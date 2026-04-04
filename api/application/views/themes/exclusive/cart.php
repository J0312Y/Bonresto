<div class="modal fade" id="vieworder" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-addons">
            <div class="modal-header ps-3 py-1">
                <h1 class="modal-title fs-5" id="exampleModalLabel"><?php echo display('foodnote') ?></h5>
                <button type="button" class="btn" data-bs-dismiss="modal" aria-label="Close">
                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M2.146 2.146a.5.5 0 0 1 .708 0L8 7.293l5.146-5.147a.5.5 0 0 1 
                      .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 
                      5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854a.5.5 0 0 
                      1 0-.708z"/>
                  </svg>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="control-label mb-1" for="user_email"><?php echo display('foodnote') ?></label>
                    <textarea rows="3" id="foodnote" class="form-control" name="foodnote" required></textarea>
                    <input name="foodid" id="foodid" type="hidden" />
                    <input name="foodvid" id="foodvid" type="hidden" />
                    <input name="foodcartid" id="foodcartid" type="hidden" />
                </div>

                <div class="col-sm-4">
                    <a onclick="addnotetoitem()" class="checkout btn btn-md text-white"><?php echo display('addnotesi') ?></a>
                </div>
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
<section class="sect_pad bg_soft_primary" id="reloadcart">
    <div class="container">
        <div class="card mb-5">
          <div class="card-body p-4">
            <div class="checkout-table table-responsive">
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
              } 
              
              $totalqty = 0;
              if (!empty($this->cart->contents())) {
                  $totalqty = count($this->cart->contents());
              }; 
              
              $calvat       = 0;
              $discount     = 0;
              $itemtotal    = 0;
              $pvat         = 0;
              $totalamount  = 0;
              $subtotal     = 0;
              $multiplletax = [];

              if ($cart = $this->cart->contents()) {
                $totalamount = 0;
                $subtotal    = 0;
                $pvat        = 0; ?>

              <table class="table mb-0 checkout-table" <?php if ($this->settinginfo->site_align == 'RTL') { echo 'dir="rtl"'; } ?>>
                <thead>
                  <tr>
                    <th><?php echo display('product'); ?></th>
                    <th><?php echo display('food_name'); ?></th>
                    <th><?php echo display('quantity'); ?></th>
                    <th><?php echo display('price'); ?></th>
                    <th><?php echo display('total'); ?></th>
                    <th><?php echo display('action'); ?></th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  $i = 0;
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

                        // Ensure the $multiplletax array has the key initialized
                        if (!isset($multiplletax[$fildname])) {
                          $multiplletax[$fildname] = 0;
                        }

                        if (!empty($iteminfo->$fildname)) {
                          $vatcalc = $itemvalprice * $iteminfo->$fildname / 100;
                          $multiplletax[$fildname] += $vatcalc;
                        } else {
                          $vatcalc = $itemvalprice * $taxinfo['default_value'] / 100;
                          $multiplletax[$fildname] += $vatcalc;
                        }

                        $pvat += $vatcalc;
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
                    $subtotal    = $subtotal - $discal + ($item['price'] * $item['qty']);
                    $i++;
                  ?>
                  <tr>
                    <td data-label="Image">
                      <img src="<?php echo base_url(!empty($iteminfo->small_thumb) ? $iteminfo->small_thumb : 'assets/img/no-image.png'); ?>"
                        class="checkout-img" alt="<?php echo $item['name']; ?>">
                    </td>
                    <td data-label="Food Name">
                      <?php 
                      echo $item['name'];
                      echo "<br>";
                      echo $item['size'];
                      if (!empty($item['addonsid'])) {
                        echo "<br>";
                        echo $item['addonname'] . ' -Qty:' . $item['addonsqty'];
                        if (!empty($taxinfos)) {
                          $addonsarray    = explode(',', $item['addonsid']);
                          $addonsqtyarray = explode(',', $item['addonsqty']);
                          $getaddonsdatas = $this->db->select('*')->from('add_ons')->where_in('add_on_id', $addonsarray)->get()->result_array();
                          $addn           = 0;
                          foreach ($getaddonsdatas as $getaddonsdata) {
                            $tax = 0;

                            foreach ($taxinfos as $taxainfo) {

                              $fildaname = 'tax' . $tax;
                              if (!empty($getaddonsdata[$fildaname])) {
                                $avatcalc                 = ($getaddonsdata['price'] * $addonsqtyarray[$addn]) * $getaddonsdata[$fildaname] / 100;
                                $multiplletax[$fildaname] = $multiplletax[$fildaname] + $avatcalc;
                              } else {
                                $avatcalc                 = ($getaddonsdata['price'] * $addonsqtyarray[$addn]) * $taxainfo['default_value'] / 100;
                                $multiplletax[$fildaname] = $multiplletax[$fildaname] + $avatcalc;
                              }

                              $pvat = $pvat + $avatcalc;

                              $tax++;
                            }

                            $addn++;
                          }
                        }
                      } ?>
                  </td>

                  <td data-label="Quantity">
                    <div class="d-inline-flex align-items-center gap-2 justify-content-center">
                      <div class="qty-control py-2 w-150 m-auto justify-content-between cart_counter">
                        <button
                          onclick="updatecart('<?php echo $item['rowid'] ?>',<?php echo $item['qty']; ?>,'del')"
                          class="btn-minus" type="button">
                          -
                        </button>
                        <input type="text" name="qty" id="sst3" maxlength="12" value="<?php echo $item['qty']; ?>" title="Quantity:" class="border-0 text-center qty">
                        <button
                          onclick="updatecart('<?php echo $item['rowid'] ?>',<?php echo $item['qty']; ?>,'add')"
                          class="btn-plus" type="button">
                          +
                        </button>
                      </div>
                      <button class="btn p-1" onclick="itemnote('<?php echo $item['rowid'] ?>','<?php echo $item['itemnote'] ?>')">
                        <svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path
                            d="M17.4712 2.94832C17.4712 2.16436 16.8357 1.52884 16.0517 1.52883H2.94832C2.16437 1.52883 1.52883 2.16437 1.52883 2.94832V16.0517C1.52884 16.8357 2.16436 17.4712 2.94832 17.4712H9.82754V11.6839C9.82754 10.6586 10.6586 9.82754 11.6839 9.82754H17.4712V2.94832ZM11.3564 16.3901L16.3901 11.3564H11.6839C11.503 11.3564 11.3564 11.503 11.3564 11.6839V16.3901ZM19 10.592C19 10.7947 18.9195 10.9891 18.7761 11.1325L11.1325 18.7761C10.9891 18.9195 10.7947 19 10.592 19H2.94832C1.32003 19 6.07814e-06 17.6801 0 16.0517V2.94832C0 1.32001 1.32001 0 2.94832 0H16.0517C17.6801 6.07888e-06 19 1.32003 19 2.94832V10.592Z"
                            fill="#A6A6A6"
                          />
                        </svg>
                      </button>

                      <?php 
                      if (!empty($item['itemnote'])) { ?><p>
                        <?php echo display('foodnote') ?>:
                        <?php echo $item['itemnote'] ?></p><?php 
                      } ?>
                    </div>
                  </td>

                  <td data-label="Price">
                    <?php if ($this->storecurrency->position == 1) {  echo $this->storecurrency->curr_icon; } ?>
                    <?php echo $item['price']; ?>
                    <?php if ($this->storecurrency->position == 2) { echo $this->storecurrency->curr_icon; } ?>
                    <?php
                    if (!empty($item['addonsid'])) {
                      echo "<br>"; ?>
                      <?php if ($this->storecurrency->position == 1) { echo $this->storecurrency->curr_icon; } ?>
                      <?php echo $item['addontpr']; ?>
                      <?php if ($this->storecurrency->position == 2) { echo $this->storecurrency->curr_icon; } ?>
                    <?php } ?>
                  </td>

                  <td data-label="Total">
                    <?php if ($this->storecurrency->position == 1) { echo $this->storecurrency->curr_icon; } ?>
                    <?php echo $itemprice - $discal; ?>
                    <?php if ($this->storecurrency->position == 2) { echo $this->storecurrency->curr_icon; } ?>
                  </td>

                  <td data-label="Action">
                    <button class="btn p-0" onclick="removetocart('<?php echo $item['rowid'] ?>')">
                      <svg width="25" height="25" viewBox="0 0 33 37" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M19.3457 27.8005V18.4733C19.3457 17.9067 19.8552 17.4473 20.4836 17.4473C21.1121 17.4473 21.6216 17.9067 21.6216 18.4733V27.8005C21.6216 28.3672 21.1121 28.8266 20.4836 28.8266C19.8552 28.8266 19.3457 28.3672 19.3457 27.8005Z" fill="#FF4646" />
                        <path d="M12.5156 27.8005V18.4733C12.5156 17.9067 13.0251 17.4473 13.6536 17.4473C14.282 17.4473 14.7915 17.9067 14.7915 18.4733V27.8005C14.7915 28.3672 14.282 28.8266 13.6536 28.8266C13.0251 28.8266 12.5156 28.3672 12.5156 27.8005Z" fill="#FF4646" />
                        <path d="M31.9385 8.34393C32.5248 8.34393 33 8.8534 33 9.48186C33 10.1103 32.5248 10.6198 31.9385 10.6198H1.06149C0.475245 10.6198 0 10.1103 0 9.48186C0 8.8534 0.475245 8.34393 1.06149 8.34393H31.9385Z" fill="#FF4646" />
                        <path d="M4.55078 30.1166V15.0697C4.55078 14.4983 5.0214 14.0352 5.60193 14.0352C6.18247 14.0352 6.65308 14.4983 6.65308 15.0697V30.1166C6.65309 32.6616 8.74924 34.7246 11.335 34.7246H22.8011C25.3869 34.7246 27.483 32.6616 27.483 30.1166V15.0697C27.483 14.4983 27.9536 14.0352 28.5341 14.0352C29.1146 14.0352 29.5853 14.4983 29.5853 15.0697V30.1166C29.5853 33.8044 26.548 36.7938 22.8011 36.7938H11.335C7.58819 36.7938 4.55079 33.8044 4.55078 30.1166Z" fill="#FF4646" />
                        <path d="M21.7816 5.49963C21.7816 3.89157 20.5331 2.58799 18.993 2.58799H15.1466C13.6065 2.58799 12.3579 3.89158 12.3579 5.49963V8.4112H21.7816V5.49963ZM23.8974 9.51574C23.8974 10.1258 23.4237 10.6203 22.8395 10.6203H11.3001C10.7158 10.6203 10.2422 10.1258 10.2422 9.51574V5.49963C10.2422 2.67154 12.438 0.378906 15.1466 0.378906H18.993C21.7017 0.378906 23.8974 2.67155 23.8974 5.49963V9.51574Z" fill="#FF4646" />
                      </svg>
                    </button>
                  </td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
            <?php } ?>

          </div>
        </div>
      </div>

      <div class="card">
        <div class="card-body p-4">
          <div class="row">
            <div class="col-12 col-xl-3 d-none d-xl-block">
              <img src="<?php echo base_url(!empty($ad_img->image) ? $ad_img->image : 'dummyimage/324x516.png'); ?>" class="img-fluid rounded-3" alt="">
            </div>
            <div class="col-lg-6 col-xl-5">
              <div class="h-100">
                <h4 class="my-3"><?php echo display('shipping_method') ?></h4>
                <table class="table shipping-method-table mb-3">
                  <tbody>
                    
                    <?php 
                    foreach ($shippinginfo as $shipment) { ?>
                      <tr>
                        <th>
                          <div class="form-check ps-0">
                            <input type="radio" name="payment_method" id="payment_method_cre-<?php echo $shipment->shipping_method; ?>" data-parent="#payment" data-target="#description_cre"
                              value="<?php echo $shipment->shippingrate; ?>" required="" class=""
                              onchange="getcheckbox('<?php echo $shipment->shippingrate; ?>','<?php echo $shipment->shipping_method; ?>');">

                            <label class="form-check-label fw-light" for="payment_method_cre-<?php echo $shipment->shipping_method; ?>">
                              <?php echo $shipment->shipping_method; ?>
                            </label>
                          </div>
                        </th>
                        <td class="text-end">
                          <?php if ($this->storecurrency->position == 1) { echo $this->storecurrency->curr_icon; } ?>
                          <?php echo $shipment->shippingrate; ?>
                          <?php if ($this->storecurrency->position == 2) { echo $this->storecurrency->curr_icon; } ?>
                        </td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>

                <div class="row g-3 mb-3">
                  <div class="col-12 col-md-6">
                    <label class="mb-2 font_prata"><?php echo display('ordate'); ?></label>
                    <div class="input-group">
                      <span class="input-group-text custom-input-group-text">
                        <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <mask id="mask0_11_862" style="mask-type: luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="28" height="28">
                            <path d="M28 0H0V28H28V0Z" fill="white" />
                          </mask>
                          <g mask="url(#mask0_11_862)">
                            <path
                              d="M7.00065 25.9699C5.76297 25.9699 4.57599 25.4782 3.70082 24.6031C2.82565 23.7279 2.33398 22.5409 2.33398 21.3032V10.8032C2.33398 9.56555 2.82565 8.37857 3.70082 7.5034C4.57599 6.62823 5.76297 6.13656 7.00065 6.13656H8.16732C8.47674 6.13656 8.77348 6.25948 8.99228 6.47827C9.21107 6.69706 9.33398 6.99381 9.33398 7.30323C9.33398 7.61265 9.21107 7.90939 8.99228 8.12819C8.77348 8.34698 8.47674 8.4699 8.16732 8.4699H7.00065C6.38181 8.4699 5.78832 8.71573 5.35073 9.15331C4.91315 9.5909 4.66732 10.1844 4.66732 10.8032V21.3032C4.66732 21.9221 4.91315 22.5156 5.35073 22.9531C5.78832 23.3907 6.38181 23.6366 7.00065 23.6366H21.0007C21.6185 23.634 22.2101 23.3864 22.6457 22.9482C22.8668 22.7284 23.0417 22.4665 23.1599 22.1779C23.2781 21.8894 23.3373 21.58 23.334 21.2682V10.7682C23.334 10.1494 23.0882 9.5559 22.6506 9.11831C22.213 8.68073 21.6195 8.4349 21.0007 8.4349H19.834C19.5246 8.4349 19.2278 8.31198 19.009 8.09319C18.7902 7.87439 18.6673 7.57765 18.6673 7.26823C18.6673 6.95881 18.7902 6.66206 19.009 6.44327C19.2278 6.22448 19.5246 6.10156 19.834 6.10156H21.0007C22.2383 6.10156 23.4253 6.59323 24.3005 7.4684C25.1757 8.34357 25.6673 9.53055 25.6673 10.7682V21.2682C25.6673 22.5059 25.1757 23.6929 24.3005 24.5681C23.4253 25.4432 22.2383 25.9349 21.0007 25.9349H7.00065V25.9699Z"
                              fill="#BFBFBF"
                            />
                            <path d="M11.6676 8.45833C11.3582 8.45833 11.0615 8.33542 10.8427 8.11662C10.6239 7.89783 10.501 7.60109 10.501 7.29167C10.501 6.98225 10.6239 6.6855 10.8427 6.46671C11.0615 6.24792 11.3582 6.125 11.6676 6.125H16.3343C16.6437 6.125 16.9405 6.24792 17.1593 6.46671C17.3781 6.6855 17.501 6.98225 17.501 7.29167C17.501 7.60109 17.3781 7.89783 17.1593 8.11662C16.9405 8.33542 16.6437 8.45833 16.3343 8.45833H11.6676Z" fill="#BFBFBF" />
                            <path
                              d="M9.89433 10.2195C9.51036 10.2153 9.13106 10.1348 8.77853 9.98256C8.426 9.83033 8.1073 9.60946 7.841 9.3328C7.57453 9.06618 7.3632 8.74967 7.21907 8.40136C7.07494 8.05305 7.00084 7.67975 7.001 7.3028V4.96947C6.99946 4.587 7.07347 4.20799 7.21877 3.85419C7.36407 3.50039 7.57781 3.17877 7.84772 2.90778C8.11763 2.63679 8.43839 2.42176 8.7916 2.27504C9.14482 2.12832 9.52353 2.0528 9.906 2.0528C10.2868 2.0502 10.6643 2.1231 11.0167 2.26728C11.3692 2.41146 11.6896 2.62407 11.9593 2.8928C12.2342 3.16224 12.4531 3.48342 12.6032 3.83784C12.7534 4.19225 12.832 4.57289 12.8343 4.9578V7.29113C12.8343 8.06778 12.5258 8.81261 11.9766 9.36178C11.4275 9.91095 10.6826 10.2195 9.906 10.2195H9.89433ZM9.89433 4.38613C9.73962 4.38613 9.59125 4.44759 9.48185 4.55699C9.37246 4.66639 9.311 4.81476 9.311 4.96947V7.3028C9.31399 7.45658 9.3764 7.60322 9.48516 7.71198C9.59391 7.82073 9.74056 7.88315 9.89433 7.88613C9.97345 7.88769 10.0521 7.87344 10.1256 7.84424C10.1992 7.81503 10.2661 7.77145 10.3226 7.71604C10.3791 7.66064 10.424 7.59452 10.4546 7.52156C10.4852 7.4486 10.501 7.37026 10.501 7.29113V4.9578C10.4979 4.80512 10.4351 4.65973 10.3261 4.55284C10.217 4.44596 10.0704 4.3861 9.91767 4.38613H9.89433Z"
                              fill="#BFBFBF"
                            />
                            <path
                              d="M18.0613 10.196C17.2928 10.1868 16.5587 9.87581 16.0174 9.33015C15.4761 8.78449 15.171 8.04789 15.168 7.2793V4.94596C15.1665 4.56349 15.2405 4.18448 15.3858 3.83068C15.5311 3.47689 15.7448 3.15526 16.0147 2.88427C16.2846 2.61328 16.6054 2.39826 16.9586 2.25154C17.3118 2.10482 17.6905 2.02929 18.073 2.0293C18.8456 2.02927 19.5869 2.33459 20.1354 2.87872C20.6839 3.42285 20.9952 4.1617 21.0013 4.9343V7.26763C21.0014 8.04025 20.696 8.78156 20.1519 9.33007C19.6078 9.87857 18.8689 10.1898 18.0963 10.196H18.0613ZM18.0613 7.86263C18.216 7.86263 18.3644 7.80117 18.4738 7.69178C18.5832 7.58238 18.6447 7.43401 18.6447 7.2793V4.94596C18.6447 4.79125 18.5832 4.64288 18.4738 4.53348C18.3644 4.42409 18.216 4.36263 18.0613 4.36263C17.9066 4.36263 17.7582 4.42409 17.6488 4.53348C17.5395 4.64288 17.478 4.79125 17.478 4.94596V7.2793C17.478 7.43401 17.5395 7.58238 17.6488 7.69178C17.7582 7.80117 17.9066 7.86263 18.0613 7.86263Z"
                              fill="#BFBFBF"
                            />
                            <path d="M3.50065 14.3138C3.19123 14.3138 2.89449 14.1909 2.67569 13.9721C2.4569 13.7533 2.33398 13.4566 2.33398 13.1471C2.33398 12.8377 2.4569 12.541 2.67569 12.3222C2.89449 12.1034 3.19123 11.9805 3.50065 11.9805H24.5007C24.8101 11.9805 25.1068 12.1034 25.3256 12.3222C25.5444 12.541 25.6673 12.8377 25.6673 13.1471C25.6673 13.4566 25.5444 13.7533 25.3256 13.9721C25.1068 14.1909 24.8101 14.3138 24.5007 14.3138H3.50065Z" fill="#BFBFBF" />
                          </g>
                        </svg>
                      </span>
                      <input type="text" class="form-control custom-control" name="orderdate" id="orderdate" placeholder="Date" value="<?php echo date('Y-n-j'); ?>" />
                    </div>
                  </div>
                  <div class="col-12 col-md-6">
                    <label class="mb-2 font_prata"><?php echo display('receive_time'); ?></label>
                    <div class="input-group">
                      <span class="input-group-text custom-input-group-text">
                        <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path
                            d="M12.1579 0C5.44206 0 0 5.443 0 12.1579C0 18.8728 5.44206 24.3158 12.1579 24.3158C18.8719 24.3158 24.3158 18.8728 24.3158 12.1579C24.3158 5.443 18.8728 0 12.1579 0ZM12.0597 22.003C6.63634 22.003 2.23986 17.6065 2.23986 12.1831C2.23986 6.75979 6.63634 2.36331 12.0597 2.36331C17.4821 2.36331 21.8795 6.75979 21.8795 12.1831C21.8795 17.6065 17.4821 22.003 12.0597 22.003ZM14.8981 12.748H12.1111V8.04198C12.1111 7.53135 11.6968 7.11611 11.1862 7.11611C10.6756 7.11611 10.2603 7.53041 10.2603 8.04198V13.673C10.2603 14.1845 10.6746 14.5979 11.1862 14.5979H14.8981C15.4097 14.5979 15.824 14.1845 15.824 13.673C15.824 13.1623 15.4097 12.748 14.8981 12.748Z"
                            fill="#BFBFBF"
                          />
                        </svg>
                      </span>
                      <input type="text" class="form-control custom-control" name="ordertime" id="reservation_time" value="<?php echo date('H:i'); ?>" placeholder="time" />
                    </div>
                  </div>
                </div>

                <div class="details-bg-1 rounded-3 p-4">
                  <h4 class="fs-20 mb-2"><?php echo display('coupon_Code'); ?></h4>
                  <p class="mb-3"><?php echo display('enter_your_coupon_code_if_you_have_one'); ?></p>

                  <?php echo form_open('checkcoupon', 'method="post" class=""') ?>
                    <div class="d-flex flex-column flex-md-row align-items-center gap-3">
                      <div class="form-group">
                        <input type="text" class="form-control custom-control bg-white" id="couponcode" name="couponcode" placeholder="Enter your coupon code.." required>
                      </div>
                      <input name="coupon" class="btn btn_primary lh-base" type="submit" value="<?php echo display('apply_coupon') ?>" />
                    </div>
                  </form>
                </div>
              </div>
            </div>

            <?php 
            if (!empty($this->cart->contents())) {
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

              $multiplletaxvalue = htmlentities(serialize($multiplletax)); ?>

              <div class="col-lg-6 col-xl-4">
                <div class="details-bg-1 rounded-3 p-4 p-xl-5 h-100">
                  <table class="table order-summary-table mb-4">
                    <tbody>
                      <tr>
                        <td colspan="2">
                          <h4 class="fs-20 mb-2"><?php echo display('cart_total'); ?></h4>
                        </td>
                      </tr>
                      <tr>
                        <td><?php echo display('subtotal'); ?></td>
                        <td class="text-end totals-value" id="cart-subtotal">
                          <?php if ($this->storecurrency->position == 1) { echo $this->storecurrency->curr_icon; } ?>
                          <span id="subtotal"><?php echo $itemtotal; ?></span>
                          <?php if ($this->storecurrency->position == 2) { echo $this->storecurrency->curr_icon; } ?>
                        </td>
                      </tr>
                      <tr>
                        <td><?php echo display('vat'); ?></td>
                        <td class="text-end totals-value" id="cart-tax">
                          <?php if ($this->storecurrency->position == 1) { echo $this->storecurrency->curr_icon; } ?>
                          <span id="vat"><?php echo $calvat; ?></span>
                          <?php if ($this->storecurrency->position == 2) { echo $this->storecurrency->curr_icon; } ?>
                        </td>
                      </tr>
                      <tr>
                        <td><?php echo display('discount'); ?></td>
                        <td class="text-end totals-value" id="Discount-charge">
                          <?php if ($this->storecurrency->position == 1) { echo $this->storecurrency->curr_icon; } ?>
                          <span id="discount"><?php echo $discount; ?></span>
                          <?php if ($this->storecurrency->position == 2) { echo $this->storecurrency->curr_icon; } ?>
                        </td>
                      </tr>

                      <?php 
                      $coupon = 0;
                      if (!empty($this->session->userdata('couponcode'))) { ?>
                        <tr>
                          <td><?php echo display('coupon_discount'); ?></td>
                          <td class="text-end">
                            <?php if ($this->storecurrency->position == 1) { echo $this->storecurrency->curr_icon; } ?>
                            <span id="coupdiscount"><?php echo $coupon = $this->session->userdata('couponprice'); ?></span>
                            <?php if ($this->storecurrency->position == 2) { echo $this->storecurrency->curr_icon; } ?>

                            <input type="hidden" name="coupon_code" id="coupon_code" value="<?php echo $this->session->userdata('couponcode'); ?>">
                          </td>
                        </tr>
                      <?php } else { ?>
                        <span id="coupdiscount" class="d-none">0</span>
                        <input type="hidden" name="coupon_code" id="coupon_code" value="">
                      <?php } ?>
                              
                      <tr>
                        <td><?php echo display('service_chrg'); ?></td>
                        <td class="text-end totals-value" id="Service">
                          <?php if ($this->storecurrency->position == 1) { echo $this->storecurrency->curr_icon; } ?>
                          <span id="scharge"><?php echo "0"; ?></span>
                          <?php if ($this->storecurrency->position == 2) { echo $this->storecurrency->curr_icon; } ?>

                          <input name="servicecharge" type="hidden" value="0" id="getscharge" />
                          <input name="servicename" type="hidden" value="" id="servicename" />
                        </td>
                      </tr>

                      <tr>
                        <td><?php echo display('grand_total'); ?></td>
                        <td class="text-end totals-value" id="gtotal">
                          <?php if ($this->storecurrency->position == 1) { echo $this->storecurrency->curr_icon; } ?>
                          <span id="grtotal">
                            <?php
                            $isvatinclusive = $this->db->select("*")->from('setting')->get()->row();
                              if ($isvatinclusive->isvatinclusive == 1) {
                                $gtotal = ($itemtotal) - ($discount + $coupon);
                              } else {
                                $gtotal = ($calvat + $itemtotal) - ($discount + $coupon);
                              }

                              echo number_format($gtotal, 2); ?>
                          </span>
                          <?php if ($this->storecurrency->position == 2) { echo $this->storecurrency->curr_icon; } ?>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <a onclick="gotocheckout()" class="checkout btn btn_primary lh-base w-100"><?php echo display('proceedtocart'); ?></a>
                </div>
              </div>
              <input name="multiplletaxvalue" id="multiplletaxvalue" type="hidden" value="<?php echo $multiplletaxvalue; ?>" />
              <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </section>
<!-- End Checkout Page  -->





