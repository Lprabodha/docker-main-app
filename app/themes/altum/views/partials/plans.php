<?php
defined('ALTUMCODE') || die()
?>
<?php

$currentUser = null;
if ($data->user->user_id) {
    $query = database()->query("SELECT * FROM `users` WHERE `user_id` = '{$data->user->user_id}'");
    $user_data = $query->fetch_all(MYSQLI_ASSOC);
    $userPlanId = json_decode($user_data[0]['plan_id'], true);
    $currentUser = $data->user;
}

$discount = null;
if (isset($_GET['promo'])) {
    if ($_GET['promo'] == '70OFF') {
        $discount = 70;
    }
}

$planId  = null;
if (isset($_GET['type'])) {

    if ($_GET['type'] == 'discounted') {
        $planId = 4;
    }
    if ($_GET['type'] == 'onetime') {
        $planId = 5;
    }
}

$user =  null;
if (isset($_GET['id'])) {
    $user  = db()->where('referral_key', $_GET['id'])->getOne('users');
    $currentUser = $user;
}


$plans = [];
$plans_result = database()->query("SELECT * FROM `plans` WHERE `status` = 1 AND `type` = 'main'");
while ($plan = $plans_result->fetch_object()) {
    $plans[] = $plan;
}

$rate = null;
$symbol = null;
$code = null;
if ($exchange_rate = exchange_rate($currentUser)) {
    $rate   = $exchange_rate['rate'];
    $symbol = $exchange_rate['symbol'];
    $code   = $exchange_rate['code'];
} else {
    $code = 'USD';
}
$countryCurrency = get_user_currency($code);

?>


<div class="container-fluid plan-section pb-3">
    <div class="plan-area">
        <div class="container-fluid row">
            <?php if (!$planId) : ?>
                <?php foreach ($plans as $plan) : ?>
                    <div class="package col-xl-4 mx-auto col-id-<?= $plan->plan_id ?>">
                        <?php
                        $total = get_plan_price($plan->plan_id, $code);
                        $monthlyPrice = get_plan_month_price($plan->plan_id, $code);
                        if ($discount) {
                            $monthlyDiscountPrice = $monthlyPrice - $monthlyPrice / 100 * $discount;
                        }

                        ?>
                        <?php if (url(\Altum\Routing\Router::$original_request) == (url('plan-rdpf'))) : ?>
                            <div class="<?= $plan->plan_id == 1 ||  $plan->plan_id == 3  ? 'full-card-wrapper' : 'annual-full-card-wrapper' ?>">
                                <div class="<?= $plan->plan_id == 1 ||  $plan->plan_id == 3  ? 'full-card' : 'annual-full-card' ?>">
                                    <?php if ($plan->plan_id == 1) : ?>
                                        <button type="button" class="btn mx-auto d-block rounded-pill plan-btn">
                                            <span class="billing-btn-text"><?= l('plan_cards.custom_plan.monthly') ?></span>
                                            <div class="default-spinner billing-spinner <?= $plan->plan_id == 1 ||  $plan->plan_id == 3  ? 'gray-spinner' : 'green-spinner' ?>"></div>
                                        </button>
                                    <?php elseif ($plan->plan_id == 2) : ?>
                                        <button type="button" class="btn mx-auto d-block rounded-pill annual-time-btn">
                                            <span class="billing-btn-text"><?= l('plan_cards.custom_plan.annual') ?></span>
                                            <div class="default-spinner billing-spinner <?= $plan->plan_id == 1 ||  $plan->plan_id == 3  ? 'gray-spinner' : 'green-spinner' ?>"></div>
                                        </button>
                                    <?php else : ?>
                                        <button type="button" class="btn mx-auto d-block rounded-pill plan-btn">
                                            <span class="billing-btn-text"><?= l('plan_cards.custom_plan.quarterly') ?></span>
                                            <div class="default-spinner billing-spinner <?= $plan->plan_id == 1 ||  $plan->plan_id == 3  ? 'gray-spinner' : 'green-spinner' ?>"></div>
                                        </button>
                                    <?php endif ?>

                                    <?php if ($discount) : ?>
                                        <div class="plan-card mx-auto monthly-plan">
                                            <div class="package-header ">

                                                <?php if (check_usd($code) || get_user_currency($code)) : ?>
                                                    <div class="lines2setup-wrp other-currency-full-wrap">
                                                        <span class="lines2setup other-currency"><?= $symbol . custom_currency_format($monthlyPrice) ?>/mo</span>
                                                        <div class="discount-area d-flex rounded-pill other-discount-wrap">
                                                            <div class="present-icon-bg my-auto rounded-circle">
                                                                <span>%</span>
                                                            </div>
                                                            <span class="discount-detail"> <?= l('plan_cards.70_discount') ?></span>
                                                        </div>
                                                    </div>


                                                    <h2 class="package-header-heading">
                                                        <?= $symbol ?>&nbsp;<?= custom_currency_format($monthlyDiscountPrice) . ' /mo'  ?>
                                                    </h2>

                                                <?php else : ?>

                                                    <div class="discount-area d-flex rounded-pill my-3" style="top: 15px;">
                                                        <div class="present-icon-bg my-auto rounded-circle">
                                                            <span>%</span>
                                                        </div>
                                                        <span class="discount-detail"> <?= l('plan_cards.70_discount') ?></span>
                                                    </div>
                                                    <span class="lines3setup" style="font-size: 20px;margin-top: 40px;">
                                                        <?php if ($countryCurrency) : ?>
                                                            <?= $symbol ?>&nbsp;<?= custom_currency_format($monthlyPrice) ?>&nbsp;<?= $code  ?>
                                                        <?php else : ?>
                                                            <?= $symbol ?>&nbsp;<?= custom_currency_format($monthlyPrice * $rate) ?>&nbsp;<?= $code  ?>
                                                        <?php endif  ?>
                                                    </span>
                                                    <h2 class="package-header-heading  default-package-heading">
                                                        <?php if ($countryCurrency) : ?>
                                                            <?= $symbol ?>&nbsp;<?= custom_currency_format($monthlyDiscountPrice) ?> <?= $code  ?> /mo
                                                        <?php else : ?>
                                                            <?= $symbol ?>&nbsp;<?= custom_currency_format($monthlyDiscountPrice * $rate) ?> <?= $code  ?> /mo
                                                            <span>(<?= custom_currency_format($monthlyDiscountPrice) ?> USD/mo)</span>
                                                        <?php endif  ?>



                                                    </h2>

                                                <?php endif ?>

                                                <?php if ($plan->plan_id == 1) { ?>
                                                    <p class="package-subheader mt-2"><?= l('plan_cards.invoiced_every_month') ?></p>
                                                <?php } elseif ($plan->plan_id == 2) { ?>
                                                    <p class="package-subheader mt-2"><?= l('plan_cards.invoiced_every_year') ?></p>
                                                <?php } else { ?>
                                                    <p class="package-subheader mt-2"><?= l('plan_cards.invoiced_each_quarter') ?></p>
                                                <?php } ?>
                                                <hr class="card-hr my-3 top-hr">
                                            </div>
                                            <div class="package-details discounted-2">
                                                <div class="plan-detail">
                                                    <div class="detail d-flex">
                                                        <div class="plan-icon-area ">
                                                            <i class="icon-checker plan-icon text-success"></i>
                                                        </div>
                                                        <div class="plan-item-detail">
                                                            <p class="item-description"> <?= l('plan_cards.purchase_detail_1') ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="plan-detail">
                                                    <div class="detail d-flex">
                                                        <div class="plan-icon-area ">
                                                            <i class="icon-checker plan-icon text-success"></i>
                                                        </div>
                                                        <div class="plan-item-detail">
                                                            <p class="item-description"> <?= l('plan_cards.purchase_detail_2') ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="plan-detail">
                                                    <div class="detail d-flex">
                                                        <div class="plan-icon-area ">
                                                            <i class="icon-checker plan-icon text-success"></i>
                                                        </div>
                                                        <div class="plan-item-detail">
                                                            <p class="item-description"> <?= l('plan_cards.purchase_detail_3') ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="plan-detail">
                                                    <div class="detail d-flex">
                                                        <div class="plan-icon-area ">
                                                            <i class="icon-checker plan-icon text-success"></i>
                                                        </div>
                                                        <div class="plan-item-detail">
                                                            <p class="item-description"> <?= l('plan_cards.purchase_detail_4') ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="plan-detail">
                                                    <div class="detail d-flex">
                                                        <div class="plan-icon-area ">
                                                            <i class="icon-checker plan-icon text-success"></i>
                                                        </div>
                                                        <div class="plan-item-detail">
                                                            <p class="item-description"> <?= l('plan_cards.purchase_detail_5') ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="plan-detail">
                                                    <div class="detail d-flex">
                                                        <div class="plan-icon-area ">
                                                            <i class="icon-checker plan-icon text-success"></i>
                                                        </div>
                                                        <div class="plan-item-detail">
                                                            <p class="item-description"> <?= l('plan_cards.purchase_detail_6') ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="plan-detail">
                                                    <div class="detail d-flex">
                                                        <div class="plan-icon-area ">
                                                            <i class="icon-checker plan-icon text-success"></i>
                                                        </div>
                                                        <div class="plan-item-detail">
                                                            <p class="item-description"> <?= l('plan_cards.purchase_detail_7') ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="plan-detail">
                                                    <div class="detail d-flex">
                                                        <div class="plan-icon-area ">
                                                            <i class="icon-checker plan-icon text-success"></i>
                                                        </div>
                                                        <div class="plan-item-detail">
                                                            <p class="item-description"> <?= l('plan_cards.purchase_detail_8') ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr class="card-hr under-hr mt-4">
                                            <div class="buy-btn-area">
                                                <?php if ($discount) : ?>

                                                    <?php if ($user) : ?>
                                                        <a class="btn mx-auto d-block rounded-pill add-to-cart  <?= $plan->plan_id == 1 ||  $plan->plan_id == 3  ? 'buy-plan-btn' : 'annual-buy-plan-btn' ?>" data-plan-name="<?= $plan->name ?>" data-plan-price="<?= $total ?>" href="<?= url('pay/' . $plan->plan_id . '?promo=' . $_GET['promo'] . '&id=' . $user->referral_key) ?>">
                                                            <span class="billing-down-btn-text"><?= l('plan_cards.buy_now') ?></span>
                                                            <div class="default-spinner billing-down-spinner <?= $plan->plan_id == 1 ||  $plan->plan_id == 3  ? 'gray-spinner' : 'green-spinner' ?>"></div>
                                                        </a>
                                                    <?php else : ?>
                                                        <a class="btn mx-auto d-block rounded-pill add-to-cart  <?= $plan->plan_id == 1 ||  $plan->plan_id == 3  ? 'buy-plan-btn' : 'annual-buy-plan-btn' ?>" data-plan-name="<?= $plan->name ?>" data-plan-price="<?= $total ?>" href="<?= \Altum\Middlewares\Authentication::check() ? url('pay/' . $plan->plan_id . '?promo=' . $_GET['promo'])  : url('login?redirect=pay/' . $plan->plan_id . '?promo=' . $_GET['promo']) ?>">
                                                            <span class="billing-down-btn-text"><?= l('plan_cards.buy_now') ?></span>
                                                            <div class="default-spinner billing-down-spinner <?= $plan->plan_id == 1 ||  $plan->plan_id == 3  ? 'gray-spinner' : 'green-spinner' ?>"></div>
                                                        </a>
                                                    <?php endif ?>


                                                <?php else : ?>
                                                    <a class="btn mx-auto d-block rounded-pill add-to-cart  <?= $plan->plan_id == 1 ||  $plan->plan_id == 3  ? 'buy-plan-btn' : 'annual-buy-plan-btn' ?>" data-plan-name="<?= $plan->name ?>" data-plan-price="<?= $total ?>" href="<?= \Altum\Middlewares\Authentication::check() ? url('pay/' . $plan->plan_id)  : url('login?redirect=pay/' . $plan->plan_id) ?>">
                                                        <span class="billing-down-btn-text"><?= l('plan_cards.buy_now') ?></span>
                                                        <div class="default-spinner billing-down-spinner <?= $plan->plan_id == 1 ||  $plan->plan_id == 3  ? 'gray-spinner' : 'green-spinner' ?>"></div>
                                                    </a>
                                                <?php endif ?>

                                            </div>
                                        </div>
                                    <?php else : ?>

                                        <div class="plan-card mx-auto monthly-plan">
                                            <div class="package-header default-header">
                                                <?php if ($plan->plan_id == 2) { ?>
                                                    <div class="discount-area d-flex rounded-pill my-3">
                                                        <div class="present-icon-bg my-auto rounded-circle">
                                                            <!-- <i class="mx-auto d-block fa fa-percent present-icon" aria-hidden="true"></i> -->
                                                            <span>%</span>
                                                        </div>
                                                        <span class="discount-detail"> <?= l('plan_cards.60_discount') ?></span>
                                                    </div>
                                                <?php  } ?>



                                                <h2 class="package-header-heading <?= $plan->plan_id == 2 ? 'set-marg' : null ?>">
                                                    <?php if ($countryCurrency) : ?>
                                                        <?= $symbol ?> &nbsp;<?= custom_currency_format($monthlyPrice) ?>&nbsp;/mo
                                                    <?php else : ?>
                                                        <?= $symbol ?>&nbsp;<?= custom_currency_format(check_usd($code) ? $monthlyPrice :  $monthlyPrice * $rate) ?>&nbsp;<?= check_usd($code)  ? '/mo' : $code ?>
                                                        <span class="<?= check_usd($code) ? 'd-none' :  '' ?>">(<?= custom_currency_format($monthlyPrice) ?> USD/mo)</span>
                                                    <?php endif  ?>

                                                </h2>

                                                <?php if ($plan->plan_id == 1) { ?>
                                                    <p class="package-subheader mt-2"><?= l('plan_cards.invoiced_every_month') ?></p>
                                                <?php } elseif ($plan->plan_id == 2) { ?>
                                                    <p class="package-subheader mt-2"><?= l('plan_cards.invoiced_every_year') ?></p>
                                                <?php } else { ?>
                                                    <p class="package-subheader mt-2"><?= l('plan_cards.invoiced_each_quarter') ?></p>
                                                <?php } ?>
                                                <hr class="card-hr my-3 top-hr">
                                            </div>
                                            <div class="package-details discounted-3">
                                                <div class="plan-detail">
                                                    <div class="detail d-flex">
                                                        <div class="plan-icon-area ">
                                                            <i class="icon-checker plan-icon text-success"></i>
                                                        </div>
                                                        <div class="plan-item-detail">
                                                            <p class="item-description"> <?= l('plan_cards.purchase_detail_1') ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="plan-detail">
                                                    <div class="detail d-flex">
                                                        <div class="plan-icon-area ">
                                                            <i class="icon-checker plan-icon text-success"></i>
                                                        </div>
                                                        <div class="plan-item-detail">
                                                            <p class="item-description"> <?= l('plan_cards.purchase_detail_2') ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="plan-detail">
                                                    <div class="detail d-flex">
                                                        <div class="plan-icon-area ">
                                                            <i class="icon-checker plan-icon text-success"></i>
                                                        </div>
                                                        <div class="plan-item-detail">
                                                            <p class="item-description"> <?= l('plan_cards.purchase_detail_3') ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="plan-detail">
                                                    <div class="detail d-flex">
                                                        <div class="plan-icon-area ">
                                                            <i class="icon-checker plan-icon text-success"></i>
                                                        </div>
                                                        <div class="plan-item-detail">
                                                            <p class="item-description"> <?= l('plan_cards.purchase_detail_4') ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="plan-detail">
                                                    <div class="detail d-flex">
                                                        <div class="plan-icon-area ">
                                                            <i class="icon-checker plan-icon text-success"></i>
                                                        </div>
                                                        <div class="plan-item-detail">
                                                            <p class="item-description"> <?= l('plan_cards.purchase_detail_5') ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="plan-detail">
                                                    <div class="detail d-flex">
                                                        <div class="plan-icon-area ">
                                                            <i class="icon-checker plan-icon text-success"></i>
                                                        </div>
                                                        <div class="plan-item-detail">
                                                            <p class="item-description"> <?= l('plan_cards.purchase_detail_6') ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="plan-detail">
                                                    <div class="detail d-flex">
                                                        <div class="plan-icon-area ">
                                                            <i class="icon-checker plan-icon text-success"></i>
                                                        </div>
                                                        <div class="plan-item-detail">
                                                            <p class="item-description"> <?= l('plan_cards.purchase_detail_7') ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="plan-detail">
                                                    <div class="detail d-flex">
                                                        <div class="plan-icon-area ">
                                                            <i class="icon-checker plan-icon text-success"></i>
                                                        </div>
                                                        <div class="plan-item-detail">
                                                            <p class="item-description"> <?= l('plan_cards.purchase_detail_8') ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr class="card-hr under-hr mt-4">
                                            <div class="buy-btn-area">
                                                <a class="btn mx-auto d-block rounded-pill add-to-cart  <?= $plan->plan_id == 1 ||  $plan->plan_id == 3  ? 'buy-plan-btn' : 'annual-buy-plan-btn' ?>" data-plan-name="<?= $plan->name ?>" data-plan-price="<?= $total ?>" href="<?= url('pay-rdpf/' . $plan->plan_id) ?>">
                                                    <span class="billing-down-btn-text"><?= l('plan_cards.buy_now') ?></span>
                                                    <div class="default-spinner billing-down-spinner <?= $plan->plan_id == 1 ||  $plan->plan_id == 3  ? 'gray-spinner' : 'green-spinner' ?>"></div>
                                                </a>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                </div>
                            </div>
                        <?php elseif (url(\Altum\Routing\Router::$original_request) == (url('plan-rdpf/upgrade'))) : ?>
                            <div class="<?= $plan->plan_id == 1 ||  $plan->plan_id == 3  ? 'full-card-wrapper' : 'annual-full-card-wrapper' ?>">
                                <div class="<?= ($plan->plan_id == $userPlanId) ? 'full-card' : 'annual-full-card' ?> <?= ($plan->plan_id == $userPlanId) ? 'gray-card-ug' : 'green-card-ug' ?>">
                                    <?php if ($plan->plan_id == 1) { ?>
                                        <button type="button" class="btn mx-auto d-block rounded-pill plan-btn" style="<?php echo ($plan->plan_id == $userPlanId) ? 'color: #68816A; border: 1px solid #e0ddd6;background-color:#e0ddd6' : 'color: #FFFFFF; border: 2px solid #25B533; background-color: #25B533;'; ?>" <?php echo ($plan->plan_id == $userPlanId) ? 'disabled' : ''; ?>>
                                            <span class="billing-btn-text"><?= l('plan_cards.custom_plan.monthly') ?></span>
                                            <div class="default-spinner billing-spinner <?= $plan->plan_id == 1 ||  $plan->plan_id == 3  ? 'gray-spinner' : 'green-spinner' ?>"></div>
                                        </button>
                                    <?php } elseif ($plan->plan_id == 2) { ?>
                                        <button type="button" class="btn mx-auto d-block rounded-pill annual-time-btn annual-time-btn-ug" style="<?php echo ($plan->plan_id == $userPlanId) ? 'color: #68816A; border: 1px solid #e0ddd6;background-color:#e0ddd6' : 'color: #FFFFFF; border: 2px solid #25B533; background-color: #25B533;'; ?>" <?php echo ($plan->plan_id == $userPlanId) ? 'disabled' : ''; ?>>
                                            <span class="billing-btn-text"><?= l('plan_cards.custom_plan.annual') ?></span>
                                            <div class="default-spinner billing-spinner <?= $plan->plan_id == 1 ||  $plan->plan_id == 3  ? 'gray-spinner' : 'green-spinner' ?>"></div>
                                        </button>
                                    <?php } else { ?>
                                        <button type="button" class="btn mx-auto d-block rounded-pill plan-btn" style="<?php echo ($plan->plan_id == $userPlanId) ? 'color: #68816A; border: 1px solid #e0ddd6;background-color:#e0ddd6' : 'color: #FFFFFF; border: 2px solid #25B533; background-color: #25B533;'; ?>" <?php echo ($plan->plan_id == $userPlanId) ? 'disabled' : ''; ?>>
                                            <span class="billing-btn-text"><?= l('plan_cards.custom_plan.quarterly') ?></span>
                                            <div class="default-spinner billing-spinner <?= $plan->plan_id == 1 ||  $plan->plan_id == 3  ? 'gray-spinner' : 'green-spinner' ?>"></div>
                                        </button>
                                    <?php } ?>
                                    <div class="plan-card mx-auto monthly-plan">
                                        <div class="package-header">
                                            <?php if ($plan->plan_id == 2) { ?>
                                                <div class="discount-area d-flex rounded-pill my-3 rdpf-upgrade-dis">

                                                    <div class="present-icon-bg my-auto rounded-circle">
                                                        <!-- <i class="mx-auto d-block fa fa-percent present-icon" aria-hidden="true"></i> -->
                                                        <span>%</span>
                                                    </div>
                                                    <span class="discount-detail"> <?= l('plan_cards.60_discount') ?></span>
                                                </div>
                                            <?php  } ?>
                                            <h2 class="package-header-heading <?= $plan->plan_id == 2 ? 'set-marg' : null ?>">
                                                <?php if ($countryCurrency) : ?>
                                                    <?= $symbol ?> &nbsp;<?= custom_currency_format($monthlyPrice) ?>&nbsp;/mo
                                                <?php else : ?>
                                                    <?= $symbol ?>&nbsp;<?= custom_currency_format(check_usd($code) ? $monthlyPrice :  $monthlyPrice * $rate) ?>&nbsp;<?= check_usd($code)  ? '/mo' : $code ?>
                                                    <span class="<?= check_usd($code) ? 'd-none' :  '' ?>">(<?= custom_currency_format($monthlyPrice) ?> USD/mo)</span>
                                                <?php endif  ?>
                                            </h2>

                                            <?php if ($plan->plan_id == 1) { ?>
                                                <p class="package-subheader mt-2"><?= l('plan_cards.invoiced_every_month') ?></p>
                                            <?php } elseif ($plan->plan_id == 2) { ?>
                                                <p class="package-subheader mt-2"><?= l('plan_cards.invoiced_every_year') ?></p>
                                            <?php } else { ?>
                                                <p class="package-subheader mt-2"><?= l('plan_cards.invoiced_each_quarter') ?></p>
                                            <?php } ?>
                                            <hr class="card-hr my-3 top-hr">
                                        </div>
                                        <div class="package-details discounted-1">
                                            <div class="plan-detail">
                                                <div class="detail d-flex">
                                                    <div class="plan-icon-area ">
                                                        <i class="icon-checker plan-icon text-success" style="background-color:<?php echo ($plan->plan_id == $userPlanId) ? '#68816A' : '#25B533'; ?>;"></i>
                                                    </div>
                                                    <div class="plan-item-detail">
                                                        <p class="item-description"> <?= l('plan_cards.purchase_detail_1') ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="plan-detail">
                                                <div class="detail d-flex">
                                                    <div class="plan-icon-area ">
                                                        <i class="icon-checker plan-icon text-success" style="background-color:<?php echo ($plan->plan_id == $userPlanId) ? '#68816A' : '#25B533'; ?>;"></i>
                                                    </div>
                                                    <div class="plan-item-detail">
                                                        <p class="item-description"> <?= l('plan_cards.purchase_detail_2') ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="plan-detail">
                                                <div class="detail d-flex">
                                                    <div class="plan-icon-area ">
                                                        <i class="icon-checker plan-icon text-success" style="background-color:<?php echo ($plan->plan_id == $userPlanId) ? '#68816A' : '#25B533'; ?>;"></i>
                                                    </div>
                                                    <div class="plan-item-detail">
                                                        <p class="item-description"> <?= l('plan_cards.purchase_detail_3') ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="plan-detail">
                                                <div class="detail d-flex">
                                                    <div class="plan-icon-area ">
                                                        <i class="icon-checker plan-icon text-success" style="background-color:<?php echo ($plan->plan_id == $userPlanId) ? '#68816A' : '#25B533'; ?>;"></i>
                                                    </div>
                                                    <div class="plan-item-detail">
                                                        <p class="item-description"> <?= l('plan_cards.purchase_detail_4') ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="plan-detail">
                                                <div class="detail d-flex">
                                                    <div class="plan-icon-area ">
                                                        <i class="icon-checker plan-icon text-success" style="background-color:<?php echo ($plan->plan_id == $userPlanId) ? '#68816A' : '#25B533'; ?>;"></i>
                                                    </div>
                                                    <div class="plan-item-detail">
                                                        <p class="item-description"> <?= l('plan_cards.purchase_detail_5') ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="plan-detail">
                                                <div class="detail d-flex">
                                                    <div class="plan-icon-area ">
                                                        <i class="icon-checker plan-icon text-success" style="background-color:<?php echo ($plan->plan_id == $userPlanId) ? '#68816A' : '#25B533'; ?>;"></i>
                                                    </div>
                                                    <div class="plan-item-detail">
                                                        <p class="item-description"> <?= l('plan_cards.purchase_detail_6') ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="plan-detail">
                                                <div class="detail d-flex">
                                                    <div class="plan-icon-area ">
                                                        <i class="icon-checker plan-icon text-success" style="background-color:<?php echo ($plan->plan_id == $userPlanId) ? '#68816A' : '#25B533'; ?>;"></i>
                                                    </div>
                                                    <div class="plan-item-detail">
                                                        <p class="item-description"> <?= l('plan_cards.purchase_detail_7') ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="plan-detail">
                                                <div class="detail d-flex">
                                                    <div class="plan-icon-area ">
                                                        <i class="icon-checker plan-icon text-success" style="background-color:<?php echo ($plan->plan_id == $userPlanId) ? '#68816A' : '#25B533'; ?>;"></i>
                                                    </div>
                                                    <div class="plan-item-detail">
                                                        <p class="item-description"> <?= l('plan_cards.purchase_detail_8') ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr class="card-hr under-hr mt-4">
                                        <div class="buy-btn-area">
                                            <?php if (url('plan/upgrade')) { ?>
                                                <a class="btn mx-auto d-block rounded-pill add-to-cart <?php echo ($plan->plan_id == $userPlanId) ? 'buy-plan-btn disabled' : 'annual-buy-plan-btn'; ?>" style="<?php echo ($plan->plan_id == $userPlanId) ? 'color: #68816A; border: 1px solid #e0ddd6;background-color:#e0ddd6' : 'color: #FFFFFF; border: 2px solid #25B533;'; ?>" data-plan-name="<?= $plan->name ?>" data-plan-price="<?= $total ?>" href="<?= \Altum\Middlewares\Authentication::check() ? url('pay-rdpf/' . $plan->plan_id)  : url('login?redirect=pay-rdpf/' . $plan->plan_id) ?>">
                                                    <span class="billing-down-btn-text"><?= l('plan_cards.buy_now') ?></span>
                                                    <div class="default-spinner billing-down-spinner <?= $plan->plan_id == 1 ||  $plan->plan_id == 3  ? 'gray-spinner' : 'green-spinner' ?>"></div>
                                                </a>
                                            <?php } else { ?>
                                                <a class="btn mx-auto d-block rounded-pill add-to-cart  <?= $plan->plan_id == 1 ||  $plan->plan_id == 3  ? 'buy-plan-btn' : 'annual-buy-plan-btn' ?>" data-plan-name="<?= $plan->name ?>" data-plan-price="<?= $total ?>" href="<?= \Altum\Middlewares\Authentication::check() ? url('pay-rdpf/' . $plan->plan_id)  : url('login?redirect=pay-rdpf/' . $plan->plan_id) ?>">
                                                    <span class="billing-down-btn-text"><?= l('plan_cards.buy_now') ?></span>
                                                    <div class="default-spinner billing-down-spinner <?= $plan->plan_id == 1 ||  $plan->plan_id == 3  ? 'gray-spinner' : 'green-spinner' ?>"></div>
                                                </a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php elseif (url(\Altum\Routing\Router::$original_request) == (url('plan/upgrade'))) : ?>
                            <div class="<?= $plan->plan_id == 1 ||  $plan->plan_id == 3  ? 'full-card-wrapper' : 'annual-full-card-wrapper' ?>">
                                <div class="<?= ($plan->plan_id == $userPlanId) ? 'full-card' : 'annual-full-card' ?> <?= ($plan->plan_id == $userPlanId) ? 'gray-card-ug' : 'green-card-ug' ?>">
                                    <?php if ($plan->plan_id == 1) { ?>
                                        <button type="button" class="btn mx-auto d-block rounded-pill plan-btn" style="<?php echo ($plan->plan_id == $userPlanId) ? 'color: #68816A; border: 1px solid #e0ddd6;background-color:#e0ddd6' : 'color: #FFFFFF; border: 2px solid #25B533; background-color: #25B533;'; ?>" <?php echo ($plan->plan_id == $userPlanId) ? 'disabled' : ''; ?>>
                                            <span class="billing-btn-text"><?= l('plan_cards.custom_plan.monthly') ?></span>
                                            <div class="default-spinner billing-spinner <?= ($plan->plan_id == $userPlanId) ? 'gray-spinner' : 'green-spinner' ?>"></div>
                                        </button>
                                    <?php } elseif ($plan->plan_id == 2) { ?>
                                        <button type="button" class="btn mx-auto d-block rounded-pill annual-time-btn annual-time-btn-ug" style="<?php echo ($plan->plan_id == $userPlanId) ? 'color: #68816A; border: 1px solid #e0ddd6;background-color:#e0ddd6' : 'color: #FFFFFF; border: 2px solid #25B533; background-color: #25B533;'; ?>" <?php echo ($plan->plan_id == $userPlanId) ? 'disabled' : ''; ?>>
                                            <span class="billing-btn-text"><?= l('plan_cards.custom_plan.annual') ?></span>
                                            <div class="default-spinner billing-spinner <?= ($plan->plan_id == $userPlanId) ? 'gray-spinner' : 'green-spinner' ?>"></div>
                                        </button>
                                    <?php } else { ?>
                                        <button type="button" class="btn mx-auto d-block rounded-pill plan-btn" style="<?php echo ($plan->plan_id == $userPlanId) ? 'color: #68816A; border: 1px solid #e0ddd6;background-color:#e0ddd6' : 'color: #FFFFFF; border: 2px solid #25B533; background-color: #25B533;'; ?>" <?php echo ($plan->plan_id == $userPlanId) ? 'disabled' : ''; ?>>
                                            <span class="billing-btn-text"><?= l('plan_cards.custom_plan.quarterly') ?></span>
                                            <div class="default-spinner billing-spinner <?= ($plan->plan_id == $userPlanId) ? 'gray-spinner' : 'green-spinner' ?>"></div>
                                        </button>
                                    <?php } ?>
                                    <div class="plan-card mx-auto monthly-plan">
                                        <div class="package-header">
                                            <?php if ($plan->plan_id == 2) { ?>
                                                <div class="discount-area d-flex rounded-pill my-3 upgrade-annual-dis">
                                                    <div class="present-icon-bg my-auto rounded-circle">
                                                        <span>%</span>
                                                    </div>
                                                    <span class="discount-detail"> <?= l('plan_cards.60_discount') ?></span>
                                                </div>
                                            <?php  } ?>

                                            <h2 class="package-header-heading default-package-heading  <?= $plan->plan_id == 2 ? 'discount-card-header' : '' ?>">

                                                <?php if ($countryCurrency) : ?>
                                                    <?= $symbol ?> &nbsp;<?= custom_currency_format($monthlyPrice) ?>&nbsp;/mo
                                                <?php else : ?>
                                                    <?= $symbol ?>&nbsp;<?= custom_currency_format(check_usd($code) ? $monthlyPrice :  $monthlyPrice * $rate) ?>&nbsp;<?= check_usd($code) ? '/mo' : $code ?>
                                                    <span class="<?= check_usd($code) ? 'd-none' :  '' ?>">(<?= custom_currency_format($monthlyPrice) ?> USD/mo)</span>
                                                <?php endif  ?>


                                            </h2>

                                            <?php if ($plan->plan_id == 1) { ?>
                                                <p class="package-subheader mt-2"><?= l('plan_cards.invoiced_every_month') ?></p>
                                            <?php } elseif ($plan->plan_id == 2) { ?>
                                                <p class="package-subheader mt-2"><?= l('plan_cards.invoiced_every_year') ?></p>
                                            <?php } else { ?>
                                                <p class="package-subheader mt-2"><?= l('plan_cards.invoiced_each_quarter') ?></p>
                                            <?php } ?>
                                            <hr class="card-hr my-3 top-hr">
                                        </div>
                                        <div class="package-details discounted-1">
                                            <div class="plan-detail">
                                                <div class="detail d-flex">
                                                    <div class="plan-icon-area ">
                                                        <i class="icon-checker plan-icon text-success" style="background-color:<?php echo ($plan->plan_id == $userPlanId) ? '#68816A' : '#25B533'; ?>;"></i>
                                                    </div>
                                                    <div class="plan-item-detail">
                                                        <p class="item-description"> <?= l('plan_cards.purchase_detail_1') ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="plan-detail">
                                                <div class="detail d-flex">
                                                    <div class="plan-icon-area ">
                                                        <i class="icon-checker plan-icon text-success" style="background-color:<?php echo ($plan->plan_id == $userPlanId) ? '#68816A' : '#25B533'; ?>;"></i>
                                                    </div>
                                                    <div class="plan-item-detail">
                                                        <p class="item-description"> <?= l('plan_cards.purchase_detail_2') ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="plan-detail">
                                                <div class="detail d-flex">
                                                    <div class="plan-icon-area ">
                                                        <i class="icon-checker plan-icon text-success" style="background-color:<?php echo ($plan->plan_id == $userPlanId) ? '#68816A' : '#25B533'; ?>;"></i>
                                                    </div>
                                                    <div class="plan-item-detail">
                                                        <p class="item-description"> <?= l('plan_cards.purchase_detail_3') ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="plan-detail">
                                                <div class="detail d-flex">
                                                    <div class="plan-icon-area ">
                                                        <i class="icon-checker plan-icon text-success" style="background-color:<?php echo ($plan->plan_id == $userPlanId) ? '#68816A' : '#25B533'; ?>;"></i>
                                                    </div>
                                                    <div class="plan-item-detail">
                                                        <p class="item-description"> <?= l('plan_cards.purchase_detail_4') ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="plan-detail">
                                                <div class="detail d-flex">
                                                    <div class="plan-icon-area ">
                                                        <i class="icon-checker plan-icon text-success" style="background-color:<?php echo ($plan->plan_id == $userPlanId) ? '#68816A' : '#25B533'; ?>;"></i>
                                                    </div>
                                                    <div class="plan-item-detail">
                                                        <p class="item-description"> <?= l('plan_cards.purchase_detail_5') ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="plan-detail">
                                                <div class="detail d-flex">
                                                    <div class="plan-icon-area ">
                                                        <i class="icon-checker plan-icon text-success" style="background-color:<?php echo ($plan->plan_id == $userPlanId) ? '#68816A' : '#25B533'; ?>;"></i>
                                                    </div>
                                                    <div class="plan-item-detail">
                                                        <p class="item-description"> <?= l('plan_cards.purchase_detail_6') ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="plan-detail">
                                                <div class="detail d-flex">
                                                    <div class="plan-icon-area ">
                                                        <i class="icon-checker plan-icon text-success" style="background-color:<?php echo ($plan->plan_id == $userPlanId) ? '#68816A' : '#25B533'; ?>;"></i>
                                                    </div>
                                                    <div class="plan-item-detail">
                                                        <p class="item-description"> <?= l('plan_cards.purchase_detail_7') ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="plan-detail">
                                                <div class="detail d-flex">
                                                    <div class="plan-icon-area ">
                                                        <i class="icon-checker plan-icon text-success" style="background-color:<?php echo ($plan->plan_id == $userPlanId) ? '#68816A' : '#25B533'; ?>;"></i>
                                                    </div>
                                                    <div class="plan-item-detail">
                                                        <p class="item-description"> <?= l('plan_cards.purchase_detail_8') ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr class="card-hr under-hr mt-4">
                                        <div class="buy-btn-area">
                                            <?php if (url('plan/upgrade')) { ?>
                                                <a class="btn mx-auto d-block rounded-pill add-to-cart <?php echo ($plan->plan_id == $userPlanId) ? 'buy-plan-btn disabled' : 'annual-buy-plan-btn'; ?>" style="<?php echo ($plan->plan_id == $userPlanId) ? 'color: #68816A; border: 1px solid #e0ddd6;background-color:#e0ddd6' : 'color: #FFFFFF; border: 2px solid #25B533;'; ?>" data-plan-name="<?= $plan->name ?>" data-plan-price="<?= $total ?>" href="<?= \Altum\Middlewares\Authentication::check() ? url('pay/' . $plan->plan_id) : (isset($data->user) ? url('pay/' . $plan->plan_id .'?id='. $data->user->referral_key) : url('login?redirect=pay/' . $plan->plan_id));?>">
                                                    <span class="billing-down-btn-text"><?= l('plan_cards.buy_now') ?></span>
                                                    <div class="default-spinner billing-down-spinner <?= ($plan->plan_id == $userPlanId) ? 'gray-spinner' : 'green-spinner' ?>"></div>
                                                </a>
                                            <?php } else { ?>
                                                <a class="btn mx-auto d-block rounded-pill add-to-cart  <?= $plan->plan_id == 1 ||  $plan->plan_id == 3  ? 'buy-plan-btn' : 'annual-buy-plan-btn' ?>" data-plan-name="<?= $plan->name ?>" data-plan-price="<?= $total ?>" href="<?= \Altum\Middlewares\Authentication::check() ? url('pay/' . $plan->plan_id)  : url('login?redirect=pay/' . $plan->plan_id) ?>">
                                                    <span class="billing-down-btn-text"><?= l('plan_cards.buy_now') ?></span>
                                                    <div class="default-spinner billing-down-spinner <?= $plan->plan_id == 1 ||  $plan->plan_id == 3  ? 'gray-spinner' : 'green-spinner' ?>"></div>
                                                </a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php else : ?>
                            <div class="<?= $plan->plan_id == 1 ||  $plan->plan_id == 3  ? 'full-card-wrapper' : 'annual-full-card-wrapper' ?>">
                                <div class="<?= $plan->plan_id == 1 ||  $plan->plan_id == 3  ? 'full-card' : 'annual-full-card' ?>">
                                    <?php if ($plan->plan_id == 1) : ?>
                                        <button type="button" class="btn mx-auto d-block rounded-pill plan-btn">
                                            <span class="billing-btn-text"><?= l('plan_cards.custom_plan.monthly') ?></span>
                                            <div class="default-spinner billing-spinner <?= $plan->plan_id == 1 ||  $plan->plan_id == 3  ? 'gray-spinner' : 'green-spinner' ?>"></div>
                                        </button>
                                    <?php elseif ($plan->plan_id == 2) : ?>
                                        <button type="button" class="btn mx-auto d-block rounded-pill annual-time-btn">
                                            <span class="billing-btn-text"><?= l('plan_cards.custom_plan.annual') ?></span>
                                            <div class="default-spinner billing-spinner <?= $plan->plan_id == 1 ||  $plan->plan_id == 3  ? 'gray-spinner' : 'green-spinner' ?>"></div>
                                        </button>
                                    <?php else : ?>
                                        <button type="button" class="btn mx-auto d-block rounded-pill plan-btn">
                                            <span class="billing-btn-text"><?= l('plan_cards.custom_plan.quarterly') ?></span>
                                            <div class="default-spinner billing-spinner <?= $plan->plan_id == 1 ||  $plan->plan_id == 3  ? 'gray-spinner' : 'green-spinner' ?>"></div>
                                        </button>
                                    <?php endif ?>

                                    <?php if ($discount) : ?>
                                        <div class="plan-card mx-auto monthly-plan">
                                            <div class="package-header ">

                                                <?php if (check_usd($code) || get_user_currency($code)) : ?>
                                                    <div class="lines2setup-wrp other-currency-full-wrap">
                                                        <span class="lines2setup other-currency"><?= $symbol ?>&nbsp; <?= custom_currency_format($monthlyPrice) ?>&nbsp;/mo</span>
                                                        <div class="discount-area d-flex rounded-pill other-discount-wrap">
                                                            <div class="present-icon-bg my-auto rounded-circle">
                                                                <span>%</span>
                                                            </div>
                                                            <span class="discount-detail"> <?= l('plan_cards.70_discount') ?></span>
                                                        </div>
                                                    </div>

                                                    <h2 class="package-header-heading ">
                                                        <?= $symbol ?>&nbsp;<?= custom_currency_format($monthlyDiscountPrice) . ' /mo'  ?>
                                                    </h2>


                                                <?php else : ?>

                                                    <div class="discount-area d-flex rounded-pill my-3" style="top: 15px;">
                                                        <div class="present-icon-bg my-auto rounded-circle">
                                                            <span>%</span>
                                                        </div>
                                                        <span class="discount-detail"> <?= l('plan_cards.70_discount') ?></span>
                                                    </div>
                                                    <span class="lines3setup" style="font-size: 20px;margin-top: 40px;">
                                                        <?php if ($countryCurrency) : ?>
                                                            <?= $symbol ?>&nbsp;<?= custom_currency_format($monthlyPrice) ?>&nbsp;<?= $code  ?>
                                                        <?php else : ?>
                                                            <?= $symbol ?>&nbsp;<?= custom_currency_format($monthlyPrice * $rate) ?>&nbsp;<?= $code  ?>
                                                        <?php endif  ?>
                                                    </span>
                                                    <h2 class="package-header-heading  default-package-heading">
                                                        <?php if ($countryCurrency) : ?>
                                                            <?= $symbol ?>&nbsp;<?= custom_currency_format($monthlyDiscountPrice) ?> <?= $code  ?> /mo
                                                        <?php else : ?>
                                                            <?= $symbol ?>&nbsp;<?= custom_currency_format($monthlyDiscountPrice * $rate) ?> <?= $code  ?> /mo
                                                            <span>(<?= custom_currency_format($monthlyDiscountPrice) ?> USD/mo)</span>
                                                        <?php endif  ?>



                                                    </h2>

                                                <?php endif ?>

                                                <?php if ($plan->plan_id == 1) { ?>
                                                    <p class="package-subheader mt-2"><?= l('plan_cards.invoiced_every_month') ?></p>
                                                <?php } elseif ($plan->plan_id == 2) { ?>
                                                    <p class="package-subheader mt-2"><?= l('plan_cards.invoiced_every_year') ?></p>
                                                <?php } else { ?>
                                                    <p class="package-subheader mt-2"><?= l('plan_cards.invoiced_each_quarter') ?></p>
                                                <?php } ?>
                                                <hr class="card-hr my-3 top-hr">
                                            </div>
                                            <div class="package-details discounted-2">
                                                <div class="plan-detail">
                                                    <div class="detail d-flex">
                                                        <div class="plan-icon-area ">
                                                            <i class="icon-checker plan-icon text-success"></i>
                                                        </div>
                                                        <div class="plan-item-detail">
                                                            <p class="item-description"> <?= l('plan_cards.purchase_detail_1') ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="plan-detail">
                                                    <div class="detail d-flex">
                                                        <div class="plan-icon-area ">
                                                            <i class="icon-checker plan-icon text-success"></i>
                                                        </div>
                                                        <div class="plan-item-detail">
                                                            <p class="item-description"> <?= l('plan_cards.purchase_detail_2') ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="plan-detail">
                                                    <div class="detail d-flex">
                                                        <div class="plan-icon-area ">
                                                            <i class="icon-checker plan-icon text-success"></i>
                                                        </div>
                                                        <div class="plan-item-detail">
                                                            <p class="item-description"> <?= l('plan_cards.purchase_detail_3') ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="plan-detail">
                                                    <div class="detail d-flex">
                                                        <div class="plan-icon-area ">
                                                            <i class="icon-checker plan-icon text-success"></i>
                                                        </div>
                                                        <div class="plan-item-detail">
                                                            <p class="item-description"> <?= l('plan_cards.purchase_detail_4') ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="plan-detail">
                                                    <div class="detail d-flex">
                                                        <div class="plan-icon-area ">
                                                            <i class="icon-checker plan-icon text-success"></i>
                                                        </div>
                                                        <div class="plan-item-detail">
                                                            <p class="item-description"> <?= l('plan_cards.purchase_detail_5') ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="plan-detail">
                                                    <div class="detail d-flex">
                                                        <div class="plan-icon-area ">
                                                            <i class="icon-checker plan-icon text-success"></i>
                                                        </div>
                                                        <div class="plan-item-detail">
                                                            <p class="item-description"> <?= l('plan_cards.purchase_detail_6') ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="plan-detail">
                                                    <div class="detail d-flex">
                                                        <div class="plan-icon-area ">
                                                            <i class="icon-checker plan-icon text-success"></i>
                                                        </div>
                                                        <div class="plan-item-detail">
                                                            <p class="item-description"> <?= l('plan_cards.purchase_detail_7') ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="plan-detail">
                                                    <div class="detail d-flex">
                                                        <div class="plan-icon-area ">
                                                            <i class="icon-checker plan-icon text-success"></i>
                                                        </div>
                                                        <div class="plan-item-detail">
                                                            <p class="item-description"> <?= l('plan_cards.purchase_detail_8') ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr class="card-hr under-hr mt-4">
                                            <div class="buy-btn-area">
                                                <?php if ($discount) : ?>

                                                    <?php if ($user) : ?>
                                                        <a class="btn mx-auto d-block rounded-pill add-to-cart  <?= $plan->plan_id == 1 ||  $plan->plan_id == 3  ? 'buy-plan-btn' : 'annual-buy-plan-btn' ?>" data-plan-name="<?= $plan->name ?>" data-plan-price="<?= $total ?>" href="<?= url('pay/' . $plan->plan_id . '?promo=' . $_GET['promo'] . '&id=' . $user->referral_key) ?>">
                                                            <span class="billing-down-btn-text"><?= l('plan_cards.buy_now') ?></span>
                                                            <div class="default-spinner billing-down-spinner <?= $plan->plan_id == 1 ||  $plan->plan_id == 3  ? 'gray-spinner' : 'green-spinner' ?>"></div>
                                                        </a>
                                                    <?php else : ?>
                                                        <a class="btn mx-auto d-block rounded-pill add-to-cart  <?= $plan->plan_id == 1 ||  $plan->plan_id == 3  ? 'buy-plan-btn' : 'annual-buy-plan-btn' ?>" data-plan-name="<?= $plan->name ?>" data-plan-price="<?= $total ?>" href="<?= \Altum\Middlewares\Authentication::check() ? url('pay/' . $plan->plan_id . '?promo=' . $_GET['promo'])  : url('login?redirect=pay/' . $plan->plan_id . '?promo=' . $_GET['promo']) ?>">
                                                            <span class="billing-down-btn-text"><?= l('plan_cards.buy_now') ?></span>
                                                            <div class="default-spinner billing-down-spinner <?= $plan->plan_id == 1 ||  $plan->plan_id == 3  ? 'gray-spinner' : 'green-spinner' ?>"></div>
                                                        </a>
                                                    <?php endif ?>


                                                <?php else : ?>
                                                    <a class="btn mx-auto d-block rounded-pill add-to-cart  <?= $plan->plan_id == 1 ||  $plan->plan_id == 3  ? 'buy-plan-btn' : 'annual-buy-plan-btn' ?>" data-plan-name="<?= $plan->name ?>" data-plan-price="<?= $total ?>" href="<?= \Altum\Middlewares\Authentication::check() ? url('pay/' . $plan->plan_id)  : url('login?redirect=pay/' . $plan->plan_id) ?>">
                                                        <span class="billing-down-btn-text"><?= l('plan_cards.buy_now') ?></span>
                                                        <div class="default-spinner billing-down-spinner <?= $plan->plan_id == 1 ||  $plan->plan_id == 3  ? 'gray-spinner' : 'green-spinner' ?>"></div>
                                                    </a>
                                                <?php endif ?>

                                            </div>
                                        </div>
                                    <?php else : ?>
                                        <div class="plan-card mx-auto monthly-plan">
                                            <div class="package-header default-header">
                                                <?php if ($plan->plan_id == 2) { ?>
                                                    <div class="discount-area dflex rounded-pill my-3 default-discount-wrp">
                                                        <div class="present-icon-bg my-auto rounded-circle">
                                                            <!-- <i class="mx-auto d-block fa fa-percent present-icon" aria-hidden="true"></i> -->
                                                            <span>%</span>
                                                        </div>
                                                        <span class="discount-detail"> <?= l('plan_cards.60_discount') ?></span>
                                                    </div>
                                                <?php  } ?>

                                                <h2 class="package-header-heading  default-package-heading <?= $plan->plan_id == 2 ? 'set-marg' : null ?>">
                                                    <?php if ($countryCurrency) : ?>
                                                        <?= $symbol ?> &nbsp;<?= custom_currency_format($monthlyPrice) ?>&nbsp;/mo
                                                    <?php else : ?>
                                                        <?= $symbol ?>&nbsp;<?= custom_currency_format(check_usd($code) ? $monthlyPrice :  $monthlyPrice * $rate) ?>&nbsp;<?= check_usd($code)  ? '/mo' : $code ?>
                                                        <span class="<?= check_usd($code) ? 'd-none' :  '' ?>">(<?= custom_currency_format($monthlyPrice) ?> USD/mo)</span>
                                                    <?php endif  ?>

                                                </h2>

                                                <div class=" blackFriday-package-heading d-none">
                                                    <div class="black-friday-discount">
                                                        <?php if ($plan->plan_id == 1) { ?>
                                                            <div class="discount-area dflex rounded-pill">
                                                                <div class="present-icon-bg my-auto rounded-circle">
                                                                    <!-- <i class="mx-auto d-block fa fa-percent present-icon" aria-hidden="true"></i> -->
                                                                    <span>%</span>
                                                                </div>
                                                                <span class="discount-detail"> <?= l('plan_cards.50_discount') ?></span>
                                                            </div>
                                                        <?php } elseif ($plan->plan_id == 2) { ?>
                                                            <div class="discount-area dflex rounded-pill">
                                                                <div class="present-icon-bg my-auto rounded-circle">
                                                                    <!-- <i class="mx-auto d-block fa fa-percent present-icon" aria-hidden="true"></i> -->
                                                                    <span>%</span>
                                                                </div>
                                                                <span class="discount-detail"> <?= l('plan_cards.50_discount') ?></span>
                                                            </div>
                                                        <?php } else { ?>
                                                            <div class="discount-area dflex rounded-pill">
                                                                <div class="present-icon-bg my-auto rounded-circle">
                                                                    <!-- <i class="mx-auto d-block fa fa-percent present-icon" aria-hidden="true"></i> -->
                                                                    <span>%</span>
                                                                </div>
                                                                <span class="discount-detail"> <?= l('plan_cards.50_discount') ?></span>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                    <div class="black-friday-pricing">

                                                        <h2 class="package-header-heading">
                                                            <?php if ($plan->plan_id == 1) { ?>

                                                                <?php if ($countryCurrency) : ?>
                                                                    <span class="strike-price <?= check_usd($code) ? '' :  'is-strike-currency' ?>"><?= $symbol ?> &nbsp;<?= round_number_format($monthlyPrice / 50 * 100) ?>&nbsp;/mo</span>
                                                                    <span class="shown-price <?= check_usd($code) ? '' :  'iscurrency' ?>"><?= $symbol ?> &nbsp;<?= custom_currency_format($monthlyPrice) ?>&nbsp;/mo</span>
                                                                <?php else : ?>
                                                                    <span class="strike-price <?= check_usd($code) ? '' :  'is-strike-currency' ?>"><?= $symbol ?>&nbsp;<?= round_number_format(check_usd($code) ? 99.95 :  99.95 * $rate) ?>&nbsp;<?= check_usd($code)  ? '/mo' : $code ?>
                                                                        <span class="<?= check_usd($code) ? 'd-none' :  '' ?>">(<?= custom_currency_format(99.95) ?> USD/mo)</span>
                                                                    </span>
                                                                    <span class="shown-price <?= check_usd($code) ? '' :  'iscurrency' ?>"><?= $symbol ?>&nbsp;<?= custom_currency_format(check_usd($code) ? $monthlyPrice :  $monthlyPrice * $rate) ?>&nbsp;<?= check_usd($code)  ? '/mo' : $code ?>
                                                                        <span class="<?= check_usd($code) ? 'd-none' :  '' ?>">(<?= custom_currency_format($monthlyPrice) ?> USD/mo)</span></span>
                                                                <?php endif  ?>
                                                            <?php } elseif ($plan->plan_id == 2) { ?>
                                                                <?php if ($countryCurrency) : ?>
                                                                    <span class="strike-price <?= check_usd($code) ? '' :  'is-strike-currency' ?>"><?= $symbol ?> &nbsp;<?= round_number_format($monthlyPrice / 50 * 100) ?>&nbsp;/mo</span>
                                                                    <span class="shown-price <?= check_usd($code) ? '' :  'iscurrency' ?>"><?= $symbol ?> &nbsp;<?= custom_currency_format($monthlyPrice) ?>&nbsp;/mo</span>
                                                                <?php else : ?>
                                                                    <span class="strike-price <?= check_usd($code) ? '' :  'is-strike-currency' ?>"><?= $symbol ?>&nbsp;<?= round_number_format(check_usd($code) ? 39.95 :  39.95 * $rate) ?>&nbsp;<?= check_usd($code)  ? '/mo' : $code ?>
                                                                        <span class="<?= check_usd($code) ? 'd-none' :  '' ?>">(<?= custom_currency_format(39.95) ?> USD/mo)</span>
                                                                    </span>
                                                                    <span class="shown-price <?= check_usd($code) ? '' :  'iscurrency' ?>"><?= $symbol ?>&nbsp;<?= custom_currency_format(check_usd($code) ? $monthlyPrice :  $monthlyPrice * $rate) ?>&nbsp;<?= check_usd($code)  ? '/mo' : $code ?>
                                                                        <span class="<?= check_usd($code) ? 'd-none' :  '' ?>">(<?= custom_currency_format($monthlyPrice) ?> USD/mo)</span></span>
                                                                <?php endif  ?>
                                                            <?php } else { ?>
                                                                <?php if ($countryCurrency) : ?>
                                                                    <span class="strike-price <?= check_usd($code) ? '' :  'is-strike-currency' ?>"><?= $symbol ?> &nbsp;<?= round_number_format($monthlyPrice / 50 * 100) ?>&nbsp;/mo</span>
                                                                    <span class="shown-price <?= check_usd($code) ? '' :  'iscurrency' ?>"><?= $symbol ?> &nbsp;<?= custom_currency_format($monthlyPrice) ?>&nbsp;/mo</span>
                                                                <?php else : ?>
                                                                    <span class="strike-price <?= check_usd($code) ? '' :  'is-strike-currency' ?>"><?= $symbol ?>&nbsp;<?= round_number_format(check_usd($code) ? 59.95 :  59.95 * $rate) ?>&nbsp;<?= check_usd($code)  ? '/mo' : $code ?>
                                                                        <span class="<?= check_usd($code) ? 'd-none' :  '' ?>">(<?= custom_currency_format(59.95) ?> USD/mo)</span>
                                                                    </span>
                                                                    <span class="shown-price <?= check_usd($code) ? '' :  'iscurrency' ?>"><?= $symbol ?>&nbsp;<?= custom_currency_format(check_usd($code) ? $monthlyPrice :  $monthlyPrice * $rate) ?>&nbsp;<?= check_usd($code)  ? '/mo' : $code ?>
                                                                        <span class="<?= check_usd($code) ? 'd-none' :  '' ?>">(<?= custom_currency_format($monthlyPrice) ?> USD/mo)</span>
                                                                    </span>
                                                                <?php endif  ?>
                                                            <?php } ?>

                                                        </h2>
                                                    </div>
                                                </div>

                                                <!-- <?= settings()->payment->currency ?> -->


                                                <?php if ($plan->plan_id == 1) { ?>
                                                    <p class="package-subheader mt-2"><?= l('plan_cards.invoiced_every_month') ?></p>
                                                <?php } elseif ($plan->plan_id == 2) { ?>
                                                    <p class="package-subheader mt-2"><?= l('plan_cards.invoiced_every_year') ?></p>
                                                <?php } else { ?>
                                                    <p class="package-subheader mt-2"><?= l('plan_cards.invoiced_each_quarter') ?></p>
                                                <?php } ?>
                                                <hr class="card-hr my-3 top-hr">
                                            </div>
                                            <div class="package-details discounted-3">
                                                <div class="plan-detail">
                                                    <div class="detail d-flex">
                                                        <div class="plan-icon-area ">
                                                            <i class="icon-checker plan-icon text-success"></i>
                                                        </div>
                                                        <div class="plan-item-detail">
                                                            <p class="item-description"> <?= l('plan_cards.purchase_detail_1') ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="plan-detail">
                                                    <div class="detail d-flex">
                                                        <div class="plan-icon-area ">
                                                            <i class="icon-checker plan-icon text-success"></i>
                                                        </div>
                                                        <div class="plan-item-detail">
                                                            <p class="item-description"> <?= l('plan_cards.purchase_detail_2') ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="plan-detail">
                                                    <div class="detail d-flex">
                                                        <div class="plan-icon-area ">
                                                            <i class="icon-checker plan-icon text-success"></i>
                                                        </div>
                                                        <div class="plan-item-detail">
                                                            <p class="item-description"> <?= l('plan_cards.purchase_detail_3') ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="plan-detail">
                                                    <div class="detail d-flex">
                                                        <div class="plan-icon-area ">
                                                            <i class="icon-checker plan-icon text-success"></i>
                                                        </div>
                                                        <div class="plan-item-detail">
                                                            <p class="item-description"> <?= l('plan_cards.purchase_detail_4') ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="plan-detail">
                                                    <div class="detail d-flex">
                                                        <div class="plan-icon-area ">
                                                            <i class="icon-checker plan-icon text-success"></i>
                                                        </div>
                                                        <div class="plan-item-detail">
                                                            <p class="item-description"> <?= l('plan_cards.purchase_detail_5') ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="plan-detail">
                                                    <div class="detail d-flex">
                                                        <div class="plan-icon-area ">
                                                            <i class="icon-checker plan-icon text-success"></i>
                                                        </div>
                                                        <div class="plan-item-detail">
                                                            <p class="item-description"> <?= l('plan_cards.purchase_detail_6') ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="plan-detail">
                                                    <div class="detail d-flex">
                                                        <div class="plan-icon-area ">
                                                            <i class="icon-checker plan-icon text-success"></i>
                                                        </div>
                                                        <div class="plan-item-detail">
                                                            <p class="item-description"> <?= l('plan_cards.purchase_detail_7') ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="plan-detail">
                                                    <div class="detail d-flex">
                                                        <div class="plan-icon-area ">
                                                            <i class="icon-checker plan-icon text-success"></i>
                                                        </div>
                                                        <div class="plan-item-detail">
                                                            <p class="item-description"> <?= l('plan_cards.purchase_detail_8') ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr class="card-hr under-hr mt-4">
                                            <div class="buy-btn-area">
                                                <?php if ($user) : ?>
                                                    <a class="btn mx-auto d-block rounded-pill add-to-cart  <?= $plan->plan_id == 1 ||  $plan->plan_id == 3  ? 'buy-plan-btn' : 'annual-buy-plan-btn' ?>" data-plan-name="<?= $plan->name ?>" data-plan-price="<?= $total ?>" href="<?= url('pay/' . $plan->plan_id . '?id=' . $user->referral_key) ?>">
                                                        <span class="billing-down-btn-text"><?= l('plan_cards.buy_now') ?></span>
                                                        <div class="default-spinner billing-down-spinner <?= $plan->plan_id == 1 ||  $plan->plan_id == 3  ? 'gray-spinner' : 'green-spinner' ?>"></div>
                                                    </a>
                                                <?php else :  ?>
                                                    <a class="btn mx-auto d-block rounded-pill add-to-cart  <?= $plan->plan_id == 1 ||  $plan->plan_id == 3  ? 'buy-plan-btn' : 'annual-buy-plan-btn' ?>" data-plan-name="<?= $plan->name ?>" data-plan-price="<?= $total ?>" href="<?= \Altum\Middlewares\Authentication::check() ? url('pay/' . $plan->plan_id)  : url('login?redirect=pay/' . $plan->plan_id) ?>">
                                                        <span class="billing-down-btn-text"><?= l('plan_cards.buy_now') ?></span>
                                                        <div class="default-spinner billing-down-spinner <?= $plan->plan_id == 1 ||  $plan->plan_id == 3  ? 'gray-spinner' : 'green-spinner' ?>"></div>
                                                    </a>
                                                <?php endif ?>

                                            </div>
                                        </div>
                                    <?php endif ?>
                                </div>
                            </div>
                        <?php endif ?>
                    </div>
                <?php endforeach ?>
            <?php else :  ?>

                <!-- onetime payment and discounted payment -->
                <?php

                $plan = db()->where('plan_id', $planId)->getOne('plans');
                $total = get_plan_price($planId, $code);
                $monthlyPrice = get_plan_month_price($planId, $code);
                if ($discount) {
                    $monthlyDiscountPrice = $monthlyPrice - $monthlyPrice / 100 * $discount;
                }


                ?>

                <div class="package col-xl-4 mx-auto col-id-<?= $plan->plan_id ?>">
                    <div class="annual-full-card-wrapper dis-one-card-wrp">
                        <div class="annual-full-card dis-one-card">
                            <?php if ($plan->plan_id == 4) : ?>
                                <button type="button" class="btn mx-auto d-block rounded-pill annual-time-btn">
                                    <span class="billing-btn-text"><?= l('plan_cards.custom_plan.monthly') ?></span>
                                    <div class="default-spinner billing-spinner <?= $plan->plan_id == 1 ||  $plan->plan_id == 3  ? 'gray-spinner' : 'green-spinner' ?>"></div>
                                </button>
                            <?php else : ?>
                                <button type="button" class="btn mx-auto d-block rounded-pill annual-time-btn">
                                    <span class="billing-btn-text"><?= l('plan_cards.custom_plan.lifetime') ?></span>
                                    <div class="default-spinner billing-spinner <?= $plan->plan_id == 1 ||  $plan->plan_id == 3  ? 'gray-spinner' : 'green-spinner' ?>"></div>
                                </button>
                            <?php endif ?>
                            <div class="plan-card mx-auto monthly-plan">
                                <div class="package-header<?php if (!($plan->plan_id == 4)) :  ?> set-top-space <?php else : ?> set-dis-top <?php endif ?> <?= check_usd($code) ? '' :  'not-us-dis-top' ?>">
                                    <?php if ($plan->plan_id == 4) : ?>
                                        <div class="discount-area d-flex rounded-pill my-3">
                                            <div class="present-icon-bg my-auto rounded-circle">
                                                <span>%</span>
                                            </div>
                                            <span class="discount-detail"> <?= l('plan_cards.78_discount') ?></span>
                                        </div>
                                    <?php endif ?>
                                    <h2 class="package-header-heading price-reverse-order <?= $plan->plan_id == 2 ? 'set-marg' : null ?> <?= $plan->plan_id == 5 ? 'text-center ps-0' : null ?> ">
                                        <?php if ($plan->plan_id == 4) : ?>

                                            <?php if ($countryCurrency) : ?>
                                                <?= $symbol ?> &nbsp;<?= custom_currency_format($total) ?>&nbsp;/mo
                                            <?php else : ?>
                                                <?= $symbol ?>&nbsp;<?= custom_currency_format(check_usd($code) ? $monthlyPrice :  $monthlyPrice * $rate) ?>&nbsp;<?= check_usd($code) ? '/mo' : $code ?>
                                                <span class="<?= check_usd($code) ? 'd-none' :  '' ?>">(<?= $monthlyPrice ?> USD/mo)</span>
                                            <?php endif  ?>

                                            <br class="<?= $plan->plan_id == 4 ? 'd-none' : 'd-block' ?>">

                                            <span class="stripe-plan-text" style="gap:6px">
                                                <?php if ($countryCurrency) : ?>
                                                    <?= $symbol ?> &nbsp;<?= get_plan_month_price(1, $code) ?>&nbsp;/mo
                                                <?php else : ?>
                                                    <?= $symbol ?>&nbsp;<?= custom_currency_format(check_usd($code) ? get_plan_month_price(1, $code) :  get_plan_month_price(1, $code) * $rate) ?>&nbsp;<?= check_usd($code) ? '/mo' : $code ?>
                                                    <span class="<?= check_usd($code) ? 'd-none' :  '' ?>">(<?= get_plan_month_price(1, $code) ?> USD/mo)</span>
                                                <?php endif  ?>
                                            </span>

                                        <?php else :  ?>
                                            <?php if ($countryCurrency) : ?>
                                                <?= $symbol ?> &nbsp;<?= custom_currency_format($total) ?>
                                            <?php else : ?>
                                                <?= $symbol ?>&nbsp;<?= custom_currency_format(check_usd($code) ? $monthlyPrice :  $monthlyPrice * $rate) ?>&nbsp;<?= check_usd($code)  ? '' : $code ?>
                                                <span class="<?= check_usd($code) ? 'd-none' :  '' ?>">(<?= custom_currency_format($monthlyPrice) ?> USD)</span>
                                            <?php endif  ?>
                                        <?php endif ?>
                                    </h2>

                                    <?php if ($plan->plan_id == 4) : ?>
                                        <p class="package-subheader mt-2"><?= l('plan_cards.invoiced_every_month') ?></p>
                                    <?php else :  ?>
                                        <p class="package-subheader mt-2 text-center ps-0"><?= l('plan_cards.invoiced_onetime') ?></p>
                                    <?php endif ?>

                                    <hr class="card-hr my-3 top-hr">
                                </div>


                                <div class="package-details discounted-onetime">
                                    <div class="plan-detail">
                                        <div class="detail d-flex">
                                            <div class="plan-icon-area ">
                                                <i class="icon-checker plan-icon text-success"></i>
                                            </div>
                                            <div class="plan-item-detail">
                                                <?php if ($plan->plan_id == 5) : ?>
                                                    <p class="item-description"> <?= l('plan_cards.purchase_detail_9') ?></p>
                                                <?php else : ?>
                                                    <p class="item-description"> <?= l('plan_cards.purchase_detail_1') ?></p>
                                                <?php endif ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="plan-detail">
                                        <div class="detail d-flex">
                                            <div class="plan-icon-area ">
                                                <i class="icon-checker plan-icon text-success"></i>
                                            </div>
                                            <div class="plan-item-detail">
                                                <?php if ($plan->plan_id == 5) : ?>
                                                    <p class="item-description"> <?= l('plan_cards.purchase_detail_3') ?></p>
                                                <?php else : ?>
                                                    <p class="item-description"> <?= l('plan_cards.purchase_detail_2') ?></p>
                                                <?php endif ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="plan-detail">
                                        <div class="detail d-flex">
                                            <div class="plan-icon-area ">
                                                <i class="icon-checker plan-icon text-success"></i>
                                            </div>
                                            <div class="plan-item-detail">
                                                <?php if ($plan->plan_id == 5) : ?>
                                                    <p class="item-description"> <?= l('plan_cards.purchase_detail_4') ?></p>
                                                <?php else : ?>
                                                    <p class="item-description"> <?= l('plan_cards.purchase_detail_3') ?></p>
                                                <?php endif ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="plan-detail">
                                        <div class="detail d-flex">
                                            <div class="plan-icon-area ">
                                                <i class="icon-checker plan-icon text-success"></i>
                                            </div>
                                            <div class="plan-item-detail">
                                                <?php if ($plan->plan_id == 5) : ?>
                                                    <p class="item-description"> <?= l('plan_cards.purchase_detail_5') ?>
                                                    </p>
                                                <?php else : ?>
                                                    <p class="item-description"> <?= l('plan_cards.purchase_detail_4') ?></p>
                                                <?php endif ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="plan-detail">
                                        <div class="detail d-flex">
                                            <div class="plan-icon-area ">
                                                <i class="icon-checker plan-icon text-success"></i>
                                            </div>
                                            <div class="plan-item-detail">
                                                <?php if ($plan->plan_id == 5) : ?>
                                                    <p class="item-description"> <?= l('plan_cards.purchase_detail_10') ?></p>
                                                <?php else : ?>
                                                    <p class="item-description"> <?= l('plan_cards.purchase_detail_5') ?></p>
                                                <?php endif ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="plan-detail">
                                        <div class="detail d-flex">
                                            <div class="plan-icon-area ">
                                                <i class="icon-checker plan-icon text-success"></i>
                                            </div>
                                            <div class="plan-item-detail">
                                                <?php if ($plan->plan_id == 5) : ?>
                                                    <p class="item-description"> <?= l('plan_cards.purchase_detail_7') ?></p>
                                                <?php else : ?>
                                                    <p class="item-description"> <?= l('plan_cards.purchase_detail_6') ?></p>
                                                <?php endif ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php if ($plan->plan_id != 5) : ?>
                                        <div class="plan-detail">
                                            <div class="detail d-flex">
                                                <div class="plan-icon-area ">
                                                    <i class="icon-checker plan-icon text-success"></i>
                                                </div>
                                                <div class="plan-item-detail">
                                                    <p class="item-description"> <?= l('plan_cards.purchase_detail_7') ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="plan-detail">
                                            <div class="detail d-flex">
                                                <div class="plan-icon-area ">
                                                    <i class="icon-checker plan-icon text-success"></i>
                                                </div>
                                                <div class="plan-item-detail">
                                                    <p class="item-description"> <?= l('plan_cards.purchase_detail_8') ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif ?>
                                </div>

                                <hr class="card-hr under-hr mt-4">
                                <div class="buy-btn-area">

                                    <?php if ($user) : ?>
                                        <?php if ($planId == 5) : ?>
                                            <a class="btn mx-auto d-block rounded-pill add-to-cart annual-buy-plan-btn" data-plan-name="<?= $plan->name ?>" data-plan-price="<?= $total ?>" href="<?= url('pay/' . $plan->plan_id . '?type=onetime&id='  . $user->referral_key) ?>">
                                                <span class="billing-down-btn-text"><?= l('plan_cards.buy_now') ?></span>
                                                <div class="default-spinner billing-down-spinner <?= $plan->plan_id == 1 ||  $plan->plan_id == 3  ? 'gray-spinner' : 'green-spinner' ?>"></div>
                                            </a>
                                        <?php else : ?>
                                            <a class="btn mx-auto d-block rounded-pill add-to-cart annual-buy-plan-btn" data-plan-name="<?= $plan->name ?>" data-plan-price="<?= $total ?>" href="<?= url('pay/' . $plan->plan_id . '?type=discounted&id='  . $user->referral_key) ?>">
                                                <span class="billing-down-btn-text"><?= l('plan_cards.buy_now') ?></span>
                                                <div class="default-spinner billing-down-spinner <?= $plan->plan_id == 1 ||  $plan->plan_id == 3  ? 'gray-spinner' : 'green-spinner' ?>"></div>
                                            </a>
                                        <?php endif ?>
                                    <?php else : ?>
                                        <a class="btn mx-auto d-block rounded-pill add-to-cart annual-buy-plan-btn" data-plan-name="<?= $plan->name ?>" data-plan-price="<?= $total ?>" href="<?= \Altum\Middlewares\Authentication::check() ? url('pay/' . $plan->plan_id)  : url('login?redirect=pay/' . $plan->plan_id) ?>">
                                            <span class="billing-down-btn-text"><?= l('plan_cards.buy_now') ?></span>
                                            <div class="default-spinner billing-down-spinner <?= $plan->plan_id == 1 ||  $plan->plan_id == 3  ? 'gray-spinner' : 'green-spinner' ?>"></div>
                                        </a>
                                    <?php endif  ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif ?>
        </div>
    </div>
    <?php if (($planId != 5) && ($planId != 4)) : ?>
        <div class="special-feature">
            <div class="row">
                <div class="col-12 feature-heading-area justify-content-center align-item-baseline d-flex flex-column">
                    <h2 class="feature-heading"><?= l('plan_cards.features_title') ?></h2>
                    <?php if ($planId == 4) : ?>
                        <p class="feature-subheading"><?= l('plan_cards.features_subtitle_single_plan') ?></p>
                    <?php else : ?>
                        <p class="feature-subheading"><?= l('plan_cards.features_subtitle_all_plan') ?></p>
                    <?php endif ?>
                </div>
            </div>
            <hr class="card-hr my-1">
            <div class="row">
                <div class="col-12">
                    <div class="special-feature-pack">
                        <div class="plan-detail feature-detail">
                            <div class="detail f-detail d-flex">
                                <div class="plan-icon-area ">
                                    <i class="icon-checker plan-icon  text-success"></i>
                                </div>
                                <div class="plan-item-detail">
                                    <p class="feature-description"> <?= l('plan_cards.purchase_detail_1') ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="plan-detail feature-detail">
                            <div class="detail f-detail d-flex">
                                <div class="plan-icon-area ">
                                    <i class="icon-checker plan-icon  text-success"></i>
                                </div>
                                <div class="plan-item-detail">
                                    <p class="feature-description"> <?= l('plan_cards.purchase_detail_2') ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="plan-detail feature-detail">
                            <div class="detail f-detail d-flex">
                                <div class="plan-icon-area ">
                                    <i class="icon-checker plan-icon  text-success"></i>
                                </div>
                                <div class="plan-item-detail">
                                    <p class="feature-description"> <?= l('plan_cards.purchase_detail_3') ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="plan-detail feature-detail">
                            <div class="detail f-detail d-flex">
                                <div class="plan-icon-area ">
                                    <i class="icon-checker plan-icon  text-success"></i>
                                </div>
                                <div class="plan-item-detail">
                                    <p class="feature-description"> <?= l('plan_cards.purchase_detail_4') ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="plan-detail feature-detail">
                            <div class="detail f-detail d-flex">
                                <div class="plan-icon-area ">
                                    <i class="icon-checker plan-icon  text-success"></i>
                                </div>
                                <div class="plan-item-detail">
                                    <p class="feature-description"> <?= l('plan_cards.purchase_detail_5') ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="plan-detail feature-detail">
                            <div class="detail f-detail d-flex">
                                <div class="plan-icon-area ">
                                    <i class="icon-checker plan-icon  text-success"></i>
                                </div>
                                <div class="plan-item-detail">
                                    <p class="feature-description"> <?= l('plan_cards.purchase_detail_6') ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="plan-detail feature-detail">
                            <div class="detail f-detail d-flex">
                                <div class="plan-icon-area ">
                                    <i class="icon-checker plan-icon  text-success"></i>
                                </div>
                                <div class="plan-item-detail">
                                    <p class="feature-description"> <?= l('plan_cards.purchase_detail_7') ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="plan-detail feature-detail">
                            <div class="detail f-detail d-flex">
                                <div class="plan-icon-area ">
                                    <i class="icon-checker plan-icon  text-success"></i>
                                </div>
                                <div class="plan-item-detail">
                                    <p class="feature-description"> <?= l('plan_cards.purchase_detail_8') ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif ?>
</div>
</div>
</div>

<!-- Plans -->
<script>
    $(".plan-friday-btn").on("click", function() {
        $('html, body').scrollTop($(".plan-subheader").offset().top);
    });

    var planBtnClicked = false;

    $(".buy-plan-btn , .annual-buy-plan-btn").on("click", function() {
        if (!planBtnClicked) {
            $(this).children(".billing-down-btn-text").addClass("invisible");
            $(this).children(".billing-down-spinner").show();
            $(this).attr("disabled", true);
            console.log("plan down click");
        }
    });


    $(".plan-btn , .annual-time-btn").on("click", function() {
        $(this).children(".billing-btn-text").addClass("invisible");
        $(this).children(".billing-spinner").show();
        $(this).attr("disabled", true).addClass("billing-plan-btn-wrap");
        $(".billing-down-btn-text").removeClass("invisible");
        $(".billing-down-spinner").hide();
        planBtnClicked = true;
    });

    $(document).ready(function() {
        $(".billing-spinner , .billing-down-spinner").hide();

        var planUrl = window.location.href;

        history.pushState({
            page: "plans"
        }, "plans", planUrl);
    });
</script>
