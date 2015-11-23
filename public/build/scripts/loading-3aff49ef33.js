var loading = function() {
    // add the overlay with loading image to the page
    var over = '<div id="overlay">' +
        '<div id="loading">Loading...</div>' +
        '</div>';
    $(over).appendTo('body');

    // click on the overlay to remove it
    //$('#overlay').click(function() {
    //    $(this).remove();
    //});

    // hit escape to close the overlay
    $(document).keyup(function(e) {
        if (e.which === 27) {
            $('#overlay').remove();
        }
    });
};

$(function() {
    window.onbeforeunload = function() {
        loading();
    }
});