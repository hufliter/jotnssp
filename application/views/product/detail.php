<div class="container-fluid" style="padding:0;margin-top:-20px">
	<div class="row-fluid">
		<ul class="breadcrumb">
			<li><?php echo anchor('/','Home'); ?> <span class="divider">&#x203a;&#x203a;</span></li>
			<li><?php echo anchor(
				'/category/show/'.$detail_product->cid.'/'.$detail_product->link,
				html_escape($detail_product->category)
			); ?> <span class="divider">&#x203a;&#x203a;</span></li>
			<li class="active"><?php echo html_escape($detail_product->name); ?></li>
		</ul>
	</div><div class="row-fluid">
		<div class="span12 border_radius show board_ribbon board" id="detail_product"><div class="white_border border_radius">
			<div class="row-fluid" style="margin-top:13px">
				<div class="label show nonSelect"> sản phẩm</div>
				<div style="display:inline-block;vertical-align:-40px;margin-left:10px">
					<div class="product_name"><span><?php echo html_escape($detail_product->name); ?></span></div>
				</div>					
			</div><div class="row-fluid">
				<div class="span6" style="margin-left:-15px">
					<div class="row-fluid">
						<div id="board_thumb" class="span10 offset1 show"><?php
							echo img(array(
								'src'=> $detail_product->thumb,
								'class'=>'border_radius','id'=>'product_thumbnail'
							));
						?></div>
					</div><div class="row-fluid">
						<div class="carousel slide span11 offset1 carousel-small-control" id="carousel_small_image">
							<div class="carousel-inner" id="elevatezoom"><?php
								$imgs = explode(',', $detail_product->image);
								foreach($imgs as $k => $v):
									if($k==0 || ($k-1!=0 && ($k %3 ==0)))
										echo '<div class="item '.(($k==0)?'active':null).'"><ul class="thumbnails">';
									?><li class="span4">
										<div class="thumbnail elevatezoom-gallery"><?php
											echo img(array(
												'src'=>$v,'class'=>'product_other_thumb'
											));
										?></div>
									</li><?php
									if(($k+1)%3 == 0 && $k != 0)
										echo '</ul></div>';
								endforeach;
								if(($k+1)%3 != 0)
									echo '</ul></div>';
							?></div>
							<a data-slide="prev" href="#carousel_small_image" class="left carousel-control"><?php
								echo img('assets/images/front/carousel_small_image_left.png');
							?></a>
		            		<a data-slide="next" href="#carousel_small_image" class="right carousel-control"><?php
		            			echo img('assets/images/front/carousel_small_image_right.png');
		            		?></a>
						</div>
					</div><div class="row-fluid"  style="margin-bottom:20px">
						<div class="span3 offset1 product_icon bow_icon_large">
						</div><div class="span8 product-price carousel_radius"><?php
							echo html_escape(countPrice($detail_product));
						?></div>
					</div><div class="row-fluid">
						<div class="product_share span11 offset1" style="text-align:center">
							<div id="fb-root"></div>
							<script>(function(d, s, id) {
							  var js, fjs = d.getElementsByTagName(s)[0];
							  if (d.getElementById(id)) return;
							  js = d.createElement(s); js.id = id;
							  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
							  fjs.parentNode.insertBefore(js, fjs);
							}(document, 'script', 'facebook-jssdk'));</script>
							<div class="fb-like" data-href="<?php echo current_url(); ?>" data-send="false" data-layout="button_count" data-width="450" data-show-faces="true"></div>
                            <span class="detail_buy" product-id="<?= $detail_product->id ?>" product-name="<?= $detail_product->name ?>" product-price="<?= $detail_product->price ?>">
                                <?php if ($detail_product->available): ?>
                                <a href="#" class="btn btn-danger btn-large">Mua ngay</a>
                                <?php else: ?>
                                    <button class="btn btn-inverse btn-large" disabled>Hết hàng</button>
                                <?php endif; ?>
                            </span>
						</div>
					</div>
				</div><div class="span6" style="margin-left:25px">
					<div class="row-fluid">
						<div class="sub_product_text span11 offset1" style="margin-top:-5px">
							<div class="product_text" style="padding-bottom:30px"><?php
								echo parseBbcode(stripslashes($detail_product->advantage));
							?></div>
						</div>
					</div>
				</div>
			</div><div class="row-fluid">
					<div class="offset1" id="product_relative" style="margin-left:20px"></div>
			</div><div class="row-fluid"><?php
				echo $slide_relative;
			?></div><div class="row-fluid"><?php
			if(!empty($ads->active) && $config->advertise):
				?><div class="span12"><?php
					$img = array(
						'src'=>$ads->img,
						'style'=>'height:100px;width:100%;margin-bottom:10px'
					);
					if(!empty($ads->link))
						echo anchor($ads->link,img($img),'alt="advertise" target="_blank"');
					else
						echo img($img);
				?></div><?php
			endif;
			?></div>
		</div></div>
	</div>
</div>
<script type="text/javascript">
	var h = $('div.product_text').outerHeight();
	$('div.sub_product_text').css('backgroundSize','332px '+h+'px');
	$('.product_other_thumb').click(function(){
		$('#product_thumbnail').attr('src',$(this).attr('src'));
		var img = $(this).attr('src');
		var ez = $('#product_thumbnail').data('elevateZoom');
		ez.swaptheimage(img, img); 
	});
	$('#product_thumbnail').elevateZoom({
		cursor:'crosshair',easing:true,
		zoomWindowFadeIn: 600,zoomWindowFadeOut: 600,
		lensFadeIn: 500,lensFadeOut: 500,
		zoomWindowWidth:300,zoomWindowHeight:300
	}).hover(function(){
		$('.zoomContainer').addClass('show');
	});
</script>