<div class="row">
    <div class="col-sm-12">

        <!-- Filter tabs -->
        <div style="margin-bottom:15px;">
            <a href="?days=7" class="btn btn-<?php echo ($days == 7) ? 'danger' : 'default'; ?> btn-sm">7 <?php echo display('days_label'); ?></a>
            <a href="?days=30" class="btn btn-<?php echo ($days == 30) ? 'warning' : 'default'; ?> btn-sm">30 <?php echo display('days_label'); ?></a>
            <a href="?days=90" class="btn btn-<?php echo ($days == 90) ? 'info' : 'default'; ?> btn-sm">90 <?php echo display('days_label'); ?></a>
        </div>

        <!-- Expired batches -->
        <?php if (!empty($expired)): ?>
        <div class="panel panel-danger">
            <div class="panel-heading">
                <h4 style="color:#fff;"><i class="fa fa-exclamation-circle"></i> <?php echo display('expired_lots'); ?> (<?php echo count($expired); ?>)</h4>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th><?php echo display('ingredient_label'); ?></th>
                            <th><?php echo display('batch_label'); ?></th>
                            <th><?php echo display('qty_remaining'); ?></th>
                            <th><?php echo display('unit_label'); ?></th>
                            <th><?php echo display('expiry_date_col'); ?></th>
                            <th><?php echo display('days_overdue'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($expired as $e): ?>
                        <tr>
                            <td><?php echo html_escape($e->ingredient_name); ?></td>
                            <td><?php echo html_escape($e->batch_number) ?: '—'; ?></td>
                            <td style="font-weight:bold;"><?php echo number_format($e->quantity_remaining, 2); ?></td>
                            <td><?php echo html_escape($e->uom_short_code) ?: '—'; ?></td>
                            <td><?php echo date('d/m/Y', strtotime($e->expiry_date)); ?></td>
                            <td><span class="label label-danger"><?php echo (int) $e->days_overdue; ?> <?php echo display('day_s'); ?></span></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endif; ?>

        <!-- Expiring soon -->
        <div class="panel panel-default thumbnail">
            <div class="panel-heading">
                <h4><i class="fa fa-clock-o"></i> <?php echo display('expiring_in') . ' ' . $days . ' ' . display('next_days'); ?> (<?php echo count($expiring); ?>)</h4>
            </div>
            <div class="panel-body">
                <?php if (!empty($expiring)): ?>
                <table class="datatable2 table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th><?php echo display('ingredient_label'); ?></th>
                            <th><?php echo display('batch_label'); ?></th>
                            <th><?php echo display('qty_remaining'); ?></th>
                            <th><?php echo display('unit_label'); ?></th>
                            <th><?php echo display('unit_cost_label'); ?></th>
                            <th><?php echo display('expiry_date_col'); ?></th>
                            <th><?php echo display('days_remaining'); ?></th>
                            <th><?php echo display('status_label'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($expiring as $e): ?>
                        <tr>
                            <td><?php echo html_escape($e->ingredient_name); ?></td>
                            <td><?php echo html_escape($e->batch_number) ?: '—'; ?></td>
                            <td style="font-weight:bold;"><?php echo number_format($e->quantity_remaining, 2); ?></td>
                            <td><?php echo html_escape($e->uom_short_code) ?: '—'; ?></td>
                            <td><?php echo $e->unit_cost ? number_format($e->unit_cost, 2) . ' XAF' : '—'; ?></td>
                            <td><?php echo date('d/m/Y', strtotime($e->expiry_date)); ?></td>
                            <td><?php echo (int) $e->days_remaining; ?></td>
                            <td>
                                <?php if ($e->days_remaining <= 3): ?>
                                    <span class="label label-danger"><?php echo display('status_critical'); ?></span>
                                <?php elseif ($e->days_remaining <= 7): ?>
                                    <span class="label label-warning"><?php echo display('status_urgent'); ?></span>
                                <?php else: ?>
                                    <span class="label label-info"><?php echo display('status_watch'); ?></span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                <div class="alert alert-success">
                    <i class="fa fa-check-circle"></i> <?php echo display('no_expiring_lots') . ' ' . $days . ' ' . display('next_days') . '.'; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>
