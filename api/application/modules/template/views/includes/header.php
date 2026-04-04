<a href="<?php echo base_url('dashboard/home') ?>" class="logo">
    <span class="logo-lg">
        <img src="<?php echo base_url((!empty($setting->logo) ? $setting->logo : 'assets/img/icons/mini-logo.png')) ?>"
            alt="">
    </span>
</a>
<style>
    @keyframes anim_opa {
        50% {
            opacity: 0.2
        }
    }

    .navbar-nav li .lang_box {
        line-height: 36px;
        color: #374767;
    }

    .navbar-nav li .lang_options {
        min-width: 90px;
    }
</style>
<?php
(int) $new_version = @file_get_contents('https://update.bdtask.com/bhojon/autoupdate/update_info');
$myversion         = current_version();
function current_version()
{

    //Current Version
    $product_version = '';
    $path            = FCPATH . 'system/core/compat/lic.php';

    if (file_exists($path)) {

        // Open the file
        $whitefile = file_get_contents($path);

        $file                = fopen($path, "r");
        $i                   = 0;
        $product_version_tmp = [];
        $product_key_tmp     = [];

        while (!feof($file)) {
            $line_of_text = fgets($file);

            if (strstr($line_of_text, 'product_version') && $i == 0) {
                $product_version_tmp = explode('=', strstr($line_of_text, 'product_version'));
                $i++;
            }
        }

        fclose($file);

        $product_version = trim(@$product_version_tmp[1]);
        $product_version = ltrim(@$product_version, '\'');
        $product_version = rtrim(@$product_version, '\';');

        return @$product_version;
    } else {
        //file is not exists
        return false;
    }
}

?>
<!-- Header Navbar -->
<nav class="navbar navbar-static-top">
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <!-- Sidebar toggle button-->
        <span class="sr-only">Toggle navigation</span>
        <span class="pe-7s-keypad"></span>
    </a>
    <div class="sidebar-link">
        <span class="top-fixed-link">
            <?php
            if ($this->permission->method('itemmanage', 'create')->access()) {
                if (($title == 'Home') || (@$title2 == 'dashboard')) {
            ?>
                    <a href="<?php echo base_url("ordermanage/order/pos_invoice") ?>"
                        class="btn custom_btn_in_header text-green">
                        <svg width="22" height="20" viewBox="0 0 22 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M20.6155 18.9191H1.37477C0.61677 18.9191 0.000305176 18.3027 0.000305176 17.5447V6.46361C0.000305176 5.70561 0.61677 5.08914 1.37477 5.08914H13.519C13.7626 5.08914 13.9604 5.28688 13.9604 5.53052V6.68195H18.4036V5.53052C18.4036 5.28688 18.6014 5.08914 18.845 5.08914H20.6155C21.3735 5.08914 21.99 5.70561 21.99 6.46361V17.5447C21.99 18.3027 21.3735 18.9191 20.6155 18.9191ZM1.37477 5.97191C1.10376 5.97191 0.883071 6.1926 0.883071 6.46361V17.5447C0.883071 17.8157 1.10376 18.0364 1.37477 18.0364H20.6155C20.8865 18.0364 21.1072 17.8157 21.1072 17.5447V6.46361C21.1072 6.1926 20.8865 5.97191 20.6155 5.97191H19.2864V7.12333C19.2864 7.36697 19.0886 7.56471 18.845 7.56471H13.519C13.2753 7.56471 13.0776 7.36697 13.0776 7.12333V5.97191H1.37477Z"
                                fill="#00A653" />
                            <path
                                d="M10.642 16.0943H3.4622C3.21855 16.0943 3.02081 15.8965 3.02081 15.6529V8.35535C3.02081 8.11171 3.21855 7.91397 3.4622 7.91397H10.642C10.8857 7.91397 11.0834 8.11171 11.0834 8.35535V15.6529C11.0834 15.8965 10.8857 16.0943 10.642 16.0943ZM3.90358 15.2115H10.2006V8.79674H3.90358V15.2115Z"
                                fill="#00A653" />
                            <path
                                d="M10.642 3.67643H3.4622C3.21855 3.67643 3.02081 3.47869 3.02081 3.23504V0.441383C3.02081 0.19774 3.21855 0 3.4622 0H10.642C10.8857 0 11.0834 0.19774 11.0834 0.441383V3.23504C11.0834 3.47869 10.8857 3.67643 10.642 3.67643ZM3.90358 2.79366H10.2006V0.882766H3.90358V2.79366Z"
                                fill="#00A653" />
                            <path
                                d="M7.9496 5.9719H6.15464C5.911 5.9719 5.71326 5.77416 5.71326 5.53052V3.23533C5.71326 2.99168 5.911 2.79395 6.15464 2.79395H7.9496C8.19324 2.79395 8.39098 2.99168 8.39098 3.23533V5.53052C8.39098 5.77416 8.19324 5.9719 7.9496 5.9719ZM6.59602 5.08914H7.50821V3.67671H6.59602V5.08914Z"
                                fill="#00A653" />
                            <path
                                d="M13.9601 10.0768C13.7223 10.0768 13.5263 9.88786 13.5193 9.64863C13.5119 9.40499 13.7035 9.20166 13.9471 9.1943L14.9293 9.16488C14.9338 9.16488 14.9385 9.16458 14.9429 9.16458C15.1806 9.16458 15.3766 9.35349 15.3837 9.59272C15.391 9.83637 15.1995 10.0397 14.9558 10.0471L13.9736 10.0765C13.9692 10.0768 13.9645 10.0768 13.9601 10.0768Z"
                                fill="#00A653" />
                            <path
                                d="M17.4211 10.0621C17.1833 10.0621 16.9874 9.87315 16.98 9.63392C16.9726 9.39028 17.1642 9.18695 17.4078 9.17959L18.3901 9.15017C18.3945 9.15017 18.3992 9.14987 18.4036 9.14987C18.6414 9.14987 18.8373 9.33878 18.8444 9.57801C18.8518 9.82166 18.6602 10.025 18.4166 10.0323L17.4343 10.0618C17.4302 10.0621 17.4255 10.0621 17.4211 10.0621Z"
                                fill="#00A653" />
                            <path
                                d="M13.9601 12.4676C13.7223 12.4676 13.5263 12.2787 13.5193 12.0395C13.5119 11.7958 13.7035 11.5925 13.9471 11.5851L14.9293 11.5557C14.9338 11.5557 14.9385 11.5554 14.9429 11.5554C15.1806 11.5554 15.3766 11.7443 15.3837 11.9836C15.391 12.2272 15.1995 12.4305 14.9558 12.4379L13.9736 12.4673C13.9692 12.4676 13.9645 12.4676 13.9601 12.4676Z"
                                fill="#00A653" />
                            <path
                                d="M17.4211 12.4529C17.1833 12.4529 16.9874 12.264 16.98 12.0247C16.9726 11.7811 17.1642 11.5778 17.4078 11.5704L18.3901 11.541C18.3945 11.541 18.3992 11.5407 18.4036 11.5407C18.6414 11.5407 18.8373 11.7296 18.8444 11.9688C18.8518 12.2125 18.6602 12.4158 18.4166 12.4232L17.4343 12.4526C17.4302 12.4529 17.4255 12.4529 17.4211 12.4529Z"
                                fill="#00A653" />
                            <path
                                d="M13.9601 14.8584C13.7223 14.8584 13.5263 14.6695 13.5193 14.4303C13.5119 14.1866 13.7035 13.9833 13.9471 13.9759L14.9293 13.9465C14.9338 13.9465 14.9385 13.9462 14.9429 13.9462C15.1806 13.9462 15.3766 14.1351 15.3837 14.3744C15.391 14.618 15.1995 14.8213 14.9558 14.8287L13.9736 14.8581C13.9692 14.8584 13.9645 14.8584 13.9601 14.8584Z"
                                fill="#00A653" />
                            <path
                                d="M17.4211 14.8437C17.1833 14.8437 16.9874 14.6548 16.98 14.4156C16.9726 14.1719 17.1642 13.9686 17.4078 13.9612L18.3901 13.9318C18.3945 13.9318 18.3992 13.9315 18.4036 13.9315C18.6414 13.9315 18.8373 14.1204 18.8444 14.3597C18.8518 14.6033 18.6602 14.8066 18.4166 14.814L17.4343 14.8434C17.4302 14.8437 17.4255 14.8437 17.4211 14.8437Z"
                                fill="#00A653" />
                            <path
                                d="M18.845 7.56473H13.519C13.2753 7.56473 13.0776 7.36699 13.0776 7.12335V1.94445C13.0776 1.77938 13.1697 1.62842 13.3159 1.55251C13.4622 1.47659 13.639 1.48895 13.7738 1.58399L14.8505 2.34552L15.9271 1.58399C16.0799 1.476 16.2841 1.476 16.4368 1.58399L17.5135 2.34552L18.5902 1.58399C18.7249 1.48865 18.9015 1.47659 19.048 1.55251C19.1946 1.62842 19.2864 1.77967 19.2864 1.94445V7.12335C19.2864 7.36699 19.0886 7.56473 18.845 7.56473ZM13.9603 6.68196H18.4036V2.79721L17.7683 3.24653C17.6156 3.35453 17.4114 3.35453 17.2586 3.24653L16.182 2.485L15.1053 3.24653C14.9526 3.35453 14.7484 3.35453 14.5956 3.24653L13.9603 2.79721V6.68196Z"
                                fill="#00A653" />
                            <path
                                d="M18.3221 21.2146H3.66819C3.42455 21.2146 3.22681 21.0169 3.22681 20.7732V18.4777C3.22681 18.2341 3.42455 18.0363 3.66819 18.0363H18.3221C18.5657 18.0363 18.7635 18.2341 18.7635 18.4777V20.7732C18.7635 21.0169 18.5657 21.2146 18.3221 21.2146ZM4.10957 20.3318H17.8807V18.9191H4.10957V20.3318Z"
                                fill="#00A653" />
                            <path
                                d="M21.5486 23.8038H0.441383C0.19774 23.8038 0 23.606 0 23.3624V20.773C0 20.5293 0.19774 20.3316 0.441383 20.3316H21.5486C21.7923 20.3316 21.99 20.5293 21.99 20.773V23.3624C21.99 23.606 21.7923 23.8038 21.5486 23.8038ZM0.882766 22.921H21.1072V21.2143H0.882766V22.921Z"
                                fill="#00A653" />
                        </svg>
                        <span><?php echo display('pos_invoice') ?></span>
                    </a>
                    <a href="<?php echo base_url("ordermanage/order/orderlist") ?>"
                        class="btn custom_btn_in_header text-orange">
                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M16.2727 8.99999V4.2C16.2727 2.43269 14.8823 1 13.1673 1H4.10544C2.39035 1 1 2.43268 1 4.2V13.8C1 15.5673 2.39035 17 4.10544 17H8.63636"
                                stroke="#FF5627" stroke-width="1.5" stroke-linecap="round" />
                            <path d="M4.63635 9H6.81817" stroke="#FF5627" stroke-width="1.5" stroke-linecap="round" />
                            <path d="M4.63635 5.36365H9.72726" stroke="#FF5627" stroke-width="1.5" stroke-linecap="round" />
                            <path
                                d="M16.1602 12.2731L14.6815 10.5831C14.5316 10.4117 14.2884 10.4117 14.1384 10.5831L11.2943 13.8335C11.212 13.9276 11.1715 14.0593 11.1841 14.1916L11.3467 15.89C11.3566 15.9923 11.4272 16.0731 11.5167 16.0843L13.0028 16.2701C13.1186 16.2846 13.2338 16.2383 13.3162 16.1443L16.1602 12.8938C16.3102 12.7224 16.3102 12.4445 16.1602 12.2731Z"
                                stroke="#FF5627" stroke-width="1.5" stroke-linecap="round" />
                        </svg>

                        <span><?php echo display('order_list') ?></span>
                    </a>
                    <a href="<?php echo base_url("ordermanage/order/allkitchen") ?>"
                        class="btn custom_btn_in_header text-violet">
                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M16.2727 16L16.2727 4.2C16.2727 2.43269 14.8823 1 13.1673 1H4.10544C2.39035 1 1 2.43268 1 4.2V13.8C1 15.5673 2.39035 17 4.10544 17H16.2727"
                                stroke="#9052F5" stroke-width="1.5" stroke-linecap="round" />
                            <path d="M4.63635 9H6.81817" stroke="#9052F5" stroke-width="1.5" stroke-linecap="round" />
                            <path d="M5 12H10" stroke="#9052F5" stroke-width="1.5" stroke-linecap="round" />
                            <path d="M4.63635 5.36365H9.72726" stroke="#9052F5" stroke-width="1.5" stroke-linecap="round" />
                        </svg>

                        <span><?php echo display('kitchen_dashboard') ?></span>
                    </a>
                    <a href="<?php echo base_url("ordermanage/order/counterboard") ?>"
                        class="btn custom_btn_in_header text-blue">
                        <svg width="16" height="15" viewBox="0 0 16 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="6.70833" height="6.70833" rx="1.5" fill="#2972FF" />
                            <path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd"
                                d="M8.625 1.5C8.625 0.671574 9.29657 0 10.125 0H13.8333C14.6618 0 15.3333 0.671573 15.3333 1.5V5.20833C15.3333 6.03676 14.6618 6.70833 13.8333 6.70833H10.125C9.29657 6.70833 8.625 6.03676 8.625 5.20833V1.5ZM0 9.5C0 8.67157 0.671573 8 1.5 8H5.20833C6.03676 8 6.70833 8.67157 6.70833 9.5V13.2083C6.70833 14.0368 6.03676 14.7083 5.20833 14.7083H1.5C0.671574 14.7083 0 14.0368 0 13.2083V9.5ZM10.5 8C9.67157 8 9 8.67157 9 9.5V13.2083C9 14.0368 9.67157 14.7083 10.5 14.7083H14.2083C15.0368 14.7083 15.7083 14.0368 15.7083 13.2083V9.5C15.7083 8.67157 15.0368 8 14.2083 8H10.5Z"
                                fill="#2972FF" />
                        </svg>

                        <span><?php echo display('counter_dashboard') ?></span>
                    </a>
            <?php
                }
            }

            ?>
        </span>
    </div>
    <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
            <!-- Order Alert -->
            <?php

            if ((float) $new_version > $myversion) {

                if ($versioncheck->version != (float) $new_version) { ?><li><a href="<?php echo base_url("dashboard/autoupdate") ?>"
                            style="display: flex;align-items: center;background: #f81111;padding: 0 10px;margin-top: 12px;color: #fff;animation-name: anim_opa; animation-duration: 0.8s; animation-iteration-count: infinite;"><i
                                class="fa fa-warning" style="background: transparent; border: 0; color: #fff;"></i><span
                                style="font-size: 16px;font-weight: 600;">Update Available</span></a></li><?php }
                                                                                                    }

                                                                                                            ?>
            <li><a id="fullscreen" href="#" class="getid1"><i class="pe-7s-expand1 bg-soft-blue"></i></a></li>
            <li class="dropdown messages-menu">

                <a href="<?php echo base_url("reservation/reservation") ?>" class="dropdown-toggle">
                    <i class="fa fa-bell-o bg-soft-green"></i>
                    <span class="label label-success reservenotif">0</span>
                </a>
                <input name="csrfres" id="csrfresarvation" type="hidden"
                    value="<?php echo $this->security->get_csrf_token_name(); ?>" />
                <input name="csrfhash" id="csrfhashresarvation" type="hidden"
                    value="<?php echo $this->security->get_csrf_hash(); ?>" />
            </li>
            <!-- Messages -->

            <!-- settings -->
            <li class="dropdown dropdown-user">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i
                        class="pe-7s-settings bg-soft-red"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo base_url('dashboard/home/profile') ?>"><i class="pe-7s-users"></i>
                            <?php echo display('profile') ?></a></li>
                    <li><a href="<?php echo base_url('dashboard/home/setting') ?>"><i class="pe-7s-settings"></i>
                            <?php echo display('setting') ?></a></li>
                    <li><a href="<?php echo base_url('logout') ?>"><i class="pe-7s-key"></i>
                            <?php echo display('logout') ?></a></li>
                    <?php $languagenames = $this->db->field_data('language');

                    ?>
                </ul>
            </li>
            <li class="dropdown dropdown-user">
                <a href="#" class="dropdown-toggle lang_box" data-toggle="dropdown"> <?php

                                                                                        if ($this->session->has_userdata('language')) {
                                                                                            echo mb_strimwidth(strtoupper($this->session->userdata('language')), 0, 3, '');
                                                                                        } else {
                                                                                            echo mb_strimwidth(strtoupper($setting->language), 0, 3, '');
                                                                                        }

                                                                                        ?></a>
                <ul class="dropdown-menu lang_options">
                    <?php
                    $lii = 0;

                    foreach ($languagenames as $languagename) {

                        if ($lii >= 2) {
                    ?>
                            <li><a href="javascript:;" onclick="addlang(this)"
                                    data-url="<?php echo base_url(); ?>hungry/setlangue/<?php echo $languagename->name; ?>">
                                    <?php echo ucfirst($languagename->name); ?></a></li>
                    <?php
                        }

                        $lii++;
                    }

                    ?>
                </ul>
            </li>
        </ul>
    </div>
</nav>

<div class="mobile-sidebar-link">
    <span class="top-fixed-link">
        <?php

        if ($this->permission->method('itemmanage', 'create')->access()) {

            if (($title == 'Home') || (@$title2 == 'dashboard')) {
        ?>
                <a href="<?php echo base_url("ordermanage/order/pos_invoice") ?>"
                    class="btn btn-success custom_btn_in_header"><i class="fa fa-plus"></i>
                    <?php echo display('pos_invoice') ?></a>
                <a href="<?php echo base_url("ordermanage/order/orderlist") ?>" class="btn btn-success custom_btn_in_header"><i
                        class="fa fa-list"></i> <?php echo display('order_list') ?></a>
                <a href="<?php echo base_url("ordermanage/order/allkitchen") ?>" class="btn btn-success custom_btn_in_header"><i
                        class="fa fa-user-o" aria-hidden="true"></i> <?php echo display('kitchen_dashboard') ?></a>
                <a href="<?php echo base_url("ordermanage/order/counterboard") ?>"
                    class="btn btn-success custom_btn_in_header"><i class="fa fa-th"></i>
                    <?php echo display('counter_dashboard') ?></a>
        <?php
            }
        }

        ?>
    </span>
</div>