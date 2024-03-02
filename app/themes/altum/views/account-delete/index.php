<?php defined('ALTUMCODE') || die() ?>

<div class="custom-container" >
    <?= \Altum\Alerts::output_alerts() ?>

    <!-- //$this->views['account_header_menu']  -->

    <div class="d-flex align-items-center mb-3">
        <h1 class="h4 m-0"><?= l('account.delete_button') ?></h1>

        <div class="ml-2">
            <span data-toggle="tooltip" class="ctp-tooltip" tp-content="<?= l('account.status.tooltip') ?>">
                <i class="fa fa-fw fa-info-circle text-muted"></i>
            </span>
        </div>
    </div>

    <div class="card">
        <div class="card-body">

            <form action="" method="post" role="form">
                <input type="hidden" name="token" value="<?= \Altum\Middlewares\Csrf::get() ?>" />

                <div class="form-group">
                    <label for="current_password"><?= l('account.account_delete.current_password') ?></label>
                    <input type="password" id="current_password" name="current_password" class="form-control <?= \Altum\Alerts::has_field_errors('current_password') ? 'is-invalid' : null ?>" />
                    <?= \Altum\Alerts::output_field_error('current_password') ?>
                </div>
                <div class="account-button">
                    <button type="submit" name="submit" class="btn " id="AccountDelete"><?= l('global.delete') ?></button>
                </div>
            </form>

        </div>
    </div>
</div>

<script src="<?= ASSETS_FULL_URL . 'js/customTooltip.js' ?>"></script>
<script>
        new CustomToolTip({targetClass:'ctp-tooltip',enableCollision:false});
</script>