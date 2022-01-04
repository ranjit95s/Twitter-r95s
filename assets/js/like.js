$(document).ready(function() {
	
	
	$(function(){
		// $().myfunction(1, null);
		
	});

	$(document).on('click','.like-btn', function(e){
		e.preventDefault();
			e.stopPropagation();
 		var tweet_id  = $(this).data('tweet');
		var user_id   = $(this).data('user');
		var counter   = $(this).find('.likesCounter');
		var count     = counter.text();
		var button    = $(this);
		
		$.post('http://localhost/Twitter-Clone-pre/core/ajax/like.php', {like:tweet_id, user_id:user_id}, function(){
 			counter.show();
 			button.addClass('unlike-btn');
			button.removeClass('like-btn');
			count++;
			counter.text(count);
			button.find('.fa-heart-o').addClass('fa-heart');
			button.find('.fa-heart').removeClass('fa-heart-o');
		});

		// $().myfunction("THANK U FOR LIKING !!!", "like");

		
		// $.post('http://localhost/Twitter-Clone-pre/core/ajax/like.php', {tweet_id:tweet_id}, function(data){
		// 	$('.likesCountt').html(data);
		// 	console.log('hit')
		// });
	});

	$(document).on('click','.countforFromManipulative .like-btn', function(e){
		e.preventDefault();
		e.stopPropagation();
		var tweet_id  = $(this).data('tweet');
		$.post('http://localhost/Twitter-Clone-pre/core/ajax/like.php', {tweet_id:tweet_id}, function(data){
			$('.likesCountt').html(data);
			console.log('hit')
		});
	});


	$(document).on('click','.unlike-btn', function(e){
		e.preventDefault();
			e.stopPropagation();
 		var tweet_id  = $(this).data('tweet');
		var user_id   = $(this).data('user');
		var counter   = $(this).find('.likesCounter');
		var count     = counter.text();
		var button    = $(this);

		$.post('http://localhost/Twitter-Clone-pre/core/ajax/like.php', {unlike:tweet_id, user_id:user_id}, function(){
 			counter.show();
 			button.addClass('like-btn');
			button.removeClass('unlike-btn');
			count--;
			if(count === 0){
				counter.hide();
			}else{
			  counter.text(count);
			}
			  counter.text(count);
			button.find('.fa-heart').addClass('fa-heart-o');
			button.find('.fa-heart-o').removeClass('fa-heart');
		}); 
		// $.post('http://localhost/Twitter-Clone-pre/core/ajax/like.php', {tweet_id:tweet_id}, function(data){
		// 	$('.likesCountt').html(data);
		// 	console.log('hit')
		// });
	});
	$(document).on('click','.countforFromManipulative .unlike-btn', function(e){
		e.preventDefault();
		e.stopPropagation();
		var tweet_id  = $(this).data('tweet');
		$.post('http://localhost/Twitter-Clone-pre/core/ajax/like.php', {tweet_id:tweet_id}, function(data){
			$('.likesCountt').html(data);
			console.log('hit')
		});
	});
	$(document).on('click','.bookmarkMyTweet', function(e){
		e.preventDefault();
		e.stopPropagation();
		var tweet_id  = $(this).data('tweet');
		var user  = $(this).data('user');
		// console.log(tweet_id);
		$.post('http://localhost/Twitter-Clone-pre/core/ajax/like.php', {bookmark:tweet_id , userID:user}, function(){
			console.log('hit')
		});
		$().myfunction("Tweet added to your bookmarks", "like");
	});
});