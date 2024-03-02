<?php

use Altum\Date;

defined('ALTUMCODE') || die() ?>

<?php

$price = $data->plan->monthly_price;
$planId  = $data->plan->plan_id;
$currentUser  = $data->user; 
$userCurrency    =  $data->user->payment_currency; 


$rate = null;
$symbol = null;
$code = null;
if ($exchange_rate = exchange_rate($currentUser)) {
    $rate   = $exchange_rate['rate'];
    $symbol = $exchange_rate['symbol'];
    $code   = $exchange_rate['code'];
}else{
    $code = 'USD';
}

$price   = get_plan_month_price($planId, $code);
$total   = get_plan_price($planId, $code);;

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
    default:
        $name    = l('pay.1_month_plan');
        $priceId = STRIPE_PRICE_1_ID;
                
}

switch ($currentUser->plan_id) {
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

?>

<?php
   
    $stripe = new \Stripe\StripeClient(settings()->stripe->secret_key);    

    if ($planId == 5) {
        $payment_intent = $stripe->paymentIntents->create([
            'customer' => $currentUser->stripe_customer_id,
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
       
    }else{
        $intents = $stripe->setupIntents->create([
            'customer' => $currentUser->stripe_customer_id,
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
                            
                        </div>
                        
                          <div class="payment-detail-field row">
                                <div class="payment-form-group col">
                                    <p><?= l('resubscribe_checkout.pay_billing.payment_detail_1') ?> (<?= $currentName ?>) <?= l('resubscribe_checkout.pay_billing.payment_detail_2') ?> <?= (new \DateTime($currentUser->plan_expiration_date))->format('M d, Y ')  ?> <?= l('resubscribe_checkout.pay_billing.payment_detail_3') ?> (<?= $name ?>) <?= l('resubscribe_checkout.pay_billing.payment_detail_4') ?> <?= (new \DateTime($currentUser->plan_expiration_date))->format('M d, Y ')  ?>.</p>
                                </div>
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

    const form = document.getElementById('payment-form');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        setLoading(true);
        var planId = "<?php echo $planId; ?>";
        var priceId = "<?php echo $priceId; ?>";
        var total = "<?php echo $total; ?>";
        var pm  = '<?= $data->paymentMethod->payment_method; ?>';
        var email = "<?php echo $currentUser->email; ?>";
        var ref_id = "<?php echo  $currentUser->referral_key; ?>";

        if(planId ==5 ){

            stripe.confirmPayment({
                elements,
                confirmParams: {
                    // Make sure to change this to your payment completion page
                    return_url: "<?= SITE_URL ?>reactive-plan-dpf/" + planId + "?total=" + total + "&id=" + ref_id ,
                    payment_method_data: {
                        billing_details: {
                            email: email,                       
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
                    return_url: "<?= SITE_URL ?>reactive-plan-dpf/" + planId + "?priceId=" + priceId + "&total=" + total + "&id=" + ref_id <?= $data->discount ? ' + "&code='.$couponCode.'"' : ''?>,
                    payment_method_data: {
                        billing_details: {
                            email: email,                       
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

    function showPaymentMethod() {
       if($('.payment-element').hasClass('d-none')){
            $('.payment-element').removeClass('d-none');
            $('.btn-element').addClass('d-none');
       }else{
        $('.payment-element').addClass('d-none');
        $('.btn-element').removeClass('d-none');
       }
    }
   
    function updateSubscription(){
       
        var planId = "<?php echo $planId; ?>";
        var priceId = "<?php echo $priceId; ?>";
        var total = "<?php echo $total; ?>";
        var pm  = '<?= $data->paymentMethod->payment_method; ?>';
        var ref_id = "<?php echo  $currentUser->referral_key; ?>";
        
        setPmLoading(true);

        if(planId ==5){
          
            var pi = '<?php echo $payment_intent->id; ?>';
            var url = "<?= SITE_URL ?>reactive-plan-dpf/" + planId + "?total=" + total + "&pm=" + pm + "&id=" + ref_id + "&pi=" + pi;           
        }else{
            var url = "<?= SITE_URL ?>reactive-plan-dpf/" + planId + "?priceId=" + priceId + "&total=" + total + "&pm=" + pm + "&id=" + ref_id <?= $data->discount ? ' + "&code='.$couponCode.'"' : ''?>;
         
        }       
        window.location.href = url;
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

        var event = "cta_click";

        var data = {
            "userId": "<?php echo $currentUser->user_id ?>",
            "clicktext": "Return to Contact",
             
        }
        googleDataLayer(event, data);
    });
</script>

<?php \Altum\Event::add_content(ob_get_clean(), 'javascript') ?>