<div id="fb-root"></div>
<script type="text/javascript">
 $.ajaxSetup({ cache: true });
  $.getScript('//connect.facebook.net/en_UK/all.js', function(){
    FB.init({
      appId: '464400093677048',
    });     
    $('#loginbutton,#feedbutton').removeAttr('disabled');
    FB.getLoginStatus(updateStatusCallback);
  });
(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=464400093677048";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>
<div class="container-fluid" style="padding:0;margin-top:-20px">
	<div class="row-fluid">
		<ul class="breadcrumb">
			<li><?php echo anchor('/','Home'); ?> <span class="divider">&#x203a;&#x203a;</span></li>
			<li><?php echo anchor('/tip','Bí kíp'); ?> <span class="divider">&#x203a;&#x203a;</span></li>
			<li class="active"><?php echo html_escape($tip_detail->name); ?></li>
		</ul>
	</div><div class="row-fluid">
		<div class="span12 border_radius show board board_ribbon"><div class="white_border border_radius">
			<div class="row-fluid">
				<div class="product_name" style="margin-left:15px">
					<span><?php echo html_escape($tip_detail->name); ?></span>
				</div>
			</div><div class="row-fluid">
				<div class="span12 contact_content nonSelect" style="margin-top:20px;background:none">
					<div class="row-fluid">
						<div class="span12 nonSelect"><?php
							echo parseBbcode($tip_detail->detail);
						?></div>
					</div>
				</div>
			</div><div class="row-fluid">
				<div class="fb-comments span12" data-href="http://jotunshop.vn/tip/detail/<?php echo (int)$tip_detail->id; ?>" data-numposts="5" data-colorscheme="light">
				</div>
			</div>
		</div></div>
	</div>
</div><script type="text/javascript">
	var h =  $('.contact_content div.span12').outerHeight()+5;
	$('.contact_content').css('backgroundSize','620px '+h+'px');
</script>