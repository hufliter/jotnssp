<?php
if(empty($ajax)):
?><div class="row-fluid">
	<div class="span12 round">
		<ul class="breadcrumb well well-small">
			<li><?php echo anchor('/admincp/tip','Bí kíp'); ?> <span class="divider">/</span></li>
			<li class="active">Thêm</li>
		</ul>
	</div>
</div><div class="row-fluid well well-small">
	<div class="span6 offset3"><?php
	endif;
	echo form_open(null,array('class'=>'form-horizontal'));
		?><div class="control-group">
			<label class="control-label" for="name">Tên</label>
			<div class="controls"><?php
				echo form_input(array(
					'name'=>'name','value'=>set_value('name'),
					'placeholder'=>'Tên bí kíp','id'=>'name',
					'autocomplete' => 'off'
				));
				echo form_error('name');
			?></div>
		</div><div class="control-group">
			<label class="control-label" for="thumb">Hình đại diện</label>
			<div class="controls"><?php
				echo form_input(array(
					'name'=>'thumb','value'=>set_value('thumb'),
					'placeholder'=>'Link','id'=>'thumb',
					'autocomplete' => 'off'
				));
				echo form_error('thumb');
			?></div>
		</div><div class="control-group">
			Review<?php
				echo form_textarea(array(
					'name'=>'review','value'=>set_value('review'),
					'placeholder'=>'Tóm tắt','id'=>'review',
					'cols'=>'50','rows'=>'10','style'=>'width:100%'
				));
				echo form_error('review');
			?>
		</div><div class="control-group">
			Chi tiết <?php
				echo form_textarea(array(
					'name'=>'detail','value'=>set_value('detail'),
					'placeholder'=>'Cách dùng','id'=>'detail',
					'autocomplete' => 'off','style'=>'width:100%',
					'cols'=>'50','rows'=>'10'
				));
				echo form_error('detail');
			?>
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
				)).' &nbsp;&nbsp;&nbsp;'.form_submit(array(
					'name'=>'submit','value'=>'Thêm bí kíp','class'=>'btn btn-info'
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