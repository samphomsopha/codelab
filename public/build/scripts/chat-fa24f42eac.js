$(function ($) {
    var running = false;
    window.runner = setInterval(function(){
        if (running == false) {
            running = true;
            url = '/services/chat/'+chat_id+'/messages/'+lastMsgId+'/'+last_timer;
            $.get( url, function(data) {
                    if (data.status == "success") {
                        $.each(data.data, function(key, val) {
                            insert = '<div class="row card card-b">' +
                            '<div class="col-xs-12">' +
                            '<div class="message">' +
                            '<div class="row">' +
                            '<div class="profile-img"> <img src="/img/profile.png"/> '+val.user.name+' </div>' +
                            '<div class="text">' +
                            '<p>'+val.message+'</p>' +
                            '<p class="timestamp">'+val.createdAt+'</p>' +
                            '</div></div></div></div></div>';
                            $(insert).insertBefore('.spacer');
                            last_timer = val.timestamp;
                            lastMsgId = val.Id;

                            $('html, body').animate({
                                scrollTop: $(".spacer").offset().top
                            }, 800);

                        });
                    }
                })
                .always(function() {
                    running = false;
                });
        }
    }, 500);

    $(".fupload").on('click', function(e){
        e.preventDefault();
        window.location.replace('/chat/upload/'+chat_id+'/?msg='+$("#message").val());
    });

    $("#chat-frm").submit(function(e) {
        e.preventDefault();
        var message = $("#message").val();
        data = {
            message: message,
            chat_id: chat_id,
            _token: $('input:hidden[name=_token]').val()
        };

        $.ajax({
            type: "POST",
            url: "/chat/message",
            data: data,
            success: function(data) {
                if (data.status == "success") {
                    $("#message").val('');
                }
            },
            dataType: 'json'
        });
    });
});

$(window).load(function() {
    $("html, body").animate({ scrollTop: $(document).height() }, 100);
});