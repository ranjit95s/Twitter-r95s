<?php

include 'core/init.php';
if (isset($_GET['hashtag']) && !empty($_GET['hashtag'])) {
	$hashtag = $getFromU->checkInput($_GET['hashtag']);
	$user_id = @$_SESSION['user_id'];
	$user     = $getFromU->userData($user_id);
	$tweets = $getFromT->getTweetsByHash($hashtag);
	// $resultTweets = $getFromT->searchTweets($hashtag);
	$tweetsLatests = $getFromT->getTweetsByHashLatest($hashtag);
	$accounts = $getFromT->getUsersByHash($hashtag);
	$notify = $getFromM->getNotificationCount($user_id);
	$notification  = $getFromM->notification($user_id);
} else {
	header('Location:' . BASE_URL . 'index.php');
}

?>

<!DOCTYPE html>
<html>

<head>
	<title><?php echo '#' . $hashtag; ?> / Tweety</title>
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
	
		<!--hash-menu-->
		<!---Inner wrapper-->

		<div class="in-wrapper">
			<div class="in-full-wrap">

			<?php 
                include 'includes/entities/side-pro-link.php';
            ?>
				<!-- in left end-->




				<div class="in-center">
					<div class="in-center-wrap">
						<section class="search-engine">
							<div class="search-pro">
								<ul>
									<li>
										<i class="fa fa-search" aria-hidden="true"></i>
										<input type="text" placeholder="Search Twitter" class="search" value="#<?php echo $hashtag; ?>" />
										<div class="search-result">
										</div>
									</li>
								</ul>
							</div>
						</section>

						<section class="hash-hash-nav">
							<div class="hash-menu" >
								<div class="hash-menu-inner">
									<ul>
												<?php
												function active($currect_page){
													// echo $currect_page;
												$url_array =  explode('/', $_SERVER['REQUEST_URI']) ;
												$url = end($url_array);  

												if($currect_page == $url){
													echo 'followActive'; //class name in css 
												} 
												}
												?>
										<li class="<?php active($hashtag);?>" ><a href="<?php echo BASE_URL . 'hashtag/' . $hashtag; ?>">Top</a></li>
										<li class="<?php active($hashtag.'?f=latest');?>"><a href="<?php echo BASE_URL . 'hashtag/' . $hashtag . '?f=latest'; ?>">Latest</a></li>
										<li class="<?php active($hashtag.'?f=users');?>"><a href="<?php echo BASE_URL . 'hashtag/' . $hashtag . '?f=users'; ?>">Accounts</a></li>
										<li class="<?php active($hashtag.'?f=photos');?>"><a href="<?php echo BASE_URL . 'hashtag/' . $hashtag . '?f=photos'; ?>">Photos</a></li>
									</ul>
								</div>
							</div>
						</section>
						<?php if (strpos($_SERVER['REQUEST_URI'], '?f=photos')) : ?>

							<!-- TWEETS IMAGES  -->
							<div class="hash-img-wrapper">
								<div class="hash-img-inner">
									<?php

									foreach ($tweets as $tweet) {
										$likes = $getFromT->likes($user_id, $tweet->tweetID);
										$retweet = $getFromT->checkRetweeTUser($tweet->tweetID);
									
										if (!empty($tweet->tweetImage)) {
											echo '<div class="hash-img-flex">
											
			<img src="' . BASE_URL . $tweet->tweetImage . '" class="imagePopup" data-tweet="' . $tweet->tweetID . '"/>
			<div class="hash-img-flex-footer">
											<div class="flex-icons-hashimg flex-icons">
				<ul>
				' . (($getFromU->loggedIn()) ?   '
						
						<li><button> <a href="'.BASE_URL.$tweet->username.'"><i class="fa fa-user" aria-hidden="true"> </i></a></button></li>
						<li>' . (((isset($retweet['retweet_tweetID'])) ? $tweet->tweetID === $retweet['retweet_tweetID'] or $user_id === $retweet['retweet_userIDBy'] : '') ? '<button class="retweeted" data-tweet="' . $tweet->tweetID . '" data-user="' . $tweet->tweetBy . '"><i class="fa fa-retweet" aria-hidden="true"></i><span class="retweetsCount">' . (($tweet->retweetCount > 0) ? $tweet->retweetCount : '') . '</span></button>' : '<button class="retweet" data-tweet="' . $tweet->tweetID . '" data-user="' . $tweet->tweetBy . '"><i class="fa fa-retweet" aria-hidden="true"></i><span class="retweetsCount">' . (($tweet->retweetCount > 0) ? $tweet->retweetCount : '') . '</span></button>') . '</li>
						<li>' . (((isset($likes['likeOn'])) ?  $likes['likeOn'] === $tweet->tweetID : '') ?
												'<button class="unlike-btn" data-tweet="' . $tweet->tweetID . '" data-user="' . $tweet->tweetBy . '"><i class="fa fa-heart" aria-hidden="true"></i><span class="likesCounter">' . (($tweet->likesCount > 0) ? $tweet->likesCount : '') . '</span></button>' :
												'<button class="like-btn" data-tweet="' . $tweet->tweetID . '" data-user="' . $tweet->tweetBy . '"><i class="fa fa-heart-o" aria-hidden="true"></i><span class="likesCounter">' . (($tweet->likesCount > 0) ? $tweet->likesCount : '') . '</span></button>') . '
						</li>
							
							' . (($tweet->tweetBy === $user_id) ? ' 
							<li>
								<a href="#" class="more"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
								<ul> 
								<li><label class="deleteTweet" data-tweet="' . $tweet->tweetID . '">Delete Tweet</label></li>
								</ul>
							</li>' : '') . '
					' : '
						<li><button><i class="fa fa-bookmark-o" aria-hidden="true"></i></button></li>	
						<li><button><i class="fa fa-retweet" aria-hidden="true"></i></button></li>	
						<li><button><i class="fa fa-heart-o" aria-hidden="true"></i></button></li>	
					') . '
				</ul>
				</div>
			</div>
		</div>';
										}
									}
									?>

<div class="clear_fix" style="display:none; height:55px; width:100%;"></div>
								</div>
							</div>
							<!-- TWEETS IMAGES -->
						<?php elseif (strpos($_SERVER['REQUEST_URI'], '?f=users')) : ?>
							<!--TWEETS ACCOUTS-->
							<div class="wrapper-following">
								<div class="wrap-follow-inner">

									<?php foreach ($accounts as $users) : ?>

										<div class="follow-unfollow-box">
											<div class="follow-unfollow-inner">
												<div class="follow-background">
													<img src="<?php echo BASE_URL . $users->profileCover; ?>" />
												</div>
												<div class="follow-person-button-img">
													<div class="follow-person-img">
														<img src="<?php echo BASE_URL . $users->profileImage; ?>" />
													</div>
													<div class="follow-person-button">
														<?php echo $getFromF->followBtn($users->user_id, $user_id, $user_id); ?>
													</div>
												</div>
												<div class="follow-person-bio">
													<div class="follow-person-name">
														<a href="<?php echo BASE_URL . $users->username; ?>"><?php echo $users->screenName;  if($users->statusVerify != 0) {echo ' <i title="User Verified" id="verifyedUser" class="fa fa-check-circle"></i>';} ?></a>
													</div>
													<div class="follow-person-tname">
														<a href="<?php echo BASE_URL . $users->username; ?>">@<?php echo $users->username; ?></a>
													</div>
													<div class="follow-person-dis">
														<?php echo $getFromT->getTweetLinks($users->bio); ?>
													</div>
												</div>
											</div>
										</div>
									<?php endforeach; ?>
									<div class="clear_fix" style="display:none; height:55px; width:100%;"></div>
								</div>
							</div>
							<!-- TWEETS ACCOUNTS -->

							<?php elseif (strpos($_SERVER['REQUEST_URI'], '?f=latest')) : ?>
							<?php
							foreach ($tweetsLatests as $tweet) {
								$likes = $getFromT->likes($user_id, $tweet->tweetID);
								$retweet = $getFromT->checkRetweet($tweet->tweetID, $user_id);
								$user = $getFromT->userData($tweet->tweetOwner);
				
								$retweets = $getFromT->checkRetweeTUser($tweet->tweetID);
				
											
											$us = 'Undefined';
											$su = 'Undefined';
											foreach($retweets as $product){
												$userTr = $getFromT->userData($product->retweet_userIDBy);
												$us = $product->retweet_tweetID;
												$su = $product->retweet_userIDBy;
											}
								
								$userRefS = $getFromT->getUserTweetsByID($tweet->tweetRef,$tweet->tweetRefTo);
								$userOwnerTweet = $getFromT->getUserTweetsOwnerByID($tweet->tweetID , $tweet->tweetOwner);
								$userRefD = $getFromT->userData($tweet->tweetRefTo);

								echo '<div class="all-tweet" data-tweet="'.$tweet->tweetID.'" data-user="'.$user->username.'">
								<div class="container">
								<div class="tweet-outer">
									<div class="tweet-inner">
				
									'.((($us != 'Undefined' && $tweet->tweetID == $us) && $tweet->tweetOwner != $user_id) ? '<div class="retweet-has">
									<div class="retweet-info">
										<i class="fa fa-retweet"></i>
										<span> <a style="color: var( --secondary-text-color); font-weight: 700; text-decoration:none;" href="'.BASE_URL.$userTr->username.'"> '.(( $su != 'Undefined' && $user_id === $su ) ? 'You' : $userTr->screenName ).' Retweeted </a> </span>
									</div>
								</div>' : '' ).'
						
										<!-- flex-out S -->
										<div class="flex-out">
											<div class="img-user">
												<div class="img-inner">
												<img src="'.BASE_URL.$user->profileImage.'"/>
												</div>
											</div>
						
						
											<!-- sc-ur-status S -->
											<div class="sc-ur-status">
												<div class="header">
													
												'.(($tweet->tweetOwner === $user_id) ? '
													
													<div class="delete-op" data-tweet="'.$tweet->tweetID.'" > <i class="fa fa-ellipsis-v ellipsiss"></i> 
													<div class="d-t-b-u" id="d-t-b-u'.$tweet->tweetID.'">
													<div class="prop">
												   <label class="deleteTweet" data-tweet="'.$tweet->tweetID.'" data-re="'.$tweet->tweetRef.'" data-ret="'.$tweet->tweetRefTo.'"> <span>Delete Tweet</span>  </label>
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
														<h4> <a style="color: var( --primary-text-color); font-weight: 800; text-decoration:none;" href="'.BASE_URL.$user->username.'">'.$user->screenName.' '.(($user->statusVerify != 0) ? '<i title="User Verified" id="verifyedUser" class="fa fa-check-circle"></i>' : '').'</a></h4>
													</div>
													<div class="useru">
														<h4 style="color: var( --secondary-text-color); font-weight: 500;">  <a style="color: var( --secondary-text-color); font-weight: 500; text-decoration:none;" href="'.BASE_URL.$user->username.'">@'.$user->username.'</a> </h4>
													</div>
													</div>
													<div class="useru">
														<h4 style="color: var( --secondary-text-color); font-weight: 500;"> • '.$getFromT->timeAgo(($userOwnerTweet[0]->postedOn)).'</h4>
													</div>
												</div>
												'.(($userOwnerTweet[0]->commentTrue == 1) ? 
													'<div class="replying-to"> <span> Replying to <a href="#"> @'.$getFromT->userData($userOwnerTweet[0]->comment_userID)->username.' </a> </span> </div>
														' : '' ).'
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
																		<img src="'.BASE_URL.$userRefD->profileImage.'" alt="" srcset="">
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
																		<h4 style="color: var( --primary-text-color); font-weight: 800;">'.$userRefD->screenName.' '.(($userRefD->statusVerify != 0) ? '<i title="User Verified" id="verifyedUser" class="fa fa-check-circle"></i>' : '').'</h4>
																	</div>
																	<div class="userd">
																		<h4 style="color: var( --secondary-text-color); font-weight: 500;">@'.$userRefD->username.'</h4>
																	</div>
																	</div>
																	<div class="userd">
																		<h4 style="color: var( --secondary-text-color); font-weight: 500;"> • '.$getFromT->timeAgo(($userRefS[0]->postedOn)).'</h4>
																	</div>
																</div>
																'.(($userRefS[0]->commentTrue == 1) ? 
																'<div class="replying-to"> <span> Replying to <a href="#"> @'.$getFromT->userData($userRefS[0]->comment_userID)->username.' </a> </span> </div>
																	' : '' ).'
																<div class="ref-status">
																	<h6>'.$getFromT->getTweetLinks($userRefS[0]->status).'</h6>
																	</div>
																	
															</div>
														</div>
													</div>
													'.(!empty($userRefS[0]->tweetImage) ? 
												'<!--tweet show head end-->
												<div class="status-image imagePopup">
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
															'.(($getFromT->loggedIn() ===true) ? '
																<li> <i class="fa fa-comment-o"></i> <span> '.$getFromT->countComments($tweet->tweetID).' </span> </li>
																<li> '.((isset($retweet['retweet_tweetID']) ? $tweet->tweetID === $retweet['retweet_tweetID'] OR $user_id == $retweet['retweet_userIDBy'] : '') ? 
																'<button id="retweet-options'.$tweet->tweetID.'" class="retweeted retweet-options"  data-tweet="'.$tweet->tweetID.'" data-user="'.$tweet->tweetOwner.'"><i class="fa fa-retweet" aria-hidden="true"></i><span class="retweetsCount">'.(($tweet->retweetCount > 0) ? $tweet->retweetCount : '').'</span></button>' : 
																'<button class="retweet-options" id="retweet-options'.$tweet->tweetID.'"  data-tweet="'.$tweet->tweetID.'" data-user="'.$tweet->tweetOwner.'"><i class="fa fa-retweet" aria-hidden="true"></i><span class="retweetsCount">'.(($tweet->retweetCount > 0) ? $tweet->retweetCount : '').'</span></button>').'
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
																'<button class="unlike-btn" data-tweet="'.$tweet->tweetID.'" data-user="'.$tweet->tweetOwner.'"><i class="fa fa-heart" aria-hidden="true"></i><span class="likesCounter">'.(($tweet->likesCount > 0) ? $tweet->likesCount : '' ).'</span></button>' : 
																'<button class="like-btn" data-tweet="'.$tweet->tweetID.'" data-user="'.$tweet->tweetOwner.'"><i class="fa fa-heart-o" aria-hidden="true"></i><span class="likesCounter">'.(($tweet->likesCount > 0) ? $tweet->likesCount : '' ).'</span></button>').' 
																</li>
																<li> <i class="fa fa-bookmark-o"></i> </li>
																' : '<li><button><i class="fa fa-comment-o"></i> <span> '.$getFromT->countComments($tweet->tweetID).' </span></button></li>
																	<li><button><i class="fa fa-retweet" aria-hidden="true"></i><span class="retweetsCount">'.(($tweet->retweetCount > 0) ? $tweet->retweetCount : '').'</span></button></li>	
																	<li><button><i class="fa fa-heart-o" aria-hidden="true"></i><span class="likesCounter">'.(($tweet->likesCount > 0) ? $tweet->likesCount : '' ).'</span></button></li>
																	<li> <i class="fa fa-bookmark-o"></i> </li>').'
				
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
					<div class="clear_fix" style="display:none; height:55px; width:100%;"></div>
					</div>
				</div>
						<?php else : ?>
							<?php
							foreach ($tweets as $tweet) {
								$likes = $getFromT->likes($user_id, $tweet->tweetID);
								$retweet = $getFromT->checkRetweet($tweet->tweetID, $user_id);
								$user = $getFromT->userData($tweet->tweetOwner);
				
								$retweets = $getFromT->checkRetweeTUser($tweet->tweetID);
				
											
											$us = 'Undefined';
											$su = 'Undefined';
											foreach($retweets as $product){
												$userTr = $getFromT->userData($product->retweet_userIDBy);
												$us = $product->retweet_tweetID;
												$su = $product->retweet_userIDBy;
											}
								
								$userRefS = $getFromT->getUserTweetsByID($tweet->tweetRef,$tweet->tweetRefTo);
								$userOwnerTweet = $getFromT->getUserTweetsOwnerByID($tweet->tweetID , $tweet->tweetOwner);
								$userRefD = $getFromT->userData($tweet->tweetRefTo);

								echo '<div class="all-tweet" data-tweet="'.$tweet->tweetID.'" data-user="'.$user->username.'">
								<div class="container">
								<div class="tweet-outer">
									<div class="tweet-inner">
				
									'.((($us != 'Undefined' && $tweet->tweetID == $us) && $tweet->tweetOwner != $user_id) ? '<div class="retweet-has">
									<div class="retweet-info">
										<i class="fa fa-retweet"></i>
										<span> <a style="color: var( --secondary-text-color); font-weight: 700; text-decoration:none;" href="'.BASE_URL.$userTr->username.'"> '.(( $su != 'Undefined' && $user_id === $su ) ? 'You' : $userTr->screenName ).' Retweeted </a> </span>
									</div>
								</div>' : '' ).'
						
										<!-- flex-out S -->
										<div class="flex-out">
											<div class="img-user">
												<div class="img-inner">
												<img src="'.BASE_URL.$user->profileImage.'"/>
												</div>
											</div>
						
						
											<!-- sc-ur-status S -->
											<div class="sc-ur-status">
												<div class="header">
													
												'.(($tweet->tweetOwner === $user_id) ? '
													
													<div class="delete-op" data-tweet="'.$tweet->tweetID.'" > <i class="fa fa-ellipsis-v ellipsiss"></i> 
													<div class="d-t-b-u" id="d-t-b-u'.$tweet->tweetID.'">
													<div class="prop">
												   <label class="deleteTweet" data-tweet="'.$tweet->tweetID.'" data-re="'.$tweet->tweetRef.'" data-ret="'.$tweet->tweetRefTo.'"> <span>Delete Tweet</span>  </label>
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
														<h4> <a style="color: var( --primary-text-color); font-weight: 800; text-decoration:none;" href="'.BASE_URL.$user->username.'">'.$user->screenName.' '.(($user->statusVerify != 0) ? '<i title="User Verified" id="verifyedUser" class="fa fa-check-circle"></i>' : '').'</a></h4>
													</div>
													<div class="useru">
														<h4 style="color: var( --secondary-text-color); font-weight: 500;">  <a style="color: var( --secondary-text-color); font-weight: 500; text-decoration:none;" href="'.BASE_URL.$user->username.'">@'.$user->username.'</a> </h4>
													</div>
													</div>
													<div class="useru">
														<h4 style="color: var( --secondary-text-color); font-weight: 500;"> • '.$getFromT->timeAgo(($userOwnerTweet[0]->postedOn)).'</h4>
													</div>
												</div>
												'.(($userOwnerTweet[0]->commentTrue == 1) ? 
													'<div class="replying-to"> <span> Replying to <a href="#"> @'.$getFromT->userData($userOwnerTweet[0]->comment_userID)->username.' </a> </span> </div>
														' : '' ).'
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
																		<img src="'.BASE_URL.$userRefD->profileImage.'" alt="" srcset="">
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
																		<h4 style="color: var( --primary-text-color); font-weight: 800;">'.$userRefD->screenName.' '.(($userRefD->statusVerify != 0) ? '<i title="User Verified" id="verifyedUser" class="fa fa-check-circle"></i>' : '').'</h4>
																	</div>
																	<div class="userd">
																		<h4 style="color: var( --secondary-text-color); font-weight: 500;">@'.$userRefD->username.'</h4>
																	</div>
																	</div>
																	<div class="userd">
																		<h4 style="color: var( --secondary-text-color); font-weight: 500;"> • '.$getFromT->timeAgo(($userRefS[0]->postedOn)).'</h4>
																	</div>
																</div>
																'.(($userRefS[0]->commentTrue == 1) ? 
																'<div class="replying-to"> <span> Replying to <a href="#"> @'.$getFromT->userData($userRefS[0]->comment_userID)->username.' </a> </span> </div>
																	' : '' ).'
																<div class="ref-status">
																	<h6>'.$getFromT->getTweetLinks($userRefS[0]->status).'</h6>
																	</div>
																	
															</div>
														</div>
													</div>
													'.(!empty($userRefS[0]->tweetImage) ? 
												'<!--tweet show head end-->
												<div class="status-image imagePopup">
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
															'.(($getFromT->loggedIn() ===true) ? '
																<li> <i class="fa fa-comment-o"></i> <span> '.$getFromT->countComments($tweet->tweetID).' </span> </li>
																<li> '.((isset($retweet['retweet_tweetID']) ? $tweet->tweetID === $retweet['retweet_tweetID'] OR $user_id == $retweet['retweet_userIDBy'] : '') ? 
																'<button id="retweet-options'.$tweet->tweetID.'" class="retweeted retweet-options"  data-tweet="'.$tweet->tweetID.'" data-user="'.$tweet->tweetOwner.'"><i class="fa fa-retweet" aria-hidden="true"></i><span class="retweetsCount">'.(($tweet->retweetCount > 0) ? $tweet->retweetCount : '').'</span></button>' : 
																'<button class="retweet-options" id="retweet-options'.$tweet->tweetID.'"  data-tweet="'.$tweet->tweetID.'" data-user="'.$tweet->tweetOwner.'"><i class="fa fa-retweet" aria-hidden="true"></i><span class="retweetsCount">'.(($tweet->retweetCount > 0) ? $tweet->retweetCount : '').'</span></button>').'
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
																'<button class="unlike-btn" data-tweet="'.$tweet->tweetID.'" data-user="'.$tweet->tweetOwner.'"><i class="fa fa-heart" aria-hidden="true"></i><span class="likesCounter">'.(($tweet->likesCount > 0) ? $tweet->likesCount : '' ).'</span></button>' : 
																'<button class="like-btn" data-tweet="'.$tweet->tweetID.'" data-user="'.$tweet->tweetOwner.'"><i class="fa fa-heart-o" aria-hidden="true"></i><span class="likesCounter">'.(($tweet->likesCount > 0) ? $tweet->likesCount : '' ).'</span></button>').' 
																</li>
																<li> <i class="fa fa-bookmark-o"></i> </li>
																' : '<li><button><i class="fa fa-comment-o"></i> <span> '.$getFromT->countComments($tweet->tweetID).' </span></button></li>
																	<li><button><i class="fa fa-retweet" aria-hidden="true"></i><span class="retweetsCount">'.(($tweet->retweetCount > 0) ? $tweet->retweetCount : '').'</span></button></li>	
																	<li><button><i class="fa fa-heart-o" aria-hidden="true"></i><span class="likesCounter">'.(($tweet->likesCount > 0) ? $tweet->likesCount : '' ).'</span></button></li>
																	<li> <i class="fa fa-bookmark-o"></i> </li>').'
				
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
					<div class="clear_fix" style="display:none; height:55px; width:100%;"></div>
					</div>
				</div>
		
			<?php endif; ?>
			<div class="popupTweet"></div>
			<div class="alert hide">
					<span id="iconSign" class="fa "></span>
					<span class="msgs"> SAMPLE TEXT </span>
					<div class="close-btn">
						<span class="fa fa-times"></span>
					</div>
			</div>
			</div>
			</div>
			<div class="in-right">
				<div class="in-right-wrap">
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
					<!--==WHO TO FOLLOW==-->
					<?php $getFromF->whoToFollow($user_id, $user_id); ?>
					<!--==WHO TO FOLLOW==-->


				</div><!-- in right wrap-->
			<!--in full wrap end-->
		</div><!-- in wrappper ends-->

	</div><!-- ends wrapper -->
	<?php 
							if ($getFromU->loggedIn() === false){
								echo '<section id="non-users">
								<div class="nonUser">
									<div class="flex-non">
										<div class="non-decs">
											<div class="non-desc-in head">
												Don’t miss what’s happening
											</div>
											<div class="non-desc-in tail">
												People on Tweety are the first to know.
											</div>
										</div>
										<div class="non-direct">
											<li>
												<div class="flex-non-li li-ml0"> <a href="'.BASE_URL.'"> Log in </a> </div>
											</li>
											<li>
											<div class="flex-non-li"> <a href="'.BASE_URL.'"> Sign up  </a> </div>
											</li>
										</div>
									</div>
								</div>
							</section>';
									}
							?>
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