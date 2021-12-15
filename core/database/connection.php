<?php
    // database name is tweety
    $dsn = 'mysql:host=localhost; dbname=test';
    $user = 'root';
    $pass = '';

    try{
        // pass above 3 
        $pdo = new PDO($dsn,$user,$pass);
    } catch (PDOException  $e) {
        echo 'connection failed' . $e->getMessage();
    }

?>