<div class="row-fluid">
	<div class="span12 round">
		<ul class="breadcrumb well well-small">
			<li><?php echo anchor('/admincp/product','Sản phẩm'); ?> <span class="divider">/</span></li>
			<li class="active">Thêm</li>
		</ul>
	</div>
</div><div class="row-fluid well well-small">
	<div class="span6 offset3"><?php
	echo form_open(null,array('class'=>'form-horizontal'));
		?><div class="control-group">
			<label class="control-label" for="name">Quảng cáo</label>
			<div class="controls"><?php
				echo form_input(array(
					'name'=>'name','value'=>$position[$ads->position],
					'placeholder'=>'Tên sản phẩm','id'=>'name',
					'autocomplete' => 'off','disabled'=>'disabled'
				));
				echo form_error('name');
			?></div>
		</div><div class="control-group">
			<label class="control-label" for="name">Link</label>
			<div class="controls"><?php
				echo form_input(array(
					'name'=>'link','value'=>set_value('link', $ads->link),
					'placeholder'=>'Link','id'=>'name',
					'autocomplete' => 'off'
				));
				echo form_error('link');
			?></div>
		</div><div class="control-group">
			<label class="control-label" for="name">Link Hình</label>
			<div class="controls"><?php
				echo form_input(array(
					'name'=>'img','value'=>set_value('img', $ads->img),
					'placeholder'=>'Link hình ảnh','id'=>'name',
					'autocomplete' => 'off'
				));
				echo form_error('img');
			?></div>
		</div><div class="control-group">
			<label class="control-label" for="active">Tình trạng</label>
			<div class="controls"><?php
				echo '<label class="label label-warning">'.form_checkbox(array(
					'type'=>'radio','name'=>'active',
					'value'=>'0','checked'=>set_radio('active','0', (bool)!$ads->active)
				)).' Không</label> &nbsp;&nbsp';
				echo '<label class="label label-success">'.form_checkbox(array(
					'type'=>'radio','name'=>'active',
					'value'=>'1','checked'=>set_radio('active','1', (bool)$ads->active)
				)).' Có</label>';
				echo form_error('active');
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
				)).' &nbsp;&nbsp;&nbsp;'.form_submit(array(
					'name'=>'submit','value'=>'Sửa quảng cáo','class'=>'btn btn-info'
				));
			?></div>
		</div>
	
	</div>
</div>