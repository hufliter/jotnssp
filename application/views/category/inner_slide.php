<?php
if(!empty($hotProduct)):
?><div class="row-fluid">
	<div class="product-label deco nonSelect">
		<span class="product_icon vip_icon"></span> Sản phẩm hot
	</div><div class="separator" style="margin-top:-3px;width:677px;padding:0;"></div>
</div>
<div class="row-fluid row-relative">
	<div class="product-content">
		<div class="container-fluid">
			<div class="row-fluid">
				<div class="carousel slide" id="carousel2">
					<div class="carousel-inner carousel_radius"><?php
					foreach($hotProduct as $k => $v):
						if($k==0 || ($k-1!=0 && ($k%3 ==0)))
							echo '<div class="item '.(($k==0)?'active':null).'"><ul class="thumbnails">';
						?><li class="span4">
							<div class="thumbnail thumb_hover <?= $v->available ? 'can-buy' : '' ?>"><?php
								echo anchor('/product/detail/'.$v->id.'/'.url_title(convert_accented_characters($v->name),'-',TRUE),img(array(
									'src'=>$v->thumb,'alt'=>html_escape($v->name),
									'title'=>html_escape($v->name),'style'=>'width:140px;height:130px',
									'class'=>'carousel_radius'
								)));
							?>
                                <div class="btn_buy" product-id="<?php echo $v->id; ?>" product-name="<?php echo $v->name; ?>"
                                     product-price="<?php echo $v->price; ?>" style="width: 141px;height: 130px;top: 8px;left: 36px;">
                                    <a href="#">Mua ngay</a>
                                </div>
                                <?php if ($v->available != '1') : ?>
                                    <div style="left: 29px;" class="icon_out_stock"></div>
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
							echo '</ul></div>';
					endforeach;
					if(($k+1)%3 != 0)
						echo '</ul></div>';
					?></div>
					<a data-slide="prev" href="#carousel2" class="left carousel-control">‹</a>
		            <a data-slide="next" href="#carousel2" class="right carousel-control">›</a>
				</div>
			</div>
		</div>
	</div>
</div>		
<script type="text/javascript">
	$('#carousel2').carousel();
</script><?php
endif;
?>