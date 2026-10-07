<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default thumbnail">
            <div class="panel-heading">
                <h4>
                    <?php echo html_escape($ingredient->ingredient_name); ?>
                    <small class="text-muted">
                        — <?php echo display('current_stock'); ?> <strong><?php echo number_format($ingredient->stock_qty, 2); ?></strong>
                        | <?php echo display('min_threshold'); ?> <strong><?php echo number_format($ingredient->min_stock, 2); ?></strong>
                    </small>
                </h4>
            </div>
            <div class="panel-body">

                <!-- Filters -->
                <form method="get" class="form-inline" style="margin-bottom:15px;">
                    <div class="form-group" style="margin-right:10px;">
                        <label><?php echo display('movement_type'); ?></label>
                        <select name="movement_type" class="form-control input-sm">
                            <option value=""><?php echo display('all_option'); ?></option>
                            <?php
                            $types = ['purchase','purchase_return','purchase_update','purchase_delete','production','production_delete','waste_packaging','waste_ingredient','adjustment','order','order_cancel'];
                            foreach ($types as $t):
                            ?>
                            <option value="<?php echo html_escape($t); ?>" <?php echo ($filters['movement_type'] == $t) ? 'selected' : ''; ?>><?php echo html_escape($t); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group" style="margin-right:10px;">
                        <label><?php echo display('from_date'); ?></label>
                        <input type="date" name="date_from" class="form-control input-sm" value="<?php echo html_escape($filters['date_from']); ?>">
                    </div>
                    <div class="form-group" style="margin-right:10px;">
                        <label><?php echo display('to_date'); ?></label>
                        <input type="date" name="date_to" class="form-control input-sm" value="<?php echo html_escape($filters['date_to']); ?>">
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-filter"></i> <?php echo display('filter_btn'); ?></button>
                    <a href="<?php echo base_url('purchase/stock_history/view/' . $ingredient->id); ?>" class="btn btn-default btn-sm">Reset</a>
                </form>

                <p class="text-muted"><?php echo $total; ?> <?php echo display('total_movements'); ?></p>

                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th><?php echo display('date_label'); ?></th>
                            <th><?php echo display('movement_type'); ?></th>
                            <th><?php echo display('qty_change'); ?></th>
                            <th><?php echo display('stock_after'); ?></th>
                            <th><?php echo display('unit_cost_label'); ?></th>
                            <th><?php echo display('reference_label'); ?></th>
                            <th><?php echo display('notes_label'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($movements)): ?>
                            <?php foreach ($movements as $m): ?>
                            <tr>
                                <td><?php echo date('d/m/Y H:i', strtotime($m['created_at'])); ?></td>
                                <td>
                                    <?php
                                    $labels = [
                                        'purchase' => '<span class="label label-success">' . display('mvt_purchase') . '</span>',
                                        'purchase_return' => '<span class="label label-warning">' . display('mvt_purchase_return') . '</span>',
                                        'purchase_update' => '<span class="label label-info">' . display('mvt_purchase_update') . '</span>',
                                        'purchase_delete' => '<span class="label label-danger">' . display('mvt_purchase_delete') . '</span>',
                                        'production' => '<span class="label label-primary">' . display('mvt_production') . '</span>',
                                        'production_delete' => '<span class="label label-danger">' . display('mvt_production_delete') . '</span>',
                                        'waste_packaging' => '<span class="label label-warning">' . display('mvt_waste_packaging') . '</span>',
                                        'waste_ingredient' => '<span class="label label-warning">' . display('mvt_waste_ingredient') . '</span>',
                                        'adjustment' => '<span class="label label-default">' . display('mvt_adjustment') . '</span>',
                                        'order' => '<span class="label label-primary">' . display('mvt_order') . '</span>',
                                        'order_cancel' => '<span class="label label-danger">' . display('mvt_order_cancel') . '</span>',
                                        'transfer_out' => '<span class="label label-warning">' . display('mvt_transfer_out') . '</span>',
                                        'transfer_in' => '<span class="label label-success">' . display('mvt_transfer_in') . '</span>',
                                    ];
                                    echo isset($labels[$m['movement_type']]) ? $labels[$m['movement_type']] : html_escape($m['movement_type']);
                                    ?>
                                </td>
                                <td style="color:<?php echo ($m['quantity_change'] >= 0) ? 'green' : 'red'; ?>; font-weight:bold;">
                                    <?php echo ($m['quantity_change'] >= 0 ? '+' : '') . number_format($m['quantity_change'], 2); ?>
                                </td>
                                <td><?php echo number_format($m['quantity_after'], 2); ?></td>
                                <td><?php echo $m['unit_cost'] ? number_format($m['unit_cost'], 2) . ' XAF' : '—'; ?></td>
                                <td><?php echo $m['reference_type'] ? html_escape($m['reference_type']) . ' #' . (int) $m['reference_id'] : '—'; ?></td>
                                <td><?php echo html_escape($m['notes']) ?: '—'; ?></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="7" class="text-center text-muted"><?php echo display('no_movements'); ?></td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <!-- Simple pagination -->
                <?php if ($total > $filters['limit']): ?>
                <nav>
                    <ul class="pagination">
                        <?php
                        $pages = ceil($total / $filters['limit']);
                        $current = ($filters['offset'] / $filters['limit']) + 1;
                        for ($p = 1; $p <= $pages; $p++):
                            $off = ($p - 1) * $filters['limit'];
                        ?>
                        <li class="<?php echo ($p == $current) ? 'active' : ''; ?>">
                            <a href="?offset=<?php echo (int) $off; ?>&movement_type=<?php echo html_escape(urlencode($filters['movement_type'])); ?>&date_from=<?php echo html_escape(urlencode($filters['date_from'])); ?>&date_to=<?php echo html_escape(urlencode($filters['date_to'])); ?>">
                                <?php echo $p; ?>
                            </a>
                        </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>
