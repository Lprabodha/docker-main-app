<?php defined('ALTUMCODE') || die() ?>

<style>
    .card {
        margin: 20px;
        justify-content: center;
        align-items: center;
    }

    .container {
        padding: 2px 16px;
           
    }

    .icon {
        display: block;
        margin-left: auto;
        margin-right: auto;
        background: #e4e6ed;
        padding: 24px;
        border-radius: 50%;
        max-width: 120px;
        max-height: 120px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .icon i {
        
        font-size: 100px !important;
        padding: 40px !important;
    }

    .container .title {
        text-align: center;
        font-size: 20px;
        padding: 10px 5px;
        max-width: 310px;
        margin: 0 auto;
        font-weight: 600;
    }

    .container .desc {
        text-align: center;
        padding: 10px;
    }

    .container a {
        color: #58a3e5 !important;
    }

    .powerd-by {
        display: flex;
        justify-content: center;
        align-items: center;
        position: absolute;
        bottom:0;
        margin-bottom: 15px;
    }
    .custom-container{
        max-width: 640px;
    }

    .custom-container .card{
        height: 80vh;
        position: relative;
    }
    .card-content{
        margin-bottom: 100px;
    }
    .icon .error-img{
        width: 80px;
    }
</style>

<div class="custom-container pt-0">
    <div class="userPage ">

        <div class="card">
            <div class="card-content">
                
            <div class="icon">
                <!-- <i class='fa-solid fa-cloud-arrow-down'></i> -->
                <img class="error-img" src="<?= ASSETS_FULL_URL . 'images/disconnected.png' ?>" class="img-fluid" alt="">
            </div>

            <div class="container">
                <h1 class="title">This QR code has been deactivated for some reason.</h1>
                <p class="desc">If you are the owner of this QR code, <a href="<?= url('login') ?>">log in</a> to reactive it.</p>
            </div>
            </div>

            <div class="powerd-by">
                <a href="<?= url() ?>">
                    <?php if (settings()->main->{'logo_' . \Altum\ThemeStyle::get()} != '') : ?>
                        <img src="<?= UPLOADS_FULL_URL . 'main/' . settings()->main->{'logo_' . \Altum\ThemeStyle::get()} ?>" class="img-fluid navbar-logo" alt="<?= l('global.accessibility.logo_alt') ?>" loading="lazy"/>
                    <?php else : ?>
                        <?= settings()->main->title ?>
                    <?php endif ?>
                </a>
                <p>Powerd by QR new</p>
            </div>
        </div>
    </div>
</div>