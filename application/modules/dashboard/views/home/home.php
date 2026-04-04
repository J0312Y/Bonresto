<!--<li><a href="<?php echo base_url('dashboard/backup_restore'); ?>">Backup & Restore</a></li>-->
<link href="<?php echo base_url('application/modules/dashboard/assest/css/home_dashboard.css?v=1.1'); ?>"
    rel="stylesheet" type="text/css" />
<link
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet" />

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
    <input name="registerclose" id="registerclose" type="hidden" value="<?php echo $_GET['status']; ?>" />
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