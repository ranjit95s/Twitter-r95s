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
setInterval(notification, 10000);