<?php 

    class Tweet extends User {

        function __construct($pdo){
            $this->pdo = $pdo; 
            $this->message  = new Message($this->pdo);
        }

        public function tweets($user_id,$num){

            

            // select * from ( select t.* from tweets as t where tweetOwner = 7 union select t.* from tweets as t where t.tweetID in (select retweet_tweetID from retweet where retweet_userIDBy = 7) union select t.* from tweets as t where t.tweetOwner in (select receiver from follow where sender = 7)) a order by postedOn desc;

            // UPDATED Q -               select * from ( select t.* from tweets as t where tweetOwner = 7 union select t.* from tweets as t where t.tweetOwner in (select retweet_userID from retweet where retweet_userIDBy = 7) union select t.* from tweets as t where t.tweetOwner in (select retweet_userID from retweet where retweet_userIDBy = (select receiver from follow where sender = 7)) union select t.* from tweets as t where t.tweetOwner in (select receiver from follow where sender = 7)) a order by postedOn desc;

            // LATEST UPDATED Q - select * from ( select t.* from tweets as t where tweetOwner = 1 union select t.* from tweets as t where t.tweetOwner in (select retweet_userID from retweet where retweet_userIDBy =1) union select t.* from tweets as t where t.tweetOwner in (select retweet_userID from retweet as vt where vt.retweet_userID != 1 and retweet_userIDBy = (select receiver from follow where sender = 1 and receiver != vt.retweet_userID)) union select t.* from tweets as t where t.tweetOwner in (select receiver from follow where sender = 1)) a order by postedOn desc;

            // NEW LATEST UPDATED Q - SELECT * FROM (SELECT t.* FROM `tweets` AS t WHERE `tweetOwner` = 1
               
            //    UNION SELECT t.* FROM `tweets` AS t WHERE t.`tweetID` IN (SELECT `retweet_tweetID` FROM `retweet` as rt WHERE rt.`retweet_userIDBy` = 1 ) 
               
            //    UNION SELECT t.* from `tweets` as t where t.`tweetID` IN (SELECT `retweet_tweetID` FROM `retweet` as rt WHERE rt.`retweet_userIDBy` IS NOT NULL OR rt.`retweet_userIDBy` = (SELECT `receiver` FROM `follow` WHERE `sender` = 1)) 
            
            //    UNION SELECT t.* FROM `tweets` AS t WHERE t.`tweetOwner` IN (SELECT `receiver` FROM `follow` WHERE `sender` = 1)) A ORDER BY `tweetID` DESC



            $stmt = $this->pdo->prepare("SELECT * FROM (SELECT t.* FROM `tweets` AS t WHERE `tweetOwner` = :user_id 
                                            UNION SELECT t.* FROM `tweets` AS t WHERE t.`tweetID` IN (SELECT `retweet_tweetID` FROM `retweet` AS rt WHERE rt.`retweet_userIDBy` =:user_id) 
                                            UNION SELECT t.* from `tweets` as t where t.`tweetID` IN (SELECT `retweet_tweetID` FROM `retweet` as rt WHERE rt.`retweet_userIDBy` IS NOT NULL OR rt.`retweet_userIDBy` = (SELECT `receiver` FROM `follow` WHERE `sender` =:user_id)) 
                                            UNION SELECT t.* FROM `tweets` AS t WHERE t.`tweetOwner` IN (SELECT `receiver` FROM `follow` WHERE `sender` = :user_id)) A ORDER BY `tweetID` DESC");
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);                                                                                                                         
            $stmt->bindParam(":num", $num, PDO::PARAM_INT);
            $stmt->execute();
            $tweets = $stmt->fetchAll(PDO::FETCH_OBJ);
    
            foreach($tweets as $tweet){
                $likes = $this->likes($user_id, $tweet->tweetID);
                $retweet = $this->checkRetweet($tweet->tweetID, $user_id);
                $user = $this->userData($tweet->tweetOwner);

                $retweets = $this->checkRetweeTUser($tweet->tweetID);

							
							$us = 'Undefined';
							$su = 'Undefined';
							foreach($retweets as $product){
								$userTr = $this->userData($product->retweet_userIDBy);
								$us = $product->retweet_tweetID;
                                $su = $product->retweet_userIDBy;
							}
                
                $userRefS = $this->getUserTweetsByID($tweet->tweetRef,$tweet->tweetRefTo);
                $userOwnerTweet = $this->getUserTweetsOwnerByID($tweet->tweetID , $tweet->tweetOwner);
                $userRefD = $this->userData($tweet->tweetRefTo);
        
                echo '
                <div class="all-tweet" data-tweet="'.$tweet->tweetID.'" data-user="'.$user->username.'">
                <div class="container">
                
                <div class="tweet-outer">
                    <div class="tweet-inner">
                    '.((($us != 'Undefined' && $tweet->tweetID == $us) && $tweet->tweetOwner != $user_id) ? '<div class="retweet-has">
                    <div class="retweet-info">
                        <i class="fa fa-retweet"></i>
                        <span> <a style="color: var( --secondary-text-color); font-weight: 700; text-decoration:none;" href="'.BASE_URL.$userTr->username.'"> '.(( $su != 'Undefined' && $user_id === $su ) ? 'You' : $userTr->screenName ).' Retweeted </a> </span>
                    </div>
                </div>' : '' ).'
        
                        <!-- flex-out S -->
                        <div class="flex-out">
                            <div class="img-user">
                                <div class="img-inner">
                                <a href="'.BASE_URL.$user->username.'">
                                <img src="'.$user->profileImage.'"/>
                                </a>
                                </div>
                            </div>
        
        
                            <!-- sc-ur-status S -->
                            <div class="sc-ur-status">
                                <div class="header">
                                    
                                '.(($tweet->tweetOwner === $user_id) ? '
                                    
                                    <div class="delete-op" data-tweet="'.$tweet->tweetID.'" > <i class="fa fa-ellipsis-v ellipsiss" tabindex="1"></i> 
                                    <div class="d-t-b-u" id="d-t-b-u'.$tweet->tweetID.'">
                                    <div class="prop">
                                   <label class="deleteTweet" data-tweet="'.$tweet->tweetID.'" data-re="'.$tweet->tweetRef.'" data-ret="'.$tweet->tweetRefTo.'"> <span>Delete Tweet</span>  </label>
                                   <i class="fa fa-close closes closes'.$tweet->tweetID.'"></i>
                                    </div>
                                    </div>
                                    </div>
                                    ' : '').'
                                    
                                    <div class="text-warpper" style="margin: 0;
                                    display: flex;
                                    margin-right: 5px;
                                    flex-direction: row;
                                    line-height: 15px;
                                    
                                    overflow: hidden;
                                    min-width: 5vw;
                                    white-space: nowrap;
                                    text-overflow: ellipsis;
                                    max-width: 30vw;
                                    ">
                                    <div class="useru">
                                        <h4> <a style="color: var( --primary-text-color); font-weight: 800; text-decoration:none;" href="'.BASE_URL.$user->username.'">'.$user->screenName.'</a></h4>
                                    </div>
                                    <div class="useru">
                                        <h4 style="color: var( --secondary-text-color); font-weight: 500;">  <a style="color: var( --secondary-text-color); font-weight: 500; text-decoration:none;" href="'.BASE_URL.$user->username.'">@'.$user->username.'</a> </h4>
                                    </div>
                                    </div>
                                    <div class="useru">
                                        <h4 style="color: var( --secondary-text-color); font-weight: 500;"> • '.$this->timeAgo(($userOwnerTweet[0]->postedOn)).'</h4>
                                    </div>
                                </div>
                                <div class="status">
                                    <div class="s-in">
                                        <div class="sto">
                                        '.$this->getTweetLinks($userOwnerTweet[0]->status).'
                                        </div>
                                    </div>
                                </div>

                                '.(!empty($userOwnerTweet[0]->tweetImage) ? 
                                '<!--tweet show head end-->
                                <div class="imageContainer">
                                <div class="imageProposal">
                                    <div class="imageContains">
                                        <img src="'.BASE_URL.$userOwnerTweet[0]->tweetImage.'" class="imagePopup" data-tweet="'.$userOwnerTweet[0]->tweetID.'" alt="">
                                    </div>
                                </div>
                            </div>
                                    <!--tweet show body end-->
                                    ' : '' ).'

                                    '.( $tweet->tweetRef > 0 && (!empty($tweet->tweetRef))?'


                            '.($tweet->tweetRef > 0 && $this->checkTweetExistence($tweet->tweetRef) ? '
                                <div class="refenceTweet" data-tweet="'.$tweet->tweetRef.'" data-user="'.$userRefD->username.'">
                                

                                    <div class="ref-o">
        
                                        <div class="ref-flex">
        
                                            <div class="headerU">
                                                <div class="flex-ref-head">
                                                    <div class="imageU">
                                                    <a href="'.BASE_URL.$userRefD->username.'">
                                                    <img src="'.$userRefD->profileImage.'"/>
                                                    </a>
                                                    </div>
                                                    <div class="text-warpper" style="margin: 0;
                                    display: flex;
                                    margin-right: 5px;
                                    flex-direction: row;
                                    line-height: 15px;
                                    
                                    overflow: hidden;
                                    min-width: 5vw;
                                    white-space: nowrap;
                                    text-overflow: ellipsis;
                                    max-width: 30vw;
                                    ">
                                                    <div class="userd">
                                                        <h4 style="color: var( --primary-text-color); font-weight: 800;">'.$userRefD->screenName.'</h4>
                                                    </div>
                                                    <div class="userd">
                                                        <h4 style="color: var( --secondary-text-color); font-weight: 500;">@'.$userRefD->username.'</h4>
                                                    </div>
                                                    </div>
                                                    <div class="userd">
                                                        <h4 style="color: var( --secondary-text-color); font-weight: 500;"> • '.$this->timeAgo(($userRefS[0]->postedOn)).'</h4>
                                                    </div>
                                                </div>
                                                <div class="ref-status">
                                                    <h6>'.$this->getTweetLinks($userRefS[0]->status).'</h6>
                                                    </div>
                                                    
                                            </div>
                                        </div>
                                    </div>
                                    '.(!empty($userRefS[0]->tweetImage) ? 
                                '<!--tweet show head end-->
                                <div class="status-image imagePopup">
                                        <img src="'.$userRefS[0]->tweetImage.'" class="imagePopup" data-tweet="'.$userRefS[0]->tweetID.'" alt="">
                                    </div>
                                    <!--tweet show body end-->
                                    ' : '' ).'
                                
                                    
                                </div>
                                ' : '<div class="deletedTweetExi"> <div class="inner-info-deleted"> This Tweet is unavailable. </div> </div>' ).'
                                ' : '' ).'
        
                                <!-- bottom S -->
                                <div class="bottom">
                                    <div class="icons-head">
                                        <div class="flex-icons">
                                            <ul>
                                            '.(($this->loggedIn() ===true) ? '
                                                <li> <i class="fa fa-comment"></i> <span> '.$this->countComments($tweet->tweetID).' </span> </li>
                                                <li> '.((isset($retweet['retweet_tweetID']) ? $tweet->tweetID === $retweet['retweet_tweetID'] OR $user_id == $retweet['retweet_userIDBy'] : '') ? 
                                                '<button id="retweet-options'.$tweet->tweetID.'" class="retweeted retweet-options"  data-tweet="'.$tweet->tweetID.'" data-user="'.$tweet->tweetOwner.'"><i class="fa fa-retweet" aria-hidden="true"></i><span class="retweetsCount">'.(($tweet->retweetCount > 0) ? $tweet->retweetCount : '').'</span></button>' : 
                                                '<button class="retweet-options" id="retweet-options'.$tweet->tweetID.'"  data-tweet="'.$tweet->tweetID.'" data-user="'.$tweet->tweetOwner.'"><i class="fa fa-retweet" aria-hidden="true"></i><span class="retweetsCount">'.(($tweet->retweetCount > 0) ? $tweet->retweetCount : '').'</span></button>').'
                                                <div class="op" id="op'.$tweet->tweetID.'">
												<ul> 
                                                '.((isset($retweet['retweet_tweetID']) ? $tweet->tweetID === $retweet['retweet_tweetID'] OR $user_id == $retweet['retweet_userIDBy'] : '') ? 
                                                '<li class="justUndoCloneTweet" data-tweet="'.$tweet->tweetID.'" data-user="'.$tweet->tweetOwner.'" style="cursor:pointer;  border-right:1px solid;">Undo Rwtweet</li> ' : 
                                                '<li class="justCloneTweet" data-tweet="'.$tweet->tweetID.'" data-user="'.$tweet->tweetOwner.'" style="cursor:pointer;  border-right:1px solid var( --primary-border-color);">Retweet</li> ').'
                                                
                                                <li class="retweet" style="cursor:pointer" data-tweet="'.$tweet->tweetID.'" data-user="'.$tweet->tweetBy.'">Quote Tweet</li> 
												<i title="close" style="color:var( --primary-text-color)" class="fa fa-close close'.$tweet->tweetID.'"></i>
													</ul>
												</div>
                                                </li>
                                                <li> '.((isset($likes['likeOn']) ? $likes['likeOn'] === $tweet->tweetID : '') ? 
                                                '<button class="unlike-btn" data-tweet="'.$tweet->tweetID.'" data-user="'.$tweet->tweetOwner.'"><i class="fa fa-heart" aria-hidden="true"></i><span class="likesCounter">'.(($tweet->likesCount > 0) ? $tweet->likesCount : '' ).'</span></button>' : 
                                                '<button class="like-btn" data-tweet="'.$tweet->tweetID.'" data-user="'.$tweet->tweetOwner.'"><i class="fa fa-heart-o" aria-hidden="true"></i><span class="likesCounter">'.(($tweet->likesCount > 0) ? $tweet->likesCount : '' ).'</span></button>').' 
                                                </li>
                                                <li> <i class="fa fa-bookmark-o"></i> </li>
                                                ' : '<li><button><i class="fa fa-comment"></i> <span> 485 </span></button></li>
                                                    <li><button><i class="fa fa-retweet" aria-hidden="true"></i><span class="retweetsCount">'.(($tweet->retweetCount > 0) ? $tweet->retweetCount : '').'</span></button></li>	
                                                    <li><button><i class="fa fa-heart-o" aria-hidden="true"></i><span class="likesCounter">'.(($tweet->likesCount > 0) ? $tweet->likesCount : '' ).'</span></button></li>
                                                    <li> <i class="fa fa-bookmark"></i> </li>').'

                                            </ul>
                                        </div>
                                    </div>
                                    
												
                                </div>
                                <!-- bottom E -->
                            </div>
                            <!-- sc-ur-status E -->
        
                        </div>
                        <!-- flex-out E -->
                    </div>
                </div>
                
            </div>
                    </div>';
            }

        }

        public function checkTweetExistence($tweet_id){
            $stmt = $this->pdo->prepare("SELECT `tweetID` FROM `tweets` WHERE `tweetID` = :tweet_id");
            $stmt->bindParam(":tweet_id", $tweet_id, PDO::PARAM_INT);
            $stmt->execute();
            
            $count = $stmt->rowCount();

            if($count > 0){
                return true;
            } else {
                return false;
            }
        }
        public function checkRetweeTUser($tweet_id){
            $stmt = $this->pdo->prepare("SELECT * from `retweet` as rt LEFT JOIN `users` ON `retweet_userIDBy` = `user_id` where `retweet_tweetID` = :tweet_id AND `retweet_userIDBy` = rt.`retweet_userIDBy`");
            // $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $stmt->bindParam(":tweet_id", $tweet_id, PDO::PARAM_INT);
            $stmt->execute();
            // var_dump($stmt);
            // return $stmt->fetch(PDO::FETCH_ASSOC);
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function getUserTweets($user_id){

            // select * from ( select t.* from tweets as t where tweetOwner = 7 union select t.* from tweets as t where t.tweetID in (select retweet_tweetID from retweet where retweet_userIDBy = 7)) a order by postedOn desc
            

            $stmt = $this->pdo->prepare("SELECT * FROM (SELECT t.* FROM `tweets` AS t WHERE `tweetOwner` = :user_id UNION SELECT t.* FROM `tweets` AS t WHERE t.`tweetID` IN (SELECT `retweet_tweetID` FROM `retweet` WHERE `retweet_userIDBy` =:user_id)) A ORDER BY `postedOn` DESC");
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function fetchLikes($tweet_id) {

            $stmt = $this->pdo->prepare("UPDATE `tweets` t SET `likesCount` = (SELECT COUNT(*) FROM `likes` WHERE `likeOn` = :tweet_id) WHERE `tweetID` = :tweet_id ");
            $stmt->bindParam(":tweet_id", $tweet_id, PDO::PARAM_INT);
            $stmt->execute();

            $stmt = $this->pdo->prepare("SELECT `likesCount` as toatlLikes FROM `tweets` WHERE `tweetId` = :tweet_id");
            $stmt->bindParam(":tweet_id", $tweet_id, PDO::PARAM_INT);
            $stmt->execute();
            $count = $stmt->fetch(PDO::FETCH_OBJ);
            echo $count->toatlLikes .' <span class="low" style="font-weight:500px !important;">Likes</span>';
        }

        public function fetchRetweetQuoteCount($tweet_id) {
            $stmt = $this->pdo->prepare("SELECT COUNT(`tweetRef`) AS toatlTweetQuote FROM `tweets` WHERE `tweetRef` = :tweet_id");
            $stmt->bindParam(":tweet_id", $tweet_id, PDO::PARAM_INT);
            $stmt->execute();
            $count = $stmt->fetch(PDO::FETCH_OBJ);
            // var_dump($count);
            return $count->toatlTweetQuote .' <span class="low" style="font-weight:500px !important;">Quote Tweets</span>';
        }

        public function fetchRetweetCount($tweet_id) {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) AS toatlRetweet FROM `retweet` WHERE `retweet_tweetID` = :tweet_id");
            $stmt->bindParam(":tweet_id", $tweet_id, PDO::PARAM_INT);
            $stmt->execute();
            $count = $stmt->fetch(PDO::FETCH_OBJ);
            // var_dump($count);
            return $count->toatlRetweet .' <span class="low" style="font-weight:500px !important;">Retweet</span>';
        }

        public function getRetweetQuotes($tweet_id) {

            $stmt = $this->pdo->prepare("SELECT * from `tweets` where `tweetRef` =:tweet_id");
            $stmt->bindParam(":tweet_id", $tweet_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function likedUserOntweets($tweet_id) {
            $stmt = $this->pdo->prepare("SELECT * FROM `likes` as li LEFT join `users` on `user_id` WHERE li.`likeOn` =:tweet_id and `user_id` = li.`likeBy`");
            $stmt->bindParam(":tweet_id" , $tweet_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
        public function retweetUserOntweets($tweet_id) {
            $stmt = $this->pdo->prepare("SELECT * FROM `retweet` as re LEFT join `users` on `user_id` WHERE re.`retweet_tweetID` = :tweet_id and `user_id` = re.`retweet_userIDBy`");
            $stmt->bindParam(":tweet_id" , $tweet_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function getUserTweetsByLiked($user_id){

            // select * from ( select t.* from tweets as t where tweetOwner = 7 union select t.* from tweets as t where t.tweetID in (select retweet_tweetID from retweet where retweet_userIDBy = 7)) a order by postedOn desc
            

            $stmt = $this->pdo->prepare("SELECT * FROM `tweets` as ult INNER JOIN `likes` ON `likeBy` WHERE `likeBy` =:user_id AND `likeOn` = ult.`tweetID` ORDER BY `postedOn` DESC");
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function getUserTweetsByID($tweet_id , $user_id){
            $stmt = $this->pdo->prepare("SELECT * FROM `tweets` WHERE `tweetID` = :tweet_id AND `tweetBy` =:user_id ");
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $stmt->bindParam(":tweet_id", $tweet_id, PDO::PARAM_INT);
            $stmt->execute();
            // var_dump($stmt);
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
        public function getUserTweetsOwnerByID($tweet_id , $user_id){
            $stmt = $this->pdo->prepare("SELECT * FROM `tweets` WHERE `tweetID` = :tweet_id AND `tweetOwner` =:user_id ");
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $stmt->bindParam(":tweet_id", $tweet_id, PDO::PARAM_INT);
            $stmt->execute();
            // var_dump($stmt);
            return $stmt->fetchAll(PDO::FETCH_OBJ);
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
            preg_match_all("/#+([a-zA-Z0-9_]+)/i", $hashtag, $matches);
            if($matches){
                $result = array_values($matches[1]);
            }
            $dates = date("Y-m-d H:i:s");
            $sql = "INSERT INTO `trends` (`hashtag`, `createdOn`) VALUES (:hashtag, CURRENT_TIMESTAMP) ON DUPLICATE KEY UPDATE `freqCheck` = `freqCheck` + 1 , `createdOn` =:dates";
            foreach ($result as $trend) {
                if($stmt = $this->pdo->prepare($sql)){
                    $stmt->execute(array(':hashtag' => $trend , ':dates' => $dates));
                }
            }
        }

        public function addMention($status,$user_id, $tweet_id){
            if(preg_match_all("/@+([a-zA-Z0-9_]+)/i", $status, $matches)){
                if($matches){
                    $result = array_values($matches[1]);
                }
                $sql = "SELECT * FROM `users` WHERE `username` = :mention";
                foreach ($result as $trend) {
                    if($stmt = $this->pdo->prepare($sql)){
                        $stmt->execute(array(':mention' => $trend));
                        $data = $stmt->fetch(PDO::FETCH_OBJ);
                    }
                }
    
                if($data->user_id != $user_id){
                    //This fixed PHP 7 error for non static methods
                    $this->message->sendNotification($data->user_id, $user_id, $tweet_id, 'mention');
                }
            }
        }

        public function getTweetLinks($tweet){
            $tweet = preg_replace("/(https?:\/\/)([\w]+.)([\w\.]+)/","<a href='$0' target='_blink'>$0</a>",$tweet);
            $tweet = preg_replace("/#([\w]+)/","<a href='".BASE_URL."hashtag/$1'>$0</a>",$tweet);
            $tweet = preg_replace("/@([\w]+)/","<a href='".BASE_URL."$1'>$0</a>",$tweet);
            return $tweet;
        }
        public function getPopupTweet($tweet_id){
            $stmt = $this->pdo->prepare("SELECT * FROM `tweets`,`users` WHERE `tweetID` = :tweet_id AND `tweetOwner` = `user_id`");
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

        public function retweet($tweet_id, $user_id, $get_id, $comment, $tweetImage){
            $stmt = $this->pdo->prepare("UPDATE `tweets` SET `retweetCount` = `retweetCount`+1 WHERE `tweetID` = :tweet_id AND `tweetOwner` = :get_id");
            $stmt->bindParam(":tweet_id", $tweet_id, PDO::PARAM_INT);
            $stmt->bindParam(":get_id", $get_id, PDO::PARAM_INT);
            $stmt->execute();

            $stmt = $this->pdo->prepare("UPDATE `tweets` SET `tweetOwner` = :get_id WHERE `tweetID` = :tweet_id AND `tweetOwner` = :get_id");
            $stmt->bindParam(":tweet_id", $tweet_id, PDO::PARAM_INT);
            $stmt->bindParam(":get_id", $get_id, PDO::PARAM_INT);
            $stmt->execute();

            $dates = date("Y-m-d H:i:s");
            $stmt = $this->pdo->prepare("INSERT INTO `tweets` (`status`,`tweetOwner`,`tweetRef`,`tweetRefTo`,`tweetBy`,`tweetImage`,`postedOn`,`retweetMsg`)
                                        SELECT :retweetMsg,:user_id,`tweetID`,`tweetBy`,:user_id,:tweetImage,:dates, :retweetMsg 
                                        FROM `tweets` WHERE `tweetID` = :tweet_id");
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            // $stmt->bindParam(":get_id", $get_id, PDO::PARAM_INT);
            $stmt->bindParam(":retweetMsg", $comment, PDO::PARAM_STR);
            $stmt->bindParam(":tweetImage", $tweetImage, PDO::PARAM_STR);
            $stmt->bindParam(":dates", $dates, PDO::PARAM_STR);
            $stmt->bindParam(":tweet_id", $tweet_id, PDO::PARAM_INT);
            $stmt->execute();
            $this->message->sendNotification($get_id, $user_id, $tweet_id, 'retweet');
        }

        public function retweets($tweet_id, $tweet_id_user_id, $user_id) {

            $stmt = $this->pdo->prepare("UPDATE `tweets` SET `retweetCount` = `retweetCount`+1 WHERE `tweetID` = :tweet_id AND `tweetOwner` = :tweet_id_user_id");
            $stmt->bindParam(":tweet_id", $tweet_id, PDO::PARAM_INT);
            $stmt->bindParam(":tweet_id_user_id", $tweet_id_user_id, PDO::PARAM_INT);
            // var_dump($stmt);
            $stmt->execute();

            $stmts = $this->create('retweet', array('retweet_tweetID' => $tweet_id, 'retweet_userID' => $tweet_id_user_id , 'retweet_userIDBy' => $user_id , 'postedOn'=> date('Y-m-d H:i:s')));
            var_dump($stmts);
            if($tweet_id_user_id != $user_id){
                $this->message->sendNotification($tweet_id_user_id, $user_id, $tweet_id, 'retweet');
            }
        }

        public function checkRetweet($tweet_id,$user_id){
            $stmt = $this->pdo->prepare("SELECT * FROM `retweet` WHERE `retweet_tweetID` = :tweet_id AND `retweet_userIDBy` = :user_id or `retweet_tweetID` = :tweet_id AND `retweet_userIDBy`=:user_id");
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
            if($get_id != $user_id){
                $this->message->sendNotification($get_id, $user_id, $tweet_id, 'like');
            }
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
        public function deleteCount($tweet_id, $tweetRef, $tweetRefTo){
            $stmt = $this->pdo->prepare("UPDATE `tweets` SET `retweetCount` = `retweetCount` -1 WHERE `tweetID` = :tweetRef AND `tweetOwner` = :tweetRefTo");
            // $stmt->bindParam(":tweet_id", $tweet_id, PDO::PARAM_INT);
            $stmt->bindParam(":tweetRef", $tweetRef, PDO::PARAM_INT);
            $stmt->bindParam(":tweetRefTo", $tweetRefTo, PDO::PARAM_INT);
            $stmt->execute();
    
           
        }

        public function countTweets($user_id){

            // SELECT (select count(*) from `tweets` WHERE `tweetOwner` = 1) + (select count(*) from `retweet` WHERE `retweet_userIDBy` = 1) as totalTweets;

            $stmt = $this->pdo->prepare("SELECT (SELECT COUNT(*) FROM `tweets` WHERE `tweetOwner`=:user_id) + (SELECT COUNT(*) FROM `retweet` WHERE `retweet_userIDBy`=:user_id) AS `totalTweets`");
            $stmt->bindParam(":user_id" , $user_id,PDO::PARAM_INT);
            $stmt->execute();
            $count = $stmt->fetch(PDO::FETCH_OBJ);
            echo $count->totalTweets;
        }

        public function countLikes($user_id){
            $stmt = $this->pdo->prepare("SELECT COUNT(`likeID`) AS totalLikes FROM `likes` WHERE `likeBy` = :user_id");
            $stmt->bindParam(":user_id" , $user_id,PDO::PARAM_INT);
            $stmt->execute();
            $count = $stmt->fetch(PDO::FETCH_OBJ);
            echo $count->totalLikes;
        }

        public function countComments($tweet_id){
            $stmt = $this->pdo->prepare("SELECT COUNT(`commentOn`) AS totalCom FROM `comments` WHERE `commentOn` = :tweet_id");
            $stmt->bindParam(":tweet_id" , $tweet_id,PDO::PARAM_INT);
            $stmt->execute();
            $count = $stmt->fetch(PDO::FETCH_OBJ);
            return $count->totalCom;
        }

        public function searchTCount($search){
            $stmt = $this->pdo->prepare("SELECT *, COUNT(`tweetID`) AS `tweetCount` FROM `tweets` LEFT JOIN `users` ON `tweetOwner` = `user_id` WHERE `status` LIKE :search");
            $stmt->bindValue(":search",'%'.$search.'%',PDO::PARAM_STR);
            // var_dump($stmt);
            $stmt->execute();
            $count =  $stmt->fetchAll(PDO::FETCH_OBJ);
            return $count[0]->tweetCount;
        }

        public function trends(){
            $stmt = $this->pdo->prepare("SELECT * , COUNT(`tweetID`) AS `tweetCount` FROM `trends` INNER JOIN `tweets` ON `status` LIKE CONCAT('%#',`hashtag`,'%') OR `retweetMsg` LIKE CONCAT('%#',`hashtag`,'%') WHERE `createdOn` BETWEEN SYSDATE() - INTERVAL 7 DAY AND SYSDATE() GROUP BY `hashtag` ORDER BY `tweetID`");
            $stmt->execute();
            $trends = $stmt->fetchAll(PDO::FETCH_OBJ);
            // echo '';
            foreach ($trends as $trend){
                echo '<div class="trend-body">
                <div class="trend-body-content">
                <h4 style="color:var( --secondary-text-color);">Trending in india</h4>
                <a href="'.BASE_URL.'hashtag/'.$trend->hashtag.'" style="color:var( --primary-text-color); text-decoration:none; font-weight:200; ">
                            <div class="trend-link" style="font-size:1rem; font-weight:800;line-height:24px;">
                               #'.$trend->hashtag.'
                            </div>
                            <div class="trend-tweets">
                                '.$trend->tweetCount.' <span>tweets</span>
                            </div>
                            </a>
                        </div>
                    </div>
            <!--Trend body end-->';
            }
            // echo '';
        }

        public function getTweetsByHash($hashtag){
            $stmt = $this->pdo->prepare("SELECT * FROM `tweets` LEFT JOIN `users` ON `tweetBy` = `user_id` WHERE `status` LIKE :hashtag OR `retweetMsg` LIKE :hashtag AND `postedOn` BETWEEN SYSDATE() - INTERVAL 14 DAY AND SYSDATE() ORDER BY `likesCount` DESC");
            $stmt->bindValue(":hashtag",'%#'.$hashtag.'%',PDO::PARAM_STR);
            // var_dump($stmt);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
        public function searchTweets($searchTweets){
            // logic remains
            $stmt = $this->pdo->prepare("SELECT * FROM `tweets` LEFT JOIN `users` ON `tweetBy` = `user_id` WHERE `status` LIKE :searchTweets AND `postedOn` BETWEEN SYSDATE() - INTERVAL 14 DAY AND SYSDATE() ORDER BY `likesCount` DESC");
            $stmt->bindValue(":searchTweets",'%'.$searchTweets.'%',PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
        public function searchTweetsLeasted($searchTweets){
            // logic remains
            $stmt = $this->pdo->prepare("SELECT * FROM `tweets` LEFT JOIN `users` ON `tweetBy` = `user_id` WHERE `status` LIKE :searchTweets ORDER BY `postedOn` DESC");
            $stmt->bindValue(":searchTweets",'%'.$searchTweets.'%',PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function getTweetsByHashLatest($hashtag){
            $stmt = $this->pdo->prepare("SELECT * FROM `tweets` LEFT JOIN `users` ON `tweetBy` = `user_id` WHERE `status`  LIKE :hashtag OR `retweetMsg` LIKE :hashtag ORDER BY `postedOn` DESC");
            $stmt->bindValue(":hashtag",'%#'.$hashtag.'%',PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function getUsersByHash($hashtag){
            $stmt = $this->pdo->prepare("SELECT DISTINCT * FROM `tweets` INNER JOIN `users` ON `tweetBy` = `user_id` WHERE `status` LIKE :hashtag OR `retweetMsg` LIKE :hashtag GROUP BY `user_id`");
            $stmt->bindValue(":hashtag", '%#'.$hashtag.'%',PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }


    }
