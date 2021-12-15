$(function(){
    // win : window
    var win = $(window);
    var offset = 10;
    win.scroll(function(){
        if($(document).height() <= (win.height() + win.scrollTop())){
            offset += 10;
            $('#loader').show();
            $.post('http://localhost/Twitter-Clone-pre/core/ajax/fetchPost.php' , {fetchPosts:offset}, function(data){
                $('.tweets').html(data);
                $('#loader').hide();
            });
        }
    });
    
});