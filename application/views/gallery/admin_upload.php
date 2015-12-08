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
						'name' => 'userfile[]','value'=>'',
						'id'=>'imgFile','multiple'=>'multiple',
						'accept'=>'image/*'
					));
					echo form_hidden(array(
						'name'=>'ajax','value'=>0,'id'=>'ajax'
					));
				?></div>
			 </div><div class="control-group">
			 	<div class="controls"><?php
			 		echo form_submit('ok','ok','class="btn btn-info"');
			 	?></div></div><?php
		echo form_close();
			?></div>
		</div><div class="row-fluid imageInfo" style="display:none">
			<div class="span8 offset2 form-horizontal">
			<fieldset class="span12">
				<LEGEND>Image Link</LEGEND>
				<div class="row-fluid row-upload"><div class="span12">
					<div class="row-fluid">
						<div class="span3 offset1"><?php
							echo img(array(
								'src'=>'default.png',
								'style'=>'width:164px;height:117px'
							));
						?></div><div class="span8">
							<div class="control-group">
								<label class="control-label" for="thumb">Link thumb</label>
								<div class="controls"><?php
								echo form_input(array(
									'class'=>'thumb_input','name'=>'thumb',
									'autocomplete'=>'off','value'=>'','disabled'=>'disabled'
								));
								?></div>
							</div><div class="control-group">
								<label class="control-label" for="imgSrc">Link image</label>
								<div class="controls"><?php
								echo form_input(array(
									'class'=>'img_input','name'=>'imgSrc',
									'autocomplete'=>'off','value'=>'','disabled'=>'disabled'
								));
								?></div>
							</div>
						</div>
					</div>
				</div></div>
			</fieldset>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
$(function(){
	$('#formUpload').submit(function(e){
		e.preventDefault();
		$.ajaxFileUpload({
			url:'<?php echo base_url(); ?>admincp/gallery/uploadAjax',
			secureuri:false,
			fileElementId:'imgFile',
			dataType:'json',
			success:function(data,status){
				alert(data.msg);
				if(data.status == 'success'){
					$('.row-upload .row-fluid:gt(0)').remove();
					var first_upload = $('.row-upload .row-fluid').eq(0);
					$.each(data.source, function(k,v){
						var new_row = first_upload.clone().appendTo('div.row-upload .span12');
						new_row.find('div.span3 > img').attr('src',v.thumb);
						new_row.find('.img_input').val(v.img);
						new_row.find('.thumb_input').val(v.thumb);
					});
					first_upload.remove();
					$('.imageInfo').show();	
				}
			}
		});
	});
	jQuery.extend({
    handleError: function( s, xhr, status, e ) {
        // If a local callback was specified, fire it
        if ( s.error )
            s.error( xhr, status, e );
    }});
	$('#ajax').val(1);
})
</script>