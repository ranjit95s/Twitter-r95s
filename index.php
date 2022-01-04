<?php
// initialize database , classes , BASE_URL
include 'core/init.php';
// if session is set to user redirect to home.php .. 
// dont let user acccess login page without logout || else continue with login page
if (isset($_SESSION['user_id'])) {
	// set session 
	$user_id = $_SESSION['user_id'];
	header('Location:home.php');
}
?>
<!--
   This template created by Meralesson.com 
   This template only use for educational purpose 
-->
<html>

<head>
	<title>Welcome to Tweety</title>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css" />
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style-complete.css" />
	<script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
	<!-- <script>
		var preLoader = document.getElementById('preLoader');
		function loader() {
			preLoader.style.display = 'none';
		}
	</script> -->
	<style>
		.onchange0 {
			display: none;
			color: #ff2d2d;
			float: left;
			text-transform: capitalize;
			font-weight: 600;
			padding: 5px;
			background: antiquewhite;
			width: 100%;
			text-align: start;
		}
	</style>

</head>
<!--Helvetica Neue-->

<body onload="loader()" >

	<?php
	include 'includes/entities/loader.php';
	?>

	<div class="front-img">
		<img src="assets/images/back.jpg" alt="background image">
	</div>

	<div class="wrapper">
		<!-- header wrapper -->
		<!---Inner wrapper-->
		<div class="inner-wrapper">
			<!-- main container -->
			<div class="main-container">
				<!-- content left-->
				<div class="content-left">
					<h1>Welcome to Tweety.</h1>
					<br />
					<p>A place to connect with your friends — and Get updates from the people you love, And get the updates from the world and things that interest you.</p>
				</div><!-- content left ends -->

				<!-- content right ends -->
				<div class="content-right">
					<!-- Log In Section -->
					<div class="login-wrapper">
						<!--Login Form here-->
						<?php
						include 'includes/login.php';
						?>
					</div><!-- log in wrapper end -->

					<!-- SignUp Section -->
					<div class="signup-wrapper">
						<!--SignUp Form here -->
						<?php
						include 'includes/signup.php';
						?>
					</div>
					<!-- SIGN UP wrapper end -->
					<div class="alert hide">
						<span id="iconSign" class="fa "></span>
						<span class="msgs"> SAMPLE TEXT </span>
						<div class="close-btn">
							<span class="fa fa-times"></span>
						</div>
					</div>
				</div><!-- content right ends -->

			</div><!-- main container end -->

		</div><!-- inner wrapper ends-->
	</div><!-- ends wrapper -->
	<script src="assets/js/custome-complete-js.js"></script>
</body>


<script>
	

	$(function() {

		

		$('#not-acc').click(function() {
			var loginForm = $('.login-wrapper').hide();
			var signUpForm = $('.signup-wrapper').show();
			var emailVal = $('#emailVal').val('');
			var passVal = $('#passVal').val('');
		});
		$('#have-acc').click(function() {
			var loginForm = $('.login-wrapper').show();
			var signUpForm = $('.signup-wrapper').hide();
			var onEvery = $('.onChange0').css({
				"display": "none"
			});
			var sFullnameVal = $('#sFullnameVal').val('');
			var sEmailVal = $('#sEmailVal').val('');
			var sPassVal = $('#sPassVal').val('');
			var sCPassVal = $('#sCPassVal').val('');
			var getsbtn = $('#checkPass').show();
			// var getbtn = $('#clickSignUp').hide();
		});

		$('#not-acc').click(function() {

			$(sFullnameVal).keyup(function() {
				if (sFullnameVal.value.length > 0) {
					var onName = $('#onName').css({
						"display": "none"
					});
					console.log("none")
				} else if (sFullnameVal.value.length == 0) {
					var onName = $('#onName').css({
						"display": "block"
					});
					console.log("none not")
				}
			})

			$(sEmailVal).keyup(function() {
				if (sEmailVal.value.length > 0) {
					var onEmail = $('#onEmail').css({
						"display": "none"
					});
					console.log("none")
				} else if (sEmailVal.value.length == 0) {
					var onEmail = $('#onEmail').css({
						"display": "block"
					});
					console.log("none not")
				}
			})

			function checkPasswordMatch() {
				var sPassVal1 = $('#sPassVal').val();
				var sCPassVal2 = $('#sCPassVal').val();

				if (sPassVal1 != sCPassVal2)
					var onName = $('#onCPass').css({
						"display": "block"
					});
				else
					var onName = $('#onCPass').css({
						"display": "none"
					});
			}

			$(document).ready(function() {
				$("#sPassVal, #sCPassVal").keyup(checkPasswordMatch);
			});



		})

	})
</script>

</html>