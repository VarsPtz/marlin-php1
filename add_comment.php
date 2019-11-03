<?php
    session_start();
    require_once 'db.php';
    require_once 'validate.php';



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