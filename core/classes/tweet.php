<?php 

    class Tweet extends User {

        function __construct($pdo){
            $this->pdo = $pdo; 
        }

        public function tweets($user_id){
            $stmt = $this->pdo->prepare("SELECT * FROM `tweets` LEFT JOIN `users` ON `tweetBy` = `user_id` WHERE `tweetBy` = :user_id AND `retweetID` = '0' OR `tweetBy` = `user_id` AND `retweetBy` != :user_id ");
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $stmt->execute();
            $tweets = $stmt->fetchAll(PDO::FETCH_OBJ);
    
            foreach($tweets as $tweet){
                $likes = $this->likes($user_id, $tweet->tweetID);
                $retweet = $this->checkRetweet($tweet->tweetID, $user_id);
                $user = $this->userData($tweet->retweetBy);
                
                echo '<div class="all-tweet">
                        <div class="t-show-wrap">	
                            <div class="t-show-inner">
                                '.((empty($tweet->retweetMsg) && $tweet->tweetID === (isset($retweet['tweetID'])) || $tweet->retweetID > 0) ? '
                                <div class="t-show-head">
                                <div class="t-show-banner">
                                    <div class="t-show-banner-inner">
                                        <span><i class="fa fa-share" aria-hidden="true"></i></span><span>'.(( $tweet->retweetBy === $user_id ) ? 'You' : $user->screenName ).' Retweeted'.((!empty(($tweet->retweetMsg))) ? ' with comment' : '').' </span>
                                    </div>
                                </div>
                                <div class="t-show-img">
                                    <img src="'.$user->profileImage.'"/>
                                </div>
                                    <div class="t-s-head-content">
                                    
                                        <div class="t-h-c-name">
                                            <span><a href="'.BASE_URL.$user->username.'">'.$user->screenName.'</a></span>
                                            <span>@'.$user->username.'</span>
                                            <span>'.($tweet->postedOn).'</span>
                                        </div>
                                        <div class="t-h-c-dis">
                                            '.($tweet->retweetMsg).'
                                        </div>
                                    </div>
                                </div>
                                <div class="t-s-b-inner">
                                    <div class="t-s-b-inner-in">
                                        <div class="retweet-t-s-b-inner">
                                            <div class="retweet-t-s-b-inner-left">	
                                            </div>
                                            <div class="t-show-img">
                                            <img src="'.$tweet->profileImage.'"/>
                                        </div>
                                                <div class="t-h-c-name">
                                                    <span><a href="'.BASE_URL.$tweet->username.'"></a>'.$tweet->screenName.'</span>
                                                    <span>@'.$tweet->username.'</span>
                                                    <span>'.($tweet->postedOn).'</span>
                                                </div>
                                                <div class="retweet-t-s-b-inner-right-text">		
                                                    '.($tweet->status).'
                                                    
                                                </div>'.
                                                (!empty($tweet->tweetImage) ? 
                                            ' <!--tweet show head end-->
                                                <div class="t-show-body">
                                                <div class="t-s-b-inner">
                                                <div class="t-s-b-inner-in">
                                                    <img src="'.$tweet->tweetImage.'" class="imagePopup"/>
                                                </div>
                                                </div>
                                                </div>
                                                <!--tweet show body end-->
                                                ' : '' ).'
                                                
                                        </div>
                                    </div>
                                </div>' : '
                                <div class="t-show-popup" data-tweet = "'.$tweet->tweetID.'">
                                    <div class="t-show-head">
                                    <div class="t-show-img">
                                    <img src="'.$tweet->profileImage.'"/>
                                </div>
                                        <div class="t-s-head-content">
                                            <div class="t-h-c-name">
                                                <span><a href="'.$tweet->username.'">'.$tweet->screenName.'</a></span>
                                                <span>'.$tweet->username.'</span>
                                                <span>'.$tweet->postedOn.'</span>
                                            </div>
                                            <div class="t-h-c-dis tweet-padd">
                                            '.$this->getTweetLinks($tweet->status).'
                                            </div>
                                        </div>
                                    </div>'.
                                    (!empty($tweet->tweetImage) ? 
                                ' <!--tweet show head end-->
                                    <div class="t-show-body">
                                    <div class="t-s-b-inner">
                                    <div class="t-s-b-inner-in">
                                        <img src="'.$tweet->tweetImage.'" class="imagePopup"/>
                                    </div>
                                    </div>
                                    </div>
                                    <!--tweet show body end-->
                                    ' : '' ).'

                                    </div>').'
                            <div class="t-show-footer">
                                <div class="t-s-f-right">
                                    <ul> 
                                        <li><button><a href="#"><i class="fa fa-share" aria-hidden="true"></i></a></button></li>	
    
                                            <li>'.((isset($retweet['retweetID']) ? $tweet->tweetID === $retweet['retweetID'] : '') ? 
                                                '<button class="retweeted" data-tweet="'.$tweet->tweetID.'" data-user="'.$tweet->tweetBy.'"><i class="fa fa-retweet" aria-hidden="true"></i><span class="retweetsCount">'.(($tweet->retweetCount > 0) ? $tweet->retweetCount : '').'</span></button>' : 
                                                '<button class="retweet" data-tweet="'.$tweet->tweetID.'" data-user="'.$tweet->tweetBy.'"><i class="fa fa-retweet" aria-hidden="true"></i><span class="retweetsCount">'.(($tweet->retweetCount > 0) ? $tweet->retweetCount : '').'</span></button>').'
                                        </li>
        
                                            <li>'.((isset($likes['likeOn']) ? $likes['likeOn'] === $tweet->tweetID : '') ? 
                                                '<button class="unlike-btn" data-tweet="'.$tweet->tweetID.'" data-user="'.$tweet->tweetBy.'"><i class="fa fa-heart" aria-hidden="true"></i><span class="likesCounter">'.(($tweet->likesCount > 0) ? $tweet->likesCount : '' ).'</span></button>' : 
                                                '<button class="like-btn" data-tweet="'.$tweet->tweetID.'" data-user="'.$tweet->tweetBy.'"><i class="fa fa-heart-o" aria-hidden="true"></i><span class="likesCounter">'.(($tweet->likesCount > 0) ? $tweet->likesCount : '' ).'</span></button>').'
                                            </li>
        
                                                <li>
                                                <a href="#" class="more"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
                                                <ul> 
                                                <li><label class="deleteTweet">Delete Tweet</label></li>
                                                </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>';
            }

        }

        public function getTrendByHash($hashtag){
            $stmt = $this->pdo->prepare("SELECT * FROM `trends` WHERE `hashtag` LIKE :hashtag LIMIT 5");
            $stmt->bindValue(':hashtag',$hashtag.'%');
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
    
        }
        public function getMention($mention){
            $stmt = $this->pdo->prepare("SELECT `user_id`,`username`,`profileImage`,`screenName` FROM `users` WHERE `username` LIKE :mention OR `screenName` LIKE :mention LIMIT 5");
            $stmt->bindValue(':mention',$mention.'%');
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
            
        }
        public function addTrend($hashtag){
            preg_match_all("/#+([a-zA-Z0-9]+)/i",$hashtag,$matches);
            if($matches){
                $res = array_values($matches[1]);
            }

            $sql = "INSERT INTO `trends` (`hashtag`,`createdOn`) VALUES (:hashtag, CURRENT_TIMESTAMP)";
            
            foreach($res as $trend){
                if($stmt = $this->pdo->prepare($sql)){
                    $stmt->execute(array(':hashtag'=>$trend));
                
                }
            }
        }
        public function getTweetLinks($tweet){
            $tweet = preg_replace("/(https?:\/\/)([\w]+.)([\w\.]+)/","<a href='$0' target='_blink'>$0</a>",$tweet);
            $tweet = preg_replace("/#([\w]+)/","<a href='".BASE_URL."hashtag/$1'>$0</a>",$tweet);
            $tweet = preg_replace("/@([\w]+)/","<a href='".BASE_URL."$1/'>$0</a>",$tweet);
            return $tweet;
        }
        public function getPopupTweet($tweet_id){
            $stmt = $this->pdo->prepare("SELECT * FROM `tweets`,`users` WHERE `tweetID` = :tweet_id AND `tweetBy` = `user_id`");
            $stmt->bindParam(":tweet_id",$tweet_id,PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        }

        public function comments($tweet_id){
            $stmt = $this->pdo->prepare("SELECT * FROM `comments` LEFT JOIN `users` ON `commentBy` = `user_id` WHERE `commentOn` = :tweet_id");
            $stmt->bindParam(":tweet_id",$tweet_id,PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function retweet($tweet_id, $user_id, $get_id, $comment){
            $stmt = $this->pdo->prepare("UPDATE `tweets` SET `retweetCount` = `retweetCount`+1 WHERE `tweetID` = :tweet_id AND `tweetBy` = :get_id");
            $stmt->bindParam(":tweet_id", $tweet_id, PDO::PARAM_INT);
            $stmt->bindParam(":get_id", $get_id, PDO::PARAM_INT);
            $stmt->execute();
    
            $stmt = $this->pdo->prepare("INSERT INTO `tweets` (`status`,`tweetBy`,`retweetID`,`retweetBy`,`tweetImage`,`postedOn`,`likesCount` ,`retweetCount` ,`retweetMsg`) SELECT `status`,`tweetBy`,`tweetID`,:user_id,`tweetImage`,`postedOn`,`likesCount`,`retweetCount`, :retweetMsg FROM `tweets` WHERE `tweetID` = :tweet_id");
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $stmt->bindParam(":retweetMsg", $comment, PDO::PARAM_STR);
            $stmt->bindParam(":tweet_id", $tweet_id, PDO::PARAM_INT);
            $stmt->execute();
        }

        public function checkRetweet($tweet_id,$user_id){
            $stmt = $this->pdo->prepare("SELECT * FROM `tweets` WHERE `retweetID` = :tweet_id AND `retweetBy` = :user_id or `tweetID` = :tweet_id AND `retweetBy`=:user_id");
            $stmt->bindParam(":tweet_id", $tweet_id, PDO::PARAM_INT);
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function addLike($user_id, $tweet_id, $get_id){
            $stmt = $this->pdo->prepare("UPDATE `tweets` SET `likesCount` = `likesCount`+1 WHERE `tweetID` = :tweet_id");
            $stmt->bindParam(":tweet_id", $tweet_id, PDO::PARAM_INT);
            $stmt->execute();
    
            $this->create('likes', array('likeBy' => $user_id, 'likeOn' => $tweet_id));
        }
        public function likes($user_id, $tweet_id){
            $stmt = $this->pdo->prepare("SELECT * FROM `likes` WHERE `likeBy` = :user_id AND `likeOn` = :tweet_id");
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $stmt->bindParam(":tweet_id", $tweet_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        public function unLike($user_id, $tweet_id, $get_id){
            $stmt = $this->pdo->prepare("UPDATE `tweets` SET `likesCount` = `likesCount` -1 WHERE `tweetID` = :tweet_id");
            $stmt->bindParam(":tweet_id", $tweet_id, PDO::PARAM_INT);
            $stmt->execute();
    
            $stmt = $this->pdo->prepare("DELETE FROM `likes` WHERE `likeBy` = :user_id AND `likeOn` = :tweet_id");
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $stmt->bindParam(":tweet_id", $tweet_id, PDO::PARAM_INT);
            $stmt->execute();  
            
        }

    }

?>