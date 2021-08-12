$(function(){
    $(document).on('click','#messagePopup',function(){
        var getMessages = 1;
        $.post('http://localhost/Twitter-Clone/core/ajax/messages.php',{showMessage:getMessages},function(data){
            $('.popupTweet').html(data);

        });
    });
});