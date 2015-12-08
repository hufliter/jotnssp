$(function () {
    "use strict";

    var $table = $(".dataTable");

    // Processing redirect button
    $table.on("click", "button.control.redirect", function () {
        var href = $(this).data("href"),
            newWindow = $(this).data("new-window");

        if (href != undefined) {
            if (newWindow) {
                window.open(href);
            } else {
                location.href = href;
            }
        }
    });
});