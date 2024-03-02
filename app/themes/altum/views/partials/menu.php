<?php defined('ALTUMCODE') || die() ?>

<?php

use Altum\Routing\Router; ?>

<link rel="stylesheet" href="<?= ASSETS_FULL_URL . 'css/dashboard-styles.css' ?>">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>


<script>
    $(document).ready(function() {
        var qrStatVal = $('#qr_status').val();
        if (qrStatVal == 1) {
            console.log(qrStatVal);
            $('.remove-on-edit').css("display", "none");
            $('.cancel-btn').css("display", "block");
        } else {
            $('.remove-on-edit').css("display", "block");
            $('.cancel-btn').css("display", "none");
        }
    });
</script>

<header class="qrg-header-wrp <?= (Altum\Routing\Router::$controller_key == 'create') ? 'create-header-wrp' : '' ?>">
    <!-- <div class="container"> -->
    <div class="<?= (Altum\Routing\Router::$controller_key == 'create') ? 'container-fluid nlp-header-wrap' : 'container' ?>">

        <nav class="main-nav">
            <a href="<?= ((Router::$controller_key == 'create') || isset($_SESSION['new_landing'])) ? $_SESSION['new_landing_route'] : url() ?>">
                <div class="logo <?= (Altum\Routing\Router::$controller_key == 'create') ? 'create-logo' : '' ?>">
                    <?php if (settings()->main->{'logo_' . \Altum\ThemeStyle::get()} != '') : ?>
                        <!-- <img src="<?= ASSETS_FULL_URL . 'images/new-qr-logo.webp' ?>" class="dashboard_logo mt-0" alt="<?= l('qr_codes.accessibility.logo_alt') ?>" /> -->
                        <img src="<?= ASSETS_FULL_URL . 'images/new-qr-logo.webp' ?>" class="dashboard_logo mt-0" alt="<?= l('qr_codes.accessibility.logo_alt') ?>" />
                    <?php else : ?>
                        <?= settings()->main->title ?>
                    <?php endif ?>
                </div>
            </a>

            <!-- <div class="vr desktop ml-5"></div> -->

            <?php if (\Altum\Middlewares\Authentication::check()) : ?>
                <div class="jss1456 mobile d-none">
                    <div class="MuiPaper-root MuiStepper-root jss1470 MuiStepper-horizontal MuiPaper-elevation0 mbcenter">
                        <a class="MuiStep-root jss1471 MuiStep-horizontal" id="tab1">
                            <svg id="ms1" class="MuiSvgIcon-root jss1478 jss1480" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                <circle cx="12" cy="12" r="12"></circle>
                                <text class="jss1479" x="12" y="18" text-anchor="middle">1</text>
                            </svg>
                        </a>
                        <div class="MuiStepConnector-root mx-2 jss1483 MuiStepConnector-horizontal">
                            <span class="MuiStepConnector-line jss1484 MuiStepConnector-lineHorizontal"></span>
                        </div>
                        <div class="MuiStep-root jss1471 MuiStep-horizontal" id="tab2">
                            <svg id="ms2" class="MuiSvgIcon-root jss1478" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                <circle cx="12" cy="12" r="12"></circle>
                                <text class="jss1479" x="12" y="18" text-anchor="middle">2</text>
                            </svg>
                        </div>
                        <div class="MuiStepConnector-root jss1483 mx-2 MuiStepConnector-horizontal Mui-disabled">
                            <span class="MuiStepConnector-line jss1484 MuiStepConnector-lineHorizontal"></span>
                        </div>
                        <div class="MuiStep-root jss1471 MuiStep-horizontal " id="tab3">
                            <svg id="ms3" class="MuiSvgIcon-root jss1478" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                <circle cx="12" cy="12" r="12"></circle>
                                <text class="jss1479" x="12" y="18" text-anchor="middle">3</text>
                            </svg>
                        </div>
                    </div>

                </div>
            <?php endif ?>

            <?php if (\Altum\Middlewares\Authentication::check()) : ?>
                <?php if ((url(\Altum\Routing\Router::$original_request) != (url('contact'))) && (url(\Altum\Routing\Router::$original_request) != (url('faq'))) && (Router::$controller_key != "notfound") && (Router::$controller_key != "qr-download")) { ?>
                    <div class="jss1456 desktop steps-progress-wrp <?= (Router::$controller_key == "create") ? 'create-steps-progress-wrp' : '' ?>">
                        <?php if (Router::$controller_key == "create") : ?>
                            <div class="MuiPaper-root MuiStepper-root jss1470 MuiStepper-horizontal MuiPaper-elevation0 create-qr-progress-header-wrp">
                                <a class="MuiStep-root jss1471 MuiStep-horizontal step-1-wrp" id="tab1">
                                    <span class="MuiStepLabel-root MuiStepLabel-horizontal" style="cursor: default;">
                                        <span class="MuiStepLabel-iconContainer jss1472 progress-circle">
                                            <div class="jss1477 jss1480 circle-number">
                                                <!-- <svg id="s1" class="MuiSvgIcon-root jss1478 jss1480" focusable="false"
                                            viewBox="0 0 24 24" aria-hidden="true">
                                            <circle cx="12" cy="12" r="12"></circle>
                                            <text class="jss1479" x="12" y="18" text-anchor="middle">1</text>
                                            </svg> -->
                                                <div class="number-wrp">
                                                    <span id="s1" class="number">1</span>
                                                </div>
                                            </div>
                                        </span>
                                        <span class="MuiStepLabel-labelContainer progress-text">
                                            <span class="MuiTypography-root MuiStepLabel-label jss1473 MuiStepLabel-active jss1474 MuiTypography-body2 MuiTypography-displayBlock" id="tab1text"><?= l('qr_general.nav.funnel.step_1') ?></span>
                                        </span>
                                    </span>
                                </a>
                                <div class="MuiStepConnector-root jss1483 MuiStepConnector-horizontal step-1-line" id="tab1Line">
                                    <span class="MuiStepConnector-line jss1484 MuiStepConnector-lineHorizontal"></span>
                                </div>
                                <div class="MuiStep-root jss1471 MuiStep-horizontal step-2-wrp" id="tab2" style="cursor: pointer;">
                                    <span class="MuiStepLabel-root MuiStepLabel-horizontal" style="cursor: default;">
                                        <span class="MuiStepLabel-iconContainer jss1472 progress-circle">
                                            <div class="jss1477 circle-number">
                                                <!-- <svg id="s2" class="MuiSvgIcon-root jss1478" focusable="false" viewBox="0 0 24 24"
                                            aria-hidden="true">
                                            <circle cx="12" cy="12" r="12"></circle>
                                            <text class="jss1479" x="12" y="18" text-anchor="middle">2</text>
                                        </svg> -->
                                                <div class="number-wrp">
                                                    <span id="s2" class="number">2</span>
                                                </div>
                                            </div>
                                        </span>
                                        <span class="MuiStepLabel-labelContainer progress-text">
                                            <span class="MuiTypography-root MuiStepLabel-label jss1473 MuiTypography-body2 MuiTypography-displayBlock" id="tab2text"><?= l('qr_general.nav.funnel.step_2') ?></span>
                                        </span>
                                    </span>
                                </div>
                                <div class="MuiStepConnector-root jss1483 MuiStepConnector-horizontal step-2-line" id="tab2Line">
                                    <span class="MuiStepConnector-line jss1484 MuiStepConnector-lineHorizontal"></span>
                                </div>
                                <div class="MuiStep-root jss1471 MuiStep-horizontal step-3-wrp " id="tab3">
                                    <span class="MuiStepLabel-root MuiStepLabel-horizontal Mui-disabled" style="cursor: default;">
                                        <span class="MuiStepLabel-iconContainer jss1472 progress-circle">
                                            <div class="jss1477 circle-number">
                                                <!-- <svg id="s3" class="MuiSvgIcon-root jss1478" focusable="false" viewBox="0 0 24 24"
                                                    aria-hidden="true">
                                                    <circle cx="12" cy="12" r="12"></circle>
                                                    <text class="jss1479" x="12" y="18" text-anchor="middle">3</text>
                                                </svg> -->
                                                <div class="number-wrp">
                                                    <span id="s3" class="number">3</span>
                                                </div>
                                            </div>
                                        </span>
                                        <span class="MuiStepLabel-labelContainer progress-text">
                                            <span class="MuiTypography-root MuiStepLabel-label jss1473 MuiTypography-body2 MuiTypography-displayBlock" id="tab3text"><?= l('qr_general.nav.funnel.step_3') ?></span>
                                        </span>
                                    </span>
                                </div>
                                <div class="MuiStepConnector-root jss1483 MuiStepConnector-horizontal step-3-line" id="tab3Line">
                                    <span class="MuiStepConnector-line jss1484 MuiStepConnector-lineHorizontal"></span>
                                </div>
                                <div class="MuiStep-root jss1471 MuiStep-horizontal step-3-wrp " id="tab4">
                                    <span class="MuiStepLabel-root MuiStepLabel-horizontal Mui-disabled" style="cursor: default;">
                                        <span class="MuiStepLabel-iconContainer jss1472 progress-circle">
                                            <div class="jss1477 circle-number">
                                                <!-- <svg id="s3" class="MuiSvgIcon-root jss1478" focusable="false" viewBox="0 0 24 24"
                                                    aria-hidden="true">
                                                    <circle cx="12" cy="12" r="12"></circle>
                                                    <text class="jss1479" x="12" y="18" text-anchor="middle">3</text>
                                                </svg> -->
                                                <div class="number-wrp">
                                                    <span id="s4" class="number">4</span>
                                                </div>
                                            </div>
                                        </span>
                                        <span class="MuiStepLabel-labelContainer progress-text">
                                            <span class="MuiTypography-root MuiStepLabel-label jss1473 MuiTypography-body2 MuiTypography-displayBlock" id="tab4text"><?= l('qr_general.nav.funnel.step_4') ?></span>
                                        </span>
                                    </span>
                                </div>
                            </div>
                        <?php else : ?>
                            <div class="MuiPaper-root MuiStepper-root jss1470 MuiStepper-horizontal MuiPaper-elevation0">
                                <a class="MuiStep-root jss1471 MuiStep-horizontal step-1-wrp" id="tab1">
                                    <span class="MuiStepLabel-root MuiStepLabel-horizontal" style="cursor: default;">
                                        <span class="MuiStepLabel-iconContainer jss1472 progress-circle">
                                            <div class="jss1477 jss1480 circle-number">
                                                <!-- <svg id="s1" class="MuiSvgIcon-root jss1478 jss1480" focusable="false"
                                        viewBox="0 0 24 24" aria-hidden="true">
                                        <circle cx="12" cy="12" r="12"></circle>
                                        <text class="jss1479" x="12" y="18" text-anchor="middle">1</text>
                                         </svg> -->
                                                <div class="number-wrp">
                                                    <span id="s1" class="number">1</span>
                                                </div>
                                            </div>
                                        </span>
                                        <span class="MuiStepLabel-labelContainer progress-text">
                                            <span class="MuiTypography-root MuiStepLabel-label jss1473 MuiStepLabel-active jss1474 MuiTypography-body2 MuiTypography-displayBlock" id="tab1text"><?= l('qr_general.nav.type_of_qrCode') ?></span>
                                        </span>
                                    </span>
                                </a>
                                <div class="MuiStepConnector-root jss1483 MuiStepConnector-horizontal step-1-line" id="tab1Line">
                                    <span class="MuiStepConnector-line jss1484 MuiStepConnector-lineHorizontal"></span>
                                </div>
                                <div class="MuiStep-root jss1471 MuiStep-horizontal step-2-wrp" id="tab2" style="cursor: pointer;">
                                    <span class="MuiStepLabel-root MuiStepLabel-horizontal" style="cursor: default;">
                                        <span class="MuiStepLabel-iconContainer jss1472 progress-circle">
                                            <div class="jss1477 circle-number">
                                                <!-- <svg id="s2" class="MuiSvgIcon-root jss1478" focusable="false" viewBox="0 0 24 24"
                                        aria-hidden="true">
                                        <circle cx="12" cy="12" r="12"></circle>
                                        <text class="jss1479" x="12" y="18" text-anchor="middle">2</text>
                                    </svg> -->
                                                <div class="number-wrp">
                                                    <span id="s2" class="number">2</span>
                                                </div>
                                            </div>
                                        </span>
                                        <span class="MuiStepLabel-labelContainer progress-text">
                                            <span class="MuiTypography-root MuiStepLabel-label jss1473 MuiTypography-body2 MuiTypography-displayBlock" id="tab2text"><?= l('qr_general.nav.content') ?></span>
                                        </span>
                                    </span>
                                </div>
                                <div class="MuiStepConnector-root jss1483 MuiStepConnector-horizontal step-2-line" id="tab2Line">
                                    <span class="MuiStepConnector-line jss1484 MuiStepConnector-lineHorizontal"></span>
                                </div>
                                <div class="MuiStep-root jss1471 MuiStep-horizontal step-3-wrp " id="tab3">
                                    <span class="MuiStepLabel-root MuiStepLabel-horizontal Mui-disabled" style="cursor: default;">
                                        <span class="MuiStepLabel-iconContainer jss1472 progress-circle">
                                            <div class="jss1477 circle-number">
                                                <!-- <svg id="s3" class="MuiSvgIcon-root jss1478" focusable="false" viewBox="0 0 24 24"
                                                aria-hidden="true">
                                                <circle cx="12" cy="12" r="12"></circle>
                                                <text class="jss1479" x="12" y="18" text-anchor="middle">3</text>
                                            </svg> -->
                                                <div class="number-wrp">
                                                    <span id="s3" class="number">3</span>
                                                </div>
                                            </div>
                                        </span>
                                        <span class="MuiStepLabel-labelContainer progress-text">
                                            <span class="MuiTypography-root MuiStepLabel-label jss1473 MuiTypography-body2 MuiTypography-displayBlock" id="tab3text"><?= l('qr_general.nav.qr_design') ?></span>
                                        </span>
                                    </span>
                                </div>
                            </div>
                        <?php endif ?>
                    </div>
                <?php } ?>


            <?php endif ?>


            <div class="d-flex right-options-wrp">



                <!-- <div class="d-flex justify-content-center align-items-center"> -->


                <?php if (url(\Altum\Routing\Router::$original_request) == (url('contact')) || url(\Altum\Routing\Router::$original_request) == (url('privacy-policy')) || url(\Altum\Routing\Router::$original_request) == (url('terms-and-conditions'))) { ?>

                    <a href="<?= url('faq') ?>" class="-link-language">
                        <button type="button" id="help-button" class="help-button remove-on-edit" data-toggle="modal" data-target="#helpModal" data-target="#helpCarousel" data-slide-to="0" onclick="onModal()" style="display: none;">
                            <i class="icon-help"></i>
                        </button>
                    </a>

                <?php } else { ?>
                    <?php if (url(\Altum\Routing\Router::$original_request) != (url('faq')) && Router::$controller_key != "notfound" && Router::$controller_key != "qr-download") { ?>
                        <button type="button" class="help-button help-info-modal remove-on-edit" id="helpInfoModal" data-toggle="modal" data-target="#helpModal" data-target="#helpCarousel" data-slide-to="0" onclick="onModal()" style="display: none;">
                            <i class="icon-help"></i>
                        </button>
                        <?php if (!isset($_COOKIE['nsf_user_id'])) { ?>
                            <a href="<?= url('qr-codes') ?>" class="cancel-btn btn outline-btn" style="display: none;">
                                Cancel
                            </a>
                        <?php }  ?>
                    <?php } ?>
                <?php } ?>
                <?php if (Router::$controller_key != "notfound"  && !\Altum\Middlewares\Authentication::is_temp_user() && Router::$controller_key != "qr-download") { ?>
                    <div class="nav-links remove-on-edit ps-0" style="display: none;">
                        <div class="hamburger burgermenu hidemenu" onclick="openNav()" id="openMenu">
                            <div class="line1"></div>
                            <div class="line2"></div>
                            <div class="line3"></div>
                        </div>
                    </div>
                <?php } ?>
            </div>
    </div>

    </nav>
    </div>

</header>



<!-- change start 28/01/2023 by parrot-->
<div id="mySidenav" class="sidenav hidemenu">
    <div class="app-sidebar-title text-truncate qr d-none">
        <a href="<?= url() ?>">
            <div class="logo">
                <?php if (settings()->main->{'logo_' . \Altum\ThemeStyle::get()} != '') : ?>
                    <img src="<?= UPLOADS_FULL_URL . 'main/' . settings()->main->{'logo_' . \Altum\ThemeStyle::get()} ?>" class="img-fluid navbar-logo" alt="<?= l('qr_codes.accessibility.logo_alt') ?>" loading="lazy" />
                <?php else : ?>
                    <?= settings()->main->title ?>
                <?php endif ?>
            </div>
        </a>
    </div>


    <!-- <div class="app-sidebar"> -->
    <div class="app-sidebar-title text-truncate">
        <a href="<?= url() ?>">
            <?php if (settings()->main->{'logo_' . \Altum\ThemeStyle::get()} != '') : ?>
                <img src="<?= ASSETS_FULL_URL . 'images/new-qr-logo.webp' ?>" class="dashboard_logo mt-1" alt="<?= l('qr_codes.accessibility.logo_alt') ?>" />
            <?php else : ?>
                <?= settings()->main->title ?>
            <?php endif ?>
        </a>
    </div>

    <div class="overflow-auto customScrollbar flex-grow-1">
        <ul class="app-sidebar-links">
            <li class="<?= \Altum\Routing\Router::$controller == 'Qr' ? 'active' : null ?>">
                <a href="<?= url('qr/') ?>" class="create-qr-btn ps-4" <?= isset($this->user->plan_expiration_date) && new DateTime($this->user->plan_expiration_date) < new DateTime() ? 'data-toggle="modal" data-target="#upgradePopup"' : '' ?>>
                    <span class="icon-add-barcode grey"></span>
                    <?= l('qr_codes.create_qr_code') ?>

                </a>
            </li>

            <li class="<?= \Altum\Routing\Router::$controller == 'Dashboard' ? 'active' : null ?>">
                <a href="<?= url('analytics') ?>" class="ps-4">
                    <span class="icon-activity grey"></span>
                    <?= l('qr_codes.analytics') ?>
                </a>
            </li>
            <li class="<?= \Altum\Routing\Router::$controller == 'QrCodes' ? 'active' : null ?>">
                <a href="<?= url('qr-codes') ?>" class="ps-4">
                    <span class="icon-scan-barcode grey"></span>
                    <?= l('qr_codes.menu') ?>
                </a>
            </li>
            <li class="<?= \Altum\Routing\Router::$controller == 'Account' ? 'active' : null ?>">
                <a href="<?= url('account') ?>" class="ps-4">
                    <span class="icon-profile grey"></span>
                    <?= l('qr_codes.account.menu') ?>
                </a>
            </li>

            <li class="<?= \Altum\Routing\Router::$controller == 'Billing' ? 'active' : null ?>">

                <a href="<?= $this->user->plan_id == 'free' ||  new DateTime($this->user->plan_expiration_date) < new DateTime() ? url('plan') : url('billing') ?>" class="ps-4">
                    <span class="icon-wallet grey"></span>
                    <?= l('qr_codes.billing.menu') ?>
                </a>
            </li>

            <li class="d-none <?= \Altum\Routing\Router::$controller == 'Users' ? 'active' : null ?>">
                <a href="<?= url('users') ?>" class="ps-4">
                    <span class="icon-users grey"></span>
                    <?= l('qr_codes.users.menu') ?>
                </a>
            </li>

            <div class="contact_us w-100">
                <hr class="my-3  mx-auto sidebar-hr">
                <li>
                    <a href="<?= url('contact') ?>" class="ps-4">
                        <span class="icon-message grey"></span>
                        <?= l('qr_codes.contact.header') ?></a>
                </li>

                <li>
                    <a href="<?= url('faq') ?>" class="ps-4">
                        <span class="icon-message-question grey"></span>
                        <?= l('qr_codes.faq.title') ?></a>
                </li>
            </div>
            <hr class="my-3 mx-auto sidebar-hr">
        </ul>
        <ul class="app-sidebar-links mb-2">
            <li style="padding: 3px 0 2px">
                <a href="<?= url('logout') ?>" class="py-2 ps logout">
                    <span class="icon-sign-out grey"></span>
                    <?= l('qr_codes.dashboard.logout') ?>
                </a>
            </li>
        </ul>
        <div class="app-sidebar-footer dropdown mt-auto w-100 p-3 pb-3">


            <?php
            function ends($time)
            {
                return $time > 1 ? 's' : '';
            }

            $xp_countdown = "";
            $xp_time = explode(':', date_diff(new DateTime($this->user->plan_expiration_date), new DateTime())->format('%h:%i:%S:%d'));
            if (new DateTime($this->user->plan_expiration_date) > new DateTime()) {
                if (date_diff(new DateTime($this->user->plan_expiration_date), new DateTime())->format('%d') <= 0) {
                    $xp_countdown = '<span class="icon-time-circle grey fs-6"> </span>';
                    $xp_countdown .=  ($xp_time[0] ? "<span>{$xp_time[0]}</span> hour" . ends($xp_time[0]) : ($xp_time[1] ? "<span>{$xp_time[1]}</span> minute" . ends($xp_time[1]) : "<span>{$xp_time[2]}</span> second" . ends($xp_time[2]))) . l('qr_codes.remaining');
                } else {
                    $xp_countdown = '<span class="icon-time-circle grey fs-6"> </span>';
                    $xp_countdown .= "<span>" . $xp_time[3] . "</span> day" . ends($xp_time[3]) . l('qr_codes.remaining');
                }
            } else {
                if ($this->user->plan_id == 'free') {
                    $xp_countdown =  l('qr_codes.trail_expired');
                } else {
                    $xp_countdown =  l('qr_codes.subscription_expired');
                }
            }
            ?>

            <?php if ($this->user->plan_id == 'free' ||   new DateTime($this->user->plan_expiration_date) < new DateTime()) : ?>

                <div class="upgrade_area p-2 rounded">
                    <p class="text-center pt-4">
                        <?= $xp_countdown ?>
                    </p>
                    <a href="<?= url('plan') ?>"> <button type="button" class="btn primary-btn upgrade-btn rounded w-75 shadow p-3 btn mx-auto d-block text-white fw-bold py-2 mt-3 mb-3"><?= l('qr_codes.upgrade_btn') ?></button></a>
                </div>

            <?php endif ?>

        </div>
    </div>

    <!-- </div> -->


</div>
<!-- change end 28/01/2023 by parrot-->
<div class="modal-backdrop d-none" id="bak" style="opacity: 0.5;"></div>
<script>
    $('.help-button').click(function() {
        // Remove the "active" class from the last carousel item with id "last"
        $('.carousel-inner').find('#lastEl').removeClass('active');
    });
</script>

<script>
    const hamburger = document.querySelector(".hamburger");
    const navLinks = document.querySelector(".nav-links");
    const mySideNav = document.querySelector("#mySidenav");
    const links = document.querySelectorAll(".nav-links li");
    // hamburger.addEventListener('click', (e) => {
    //     //Animate Links
    //     hamburger.classList.toggle("toggle");
    //     navLinks.classList.toggle("open");
    //     links.forEach(link => {
    //         link.classList.toggle("fade");
    //     });
    //     //Hamburger Animation
    //     hamburger.classList.toggle("toggle");
    // });
</script>


<script>
    function openNav() {
        document.getElementById("mySidenav").style.width = "250px";
        $("#bak").addClass('fade show');
        $("#bak").removeClass('d-none');
        $("#mySidenav").css("z-index", "1050");
        const openMbMenuwithloginElement = document.getElementById("openMbMenuwithlogin");
        if (openMbMenuwithloginElement) {
            openMbMenuwithloginElement.setAttribute("onClick", "closeNav()");
        }
        $(document.body).append("")
    }

    function closeNav() {
        $("#bak").removeClass('fade show');
        $("#bak").addClass('d-none');
        document.getElementById("mySidenav").style.width = "0";
        document.getElementById("openMbMenuwithlogin").setAttribute("onClick", "openNav()");
        const element = document.getElementById('bak');

        if (element) {
            element.remove()
        }
    }
    const overlayBg = document.getElementById('bak');
    const sideBarNav = document.getElementById("mySidenav");

    const screenWidth = window.innerWidth;

    overlayBg.addEventListener('click', function(event) {
        sideBarNav.style.width = "0";
        overlayBg.classList.add('d-none');
        overlayBg.classList.remove('fade', 'show');
    });


    // Data Layer Implementation (GTM)
    $(document).on('click', '.logout', function() {

        var event = "logout";

        var data = {
            "userId": "<?php echo  $this->user->user_id  ?>",
            'user_type': '<?php echo $this->user->total_logins == '1' ? 'New User' : 'Returning User' ?>',
             
        }
        googleDataLayer(event, data);
    });

    $(document).on('click', '.create-qr-btn', function() {

        var event = "all_click";

        var data = {
            "userId": "<?php echo $this->user->user_id ?>",
            "clicktext": "Create QR Code",
             
        }
        googleDataLayer(event, data);
    });
</script>

<script>
    $('.help-button').click(function() {
        // Remove the "active" class from the last carousel item with id "last"
        $('.carousel-inner').find('#lastEl').removeClass('active');
    });
</script>