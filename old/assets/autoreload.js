$(document).ready(function() {
    var currenthtml;
    var latesthtml;
    var count = 0;

    $.get(window.location.href, function(data) {
        currenthtml = data;
        latesthtml = data;
    });

    setInterval(function() {

        $.get(window.location.href, function(data) {
            latesthtml = data;
            
            if(count < 1) {
                currenthtml = data;
                count = count + 1;
            }
        });

        if(currenthtml != latesthtml) {
            location.reload();
        }
    }, 5000);
});