<div class="container-fluid" style="padding:0"><?php
	echo $ads_under_news;
	echo $category_slide;
	echo $new_product;
?></div>

<?php if ($login_success !== false): ?>
    <script>
        noty({
            text: "Đăng nhập thành công.",
            layout: "topCenter",
            type: "success",
            timeout: 2000
        });
    </script>
<?php endif; ?>

