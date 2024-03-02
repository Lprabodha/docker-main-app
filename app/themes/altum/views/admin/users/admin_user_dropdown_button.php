<?php

use Altum\Middlewares\Authentication;

defined('ALTUMCODE') || die() ?>

<?php

$userDiscount  =  database()->query("SELECT * FROM `payments` WHERE `user_id` = {$data->id} AND `discount_amount` IS  NOT NULL ORDER BY `id` ASC LIMIT 1")->fetch_object();
$user = Authentication::$user;

?>

<div class="dropdown">
    <button type="button" class="btn btn-link text-secondary dropdown-toggle dropdown-toggle-simple" data-toggle="dropdown" data-boundary="viewport">
        <i class="fa fa-fw fa-ellipsis-v"></i>
    </button>

    <div class="dropdown-menu dropdown-menu-right">
        <a class="dropdown-item" href="admin/user-view/<?= $data->id ?>"><i class="fa fa-fw fa-sm fa-eye mr-2"></i> <?= l('global.view') ?></a>
        <?php if ($data->type == 1 && $user->type == 3) : ?>
        <?php else : ?>
            <a class="dropdown-item" href="admin/user-update/<?= $data->id ?>"><i class="fa fa-fw fa-sm fa-pencil-alt mr-2"></i> <?= l('global.edit') ?></a>
        <?php endif ?>
        <a href="#" data-toggle="modal" data-target="#user_plan_generate_modal" data-user-referral-key="<?= $data->referral_key ?>" data-user-id="<?= $data->id ?>" data-resource-name="<?= $data->resource_name ?>" class="dropdown-item"><i class="fa fa-fw fa-sm fa-link mr-2"></i> Generate URL</a>

        <?php if ($user->type != 3) : ?>
            <a href="#" data-toggle="modal" data-target="#user_delete_modal" data-user-id="<?= $data->id ?>" data-resource-name="<?= $data->resource_name ?>" class="dropdown-item"><i class="fa fa-fw fa-sm fa-trash-alt mr-2"></i> <?= l('global.delete') ?></a>
        <?php endif ?>
        <?php if ($data->type == 1 && $user->type == 3) : ?>
        <?php else : ?>
            <a href="#" data-toggle="modal" data-target="#user_login_modal" data-user-id="<?= $data->id ?>" class="dropdown-item"><i class="fa fa-fw fa-sm fa-sign-in-alt mr-2"></i> <?= l('global.login') ?></a>
        <?php endif ?>
    </div>
</div>