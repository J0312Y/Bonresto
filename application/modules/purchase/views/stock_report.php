<!-- Summary Cards -->
<div class="row" style="margin-bottom:20px;">
    <div class="col-sm-4">
        <div class="panel panel-default" style="text-align:center; padding:20px;">
            <div style="font-size:28px; font-weight:bold; color:#2ecc71;">
                <?php echo number_format($stock_value, 0, ',', ' '); ?> <small style="font-size:14px;">XAF</small>
            </div>
            <div style="color:#7f8c8d; margin-top:5px;"><?php echo display('total_stock_value'); ?></div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="panel panel-default" style="text-align:center; padding:20px;">
            <div style="font-size:28px; font-weight:bold; color:#3498db;">
                <?php echo $summary['total_ingredients']; ?>
            </div>
            <div style="color:#7f8c8d; margin-top:5px;"><?php echo display('active_ingredients'); ?></div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="panel panel-default" style="text-align:center; padding:20px;">
            <div style="font-size:28px; font-weight:bold; color:<?php echo $summary['below_min'] > 0 ? '#e74c3c' : '#2ecc71'; ?>;">
                <?php echo $summary['below_min']; ?>
            </div>
            <div style="color:#7f8c8d; margin-top:5px;"><?php echo display('below_min_threshold'); ?></div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Top Consumed -->
    <div class="col-sm-6">
        <div class="panel panel-default thumbnail">
            <div class="panel-heading"><h4><i class="fa fa-bar-chart"></i> <?php echo display('top_consumed_month'); ?></h4></div>
            <div class="panel-body">
                <?php if (!empty($top_consumed)): ?>
                <canvas id="topConsumedChart" height="200"></canvas>
                <?php else: ?>
                <p class="text-muted"><?php echo display('no_consumption_month'); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Consumption Chart -->
    <div class="col-sm-6">
        <div class="panel panel-default thumbnail">
            <div class="panel-heading"><h4><i class="fa fa-line-chart"></i> <?php echo display('consumption_30days'); ?></h4></div>
            <div class="panel-body">
                <canvas id="consumptionChart" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Dormant Stock -->
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default thumbnail">
            <div class="panel-heading"><h4><i class="fa fa-archive"></i> <?php echo display('dormant_stock'); ?></h4></div>
            <div class="panel-body">
                <?php if (!empty($dormant)): ?>
                <table class="datatable2 table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th><?php echo display('ingredient_label'); ?></th>
                            <th><?php echo display('current_stock_col'); ?></th>
                            <th><?php echo display('unit_label'); ?></th>
                            <th><?php echo display('last_movement'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($dormant as $d): ?>
                        <tr>
                            <td><?php echo html_escape($d->ingredient_name); ?></td>
                            <td><?php echo number_format($d->stock_qty, 2); ?></td>
                            <td><?php echo html_escape($d->uom_short_code) ?: '—'; ?></td>
                            <td><?php echo $d->last_movement ? date('d/m/Y', strtotime($d->last_movement)) : display('never_label'); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                <p class="text-muted"><?php echo display('all_ingredients_active'); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Top consumed bar chart
<?php if (!empty($top_consumed)): ?>
new Chart(document.getElementById('topConsumedChart'), {
    type: 'bar',
    data: {
        labels: <?php echo json_encode(
            array_map(function ($tc) { return $tc->ingredient_name; }, $top_consumed),
            JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT
        ); ?>,
        datasets: [{
            label: '<?php echo display('qty_consumed'); ?>',
            data: [<?php foreach ($top_consumed as $tc) echo (float) $tc->total_consumed . ','; ?>],
            backgroundColor: '#3498db',
            borderRadius: 4
        }]
    },
    options: {
        responsive: true,
        indexAxis: 'y',
        plugins: { legend: { display: false } },
        scales: { x: { beginAtZero: true } }
    }
});
<?php endif; ?>

// Daily consumption line chart
fetch('<?php echo base_url("purchase/stock_report/chart_data"); ?>')
    .then(function(r){ return r.json(); })
    .then(function(d) {
        if (d.labels.length === 0) {
            document.getElementById('consumptionChart').parentNode.innerHTML = '<p class="text-muted"><?php echo display('no_consumption_data'); ?></p>';
            return;
        }
        new Chart(document.getElementById('consumptionChart'), {
            type: 'line',
            data: {
                labels: d.labels,
                datasets: [{
                    label: '<?php echo display('consumption_label'); ?>',
                    data: d.values,
                    borderColor: '#e74c3c',
                    backgroundColor: 'rgba(231,76,60,0.1)',
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true } }
            }
        });
    });
</script>
