<?php 
    // creating user class
    class User {
        // global $pdo --init.php
        protected $pdo;
        /* 
        A constructor allows you to initialize an object's properties upon creation of the object.
        If you create a __construct() function, 
        PHP will automatically call this function when you create an object from a class.
        */
        function __construct($pdo){
            $this->pdo = $pdo; 
        }

        // 
        public function checkInput($var){
            // htmlspecialchars — Convert special characters to HTML entities
            /* 
            Convert the predefined characters "<" (less than) and ">" (greater than) to HTML entities:

            $str = "This is some <b>bold</b> text.";
            echo htmlspecialchars($str);
               **The HTML output of the code above will be (View Source):
                        <!DOCTYPE html>
                        <html>
                        <body>
                                This is some &lt;b&gt;bold&lt;/b&gt; text.
                        </body>
                        </html>
            The browser output of the code above will be:
            This is some <b>bold</b> text.
            */
            $var = htmlspecialchars($var);
            // trim from right and left
            /*  The trim() function removes whitespace and other predefined characters from both sides of a string.
                    $str = " Hello World! ";
                    echo "Without trim: " . $str;
                    echo "<br>";
                    echo "With trim: " . trim($str);
               **The HTML output of the code above will be (View Source):
                        <!DOCTYPE html>
                        <html>
                        <body>
                                Without trim:  Hello World! <br>With trim: Hello World!
                        </body>
                        </html>
            The browser output of the code above will be:
            Without trim : Hello World!
            With trim    : Hello World!
            */
            $var = trim($var);
            // Remove the backslash in front of character:
            /* 
            echo stripcslashes("Hello \World!");
            The browser output of the code above will be:
            Hello World!
            */
            $var = stripcslashes($var);
            // return the variable
            return $var;
        }

        public function preventAccess($request,$currentFile,$currently){
            if($request == "GET" && $currentFile == $currently){
                header('Location: '.BASE_URL.'index.php');
            }
        }

        public function login($email,$password){
            // statement call database and prepare for query execution 
            // select user_id from users table(users database) where email value is in :email field( ':' says email field )
            // and password is in :password field
            $stmt = $this->pdo->prepare("SELECT `user_id` FROM `users` WHERE `email` = :email AND `password` = :password");
            // '->' is used to call a method, or access a property, on the object of a class.
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $tempPassCheck = md5($password);
            $stmt->bindParam(":password", $tempPassCheck, PDO::PARAM_STR);
            /* The PDOStatement::bindParam() function is an inbuilt function in PHP 
            which is used to bind a parameter to the specified variable name. This function bound the variables, 
            pass their value as input and receive the output value, if any, of their associated parameter marker. 
            */

            $stmt->execute();
            
            $user = $stmt->fetch(PDO::FETCH_OBJ);
            $count = $stmt->rowCount();

            if($count > 0){
                $_SESSION['user_id'] = $user->user_id;
                header('Location:home.php');
            } else {
                return false;
            }
        }

        public  function search($search){
            $stmt = $this->pdo->prepare("SELECT `user_id`, `username`,`screenName`,`profileImage`,`profileCover` FROM `users` WHERE `username` LIKE ? OR `screenName` LIKE ?");
            $stmt->bindValue(1,$search.'%',PDO::PARAM_STR);
            $stmt->bindValue(2,$search.'%',PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function userData($user_id){
            $stmt = $this->pdo->prepare("SELECT * FROM `users` WHERE `user_id` = :user_id ");
            $stmt ->bindParam(":user_id",$user_id,PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_OBJ);
        }

        public function create($table,$field = array()){
            $columns = implode(',',array_keys($field));
            $values = ':'.implode(', :',array_keys($field));

            $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$values})";
            // var_dump($sql);
            // string(47) "INSERT INTO users (username) VALUES (:username)"

            if($stmt = $this->pdo->prepare($sql)){
                foreach($field as $key => $data){
                    $stmt->bindValue(':'.$key,$data);
                }
                $stmt->execute();
                return $this->pdo->lastInsertId();
            }
        }

        public function update($table,$user_id,$field = array()){
            $columns = '';
            $i       = 1;

            foreach($field as $name => $value){
                $columns .="`{$name}` = :{$name}";
                if($i < count($field)){
                    $columns .= ', ';
                }
                $i++;
            }
            $sql = "UPDATE {$table} SET {$columns} WHERE `user_id` = {$user_id}";
            if($stmt = $this->pdo->prepare($sql)){
                foreach($field as $key => $value){
                    $stmt->bindValue(':'.$key,$value);
                }
                $stmt->execute();
            }
        }

        public function delete($table , $array){
            $sql = "DELETE FROM `{$table}`";
            $where = " WHERE ";

            foreach($array as $name => $value){
                $sql .= " {$where} `{$name}` = :{$name}";
                $where = " AND ";

            }
            if($stmt = $this->pdo->prepare($sql)){
                foreach($array as $name => $value){
                    $stmt->bindValue(':'.$name,$value);
                }
                $stmt->execute();
            }

        }

        // public function register($email,$screenName,$password){
        //     $stmt = $this->pdo->prepare("INSERT INTO `users` (`email`,`password`,`screenName`,`profileImage`,`profileCover`) VALUES (:email,:password,:screenName,'assets/images/dpi.png','assets/images/dc.png')");
        //     $stmt->bindParam(":email",$email,PDO::PARAM_STR);
        //     $stmt->bindParam(":password",md5($password),PDO::PARAM_STR);
        //     $stmt->bindParam(":screenName",$screenName,PDO::PARAM_STR);
        //     $stmt->execute();

        //     $user_id = $this->pdo->lastInsertId();
        //     $_SESSION['user_id'] = $user_id;
        // }

        public function loggedIn(){
            return (isset($_SESSION['user_id'])) ? true : false;
        }

        public function logout(){
            $_SESSION = array();
            session_destroy();
            header('Location: '.BASE_URL.'index.php');
        }

        public function checkEmail($email){
            $stmt = $this->pdo->prepare("SELECT `email` FROM `users` WHERE `email` = :email");
            $stmt->bindParam(":email",$email,PDO::PARAM_STR);
            $stmt->execute();

            $count = $stmt->rowCount();

            if($count > 0){
                return true;
            }else{
                return false;
            }
        }
        public function checkUsername($username){
            $stmt = $this->pdo->prepare("SELECT `username` FROM `users` WHERE `username` = :username");
            $stmt->bindParam(":username",$username,PDO::PARAM_STR);
            $stmt->execute();

            $count = $stmt->rowCount();

            if($count > 0){
                return true;
            }else{
                return false;
            }
        }

        public function checkPassword($password){
            $stmt = $this->pdo->prepare("SELECT `password` FROM `users` WHERE `password` = :password");
            $stmt->bindParam(":password",md5($password),PDO::PARAM_STR);
            $stmt->execute();

            $count = $stmt->rowCount();

            if($count > 0){
                return true;
            }else{
                return false;
            }
        }

        public function userIdByUsername($username){
            $stmt = $this->pdo->prepare("SELECT `user_id` FROM `users` WHERE `username` = :username");
            $stmt->bindParam(":username",$username,PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_OBJ);
            return $user->user_id;
        }

        public function uploadImage($file){
            $filename = basename($file['name']);
            $fileTem = $file['tmp_name'];
            $fileSize = $file['size'];
            $error = $file['error'];

            $ext = explode('.', $filename);
            $ext = strtolower(end($ext));
            $allowed_ext = array('jpg','png','jpeg');
            if(in_array($ext,$allowed_ext)===true){
                if($error ===0){
                    if($fileSize <= 209272152){
                        $date = date('Y_m_d-H-i-s');
                        $exts = pathinfo($filename, PATHINFO_EXTENSION);
                        $random = rand(99,999999);
                        $fileRoot = 'users/'.$date.'_'.$random.'.'.$exts;
                        move_uploaded_file($fileTem,$_SERVER['DOCUMENT_ROOT'].'/Twitter-Clone/'.$fileRoot);
                        return $fileRoot;
                    }else {
                        $GLOBALS['imageError']="file size is too large";
                    }
                }
            }else{
                $GLOBALS['imageError']="the extenstion is not allowed";
            }
        }
        public function timeAgo($datatime){
            $time    = strtotime($datatime);
            $current = time();
            $second  = $current - $time;
            $minute  = round($second / 60);
            $hour    = round($second / 3600);
            $month   = round($second / 2600640);

            if($second <= 60){
                if($second == 0){
                    return 'now';
                }else {
                    return $second.'s';
                }
            } else if ($minute <= 60){
                return $minute.'m';
            }else if ($hour <= 24){
                return $hour.'h';
            } else if($month <=12){
                return date('M j' , $time);
            } else {
                return date('j M Y',$time);
            }

        }
    }

?>