<?php 
	include '../init.php';
    if(isset($_POST['showpopup']) && !empty($_POST['showpopup'])){

        echo '
        <div class="wrap">
        <div class="outer-abs full-width-shrink">

        <div class="displayCon">
         <div class="top-display">
            <div class="top-inner-head"> <span> Customize your view </span> </div>
            <div class="top-inner-tail"> <span> Manage your font size, color, and background. These settings affect all the Twitter accounts on this browser. </span> </div>
        </div>

        <div class="sampleSection">
            <div class="ssInner">
                <div class="ssflex">
                    <div class="ssImage"> <img src="'.BASE_URL.'users/sttww2.jpg" alt="sampleSection"> </div>
                    <div class="ssText">
                        <div class="ssInfoDummy">
                            <div class="ssInfo">
                                <h4> Twitter </h4>
                            </div>
                            <div class="ssInfo">
                                <h4> @Twitter </h4>
                            </div>
                            <div class="ssInfo">
                                <h4> • 14m </h4>
                            </div>
                        </div>
                        <div class="ssStatus">
                            <span id="ssStatus"> At the heart of Twitter are short messages called Tweets --- just like this one --- which include photos, videos,<span class="colorTheme"> <a> Links</a></span>, Text,<span class="colorTheme"> #Tweety</span> ,and mentions like <span class="colorTheme"> @Tweety</span>.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="colorSections">
            <div class="colorText">
                <span> Color </span>
            </div>
            <div class="colorChoice">
                <ul> 
                    <li>
                        <div class="colorPicks" data-color="Blue" data-colorcode="#1d9bf0" data-colorcodehover="#1583cc" ></div>
                    </li>
                    <li> 
                        <div class="colorPicks" data-color="Yellow" data-colorcode="#ffd400" data-colorcodehover="#dfba01" ></div>
                    </li>
                    <li> 
                        <div class="colorPicks" data-color="Pink" data-colorcode="#f91880" data-colorcodehover="#da1571" ></div>
                    </li>
                    <li> 
                        <div class="colorPicks" data-color="Purple" data-colorcode="#7856ff" data-colorcodehover="#6548d8" ></div>
                    </li>
                    <li> 
                        <div class="colorPicks" data-color="Orange" data-colorcode="#ff7a00" data-colorcodehover="#dd6b00" ></div>
                    </li>
                    <li> 
                        <div class="colorPicks" data-color="Green" data-colorcode="#00ba7c" data-colorcodehover="#00a06b" ></div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="BackcolorSections">
            <div class="BackcolorText">
                <span> Background </span>
            </div>
            <div class="backcolorChoice">
                <div class="backgroundUserPick backback lightPick" data-color="light"> 
                    <input type="radio" value="default" id="default" name="userSelectBG"> 
                    <label for="default" class="backback" data-color="light"> 
                        <div class="backGColor"> Default </div> 
                    </label>
                </div>
                <div class="backgroundUserPick backback dimPick" data-color="dim"> 
                    <input type="radio" value="dim" id="dim" name="userSelectBG">
                    <label for="dim"  class="backback" data-color="dim"> 
                        <div class="backGColor"> Dim </div>
                    </label>
                </div>
                <div class="backgroundUserPick backback darkPick" data-color="dark"> 
                    <input type="radio" value="dark" id="dark" name="userSelectBG">
                    <label for="dark"  class="backback" data-color="dark"> 
                        <div class="backGColor"> Light out </div>
                    </label>
                </div>
            </div>
        </div>

        <div class="doneUserClick">
            <div class="donePick">
                <span> Done </span>
            </div>
        </div>
        </div>

        </div>
        </div> 
        ';
    }
