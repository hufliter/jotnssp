<?php echo doctype('html5'); ?>
<html></head>
	<title>Trang Đăng Nhập</title><?php
	echo meta(array(
	array('name'=>'viewport','content'=>'width=device-width, initial-scale=1.0'),
	array('name'=>'Content-type','content'=>'text/html; charset=utf-8','type'=>'equiv')
));
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
?><style type="text/css">
#loginDiv {
	margin-top:20px;
}
label {
	float: left;
	width: 140px;
	text-align: right;
	padding-top: 8px;
	padding-right: 20px;
}
input.user, input.pass, input.captcha {width: 182px !important;}
.button-div {
	padding: 10px;
	margin-left: 206px;
}
body {background:#fafafa;}
</style>
</head><body>
	<div class="container"><?php
 		showFlash($this);
		?><div class="row-fluid">
			<div class="span6 offset3 well" id="loginDiv"><?php
		echo form_open();
		?>
				<fieldset>
					<legend>User login</legend>

					<label for="user">Username</label>
					<div class="div_text">
						<div class="input-prepend">
							<span class="add-on"><i class="icon-user"></i></span><?php
							echo form_input(array(
								'name'=>'user',
								'value'=>set_value('user'),
								'class'=>'user span2','placeholder'=>'Username here'
							));
							echo form_error('user');
						?></div>
					</div>
					<label for="pass">Password</label>
					<div class="div_text">
						<div class="input-prepend">
							<span class="add-on"><i class="icon-lock"></i></span><?php
						echo form_password(array(
							'name'=>'pass','value'=>'',
							'class'=>'span2 pass','placeholder'=>'Password here'
						));
						echo form_error('pass');
						?></div>
					</div>
					<label for="captcha"><?php
					echo img('assets/images/captcha/'.$captTime.'.jpg');
					?></label>
					<div class="div_text">
						<div class="input-prepend" style="vertical-align:-8px">
							<span class="add-on"><i class="icon-eye-open"></i></span><?php
						echo form_input(array(
							'name'=>'captcha','value'=>'',
							'class'=>'span2 captcha', 'placeholder'=>'Enter the captcha'
						));
						echo form_error('captcha');
						?></div>
					</div>
					<div class="button-div"><?php
					echo form_submit(array(
						'name'=>'submit','value'=>'Login',
						'class'=>'btn btn-small btn-info'
					)).' '.form_reset(array(
						'value'=>'Reset','class'=>'btn btn-small'
					));
					?></div>
				</fieldset>
		<?php
		echo form_close();
			?></div>
		</div>
	</div>
</body></html>