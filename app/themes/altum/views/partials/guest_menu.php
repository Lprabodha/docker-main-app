<?php
defined('ALTUMCODE') || die();

$currentUrl = SITE_URL . \Altum\Routing\Router::$original_request;

use Altum\Routing\Router;

?>

<?php if (\Altum\Routing\Router::$controller_key != 'email-unsubscribe') : ?>
    <nav class="section-navbar w-100 <?= url(\Altum\Routing\Router::$original_request) == (url('register_nsf')) ? 'shadow' : '' ?>">
        <div class="-container guest-container <?= url(\Altum\Routing\Router::$original_request) == (url('update-payment-method')) ? 'update-method-nav-wrap' : '' ?>">
            <div class="-logo-language">

                <a href="<?= url() ?>" class="-logo <?= (!\Altum\Middlewares\Authentication::check() &&  url(\Altum\Routing\Router::$original_request) == (url('register_nsf')) || url(\Altum\Routing\Router::$original_request) == (url('register-dpf'))) ? 'animate-logo': '' ?>  " id="guest-logo">

                    <img src="<?= ASSETS_FULL_URL . 'images/logo.webp' ?>" alt="Logo" width="1634" height="304">
                </a>
            </div>
            <?php if ($currentUrl  == url("login")) : ?>
                <a href="<?= url('faq') ?>" class="-link-language">
                    <img src="<?= ASSETS_FULL_URL . '/images/message-question.svg' ?>" alt="">
                </a>
            <?php endif ?>
            <?php if ((!\Altum\Middlewares\Authentication::check() &&  url(\Altum\Routing\Router::$original_request) != (url('register_nsf')) && url(\Altum\Routing\Router::$original_request) != (url('register-dpf'))) || $currentUrl  == url("login")) : ?>
                <div class="-login-signup <?= url(\Altum\Routing\Router::$original_request) == (url('update-payment-method')) ? 'hide-element' : '' ?>">
                    <a href="<?= url('login') ?>" class="-link-log-in">
                        <img src="<?= ASSETS_FULL_URL . '/images/Login.svg' ?>" alt="">
                        <span><?= l('home.navbar.btn.login') ?></span>
                    </a>
                    <a href="<?= url('register') ?>" class="-link-sign-up">
                        <img src="<?= ASSETS_FULL_URL . '/images/Logout.svg' ?>" alt="">
                        <span><?= l('home.navbar.btn.signup') ?></span>
                    </a>
                </div>
                <div class="nav-links remove-on-edit ps-0 <?= url(\Altum\Routing\Router::$original_request) == (url('update-payment-method')) ? 'hide-element' : '' ?>">
                    <div class="hamburger burgermenu hidemenu" onclick="openNav()" id="openMenu">
                        <div class="line1"></div>
                        <div class="line2"></div>
                        <div class="line3"></div>
                    </div>
                </div>
            <?php endif ?>
     

            <?php if((\Altum\Middlewares\Authentication::check()) && (Router::$controller_key  == "qr-download")) : ?>
        
                <div class="nav-links guest remove-on-edit ps-0" style="position:relative ;z-index: 1002;">
                    <div class="hamburger burgermenu hidemenu d-flex"  id="openMenu">
                        <div class="line1"></div>
                        <div class="line2"></div>
                        <div class="line3"></div>
                    </div>
                </div>
                <div>

                    <div class="app-sidebar billing-sidenav guest-sidenav">
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
                                    <a href="<?= url('qr/') ?>" class="create-qr-btn ps-4" <?= isset($this->user->plan_expiration_date) ? (new DateTime($this->user->plan_expiration_date) < new DateTime() ? 'data-toggle="modal" data-target="#upgradePopup"' : '') : '' ?>>
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
    
                    <div class="sidebar-backdrop guest-sidenav-back"></div>
                </div>
            <?php endif ?>

           
           
        </div>
    </nav>
<?php endif ?>


<!--  -->