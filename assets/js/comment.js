$(function(){

    // despoyboo
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
    // =================================


    // working
	// $('#postComments').click(function(){
	// 	var comment = $('#commentFields').val();
	// 	var tweet_id = $('#commentFields').data('tweet');
	// 	var user_id = $('#commentFields').data('user');
	// 	var owner = $('#commentFields').data('ttweet');
    //     // console.log(owner);
    //     if(comment != ""){
	// 	var owner = $('#commentFields').data('ttweet');
		
    //         $.post('http://localhost/Twitter-Clone-pre/core/ajax/comment.php', {comment:comment,tweet_id:tweet_id,user:user_id , replytos : owner}, function(data){
    //             $('#replySection').html(data);
    //             $('#commentFields').val('');
    //         });
    //     }
	// });

    $(document).on('submit', '#commentPost', function(e){
		e.preventDefault();
        var formData = new FormData($(this)[0]);
        formData.append('file', $('#filec')[0].files[0]);
        $.ajax({
            url: "http://localhost/Twitter-Clone-pre/core/ajax/comment.php",
            type: "POST",
            data: formData,
			success: function(data) {
                // result = JSON.parse(data);
                console.log(data);
                $('#replySection').html(data);
            },
            cache: false,
            contentType: false,
            processData: false,
            
        });
        $("#commentPost")[0].reset();

        
	});

});