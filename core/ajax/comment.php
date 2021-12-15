<?php 
	include '../init.php';
	$getFromU->preventAccess($_SERVER['REQUEST_METHOD'], realpath(__FILE__),realpath($_SERVER['SCRIPT_FILENAME']));

	if(isset($_POST['comment']) && !empty($_POST['comment'])){
		$comment = $getFromU->checkInput($_POST['comment']);
		$user_id = $_SESSION['user_id'];
		$tweetID = $_POST['tweet_id'];
		$replyTo = $_POST['user'];
		// $replyTo = $getFromT->userData($tweetOwner);
		// echo $replyTo;
		$getFromU->create('comments', array('comment' => $comment, 'commentOn' => $tweetID, 'commentBy' => $user_id,'commentAt'=>date('Y-m-d H:i:s')));
		$comments = $getFromT->comments($tweetID);
		// $tweet = $getFromT->getPopupTweet($tweetID);

		foreach($comments as $comment){
			echo'<div class="replyuser">
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
								<h4> <a href="$" style="            color: rgb(173, 173, 173);
									font-weight: 500;
									text-decoration: none;">@'.$comment->username.'</a> </h4>
							</div>
							<div class="user-t-r-s">
								<h4> • 		'.$getFromT->timeAgo(($comment->commentAt)).' </h4>
							</div>
							'.(($comment->commentBy === $user_id) ? '
										
							<div class="delete-op" data-tweet="'.$comment->commentID.'" > <i class="fa fa-ellipsis-v ellipsiss"></i> 
							<div class="d-t-b-u" id="d-t-b-u'.$comment->commentID.'">
							<div class="prop">
							<label class="deleteComment" data-tweet="'.$tweetID.'" data-comment="'.$comment->commentID.'">Delete Tweet</label>
						   <i class="fa fa-close closes closes'.$comment->commentID.'"></i>
							</div>
							</div>
							</div>
							' : '').'
						</div>
						<div class="replyTo-user">
							<h4> Replying To <span>@'.$replyTo.'</span> </h4>
						</div>
						<div class="status-reply5">
						'.$getFromT->getTweetLinks($comment->comment).'
						</div>
						<div class="react-retweet-like">
						<ul>
						<li> <i class="fa fa-comment-o"></i> </li>
						<li> <i class="fa fa-retweet"></i> </li>
						<li> <i class="fa fa-heart-o"></i> </li>
						<li> <i class="fa fa-share"></i> </li>
					</ul>
						</div>
					</div>
				</div>
			</div> ';
		}
	}
?>