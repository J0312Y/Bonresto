<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default thumbnail">
            <div class="panel-heading">
                <h4><i class="fa fa-calculator"></i> <?php echo display('recipe_cost'); ?></h4>
                <p class="text-muted" style="margin:5px 0 0;">
                    <?php echo display('food_cost_subtitle'); ?>
                </p>
            </div>
            <div class="panel-body">
                <?php if (!empty($items)): ?>
                <table class="datatable2 table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th></th>
                            <th><?php echo display('dish_label'); ?></th>
                            <th><?php echo display('variant_label'); ?></th>
                            <th><?php echo display('ingredient_cost'); ?></th>
                            <th><?php echo display('selling_price'); ?></th>
                            <th><?php echo display('food_cost_pct'); ?></th>
                            <th><?php echo display('margin_label'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $i => $item): ?>
                        <tr class="food-cost-row" data-target="#detail_<?php echo $i; ?>" style="cursor:pointer;">
                            <td><i class="fa fa-chevron-right fc-arrow"></i></td>
                            <td><strong><?php echo $item->ProductName; ?></strong></td>
                            <td><?php echo $item->variantName ?: '—'; ?></td>
                            <td><?php echo number_format($item->total_cost, 0, ',', ' '); ?> XAF</td>
                            <td><?php echo $item->selling_price ? number_format($item->selling_price, 0, ',', ' ') . ' XAF' : '—'; ?></td>
                            <td>
                                <?php
                                $pct = $item->food_cost_pct;
                                if ($pct == 0) {
                                    $badge = 'label-default';
                                } elseif ($pct < 30) {
                                    $badge = 'label-success';
                                } elseif ($pct <= 35) {
                                    $badge = 'label-warning';
                                } else {
                                    $badge = 'label-danger';
                                }
                                ?>
                                <span class="label <?php echo $badge; ?>" style="font-size:13px;"><?php echo $pct; ?>%</span>
                            </td>
                            <td>
                                <?php if ($item->selling_price > 0): ?>
                                    <?php echo number_format($item->selling_price - $item->total_cost, 0, ',', ' '); ?> XAF
                                <?php else: ?>
                                    —
                                <?php endif; ?>
                            </td>
                        </tr>
                        <!-- Detail row (hidden by default) -->
                        <tr id="detail_<?php echo $i; ?>" class="detail-row" style="display:none; background:#f9f9f9;">
                            <td colspan="7">
                                <table class="table table-condensed" style="margin:0; background:transparent;">
                                    <thead>
                                        <tr>
                                            <th><?php echo display('ingredient_label'); ?></th>
                                            <th><?php echo display('quantity_label'); ?></th>
                                            <th><?php echo display('unit_label'); ?></th>
                                            <th><?php echo display('unit_price'); ?></th>
                                            <th><?php echo display('subtotal_label'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($item->recipe)): ?>
                                        <?php foreach ($item->recipe as $r): ?>
                                        <tr>
                                            <td><?php echo $r->ingredient_name; ?></td>
                                            <td><?php echo number_format($r->qty, 2); ?></td>
                                            <td><?php echo $r->uom_short_code ?: '—'; ?></td>
                                            <td><?php echo number_format($r->unit_price, 2); ?> XAF</td>
                                            <td><strong><?php echo number_format($r->subtotal, 2); ?> XAF</strong></td>
                                        </tr>
                                        <?php endforeach; ?>
                                        <?php else: ?>
                                        <tr><td colspan="5" class="text-muted"><?php echo display('no_recipe_ingredients'); ?></td></tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <script>
                document.querySelectorAll('.food-cost-row').forEach(function(row){
                    row.addEventListener('click', function(){
                        var target = document.querySelector(this.getAttribute('data-target'));
                        var arrow = this.querySelector('.fc-arrow');
                        if (target.style.display === 'none') {
                            target.style.display = '';
                            arrow.className = 'fa fa-chevron-down fc-arrow';
                        } else {
                            target.style.display = 'none';
                            arrow.className = 'fa fa-chevron-right fc-arrow';
                        }
                    });
                });
                </script>

                <?php else: ?>
                <div class="alert alert-info"><?php echo display('no_production_recipe'); ?></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
