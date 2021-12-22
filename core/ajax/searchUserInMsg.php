<?php 
	include '../init.php';
	$getFromU->preventAccess($_SERVER['REQUEST_METHOD'], realpath(__FILE__),realpath($_SERVER['SCRIPT_FILENAME']));

	if(isset($_POST['search']) && !empty($_POST['search'])){
		$user_id = $_SESSION['user_id'];
		$search  = $getFromU->checkInput($_POST['search']);
		$result  = $getFromU->search($search);
		echo '<h4>People</h4><div class="message-recent"> ';

		if(empty($result)){
			echo ' <div class="empty-message" style="    color: #b9b3ab;
			display: flex;
			font-size: 1.3rem;
			position: relative;
			width: 100%;
			/* line-height: 15; */
			overflow-wrap: break-word;
			top: 8rem;"> <div class="state-em-msg"> <span> No result match with "'.$search.'" </span> </div> </div> ';
		} 

		foreach ($result as $user) {
			if($user->user_id != $user_id){
			echo '<div class="people-message" data-user="'.$user->user_id.'">
						<div class="people-inner">
							<div class="people-img">
								<img src="'.BASE_URL.$user->profileImage.'"/>
							</div>
							<div class="name-right">
								<div><a>'.$user->screenName.' '.(($user->statusVerify != 0) ? '<i title="User Verified" id="verifyedUser" class="fa fa-check-circle"></i>' : '').'</a></div>
								<div>@'.$user->username.'</div>
							</div>
							<div class="span-time">
								<div>'.$getFromT->timeAgo($user->joinedOn).'</div>
								
							</div>
						</div>
					</div>';
			}
		}
		echo '</div>';
	}
?>