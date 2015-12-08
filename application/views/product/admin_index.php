<?php
$c = new common_helper($this, $sort_link);
?>
<div class="row-fluid">
    <div class="span12 round" style="position:relative">
        <ul class="breadcrumb well well-small">
            <li class="active">Sản phẩm</li>
        </ul>
        <div class="span4" style="position:absolute;top:5px;right:5px"><?php
            echo form_open('/admincp/product/search', 'method="get" class="navbar-form pull-left"');
            echo form_input(array(
                'name' => 'q', 'value' => $this->input->get('q'), 'class' => 'search-query span10',
                'placeholder' => 'Tìm sản phẩm', 'style' => 'margin-top:0'
            ));
            echo form_close();
            echo anchor('/admincp/product/add/', 'Thêm sản phẩm', 'class="btn btn-info addBtn"');
            ?></div>
    </div>
</div>
<div class="row-fluid">
    <table class="table table-hover table-striped" id="product-datatable">
        <thead>
        <tr>
            <th><?php $c->sortRow('stt', '#'); ?></th>
            <th><?php $c->sortRow('ten', 'Tên sản phẩm'); ?></th>
            <th><?php $c->sortRow('category', 'Tên chủng loại'); ?></th>
            <th><?php $c->sortRow('gia', 'Giá'); ?></th>
            <th><?php $c->sortRow('view', 'Lượt xem'); ?></th>
            <th><?php $c->sortRow('ngay', 'Ngày'); ?></th>
            <th><?= $c->sortRow('available', 'Còn hàng') ?></th>
            <th>Chức năng</th>
        </tr>
        </thead>
        <tbody><?php
        if (!empty($pagination)):
            foreach ($pagination as $v):
                ?><tr class="<?php echo ($v->status) ? null : 'error'; ?>">
                <td><?php echo $v->id; ?></td>
                <td><span class="tooltips" data-toggle="tooltip" data-placement="right"
                          title="<img src='<?php echo $v->thumb; ?>' alt='' width='100' height='70' />"><?php
                        echo html_escape($v->name);
                        ?></span></td>
                <td><?php echo anchor('/admincp/product/neighbour/' . $v->cid, html_escape($v->category)); ?></td>
                <td><code class="price"><?php echo html_escape(round($v->price)); ?>K</code></td>
                <td><?php echo html_escape($v->view); ?></td>
                <td><?php echo date('Y-m-d H:i', strtotime($v->date)); ?></td>
                <td class="product-available" data-id="<?= $v->id ?>" title="Click để thay đổi trạng thái">
                    <?php if ($v->available): ?>
                        <i class="fa fa-check available"></i>
                    <?php else: ?>
                        <i class="fa fa-times unavailable"></i>
                    <?php endif; ?>
                </td>
                <td><?php echo anchor(
                    '/admincp/product/delete/' . $v->id,
                    img('/assets/images/back/delete.png'),
                    'class="deleteBtn" title="Xóa sản phẩm"'
                ) . ' ' . anchor(
                    '/admincp/product/edit/' . $v->id,
                    img('/assets/images/back/edit.png'),
                    'class="editBtn" title="Sửa sản phẩm"'
                );
                ?></td><?php
            endforeach;
            ?></tr><?php
        else:
            ?>
            <tr>
                <td colspan="7">Không có sản phẩm nào</td>
            </tr><?php
        endif;
        ?></tbody>
        <tfoot>
        <tr>
            <td colspan="7"><?php
                echo $pagination_link;
                ?></td>
        </tr>
        </tfoot>
    </table>
</div>
<div class="modal hide fade" id="modal">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>Sản phẩm</h3>
    </div>
    <div class="modal-body">
    </div>
    <div class="modal-footer">
        <a href="#" class="btn" data-dismiss="modal" aria-hidden="true">Đóng</a>
    </div>
</div>
<script type="text/javascript">
    (function () {
        var modalDiv = $('#modal');
        function actionForm(x, text) {
            modalDiv.find('div.modal-header h3').text(text);
            modalDiv.find('div.modal-body').load($(x).attr('href'));
            modalDiv.modal('show');
        }

        $('.tooltips').tooltip({
            html: '<span></span>'
        });

        $('.addBtn').click(function () {
            actionForm(this, 'Thêm sản phẩm');
            return false;
        });

        $('.deleteBtn').click(function () {
            if (confirm('Are you sure'))
                actionForm(this, 'Xóa sản phẩm');
            return false;
        });

        $('.editBtn').click(function () {
            actionForm(this, 'Sửa sản phẩm');
            return false;
        });
    })(jQuery);
</script>