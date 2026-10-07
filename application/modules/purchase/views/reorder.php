<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default thumbnail">
            <div class="panel-heading">
                <h4><i class="fa fa-shopping-basket"></i> <?php echo display('reorder_suggestions'); ?></h4>
                <p class="text-muted" style="margin:5px 0 0;">
                    <?php echo display('reorder_subtitle'); ?>
                </p>
            </div>
            <div class="panel-body">
                <?php if (!empty($items)): ?>
                <form action="<?php echo base_url('purchase/reorder/generate_po'); ?>" method="post">
                    <table class="datatable2 table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th style="width:40px;"><input type="checkbox" id="check_all"></th>
                                <th><?php echo display('ingredient_label'); ?></th>
                                <th><?php echo display('unit_label'); ?></th>
                                <th><?php echo display('current_stock_col'); ?></th>
                                <th><?php echo display('min_threshold'); ?></th>
                                <th><?php echo display('deficit_col'); ?></th>
                                <th><?php echo display('avg_daily_consumption'); ?></th>
                                <th><?php echo display('last_supplier'); ?></th>
                                <th><?php echo display('last_price'); ?></th>
                                <th style="width:120px;"><?php echo display('qty_to_order'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($items as $item): ?>
                            <tr>
                                <td>
                                    <input type="checkbox" name="ingredient_id[]" value="<?php echo (int) $item->id; ?>" class="reorder-check" checked>
                                </td>
                                <td><?php echo html_escape($item->ingredient_name); ?></td>
                                <td><?php echo html_escape($item->uom_short_code) ?: '—'; ?></td>
                                <td style="color:<?php echo ($item->stock_qty <= 0) ? '#c0392b' : '#e67e22'; ?>; font-weight:bold;">
                                    <?php echo number_format($item->stock_qty, 2); ?>
                                </td>
                                <td><?php echo number_format($item->min_stock, 2); ?></td>
                                <td style="color:#c0392b; font-weight:bold;"><?php echo number_format($item->deficit, 2); ?></td>
                                <td><?php echo number_format($item->avg_daily, 2); ?></td>
                                <td><?php echo html_escape($item->last_supplier); ?></td>
                                <td><?php echo $item->last_price > 0 ? number_format($item->last_price, 2) . ' XAF' : '—'; ?></td>
                                <td>
                                    <input type="number" name="order_qty[]" class="form-control input-sm"
                                        value="<?php echo ceil($item->suggested_qty); ?>" step="1" min="1">
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <div class="form-group text-right" style="margin-top:15px;">
                        <button type="submit" class="btn btn-success btn-md">
                            <i class="fa fa-cart-plus"></i> <?php echo display('generate_po'); ?>
                        </button>
                    </div>
                </form>

                <script>
                document.getElementById('check_all').addEventListener('change', function(){
                    document.querySelectorAll('.reorder-check').forEach(function(cb){
                        cb.checked = this.checked;
                    }.bind(this));
                });
                </script>

                <?php else: ?>
                <div class="alert alert-success">
                    <i class="fa fa-check-circle"></i> <?php echo display('all_above_threshold'); ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
