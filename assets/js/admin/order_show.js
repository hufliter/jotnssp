$(function () {
    "use strict";
    var $btnShip = $("button.shipped"),
        $btnDestroy = $("button.destroy");

    $btnShip.click(function () {
        var ep = $(this).data('ep');
        noty({
            layout: 'center',
            modal: true,
            text: "Bạn muốn xác nhận đã chuyển hàng cho hóa đơn này?",
            buttons: [
                {
                    addClass: "btn btn-normal",
                    text: "Hủy",
                    onClick: function ($noty) { $noty.close(); }
                },
                {
                    addClass: "btn btn-success",
                    text: "Xác nhận",
                    onClick: function ($noty) {
                        $noty.close();
                        sendRequest(ep, function () {
                            noty({
                                layout: "topCenter",
                                text: "Xác nhận giao hàng thành công.",
                                type: "success",
                                modal: true,
                                callback: {
                                    onClose: function () {
                                        location.reload();
                                    }
                                }
                            });
                            setTimeout(function () {
                                location.reload();
                            }, 1500);
                        });
                    }
                }
            ]
        });
    });

    $btnDestroy.click(function () {
        var ep = $(this).data('ep');
        noty({
            layout: 'center',
            modal: true,
            text: "Bạn muốn xóa đơn đặt hàng này?",
            buttons: [
                {
                    addClass: "btn btn-normal",
                    text: "Hủy",
                    onClick: function ($noty) { $noty.close(); }
                },
                {
                    addClass: "btn btn-danger",
                    text: "Xóa",
                    onClick: function ($noty) {
                        $noty.close();
                        sendRequest(ep, function () {
                            noty({
                                layout: "topCenter",
                                text: "Xóa thành công.",
                                type: "success",
                                modal: true,
                                callback: {
                                    onClose: function () {
                                        location.href = "./../index";
                                    }
                                }
                            });
                            setTimeout(function () {
                                location.href = "./../index";
                            }, 1500);
                        });
                    }
                }
            ]
        });
    });

    function sendRequest(ep, callback) {
        var data = {},
            request;

        data[JTS.csrf.name] = JTS.csrf.value;
        $.isLoading({text: "Processing...", position: "overlay"});
        request = $.post(ep, data, function (resp) {
            if (resp.code < 0) {
                noty({
                    layout: "topCenter",
                    text: resp.message,
                    type: "error",
                    timeout: 3000
                });
            } else {
                callback.call();
            }
        });

        request.always(function () {
            $.isLoading("hide");
        });
    }
});