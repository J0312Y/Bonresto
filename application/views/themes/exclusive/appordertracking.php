<?php
$webinfo = $this->webinfo;
$activethemeinfo = $this->themeinfo;
$acthemename = $activethemeinfo->themename;
$headercolor = !empty($webinfo->qrheadercolor) ? $webinfo->qrheadercolor : '#ff6b35';
$headerfontcolor = !empty($webinfo->qrheaderfontcolor) ? $webinfo->qrheaderfontcolor : '#fff';
$bgcolor = !empty($webinfo->backgroundcolorqr) ? $webinfo->backgroundcolorqr : '#fff';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Suivi de commande #<?php echo $order->saleinvoice; ?></title>
    <link rel="shortcut icon" type="image/ico" href="<?php echo base_url((!empty($this->settinginfo->favicon) ? $this->settinginfo->favicon : 'application/views/themes/' . $acthemename . '/assets_web/images/favicon.png')); ?>">
    <script src="<?php echo base_url(); ?>application/views/themes/<?php echo $acthemename; ?>/assets_web/js/jquery-3.3.1.min.js"></script>
    <link href="<?php echo base_url(); ?>application/views/themes/<?php echo $acthemename; ?>/assets_web/plugins/bootstrap-4.1.3-dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>application/views/themes/<?php echo $acthemename; ?>/assets_web/plugins/fontawesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>application/views/themes/<?php echo $acthemename; ?>/assets_web/plugins/themify-icons/themify-icons.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>application/views/themes/<?php echo $acthemename; ?>/assets_web/css/style.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>application/views/themes/<?php echo $acthemename; ?>/assets_web/css/app.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>application/views/themes/<?php echo $acthemename; ?>/assets_web/css/new.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/sweetalert/sweetalert.css" rel="stylesheet">
    <script src="<?php echo base_url(); ?>assets/sweetalert/sweetalert.min.js"></script>
    <style>
        body { background: #f5f5f5; }
        .tracking-container { max-width: 500px; margin: 0 auto; padding: 15px 15px 120px; }

        /* Table badge */
        .table-badge { background: <?php echo $headercolor; ?>; color: <?php echo $headerfontcolor; ?>; padding: 15px 20px; border-radius: 12px; text-align: center; margin-bottom: 20px; box-shadow: 0 3px 10px rgba(0,0,0,.12); }
        .table-badge h3 { margin: 0; font-size: 1.3em; font-weight: 700; }
        .table-badge .badge-invoice { opacity: 0.85; font-size: 0.85em; margin-top: 4px; display: block; }

        /* Tracker */
        .tracker { position: relative; padding: 0; list-style: none; margin: 20px 0; }
        .tracker-step { display: flex; align-items: flex-start; position: relative; }
        .tracker-step .step-icon { width: 44px; height: 44px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 17px; flex-shrink: 0; z-index: 2; border: 3px solid #e0e0e0; background: #fff; color: #ccc; transition: all 0.4s ease; }
        .tracker-step .step-content { padding: 10px 0 28px 14px; }
        .tracker-step .step-content h5 { margin: 0 0 2px; font-size: 0.95em; color: #aaa; font-weight: 600; transition: color 0.4s ease; }
        .tracker-step .step-content p { margin: 0; font-size: 0.8em; color: #ccc; }

        /* Step states */
        .tracker-step.active .step-icon { border-color: <?php echo $headercolor; ?>; background: <?php echo $headercolor; ?>; color: #fff; animation: pulse 2s infinite; }
        .tracker-step.active .step-content h5 { color: #333; }
        .tracker-step.active .step-content p { color: #666; }
        .tracker-step.done .step-icon { border-color: #28a745; background: #28a745; color: #fff; }
        .tracker-step.done .step-content h5 { color: #28a745; }
        .tracker-step.cancelled .step-icon { border-color: #dc3545; background: #dc3545; color: #fff; }
        .tracker-step.cancelled .step-content h5 { color: #dc3545; font-weight: bold; }

        /* Connector line */
        .tracker-step::before { content: ''; position: absolute; left: 21px; top: 44px; width: 2px; height: calc(100% - 44px); background: #e0e0e0; z-index: 1; }
        .tracker-step:last-child::before { display: none; }
        .tracker-step.done::before { background: #28a745; }

        /* Order items card */
        .order-card { background: #fff; border-radius: 12px; padding: 18px; margin: 15px 0; box-shadow: 0 1px 6px rgba(0,0,0,.06); }
        .order-card h5 { margin: 0 0 12px; font-size: 1em; font-weight: 700; color: #333; }
        .order-item { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #f0f0f0; font-size: 0.9em; color: #555; }
        .order-item:last-child { border-bottom: none; }
        .order-item .item-qty { color: <?php echo $headercolor; ?>; font-weight: 600; margin-right: 6px; }
        .order-total { display: flex; justify-content: space-between; padding: 12px 0 0; font-weight: 700; font-size: 1.05em; border-top: 2px solid #eee; margin-top: 8px; color: #333; }

        /* Buttons */
        .btn-addmore { display: block; width: 100%; padding: 14px; border-radius: 12px; font-weight: 700; text-align: center; margin-top: 10px; font-size: 1em; border: 2px solid <?php echo $headercolor; ?>; color: <?php echo $headercolor; ?>; background: #fff; }
        .btn-addmore:hover { background: <?php echo $headercolor; ?>; color: #fff; text-decoration: none; }

        /* Bell dropdown */
        .bell-dropdown { display: none; position: absolute; bottom: 50px; right: 0; background: #fff; border-radius: 10px; box-shadow: 0 4px 20px rgba(0,0,0,.15); min-width: 210px; z-index: 999; overflow: hidden; }
        .bell-dropdown.bell-open { display: block; }
        .bell-dropdown a { display: block; padding: 12px 16px; color: #333; text-decoration: none; font-size: 14px; border-bottom: 1px solid #f5f5f5; }
        .bell-dropdown a:last-child { border-bottom: none; }
        .bell-dropdown a:hover { background: #f8f8f8; }
        .bell-dropdown a i { margin-right: 8px; color: <?php echo $headercolor; ?>; }

        @keyframes pulse { 0% { box-shadow: 0 0 0 0 <?php echo $headercolor; ?>66; } 70% { box-shadow: 0 0 0 12px <?php echo $headercolor; ?>00; } 100% { box-shadow: 0 0 0 0 <?php echo $headercolor; ?>00; } }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header_top_area only-sm">
        <div class="header_top light" style="background:<?php echo $bgcolor; ?>;">
            <div class="container-fluid">
                <nav class="navbar navbar-expand-lg">
                    <div class="sidebar-toggle-btn"></div>
                    <a href="<?php echo base_url('qr-menu'); ?>">
                        <img src="<?php echo base_url(!empty($webinfo->logo) ? $webinfo->logo : 'assets/img/applogo.png'); ?>" alt="logo" style="max-height:40px;">
                    </a>
                    <div class="act-icon">
                        <span style="font-weight:600; color:<?php echo $headerfontcolor; ?>; font-size:0.9em;">
                            <i class="fa fa-map-marker"></i> Suivi
                        </span>
                    </div>
                </nav>
            </div>
        </div>
    </header>

    <div class="tracking-container">
        <!-- Table & Order Info -->
        <div class="table-badge">
            <h3><i class="fa fa-cutlery"></i> <?php echo $tablename; ?></h3>
            <span class="badge-invoice">Commande #<?php echo $order->saleinvoice; ?></span>
        </div>

        <!-- Progress Tracker -->
        <?php
        $status = (int) $order->order_status;
        $steps = [
            1 => ['icon' => 'fa-clock-o',       'title' => 'En attente',       'desc' => 'Votre commande a été reçue'],
            2 => ['icon' => 'fa-fire',           'title' => 'En préparation',   'desc' => 'La cuisine prépare votre commande'],
            3 => ['icon' => 'fa-check-circle',   'title' => 'Prêt',             'desc' => 'Votre commande est prête !'],
            4 => ['icon' => 'fa-cutlery',        'title' => 'Servi',            'desc' => 'Bon appétit !'],
        ];
        ?>

        <?php if ($status == 5) { ?>
            <div class="tracker">
                <div class="tracker-step cancelled">
                    <div class="step-icon"><i class="fa fa-times"></i></div>
                    <div class="step-content">
                        <h5>Commande annulée</h5>
                        <p>Votre commande a été annulée.</p>
                    </div>
                </div>
            </div>
        <?php } else { ?>
            <div class="tracker" id="tracker">
                <?php foreach ($steps as $stepNum => $step) {
                    if ($stepNum < $status) { $cls = 'done'; }
                    elseif ($stepNum == $status) { $cls = 'active'; }
                    else { $cls = ''; }
                ?>
                <div class="tracker-step <?php echo $cls; ?>" data-step="<?php echo $stepNum; ?>">
                    <div class="step-icon"><i class="fa <?php echo $step['icon']; ?>"></i></div>
                    <div class="step-content">
                        <h5><?php echo $step['title']; ?></h5>
                        <p><?php echo $step['desc']; ?></p>
                    </div>
                </div>
                <?php } ?>
            </div>
        <?php } ?>

        <!-- Order Items -->
        <div class="order-card">
            <h5><i class="fa fa-list"></i> Détails de la commande</h5>
            <div id="items-list">
            <?php if (!empty($items)) { foreach ($items as $item) { ?>
                <div class="order-item">
                    <span><span class="item-qty"><?php echo $item->qty; ?>x</span> <?php echo $item->product_name; ?></span>
                    <span><?php echo number_format($item->price * $item->qty, 2); ?></span>
                </div>
            <?php } } ?>
            </div>
            <div class="order-total">
                <span>Total</span>
                <span id="order-total-amount"><?php echo number_format($order->totalamount, 2); ?></span>
            </div>
        </div>

        <!-- Action Buttons -->
        <?php if ($status < 4 && $status != 5) { ?>
        <a href="<?php echo base_url('qr-menu'); ?>" class="btn-addmore">
            <i class="fa fa-plus-circle"></i> Commander plus
        </a>
        <?php } ?>
    </div>

    <!-- Footer Navigation -->
    <?php $totalqty = 0;
    if ($this->cart->contents() > 0) {
        $totalqty = count($this->cart->contents());
    } ?>
    <div class="fixed_area only-sm">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex align-items-center justify-content-around">
                        <div class="icon">
                            <a class="btn btn-transparent" href="<?php echo base_url('qr-menu'); ?>">
                                <i class="ti-home" style="color:<?php echo $headerfontcolor; ?>;"></i>
                            </a>
                        </div>
                        <div class="icon">
                            <a class="btn btn-transparent" href="<?php echo base_url('apporedrlist'); ?>">
                                <i class="ti-pencil-alt" style="color:<?php echo $headerfontcolor; ?>;"></i>
                            </a>
                        </div>
                        <div class="icon">
                            <a class="btn btn-transparent btnposition" href="<?php echo base_url('qr-app-cart'); ?>">
                                <i class="ti-shopping-cart" style="color:<?php echo $headerfontcolor; ?>;"></i>
                                <?php if ($totalqty > 0) { ?>
                                <span class="badgedisplayblock classic-badge2"><?php echo $totalqty; ?></span>
                                <?php } ?>
                            </a>
                        </div>
                        <div class="icon" style="position:relative;">
                            <button class="btn btn-transparent" onclick="document.getElementById('bellMenu').classList.toggle('bell-open');">
                                <i class="ti-bell" style="color:<?php echo $headerfontcolor; ?>;"></i>
                            </button>
                            <div id="bellMenu" class="bell-dropdown">
                                <a href="#" onclick="callWaiter('waiter'); document.getElementById('bellMenu').classList.remove('bell-open'); return false;"><i class="fa fa-hand-paper-o"></i> Appeler le serveur</a>
                                <a href="#" onclick="callWaiter('bill'); document.getElementById('bellMenu').classList.remove('bell-open'); return false;"><i class="fa fa-file-text-o"></i> Demander l'addition</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="<?php echo base_url(); ?>application/views/themes/<?php echo $acthemename; ?>/assets_web/plugins/bootstrap-4.1.3-dist/js/bootstrap.min.js"></script>
    <script>
    var orderid = <?php echo $order->order_id; ?>;
    var currentStatus = <?php echo $status; ?>;
    var baseUrl = '<?php echo base_url(); ?>';

    function updateTracker(newStatus) {
        if (newStatus == currentStatus) return;
        currentStatus = newStatus;
        if (newStatus == 5) {
            $('#tracker').html(
                '<div class="tracker-step cancelled">' +
                '<div class="step-icon"><i class="fa fa-times"></i></div>' +
                '<div class="step-content"><h5>Commande annulée</h5><p>Votre commande a été annulée.</p></div></div>'
            );
            return;
        }
        $('#tracker .tracker-step').each(function() {
            var step = parseInt($(this).data('step'));
            $(this).removeClass('done active');
            if (step < newStatus) $(this).addClass('done');
            else if (step == newStatus) $(this).addClass('active');
        });
    }

    function pollStatus() {
        $.ajax({
            url: baseUrl + 'order-status-api/' + orderid,
            type: 'GET', dataType: 'json',
            success: function(data) {
                if (data && data.order_status) updateTracker(parseInt(data.order_status));
            }
        });
    }
    setInterval(pollStatus, 15000);

    function getCsrf() {
        var match = document.cookie.match(/csrf_cookie_name=([^;]+)/);
        return match ? decodeURIComponent(match[1]) : '';
    }
    function callWaiter(callType) {
        var url = (callType === 'bill') ? baseUrl + 'request-bill' : baseUrl + 'call-waiter';
        var msg = (callType === 'bill') ? 'Envoyer la demande d\'addition ?' : 'Appeler le serveur ?';
        swal({
            title: msg, type: 'info',
            showCancelButton: true, confirmButtonText: 'Oui', cancelButtonText: 'Non'
        }, function(confirmed) {
            if (!confirmed) return;
            $.ajax({
                url: url, type: 'POST', dataType: 'json',
                data: 'csrf_test_name=' + getCsrf(),
                success: function(r) {
                    swal(r.status === 'success' ? 'Envoyé !' : 'Erreur', r.message, r.status === 'success' ? 'success' : 'warning');
                },
                error: function(xhr) {
                    swal('Erreur', xhr.responseText ? xhr.responseText.substring(0, 200) : 'Impossible de contacter le serveur.', 'error');
                }
            });
        });
    }

    // Close bell menu when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.ti-bell, #bellMenu').length) {
            $('#bellMenu').removeClass('bell-open');
        }
    });
    </script>
</body>
</html>
