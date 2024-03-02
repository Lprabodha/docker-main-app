<?php

use Altum\Middlewares\Authentication;

defined('ALTUMCODE') || die() ?>

<?php $user = Authentication::$user ?>

<div class="d-flex flex-column flex-md-row justify-content-between mb-4">
    <h1 class="h3 m-0"><i class="text-primary-900 mr-2"></i> <?= l('admin_payments.header') ?></h1>
    <div class="d-flex flex-column flex-md-row justify-content-between mb-4">
        <span class="h3 m-0"><i class="text-primary-900 mr-2"></i> </span>
        <div class="d-flex position-relative">

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

                        <form id="searchForm" action="" method="get" role="form">
                            <div class="form-group px-4">
                                <label for="filters_search" class="small">Search by Email</label>
                                <input type="search" name="user_id" id="uid_search" class="form-control form-control-sm" />
                            </div>

                            <div class="form-group px-4 mt-4">
                                <button onclick="handleSearchFilter()" class="btn btn-sm btn-primary btn-block"><?= l('global.submit') ?></button>
                            </div>
                        </form>

                    </div>
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
                                    'is_refund' => $row->is_refund,
                                    'currency' => $row->payment_currency
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

                        <td style="width: 110px;">
                            <div class="d-flex justify-content-end">
                                <?= include_view(THEME_PATH . 'views/admin/payments/admin_payment_dropdown_button.php', [
                                    'id' => $row->id,
                                    'payment_proof' => $row->payment_proof,
                                    'processor' => $row->processor,
                                    'status' => $row->status,
                                    'is_refund' => $row->is_refund,
                                    'currency' => $row->payment_currency
                                ]) ?>
                            </div>

                        </td>

                    </tr>
                <?php endif ?>
            <?php endforeach ?>
        </tbody>
    </table>
</div>
<div class="mt-3 float-right pr-2 mb-3">
    <a href="<?= url('admin/payments/all') ?>" class="btn btn-outline-secondary dropdown-toggle-simple">See more</a>
</div>


<!-- Payment History -->

<div class="d-flex flex-column flex-md-row justify-content-between mb-4 mt-5 pt-1">
    <h1 class="h3 m-0"><i class="text-primary-900 mr-2"></i> <?= l('admin_payments.history_table.title') ?></h1>
</div>

<div class="table-full-wrap pb-5">
    <div class="table-responsive table-custom-container">
        <table class="table table-custom">
            <thead>
                <tr>
                    <th><?= l('admin_payments.table.user') ?></th>
                    <th><?= l('admin_payments.table.discount') ?></th>
                    <th><?= l('admin_payments.table.payment_details') ?></th>
                    <th><?= l('admin_payments.table.plan') ?></th>
                    <th><?= l('admin_payments.table.total_amount') ?></th>
                    <th><?= l('admin_payments.history_table.billing_date') ?></th>
                    <th><?= l('admin_payments.table.status') ?></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>

                <?php $latestUpcomingPayments = array_slice($data->upcomingPayments, -10); ?>
                <?php foreach ($latestUpcomingPayments as $upcomingPayment) : ?>

                    <tr>
                        <td class="text-nowrap">
                            <div class="d-flex flex-column">
                                <div>
                                    <a href="<?= url('admin/user-view/' . $upcomingPayment['name']) ?>"><?= $upcomingPayment['name'] ?></a>
                                </div>

                                <span class="text-muted"><?= $upcomingPayment['email'] ?></span>
                            </div>
                        </td>

                        <td class="text-nowrap">
                            <?php
                            switch ($upcomingPayment['discount']) {
                                case '30OFF':
                                    $discount = '30%';
                                    break;
                                case '50OFF':
                                    $discount = '50%';
                                    break;
                                case '70OFF':
                                    $discount = '70%';
                                    break;
                                case '90OFF':
                                    $discount = '90%';
                                    break;
                                default:
                                    $discount = 'N/A';
                            }
                            ?>

                            <div class="d-flex flex-column">
                                <span><?= $discount ?></span>
                            </div>
                        </td>
                        <td class="text-nowrap">
                            <div class="d-flex flex-column">
                                <span><?= $upcomingPayment['payment_proof'] ?></span>
                            </div>
                        </td>
                        <td class="text-nowrap">
                            <div class="d-flex flex-column">
                                <?php if ($user->type != 3) : ?>
                                    <a href="<?= url('admin/plan-update/' . $row->plan_id) ?>">
                                        <?= ($upcomingPayment['payment_frequency'] == 'trial_full' || $upcomingPayment['payment_frequency'] == 'trial_limited') ? 'Monthly' : ($upcomingPayment['payment_frequency'] == '14 Day Limited Access' || $upcomingPayment['payment_frequency'] == '14 Day Full Access' ? 'Monthly' : $upcomingPayment['payment_frequency']) ?>
                                    </a>
                                <?php else : ?>
                                    <?= ($upcomingPayment['payment_frequency'] == 'trial_full' || $upcomingPayment['payment_frequency'] == 'trial_limited') ? 'Monthly' : ($upcomingPayment['payment_frequency'] == '14 Day Limited Access' || $upcomingPayment['payment_frequency'] == '14 Day Full Access' ? 'Monthly' : $upcomingPayment['payment_frequency']) ?>
                                <?php endif ?>
                            </div>
                        </td>
                        <td class="text-nowrap">
                            <div class="d-flex flex-column">
                                <?php $upcomingAmount = get_plan_price(1, $upcomingPayment['currency'] ?? 'USD'); ?>
                                <?php if ($upcomingPayment['plan_id'] == 6 || $upcomingPayment['plan_id'] == 7) : ?>
                                    <span class=""><?= $upcomingPayment['currency'] ? strtoupper($upcomingPayment['currency']) : 'USD' ?>&nbsp;<?= nr($upcomingAmount,2) ?></span>
                                <?php elseif ($upcomingPayment['subscription_id'] == null) : ?>
                                    <span class=""><?= $upcomingPayment['currency'] ? strtoupper($upcomingPayment['currency']) : 'USD' ?>&nbsp;<?= nr($upcomingAmount,2) ?></span>
                                <?php else : ?>
                                    <span class=""><?= $upcomingPayment['currency'] ? strtoupper($upcomingPayment['currency']) : 'USD' ?>&nbsp;<?= nr($upcomingPayment['billing_amount'],2)  ?></span>
                                <?php endif ?>

                            </div>
                        </td>
                        <td class="text-nowrap">
                            <div>
                                <span class="text-muted">
                                    <?= $upcomingPayment['billing_period'] ?>
                                </span>
                            </div>
                        </td>

                        <td class="text-nowrap">
                            <div>
                                <?php if ($upcomingPayment['status'] == "upcoming") : ?>
                                    <span class="badge badge-light p-2">
                                        Pending
                                    </span>
                                <?php else : ?>
                                    <span class="badge badge-danger p-2" style="background-color: #fe4256; color: white;">
                                        Canceled
                                    </span>
                                <?php endif ?>

                            </div>
                        </td>

                        <td>
                            <div class="d-flex justify-content-end">
                                <?= include_view(THEME_PATH . 'views/admin/payments/pending_payment_cancel.php', [
                                    'id' => $upcomingPayment['customer_id'],
                                    'user_id' => $upcomingPayment['user_id'],
                                    'payment_proof' => isset($upcomingPayment['payment_proof']) ? $upcomingPayment['payment_proof'] : null,
                                    'processor' => isset($upcomingPayment['processor']) ? $upcomingPayment['processor'] : null,
                                    'status' => $upcomingPayment['status'],
                                    'is_refund' => isset($upcomingPayment['is_refund']) ? $upcomingPayment['is_refund'] : null,
                                ]) ?>
                            </div>
                        </td>

                    </tr>

                <?php endforeach ?>
            </tbody>
        </table>
    </div>
    <div class="mt-3 float-right mb-3 pr-2">
        <a href="<?= url('admin/payments/upcoming') ?>" class="btn btn-outline-secondary dropdown-toggle-simple">See more</a>
    </div>
</div>


<?php \Altum\Event::add_content(include_view(THEME_PATH . 'views/admin/payments/payment_refund_modal.php'), 'modals'); ?>
<?php \Altum\Event::add_content(include_view(THEME_PATH . 'views/admin/payments/refund_options_modal.php'),'modals'); ?>
<?php \Altum\Event::add_content(include_view(THEME_PATH . 'views/admin/payments/payment_approve_modal.php'), 'modals'); ?>
<?php \Altum\Event::add_content(include_view(THEME_PATH . 'views/partials/universal_delete_modal_url.php', [
    'name' => 'payment',
    'resource_id' => 'id',
    'has_dynamic_resource_name' => false,
    'path' => 'admin/payments/delete/'
]), 'modals'); ?>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("subscription_cancel_btn").addEventListener("click", function(e) {
            const element = document.getElementById('cancel_loader');
            element.style.display = 'block';

            e.preventDefault();
            var closestDiv = $(this).closest('div');
            var user_id = closestDiv.find('input').val();
            var data = {
                action: 'cancel_subscription',
                user_id: user_id
            }

            $.ajax({
                type: 'POST',
                url: '<?= url('api/ajax_new') ?>',
                data: data,
                dataType: 'json',
                success: function(response) {
                    setTimeout(function() {
                        location.reload();
                    }, 7000)
                },
                error: function(error) {
                    console.error(error);
                }
            });
        });
    });

    const optionButtons = document.querySelectorAll('.optionsButton');
    optionButtons.forEach(optionButton => {
        optionButton.addEventListener('click', (event) => {
            // Prevent default behavior if button is linked
            event.preventDefault();
            const buttonValue = optionButton.value;
            const modal = document.getElementById('subscription_cancel_modal');
            const hiddenInput = modal.querySelector('input[type="hidden"]');
            hiddenInput.value = buttonValue;

        });
    });

    function handleSearchFilter() {
        var emailInput = document.getElementById('uid_search');
        var form = document.getElementById('searchForm');
        var data = {
            action: 'get_user_by_email',
            email: emailInput.value.trim()
        }

        $.ajax({
            type: 'POST',
            url: '<?= url('api/ajax_new') ?>',
            data: data,
            dataType: 'json',
            success: function(response) {
                if (response.data['status'] == 'success') {
                    emailInput.value = response.data['uid']
                    form.submit();
                    emailInput.value = '';
                }

            },
            error: function(error) {
                console.error(error);
            }
        });

    }
</script>