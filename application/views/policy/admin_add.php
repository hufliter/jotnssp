<?php
if(empty($ajax)):
?><div class="row-fluid">
	<div class="span12 round">
		<ul class="breadcrumb well well-small">
			<li><?php echo anchor('/admincp/policy','Chính Sách'); ?> <span class="divider">/</span></li>
			<li class="active">Thêm</li>
		</ul>
	</div>
</div><div class="row-fluid well well-small">
	<div class="span6 offset3"><?php
	endif;
	echo form_open(null,array('class'=>'form-horizontal'));
		?><div class="control-group">
			<label class="control-label" for="name">Tên Chính Sách</label>
			<div class="controls"><?php
				echo form_input(array(
					'name'=>'name','value'=>set_value('name'),
					'placeholder'=>'Tên Chính Sách','id'=>'name',
					'autocomplete' => 'off'
				));
				echo form_error('name');
			?></div>
		</div>
		<div class="control-group">
			<label class="control-label" for="name">Đường dẫn</label>
			<div class="controls"><?php
				echo form_input(array(
					'name'=>'link','value'=>set_value('link'),
					'placeholder'=>'Đường Dãn','id'=>'link',
					'autocomplete' => 'off'
				));
				echo form_error('link');
			?></div>
		</div>
		<div class="control-group">
			<label class="control-label" for="hot">Trạng Thái</label>
			<div class="controls"><?php
				echo '<label class="label label-warning">'.form_checkbox(array(
					'type'=>'radio','name'=>'status',
					'value'=>'0','checked'=>set_checkbox('status','0',true)
				)).' Tắt</label> &nbsp;&nbsp';
				echo '<label class="label label-success">'.form_checkbox(array(
					'type'=>'radio','name'=>'status',
					'value'=>'1','checked'=>set_checkbox('status','1')
				)).' Bật</label>';
				echo form_error('status');
			?></div>
		</div>
		<div class="control-group">
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
		</div>
		<div class="control-group">
			<div class="controls"><?php
				echo form_reset(array(
					'name'=>'reset','value'=>'Reset','class'=>'btn'
				)).' &nbsp;&nbsp;&nbsp;'.form_submit(array(
					'name'=>'submit','value'=>'Thêm Chính sách','class'=>'btn btn-info'
				));
			?></div>
		</div><?php
	echo form_close();
	if(empty($ajax)):
	?></div>
</div><?php
endif;
?><script type="text/javascript">
(function(){
	$('#detail').sceditor({
		plugins:'bbcode',
		toolbarExclude :'emoticon,cut,copy,paste',
		emoticonsEnabled:false,
		style:"<?php echo base_url(); ?>assets/css/jquery.sceditor.default.min.css"
	});
})(jQuery);
</script>