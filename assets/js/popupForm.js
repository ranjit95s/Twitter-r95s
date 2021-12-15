$(function() {
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
        formData.append('file', $('#file')[0].files[0]);
        $.ajax({
            url: "http://localhost/Twitter-Clone-pre/core/ajax/addTweet.php",
            type: "POST",
            data: formData,
            success: function(data) {
                result = JSON.parse(data);
                console.log(result);
            },
            cache: false,
            contentType: false,
            processData: false
        });
        $('.popup-tweet-wrap').hide();
        var selector = $('#tweety-msg').css({"display":"block"}).text("Your Tweet is adding");
    });
});