<?php
    session_start();
    require_once 'db.php';
    require_once 'validate.php';

    function security_clean_data($data) {
        $data = trim($data);
        $data = htmlspecialchars($data);
        return $data;
    }

//    function check_not_empty($data) {
////        if (empty($data)) {
////            return "Пустая строка";
////        } else {
////            return false;
////        }
////    }
////
////    function check_characters($data) {
////        if (preg_match('/^[a-zA-Zа-яА-ЯёЁ]++$/u', $data)) {
////            return "Можно использовать только буквы";
////        } else {
////            return false;
////        }
////    }

    function check_name($name) {
        //$check_name_empty = check_not_empty($name);
        //$check_name_characters = check_characters($name);

        if (check_empty($name)) {
            $_SESSION['error']['name'] = "Вы не ввели имя пользователя";
            return false;
        } elseif (check_characters($name)) {
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
        if (check_empty($comment)) {
            $_SESSION['error']['comment'] = "Вы ничего не написали в комментарии.";
            return false;
        } else {
            if (isset($_SESSION['error']['comment'])) {
                unset($_SESSION['error']['comment']);
            }
            return true;
        }
    }



    if (isset($_POST['btn-add-comment'])) {

        $name = security_clean_data($_POST['name']);
        $comment = security_clean_data($_POST['text']);

        //Data for new comment in mysql
        $data_comment = [
            'name' => $name,
            'comment' => $comment,
            'date' => date('Y-m-d')
        ];

        //Check incoming data for errors. If no errors, add new comment in to the data base.
        $result_name = check_name($name);
        $result_comment = check_comment($comment);
        if ($result_name && $result_comment) {
            $sql = "INSERT INTO comments (name, comment, date) VALUES (:name, :comment, :date)";
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