<?php
/**
 * @var Entity\User $reseller
 * @var array $salaries
 */
?>
    <div class="row-fluid">
        <div class="span12 round">
            <h3>
                Các đơn hàng của CTV <code><?= $reseller->getName(); ?></code>
            </h3>
        </div>
    </div>

    <!-- content -->
    <div class="row-fluid well well-small">
        <table id="table_data" class="display"
               data-ajax-base="<?= base_url() ?>admincp/reseller"
               data-id="<?= $reseller->getId() ?>"
            >
            <thead>
            <tr>
                <td>Mã đơn hàng</td>
                <td>Khách hàng</td>
                <td>Thời gian</td>
                <td>Tổng giá trị</td>
                <td>Controls</td>
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>

    <div class="row-fluid">
        <div class="panel panel-success">
            <div class="panel-heading">Thu nhập</div>
            <div class="panel-body">
                <p>Thông tin thu nhập gần đây (tối đa 6 tháng)</p>

                <table class="table table-hover">
                    <?php foreach ($salaries as $s): ?>
                    <tr>
                        <th><?= $s['time'] ?></th>
                        <td><?= JotunUtils::currencyFormat($s['value']) ?></td>
                        <td>
                            <?php
                            if ($s['paid'] == 1) {
                                echo "<span class=\"paid\"><i class='fa fa-check'></i> Đã thanh toán. </span>";
                            } elseif ($s['paid'] == 0) {
                                echo "<button class='btn btn-success btn-paid' data-time='{$s['time']}' data-id='{$reseller->getId()}'>Đánh dấu đã thanh toán.</button>";
                            } else {
                                echo "<span class=\"unpaid\"><i class='fa fa-times'></i> Chưa đến kỳ thanh toán. </span>";
                            }
                            ?>
                        </td>
                        <td>
                            <?php if ($s['value'] > 0): ?>
                            <button class="btn btn-info btn-detail" data-id="<?= $reseller->getId() ?>" data-time="<?= $s['time'] ?>">Xem chi tiết</button>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>

                    <tr>
                        <td style="text-align: center" colspan="3">...</td>
                    </tr>

                    <tr>
                        <th>Tất cả</th>
                        <td><?= JotunUtils::currencyFormat($reseller->getLifetimeSalary()); ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

<?= $bs_modal ?>