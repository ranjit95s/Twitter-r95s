$(document).ready(function() {



    $(document).on('click','#messagePopup',function(){
    
        

        var getMessages = 1;
        $.post('http://localhost/Twitter-Clone-pre/core/ajax/messages.php',{showMessage:getMessages},function(data){
            $('.popupTweet').html(data);
            $('#messages').hide();
            
            $('.popup-message-tweet').click(function(){
                clearInterval(timers);
            });

            $('.new-message-btn').click(function(){
                clearInterval(timers);
            });
            // $('.main-msg-inner').click(function(){
            //     clearInterval(timers);
            // });
            $('.message-h-left').click(function(){
                clearInterval(timers); 
                timer();//start
            });
            
            $(document).on('click', '.back-messages', function() {
                clearInterval(timers); 
                timer(); });
            $(document).on('click', '.close-msgPopup', function() {
                clearInterval(timers); });
                $(document).on('click', '.people-message', function() {
                    clearInterval(timers); });

           
     
        });

        getMessagesR = function(){
            $.post('http://localhost/Twitter-Clone-pre/core/ajax/messages.php',{showMessage:getMessages},function(data){
                $('.popupTweet').html(data);
                $('#messages').hide();
                
                $('.popup-message-tweet').click(function(){
                    clearInterval(timers);
                });
    
                $('.new-message-btn').click(function(){
                    clearInterval(timers);
                });
                // $('.main-msg-inner').click(function(){
                //     clearInterval(timers);
                // });
                $('.message-h-left').click(function(){
                    clearInterval(timers); 
                    timer(); //start
                });
                
                $(document).on('click', '.back-messages', function() {
                    clearInterval(timers); 
                    timer(); });
                $(document).on('click', '.close-msgPopup', function() {
                    clearInterval(timers); });
                $(document).on('click', '.people-message', function() {
                    clearInterval(timers); });
 
            });
        }
        var timers; //set 500
        var timer = function(){
            timers = setInterval(function(){
                getMessagesR();
       },1000);
       };
        timer();
        getMessagesR();

    });

	$(document).on('click', '.people-message', function(){
        var get_id = $(this).data('user');
        // console.log(get_id); alert(get_id);
        $.post('http://localhost/Twitter-Clone-pre/core/ajax/messages.php', {showChatPopup:get_id}, function(data){
            $('.popupTweet').html(data);
            if(autoscroll){
                scrollDown();
            }
            $('#chat').on('scroll',function(){
                if($(this).scrollTop() < this.scrollHeight - $(this).height()){
                    autoscroll = false;
                }else{
                    autoscroll = true;
                }
            });
            $('.close-msgPopup').click(function(){
                clearInterval(timer);
            });
         
        });
        getMessages = function(){
            $.post('http://localhost/Twitter-Clone-pre/core/ajax/messages.php', {showChatMessage:get_id}, function(data){
                $('.main-msg-inner').html(data);

                if(autoscroll){
                    scrollDown();
                    // console.log("scrolling down ....");
                }
                $('#chat').on( 'scroll', function(){
                    if($(this).scrollTop() < this.scrollHeight - $(this).height()){
						autoscroll = false;
                        // console.log("auto scroll false");
					}else{
						autoscroll = true;
					}
                });
                $('.close-msgPopup').click(function(){
                    clearInterval(timer);
                    
                });

            });
        }
        var timer = setInterval(getMessages, 1000); //set 500
        getMessages();

        autoscroll = true;
		scrollDown = function(){
			var chat  = $('#chat')[0];
            if(chat !== undefined){
				$('#chat').scrollTop(chat.scrollHeight);
			}
		}

        $(document).on('click','.back-messages',function(){
            var getMessages = 1;
            $.post('http://localhost/Twitter-Clone-pre/core/ajax/messages.php',{showMessage:getMessages},function(data){
                $('.popupTweet').html(data);
                clearInterval(timer);
            });
        });

        $(document).on('click','.deleteMsg',function(){
            var messageID = $(this).data('message');
            $('.message-del-inner').height('85px');
            $(document).on('click','.cancel',function(){
                $('.message-del-inner').height('0px');
            });
            $(document).on('click','.delete',function(){
                $.post('http://localhost/Twitter-Clone-pre/core/ajax/messages.php',{deleteMsg:messageID},function(data){
                    $('.message-del-inner').height('0px');
                
                    getMessages();
                });
            });
        });

    });
})