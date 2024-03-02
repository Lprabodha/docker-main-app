<?php defined('ALTUMCODE') || die() ?>

<?php

$price = $data->plan->monthly_price;
$planId  = $data->plan_id;

$rate   = null;
$symbol = null;
$code   = null;

$user_email                 = $data->user->email;
$user_name                  = $data->user->name;
$user_id                    = $data->user->user_id;
$user_country               = isset($data->info->country) && $data->info->country != ''   ? $data->info->country : $data->user->country;
$user_zip                   = isset($data->info->zip) ? $data->info->zip : null;
$user_postal_code           = isset($data->info->postal_code) ? $data->info->postal_code : null;
$user_billing_name          = isset($data->info->name) ? $data->info->name : null;
$customerId                 = $data->customerId;
$currentUser                = $data->user;
$userCurrency               = $data->user->payment_currency;


if ($exchange_rate = exchange_rate($currentUser)) {
    $rate   = $exchange_rate['rate'];
    $symbol = $exchange_rate['symbol'];
    $code   = $exchange_rate['code'];
}


$currency = 'USD';
$countryCurrency = get_user_currency($code);
if ($userCurrency && $userCurrency != '') {
    $currency = $userCurrency;
} else if ($countryCurrency) {
    $currency = $code;
}

$total = get_plan_price($planId, $code);
$price = get_plan_month_price($planId, $code);




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

}

switch ($data->user->plan_id) {
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

                    <div class="payment-detail-area card-detail-area col-xl-7 pt-4 <?= $data->view_info ?  'd-none' : '' ?>">
                        <form action="change-plan/update" class="pay-personal-detail-form" method="post" enctype="multipart/form-data" role="form">
                            <input type="hidden" name="plan_id" value="<?= $data->user->plan_id ?>" />
                            <input type="hidden" name="user_id" value="<?= $data->user->user_id ?>" />
                            <input type="hidden" name="new_plan_id" value="<?= $planId ?>" />
                            <input type="hidden" name="plan_name" value="<?= $data->plan->name ?>" />
                            <input type="hidden" name="total_amount" value="<?= $total ?>" />
                            <input type="hidden" name="priceId" value="<?= $priceId ?>" />
                            <input type="hidden" name="token" value="<?= \Altum\Middlewares\Csrf::get() ?>" />
                            <input type="hidden" name="currency" value="<?= $currency ?>" />

                            <h2 class="payment-subhead"><?= l('upgrade_checkout.pay_billing.billing_info') ?></h2>

                            <div class="payment-contact-info">
                                <p class="payment-small-head my-2"><?= l('upgrade_checkout.pay_billing.information') ?></p>
                                <div class="payment-detail-field row">
                                    <div class="payment-form-group col">
                                        <div class="payment-input-field d-flex">
                                            <div class="payment-input-icons-field m-auto d-flex" id="icon_area">
                                                <span class="icon-profile grey input-icon"></span>
                                            </div>
                                            <input type="email" name="" id="pay_name" value="<?php echo $user_name ?>" class="pay-form-control" readonly required="required" />
                                        </div>
                                    </div>
                                    <div class="payment-form-group payment-edit-warp col-auto" id="edit-email" onclick="returnInfo()">
                                        <div class="payment-edit-area">
                                            <span class="icon-edit grey payment-edit-icon mx-auto d-flex"></span>
                                        </div>
                                    </div>
                                </div>
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

                                <?php if ($planId != 5) : ?>

                                    <p class="payment-small-head my-2"><?= l('upgrade_checkout.pay_billing.upgrade_downgrade_summary') ?></p>
                                    <div class="payment-detail-field row">
                                        <div class="payment-form-group col">
                                            <p><?= l('upgrade_checkout.pay_billing.payment_detail_1_1') ?> (<?= $currentName ?>) <?= l('upgrade_checkout.pay_billing.payment_detail_2') ?> <?= (new \DateTime($data->user->plan_expiration_date))->format('M d, Y ')  ?> <?= l('upgrade_checkout.pay_billing.payment_detail_3_2') ?> (<?= $name ?>) <?= l('upgrade_checkout.pay_billing.payment_detail_4') ?> <?= (new \DateTime($data->user->plan_expiration_date))->format('M d, Y ')  ?></p>
                                        </div>
                                    </div>
                                <?php endif ?>

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
                                            <?= l('upgrade_checkout.pay_billing.update_plan') ?>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <?php include_once(THEME_PATH . '/views/partials/summery-plan.php') ?>

                </div>
            </div>
        </div>
    </div>

    <script src="https://js.stripe.com/v3/"></script>
    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>

    <script>
        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }
        var scrollToTopBtn = document.querySelector('.payInfoBtn');
        scrollToTopBtn.addEventListener('click', scrollToTop);

        const stripe = Stripe('<?php echo settings()->stripe->publishable_key ?>');

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
                                console.log(response);
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


        function returnInfo() {
            $('.pay-user-info').removeClass('d-none');
            $('#menu-payment').removeClass('active');
            $('.card-detail-area').addClass('d-none');
        }



        $(document).on('click', '.pay-back-btn', function() {
            var event = "cta_click";
            var data = {
                "userId": "<?php echo $data->user->user_id ?>",
                "clicktext": "Return to Contact",

            }
            googleDataLayer(event, data);
        });
    </script>

    <?php \Altum\Event::add_content(ob_get_clean(), 'javascript') ?>