<?php
/**
 * @var Entity\Ward $ward
 */
?>
<?= form_open('#', ['class' => 'span3 offset2', 'id' => '_form']) ?>
<div>
    <label for="name">Tên/Quận</label>
    <input type="text" id="name" name="name" class="span3" value="<?= $ward->getName() ?>" />
</div>

<div>
    <label for="fee">Phí vận chuyển</label>
    <div class="input-append">
        <input type="text" id="fee" name="fee" class="span2 text-right" value="<?= $ward->getShipFee() ?>"/>
        <span class="add-on">,000</span>
    </div>
</div>

<div>
    <label for="message">Thông báo thêm</label>
    <input type="text" id="message" name="message" class="span4" value="<?= $ward->getMessage() ?>" />
</div>
<?= form_close() ?>

<script>
    // Update title
    $("#modal_label", "#bs_modal").text("Update <?= $ward->getName() ?>");
</script>