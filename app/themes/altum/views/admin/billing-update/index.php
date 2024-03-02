<?php defined('ALTUMCODE') || die() ?>

<nav aria-label="breadcrumb">
    <ol class="custom-breadcrumbs small">
        <li>
            <a href="<?= url('admin/billings') ?>"><?= l('admin_billings.breadcrumb') ?></a><i class="fa fa-fw fa-angle-right"></i>
        </li>
        <li class="active" aria-current="page"><?= l('admin_billing_update.breadcrumb') ?></li>
    </ol>
</nav>

<div class="d-flex justify-content-between mb-4">
    <h1 class="h3 mb-0 text-truncate"><i class="fa fa-fw fa-xs fa-box-open text-primary-900 mr-2"></i> <?= l('admin_billing_update.header') ?></h1>

    <?= include_view(THEME_PATH . 'views/admin/billings/admin_billing_dropdown_button.php', ['id' => $data->billing->billing_id]) ?>
</div>

<?= \Altum\Alerts::output_alerts() ?>

<div class="card">
    <div class="card-body">

        <form action="" method="post" role="form">
            <input type="hidden" name="token" value="<?= \Altum\Middlewares\Csrf::get() ?>" />
            <input type="hidden" name="type" value="update" />

            <?php if(is_numeric($data->billing_id)): ?>
            <div class="form-group">
                <label for="billing_id"><?= l('admin_billings.main.billing_id') ?></label>
                <input type="text" id="billing_id" name="billing_id" class="form-control form-control-lg <?= \Altum\Alerts::has_field_errors('billing_id') ? 'is-invalid' : null ?>" value="<?= $data->billing->billing_id ?>" disabled="disabled" />
                <?= \Altum\Alerts::output_field_error('name') ?>
            </div>
            <?php endif ?>

            <div class="form-group">
                <label for="name"><?= l('admin_billings.main.name') ?></label>
                <input type="text" id="name" name="name" class="form-control form-control-lg <?= \Altum\Alerts::has_field_errors('name') ? 'is-invalid' : null ?>" value="<?= $data->billing->name ?>" required="required" />
                <?= \Altum\Alerts::output_field_error('name') ?>
            </div>

            <div class="form-group">
                <label for="short_description"><?= l('admin_billings.short.description') ?></label>
                <input type="text" id="short_description" name="short_description" class="form-control form-control-lg <?= \Altum\Alerts::has_field_errors('short_description') ? 'is-invalid' : null ?>" value="<?= $data->billing->short_description ?>" />
                <?= \Altum\Alerts::output_field_error('short_description') ?>
            </div>

            <div class="form-group" data-type="internal">
                <label for="description"><?= l('admin_billings.main.description') ?></label>
                <div id="quill_container">
                    <div id="quill" style="height: 15rem;"></div>
                </div>
                <textarea name="description" id="description" class="form-control form-control-lg d-none" style="height: 15rem;"><?= $data->billing->description ?></textarea>
            </div>

            <div class="form-group">
                <label for="price"><?= l('admin_billings.main.price') ?></label>
                <input type="text" id="price" name="price" class="form-control form-control-lg <?= \Altum\Alerts::has_field_errors('price') ? 'is-invalid' : null ?>" value="<?= $data->billing->price ?>" required="required" />
                <?= \Altum\Alerts::output_field_error('price') ?>
            </div>

            <div class="form-group">
                <label for="all_price"><?= l('admin_billings.all.price') ?></label>
                <input type="text" id="all_price" name="all_price" class="form-control form-control-lg <?= \Altum\Alerts::has_field_errors('all_price') ? 'is-invalid' : null ?>" value="<?= $data->billing->all_price ?>" required="required" />
                <?= \Altum\Alerts::output_field_error('all_price') ?>
            </div>

            <div class="form-group">
                <label for="status"><?= l('admin_billings.main.status') ?></label>
                <select id="status" name="status" class="form-control form-control-lg">
                    <option value="1" <?= $data->billing->status == 1 ? 'selected="selected"' : null ?>><?= l('global.active') ?></option>
                    <option value="0" <?= $data->billing->status == 0 ? 'selected="selected"' : null ?> <?= $data->billing->billing_id == 'custom' ? 'disabled="disabled"' : null ?>><?= l('global.disabled') ?></option>
                    <option value="2" <?= $data->billing->status == 2 ? 'selected="selected"' : null ?>><?= l('global.hidden') ?></option>
                </select>
            </div>

            <?php if(is_numeric($data->billing_id)): ?>
                <div class="form-group">
                    <label for="order"><?= l('admin_billings.main.order') ?></label>
                    <input id="order" type="number" min="0"  name="order" class="form-control form-control-lg" value="<?= $data->billing->order ?>" />
                </div>
            <?php endif ?>


            <?php if($data->billing_id == 'custom'): ?>
                <div class="alert alert-info" role="alert"><?= l('admin_billings.main.custom_help') ?></div>
                <button type="submit" name="submit" class="btn btn-lg btn-block btn-primary mt-4"><?= l('global.update') ?></button>
            <?php elseif($data->billing_id == 'guest'): ?>
                <button type="submit" name="submit" class="btn btn-lg btn-block btn-primary mt-4"><?= l('global.update') ?></button>
            <?php else: ?>
                <button type="submit" name="submit" class="btn btn-lg btn-block btn-primary mt-4"><?= l('global.update') ?></button>
            <?php endif ?>
        </form>

    </div>
</div>

<?php \Altum\Event::add_content(include_view(THEME_PATH . 'views/admin/billings/billing_delete_modal.php'), 'modals'); ?>
<?php ob_start() ?>
<link href="<?= ASSETS_FULL_URL . 'css/quill.snow.css?v=' . PRODUCT_CODE ?>" rel="stylesheet" media="screen,print">
<?php \Altum\Event::add_content(ob_get_clean(), 'head') ?>

<?php ob_start() ?>
<script src="<?= ASSETS_FULL_URL . 'js/libraries/quill.min.js' ?>"></script>

<script>
    'use strict';

    let quill = new Quill('#quill', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ "font": [] }, { "size": ["small", false, "large", "huge"] }],
                ["bold", "italic", "underline", "strike"],
                [{ "color": [] }, { "background": [] }],
                [{ "script": "sub" }, { "script": "super" }],
                [{ "header": 1 }, { "header": 2 }, "blockquote", "code-block"],
                [{ "list": "ordered" }, { "list": "bullet" }, { "indent": "-1" }, { "indent": "+1" }],
                [{ "direction": "rtl" }, { "align": [] }],
                ["link", "image", "video", "formula"],
                ["clean"]
            ]
        },
    });

    quill.root.innerHTML = document.querySelector('#description').value;

    document.querySelector('form').addEventListener('submit', event => {        
            document.querySelector('#description').value = quill.root.innerHTML;
   });

    /* Editor change handlers */
    let current_editor = document.querySelector('#editor').value;

    let editor_handler = (event = null) => {
        if(event && !confirm(<?= json_encode(l('admin_resources.main.editor_confirm')) ?>)) {
            document.querySelector('#editor').value = current_editor;
            return;
        }

        let editor = document.querySelector('#editor').value;

        switch(editor) {
            case 'wysiwyg':
                document.querySelector('#quill_container').classList.remove('d-none');
                quill.enable(true);
                // quill.root.innerHTML = document.querySelector('#description').value;
                document.querySelector('#description').classList.add('d-none');
                break;
        }

        current_editor = document.querySelector('#editor').value;
    };

    document.querySelector('#editor').addEventListener('change', editor_handler);
    editor_handler();

    /* Type handler */
    let type_handler = () => {
        let type = document.querySelector('select[name="type"]').value;

        document.querySelectorAll(`[data-type]:not([data-type="${type}"])`).forEach(element => {
            element.classList.add('d-none');
            let input = element.querySelector('input');

            if(input) {
                input.setAttribute('disabled', 'disabled');
                if(input.getAttribute('required')) {
                    input.setAttribute('data-is-required', 'true');
                }
                input.removeAttribute('required');
            }
        });

        document.querySelectorAll(`[data-type="${type}"]`).forEach(element => {
            element.classList.remove('d-none');
            let input = element.querySelector('input');

            if(input) {
                input.removeAttribute('disabled');
                if(input.getAttribute('data-is-required')) {
                    input.setAttribute('required', 'required')
                }
            }
        });
    }

    type_handler();

    document.querySelector('select[name="type"]') && document.querySelector('select[name="type"]').addEventListener('change', type_handler);
</script>
<?php \Altum\Event::add_content(ob_get_clean(), 'javascript') ?>
