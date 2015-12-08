<style type="text/css">
#feedback { font-size: 1.4em; }
  #select .ui-selecting { border:2px solid #FECA40; }
  #select .ui-selected { border:2px solid #F39814; color: white; }
  #select { list-style-type: none; margin: 0; padding: 0; }
  #select li { margin-top:3px;margin-bottom:3px; padding: 0; float: left; font-size: 4em; text-align: center; border:2px solid #fff;}
</style>
<div class="row-fluid">
	<div class="span12 round">
		<ul class="breadcrumb well well-small">
			<li class="active">Gallery </li>
		</ul>
	</div>
</div><div class="row-fluid">
	<div class="span12 well">
		<fieldset>
			<legend>Danh sách hình ảnh<?php
			echo anchor('/admincp/gallery/upload','Upload image','class="btn btn-info pull-right"');
			?></legend>
			<div class="row-fluid" style="margin-bottom:30px">
			<div class="span12" style="background:white"><?php
		if(!empty($imgs)):
			$i = 1;
			echo form_open('/admincp/gallery/delete',array('id'=>'deleteForm'));
			?><div class="row-fluid"><ol id="select"><?php
			foreach($imgs as $k => $v):
				if($k==0 || ($k-1!=0 && ($k %6 ==0)))
					echo '<div class="row-fluid">';
				?><li data-img="<?php echo $v['url']; ?>" data-thumb="<?php echo strip_tags($v['thumb']); ?>" class="span2 ui-widget-content" style="height:116px"><?php
					echo img(array(
						'src' => $v['thumb'],'class' => 'img-polaroid',
						'alt' => $v['name'],'style' => 'width:150px !important;height:103px'
					));
				?></li><?php
				if(($k+1)%6 == 0 && $k!=0)
					echo '</div>';
			endforeach;
			if(($k+1)%6 != 0)
				echo '</div>';
			?></ol></div><?php
			echo form_hidden('img',0);
			echo form_close();
		endif;
			?></div></div><?php
				echo $pagination_link;
			?>
			<div class="row-fluid">
				<div class="span12 form-horizontal">
					<div class="control-group">
						<label class="control-label span2" for="img" id="img_label">Hình gốc</label>
						<div class="controls"><?php
							echo form_input(array(
								'name'=>'img','value'=>'','disabled'=>'disabled',
								'id'=>'img','autocomplete'=>'off','class'=>'span10'
							));
						?></div>
					</div><div class="control-group">
						<label class="control-label span2" for="thumb" id="thumb_label">Hình đại diện</label>
						<div class="controls"><?php
							echo form_input(array(
								'name'=>'thumb','value'=>'','disabled'=>'disabled',
								'id'=>'thumb','autocomplete'=>'off','class'=>'span10'
							));
						?></div>
					</div><div class="control-group">
						<div class="controls"><?php
							echo anchor('/admincp/gallery/upload','Upload image','class="btn btn-info"');
						?> <button class="btn btn-danger" disabled="disabled" id="deleteBtn" onclick="if(confirm('Are you sure ?')) $('#deleteForm').submit()">Delete image</button>
						</div>
					</div>
				</div>
			</div>
		</fieldset>
	</div>
</div>
<script type="text/javascript">
url = '<?php echo base_url('/admincp/gallery/'); ?>';
$('#select li').selectable({
	filter:'li',
	stop:function(){
		var img  = $('#img').empty();
		ui_selected($(this));
	}
}).zclip({
	path:"<?php echo base_url('/assets/swf/ZeroClipboard.swf'); ?>",
	alertCopy: false,
	copy:function(){
		ui_selected($(this));
		return $(this).attr('data-img');
	},
	afterCopy: function(){}
});

$('#img_label, #thumb_label').click(function(){
	$(this).parent().find('input').select();
});

function ui_selected(x){
	$('.ui-selected').removeClass('ui-selected');
	$(x).addClass('ui-selected');
	$('#img').val(x.attr('data-img')).select();
	$('#thumb').val(x.attr('data-thumb'));
	$('#deleteBtn').removeAttr('disabled');
	$('#deleteForm').attr('action',url+'/delete');
	$('#deleteForm input[name=img]').val(x.find('img').attr('alt'));

	return x;
}
</script>	