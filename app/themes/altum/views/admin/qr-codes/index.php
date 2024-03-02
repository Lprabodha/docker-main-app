<?php

use Altum\Middlewares\Authentication;

defined('ALTUMCODE') || die() ?>
<?php $user = Authentication::$user ?>



<div class="d-flex flex-column flex-md-row justify-content-between mb-4 qr-code-wrap">
    <h1 class="h3 m-0 w-50"><i class="fa fa-fw fa-xs fa-qrcode text-primary-900 mr-2"></i> <?= l('admin_qr_codes.header') ?></h1>
    <div class="w-75 qr-form-wrap">
        <form action="" method="get" role="form">
            <div class="d-flex form-group has-search w-100 qr-search-wrap" style="align-items: center;">
                <!-- <span class="fa fa-search form-control-feedback" style="margin-right: 10px;"></span> -->
                <input type="text" id="global_search" name="search" class=" form-control search-input" placeholder="Search...">
                <input type="hidden" id="search_type" name="search_by" value="name" class=" form-control search-input">
                <input type="hidden" id="order_by" name="order_by" value="datetime" class=" form-control search-input">
                <input type="hidden" id="order_type" name="order_type" value="ASC" class=" form-control search-input">
                <button class="btn btn-primary btn-sm ml-3 qr-search-btn" onclick="handleSubmit()">Search</button>
            </div>
        </form>
    </div>
    <div class="d-flex position-relative">
        <div class="ml-3">
            <?php if ($user->type != 3) : ?>
                <div class="dropdown">
                    <button type="button" class="btn btn-outline-secondary dropdown-toggle-simple" data-toggle="dropdown" data-boundary="viewport" title="<?= l('global.export') ?>">
                        <i class="fa fa-fw fa-sm fa-download"></i>
                    </button>

                    <div class="dropdown-menu dropdown-menu-right d-print-none">
                        <a href="<?= url('admin/qr-codes?' . $data->filters->get_get() . '&export=csv') ?>" target="_blank" class="dropdown-item">
                            <i class="fa fa-fw fa-sm fa-file-csv mr-1"></i> <?= sprintf(l('global.export_to'), 'CSV') ?>
                        </a>
                        <a href="<?= url('admin/qr-codes?' . $data->filters->get_get() . '&export=json') ?>" target="_blank" class="dropdown-item">
                            <i class="fa fa-fw fa-sm fa-file-code mr-1"></i> <?= sprintf(l('global.export_to'), 'JSON') ?>
                        </a>
                        <button type="button" onclick="window.print();" class="dropdown-item">
                            <i class="fa fa-fw fa-sm fa-file-pdf mr-1"></i> <?= sprintf(l('global.export_to'), 'PDF') ?>
                        </button>
                    </div>
                </div>
            <?php endif ?>
        </div>

        <div class="ml-3">
            <div class="dropdown">
                <button type="button" class="btn <?= count($data->filters->get) ? 'btn-outline-primary' : 'btn-outline-secondary' ?> filters-button dropdown-toggle-simple" data-toggle="dropdown" data-boundary="viewport" title="<?= l('global.filters.header') ?>">
                    <i class="fa fa-fw fa-sm fa-filter"></i>
                </button>

                <div class="dropdown-menu dropdown-menu-right filters-dropdown">
                    <div class="dropdown-header d-flex justify-content-between">
                        <span class="h6 m-0"><?= l('global.filters.header') ?></span>

                        <?php if (count($data->filters->get)) : ?>
                            <a href="<?= url('admin/qr-codes') ?>" class="text-muted"><?= l('global.filters.reset') ?></a>
                        <?php endif ?>
                    </div>

                    <div class="dropdown-divider"></div>

                    <form action="" method="get" role="form">
                        <div class="form-group px-4">
                            <label for="filters_search" class="small"><?= l('global.filters.search') ?></label>
                            <input type="search" name="search" id="filters_search" class="form-control form-control-sm" value="<?= $data->filters->search ?>" />
                        </div>

                        <div class="form-group px-4">
                            <label for="filters_search_by" class="small"><?= l('global.filters.search_by') ?></label>
                            <select name="search_by" id="filters_search_by" class="form-control form-control-sm">
                                <option value="name" <?= $data->filters->search_by == 'name' ? 'selected="selected"' : null ?>><?= l('admin_qr_codes.table.name') ?></option>
                            </select>
                        </div>

                        <div class="form-group px-4">
                            <label for="filters_type" class="small"><?= l('admin_qr_codes.table.type') ?></label>
                            <select name="type" id="filters_type" class="form-control form-control-sm">
                                <option value=""><?= l('global.filters.all') ?></option>
                                <?php foreach (array_keys((require APP_PATH . 'includes/qr_code.php')['type']) as $type) : ?>
                                    <option value="<?= $type ?>" <?= isset($data->filters->filters['type']) && $data->filters->filters['type'] == $type ? 'selected="selected"' : null ?>><?= l('qr_codes.type.' . $type) ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>

                        <div class="form-group px-4">
                            <label for="filters_order_by" class="small"><?= l('global.filters.order_by') ?></label>
                            <select name="order_by" id="filters_order_by" class="form-control form-control-sm">
                                <option value="datetime" <?= $data->filters->order_by == 'datetime' ? 'selected="selected"' : null ?>><?= l('global.filters.order_by_datetime') ?></option>
                                <option value="name" <?= $data->filters->order_by == 'name' ? 'selected="selected"' : null ?>><?= l('admin_qr_codes.table.name') ?></option>
                            </select>
                        </div>

                        <div class="form-group px-4">
                            <label for="filters_order_type" class="small"><?= l('global.filters.order_type') ?></label>
                            <select name="order_type" id="filters_order_type" class="form-control form-control-sm">
                                <option value="ASC" <?= $data->filters->order_type == 'ASC' ? 'selected="selected"' : null ?>><?= l('global.filters.order_type_asc') ?></option>
                                <option value="DESC" <?= $data->filters->order_type == 'DESC' ? 'selected="selected"' : null ?>><?= l('global.filters.order_type_desc') ?></option>
                            </select>
                        </div>

                        <div class="form-group px-4">
                            <label for="filters_results_per_page" class="small"><?= l('global.filters.results_per_page') ?></label>
                            <select name="results_per_page" id="filters_results_per_page" class="form-control form-control-sm">
                                <?php foreach ($data->filters->allowed_results_per_page as $key) : ?>
                                    <option value="<?= $key ?>" <?= $data->filters->results_per_page == $key ? 'selected="selected"' : null ?>><?= $key ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>

                        <div class="form-group px-4 mt-4">
                            <button type="submit" name="submit" class="btn btn-sm btn-primary btn-block"><?= l('global.submit') ?></button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

        <?php if ($user->type != 3) : ?>
            <div class="ml-3">
                <button id="bulk_enable" type="button" class="btn btn-outline-secondary" data-toggle="tooltip" title="<?= l('global.bulk_actions') ?>"><i class="fa fa-fw fa-sm fa-list"></i></button>

                <div id="bulk_group" class="btn-group d-none" role="group">
                    <div class="btn-group" role="group">
                        <button id="bulk_actions" type="button" class="btn btn-outline-primary dropdown-toggle" data-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false">
                            <?= l('global.bulk_actions') ?> <span id="bulk_counter" class="d-none"></span>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="bulk_actions">
                            <a href="#" class="dropdown-item" data-toggle="modal" data-target="#bulk_delete_modal"><?= l('global.delete') ?></a>
                        </div>
                    </div>

                    <button id="bulk_disable" type="button" class="btn btn-outline-secondary" data-toggle="tooltip" title="<?= l('global.close') ?>"><i class="fa fa-fw fa-times"></i></button>
                </div>
            </div>
        <?php endif ?>

    </div>
</div>

<?= \Altum\Alerts::output_alerts() ?>

<form id="table" action="<?= SITE_URL . 'admin/qr-codes/bulk' ?>" method="post" role="form">
    <input type="hidden" name="token" value="<?= \Altum\Middlewares\Csrf::get() ?>" />
    <input type="hidden" name="type" value="" data-bulk-type />

    <div class="table-responsive table-custom-container">
        <table class="table table-custom">
            <thead>
                <tr>
                    <th data-bulk-table class="d-none">
                        <div class="custom-control custom-checkbox">
                            <input id="bulk_select_all" type="checkbox" class="custom-control-input" />
                            <label class="custom-control-label" for="bulk_select_all"></label>
                        </div>
                    </th>
                    <th><?= l('admin_qr_codes.table.user') ?></th>
                    <th><?= l('admin_qr_codes.table.name') ?></th>
                    <th><?= l('admin_qr_codes.table.type') ?></th>
                    <th><?= l('global.datetime') ?></th>
                    <th>Scanned.page</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($data->qr_codes) == 0) : ?>
                    <td class="text-nowrap" colspan="4">
                        No search results
                    </td>
                <?php endif ?>
                <?php foreach ($data->qr_codes as $row) : ?>
                    <?php //ALTUMCODE:DEMO if(DEMO) {$row->user_email = 'hidden@demo.com'; $row->user_name = 'hidden on demo';} 
                    ?>
                    <tr>
                        <td data-bulk-table class="d-none">
                            <div class="custom-control custom-checkbox">
                                <input id="selected_qr_code_id_<?= $row->qr_code_id ?>" type="checkbox" class="custom-control-input" name="selected[]" value="<?= $row->qr_code_id ?>" />
                                <label class="custom-control-label" for="selected_qr_code_id_<?= $row->qr_code_id ?>"></label>
                            </div>
                        </td>
                        <td class="text-nowrap">
                            <div class="d-flex flex-column">
                                <div>
                                    <a href="<?= url('admin/user-view/' . $row->user_id) ?>"><?= $row->user_name ?></a>
                                </div>

                                <span class="text-muted"><?= $row->user_email ?></span>
                            </div>
                        </td>
                        <td class="text-nowrap">
                            <?= $row->name ?>
                        </td>
                        <td class="text-nowrap">
                            <i class="<?= $data->qr_code_settings['type'][$row->type]['icon'] ?> fa-fw fa-sm mr-1"></i>
                            <?= l('qr_codes.type.' . $row->type) ?>
                        </td>
                        <td class="text-nowrap">
                            <span class="text-muted" data-toggle="tooltip" title="<?= \Altum\Date::get($row->datetime, 1) ?>">
                                <?= \Altum\Date::get($row->datetime, 2) ?>
                            </span>
                        </td>
                        <td class="text-nowrap">
                            <?php $qrData = json_decode($row->settings, true); ?>
                            <a href="<?= LANDING_PAGE_URL . "p/" . $row->uId ?>" target="_blank" style="color: #28c254;" class="d-flex scan-url-wrap">
                                <span class="icon-global pr-1" style="margin-top: 2px; font-size:17px;"></span>
                                <span class="scan-url"><?= LANDING_PAGE_URL . "p/" . $row->uId ?></span>
                            </a>
                        </td>

                        <?php
                        $status = "";

                        switch ($row->status) {
                            case 1:
                                $status = "Active";
                                break;
                            case 2:
                                $status = "Paused";
                                break;
                            case 3:
                                $status = "Deleted";
                                break;
                            case 4:
                                $status = "Deactivated";
                                break;
                            case 5:
                                $status = "Draft";
                                break;
                            default:
                                $status = "Active";
                        }
                        ?>

                        <td class=" text-nowrap">
                            <?php
                            $user = db()->where('user_id', $row->user_id)->getOne('users');
                            $currentDate = date('Y-m-d H:i:s');
                            ?>
                            <?php if ($status == "Deleted") : ?>
                                <span class="badge badge-success p-2" style="background-color: #fe4256; color: white;">
                                    <?= $status ?>
                                </span>
                            <?php elseif ($status == "Paused") : ?>
                                <span class="badge badge-light p-2">
                                    <?= $status ?>
                                </span>
                            <?php elseif ($status == "Deactivated" || $user->plan_expiration_date < $currentDate) : ?>
                                <span class="badge badge-success p-2" style="background-color: #f3b71a; color: white;">
                                    Deactivated
                                </span>
                            <?php endif ?>

                        </td>
                        <td>
    
                        <div class="d-flex justify-content-end">
                            <?= include_view(THEME_PATH . 'views/admin/qr-codes/admin_qr_code_dropdown_button.php', ['id' => $row->qr_code_id, 'resource_name' => $row->name, 'status' => $status]) ?>
                        </div>
 
                        </td>
                    </tr>
                <?php endforeach ?>

            </tbody>
        </table>
    </div>
</form>

<div class="mt-3"><?= $data->pagination ?></div>

<?php require THEME_PATH . 'views/admin/partials/js_bulk.php' ?>
<?php \Altum\Event::add_content(include_view(THEME_PATH . 'views/admin/partials/bulk_delete_modal.php'), 'modals'); ?>
<?php \Altum\Event::add_content(include_view(THEME_PATH . 'views/partials/universal_delete_modal_url.php', [
    'name' => 'qr_code',
    'resource_id' => 'qr_code_id',
    'has_dynamic_resource_name' => true,
    'path' => 'admin/qr-codes/delete/'
]), 'modals'); ?>


<script>
    function handleSubmit() {

        var searchInput = document.getElementById('global_search');
        var searchType = document.getElementById('search_type');
        searchInput.value = searchInput.value.trim()

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        const urlRegex = /^(ftp|http|https):\/\/[^ "]+$/i;
        const uidRegex = /^[a-f0-9]{13}$/i;
        const scanUidRegex = /^scanned\.page\/[a-f0-9]{13}$/i;

        if (emailRegex.test(searchInput.value)) {
            searchType.value = "user_id";
        } else if (urlRegex.test(searchInput.value) || searchInput.value.match(/[a-f0-9]{13}$/i) || uidRegex.test(searchInput.value) || scanUidRegex.test(searchInput.value)) {

            searchType.value = "uId";

            if (scanUidRegex.test(searchInput.value)) {
                searchInput.value = searchInput.value.replace(/^scanned\.page\//i, "");
            }

            var match = searchInput.value.match(/\/p\/([a-zA-Z0-9]+)/i);
            if (match) {
                searchInput.value = match[1];
            }

            if (searchInput.value.match(/[a-f0-9]{13}$/i)) {
                searchInput.value = searchInput.value.match(/[a-f0-9]{13}$/i)
            }
        } else {
            searchType.value = "name";
        }
    }
</script>