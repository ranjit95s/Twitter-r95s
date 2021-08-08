<?php 

    class Follow extends User {
        protected $pdo;

        function __construct($pdo){
            $this->pdo = $pdo; 
        }


        public function checkFollow($followID, $user_id){
            $stmt = $this->pdo->prepare("SELECT * FROM `follow` WHERE `sender` = :user_id  AND `receiver` = :followID");
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $stmt->bindParam(":followID", $followID, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
    
        }

        public function followBtn($profileID,$user_id){

            $data = $this->checkFollow($profileID,$user_id);
            if($this->loggedIn()===true){

                if($profileID != $user_id){
                    // follow / unfollow
                    if(isset($data['receiver']) && $data['receiver'] === $profileID){
                        // following btn
                        echo "<button class='f-btn following-btn follow-btn' data-follow='".$profileID."'>Following</button>";
                    } else {
                        // follow btn
                        echo "<button class='f-btn follow-btn' data-follow='".$profileID."'><i class='fa fa-user-plus'> Follow</i></button>";
                    }
                } else {
                    // edit btn
                    echo "<button class='f-btn' onclick=location.href='".BASE_URL."profileEdit.php'>Edit Profile</button>";
                }
            } else {
                echo "<button class='f-btn' onclick=location.href='".BASE_URL."index.php'><i class='fa fa-user-plus'> Follow</i></button>";
            }
        }

        public function follow($followID,$user_id){
            $date = date("Y-m-d H:i:s");
            $this->create('follow' , array('sender'=>$user_id,'receiver'=>$followID,'followOn'=> $date));
            $this->addFollowCount($followID,$user_id);
            $stmt = $this->pdo->prepare('SELECT * FROM `users` WHERE `user_id` = :followID');
            $stmt->execute(array("followID" =>$followID));
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode($data);

        }

        public function unfollow($followID,$user_id){

            $this->delete('follow' , array('sender'=>$user_id,'receiver'=>$followID));
            $this->removeFollowCount($followID,$user_id);
            $stmt = $this->pdo->prepare('SELECT * FROM `users` WHERE `user_id` =:followID');
            $stmt->execute(array("followID"=>$followID));
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode($data);

        }

        public function addFollowCount($followID,$user_id){
            $stmt = $this->pdo->prepare("UPDATE `users` SET `following` = `following` + 1 WHERE `user_id` = :user_id; UPDATE `users` SET `followers` = `followers` + 1 WHERE `user_id` = :followID");
            $stmt->execute(array("user_id"=>$user_id,"followID"=>$followID));

        }

        public function removeFollowCount($followID,$user_id){
            $stmt = $this->pdo->prepare("UPDATE `users` SET `following` = `following` - 1 WHERE `user_id` = :user_id; UPDATE `users` SET `followers` = `followers` - 1 WHERE `user_id` = :followID");
            $stmt->execute(array("user_id"=>$user_id,"followID"=>$followID));

        }

    }

?>