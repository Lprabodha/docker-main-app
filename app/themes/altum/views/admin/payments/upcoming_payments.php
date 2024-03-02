<?php

use Altum\Middlewares\Authentication;

defined('ALTUMCODE') || die() ?>
<?php $user = Authentication::$user ?>

<div class="d-flex flex-column flex-md-row justify-content-between mb-4">
    <span class="h3 m-0"><i class="text-primary-900 mr-2"></i> </span>
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
                            <label for="filters_plan_id" class="small"><?= l('admin_payments.filters.plan_id') ?></label>
                            <select name="plan_id" id="filters_plan_id" class="form-control form-control-sm">
                                <option value=""><?= l('global.filters.all') ?></option>
                                <?php foreach ($data->plans as $plan) : ?>
                                    <option value="<?= $plan->plan_id ?>" <?= isset($data->filters->filters['plan_id']) && $data->filters->filters['plan_id'] == $plan->plan_id ? 'selected="selected"' : null ?>><?= $plan->name ?></option>
                                <?php endforeach ?>
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

<!-- Payment History -->

<div class="d-flex flex-column flex-md-row justify-content-between mb-4 mt-4">
    <h1 class="h3 m-0"><i class="text-primary-900 mr-2"></i> <?= l('admin_payments.history_table.title') ?></h1>
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
                <th><?= l('admin_payments.history_table.billing_date') ?></th>
                <th><?= l('admin_payments.table.status') ?></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data->upcomingPayments as $upcomingPayment) : ?>
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
                            <?php if ($upcomingPayment['plan_id'] == 6 || $upcomingPayment['plan_id'] == 7) : ?>
                                <?php $upcomingAmount = get_plan_price(1, $upcomingPayment['currency'] ?? 'USD'); ?>
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
                                'id' => isset($upcomingPayment['id']) ? $upcomingPayment['id'] : null,
                                'user_id' => $upcomingPayment['user_id'],
                                'payment_proof' => isset($upcomingPayment['payment_proof']) ? $upcomingPayment['payment_proof'] : null,
                                'processor' => isset($upcomingPayment['processor']) ? $upcomingPayment['processor'] : null,
                                'status' => isset($upcomingPayment['status']) ? $upcomingPayment['status'] : null,
                                'is_refund' => isset($upcomingPayment['is_refund']) ? $upcomingPayment['is_refund'] : null,
                            ]) ?>
                        </div>
                    </td>
                </tr>

            <?php endforeach ?>
        </tbody>
    </table>
</div>

<div class="mt-3"><?= $data->pagination ?></div>

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
                    }, 9000)
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
</script>