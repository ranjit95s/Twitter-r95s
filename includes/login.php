<?php
    if($_SERVER['REQUEST_METHOD'] == "GET" && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])){
        header('Location: ../index.php');
    }
    // if form submitted (POST) and form isnt empty
    if(isset($_POST['login']) && !empty($_POST['login'])) {
        // getting email and password from fields [fields name are 'email' & 'password']
        $email    = $_POST['email'];
        $password = $_POST['password'];
        // email and password fields arent empty
        if(!empty($email) or !empty($password)){
            // passing through checkInput() method / function -
            $email    = $getFromU -> checkInput($email);
            $password = $getFromU -> checkInput($password);
            // validating email format 
            if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
                // if invalid pass error
                $error = "Invalid email format";
            } else {
                // else above condition satisfying -- pass field values in database to verify values
                if($getFromU->login($email,$password) ===false){
                    $error = "The email or password is incorret !";
                }
            }

        }else {
            $error = "Please enter email and password !";
        }
    }
?>

<div class="login-div">
							<h3>Log in to Tweety</h3>
							<form method="post">
								<ul style="text-align:center;">
									<li>
										<input type="text" name="email" id="emailVal" placeholder="Please enter your Email here" />
									</li>
									<li>
										<input type="password" name="password" id="passVal" placeholder="password" />
									</li>

									<li><input type="submit" name="login" value="Log in" /></li>
									<br>
									<li style="font-weight: 700;"> Don’t have an account? <span id="not-acc" style="color: #2424ce; cursor: pointer;"> Sign up </span> </li>
								</ul>
    <?php 

    if(isset($error)){
        echo ' <li class="error-li">
                <div class="span-fp-error">' .$error. '</div>
                </li> ';
    }
	
    ?>
	</form>
</div>