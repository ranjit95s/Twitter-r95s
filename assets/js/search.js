$(function(){
    $('.search').keyup(function(){
		var search = $(this).val();
		var regex = /[#](\w+)$/ig;
		var content = $.trim($(this).val());
		var text = content.match(regex);

		if(text){
			if(text != null){
				var hashtag = 'hashtag='+text+'&links=true';
				
				// alert(hashtag)
                $.ajax({
                    type: "POST",
                    url : "http://localhost/Twitter-Clone-pre/core/ajax/getHashtag.php",
                    data : 
						hashtag , 
                    catch : false,
                    success : function (data) {
                        $('.search-result').html(data);
                        
                    }
                });
            }
        }else {
			$.post('http://localhost/Twitter-Clone-pre/core/ajax/search.php',{search:search},function(data){
				$('.search-result').html(data);
			});
		}
    });

	$(document).on('keyup', '.search-user', function(){
		$('.message-recent').hide();
		var search = $(this).val();
		$.post('http://localhost/Twitter-Clone-pre/core/ajax/searchUserInMsg.php', {search:search}, function(data){
			$('.message-body').html(data);
		});
	});
});