<div class="bot-nav-main" >
		<div class="bot-nav">
			<div class="hori-nav">
				<ul class="flex-nav">
					<li>
						<a href="<?php echo BASE_URL;?>home.php"><i class="fa fa-home"> </i></a>
					</li>
					<li>
						<a href="<?php echo BASE_URL;?>explore.php"><i class="fa fa-search"></i></a>
					</li>
					<?php if($getFromU->loggedIn()===true){?>
					<li>
						<a href="<?php echo BASE_URL;?>i/notifications"><i class="fa fa-bell"><span id="notificaiton" class="dsrg"><?php if($notify->totalN > 0){echo '<span class="span-i pro-i-i-i_two">'.$notify->totalN.'</span>';}?></span> </i></a>
					</li>
					<li id="bot-nav-main" >
						<a href=""><i class="fa fa-envelope"><span id="messages" class="dsrg"><?php if($notify->totalM > 0){echo '<span class="span-i pro-i-i_two">'.$notify->totalM.'</span>';}?></span> </i></a>
					</li>
					<?php }?>
				</ul>
			</div>
		</div>
	</div>