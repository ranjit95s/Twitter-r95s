$(function() {

    // $("#homeTweet").submit(function(e){
    //     e.preventDefault();
    // });

    $(document).on('click', '.addTweetBtn', function() {
        $('.status').removeClass().addClass('status-removed');
        $('.hash-box').removeClass().addClass('hash-removed');
        $('#count').attr('id', 'count-removed');

        $.post('http://localhost/Twitter-Clone-pre/core/ajax/popupForm.php', function(data) {
            $('.popupTweet').html(data);
            $('.closeTweetPopup').click(function() {
                $('.popup-tweet-wrap').hide();
                $('.status-removed').removeClass().addClass('status');
                $('.hash-removed').removeClass().addClass('hash-box');
                $('#count-removed').attr('id', 'count');
            });
        });
    });
    $(document).on('submit', '#popupForm', function(e) {
        e.preventDefault();
        var formData = new FormData($(this)[0]);
        formData.append('file', $('#files')[0].files[0]);
        $.ajax({
            url: "http://localhost/Twitter-Clone-pre/core/ajax/addTweet.php",
            type: "POST",
            data: formData,
            success: function(data) {
                result = JSON.parse(data);
                console.log(result);
                $().myfunction(result.success, "like");
            },
            cache: false,
            contentType: false,
            processData: false
        });
        $("#popupForm")[0].reset();
        $('.popup-tweet-wrap').hide();
        var offset = 11;
        $.post('http://localhost/Twitter-Clone-pre/core/ajax/fetchPost.php' , {fetchPosts:offset}, function(data){
                $('.tweets').html(data);
            });
            
    });
});