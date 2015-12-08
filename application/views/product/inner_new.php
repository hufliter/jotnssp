<?php
if(!empty($lastProduct)):
?><div class="row-fluid">
	<div class="product-label deco nonSelect">
		<span class="product_icon vip_icon"></span> Sản phẩm mới
	</div><div class="separator" style="margin-top:-3px;width:677px;padding:0;"></div>
</div>
<div class="row-fluid show">
	<div class="product-content sub-product product-table carousel_radius span12" style="height:100%;padding-top:5px">
		<div class="row-fluid"><ul class="thumbnails"><?php
			foreach($lastProduct as $k => $v):
				if($k==0 || ($k-1!=0 && ($k%3 ==0)))
					echo '<ul class="thumbnails">';
				?><li class="span4">
					<div class="thumbnail thumb_hover product <?= $v->available ? 'can-buy' : '' ?>"><?php
						echo anchor('/product/detail/'.$v->id.'/'.url_title(convert_accented_characters($v->name),'-',TRUE),
								img(array(
								'data-original'=>$v->thumb,'alt'=>html_escape($v->name),
								'data-src'=>'/assets/images/front/loader.gif',
								'title'=>html_escape($v->name),'class'=>'carousel_radius lazy'
								)).'<noscript>'.img(array(
								'src'=>$v->thumb,'alt'=>html_escape($v->name),
								'title'=>html_escape($v->name),'class'=>'carousel_radius no_lazy'
								)).'</noscript>'
						);
					?>
                        <div class="btn_buy" product-id="<?php echo $v->id; ?>" product-name="<?php echo $v->name; ?>"
                            product-price="<?php echo $v->price; ?>">
                            <a href="#">Mua ngay</a>
                        </div>
                        <?php if ($v->available != '1') : ?>
                            <div class="icon_out_stock"></div>
                        <?php endif; ?>

                    </div><div class="product-review">
                        <img class="price_tag" src="/assets/images/front/price_tag.png" />
                        <?php
						echo anchor('/product/detail/'.$v->id.'/'.url_title(convert_accented_characters($v->name),'-',TRUE), html_escape($v->name));
						?><div class="product-price carousel_radius nonSelect"><?php
							echo html_escape(countPrice($v));
						?></div>
					</div>
				</li><?php
				if(($k+1)%3 == 0 && $k!=0)
					echo '</ul>';
			endforeach;
			if(($k+1)%3 != 0)
				echo '</ul>';
		?></div>
		<div class="row-fluid">
			<div class="span12 text-right" id="view_more"><?php
				echo anchor('/product/index/21', 'Xem tất cả các sản phẩm tại đây');
			?></div>
		</div>
</div><?php
endif;
?>
<script>
$('img.lazy').show().lazyload({
	effect : "fadeIn",placeholder: '<?php echo base_url('/assets/images/front/loader.gif'); ?>'});
</script>