$(function(){

	$(document).on('click','.delete-op', function(e){
		e.preventDefault();
		e.stopPropagation();
		var tweet_id = $(this).data('tweet');
		var op = $('#d-t-b-u' + tweet_id).css('display','block')
		$('.closes' + tweet_id).click(function(e){
			op.hide();
			
			// console.log('hide')
			e.stopPropagation();
		});
	});

	$(document).on('click','.delete-ops', function(e){
		e.preventDefault();
		e.stopPropagation();
		var tweet_id = $(this).data('tweet');
		var op = $('#d-t-b-u' + tweet_id).css('display','block')
		$('.closes' + tweet_id).click(function(e){
			op.hide();
			// console.log('hide')
			e.stopPropagation();
		});
	});

	$(document).on('click','.deleteTweet',function(e){
		e.preventDefault();
		e.stopPropagation();
		var tweet_id = $(this).data('tweet');
		var tweetRef = $(this).data('re');
		var tweetRefTo = $(this).data('ret');

		console.log(tweetRefTo);
		console.log(tweet_id + ' id and user ' + tweetRefTo);
		$.post('http://localhost/Twitter-Clone-pre/core/ajax/deleteTweet.php', {showPopup:tweet_id},function(data){
			$('.popupTweet').html(data);
			$('.close-retweet-popup,.cancel-it').click(function(){
				$('.retweet-popup').hide();
				var op = $('#d-t-b-u' + tweet_id).css('display','none')
			});
			if(tweetRef > 0 && tweetRefTo > 0) {
				$(document).on('click','.delete-it',function(){
					$.post('http://localhost/Twitter-Clone-pre/core/ajax/deleteTweet.php',{deleteTweetWithRef:tweet_id,re:tweetRef,ret:tweetRefTo},function(){
						$('.retweet-popup').hide();
						
					});
					var offset = 10;
					$.post('http://localhost/Twitter-Clone-pre/core/ajax/fetchPost.php' , {fetchPosts:offset}, function(data){
							$('.tweets').html(data);
						});
						$().myfunction("Your Tweet was deleted", "deletetc");
				});
			} else {
				$(document).on('click','.delete-it',function(){
					$.post('http://localhost/Twitter-Clone-pre/core/ajax/deleteTweet.php',{deleteTweet:tweet_id},function(){
						$('.retweet-popup').hide();
					});
					var offset = 10;
					$.post('http://localhost/Twitter-Clone-pre/core/ajax/fetchPost.php' , {fetchPosts:offset}, function(data){
							$('.tweets').html(data);
						});
						$().myfunction("Your Tweet was deleted", "deletetc");
				});
			}
		});
	});

	$(document).on('click', '.deleteComment', function(){
		var tweet_id    = $(this).data('tweet');
		var commentID   = $(this).data('comment');

		$.post('http://localhost/Twitter-Clone-pre/core/ajax/deleteComment.php', {deleteComment:commentID});
		window.setTimeout(function(){location.reload()})
		// $.post('http://localhost/Twitter-Clone-pre/core/ajax/popuptweets.php', {showpopup:tweet_id}, function(data){
		// 	$('.popupTweet').html(data);
		// 	$('.tweet-show-popup-box-cut').click(function(){
		// 		$('.tweet-show-popup-wrap').hide();
				
		// 		// var selector = $('#tweety-msg').css({"display":"block"}).text("Your Comment is deleting");
		// 	});
		// });
	});
});