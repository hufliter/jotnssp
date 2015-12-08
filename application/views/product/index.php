<div class="container-fluid" style="padding:0;margin-top:-20px">
	<div class="row-fluid">
		<div class="breadcrumb">
			<li><?php echo anchor('/','Home'); ?> <span class="divider">&#x203a;&#x203a;</span></li>
			<li class="active">Sản phẩm mới cập nhật</li>
		</div>
	</div><div class="row-fluid">
		<div class="span12 border_radius show board"><div class="white_border border_radius"><?php
		if(!empty($pagination)):
			?><div class="row-fluid">
				<div class="label show nonSelect">Sản phẩm mới cập nhật</div>
			</div><div class="row-fluid" style="margin-top:20px">
				<div class="product-content products-page"><ul class="thumbnails"><?php
					foreach($pagination as $k => $v):
						if($k==0 || ($k-1!=0 && ($k %3 ==0)))
							echo '<ul class="thumbnails">';
						?><li class="span4">
							<div class="thumbnail thumb_hover  <?= $v->available ? 'can-buy' : '' ?>" style="margin-top:-12px"><?php
								echo anchor('/product/detail/'.$v->id.'/'.url_title(convert_accented_characters($v->name),'-',TRUE),img(array(
									'src'=>$v->thumb,'alt'=>html_escape($v->name),
									'title'=>html_escape($v->name),'style'=>'width:160px;height:160px',
									'class'=>'carousel_radius'
								)));
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
				?></div><?php
				echo $pagination_link;
			?></div><?php
		else:
			echo '<h5>Không có sản phẩm phù hợp yêu cầu của bạn';
		endif;
		?></div></div>
	</div>
</div>