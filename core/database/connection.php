<?php
    // database name is tweety
    $dsn = 'mysql:host=localhost; dbname=tweety';
    $user = 'root';
    $pass = '';

    try{
        // pass above 3 
        $pdo = new PDO($dsn,$user,$pass);
        echo '<script>console.log("connection connected to database");</script>';
    } catch (PDOExcetion $e) {
        echo 'connection failed' . $e->getMessage();
    }

?>