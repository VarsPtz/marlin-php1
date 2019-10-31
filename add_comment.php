<?php
    session_start();
    require_once 'db.php';

    function security_clean_data($data) {
        $data = trim($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function check_name($name) {
        if ($name == "" ) {
            $_SESSION['error']['name'] = "Вы не ввели имя пользователя";
            return false;
        } elseif (preg_match('/^[a-zA-Zа-яА-ЯёЁ]++$/u', $name ) === 0) {
            $_SESSION['error']['name'] = "Для имени пользователя можно использовать только буквы";
            return false;
        } else {
           if (isset($_SESSION['error']['name'])) {
               unset($_SESSION['error']['name']);
           }
           return true;
        }
    }

    function check_comment($comment) {
        if (!empty($comment)) {
            if (isset($_SESSION['error']['comment'])) {
                unset($_SESSION['error']['comment']);
            }
            return true;
        } else {
            $_SESSION['error']['comment'] = "Вы ничего не написали в комментарии.";
            return false;
        }
    }



    if (isset($_POST['btn-add-comment'])) {

        $name = security_clean_data($_POST['name']);
        $comment = security_clean_data($_POST['text']);

        //Data for new comment in mysql
        $data_comment = [
            'name' => $name,
            'comment' => $comment
        ];

        //Check incoming data for errors. If no errors, add new comment in to the data base.
        $result_name = check_name($name);
        $result_comment = check_comment($comment);
        if ($result_name && $result_comment) {
            $sql = "INSERT INTO comments (name, comment) VALUES (:name, :comment)";
            $statement = $pdo->prepare($sql);
            $statement->execute($data_comment);
            unset($_SESSION['error']);
            header('Location: /index.php');
        } else {
            header('Location: /index.php');
        }
    } else {
        header('Location: /index.php');
    }


?>