<?php
    session_start();
    require_once 'db.php';
    require_once 'validate.php';

    if (isset($_POST['btn-authorization-user'])) {
        $email = security_clean_data($_POST['remember']);
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
            if (missing_email($find_email_result)) {
                if (!empty($password)) {
                    unset($_SESSION['error']['password']);
                    if (coincidence_passwords($password, $find_email_result['password'])) {
                        $_SESSION['auth_user'] = $find_email_result;
                        header('Location: /index.php');
                    } else {
                        header('Location: /login.php');
                    }
                } else {
                    $_SESSION['error']['password'] = "Вы не ввели пароль.";
                    header('Location: /login.php');
                }
            } else {
                header('Location: /login.php');
            }
        } else {
            header('Location: /login.php');
        }
    } else {
        header('Location: /login.php');
    }

echo "<pre>";
var_dump($_SESSION);
echo "</pre>";
echo "<pre>";
var_dump($_POST);
echo "</pre>";

?>