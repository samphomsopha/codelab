$(function ($) {
    var rtkey = jQuery.Event("keypress");
    rtkey.which = 13; //choose the one you want
    rtkey.keyCode = 13;

    if ($('input:hidden[name="invites[]"]').val()) {
        $('.friends').show();
    }

    function addFriend(elem, email) {
        if (email != '' && validateEmail(email)) {
            $(elem).parent().parent().find('.friends').append('<div class="invite-contain">' +
            '<input type="hidden" name="invites[]" value="' + email + '"/>' +
            '<div class="invite">' + email + '</div><i class="fa fa-times-circle x-out"></i></div>');
            if ($('.friends:visible').length == 0) {
                $('.friends').show();
            }
        } else {
            $.notify(email + ' is not a valid email', {
                position:  'top center'
            });
        }
    };

    function validateEmail(email) {
        var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
        return re.test(email);
    }

    $("#invite").bind("keypress", function(e) {
        if(e.which == 13) {
            e.preventDefault();
            email = $(this).val();
            that = this;

            while (email.indexOf(',') != -1) {
                email = email.replace(',', ' ');
            }

            if (email != '') {
                if (email.indexOf(' ') != -1) {
                    emails = email.split(' ');
                    $.each(emails, function (index, value) {
                        addFriend(that, value);
                    });
                } else {
                    addFriend(that, email);
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

    $("#groupform").submit(function(e) {
        //e.preventDefault();
        var email = $("#invite").val();
        if (email.indexOf(',') != -1) {
            email = email.replace(',', ' ');
        }
        var elem = "#invite";
        if (email != '') {
            if (email.indexOf(' ') != -1) {
                emails = email.split(' ');
                $.each(emails, function (index, value) {
                    addFriend(elem, value);
                });
            } else {
                addFriend(elem, email);
            }

            $(elem).val('');
        }

        return true;
    });
});