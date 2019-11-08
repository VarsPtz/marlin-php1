<?php
    session_start();
    session_unset();
    session_destroy();
    setcookie("user_email", '', time() - 2592000);
    setcookie("user_pwd", '', time() - 2592000);
    setcookie("user_name", '', time() - 2592000);
    header('Location: /login.php');
?>