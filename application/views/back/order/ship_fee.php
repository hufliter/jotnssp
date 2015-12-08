<div class="row-fluid">
    <div class="span12 round">
        <h3>Quận & Phí vận chuyển</h3>
    </div>
</div>
<!-- content -->
<div class="row-fluid well well-small">
    <table id="table_data" class="display"
           data-ajax-base="<?= base_url() ?>admincp/order"
        >
        <thead>
        <tr>
            <td>Quận</td>
            <td>Phí vận chuyển</td>
            <td>Controls</td>
        </tr>
        </thead>
        <tbody>

        </tbody>
    </table>

    <?= form_open('#', ['id' => 'f_form']) . form_close() ?>
    <button class="btn btn-success" id="btn_add" data-ep="<?= base_url() ?>admincp/order/api-ship-fee-store"><i class="fa fa-plus"></i> Thêm Quận</button>
</div>

<?= $bs_modal ?>