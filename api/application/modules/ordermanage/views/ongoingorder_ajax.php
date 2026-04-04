<link rel="stylesheet" type="text/css"
    href="<?php echo base_url('application/modules/ordermanage/assets/css/onoing_ajax.css'); ?>">
<div class="col-md-12">
    <div class="row mb-2">
        <div class="col-sm-3 custom-select">
            <select id="ongoingtable_name" class="form-control custom-form-control dont-select-me  search-table-field"
                dir="ltr" name="s">
            </select>
        </div>
        <div class="col-sm-3 custom-select">
            <select id="ongoingtable_sr" class="form-control custom-form-control dont-select-me  search-tablesr-field"
                dir="ltr" name="ts">
            </select>
        </div>
        <div class="col-sm-6">
            <button class="btn btn-green pull-right"
                onclick="mergeorderlist()"><?php echo display('mergeord') ?></button>
        </div>
    </div>
    <div class="row">
        <?php

    if (!empty($ongoingorder)) {

      foreach ($ongoingorder as $onprocess) {
        $billtotal = round($onprocess->totalamount - $onprocess->customerpaid);

    ?>
        <div class="col-sm-4 col-md-3 col-xs-6 col-xlg-2">
            <?php

          if (!empty($onprocess->marge_order_id)) {
          ?>
            <div class="hero-widget well well-sm height-abg order-update-style">
                <div class="mdjc">
                    <?php
                if ($this->permission->method('ordermanage', 'update')->access() && $onprocess->splitpay_status == 0):
                ?>
                    <div class="display-flex align-items-center">
                        <?php $margeinfo = $this->db->select('order_id')->from('customer_order')->where('marge_order_id', $onprocess->marge_order_id)->get()->result();
                    $allmergeid                                             = "";

                    foreach ($margeinfo as $mergeord) {
                      $allmergeid .= $mergeord->order_id . ',';
                    }

                    $allorder = trim($allmergeid, ',');
                    ?>
                        <input name="margeid" id="allmerge_<?php echo $onprocess->marge_order_id; ?>" type="hidden"
                            value="<?php echo $allorder ?>" />
                    </div>
                    <?php endif; ?>


                    <table class="fs-15px width-100 mb-2">
                        <tr>
                            <td>
                                <span><?php echo display('table'); ?></span><br>
                                <span class="font-weight"><?php echo $onprocess->tablename; ?></span>
                            </td>
                            <td>
                                <span><?php echo display('ord_num'); ?></span><br>
                                <span class="font-weight"><?php echo $allorder; ?></span>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <span><?php echo display('waiter'); ?></span><br>
                                <span
                                    class="font-weight"><?php echo $onprocess->first_name . ' ' . $onprocess->last_name; ?></span>
                            </td>
                            <td>
                                <span><?php echo display('before_time'); ?></span><br>
                                <?php
                      $diff = 0;

                      $actualtime = date('H:i:s');

                      $array1   = explode(':', $actualtime);
                      $array2   = explode(':', $onprocess->order_time);
                      $minutes1 = ($array1[0] * 3600.0 + $array1[1] * 60.0 + $array1[2]);
                      $minutes2 = ($array2[0] * 3600.0 + $array2[1] * 60.0 + $array2[2]);
                      $diff     = $minutes1 - $minutes2;

                      /* $format   = sprintf('%02d:%02d:%02d', round($diff / 3600), round($diff / 60 % 60), round($diff % 60)); */
                      //$format = $actualtime;

                      $currentTimeObj = new DateTime($actualtime);
                      $orderTimeObj   = new DateTime($onprocess->order_time);

                      // Calculate the difference
                      $interval = $currentTimeObj->diff($orderTimeObj);

                      // Output the difference in hours, minutes, and seconds
                      $format = $interval->format('%d days %H:%I:%S');
                      ?>
                                <span class="font-weight"><?php echo $format; ?></span>
                            </td>
                        </tr>
                    </table>

                </div>

                <div class="d-flex flex-wrap gap-8">
                    <a href="javascript:;"
                        onclick="duemergeorder(<?php echo $onprocess->order_id; ?>,'<?php echo $onprocess->marge_order_id; ?>')"
                        class="btn btn-xs btn-green btn-sm mr-1"><?php echo display('cmplt'); ?></a>

                    <?php

                if ($this->permission->method('ordermanage', 'delete')->access()) { ?>
                    <a href="javascript:;" data-id="<?php echo $onprocess->order_id; ?>"
                        class="btn btn-xs btn-red  btn-sm mr-1 cancelorder" data-toggle="tooltip" data-placement="left"
                        title="" data-original-title="<?php echo display('cancel_order') ?>">Delete</a>&nbsp;
                    <?php }

                ?>
                    <a href="javascript:;"
                        onclick="printmergeinvoice('<?php echo base64_encode($onprocess->marge_order_id); ?>')"
                        class="btn btn-violet d-flex align-center py-10" data-toggle="tooltip" data-placement="left"
                        title="" data-original-title="<?php echo display('pos_invoice') ?>">
                        <svg class="m-r-5" width="17" height="17" viewBox="0 0 17 17" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M9.35 11.901H4.25001C4.02457 11.901 3.80837 11.9905 3.64896 12.1499C3.48956 12.3093 3.40001 12.5255 3.40001 12.7508C3.40001 12.9762 3.48956 13.1924 3.64896 13.3518C3.80837 13.5111 4.02457 13.6007 4.25001 13.6007H9.35C9.57544 13.6007 9.79164 13.5111 9.95104 13.3518C10.1104 13.1924 10.2 12.9762 10.2 12.7508C10.2 12.5255 10.1104 12.3093 9.95104 12.1499C9.79164 11.9905 9.57544 11.901 9.35 11.901ZM5.95 6.80203H7.65C7.87544 6.80203 8.09164 6.71249 8.25104 6.55312C8.41045 6.39374 8.5 6.17758 8.5 5.9522C8.5 5.72681 8.41045 5.51065 8.25104 5.35127C8.09164 5.1919 7.87544 5.10236 7.65 5.10236H5.95C5.72457 5.10236 5.50837 5.1919 5.34896 5.35127C5.18956 5.51065 5.1 5.72681 5.1 5.9522C5.1 6.17758 5.18956 6.39374 5.34896 6.55312C5.50837 6.71249 5.72457 6.80203 5.95 6.80203ZM16.15 8.50169H13.6V0.853209C13.6006 0.70346 13.5616 0.556213 13.487 0.426378C13.4123 0.296542 13.3047 0.18873 13.175 0.113856C13.0458 0.0392676 12.8992 0 12.75 0C12.6008 0 12.4542 0.0392676 12.325 0.113856L9.775 1.57557L7.225 0.113856C7.09579 0.0392676 6.94921 0 6.8 0C6.6508 0 6.50422 0.0392676 6.375 0.113856L3.82501 1.57557L1.27501 0.113856C1.14579 0.0392676 0.999212 0 0.850006 0C0.7008 0 0.554223 0.0392676 0.425007 0.113856C0.295293 0.18873 0.187671 0.296542 0.113038 0.426378C0.0384054 0.556213 -0.000587932 0.70346 6.70045e-06 0.853209V14.4505C6.70045e-06 15.1267 0.268667 15.7751 0.746884 16.2533C1.2251 16.7314 1.8737 17 2.55001 17H14.45C15.1263 17 15.7749 16.7314 16.2531 16.2533C16.7313 15.7751 17 15.1267 17 14.4505V9.35152C17 9.12613 16.9104 8.90997 16.751 8.7506C16.5916 8.59122 16.3754 8.50169 16.15 8.50169ZM2.55001 15.3003C2.32457 15.3003 2.10837 15.2108 1.94897 15.0514C1.78956 14.8921 1.70001 14.6759 1.70001 14.4505V2.32342L3.40001 3.29222C3.53119 3.36073 3.677 3.39651 3.82501 3.39651C3.97301 3.39651 4.11882 3.36073 4.25001 3.29222L6.8 1.83051L9.35 3.29222C9.48119 3.36073 9.627 3.39651 9.775 3.39651C9.92301 3.39651 10.0688 3.36073 10.2 3.29222L11.9 2.32342V14.4505C11.9023 14.7404 11.954 15.0278 12.053 15.3003H2.55001ZM15.3 14.4505C15.3 14.6759 15.2104 14.8921 15.051 15.0514C14.8916 15.2108 14.6754 15.3003 14.45 15.3003C14.2246 15.3003 14.0084 15.2108 13.849 15.0514C13.6896 14.8921 13.6 14.6759 13.6 14.4505V10.2014H15.3V14.4505ZM9.35 8.50169H4.25001C4.02457 8.50169 3.80837 8.59122 3.64896 8.7506C3.48956 8.90997 3.40001 9.12613 3.40001 9.35152C3.40001 9.57691 3.48956 9.79307 3.64896 9.95244C3.80837 10.1118 4.02457 10.2014 4.25001 10.2014H9.35C9.57544 10.2014 9.79164 10.1118 9.95104 9.95244C10.1104 9.79307 10.2 9.57691 10.2 9.35152C10.2 9.12613 10.1104 8.90997 9.95104 8.7506C9.79164 8.59122 9.57544 8.50169 9.35 8.50169Z"
                                fill="white"></path>
                        </svg>
                        <span> <?php echo display('pos_invoice') ?></span>
                    </a>
                    <a href="javascript:;" class="btn btn-orange d-flex align-center py-10  due_mergeprint"
                        data-toggle="tooltip" data-placement="left" title=""
                        data-url="<?php echo base_url("ordermanage/order/checkprintdue/" . $onprocess->marge_order_id) ?>"
                        data-original-title="<?php echo display('due_invoice'); ?>"><i
                            class="fa fa-window-restore"></i></a>
                </div>

            </div>
            <?php
          } else {
          ?>
            <div class="hero-widget well well-sm height-auto order-update-style">
                <div class="float-right mdjc">
                    <?php
                if ($this->permission->method('ordermanage', 'update')->access() && $onprocess->splitpay_status == 0): ?>
                    <div class="display-flex align-items-center">
                        <div class="kitchen-tab bd-pd-overflow">
                            <input id='chkbox-<?php echo $onprocess->order_id; ?>' type='checkbox' class="individual"
                                name="margeorder" value="<?php echo $onprocess->order_id; ?>" />
                            <label for='chkbox-<?php echo $onprocess->order_id; ?>' class="mb-0">
                                <span class="radio-shape mr-0"> <i class="fa fa-check"></i> </span>
                            </label>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                <table class="fs-15px width-100 mb-2">
                    <tr>
                        <td>
                            <span><?php echo display('table'); ?></span><br>
                            <span class="font-weight"><?php echo $onprocess->tablename; ?></span>
                        </td>
                        <td>
                            <span><?php echo display('ord_num'); ?></span><br>
                            <span class="font-weight"><?php echo $onprocess->saleinvoice; ?></span>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <span><?php echo display('waiter'); ?></span><br>
                            <span
                                class="font-weight"><?php echo $onprocess->first_name . ' ' . $onprocess->last_name; ?></span>
                        </td>
                        <td>
                            <span><?php echo display('before_time'); ?></span><br>
                            <?php
                    $diff = 0;

                    $actualtime = date('H:i:s');

                    $array1   = explode(':', $actualtime);
                    $array2   = explode(':', $onprocess->order_time);
                    $minutes1 = ($array1[0] * 3600.0 + $array1[1] * 60.0 + $array1[2]);
                    $minutes2 = ($array2[0] * 3600.0 + $array2[1] * 60.0 + $array2[2]);
                    $diff     = $minutes1 - $minutes2;

                    /* $format   = sprintf('%02d:%02d:%02d', round($diff / 3600), round($diff / 60 % 60), round($diff % 60)); */
                    //$format = $actualtime;

                    $currentTimeObj = new DateTime($actualtime);
                    $orderTimeObj   = new DateTime($onprocess->order_time);

                    // Calculate the difference
                    $interval = $currentTimeObj->diff($orderTimeObj);

                    // Output the difference in hours, minutes, and seconds
                    $format = $interval->format('%d days %H:%I:%S');
                    ?>
                            <span class="font-weight"><?php echo $format; ?></span>
                        </td>
                    </tr>
                </table>

                <div class="d-flex flex-wrap gap-8">
                    <?php

                if ($onprocess->splitpay_status == 0) {
                ?>
                    <a href="javascript:;" onclick="createMargeorder(<?php echo $onprocess->order_id; ?>,1)"
                        class="btn btn-green d-flex align-center py-10"><?php echo display('cmplt'); ?></a>
                    <a href="javascript:;" onclick="showsplitmodal(<?php echo $onprocess->order_id; ?>)"
                        class="btn btn-navy d-flex align-center py-10">
                        <svg class="m-r-5" width="20" height="17" viewBox="0 0 20 17" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.357 0H8.97607V16.5712H10.357V0Z" fill="white" />
                            <path
                                d="M5.52374 2.07136V14.4998H1.38093V2.07136H5.52374ZM5.52374 0.69043H1.38093C1.01469 0.69043 0.663442 0.835921 0.404466 1.0949C0.145491 1.35387 0 1.70512 0 2.07136V14.4998C0 14.866 0.145491 15.2173 0.404466 15.4762C0.663442 15.7352 1.01469 15.8807 1.38093 15.8807H5.52374C5.88999 15.8807 6.24123 15.7352 6.50021 15.4762C6.75918 15.2173 6.90467 14.866 6.90467 14.4998V2.07136C6.90467 1.70512 6.75918 1.35387 6.50021 1.0949C6.24123 0.835921 5.88999 0.69043 5.52374 0.69043Z"
                                fill="white" />
                            <path
                                d="M17.952 2.07136V14.4998H13.8092V2.07136H17.952ZM17.952 0.69043H13.8092C13.4429 0.69043 13.0917 0.835921 12.8327 1.0949C12.5737 1.35387 12.4282 1.70512 12.4282 2.07136V14.4998C12.4282 14.866 12.5737 15.2173 12.8327 15.4762C13.0917 15.7352 13.4429 15.8807 13.8092 15.8807H17.952C18.3182 15.8807 18.6695 15.7352 18.9284 15.4762C19.1874 15.2173 19.3329 14.866 19.3329 14.4998V2.07136C19.3329 1.70512 19.1874 1.35387 18.9284 1.0949C18.6695 0.835921 18.3182 0.69043 17.952 0.69043Z"
                                fill="white" />
                        </svg>
                        <?php echo display('split'); ?>
                    </a>
                    <?php

                  if ($this->permission->method('ordermanage', 'delete')->access()) { ?>
                    <a href="javascript:;" data-id="<?php echo $onprocess->order_id; ?>"
                        class="btn btn-red d-flex align-center py-10 cancelorder" data-toggle="tooltip"
                        data-placement="left" title=""
                        data-original-title="<?php echo display('cancel_order') ?>">Delete</a>
                    <?php }

                  ?>

                    <a href="javascript:;" class="btn btn-orange d-flex align-center py-10 due_print"
                        data-toggle="tooltip" data-placement="left" title=""
                        data-url="<?php echo base_url("ordermanage/order/dueinvoice/" . $onprocess->order_id) ?>"
                        data-original-title="<?php echo display('due_invoice'); ?>">
                        <i class="fa fa-window-restore"></i>
                    </a>
                    <a href="javascript:;" onclick="createMargeorder(<?php echo $onprocess->order_id; ?>,1)"
                        class="btn btn-violet d-flex align-center py-10" data-toggle="tooltip" data-placement="left"
                        title="" data-original-title="<?php echo display('pos_invoice') ?>">
                        <svg class="m-r-5" width="17" height="17" viewBox="0 0 17 17" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M9.35 11.901H4.25001C4.02457 11.901 3.80837 11.9905 3.64896 12.1499C3.48956 12.3093 3.40001 12.5255 3.40001 12.7508C3.40001 12.9762 3.48956 13.1924 3.64896 13.3518C3.80837 13.5111 4.02457 13.6007 4.25001 13.6007H9.35C9.57544 13.6007 9.79164 13.5111 9.95104 13.3518C10.1104 13.1924 10.2 12.9762 10.2 12.7508C10.2 12.5255 10.1104 12.3093 9.95104 12.1499C9.79164 11.9905 9.57544 11.901 9.35 11.901ZM5.95 6.80203H7.65C7.87544 6.80203 8.09164 6.71249 8.25104 6.55312C8.41045 6.39374 8.5 6.17758 8.5 5.9522C8.5 5.72681 8.41045 5.51065 8.25104 5.35127C8.09164 5.1919 7.87544 5.10236 7.65 5.10236H5.95C5.72457 5.10236 5.50837 5.1919 5.34896 5.35127C5.18956 5.51065 5.1 5.72681 5.1 5.9522C5.1 6.17758 5.18956 6.39374 5.34896 6.55312C5.50837 6.71249 5.72457 6.80203 5.95 6.80203ZM16.15 8.50169H13.6V0.853209C13.6006 0.70346 13.5616 0.556213 13.487 0.426378C13.4123 0.296542 13.3047 0.18873 13.175 0.113856C13.0458 0.0392676 12.8992 0 12.75 0C12.6008 0 12.4542 0.0392676 12.325 0.113856L9.775 1.57557L7.225 0.113856C7.09579 0.0392676 6.94921 0 6.8 0C6.6508 0 6.50422 0.0392676 6.375 0.113856L3.82501 1.57557L1.27501 0.113856C1.14579 0.0392676 0.999212 0 0.850006 0C0.7008 0 0.554223 0.0392676 0.425007 0.113856C0.295293 0.18873 0.187671 0.296542 0.113038 0.426378C0.0384054 0.556213 -0.000587932 0.70346 6.70045e-06 0.853209V14.4505C6.70045e-06 15.1267 0.268667 15.7751 0.746884 16.2533C1.2251 16.7314 1.8737 17 2.55001 17H14.45C15.1263 17 15.7749 16.7314 16.2531 16.2533C16.7313 15.7751 17 15.1267 17 14.4505V9.35152C17 9.12613 16.9104 8.90997 16.751 8.7506C16.5916 8.59122 16.3754 8.50169 16.15 8.50169ZM2.55001 15.3003C2.32457 15.3003 2.10837 15.2108 1.94897 15.0514C1.78956 14.8921 1.70001 14.6759 1.70001 14.4505V2.32342L3.40001 3.29222C3.53119 3.36073 3.677 3.39651 3.82501 3.39651C3.97301 3.39651 4.11882 3.36073 4.25001 3.29222L6.8 1.83051L9.35 3.29222C9.48119 3.36073 9.627 3.39651 9.775 3.39651C9.92301 3.39651 10.0688 3.36073 10.2 3.29222L11.9 2.32342V14.4505C11.9023 14.7404 11.954 15.0278 12.053 15.3003H2.55001ZM15.3 14.4505C15.3 14.6759 15.2104 14.8921 15.051 15.0514C14.8916 15.2108 14.6754 15.3003 14.45 15.3003C14.2246 15.3003 14.0084 15.2108 13.849 15.0514C13.6896 14.8921 13.6 14.6759 13.6 14.4505V10.2014H15.3V14.4505ZM9.35 8.50169H4.25001C4.02457 8.50169 3.80837 8.59122 3.64896 8.7506C3.48956 8.90997 3.40001 9.12613 3.40001 9.35152C3.40001 9.57691 3.48956 9.79307 3.64896 9.95244C3.80837 10.1118 4.02457 10.2014 4.25001 10.2014H9.35C9.57544 10.2014 9.79164 10.1118 9.95104 9.95244C10.1104 9.79307 10.2 9.57691 10.2 9.35152C10.2 9.12613 10.1104 8.90997 9.95104 8.7506C9.79164 8.59122 9.57544 8.50169 9.35 8.50169Z"
                                fill="white" />
                        </svg>
                        <span>POS Invoice</span>
                    </a>

                    <?php
                  if ($this->permission->method('ordermanage', 'update')->access() && $onprocess->splitpay_status == 0): ?>
                    <a href="javascript:;" onclick="editposorder(<?php echo $onprocess->order_id; ?>,1)"
                        class="btn btn-blue d-flex align-center py-10 pdmr" data-toggle="tooltip" data-placement="left"
                        title="" data-original-title="<?php echo display('update_ord') ?>"
                        id="table-<?php echo $onprocess->order_id; ?>">
                        Edit
                    </a>
                    <?php endif; ?>

                    <?php
                } else { ?>
                    <a href="javascript:;" onclick="showsplitmodal(<?php echo $onprocess->order_id; ?>)"
                        class="btn btn-ash"><?php echo display('split'); ?></a>
                    <br><br>
                    <?php
                }

                ?>

                </div>

            </div>
            <?php
          }

          ?>
        </div>
        <?php
      }
    } else {
      $odmsg = display('no_order_run');
      echo "<p class='pl-12'>" . $odmsg . "</p>";
    }

    ?>
    </div>
</div>
<script src="<?php echo base_url('application/modules/ordermanage/assets/js/ongoing.js'); ?>" type="text/javascript">
</script>