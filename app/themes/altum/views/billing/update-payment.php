<?php defined('ALTUMCODE') || die() ?>

<?php

use Altum\Alerts;

$definedCurrency = get_user_currency($data->code);
$userLanguage =  user_language($this->user);
$userLanguageCode = \Altum\Language::$active_languages[$userLanguage] ? \Altum\Language::$active_languages[$userLanguage] : null;

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
?>

<div class=" my-account my-account-wrp container-fluid billing-page space-block">
    <?= \Altum\Alerts::output_alerts() ?>
    <div class="accountTabbing">
        <div class="row billing-info-title">
            <h1 class="mb-2 heading ms-1"><?= l('billing.header') ?></h1>
        </div>
        <div class="bill-detail r-4 mt-2 bill-update-alert">
            <div class="triel">
                <div class="description-wrp">
                    <div class="triel-icon d-flex exp-error">
                        <svg class="MuiSvgIcon-root expire-icon MuiSvgIcon-fontSizeMedium MuiSvgIcon-root MuiSvgIcon-fontSizeLarge css-1shn170" focusable="false" aria-hidden="true" viewBox="0 0 24 24" data-testid="ErrorIcon" tabindex="-1" title="Error">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"></path>
                        </svg>

                    </div>

                    <div class="triel-des ">
                        <p class="bil-des bil-des1 exp-error exp-message"> <br class="d-none"> <?= l('billing.suspend_subscription_payment_method_description') ?>
                        </p>
                    </div>

                </div>

                <?php if (url(\Altum\Routing\Router::$original_request) == (url('qr-codes')) || url(\Altum\Routing\Router::$original_request) == (url('analytics'))) : ?>
                    <a href="<?= url('plan') ?>" class="btn btn-light r-4" style=""><?= l('qr_codes.active_account') ?></a>
                <?php endif ?>
            </div>
        </div>
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
                <div class="accountCardDetail tax-full-wrap billing-pay-update-wrap">
                    <div class="accountCardDetailRow subscription-tab-wrp d-flex align-items-start">
                        <div class="container-fluid fullCard rounded ">
                            <div class="card-sub-detail-window">
                                <div class="plan-title-wrp">
                                    <div class="row">
                                        <div class="col plan-name-wrp">
                                            <div class="row billing-info-title">
                                                <h1 class="mb-2 heading ms-1">Update Your Payment Method</h1>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="plan-content-wrp mt-4 mb-4">
                                    <div class="row subscription">
                                        <div class="col-6 col-md content-title">
                                            <span><?= l('billing.subscription') ?></span>
                                        </div>
                                        <div class="col-6 col-md content-description">
                                            <span><?= $data->latestPayment->plan_name ?></span>
                                        </div>
                                    </div>

                                    <?php if ($this->user->plan_id != 8) : ?>
                                        <div class="row validity">
                                            <div class="col-6 col-md content-title">
                                                <span>Total due today</span>
                                            </div>
                                            <div class="col-6 col-md content-description">
                                                <?php if (!$definedCurrency && !check_usd($data->code)) : ?>
                                                    <span><?= $data->symbol . ' ' . custom_currency_format($data->overdueAmount * exchange_rate($this->user)['rate']) ?></span>
                                                <?php else : ?>
                                                    <span><?= $data->symbol . ' ' . custom_currency_format($data->overdueAmount) ?> </span>
                                                <?php endif ?>

                                                <div class="tooltip"></div>
                                            </div>
                                        </div>
                                    <?php endif ?>
                                </div>
                            </div>
                            <div class="cardupdate-detail">
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
                                                <div class="row w-100 justify-content-sm-end m-auto bill-update-btn-wrap">
                                                    <hr class="billind-update-hr d-none d-sm-block">
                                                    <div class="col-md col-sm-3 col-xl-2 col-6">
                                                        <button class="btn w-100 outline-btn" type="button" onclick="redirectToBilling()">
                                                            <span class="text "><?= l('billing.back') ?></span>
                                                        </button>
                                                    </div>
                                                    <div class="col-md col-sm-3 col-xl-2 col-6">
                                                        <button class="btn w-100 primary-btn  update-btn" id="submit">
                                                            <div class="spinner hidden" id="spinner"></div>
                                                            <span class="text" id="button-text"><?= l('billing.update') ?></span>
                                                        </button>
                                                    </div>
                                                    <!-- <hr class="billind-update-hr d-none d-sm-block"> -->
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




<?php ob_start() ?>



<?php if ($this->user->plan_id != 'free') : ?>
    <?php include_once('cancel-popmodal/cancel-pop.php') ?>
<?php endif ?>

<script src="https://js.stripe.com/v3/"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

<script>
    $(".updatePayment-btn").on("click", function() {
        $(".cardupdate-detail-window").toggleClass('active');
    });

    // Change button text on mobile devices
    const updateButton = document.getElementById('button-text');
    const isMobile = /Mobi|Android/i.test(navigator.userAgent);
    if (isMobile) {
        updateButton.textContent = 'Update plan';
    }

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
</script>

<?php \Altum\Event::add_content(ob_get_clean(), 'javascript') ?>