<!-- Start Checkout Page  -->
<section class="sect_pad bg_soft_primary">
    <div class="container">
        <div class="row justify-content-center g-4">
            <div class="col-11 col-lg-7 col-md-7 col-xxl-6">
                <div class="card">
                    <?php if ($this->session->flashdata('message')) { ?>
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="alert"
                                aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                            <?php echo $this->session->flashdata('message') ?>
                        </div>
                    <?php } ?>
                    <?php if ($this->session->flashdata('exception')) { ?>
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="alert"
                                aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                            <?php echo $this->session->flashdata('exception') ?>
                        </div>
                    <?php } ?>
                    <?php if (validation_errors()) { ?>
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="alert"
                                aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                            <?php echo validation_errors() ?>
                        </div>
                    <?php } ?>

                    <div class="card-body p-4 py-lg-5">
                        <h4 class="fs-2 text_primary text-center"><?php echo display('register'); ?></h4>
                        <p class="text-center mb-4"><?php echo display('register_txt'); ?></p>
                        
                        <?= form_open_multipart('hungry/submitregister','class=""') ?>
                        <div class="row g-4 mb-4">
                            <div class="col-lg-6">
                                <label for="user_name" class="mb-2 font_prata"><?php echo display('name'); ?></label>
                                <input type="text" id="user_name" class="form-control custom-control" name="user_name" placeholder="" required>
                            </div>
                            <div class="col-lg-6">
                                <label for="user_email" class="mb-2 font_prata"><?php echo display('email'); ?></label>
                                <input type="email" id="user_email" class="form-control custom-control" name="user_email" placeholder="<?php echo display('email'); ?>" required>
                            </div>
                            <div class="col-lg-6">
                                <label for="phone" class="mb-2 font_prata"><?php echo display('phone'); ?></label>
                                <input type="text" id="phone" class="form-control custom-control" name="phone" placeholder="<?php echo display('phone'); ?>" required>
                            </div>
                            <div class="col-lg-6">
                                <label for="u_pass" class="mb-2 font_prata"><?php echo display('password'); ?></label>
                                <input type="password" id="u_pass" class="form-control custom-control" name="u_pass" placeholder="<?php echo display('password'); ?>" required>
                            </div>
                            <div class="col-lg-6">
                                <label for="UserPicture" class="mb-2 font_prata"><?php echo display('photo'); ?></label>
                                 <input name="UserPicture" id="UserPicture" class="form-control custom-control" type="file" style="width:100%;" />
                            </div>
                            <div class="col-lg-6">
                                <label for="address" class="mb-2 font_prata"><?php echo display('address'); ?></label>
                                <textarea name="address" id="address" class="form-control custom-control" cols="30" rows="2" placeholder<?php echo display('address'); ?>></textarea>
                            </div>
                        </div>
                        <div class="d-flex flex-column flex-md-row align-items-center gap-2">
                            <button type="submit" class="btn btn_primary py-2 w-100 lh-lg px-4"><?php echo display('register')?></button>
                            <p class="mb-0"><?php echo display('or')?></p>
                            <a href="<?php echo base_url().'mylogin'?>" class="btn btn-primary py-2 lh-lg w-100 px-4"><?php echo display('login'); ?></a>
                        </div>
                        <?php echo form_close() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Checkout Page  -->

<script src="<?php echo base_url(); ?>application/views/themes/<?php echo $acthemename; ?>/assets_web/js/signup.js"></script>
    