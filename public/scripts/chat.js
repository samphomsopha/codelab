$(function ($) {
    Parse.initialize("uctT04ZoBDOcp3am72FWUDZ5ZVdWE8WwDtnQvhJ3", "7sfR7nQDKxBEc0CM7s4b0Lkw1wH8DiMJgpWUGm0N");

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
        var Message = Parse.Object.extend("Messages");
        var User = Parse.Object.extend("User");
        var ChatRoom = Parse.Object.extend("ChatRoom");
        var messObj = new Message();
        if ($("#message").val()) {
            var query = new Parse.Query(ChatRoom);
            query.get(chat_id, {
                success: function(chatRoom) {
                    var query = new Parse.Query(User);
                    query.get(PU, {
                        success: function(user) {
                            // The object was retrieved successfully.
                            messObj.set("message", $("#message").val());
                            messObj.set("user", user);
                            messObj.save(null, {
                                success: function(messObj) {
                                    $("#message").val('');
                                    // Execute any logic that should take place after the object is saved.
                                    var relation = chatRoom.relation("messages");
                                    relation.add(messObj);
                                    chatRoom.save();
                                    console.log('New object created with objectId: ' + messObj.id);
                                },
                                error: function(messObj, error) {
                                    // Execute any logic that should take place if the save fails.
                                    // error is a Parse.Error with an error code and message.
                                    alert('Failed to create new object, with error code: ' + error.message);
                                }
                            });
                        },
                        error: function(object, error) {
                            // The object was not retrieved successfully.
                            // error is a Parse.Error with an error code and message.
                            alert('Failed to retrieve user('+PU+'), with error code: ' + error.message);
                        }
                    });
                },
                error: function(object, error) {
                    alert('Failed to retrieve ChatRoom ('+chat_id+'), with error code: ' + error.message);
                }
            });
        }

        var currentUser = Parse.User.current();
        if (currentUser) {
            console.log($("#message").val());
        } else {
            console.log(currentUser);
        }
    });
});

$(window).load(function() {
    $("html, body").animate({ scrollTop: $(document).height() }, 100);
});