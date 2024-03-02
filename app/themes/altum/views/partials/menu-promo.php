<?php defined('ALTUMCODE') || die() ?>



<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
<!-- font-awesome  -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<link href="<?= ASSETS_FULL_URL . 'css/custom_dash.css?v=' . PRODUCT_CODE ?>" rel="stylesheet" media="screen,print">
<link href="<?= ASSETS_FULL_URL . 'css/billing-header.css?v=' . PRODUCT_CODE ?>" rel="stylesheet" media="screen,print">

<style>
    .-link-language {
        display: flex;
        align-items: center;
        flex-grow: 1;
        gap: 9.5px;
    }
</style>
<header class="main-header-wrp plans-header-wrp">
    <div class="container">
        <nav class="billing-nav">
            <a href="<?= url() ?>">
                <div class="logo">
                    <?php if (settings()->main->{'logo_' . \Altum\ThemeStyle::get()} != '') : ?>
                        <!-- <img src="<?= ASSETS_FULL_URL . 'images/new-qr-logo.webp' ?>" class="dashboard_logo mt-0" alt="<?= l('qr_codes.accessibility.logo_alt') ?>" /> -->
                        <img src="<?= ASSETS_FULL_URL . 'images/new-qr-logo.webp' ?>" class="dashboard_logo mt-0" alt="<?= l('qr_codes.accessibility.logo_alt') ?>" />
                    <?php else : ?>
                        <?= settings()->main->title ?>
                    <?php endif ?>
                </div>
            </a>

            <?php

            if (isset($_GET['id'])) {
                $user  = db()->where('referral_key', $_GET['id'])->getOne('users');
            }

            ?>

            <div class="billing-block">
                <nav aria-label="breadcrumb ">
                    <ol class="custom-breadcrumbs small mb-0">
                        <li class="active">

                            <div>
                                <span class="number">1</span>
                                <span class="text d-lg-block -md-none"><?= l('plans_and_prices.header_nav_1') ?></span>
                                <div class="arrow-block"><i class="fa fa-fw fa-angle-right arrow-head"></i></div>
                            </div>
                        </li>

                        <?php if ($user->onboarding_funnel == 4) : ?>
                            <li>
                                <div>
                                    <span class="number">2</span>
                                    <span class="text d-lg-block -md-none"><?= l('plans_and_prices.header_nav_3') ?></span>
                                </div>
                            </li>
                        <?php else : ?>

                            <li>
                                <div>
                                    <span class="number">2</span>
                                    <span class="text d-lg-block -md-none"><?= l('plans_and_prices.header_nav_2') ?></span>
                                    <div class="arrow-block"><i class="fa fa-fw fa-angle-right arrow-head"></i></div>
                                </div>
                            </li>

                            <li>
                                <div>
                                    <span class="number">3</span>
                                    <span class="text d-lg-block -md-none"><?= l('plans_and_prices.header_nav_3') ?></span>
                                </div>
                            </li>

                        <?php endif ?>
                    </ol>
                </nav>
            </div>

            <div class="d-flex right-options-wrp">
                <a href="<?= url('faq') ?> " class="-link-language">
                    <img src="<?= ASSETS_FULL_URL . 'images/message-question.svg' ?>" alt="">
                </a>
            </div>
        </nav>
    </div>
    <div class="black-friday-full-wrap dpf-black-friday d-none plan-friday-wrap">
        <div class="friday-wrap d-flex justify-content-center align-items-center">
            <div class="friday-text-wrap">
                <span class="friday-text"><?= l('plan_card.black_friday_text_1') ?><span class="color-text"><?= l('plan_card.black_friday_text_3') ?></span></span>
            </div>
        </div>
    </div>
</header>