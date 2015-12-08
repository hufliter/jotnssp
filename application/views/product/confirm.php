<?php
/**
 * @var string $name
 * @var string $address
 * @var string $phone
 * @var string $note
 * @var \Entity\Ward $ward
 * @var array $items
 * @var \Entity\User $reseller
 */
?>
<div class="row-fluid">
    <div class="product-label deco nonSelect">
        <span class="product_icon vip_icon"></span> Xác nhận đơn hàng
    </div><div class="separator" style="margin-top:-3px;width:677px;padding:0;"></div>
</div>
<div class="row-fluid show">
    <div class="product-content sub-product product-table carousel_radius span12" style="height:100%;padding-top:5px">
        <?= form_open('xac-nhan-dat-hang', ['method' => 'post', 'class' => 'form-horizontal']) ?>
            <div class="control-group">
                <label class="control-label span2">Họ tên</label>
                <label class="control-label span1">:</label>
                <div class="controls">
                    <label class="span9" style="padding-top: 5px;"><?= $name ?></label>
                    <input type="hidden" name="name" value="<?= $name ?>"/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label span2">Địa chỉ</label>
                <label class="control-label span1">:</label>
                <div class="controls">
                    <label class="span9" style="padding-top: 5px;"><?= $address ?></label>
                    <input type="hidden" name="address" value="<?= $address ?>"/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label span2">Điện thoại</label>
                <label class="control-label span1">:</label>
                <div class="controls">
                    <label class="span9" style="padding-top: 5px;"><?= $phone ?></label>
                    <input type="hidden" name="phone" value="<?= $phone ?>"/>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label span2">Quận</label>
                <label class="control-label span1">:</label>
                <div class="controls">
                    <label class="span9" style="padding-top: 5px;"><?= $ward->getName() ?></label>
                    <input type="hidden" name="ward_id" value="<?= $ward->getId() ?>"/>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label span2">Ghi chú</label>
                <label class="control-label span1">:</label>
                <div class="controls">
                    <label class="span9" style="padding-top: 5px;"><?= $note ?></label>
                    <input type="hidden" name="note" value="<?= $note ?>"/>
                </div>
            </div>

            <div class="control-group"  style="margin-bottom: 0px;">
                <div class="controls" style="margin-left: 15px; margin-right: 15px;">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Thông tin sản phẩm</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Tổng</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 0; ?>
                        <?php foreach ($items as $it): ?>
                            <?php
                            /** @var \Entity\Product $product */
                            $product = $it['product'];
                            $quantity = $it['quantity'];
                            ?>
                        <tr>
                            <td><?= $product->getName() ?></td>
                            <td><?= JotunUtils::currencyFormat($product->getPrice()) ?></td>
                            <td><label class="span1" style="padding-top: 5px;"><?= $quantity ?></label></td>
                            <td>
                                <?= JotunUtils::currencyFormat($product->getPrice() * $quantity) ?>
                                <input type="hidden" name="quantity[]" value="<?= $quantity ?>"/>
                                <input type="hidden" name="product_id[]" value="<?= $product->getId() ?>"/>
                            </td>
                        </tr>
                            <?php $i++; ?>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="control-group" style="margin-bottom: 0px;">
                <div class="controls" style="margin-left: 25px; margin-right: 15px;">
                    <label class="pull-right" style="margin-right: 15px;">Thành tiền</label>
                </div>
            </div>

            <div class="control-group"  style="margin-bottom: 0px;">
                <div class="controls" style="margin-left: 20px; margin-right: 15px;">
                    <label class="pull-right" style="margin-right: 15px; font-size: 16px; font-weight: bold; color: red;"><?= JotunUtils::currencyFormat($final) ?> VNĐ</label>
                </div>
            </div>

            <div class="control-group">
                <div class="controls" style="margin-left: 25px; margin-right: 15px;">
                    <?php if ($reseller): ?>
                        <input type="hidden" name="reseller_id" value="<?= $reseller->getId() ?>"/>
                        <p class="text-right">
                            <label style="margin-right: 15px; color: #1c8517">(Khuyến mãi : -<?= JotunUtils::currencyFormat($off) ?>k)</label>
                        </p>
                    <?php endif; ?>
                    <p class="text-right">
                        <label style="margin-right: 15px;">(bao gồm ship : <?= $ward->getShipFee() ?>k)</label>
                    </p>
                </div>
            </div>

            <div class="control-group">
                <div class="controls">
                    <a href="<?= base_url() ?>" class="btn btn-danger span4">Hủy bỏ</a>
                    <button type="submit" class="btn btn-success span4">Xác nhận</button>
                </div>
            </div>
        <?= form_close() ?>

    </div>
</div>
