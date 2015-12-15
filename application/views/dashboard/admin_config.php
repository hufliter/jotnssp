<div class="row-fluid">
	<div class="span12 round">
		<ul class="breadcrumb well well-small">
			<li><?php echo anchor('/admincp/dashboard','Dashboard'); ?> <span class="divider">/</span></li>
			<li class="active">Cấu hình</li>
		</ul>
	</div>
</div><div class="row-fluid well well-small">
	<div class="span6 offset3"><?php
	echo form_open(null,array('class'=>'form-horizontal'));
		?><div class="control-group">
			<label class="control-label" for="status">Tình trạng website</label>
			<div class="controls"><?php
				$ar = array('1'=>'Bật','0'=>'Tắt');
				echo form_dropdown('status', $ar, set_value('status', $config->status));
				echo form_error('status');
			?></div>
		</div><div class="control-group">
			<label class="control-label" for="status">Quảng cáo</label>
			<div class="controls"><?php
				$ar = array('1'=>'Bật','0'=>'Tắt');
				echo form_dropdown('advertise', $ar, set_value('status', $config->advertise));
				echo form_error('advertise');
			?></div>
		</div>

        <div class="control-group">
            <label class="control-label" for="conf_reseller_value">% Hoa hồng CTV</label>
            <div class="controls">
                <input type="number" name="conf_reseller_value" id="conf_reseller_value" value="<?= $conf_reseller_value ?>"/>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="conf_coupon_off">% Hóa đơn được giảm</label>
            <div class="controls">
                <input type="number" name="conf_coupon_off" id="conf_coupon_off" value="<?= $conf_coupon_off ?>"/>
            </div>
        </div>

        <div class="control-group">
				Lý do đóng cửa<?php
				echo form_textarea(array(
					'name'=>'reason','value'=>set_value('reason', $config->reason),
					'placeholder'=>'Lý do','id'=>'reason',
					'cols'=>'50','rows'=>'10','style'=>'width:100%'
				));
				echo form_error('reason');
			?>
		</div><div class="control-group">
			<label class="control-label" for="contact">Địa chỉ</label>
			<div class="controls"><?php
				echo form_input(array(
					'name'=>'contact','value'=>set_value('contact', $config->contact),
					'placeholder'=>'Địa chỉ','id'=>'contact',
					'autocomplete' => 'off'
				));
				echo form_error('contact');
			?></div>
		</div>
		<div class="control-group">
			<label class="control-label" >Mã Số Thuế</label>
			<div class="controls"><?php
				echo form_input(array(
					'name'=>'tax_code','value'=>set_value('tax_code', $config->tax_code),
					'placeholder'=>'Mã Số Thuế','id'=>'tax-code',
					'autocomplete' => 'off'
				));
				echo form_error('tax_code');
			?></div>
		</div>
		<div class="control-group">
			<label class="control-label" >Email</label>
			<div class="controls"><?php
				echo form_input(array(
					'name'=>'email','value'=>set_value('email', $config->email),
					'placeholder'=>'Email','id'=>'email',
					'type'=>'email',
					'autocomplete' => 'off'
				));
				echo form_error('email');
			?></div>
		</div>
		<div class="control-group">
			<label class="control-label" for="phone">Phone</label>
			<div class="controls"><?php
				echo form_input(array(
					'name'=>'phone','value'=>set_value('phone', $config->phone),
					'placeholder'=>'XXX(abc)','id'=>'phone',
					'autocomplete' => 'off'
				));
				echo form_error('phone');
			?></div>
		</div><div class="control-group">
				Liên hệ<?php
				echo form_textarea(array(
					'name'=>'ck','value'=>set_value('ck',$config->ck),
					'placeholder'=>'Liên hệ','id'=>'ck',
					'cols'=>'50','rows'=>'10','style'=>'width:100%'
				));
				echo form_error('ck');
			?>
		</div><div class="control-group">
				Chuyển khoản trước<?php
				echo form_textarea(array(
					'name'=>'ckt','value'=>set_value('ckt',$config->ckt),
					'placeholder'=>'Chuyển khoản trước','id'=>'ckt',
					'cols'=>'50','rows'=>'10','style'=>'width:100%'
				));
				echo form_error('ckt');
			?>
		</div><div class="control-group">
				Chuyển khoản sau<?php
				echo form_textarea(array(
					'name'=>'cks','value'=>set_value('cks',$config->cks),
					'placeholder'=>'Chuyển khoản sau','id'=>'cks',
					'cols'=>'50','rows'=>'10','style'=>'width:100%'
				));
				echo form_error('cks');
			?>
		</div><div class="control-group">
				Gửi và nhận hàng<?php
				echo form_textarea(array(
					'name'=>'gnh','value'=>set_value('gnh',$config->gnh),
					'placeholder'=>'Gửi nhận hàng','id'=>'gnh',
					'cols'=>'50','rows'=>'10','style'=>'width:100%'
				));
				echo form_error('gnh');
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
				)).'&nbsp;&nbsp;&nbsp;&nbsp;'.form_submit(array(
					'name'=>'submit','value'=>'Sửa','class'=>'btn btn-info'
				));
			?></div>
		</div><?php
	echo form_close();
	?></div>
</div><script type="text/javascript">
	$('#reason,#ckt,#cks,#gnh,#ck').sceditor({
		plugins:'bbcode',
		toolbarExclude :'emoticon,cut,copy,paste',
		emoticonsEnabled:false,
		style:"<?php echo base_url(); ?>assets/css/jquery.sceditor.default.min.css"
	});
</script>