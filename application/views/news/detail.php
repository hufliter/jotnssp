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
			<div class="row-fluid show" id="news_detail">
				<div class="row-fluid">
					<div id="news_detail_header" class="span7 news_review_title news_review_title_reverse show tag_line">
						<a href="#"><?php echo html_escape($news_detail->name); ?></a>
					</div>
				</div><div class="row-fluid">
					<div class="span8 nonSelect" id="news_detail_content"><?php
						echo parseBbcode(stripslashes($news_detail->detail));
					?></div>
				</div>
			</div>
		</div></div>
	</div>
</div>