<div class="modal fade" id="lostpassword" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header ps-3 py-1">
                <h1 class="modal-title fs-5" id="exampleModalLabel"><?php echo display('forgot_password')?></h5>
                <button type="button" class="btn" data-bs-dismiss="modal" aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M2.146 2.146a.5.5 0 0 1 .708 0L8 7.293l5.146-5.147a.5.5 0 0 1 
                        .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 
                        5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854a.5.5 0 0 
                        1 0-.708z"/>
                    </svg>
                </button>
            </div>
            <div class="modal-body passwordupdate">
                <div class="form-group mb-2">
                    <label class="control-label" for="user_email"><?php echo display('please_enter_your_email')?></label>
                    <input type="text" id="user_email2" class="form-control" name="user_email2">
                </div>
                <a onclick="lostpassword();" class="btn btn-success btn-sm lost-pass"><?php echo display('submit')?></a>
            </div>
        </div>
    </div>
</div>

<!-- Start Checkout Page  -->
<section class="sect_pad bg_soft_primary">
    <div class="container">
        <div class="row justify-content-center g-4">
            <div class="col-11 col-lg-5 col-md-7 col-xxl-4">
                <div class="card">
                    <div class="card-body p-4 p-xl-5">
                        <h4 class="fs-2 text_primary text-center"><?php echo display('login'); ?></h4>
                        <p class="text-center mb-4"><?php echo display('shopping_details_information_msg')?></p>
                        <div class="row g-4">
                            <div class="col-12">
                                <label for="user_email" class="mb-2 font_prata"><?php echo display('email') ?></label>
                                <input type="text" id="user_email" class="form-control custom-control" name="user_email" value="" placeholder="<?php echo display('email') ?>">
                            </div>
                            <div class="col-12">
                                <label for="u_pass" class="mb-2 font_prata"><?php echo display('password') ?></label>
                                <input type="password" id="u_pass" class="form-control custom-control" name="u_pass" value="" placeholder="<?php echo display('password') ?>">
                            </div>
                            <div class="col-12">
                                <div class="d-flex flex-wrap justify-content-between align-items-center font_prata mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input custom-check" type="checkbox" value="1" id="brand1" name="isremember" />
                                        <label class="form-check-label fs-15" for="brand1"><?php echo display('remember_me')?></label>
                                    </div>
                                    
                                    <button class="btn btn-link px-0 text-decoration-none fs-15" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#lostpassword">
                                        <?php echo display('forgot_password'); ?>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-column align-items-center gap-2 mb-2">
                            <a class="btn btn_primary lh-base py-2 w-100 lh-lg px-4" onclick="logincustomer();"><?php echo display('login')?></a>
                            <?php 
                            $facrbooklogn = $this->db->where('directory', 'facebooklogin')->where('status', 1)->get('module')->num_rows();
                            if ($facrbooklogn == 1) { ?>
                                <p class="mb-0"><?php echo display('or')?></p>
                            
                                <a class="btn btn-primary font_prata py-2 lh-base w-100 lh-lg px-4" href="<?php echo base_url('facebooklogin/facebooklogin/index/1') ?>"><i class="fa fa-facebook pr-1"></i><?php echo display('facebook_login') ?></a>
                                <?php 
                            } ?>
                        </div>
                        <div class="d-flex justify-content-center font_prata align-items-center gap-2">
                            <p class="mb-0 fs-15"><?php echo display('create_account'); ?></p>
                            <a href="<?php echo base_url() . 'hungry/signup' ?>" class="btn btn-link px-0 text-decoration-none fs-15"><?php echo display('register')?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Checkout Page  -->

<?php 
$webinfo = $this->webinfo;
$activethemeinfo = $this->themeinfo;
$acthemename = $activethemeinfo->themename; ?>

<!--End Login Area-->
<script src="<?php echo base_url(); ?>application/views/themes/<?php echo $acthemename; ?>/assets_web/js/login.js"></script>
