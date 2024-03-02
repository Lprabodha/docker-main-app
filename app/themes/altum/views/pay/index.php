<?php
    defined('ALTUMCODE') || die() ;
    use Altum\Alerts;
    $planId  = $data->plan->plan_id;

    $user  = $data->user;
    $user_email                 = $user->email;
    $user_name                  = $user->name;
    $user_id                    = $user->user_id;
    $unique_id                  = isset($user->unique_id) ? $user->unique_id : null;
    $user_country               = isset($user->billing->country) && $user->billing->country != ''   ? $user->billing->country : $user->country;
    $user_zip                   = isset($user->billing->zip) ? $user->billing->zip : null;
    $user_postal_code           = isset($user->billing->postal_code) ? $user->billing->postal_code : null;
    $user_billing_name          = isset($user->billing->name) ? $user->billing->name : null;
    $total_logins               = $user->total_logins;
    $user_source                = $user->source;
    $user_payment_processor     = $user->payment_processor;
    $ref_key                    = isset($data->ref_key) ? $data->ref_key : null;
    $userCurrency               =  $user->payment_currency;

    $rate = null;
    $symbol = null;
    $code = null;
    if ($exchange_rate = exchange_rate($user)) {
        $rate   = $exchange_rate['rate'];
        $symbol = $exchange_rate['symbol'];
        $code   = $exchange_rate['code'];
    }

    $total   = get_plan_price($planId, $code);
    $price = get_plan_month_price($planId, $code); 

    $currency = 'USD';
    $countryCurrency = get_user_currency($code);
    if($userCurrency && $userCurrency !=''){
        $currency = $userCurrency;   
    }else if($countryCurrency){            
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


try {

    $stripe = $data->stripe;
    $customerId = $data->customerId;

    if (isset($_SESSION['clientSecret']) &&  $_SESSION['clientSecret'] != '') {
        $clientSecret = $_SESSION['clientSecret'];
    } else {
        try {
            if ($planId == 5) {
                $payment_intent = $stripe->paymentIntents->create([
                    'customer' => $customerId,
                    'amount' => get_stripe_format($total,$currency ),
                    'currency' => $currency,
                    'payment_method_types' => ['card'], // Specify the payment method type.
                    'description' => 'One-time payment',
                    'metadata' => [
                        'plan_id' => $planId,
                        'payment_frequency' => 'onetime',
                    ]
                ]);
               
                $clientSecret = $payment_intent->client_secret;
                $_SESSION['clientSecret'] = $clientSecret;
            } else {               
                if ($data->discount) {
                    $subscription = $stripe->subscriptions->create([
                        'customer' => $customerId,                            
                        'items' => [[
                            'price' => $priceId,   
                        ]],
                        'coupon' => $couponCode,
                        'payment_behavior' => 'default_incomplete',
                        'payment_settings' => ['save_default_payment_method' => 'on_subscription'],
                        'expand' => ['latest_invoice.payment_intent'],
                        'currency'=>$currency
                    ]);
                } else {
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
                }
                $clientSecret = $subscription->latest_invoice->payment_intent->client_secret;
                $_SESSION['clientSecret'] = $clientSecret;
            }               
        } catch (Exception $e) {
            Alerts::add_error(l('pay.error_message.payment_gateway'));
        }
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

                            <div class="pay-info-btn-area desktop-view payInfoBtn" style="margin-top: 15px;">
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
                        <h2 class="payment-subhead"><?= l('pay.billing_info') ?></h2>

                        <div class="payment-contact-info">
                            <p class="payment-small-head my-2"><?= l('pay.information') ?></p>
                            <div class="payment-detail-field row">
                                <div class="payment-form-group col">
                                    <div class="payment-input-field d-flex">
                                        <div class="payment-input-icons-field m-auto d-flex" id="icon_area">
                                            <span class="icon-profile grey input-icon"></span>
                                        </div>
                                        <input type="text" name="" id="pay_name" value="<?php echo $user_billing_name ?>" class="pay-form-control" readonly required="required" />
                                    </div>
                                </div>
                                <div class="payment-form-group payment-edit-warp col-auto" id="edit-email" onclick="returnInfo()">
                                    <div class="payment-edit-area">
                                        <span class="icon-edit grey payment-edit-icon mx-auto d-flex"></span>
                                    </div>
                                </div>
                            </div>
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
                        </div>
                        <div class="payment-method-info-wrap mt-4">
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
                                            <div class="back-btn d-flex" onclick="returnInfo()">
                                                <span class="icon-arrow-right paymethod-icon"></span>
                                                <p class="btn-text"><?= l('pay.return_to_contact') ?></p>
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
                                                <?= l('pay.submit_payment') ?>
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- summery plan -->
                    <?php

                    include_once(THEME_PATH . '/views/partials/summery-plan.php') ?>

                </div>
            </div>
        </div>
    </div>
</div>



<?php ob_start() ?>


<script src="https://js.stripe.com/v3/"></script>
<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script>
    function scrollToTop() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }

    <?php 
        $userLanguage =  user_language($user);
        $userLanguageCode = \Altum\Language::$active_languages[$userLanguage] ? \Altum\Language::$active_languages[$userLanguage] : null;
    ?>

    var scrollToTopBtn = document.querySelector('.payInfoBtn');
    scrollToTopBtn.addEventListener('click', scrollToTop);
    // Address element
    const stripe = Stripe('<?php echo settings()->stripe->publishable_key ?>', {
        locale: '<?= $userLanguageCode ?>',
    });



    const info = {
        name: "<?= isset($data->info->name) ? $data->info->name : '' ?>",
        address: {
            line1: "<?= isset($data->info->line1) ? $data->info->line1 : '' ?>",
            line2: "<?= isset($data->info->line2) ? $data->info->line2 : '' ?>",
            city: "<?= isset($data->info->city) ? $data->info->city : '' ?>",
            country: "<?= isset($data->info->country) && $data->info->country != '' ? $data->info->country : ($user_country ? $user_country : get_country_code()) ?>",
            state: "<?= isset($data->info->state) ? $data->info->state : '' ?>",
            province: "<?= isset($data->info->province) ? $data->info->province : '' ?>",
            zip: "<?= isset($data->info->zip) ? $data->info->zip : '' ?>",
            postal_code: "<?= isset($data->info->postal_code) ? $data->info->postal_code : '' ?>",
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

    // Card Element
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


        var country = $('#country').val();
        var postal_code = $('#postal_code').val();
        var planId = "<?php echo $data->plan->plan_id; ?>";
        var email = "<?php echo $user_email; ?>";
        var ref_key = "<?php echo $ref_key; ?>";  
        var currency = "<?php echo $currency; ?>";  
            
        var radarSessionId;		
		const {radarSession, error} = await stripe.createRadarSession();
		if (error) {    
			console.error(error);
		} else {   
			radarSessionId =  radarSession.id;
		}  

        stripe.confirmPayment({
            elements,
            confirmParams: {
                // Make sure to change this to your payment completion page
                return_url: "<?= SITE_URL ?>pay/" + planId + "?ref=" + ref_key + "&currency=" + currency ,
                payment_method_data: {
                    billing_details: {
                        email: email,
                        address: {
                            country: country,
                            postal_code: postal_code,
                        }
                    },
                    radar_options : {
                        session : radarSessionId,
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

    })


    function returnInfo() {
        $('.pay-user-info').removeClass('d-none');
        $('#menu-payment').removeClass('active');

        $('.card-detail-area').addClass('d-none');


    }

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
</script>

<script>
    if ("<?php echo $user_payment_processor ==  '' ?>") {
        // Data Layer Implementation (GTM)
        var checkoutEvent = "begin_checkout";

        var checkoutData = {
            "userId": "<?php echo $user_id ?>",
            'plan_name': "<?php echo $data->plan->name ?>",
            'plan_value': "<?php echo $total ?>",
            'plan_currency': "<?= $currency  ?>",
            'user_type': '<?php echo $user->total_logins == '1' ? 'New User' : 'Returning User' ?>',
            'method': '<?php echo $user->source == 'direct' ? 'Email' : 'Google' ?>',
            'entry_point': '<?php echo $user->total_logins == '1' ? 'Signup' : 'Signin' ?>',
             
        }
        googleDataLayer(checkoutEvent, checkoutData);
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