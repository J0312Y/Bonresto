<div class="row">
    <div class="col-sm-8 col-sm-offset-2">
        <div class="panel panel-default thumbnail">
            <div class="panel-heading">
                <h4><i class="fa fa-sliders"></i> <?php echo display('stock_adjustment'); ?></h4>
            </div>
            <div class="panel-body">
                <form action="<?php echo base_url('purchase/stock_adjustment/save'); ?>" method="post">
                    <div class="form-group">
                        <label><?php echo display('ingredient_label'); ?></label>
                        <select name="ingredient_id" id="adj_ingredient" class="form-control" required>
                            <option value=""><?php echo display('choose_ingredient'); ?></option>
                            <?php foreach ($ingredients as $ing): ?>
                            <option value="<?php echo (int) $ing->id; ?>"
                                data-stock="<?php echo (float) $ing->stock_qty; ?>"
                                <?php echo (!empty($ingredient) && $ingredient->id == $ing->id) ? 'selected' : ''; ?>>
                                <?php echo html_escape($ing->ingredient_name); ?> (stock: <?php echo number_format($ing->stock_qty, 2); ?>)
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label><?php echo display('system_stock'); ?></label>
                        <input type="text" id="current_stock" class="form-control" readonly
                            value="<?php echo !empty($ingredient) ? number_format($ingredient->stock_qty, 2) : ''; ?>">
                    </div>

                    <div class="form-group">
                        <label><?php echo display('actual_quantity'); ?></label>
                        <input type="number" name="actual_qty" class="form-control" step="0.01" min="0" required
                            placeholder="<?php echo display('enter_actual_qty'); ?>">
                    </div>

                    <div class="form-group">
                        <label><?php echo display('reason_label'); ?></label>
                        <select name="reason" class="form-control" required>
                            <option value="count_correction"><?php echo display('reason_counting'); ?></option>
                            <option value="damage"><?php echo display('reason_damage'); ?></option>
                            <option value="theft"><?php echo display('reason_theft'); ?></option>
                            <option value="expired"><?php echo display('reason_expired'); ?></option>
                            <option value="other"><?php echo display('reason_other'); ?></option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label><?php echo display('notes_label'); ?></label>
                        <textarea name="notes" class="form-control" rows="3" placeholder="<?php echo display('additional_details'); ?>"></textarea>
                    </div>

                    <div class="form-group text-right">
                        <a href="<?php echo base_url('purchase/stock_adjustment'); ?>" class="btn btn-default"><?php echo display('cancel_btn'); ?></a>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> <?php echo display('save_adjustment'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    $('#adj_ingredient').on('change', function(){
        var stock = $(this).find(':selected').data('stock');
        $('#current_stock').val(stock !== undefined ? parseFloat(stock).toFixed(2) : '');
    });
});
</script>
