<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="content-wrapper">
    <section class="content-header">
        <h1><?php echo $title; ?></h1>
    </section>

    <section class="content">
        <div class="box box-primary">
            <div class="box-body table-responsive">
                <table class="table table-bordered table-striped" id="qrOrderTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Order ID</th>
                            <th>Customer Name</th>
                            <th>Phone</th>
                            <th>Table No</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                            <th>Order Date</th>
                            <th>Action</th>
                        
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($orders)) { 
                            $sl = 1;
                            foreach($orders as $order) { ?>
                                <tr>
                                    <td><?php echo $sl++; ?></td>
                                    <td><?php echo $order->order_id; ?></td>
                                    <td><?php echo $order->fullname ?? 'Guest'; ?></td>
                                    <td><?php echo $order->phone ?? '-'; ?></td>
                                    <td><?php echo $order->table_no ?? '-'; ?></td>
                                    <td><?php echo number_format($order->total_amount, 2); ?></td>
                                    <td>
                                        <?php 
                                        if($order->order_status == 1) echo "<span class='label label-success'>Completed</span>";
                                        elseif($order->order_status == 2) echo "<span class='label label-warning'>Pending</span>";
                                        else echo "<span class='label label-danger'>Cancelled</span>";
                                        ?>
                                    </td>
                                    <td><?php echo date('d-m-Y H:i', strtotime($order->created_at)); ?></td>
                                    <td>
                                        <a href="<?php echo base_url('qrapp/qrorder/view/'.$order->order_id); ?>" class="btn btn-info btn-sm">View</a>
                                    </td>
                                </tr>
                        <?php } } else { ?>
                            <tr>
                                <td colspan="9" class="text-center">No QR Orders Found</td>
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
    $('#qrOrderTable').DataTable();
});
</script>
