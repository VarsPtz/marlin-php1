<?php
    session_start();
    require_once 'db.php';
    require_once 'validate.php';



    if (isset($_POST['btn-add-comment'])) {

        if (!empty($_SESSION['auth_user']['name'])) {
            $name = security_clean_data($_SESSION['auth_user']['name']);
            $user_id = $_SESSION['auth_user']['user_id'];
        } elseif (!empty($_COOKIE['user_email'])) {
            $email = $_COOKIE['user_email'];
            $password = $_COOKIE['user_pwd'];

            //Prepare data to find email in data base.
            $sql_email_in_db = "SELECT * FROM `users` WHERE email = :email";
            $sql_email_in_db_prepared = $pdo->prepare($sql_email_in_db);
            $find_email = [':email' => $email];
            $sql_email_in_db_prepared->execute($find_email);
            $find_email_result = $sql_email_in_db_prepared->fetch();

            if ($email == $find_email_result['email'] && $password == $find_email_result['password']) {
                $name = $find_email_result['name'];
                $user_id = $find_email_result['user_id'];
                $_SESSION['auth_user'] = $find_email_result;
            }
        } else {
            $name = false;
        }

        $comment = security_clean_data($_POST['text']);

        //Data for new comment in mysql
        $data_comment = [
            'user_id' => $user_id,
            'comment' => $comment,
            'date' => date('Y-m-d')
        ];

        //Check incoming data for errors. If no errors, add new comment in to the data base.
        $result_comment = check_comment($comment);

        if ($result_comment && $name != false) {
            $sql = "INSERT INTO comments (user_id, comment, date) VALUES (:user_id, :comment, :date)";
            $statement = $pdo->prepare($sql);
            $statement->execute($data_comment);
            unset($_SESSION['error']);
            $_SESSION['flash']['add_comment'] = 1;
            header('Location: /index.php');
        } else {
            header('Location: /index.php');
        }
    } else {
        header('Location: /index.php');
    }

?>