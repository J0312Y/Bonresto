<?php $webinfo = $this->webinfo; ?>

<!--START HERO PART -->
<div class="common-bg position-relative">
    <img class="img-fluid common-bg-img" src="<?php echo base_url(!empty($hero_bg->image) ? $hero_bg->image : 'application/views/themes/' . $theme_name . '/assets_web/images/common-bg.webp'); ?>" alt="" />
    <div class="sect_pad position-relative z-2">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-xl-8">
                    <h1 class="main_title text-white text-center" data-aos="fade-down" data-aos-delay="100"><?php echo $title; ?></h1>
                    <div class="menu-breadcrumb" data-aos="fade-down" data-aos-delay="150">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>"><?php echo display('home') ?></a></li>
                                <li class="breadcrumb-item active" aria-current="page"><?php echo $title; ?></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--END HERO PART -->

<!-- Start Expert  -->
<section class="sect_pad">
    <div class="container">
        <div class="row g-4 g-lg-5 mb-5">
            <div class="col-md-6 col-xl-4" data-aos="fade-down" data-aos-delay="100">
                <div class="bg_deep_primary d-flex gap-4 rounded-5 p-4">
                    <img class="img-fluid h-60" src="<?php echo base_url(); ?>application/views/themes/<?php echo $this->themeinfo->themename; ?>/assets_web/images/location.png" alt="" />
                    <div>
                        <h3 class="font_prata fs-22 text-black mb-2"><?php echo display('office_addres1') ?></h3>
                        <p class="font_prata fs-15"><?php echo $webinfo->address; ?></p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-4" data-aos="fade-down" data-aos-delay="100">
                <div class="bg_deep_primary d-flex gap-4 rounded-5 h-100 p-4">
                    <img class="img-fluid h-60" src="<?php echo base_url(); ?>application/views/themes/<?php echo $this->themeinfo->themename; ?>/assets_web/images/call.png" alt="" />
                    <div>
                        <h3 class="font_prata fs-22 text-black mb-2"><?php echo display('call_us') ?></h3>
                        <p class="font_prata fs-15">
                            <?php echo $webinfo->phone; ?> <br>
                            <?php echo $webinfo->phone_optional; ?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-4" data-aos="fade-down" data-aos-delay="100">
                <div class="bg_deep_primary d-flex gap-4 rounded-5 h-100 p-4">
                    <img class="img-fluid h-60" src="<?php echo base_url(); ?>application/views/themes/<?php echo $this->themeinfo->themename; ?>/assets_web/images/email.png" alt="" />
                    <div>
                        <h3 class="font_prata fs-22 text-black mb-2"><?php echo display('sent_message') ?></h3>
                        <p class="font_prata fs-15">
                            <?php echo $webinfo->email; ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card rounded-4">
            <div class="row">
                <?php
                $contactsms = $this->db->select('*')->from('tbl_widget')->where('widgetid', 23)->where('status', 1)->get()->row(); ?>

                <div class="col-lg-5">
                    <img class="rounded-top-left rounded-bottom-left img-fluid h-100 d-none d-lg-block" src="<?php echo base_url(!empty($contactimg->image) ? $contactimg->image : 'dummyimage/555x370.jpg'); ?>" alt="" />
                </div>
                <div class="col-lg-7">
                    <?php
                    if ($this->session->flashdata('message')) { ?>
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                            <?php echo $this->session->flashdata('message') ?>
                            <?php echo $this->session->unset_userdata('message'); ?>
                        </div> <?php 
                    }
                    if ($this->session->flashdata('exception')) { ?>
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                            <?php echo $this->session->flashdata('exception') ?>
                            <?php echo $this->session->unset_userdata('exception'); ?>
                        </div> <?php 
                    }
                    if (validation_errors()) { ?>
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                            <?php echo validation_errors() ?>
                        </div> <?php 
                    } 

                    echo form_open('hungry/sendemail', 'method="post"') ?>
                        <div class="p-4 p-xl-5 ps-lg-0">
                            <h4 class="fs-2 text_primary text-center mb-2"><?php echo $contactsms->widget_name ?? ''; ?></h4>
                            <p class="mb-4 font_prata"><?php echo $contactsms->widget_desc ?? ''; ?></p>
                            <div class="row g-4 mb-4 mt-2">
                                <div class="col-lg-6">
                                    <label for="firstname" class="mb-2 font_prata"><?php echo display('first_name') ?></label>
                                    <input type="text" class="form-control custom-control" id="firstname" name="firstname" autocomplete="off" placeholder="<?php echo display('first_name') ?>" required>
                                </div>
                                <div class="col-lg-6">
                                    <label for="lastname" class="mb-2 font_prata"><?php echo display('last_name') ?></label>
                                    <input type="text" class="form-control custom-control" id="lastname" name="lastname" autocomplete="off" placeholder="<?php echo display('last_name') ?>" required>
                                </div>
                                <div class="col-lg-6">
                                    <label for="phone" class="mb-2 font_prata"><?php echo display('phone') ?></label>
                                    <input type="number" class="form-control custom-control" id="phone" name="phone" autocomplete="off" placeholder="<?php echo display('phone') ?>" required>
                                </div>
                                <div class="col-lg-6">
                                    <label for="email" class="mb-2 font_prata"><?php echo display('email') ?></label>
                                    <input type="email" class="form-control custom-control" id="email" name="email" autocomplete="off" placeholder="<?php echo display('email') ?>" required>
                                </div>
                                <div class="col-12">
                                    <label for="comments" class="mb-2 font_prata"><?php echo display('write_comments') ?></label>
                                    <textarea name="comments" id="comments" rows="4" class="form-control custom-control" placeholder="<?php echo display('write_comments') ?>" required></textarea>
                                </div>
                            </div>
                            <button type="submit"  class="btn btn_primary py-2 w-100 lh-lg px-4"><?php echo display('send') ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Expert  -->
