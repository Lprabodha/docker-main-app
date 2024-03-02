<?php defined('ALTUMCODE') || die() ?>
<?php ob_start() ?>

<?php

$price = $data->plan->monthly_price;
$planId  = $data->plan->plan_id;


switch ($data->plan->plan_id) {
    case 1:
        $name = l('pay_billing.1_month_plan');
        $total = $price;
        break;
    case 2:
        $name = l('pay_billing.12_month_plan');
        $total = $price * 12;
        break;
    case 3:
        $name = l('pay_billing.3_month_plan');
        $total = $price * 3;
        break;
    default:
        $name = l('pay_billing.1_month_plan');
        $total = $price;
}
?>


<div class="bg-light">
    <div class="container pay-info">
        <div class="pay-info-wrap">
            <?= \Altum\Alerts::output_alerts() ?>

            <nav aria-label="breadcrumb" class="d-none">
                <ol class="custom-breadcrumbs small">
                    <li><a href="<?= url() ?>"><?= l('index.breadcrumb') ?></a> <i class="fa fa-fw fa-angle-right"></i></li>
                    <li><a href="<?= url('plan') ?>"><?= l('plan.breadcrumb') ?></a> <i class="fa fa-fw fa-angle-right"></i></li>
                    <li class="active" aria-current="page"><?= l('pay_billing.breadcrumb') ?></li>
                </ol>
            </nav>

            <div class="row info-area">
                <div class="col-xl-7  pay-user-info">
                    <form action="" class="detail-form" method="post" role="form" id="info-form">

                    <input type="hidden" name="token" value="<?= \Altum\Middlewares\Csrf::get() ?>" />
                    <input type="hidden" id="address" name="address">
                    <h2 class="pay-subheading" style="margin-bottom: 20px;"><?= l('pay_billing.subheader') ?></h2>

                        <div class="pay-form">

                            <div id="address-element">
                            </div>

                        </div>

                        <div class="pay-info-btn-area desktop-view payInfoBtn" id="" style="margin-top: 15px;">
                            <button type="button" name="submitBtn" class="btn pay-btn" onclick="submitForm()">
                                <div class="btn-head d-flex">
                                    <div class="btn-heading">
                                        <span><?= sprintf(l('pay_billing.submit'), $data->plan->name) ?></span>
                                    </div>
                                    <div class="btn-icon">
                                        <span class="icon-arrow-right pay-arrow"></span>
                                    </div>
                                </div>
                            </button>
                        </div>
                    </form>
                </div>
                <?php include_once(THEME_PATH . '/views/partials/summery-plan.php') ?>
            </div>

        </div>
    </div>
</div>
</div>

<?php ob_start() ?>

<?php 
    $userLanguage =  user_language($this->user);
    $userLanguageCode = \Altum\Language::$active_languages[$userLanguage] ? \Altum\Language::$active_languages[$userLanguage] : null;
?>

<script src="https://js.stripe.com/v3/"></script>

<script>
      function scrollToTop() {
        window.scrollTo({
        top: 0,
        behavior: 'smooth'
        });
    }

    window.addEventListener('scroll', function() {
        var scrollToTopBtn = document.querySelector('.payInfoBtn');
        // if (window.scrollY >= 200) {
        // scrollToTopBtn.style.display = 'block';
        // } else {
        // scrollToTopBtn.style.display = 'none';
        // }
    });

    var  scrollToTopBtn = document.querySelector('.payInfoBtn');
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
            country: "<?= isset($data->info->country) ? $data->info->country : get_country_code() ?>",
            state: "<?= isset($data->info->state) ? $data->info->state : '' ?>",
            province: "<?= isset($data->info->province) ? $data->info->province : '' ?>",
            zip: "<?= isset($data->info->zip) ? $data->info->zip : '' ?>",
            postal_code: "<?= isset($data->info->postal_code) ? $data->info->postal_code : ''?>",
        }
    };

    
    const options = {
        appearance: {
            theme: 'stripe',

        }
    };

    const elements = stripe.elements(options);
    const addressElement = elements.create("address", {
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

        var addEle = elements.getElement('address');

        addEle.getValue()
            .then(function(result) {
                if (result.complete) {
                    $('#address').val(JSON.stringify(result.value));
                    myForm.submit();


                    if ("<?php echo $this->user->payment_processor ==  '' ?>") {
                        // Data Layer Implementation (GTM)
                        var checkoutEvent = "begin_checkout";

                        var checkoutData = {
                            "userId": "<?php echo $this->user ? $this->user->user_id : 'null' ?>",
                            'plan_name': "<?php echo $data->plan->name ?>",
                            'plan_value': "<?php echo $total ?>",
                            'plan_currency': "<?php echo settings()->payment->currency  ?>",
                            'user_type': '<?php echo $this->user->total_logins == '1' ? 'New User' : 'Returning User' ?>',
                            'method': '<?php echo $this->user->source == 'direct' ? 'Email' : 'Google' ?>',
                            'entry_point': '<?php echo $this->user->total_logins == '1' ? 'Signup' : 'Signin' ?>',
                            
                        }
                        googleDataLayer(checkoutEvent, checkoutData);
                    }


                } else {
                    var errorElement = null;
                    var stripeElements = document.querySelector('.StripeElement iframe');
                    var scrollDiv = document.getElementsByClassName(".StripeElement iframe").offsetTop;
                    console.log(result.value);
                    if(result.value.name == '') {
                        window.scrollTo(0,72);
                    }else if(result.value.address.line1 == '') {
                        window.scrollTo(0,229);
                    }else if(result.value.address.city == '') {
                        window.scrollTo(0,391);
                    }else if(result.value.address.state == '') {
                        window.scrollTo(0,463);
                    }else if(result.value.address.postal_code == '') {
                        window.scrollTo(0,542);
                    }else{
                        window.scrollTo(0,526);
                    }
                }
            });
        }
    </script>

<script type="text/javascript">

    // window.onscroll = (e)=>{
    //     console.log(window.visualViewport.pageTop);
    // }
</script>

<?php \Altum\Event::add_content(ob_get_clean(), 'javascript') ?>