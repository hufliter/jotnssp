<div class="row-fluid">
	<div class="span12 round" style="position:relative">
		<ul class="breadcrumb well well-small">
			<li class="active">Chủng loại</li>
		</ul><div class="span2" style="position:absolute;top:5px;right:5px" id="a"><?php
			echo anchor('/admincp/category/categoryAdd/','Thêm chủng loại','class="btn btn-info addBtn"');
		?></div>
	</div>
</div><div class="row-fluid">
	<div class="span12"><?php
	if(!empty($category)):
		?><ol class="sortable"><?php
			recursive($category);
		?></ol><?php
	endif;
	?></div>
</div><div class="row-fluid">
	<div class="span12" style="margin-top:10px"><?php
	echo form_open('/admincp/category/save',array('class'=>'form-horizontal'));
	?><div class="control-group">
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
	</div><div class="control-group"><div class="controls"><?php
	echo '<input type="hidden" name="category" value="" id="categoryInput" />';
	echo form_submit('save','Save','class="btn btn-info" id="save" disabled');
	echo form_close();
	?></div></div></div>
</div>
<script type="text/javascript">
	function confirmE(){
		return 'Chủng loại của bạn chưa save, bạn có chắc muốn thoát ?';
	}
	$('ol.sortable').nestedSortable({
			forcePlaceholderSize: true,
			handle: 'div',helper:	'clone',items: 'li',
			opacity: .6,
			placeholder: 'placeholder',
			revert: 250,tabSize: 25,
			tolerance: 'pointer',
			toleranceElement: '> div',
			maxLevels: 2,

			isTree: true,expandOnHover: 700,
			startCollapsed: true,
			stop:function(){
				$('#save').removeAttr('disabled');
				window.onbeforeunload = confirmE;
			}
		});
	$('.disclose').on('click', function() {
			$(this).closest('li').toggleClass('mjs-nestedSortable-collapsed').toggleClass('mjs-nestedSortable-expanded');
	});
	$('#save').click(function(){
		window.onbeforeunload = null;
		var val =  $('ol.sortable').nestedSortable('toArray', {startDepthCount: 0});
		$('#categoryInput').val(JSON.stringify(val));
	});
</script>