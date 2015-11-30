$(function ($) {    //get here
    var url = '/services/groups/events';
    $.get( url, function(data) {
        if (data.status == "success") {
            $('.responsive-calendar').responsiveCalendar({
                time: showTime,
                events: data.data.dsEvents,
                monthChangeAnimation: true,
                startFromSunday: true,
                activateNonCurrentMonths: true
            });
        }
    });
});