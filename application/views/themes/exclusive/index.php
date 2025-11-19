<?php 
$webinfo   = $this->webinfo;
$activethemeinfo = $this->themeinfo;
$acthemename     = $activethemeinfo->themename;

$footerfirst = $this->db->select('*')->from('tbl_widget')->where('widgetid', 1)->where('status', 1)->get()->row();
$footeraddress = $this->db->select('*')->from('tbl_widget')->where('widgetid', 27)->where('status', 1)->get()->row();

if ($title != "Menu") {
    $this->session->unset_userdata('product_id');
    $this->session->unset_userdata('categoryid');
}

if (!empty($seoterm)) {
    $seoinfo = $this->db->select('*')->from('tbl_seoption')->where('title_slug', $seoterm)->get()->row();
}

/*for whatsapp modules*/
$WhatsApp       = $this->db->where('directory', 'whatsapp')->where('status', 1)->get('module');
$whatsapp_count = $WhatsApp->num_rows();
/*end whatsmoudles*/
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="<?php echo $seoinfo->description ?? ''; ?>">
	<meta name="keywords" content="<?php echo $seoinfo->keywords ?? ''; ?>">

	<title><?php echo $seoinfo->title ?? ''; ?></title>
	<link rel="shortcut icon" type="image/ico" href="<?php echo base_url((!empty($this->settinginfo->favicons) ? $this->settinginfo->favicon : 'application/views/themes/' . $acthemename . '/assets_web/images/favicon.png')) ?>">

	<!--====== Font CSS Files =======-->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Prata&display=swap" rel="stylesheet" />

	<!--====== Plugins CSS Files =======-->
	<link href="<?php echo base_url(); ?>application/views/themes/<?php echo $acthemename; ?>/assets_web/plugins/fontawesome/css/font-awesome.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>application/views/themes/<?php echo $acthemename; ?>/assets_web/plugins/themify-icons/themify-icons.css" rel="stylesheet">
	
	<link href="<?php echo base_url(); ?>application/views/themes/<?php echo $acthemename; ?>/assets_web/plugins/metismenu/metisMenu.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>application/views/themes/<?php echo $acthemename; ?>/assets_web/plugins/bootstrap-5.3.2-dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>application/views/themes/<?php echo $acthemename; ?>/assets_web/plugins/OwlCarousel/owl.carousel.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>application/views/themes/<?php echo $acthemename; ?>/assets_web/plugins/OwlCarousel/owl.theme.default.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>application/views/themes/<?php echo $acthemename; ?>/assets_web/plugins/select2/select2.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>application/views/themes/<?php echo $acthemename; ?>/assets_web/plugins/flatpickr/flatpickr.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>application/views/themes/<?php echo $acthemename; ?>/assets_web/plugins/aos/aos.css" rel="stylesheet" />

	<!--====== Custom CSS Files ======-->
	<link href="<?php echo base_url(); ?>application/views/themes/<?php echo $acthemename; ?>/assets_web/css/style.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>application/views/themes/<?php echo $acthemename; ?>/assets_web/css/responsive.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>application/views/themes/<?php echo $acthemename; ?>/assets_web/css/new-theme.css" rel="stylesheet" />
	<link href="<?php echo base_url(); ?>application/views/themes/<?php echo $acthemename; ?>/assets_web/css/custome.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/sweetalert/sweetalert.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url(); ?>application/views/themes/<?php echo $acthemename; ?>/assets_web/plugins/fancybox/dist/fancybox.css" rel="stylesheet" />
	
	<script src="<?php echo base_url(); ?>application/views/themes/<?php echo $acthemename; ?>/assets_web/js/jquery-3.3.1.min.js"></script>
	
	<script src="<?php echo base_url(); ?>assets/sweetalert/sweetalert.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>assets/js/product.js.php"></script>
	<script src="<?php echo base_url(); ?>assets/js/category.js.php"></script>
    <script src="<?php echo base_url('/ordermanage/order/showljslang') ?>" type="text/javascript"></script>
	<script src="<?php echo base_url('/ordermanage/order/basicjs') ?>" type="text/javascript"></script>
	
	<!-- for whatsapp modules -->
	<?php
	if ($whatsapp_count == 1) {
		$whatsapp_data = $WhatsApp->row();
		$whatsapp_url  = str_replace("/images/thumbnail.jpg", "", $whatsapp_data->image);
		?>
			<link href="<?php echo base_url() . $whatsapp_url; ?>/css/floating-wpp.min.css" rel="stylesheet">
			<script src="<?php echo base_url() . $whatsapp_url; ?>/js/floating-wpp.min.js"></script>

		<?php
	} ?>

	<style>	
		:root {
			--text-primary: <?php echo $activethemeinfo->primary_color ? $activethemeinfo->primary_color : '#c09342'; ?>;
			--top-header-bg: <?php echo $activethemeinfo->top_header_bg ? $activethemeinfo->top_header_bg : '#112a2a'; ?>;
			--header-bg: <?php echo $activethemeinfo->header_bg ? $activethemeinfo->header_bg : '#1f3433'; ?>;
			--nav-text: <?php echo $activethemeinfo->header_color ? $activethemeinfo->header_color : '#ffffff'; ?>;
			--footer-bg: <?php echo $activethemeinfo->footer_bg ? $activethemeinfo->footer_bg : '#081d1c'; ?>;
			--footer-text: <?php echo $activethemeinfo->footer_color ? $activethemeinfo->footer_color : '#ffffff'; ?>;
		}
	</style>

</head>

<body>
	<div class="modal fade" id="addons" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header ps-3 py-1">
					<h1 class="modal-title fs-5" id="exampleModalLabel"><?php echo display('food_details'); ?></h1>
					<button type="button" class="btn" data-bs-dismiss="modal" aria-label="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M2.146 2.146a.5.5 0 0 1 .708 0L8 7.293l5.146-5.147a.5.5 0 0 1 
                            .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 
                            5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854a.5.5 0 0 
                            1 0-.708z"/>
                        </svg>
                    </button>
				</div>

				<div class="modal-body addonsinfo">

				</div>
			</div>
		</div>
	</div>

	<!-- Preloader -->
	<div class="preloader">
		<div class="loader4"></div>
		<img src="<?php echo base_url(); ?>application/views/themes/<?php echo $acthemename; ?>/assets_web/images/loader.png" class="loader-img" alt="">
	</div>

	<!--START HEADER TOP-->
	<?php
	include(APPPATH.'views/themes/exclusive/top-header.php');
	?>

	<!--START HEADER-->
	<div class="common-bg position-relative">
		<header class="header_top_area main-nav">
			<div class="top_header">
				<div class="container">
					<nav class="navbar navbar-expand-lg position-relative py-3 z-3">
						<a href="<?php echo base_url(); ?>">
							<img class="logo-resize" src="<?php echo base_url(!empty($webinfo->logo) ? $webinfo->logo : 'dummyimage/168x65.jpg'); ?>" alt="">
						</a>
						<div class="sidebar-toggle-btn">
					
						<div class="d-flex align-items-end gap-4">
								<a class="nav-link text-primary position-relative" href="<?php echo base_url(); ?>cart" id="navbarDropdown3">
									<i class="fa fa-shopping-basket"></i>
									<span class="badge badge-notify my-cart-badge" id="itemnum">
										<?php $totalqty = 0;if ($this->cart->contents() > 0) {$totalqty = count($this->cart->contents());}
										echo $totalqty;?>
									</span>
								</a>
							<button type="button" id="sidebarCollapse" class="btn">
								<i class="ti-menu"></i>
							</button>
							</div>
						</div>
						<div class="collapse justify-content-end navbar-collapse" id="navbarTogglerDemo03">
							<ul class="navbar-nav ml-auto mt-2 mt-lg-0">
								<?php 
								$allmenu = $this->allmenu;
								$myid = $this->session->userdata('CusUserID');
								$current = $this->uri->segment(1);
								foreach ($allmenu as $menu) {
									$dropdown       = '';
									$dropdownassest = '';
									$dropdownaclass = '';
									$activeclass = (empty($current) && $menu->menu_slug == 'home') || ($current == $menu->menu_slug) ? 'active' : '';


									if ($menu->menu_name == 'Home') {
										$href        = base_url() . $menu->menu_slug;
									} else {
										$href        = base_url() . $menu->menu_slug;
									}

									if ($menu->menu_slug == 'myprofile') {
										if (empty($myid)) {
											$menu->menu_name = "Login";
											$href            = base_url() . "mylogin";
										}
									}

									if (!empty($menu->sub)) {
										$dropdown       = 'dropdown';
										$dropdownassest = 'id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"';
										$dropdownaclass = 'dropdown-toggle';
										$href           = '#';
									} ?>

									<li class="nav-item <?php echo $dropdown; ?> <?php echo $activeclass; ?>">
										<a class="nav-link <?php echo $dropdownaclass; ?>" href="<?php echo $href; ?>" <?php echo $dropdownassest; ?>><?php echo $menu->menu_name; ?></a>
										<div class="dropdown-menu" aria-labelledby="navbarDropdown">
											<?php 
											if (!empty($menu->sub)) {
												foreach ($menu->sub as $submenu) {
													$menurl   = $submenu->menu_slug;
													$menuname = $submenu->menu_name;
													if ($submenu->menu_slug == 'logout') {
														if (empty($myid)) {
															$menurl   = "mylogin";
															$menuname = "Login";
														}

													} ?>
													<a class="dropdown-item" href="<?php echo base_url() . $menurl; ?>"><?php echo $menuname; ?></a> <?php
												}
											} ?>
										</div>
									</li>
									<?php
								} ?>

								<li class="nav-item">
									<a class="btn btn_dark_green ms-3 lh-lg" href="<?php echo base_url('online-order'); ?>"><?php echo display('online_order'); ?></a>
								</li>

								<li class="nav-item">
									<a class="nav-link position-relative" href="<?php echo base_url(); ?>cart" id="navbarDropdown3">
										<i class="fa fa-shopping-basket"></i>
										<span class="badge badge-notify my-cart-badge" id="itemnum">
											<?php $totalqty = 0;if ($this->cart->contents() > 0) {$totalqty = count($this->cart->contents());}
											echo $totalqty;?>
										</span>
									</a>
								</li>
							</ul>
						</div>
					</nav>
					<!-- /. Navbar -->
					<nav id="sidebar" class="sidebar-nav">
						<div id="dismiss">
							<i class="ti-close"></i>
						</div>
						<ul class="metismenu list-unstyled" id="mobile-menu">
							<?php 
							$current = $this->uri->segment(1);
							foreach ($allmenu as $menu) {
								$activeclass = (empty($current) && $menu->menu_slug == 'home') || ($current == $menu->menu_slug) ? 'active' : '';

								if ($menu->menu_name == 'Home') {
									$mobile      = '';
									$href        = base_url() . $menu->menu_slug;
								} else {
									$href        = base_url() . $menu->menu_slug;
								}

								if (!empty($menu->sub)) {
									$mobile = 'aria-expanded="false"';
									$href   = '#';
								} ?>
								<li class="nav-item <?php echo $activeclass; ?>">
									<a href="<?php echo $href; ?>" <?php echo $mobile; ?>><?php echo $menu->menu_name; ?> <?php if (!empty($menu->sub)) {?><span class="fa arrow"></span><?php } ?></a>
									<?php 
									if (!empty($menu->sub)) { ?>
										<ul aria-expanded="false">
											<?php 
											foreach ($menu->sub as $submenu) {
												$menurl   = $submenu->menu_slug;
												$menuname = $submenu->menu_name;
												if ($submenu->menu_slug == 'logout') {
													$myid = $this->session->userdata('CusUserID');
													if (empty($myid)) {
														$menurl   = "mylogin";
														$menuname = "Login";
													}
												} ?>
												<li><a href="<?php echo base_url() . $menurl; ?>"><?php echo $menuname; ?></a></li> <?php
											} ?>
										</ul> <?php
									} ?>
								</li> <?php
							} ?>

							<li class="nav-item">
								<a class="btn btn_dark_green ms-3 lh-lg" href="<?php echo base_url('online-order'); ?>"><?php echo display('online_order'); ?></a>
							</li>
						</ul>
					</nav>
					<div class="overlay"></div>
				</div>
			</div>
		</header>
    </div>
	<!--END HEADER-->

	<?php 
	if (isset($content)) {
		echo $content;
	}
	?>

	<!--Footer Area-->
    <div class="footer-area px-md-4 px-lg-0">
      	<div class="bg-hero-footer"></div>
		<div class="container-xl">
			<div class="row footer-inner justify-content-between">
				<div class="col-xl-3 col-lg-4 col-md-6">
					<div class="footer-logo-area mb-5 mb-md-0">
					<div class="footer-logo">
						<a href="<?php echo base_url(); ?>">
							<img src="<?php echo base_url(!empty($webinfo->logo_footer) ? $webinfo->logo_footer : 'dummyimage/168x65.jpg'); ?>" alt="">
						</a>
					</div>
					<?php
					if (!empty($footerfirst)) { ?>
						<div class="footer_widget_body">
							<p class="mb-4"><?php echo $footerfirst->widget_desc; ?></p>
						</div>
					<?php } ?>

					<div class="footer-social-bookmark">
						<ul class="d-flex gap-2">
							<?php
							foreach ($this->sociallink as $slink) {
        						$icon = substr($slink->icon, 4); ?>
                                <li>
									<a href="<?php echo $slink->socialurl; ?>" class="rounded-circle text-center">
										<i class="fa <?php echo $icon; ?>"></i>
									</a>
								</li> <?php
							} ?>
						</ul>
					</div>
				</div>
			</div>

			<div class="col-lg-4 col-md-6">
				<div class="mb-0">
					<h4 class="contact_title"><?php echo display('get_in_tuch') ?></h4>
					
					<?php if (!empty($footeraddress)) { ?>
						<div class="d-flex mb-3">
							<div class="d-block me-3">
								<svg xmlns="http://www.w3.org/2000/svg" width="21" height="22" viewBox="0 0 21 22" fill="none">
									<path d="M6.9375 9.88889C6.9375 11.7299 8.53243 13.2222 10.5 13.2222C12.4676 13.2222 14.0625 11.7299 14.0625 9.88889C14.0625 8.04794 12.4676 6.55556 10.5 6.55556M10.5 21C5.25329 18.7778 1 14.7981 1 9.88889C1 4.97969 5.25329 1 10.5 1C15.7467 1 20 4.97969 20 9.88889C20 13.1614 18.1099 16.021 15.2954 18.2222" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
								</svg>
							</div>
							<div><?php echo $footeraddress->widget_desc; ?></div>
						</div>
					<?php } ?>
					<div class="d-flex mb-3">
						<div class="d-block me-3">
							<svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 19 19" fill="none">
								<path
								d="M18 14.8805C18 15.1865 17.9319 15.501 17.7872 15.807C17.6425 16.113 17.4552 16.402 17.2083 16.674C16.7912 17.133 16.3315 17.4645 15.8122 17.677C15.3015 17.8895 14.7481 18 14.1522 18C13.2839 18 12.356 17.796 11.3771 17.3795C10.3981 16.963 9.41913 16.402 8.44867 15.6965C7.4697 14.9825 6.54181 14.192 5.65648 13.3165C4.77967 12.4325 3.98798 11.506 3.28142 10.537C2.58337 9.568 2.02153 8.599 1.61292 7.6385C1.20431 6.6695 1 5.743 1 4.859C1 4.281 1.10215 3.7285 1.30646 3.2185C1.51077 2.7 1.83425 2.224 2.28543 1.799C2.83025 1.2635 3.42614 1 4.05608 1C4.29444 1 4.5328 1.051 4.74562 1.153C4.96695 1.255 5.16274 1.408 5.31597 1.629L7.29094 4.4085C7.44417 4.621 7.55483 4.8165 7.63145 5.0035C7.70806 5.182 7.75063 5.3605 7.75063 5.522C7.75063 5.726 7.69104 5.93 7.57186 6.1255C7.46119 6.321 7.29945 6.525 7.09514 6.729L6.44817 7.4005C6.35453 7.494 6.31197 7.6045 6.31197 7.7405C6.31197 7.8085 6.32048 7.868 6.33751 7.936C6.36305 8.004 6.38858 8.055 6.40561 8.106C6.55884 8.3865 6.82273 8.752 7.1973 9.194C7.58037 9.636 7.98898 10.0865 8.43165 10.537C8.89134 10.9875 9.334 11.404 9.78518 11.7865C10.2278 12.1605 10.5939 12.4155 10.8833 12.5685C10.9259 12.5855 10.977 12.611 11.0366 12.6365C11.1047 12.662 11.1728 12.6705 11.2494 12.6705C11.3941 12.6705 11.5048 12.6195 11.5984 12.526L12.2454 11.8885C12.4582 11.676 12.6625 11.5145 12.8583 11.4125C13.0541 11.2935 13.2499 11.234 13.4627 11.234C13.6244 11.234 13.7947 11.268 13.982 11.3445C14.1693 11.421 14.365 11.5315 14.5779 11.676L17.3956 13.6735C17.6169 13.8265 17.7702 14.005 17.8638 14.2175C17.9489 14.43 18 14.6425 18 14.8805Z"
								stroke="white"
								stroke-width="2"
								stroke-miterlimit="10"
								/>
								<path opacity="0.4" d="M14.7615 6.66668C14.7615 6.11158 14.3267 5.26043 13.6791 4.56655C13.087 3.92818 12.3006 3.42859 11.5234 3.42859" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
								<path opacity="0.4" d="M17.9996 6.66667C17.9996 3.53381 15.1038 1 11.5234 1" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
							</svg>
						</div>
						<div><?php echo $webinfo->phone_optional; ?></div>
					</div>
					<div class="d-flex mb-4">
						<div class="d-block me-3">
							<svg xmlns="http://www.w3.org/2000/svg" width="22" height="17" viewBox="0 0 22 17" fill="none">
								<path d="M1.32543 1.31381C1.52651 1.11993 1.80429 1 2.11111 1H19.8889C20.1957 1 20.4734 1.11993 20.6746 1.31381M1.32543 1.31381C1.12437 1.50771 1 1.77556 1 2.07143V14.9286C1 15.5203 1.49747 16 2.11111 16H13.2222M1.32543 1.31381L3.22222 3.14292M20.6746 1.31381C20.8757 1.50771 21 1.77556 21 2.07143V14.9286C21 15.5203 20.5026 16 19.8889 16H17.6667M20.6746 1.31381L12.5713 9.12754C11.7034 9.96443 10.2964 9.96443 9.42856 9.12754L6.55556 6.35714" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
							</svg>
						</div>
						<div><?php echo $webinfo->email; ?></div>
					</div>
						<div class="d-block">
							<div class="fs-22 fw-bold text-uppercase"><?php echo display('book_a_table') ?></div>
							<div class="fs-22 fw-bold text_primary"><?php echo $webinfo->phone; ?></div>
						</div>
					</div>
				</div>

				<div class="col-auto col-xl-2">
					<div class="d-xl-block d-none mb-5 mb-lg-0">
						<h4 class="contact_title"><?php echo display('pages') ?></h4>
						<ul class="ps-3">
							<?php
							$footermenu = $this->footermenu;
							foreach ($footermenu as $fmenu) { ?>
								<li>
									<a href="<?php echo base_url() . $fmenu->menu_slug; ?>" class="text-decoration-none pageLink"><?php echo $fmenu->menu_name; ?></a>
								</li><?php 
							} ?>
						</ul>
					</div>
				</div>

				<div class="col-lg-3">
					<div class="d-lg-block d-none mb-5 mb-lg-0">
						<h4 class="contact_title"><?php echo display('opening_time') ?></h4>
						<div class="schedul_footer">
							<?php 
							if (isset($openclosetime)) {
								foreach ($openclosetime as $timeshedule) {
									if ($timeshedule->opentime != "Closed") { ?>
										<div class="d-flex align-items-center mb-2">
											<p class="me-2 font_prata"><strong><?php echo $timeshedule->dayname; ?>: </strong></p>
											<p class="opening-time font_prata"><?php echo $timeshedule->opentime; ?> - <?php echo $timeshedule->closetime; ?></p>
										</div>
									<?php } else { ?>
										<div class="d-flex align-items-center mb-2">
											<p class="me-2 font_prata"><strong><?php echo $timeshedule->dayname; ?>: </strong></p>
											<p class="opening-time font_prata"><?php echo $timeshedule->opentime; ?></p>
										</div>
								<?php }
								} 
							}?>
						</div>
					</div>
				</div>
			</div>
		</div>
    </div>
    <!--End Footer Area-->

	<a href="#0" class="cd-top">
		<i class="ti-arrow-up"></i>
	</a>
	<?php
	$openingtimerv = strtotime($this->settinginfo->reservation_open);
	$closetimerv   = strtotime($this->settinginfo->reservation_close);
	$compareretime = strtotime(date("H:i:s A"));
	if (($compareretime >= $openingtimerv) && ($compareretime < $closetimerv)) {
		$reservationopen = 1;
	} else {
		$reservationopen = 0;
	} ?>
	
	<!-- for whatsapp modules -->
	<?php 
	if ($whatsapp_count == 1) {
		$whatsapp_data = $WhatsApp->row();
		$whatsapp_url  = str_replace("/images/thumbnail.jpg", "", $whatsapp_data->image);
		$wtapp         = $this->db->select('*')->from('whatsapp_settings')->get()->row();
		if ($wtapp->chatenable ?? '' == 1) { ?>
			<div id="WAButton"></div>
			<script type="text/javascript">
				$(function() {
					$('#WAButton').floatingWhatsApp({
						phone: '<?php echo $this->settinginfo->whatsapp_number; ?>', //WhatsApp Business phone number
						headerTitle: '<?php echo display('whatsapp_chat') ?>', //Popup Title
						popupMessage: '<?php echo display('hello,_how_can_we_help_you?') ?>', //Popup Message
						showPopup: true, //Enables popup display
						buttonImage: '<img src="<?php echo base_url() . $whatsapp_url; ?>/images/whatsapp.png" />', //Button Image
						//headerColor: 'crimson', //Custom header color
						//backgroundColor: 'crimson', //Custom background button color
						position: "left" //Position: left | right

					});
				});
			</script> <?php
		}

	} ?>
	<!-- end whatsapp modules -->

	<!--====== SCRIPTS JS ======-->
	<script src="<?php echo base_url(); ?>application/views/themes/<?php echo $acthemename; ?>/assets_web/js/jquery-3.3.1.min.js"></script>
	<script src="<?php echo base_url(); ?>application/views/themes/<?php echo $acthemename; ?>/assets_web/plugins/umd/popper.min.js"></script>
	<script src="<?php echo base_url(); ?>application/views/themes/<?php echo $acthemename; ?>/assets_web/plugins/bootstrap-5.3.2-dist/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url(); ?>application/views/themes/<?php echo $acthemename; ?>/assets_web/plugins/OwlCarousel/owl.carousel.min.js"></script>
	<script src="<?php echo base_url(); ?>application/views/themes/<?php echo $acthemename; ?>/assets_web/plugins/metismenu/metisMenu.min.js"></script>
	<script src="<?php echo base_url(); ?>application/views/themes/<?php echo $acthemename; ?>/assets_web/plugins/select2/select2.min.js"></script>
    <script src="<?php echo base_url(); ?>application/views/themes/<?php echo $acthemename; ?>/assets_web/plugins/flatpickr/flatpickr.js"></script>
    <script src="<?php echo base_url(); ?>application/views/themes/<?php echo $acthemename; ?>/assets_web/plugins/aos/aos.js"></script>
	<script src="<?php echo base_url(); ?>application/views/themes/<?php echo $acthemename; ?>/assets_web/plugins/fancybox/dist/fancybox.js"></script>

	<?php if ($this->settinginfo->site_align == 'RTL') {?>
	<script src="<?php echo base_url(); ?>application/views/themes/<?php echo $acthemename; ?>/assets_web/plugins/bootstrap-4.1.3-dist/js/bootstrap-rtl.js"></script>
	<script src="<?php echo base_url(); ?>application/views/themes/<?php echo $acthemename; ?>/assets_web/js/custom-rtl.js"></script>
	<?php } else { ?>
	<!--===== ACTIVE JS=====-->
	<script src="<?php echo base_url(); ?>application/views/themes/<?php echo $acthemename; ?>/assets_web/js/custom.js"></script>
	<?php } ?>

	<!-- <script src="<?php echo base_url(); ?>application/views/themes/<?php echo $acthemename; ?>/assets_web/js/customescript.js"></script> -->
	<script src="<?php echo base_url(); ?>assets/sweetalert/sweetalert.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>application/views/themes/<?php echo $acthemename; ?>/assets_web/js/exclusive_theme.js"></script>
    
	<script>
		$(document).ready(function () {
			$(".js-example-basic-single").select2();
		});

		flatpickr("#reservation_date, #orderdate", {
			dateFormat: "Y-m-d",
			defaultDate: "today",
			minDate: "today",
		});

		flatpickr("#reservation_time", {
			enableTime: true,
			noCalendar: true,
			dateFormat: "H:i",
		});
    </script>

	<!-- For gallery -->
	<script>
		document.addEventListener("DOMContentLoaded", () => {
			// Fancybox binding
			Fancybox.bind('[data-fancybox="gallery"]', {});

			function applyGalleryLayout() {
				const boxes = document.querySelectorAll(".gallery-img-box");
				boxes.forEach((box, index) => {
					box.classList.remove("span-2-col", "span-3-col", "span-4-col", "span-2-row");

					// Apply your original nth-child pattern dynamically
					if (index + 1 === 1) box.classList.add("span-2-col");
					if (index + 1 === 2) box.classList.add("span-2-col");
					if (index + 1 === 3) box.classList.add("span-4-col");
					if (index + 1 === 5) box.classList.add("span-3-col");
					if (index + 1 === 9) box.classList.add("span-2-row");
				});
			}

			// Initial layout
			applyGalleryLayout();

			// Watch for dynamically added images
			const target = document.querySelector(".gallery-grid");
			if (target) {
				const observer = new MutationObserver(() => {
					applyGalleryLayout();
				});
				observer.observe(target, { childList: true });
			}
		});
	</script>
</body>
</html>