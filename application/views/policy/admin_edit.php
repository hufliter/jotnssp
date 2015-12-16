<?php
if(empty($ajax)):
?><div class="row-fluid">
	<div class="span12 round">
		<ul class="breadcrumb well well-small">
			<li><?php echo anchor('/admincp/recruitment','Chính sách'); ?> <span class="divider">/</span></li>
			<li class="active">Sửa</li>
		</ul>
	</div>
</div><div class="row-fluid well well-small">
	<div class="span6 offset3"><?php
	endif;
	echo form_open(null,array('class'=>'form-horizontal'));
	echo form_hidden('id',$policy->id);
		?><div class="control-group">
			<label class="control-label" for="name">Tên Chính sách</label>
			<div class="controls"><?php
				echo form_input(array(
					'name'=>'name','value'=>$policy->name,
					'placeholder'=>'Tên Chính sách','id'=>'name',
					'autocomplete' => 'off'
				));
				echo form_error('name');
			?></div>
		</div>
		<div class="control-group">
			<label class="control-label" for="name">Đường dẫn</label>
			<div class="controls"><?php
				echo form_input(array(
					'name'=>'link','value'=>$policy->link,
					'placeholder'=>'Đường dẫn','id'=>'link',
					'autocomplete' => 'off'
				));
				echo form_error('link');
			?></div>
		</div>

		<div class="control-group">
            <label class="control-label" for="status">Trạng Thái</label>
            <div class="controls">
                <label class="radio inline label label-warning">
                    <input type="radio" name="status" value="0" class="icheck"
                           <?= !$policy->status ? "checked" : "" ?>
                        /> Tắt
                </label>
                <label class="radio inline label label-info">
                    <input type="radio" name="status" value="1" class="icheck"
                        <?= $policy->status ? "checked" : "" ?>
                        /> Bật
                </label>
            </div>
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
					'name'=>'submit','value'=>'Sửa chính sách','class'=>'btn btn-info'
				));
			?></div>
		</div><?php
	echo form_close();
	?></div>
</div>