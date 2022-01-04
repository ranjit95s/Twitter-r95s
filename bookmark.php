<?php 
		include 'core/init.php';
		$user_id = $_SESSION['user_id'];
		$user = $getFromU->userData($user_id);
		$notify = $getFromM->getNotificationCount($user_id);

		if($getFromU->loggedIn() ===false){
			header('Location:index.php');
		}
			// $getFromU->delete('comments', array('commentID' => 9));
			// $getFromU->create('users',array('username' => 'dany','email' => 'dany12@gmail.com','password'=> md5('password')));
			// $getFromU->update('users',$user_id,array('username' => 'danynew','email' => 'danynew45@gmail.com'));

			if(isset($_POST['tweet'])){
				$status = $getFromU->checkInput($_POST['status']);
				$tweetImage = '';

				if(!empty($status) or !empty($_FILES['file']['name'][0])){
					if(!empty($_FILES['file']['name'][0])){
						$tweetImage = $getFromU->uploadImage($_FILES['file']);
					}
					if(strlen($status)>300){
						$error = "tweet must be in 300 length";
					}
					$tweet_id = $getFromU->create('tweets',array('status' => $status,'tweetBy'=>$user_id,'tweetOwner'=>$user_id, 'tweetImage'=> $tweetImage,'postedOn'=> date('Y-m-d H:i:s')));
					preg_match_all("/#+([a-zA-Z0-9_]+)/i", $status, $hashtag);
					
					
					if(!empty($hashtag)){
						$getFromT->addTrend($status);
					}
					$getFromT->addMention($status,$user_id,$tweet_id);
				}else{	
					$error = "Type or choose image to tweet";
				}
			}

	?>

	<!--
	This template created by Meralesson.com 
	This template only use for educational purpose 
	-->
		<!DOCTYPE HTML> 
		<html>
			<head>
				<title>Home / Tweety</title>
				<meta charset="UTF-8" />
				<!-- <meta name="viewport" content="width=device-width"> -->
				<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1" />
				<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css"/>
                <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style-complete.css" />
				<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script> 
		
			</head>
			<!--Helvetica Neue-->
		<body >
		<?php
	include 'includes/entities/loader.php';
	?>
	<div class="wrapper">
	<!-- header wrapper -->
	
			<!-- ------------------------------------------------------------------------------------------------ -->
			
		<!-- ------------------------------------------------------------------------------------------------ -->
		<script type="text/javascript" src=""<?php echo BASE_URL; ?>assets/js/search.js"></script>
		<script type="text/javascript" src=""<?php echo BASE_URL; ?>assets/js/hashtag.js"></script>
	<!---Inner wrapper-->
	<div class="inner-wrapper">
	<div class="in-wrapper">
		<div class="in-full-wrap">
		<?php 
                include 'includes/entities/side-pro-link.php';
            ?>
			
				<div class="in-center">
					<div class="in-center-wrap">
						<!--Tweet SHOW WRAPPER-->
						
						<div class="tweets">
						
						<?php $getFromT->bookmarkTweets($user_id); ?>
					</div>
					<div class="loading-div">
						<img id="loader" src="<?php echo BASE_URL; ?>assets/images/loading.svg" style="display: none;"/> 
					</div>
					<div class="clear_fix" style="display:none; height:55px; width:100%;"></div>
					
						<!--TWEETS SHOW WRAPPER-->
						<div class="float-tweet" id="float-tweet">
						
						<i class="fa fa-leaf"></i>
						</div>

					
						<div class="popupTweet"></div>

<div class="alert hide">
         <span id="iconSign" class="fa "></span>
         <span class="msgs"> SOMETHING WENT WRONG ! </span>
         <div class="close-btn">
            <span class="fa fa-times"></span>
         </div>
</div>
						<!--Tweet END WRAPER-->
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
					</div><!-- in left wrap-->
				</div><!-- in center end -->
				
				<div class="in-right">
					
					<div class="in-right-wrap">
					<section class="search-engine">
								<div class="search-pro">
									<ul>
										<li>
											<i class="fa fa-search" aria-hidden="true"></i>
											<input type="text" placeholder="Search Twitter" class="search" />
											<div class="search-result">
											</div>
										</li>
									</ul>
								</div>
							</section>
					<!--Who To Follow-->


<!--==TRENDS==-->
		<div class="trend-wrapper">
            <div class="trend-inner">
            <div class="trend-title">
            <h3>
What’s happening</h3>
            </div>
            <!-- trend title end-->
					<?php $getFromT->trends();?>
					</div><!--TREND INNER END-->
            </div><!--TRENDS WRAPPER ENDS-->
<!--==TRENDS==-->

					<!--WHO_TO_FOLLOW HERE-->
					<?php $getFromF->whoToFollow($user_id,$user_id); ?>
					<!--Who To Follow-->


					</div><!-- in left wrap-->

				</div><!-- in right end -->
				
				
		
			</div><!--in full wrap end-->
			
		</div><!-- in wrappper ends-->
		</div><!-- inner wrapper ends-->
		
		</div><!-- ends wrapper -->
	
		<?php 
                include 'includes/entities/bottom-nav.php';
            ?>
			
</body>
</html>