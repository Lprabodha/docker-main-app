<?php defined('ALTUMCODE') || die() ?>

<style>

    .unsub-wrap {
        height: 100vh;
        position: relative;
    }

    .unsub-content-wrap {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 100%;
        margin: auto;
    }

    .unsub-wrap .unsub-title {
        text-align: center;
    }

    .unsub-wrap .button-wrap {
        justify-content: center;
    }

    .unsub-wrap .button-wrap button {
        width: 255px;
        background-color: #28C254;
        color: white;
        font-weight: 600;
        font-size: 22px;
        height: 60px;
        margin-top: 57px;
        margin-bottom: 50px;
        border-radius: 10px;
    }

    .unsub-wrap .unsub-subtitle {
        font-size: 20px;
        padding-inline: 10px;
        align-items: center;
        justify-content: center;
        margin: auto;
    }

    .unsub-wrap .logo-wrap img {
        width: 260px;
    }

    .unsub-wrap hr {
        height: 2.5px;
        color: black;
        opacity: 0.5;
    }

    .unsub-wrap .unsub-content {
        width: 417px;
        margin: auto;
        display: block;
    }

    .unsub-wrap .unsub-form {
        display: flex;
        align-items: center;
        justify-content: center;
    }

</style>

<div class="unsub-wrap container">
    <div class="row unsub-content-wrap">
        <div class="unsub-content">
            <div class="row logo-wrap d-flex justify-content-center">
                <img src="<?= ASSETS_FULL_URL . 'images/new-qr-logo.png' ?>" class="" alt="" />
            </div>
            <div class="unsub-title row mt-5">
                <h3><?= l('email_unsubscribe.main_title'); ?></h3>
            </div>
            <div class="unsub-subtitle row d-flex text-center mt-4">
                <p><?= l('email_unsubscribe.subtitle'); ?></p>
            </div>
            <div class="row button-wrap">
                <form action="<?= url('email-unsubscribe/update') ?>" method="POST" class="unsub-form">
                    <input type="hidden" name="ref_key" value="<?= $data->ref_key ?>">
                    <button type="submit"><?= l('email_unsubscribe.button'); ?></button>
                </form>
            </div>
        </div>

        <hr>

        <div class="unsub-footer d-block m-auto text-center">
            <p>© Online QR Generator <?= l('email_unsubscribe.footer_text_1'); ?></p>
            <p><?= l('email_unsubscribe.footer_text_2'); ?></p>
        </div>
    </div>
</div>

