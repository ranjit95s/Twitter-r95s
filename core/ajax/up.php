<?php 

    include '../init.php';
    $getFromU->preventAccess($_SERVER['REQUEST_METHOD'], realpath(__FILE__),realpath($_SERVER['SCRIPT_FILENAME']));

    $user_id = $_SESSION['user_id'];
    if(isset($_POST['screenName'])){
            if(!empty($_POST['screenName'])){
                $screenName = $getFromU->checkInput($_POST['screenName']);
                $profileBio = $getFromU->checkInput($_POST['bio']);
                $country    = $getFromU->checkInput($_POST['country']);
                $website    = $getFromU->checkInput($_POST['website']);
                if(strlen($screenName) > 20){
                    $error = "name must be between 6-20";
                }else if(strlen($profileBio) > 120){
                    $error = "Bio is too long";
                }else if(strlen($country)>80){
                    $error = "Country name is too long";
                }else {
                    $getFromU->update('users',$user_id,array('screenName'=>$screenName, 'bio'=> $profileBio,'country'=>$country,'website'=>$website));
                    // header("Refresh:0");
                }
            }else{
                $error = "Name field can't be blink";
            }
        }
?>