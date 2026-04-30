<?php

if ($this->session->flashdata('message')) {
    ?>
<script>
 setTimeout(function () {
        toastr.options = {
            closeButton: true,
            progressBar: true,
            showMethod: 'slideDown',
            timeOut: 4000

        };
        toastr.success('<?php echo $this->session->flashdata('message') ?>', 'Success');

    }, 1300);
</script>

<?php
$this->session->unset_userdata('message');
}

?>
<?php

if ($this->session->flashdata('exception')) {
    ?>
<script>
 setTimeout(function () {
        toastr.options = {
            closeButton: true,
            progressBar: true,
            showMethod: 'slideDown',
            timeOut: 4000

        };
        toastr.error('<?php echo $this->session->flashdata('exception') ?>', 'Something Wrong');

    }, 1300);
</script>

<?php
$this->session->unset_userdata('exception');
}

?>
<?php

// License grace-period warning banner
if ($this->session->flashdata('license_warning')): ?>
<div style="background:#fef3c7;border-bottom:2px solid #f59e0b;padding:10px 20px;font-size:14px;color:#92400e;display:flex;align-items:center;gap:10px">
    <span>⚠️</span>
    <span><?php echo htmlspecialchars($this->session->flashdata('license_warning')); ?></span>
    <a href="<?php echo site_url('dashboard/license'); ?>" style="margin-left:auto;font-weight:600;color:#b45309;text-decoration:underline">
        Gérer la licence →
    </a>
</div>
<?php endif;

if (validation_errors()) {?>

<div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <?php echo validation_errors() ?>
</div>
<?php }

?>