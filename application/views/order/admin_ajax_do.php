<?php
echo form_open('/admincp/order/ajax_do/'.$order->id,array(
	'class'=>'form-horizontal','style'=>'margin:0',
	'id'=>'ajax_do'
)).form_hidden('id',$order->id);
?><div class="modal-header">
	<button type="button" data-dismiss="modal" aria-hidden="true" class="close">X</button>
	<h3 id="modal-header">Xử lý</h3>
</div><div class="modal-body">
	<div class="row-fluid">
		<div class="control-group">
			<label class="control-label" for="status">Tình trạng</label>
			<div class="controls">
				<label class="label label-success status" data-mess="Đặt hàng thành công, chúng tôi sẽ gửi hàng cho bạn sớm nhất có thể. Cảm ơn bạn đã chọn website của chúng tôi"><?php
					echo form_radio('status',1, $order->status==1).' '.$orderStatus[1];
				?></label> &nbsp;<label class="label label-warning status" data-mess="Đơn hàng của bạn tạm thời bị trì hoãn. Chúng tôi sẽ giải quyết sớm nhất có thể, cảm ơn."><?php
					echo form_radio('status',2, $order->status==2).' '.$orderStatus[2];
				?></label> &nbsp;<label class="label label-important status" data-mess="Thành thật xin lỗi, đơn hàng của bạn đã bị hủy bởi admin."><?php
					echo form_radio('status',8, $order->status==8).' '.$orderStatus[8];
				?></label>
			</div>
		</div><div class="control-group">
			<label class="control-label" for="mail">Gửi thư</label>
			<div class="controls">
				<label class="label label-success"><?php
					echo form_radio('mail',1,1);
				?> Có</label>
				<label class="label label-important"><?php
					echo form_radio('mail',0,0);
				?> Không</label>
			</div>
		</div><div class="control-group">
			<label class="control-label" for="mess">Tin nhắn</label>
			<div class="controls"><?php
				echo form_textarea(array(
					'name'=>'mess','value'=>'','id'=>'mess',
					'cols'=>'5','rows'=>'5'
				));
			?></div>
		</div><div class="control-group">
			<label class="control-label" for="captcha"><?php
				echo img('assets/images/captcha/'.$captTime.'.jpg');
			?></label><div class="controls"><?php
				echo form_input(array(
						'name'=>'captcha','value'=>'',
						'placeholder'=>'Captcha','id'=>'captcha',
						'style'=>'vertical-align:-15px',
						'autocomplete' => 'off'
				));
			?></div>
		</div>
	</div>
</div><div class="modal-footer"><?php
	echo form_submit(array(
		'name'=>'ok','value'=>'Chỉnh sửa',
		'class'=>'btn btn-info'
	));
	?> <button class="btn" data-dismiss="modal" aria-hidden="true">Đóng</button>
</div><?php
echo form_close();
?><script type="text/javascript">
(function(){
	var textarea = $('textarea');
	var selected = 0;
	function validate(){
		var check = $('input[name=status]').is(':checked');
		var capt = $('#captcha').val()
		return (check && capt!='');
	}

	$('label.status').click(function(){
		var input = $('input[name=status]:checked');
		if(!textarea.prop('disabled') && input.val()!= selected){
			textarea.val($(this).attr('data-mess'));
			selected = input.val();
		}
	});

	$('input[name=status]:checked').parent().trigger('click');
	$('input[name=mail]').change(function(){
		if($(this).val()==1)
			textarea.removeAttr('disabled');
		else
			textarea.attr('disabled','');
	});

	$('form').submit(function(){
		var f = $(this);
		if(validate()){
			$.ajax({
				url:f.attr('action'),
				type:'POST',cache:false,
				data:f.serialize()
			}).done(function(data){
				console.log(data);
				if(data=='success')
					alert('SUCCESS');
				else
					alert(data);

				$('#modalDo').modal('hide');
			})
		} else 
			alert('Please fill all the form');
		return false;
	});
})(jQuery);
</script>