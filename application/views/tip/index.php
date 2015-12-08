<div class="container-fluid" style="padding:0;margin-top:-20px">
	<div class="row-fluid">
		<ul class="breadcrumb">
			<li><?php echo anchor('/','Home'); ?> <span class="divider">&#x203a;&#x203a;</span></li>
			<li class="active">Bí kíp</li>
		</ul>
	</div><div class="row-fluid">
		<div class="span12 border_radius show board"><div class="white_border border_radius">
			<div class="row-fluid">
				<div class="label show span8 nonSelect">Các bí kíp làm đẹp và chăm sóc sức khỏe</div>
			</div><div class="row-fluid"><?php
			if(!empty($pagination)):
				foreach($pagination as $v):
				?><div class="row-fluid">
					<div class="span3 tip_review_thumb"><?php
						echo anchor('/tip/detail/'.$v->id.'/'.url_title($v->name), img(array(
							'src'=>$v->thumb,'class'=>'carousel_radius'
						)));
					?></div><div class="span8 tip_review_text nonSelect"><?php
						echo anchor('/tip/detail/'.$v->id.'/'.url_title($v->name), $v->name);
						echo html_escape($v->review);
					?></div>
				</div><?php
				endforeach;
				echo $pagination_link;
			else:
				echo '<h5>Tạm thời chưa có bí kíp nào</h5>';
			endif;
			?></div>
		</div></div>
	</div>
</div>