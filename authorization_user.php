<?php
    session_start();
    require_once 'db.php';
    require_once 'validate.php';

    if (isset($_POST['btn-authorization-user'])) {
        $email = security_clean_data($_POST['email']);
        $password = $_POST['password'];

        //Prepare data to find email in data base.
        $sql_email_in_db = "SELECT * FROM `users` WHERE email = :email";
        $sql_email_in_db_prepared = $pdo->prepare($sql_email_in_db);
        $find_email = [':email' => $email];
        $sql_email_in_db_prepared->execute($find_email);
        $find_email_result = $sql_email_in_db_prepared->fetch();
        //var_dump($find_email_result['password']);

        //Check incoming data for errors. If no errors, add new user in to the data base.

        //$result_email = check_email($email);

        if (check_email($email)) {
           $error_status = false;
        } else {
            header('Location: /login.php');
        }

        if (missing_email($find_email_result)) {
            $error_status = false;
        } else {
            header('Location: /login.php');
        }

        if (!empty($password)) {
            unset($_SESSION['error']['password']);
            $error_status = false;
        } else {
            $_SESSION['error']['password'] = "Вы не ввели пароль.";
            header('Location: /login.php');
        }

        if (coincidence_passwords($password, $find_email_result['password'])) {
            $_SESSION['auth_user'] = $find_email_result;
            if (isset($_POST['remember'])) {
                if ($_POST['remember'] == 1) {
                    setcookie("user_email", $email, time() + 2592000);//one month
                    setcookie("user_pwd", $find_email_result['password'], time() + 2592000);//one month
                    setcookie("user_name", $find_email_result['name'], time() + 2592000);//one month
                    setcookie("user_image", $find_email_result['image'], time() + 2592000);//one month
                    setcookie("user_id", $find_email_result['user_id'], time() + 2592000);//one month
                }
            } else {
                setcookie("user_email", '', time() - 2592000);
                setcookie("user_pwd", '', time() - 2592000);
                setcookie("user_name", '', time() - 2592000);
                setcookie("user_image", '', time() - 2592000);
                setcookie("user_id", '', time() - 2592000);
            }
            header('Location: /index.php');
        } else {
            header('Location: /login.php');
        }



    } else {
        header('Location: /login.php');
    }

echo "<pre>";
var_dump($_SESSION);
echo "</pre>";
echo "POST<br>";
echo "<pre>";
var_dump($_POST);
echo "</pre>";
echo "COOKIE<br>";
echo "<pre>";
var_dump($_COOKIE);
echo "</pre>";



?>