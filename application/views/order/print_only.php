<?php
/**
 * @var \Entity\Order $order
 */
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Hoa don <?=$order->getBeautyId() ?></title>
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/order-print.css" media="all" />
</head>
<body>
<header class="clearfix">
    <div id="logo">
        <img src="<?= base_url() ?>assets/images/front/full_logo.png">
    </div>
    <h1>Hóa đơn <?= $order->getBeautyId() ?></h1>
    <div id="company" class="clearfix">
        <div>Jotunshop.vn</div>
        <div>256 Cao Thắng, P12, <br/>Q10, TPHCM</div>
        <div>01282533534 (Trinh)
            <br/>0902557162 (Tường)
        </div>
    </div>
    <div id="project">
        <div><span>Khach hang</span> <?= $order->getFullName() ?></div>
        <div><span>Dia chi</span> <?= $order->getAddress() ?></div>
        <div><span>Dien thoai</span> <?= $order->getPhone() ?></div>
        <div><span>Thoi gian</span> <?= $order->getCreatedAt()->format('d/m/Y') ?></div>
    </div>
</header>
<main>
    <table class="items">
        <thead>
        <tr>
            <th class="service">#</th>
            <th class="desc">PRODUCT</th>
            <th>PRICE</th>
            <th>QTY</th>
            <th>TOTAL</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $i = 1;
        foreach ($order->getDetails() as $detail):
        ?>
        <tr>
            <td class="service"><?= $i ?></td>
            <td class="desc"><?= $detail->getProduct()->getName() ?></td>
            <td class="unit"><?= JotunUtils::currencyFormat($detail->getPrice()) ?></td>
            <td class="qty"><?= $detail->getQuantity() ?></td>
            <td class="total"><?= JotunUtils::currencyFormat($detail->getPrice() * $detail->getQuantity()) ?></td>
        </tr>
        <?php
        $i++;
        endforeach;
        ?>
        </tbody>
    </table>
    <div id="notices">
        <table class="table total">
            <tr>
                <td>Phí vận chuyển</td>
                <td class="currency"><?= JotunUtils::currencyFormat($order->getShipFee()) ?></td>
            </tr>
            <tr>
                <td>Khuyến mãi</td>
                <td class="currency"><?= JotunUtils::currencyFormat($order->getSaleOff()) ?></td>
            </tr>
            <tr>
                <td>Thành tiền</td>
                <td class="currency"><?= JotunUtils::currencyFormat($order->getTotal() + $order->getShipFee() - $order->getSaleOff()) ?></td>
            </tr>
        </table>
    </div>
</main>

<script>
    window.print()
</script>
</body>
</html>