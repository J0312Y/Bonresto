<div class="panel panel-default">
  <div class="panel-heading">
    <h4><i class="fa fa-credit-card"></i> QR Payment Settings</h4>
  </div>

  <div class="panel-body">
    <table class="table table-bordered table-hover">
      <thead>
        <tr>
          <th>#</th>
          <th>Payment Name</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($payment_methods)) { 
          $i = 1; 
          foreach ($payment_methods as $method): ?>
          <tr>
            <td><?= $i++; ?></td>
            <td><strong><?= html_escape($method->payment_method); ?></strong></td>
            <td>
              <label class="switch">
                <input type="checkbox" class="toggle-status" data-id="<?= $method->id; ?>" <?= $method->is_active ? 'checked' : ''; ?>>
                <span class="slider round"></span>
              </label>
            </td>
          </tr>
        <?php endforeach; } else { ?>
          <tr><td colspan="4" class="text-center text-muted">No payment methods found</td></tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>

<style>
.switch {
  position: relative;
  display: inline-block;
  width: 50px;
  height: 26px;
}
.switch input { display: none; }
.slider {
  position: absolute;
  cursor: pointer;
  top: 0; left: 0; right: 0; bottom: 0;
  background-color: #ccc;
  transition: .4s;
  border-radius: 26px;
}
.slider:before {
  position: absolute;
  content: "";
  height: 20px; width: 20px;
  left: 3px; bottom: 3px;
  background-color: white;
  transition: .4s;
  border-radius: 50%;
}
input:checked + .slider {
  background-color: #28a745;
}
input:checked + .slider:before {
  transform: translateX(24px);
}
</style>

<!-- Toast style -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
$(document).ready(function() {
    $('.toggle-status').on('change', function() {
        var id = $(this).data('id');
        var is_active = $(this).is(':checked') ? 1 : 0;

        $.ajax({
            url: "<?= base_url('qrapp/Qrtable/update_payment_status'); ?>",
            type: "POST",
            data: { id: id, is_active: is_active },
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    toastr.success(response.message, 'Success', {timeOut: 2000});
                } else {
                    toastr.error(response.message, 'Error', {timeOut: 2000});
                }
            },
            error: function() {
                toastr.error('An unexpected error occurred', 'Error', {timeOut: 2000});
            }
        });
    });
});
</script>
