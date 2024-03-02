<?php defined('ALTUMCODE') || die() ?>

<?php

if (isset($data->planId)) {
    $plan  = db()->where('plan_id', $data->planId)->getOne('plans');
}
$currentUser =  $this->user; 


$code = null;
if ($exchange_rate = exchange_rate($currentUser)) {           
    $symbol = $exchange_rate['symbol'];
    $code   = $exchange_rate['code'];
}

if(get_user_currency($code)){            
    $currencySymbol = $symbol;
    $currency = $code;
}else{
    $currency = 'USD';
    $currencySymbol = '$';
}

$currentUrl = SITE_URL . \Altum\Routing\Router::$original_request;
?>

<div class="bg-light">
    <div class="container-fluid plans-wrap">
        <div class="container-fluid plans">
            <div>
                <?php
                if ($data->qrCount !== "0") {
                    include_once(THEME_PATH . '/views/plan/expire-banner.php');
                }
                ?>
            </div>
            <div class="icon-area " id="icon-area" style="color: transparent;">
                <a href="<?= url('billing') ?>">
                    <div class="icon">
                        <span class="icon-arrow-right back-icon"></span>
                    </div>
                </a>
            </div>
            <?= \Altum\Alerts::output_alerts() ?>

            <?php if (\Altum\Middlewares\Authentication::check() && $this->user->plan_is_expired && $this->user->plan_id != 'free') : ?>
                <div class="alert alert-info" role="alert">
                    <?= l('global.info_message.user_plan_is_expired') ?>
                </div>
            <?php endif ?>

            <h1 class="plan-header"><?= $currentUrl == url('plan-rdpf/upgrade') ? l('private_plan.plan.title_upgrade') : l('private_plan.plan.title_upgrade_dpf') ?></h1>
            <p class="text-muted plan-subheader"><?= l('private_plan.plan.subtitle_upgrade') ?></p>
           
            <div class="container-fluid bill-wrap pb-6">
                <?= $this->views['plans'] ?>
            </div>
        </div>
        <div>

            <!-- question sections -->
            <?php include_once(THEME_PATH . '/views/partials/plan_question.php') ?>
        </div>
    </div>
</div>

<script>
    var url = window.location.href;
    var icon_area = document.getElementById("icon-area");

    function getLastPart(url) {
        const parts = url.split('/');
        return parts.at(-1);
    }

    if (getLastPart(url) == "plan" || getLastPart(url) == "plans-and-prices") {
        icon_area.style.visibility = "hidden";
    } else {
        icon_area.style.visibility = "visible";
    }

    // Data Layer Implementation (GTM)
    window.addEventListener('load', (event) => {
        if (<?php echo isset($this->user->user_id)  ?>) {
            var event = "upgrade_account_start";
            var data = {
                "userId": "<?php echo  $this->user->user_id  ?>",
                'user_type': '<?php echo $this->user->total_logins == '1' ? 'New User' : 'Returning User' ?>',
                'method': '<?php echo $this->user->source == 'direct' ? 'Email' : 'Google' ?>',
                'entry_point': '<?php echo $this->user->total_logins == '1' ? 'Signup' : 'Signin' ?>',
                 
            }
            googleDataLayer(event, data);
        }
    });
</script>

<?php if (isset($this->user->user_id) && $this->user->payment_processor == '') : ?>
    <script>
        // Data Layer Implementation (GTM)
        $(document).on('click', '.add-to-cart', function() {
            var event = "add_to_cart";

            var data = {
                "userId": "<?php echo $this->user ? $this->user->user_id : 'null' ?>",
                'plan_name': $(this).data('plan-name'),
                'plan_value': $(this).data('plan-price'),
                'plan_currency': "<?= $currency  ?>",
                'user_type': '<?php echo $this->user->total_logins == '1' ? 'New User' : 'Returning User' ?>',
                'method': '<?php echo $this->user->source == 'direct' ? 'Email' : 'Google' ?>',
                'entry_point': '<?php echo $this->user->total_logins == '1' ? 'Signup' : 'Signin' ?>',
                'funnel': '<?php echo $this->user->onboarding_funnel == '3' ? 'cff' : ($this->user->onboarding_funnel == '2' ? 'nsf' : 'default' ) ?>',
                            }
            googleDataLayer(event, data);
        })
    </script>
<?php endif ?>