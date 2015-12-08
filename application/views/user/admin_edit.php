<div class="row-fluid">
	<div class="span12 round">
		<ul class="breadcrumb well well-small">
			<li class="active">Sửa mật khẩu</li>
		</ul>
	</div>
</div><div class="row-fluid well well-small">
	<div class="span6 offset3"><?php
	echo form_open(null,array('class'=>'form-horizontal'));
		?><div class="control-group">
			<label class="control-label" for="pass">Mật khẩu</label>
			<div class="controls"><?php
				echo form_password(array(
					'name'=>'pass','value'=>'',
					'placeholder'=>'password','id'=>'pass',
					'autocomplete' => 'off'
				));
				echo form_error('pass');
			?></div>
		</div><div class="control-group">
			<label class="control-label" for="captcha"><?php
				echo img('assets/images/captcha/'.$captTime.'.jpg');
			?></label>
			<div class="controls"><?php
				echo form_input(array(
					'name'=>'captcha','value'=>'',
					'placeholder'=>'Captcha','id'=>'captcha',
					'style'=>'vertical-align:-15px',
					'autocomplete' => 'off'
				));
				echo form_error('captcha');
			?></div>
		</div><div class="control-group">
			<div class="controls"><?php
				echo form_submit(array(
					'name'=>'submit','value'=>'Sửa','class'=>'btn btn-info'
				));
			?></div>
		</div><?php
	echo form_close();
	?></div>
</div>