notification = function() {
    $.get('http://localhost/Twitter-Clone-pre/core/ajax/notification.php', { showNotification: true }, function(data) {
        if (data) {
            if (data.notification > 0) {
                $('#notification').addClass('span-i');
                $('#notification').addClass('pro-i-i');
                $('#notification').html(data.notification);
            }
            if (data.messages > 0) {
                $('#messages').show();
                $('#messages').addClass('span-i');
                $('#messages').html(data.messages);
            }
        }
    }, 'json');
}

// newPost = function() {
//     $.get('http://localhost/Twitter-Clone-pre/core/ajax/fetchPost.php', { showPostNotification: true }, function(data) {
//         if (data) {
//             if (data.post > 0) {
//                 console.log(data.post + 'New Tweets');
//             }
//         }
//     }, 'json');
// }


setInterval(notification, 10000);
// setInterval(newPost, 10000);