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
                    <div class="ssImage"> <img src="'.BASE_URL.'users/2021_12_25-16-57-19_110868.jpg" alt="sampleSection"> </div>
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

    if(isset($_POST['showpopupforVerify']) && !empty($_POST['showpopupforVerify'])){
      $user_id = @$_SESSION['user_id'];
      $user = $getFromU->userData($user_id);
     
        echo '
        <div class="wrap">
        <div class="outer-abs full-width-shrink remove-height">
        <div class="modal">
    <div class="modal__container">
      <div class="modal__featured">
        <button type="button" class="button--transparent button--close">
          <svg class="nc-icon glyph" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="32px" height="32px" viewBox="0 0 32 32">
            <g><path fill="#ffffff" d="M1.293,15.293L11,5.586L12.414,7l-8,8H31v2H4.414l8,8L11,26.414l-9.707-9.707 C0.902,16.316,0.902,15.684,1.293,15.293z"></path> </g></svg>
          <span class="visuallyhidden">Return to Product Page</span>
        </button>
        <div class="modal__circle"></div>
        <img src="https://cloud.githubusercontent.com/assets/3484527/19622568/9c972d44-987a-11e6-9dcc-93d496ef408f.png" class="modal__product" />
      </div>
      <div class="modal__content">
        <h2>Your details <span id="processFail"></span> </h2>

        <form id="processForm" >
          <ul class="form-list">
            <li class="form-list__row">
              <label>Name</label>
              <input type="text" name="" value="'.$user->screenName.'" readonly required="" />
            </li>
            <li class="form-list__row">
            <label>Select  Verification Doc</label>
            <select id="process" name="process">
              <option value="Voter ID"> Voter ID </option>
              <option value="Adharcard"> Adharcard ID </option>
            </select>
          </li>
            <li class="form-list__row">
              <label><span id="lableProces">Voter ID</span> Number</label>
              <div id="input--cc" class="creditcard-icon">
                <input id="processID" type="text" name="cc_number" required="" />
              </div>
              <div class="notes" id="example">
                  Example, ABE1234566
                </div>
            </li>
            <li class="form-list__row form-list__row--inline">
              <div>
                <label>Birth Date</label>
                <div class="form-list__input-inline">
                  <input type="text" name="cc_month" placeholder="DD"  pattern="\\d*" minlength="2" maxlength="2" required="" />
                  <input type="text" name="cc_year" placeholder="MM"  pattern="\\d*" minlength="2" maxlength="2" required="" />
                  <input type="text" name="cc_year" placeholder="YY"  pattern="\\d*" minlength="2" maxlength="4" required="" />
                </div>
              </div>
              <div>
            </li>
            <li class="form-list__row form-list__row--agree">
              <label>
                <input type="file" name="save_cc" >
                <div class="notes">
                  Upload any document proof for faster verification process (optional)
                </div>
              </label>
            </li>
            <li>
              <button id="processSubmit" data-user="'.$user->user_id.'" type="button" class="button">Submit</button>
            </li>
          </ul>
        </form>
      </div> <!-- END: .modal__content -->
    </div> <!-- END: .modal__container -->
  </div> <!-- END: .modal -->
  </div>
  </div> 
        ';
    }
    if(isset($_POST['verifyUser']) && !empty($_POST['verifyUser'])){ 
      $user_id   = $_POST['verifyUser'];
      $getFromU->verifyUser($user_id);
      
     }  

?>