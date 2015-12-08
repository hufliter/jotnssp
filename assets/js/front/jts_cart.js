$(function () {
    "use strict";
    var $remodal = $("#_remodal"),
        $remodalObj = $remodal.remodal({closeOnConfirm: false}),
        $btnBuy = $(".btn_buy")
    ;

    function buyItemOnClick(e) {
        e.preventDefault();
        var $self = $(this).parent(),
            id = $self.attr("product-id"),
            ep = window['_base_url'] + "cart/api-get-add/" + id;

        e.preventDefault();

        $.isLoading({text: "Processing...", position: "overlay"});
        $.get(ep, function (resp) {
            if (resp.length > 0) {
                $remodal.find(".body").html(resp);
                $remodal.find(".title").text("Thêm sản phẩm vào giỏ hàng");
                $remodalObj.open();
            } else {
                // error with this product, just reload
                // location.reload();
                console.log("error");
            }
        }, "html")
            .always(function () {
                $.isLoading("hide");
            });
    }

    $("a", $btnBuy).click(buyItemOnClick);
    $("a", ".detail_buy").click(buyItemOnClick);
});