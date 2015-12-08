<div class="row-fluid">
	<div class="span12 round">
		<ul class="breadcrumb well well-small">
			<li><?php echo anchor('/admincp/gallery/','Gallery'); ?> <span class="divider">/</span></li>
			<li class="active">Upload</li>
		</ul>
	</div>
</div><div class="row-fluid">
	<div class="span12 well">
		<div class="row-fluid">
			<div class="span7 offset3"><?php
		echo form_open_multipart(null,array('class'=>'form-horizontal','id'=>'formUpload'));
			?><div class="control-group">
				<label class="control-label" for="img">Hình</label>
				<div class="controls"><?php
					echo form_upload(array(
						'name' => 'userfile','value'=>'',
						'id'=>'imgFile','multiple'=>'multiple',
						'accept'=>'image/*'
					));
					echo form_hidden(array(
						'name'=>'ajax','value'=>0,'id'=>'ajax'
					));
				?></div>
			 </div><?php
		echo form_close();
			?></div>
		</div><div class="row-fluid">
			<div class="span6 offset4" id="uploadControl" style="display:none">
				<button class="btn btn-primary" id="uploadStart" onclick="$('#imgFile').uploadify('upload','*');">Upload</button> 
				<button class="btn btn-danger" id="uploadStop" onclick="$('#imgFile').uploadify('stop');">Stop</button>
			</div>
		</div><div class="row-fluid">
			<div class="span6 offset4" id="imageInfo"></div>
		</div>
	</div>
</div>
<script type="text/javascript">
$(function(){
	<?php $timestamp = time(); ?>
	$('#imgFile').uploadify({
		'formData'     : {
			'timestamp' : '<?php echo $timestamp;?>',
			'token'     : '<?php echo md5('unique_salt' . $timestamp);?>'
		},
		'fileObjName':'userfile','fileTypeDesc':'jpg','auto':false,'removeCompleted':false,'uploadLimit':60,
		'queueID':'imageInfo','cancelImg':'<?php echo base_url(); ?>assets/images/uploadify-cancel.png',
		'swf'      : '<?php echo base_url(); ?>assets/js/uploadify/uploadify.swf',
		'uploader' : '<?php echo base_url(); ?>admincp/gallery/uploadAjax',
		'fileTypeExts'     : '*.jpg;*.gif;*.png;*.jpeg;',
	    'onUploadSuccess' : function(file, data, response) {
			console.log(data);
	    	data = $.parseJSON(data);
			if(data.status == 'success'){
				$('#'+file.id).empty().append('<div class="media span12"><a href="#'+file.id+'" class="pull-left span3"><img class="media-object thumbnail" src="'+data.thumb+'"/></a><div class="media-body controls span8" style="padding-top:33px"><input type="text" class="thumb_input span12" value="'+data.img+'" disabled /></div></div>');
			}
			else 
				$('#'+file.id).empty().append('<div class="media span12"><p>Lỗi, thử lại</p></div>');
	    },
	    'onSelect' : function(){
	    	$('#uploadControl').fadeIn('slow');
	    }
	});
	$('#ajax').val(1);
	$('#imageInfo').on('click','.media a',function(){
		$(this).siblings('div').find('input').select();
	});
});
</script>