<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="content-wrapper">
    <section class="content-header">
        <h1><?php echo $title; ?></h1>
    </section>

    <section class="content">
        <div class="box box-primary">
            <div class="box-body table-responsive">
                <table class="table table-bordered table-striped" id="tableQrTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Table No</th>
                            <th>QR Code</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($tables)) { 
                            $sl = 1;
                            foreach($tables as $table) { ?>
                                <tr>
                                    <td><?php echo $sl++; ?></td>
                                    <td><?php echo $table->table_no; ?></td>
                                    <td>
                                        <?php if(!empty($table->qr_code)) { ?>
                                            <img src="<?php echo base_url('uploads/qrcodes/'.$table->qr_code); ?>" width="80">
                                        <?php } else { echo '-'; } ?>
                                    </td>
                                </tr>
                        <?php } } else { ?>
                            <tr>
                                <td colspan="3" class="text-center">No Tables Found</td>
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
    $('#tableQrTable').DataTable();
});
</script>
