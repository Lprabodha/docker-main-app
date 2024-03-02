<?php defined('ALTUMCODE') || die() ?>

<?php

use Altum\Alerts;


if (!$data->suspendsubcription && !$data->clientSecret) {
    if ($this->user->plan_id != 8 && $this->user->plan_id != 5) {
        try {
            $stripe = new \Stripe\StripeClient(settings()->stripe->secret_key);
            try {
                $intents = $stripe->setupIntents->create([
                    'customer' => $this->user->stripe_customer_id,
                    'payment_method_types' => ['card'],
                ]);
                $clientSecret = $intents->client_secret;
            } catch (Exception $e) {
                Alerts::add_error(l('billing.plan_error_customer_details'));
                $clientSecret = null;
            }
        } catch (Exception $e) {
            Alerts::add_error(l('billing.plan_error_payment_gateway'));
        }
    }
} else {
    $clientSecret = $data->clientSecret;
}



$paymentDays           =  null;
$isPlanExpire          = (new DateTime($this->user->plan_expiration_date) < new DateTime()) ? true : false;
$userFirstPurchase     = analyticsDatabase()->query("SELECT * FROM `subscription_users` WHERE `user_id` = {$this->user->user_id} AND  `subscription_change` != 'purchase' ORDER BY `id` ASC LIMIT 1")->fetch_object();


if ($userFirstPurchase) {
    $paymentDays = (new \DateTime($userFirstPurchase->change_date))->diff((new \DateTime()))->days;
}

if ($data->upcomingDiscount) {

    switch ($data->upcomingDiscount->coupon->id) {
        case 'PROMO_70OFF_MONTH_FOREVER':
            $promoCode =  '70% ' . l('billing.promo_off');
            break;
        case 'PROMO_90OFF_MONTH_FOREVER':
            $promoCode =  '90% ' . l('billing.promo_off');
            break;
    }
}

?>



<div class=" my-account my-account-wrp container-fluid billing-page space-block">
    <?= \Altum\Alerts::output_alerts() ?>
    <div class="accountTabbing">
        <div class="row billing-info-title">
            <h1 class="mb-2 heading ms-1"><?= l('billing.header') ?></h1>
        </div>

        <?= isset($data->planExpireBannerHtml)  ? $data->planExpireBannerHtml : '' ?>

        <div class="tab-content" id="myTabContent">
            <div class="myaccount-nav">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item active_item border_style border_round not_active" id="active_link" role="presentation">
                        <button class="navLinkBtn active " id="generalInfo-tab" data-toggle="tab" data-target="#generalInfo" type="button" role="tab" aria-controls="generalInfo" aria-selected="true"><span class="desktop-nav-bt"><?= l('billing.subscription') ?></span></button>
                    </li>
                    <li class="nav-item border_style border_round" id="nav2" role="presentation">
                        <button class="navLinkBtn " id="taxInfo-tab" data-toggle="tab" data-target="#taxInfo" type="button" role="tab" aria-controls="taxInfo" aria-selected="false">
                            <span class="desktop-nav-bt"><?= l('billing.history') ?></button>
                    </li>

                </ul>
            </div>
            <div class="tab-pane fade show active" id="generalInfo" role="tabpanel" aria-labelledby="generalInfo-tab">
                <div class="accountCardDetail tax-full-wrap">
                    <div class="accountCardDetailRow subscription-tab-wrp d-flex align-items-start">
                        <div class="container-fluid fullCard rounded ">
                            <div class="card-sub-detail-window">
                                <div class="plan-title-wrp">
                                    <div class="row">
                                        <div class="col plan-name-wrp">
                                            <div class="plan-name">
                                                <h1 class="heading "><?= l('billing.plan.header') ?></h1>
                                            </div>
                                        </div>
                                        <div class="col active-plan-wrp">
                                            <?php if (new DateTime($this->user->plan_expiration_date) < new DateTime()) : ?>
                                                <div class="active-plan expired">
                                                    <span class="">
                                                        <?= l('billing.expired') ?>
                                                    </span>
                                                </div>
                                            <?php else : ?>
                                                <div class="active-plan active">
                                                    <span class="">
                                                        <?= l('billing.active') ?>
                                                    </span>
                                                </div>

                                            <?php endif ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="plan-content-wrp mt-4 mb-4">
                                    <div class="row subscription">
                                        <div class="col content-title">
                                            <span><?= l('billing.subscription') ?></span>
                                        </div>
                                        <div class="col content-description">
                                            <?php if ($this->user->plan_id == 'free') : ?>
                                                <span><?= l('billing.subscription.suspend')?></span>
                                            <?php else : ?>
                                                <span><?= l('billing.plan_' . $this->user->plan->name) ?></span>
                                            <?php endif ?>

                                        </div>
                                    </div>

                                    <?php if ($this->user->plan_id != 8) : ?>
                                        <div class="row validity">
                                            <div class="col content-title">
                                                <span><?= l('billing.valid_until') ?></span>
                                            </div>
                                            <div class="col content-description">
                                                <?php if ($this->user->plan_id == 5) : ?>
                                                    <span><?= l('pay_custom_plan.summary.lifetime') ?></span>
                                                <?php else : ?>
                                                    <span><?= (new \DateTime($this->user->plan_expiration_date))->setTimezone(new \DateTimeZone($this->user->timezone))->format('M d, Y') ?></span>

                                                <?php endif ?>
                                                <div class="tooltip"></div>
                                            </div>
                                        </div>
                                    <?php endif ?>

                                    <?php if ($data->newPlanName ) : ?>
                                        <div class="row validity">
                                            <div class="col content-title">
                                                <span><?= l('billing.next_subscription') ?></span>
                                            </div>
                                            <div class="col content-description">
                                                <?php if ($data->upcomingDiscount) : ?>
                                                    <span> (<?= (new \DateTime($data->start_date))->setTimezone(new \DateTimeZone($this->user->timezone))->format('M d, Y') ?>) <?= $data->newPlanName ?> <?= $promoCode ?> </span>

                                                <?php else : ?>
                                                    <span><?= $data->newPlanName ?> (<?= (new \DateTime($data->start_date))->setTimezone(new \DateTimeZone($this->user->timezone))->format('M d, Y') ?>) </span>
                                                <?php endif ?>
                                                <div class="tooltip"></div>
                                            </div>
                                        </div>
                                    <?php endif ?>

                                    <?php if ($data->reactivePlanName && $this->user->plan_id != 8) : ?>
                                        <div class="row validity">
                                            <div class="col content-title">
                                                <span><?= l('billing.next_subscription') ?></span>
                                            </div>
                                            <div class="col content-description">
                                                <span><?= $data->reactivePlanName ?> (<?= (new \DateTime($data->start_date))->setTimezone(new \DateTimeZone($this->user->timezone))->format('M d, Y') ?>) </span>
                                                <div class="tooltip"></div>
                                            </div>
                                        </div>
                                    <?php endif ?>
                                    <?php if (($this->user->payment_subscription_id || isset($this->user->subscription_schedule_id) || $data->suspendsubcription) || ($this->user->payment_subscription_id == 'onetime' && $this->user->subscription_schedule_id)) : ?>
                                        <?php if ($this->user->plan_id != 8) : ?>
                                            <div class="row payment-method">
                                                <div class="col content-title">
                                                    <div class="d-flex align-items-center">
                                                        <span><?= l('billing.payment_method') ?></span>
                                                    </div>
                                                </div>
                                                <div class="col content-description ">
                                                    <div class="d-flex align-items-center">
                                                        <div class="">
                                                            <span><span class="card-type"><?= ucfirst($data->card) ?></span>
                                                        </div>                                                        
                                                        <?php if ($this->user->payment_subscription_id != 'onetime' && ($this->user->payment_subscription_id != null || $this->user->subscription_schedule_id != null) && !$isPlanExpire) : ?>
                                                            <button class="btn ms-2 p-0 pay-method-update d-inline updatePayment-btn" id="updateMethod"><?= l('billing.update') ?></button>
                                                        <?php endif ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif ?>
                                    <?php endif ?>
                                </div>
                                <?php if (($this->user->payment_subscription_id || $this->user->subscription_schedule_id) && $this->user->plan_id != 5 && $this->user->plan_id != 8 && !$data->suspendsubcription) : ?>

                                    <div class="plan-update-options-wrp">
                                        <?php if (!$data->newPlanName && !$data->reactivePlanName) : ?>
                                            <a href="<?= url('plan/upgrade') ?>">
                                                <button type="button" class="btn plan-update change-plan  p-0" id="changePlan"><?= l('billing.change_plan') ?><span class="icon-arrow-right ms-2"></span></button>
                                            </a>
                                        <?php endif; ?>

                                        <?php if ($this->user->payment_subscription_id != 'onetime' || ($this->user->payment_subscription_id == 'onetime' && $this->user->subscription_schedule_id)) : ?>
                                            <button type="button" class="btn plan-update cancel-sub  p-0" data-toggle="modal" data-target="#cancelSubscriptionModal" id="cancelSub"><?= l('billing.cancel_subscription') ?><span class="icon-arrow-right ms-2"></span></button>
                                            <a href="<?= url('billing/cancel_subscription' . Altum\Middlewares\Csrf::get_url_query()) ?>" class="cancel-sub-url d-none"><button class="btn primary-btn r-4 confirm-btn cancel-confirm-btn" name="qr_status_paused"><?= l('billing.confirm') ?></button></a>

                                        <?php endif; ?>
                                    </div>
                                <?php elseif ($data->suspendsubcription) : ?>
                                    <div class="plan-update-options-wrp">
                                        <button type="button" class="btn plan-update cancel-sub  p-0" data-toggle="modal" data-target="#cancelSubscriptionModal" id="cancelSub"><?= l('billing.cancel_subscription') ?><span class="icon-arrow-right ms-2"></span></button>
                                        <a href="<?= url('billing/cancel_subscription' . Altum\Middlewares\Csrf::get_url_query()) ?>" class="cancel-sub-url d-none"><button class="btn primary-btn r-4 confirm-btn cancel-confirm-btn" name="qr_status_paused"><?= l('billing.confirm') ?></button></a>

                                    </div>
                                <?php endif; ?>

                                <?php if (new DateTime($this->user->plan_expiration_date) < new DateTime() || !$this->user->payment_subscription_id && !$data->reactivePlanName || (($this->user->plan_id  == 7  || $this->user->plan_id  == 6) && $this->user->payment_subscription_id == 'onetime' && !$this->user->subscription_schedule_id)) : ?>
                                    <?php if ($this->user->plan_id != 8 && $this->user->plan_id != 5) : ?>
                                        <div class="row subscription-status-banner-wrp">
                                            <?php if ($data->suspendsubcription) : ?>
                                                <div class="content-wrp">
                                                    <div class="text-content">
                                                        <h1><?= l('billing.suspend_subscription') ?></h1>
                                                        <p><?= l('billing.suspend_subscription_description') ?></p>
                                                    </div>
                                                    <div class="button-wrp">

                                                        <button class="btn w-100 primary-btn  updatePayment-btn" name="send_to_modal">
                                                            <span class="text "><?= l('billing.update_card') ?></span>
                                                        </button>

                                                    </div>

                                                </div>
                                            <?php elseif ($this->user->onboarding_funnel  == 3  || $this->user->onboarding_funnel  == 4) : ?>
                                                <div class="content-wrp">
                                                    <div class="text-content">
                                                        <h1><?= l('billing.14_day_subscription') ?></h1>
                                                        <p><?= l('billing.14_day_subscription_description') ?></p>
                                                    </div>
                                                    <a href="<?= url('plan-rdpf') ?>">
                                                        <button class="btn w-100 primary-btn  resubscribe-btn" name="send_to_modal">
                                                            <span class="text "><?= l('billing.resubscribe') ?></span>
                                                        </button>
                                                    </a>
                                                </div>
                                            <?php else : ?>

                                                <div class="content-wrp">
                                                    <div class="text-content">
                                                        <h1><?= l('billing.subscription_canceled') ?></h1>
                                                        <p><?= l('billing.subscription_canceled_description') ?></p>
                                                    </div>
                                                    <div class="button-wrp">
                                                        <a href="<?= url('plan/renew') ?>">
                                                            <button class="btn w-100 primary-btn  resubscribe-btn" name="send_to_modal">
                                                                <span class="text "><?= l('billing.resubscribe') ?></span>
                                                            </button>
                                                        </a>
                                                    </div>
                                                </div>
                                            <?php endif ?>
                                        </div>
                                    <?php endif ?>
                                <?php endif ?>
                            </div>
                            <div class="cardupdate-detail-window ">
                                <form id="payment-form">
                                    <div class="content-wrp">
                                        <div class="row">
                                            <div class="payment-form-content">
                                                <div class="card-detail-form-wrap">
                                                    <div id="payment-element">
                                                        <!--Stripe.js injects the Payment Element-->
                                                    </div>
                                                    <div id="payment-message" style="color:red; font-weight:700" class="hidden"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-12 d-flex buttons-wrp">
                                                <div class="row w-100 justify-content-sm-end">
                                                    <div class="col-md col-sm-3 col-6">
                                                        <button class="btn w-100 outline-btn" type="button" onclick="redirectToBilling()">
                                                            <span class="text "><?= l('billing.back') ?></span>
                                                        </button>
                                                    </div>
                                                    <div class="col-md col-sm-3 col-6">
                                                        <button class="btn w-100 primary-btn  update-btn" id="submit">
                                                            <div class="spinner hidden" id="spinner"></div>
                                                            <span class="text" id="button-text"><?= l('billing.update') ?></span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="card-errors" style="color:red" role="alert"></div>
                                            <div id="payment-message" style="color:red" class="hidden"></div>
                                        </div>
                                    </div>
                                </form>




                            </div>

                        </div>

                    </div>
                </div>

            </div>
            <div class="tab-pane fade " id="taxInfo" role="tabpanel" aria-labelledby="taxInfo-tab">
                <div class="accountCardDetail history-table tax-full-wrap">
                    <div class="accountCardDetailRow d-flex align-items-start">
                        <div class="container-fluid fullCard rounded payment-history-table-wrp">
                            <div class="row d-md-flex d-none title-wrp">
                                <div class="col-md "><span class="font-bold"><?= l('billing.transaction_date') ?></span></div>
                                <div class="col-md "><span class="font-bold"><?= l('billing.payments_details') ?></span></div>
                                <div class="col-md "><span class="font-bold"><?= l('billing.status') ?></span></div>
                            </div>

                            <?php foreach ($data->payments as $row) : ?>


                                <div class="row content-wrp">
                                    <div class="col-md col-8 type-wrp d-md-none d-block"><span><?= $row->type == 'card' ? l('billing.type_' . $row->type) : $row->type ?></span></div>
                                    <div class="col-md col-8 date-wrp "><span><?= (new \DateTime($row->datetime))->format('M d, Y ') ?></span></div>
                                    <div class="hr d-md-none d-block col-12"></div>
                                    <div class="col-md col-5 card-num-wrp d-md-none d-block"><span><?= l('billing.card_number') ?></span></div>
                                    <div class="col-md col-7 number-wrp "><span><?= ucfirst($row->payment_proof) ?></span></div>
                                    <div class="col-md col-4 status-wrp ">
                                        <?php if ($row->status == 1 && !($row->is_refund)) : ?>
                                            <span class="status-label paid"><?= l('billing.paid') ?></span>
                                        <?php elseif ($row->is_refund) : ?>
                                            <span class="status-label pending"><?= l('billing.refunded') ?></span>
                                        <?php else : ?>
                                            <span class="status-label failed"><?= l('billing.failed') ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md col-8 invoice-dwn-wrp d-md-none d-block"><span><?= l('billing.download_invoice') ?></span></div>
                                    <div class="col-md col-auto download-invoice-wrp">

                                        <?php if ($row->status == 1) : ?>
                                            <a href="<?= url('invoice/' . $row->id) ?>" target="_blank">
                                                <button class="btn download-invoice outline-btn">
                                                    <span class="icon-download"></span>
                                                    <span class="d-xl-block d-none"><?= l('billing.download_invoice') ?></span>
                                                </button>
                                            </a>
                                        <?php else : ?>

                                            <button class="btn download-invoice outline-btn" disabled>
                                                <span class="icon-download"></span>
                                                <span class="d-xl-block d-none"><?= l('billing.download_invoice') ?></span>
                                            </button>

                                        <?php endif; ?>


                                    </div>
                                </div>
                            <?php endforeach ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal smallmodal fade" id="cancelSubscriptionModal" tabindex="-1" aria-labelledby="cancelSubscriptionModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-export">
        <div class="modal-content extra-space">
            <button type="button" class="close d-none" data-dismiss="modal" aria-label="Close">
                <svg class="MuiSvgIcon-root jss709" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 20px;">
                    <path d="M13.41,12l5.3-5.29a1,1,0,1,0-1.42-1.42L12,10.59,6.71,5.29A1,1,0,0,0,5.29,6.71L10.59,12l-5.3,5.29a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0L12,13.41l5.29,5.3a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42Z"></path>
                </svg>
            </button>
            <div class="modal-img px-0">
                <?php if ($this->user->plan_id == 6 || $this->user->plan_id == 7) : ?>
                    <h1 class="font-weight-bold"><?= l('billing.cancel_14_day_subscription.title') ?></h1>

                    <p><?= sprintf(l('billing.cancel_14_day_subscription.description_1'), (new \DateTime($this->user->plan_expiration_date))->format('Y-m-d')) ?></p>

                    <p><?= l('billing.cancel_14_day_subscription.description_2') ?></p>
                <?php else :  ?>
                    <h1><?= l('billing.cancel_subscription.title') ?></h1>
                    <p><?= l('billing.cancel_subscription.description') ?></p>
                <?php endif ?>

            </div>
            <div class="modal-body modal-btn justify-content-center">
                <a class="subscription-cancel-btn"><button class="btn primary-btn r-4 confirm-btn" name="qr_status_paused"><?= l('billing.confirm') ?></button></a>

                <button class="btn outline-btn ms-2  m-0 r-4 me-2" type="button" data-dismiss="modal" aria-label="Close"><?= l('billing.go_back') ?></button>
            </div>
        </div>
    </div>
</div>

<?php include_once('modals/switch-plan-modal.php') ?>

<?php if ($data->isSwitchPlan) { ?>
    <script>
        $(document).ready(switchPlanModalOpened);
    </script>
<?php } ?>

<?php ob_start() ?>

<?php
$userLanguage =  user_language($this->user);
$userLanguageCode = \Altum\Language::$active_languages[$userLanguage] ? \Altum\Language::$active_languages[$userLanguage] : null;
?>

<?php if ($this->user->plan_id != 'free' || $data->suspendsubcription) : ?>
    <?php include_once('cancel-popmodal/cancel-pop.php') ?>
<?php endif ?>

<script src="https://js.stripe.com/v3/"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>


<script>
    window.addEventListener('load', (event) => {
        <?php if (isset($_SESSION['cancel_subscription']) && $_SESSION['cancel_subscription'] == true) { ?>
            window.location.reload();
            <?php unset($_SESSION['cancel_subscription']) ?>
        <?php  } ?>

    });
</script>

<script>
    function redirectToBilling() {
        window.location.href = "<?= url('billing') ?>";
    }

    $(".updatePayment-btn").on("click", function() {
        $(".cardupdate-detail-window").toggleClass('active');
    });


    const stripe = Stripe('<?php echo settings()->stripe->publishable_key ?>', {
        locale: '<?= $userLanguageCode ?>',
    });
    const elements = stripe.elements({
        clientSecret: '<?= $clientSecret ?>'
    });
    const paymentElementOptions = {
        layout: {
            type: 'tabs',
            defaultCollapsed: false,
        },
    };
    const paymentElement = elements.create("payment", paymentElementOptions);
    paymentElement.mount("#payment-element");


    var email = "<?php echo isset($this->user->billing->email) ? $this->user->billing->email : $this->user->email; ?>";
    var country = "<?php echo $this->user->billing->country ? $this->user->billing->country : $this->user->country; ?>";

    const form = document.getElementById('payment-form');
    var suspendsubcription = "<?= $data->suspendsubcription ? true : false ?>";

    form.addEventListener('submit', async (e) => {
        $('.update-btn').prop('disabled', true);

        e.preventDefault();
        if (suspendsubcription) {
            stripe.confirmPayment({
                elements,
                confirmParams: {
                    // Make sure to change this to your payment completion page
                    return_url: "<?= SITE_URL ?>billing",
                    payment_method_data: {
                        billing_details: {
                            email: email,
                            address: {
                                country: country,
                            }
                        }
                    }
                },
            }).then(function(result) {
                if (result.error) {
                    if (result.error.type === "card_error" || result.error.type === "validation_error") {
                        showMessage(result.error.message);
                    } else {
                        showMessage("An unexpected error occurred.");
                    }
                    setLoading(false);
                }

            });

        } else {

            stripe.confirmSetup({
                elements,
                confirmParams: {
                    // Make sure to change this to your payment completion page
                    return_url: "<?= SITE_URL ?>billing",
                    payment_method_data: {
                        billing_details: {
                            email: email,
                            address: {
                                country: country,
                            }
                        }
                    }
                },
            }).then(function(result) {
                if (result.error) {
                    console.log(result.error);
                    if (result.error.type === "card_error" || result.error.type === "validation_error") {
                        showMessage(result.error.message);
                    } else {
                        showMessage("An unexpected error occurred.");
                    }
                    setLoading(false);
                }
            });
        }
    });

    function showMessage(messageText) {
        const messageContainer = document.querySelector("#payment-message");

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
            document.querySelector("#submit").disabled = true;
            document.querySelector("#spinner").classList.remove("hidden");
            document.querySelector("#button-text").classList.add("hidden");
        } else {
            document.querySelector("#submit").disabled = false;
            document.querySelector("#spinner").classList.add("hidden");
            document.querySelector("#button-text").classList.remove("hidden");
        }
    }

    // Cancel subcription 
   // Cancel subcription 
   $(document).on('click', '.subscription-cancel-btn', function() {
        <?php if (isset($data->suspendsubcription) &&  $this->user->cancel_promo != 3 ) : ?>
            var feedbackModal = $("#feedbackModal");
            var subscriptionCancelModal = $("#cancelSubscriptionModal");
            subscriptionCancelModal.hide();
            $("#feedbackModal").show();
            feedbackModal.addClass("show");
            $(".feedback-submit-btn , #customFeedback").prop('disabled', true);
        <?php elseif (

            isset($paymentDays)
            &&  $paymentDays < 30 
            &&  $this->user->plan_id == 2 ) : 
        ?>
            $(".cancel-confirm-btn").trigger("click");

        <?php elseif (
            
            $paymentDays < 7 
            && $this->user->onboarding_funnel != 4 
            &&  $this->user->cancel_promo == 1) : 
        ?>
            $(".cancel-confirm-btn").trigger("click");

        <?php elseif (
            $this->user->plan_id != 4 &&
            $this->user->plan_id != 5 &&
            $this->user->plan_id != 6 &&
            $this->user->plan_id != 7 &&
            $data->userDiscount == null &&
            $this->user->cancel_promo != 3 &&
            $this->user->payment_subscription_id != null
        ) : ?>
            var feedbackModal = $("#feedbackModal");
            var subscriptionCancelModal = $("#cancelSubscriptionModal");
            subscriptionCancelModal.hide();
            $("#feedbackModal").show();
            feedbackModal.addClass("show");
            $(".feedback-submit-btn , #customFeedback").prop('disabled', true);
        <?php else : ?>
            $(".cancel-confirm-btn").trigger("click");
        <?php endif ?>
    });
</script>

<?php \Altum\Event::add_content(ob_get_clean(), 'javascript') ?>