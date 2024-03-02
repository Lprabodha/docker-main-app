<?php defined('ALTUMCODE') || die(); ?>
<?php
$billings_result = database()->query("SELECT * FROM `billings` WHERE `status` = 1 ORDER BY `order`");
?>
<div class="row justify-content-around">
    <?php if (settings()->billing_guest->status == 1) : ?>

        <div class="col-12 col-lg-4 mb-4">
            <div class="card pricing-card h-100" style="<?= settings()->billing_guest->color ? 'border-color: ' . settings()->billing_guest->color : null ?>">
                <div class="card-body d-flex flex-column">

                    <div class="mb-3">
                        <div class="font-weight-bold text-center text-uppercase pb-2 text-muted border-bottom border-gray-200"><?= settings()->billing_guest->name ?></div>
                    </div>

                    <div class="mb-4 text-center">
                        <div class="h1">
                            <?= settings()->billing_guest->price ?>
                        </div>
                        <div>
                            <span class="text-muted"><?= settings()->billing_guest->description ?></span>
                        </div>
                    </div>

                    <?= include_view(THEME_PATH . 'views/partials/billings_billing_content.php', ['billing_settings' => settings()->billing_guest->settings]) ?>
                </div>

                <div class="p-3">
                    <button type="button" class="btn btn-block btn-primary disabled cclr" disabled="disabled"><?= l('billing.button.choose') ?></button>
                </div>
            </div>
        </div>

    <?php endif ?>

    <?php if (settings()->billing_free->status == 1) : ?>

        <div class="col-12 col-lg-4 mb-4">
            <div class="card pricing-card h-100" style="<?= settings()->billing_free->color ? 'border-color: ' . settings()->billing_free->color : null ?>">
                <div class="card-body d-flex flex-column">

                    <div class="mb-3">
                        <div class="font-weight-bold text-center text-uppercase pb-2 text-muted border-bottom border-gray-200"><?= settings()->billing_free->name ?></div>
                    </div>

                    <div class="mb-4 text-center">
                        <div class="h1">
                            <?= settings()->billing_free->price ?>
                        </div>
                        <div>
                            <span class="text-muted"><?= settings()->billing_free->description ?></span>
                        </div>
                    </div>

                    <?= include_view(THEME_PATH . 'views/partials/billings_billing_content.php', ['billing_settings' => settings()->billing_free->settings]) ?>
                </div>

                <div class="p-3">
                    <a href="<?= url('register') ?>" class="btn btn-block btn-primary cclr <?= \Altum\Middlewares\Authentication::check() && $this->user->billing_id != 'free' ? 'disabled' : null ?>"><?= l('billing.button.choose') ?></a>
                </div>
            </div>
        </div>

    <?php endif ?>

    <?php if (settings()->payment->is_enabled) : ?>

        <?php foreach ($billings as $billing) : ?>

            <?php $billing->settings = json_decode($billing->settings) ?>
            <?php $annual_price_savings = ceil(($billing->monthly_price * 12) - $billing->annual_price); ?>

            <div class="col-12 col-lg-4 mb-4" data-billing-monthly="<?= json_encode((bool) $billing->monthly_price) ?>" data-billing-annual="<?= json_encode((bool) $billing->annual_price) ?>" data-billing-lifetime="<?= json_encode((bool) $billing->lifetime_price) ?>">
                <div class="card pricing-card h-100" style="<?= $billing->color ? 'border-color: ' . $billing->color : null ?>">
                    <div class="card-body d-flex flex-column">

                        <div class="mb-3">
                            <div class="font-weight-bold text-center text-uppercase pb-2 text-muted border-bottom border-gray-200"><?= $billing->name ?></div>
                        </div>

                        <div class="mb-4 text-center">
                            <div class="h1 d-none" data-billing-payment-frequency="monthly"><?= $billing->monthly_price ?></div>
                            <div class="h1 d-none" data-billing-payment-frequency="annual"><?= $billing->annual_price ?></div>
                            <div class="h1 d-none" data-billing-payment-frequency="lifetime"><?= $billing->lifetime_price ?></div>

                            <span class="h5 text-muted">
                                <?= settings()->payment->currency ?>
                            </span>

                            <div>
                                <span class="text-muted">
                                    <?= $billing->description ?>
                                </span>

                                <?php if ($billing->monthly_price) : ?>
                                    <span class="d-none" data-billing-payment-frequency="annual"><span class="badge badge-success">- <?= $annual_price_savings . ' ' . settings()->payment->currency ?></span></span>
                                <?php endif ?>
                            </div>
                        </div>

                        <?= include_view(THEME_PATH . 'views/partials/billings_billing_content.php', ['billing_settings' => $billing->settings]) ?>
                    </div>

                    <div class="p-3">
                        <a href="<?= url('register?redirect=pay/' . $billing->billing_id) ?>" class="btn btn-block btn-primary">
                            <?php if (\Altum\Middlewares\Authentication::check()) : ?>
                                <?php if (!$this->user->billing_trial_done && $billing->trial_days) : ?>
                                    <?= sprintf(l('billing.button.trial'), $billing->trial_days) ?>
                                <?php elseif ($this->user->billing_id == $billing->billing_id) : ?>
                                    <?= l('billing.button.renew') ?>
                                <?php else : ?>
                                    <?= l('billing.button.choose') ?>
                                <?php endif ?>
                            <?php else : ?>
                                <?php if ($billing->trial_days) : ?>
                                    <?= sprintf(l('billing.button.trial'), $billing->trial_days) ?>
                                <?php else : ?>
                                    <?= l('billing.button.choose') ?>
                                <?php endif ?>
                            <?php endif ?>
                        </a>
                    </div>
                </div>
            </div>

        <?php endforeach ?>

        <?php ob_start() ?>
        <script>
            'use strict';

            let payment_frequency_handler = (event = null) => {

                let payment_frequency = null;

                if (event) {
                    payment_frequency = $(event.currentTarget).data('payment-frequency');
                } else {
                    payment_frequency = $('[name="payment_frequency"]:checked').closest('label').data('payment-frequency');
                }

                switch (payment_frequency) {
                    case 'monthly':
                        $(`[data-billing-payment-frequency="annual"]`).removeClass('d-inline-block').addClass('d-none');
                        $(`[data-billing-payment-frequency="lifetime"]`).removeClass('d-inline-block').addClass('d-none');

                        break;

                    case 'annual':
                        $(`[data-billing-payment-frequency="monthly"]`).removeClass('d-inline-block').addClass('d-none');
                        $(`[data-billing-payment-frequency="lifetime"]`).removeClass('d-inline-block').addClass('d-none');

                        break

                    case 'lifetime':
                        $(`[data-billing-payment-frequency="monthly"]`).removeClass('d-inline-block').addClass('d-none');
                        $(`[data-billing-payment-frequency="annual"]`).removeClass('d-inline-block').addClass('d-none');

                        break
                }

                $(`[data-billing-payment-frequency="${payment_frequency}"]`).addClass('d-inline-block');

                $(`[data-billing-${payment_frequency}="true"]`).removeClass('d-none').addClass('d-inline-block');
                $(`[data-billing-${payment_frequency}="false"]`).addClass('d-none').removeClass('d-inline-block');

            };

            $('[data-payment-frequency]').on('click', payment_frequency_handler);

            payment_frequency_handler();
        </script>
        <?php \Altum\Event::add_content(ob_get_clean(), 'javascript') ?>

        <?php if (settings()->billing_custom->status == 1) : ?>

            <div class="col-12 col-lg-4 mb-4">
                <div class="card pricing-card h-100" style="<?= settings()->billing_custom->color ? 'border-color: ' . settings()->billing_custom->color : null ?>">
                    <div class="card-body d-flex flex-column">

                        <div class="mb-3">
                            <div class="font-weight-bold text-center text-uppercase pb-2 text-muted border-bottom border-gray-200"><?= settings()->billing_custom->name ?></div>
                        </div>

                        <div class="mb-4 text-center">
                            <div class="h1">
                                <?= settings()->billing_custom->price ?>
                            </div>
                            <div>
                                <span class="text-muted"><?= settings()->billing_custom->description ?></span>
                            </div>
                        </div>

                        <?= include_view(THEME_PATH . 'views/partials/billings_billing_content.php', ['billing_settings' => settings()->billing_custom->settings]) ?>
                    </div>

                    <div class="p-3">
                        <a href="<?= settings()->billing_custom->custom_button_url ?>" class="btn btn-block btn-primary"><?= l('billing.button.contact') ?></a>
                    </div>
                </div>
            </div>

        <?php endif ?>

    <?php endif ?>
</div>