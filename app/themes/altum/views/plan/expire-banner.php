<?php
if ($this->user->user_id != null || $this->user->user_id != '') {
    $user = $this->user;
} else if (isset($data->user)) {
    $user = $data->user;
} else {
    $user = null;
}



$stripe = new \Stripe\StripeClient(settings()->stripe->secret_key);
$activeStripeSubcription = db()->where('user_id', $this->user->user_id)->orderBy('id', 'DESC')->getOne('subscriptions');

if (isset($user->stripe_customer_id)) {
    if ($activeStripeSubcription) {
        try {
            $activeStripeSubcription = $stripe->subscriptions->retrieve(
                $activeStripeSubcription->subscription_id,
                []
            );
        } catch (\Stripe\Exception\ApiErrorException $e) {
            $activeStripeSubcription   = null;
        }
    } else {

        if($user->stripe_customer_id){
            try {
                $activeStripeSubcription = $stripe->subscriptions->all(
                    ['customer' => $user->stripe_customer_id]
                );
    
                if ($activeStripeSubcription) {
                    $activeStripeSubcription = $activeStripeSubcription['data'][0];
                }
            } catch (\Stripe\Exception\ApiErrorException $e) {
                $activeStripeSubcription = null;
            }
        }else{
            $activeStripeSubcription = null;
        }
        
    }

    if ($activeStripeSubcription && $activeStripeSubcription->status == 'past_due' && (new DateTime($this->user->plan_expiration_date) < new DateTime())) {
        $suspendsubcription  = $activeStripeSubcription;
    } else {
        $suspendsubcription = null;
    }
}

?>
<?php if ($user && $user->plan_id == 'free' && new DateTime($user->plan_expiration_date) < new DateTime()) : ?>
    <div class="bill-detail r-4 mt-2">
        <div class="triel">
            <div class="description-wrp">
                <div class="triel-icon d-flex exp-error">
                    <svg class="MuiSvgIcon-root expire-icon MuiSvgIcon-fontSizeMedium MuiSvgIcon-root MuiSvgIcon-fontSizeLarge css-1shn170" focusable="false" aria-hidden="true" viewBox="0 0 24 24" data-testid="ErrorIcon" tabindex="-1" title="Error">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"></path>
                    </svg>


                </div>
                <?php if ($user->payment_processor != '') : ?>
                    <?php if (url(\Altum\Routing\Router::$original_request) == (url('plan'))) : ?>
                        <div class="triel-des ">
                            <p class="bil-des bil-des1 exp-error exp-message"><?= isset($suspendsubcription) ?  l('billing.suspend_subscription_description')  :  l('private_plan.plan_expire_line_1')  . '<br class="d-none"> '  . l('private_plan.plan_expire_line_2') ?>
                            </p>
                        </div>
                    <?php else : ?>
                        <div class="triel-des ">
                            <?php if (isset($suspendsubcription)) : ?>
                                <p class="bil-des bil-des1 exp-error <?= isset($data->page) && $data->page == 'qr-codes' ? 'exp-error-scale-remove' : '' ?> "><?= l('billing.suspend_subscription_description') ?></p>
                            <?php else : ?>
                                <p class="bil-des bil-des1 exp-error <?= isset($data->page) && $data->page == 'qr-codes' ? 'exp-error-scale-remove' : '' ?> "><?= l('qr_codes.plan_expire_line_1') ?> <br class="d-none"> <?= l('qr_codes.plan_expire_line_2') ?>
                                </p>
                            <?php endif ?>

                        </div>
                    <?php endif ?>

            </div>
            <?php if (url(\Altum\Routing\Router::$original_request) == (url('qr-codes')) || url(\Altum\Routing\Router::$original_request) == (url('analytics'))) : ?>
                <a href="<?= url('plan/renew') ?>" class="btn btn-light r-4" style=""><?= l('qr_codes.active_account') ?></a>
            <?php endif ?>

        <?php else : ?>

            <?php if (url(\Altum\Routing\Router::$original_request) == (url('plan'))) : ?>
                <div class="triel-des ">
                    <p class="bil-des bil-des1 exp-error exp-message"><?= l('private_plan.trial_expire_line_1') ?> <br class="d-none"> <?= l('private_plan.trial_expire_line_2') ?>
                    </p>
                </div>
            <?php else : ?>
                <div class="triel-des ">
                    <p class="bil-des bil-des1 exp-error"><?= l('qr_codes.trial_expire_line_1') ?> <br class="d-none"> <?= l('qr_codes.trial_expire_line_2') ?>
                    </p>
                </div>
            <?php endif ?>

        </div>

        <?php if (url(\Altum\Routing\Router::$original_request) == (url('qr-codes')) || url(\Altum\Routing\Router::$original_request) == (url('analytics'))) : ?>
            <a href="<?= url('plan') ?>" class="btn btn-light r-4" style=""><?= l('qr_codes.active_account') ?></a>
        <?php endif ?>

    <?php endif ?>
    </div>
    </div>

<?php endif ?>