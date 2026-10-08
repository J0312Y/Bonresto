<?php
$webinfo        = $this->webinfo;
$activethemeinfo = $this->themeinfo;
$acthemename    = $activethemeinfo->themename;
$headercolor    = !empty($webinfo->qrheadercolor)    ? $webinfo->qrheadercolor    : '#ff6b35';
$headerfontcolor = !empty($webinfo->qrheaderfontcolor) ? $webinfo->qrheaderfontcolor : '#fff';
$bgcolor        = !empty($webinfo->backgroundcolorqr) ? $webinfo->backgroundcolorqr : '#f5f6fa';

// Fix N/A table name
$tableid_session = $this->session->userdata('tableid');
if (!empty($tablename) && $tablename !== 'N/A' && $tablename !== 'null') {
    $display_table = $tablename;
} elseif (!empty($tableid_session)) {
    $display_table = 'Table ' . $tableid_session;
} else {
    $display_table = 'À emporter';
}

$status = (int) $order->order_status;
$progress_map = [1 => 25, 2 => 50, 3 => 75, 4 => 100];
$progress_pct  = $progress_map[$status] ?? 0;
$progress_step = ($status >= 1 && $status <= 4) ? $status : 0;

$order_date_fmt = !empty($order->order_date) ? date('d/m/Y', strtotime($order->order_date)) : date('d/m/Y');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Suivi · #<?php echo $order->saleinvoice; ?></title>
    <link rel="shortcut icon" type="image/ico" href="<?php echo base_url(!empty($this->settinginfo->favicon) ? $this->settinginfo->favicon : 'application/views/themes/' . $acthemename . '/assets_web/images/favicon.png'); ?>">
    <script src="<?php echo base_url(); ?>application/views/themes/<?php echo $acthemename; ?>/assets_web/js/jquery-3.3.1.min.js"></script>
    <link href="<?php echo base_url(); ?>application/views/themes/<?php echo $acthemename; ?>/assets_web/plugins/bootstrap-4.1.3-dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>application/views/themes/<?php echo $acthemename; ?>/assets_web/plugins/fontawesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>application/views/themes/<?php echo $acthemename; ?>/assets_web/plugins/themify-icons/themify-icons.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>application/views/themes/<?php echo $acthemename; ?>/assets_web/css/style.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>application/views/themes/<?php echo $acthemename; ?>/assets_web/css/new.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>application/views/themes/<?php echo $acthemename; ?>/assets_web/css/app.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/sweetalert/sweetalert.css" rel="stylesheet">
    <script src="<?php echo base_url(); ?>assets/sweetalert/sweetalert.min.js"></script>

    <style>
    *, *::before, *::after { box-sizing: border-box; }
    body { background: #f0f2f5; margin: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; }

    /* ── Page wrapper ───────────────────── */
    .track-page { max-width: 480px; margin: 0 auto; padding: 15px 14px 110px; }

    /* ── Hero card ─────────────────────── */
    .hero-card {
        background: #fff;
        border-radius: 18px;
        padding: 20px 18px 18px;
        margin-bottom: 14px;
        border-left: 5px solid <?php echo $headercolor; ?>;
        box-shadow: 0 2px 12px rgba(0,0,0,.08);
    }
    .hero-table-name {
        color: #111;
        font-size: 22px;
        font-weight: 800;
        margin: 0 0 10px;
        letter-spacing: -.3px;
    }
    .hero-table-name i {
        color: <?php echo $headercolor; ?>;
        margin-right: 7px;
    }
    .hero-meta {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }
    .hero-badge {
        background: #f3f4f6;
        border: 1px solid #e5e7eb;
        color: #374151;
        border-radius: 20px;
        padding: 3px 11px;
        font-size: 12px;
        font-weight: 600;
    }
    .hero-badge i { color: <?php echo $headercolor; ?>; margin-right: 3px; }

    /* ── Progress bar ──────────────────── */
    .progress-wrap {
        background: #fff;
        border-radius: 14px;
        padding: 14px 16px 12px;
        margin-bottom: 14px;
        box-shadow: 0 1px 8px rgba(0,0,0,.06);
    }
    .progress-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }
    .progress-label { font-size: 12px; font-weight: 700; color: #374151; }
    .progress-step-count { font-size: 11px; color: #9ca3af; font-weight: 600; }
    .progress-bar-track {
        height: 7px;
        background: #f0f0f0;
        border-radius: 99px;
        overflow: hidden;
    }
    .progress-bar-fill {
        height: 100%;
        border-radius: 99px;
        background: linear-gradient(90deg, <?php echo $headercolor; ?>, <?php echo $headercolor; ?>bb);
        transition: width .6s ease;
        width: <?php echo $progress_pct; ?>%;
    }

    /* ── Timeline ──────────────────────── */
    .timeline-card {
        background: #fff;
        border-radius: 16px;
        padding: 18px 16px;
        margin-bottom: 14px;
        box-shadow: 0 1px 8px rgba(0,0,0,.06);
    }
    .timeline { list-style: none; margin: 0; padding: 0; }
    .tl-step { display: flex; align-items: flex-start; position: relative; padding-bottom: 0; }
    .tl-step:not(:last-child) { padding-bottom: 6px; }

    /* Connector line */
    .tl-line-wrap { display: flex; flex-direction: column; align-items: center; width: 42px; flex-shrink: 0; }
    .tl-dot {
        width: 40px; height: 40px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 16px;
        background: #f3f4f6;
        color: #d1d5db;
        border: 2px solid #e5e7eb;
        flex-shrink: 0;
        transition: all .4s ease;
        position: relative; z-index: 2;
    }
    .tl-connector {
        width: 2px;
        flex: 1;
        min-height: 24px;
        background: #e5e7eb;
        margin: 2px 0;
        transition: background .4s ease;
    }
    .tl-step:last-child .tl-connector { display: none; }

    /* Step states */
    .tl-step.done .tl-dot { background: #dcfce7; color: #16a34a; border-color: #16a34a; }
    .tl-step.done .tl-connector { background: #16a34a; }
    .tl-step.active .tl-dot {
        background: <?php echo $headercolor; ?>;
        color: <?php echo $headerfontcolor; ?>;
        border-color: <?php echo $headercolor; ?>;
        animation: tlpulse 2s infinite;
    }
    .tl-step.cancelled .tl-dot { background: #fee2e2; color: #dc2626; border-color: #dc2626; }

    /* Step content */
    .tl-content { padding: 8px 0 20px 14px; flex: 1; }
    .tl-step:last-child .tl-content { padding-bottom: 0; }
    .tl-title { font-size: 14px; font-weight: 700; color: #9ca3af; margin: 0 0 2px; transition: color .4s; }
    .tl-desc { font-size: 12px; color: #d1d5db; margin: 0; transition: color .4s; }
    .tl-step.done .tl-title { color: #16a34a; }
    .tl-step.done .tl-desc { color: #6b7280; }
    .tl-step.active .tl-title { color: #111; }
    .tl-step.active .tl-desc { color: #6b7280; }
    .tl-step.active .tl-content { position: relative; }
    .active-badge {
        display: inline-block;
        background: <?php echo $headercolor; ?>18;
        color: <?php echo $headercolor; ?>;
        border: 1px solid <?php echo $headercolor; ?>44;
        border-radius: 20px;
        padding: 1px 8px;
        font-size: 10px;
        font-weight: 700;
        margin-left: 6px;
        vertical-align: middle;
        letter-spacing: .3px;
    }
    .tl-step.cancelled .tl-title { color: #dc2626; }
    .tl-step.cancelled .tl-desc { color: #6b7280; }

    /* ── Order items card ──────────────── */
    .items-card {
        background: #fff;
        border-radius: 16px;
        padding: 16px;
        margin-bottom: 14px;
        box-shadow: 0 1px 8px rgba(0,0,0,.06);
    }
    .items-card-title {
        font-size: 13px;
        font-weight: 700;
        color: #374151;
        margin: 0 0 12px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .items-card-title i { color: <?php echo $headercolor; ?>; }
    .order-item-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        border-bottom: 1px solid #f3f4f6;
        font-size: 13px;
        color: #374151;
    }
    .order-item-row:last-of-type { border-bottom: none; }
    .item-qty-tag {
        display: inline-block;
        background: <?php echo $headercolor; ?>18;
        color: <?php echo $headercolor; ?>;
        border-radius: 6px;
        padding: 1px 7px;
        font-size: 11px;
        font-weight: 700;
        margin-right: 6px;
    }
    .item-price { font-weight: 600; color: #111; white-space: nowrap; }
    .total-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0 0;
        margin-top: 8px;
        border-top: 2px solid #f3f4f6;
        font-size: 15px;
        font-weight: 800;
        color: #111;
    }

    /* ── Buttons ───────────────────────── */
    .btn-addmore {
        display: block;
        width: 100%;
        padding: 15px;
        border-radius: 14px;
        font-weight: 700;
        text-align: center;
        font-size: 15px;
        background: <?php echo $headercolor; ?>;
        color: <?php echo $headerfontcolor; ?>;
        border: none;
        box-shadow: 0 4px 16px <?php echo $headercolor; ?>44;
        text-decoration: none;
        transition: opacity .2s;
    }
    .btn-addmore:hover { opacity: .9; color: <?php echo $headerfontcolor; ?>; text-decoration: none; }
    .btn-addmore i { margin-right: 6px; }

    /* ── Bell dropdown ─────────────────── */
    .bell-dropdown { display: none; position: absolute; bottom: 56px; right: 0; background: #fff; border-radius: 12px; box-shadow: 0 4px 24px rgba(0,0,0,.14); min-width: 210px; z-index: 999; overflow: hidden; }
    .bell-dropdown.bell-open { display: block; }
    .bell-dropdown a { display: block; padding: 12px 16px; color: #333; text-decoration: none; font-size: 13px; border-bottom: 1px solid #f3f4f6; }
    .bell-dropdown a:last-child { border-bottom: none; }
    .bell-dropdown a:hover { background: #f9fafb; }
    .bell-dropdown a i { margin-right: 8px; color: <?php echo $headercolor; ?>; }

    /* ── Pulse animation ───────────────── */
    @keyframes tlpulse {
        0%   { box-shadow: 0 0 0 0   <?php echo $headercolor; ?>77; }
        70%  { box-shadow: 0 0 0 12px <?php echo $headercolor; ?>00; }
        100% { box-shadow: 0 0 0 0   <?php echo $headercolor; ?>00; }
    }

    /* ── Live indicator ────────────────── */
    .live-indicator {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 11px;
        color: #9ca3af;
        margin-bottom: 12px;
        justify-content: flex-end;
    }
    .live-dot {
        width: 7px; height: 7px;
        border-radius: 50%;
        background: #16a34a;
        animation: liveblink 2s infinite;
    }
    @keyframes liveblink { 0%,100%{opacity:1;} 50%{opacity:.3;} }
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
                    <img src="<?php echo base_url(!empty($webinfo->logo) ? $webinfo->logo : 'assets/img/applogo.png'); ?>" alt="logo" style="max-height:38px;">
                </a>
                <div class="act-icon">
                    <span style="font-weight:700;color:<?php echo $headerfontcolor; ?>;font-size:13px;">
                        <i class="fa fa-map-marker" style="margin-right:4px;"></i>Suivi
                    </span>
                </div>
            </nav>
        </div>
    </div>
</header>

<div class="track-page">

    <!-- Live indicator -->
    <div class="live-indicator">
        <span class="live-dot"></span>
        <span id="lastUpdated">En direct</span>
    </div>

    <!-- Hero card -->
    <div class="hero-card">
        <h2 class="hero-table-name">
            <i class="fa fa-cutlery"></i><?php echo htmlspecialchars($display_table); ?>
        </h2>
        <div class="hero-meta">
            <span class="hero-badge"><i class="fa fa-hashtag"></i> <?php echo $order->saleinvoice; ?></span>
            <span class="hero-badge"><i class="fa fa-calendar-o"></i> <?php echo $order_date_fmt; ?></span>
        </div>
    </div>

    <?php if ($status != 5): ?>
    <!-- Progress bar -->
    <div class="progress-wrap">
        <div class="progress-header">
            <span class="progress-label">Progression</span>
            <span class="progress-step-count" id="stepCount">Étape <?php echo $progress_step; ?> / 4</span>
        </div>
        <div class="progress-bar-track">
            <div class="progress-bar-fill" id="progressFill" style="width:<?php echo $progress_pct; ?>%;"></div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Timeline -->
    <div class="timeline-card">
        <?php if ($status == 5): ?>
        <ul class="timeline">
            <li class="tl-step cancelled">
                <div class="tl-line-wrap">
                    <div class="tl-dot"><i class="fa fa-times"></i></div>
                    <div class="tl-connector"></div>
                </div>
                <div class="tl-content">
                    <p class="tl-title">Commande annulée</p>
                    <p class="tl-desc">Votre commande a été annulée.</p>
                </div>
            </li>
        </ul>
        <?php else: ?>
        <?php
        $steps = [
            1 => ['icon' => 'fa-clock-o',     'title' => 'En attente',     'desc' => 'Votre commande a été reçue'],
            2 => ['icon' => 'fa-fire',         'title' => 'En préparation', 'desc' => 'La cuisine prépare votre commande'],
            3 => ['icon' => 'fa-check-circle', 'title' => 'Prêt',           'desc' => 'Votre commande est prête !'],
            4 => ['icon' => 'fa-cutlery',      'title' => 'Servi',          'desc' => 'Bon appétit !'],
        ];
        ?>
        <ul class="timeline" id="tracker">
        <?php foreach ($steps as $stepNum => $step):
            if ($stepNum < $status)      $cls = 'done';
            elseif ($stepNum == $status) $cls = 'active';
            else                          $cls = '';
        ?>
            <li class="tl-step <?php echo $cls; ?>" data-step="<?php echo $stepNum; ?>">
                <div class="tl-line-wrap">
                    <div class="tl-dot">
                        <?php if ($stepNum < $status): ?>
                            <i class="fa fa-check"></i>
                        <?php else: ?>
                            <i class="fa <?php echo $step['icon']; ?>"></i>
                        <?php endif; ?>
                    </div>
                    <div class="tl-connector"></div>
                </div>
                <div class="tl-content">
                    <p class="tl-title">
                        <?php echo $step['title']; ?>
                        <?php if ($stepNum == $status): ?><span class="active-badge">En cours</span><?php endif; ?>
                    </p>
                    <p class="tl-desc"><?php echo $step['desc']; ?></p>
                </div>
            </li>
        <?php endforeach; ?>
        </ul>
        <?php endif; ?>
    </div>

    <!-- Order items -->
    <div class="items-card">
        <h5 class="items-card-title"><i class="fa fa-list-ul"></i> Détails de la commande</h5>
        <div id="items-list">
        <?php if (!empty($items)): foreach ($items as $item):
            $line_price = $item->price * $item->qty;
        ?>
            <div class="order-item-row">
                <span>
                    <span class="item-qty-tag"><?php echo $item->qty; ?>x</span>
                    <?php echo htmlspecialchars($item->product_name); ?>
                </span>
                <span class="item-price">
                    <?php echo $line_price > 0 ? number_format($line_price, 0, '.', ' ') : number_format($order->totalamount / max(count($items), 1), 0, '.', ' '); ?>
                </span>
            </div>
        <?php endforeach; endif; ?>
        </div>
        <div class="total-row">
            <span>Total</span>
            <span id="order-total-amount"><?php echo number_format($order->totalamount, 0, '.', ' '); ?></span>
        </div>
    </div>

    <!-- Commander plus -->
    <?php if ($status < 4 && $status != 5): ?>
    <a href="<?php echo base_url('qr-menu'); ?>" class="btn-addmore">
        <i class="fa fa-plus-circle"></i> Commander plus
    </a>
    <?php endif; ?>

</div>

<!-- Bottom nav -->
<?php $totalqty = ($this->cart->contents() > 0) ? count($this->cart->contents()) : 0; ?>
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
                            <?php if ($totalqty > 0): ?>
                            <span class="badgedisplayblock classic-badge2"><?php echo $totalqty; ?></span>
                            <?php endif; ?>
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

<script src="<?php echo base_url(); ?>application/views/themes/<?php echo $acthemename; ?>/assets_web/plugins/bootstrap-4.1.3-dist/js/bootstrap.min.js"></script>
<script>
var orderid       = <?php echo $order->order_id; ?>;
var currentStatus = <?php echo $status; ?>;
var baseUrl       = '<?php echo base_url(); ?>';

var progressMap = { 1: 25, 2: 50, 3: 75, 4: 100 };
var stepTitles  = { 1: 'En attente', 2: 'En préparation', 3: 'Prêt', 4: 'Servi' };
var stepDescs   = { 1: 'Votre commande a été reçue', 2: 'La cuisine prépare votre commande', 3: 'Votre commande est prête !', 4: 'Bon appétit !' };
var stepIcons   = { 1: 'fa-clock-o', 2: 'fa-fire', 3: 'fa-check-circle', 4: 'fa-cutlery' };

function updateTracker(newStatus) {
    if (newStatus === currentStatus) return;
    currentStatus = newStatus;

    if (newStatus === 5) {
        $('#tracker').html(
            '<li class="tl-step cancelled">' +
            '<div class="tl-line-wrap"><div class="tl-dot"><i class="fa fa-times"></i></div><div class="tl-connector"></div></div>' +
            '<div class="tl-content"><p class="tl-title">Commande annulée</p><p class="tl-desc">Votre commande a été annulée.</p></div></li>'
        );
        return;
    }

    // Update progress bar
    var pct = progressMap[newStatus] || 0;
    $('#progressFill').css('width', pct + '%');
    $('#stepCount').text('Étape ' + newStatus + ' / 4');

    // Update timeline steps
    $('#tracker .tl-step').each(function() {
        var step = parseInt($(this).data('step'));
        var $dot  = $(this).find('.tl-dot');
        var $conn = $(this).find('.tl-connector');
        $(this).removeClass('done active');
        $dot.html('<i class="fa ' + stepIcons[step] + '"></i>');
        $conn.css('background', '#e5e7eb');

        if (step < newStatus) {
            $(this).addClass('done');
            $dot.html('<i class="fa fa-check"></i>');
            $conn.css('background', '#16a34a');
        } else if (step === newStatus) {
            $(this).addClass('active');
            $(this).find('.tl-title').html(stepTitles[step] + ' <span class="active-badge">En cours</span>');
            $(this).find('.tl-desc').text(stepDescs[step]);
        }
    });
}

var lastUpdate = new Date();
function updateLastUpdatedLabel() {
    var sec = Math.round((new Date() - lastUpdate) / 1000);
    var label = sec < 10 ? 'En direct' : 'Mis à jour il y a ' + sec + 's';
    document.getElementById('lastUpdated').textContent = label;
}

function pollStatus() {
    $.ajax({
        url: baseUrl + 'order-status-api/' + orderid,
        type: 'GET', dataType: 'json',
        success: function(data) {
            if (data && data.order_status) {
                updateTracker(parseInt(data.order_status));
                lastUpdate = new Date();
            }
        }
    });
}

setInterval(pollStatus, 15000);
setInterval(updateLastUpdatedLabel, 5000);

function getCsrf() {
    var match = document.cookie.match(/csrf_cookie_name=([^;]+)/);
    return match ? decodeURIComponent(match[1]) : '';
}
function callWaiter(callType) {
    var url = (callType === 'bill') ? baseUrl + 'request-bill' : baseUrl + 'call-waiter';
    var msg = (callType === 'bill') ? "Envoyer la demande d'addition ?" : 'Appeler le serveur ?';
    swal({ title: msg, type: 'info', showCancelButton: true, confirmButtonText: 'Oui', cancelButtonText: 'Non' },
    function(confirmed) {
        if (!confirmed) return;
        $.ajax({
            url: url, type: 'POST', dataType: 'json',
            data: 'csrf_test_name=' + getCsrf(),
            success: function(r) {
                swal(r.status === 'success' ? 'Envoyé !' : 'Erreur', r.message, r.status === 'success' ? 'success' : 'warning');
            },
            error: function() { swal('Erreur', 'Impossible de contacter le serveur.', 'error'); }
        });
    });
}

$(document).on('click', function(e) {
    if (!$(e.target).closest('[onclick*="bellMenu"], #bellMenu').length) {
        $('#bellMenu').removeClass('bell-open');
    }
});
</script>
</body>
</html>
