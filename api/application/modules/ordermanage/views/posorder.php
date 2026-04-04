<link rel="stylesheet" type="text/css"
    href="<?php echo base_url('application/modules/ordermanage/assets/css/posordernew.css?v=1.2'); ?>">
<script src="<?php echo base_url(); ?>assets/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo base_url('application/modules/ordermanage/assets/js/postop.js?v=1.2'); ?>"
    type="text/javascript">
</script>
<?php
(int) $new_version = @file_get_contents('https://update.bdtask.com/bhojon/autoupdate/update_info');
$myversion         = current_version();
function current_version()
{

    //Current Version
    $product_version = '';
    $path            = FCPATH . 'system/core/compat/lic.php';

    if (file_exists($path)) {

        // Open the file
        $whitefile = @file_get_contents($path);

        $file                = fopen($path, "r");
        $i                   = 0;
        $product_version_tmp = [];
        $product_key_tmp     = [];

        while (!feof($file)) {
            $line_of_text = fgets($file);

            if (strstr($line_of_text, 'product_version') && $i == 0) {
                $product_version_tmp = explode('=', strstr($line_of_text, 'product_version'));
                $i++;
            }
        }

        fclose($file);

        $product_version = trim(@$product_version_tmp[1]);
        $product_version = ltrim(@$product_version, '\'');
        $product_version = rtrim(@$product_version, '\';');

        return @$product_version;
    } else {
        //file is not exists
        return false;
    }
}

?>
<input name="site_url" type="hidden" value="<?php echo $soundsetting->nofitysound; ?>" id="site_url">

<?php $subtotal = 0;
$ptdiscount     = 0; ?>
<div id="openregister" class="modal fade  bd-example-modal-lg" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" id="openclosecash">

        </div>
    </div>
</div>
<div class="modal fade" id="vieworder" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5 class="modal-title" id="exampleModalLabel"><?php echo display('foodnote') ?></h5>

            </div>
            <div class="modal-body pd-15">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label" for="user_email"><?php echo display('foodnote') ?></label>
                            <textarea cols="45" rows="3" id="foodnote" class="form-control" name="foodnote"></textarea>
                            <input name="foodqty" id="foodqty" type="hidden" />
                            <input name="foodgroup" id="foodgroup" type="hidden" />
                            <input name="foodid" id="foodid" type="hidden" />
                            <input name="foodvid" id="foodvid" type="hidden" />
                            <input name="foodcartid" id="foodcartid" type="hidden" />

                        </div>
                    </div>
                    <div class="col-md-4">
                        <a onclick="addnotetoitem()" class="btn btn-success btn-md text-white"
                            id="notesmbt"><?php echo display('addnotesi') ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content border-none">
            <div class="modal-body p-0">
                <div class="position-relative">
                    <div class="calcbody">
                        <form name="calc">
                            <div class="cacldisplay">
                                <input type="text" placeholder="0" name="displayResult" />
                            </div>
                            <div class="calcbuttons">
                                <div class="calcrow">
                                    <input type="button" name="c0" value="C" placeholder="0"
                                        onClick="calcNumbers(c0.value)">
                                    <button type="button" data-dismiss="modal" aria-label="Close"> <i
                                            class="fa fa-power-off" aria-hidden="true"></i> </button>
                                </div>
                                <div class="calcrow">
                                    <input type="button" name="b7" value="7" onClick="calcNumbers(b7.value)">
                                    <input type="button" name="b8" value="8" onClick="calcNumbers(b8.value)">
                                    <input type="button" name="b9" value="9" onClick="calcNumbers(b9.value)">
                                    <input type="button" name="addb" value="+" onClick="calcNumbers(addb.value)">
                                </div>
                                <div class="calcrow">
                                    <input type="button" name="b4" value="4" onClick="calcNumbers(b4.value)">
                                    <input type="button" name="b5" value="5" onClick="calcNumbers(b5.value)">
                                    <input type="button" name="b6" value="6" onClick="calcNumbers(b6.value)">
                                    <input type="button" name="subb" value="-" onClick="calcNumbers(subb.value)">
                                </div>
                                <div class="calcrow">
                                    <input type="button" name="b1" value="1" onClick="calcNumbers(b1.value)">
                                    <input type="button" name="b2" value="2" onClick="calcNumbers(b2.value)">
                                    <input type="button" name="b3" value="3" onClick="calcNumbers(b3.value)">
                                    <input type="button" name="mulb" value="*" onClick="calcNumbers(mulb.value)">
                                </div>
                                <div class="calcrow">
                                    <input type="button" name="b0" value="0" onClick="calcNumbers(b0.value)">
                                    <input type="button" name="potb" value="." onClick="calcNumbers(potb.value)">
                                    <input type="button" name="divb" value="/" onClick="calcNumbers(divb.value)">
                                    <input type="button" class="calcred" value="="
                                        onClick="displayResult.value = eval(displayResult.value)">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="payprint" class="modal fade  bd-example-modal-lg" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <strong><?php echo display('sl_payment'); ?></strong>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div class="panel">
                            <div class="panel-body">
                                <div class="col-md-8">
                                    <div class="form-group row">
                                        <label for="payments"
                                            class="col-sm-4 col-form-label"><?php echo display('paymd'); ?></label>
                                        <div class="col-sm-7 customesl">
                                            <?php $card_type = 4;
                                            echo form_dropdown('card_typesl', $paymentmethod, (!empty($card_type) ? $card_type : null), 'class="postform resizeselect form-control" id="card_typesl"') ?>
                                        </div>
                                    </div>
                                    <div id="cardarea wpr_100 display-none">
                                        <div class="form-group row">
                                            <label for="card_terminal"
                                                class="col-sm-4 col-form-label"><?php echo display('crd_terminal'); ?></label>
                                            <div class="col-sm-7 customesl">
                                                <?php echo form_dropdown('card_terminal', $terminalist, '', 'class="postform resizeselect form-control" id="card_terminal"') ?>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="bank"
                                                class="col-sm-4 col-form-label"><?php echo display('sl_bank'); ?></label>
                                            <div class="col-sm-7 customesl">
                                                <?php echo form_dropdown('bank', $banklist, '', 'class="postform resizeselect form-control" id="bank"') ?>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="4digit"
                                                class="col-sm-4 col-form-label"><?php echo display('lstdigit'); ?></label>
                                            <div class="col-sm-7 customesl">
                                                <input type="text" class="form-control" id="last4digit"
                                                    name="last4digit" value="" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="4digit"
                                            class="col-sm-4 col-form-label"><?php echo display('total_amount'); ?></label>
                                        <div class="col-sm-7 customesl">
                                            <input type="hidden" id="maintotalamount" name="maintotalamount" value="" />
                                            <input type="text" class="form-control" id="totalamount" name="totalamount"
                                                readonly="readonly" value="" />
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="4digit"
                                            class="col-sm-4 col-form-label"><?php echo display('cuspayment'); ?></label>
                                        <div class="col-sm-7 customesl">
                                            <input type="number" class="form-control" id="paidamount" name="paidamount"
                                                placeholder="0" />
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="4digit"
                                            class="col-sm-4 col-form-label"><?php echo display('cuspayment'); ?></label>
                                        <div class="col-sm-7 customesl">
                                            <input type="text" class="form-control" id="change" name="change"
                                                readonly="readonly" value="" />
                                        </div>
                                    </div>
                                    <div class="form-group text-right">
                                        <div class="col-sm-11 pr-0">
                                            <button type="button" id="paidbill" class="btn btn-success w-md m-b-5"
                                                onclick="orderconfirmorcancel()"><?php echo display('pay_print'); ?></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <form name="placenum">
                                        <div class="grid-container">
                                            <input type="button" class="grid-item" name="n1" value="1"
                                                onClick="inputNumbers(n1.value)">
                                            <input type="button" class="grid-item" name="n2" value="2"
                                                onClick="inputNumbers(n2.value)">
                                            <input type="button" class="grid-item" name="n3" value="3"
                                                onClick="inputNumbers(n3.value)">
                                            <input type="button" class="grid-item" name="n4" value="4"
                                                onClick="inputNumbers(n4.value)">
                                            <input type="button" class="grid-item" name="n5" value="5"
                                                onClick="inputNumbers(n5.value)">
                                            <input type="button" class="grid-item" name="n6" value="6"
                                                onClick="inputNumbers(n6.value)">
                                            <input type="button" class="grid-item" name="n7" value="7"
                                                onClick="inputNumbers(n7.value)">
                                            <input type="button" class="grid-item" name="n8" value="8"
                                                onClick="inputNumbers(n8.value)">
                                            <input type="button" class="grid-item" name="n9" value="9"
                                                onClick="inputNumbers(n9.value)">
                                            <input type="button" class="grid-item" name="n10" value="10"
                                                onClick="inputNumbers(n10.value)">
                                            <input type="button" class="grid-item" name="n20" value="20"
                                                onClick="inputNumbers(n20.value)">
                                            <input type="button" class="grid-item" name="n50" value="50"
                                                onClick="inputNumbers(n50.value)">
                                            <input type="button" class="grid-item" name="n100" value="100"
                                                onClick="inputNumbers(n100.value)">
                                            <input type="button" class="grid-item" name="n500" value="500"
                                                onClick="inputNumbers(n500.value)">
                                            <input type="button" class="grid-item" name="n1000" value="1000"
                                                onClick="inputNumbers(n1000.value)">
                                            <input type="button" class="grid-item" name="n0" value="0"
                                                onClick="inputNumbers(n0.value)">
                                            <input type="button" class="grid-item" name="n00" value="00"
                                                onClick="inputNumbers(n00.value)">
                                            <input type="button" class="grid-item" name="c0" value="C" placeholder="0"
                                                onClick="inputNumbers(c0.value)">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="paymentsselect" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <strong><?php echo display('sl_payment'); ?></strong>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div class="panel">
                            <div class="panel-body">
                                <div class="form-group row">
                                    <label for="payments"
                                        class="col-sm-4 col-form-label"><?php echo display('paymd'); ?></label>
                                    <div class="col-sm-7 customesl">
                                        <?php $card_type = 4;
                                        echo form_dropdown('card_typesl', $paymentmethod, (!empty($card_type) ? $card_type : null), 'class="postform resizeselect form-control" id="card_typesl"') ?>
                                    </div>
                                </div>
                                <div id="cardarea display-none wpr_100">
                                    <div class="form-group row">
                                        <label for="card_terminal"
                                            class="col-sm-4 col-form-label"><?php echo display('crd_terminal'); ?></label>
                                        <div class="col-sm-7 customesl">
                                            <?php echo form_dropdown('card_terminal', $terminalist, '', 'class="postform resizeselect form-control" id="card_terminal"') ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="bank"
                                            class="col-sm-4 col-form-label"><?php echo display('sl_bank'); ?></label>
                                        <div class="col-sm-7 customesl">
                                            <?php echo form_dropdown('bank', $banklist, '', 'class="postform resizeselect form-control" id="bank"') ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="4digit"
                                            class="col-sm-4 col-form-label"><?php echo display('lstdigit'); ?></label>
                                        <div class="col-sm-7 customesl">
                                            <input type="text" class="form-control" id="last4digit" name="last4digit"
                                                value="" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group text-right">
                                    <div class="col-sm-11 pr-0">
                                        <button type="button" class="btn btn-success w-md m-b-5"
                                            onclick="onlinepay()"><?php echo display('payn'); ?></button>
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
<div id="cancelord" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <strong><?php echo display('can_ord'); ?></strong>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div class="panel">
                            <div class="panel-body">
                                <div class="form-group row">
                                    <label for="payments"
                                        class="col-sm-4 col-form-label"><?php echo display('ordid'); ?></label>
                                    <div class="col-sm-7 customesl"> <span id="canordid"></span>
                                        <input name="mycanorder" id="mycanorder" type="hidden" value="" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="canreason"
                                        class="col-sm-4 col-form-label"><?php echo display('can_reason'); ?></label>
                                    <div class="col-sm-7 customesl">
                                        <textarea name="canreason" id="canreason" cols="35" rows="3"
                                            class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="form-group text-right">
                                    <div class="col-sm-11 pr-0">
                                        <button type="button" class="btn btn-success w-md m-b-5"
                                            id="cancelreason"><?php echo display('submit'); ?></button>
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
<div id="edit" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <strong>
                    <?php //echo display('unit_update');
                    ?>
                </strong>
            </div>
            <div class="modal-body addonsinfo"> </div>
        </div>
        <div class="modal-footer"> </div>
    </div>
</div>
<!-- 22-09 -->
<div id="payprint_marge" class="modal fade  bd-example-modal-lg" role="dialog">
    <div class="modal-dialog modal-lg" id="modal-ajaxview"> </div>
</div>
<div id="tablemodal" class="modal fade  bd-example-modal-lg" role="dialog">
    <div class="modal-dialog modal-inner" id="table-ajaxview"> </div>
</div>
<div id="payprint_split" class="modal fade  bd-example-modal-lg" role="dialog">
    <div class="modal-dialog modal-lg" id="modal-ajaxview-split"> </div>
</div>

<?php echo form_open('ordermanage/order/insert_customer', 'method="post" class="form-vertical" id="validate"') ?>
<div class="modal fade modal-warning" id="client-info" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h3 class="modal-title"><?php echo display('add_customer'); ?></h3>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label for="name" class="col-sm-3 col-form-label"><?php echo display('customer_name'); ?> <i
                            class="text-danger">*</i></label>
                    <div class="col-sm-6">
                        <input class="form-control simple-control" name="customer_name" id="name" type="text"
                            placeholder="Customer Name" required="">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="email" class="col-sm-3 col-form-label"><?php echo display('email'); ?> <i
                            class="text-danger">*</i></label>
                    <div class="col-sm-6">
                        <input class="form-control" name="email" id="email" type="email" placeholder="Customer Email"
                            required="">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="mobile" class="col-sm-3 col-form-label"><?php echo display('mobile'); ?> <i
                            class="text-danger">*</i></label>
                    <div class="col-sm-6">
                        <input class="form-control" name="mobile" id="mobile" type="number"
                            placeholder="Customer Mobile" required="" min="0">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="address " class="col-sm-3 col-form-label"><?php echo display('b_address'); ?></label>
                    <div class="col-sm-6">
                        <textarea class="form-control" name="address" id="address " rows="3"
                            placeholder="Customer Address"></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="address " class="col-sm-3 col-form-label"><?php echo display('fav_addesrr'); ?></label>
                    <div class="col-sm-6">
                        <textarea class="form-control" name="favaddress" id="favaddress " rows="3"
                            placeholder="Customer Address"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo display('close'); ?>
                </button>
                <button type="submit" class="btn btn-success"><?php echo display('submit'); ?> </button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
</form>
<div class="modal fade modal-warning" id="myModal" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h3 class="modal-title"></h3>
            </div>
            <form id="updateCart" action="#" method="post">
                <div class="modal-body">
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <th class="wpr_25">Price</th>
                                <th class="wpr_25"><span id="net_price" class="price"></span></th>
                            </tr>
                        </tbody>
                    </table>
                    <div class="form-group row">
                        <label for="available_quantity" class="col-sm-4 col-form-label">Ava. Qnty</label>
                        <div class="col-sm-8">
                            <input class="form-control" type="text" id="available_quantity" placeholder="Ava. Qnty"
                                name="available_quantity" readonly="readonly">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="unit" class="col-sm-4 col-form-label">Unit</label>
                        <div class="col-sm-8">
                            <input class="form-control" type="text" id="unit" placeholder="Unit" name="unit"
                                readonly="readonly">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="Qnty" class="col-sm-4 col-form-label">Qnty <span class="color-red">*</span></label>
                        <div class="col-sm-8">
                            <input class="form-control" type="text" id="Qnty" name="quantity">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="Rate" class="col-sm-4 col-form-label">Rate <span class="color-red">*</span></label>
                        <div class="col-sm-8">
                            <input class="form-control" type="text" id="Rate" name="rate">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="Dis/ Pcs" class="col-sm-4 col-form-label">Dis/ Pcs</label>
                        <div class="col-sm-8">
                            <input class="form-control" type="text" id="Dis/ Pcs" placeholder="Dis/ Pcs"
                                name="discount">
                        </div>
                    </div>
                    <input type="hidden" name="rowID">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save Changes</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<?php

$scan  = scandir('application/modules/');
$qrapp = 0;

foreach ($scan as $file) {

    if ($file == "qrapp") {

        if (file_exists(APPPATH . 'modules/' . $file . '/assets/data/env')) {
            $qrapp = 1;
        }
    }
}

?>
<input name="csrfres" id="csrfresarvation" type="hidden"
    value="<?php echo $this->security->get_csrf_token_name(); ?>" />
<input name="csrfhash" id="csrfhashresarvation" type="hidden" value="<?php echo $this->security->get_csrf_hash(); ?>" />
<div class="row pos">
    <div class="panel">
        <div class="panel-body">
            <div class="tabsection"> <span class="display-none"><?php echo $settinginfo->language; ?></span>
                <ul class="nav nav-tabs" role="tablist">
                    <li><a href="<?php echo base_url() ?>dashboard/home" class="maindashboard">
                            <svg width="22" height="17" viewBox="0 0 22 17" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M7.44618 16.1752C7.44618 16.6294 7.82502 16.9976 8.29233 16.9976C8.75963 16.9976 9.13848 16.6294 9.13848 16.1752H7.44618ZM8.29233 13.7286L7.4468 13.6971C7.44639 13.7077 7.44618 13.7181 7.44618 13.7286H8.29233ZM11 11.2832L10.9702 12.1051C10.9901 12.1057 11.0099 12.1057 11.0298 12.1051L11 11.2832ZM13.7077 13.7286H14.5538C14.5538 13.7181 14.5536 13.7077 14.5533 13.6971L13.7077 13.7286ZM12.8615 16.1752C12.8615 16.6294 13.2404 16.9976 13.7077 16.9976C14.175 16.9976 14.5538 16.6294 14.5538 16.1752H12.8615ZM8.29233 15.3527C7.82502 15.3527 7.44618 15.7209 7.44618 16.1752C7.44618 16.6294 7.82502 16.9976 8.29233 16.9976V15.3527ZM13.7077 16.9976C14.175 16.9976 14.5538 16.6294 14.5538 16.1752C14.5538 15.7209 14.175 15.3527 13.7077 15.3527V16.9976ZM8.29233 16.9976C8.75963 16.9976 9.13848 16.6294 9.13848 16.1752C9.13848 15.7209 8.75963 15.3527 8.29233 15.3527V16.9976ZM7.61541 16.1752V15.3527C7.60548 15.3527 7.59556 15.3528 7.58563 15.3531L7.61541 16.1752ZM3.55391 12.5059H2.70776C2.70776 12.5162 2.70796 12.5266 2.70837 12.537L3.55391 12.5059ZM4.40005 5.15196C4.40005 4.69774 4.02122 4.3295 3.55391 4.3295C3.0866 4.3295 2.70776 4.69774 2.70776 5.15196H4.40005ZM0.371038 6.25785C-0.0156291 6.5129 -0.116321 7.02436 0.14612 7.40027C0.408573 7.77608 0.934775 7.8739 1.32143 7.61883L0.371038 6.25785ZM4.0291 5.83248C4.41577 5.57737 4.51646 5.0659 4.25402 4.69007C3.99157 4.31424 3.46536 4.21636 3.07871 4.47146L4.0291 5.83248ZM3.07871 4.47146C2.69203 4.72653 2.59135 5.23798 2.85377 5.61383C3.1162 5.98968 3.64243 6.08755 4.0291 5.83248L3.07871 4.47146ZM9.43858 1.26995L8.97951 0.579053C8.9741 0.582453 8.96868 0.585907 8.96338 0.589427L9.43858 1.26995ZM12.5614 1.26995L13.0366 0.589427C13.0313 0.585907 13.0259 0.582453 13.0205 0.579053L12.5614 1.26995ZM17.9709 5.8325C18.3576 6.08757 18.8838 5.98968 19.1463 5.61383C19.4087 5.23798 19.3079 4.72651 18.9213 4.47144L17.9709 5.8325ZM13.7077 15.3527C13.2404 15.3527 12.8615 15.7209 12.8615 16.1752C12.8615 16.6294 13.2404 16.9976 13.7077 16.9976V15.3527ZM14.3846 16.1752L14.4144 15.3531C14.4044 15.3528 14.3945 15.3527 14.3846 15.3527V16.1752ZM18.4461 12.5059L19.2917 12.537C19.292 12.5266 19.2922 12.5162 19.2922 12.5059H18.4461ZM19.2922 5.15196C19.2922 4.69774 18.9134 4.3295 18.4461 4.3295C17.9788 4.3295 17.6 4.69774 17.6 5.15196H19.2922ZM20.6788 7.61784C21.0655 7.87292 21.5917 7.77488 21.854 7.39896C22.1163 7.02304 22.0155 6.51158 21.6287 6.25662L20.6788 7.61784ZM18.9213 4.47144C18.5345 4.21644 18.0082 4.31436 17.7458 4.69027C17.4835 5.06618 17.5842 5.57751 17.9709 5.8325L18.9213 4.47144ZM9.13848 16.1752V13.7286H7.44618V16.1752H9.13848ZM9.13791 13.76C9.17514 12.8118 9.99467 12.0716 10.9702 12.1051L11.0298 10.4611C9.12212 10.3959 7.51966 11.8431 7.4468 13.6971L9.13791 13.76ZM11.0298 12.1051C12.0053 12.0716 12.8249 12.8118 12.8621 13.76L14.5533 13.6971C14.4804 11.8431 12.8779 10.3959 10.9702 10.4611L11.0298 12.1051ZM12.8615 13.7286V16.1752H14.5538V13.7286H12.8615ZM8.29233 16.9976H13.7077V15.3527H8.29233V16.9976ZM8.29233 15.3527H7.61541V16.9976H8.29233V15.3527ZM7.58563 15.3531C5.88889 15.4113 4.46377 14.1237 4.39944 12.4747L2.70837 12.537C2.80803 15.0921 5.01618 17.0871 7.6452 16.9971L7.58563 15.3531ZM4.40005 12.5059V5.15196H2.70776V12.5059H4.40005ZM1.32143 7.61883L4.0291 5.83248L3.07871 4.47146L0.371038 6.25785L1.32143 7.61883ZM4.0291 5.83248L9.91377 1.95049L8.96338 0.589427L3.07871 4.47146L4.0291 5.83248ZM9.89764 1.96085C10.5687 1.53961 11.4313 1.53961 12.1024 1.96085L13.0205 0.579053C11.7906 -0.193018 10.2094 -0.193018 8.97951 0.579053L9.89764 1.96085ZM12.0862 1.95049L17.9709 5.8325L18.9213 4.47144L13.0366 0.589427L12.0862 1.95049ZM13.7077 16.9976H14.3846V15.3527H13.7077V16.9976ZM14.3548 16.9971C16.9838 17.0871 19.1919 15.0921 19.2917 12.537L17.6005 12.4747C17.5362 14.1237 16.1111 15.4113 14.4144 15.3531L14.3548 16.9971ZM19.2922 12.5059V5.15196H17.6V12.5059H19.2922ZM21.6287 6.25662L18.9213 4.47144L17.9709 5.8325L20.6788 7.61784L21.6287 6.25662Z"
                                    fill="white" />
                            </svg>
                            <span>Home</span>
                        </a></li>
                    <li class="active"> <a href="#home" role="tab" data-toggle="tab"
                            title="<?php echo display('nw_order') ?>" id="fhome" autofocus
                            class="home newtab new-order-tab" onclick="giveselecttab(this)"><i
                                class="fa fa-plus smallview"></i> <span
                                class="responsiveview"><?php echo display('nw_order'); ?></span> </a></li>
                    <li><a href="#profile" role="tab" data-toggle="tab" class="ongord newtab ongo-order-tab"
                            id="ongoingorder" onclick="giveselecttab(this)"><i
                                class="fa fa-hourglass-start smallview"></i> <span
                                class="responsiveview"><?php echo display('ongoingorder'); ?></span> </a> </li>
                    <li><a href="#kitchen" role="tab" data-toggle="tab" class="torder newtab kitchen-order-tab"
                            id="kitchenorder" onclick="giveselecttab(this)"><i class="fa fa-coffee smallview"></i> <span
                                class="responsiveview"><?php echo display('kitchen_status'); ?></span> </a> </li>
                    <?php

                    if ($qrapp == 1) { ?>
                    <li class="seelist2"> <a href="#qrorder" role="tab" data-toggle="tab" id="todayqrorder"
                            class="home newtab kitchen-order-tab" onclick="giveselecttab(this)"><i
                                class="fa fa-qrcode smallview"></i> <span
                                class="responsiveview"><?php echo display('qr-order'); ?></span> </a> <a href=""
                            class="notif2"><span class="label label-danger count2">0</span></a> </li>
                    <?php }

                    ?>
                    <li class="seelist"> <a href="#settings" role="tab" data-toggle="tab"
                            class="comorder newtab online-order-tab" id="todayonlieorder"
                            onclick="giveselecttab(this)"><i class="fa fa-shopping-bag smallview"></i> <span
                                class="responsiveview"><?php echo display('onlineord'); ?></span> </a> <a href=""
                            class="notif order-notify"><span class="label label-danger count order-label">02</span></a>
                    </li>
                    <li> <a href="#messages" role="tab" data-toggle="tab" class="torder newtab today-order-tab"
                            id="todayorder" onclick="giveselecttab(this)"><i class="fa fa-first-order smallview"></i>
                            <span class="responsiveview"><?php echo display('tdayorder'); ?></span> </a> </li>

                    <li class="mobiletag"><a href="javascript:;" class="btn bg-soft-blue" onclick="closeopenresister()"
                            role="button"><i class="fa fa-window-close"></i></a></li>
                    <li class="mobiletag"><a href="#" class="bg-soft-red"><i
                                class="fa fa-keyboard bg-soft-red hover-q text-muted" aria-hidden="true"
                                data-container="body" data-toggle="popover" data-placement="bottom" data-content="<table class='table table-condensed table-striped' >
        <tr>
            <th>Operations</th>
            <th>Keyboard Shortcut</th>
            <th>Operations</th>
            <th>Keyboard Shortcut</th>
        </tr>
        <tr>
        <td>New Order Tab</td>
        <td>Shift+N</td>
        <td>On Going Tab</td>
        <td>Shift+G</td>
        </tr>
        <tr>
        <td>Today Order Tab</td>
        <td>Shift+T</td>
        <td>Online Order Tab</td>
        <td>Shift+O</td>
        </tr>
        <tr>
        <td>Place Order</td>
        <td>Shift+P</td>
        <td>Quick Order</td>
        <td>Shift+Q</td>
        </tr>
        <tr>
        <td>Search Product</td>
        <td>Shift+S</td>
        <td>Select Customer</td>
        <td>Shift+C</td>
        </tr>
        <tr>
        <td>Select Customer Type</td>
        <td>Shift+Y</td>
        <td>Edit Discount:</td>
        <td>Shift+D</td></tr>
        <tr>
        <td>Edit Service Charge</td>
        <td>Shift+R</td>
        <td>Select Waiter</td>
        <td>Shift+W</td>
        </tr>
        <tr>
        <td>Select Table</td>
        <td>Shift+B</td>
        <td>Cooking Time</td>
        <td>Alt+K</td></tr>
        <tr>
        <td>Search Table</td>
        <td>Alt+T</td>
        <td>Go Edit</td>
        <td>Shift+E</td></tr>
        <tr>
        <td>Search Today Order</td>
        <td>Shift+X</td>
        <td>Search Online Order</td>
        <td>Shift+V</td>
        </tr>
        <tr>
        <td>Update Search Product</td>
        <td>Alt+S</td>
        <td>Update Select Customer</td>
        <td>Alt+C</td>
        </tr>
        <tr>
        <td>Update Select Customer Type</td>
        <td>Alt+Y</td>
        <td>Update Discount:</td>
        <td>Alt+D</td></tr>
        <tr>
        <td>Update Service Charge:</td>
        <td>Alt+R</td>
        <td>Update Select Table</td>
        <td>Alt+B</td>
        </tr>

        <td>Update Submit From</td>
        <td>Alt+U</td>
        <td>Select Payment Type</td>
        <td>Alt+M</td></tr>
        <tr>
        <td>Pay & Print Bill</td>
        <td>Alt+P</td>
        <td>Paid Amount Typing</td>
        <td>Alt+A</td></tr>
    </table>" data-html="true" data-trigger="hover" data-original-title="" title=""></i></a></li>
                    <li class="mobiletag">
                        <?php $languagenames = $this->db->field_data('language'); ?>
                        <!-- for language -->
                        <div class="dropdown dropdown-user">

                            <a href="#" class="btn dropdown-toggle lang_box" data-toggle="dropdown">
                                <?php

                                if ($this->session->has_userdata('language')) {
                                    echo mb_strimwidth(strtoupper($this->session->userdata('language')), 0, 3, '');
                                } else {
                                    echo mb_strimwidth(strtoupper($setting->language), 0, 3, '');
                                }

                                ?></a>
                            <ul class="dropdown-menu lang_options">
                                <?php
                                $lii = 0;

                                foreach ($languagenames as $languagename) {

                                    if ($lii >= 2) {
                                ?>
                                <li><a href="javascript:;" onclick="addlang(this)"
                                        data-url="<?php echo base_url(); ?>hungry/setlangue/<?php echo $languagename->name; ?>">
                                        <?php echo ucfirst($languagename->name); ?></a></li>
                                <?php
                                    }

                                    $lii++;
                                }

                                ?>
                            </ul>
                        </div>
                    </li>
                </ul>

                <div class="tgbar">

                    <a href="javascript:;" class="btn bg-soft-blue" onclick="closeopenresister()" role="button"><i
                            class="fa fa-window-close"></i></a>
                    <?php

                    if ($new_version > $myversion) {

                        if ($versioncheck->version != $new_version) {
                    ?>
                    <a href="<?php echo base_url("dashboard/autoupdate") ?>" class="updateanimate"><i
                            class="fa fa-warning fa-warning-bg"></i><span class="f-size-weight">Update
                            Available</span></a>
                    <?php
                        }
                    }

                    ?>
                    <a id="fullscreen" href="#" class="bg-soft-green"><i class="pe-7s-expand1"></i></a> <a href="#"
                        class="bg-soft-red"><i class="fa fa-keyboard hover-q text-muted" aria-hidden="true"
                            data-container="body" data-toggle="popover" data-placement="bottom" data-content="<table class='table table-condensed table-striped' >
        <tr>
            <th>Operations</th>
            <th>Keyboard Shortcut</th>
            <th>Operations</th>
            <th>Keyboard Shortcut</th>
        </tr>
        <tr>
        <td>New Order Tab</td>
        <td>Shift+N</td>
        <td>On Going Tab</td>
        <td>Shift+G</td>
        </tr>
        <tr>
        <td>Today Order Tab</td>
        <td>Shift+T</td>
        <td>Online Order Tab</td>
        <td>Shift+O</td>
        </tr>
        <tr>
        <td>Place Order</td>
        <td>Shift+P</td>
        <td>Quick Order</td>
        <td>Shift+Q</td>
        </tr>
        <tr>
        <td>Search Product</td>
        <td>Shift+S</td>
        <td>Select Customer</td>
        <td>Shift+C</td>
        </tr>
        <tr>
        <td>Select Customer Type</td>
        <td>Shift+Y</td>
        <td>Edit Discount:</td>
        <td>Shift+D</td></tr>
        <tr>
        <td>Edit Service Charge</td>
        <td>Shift+R</td>
        <td>Select Waiter</td>
        <td>Shift+W</td>
        </tr>
        <tr>
        <td>Select Table</td>
        <td>Shift+B</td>
        <td>Cooking Time</td>
        <td>Alt+K</td></tr>
        <tr>
        <td>Search Table</td>
        <td>Alt+T</td>
        <td>Go Edit</td>
        <td>Shift+E</td></tr>
        <tr>
        <td>Search Today Order</td>
        <td>Shift+X</td>
        <td>Search Online Order</td>
        <td>Shift+V</td>
        </tr>
        <tr>
        <td>Update Search Product</td>
        <td>Alt+S</td>
        <td>Update Select Customer</td>
        <td>Alt+C</td>
        </tr>
        <tr>
        <td>Update Select Customer Type</td>
        <td>Alt+Y</td>
        <td>Update Discount:</td>
        <td>Alt+D</td></tr>
        <tr>
        <td>Update Service Charge:</td>
        <td>Alt+R</td>
        <td>Update Select Table</td>
        <td>Alt+B</td>
        </tr>

        <td>Update Submit From</td>
        <td>Alt+U</td>
        <td>Select Payment Type</td>
        <td>Alt+M</td></tr>
        <tr>
        <td>Pay & Print Bill</td>
        <td>Alt+P</td>
        <td>Paid Amount Typing</td>
        <td>Alt+A</td></tr>
    </table>" data-html="true" data-trigger="hover" data-original-title="" title=""></i></a>
                    <?php $languagenames = $this->db->field_data('language'); ?>
                    <div class="dropdown">
                        <a class="dropdown-toggle lang_box" type="button" data-toggle="dropdown">
                            <?php

                            if ($this->session->has_userdata('language')) {
                                echo mb_strimwidth(strtoupper($this->session->userdata('language')), 0, 3, '');
                            } else {
                                echo mb_strimwidth(strtoupper($setting->language), 0, 3, '');
                            }

                            ?>
                            <span class="caret"></span></a>
                        <ul class="dropdown-menu lang_options">
                            <?php
                            $lii = 0;

                            foreach ($languagenames as $languagename) {

                                if ($lii >= 2) {
                            ?>
                            <li><a href="javascript:;" onclick="addlang(this)"
                                    data-url="<?php echo base_url(); ?>hungry/setlangue/<?php echo $languagename->name; ?>">
                                    <?php echo ucfirst($languagename->name); ?></a></li>
                            <?php
                                }

                                $lii++;
                            }

                            ?>
                        </ul>
                    </div>

                </div>
            </div>

            <!-- Tab panes -->
            <div class="tab-content tab-content-xs pb-0">
                <div class="tab-pane fade active in" id="home">
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <div class="panel">
                                <input name="url" type="hidden" id="posurl"
                                    value="<?php echo base_url("ordermanage/order/getitemlist") ?>" />
                                <input name="url" type="hidden" id="productdata"
                                    value="<?php echo base_url("ordermanage/order/getitemdata") ?>" />
                                <input name="url" type="hidden" id="url"
                                    value="<?php echo base_url("ordermanage/order/itemlistselect") ?>" />
                                <input name="url" type="hidden" id="carturl"
                                    value="<?php echo base_url("ordermanage/order/posaddtocart") ?>" />
                                <input name="url" type="hidden" id="cartupdateturl"
                                    value="<?php echo base_url("ordermanage/order/poscartupdate") ?>" />
                                <input name="url" type="hidden" id="addonexsurl"
                                    value="<?php echo base_url("ordermanage/order/posaddonsmenu") ?>" />
                                <input name="url" type="hidden" id="removeurl"
                                    value="<?php echo base_url("ordermanage/order/removetocart") ?>" />
                                <input name="updateid" type="hidden" id="updateid" value="" />
                                <div class="row">
                                    <form action="<?php echo base_url("ordermanage/order/pos_order") ?>"
                                        class="form-vertical" id="onlineordersubmit" enctype="multipart/form-data"
                                        method="post" accept-charset="utf-8">

                                        <div class="col-md-4">
                                            <div class="leftSidebarPosMain">
                                                <!-- <div class="slimScrollDiv"> -->
                                                <div class="row">
                                                    <div class="col-md-6 form-group">
                                                        <label
                                                            for="customer_name"><?php echo display('customer_name'); ?><span
                                                                class="color-red">*</span></label>
                                                        <div class="d-flex custom-select">
                                                            <?php $cusid = 1;
                                                            echo form_dropdown('customer_name', $customerlist, (!empty($cusid) ? $cusid : null), 'class="postform resizeselect form-control" id="customer_name" required') ?>
                                                            <button type="button" class="btn btn-green ml-l"
                                                                aria-hidden="true" data-toggle="modal"
                                                                data-target="#client-info"><i
                                                                    class="ti-plus"></i></button>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 form-group custom-select">
                                                        <label for="store_id"><?php echo display('customer_type'); ?>
                                                            <span
                                                                class="color-red">*</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                                        <?php $ctype = 1;
                                                        echo form_dropdown('ctypeid', $curtomertype, (!empty($ctype) ? $ctype : null), 'class="form-control" id="ctypeid" required') ?>
                                                    </div>
                                                    <div id="nonthirdparty" class="col-md-12">
                                                        <div class="row">

                                                            <div class="col-md-4 form-group custom-select pl-0">
                                                                <label for="store_id"><?php echo display('waiter'); ?>
                                                                    <span
                                                                        class="color-red">*</span>&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                                                <?php $waiterkitchen = $this->session->userdata('id');
                                                                echo form_dropdown('waiter', $waiterlist, (!empty($waiterkitchen) ? $waiterkitchen : null), 'class="form-control" id="waiter" required') ?>
                                                            </div>
                                                            <?php

                                                            if ($possetting->tablemaping == 1) {
                                                            ?>


                                                            <div class="col-md-3 form-group custom-select" id="tblsecp">
                                                                <label for="store_id" class="wpr_100 person"> <span
                                                                        class="color-red">&nbsp;&nbsp;</span></label>
                                                                <input name="" type="button"
                                                                    class="btn btn-ash h-40  form-control width-100"
                                                                    onclick="showTablemodal()" id="table_person"
                                                                    value="<?php echo display('person'); ?>">
                                                                <input type="hidden" id="table_member"
                                                                    name="table_member" class="form-control" value="" />
                                                            </div>
                                                            <?php
                                                            }

                                                            ?>
                                                            <div class="col-md-5 custom-select" id="tblsec">

                                                                <label for="store_id"><?php echo display('table'); ?>
                                                                    <span class="color-red">*</span></label>
                                                                <?php echo form_dropdown('tableid', $tablelist, (!empty($tablelist->tableid) ? $tablelist->tableid : null), 'class="postform resizeselect form-control" id="tableid" required onchange="checktable()"') ?>
                                                                <input type="hidden" id="table_member_multi"
                                                                    name="table_member_multi" class="form-control"
                                                                    value="0" />
                                                                <input type="hidden" id="table_member_multi_person"
                                                                    name="table_member_multi_person"
                                                                    class="form-control" value="0" />

                                                            </div>
                                                            <?php
                                                            ?>
                                                            <input name="cookedtime" type="hidden" id="cookedtime" />
                                                            <!-- <div class="col-md-3 form-group" id="cookingtime">
                                                                <label
                                                                    for="Cooked Time"><?php echo display('cookedtime'); ?></label>
                                                                <input name="cookedtime" type="text"
                                                                    class="form-control custom-form-control timepicker3"
                                                                    id="cookedtime" placeholder="00:00:00"
                                                                    autocomplete="off" />
                                                            </div> -->

                                                        </div>
                                                    </div>
                                                    <div id="thirdparty" style="display: none;">
                                                        <div class="col-md-6 custom-select">
                                                            <div class="form-group">
                                                                <label
                                                                    for="store_id"><?php echo display('del_company'); ?>
                                                                    <span
                                                                        class="color-red">*</span>&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                                                <?php echo form_dropdown('delivercom', $thirdpartylist, (!empty($thirdpartylist->companyId) ? $thirdpartylist->companyId : null), 'class="form-control wpr_95" id="delivercom" required disabled="disabled"') ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 custom-select">
                                                            <div class="form-group">
                                                                <label
                                                                    for="third_id"><?php echo display('thirdparty_orderid'); ?>&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                                                <input name="thirdinvoiceid" type="text"
                                                                    class="form-control custom-form-control"
                                                                    id="thirdinvoiceid">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <input class="form-control" type="hidden" id="order_date"
                                                            name="order_date" required
                                                            value="<?php echo date('d-m-Y') ?>" />
                                                        <input class="form-control" type="hidden" id="bill_info"
                                                            name="bill_info" required value="1" />
                                                        <input type="hidden" id="card_type" name="card_type"
                                                            value="4" />
                                                        <input type="hidden" id="isonline" name="isonline" value="0" />
                                                        <input type="hidden" id="assigncard_terminal"
                                                            name="assigncard_terminal" value="" />
                                                        <input type="hidden" id="assignbank" name="assignbank"
                                                            value="" />
                                                        <input type="hidden" id="assignlastdigit" name="assignlastdigit"
                                                            value="" />
                                                        <input type="hidden" id="product_value" name="">
                                                    </div>
                                                </div>
                                                <div class="productlist product-table">
                                                    <div class="product-list pdlist product-table-height">
                                                        <div class="table-responsive" id="addfoodlist">
                                                            <?php $grtotal = 0;
                                                            $totalitem                               = 0;
                                                            $calvat                                  = 0;
                                                            $discount                                = 0;
                                                            $itemtotal                               = 0;
                                                            $pdiscount                               = 0;
                                                            $multiplletax                            = [];
                                                            $this->load->model('ordermanage/order_model', 'ordermodel');

                                                            if ($cart = $this->cart->contents()) {
                                                            ?>
                                                            <table class="table item-table border-none wpr_100 mb-0"
                                                                border="1" id="addinvoice">
                                                                <thead>
                                                                    <tr>
                                                                        <th><?php echo display('item') ?></th>
                                                                        <th><?php echo display('varient') ?></th>
                                                                        <th><?php echo display('price'); ?></th>
                                                                        <th class="text-center">Qnt.</th>
                                                                        <th><?php echo display('total'); ?></th>
                                                                        <th><?php echo display('action'); ?></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="itemNumber">
                                                                    <?php $i = 0;
                                                                        $totalamount                           = 0;
                                                                        $subtotal                              = 0;
                                                                        $ptdiscount                            = 0;
                                                                        $pvat                                  = 0;

                                                                        foreach ($cart as $item) {
                                                                            $iteminfo         = $this->ordermodel->getiteminfo($item['pid']);
                                                                            $itemprice        = $item['price'] * $item['qty'];
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

                                                                                if ($iteminfo->productvat > 0) {
                                                                                    $vatcalc = $itemprice * $iteminfo->productvat / 100;
                                                                                } else {
                                                                                    $vatcalc = 0;
                                                                                }

                                                                                $pvat = $pvat + $vatcalc;
                                                                            }

                                                                            if ($iteminfo->OffersRate > 0) {
                                                                                $mypdiscount = $iteminfo->OffersRate * $itemprice / 100;
                                                                                $ptdiscount  = $ptdiscount + ($iteminfo->OffersRate * $itemprice / 100);
                                                                            } else {
                                                                                $mypdiscount = 0;
                                                                                $pdiscount   = $pdiscount + 0;
                                                                            }

                                                                            if (!empty($item['addonsid'])) {
                                                                                $nittotal  = $item['addontpr'];
                                                                                $itemprice = $itemprice + $item['addontpr'];
                                                                            } else {
                                                                                $nittotal  = 0;
                                                                                $itemprice = $itemprice;
                                                                            }

                                                                            $totalamount = $totalamount + $nittotal;
                                                                            $subtotal    = $subtotal + $nittotal + $item['price'] * $item['qty'];
                                                                            $i++;
                                                                        ?>
                                                                    <tr id="<?php echo $i; ?>">
                                                                        <th id="product_name_MFU4E">
                                                                            <?php echo $item['name'];

                                                                                    if (!empty($item['addonsid'])) {
                                                                                        echo "<br>";
                                                                                        echo $item['addonname'];

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
                                                                                    }

                                                                                    ?><a class="serach pl-5"
                                                                                onclick="itemnote('<?php echo $item['rowid'] ?>','<?php echo $item['itemnote'] ?>',<?php echo $item['qty']; ?>,2)"
                                                                                title="<?php echo display('foodnote') ?>">
                                                                                <i class="fa fa-sticky-note"
                                                                                    aria-hidden="true"></i> </a></th>
                                                                        <td><?php echo $item['size']; ?></td>
                                                                        <td width=""><?php

                                                                                                if ($currency->position == 1) {
                                                                                                    echo $currency->curr_icon;
                                                                                                }

                                                                                                ?>
                                                                            <?php echo $item['price']; ?>
                                                                            <?php

                                                                                    if ($currency->position == 2) {
                                                                                        echo $currency->curr_icon;
                                                                                    }

                                                                                    ?></td>
                                                                        <td scope="row"><a
                                                                                class="btn btn-info btn-sm btn-incriment btnleftalign"
                                                                                onclick="posupdatecart('<?php echo $item['rowid'] ?>',<?php echo $item['pid']; ?>,<?php echo $item['sizeid'] ?>,<?php echo $item['qty']; ?>,'add')"><i
                                                                                    class="fa fa-plus"
                                                                                    aria-hidden="true"></i></a> <span
                                                                                id="productionsetting-<?php echo $item['pid'] . '-' . $item['sizeid'] ?>">
                                                                                <?php echo $item['qty']; ?> </span>
                                                                            <a class="btn btn-danger btn-sm btn-dicriment btnrightalign"
                                                                                onclick="posupdatecart('<?php echo $item['rowid'] ?>',<?php echo $item['pid']; ?>,<?php echo $item['sizeid'] ?>,<?php echo $item['qty']; ?>,'del')"><i
                                                                                    class="fa fa-minus"
                                                                                    aria-hidden="true"></i></a>
                                                                        </td>
                                                                        <td width=""><?php

                                                                                                if ($currency->position == 1) {
                                                                                                    echo $currency->curr_icon;
                                                                                                }

                                                                                                ?>
                                                                            <?php echo $itemprice - $mypdiscount; ?>
                                                                            <?php

                                                                                    if ($currency->position == 2) {
                                                                                        echo $currency->curr_icon;
                                                                                    }

                                                                                    ?></td>
                                                                        <td width:"80"=""><a class="btn btn-sm"
                                                                                onclick="removecart('<?php echo $item['rowid']; ?>')">
                                                                                <svg width="16" height="18"
                                                                                    viewBox="0 0 16 18" fill="none"
                                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                                    <path fill-rule="evenodd"
                                                                                        clip-rule="evenodd"
                                                                                        d="M0 3.9975C0 3.65763 0.27552 3.38212 0.615385 3.38212H15.3846C15.7245 3.38212 16 3.65763 16 3.9975C16 4.33737 15.7245 4.61289 15.3846 4.61289H0.615385C0.27552 4.61289 0 4.33737 0 3.9975Z"
                                                                                        fill="#D43407" />
                                                                                    <path fill-rule="evenodd"
                                                                                        clip-rule="evenodd"
                                                                                        d="M13.8323 11.8018C13.5918 13.9802 13.4715 15.0694 12.8566 15.8213C12.6415 16.0842 12.3871 16.3121 12.1021 16.497C11.2873 17.0256 10.1915 17.0256 7.9998 17.0256C5.80824 17.0256 4.71244 17.0256 3.89755 16.497C3.61262 16.3121 3.35811 16.0842 3.14311 15.8213C2.5282 15.0694 2.4079 13.9801 2.16731 11.8018L1.24268 3.43009H14.757L13.8323 11.8018ZM9.64083 7.56119C9.98069 7.56119 10.2562 7.83672 10.2562 8.17658V12.2791C10.2562 12.619 9.98069 12.8945 9.64083 12.8945C9.30097 12.8945 9.02544 12.619 9.02544 12.2791V8.17658C9.02544 7.83672 9.30097 7.56119 9.64083 7.56119ZM6.97416 8.17658C6.97416 7.83672 6.69863 7.56119 6.35876 7.56119C6.0189 7.56119 5.74338 7.83672 5.74338 8.17658V12.2791C5.74338 12.619 6.0189 12.8945 6.35876 12.8945C6.69863 12.8945 6.97416 12.619 6.97416 12.2791V8.17658Z"
                                                                                        fill="#D43407" />
                                                                                    <path fill-rule="evenodd"
                                                                                        clip-rule="evenodd"
                                                                                        d="M6.6362 2.5084e-06C6.64933 2.5084e-06 6.66246 1.07247e-05 6.67567 1.07247e-05H9.32429C9.3375 1.07247e-05 9.35071 2.5084e-06 9.36375 2.5084e-06C9.79132 -3.85172e-05 10.1739 -7.13422e-05 10.4833 0.0429974C10.822 0.0901769 11.1622 0.199239 11.438 0.484835C11.7109 0.767412 11.8122 1.11081 11.8565 1.45126C11.8975 1.76724 11.8974 2.15956 11.8974 2.60498V4.01428H10.6666V2.6428C10.6666 2.14812 10.6654 1.83692 10.636 1.60972C10.6085 1.39807 10.5665 1.35409 10.5527 1.33977L10.5519 1.33897C10.5401 1.32671 10.5035 1.28846 10.3135 1.26201C10.0993 1.23217 9.80379 1.23078 9.32429 1.23078H6.67567C6.19621 1.23078 5.90071 1.23217 5.68643 1.26201C5.49646 1.28846 5.45983 1.32671 5.44808 1.33897L5.44731 1.33977C5.43348 1.35409 5.39151 1.39807 5.36403 1.60972C5.33453 1.83692 5.33331 2.14812 5.33331 2.6428V4.01428H4.10254V2.6428C4.10254 2.63015 4.10254 2.61754 4.10254 2.60497C4.10251 2.15955 4.10248 1.76724 4.1435 1.45126C4.1877 1.11081 4.28908 0.767412 4.56195 0.484835C4.83772 0.199239 5.1779 0.0901769 5.51671 0.0429974C5.82606 -7.13422e-05 6.20867 -3.85172e-05 6.6362 2.5084e-06Z"
                                                                                        fill="#D43407" />
                                                                                </svg>

                                                                            </a></td>
                                                                    </tr>
                                                                    <?php
                                                                        }

                                                                        $itemtotal = $subtotal;

                                                                        /*check $taxsetting info*/
                                                                        if (empty($taxinfos)) {
                                                                            if ($settinginfo->vat > 0) {
                                                                                $calvat = ($itemtotal - $ptdiscount) * $settinginfo->vat / 100;
                                                                            } else {
                                                                                $calvat = $pvat;
                                                                            }
                                                                        } else {
                                                                            $calvat = $pvat;
                                                                        }

                                                                        $grtotal   = $itemtotal;
                                                                        $totalitem = $i;
                                                                        ?>
                                                                </tbody>
                                                            </table>
                                                            <?php $pdiscount = $ptdiscount;
                                                            }

                                                            $multiplletaxvalue = htmlentities(serialize($multiplletax));
                                                            ?>
                                                            <input name="subtotal" id="subtotal" type="hidden"
                                                                value="<?php echo $subtotal; ?>" />

                                                            <input name="multiplletaxvalue" id="multiplletaxvalue"
                                                                type="hidden"
                                                                value="<?php echo $multiplletaxvalue; ?>" />
                                                            <?php
                                                            if (!empty($this->cart->contents())) {
                                                                if ($settinginfo->service_chargeType == 1) {
                                                                    $totalsercharge = $subtotal - $pdiscount;
                                                                    $servicetotal   = $settinginfo->servicecharge * $totalsercharge / 100;
                                                                } else {
                                                                    $servicetotal = $settinginfo->servicecharge;
                                                                }

                                                                $servicecharge = $settinginfo->servicecharge;
                                                            } else {
                                                                $servicetotal  = 0;
                                                                $servicecharge = 0;
                                                            }

                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="fixedclasspos bt-none">
                                                    <div class="row">
                                                        <div class="col-12 leftview">
                                                            <input name="distype" id="distype" type="hidden"
                                                                value="<?php echo $settinginfo->discount_type; ?>" />
                                                            <input name="sdtype" id="sdtype" type="hidden"
                                                                value="<?php echo $settinginfo->service_chargeType; ?>" />
                                                            <input type="hidden" id="orginattotal"
                                                                value="<?php echo $calvat + $itemtotal + $servicetotal - ($discount + $pdiscount); ?>"
                                                                name="orginattotal">
                                                            <input type="hidden" id="invoice_discount"
                                                                class="form-control text-right" name="invoice_discount"
                                                                value="<?php echo $discount + $pdiscount ?>">
                                                            <div class="summary-bg p-10 mb-13">
                                                                <table
                                                                    class="table table-bordered footersumtotal summary-table">
                                                                    <tr>
                                                                        <td>
                                                                            <label for="date"
                                                                                class="mb-0"><?php echo display('vat_tax1') ?>:
                                                                            </label>
                                                                        </td>
                                                                        <td class="text-end fs-17">
                                                                            <label class="mb-0">
                                                                                <input type="hidden" id="vat" name="vat"
                                                                                    value="<?php echo $calvat; ?>" />
                                                                                <strong>
                                                                                    <?php if ($currency->position == 1) {
                                                                                        echo $currency->curr_icon;
                                                                                    }

                                                                                    ?>
                                                                                    <span id="calvat">
                                                                                        <?php echo $calvat; ?></span>
                                                                                    <?php if ($currency->position == 2) {
                                                                                        echo $currency->curr_icon;
                                                                                    }

                                                                                    ?>
                                                                                </strong>
                                                                            </label>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <label for="date"
                                                                                class="mb-0"><?php echo display('service_chrg') ?>
                                                                                <?php if ($settinginfo->service_chargeType == 0) {
                                                                                    echo "(" . $currency->curr_icon . ")";
                                                                                } else {
                                                                                    echo "(%)";
                                                                                }

                                                                                ?>
                                                                                :</label>
                                                                        </td>
                                                                        <td class="text-end float-right">
                                                                            <input type="text" id="service_charge"
                                                                                onkeyup="calculatetotal();"
                                                                                class="form-control text-right fw-700 p-0 border-none fs-17 text-summary"
                                                                                value="<?php echo $servicecharge; ?>"
                                                                                name="service_charge"
                                                                                placeholder="0.00" />
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <label for="date"
                                                                                class="mb-0 text-green font-18"><?php echo display('grand_total') ?>:</label>

                                                                        </td>
                                                                        <td class="text-end text-green">
                                                                            <label class="mb-0">
                                                                                <input type="hidden" id="orggrandTotal"
                                                                                    value="<?php echo $calvat + $itemtotal + $servicetotal - ($discount + $pdiscount); ?>"
                                                                                    name="orggrandTotal">
                                                                                <input name="grandtotal" type="hidden"
                                                                                    value="<?php echo $calvat + $itemtotal + $servicetotal - ($discount + $pdiscount); ?>"
                                                                                    id="grandtotal" />
                                                                                <span class="fs-20"><strong>
                                                                                        <?php if ($currency->position == 1) {
                                                                                            echo $currency->curr_icon;
                                                                                        }

                                                                                        ?>
                                                                                        <span id="caltotal">
                                                                                            <?php echo $calvat + $itemtotal + $servicetotal - ($discount + $pdiscount); ?>
                                                                                        </span>
                                                                                        <?php if ($currency->position == 2) {
                                                                                            echo $currency->curr_icon;
                                                                                        }

                                                                                        ?>
                                                                                    </strong>
                                                                                </span>
                                                                            </label>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 d-flex text-right">
                                                            <a class="btn btn-navy cusbtn width-100" data-toggle="modal"
                                                                data-target="#exampleModal">Calculator</a>
                                                            <a href="<?php echo base_url("ordermanage/order/posclear") ?>"
                                                                type="button"
                                                                class="btn btn-red cusbtn width-100"><?php echo display('cancel') ?></a>
                                                            <input type="hidden" id="getitemp" name="getitemp"
                                                                value="<?php echo $totalitem - $discount; ?>" />
                                                            <input type="button" id="add_payment2"
                                                                class="btn btn-blue width-100 btn-large cusbtn"
                                                                onclick="quickorder()" name="add-payment"
                                                                value="<?php echo display('quickorder') ?>">
                                                            <input type="button" id="add_payment"
                                                                class="btn btn-green width-100 btn-large cusbtn"
                                                                onclick="placeorder()" name="add-payment"
                                                                value="<?php echo display('placeorder') ?>">


                                                            <input type="hidden" id="production_setting"
                                                                value="<?php echo $possetting->productionsetting; ?>">
                                                            <input type="hidden" id="production_url"
                                                                value="<?php echo base_url("production/production/ingredientcheck") ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- </div> -->
                                            </div>
                                        </div>
                                    </form>
                                    <div class="col-md-8 height-cal">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <form class="navbar-search" method="get"
                                                    action="<?php echo base_url("ordermanage/order/pos_invoice") ?>">
                                                    <label class="sr-only screen-reader-text"
                                                        for="search"><?php echo display('search') ?>:</label>
                                                    <div class="input-group search-custom">
                                                        <select id="product_name"
                                                            class="form-control dont-select-me  search-field" dir="ltr"
                                                            name="s">
                                                        </select>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 col-lg-2 pr-0">
                                                <div class="leftSidebarPosMain bg-alice-blue p-10 pb-60 pb-sm-0">
                                                    <div class="slimScrollDiv">
                                                        <div class="product-category">
                                                            <div class="listcatnew pos-category"
                                                                onclick="getslcategory('')"><?php echo display('all') ?>
                                                            </div>
                                                            <?php //$result = array_diff($categorylist, array("Select Food Category"));

                                                            foreach ($allcategorylist as $category) {

                                                                if (!empty($category->sub)) {
                                                            ?>
                                                            <div class="listcatnew pos-category cat-nav2">
                                                                <a class="btn listcatnew listcat2 pos-category-sub">
                                                                    <?php echo $category->Name; ?>
                                                                    <span class="caret"></span>
                                                                </a>
                                                                <ul class="dropdown-menucat dropcat display-none"
                                                                    id="newtcat<?php echo $subcat->CategoryID ?? ''; ?>">
                                                                    <?php

                                                                            foreach ($category->sub as $subcat) { ?>
                                                                    <li class="lip-2 border-bottom-white"><a
                                                                            onclick="getslcategory(<?php echo $subcat->CategoryID; ?>)"><?php echo $subcat->Name; ?></a>
                                                                    </li>
                                                                    <?php }

                                                                            ?>
                                                                </ul>


                                                            </div>
                                                            <?php
                                                                } else { ?>

                                                            <div class="listcatnew pos-category cat-nav"
                                                                onclick="getslcategory(<?php echo $category->CategoryID; ?>)">
                                                                <?php echo $category->Name; ?></div>
                                                            <?php }
                                                            }

                                                            ?>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-9 col-lg-10">
                                                <div class="leftSidebarPosMain bg-alice-blue pb-60">
                                                    <div class="slimScrollDiv">
                                                        <div class="row m-3" id="product_search">
                                                            <?php $i = 0;

                                                            foreach ($itemlist as $item) {
                                                                $item = (object) $item;
                                                                $i++;
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
                                                                    class="panel panel-bd product-panel select_product rounded-lg border-none p-10 product-h m-0 bg-white">
                                                                    <div class="panel-body p-0">
                                                                        <div class="pos-img-wrap">
                                                                            <img src="<?php echo base_url(!empty($item->small_thumb) ? $item->small_thumb : 'assets/img/icons/default_pos_pro.jpg'); ?>"
                                                                                class="img-responsive"
                                                                                alt="<?php echo $item->ProductName; ?>">
                                                                        </div>
                                                                        <input type="hidden" name="select_product_id"
                                                                            class="select_product_id"
                                                                            value="<?php echo $item->ProductsID; ?>">
                                                                        <input type="hidden" name="select_totalvarient"
                                                                            class="select_totalvarient"
                                                                            value="<?php echo $item->totalvarient; ?>">
                                                                        <input type="hidden" name="select_iscustomeqty"
                                                                            class="select_iscustomeqty"
                                                                            value="<?php echo $item->is_customqty; ?>">
                                                                        <input type="hidden" name="select_product_size"
                                                                            class="select_product_size"
                                                                            value="<?php echo $item->variantid; ?>">
                                                                        <input type="hidden"
                                                                            name="select_product_isgroup"
                                                                            class="select_product_isgroup"
                                                                            value="<?php echo $item->isgroup; ?>">
                                                                        <input type="hidden" name="select_product_cat"
                                                                            class="select_product_cat"
                                                                            value="<?php echo $item->CategoryID; ?>">
                                                                        <input type="hidden" name="select_varient_name"
                                                                            class="select_varient_name"
                                                                            value="<?php echo $item->variantName; ?>">
                                                                        <input type="hidden" name="select_product_name"
                                                                            class="select_product_name"
                                                                            value="<?php echo $item->ProductName;

                                                                                                                    if (!empty($item->itemnotes)) {
                                                                                                                        echo " -" . $item->itemnotes;
                                                                                                                    }

                                                                                                                    ?>">
                                                                        <input type="hidden" name="select_product_price"
                                                                            class="select_product_price"
                                                                            value="<?php echo $item->price; ?>">
                                                                        <input type="hidden" name="select_addons"
                                                                            class="select_addons"
                                                                            value="<?php echo $getadons; ?>">
                                                                    </div>
                                                                    <div class="text-center">
                                                                        <h4 class="m-0 pt-12">
                                                                            <?php echo $item->ProductName; ?>

                                                                            <?php

                                                                                if (!empty($item->itemnotes)) {
                                                                                    echo " -" . $item->itemnotes;
                                                                                }

                                                                                ?>
                                                                        </h4>
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
                </div>
                <div class="tab-pane fade" id="profile">
                    <div class="row m-0" id="onprocesslist"> </div>
                </div>
                <div class="tab-pane fade" id="kitchen">
                    <div class="row" id="kitchenstatus"> </div>
                </div>
                <?php if ($qrapp == 1) { ?>
                <div class="tab-pane fade" id="qrorder"> </div>
                <?php }

                ?>
                <div class="tab-pane fade" id="settings"> </div>
                <div class="tab-pane fade" id="messages"> </div>
            </div>
        </div>
    </div>
</div>
<audio id="myAudio" src="<?php echo base_url() ?><?php echo $soundsetting->nofitysound; ?>" preload="auto"
    class="display-none"></audio>
<div id="payprint2"> </div>
<div class="modal fade modal-warning" id="posprint" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body" id="kotenpr"> </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div id="orderdetailsp" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <strong>

                </strong>
            </div>
            <div class="modal-body orddetailspop"> </div>
        </div>
        <div class="modal-footer"> </div>
    </div>
</div>
<?php
$scan1   = scandir('application/modules/');
$getdisc = "";
foreach ($scan1 as $file) {
    if ($file == "loyalty") {
        if (file_exists(APPPATH . 'modules/' . $file . '/assets/data/env')) {
            $getdisc = 1;
        }
    }
}

//$this->load->view('include/pos_script');
?>

<script src="<?php echo base_url('ordermanage/order/possettingjs') ?>" type="text/javascript"></script>
<script src="<?php echo base_url('ordermanage/order/quickorderjs') ?>" type="text/javascript"></script>
<script src="<?php echo base_url('application/modules/ordermanage/assets/js/possetting.js'); ?>" type="text/javascript">
</script>