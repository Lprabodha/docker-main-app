<?php defined('ALTUMCODE') || die() ?>

<div class="container-fluid pay-thank-wrap mt-3">
    <?= \Altum\Alerts::output_alerts() ?>

    <div class="thank-you">
        <!-- <img src="<?= ASSETS_FULL_URL . 'images/thank_you.svg' ?>" class="col-10 col-md-6 col-lg-4 mb-4" alt="
        
        
        <?= l('pay_dpf.thankyou_header') ?>" /> -->

        <h2 class="thank-header"><?= l('pay_dpf.thankyou_header') ?></h2>

        <?php if (isset($_GET['schedule_id'])) : ?>
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 ">
                    <h3 class="thank-subhead"><?= l('pay_dpf.thankyou_subheader_1') ?></h3>
                </div>
            </div>

        <?php elseif (isset($_GET['reactive_schedule_id'])) : ?>
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 ">
                    <h3 class="thank-subhead"><?= l('pay_dpf.thankyou_subheader_1') ?></h3>
                </div>
            </div>
        <?php else : ?>

            <div class="row justify-content-center">
                <div class="col-12 col-md-8 ">
                    <h3 class="thank-subhead"><?= l('pay_dpf.thankyou_subheader_3') ?></h3>
                </div>
            </div>

        <?php endif ?>

        <div class="thank-btn-area">
            <?php if (isset($data->type) && $data->type == 'change') : ?>
                <?php if (Altum\Middlewares\Authentication::check()) : ?>
                    <a href="<?= url('qr-codes') ?>" class="btn thank-btn mt-4 mx-auto d-block" style="padding:10px 15px;"><?= l('pay_dpf.thankyou_button') ?></a>
                <?php else : ?>
                    <a href="<?= url('login') ?>" class="btn thank-btn mt-4 mx-auto d-block" style="padding:10px 15px;"><?= l('pay_dpf.thankyou_button') ?></a>
                <?php endif ?>
            <?php else : ?>
                <?php if (Altum\Middlewares\Authentication::check()) : ?>
                    <a href="<?= url('qr-codes') ?>" class="btn thank-btn mt-4 mx-auto d-block" style="padding:10px 15px;"><?= l('pay_dpf.submit') ?></a>
                <?php else : ?>
                    <a href="<?= url('login') ?>" class="btn thank-btn mt-4 mx-auto d-block" style="padding:10px 15px;"><?= l('pay_dpf.submit') ?></a>
                <?php endif ?>
            <?php endif ?>
        </div>
    </div>
</div>
<script>
    var isBackFromPay = sessionStorage.getItem("is_back");
    if (isBackFromPay) {
        sessionStorage.removeItem("is_back");
    }
</script>

