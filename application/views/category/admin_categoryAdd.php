<?php
$c = new common_helper();
if(empty($ajax)):
?><div class="row-fluid">
	<div class="span12 round">
		<ul class="breadcrumb well well-small">
			<li><?php echo anchor('/admincp/category','Chủng loại'); ?> <span class="divider">/</span></li>
			<li class="active">Thêm</li>
		</ul>
	</div>
</div><div class="row-fluid well well-small">
	<div class="span6 offset3"><?php
	endif;
	echo form_open(null,array('class'=>'form-horizontal'));
		?><div class="control-group">
			<label class="control-label" for="name">Tên chủng loại</label>
			<div class="controls"><?php
				echo form_input(array(
					'name'=>'name',
					'value'=>set_value('name'),
					'autocomplete'=>'off',
					'placeholder'=>'Tên chủng loại'
				));
				echo form_error('name');
			?></div>
		</div><div class="control-group">
			<label class="control-label" for="parent">Chủng loại cha</label>
			<div class="controls"><?php
				echo form_dropdown('parent', $c->category_drop($category), set_value('parent'));
				echo form_error('parent');
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
				echo form_reset(array(
					'name'=>'reset','value'=>'Reset','class'=>'btn'
				)).' &nbsp;&nbsp;&nbsp;&nbsp;'.form_submit(array(
					'name'=>'submit','value'=>'Thêm','class'=>'btn btn-info'
				));
			?></div>
		</div><?php
	echo form_close();
	if(empty($ajax)):
	?></div>
</div><?php
endif;
?>