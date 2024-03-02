<?php defined('ALTUMCODE') || die() ?>
<link href="<?= ASSETS_FULL_URL . 'css/term-privacy.css?v=' . PRODUCT_CODE ?>" rel="stylesheet" media="screen,print">

<style>
    .cs-header {
        margin-bottom: 30px;
        margin-top: 30px;
    }
</style>

<div class="section-faq">

    <div class="-container">

        <h1 class="-section-title cs-header">
            <?= l('cancel_subscription.title') ?>
        </h1>

        <div class="termsContain">
            <div class="termsDetail">

                <p> <?= l('cancel_subscription.sub_content_1') ?></p>

                <h2 class="m-0"><?= l('cancel_subscription.subheading_1', SITE_URL) ?></h2>

                <p id="billingBtn">
                    <?= l('cancel_subscription.sub_content_1.1') ?>
                </p>


                <h2 class="m-0 mb-2"><?= l('cancel_subscription.subheading_2') ?></h2>

                <p>
                    <?= l('cancel_subscription.sub_content_2.1') ?>
                </p>

                <h2 class="m-0"><?= l('cancel_subscription.subheading_3') ?></h2>

                <p>
                    <?= l('cancel_subscription.sub_content_3.1') ?>
                </p>

                <h1 class="-section-title cs-header">
                    <?= l('cancel_subscription.title_2') ?>
                </h1>

                <p>
                    <?= l('cancel_subscription.sub_content_4') ?>
                </p>

                <p>
                    <?= l('cancel_subscription.sub_content_5') ?>
                </p>

            </div>

        </div>
    </div>
</div>