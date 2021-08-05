$(function(){

	$(document).on('click','.deleteTweet',function(){
		var tweet_id = $(this).data('tweet');
		$.post('http://localhost/Twitter-Clone/core/ajax/deleteTweet.php', {showPopup:tweet_id},function(data){
			$('.popupTweet').html(data);
			$('.close-retweet-popup,.cancel-it').click(function(){
				$('.retweet-popup').hide();
			});
			$(document).on('click','.delete-it',function(){
				$.post('http://localhost/Twitter-Clone/core/ajax/deleteTweet.php',{deleteTweet:tweet_id},function(){
					$('.retweet-popup').hide();
					location.reload();
				});
			});
		});
	});

	$(document).on('click', '.deleteComment', function(){
		var tweet_id    = $(this).data('tweet');
		var commentID   = $(this).data('comment');

		$.post('http://localhost/Twitter-Clone/core/ajax/deleteComment.php', {deleteComment:commentID});
		$.post('http://localhost/Twitter-Clone/core/ajax/popuptweets.php', {showpopup:tweet_id}, function(data){
			$('.popupTweet').html(data);
			$('.tweet-show-popup-box-cut').click(function(){
				$('.tweet-show-popup-wrap').hide();
			});
		});
	});
});