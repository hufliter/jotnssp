<?php
/**
 * @var \Entity\Ward[] $wards
 * @var \Entity\User $user
 */
?>
<div class="row-fluid">
    <div class="product-label deco nonSelect">
        <span class="product_icon vip_icon"></span> Đơn hàng của bạn
    </div>
    <div class="separator" style="margin-top:-3px;width:677px;padding:0;"></div>
</div>
<div class="row-fluid show order-page">
    <div class="product-content sub-product product-table carousel_radius span12" style="height:100%;padding-top:5px">
        <!--<form class="form-horizontal" method="post" action="<?php /*echo base_url('/product/order') */ ?>">-->
        <?php echo form_open('dat-hang', ['id' => 'f_form', 'class' => 'form-horizontal', 'method' => 'post', 'novalidate' => true]); ?>
        <div class="control-group">
            <label class="control-label span2" for="inputName">Họ tên</label>

            <div class="controls">
                <input class="span11" type="text" id="inputName" name="name" placeholder="Họ tên" required="required"
                    value="<?= $user->getName() ?>">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label span2" for="inputAddress">Địa chỉ</label>

            <div class="controls">
                <input class="span11" type="text" id="inputAddress" name="address" placeholder="Địa chỉ" required="required"
                    value="<?= $user->getAddress() ?>">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label span2" for="inputDistrict">Chọn quận</label>

            <div class="controls controls-row">
                <select class="span5" name="ward_id" id="ward_id">
                    <?php foreach ($wards as $w) : ?>
                        <option value="<?= $w->getId(); ?>" data-shipfee="<?= $w->getShipFee(); ?>"
                            data-message="<?= $w->getMessage() ?>">
                            <?= $w->getName(); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <input class="span6 numeric" type="text" id="inputPhone" name="phone" placeholder="Số ĐT" required="required"
                    value="<?= $user->getPhone() ?>">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label span2" for="inputNote">Ghi chú</label>

            <div class="controls">
                <textarea rows="3" cols="50" class="span11" id="inputNote" placeholder="Yêu cầu giao hàng (nếu có)"
                          name="note"></textarea>
            </div>
        </div>
        <div class="control-group" style="margin-bottom: 0px;">
            <div class="controls" style="margin-left: 15px; margin-right: 15px;">
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Sản phẩm</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th style="text-align: right">Thành tiền</th>
                    </tr>
                    </thead>
                    <tbody id="order-items">
                    <?php
                    $i = 0;
                    foreach (Jotun\Cart\Cart::getInstance()->getItems() as $item):
                        ?>
                        <tr data-price="<?= round($item->getPrice()) ?>" data-quantity="<?= $item->getQuantity() ?>"
                            data-product-id="<?= $item->getProductId() ?>">
                            <td>
                                <?= ++$i ?>
                                <input type="hidden" value="<?= $item->getProductId() ?>" name="product_id[]"/>
                            </td>
                            <td><?= $item->getName() ?> [<a href="#" class="remove-item">xóa</a>]</td>
                            <td class="currency">
                                <?= JotunUtils::currencyFormat($item->getPrice()) ?>
                                <input type="hidden" value="<?= $item->getPrice() ?>" name="price[]"/>
                            </td>
                            <td class="quantity" data-val="<?= $item->getQuantity() ?>">
                                <select class="quantity" name="quantity[]" id="quantity_<?= $item->getProductId() ?>">

                                </select>
                            </td>
                            <td class="total currency"></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="control-group">
            <div class="row">
                <div class="span6 offset1">
                    <div class="input-append" style="margin-left: -15px">
                        <input name="reseller_code" class="span8" id="reseller_code"
                               type="text" placeholder="Nhập mã giảm giá">
                        <button class="btn" type="button" id="btnResellerCheck">OK</button>
                    </div>
                    <div id="order-reseller" style="color: #348048">
                        Phuong Huynh
                    </div>

                    <div class="ship_extra_message" id="ship_extra_message"></div>
                </div>
                <div class="span5 pull-right summary">
                    <table class="summary table table-hover table-condensed">
                        <tr>
                            <td>Tổng cộng</td>
                            <td id="order-total" class="currency">120,000</td>
                        </tr>
                        <tr>
                            <td>Được giảm giá</td>
                            <td id="saleoff" class="currency" data-val="0">0</td>
                        </tr>
                        <tr>
                            <td>Phí vận chuyển</td>
                            <td id="order-fee" class="currency"></td>
                        </tr>
                        <tr class="total">
                            <td>Thành tiền</td>
                            <td id="final-total" class="currency">120,000</td>
                        </tr>
                    </table>

                    <button type="submit" class="btn btn-success btn-block">Đặt hàng</button>
                </div>
            </div>
        </div>
        <?= form_close() ?>

    </div>
</div>

<script src="<?= base_url() ?>assets/js/front/order.js"></script>