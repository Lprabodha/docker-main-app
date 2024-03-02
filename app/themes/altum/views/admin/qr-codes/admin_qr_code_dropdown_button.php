<?php

use Altum\Middlewares\Authentication;

defined('ALTUMCODE') || die() ?>
<?php $user = Authentication::$user ?>

<div class="dropdown">
    <button type="button" class="btn btn-link text-secondary dropdown-toggle dropdown-toggle-simple" data-toggle="<?= $data->status != "Deleted" ? "dropdown" : '' ?>" data-boundary="viewport">
        <i class="fa fa-fw fa-ellipsis-v"></i>
    </button>

    <div class="dropdown-menu dropdown-menu-right">
        <a href="#" data-toggle="modal" data-target="#qr_code_transfer_modal" data-qr-code-id="<?= $data->id ?>" data-resource-name="<?= $data->resource_name ?>" class="dropdown-item"><i class="fas fa-fw fa-sm fa-random mr-2"></i> <?= l('admin.transfer') ?></a>
        
        <a href="#" data-toggle="modal" data-target="#qr_code_delete_modal" data-qr-code-id="<?= $data->id ?>" data-resource-name="<?= $data->resource_name ?>" class="dropdown-item"><i class="fa fa-fw fa-sm fa-trash-alt mr-2"></i> <?= l('global.delete') ?></a>
    </div>

</div>

<?php \Altum\Event::add_content(include_view(THEME_PATH . 'views/partials/universal_delete_modal_url.php', [
    'name' => 'qr_code',
    'resource_id' => 'qr_code_id',
    'has_dynamic_resource_name' => true,
    'path' => 'admin/qr-codes/delete/'
]), 'modals', 'qr_code_delete_modal'); ?>

<?php \Altum\Event::add_content(include_view(THEME_PATH . 'views/partials/transfer_modal.php', [
    'name' => 'qr_code',
    'resource_id' => 'qr_code_id',
    'has_dynamic_resource_name' => true,
    'path' => 'admin/qr-codes/transfer/'
]), 'modals', 'qr_code_transfer_modal'); ?>