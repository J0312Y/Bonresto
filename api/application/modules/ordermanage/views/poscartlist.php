<?php
$grtotal = 0;
$totalitem = 0;
$calvat = 0;
$discount = 0;
$itemtotal = 0;
$pvat = 0;
$multiplletax = array();
$this->load->model('ordermanage/order_model',  'ordermodel');
if ($cart = $this->cart->contents()) { ?>
<table class="table item-table border-none wpr_100 mb-0" border="1" id="addinvoice">
    <thead>
        <tr>
            <th><?php echo display('item') ?></th>
            <th><?php echo display('varient_name') ?></th>
            <th><?php echo display('price'); ?></th>
            <th class="text-center">Qnt.</th>
            <th><?php echo display('total'); ?></th>
            <th><?php echo display('action'); ?></th>
        </tr>
    </thead>
    <tbody class="itemNumber">
        <?php

      $i = 0;
      $totalamount = 0;
      $subtotal = 0;
      $pvat = 0;
      $discount = 0;
      $pdiscount = 0;
      foreach ($cart as $item) {
        $iteminfo = $this->ordermodel->getiteminfo($item['pid']);

        $itemprice = $item['price'] * $item['qty'];
        $mypdiscountprice = 0;
        if (!empty($taxinfos)) {
          $tx = 0;
          if ($iteminfo->OffersRate > 0) {
            $mypdiscountprice = $iteminfo->OffersRate * $itemprice / 100;
          }
          $itemvalprice =  ($itemprice - $mypdiscountprice);
          foreach ($taxinfos as $taxinfo) {
            //print_r($taxinfo);
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
          $mypdiscount = $iteminfo->OffersRate * $itemprice / 100;
          $pdiscount = $pdiscount + ($iteminfo->OffersRate * $itemprice / 100);
        } else {
          $mypdiscount = 0;
          $pdiscount = $pdiscount + 0;
        }
        if (!empty($item['addonsid'])) {
          $nittotal = $item['addontpr'];
          $itemprice = $itemprice + $item['addontpr'];
        } else {
          $nittotal = 0;
          $itemprice = $itemprice;
        }
        $totalamount = $totalamount + $nittotal;
        $subtotal = $subtotal + $nittotal + $item['price'] * $item['qty'];
        $i++;
        $totalitem = $i;
      ?>
        <tr id="<?php echo $i; ?>">
            <th id="product_name_MFU4E">
                <?php
            echo  $item['name'];
            echo "<br>";
            if (!empty($item['addonsid'])) {
              echo $item['addonname'];
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
            ?><a class="serach pl-15"
                    onclick="itemnote('<?php echo $item['rowid'] ?>','<?php echo $item['itemnote'] ?>',<?php echo $item['qty']; ?>,2)"
                    title="<?php echo display('foodnote') ?>"> <i class="fa fa-sticky-note" aria-hidden="true"></i> </a>
            </th>
            <td>
                <?php echo $item['size']; ?>
            </td>

            <td width="">
                <?php echo $item['price']; ?>
            </td>
            <td scope="row">
                <a class="btn btn-info btn-sm btn-incriment btnleftalign"
                    onclick="posupdatecart('<?php echo $item['rowid'] ?>',<?php echo $item['pid'] ?>,<?php echo $item['sizeid'] ?>,<?php echo $item['qty']; ?>,'add')"><i
                        class="fa fa-plus" aria-hidden="true"></i></a>
                <span id="productionsetting-<?php echo $item['pid'] . '-' . $item['sizeid'] ?>">
                    <?php echo $item['qty']; ?>
                </span>
                <a class="btn btn-danger btn-sm btn-dicriment btnrightalign"
                    onclick="posupdatecart('<?php echo $item['rowid'] ?>',<?php echo $item['pid'] ?>,<?php echo $item['sizeid'] ?>,<?php echo $item['qty']; ?>,'del')"><i
                        class="fa fa-minus" aria-hidden="true"></i></a>
            </td>
            <td width="">
                <?php echo $itemprice - $mypdiscount; ?>
            </td>

            <td width:"80"="">
                <a href="javascript:void(0);" class="btnrightalign"
                    onclick="removecart('<?php echo $item['rowid']; ?>')">
                    <svg width="16" height="18" viewBox="0 0 16 18" fill="none" xmlns="http://www.w3.org/2000/svg">
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
            </td>
        </tr>
        <?php }
      $itemtotal = $subtotal;
      /*check $taxsetting info*/
      if (empty($taxinfos)) {
        if ($settinginfo->vat > 0) {
          $calvat = ($itemtotal - $pdiscount) * $settinginfo->vat / 100;
        } else {
          $calvat = $pvat;
        }
      } else {
        $calvat = $pvat;
      }
      $grtotal = $itemtotal;
      ?>

        <input name="grandtotal" id="grtotal" type="hidden" value="<?php echo $grtotal - $pdiscount; ?>" />

    </tbody>
</table>
<?php }
if (!empty($this->cart->contents())) {
  if ($settinginfo->service_chargeType == 1) {
    $totalsercharge = $subtotal - $pdiscount;
    $servicetotal = $settinginfo->servicecharge * $totalsercharge / 100;
  } else {
    $servicetotal = $settinginfo->servicecharge;
  }
  $servicecharge = $settinginfo->servicecharge;
} else {
  $servicetotal = 0;
  $servicecharge = 0;
  $subtotal = 0;
  $pdiscount = 0;
}

$multiplletaxvalue = htmlentities(serialize($multiplletax));
?>
<input name="subtotal" id="subtotal" type="hidden" value="<?php echo $subtotal; ?>" />
<input name="totalitem" id="totalitem" type="hidden" value="<?php echo $totalitem; ?>" />
<input name="multiplletaxvalue" id="multiplletaxvalue" type="hidden" value="<?php echo $multiplletaxvalue; ?>" />
<input name="tvat" type="hidden" value="<?php echo $calvat; ?>" id="tvat" />
<input name="sc" type="hidden" value="<?php echo $servicecharge; ?>" id="sc" />
<input name="tdiscount" type="hidden" value="<?php echo $pdiscount; ?>" placeholder="0.00" id="tdiscount" />
<input name="tgtotal" type="hidden" value="<?php echo $calvat + $servicetotal + $itemtotal - $pdiscount; ?>"
    id="tgtotal" />