<?php if ( $this->user->plan_expiration_date > \Altum\Date::$date && $this->user->plan_id == "free" && ($this->user->payment_subscription_id == null || $this->user->payment_subscription_id == '')) : ?>
    <div class="container-fluid free-trial-full-wrap">
        <div class="free-trial-wrap">
            <span class="free-trial-text"><?= l('qr_codes.trail_banner.text') ?><a href="<?= $this->user->plan_id == 'free' ||  new DateTime($this->user->plan_expiration_date) < new DateTime() ? url('plan') : url('billing') ?>" class="trial-url-text"><?= l('qr_codes.trail_banner.upgrade') ?>.</a></span>
        </div>
    </div>
<?php endif ?>