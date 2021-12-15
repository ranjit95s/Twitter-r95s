$(function(){
    $(document).on('click', '#popupEditForm',function(){
        alert("txt");
        debugger;
        $.post('http://localhost/Twitter-Clone-pre/core/ajax/popupEditForm.php',function(data){
            console.log('popup !!!');
            $('.popupTweet').html(data);
            $('.close').click(function(){
                $('.popupEditForm').hide();
            });
        });
    });
    $(document).on('submit','#editform',function(e){
        console.log('edit form !!!');
        $('.popupEditForm').hide();
        e.preventDefault();
       
    });
});