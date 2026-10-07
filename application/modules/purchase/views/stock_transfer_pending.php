<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default thumbnail">
            <div class="panel-heading">
                <h4><i class="fa fa-inbox"></i> <?php echo display('pending_confirmation'); ?></h4>
            </div>
            <div class="panel-body">
                <?php if (!empty($pending)): ?>
                    <?php foreach ($pending as $t): ?>
                    <div class="panel panel-warning" style="margin-bottom:15px;">
                        <div class="panel-heading">
                            <strong>Transfert #<?php echo (int) $t->id; ?></strong> —
                            <?php echo display('from_sender'); ?> <strong><?php echo html_escape($t->from_name); ?></strong> —
                            <?php echo date('d/m/Y H:i', strtotime($t->created_at)); ?>
                            <?php if (!empty($t->notes)): ?>
                                — <em><?php echo html_escape($t->notes); ?></em>
                            <?php endif; ?>
                        </div>
                        <div class="panel-body">
                            <table class="table table-condensed table-bordered">
                                <thead>
                                    <tr>
                                        <th><?php echo display('ingredient_label'); ?></th>
                                        <th><?php echo display('quantity_label'); ?></th>
                                        <th><?php echo display('unit_label'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($t->items as $item): ?>
                                    <tr>
                                        <td><?php echo html_escape($item->ingredient_name); ?></td>
                                        <td style="font-weight:bold;"><?php echo number_format($item->quantity, 2); ?></td>
                                        <td><?php echo html_escape($item->unit) ?: '—'; ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>

                            <div class="text-right">
                                <a href="<?php echo base_url('purchase/stock_transfer/reject/' . $t->id); ?>"
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('<?php echo display('reject_confirm'); ?>');">
                                    <i class="fa fa-times"></i> <?php echo display('reject_btn'); ?>
                                </a>
                                <a href="<?php echo base_url('purchase/stock_transfer/confirm/' . $t->id); ?>"
                                   class="btn btn-success btn-sm"
                                   onclick="return confirm('<?php echo display('confirm_reception_q'); ?>');">
                                    <i class="fa fa-check"></i> <?php echo display('confirm_reception'); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                <div class="alert alert-info">
                    <i class="fa fa-check-circle"></i> <?php echo display('no_pending_transfer'); ?>
                </div>
                <?php endif; ?>

                <a href="<?php echo base_url('purchase/stock_transfer'); ?>" class="btn btn-default">
                    <i class="fa fa-arrow-left"></i> <?php echo display('back_btn'); ?>
                </a>
            </div>
        </div>
    </div>
</div>
