<?php
    error_reporting(E_ALL);//for windows
    ini_set('display_errors', 'on');//for linux
    //session_start();

    $driver = 'mysql';
    $host = 'localhost';
    $db_name = 'marlin-php1';
    $db_user = 'root';
    $db_pass = '';
    $charset = 'utf8';
    $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
    $dsn = "$driver:host=$host;dbname=$db_name;charset=$charset";

    try{
        $pdo = new PDO($dsn, $db_user, $db_pass, $options);
        //echo "connection successful";
    }catch(PDOException $e){
        var_dump($e);
        die("Не могу подключиться к базе данных");
    }

    $sql_query = "SELECT `name`, `comment` FROM `comments` WHERE `id`>0";
    $sql_query_prepared = $pdo->prepare($sql_query);
    $sql_query_prepared->execute();
    $array_comments = $sql_query_prepared->fetchAll(PDO::FETCH_ASSOC);
//    echo '<pre>';
//    var_dump($array_comments);
//    echo '</pre>';



?>