<div class="form-group text-right">
    <?php if($this->permission->method('purchase','update')->access()): ?>
    <a href="<?php echo base_url('purchase/stock_adjustment/create'); ?>" class="btn btn-primary btn-md">
        <i class="fa fa-plus-circle"></i> <?php echo display('individual_adjustment'); ?>
    </a>
    <a href="<?php echo base_url('purchase/stock_adjustment/bulk'); ?>" class="btn btn-success btn-md">
        <i class="fa fa-clipboard"></i> <?php echo display('physical_inventory'); ?>
    </a>
    <?php endif; ?>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default thumbnail">
            <div class="panel-heading">
                <h4><i class="fa fa-history"></i> <?php echo display('adjustment_history'); ?></h4>
            </div>
            <div class="panel-body">

                <!-- Filters -->
                <form method="get" class="form-inline" style="margin-bottom:15px;">
                    <div class="form-group" style="margin-right:10px;">
                        <label><?php echo display('from_date'); ?></label>
                        <input type="date" name="date_from" class="form-control input-sm" value="<?php echo html_escape($filters['date_from']); ?>">
                    </div>
                    <div class="form-group" style="margin-right:10px;">
                        <label><?php echo display('to_date'); ?></label>
                        <input type="date" name="date_to" class="form-control input-sm" value="<?php echo html_escape($filters['date_to']); ?>">
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-filter"></i> <?php echo display('filter_btn'); ?></button>
                    <a href="<?php echo base_url('purchase/stock_adjustment'); ?>" class="btn btn-default btn-sm">Reset</a>
                </form>

                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th><?php echo display('date_label'); ?></th>
                            <th><?php echo display('ingredient_label'); ?></th>
                            <th><?php echo display('unit_label'); ?></th>
                            <th><?php echo display('qty_adjusted'); ?></th>
                            <th><?php echo display('stock_after'); ?></th>
                            <th><?php echo display('reason_label'); ?></th>
                            <th><?php echo display('notes_label'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($movements)): ?>
                            <?php foreach ($movements as $m): ?>
                            <tr>
                                <td><?php echo date('d/m/Y H:i', strtotime($m['created_at'])); ?></td>
                                <td>
                                    <a href="<?php echo base_url('purchase/stock_history/view/' . $m['ingredient_id']); ?>">
                                        <?php echo html_escape($m['ingredient_name']); ?>
                                    </a>
                                </td>
                                <td><?php echo html_escape($m['uom_short_code']) ?: '—'; ?></td>
                                <td style="color:<?php echo ($m['quantity_change'] >= 0) ? 'green' : 'red'; ?>; font-weight:bold;">
                                    <?php echo ($m['quantity_change'] >= 0 ? '+' : '') . number_format($m['quantity_change'], 2); ?>
                                </td>
                                <td><?php echo number_format($m['quantity_after'], 2); ?></td>
                                <td>
                                    <?php
                                    $reasons = [
                                        'count_correction' => display('reason_counting'),
                                        'damage'           => display('reason_damage'),
                                        'theft'            => display('reason_theft'),
                                        'expired'          => display('reason_expired'),
                                        'other'            => display('reason_other'),
                                    ];
                                    echo isset($reasons[$m['adjustment_reason']]) ? $reasons[$m['adjustment_reason']] : (html_escape($m['adjustment_reason']) ?: '—');
                                    ?>
                                </td>
                                <td><?php echo html_escape($m['notes']) ?: '—'; ?></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="7" class="text-center text-muted"><?php echo display('no_adjustment'); ?></td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
