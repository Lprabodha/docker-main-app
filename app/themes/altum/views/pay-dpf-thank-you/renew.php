<?php defined('ALTUMCODE') || die() ?>

<div class="container-fluid pay-thank-wrap mt-3">
    <?= \Altum\Alerts::output_alerts() ?>

    <div class="thank-you">
        <!-- <img src="<?= ASSETS_FULL_URL . 'images/thank_you.svg' ?>" class="col-10 col-md-6 col-lg-4 mb-4" alt="
        
        
        <?= l('pay_dpf.thankyou_header') ?>" /> -->

        <h2 class="thank-header"><?= l('pay_dpf.thankyou_header') ?></h2>

        <?php if (isset($_GET['schedule_id'])) : ?>
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 ">
                    <h3 class="thank-subhead"><?= l('pay_dpf.thankyou_subheader_1') ?></h3>
                </div>
            </div>

        <?php elseif (isset($_GET['reactive_schedule_id'])) : ?>
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 ">
                    <h3 class="thank-subhead"><?= l('pay_dpf.thankyou_subheader_2') ?></h3>
                </div>
            </div>
        <?php else : ?>

            <div class="row justify-content-center">
                <div class="col-12 col-md-8 ">
                    <h3 class="thank-subhead"><?= l('pay_dpf.thankyou_subheader_3') ?></h3>
                </div>
            </div>

        <?php endif ?>

        <div class="thank-btn-area">
        <div class="thank-btn-area">
            <?php if (Altum\Middlewares\Authentication::check()) : ?>
                <a href="<?= url('qr-codes') ?>" class="btn thank-btn mt-4 mx-auto d-block" style="padding:10px 15px;"><?= l('pay_thank_you.button') ?></a>
            <?php else : ?>
                <a href="<?= url('login') ?>" class="btn thank-btn mt-4 mx-auto d-block" style="padding:10px 15px;"><?= l('pay_thank_you.button') ?></a>
            <?php endif ?>
        </div>
        </div>
    </div>
</div>

<?php ob_start() ?>

<?php 
    $plan = $data->plan;
    $payments = [];
    $user   = isset($this->user->user_id) ? $this->user : $data->user;
    $planId = $plan ? $plan->plan_id : $_GET['plan_id']; 

    $payments =  db()->where('user_id', $user->user_id)->get('payments');

    if(count($payments) == 1){
        if (isset($_SESSION['discount'])) {
            $price     = round($price - $price / 100 * $_SESSION['discount'], 2);
            $plan_name = $plan->name . '- promo' . $_SESSION['discount'];
            $coupon    = 'Promo70';
        } else {
            $plan_name = $plan->name;
        }
       
        switch ($planId) {
            case 1:
                $total        = $price;
                $basic_amount = $plan->monthly_price;
                break;
            case 2:
                $total        = $price * 12;
                $basic_amount = $plan->monthly_price * 12;
                break;
            case 3:
                $total        = $price * 3;
                $basic_amount = $plan->monthly_price * 3;
                break;
            default:
                $total = $price;
        }

        $discount_amount       =  null;
        if (isset($_SESSION['discount'])) {
            $discount_amount = round($basic_amount / 100 * $_SESSION['discount'], 2);
        }
        $coupon                =  null;
        
    }
    
?>

<script>
   var isBackFromPay = sessionStorage.getItem("is_back");
	if (isBackFromPay) {
		sessionStorage.removeItem("is_back");
	}
</script>
<?php \Altum\Event::add_content(ob_get_clean(), 'javascript') ?>