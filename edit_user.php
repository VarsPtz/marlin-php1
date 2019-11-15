<?php
    session_start();
    require_once 'db.php';
    require_once 'validate.php';

    if (isset($_POST['btn-user-edit'])) {
        $name_new = security_clean_data($_POST['name']);
        $email_new = security_clean_data($_POST['email']);
        $file_image_new = $_FILES['image'];

        if (!empty($_SESSION['auth_user']['user_id'])) {
            $user_id = $_SESSION['auth_user']['user_id'];
        } elseif (!empty($_COOKIE['user_id'])) {
            $user_id = $_COOKIE['user_id'];
        }

        //Prepare data to find id in data base.
        $sql_id_in_db = "SELECT * FROM `users` WHERE user_id = :user_id";
        $sql_id_in_db_prepared = $pdo->prepare($sql_id_in_db);
        $find_id = [':user_id' => $user_id];
        $sql_id_in_db_prepared->execute($find_id);
        $find_id_result = $sql_id_in_db_prepared->fetch();

        //Prepare data to find email in data base.
        $sql_email_in_db = "SELECT `email` FROM `users` WHERE email = :email";
        $sql_email_in_db_prepared = $pdo->prepare($sql_email_in_db);
        $find_email = [':email' => $email_new];
        $sql_email_in_db_prepared->execute($find_email);
        $find_email_result = $sql_email_in_db_prepared->fetch();


        //Check incoming data for errors. If no errors, add new user in to the data base.

        $result_name = check_name($name_new);
        $result_email = check_email($email_new);

        if (!$result_name || !$result_email) {
            header('Location: /profile.php');
        }

        if ($email_new != $find_id_result['email']) {
            if (find_email($find_email_result)) {
                //email is unique
            } else {
                header('Location: /profile.php');
            }
        } else {
            //user don't change name
        }


        //Upload image file
        if (!empty($file_image_new['name'])) {
            $tmp_arr = explode('.',  $file_image_new['name']);

            $error_image_type = checking_for_image_type($tmp_arr[1]);
            $error_image_size = checking_file_size($file_image_new['size']);

            if ($error_image_type && $error_image_size) {
                //do nothing, next step
            } else {
                header('Location: /profile.php');
            }

            if ($file_image_new['name'] != 'no-user.jpg') {

                $new_image_name = uniqid().'.'.$tmp_arr[1];
                move_uploaded_file($file_image_new['tmp_name'], 'img/'.$new_image_name);
                $sql_image = "UPDATE `users` SET image = :image WHERE user_id = :user_id";
                $slq_image_prepared = $pdo->prepare($sql_image);
                $arr_image = [
                    ':image' => $new_image_name,
                    ':user_id' => $find_id_result['user_id']
                ];
                $slq_image_prepared->execute($arr_image);

                if (!empty($_SESSION['auth_user']['image'])) {
                    $_SESSION['auth_user']['image'] = $new_image_name;
                }

                if (!empty($_COOKIE['user_image'])) {
                    setcookie("user_image", '', time() - 2592000);
                    setcookie("user_image", $name_new, time() + 2592000);//one month
                }
            }
        }

        //Save new name
        if ($name_new != $find_id_result['user_id']) {
            $sql_name = "UPDATE `users` SET name = :name WHERE user_id = :user_id";
            $sql_name_in_db_prepared = $pdo->prepare($sql_name);
            $arr_name = [
                ':name' => $name_new,
                ':user_id' => $find_id_result['user_id']
            ];
            $sql_name_in_db_prepared->execute($arr_name);

            if (!empty($_SESSION['auth_user']['name'])) {
                $_SESSION['auth_user']['name'] = $name_new;
            }

            if (!empty($_COOKIE['user_name'])) {
                setcookie("user_name", '', time() - 2592000);
                setcookie("user_name", $name_new, time() + 2592000);//one month
            }
        }

        //Save new email
        if ($email_new != $find_id_result['email']) {
            $sql_email = "UPDATE `users` SET email = :email WHERE user_id = :user_id";
            $sql_email_prepared = $pdo->prepare($sql_email);
            $arr_email = [
                ':email' => $email_new,
                ':user_id' => $find_id_result['user_id']
            ];
            $sql_email_prepared->execute($arr_email);

            if (!empty($_SESSION['auth_user']['email'])) {
                $_SESSION['auth_user']['email'] = $email_new;
            }

            if (!empty($_COOKIE['user_email'])) {
                setcookie("user_email", '', time() - 2592000);
                setcookie("user_email", $name_new, time() + 2592000);//one month
            }

            unset($_SESSION['error']);
            $_SESSION['flash']['change_user'] = 1;
            header('Location: /profile.php');
        }
    } else {
        header('Location: /profile.php');
    }

//    echo "<pre>";
//    var_dump($_SESSION);
//    echo "</pre>";
//    echo "<pre>";
//    var_dump($_COOKIE);
//    echo "</pre>";
//    echo "<pre>";
//    var_dump($_FILES);
//    echo "</pre>";
?>