<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default thumbnail">
            <div class="panel-heading">
                <h4><i class="fa fa-clipboard"></i> <?php echo display('physical_inventory'); ?></h4>
                <p class="text-muted" style="margin:5px 0 0;"><?php echo display('physical_inventory_subtitle'); ?></p>
            </div>
            <div class="panel-body">

                <!-- Barcode scanner input -->
                <div class="form-group" style="margin-bottom:20px; max-width:400px;">
                    <label><i class="fa fa-barcode"></i> <?php echo display('scan_barcode'); ?></label>
                    <input type="text" id="barcode_scan" class="form-control" placeholder="<?php echo display('scan_placeholder'); ?>" autofocus>
                    <span id="barcode_status" class="help-block"></span>
                </div>

                <form action="<?php echo base_url('purchase/stock_adjustment/save_bulk'); ?>" method="post">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th><?php echo display('ingredient_label'); ?></th>
                                <th><?php echo display('unit_label'); ?></th>
                                <th><?php echo display('system_stock'); ?></th>
                                <th><?php echo display('min_threshold'); ?></th>
                                <th style="width:180px;"><?php echo display('real_quantity'); ?></th>
                                <th><?php echo display('difference_label'); ?></th>
                                <th style="width:200px;"><?php echo display('notes_label'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($ingredients as $ing): ?>
                            <tr>
                                <td>
                                    <?php echo html_escape($ing->ingredient_name); ?>
                                    <input type="hidden" name="ingredient_id[]" value="<?php echo (int) $ing->id; ?>">
                                </td>
                                <td><?php echo html_escape($ing->uom_short_code) ?: '—'; ?></td>
                                <td class="system-stock"><?php echo number_format($ing->stock_qty, 2); ?></td>
                                <td><?php echo number_format($ing->min_stock, 2); ?></td>
                                <td>
                                    <input type="number" name="actual_qty[]" class="form-control input-sm actual-qty"
                                        step="0.01" min="0" data-system="<?php echo (float) $ing->stock_qty; ?>"
                                        placeholder="—">
                                </td>
                                <td class="diff-cell" style="font-weight:bold;">—</td>
                                <td>
                                    <input type="text" name="notes[]" class="form-control input-sm" placeholder="<?php echo display('note_label'); ?>">
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <div class="form-group text-right" style="margin-top:15px;">
                        <a href="<?php echo base_url('purchase/stock_adjustment'); ?>" class="btn btn-default"><?php echo display('cancel_btn'); ?></a>
                        <button type="submit" class="btn btn-success"><i class="fa fa-check-circle"></i> <?php echo display('validate_inventory'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
$js_searching    = display('searching_label');
$js_barcode_not  = display('barcode_not_found');
?>
<script>
var jsSearching   = <?php echo json_encode($js_searching); ?>;
var jsBarcodeNot  = <?php echo json_encode($js_barcode_not); ?>;

document.querySelectorAll('.actual-qty').forEach(function(input) {
    input.addEventListener('input', function() {
        var system = parseFloat(this.getAttribute('data-system')) || 0;
        var actual = parseFloat(this.value);
        var cell = this.closest('tr').querySelector('.diff-cell');
        if (isNaN(actual) || this.value === '') {
            cell.textContent = '—';
            cell.style.color = '';
        } else {
            var diff = actual - system;
            cell.textContent = (diff >= 0 ? '+' : '') + diff.toFixed(2);
            cell.style.color = diff > 0 ? 'green' : (diff < 0 ? 'red' : '');
        }
    });
});

// Barcode scanner: lookup ingredient and scroll to its row
(function(){
    var scanInput = document.getElementById('barcode_scan');
    var statusEl = document.getElementById('barcode_status');
    var timer = null;

    scanInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            doLookup(this.value.trim());
        }
    });

    function doLookup(barcode) {
        if (!barcode) return;
        statusEl.textContent = jsSearching;
        statusEl.style.color = '';

        var xhr = new XMLHttpRequest();
        xhr.open('GET', '<?php echo base_url("purchase/stock_adjustment/barcode_lookup"); ?>?barcode=' + encodeURIComponent(barcode));
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var d = JSON.parse(xhr.responseText);
                if (d.found) {
                    statusEl.textContent = '✓ ' + d.name;
                    statusEl.style.color = 'green';
                    // Find the row with this ingredient ID and scroll to it
                    var hiddens = document.querySelectorAll('input[name="ingredient_id[]"]');
                    for (var i = 0; i < hiddens.length; i++) {
                        if (hiddens[i].value == d.id) {
                            var row = hiddens[i].closest('tr');
                            row.style.backgroundColor = '#ffffcc';
                            row.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            var qtyInput = row.querySelector('.actual-qty');
                            if (qtyInput) qtyInput.focus();
                            setTimeout(function(){ row.style.backgroundColor = ''; }, 3000);
                            break;
                        }
                    }
                } else {
                    statusEl.textContent = '✗ ' + jsBarcodeNot;
                    statusEl.style.color = 'red';
                }
                scanInput.value = '';
                scanInput.focus();
            }
        };
        xhr.send();
    }
})();
</script>
