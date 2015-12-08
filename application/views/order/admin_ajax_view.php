<div class="modal-header">
	<button type="button" data-dismiss="modal" aria-hidden="true" class="close">X</button>
	<h3 id="modal-header">Đơn hàng #<?php echo (int)$order->id; ?></h3>
</div><div class="modal-body">
	<div class="tabbable tabs-left">
		<ul class="nav nav-tabs">
			<li class="active"><?php
				echo anchor($referrer.'#ajaxInfo','Thông tin','data-toggle="tab"');
			?></li>
			<li><?php
				echo anchor($referrer.'#ajaxProduct','Mặt hàng','data-toggle="tab"');
			?></li>
		</ul><div class="tab-content">
			<div id="ajaxInfo" class="tab-pane active">
				<div class="row-fluid">
					<div class="span4">Tên người nhận:</div>
					<div class="span8"><?php
						echo anchor('/admincp/user/view/'.$order->uid,html_escape($order->name));
					?></div>
				</div><div class="row-fluid">
					<div class="span4">Địa chỉ:</div>
					<div class="span8"><?php
						echo html_escape($order->address);
					?></div>
				</div><div class="row-fluid">
					<div class="span4">Ghi chú:</div>
					<div class="span8"><?php
						echo html_escape($order->note);
					?></div>
				</div><div class="row-fluid">
					<div class="span4">Tổng cộng:</div>
					<div class="span8"><?php
						echo '<b>'.html_escape($order->total).'</b> VNĐ';
					?></div>
				</div><div class="row-fluid">
					<div class="span4">Tình trạng:</div>
					<div class="span8"><?php
						orderStatus($order->status, $orderStatus);
					?></div>
				</div><div class="row-fluid">
					<div class="span4">Ngày đặt:</div>
					<div class="span8"><?php
						echo date('h:i d/m/Y');
					?></div>
				</div>
			</div><div id="ajaxProduct" class="tab-pane">
				<table class="table table-striped table-hover">
					<thead>
						<th>#</th><th>Tên</th><th>Số lượng</th><th>Đơn Giá</th>
					</thead><tbody><?php
					if(!empty($product)):
						foreach($product as $v):
					?>
						<tr>
							<td><?php echo (int)$v->pid; ?></td>
							<td><span class="tooltips" data-toggle="tooltip" data-placement="right" title="<img src='<?php echo $v->thumb; ?>' alt='' width='100' height='70' />"><?php
								echo html_escape($v->name);
							?></span></td>
							<td><?php echo html_escape($v->qty); ?></td>
							<td style="text-align:right"><?php echo html_escape($v->price); ?></td>
						</tr><?php
						endforeach;
						?><tr>
							<td colspan="4" style="text-align:right"><?php echo html_escape($order->total); ?></td>
						</tr><?php
					else:
						?><tr><td colspan="4">Không có mặt hàng nào</td></tr><?php
					endif;
					?></tbody>
				</table>
			</div>
		</div>
	</div>
</div><div class="modal-footer">
	<button class="btn" data-dismiss="modal" aria-hidden="true">Đóng</button>
</div>
<script type="text/javascript">
	$('.tooltips').tooltip({
		html:'<span></span>'
	});
</script>