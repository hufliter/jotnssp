<div class="row-fluid">
	<div class="span12 round" style="position:relative">
		<ul class="breadcrumb well well-small">
			<li class="active">Quảng cáo</li>
		</ul>
	</div>
</div><div class="row-fluid">
	<table class="table table-hover table-striped">
		<thead>
			<th>#</th><th style="width:130px">Hình</th><th>Vị trí</th><th>Link</th><th>Tình trạng</th><th>Chức năng</th>
		</thead><tbody><?php
		if(!empty($ads)):
			foreach($ads as $k => $v):
			?><tr><td><?php echo $k+1; ?></td>
			<td><?php echo img(array(
				'src'=>$v->img,
				'style'=>'width:120px;height:120px'
			)); ?></td>
			<td><?php echo $position[$v->position]; ?></td>
			<td><?php echo (empty($v->link)?'Không có':'Có'); ?></td>
			<td><?php echo ($v->active?'Bật':'Tắt'); ?></td>
			<td><?php echo anchor(
				'/admincp/dashboard/ads_edit/'.$v->id,
				img('/assets/images/back/edit.png'),
				'class="editBtn" title="Sửa quảng cáo"'
			); ?></td></tr><?php
			endforeach;
		else:
			echo '<td colspan="6">Không có quảng cáo nào</td>';
		endif;
		?></tbody>
	</table>
</div>