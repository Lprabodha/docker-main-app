<?php
defined('ALTUMCODE') || die();

use Altum\Alerts;


$planId  = $data->plan->plan_id;
$plan     = db()->where('plan_id', $planId)->getOne('plans');
$user    = $this->user;

$user_email                 = $user->email;
$user_id                    = $user->user_id;
$unique_id                  = isset($user->unique_id) ? $user->unique_id : null;
$total_logins               = $user->total_logins;
$user_source                = $user->source;
$user_payment_processor     = $user->payment_processor;
$userCountry                = $user->country;

$rate = null;
$symbol = null;
$code = null;
if ($exchangeData = exchange_rate($user)) {
    $rate   = $exchangeData['rate'];
    $symbol = $exchangeData['symbol'];
    $code   = $exchangeData['code'];
}

$currency = 'USD';
$countryCurrency = get_user_currency($code);
if ($countryCurrency) {
    $currency = $code;
}


$price   = get_plan_month_price($planId, $code);
$total   = get_plan_price($planId, $code);

switch ($data->plan->plan_id) {
    case 2:
        $priceId = STRIPE_PRICE_12_ID;
        $name    =  'annually';
        break;
    case 6:
        $priceId = STRIPE_PRICE_14_DAY_FULL_ACCESS;
        $name    =  '14_day_full_access';
        break;
    case 7:
        $priceId = STRIPE_PRICE_14_DAY_LIMITED_ACCESS;
        $name    =  '14_day_limited_access';
        break;

    default:
        $priceId = STRIPE_PRICE_14_DAY_FULL_ACCESS;
        $name    =  '14_day_full_access';
        break;
}

try {
    $stripe     = $data->stripe;
    $customerId = $data->customerId;

    if (isset($_SESSION['clientSecret']) &&  $_SESSION['clientSecret'] != '') {
        $clientSecret = $_SESSION['clientSecret'];
    } else {

        try {
            if ($planId == 6 || $planId == 7) {

                $payment_intent = $stripe->paymentIntents->create([
                    'customer' => $customerId,
                    'amount' => get_stripe_format($total, $currency),
                    'currency' => $currency,
                    'description' => 'One-time payment',
                    'metadata' => [
                        'plan_id' => $planId,
                        'payment_frequency' => $name,
                    ],
                    'setup_future_usage' => 'off_session',
                    'automatic_payment_methods' => [
                        'enabled' => 'true',
                    ],

                ]);
                $clientSecret = $payment_intent->client_secret;
                $_SESSION['clientSecret'] = $clientSecret;
            } else {
                $subscription = $stripe->subscriptions->create([
                    'customer' => $customerId,
                    'description' => 'DPF',
                    'items' => [[
                        'price' => $priceId,
                    ]],
                    'payment_behavior' => 'default_incomplete',
                    'payment_settings' => ['save_default_payment_method' => 'on_subscription'],
                    'expand' => ['latest_invoice.payment_intent'],
                    'currency' => $currency,
                ]);
                $clientSecret = $subscription->latest_invoice->payment_intent->client_secret;
                $_SESSION['clientSecret'] = $clientSecret;
            }
        } catch (Exception $e) {

            Alerts::add_error(l('pay_dpf.plan_error_payment_gateway'));
        }
    }
} catch (Exception $e) {
    Alerts::add_error(l('pay_dpf.plan_error_payment_gateway'));
}



?>

<style>
    .dpf-currency {
        margin-left: 0.5rem;
        margin-top: 2px;
        display: flex;
        flex-direction: column;
    }

    .dpf-currency span.main {
        margin-left: 16px;
        margin-top: 3px;
        line-height: 1;
    }

    .dpf-currency span.converted {
        font-size: 16px;
        font-weight: 400;
        margin-left: 16px;
    }
</style>



<div class="section-login-signup plan-dpf-main-wrapper pay-dpf">
    <div class="container">
        <div class="-main-cols plans-pick payment-pick">
            <div class="right-pad">
                <div class="-col-form w-100">
                    <div class="-logo-wrapper-shadow"></div>
                    <div class="-logo-wrapper">
                        <img src="<?= ASSETS_FULL_URL . 'images/logo-footer.svg' ?>" alt="Online QR Generator" class="-logo" loading="lazy">
                    </div>
                    <div class="form-wrap">
                        <div class="-form-title pay-dpf-title">
                            <span class="pay-heading"><?= l('pay_dpf.heading') ?></span>
                        </div>
                        <div class="-form-subtitle pay-dpf-subtitle">
                            <span class="pay-subheading"><?= l('pay_dpf.sub_heading') ?></span>
                        </div>

                        <div class="stripe-pay-wrap mt-3">
                            <span class="test"></span>
                            <span class="test1"></span>
                            <div class="stripe-header">
                                <span class="stripe-title d-block d-md-none"><?= l('pay_dpf.stripe_title') ?></span>
                                <span class="stripe-title d-none d-md-flex"><?= l('pay_dpf.price_title') ?> :
                                    <span class="fw-bold dpf-currency ">
                                        <?php if ($countryCurrency) : ?>
                                            <?= $symbol ?>&nbsp;<?= custom_currency_format($total) ?>
                                        <?php elseif (check_usd($code)) : ?>
                                            $&nbsp;<?= custom_currency_format($total) ?>
                                        <?php else : ?>
                                            <span class="main">$<?= custom_currency_format($total) ?>&nbsp;USD</span>
                                            <span class="converted">(<?= $symbol ?>&nbsp;<?= custom_currency_format($total * $rate) ?>&nbsp;<?= $code ?>)</span>

                                        <?php endif ?>
                                    </span>
                                </span>
                            </div>
                            <div class="stripe-pay-field" id="stripe">


                                <!-- payment element stripe -->
                                <form class="payment-form" id="payment-form">
                                    <div class="payment-form-content">
                                        <div class="loader-wrap">
                                            <div class="skeleton-container">
                                                <div class="skeleton-wrap bx-2-column ">
                                                    <div class="row mx-1 mt-1">
                                                        <div class="col-sm-6 p-2">
                                                            <div class="skeleton-box">
                                                                <div class="dummy-box-title skeleton-anim"></div>
                                                                <div class="dummy-box-content skeleton-anim"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6 p-2">
                                                            <div class="skeleton-box">
                                                                <div class="dummy-box-title skeleton-anim"></div>
                                                                <div class="dummy-box-content skeleton-anim"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mx-1 mt-1">
                                                        <div class="col-sm-12 p-2">
                                                            <div class="skeleton-box single">
                                                                <div class="dummy-box-title skeleton-anim"></div>
                                                                <div class="dummy-box-content skeleton-anim"></div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row mx-1 mt-1">
                                                        <div class="col-sm-6 p-2">
                                                            <div class="skeleton-box single">
                                                                <div class="dummy-box-title skeleton-anim"></div>
                                                                <div class="dummy-box-content skeleton-anim"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6 p-2">
                                                            <div class="skeleton-box single">
                                                                <div class="dummy-box-title skeleton-anim"></div>
                                                                <div class="dummy-box-content skeleton-anim"></div>
                                                            </div>
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-detail-form-wrap">
                                            <div id="payment-element">
                                                <!--Stripe.js injects the Payment Element-->
                                            </div>
                                            <div id="payment-message" style="color:red; font-weight:700" class="hidden"></div>
                                        </div>
                                    </div>
                                    <div class="paymethod-btn-area payment-desktop-view">
                                        <div class="pay-btn-wrap">
                                            <button class="btn payment payInfoBtn dpf-pay-btn" id="submit" type="submit">
                                                <div class="hidden" id="spinner">
                                                    <svg viewBox="25 25 50 50" class="new-spinner">
                                                        <circle r="20" cy="50" cx="50"></circle>
                                                    </svg>
                                                </div>
                                                <span id="button-text">
                                                    <?= l('pay_dpf.submit') ?>
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>

                        <div class="dpf-pay-payment-wrap mt-4">
                            <!-- <span class="dpf-pay-methods"><?= l('pay_dpf.pay_method_title') ?></span> -->
                            <div class="dpf-pay-method-wrap d-flex">
                                <div class="pay-method-card col">
                                    <div class="pay-card">
                                        <div class="image-card-wrap">
                                            <img src="<?= ASSETS_FULL_URL . 'images/payment-methods/visa.png' ?>" class="img-fluid" alt="" />
                                        </div>
                                    </div>
                                </div>
                                <div class="pay-method-card col">
                                    <div class="pay-card">
                                        <div class="image-card-wrap">
                                            <img src="<?= ASSETS_FULL_URL . 'images/payment-methods/master.png' ?>" class="img-fluid" alt="" />
                                        </div>
                                    </div>
                                </div>
                                <div class="pay-method-card col">
                                    <div class="pay-card">
                                        <div class="image-card-wrap">
                                            <img src="<?= ASSETS_FULL_URL . 'images/payment-methods/google-pay.png' ?>" class="img-fluid" alt="" />
                                        </div>
                                    </div>
                                </div>
                                <div class="pay-method-card col">
                                    <div class="pay-card">
                                        <div class="image-card-wrap">
                                            <img src="<?= ASSETS_FULL_URL . 'images/payment-methods/amreican-express.png' ?>" class="img-fluid" alt="" />
                                        </div>
                                    </div>
                                </div>
                                <div class="pay-method-card col">
                                    <div class="pay-card">
                                        <div class="image-card-wrap">
                                            <img src="<?= ASSETS_FULL_URL . 'images/payment-methods/apple-pay.png' ?>" class="img-fluid" alt="" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="payment-policy-wrap mt-4 d-none d-md-block">
                            <?php if ($planId == 2) : ?>
                                <span class="dpf-policy-text">
                                    <span><?= l('pay_dpf.policy_text_2') ?></span><span></span><a><?= l('pay_dpf.policy_text_3') ?>.</a>
                                </span>
                            <?php else : ?>
                                <span class="dpf-policy-text">
                                    <span> <?= l('pay_dpf.policy_text') ?></span>
                                    <span>
                                        <?php if ($countryCurrency) : ?>
                                            <?= $symbol ?>&nbsp<?= custom_currency_format($total) ?>
                                        <?php else : ?>
                                            $&nbsp<?= custom_currency_format($total) ?>
                                        <?php endif ?>
                                    </span>
                                    <span><?= l('pay_dpf.policy_text_1') ?>
                                        <?php if ($countryCurrency) : ?>
                                            <?= $symbol ?>&nbsp<?= custom_currency_format(get_plan_month_price(1, $code)) ?>
                                        <?php else : ?>
                                            $&nbsp<?= custom_currency_format(get_plan_month_price(1, $code)) ?>
                                        <?php endif ?>



                                        <?= l('pay_dpf.policy_text_1_2') ?>
                                    </span>
                                    <a><?= l('pay_dpf.policy_text_3') ?>.</a>
                                </span>
                            <?php endif ?>
                        </div>
                    </div>
                </div>

            </div>

            <hr class="dpf-hr pay-dpf-hr d-none">
            <div class="left-pad">
                <div class="desktop-qr col-qr-image dpf-qr-wrap w-100">
                    <div class="pay-dpf-qrprev-wrap">
                        <div class="dpf-pay-qr-header d-flex justify-content-center">
                            <div class="check-icon-wrap">
                                <div class="check-icon"></div>
                            </div>
                            <span class="dpf-qr-title"><?= l('pay_dpf.qr_title') ?></span>
                        </div>
                        <div class="qr-wrap pay-qr mt-lg-4">
                            <object data="<?= SITE_URL . 'uploads/qr_codes/logo/' . $data->qr_code->qr_code ?>?<?= time() ?>" class="img-fluid scan-img-obj" style="pointer-events: none;"></object>
                            <span class="corners-set corners-up"></span>
                            <span class="corners-set corners-down"></span>
                        </div>
                    </div>
                    <div class="dpf-qr-feature mt-4">
                        <div class="section-email-feature row row-cols-md-2 mt-6">
                            <div class="feature-detail">
                                <div class="detail d-flex">
                                    <div class="feature-icon-area">
                                        <i class="dpf-plan-icon icon-email text-success"></i>
                                    </div>
                                    <div class="feature-item-detail">
                                        <p class="item-description"> <?= l('register_dpf.email_feature_1') ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="feature-detail">
                                <div class="detail d-flex">
                                    <div class="feature-icon-area ">
                                        <i class="dpf-plan-icon icon-qr-multiple text-success"></i>
                                    </div>
                                    <div class="feature-item-detail">
                                        <?php if ($planId != 7) : ?>
                                            <p class="item-description 1"> <?= l('pay_dpf.email_feature_1') ?></p>
                                        <?php else : ?>
                                            <p class="item-description 1"> <?= l('pay_dpf.email_feature_1_1') ?></p>
                                        <?php endif ?>
                                    </div>
                                </div>
                            </div>
                            <div class="feature-detail">
                                <div class="detail d-flex">
                                    <div class="feature-icon-area ">
                                        <i class="dpf-plan-icon icon-qr-edit-sq text-success"></i>
                                    </div>
                                    <div class="feature-item-detail">
                                        <p class="item-description 4"> <?= l('pay_dpf.email_feature_2') ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="feature-detail">
                                <div class="detail d-flex">
                                    <div class="feature-icon-area ">
                                        <i class="dpf-plan-icon icon-scan-barcode text-success"></i>
                                    </div>
                                    <div class="feature-item-detail">
                                        <?php if ($planId != 7) : ?>
                                            <p class="item-description 3"> <?= l('pay_dpf.email_feature_3') ?></p>
                                        <?php else : ?>
                                            <p class="item-description 3"> <?= l('pay_dpf.email_feature_3_1') ?></p>
                                        <?php endif ?>
                                    </div>
                                </div>
                            </div>
                            <div class="feature-detail">
                                <div class="detail d-flex">
                                    <div class="feature-icon-area ">
                                        <i class="dpf-plan-icon icon-activity text-success"></i>
                                    </div>
                                    <div class="feature-item-detail">
                                        <p class="item-description 5"> <?= l('pay_dpf.email_feature_4') ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="feature-detail">
                                <div class="detail d-flex">
                                    <div class="feature-icon-area ">
                                        <i class="dpf-plan-icon icon-qr-manage text-success"></i>
                                    </div>
                                    <div class="feature-item-detail">
                                        <p class="item-description 2"> <?= l('pay_dpf.email_feature_5') ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="feature-detail">
                                <div class="detail d-flex">
                                    <div class="feature-icon-area">
                                        <i class="dpf-plan-icon icon-qr-more text-success"></i>
                                    </div>
                                    <div class="feature-item-detail">
                                        <p class="item-description 6"> <?= l('pay_dpf.email_feature_6') ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="payment-policy-wrap payment-policy-wrap-mobile mt-0 border-none d-block d-md-none">
                        <?php if ($planId == 2) : ?>
                            <span class="dpf-policy-text">
                                <span><?= l('pay_dpf.policy_text_2') ?></span><span></span><a><?= l('pay_dpf.policy_text_3') ?>.</a>
                            </span>
                        <?php else : ?>
                            <span class="dpf-policy-text">
                                <span> <?= l('pay_dpf.policy_text') ?></span>
                                <span>
                                    <?php if ($countryCurrency) : ?>
                                        <?= $symbol ?>&nbsp<?= custom_currency_format($total) ?>
                                    <?php else : ?>
                                        $&nbsp<?= custom_currency_format($total) ?>
                                    <?php endif ?>
                                </span>
                                <span><?= l('pay_dpf.policy_text_1') ?>
                                    <?php if ($countryCurrency) : ?>
                                        <?= $symbol ?>&nbsp<?= custom_currency_format(get_plan_month_price(1, $code)) ?>
                                    <?php else : ?>
                                        $&nbsp<?= custom_currency_format(get_plan_month_price(1, $code)) ?>
                                    <?php endif ?>

                                    <?= l('pay_dpf.policy_text_1_2') ?>
                                </span>
                                <a><?= l('pay_dpf.policy_text_3') ?>.</a>
                            </span>
                        <?php endif ?>
                    </div>
                    <div class="pay-dpf-final-wrap mt-3">
                        <div class="pay-dpf-price d-flex">
                            <div class="pay-dpf-price-title col-6">
                                <span class="pay-pdf-final-tile"><?= l('pay_dpf.price_title') ?></span>
                            </div>
                            <div class="pay-dpf-price-text col-6">
                                <?php if ($countryCurrency) : ?>
                                    <span class="pay-pdf-final-text"><?= $symbol ?>&nbsp;<?= custom_currency_format($total) ?></span>
                                <?php elseif (check_usd($code)) : ?>
                                    <span class="pay-pdf-final-text">$&nbsp;<?= custom_currency_format($total) ?></span>
                                <?php else : ?>
                                    <span class="pay-pdf-final-text">$&nbsp;<?= custom_currency_format($total) ?> USD</span>
                                    <span class="pay-dpf-local-currency">(<?= $symbol ?>&nbsp;<?= custom_currency_format($total * $rate) ?>&nbsp;<?= $code ?>)</span>
                                <?php endif ?>


                            </div>
                        </div>
                        <hr class="accordian-hr dpf-qr-hr d-none">
                        <div class="mobile-dpf-paybtn-wrap p-2">
                            <button class="dpf-pay-mobile-btn btn" id="mobileSubmitBtn">
                                <div class="hidden" id="spinner-m">
                                    <svg viewBox="25 25 50 50" class="new-spinner">
                                        <circle r="20" cy="50" cx="50"></circle>
                                    </svg>
                                </div>
                                <span id="button-textm">
                                    <?= l('pay_dpf.submit') ?>
                                </span>
                                <!-- Download QR Code -->
                            </button>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
<div id="confirmationModal" style="display: none;position:absolute;top:50%;left:50%;opacity:0;transform:translate(-50%,-50%);background-color:#fff;z-index:-1000;">
    <div>
        <p>Are you sure you want to leave this page?</p>
        <button class="btn leave-alert-accept" onclick="confirmLeave()">Yes</button><br>
        <button class="btn" onclick="closeModal()">No</button>
    </div>
</div>
<script>
    $(document).ready(function() {
        $(".dpf-pay-methodbox").on("click", function() {
            // Uncheck all radio buttons with the same name
            $('input[name="payment-method"]').prop("checked", false).parents(".pay-card").removeClass("pdf-pay-radio-active");
            // Check the clicked radio button
            $(this).prop("checked", true).parents(".pay-card").addClass("pdf-pay-radio-active");
        });
    });
</script>

<?php ob_start() ?>

<script src="https://js.stripe.com/v3/"></script>
<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script>
    var currentLangCode = document.documentElement.lang;

    // var scrollToTopBtn = document.querySelector('.payInfoBtn');
    // scrollToTopBtn.addEventListener('click', scrollToTop);

    // Card Element
    const stripe = Stripe('<?php echo settings()->stripe->publishable_key ?>', {
        locale: currentLangCode
    });
    const elements = stripe.elements({
        clientSecret: '<?= $clientSecret ?>'
    });
    const paymentElementOptions = {
        layout: {
            type: 'tabs',
            defaultCollapsed: false,
        },
        terms: {
            card: 'never',
            googlePay: 'never',
            applePay: 'never',
            cashapp: 'never',
        }
    };



    const paymentElement = elements.create("payment", paymentElementOptions);
    paymentElement.on('ready', function(event) {
        $('.loader-wrap').fadeOut('slow');
        $('.payment-form-content').css('min-height', 'unset');
    });

    paymentElement.mount("#payment-element");
    const form = document.getElementById('payment-form');

    form.addEventListener('submit', async (e) => {

        changePayUrl();

        e.preventDefault();
        setLoading(true);
        var planId = "<?php echo $data->plan->plan_id; ?>";
        var email = "<?php echo $user_email; ?>";
        var currency = "<?php echo $currency; ?>";

        var radarSessionId;
        const {
            radarSession,
            error
        } = await stripe.createRadarSession();
        if (error) {
            console.error(error);
        } else {
            radarSessionId = radarSession.id;
        }


        stripe.confirmPayment({
            elements,
            confirmParams: {
                return_url: "<?= SITE_URL ?>pay-dpf/" + planId + '?currency=' + currency,
                payment_method_data: {
                    billing_details: {
                        email: email,
                    },
                    radar_options: {
                        session: radarSessionId,
                    }
                },

            },
        }).then(function(result) {
            if (result.error) {
                if (result.error.type === "card_error" || result.error.type === "validation_error") {
                    $("body").trigger("click");
                    showMessage(result.error.message);
                    if ($(window).width() < 576) {
                        $('html, body').animate({
                            scrollTop: $(".stripe-header").offset().top
                        });
                    }
                } else {
                    showMessage("An unexpected error occurred.");
                }
                setLoading(false);
            } else {
                console.log('No Errors Found');
            }
        });
    });

    function returnInfo() {
        $('.pay-user-info').removeClass('d-none');
        $('#menu-payment').removeClass('active');
        $('.card-detail-area').addClass('d-none');
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
    // Show a spinner on payment submission
    function setLoading(isLoading) {
        if (isLoading) {
            // Disable the button and show a spinner
            document.querySelector("#submit").disabled = true;
            document.querySelector("#spinner").classList.remove("hidden");
            document.querySelector("#button-text").classList.add("hidden");
            document.querySelector("#mobileSubmitBtn").disabled = true;
            document.querySelector("#spinner-m").classList.remove("hidden");
            document.querySelector("#button-textm").classList.add("hidden");
        } else {
            document.querySelector("#submit").disabled = false;
            document.querySelector("#spinner").classList.add("hidden");
            document.querySelector("#button-text").classList.remove("hidden");
            document.querySelector("#mobileSubmitBtn").disabled = false;
            document.querySelector("#spinner-m").classList.add("hidden");
            document.querySelector("#button-textm").classList.remove("hidden");
        }
    }





    // Show a spinner on payment submission
    function setInfoLoading(isLoading) {
        if (isLoading) {
            // Disable the button and show a spinner
            document.querySelector("#infoSubmit").disabled = true;
            document.querySelector("#infoSpinner").classList.remove("hidden");
        } else {
            document.querySelector("#infoSubmit").disabled = false;
            document.querySelector("#infoSpinner").classList.add("hidden");
        }
    }

    $(".dpf-pay-mobile-btn").on("click", function() {
        $("#submit").trigger("click");
    });

    $(document).on("DOMSubtreeModified", function() {
        setTimeout(function() {
            var paymentErrorText = $("#payment-message").text();
            if (paymentErrorText == 'Please provide complete payment details.') {
                $("#payment-message").hide();
            }
        }, 100);

    });

    const payElement = $('.form-wrap');

    const elementOffset = payElement.offset();

    const scrollTop = $(window).scrollTop();

    const distanceToElement = elementOffset.top - scrollTop;

    const viewportHeight = window.innerHeight;

    paymentElement.on('focus', (event) => {
        $('.pay-dpf-final-wrap').removeClass('animate-position');
        $('head').find('style#moveFromTopToBottom').remove();
        if (scrollTop < distanceToElement) {

            addAnimation();

            $('.pay-dpf-final-wrap.animate-position').css({
                'animation': 'moveFromTopToBottom 1s ease-in-out',
            });
            $('.pay-dpf-final-wrap').css({
                'bottom': '0px'
            });
        } else {
            isKeyboardOpen();
        }
    });

    function isKeyboardOpen() {
        if ('visualViewport' in window) {
            const VIEWPORT_VS_CLIENT_HEIGHT_RATIO = 0.75;
            window.visualViewport.addEventListener('resize', function(event) {
                if (
                    (event.target.height * event.target.scale) / window.screen.height <
                    VIEWPORT_VS_CLIENT_HEIGHT_RATIO
                ) {
                    const visualViewportHeight = window.visualViewport.height;
                    const keyboardHeight = viewportHeight - visualViewportHeight;

                    $('.pay-dpf-final-wrap').css({
                        'bottom': keyboardHeight + 'px',
                        'transform': 'translateY(0px)',
                    });

                    // const payFormElement = $('.stripe-header');
                    const payFormElement = $('.pay-heading');

                    const payElementOffset = payFormElement.offset();

                    const windowScrollTop = $(window).scrollTop();

                    const distanceToFormElement = payElementOffset.top - scrollTop;

                } else {
                    $(".pay-dpf-final-wrap").addClass('animate-position');
                    $('.pay-dpf-final-wrap.animate-position').css({
                        'animation': 'moveFromTopToBottom 1s ease-in-out',
                    });
                    $('.pay-dpf-final-wrap').css({
                        'bottom': '0px'
                    });
                }
            });
        }
    }

    function addAnimation() {
        $(".pay-dpf-final-wrap").addClass('animate-position');
        var keyframe = `@keyframes moveFromTopToBottom {
                                                    0% {
                                                        opacity: 0;
                                                    }
                                                    100% {
                                                        opacity: 1;
                                                    }
                                            }`;

        $('head').append('<style>' + keyframe + '</style>');
    }

    // skeleton
    const payElementSkel = $(".card-detail-form-wrap");
    payElementSkel.on('ready', function(event) {
        console.log('Payment FOrmLoaded');
        // Handle ready event
    });
    // skeleton
</script>

<script>
    // Set the time (in milliseconds) for inactivity before redirect
    const inactivityTimeout = 30 * 60 * 1000; // 60 minutes

    let timeout;

    function resetTimer() {
        clearTimeout(timeout);
        timeout = setTimeout(redirectToHomepage, inactivityTimeout);
    }

    function redirectToHomepage() {
        // redirect to dashboard
        window.location.href = '<?= SITE_URL ?>';
    }

    // Reset the timer when there's user activity
    document.addEventListener('mousemove', resetTimer);
    document.addEventListener('keypress', resetTimer);
    document.addEventListener('touchstart', resetTimer);

    // Initial timer start
    resetTimer();
</script>

<script>
    function checkUserOnlineStatus() {
        var data = {
            action: 'check_user_online_status',
            userId: '<?= $this->user->user_id ?>'
        }

        $.ajax({
            type: 'POST',
            url: '<?= url('api/ajax_new') ?>',
            data: data,
            dataType: 'json',
            success: function(response) {},
            error: function(error) {
                console.error(error);
            }
        });
    }

    setInterval(() => {
        checkUserOnlineStatus();
    }, 30000);

    $(".dpf-pay-btn , .dpf-pay-mobile-btn").on("click", function() {
        isPaySubmit = true;
        getLeaveAlert();
    });

    $("body").on("click", function(e) {
        var paySubmitBtn = $(".dpf-pay-btn");
        var payMobileSubmitBtn = $(".dpf-pay-mobile-btn");
        if ($(window).width() > 900){
            if (!paySubmitBtn.is(e.target) && paySubmitBtn.has(e.target).length === 0 ) {
                desableLeaveAlert();
            }
        }else{
            if (!payMobileSubmitBtn.is(e.target) && payMobileSubmitBtn.has(e.target).length === 0 ) {
                desableLeaveAlert();
            }
        }
    });

    function desableLeaveAlert(){
        changePlanUrl();
        isPaySubmit = false;
        getLeaveAlert();
    }
    
    $(document).ready(function() {
        changePayUrl();
    });

    var isPaySubmit = false;
    var isLogoClick = false;

    let confirmedLeave = false;

    document.addEventListener("DOMContentLoaded", function() {
        window.addEventListener("popstate", (event) => {
            window.onbeforeunload = null;
            var mainUrl = '<?= SITE_URL ?>';
            var updateUrl = mainUrl + "plan-dpf?qr_onboarding=active_dpf";
            window.history.pushState("", "plan-dpf", updateUrl);
            window.location.href = updateUrl;
        });
    });

    function confirmLeave() {
        confirmedLeave = true;
        window.location.href = '<?= SITE_URL ?>';
    }

    function getLeaveAlert() {
        if (!isPaySubmit) {
            window.onbeforeunload = function(e) {
                if (!confirmedLeave) {
                    if (isLogoClick) {
                        defaultOpenModal();
                    } else {
                        openModal();
                    }
                    return "Are you sure you want to leave this page?";
                }
            };

        } else {
            window.onbeforeunload = null;
        }
    }

    function openModal() {
        const modal = document.getElementById("confirmationModal");
        modal.style.display = "block";
        setTimeout(function() {
            $(".leave-alert-accept").trigger("click");
        }, 500);
    }

    function defaultOpenModal() {
        const modal = document.getElementById("confirmationModal");
        modal.style.display = "block";
        $(".leave-alert-accept").trigger("click");
        $("body").trigger("click");
        changePlanUrl();
        isPaySubmit = false;
        isLogoClick = false;
        confirmedLeave = false;
        getLeaveAlert();
    }

    getLeaveAlert();

    function changePlanUrl() {
        var newUrl = window.location.href;
        history.pushState({}, '', newUrl);
    }

    function changePayUrl() {
        var mainUrl = '<?= SITE_URL ?>';
        var planId = '<?= $planId ?>';
        var newPayUrl = mainUrl + "pay-dpf/" + planId + "?qr_onboarding=active_dpf";

        history.pushState({}, '', newPayUrl);

    }

    $(".animate-logo").on("click", function(event) {
        if ($(window).width() < 768) {
            isPaySubmit = true;
            getLeaveAlert();
            event.preventDefault();
            window.location.href = "<?= SITE_URL ?>";
        } else {
            isPaySubmit = true;
            isLogoClick = true;
            getLeaveAlert();
        }
    });
</script>



<?php \Altum\Event::add_content(ob_get_clean(), 'javascript') ?>