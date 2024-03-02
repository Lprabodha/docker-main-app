<?php defined('ALTUMCODE') || die() ?>

<div class="app-sidebar">
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
            <li class="<?= \Altum\Routing\Router::$controller == 'Qr' ? 'active' : null ?> create-qr-btn">
                <a 
                    href="<?= url('qr/') ?>" 
                    class="ps-4 create-qr-btn" 
                    <?= new DateTime($this->user->plan_expiration_date) < new DateTime() ? 'data-toggle="modal" data-target="#upgradePopup"' : '' ?>
                >
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

                <a href="<?= ($this->user->plan_id == 'free' &&  new DateTime($this->user->plan_expiration_date) < new DateTime() && $this->user->payment_processor == null) ? url('plan') : url('billing') ?>" class="ps-4">
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
            <hr class="m-auto mt-3 text-secondary ">
        </ul>
        <ul class="app-sidebar-links mb-2">
            <li style="padding: 3px 0 2px">
                <a href="<?= url('logout') ?>" class="py-2 ps-4 logout">
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
            } else if ((new DateTime()  > new DateTime($this->user->plan_expiration_date)) && $this->user->payment_processor != null) {
                $xp_countdown =  l('qr_codes.subscription_expired');
            } else {
                $xp_countdown =  l('qr_codes.trail_expired');
            }
            ?>

            <?php if ($this->user->plan_id == 'free' ||   new DateTime($this->user->plan_expiration_date) < new DateTime()) : ?>
                <div class="upgrade_area p-2 rounded">
                    <p class="text-center pt-4">
                        <?= $xp_countdown ?>
                    </p>
                    <a href="<?= $this->user->payment_processor != null ? url('plan/renew')   : url('plan') ?>"> <button type="button" class="btn primary-btn rounded w-75 shadow p-3 btn mx-auto d-block text-white fw-bold py-2 mt-3 mb-3"><?= l('qr_codes.upgrade_btn') ?></button></a>
                </div>
            <?php endif ?>
        </div>
    </div>

</div>