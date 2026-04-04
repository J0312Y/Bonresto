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
                foreach ($ourteam as $index => $team) { ?>
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
