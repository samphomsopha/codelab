$(function($){
    var assets = [];
    var myDropzone = new Dropzone("#chatfrm", {
        url: "/chat/upload",
        paramName: 'image',
        previewsContainer: '#uploadctn'});
    myDropzone.on("sending", function(file){
        $('.send').prop('disabled', true);
    });
    myDropzone.on("success", function(file, data){
        assets.push(data.data.asset.id);
        $('.send').prop('disabled', false);
    });

    $(".send").on("click", function(e){
        e.preventDefault();
        var message = $("#message").val();
        var youtube = $("#youtube").val();
        data = {
            message: message,
            chat_id: chat_id,
            _token: $('input:hidden[name=_token]').val(),
            assets: assets,
            youtube: youtube
        };

        $.ajax({
            type: "POST",
            url: "/chat/message",
            data: data,
            success: function(data) {
                console.log(data);
                if (data.status == "success") {
                    $("#message").val('');
                    window.location.replace('/chat/'+chat_id);
                }
            },
            dataType: 'json'
        });
    });
});