$(function () {
    "use strict";

    var $table = $("#product-datatable");

    $table.on("click", ".product-available .fa", function () {
        var $self = $(this),
            $td = $self.parent(),
            id = $td.data("id"),
            isProcessing = $td.data("is_processing"),
            postData = {};

        // Checking for processing process on this product (loading)
        if (!isProcessing) {
            $td.data("is_processing", true);
            postData[JTS.csrf.name] = JTS.csrf.value;
            $self.isLoading({text: "..."});
            $.post("/admincp/product/api-available-swap/" + id, postData, function (resp) {
                if (resp.code == 0) {
                    $self.removeClass("available unavailable fa-check fa-times")
                        .addClass(resp.result);
                }
            })
                .always(function () {
                    $self.isLoading("hide");
                    $td.data("is_processing", false);
                });
        }
    });
});