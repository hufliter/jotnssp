<?php
/**
 * @var string $rows
 * @var \Entity\Order $order
 */
?>
<link rel="stylesheet" href="<?= base_url() ?>assets/js/jquery-ui-1.11.2.custom/jquery-ui.min.css"/>
<link rel="stylesheet" href="<?= base_url() ?>assets/js/jquery-ui-1.11.2.custom/jquery-ui.theme.min.css"/>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
<div class="row-fluid">
    <div class="product-label deco nonSelect">
        <span class="product_icon vip_icon"></span> Chi tiết đơn hàng
    </div>
    <div class="separator" style="margin-top:-3px;width:677px;padding:0;"></div>
</div>
<div class="row-fluid show">
<div class="product-content sub-product product-table carousel_radius span12" style="height:100%;padding : 10px">

<form class="form-horizontal">
    <a href="<?= base_url() ?>order/print-only/<?= $order->getId() ?>" target="_blank">
    <div class="control-group" style="margin-bottom: 0px;">

        <div class="controls" style="margin-left: 25px; margin-right: 15px;">

                <label class="pull-right bold_text" style="margin-right: 15px;">In đơn hàng</label>
        </div>
    </div>

    <div class="control-group"  style="margin-bottom: 0px;">
        <div class="controls" style="margin-left: 20px; margin-right: 15px;">
            <span class="pull-right" style="margin-right: 15px; font-size: 16px; font-weight: bold; color: red; cursor: pointer;"><img width="30px" height="30px" src="<?= base_url() ?>assets/images/front/icon_print.png"></span>
        </div>
    </div>
        </a>
</form>

<table class="table table-hover">
    <thead>
    <tr>
        <th>#</th>
        <th>Sản phẩm</th>
        <th>Giá</th>
        <th>Số lượng</th>
        <th>Tổng</th>
    </tr>
    </thead>
    <tbody>
        <?= $rows ?>
    </tbody>
</table>

<div class="clear"></div>



<div class="clear"></div>
<div class="pull-right">
    <table class="table">
        <tr>
            <th>Giảm giá</th>
            <td>
                <label class="text-success">
                    <?= JotunUtils::currencyFormat($order->getSaleOff()) ?>
                </label>
            </td>
        </tr>
        <tr>
            <th>Ship</th>
            <td>
                <?= JotunUtils::currencyFormat($order->getShipFee()) ?>
            </td>
        </tr>
        <tr>
            <th>Thành tiền</th>
            <td>
                <label class="pull-right" style="margin-right: 15px; font-size: 16px; font-weight: bold; color: red;">
                    <?= JotunUtils::currencyFormat($order->getTotal() + $order->getShipFee() - $order->getSaleOff()) ?> VND
                </label>
            </td>
        </tr>
    </table>
</div>



</div>
</div>
