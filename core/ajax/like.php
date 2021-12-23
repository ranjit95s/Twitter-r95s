<?php

        include '../init.php'; 
        $getFromU->preventAccess($_SERVER['REQUEST_METHOD'], realpath(__FILE__),realpath($_SERVER['SCRIPT_FILENAME']));

        if(isset($_POST['like']) && !empty($_POST['like'])){
            $user_id  = $_SESSION['user_id'];
            $tweet_id = $_POST['like'];
            $get_id   = $_POST['user_id'];
            $getFromT->addLike($user_id, $tweet_id, $get_id);
            $getFromT->fetchLikes($tweet_id);

        }
        
        if(isset($_POST['tweet_id']) && !empty($_POST['tweet_id'])){
            $tweet_id = $_POST['tweet_id'];
            $getFromT->fetchLikes($tweet_id);
        }

        if(isset($_POST['unlike']) && !empty($_POST['unlike'])){
            $user_id  = $_SESSION['user_id'];
            $tweet_id = $_POST['unlike'];
            $get_id   = $_POST['user_id'];
            $getFromT->unLike($user_id, $tweet_id, $get_id);
        }

        if(isset($_POST['bookmark']) && !empty($_POST['bookmark'])){
            $user_id  = $_SESSION['user_id'];
            $tweet_id = $_POST['bookmark'];
            $get_id = $_POST['userID'];
            $getFromT->bookmarkTweet($user_id,$tweet_id,$get_id);
        }

     
        
        ?>