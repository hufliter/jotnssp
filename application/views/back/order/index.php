<div class="row-fluid">
    <div class="span12 round">
        <h3>Đơn đặt hàng</h3>
    </div>
</div>
<!-- content -->
<div class="row-fluid well well-small">
    <table id="table_data" class="display"
           data-ajax-base="<?= base_url() ?>admincp/order"
        >
        <thead>
        <tr>
            <td>Tên</td>
            <td>Số </td>
            <td>CTV</td>
            <td>Thời gian</td>
            <td>Thành tiền</td>
            <td>Đã giao hàng</td>
            <td>Controls</td>
        </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>

<?= $bs_modal ?>