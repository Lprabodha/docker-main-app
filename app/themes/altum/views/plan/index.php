<?php defined('ALTUMCODE') || die() ?>

<?php

if (isset($data->planId)) {
    $plan  = db()->where('plan_id', $data->planId)->getOne('plans');
}


$code = null;
$currentUser = $data->user;
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
        if (currentUrl.includes("promo=70OFF") || currentUrl.includes("upgrade") || currentUrl.includes("renew") || currentUrl.includes("type=onetime") || currentUrl.includes("type=discounted")) {
            $(".plans-wrap").removeClass("isHomeFriday");
            $(".plans-wrap").removeClass("isFriday");
            $(".package-header-heading").removeClass("default-package-heading");
            $(".plan-friday-wrap").addClass("d-none");
        }

        if (currentUrl.includes("renew")) {
            $(".blackFriday-package-heading").addClass("d-none");
        }

    });
</script>

<div class="bg-light">
    <div class="container-fluid plans-wrap">
        <!-- to add Friday or other banner add this class for plans wrap "isHomeFriday" -->
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

            <?php if (\Altum\Middlewares\Authentication::check() && $data->user->plan_is_expired && $data->user->plan_id != 'free') : ?>
                <div class="alert alert-info" role="alert">
                    <?= l('global.info_message.user_plan_is_expired') ?>
                </div>
            <?php endif ?>

            <?php if ($data->type == 'new') : ?>
                <?php if ($data->discount) : ?>

                    <h1 class="plan-header"><?= sprintf(l('private_plan.plan.title_discount'), $data->discount . '%') ?></h1>
                    <p class="text-muted  plan-subheader"><?= l('private_plan.plan.subtitle_discount') ?></p>

                <?php elseif ($data->planId) : ?>

                    <?php if ($data->planId == 4) : ?>
                        <h1 class="plan-header"><?= (l('public_plan.plan.title_discounted')) ?></h1>
                        <p class="text-muted  plan-subheader"><?= (l('public_plan.plan.subtitle_discounted')) ?></p>
                    <?php endif ?>

                    <?php if ($data->planId == 5) : ?>
                        <h1 class="plan-header"><?= l('public_plan.plan.header_onetime') ?></h1>
                        <p class="text-muted  plan-subheader"><?= l('public_plan.plan.subheader_onetime') ?></p>
                    <?php endif ?>

                <?php else : ?>

                    <h1 class="plan-header"><?= l('private_plan.plan.title_new') ?></h1>
                    <p class="text-muted  plan-subheader"><?= l('private_plan.plan.subtitle_new') ?></p>
                <?php endif ?>
            <?php elseif ($data->type == 'renew') : ?>
                <h1 class="plan-header"><?= l('private_plan.plan.title_renew') ?></h1>
                <p class="text-muted plan-subheader"><?= l('private_plan.plan.subtitle_renew') ?></p>

            <?php elseif ($data->type == 'upgrade') : ?>

                <h1 class="plan-header"><?= l('private_plan.plan.title_upgrade') ?></h1>
                <p class="text-muted plan-subheader"><?= l('private_plan.plan.subtitle_upgrade') ?></p>

            <?php endif ?>


            <?php
            ?>
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
        if (<?php echo isset($data->user->user_id)  ?>) {
            var event = "upgrade_account_start";
            var data = {
                "userId": "<?php echo  $data->user->user_id  ?>",
                'user_type': '<?php echo $data->user->total_logins == '1' ? 'New User' : 'Returning User' ?>',
                'method': '<?php echo $data->user->source == 'direct' ? 'Email' : 'Google' ?>',
                'entry_point': '<?php echo $data->user->total_logins == '1' ? 'Signup' : 'Signin' ?>',
                 
            }
            googleDataLayer(event, data);
        }
    });

    if ($(".plans-header-wrp").children(".black-friday-full-wrap")) {
        // $(".plans-wrap").addClass("isFriday");
    } else {
        // $(".plans-wrap").removeClass("isFriday");
    }

    $(".plan-friday-btn").on("click", function() {
        $('html, body').scrollTop($(".plan-subheader").offset().top);
    });
</script>

<?php if (isset($data->user->user_id) && $data->user->payment_processor == '') : ?>
    <script>
        // Data Layer Implementation (GTM)
        $(document).on('click', '.add-to-cart', function() {
            var event = "add_to_cart";

            var data = {
                "userId": "<?php echo $data->user ? $data->user->user_id : 'null' ?>",
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