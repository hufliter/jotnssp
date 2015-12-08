<?php
/**
 * @var \Entity\Order[] $orders
 */
?>
<table class="table table-hover">
    <thead>
    <tr>
        <th>Mã hóa đơn</th>
        <th>Khách hàng</th>
        <th>Giá trị</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($orders as $o): ?>
        <tr>
            <td><a href="<?= base_url() ?>admincp/order/show/<?= $o->getId() ?>" target="_blank"><?= $o->getId()  ?></a></td>
            <td><?= $o->getFullName() ?></td>
            <td><?= JotunUtils::currencyFormat($o->getTotal()) ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<script>
    $(function () {
        $("#bs_modal > div > div > div.modal-footer > button.btn.btn-primary").hide();
        $("#modal_label").text("Các đơn hàng");
    });
</script>