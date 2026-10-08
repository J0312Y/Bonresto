<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <h4><?php echo (!empty($title)?$title:null) ?></h4>
                </div>
            </div>
            <div class="panel-body">
            		
                <?php 
				echo form_open_multipart('reservation/reservation/settingsave','class="form-inner"') ?>
                    <?php echo form_hidden('id',$setting->id) ?>
                     <div class="form-group row">
                        <label for="storevat" class="col-xs-3 col-form-label"><?php echo display('opening_time') ?></label>
                        <div class="col-xs-9">
                            <input name="opentime" type="text" class="form-control timepicker" id="opentime" placeholder="<?php echo display('opening_time') ?>"  value="<?php echo $setting->reservation_open ?>" autocomplete="off" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="storevat" class="col-xs-3 col-form-label"><?php echo display('closeTime') ?></label>
                        <div class="col-xs-9">
                            <input name="closetime" type="text" class="form-control timepicker" id="closetime" placeholder="<?php echo display('closeTime') ?>"  value="<?php echo $setting->reservation_close ?>" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="storevat" class="col-xs-3 col-form-label"><?php echo display('max_reserveperson') ?></label>
                        <div class="col-xs-9">
                            <input name="maxperson" type="text" class="form-control" id="scharge" placeholder="<?php echo display('max_reserveperson') ?>"  value="<?php echo $setting->maxreserveperson ?>" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group text-right">
                        <button type="reset" class="btn btn-primary w-md m-b-5"><?php echo display('reset') ?></button>
                        <button type="submit" class="btn btn-success w-md m-b-5"><?php echo display('save') ?></button>
                    </div>
                <?php echo form_close() ?>
            </div>
        </div>
    </div>
</div>

<!-- Booking URL & QR Code -->
<div class="row" style="margin-top:20px;">
    <div class="col-sm-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <h4><i class="fa fa-qrcode"></i> Online Booking Link</h4>
                </div>
            </div>
            <div class="panel-body" style="display:flex;align-items:flex-start;gap:30px;flex-wrap:wrap;">
                <div style="flex:1;min-width:220px;">
                    <p style="margin-bottom:8px;color:#555;">Share this link or print the QR code so customers can book a table directly.</p>
                    <div class="input-group" style="margin-bottom:12px;">
                        <input type="text" id="bookingUrl" class="form-control" readonly value="<?php echo base_url('book'); ?>">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button" onclick="copyBookingUrl()" title="Copy link">
                                <i class="fa fa-copy"></i>
                            </button>
                        </span>
                    </div>
                    <a href="<?php echo base_url('reservation/reservation/booking_qr'); ?>" download="booking-qr.png" class="btn btn-primary btn-sm">
                        <i class="fa fa-download"></i> Download QR Code
                    </a>
                    <a href="<?php echo base_url('book'); ?>" target="_blank" class="btn btn-default btn-sm">
                        <i class="fa fa-external-link"></i> Preview Form
                    </a>
                </div>
                <div style="text-align:center;">
                    <img src="<?php echo base_url('reservation/reservation/booking_qr'); ?>" alt="Booking QR Code"
                         style="width:180px;height:180px;border:1px solid #ddd;border-radius:8px;padding:6px;background:#fff;">
                    <p style="font-size:11px;color:#999;margin-top:6px;">Scan to book a table</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function copyBookingUrl() {
    var el = document.getElementById('bookingUrl');
    el.select();
    document.execCommand('copy');
    alert('Link copied!');
}
</script>