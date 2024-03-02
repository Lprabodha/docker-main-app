<?php

use Altum\Date;

defined('ALTUMCODE') || die() ?>

<?php

$price   = $data->plan->monthly_price;
$planId  = $data->plan->plan_id;
$user    = $data->user;
$info = $data->info;

$user_email                 = $user->email;
$user_name                  = $user->name;
$user_id                    = $user->user_id;
$unique_id                  = isset($user->unique_id) ? $user->unique_id : null;
$user_country               = isset($info->country) && $info->country != ''   ? $info->country : $user->country;
$user_zip                   = isset($info->zip) ? $info->zip : null;
$user_postal_code           = isset($info->postal_code) ? $info->postal_code : null;
$user_billing_name          = isset($info->name) ? $info->name : null;
$customerId                 = $data->customerId;
$currentUser                = $user;  
$userCurrency               =  $user->payment_currency; 


$rate = null;
$symbol = null;
$code = null;
if ($exchange_rate = exchange_rate($currentUser )) {
    $rate   = $exchange_rate['rate'];
    $symbol = $exchange_rate['symbol'];
    $code   = $exchange_rate['code'];
}

$total   = get_plan_price($planId, $code);
$price   =  get_plan_month_price($planId, $code);


$currency = 'USD';
$countryCurrency = get_user_currency($code);
if($userCurrency && $userCurrency !=''){
    $currency = $userCurrency;   
}else if($countryCurrency){            
    $currency = $code;    
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


switch ($planId) {
    case 1:
        $name = l('resubscribe_checkout.pay_billing.1_month_plan');
        $priceId = STRIPE_PRICE_1_ID;        
        break;
    case 2:
        $name = l('resubscribe_checkout.pay_billing.12_month_plan');
        $priceId = STRIPE_PRICE_12_ID;        
        break;
    case 3:
        $name = l('resubscribe_checkout.pay_billing.3_month_plan');
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

                
}

switch ($user->plan_id) {
    case 1:
        $currentName = l('resubscribe_checkout.pay_billing.1_month_plan');
        break;
    case 2:
        $currentName = l('resubscribe_checkout.pay_billing.12_month_plan');
        break;
    case 3:
        $currentName = l('resubscribe_checkout.pay_billing.3_month_plan');
        break;
    default:
        $currentName = l('resubscribe_checkout.pay_billing.1_month_plan');
}

$stripe = $data->stripe;

if ($planId == 5) {
    $payment_intent = $stripe->paymentIntents->create([
        'customer' => $customerId,
        'amount' => get_stripe_format($total, $currency),
        'currency' => $currency,
        'payment_method_types' => ['card'], // Specify the payment method type.
        'description' => 'One-time payment',
        'metadata' => [
            'plan_id' => $planId,
            'payment_frequency' => 'onetime',
        ]
    ]);
   
    $clientSecret = $payment_intent->client_secret;
}else if ($planId == 4) {
    $subscription = $stripe->subscriptions->create([
        'customer' => $customerId,                            
        'items' => [[
            'price' => $priceId,   
        ]],      
        'payment_behavior' => 'default_incomplete',
        'payment_settings' => ['save_default_payment_method' => 'on_subscription'],
        'expand' => ['latest_invoice.payment_intent'],
        'currency'=>$currency
    ]);
    $clientSecret = $subscription->latest_invoice->payment_intent->client_secret;
}else{
    $intents = $stripe->setupIntents->create([
        'customer' => $data->customerId,
        'payment_method_types' => ['card'],
    ]);
    $clientSecret = $intents->client_secret;
    
}


?>

<div class="bg-light">
    <div class="container payment-full-wrap">
        <div class="payment-wrap">
            <?= \Altum\Alerts::output_alerts() ?>

            <div class="payment-form-wrap">
                <div class="pay-personal-detail-form">
                    <div class="row full-wrap">
                        <div class="col-xl-7  pay-user-info pt-4 <?= $data->view_info ?  '' : 'd-none' ?> ">
                            <form action="" class="detail-form" method="post" role="form" id="infoForm">

                                <input type="hidden" name="token" value="<?= \Altum\Middlewares\Csrf::get() ?>" />
                                <input type="hidden" id="address" name="address">
                                <input type="hidden" name="user_id" value="<?= $user_id ?>">
                                <input type="hidden" name="email" value="<?= $user_email ?>">
                                <input type="hidden" name="customer_id" value="<?= $customerId ?>">
                                <input type="hidden" id="country" value="<?php echo $user_country; ?>">
                                <input type="hidden" id="postal_code" value="<?php echo $user_zip ? $user_zip : $user_postal_code; ?>">

                                <h2 class="pay-subheading" style="margin-bottom: 20px;"><?= l('pay.billing_info') ?></h2>

                                <div class="pay-form">
                                    <div id="address-element">
                                    </div>
                                </div>

                                <div class="pay-info-btn-area desktop-view payInfoBtn" style="margin-top: 15px;" >
                                    <button type="button" name="submitBtn" class="btn pay-btn" onclick="submitForm()" id="infoSubmit">
                                        <div class="btn-head d-flex">
                                            <div class="hidden" id="infoSpinner" style="margin-right: 10px;">
                                                <svg viewBox="25 25 50 50" class="new-spinner">
                                                    <circle r="20" cy="50" cx="50"></circle>
                                                </svg>
                                            </div>

                                            <div class="btn-heading">
                                                <span><?= sprintf(l('pay.submit')) ?></span>
                                            </div>
                                            <div class="btn-icon">
                                                <span class="icon-arrow-right pay-arrow"></span>
                                            </div>
                                        </div>
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div class="col-xl-7 card-detail-area pt-4 <?= $data->view_info ?  'd-none' : '' ?>">
                            <h2 class="payment-subhead"><?= l('resubscribe_checkout.pay_billing.billing_info') ?></h2>

                            <div class="payment-contact-info">
                                <p class="payment-small-head my-2"><?= l('resubscribe_checkout.pay_billing.information') ?></p>
                                <div class="payment-detail-field row">
                                    <div class="payment-form-group col">
                                        <div class="payment-input-field d-flex">
                                            <div class="payment-input-icons-field m-auto d-flex" id="icon_area">
                                                <span class="icon-profile grey input-icon"></span>
                                            </div>
                                            <input type="email" name="" id="pay_email" value="<?php echo $info->name ?>" class="pay-form-control" readonly required="required" />
                                        </div>
                                    </div>
                                    <div class="payment-form-group payment-edit-warp col-auto" id="edit-email" onclick="returnInfo()">
                                        <div class="payment-edit-area">
                                            <span class="icon-edit grey payment-edit-icon mx-auto d-flex"></span>
                                        </div>
                                    </div>
                                </div>
                                <p class="payment-small-head my-2"><?= l('resubscribe_checkout.pay_billing.plan') ?></p>
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
                            </div>

                            <?php if ($planId != 5) : ?>
                            <div class="payment-detail-field row">
                                <div class="payment-form-group col">
                                    <p><?= l('resubscribe_checkout.pay_billing.payment_detail_1') ?> (<?= $currentName ?>) <?= l('resubscribe_checkout.pay_billing.payment_detail_2') ?> <?= (new \DateTime($user->plan_expiration_date))->format('M d, Y ')  ?> <?= l('resubscribe_checkout.pay_billing.payment_detail_3') ?> (<?= $name ?>) <?= l('resubscribe_checkout.pay_billing.payment_detail_4') ?> <?= (new \DateTime($user->plan_expiration_date))->format('M d, Y ')  ?>.</p>
                                </div>
                            </div>

                            <?php endif ?>
                            <div class="payment-method-info-wrap mt-4">
                                <h2 class="payment-subhead"><?= l('resubscribe_checkout.pay_billing.payment_method') ?></h2>
                            </div>
                            <!-- Display a payment form -->
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
                                            <div class="back-btn d-flex" onclick="returnInfo()">
                                                <span class="icon-arrow-right paymethod-icon"></span>
                                                <p class="btn-text"><?= l('pay.return_to_contact') ?></p>
                                            </div>
                                        </button>
                                        
                                    </div>
                                    <div class="pay-btn-wrap">
                                        <button class="btn payment" id="submit" type="submit">
                                            <div class="spinner hidden" id="spinner"></div>
                                            <span id="button-text">
                                                <?= l('resubscribe_checkout.pay_billing.submit_payment') ?>
                                            </span>
                                        </button>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <!-- summery plan -->
                        <?php include_once(THEME_PATH . '/views/partials/summery-plan.php') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php ob_start() ?>


<?php 
    $userLanguage =  user_language($user);
    $userLanguageCode = \Altum\Language::$active_languages[$userLanguage] ? \Altum\Language::$active_languages[$userLanguage] : null;
?>

<script src="https://js.stripe.com/v3/"></script>
<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script>

    const stripe = Stripe('<?php echo settings()->stripe->publishable_key ?>', {
        locale: '<?= $userLanguageCode ?>',
    });

    function scrollToTop() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }
    var scrollToTopBtn = document.querySelector('.payInfoBtn');
    scrollToTopBtn.addEventListener('click', scrollToTop);

    const info = {
        name: "<?= isset($info->name) ? $info->name : '' ?>",
        address: {
            line1: "<?= isset($info->line1) ? $info->line1 : '' ?>",
            line2: "<?= isset($info->line2) ? $info->line2 : '' ?>",
            city: "<?= isset($info->city) ? $info->city : '' ?>",
            country: "<?= isset($info->country) && $info->country != '' ? $info->country : ($user_country ? $user_country : get_country_code()) ?>",
            state: "<?= isset($info->state) ? $info->state : '' ?>",
            province: "<?= isset($info->province) ? $info->province : '' ?>",
            zip: "<?= isset($info->zip) ? $info->zip : '' ?>",
            postal_code: "<?= isset($info->postal_code) ? $info->postal_code : '' ?>",
        }
    };

    const options = {
        appearance: {
            theme: 'stripe',
        }
    };

    const infoElements = stripe.elements(options);
    const addressElement = infoElements.create("address", {
        mode: "billing",
        display: {
            name: 'full',
        },
        defaultValues: info,
    });
    addressElement.mount("#address-element");
    
    const elements = stripe.elements({
        clientSecret: '<?= $clientSecret ?>'
    });
    const paymentElementOptions = {
        layout: {
            type: 'tabs',
            defaultCollapsed: false,
        },
        fields: {
            billingDetails: {
                address: {
                    country: 'never',
                    postalCode: 'never'
                }
            }
        }
    };
    const paymentElement = elements.create("payment", paymentElementOptions);
    paymentElement.mount("#payment-element");

    const form = document.getElementById('payment-form');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        setLoading(true);
        var planId = "<?php echo $planId; ?>";
        var country = "<?php echo $info->country; ?>";
        var postal_code = "<?php echo $info->zip ? $info->zip : $info->postal_code; ?>";
        var email = "<?php echo $info->email ? $info->email : $user->email; ?>";
        var ref_id = "<?php echo  $user->referral_key; ?>";
        var priceId = "<?php echo $priceId; ?>";
        var total = "<?php echo $total; ?>";

        if(planId ==5 || planId ==4 ){

            stripe.confirmPayment({
            elements,
            confirmParams: {
                // Make sure to change this to your payment completion page
                return_url: "<?= SITE_URL ?>reactive-plan/" + planId + "&total=" + total + "&id=" + ref_id  ,
                payment_method_data: {
                    billing_details: {
                        email: email,
                        address: {
                            country: country,
                            postal_code: postal_code,
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

        }else{

            stripe.confirmSetup({
                elements,
                confirmParams: {
                    // Make sure to change this to your payment completion page
                    return_url: "<?= SITE_URL ?>reactive-plan/" + planId + "?priceId=" + priceId + "&total=" + total + "&id=" + ref_id <?= $data->discount ? ' + "&code='.$couponCode.'"' : ''?> ,
                    payment_method_data: {
                        billing_details: {

                            email: email,
                            address: {
                                country: country,
                                postal_code: postal_code,
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

    })


    var myForm = document.getElementById("info-form");
    myForm.addEventListener('submit', submitForm);

    function submitForm(e) {
        var addEle = infoElements.getElement('address');

        addEle.getValue()
            .then(function(result) {
                    if (result.complete) {
                        setInfoLoading(true);
                        $('#address').val(JSON.stringify(result.value));
                        var form = $("#infoForm")[0];
                        var formData = new FormData(form);
                        formData.append('action', 'savePayInfo');
                        $.ajax({
                            type: 'POST',
                            url: '<?php echo url('api/ajax') ?>',
                            data: formData,
                            dataType: 'json',
                            contentType: false,
                            processData: false,
                            success: function(response) {                               
                                setInfoLoading(false);
                                $('.pay-user-info').addClass('d-none');
                                $('#menu-payment').addClass('active');
                                $('.card-detail-area').removeClass('d-none');
                                $('#pay_name').val(response.data.name);
                                $('#country').val(response.data.country);
                                $('#postal_code').val(response.data.postal_code);

                            },
                            error: () => {
                                /* Re enable submit button */
                                // submit_button.removeClass('disabled').text(text);
                            },

                        });


                    } else {
                        var errorElement = null;
                        var stripeElements = document.querySelector('.StripeElement iframe');
                        var scrollDiv = document.getElementsByClassName(".StripeElement iframe").offsetTop;
                        if (result.value.name == '') {
                            window.scrollTo(0, 72);
                        } else if (result.value.address.line1 == '') {
                            window.scrollTo(0, 229);
                        } else if (result.value.address.city == '') {
                            window.scrollTo(0, 391);
                        } else if (result.value.address.state == '') {
                            window.scrollTo(0, 463);
                        } else if (result.value.address.postal_code == '') {
                            window.scrollTo(0, 542);
                        } else {
                            window.scrollTo(0, 526);
                        }
                    }
                
            });
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

    function returnInfo() {
        $('.pay-user-info').removeClass('d-none');
        $('#menu-payment').removeClass('active');
        $('.card-detail-area').addClass('d-none');
    }

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

</script>




<script>
    $(document).on('click', '.pay-back-btn', function() {

        var event = "cta_click";

        var data = {
            "userId": "<?php echo $user->user_id ?>",
            "clicktext": "Return to Contact",
             
        }
        googleDataLayer(event, data);
    });
</script>

<?php \Altum\Event::add_content(ob_get_clean(), 'javascript') ?>