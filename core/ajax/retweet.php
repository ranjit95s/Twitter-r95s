<?php 
	include '../init.php';
	$getFromU->preventAccess($_SERVER['REQUEST_METHOD'], realpath(__FILE__),realpath($_SERVER['SCRIPT_FILENAME']));

	$user_id = $_SESSION['user_id'];
	if(isset($_POST['retweets']) && !empty($_POST['retweets'])){
		$tweet_id  = $_POST['retweets'];
		$get_id    = $_POST['user_id'];
		$getFromT->retweets($tweet_id, $get_id ,$user_id);
	}

	if(isset($_POST['do']) && !empty($_POST['do'])){
		// $tweet_id  = $_POST['retweet'];
		$tweet_id  = $_POST['tweet_id'];
		$get_id    = $_POST['user_id'];
		$comment   = $getFromU->checkInput($_POST['retweet']);
		$tweetImage ='';



		// if(!empty($_FILES['file']['name'][0])){
		// 	$tweetImage = $getFromU->uploadImage($_FILES['file']);
		// }

		$getFromT->retweet($tweet_id, $user_id, $get_id, $comment,$tweetImage);

		
	}

	if(isset($_POST['retweetQuote']) && !empty($_POST['retweetQuote'])){
		$tweet_id = $_POST['retweetQuote'];
		$getFromT->fetchRetweetQuoteCount($tweet_id);
	}

	if(isset($_POST['justRetweets']) && !empty($_POST['justRetweets'])){
		$tweet_id = $_POST['justRetweets'];
		$getFromT->fetchLikes($tweet_id);
	}


	if(isset($_POST['showPopup']) && !empty($_POST['showPopup'])){
		$tweet_id   = $_POST['showPopup'];
		$user       = $getFromU->userData($user_id);
		$tweet      = $getFromT->getPopupTweet($tweet_id);
	
?>
<div class="retweet-popup">
<div class="wrap">
<form id="popupRet" method="POST" enctype="multipart/form-data">
	<div class="retweet-popup-body-wrap">
		<div class="retweet-popup-heading">
			<h3>Retweet this to followers?</h3>
			<span><button class="close-retweet-popup"><i class="fa fa-times" aria-hidden="true"></i></button></span>
		</div>
		<div class="giveItDamnHei" style="min-height: 20vh;
    overflow-y: scroll; overflow-x:hidden;">
		<div class="retweet-popup-input">
			<div class="retweet-popup-input-inner">
			<img class="user-w-retweet" src="<?php echo BASE_URL.$user->profileImage?>"/>
				<textarea name="retweet" id="" class="retweetMsg" placeholder="Add a comment.."></textarea>
				<!-- <input class="retweetMsg" type="text" placeholder="Add a comment.."/> -->
			</div>
		</div>
		<div class="retweet-popup-inner-body">
			<div class="retweet-popup-inner-body-inner">
				<div class="retweet-popup-comment-wrap">
					 <div class="retweet-popup-comment-head">
					 	<img src="<?php echo BASE_URL.$tweet->profileImage?>"/>
					 </div>
					 <div class="retweet-popup-comment-right-wrap">
						 <div class="retweet-popup-comment-headline">
						 	<a><?php echo $tweet->screenName;?> </a><span> · ‏<?php echo $getFromT->timeAgo($tweet->postedOn);?></span> <br> <span>@<?php echo $tweet->username;?> </span>
						 </div>
						 
						 <div class="retweet-popup-comment-body">
						 	<?php echo $tweet->status;?>
							
							<?php if (!empty($tweet->tweetImage)) { 
							echo '<div class="retweet-popup-comment-body-image" style="width: 100%;
							height: 14.5rem;">
												<img style="width: inherit;
							object-fit: cover;
							border-radius: 15px;
							height: 100%;" class="retweet-images" src="'.BASE_URL.$tweet->tweetImage.'?>" alt="">
												 </div>';	
							}?>
						 </div>
						 </div>
					 </div>
				</div>
			</div>
		<div class="retweet-popup-footer"> 
		
		<div class="fileupload">
		<input type="text" name="tweetID" value="<?php echo $tweet->tweetID?>" hidden>
		<input type="text" name="userID" value="<?php echo $tweet->user_id?>" hidden>
		<input type="file" name="filesImage" id="filesImage" hidden>
        <li><label for="filesImage"><i class="fa fa-camera" aria-hidden="true" ></i> <span style="font-size: 15px;" id="filenameR">  </span> </label></li>
		<div class="retweet-popup-footer-right">
			<button class="retweet-it" data-tweet="<?php echo $tweet->tweetID;?>" data-user="<?php echo $tweet->user_id;?>" type="submit"><i class="fa fa-retweet" aria-hidden="true"></i>Retweet</button>
		</div>
		</div>
	
		</div>
		</div>
	</div>
	</form>
</div>
</div><!-- Retweet PopUp ends-->
<?php }?>
