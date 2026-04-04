<div class="bg-swamp header-content-top">
    <div class="container">
        <div class="d-flex flex-column flex-md-row gap-3 justify-content-between align-items-center">
            <?php if (!empty($footeraddress)) { ?>
                <div class="d-none d-lg-flex align-items-center w-100 gap-2">
                    <svg class="type-one" width="21" height="22" viewBox="0 0 21 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6.9375 9.88889C6.9375 11.7299 8.53243 13.2222 10.5 13.2222C12.4676 13.2222 14.0625 11.7299 14.0625 9.88889C14.0625 8.04794 12.4676 6.55556 10.5 6.55556M10.5 21C5.25329 18.7778 1 14.7981 1 9.88889C1 4.97969 5.25329 1 10.5 1C15.7467 1 20 4.97969 20 9.88889C20 13.1614 18.1099 16.021 15.2954 18.2222" stroke="#F2C94C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <span class="text-white font_prata fs-12"><?php echo $footeraddress->widget_desc; ?></span>
                </div>
            <?php } ?>

            <div class="d-flex justify-content-between justify-content-lg-end w-100 gap-2 gap-md-4 py-2">
                <div class="align-items-center d-flex">
                    <div class="d-block me-2">
                        <svg class="type-two" width="19" height="15" viewBox="0 0 19 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M18.6583 8.44468L16.25 5.94308L18.6583 3.86719V8.44468Z" fill="#C09342" />
                            <path d="M2.41122 5.94112L0 8.44565V3.86523L2.41122 5.94112Z" fill="#C09342" />
                            <path d="M18.66 10.7183V13.0216C18.66 13.5785 18.2081 14.0305 17.6512 14.0305H1.00881C0.451886 14.0305 0 13.5786 0 13.0216V10.7183L3.60659 6.97461L7.72641 10.5229C8.155 10.8903 8.72352 11.0944 9.33 11.0944C9.93649 11.0944 10.5079 10.8903 10.9365 10.5229L15.0533 6.97461L18.66 10.7183Z" fill="#C09342" />
                            <path d="M18.66 1.00589V2.0147L9.86057 9.59532C9.57776 9.84024 9.08214 9.84024 8.79932 9.59532L0 2.0147V1.00589C0 0.449043 0.451849 0 1.00881 0H17.6512C18.2081 0 18.66 0.449043 18.66 1.00589Z" fill="#C09342" />
                        </svg>
                    </div>
                    <span class="text-white responsive-fs-12 "><?php echo $webinfo->email; ?></span>
                </div>
                <div class="align-items-center d-none d-lg-flex">
                    <div class="d-block me-2">
                        <svg class="type-two" width="16" height="18" viewBox="0 0 16 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                            d="M4.54256 0.632454C4.54256 0.632454 4.27422 0 3.8644 0C3.46109 0 3.2513 0.187364 3.11144 0.316636C2.97158 0.445909 0.63139 2.38091 0.63139 2.38091C0.63139 2.38091 -0.0492012 2.979 0.00283922 4.104C0.0467483 5.229 0.265481 6.83018 1.40061 9.06054C2.52761 11.286 5.34837 14.6864 7.13075 15.8817C7.13075 15.8817 8.78222 17.1565 10.319 17.6744C10.7655 17.8159 11.6583 18 11.8664 18C12.0778 18 12.4511 18 12.8796 17.685C13.3154 17.3667 15.7605 15.3884 15.7605 15.3884C15.7605 15.3884 16.359 14.8443 15.6638 14.2118C14.9653 13.5794 12.8446 12.1729 12.3909 11.8031C11.9364 11.4275 11.2891 11.5928 11.0094 11.8473C10.7305 12.1034 10.232 12.5247 10.1711 12.5779C10.08 12.6483 9.83035 12.8765 9.55063 12.7628C9.19448 12.6213 7.7341 11.8235 6.38023 9.95973C5.0345 8.09755 4.88651 7.48882 4.68567 6.831C4.6516 6.73376 4.65113 6.62779 4.68433 6.53025C4.71753 6.4327 4.78246 6.34927 4.86862 6.29345C5.07028 6.15273 5.81267 5.53009 5.81267 5.53009C5.81267 5.53009 6.29323 5.05309 6.09239 4.491C5.89154 3.92891 4.54256 0.632454 4.54256 0.632454Z"
                            fill="#C09342"
                            />
                        </svg>
                    </div>
                    <span class="text-white responsive-fs-12"><?php echo $webinfo->phone_optional; ?></span>
                </div>
                <div class="social-bookmark">
                    <ul class="d-flex gap-1 nav">
                        <?php
                        foreach ($this->sociallink as $slink) {
                            $icon = substr($slink->icon, 4); ?>
                            <li>
                                <a href="<?php echo $slink->socialurl; ?>" class="rounded-circle text-center text-white">
                                    <i class="fa <?php echo $icon; ?>"></i>
                                </a>
                            </li> <?php
                        } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>