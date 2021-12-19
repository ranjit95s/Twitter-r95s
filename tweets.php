<?php
include 'core/init.php';
if ((isset($_GET['username']) === true && empty($_GET['username']) === false) && (isset($_GET['tweetID']) === true && empty($_GET['tweetID']) === false) ) {

	$username = $getFromU->checkInput($_GET['username']);
	$tweetID = $_GET['tweetID'];
	$profileId = $getFromU->userIdByUsername($username);
	$profileData = $getFromU->userData($profileId);
	$user_id = @$_SESSION['user_id'];
	$user = $getFromU->userData($user_id);
	$notify = $getFromM->getNotificationCount($user_id);
	$notification  = $getFromM->notification($user_id);


	$noTweetdata = $getFromT->checkTweetExistence($tweetID);
	if (!$noTweetdata) {
		header('Location:' . BASE_URL . 'home.php');
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
	<title><?php echo $profileData->screenName . ' (@' . $tweetID . ')'; ?> / Tweety</title>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1" />
	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style-complete.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css" />
</head>
<!--Helvetica Neue-->

<!-- <style>
* {
	/* box-sizing: border-box !important; */
}
</style> -->

<body>
<div class="wrapper">
		<!-- header wrapper -->
		
			<?php 
				
                include 'includes/entities/side-pro-link.php';
            ?>


				<div class="in-center">
					<div class="in-center-wrap">
			



					<?php if (strpos($_SERVER['REQUEST_URI'], '?retweet_with_comments')) :?>
					
						<?php
								$tweets = $getFromT->getRetweetQuotes($tweetID);

								if(empty($tweets)){echo '<div class="emptyBox" style="    color: var( --secondary-text-color);
									display: flex;
									position: relative;
									font-size:1.6rem;
									padding: 15px;
									top: 50px;
									font-weight: 600;"> <div class="center-box"> <span> Nothing to see here — yet </span> </div> </div>';}
							
								foreach ($tweets as $tweet) {
									$likes = $getFromT->likes($user_id, $tweet->tweetID);
									$retweet = $getFromT->checkRetweet($tweet->tweetID, $user_id);
									$retweets = $getFromT->checkRetweeTUser($tweet->tweetID);
									
									
									// $us = 'Undefined';
									// foreach($retweets as $product){
									// 	$userTr = $getFromT->userData($product->retweet_userIDBy);
									// 	$us = $product->retweet_tweetID;
									// }
									
									
									$user = $getFromT->userData($tweet->tweetOwner);
									
									$userRefS = $getFromT->getUserTweetsByID($tweet->tweetRef,$tweet->tweetRefTo);
									$userOwnerTweet = $getFromT->getUserTweetsOwnerByID($tweet->tweetID , $tweet->tweetOwner);
									$userRefD = $getFromT->userData($tweet->tweetRefTo);
									
									// echo $us;
									echo '	 

									<div class="backBtn" style="    color: var( --secondary-text-color);
									background: var( --primary-background-color);
									padding: 10px;
									border-bottom: 1px solid var( --primary-border-color);
									display: flex;
									font-size: 1.2rem;
									align-items: center;">
										<i class="fa fa-angle-left backtweetsarrow" onclick="window.history.back()" style="margin: 0;
										margin-left: 8px;
										font-weight: 900;
										padding: 10px 15.5px;
										cursor:pointer;
										border-radius: 50%;"></i>
										<span style="    margin: 0;
										margin-left: 15px;
										font-weight: 600;
										letter-spacing: 2px;"> Tweet </span>
									</div>
									';
									echo '<div class="all-tweet" data-tweet="'.$tweet->tweetID.'" data-user="'.$user->username.'">
									
									<div class="container">
									<div class="tweet-outer">
										<div class="tweet-inner">
	
											<!-- flex-out S -->
											<div class="flex-out">
												<div class="img-user">
													<div class="img-inner">
													<a href="'.BASE_URL.$user->username.'">
													<img src="'.BASE_URL.$user->profileImage.'"/>
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
													<h4 style="color: grey; font-weight: 500;">  <a style="color: grey; font-weight: 500; text-decoration:none;" href="'.BASE_URL.$user->username.'">@'.$user->username.'</a> </h4>
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
														<img style="cursor:pointer;" src="'.BASE_URL.$userOwnerTweet[0]->tweetImage.'" class="imagePopup" data-tweet="'.$userOwnerTweet[0]->tweetID.'" alt="">
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
																		<img src="'.BASE_URL.$userRefD->profileImage.'"/>
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
															<img style="cursor:pointer;" src="'.BASE_URL.$userRefS[0]->tweetImage.'" class="imagePopup" data-tweet="'.$userRefS[0]->tweetID.'" alt="">
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
						</div>
						
						';
							} 

						

							?>

					<?php else : ?> 	
						<?php
							// $tweets = $getFromT->getUserTweets($profileId);
							$userTstatus = $getFromT->getPopupTweet($tweetID);
							
							
								
								$retweets = $getFromT->checkRetweeTUser($userTstatus->tweetID);
								$comments = $getFromT->comments($tweetID);
								
								$us = 'Undefined';
								foreach($retweets as $product){
									$userTr = $getFromT->userData($product->retweet_userIDBy);
									$us = $product->retweet_tweetID;
									$su = $product->retweet_userIDBy;
									// print_r($userTr);
								}

								

								$booleanConnection = false;
								$booleanConnectionRef1 = false;
								$booleanConnectionRef2 = false;
								
								
								
								if($userTstatus->commentTrue != 0 && $userTstatus->comment_tweetID != 0 && $userTstatus->comment_userID != 0){
									$hasConnection = $getFromT->getPopupTweetRef($userTstatus->tweetID);

								$retweets1 = $getFromT->checkRetweeTUser($hasConnection->tweetID);
								$us1 = 'Undefined';
								foreach($retweets1 as $product){
									$userTr1 = $getFromT->userData($product->retweet_userIDBy);
									$us1 = $product->retweet_tweetID;
									$su1 = $product->retweet_userIDBy;
									// print_r($userTr1->username);
								}
									
									if($hasConnection->comment_tweetID != 0){
										$booleanConnectionRef1 = true;
									}
									$booleanConnection = true;
									
									if ($hasConnection->tweetRef) {
										$hasConnectionRef = $getFromT->getPopupTweet($hasConnection->tweetRef);
										if($hasConnectionRef->comment_tweetID != 0){
											$booleanConnectionRef2 = true;
										}
									}									
								}
								
								
								// $user = $getFromT->userData($tweet->tweetOwner);
								
								$userRefS = $getFromT->getUserTweetsByID($userTstatus->tweetRef,$userTstatus->tweetRefTo);
								// $userOwnerTweet = $getFromT->getUserTweetsOwnerByID($tweet->tweetID , $tweet->tweetOwner);
								$userRefD = $getFromT->userData($userTstatus->tweetRefTo);
								
								// echo $us;
								echo '	 

									<div class="backBtn" style="    color: var( --primary-text-color);
									background: var( --primary-background-color);
									padding: 10px;
									border-bottom: 1px solid var( --primary-border-color);
									display: flex;
									font-size: 1.2rem;
									align-items: center;">
										<i class="fa fa-angle-left backtweetsarrow" onclick="window.history.back()" style="margin: 0;
										margin-left: 8px;
										font-weight: 900;
										padding: 10px 15.5px;
										cursor:pointer;
										border-radius: 50%;"></i>
										<span style="    margin: 0;
										margin-left: 15px;
										font-weight: 600;
										letter-spacing: 2px;"> Tweet </span>
									</div>

									';
								echo '
							
								<div class="all-tweets" style="margin-top: -5px;">
								
								<div class="containerTweets">
								<!-- innerContainerStart -->
								<div class="border-bottom">
								<div class="innerContainer">
									<!-- innnerr-inner -->
									<div class="inner-usero">';

									if($userTstatus->commentTrue != 0 && $userTstatus->comment_tweetID != 0 && $userTstatus->comment_userID != 0){
										$likes = $getFromT->likes($user_id, $hasConnection->tweetID);
										$retweet = $getFromT->checkRetweet($hasConnection->tweetID, $user_id);
										$retweets = $getFromT->checkRetweeTUser($hasConnection->tweetID);
										$comments = $getFromT->comments($tweetID);
echo '

								<div class="userTweet-flex userTweet" data-tweet="'.$hasConnection->tweetID.'" data-user="'.$hasConnection->username.'">
									<div class="lineConnector"></div>
									
									<div class="proImage">
										<img src="'.BASE_URL.$hasConnection->profileImage.'" alt="">
									</div>
									<div class="userTweet2">
									'.((($us1 != 'Undefined' && $hasConnection->tweetID == $us1)) ? '<div class="retweet-has1 retweet-has">
										<div class="retweet-info">
											<i class="fa fa-retweet"></i>
											<span> <a style="color: var( --secondary-text-color); font-weight: 700; text-decoration:none;" href="'.BASE_URL.$userTr1->username.'"> '.(( $su1 != 'Undefined' && $user_id === $su1 ) ? 'You' : $userTr1->screenName).' Retweeted </a> </span>
										</div>
									</div>' : '' ).'
										<div class=" userInfoT ">
											<div class="userInfoT-flex userInfoIn">
												<h4 class="" > <a style="font-weight: 700;" href="'.BASE_URL.$hasConnection->username.'"> '.$hasConnection->screenName.' </a> </h4>
												<h4 class="username"> <a href="'.BASE_URL.$hasConnection->username.'"> @'.$hasConnection->username.' </a> </h4>
												<h4 class="username">  • '.$getFromT->timeAgo(($hasConnection->postedOn)).'  </h4>
												'.(($hasConnection->tweetOwner === $user_id) ? '
                                    
												<div class="delete-op" data-tweet="'.$hasConnection->tweetID.'" > <i class="fa fa-ellipsis-v ellipsiss" tabindex="1"></i> 
												<div class="d-t-b-u" id="d-t-b-u'.$hasConnection->tweetID.'">
												<div class="prop">
											   <label class="deleteTweet" data-tweet="'.$hasConnection->tweetID.'" data-re="'.$hasConnection->tweetRef.'" data-ret="'.$hasConnection->tweetRefTo.'"> <span>Delete Tweet</span>  </label>
											   <i class="fa fa-close closes closes'.$hasConnection->tweetID.'"></i>
												</div>
												</div>
												</div>
												' : '').'
				
											</div>
										</div>

										'.(($booleanConnectionRef1 == true) ? 
										'<div class="replying-to"> <span> Replying to <a href="#"> @'.$getFromT->userData($hasConnection->comment_userID)->username.' </a> </span> </div>
											' : '' ).' 
										
										<div class="status-flex status">
											<div class="swi67h">
											'.$getFromT->getTweetLinks($hasConnection->status).'
											</div>
										
											'.(!empty($hasConnection->tweetImage) ?'
											<div class="status-huh678">
												<img src="'.BASE_URL.$hasConnection->tweetImage.'" alt="">
											</div>
												' : '' ).'

												'.( $hasConnection->tweetRef > 0 && (!empty($hasConnection->tweetRef))?'
												'.($hasConnection->tweetRef > 0 && $getFromT->checkTweetExistence($hasConnection->tweetRef) ? '
												<div class="refenceTweet" data-tweet="'.$hasConnection->tweetRef.'" data-user="'.$hasConnection->username.'">
													<div class="retrvieRef">
														<div class="r-t-u-flex">
															<div class="imagefor78ref">
																<img src="'.BASE_URL.$hasConnectionRef->profileImage.'" alt="">
															</div>
															<div class="nameref44e">
																<h4> <a style="color:var( --primary-text-color);" href="'.BASE_URL.$hasConnectionRef->username.'"> '.$hasConnectionRef->screenName.' </a> </h4>
															</div>
															<div class="nameref44e">
																<h4> <a href="#" style="color: var( --secondary-text-color); font-weight: 500;"> @'.$hasConnectionRef->username.' </a>
																</h4>
															</div>
															<div class="nameref44e" >
																<h4 style="color: var( --primary-text-color); font-weight: 500;"> • '.$getFromT->timeAgo(($hasConnectionRef->postedOn)).' </h4>
															</div>
														</div>
														
														'.(($booleanConnectionRef2 == true) ? 
														'<div class="replying-to"> <span> Replying to <a href="#"> @'.$getFromT->userData($hasConnectionRef->comment_userID)->username.' </a> </span> </div>
															' : '' ).' 
														 
														<div class="ref-status-t">
															<div class="status-reftt-t">
															'.$getFromT->getTweetLinks($hasConnectionRef->status).'
															</div>
														</div>
													</div>
													'.(!empty($hasConnectionRef->tweetImage) ?'
													<div class="image-ref-status-tweet-img">
														<img style="cursor:pointer;" src="'.BASE_URL.$hasConnectionRef->tweetImage.'" class="imagePopup" data-tweet="'.$hasConnectionRef->tweetID.'">
													</div>
													' : '' ).'
												</div>
												' : '<div class="deletedTweetExi"> <div class="inner-info-deleted"> This Tweet is unavailable. </div> </div>' ).'
												' : '' ).'
											
				
											<div class="react-retweet-like-flex react-retweet-like flex-icons">
											<ul>
											'.(($getFromT->loggedIn() ===true) ? '
												<li> <i class="fa fa-comment"></i> <span> '.$getFromT->countComments($hasConnection->tweetID).' </span> </li>
												<li> '.((isset($retweet['retweet_tweetID']) ? $hasConnection->tweetID === $retweet['retweet_tweetID'] OR $user_id == $retweet['retweet_userIDBy'] : '') ? 
												'<button id="retweet-options'.$hasConnection->tweetID.'" class="retweeted retweet-options"  data-tweet="'.$hasConnection->tweetID.'" data-user="'.$hasConnection->tweetOwner.'"><i class="fa fa-retweet" aria-hidden="true"></i><span class="retweetsCount">'.(($hasConnection->retweetCount > 0) ? $hasConnection->retweetCount : '').'</span></button>' : 
												'<button class="retweet-options" id="retweet-options'.$hasConnection->tweetID.'"  data-tweet="'.$hasConnection->tweetID.'" data-user="'.$hasConnection->tweetOwner.'"><i class="fa fa-retweet" aria-hidden="true"></i><span class="retweetsCount">'.(($hasConnection->retweetCount > 0) ? $hasConnection->retweetCount : '').'</span></button>').'
												<div class="op" id="op'.$hasConnection->tweetID.'">
												<ul> 
												'.((isset($retweet['retweet_tweetID']) ? $hasConnection->tweetID === $retweet['retweet_tweetID'] OR $user_id == $retweet['retweet_userIDBy'] : '') ? 
												'<li class="justUndoCloneTweet" data-tweet="'.$hasConnection->tweetID.'" data-user="'.$hasConnection->tweetOwner.'" style="cursor:pointer;  border-right:1px solid;">Undo Rwtweet</li> ' : 
												'<li class="justCloneTweet" data-tweet="'.$hasConnection->tweetID.'" data-user="'.$hasConnection->tweetOwner.'" style="cursor:pointer;  border-right:1px solid var( --primary-border-color);">Retweet</li> ').'
												
												<li class="retweet" style="cursor:pointer" data-tweet="'.$hasConnection->tweetID.'" data-user="'.$hasConnection->tweetBy.'">Quote Tweet</li> 
												<i title="close" style="color:var( --primary-text-color)" class="fa fa-close close'.$hasConnection->tweetID.'"></i>
													</ul>
												</div>
												</li>
												<li> '.((isset($likes['likeOn']) ? $likes['likeOn'] === $hasConnection->tweetID : '') ? 
												'<button class="unlike-btn" data-tweet="'.$hasConnection->tweetID.'" data-user="'.$hasConnection->tweetOwner.'"><i class="fa fa-heart" aria-hidden="true"></i><span class="likesCounter">'.(($hasConnection->likesCount > 0) ? $hasConnection->likesCount : '' ).'</span></button>' : 
												'<button class="like-btn" data-tweet="'.$hasConnection->tweetID.'" data-user="'.$hasConnection->tweetOwner.'"><i class="fa fa-heart-o" aria-hidden="true"></i><span class="likesCounter">'.(($hasConnection->likesCount > 0) ? $hasConnection->likesCount : '' ).'</span></button>').' 
												</li>
												<li> <i class="fa fa-bookmark-o"></i> </li>
												' : '<li><button><i class="fa fa-comment"></i> <span> 485 </span></button></li>
													<li><button><i class="fa fa-retweet" aria-hidden="true"></i><span class="retweetsCount">'.(($hasConnection->retweetCount > 0) ? $hasConnection->retweetCount : '').'</span></button></li>	
													<li><button><i class="fa fa-heart-o" aria-hidden="true"></i><span class="likesCounter">'.(($hasConnection->likesCount > 0) ? $hasConnection->likesCount : '' ).'</span></button></li>
													<li> <i class="fa fa-bookmark"></i> </li>').'

											</ul>

											</div>
										</div>
				
									</div>
				
				
				
								</div>';}
								$likes = $getFromT->likes($user_id, $userTstatus->tweetID);
								$retweet = $getFromT->checkRetweet($userTstatus->tweetID, $user_id);
						echo '
										<!-- userTweetStart -->
										<div class="userTweet">
						
											<div class="retweetLikeLable">
											'.((($us != 'Undefined' && $userTstatus->tweetID == $us)) ? '<div class="retweet-has">
											<div class="retweet-info">
												<i class="fa fa-retweet"></i>
												<span> <a style="color: var( --secondary-text-color); font-weight: 700; text-decoration:none;" href="'.BASE_URL.$userTr->username.'"> '.(( $su != 'Undefined' && $user_id === $su ) ? 'You' : $userTr->screenName).' Retweeted </a> </span>
											</div>
										</div>' : '' ).'
											</div>
						
											<div class="userInfoT">
												<div class="proImage">
												<img src="'.BASE_URL.$userTstatus->profileImage.'"/>
												</div>
												<div class="userInfoIn">
													<h4> <a href="'.BASE_URL.$userTstatus->username.'"> '.$userTstatus->screenName.' </a> </h4>
													<h4 class="username"> <a href="'.BASE_URL.$userTstatus->username.'"> @'.$userTstatus->username.' </a> </h4>
												</div>

												'.(($userTstatus->tweetOwner === $user_id) ? '
                                    
												<div class="delete-op" data-tweet="'.$userTstatus->tweetID.'" > <i class="fa fa-ellipsis-v ellipsiss" tabindex="1"></i> 
												<div class="d-t-b-u" id="d-t-b-u'.$userTstatus->tweetID.'">
												<div class="prop">
											   <label class="deleteTweet" data-tweet="'.$userTstatus->tweetID.'" data-re="'.$userTstatus->tweetRef.'" data-ret="'.$userTstatus->tweetRefTo.'"> <span>Delete Tweet</span>  </label>
											   <i class="fa fa-close closes closes'.$userTstatus->tweetID.'"></i>
												</div>
												</div>
												</div>
												' : '').'

											</div>
											
												'.(($booleanConnection == true) ? 
													'<div class="replying-to"> <span> Replying to <a href="#"> @'.$getFromT->userData($userTstatus->comment_userID)->username.' </a> </span> </div>
												' : '' ).' 
						
											<div class="status">
						
												<div class="swi67h">
												'.$getFromT->getTweetLinks($userTstatus->status).'
												</div>

												'.(!empty($userTstatus->tweetImage) ?'
												<div class="status-huh678">
													<img style="cursor:pointer;" src="'.BASE_URL.$userTstatus->tweetImage.'" alt="" class="imagePopup" data-tweet="'.$userTstatus->tweetID.'">
												</div>
												' : '' ).'

												'.( $userTstatus->tweetRef > 0 && (!empty($userTstatus->tweetRef))?'
												'.($userTstatus->tweetRef > 0 && $getFromT->checkTweetExistence($userTstatus->tweetRef) ? '
												<div class="refenceTweet" data-tweet="'.$userTstatus->tweetRef.'" data-user="'.$userRefD->username.'">
													<div class="retrvieRef">
														<div class="r-t-u-flex">
															<div class="imagefor78ref">
																<img src="'.BASE_URL.$userRefD->profileImage.'" alt="">
															</div>
															<div class="nameref44e">
																<h4> <a style="color:var( --primary-text-color);" href="'.BASE_URL.$userRefD->username.'"> '.$userRefD->username.' </a> </h4>
															</div>
															<div class="nameref44e">
																<h4> <a href="#" style="color: var( --secondary-text-color); font-weight: 500;"> @'.$userRefD->username.' </a>
																</h4>
															</div>
															<div class="nameref44e" >
																<h4 style="color: var( --primary-text-color); font-weight: 500;"> • '.$getFromT->timeAgo(($userRefS[0]->postedOn)).' </h4>
															</div>
														</div>
														<div class="ref-status-t">
															<div class="status-reftt-t">
															'.$getFromT->getTweetLinks($userRefS[0]->status).'
															</div>
														</div>
													</div>
													'.(!empty($userRefS[0]->tweetImage) ?'
													<div class="image-ref-status-tweet-img">
														<img style="cursor:pointer;" src="'.BASE_URL.$userRefS[0]->tweetImage.'" class="imagePopup" data-tweet="'.$userRefS[0]->tweetID.'">
													</div>
													' : '' ).'
												</div>
												' : '<div class="deletedTweetExi"> <div class="inner-info-deleted"> This Tweet is unavailable. </div> </div>' ).'
												' : '' ).'
						
						
												<div class="timeControl">
													<div class="timeforFrom">
													'.$getFromT->timeAgo(($userTstatus->postedOn)).' • Tweet for Android
													</div>
												</div>
						
												<div class="countControl">
													<div class="countforFrom">
														<ul>
															<li class="showUsers" data-tweet="'.$userTstatus->tweetID.'" data-cat="retweets"> <span class="retweett"> '.$getFromT->fetchRetweetCount($userTstatus->tweetID).'  </span>  </li>
															<li> <a href="'.BASE_URL.$userTstatus->username.'/status/'.$userTstatus->tweetID.'?retweet_with_comments"> <span class="qouteTweett"> '.$getFromT->fetchRetweetQuoteCount($userTstatus->tweetID).'  </span></a> </li>
															<li class="showUsers" data-tweet="'.$userTstatus->tweetID.'" data-cat="likes"> <span class="likesCountt"> '.(($userTstatus->likesCount > 0) ? $userTstatus->likesCount .' <span class="low" style="font-weight:500px !important;">Likes</span>' : '' ).'  </li>
														</ul>
													</div>
												</div>
						
												<div class="countControlManipulative">
													<div class="countforFromManipulative">
													<ul>
													
													<li> <i class="fa fa-comment-o"></i> </li>
													<li> '.((isset($retweet['retweet_tweetID']) ? $userTstatus->tweetID === $retweet['retweet_tweetID'] OR $user_id == $retweet['retweet_userIDBy'] : '') ? 
															'<button id="retweet-options'.$userTstatus->tweetID.'" class="retweeted retweet-options" data-tweet="'.$userTstatus->tweetID.'" data-user="'.$userTstatus->tweetBy.'"><i class="fa fa-retweet" aria-hidden="true"></i></button>' : 
															'<button class="retweet-options" id="retweet-options'.$userTstatus->tweetID.'" data-tweet="'.$userTstatus->tweetID.'" data-user="'.$userTstatus->tweetBy.'"><i class="fa fa-retweet" aria-hidden="true"></i></button>').'
															<div class="op" id="op'.$userTstatus->tweetID.'">
															<ul>
															'.((isset($retweet['retweet_tweetID']) ? $userTstatus->tweetID === $retweet['retweet_tweetID'] OR $user_id == $retweet['retweet_userIDBy'] : '') ? 
															'<li class="justUndoCloneTweet" data-tweet="'.$userTstatus->tweetID.'" data-user="'.$userTstatus->tweetOwner.'" style="cursor:pointer;  border-right:1px solid;">Undo Rwtweet</li> ' : 
															'<li class="justCloneTweet" data-tweet="'.$userTstatus->tweetID.'" data-user="'.$userTstatus->tweetOwner.'" style="cursor:pointer;  border-right:1px solid;">Retweet</li> ').'
															
															<li class="retweet" style="cursor:pointer" data-tweet="'.$userTstatus->tweetID.'" data-user="'.$userTstatus->tweetBy.'">Quote Tweet</li> 
															<i title="close" style="color:var( --primary-text-color)" class="fa fa-close close'.$userTstatus->tweetID.'"></i>
															</ul>
															</div>
															</li>
													<li> '.((isset($likes['likeOn']) ? $likes['likeOn'] === $userTstatus->tweetID : '') ? 
															'<button class="unlike-btn" data-tweet="'.$userTstatus->tweetID.'" data-user="'.$userTstatus->tweetBy.'"><i class="fa fa-heart" aria-hidden="true"></i></button>' : 
															'<button class="like-btn" data-tweet="'.$userTstatus->tweetID.'" data-user="'.$userTstatus->tweetBy.'"><i class="fa fa-heart-o" aria-hidden="true"></i></button>').' </li>
													<li> <i class="fa fa-share"></i> </li>
												</ul>
													</ul>
													</div>
												</div>
												
						
												<div class="input-comment-t">
													<div class="comment-t">
													<div class="image-com">
													<img src="'.BASE_URL.$user->profileImage.'" alt="img">
													</div>
													<div class="inputFiled">
													<form id="commentPost" method="POST" enctype="multipart/form-data" style="    margin: 0;
													width: 100%;">
															<div class="hidden-replyTo">
																<h5> Replying to <span> @'.$userTstatus->username.' </span> </h5>
															</div>
															<div class="getCom">
																<textarea name="comment" id="commentFields" data-ttweet="'.$userTstatus->tweetBy.'" data-user="'.$userTstatus->username.'" data-tweet="'.$userTstatus->tweetID.'" placeholder="Tweet your reply" name="comment" cols="15"
																	rows="2"></textarea>
																	<input type="text" value="'.$userTstatus->tweetID.'" name="tweet_id" hidden>
																	<input type="text" value="'.$userTstatus->username.'" name="user" hidden>
																	<input type="text" value="'.$userTstatus->tweetBy.'" name="ttweet" hidden>
															</div>
															<div class="icons-comm">
															<input type="file" name="filec" id="filec" class="filec" hidden/>
																<label for="filec"> <i class="fa fa-camera"></i>  <span style="font-size: 15px;" id="filenamec">  </span>  </label>
																<button  id="postComments"  type="submit"> Reply </button>
															</div>
															</form>
														</div>
						
													</div>
												</div>
												
											
						
											</div>
						
										</div>
										<!-- userTweetEnd -->
									</div>
									<!-- inner-ienwrfo -->
								</div>
								<!-- innerContainerEnd -->
								</div>
							
								';
								echo '<div class="replySection" id="replySection">';
								foreach($comments as $comment){

									$likes = $getFromT->likes($user_id, $comment->tweetID);
									$retweet = $getFromT->checkRetweet($comment->tweetID, $user_id);
									// $retweets = $getFromT->checkRetweeTUser($comment->tweetID);
									$comments = $getFromT->comments($tweetID);

									echo'<div class="replyuser" data-tweet="'.$comment->tweetID.'" data-user="'.$comment->username.'">
										<div class="flex-box-y">
											<div class="img-reply-u">
												<img src="'.BASE_URL.$comment->profileImage.'" alt="">
											</div>
											<div class="non-flex">
												<div class="flex-user-info-tweet">
													<div class="user-t-r-s">
														<h4> <a href="'.BASE_URL.$comment->username.'"> '.$comment->screenName.' </a> </h4>
													</div>
													<div class="user-t-r-s">
														<h4> <a href="$" style="            color:var(--secondary-text-color);
															font-weight: 500;
															text-decoration: none;">@'.$comment->username.'</a> </h4>
													</div>
													<div class="user-t-r-s" style="            color:var(--secondary-text-color);">
														<h4> • 		'.$getFromT->timeAgo(($comment->postedOn)).' </h4>
													</div>
													'.(($comment->tweetOwner === $user_id) ? '
										
													<div class="delete-op" data-tweet="'.$comment->tweetID.'" > <i class="fa fa-ellipsis-v ellipsiss"></i> 
													<div class="d-t-b-u" id="d-t-b-u'.$comment->tweetID.'">
													<div class="prop">
													<label class="deleteTweet" data-tweet="'.$comment->tweetID.'" data-re="'.$comment->tweetRef.'" data-ret="'.$comment->tweetRefTo.'">Delete Tweet</label>
												   <i class="fa fa-close closes closes'.$comment->tweetID.'"></i>
													</div>
													</div>
													</div>
													' : '').'
												</div>
												<div class="replyTo-user">
													<h4> Replying To <span>@'.$userTstatus->username.'</span> </h4>
												</div>
												<div class="status-reply5">
												'.$getFromT->getTweetLinks($comment->status).'
												</div>
												<div class="commentImage">
													'.(!empty($comment->tweetImage) ? 
													'<!--tweet show head end-->
													<div class="cimageContainer imageContainer">
													<div class="imageProposal">
													<div class="imageContains">
														<img src="'.BASE_URL.$comment->tweetImage.'" class="imagePopup" data-tweet="'.$comment->tweetID.'" alt="">
													</div>
													</div>
													</div>
													<!--tweet show body end-->
													' : '' ).'
												</div>
												<div class="react-retweet-like flex-icons">


												<ul>
												'.(($getFromT->loggedIn() ===true) ? '
													<li> <i class="fa fa-comment"></i> <span> '.$getFromT->countComments($comment->tweetID).' </span> </li>
													<li> '.((isset($retweet['retweet_tweetID']) ? $comment->tweetID === $retweet['retweet_tweetID'] OR $user_id == $retweet['retweet_userIDBy'] : '') ? 
													'<button id="retweet-options'.$comment->tweetID.'" class="retweeted retweet-options"  data-tweet="'.$comment->tweetID.'" data-user="'.$comment->tweetOwner.'"><i class="fa fa-retweet" aria-hidden="true"></i><span class="retweetsCount">'.(($comment->retweetCount > 0) ? $comment->retweetCount : '').'</span></button>' : 
													'<button class="retweet-options" id="retweet-options'.$comment->tweetID.'"  data-tweet="'.$comment->tweetID.'" data-user="'.$comment->tweetOwner.'"><i class="fa fa-retweet" aria-hidden="true"></i><span class="retweetsCount">'.(($comment->retweetCount > 0) ? $comment->retweetCount : '').'</span></button>').'
													<div class="op" id="op'.$comment->tweetID.'">
													<ul> 
													'.((isset($retweet['retweet_tweetID']) ? $comment->tweetID === $retweet['retweet_tweetID'] OR $user_id == $retweet['retweet_userIDBy'] : '') ? 
													'<li class="justUndoCloneTweet" data-tweet="'.$comment->tweetID.'" data-user="'.$comment->tweetOwner.'" style="cursor:pointer;  border-right:1px solid;">Undo Rwtweet</li> ' : 
													'<li class="justCloneTweet" data-tweet="'.$comment->tweetID.'" data-user="'.$comment->tweetOwner.'" style="cursor:pointer;  border-right:1px solid var( --primary-border-color);">Retweet</li> ').'
													
													<li class="retweet" style="cursor:pointer" data-tweet="'.$comment->tweetID.'" data-user="'.$comment->tweetBy.'">Quote Tweet</li> 
													<i title="close" style="color:var( --primary-text-color)" class="fa fa-close close'.$comment->tweetID.'"></i>
														</ul>
													</div>
													</li>
													<li> '.((isset($likes['likeOn']) ? $likes['likeOn'] === $comment->tweetID : '') ? 
													'<button class="unlike-btn" data-tweet="'.$comment->tweetID.'" data-user="'.$comment->tweetOwner.'"><i class="fa fa-heart" aria-hidden="true"></i><span class="likesCounter">'.(($comment->likesCount > 0) ? $comment->likesCount : '' ).'</span></button>' : 
													'<button class="like-btn" data-tweet="'.$comment->tweetID.'" data-user="'.$comment->tweetOwner.'"><i class="fa fa-heart-o" aria-hidden="true"></i><span class="likesCounter">'.(($comment->likesCount > 0) ? $comment->likesCount : '' ).'</span></button>').' 
													</li>
													<li> <i class="fa fa-bookmark-o"></i> </li>
													' : '<li><button><i class="fa fa-comment"></i> <span> 485 </span></button></li>
														<li><button><i class="fa fa-retweet" aria-hidden="true"></i><span class="retweetsCount">'.(($comment->retweetCount > 0) ? $comment->retweetCount : '').'</span></button></li>	
														<li><button><i class="fa fa-heart-o" aria-hidden="true"></i><span class="likesCounter">'.(($comment->likesCount > 0) ? $comment->likesCount : '' ).'</span></button></li>
														<li> <i class="fa fa-bookmark"></i> </li>').'
	
												</ul>


												</div>
											</div>
										</div>
									</div> ';
								}
								echo'
								</div>
						
						
							</div>
					</div>';
						
						?>
						<?php endif; ?>

								<div class="clear_fix" style="display:none; height:55px; width:100%;"></div>
					</div>
				</div>
							

							<div class="clear_fix" style="display:none; height:55px; width:100%;"></div>
						<!--Tweet SHOW WRAPER END-->
					</div><!-- in left wrap-->
					<div class="float-tweet" id="float-tweet">

						<i class="fa fa-leaf"></i>
					</div>
					<div class="popupTweet"></div>
					<div class="alert hide">
							<span id="iconSign" class="fa "></span>
							<span class="msgs"> SAMPLE TEXT </span>
							<div class="close-btn">
								<span class="fa fa-times"></span>
							</div>
					</div>

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

						<?php if (!(strpos($_SERVER['REQUEST_URI'], '?retweet_with_comments'))) :?>
						<!--==WHO TO FOLLOW==-->
						<?php $getFromF->Relevantpeople($user_id, $profileId , $userTstatus->status); ?>
						<!--==WHO TO FOLLOW==-->
						<?php endif; ?>

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