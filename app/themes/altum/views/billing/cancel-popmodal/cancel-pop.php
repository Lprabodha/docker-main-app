<?php

$rate        = null;
$symbol      = null;
$code        = null;
$currentUser = $this->user;



if (isset($data->newPlanId)) {
    $planId  = $data->newPlanId;
} elseif (isset($data->suspendsubcription)) {
    $planId  = $data->suspendsubcription->items['data'][0]->plan->metadata->plan_id;
    $delinquentSubscriptionId = $data->suspendsubcription->items['data'][0]->subscription;
} else {
    $planId  =  $this->user->plan_id;
}

$plan        = db()->where('plan_id', $planId)->getOne('plans');
$promo_70    = db()->where('user_id', $this->user->user_id)->where('code', '70OFF')->getOne('payments');



if ($exchange_rate = exchange_rate($currentUser)) {
    $rate   = $exchange_rate['rate'];
    $symbol = $exchange_rate['symbol'];
    $code   = $exchange_rate['code'];
} else {
    $code   = 'USD';
}
$countryCurrency = get_user_currency($code);

if ($plan->plan_id == 1) {

    $payment_total_amount  = $this->user->payment_total_amount;

    if ($payment_total_amount == '39.95') {
        $total         = 39.95 * 12;
        $monthlyPrice  = 39.95;
    } else {
        $total         = get_plan_price($plan->plan_id, $code);
        $monthlyPrice  = get_plan_month_price($plan->plan_id, $code);
    }
} else {
    $total          = get_plan_price($plan->plan_id, $code);
    $monthlyPrice   = get_plan_month_price($plan->plan_id, $code);
}



switch ($plan->plan_id) {
    case 1:
        $name      = l('pay.1_month_plan');
        $subTitle  = l('plan_cards.invoiced_every_month');
        $title     = l('plan_cards.custom_plan.monthly');
        $priceId   = STRIPE_PRICE_1_ID;
        $subTitle2 =  l('billing.subscription_canceled.month');
        break;
    case 2:
        $name      = l('pay.12_month_plan');
        $subTitle  = l('plan_cards.invoiced_every_year');
        $title     = l('plan_cards.custom_plan.annual');
        $subTitle2 =  l('billing.subscription_canceled.month');
        $priceId   = STRIPE_PRICE_12_ID;

        break;
    case 3:
        $name      = l('pay.3_month_plan');
        $subTitle  = l('plan_cards.invoiced_each_quarter');
        $title     = l('plan_cards.custom_plan.quarterly');
        $subTitle2 =  l('billing.subscription_canceled.month');
        $priceId   = STRIPE_PRICE_3_ID;
        break;

    default:
        $name      = l('pay.1_month_plan');
        $subTitle  = l('plan_cards.invoiced_every_month');
        $title     = l('plan_cards.custom_plan.monthly');
        $subTitle2 =  l('billing.subscription_canceled.month');
        $priceId   = STRIPE_PRICE_1_ID;
}


?>

<script src="https://js.stripe.com/v3/"></script>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

<div class="modal feedback-modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModal" aria-hidden="true">
    <div class="feedback-modal-dialog modal-dialog modal-dialog-centered modal-dialog-export">
        <div class="modal-content">
            <button type="button" class="close feedback-modal-close" data-dismiss="modal" aria-label="Close">
                <svg class="MuiSvgIcon-root jss709" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 24px;">
                    <path d="M13.41,12l5.3-5.29a1,1,0,1,0-1.42-1.42L12,10.59,6.71,5.29A1,1,0,0,0,5.29,6.71L10.59,12l-5.3,5.29a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0L12,13.41l5.29,5.3a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42Z"></path>
                </svg>
            </button>
            <div class="feedback-modal-content">
                <div class="feedback-header-wrap">
                    <p class="feedback-title"><?= l('billing.cancel_sub_feedback_title') ?></p>
                    <span class="feedback-subtitle pt-2 d-block"><?= l('billing.cancel_sub_feedback_subtitle') ?></span>
                </div>
                <div class="feedback-types-wrap pt-4">
                    <div class="feedback-card-full-wrap">
                        <div class="feedback-card-wrap">
                            <div class="feedback-radio-btn-wrap">
                                <input type="radio" id="feedback1" class="feedback-radio" name="fd-radio" value="defficulties_platform" />
                                <span class="green-checkbox"></span>
                            </div>
                            <div class="feedback-text-wrap">
                                <span class="feedback-text"><?= l('billing.cancel_sub_feedback_1') ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="feedback-card-full-wrap">
                        <div class="feedback-card-wrap">
                            <div class="feedback-radio-btn-wrap">
                                <input type="radio" id="feedback1" class="feedback-radio" name="fd-radio" value="enough_platform" />
                                <span class="green-checkbox"></span>
                            </div>
                            <div class="feedback-text-wrap">
                                <span class="feedback-text"><?= l('billing.cancel_sub_feedback_2') ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="feedback-card-full-wrap">
                        <div class="feedback-card-wrap">
                            <div class="feedback-radio-btn-wrap">
                                <input type="radio" id="feedback1" class="feedback-radio" name="fd-radio" value="missing_feature" />
                                <span class="green-checkbox"></span>
                            </div>
                            <div class="feedback-text-wrap">
                                <span class="feedback-text"><?= l('billing.cancel_sub_feedback_3') ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="feedback-card-full-wrap">
                        <div class="feedback-card-wrap">
                            <div class="feedback-radio-btn-wrap">
                                <input type="radio" id="feedback1" class="feedback-radio" name="fd-radio" value="platform_expensive" />
                                <span class="green-checkbox"></span>
                            </div>
                            <div class="feedback-text-wrap">
                                <span class="feedback-text"><?= l('billing.cancel_sub_feedback_4') ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="feedback-card-full-wrap">
                        <div class="feedback-card-wrap">
                            <div class="feedback-radio-btn-wrap">
                                <input type="radio" id="feedback1" class="feedback-radio" name="fd-radio" value="no_need_qr" />
                                <span class="green-checkbox"></span>
                            </div>
                            <div class="feedback-text-wrap">
                                <span class="feedback-text"><?= l('billing.cancel_sub_feedback_5') ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="feedback-card-full-wrap">
                        <div class="feedback-card-wrap">
                            <div class="feedback-radio-btn-wrap">
                                <input type="radio" id="feedback1" class="feedback-radio" name="fd-radio" value="another_platform" />
                                <span class="green-checkbox"></span>
                            </div>
                            <div class="feedback-text-wrap">
                                <span class="feedback-text"><?= l('billing.cancel_sub_feedback_6') ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="feedback-card-full-wrap">
                        <div class="feedback-card-wrap">
                            <div class="feedback-radio-btn-wrap">
                                <input type="radio" id="feedback1" class="feedback-radio" name="fd-radio" value="other" />
                                <span class="green-checkbox"></span>
                            </div>
                            <div class="feedback-text-wrap">
                                <span class="feedback-text"><?= l('billing.cancel_sub_feedback_7') ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="feedback-text-area-wrap pt-3">
                    <div class="feedback-text-area-header">
                        <span class="text-danger req-mark pe-1">*</span><span class="feedback-text-area-title"><?= l('billing.cancel_sub_feedback_textarea_title') ?></span>
                    </div>
                    <div class="text-area-wrap mt-3">
                        <textarea id="customFeedback" name="customFeedback" placeholder="<?= l('billing.cancel_sub_feedback_textarea_placeholder') ?>" class="form-control textarea-control" rows="5" style="border-radius: 4px;" spellcheck="false"></textarea>
                    </div>
                    <div class="feedback-submit-wrap pt-3 d-flex justify-content-end">
                        <button type="button" class="btn feedback-submit-btn"><?= l('billing.cancel_sub_feedback_btn_title') ?></button>
                    </div>
                </div>
            </div>
            <div class="promo1-modal-content promo-modal-content promo1" style="display: none;">
                <input type="hidden" id="feedback_type">
                <div class="promo-1-header-wrap pt-2">
                    <span class="d-block text-center promo-header-heading"><?= l('billing.cancel_sub_promo1_title') ?></span>
                    <span class="promo-header-subheading promo1-subheading1"></span>
                    <span class="promo-header-subheading promo1-subheading2"><?= l('billing.cancel_sub_promo1_subtitle_2') ?></span>
                </div>
                <div class="promo-plan-wrap">
                    <div class="special-offer-wrap">
                        <div class="offer-icon-wrap">
                            <span class="discount-icon" translate="no">%</span>
                        </div>
                        <span class="offer-text ps-2"><?= l('billing.cancel_sub_promo1_offer_text') ?></span>
                    </div>
                    <div class="promo-plan-card">
                        <div class="plan-text-wrap">
                            <div class="plan-title-wrap">
                                <p class="plan-title <?= check_usd($code) ? '' : 'other-plan-title ' ?>"><?= $name ?></p>
                                <div class="plan-subtitle-wrap">
                                    <p class="plan-subtitle"><?= $subTitle ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="plan-price-wrap">
                            <p class="plan-full-price <?= check_usd($code) ? '' : 'other-offerfull-currency' ?>">
                                <?php if (check_usd($code) || get_user_currency($code)) : ?>
                                    <?= $symbol ?>&nbsp;<?= custom_currency_format($monthlyPrice) ?>
                                <?php else : ?>
                                    <?php if ($countryCurrency) : ?>
                                        <?= $symbol ?>&nbsp;<?= custom_currency_format($monthlyPrice) ?>&nbsp;<?= $code  ?>
                                    <?php else : ?>
                                        <?= $symbol ?>&nbsp;<?= custom_currency_format($monthlyPrice * $rate) ?>&nbsp;<?= $code  ?>
                                    <?php endif  ?>
                                <?php endif ?>

                            </p>
                            <p class="plan-discount-price <?= check_usd($code) ? '' : 'other-offer-currency' ?>">
                                <?php
                                $monthlyDiscountPrice = $monthlyPrice - $monthlyPrice / 100 * 70;
                                ?>
                                <span translate="no">
                                    <?php if (check_usd($code) || get_user_currency($code)) : ?>
                                        <?= $symbol ?>&nbsp;<?= custom_currency_format($monthlyDiscountPrice) . ' /mo'  ?>
                                    <?php else : ?>
                                        <?php if ($countryCurrency) : ?>
                                            <?= $symbol ?>&nbsp;<?= custom_currency_format($monthlyDiscountPrice) ?> <?= $code  ?> /mo
                                        <?php else : ?>
                                            <?= $symbol ?>&nbsp;<?= custom_currency_format($monthlyDiscountPrice * $rate) ?> <?= $code  ?> /mo
                                        <?php endif  ?>
                                    <?php endif ?>
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row w-100 offer-description-wrap pt-4 m-auto">
                    <div class="col-12 col-md-9">
                        <div class="offer-description">
                            <span class="offer-description-text"><?= l('billing.cancel_sub_promo1_offer_description_1') ?><b><?= l('billing.cancel_sub_promo1_offer_description_2') ?></b><?= l('billing.cancel_sub_promo1_offer_description_3') ?><b>[<?= $title  ?>]</b> <?= l('billing.cancel_sub_promo1_offer_description_4') ?><b>[<?= (new \DateTime($this->user->plan_expiration_date))->format('M d, Y') ?>],</b> <?= l('billing.cancel_sub_promo1_offer_description_5') ?></span>
                        </div>
                    </div>
                    <div class="col-0 col-md-3"></div>
                </div>
                <div class="promo-bottom-offer-full-wrap">
                    <div class="promo-bottom-wrap">
                        <div class="promo-offer-wrap row w-100 m-auto">
                            <div class="col-12 col-md-8 offer-area">
                                <p class="offer-promo-text"><?= l('billing.cancel_sub_promo1_offer_area_title_1') ?><span class="promo-1-text-color"><?= l('billing.cancel_sub_promo1_offer_area_title_2') ?></span><?= l('billing.cancel_sub_promo1_offer_area_title_3') ?></p>
                                <div class="offer-btn-wrap pt-2">
                                    <button type="button" class="btn offer-submit-btn btn-offer promo1-offer-btn" data-discount="70" data-suspend-payment="<?= isset($data->suspendsubcription) ? 'yes' : 'no' ?>" data-month-free="no">
                                        <span class="offer-submit-text"><?= l('billing.cancel_sub_promo1_accept_offer_title') ?></span>
                                        <div class="cancel-spinner"></div>
                                    </button>
                                </div>
                                <div class="offer-cancel-wrap">
                                    <span class="offer-cancel-text" id="promo1_cancel_btn"><?= l('billing.cancel_sub_promo1_cancel_offer_title') ?></span>
                                </div>
                            </div>
                            <div class="col-0 col-md-4 vector-img-area">
                                <div class="vector-img-wrap">
                                    <img src="<?= ASSETS_FULL_URL . 'images/cancel-subcription/promo-vector.png' ?>" alt="" class="img-fluid">
                                </div>
                                <div class="offer-description d-none">
                                    <span class="offer-description-text"><?= l('billing.cancel_sub_promo1_offer_description_1') ?><b><?= l('billing.cancel_sub_promo1_offer_description_2') ?></b><?= l('billing.cancel_sub_promo1_offer_description_3') ?><b>[<?= $title  ?>]</b> <?= l('billing.cancel_sub_promo1_offer_description_4') ?><b>[<?= (new \DateTime($this->user->plan_expiration_date))->format('M d, Y') ?>],</b> <?= l('billing.cancel_sub_promo1_offer_description_5') ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="accept-offer-content offer-accept-wrap" style="display: none;">
                <input type="hidden" class="is_submit_payment">
                <div class="accept-img-wrap d-flex justify-content-center align-items-center">
                    <img src="<?= ASSETS_FULL_URL . 'images/cancel-subcription/check-mark.png' ?>" class="img-fluid" alt="">
                </div>
                <div class="accept-header-wrap">
                    <p class="accept-title text-center"><?= l('billing.cancel_sub_get_offer_title') ?></p>
                    <span class="accept-subtitle d-block text-center"><?= l('billing.cancel_sub_get_offer_subtitle') ?></span>
                </div>
                <div class="accept-bottom-full-wrap">
                    <div class="accept-bottom-wrap">
                        <button type="button" class="btn offer-accept-btn offer-accept"><?= l('billing.cancel_sub_get_offer_close') ?></button>
                    </div>
                </div>
            </div>
            <div class="promo1-modal-content promo-modal-content promo2" style="display: none;">
                <div class="promo-1-header-wrap pt-2">
                    <span class="d-block text-center promo-header-heading"><?= l('billing.cancel_sub_promo2_title') ?></span>
                    <span class="promo-header-subheading"><span><?= l('billing.cancel_sub_promo2_subtitle_1') ?><br class="d-block d-md-none"> </span><span class="bold-subheading"><?= l('billing.cancel_sub_promo2_subtitle_2') ?></span></span>
                    <span class="promo-header-subheading promo2-subheading-2">
                        <?= l('billing.cancel_sub_promo2_subtitle_3') ?>
                    </span>
                </div>
                <div class="promo-plan-wrap">
                    <div class="special-offer-wrap">
                        <div class="offer-icon-wrap">
                            <span class="discount-icon" translate="no">%</span>
                        </div>
                        <span class="offer-text ps-2"><?= l('billing.cancel_sub_promo2_offer_text') ?></span>
                    </div>
                    <div class="promo-plan-card">
                        <div class="plan-text-wrap">
                            <div class="plan-title-wrap">
                                <p class="plan-title <?= check_usd($code) ? '' : 'other-plan-title ' ?>"><?= $name ?></p>
                                <div class="plan-subtitle-wrap">
                                    <p class="plan-subtitle"><?= $subTitle ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="plan-price-wrap">
                            <p class="plan-full-price <?= check_usd($code) ? '' : 'other-offerfull-currency' ?>">
                                <?php if (check_usd($code) || get_user_currency($code)) : ?>
                                    <?= $symbol . custom_currency_format($monthlyPrice) ?>
                                <?php else : ?>
                                    <?php if ($countryCurrency) : ?>
                                        <?= $symbol ?>&nbsp;<?= custom_currency_format($monthlyPrice) ?>&nbsp;<?= $code  ?>
                                    <?php else : ?>
                                        <?= $symbol ?>&nbsp;<?= custom_currency_format($monthlyPrice * $rate) ?>&nbsp;<?= $code  ?>
                                    <?php endif  ?>
                                <?php endif ?>
                            </p>
                            <p class="plan-discount-price <?= check_usd($code) ? '' : 'other-offer-currency' ?>">
                                <?php
                                $monthlyDiscountPrice = $monthlyPrice - $monthlyPrice / 100 * 90;
                                ?>
                                <span translate="no">
                                    <?php if (check_usd($code) || get_user_currency($code)) : ?>
                                        <?= $symbol ?>&nbsp;<?= custom_currency_format($monthlyDiscountPrice) . ' /mo'  ?>
                                    <?php else : ?>
                                        <?php if ($countryCurrency) : ?>
                                            <?= $symbol ?>&nbsp;<?= custom_currency_format($monthlyDiscountPrice) ?> <?= $code  ?> /mo
                                        <?php else : ?>
                                            <?= $symbol ?>&nbsp;<?= custom_currency_format($monthlyDiscountPrice * $rate) ?> <?= $code  ?> /mo
                                        <?php endif  ?>
                                    <?php endif ?>
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row w-100 offer-description-wrap pt-4 m-auto d-block d-md-none">
                    <div class="col-12 d-block md-d-none">
                        <div class="offer-description">
                            <span class="offer-description-text"><?= l('billing.cancel_sub_promo2_offer_description_1') ?><b><?= l('billing.cancel_sub_promo2_offer_description_2') ?></b><?= l('billing.cancel_sub_promo2_offer_description_3') ?><b>90%</b><?= l('billing.cancel_sub_promo2_offer_description_4') ?><b>[<?= $title ?>]</b> <?= l('billing.cancel_sub_promo2_offer_description_5') ?><b>[
                                    <?php $discountPrice = discount_price($plan->plan_id, 90, $monthlyPrice); ?>
                                    <?php if (check_usd($code) || get_user_currency($code)) : ?>
                                        <?= $symbol ?>&nbsp;<?= custom_currency_format($discountPrice) ?>
                                    <?php else : ?>
                                        <?php if ($countryCurrency) : ?>
                                            <?= $symbol ?>&nbsp;<?= custom_currency_format($discountPrice) ?> <?= $code  ?>
                                        <?php else : ?>
                                            <?= $symbol ?>&nbsp;<?= custom_currency_format($discountPrice * $rate) ?> <?= $code  ?>
                                        <?php endif  ?>
                                    <?php endif ?> ]</b>, <?= l('billing.cancel_sub_promo2_offer_description_6') ?></span>
                        </div>
                    </div>
                </div>
                <div class="promo2-bottom-offer-full-wrap">
                    <div class="promo2-bottom-wrap">
                        <div class="promo2-offer-wrap row w-100 m-auto">
                            <div class="col-0 col-md-4 promo2-img-area">
                                <img src="<?= ASSETS_FULL_URL . 'images/cancel-subcription/promo2-vector.png' ?>" alt="" class="img-fluid">
                            </div>
                            <div class="col-12 col-md-8 d-flex justify-content-center align-items-center flex-column promo2-offer-area">
                                <div class="promo2-offer-btn-full-wrap">
                                    <p class="promo2-accept-offer-title text-center text-md-start"><?= l('billing.cancel_sub_promo2_offer_area_title_1') ?><span class="offer-heading-color"><?= l('billing.cancel_sub_promo2_offer_area_title_2') ?></span><?= l('billing.cancel_sub_promo2_offer_area_title_3') ?></p>
                                    <div class="promo2-btn-wrap">
                                        <button type="button" class="btn offer-submit-btn promo2-btn-offer" data-discount="90" data-suspend-payment="<?= isset($data->suspendsubcription) ? 'yes' : 'no' ?>" data-month-free="no">
                                            <span class="offer-submit-text"><?= l('billing.cancel_sub_promo1_accept_offer_title') ?></span>
                                            <div class="cancel-spinner"></div>
                                        </button>
                                    </div>
                                    <span class="offer-cancel-text text-center text-md-start" id="promo2_cancel_btn"><?= l('billing.cancel_sub_promo1_cancel_offer_title') ?></span>
                                </div>
                                <div class="promo2-offer-details">
                                    <span class="promo2-offer-text"><?= l('billing.cancel_sub_promo2_offer_description_1') ?><b><?= l('billing.cancel_sub_promo2_offer_description_2') ?></b><?= l('billing.cancel_sub_promo2_offer_description_3') ?><b>90%</b><?= l('billing.cancel_sub_promo2_offer_description_4') ?><b>[<?= $title ?>]</b> <?= l('billing.cancel_sub_promo2_offer_description_5') ?><b>[
                                            <?php $discountPrice =  discount_price($plan->plan_id, 90, $monthlyPrice) ?>
                                            <?php if (check_usd($code) || get_user_currency($code)) : ?>
                                                <?= $symbol ?>&nbsp;<?= custom_currency_format($discountPrice)   ?>
                                            <?php else : ?>
                                                <?php if ($countryCurrency) : ?>
                                                    <?= $symbol ?>&nbsp;<?= custom_currency_format($discountPrice) ?> <?= $code  ?>
                                                <?php else : ?>
                                                    <?= $symbol ?>&nbsp;<?= custom_currency_format($discountPrice * $rate) ?> <?= $code  ?>
                                                <?php endif  ?>
                                                <?php endif ?>]</b>, <?= l('billing.cancel_sub_promo2_offer_description_6') ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="promo1-modal-content promo-modal-content promo3" style="display: none;">
                <div class="promo-1-header-wrap pt-2">
                    <span class="d-block text-center promo-header-heading"><?= l('billing.cancel_sub_promo3_title') ?></span>
                    <span class="promo-header-subheading"><?= l('billing.cancel_sub_promo3_subtitle_1') ?><b><?= l('billing.cancel_sub_promo3_subtitle_2') ?></b><?= l('billing.cancel_sub_promo3_subtitle_3') ?></span>
                </div>
                <div class="promo-plan-wrap">
                    <div class="special-offer-wrap">
                        <div class="offer-icon-wrap">
                            <span class="discount-icon" translate="no">%</span>
                        </div>
                        <span class="offer-text ps-2"><?= l('billing.cancel_sub_promo3_offer_text') ?></span>
                    </div>
                    <div class="promo-plan-card">
                        <div class="plan-text-wrap">
                            <div class="plan-title-wrap">
                                <p class="plan-title <?= check_usd($code) ? '' : 'other-plan-title ' ?>"><?= $name ?><br><span class="promo3-sec-title"><?= l('billing.cancel_sub_promo3_offer_text_subtitle_1') ?> <?= $subTitle2 ?><?= l('billing.cancel_sub_promo3_offer_text_subtitle_2') ?></span></p>
                                <div class="plan-subtitle-wrap">
                                    <p class="plan-subtitle"><?= $subTitle ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="plan-price-wrap">
                            <p class="plan-full-price <?= check_usd($code) ? '' : 'other-offerfull-currency' ?>">
                                <?php if (check_usd($code) || get_user_currency($code)) : ?>
                                    <?= $symbol ?>&nbsp;<?= custom_currency_format($monthlyPrice) ?>
                                <?php else : ?>
                                    <?php if ($countryCurrency) : ?>
                                        <?= $symbol ?>&nbsp;<?= custom_currency_format($monthlyPrice) ?>&nbsp;<?= $code  ?>
                                    <?php else : ?>
                                        <?= $symbol ?>&nbsp;<?= custom_currency_format($monthlyPrice * $rate) ?>&nbsp;<?= $code  ?>
                                    <?php endif  ?>
                                <?php endif ?>
                            </p>
                            <p class="plan-discount-price <?= check_usd($code) ? '' : 'other-offer-currency' ?>">
                                <?php
                                $monthlyDiscountPrice = $monthlyPrice - $monthlyPrice / 100 * 90;
                                ?>
                                <span translate="no">

                                    <?php if (check_usd($code) || get_user_currency($code)) : ?>
                                        <?= $symbol ?>&nbsp;<?= custom_currency_format($monthlyDiscountPrice) . ' /mo'  ?>
                                    <?php else : ?>
                                        <?php if ($countryCurrency) : ?>
                                            <?= $symbol ?>&nbsp;<?= custom_currency_format($monthlyDiscountPrice) ?> <?= $code  ?> /mo
                                        <?php else : ?>
                                            <?= $symbol ?>&nbsp;<?= custom_currency_format($monthlyDiscountPrice * $rate) ?> <?= $code  ?> /mo
                                        <?php endif  ?>
                                    <?php endif ?>
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row w-100 offer-description-wrap pt-4 m-auto">
                    <div class="col-12 col-md-8">
                        <div class="offer-description">
                            <span class="offer-description-text"><?= l('billing.cancel_sub_promo3_offer_description_1') ?><b><?= l('billing.cancel_sub_promo3_offer_description_2') ?></b><?= l('billing.cancel_sub_promo3_offer_description_3') ?><b>[<?= $title ?>]</b>
                                <?= l('billing.cancel_sub_promo3_offer_description_4') ?><b><span class="d-inline-flex">
                                        <?php $discountPrice =  discount_price($plan->plan_id, 90, $monthlyPrice) ?>
                                        <?php if (check_usd($code) || get_user_currency($code)) : ?>
                                            [<?= $symbol ?>&nbsp;<?= custom_currency_format($discountPrice) ?>]
                                        <?php else : ?>
                                            <?php if ($countryCurrency) : ?>
                                                [<?= $symbol ?>&nbsp;<?= custom_currency_format($discountPrice) ?> <?= $code ?>]
                                            <?php else : ?>
                                                [<?= $symbol ?>&nbsp;<?= custom_currency_format($discountPrice * $rate) ?> <?= $code ?>]
                                            <?php endif  ?>
                                        <?php endif ?></span></b><?= l('billing.cancel_sub_promo3_offer_description_5') ?></span>
                        </div>
                    </div>
                    <div class="col-0 col-md-4"></div>
                </div>
                <div class="promo-bottom-offer-full-wrap">
                    <div class="promo-bottom-wrap">
                        <div class="promo-offer-wrap row w-100 m-auto">
                            <div class="col-12 col-md-8 offer-area">
                                <p class="offer-promo-text"><?= l('billing.cancel_sub_promo3_offer_area_title_1') ?><span class="promo-3-offer-text"><?= sprintf(l('billing.cancel_sub_promo3_offer_area_title_2'), $subTitle2) ?></span> <br class="d-none d-md-block"><?= l('billing.cancel_sub_promo3_offer_area_title_3') ?></p>
                                <div class="offer-btn-wrap pt-2">
                                    <button type="button" class="btn offer-submit-btn btn-offer promo3-btn-offer" data-suspend-payment="<?= isset($data->suspendsubcription) ? 'yes' : 'no' ?>" data-discount="90" data-month-free="yes">
                                        <span class="offer-submit-text"><?= l('billing.cancel_sub_promo1_accept_offer_title') ?></span>
                                        <div class="cancel-spinner"></div>
                                    </button>
                                </div>
                                <div class="offer-cancel-wrap">
                                    <span class="offer-cancel-text" id="last_promo_cancel_btn"><?= l('billing.cancel_sub_promo3_offer_cancel_title') ?></span>
                                </div>
                            </div>
                            <div class="col-0 col-md-4 vector-img-area">
                                <div class="vector-img-wrap">
                                    <img src="<?= ASSETS_FULL_URL . 'images/cancel-subcription/promo3-vector.png' ?>" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="promo1-modal-content promo-modal-content payment-method" style="display: none;">
                <input type="hidden" class="is_open-promo">
                <div class="payment-method-header-wrap">
                    <span class="d-block text-center promo-header-heading"><?= l('billing.cancel_delinquent_offer.title') ?></span>
                </div>
                <div class="payment-method-subheader-wrap p-3">
                    <span class="payment-method-subheading d-block text-center"></span>
                </div>
                <div class="promo-plan-wrap p-3 pt-0">
                    <div class="payment-details-wrap">
                        <div class="payment-details d-flex flex-column">
                            <div class="sub-update-wrap d-flex w-100 justify-content-between">
                                <div class="sub-update-heading py-2 ms-3">
                                    <p class="sub-update-header sub-update"></p>
                                </div>
                                <div class="sub-update-plan-heading py-2">
                                    <p class="sub-update-plan sub_update_plan"></p>
                                </div>
                            </div>
                            <div class="due-payment-wrap d-flex w-100 justify-content-between">
                                <div class="due-payment-heading py-2 ms-3">
                                    <p class="sub-update-header amount_due"></p>
                                </div>
                                <div class="due-payment-price py-2">
                                    <p class="sub-update-plan due_payment_price"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="cardupdate-detail-window ">
                        <form id="payment-form-2" class="payment-form">
                            <input type="hidden" name="discount" id="discount">
                            <input type="hidden" name="month_free" id="month_free">
                            <input type="hidden" name="client_secret" id="client_secret">
                            <div class="content-wrp">
                                <div class="row">
                                    <div class="payment-form-content">
                                        <div class="card-detail-form-wrap">
                                            <div id="payment-element-2">
                                                <!--Stripe.js injects the Payment Element-->
                                            </div>
                                            <div id="payment-message-2" style="color:red; font-weight:700" class="hidden payment-message"></div>
                                        </div>
                                    </div>
                                    <hr class="payment-hr">
                                    <div class="col-md-12 col-12 d-flex buttons-wrp">
                                        <div class="row w-100 justify-content-md-end justify-content-center m-auto">
                                            <div class="col-md col-sm-3 col-6">
                                                <button class="btn w-100 outline-btn cancel-update-back" type="button">
                                                    <span class="text "><?= l('billing.back') ?></span>
                                                </button>
                                            </div>
                                            <div class="col-md col-sm-3 col-6">
                                                <button class="btn w-100 primary-btn  update-btn" id="submit-2" type="submit" disabled>
                                                    <div class="cancel-spinner"></div>
                                                    <span class="text button-text" id="button-text-2"><?= l('billing.update') ?></span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="payment-hr d-none d-sm-block">
                                    <div id="card-errors-2" style="color:red" class="card-errors" role="alert"></div>
                                    <div id="payment-message-2" style="color:red" class="hidden payment-message"></div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(".promo1-offer-btn").on("click", function() {
        $('.is_open-promo').val('1');
    });

    $(".promo3-btn-offer").on("click", function() {
        $('.is_open-promo').val('2');
    });

    $(".cancel-update-back").on("click", function() {

        $.ajax({
            type: 'POST',
            url: '<?php echo url('api/ajax_new') ?>',
            data: {
                user_id: user_id,
                action: 'unset_delinquent_session',
            },
            success: function(response) {}
        });

        $("#submit-2").prop("disabled", false);
        $(".payment-method-subheading").removeClass("promo70subheading");
        var isCancelPromoNo = $('.is_open-promo').val();
        if (isCancelPromoNo == '1') {
            $(".payment-method").fadeIn().hide().removeClass("show");
            $(".promo1").fadeIn().show().addClass("show");
            $('.is_open-promo').val('');
            disableLoader();
        } else if (isCancelPromoNo == '2') {
            $(".payment-method").fadeIn().hide().removeClass("show");
            $(".promo3").fadeIn().show().addClass("show");
            $('.is_open-promo').val('');
            disableLoader();
        }
    });

    $(document).on('click', '.feedback-modal-close', function() {
        $("#cancelSubscriptionModal").css({
            'display': 'none'
        });
        $(".modal-backdrop").remove();
        $("#feedbackModal").hide();
        $(".feedback-radio").prop('checked', false);
        promo1Close();
        $(".feedback-modal-content").show();
        $("#feedbackModal").removeClass("show");
        $("#cancelSubscriptionModal").removeClass("show");
        $("#cancelSubscriptionModal").removeAttr("aria-modal role");
        $("#cancelSubscriptionModal").attr("aria-hidden", "true");
        $(".accept-offer-content").hide().removeClass("show");
        $(".cancel-sub").trigger("click");
        $("#feedback_type , #customFeedback").val('');
        $('.is_open-promo').val('');
        $('.is_submit_payment').val('');
        $(".payment-method-subheading").removeClass("promo70subheading");
        disableLoader();

        // clear delinquent session 
        $.ajax({
            type: 'POST',
            url: '<?php echo url('api/ajax_new') ?>',
            data: {
                user_id: user_id,
                action: 'unset_delinquent_session',
            },
            success: function(response) {}
        });

    });

    function disableLoader() {
        $('.offer-submit-text').css({
            'visibility': 'visible'
        });
        $('.cancel-spinner').css({
            'display': 'none'
        });
        $(".offer-submit-btn").prop("disabled", false);
    }



    $(document).on('click', '.feedback-card-full-wrap', function() {
        $(this).children(".feedback-card-wrap").children(".feedback-radio-btn-wrap").children(".feedback-radio").prop('checked', true);
    });

    function getCharacters(callback) {
        $(document).on('input', '#customFeedback', function() {
            var characters = $("#customFeedback").val();
            const characterCount = characters.replace(/\s/g, '').length;
            if (callback) {
                callback(characterCount);
            }
        });
    }

    function enableContinueOneCharacter() {
        getCharacters(function(characterCount) {
            if (characterCount > 0) {
                $(".feedback-submit-btn").prop('disabled', false);
            } else {
                $(".feedback-submit-btn").prop('disabled', true);
            }
        });
    }

    function enableContinueTenCharacter() {
        getCharacters(function(characterCount) {
            if (characterCount > 9) {
                $(".feedback-submit-btn").prop('disabled', false);
            } else {
                $(".feedback-submit-btn").prop('disabled', true);
            }
        });
    }

    $(document).ready(function() {
        $(".feedback-text-area-header").hide();
        $(".text-area-wrap").hide();
    });

    $(document).on('click', '.feedback-card-full-wrap', function() {
        var feedbackType = $(this).children(".feedback-card-wrap").children(".feedback-radio-btn-wrap").children('.feedback-radio[name="fd-radio"]:checked').val();

        $(".feedback-submit-btn").prop('disabled', true);
        $("#customFeedback").prop('disabled', true);
        $("#feedback_type").val('');

        if (feedbackType == 'no_need_qr' || feedbackType == 'enough_platform' || feedbackType == 'platform_expensive') {
            $(".feedback-text-area-title").html("<?= str_replace("'", "\'", l('billing.cancel_sub_feedback_textarea_title')) ?>");
            $(".feedback-submit-btn").prop('disabled', false);
            $(".feedback-text-area-header").hide();
            $(".text-area-wrap").hide();
        } else if (feedbackType == 'another_platform') {
            $(".feedback-text-area-title").html("<?= str_replace("'", "\'", l('billing.cancel_sub_feedback_textarea_title_1')) ?>");
            $("#customFeedback").prop('disabled', false);
            $(".feedback-text-area-header").show();
            $(".text-area-wrap").show();
            $("#customFeedback").val('');
            enableContinueOneCharacter();
        } else if (feedbackType == 'missing_feature') {
            $(".feedback-text-area-title").html("<?= str_replace("'", "\'", l('billing.cancel_sub_feedback_textarea_title_2')) ?>");
            $("#customFeedback").prop('disabled', false);
            $(".feedback-text-area-header").show();
            $(".text-area-wrap").show();
            $("#customFeedback").val('');
            enableContinueOneCharacter();
        } else if (feedbackType == 'defficulties_platform') {
            $(".feedback-text-area-title").html("<?= str_replace("'", "\'", l('billing.cancel_sub_feedback_textarea_title_3')) ?>");
            $("#customFeedback").prop('disabled', false);
            $(".feedback-text-area-header").show();
            $(".text-area-wrap").show();
            $("#customFeedback").val('');
            enableContinueOneCharacter();
            $("#feedback_type").val('defficulties_platform');
        } else if (feedbackType == 'other') {
            $(".feedback-text-area-title").html("<?= str_replace("'", "\'", l('billing.cancel_sub_feedback_textarea_title')) ?>");
            $("#customFeedback").prop('disabled', false);
            $(".feedback-text-area-header").show();
            $(".text-area-wrap").show();
            $("#customFeedback").val('');
            enableContinueOneCharacter();
        }
    });

    $(document).on('click', '.feedback-submit-btn', function() {

        var feedbackType = $("input[name='fd-radio']:checked").val();
        var customFeedback = $("#customFeedback").val();
        var user_id = '<?php echo $this->user->user_id ?>';

        document.cookie = 'feedback_type=' + feedbackType;

        // Zenddesk feedback message
        if (feedbackType == 'defficulties_platform' || feedbackType == 'missing_feature' || feedbackType == 'other' || feedbackType == 'another_platform') {

            $.ajax({
                type: 'POST',
                url: '<?php echo url('api/ajax_new') ?>',
                data: {
                    user_id: user_id,
                    feedbackType: feedbackType,
                    customFeedback: customFeedback,
                    action: 'feedback_zendesk',
                },
                success: function(response) {}
            });
        }
        $(".feedback-modal-content").hide();

        <?php if ($promo_70 || $this->user->cancel_promo == 1) : ?>
            $(".promo1").fadeIn().hide().removeClass("show");
            $(".promo3").fadeIn().show().addClass("show");
            $("modal-content").addClass("promo-modal-content-wrap");
            $(".feedback-modal-dialog").addClass("promo1-modal-dialog");
        <?php elseif ($this->user->cancel_promo == 2) : ?>
            $(".promo1").fadeIn().hide().removeClass("show");
            $(".promo2").fadeIn().hide().removeClass("show");
            $(".promo3").fadeIn().show().addClass("show");
            $("modal-content").addClass("promo-modal-content-wrap");
            $(".feedback-modal-dialog").addClass("promo1-modal-dialog");
        <?php else : ?>
            $(".promo1").fadeIn().show().addClass("show");
            if ($(".promo1-modal-content").hasClass("show")) {
                $(".feedback-modal-dialog").addClass("promo1-modal-dialog");
                $("modal-content").addClass("promo-modal-content-wrap");
                var isDifficulties = $("#feedback_type").val();
                if (isDifficulties == 'defficulties_platform') {
                    $(".promo1").addClass("isDifficulties");
                    $(".promo1 .promo-header-heading").html("<?= str_replace("'", "\'", l('billing.cancel_sub_promo4_title')) ?>");
                    $(".promo1 .promo1-subheading1").html("<?= str_replace("'", "\'", l('billing.cancel_sub_promo4_subtitle_1')) ?>");
                    $(".promo1 .promo1-subheading2").html("<?= str_replace("'", "\'", l('billing.cancel_sub_promo4_subtitle_2')) ?>");
                } else {
                    $(".promo1").removeClass("isDifficulties");
                    $(".promo1 .promo-header-heading").html("<?= str_replace("'", "\'", l('billing.cancel_sub_promo1_title')) ?>");
                    $(".promo1 .promo1-subheading1").remove();
                    $(".promo1 .promo1-subheading2").html("<?= str_replace("'", "\'", l('billing.cancel_sub_promo1_subtitle_2')) ?>");
                }
            } else {
                $(".feedback-modal-dialog").removeClass("promo1-modal-dialog");
            }
        <?php endif ?>
    });


    $(document).on('click', '.offer-accept', function() {
        $('.feedback-modal-close').each(function() {
            $(this).triggerHandler('click');

            // clear delinquent session 
            $.ajax({
                type: 'POST',
                url: '<?php echo url('api/ajax_new') ?>',
                data: {
                    user_id: user_id,
                    action: 'unset_delinquent_session',
                },
                success: function(response) {}
            });

        });
        location.reload();

    });

    $(document).on('click', '.accept-offer-cancel', function() {
        $('.feedback-modal-close').each(function() {
            $(this).triggerHandler('click');

            // clear delinquent session 
            $.ajax({
                type: 'POST',
                url: '<?php echo url('api/ajax_new') ?>',
                data: {
                    user_id: user_id,
                    action: 'unset_delinquent_session',
                },
                success: function(response) {}
            });

        });
        location.reload();

    });

    $(document).on('click', '#promo1_cancel_btn', function() {
        $(".promo1").fadeIn().hide().removeClass("show");
        $(".promo3").fadeIn().show().addClass("show");
    });

    $(document).on('click', '#promo2_cancel_btn', function() {
        $(".promo2").fadeIn().hide().removeClass("show");
        $(".promo3").fadeIn().show().addClass("show");
    });

    $(document).on('click', '#last_promo_cancel_btn', function() {
        $(".feedback-modal-close").trigger("click");
        // $(".cancel-confirm-btn").trigger("click");
        window.location.replace('<?= url('billing/cancel_subscription?cancel_promo=4'. Altum\Middlewares\Csrf::get_url_query())  ?>')
        
    });

    function promo1Close() {
        $(".promo1-modal-content").hide().removeClass("show");
        $(".feedback-modal-dialog").removeClass("promo1-modal-dialog");
    }

    function promo2Close() {
        $(".promo2").hide().removeClass("show");
        $(".feedback-modal-dialog").removeClass("promo1-modal-dialog");
    }

    function promo3Close() {
        $(".promo3").hide().removeClass("show");
        $(".feedback-modal-dialog").removeClass("promo1-modal-dialog");
    }

    var user_id = '<?php echo $this->user->user_id ?>';
    var plan_id = '<?php echo $plan->plan_id ?>';
    var price_id = '<?php echo $priceId ?>';
    var email = "<?php echo isset($this->user->billing->email) ? $this->user->billing->email : $this->user->email; ?>";
    var country = "<?php echo $this->user->billing->country ? $this->user->billing->country : $this->user->country; ?>";

    // Accept promotion
    $(document).on('click', ".offer-submit-btn", function() {

        var feedback_type = $("input[name='fd-radio']:checked").val();
        var discount = $(this).data('discount');
        var month_free = $(this).data('month-free');
        var suspend_payment = $(this).data('suspend-payment');

        $('#discount').val(discount);
        $('#month_free').val(month_free);

        $('.offer-submit-text').css({
            'visibility': 'hidden'
        });
        $('.cancel-spinner').css({
            'display': 'block'
        });
        $(".offer-submit-btn").prop("disabled", true);

        if (suspend_payment === 'yes') {
            var client_secret = null;
            var data_value = {
                'user_id': user_id,
                'plan_id': plan_id,
                'price_id': price_id,
                'discount': discount,
                'month_free': month_free,
                'action': 'create_client_secret'
            }

            create_client_secret(data_value);

            if (discount == 70) {
                $(".payment-method-subheading").html("<?= str_replace("'", "\'", l('billing.cancel_delinquent_offer.desciption_70')) ?>");
                $(".sub-update").html("<?= str_replace("'", "\'", l('billing.cancel_delinquent_offer.sub_update_header_70')) ?>");
                $(".sub_update_plan").html("<?= str_replace("'", "\'", l('billing.cancel_delinquent_offer.sub_update_plan_70')) ?>");
                $(".amount_due").html("<?= str_replace("'", "\'", l('billing.cancel_delinquent_offer.sub_amount_70')) ?>");

                <?= $discountPrice =  discount_price($plan->plan_id, 70, $monthlyPrice) ?>

                $(".due_payment_price").html("<?= check_usd($code) || get_user_currency($code) ? $symbol . ' ' . custom_currency_format($discountPrice)   : ($countryCurrency ? $symbol . ' ' .  custom_currency_format($discountPrice)  . ' ' . $code : $symbol . ' ' . custom_currency_format($discountPrice * $rate) . ' ' . $code)  ?>");
            } else {
                $(".payment-method-subheading").html("<?= str_replace("'", "\'", l('billing.cancel_delinquent_offer.desciption_90')) ?>");
                $(".sub-update").html("<?= str_replace("'", "\'", l('billing.cancel_delinquent_offer.sub_update_header_90')) ?>");
                $(".sub_update_plan").html("<?= str_replace("'", "\'", l('billing.cancel_delinquent_offer.sub_update_plan_90')) ?>");
                $(".amount_due").html("<?= str_replace("'", "\'", l('billing.cancel_delinquent_offer.sub_amount_90')) ?>");

                <?= $discountPrice =  discount_price($plan->plan_id, 90, $monthlyPrice) ?>


                $(".due_payment_price").html("<?= check_usd($code) || get_user_currency($code) ? $symbol . ' ' . custom_currency_format($discountPrice)   : ($countryCurrency ? $symbol . ' ' .  custom_currency_format($discountPrice)  . ' ' . $code : $symbol . ' ' . custom_currency_format($discountPrice * $rate) . ' ' . $code)  ?>");

            }
            $(".promo1-modal-content").hide().removeClass("show");
            $(".payment-method").fadeIn().show().addClass("show");
            addClassPaySubheading();
            $('#button-text-2').css({
                'visibility': 'visible'
            });
            $('.cancel-spinner').css({
                'display': 'none'
            });
            // $("#submit-2").prop("disabled", false);
        } else {
            $.ajax({
                type: 'POST',
                url: '<?php echo url('api/ajax_new') ?>',
                data: {
                    user_id: user_id,
                    discount: discount,
                    plan_id: plan_id,
                    price_id: price_id,
                    month_free: month_free,
                    feedback_type: feedback_type,
                    action: 'cancel_subscription_promo',
                },
                success: function(response) {
                    $('.offer-submit-text').css({
                        'visibility': 'unset'
                    });
                    $('.cancel-spinner').css({
                        'display': 'none'
                    });
                    $(".offer-submit-btn").prop("disabled", false);
                    promo1Close();
                    promo2Close();
                    promo3Close();
                    $(".accept-offer-content").fadeIn().show().addClass("show");
                    addClassOfferAccept();
                },
                error: function(e) {
                    show_alert('error', e.responseJSON?.errors?.error);
                }
            });
        }
    });

    function addClassPaySubheading() {
        var getCancelPromoNo = $('.is_open-promo').val();
        if (getCancelPromoNo == '1') {
            $(".payment-method-subheading").addClass("promo70subheading");
        }
    }

    function addClassOfferAccept() {
        if ($(".accept-offer-content").hasClass("offer-accept-wrap")) {
            $(".feedback-modal-close").addClass("accept-offer-cancel");
        } else {
            $(".feedback-modal-close").removeClass("accept-offer-cancel");
        }
    }


    function create_client_secret(value) {

        formData = new FormData();
        formData.append('user_id', value.user_id);
        formData.append('plan_id', value.plan_id);
        formData.append('price_id', value.price_id);
        formData.append('discount', value.discount);
        formData.append('month_free', value.month_free);
        formData.append('action', 'create_client_secret');

        $.ajax({
            type: 'POST',
            method: 'post',
            url: '<?= url('api/ajax_new') ?>',
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function(response) {
                const stripe_2 = Stripe('<?php echo settings()->stripe->publishable_key ?>', {
                    locale: '<?= $userLanguageCode ?>',
                });

                const elements_2 = stripe_2.elements({
                    clientSecret: response.data.clientSecret
                });

                const paymentElementOptions_2 = {
                    layout: {
                        type: 'tabs',
                        defaultCollapsed: false,
                    },
                };
                var subscriptionId = response.data.subscriptionId;
                const paymentElement_2 = elements_2.create("payment", paymentElementOptions_2);
                paymentElement_2.mount("#payment-element-2");

                const form_2 = document.getElementById('payment-form-2');

                paymentElement_2.on('focus', function(event) {
                    $("#submit-2").prop("disabled", false);
                });

                const confirmIntent = response.data.type === "setup" ? stripe_2.confirmSetup : stripe_2.confirmPayment;

                form_2.addEventListener('submit', async (e) => {

                    var feedback_type = $("input[name='fd-radio']:checked").val();
                    var discount = $("#discount").val();
                    var month_free = $("#month_free").val();

                    e.preventDefault();
                    $('.update-btn').prop('disabled', true);

                    confirmIntent({
                        elements: elements_2,
                        confirmParams: {
                            payment_method_data: {
                                billing_details: {
                                    email: email,
                                    address: {
                                        country: country,
                                    }
                                }
                            },
                        },
                        redirect: "if_required",
                    }).then(function(result) {
                        $('.update-btn').prop('disabled', false);
                        if (result.error) {
                            if (result.error.type === "card_error" || result.error.type === "validation_error") {
                                showErrorMessage(result.error.message);
                            } else {
                                showErrorMessage("An unexpected error occurred.");
                            }
                            setLoading(false);
                        } else if (result.paymentIntent && result.paymentIntent.status === "succeeded") {
                            $('.update-btn').prop('disabled', false);
                            updateSubscriptionWithCard(result.paymentIntent.id, value.plan_id, value.user_id, discount, month_free, subscriptionId);
                            $('#button-text-2').css({
                                'visibility': 'hidden'
                            });
                            $('.cancel-spinner').css({
                                'display': 'block'
                            });
                            $("#submit-2").prop("disabled", true);
                        } else if (result.setupIntent && result.setupIntent.status === "succeeded") {
                            $('.update-btn').prop('disabled', false);
                            updateSubscriptionWithCard(result.setupIntent.id, value.plan_id, value.user_id, discount, month_free, subscriptionId);
                            $('#button-text-2').css({
                                'visibility': 'hidden'
                            });
                            $('.cancel-spinner').css({
                                'display': 'block'
                            });
                            $("#submit-2").prop("disabled", true);
                        } else {
                            showErrorMessage("An unexpected error occurred.");
                            setLoading(false);
                        }
                    });

                });


            },
            error: function(e) {
                show_alert('error', e.responseJSON?.errors?.error);
            }
        });

    }


    function showErrorMessage(messageText) {

        const messageContainer = document.querySelector("#payment-message-2");

        messageContainer.classList.remove("hidden");
        messageContainer.textContent = messageText;

        setTimeout(function() {
            messageContainer.classList.add("hidden");
            messageText.textContent = "";
        }, 4000);
    }

    // Show a spinner on payment submission
    function setLoading(isLoading) {
        if (isLoading) {
            // Disable the button and show a spinner
            document.querySelector("#submit-2").disabled = true;
            document.querySelector("#spinner-2").classList.remove("hidden");
            document.querySelector("#button-text-2").classList.add("hidden");
        } else {
            document.querySelector("#submit-2").disabled = false;
            document.querySelector("#spinner-2").classList.add("hidden");
            document.querySelector("#button-text-2").classList.remove("hidden");
        }
    }

    function updateSubscriptionWithCard(setup_intent, plan_id, user_id, discount, monthFree, subscriptionId) {
        formData = new FormData();
        formData.append('plan_id', plan_id);
        formData.append('user_id', user_id);
        formData.append('discount', discount);
        formData.append('new_subscription_id', subscriptionId);
        formData.append('subId', "<?= isset($delinquentSubscriptionId) ? $delinquentSubscriptionId : null ?>");
        formData.append('month_free', monthFree);
        formData.append('setup_intent', setup_intent);
        formData.append('action', 'cancel_popup_delinquent_user');

        $.ajax({
            type: 'POST',
            method: 'post',
            url: '<?= url('api/ajax_new') ?>',
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function(response) {
                $('.offer-submit-text').css({
                    'visibility': 'unset'
                });
                $('.cancel-spinner').css({
                    'display': 'none'
                });
                $(".offer-submit-btn").prop("disabled", false);
                promo1Close();
                promo2Close();
                promo3Close();
                $(".accept-offer-content").fadeIn().show().addClass("show");
                $('.is_submit_payment').val('1');
                changeTextOfferAccept();
                addClassOfferAccept();
            },
            error: function(e) {
                showErrorMessage("An unexpected error occurred.");
            }
        });
    }

    function changeTextOfferAccept() {
        var isPayementSubmit = $(".is_submit_payment").val();
        if (isPayementSubmit == "1") {
            $(".accept-subtitle").html("<?= str_replace("'", "\'", l('billing.cancel_sub_get_offer_submit_payment_subtitle')) ?>");
        }
    }
</script>