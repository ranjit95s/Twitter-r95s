<?php
include 'core/init.php';
if (isset($_GET['username']) === true && empty($_GET['username']) === false) {

	$username = $getFromU->checkInput($_GET['username']);
	$profileId = $getFromU->userIdByUsername($username);
	$profileData = $getFromU->userData($profileId);
	$user_id = @$_SESSION['user_id'];
	$user = $getFromU->userData($user_id);

	// $userRef = $getFromT->getUserTweetsByID($user_id,$tweetId);


	$notify = $getFromM->getNotificationCount($user_id);
	$notification  = $getFromM->notification($user_id);


	if (!$profileData) {
		header('Location:' . BASE_URL . 'index.php');
	}


	if (isset($_POST['screenName'])) {
		if (!empty($_POST['screenName'])) {
			$screenName = $getFromU->checkInput($_POST['screenName']);
			$profileBio        = $getFromU->checkInput($_POST['bio']);
			$country    = $getFromU->checkInput($_POST['country']);
			$website    = $getFromU->checkInput($_POST['website']);

			if (strlen($screenName) > 20) {
				$error = "name must be between 6-20";
			} else if (strlen($profileBio) > 160) {
				$error = "Bio is too long";
			} else if (strlen($country) > 80) {
				$error = "Country name is too long";
			} else {
				$getFromU->update('users', $user_id, array('screenName' => $screenName, 'bio' => $profileBio, 'country' => $country, 'website' => $website));
				header('Location: ' . $user->username);
			}
		} else {
			$error = "Name field can't be blink";
		}
	}
	if (isset($_FILES['profileImage'])) {
		if (!empty($_FILES['profileImage']['name'][0])) {
			$fileRoot = $getFromU->uploadImage($_FILES['profileImage']);
			$getFromU->update('users', $user_id, array('profileImage' => $fileRoot));
			header('Location:' . $user->username);
		}
	}
	if (isset($_FILES['profileCover'])) {
		if (!empty($_FILES['profileCover']['name'][0])) {
			$fileRoot = $getFromU->uploadImage($_FILES['profileCover']);
			$getFromU->update('users', $user_id, array('profileCover' => $fileRoot));
			header('Location:' . $user->username);
		}
	}
}

?>

<!--
   This template created by Meralesson.com 
   This template only use for educational purpose 
-->
<!doctype html>
<html>

<head>
	<title><?php echo $profileData->screenName . ' (@' . $username . ')'; ?> / Tweety</title>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1" />
	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style-complete.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css" />
</head>
<!--Helvetica Neue-->

<body>
	<div class="wrapper">
		<!-- header wrapper -->
		
			<?php 
				
                include 'includes/entities/side-pro-link.php';
            ?>


				<div class="in-center">
					<div class="in-center-wrap">
						<div class="info-boxs">
							<div class="info-inner">
								<div class="info-in-head pro-head">
									<!-- PROFILE-COVER-IMAGE -->
									<img src="<?php echo BASE_URL.$profileData->profileCover; ?>" />
								</div><!-- info in head end -->
								<div class="info-in-body">
									<div class="in-b-box">
										<div class="in-b-img">
											<!-- PROFILE-IMAGE -->
											<img src="<?php echo BASE_URL.$profileData->profileImage; ?>" />
										</div>
									</div><!--  in b box end-->
									<div class="footer-upper-nav" style="position: relative;">
									<div class="info-body-name info-body-name-pro">
										<div class="in-b-name">
											<div><a href="<?php echo $profileData->username; ?>"><?php echo $profileData->screenName; ?></a></div>
											<span><small><a href="<?php echo $profileData->username; ?>">@<?php echo $profileData->username; ?></a></small></span>
										</div><!-- in b name end-->
									</div><!-- info body name end-->
								</div><!-- info in body end-->
								<div class="follo-pro">
									<span>
										<?php echo $getFromF->followBtn($profileId, $user_id, $profileData->user_id); ?>
										<button hidden id="popupEditForm">Edit Profile</button>
									</span>
								</div>
								</div>


								<!--  -->
								<div class="profile-extra-info">
									<div class="profile-extra-inner">
										<?php if (!empty($profileData->bio)) { ?>
											<ul>
												<li style="     margin: 5px 10px;
    font-size: 1.1rem;
    /* margin: 0; */
    color: var(--secondary-text-color);">
													<div class="bio" style="    margin-top: 60px;
    white-space: pre-line;">
														<?php echo $getFromT->getTweetLinks($profileData->bio); ?>
													</div>
												</li>
											</ul>
										<?php } ?>

										<div class="more-lol">
											<ul>

												<?php if (!empty($profileData->country)) { ?>
													<li>


														<!-- <div class="profile-ex-location-i">
				</div> -->
														<div class="profile-ex-location">
															<i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo $profileData->country; ?>
														</div>
													</li>
												<?php } ?>
												<?php if (!empty($profileData->website)) { ?>
													<li>
														<!-- <div class="profile-ex-location-i">
					
				</div> -->
														<div class="profile-ex-location">
															<i class="fa fa-link" aria-hidden="true"></i>
															<a href="<?php echo 'http://'.$profileData->website; ?>" target="_blink"><?php echo $profileData->website; ?></a>
														</div>
													</li>
												<?php } ?>
												<?php if (!empty($profileData->joinedOn)) { ?>
													<li>
														<!-- <div class="profile-ex-location-i">
					
				</div> -->
														<div class="profile-ex-location">
															<i class="fa fa-calendar-o" aria-hidden="true"></i> <?php echo " Joined On " . $getFromU->timeAgo($profileData->joinedOn); ?>
														</div>
													</li>
												<?php } ?>
												<!-- <li>
				<div class="profile-ex-location-i">
					<i class="fa fa-calendar-o" aria-hidden="true"></i>
				</div>
				<div class="profile-ex-location">
				</div>
			</li>
			<li>
				<div class="profile-ex-location-i">
					<i class="fa fa-tint" aria-hidden="true"></i>
				</div>
				<div class="profile-ex-location">
				</div>
			</li> -->
											</ul>
										</div>

										<div class="info-in-footer info-in-footer-pro">

<div class="number-wrapper">

	<div class="num-boxs">
		<div class="num-body">
			<a href="<?php echo BASE_URL . $profileData->username; ?>/following"><span class="count-following"><?php echo $profileData->following; ?> </span> <span class="num-name"> Following</span></a>
		</div>
	</div>
	<div class="num-boxs">
		<div class="num-body">
			<a href="<?php echo BASE_URL . $profileData->username; ?>/followers"><span class="count-followers"><?php echo $profileData->followers; ?> </span> <span class="num-name">Followers</span></a>
		</div>
	</div>
</div><!-- mumber wrapper-->
</div><!-- info in footer -->

									</div>
								</div>
								<div class="scroller">
									<ul class="scoller-ul">
												<?php
												function active($currect_page){
													// echo $currect_page;
												$url_array =  explode('/', $_SERVER['REQUEST_URI']) ;
												$url = end($url_array);  
											
												if($currect_page == $url){
													echo 'followActive activeText'; //class name in css 
												
												} 
												}
												?>
										<li class="<?php active($profileData->username);?>"> <a class="" href="<?php echo BASE_URL . $profileData->username; ?>"> <span><?php $getFromT->countTweets($profileData->user_id); ?></span> Tweets </a> </li>
										<li class="<?php active($profileData->username.'?with_replies');?>"> <a href="<?php echo BASE_URL . $profileData->username; ?>?with_replies"> Tweets & replies </a> </li>
										<li class="<?php active($profileData->username.'?media');?>"> <a href="<?php echo BASE_URL . $profileData->username; ?>?media"> Media </a> </li>
										<li class="<?php active($profileData->username.'?likes');?>"> <a href="<?php echo BASE_URL . $profileData->username; ?>?likes"> <span><?php $getFromT->countLikes($profileId); ?></span> Likes </a> </li>
									</ul>
								</div>
							</div><!-- info inner end -->
						</div><!-- info box end-->
						<!--Tweet SHOW WRAPER-->



						<?php if (strpos($_SERVER['REQUEST_URI'], '?media')) :?>
						<?php
							$tweets = $getFromT->getUserTweets($profileId);

							
							
							foreach ($tweets as $tweet) {
								$likes = $getFromT->likes($user_id, $tweet->tweetID);
								$retweet = $getFromT->checkRetweet($tweet->tweetID, $user_id);
								$retweets = $getFromT->checkRetweeTUser($tweet->tweetID);
								
								
								$us = 'Undefined';
								foreach($retweets as $product){
									$userTr = $getFromT->userData($product->retweet_userIDBy);
									$us = $product->retweet_tweetID;
								}
								
								
								$user = $getFromT->userData($tweet->tweetOwner);
								
								$userRefS = $getFromT->getUserTweetsByID($tweet->tweetRef,$tweet->tweetRefTo);
								$userOwnerTweet = $getFromT->getUserTweetsOwnerByID($tweet->tweetID , $tweet->tweetOwner);
								$userRefD = $getFromT->userData($tweet->tweetRefTo);
								
								// echo $us;
							


								if(!empty($tweet->tweetImage)) {

								echo '<div class="all-tweet" data-tweet="'.$tweet->tweetID.'" data-user="'.$user->username.'">
								
								<div class="container">
								<div class="tweet-outer">
									<div class="tweet-inner">
									
									'.((($us != 'Undefined' && $tweet->tweetID == $us) && $tweet->tweetOwner != $profileId) ? '<div class="retweet-has">
									<div class="retweet-info">
										<i class="fa fa-retweet"></i>
										<span> <a style="color: var( --secondary-text-color); font-weight: 700; text-decoration:none;" href="'.BASE_URL.$userTr->username.'"> '.(( $user_id === $profileId ) ? 'You' : $userTr->screenName).' Retweeted </a> </span>
									</div>
								</div>' : '' ).'
									
						
										<!-- flex-out S -->
										<div class="flex-out">
											<div class="img-user">
												<div class="img-inner">
												<a href="'.BASE_URL.$user->username.'">
												<img src="'.$user->profileImage.'"/>
												</a>
												</div>
											</div>
						
						
											<!-- sc-ur-status S -->
											<div class="sc-ur-status">
												<div class="header">
													
												'.(($tweet->tweetOwner === $user_id) ? '
										
												<div class="delete-op" data-tweet="'.$tweet->tweetID.'" > <i class="fa fa-ellipsis-v ellipsiss"></i> 
												<div class="d-t-b-u" id="d-t-b-u'.$tweet->tweetID.'">
												<div class="prop">
											   <label class="deleteTweet" data-tweet="'.$tweet->tweetID.'"> <span>Delete Tweet</span>  </label>
											   <i class="fa fa-close closes closes'.$tweet->tweetID.'"></i>
												</div>
												</div>
												</div>
												' : '').'
	
												<div class="text-warpper" style="margin: 0;
										display: flex;
										margin-right: 5px;
										flex-direction: row;
										line-height: 15px;
										
										overflow: hidden;
										min-width: 5vw;
										white-space: nowrap;
										text-overflow: ellipsis;
										max-width: 30vw;
										">
												<div class="useru">
												<h4> <a style="color: var( --primary-text-color); font-weight: 800; text-decoration:none;" href="'.BASE_URL.$user->username.'">'.$user->screenName.'</a></h4>
											</div>
											<div class="useru">
												<h4 style="color: var( --secondary-text-color); font-weight: 500;">  <a style="color: var( --secondary-text-color); font-weight: 500; text-decoration:none;" href="'.BASE_URL.$user->username.'">@'.$user->username.'</a> </h4>
											</div>
											</div>
													<div class="useru">
														<h4 style="color: var( --secondary-text-color); font-weight: 500;"> • '.$getFromT->timeAgo(($userOwnerTweet[0]->postedOn)).'</h4>
													</div>
												</div>
												<div class="status">
													<div class="s-in">
														<div class="sto">
														'.$getFromT->getTweetLinks($userOwnerTweet[0]->status).'
														</div>
													</div>
												</div>
	
												'.(!empty($userOwnerTweet[0]->tweetImage) ?
												'<!--tweet show head end-->
												<div class="imageContainer">
												<div class="imageProposal">
													<div class="imageContains">
													<img src="'.BASE_URL.$userOwnerTweet[0]->tweetImage.'" class="imagePopup" data-tweet="'.$userOwnerTweet[0]->tweetID.'" alt="">
													</div>
												</div>
											</div>
													<!--tweet show body end-->
													' : '' ).'
	
													'.( $tweet->tweetRef > 0 && (!empty($tweet->tweetRef))?'
	
	
								'.($tweet->tweetRef > 0 && $getFromT->checkTweetExistence($tweet->tweetRef) ? '
	
												<div class="refenceTweet" data-tweet="'.$tweet->tweetRef.'" data-user="'.$userRefD->username.'">
													<div class="ref-o">
						
														<div class="ref-flex">
						
															<div class="headerU">
																<div class="flex-ref-head">
																	<div class="imageU">
																	<a href="'.BASE_URL.$userRefD->username.'">
																	<img src="'.$userRefD->profileImage.'"/>
																	</a>
																	</div>
																	<div class="text-warpper" style="margin: 0;
										display: flex;
										margin-right: 5px;
										flex-direction: row;
										line-height: 15px;
										
										overflow: hidden;
										min-width: 5vw;
										white-space: nowrap;
										text-overflow: ellipsis;
										max-width: 30vw;
										">
																	<div class="userd">
																		<h4 style="color:var( --primary-text-color); font-weight: 800;"> <a style="color: var( --primary-text-color); font-weight: 800; text-decoration:none;" href="'.BASE_URL.$userRefD->username.'">'.$userRefD->screenName.'</a></h4>
																	</div>
																	<div class="userd">
																		<h4 style="color: var( --secondary-text-color); font-weight: 500;"> <a style="color: var( --secondary-text-color); font-weight: 500; text-decoration:none;" href="'.BASE_URL.$userRefD->username.'">@'.$userRefD->username.'</a></h4>
																	</div>
																	</div>
	
																	<div class="userd">
																		<h4 style="color: var( --secondary-text-color); font-weight: 500;"> • '.$getFromT->timeAgo(($userRefS[0]->postedOn)).'</h4>
																	</div>
																</div>
																<div class="ref-status">
																	<h6>'.$getFromT->getTweetLinks($userRefS[0]->status).'</h6>
																	</div>
																	
															</div>
														</div>
													</div>
													'.(!empty($userRefS[0]->tweetImage) ? 
												'<!--tweet show head end-->
												<div class="status-image">
														<img src="'.BASE_URL.$userRefS[0]->tweetImage.'" class="imagePopup" data-tweet="'.$userRefS[0]->tweetID.'" alt="">
													</div>
													<!--tweet show body end-->
													' : '' ).'
												
													
													</div>
													' : '<div class="deletedTweetExi"> <div class="inner-info-deleted"> This Tweet is unavailable. </div> </div>' ).'
													' : '' ).'
						
												<!-- bottom S -->
												<div class="bottom">
													<div class="icons-head">
														<div class="flex-icons">
															<ul>
															'.(($getFromU->loggedIn() ===true) ? '
																<li> <i class="fa fa-comment"></i> <span> '.$getFromT->countComments($tweet->tweetID).' </span> </li>
																
																<li> '.((isset($retweet['retweet_tweetID']) ? $tweet->tweetID === $retweet['retweet_tweetID'] OR $user_id == $retweet['retweet_userIDBy'] : '') ? 
																'<button id="retweet-options'.$tweet->tweetID.'" class="retweeted retweet-options" data-tweet="'.$tweet->tweetID.'" data-user="'.$tweet->tweetBy.'"><i class="fa fa-retweet" aria-hidden="true"></i><span class="retweetsCount">'.(($tweet->retweetCount > 0) ? $tweet->retweetCount : '').'</span></button>' : 
																'<button class="retweet-options" id="retweet-options'.$tweet->tweetID.'" data-tweet="'.$tweet->tweetID.'" data-user="'.$tweet->tweetBy.'"><i class="fa fa-retweet" aria-hidden="true"></i><span class="retweetsCount">'.(($tweet->retweetCount > 0) ? $tweet->retweetCount : '').'</span></button>').'
																<div class="op" id="op'.$tweet->tweetID.'">
																<ul>
																'.((isset($retweet['retweet_tweetID']) ? $tweet->tweetID === $retweet['retweet_tweetID'] OR $user_id == $retweet['retweet_userIDBy'] : '') ? 
																'<li class="justUndoCloneTweet" data-tweet="'.$tweet->tweetID.'" data-user="'.$tweet->tweetOwner.'" style="cursor:pointer;  border-right:1px solid;">Undo Rwtweet</li> ' : 
																'<li class="justCloneTweet" data-tweet="'.$tweet->tweetID.'" data-user="'.$tweet->tweetOwner.'" style="cursor:pointer;  border-right:1px solid;">Retweet</li> ').'
																
																<li class="retweet" style="cursor:pointer" data-tweet="'.$tweet->tweetID.'" data-user="'.$tweet->tweetBy.'">Quote Tweet</li> 
																<i title="close" style="color:var( --primary-text-color)" class="fa fa-close close'.$tweet->tweetID.'"></i>
																	</ul>
																</div>
																</li>
																
																<li> '.((isset($likes['likeOn']) ? $likes['likeOn'] === $tweet->tweetID : '') ? 
																'<button class="unlike-btn" data-tweet="'.$tweet->tweetID.'" data-user="'.$tweet->tweetBy.'"><i class="fa fa-heart" aria-hidden="true"></i><span class="likesCounter">'.(($tweet->likesCount > 0) ? $tweet->likesCount : '' ).'</span></button>' : 
																'<button class="like-btn" data-tweet="'.$tweet->tweetID.'" data-user="'.$tweet->tweetBy.'"><i class="fa fa-heart-o" aria-hidden="true"></i><span class="likesCounter">'.(($tweet->likesCount > 0) ? $tweet->likesCount : '' ).'</span></button>').' </li>
																
																<li> <i class="fa fa-share"></i> </li>
																' : '<li><button><i class="fa fa-comment"></i> <span> '.$getFromT->countComments($tweet->tweetID).' </span></button></li>
																	<li><button><i class="fa fa-retweet" aria-hidden="true"></i><span class="retweetsCount">'.(($tweet->retweetCount > 0) ? $tweet->retweetCount : '').'</span></button></li>	
																	<li><button><i class="fa fa-heart-o" aria-hidden="true"></i><span class="likesCounter">'.(($tweet->likesCount > 0) ? $tweet->likesCount : '' ).'</span></button></li>
																	<li> <i class="fa fa-share"></i> </li>').'
	
															</ul>
														</div>
													</div>
	
												</div>
	
												<!-- bottom E -->
											</div>
											<!-- sc-ur-status E -->
						
										</div>
										<!-- flex-out E -->
									</div>
								</div>
							</div>
					</div>';}
						} 
						?>
						<?php elseif (strpos($_SERVER['REQUEST_URI'], '?likes')) : ?>
							<?php
								$tweets = $getFromT->getUserTweetsByLiked($profileId);

								if(empty($tweets)){echo '<div class="emptyBox" style="    color: var( --primary-theme-color);
									display: flex;
									position: relative;
									font-size: 1.6rem;
									padding: 15px;
									width: 100%;
									justify-content: center;
									top: 50px;
									font-weight: 600;"> <div class="center-box"> <span> Nothing to see here — yet </span> </div> </div>';}
							
								foreach ($tweets as $tweet) {
									$likes = $getFromT->likes($user_id, $tweet->tweetID);
									$retweet = $getFromT->checkRetweet($tweet->tweetID, $user_id);
									$retweets = $getFromT->checkRetweeTUser($tweet->tweetID);
									
									
									$us = 'Undefined';
									foreach($retweets as $product){
										$userTr = $getFromT->userData($product->retweet_userIDBy);
										$us = $product->retweet_tweetID;
									}
									
									
									$user = $getFromT->userData($tweet->tweetOwner);
									
									$userRefS = $getFromT->getUserTweetsByID($tweet->tweetRef,$tweet->tweetRefTo);
									$userOwnerTweet = $getFromT->getUserTweetsOwnerByID($tweet->tweetID , $tweet->tweetOwner);
									$userRefD = $getFromT->userData($tweet->tweetRefTo);
									
									// echo $us;
								
									echo '<div class="all-tweet" data-tweet="'.$tweet->tweetID.'" data-user="'.$user->username.'">
									
									<div class="container">
									<div class="tweet-outer">
										<div class="tweet-inner">
										
										'.((($us != 'Undefined' && $tweet->tweetID == $us) && $tweet->tweetOwner != $profileId) ? '<div class="retweet-has">
										<div class="retweet-info">
											<i class="fa fa-retweet"></i>
											<span> <a style="color: var( --secondary-text-color); font-weight: 700; text-decoration:none;" href="'.BASE_URL.$userTr->username.'"> '.(( $user_id === $profileId ) ? 'You' : $userTr->screenName).' Retweeted </a> </span>
										</div>
									</div>' : '' ).'
										
							
											<!-- flex-out S -->
											<div class="flex-out">
												<div class="img-user">
													<div class="img-inner">
													<a href="'.BASE_URL.$user->username.'">
													<img src="'.$user->profileImage.'"/>
													</a>
													</div>
												</div>
							
							
												<!-- sc-ur-status S -->
												<div class="sc-ur-status">
													<div class="header">
														
													'.(($tweet->tweetOwner === $user_id) ? '
											
													<div class="delete-op" data-tweet="'.$tweet->tweetID.'" > <i class="fa fa-ellipsis-v ellipsiss"></i> 
													<div class="d-t-b-u" id="d-t-b-u'.$tweet->tweetID.'">
													<div class="prop">
												   <label class="deleteTweet" data-tweet="'.$tweet->tweetID.'"> <span>Delete Tweet</span>  </label>
												   <i class="fa fa-close closes closes'.$tweet->tweetID.'"></i>
													</div>
													</div>
													</div>
													' : '').'
		
													<div class="text-warpper" style="margin: 0;
											display: flex;
											margin-right: 5px;
											flex-direction: row;
											line-height: 15px;
											
											overflow: hidden;
											min-width: 5vw;
											white-space: nowrap;
											text-overflow: ellipsis;
											max-width: 30vw;
											">
													<div class="useru">
													<h4> <a style="color: var( --primary-text-color); font-weight: 800; text-decoration:none;" href="'.BASE_URL.$user->username.'">'.$user->screenName.'</a></h4>
												</div>
												<div class="useru">
													<h4 style="color: var( --secondary-text-color); font-weight: 500;">  <a style="color: var( --secondary-text-color); font-weight: 500; text-decoration:none;" href="'.BASE_URL.$user->username.'">@'.$user->username.'</a> </h4>
												</div>
												</div>
														<div class="useru">
															<h4 style="color: var( --secondary-text-color); font-weight: 500;"> • '.$getFromT->timeAgo(($userOwnerTweet[0]->postedOn)).'</h4>
														</div>
													</div>
													<div class="status">
														<div class="s-in">
															<div class="sto">
															'.$getFromT->getTweetLinks($userOwnerTweet[0]->status).'
															</div>
														</div>
													</div>
		
													'.(!empty($userOwnerTweet[0]->tweetImage) ?
													'<!--tweet show head end-->
													<div class="imageContainer">
													<div class="imageProposal">
														<div class="imageContains">
														<img src="'.BASE_URL.$userOwnerTweet[0]->tweetImage.'" class="imagePopup" data-tweet="'.$userOwnerTweet[0]->tweetID.'" alt="">
														</div>
													</div>
												</div>
														<!--tweet show body end-->
														' : '' ).'
		
														'.( $tweet->tweetRef > 0 && (!empty($tweet->tweetRef))?'
		
		
									'.($tweet->tweetRef > 0 && $getFromT->checkTweetExistence($tweet->tweetRef) ? '
		
													<div class="refenceTweet" data-tweet="'.$tweet->tweetRef.'" data-user="'.$userRefD->username.'">
														<div class="ref-o">
							
															<div class="ref-flex">
							
																<div class="headerU">
																	<div class="flex-ref-head">
																		<div class="imageU">
																		<a href="'.BASE_URL.$userRefD->username.'">
																		<img src="'.$userRefD->profileImage.'"/>
																		</a>
																		</div>
																		<div class="text-warpper" style="margin: 0;
											display: flex;
											margin-right: 5px;
											flex-direction: row;
											line-height: 15px;
											
											overflow: hidden;
											min-width: 5vw;
											white-space: nowrap;
											text-overflow: ellipsis;
											max-width: 30vw;
											">
																		<div class="userd">
																			<h4 style="color: var( --primary-text-color); font-weight: 800;"> <a style="color: var( --primary-text-color); font-weight: 800; text-decoration:none;" href="'.BASE_URL.$userRefD->username.'">'.$userRefD->screenName.'</a></h4>
																		</div>
																		<div class="userd">
																			<h4 style="color: var( --secondary-text-color); font-weight: 500;"> <a style="color: var( --secondary-text-color); font-weight: 500; text-decoration:none;" href="'.BASE_URL.$userRefD->username.'">@'.$userRefD->username.'</a></h4>
																		</div>
																		</div>
		
																		<div class="userd">
																			<h4 style="color: var( --secondary-text-color); font-weight: 500;"> • '.$getFromT->timeAgo(($userRefS[0]->postedOn)).'</h4>
																		</div>
																	</div>
																	<div class="ref-status">
																		<h6>'.$getFromT->getTweetLinks($userRefS[0]->status).'</h6>
																		</div>
																		
																</div>
															</div>
														</div>
														'.(!empty($userRefS[0]->tweetImage) ? 
													'<!--tweet show head end-->
													<div class="status-image">
															<img src="'.BASE_URL.$userRefS[0]->tweetImage.'" class="imagePopup" data-tweet="'.$userRefS[0]->tweetID.'" alt="">
														</div>
														<!--tweet show body end-->
														' : '' ).'
													
														
														</div>
														' : '<div class="deletedTweetExi"> <div class="inner-info-deleted"> This Tweet is unavailable. </div> </div>' ).'
														' : '' ).'
							
													<!-- bottom S -->
													<div class="bottom">
														<div class="icons-head">
															<div class="flex-icons">
																<ul>
																'.(($getFromU->loggedIn() ===true) ? '
																	<li> <i class="fa fa-comment"></i> <span> '.$getFromT->countComments($tweet->tweetID).' </span> </li>
																	
																	<li> '.((isset($retweet['retweet_tweetID']) ? $tweet->tweetID === $retweet['retweet_tweetID'] OR $user_id == $retweet['retweet_userIDBy'] : '') ? 
																	'<button id="retweet-options'.$tweet->tweetID.'" class="retweeted retweet-options" data-tweet="'.$tweet->tweetID.'" data-user="'.$tweet->tweetBy.'"><i class="fa fa-retweet" aria-hidden="true"></i><span class="retweetsCount">'.(($tweet->retweetCount > 0) ? $tweet->retweetCount : '').'</span></button>' : 
																	'<button class="retweet-options" id="retweet-options'.$tweet->tweetID.'" data-tweet="'.$tweet->tweetID.'" data-user="'.$tweet->tweetBy.'"><i class="fa fa-retweet" aria-hidden="true"></i><span class="retweetsCount">'.(($tweet->retweetCount > 0) ? $tweet->retweetCount : '').'</span></button>').'
																	<div class="op" id="op'.$tweet->tweetID.'">
																	<ul>
																	'.((isset($retweet['retweet_tweetID']) ? $tweet->tweetID === $retweet['retweet_tweetID'] OR $user_id == $retweet['retweet_userIDBy'] : '') ? 
																	'<li class="justUndoCloneTweet" data-tweet="'.$tweet->tweetID.'" data-user="'.$tweet->tweetOwner.'" style="cursor:pointer;  border-right:1px solid;">Undo Rwtweet</li> ' : 
																	'<li class="justCloneTweet" data-tweet="'.$tweet->tweetID.'" data-user="'.$tweet->tweetOwner.'" style="cursor:pointer;  border-right:1px solid;">Retweet</li> ').'
																	
																	<li class="retweet" style="cursor:pointer" data-tweet="'.$tweet->tweetID.'" data-user="'.$tweet->tweetBy.'">Quote Tweet</li> 
																	<i title="close" style="color:var( --primary-text-color)" class="fa fa-close close'.$tweet->tweetID.'"></i>
																		</ul>
																	</div>
																	</li>
																	
																	<li> '.((isset($likes['likeOn']) ? $likes['likeOn'] === $tweet->tweetID : '') ? 
																	'<button class="unlike-btn" data-tweet="'.$tweet->tweetID.'" data-user="'.$tweet->tweetBy.'"><i class="fa fa-heart" aria-hidden="true"></i><span class="likesCounter">'.(($tweet->likesCount > 0) ? $tweet->likesCount : '' ).'</span></button>' : 
																	'<button class="like-btn" data-tweet="'.$tweet->tweetID.'" data-user="'.$tweet->tweetBy.'"><i class="fa fa-heart-o" aria-hidden="true"></i><span class="likesCounter">'.(($tweet->likesCount > 0) ? $tweet->likesCount : '' ).'</span></button>').' </li>
																	
																	<li> <i class="fa fa-share"></i> </li>
																	' : '<li><button><i class="fa fa-comment"></i> <span> '.$getFromT->countComments($tweet->tweetID).' </span></button></li>
																		<li><button><i class="fa fa-retweet" aria-hidden="true"></i><span class="retweetsCount">'.(($tweet->retweetCount > 0) ? $tweet->retweetCount : '').'</span></button></li>	
																		<li><button><i class="fa fa-heart-o" aria-hidden="true"></i><span class="likesCounter">'.(($tweet->likesCount > 0) ? $tweet->likesCount : '' ).'</span></button></li>
																		<li> <i class="fa fa-share"></i> </li>').'
		
																</ul>
															</div>
														</div>
		
													</div>
		
													<!-- bottom E -->
												</div>
												<!-- sc-ur-status E -->
							
											</div>
											<!-- flex-out E -->
										</div>
									</div>
								</div>
						</div>';
							} 
							?>
							<?php else : ?>
								<?php $tweets = $getFromT->getUserTweets($profileId);
						foreach ($tweets as $tweet) {
							$likes = $getFromT->likes($user_id, $tweet->tweetID);
							$retweet = $getFromT->checkRetweet($tweet->tweetID, $user_id);
							$retweets = $getFromT->checkRetweeTUser($tweet->tweetID);

							
							$us = 'Undefined';
							foreach($retweets as $product){
								$userTr = $getFromT->userData($product->retweet_userIDBy);
								$us = $product->retweet_tweetID;
							}


								$user = $getFromT->userData($tweet->tweetOwner);
						
								$userRefS = $getFromT->getUserTweetsByID($tweet->tweetRef,$tweet->tweetRefTo);
								$userOwnerTweet = $getFromT->getUserTweetsOwnerByID($tweet->tweetID , $tweet->tweetOwner);
								$userRefD = $getFromT->userData($tweet->tweetRefTo);
						
							// echo $us;
							echo '<div class="all-tweet" data-tweet="'.$tweet->tweetID.'" data-user="'.$user->username.'">
							<div class="container">
							<div class="tweet-outer">
								<div class="tweet-inner">
								
								'.((($us != 'Undefined' && $tweet->tweetID == $us) && $tweet->tweetOwner != $profileId) ? '<div class="retweet-has">
								<div class="retweet-info">
									<i class="fa fa-retweet"></i>
									<span> <a style="color: var( --seconadry-text-color); font-weight: 700; text-decoration:none;" href="'.BASE_URL.$userTr->username.'"> '.(( $user_id === $profileId ) ? 'You' : $userTr->screenName).' Retweeted </a> </span>
								</div>
							</div>' : '' ).'
								
					
									<!-- flex-out S -->
									<div class="flex-out">
										<div class="img-user">
											<div class="img-inner">
											<a href="'.BASE_URL.$user->username.'">
											<img src="'.$user->profileImage.'"/>
											</a>
											</div>
										</div>
					
					
										<!-- sc-ur-status S -->
										<div class="sc-ur-status">
											<div class="header">
												
											'.(($tweet->tweetOwner === $user_id) ? '
                                    
											<div class="delete-op" data-tweet="'.$tweet->tweetID.'" > <i class="fa fa-ellipsis-v ellipsiss"></i> 
											<div class="d-t-b-u" id="d-t-b-u'.$tweet->tweetID.'">
											<div class="prop">
										   <label class="deleteTweet" data-tweet="'.$tweet->tweetID.'"> <span>Delete Tweet</span>  </label>
										   <i class="fa fa-close closes closes'.$tweet->tweetID.'"></i>
											</div>
											</div>
											</div>
											' : '').'

											<div class="text-warpper" style="margin: 0;
                                    display: flex;
                                    margin-right: 5px;
                                    flex-direction: row;
                                    line-height: 15px;
                                    
                                    overflow: hidden;
                                    min-width: 5vw;
                                    white-space: nowrap;
                                    text-overflow: ellipsis;
                                    max-width: 30vw;
                                    ">
											<div class="useru">
											<h4> <a style="color: var( --primary-text-color); font-weight: 800; text-decoration:none;" href="'.BASE_URL.$user->username.'">'.$user->screenName.'</a></h4>
										</div>
										<div class="useru">
											<h4 style="color: var( --secondary-text-color); font-weight: 500;">  <a style="color: var( --secondary-text-color); font-weight: 500; text-decoration:none;" href="'.BASE_URL.$user->username.'">@'.$user->username.'</a> </h4>
										</div>
										</div>
												<div class="useru">
													<h4 style="color: var( --secondary-text-color); font-weight: 500;"> • '.$getFromT->timeAgo(($userOwnerTweet[0]->postedOn)).'</h4>
												</div>
											</div>
											<div class="status">
												<div class="s-in">
													<div class="sto">
													'.$getFromT->getTweetLinks($userOwnerTweet[0]->status).'
													</div>
												</div>
											</div>

											'.(!empty($userOwnerTweet[0]->tweetImage) ?
                                            '<!--tweet show head end-->
											<div class="imageContainer">
											<div class="imageProposal">
												<div class="imageContains">
												<img src="'.BASE_URL.$userOwnerTweet[0]->tweetImage.'" class="imagePopup" data-tweet="'.$userOwnerTweet[0]->tweetID.'" alt="">
												</div>
											</div>
										</div>
                                                <!--tweet show body end-->
                                                ' : '' ).'

												'.( $tweet->tweetRef > 0 && (!empty($tweet->tweetRef))?'


                            '.($tweet->tweetRef > 0 && $getFromT->checkTweetExistence($tweet->tweetRef) ? '

											<div class="refenceTweet" data-tweet="'.$tweet->tweetRef.'" data-user="'.$userRefD->username.'">
												<div class="ref-o">
					
													<div class="ref-flex">
					
														<div class="headerU">
															<div class="flex-ref-head">
																<div class="imageU">
																<a href="'.BASE_URL.$userRefD->username.'">
																<img src="'.$userRefD->profileImage.'"/>
																</a>
																</div>
																<div class="text-warpper" style="margin: 0;
                                    display: flex;
                                    margin-right: 5px;
                                    flex-direction: row;
                                    line-height: 15px;
                                    
                                    overflow: hidden;
                                    min-width: 5vw;
                                    white-space: nowrap;
                                    text-overflow: ellipsis;
                                    max-width: 30vw;
                                    ">
																<div class="userd">
																	<h4 style="color: var( --primary-text-color); font-weight: 800;"> <a style="color: var( --primary-text-color); font-weight: 800; text-decoration:none;" href="'.BASE_URL.$userRefD->username.'">'.$userRefD->screenName.'</a></h4>
																</div>
																<div class="userd">
																	<h4 style="color: var( --secondary-text-color); font-weight: 500;"> <a style="color: var( --secondary-text-color); font-weight: 500; text-decoration:none;" href="'.BASE_URL.$userRefD->username.'">@'.$userRefD->username.'</a></h4>
																</div>
																</div>

																<div class="userd">
																	<h4 style="color: var( --secondary-text-color); font-weight: 500;"> • '.$getFromT->timeAgo(($userRefS[0]->postedOn)).'</h4>
																</div>
															</div>
															<div class="ref-status">
																<h6>'.$getFromT->getTweetLinks($userRefS[0]->status).'</h6>
																</div>
																
														</div>
													</div>
												</div>
												'.(!empty($userRefS[0]->tweetImage) ?'
												<!--tweet show head end-->
											<div class="status-image">
													<img src="'.BASE_URL.$userRefS[0]->tweetImage.'" class="imagePopup" data-tweet="'.$userRefS[0]->tweetID.'" alt="">
												</div>
                                                <!--tweet show body end-->
                                                ' : '' ).'
											
												
												</div>
												' : '<div class="deletedTweetExi"> <div class="inner-info-deleted"> This Tweet is unavailable. </div> </div>' ).'
												' : '' ).'
					
											<!-- bottom S -->
											<div class="bottom">
												<div class="icons-head">
													<div class="flex-icons">
														<ul>
														'.(($getFromU->loggedIn() ===true) ? '
															<li> <i class="fa fa-comment"></i> <span> '.$getFromT->countComments($tweet->tweetID).' </span> </li>
															
															<li> '.((isset($retweet['retweet_tweetID']) ? $tweet->tweetID === $retweet['retweet_tweetID'] OR $user_id == $retweet['retweet_userIDBy'] : '') ? 
															'<button id="retweet-options'.$tweet->tweetID.'" class="retweeted retweet-options" data-tweet="'.$tweet->tweetID.'" data-user="'.$tweet->tweetBy.'"><i class="fa fa-retweet" aria-hidden="true"></i><span class="retweetsCount">'.(($tweet->retweetCount > 0) ? $tweet->retweetCount : '').'</span></button>' : 
															'<button class="retweet-options" id="retweet-options'.$tweet->tweetID.'" data-tweet="'.$tweet->tweetID.'" data-user="'.$tweet->tweetBy.'"><i class="fa fa-retweet" aria-hidden="true"></i><span class="retweetsCount">'.(($tweet->retweetCount > 0) ? $tweet->retweetCount : '').'</span></button>').'
															<div class="op" id="op'.$tweet->tweetID.'">
															<ul>
															'.((isset($retweet['retweet_tweetID']) ? $tweet->tweetID === $retweet['retweet_tweetID'] OR $user_id == $retweet['retweet_userIDBy'] : '') ? 
															'<li class="justUndoCloneTweet" data-tweet="'.$tweet->tweetID.'" data-user="'.$tweet->tweetOwner.'" style="cursor:pointer;  border-right:1px solid;">Undo Rwtweet</li> ' : 
															'<li class="justCloneTweet" data-tweet="'.$tweet->tweetID.'" data-user="'.$tweet->tweetOwner.'" style="cursor:pointer;  border-right:1px solid;">Retweet</li> ').'
															
															<li class="retweet" style="cursor:pointer" data-tweet="'.$tweet->tweetID.'" data-user="'.$tweet->tweetBy.'">Quote Tweet</li> 
															<i title="close" style="color:var( --primary-text-color)" class="fa fa-close close'.$tweet->tweetID.'"></i>
															</ul>
															</div>
															</li>
															
															<li> '.((isset($likes['likeOn']) ? $likes['likeOn'] === $tweet->tweetID : '') ? 
															'<button class="unlike-btn" data-tweet="'.$tweet->tweetID.'" data-user="'.$tweet->tweetBy.'"><i class="fa fa-heart" aria-hidden="true"></i><span class="likesCounter">'.(($tweet->likesCount > 0) ? $tweet->likesCount : '' ).'</span></button>' : 
															'<button class="like-btn" data-tweet="'.$tweet->tweetID.'" data-user="'.$tweet->tweetBy.'"><i class="fa fa-heart-o" aria-hidden="true"></i><span class="likesCounter">'.(($tweet->likesCount > 0) ? $tweet->likesCount : '' ).'</span></button>').' </li>
															
															<li> <i class="fa fa-share"></i> </li>
															' : '<li><button><i class="fa fa-comment"></i> <span> '.$getFromT->countComments($tweet->tweetID).' </span></button></li>
																<li><button><i class="fa fa-retweet" aria-hidden="true"></i><span class="retweetsCount">'.(($tweet->retweetCount > 0) ? $tweet->retweetCount : '').'</span></button></li>	
																<li><button><i class="fa fa-heart-o" aria-hidden="true"></i><span class="likesCounter">'.(($tweet->likesCount > 0) ? $tweet->likesCount : '' ).'</span></button></li>
																<li> <i class="fa fa-share"></i> </li>').'

														</ul>
													</div>
												</div>

											</div>

											<!-- bottom E -->
										</div>
										<!-- sc-ur-status E -->
					
									</div>
									<!-- flex-out E -->
								</div>
							</div>
						</div>
				</div>';
						} 	?>

								<div class="clear_fix" style="display:none; height:55px; width:100%;"></div>
					</div>
				</div>
								<?php endif; ?>


							<div class="clear_fix" style="display:none; height:55px; width:100%;"></div>
						<!--Tweet SHOW WRAPER END-->
					</div><!-- in left wrap-->
					<div class="float-tweet" id="float-tweet">

						<i class="fa fa-leaf"></i>
					</div>
					<div class="popupTweet"></div>

					<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/custome-complete-js.js"></script>
					<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/like.js"></script>
					<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/retweet.js"></script>
					<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/popuptweets.js"></script>
					<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/delete.js"></script>
					<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/comment.js"></script>
					<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/popupForm.js"></script>
					<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/fetch.js"></script>
					<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/search.js"></script>
					<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/hashtag.js"></script>
					<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/messages.js"></script>
					<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/postMessage.js"></script>
					<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/notification.js"></script>
					<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/popupEditForm.js"></script>


				</div>
				<!-- in center end -->

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
						<!--==WHO TO FOLLOW==-->
						<?php $getFromF->whoToFollow($user_id, $profileId); ?>
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
				</div>
				<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/follow.js"></script>

				<!-- in right end -->

			</div>
			<!--in full wrap end-->
		</div>
		<!-- in wrappper ends-->
	</div>



	<!-- ends wrapper -->
	<?php 
                include 'includes/entities/bottom-nav.php';
            ?>

</body>
</html>