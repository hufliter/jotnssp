<?php
$c = new common_helper();
if(empty($ajax)):
?><div class="row-fluid">
	<div class="span12 round">
		<ul class="breadcrumb well well-small">
			<li><?php echo anchor('/admincp/product','Sản phẩm'); ?> <span class="divider">/</span></li>
			<li class="active">Thêm</li>
		</ul>
	</div>
</div><div class="row-fluid well well-small">
	<div class="span6 offset3"><?php
	endif;
	echo form_open(null,array('class'=>'form-horizontal'));
		?><div class="control-group">
			<label class="control-label" for="name">Tên sản phẩm</label>
			<div class="controls"><?php
				echo form_input(array(
					'name'=>'name','value'=>set_value('name'),
					'placeholder'=>'Tên sản phẩm','id'=>'name',
					'autocomplete' => 'off'
				));
				echo form_error('name');
			?></div>
		</div><div class="control-group">
			<label class="control-label" for="catory">Chủng loại</label>
			<div class="controls"><?php
				echo form_dropdown('category', $c->category_drop($category,1), set_value('category'));
				echo form_error('category');
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
			<label class="control-label" for="image">Ảnh khác</label>
			<div class="controls"><div class="input-append" id="image"><?php
				$imgs = $this->input->post('image');
				if(!empty($imgs) && is_array($imgs)):
					foreach($imgs as $k => $img):
						echo form_input(array(
							'name'=>'image[]','value'=>$img,
							'placeholder'=>'Link','autocomplete' => 'off',
							'style'=>($k!=0)?'margin-top:10px':null
						));
						if($k==0)
						echo '<button class="btn" id="addBtn" type="button">Thêm</button></div>';
					endforeach;					
				else:
					echo form_input(array(
						'name'=>'image[]','value'=>'',
						'placeholder'=>'Link','autocomplete' => 'off'
					)).'<button class="btn" id="addBtn" type="button">Thêm</button></div>';
				endif;				
				echo form_error('image');
			?></div>
		</div><div class="control-group">
			<label class="control-label" for="tag">SEO</label>
			<div class="controls"><?php
				echo form_input(array(
					'name'=>'tag','value'=>set_value('tag'),'autocomplete'=>'off',
					'id'=>'tag'
				));
				echo form_error('tag');
			?></div>
		</div><div class="control-group">
			Ưu điểm<?php
				$textarea_val = stripslashes(html_entity_decode($this->input->get_advantage(), ENT_QUOTES));
				if(empty($textarea_val))
					$textarea_val = null;
				echo form_textarea(array(
					'name'=>'advantage','value'=>$textarea_val,
					'placeholder'=>'Ưu điểm','id'=>'advantage',
					'cols'=>'50','rows'=>'10','style'=>'width:100%'
				));
				echo form_error('advantage');
			?>
		</div><div class="control-group">
			<label class="control-label" for="hot">Hot</label>
			<div class="controls"><?php
				echo '<label class="label label-warning">'.form_checkbox(array(
					'type'=>'radio','name'=>'hot',
					'value'=>'0','checked'=>set_checkbox('hot','0',true)
				)).' Không</label> &nbsp;&nbsp';
				echo '<label class="label label-success">'.form_checkbox(array(
					'type'=>'radio','name'=>'hot',
					'value'=>'1','checked'=>set_checkbox('hot','1')
				)).' Có</label>';
				echo form_error('hot');
			?></div>
		</div><div class="control-group">
			<label class="control-label" for="price">Giá</label>
			<div class="controls"><div class="input-append"><?php
				echo form_input(array(
					'name'=>'price','value'=>set_value('price'),
					'placeholder'=>'Giá','id'=>'price',
					'autocomplete' => 'off'
				)).'<span class="add-on">K</span></div>';
				echo form_error('price');
			?></div>
		</div><div class="control-group">
			<label class="control-label" for="sale">% Sale</label>
			<div class="controls"><div class="input-append"><?php
				echo form_input(array(
					'name'=>'sale','value'=>set_value('sale',0),
					'placeholder'=>'%','id'=>'sale',
					'autocomplete' => 'off','class'=>'span3'
				)).'<span class="add-on">%</span></div>';
				echo form_error('sale');
			?></div>
		</div><div class="control-group">
			<label class="control-label" for="start">Ngày bắt đầu</label>
			<div class="controls"><?php
				echo form_input(array(
					'name'=>'start','value'=>set_value('start'),
					'placeholder'=>'d-m-y','id'=>'start',
					'autocomplete' => 'off','class'=>'span3'
				));
				echo form_error('start');
			?></div>
		</div><div class="control-group">
			<label class="control-label" for="sale">Ngày kết thúc</label>
			<div class="controls"><?php
				echo form_input(array(
					'name'=>'end','value'=>set_value('end'),
					'placeholder'=>'d-m-y','id'=>'end',
					'autocomplete' => 'off','class'=>'span3'
				));
				echo form_error('end');
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
					'name'=>'submit','value'=>'Thêm sản phẩm','class'=>'btn btn-info'
				));
			?></div>
		</div><script>$('#tag').tagit({
			allowSpaces: true,removeConfirmation:true
		});</script><?php
	echo form_close();
	if(empty($ajax)):
	?></div>
</div><?php
endif;
?><script type="text/javascript">
(function(){
	cl = $('#image input').first();
	target = $('#image').parent();
	count =1;

	$('#start').datepicker({
		dateFormat:'dd-mm-yy',
		onClose:function(selectedDate){
			$('#end').datepicker('option','minDate', selectedDate);
		}
	});

	$('#end').datepicker({
		dateFormat:'dd-mm-yy',
		onClose:function(selectedDate){
			$('#start').datepicker('option','maxDate', selectedDate);
		}
	});

	$('#addBtn').click(function(){
		count++;
		if(count<=9)
			$(cl).clone().val('').css('margin-top','10px').appendTo(target);
		else
			alert('Vượt quá số lượng hình cho phép');
	});
	$('#advantage,#use').sceditor({
		plugins:'bbcode',
		toolbarExclude :'emoticon,cut,copy,paste',
		emoticonsEnabled:false,
		style:"<?php echo base_url(); ?>assets/css/jquery.sceditor.default.min.css"
	});
})(jQuery);
</script>