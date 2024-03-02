<?php defined('ALTUMCODE') || die() ?>

<?php

$currentUrl = SITE_URL . \Altum\Routing\Router::$original_request;


if (isset($data->discount)) {
    $data->discount = $data->discount;
} else {
    $data->discount = null;
}

$definedCurrency = get_user_currency($data->code);

?>

<div class="payment-detail-area col-xl-5 py-4">

    <div class="purchase-package-wrap">
        <div class="purchase-package-detail">
            <div class="purchase-plan-detail d-flex">
                <?php if ($currentUrl == url('change-plan/' . $data->plan->plan_id)) : ?>
                    <button type="button" class="btn purchase-icon" onclick="editUpgrade()">
                        <span class="icon-edit grey package-icon"></span>
                    </button>
                <?php elseif ($currentUrl == url('reactive-plan/' . $data->plan->plan_id)) : ?>

                    <button type="button" class="btn purchase-icon" onclick="editActivePlan()">
                        <span class="icon-edit grey package-icon"></span>
                    </button>
                <?php else : ?>
                    <button type="button" class="btn purchase-icon" onclick="editPlan()">
                        <span class="icon-edit grey package-icon"></span>
                    </button>
                <?php endif ?>
                <div class="purchase-plan-price w-100 d-flex <?= check_usd($data->code) ? '' :  'other-currency-purchase-plan' ?>" style="margin-left: 12px;">
                    <div class="col-7 m-auto plan-name-wrap">
                        <span class="plan-name m-auto"><?php echo $data->planName . ' subscription' ?></span>
                    </div>

                    <?php if ($data->discount) : ?>
                        <div class="col-5 my-auto plan-price-plan">
                            <?php if ($countryCurrency) : ?>
                                <span class="plan-price"><?= $symbol ?>&nbsp;<?= custom_currency_format($monthlyDiscountPrice) ?></span>
                            <?php else : ?>
                                <span class="plan-price">$<?= custom_currency_format($monthlyDiscountPrice) ?></span>
                                <span class="subprice <?= check_usd($data->code) ? 'd-none' :  '' ?>">(<?= $symbol ?>&nbsp;<?= custom_currency_format(check_usd($data->code)  ? $monthlyDiscountPrice :  $monthlyDiscountPrice * $rate, 2, '.', ',') ?>)</span>
                            <?php endif  ?>
                        </div>
                    <?php elseif ($data->plan->plan_id == 5) : ?>
                        <div class="col-5 my-auto plan-price-plan">
                            <?php if ($countryCurrency) : ?>
                                <span class="plan-price"><?= $symbol ?>&nbsp;<?= custom_currency_format($total) ?></span>
                            <?php else : ?>
                                <span class="plan-price">$<?= custom_currency_format($total) ?></span>
                                <span class="subprice <?= check_usd($data->code) ? 'd-none' :  '' ?>">(<?= $symbol ?>&nbsp;<?= custom_currency_format(check_usd($data->code)  ? $total :  $total * $rate) ?>)</span>
                            <?php endif  ?>
                        </div>

                    <?php else : ?>
                        <div class="col-5 my-auto plan-price-plan">
                            <?php if (!$definedCurrency && !check_usd($data->code)) : ?>
                                <span class="plan-price"><?= $data->symbol ?> <?= custom_currency_format($data->totalDue * exchange_rate($data->user)['rate']) ?></span>
                            <?php else : ?>
                                <span class="plan-price"><?= $data->symbol ?> <?= custom_currency_format($data->totalDue)?></span>
                        </div>
                    <?php endif  ?>
                </div>
            <?php endif ?>
            </div>
        </div>
        <hr class="pay-hr mt-4">
        <div class="price-summery d-flex <?= check_usd($data->code) ? '' :  'other-currency-summery' ?>">
            <div class="col-5 my-auto update-summery-heading">
                <p class="summery-heading"><?= l('billing_com_summary.total') ?></p>
            </div>
            <div class="col-7 total-wrp">
                <?php if ($data->discount) : ?>
                    <?php if ($countryCurrency) : ?>
                        <span class="summery-price-head"><?= $symbol ?>&nbsp;<?= custom_currency_format($discountTotal) ?></span>
                    <?php else : ?>
                        <span class="summery-price-head">$<?= custom_currency_format($discountTotal) ?></span>
                        <p class="sub-summery-price <?= check_usd($data->code) ? 'd-none' :  '' ?>">(<?= $symbol ?>&nbsp;<?= custom_currency_format(check_usd($data->code)  ? $discountTotal :  $discountTotal * $rate) ?>)</p>
                    <?php endif  ?>


                <?php elseif ($data->plan->plan_id == 5) : ?>
                    <?php if (isset($countryCurrency)) : ?>
                        <span class="summery-price-head"><?= $symbol ?>&nbsp;<?= custom_currency_format($total) ?></span>
                    <?php else : ?>
                        <span class="summery-price-head">$<?= custom_currency_format($total) ?> <?= check_usd($data->code) ? '' :  'USD' ?></span>
                        <p class="sub-summery-price <?= check_usd($data->code) ? 'd-none' :  '' ?>">(<?= $symbol ?>&nbsp;<?= custom_currency_format(check_usd($data->code)  ? $total :  $total * $rate) ?>)</p>
                    <?php endif  ?>

                <?php else : ?>
                    <?php if (isset($countryCurrency)) : ?>
                        <span class="summery-price-head"><?= $symbol ?>&nbsp;<?= custom_currency_format($total) ?></span>

                    <?php else : ?>
                        <?php if (!$definedCurrency && !check_usd($data->code)) : ?>
                            <span class="summery-price-head"><?= $data->symbol ?> <?= custom_currency_format($data->totalDue * exchange_rate($data->user)['rate']) ?></span>
                        <?php else : ?>
                            <span class="summery-price-head"><?= $data->symbol ?> <?= custom_currency_format($data->totalDue) ?> </span>
                        <?php endif  ?>
                    <?php endif  ?>

                <?php endif ?>
            </div>
        </div>
    </div>
    <div class="purchase-package-info-wrap mt-4">
        <h2 class="purchase-plan-heading mb-3"><?= l('billing_com_summary.plan_' . $data->plan->name) ?></h2>
        <?php if ($data->plan->plan_id == 5) : ?>
            <div class="purchase-package-info">
                <div class="purchase-pack-all-deatil">
                    <div class="purchase-description d-flex">
                        <div class="pack-detail-icon">
                            <span><i class="fa fa-check-circle" aria-hidden="true"></i></span>
                        </div>
                        <div class="purchase-detail-area">
                            <p class="purchase-detail-area-text"><?= l('billing_com_summary.purchase_detail_9') ?></p>
                        </div>
                    </div>
                    <div class="purchase-description d-flex">
                        <div class="pack-detail-icon">
                            <span><i class="fa fa-check-circle" aria-hidden="true"></i></span>
                        </div>
                        <div class="purchase-detail-area">
                            <p class="purchase-detail-area-text"><?= l('billing_com_summary.purchase_detail_3') ?></p>
                        </div>
                    </div>
                    <div class="purchase-description d-flex">
                        <div class="pack-detail-icon">
                            <span><i class="fa fa-check-circle" aria-hidden="true"></i></span>
                        </div>
                        <div class="purchase-detail-area">
                            <p class="purchase-detail-area-text"><?= l('billing_com_summary.purchase_detail_4') ?></p>
                        </div>
                    </div>
                    <div class="purchase-description d-flex">
                        <div class="pack-detail-icon">
                            <span><i class="fa fa-check-circle" aria-hidden="true"></i></span>
                        </div>
                        <div class="purchase-detail-area">
                            <p class="purchase-detail-area-text"><?= l('billing_com_summary.purchase_detail_5') ?></p>
                        </div>
                    </div>
                    <div class="purchase-description d-flex">
                        <div class="pack-detail-icon">
                            <span><i class="fa fa-check-circle" aria-hidden="true"></i></span>
                        </div>
                        <div class="purchase-detail-area">
                            <p class="purchase-detail-area-text"><?= l('billing_com_summary.purchase_detail_6') ?></p>
                        </div>
                    </div>
                    <div class="purchase-description d-flex">
                        <div class="pack-detail-icon">
                            <span><i class="fa fa-check-circle" aria-hidden="true"></i></span>
                        </div>
                        <div class="purchase-detail-area">
                            <p class="purchase-detail-area-text"><?= l('billing_com_summary.purchase_detail_7') ?></p>
                        </div>
                    </div>
                </div>
            </div>
        <?php else : ?>
            <div class="purchase-package-info">
                <div class="purchase-pack-all-deatil">
                    <div class="purchase-description d-flex">
                        <div class="pack-detail-icon">
                            <span><i class="fa fa-check-circle" aria-hidden="true"></i></span>
                        </div>
                        <div class="purchase-detail-area">
                            <p class="purchase-detail-area-text"><?= l('billing_com_summary.purchase_detail_1') ?></p>
                        </div>
                    </div>
                    <div class="purchase-description d-flex">
                        <div class="pack-detail-icon">
                            <span><i class="fa fa-check-circle" aria-hidden="true"></i></span>
                        </div>
                        <div class="purchase-detail-area">
                            <p class="purchase-detail-area-text"><?= l('billing_com_summary.purchase_detail_2') ?></p>
                        </div>
                    </div>
                    <div class="purchase-description d-flex">
                        <div class="pack-detail-icon">
                            <span><i class="fa fa-check-circle" aria-hidden="true"></i></span>
                        </div>
                        <div class="purchase-detail-area">
                            <p class="purchase-detail-area-text"><?= l('billing_com_summary.purchase_detail_3') ?></p>
                        </div>
                    </div>
                    <div class="purchase-description d-flex">
                        <div class="pack-detail-icon">
                            <span><i class="fa fa-check-circle" aria-hidden="true"></i></span>
                        </div>
                        <div class="purchase-detail-area">
                            <p class="purchase-detail-area-text"><?= l('billing_com_summary.purchase_detail_4') ?></p>
                        </div>
                    </div>
                    <div class="purchase-description d-flex">
                        <div class="pack-detail-icon">
                            <span><i class="fa fa-check-circle" aria-hidden="true"></i></span>
                        </div>
                        <div class="purchase-detail-area">
                            <p class="purchase-detail-area-text"><?= l('billing_com_summary.purchase_detail_5') ?></p>
                        </div>
                    </div>
                    <div class="purchase-description d-flex">
                        <div class="pack-detail-icon">
                            <span><i class="fa fa-check-circle" aria-hidden="true"></i></span>
                        </div>
                        <div class="purchase-detail-area">
                            <p class="purchase-detail-area-text"><?= l('billing_com_summary.purchase_detail_6') ?></p>
                        </div>
                    </div>
                    <div class="purchase-description d-flex">
                        <div class="pack-detail-icon">
                            <span><i class="fa fa-check-circle" aria-hidden="true"></i></span>
                        </div>
                        <div class="purchase-detail-area">
                            <p class="purchase-detail-area-text"><?= l('billing_com_summary.purchase_detail_7') ?></p>
                        </div>
                    </div>
                    <div class="purchase-description d-flex">
                        <div class="pack-detail-icon">
                            <span><i class="fa fa-check-circle" aria-hidden="true"></i></span>
                        </div>
                        <div class="purchase-detail-area">
                            <p class="purchase-detail-area-text"><?= l('billing_com_summary.purchase_detail_8') ?></p>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif ?>

    </div>

</div>
</div>