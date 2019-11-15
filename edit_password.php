<?php
    session_start();
    require_once 'db.php';
    require_once 'validate.php';

    if (isset($_POST['btn-password-edit'])) {

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


        if (!empty($_POST['password_current'])) {

            if (password_verify($_POST['password_current'], $find_id_result['password'])) {
                unset($_SESSION['error']['password_current']);
            } else {
                $_SESSION['error']['password_current'] = "Пароли не совпадают.";
//                header('Location: /profile.php');
            }
        } else {
            $_SESSION['error']['password_current'] = "Вы не ввели пароль.";
//            header('Location: /profile.php');
        }

        $check_password = check_one_password($_POST['password'], 'password');
        $check_password_confirmation = check_one_password($_POST['password_confirmation'], 'password_confirmation');

        if ($check_password && $check_password_confirmation) {
            //do nothing
        } else {
            header('Location: /profile.php');
        }

        if (check_password($_POST['password'], $_POST['password_confirmation'])) {
            $sql_password = "UPDATE `users` SET password = :password WHERE user_id = :user_id";
            $slq_password_prepared = $pdo->prepare($sql_password);
            $new_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $arr_password = [
                ':password' => $new_password,
                ':user_id' => $find_id_result['user_id']
            ];
            $slq_password_prepared->execute($arr_password);

            if (!empty($_SESSION['auth_user']['password'])) {
                $_SESSION['auth_user']['password'] = $new_password;
            }

            if (!empty($_COOKIE['user_password'])) {
                setcookie("user_password", '', time() - 2592000);
                setcookie("user_password", $new_password, time() + 2592000);//one month
            }

            unset($_SESSION['error']);
            $_SESSION['flash']['change_password'] = 1;
            header('Location: /profile.php');
        }
    } else {
        header('Location: /profile.php');
    }

?>