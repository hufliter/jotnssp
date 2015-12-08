<?php
if(empty($ajax)):
?><div class="row-fluid">
	<div class="span12 round">
		<ul class="breadcrumb well well-small">
			<li><?php echo anchor('/admincp/news','tin tức'); ?> <span class="divider">/</span></li>
			<li class="active">Sửa</li>
		</ul>
	</div>
</div><div class="row-fluid well well-small">
	<div class="span6 offset3"><?php
	endif;
	echo form_open(null,array('class'=>'form-horizontal'));
	echo form_hidden('id',$news->id);
		?><div class="control-group">
			<label class="control-label" for="name">Tên</label>
			<div class="controls"><?php
				echo form_input(array(
					'name'=>'name','value'=>set_value('name',$news->name),
					'placeholder'=>'Tên sản phẩm','id'=>'name',
					'autocomplete' => 'off'
				));
				echo form_error('name');
			?></div>
		</div><div class="control-group">
			<label class="control-label" for="thumb">Hình đại diện</label>
			<div class="controls"><?php
				echo form_input(array(
					'name'=>'thumb','value'=>set_value('thumb',$news->thumb),
					'placeholder'=>'Link','id'=>'thumb',
					'autocomplete' => 'off'
				));
				echo form_error('thumb');
			?></div>
		</div><div class="control-group">
			Review<?php
				echo form_textarea(array(
					'name'=>'review','value'=>set_value('review',$news->review),
					'placeholder'=>'Ưu điểm','id'=>'review',
					'cols'=>'50','rows'=>'10','style'=>'width:100%'
				));
				echo form_error('review');
			?>
		</div><div class="control-group">
			Chi tiết <?php
				$detail = $this->input->get_news_detail();
				if(empty($detail))
					$detail = $news->detail;
				echo form_textarea(array(
					'name'=>'detail','value'=>stripslashes(html_entity_decode($detail, ENT_QUOTES)),
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
					'name'=>'submit','value'=>'Sửa tin tức','class'=>'btn btn-info'
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