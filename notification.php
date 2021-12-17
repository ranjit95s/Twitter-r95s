<?php 
		include 'core/init.php';
		$user_id = $_SESSION['user_id'];
		$user = $getFromU->userData($user_id);
	
		$notify = $getFromM->getNotificationCount($user_id);
		$getFromM->notificationViewed($user_id);
		if($getFromU->loggedIn() ===false){
			header('Location:index.php');
		}
		$notification  = $getFromM->notification($user_id);
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
					if(strlen($status)>140){
						$error = "tweet must be in 140 length";
					}
					$getFromU->create('tweets',array('status' => $status,'tweetBy'=>$user_id, 'tweetImage'=> $tweetImage,'postedOn'=> date('Y-m-d H:i:s')));
					preg_match_all("/#+([a-zA-Z0-9_]+)/i", $status, $hashtag);
					
					
					if(!empty($hashtag)){
						$getFromT->addTrend($status);
					}
				}else{	
					$error = "Type or choose image to tweet";
				}
			}

	?>

		<!DOCTYPE HTML> 
		<html>
			<head>
		<title>Notification / Tweety</title>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width">
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1" />
		<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script> 	 
 		<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style-complete.css"/>
   		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css"/>   	  
			</head>
			<!--Helvetica Neue-->
		<body>
	<div class="wrapper">
	<!-- header wrapper -->
	
	<?php 
                include 'includes/entities/side-pro-link.php';
            ?>
				<div class="in-center">
					<div class="in-center-wrap in-ce-w-exp">
						<!--TWEET WRAPPER-->
                                                    
                            <!--NOTIFICATION WRAPPER FULL WRAPPER-->
                            <div class="notification-full-wrapper">

                            <div class="notification-full-head">
							<section class="hash-hash-nav">
							<div class="hash-menu">
								<div class="hash-menu-inner">
									<ul>
										<li><a style="text-decoration: none;" href="#">All</a></li>
										<li><a style="text-decoration: none;" href="#">Mentions</a></li>
									</ul>
								</div>
							</div>
						</section>
                            </div>
					<?php foreach($notification as $data):?>
					<?php if($data->type == 'follow') :?>
                            <!-- Follow Notification -->
                            <!--NOTIFICATION WRAPPER-->
                            <div class="notification-wrapper">
                            <div class="notification-inner">
                                <div class="notification-header">
                                    
                                <div class="flexFix">
                                <div class="notification-img">
                                        <span class="follow-logo">
                                            <i class="fa fa-child" aria-hidden="true"></i>
                                        </span>
                                    </div>
                                    <div class="notification-name">
                                        <div>
                                            <img src="<?php echo BASE_URL.$data->profileImage;?>"/>
                                        </div>
                                    <div class="notification-tweet"> 
                                    <a href="<?php echo BASE_URL.$data->username;?>" class="notifi-name"><?php echo $data->screenName;?></a><span> Followed you <span><?php echo $getFromU->timeAgo($data->time);?></span>               
                                    </div>
                                    </div>

                                </div>
                                   
                                  
                                
                                </div>
                                
                            </div>
                            <!--NOTIFICATION-INNER END-->
                            </div>
                            <!--NOTIFICATION WRAPPER END-->
                            <!-- Follow Notification -->
							<?php endif;?>

							<?php if($data->type == 'like') :?>
                            <!-- Like Notification -->
                            <!--NOTIFICATION WRAPPER-->
                            <div class="notification-wrapper">
                            <div class="notification-inner">
                                <div class="notification-header">
                                    <div class="flexFix">
                                        <div class="notification-img">
                                            <span class="heart-logo">
                                                <i class="fa fa-heart" aria-hidden="true"></i>
                                            </span>
                                        </div>

                                    <div class="tweetFlex">
                                    <div class="notification-name">
                                        <div>
                                            <img src="<?php echo BASE_URL.$data->profileImage;?>"/>
                                        </div>
                                    </div>
                                    <div class="notification-tweet"> 
                                    <a href="<?php echo BASE_URL.$data->username;?>" class="notifi-name"><?php echo $data->screenName;?></a><span> liked your <?php if($data->tweetBy === $user_id){echo 'Tweet';}else{echo 'Retweet';}?> <span><?php echo $getFromU->timeAgo($data->time);?></span>
                                    </div>
                                    <div class="notification-footer">
                                    <div class="noti-footer-inner">
									<div class="noti-footer-inner-left">
											<div class="t-h-c-name">
												<span><a href="<?php echo BASE_URL.$user->username;?>"><?php echo $user->screenName;?></a></span>
												<span>@<?php echo $user->username;?></span>
												<span><?php echo $getFromU->timeAgo($data->postedOn);?></span>
											</div>
											<div class="noti-footer-inner-right-text">		
												<?php echo $getFromT->getTweetLinks($data->status)?>
											</div>
										</div>
										<?php if(!empty($data->tweetImage)):?>
                                        <div class="noti-footer-inner-right">
                                            <img src="<?php echo BASE_URL.$data->tweetImage;?>"/>	
                                        </div> 
										<?php endif;?>

                                    </div><!--END NOTIFICATION-inner-->
                                </div>

                                    </div>

                                    </div>
                                   
                                   
                                </div>
                               
                             
                            </div>
                            </div>
                            <!--NOTIFICATION WRAPPER END--> 
                            <!-- Like Notification -->
								<?php endif;?>
								<?php if($data->type == 'retweet') :?>
			<!-- Retweet Notification -->
			<!--NOTIFICATION WRAPPER-->
			<div class="notification-wrapper">
				<div class="notification-inner">
					<div class="notification-header">

                    <div class="flexFix">
                    <div class="notification-img">
							<span class="retweet-logo">
								<i class="fa fa-retweet" aria-hidden="true"></i>
							</span>
					</div>

                    <div class="tweetFlex">
                    <div class="notification-name">
                        <div>
                            <img src="<?php echo BASE_URL.$data->profileImage;?>"/>
                        </div>
                    </div>
                    
                    <div class="notification-tweet"> 
						<a href="<?php echo BASE_URL.$data->username;?>" class="notifi-name"><?php echo $data->screenName;?></a><span> retweet your <?php if($data->tweetBy === $user_id){echo 'Tweet';}else{echo 'Retweet';}?> <span><?php echo $getFromU->timeAgo($data->time);?></span>
					</div>
					<div class="notification-footer">
						<div class="noti-footer-inner">

                        <?php 
			$tweet = $data;
			$likes        = $getFromT->likes($user_id, $tweet->tweetID);
			$userRef = $getFromU->userData($tweet->tweetRefTo);
			$retweet      = $getFromT->checkRetweet($tweet->tweetID, $user_id);
    			echo '
				'.($getFromT->checkTweetExistence($tweet->tweetID) ? '
				<div class="all-tweet-inner">
				<div class="container">
                <div class="tweet-outer">
                    <div class="tweet-inner">

        
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
                                    max-width: 55vw;
                                    ">
                                    <div class="useru">
                                        <h4> <a style="color: var( --primary-text-color); font-weight: 800; text-decoration:none;" href="'.BASE_URL.$user->username.'">'.$user->screenName.'</a></h4>
                                    </div>
                                    <div class="useru">
                                        <h4 style="color: var( --secondary-text-color); font-weight: 500;">  <a style="color: var( --secondary-text-color); font-weight: 500; text-decoration:none;" href="'.BASE_URL.$user->username.'">@'.$user->username.'</a> </h4>
                                    </div>
                                    </div>
                                    <div class="useru">
                                        <h4 style="color: var( --secondary-text-color); font-weight: 500;"> • '.$getFromT->timeAgo(($tweet->postedOn)).'</h4>
                                    </div>
                                </div>
                                <div class="status">
                                    <div class="s-in">
                                        <div class="sto">
                                        '.$getFromT->getTweetLinks($tweet->status).'
                                        </div>
                                    </div>
                                </div>

                                '.(!empty($tweet->tweetImage) ? 
                                '<!--tweet show head end-->
                                <div class="imageContainer">
                                <div class="imageProposal">
                                    <div class="imageContains">
                                        <img src="'.BASE_URL.$tweet->tweetImage.'" class="imagePopup" data-tweet="'.$tweet->tweetID.'" alt="">
                                    </div>
                                </div>
                            </div>
                                    <!--tweet show body end-->
                                    ' : '' ).'

                                   
        
                                <!-- bottom S -->
                                <div class="bottom">
                                    <div class="icons-head">
                                        <div class="flex-icons">
                                            <ul>
                                            '.(($getFromT->loggedIn() ===true) ? '
                                                <li> <i class="fa fa-comment"></i> <span> '.$getFromT->countComments($tweet->tweetID).' </span> </li>
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
			</div> ' : '' ).' ';		 
			?> 

						</div>
                    </div> 

                    </div>
						
					
				<!--END NOTIFICATION-inner-->
					</div>
					</div>
				</div>
			</div>
			<!--NOTIFICATION WRAPPER END-->
			<!-- Retweet Notification -->
		<?php endif;?>
		<?php if($data->type == 'mention') :?>
			<?php 
			$tweet = $data;
			$likes        = $getFromT->likes($user_id, $tweet->tweetID);
			$userRef = $getFromU->userData($tweet->tweetRefTo);
			$retweet      = $getFromT->checkRetweet($tweet->tweetID, $user_id);
    			echo '
				'.($getFromT->checkTweetExistence($tweet->tweetID) ? '
				<div class="all-tweet-inner">
				<div class="container">
                <div class="tweet-outer">
                    <div class="tweet-inner">

        
                        <!-- flex-out S -->
                        <div class="flex-out">
                            <div class="img-user">
                                <div class="img-inner">
                                <img src="'.BASE_URL.$tweet->profileImage.'"/>
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
                                    max-width: 55vw;
                                    ">
                                    <div class="useru">
                                        <h4> <a style="color: var( --primary-text-color); font-weight: 800; text-decoration:none;" href="'.BASE_URL.$tweet->username.'">'.$tweet->screenName.'</a></h4>
                                    </div>
                                    <div class="useru">
                                        <h4 style="color: var( --secondary-text-color); font-weight: 500;">  <a style="color: var( --secondary-text-color); font-weight: 500; text-decoration:none;" href="'.BASE_URL.$tweet->username.'">@'.$tweet->username.'</a> </h4>
                                    </div>
                                    </div>
                                    <div class="useru">
                                        <h4 style="color: var( --secondary-text-color); font-weight: 500;"> • '.$getFromT->timeAgo(($tweet->postedOn)).'</h4>
                                    </div>
                                </div>
                                <div class="status">
                                    <div class="s-in">
                                        <div class="sto">
                                        '.$getFromT->getTweetLinks($tweet->status).'
                                        </div>
                                    </div>
                                </div>

                                '.(!empty($tweet->tweetImage) ? 
                                '<!--tweet show head end-->
                                <div class="imageContainer">
                                <div class="imageProposal">
                                    <div class="imageContains">
                                        <img src="'.BASE_URL.$tweet->tweetImage.'" class="imagePopup" data-tweet="'.$tweet->tweetID.'" alt="">
                                    </div>
                                </div>
                            </div>
                                    <!--tweet show body end-->
                                    ' : '' ).'

                                    '.( $tweet->tweetRef > 0 && (!empty($tweet->tweetRef))?'


                            '.($tweet->tweetRef > 0 && $getFromT->checkTweetExistence($tweet->tweetRef) ? '
                                <div class="refenceTweet">
                                

                                    <div class="ref-o">
        
                                        <div class="ref-flex">
        
                                            <div class="headerU">
                                                <div class="flex-ref-head">
                                                    <div class="imageU">
                                                        <img src="'.BASE_URL.$userRef->profileImage.'" alt="" srcset="">
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
                                                        <h4 style="color: var( --primary-text-color); font-weight: 800;">'.$userRef->screenName.'</h4>
                                                    </div>
                                                    <div class="userd">
                                                        <h4 style="color: var( --secondary-text-color); font-weight: 500;">@'.$userRef->username.'</h4>
                                                    </div>
                                                    </div>
                                                    <div class="userd">
                                                        <h4 style="color: var( --secondary-text-color); font-weight: 500;"> • '.$getFromT->timeAgo(($userRefS[0]->postedOn)).'</h4>
                                                    </div>
                                                </div>
                                                <div class="ref-status">
                                                    <h6>'.$getFromT->getTweetLinks($userRef->status).'</h6>
                                                    </div>
                                                    
                                            </div>
                                        </div>
                                    </div>
                                    '.(!empty($userRef->tweetImage) ? 
                                '<!--tweet show head end-->
                                <div class="status-image imagePopup">
                                        <img src="'.$userRef->tweetImage.'" class="imagePopup" data-tweet="'.$userRef->tweetID.'" alt="">
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
                                                <li> <i class="fa fa-comment"></i> <span> '.$getFromT->countComments($tweet->tweetID).' </span> </li>
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
			</div> ' : '' ).' ';		 
			?>
		<?php endif;?>
		<?php endforeach;?>
                            </div>
                            <!--NOTIFICATION WRAPPER FULL WRAPPER END-->


						<div class="loading-div">
							<img id="loader" src="<?php echo BASE_URL;?>assets/images/loading.svg" style="display: none;"/> 
						</div>
						<div class="clear_fix" style="display:none; height:55px; width:100%;"></div>
						<div class="popupTweet"></div>
						<!--Tweet END WRAPER-->
						<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/custome-complete-js.js"></script>
						<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/like.js"></script>
						<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/retweet.js"></script>
						<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/popuptweets.js"></script>
						<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/delete.js"></script>
						<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/comment.js"></script>
						<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/popupForm.js"></script>
						<!-- <script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/fetch.js"></script> -->
						<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/messages.js"></script>
						<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/postMessage.js"></script>
						<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/notification.js"></script>
						<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/search.js"></script>
						<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/hashtag.js"></script>
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
					<!--WHO_TO_FOLLOW HERE-->
					<?php $getFromF->whoToFollow($user_id,$user_id); ?>
					<!--Who To Follow-->

		<!--==TRENDS==-->
		<div class="trend-wrapper">
            <div class="trend-inner">
            <div class="trend-title">
            <h3>Trends</h3>
            </div>
            <!-- trend title end-->
					<?php $getFromT->trends();?>
					</div><!--TREND INNER END-->
            </div><!--TRENDS WRAPPER ENDS-->
				<!--==TRENDS==-->


					</div><!-- in left wrap-->

				</div><!-- in right end -->
				<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/follow.js"></script>

			</div><!--in full wrap end-->

		</div><!-- in wrappper ends-->
		</div><!-- inner wrapper ends-->
		</div><!-- ends wrapper -->
		<?php 
                include 'includes/entities/bottom-nav.php';
            ?>
		</body>
		</html>