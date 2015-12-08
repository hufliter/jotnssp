<?php
/**
 * @var Entity\Order $order
 */
?>
<div class="row-fluid">
    <div class="span12 round">
        <h3>
            Xem chi tiết đơn hàng <code><?= $order->getId() ?></code>
            <a href="<?= base_url() ?>order/print-only/<?= $order->getId() ?>" target="_blank"><i class="fa fa-print"></i></a>
        </h3>
    </div>
</div>

<div class="row-fluid">
    <div class="panel span4">
        <div class="panel-body">
            <p>Thông tin khách hàng</p>
        </div>

        <table class="table table-hover">
            <tr>
                <th>Họ tên</th>
                <td><?= $order->getFullName() ?></td>
            </tr>
            <tr>
                <th>Điện thoại</th>
                <td><?= $order->getPhone() ?></td>
            </tr>
            <tr>
                <th>Địa chỉ</th>
                <td><?= $order->getAddress() ?></td>
            </tr>
            <tr>
                <th>Quận</th>
                <td><?= $order->getWardName() ?></td>
            </tr>
            <tr>
                <th>Ghi chú</th>
                <td><?= $order->getNote() ?></td>
            </tr>
        </table>
    </div>

    <div class="panel <?= $order->getStatus() == ORDER_STATUS_NEW ? 'panel-warning' : 'panel-success' ?> span4">
        <div class="panel-heading">Tình trạng</div>
        <div class="panel-body">
            <p>Cập nhật tình trạng đơn hàng</p>
        </div>

        <table class="table">
            <tr>
                <th><code><?= $order->getCreatedAt()->format('H:i:s d/m/Y') ?></code></th>
                <td>Đặt hàng</td>
            </tr>

            <?php if ($order->getStatus() == ORDER_STATUS_SHIPPED): ?>
                <tr>
                    <th><code><?= $order->getUpdatedAt()->format('H:i:s d/m/Y') ?></code></th>
                    <td>Giao hàng</td>
                </tr>
            <?php endif; ?>
        </table>
    </div>

    <div class="panel panel-success span4">
        <div class="panel-heading">Cộng tác viên</div>
        <div class="panel-body">
            <?php if ($order->getReseller() != null): ?>
                <p class="strong"><?= $order->getReseller()->getName() ?></p>
                <code><?= $order->getCoupon() ?></code>
            <?php else: ?>
                <p class="warning">Không có.</p>
            <?php endif;?>
        </div>
    </div>
</div>


<div class="row-fluid">
    <div class="panel panel-success">
        <div class="panel-heading">Chi tiết</div>
        <div class="panel-body">
            <p>Thông tin chi tiết đơn hàng</p>
        </div>

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
    </div>
</div>

<?= form_open('#', ['id' => 'f_form']) . form_close() ?>

<?php if ($order->getStatus() == ORDER_STATUS_NEW): ?>
    <div class="row-fluid">
        <button class="shipped btn btn-large btn-success span6" data-ep="<?= base_url() ?>admincp/order/api_mark_shipped/<?= $order->getId() ?>"><i class="fa fa-truck"></i> Đánh dấu đã chuyển hàng.</button>
        <button class="destroy btn btn-large btn-danger span6" data-ep="<?= base_url() ?>admincp/order/api_destroy/<?= $order->getId() ?>"><i class="fa fa-trash-o"></i> Xóa đơn hàng.</button>
    </div>
<?php endif; ?>