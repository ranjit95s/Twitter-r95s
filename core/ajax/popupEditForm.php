<?php
        include '../init.php';
        $user_id = @$_SESSION['user_id'];
        $user = $getFromU->userData($user_id);
        $getFromU->preventAccess($_SERVER['REQUEST_METHOD'], realpath(__FILE__),realpath($_SERVER['SCRIPT_FILENAME']));
?>


<!-- popup Profile Edit Form Start -->

    <div class="popupEditForm">
    <div class="pef-head">
                <ul>
                    <li style="width:70%;"> <i class="fa fa-close close"></i> <span>Edit Profile</span></li>
                    <li> <input id="save" class="saveUp" type="submit" value="Save"> </li>
                </ul>
            </div>
    <div class="scroll-control">
    <div class="pef-inner">
            <div class="pef-pics-o">
                <div class="inner">
                    <!--  -->
                    <div class="info-boxs pef-info-box">
				<div class="info-inner">
					<div class="info-in-head pef-info-in-head">
						<!-- PROFILE-COVER-IMAGE -->
						<img src="<?php echo $user->profileCover; ?>"/>
                        <div class="cover-cover-pic">
                            <div class="camera-pef">
                            <form method="post" id="ProCeditform" enctype="multipart/form-data">
                            <label for="files">
                                <i class="fa fa-camera" aria-hidden="true"></i>
                                <input hidden type="file" name="profileCover" onchange="this.form.submit();" id="files" />
                            </label>
                            <span class="span-text1">
                                Change your profile photo
                            </span>
                            </form>
                            </div>
                        </div>
					</div><!-- info in head end -->

               
					<div class="info-in-body">
						<div class="in-b-box">
							<div class="in-b-img pef-in-b-img">
							<!-- PROFILE-IMAGE -->
								<img src="<?php echo $user->profileImage; ?>"/>
                                <div class="img-p-pef-up-btn">
                                    <div class="pef-img-up-btn">
                                        <label for="img-upload-btn"></label>
                                        <form method="post" id="ProCeditform" enctype="multipart/form-data">
                                        <label for="profileImage">
                                            <i class="fa fa-camera" aria-hidden="true"></i>
                                            <input hidden type="file" name="profileImage" onchange="this.form.submit();" id="profileImage" />
                                        </label>
                                        </form>
                                    </div>
                                </div>
							</div>
						</div><!--  in b box end-->
					</div><!-- info in body end-->
				</div><!-- info inner end -->
			</div><!-- info box end-->
                    <!--  -->
                </div>
            </div>
            <div class="pef-user-se">
                <div class="title">
                <form id="editForm" method="post" enctype="multipart/Form-data">	
                    <ul>
                        <li> <input autocomplete="off" type="text" name="screenName" placeholder="Your Name" value="<?php echo $user->screenName; ?>" > </li>
                        <li> <textarea name="bio" id="" cols="30" rows="5" style="width: 100%;
    border-radius: 5px;
    font-size: 1.5rem;
    background: var( --primary-background-color);
    color: var( --primary-text-color);"><?php echo $user->bio; ?></textarea> </li>
                        <!-- <li> <input autocomplete="off" type="text"style="height:42px; font-size: 1.2rem;" name="bio" placeholder="Bio" value="<?php echo $user->bio; ?>" > </li> -->
                        <li> <input autocomplete="off" type="text" name="country" placeholder="Your Country Name" value="<?php echo $user->country; ?>" > </li>
                        <li> <input autocomplete="off" type="text" name="website" placeholder="Website" value="<?php echo $user->website; ?>" > </li>
                    </ul>
                    </form>
                </div>
            </div>
        </div>
    </div>

                <script type="text/javascript">
                    $('#save').click(function(){
                        $('#editForm').submit();
                        console.log('submitted !!!');
                    });
                </script>
                
    </div>

<!-- popup Profile Edit Form Start -->