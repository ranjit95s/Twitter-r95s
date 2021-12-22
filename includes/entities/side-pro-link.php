
<div class="info-box respo-info">
<?php if($getFromU->loggedIn()===true){?>
			<i class="fa fa-close close"></i>
			<div class="info-inner">
				
				<div class="info-in-head relative-pro">
					<!-- PROFILE-COVER-IMAGE -->
					<img src="<?php echo BASE_URL.$user->profileCover; ?>" />
				
				</div><!-- info in head end -->
				<div class="info-in-body">
					<div class="in-b-box">
						<div class="in-b-img fixedImage">
							<!-- PROFILE-IMAGE -->
							<img src="<?php echo BASE_URL.$user->profileImage; ?>" />
						</div>
					</div><!-- in b box end -->
					<div class="fixedImagename info-body-name">
						<div class="in-b-name">
							<div><a href="<?php echo BASE_URL.$user->username; ?>"><?php echo $user->screenName; ?></a></div>
							<span><small><a href="<?php echo BASE_URL.$user->username; ?>">@<?php echo $user->username; ?></a></small></span>
						</div><!-- in b name end -->
					</div><!-- info body name end -->
				</div><!-- info in body end -->
				<div class="info-in-footer">
					<div class="number-wrapper">
						<div class="num-box">
							<div class="num-head">
								TWEETS
							</div>
							<div class="num-body">
							<?php $getFromT->countTweets($user_id); ?>
							</div>
						</div>
						<div class="num-box">
							<div class="num-head">
								FOLLOWING
							</div>
							<div class="num-body">
							<span class="count-following"><?php echo $user->following; ?></span>
							</div>
						</div>
						<div class="num-box">
							<div class="num-head">
								FOLLOWERS
							</div>
							<div class="num-body">
							<span class="count-followers"><?php echo $user->followers; ?></span>
							</div>
						</div>
					</div><!-- mumber wrapper-->
				</div><!-- info in footer -->
			</div><!-- info inner end -->
			<?php }?>
			
			<div class="links-pro">
				<ul>
				<?php if($getFromU->loggedIn()===true){?>
					<li><a href="<?php echo BASE_URL.$user->username; ?>"><i class="fa fa-user"></i> Profile</a></li>
					<li><a href="<?php echo BASE_URL; ?>settings/account"><i class="fa fa-cog"></i> Settings</a></li>
					<li class="displayAdjust"><a> <i class="fa fa-adjust"></i> Display</a></li>
					<li><a href="<?php echo BASE_URL; ?>includes/logout.php"><i class="fa fa-sign-in"></i> Logout</a></li>
					<?php }?>
				</ul>
			</div>
		</div>
		
		
<div class="in-left">
	
<?php if($getFromU->loggedIn()===true){?>
				<div class="in-left-wrap" style="display: none;">
			<div class="info-box">
				<div class="info-inner">
					<div class="info-in-head">
						<!-- PROFILE-COVER-IMAGE -->
						<img src="<?php echo BASE_URL.$user->profileCover; ?>"/>
					</div><!-- info in head end -->
					<div class="info-in-body">
						<div class="in-b-box">
							<div class="in-b-img">
							<!-- PROFILE-IMAGE -->
								<img src="<?php echo BASE_URL.$user->profileImage; ?>"/>
							</div>
						</div><!--  in b box end-->
						<div class="info-body-name">
							<div class="in-b-name">
								<div><a href="<?php echo BASE_URL.$user->username; ?>"><?php echo $user->screenName; ?></a></div>
								<span><small><a href="<?php echo BASE_URL.$user->username; ?>">@<?php echo $user->username; ?></a></small></span>
							</div><!-- in b name end-->
						</div><!-- info body name end-->
					</div><!-- info in body end-->
					<div class="info-in-footer">
						<div class="number-wrapper">
							<div class="num-box">
								<div class="num-head">
									TWEETS
								</div>
								<div class="num-body">
									<?php $getFromT->countTweets($user_id); ?>
								</div>
							</div>
							<div class="num-box">
								<div class="num-head">
									FOLLOWING
								</div>
								<div class="num-body">
									<span class="count-following"><?php echo $user->following; ?></span>
								</div>
							</div>
							<div class="num-box">
								<div class="num-head">
									FOLLOWERS
								</div>
								<div class="num-body">
									<span class="count-followers"><?php echo $user->followers; ?></span>
								</div>
							</div>	
						</div><!-- mumber wrapper-->
					</div><!-- info in footer -->
				</div><!-- info inner end -->
			</div><!-- info box end-->
			</div><!-- in left wrap-->
			<?php }?>
			
		
			<nav class="dev-nav">
			<ul>
								<div class="dev-nav-drop">
								<div class="dev-li">
								<a href="<?php echo BASE_URL;?>home.php">
								<div class="iconTwitter" style="
								            /* display: flex; */
    color: #1d9bf0;
    margin: 0;
    /* width: 65%; */
    margin-top: 10px;
    margin-bottom: 10px;
    margin-left: 25px;
    font-size: 1.4rem;
								"> <i class="fa fa-twitter" style="   color: #1d9bf0;
    padding: 10px;"></i> </div> </a> </div>
							<?php if($getFromU->loggedIn()===true){?>
									<div class="dev-li" id="profile-dev">
										<div class="padding-profile">

										
										<div class="npx-img">
											<a href="home.php">
												<img src="<?php echo BASE_URL.$user->profileImage; ?>" />
											</a>
										</div>
										<div class="profile-dev-info ellipsis">
											<div class="info-pd"> <?php echo $user->screenName; if($user->statusVerify != 0) {echo ' <i title="User Verified" id="verifyedUser" class="fa fa-check-circle"></i>';} ?>  </div>
											<div class="info-pd" style=" font-size: 15px;
            font-weight: 500;
            color: var(--secondary-text-color);"> @<?php echo $user->username; ?> </div>
										</div>
										</div>
									</div>
									<?php }?>
									<?php if($getFromU->loggedIn()===true){?>
									<div class="dev-li">
									<a href="<?php echo BASE_URL;?>home.php">
										<!-- <i class="fa fa-home resp" style="display: none;" aria-hidden="true"></i> -->
										<li><i class="fa fa-home" aria-hidden="true"></i> <div class="cderd"> Home </div></li>
									</a>
									</div>
									<?php }?>
									<div class="dev-li">
										<a href="<?php echo BASE_URL;?>explore.php">
										<!-- <i class="fa fa-hashtag resp" style="display: none;" aria-hidden="true"></i> -->
										<li><i class="fa fa-hashtag" aria-hidden="true"></i> <div class="cderd"> Explore </div>
										</li>
										</a>
									</div>
									<?php if($getFromU->loggedIn()===true){?>
									<div class="dev-li">
										<a href="<?php echo BASE_URL;?>i/notifications">
										<!-- <i class="fa fa-bell resp" style="display: none;" aria-hidden="true"> <span id="notification" style="position:absolute;"><?php if($notify->totalN > 0){echo '<span class="span-i pro-res">'.$notify->totalN.'</span>';}?></span> </i> -->
										<li><i class="fa fa-bell" aria-hidden="true"></i> <span id="notification"><?php if($notify->totalN > 0){echo '<span class="span-i pro-i-i">'.$notify->totalN.'</span>';}?></span> <div class="cderd"> Notifications </div>  </li></a>
									</div>
									<?php }?>
									<?php if($getFromU->loggedIn()===true){?>
									<div class="dev-li" >
										<!-- <i id="main-page-msg" class="fa fa-envelope resp" style="display: none;" aria-hidden="true"> <span id="messages" style="position:absolute;"><?php if($notify->totalM > 0){echo '<span class="span-i pro-res">'.$notify->totalM.'</span>';}?></span></i> -->
										<li id="messagePopup"><i class="fa fa-envelope" aria-hidden="true"></i> <div class="cderd"> Messages </div> <span id="messages"><?php if($notify->totalM > 0){echo '<span class="span-i pro-i">'.$notify->totalM.'</span>';}?></span></li>
									</div>
									<div class="dev-li" >
										<!-- <i id="main-page-msg" class="fa fa-envelope resp" style="display: none;" aria-hidden="true"> <span id="messages" style="position:absolute;"><?php if($notify->totalM > 0){echo '<span class="span-i pro-res">'.$notify->totalM.'</span>';}?></span></i> -->
										<a href="<?php echo BASE_URL;?>i/bookmarks">
										<!-- <i class="fa fa-bell resp" style="display: none;" aria-hidden="true"> <span id="notification" style="position:absolute;"><?php if($notify->totalN > 0){echo '<span class="span-i pro-res">'.$notify->totalN.'</span>';}?></span> </i> -->
										<li><i class="fa fa-bookmark" aria-hidden="true"></i>  <div class="cderd"> Bookmarks </div>  </li></a>
									</div>
									<div class="dev-li">
										<a href="<?php echo BASE_URL.$user->username; ?>" style="text-decoration: none;">
											<!-- <i class="fa fa-user resp" style="display: none;" aria-hidden="true"></i> -->
											<li><i class="fa fa-user" aria-hidden="true"></i> <div class="cderd"> Profile </div></li>
										</a>
										
									</div>
									<div class="dev-li">
										<!-- <i class="fa fa-cogs resp more-more-i" style="display: none;" aria-hidden="true"></i> -->
										<!-- <div class="more-setting-shown-i" style="display: none;">
											<div class="x">
												<i class="fa fa-cog"><span><a href="<?php echo BASE_URL; ?>settings/account">Settings</a></span></i>
												<i class="fa fa-sign-in"><span><a href="<?php echo BASE_URL; ?>includes/logout.php">Logout</a></span></i>
											</div>
										</div> -->
										<li class="more-more"><i class="fa fa-cogs" aria-hidden="true"></i> <span class="cderd"> More </span></li>
										<div class="more-setting-shown more-setting-hidden-i" style="display: none;">
											<div class="more-setting-hidden noHover">
												<li><a href="<?php echo BASE_URL; ?>settings/account"> <i class="fa fa-cog"></i> Settings</a></li>
												<li class="displayAdjust"><a> <i class="fa fa-adjust"></i> Display</a></li>
												<li><a href="<?php echo BASE_URL; ?>includes/logout.php"> <i class="fa fa-sign-in"></i> Logout</a></li>
											</div>
										</div>
									</div>
									<?php }?>
									<?php if($getFromU->loggedIn()===true){?>
									<li id="dev-tweet" style="text-align: center; background-color: var(--primary-theme-color); color: var(--bg-text-color); width: 70%; margin: 0; margin:10px 25px; font-size: 1.3rem; display: block;">
										<label id="addTweetBtn" class="addTweetBtn dev-T">Tweet</label>
										<i id="dev-tweets" class="fa fa-leaf respT" style="display: none;" aria-hidden="true"><span>+</span></i>
									</li>
									<?php }?>
								</div>
							</ul>
						</nav>
						
				</div><!-- in left end-->
				<?php if($getFromU->loggedIn()===true){?>
				<div class="show-nav-home-mar">
						<div class="show-nav-home-fix">
							<div class="show-nav-home">
								<ul>
									<li style="float: left;"> 
										<a><img
											src="<?php echo BASE_URL.$user->profileImage; ?>"></a>
									</li>
									<li style="float: right; margin-top: 10px;"><a href="home.php"> Home </a></li>
								</ul>
							</div>
						</div>
					</div>
					<?php }?>
				
	