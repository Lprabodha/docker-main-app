<?php defined('ALTUMCODE') || die() ?>

<div class="d-flex flex-column flex-md-row justify-content-between mb-4">
    <h1 class="h3 m-0"><i class="fa fa-fw fa-xs fa-box-open text-primary-900 mr-2"></i> <?= l('admin_staticblocks.header') ?></h1>

    <div class="col-auto p-0">
        <a href="<?= url('admin/staticblock-create') ?>" class="btn btn-outline-primary"><i class="fa fa-fw fa-plus-circle"></i> <?= l('admin_staticblocks.create') ?></a>
    </div>
</div>

<?= \Altum\Alerts::output_alerts() ?>

<div class="table-responsive table-custom-container">
    <table class="table table-custom">
        <thead>
        <tr>
            <th><?= l('admin_staticblocks.table.name') ?></th>
            <th><?= l('admin_staticblocks.table.order') ?></th>
            <th><?= l('admin_staticblocks.table.status') ?></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($data->staticblocks as $row): ?>

            <tr data-staticblock-id="<?= $row->staticblock_id ?>">
                <td class="text-nowrap">
                    <a href="<?= url('admin/staticblock-update/' . $row->staticblock_id) ?>"><?= $row->name ?></a>
                </td>
                <td class="text-muted"><?= $row->order ?></td>
                <td class="text-nowrap">
                    <?php if($row->status == 0): ?>
                        <span class="badge badge-warning"><i class="fa fa-fw fa-sm fa-eye-slash"></i> <?= l('global.disabled') ?></span>
                    <?php elseif($row->status == 1): ?>
                        <span class="badge badge-success"><i class="fa fa-fw fa-sm fa-check"></i> <?= l('global.active') ?></span>
                    <?php else: ?>
                        <span class="badge badge-info"><i class="fa fa-fw fa-sm fa-eye-slash"></i> <?= l('global.hidden') ?></span>
                    <?php endif ?>
                </td>
                <td class="text-nowrap">
                    <div class="d-flex justify-content-end">
                        <?= include_view(THEME_PATH . 'views/admin/staticblocks/admin_staticblock_dropdown_button.php', ['id' => $row->staticblock_id]) ?>
                    </div>
                </td>
            </tr>

        <?php endforeach ?>
        </tbody>
    </table>
</div>

<?php \Altum\Event::add_content(include_view(THEME_PATH . 'views/admin/staticblocks/staticblock_delete_modal.php'), 'modals'); ?>
