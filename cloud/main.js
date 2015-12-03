
// Use Parse.Cloud.define to define as many cloud functions as you want.
// For example:
Parse.Cloud.define("hello", function(request, response) {
  response.success("Hello world!");
});

Parse.Cloud.afterSave("Messages", function(request) {
    query = new Parse.Query("ChatRoom");
    query.get(request.object.get("chatRoom").id, {
        success: function(chatRoom) {
            var relation = chatRoom.relation("members");
            var qry = relation.query();
            qry.find({
               success: function(members) {
                   var Notification = Parse.Object.extend("Notifications");
                   for (var i = 0; i < members.length; ++i) {
                       var member = members[i];
                       if (member.id !== request.object.get("user").id) {
                           var note = new Notification();
                           note.set("for", member);
                           note.set("type", "message");
                           note.set("by", request.object.get("user"));
                           note.set("message", request.object);
                           note.set("read", false);
                           note.set("sent", false);
                           note.save();
                       }
                   }
               }
            });
        },
        error: function(error) {
            console.error("Got an error " + error.code + " : " + error.message);
        }
    });
});