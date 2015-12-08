$(function () {
    "use strict";
    var $table = $("#table_data"),
        id = $table.data("id"),
        $modal = $("#bs_modal"),
        currentOp = {
            mode: 'update',
            id: 0,
            ep: ''
        };

    $table.dataTable({
        columns: [
            null,
            null,
            null,
            null,
            {sortable: false}
        ],
        bFilter: false,
        processing: true,
        serverSide: true,
        ajax: $table.data('ajax-base') + "/api-get-orders?reseller_id=" + id
    });

    $(".btn-paid").click(function () {
        var $self = $(this);
        noty({
            layout: 'center',
            modal: true,
            text: "Bạn muốn xác nhận đã thanh toán cho CTV này tháng " + $self.data("time") + "?",
            buttons: [
                {
                    addClass: "btn btn-normal",
                    text: "Hủy",
                    onClick: function ($noty) {
                        $noty.close();
                    }
                },
                {
                    addClass: "btn btn-success",
                    text: "Thanh toán",
                    onClick: function ($noty) {
                        $noty.close();
                        makePayment($self);
                    }
                }
            ]
        });
    });

    $(".btn-detail").click(function () {
        var $self = $(this),
            ep = $table.data("ajax-base") + "/api_get_payment_detail",
            postData = {
                id: $self.data("id"),
                time: $self.data("time")
            };

        postData[JTS.csrf.name] = JTS.csrf.value;
        $.isLoading({text: "Processing...", position: "overlay"});
        $.post(ep, postData, function (resp) {
            $modal.find(".modal-body")
                .html(resp);
            $modal.modal("show");
        }, "html")
            .always(function () {
                $.isLoading("hide");
            });
    });

    function makePayment($button) {
        var ep = $table.data("ajax-base") + "/api-make-payment",
            postData = {
                id: $button.data("id"),
                time_code: $button.data("time")
            };
        postData[JTS.csrf.name] = JTS.csrf.value;
        $.isLoading({text: "Processing...", position: "overlay"});
        $.post(ep, postData, function (resp) {
            if (resp.code == 0) {
                $button.parent().append('<span class="paid"><i class="fa fa-check"></i> Đã thanh toán. </span>');
                $button.remove();
            } else {
                // Notify error message
                noty({
                    layout: 'center',
                    modal: true,
                    text: resp.message
                });
            }
        })
            .always(function () {
                $.isLoading("hide");
            });
    }
});