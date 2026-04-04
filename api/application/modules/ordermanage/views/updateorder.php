<script src="<?php echo base_url(); ?>assets/js/jquery.validate.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css"
    href="<?php echo base_url('application/modules/ordermanage/assets/css/posordernew.css?v=1.1'); ?>">
<div id="edit" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <strong></strong>
            </div>
            <div class="modal-body addonsinfo">

            </div>

        </div>
        <div class="modal-footer">
        </div>
    </div>
</div>
<div id="items" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <strong><?php echo "Item Information"; ?></strong>
            </div>
            <div class="modal-body iteminfo">

            </div>

        </div>
        <div class="modal-footer">
        </div>
    </div>
</div>
<div class="row update-order-height">
    <div class="col-sm-12 col-md-12">
        <div class="panel">
            <fieldset class="border p-2">
                <legend class="w-auto"><?php echo display('update_ord') ?></legend>
            </fieldset>
            <input name="url" type="hidden" id="posurl_update"
                value="<?php echo base_url("ordermanage/order/getitemlist") ?>" />
            <input name="url" type="hidden" id="productdata"
                value="<?php echo base_url("ordermanage/order/getitemdata") ?>" />
            <input name="url" type="hidden" id="updatecarturl"
                value="<?php echo base_url("ordermanage/order/addtocartupdate") ?>" />
            <input name="url" type="hidden" id="cartupdateturl"
                value="<?php echo base_url("ordermanage/order/poscartupdate") ?>" />
            <input name="url" type="hidden" id="addonexsurl"
                value="<?php echo base_url("ordermanage/order/posaddonsmenu") ?>" />
            <input name="url" type="hidden" id="removeurl"
                value="<?php echo base_url("ordermanage/order/removetocart") ?>" />
            <div class="row">

                <div class="col-md-4">
                    <?php echo form_open_multipart('ordermanage/order/modifyoreder', ['class' => 'form-vertical', 'id' => 'insert_purchase', 'name' => 'insert_purchase']) ?>
                    <div class="leftSidebarPos update-height">
                        <div class="slimScrollDiv">
                            <input name="url" type="hidden" id="url"
                                value="<?php echo base_url("ordermanage/order/itemlistselect") ?>" />
                            <input name="url" type="hidden" id="addonsurl"
                                value="<?php echo base_url("ordermanage/order/addonsmenu") ?>" />
                            <input name="url" type="hidden" id="updatecarturl"
                                value="<?php echo base_url("ordermanage/order/addtocartupdate") ?>" />
                            <input name="url" type="hidden" id="delurl"
                                value="<?php echo base_url("ordermanage/order/deletetocart") ?>" />
                            <input name="updateid" type="hidden" id="uidupdateid"
                                value="<?php echo $orderinfo->order_id; ?>" />
                            <input name="custmercode" type="hidden" id="custmercode"
                                value="<?php echo $customerinfo->cuntomer_no ?? ''; ?>" />
                            <input name="custmername" type="hidden" id="custmername"
                                value="<?php echo $customerinfo->customer_name ?? ''; ?>" />
                            <input name="saleinvoice" type="hidden" id="saleinvoice"
                                value="<?php echo $orderinfo->saleinvoice ?? ''; ?>" />
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label for="customer_name"><?php echo display('customer_name'); ?> <span
                                            class="color-red">*</span></label>
                                    <div class="d-flex">
                                        <?php $cusid = 1;
                                        echo form_dropdown('customer_name', $customerlist, (!empty($orderinfo->customer_id) ? $orderinfo->customer_id : null), 'class="postform resizeselect custom-form-control form-control" id="customer_name_update" required') ?>
                                        <button type="button" class="btn btn-green ml-l" aria-hidden="true"
                                            data-toggle="modal" data-target="#client-info"><i
                                                class="ti-plus"></i></button>
                                    </div>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="store_id"><?php echo display('customer_type'); ?> <span
                                            class="color-red">*</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                    <?php $ctype = 1;
                                    echo form_dropdown('ctypeid', $curtomertype, (!empty($orderinfo->cutomertype) ? $orderinfo->cutomertype : null), 'class="form-control custom-form-control" id="ctypeid_update" required') ?>
                                </div>
                                <div id="nonthirdparty_update" class="col-md-12">
                                    <div class="row">
                                        <?php

                                        if ($possetting->waiter == 1) { ?>
                                        <div class="col-md-6 form-group">
                                            <label for="store_id"><?php echo display('waiter'); ?> <span
                                                    class="color-red">*</span>&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                            <?php echo form_dropdown('waiter', $waiterlist, (!empty($orderinfo->waiter_id) ? $orderinfo->waiter_id : null), 'class="form-control custom-form-control" id="waiter_update" required') ?>
                                        </div>
                                        <?php }

                                        if ($possetting->tableid == 1) {
                                        ?>
                                        <div class="col-md-6 form-group" id="tblsec_update display-none">
                                            <label
                                                for="store_id"><?php echo display('table'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span
                                                    class="color-red">*</span></label>
                                            <?php echo form_dropdown('tableid', $tablelist, (!empty($orderinfo->table_no) ? $orderinfo->table_no : null), 'class="form-control custom-form-control" id="tableid_update" required') ?>
                                        </div>
                                        <?php
                                        }

                                        ?>
                                    </div>
                                </div>
                                <div id="thirdparty_update" class="col-md-12 display-none">
                                    <div class="form-group">
                                        <label for="store_id"><?php echo display('del_company'); ?> <span
                                                class="color-red">*</span>&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                        <?php echo form_dropdown('delivercom', $thirdpartylist, (!empty($orderinfo->isthirdparty) ? $orderinfo->isthirdparty : null), 'class="form-control wpr_95" id="delivercom_update" required disabled="disabled"') ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" type="hidden" id="order_date" name="order_date" required
                                        value="<?php echo date('d-m-Y') ?>" />
                                    <input class="form-control" type="hidden" id="bill_info" name="bill_info" required
                                        value="<?php echo $billinfo->bill_status; ?>" />
                                    <input type="hidden" id="card_type" name="card_type"
                                        value="<?php echo $billinfo->payment_method_id; ?>" />
                                    <input type="hidden" id="orderstatus" name="orderstatus"
                                        value="<?php echo $orderinfo->order_status; ?>" />
                                    <input type="hidden" id="assigncard_terminal" name="assigncard_terminal" value="" />
                                    <input type="hidden" id="assignbank" name="assignbank" value="" />
                                    <input type="hidden" id="assignlastdigit" name="assignlastdigit" value="" />
                                    <input type="hidden" id="product_value" name="">
                                </div>

                            </div>
                            <div class="product-list">
                                <div id="updatefoodlist">

                                    <div class="">
                                        <div class="table-responsive">
                                            <table
                                                class="table table-fixed table-bordered table-hover bg-white item-table border-none mb-0"
                                                id="purchaseTable">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center"><?php echo display('item') ?> </th>
                                                        <th class="text-center"><?php echo display('varient_name') ?>
                                                        </th>
                                                        <th class="text-center wp_100">
                                                            <?php echo display('unit_price') ?></th>
                                                        <th class="text-center wp_100">Qnt.</th>
                                                        <th class="text-center"><?php echo display('total_price') ?>
                                                        </th>
                                                        <th class="text-center"><?php echo display('action') ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $this->load->model('ordermanage/order_model', 'ordermodel');
                                                    $i            = 0;
                                                    $totalamount  = 0;
                                                    $subtotal     = 0;
                                                    $pvat         = 0;
                                                    $total        = $orderinfo->totalamount;
                                                    $pdiscount    = 0;
                                                    $discount     = 0;
                                                    $multiplletax = [];

                                                    foreach ($iteminfo as $item) {
                                                        $i++;

                                                        if ($item->isgroup == 1) {
                                                            $isgroupidp = 1;
                                                            $isgroup    = $item->menu_id;
                                                        } else {
                                                            $isgroupidp = 0;
                                                            $isgroup    = 0;
                                                        }

                                                        if ($item->price > 0) {
                                                            $itemprice       = $item->price * $item->menuqty;
                                                            $itemsingleprice = $item->price;
                                                        } else {
                                                            $itemprice       = $item->mprice * $item->menuqty;
                                                            $itemsingleprice = $item->mprice;
                                                        }

                                                        $iteminfo         = $this->ordermodel->getiteminfo($item->menu_id);
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
                                                            $mypdiscount = $iteminfo->OffersRate * $itemprice / 100;
                                                            $pdiscount   = $pdiscount + ($iteminfo->OffersRate * $itemprice / 100);
                                                        } else {
                                                            $mypdiscount = 0;
                                                            $pdiscount   = $pdiscount + 0;
                                                        }

                                                        $adonsprice = 0;

                                                        if (!empty($item->add_on_id)) {
                                                            $addons    = explode(",", $item->add_on_id);
                                                            $addonsqty = explode(",", $item->addonsqty);
                                                            $text      = '&nbsp;&nbsp;<a class="text-right adonsmore" onclick="expand(' . $i . ')">More..</a>';
                                                            $x         = 0;

                                                            foreach ($addons as $addonsid) {
                                                                $adonsinfo  = $this->order_model->read('*', 'add_ons', ['add_on_id' => $addonsid]);
                                                                $adonsprice = $adonsprice + $adonsinfo->price * $addonsqty[$x];
                                                                $x++;
                                                            }

                                                            $nittotal  = $adonsprice;
                                                            $itemprice = $itemprice;
                                                        } else {
                                                            $nittotal = 0;
                                                            $text     = '';
                                                        }

                                                        $totalamount = $totalamount + $nittotal;
                                                        $subtotal    = $subtotal + $nittotal + $itemsingleprice * $item->menuqty;
                                                    ?>
                                                    <tr class="<?php if ($item->isupdate) echo 'tempCartData'; ?>">
                                                        <td>
                                                            <?php echo $item->ProductName; ?><?php echo $text; ?> <a
                                                                class="serach pl-5"
                                                                onclick="itemnote('<?php echo $item->row_id; ?>','<?php echo $item->notes; ?>',<?php echo $item->order_id; ?>,1,<?php echo $isgroup; ?>)"
                                                                title="<?php echo display('foodnote') ?>"> <i
                                                                    class="fa fa-sticky-note" aria-hidden="true"></i>
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <?php echo $item->variantName; ?>
                                                        </td>
                                                        <td class="text-right">
                                                            <?php

                                                                if ($currency->position == 1) {
                                                                    echo $currency->curr_icon;
                                                                }

                                                                ?> <?php echo $itemsingleprice; ?>
                                                            <?php

                                                                if ($currency->position == 2) {
                                                                    echo $currency->curr_icon;
                                                                }

                                                                ?> </td>
                                                        <td class="text-right">
                                                            <div class="d-flex align-center gap-8">
                                                                <a class="btn btn-danger btn-dicriment btn-sm btnrightalign"
                                                                    onclick="positemupdate('<?php echo $item->menu_id ?>',<?php echo $item->menuqty; ?>,'<?php echo $item->order_id; ?>','<?php echo $item->varientid ?>','<?php echo $isgroupidp; ?>','<?php echo $item->addonsuid ?>','del')"><i
                                                                        class="fa fa-minus"
                                                                        aria-hidden="true"></i></a><input
                                                                    class="exists_qty" type="hidden"
                                                                    name="select_qty_<?php echo $item->menu_id ?>"
                                                                    id="select_qty_<?php echo $item->menu_id ?>_<?php echo $item->varientid ?>"
                                                                    value="<?php echo $item->menuqty; ?>"> <span
                                                                    id="productionsetting-update-<?php echo $item->menu_id . '-' . $item->varientid ?>"><?php echo number_format($item->menuqty, 3); ?>
                                                                </span>
                                                                <a class="btn btn-info btn-incriment btn-sm btnleftalign"
                                                                    onclick="positemupdate('<?php echo $item->menu_id ?>',<?php echo $item->menuqty; ?>,'<?php echo $item->order_id; ?>','<?php echo $item->varientid ?>','<?php echo $isgroupidp; ?>','<?php echo $item->addonsuid ?>','add')"><i
                                                                        class="fa fa-plus" aria-hidden="true"></i></a>
                                                            </div>
                                                        </td>
                                                        <td class="text-right"><strong>
                                                                <?php

                                                                    if ($currency->position == 1) {
                                                                        echo $currency->curr_icon;
                                                                    }

                                                                    ?>
                                                                <?php echo number_format($itemprice - $mypdiscount, 3); ?>
                                                                <?php

                                                                    if ($currency->position == 2) {
                                                                        echo $currency->curr_icon;
                                                                    }

                                                                    ?> </strong></td>
                                                        <td class="text-right">
                                                            <?php

                                                                if ($orderinfo->order_status != 4) { ?>
                                                            <a class="btn btn-sm btnrightalign"
                                                                onclick="deletecart(<?php echo $item->row_id; ?>,<?php echo $item->order_id; ?>,<?php echo $item->menu_id ?>,<?php echo $item->varientid ?>,<?php echo $item->menuqty; ?>)">
                                                                <svg width="16" height="18" viewBox="0 0 16 18"
                                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                                        d="M0 3.9975C0 3.65763 0.27552 3.38212 0.615385 3.38212H15.3846C15.7245 3.38212 16 3.65763 16 3.9975C16 4.33737 15.7245 4.61289 15.3846 4.61289H0.615385C0.27552 4.61289 0 4.33737 0 3.9975Z"
                                                                        fill="#D43407" />
                                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                                        d="M13.8323 11.8018C13.5918 13.9802 13.4715 15.0694 12.8566 15.8213C12.6415 16.0842 12.3871 16.3121 12.1021 16.497C11.2873 17.0256 10.1915 17.0256 7.9998 17.0256C5.80824 17.0256 4.71244 17.0256 3.89755 16.497C3.61262 16.3121 3.35811 16.0842 3.14311 15.8213C2.5282 15.0694 2.4079 13.9801 2.16731 11.8018L1.24268 3.43009H14.757L13.8323 11.8018ZM9.64083 7.56119C9.98069 7.56119 10.2562 7.83672 10.2562 8.17658V12.2791C10.2562 12.619 9.98069 12.8945 9.64083 12.8945C9.30097 12.8945 9.02544 12.619 9.02544 12.2791V8.17658C9.02544 7.83672 9.30097 7.56119 9.64083 7.56119ZM6.97416 8.17658C6.97416 7.83672 6.69863 7.56119 6.35876 7.56119C6.0189 7.56119 5.74338 7.83672 5.74338 8.17658V12.2791C5.74338 12.619 6.0189 12.8945 6.35876 12.8945C6.69863 12.8945 6.97416 12.619 6.97416 12.2791V8.17658Z"
                                                                        fill="#D43407" />
                                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                                        d="M6.6362 2.5084e-06C6.64933 2.5084e-06 6.66246 1.07247e-05 6.67567 1.07247e-05H9.32429C9.3375 1.07247e-05 9.35071 2.5084e-06 9.36375 2.5084e-06C9.79132 -3.85172e-05 10.1739 -7.13422e-05 10.4833 0.0429974C10.822 0.0901769 11.1622 0.199239 11.438 0.484835C11.7109 0.767412 11.8122 1.11081 11.8565 1.45126C11.8975 1.76724 11.8974 2.15956 11.8974 2.60498V4.01428H10.6666V2.6428C10.6666 2.14812 10.6654 1.83692 10.636 1.60972C10.6085 1.39807 10.5665 1.35409 10.5527 1.33977L10.5519 1.33897C10.5401 1.32671 10.5035 1.28846 10.3135 1.26201C10.0993 1.23217 9.80379 1.23078 9.32429 1.23078H6.67567C6.19621 1.23078 5.90071 1.23217 5.68643 1.26201C5.49646 1.28846 5.45983 1.32671 5.44808 1.33897L5.44731 1.33977C5.43348 1.35409 5.39151 1.39807 5.36403 1.60972C5.33453 1.83692 5.33331 2.14812 5.33331 2.6428V4.01428H4.10254V2.6428C4.10254 2.63015 4.10254 2.61754 4.10254 2.60497C4.10251 2.15955 4.10248 1.76724 4.1435 1.45126C4.1877 1.11081 4.28908 0.767412 4.56195 0.484835C4.83772 0.199239 5.1779 0.0901769 5.51671 0.0429974C5.82606 -7.13422e-05 6.20867 -3.85172e-05 6.6362 2.5084e-06Z"
                                                                        fill="#D43407" />
                                                                </svg>
                                                            </a>
                                                            <?php }

                                                                ?>
                                                        </td>
                                                    </tr>
                                                    <?php

                                                        if (!empty($item->add_on_id)) {
                                                            $y = 0;

                                                            foreach ($addons as $addonsid) {
                                                                $adonsinfo  = $this->order_model->read('*', 'add_ons', ['add_on_id' => $addonsid]);
                                                                $adonsprice = $adonsprice + $adonsinfo->price * $addonsqty[$y];

                                                                /*for adonsval cal*/
                                                                if (!empty($taxinfos)) {
                                                                    $tax = 0;

                                                                    foreach ($taxinfos as $taxainfo) {

                                                                        $fildaname = 'tax' . $tax;

                                                                        if (!empty($adonsinfo->$fildaname)) {

                                                                            $avatcalc                 = ($adonsinfo->price * $addonsqty[$y]) * ($adonsinfo->$fildaname) / 100;
                                                                            $multiplletax[$fildaname] = $multiplletax[$fildaname] + $avatcalc;
                                                                        } else {
                                                                            $avatcalc                 = ($adonsinfo->price * $addonsqty[$y]) * $taxainfo['default_value'] / 100;
                                                                            $multiplletax[$fildaname] = $multiplletax[$fildaname] + $avatcalc;
                                                                        }

                                                                        $pvat = $pvat + $avatcalc;

                                                                        $avatcalc = 0;
                                                                        $tax++;
                                                                    }
                                                                }

                                                                /*adonse update val cal*/
                                                        ?>
                                                    <tr class="bg-deep-purple get_<?php echo $i; ?> hasaddons"
                                                        id="expandcol_<?php echo $i; ?>">
                                                        <td colspan="2">
                                                            <?php echo $adonsinfo->add_on_name; ?>
                                                        </td>
                                                        <td class="text-right">
                                                            <?php

                                                                        if ($currency->position == 1) {
                                                                            echo $currency->curr_icon;
                                                                        }

                                                                        ?> <?php echo $adonsinfo->price; ?>
                                                            <?php

                                                                        if ($currency->position == 2) {
                                                                            echo $currency->curr_icon;
                                                                        }

                                                                        ?> </td>
                                                        <td class="text-right">
                                                            <?php echo $addonsqty[$y]; ?></td>
                                                        <td class="text-right"><strong>
                                                                <?php

                                                                            if ($currency->position == 1) {
                                                                                echo $currency->curr_icon;
                                                                            }

                                                                            ?>
                                                                <?php echo $adonsinfo->price * $addonsqty[$y]; ?>
                                                                <?php

                                                                            if ($currency->position == 2) {
                                                                                echo $currency->curr_icon;
                                                                            }

                                                                            ?> </strong></td>
                                                        <td class="text-right">&nbsp;</td>
                                                    </tr>
                                                    <?php $y++;
                                                            }
                                                        }
                                                    }

                                                    $itemtotal = $subtotal;

                                                    if (empty($taxinfos)) {

                                                        if ($settinginfo->vat > 0) {
                                                            $calvat = ($itemtotal - $pdiscount) * $settinginfo->vat / 100;
                                                        } else {
                                                            $calvat = $pvat;
                                                        }
                                                    } else {
                                                        $calvat = $pvat;
                                                    }

                                                    $multiplletaxvalue = htmlentities(serialize($multiplletax));
                                                    ?>
                                                    <tr>
                                                        <td class="text-right" colspan="4">
                                                            <strong><?php echo display('subtotal') ?></strong>
                                                        </td>
                                                        <td class="text-right"><strong>
                                                                <?php

                                                                if ($currency->position == 1) {
                                                                    echo $currency->curr_icon;
                                                                }

                                                                ?>
                                                                <?php echo number_format($itemtotal - $pdiscount, 3); ?>
                                                                <?php

                                                                if ($currency->position == 2) {
                                                                    echo $currency->curr_icon;
                                                                }

                                                                ?> </strong></td>
                                                    </tr>
                                                </tbody>
                                                <tfoot>

                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                    <input name="subtotal" id="subtotal_update" type="hidden"
                                        value="<?php echo $subtotal; ?>" />
                                    <input name="multiplletaxvalue" id="multiplletaxvalue_update" type="hidden"
                                        value="<?php echo $multiplletaxvalue; ?>" />
                                    <?php $servicecharge = 0;

                                    if (empty($billinfo)) {
                                        $servicecharge = 0;
                                    } else {

                                        if ($settinginfo->service_chargeType == 0) {
                                            $servicecharge = $settinginfo->servicecharge;
                                        } else {
                                            $totalsercharge = $subtotal - $pdiscount;
                                            $servicecharge  = $settinginfo->servicecharge * $totalsercharge / 100;
                                        }

                                        $sdamount = $settinginfo->service_charge ?? 0;
                                    }

                                    ?>
                                    <?php
                                    $discount     = 0;
                                    $customerinfo = $this->ordermodel->read('*', 'customer_info', ['customer_id' => $billinfo->customer_id]);
                                    $mtype        = $this->order_model->read('*', 'membership', ['id' => $customerinfo->membership_type ?? '']);

                                    if (empty($billinfo)) {
                                        $discount = $pdiscount;
                                    } else {
                                        $newsubtotal = $subtotal - $pdiscount;

                                        if (isset($mtype->discount) && $mtype->discount > 0) {
                                            $discount = $pdiscount + ($mtype->discount * $newsubtotal / 100);
                                        }

                                        $disamount = $billinfo->discount;
                                    }

                                    ?>
                                    <input name="distype" id="distype_update" type="hidden"
                                        value="<?php echo $settinginfo->discount_type; ?>" />
                                    <input name="sdtype" id="sdtype_update" type="hidden"
                                        value="<?php echo $settinginfo->service_chargeType; ?>" />
                                    <input name="invoice_discount" class="text-right" id="invoice_discount_update"
                                        type="hidden" value="<?php echo $discount; ?>" />
                                    <table class="table table-bordered bg-white">

                                        <tr>
                                            <td class="text-right wpr_494">
                                                <strong>
                                                    <?php echo display('service_chrg') ?>
                                                    <?php

                                                    if ($settinginfo->service_chargeType == 0) {
                                                        echo "(" . $currency->curr_icon . ")";
                                                    } else {
                                                        echo "(%)";
                                                    }

                                                    ?>
                                                </strong>
                                            </td>
                                            <td class="text-right wpr_28">
                                                <strong>
                                                    <input name="service_charge" class="text-right"
                                                        id="service_charge_update" type="number" placeholder="0.00"
                                                        onkeyup="sumcalculation(1)"
                                                        value="<?php echo $settinginfo->servicecharge; ?>" />

                                                </strong>
                                            </td>
                                            <td class="text-right wpr_126">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td class="text-right wpr_494">
                                                <strong><?php echo display('vat_tax') ?></strong>
                                            </td>
                                            <td class="text-right wpr_28"><input id="vat_update" name="vat"
                                                    type="hidden" value="<?php echo $calvat; ?>" />
                                                <strong>
                                                    <?php

                                                    if ($currency->position == 1) {
                                                        echo $currency->curr_icon;
                                                    }

                                                    ?> <?php echo number_format($calvat, 3); ?>
                                                    <?php

                                                    if ($currency->position == 2) {
                                                        echo $currency->curr_icon;
                                                    }

                                                    ?> </strong>
                                            </td>
                                            <td class="text-right wpr_126">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td class="text-right wpr_494">
                                                <strong><?php echo display('grand_total') ?></strong>
                                            </td>
                                            <td class="text-right wpr_28"><input name="vat" id="tvat" type="hidden"
                                                    value="<?php echo $calvat; ?>" />
                                                <input name="tgtotal" type="hidden"
                                                    value="<?php echo $calvat + $itemtotal + $servicecharge - $discount; ?>"
                                                    id="tgtotal" />
                                                <input name="orginattotal" id="orginattotal_update" type="hidden"
                                                    value="<?php echo $calvat + $itemtotal + $servicecharge - $discount; ?>" />
                                                <input name="grandtotal" id="grandtotal_update" type="hidden"
                                                    value="<?php echo $calvat + $itemtotal + $servicecharge - $discount; ?>" />
                                                <?php

                                                if ($currency->position == 1) {
                                                    echo $currency->curr_icon;
                                                }

                                                ?> <strong id="gtotal_update">
                                                    <?php
                                                    $isvatinclusive = $this->db->select("*")->from('setting')->get()->row();

                                                    if ($isvatinclusive->isvatinclusive == 1) {
                                                        echo number_format($itemtotal + $servicecharge - $discount, 3);
                                                    } else {
                                                        echo number_format($calvat + $itemtotal + $servicecharge - $discount, 3);
                                                    }

                                                    ?>
                                                </strong> <?php

                                                            if ($currency->position == 2) {
                                                                echo $currency->curr_icon;
                                                            }

                                                            ?>
                                            </td>
                                            <td class="text-right wpr_126">&nbsp;</td>
                                        </tr>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="fixedclasspos">
                        <div class="bottomarea">
                            <div class="row">
                                <div class="col-sm-12 d-flex justify-content-end">
                                    <input name="getuv" id="uvchange" type="hidden" value="0" />
                                    <input type="button" id="update_order_confirm" onclick="postupdateorder_ajax()"
                                        class="btn btn-success my-6 btn-green btn-large cusbtn" name="add-payment"
                                        value="Order Update">
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>

                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-12">
                            <form class="navbar-search" method="get"
                                action="<?php echo base_url("ordermanage/order/pos_invoice") ?>">
                                <label class="sr-only screen-reader-text"
                                    for="search"><?php echo display('search') ?>:</label>
                                <div class="input-group search-custom">
                                    <select id="update_product_name"
                                        class="form-control custom-form-control dont-select-me  update_search-field"
                                        dir="ltr" name="s">
                                    </select>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-lg-2 pr-0">
                            <div class="leftSidebarPos bg-alice-blue p-10 pb-20 pb-sm-0">
                                <div class="slimScrollDiv">
                                    <div class="product-category ">
                                        <div class="listcat pos-category" onclick="getslcategory_update('')">All</div>
                                        <?php //$result = array_diff($categorylist, array("Select Food Category"));

                                        foreach ($allcategorylist as $category) {

                                            if (!empty($category->sub)) {
                                        ?>
                                        <div class="listcat dropdown cat-nav pos-category">
                                            <a class="btn dropdown-toggle listcat listcat2 listcat3 pos-category-sub">
                                                <?php echo $category->Name; ?>
                                                <span class="caret"></span>
                                            </a>
                                            <ul class="dropdown-menu dropcat display-none"
                                                id="updatenewtcat<?php echo $category->CategoryID; ?>">
                                                <?php

                                                        foreach ($category->sub as $subcat) { ?>
                                                <li class="lip-2 border-bottom-white"><a class="text-center"
                                                        onclick="getslcategory_update(<?php echo $subcat->CategoryID; ?>)"><?php echo $subcat->Name; ?></a>
                                                </li>
                                                <?php }

                                                        ?>
                                            </ul>


                                        </div>
                                        <?php
                                            } else { ?>

                                        <div class="listcat dropdown cat-nav pos-category"
                                            onclick="getslcategory_update(<?php echo $category->CategoryID; ?>)">
                                            <?php echo $category->Name; ?></div>
                                        <?php }
                                        }

                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9 col-lg-10">
                            <div class="leftSidebarPos bg-alice-blue pb-20">
                                <div class="slimScrollDiv">
                                    <div class="row m-3" id="product_search_update">
                                        <?php $i = 0;

                                        foreach ($itemlist as $item) {
                                            $item = (object) $item;
                                            $i++;

                                            if ($item->isgroup == 1) {
                                                $isgroupid = 1;
                                            } else {
                                                $isgroupid = 0;
                                            }

                                            $this->db->select('*');
                                            $this->db->from('menu_add_on');
                                            $this->db->where('menu_id', $item->ProductsID);
                                            $query    = $this->db->get();
                                            $getadons = "";

                                            if ($query->num_rows() > 0) {
                                                $getadons = 1;
                                            } else {
                                                $getadons = 0;
                                            }

                                        ?>
                                        <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3 p-6">
                                            <div
                                                class="panel panel-bd product-panel update_select_product rounded-lg border-none p-10 product-h m-0 bg-white">
                                                <div class="panel-body p-0">
                                                    <div class="pos-img-wrap">
                                                        <img src="<?php echo base_url(!empty($item->ProductImage) ? $item->ProductImage : 'assets/img/icons/default_pos_pro.jpg'); ?>"
                                                            class="img-responsive"
                                                            alt="<?php echo $item->ProductName; ?>">
                                                    </div>
                                                    <input type="hidden" name="update_select_product_id"
                                                        class="select_product_id"
                                                        value="<?php echo $item->ProductsID; ?>">
                                                    <input type="hidden" name="update_select_totalvarient"
                                                        class="select_totalvarient"
                                                        value="<?php echo $item->totalvarient; ?>">
                                                    <input type="hidden" name="update_select_iscustomeqty"
                                                        class="select_iscustomeqty"
                                                        value="<?php echo $item->is_customqty; ?>">
                                                    <input type="hidden" name="update_select_product_size"
                                                        class="select_product_size"
                                                        value="<?php echo $item->variantid; ?>">
                                                    <input type="hidden" name="update_select_product_isgroup"
                                                        class="select_product_isgroup"
                                                        value="<?php echo $isgroupid; ?>">
                                                    <input type="hidden" name="update_select_product_cat"
                                                        class="select_product_cat"
                                                        value="<?php echo $item->CategoryID; ?>">
                                                    <input type="hidden" name="update_select_varient_name"
                                                        class="select_varient_name"
                                                        value="<?php echo $item->variantName; ?>">
                                                    <input type="hidden" name="update_select_product_name"
                                                        class="select_product_name" value="
                                                        <?php echo $item->ProductName;

                                                        if (!empty($item->itemnotes)) {
                                                            echo " -" . $item->itemnotes;
                                                        }

                                                        ?>">
                                                    <input type="hidden" name="update_select_product_price"
                                                        class="select_product_price"
                                                        value="<?php echo $item->price; ?>">
                                                    <input type="hidden" name="update_select_addons"
                                                        class="select_addons" value="<?php echo $getadons; ?>">
                                                </div>
                                                <div class="text-center">
                                                    <h4 class="m-0 pt-12"><?php echo $item->ProductName; ?>
                                                        <?php

                                                            if (!empty($item->itemnotes)) {
                                                                echo " -" . $item->itemnotes;
                                                            }

                                                            ?></h4>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        }

                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url('ordermanage/order/possettingjs') ?>" type="text/javascript"></script>
<script src="<?php echo base_url('ordermanage/order/updateorderjs/' . $orderinfo->order_id) ?>" type="text/javascript">
</script>
<script src="<?php echo base_url('application/modules/ordermanage/assets/js/posupdate.js'); ?>" type="text/javascript">
</script>