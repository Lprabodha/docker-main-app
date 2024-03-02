<?php defined('ALTUMCODE') || die() ?>
<?php

if (isset($_GET['id'])) {
    $user  = db()->where('referral_key', $_GET['id'])->getOne('users');
    if($user){
        $user->billing = json_decode($user->billing);
    }
}
    


$user = isset($this->user->user_id) ? $this->user : $user;
$billingData = false;
if (isset($user->billing->country) && $user->billing->country != '') {
    $billingData = true;
}

?>

<style>
    .features-boxes::before {
        position: absolute;
        content: "";
        background-image: url(<?= ASSETS_FULL_URL . 'images/yellowdots.png' ?>);
        background-repeat: no-repeat;
        height: 250px;
        width: 250px;
        bottom: 90px;
        left: -90px;
        z-index: -1;
    }

    .features-boxes::after {
        position: absolute;
        content: "";
        background-image: url(<?= ASSETS_FULL_URL . 'images/blue-dots.png' ?>);
        background-repeat: no-repeat;
        height: 250px;
        width: 250px;
        top: -140px;
        right: -114px;
        z-index: -1;
    }
</style>

<link rel="stylesheet" href="<?= ASSETS_FULL_URL . 'css/dashboard-styles.css' ?>">
<!-- for box area slider -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">
<link rel="stylesheet" href="https://unpkg.com/swiper@6.8.1/swiper-bundle.min.css">
<!-- font-awesome  -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">


<script src="<?= ASSETS_FULL_URL . 'js/jquery.min.js' ?>"></script>
<link rel="stylesheet" href="<?= ASSETS_FULL_URL . 'css/payment.css' ?>">

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<!-- <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom border-gray-200 <?= \Altum\Routing\Router::$controller_key == 'index' ? null : 'mb-6' ?>"> -->


<header class="main-header-wrp plans-header-wrp">
    <div class="container-fluid">



        <nav class="billing-nav">
            <a href="<?= isset($_SESSION['new_landing']) ? $_SESSION['new_landing_route'] : url() ?>">
                <div class="logo">
                    <?php if (settings()->main->{'logo_' . \Altum\ThemeStyle::get()} != '') : ?>
                        <img src="<?= ASSETS_FULL_URL . 'images/new-qr-logo.webp' ?>" class="dashboard_logo mt-1" alt="<?= l('global.accessibility.logo_alt') ?>" />
                    <?php else : ?>
                        <?= settings()->main->title ?>
                    <?php endif ?>
                </div>

            </a>

            <?php if (\Altum\Middlewares\Authentication::check() || isset($_GET['id'])) : ?>


                <?php 
                
                    $currentUrl = url() . \Altum\Routing\Router::$original_request; 
                    $para1 = isset($this->params[0]) ? $this->params[0] : '';
                  
                    
                ?>
                <div class="billing-block">
                    <nav aria-label="breadcrumb ">
                        <ol class="custom-breadcrumbs small mb-0">
                          

               
                            <li id="header-step-1" 
                            class="<?= $currentUrl == url('plan') ? 'current' : '' ?> 
                            <?php if ($currentUrl == url('plan') || 
                                    $currentUrl == url('pay-thank-you') || 
                                    $currentUrl == url('plan/renew') || 
                                    $currentUrl == url('plan/upgrade') || 
                                    $currentUrl == url('pay/' . $para1 ) || 
                                    $currentUrl == url('pay-billing/' . $para1) || 
                                    $currentUrl == url('change-plan/' . $para1) || 
                                    $currentUrl == url('reactive-plan/' . $para1)) 
                                    
                                    {    echo 'active'; } else { echo ''; } ?>">
                                <div>
                                    <span class="number">1</span>
                                    <span class="text d-lg-block -md-none"><?= l('plans_and_prices.header_nav_1') ?></span>
                                    <div class="arrow-block"><i class="fa fa-fw fa-angle-right arrow-head"></i></div>
                                </div>
                            </li>
                          
                            <li id="header-step-2" 
                            class="<?= $currentUrl == url('pay-billing/' . $para1) ? 'current' : '' ?> 
                            <?php if ($currentUrl == url('pay-billing/' . $para1) || 
                                    $currentUrl == url('pay-thank-you') || 
                                    $currentUrl == url('pay/' . $para1) || 
                                    $currentUrl == url('change-plan/' . $para1) ||
                                    $currentUrl == url('reactive-plan/' . $para1)) 
                                    { echo 'active'; } else {  echo ''; } ?>">
                                <div>
                                    <span class="number">2</span>
                                    <span class="text d-lg-block -md-none"><?= l('plans_and_prices.header_nav_2') ?></span>
                                    <div class="arrow-block"><i class="fa fa-fw fa-angle-right arrow-head"></i></div>
                                    <!--  -->
                                </div>
                            </li>
                                                                                                    
                            <li  aria-current="page" id="menu-payment" 
                            class="<?= $currentUrl == url('pay/' . $para1) ? 'current' : '' ?> 
                            <?php if ($billingData==true && $currentUrl == url('pay/' . $para1) || 
                                    $currentUrl == url('change-plan/' . $para1) || 
                                    $currentUrl == url('reactive-plan/' . $para1) ||
                                    $currentUrl == url('pay-thank-you')) 
                                    { echo 'active'; } else { echo ''; } ?>">

                                <div>
                                    <span class="number">3</span>
                                    <span class="text d-lg-block -md-none"><?= l('plans_and_prices.header_nav_3') ?></span>
                                </div>
                            </li>
                        </ol>
                    </nav>
                </div>



            <?php endif ?>


            <div class="d-flex">
                <ul class="nav-links">
                    <?php if (\Altum\Middlewares\Authentication::check()) : ?>
                        <div class="hamburger burgermenu" id="openMenu">
                            <i class="fas fa-bars"></i>
                        </div>
                    <?php endif ?>
                </ul>

            </div>

        </nav>
    </div>
    <!-- <div class="black-friday-full-wrap dpf-black-friday 
    <?= $currentUrl == url('plan') ||
        $currentUrl == url('plan/renew') ||
        $currentUrl == url('plan/upgrade')  ? 'd-none' : 'd-none plan-friday-wrap' ?> ">
        <div class="friday-wrap d-flex justify-content-center align-items-center">
            <div class="friday-text-wrap">
                <span class="friday-text"><?= l('plan_card.black_friday_text_1') ?><span class="color-text"><?= l('plan_card.black_friday_text_3') ?></span></span>
            </div>
        </div>
    </div> -->
</header>

<!-- change start 28/01/2023 by parrot-->

<?php defined('ALTUMCODE') || die() ?>

<div class="app-sidebar billing-sidenav">
    <div class="app-sidebar-title text-truncate">
        <a href="<?= url() ?>">
            <?php if (settings()->main->{'logo_' . \Altum\ThemeStyle::get()} != '') : ?>
                <img src="<?= ASSETS_FULL_URL . 'images/new-qr-logo.webp' ?>" class="dashboard_logo mt-1" alt="<?= l('global.accessibility.logo_alt') ?>" />
            <?php else : ?>
                <?= settings()->main->title ?>
            <?php endif ?>
        </a>
    </div>

    <div class="overflow-auto customScrollbar flex-grow-1">
        <ul class="app-sidebar-links pl-0">
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
                <a href="<?= url('billing') ?>" class="ps-4">
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
                <hr class="m-auto my-3 text-secondary">
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
            <hr class="m-auto mt-3 text-secondary">
        </ul>
        <ul class="app-sidebar-links mb-2 pl-0">
            <li style="padding: 3px 0 2px">
                <a href="<?= url('logout') ?>" class="py-2 ps-4">
                    <span class="icon-sign-out grey"></span>
                    <?= l('qr_codes.dashboard.logout') ?>
                </a>
            </li>
        </ul>

    </div>

</div>

<div class="sidebar-backdrop"></div>

<!-- change end 28/01/2023 by parrot-->
<div class="modal-backdrop d-none" id="bak" style="opacity: 0.5;"></div>

<script>
    // Menu Steps
        // var url = window.location.href;
        // var firstStep =  $("#header-step-1");
        // var secondStep =  $("#header-step-2");
        // var thirdStep =  $("#menu-payment");
        // if ( url.includes("plan") ) {
        //     firstStep.addClass('active');
        // console.log("The URL contains the word");
        // } 
        // if ( url.includes("pay-billing") ) {
        //     firstStep.addClass('active');
        //     secondStep.addClass('active');
        //     secondStep.addClass('current');
        // }
        // if ( url.includes("pay") ) {
        //     firstStep.addClass('active');
        //     secondStep.addClass('active');
        //     thirdStep.addClass('active');
        //     thirdStep.addClass('current');
            
        // }
    // Menu Steps
    $("#openMenu").click(function() {
        $('.billing-sidenav').toggleClass('active');
    });

    document.querySelector('.sidebar-backdrop').addEventListener('click', function() {
        $('.billing-sidenav').toggleClass('active');
    });

    const overlayBg = document.getElementById('bak');
    const sideBarNav = document.getElementById("mySidenav");

    const screenWidth = window.innerWidth;

    overlayBg.addEventListener('click', function(event) {
        sideBarNav.style.width = "0";
        overlayBg.classList.add('d-none');
        overlayBg.classList.remove('fade', 'show');
    });
</script>