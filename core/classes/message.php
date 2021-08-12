<?php 

    class Message extends User {

        function __construct($pdo){
            $this->pdo = $pdo;
        }

        public function recentMessages($user_id){

            $stmt = $this->pdo->prepare("SELECT * FROM `messages` LEFT JOIN `users` ON `messageFrom` = `user_id` WHERE `messageTo` = :user_id");
            $stmt->bindParam(":user_id",$user_id,PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);

        }

    }



?>