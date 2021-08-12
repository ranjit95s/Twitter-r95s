<?php 

    include '../init.php';

    if(isset($_POST['showMessage']) && !empty($_POST['showMessage'])){
        $user_id = $_SESSION['user_id'];
        $messages = $getFromM->recentMessages($user_id);

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
			<label for="popup-message-tweet" ><i class="fa fa-times" aria-hidden="true"></i></label>
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

        <?php foreach($messages as $message) :?>
			<!--Direct Messages-->
			<div class="people-message">
				<div class="people-inner">
					<div class="people-img">
						<img src="<?php echo BASE_URL.$message->profileImage;?>"/>
					</div>
					<div class="name-right2">
						<span><a href="#"><?php echo $message->screenName;?></a></span><span>@<?php echo $message->username;?></span>
					</div>
					
					<span>
					<?php echo $getFromU->timeAgo($message->messageOn);?>
					</span>
				</div>
			</div>
			<!--Direct Messages-->
            <?php endforeach;?>
		</div>
	</div>
	<!--message FOOTER-->
	<div class="message-footer">
		<div class="ms-fo-right">
			<label>Next</label>
		</div>
	</div><!-- message FOOTER END-->
</div><!-- MESSGAE send ENDS-->
 
 
	<input id="mass" type="checkbox" checked="unchecked" />
	<div class="back">
		<div class="back-header">
			<div class="back-left">
				Direct message
			</div>
			<div class="back-right">
				<label for="mass"  class="new-message-btn">New messages</label>
				<label for="popup-message-tweet"><i class="fa fa-times" aria-hidden="true"></i></label>
			</div>
		</div>
		<div class="back-inner">
			<div class="back-body">
			<!--Direct Messages-->
            <?php foreach($messages as $message) :?>
				<div class="people-message">
					<div class="people-inner">
						<div class="people-img">
							<img src="<?php echo BASE_URL.$message->profileImage;?>"/>
						</div>
						<div class="name-right2">
							<span><a href="#"></a><?php echo $message->screenName;?></span><span>@<?php echo $message->username;?></span>
						</div>
						<div class="msg-box">
                        <?php echo $message->message;?>
						</div>

						<span>
                        <?php echo $getFromU->timeAgo($message->messageOn);?>
						</span>
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
<!-- POPUP MESSAGES END HERE -->
        
        <?php 
    }

?>