<?php
$user = null;
$payments = [];

if (isset($_GET['ref'])) {                
    $refUser  = db()->where('referral_key', $_GET['ref'])->getOne('users');            
}  
$user = isset($this->user->user_id) ? $this->user : $refUser;  

$plan_id = $_GET['plan_id'] ?? null;

if($plan_id && $user ){
   
    $plan = (new \Altum\Models\Plan())->get_plan_by_id($plan_id);
    $coupon   =  null;
    $price    = $plan->monthly_price;
    $payments =  db()->where('user_id', $user->user_id)->get('payments');

    


    if (count($payments) == 1) {
        if (isset($_SESSION['discount'])) {
            $price     = round($price - $price / 100 * $_SESSION['discount'], 2);
            $plan_name = $plan->name . '- promo' . $_SESSION['discount'];
            $coupon    = 'Promo70';
        } else {
            if ($plan->plan_id == 2) {
                $plan_name = $plan->name . '-DPF';
            } else {
                $plan_name = $plan->name;
            }
        }
    
        if ($plan->plan_id == 2) {
            $item_name = $plan->name . '-DPF';
        } else {
            $item_name = $plan->name;
        }
    
        if (isset($_GET['currency'])) {
            $currency = $_GET['currency'];
        } else {
            $currency = 'USD';
        }
    
    
        $total = get_plan_price($plan_id, $currency);
       
        $discount_amount       =  null;
        if (isset($_SESSION['discount'])) {
            $discount_amount = round($total / 100 * $_SESSION['discount'], 2);
        }

        $currentUrl = SITE_URL . \Altum\Routing\Router::$original_request;
        $entryPoint = null;     
        if($currentUrl == url('pay-thank-you-dpf')){
            $entryPoint = 'DPF';
        }else{
            $entryPoint = $user->total_logins == '1' ? 'Signup' : 'Signin';
        }
    }
}

?>

<?php if ($plan_id && count($payments) == 1 && !isset($_SESSION['purchase_event'])) :  ?>
    <?php $_SESSION['purchase_event'] = true; ?>
    <script>
        let current_url = new URL(window.location.href);
        let unique_transaction_identifier = current_url.searchParams.get('payment_intent');
        let currency = '<?= $currency ?>';

        let plan_name = '<?= $plan_name ?>';
        let plan_id = '<?= $plan_id ?>';
        let total_amount = '<?= $total ?>';
        let discount = '<?= $discount_amount ?>';
        let coupon = '<?= $coupon ?>';
        let item_name = '<?= $item_name ?>';
        let user_id = '<?= $user->user_id ?>';
        let email = '<?= $user->email ?>';
        let postal_code = '<?= isset($user->billing->postal_code) ? $user->billing->postal_code : null; ?>';
        let is_production = '<?= APP_CONFIG ?>';
        let entry_point = '<?= $entryPoint ?>';

        // Data Layer Implementation (GTM)
        window.addEventListener('load', (event) => {
            var event = "purchase";
            var purchaseData = {
                "userId": "<?= $user->user_id  ?>",
                'plan_name': plan_name,
                'item_name': item_name,
                'plan_id': plan_id,
                'plan_value': total_amount,
                'discount': discount,
                'coupon': coupon,
                'plan_currency': currency,
                'transaction_id': unique_transaction_identifier,
                'user_type': '<?php echo $user->total_logins == '1' ? 'New User' : 'Returning User' ?>',
                'method': '<?php echo $user->source == 'direct' ? 'Email' : 'Google' ?>',
                'entry_point': entry_point,                
                'email' :email,             
            }
            googleDataLayer(event, purchaseData);          
        });
    </script>
<?php endif ?>

