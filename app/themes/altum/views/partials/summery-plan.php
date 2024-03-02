<?php defined('ALTUMCODE') || die() ?>

<?php

$currentUrl = SITE_URL . \Altum\Routing\Router::$original_request;
$previousUrl = $_SERVER['HTTP_REFERER'];



if (isset($data->discount)) {
    $data->discount = $data->discount;
} else {
    $data->discount = null;
}

?>

<div class="payment-detail-area col-xl-5 py-4">
    <h2 class="payment-subhead"><?= l('billing_com_summary.summary') ?></h2>

    <div class="purchase-package-wrap">
        <div class="purchase-package-detail">
            <div class="purchase-plan-detail d-flex">               
                <button type="button" class="btn purchase-icon" onclick="editPlan()">
                    <span class="icon-edit grey package-icon"></span>
                </button>               
                <div class="purchase-plan-price w-100 d-flex">
                    <div class="col-5 m-auto">
                        <span class="plan-name m-auto"><?php echo $name ?></span>
                    </div>
                    <?php if ($data->discount) : ?>
                        <div class="col-7 my-auto">
                        <?php if($countryCurrency) :?>
                            <span class="plan-price"><?= $symbol ?>&nbsp;<?= custom_currency_format($monthlyDiscountPrice) ?>/mo</span>                            
                        <?php else : ?>
                            <span class="plan-price">$<?= custom_currency_format($monthlyDiscountPrice) ?> <?= check_usd($code) ? '' :  'USD' ?>/mo</span>
                            <span class="subprice <?= check_usd($code) ? 'd-none' :  '' ?>">(<?= $symbol ?>&nbsp;<?= custom_currency_format(check_usd($code)  ? $monthlyDiscountPrice :  $monthlyDiscountPrice * $rate, 2, '.', ',') ?>&nbsp;<?= $code ?>)</span>
                        <?php endif  ?> 
                        </div>
                    <?php elseif ($data->plan->plan_id == 5) : ?>                        
                        <div class="col-7 my-auto">
                            <?php if($countryCurrency) :?>
                                <span class="plan-price"><?= $symbol ?>&nbsp;<?= custom_currency_format($total) ?></span>                                
                            <?php else : ?>
                                <span class="plan-price">$<?= custom_currency_format($total) ?></span>
                                <span class="subprice <?= check_usd($code) ? 'd-none' :  '' ?>">(<?= $symbol ?>&nbsp;<?= custom_currency_format(check_usd($code)  ? $total :  $total * $rate) ?>&nbsp;<?= $code ?>)</span>
                            <?php endif  ?> 
                        </div>

                    <?php else : ?>
                        <div class="col-7 my-auto">
                            <?php if($countryCurrency) :?>
                                <span class="plan-price"><?= $symbol ?>&nbsp;<?= custom_currency_format($price)?>/mo</span>                                
                            <?php else : ?>
                                <span class="plan-price">$<?= custom_currency_format($price) ?> <?= check_usd($code) ? '' :  'USD' ?>/mo</span>
                                <span class="subprice <?= check_usd($code) ? 'd-none' :  '' ?>">(<?= $symbol ?>&nbsp;<?= custom_currency_format(check_usd($code)  ? $price :  $price * $rate) ?>&nbsp;<?= $code ?>)</span>
                            </div>
                            <?php endif  ?> 
                        </div>
                    <?php endif ?>
                </div>
            </div>
            <hr class="pay-hr mt-4">
            <div class="price-summery d-flex">
                <div class="col-5 my-auto">
                    <p class="summery-heading"><?= l('billing_com_summary.total') ?></p>
                </div>
                <div class="col-7 total-wrp">
                    <?php if ($data->discount) : ?>
                        <?php if($countryCurrency) :?>
                            <span class="summery-price-head"><?= $symbol ?>&nbsp;<?= custom_currency_format($discountTotal) ?></span>                           
                        <?php else : ?>
                            <span class="summery-price-head">$<?= custom_currency_format($discountTotal) ?> <?= check_usd($code) ? '' :  'USD' ?></span>
                            <p class="sub-summery-price <?= check_usd($code) ? 'd-none' :  '' ?>">(<?= $symbol ?>&nbsp;<?= custom_currency_format(check_usd($code)  ? $discountTotal :  $discountTotal * $rate) ?>&nbsp;<?= $code ?>)</p>
                        <?php endif  ?> 

                        
                    <?php elseif ($data->plan->plan_id == 5) : ?>
                        <?php if($countryCurrency) :?>
                            <span class="summery-price-head"><?= $symbol ?>&nbsp;<?= custom_currency_format($total) ?></span> 
                        <?php else : ?>
                            <span class="summery-price-head">$<?= custom_currency_format($total) ?> <?= check_usd($code) ? '' :  'USD' ?></span>
                            <p class="sub-summery-price <?= check_usd($code) ? 'd-none' :  '' ?>">(<?= $symbol ?>&nbsp;<?= custom_currency_format(check_usd($code)  ? $total :  $total * $rate) ?>&nbsp;<?= $code ?>)</p>
                        <?php endif  ?> 
                        
                    <?php else : ?>
                        <?php if($countryCurrency) :?>
                            <span class="summery-price-head"><?= $symbol ?>&nbsp;<?= custom_currency_format($total) ?></span>
                            
                        <?php else : ?>
                            <span class="summery-price-head">$<?= custom_currency_format($total) ?> <?= check_usd($code) ? '' :  'USD' ?></span>
                        <p class="sub-summery-price <?= check_usd($code) ? 'd-none' :  '' ?>">(<?= $symbol ?>&nbsp;<?= custom_currency_format(check_usd($code)  ? $total :  $total * $rate) ?>&nbsp;<?= $code ?>)</p>
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
        <div class="purchase-type-area">
            <h2 class="purchase-plan-heading mb-3"><?= l('billing_com_summary.accepted_payment_methods') ?></h2>
            <div class="purchase-type-wrap container-fluid">
                <div class="purchase-type row">
                    <div class="col-6 col-md-3 col-xl-6">
                        <div class="img-area m-auto">
                            <img class="img-fluid" src="<?= ASSETS_FULL_URL . 'images/payment-methods/visa.png' ?>" alt="visa">
                        </div>
                    </div>
                    <div class="col-6 col-md-3 col-xl-6">
                        <div class="img-area m-auto">
                            <img class="img-fluid" src="<?= ASSETS_FULL_URL . 'images/payment-methods/amreican-express.png' ?>" alt="american express">
                        </div>
                    </div>
                    <div class="col-6 col-md-3 col-xl-6">
                        <div class="img-area m-auto">
                            <img class="img-fluid" src="<?= ASSETS_FULL_URL . 'images/payment-methods/google-pay.png' ?>" alt="google pay">
                        </div>
                    </div>
                    <div class="col-6 col-md-3 col-xl-6">
                        <div class="img-area m-auto">
                            <img class="img-fluid" src="<?= ASSETS_FULL_URL . 'images/payment-methods/master.png' ?>" alt="master">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>