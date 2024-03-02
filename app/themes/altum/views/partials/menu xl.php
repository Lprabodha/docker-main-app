<?php defined('ALTUMCODE') || die() ?>

<!-- for box area slider -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">
<link rel="stylesheet" href="https://unpkg.com/swiper@6.8.1/swiper-bundle.min.css">
<!-- font-awesome  -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<script src="./themes/altum/assets/js/jquery.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<!-- <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom border-gray-200 <?= \Altum\Routing\Router::$controller_key == 'index' ? null : 'mb-6' ?>"> -->
<header>
    <div class="container">

        <div id="mySidenav" class="sidenav">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <ul class="app-sidebar-links">
                <li class="<?= \Altum\Routing\Router::$controller == 'Dashboard' ? 'active' : null ?>">
                    <a href="<?= url('analytics') ?>">
                        <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 24px;">
                            <rect x="3" y="11" width="4" height="10"></rect>
                            <rect x="10" y="7" width="4" height="14"></rect>
                            <rect x="17" y="3" width="4" height="18"></rect>
                        </svg>
                        Analysis
                    </a>
                </li>
                <li class="<?= \Altum\Routing\Router::$controller == 'Dashboard' ? 'active' : null ?>">
                    <a href="<?= url('analytics') ?>">
                        <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 24px;">
                            <rect x="3" y="11" width="4" height="10"></rect>
                            <rect x="10" y="7" width="4" height="14"></rect>
                            <rect x="17" y="3" width="4" height="18"></rect>
                        </svg>
                        Analysis
                    </a>
                </li>
                <li class="<?= \Altum\Routing\Router::$controller == 'Dashboard' ? 'active' : null ?>">
                    <a href="<?= url('analysis') ?>">
                        <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 24px;">
                            <rect x="3" y="11" width="4" height="10"></rect>
                            <rect x="10" y="7" width="4" height="14"></rect>
                            <rect x="17" y="3" width="4" height="18"></rect>
                        </svg>
                        Analysis
                    </a>
                </li>
                <li class="<?= \Altum\Routing\Router::$controller == 'QrCodes' ? 'active' : null ?>">
                    <a href="<?= url('qr-codes') ?>">
                        <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 24px;">
                            <path d="M3,10h7V3H3ZM5,5H8V8H5Z"></path>
                            <path d="M3,21h7V14H3Zm2-5H8v3H5Z"></path>
                            <path d="M14,3v7h7V3Zm5,5H16V5h3Z"></path>
                            <rect x="16" y="16" width="3" height="3"></rect>
                            <rect x="14" y="14" width="2" height="2"></rect>
                            <rect x="19" y="14" width="2" height="2"></rect>
                            <rect x="19" y="19" width="2" height="2"></rect>
                            <rect x="14" y="19" width="2" height="2"></rect>
                        </svg>
                        <?= l('qr_codes.menu') ?>
                    </a>
                </li>
                <li class="<?= \Altum\Routing\Router::$controller == 'Account' ? 'active' : null ?>">
                    <a href="<?= url('account') ?>">
                        <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 24px;">
                            <ellipse cx="12" cy="7.5" rx="4.52" ry="4.5"></ellipse>
                            <path d="M19.63,16.5A2.92,2.92,0,0,0,16.58,14H7.42a2.92,2.92,0,0,0-3,2.5L3,21H21Z"></path>
                        </svg>
                        <?= l('account.menu') ?>
                    </a>
                </li>

                <li class="<?= \Altum\Routing\Router::$controller == 'Billing' ? 'active' : null ?>">
                    <a href="<?= url('billing') ?>">
                        <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 24px;">
                            <path d="M2,4v9H22V4ZM19.89,8H16V6h3.89Z"></path>
                            <rect x="2" y="16" width="20" height="4"></rect>
                        </svg>
                        <?= l('billing.menu') ?>
                    </a>
                </li>
                <li class="<?= \Altum\Routing\Router::$controller == 'Users' ? 'active' : null ?>">
                    <a href="<?= url('users') ?>">
                        <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 24px;">
                            <path d="M4,2V22H20V2Zm6,16H7V15h3Zm0-5H7V10h3Zm0-5H7V5h3Zm7,9H12V16h5Zm0-5H12V11h5Zm0-5H12V6h5Z"></path>
                        </svg>
                        <?= l('users.menu') ?>
                    </a>
                </li>
            </ul>
            <div class="toggle-container" id="accordionExample">
                <div class="menu-toggle">
                    <div class="tab-head" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                        <label>Company</label>
                        <span class="plus">+</span>
                        <span class="minimize">-</span>
                    </div>
                    <div class="collapse" id="collapseExample" data-parent="#accordionExample">
                        <ul class="toggle-link">
                            <li>
                                <a href="<?= url('plan') ?>"> Plans and prices</a>
                            </li>
                            <li>
                                <a href="<?= url('terms-and-conditions') ?>">Terms of Use and Contract</a>
                            </li>
                            <li>
                                <a href="<?= url('privacy-policy') ?>">Privacy Policy</a>
                            </li>
                            <li>
                                <a href="<?= url('cookies-policy') ?>">Cookies Policy</a>
                            </li>
                            <li>
                                <a href="<?= url('gdpr') ?>">GDPR</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="menu-toggle">
                    <div class="tab-head" data-toggle="collapse" data-target="#collapseExample1" aria-expanded="false" aria-controls="collapseExample1">
                        <label>Help</label>
                        <span class="plus">+</span>
                        <span class="minimize">-</span>
                    </div>
                    <div class="collapse" id="collapseExample1" data-parent="#accordionExample">
                        <ul class="toggle-link">
                            <li>
                                <a href="<?= url('contact') ?>">Contact us</a>
                            </li>
                            <li>
                                <a href="<?= url('faq') ?>">FAQ</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <ul class="app-sidebar-links mt-3 mb-2">
                <li style="padding: 3px 0 2px">
                    <a href="<?= url('logout') ?>" class="py-2">
                        <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 24px;">
                            <path d="M20.71,11.29l-4-4a1,1,0,1,0-1.42,1.42L17.59,11H9a1,1,0,0,0,0,2h8.59l-2.3,2.29a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0l4-4A1,1,0,0,0,20.71,11.29Z"></path>
                            <path d="M12,19H5V5h7a1,1,0,0,0,0-2H4A1,1,0,0,0,3,4V20a1,1,0,0,0,1,1h8a1,1,0,0,0,0-2Z"></path>
                        </svg>
                        Log Out
                    </a>
                </li>
            </ul>
            <div class="app-sidebar-footer dropdown">
                <div class="d-flex align-items-center app-sidebar-footer-block">
                    <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 24px;" color="#EAEAEC" app-sidebar-footer-text;>
                        <circle cx="12" cy="12" r="12"></circle>
                        <path fill="#220E27" d="M12,12A4,4,0,1,0,8,8,4,4,0,0,0,12,12Zm0-6a2,2,0,1,1-2,2A2,2,0,0,1,12,6Z"></path>
                        <path fill="#220E27" d="M19.93,21A8,8,0,0,0,4.07,21,11.75,11.75,0,0,0,6,22.39c0-.13,0-.26,0-.39a6,6,0,0,1,12,0c0,.13,0,.26,0,.39A11.75,11.75,0,0,0,19.93,21Z"></path>
                    </svg>
                    <div class="app-sidebar-footer-text d-flex flex-column text-truncate">
                        <small class="text-truncate"><?= $this->user->email ?></small>
                    </div>
                </div>

                <?php if (new DateTime($this->user->plan_expiration_date) > new DateTime()) : ?>
                    <div class="triel-tab" data-toggle="tooltip" data-html="true" title="<?= date_diff(new DateTime($this->user->plan_expiration_date), new DateTime())->format('%d days') ?> of Free Trial Left">
                        <span>Trial</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                        </svg>
                    </div>
                <?php endif ?>

            </div>
        </div>
        <nav>
            <a href="<?= url() ?>">
                <div class="logo">
                    <?php if (settings()->main->{'logo_' . \Altum\ThemeStyle::get()} != '') : ?>
                        <img src="<?= UPLOADS_FULL_URL . 'main/' . settings()->main->{'logo_' . \Altum\ThemeStyle::get()} ?>" class="img-fluid navbar-logo" alt="<?= l('global.accessibility.logo_alt') ?>" loading="lazy" />
                    <?php else : ?>
                        <?= settings()->main->title ?>
                    <?php endif ?>
                </div>
            </a>


            <div class="jss1456 mobile">
                <div class="MuiPaper-root MuiStepper-root jss1470 MuiStepper-horizontal MuiPaper-elevation0">
                    <a class="MuiStep-root jss1471 MuiStep-horizontal" id="tab1">
                        <svg id="s1" class="MuiSvgIcon-root jss1478 jss1480" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                            <circle cx="12" cy="12" r="12"></circle>
                            <text class="jss1479" x="12" y="18" text-anchor="middle">1</text>
                        </svg>
                    </a>
                    <div class="MuiStepConnector-root jss1483 MuiStepConnector-horizontal">
                        <span class="MuiStepConnector-line jss1484 MuiStepConnector-lineHorizontal"></span>
                    </div>
                    <div class="MuiStep-root jss1471 MuiStep-horizontal" id="tab2">
                        <svg id="s2" class="MuiSvgIcon-root jss1478" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                            <circle cx="12" cy="12" r="12"></circle>
                            <text class="jss1479" x="12" y="18" text-anchor="middle">2</text>
                        </svg>
                    </div>
                    <div class="MuiStepConnector-root jss1483 MuiStepConnector-horizontal Mui-disabled">
                        <span class="MuiStepConnector-line jss1484 MuiStepConnector-lineHorizontal"></span>
                    </div>
                    <div class="MuiStep-root jss1471 MuiStep-horizontal " id="tab3">
                        <svg id="s3" class="MuiSvgIcon-root jss1478" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                            <circle cx="12" cy="12" r="12"></circle>
                            <text class="jss1479" x="12" y="18" text-anchor="middle">3</text>
                        </svg>
                    </div>
                </div>

            </div>
            <div class="vr mobile"></div>

            <div class="hamburger">
                <div class="line1"></div>
                <div class="line2"></div>
                <div class="line3"></div>
            </div>

            <span style="font-size:30px;cursor:pointer;" class="mobileNav" onclick="openNav()">&#9776;</span>
            <div class="vr mobile"></div>
            <button type="button" class="jss1466 mobile" data-toggle="modal" data-target="#helpModal" data-target="#helpCarousel" data-slide-to="0" onclick="onModal()">
                <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M12,2A10,10,0,1,0,22,12,10,10,0,0,0,12,2Zm0,18a8,8,0,1,1,8-8A8,8,0,0,1,12,20Z"></path>
                    <path d="M11.17,15.17a.91.91,0,0,0-.92.92.89.89,0,0,0,.27.65.91.91,0,0,0,.65.26.92.92,0,0,0,.65-.26.93.93,0,0,0,0-1.31A.92.92,0,0,0,11.17,15.17Z"></path>
                    <path d="M12,7a3,3,0,0,0-2.18.76,2.5,2.5,0,0,0-.81,2h1.44a1.39,1.39,0,0,1,.41-1.07A1.61,1.61,0,0,1,12,8.27a1.6,1.6,0,0,1,1.14.4,1.48,1.48,0,0,1,.41,1.1,1.39,1.39,0,0,1-.61,1.33,3.88,3.88,0,0,1-1.88.33h-.64v2.65h1.45V12.46a3.79,3.79,0,0,0,2.35-.63,2.37,2.37,0,0,0,.79-2,2.7,2.7,0,0,0-.83-2.11A3.16,3.16,0,0,0,12,7Z"></path>
                </svg>
                <!-- <span class="jss1467">Help</span> -->
            </button>

            <div class="jss1456 desktop" style="display: none;">
                <div class="MuiPaper-root MuiStepper-root jss1470 MuiStepper-horizontal MuiPaper-elevation0">
                    <a onclick="change_step(1)" class="MuiStep-root jss1471 MuiStep-horizontal" id="tab1">
                        <span class="MuiStepLabel-root MuiStepLabel-horizontal">
                            <span class="MuiStepLabel-iconContainer jss1472">
                                <div class="jss1477 jss1480">
                                    <svg id="s1" class="MuiSvgIcon-root jss1478 jss1480" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                        <circle cx="12" cy="12" r="12"></circle>
                                        <text class="jss1479" x="12" y="18" text-anchor="middle">1</text>
                                    </svg>
                                </div>
                            </span>
                            <span class="MuiStepLabel-labelContainer">
                                <span class="MuiTypography-root MuiStepLabel-label jss1473 MuiStepLabel-active jss1474 MuiTypography-body2 MuiTypography-displayBlock">Type of QR code</span>
                            </span>
                        </span>
                    </a>
                    <div class="MuiStepConnector-root jss1483 MuiStepConnector-horizontal">
                        <span class="MuiStepConnector-line jss1484 MuiStepConnector-lineHorizontal"></span>
                    </div>
                    <div class="MuiStep-root jss1471 MuiStep-horizontal" id="tab2" onclick="backButton()">
                        <span class="MuiStepLabel-root MuiStepLabel-horizontal">
                            <span class="MuiStepLabel-iconContainer jss1472">
                                <div class="jss1477">
                                    <svg id="s2" class="MuiSvgIcon-root jss1478" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                        <circle cx="12" cy="12" r="12"></circle>
                                        <text class="jss1479" x="12" y="18" text-anchor="middle">2</text>
                                    </svg>
                                </div>
                            </span>
                            <span class="MuiStepLabel-labelContainer">
                                <span class="MuiTypography-root MuiStepLabel-label jss1473 MuiTypography-body2 MuiTypography-displayBlock">Content</span>
                            </span>
                        </span>
                    </div>
                    <div class="MuiStepConnector-root jss1483 MuiStepConnector-horizontal Mui-disabled">
                        <span class="MuiStepConnector-line jss1484 MuiStepConnector-lineHorizontal"></span>
                    </div>
                    <div class="MuiStep-root jss1471 MuiStep-horizontal " id="tab3">
                        <span class="MuiStepLabel-root MuiStepLabel-horizontal Mui-disabled">
                            <span class="MuiStepLabel-iconContainer jss1472">
                                <div class="jss1477">
                                    <svg id="s3" class="MuiSvgIcon-root jss1478" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                        <circle cx="12" cy="12" r="12"></circle>
                                        <text class="jss1479" x="12" y="18" text-anchor="middle">3</text>
                                    </svg>
                                </div>
                            </span>
                            <span class="MuiStepLabel-labelContainer">
                                <span class="MuiTypography-root MuiStepLabel-label jss1473 MuiTypography-body2 MuiTypography-displayBlock">QR design</span>
                            </span>
                        </span>
                    </div>
                </div>


            </div>


            <div class="d-flex">

                <button type="button" class="jss1466 desktop mr-n2" data-toggle="modal" data-target="#helpModal" data-target="#helpCarousel" data-slide-to="0" onclick="onModal()">
                    <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M12,2A10,10,0,1,0,22,12,10,10,0,0,0,12,2Zm0,18a8,8,0,1,1,8-8A8,8,0,0,1,12,20Z"></path>
                        <path d="M11.17,15.17a.91.91,0,0,0-.92.92.89.89,0,0,0,.27.65.91.91,0,0,0,.65.26.92.92,0,0,0,.65-.26.93.93,0,0,0,0-1.31A.92.92,0,0,0,11.17,15.17Z"></path>
                        <path d="M12,7a3,3,0,0,0-2.18.76,2.5,2.5,0,0,0-.81,2h1.44a1.39,1.39,0,0,1,.41-1.07A1.61,1.61,0,0,1,12,8.27a1.6,1.6,0,0,1,1.14.4,1.48,1.48,0,0,1,.41,1.1,1.39,1.39,0,0,1-.61,1.33,3.88,3.88,0,0,1-1.88.33h-.64v2.65h1.45V12.46a3.79,3.79,0,0,0,2.35-.63,2.37,2.37,0,0,0,.79-2,2.7,2.7,0,0,0-.83-2.11A3.16,3.16,0,0,0,12,7Z"></path>
                    </svg>
                    <span class="jss1467">Help</span>
                </button>
                <div class="vr desktop mt-2 mx-3"></div>




                <ul class="nav-links">

                    <!-- <li>
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle btn-hdr" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-globe"></i>&nbsp; Langauge
                        </button>
                       
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            
                            <a class="dropdown-item" href="/bg">Bulgarian</a>
                            <a class="dropdown-item" href="/hr">Croatian</a>
                            <a class="dropdown-item" href="/cs">Czech</a>
                            <a class="dropdown-item" href="/da">Danish</a>
                            <a class="dropdown-item" href="/nl">Dutch</a>
                            <a class="dropdown-item" href="/en">English</a>
                            <a class="dropdown-item" href="/fr">French</a>
                            <a class="dropdown-item" href="/de">German</a>
                            <a class="dropdown-item" href="/el">Greek</a>
                            <a class="dropdown-item" href="/it">Italian</a>
                            <a class="dropdown-item" href="/ko">Korian</a>
                        </div>
                </li> -->
                    <!-- <li>
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle btn-hdr" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-dollar-sign"></i>&nbsp; Currency
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="#">AED</a>
                            <a class="dropdown-item" href="#">AFN</a>
                            <a class="dropdown-item" href="#">ALL</a>
                            <a class="dropdown-item" href="#">AMD</a>
                            <a class="dropdown-item" href="#">ANG</a>
                            <a class="dropdown-item" href="#">AUD</a>
                            <a class="dropdown-item" href="#">AZW</a>
                            <a class="dropdown-item" href="#">BAM</a>
                            <a class="dropdown-item" href="#">BDT</a>
                            <a class="dropdown-item" href="#">CLP</a>
                            <a class="dropdown-item" href="#">GEL</a>
                        </div>
                </li> -->

                    <?php if (\Altum\Middlewares\Authentication::check()) : ?>

                        <!-- <li class="dropdown">
                        <a class="dropdown-toggle dropdown-toggle-simple" data-toggle="dropdown" href="#" aria-haspopup="true" aria-expanded="false">
                            <img src="<?= get_gravatar($this->user->email, 80, 'identicon') ?>" class="navbar-avatar mr-1" loading="lazy" />
                            <span class="align-middle"><?= $this->user->name ?></span>
                            <span class="align-middle"><i class="fa fa-fw fa-sm fa-caret-down"></i></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right">
                            <?php if (!\Altum\Teams::is_delegated()) : ?>
                                <?php if (\Altum\Middlewares\Authentication::is_admin()) : ?>
                                    <a class="dropdown-item" href="<?= url('admin') ?>"><i class="fa fa-fw fa-sm fa-fingerprint mr-2"></i> <?= l('global.menu.admin') ?></a>
                                    <div class="dropdown-divider"></div>
                                <?php endif ?>
                                <a class="dropdown-item" href="<?= url('qr-codes') ?>"><i class="fa fa-fw fa-sm fa-qrcode mr-2"></i> <?= l('dashboard.name') ?></a>
                                <a class="dropdown-item" href="<?= url('account') ?>"><i class="fa fa-fw fa-sm fa-wrench mr-2"></i> <?= l('account.menu') ?></a>

                                <a class="dropdown-item" href="<?= url('account-plan') ?>"><i class="fa fa-fw fa-sm fa-box-open mr-2"></i> <?= l('account_plan.menu') ?></a>
                                <?php if (settings()->payment->is_enabled) : ?>
                                    <a class="dropdown-item" href="<?= url('account-payments') ?>"><i class="fa fa-fw fa-sm fa-dollar-sign mr-2"></i> <?= l('account_payments.menu') ?></a>

                                    <?php if (\Altum\Plugin::is_active('affiliate') && settings()->affiliate->is_enabled) : ?>
                                        <a class="dropdown-item" href="<?= url('referrals') ?>"><i class="fa fa-fw fa-sm fa-wallet mr-2"></i> <?= l('referrals.menu') ?></a>
                                    <?php endif ?>
                                <?php endif ?>
                                <a class="dropdown-item" href="<?= url('account-api') ?>"><i class="fa fa-fw fa-sm fa-code mr-2"></i> <?= l('account_api.menu') ?></a>

                                <?php if (\Altum\Plugin::is_active('teams')) : ?>
                                    <a class="dropdown-item" href="<?= url('teams-system') ?>"><i class="fa fa-fw fa-sm fa-user-shield mr-2"></i> <?= l('teams_system.menu') ?></a>
                                <?php endif ?>
                            <?php endif ?>

                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?= url('logout') ?>"><i class="fa fa-fw fa-sm fa-sign-out-alt mr-2"></i> <?= l('global.menu.logout') ?></a>
                        </div>
                    </li> -->

                    <?php else : ?>
                        <li>
                            <a data-toggle="modal" class=" text-primary" href="<?= url('login') ?>"><?= l('login.menu') ?></a>
                        </li>

                        <?php if (settings()->users->register_is_enabled) : ?>
                            <li>
                                <a data-toggle="modal" data-target="#registerModal" class=" text-primary" href="<?= url('register') ?>"><?= l('register.menu') ?></a>

                                <!-- <button class="join-button"><a style="color: white;" href="<?= url('register') ?>"><?= l('register.menu') ?></a></button> -->
                            </li>
                        <?php endif ?>

                    <?php endif ?>

                    <?php if (\Altum\Middlewares\Authentication::check()) : ?>
                        <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776;</span>
                    <?php else : ?>

                    <?php endif ?>

                </ul>

            </div>

        </nav>
    </div>
</header>

<!-- signin -->
<div class="modal smallmodal fade loginRegisterModal" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <h1><?= l('login.menu') ?></h1>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <svg class="MuiSvgIcon-root jss709" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 20px;">
                    <path d="M13.41,12l5.3-5.29a1,1,0,1,0-1.42-1.42L12,10.59,6.71,5.29A1,1,0,0,0,5.29,6.71L10.59,12l-5.3,5.29a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0L12,13.41l5.29,5.3a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42Z"></path>
                </svg>
            </button>            
        </div>
    </div>
</div>

<!-- signup -->
<div class="modal smallmodal fade loginRegisterModal" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <h1><?= l('login.menu') ?></h1>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <svg class="MuiSvgIcon-root jss709" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 20px;">
                    <path d="M13.41,12l5.3-5.29a1,1,0,1,0-1.42-1.42L12,10.59,6.71,5.29A1,1,0,0,0,5.29,6.71L10.59,12l-5.3,5.29a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0L12,13.41l5.29,5.3a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42Z"></path>
                </svg>
            </button>            
        </div>
    </div>
</div>

<!-- forgot password-->
<div class="modal smallmodal fade loginRegisterModal" id="forgotModal" tabindex="-1" aria-labelledby="forgotModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <h1>Recover Password</h1>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <svg class="MuiSvgIcon-root jss709" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 20px;">
                    <path d="M13.41,12l5.3-5.29a1,1,0,1,0-1.42-1.42L12,10.59,6.71,5.29A1,1,0,0,0,5.29,6.71L10.59,12l-5.3,5.29a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0L12,13.41l5.29,5.3a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42Z"></path>
                </svg>
            </button>
            <div class="modal-body p-0">
                <p class="modalText mb-3 text-left">Enter the email with which you created your account and we will send you a code so you can recover your password</p>

                <div class="form-group pt-4">
                    <label for="email_title" class="commonLabel d-block"><?= l('login.form.email') ?></label>
                    <input id="email" type="text" name="email" class="form-control <?= \Altum\Alerts::has_field_errors('email') ? 'is-invalid' : null ?>" value="<?= $data->values['email'] ?>" required="required" autofocus="autofocus" />
                    <?= \Altum\Alerts::output_field_error('email') ?>
                </div>
                <div class="modalButton">
                    <button class="primaryBigButton mt-0 mb-3" data-toggle="modal" data-dismiss="modal" aria-label="Close" data-target="#sendEmailModal">Send email</button>
                    <button class="primaryBigButton outline m-0 d-block" data-dismiss="modal" aria-label="Close">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!--send email-->
<div class="modal smallmodal fade loginRegisterModal" id="sendEmailModal" tabindex="-1" aria-labelledby="sendEmailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content pb-5">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <svg class="MuiSvgIcon-root jss709" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 20px;">
                    <path d="M13.41,12l5.3-5.29a1,1,0,1,0-1.42-1.42L12,10.59,6.71,5.29A1,1,0,0,0,5.29,6.71L10.59,12l-5.3,5.29a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0L12,13.41l5.29,5.3a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42Z"></path>
                </svg>
            </button>
            <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 50px;">
                <path class="custom-color--circle-check-green" fill="#69DF6A" d="M24 12c0 6.627-5.373 12-12 12s-12-5.373-12-12c0-6.627 5.373-12 12-12s12 5.373 12 12z"></path>
                <path fill="#000" d="M10 17.41l-4.71-4.7 1.42-1.42 3.29 3.3 7.29-7.3 1.42 1.42-8.71 8.7z"></path>
            </svg>
            <h1>Check your inbox!</h1>
            <p class="modalText">We have sent you an email with the instructions to recover your password.</p>
            <div class="modalButton1">
                <button class="primaryBigButton m-0" data-dismiss="modal" aria-label="Close">Accept</button>
            </div>
        </div>
    </div>
</div>

<script>
    const hamburger = document.querySelector(".hamburger");
    const navLinks = document.querySelector(".nav-links");
    const links = document.querySelectorAll(".nav-links li");
    hamburger.addEventListener('click', () => {
        //Animate Links
        navLinks.classList.toggle("open");
        links.forEach(link => {
            link.classList.toggle("fade");
        });
        //Hamburger Animation
        hamburger.classList.toggle("toggle");
    });
</script>
<style>
    .vr {
        border-left: 1px solid gray;
        min-height: 1em;
    }

    @import url('https://fonts.googleapis.com/css2?family=Kadwa:wght@400;700&family=Roboto+Condensed:wght@300;400;700&family=Roboto:wght@100;300;400;500;700;900&display=swap');

    * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
    }

    p {
        margin: 0;
        padding: 0;
    }

    h1,
    h2,
    h3,
    h4,
    h5.h6 {
        padding: 0;
        margin: 0;
    }

    ul {
        margin: 0;
        padding: 0;
        list-style-type: none;
    }

    a {
        text-decoration: none !important;
    }

    body {
        background: var(--bg-color);
        font-family: 'Kadwa', serif;
        overflow-x: hidden;
    }

    :root {
        --primary-color: #FF9B06;
        --light-primary: #FFB74D;
        --secondary--color: #00288A;
        --black: #000000;
        --white-color: #FFFFFF;
        --bg-color: #F5F5F5;
        --paragraph: #9c9c9c;
    }

    /* header start */

    header {
        padding: 15px 0;
        background: var(--white-color);
        box-shadow: rgb(230 230 230) 0px 2px 8px 0px;
    }

    header .container {
        max-width: 1196px;
    }

    header nav {
        /* height: 6rem; */
        width: 100%;
        display: flex;
        justify-content: space-between;
        position: unset !important;
        max-width: 1196px;
        z-index: 999999;
        align-items: center;
    }

    /*Styling logo*/
    .logo {
        /* margin-left: 30px; */
    }

    .logo img {
        height: 5rem;
        width: 5rem;
    }

    /*Styling Links*/

    .nav-links {
        display: flex;
        list-style: none;
        /* width: 58vw; */
        /* padding: 0 0.7vw; */
        justify-content: space-between;
        align-items: center;
        text-transform: uppercase;
    }

    .nav-links li a {
        text-decoration: none;
        color: #000000;
        margin: 0 16px;
        font-size: 15px !important;
        font-weight: 400;
        transition: .5s;
    }

    .nav-links li a:hover {
        color: #FF9B06;
    }

    .nav-links li {
        position: relative;
        padding: 0 7px;
    }


    .dropdown:hover>.dropdown-menu {
        display: block;
    }

    .dropdown>.dropdown-toggle:active {
        /*Without this, clicking will make it sticky*/
        pointer-events: none;
    }

    .btn-hdr {
        padding: 0 !important;
        background: transparent;
        border: none;
        color: #000000;
        min-width: 0 !important;
        font-size: 16px !important;
        margin: 0 16px;
    }

    .btn-hdr:hover {
        background: transparent;
        color: #FF9B06;
    }

    .dropdown-menu {
        max-height: 150px;
        left: -20px;
        overflow-y: scroll;
        overflow-x: hidden;
        border: none;
        background: rgb(255, 255, 255);
    }

    /* 
    .dropdown-menu::-webkit-scrollbar {
        background: rgb(240, 240, 240) !important;
        width: 5px !important;
        border-radius: 3px !important;
        color: #00288A!important;
        height: 20px!important;
    } */


    /* width */
    .dropdown-menu::-webkit-scrollbar {
        width: 5px;

    }

    /* Track */
    .dropdown-menu::-webkit-scrollbar-track {
        /* background: #f1f1f1; */
    }

    /* Handle */
    .dropdown-menu::-webkit-scrollbar-thumb {
        background: rgb(209, 209, 209);
        border-radius: 100px;
    }


    .dropdown-menu a {
        margin: 0 !important;
    }

    .fade:not(.show) {
        opacity: 1;
    }

    /*Styling Buttons*/

    .join-button {
        color: #fff;
        background-color: #00288A;
        border: 1.5px solid #00288A;
        border-radius: 50px;
        padding: 10px 25px;
        font-size: 22px;
        cursor: pointer;
        height: 40px;
        display: flex;
        align-items: center;

    }

    .join-button:hover {
        color: #fff;
        background-color: #FF9B06;
        border: 1.5px solid #FF9B06;
        transition: all ease-in-out 350ms;
    }

    /*Styling Hamburger Icon*/
    .hamburger div {
        width: 20px;
        height: 3px;
        background: #00288A;
        margin: 3px;
        transition: all 0.3s ease;
    }

    .hamburger {
        display: none;
    }

    /*Animating Hamburger Icon on Click*/
    .toggle .line1 {
        transform: rotate(-45deg) translate(-3px, 6px);
    }

    .toggle .line2 {
        transition: all 0.7s ease;
        width: 0;
    }

    .toggle .line3 {
        transform: rotate(45deg) translate(-2px, -6px);
    }

    .mobileNav {
        display: none;
        cursor: pointer;
        z-index: 2;
        transition: all 0.7s ease;
    }

    @media only screen and (max-width: 1440px) {
        header nav {
            left: 160px;
        }

    }

    @media only screen and (max-width: 1199px) {
        nav {
            position: fixed;
            z-index: 3;
        }


        header nav {
            left: 0px;
            max-width: 100%;
        }

        .mobileNav {
            display: block;
            cursor: pointer;
            z-index: 2;
            transition: all 0.7s ease;
        }

        .hamburger {
            display: none;
            cursor: pointer;
            z-index: 2;
            transition: all 0.7s ease;
        }

        .nav-links {
            left: 0;
            top: 0;
            position: fixed;
            background: #FF9B06;
            height: 100vh;
            width: 100%;
            flex-direction: column;
            clip-path: circle(50px at 90% -20%);
            -webkit-clip-path: circle(50px at 90% -10%);
            transition: all 1s ease-out;
            pointer-events: none;
            justify-content: center;
        }

        li.fade {
            padding-bottom: 50px;
        }

        .nav-links.open {
            clip-path: circle(1000px at 90% -10%);
            -webkit-clip-path: circle(1530px at 90% 10%);
            pointer-events: all;
        }

        .nav-links li {
            opacity: 0;
        }

        .nav-links li:nth-child(1) {
            transition: all 0.5s ease 0.2s;
        }

        .nav-links li:nth-child(2) {
            transition: all 0.5s ease 0.4s;
        }

        .nav-links li:nth-child(3) {
            transition: all 0.5s ease 0.6s;
        }

        .nav-links li:nth-child(4) {
            transition: all 0.5s ease 0.7s;
        }

        .nav-links li:nth-child(5) {
            transition: all 0.5s ease 0.8s;
        }

        .nav-links li:nth-child(6) {
            transition: all 0.5s ease 0.9s;
            margin: 0;
        }

        .nav-links li:nth-child(7) {
            transition: all 0.5s ease 1s;
            margin: 0;
        }

        li.fade {
            opacity: 1;
        }
    }

    @media only screen and (max-width: 960px) {
        header {
            height: 52px;
            padding: 10px 0;
        }

        header .logo img {
            width: 40px;
            height: 30px;
        }
    }

    @media only screen and (max-width: 768px) {}

    @media only screen and (max-width: 576px) {}

    /* banner section start */

    section.banner {
        padding: 100px 0;
    }

    section.banner .container {
        max-width: 1140px;
    }

    .white-box {
        background: #FFFFFF;
        box-shadow: 0px 0px 20px 20px rgba(0, 0, 0, 0.25);
        border-radius: 40px;
        padding: 60px 100px;
    }

    .banner-heading {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        justify-content: center;
        height: 100%;
    }

    .banner-heading h2 {
        font-style: normal;
        font-weight: 700;
        font-size: 38px;
        line-height: 55px;
        max-width: 470px;
        padding-bottom: 15px;
    }

    .banner-heading p {
        font-style: normal;
        font-weight: 400;
        font-size: 20px;
        line-height: 30px;
        max-width: 430px;
        padding-bottom: 15px;
        color: var(--paragraph);
    }

    .banner-heading a {
        background: #FF9B06;
        border-radius: 50px;
        padding: 4px 40px;
        color: #FFFFFF;
        font-style: normal;
        font-weight: 500;
        font-size: 24px;
        line-height: 50px;
        display: inline-block;
        transition: .5s;
    }

    .banner-heading a:hover {
        background: #00288A;
    }

    .hero-img img {
        width: 100%;
    }

    /* banner section media querry start */

    @media only screen and (max-width: 1199px) {}

    @media only screen and (max-width: 991px) {
        .white-box {
            padding: 40px 80px;
        }

        section.banner {
            padding: 70px 0;
        }

        .banner-heading h2 {
            font-size: 32px;
            line-height: 46px;
            max-width: 400px;
            padding-bottom: 10px;
        }

        .banner-heading p {
            font-size: 16px;
            line-height: 22px;
            max-width: 320px;
            padding-bottom: 10px;
        }

        .banner-heading a {
            padding: 4px 30px;
            font-size: 18px;
            line-height: 40px;
        }
    }

    @media only screen and (max-width: 767px) {
        .white-box {
            padding: 30px 60px;
        }

        section.banner {
            padding: 40px 0;
        }

        .banner-heading h2 {
            font-size: 22px;
            line-height: 32px;
            max-width: 260px;
            padding-bottom: 5px;
        }

        .banner-heading p {
            font-size: 14px;
            line-height: 20px;
            max-width: 270px;
            padding-bottom: 8px;
        }

        .banner-heading a {
            padding: 3px 20px;
            font-size: 14px;
            line-height: 28px;
        }
    }

    @media only screen and (max-width: 575px) {
        .white-box {
            padding: 20px;
        }

        section.banner {
            padding: 30px 0;
        }

        /* .banner-heading h2 {
        font-size: 16px;
        line-height: 22px;
        max-width: 180px;
        padding-bottom: 3px;
    }
    .banner-heading p {
        font-size: 12px;
        line-height: 16px;
        max-width: 200px;
        padding-bottom: 5px;
    }
    .banner-heading a {
        padding: 3px 10px;
        font-size: 12px;
        line-height: 21px;
    } */

        .banner-heading {
            align-items: center;
            padding-bottom: 10px;
        }

        .banner-heading h2 {
            text-align: center;
            font-size: 16px;
            line-height: 24px;
            max-width: 100%;
        }

        .banner-heading p {
            text-align: center;
            font-size: 12px;
            line-height: 16px;
            max-width: 100%;
        }

        .banner-heading a {
            padding: 3px 20px;
            font-size: 12px;
            line-height: 22px;
        }
    }

    /* section step of qr satrt */

    section.step-of-qr {
        background: #00288A;
        padding: 20px 0;
    }

    section.step-of-qr .container {
        max-width: 1440px;
    }

    h2.step-heading {
        text-align: center;
        color: #FFFFFF;
        font-style: normal;
        font-weight: 700;
        font-size: 38px;
        line-height: 55px;
        padding-bottom: 80px;
        position: relative;
        z-index: 999;
    }

    h2.step-heading:after {
        content: "";
        position: absolute;
        top: 27px;
        right: 200px;
        width: 280px;
        height: 30px;
        background: #FF9B06;
        z-index: -1;
    }

    .squre-box h4 {
        background: #FFFFFF;
        font-weight: 700;
        font-size: 32px;
        line-height: 42px;
        padding: 20px 40px;
        color: #00288A;
    }

    .steps h3 {
        font-weight: 500;
        font-size: 24px;
        line-height: 30px;
        color: #FFFFFF;
        max-width: 290px;
        text-align: center;
        padding-bottom: 10px;
    }

    .steps p {
        font-weight: 400;
        font-size: 18px;
        line-height: 34px;
        color: #FFFFFF;
        text-align: center;
        max-width: 270px;
    }

    .steps {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .step-for-qr {
        display: flex;
        justify-content: space-around;
    }

    .squre-box {
        padding-bottom: 30px;
        filter: drop-shadow(0px 4px 4px rgba(0, 0, 0, 0.25));
    }

    /* step of qr section media querry start */

    @media only screen and (max-width: 1368px) {
        h2.step-heading:after {
            right: 160px;
        }
    }

    @media only screen and (max-width: 1280px) {
        h2.step-heading:after {
            right: 120px;
            top: 20;
        }
    }

    @media only screen and (max-width: 1280px) {
        h2.step-heading:after {
            right: 70px;
        }
    }

    @media only screen and (max-width: 1199px) {
        h2.step-heading:after {
            right: 80px;
        }
    }

    @media only screen and (max-width: 1024px) {
        h2.step-heading:after {
            right: 0px;
        }
    }

    @media only screen and (max-width: 991px) {
        h2.step-heading {
            font-size: 32px;
            line-height: 46px;
            padding-bottom: 60px;
        }

        h2.step-heading:after {
            right: 60px;
            width: 230px;
            height: 25px;
            top: 20px;
        }

        .squre-box {
            padding-bottom: 20px;
        }

        .squre-box h4 {
            font-size: 26px;
            line-height: 36px;
        }

        .steps h3 {
            font-size: 20px;
            line-height: 25px;
            max-width: 220px;
        }

        .steps p {
            font-size: 16px;
            line-height: 25px;
            max-width: 240px;
        }
    }

    @media only screen and (max-width: 767px) {
        h2.step-heading {
            font-size: 22px;
            line-height: 32px;
            padding-bottom: 40px;
        }

        h2.step-heading:after {
            right: 86px;
            width: 150px;
            height: 20px;
            top: 15px;
        }

        .squre-box h4 {
            font-size: 22px;
            line-height: 28px;
            padding: 15px 30px;
        }

        .squre-box {
            padding-bottom: 15px;
        }

        .steps h3 {
            font-size: 16px;
            line-height: 23px;
            max-width: 170px;
            padding-bottom: 5px;
        }

        .steps p {
            font-size: 14px;
            line-height: 22px;
            max-width: 210px;
        }
    }

    @media only screen and (max-width: 575px) {
        h2.step-heading {
            font-size: 16px;
            line-height: 24px;
            padding-bottom: 30px;
        }

        .squre-box h4 {
            font-size: 18px;
            line-height: 22px;
            padding: 10px 20px;
        }

        .squre-box {
            padding-bottom: 10px;
        }

        .steps h3 {
            font-size: 14px;
            line-height: 20px;
            max-width: 150px;
        }

        .steps p {
            font-size: 12px;
            line-height: 18px;
            max-width: 160px;
        }

        h2.step-heading:after {
            width: 100px;
            height: 10px;
            top: 12px;
        }

        h2.step-heading:after {
            display: none;
        }
    }

    @media only screen and (max-width: 480px) {
        h2.step-heading:after {
            right: 27px;
        }

        .step-for-qr {
            flex-direction: column;
        }

        .steps h3 {
            max-width: 100%;
        }

        .steps p {
            max-width: 100%;
        }

        .steps {
            padding-bottom: 10px;
        }
    }

    /*  marketing features section start */

    section.marketing-features {
        padding: 100px 0;
    }

    section.marketing-features .container {
        max-width: 1140px;
    }

    .marketing-heading {
        padding-bottom: 100px;
    }

    .marketing-heading h2 {
        text-align: center;
        color: #000000;
        font-style: normal;
        font-weight: 700;
        font-size: 38px;
        line-height: 55px;
        padding-bottom: 10px;
        position: relative;
    }

    .marketing-heading p {
        font-style: normal;
        font-weight: 400;
        font-size: 20px;
        line-height: 30px;
        text-align: center;
        color: #000000;
    }

    .features-boxes {
        position: relative;
    }

    .features-boxes::before {
        position: absolute;
        content: "";
        background-image: url(./themes/altum/assets/images/yellowdots.png);
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
        background-image: url(./themes/altum/assets/images/blue-dots.png);
        background-repeat: no-repeat;
        height: 250px;
        width: 250px;
        top: -140px;
        right: -114px;
        z-index: -1;
    }

    .feature-box {
        display: flex;
        align-items: center;
        padding: 20px 40px;
        background: #FFFFFF;
        box-shadow: 0px 20px 10px rgba(0, 0, 0, 0.25);
        border-radius: 30px;
        margin-bottom: 40px;
        transition: .5s;
    }

    .feature-box:hover {
        background: #FFB74D;
    }

    .icon {
        margin-right: 20px;
    }

    .icon i {
        font-size: 18px;
        background: #00288A;
        padding: 15px;
        color: white;
        border-radius: 50%;
    }

    .features h5 {
        font-style: normal;
        font-weight: 700;
        font-size: 16px;
        line-height: 22px;
        color: #000000;
    }

    .features p {
        font-style: normal;
        font-weight: 400;
        font-size: 14px;
        line-height: 21px;
        color: #000000;
    }

    /* marketing features section media querry start */

    @media only screen and (max-width: 1199px) {

        .features-boxes::after {
            width: 200px;
            height: 200px;
            right: -15px;
            top: -80px;
        }

        .features-boxes::before {
            height: 200px;
            width: 200px;
            left: -10px;
        }

        .marketing-heading {
            padding-bottom: 80px;
        }

    }

    @media only screen and (max-width: 991px) {
        section.marketing-features {
            padding: 70px 0;
        }

        .marketing-heading h2 {
            font-size: 32px;
            line-height: 46px;
        }

        .marketing-heading p {
            font-size: 18px;
            line-height: 22px;
        }

        .features h5 {
            font-size: 14px;
            line-height: 18px;
        }

        .features p {
            font-size: 12px;
            line-height: 14px;
        }

        .icon i {
            font-size: 16px;
            padding: 13px;
        }

        .feature-box {
            padding: 15px 20px;
        }

        .icon {
            margin-right: 10px;
        }

        .marketing-heading {
            padding-bottom: 60px;
        }
    }

    @media only screen and (max-width: 767px) {
        section.marketing-features {
            padding: 40px 0;
        }

        .marketing-heading h2 {
            font-size: 22px;
            line-height: 31px;
        }

        .marketing-heading p {
            font-size: 16px;
            line-height: 18px;
        }

        .marketing-heading {
            padding-bottom: 40px;
        }

        .features-boxes::after {
            height: 120px;
            top: -30px;
        }
    }

    @media only screen and (max-width: 575px) {
        section.marketing-features {
            padding: 20px 0;
        }

        .marketing-heading h2 {
            font-size: 16px;
            line-height: 24px;
            padding-bottom: 5px;
        }

        .marketing-heading p {
            font-size: 14px;
            line-height: 15px;
        }

        .features-boxes::before {
            display: none;
        }

        .features-boxes::after {
            display: none;
        }
    }

    /* analys qr section start */

    section.analys-qr {
        background: #00288A;
        padding: 40px 0;
    }

    section.analys-qr.container {
        max-width: 1150px;
    }

    /* analysis-heading {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    width: 100px;
    } */

    .analysis-heading h2 {
        text-align: center;
        font-style: normal;
        font-weight: 700;
        font-size: 38px;
        line-height: 55px;
        color: #FFFFFF;
        padding-bottom: 26px;
        z-index: 99;
        position: relative;
    }

    .analysis-heading h2::after {
        position: absolute;
        top: 9px;
        right: 180px;
        width: 180px;
        height: 40px;
        content: "";
        background: #FF9B06;
        z-index: -1;
    }

    .analysis-heading p {
        font-style: normal;
        font-weight: 400;
        font-size: 20px;
        line-height: 30px;
        text-align: center;
        color: #FFFFFF;
        padding-bottom: 20px;
    }



    .section__slogan {
        display: flex;
        align-items: center;
        gap: 10px;
        width: max-content;
        background: lightgray;
        border-radius: 0px;
        padding: 0 20px;
        margin-bottom: 40px;
        color: #21325e;
    }

    .section__slogan img {
        width: 30px;
        height: 30px;
    }

    h2.section__heading.heading--2 {
        padding-bottom: 100px;
    }

    .section__caption {
        margin-bottom: 50px;
        font-size: 17px;
    }

    .section__slogan--center {
        margin-left: auto;
        margin-right: auto;
    }

    .btn {
        text-decoration: none;
        display: inline-block;
        border-radius: 0px;
        min-width: 190px;
        padding: 19px 42px;
        text-align: center;
        font-size: 20px;
    }

    .btn--primary {
        background: #00288A;
        border: 2px solid #00288A;
        color: #fff;
    }

    .btn--primary:hover,
    .btn--primary:focus {
        background: #fff;
        border: 2px solid #21325e;
        color: #21325e;
    }

    /* ===== SECTION EXPERTISE ===== */
    /* preview box tab strt */

    button:focus,
    input:focus {
        outline: none;
        box-shadow: none;
    }

    /*--------------------*/
    .category-lists-slider {
        position: relative;
    }

    #catgory-slider .swiper-slide {
        width: auto;
    }

    .category-button {
        text-align: center;
        display: inline-block;
        cursor: pointer;
        user-select: none;
    }

    .category-button img {
        max-width: 100px;
    }

    .category-button.active {
        border-radius: 15px;
        border: 3px solid #FF9B06;
    }

    .data-text {
        display: none;
    }

    .data-text.active {
        display: block;
        background: #fff;
        border-radius: 20px;
        padding: 20px 40px;
    }

    /* .data-text h6 {
            font-size: 18px;
            margin-top: 30px;
            margin-bottom: 8px;
            font-weight: 700;
        } */

    .slider-button {
        width: 25px;
        height: 25px;
        background-color: #FF9B06;
        box-shadow: 0px 2px 4px rgb(0 0 0 / 30%);
        border-radius: 50%;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        position: absolute;
        top: 5px;
        z-index: 1;
        cursor: pointer;
    }

    .slider-button.slider-prev {
        left: -30px;
    }

    .slider-button.slider-next {
        right: -30px;
    }

    .slider-button.swiper-button-disabled {
        opacity: 0;
        visibility: hidden;
    }

    .box {
        padding: 10px;
        margin-top: 20px;
        border-radius: 6px;
        transition: 0.3s;
        height: 100%;
    }

    .box img {
        width: 100%;
    }

    .box h4 {
        font-size: 32px;
        font-weight: 800;
        margin-bottom: 50px;
    }

    .box p {
        font-size: 18px;
        margin-bottom: 50px;
    }

    .btn-create {
        background: #00288A;
        padding: 15px 35px;
        color: #fff;
        font-size: 18px;
        display: inline-block;
        transition: .5s;
    }

    .btn-create:hover {
        background: #FF9B06;
        color: #fff;
    }

    .box i {
        font-size: 40px;
        margin-bottom: 20px;
        color: #37a7f1;
    }


    /* preview box tab end */

    /* media querry start */

    @media only screen and (max-width: 1199px) {
        .analysis-heading h2::after {
            right: 95px;
        }
    }

    @media only screen and (max-width: 991px) {
        .container {
            max-width: 100%;
        }

        .analysis-heading h2 {
            font-size: 32px;
            line-height: 46px;
            padding-bottom: 20px;
        }

        .analysis-heading h2::after {
            right: 170px;
            width: 150px;
            top: 5px;
        }


        .analysis-heading p {
            font-size: 18px;
            line-height: 27px;
            padding-bottom: 30px;
        }

        h2.section__heading.heading--2 {
            padding-bottom: 50px;
            font-size: 26px;
        }

        .section__caption {
            margin-bottom: 30px;
            font-size: 15px;
        }

        a.btn.btn--primary {
            font-size: 18px;
            padding: 14px 32px;

        }
    }

    @media only screen and (max-width: 767px) {


        .analysis-heading h2 {
            font-size: 22px;
            line-height: 31px;
        }

        .analysis-heading h2::after {
            right: 160px;
            width: 97px;
            top: 0px;
            height: 30px;
        }

        .analysis-heading p {
            font-size: 16px;
            line-height: 24px;
            padding-bottom: 40px;
        }

        h2.section__heading.heading--2 {
            padding-bottom: 30px;
            font-size: 22px;
        }

        .section__caption {
            margin-bottom: 20px;
            font-size: 13px;
        }

        a.btn.btn--primary {
            font-size: 16px;
            padding: 10px 22px;
        }

        .box {
            text-align: center;
            padding: 0;
        }

        .box h4 {
            font-size: 22px;
            font-weight: 800;
            margin-bottom: 30px;
        }

        .box p {
            font-size: 16px;
            margin-bottom: 30px;
        }

        .btn-create {
            padding: 10px 25px;
            font-size: 16px;
        }
    }

    @media only screen and (max-width: 575px) {

        .analysis-heading h2::after {
            display: none;
        }

        .analysis-heading h2 {
            font-size: 16px;
            line-height: 24px;
            padding-bottom: 10px;
        }

        .analysis-heading p {
            font-size: 14px;
            line-height: 22px;
            padding-bottom: 6px;
        }

        .category-lists-slider {
            margin-top: 40px;
        }

        .slider-button {
            top: -40px;
        }

        .slider-button.slider-prev {
            left: inherit;
            right: 32px;
        }

        .slider-button.slider-next {
            right: 0;
        }

        .data-text.active {
            padding: 10px;
        }

        .box {
            text-align: center;
            padding: 0;
            border-radius: 0;
        }

        .box h4 {
            margin-bottom: 20px;
        }

        .box p {
            margin-bottom: 20px;
        }
    }


    /* ===== SECTION EXPERTISE end ===== */





    /* know more section start */

    section.know-more {
        background: #fff;
        padding: 40px 0;
    }

    section.know-more .container {
        max-width: 1440px;
    }

    .know-more-heading {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .know-more-heading::after {
        position: absolute;
        content: "";
        top: 35px;
        right: -139px;
        width: 270px;
        height: 200px;
        background-image: url(./themes/altum/assets/images/darkdots.png);
        background-repeat: no-repeat;
    }

    .know-more-heading h2 {
        font-style: normal;
        font-weight: 700;
        font-size: 38px;
        line-height: 55px;
        color: #000000;
        padding-bottom: 26px;
        position: relative;
        z-index: 99;
    }

    .know-more-heading h2:after {
        position: absolute;
        top: 20px;
        left: 160px;
        content: "";
        height: 30px;
        width: 240px;
        background: #FF9B06;
        z-index: -1;
    }

    .know-more-heading p {
        font-style: normal;
        font-weight: 400;
        font-size: 20px;
        line-height: 30px;
        text-align: center;
        color: #000000;
        max-width: 430px;
        padding-bottom: 26px;
    }

    .know-more-heading a {
        background: #00288A;
        color: #FFFFFF;
        font-size: 16px;
        padding: 10px 25px;
        border-radius: 20px;
        filter: drop-shadow(0px 20px 10px rgba(0, 0, 0, 0.5));
    }

    /* media query start */

    @media only screen and (max-width: 1199px) {
        .know-more-heading::after {
            right: -15px;
        }
    }

    @media only screen and (max-width: 991px) {
        .know-more-heading::after {
            width: 200px;
            top: -5px;
        }

        .know-more-heading h2 {
            font-size: 32px;
            line-height: 45px;
            padding-bottom: 20px;
        }

        .know-more-heading h2:after {
            width: 210px;
            left: 130px;
            height: 25px;
        }

        .know-more-heading p {
            font-size: 18px;
            line-height: 24px;
            padding-bottom: 20px;
        }

        .know-more-heading a {
            font-size: 14px;
            padding: 10px 20px;
        }

    }

    @media only screen and (max-width: 767px) {

        .know-more-heading::after {
            width: 140px;
            height: 140px;
            top: 10px;
        }

        .know-more-heading h2 {
            font-size: 22px;
            line-height: 32px;
            padding-bottom: 10px;
        }

        .know-more-heading h2:after {
            width: 150px;
            left: 90px;
            height: 18px;
            top: 15px;
        }

        .know-more-heading p {
            font-size: 16px;
            line-height: 22px;
            padding-bottom: 10px;
        }

        .know-more-heading a {
            font-size: 12px;
        }
    }

    @media only screen and (max-width: 575px) {
        .know-more-heading::after {
            display: none;
        }

        section.know-more {
            padding: 20px 0;
        }

        .know-more-heading h2 {
            font-size: 16px;
            line-height: 24px;
            padding-bottom: 5px;
        }

        .know-more-heading h2:after {
            display: none;
        }

        .know-more-heading p {
            font-size: 14px;
            line-height: 18px;
        }

        .know-more-heading h2:after {
            display: none;
        }

    }

    /* basic-concept section start */

    section.basic-concept {
        padding: 100px 0;
    }

    section.basic-concept h2 {
        text-align: center;
        font-style: normal;
        font-weight: 700;
        font-size: 38px;
        line-height: 55px;
        color: #ffffff;
        padding-bottom: 26px;
        position: relative;
        z-index: 99;
    }

    section.basic-concept h2::before {
        position: absolute;
        top: 4px;
        left: 280px;
        height: 40px;
        width: 550px;
        content: "";
        background: #FF9B06;
        z-index: -1;
    }

    .accordion {
        width: 100%;
        display: flex;
        flex-direction: column;
    }

    .accordion__button {
        border: none;
        padding: 30px;
        display: flex;
        background-color: #FFFFFF;
        border-radius: 10px;
        cursor: pointer;
        align-items: center;
        justify-content: space-between;
        text-align: left;
        transition: all 100ms linear;
        box-shadow: 0px 20px 10px rgba(0, 0, 0, 0.25);
        margin-bottom: 40px;
        font-size: 20px;
    }

    .accordion__button:hover {
        --accordion__button_bd-cr: var(--white-3);
    }

    p.accordion__content.active {
        background: #fff;
        margin-bottom: 40px;
        border-radius: 10px;
        font-size: 16px;
    }

    .accordion__content {
        padding: 1em;
    }

    .accordion__content:not(.active) {
        display: none;
    }

    .rmbg {
        background: transparent;
        box-shadow: none;
        margin-bottom: 0;
        padding: 20px;
    }

    p.rmbg.active {
        background: transparent;
        box-shadow: none;
        margin-bottom: 0;
        padding: 20px;
    }

    .create-qr-code {
        background: #00288A;
        color: #fff;
        padding: 20px 50px;
        border-radius: 30px;
        transition: .5s;
        display: inline-block;
        font-size: 18px;
    }

    .create {
        text-align: center;
        margin-top: 100px;
    }

    .create-qr-code:hover {
        background: #FF9B06;
        color: #fff;
    }


    /* faq page css */

    section.FAQ {
        padding: 100px 0;
    }

    section.FAQ .container {
        max-width: 1140px;
    }

    .faq-heading {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .faq-heading h2 {
        font-style: normal;
        font-weight: 700;
        font-size: 38px;
        line-height: 55px;
        color: #000000;
        padding-bottom: 26px;
        text-align: center;
    }

    .faq-heading p {
        font-style: normal;
        font-weight: 400;
        font-size: 20px;
        line-height: 30px;
        text-align: center;
        color: #000000;
        max-width: 700px;
    }

    .accrodian {
        padding-top: 30px;
    }

    /* accrodian media querry start */

    @media only screen and (max-width: 1199px) {
        section.basic-concept h2::before {
            left: 190px;
        }
    }

    @media only screen and (max-width: 991px) {
        section.basic-concept {
            padding: 80px 0;
        }

        section.basic-concept h2 {
            font-size: 32px;
            line-height: 45px;
            padding-bottom: 20px;
        }

        section.basic-concept h2::before {
            left: 240px;
            width: 470px;
            top: 2px;
        }

        .accordion__button {
            padding: 25px;
            margin-bottom: 30px;
        }

        p.accordion__content.active {
            margin-bottom: 30px;
            font-size: 16px;
        }

        .create {
            margin-top: 50px;
        }

        section.FAQ {
            padding: 50px 0;
        }
    }

    @media only screen and (max-width: 767px) {
        section.basic-concept {
            padding: 60px 0;
        }

        section.basic-concept h2 {
            font-size: 22px;
            line-height: 32px;
            padding-bottom: 10px;
        }

        section.basic-concept h2::before {
            left: 213px;
            width: 310px;
            top: 0px;
            height: 30px;
        }

        .accordion__button {
            padding: 20px;
            margin-bottom: 20px;
        }

        p.accordion__content.active {
            margin-bottom: 20px;
            font-size: 14px;
        }

        .create-qr-code {
            padding: 15px 20px;
            font-size: 16px;
        }

        .create {
            margin-top: 20px;
        }

        section.FAQ {
            padding: 20px 0;
        }

        .faq-heading h2 {
            font-size: 26px;
            padding-bottom: 15px;
            line-height: 25px;
        }

        .faq-heading p {
            font-size: 16px;
            max-width: 100%;
            line-height: 26px;
        }
    }

    @media only screen and (max-width: 575px) {

        section.basic-concept h2::before {
            display: none;
        }

        .accordion__button {
            padding: 10px;
            margin-bottom: 15px;
            font-size: 14px;
        }

        p.accordion__content.active {
            margin-bottom: 15px;
            font-size: 12px;
        }

        section.basic-concept {
            padding: 30px 0;
        }

        section.basic-concept h2 {
            font-size: 16px;
            line-height: 24px;
            padding-bottom: 8px;
            color: #000000;
        }

    }

    /* creation of qr */


    section.creation-of-qr {
        padding: 20px 0 80px;
    }

    .creation-of-qr h2 {
        text-align: center;
        font-style: normal;
        font-weight: 700;
        font-size: 38px;
        line-height: 55px;
        color: #000000;
        padding: 70px 0 26px 0;
        position: relative;
    }

    /* creation of qr media querry start  */


    @media only screen and (max-width: 1199px) {}

    @media only screen and (max-width: 991px) {
        .creation-of-qr h2 {
            font-size: 32px;
            line-height: 45px;
        }
    }

    @media only screen and (max-width: 767px) {
        .creation-of-qr h2 {
            font-size: 22px;
            line-height: 32px;
            padding: 50px 0 26px 0;
        }

        section.creation-of-qr {
            padding: 20px 0 50px;
        }
    }

    @media only screen and (max-width: 575px) {
        .creation-of-qr h2 {
            font-size: 16px;
            line-height: 24px;
            padding: 30px 0 16px 0;
        }
    }




    /* generator section start */

    section.generator {
        padding: 100px 0;
        background: #FF9B06;
    }

    section.generator .container {
        max-width: 1140px;
    }

    .generator-heading h2 {
        font-style: normal;
        font-weight: 700;
        font-size: 38px;
        line-height: 55px;
        color: #fff;
    }

    .generator-heading a {
        font-size: 18px;
        background: #00288A;
        padding: 10px 55px;
        border-radius: 30px;
        color: #FFFFFF;
        border: solid 1px #00288A;
        display: inline-block;
        transition: .5s;
    }

    .generator-heading a:hover {
        background: transparent;
        border: 1px solid #fff;
        color: #fff;
    }

    .generator-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    /* generator section media querry start */

    @media only screen and (max-width: 1199px) {
        section.generator {
            padding: 80px 0;
        }
    }

    @media only screen and (max-width: 991px) {
        section.generator {
            padding: 60px 0;
        }

        .generator-heading h2 {
            font-size: 32px;
            line-height: 46px;
        }

        .generator-heading a {
            font-size: 16px;
        }
    }

    @media only screen and (max-width: 767px) {
        section.generator {
            padding: 40px 0;
        }

        .generator-heading h2 {
            font-size: 22px;
            line-height: 32px;
        }

        .generator-heading a {
            padding: 8px 45px;
        }
    }

    @media only screen and (max-width: 575px) {
        section.generator {
            padding: 20px 0;
        }

        .generator-heading h2 {
            font-size: 16px;
            line-height: 24px;
        }

        .generator-heading a {
            font-size: 14px;
            padding: 6px 25px;
        }
    }

    /* footer section start */

    footer {
        background: #00288A;
        padding: 80px 0;
    }

    footer .container {
        max-width: 1140px;
    }

    footer h4 {
        font-size: 24px;
        line-height: 26px;
        color: #FFFFFF;
        padding-bottom: 30px;
    }

    .footer-menu li {
        padding-bottom: 10px;
    }

    .footer-menu a {
        font-size: 16px;
        color: #FFFFFF;
        transition: .5s;
    }

    .footer-menu a:hover {
        color: #FF9B06;
    }

    .footer-logo {
        margin-top: -50px;
    }

    .footer-logo img {
        width: 100%;
    }

    .social-media i,
    .social-media a {
        font-size: 16px;
        color: #00288A;
        background: #FFFFFF;
        padding: 10px;
        border-radius: 10px;
        cursor: pointer;
        transition: .5s;
        margin-right: 5px;
    }

    .social-media i:hover,
    .social-media a:hover {
        background: #FF9B06;
        color: #FFFFFF;
    }

    .terms {
        text-align: center;
        font-size: 16px;
        margin-top: 20px;
        border-top: 1px solid #fff;
        padding-top: 20px;
        color: #fff;
    }

    /* footer media querry start */

    @media only screen and (max-width: 1199px) {}

    @media only screen and (max-width: 991px) {
        footer {
            padding: 60px 0;
        }

        footer h4 {
            font-size: 20px;
            line-height: 20px;
            padding-bottom: 20px;
        }

        .footer-menu li {
            padding-bottom: 5px;
        }

        .social-media i {
            font-size: 14px;
            padding: 10px;
        }
    }

    @media only screen and (max-width: 767px) {
        footer {
            padding: 40px 0;
        }

        footer h4 {
            font-size: 18px;
            line-height: 16px;
            padding-bottom: 15px;
        }

        .footer-menu a {
            font-size: 14px;
        }

        .footer-logo {
            margin-top: 0px;
        }

        .terms {
            font-size: 14px;
        }

        .social-media i {
            font-size: 12px;
            padding: 6px;
        }
    }

    @media only screen and (max-width: 575px) {
        footer {
            padding: 20px 0;
            text-align: center;
        }

        footer h4 {
            font-size: 16px;
            line-height: 14px;
            padding-bottom: 10px;
        }

        .terms {
            font-size: 12px;
        }

        .social-media {
            padding-bottom: 15px;
        }

        .footer-menu a {
            font-size: 12px;
        }

        .padding {
            padding-bottom: 20px;
        }

        /* .text-center {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        } */
    }


    /*Sidebar Navigation Menu Style Here*/
    .sidenav {
        height: 100%;
        width: 0;
        position: fixed;
        z-index: 1;
        top: 0;
        left: 0;
        background-color: #fffcfc;
        overflow-x: hidden;
        transition: 0.5s;
        padding-top: 60px;
    }

    .sidenav a {
        padding: 8px 8px 8px 32px;
        text-decoration: none;
        font-size: 25px;
        color: #818181;
        display: block;
        transition: 0.3s;
    }

    .sidenav a:hover {
        color: #181616;
    }

    .sidenav .closebtn {
        position: absolute;
        top: 0;
        right: 25px;
        font-size: 36px;
        margin-left: 50px;
    }

    @media screen and (max-height: 450px) {
        .sidenav {
            padding-top: 15px;
        }

        .sidenav a {
            font-size: 18px;
        }
    }

    /*
 * And let's slide it in from the left
 */


    /* uday 's code */

    @media (max-width: 480px) {
        .mobile {
            display: block;
        }

        .desktop {
            display: none;
        }


    }

    @media (min-width: 481px) and (max-width: 767px) {

        .mobile {
            display: block;
        }

        .desktop {
            display: none;
        }

    }

    @media (min-width: 768px) and (max-width: 1024px) {

        header span {
            padding: unset;
        }


        .jss1456 {
            margin-top: unset;
            margin-bottom: unset;
            white-space: nowrap;

        }


        .mobile {
            display: none;

        }

        .desktop {
            display: block;
        }
    }

    @media (min-width: 1025px) and (max-width: 1280px) {

        header span {
            padding: unset;
        }


        .mobile {
            display: none;

        }

        .desktop {
            display: block;
        }

        .jss1456 {
            margin-top: unset;
            margin-bottom: unset;
            white-space: nowrap;

        }
    }

    @media (min-width: 1281px) {

        header span {
            padding: unset;
        }


        .mobile {
            display: none;

        }

        .desktop {
            display: block;
        }

        .jss1456 {
            margin-top: unset;
            margin-bottom: unset;
            white-space: nowrap;

        }
    }

    @media (min-width: 1920px) {

        header span {
            padding: unset;
        }




        .mobile {
            display: none;

        }

        .desktop {
            display: block;
        }

        .jss1456 {
            margin-top: unset;
            margin-bottom: unset;
            white-space: nowrap;

        }
    }
</style>

<script>
    function openNav() {
        document.getElementById("mySidenav").style.width = "300px";
    }

    function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
    }
</script>