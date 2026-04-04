<?php
$defaultship = $this->session->userdata('shippingid');
$shiptype = $this->session->userdata('shiptype');
$shippingaddress = $this->session->userdata('shippingaddress');

if ($shiptype == 3) {
    $address = $shippingaddress;
} else {
    $address = $this->settinginfo->address;
}
$intinfo = $this->db->select('*')->from('shipping_method')->where('ship_id', $defaultship)->get()->row();
$slpayment = explode(',', $intinfo->payment_method);
$pvalue = $slpayment[0];
foreach ($slpayment as $checkmethod) {
    if ($checkmethod == 4) {
        $pvalue = 4;
    }
}
?>

<div class="modal fade" id="lostpassword" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-addons">
            <div class="modal-header ps-3 py-1">
                <h1 class="modal-title fs-5" id="exampleModalLabel"><?php echo display('forgot_password') ?></h5>
                <button type="button" class="btn" data-bs-dismiss="modal" aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M2.146 2.146a.5.5 0 0 1 .708 0L8 7.293l5.146-5.147a.5.5 0 0 1 
                        .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 
                        5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854a.5.5 0 0 
                        1 0-.708z"/>
                    </svg>
                </button>
            </div>
            <div class="modal-body passwordupdate">
                <div class="form-group mb-2">
                    <label class="control-label" for="user_email"><?php echo display('email'); ?></label>
                    <input type="text" id="user_email2" class="form-control" name="user_email2">
                </div>
                <a onclick="lostpassword();"
                    class="btn btn-success btn-sm lost-pass"><?php echo display('submit'); ?></a>
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

<!-- Start Checkout Page  -->
<section class="sect_pad bg_soft_primary">
    <div class="container">
        <div class="row g-4">
            <?php if ($this->session->flashdata('exception')) { ?>
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                    <?php echo $this->session->flashdata('exception') ?>
                    <?php echo $this->session->unset_userdata('exception'); ?>
                </div>
            <?php } ?>
            <?php echo form_open('hungry/placeorder', 'method="post" class="row"') ?>
            <div class="col-xl-9">
                <div class="card">
                    <div class="card-body p-4 p-xl-5">
                        <?php if (empty($this->session->userdata('CusUserID'))) { ?>
                            <div class="accordion mb-3 border-bottom" id="accordionExample">
                                <div class="">
                                    <h4 class="fs-24 d-flex gap-2"><?php echo display('returning_customer') ?>
                                        <a class="d-flex align-items-center gap-2 text-decoration-none"
                                            data-bs-toggle="collapse"
                                            href="#collapseOne"
                                            aria-expanded="false"
                                            aria-controls="collapseOne">
                                            <span class="text-primary"><?php echo display('click_login') ?></span>
                                        </a>
                                    </h4>

                                    <div id="collapseOne" class="accordion-collapse collapse" 
                                        aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        <div class="">
                                            <p class="mb-4"><?php echo display('checkout_msg') ?></p>

                                            <div class="row g-4 mb-4">
                                                <div class="col-md-6">
                                                    <label class="" for="user_email"><?php echo display('username_or_email') ?>*</label>
                                                    <input type="text" id="user_email" class="form-control custom-control" name="user_email" placeholder="admin@gmail.com">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="" for="u_pass"><?php echo display('password') ?>*</label>
                                                    <input type="password" id="u_pass" name="u_pass" class="form-control custom-control" placeholder="Enter your password">
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-check">
                                                        <input id="brand1" type="checkbox" class="form-check-input custom-check">
                                                        <label for="brand1" class="form-check-label"><?php echo display('remember_me') ?></label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="d-flex flex-column flex-md-row align-items-center gap-2 mb-4">
                                                <?php 
                                                $facrbooklogn = $this->db->where('directory', 'facebooklogin')->where('status', 1)->get('module')->num_rows();
                                                if ($facrbooklogn == 1) { ?>
                                                    <a class="btn btn-primary w-sm-100 lh-lg px-4"
                                                        href="<?php echo base_url('facebooklogin/facebooklogin/index') ?>"><i
                                                        class="fa fa-facebook pr-1"></i><?php echo display('facebook_login') ?>
                                                    </a>
                                                <?php } ?>

                                                <a class="btn btn-secondary w-sm-100 lh-lg px-4"
                                                    onclick="logincustomer();"><?php echo display('login') ?></a>
                                                    
                                                <a class="btn btn-light w-sm-100 lh-lg px-4" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#lostpassword">
                                                    <?php echo display('forgot_password') ?>
                                                </a>
                                            </div>                                    
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                        <h4 class="mb-4"><?php echo display('billing_address') ?></h4>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <input type="text" id="f_name" class="form-control custom-control" name="f_name"
                                    value="<?php echo (!empty($billinginfo->firstname) ? $billinginfo->firstname : null) ?>" placeholder="<?php echo display('first_name') ?>" required>
                            </div>

                            <div class="col-md-6">
                                <input type="text" id="l_name" class="form-control custom-control" name="l_name"
                                    value="<?php echo (!empty($billinginfo->lastname) ? $billinginfo->lastname : null) ?>" placeholder="<?php echo display('last_name') ?>">
                            </div>
                            
                            <div class="col-md-6">
                                <div class="custom-control-three">
                                    <select name="country" id="country" class="form-control js-example-basic-single">
                                        <option value=""><?php echo display('select_country') ?></option>
                                        <?php 
                                        if (!empty($countryinfo)) {
                                            foreach ($countryinfo as $mcountry) { ?>
                                                <option value="<?php echo $mcountry->countryname; ?>"
                                                    data-id="<?php echo $mcountry->countryid; ?>" <?php echo (is_object($billinginfo) && isset($billinginfo->country) && $billinginfo->country == $mcountry->countryname) ? 'selected' : '' ?>>
                                                    <?php echo $mcountry->countryname; ?>
                                                </option><?php 
                                            }
                                        }  ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="custom-control-three">
                                    <select name="district" id="district" class="form-control js-example-basic-single">
                                        <option value=""><?php echo display('select_state') ?></option>
                                        <?php if (!empty($billinginfo) && is_object($billinginfo) && !empty($billinginfo->district)) { ?>
                                            <option value="<?php echo $billinginfo->district; ?>" selected>
                                                <?php echo $billinginfo->district; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="custom-control-three">
                                    <select name="town" id="town" class="form-control js-example-basic-single">
                                        <option value=""><?php echo display('select_city') ?></option>
                                        <?php if (!empty($billinginfo) && is_object($billinginfo) && !empty($billinginfo->city)) { ?>
                                            <option value="<?php echo $billinginfo->city; ?>" selected>
                                                <?php echo $billinginfo->city; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <input type="text"  id="billing_address_1" name="billing_address_1" class="form-control custom-control" placeholder="<?php echo display('street_address') ?>" value="<?php echo (!empty($billinginfo->address) ? $billinginfo->address : null) ?>">
                            </div>

                            <div class="col-md-6">
                                <input type="text" id="email" name="email" class="form-control custom-control"
                                    value="<?php echo (!empty($billinginfo->email) ? $billinginfo->email : null) ?>" placeholder="<?php echo display('email') ?>">
                            </div>

                            <div class="col-md-6">
                                <input type="text" id="phone" class="form-control custom-control"
                                    value="<?php echo (!empty($billinginfo->phone) ? $billinginfo->phone : null) ?>"
                                    placeholder="<?php echo display('phone') ?>" name="phone" required>
                            </div>

                            <div class="col-md-6">
                                <input type="text" id="postcode" class="form-control custom-control" name="postcode" placeholder="<?php echo display('postcode_zip') ?>"
                                    value="<?php echo (!empty($billinginfo->zip) ? $billinginfo->zip : null) ?>">
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <?php if (empty($this->session->userdata('CusUserID'))) { ?>
                                    <div class="form-check">
                                        <input id="creat_ac" type="checkbox" 
                                            class="form-check-input" 
                                            data-bs-toggle="collapse" 
                                            data-bs-target="#account-pass">
                                        <label for="creat_ac" class="form-check-label"><?php echo display('create_account') ?></label>
                                    </div>
                                
                                    <div class="collapse mt-2" id="account-pass">
                                        <div class="form-group">
                                            <input type="text" class="form-control custom-control" id="ac_pass" name="password" placeholder="<?php echo display('create_account_password') ?>">
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                                
                            <div class="col-md-12 mt-2">
                                <div class="form-check">
                                    <input id="shipping_address2" type="checkbox" name="isdiffship"
                                            class="form-check-input" 
                                            data-bs-toggle="collapse" 
                                            data-bs-target="#billing-different-address">
                                    <label for="shipping_address2" class="form-check-label">
                                        <?php echo display('shipping_different_address') ?>
                                    </label>
                                </div>

                                <div class="collapse mt-2" id="billing-different-address">
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <input type="text" id="f_name3" class="form-control custom-control" name="f_name3"
                                                value="<?php echo (!empty($shippinginfo->firstname) ? $shippinginfo->firstname : null) ?>" placeholder="<?php echo display('first_name') ?>">
                                        </div>

                                        <div class="col-md-6">
                                            <input type="text" id="l_name2" class="form-control custom-control" name="l_name2"
                                                value="<?php echo (!empty($shippinginfo->lastname) ? $shippinginfo->lastname : null) ?>" placeholder="<?php echo display('last_name') ?>">
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="custom-control-three">
                                                <select name="country2" id="country2" class="form-control js-example-basic-single">
                                                    <option value=""><?php echo display('select_country') ?></option>
                                                    <?php 
                                                    if (!empty($countryinfo)) {
                                                        foreach ($countryinfo as $mcountry) { ?>
                                                            <option value="<?php echo $mcountry->countryname; ?>"
                                                                data-id="<?php echo $mcountry->countryid; ?>">
                                                                <?php echo $mcountry->countryname; ?>
                                                            </option><?php 
                                                        }
                                                    }  ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="custom-control-three">
                                                <select name="district2" id="district2" class="form-control js-example-basic-single">
                                                    <option value=""><?php echo display('select_state') ?></option>
                                                    <option
                                                        value="<?php echo (!empty($shippinginfo->district) ? $shippinginfo->district : null) ?>"
                                                        data-stateid=''>
                                                        <?php echo (!empty($shippinginfo->district) ? $shippinginfo->district : null) ?>
                                                    </option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="custom-control-three">
                                                <select name="town2" id="town2" class="form-control js-example-basic-single">
                                                    <option value=""><?php echo display('select_city') ?></option>
                                                    <option
                                                        value="<?php echo (!empty($shippinginfo->city) ? $shippinginfo->city : null) ?>"
                                                        data-city=''>
                                                        <?php echo (!empty($shippinginfo->city) ? $shippinginfo->city : null) ?>
                                                    </option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <input type="text"  id="billing_address_3" name="billing_address_3" class="form-control custom-control" placeholder="<?php echo display('street_address') ?>" value="<?php echo (!empty($shippinginfo->address) ? $shippinginfo->address : null) ?>">
                                        </div>

                                        <div class="col-md-6">
                                            <input type="text" id="email2" name="email2" class="form-control custom-control"
                                                    value="<?php echo (!empty($shippinginfo->email) ? $shippinginfo->email : null) ?>" placeholder="<?php echo display('email') ?>">
                                        </div>

                                        <div class="col-md-6">
                                            <input type="text" id="phone2" class="form-control custom-control"
                                                value="<?php echo (!empty($shippinginfo->phone) ? $shippinginfo->phone : null) ?>"
                                                placeholder="<?php echo display('phone') ?>" name="phone2">
                                        </div>

                                        <div class="col-md-6">
                                            <input type="text" id="postcode2" class="form-control custom-control" name="postcode2" placeholder="<?php echo display('postcode_zip') ?>"
                                                value="<?php echo (!empty($shippinginfo->zip) ? $shippinginfo->zip : null) ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mt-4">
                            <textarea class="form-control custom-control" id="ordre_notes" rows="5" name="ordre_notes" rows="4" placeholder="<?php echo display('ordnote') ?>"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3">
                <div class="cart-box p-4">
                    <div class="mb-3">
                        <h4 class="mb-0"><?php echo display('your_order') ?></h4>
                    </div>
                    <?php
                    if (!empty($this->cart->contents())) {
                        $totalqty = count($this->cart->contents());
                    }; 
                    $calvat = 0;
                    $discount = 0;
                    $itemtotal = 0;
                    $pvat = 0;
                    $totalamount = 0;
                    $subtotal = 0;
                    $multiplletax = array();
                    if ($cart = $this->cart->contents()) {
                        $totalamount = 0;
                        $subtotal = 0;
                        $pvat = 0;


                        $i = 0;
                        foreach ($cart as $item) {
                            $itemprice = $item['price'] * $item['qty'];
                            $iteminfo = $this->hungry_model->getiteminfo($item['pid']);
                            $mypdiscountprice = 0;
                            if (!empty($taxinfos)) {
                                $tx = 0;
                                if ($iteminfo->OffersRate > 0) {
                                    $mypdiscountprice = $iteminfo->OffersRate * $itemprice / 100;
                                }
                                $itemvalprice =  ($itemprice - $mypdiscountprice);
                                foreach ($taxinfos as $taxinfo) {
                                    $fildname = 'tax' . $tx;
                                    if (!empty($iteminfo->$fildname)) {
                                        $vatcalc = $itemvalprice * $iteminfo->$fildname / 100;
                                        $multiplletax[$fildname] = @$multiplletax[$fildname] + $vatcalc;
                                    } else {
                                        $vatcalc = $itemvalprice * $taxinfo['default_value'] / 100;
                                        $multiplletax[$fildname] = @$multiplletax[$fildname] + $vatcalc;
                                    }

                                    $pvat = $pvat + $vatcalc;
                                    $vatcalc = 0;
                                    $tx++;
                                }
                            } else {
                                $vatcalc = $itemprice * $iteminfo->productvat / 100;
                                $pvat = $pvat + $vatcalc;
                            }
                            if ($iteminfo->OffersRate > 0) {
                                $discal = $itemprice * $iteminfo->OffersRate / 100;
                                $discount = $discal + $discount;
                            } else {
                                $discal = 0;
                                $discount = $discount;
                            }
                            if (!empty($item['addonsid'])) {
                                $nittotal = $item['addontpr'];
                                $itemprice = $itemprice + $item['addontpr'];
                            } else {
                                $nittotal = 0;
                                $itemprice = $itemprice;
                            }
                            $totalamount = $totalamount + $nittotal;
                            $subtotal = $subtotal - $discal + $item['price'] * $item['qty'];
                            $i++; ?>

                            <div class="cart-item align-items-baseline">
                                <div>
                                    <div><?php echo $item['name']; ?>(<?php echo $item['size']; ?>)</div>
                                    <small><?php echo $item['qty']. ' × ' .$item['price']; ?></small>
                                    <?php
                                    if (!empty($item['addonsid'])) {
                                        echo "<br>";
                                        echo '<small>'.$item['addonname'] . ': ' . $item['addonsqty'] . ' × ' . $item['addontpr'] .'</small>';
                                        if (!empty($taxinfos)) {

                                            $addonsarray = explode(',', $item['addonsid']);
                                            $addonsqtyarray = explode(',', $item['addonsqty']);
                                            $getaddonsdatas = $this->db->select('*')->from('add_ons')->where_in('add_on_id', $addonsarray)->get()->result_array();
                                            $addn = 0;
                                            foreach ($getaddonsdatas as $getaddonsdata) {
                                                $tax = 0;

                                                foreach ($taxinfos as $taxainfo) {

                                                    $fildaname = 'tax' . $tax;

                                                    if (!empty($getaddonsdata[$fildaname])) {

                                                        $avatcalc = ($getaddonsdata['price'] * $addonsqtyarray[$addn]) * $getaddonsdata[$fildaname] / 100;
                                                        $multiplletax[$fildaname] = $multiplletax[$fildaname] + $avatcalc;
                                                    } else {
                                                        $avatcalc = ($getaddonsdata['price'] * $addonsqtyarray[$addn]) * $taxainfo['default_value'] / 100;
                                                        $multiplletax[$fildaname] = $multiplletax[$fildaname] + $avatcalc;
                                                    }

                                                    $pvat = $pvat + $avatcalc;

                                                    $tax++;
                                                }
                                                $addn++;
                                            }
                                        }
                                    }
                                    ?>
                                </div>
                                <span class="text_primary">
                                    <?php if ($this->storecurrency->position == 1) { echo $this->storecurrency->curr_icon; } ?>
                                    <?php echo $itemprice; ?>
                                    <?php if ($this->storecurrency->position == 2) { echo $this->storecurrency->curr_icon; } ?>
                                </span>
                            </div> <?php 
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

                        <div class="cart-summary mt-3 mb-5">
                            <div class="d-flex mb-3 pb-3 border_bottom1 justify-content-between">
                                <span><?php echo display('subtotal') ?></span>
                                <span>
                                    <?php if ($this->storecurrency->position == 1) { echo $this->storecurrency->curr_icon; } ?>
                                    <?php echo $itemtotal; ?>
                                    <?php if ($this->storecurrency->position == 2) { echo $this->storecurrency->curr_icon; } ?>
                                </span>
                                <input name="orggrandTotal" type="hidden" value="<?php echo $itemtotal; ?>" />
                            </div>

                            <?php 
                            if (empty($taxinfos)) { ?>
                                <div class="d-flex mb-3 pb-3 border_bottom1 justify-content-between">
                                    <span><?php echo display('total_vat') ?></span>
                                    <span>
                                        <?php if ($this->storecurrency->position == 1) { echo $this->storecurrency->curr_icon; } ?>
                                        <?php echo $calvat; ?>
                                        <?php if ($this->storecurrency->position == 2) { echo $this->storecurrency->curr_icon; } ?>
                                    </span>
                                    <input name="vat" type="hidden" value="<?php echo $calvat; ?>" />
                                </div> <?php 
                            } else {
                                $i = 0;
                                foreach ($taxinfos as $mvat) {
                                    if ($mvat['is_show'] == 1) { ?>
                                        <div class="d-flex mb-3 pb-3 border_bottom1 justify-content-between">
                                            <span><?php echo $mvat['tax_name']; ?></span>
                                            <span>
                                                <?php if ($this->storecurrency->position == 1) { echo $this->storecurrency->curr_icon; } ?>
                                                <?php echo $multiplletax['tax' . $i]; ?>
                                                <?php if ($this->storecurrency->position == 2) { echo $this->storecurrency->curr_icon; } ?>
                                            </span>
                                        </div> <?php 
                                        $i++;
                                    }
                                } ?>
                                <input name="vat" type="hidden" value="<?php echo $calvat; ?>" /> <?php 
                            } ?>

                            <div class="d-flex mb-3 pb-3 border_bottom1 justify-content-between">
                                <span><?php echo display('discount') ?></span>
                                <span>
                                    <?php if ($this->storecurrency->position == 1) { echo $this->storecurrency->curr_icon; } ?>
                                    <?php echo 0; ?>
                                    <?php if ($this->storecurrency->position == 2) { echo $this->storecurrency->curr_icon; } ?>
                                </span>
                            </div>

                            <?php 
                            $coupon = 0;
                            if (!empty($this->session->userdata('couponcode'))) { ?>
                                <div class="d-flex mb-3 pb-3 border_bottom1 justify-content-between">
                                    <span><?php echo display('coupon_discount') ?></span>
                                    <span>
                                        <?php if ($this->storecurrency->position == 1) { echo $this->storecurrency->curr_icon; } ?>
                                        <?php echo $coupon = $this->session->userdata('couponprice'); ?>
                                        <?php if ($this->storecurrency->position == 2) { echo $this->storecurrency->curr_icon; } ?>
                                    </span>
                                </div>
                            <?php } ?>
                                
                            <input name="invoice_discount" type="hidden" value="<?php echo $discount + $coupon; ?>" />

                            <div class="d-flex mb-3 pb-3 border_bottom1 justify-content-between">
                                <span><?php echo display('service') ?></span>
                                <span>
                                    <?php if ($this->storecurrency->position == 1) { echo $this->storecurrency->curr_icon; } ?>
                                    <?php echo $this->session->userdata('shippingrate'); ?>
                                    <?php if ($this->storecurrency->position == 2) { echo $this->storecurrency->curr_icon; } ?>
                                </span>
                                <input name="service_charge" type="hidden" value="<?php echo $this->session->userdata('shippingrate'); ?>" />
                            </div>

                            <div class="d-flex mb-3 pb-3 border_bottom1 justify-content-between">
                                <span><?php echo display('total') ?></span>
                                <span>
                                    <?php if ($this->storecurrency->position == 1) { echo $this->storecurrency->curr_icon; } ?>
                                    <?php
                                    $isvatinclusive = $this->db->select("*")->from('setting')->get()->row();
                                    if ($isvatinclusive->isvatinclusive == 1) {
                                        echo ($itemtotal + $this->session->userdata('shippingrate')) - ($coupon);
                                    } else {
                                        echo ($calvat + $itemtotal + $this->session->userdata('shippingrate')) - ($coupon);
                                    } ?>
                                    <?php if ($this->storecurrency->position == 2) { echo $this->storecurrency->curr_icon; } ?>
                                </span>
                                <input name="grandtotal" type="hidden" value="<?php echo ($calvat + $itemtotal + $this->session->userdata('shippingrate')) - ($coupon); ?>" />
                            </div>
                        </div>
                    <?php } ?>


                    <h4 class="border_bottom1 pb-3 mb-4"><?php echo display('paymd') ?></h4>

                    <?php
                    if (!empty($paymentinfo)) {
                        foreach ($paymentinfo as $payment) {
                            if (!array_filter($slpayment)) { ?>

                                <div class="form-check mb-3">
                                     <input type="radio" name="card_type"
                                        id="payment_method_cre<?php echo $payment->payment_method_id; ?>" data-parent="#payment"
                                        data-target="#description_cre" value="<?php echo $payment->payment_method_id; ?>"
                                        class="form-check-input custom-check"
                                        <?php if ($payment->payment_method_id == 4) {
                                            echo "checked";
                                        } ?>>
                                    <label class="form-check-label fs-16 font_prata fw-light" for="payment_method_cre<?php echo $payment->payment_method_id; ?>"><?php echo $payment->payment_method; ?></label>
                                </div> <?php 
                            } else {
                                foreach ($slpayment as $selmethod) {
                                    if ($selmethod == $payment->payment_method_id) { ?>
                                        <div class="form-check mb-3">
                                            <input type="radio" name="card_type"
                                                    id="payment_method_cre<?php echo $payment->payment_method_id; ?>" data-parent="#payment"
                                                    data-target="#description_cre" value="<?php echo $payment->payment_method_id; ?>"
                                                    class="form-check-input custom-check"
                                                    <?php if ($payment->payment_method_id == $pvalue) {
                                                        echo "checked";
                                                    } ?>>
                                            <label class="form-check-label fs-16 font_prata fw-light" for="payment_method_cre<?php echo $payment->payment_method_id; ?>"><?php echo $payment->payment_method; ?></label>
                                        </div> <?php 
                                    }
                                }
                            }
                        }
                    } ?>

                    <input name="multiplletaxvalue" id="multiplletaxvalue" type="hidden"
                        value="<?php echo $multiplletaxvalue; ?>" />
                    
                    <button type="submit" class="btn-checkout"><?php echo display('placeorder') ?></button>
                </div>
            </div>

            </form>
        </div>
    </div>
</section>
<!-- End Checkout Page  -->

<script src="<?php echo base_url(); ?>application/views/themes/<?php echo $this->themeinfo->themename; ?>/assets_web/js/checkout.js"></script>



