$(function ($) {    //get here
    var url = '/services/groups/events';
    $.get( url, function(data) {
        if (data.status == "success") {
            $('.responsive-calendar').responsiveCalendar({
                time: showTime,
                events: data.data.dsEvents,
                monthChangeAnimation: true,
                startFromSunday: true,
                activateNonCurrentMonths: true,
                onDayClick: function(events) {
                    var date = $(this).data();
                    window.location.replace('/calendar/day/'+date.year+'-'+date.month+'-'+date.day);
                }
            });
        }
    });
});