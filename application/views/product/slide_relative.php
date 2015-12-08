<?php
if(!empty($detail_relative)):
?><div class="carousel slide span11 offset1 carousel-small-control" id="carousel3">
	<div class="carousel-inner"><?php
		foreach($detail_relative as $k => $v):
			if($k==0 || ($k-1!=0 && ($k %4 ==0)))
				echo '<div class="item '.(($k==0)?'active':null).'"><ul class="thumbnails">';
			?><li class="span3">
				<div class="thumbnail"><?php
					echo anchor('/product/detail/'.$v->id.'/'.url_title(convert_accented_characters($v->name),'-',TRUE),img(array(
							'src'=>$v->thumb,'alt'=>html_escape($v->name),
							'title'=>html_escape($v->name),'style'=>'width:100px;height:80px',
							'class'=>'carousel_radius'
					)));
				?></div><div class="product-review"><?php
					echo anchor('/product/detail/'.$v->id.'/'.url_title(convert_accented_characters($v->name),'-',TRUE), html_escape($v->name));
					?></div>
			</li><?php
			if(($k+1)%4 == 0 && $k != 0)
				echo '</ul></div>';
		endforeach;
		if(!empty($k) && ($k+1)%4 != 0)
			echo '</ul></div>';
	?></div>
	<a data-slide="prev" href="#carousel3" class="left carousel-control"><?php
		echo img('assets/images/front/carousel_small_image_left.png');
	?></a>
	<a data-slide="next" href="#carousel3" class="right carousel-control"><?php
		echo img('assets/images/front/carousel_small_image_right.png');
	?></a>
</div><?php
endif;
?>