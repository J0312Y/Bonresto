<div class="table-wrapper-scroll-y">
    <div class="table-responsive">
        <table class="table table-fixed table-bordered table-hover bg-white item-table border-none mb-0"
            id="purchaseTable">
            <thead>
                <tr>
                    <th class="text-center"><?php echo display('item') ?></th>
                    <th class="text-center"><?php echo display('varient_name') ?></th>
                    <th class="text-center wp_100"><?php echo display('unit_price') ?></th>
                    <th class="text-center wp_100"><?php echo display('qty'); ?></th>
                    <th class="text-center"><?php echo display('total_price') ?></th>
                    <th class="text-center"><?php echo display('action') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 0;
                $totalamount                             = 0;
                $subtotal                                = 0;
                $total                                   = $orderinfo->totalamount;
                $pdiscount                               = 0;
                $discount                                = 0;
                $multiplletax                            = [];
                $pvat                                    = 0;

                foreach ($iteminfo as $item) {
                    $i++;

                    if ($item->isgroup == 1) {
                        $isgroupidp = 1;
                        $isgroup    = $item->menu_id;
                    } else {
                        $isgroupidp = 0;
                        $isgroup    = 0;
                    }

                    $iteminfor = $this->order_model->getiteminfo($item->menu_id);

                    if ($item->price > 0) {
                        $itemprice       = $item->price * $item->menuqty;
                        $itemsingleprice = $item->price;
                    } else {
                        $itemprice       = $item->mprice * $item->menuqty;
                        $itemsingleprice = $item->mprice;
                    }

                    $mypdiscountprice = 0;

                    if (!empty($taxinfos)) {
                        $tx = 0;

                        if ($iteminfor->OffersRate > 0) {

                            $mypdiscountprice = $iteminfor->OffersRate * $itemprice / 100;
                        }

                        $itemvalprice = ($itemprice - $mypdiscountprice);

                        foreach ($taxinfos as $taxinfo) {
                            $fildname = 'tax' . $tx;

                            if (!empty($iteminfor->$fildname)) {
                                $vatcalc                 = $itemvalprice * $iteminfor->$fildname / 100;
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
                        $vatcalc = $itemprice * $iteminfor->productvat / 100;
                        $pvat    = $pvat + $vatcalc;
                    }

                    if ($iteminfor->OffersRate > 0) {
                        $mypdiscount = $iteminfor->OffersRate * $itemprice / 100;
                        $pdiscount   = $pdiscount + ($iteminfor->OffersRate * $itemprice / 100);
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
                    $subtotal    = $subtotal + $nittotal + $itemprice;
                ?>
                    <tr class="<?php if ($item->isupdate) echo 'tempCartData'; ?>">
                        <td>
                            <?php echo $item->ProductName; ?>
                            <?php echo $text; ?>
                            <a class="serach pl-15"
                                onclick="itemnote('<?php echo $item->row_id; ?>','<?php echo $item->notes; ?>',<?php echo $item->order_id; ?>,1,<?php echo $isgroup; ?>)"
                                title="<?php echo display('foodnote') ?>">
                                <i class="fa fa-sticky-note" aria-hidden="true"></i>
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
                            ?>
                            <?php echo $itemsingleprice; ?>
                            <?php
                            if ($currency->position == 2) {
                                echo $currency->curr_icon;
                            }
                            ?>
                        </td>
                        <td class="text-right">
                            <div class="d-flex align-center gap-8">
                                <input type="hidden" class="exists_qty" name="select_qty_<?php echo $item->menu_id ?>"
                                    id="select_qty_<?php echo $item->menu_id ?>_<?php echo $item->varientid ?>"
                                    value="<?php echo $item->menuqty; ?>"><a
                                    class="btn btn-danger btn-dicriment btn-sm btnrightalign"
                                    onclick="positemupdate('<?php echo $item->menu_id ?>',<?php echo $item->menuqty; ?>,'<?php echo $item->order_id; ?>','<?php echo $item->varientid ?>','<?php echo $isgroupidp; ?>','<?php echo $item->addonsuid ?>','del')"><i
                                        class="fa fa-minus" aria-hidden="true"></i></a> <span
                                    id="productionsetting-update-<?php echo $item->menu_id . '-' . $item->varientid ?>"><?php echo number_format($item->menuqty, 3); ?>
                                </span><a class="btn btn-info btn-incriment btn-sm btnleftalign"
                                    onclick="positemupdate('<?php echo $item->menu_id ?>',<?php echo $item->menuqty; ?>,'<?php echo $item->order_id; ?>','<?php echo $item->varientid ?>','<?php echo $isgroupidp; ?>','<?php echo $item->addonsuid ?>','add')"><i
                                        class="fa fa-plus" aria-hidden="true"></i></a>
                            </div>
                        </td>
                        <td class="text-right">
                            <strong>
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
                                ?>
                            </strong>
                        </td>
                        <td class="text-right">
                            <?php

                            if ($this->permission->method('ordermanage', 'delete')->access()) { ?>
                                <a class="btn btn-sm btnrightalign"
                                    onclick="deletecart(<?php echo $item->row_id; ?>,<?php echo $item->order_id; ?>,<?php echo $item->menu_id ?>,<?php echo $item->varientid ?>,<?php echo $item->menuqty; ?>)">
                                    <svg width="16" height="18" viewBox="0 0 16 18" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M0 3.9975C0 3.65763 0.27552 3.38212 0.615385 3.38212H15.3846C15.7245 3.38212 16 3.65763 16 3.9975C16 4.33737 15.7245 4.61289 15.3846 4.61289H0.615385C0.27552 4.61289 0 4.33737 0 3.9975Z"
                                            fill="#D43407"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M13.8323 11.8018C13.5918 13.9802 13.4715 15.0694 12.8566 15.8213C12.6415 16.0842 12.3871 16.3121 12.1021 16.497C11.2873 17.0256 10.1915 17.0256 7.9998 17.0256C5.80824 17.0256 4.71244 17.0256 3.89755 16.497C3.61262 16.3121 3.35811 16.0842 3.14311 15.8213C2.5282 15.0694 2.4079 13.9801 2.16731 11.8018L1.24268 3.43009H14.757L13.8323 11.8018ZM9.64083 7.56119C9.98069 7.56119 10.2562 7.83672 10.2562 8.17658V12.2791C10.2562 12.619 9.98069 12.8945 9.64083 12.8945C9.30097 12.8945 9.02544 12.619 9.02544 12.2791V8.17658C9.02544 7.83672 9.30097 7.56119 9.64083 7.56119ZM6.97416 8.17658C6.97416 7.83672 6.69863 7.56119 6.35876 7.56119C6.0189 7.56119 5.74338 7.83672 5.74338 8.17658V12.2791C5.74338 12.619 6.0189 12.8945 6.35876 12.8945C6.69863 12.8945 6.97416 12.619 6.97416 12.2791V8.17658Z"
                                            fill="#D43407"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M6.6362 2.5084e-06C6.64933 2.5084e-06 6.66246 1.07247e-05 6.67567 1.07247e-05H9.32429C9.3375 1.07247e-05 9.35071 2.5084e-06 9.36375 2.5084e-06C9.79132 -3.85172e-05 10.1739 -7.13422e-05 10.4833 0.0429974C10.822 0.0901769 11.1622 0.199239 11.438 0.484835C11.7109 0.767412 11.8122 1.11081 11.8565 1.45126C11.8975 1.76724 11.8974 2.15956 11.8974 2.60498V4.01428H10.6666V2.6428C10.6666 2.14812 10.6654 1.83692 10.636 1.60972C10.6085 1.39807 10.5665 1.35409 10.5527 1.33977L10.5519 1.33897C10.5401 1.32671 10.5035 1.28846 10.3135 1.26201C10.0993 1.23217 9.80379 1.23078 9.32429 1.23078H6.67567C6.19621 1.23078 5.90071 1.23217 5.68643 1.26201C5.49646 1.28846 5.45983 1.32671 5.44808 1.33897L5.44731 1.33977C5.43348 1.35409 5.39151 1.39807 5.36403 1.60972C5.33453 1.83692 5.33331 2.14812 5.33331 2.6428V4.01428H4.10254V2.6428C4.10254 2.63015 4.10254 2.61754 4.10254 2.60497C4.10251 2.15955 4.10248 1.76724 4.1435 1.45126C4.1877 1.11081 4.28908 0.767412 4.56195 0.484835C4.83772 0.199239 5.1779 0.0901769 5.51671 0.0429974C5.82606 -7.13422e-05 6.20867 -3.85172e-05 6.6362 2.5084e-06Z"
                                            fill="#D43407"></path>
                                    </svg>

                                </a>
                            <?php } ?>
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
                                        $multiplletax[$fildaname] = @$multiplletax[$fildaname] + $avatcalc;
                                    } else {
                                        $avatcalc                 = ($adonsinfo->price * $addonsqty[$y]) * $taxainfo['default_value'] / 100;
                                        $multiplletax[$fildaname] = @$multiplletax[$fildaname] + $avatcalc;
                                    }

                                    $pvat = $pvat + $avatcalc;

                                    $avatcalc = 0;
                                    $tax++;
                                }
                            }

                            /*adonse update val cal*/
                    ?>
                            <tr class="bg-deep-purple get_<?php echo $i; ?> hasaddons" id="expandcol_<?php echo $i; ?>">
                                <td colspan="2">
                                    <?php echo $adonsinfo->add_on_name; ?>
                                </td>
                                <td class="text-right">
                                    <?php

                                    if ($currency->position == 1) {
                                        echo $currency->curr_icon;
                                    }

                                    ?>
                                    <?php echo $adonsinfo->price; ?>
                                    <?php

                                    if ($currency->position == 2) {
                                        echo $currency->curr_icon;
                                    }

                                    ?>
                                </td>
                                <td class="text-right"><?php echo $addonsqty[$y]; ?></td>
                                <td class="text-right">
                                    <strong>
                                        <?php

                                        if ($currency->position == 1) {
                                            echo $currency->curr_icon;
                                        }

                                        ?> <?php echo $adonsinfo->price * $addonsqty[$y]; ?>
                                        <?php

                                        if ($currency->position == 2) {
                                            echo $currency->curr_icon;
                                        }

                                        ?>
                                    </strong>
                                </td>
                                <td class="text-right">&nbsp;</td>
                            </tr>
                <?php $y++;
                        }
                    }
                }

                $itemtotal = $subtotal - $pdiscount;

                if (empty($taxinfos)) {

                    if ($settinginfo->vat > 0) {
                        $calvat = $itemtotal * $settinginfo->vat / 100;
                    } else {
                        $calvat = $pvat;
                    }
                } else {
                    $calvat = $pvat;
                }

                ?>
                <tr>
                    <td class="text-right" colspan="4"><strong><?php echo display('subtotal') ?></strong></td>
                    <td class="text-right">
                        <strong>
                            <?php

                            if ($currency->position == 1) {
                                echo $currency->curr_icon;
                            }

                            ?>
                            <?php echo number_format($itemtotal, 3); ?>
                            <?php

                            if ($currency->position == 2) {
                                echo $currency->curr_icon;
                            }

                            ?>
                        </strong>
                    </td>
                </tr>
            </tbody>
            <tfoot>

            </tfoot>
        </table>
    </div>
</div>
<input name="subtotal" id="subtotal_update" type="hidden" value="<?php echo $subtotal; ?>" />
<input name="multiplletaxvalue" id="multiplletaxvalue_update" type="hidden"
    value="<?php echo $multiplletaxvalue ?? 0; ?>" />
<table class="table table-bordered bg-white">
    <?php $servicecharge = 0;

    if (empty($billinfo)) {
        $servicecharge = 0;
    } else {

        if ($settinginfo->service_chargeType == 0) {
            $servicecharge = $billinfo->service_charge;
        } else {
            $servicecharge = $billinfo->service_charge * 100 / $billinfo->total_amount;
        }

        $sdamount = $billinfo->service_charge;
    }

    ?>
    <?php
    $discount = 0;
    $customerinfo = $this->order_model->read('*', 'customer_info', ['customer_id' => $billinfo->customer_id]);
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
    <input name="distype" id="distype_update" type="hidden" value="<?php echo $settinginfo->discount_type; ?>" />
    <input name="sdtype" id="sdtype_update" type="hidden" value="<?php echo $settinginfo->service_chargeType; ?>" />
    <input name="invoice_discount" class="text-right" id="invoice_discount_update" type="hidden"
        value="<?php echo $discount; ?>" />
    <tr>
        <td class="text-right wpr_494">
            <strong><?php echo display('service_chrg') ?>
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

                    $sdamount = $billinfo->service_charge;
                }

                ?>
                <input name="service_charge" class="text-right" id="service_charge_update" type="number"
                    placeholder="0.00" onkeyup="sumcalculation(1)" value="<?php echo $settinginfo->servicecharge; ?>" />

            </strong>
        </td>
        <td class="text-right wpr_126">&nbsp;</td>
    </tr>
    <tr>
        <td class="text-right wpr_494"><strong><?php echo display('vat_tax') ?></strong></td>
        <td class="text-right wpr_28">
            <input name="tvat" id="tvat" type="hidden" value="<?php echo $calvat; ?>" />
            <input id="vat_update" name="vat" type="hidden" value="<?php echo $calvat; ?>" />
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

                ?>
            </strong>
        </td>
        <td class="text-right wpr_126">&nbsp;</td>
    </tr>
    <tr>
        <td class="text-right wpr_494"><strong><?php echo display('grand_total') ?></strong></td>
        <td class="text-right wpr_28">
            <input name="tgtotal" type="hidden" value="<?php echo $calvat + $itemtotal + $servicecharge; ?>"
                id="tgtotal" />
            <input name="orginattotal" id="orginattotal_update" type="hidden"
                value="<?php echo $calvat + $itemtotal + $servicecharge; ?>" />
            <input name="grandtotal" id="grandtotal_update" type="hidden"
                value="<?php echo $calvat + $itemtotal + $servicecharge; ?>">
            <?php

            if ($currency->position == 1) {
                echo $currency->curr_icon;
            }

            ?>
            <strong id="gtotal_update">
                <?php
                $isvatinclusive = $this->db->select("*")->from('setting')->get()->row();

                if ($isvatinclusive->isvatinclusive == 1) {
                    echo number_format($itemtotal + $servicecharge, 3);
                } else {
                    echo number_format($calvat + $itemtotal + $servicecharge, 3);
                }

                ?></strong>
            <?php

            if ($currency->position == 2) {
                echo $currency->curr_icon;
            }

            ?>
        </td>
        <td class="text-right wpr_126">&nbsp;</td>
    </tr>
</table>