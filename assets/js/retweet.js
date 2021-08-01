$(function () {
    $(document).on('click','.retweet',function(){
        var tweet_id = $(this).data('tweet');
        var user_id = $(this).data('user');
        $counter = $(this).find('.retweetsCount');
        $count = $counter.text();
        $button = $(this);

        $.post('http://localhost/Twitter-Clone/core/ajax/retweet.php',{showPopup:tweet_id,user_id:user_id},function(data){
            $('.popupTweet').html(data);
            $('.close-retweet-popup').click(function(){
                $('.retweet-popup').hide();
            });
        });


    });
});