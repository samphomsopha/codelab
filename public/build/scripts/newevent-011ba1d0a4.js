$(function ($) {

    var rtkey = jQuery.Event("keypress");
    rtkey.which = 13; //choose the one you want
    rtkey.keyCode = 13;

    function addFriend(elem, email) {
        if (email != '') {
            $(elem).parent().find('.friends').append('<div class="invite-contain">' +
            '<input type="hidden" name="invites[]" value="' + email + '"/>' +
            '<div class="invite">' + email + '</div><i class="fa fa-times-circle x-out"></i></div>');
            if ($('.friends:visible').length == 0) {
                $('.friends').show();
            }
        }
    };

    $( "#eventDate" ).pickadate({
        formatSubmit: 'mm/dd/yyyy',
        format: 'mm/dd/yyyy'
    });

    $("#invite").bind("keypress", function(e) {
        if(e.which == 13) {
            e.preventDefault();
            email = $(this).val();
            that = this;

            if (email.indexOf(',') != -1) {
                email = email.replace(',', ' ');
            }

            if (email != '') {
                if (email.indexOf(' ') != -1) {
                    emails = email.split(' ');
                    $.each(emails, function (index, value) {
                        addFriend(that, value);
                    });
                } else {
                    addFriend(this, email);
                }

                $(this).val('');
            }
        }
    });

    $(".invite-btn").click(function(e){
        e.preventDefault();
        $("#invite").trigger(rtkey);
    });

    $(".placeholder").on("click", ".x-out", function(e) {
        e.preventDefault();
        $(this).parent().remove();
    });
});