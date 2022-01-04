$(document).ready(function () {



  var preLoader = document.getElementById('preLoader');

	function loader() {
		preLoader.style.display = 'none';
		console.log("hide");
	}

  $("#preLoader").show();
		// $("#preLoader").show();
		console.log('gege');
		function ahref() {
			$("#preLoader").hide();
		};
		window.setTimeout(ahref, 500); // 1.5 seconds

  $(function () {
    // $().myfunction("TEXT SAMPLE", null); // [for notify { 1st arg is notify message and 2nd arg is type of message eg. success or danger }]

    if ( window.history.replaceState ) {
      window.history.replaceState( null, null, window.location.href );
    }

    var dontExecute = location.pathname;
		dontExecute = dontExecute.substring(dontExecute.lastIndexOf('/'));
    // console.log(current);
    if (dontExecute != '/explore.php'){
      var s = $(".in-right");
      var top = ($('.in-right').offset() || { "top": NaN }).top;
      if (isNaN(top)){
       console.log('undefined');
      //  $().myfunction("No such a element found", null);
    }else {
      var pos = s.offset().top+s.height(); //offset that you need is actually the div's top offset + it's height
      $(window).scroll(function() {
          var windowpos = $(window).scrollTop(); //current scroll position of the window
          var windowheight = $(window).height(); //window height
          if (windowpos+windowheight>pos) s.addClass('stick'); //Currently visible part of the window > greater than div offset + div height, add class
          else s.removeClass('stick');
      });
    }
  }



    $('.show-nav-home ul li a img').click(function () {
      var pro = $('.respo-info');
      if ((pro).css('display') == 'none') {
        $('.respo-info').show('fast');
      } else {
        $('.respo-info').hide('slow');
      }
    });

    $('.close').click(function () {
      $('.respo-info').hide('slow');
    });

    $('.more-more').click(function () {
      if ($(".more-setting-shown").css('display') === 'none') {
        $('.more-setting-shown').css({ 'display': 'block' });
      } else {
        $('.more-setting-shown').css({ 'display': 'none' });
      }
    });
    $('.more-more-i').click(function () {
      if ($(".more-setting-shown-i").css('display') === 'none') {
        $('.more-setting-shown-i').css({ 'display': 'block' });
      } else {
        $('.more-setting-shown-i').css({ 'display': 'none' });
      }
    });
    $(document).on('click', '#bot-nav-main', function (event) {
      event.preventDefault();
      $("#messagePopup").click();
    });
    $(document).on('click', '#main-page-msg', function (event) {
      event.preventDefault();
      $("#messagePopup").click();
    });
    $(document).on('click', '#dev-tweets', function (event) {
      event.preventDefault();
      $("#addTweetBtn").click();
    });
    $(document).on('click', '#float-tweet', function (event) {
      event.preventDefault();
      $("#addTweetBtn").click();
    });


    $(document).on('change', '#files', function () {
      var filename = $('#files')[0].files[0];
      // console.log(filename.name);
      $('#filenameP').html(filename.name);
    });
    $(document).on('change', '#files', function () {
      var filename = $('#files')[0].files[0];
      // console.log(filename.name);
      $('#filename').text(filename.name);
      $('#filenameP').html(filename.name);
    });


    $(document).on('change', '#filesImage', function () {
      var filename = $('#filesImage')[0].files[0];
      // console.log(filename.name);
      $('#filenameR').html(filename.name);
    });


    $(document).on('change', '#filec', function () {
      var filename = $('#filec')[0].files[0];
      console.log(filename.name);
      $('#filenamec').text(filename.name);
    });

    var current = location.pathname;
		current = current.substring(current.lastIndexOf('/'));
		$('.dev-li a').each(function(){
			var $this = $(this);
			// if the current path is like this link, make it active
			var data = $this.attr('href');
			if(data && data.indexOf(current) !== -1){
				var counter = $(this).find('li');
				counter.addClass('active');
			}
			// console.log($this[0]);
			
		});

		$('.flex-nav li a').each(function(){
			var $this = $(this);
			// if the current path is like this link, make it active
			var data = $this.attr('href');
			if(data && data.indexOf(current) !== -1){
				// var counter = $(this).find('li');
				$this.addClass('active');
			}
			// console.log($this[0]);
		});


    $(document).on('click','.colorPicks',function(e){
		
      var dataColor = $(this).data("color");
      var dataColorCode = $(this).data("colorcode");
      var dataColorCodeHover = $(this).data('colorcodehover');
      // alert('color name is ' + dataColor + ' code is ' + dataColorCode + ' hover code is ' + dataColorCodeHover);
      
      if(dataColor=="Blue"){
        blueMode();
      }else if(dataColor =="Yellow"){
        yellowMode();
      }else if(dataColor =="Pink"){
        pinkMode();
      }else if(dataColor =="Purple"){
        purpleMode();
      }else if(dataColor =="Orange"){
        orangeMode();
      }else if(dataColor =="Green"){
        greenMode();
      }else{
        blueMode();
      }
  
  
  
    });
  
      function blueMode(){
        $("body").get(0).style.setProperty("--primary-theme-color", "#1d9bf0");
        $("body").get(0).style.setProperty("--primary-theme-colorh", "#1583cc");
        $("body").get(0).style.setProperty("--pro-convert", "30, 156, 241");
        localStorage.setItem("themeMode", "Blue");
        }
      function yellowMode(){
        $("body").get(0).style.setProperty("--primary-theme-color", "#ffd400");
        $("body").get(0).style.setProperty("--primary-theme-colorh", "#dfba01");
        $("body").get(0).style.setProperty("--pro-convert", "255, 212, 0");
        localStorage.setItem("themeMode", "Yellow");
        }
      function pinkMode(){
        $("body").get(0).style.setProperty("--primary-theme-color", "#f91880");
        $("body").get(0).style.setProperty("--primary-theme-colorh", "#da1571");
        $("body").get(0).style.setProperty("--pro-convert", "249, 24, 128");
        localStorage.setItem("themeMode", "Pink");
        }
      function purpleMode(){
        $("body").get(0).style.setProperty("--primary-theme-color", "#7856ff");
        $("body").get(0).style.setProperty("--primary-theme-colorh", "#6548d8");
        $("body").get(0).style.setProperty("--pro-convert", "120, 86, 255");
        localStorage.setItem("themeMode", "Purple");
        }
      function orangeMode(){
        $("body").get(0).style.setProperty("--primary-theme-color", "#ff7a00");
        $("body").get(0).style.setProperty("--primary-theme-colorh", "#dd6b00");
        $("body").get(0).style.setProperty("--pro-convert", "255, 122, 0");
        localStorage.setItem("themeMode", "Orange");
        }
      function greenMode(){
        $("body").get(0).style.setProperty("--primary-theme-color", "#00ba7c");
        $("body").get(0).style.setProperty("--primary-theme-colorh", "#00a06b");
        $("body").get(0).style.setProperty("--pro-convert", "0, 186, 124");
        localStorage.setItem("themeMode", "Green");
        }
  
  
        function darkmode(){
            $('body').toggleClass("dark-mode").removeClass("light-mode").removeClass("dim-mode");
            localStorage.setItem("mode", "dark");
            }
        function dimmode(){
            $('body').toggleClass("dim-mode").removeClass("light-mode").removeClass("dark-mode");
            localStorage.setItem("mode", "dim");
            }
        function lightmode(){
            $('body').removeClass("dim-mode").removeClass("dark-mode");
            localStorage.setItem("mode", "light");
            }
  
        var mode = localStorage.getItem('mode');
        var themeMode = localStorage.getItem('themeMode');
        
        if(themeMode=="Blue"){
          blueMode();
        }else if(themeMode =="Yellow"){
          yellowMode();
        }else if(themeMode =="Pink"){
          pinkMode();
        }else if(themeMode =="Purple"){
          purpleMode();
        }else if(themeMode =="Orange"){
          orangeMode();
        }else if(themeMode =="Green"){
          greenMode();
        }else{
          blueMode();
        }
  
        if(mode=="dark"){
          darkmode();
        }else if(mode =="dim"){
          dimmode();
        }
        else{
          lightmode();
        }
  
    $(document).on('change','.backback',function(e){
      // e.stopPropagation();
      var dataColor = $(this).data('color');
      if(dataColor == 'light'){
        lightmode();
  
      }else if(dataColor == 'dim'){
        dimmode();
        $("#dim").prop('checked', true);
      }else if(dataColor == 'dark'){
        darkmode();
        $("#dark").prop('checked', true);
      }
    });

 
  
  
    $(document).on('click','.displayAdjust',function(e){
      var dataColor = "light";
    
      $.post('http://localhost/Twitter-Clone-pre/core/ajax/display.php', {showpopup:dataColor}, function(data){
              $('.popupTweet').html(data);
              $('.donePick').click(function(){
                  $('.wrap').hide();
              });
          });
      $('.more-setting-shown').hide();
    });

   

    $(document).on('click','#req-for-verify-form',function(e){
      var dataColor = "req-for-verify";
      
    
        $.post('http://localhost/Twitter-Clone-pre/core/ajax/display.php', {showpopupforVerify:dataColor}, function(data){
                $('.popupTweet').html(data);
                $('.donePick').click(function(){
                    $('.wrap').hide();
                });
            });
        $('.more-setting-shown').hide();
     
    });

    $(document).on('change','#process',function(){
      var optionSelected = $("option:selected", this);
      var valueSelected = this.value;
      var example = $('#example');
      $('#lableProces').text(valueSelected)
      if(valueSelected == 'Voter ID'){
        example.text('Example, ABE1234566');
      }else {
        example.text('Example, 3675 9834 6015');
      }

 
    });

    $(document).on('click','#processSubmit',function(){
      value = $("#processID").val(); 
      var user_id   = $(this).data('user');
      processSelection = $("#process").val(); 
      console.log(processSelection + ' ' + value );
    if(processSelection == 'Voter ID'){
      var regex = /^([a-zA-Z]){3}([0-9]){7}?$/g;
      if (!regex.test(value)) {
        $('#processFail').text('(Invalid Voter ID Number)');
        $('#processForm')[0].reset();
      } else {
       
        console.log(user_id);
        $().myfunction("Form validated! Check status after sometime", "like");
        $('.wrap').hide();
        $.post('http://localhost/Twitter-Clone-pre/core/ajax/display.php', {verifyUser:user_id}, function(){
          console.log('posted');
        });
      }
      }else if(processSelection == 'Adharcard'){
        var regex = /^\d{4}\s\d{4}\s\d{4}$/g;
        if (!regex.test(value)) {
          $('#processFail').text('(Invalid Adharcard ID Number)');
          $('#processForm')[0].reset();
        } else {
          var user_id   = $('#processSubmit').data('user');
          $().myfunction("Form validated! Check status after sometime", "like");
          $('.wrap').hide();
          $.post('http://localhost/Twitter-Clone-pre/core/ajax/display.php', {verifyUser:user_id}, function(){
            console.log('posted');
          });
        }
      }
    })

    $(document).on('click','.all-tweet', function(e){
      var tweet_id  = $(this).data('tweet');
      var user_id   = $(this).data('user');
      var base = "http://localhost/Twitter-Clone-pre/";
      if( $(e.target).is('.retweet-options') ) {
        e.preventDefault();
        e.stopPropagation();
        //your logic for the button comes here
      }else {
        window.location.href= base + user_id + '/status/' + tweet_id;
      }
    });
  
      
    $(document).on('click', '.refenceTweet', function(e) {
        e.preventDefault();
        e.stopPropagation();
  
      var tweet_id  = $(this).data('tweet');
      var user_id   = $(this).data('user');
      var base = "http://localhost/Twitter-Clone-pre/";
      window.location.href= base + user_id + '/status/' + tweet_id;
    });

    $(document).on('click', '.userTweet-flex', function(e) {
        e.preventDefault();
        e.stopPropagation();
  
      var tweet_id  = $(this).data('tweet');
      var user_id   = $(this).data('user');
      var base = "http://localhost/Twitter-Clone-pre/";
      window.location.href= base + user_id + '/status/' + tweet_id;
    });

    $(document).on('click', '.replyuser', function(e) {
        e.preventDefault();
        e.stopPropagation();
  
      var tweet_id  = $(this).data('tweet');
      var user_id   = $(this).data('user');
      var base = "http://localhost/Twitter-Clone-pre/";
      window.location.href= base + user_id + '/status/' + tweet_id;
    });
  

  });
});

(function ($) {

  $.fn.myfunction = function ($notifyMsg, $success) {

    var iconSign = $('#iconSign');

    var like = 'fa-heart';
    var deletetc = 'fa-angellist';


    if ($success != null) {
      if($success == 'like'){
        iconSign.addClass(like);
      }else if($success == 'deletetc'){
        iconSign.addClass(deletetc);
      }
      console.log($success);
    }


    $('.alert').addClass("show");
    $('.alert').removeClass("hide");
    $('.alert').addClass("showAlert");
    $('.msgs').text($notifyMsg);

    setTimeout(function () {
      $('.alert').removeClass("show");
      $('.alert').addClass("hide");
    }, 2500);
  };

  $('.close-btn').click(function () {
    $('.alert').removeClass("show");
    $('.alert').addClass("hide");
  });
})(jQuery);
