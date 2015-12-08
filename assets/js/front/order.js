$(function () {
    "use strict";

    var $itemsWrapper = $("#order-items"),
        $trItem  = $("tr", $itemsWrapper),
        $orderTotal = $("#order-total"),
        $saleOff = $("#saleoff"),
        $fee = $("#order-fee"),
        $finalTotal = $("#final-total"),
        $wardId = $("#ward_id"),
        $resellerCode = $("#reseller_code"),
        $orderReseller = $("#order-reseller").hide(),
        $ship_extra_message = $("#ship_extra_message"),
        $form = $("#f_form");

    $("select.quantity").change(function () {
        var $self = $(this),
            $tr = $self.parents("tr"),
            total = $tr.data("price") * $self.val() * 1000,
            postData;

        // Update to tr
        $tr.data("quantity", $self.val());

        $tr.find(".total").text(numeral(total).format("0,0"));
        makeTotal();

        // Update data to server
        postData = {
            product_id: $tr.data("product-id"),
            quantity: $tr.data("quantity")
        };

        if (JTS.csrf.value.length > 0) {
            $.post(window["_base_url"] + 'product/api_cart_change_quantity', JTS.csrf.fillPostData(postData), function () {

            });
        }
    });

    $wardId.change(function () {
        var $self = $(this),
            v = $self.val(),
            $option,
            fee;

        $option = $self.find("[value=" + v + "]");
        fee = parseInt($option.data("shipfee"));

        $fee.data("val", fee)
            .text(numeral(fee * 1000).format("0,0"));

        $ship_extra_message.text($option.data("message"));
    }).change();

    $trItem.each(function () {
        var $tr = $(this),
            $select = $("select.quantity", $tr),
            initQuantity = $tr.data("quantity"),
            i,
            $option;

        for(i = 1; i <= 10; i++) {
            $option = $("<option />").attr("value", i)
                .text(i);
            $select.append($option);
        }

        $select.val(initQuantity)
            .change();
    });

    function makeTotal() {
        var total = 0,
            final,
            off;
        $trItem.each(function () {
            var $self = $(this);

            total += $self.data("price") * $self.data("quantity");
        });

        $orderTotal.data("val", total)
            .text(numeral(total * 1000).format("0,0"));

        final = total + $fee.data("val");
        off = $saleOff.data("val") * total / 100;

        final -= off;
        $finalTotal.text(numeral(final * 1000).format("0,0"));

        $saleOff.text(numeral(off * 1000).format("0,0"));

        return final;
    }

    $("#btnResellerCheck").click(function () {
        var ep = window["_base_url"] + 'product/api-check-reseller-code/' + $resellerCode.val();
        $.isLoading({text: "Processing...", position: "overlay"});
        $.get(ep, function (resp) {
            if (resp.code == 0) {
                noty({
                    type: "success",
                    text: "Sử dụng mã giảm giá thành công. Bạn được giảm " + resp.off + "%",
                    modal: true,
                    layout: "center"
                });
                $orderReseller.text(resp.reseller)
                    .show();
                $saleOff.data("val", resp.off);
                makeTotal();
            } else {
                noty({
                    type: "error",
                    text: "Mã giảm giá không hợp lệ.",
                    modal: true,
                    layout: "center"
                });
            }
        })
            .always(function () {
                $.isLoading("hide");
            });
    });

    $form.validate({
        submitHandler: function (form) {
            var total = makeTotal();
            if (total > 100) {
                form.submit();
            } else {
                noty({
                    type: "error",
                    text: "Chúng tôi chỉ chấp nhận đơn hàng trên 100.000, vui lòng đặt thêm hàng!",
                    modal: true,
                    layout: "center"
                });
            }
        }
    });

    $(".remove-item").click(function (e) {
        e.preventDefault();
        var $self = $(this),
            $tr = $self.parents('tr'),
            postData = {
                product_id: $tr.data("product-id")
            };
        $self.hide();
        $.post(window["_base_url"] + 'product/api_cart_remove', JTS.csrf.fillPostData(postData), function (resp) {
            $tr.remove();
            // Update rows
            $trItem  = $("tr", $itemsWrapper);
            makeTotal();
        })
    });
});