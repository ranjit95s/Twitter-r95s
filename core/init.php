<?php

    include 'database/connection.php';
    include 'classes/user.php';
    include 'classes/follow.php';
    include 'classes/tweet.php';
    
    global $pdo;

    session_start();

    $getFromU = new User($pdo);
    $getFromF = new Follow($pdo);
    $getFromT = new Tweet($pdo);

    define("BASE_URL" , "http://localhost/Twitter-Clone/");
?>