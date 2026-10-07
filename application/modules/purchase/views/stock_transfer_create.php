<div class="row">
    <div class="col-sm-10 col-sm-offset-1">
        <div class="panel panel-default thumbnail">
            <div class="panel-heading">
                <h4><i class="fa fa-exchange"></i> <?php echo display('new_stock_transfer'); ?></h4>
            </div>
            <div class="panel-body">

                <?php if (empty($siblings)): ?>
                <div class="alert alert-warning">
                    <i class="fa fa-info-circle"></i> <?php echo display('no_group_warning'); ?>
                </div>
                <?php else: ?>

                <form action="<?php echo base_url('purchase/stock_transfer/send'); ?>" method="post">
                    <div class="form-group">
                        <label><?php echo display('target_restaurant'); ?></label>
                        <select name="to_tenant_id" class="form-control" required>
                            <option value=""><?php echo display('choose_option'); ?></option>
                            <?php foreach ($siblings as $s): ?>
                            <option value="<?php echo (int) $s->tenant_id; ?>"><?php echo html_escape($s->business_name); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label><?php echo display('notes_label'); ?></label>
                        <input type="text" name="notes" class="form-control" placeholder="<?php echo display('transfer_reason'); ?>">
                    </div>

                    <h5 style="margin-top:20px;"><?php echo display('ingredients_to_transfer'); ?></h5>
                    <table class="table table-striped table-bordered" id="transfer_items">
                        <thead>
                            <tr>
                                <th><?php echo display('ingredient_label'); ?></th>
                                <th><?php echo display('available_stock'); ?></th>
                                <th style="width:150px;"><?php echo display('quantity_label'); ?></th>
                                <th style="width:60px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="transfer-row">
                                <td>
                                    <select name="ingredient_id[]" class="form-control" required>
                                        <option value=""><?php echo display('choose_option'); ?></option>
                                        <?php foreach ($ingredients as $ing): ?>
                                        <option value="<?php echo (int) $ing->id; ?>" data-stock="<?php echo (float) $ing->stock_qty; ?>" data-unit="<?php echo html_escape($ing->uom_short_code); ?>">
                                            <?php echo html_escape($ing->ingredient_name); ?> (<?php echo number_format($ing->stock_qty, 2); ?> <?php echo html_escape($ing->uom_short_code); ?>)
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td class="stock-display">—</td>
                                <td><input type="number" name="quantity[]" class="form-control" step="0.01" min="0.01" required></td>
                                <td><button type="button" class="btn btn-danger btn-sm remove-row"><i class="fa fa-minus"></i></button></td>
                            </tr>
                        </tbody>
                    </table>

                    <button type="button" id="add_row" class="btn btn-default btn-sm" style="margin-bottom:15px;">
                        <i class="fa fa-plus"></i> <?php echo display('add_ingredient'); ?>
                    </button>

                    <div class="form-group text-right">
                        <a href="<?php echo base_url('purchase/stock_transfer'); ?>" class="btn btn-default"><?php echo display('cancel_btn'); ?></a>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane"></i> <?php echo display('send_transfer'); ?></button>
                    </div>
                </form>

                <script>
                // Show stock on ingredient change
                $(document).on('change', 'select[name="ingredient_id[]"]', function(){
                    var opt = $(this).find(':selected');
                    $(this).closest('tr').find('.stock-display').text(
                        opt.data('stock') ? parseFloat(opt.data('stock')).toFixed(2) + ' ' + (opt.data('unit')||'') : '—'
                    );
                });

                // Add row
                $('#add_row').on('click', function(){
                    var row = $('#transfer_items tbody tr:first').clone();
                    row.find('select').val('');
                    row.find('input').val('');
                    row.find('.stock-display').text('—');
                    $('#transfer_items tbody').append(row);
                });

                // Remove row
                $(document).on('click', '.remove-row', function(){
                    if ($('#transfer_items tbody tr').length > 1) {
                        $(this).closest('tr').remove();
                    }
                });
                </script>

                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
