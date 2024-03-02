<?php defined('ALTUMCODE') || die() ?>

    $staticblocks_result = database()->query("SELECT * FROM `staticblocks` WHERE `status` = 1 ORDER BY `order`");
    ?>
<div class="row justify-content-around">
    <?php if(settings()->staticblock_guest->status == 1): ?>

        <div class="col-12 col-lg-4 mb-4">
            <div class="card pricing-card h-100" style="<?= settings()->staticblock_guest->color ? 'border-color: ' . settings()->staticblock_guest->color : null ?>">
                <div class="card-body d-flex flex-column">

                    <div class="mb-3">
                        <div class="font-weight-bold text-center text-uppercase pb-2 text-muted border-bottom border-gray-200"><?= settings()->staticblock_guest->name ?></div>
                    </div>

                    <div class="mb-4 text-center">
                        <div class="h1">
                            <?= settings()->staticblock_guest->price ?>
                        </div>
                        <div>
                            <span class="text-muted"><?= settings()->staticblock_guest->description ?></span>
                        </div>
                    </div>

                    <?= include_view(THEME_PATH . 'views/partials/staticblocks_staticblock_content.php', ['staticblock_settings' => settings()->staticblock_guest->settings]) ?>
                </div>

                <div class="p-3">
                    <button type="button" class="btn btn-block btn-primary disabled cclr" disabled="disabled"><?= l('staticblock.button.choose') ?></button>
                </div>
            </div>
        </div>

    <?php endif ?>

    <?php if(settings()->staticblock_free->status == 1): ?>

        <div class="col-12 col-lg-4 mb-4">
            <div class="card pricing-card h-100" style="<?= settings()->staticblock_free->color ? 'border-color: ' . settings()->staticblock_free->color : null ?>">
                <div class="card-body d-flex flex-column">

                    <div class="mb-3">
                        <div class="font-weight-bold text-center text-uppercase pb-2 text-muted border-bottom border-gray-200"><?= settings()->staticblock_free->name ?></div>
                    </div>

                    <div class="mb-4 text-center">
                        <div class="h1">
                            <?= settings()->staticblock_free->price ?>
                        </div>
                        <div>
                            <span class="text-muted"><?= settings()->staticblock_free->description ?></span>
                        </div>
                    </div>

                    <?= include_view(THEME_PATH . 'views/partials/staticblocks_staticblock_content.php', ['staticblock_settings' => settings()->staticblock_free->settings]) ?>
                </div>

                <div class="p-3">
                    <a href="<?= url('register') ?>" class="btn btn-block btn-primary cclr <?= \Altum\Middlewares\Authentication::check() && $this->user->staticblock_id != 'free' ? 'disabled' : null ?>"><?= l('staticblock.button.choose') ?></a>
                </div>
            </div>
        </div>

    <?php endif ?>

    <?php if(settings()->payment->is_enabled): ?>

        <?php foreach($staticblocks as $staticblock): ?>

        <?php $staticblock->settings = json_decode($staticblock->settings) ?>
        <?php $annual_price_savings = ceil(($staticblock->monthly_price * 12) - $staticblock->annual_price); ?>

        <div
                class="col-12 col-lg-4 mb-4"
                data-staticblock-monthly="<?= json_encode((bool) $staticblock->monthly_price) ?>"
                data-staticblock-annual="<?= json_encode((bool) $staticblock->annual_price) ?>"
                data-staticblock-lifetime="<?= json_encode((bool) $staticblock->lifetime_price) ?>"
        >
            <div class="card pricing-card h-100" style="<?= $staticblock->color ? 'border-color: ' . $staticblock->color : null ?>">
                <div class="card-body d-flex flex-column">

                    <div class="mb-3">
                        <div class="font-weight-bold text-center text-uppercase pb-2 text-muted border-bottom border-gray-200"><?= $staticblock->name ?></div>
                    </div>

                    <div class="mb-4 text-center">
                        <div class="h1 d-none" data-staticblock-payment-frequency="monthly"><?= $staticblock->monthly_price ?></div>
                        <div class="h1 d-none" data-staticblock-payment-frequency="annual"><?= $staticblock->annual_price ?></div>
                        <div class="h1 d-none" data-staticblock-payment-frequency="lifetime"><?= $staticblock->lifetime_price ?></div>

                        <span class="h5 text-muted">
                            <?= settings()->payment->currency ?>
                        </span>

                        <div>
                            <span class="text-muted">
                                <?= $staticblock->description ?>
                            </span>

                            <?php if($staticblock->monthly_price): ?>
                                <span class="d-none" data-staticblock-payment-frequency="annual"><span class="badge badge-success">- <?= $annual_price_savings . ' ' . settings()->payment->currency ?></span></span>
                            <?php endif ?>
                        </div>
                    </div>

                    <?= include_view(THEME_PATH . 'views/partials/staticblocks_staticblock_content.php', ['staticblock_settings' => $staticblock->settings]) ?>
                </div>

                <div class="p-3">
                    <a href="<?= url('register?redirect=pay/' . $staticblock->staticblock_id) ?>" class="btn btn-block btn-primary">
                        <?php if(\Altum\Middlewares\Authentication::check()): ?>
                            <?php if(!$this->user->staticblock_trial_done && $staticblock->trial_days): ?>
                                <?= sprintf(l('staticblock.button.trial'), $staticblock->trial_days) ?>
                            <?php elseif($this->user->staticblock_id == $staticblock->staticblock_id): ?>
                                <?= l('staticblock.button.renew') ?>
                            <?php else: ?>
                                <?= l('staticblock.button.choose') ?>
                            <?php endif ?>
                        <?php else: ?>
                            <?php if($staticblock->trial_days): ?>
                                <?= sprintf(l('staticblock.button.trial'), $staticblock->trial_days) ?>
                            <?php else: ?>
                                <?= l('staticblock.button.choose') ?>
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

                if(event) {
                    payment_frequency = $(event.currentTarget).data('payment-frequency');
                } else {
                    payment_frequency = $('[name="payment_frequency"]:checked').closest('label').data('payment-frequency');
                }

                switch(payment_frequency) {
                    case 'monthly':
                        $(`[data-staticblock-payment-frequency="annual"]`).removeClass('d-inline-block').addClass('d-none');
                        $(`[data-staticblock-payment-frequency="lifetime"]`).removeClass('d-inline-block').addClass('d-none');

                        break;

                    case 'annual':
                        $(`[data-staticblock-payment-frequency="monthly"]`).removeClass('d-inline-block').addClass('d-none');
                        $(`[data-staticblock-payment-frequency="lifetime"]`).removeClass('d-inline-block').addClass('d-none');

                        break

                    case 'lifetime':
                        $(`[data-staticblock-payment-frequency="monthly"]`).removeClass('d-inline-block').addClass('d-none');
                        $(`[data-staticblock-payment-frequency="annual"]`).removeClass('d-inline-block').addClass('d-none');

                        break
                }

                $(`[data-staticblock-payment-frequency="${payment_frequency}"]`).addClass('d-inline-block');

                $(`[data-staticblock-${payment_frequency}="true"]`).removeClass('d-none').addClass('d-inline-block');
                $(`[data-staticblock-${payment_frequency}="false"]`).addClass('d-none').removeClass('d-inline-block');

            };

            $('[data-payment-frequency]').on('click', payment_frequency_handler);

            payment_frequency_handler();
        </script>
    <?php \Altum\Event::add_content(ob_get_clean(), 'javascript') ?>

    <?php if(settings()->staticblock_custom->status == 1): ?>

        <div class="col-12 col-lg-4 mb-4">
            <div class="card pricing-card h-100" style="<?= settings()->staticblock_custom->color ? 'border-color: ' . settings()->staticblock_custom->color : null ?>">
                <div class="card-body d-flex flex-column">

                    <div class="mb-3">
                        <div class="font-weight-bold text-center text-uppercase pb-2 text-muted border-bottom border-gray-200"><?= settings()->staticblock_custom->name ?></div>
                    </div>

                    <div class="mb-4 text-center">
                        <div class="h1">
                            <?= settings()->staticblock_custom->price ?>
                        </div>
                        <div>
                            <span class="text-muted"><?= settings()->staticblock_custom->description ?></span>
                        </div>
                    </div>

                    <?= include_view(THEME_PATH . 'views/partials/staticblocks_staticblock_content.php', ['staticblock_settings' => settings()->staticblock_custom->settings]) ?>
                </div>

                <div class="p-3">
                    <a href="<?= settings()->staticblock_custom->custom_button_url ?>" class="btn btn-block btn-primary"><?= l('staticblock.button.contact') ?></a>
                </div>
            </div>
        </div>

    <?php endif ?>

    <?php endif ?>
</div>


