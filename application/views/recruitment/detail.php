<div class="container-fluid" style="padding:0;margin-top:-20px">
	<div class="row-fluid">
		<ul class="breadcrumb">
			<li><?php echo anchor('/','Home'); ?> <span class="divider">&#x203a;&#x203a;</span></li>
			<li><?php echo anchor('/recruitment','Thông báo'); ?> <span class="divider">&#x203a;&#x203a;</span></li>
			<li class="active"><?php echo html_escape($recruitment_detail->name); ?></li>
		</ul>
	</div><div class="row-fluid">
		<div class="span12 border_radius show board board_ribbon"><div class="white_border border_radius">
			<div class="row-fluid">
				<div class="product_name" style="margin-left:15px">
					<span><?php echo html_escape($recruitment_detail->name); ?></span>
				</div>
			</div><div class="row-fluid">
				<div class="span12 contact_content" style="margin-top:20px">
					<div class="row-fluid">
						<div class="span12"><?php
							echo parseBbcode($recruitment_detail->detail);
						?></div>
					</div>
				</div>
			</div>
		</div></div>
	</div>
</div><script type="text/javascript">
	var h =  $('.contact_content div.span12').outerHeight()+5;
	$('.contact_content').css('backgroundSize','620px '+h+'px');
</script>