<?php
    if(isset($_GET['username']) === true && empty($_GET['username']) === false){
        include 'core/init.php';
        
		$username    = $getFromU->checkInput($_GET['username']);
		$profileId   = $getFromU->userIdByUsername($username);
		$profileData = $getFromU->userData($profileId);
		$user_id 	 = $_SESSION['user_id'];
		$user 		 = $getFromU->userData($user_id);
		$notify = $getFromM->getNotificationCount($user_id);
		$notification  = $getFromM->notification($user_id);
		if($getFromU->loggedIn() === false){
			header('Location:'.BASE_URL.'index.php');
		}

        if(!$profileData){
            header('Location:'.BASE_URL.'index.php');
        }	

    } else {
		header('Location:'.BASE_URL.'index.php');
	}

?>

<!DOCTYPE html>
<html>

<head>
<title>People following <?php echo $profileData->screenName .' (@'. $username .')';?> / Tweety</title>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css" />
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style-complete.css" />
	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>


</head>
<!--Helvetica Neue-->

<body>
	<div class="wrapper hash-wrapper">
		<!-- header wrapper -->
		<?php 
                include 'includes/entities/side-pro-link.php';
            ?>
				<!-- in left end-->




				<div class="in-center">
					<div class="in-center-wrap">

						<section class="hash-hash-nav">
							<div class="hash-menu">
								<div class="hash-menu-inner hash-menu-inner-pro">
								<ul>
										<li><a href="<?php echo BASE_URL.$profileData->username; ?>/followers">Followers</a></li>
										<li class="followActive"><a href="<?php echo BASE_URL.$profileData->username; ?>/following">Following</a></li>
									</ul>
								</div>
							</div>
						</section>
						<div class="wrapper-following">
			<div class="wrap-follow-inner">
			<?php $getFromF->followingList($profileId, $user_id, $profileData->user_id);?>
			</div>
						</div>

			<div class="popupTweet"></div>
			</div>
			</div>
			<div class="in-right">
				<div class="in-right-wrap">
					<!--==WHO TO FOLLOW==-->
					<section class="search-engine">
							<div class="search-pro">
								<ul>
									<li>
										<i class="fa fa-search" aria-hidden="true"></i>
										<input type="text" placeholder="Search Twitter" class="search"/>
										<div class="search-result">
										</div>
									</li>
								</ul>
							</div>
						</section>
					<?php $getFromF->whoToFollow($user_id, $user_id); ?>
					<!--==WHO TO FOLLOW==-->
					<!--==TRENDS==-->
					<div class="trend-wrapper">
						<div class="trend-inner">
							<div class="trend-title">
								<h3>What’s happening</h3>
							</div>
							<!-- trend title end-->
							<?php $getFromT->trends(); ?>
						</div>
						<!--TREND INNER END-->
					</div>
					<!--TRENDS WRAPPER ENDS-->
					<!--==TRENDS==-->


				</div><!-- in right wrap-->
			<!--in full wrap end-->
		</div><!-- in wrappper ends-->

	</div><!-- ends wrapper -->
	<?php 
                include 'includes/entities/bottom-nav.php';
            ?>
	<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/custome-complete-js.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/popuptweets.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/delete.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/popupForm.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/follow.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/retweet.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/like.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/messages.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/postMessage.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/notification.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/hashtag.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/search.js"></script>

</body>
</html>