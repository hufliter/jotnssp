<?php echo doctype('html5'); ?>
<html><head>
	<title>Jotun shop</title><?php
echo meta(array(
	array('name'=>'viewport','content'=>'width=device-width, initial-scale=1.0'),
	array('name'=>'Content-type','content'=>'text/html; charset=utf-8','type'=>'equiv')
));
echo link_tag(
	array('href'=>'assets/css/bootstrap.min.css','rel'=>'stylesheet','media'=>'screen')
);
echo link_tag(
	array('href'=>'assets/css/front.css','rel'=>'stylesheet','media'=>'screen')
);
if(!empty($css))
	foreach($css as $v)
		echo link_tag(array('href'=>base_url().'assets/css/'.$v.'.css','rel'=>'stylesheet'));

	echo '<script type="text/javascript" src="'.base_url().'assets/js/jquery-1.9.0.js"></script>';
	echo '<script type="text/javascript" src="'.base_url().'assets/js/bootstrap.min.js"></script>';
if(!empty($js))
	foreach($js as $v)
		echo '<script type="text/javascript" src="'.base_url().'assets/js/'.$v.'.js"></script>';
?><style type="text/css">
.container {position: relative;z-index: 10}
#logo {
	height:140px;
	width: 200px;
	margin: 24px 0 0 170px;
}
.footer {
	position: absolute;
	bottom: 0px;
	width: 100%;height: 160px;
	background-size:100% 200%;
	z-index:1;
}
@media (max-width: 979px) and (min-width: 768px){
	#logo {
		width: 150px;
		margin:0 0 0 130px;
	}
	.footer {
		height: 280px;
		background-size:100% 200%;
	}
}
@media (min-width: 1200px){
	#logo {
		width: 250px;
		margin:70px 0 0 210px;
	}
	.footer {
		height: 50px;
		background-size:100%;
	}
}
#ad {
	position: absolute;
	width: 100%;height: 100%;
	top:0;z-index: 20;
}
</style>
<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
</head><body style="position:relative">
	<div class="container fill">
		<div class="row fill">
			<div class="curtain span12 fill scale">
				<div class="row">
						<div class="furniture span10 offset1">
							<div id="logo"></div>
						</div>
				</div>
			</div>
		</div>
	</div>
	<div class="footer"></div>
	<?php
	echo anchor('/page/',' ','title="Vào trang chủ" id="ad"');
?></body></html>