<?php

    include 'database/connection.php';
    include 'classes/user.php';
    include 'classes/follow.php';
    include 'classes/tweet.php';
    include 'classes/message.php';
    
    global $pdo;

    session_start();

    $getFromU = new User($pdo);
    $getFromF = new Follow($pdo);
    $getFromT = new Tweet($pdo);
    $getFromM = new Message($pdo);

    define("BASE_URL" , "http://localhost/Twitter-Clone/");
?>