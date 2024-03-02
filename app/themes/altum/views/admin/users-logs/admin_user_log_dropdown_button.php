<?php

use Altum\Middlewares\Authentication;

defined('ALTUMCODE') || die() ?>
<?php $user = Authentication::$user ?>
<?php if ($user->type != 3) : ?>
    <div class="dropdown">
        <button type="button" class="btn btn-link text-secondary dropdown-toggle dropdown-toggle-simple" data-toggle="dropdown" data-boundary="viewport">
            <i class="fa fa-fw fa-ellipsis-v"></i>
        </button>
        <div class="dropdown-menu dropdown-menu-right">
            <a href="#" data-toggle="modal" data-target="#user_log_delete_modal" data-id="<?= $data->id ?>" class="dropdown-item"><i class="fa fa-fw fa-sm fa-trash-alt mr-2"></i> <?= l('global.delete') ?></a>
            <a href="#" data-toggle="modal" data-target="#user_log_delete_modal" data-id="<?= $data->id ?>" class="dropdown-item"><i class="fa fa-fw fa-sm fa-trash-alt mr-2"></i> <?= $user->type ?> </a>
        </div>
    </div>
<?php endif ?>