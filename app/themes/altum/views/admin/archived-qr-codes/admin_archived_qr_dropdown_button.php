<?php

use Altum\Middlewares\Authentication;

defined('ALTUMCODE') || die() ?>
<?php $user = Authentication::$user ?>

<div class="dropdown">
    <button type="button" class="btn btn-link text-secondary dropdown-toggle dropdown-toggle-simple" data-toggle="dropdown" data-boundary="viewport">
        <i class="fa fa-fw fa-ellipsis-v"></i>
    </button>

        <div class="dropdown-menu dropdown-menu-right">
            <a href="#" data-toggle="modal" data-target="#archived_qr_code_reactive_qr_modal" data-qr-code-id="<?= $data->id ?>" data-resource-name="<?= $data->resource_name ?>" class="dropdown-item"><i class="fas fa-fw fa-sm fa-random mr-2"></i> Restore QR code</a>
        </div>
</div>


<?php \Altum\Event::add_content(include_view(THEME_PATH . 'views/partials/reactive_qr_modal.php', [
    'name' => 'archived_qr_code',
    'resource_id' => 'qr_code_id',
    'has_dynamic_resource_name' => true,
    'path' => 'admin/archived-qr-codes/reactive_qr_code/'
]), 'modals', 'qr_code_reactive_qr_modal'); ?>