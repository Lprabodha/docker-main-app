<?php defined('ALTUMCODE') || die() ?>

<div class="container">
    <?= \Altum\Alerts::output_alerts() ?>

    <nav aria-label="breadcrumb">
        <ol class="custom-breadcrumbs small">
            <li>
                <a href="<?= url('teams-system') ?>"><?= l('teams_system.breadcrumb') ?></a><i class="fa fa-fw fa-angle-right"></i>
            </li>
            <li>
                <a href="<?= url('teams') ?>"><?= l('teams.breadcrumb') ?></a><i class="fa fa-fw fa-angle-right"></i>
            </li>
            <li class="active" aria-current="page"><?= l('team_update.breadcrumb') ?></li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between mb-4">
        <h1 class="h4 text-truncate mb-0"><?= l('team_update.header') ?></h1>

        <?= include_view(THEME_PATH . 'views/team/team_dropdown_button.php', ['id' => $data->team->team_id, 'resource_name' => $data->team->name]) ?>
    </div>

    <div class="card">
        <div class="card-body">

            <form action="" method="post" role="form">
                <input type="hidden" name="token" value="<?= \Altum\Middlewares\Csrf::get() ?>" />

                <div class="form-group">
                    <label for="name"><i class="fa fa-fw fa-signature fa-sm text-muted mr-1"></i> <?= l('teams.input.name') ?></label>
                    <input type="text" id="name" name="name" class="form-control <?= \Altum\Alerts::has_field_errors('name') ? 'is-invalid' : null ?>" value="<?= $data->team->name ?>" required="required" />
                    <?= \Altum\Alerts::output_field_error('name') ?>
                </div>

                <button type="submit" name="submit" class="btn btn-block btn-primary"><?= l('global.update') ?></button>
            </form>

        </div>
    </div>
</div>

<?php \Altum\Event::add_content(include_view(THEME_PATH . 'views/partials/universal_delete_modal_form.php', [
    'name' => 'team',
    'resource_id' => 'team_id',
    'has_dynamic_resource_name' => true,
    'path' => 'teams/delete'
]), 'modals'); ?>
