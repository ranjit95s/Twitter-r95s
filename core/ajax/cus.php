<?php 

    include '../init.php';
    $getFromU->preventAccess($_SERVER['REQUEST_METHOD'], realpath(__FILE__),realpath($_SERVER['SCRIPT_FILENAME']));

    if (isset($_POST) && !empty($_POST)){
        $status = $getFromU->checkInput($_POST['retweet']);
        $user_id = $_SESSION['user_id'];
        $tweet_id  = $_POST['tweetID'];
		$get_id    = $_POST['userID'];
        $tweetImage ='';

        if(!empty($status) or !empty($_FILES['file']['name'][0])){
            if(!empty($_FILES['filesImage']['name'][0])){
                $tweetImage = $getFromU->uploadImage($_FILES['file']);
            }

            // echo $tweetImage + 'hahahahahahhahahahahahhaha';
            // if(strlen($status)>300){
            //     $error = "tweet must be in 280 length";
            // }
            // $tweet_id = $getFromU->create('tweets',array('status' => $status,'tweetBy'=>$user_id ,'tweetOwner'=>$user_id, 'tweetImage'=> $tweetImage,'postedOn'=> date('Y-m-d H:i:s')));
            // preg_match_all("/#+([a-zA-Z0-9]+)/i",$status,$hashtag);
            // if(!empty($hashtag)){
            //     $getFromT->addTrend($status);
            // }
            $getFromT->retweet($tweet_id, $user_id, $get_id, $status,$tweetImage);
            $result['success'] = "Your Tweet has been posted";
            echo json_encode($result);
            // $getFromT->addMention($status,$user_id,$tweet_id);
        }else{	
            $error = "Type or choose image to tweet";
        }

     
    }

?>