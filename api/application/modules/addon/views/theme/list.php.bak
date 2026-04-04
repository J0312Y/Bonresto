<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<link href="<?php echo base_url('application/modules/addon/assets/css/style.css'); ?>" rel="stylesheet" type="text/css"/>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-bd">
            <div class="panel-heading">
                <div class="panel-title box-header">
                    <h4><?php echo display('manage_themes') ?></h4>
                </div>
            </div>
            <div class="panel-body">
                <?php $this->load->view('template/includes/messages'); ?>

                <div class="row themediv">
                    <?php
                    $i = 0;
                    foreach ($themes as $single_theme) {
                        $i++; ?>
                        <div class="col-md-4 themebox  theme_<?php echo $single_theme->themename ?>">
                            <div class="card_item">
                                <div class="border-box pnav" id="pnav">
                                    <div class="img_part">
                                        <img class="img-fluid img-thumbnail" src="<?php echo base_url() . 'application/views/themes/' . html_escape($single_theme->themename) . '/preview.png'; ?>"  alt="<?php echo html_escape($single_theme->themename); ?>">
                                        <?php
                                        if (@$active_theme == $single_theme->themename) {?>
                                            <a href="<?php echo base_url() ?>" target='__blank' class="btn btn-dtls"><?php echo display('show_theme'); ?></a>
                                        <?php } else {?>
                                            <a href="<?php echo base_url('addon/theme/active_theme/' . html_escape($single_theme->themename)) ?>" target='__blank' class="btn btn-dtls"><?php echo display('active') ?></a>
                                        <?php } ?>
                                    </div>
                                </div>

                                <div class="caption_part" >
                                    <h4><?php echo ucwords(str_replace('_', ' ', $single_theme->themename)); ?></h4>


                                    <div class="caption_btn <?php echo((@$active_theme == $single_theme->themename) ? 'activated' : ''); ?>">
                                        <?php
                                        if (@$active_theme !== $single_theme->themename) {?>
                                        <a href="<?php echo base_url('addon/theme/active_theme/' . html_escape($single_theme->themename)) ?>" class="btn btn-success"><?php echo display('active') ?></a>
                                        <button data_id="<?php echo $single_theme->themename; ?>"  class="btn btn-danger delete_item"><?php echo display("delete") ?></button>
                                        <?php } else {?>
                                        <a href="<?php echo base_url() ?>" target='__blank' class="btn btn-success"><?php echo display('activated'); ?></a>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div> <?php
                    } 
                    
                    if ($i == 0) {?>
                        <div class="col-md-12 text-center">
                            <h3><?php echo display('no_theme_available') ?></h3>
                        </div> <?php 
                    } ?>
                </div>
            </div>
        </div>

        <!-- New Section -->
        <?php 
        if (isset($active_theme) && $active_theme == 'exclusive') { ?>
        
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="panel-title box-header">
                                <h4><?php echo display('manage_color') ?></h4>
                            </div>
                        </div>

                        <div class="panel-body">
                            <form class="form-horizontal" action="<?php echo base_url('addon/theme/save_colors'); ?>" method="post">

                                <!-- CSRF token -->
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" 
                                    value="<?php echo $this->security->get_csrf_hash(); ?>">

                                <!-- Theme Name -->
                                <input type="hidden" name="themename" value="exclusive">
                                
                                <div class="row">
                                    <!-- Primary Color -->
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label" for="primaryColor"><?php echo display('primary_color'); ?></label>
                                            <div class="col-sm-3">
                                                <input type="color" class="form-control" id="primaryColor" name="primary_color"
                                                    value="<?php echo !empty($theme->primary_color) ? $theme->primary_color : '#c09342'; ?>">
                                            </div>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" id="primaryColorCode"
                                                value="<?php echo !empty($theme->primary_color) ? $theme->primary_color : '#c09342'; ?>" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Top Header Background Color -->
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label" for="topHeaderBackgroundColor"><?php echo display('top_header_bg'); ?></label>
                                            <div class="col-sm-4">
                                                <input type="color" class="form-control" id="topHeaderBackgroundColor" name="top_header_bg" 
                                                    value="<?php echo !empty($theme->top_header_bg) ? $theme->top_header_bg : '#112a2a'; ?>">
                                            </div>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" id="topHeaderBackgroundColorCode"
                                                value="<?php echo !empty($theme->top_header_bg) ? $theme->top_header_bg : '#112a2a'; ?>" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Header Background Color -->
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label" for="headerBackgroundColor"><?php echo display('header_bg'); ?></label>
                                            <div class="col-sm-3">
                                                <input type="color" class="form-control" id="headerBackgroundColor" name="header_bg" 
                                                    value="<?php echo !empty($theme->header_bg) ? $theme->header_bg : '#1f3433'; ?>">
                                            </div>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" id="headerBackgroundColorCode" 
                                                    value="<?php echo !empty($theme->header_bg) ? $theme->header_bg : '#1f3433'; ?>" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Header Text Color -->
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label" for="headerTextColor"><?php echo display('header_text_color'); ?></label>
                                            <div class="col-sm-4">
                                                <input type="color" class="form-control" id="headerTextColor" name="header_color" 
                                                    value="<?php echo !empty($theme->header_color) ? $theme->header_color : '#ffffff'; ?>">
                                            </div>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" id="headerTextColorCode" 
                                                    value="<?php echo !empty($theme->header_color) ? $theme->header_color : '#ffffff'; ?>" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Footer Background Color -->
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label" for="footerBackgroundColor"><?php echo display('footer_bg'); ?></label>
                                            <div class="col-sm-3">
                                                <input type="color" class="form-control" id="footerBackgroundColor" name="footer_bg" 
                                                    value="<?php echo !empty($theme->footer_bg) ? $theme->footer_bg : '#081d1c'; ?>">
                                            </div>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" id="footerBackgroundColorCode" 
                                                    value="<?php echo !empty($theme->footer_bg) ? $theme->footer_bg : '#081d1c'; ?>" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Footer Text Color -->
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label" for="footerTextColor"><?php echo display('footer_text_color'); ?></label>
                                            <div class="col-sm-4">
                                                <input type="color" class="form-control" id="footerTextColor" name="footer_color" 
                                                    value="<?php echo !empty($theme->footer_color) ? $theme->footer_color : '#ffffff'; ?>">
                                            </div>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" id="footerTextColorCode" 
                                                    value="<?php echo !empty($theme->footer_color) ? $theme->footer_color : '#ffffff'; ?>" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit Buttons -->
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="button" class="btn btn-default" id="resetColors"><?php echo display('reset_default') ?></button>
                                        <button type="submit" class="btn btn-success"><?php echo display('save') ?></button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div> <!-- /.panel -->
                </div>
            </div>
        <?php } ?>
        <!-- End New Section -->

    </div>
</div>
<script src="<?php echo base_url() . 'application/modules/addon/assets/ajaxs/addons/theme.js' ?>"></script>
