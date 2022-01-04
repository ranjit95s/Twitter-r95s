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
        $currentPwd  = $_POST['currentPwd'];
        $newPassword = $_POST['newPassword'];
        $rePassword  = $_POST['rePassword'];
        $error = array();
        if(!empty($currentPwd) && !empty($newPassword) && !empty($rePassword)){
            if($getFromU->checkPassword($currentPwd) ===true){
                if(strlen($newPassword) < 8){
                    $error['newPassword'] = "password is too short (min 8 len)";
                }else if($newPassword != $rePassword){
                    $error['rePassword'] = "new password does not match with comfirm password";
                }else {
                    $getFromU->update('users',$user_id,array('password'=>md5($newPassword)));
                    header('Location: '.BASE_URL.$user->username);
                }
            } else {
                $error['currentPwd'] = "Password is incorrect";
            }
        }else {
            $error['fields'] = "all fields are required";
        }
    }


?>


<html>
	<head>
		<title>Password settings page</title>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width">
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1" />
		<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script> 	 
 		<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style-complete.css"/>
   		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css"/>  
		

    </head>
	<!--Helvetica Neue-->
<body>
<?php
	include 'includes/entities/loader.php';
	?>
<div class="wrapper">
<?php 
                include 'includes/entities/side-pro-link.php';
            ?>
	<div class="righter">
		<div class="inner-righter">
			<div class="acc">
				<div class="acc-heading">
					<h2>Password</h2>
					<h3>Change your password or recover your current one.</h3>
				</div>
				<form method="POST">
				<div class="acc-content">
					<div class="acc-wrap">
						<div class="acc-left pass-left">
							Current password
						</div>
						<div class="acc-right pass-ri">
							<input type="password" name="currentPwd"/>
							<br>
								<div style="text-align: center; margin: 2px 0; font-size: 14px; color: #ed3f3f; padding: 5px;">
									<?php if(isset($error['currentPwd'])){
                                        echo $error['currentPwd'];
                                    }
                                    ?>
								</div>
						</div>
					</div>

					<div class="acc-wrap">
						<div class="acc-left pass-left">
							New password
						</div>
						<div class="acc-right pass-ri">
							<input type="password" name="newPassword" />
							<br>
								<div style="text-align: center; margin: 2px 0; font-size: 14px; color: #ed3f3f; padding: 5px;">
									<?php if(isset($error['newPassword'])){
                                        echo $error['newPassword'];
                                    }
                                    ?>
								</div>
						</div>
					</div>

					<div class="acc-wrap">
						<div class="acc-left pass-left">
							Verify password
						</div>
						<div class="acc-right pass-ri">
							<input type="password" name="rePassword"/>
							<br>
								<div style="text-align: center; margin: 2px 0; font-size: 14px; color: #ed3f3f; padding: 5px;">
									<?php if(isset($error['rePassword'])){
                                        echo $error['rePassword'];
                                    }
                                    ?>
								</div>
						</div>
					</div>
					<div class="acc-wrap">
						<div class="acc-left">
						</div>
						<div class="acc-right pass-ri">
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
									<a href="<?php echo BASE_URL;?>settings/account">
									<div>
										Change Account Settings
										<span><i class="fa fa-angle-right" aria-hidden="true"></i></span>
									</div>
									</a>
								</li>
							</ul>
						</div>
<div class="clear_fix" style="display:none; height:55px; width:100%;"></div>
		</div>	
	</div>
	<!--RIGHTER ENDS-->

</div>
<div class="alert hide">
         <span id="iconSign" class="fa "></span>
         <span class="msgs"> SAMPLE TEXT </span>
         <div class="close-btn">
            <span class="fa fa-times"></span>
         </div>
</div>
<!--CONTAINER_WRAP ENDS-->
</div>
<?php 
                include 'includes/entities/bottom-nav.php';
            ?>
<!-- ends wrapper -->
<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/popupForm.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/search.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/hashtag.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/messages.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/delete.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/postMessage.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/notification.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/custome-complete-js.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/like.js"></script>
</body>
</html>
