<?php defined('ALTUMCODE') || die() ?>

<?php

use Altum\Alerts;

$user = $data->user;

$userLanguage =  user_language($user);
$userLanguageCode = \Altum\Language::$active_languages[$userLanguage] ? \Altum\Language::$active_languages[$userLanguage] : null;


if (!$data->suspendsubcription && !$data->clientSecret) {
    if ($user->plan_id != 8 && $user->plan_id != 5) {
        try {
            $stripe = new \Stripe\StripeClient(settings()->stripe->secret_key);
            try {
                $intents = $stripe->setupIntents->create([
                    'customer' => $user->stripe_customer_id,
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



<div class="pay-update-container container-fluid px-5">
    <div class="bill-detail r-4 mt-2">
        <div class="triel">
            <div class="description-wrp">
                <div class="triel-icon d-flex exp-error">
                    <svg class="MuiSvgIcon-root expire-icon MuiSvgIcon-fontSizeMedium MuiSvgIcon-root MuiSvgIcon-fontSizeLarge css-1shn170" focusable="false" aria-hidden="true" viewBox="0 0 24 24" data-testid="ErrorIcon" tabindex="-1" title="Error">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"></path>
                    </svg>
                </div>

                <div class="triel-des ">
                    <p class="bil-des bil-des1 exp-error exp-message"><br class="d-none"> <?= l('billing.suspend_subscription_payment_method_description') ?>
                    </p>
                </div>

            </div>

            <?php if (url(\Altum\Routing\Router::$original_request) == (url('qr-codes')) || url(\Altum\Routing\Router::$original_request) == (url('analytics'))) : ?>
                <a href="<?= url('plan') ?>" class="btn btn-light r-4" style=""><?= l('qr_codes.active_account') ?></a>
            <?php endif ?>
        </div>
    </div>
    <div class="update-payment-full-wrap">
        <div class="update-payment-heading">
            <h1 class="pay-update-header-text">Update Your Payment Method</h1>
        </div>
        <div class="row update-payment-wrap">
            <div class="col-lg-7 col-xxl-7 p-0 update-pay-left">
                <div class="container-fluid fullCard rounded">
                    <!-- <hr class="pay-update-hr mt-4"> -->
                    <div class="cardupdate-detail-window">
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
                                        <div class="row w-100 justify-content-sm-end m-auto pt-3">
                                            <!-- <hr class="pay-update-hr stripe-update-hr d-none d-sm-block"> -->
                                            <div class="col-md col-sm-6 col-xl-4 col-12 pay-update-btn-wrap">
                                                <button class="btn w-100 primary-btn update-btn pay-update-btn" id="submit">
                                                    <div class="spinner hidden" id="spinner"></div>
                                                    <span class="text" id="button-text"><?= l('billing.update') ?></span>
                                                </button>
                                            </div>
                                            <hr class="pay-update-hr stripe-update-hr d-none d-sm-block">
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
            <div class="col-lg-5 col-xxl-5 p-0 update-pay-right">
                <?php include_once(THEME_PATH . '/views/partials/delinquent-plan.php') ?>
            </div>
        </div>
    </div>
</div>


<?php ob_start() ?>

<script src="https://js.stripe.com/v3/"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

<script>


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

    // Change button text on mobile devices
    const updateButton = document.getElementById('button-text');
    const isMobile = /Mobi|Android/i.test(navigator.userAgent);
    if (isMobile) {
        updateButton.textContent = 'Update plan';
    }

    var email = "<?php echo isset($user->billing->email) ? $user->billing->email : $user->email; ?>";
    var country = "<?php echo isset($user->billing->country) ? $user->billing->country : $user->country; ?>";

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
                    return_url: "<?= SITE_URL ?>update-payment-method/change?referral_key=<?= $_GET['referral_key'] ?>",
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
                    $('.update-btn').attr("disabled", false);
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
                    return_url: "<?= SITE_URL ?>update-payment-method/change?referral_key=<?= $_GET['referral_key'] ?>",
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
                    $('.update-btn').attr("disabled", false);
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
</script>
<?php \Altum\Event::add_content(ob_get_clean(), 'javascript') ?>