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

<!-- Start Table Book  -->
<?php if (!empty($reservation)) { ?>
    <section class="sect_pad" id="book-table">
        <div class="container">
            <div class="row g-4 g-lg-5 align-items-center justify-content-between">
                <div class="col-lg-6">
                    <div class="table-book" data-aos="zoom-in">
                        <img src="<?php echo base_url(!empty($reservation_sl[0]->image) ? $reservation_sl[0]->image : 'dummyimage/470x548.jpg'); ?>" class="img-fluid" alt="">
                    </div>
                </div>

                <div class="col-lg-6">
                    <p class="font_prata fs-18 text_primary mb-3" data-aos="fade-down" data-aos-delay="100"><?php echo $reservation->widget_name; ?></p>
                    <h2 class="fs-50 font-fantasy text-color1 mb-4" data-aos="fade-down" data-aos-delay="150"><?php echo $reservation->widget_title; ?></h2>

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
                    } ?>
                    
                    <form class="/*main-reservaton-form*/" action="#" method="post">
                        <div class="input-group mb-4" data-aos="zoom-in">
                            <span class="input-group-text custom-input-group-text">
                                <svg width="21" height="24" viewBox="0 0 21 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M14.1248 13.7773C14.1438 13.7773 14.1628 13.7778 14.1817 13.7787C16.8373 13.9106 19.1912 15.5265 20.2693 17.9549C21.0437 19.5041 20.6122 21.0377 19.6235 22.0938C18.6662 23.1163 17.1831 23.727 15.6417 23.727H5.02474C3.4839 23.727 2.00124 23.1162 1.04413 22.0938C0.0555098 21.0378 -0.376621 19.5041 0.397333 17.9546C1.47555 15.5264 3.82936 13.9106 6.48473 13.7787L6.51318 13.7777C6.52266 13.7775 6.53218 13.7773 6.54167 13.7773H14.1248ZM6.57231 16.0734C4.78593 16.172 3.20564 17.267 2.48665 18.907C2.47775 18.9273 2.46826 18.9473 2.4582 18.9671C2.1704 19.5321 2.2779 20.0521 2.72031 20.5246C3.20053 21.0376 4.0537 21.4309 5.02474 21.4309H15.6417C16.6138 21.4309 17.4673 21.0374 17.9474 20.5246C18.3895 20.0524 18.4968 19.5327 18.2086 18.9676C18.1984 18.9477 18.1888 18.9274 18.1798 18.9069C17.4609 17.267 15.8807 16.172 14.0941 16.0734H6.57231Z"
                                    fill="#BFBFBF"
                                />
                                <path d="M13.778 5.74017C13.778 4.82667 13.4152 3.95065 12.7693 3.3048C12.1235 2.65894 11.2474 2.29607 10.3339 2.29607C8.43184 2.29607 6.88982 3.83804 6.88982 5.74017C6.88982 7.6423 8.43184 9.18427 10.3339 9.18427C12.2361 9.18427 13.778 7.6423 13.778 5.74017ZM16.074 5.74017C16.074 8.91036 13.5042 11.4803 10.3339 11.4803C7.16374 11.4803 4.59375 8.91037 4.59375 5.74017C4.59375 2.56998 7.16374 0 10.3339 0C11.8563 3.86599e-06 13.3164 0.604755 14.3929 1.68127C15.4694 2.75781 16.074 4.21786 16.074 5.74017Z" fill="#BFBFBF" />
                                </svg>
                            </span>
                            <input type="text" class="form-control custom-control" name="reservation_person" id="reservation_person" placeholder="<?php echo display('reservation_person')?>" autocomplete="off">
                        </div>

                        <div class="input-group mb-4" data-aos="zoom-in">
                            <span class="input-group-text custom-input-group-text">
                                <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <mask id="mask0_11_862" style="mask-type: luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="28" height="28">
                                    <path d="M28 0H0V28H28V0Z" fill="white" />
                                </mask>
                                <g mask="url(#mask0_11_862)">
                                    <path
                                    d="M7.00065 25.9699C5.76297 25.9699 4.57599 25.4782 3.70082 24.6031C2.82565 23.7279 2.33398 22.5409 2.33398 21.3032V10.8032C2.33398 9.56555 2.82565 8.37857 3.70082 7.5034C4.57599 6.62823 5.76297 6.13656 7.00065 6.13656H8.16732C8.47674 6.13656 8.77348 6.25948 8.99228 6.47827C9.21107 6.69706 9.33398 6.99381 9.33398 7.30323C9.33398 7.61265 9.21107 7.90939 8.99228 8.12819C8.77348 8.34698 8.47674 8.4699 8.16732 8.4699H7.00065C6.38181 8.4699 5.78832 8.71573 5.35073 9.15331C4.91315 9.5909 4.66732 10.1844 4.66732 10.8032V21.3032C4.66732 21.9221 4.91315 22.5156 5.35073 22.9531C5.78832 23.3907 6.38181 23.6366 7.00065 23.6366H21.0007C21.6185 23.634 22.2101 23.3864 22.6457 22.9482C22.8668 22.7284 23.0417 22.4665 23.1599 22.1779C23.2781 21.8894 23.3373 21.58 23.334 21.2682V10.7682C23.334 10.1494 23.0882 9.5559 22.6506 9.11831C22.213 8.68073 21.6195 8.4349 21.0007 8.4349H19.834C19.5246 8.4349 19.2278 8.31198 19.009 8.09319C18.7902 7.87439 18.6673 7.57765 18.6673 7.26823C18.6673 6.95881 18.7902 6.66206 19.009 6.44327C19.2278 6.22448 19.5246 6.10156 19.834 6.10156H21.0007C22.2383 6.10156 23.4253 6.59323 24.3005 7.4684C25.1757 8.34357 25.6673 9.53055 25.6673 10.7682V21.2682C25.6673 22.5059 25.1757 23.6929 24.3005 24.5681C23.4253 25.4432 22.2383 25.9349 21.0007 25.9349H7.00065V25.9699Z"
                                    fill="#BFBFBF"
                                    />
                                    <path d="M11.6676 8.45833C11.3582 8.45833 11.0615 8.33542 10.8427 8.11662C10.6239 7.89783 10.501 7.60109 10.501 7.29167C10.501 6.98225 10.6239 6.6855 10.8427 6.46671C11.0615 6.24792 11.3582 6.125 11.6676 6.125H16.3343C16.6437 6.125 16.9405 6.24792 17.1593 6.46671C17.3781 6.6855 17.501 6.98225 17.501 7.29167C17.501 7.60109 17.3781 7.89783 17.1593 8.11662C16.9405 8.33542 16.6437 8.45833 16.3343 8.45833H11.6676Z" fill="#BFBFBF" />
                                    <path
                                    d="M9.89433 10.2195C9.51036 10.2153 9.13106 10.1348 8.77853 9.98256C8.426 9.83033 8.1073 9.60946 7.841 9.3328C7.57453 9.06618 7.3632 8.74967 7.21907 8.40136C7.07494 8.05305 7.00084 7.67975 7.001 7.3028V4.96947C6.99946 4.587 7.07347 4.20799 7.21877 3.85419C7.36407 3.50039 7.57781 3.17877 7.84772 2.90778C8.11763 2.63679 8.43839 2.42176 8.7916 2.27504C9.14482 2.12832 9.52353 2.0528 9.906 2.0528C10.2868 2.0502 10.6643 2.1231 11.0167 2.26728C11.3692 2.41146 11.6896 2.62407 11.9593 2.8928C12.2342 3.16224 12.4531 3.48342 12.6032 3.83784C12.7534 4.19225 12.832 4.57289 12.8343 4.9578V7.29113C12.8343 8.06778 12.5258 8.81261 11.9766 9.36178C11.4275 9.91095 10.6826 10.2195 9.906 10.2195H9.89433ZM9.89433 4.38613C9.73962 4.38613 9.59125 4.44759 9.48185 4.55699C9.37246 4.66639 9.311 4.81476 9.311 4.96947V7.3028C9.31399 7.45658 9.3764 7.60322 9.48516 7.71198C9.59391 7.82073 9.74056 7.88315 9.89433 7.88613C9.97345 7.88769 10.0521 7.87344 10.1256 7.84424C10.1992 7.81503 10.2661 7.77145 10.3226 7.71604C10.3791 7.66064 10.424 7.59452 10.4546 7.52156C10.4852 7.4486 10.501 7.37026 10.501 7.29113V4.9578C10.4979 4.80512 10.4351 4.65973 10.3261 4.55284C10.217 4.44596 10.0704 4.3861 9.91767 4.38613H9.89433Z"
                                    fill="#BFBFBF"
                                    />
                                    <path
                                    d="M18.0613 10.196C17.2928 10.1868 16.5587 9.87581 16.0174 9.33015C15.4761 8.78449 15.171 8.04789 15.168 7.2793V4.94596C15.1665 4.56349 15.2405 4.18448 15.3858 3.83068C15.5311 3.47689 15.7448 3.15526 16.0147 2.88427C16.2846 2.61328 16.6054 2.39826 16.9586 2.25154C17.3118 2.10482 17.6905 2.02929 18.073 2.0293C18.8456 2.02927 19.5869 2.33459 20.1354 2.87872C20.6839 3.42285 20.9952 4.1617 21.0013 4.9343V7.26763C21.0014 8.04025 20.696 8.78156 20.1519 9.33007C19.6078 9.87857 18.8689 10.1898 18.0963 10.196H18.0613ZM18.0613 7.86263C18.216 7.86263 18.3644 7.80117 18.4738 7.69178C18.5832 7.58238 18.6447 7.43401 18.6447 7.2793V4.94596C18.6447 4.79125 18.5832 4.64288 18.4738 4.53348C18.3644 4.42409 18.216 4.36263 18.0613 4.36263C17.9066 4.36263 17.7582 4.42409 17.6488 4.53348C17.5395 4.64288 17.478 4.79125 17.478 4.94596V7.2793C17.478 7.43401 17.5395 7.58238 17.6488 7.69178C17.7582 7.80117 17.9066 7.86263 18.0613 7.86263Z"
                                    fill="#BFBFBF"
                                    />
                                    <path d="M3.50065 14.3138C3.19123 14.3138 2.89449 14.1909 2.67569 13.9721C2.4569 13.7533 2.33398 13.4566 2.33398 13.1471C2.33398 12.8377 2.4569 12.541 2.67569 12.3222C2.89449 12.1034 3.19123 11.9805 3.50065 11.9805H24.5007C24.8101 11.9805 25.1068 12.1034 25.3256 12.3222C25.5444 12.541 25.6673 12.8377 25.6673 13.1471C25.6673 13.4566 25.5444 13.7533 25.3256 13.9721C25.1068 14.1909 24.8101 14.3138 24.5007 14.3138H3.50065Z" fill="#BFBFBF" />
                                </g>
                                </svg>
                            </span>

                            <input type="text" class="form-control custom-control" name="reservation_date" id="reservation_date" placeholder="<?php echo display('reservation_date')?>" autocomplete="off">
                        </div>

                        <div class="input-group mb-4" data-aos="zoom-in">
                            <span class="input-group-text custom-input-group-text">
                                <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M12.1579 0C5.44206 0 0 5.443 0 12.1579C0 18.8728 5.44206 24.3158 12.1579 24.3158C18.8719 24.3158 24.3158 18.8728 24.3158 12.1579C24.3158 5.443 18.8728 0 12.1579 0ZM12.0597 22.003C6.63634 22.003 2.23986 17.6065 2.23986 12.1831C2.23986 6.75979 6.63634 2.36331 12.0597 2.36331C17.4821 2.36331 21.8795 6.75979 21.8795 12.1831C21.8795 17.6065 17.4821 22.003 12.0597 22.003ZM14.8981 12.748H12.1111V8.04198C12.1111 7.53135 11.6968 7.11611 11.1862 7.11611C10.6756 7.11611 10.2603 7.53041 10.2603 8.04198V13.673C10.2603 14.1845 10.6746 14.5979 11.1862 14.5979H14.8981C15.4097 14.5979 15.824 14.1845 15.824 13.673C15.824 13.1623 15.4097 12.748 14.8981 12.748Z"
                                    fill="#BFBFBF"
                                />
                                </svg>
                            </span>

                            <input type="text" class="form-control custom-control" name="reservation_time" id="reservation_time" placeholder="<?php echo display('reservation_time')?>" autocomplete="off">
                        </div>

                        <div class="input-group mb-4" data-aos="zoom-in">
                            <span class="input-group-text custom-input-group-text">
                                <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path 
                                        d="M19.8 15.6l-2.6-1.1c-.4-.2-.9-.1-1.2.2l-1.2 1.4c-3-1.3-5.4-3.7-6.7-6.7l1.4-1.2c.3-.3.4-.8.2-1.2l-1.1-2.6c-.2-.5-.7-.8-1.3-.8h-2c-.7 0-1.3.6-1.3 1.3 0 8.2 6.6 14.8 14.8 14.8.7 0 1.3-.6 1.3-1.3v-2c0-.5-.3-1.1-.8-1.3z" 
                                        stroke="#BFBFBF" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>

                            <input type="text" class="form-control custom-control" name="reservation_contact" id="reservation_contact" placeholder="<?php echo display('reservation_contact')?>" autocomplete="off">
                        </div>

                        <input name="checkurl" id="checkurl" type="hidden" value="<?php echo base_url("hungry/checkavailablity"); ?>" />
                        <button type="button" class="btn btn_primary w-100 simple_btn mt-0" data-aos="zoom-in" onclick="checkavailablity()"><?php echo display('book_table')?></button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!--Start Table Chart-->
    <div class="modal fade" id="edit" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-addons">
                <div class="modal-header ps-3 py-1">
                    <h1 class="modal-title fs-5" id="exampleModalLabel"><?php echo display('reserve_table') ?></h5>
                    <button type="button" class="btn" data-bs-dismiss="modal" aria-label="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M2.146 2.146a.5.5 0 0 1 .708 0L8 7.293l5.146-5.147a.5.5 0 0 1 
                            .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 
                            5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854a.5.5 0 0 
                            1 0-.708z"/>
                        </svg>
                    </button>
                </div>
                <div class="modal-body editinfo">

                </div>
            </div>
        </div>
    </div>

    <section class="table_chart" id="searchreservation" style="background:#f6f6f6;">
        <div class="container">
            <div class="row table_chart_inner" id="addmargind">

            </div>
        </div>
    </section>
    <!--End Table Chart-->

<?php } ?>
<!-- End Table Book  -->

<!-- Start Our Culinary Expert slider  -->
<?php if (!empty($photogallery)) { ?>
    <section class="sect_pad bg-dark-green">
        <div class="container-fluid overflow-hidden">
            <div class="row g-4 g-lg-5 justify-content-center align-items-center mb-5">
                <div class="col-xl-7 col-md-10 text-center">
                    <p class="font_prata fs-20 text_primary" data-aos="fade-down" data-aos-delay="100"><?php echo $photogallery->widget_name; ?></p>
                    <h2 class="main_title text-white" data-aos="fade-down" data-aos-delay="150"><?php echo $photogallery->widget_title; ?></h2>
                </div>
            </div>
            <div class="row justify-content-center g-4 position-relative" data-aos="zoom-in">
                <div class="col-md-12">
                    <div class="owl-carousel expert-carousel owl-theme">
                        <?php 
                        foreach ($gallery as $image) { ?>
                            <div class="expert-slider">
                                <img class="img-fluid" src="<?php echo base_url(!empty($image->image) ? $image->image : 'dummyimage/363x363.jpg'); ?>" alt="" />
                                <div class="expert-slider-text">
                                    <p class="font_prata fs-2 text-white mb-0"><?php echo $image->title; ?></p>
                                    <a href="<?php echo base_url('gallery'); ?>" class="btn-expert">
                                        <svg width="27" height="28" viewBox="0 0 27 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M26.3212 21.24C26.3783 22.0066 25.802 22.6535 25.0339 22.6849C24.2659 22.7162 23.5969 22.1202 23.5398 21.3537L22.3273 5.0751L2.67843 27.1281L2.6546 27.1542C2.14827 27.6933 1.28602 27.7202 0.711649 27.2085C0.137299 26.6967 0.064914 25.8371 0.542345 25.2722L0.565502 25.2456L20.2145 3.19245L3.90438 3.85879L3.86844 3.85974C3.11557 3.87143 2.46651 3.28216 2.41029 2.52758C2.35408 1.77298 2.91169 1.13432 3.66175 1.08461L3.69761 1.08275L23.3651 0.279258C24.1331 0.247882 24.8021 0.843897 24.8592 1.61047L26.3212 21.24Z" fill="#E9BA66" />
                                        </svg>
                                    </a>
                                </div>
                            </div> <?php 
                        } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>
<!-- End Our Culinary Expert slider  -->


<!-- Start Why choose us  -->
<?php if (!empty($why_choose)) { ?>
    <section class="sect_pad">
        <div class="container">
            <div class="row g-4 g-lg-5 align-items-center justify-content-between">
                <div class="col-lg-6">
                    <div class="row" data-aos="zoom-in">
                        <div class="col-lg-6 d-none d-lg-block">
                            <img class="img-fluid h-250 rounded-3 mb-3" src="<?php echo base_url(!empty($choose_images[2]->image) ? $choose_images[2]->image : 'dummyimage/300x250.png'); ?>" alt="img" />
                            <img class="img-fluid h-250 rounded-3" src="<?php echo base_url(!empty($choose_images[1]->image) ? $choose_images[1]->image : 'dummyimage/300x250.png'); ?>" alt="img" />
                        </div>
                        <div class="col-lg-6">
                            <img class="img-fluid h-100 rounded-3" src="<?php echo base_url(!empty($choose_images[0]->image) ? $choose_images[0]->image : 'dummyimage/324x516.png'); ?>" alt="img" />
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <p class="font_prata fs-18 text_primary mb-3" data-aos="fade-down" data-aos-delay="100"><?php echo $why_choose->widget_name; ?></p>
                    <h2 class="main_title mb-4" data-aos="fade-down" data-aos-delay="150"><?php echo $why_choose->widget_title; ?></h2>
                    <?php
                    $desc = $why_choose->widget_desc;
                    $dom = new DOMDocument();
                    libxml_use_internal_errors(true);
                    $dom->loadHTML('<div>'.$desc.'</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
                    libxml_clear_errors();

                    foreach ($dom->documentElement->childNodes as $node) {
                        if ($node->nodeName === 'p') {
                            // Handle <p>
                            echo '<p class="mb-4" data-aos="fade-down" data-aos-delay="200">'
                                . htmlspecialchars($node->textContent)
                                . '</p>';
                        }

                        if ($node->nodeName === 'ul') {
                            echo '<ul class="list-unstyled mb-4 fs-16" data-aos="fade-down" data-aos-delay="250">';
                            foreach ($node->getElementsByTagName('li') as $li) {
                                echo '<li class="mb-3">
                                        <svg width="23" height="23" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M21.3954 11.4993C21.3953 6.05865 16.9406 1.60392 11.5 1.60392C6.05939 1.60392 1.60466 6.05865 1.60465 11.4993C1.60465 16.9399 6.05938 21.3946 11.5 21.3946C16.9406 21.3946 21.3954 16.9399 21.3954 11.4993ZM23 11.4993C23 17.8261 17.8268 22.9993 11.5 22.9993C5.17316 22.9993 0 17.8261 0 11.4993C5.47513e-06 5.17243 5.17316 -0.000726949 11.5 -0.000732422C17.8268 -0.000732422 23 5.17243 23 11.4993Z" fill="#292D32" />
                                            <path d="M15.5921 8.24418C15.9146 7.91722 16.437 7.91769 16.7589 8.24523C17.0808 8.57278 17.0803 9.10337 16.7578 9.43034L10.5208 15.7543C10.1986 16.0811 9.67661 16.0809 9.35463 15.7538L6.24164 12.5918L6.22678 12.5763C5.91953 12.248 5.92448 11.7288 6.24164 11.4067C6.55879 11.0845 7.06991 11.0795 7.39312 11.3916L7.40837 11.4067L9.93851 13.9767L15.5921 8.24418Z" fill="#C09342" />
                                        </svg>
                                        <span>' . htmlspecialchars($li->textContent) . '</span>
                                    </li>';
                            }
                            echo '</ul>';
                        }
                    }
                    ?>

                    <div class="d-flex flex-wrap justify-content-center justify-content-lg-start align-items-center gap-3" data-aos="fade-down" data-aos-delay="250">
                        <a href="<?php echo base_url('reservation'); ?>" class="btn btn_primary"><?php echo display('reservation') ?></a>
                        <a href="<?php echo base_url('menu'); ?>" class="btn btn_primary_outline text-black"><?php echo display('open_menu') ?></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>
<!-- End Why choose us  -->

<!-- Start Map  -->
<section class="sect_pad bg_soft_primary">
    <div class="container">
        <div class="row g-4 g-lg-5 align-items-center justify-content-between">
            <div class="col-lg-6">
                <?php if (!empty($visit_text)) { ?>
                <h2 class="sec_title mb-4" data-aos="fade-down" data-aos-delay="100">
                    <?php echo $visit_text->widget_title; ?>
                </h2>
                <p class="mb-4" data-aos="fade-down" data-aos-delay="150">
                    <?php echo $visit_text->widget_desc; ?>
                </p>
                <?php } ?>
        
                <?php if (!empty($opening_hours)) { ?>
                <p class="font_prata fs-20 text_primary mb-4" data-aos="fade-down" data-aos-delay="200"><?php echo $opening_hours->widget_title; ?></p>
                <div  data-aos="fade-down" data-aos-delay="200">
                    <?php echo $opening_hours->widget_desc; ?>
                </div>
                <?php } ?>
                
                <div class="d-flex flex-wrap align-items-center gap-3 mt-4" data-aos="fade-down" data-aos-delay="200">
                    <a href="#book-table" class="btn btn_primary"><?php echo display('book_a_table') ?></a>
                    <div class="d-flex align-items-center gap-2">
                        <svg width="16" height="18" viewBox="0 0 16 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                            d="M4.54256 0.632454C4.54256 0.632454 4.27422 0 3.8644 0C3.46109 0 3.2513 0.187364 3.11144 0.316636C2.97158 0.445909 0.63139 2.38091 0.63139 2.38091C0.63139 2.38091 -0.0492012 2.979 0.00283922 4.104C0.0467483 5.229 0.265481 6.83018 1.40061 9.06054C2.52761 11.286 5.34837 14.6864 7.13075 15.8817C7.13075 15.8817 8.78222 17.1565 10.319 17.6744C10.7655 17.8159 11.6583 18 11.8664 18C12.0778 18 12.4511 18 12.8796 17.685C13.3154 17.3667 15.7605 15.3884 15.7605 15.3884C15.7605 15.3884 16.359 14.8443 15.6638 14.2118C14.9653 13.5794 12.8446 12.1729 12.3909 11.8031C11.9364 11.4275 11.2891 11.5928 11.0094 11.8473C10.7305 12.1034 10.232 12.5247 10.1711 12.5779C10.08 12.6483 9.83035 12.8765 9.55063 12.7628C9.19448 12.6213 7.7341 11.8235 6.38023 9.95973C5.0345 8.09755 4.88651 7.48882 4.68567 6.831C4.6516 6.73376 4.65113 6.62779 4.68433 6.53025C4.71753 6.4327 4.78246 6.34927 4.86862 6.29345C5.07028 6.15273 5.81267 5.53009 5.81267 5.53009C5.81267 5.53009 6.29323 5.05309 6.09239 4.491C5.89154 3.92891 4.54256 0.632454 4.54256 0.632454Z"
                            fill="#C09342"
                            />
                        </svg>
                        <span><?php echo $phone; ?></span>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <?php if (!empty($googlemap)) { ?>
                    <div class="border p-4 rounded-4 map_area" data-aos="zoom-in">
                        <?php echo htmlspecialchars_decode($googlemap->widget_desc);?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>
<!-- End Map  -->

<!-- Start Expert  -->
<?php if (!empty($team)) { ?>
    <section class="sect_pad">
        <div class="container">
            <div class="row g-4 g-lg-5 justify-content-center align-items-center mb-5">
                <div class="col-xl-8 col-md-10 text-center">
                    <p class="font_prata fs-20 text_primary" data-aos="fade-down" data-aos-delay="100"><?php echo $team->widget_name; ?></p>
                    <h2 class="main_title" data-aos="fade-down" data-aos-delay="150"><?php echo $team->widget_title; ?></h2>
                </div>
            </div>
            <div class="row g-4 g-lg-5">
                <?php 
                foreach ($ourteam as $index => $team) { if ($index >= 4) break; ?>
                    <div class="col-md-6 col-xl-3 text-center" data-aos="fade-down" data-aos-delay="<?php echo 100 + ($index * 50) ?>">
                        <div class="bg_deep_primary rounded-5 p-4 pb-0 mb-4 expert-img">
                            <img class="img-fluid" src="<?php echo base_url(!empty($team->picture) ? $team->picture : 'dummyimage/363x363.jpg'); ?>" alt="">
                        </div>
                        <h3 class="font_prata fs-22 mb-1"><?php echo $team->first_name . ' ' . $team->last_name; ?></h3>
                        <p class="font_prata fs-16 text_primary"><?php echo $team->custom_field; ?></p>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
<?php } ?>
<!-- End Expert  -->
