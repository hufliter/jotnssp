<?php
if(!empty($page_ads)):
?><div class="row show" style="left:10px">
	<div class="span12 pane_carousel carousel_radius">
		<div class="pane_carousel_inner"><div class="pane_carousel_item"><?php
		$img = array(
			'src'=>$page_ads->img,
			'alt'=>'Quảng cáo'
		);
		if(!empty($page_ads->link))
			echo anchor($page_ads->link,img($img),'alt="advertise" target="_blank"');
		else
			echo img($img);
		?></div></div>
	</div>
</div><?php
endif;
?>
