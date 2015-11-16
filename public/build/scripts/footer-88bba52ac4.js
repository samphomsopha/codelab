$(function ($) {
    $('.nav-left').click(function(e){
        e.preventDefault();
        window.history.go(-1);
    });
});