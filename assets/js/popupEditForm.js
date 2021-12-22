$(function(){
    $(document).on('click', '#edit-from-follow',function(){
      
    
        $.post('http://localhost/Twitter-Clone-pre/core/ajax/popupEditForm.php',function(data){
            console.log('popup !!!');
            $('.popupTweet').html(data);
            $('.close').click(function(){
                $('.wrap').hide();
            });
        });
    });
    $(document).on('submit','#editform',function(e){
        console.log('edit form !!!');
        $('.wrap').hide();
        e.preventDefault();
       
    });
});