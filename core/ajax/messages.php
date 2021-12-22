<?php 

    include '../init.php';
	$getFromU->preventAccess($_SERVER['REQUEST_METHOD'], realpath(__FILE__),realpath($_SERVER['SCRIPT_FILENAME']));


	if(isset($_POST['deleteMsg']) && !empty($_POST['deleteMsg'])){
		$user_id = $_SESSION['user_id'];
		$messageID = $_POST['deleteMsg'];
		$getFromM->deleteMsg($messageID,$user_id);
	}

	if(isset($_POST['sendMessage']) && !empty($_POST['sendMessage'])){
		$user_id = $_SESSION['user_id'];
		$message = $getFromU->checkInput($_POST['sendMessage']);
		$get_id = $_POST['get_id'];
		if(!empty($message)){
			$getFromU->create('messages', array('messageTo' => $get_id, 'messageFrom' => $user_id, 'message' => $message, 'messageOn' => date('Y-m-d H:i:s')));
			// $getFromU->create('messages', array('messageTo' => $get_id, 'messageFrom' => $user_id, 'message' => $message, 'messageOn' => date('Y-m-d H:i:s')));

		}
	}

	if(isset($_POST['showChatMessage']) && !empty($_POST['showChatMessage'])){
		$user_id = $_SESSION['user_id'];
		$messageFrom = $_POST['showChatMessage'];
		$getFromM->getMessages($messageFrom, $user_id);
	}

	if(isset($_POST['showMessage']) && !empty($_POST['showMessage'])){
		$user_id = $_SESSION['user_id'];
		$messages = $getFromM->recentMessages($user_id);
		$getFromM->messagesViewed($user_id);
		
		?>
		<div class="popup-message-wrap">
			<input id="popup-message-tweet" type="checkbox" checked="unchecked"/>
			<div class="wrap2">
			<div class="message-send">
				<div class="message-header">
					<div class="message-h-left">
						<label for="mass"><i class="fa fa-angle-left" aria-hidden="true"></i></label>
					</div>
					<div class="message-h-cen">
						<h4>New message</h4>
					</div>
					<div class="message-h-right">
						<label for="popup-message-tweet" class="popup-message-tweet" ><i class="fa fa-times" aria-hidden="true"></i></label>
					</div>
				</div>
				<div class="message-input">
					<h4>Send message to:</h4>
				<input type="text" placeholder="Search people" class="search-user"/>
					<ul class="search-result down">
							
					</ul>
				</div>
				<div class="message-body">
					<h4>Recent</h4>
					<div class="message-recent">
					<?php if(empty($messages)){
								echo ' <div class="empty-message" style="    color: var( --secondary-text-color);
								display: flex;
								font-size: 1.3rem;
								position: relative;
								width: 100%;
								/* line-height: 15; */
								overflow-wrap: break-word;
								top: 8rem;"> <div class="state-em-msg"> <span> You haven`t start any conversation --yet </span> </div> </div> ';
							} ?>
					<?php foreach($messages as $message) :?>

						<?php 
							if($message->messageTo != $user_id){
							$user = $getFromU->userData($message->messageTo); 
						}else{
							$user = $getFromU->userData($message->messageFrom); 
						}
							?>
						<!--Direct Messages-->
						<div class="people-message" data-user="<?php echo $user->user_id;?>">
							<div class="people-inner">
								<div class="people-img">
								<a href="<?php echo BASE_URL.$user->username;?>"><img src="<?php echo BASE_URL.$user->profileImage;?>"/></a>
								</div>
								<div class="name-right2">
									<div><a href="#"><?php echo $user->screenName;  if($user->statusVerify != 0) {echo ' <i title="User Verified" id="verifyedUser" class="fa fa-check-circle"></i>';}?></a></div> 
								
									<div>@<?php echo $user->username;?></div>
								</div>
								
								<span class="recent-time">
									<?php echo $getFromU->timeAgo($message->messageOn);?>
								</span>
							</div>
						</div>
						<!--Direct Messages-->
					<?php endforeach;?>
					</div>
				</div>
				<!--message FOOTER-->
				<!-- <div class="message-footer">
					<div class="ms-fo-right">
						<label>Next</label>
					</div>
				</div>message FOOTER END -->
				</div><!-- MESSGAE send ENDS-->
				<input id="mass" type="checkbox" checked="unchecked" />
				<div class="back">
					<div class="back-header">
						<div class="back-left">
							Direct message
						</div>
						<div class="back-right">
							<label for="mass"  class="new-message-btn">New messages</label>
							<label for="popup-message-tweet" class="popup-message-tweet"><i class="fa fa-times" aria-hidden="true"></i></label>
						</div>
					</div>
					<div class="back-inner">
						<div class="back-body">
							<?php if(empty($messages)){
								echo ' <div class="empty-message" style="    color: var( --secondary-text-color);
								display: flex;
								font-size: 1.3rem;
								position: relative;
								width: 100%;
								/* line-height: 15; */
								overflow-wrap: break-word;
								top: 8rem;"> <div class="state-em-msg"> <span> You haven`t start any conversation --yet </span> </div> </div> ';
							} ?>
						<?php foreach($messages as $message) :?>

							<?php 
							if($message->messageTo != $user_id){
							$user = $getFromU->userData($message->messageTo); 
						}else{
							$user = $getFromU->userData($message->messageFrom); 
						}
							?>

							<!--Direct Messages-->
							<div class="people-message" data-user="<?php echo $user->user_id;?>">

								<div class="inner-msg">
								
								<div class="user-msg-info">
								<div class="user-pic" style="
								width:70px; height:70px;
								">
								<a href="<?php echo BASE_URL.$user->username;?>">
								<img style="
								width:100%; height:100%; border-radius:50%;
								" src="<?php echo BASE_URL.$user->profileImage;?>"/>
								</a>
								</div>

								<div class="user-data-msg">
									<div class="sc-ur">
										<div class="info-mmmssgg">
										<?php echo $user->screenName;  if($user->statusVerify != 0) {echo ' <i title="User Verified" id="verifyedUser" class="fa fa-check-circle"></i>';}?>
										</div>
										<div class="info-mmmssgg" style="color: var( --secondary-text-color);">
										@<?php echo $user->username;?>
										</div>
									</div>
									<div class="msg-user-send ellipsis">
									<?php if($message->messageFrom === $user_id){ echo "You : ".$message->message; }else{echo $message->message;} ?>
									</div>
								</div>
								<div class="span-time">
								<?php echo $getFromU->timeAgo($message->messageOn);?>
								</div>
								</div>

								</div>

							</div>
							<!--Direct Messages-->
						<?php endforeach;?>
						</div>
					</div>
					<div class="back-footer">
					</div>
				</div>
				</div>
			</div>
		<?php
	}
	if(isset($_POST['showChatPopup']) && !empty($_POST['showChatPopup'])){
		$messageFrom = $_POST['showChatPopup'];
		$user_id = $_SESSION['user_id'];
		$user    = $getFromU->userData($messageFrom);
		?>
		
		<!-- MESSAGE CHAT START -->
			<div class="popup-message-body-wrap">
			<input id="popup-message-tweet" type="checkbox" checked="unchecked"/>
			<input id="message-body" type="checkbox" checked="unchecked"/>
			<div class="wrap3">
			<div class="message-send2">
				<div class="message-header2">
					<div class="message-h-left">
						<label class="back-messages" for="mass"><i class="fa fa-angle-left" aria-hidden="true"></i></label>
					</div>
					<div class="message-h-cen">
						<div class="message-head-img">
						<a href="<?php echo BASE_URL.$user->username;?>"><img src="<?php echo BASE_URL.$user->profileImage;?>"/> </a>
						
						<h4><?php echo $user->screenName;  if($user->statusVerify != 0) {echo ' <i title="User Verified" id="verifyedUser" class="fa fa-check-circle"></i>';}?> <br> <span style="    position: relative;
    top: -28px;
	color:var( --secondary-text-color);
    left: -2px;"> @<?php echo $user->username;?> </span> </h4>
						
					
					</div>
					</div>
					<div class="message-h-right">
					<label class="close-msgPopup" id="closeMsg" for="message-body" ><i class="fa fa-times" aria-hidden="true"></i></label> 
					</div>
				
				</div>
				<div class="main-msg-wrap">
				<div class="message-del">
						<div class="message-del-inner">
							<h4>Are you sure you want to delete this message? </h4>
							<div class="message-del-box">
								<span>
									<button class="cancel" value="Cancel">Cancel</button>
								</span>
								<span>	
									<button class="delete" value="Delete">Delete</button>
								</span>
							</div>
						</div>
					</div>
				<div id="chat" class="main-msg-inner">
			<!-- All CHAT GOES HERE -->
				</div>
				</div>
				<div class="main-msg-footer">
					<div class="main-msg-footer-inner">
						<ul>
							<li><textarea id="msg" name="msg" placeholder="Write some thing!"></textarea></li>
							<li><input id="msg-upload" type="file" value="upload"/><label for="msg-upload"><i class="fa fa-camera" aria-hidden="true"></i></label></li>
							<li><input id="send" type="submit" data-user="<?php echo $messageFrom;?>" value="Send"/></li>
						</ul>
					</div>
				</div>
			</div> <!--MASSGAE send ENDS-->
			</div> <!--wrap 3 end-->
			</div><!--POP UP message WRAP END-->
		
			<!-- message Chat popup end -->
		
		<?php 
	}

?>