<link rel="stylesheet" href="<?= base_url() ?>assets/js/jquery-ui-1.11.2.custom/jquery-ui.min.css"/>
<link rel="stylesheet" href="<?= base_url() ?>assets/js/jquery-ui-1.11.2.custom/jquery-ui.theme.min.css"/>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
<div class="row-fluid">
    <div class="product-label deco nonSelect">
        <span class="product_icon vip_icon"></span> Quản lý đơn hàng cho CTV(VIP)
    </div>
    <div class="separator" style="margin-top:-3px;width:677px;padding:0;"></div>
</div>
<div class="row-fluid show">
    <div class="product-content sub-product product-table carousel_radius span12" style="height:100%;padding : 10px">
        <table class="table" id="datatable" data-ajax="<?= base_url() ?>product/api_list_order_ctv">
            <thead>
            <tr>
                <th>Mã</th>
                <th>Tên KH</th>
                <th>Thành tiền</th>
                <th>Thời gian</th>
                <th>Giao hàng</th>
                <th>Xem</th>
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>

<script>
    $(function () {
        var $datatable = $("#datatable"),
            oTable = $datatable.DataTable({
            processing: true,
            serverSide: true,
            columns: [
                {name: "code", data: "code"},
                {name: "name", data: "name"},
                {name: "total", data: "total"},
                {name: "created_at", data: "created_at"},
                {name: "status", data: "status"},
                {name: "actions", data: "actions"}
            ]
        });

        var $modal = $("#bs_modal");
        $modal.find(".btn-primary").hide();
        $datatable.on("click", ".btn.btn-info", function () {
            $.isLoading({text: "loading...", modal: true});
            $.get($(this).data("ep"), function (resp) {
                $modal.find(".modal-body").html(resp);
                $modal.show();
            }, "html")
                .always(function () {
                    $.isLoading("hide");
                });
            $modal.modal("show");
        });
    });
</script>