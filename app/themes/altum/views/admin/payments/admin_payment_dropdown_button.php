<?php

use Altum\Middlewares\Authentication;

defined('ALTUMCODE') || die() ?>
<?php $user = Authentication::$user ?>
<style>
    /* .actions-menu {
        transform: none !important;
        top: 24px !important;
        left: -110px !important;

    }

    .actions-dropdown {
        position: absolute !important;
    }

    .actions-dropdown>button {
        margin-top: -23px;
    } */
</style>

<div class="dropdown actions-dropdown">
    <button type="button" class="btn btn-link text-secondary dropdown-toggle dropdown-toggle-simple" data-toggle="dropdown" data-boundary="viewport">
        <i class="fa fa-fw fa-ellipsis-v <?= $data->processor == 'offline_payment' && !$data->status ? 'text-danger' : null ?>"></i>
    </button>

    <div class="dropdown-menu dropdown-menu-right actions-menu">
        <?php if ($data->processor == 'offline_payment') : ?>
            <a href="<?= UPLOADS_FULL_URL . 'offline_payment_proofs/' . $data->payment_proof ?>" target="_blank" class="dropdown-item"><i class="fa fa-fw fa-sm fa-download mr-2"></i> <?= l('admin_payments.table.action_view_proof') ?></a>

            <?php if (!$data->status) : ?>
                <a href="#" data-toggle="modal" data-target="#payment_approve_modal" data-payment-id="<?= $data->id ?>" class="dropdown-item"><i class="fa fa-fw fa-sm fa-check mr-2"></i> <?= l('admin_payments.table.action_approve_proof') ?></a>
            <?php endif ?>
        <?php endif ?>

        <?php if (!$data->is_refund) : ?>
            <?php if ($data->status) : ?>
                <a href="<?= url('invoice/' . $data->id) ?>" target="_blank" class="dropdown-item"><i class="fa fa-fw fa-sm fa-file-invoice mr-2"></i> <?= l('admin_payments.table.invoice') ?></a>
                <input id="user_currency" type="hidden" value="<?= $data->currency?>">
                <a href="#" data-toggle="modal" data-target="#refund_options_modal" data-currency="<?= $data->currency?>" data-id="<?= $data->id ?>" class="dropdown-item"><i class="fa fa-fw fa-sm fa-reply mr-2"></i> Refund</a>
            <?php endif ?>

            <?php if ($user->type != 3) : ?>
                <a href="#" data-toggle="modal" data-target="#payment_delete_modal" data-id="<?= $data->id ?>" class="dropdown-item"><i class="fa fa-fw fa-sm fa-trash-alt mr-2"></i> <?= l('global.delete') ?></a>
            <?php endif ?>
        <?php else : ?>
            <a href="<?= url('invoice/' . $data->id) ?>" target="_blank" class="dropdown-item"><i class="fa fa-fw fa-sm fa-file-invoice mr-2"></i> <?= l('admin_payments.table.invoice') ?></a>
        <?php endif ?>
    </div>
</div>