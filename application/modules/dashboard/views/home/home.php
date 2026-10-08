<!--<li><a href="<?php echo base_url('dashboard/backup_restore'); ?>">Backup & Restore</a></li>-->
<link href="<?php echo base_url('application/modules/dashboard/assest/css/home_dashboard.css?v=1.1'); ?>"
    rel="stylesheet" type="text/css" />
<link
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet" />

<?php if (!empty($saas_pending_updates) && $saas_pending_updates > 0): ?>
<div style="background:#fffbeb;border:1px solid #fcd34d;border-radius:10px;padding:12px 20px;margin-bottom:18px;display:flex;align-items:center;justify-content:space-between;gap:12px;">
    <div style="display:flex;align-items:center;gap:10px;">
        <i class="fa fa-cloud-download" style="color:#d97706;font-size:18px;"></i>
        <span style="font-size:14px;color:#92400e;font-weight:500;">
            <strong><?php echo $saas_pending_updates; ?> mise<?php echo $saas_pending_updates > 1 ? 's' : ''; ?> à jour</strong>
            de la plateforme Bonresto disponible<?php echo $saas_pending_updates > 1 ? 's' : ''; ?>.
        </span>
    </div>
    <a href="<?php echo base_url('dashboard/autoupdate'); ?>"
       style="background:#37a000;color:#fff;border-radius:7px;padding:7px 16px;font-size:13px;font-weight:600;text-decoration:none;white-space:nowrap;">
        Voir &amp; Appliquer
    </a>
</div>
<?php endif; ?>

<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-2 mt-10">
        <div class="panel home-panel-bd bg-alice-blue rounded-15 d-flex align-items-center justify-content-center">
            <div class="panel-body">
                <div class="statistic-box text-center text-white">
                    <h2><span class="count-number text-inverse fs-24"><?php echo $totalorder ?? 0; ?></span> <span
                            class="slight"> </span></h2>
                    <div class="lifeord text-orange"><?php echo display('lifeord') ?></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-2 mt-10">
        <div class="panel home-panel-bd bg-alice-blue rounded-15 d-flex align-items-center justify-content-center">
            <div class="panel-body">
                <div class="statistic-box text-center text-white">
                    <h2><span class="count-number text-inverse fs-24"><?php echo $todayorder ?? 0; ?></span> <span
                            class="slight"> </span></h2>
                    <div class="lifeord text-red"><?php echo display('tdayorder') ?></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-2 mt-10">
        <div class="panel home-panel-bd bg-alice-blue rounded-15 d-flex align-items-center justify-content-center">
            <div class="panel-body">
                <div class="statistic-box text-center text-white">
                    <h2><span class="count-number text-inverse fs-24"><?php echo $todayamount ?? 0; ?></span></h2>
                    <div class="lifeord text-green"><?php echo display('tdaysell') ?></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-2 mt-10">
        <div class="panel home-panel-bd bg-alice-blue rounded-15 d-flex align-items-center justify-content-center">
            <div class="panel-body">
                <div class="statistic-box text-center text-white">
                    <h2><span class="count-number text-inverse fs-24"><?php echo $totalcustomer ?? 0; ?></span> <span
                            class="slight"> </span></h2>
                    <div class="lifeord text-violet"><?php echo display('tcustomer') ?></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-2 mt-10">
        <div class="panel home-panel-bd bg-alice-blue rounded-15 d-flex align-items-center justify-content-center">
            <div class="panel-body">
                <div class="statistic-box text-center text-white">
                    <h2><span class="count-number text-inverse fs-24"><?php echo $completeord ?? 0; ?></span></h2>
                    <div class="lifeord text-info"><?php echo display('tdeliv') ?></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-2 mt-10">
        <div class="panel home-panel-bd bg-alice-blue rounded-15 d-flex align-items-center justify-content-center">
            <div class="panel-body">
                <div class="statistic-box text-center text-white">
                    <h2><span class="count-number text-inverse fs-24"><?php echo $totalreservation ?? 0; ?></span> <span
                            class="slight"> </span></h2>
                    <div class="lifeord text-orange"><?php echo display('treserv') ?></div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if (!empty($group_info)): ?>
<div class="row">
    <div class="col-sm-12 col-md-12">
        <div style="background:linear-gradient(135deg,#eff6ff,#dbeafe);border:1px solid #bfdbfe;border-radius:12px;padding:20px 24px;margin-bottom:18px;">
            <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;margin-bottom:16px;">
                <div style="display:flex;align-items:center;gap:12px;">
                    <div style="width:44px;height:44px;border-radius:10px;background:linear-gradient(135deg,#2563eb,#1d4ed8);color:#fff;display:flex;align-items:center;justify-content:center;font-size:18px;font-weight:700;">
                        <?php echo strtoupper(substr($group_info['group_name'], 0, 2)); ?>
                    </div>
                    <div>
                        <div style="font-size:16px;font-weight:700;color:#1e3a8a;"><?php echo htmlspecialchars($group_info['group_name']); ?></div>
                        <div style="font-size:12px;color:#3b82f6;font-weight:500;"><?php echo $group_info['outlet_count']; ?> restaurant<?php echo $group_info['outlet_count'] > 1 ? 's' : ''; ?> dans ce groupe</div>
                    </div>
                </div>
            </div>
            <div style="display:flex;gap:10px;flex-wrap:wrap;">
                <?php foreach ($group_info['outlets'] as $outlet): ?>
                <?php
                    $is_current = ((int)$outlet['tenant_id'] === (int)$group_info['current_tenant_id']);
                    $is_primary = !empty($outlet['is_primary']);
                    $host = $_SERVER['HTTP_HOST'] ?? '';
                    $is_localhost = (strpos($host, 'localhost') !== false || strpos($host, '127.0.0.1') !== false);
                    $url = '';
                    if (!$is_current && !$is_localhost) {
                        if (!empty($outlet['custom_domain'])) {
                            $url = 'https://' . $outlet['custom_domain'] . '/dashboard/home';
                        } elseif (!empty($outlet['slug'])) {
                            $parts = explode('.', $host);
                            $domain = count($parts) >= 3 ? implode('.', array_slice($parts, 1)) : implode('.', $parts);
                            $url = (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $outlet['slug'] . '.' . $domain . '/dashboard/home';
                        }
                    }
                ?>
                <div style="background:<?php echo $is_current ? '#fff' : '#f0f9ff'; ?>;border:<?php echo $is_current ? '2px solid #2563eb' : '1px solid #bfdbfe'; ?>;border-radius:10px;padding:12px 16px;min-width:180px;flex:1;max-width:280px;<?php echo $is_current ? 'box-shadow:0 2px 8px rgba(37,99,235,.15);' : ''; ?>">
                    <div style="display:flex;align-items:center;gap:6px;margin-bottom:4px;">
                        <?php if ($is_current): ?>
                            <span style="width:8px;height:8px;border-radius:50%;background:#22c55e;display:inline-block;"></span>
                        <?php endif; ?>
                        <span style="font-size:13px;font-weight:<?php echo $is_current ? '700' : '600'; ?>;color:#1e3a8a;">
                            <?php echo htmlspecialchars($outlet['business_name']); ?>
                        </span>
                        <?php if ($is_primary): ?>
                            <i class="fa fa-star" style="color:#f59e0b;font-size:11px;" title="Siege"></i>
                        <?php endif; ?>
                    </div>
                    <div style="font-size:11px;color:#64748b;">
                        <?php echo htmlspecialchars($outlet['city'] ?? ''); ?><?php echo !empty($outlet['country']) ? ', ' . htmlspecialchars($outlet['country']) : ''; ?>
                    </div>
                    <?php if ($is_current): ?>
                        <div style="font-size:10px;color:#2563eb;font-weight:600;margin-top:4px;">
                            <i class="fa fa-check-circle"></i> Vous etes ici
                        </div>
                    <?php elseif ($url): ?>
                        <a href="<?php echo $url; ?>" style="font-size:10px;color:#2563eb;font-weight:600;margin-top:4px;display:inline-block;text-decoration:none;">
                            <i class="fa fa-external-link"></i> Ouvrir
                        </a>
                    <?php elseif (!$is_current && $is_localhost): ?>
                        <div style="font-size:10px;color:#94a3b8;font-style:italic;margin-top:4px;">
                            <i class="fa fa-link"></i> <?php echo htmlspecialchars($outlet['slug'] ?? ''); ?>.bonresto.com
                        </div>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php if (!empty($low_stock_count) && $low_stock_count > 0): ?>
<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-bd shadow-1 border-none rounded-10">
            <div class="panel-body">
                <div class="bg-soft-danger p-12 rounded-10 mb-13" style="background:#ffe0e0;">
                    <h4 class="m-0 fw-600" style="color:#c0392b;">
                        <i class="fa fa-exclamation-triangle"></i>
                        <?php echo display('stock_alert') ?? 'Stock Alert'; ?>
                        <span class="label label-danger" style="font-size:14px;margin-left:8px;"><?php echo $low_stock_count; ?></span>
                    </h4>
                </div>
                <div class="message_inner1">
                    <div class="message_widgets">
                        <table class="table table-striped table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th><?php echo display('ingredient_name') ?? 'Ingredient'; ?></th>
                                    <th><?php echo display('current_stock') ?? 'Current Stock'; ?></th>
                                    <th><?php echo display('stock_limit') ?? 'Min Stock'; ?></th>
                                    <th><?php echo display('unit') ?? 'Unit'; ?></th>
                                    <th><?php echo display('status') ?? 'Status'; ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($low_stock_items as $item): ?>
                                <tr>
                                    <td><strong><?php echo html_escape($item->ingredient_name); ?></strong></td>
                                    <td style="color:<?php echo ($item->stock_qty <= 0) ? '#c0392b' : '#e67e22'; ?>; font-weight:600;">
                                        <?php echo number_format($item->stock_qty, 2); ?>
                                    </td>
                                    <td><?php echo number_format($item->min_stock, 2); ?></td>
                                    <td><?php echo html_escape($item->unit ?? ''); ?></td>
                                    <td>
                                        <?php if ($item->stock_qty <= 0): ?>
                                            <span class="label label-danger">Rupture</span>
                                        <?php else: ?>
                                            <span class="label label-warning">Bas</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <?php if ($low_stock_count > 10): ?>
                        <div class="text-center mt-10">
                            <a href="<?php echo base_url('purchase/purchase/stock_out_ingredients'); ?>" class="btn btn-sm btn-warning">
                                <?php echo display('view_all') ?? 'View All'; ?> (<?php echo $low_stock_count; ?>)
                            </a>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<div class="row">

    <!-- Latest Order new -->
    <div class="col-sm-12 col-md-6">
        <div class="panel panel-bd shadow-1 border-none rounded-10">
            <div class="panel-body">
                <div class="bg-soft-green p-12 rounded-10 mb-13">
                    <h4 class="m-0 fw-600"><?php echo display('latestord') ?></h4>
                </div>
                <div class="message_inner1">
                    <div class="message_widgets">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th><?php echo display('name') ?></th>
                                    <th><?php echo display('phone') ?></th>
                                    <th><?php echo display('ord_number') ?></th>
                                    <th><?php echo display('tabltno') ?></th>
                                    <th><?php echo display('time') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                if (!empty($latestoreder)) {

                                    foreach ($latestoreder as $order) {
                                ?>
                                        <tr>
                                            <td><?php echo $order->customer_name; ?></td>
                                            <td><?php echo $order->customer_phone; ?></td>
                                            <td class="text-green"><a
                                                    href="<?php echo base_url() ?>ordermanage/order/orderdetails/<?php echo $order->order_id; ?>">(<?php echo $order->saleinvoice; ?>)</a>
                                            </td>
                                            <td><?php echo $order->tablename; ?></td>
                                            <td><?php echo $order->order_time; ?></td>
                                        </tr>
                                <?php
                                    }
                                }

                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- Pending Order (adapted to Latest Online Order style) -->
<div class="col-sm-12 col-md-6">
    <div class="panel panel-bd shadow-1 border-none rounded-10">
        <div class="panel-body">
            <div class="bg-soft-warning p-12 rounded-10 mb-13">
                <h4 class="m-0 fw-600"><?php echo display('pending_ord'); ?></h4>
            </div>

            <div class="message_inner1">
                <div class="message_widgets">
                    <table class="table table-striped table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th><?php echo display('name'); ?></th>
                                <th><?php echo display('phone'); ?></th>
                                <th><?php echo display('ord_number'); ?></th>
                                <th><?php echo display('tabltno'); ?></th>
                                <th><?php echo display('time'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($latestpending)) { ?>
                                <?php foreach ($latestpending as $order) { ?>
                                    <tr>
                                        <td><strong><?php echo html_escape($order->customer_name); ?></strong></td>
                                        <td><?php echo html_escape($order->customer_phone); ?></td>
                                        <td>
                                            <a href="<?php echo base_url('ordermanage/order/orderdetails/' . $order->order_id); ?>"
                                               class="text-primary fw-bold">
                                                (<?php echo html_escape($order->saleinvoice); ?>)
                                            </a>
                                        </td>
                                        <td><?php echo html_escape($order->tablename); ?></td>
                                        <td><?php echo html_escape($order->order_time); ?></td>
                                    </tr>
                                <?php } ?>
                            <?php } else { ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-3">
                                        <?php echo display('no_pending_order_found'); ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

   <!-- Latest Reservation (adapted to Latest Online Order style) -->
<div class="col-sm-12 col-md-6">
    <div class="panel panel-bd shadow-1 border-none rounded-10">
        <div class="panel-body">
            <div class="bg-soft-warning p-12 rounded-10 mb-13">
                <h4 class="m-0 fw-600"><?php echo display('latest_reser'); ?></h4>
            </div>

            <div class="message_inner1">
                <div class="message_widgets">
                    <table class="table table-striped table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th><?php echo display('name'); ?></th>
                                <th><?php echo display('phone'); ?></th>
                                <th><?php echo display('date'); ?></th>
                                <th><?php echo display('tabltno'); ?></th>
                                <th><?php echo display('time'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($latestreservation)) { ?>
                                <?php foreach ($latestreservation as $order) { ?>
                                    <tr>
                                        <td><?php echo html_escape($order->customer_name); ?></td>
                                        <td><?php echo html_escape($order->customer_phone); ?></td>
                                        <td>
                                            <a href="<?php echo base_url('reservation/reservation/index'); ?>"
                                               class="text-primary fw-bold">
                                                (<?php echo html_escape($order->reserveday); ?>)
                                            </a>
                                        </td>
                                        <td><?php echo html_escape($order->tablename); ?></td>
                                        <td><?php echo html_escape($order->formtime); ?></td>
                                    </tr>
                                <?php } ?>
                            <?php } else { ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-3">
                                        <?php echo display('no_reservation_found'); ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- Online Order new-->
    <div class="col-sm-12 col-md-6">
        <div class="panel panel-bd shadow-1 border-none rounded-10">
            <div class="panel-body">
                <div class="bg-soft-warning p-12 rounded-10 mb-13">
                    <h4 class="m-0 fw-600">Latest Online Order</h4>
                </div>
                <div class="message_inner1">
                    <div class="message_widgets">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th><?php echo display('name') ?></th>
                                    <th><?php echo display('phone') ?></th>
                                    <th><?php echo display('ord_number') ?></th>
                                    <th><?php echo display('tabltno') ?></th>
                                    <th><?php echo display('time') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                if (!empty($onlineorder)) {

                                    foreach ($onlineorder as $order) {
                                ?>
                                        <tr>
                                            <td><?php echo $order->customer_name; ?></td>
                                            <td><?php echo $order->customer_phone; ?></td>
                                            <td><a
                                                    href="<?php echo base_url() ?>ordermanage/order/orderdetails/<?php echo $order->order_id; ?>">(<?php echo $order->saleinvoice; ?>)</a>
                                            </td>
                                            <td><?php echo $order->tablename; ?></td>
                                            <td><?php echo $order->order_time; ?></td>
                                        </tr>
                                <?php
                                    }
                                }

                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="row">
    <!-- Online Vs Offline Order and sales -->
    <div class="col-sm-12 col-md-6">
        <div class="panel panel-bd shadow-1 border-none rounded-10 p-15">
            <div class="bg-soft-green d-flex align-center justify-content-between p-12 rounded-10 mb-13">
                <h4 class="m-0 fw-600"><?php echo display('onlineofline') ?></h4>
                <ul class="nav nav-tabs">
                    <li class="m-0">
                        <select id="datepicker5" class="form-control">
                            <?php
                            $startYear   = 2000;
                            $endYear     = 2100;
                            $currentYear = date('Y');

                            for ($year = $startYear; $year <= $endYear; $year++) {
                            ?>
                                <option <?php

                                        if ($currentYear == $year) {
                                            echo 'selected';
                                        }

                                        ?> value="<?php echo $year; ?>"><?php echo $year; ?></option>
                            <?php
                            }

                            ?>
                        </select>
                    </li>
                </ul>
            </div>
            <div class="panel-body">
                <canvas id="barChart" height="435"></canvas>
            </div>
        </div>
    </div>

    <!-- Purchase -->
   <!-- Sales Report -->
<!-- Purchase -->
    <div class="col-sm-12 col-md-6">
        <div class="panel panel-bd shadow-1 border-none rounded-10 p-15">
            <div class="bg-soft-green d-flex align-center justify-content-between p-12 rounded-10 mb-13">
                <h4 class="m-0 fw-600">Sales Report</h4>
                <ul class="nav nav-tabs">
                    <li class="m-0"><input name="yearmonth" id="datepicker4"
                            class="form-control custom-date-control datepicker3" type="text"
                            placeholder="<?php echo display('month') ?>" value="" readonly="readonly"></li>
                </ul>
            </div>
            <div class="panel-body">
                <canvas id="purchaseChart" height="324"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Top Selling Items new -->
    <div class="col-sm-12 col-md-6">
        <div class="panel panel-bd shadow-1 border-none rounded-10">
            <div class="panel-body">
                <div class="bg-soft-green p-12 rounded-10 mb-13">
                    <h4 class="m-0 fw-600">Top Selling Items</h4>
                </div>
                <div class="top-sell-table">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Food Name</th>
                                <th><?php echo display('varient_name') ?></th>
                                <th><?php echo display('quantity'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            if (!empty($topseller)) {

                                foreach ($topseller as $pitem) { ?>
                                    <tr>
                                        <td><?php echo $pitem->ProductName; ?></td>
                                        <td><?php echo $pitem->variantName; ?></td>
                                        <td><?php echo $pitem->qty; ?></td>
                                    </tr>
                            <?php
                                }
                            }

                            ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Sales Amount and Order -->

    <div class="col-sm-12 col-md-6">
        <div class="panel panel-bd shadow-1 border-none rounded-10 p-15">
            <div class="bg-soft-green d-flex align-center justify-content-between p-12 rounded-10 mb-13">
                <h4 class="m-0 fw-600">Monthly Sales Amount and Order</h4>
                <ul class="nav nav-tabs">
                    <li class="m-0"><input name="yearmonth" id="datepicker3"
                            class="form-control custom-date-control datepicker3" type="text"
                            placeholder="<?php echo display('month') ?>" value="" readonly="readonly"></li>
                </ul>
            </div>
            <div class="panel-body" id="salechart">
                <canvas id="lineChart" height="275"></canvas>
            </div>
        </div>
    </div>
</div>

<input name="monthname" id="monthname" type="hidden" value="<?php echo $monthname; ?>" />
<input name="monthlysaleamount" id="monthlysaleamount" type="hidden" value="<?php echo $monthlysaleamount; ?>" />
<input name="monthlysaleorder" id="monthlysaleorder" type="hidden" value="<?php echo $monthlysaleorder; ?>" />
<input name="onlinesaleamount" id="onlinesaleamount" type="hidden" value="<?php echo $onlinesaleamount; ?>" />
<input name="onlinesaleorder" id="onlinesaleorder" type="hidden" value="<?php echo $onlinesaleorder; ?>" />
<input name="offlinesaleamount" id="offlinesaleamount" type="hidden" value="<?php echo $offlinesaleamount; ?>" />
<input name="offlinesaleorder" id="offlinesaleorder" type="hidden" value="<?php echo $offlinesaleorder; ?>" />
<?php

if (isset($_GET['status'])) { ?>
    <input name="registerclose" id="registerclose" type="hidden" value="<?php echo htmlspecialchars($_GET['status'], ENT_QUOTES, 'UTF-8'); ?>" />
<?php }

?>
<!-- Chart js -->
<script src="<?php echo base_url('assets/js/Chart.min.js') ?>" type="text/javascript"></script>
<script src="<?php echo base_url('dashboard/home/chartjs') ?>" type="text/javascript"></script>
<script src="<?php echo base_url('application/modules/dashboard/assest/js/chartdata.js?v=1.1'); ?>"
    type="text/javascript"></script>
<script>
    $('#testDiv2').slimscroll({
        height: '400px',

    });
</script>
<?php //$this->load->view('include/homescript');
?>