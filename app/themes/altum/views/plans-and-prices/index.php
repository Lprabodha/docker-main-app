<?php defined('ALTUMCODE') || die() ?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
<link href="<?= ASSETS_FULL_URL . 'css/qr-icons.css?v=' . PRODUCT_CODE ?>" rel="stylesheet" media="screen,print">
<link rel="stylesheet" href="<?= ASSETS_FULL_URL . 'css/dashboard-styles.css' ?>">

<?php

if (isset($data->planId)) {
    $plan  = db()->where('plan_id', $data->planId)->getOne('plans');
}

$currentUser = $data->user ? $data->user : null;

$code = null;
if ($exchange_rate = exchange_rate($currentUser)) {
    $symbol = $exchange_rate['symbol'];
    $code   = $exchange_rate['code'];
}

if (get_user_currency($code)) {
    $currencySymbol = $symbol;
    $currency = $code;
} else {
    $currency = 'USD';
    $currencySymbol = '$';
}


?>

<script>
    $(document).ready(function() {
        var currentUrl = window.location.href;
        if (currentUrl.includes("promo=70OFF") || currentUrl.includes("type=onetime") || currentUrl.includes("type=discounted")) {
            $(".70promo").removeClass("isHomeFriday");
            $(".plan-friday-wrap").addClass("d-none");
            $(".plans-header-wrp").addClass("fridayWrap");
        } else if (currentUrl.includes("id=")) {
            $(".70promo").addClass("promoFriday");
            $(".plans-header-wrp").addClass("fridayWrap");
        } else {
            $(".plan-friday-wrap").addClass("d-block");
            $(".70promo").removeClass("promoFriday");
        }
    });
</script>


<div class="bg-light">
    <div class="container-fluid plans-wrap">
        <!-- add to Black Friday Banner or other banner Please add this classes "isHomeFriday 70promo" -->
        <div class="container-fluid plans">
            <div>
                <?php
                if ($data->qrCount > 0) {
                    include_once(THEME_PATH . '/views/plan/expire-banner.php');
                }
                ?>
            </div>
            <div class="icon-area" id="icon-area">
                <a href="<?= isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] :  url('billing') ?>" style="color: transparent;">
                    <div class="icon">
                        <span class="icon-arrow-right back-icon"></span>
                    </div>
                </a>
            </div>
            <?php if ($data->discount) : ?>
                <h1 class="plan-header"><?= sprintf(l('public_plan.plan.title_discount'), $data->discount . '%') ?></h1>
                <p class="text-muted  plan-subheader"><?= l('public_plan.plan.subtitle_discount') ?></p>
            <?php elseif ($data->planId) : ?>


                <?php if ($data->planId == 4) : ?>
                    <h1 class="plan-header"><?= sprintf(l('public_plan.plan.title_discounted'), '$' . $plan->monthly_price) ?></h1>
                    <p class="text-muted  plan-subheader"><?= l('public_plan.plan.subtitle_discounted') ?></p>
                <?php endif ?>

                <?php if ($data->planId == 5) : ?>
                    <h1 class="plan-header"><?= l('public_plan.plan.header_onetime') ?></h1>
                    <p class="text-muted  plan-subheader"><?= l('public_plan.plan.subheader_onetime') ?></p>
                <?php endif ?>

            <?php else : ?>

                <h1 class="plan-header"><?= l('public_plan.plan.title_new') ?></h1>
                <p class="text-muted  plan-subheader"><?= l('public_plan.plan.subtitle_new') ?></p>
            <?php endif ?>

            <div class="container-fluid bill-wrap mt-5 pb-5">
                <?= $this->views['plans'] ?>
            </div>
        </div>
        <div>
            <!-- question sections -->
            <?php include_once(THEME_PATH . '/views/partials/plan_question.php') ?>
        </div>
    </div>
</div>

<?php foreach (['libraries/popper.min.js', 'libraries/bootstrap.min.js'] as $file) : ?>
    <script src="<?= ASSETS_FULL_URL ?>js/<?= $file ?>?v=<?= PRODUCT_CODE ?>"></script>
<?php endforeach ?>

<?php if ($data->user && $data->user->user_id) : ?>
    <?php

    $userLogin  = $data->user->total_logins;
    $userSource = $data->user->source;

    ?>

    <script>
        // Data Layer Implementation (GTM)
        window.addEventListener('load', (event) => {

            var event = "upgrade_account_start";
            var data = {
                "userId": "<?php echo  isset($this->user->user_id) ? $this->user->user_id : $data->user->user_id  ?>",
                'user_type': '<?php echo $userLogin == '1' ? 'New User' : 'Returning User' ?>',
                'method': '<?php echo $userSource == 'direct' ? 'Email' : 'Google' ?>',
                'entry_point': '<?php echo $userSource == '1' ? 'Signup' : 'Signin' ?>',
                 
            }
            googleDataLayer(event, data);

        });
    </script>
<?php endif ?>


<?php if (isset($data->user) && $data->user->payment_processor == '') : ?>
    <script>
        // Data Layer Implementation (GTM)
        $(document).on('click', '.add-to-cart', function() {
            var event = "add_to_cart";

            var data = {
                "userId": "<?php echo $data->user->user_id ?>",
                'plan_name': $(this).data('plan-name'),
                'plan_value': $(this).data('plan-price'),
                'plan_currency': "<?= $currency  ?>",
                'user_type': '<?php echo  $data->user->total_logins == '1' ? 'New User' : 'Returning User' ?>',
                'method': '<?php echo $data->user->source == 'direct' ? 'Email' : 'Google' ?>',
                'entry_point': '<?php echo $data->user->total_logins == '1' ? 'Signup' : 'Signin' ?>',
                'funnel': '<?php echo $data->user->onboarding_funnel == '3' ? 'cff' : ($data->user->onboarding_funnel == '2' ? 'nsf' : 'default' ) ?>',
                            }
            googleDataLayer(event, data);
        })
    </script>
<?php endif ?>