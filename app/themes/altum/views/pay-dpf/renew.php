<?php
defined('ALTUMCODE') || die();

use Altum\Alerts;

$price   = $data->plan->monthly_price;

if (isset($data->planId)) {
    $plan  = db()->where('plan_id', $data->planId)->getOne('plans');
    $planId  = $data->planId;
} else {
    $planId  = $data->plan->plan_id;
}

$user           = $data->user;
$user_email     = $user->email;
$user_id        = $user->user_id;
$unique_id      = isset($user->unique_id) ? $user->unique_id : null;
$ref_key        = isset($data->ref_key) ? $data->ref_key : null;
$payment_intent = null;
$subscription = null;
$userCurrency = $user->payment_currency;

$rate = null;
$symbol = null;
$code = null;
if ($exchange_rate = exchange_rate($user)) {
    $rate   = $exchange_rate['rate'];
    $symbol = $exchange_rate['symbol'];
    $code   = $exchange_rate['code'];
}

$price   = get_plan_month_price($planId, $code);
$total   = get_plan_price($planId, $code);

$currency = 'USD';
$countryCurrency = get_user_currency($code);
if ($userCurrency && $userCurrency != '') {
    $currency = $userCurrency;
} else if ($countryCurrency) {
    $currency = $code;
}

switch ($data->plan->plan_id) {
    case 1:
        $name    = l('pay.1_month_plan');
        $priceId = STRIPE_PRICE_1_ID;
        break;
    case 2:
        $name    = l('pay.12_month_plan');
        $priceId = STRIPE_PRICE_12_ID;
        break;
    case 3:
        $name    = l('pay.3_month_plan');
        $priceId = STRIPE_PRICE_3_ID;
        break;
    case 4:
        $name    = l('pay.1_month_discounted_plan');
        $priceId = STRIPE_PRICE_1_DISCOUNTED_ID;
        break;
    case 5:
        $name    = l('pay.onetime_plan');
        $priceId = STRIPE_PRICE_ONETIME_ID;
        break;
    default:
        $name    = l('pay.1_month_plan');
        $priceId = STRIPE_PRICE_1_ID;
}

if ($data->discount) {
    $monthlyDiscountPrice = round($price - $price / 100 * $data->discount, 2);
    switch ($data->plan->plan_id) {
        case 1:
            $discountTotal = $monthlyDiscountPrice;
            $couponCode = STRIPE_COUPON_1_NEW;
            break;
        case 2:
            $discountTotal = $monthlyDiscountPrice * 12;
            $couponCode = STRIPE_COUPON_12_NEW;
            break;
        case 3:
            $discountTotal = $monthlyDiscountPrice * 3;
            $couponCode = STRIPE_COUPON_3_NEW;
            break;
        default:
            $discountTotal = 0;
            $couponCode = '';
    }
}




$stripeClient = $data->stripeClient;
$customerId = $data->customerId;
try {
    if ($planId == 5) {
        $payment_intent = $stripeClient->paymentIntents->create([
            'customer' => $customerId,
            'amount' => get_stripe_format($total, $currency),
            'payment_method_types' => ['card'], // Specify the payment method type.
            'description' => 'One-time payment',
            'metadata' => [
                'plan_id' => $planId,
                'payment_frequency' => 'onetime',
            ],
            'currency' => $currency,
        ]);
        // $clientSecret = $payment_intent->client_secret;               
    } else {

        if ($data->discount) {

            $subscription = $stripeClient->subscriptions->create([
                'customer' => $customerId,
                'items' => [[
                    'price' => $priceId,
                ]],
                'coupon' => $couponCode,
                'payment_behavior' => 'default_incomplete',
                'payment_settings' => ['save_default_payment_method' => 'on_subscription'],
                'expand' => ['latest_invoice.payment_intent'],
                'currency' => $currency,
            ]);
        } else {
            $subscription = $stripeClient->subscriptions->create([
                'customer' => $customerId,
                'items' => [[
                    'price' => $priceId,
                ]],
                'payment_behavior' => 'default_incomplete',
                'payment_settings' => ['save_default_payment_method' => 'on_subscription'],
                'expand' => ['latest_invoice.payment_intent'],
                'currency' => $currency,
            ]);
        }
        // $clientSecret = $subscription->latest_invoice->payment_intent->client_secret;               
    }

    try {
        $stripe = new \Stripe\StripeClient(settings()->stripe->secret_key);
        try {
            $intents = $stripe->setupIntents->create([
                'customer' => $customerId,
            ]);
            $clientSecret = $intents->client_secret;
        } catch (Exception $e) {
            Alerts::add_error(l('billing.plan_error_customer_details'));
            $clientSecret = null;
        }
    } catch (Exception $e) {
        Alerts::add_error(l('billing.plan_error_payment_gateway'));
    }
} catch (Exception $e) {
    Alerts::add_error(l('pay.error_message.payment_gateway'));
}


?>

<div class="bg-light">
    <div class="container payment-full-wrap">
        <div class="payment-wrap">
            <?= \Altum\Alerts::output_alerts() ?>
            <div class="payment-form-wrap">
                <div class="row info-area">
                    <div class="col-xl-7 card-detail-area pt-4">
                        <h2 class="payment-subhead"><?= l('pay.billing_info') ?></h2>
                        <div class="payment-contact-info">
                            <p class="payment-small-head my-2"><?= l('pay.plan') ?></p>
                            <div class="payment-detail-field row">
                                <div class="payment-form-group col">
                                    <div class="payment-input-field d-flex">
                                        <div class="payment-input-icons-field m-auto d-flex" id="icon_area2">
                                            <span class="icon-document grey input-icon"></span>
                                        </div>
                                        <input type="text" name="" id="plan_type" value="<?php echo  $data->plan->name ?>" class="pay-form-control" readonly required="required" />
                                    </div>
                                </div>
                                <div class="payment-form-group payment-edit-warp col-auto" id="edit-plan" onclick="editPlan()">
                                    <div class="payment-edit-area">
                                        <span class="icon-edit grey payment-edit-icon mx-auto d-flex"></span>
                                    </div>
                                </div>
                            </div>

                            <p class="payment-small-head my-2"><?= l('billing.payment_method') ?></p>
                            <div class="payment-detail-field row">
                                <div class="payment-form-group col">
                                    <div class="payment-input-field d-flex">
                                        <div class="payment-input-icons-field m-auto d-flex" id="icon_area">
                                            <span class="icon-profile grey input-icon"></span>
                                        </div>
                                        <input type="text" name="" id="pay_name" value="<?php echo ucfirst($data->paymentMethod->card) ?>" class="pay-form-control" readonly required="required" />
                                    </div>
                                </div>
                                <div class="payment-form-group payment-edit-warp col-auto" id="edit-email" onclick="showPaymentMethod()">
                                    <div class="payment-edit-area">
                                        <span class="icon-edit grey payment-edit-icon mx-auto d-flex"></span>
                                    </div>
                                </div>
                            </div>
                            <div id="pm-message" style="color:red; font-weight:700" class="hidden"></div>
                        </div>
                        <div class="payment-method-info-wrap mt-4 btn-element">
                            <div class="paymethod-btn-area payment-desktop-view">
                                <div class="back-btn-wrap">
                                    <button type="button" class="btn pay-back-btn payInfoBtn">
                                        <div class="back-btn d-flex" onclick="editPlan()">
                                            <span class="icon-arrow-right paymethod-icon"></span>
                                            <p class="btn-text"><?= l('pay.plan') ?></p>
                                        </div>
                                    </button>
                                </div>
                                <div class="pay-btn-wrap">
                                    <button class="btn payment payInfoBtn" id="updateSubscription" onclick="updateSubscription()" type="submit">
                                        <div class="hidden" id="updateSpinner">
                                            <svg viewBox="25 25 50 50" class="new-spinner">
                                                <circle r="20" cy="50" cx="50"></circle>
                                            </svg>
                                        </div>
                                        <span id="updateButton-text">
                                            <?= l('pay_dpf.renew.submit') ?>
                                        </span>
                                    </button>
                                </div>



                            </div>
                        </div>

                        <div class="payment-method-info-wrap mt-4 payment-element d-none">
                            <h2 class="payment-subhead"><?= l('pay.payment_method') ?></h2>
                            <form class="payment-form" id="payment-form">
                                <div class="payment-form-content">
                                    <div class="card-detail-form-wrap">

                                        <div id="payment-element">
                                            <!--Stripe.js injects the Payment Element-->
                                        </div>
                                        <div id="payment-message" style="color:red; font-weight:700" class="hidden"></div>

                                    </div>
                                </div>
                                <div class="paymethod-btn-area payment-desktop-view">
                                    <div class="back-btn-wrap">
                                        <button type="button" class="btn pay-back-btn payInfoBtn">
                                            <div class="back-btn d-flex" onclick="showPaymentMethod()">
                                                <span class="icon-arrow-right paymethod-icon"></span>
                                                <p class="btn-text"><?= l('pay_dpf.renew.back') ?></p>
                                            </div>
                                        </button>

                                    </div>

                                    <div class="pay-btn-wrap">
                                        <button class="btn payment payInfoBtn" id="submit" type="submit">
                                            <div class="hidden" id="spinner">
                                                <svg viewBox="25 25 50 50" class="new-spinner">
                                                    <circle r="20" cy="50" cx="50"></circle>
                                                </svg>
                                            </div>
                                            <span id="button-text">
                                                <?= l('pay_dpf.renew.submit') ?>
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>

                    <!-- summery plan -->
                    <?php include_once(THEME_PATH . '/views/partials/summery-plan.php') ?>

                </div>
            </div>
        </div>
    </div>
</div>

<?php ob_start() ?>


<script src="https://js.stripe.com/v3/"></script>
<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script>
    const stripe = Stripe('<?php echo settings()->stripe->publishable_key ?>');
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

    var email = "<?php echo isset($user ->billing->email) ? $user ->billing->email :$user->email; ?>";
    var country = "<?= isset($user->billing->country) ? $user->billing->country : $user->country; ?>";

    const form = document.getElementById('payment-form');

    form.addEventListener('submit', async (e) => {
        setLoading(true);
        e.preventDefault();
        stripe.confirmSetup({
            elements,
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
            if (result.error) {
                if (result.error.type === "card_error" || result.error.type === "validation_error") {
                    showMessage(result.error.message);
                } else {
                    showMessage("An unexpected error occurred.");
                }
                setLoading(false);
            } else if (result.setupIntent.payment_method && result.setupIntent.status === "succeeded") {
                updateSubscriptionWithCard(result.setupIntent.payment_method);
            } else {
                showMessage("An unexpected error occurred.");
                setLoading(false);
            }
        });

    });

    function showPaymentMethod() {
        if ($('.payment-element').hasClass('d-none')) {
            $('.payment-element').removeClass('d-none');
            $('.btn-element').addClass('d-none');
        } else {
            $('.payment-element').addClass('d-none');
            $('.btn-element').removeClass('d-none');
        }
    }

    function updateSubscription() {
        setPmLoading(true);
        formData = new FormData();
        formData.append('subscription', '<?= $subscription ? $subscription->id : ''; ?>');
        formData.append('payment_intent', '<?= $payment_intent ? $payment_intent->id : ''; ?>');
        formData.append('pm', '<?= $data->paymentMethod->payment_method; ?>');
        formData.append('plan_id', '<?php echo $planId; ?>');

        $.ajax({
            type: 'POST',
            method: 'post',
            url: '<?= url('pay-rdpf/update') ?>',
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.data.payment == 'success') {
                    window.location.href = response.data.url;
                }
                if (response.data.payment == 'failed') {
                    showPaymentMethod();
                    setPmLoading(false);
                    if (response.data.error) {
                        showPmMessage(response.data.error);
                    } else {
                        showPmMessage("An unexpected error occurred.");
                    }
                }
            },
            error: function(response) {
                showPaymentMethod();
                showPmMessage("An unexpected error occurred.");
            }
        });


    }

    function updateSubscriptionWithCard(paymentMethod) {
        formData = new FormData();
        formData.append('subscription', '<?= $subscription ? $subscription->id : ''; ?>');
        formData.append('payment_intent', '<?= $payment_intent ? $payment_intent->id : ''; ?>');
        formData.append('pm', paymentMethod);
        formData.append('plan_id', '<?php echo $planId; ?>');

        $.ajax({
            type: 'POST',
            method: 'post',
            url: '<?= url('pay-rdpf/update') ?>',
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.data.payment == 'success') {
                    window.location.href = response.data.url;
                }
                if (response.data.payment == 'failed') {
                    setLoading(false);
                    if (response.data.error) {
                        showPmMessage(response.data.error);
                    } else {
                        showPmMessage("An unexpected error occurred.");
                    }
                }
            },
            error: function(response) {
                showPmMessage("An unexpected error occurred.");
            }
        });


    }

    function showPmMessage(messageText) {
        const messageContainer = document.querySelector("#pm-message");
        messageContainer.classList.remove("hidden");
        messageContainer.textContent = messageText;

        setTimeout(function() {
            messageContainer.classList.add("hidden");
            messageText.textContent = "";
        }, 5000);
    }


    // ------- UI helpers -------

    function showMessage(messageText) {
        const messageContainer = document.querySelector("#payment-message");
        messageContainer.classList.remove("hidden");
        messageContainer.textContent = messageText;

        setTimeout(function() {
            messageContainer.classList.add("hidden");
            messageText.textContent = "";
        }, 10000);
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

    function setPmLoading(isLoading) {
        if (isLoading) {
            // Disable the button and show a spinner
            document.querySelector("#updateSubscription").disabled = true;
            document.querySelector("#updateSpinner").classList.remove("hidden");
            document.querySelector("#updateButton-text").classList.add("hidden");
        } else {
            document.querySelector("#updateSubscription").disabled = false;
            document.querySelector("#updateSpinner").classList.add("hidden");
            document.querySelector("#updateButton-text").classList.remove("hidden");
        }
    }
</script>




<script>
    $(document).on('click', '.pay-back-btn', function() {
        window.history.back();
        var event = "cta_click";

        var data = {
            "userId": "<?php echo $user->user_id ?>",
            "clicktext": "Return to Contact",

        }
        googleDataLayer(event, data);
    });
</script>

<?php \Altum\Event::add_content(ob_get_clean(), 'javascript') ?>