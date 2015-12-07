$(function ($) {
    var running = false;
    window.runner = setInterval(function(){
        if (running == false) {
            running = true;
            url = '/services/chat/'+chat_id+'/messages/'+lastMsgId+'/'+last_timer;
            $.get( url, function(data) {
                    if (data.status == "success") {
                        $.each(data.data, function(key, val) {
                            var assets = '';
                            if (val.assets.length > 0) {
                                $.each(val.assets, function(key, ast){
                                    if (ast.youtube != '') {
                                        assets += '<div class="video-container">' +
                                                    '<iframe width="560" height="315" src="http://www.youtube.com/embed/'+
                                                    ast.youtube + '?rel=0" frameborder="0" allowfullscreen></iframe>'+
                                                    '</div>';
                                    }
                                    else if (ast.url.match(/\.(jpeg|jpg|gif|png|JPEG|JPG|GIF|PNG)$/) != null) {
                                        assets += '<img class="msgimg img-responsive" src="'+ast.url+'"/>';
                                    } else {
                                        assets += '<a class="download-asset" href="'+ast.url+'"><i class="fa fa-download">'+ast.name+'</i></a>';
                                    }
                                });
                            }
                            var userimg = '<img src="/img/profile.png"/>';
                            if (val.user.image != '') {
                                userimg = '<img src="'+val.user.image+'"/>';
                            }
                            insert = '<div class="row card card-b">' +
                            '<div class="col-xs-12">' +
                            '<div class="message">' +
                            '<div class="row">' +
                            '<div class="profile-img">' + userimg +' '+ val.user.name + ' </div>' +
                            '<div class="text">' +
                            '<p>'+val.message.replace(/(?:\r\n|\r|\n)/g, '<br />');+'</p>' + assets +
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

    $(".container").on('click', '.btn-delete-msg', function(e) {
        e.preventDefault();
        var url = '/services/message/'+$(this).attr('data-id')+'/delete';
        $.get( url, function(data) {
            if (data.status == "success") {
                console.log(data);
                window.test = e;
                $(e.target).closest('.card-b').remove();
            }
        });
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