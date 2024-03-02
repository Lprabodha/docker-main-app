<?php

use Altum\Middlewares\Authentication;

defined('ALTUMCODE') || die() ?>
<?php $user = Authentication::$user ?>
<div class="d-flex flex-column flex-md-row justify-content-between mb-4">
    <h1 class="h3 m-0"><i class="text-primary-900 mr-2"></i> <?= l('admin_payments.header') ?></h1>

    <div class="d-flex position-relative">
        <div class="">
            <?php if ($user->type != 3) : ?>
                <div class="dropdown">
                    <button type="button" class="btn btn-outline-secondary dropdown-toggle-simple" data-toggle="dropdown" data-boundary="viewport" title="<?= l('global.export') ?>">
                        <i class="fa fa-fw fa-sm fa-download"></i>
                    </button>

                    <div class="dropdown-menu dropdown-menu-right d-print-none">
                        <a href="<?= url('admin/payments?' . $data->filters->get_get() . '&export=csv') ?>" target="_blank" class="dropdown-item">
                            <i class="fa fa-fw fa-sm fa-file-csv mr-1"></i> <?= sprintf(l('global.export_to'), 'CSV') ?>
                        </a>
                        <a href="<?= url('admin/payments?' . $data->filters->get_get() . '&export=json') ?>" target="_blank" class="dropdown-item">
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
                            <a href="<?= url('admin/payments') ?>" class="text-muted"><?= l('global.filters.reset') ?></a>
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
                                <option value="payment_id" <?= $data->filters->search_by == 'payment_id' ? 'selected="selected"' : null ?>><?= l('admin_payments.filters.search_by_payment_id') ?></option>
                            </select>
                        </div>

                        <div class="form-group px-4">
                            <label for="filters_status" class="small"><?= l('admin_payments.filters.status') ?></label>
                            <select name="status" id="filters_status" class="form-control form-control-sm">
                                <option value=""><?= l('global.filters.all') ?></option>
                                <option value="1" <?= isset($data->filters->filters['status']) && $data->filters->filters['status'] == '1' ? 'selected="selected"' : null ?>><?= l('admin_payments.filters.status_paid') ?></option>
                                <option value="0" <?= isset($data->filters->filters['status']) && $data->filters->filters['status'] == '0' ? 'selected="selected"' : null ?>><?= l('admin_payments.filters.status_pending') ?></option>
                            </select>
                        </div>

                        <div class="form-group px-4">
                            <label for="filters_plan_id" class="small"><?= l('admin_payments.filters.plan_id') ?></label>
                            <select name="plan_id" id="filters_plan_id" class="form-control form-control-sm">
                                <option value=""><?= l('global.filters.all') ?></option>
                                <?php foreach ($data->plans as $plan) : ?>
                                    <option value="<?= $plan->plan_id ?>" <?= isset($data->filters->filters['plan_id']) && $data->filters->filters['plan_id'] == $plan->plan_id ? 'selected="selected"' : null ?>><?= $plan->name ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>

                        <div class="form-group px-4">
                            <label for="filters_type" class="small"><?= l('pay_custom_plan.payment_type') ?></label>
                            <select name="type" id="filters_type" class="form-control form-control-sm">
                                <option value=""><?= l('global.filters.all') ?></option>
                                <option value="recurring" <?= isset($data->filters->filters['type']) && $data->filters->filters['type'] == 'recurring' ? 'selected="selected"' : null ?>><?= l('pay_custom_plan.recurring_type') ?></option>
                                <option value="one_time" <?= isset($data->filters->filters['type']) && $data->filters->filters['type'] == 'one_time' ? 'selected="selected"' : null ?>><?= l('pay_custom_plan.one_time_type') ?></option>
                            </select>
                        </div>

                        <div class="form-group px-4">
                            <label for="filters_processor" class="small"><?= l('pay_custom_plan.payment_processor') ?></label>
                            <select name="processor" id="filters_processor" class="form-control form-control-sm">
                                <option value=""><?= l('global.filters.all') ?></option>
                                <?php foreach ($data->payment_processors as $key => $value) : ?>
                                    <option value="<?= $key ?>" <?= isset($data->filters->filters['processor']) && $data->filters->filters['processor'] == $key ? 'selected="selected"' : null ?>><?= l('pay_custom_plan.' . $key) ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>

                        <div class="form-group px-4">
                            <label for="filters_frequency" class="small"><?= l('pay_custom_plan.payment_frequency') ?></label>
                            <select name="frequency" id="filters_frequency" class="form-control form-control-sm">
                                <option value=""><?= l('global.filters.all') ?></option>
                                <option value="monthly" <?= isset($data->filters->filters['frequency']) && $data->filters->filters['frequency'] == 'monthly' ? 'selected="selected"' : null ?>><?= l('pay_custom_plan.monthly') ?></option>
                                <option value="annual" <?= isset($data->filters->filters['frequency']) && $data->filters->filters['frequency'] == 'annual' ? 'selected="selected"' : null ?>><?= l('pay_custom_plan.annual') ?></option>
                                <option value="lifetime" <?= isset($data->filters->filters['frequency']) && $data->filters->filters['frequency'] == 'lifetime' ? 'selected="selected"' : null ?>><?= l('pay_custom_plan.lifetime') ?></option>
                            </select>
                        </div>


                        <div class="form-group px-4">
                            <label for="filters_order_by" class="small"><?= l('global.filters.order_by') ?></label>
                            <select name="order_by" id="filters_order_by" class="form-control form-control-sm">
                                <option value="datetime" <?= $data->filters->order_by == 'datetime' ? 'selected="selected"' : null ?>><?= l('global.filters.order_by_datetime') ?></option>
                                <option value="total_amount" <?= $data->filters->order_by == 'total_amount' ? 'selected="selected"' : null ?>><?= l('admin_payments.filters.order_by_total_amount') ?></option>
                                <option value="name" <?= $data->filters->order_by == 'name' ? 'selected="selected"' : null ?>><?= l('admin_payments.filters.order_by_name') ?></option>
                                <option value="email" <?= $data->filters->order_by == 'email' ? 'selected="selected"' : null ?>><?= l('admin_payments.filters.order_by_email') ?></option>
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
    </div>
</div>

<?= \Altum\Alerts::output_alerts() ?>

<div class="table-responsive table-custom-container">
    <table class="table table-custom">
        <thead>
            <tr>
                <th><?= l('admin_payments.table.user') ?></th>
                <th><?= l('admin_payments.table.discount') ?></th>
                <th><?= l('admin_payments.table.payment_details') ?></th>
                <th><?= l('admin_payments.table.plan') ?></th>
                <th><?= l('admin_payments.table.total_amount') ?></th>
                <th>Created at</th>
                <th><?= l('admin_payments.table.status') ?></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data->payments as $row) : ?>
                <?php if (!$row->status) : ?>
                    <tr>
                        <td class="text-nowrap">
                            <div class="d-flex flex-column">
                                <div>
                                    <a href="<?= url('admin/user-view/' . $row->user_id) ?>"><?= $row->user_name ?></a>
                                </div>
                                <span class="text-muted"><?= $row->user_email ?></span>
                            </div>
                        </td>
                        <td class="text-nowrap">
                            <?php
                            switch ($row->code) {
                                case '30OFF_FOREVER':
                                    $discount = '30%';
                                    break;
                                case '50OFF_FOREVER':
                                    $discount = '50%';
                                    break;
                                case '70OFF_FOREVER':
                                    $discount = '70%';
                                    break;
                                case '90OFF_FOREVER':
                                    $discount = '90%';
                                    break;
                                default:
                                    $discount = 'No';
                            }
                            ?>
                            <div class="d-flex flex-column">
                                <span><?= $discount ?></span>
                            </div>


                        <td class="text-nowrap">
                            <div class="d-flex flex-column">
                                <span><?= $row->payment_proof ?></span>
                            </div>
                        </td>


                        <td class="text-nowrap">
                            <div class="d-flex flex-column">
                                <?php if (isset($data->plans[$row->plan_id])) : ?>
                                    <a style="font-weight: <?= $row->plan_id == 5 || $row->plan_id == 4 ? '700' : '' ?>; color:<?= $row->plan_id == 5 || $row->plan_id == 4 ? '#1ECDDE' : '' ?>" href="<?= url('admin/plan-update/' . $row->plan_id) ?>"><?= $data->plans[$row->plan_id]->name ?></a>
                                <?php else : ?>
                                    <?= $row->plan->name ?? null ?>
                                <?php endif ?>
                            </div>
                        </td>
                        <td class="text-nowrap">
                            <div class="d-flex flex-column">
                                <span style="color:red"><?= strtoupper($row->currency) ?>&nbsp;<?= nr($row->total_amount, 2)  ?></span>

                            </div>
                        </td>
                        <td class="text-nowrap">
                            <div>
                                <span class="text-muted">
                                    <?= \Altum\Date::get($row->datetime, 1) ?>
                                </span>
                            </div>
                        </td>

                        <td class="text-nowrap">
                            <div>
                                <span style="color:red">
                                    Failed
                                </span>
                            </div>
                        </td>

                        <td>

                            <div class="d-flex justify-content-end">
                                <?= include_view(THEME_PATH . 'views/admin/payments/admin_payment_dropdown_button.php', [
                                    'id' => $row->id,
                                    'payment_proof' => $row->payment_proof,
                                    'processor' => $row->processor,
                                    'status' => $row->status,
                                    'is_refund' => $row->is_refund
                                ]) ?>
                            </div>

                        </td>
                    </tr>
                <?php else : ?>
                    <tr>
                        <td class="text-nowrap">
                            <div class="d-flex flex-column">
                                <div>
                                    <a href="<?= url('admin/user-view/' . $row->user_id) ?>"><?= $row->user_name ?></a>
                                </div>

                                <span class="text-muted"><?= $row->user_email ?></span>
                            </div>
                        </td>

                        <td class="text-nowrap">

                            <?php
                            switch ($row->code) {
                                case '30OFF':
                                    $discount = '30%';
                                    $planName = 'Promo 30';
                                    break;
                                case '50OFF':
                                    $discount = '50%';
                                    $planName = 'Promo 50';
                                    break;
                                case '70OFF':
                                    $discount = '70%';
                                    $planName = 'Promo 70';
                                    break;
                                case '90OFF':
                                    $discount = '90%';
                                    $planName = 'Promo 90';
                                    break;
                                default:
                                    $discount = 'No';
                                    $planName = null;
                            }
                            ?>

                            <div class="d-flex flex-column">
                                <span><?= $discount ?></span>
                            </div>
                        </td>
                        <td class="text-nowrap">
                            <div class="d-flex flex-column">
                                <span><?= $row->payment_proof ?></span>
                            </div>
                        </td>
                        <td class="text-nowrap">
                            <div class="d-flex flex-column">
                                <?php if (isset($data->plans[$row->plan_id])) : ?>
                                    <?php if ($user->type != 3) : ?>
                                        <a style="font-weight: <?= $row->plan_id == 5 || $row->plan_id == 4 || $row->code ? '700' : '' ?>; color:<?= $row->plan_id == 5 || $row->plan_id == 4 || $row->code ? '#1ECDDE' : '' ?>" href="<?= url('admin/plan-update/' . $row->plan_id) ?>">
                                            <?php if ($row->code) : ?>
                                                <?= $planName ?></a>
                                    <?php else : ?>
                                        <?= $data->plans[$row->plan_id]->name ?></a>
                                    <?php endif ?>
                                <?php else : ?>
                                    <a><?= $data->plans[$row->plan_id]->name ?></a>
                                <?php endif ?>
                            <?php else : ?>
                                <?= $row->plan->name ?? null ?>
                            <?php endif ?>
                            </div>
                        </td>
                        <td class="text-nowrap">
                            <div class="d-flex flex-column">
                                <span class=""><?= strtoupper($row->currency) ?>&nbsp;<?= nr($row->total_amount, 2)  ?></span>

                            </div>
                        </td>
                        <td class="text-nowrap">
                            <div>
                                <span class="text-muted">
                                    <?= \Altum\Date::get($row->datetime, 1) ?>
                                </span>
                            </div>
                        </td>

                        <td class="text-nowrap">
                            <div>
                                <?php if ($row->is_refund == 0) : ?>
                                    <span class="badge badge-success p-2" style="background-color: #28c254; color: white;">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="white" height="15" width="15" viewBox="0 0 512 512">
                                            <path d="M256 48a208 208 0 1 1 0 416 208 208 0 1 1 0-416zm0 464A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-111 111-47-47c-9.4-9.4-24.6-9.4-33.9 0s-9.4 24.6 0 33.9l64 64c9.4 9.4 24.6 9.4 33.9 0L369 209z" />
                                        </svg>
                                        Paid
                                    </span>
                                <?php else : ?>
                                    <span class="badge badge-warning p-2" style="background-color: #f3b71a; color: white;">
                                        <i class="fa fa-light fa-sharp fa-info-circle"></i>
                                        Refunded
                                    </span>
                                <?php endif ?>

                            </div>
                        </td>

                        <td>
                            <div class="d-flex justify-content-end">
                                <?= include_view(THEME_PATH . 'views/admin/payments/admin_payment_dropdown_button.php', [
                                    'id' => $row->id,
                                    'payment_proof' => $row->payment_proof,
                                    'processor' => $row->processor,
                                    'status' => $row->status,
                                    'is_refund' => $row->is_refund
                                ]) ?>
                            </div>

                        </td>

                    </tr>
                <?php endif ?>
            <?php endforeach ?>
        </tbody>
    </table>
</div>
<div class="mt-3"><?= $data->pagination ?></div>

<?php \Altum\Event::add_content(include_view(THEME_PATH . 'views/admin/payments/payment_refund_modal.php'), 'modals'); ?>
<?php \Altum\Event::add_content(include_view(THEME_PATH . 'views/admin/payments/refund_options_modal.php'), 'modals'); ?>
<?php \Altum\Event::add_content(include_view(THEME_PATH . 'views/admin/payments/payment_approve_modal.php'), 'modals'); ?>
<?php \Altum\Event::add_content(include_view(THEME_PATH . 'views/partials/universal_delete_modal_url.php', [
    'name' => 'payment',
    'resource_id' => 'id',
    'has_dynamic_resource_name' => false,
    'path' => 'admin/payments/delete/'
]), 'modals'); ?>