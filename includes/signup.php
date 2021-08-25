<?php
	    if($_SERVER['REQUEST_METHOD'] == "GET" && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])){
			header('Location: ../index.php');
		}
	if(isset($_POST['signup'])){
		$screenName = $_POST['screenName'];
		$password   = $_POST['password'];
		$email      = $_POST['email'];
		
		if(empty($screenName) or empty($password) or empty($email)){
			$error = 'All field are required';
		}else {
			$screenName = $getFromU->checkInput($screenName);
			$password   = $getFromU->checkInput($password);
			$email      = $getFromU->checkInput($email);

			if(!filter_var($email)){
				$error = 'Invalid email format';
			} else if((strlen($screenName) > 20)){
				$error = 'Name must be less than 20';
			}else if(strlen($password)<8){
				$error = 'password is too short (must be greater than 8)';
			}else {
				if($getFromU->checkEmail($email) === true){
					$error = 'Email is already in use';
				}else{
					$user_id = $getFromU->create('users',array('email'=>$email,'password'=>md5($password),'screenName' => $screenName, 'ProfileImage'=> 'assets/images/dpi.png','profileCover' => 'assets/images/dc.png'));
					$_SESSION['user_id'] = $user_id;
					header('Location:'.BASE_URL.'includes/signupC.php?step=1');
				}
			}

		}
	}
?>

<form method="post">
<div class="signup-div"> 
	<h3>Sign up </h3>
	<ul>
		<li>
		    <input type="text" name="screenName" placeholder="Full Name"/>
		</li>
		<li>
		    <input type="email" name="email" placeholder="Email"/>
		</li>
		<li>
			<input type="password" name="password" placeholder="Password"/>
		</li>
		<li>
			<input type="submit" name="signup" Value="Signup for Twitter">
		</li>
	</ul>
	<?php if(isset($error)){
		echo '<li class="error-li">
		<div class="span-fp-error">' .$error. '</div>
	   </li> ';
	} ?>

	
</div>
</form>