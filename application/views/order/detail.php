<?php
/**
 * @var Entity\Order $order
 */
?>

<table class="table order-detail">
    <thead>
    <tr>
        <th>STT</th>
        <th>Mã hàng</th>
        <th>Tên hàng</th>
        <th>Số lượng</th>
        <th>Đơn giá</th>
        <th>Thành tiền</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $i = 0;
    $total = 0;
    /** @var \Entity\OrderDetail $detail */
    ?>
    <?php foreach ($order->getDetails() as $detail): ?>
        <tr>
            <td><?= ++$i ?></td>
            <td><?= $detail->getProduct()->getId() ?></td>
            <td><?= $detail->getProduct()->getName() ?></td>
            <td><?= $detail->getQuantity() ?></td>
            <td><?= $detail->getPrice() ?>,000</td>
            <td><?= number_format($detail->getQuantity() * $detail->getPrice()) ?>,000</td>

            <?php
            $total += $detail->getQuantity() * $detail->getPrice();
            ?>
        </tr>
    <?php endforeach;?>

    <tr class="ship-row success">
        <td colspan="5" style="text-align: center">Giảm giá</td>
        <td><?= JotunUtils::currencyFormat($order->getSaleOff()); ?></td>
    </tr>

    <tr class="ship-row">
        <td colspan="5" style="text-align: center">Phí vận chuyển</td>
        <td><?= JotunUtils::currencyFormat($order->getShipFee()) ?></td>
    </tr>
    </tbody>

    <tfoot>
    <tr>
        <th colspan="5">Tổng</th>
        <td><?= JotunUtils::currencyFormat($order->getTotal() + $order->getShipFee() - $order->getSaleOff()) ?></td>
    </tr>
    </tfoot>
</table>

<script>
    var $modal = $("#bs_modal");

    $modal.find(".modal-title").text("Hóa đơn <?= $order->getBeautyId() ?>");
</script>