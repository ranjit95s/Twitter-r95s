<?php
	    // if($_SERVER['REQUEST_METHOD'] == "GET" && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])){
		// 	header('Location: ../index.php');
		// }
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
					$date = date('Y-m-d H:i:s');
					$user_id = $getFromU->create('users',array('email'=>$email,'password'=>md5($password),'screenName' => $screenName, 'ProfileImage'=> 'assets/images/dpi.png','profileCover' => 'assets/images/dc.png','country' => 'India','joinedOn' => $date));
					$_SESSION['user_id'] = $user_id;
					header('Location:includes/signupC.php?step=1');
				}
			}

		}
	}
?>

<form method="post">
							<div class="signup-div">
								<h3>Sign up </h3>
								<?php if(isset($error)){
		echo '<li class="error-li">
		<div class="span-fp-error">' .$error. '</div>
	   </li> ';
	} ?>
								<ul style="text-align:center;">
									<li>
										<input type="text" name="screenName" id="sFullnameVal" required placeholder="Full Name" autocomplete="off" />
										<br>
										<span class="onchange0" id="onName"> name require </span>
									</li>
									<br>
									<li>
										<input type="email" name="email" id="sEmailVal" required placeholder="Email" autocomplete="on"  />
										<br>
										<span class="onchange0" id="onEmail"> email require </span>
									</li>
									<br>
									<li>
										<input type="password" name="password" id="sPassVal" required placeholder="Password" autocomplete="off"/>
										<br>
										<span class="onchange0" id="onPass"> password require </span>
									</li>
									<br>
									<li>
										<input type="password" name="Cpassword" required id="sCPassVal" placeholder="Confirm Password" autocomplete="off"/>
										<br>
										<span class="onchange0" id="onCPass"> doesn't match with password </span>
									</li>
									<br>
									<li>
										<input type="submit" id="clickSignUp" name="signup" Value="Signup for Tweety">
									</li>
									<br>
									<li style="font-weight: 700; color:var( --primary-text-color);"> Already have an account? <span id="have-acc" style="color: var( --primary-theme-color); cursor: pointer;"> Log in </span> </li>
								</ul>


	
</div>
</form>