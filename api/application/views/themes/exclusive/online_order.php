<?php
$webinfo         = $this->webinfo;
$activethemeinfo = $this->themeinfo;
$acthemename     = $activethemeinfo->themename;
?>

<div class="modal fade" id="addons" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?php echo display('food_details'); ?></h5>
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

<!--START HERO PART -->
<div class="common-bg position-relative">
    <img class="img-fluid common-bg-img" src="<?php echo base_url(!empty($hero_bg->image) ? $hero_bg->image : 'application/views/themes/' . $theme_name . '/assets_web/images/common-bg.webp'); ?>" alt="" />
    <div class="sect_pad position-relative z-2">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-xl-8">
                    <h1 class="main_title text-white text-center" data-aos="fade-down" data-aos-delay="100"><?php echo $title; ?></h1>
                    <div class="menu-breadcrumb" data-aos="fade-down" data-aos-delay="150">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>"><?php echo display('home') ?></a></li>
                                <li class="breadcrumb-item active" aria-current="page"><?php echo $title; ?></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--END HERO PART -->


<!-- Start Category  -->
<section class="sect_pad bg_soft_primary">
    
    <div class="container-fluid overflow-hidden">
        <div class="row g-4">
            <div class="col-xxl-2"></div>
            <div class="col-lg-9 col-xxl-8">
                <?php
                if ($this->session->flashdata('message')) { ?>
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <?php echo $this->session->flashdata('message') ?>
                        <?php echo $this->session->unset_userdata('message'); ?>
                    </div> <?php 
                }
                if ($this->session->flashdata('exception')) { ?>
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <?php echo $this->session->flashdata('exception') ?>
                        <?php echo $this->session->unset_userdata('exception'); ?>
                    </div> <?php 
                }
                if (validation_errors()) { ?>
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <?php echo validation_errors() ?>
                    </div> <?php 
                } ?>

                <div class="d-flex flex-wrap justify-content-center justify-content-md-between align-items-center gap-3 mb-4">
                    <h4 class="mb-0"><?php echo display('category_food'); ?></h4>
                    <div class="d-flex gap-2">
                        <?php echo form_open('online-order', 'method="post" class="d-flex gap-1') ?>
                            <input type="text" class="form-control category-search" name="product_name" id="product_name" placeholder="<?php echo display('search_food_item') ?>">
                            
                            <button class=" btn-checkout" type="submit"><i class="ti-search"></i></button>
                        </form>

                        <div class="position-relative hide-menu d-block d-lg-none">
                            <button class="align-items-center cartBtn d-flex justify-content-center nav-link rounded-circle text-center" id="navbarDropdown3" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="20" viewBox="0 0 24 26" fill="none">
                                    <path
                                    d="M17.6219 8.05882H19.2518C20.7138 8.05882 21.9316 9.18445 22.0531 10.6479L22.9901 21.942C23.1267 23.5881 21.8334 25 20.1888 25H3.81114C2.16662 25 0.873334 23.5881 1.0099 21.942L1.94689 10.6479C2.0683 9.18445 3.28618 8.05882 4.74813 8.05882H6.3781M17.6219 8.05882H6.3781M17.6219 8.05882V6.64706C17.6219 5.14936 17.0296 3.71302 15.9752 2.65398C14.921 1.59496 13.4911 1 12 1C10.5089 1 9.07902 1.59496 8.02471 2.65398C6.9704 3.71302 6.3781 5.14936 6.3781 6.64706V8.05882M17.6219 8.05882V13.7059M6.3781 8.05882V13.7059"
                                    stroke="#c09342"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    />
                                </svg>
                                <!-- <span class="position-absolute start-100 translate-middle badge notification-badge">2</span> -->
                            </button>

                            <div class="cart_box" aria-labelledby="navbarDropdown3">
                                <div class="cart-box" id="cartitem-small">
                                    <div class="d-flex align-items-center justify-content-between gap-3 mb-3">
                                        <h4 class="mb-0"><?php echo display('cart') ?></h4>
                                    </div>
                                    <?php
                                    $calvat       = 0;
                                    $discount     = 0;
                                    $itemtotal    = 0;
                                    $pvat         = 0;
                                    $multiplletax = [];

                                    if ($cart = $this->cart->contents()) {
                                        $i           = 0;
                                        $totalamount = 0;
                                        $subtotal    = 0;
                                        $pvat        = 0;

                                        foreach ($cart as $item) {
                                            $itemprice        = $item['price'] * $item['qty'];
                                            $iteminfo         = $this->hungry_model->getiteminfo($item['pid']);
                                            $mypdiscountprice = 0;

                                            if (!empty($taxinfos)) {
                                                $tx = 0;

                                                if ($iteminfo->OffersRate > 0) {
                                                    $mypdiscountprice = $iteminfo->OffersRate * $itemprice / 100;
                                                }

                                                $itemvalprice = ($itemprice - $mypdiscountprice);

                                                foreach ($taxinfos as $taxinfo) {
                                                    $fildname = 'tax' . $tx;

                                                    if (!empty($iteminfo->$fildname)) {
                                                        $vatcalc                 = $itemvalprice * $iteminfo->$fildname / 100;
                                                        $multiplletax[$fildname] = @$multiplletax[$fildname] + $vatcalc;
                                                    } else {
                                                        $vatcalc                 = $itemvalprice * $taxinfo['default_value'] / 100;
                                                        $multiplletax[$fildname] = @$multiplletax[$fildname] + $vatcalc;
                                                    }

                                                    $pvat    = $pvat + $vatcalc;
                                                    $vatcalc = 0;
                                                    $tx++;
                                                }

                                            } else {
                                                $vatcalc = $itemprice * $iteminfo->productvat / 100;
                                                $pvat    = $pvat + $vatcalc;
                                            }

                                            if ($iteminfo->OffersRate > 0) {
                                                $discal   = $itemprice * $iteminfo->OffersRate / 100;
                                                $discount = $discal + $discount;
                                            } else {
                                                $discal   = 0;
                                                $discount = $discount;
                                            }

                                            if (!empty($item['addonsid'])) {
                                                $nittotal  = $item['addontpr'];
                                                $itemprice = $itemprice + $item['addontpr'];
                                            } else {
                                                $nittotal  = 0;
                                                $itemprice = $itemprice;
                                            }

                                            $totalamount = $totalamount + $nittotal;
                                            $subtotal    = $subtotal - $discal + $item['price'] * $item['qty'];
                                            $i++;
                                            ?>

                                            <div class="cart-item align-item-">
                                                <img src="<?php echo base_url(!empty($iteminfo->small_thumb) ? $iteminfo->small_thumb : 'assets/img/no-image.png'); ?>" alt="<?php echo $item['name']; ?>" />
                                                <div class="flex-grow-1">
                                                    <div><?php echo $item['name']; ?><br><small><?php echo $item['size']; ?></small></div>
                                                    <small class="text_primary">
                                                        <?php echo $item['qty']; ?> X
                                                        <?php if ($this->storecurrency->position == 1) { echo $this->storecurrency->curr_icon; } ?>
                                                        <?php echo $item['price']; ?>
                                                        <?php if ($this->storecurrency->position == 2) { echo $this->storecurrency->curr_icon; } ?>
                                                    </small>
                                                </div>
                                                <a href="javascript:void(0)" onclick="removecart('<?php echo $item['rowid']; ?>')">
                                                    <svg width="21" height="24" viewBox="0 0 21 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M12.3105 17.8638V11.9283C12.3105 11.5677 12.6348 11.2754 13.0347 11.2754C13.4346 11.2754 13.7588 11.5677 13.7588 11.9283V17.8638C13.7588 18.2244 13.4346 18.5168 13.0347 18.5168C12.6348 18.5168 12.3106 18.2244 12.3105 17.8638Z" fill="#FF4646" />
                                                    <path d="M7.96484 17.8638V11.9283C7.96484 11.5677 8.28905 11.2754 8.68898 11.2754C9.08891 11.2754 9.41312 11.5677 9.41312 11.9283V17.8638C9.41311 18.2244 9.08891 18.5168 8.68898 18.5168C8.28905 18.5168 7.96485 18.2244 7.96484 17.8638Z" fill="#FF4646" />
                                                    <path d="M20.3245 5.48242C20.6976 5.48242 21 5.80663 21 6.20656C21 6.60649 20.6976 6.9307 20.3245 6.9307H0.675495C0.302429 6.9307 0 6.60649 0 6.20656C0 5.80663 0.302429 5.48242 0.675495 5.48242H20.3245Z" fill="#FF4646" />
                                                    <path d="M2.89648 19.3371V9.76181C2.89648 9.39821 3.19597 9.10345 3.5654 9.10345C3.93483 9.10345 4.23431 9.39821 4.23431 9.76181V19.3371C4.23432 20.9567 5.56823 22.2695 7.2137 22.2695H14.5103C16.1558 22.2695 17.4897 20.9567 17.4897 19.3371V9.76181C17.4897 9.39821 17.7892 9.10345 18.1586 9.10345C18.528 9.10345 18.8275 9.39821 18.8275 9.76181V19.3371C18.8275 21.6839 16.8947 23.5862 14.5103 23.5862H7.2137C4.82938 23.5862 2.89649 21.6839 2.89648 19.3371Z" fill="#FF4646" />
                                                    <path d="M13.8608 3.6727C13.8608 2.6494 13.0664 1.81984 12.0863 1.81984H9.63854C8.65848 1.81984 7.86396 2.6494 7.86396 3.6727V5.52552H13.8608V3.6727ZM15.2072 6.22841C15.2072 6.61661 14.9058 6.9313 14.534 6.9313H7.19077C6.81898 6.9313 6.51758 6.61661 6.51758 6.22841V3.6727C6.51758 1.87301 7.91489 0.414062 9.63854 0.414062H12.0863C13.81 0.414062 15.2072 1.87302 15.2072 3.6727V6.22841Z" fill="#FF4646" />
                                                    </svg>
                                                </a>
                                            </div>
                                            <?php
                                        }
                                        $itemtotal = $totalamount + $subtotal; 
                                        if (empty($taxinfos)) {
                                            if ($this->settinginfo->vat > 0) {
                                                $calvat = $itemtotal * $this->settinginfo->vat / 100;
                                            } else {
                                                $calvat = $pvat;
                                            }
                                        } else {
                                            $calvat = $pvat;
                                        }

                                        $multiplletaxvalue = htmlentities(serialize($multiplletax));
                                        ?>

                                        <div class="cart-summary mt-3">
                                            <div class="d-flex mb-3 pb-3 border_bottom1 justify-content-between">
                                                <span><?php echo display('subtotal') ?></span>
                                                <span>
                                                    <?php if ($this->storecurrency->position == 1) { echo $this->storecurrency->curr_icon; } ?>
                                                    <?php echo $itemtotal; ?>
                                                    <?php if ($this->storecurrency->position == 2) { echo $this->storecurrency->curr_icon; } ?>
                                                </span>
                                            </div>
                                            <div class="d-flex mb-3 pb-3 border_bottom1 justify-content-between">
                                                <span><?php echo display('vat') ?></span>
                                                <span>
                                                    <?php if ($this->storecurrency->position == 1) { echo $this->storecurrency->curr_icon; } ?>
                                                    <?php echo $calvat; ?>
                                                    <?php if ($this->storecurrency->position == 2) { echo $this->storecurrency->curr_icon; } ?>
                                                </span>
                                            </div>
                                            <div class="d-flex mb-3 pb-3 border_bottom1 justify-content-between">
                                                <span><?php echo display('discount') ?></span>
                                                <span>
                                                    <?php if ($this->storecurrency->position == 1) { echo $this->storecurrency->curr_icon; } ?>
                                                    <?php echo $discount; ?>
                                                    <?php if ($this->storecurrency->position == 2) { echo $this->storecurrency->curr_icon; } ?>
                                                </span>
                                            </div>
                                            <div class="d-flex mb-3 pb-3 border_bottom1 justify-content-between">
                                                <span><?php echo display('total') ?></span>
                                                <span>
                                                    <?php if ($this->storecurrency->position == 1) { echo $this->storecurrency->curr_icon; } ?>
                                                    <?php
                                                    $isvatinclusive = $this->db->select("*")->from('setting')->get()->row();
                                                    if ($isvatinclusive->isvatinclusive == 1) {
                                                        echo $itemtotal - $discount;
                                                    } else {
                                                        echo $calvat + $itemtotal - $discount;
                                                    }
                                                    ?>
                                                    <?php if ($this->storecurrency->position == 2) { echo $this->storecurrency->curr_icon; } ?>
                                                </span>
                                            </div>
                                        </div>

                                        <a href="<?php echo base_url(); ?>cart" class="btn-checkout mt-3">
                                            <svg width="20" height="17" viewBox="0 0 20 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                d="M19.4141 6.45312H16.1523L13.8086 3.32812C13.8997 3.1849 13.9714 3.0319 14.0234 2.86914C14.0755 2.70638 14.1016 2.53385 14.1016 2.35156C14.1016 1.86979 13.929 1.45638 13.584 1.11133C13.2389 0.766275 12.8255 0.59375 12.3438 0.59375C11.862 0.59375 11.4486 0.766275 11.1035 1.11133C10.7585 1.45638 10.5859 1.86979 10.5859 2.35156C10.5859 2.84635 10.7585 3.26302 11.1035 3.60156C11.4486 3.9401 11.862 4.10938 12.3438 4.10938C12.4349 4.10938 12.5228 4.10286 12.6074 4.08984C12.6921 4.07682 12.7799 4.05729 12.8711 4.03125L14.6875 6.45312H5.3125L7.12891 4.03125C7.22005 4.05729 7.30794 4.07682 7.39258 4.08984C7.47721 4.10286 7.5651 4.10938 7.65625 4.10938C8.13802 4.10938 8.55143 3.9401 8.89648 3.60156C9.24154 3.26302 9.41406 2.84635 9.41406 2.35156C9.41406 1.86979 9.24154 1.45638 8.89648 1.11133C8.55143 0.766275 8.13802 0.59375 7.65625 0.59375C7.17448 0.59375 6.76107 0.766275 6.41602 1.11133C6.07096 1.45638 5.89844 1.86979 5.89844 2.35156C5.89844 2.53385 5.92448 2.70638 5.97656 2.86914C6.02865 3.0319 6.10026 3.1849 6.19141 3.32812L3.84766 6.45312H0.585938C0.429688 6.45312 0.292969 6.51172 0.175781 6.62891C0.0585938 6.74609 0 6.88281 0 7.03906C0 7.20833 0.0585938 7.34831 0.175781 7.45898C0.292969 7.56966 0.429688 7.625 0.585938 7.625H1.34766L1.64062 8.79688H18.3594L18.6523 7.625H19.4141C19.5703 7.625 19.707 7.56966 19.8242 7.45898C19.9414 7.34831 20 7.20833 20 7.03906C20 6.88281 19.9414 6.74609 19.8242 6.62891C19.707 6.51172 19.5703 6.45312 19.4141 6.45312ZM11.7578 2.35156C11.7578 2.19531 11.8164 2.05859 11.9336 1.94141C12.0508 1.82422 12.1875 1.76562 12.3438 1.76562C12.5 1.76562 12.6367 1.82422 12.7539 1.94141C12.8711 2.05859 12.9297 2.19531 12.9297 2.35156C12.9297 2.52083 12.8711 2.66081 12.7539 2.77148C12.6367 2.88216 12.5 2.9375 12.3438 2.9375C12.1875 2.9375 12.0508 2.88216 11.9336 2.77148C11.8164 2.66081 11.7578 2.52083 11.7578 2.35156ZM7.65625 1.76562C7.8125 1.76562 7.94922 1.82422 8.06641 1.94141C8.18359 2.05859 8.24219 2.19531 8.24219 2.35156C8.24219 2.52083 8.18359 2.66081 8.06641 2.77148C7.94922 2.88216 7.8125 2.9375 7.65625 2.9375C7.5 2.9375 7.36328 2.88216 7.24609 2.77148C7.12891 2.66081 7.07031 2.52083 7.07031 2.35156C7.07031 2.19531 7.12891 2.05859 7.24609 1.94141C7.36328 1.82422 7.5 1.76562 7.65625 1.76562ZM3.35938 15.6719C3.45052 16.0625 3.6556 16.3815 3.97461 16.6289C4.29362 16.8763 4.65495 17 5.05859 17H14.9414C15.3451 17 15.7064 16.8763 16.0254 16.6289C16.3444 16.3815 16.5495 16.0625 16.6406 15.6719L18.0664 9.96875H1.93359L3.35938 15.6719ZM12.9297 11.7266C12.9297 11.5703 12.9883 11.4336 13.1055 11.3164C13.2227 11.1992 13.3594 11.1406 13.5156 11.1406C13.6719 11.1406 13.8086 11.1992 13.9258 11.3164C14.043 11.4336 14.1016 11.5703 14.1016 11.7266V15.2422C14.1016 15.4115 14.043 15.5514 13.9258 15.6621C13.8086 15.7728 13.6719 15.8281 13.5156 15.8281C13.3594 15.8281 13.2227 15.7728 13.1055 15.6621C12.9883 15.5514 12.9297 15.4115 12.9297 15.2422V11.7266ZM9.41406 11.7266C9.41406 11.5703 9.47266 11.4336 9.58984 11.3164C9.70703 11.1992 9.84375 11.1406 10 11.1406C10.1562 11.1406 10.293 11.1992 10.4102 11.3164C10.5273 11.4336 10.5859 11.5703 10.5859 11.7266V15.2422C10.5859 15.4115 10.5273 15.5514 10.4102 15.6621C10.293 15.7728 10.1562 15.8281 10 15.8281C9.84375 15.8281 9.70703 15.7728 9.58984 15.6621C9.47266 15.5514 9.41406 15.4115 9.41406 15.2422V11.7266ZM5.89844 11.7266C5.89844 11.5703 5.95703 11.4336 6.07422 11.3164C6.19141 11.1992 6.32812 11.1406 6.48438 11.1406C6.64062 11.1406 6.77734 11.1992 6.89453 11.3164C7.01172 11.4336 7.07031 11.5703 7.07031 11.7266V15.2422C7.07031 15.4115 7.01172 15.5514 6.89453 15.6621C6.77734 15.7728 6.64062 15.8281 6.48438 15.8281C6.32812 15.8281 6.19141 15.7728 6.07422 15.6621C5.95703 15.5514 5.89844 15.4115 5.89844 15.2422V11.7266Z"
                                                fill="white"
                                                />
                                            </svg>
                                            <?php echo display('go_to_checkout') ?>
                                        </a>
                                        <?php
                                    } ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="category-wrapper mb-4">
                    <div class="scroll-btn left hidden"><i class="fa fa-chevron-left"></i></div>
                    <ul class="category-scroll nav nav-tabs" id="productTab" role="tablist">
                        <li class="nav-item">
                            <a href="javascript:void(0)" class="nav-link" onclick="searchmenu('all')"><?php echo display('all_items'); ?></a>
                        </li>

                        <?php 
                        foreach ($categorylist as $category) {
                            $Productsnum   = "SELECT Count(CategoryID) as totalcat FROM item_foods Where CategoryID={$category->CategoryID}";
                            $pnumQuery     = $this->db->query($Productsnum);
                            $pnumResult    = $pnumQuery->row();
                            $ProdcutQTY    = $pnumResult->totalcat; ?>

                            <li class="nav-item">
                                <a href="javascript:void(0)" class="nav-link" onclick="searchmenu('<?php echo $category->CategoryID; ?>')" id="<?php echo $category->Name; ?>-tab" data-bs-toggle="tab" role="tab"><?php echo $category->Name; ?> (<?php echo $ProdcutQTY; ?>)</a>
                            </li>
                            <?php
                        } ?>
                    </ul>
                    <div class="scroll-btn right"><i class="fa fa-chevron-right"></i></div>
                </div>

                <div class="tab-content" id="productTabContent">
                    <div id="loaditem">
                        <div class="row g-3">

                            <?php
                            if (!empty($searchresult)) {
                                $id = 0;

                                foreach ($searchresult as $menuitem) {
                                    $menuitem = (object) $menuitem;
                                    $id++;
                                    $this->db->select('*');
                                    $this->db->from('menu_add_on');
                                    $this->db->where('menu_id', $menuitem->ProductsID);
                                    $query    = $this->db->get();
                                    $getadons = "";

                                    if ($query->num_rows() > 0) {
                                        $getadons = 1;
                                    } else {
                                        $getadons = 0;
                                    }

                                    $dayname = date('l');
                                    $this->db->select('*');
                                    $this->db->from('foodvariable');
                                    $this->db->where('foodid', $menuitem->ProductsID);
                                    $this->db->where('availday', $dayname);
                                    $query      = $this->db->get();
                                    $avail      = $query->row();
                                    $availavail = '';
                                    $addtocart  = 1;

                                    if (!empty($avail)) {
                                        $availabletime = explode("-", $avail->availtime);
                                        $deltime1      = strtotime($availabletime[0]);
                                        $deltime2      = strtotime($availabletime[1]);
                                        $Time1         = date("h:i:s A", $deltime1);
                                        $Time2         = date("h:i:s A", $deltime2);
                                        $curtime       = date("h:i:s A");
                                        $gettime       = strtotime(date("h:i:s A"));

                                        if (($gettime > $deltime1) && ($gettime < $deltime2)) {
                                            $availavail = '';
                                            $addtocart  = 1;
                                        } else {
                                            $availavail = '<h6>Unavailable</h6>';
                                            $addtocart  = 0;
                                        }

                                    } ?>

                                    <!-- Product Card Starat -->
                                    <div class="col-md-6 col-lg-12 col-xl-6">
                                        <div id="snackbar<?php echo $id; ?>" class="snackbar"><?php echo display('item_has_been_successfully_added') ?></div>

                                        <div class="product-card d-flex flex-column flex-lg-row align-items-center gap-4">
                                            <div class="online-order-img">
                                            <img class="w-sm-100" src="<?php echo base_url(!empty($menuitem->medium_thumb) ? $menuitem->medium_thumb : 'assets/img/no-image.png'); ?>" alt="<?php echo $menuitem->ProductName ?>" />
                                            </div>
                                            <div class="w-100">
                                                <a href="<?php echo base_url() . 'details/' . $menuitem->ProductsID . '/' . $menuitem->variantid; ?>" class="d-block fs-22 text-center text-lg-start"><?php echo $menuitem->ProductName ?></a>

                                                <?php 
                                                $ratingp = $this->hungry_model->read_average('tbl_rating', 'rating', 'proid', $menuitem->ProductsID);
                                                $count = $this->db->where('proid', $menuitem->ProductsID)->count_all_results('tbl_rating');
                                                if (!empty($ratingp)) {
                                                    $averagerating = round(number_format($ratingp->averagerating ?? 0, 1)); ?>

                                                    <div class="d-flex gap-1 align-items-center justify-content-center justify-content-lg-start mb-3">
                                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                                            <?php if ($i <= $averagerating): ?>
                                                                <!-- Filled star -->
                                                                <svg width="16" height="15" viewBox="0 0 16 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M7.97625 11.1565L12.4169 14.3887L10.7306 9.1189L15.1713 5.99919H9.775L7.97625 0.602939L6.1775 5.99919H0.78125L5.22191 9.1189L3.53559 14.3887L7.97625 11.1565Z" fill="#C3C3C3" />
                                                                </svg>
                                                            <?php else: ?>
                                                                <!-- Outline star -->
                                                                <svg width="16" height="15" viewBox="0 0 16 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M7.97625 11.1565L12.4169 14.3887L10.7306 9.1189L15.1713 5.99919H9.775L7.97625 0.602939L6.1775 5.99919H0.78125L5.22191 9.1189L3.53559 14.3887L7.97625 11.1565Z" fill="none" stroke="#C3C3C3" stroke-width="1.5" stroke-linejoin="round" />
                                                                </svg>
                                                            <?php endif; ?>
                                                        <?php endfor; ?>

                                                        <span class="text-color2 fs-14">(<?php echo $count; ?>)</span>
                                                    </div> 
                                                <?php } ?>

                                                <div class="fs-20 font_prata text_primary text-center text-lg-start mb-2">
                                                    <?php if ($this->storecurrency->position == 1) { echo $this->storecurrency->curr_icon; } ?>
                                                    <?php echo $menuitem->price; ?>
                                                    <?php if ($this->storecurrency->position == 2) { echo $this->storecurrency->curr_icon; } ?>
                                                </div>

                                                <?php
                                                if ($addtocart == 1) {

                                                    if ($getadons == 0 && $menuitem->totalvarient == 1) { ?>
                                                        <div class="d-flex align-items-center mt-2">
                                                            <input name="sizeid" type="hidden" id="sizeid_<?php echo $id; ?>other" value="<?php echo $menuitem->variantid; ?>" />
                                                            <input type="hidden" name="catid" id="catid_<?php echo $id; ?>other" value="<?php echo $menuitem->CategoryID; ?>">
                                                            <input type="hidden" name="itemname" id="itemname_<?php echo $id; ?>other" value="<?php echo $menuitem->ProductName; ?>">
                                                            <input type="hidden" name="varient" id="varient_<?php echo $id; ?>other" value="<?php echo $menuitem->variantName; ?>">
                                                            <input type="hidden" name="cartpage" id="cartpage_<?php echo $id; ?>other" value="0">
                                                            <input name="itemprice" type="hidden" value="<?php echo $menuitem->price; ?>" id="itemprice_<?php echo $id; ?>other" />

                                                            <div class="d-flex align-items-center justify-content-center justify-content-lg-between gap-3">
                                                                <a onclick="addtocartitem(<?php echo $menuitem->ProductsID; ?>,<?php echo $id; ?>,'other')" class="add-cart-btn" href="javascript:void(0)"><i class="fa fa-shopping-basket"></i> <?php echo display('add_to_cart') ?></a>

                                                                <div class="qty-control">
                                                                    <button onclick="var result = document.getElementById('sst6<?php echo $id; ?>_other'); var sst = result.value; if( !isNaN( sst ) &amp;&amp; sst > 0 ) result.value--;return false;" class="btn-minus" type="button">
                                                                        -
                                                                    </button>

                                                                    <input type="text" name="qty" id="sst6<?php echo $id; ?>_other" maxlength="12" value="1" title="Quantity:" class="cart-input-qty">

                                                                    <button onclick="var result = document.getElementById('sst6<?php echo $id; ?>_other'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;" class="btn-plus" type="button">
                                                                        +
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>

                                                 <?php } else {?>
                                                 
                                                        <div class="d-flex align-items-center justify-content-center justify-content-lg-between gap-3">
                                                            <a onclick="addonsitem(<?php echo $menuitem->ProductsID; ?>,<?php echo $menuitem->variantid; ?>,'other')" class="add-cart-btn ws-nowrap" data-toggle="modal" data-target="#addons" data-dismiss="modal" href="javascript:void(0)"><i class="fa fa-shopping-basket"></i> <?php echo display('add_to_cart') ?></a>

                                                            <div class="qty-control">
                                                                <button onclick="var result = document.getElementById('sst6<?php echo $id; ?>_other'); var sst = result.value; if( !isNaN( sst ) &amp;&amp; sst >= 1 ) result.value--;return false;" class="btn-minus" type="button">
                                                                    -
                                                                </button>
                                                                <input type="text" name="qty" id="sst6<?php echo $id; ?>_other" maxlength="12" value="1" title="Quantity:" class="cart-input-qty">

                                                                <button onclick="var result = document.getElementById('sst6<?php echo $id; ?>_other'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;" class="btn-plus" type="button">
                                                                    +
                                                                </button>
                                                            </div>
                                                        </div>
                                                   
                                             <?php }

                                            } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Product Card End -->
                                    <?php
                                }
                            } ?>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-lg-3 col-xxl-2 d-none d-lg-block">
                <div class="cart-box" id="cartitem">
                    <div class="d-flex align-items-center justify-content-between gap-3 mb-3">
                        <h4 class="mb-0"><?php echo display('cart') ?></h4>
                    </div>

                    <?php
                    $calvat       = 0;
                    $discount     = 0;
                    $itemtotal    = 0;
                    $pvat         = 0;
                    $multiplletax = [];

                    if ($cart = $this->cart->contents()) {
                        $i           = 0;
                        $totalamount = 0;
                        $subtotal    = 0;
                        $pvat        = 0;

                        foreach ($cart as $item) {
                            $itemprice        = $item['price'] * $item['qty'];
                            $iteminfo         = $this->hungry_model->getiteminfo($item['pid']);
                            $mypdiscountprice = 0;

                            if (!empty($taxinfos)) {
                                $tx = 0;

                                if ($iteminfo->OffersRate > 0) {
                                    $mypdiscountprice = $iteminfo->OffersRate * $itemprice / 100;
                                }

                                $itemvalprice = ($itemprice - $mypdiscountprice);

                                foreach ($taxinfos as $taxinfo) {
                                    $fildname = 'tax' . $tx;

                                    if (!empty($iteminfo->$fildname)) {
                                        $vatcalc                 = $itemvalprice * $iteminfo->$fildname / 100;
                                        $multiplletax[$fildname] = @$multiplletax[$fildname] + $vatcalc;
                                    } else {
                                        $vatcalc                 = $itemvalprice * $taxinfo['default_value'] / 100;
                                        $multiplletax[$fildname] = @$multiplletax[$fildname] + $vatcalc;
                                    }

                                    $pvat    = $pvat + $vatcalc;
                                    $vatcalc = 0;
                                    $tx++;
                                }

                            } else {
                                $vatcalc = $itemprice * $iteminfo->productvat / 100;
                                $pvat    = $pvat + $vatcalc;
                            }

                            if ($iteminfo->OffersRate > 0) {
                                $discal   = $itemprice * $iteminfo->OffersRate / 100;
                                $discount = $discal + $discount;
                            } else {
                                $discal   = 0;
                                $discount = $discount;
                            }

                            if (!empty($item['addonsid'])) {
                                $nittotal  = $item['addontpr'];
                                $itemprice = $itemprice + $item['addontpr'];
                            } else {
                                $nittotal  = 0;
                                $itemprice = $itemprice;
                            }

                            $totalamount = $totalamount + $nittotal;
                            $subtotal    = $subtotal - $discal + $item['price'] * $item['qty'];
                            $i++;
                            ?>

                            <div class="cart-item align-item-">
                                <img src="<?php echo base_url(!empty($iteminfo->small_thumb) ? $iteminfo->small_thumb : 'assets/img/no-image.png'); ?>" alt="<?php echo $item['name']; ?>" />
                                <div class="flex-grow-1">
                                    <div><?php echo $item['name']; ?><br><small><?php echo $item['size']; ?></small></div>
                                    <small class="text_primary">
                                        <?php echo $item['qty']; ?> X
                                        <?php if ($this->storecurrency->position == 1) { echo $this->storecurrency->curr_icon; } ?>
                                        <?php echo $item['price']; ?>
                                        <?php if ($this->storecurrency->position == 2) { echo $this->storecurrency->curr_icon; } ?>
                                    </small>
                                </div>
                                <a href="javascript:void(0)" onclick="removecart('<?php echo $item['rowid']; ?>')">
                                    <svg width="21" height="24" viewBox="0 0 21 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12.3105 17.8638V11.9283C12.3105 11.5677 12.6348 11.2754 13.0347 11.2754C13.4346 11.2754 13.7588 11.5677 13.7588 11.9283V17.8638C13.7588 18.2244 13.4346 18.5168 13.0347 18.5168C12.6348 18.5168 12.3106 18.2244 12.3105 17.8638Z" fill="#FF4646" />
                                    <path d="M7.96484 17.8638V11.9283C7.96484 11.5677 8.28905 11.2754 8.68898 11.2754C9.08891 11.2754 9.41312 11.5677 9.41312 11.9283V17.8638C9.41311 18.2244 9.08891 18.5168 8.68898 18.5168C8.28905 18.5168 7.96485 18.2244 7.96484 17.8638Z" fill="#FF4646" />
                                    <path d="M20.3245 5.48242C20.6976 5.48242 21 5.80663 21 6.20656C21 6.60649 20.6976 6.9307 20.3245 6.9307H0.675495C0.302429 6.9307 0 6.60649 0 6.20656C0 5.80663 0.302429 5.48242 0.675495 5.48242H20.3245Z" fill="#FF4646" />
                                    <path d="M2.89648 19.3371V9.76181C2.89648 9.39821 3.19597 9.10345 3.5654 9.10345C3.93483 9.10345 4.23431 9.39821 4.23431 9.76181V19.3371C4.23432 20.9567 5.56823 22.2695 7.2137 22.2695H14.5103C16.1558 22.2695 17.4897 20.9567 17.4897 19.3371V9.76181C17.4897 9.39821 17.7892 9.10345 18.1586 9.10345C18.528 9.10345 18.8275 9.39821 18.8275 9.76181V19.3371C18.8275 21.6839 16.8947 23.5862 14.5103 23.5862H7.2137C4.82938 23.5862 2.89649 21.6839 2.89648 19.3371Z" fill="#FF4646" />
                                    <path d="M13.8608 3.6727C13.8608 2.6494 13.0664 1.81984 12.0863 1.81984H9.63854C8.65848 1.81984 7.86396 2.6494 7.86396 3.6727V5.52552H13.8608V3.6727ZM15.2072 6.22841C15.2072 6.61661 14.9058 6.9313 14.534 6.9313H7.19077C6.81898 6.9313 6.51758 6.61661 6.51758 6.22841V3.6727C6.51758 1.87301 7.91489 0.414062 9.63854 0.414062H12.0863C13.81 0.414062 15.2072 1.87302 15.2072 3.6727V6.22841Z" fill="#FF4646" />
                                    </svg>
                                </a>
                            </div>
                            <?php
                        }
                        $itemtotal = $totalamount + $subtotal; 
                        if (empty($taxinfos)) {
                            if ($this->settinginfo->vat > 0) {
                                $calvat = $itemtotal * $this->settinginfo->vat / 100;
                            } else {
                                $calvat = $pvat;
                            }
                        } else {
                            $calvat = $pvat;
                        }

                        $multiplletaxvalue = htmlentities(serialize($multiplletax));
                        ?>

                        <div class="cart-summary mt-3">
                            <div class="d-flex mb-3 pb-3 border_bottom1 justify-content-between">
                                <span><?php echo display('subtotal') ?></span>
                                <span>
                                    <?php if ($this->storecurrency->position == 1) { echo $this->storecurrency->curr_icon; } ?>
                                    <?php echo $itemtotal; ?>
                                    <?php if ($this->storecurrency->position == 2) { echo $this->storecurrency->curr_icon; } ?>
                                </span>
                            </div>
                            <div class="d-flex mb-3 pb-3 border_bottom1 justify-content-between">
                                <span><?php echo display('vat') ?></span>
                                <span>
                                    <?php if ($this->storecurrency->position == 1) { echo $this->storecurrency->curr_icon; } ?>
                                    <?php echo $calvat; ?>
                                    <?php if ($this->storecurrency->position == 2) { echo $this->storecurrency->curr_icon; } ?>
                                </span>
                            </div>
                            <div class="d-flex mb-3 pb-3 border_bottom1 justify-content-between">
                                <span><?php echo display('discount') ?></span>
                                <span>
                                    <?php if ($this->storecurrency->position == 1) { echo $this->storecurrency->curr_icon; } ?>
                                    <?php echo $discount; ?>
                                    <?php if ($this->storecurrency->position == 2) { echo $this->storecurrency->curr_icon; } ?>
                                </span>
                            </div>
                            <div class="d-flex mb-3 pb-3 border_bottom1 justify-content-between">
                                <span><?php echo display('total') ?></span>
                                <span>
                                    <?php if ($this->storecurrency->position == 1) { echo $this->storecurrency->curr_icon; } ?>
                                    <?php
                                    $isvatinclusive = $this->db->select("*")->from('setting')->get()->row();
                                    if ($isvatinclusive->isvatinclusive == 1) {
                                        echo $itemtotal - $discount;
                                    } else {
                                        echo $calvat + $itemtotal - $discount;
                                    }
                                    ?>
                                    <?php if ($this->storecurrency->position == 2) { echo $this->storecurrency->curr_icon; } ?>
                                </span>
                            </div>
                        </div>

                        <a href="<?php echo base_url(); ?>cart" class="btn-checkout mt-3">
                            <svg width="20" height="17" viewBox="0 0 20 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                d="M19.4141 6.45312H16.1523L13.8086 3.32812C13.8997 3.1849 13.9714 3.0319 14.0234 2.86914C14.0755 2.70638 14.1016 2.53385 14.1016 2.35156C14.1016 1.86979 13.929 1.45638 13.584 1.11133C13.2389 0.766275 12.8255 0.59375 12.3438 0.59375C11.862 0.59375 11.4486 0.766275 11.1035 1.11133C10.7585 1.45638 10.5859 1.86979 10.5859 2.35156C10.5859 2.84635 10.7585 3.26302 11.1035 3.60156C11.4486 3.9401 11.862 4.10938 12.3438 4.10938C12.4349 4.10938 12.5228 4.10286 12.6074 4.08984C12.6921 4.07682 12.7799 4.05729 12.8711 4.03125L14.6875 6.45312H5.3125L7.12891 4.03125C7.22005 4.05729 7.30794 4.07682 7.39258 4.08984C7.47721 4.10286 7.5651 4.10938 7.65625 4.10938C8.13802 4.10938 8.55143 3.9401 8.89648 3.60156C9.24154 3.26302 9.41406 2.84635 9.41406 2.35156C9.41406 1.86979 9.24154 1.45638 8.89648 1.11133C8.55143 0.766275 8.13802 0.59375 7.65625 0.59375C7.17448 0.59375 6.76107 0.766275 6.41602 1.11133C6.07096 1.45638 5.89844 1.86979 5.89844 2.35156C5.89844 2.53385 5.92448 2.70638 5.97656 2.86914C6.02865 3.0319 6.10026 3.1849 6.19141 3.32812L3.84766 6.45312H0.585938C0.429688 6.45312 0.292969 6.51172 0.175781 6.62891C0.0585938 6.74609 0 6.88281 0 7.03906C0 7.20833 0.0585938 7.34831 0.175781 7.45898C0.292969 7.56966 0.429688 7.625 0.585938 7.625H1.34766L1.64062 8.79688H18.3594L18.6523 7.625H19.4141C19.5703 7.625 19.707 7.56966 19.8242 7.45898C19.9414 7.34831 20 7.20833 20 7.03906C20 6.88281 19.9414 6.74609 19.8242 6.62891C19.707 6.51172 19.5703 6.45312 19.4141 6.45312ZM11.7578 2.35156C11.7578 2.19531 11.8164 2.05859 11.9336 1.94141C12.0508 1.82422 12.1875 1.76562 12.3438 1.76562C12.5 1.76562 12.6367 1.82422 12.7539 1.94141C12.8711 2.05859 12.9297 2.19531 12.9297 2.35156C12.9297 2.52083 12.8711 2.66081 12.7539 2.77148C12.6367 2.88216 12.5 2.9375 12.3438 2.9375C12.1875 2.9375 12.0508 2.88216 11.9336 2.77148C11.8164 2.66081 11.7578 2.52083 11.7578 2.35156ZM7.65625 1.76562C7.8125 1.76562 7.94922 1.82422 8.06641 1.94141C8.18359 2.05859 8.24219 2.19531 8.24219 2.35156C8.24219 2.52083 8.18359 2.66081 8.06641 2.77148C7.94922 2.88216 7.8125 2.9375 7.65625 2.9375C7.5 2.9375 7.36328 2.88216 7.24609 2.77148C7.12891 2.66081 7.07031 2.52083 7.07031 2.35156C7.07031 2.19531 7.12891 2.05859 7.24609 1.94141C7.36328 1.82422 7.5 1.76562 7.65625 1.76562ZM3.35938 15.6719C3.45052 16.0625 3.6556 16.3815 3.97461 16.6289C4.29362 16.8763 4.65495 17 5.05859 17H14.9414C15.3451 17 15.7064 16.8763 16.0254 16.6289C16.3444 16.3815 16.5495 16.0625 16.6406 15.6719L18.0664 9.96875H1.93359L3.35938 15.6719ZM12.9297 11.7266C12.9297 11.5703 12.9883 11.4336 13.1055 11.3164C13.2227 11.1992 13.3594 11.1406 13.5156 11.1406C13.6719 11.1406 13.8086 11.1992 13.9258 11.3164C14.043 11.4336 14.1016 11.5703 14.1016 11.7266V15.2422C14.1016 15.4115 14.043 15.5514 13.9258 15.6621C13.8086 15.7728 13.6719 15.8281 13.5156 15.8281C13.3594 15.8281 13.2227 15.7728 13.1055 15.6621C12.9883 15.5514 12.9297 15.4115 12.9297 15.2422V11.7266ZM9.41406 11.7266C9.41406 11.5703 9.47266 11.4336 9.58984 11.3164C9.70703 11.1992 9.84375 11.1406 10 11.1406C10.1562 11.1406 10.293 11.1992 10.4102 11.3164C10.5273 11.4336 10.5859 11.5703 10.5859 11.7266V15.2422C10.5859 15.4115 10.5273 15.5514 10.4102 15.6621C10.293 15.7728 10.1562 15.8281 10 15.8281C9.84375 15.8281 9.70703 15.7728 9.58984 15.6621C9.47266 15.5514 9.41406 15.4115 9.41406 15.2422V11.7266ZM5.89844 11.7266C5.89844 11.5703 5.95703 11.4336 6.07422 11.3164C6.19141 11.1992 6.32812 11.1406 6.48438 11.1406C6.64062 11.1406 6.77734 11.1992 6.89453 11.3164C7.01172 11.4336 7.07031 11.5703 7.07031 11.7266V15.2422C7.07031 15.4115 7.01172 15.5514 6.89453 15.6621C6.77734 15.7728 6.64062 15.8281 6.48438 15.8281C6.32812 15.8281 6.19141 15.7728 6.07422 15.6621C5.95703 15.5514 5.89844 15.4115 5.89844 15.2422V11.7266Z"
                                fill="white"
                                />
                            </svg>
                            <?php echo display('go_to_checkout') ?>
                        </a>
                        <?php
                    } ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Category  -->


<script>
    const scrollContainer = document.querySelector(".category-scroll");
    const btnLeft = document.querySelector(".scroll-btn.left");
    const btnRight = document.querySelector(".scroll-btn.right");

    function updateScrollButtons() {
    btnLeft.classList.toggle("hidden", scrollContainer.scrollLeft <= 0);
    btnRight.classList.toggle("hidden", scrollContainer.scrollLeft + scrollContainer.clientWidth >= scrollContainer.scrollWidth - 1);
    }

    btnLeft.addEventListener("click", () => {
    scrollContainer.scrollBy({ left: -150, behavior: "smooth" });
    });
    btnRight.addEventListener("click", () => {
    scrollContainer.scrollBy({ left: 150, behavior: "smooth" });
    });

    scrollContainer.addEventListener("scroll", updateScrollButtons);
    window.addEventListener("resize", updateScrollButtons);

    // Initialize
    updateScrollButtons();

</script>