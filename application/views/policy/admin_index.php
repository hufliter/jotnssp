<?php
?><div class="row-fluid">
	<div class="span12 round" style="position:relative">
		<ul class="breadcrumb well well-small">
			<li class="active">Chính Sách</li>
		</ul><div class="span2" style="position:absolute;top:5px;right:5px"><?php
			echo anchor('/admincp/policy/add/','Thêm Mới Chính Sách','class="btn btn-info addBtn"');
		?></div>
	</div>
</div><div class="row-fluid">
	<table class="table table-hover table-striped">
		<thead><tr>
			<th>Stt</th>
			<th>Tên Chính Sách</th>
			<th>Link</th>
			<th>Trạng Thái</th>
			<th>Chức năng</th>
		</tr>
		</thead>
			<tbody>
			<?php
			if(!empty($pagination)):
				foreach($pagination as $v):
			?>
			<tr>
				<td><?php echo $v->id; ?></td>
				<td><?php echo html_escape($v->name); ?></td>
				<td><?php echo html_escape($v->link); ?></td>
				<td><?php echo html_escape($v->status); ?></td>
				<td><?php echo anchor(
						'/admincp/policy/delete/' . $v->id,
						img('/assets/images/back/delete.png'),
						'class="deleteBtn" title="Xóa Chính Sách"'
					).' '.anchor(
						'/admincp/policy/edit/' . $v->id,
						img('/assets/images/back/edit.png'),
						'class="editBtn" title="Sửa Chính Sách"'
					);
				?></td><?php
				endforeach;
			?></tr><?php
			else:
			?><tr><td colspan="5">Không có chính sách nào</td></tr><?php
			endif;
		?></tbody><tfoot>
			<tr><td colspan="5"><?php
				echo $pagination_link;
			?></td></tr>
		</tfoot>
	</table>
</div><div class="modal hide fade" id="modal">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h3>Chính Sách</h3>		
	</div><div class="modal-body">
	</div><div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal" aria-hidden="true">Đóng</a>
	</div>
</div>
<script type="text/javascript">
(function(){
	modalDiv = $('#modal');
	function actionForm(x,text){
		modalDiv.find('div.modal-header h3').text(text);
		modalDiv.find('div.modal-body').load($(x).attr('href'));
		modalDiv.modal('show');
	}

	$('.addBtn').click(function(){
		actionForm(this,'Thêm Chính sách');
		return false;
	});

	$('.deleteBtn').click(function(){
		if(confirm('Are you sure'))
			actionForm(this,'Xóa Chính Sách');
		return false;
	});

	$('.editBtn').click(function(){
		actionForm(this,'Sửa Chính Sách');
		return false;
	});
})(jQuery);
</script>