<div class="container-fluid" style="padding:0;margin-top:-20px">
	<div class="row-fluid">
		<ul class="breadcrumb">
			<li><?php echo anchor('/','Home'); ?> <span class="divider">&#x203a;&#x203a;</span></li>
			<li class="active">Thông báo</li>
		</ul>
	</div><div class="row-fluid">
		<div class="span12 border_radius show board"><div class="white_border border_radius">
			<div id="news_label" class="show headline"><?php
				echo img(array(
					'src'=>'/assets/images/front/news_label.png',
				));
			?></div>
			<div class="row-fluid" id="news_review_content"><?php
			if(!empty($pagination)):
				$close = null;
				foreach($pagination as $k => $v):
					if($k == 0 || $k == 2):
						echo '<div class="span6 '.(($k==2)?'offset5':'').'">';
						$close = '</div>';
					endif;
				?><div class="row-fluid news_review_box">
					<div class="span7 news_review_title show"><?php
						echo anchor('/news/detail/'.$v->id.'/'.url_title($v->name), html_escape($v->name));
					?></div><div class="span11 news_review nonSelect"><?php
						echo html_escape($v->review);
					?></div>
				</div><?php
					if($k==1 || $k == 4):
						echo $close;
						$close = null;
					endif;
				endforeach;
				echo $close;
			else:
				echo '<h5>Tạm thời chưa có thông báo nào</h5>';
			endif;
			?></div><?php  echo $pagination_link; ?>
		</div></div>
	</div>
</div>
<script type="text/javascript">
	$.each($('.news_review_title'), function(k){
		if(k%2!=0)
			$(this).addClass('news_review_title_reverse').
			siblings('.news_review').addClass('news_review_reverse');
	});
</script>