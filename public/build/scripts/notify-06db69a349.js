$(function($){
    var running = false;
    var showNote = function(msg) {
        $('.notifyjs-wrapper').remove();
        $.notify(msg, {
            position:  'top center',
            autoHide: false,
            clickToHide: false
        });
    };
    var runner = setInterval(function(){
        check();
    }, 30000);


    function check() {
        if (running == false) {
            running = true;
            var url = '/services/notifications/';
            if (typeof currentChatId !== 'undefined') {
                // the variable is defined
                url = '/services/notifications/'+currentChatId;
            }

            $.get( url, function(data) {
                if (data.status == "success") {
                    if (data.data.notifications.length > 0) {
                        var num = data.data.notifications.length;
                        var msg = "message";
                        if (num > 1) {
                            msg = "messages"
                        }

                        showNote(num + ' ' + msg);
                    }
                }
            })
                .always(function() {
                    running = false;
                });
        }
    }

    $(document).on('click', '.notifyjs-container', function() {
        loading();
        window.location.replace('/notifications');
    });
    check();
});