$(function(){


		$(document).on('click','.retweet-options', function(e){
			e.preventDefault();
			e.stopPropagation();
		
			var tweet_id = $(this).data('tweet');
			// alert(tweet_id);
			var op = $('#op' + tweet_id).css('display','block').fadeIn("slow");

			$('.close' + tweet_id).click(function(e){
				e.preventDefault();
				e.stopPropagation();
	
				op.hide();
				console.log('hide')
			});

		});


	$(document).on('click','.retweet', function(e){

		e.preventDefault();
			e.stopPropagation();

		var tweet_id    = $(this).data('tweet');
		var user_id     = $(this).data('user');
	    $counter        = $('#retweet-options' + tweet_id).find(".retweetsCount");
	    $count          = $counter.text();
	    $button         = $('#retweet-options' + tweet_id)
		

		$.post('http://localhost/Twitter-Clone-pre/core/ajax/retweet.php', {showPopup:tweet_id,user_id:user_id}, function(data){
			$('.popupTweet').html(data);
			$('.close-retweet-popup').click(function(e){
				e.preventDefault();
				e.stopPropagation();
	
				$('.retweet-popup').hide();
				var op = $('#op' + tweet_id).css('display','none')
			})
		});
	});

	$(document).on('submit', '#popupRet', function(e){

		// e.preventDefault();
		// e.stopPropagation();

		var tweet_id   = $(this).data('tweet');
		var user_id    = $(this).data('user');
	    var comment    = $('.retweetMsg').val();


		// var hashtag = 'hashtag='+text+'&links=true';

		
		e.preventDefault();
        var formData = new FormData($(this)[0]);
        formData.append('file', $('#filesImage')[0].files[0]);
        $.ajax({
            url: "http://localhost/Twitter-Clone-pre/core/ajax/cus.php",
            type: "POST",
            data: formData,
			success: function(data) {
                result = JSON.parse(data);
                console.log(result);
            },
            cache: false,
            contentType: false,
            processData: false,
		
        });
        $('.popup-tweet-wrap').hide();
        // var selector = $('#tweety-msg').css({"display":"block"}).text("Your Tweet is adding");


	    // $.post('http://localhost/Twitter-Clone-pre/core/ajax/retweet.php', {retweet:tweet_id,user_id:user_id,comment:comment}, function(){
	    // 	$('.retweet-popup').hide();
		// 	var op = $('#op' + tweet_id).css('display','none')
	    // 	$count++;
	    // 	$counter.text($count);
	    // 	// $button.removeClass('retweet-options').addClass('retweeted');
	    // });

		$.post('http://localhost/Twitter-Clone-pre/core/ajax/retweet.php', {retweetQuote:tweet_id}, function(data){
			$('.qouteTweett').html(data);
			// console.log('hit')
		});

	});

	$(document).on('click', '.justCloneTweet', function(e){

		e.preventDefault();
			e.stopPropagation();

		var tweet_id   = $(this).data('tweet');
		var user_id    = $(this).data('user');
	    // var comment    = $('.retweetMsg').val();
	    $.post('http://localhost/Twitter-Clone-pre/core/ajax/retweet.php', {retweets:tweet_id,user_id:user_id}, function(){
	    	$('.retweet-popup').hide();
			var op = $('#op' + tweet_id).css('display','none')
			$counter        = $('#retweet-options' + tweet_id).find(".retweetsCount");
			$count          = $counter.text();
			$button         = $('#retweet-options' + tweet_id)
			$count++;
	    	$counter.text($count);
	    	$button.addClass('retweeted');
			op.find(".justCloneTweet").removeClass('justCloneTweet').addClass('undoRetweet').text('Undo Retweet');
	    });

		$.post('http://localhost/Twitter-Clone-pre/core/ajax/retweet.php', {justRetweets:tweet_id}, function(data){
			$('.retweett').html(data);
			// console.log('hit')
		});
	});

});