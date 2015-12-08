<?php echo doctype('html5'); ?>
<html><head>
	<title>Shutdown</title><?php
echo meta(array(
	array('name'=>'viewport','content'=>'width=device-width, initial-scale=1.0'),
	array('name'=>'Content-type','content'=>'text/html; charset=utf-8','type'=>'equiv'),
	array('name'=>'Content-Language','content'=>'vi','type'=>'equiv'),
	array('name' => 'keywords', 'content' => 'Jotunshop đang bảo trì, jotun shop is in maintenance, maintain')
));
?>
	<meta property="og:title" content="Bảo trì">
	<meta property="og:description" content="Website jotun đang tiến hành bảo trì, xin vui lòng quay lại sau">
	<meta property="og:image" content="<?php echo base_url('/assets/images/front/face_logo.png'); ?>">
	<meta property="og:url" content="http://jotunshop.vn">
	<meta property="og:site_name" content="JotunShop">
<?php
echo '<link rel="shortcut icon" href="'.base_url('/assets/images/front/favicon.ico').'" />';
echo link_tag(
	array('href'=>'assets/css/bootstrap.min.css','rel'=>'stylesheet','media'=>'screen')
);
if(!empty($css))
	foreach($css as $v)
		echo link_tag(array('href'=>base_url().'assets/css/'.$v.'.css','rel'=>'stylesheet'));

	echo '<script type="text/javascript" src="'.base_url().'assets/js/jquery-1.9.0.js"></script>';
	echo '<script type="text/javascript" src="'.base_url().'assets/js/bootstrap.min.js"></script>';
if(!empty($js))
	foreach($js as $v)
		echo '<script type="text/javascript" src="'.base_url().'assets/js/'.$v.'.js"></script>';
?></head><body>
	<div class="container">
		<div class="row">
			<div class="span12"><?php
		echo parseBbcode($config->reason);
			?></div>
		</div>
	</div>
</body>