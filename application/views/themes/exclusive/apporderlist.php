<?php $webinfo = $this->webinfo;
$storeinfo = $this->settinginfo;
$currency = $this->storecurrency;
$activethemeinfo = $this->themeinfo;
$acthemename = $activethemeinfo->themename;

if (!empty($seoterm)) {
	$seoinfo = $this->db->select('*')->from('tbl_seoption')->where('title_slug', $seoterm)->get()->row();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?php echo $seoinfo->description ?? ''; ?>">
    <meta name="keywords" content="<?php echo $seoinfo->keywords ?? ''; ?>">

    <title><?php echo $title; ?></title>
    <link rel="shortcut icon" type="image/ico" href="<?php echo base_url((!empty($this->settinginfo->favicon) ? $this->settinginfo->favicon : 'application/views/themes/' . $acthemename . '/assets_web/images/favicon.png')) ?>">
    <script src="<?php echo base_url(); ?>application/views/themes/<?php echo $acthemename; ?>/assets_web/js/jquery-3.3.1.min.js"></script>
        <!-- Ajout plugins via CDN -->
        <script src="https://cdn.jsdelivr.net/npm/theia-sticky-sidebar@1.7.0/dist/theia-sticky-sidebar.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/floating-whatsapp@1.0.1/dist/floating-wpp.min.css" />
        <script src="https://cdn.jsdelivr.net/npm/floating-whatsapp@1.0.1/dist/floating-wpp.min.js"></script>

    <!--====== Plugins CSS Files =======-->
    <link href="<?php echo base_url(); ?>application/views/themes/<?php echo $acthemename; ?>/assets_web/plugins/bootstrap-4.1.3-dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>application/views/themes/<?php echo $acthemename; ?>/assets_web/plugins/fontawesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>application/views/themes/<?php echo $acthemename; ?>/assets_web/plugins/themify-icons/themify-icons.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>application/views/themes/<?php echo $acthemename; ?>/assets_web/plugins/animate-css/animate.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>application/views/themes/<?php echo $acthemename; ?>/assets_web/plugins/owl-carousel/owl.carousel.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>application/views/themes/<?php echo $acthemename; ?>/assets_web/plugins/metismenu/metisMenu.min.css" rel="stylesheet">

    <!--====== Custom CSS Files ======-->
    <link href="<?php echo base_url(); ?>application/views/themes/<?php echo $acthemename; ?>/assets_web/css/style.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>application/views/themes/<?php echo $acthemename; ?>/assets_web/css/new.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>application/views/themes/<?php echo $acthemename; ?>/assets_web/css/responsive.css" rel="stylesheet">

    <link href="<?php echo base_url(); ?>application/views/themes/<?php echo $acthemename; ?>/assets_web/css/apporderlist.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/sweetalert/sweetalert.css" rel="stylesheet" type="text/css" />
    <script src="<?php echo base_url(); ?>assets/sweetalert/sweetalert.min.js" type="text/javascript"></script>
    <style>
    .order-filter-bar{display:flex;gap:6px;flex-wrap:wrap;padding:0 0 12px;overflow-x:auto;}
    .filter-status-btn{border:1px solid #e5e7eb;background:#fff;border-radius:20px;padding:5px 14px;font-size:12px;font-weight:600;cursor:pointer;white-space:nowrap;transition:all .2s;color:#6b7280;}
    .filter-status-btn.active{background:#111;color:#fff;border-color:#111;}
    .order-card{background:#fff;border-radius:12px;box-shadow:0 1px 8px rgba(0,0,0,.08);margin-bottom:12px;overflow:hidden;}
    .order-card-header{display:flex;justify-content:space-between;align-items:center;padding:12px 14px 8px;}
    .order-card-id{font-weight:700;font-size:14px;color:#111;}
    .order-status-badge{border-radius:20px;padding:3px 10px;font-size:11px;font-weight:700;letter-spacing:.3px;}
    .order-card-body{display:flex;justify-content:space-between;align-items:center;padding:0 14px 10px;border-bottom:1px solid #f3f4f6;}
    .order-card-date{font-size:12px;color:#9ca3af;}
    .order-card-date i{margin-right:4px;}
    .order-card-amount{font-size:15px;font-weight:700;color:#111;}
    .order-card-actions{display:flex;gap:6px;padding:10px 14px;flex-wrap:wrap;}
    .btn-order-action{border-radius:8px;padding:6px 12px;font-size:12px;font-weight:600;text-decoration:none;cursor:pointer;border:none;display:inline-flex;align-items:center;gap:4px;transition:opacity .2s;}
    .btn-order-action:hover{opacity:.8;text-decoration:none;}
    .btn-view-order{background:#111;color:#fff;}
    .btn-track-order{background:#3b82f6;color:#fff;}
    .btn-edit-order{background:#10b981;color:#fff;}
    .orders-empty{text-align:center;padding:40px 20px;color:#9ca3af;}
    .orders-empty i{font-size:36px;display:block;margin-bottom:10px;}
    @media print{
        body>*{display:none!important;}
        .modal,#vieworder{display:block!important;position:static!important;}
        .modal-dialog{margin:0;max-width:100%!important;}
        .modal-header .close,.btn-download-receipt,.fixed_area,.header_top_area{display:none!important;}
        .modal-backdrop{display:none!important;}
        .modal-content{box-shadow:none;border:none;}
    }
    </style>

 
</head>

<body>
    <div class="modal fade" id="vieworder" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-addons">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><?php echo display('foodde') ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body popview">
                </div>

            </div>
        </div>
    </div>
    <!-- Preloader -->
    <div class="preloader"></div>

    <!--START HEADER TOP-->
    <header class="header_top_area only-sm">

        <div class="header_top light" style="background:<?php if (!empty($webinfo->backgroundcolorqr)) {
                                                            echo $webinfo->backgroundcolorqr;
                                                        } ?>;">
            <div class="container-fluid">
                <nav class="navbar navbar-expand-lg">
                    <div class="sidebar-toggle-btn">
                        
                    </div>
                    <a class="" href="<?php echo base_url(); ?>qr-menu">
                        <img src="<?php echo base_url(!empty($webinfo->logo) ? $webinfo->logo : 'dummyimage/168x65.jpg'); ?>" alt="">
                    </a>
                    <div class="act-icon">
                       
                    </div>
                </nav>
                <nav id="sidebar" class="sidebar-nav">
                    <div id="dismiss">
                        <i class="ti-close"></i>
                    </div>
                    <ul class="metismenu list-unstyled" id="mobile-menu">
                        <li><a href="<?php echo base_url() . 'app-terms'; ?>"><?php echo display('terms_condition') ?></a></li>
                        <li><a href="<?php echo base_url() . 'app-refund-policty'; ?>"><?php echo display('refundp') ?></a></li>
                        <?php
                        if ($this->session->userdata('CusUserID') != "") { ?>
                            <li><a href="<?php echo base_url() . 'apporedrlist'; ?>"><?php echo display('morderlist') ?></a></li>
                        <?php } ?>
                    </ul>
                </nav>
                <div class="overlay"></div>
            </div>
        </div>

    </header>
    <!--END HEADER TOP-->

    <div class="product_sec sec_mar only-sm">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h5 class="text-center mb-3" style="font-weight:700;"><?php echo display('morderlist') ?></h5>

                    <!-- Status filter -->
                    <div class="order-filter-bar">
                        <button class="filter-status-btn active" onclick="filterOrderStatus(this,'all')">Tous</button>
                        <button class="filter-status-btn" onclick="filterOrderStatus(this,'1')"><?php echo display('pending_ord') ?></button>
                        <button class="filter-status-btn" onclick="filterOrderStatus(this,'2')"><?php echo display('Processingod') ?></button>
                        <button class="filter-status-btn" onclick="filterOrderStatus(this,'3')"><?php echo display('ready') ?></button>
                        <button class="filter-status-btn" onclick="filterOrderStatus(this,'4')"><?php echo display('served') ?></button>
                        <button class="filter-status-btn" onclick="filterOrderStatus(this,'5')"><?php echo display('cancel') ?></button>
                    </div>

                    <!-- Order cards -->
                    <div id="orderCardsContainer">
                    <?php
                    $today = date('Y-m-d');
                    $has_orders = false;
                    foreach ($iteminfo as $item):
                        $has_orders = true;
                        // Effective status for filtering
                        $eff_status = $item->order_status;
                        if ($item->order_status == 4 && $item->orderacceptreject != 1) $eff_status = 1;

                        // Status label & color
                        if ($item->order_status == 1) { $sl = display('pending_ord'); $sc = '#f59e0b'; }
                        elseif ($item->order_status == 2) { $sl = display('Processingod'); $sc = '#3b82f6'; }
                        elseif ($item->order_status == 3) { $sl = display('ready'); $sc = '#10b981'; }
                        elseif ($item->order_status == 4 && $item->orderacceptreject != 1) { $sl = display('pending_ord'); $sc = '#f59e0b'; }
                        elseif ($item->order_status == 4 && $item->orderacceptreject == 1) { $sl = display('served'); $sc = '#6366f1'; }
                        elseif ($item->order_status == 5) { $sl = display('cancel'); $sc = '#ef4444'; }
                        else { $sl = '—'; $sc = '#9ca3af'; }
                    ?>
                    <div class="order-card" data-status="<?php echo $eff_status; ?>">
                        <div class="order-card-header">
                            <span class="order-card-id">#<?php echo $item->order_id; ?></span>
                            <span class="order-status-badge" style="background:<?php echo $sc; ?>18;color:<?php echo $sc; ?>;border:1px solid <?php echo $sc; ?>44;">
                                <?php echo $sl; ?>
                            </span>
                        </div>
                        <div class="order-card-body">
                            <span class="order-card-date"><i class="fa fa-calendar-o"></i><?php echo $item->order_date; ?></span>
                            <span class="order-card-amount">
                                <?php if ($currency->position == 1) echo $currency->curr_icon; ?>
                                <?php echo number_format($item->totalamount, 0, '.', ' '); ?>
                                <?php if ($currency->position == 2) echo $currency->curr_icon; ?>
                            </span>
                        </div>
                        <div class="order-card-actions">
                            <a onclick="vieworderinfo(<?php echo $item->order_id; ?>)" class="btn-order-action btn-view-order" data-toggle="modal" data-target="#vieworder">
                                <i class="fa fa-eye"></i> Voir détails
                            </a>
                            <?php if ($item->order_status >= 1 && $item->order_status <= 3): ?>
                            <a href="<?php echo base_url('order-tracking/' . $item->order_id); ?>" class="btn-order-action btn-track-order">
                                <i class="fa fa-map-marker"></i> Suivi
                            </a>
                            <?php endif; ?>
                            <?php if (($item->order_status == 1 || $item->order_status == 2 || $item->order_status == 3 || $item->cutomertype == 99) && ($item->order_date == $today) && ($item->order_status != 4) && ($item->order_status != 5)): ?>
                            <a href="<?php echo base_url(); ?>updatemyorder/<?php echo $item->order_id; ?>" class="btn-order-action btn-edit-order">
                                <i class="fa fa-pencil"></i> Modifier
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    </div>

                    <?php if (!$has_orders): ?>
                    <div class="orders-empty">
                        <i class="fa fa-inbox"></i>
                        Aucune commande trouvée
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php $totalqty = 0;
          $totalamount = 0;
          if ($this->cart->contents() > 0) {
          	$totalqty = count($this->cart->contents());
          } ?>
<div class="fixed_area only-sm">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex align-items-center justify-content-between">
                      	<div class="icon">
                      		<a class="btn btn-transparent" href="<?php echo base_url(); ?>qr-menu">
                      			<i class="ti-home" style="color:<?php if (!empty($webinfo->qrheaderfontcolor)) {
                                                                echo $webinfo->qrheaderfontcolor;
                                                            } ?>;"></i>
                      		</a>                      			
                      	</div>
                      	<div class="icon">
                        <input name="cqty" type="hidden" value="<?php echo $totalqty;?>" id="cartitemandprice">
                        <input name="isloginuser" id="isloginuser" type="hidden" value="<?php echo $this->session->userdata('CusUserID');?>">
                      		<button class="btn btn-transparent" onClick="orderlist()">
                      			<i class="ti-pencil-alt" style="color:<?php if (!empty($webinfo->qrheaderfontcolor)) {
                                                                echo $webinfo->qrheaderfontcolor;
                                                            } ?>;"></i>
                      		</button>   
                      	</div>
                      	<div class="icon">
                      		<button class="btn btn-transparent btnposition" onClick="gotoappcart()">
                      			<i class="ti-shopping-cart" style="color:<?php if (!empty($webinfo->qrheaderfontcolor)) {
                                                                echo $webinfo->qrheaderfontcolor;
                                                            } ?>;"></i><span id="badgeshow" class="<?php if($totalqty>0){ echo "badgedisplayblock";}else{ echo "badgedisplaynone";}?> classic-badge2"><?php echo $totalqty;?></span>
                      		</button>   
                      	</div>
                        <div class="sidebar-toggle-btn icon">
                        <button type="button" id="sidebarCollapse" class="btn btn-transparent">
                            <i class="ti-menu" style="color:<?php if (!empty($webinfo->qrheaderfontcolor)) {
                                                                echo $webinfo->qrheaderfontcolor;
                                                            } ?>;"></i>
                        </button>
                      		 
                      	</div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--====== SCRIPTS JS ======-->
    <script src="<?php echo base_url('/ordermanage/order/showljslang') ?>" type="text/javascript"></script>
	<script src="<?php echo base_url('/ordermanage/order/basicjs') ?>" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>application/views/themes/<?php echo $acthemename; ?>/assets_web/plugins/bootstrap-4.1.3-dist/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>application/views/themes/<?php echo $acthemename; ?>/assets_web/plugins/owl-carousel/owl.carousel.min.js"></script>
    <script src="<?php echo base_url(); ?>application/views/themes/<?php echo $acthemename; ?>/assets_web/plugins/metismenu/metisMenu.min.js"></script>
    <script src="<?php echo base_url(); ?>application/views/themes/<?php echo $acthemename; ?>/assets_web/plugins/wow/wow.min.js"></script>
    <script src="<?php echo base_url(); ?>application/views/themes/<?php echo $acthemename; ?>/assets_web/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <script src="<?php echo base_url(); ?>application/views/themes/<?php echo $acthemename; ?>/assets_web/plugins/clockpicker/clockpicker.min.js"></script>
    <!--===== ACTIVE JS=====-->
    <script src="<?php echo base_url(); ?>application/views/themes/<?php echo $acthemename; ?>/assets_web/js/custom.js"></script>

    <script src="<?php echo base_url(); ?>application/views/themes/<?php echo $acthemename; ?>/assets_web/js/qrappdetails.js"></script>
    <script>
    function filterOrderStatus(btn, status) {
        document.querySelectorAll('.filter-status-btn').forEach(function(b){ b.classList.remove('active'); });
        btn.classList.add('active');
        document.querySelectorAll('.order-card').forEach(function(card) {
            if (status === 'all' || card.getAttribute('data-status') === status) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    }
    </script>
</body>

</html>