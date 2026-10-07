<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default thumbnail">
            <div class="panel-heading">
                <h4><i class="fa fa-line-chart"></i> <?php echo display('supplier_price_history'); ?></h4>
            </div>
            <div class="panel-body">

                <!-- Ingredient selector -->
                <form method="get" action="<?php echo base_url('purchase/supplier_price_history/index'); ?>" class="form-inline" style="margin-bottom:20px;">
                    <div class="form-group">
                        <label><?php echo display('ingredient_label'); ?> :</label>
                        <select id="ingredient_select" class="form-control" onchange="window.location='<?php echo base_url('purchase/supplier_price_history/index/'); ?>'+this.value">
                            <option value=""><?php echo display('choose_option'); ?></option>
                            <?php foreach ($ingredients as $ing): ?>
                            <option value="<?php echo (int) $ing->id; ?>" <?php echo ($selected_id == $ing->id) ? 'selected' : ''; ?>>
                                <?php echo html_escape($ing->ingredient_name); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </form>

                <?php if (!empty($selected_id) && !empty($history)): ?>

                <!-- Chart -->
                <div style="margin-bottom:30px;">
                    <h5><?php echo display('price_evolution'); ?> — <?php echo $ingredient_name; ?></h5>
                    <canvas id="priceChart" height="80"></canvas>
                </div>

                <!-- Table -->
                <table class="datatable2 table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th><?php echo display('date_label'); ?></th>
                            <th><?php echo display('supplier_label'); ?></th>
                            <th><?php echo display('unit_price'); ?></th>
                            <th><?php echo display('quantity_label'); ?></th>
                            <th><?php echo display('total_label'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($history as $h): ?>
                        <tr>
                            <td><?php echo date('d/m/Y', strtotime($h->purchasedate)); ?></td>
                            <td><?php echo html_escape($h->supName) ?: display('unknown_label'); ?></td>
                            <td><?php echo number_format($h->price, 2); ?> XAF</td>
                            <td><?php echo number_format($h->quantity, 2); ?></td>
                            <td><?php echo number_format($h->totalprice, 2); ?> XAF</td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                <script>
                fetch('<?php echo base_url("purchase/supplier_price_history/chart_data/" . $selected_id); ?>')
                    .then(r => r.json())
                    .then(function(data) {
                        new Chart(document.getElementById('priceChart'), {
                            type: 'line',
                            data: { datasets: data.datasets },
                            options: {
                                responsive: true,
                                scales: {
                                    x: { type: 'category', title: { display: true, text: '<?php echo display('date_label'); ?>' } },
                                    y: { title: { display: true, text: '<?php echo display('price_xaf'); ?>' }, beginAtZero: false }
                                },
                                plugins: {
                                    tooltip: {
                                        callbacks: {
                                            label: function(ctx) {
                                                return ctx.dataset.label + ': ' + ctx.parsed.y.toLocaleString() + ' XAF';
                                            }
                                        }
                                    }
                                }
                            }
                        });
                    });
                </script>

                <?php elseif (!empty($selected_id)): ?>
                <div class="alert alert-info"><?php echo display('no_purchase_history'); ?></div>
                <?php else: ?>
                <div class="alert alert-info"><?php echo display('select_ingredient_history'); ?></div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>
