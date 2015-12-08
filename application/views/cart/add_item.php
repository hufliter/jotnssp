<?php
/**
 * @var \Entity\Product $product
 */
?>
<table class="table add_cart_table">
    <thead>
    <tr>
        <th>#</th>
        <th>Tên SP</th>
        <th>Giá</th>
        <th>Số lượng</th>
        <th>Tổng cộng</th>
    </tr>
    </thead>
    <tr>
        <td>
            <div class="thumbnail" style="width: 100px">
                <img src="<?= $product->getThumb() ?>" alt="<?= $product->getName() ?>"/>
            </div>
        </td>
        <td>
            <span class="product-name"><?= $product->getName() ?></span>
        </td>
        <td id="i_price">
            <?= JotunUtils::currencyFormat($product->getPrice()) ?>
        </td>
        <td>
            <label for="i_quantity"></label>
            <select name="i_quantity" id="i_quantity" style="width: 60px">
            </select>
        </td>
        <td id="i_total" style="min-width: 120px">

        </td>
    </tr>
</table>

<button class="remodal-cancel">Cancel</button>
<button class="remodal-confirm">OK</button>

<style>
    .add_cart_table td {
        vertical-align: middle;
    }
    .product-name {
        font-weight: bold;
    }
    #i_price, #i_total {
        font-size: 120%;
    }
</style>

<script>
    var $quantity = $("#i_quantity"),
        price = parseInt("<?= $product->getPrice() ?>"),
        productId = parseInt("<?= $product->getId() ?>"),
        $total = $("#i_total"),
        ep = "<?= base_url() ?>cart/api-add",
        i;

    $quantity.change(function () {
        var quantity = $quantity.val(),
            total = quantity * price;
        $total.text(numeral(total * 1000).format("0,0"));
    });

    // Add value for quantity
    for (i = 1; i <= 10; i++) {
        $quantity.append($("<option />").attr("value", i).text(i));
    }
    $quantity.val(1).change();

    $(".remodal-confirm").click(function () {
        $.isLoading({text: "Processing...", position: "overlay"});
        var postData = {
            product_id: productId,
            quantity: $quantity.val()
        };

        postData[JTS.csrf.name]  = JTS.csrf.value;

        $.post(ep, postData, function (resp) {
            if (resp.code == 0) {
                // success
                location.reload();
            }
        })
            .always(function () {
                $.isLoading("hide");
            });
    });
</script>