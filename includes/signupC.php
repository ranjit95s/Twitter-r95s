<?php

    // if($_SERVER['REQUEST_METHOD'] == "GET" && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])){
    //     header('Location: ../index.php');
    // }
    include '../core/init.php';
    $user_id = $_SESSION['user_id'];
    $user    = $getFromU->userData($user_id);
    
    if(isset($_GET['step']) === true && empty($_GET['step'])===false){

        if(isset($_POST['next'])){
            $username = $getFromU->checkInput($_POST['username']);
            
                if (!empty($username)) {
                if(strlen($username) > 20){
                    $error = "Username must be between in 6-20 characters";
                }else if(!preg_match('/^[a-zA-Z0-9]{4,}$/', $username)){
                    $error = 'Username must be longer than 4 alphanumeric characters without any spaces or special character';
                } else if($getFromU->checkUsername($username) === true){
                    $error = "Username is already taken!";
                }else{
                    $getFromU->update('users', $user_id, array('username' => $username));
                    header('Location: signupC.php?step=2');
                }
                }else{
                $error = "Please enter your username to choose";
                }
            }

        ?>
        <!doctype html>
<html>
		<title>Tweety</title>
		<meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css"/> 
		<link rel="stylesheet" href="../assets/css/style-complete.css"/>
        <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>  	  
	</head>
	<!--Helvetica Neue-->
<body>
<div class="wrapper">
<!-- nav wrapper -->
<div class="nav-wrapper">
	
	<div class="nav-container">	
		<div class="nav-second">
			<ul>
				<li><a href="#"<i class="fa fa-twitter" aria-hidden="true"></i></a></li>							
			</ul>
		</div><!-- nav second ends-->
	</div><!-- nav container ends -->

</div><!-- nav wrapper end -->

<!---Inner wrapper-->
<div class="inner-wrapper">
	<!-- main container -->
	<div class="main-container">
		<!-- step wrapper-->
        <?php if($_GET['step'] == 1) {?>
            <div class="step-wrapper">
		    <div class="step-container">
				<form method="post">
					<h2>Choose a Username</h2>
					<h4>Don't worry, you can always change it later.</h4>
					<div>
						<input type="text" id="usernameValidation" name="username" placeholder="Username"/>
					</div>
					<div>
						<ul>
					<li> <?php if(isset($error)){echo $error;} ?> </li>
						</ul>
					</div>
					<div>
						<input type="submit" name="next" value="Next"/>
					</div>
	</form>
			</div>
		</div>
        <?php }?>

        <?php if($_GET['step'] == 2) {?>
        <div class='lets-wrapper'>
            <div class='step-letsgo'>
                <h2>We're glad you're here, <?php echo $user-> screenName; ?> </h2>
                <p>Tweety is a constantly updating stream of the coolest, most important news, media, sports, TV, conversations and more--all tailored just for you.</p>
                <br/>
                <p>
                    Tell us about all the stuff you love and we'll help you get set up.
                </p>
                <span>
                    <a href='../home.php' class='backButton' style="color:#499bea;">Let's go!</a>
                </span>
            </div>
        </div>
        <?php }?>
		
	</div><!-- main container end -->

</div><!-- inner wrapper ends-->
</div><!-- ends wrapper -->

</body>
</html>
	<?php
    }
?>

