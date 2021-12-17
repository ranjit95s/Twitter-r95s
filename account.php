<?php 
     include 'core/init.php';
    $user_id = $_SESSION['user_id'];
    $user    = $getFromU->userData($user_id);
	$notify = $getFromM->getNotificationCount($user_id);
	$notification  = $getFromM->notification($user_id);
    if($getFromU->loggedIn()===false){
        header('Location: '.BASE_URL.'index.php');
    }
    if(isset($_POST['submit'])){
        $username = $getFromU->checkInput($_POST['username']);
        $email = $getFromU->checkInput($_POST['email']);
        $error = array();
		// $lmao = '/^[a-zA-Z0-9]{4,}$/';
        if(!empty($username) and !empty($email)){
            if($user->username != $username and $getFromU->checkUsername($username) === true){
                $error['username'] = "username is not available, try diffrent username";
            } else if(!preg_match('/^[a-zA-Z0-9]{4,}$/', $username)){
                $error['username'] = "only character and numbers allowed";
            } else if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
                $error['email'] = "Invalid email format";
            }else if($user->email != $email and $getFromU->checkEmail($email) === true){
                $error['email'] = "email already in use";
            } else {
                $getFromU->update('users',$user_id,array('username'=>$username,'email'=>$email));
                header('Location: '.BASE_URL.'settings/account');
            }
        }else {
            $error['fields'] = "all fields are required";
        }

    }
?>
<!DOCTYPE HTML> 
<html>
	<head>
		<title>Account settings page</title>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width">
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1" />
		<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script> 	 
 		<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style-complete.css"/>
   		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css"/>  
		

    </head>
	<!--Helvetica Neue-->
<body style="    min-height: 110vh;">
<div class="wrapper">
<?php 
                include 'includes/entities/side-pro-link.php';
            ?>
		<div class="righter">
			<div class="inner-righter">
				<div class="acc">
					<div class="acc-heading">
						<h2>Account</h2>
						<h3>Change your basic account settings.</h3>
					</div>
					<div class="acc-content">
					<form method="POST">
						<div class="acc-wrap">
							<div class="acc-left">
								USERNAME
							</div>
							<div class="acc-right">
								<input type="text" name="username" placeholder="<?php echo $user->username ?>" value="<?php echo $user->username ?>" />
								<br>
								<div style="text-align: center; margin: 2px 0; font-size: 14px; color: #ed3f3f; padding: 5px;">
									<?php if(isset($error['username'])){
                                        echo $error['username'];
                                    }
                                    ?>
								</div>
							</div>
						</div>

						<div class="acc-wrap">
							<div class="acc-left">
								Email
							</div>
							<div class="acc-right">
								<input type="text" name="email" placeholder="<?php echo $user->email ?>" value="<?php echo $user->email ?>"/>
								<br>
								<div style="text-align: center; margin: 2px 0; font-size: 14px; color: #ed3f3f; padding: 5px;">
									<?php if(isset($error['email'])){
                                        echo $error['email'];
                                    }
                                    ?>
								</div>
							</div>
						</div>
						<div class="acc-wrap">
							<div class="acc-left">
								
							</div>
							<div class="acc-right">
								<input type="Submit" name="submit" value="Save changes"/>
							</div>
							<div class="settings-error" style="color:var( --primary-text-color);">
                            <?php if(isset($error['fields'])){
                                        echo $error['fields'];
                                    }
                                    ?>
   							</div>	
						</div>
					</form>
					</div>
				</div>
				<div class="option-box">
					<ul> 
						<li>
							<a href="<?php echo BASE_URL;?>settings/password">
							<div>
								Change Password
								<span><i class="fa fa-angle-right" aria-hidden="true"></i></span>
							</div>
							</a>
						</li>
					</ul>
				</div>
			</div>	
		</div><!--RIGHTER ENDS-->
		
		<div class="popupTweet"></div>
		
		<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/custome-complete-js.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/popupForm.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/search.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/hashtag.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/messages.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/delete.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/postMessage.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/notification.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/like.js"></script>

	</div>
	<!--CONTAINER_WRAP ENDS-->

	</div><!-- ends wrapper -->
	<?php 
                include 'includes/entities/bottom-nav.php';
            ?>
</body>

</html>

