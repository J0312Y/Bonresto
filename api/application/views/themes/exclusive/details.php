<!--START HERO PART -->
<div class="common-bg position-relative">
    <div class="sect_pad position-relative">
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

<!-- Start Food Details  -->
<?php $iteminfo=(object)$iteminfo;?>

<section class="sect_pad bg_soft_primary">
    <div class="container">
        <div class="card">
            <div class="card-body p-4">
                <div class="row g-4 justify-content-center mb-5">
                    <div class="col-xl-6">
                        <div class="food-details-img">
                            <img src="<?php echo base_url(!empty($iteminfo->bigthumb) ? $iteminfo->bigthumb : 'dummyimage/555x370.jpg'); ?>" alt="" class="<?php echo $iteminfo->ProductName; ?>" />
                        </div>
                    </div>

                    <div class="col-xl-6 mb-5">
                        <?php 
                        if ($iteminfo->special == 1) { ?>
                            <p class="bg_primary mb-2 p-2 rounded-pill d-inline-block text-white fs-14 px-3">
                                <?php echo display('is_special'); ?>
                            </p>
                        <?php } ?>

                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="fs-16"><?php echo display('category')?>: </span>
                            <span class="fs-16 fw-bold"><?php echo $category->Name; ?></span>
                        </div>
                        <h4 class="fs-22 mb-3"><?php echo $iteminfo->ProductName; ?></h4>
                        <div class="custom-control-two mb-3">
                            <select name="varientinfo" class="form-control js-example-basic-single" required id="varientinfodt" style="display:inline; width:50%">
                                <?php foreach($varientlist as $thisvarient){ ?>
                                <option value="<?php echo $thisvarient->variantid;?>"
                                    data-title="<?php echo $thisvarient->variantName;?>"
                                    data-price="<?php echo $thisvarient->price;?>"
                                    <?php if($iteminfo->variantid==$thisvarient->variantid){ echo "selected";}?>>
                                    <?php echo $thisvarient->variantName;?></option>
                                <?php }?>
                            </select>
                        </div>

                        <div class="d-flex flex-column flex-md-row align-items-baseline align-items-md-center gap-2 gap-md-4 mb-3">
                            <?php 
                            $ratingp = $this->hungry_model->read_average('tbl_rating', 'rating', 'proid', $iteminfo->ProductsID);
                            if (!empty($ratingp)) {
                                $averagerating = round(number_format($ratingp->averagerating ?? 0, 1)); ?>

                                <div class="d-flex gap-2 align-items-center">
                                    <div class="d-flex justify-content-center align-items-center gap-2" aria-label="Rating: <?php echo $averagerating; ?> out of 5">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <?php if ($i <= $averagerating): ?>
                                                <!-- Filled star -->
                                                <svg width="16" height="16" viewBox="0 0 22 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M11.09 14.5716L16.3044 17.7188L14.9207 11.7872L19.5275 7.79625L13.461 7.28156L11.09 1.6875L8.71909 7.28156L2.65253 7.79625L7.2594 11.7872L5.87565 17.7188L11.09 14.5716Z" fill="#F08200"/>
                                                </svg>
                                            <?php else: ?>
                                                <!-- Outline star -->
                                                <svg width="16" height="16" viewBox="0 0 22 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M11.09 14.5716L16.3044 17.7188L14.9207 11.7872L19.5275 7.79625L13.461 7.28156L11.09 1.6875L8.71909 7.28156L2.65253 7.79625L7.2594 11.7872L5.87565 17.7188L11.09 14.5716Z"
                                                        fill="none" stroke="#F08200" stroke-width="1.5" stroke-linejoin="round"/>
                                                </svg>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                    </div> 

                                    <span class="text-color2 ms-1 fs-14"><?php echo $averagerating; ?> (<?php echo $totalreview->totalrate.' '.display('review'); ?>)</span></span>
                                </div>
                            <?php } ?>
                        </div>

                        <?php if (!empty($iteminfo->component)) { ?>
                        <div class="details-bg-1 p-4 rounded-3 mb-3">
                            <p class="fw-semibold"><?php echo display('ingredients'); ?></p>
                            <?php echo $iteminfo->component; ?>
                        </div>
                        <?php } ?>

                        <div class="d-flex align-items-center gap-2 mb-3 font_prata">
                            <span class="fs-14"><?php echo display('price'); ?>: </span>
                            <span class="fs-16 fw-semibold">
                                <?php if ($this->storecurrency->position == 1) { echo $this->storecurrency->curr_icon; } ?>
                                <span id="vpricedt"><?php echo $iteminfo->price;?></span>
                                <?php if ($this->storecurrency->position == 2) { echo $this->storecurrency->curr_icon; } ?>
                            </span>
                        </div>

                        <div class="d-flex flex-column flex-md-row align-items-center gap-2">
                            <div class="qty-control py-2 w-sm-100 w-75 justify-content-between">
                                <button
                                    onclick="var result = document.getElementById('sst6999_det'); var sst = result.value; if( !isNaN( sst ) && sst > 0 ) result.value--;return false;"
                                    class="btn-minus" type="button">
                                    -
                                </button>
                                <input type="text" name="qty" id="sst6999_det" maxlength="12" value="1"
                                title="<?php echo display('quantity')?>:" class="qty border-0 text-center">
                                <button
                                    onclick="var result = document.getElementById('sst6999_det'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;"
                                    class="btn-plus" type="button">
                                    +
                                </button>

                                <input name="sizeid" type="hidden" id="sizeid_999det" value="<?php echo $iteminfo->variantid; ?>" />
                                <input type="hidden" name="catid" id="catid_999det" value="<?php echo $iteminfo->CategoryID; ?>">
                                <input type="hidden" name="itemname" id="itemname_999det" value="<?php echo $iteminfo->ProductName; ?>">
                                <input type="hidden" name="varient" id="varient_999det" value="<?php echo $iteminfo->variantName; ?>">
                                <input type="hidden" name="cartpage" id="cartpage_999det" value="0">
                                <input name="itemprice" type="hidden" value="<?php echo $iteminfo->price; ?>" id="itemprice_999det" />
                                <input name="dpid" type="hidden" value="<?php echo $iteminfo->ProductsID; ?>" id="dpid" />
                            </div>
                        
                            <div class="action_btn w-50">
                                <?php 
                                $this->db->select('*');
                                $this->db->from('menu_add_on');
                                $this->db->where('menu_id', $iteminfo->ProductsID);
                                $query = $this->db->get();
                                $getadons = "";
                                if ($query->num_rows() > 0) {
                                    $getadons = 1;
                                } else {
                                    $getadons =  0;
                                }?>
                                <input name="isaddons" type="hidden" value="<?php echo $getadons; ?>" id="isaddons" />
                                <?php 
                                $dayname = date('l');
                                $this->db->select('*');
                                $this->db->from('foodvariable');
                                $this->db->where('foodid', $iteminfo->ProductsID);
                                $this->db->where('availday', $dayname);
                                $query = $this->db->get();
                                $avail = $query->row();
                                $availavail = '';
                                $addtocart = 1;
                                if (!empty($avail)) {
                                    $availabletime = explode("-", $avail->availtime);
                                    $deltime1 = strtotime($availabletime[0]);
                                    $deltime2 = strtotime($availabletime[1]);
                                    $Time1 = date("h:i:s A", $deltime1);
                                    $Time2 = date("h:i:s A", $deltime2);
                                    $curtime = date("h:i:s A");
                                    $gettime = strtotime(date("h:i:s A"));
                                    if (($gettime > $deltime1) && ($gettime < $deltime2)) {
                                        $availavail = '';
                                        $addtocart = 1;
                                    } else {
                                        $availavail = '<h6 class="mt-4">Unavailable</h6>';
                                        $addtocart = 0;
                                    }
                                }
                                if ($addtocart == 1) {
                                    if($getadons == 0) { ?>
                                        <div id="snackbar<?php echo "999"; ?>" class="snackbar">
                                            <?php echo display('item_has_been_successfully_added')?>
                                        </div>
                                        <a onclick="addtocartitem(<?php echo $iteminfo->ProductsID; ?>,999,'det')"
                                            id="chng_<?php echo $iteminfo->ProductsID; ?>"
                                            class="btn btn_primary lh-sm w-100">
                                            <i class="fa fa-shopping-basket me-2"></i><span><?php echo display('add_to_cart')?></span>
                                        </a> 
                                        <?php 
                                    } else { ?>
                                        <div id="snackbar<?php echo "999"; ?>" class="snackbar">
                                            <?php echo display('item_has_been_successfully_added')?>
                                        </div>
                                        <a onclick="addonsitem(<?php echo $iteminfo->ProductsID; ?>,<?php echo $iteminfo->variantid; ?>,'other')"
                                            id="chng_<?php echo $iteminfo->ProductsID; ?>"
                                            class="btn btn_primary lh-sm w-100" data-toggle="modal"
                                            data-target="#addons" data-bs-dismiss="modal">
                                            <i class="fa fa-shopping-basket me-2"></i><span><?php echo display('add_to_cart')?></span>
                                        </a>
                                        <?php 
                                    }
                                } else {
                                    echo $availavail;
                                } ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <ul class="nav d-flex flex-row gap-2 justify-content-center" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="btn btn_secondary active" id="specification-tab"
                                    data-bs-toggle="tab" data-bs-target="#specification"
                                    type="button" role="tab" aria-controls="specification"
                                    aria-selected="true">
                                    <?php echo display('description')?>
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="btn btn_secondary" id="reviews-tab"
                                    data-bs-toggle="tab" data-bs-target="#reviews"
                                    type="button" role="tab" aria-controls="reviews"
                                    aria-selected="false">
                                    <?php echo display('review')?> (<?php echo $totalreview->totalrate; ?>)
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="tab-content details-bg-2 p-4 p-xl-5 rounded-4 mb-5" id="myTabContent">
                
                    <div class="tab-pane fade show active" id="specification" role="tabpanel" aria-labelledby="specification-tab">
                        <?php echo $iteminfo->descrip; ?>
                    </div>

                    <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                        <div class="row pb-3">
                            <div class="col-12">
                                <div class="product_review_right pb-4">
                                    <h4 class="mb-4"><?php echo display('review_rating')?></h4>
                                    <div class="row mb-5">
                                        <div class="col-lg-6">
                                            <div class="rating-block text-center">
                                                <h6><?php echo display('average_user_rating')?></h6>
                                                <div class="rating-point center-block">
                                                    <img src="<?php echo base_url(); ?>application/views/themes/<?php echo $this->themeinfo->themename; ?>/assets_web/images/star.png"
                                                        alt="">
                                                    <h4 class="rating-count">
                                                        <?php echo number_format($average->averagerating ?? 0, 1); ?>
                                                    </h4>
                                                </div>
                                                <div>
                                                    <?php echo $totalrating->totalrate; ?>
                                                    <?php echo display('rating')?> &amp;
                                                </div>
                                                <div>
                                                    <?php echo $totalreview->totalrate; ?>
                                                    <?php echo display('review')?>
                                                </div>
                                            </div>

                                            <div class="reviewer_area mt-4">
                                                <?php 
                                                if (!empty($readreview)) {
                                                    foreach ($readreview as $myreview) { ?>
                                                        <div class="review-block">
                                                            <div class="row m-0 review-block-rate">
                                                                <button type="button" class="btn btn-success btn-sm mb-2"
                                                                    aria-label="Left Align"><?php echo $x = round($myreview->rating / 5) * 5; ?>
                                                                    <i class="ti-star" aria-hidden="true"></i></button>
                                                                <h6 class="ps-0 fw-bold"><?php echo $myreview->title; ?>
                                                                </h6>
                                                            </div>

                                                            <p><?php echo $myreview->reviewtxt; ?></p>
                                                            <div class="review-meta-row">
                                                                <div class="review-meta-inner">
                                                                    <span class="review-block-name mr-4"><?php echo $myreview->name; ?></span>
                                                                    <i class="ti-alarm-clock" aria-hidden="true"></i>
                                                                    <span class="review-block-date"><?php echo $newDate = date("F ,d, Y", strtotime($myreview->ratetime)); ?>
                                                                        <?php echo $Defference = time_elapsed($myreview->ratetime); ?></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php 
                                                    }
                                                } ?>

                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-6">
                                            <div class="rating-position mb-5">
                                                <h6><?php echo display('rating_breakdown')?></h6>
                                                <div class="rating-dimension">
                                                    <div class="rating-quantity">
                                                        <div>5 <i class="ti-star"></i></div>
                                                    </div>
                                                    <div class="rating-percent">
                                                        <div class="progress">
                                                            <div class="progress-bar progress-bar-success"
                                                                role="progressbar" aria-valuenow="5"
                                                                aria-valuemin="0" aria-valuemax="5"
                                                                style="width: 100%">
                                                                <span
                                                                    class="sr-only"><?php echo display('complete_success')?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="user-rating">
                                                        <?php echo $rate5 = $this->db->select('*')->from('tbl_rating')->where('proid', $iteminfo->ProductsID)->where('rating>', 4.4)->get()->num_rows(); ?>
                                                    </div>
                                                </div><!-- /.End of rating dimension -->
                                                <div class="rating-dimension">
                                                    <div class="rating-quantity">
                                                        <div>4 <i class="ti-star"></i></div>
                                                    </div>
                                                    <div class="rating-percent">
                                                        <div class="progress">
                                                            <div class="progress-bar progress-bar-primary"
                                                                role="progressbar" aria-valuenow="5"
                                                                aria-valuemin="0" aria-valuemax="5"
                                                                style="width: 80%">
                                                                <span
                                                                    class="sr-only"><?php echo display('80_complete_primary')?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="user-rating">
                                                        <?php echo $rate4 = $this->db->select('*')->from('tbl_rating')->where('proid', $iteminfo->ProductsID)->where('rating >', 3.4)->where('rating <', 4.5)->get()->num_rows(); ?>
                                                    </div>
                                                </div><!-- /.End of rating dimension -->
                                                <div class="rating-dimension">
                                                    <div class="rating-quantity">
                                                        <div>3 <i class="ti-star"></i></div>
                                                    </div>
                                                    <div class="rating-percent">
                                                        <div class="progress">
                                                            <div class="progress-bar progress-bar-info"
                                                                role="progressbar" aria-valuenow="5"
                                                                aria-valuemin="0" aria-valuemax="5"
                                                                style="width: 60%">
                                                                <span
                                                                    class="sr-only"><?php echo display('60_complete_info')?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="user-rating">
                                                        <?php echo $rate3 = $this->db->select('*')->from('tbl_rating')->where('proid', $iteminfo->ProductsID)->where('rating >', 2.4)->where('rating <', 3.5)->get()->num_rows(); ?>
                                                    </div>
                                                </div><!-- /.End of rating dimension -->
                                                <div class="rating-dimension">
                                                    <div class="rating-quantity">
                                                        <div>2 <i class="ti-star"></i></div>
                                                    </div>
                                                    <div class="rating-percent">
                                                        <div class="progress">
                                                            <div class="progress-bar progress-bar-warning"
                                                                role="progressbar" aria-valuenow="5"
                                                                aria-valuemin="0" aria-valuemax="5"
                                                                style="width: 40%">
                                                                <span
                                                                    class="sr-only"><?php echo display('40_complete_warning')?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="user-rating">
                                                        <?php echo $rate2 = $this->db->select('*')->from('tbl_rating')->where('proid', $iteminfo->ProductsID)->where('rating >', 1.4)->where('rating <', 2.5)->get()->num_rows(); ?>
                                                    </div>
                                                </div><!-- /.End of rating dimension -->
                                                <div class="rating-dimension">
                                                    <div class="rating-quantity">
                                                        <div>1 <i class="ti-star"></i></div>
                                                    </div>
                                                    <div class="rating-percent">
                                                        <div class="progress">
                                                            <div class="progress-bar progress-bar-danger"
                                                                role="progressbar" aria-valuenow="5"
                                                                aria-valuemin="0" aria-valuemax="5"
                                                                style="width: 20%">
                                                                <span
                                                                    class="sr-only"><?php echo display('20_complete_danger')?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="user-rating">
                                                        <?php echo $rate2 = $this->db->select('*')->from('tbl_rating')->where('proid', $iteminfo->ProductsID)->where('rating >', 0)->where('rating <', 1.5)->get()->num_rows(); ?>
                                                    </div>
                                                </div><!-- /.End of rating dimension -->
                                            </div>

                                            <h5 class="mb-4"><?php echo display('write_a_review')?></h5>

                                            <div class="review-content">
                                                <?php if ($this->session->flashdata('message')) { ?>
                                                    <div class="alert alert-success alert-dismissible" role="alert">
                                                        <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="alert"
                                                            aria-label="Close"><span
                                                                aria-hidden="true">&times;</span></button>
                                                        <?php echo $this->session->flashdata('message') ?>
                                                    </div>
                                                <?php } ?>
                                                <?php if ($this->session->flashdata('exception')) { ?>
                                                    <div class="alert alert-danger alert-dismissible" role="alert">
                                                        <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="alert"
                                                            aria-label="Close"><span
                                                                aria-hidden="true">&times;</span></button>
                                                        <?php echo $this->session->flashdata('exception') ?>
                                                    </div>
                                                <?php } ?>
                                                <?php if (validation_errors()) { ?>
                                                    <div class="alert alert-danger alert-dismissible" role="alert">
                                                        <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="alert"
                                                            aria-label="Close"><span
                                                                aria-hidden="true">&times;</span></button>
                                                        <?php echo validation_errors() ?>
                                                    </div>
                                                <?php }

                                                if ($this->session->userdata('CusUserID') == TRUE) {
                                                    if ($isgivenreview == 1) { ?>

                                                        <?php echo form_open('hungry/reviewsubmit','method="post" class="review-form"')?>

                                                        <input type="hidden" id="productid" name="productid"
                                                            value="<?php echo $iteminfo->ProductsID; ?>">
                                                        <input type="hidden" id="varientid" name="varientid"
                                                            value="<?php echo $iteminfo->variantid; ?>">

                                                        <div class="form-group mb-1">
                                                            <label><?php echo display('rate_it')?></label>
                                                            <input type="number" class="form-control" id="rating" name="rating" min="1" step="any" value="5" placeholder="5" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label><?php echo display('title')?></label>
                                                            <input type="text" class="form-control" id="title" name="title"
                                                                required>
                                                        </div>
                                                        <div class="form-group mb-1">
                                                            <label><?php echo display('name')?></label>
                                                            <input type="text" class="form-control" id="name" name="name"
                                                                value="<?php if (!empty($customerinfo)) { echo $customerinfo->customer_name; } ?>"
                                                                readonly="readonly" required>
                                                        </div>
                                                        <div class="form-group mb-1">
                                                            <label><?php echo display('email')?></label>
                                                            <input type="email" class="form-control" id="email" name="email"
                                                                value="<?php if (!empty($customerinfo)) { echo $customerinfo->customer_email; } ?>"
                                                                readonly="readonly" required>
                                                        </div>
                                                        <div class="form-group mb-2">
                                                            <label><?php echo display('review')?></label>
                                                            <textarea class="form-control" rows="5"
                                                                name="review"></textarea>
                                                        </div>
                                                        <button type="submit"
                                                            class="btn btn-success btn-sm"><?php echo display('review_submit')?></button>
                                                        </form>
                                                        <?php 
                                                    }
                                                } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--End Product Review-->
            
                <!--Start Offer Area-->
                <?php if (!empty($related)) { ?>
                <div class="row g-4">
                    <div class="col-12">
                        <h4 class="mb-0"><?php echo display('related_items')?></h4>
                    </div>
                    <?php 
                    $id = 0;
                    foreach ($related as $relateditem) {
                        $relateditem=(object)$relateditem;
                        $id++;
                        $this->db->select('*');
                        $this->db->from('menu_add_on');
                        $this->db->where('menu_id', $relateditem->ProductsID);
                        $query = $this->db->get();
                        $getadons = "";
                        if ($query->num_rows() > 0) {
                            $getadons = 1;
                        } else {
                            $getadons =  0;
                        }
                        $dayname = date('l');
                        $this->db->select('*');
                        $this->db->from('foodvariable');
                        $this->db->where('foodid', $relateditem->ProductsID);
                        $this->db->where('availday', $dayname);
                        $query = $this->db->get();
                        $avail = $query->row();
                        $availavail = '';
                        $addtocart = 1;
                        if(!empty($avail)) {
                            $availabletime = explode("-", $avail->availtime);
                            $deltime1 = strtotime($availabletime[0]);
                            $deltime2 = strtotime($availabletime[1]);
                            $Time1 = date("h:i:s A", $deltime1);
                            $Time2 = date("h:i:s A", $deltime2);
                            $curtime = date("h:i:s A");
                            $gettime = strtotime(date("h:i:s A"));
                            if (($gettime > $deltime1) && ($gettime < $deltime2)) {
                                $availavail = '';
                                $addtocart = 1;
                            } else {
                                $availavail = '<h6 class="mt-4">Unavailable</h6>';
                                $addtocart = 0;
                            }
                        } ?>

                        <div class="col-md-6 col-lg-3">
                            <div class="product-card details-bg-2 d-flex flex-column align-items-center text-center gap-4">
                                <img class="w-100" src="<?php echo base_url(!empty($relateditem->medium_thumb) ? $relateditem->medium_thumb : 'dummyimage/268x223.jpg'); ?>" alt="<?php echo $relateditem->ProductName ?>" />

                                <input name="sizeid" type="hidden" id="sizeid_<?php echo $id; ?>rel"
                                value="<?php echo $relateditem->variantid; ?>" />
                                <input type="hidden" name="qty" id="sst6<?php echo $id; ?>_rel" value="1">
                                <input type="hidden" name="catid" id="catid_<?php echo $id; ?>rel"
                                    value="<?php echo $relateditem->CategoryID; ?>">
                                <input type="hidden" name="itemname" id="itemname_<?php echo $id; ?>rel"
                                    value="<?php echo $relateditem->ProductName; ?>">
                                <input type="hidden" name="varient" id="varient_<?php echo $id; ?>rel"
                                    value="<?php echo $relateditem->variantName; ?>">
                                <input type="hidden" name="cartpage" id="cartpage_<?php echo $id; ?>rel" value="0">
                                <input name="itemprice" type="hidden" value="<?php echo $relateditem->price; ?>"
                                    id="itemprice_<?php echo $id; ?>rel" />

                                <div class="w-100">
                                    <a href="<?php echo base_url() . 'details/' . $relateditem->ProductsID . '/' . $relateditem->variantid; ?>" class="fs-22 item_name"><?php echo $relateditem->ProductName ?></a>

                                    <div class="fs-20 font_prata text_primary mb-2">
                                        <?php if ($this->storecurrency->position == 1) { echo $this->storecurrency->curr_icon; } ?>
                                        <?php echo $relateditem->price; ?>
                                        <?php if ($this->storecurrency->position == 2) { echo $this->storecurrency->curr_icon; } ?>
                                    </div>
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <?php 
                                        if ($addtocart == 1) {
                                            if($getadons == 0 && $relateditem->totalvarient==1) { ?>

                                                <div id="snackbar<?php echo $id; ?>" class="snackbar">
                                                    <?php echo display('item_has_been_successfully_added')?>
                                                </div>
                                                <a onclick="addtocartitem(<?php echo $relateditem->ProductsID; ?>,<?php echo $id; ?>,'rel')" class="btn add-cart-btn">
                                                    <i class="fa fa-shopping-basket me-2"></i>
                                                    <span><?php echo display('add_to_cart')?></span>
                                                </a>
                                                <?php 
                                            } else { ?>
                                                <div id="snackbar<?php echo $id; ?>" class="snackbar">
                                                    <?php echo display('item_has_been_successfully_added')?>
                                                </div>
                                                <a onclick="addonsitem(<?php echo $relateditem->ProductsID; ?>,<?php echo $relateditem->variantid; ?>,'other')" class="btn add-cart-btn" data-toggle="modal" data-target="#addons" data-bs-dismiss="modal">
                                                    <i class="fa fa-shopping-basket me-2"></i>
                                                    <span><?php echo display('add_to_cart')?></span>
                                                </a><?php 
                                            }
                                        } else {
                                            echo $availavail;
                                        } ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php } ?>
                </div>
                <div id="cartitem" style="display:none;"></div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>
<!-- End Food Details  -->

