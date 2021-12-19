<?php 
	include '../init.php';
	$getFromU->preventAccess($_SERVER['REQUEST_METHOD'], realpath(__FILE__),realpath($_SERVER['SCRIPT_FILENAME']));

	if(isset($_POST) && !empty($_POST)){
		$comment = $getFromU->checkInput($_POST['comment']);
		$user_id = $_SESSION['user_id'];
		$tweetID = $_POST['tweet_id'];
		$replyTo = $_POST['user'];
		$replyTos = $_POST['ttweet'];
		// $replyTo = $getFromT->userData($tweetOwner);
		// echo $replyTos;
		$tweetImage ='';

		if(!empty($comment) or !empty($_FILES['file']['name'][0])){
            if(!empty($_FILES['filec']['name'][0])){
                $tweetImage = $getFromU->uploadImage($_FILES['file']);
            }
			$getFromU->create('comments', array('comment' => $comment, 'commentOn' => $tweetID, 'commentBy' => $user_id,'commentAt'=>date('Y-m-d H:i:s')));
			$getFromU->create('tweets', array('status' => $comment, 'tweetImage'=>$tweetImage ,'comment_tweetID' => $tweetID, 'tweetOwner' => $user_id, 'tweetBy' =>$user_id, 'commentTrue'=> 1 ,'comment_userID' => $replyTos,'postedOn'=>date('Y-m-d H:i:s')));
			$comments = $getFromT->comments($tweetID);

			foreach($comments as $comment){
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
									<h4> <a href="$" style="            color: rgb(173, 173, 173);
										font-weight: 500;
										text-decoration: none;">@'.$comment->username.'</a> </h4>
								</div>
								<div class="user-t-r-s">
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
								<h4> Replying To <span>@'.$replyTo.'</span> </h4>
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
	
							<div class="react-retweet-like">
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
					</div>
				</div> ';
			}
        }
		// $tweet = $getFromT->getPopupTweet($tweetID);


	}
?>