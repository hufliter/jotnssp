<link rel="stylesheet" href="<?= base_url() ?>assets/js/jquery-ui-1.11.2.custom/jquery-ui.min.css"/>
<link rel="stylesheet" href="<?= base_url() ?>assets/js/jquery-ui-1.11.2.custom/jquery-ui.theme.min.css"/>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
<div class="row-fluid">
    <div class="product-label deco nonSelect">
        <span class="product_icon vip_icon"></span> Lịch sử đơn hàng
    </div>
    <div class="separator" style="margin-top:-3px;width:677px;padding:0;"></div>
</div>
<div class="row-fluid show">
<div class="product-content sub-product product-table carousel_radius span12" style="height:100%;padding : 10px">

<table class="table" id="datatable" data-ajax="<?= base_url() ?>product/api-list-order">
    <thead>
    <tr>
        <th>Mã hóa đơn</th>
        <th>Ngày đặt hàng</th>
        <th>Thành tiền</th>
        <th>Giao hàng</th>
        <th>#</th>
    </tr>
    </thead>
    <tbody>
    </tbody>
</table>
</div>
</div>

<script>
    $(function () {
        var oTable = $("#datatable").DataTable({
            processing: true,
            serverSide: true,
            columns: [
                {name: "code", data: "code"},
                {name: "created_at", data: "created_at"},
                {name: "total", data: "total"},
                {name: "status", data: "status"},
                {name: "actions", data: "actions"}
            ]
        });
    })
</script>