<?php
    session_start();
    require_once 'db.php';
    require_once 'validate.php';

    if (!empty($_SESSION['auth_user']['user_id']) && !empty($_COOKIE['user_id'])) {

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

        if ($find_id_result['role'] != 'admin') {
            header('Location: /login.php');
        }

        $sql_comment = "UPDATE `comments` SET `show` = :show WHERE `id` = :id";
        $slq_comment_prepared = $pdo->prepare($sql_comment);
        $arr_comment = [
            ':show' => 0,
            ':id' => $_POST['comment_id']
        ];
        $slq_comment_prepared->execute($arr_comment);
        header('Location: /admin.php');
    } else {
        header('Location: /admin.php');
    }
?>