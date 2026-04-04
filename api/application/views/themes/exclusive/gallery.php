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

<!-- Gallery Image start  -->
<div class="py_70 position-relative">
    <div class="container">
        <div class="grid-container">
            <?php 
            foreach ($gallery as $image) { ?>
                <div class="gallery-img-box">
                    <a data-fancybox="gallery" href="<?php echo base_url(!empty($image->image) ? $image->image : 'dummyimage/gallery-default.png'); ?>">
                    <img class="gallery-img-size" src="<?php echo base_url(!empty($image->image) ? $image->image : 'dummyimage/gallery-default.png'); ?>" alt="" />
                    </a>
                </div><?php 
            } ?>
        </div>
    </div>
</div>
<!-- Gallery Image end  -->

