<?php

use Altum\Middlewares\Authentication;

if(isset($data->last_payment->new_plan_id)){
    $newPlanName  =  db()->where('plan_id', $data->last_payment->new_plan_id)->getOne('plans')->name;
}

$discount_text = '';
switch ($data->last_payment->code) {
    case '30OFF_FOREVER':
        $discount_text = '30 Off';
        break;
    case '50OFF_FOREVER':
        $discount_text = '50 Off';
        break;
    case '70OFF_FOREVER':
        $discount_text = '70 Off';
        break;
    case '90OFF_FOREVER':
        $discount_text = '90 Off';
        break;

    default:
        $discount_text = '';
}

defined('ALTUMCODE') || die() ?>
<?php $user = Authentication::$user ?>

<?php $userExpireDate =  (new \DateTime($data->user->plan_expiration_date))->setTimezone(new \DateTimeZone($data->user->timezone))->format('M j, Y'); ?>

<nav aria-label="breadcrumb">
    <ol class="custom-breadcrumbs small">
        <li>
            <a href="<?= url('admin/users') ?>"><?= l('admin_users.breadcrumb') ?></a><i class="fa fa-fw fa-angle-right"></i>
        </li>
        <li class="active" aria-current="page"><?= l('admin_user_update.breadcrumb') ?></li>
    </ol>
</nav>

<div class="d-flex justify-content-between mb-4">
    <h1 class="h3 mb-0 text-truncate"><i class="fa fa-fw fa-xs fa-user text-primary-900 mr-2"></i> <?= l('admin_user_update.header') ?></h1>

    <?= include_view(THEME_PATH . 'views/admin/users/admin_user_dropdown_button.php', ['id' => $data->user->user_id, 'type' => $data->user->type, 'referral_key' => isset($row->referral_key) ? $row->referral_key : null, 'resource_name' => $data->user->name]) ?>
</div>

<?= \Altum\Alerts::output_alerts() ?>

<?php //ALTUMCODE:DEMO if(DEMO) {$data->user->email = 'hidden@demo.com'; $data->user->name = $data->user->ip = 'hidden on demo';} 
?>

<div class="card <?= \Altum\Alerts::has_field_errors() ? 'border-danger' : null ?>">
    <div class="card-body">

        <form action="" method="post" role="form" enctype="multipart/form-data">
            <input type="hidden" name="token" value="<?= \Altum\Middlewares\Csrf::get() ?>" />

            <div class="form-group">
                <label for="name"><?= l('admin_users.main.name') ?></label>
                <input id="name" type="text" name="name" class="form-control form-control-lg <?= \Altum\Alerts::has_field_errors('name') ? 'is-invalid' : null ?>" value="<?= $data->user->name ?>" />
                <?= \Altum\Alerts::output_field_error('name') ?>
            </div>

            <div class="form-group">
                <label for="email"><?= l('admin_users.main.email') ?></label>
                <input id="email" type="email" name="email" class="form-control form-control-lg <?= \Altum\Alerts::has_field_errors('email') ? 'is-invalid' : null ?>" value="<?= $data->user->email ?>" required="required" />
                <?= \Altum\Alerts::output_field_error('email') ?>
            </div>

            <div class="form-group">
                <label for="email_subscription"><?= l('admin_users.main.email_subscrition_type.title') ?></label>
                <select id="email_subscription" name="email_subscription" class="form-control form-control-lg">
                    <option value="0" <?= $data->user->email_subscription_type == 0 ? 'selected="selected"' : null ?>><?= l('admin_users.main.email_subscrition_type_0') ?></option>
                    <option value="2" <?= $data->user->email_subscription_type == 2 ? 'selected="selected"' : null ?>><?= l('admin_users.main.email_subscrition_type_2') ?></option>
                    <option value="1" <?= $data->user->email_subscription_type == 1 ? 'selected="selected"' : null ?>><?= l('admin_users.main.email_subscrition_type_1') ?></option>
                </select>
            </div>

            <?php if ($user->type != 3) : ?>
                <div class="form-group">
                    <label for="type"><?= l('admin_users.main.type') ?></label>
                    <select id="type" name="type" class="form-control form-control-lg">
                        <option value="1" <?= $data->user->type == 1 ? 'selected="selected"' : null ?>><?= l('admin_users.main.type_admin') ?></option>
                        <option value="0" <?= $data->user->type == 0 ? 'selected="selected"' : null ?>><?= l('admin_users.main.type_user') ?></option>
                        <option value="3" <?= $data->user->type == 3 ? 'selected="selected"' : null ?>><?= l('admin_users.main.type_support') ?></option>
                    </select>
                    <small class="form-text text-muted"><?= l('admin_users.main.type_help') ?></small>
                </div>
            <?php endif ?>

            <div class="mt-5"></div>

            <h2 class="h4"><?= l('admin_user_update.plan.header') ?></h2>

            <div class="form-group">

                <label for="plan_id"><?= l('admin_users.main.plan_id') ?></label>
                <?php if ($data->user->plan->plan_id == 'free') : ?>
                    <input id="plan_id" type="text" name="plan_id" class="form-control form-control-lg " value="free" required="required" readonly />

                <?php else : ?>

                    <input type="hidden" id="plan_id" name="plan_id" value="<?= $data->user->plan->plan_id ?>">
                    <?php if ($data->last_payment->code == '') : ?>
                        <input type="text" class="form-control form-control-lg " value="<?= $data->user->plan->name . ' - ' . strtoupper($data->user->payment_currency) ?>" required="required" readonly />
                    <?php else : ?>
                        <?php if ($data->last_payment->new_plan_id && $data->last_payment->plan_id != $data->last_payment->new_plan_id) : ?>

                            <input type="text" class="form-control form-control-lg " value="<?= $newPlanName . ' - ' . $discount_text . ' - ' . strtoupper($data->user->payment_currency) ?>" required="required" readonly />
                        <?php else : ?>
                            <input type="text" class="form-control form-control-lg " value="<?= $data->last_plan_name . ' - ' . $discount_text . ' - ' . strtoupper($data->user->payment_currency) ?>" required="required" readonly />
                        <?php endif ?>
                    <?php endif ?>
                <?php endif ?>

            </div>

            <?php if ($data->user->plan->plan_id != 'free') : ?>
                <div class="form-group">
                    <label for="new_plan">New Plan</label>
                    <select id="new_plan" name="new_plan" class="form-control form-control-lg" <?= $data->user->plan->plan_id == '8' ? 'disabled' : '' ?>>

                        <option selected value="none">None</option>

                        <?php if ($data->user->plan->plan_id  == '2' || $data->user->plan->plan_id  == '3') : ?>
                            <!-- <option value="none">None</option> -->
                            <option value="8">Lifetime free</option>
                        <?php elseif ($data->user->plan->plan_id == '4' || $data->user->plan->plan_id == '5') : ?>
                            <!-- <option selected value="none">None</option> -->
                            <option value="8">Lifetime free</option>
                        <?php else :  ?>
                            <?php foreach ($data->plans as $plan) : ?>
                                <?php if ($plan->plan_id == '1' || $plan->plan_id == '2' || $plan->plan_id == '3' || $plan->plan_id == '8') : ?>
                                    <option value="<?= $plan->plan_id ?>"><?= $plan->name ?></option>
                                <?php endif ?>
                            <?php endforeach; ?>
                        <?php endif ?>
                    </select>
                </div>
            <?php else : ?>
                <div class="form-group">
                    <label for="new_plan">New Plan</label>
                    <select id="new_plan" name="new_plan" class="form-control form-control-lg">

                        <option selected value="none">None</option>
                        <option value="8">Lifetime free</option>

                    </select>
                </div>
            <?php endif ?>

            <?php if ($data->user->plan->plan_id != 'free') : ?>
                <div class="form-group  discount-option" id="discount-option">
                    <label for="discount">Discount</label>

                    <?php if ($data->last_payment->code != '') : ?>
                        <?php if ($data->last_payment->code == '30OFF_FOREVER' || $data->last_payment->code == '50OFF_FOREVER' || $data->last_payment->code == '70OFF_FOREVER' || $data->last_payment->code == '90OFF_FOREVER') : ?>
                            <select id="discount" name="discount" class="form-control form-control-lg" <?= $data->user->plan->plan_id == '8' ? 'disabled' : '' ?>>
                                <option value="" disabled selected>None</option>
                                <option value="30">30 OFF</option>
                                <option value="50">50 OFF</option>
                                <option value="70">70 OFF</option>
                                <option value="90">90 OFF</option>
                            </select>
                        <?php elseif ($data->last_payment->code == '70OFF') : ?>
                            <input class="form-control form-control-lg " value="70 OFF" required="required" readonly />

                            <input class="form-control form-control-lg " value="None" required="required" readonly />
                        <?php endif ?>
                    <?php else : ?>
                        <select id="discount" name="discount" <?= $data->last_payment->code || $data->user->plan->plan_id == '8' ? 'disabled' : null  ?> class="form-control form-control-lg">
                            <option value="" disabled selected>None</option>
                            <option value="30">30 OFF</option>
                            <option value="50">50 OFF</option>
                            <option value="70">70 OFF</option>
                            <option value="90">90 OFF</option>
                        </select>
                    <?php endif ?>
                </div>
            <?php endif ?>

            <?php if ($data->user->plan->plan_id != 'free') : ?>
                <div class="form-group">
                    <label for="refund">Refund</label>
                    <select id="refund" name="refund" class="form-control form-control-lg" <?= $data->user->plan->plan_id == '8' ? 'disabled' : '' ?>>
                        <option value="1"><?= l('global.yes') ?></option>
                        <option value="0" selected>None</option>
                    </select>
                </div>
            <?php endif ?>

            <?php if ($data->user->plan->plan_id == 'free') : ?>
                <div class="form-group">
                    <label for="plan_trial_done"><?= l('admin_users.main.plan_trial_done') ?></label>
                    <select id="plan_trial_done" name="plan_trial_done" class="form-control form-control-lg">
                        <option value="1" <?= $data->user->plan_trial_done ? 'selected="selected"' : null ?>><?= l('global.yes') ?></option>
                        <option value="0" <?= !$data->user->plan_trial_done ? 'selected="selected"' : null ?>><?= l('global.no') ?></option>
                    </select>
                </div>
            <?php endif ?>


            <div id="plan_expiration_date_container" class="form-group">
                <label for="plan_expiration_date"><?= l('admin_users.main.plan_expiration_date') ?></label>
                <input id="plan_expiration_date" type="text" name="plan_expiration_date" class="form-control form-control-lg" autocomplete="off" value="<?= $userExpireDate ?>">
                <div class="invalid-feedback">
                    <?= l('admin_user_update.plan.plan_expiration_date_invalid') ?>
                </div>
            </div>

            <div id="plan_settings" style="display: none">
                <div class="form-group">
                    <label for="qr_codes_limit"><?= l('admin_plans.plan.qr_codes_limit') ?></label>
                    <input type="number" id="qr_codes_limit" name="qr_codes_limit" min="-1" class="form-control form-control-lg" value="<?= $data->user->plan->settings->qr_codes_limit ?>" />
                    <small class="form-text text-muted"><?= l('admin_plans.plan.unlimited') ?></small>
                </div>

                <div class="form-group">
                    <label for="links_limit"><?= l('admin_plans.plan.links_limit') ?></label>
                    <input type="number" id="links_limit" name="links_limit" min="-1" class="form-control form-control-lg" value="<?= $data->user->plan->settings->links_limit ?>" />
                    <small class="form-text text-muted"><?= l('admin_plans.plan.unlimited') ?></small>
                </div>

                <div class="form-group">
                    <label for="projects_limit"><?= l('admin_plans.plan.projects_limit') ?></label>
                    <input type="number" id="projects_limit" name="projects_limit" min="-1" class="form-control form-control-lg" value="<?= $data->user->plan->settings->projects_limit ?>" />
                    <small class="form-text text-muted"><?= l('admin_plans.plan.unlimited') ?></small>
                </div>

                <div class="form-group">
                    <label for="pixels_limit"><?= l('admin_plans.plan.pixels_limit') ?></label>
                    <input type="number" id="pixels_limit" name="pixels_limit" min="-1" class="form-control form-control-lg" value="<?= $data->user->plan->settings->pixels_limit ?>" />
                    <small class="form-text text-muted"><?= l('admin_plans.plan.unlimited') ?></small>
                </div>

                <div class="form-group">
                    <label for="domains_limit"><?= l('admin_plans.plan.domains_limit') ?></label>
                    <input type="number" id="domains_limit" name="domains_limit" min="-1" class="form-control form-control-lg" value="<?= $data->user->plan->settings->domains_limit ?>" />
                    <small class="form-text text-muted"><?= l('admin_plans.plan.unlimited') ?></small>
                </div>

                <?php if (\Altum\Plugin::is_active('teams')) : ?>
                    <div class="form-group">
                        <label for="teams_limit"><?= l('admin_plans.plan.teams_limit') ?></label>
                        <input type="number" id="teams_limit" name="teams_limit" min="-1" class="form-control form-control-lg" value="<?= $data->user->plan->settings->teams_limit ?>" />
                        <small class="form-text text-muted"><?= l('admin_plans.plan.unlimited') ?></small>
                    </div>

                    <div class="form-group">
                        <label for="team_members_limit"><?= l('admin_plans.plan.team_members_limit') ?></label>
                        <input type="number" id="team_members_limit" name="team_members_limit" min="-1" class="form-control form-control-lg" value="<?= $data->user->plan->settings->team_members_limit ?>" />
                        <small class="form-text text-muted"><?= l('admin_plans.plan.unlimited') ?></small>
                    </div>
                <?php endif ?>

                <?php if (\Altum\Plugin::is_active('affiliate') && settings()->affiliate->is_enabled) : ?>
                    <div class="form-group">
                        <label for="affiliate_commission_percentage"><?= l('admin_plans.plan.affiliate_commission_percentage') ?></label>
                        <input type="number" id="affiliate_commission_percentage" name="affiliate_commission_percentage" min="0" max="100" class="form-control form-control-lg" value="<?= $data->user->plan->settings->affiliate_commission_percentage ?>" />
                        <small class="form-text text-muted"><?= l('admin_plans.plan.affiliate_commission_percentage_help') ?></small>
                    </div>
                <?php endif ?>

                <div class="form-group">
                    <label for="statistics_retention"><?= l('admin_plans.plan.statistics_retention') ?></label>
                    <input type="number" id="statistics_retention" name="statistics_retention" min="-1" class="form-control form-control-lg" value="<?= $data->user->plan->settings->statistics_retention ?>" />
                    <small class="form-text text-muted"><?= l('admin_plans.plan.statistics_retention_help') ?></small>
                </div>

                <div class="custom-control custom-switch my-3">
                    <input id="additional_domains_is_enabled" name="additional_domains_is_enabled" type="checkbox" class="custom-control-input" <?= $data->user->plan->settings->additional_domains_is_enabled ? 'checked="checked"' : null ?>>
                    <label class="custom-control-label" for="additional_domains_is_enabled"><?= l('admin_plans.plan.additional_domains_is_enabled') ?></label>
                    <div><small class="form-text text-muted"><?= l('admin_plans.plan.additional_domains_is_enabled_help') ?></small></div>
                </div>

                <div class="custom-control custom-switch my-3">
                    <input id="no_ads" name="no_ads" type="checkbox" class="custom-control-input" <?= $data->user->plan->settings->no_ads ? 'checked="checked"' : null ?>>
                    <label class="custom-control-label" for="no_ads"><?= l('admin_plans.plan.no_ads') ?></label>
                    <div><small class="form-text text-muted"><?= l('admin_plans.plan.no_ads_help') ?></small></div>
                </div>

                <div class="custom-control custom-switch my-3">
                    <input id="analytics_is_enabled" name="analytics_is_enabled" type="checkbox" class="custom-control-input" <?= $data->user->plan->settings->analytics_is_enabled ? 'checked="checked"' : null ?>>
                    <label class="custom-control-label" for="analytics_is_enabled"><?= l('admin_plans.plan.analytics_is_enabled') ?></label>
                    <div><small class="form-text text-muted"><?= l('admin_plans.plan.analytics_is_enabled_help') ?></small></div>
                </div>

                <div class="custom-control custom-switch my-3">
                    <input id="custom_url_is_enabled" name="custom_url_is_enabled" type="checkbox" class="custom-control-input" <?= $data->user->plan->settings->custom_url_is_enabled ? 'checked="checked"' : null ?>>
                    <label class="custom-control-label" for="custom_url_is_enabled"><?= l('admin_plans.plan.custom_url_is_enabled') ?></label>
                    <div><small class="form-text text-muted"><?= l('admin_plans.plan.custom_url_is_enabled_help') ?></small></div>
                </div>

                <div class="custom-control custom-switch my-3">
                    <input id="password_protection_is_enabled" name="password_protection_is_enabled" type="checkbox" class="custom-control-input" <?= $data->user->plan->settings->password_protection_is_enabled ? 'checked="checked"' : null ?>>
                    <label class="custom-control-label" for="password_protection_is_enabled"><?= l('admin_plans.plan.password_protection_is_enabled') ?></label>
                    <div><small class="form-text text-muted"><?= l('admin_plans.plan.password_protection_is_enabled_help') ?></small></div>
                </div>

                <div class="custom-control custom-switch my-3">
                    <input id="sensitive_content_is_enabled" name="sensitive_content_is_enabled" type="checkbox" class="custom-control-input" <?= $data->user->plan->settings->sensitive_content_is_enabled ? 'checked="checked"' : null ?>>
                    <label class="custom-control-label" for="sensitive_content_is_enabled"><?= l('admin_plans.plan.sensitive_content_is_enabled') ?></label>
                    <div><small class="form-text text-muted"><?= l('admin_plans.plan.sensitive_content_is_enabled_help') ?></small></div>
                </div>

                <div class="custom-control custom-switch my-3">
                    <input id="api_is_enabled" name="api_is_enabled" type="checkbox" class="custom-control-input" <?= $data->user->plan->settings->api_is_enabled ? 'checked="checked"' : null ?>>
                    <label class="custom-control-label" for="api_is_enabled"><?= l('admin_plans.plan.api_is_enabled') ?></label>
                    <div><small class="form-text text-muted"><?= l('admin_plans.plan.api_is_enabled_help') ?></small></div>
                </div>

                <div class="custom-control custom-switch my-3">
                    <input id="qr_reader_is_enabled" name="qr_reader_is_enabled" type="checkbox" class="custom-control-input" <?= $data->user->plan->settings->qr_reader_is_enabled ? 'checked="checked"' : null ?>>
                    <label class="custom-control-label" for="qr_reader_is_enabled"><?= l('admin_plans.plan.qr_reader_is_enabled') ?></label>
                    <div><small class="form-text text-muted"><?= l('admin_plans.plan.qr_reader_is_enabled_help') ?></small></div>
                </div>

                <h3 class="h5 mt-4"><?= l('admin_plans.plan.enabled_qr_codes') ?></h3>
                <p class="text-muted"><?= l('admin_plans.plan.enabled_qr_codes_help') ?></p>

                <div class="row">
                    <?php foreach (array_keys((require APP_PATH . 'includes/qr_code.php')['type']) as $key) : ?>
                        <div class="col-6 mb-3">
                            <div class="custom-control custom-switch">
                                <input id="enabled_qr_codes_<?= $key ?>" name="enabled_qr_codes[]" value="<?= $key ?>" type="checkbox" class="custom-control-input" <?= $data->user->plan->settings->enabled_qr_codes->{$key} ? 'checked="checked"' : null ?>>
                                <label class="custom-control-label" for="enabled_qr_codes_<?= $key ?>"><?= l('qr_codes.type.' . mb_strtolower($key)) ?></label>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>

            <div class="mt-5"></div>

            <h2 class="h4"><?= l('admin_user_update.change_password.header') ?></h2>
            <p class="text-muted"><?= l('admin_user_update.change_password.subheader') ?></p>

            <div class="form-group">
                <label for="new_password"><?= l('admin_user_update.change_password.new_password') ?></label>
                <input id="new_password" type="password" name="new_password" class="form-control form-control-lg <?= \Altum\Alerts::has_field_errors('new_password') ? 'is-invalid' : null ?>" />
                <?= \Altum\Alerts::output_field_error('new_password') ?>
            </div>

            <div class="form-group">
                <label for="repeat_password"><?= l('admin_user_update.change_password.repeat_password') ?></label>
                <input id="repeat_password" type="password" name="repeat_password" class="form-control form-control-lg <?= \Altum\Alerts::has_field_errors('new_password') ? 'is-invalid' : null ?>" />
                <?= \Altum\Alerts::output_field_error('new_password') ?>
            </div>

            <button type="submit" name="submit" class="btn btn-lg btn-block btn-primary mt-4"><?= l('global.update') ?></button>
        </form>
    </div>
</div>

<?php ob_start() ?>
<link href="<?= ASSETS_FULL_URL . 'css/daterangepicker.min.css' ?>" rel="stylesheet" media="screen,print">
<?php \Altum\Event::add_content(ob_get_clean(), 'head') ?>

<?php ob_start() ?>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.js"></script>
<script src="<?= ASSETS_FULL_URL . 'js/libraries/moment.min.js' ?>"></script>
<script src="<?= ASSETS_FULL_URL . 'js/libraries/daterangepicker.min.js' ?>"></script>
<script src="<?= ASSETS_FULL_URL . 'js/libraries/moment-timezone-with-data-10-year-range.min.js' ?>"></script>

<script>
    'use strict';

    moment.tz.setDefault(<?= json_encode($this->user->timezone) ?>);

    let check_plan_id = () => {
        let selected_plan_id = document.querySelector('[name="plan_id"]').value;

        if (selected_plan_id == 'free') {
            document.querySelector('#plan_expiration_date_container').style.display = 'none';

        } else {
            document.querySelector('#plan_expiration_date_container').style.display = 'block';
        }

        if (selected_plan_id == 'custom') {
            document.querySelector('#plan_settings').style.display = 'block';
        } else {
            document.querySelector('#plan_settings').style.display = 'none';
        }
    };

    check_plan_id();

    /* Dont show expiration date when the chosen plan is the free one */
    document.querySelector('[name="plan_id"]').addEventListener('change', check_plan_id);

    /* Check for expiration date to show a warning if expired */
    let check_plan_expiration_date = () => {
        let plan_expiration_date = document.querySelector('[name="plan_expiration_date"]');

        let plan_expiration_date_object = new Date(plan_expiration_date.value);
        let today_date_object = new Date();

        if (plan_expiration_date_object < today_date_object) {
            plan_expiration_date.classList.add('is-invalid');
        } else {
            plan_expiration_date.classList.remove('is-invalid');
        }
    };

    check_plan_expiration_date();
    document.querySelector('[name="plan_expiration_date"]').addEventListener('change', check_plan_expiration_date);

    /* Daterangepicker */
    $('[name="plan_expiration_date"]').daterangepicker({
        startDate: <?= json_encode($userExpireDate) ?>,
        minDate: new Date(),
        alwaysShowCalendars: true,
        singleCalendar: true,
        singleDatePicker: true,
        locale: <?= json_encode(require APP_PATH . 'includes/daterangepicker_translations.php') ?>,
    }, (start, end, label) => {
        check_plan_expiration_date()
    });

    $(document).ready(function() {
        $('#plan_id').on('change', function() {
            var plan_name = document.querySelector('[name="plan_id"]').value;
            if (plan_name == 'free' || plan_name == 'custom' || plan_name == 5) {
                $(".discount-option").addClass('d-none');
            } else {
                $(".discount-option").removeClass('d-none');
            }
        });
    });

    $('#new_plan').on('change', function() {
        var plan_id = $(this).val();
        if (plan_id == '8') {
            $('#discount').val('');
            $('#discount').attr('disabled', true);
            $('#refund').attr('disabled', true);
        } else {
            $('#discount').attr('disabled', false);
            $('#refund').attr('disabled', false);
        }

    });


    const currentPlan = document.getElementById('plan_id');
    const newPlan = document.getElementById('new_plan');

    newPlan.addEventListener('change', function() {
        var data = {
            action: 'get_discounts',
            currentPlan: currentPlan.value,
            newPlan: newPlan.value
        }

        $.ajax({
            type: 'POST',
            url: '<?= url('api/ajax_new') ?>',
            data: data,
            success: function(response) {
                var selectElement = document.getElementById('discount');
                selectElement.innerHTML = '';

                var defaultOption = document.createElement('option');
                defaultOption.value = '';
                defaultOption.text = 'None';
                selectElement.appendChild(defaultOption);

                response.data.forEach(function(item) {
                    var option = document.createElement('option');
                    option.value = item;
                    option.text = item + ' OFF';
                    selectElement.appendChild(option);
                });

            }
        });
    });
</script>
<?php \Altum\Event::add_content(ob_get_clean(), 'javascript') ?>

<?php \Altum\Event::add_content(include_view(THEME_PATH . 'views/partials/universal_delete_modal_url.php', [
    'name' => 'user',
    'resource_id' => 'user_id',
    'has_dynamic_resource_name' => true,
    'path' => 'admin/users/delete/'
]), 'modals'); ?>
<?php \Altum\Event::add_content(include_view(THEME_PATH . 'views/admin/users/user_login_modal.php'), 'modals'); ?>
<?php \Altum\Event::add_content(include_view(THEME_PATH . 'views/admin/users/user_plan_generate_modal.php'), 'modals'); ?>