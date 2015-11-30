$(function ($) {
    $("#groupId").change(function(){
        var id = $( "#groupId option:selected" ).val();
        window.location.replace('/group/'+id+'/new-event/?st='+stDate);
    })
});