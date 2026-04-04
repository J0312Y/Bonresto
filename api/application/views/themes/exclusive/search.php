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
                                    <a onclick="addonsitem(<?php echo $menuitem->ProductsID; ?>,<?php echo $menuitem->variantid; ?>,'other')" class="add-cart-btn" data-toggle="modal" data-target="#addons" data-dismiss="modal" href="javascript:void(0)"><i class="fa fa-shopping-basket"></i> <?php echo display('add_to_cart') ?></a>

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