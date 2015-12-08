<?php
$this->load->helper('text');
?><div class="row-fluid">
	<div class="span12 round">
		<ul class="breadcrumb well well-small">
			<li class="active">Dashboard</li>
		</ul>
	</div>
</div><div class="row-fluid">
	<div class="span5 well well-small">
		<div class="row-fluid">
			<div class="span12">
				<h4 class="reduce">Tổng quát <hr /></h4>
			</div><div class="span12"><?php
			if(!empty($overview)):
				?><span class="row-fluid">
					<span class="span6">Tổng sản phẩm:</span><span class="text-info span5 text-right"><strong><?php echo (int)$overview['productTotal']; ?></strong></span>
				</span><?php
			else:
				?><span class="row-fluid">
					<span class="text-error"><strong>Lỗi không tìm thấy biến</strong></span>
				</span><?php
			endif;					
			?></div>
		</div>
	</div><div class="span6 offset1 well well-small" style="background:white">
		<div class="row-fluid">
			<ul class="nav nav-tabs" id="dashboardTab">
				<li><a href="#view" data-toggle="tab">Yêu thích</a></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active in" id="view">
					<table class="table table-hover table-striped">
						<thead><tr>
							<th>#</th><th>Tên</th><th>Lượt xem</th>
						</tr></thead>
						<tbody><?php
						if(!empty($popular)):
							foreach($popular as $v):
						?><tr>
							<td><?php echo (int)$v->id; ?></td>
							<td><span class="tooltips" data-toggle="tooltip" data-placement="right" title="<img src='<?php echo $v->thumb; ?>' alt='' width='100' height='70' />"><?php
							 	echo $v->name;
							?></span></td>
							<td><?php echo (int)$v->sale; ?></td>
						</tr><?php
							endforeach;
						endif;
						?></tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
$(function(){
	$('#dashboardTab a:first').tab('show');
})
</script>
<div class="row-fluid">
	<div class="span12 ">
		<h4>Sản phẩm mới</h4><?php
		if(!empty($lastProduct)):
		?><table class="table table-hover table-striped">
			<thead>
				<tr>
					<th class="span1">#</th>
					<th class="span1">Tên</th>
					<th class="span3">Chủng loại</th>
					<th class="span2">Giá</th>
					<th class="span2">Lượt xem</th>
					<th class="span2"></th>
				</tr>
			</thead><tbody><?php
			foreach($lastProduct as $v):
				?><tr>
					<td><?php echo (int)$v->id; ?></td>
					<td><span class="tooltips" data-toggle="tooltip" data-placement="right" title="<img src='<?php echo $v->thumb; ?>' alt='' width='100' height='70' />">
						<?php echo html_escape($v->name); ?>
					</span></td>
					<td><?php echo anchor('/amdincp/user/edit/'.$v->cid,html_escape($v->cat_name)); ?></td>
					<td><?php echo html_escape($v->price); ?> <strong>VND</strong></td>
					<td><?php echo html_escape($v->view); ?> </td>
					<td></td>
				</tr><?php
			endforeach;
			?></tbody><tfoot><tr>
				<td colspan="5" class="span12" style="text-align:center"><?php
					echo anchor('/admincp/product','Xem thêm',array('class'=>'btn btn-info'));
				?></td>
			</tr></tfoot>
		</table><?php
		else:
		?><div>Lỗi không tìm thấy biến, xin liên hệ admin</div><?php
		endif;
	?></div>
</div><div id="modal" class="modal hide fade"></div><div id="modalDo" class="modal hide fade"></div>
<script type="text/javascript">
	function ajaxErr(a,b){
		alert('error'+b);
	};
	$('.tooltips').tooltip({
		html:'<span></span>'
	});
	$('.orderView').click(function(){
		var id = $(this).attr('data-id');

		$.ajax({
			url:"<?php echo base_url(); ?>admincp/order/ajax_view/"+id,
			type:'GET',cache:false,
			error:ajaxErr
		}).done(function(data){
			$('#modal').html(data).modal();
		});

		return false;
	});

	$('.orderAction').click(function(){
		var id = $(this).attr('data-id');

		$.ajax({
			url:"<?php echo base_url(); ?>admincp/order/ajax_do/"+id,
			type:"GET",cache:false,
			error:ajaxErr
		}).done(function(data){
			$('#modalDo').html(data).modal();
		});

		return false;
	});
</script>
