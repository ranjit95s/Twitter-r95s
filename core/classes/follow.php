<?php 

    class Follow extends User {
        protected $pdo;
        protected $tweet;
        function __construct($pdo){
            $this->pdo = $pdo; 
            $this->message = new Message($this->pdo);
            $this->tweet   = new tweet($this->pdo);
        }


        public function checkFollow($followerID, $user_id){
            $stmt = $this->pdo->prepare("SELECT * FROM `follow` WHERE `sender` = :user_id  AND `receiver` = :followerID");
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $stmt->bindParam(":followerID", $followerID, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
    
        }

        public function followBtn($profileID, $user_id, $followID){
            $data = $this->checkFollow($profileID, $user_id);
            if($this->loggedIn()===true){
    
                if($profileID != $user_id){
                    if(isset($data['receiver']) && $data['receiver'] === $profileID){
                        //Following btn
                        return "<button class='f-btn following-btn follow-btn' data-follow='".$profileID."' data-profile='".$followID."'>Following</button>";
                    }else{
                        //Follow button
                        return "<button class='f-btn follow-btn' data-follow='".$profileID."' data-profile='".$followID."'><i class='fa fa-user-plus'></i>Follow</button>";
                    }
                }else{
                    //edit button
                    return "<button class='f-btn' id='edit-from-follow' >Edit Profile</button>";
                }
            }else{
                return "<button class='f-btn' onclick=location.href='".BASE_URL."index.php'><i class='fa fa-user-plus'></i>Follow</button>";
            }
        }

        public function follow($followID, $user_id, $profileID){
            $date = date("Y-m-d H:i:s");
            $this->create('follow', array('sender' => $user_id, 'receiver' => $followID, 'followOn' => $date));
            $this->addFollowCount($followID, $user_id);
            $stmt = $this->pdo->prepare('SELECT `user_id`, `following`, `followers` FROM `users` LEFT JOIN `follow` ON `sender` = :user_id AND CASE WHEN `receiver` = :user_id THEN `sender` = `user_id` END WHERE `user_id` = :profileID');
            $stmt->execute(array("user_id" => $user_id,"profileID" => $profileID));
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode($data);
            $this->message->sendNotification($followID, $user_id, $user_id, 'follow');

            //This fixed php 7 error
            // $this->message->sendNotification($followID, $user_id, $user_id, 'follow');
    
        }
    
        public function unfollow($followID, $user_id, $profileID){
            $this->delete('follow', array('sender' => $user_id, 'receiver' => $followID));
            $this->removeFollowCount($followID, $user_id);
            $stmt = $this->pdo->prepare('SELECT `user_id`, `following`, `followers` FROM `users` LEFT JOIN `follow` ON `sender` = :user_id AND CASE WHEN `receiver` = :user_id THEN `sender` = `user_id` END WHERE `user_id` = :profileID');
            $stmt->execute(array("user_id" => $user_id,"profileID" => $profileID));
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode($data);
        }
    
        public function addFollowCount( $followID, $user_id){
            $stmt = $this->pdo->prepare("UPDATE `users` SET `following` = `following` + 1 WHERE `user_id` = :user_id; UPDATE `users` SET `followers` = `followers` + 1 WHERE `user_id` = :followID");
            $stmt->execute(array("user_id" => $user_id, "followID" => $followID));
        }
    
        public function removeFollowCount($followID, $user_id){
            $stmt = $this->pdo->prepare("UPDATE `users` SET `following` = `following` - 1 WHERE `user_id` = :user_id; UPDATE `users` SET `followers` = `followers` - 1 WHERE `user_id` = :followID");
            $stmt->execute(array("user_id" => $user_id, "followID" => $followID));
        }
    
        public function followingList($profileID, $user_id, $followID){
            $stmt = $this->pdo->prepare("SELECT * FROM `users` LEFT JOIN `follow` ON `receiver` = `user_id` AND CASE WHEN `sender` = :profileID THEN `receiver` = `user_id` END WHERE `sender` IS NOT NULL ");
            $stmt->bindParam(":profileID", $profileID, PDO::PARAM_INT);
            $stmt->execute();
            $followings = $stmt->fetchAll(PDO::FETCH_OBJ);
            foreach ($followings as $following) {
                echo '

                    <div class="flex"> 
                    <div class="imageFollow"> 
                    <a href="'.BASE_URL.$following->username.'">
                    <img src="'.BASE_URL.$following->profileImage.'"/>
                    </a>
                    </div>
                    <div class="followInfo">
                        <div class="info-follow">
                        <div class="name-username">
                        <h3> <a href="'.BASE_URL.$following->username.'">'.$following->screenName.' '.(($following->statusVerify != 0) ? '<i title="User Verified" id="verifyedUser" class="fa fa-check-circle"></i>' : '').' </a> </h3>
                        <h4> <a href="'.BASE_URL.$following->username.'">@'.$following->username.'</a> </h4>
                        </div>
                        <div class="followBtn"> '.$this->followBtn($following->user_id,$user_id,$profileID).'  </div>
                    </div>
                    <div class="bioFollow"> '.$this->tweet->getTweetLinks($following->bio).' </div>
                    </div>
                    
                    </div>

                        ';
            }
        }
    
        public function followersList($profileID, $user_id, $followID){
            $stmt = $this->pdo->prepare("SELECT * FROM `users` LEFT JOIN `follow` ON `sender` = `user_id` AND CASE WHEN `receiver` = :profileID THEN `sender` = `user_id` END WHERE `user_id` and `receiver` IS NOT NULL");
            $stmt->bindParam(":profileID", $profileID, PDO::PARAM_INT);
            $stmt->execute();
            $followings = $stmt->fetchAll(PDO::FETCH_OBJ);
            foreach ($followings as $following) {
                echo '
                <div class="flex"> 
                    <div class="imageFollow"> 
                    <a href="'.BASE_URL.$following->username.'">
                        <img src="'.BASE_URL.$following->profileImage.'"/>
                    </a>
                    </div>
                    <div class="followInfo">
                        <div class="info-follow">
                        <div class="name-username">
                        <h3> <a href="'.BASE_URL.$following->username.'">'.$following->screenName.' '.(($following->statusVerify != 0) ? '<i title="User Verified" id="verifyedUser" class="fa fa-check-circle"></i>' : '').'</a> </h3>
                        <h4> <a href="'.BASE_URL.$following->username.'">@'.$following->username.'</a> </h4>
                        </div>
                        <div class="followBtn"> '.$this->followBtn($following->user_id,$user_id,$profileID).'  </div>
                    </div>
                    <div class="bioFollow"> '.$this->tweet->getTweetLinks($following->bio).' </div>
                    </div>
                    
                    </div>';
            }
        }

        public function whoToFollow($user_id,$profileID){

            $stmt = $this->pdo->prepare("SELECT * FROM `users` WHERE `user_id` != :user_id AND `user_id` NOT IN (SELECT `receiver` FROM `follow` WHERE `sender` =:user_id) ORDER BY rand() LIMIT 3");
            $stmt->bindParam(":user_id", $user_id,PDO::PARAM_INT);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_OBJ);

            echo '<div class="follow-wrap">
                    <div class="follow-inner">
                    <div class="follow-title">
                    <h3>Who to follow</h3>
                    </div>';
            foreach($data as $user){
                echo '<div class="follow-body">
                        <div class="follow-img">
                        <a href="'.BASE_URL.$user->username.'">
                        <img src="'.BASE_URL.$user->profileImage.'"/>
                        </a>
                        </div>
                        <div class="follow-content">
                            <div class="fo-co-head ellipsis">
                                <a href="'.BASE_URL.$user->username.'">'.$user->screenName.' '.(($user->statusVerify != 0) ? '<i title="User Verified" id="verifyedUser" class="fa fa-check-circle"></i>' : '').' </a> </br> <span>@'.$user->username.'</span>
                            </div>
                            <div class="w-t-f-f-btn"> <!-- FOLLOW BUTTON -->
                            '.$this->followBtn($user->user_id,$user_id,$profileID).' 
                            </div>
                        </div>


                    </div>';
            }
            echo '</div></div>';

        }

        public function Relevantpeople($user_id,$profileID,$status){

            $user = $this->userData($profileID);
            if(preg_match_all("/@+([a-zA-Z0-9_]+)/i", $status, $matches)){
                if($matches){
                    $result = array_values($matches[1]);
                }
                $sql = "SELECT * FROM `users` WHERE `username` != :profileID AND `username` = :mention";
                echo '<div class="follow-wrap">
                <div class="follow-inner">
                <div class="follow-title">
                <h3>Relevant People</h3>
                </div>';
                foreach ($result as $i => $trend) {
                    if($stmt = $this->pdo->prepare($sql) ){
                        $stmt->execute(array(':mention' => $trend , ':profileID' => $user->username));
                        $data = $stmt->fetch(PDO::FETCH_OBJ);

                        
                            if($data && $data->username != $user->username){
                                echo '<div class="follow-body">
                                <div class="follow-img">
                                <a href="'.BASE_URL.$data->username.'">
                                <img src="'.BASE_URL.$data->profileImage.'"/>
                                </a>
                                </div>
                                <div class="follow-content">
                                    <div class="fo-co-head ellipsis">
                                        <a href="'.BASE_URL.$data->username.'">'.$data->screenName.' '.(($data->statusVerify != 0) ? '<i title="User Verified" id="verifyedUser" class="fa fa-check-circle"></i>' : '').'</a> </br> <span>@'.$data->username.'</span>
                                    </div>
                                    <div class="w-t-f-f-btn"> <!-- FOLLOW BUTTON -->
                                    '.$this->followBtn($data->user_id,$user_id,$profileID).' 
                                    </div>
                                </div>
                            </div>';

                            }
                     

                   

                    }
                }
                echo '</div></div>';
   
            }else{
                echo '<div class="follow-wrap">
                <div class="follow-inner">
                <div class="follow-title">
                <h3>Relevant People</h3>
                </div>';
                echo '<div class="follow-body">
                <div class="follow-img">
                <a href="'.BASE_URL.$user->username.'">
                <img src="'.BASE_URL.$user->profileImage.'"/>
                </a>
                </div>
                <div class="follow-content">
                    <div class="fo-co-head ellipsis">
                        <a href="'.BASE_URL.$user->username.'">'.$user->screenName.' '.(($user->statusVerify != 0) ? '<i title="User Verified" id="verifyedUser" class="fa fa-check-circle"></i>' : '').' </a> </br> <span>@'.$user->username.'</span>
                    </div>
                    <div class="w-t-f-f-btn"> <!-- FOLLOW BUTTON -->
                    '.$this->followBtn($user->user_id,$user_id,$profileID).' 
                    </div>
                </div>
            </div>';
            echo '</div></div>';
            }


        }

    }

?>