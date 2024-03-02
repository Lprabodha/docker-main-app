<?php defined('ALTUMCODE') || die() ?>

<?php

$price = $data->plan->monthly_price;
$planId  = $data->plan_id;
$user     = $data->user;  
$userCurrency    =  $user->payment_currency; 

$rate = null;
$symbol = null;
$code = null;
if ($exchange_rate = exchange_rate($user)) {
    $rate   = $exchange_rate['rate'];
    $symbol = $exchange_rate['symbol'];
    $code   = $exchange_rate['code'];
}

$price   = get_plan_month_price($planId, $code);
$total   = $price;

$currency = 'USD';
$countryCurrency = get_user_currency($code);
if($userCurrency && $userCurrency !=''){
    $currency = $userCurrency;   
}else if($countryCurrency){            
    $currency = $code;    
}

switch ($planId) {
    case 1:        
        $name = l('upgrade_checkout.pay_billing.1_month_plan'); 
        $priceId = STRIPE_PRICE_1_ID;        
        break;
    case 2:       
        $name = l('upgrade_checkout.pay_billing.12_month_plan');    
        $priceId = STRIPE_PRICE_12_ID;        
        break;
    case 3:      
        $name = l('upgrade_checkout.pay_billing.3_month_plan'); 
        $priceId = STRIPE_PRICE_3_ID;       
        break;
    case 4:
        $name = l('upgrade_checkout.pay_billing.discounted_plan');
        $priceId = STRIPE_PRICE_1_DISCOUNTED_ID;
        break;
    case 5:
        $name = l('upgrade_checkout.pay_billing.onetime_plan');
        $priceId = STRIPE_PRICE_ONETIME_ID;
        break;
    default:       
        $name = l('upgrade_checkout.pay_billing.1_month_plan');
        $priceId = STRIPE_PRICE_1_ID;       
}

switch ($user->plan_id) {
    case 1:        
        $currentName = l('upgrade_checkout.pay_billing.1_month_plan');         
        break;
    case 2:       
        $currentName = l('upgrade_checkout.pay_billing.12_month_plan'); 
        break;
    case 3:      
        $currentName = l('upgrade_checkout.pay_billing.3_month_plan');       
        break;
    case 6:      
        $currentName = l('upgrade_checkout.pay_billing.14_day_full_plan');       
        break;
    case 7:      
        $currentName = l('upgrade_checkout.pay_billing.14_day_limited_plan');       
        break;
    default:       
        $currentName = l('upgrade_checkout.pay_billing.1_month_plan');      
}

?> 

<div class="bg-light">
    <div class="container payment-full-wrap">
    <?= \Altum\Alerts::output_alerts() ?>
        <div class="payment-wrap">
            
            <div class="payment-form-wrap">
                <form action="change-plan-dpf/update" class="pay-personal-detail-form" method="post" enctype="multipart/form-data" role="form">
                    <input type="hidden" name="user_id" value="<?= $user->user_id ?>" />     
                    <input type="hidden" name="plan_id" value="<?= $user->plan_id ?>" /> 
                    <input type="hidden" name="new_plan_id" value="<?= $planId ?>" /> 
                    <input type="hidden" name="plan_name" value="<?= $data->plan->name ?>" />
                    <input type="hidden" name="total_amount" value="<?= $total ?>" />          
                    <input type="hidden" name="priceId" value="<?= $priceId ?>" /> 
                    <input type="hidden" name="token" value="<?= \Altum\Middlewares\Csrf::get() ?>" />
                    <input type="hidden" name="currency" value="<?= $currency ?>" />

                    <div class="row full-wrap">
                        <div class="payment-detail-area col-xl-7 pt-4">
                            <h2 class="payment-subhead"><?= l('upgrade_checkout.pay_billing.billing_info') ?></h2>

                            <div class="payment-contact-info">
                                <p class="payment-small-head my-2"><?= l('upgrade_checkout.pay_billing.plan') ?></p>
                                <div class="payment-detail-field row">
                                    <div class="payment-form-group col">
                                        <div class="payment-input-field d-flex">
                                            <div class="payment-input-icons-field m-auto d-flex" id="icon_area2">
                                                <span class="icon-document grey input-icon"></span>
                                            </div>
                                            <input type="text" name="" id="plan_type" value="<?php echo  $data->plan->name ?>" class="pay-form-control" readonly required="required" />
                                        </div>
                                    </div>
                                    <div class="payment-form-group payment-edit-warp col-auto" id="edit-plan" onclick="editUpgrade()">
                                        <div class="payment-edit-area">
                                            <span class="icon-edit grey payment-edit-icon mx-auto d-flex"></span>
                                        </div>
                                    </div>
                                </div>

                                <p class="payment-small-head my-2"><?= l('upgrade_checkout.pay_billing.upgrade_downgrade_summary') ?></p>
                                <div class="payment-detail-field row">
                                    <div class="payment-form-group col">
                                        <p><?= l('upgrade_checkout.pay_billing.payment_detail_1_1') ?> (<?= $currentName ?>) <?= l('upgrade_checkout.pay_billing.payment_detail_2') ?> <?= (new \DateTime($user->plan_expiration_date))->format('M d, Y ')  ?> <?= l('upgrade_checkout.pay_billing.payment_detail_3_2') ?> (<?=$name?>) <?= l('upgrade_checkout.pay_billing.payment_detail_4') ?> <?= (new \DateTime($user->plan_expiration_date))->format('M d, Y ')  ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="paymethod-btn-area payment-desktop-view">
                                <div class="back-btn-wrap">
                                    <a href="<?= url('plan-rdpf') ?>">
                                        <button type="button" class="btn pay-back-btn payInfoBtn">
                                            <div class="back-btn d-flex" >
                                                <span class="icon-arrow-right paymethod-icon"></span>
                                                <p class="btn-text"><?= l('pay.plan') ?></p>
                                            </div>
                                        </button>
                                    </a>
                                </div>
                                <div class="pay-btn-wrap">
                                    <button class="btn payment" id="submit" type="submit">
                                        <div class="spinner hidden" id="spinner"></div>
                                        <span id="button-text">
                                            <?= l('upgrade_checkout.pay_billing.update_plan') ?>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>                    
                </form>
                <?php include_once(THEME_PATH . '/views/partials/summery-plan.php') ?>

            </div>
        </div>
    </div>
</div>

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