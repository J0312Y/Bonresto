<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-credit-card"></i> QR Payment Setting</h3>
    </div>

    <div class="panel-body">
        <div class="row">
            <?php foreach ($payment_methods as $method): ?>
                <div class="col-sm-3 col-xs-6 mb-3">
                    <div class="checkbox checkbox-success" style="font-size:16px;">
                        <label style="display:flex; align-items:center; gap:8px;">
                            <input 
                                type="checkbox" 
                                class="toggle-payment" 
                                data-id="<?php echo $method->payment_method_id; ?>"
                                <?php echo ($method->is_active == 1) ? 'checked' : ''; ?>
                            >
                            <strong><?php echo ucfirst($method->payment_method); ?></strong>
                        </label>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('.toggle-payment').change(function() {
        var id = $(this).data('id');
        var status = $(this).is(':checked') ? 1 : 0;
        $.ajax({
            url: "<?php echo base_url('qrapp/qrpayment/update_status'); ?>",
            method: "POST",
            data: {
                id: id,
                status: status,
                '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
            },
            success: function() {
                toastr.success('Payment method updated successfully');
            },
            error: function() {
                toastr.error('Update failed, please try again');
            }
        });
    });
});
</script>

<style>
.panel-default {
    border-radius: 10px;
    border: 1px solid #ddd;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}
.checkbox-success input[type="checkbox"]:checked + strong {
    color: #2d9c3c;
}
.mb-3 { margin-bottom: 15px; }
</style>
