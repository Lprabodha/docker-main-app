<?php defined('ALTUMCODE') || die() ?>


<div class="container">
    <?= \Altum\Alerts::output_alerts() ?>

    <nav aria-label="breadcrumb">
        <ol class="custom-breadcrumbs small">
            <li>
                <a href="<?= url('projects') ?>"><?= l('projects.breadcrumb') ?></a><i class="fa fa-fw fa-angle-right"></i>
            </li>
            <li class="active" aria-current="page"><?= l('project_create.breadcrumb') ?></li>
        </ol>
    </nav>

    <h1 class="h4 text-truncate mb-4"><?= l('project_create.header') ?></h1>

    <div class="card borr">
        <div class="card-body">

            <form action="" method="post" role="form">
                <input type="hidden" name="token" value="<?= \Altum\Middlewares\Csrf::get() ?>" />

                <div class="form-group">
                    <label for="name"><i class="fa fa-fw fa-signature fa-sm mr-1"></i> <?= l('projects.input.name') ?></label>
                    <input type="text" id="name" name="name" class="form-control brr" value="<?= $data->values['name'] ?>" required="required" />
                </div>

                <div class="form-group">
                    <label for="color"><i class="fa fa-fw fa-palette fa-sm mr-1"></i> <?= l('projects.input.color') ?></label>
                    <input type="color" id="color" name="color" class="form-control brr" value="<?= $data->values['color'] ?>" required="required" />
                    <small class="text-muted form-text"><?= l('projects.input.color_help') ?></small>
                </div>

                <button type="submit" name="submit" class="btn btn-block btn-primary cclrf"><?= l('global.create') ?></button>
            </form>

        </div>
    </div>
</div>
