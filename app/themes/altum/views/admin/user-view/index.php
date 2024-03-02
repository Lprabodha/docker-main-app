<?php

if ($data->user->plan_id == 'free' && $data->user->payment_processor == null && (new DateTime($data->user->plan_expiration_date) > new DateTime())) {
    $planName = 'Free Trial';
} else if ((new DateTime($data->user->plan_expiration_date) < new DateTime())) {
    $planName = 'Inactive';
} else {
    $planName = $data->user->plan->name;
}

$subscriptionUser = analyticsDatabase()->query("SELECT * FROM `subscription_users` WHERE `user_id` = {$data->user->user_id} ORDER BY `id` DESC LIMIT 1")->fetch_object();

if($data->user->plan->plan_id == 'free' || $data->user->plan->plan_id == 5 ||  $data->user->plan->plan_id == 8) {
    $next_subscription =   'NULL';
}else if ($subscriptionUser->subscription_change == 'cancellation') {
    $next_subscription = 'Cancelled';
}else if($subscriptionUser->subscription_change == 'downgrade') {
    $next_subscription = $subscriptionUser->new_plan;
}else if($subscriptionUser->subscription_change == 'reactivation') {
    $next_subscription = $subscriptionUser->new_plan;
}
else if($data->user->plan->plan_id == 6 || $data->user->plan->plan_id == 7) {
    $next_subscription= 'Monthly';
}
else{
    $next_subscription =  $data->user->plan->name;
}


use Altum\Middlewares\Authentication;

defined('ALTUMCODE') || die() ?>
<?php $user = Authentication::$user ?>

<nav aria-label="breadcrumb">
    <ol class="custom-breadcrumbs small">
        <li>
            <a href="<?= url('admin/users') ?>"><?= l('admin_users.breadcrumb') ?></a><i class="fa fa-fw fa-angle-right"></i>
        </li>
        <li class="active" aria-current="page"><?= l('admin_user_view.breadcrumb') ?></li>
    </ol>
</nav>

<div class="d-flex justify-content-between mb-4">
    <h1 class="h3 mb-0 text-truncate"><i class="fa fa-fw fa-xs fa-user text-primary-900 mr-2"></i> <?= l('admin_user_view.header') ?></h1>

    <?= include_view(THEME_PATH . 'views/admin/users/admin_user_dropdown_button.php', ['id' => $data->user->user_id, 'type' => $data->user->type, 'referral_key' => $data->user->referral_key, 'resource_name' => $data->user->name]) ?>
</div>

<?= \Altum\Alerts::output_alerts() ?>

<?php //ALTUMCODE:DEMO if(DEMO) {$data->user->email = 'hidden@demo.com'; $data->user->name = $data->user->ip = 'hidden on demo';} 
?>

<div class="row">
    <div class="col-xl-4 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="form-group">
                    <label for="type" class="font-weight-bold"><i class="fa fa-fw fa-sm fa-user text-muted mr-1"></i> <?= l('admin_users.main.type') ?></label>
                    <input id="type" type="text" class="form-control-plaintext" value="<?= $data->user->type ? l('admin_users.main.type_admin') : l('admin_users.main.type_user') ?>" readonly />
                </div>

                <div class="form-group">
                    <label for="email" class="font-weight-bold"><i class="fa fa-fw fa-sm fa-envelope text-muted mr-1"></i> <?= l('admin_users.main.email') ?></label>
                    <input id="email" type="text" class="form-control-plaintext" value="<?= $data->user->email ?>" readonly />
                </div>

                <div class="form-group">
                    <label for="email_subscription" class="font-weight-bold"><i class="fa fa-fw fa-sm fa-envelope text-muted mr-1"></i><?= l('admin_users.main.email_subscrition_type.title_2') ?></label>
                    <input id="email_subscription" type="text" class="form-control-plaintext" value="<?php if ($data->user->email_subscription_type == 0) echo l('admin_users.main.email_subscrition_type_0');
                                                                                                        elseif ($data->user->email_subscription_type == 1) echo l('admin_users.main.email_subscrition_type_1');
                                                                                                        elseif ($data->user->email_subscription_type == 2) echo l('admin_users.main.email_subscrition_type_2') ?>" readonly />
                </div>

                <div class="form-group">
                    <label for="name" class="font-weight-bold"><i class="fa fa-fw fa-sm fa-signature text-muted mr-1"></i> <?= l('admin_users.main.name') ?></label>
                    <input id="name" type="text" class="form-control-plaintext" value="<?= $data->user->name ?>" readonly />
                </div>

                <div class="form-group">
                    <label for="language" class="font-weight-bold"><i class="fa fa-fw fa-sm fa-language text-muted mr-1"></i> <?= l('admin_users.main.language') ?></label>
                    <input id="language" type="text" class="form-control-plaintext" value="<?= $data->user->language ?>" readonly />
                </div>

                <div class="form-group">
                    <label for="timezone" class="font-weight-bold"><i class="fa fa-fw fa-sm fa-clock text-muted mr-1"></i> <?= l('admin_users.main.timezone') ?></label>
                    <input id="timezone" type="text" class="form-control-plaintext" value="<?= $data->user->timezone ?>" readonly />
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="form-group">
                    <label class="font-weight-bold"><i class="fa fa-fw fa-sm fa-box-open text-muted mr-1"></i> Signup funnel</label>
                    <div>
                        <span class="badge badge-success p-2" style="background-color: #28c254; color: white; width: 75px;">
                            <?= $data->funnel ?>
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="font-weight-bold"><i class="fa fa-fw fa-sm fa-box-open text-muted mr-1"></i> <?= l('admin_users.main.plan_id') ?></label>
                    <div>
                        <?php if ($user->type != '3') : ?>
                            <a href="<?= url('admin/plan-update/' . $data->user->plan->plan_id) ?>"><?= $planName ?></a>
                        <?php else : ?>
                            <a><?= $planName ?></a>
                        <?php endif ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold"><i class="fa fa-fw fa-sm fa-box-open text-muted mr-1"></i> Next Subscription</label>
                    <input id="cancel_subscription" type="text" class="form-control-plaintext" value="<?= $next_subscription  ?>" readonly />
                </div>

                <div class="form-group">
                    <label for="plan_expiration_date" class="font-weight-bold"><i class="fa fa-fw fa-sm fa-calendar text-muted mr-1"></i> <?= l('admin_users.main.plan_expiration_date') ?></label>
                    <input id="plan_expiration_date" type="text" class="form-control-plaintext" value="<?= \Altum\Date::get($data->user->plan_expiration_date, 1) ?>" readonly />
                </div>

                <?php if (in_array(settings()->license->type, ['Extended License', 'extended'])) : ?>
                    <div class="form-group">
                        <label for="payment_processor" class="font-weight-bold"><i class="fa fa-fw fa-sm fa-money-check-alt text-muted mr-1"></i> <?= l('admin_users.main.payment_processor') ?></label>
                        <input id="payment_processor" type="text" class="form-control-plaintext" value="<?= $data->user->payment_processor ? l('pay_custom_plan.' . $data->user->payment_processor) : null ?>" readonly />
                    </div>

                    <div class="form-group">
                        <label for="payment_total_amount" class="font-weight-bold"><i class="fa fa-fw fa-sm fa-money-bill-alt text-muted mr-1"></i> <?= l('admin_users.main.payment_total_amount') ?></label>
                        <input id="payment_total_amount" type="text" class="form-control-plaintext" value="<?= $data->user->payment_total_amount ? nr($data->user->payment_total_amount, 2) . ' ' . $data->user->payment_currency : null ?>" readonly />
                    </div>

                    <div class="form-group">
                        <label for="payment_subscription_id" class="font-weight-bold"><i class="fa fa-fw fa-sm fa-hand-holding-usd text-muted mr-1"></i> <?= l('admin_users.main.payment_subscription_id') ?></label>
                        <input id="payment_subscription_id" type="text" class="form-control-plaintext" value="<?= $data->user->payment_subscription_id ?>" readonly />
                    </div>

                    <div class="form-group">
                        <label for="plan_trial_done" class="font-weight-bold"><i class="fa fa-fw fa-sm fa-calendar-minus text-muted mr-1"></i> <?= l('admin_users.main.plan_trial_done') ?></label>
                        <input id="plan_trial_done" type="text" class="form-control-plaintext" value="<?= $data->user->plan_trial_done ? l('global.yes') : l('global.no') ?>" readonly />
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>

    <div class="col-xl-4 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="form-group">
                    <label for="source" class="font-weight-bold"><i class="fa fa-fw fa-sm fa-sign-in-alt text-muted mr-1"></i> <?= l('admin_users.main.source') ?></label>
                    <input id="source" type="text" class="form-control-plaintext" value="<?= l('admin_users.main.source.' .  $data->user->source) ?>" readonly />
                </div>

                <div class="form-group">
                    <label for="ip" class="font-weight-bold"><i class="fa fa-fw fa-sm fa-network-wired text-muted mr-1"></i> <?= l('admin_users.main.ip') ?></label>
                    <input id="ip" type="text" class="form-control-plaintext" value="<?= $data->user->ip ?>" readonly />
                </div>

                <div class="form-group">
                    <label for="country" class="font-weight-bold"><i class="fa fa-fw fa-sm fa-flag text-muted mr-1"></i> <?= l('admin_users.main.country') ?></label>
                    <input id="country" type="text" class="form-control-plaintext" value="<?= $data->user->country ?>" readonly />
                </div>

                <div class="form-group">
                    <label for="currency_code" class="font-weight-bold"><i class="fa fa-fw fa-sm fa-flag text-muted mr-1"></i> Currency</label>
                    <input id="currency_code" type="text" class="form-control-plaintext" value="<?= isset($data->user->payment_currency) ?  $data->user->payment_currency : 'USD' ?>" readonly />
                </div>

                <div class="form-group">
                    <label for="last_activity" class="font-weight-bold"><i class="fa fa-fw fa-sm fa-history text-muted mr-1"></i> <?= l('admin_users.main.last_activity') ?></label>
                    <input id="last_activity" type="text" class="form-control-plaintext" value="<?= $data->user->last_activity ? \Altum\Date::get($data->user->last_activity, 1) : '-' ?>" readonly />
                </div>

                <div class="form-group">
                    <label for="last_user_agent" class="font-weight-bold"><i class="fa fa-fw fa-sm fa-desktop text-muted mr-1"></i> <?= l('admin_users.main.last_user_agent') ?></label>
                    <input id="last_user_agent" type="text" class="form-control-plaintext" value="<?= $data->user->last_user_agent ?>" readonly />
                </div>

                <div class="form-group">
                    <label for="total_logins" class="font-weight-bold"><i class="fa fa-fw fa-sm fa-calendar-alt text-muted mr-1"></i> <?= l('admin_users.main.total_logins') ?></label>
                    <input id="total_logins" type="text" class="form-control-plaintext" value="<?= $data->user->total_logins ?>" readonly />
                </div>

                <?php if (\Altum\Plugin::is_active('affiliate') && settings()->affiliate->is_enabled) : ?>
                    <div class="form-group">
                        <label for="referral_key" class="font-weight-bold"><i class="fa fa-fw fa-sm fa-users text-muted mr-1"></i> <?= l('admin_users.main.referral_key') ?></label>
                        <input id="referral_key" type="text" class="form-control-plaintext" value="<?= $data->user->referral_key ?>" readonly />
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold"><i class="fa fa-fw fa-sm fa-user-plus text-muted mr-1"></i> <?= l('admin_users.main.referred_by') ?></label>
                        <div>
                            <a href="<?= url('admin/user-view/' . $data->user->referred_by) ?>"><?= $data->user->referred_by ?></a>
                        </div>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>

<?php if ($data->user->payment_processor != null &&  in_array(settings()->license->type, ['Extended License', 'extended']) && settings()->payment->is_enabled && settings()->payment->taxes_and_billing_is_enabled) : ?>

    <div class="accordion">
        <div class="card">
            <div class="card-body p-3 position-relative">
                <h3 class="h6 m-0">
                    <a href="#" class="stretched-link" data-toggle="collapse" data-target="#billing" aria-expanded="true" aria-controls="billing">
                        <?= l('admin_user_view.billing') ?>
                    </a>
                </h3>
            </div>

            <div id="billing" class="collapse">
                <div class="card-body">

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="billing_type" class="font-weight-bold"><?= l('global.account.billing.type') ?></label>
                                <input id="billing_type" type="text" class="form-control-plaintext" value="<?= isset($data->user->billing->type) ?  l('account.billing.type_' . $data->user->billing->type) : null ?>" readonly />
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label for="billing_name" class="font-weight-bold"><?= l('global.account.billing.name') ?></label>
                                <input id="billing_name" type="text" name="billing_name" class="form-control-plaintext" value="<?= $data->user->billing->name ?>" readonly />
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label for="billing_address" class="font-weight-bold"><?= l('global.account.billing.address') ?></label>
                                <input id="billing_address" type="text" name="billing_address" class="form-control-plaintext" value="<?= $data->user->billing->line1 ?>" readonly />
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="billing_city" class="font-weight-bold"><?= l('global.account.billing.city') ?></label>
                                <input id="billing_city" type="text" name="billing_city" class="form-control-plaintext" value="<?= $data->user->billing->city ?>" readonly />
                            </div>
                        </div>

                        <div class="col-12 col-lg-4">
                            <div class="form-group">
                                <label for="billing_county" class="font-weight-bold"><?= l('global.account.billing.county') ?></label>
                                <input id="billing_county" type="text" name="billing_county" class="form-control-plaintext" value="<?= isset($data->user->billing->county) ? $data->user->billing->county : null ?>" readonly />
                            </div>
                        </div>

                        <div class="col-12 col-lg-2">
                            <div class="form-group">
                                <label for="billing_zip" class="font-weight-bold"><?= l('global.account.billing.zip') ?></label>
                                <input id="billing_zip" type="text" name="billing_zip" class="form-control-plaintext" value="<?= $data->user->billing->zip ?>" readonly />
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label for="billing_country" class="font-weight-bold"><?= l('global.account.billing.country') ?></label>
                                <input id="billing_country" type="text" class="form-control-plaintext" value="<?= $data->user->billing->country ?>" readonly />
                            </div>
                        </div>

                        <?php if (isset($data->user->billing->phone)) :  ?>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="billing_phone" class="font-weight-bold"><?= l('global.account.billing.phone') ?></label>
                                    <input id="billing_phone" type="text" name="billing_phone" class="form-control-plaintext" value="<?= $data->user->billing->phone ?>" readonly />
                                </div>
                            </div>
                        <?php endif ?>
                        <?php if (isset($data->user->billing->tax_id)) :  ?>
                            <div class="col-12" id="billing_tax_id_container">
                                <div class="form-group">
                                    <label for="billing_tax_id" class="font-weight-bold"><?= !empty(settings()->business->tax_type) ? settings()->business->tax_type : l('global.account.billing.tax_id') ?></label>
                                    <input id="billing_tax_id" type="text" name="billing_tax_id" class="form-control-plaintext" value="<?= $data->user->billing->tax_id ?>" readonly />
                                </div>
                            </div>
                        <?php endif ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
<?php endif ?>

<div class="my-5 row justify-content-between">
    <div class="col-12 col-sm-6 col-xl-3 mb-4 position-relative">
        <div class="card d-flex flex-row h-100 overflow-hidden">
            <div class="card-body">
                <small class="text-muted"><i class="fa fa-fw fa-sm fa-qrcode mr-1"></i> <?= l('admin_user_view.qr_codes') ?></small>

                <div class="mt-3"><span class="h4"><?= nr($data->qr_codes) ?></span></div>
            </div>

            <div class="bg-gray-200 px-2 d-flex flex-column justify-content-center">
                <a href="<?= url('admin/qr-codes?user_id=' . $data->user->user_id) ?>" class="stretched-link">
                    <i class="fa fa-fw fa-angle-right text-gray-500"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3 mb-4 position-relative">
        <div class="card d-flex flex-row h-100 overflow-hidden">
            <div class="card-body">
                <small class="text-muted"><i class="fa fa-fw fa-sm fa-link mr-1"></i> <?= l('admin_user_view.links') ?></small>

                <div class="mt-3"><span class="h4"><?= nr($data->links) ?></span></div>
            </div>

            <div class="bg-gray-200 px-2 d-flex flex-column justify-content-center">
                <a href="<?= url('admin/links?user_id=' . $data->user->user_id) ?>" class="stretched-link">
                    <i class="fa fa-fw fa-angle-right text-gray-500"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3 mb-4 position-relative">
        <div class="card d-flex flex-row h-100 overflow-hidden">
            <div class="card-body">
                <small class="text-muted"><i class="fa fa-fw fa-sm fa-adjust mr-1"></i> <?= l('admin_user_view.pixels') ?></small>

                <div class="mt-3"><span class="h4"><?= nr($data->pixels) ?></span></div>
            </div>

            <div class="bg-gray-200 px-2 d-flex flex-column justify-content-center">
                <a href="<?= url('admin/pixels?user_id=' . $data->user->user_id) ?>" class="stretched-link">
                    <i class="fa fa-fw fa-angle-right text-gray-500"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3 mb-4 position-relative">
        <div class="card d-flex flex-row h-100 overflow-hidden">
            <div class="card-body">
                <small class="text-muted"><i class="fa fa-fw fa-sm fa-folder mr-1"></i> <?= l('admin_user_view.projects') ?></small>

                <div class="mt-3"><span class="h4"><?= nr($data->projects) ?></span></div>
            </div>

            <div class="bg-gray-200 px-2 d-flex flex-column justify-content-center">
                <a href="<?= url('admin/projects?user_id=' . $data->user->user_id) ?>" class="stretched-link">
                    <i class="fa fa-fw fa-angle-right text-gray-500"></i>
                </a>
            </div>
        </div>
    </div>

    <?php if ($user->type != 3) : ?>
        <div class="col-12 col-sm-6 col-xl-3 mb-4 position-relative">
            <div class="card d-flex flex-row h-100 overflow-hidden">
                <div class="card-body">
                    <small class="text-muted"><i class="fa fa-fw fa-sm fa-globe mr-1"></i> <?= l('admin_user_view.domains') ?></small>

                    <div class="mt-3"><span class="h4"><?= nr($data->domains) ?></span></div>
                </div>

                <div class="bg-gray-200 px-2 d-flex flex-column justify-content-center">
                    <a href="<?= url('admin/domains?user_id=' . $data->user->user_id) ?>" class="stretched-link">
                        <i class="fa fa-fw fa-angle-right text-gray-500"></i>
                    </a>
                </div>
            </div>
        </div>
    <?php endif ?>

    <div class="col-12 col-sm-6 col-xl-3 mb-4 position-relative">
        <div class="card d-flex flex-row h-100 overflow-hidden">
            <div class="card-body">
                <small class="text-muted"><i class="fa fa-fw fa-sm fa-funnel-dollar mr-1"></i> <?= l('admin_user_view.payments') ?></small>

                <div class="mt-3"><span class="h4"><?= nr($data->payments) ?></span></div>
            </div>

            <div class="bg-gray-200 px-2 d-flex flex-column justify-content-center">
                <a href="<?= url('admin/payments?user_id=' . $data->user->user_id) ?>" class="stretched-link">
                    <i class="fa fa-fw fa-angle-right text-gray-500"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="my-5 row justify-content-between">
    <div class="col-12 col-sm-6 mb-4 position-relative">
        <div class="card d-flex flex-row h-100 overflow-hidden">
            <div class="card-body">
                <span class="text-muted"><i class="fa fa-fw fa-sm fa-scroll mr-1"></i> <?= l('admin_user_view.users_logs') ?></span>
            </div>

            <div class="bg-gray-200 px-2 d-flex flex-column justify-content-center">
                <a href="<?= url('admin/users-logs?user_id=' . $data->user->user_id) ?>" class="stretched-link">
                    <i class="fa fa-fw fa-angle-right text-gray-500"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 mb-4 position-relative">
        <div class="card d-flex flex-row h-100 overflow-hidden">
            <div class="card-body">
                <span class="text-muted"><i class="fa fa-fw fa-sm fa-tags mr-1"></i> <?= l('admin_user_view.redeemed_codes') ?></span>
            </div>

            <div class="bg-gray-200 px-2 d-flex flex-column justify-content-center">
                <a href="<?= url('admin/redeemed-codes?user_id=' . $data->user->user_id) ?>" class="stretched-link">
                    <i class="fa fa-fw fa-angle-right text-gray-500"></i>
                </a>
            </div>
        </div>
    </div>

    <?php if (\Altum\Plugin::is_active('affiliate')) : ?>
        <div class="col-12 col-sm-6 mb-4 position-relative">
            <div class="card d-flex flex-row h-100 overflow-hidden">
                <div class="card-body">
                    <span class="text-muted"><i class="fa fa-fw fa-sm fa-wallet mr-1"></i> <?= l('admin_user_view.referred_by') ?></span>
                </div>

                <div class="bg-gray-200 px-2 d-flex flex-column justify-content-center">
                    <a href="<?= url('admin/users?referred_by=' . $data->user->user_id) ?>" class="stretched-link">
                        <i class="fa fa-fw fa-angle-right text-gray-500"></i>
                    </a>
                </div>
            </div>
        </div>
    <?php endif ?>

    <?php if (\Altum\Plugin::is_active('teams')) : ?>
        <div class="col-12 col-sm-6 mb-4 position-relative">
            <div class="card d-flex flex-row h-100 overflow-hidden">
                <div class="card-body">
                    <span class="text-muted"><i class="fa fa-fw fa-sm fa-user-shield mr-1"></i> <?= l('admin_user_view.teams') ?></span>
                </div>

                <div class="bg-gray-200 px-2 d-flex flex-column justify-content-center">
                    <a href="<?= url('admin/teams?user_id=' . $data->user->user_id) ?>" class="stretched-link">
                        <i class="fa fa-fw fa-angle-right text-gray-500"></i>
                    </a>
                </div>
            </div>
        </div>
    <?php endif ?>
</div>

<?php \Altum\Event::add_content(include_view(THEME_PATH . 'views/partials/universal_delete_modal_url.php', [
    'name' => 'user',
    'resource_id' => 'user_id',
    'has_dynamic_resource_name' => true,
    'path' => 'admin/users/delete/'
]), 'modals'); ?>

<?php \Altum\Event::add_content(include_view(THEME_PATH . 'views/admin/users/user_login_modal.php'), 'modals'); ?>
<?php \Altum\Event::add_content(include_view(THEME_PATH . 'views/admin/users/user_plan_generate_modal.php'), 'modals'); ?>