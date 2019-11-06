<?php
    session_start();
    require_once 'db.php';
    require_once 'validate.php';

    if (isset($_POST['btn-add-user'])) {

        $name = security_clean_data($_POST['name']);
        $email = security_clean_data($_POST['email']);
        $password = $_POST['password'];
        $password_confirmation = $_POST['password_confirmation'];

        //Prepare data to find email in data base.
        $sql_email_in_db = "SELECT `email` FROM `users` WHERE email = :email";
        $sql_email_in_db_prepared = $pdo->prepare($sql_email_in_db);
        $find_email = [':email' => $email];
        $sql_email_in_db_prepared->execute($find_email);
        $find_email_result = $sql_email_in_db_prepared->fetch();


        //Check incoming data for errors. If no errors, add new user in to the data base.

        $result_name = check_name($name);
        $result_email = check_email($email);
        $find_email = find_email($find_email_result);
        $result_password = check_password($password, $password_confirmation);

        if ($result_name && $result_email && $find_email && $result_password) {

            //Data for new comment in mysql
            $data_user = [
                'name' => $name,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT)
            ];

            $sql_add_user = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
            $statement_add_user = $pdo->prepare($sql_add_user);
            $statement_add_user->execute($data_user);
            unset($_SESSION['error']);
            unset($_SESSION['email']);
            unset($_SESSION['password']);
            //$_SESSION['flash']['add_comment'] = 1;
            header('Location: /register.php');
        } else {
            header('Location: /register.php');
        }
    } else {
        header('Location: /register.php');
    }

?>


