<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="content-wrapper">
    <section class="content-header">
        <h1><?php echo $title; ?></h1>
    </section>

    <section class="content">
        <div class="box box-primary">
            <div class="box-body table-responsive">
                <table class="table table-bordered table-striped" id="qrPaymentTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Payment Method</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($payments)) { 
                            $sl = 1;
                            foreach($payments as $pay) { ?>
                                <tr>
                                    <td><?php echo $sl++; ?></td>
                                    <td><?php echo $pay->method_name; ?></td>
                                    <td>
                                        <?php echo ($pay->is_active) ? "<span class='label label-success'>Active</span>" : "<span class='label label-danger'>Inactive</span>"; ?>
                                    </td>
                                </tr>
                        <?php } } else { ?>
                            <tr>
                                <td colspan="3" class="text-center">No QR Payment Methods Found</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<script>
$(document).ready(function() {
    $('#qrPaymentTable').DataTable();
});
</script>
