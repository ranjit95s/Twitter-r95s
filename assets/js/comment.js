$(function(){
	$('#postComment').click(function(){
		var comment = $('#commentField').val();
		var tweet_id = $('#commentField').data('tweet');

        if(comment != ""){
            $.post('http://localhost/Twitter-Clone-pre/core/ajax/comment.php', {comment:comment,tweet_id:tweet_id}, function(data){
                $('#comments').html(data);
                $('#commentField').val('');
            });
        }
	});

	$('#postComments').click(function(){
		var comment = $('#commentFields').val();
		var tweet_id = $('#commentFields').data('tweet');
		var user_id = $('#commentFields').data('user');

        if(comment != ""){
            $.post('http://localhost/Twitter-Clone-pre/core/ajax/comment.php', {comment:comment,tweet_id:tweet_id,user:user_id}, function(data){
                $('#replySection').html(data);
                $('#commentFields').val('');
            });
        }
	});
});