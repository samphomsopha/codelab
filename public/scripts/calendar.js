$(document).ready(function ($) {
    $('.responsive-calendar').responsiveCalendar({
        events: {
            "2015-11-23": {
                "number": 5,
                "badgeClass": "badge-warning",
                "url": "http://w3widgets.com/responsive-calendar"
            },
            "2015-11-26": {
                "number": 1,
                "badgeClass": "badge-warning",
                "url": "http://w3widgets.com"
            }
        },
        monthChangeAnimation: true,
        startFromSunday: true
    });
});