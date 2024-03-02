<?php defined('ALTUMCODE') || die() ?>

<?php if (settings()->payment->is_enabled) : ?>

    <?php
    $plans = [];
    $available_payment_frequencies = [];

    $plans_result = database()->query("SELECT * FROM `plans` WHERE `status` = 1 ORDER BY `order`");

    while ($plan = $plans_result->fetch_object()) {
        $plans[] = $plan;

        foreach (['monthly', 'annual', 'lifetime'] as $value) {
            if ($plan->{$value . '_price'}) {
                $available_payment_frequencies[$value] = true;
            }
        }
    }

    ?>
    <?php if (count($plans)) : ?>
        <div class="custom-container">
            <div class="bill-detail">
                <div class="billing-plan">
                    <div class="bill-data">
                        <?php foreach ($plans as $plan) : ?>
                            <?php if (isset($available_payment_frequencies['monthly'])) : ?>
                                <div class="bill">
                                    <h2 class="bill-month">Monthly</h2>
                                    <span class="bill-price"><?= $plan->monthly_price ?></span>
                                    <span class="bill-sell">(ALL 11,589)</span>
                                    <p class="italic">Invoiced every month</p>
                                    <div class="bill-variant">
                                        <div class="bill-spesi">
                                            <i class="fa fa-fw fa-sm <?= $enabled_qr_codes_count ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
                                            <span class="packk"> <?= sprintf(l('global.plan_settings.enabled_qr_codes'), nr($enabled_qr_codes_count)) ?></span>
                                        </div>
                                    </div>
                                    <div class="bill-variant">
                                        <div class="bill-spesi">
                                            <i class="fa fa-fw fa-sm <?= $data->plan_settings->qr_codes_limit ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
                                            <span class="packk"> <?= sprintf(l('global.plan_settings.qr_codes_limit'), ($data->plan_settings->qr_codes_limit == -1 ? l('global.unlimited') : nr($data->plan_settings->qr_codes_limit))) ?></span>
                                        </div>
                                    </div>
                                    <div class="bill-variant">
                                        <div class="bill-spesi">
                                            <i class="fa fa-fw fa-sm <?= $data->plan_settings->links_limit ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
                                            <span class="packk"><?= sprintf(l('global.plan_settings.links_limit'), '<strong>' . ($data->plan_settings->links_limit == -1 ? l('global.unlimited') : nr($data->plan_settings->links_limit)) . '</strong>') ?></span>
                                        </div>
                                    </div>
                                    <div class="bill-variant">
                                        <div class="bill-spesi">
                                            <i class="fa fa-fw fa-sm <?= $data->plan_settings->projects_limit ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
                                            <span class="packk"><?= sprintf(l('global.plan_settings.projects_limit'), '<strong>' . ($data->plan_settings->projects_limit == -1 ? l('global.unlimited') : nr($data->plan_settings->projects_limit)) . '</strong>') ?></span>
                                        </div>
                                    </div>
                                    <div class="bill-variant">
                                        <div class="bill-spesi">
                                            <i class="fa fa-fw fa-sm <?= $data->plan_settings->pixels_limit ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
                                            <span class="packk"><?= sprintf(l('global.plan_settings.pixels_limit'), '<strong>' . ($data->plan_settings->pixels_limit == -1 ? l('global.unlimited') : nr($data->plan_settings->pixels_limit)) . '</strong>') ?></span>
                                        </div>
                                    </div>
                                    <?php if (settings()->links->domains_is_enabled) : ?>
                                        <div class="bill-variant">
                                            <div class="bill-spesi">
                                                <i class="fa fa-fw fa-sm <?= $data->plan_settings->domains_limit ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
                                                <span class="packk"> <?= sprintf(l('global.plan_settings.domains_limit'), '<strong>' . ($data->plan_settings->domains_limit == -1 ? l('global.unlimited') : nr($data->plan_settings->domains_limit)) . '</strong>') ?></span>
                                            </div>
                                        </div>
                                    <?php endif ?>
                                    <?php if (\Altum\Plugin::is_active('teams')) : ?>
                                        <div class="bill-variant">
                                            <div class="bill-spesi">
                                                <i class="fa fa-fw fa-sm <?= $data->plan_settings->teams_limit ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
                                                <span class="packk"> <?= sprintf(l('global.plan_settings.teams_limit'), '<strong>' . ($data->plan_settings->teams_limit == -1 ? l('global.unlimited') : nr($data->plan_settings->teams_limit)) . '</strong>') ?></span>
                                            </div>
                                        </div>
                                        <div class="bill-variant">
                                            <div class="bill-spesi">
                                                <i class="fa fa-fw fa-sm <?= $data->plan_settings->team_members_limit ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
                                                <span class="packk"><?= sprintf(l('global.plan_settings.team_members_limit'), '<strong>' . ($data->plan_settings->team_members_limit == -1 ? l('global.unlimited') : nr($data->plan_settings->team_members_limit)) . '</strong>') ?></span>
                                            </div>
                                        </div>
                                    <?php endif ?>
                                    <?php if (\Altum\Plugin::is_active('affiliate') && settings()->affiliate->is_enabled) : ?>
                                        <div class="bill-variant">
                                            <div class="bill-spesi">
                                                <i class="fa fa-fw fa-sm <?= $data->plan_settings->affiliate_commission_percentage ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
                                                <span class="packk"><?= sprintf(l('global.plan_settings.affiliate_commission_percentage'), '<strong>' . nr($data->plan_settings->affiliate_commission_percentage) . '%</strong>') ?></span>
                                            </div>
                                        </div>


                                    <?php endif ?>

                                    <div class="bill-variant">
                                        <div class="bill-spesi">
                                            <i class="fa fa-fw fa-sm <?= $data->plan_settings->statistics_retention ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
                                            <span class="packk"><?= sprintf(l('global.plan_settings.statistics_retention'), '<strong>' . ($data->plan_settings->statistics_retention == -1 ? l('global.unlimited') : nr($data->plan_settings->statistics_retention)) . '</strong>') ?></span>
                                        </div>
                                    </div>
                                    <?php if (settings()->links->additional_domains_is_enabled) : ?>
                                        <div class="bill-variant <?= $data->plan_settings->additional_domains_is_enabled ? null : 'text-muted' ?>">
                                            <div class="bill-spesi">
                                                <i class="fa fa-fw fa-sm <?= $data->plan_settings->additional_domains_is_enabled ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
                                                <div>
                                                    <span class="packk"><?= l('global.plan_settings.additional_domains_is_enabled') ?></span><i class="fa fa-fw fa-xs fa-question text-gray-500" id="tooltip"></i>
                                                    <span class="tooltip-text" id="tooltip-text"><?= l('global.plan_settings.additional_domains_is_enabled_help') ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif ?>

                                    <div class="bill-variant <?= $data->plan_settings->analytics_is_enabled ? null : 'text-muted' ?>">
                                            <div class="bill-spesi">
                                                <i class="fa fa-fw fa-sm <?= $data->plan_settings->analytics_is_enabled ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
                                                <div>
                                                    <span class="packk"><?= l('global.plan_settings.analytics_is_enabled') ?></span><i class="fa fa-fw fa-xs fa-question text-gray-500" id="tooltip"></i>
                                                    <span class="tooltip-text" id="tooltip-text"><?= l('global.plan_settings.analytics_is_enabled_help') ?></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="bill-variant  <?= $data->plan_settings->password_protection_is_enabled ? null : 'text-muted' ?>">
                                            <div class="bill-spesi">
                                                <i class="fa fa-fw fa-sm <?= $data->plan_settings->password_protection_is_enabled ?'fa-check text-success' : 'fa-times text-muted' ?>"></i>
                                                <div>
                                                    <span class="packk"><?= l('global.plan_settings.password_protection_is_enabled') ?></span><i class="fa fa-fw fa-xs fa-question text-gray-500" id="tooltip"></i>
                                                    <span class="tooltip-text" id="tooltip-text"><?= l('global.plan_settings.password_protection_is_enabled_help') ?></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="bill-variant  <?= $data->plan_settings->sensitive_content_is_enabled ? null : 'text-muted' ?>">
                                            <div class="bill-spesi">
                                                <i class="fa fa-fw fa-sm <?= $data->plan_settings->sensitive_content_is_enabled ?'fa-check text-success' : 'fa-times text-muted' ?>"></i>
                                                <div>
                                                    <span class="packk"><?= l('global.plan_settings.sensitive_content_is_enabled') ?></span><i class="fa fa-fw fa-xs fa-question text-gray-500" id="tooltip"></i>
                                                    <span class="tooltip-text" id="tooltip-text"><?= l('global.plan_settings.sensitive_content_is_enabled_help') ?></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="bill-variant  <?= $data->plan_settings->custom_url_is_enabled ? null : 'text-muted' ?>">
                                            <div class="bill-spesi">
                                                <i class="fa fa-fw fa-sm <?= $data->plan_settings->custom_url_is_enabled ?'fa-check text-success' : 'fa-times text-muted' ?>"></i>
                                                <div>
                                                    <span class="packk"><?= l('global.plan_settings.custom_url_is_enabled') ?></span><i class="fa fa-fw fa-xs fa-question text-gray-500" id="tooltip"></i>
                                                    <span class="tooltip-text" id="tooltip-text"><?= l('global.plan_settings.custom_url_is_enabled_help') ?></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="bill-variant  <?= $data->plan_settings->qr_reader_is_enabled ? null : 'text-muted' ?>">
                                            <div class="bill-spesi">
                                                <i class="fa fa-fw fa-sm <?= $data->plan_settings->qr_reader_is_enabled ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
                                                <div>
                                                    <span class="packk"><?= l('global.plan_settings.qr_reader_is_enabled') ?></span><i class="fa fa-fw fa-xs fa-question text-gray-500" id="tooltip"></i>
                                                    <span class="tooltip-text" id="tooltip-text"><?= l('global.plan_settings.qr_reader_is_enabled_help') ?></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="bill-variant  <?= $data->plan_settings->api_is_enabled ? null : 'text-muted' ?>">
                                            <div class="bill-spesi">
                                                <i class="fa fa-fw fa-sm <?= $data->plan_settings->api_is_enabled ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
                                                <div>
                                                    <span class="packk"><?= l('global.plan_settings.api_is_enabled') ?></span><i class="fa fa-fw fa-xs fa-question text-gray-500" id="tooltip"></i>
                                                    <span class="tooltip-text" id="tooltip-text"><?= l('global.plan_settings.api_is_enabled_help') ?></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="bill-variant  <?= $data->plan_settings->no_ads ? null : 'text-muted' ?>">
                                            <div class="bill-spesi">
                                                <i class="fa fa-fw fa-sm <?= $data->plan_settings->no_ads ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
                                                <div>
                                                    <span class="packk"><?= l('global.plan_settings.no_ads') ?></span><i class="fa fa-fw fa-xs fa-question text-gray-500" id="tooltip"></i>
                                                    <span class="tooltip-text" id="tooltip-text"><?= l('global.plan_settings.no_ads_help') ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    <button class="primaryBigButton outline">Buy</button>
                                </div>
                            <?php endif ?>

                            <?php if (isset($available_payment_frequencies['annual'])) :  ?>
                                <div class="bill blue-line">
                                    <h2 class="bill-month blue-month">Annually</h2>
                                    <span class="bill-price"><?= $plan->annual_price ?></span>
                                    <span class="bill-sell">(ALL 29,266)</span>
                                    <p class="italic blue-pack">Invoiced every year</p>
                                    <div class="bill-variant">
                                        <div class="bill-spesi">
                                            <i class="fa fa-fw fa-sm <?= $enabled_qr_codes_count ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
                                            <span class="packk"> <?= sprintf(l('global.plan_settings.enabled_qr_codes'), nr($enabled_qr_codes_count)) ?></span>
                                        </div>
                                    </div>
                                    <div class="bill-variant">
                                        <div class="bill-spesi">
                                            <i class="fa fa-fw fa-sm <?= $data->plan_settings->qr_codes_limit ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
                                            <span class="packk"> <?= sprintf(l('global.plan_settings.qr_codes_limit'), ($data->plan_settings->qr_codes_limit == -1 ? l('global.unlimited') : nr($data->plan_settings->qr_codes_limit))) ?></span>
                                        </div>
                                    </div>
                                    <div class="bill-variant">
                                        <div class="bill-spesi">
                                            <i class="fa fa-fw fa-sm <?= $data->plan_settings->links_limit ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
                                            <span class="packk"><?= sprintf(l('global.plan_settings.links_limit'), '<strong>' . ($data->plan_settings->links_limit == -1 ? l('global.unlimited') : nr($data->plan_settings->links_limit)) . '</strong>') ?></span>
                                        </div>
                                    </div>
                                    <div class="bill-variant">
                                        <div class="bill-spesi">
                                            <i class="fa fa-fw fa-sm <?= $data->plan_settings->projects_limit ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
                                            <span class="packk"><?= sprintf(l('global.plan_settings.projects_limit'), '<strong>' . ($data->plan_settings->projects_limit == -1 ? l('global.unlimited') : nr($data->plan_settings->projects_limit)) . '</strong>') ?></span>
                                        </div>
                                    </div>
                                    <div class="bill-variant">
                                        <div class="bill-spesi">
                                            <i class="fa fa-fw fa-sm <?= $data->plan_settings->pixels_limit ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
                                            <span class="packk"><?= sprintf(l('global.plan_settings.pixels_limit'), '<strong>' . ($data->plan_settings->pixels_limit == -1 ? l('global.unlimited') : nr($data->plan_settings->pixels_limit)) . '</strong>') ?></span>
                                        </div>
                                    </div>
                                    <?php if (settings()->links->domains_is_enabled) : ?>
                                        <div class="bill-variant">
                                            <div class="bill-spesi">
                                                <i class="fa fa-fw fa-sm <?= $data->plan_settings->domains_limit ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
                                                <span class="packk"> <?= sprintf(l('global.plan_settings.domains_limit'), '<strong>' . ($data->plan_settings->domains_limit == -1 ? l('global.unlimited') : nr($data->plan_settings->domains_limit)) . '</strong>') ?></span>
                                            </div>
                                        </div>
                                    <?php endif ?>
                                    <?php if (\Altum\Plugin::is_active('teams')) : ?>
                                        <div class="bill-variant">
                                            <div class="bill-spesi">
                                                <i class="fa fa-fw fa-sm <?= $data->plan_settings->teams_limit ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
                                                <span class="packk"> <?= sprintf(l('global.plan_settings.teams_limit'), '<strong>' . ($data->plan_settings->teams_limit == -1 ? l('global.unlimited') : nr($data->plan_settings->teams_limit)) . '</strong>') ?></span>
                                            </div>
                                        </div>
                                        <div class="bill-variant">
                                            <div class="bill-spesi">
                                                <i class="fa fa-fw fa-sm <?= $data->plan_settings->team_members_limit ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
                                                <span class="packk"><?= sprintf(l('global.plan_settings.team_members_limit'), '<strong>' . ($data->plan_settings->team_members_limit == -1 ? l('global.unlimited') : nr($data->plan_settings->team_members_limit)) . '</strong>') ?></span>
                                            </div>
                                        </div>
                                    <?php endif ?>
                                    <?php if (\Altum\Plugin::is_active('affiliate') && settings()->affiliate->is_enabled) : ?>
                                        <div class="bill-variant">
                                            <div class="bill-spesi">
                                                <i class="fa fa-fw fa-sm <?= $data->plan_settings->affiliate_commission_percentage ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
                                                <span class="packk"><?= sprintf(l('global.plan_settings.affiliate_commission_percentage'), '<strong>' . nr($data->plan_settings->affiliate_commission_percentage) . '%</strong>') ?></span>
                                            </div>
                                        </div>


                                    <?php endif ?>

                                    <div class="bill-variant">
                                        <div class="bill-spesi">
                                            <i class="fa fa-fw fa-sm <?= $data->plan_settings->statistics_retention ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
                                            <span class="packk"><?= sprintf(l('global.plan_settings.statistics_retention'), '<strong>' . ($data->plan_settings->statistics_retention == -1 ? l('global.unlimited') : nr($data->plan_settings->statistics_retention)) . '</strong>') ?></span>
                                        </div>
                                    </div>
                                    <?php if (settings()->links->additional_domains_is_enabled) : ?>
                                        <div class="bill-variant <?= $data->plan_settings->additional_domains_is_enabled ? null : 'text-muted' ?>">
                                            <div class="bill-spesi">
                                                <i class="fa fa-fw fa-sm <?= $data->plan_settings->additional_domains_is_enabled ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
                                                <div>
                                                    <span class="packk"><?= l('global.plan_settings.additional_domains_is_enabled') ?></span><i class="fa fa-fw fa-xs fa-question text-gray-500" id="tooltip"></i>
                                                    <span class="tooltip-text" id="tooltip-text"><?= l('global.plan_settings.additional_domains_is_enabled_help') ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif ?>

                                    <div class="bill-variant <?= $data->plan_settings->analytics_is_enabled ? null : 'text-muted' ?>">
                                            <div class="bill-spesi">
                                                <i class="fa fa-fw fa-sm <?= $data->plan_settings->analytics_is_enabled ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
                                                <div>
                                                    <span class="packk"><?= l('global.plan_settings.analytics_is_enabled') ?></span><i class="fa fa-fw fa-xs fa-question text-gray-500" id="tooltip"></i>
                                                    <span class="tooltip-text" id="tooltip-text"><?= l('global.plan_settings.analytics_is_enabled_help') ?></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="bill-variant  <?= $data->plan_settings->password_protection_is_enabled ? null : 'text-muted' ?>">
                                            <div class="bill-spesi">
                                                <i class="fa fa-fw fa-sm <?= $data->plan_settings->password_protection_is_enabled ?'fa-check text-success' : 'fa-times text-muted' ?>"></i>
                                                <div>
                                                    <span class="packk"><?= l('global.plan_settings.password_protection_is_enabled') ?></span><i class="fa fa-fw fa-xs fa-question text-gray-500" id="tooltip"></i>
                                                    <span class="tooltip-text" id="tooltip-text"><?= l('global.plan_settings.password_protection_is_enabled_help') ?></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="bill-variant  <?= $data->plan_settings->sensitive_content_is_enabled ? null : 'text-muted' ?>">
                                            <div class="bill-spesi">
                                                <i class="fa fa-fw fa-sm <?= $data->plan_settings->sensitive_content_is_enabled ?'fa-check text-success' : 'fa-times text-muted' ?>"></i>
                                                <div>
                                                    <span class="packk"><?= l('global.plan_settings.sensitive_content_is_enabled') ?></span><i class="fa fa-fw fa-xs fa-question text-gray-500" id="tooltip"></i>
                                                    <span class="tooltip-text" id="tooltip-text"><?= l('global.plan_settings.sensitive_content_is_enabled_help') ?></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="bill-variant  <?= $data->plan_settings->custom_url_is_enabled ? null : 'text-muted' ?>">
                                            <div class="bill-spesi">
                                                <i class="fa fa-fw fa-sm <?= $data->plan_settings->custom_url_is_enabled ?'fa-check text-success' : 'fa-times text-muted' ?>"></i>
                                                <div>
                                                    <span class="packk"><?= l('global.plan_settings.custom_url_is_enabled') ?></span><i class="fa fa-fw fa-xs fa-question text-gray-500" id="tooltip"></i>
                                                    <span class="tooltip-text" id="tooltip-text"><?= l('global.plan_settings.custom_url_is_enabled_help') ?></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="bill-variant  <?= $data->plan_settings->qr_reader_is_enabled ? null : 'text-muted' ?>">
                                            <div class="bill-spesi">
                                                <i class="fa fa-fw fa-sm <?= $data->plan_settings->qr_reader_is_enabled ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
                                                <div>
                                                    <span class="packk"><?= l('global.plan_settings.qr_reader_is_enabled') ?></span><i class="fa fa-fw fa-xs fa-question text-gray-500" id="tooltip"></i>
                                                    <span class="tooltip-text" id="tooltip-text"><?= l('global.plan_settings.qr_reader_is_enabled_help') ?></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="bill-variant  <?= $data->plan_settings->api_is_enabled ? null : 'text-muted' ?>">
                                            <div class="bill-spesi">
                                                <i class="fa fa-fw fa-sm <?= $data->plan_settings->api_is_enabled ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
                                                <div>
                                                    <span class="packk"><?= l('global.plan_settings.api_is_enabled') ?></span><i class="fa fa-fw fa-xs fa-question text-gray-500" id="tooltip"></i>
                                                    <span class="tooltip-text" id="tooltip-text"><?= l('global.plan_settings.api_is_enabled_help') ?></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="bill-variant  <?= $data->plan_settings->no_ads ? null : 'text-muted' ?>">
                                            <div class="bill-spesi">
                                                <i class="fa fa-fw fa-sm <?= $data->plan_settings->no_ads ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
                                                <div>
                                                    <span class="packk"><?= l('global.plan_settings.no_ads') ?></span><i class="fa fa-fw fa-xs fa-question text-gray-500" id="tooltip"></i>
                                                    <span class="tooltip-text" id="tooltip-text"><?= l('global.plan_settings.no_ads_help') ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    <button class="primaryBigButton outline">Buy</button>
                                </div>
                            <?php endif ?>

                            <?php if (isset($available_payment_frequencies['lifetime'])) :  ?>
                                <div class="bill">
                                    <h2 class="bill-month">Quarterly</h2>
                                    <span class="bill-price"><?= $plan->lifetime_price ?></span>
                                    <span class="bill-sell">(ALL 17,560)</span>
                                    <p class="italic">Invoiced each quarter</p>
                                    <div class="bill-variant">
                                        <div class="bill-spesi">
                                            <i class="fa fa-fw fa-sm <?= $enabled_qr_codes_count ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
                                            <span class="packk"> <?= sprintf(l('global.plan_settings.enabled_qr_codes'), nr($enabled_qr_codes_count)) ?></span>
                                        </div>
                                    </div>
                                    <div class="bill-variant">
                                        <div class="bill-spesi">
                                            <i class="fa fa-fw fa-sm <?= $data->plan_settings->qr_codes_limit ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
                                            <span class="packk"> <?= sprintf(l('global.plan_settings.qr_codes_limit'), ($data->plan_settings->qr_codes_limit == -1 ? l('global.unlimited') : nr($data->plan_settings->qr_codes_limit))) ?></span>
                                        </div>
                                    </div>
                                    <div class="bill-variant">
                                        <div class="bill-spesi">
                                            <i class="fa fa-fw fa-sm <?= $data->plan_settings->links_limit ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
                                            <span class="packk"><?= sprintf(l('global.plan_settings.links_limit'), '<strong>' . ($data->plan_settings->links_limit == -1 ? l('global.unlimited') : nr($data->plan_settings->links_limit)) . '</strong>') ?></span>
                                        </div>
                                    </div>
                                    <div class="bill-variant">
                                        <div class="bill-spesi">
                                            <i class="fa fa-fw fa-sm <?= $data->plan_settings->projects_limit ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
                                            <span class="packk"><?= sprintf(l('global.plan_settings.projects_limit'), '<strong>' . ($data->plan_settings->projects_limit == -1 ? l('global.unlimited') : nr($data->plan_settings->projects_limit)) . '</strong>') ?></span>
                                        </div>
                                    </div>
                                    <div class="bill-variant">
                                        <div class="bill-spesi">
                                            <i class="fa fa-fw fa-sm <?= $data->plan_settings->pixels_limit ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
                                            <span class="packk"><?= sprintf(l('global.plan_settings.pixels_limit'), '<strong>' . ($data->plan_settings->pixels_limit == -1 ? l('global.unlimited') : nr($data->plan_settings->pixels_limit)) . '</strong>') ?></span>
                                        </div>
                                    </div>
                                    <?php if (settings()->links->domains_is_enabled) : ?>
                                        <div class="bill-variant">
                                            <div class="bill-spesi">
                                                <i class="fa fa-fw fa-sm <?= $data->plan_settings->domains_limit ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
                                                <span class="packk"> <?= sprintf(l('global.plan_settings.domains_limit'), '<strong>' . ($data->plan_settings->domains_limit == -1 ? l('global.unlimited') : nr($data->plan_settings->domains_limit)) . '</strong>') ?></span>
                                            </div>
                                        </div>
                                    <?php endif ?>
                                    <?php if (\Altum\Plugin::is_active('teams')) : ?>
                                        <div class="bill-variant">
                                            <div class="bill-spesi">
                                                <i class="fa fa-fw fa-sm <?= $data->plan_settings->teams_limit ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
                                                <span class="packk"> <?= sprintf(l('global.plan_settings.teams_limit'), '<strong>' . ($data->plan_settings->teams_limit == -1 ? l('global.unlimited') : nr($data->plan_settings->teams_limit)) . '</strong>') ?></span>
                                            </div>
                                        </div>
                                        <div class="bill-variant">
                                            <div class="bill-spesi">
                                                <i class="fa fa-fw fa-sm <?= $data->plan_settings->team_members_limit ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
                                                <span class="packk"><?= sprintf(l('global.plan_settings.team_members_limit'), '<strong>' . ($data->plan_settings->team_members_limit == -1 ? l('global.unlimited') : nr($data->plan_settings->team_members_limit)) . '</strong>') ?></span>
                                            </div>
                                        </div>
                                    <?php endif ?>
                                    <?php if (\Altum\Plugin::is_active('affiliate') && settings()->affiliate->is_enabled) : ?>
                                        <div class="bill-variant">
                                            <div class="bill-spesi">
                                                <i class="fa fa-fw fa-sm <?= $data->plan_settings->affiliate_commission_percentage ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
                                                <span class="packk"><?= sprintf(l('global.plan_settings.affiliate_commission_percentage'), '<strong>' . nr($data->plan_settings->affiliate_commission_percentage) . '%</strong>') ?></span>
                                            </div>
                                        </div>


                                    <?php endif ?>

                                    <div class="bill-variant">
                                        <div class="bill-spesi">
                                            <i class="fa fa-fw fa-sm <?= $data->plan_settings->statistics_retention ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
                                            <span class="packk"><?= sprintf(l('global.plan_settings.statistics_retention'), '<strong>' . ($data->plan_settings->statistics_retention == -1 ? l('global.unlimited') : nr($data->plan_settings->statistics_retention)) . '</strong>') ?></span>
                                        </div>
                                    </div>
                                    <?php if (settings()->links->additional_domains_is_enabled) : ?>
                                        <div class="bill-variant <?= $data->plan_settings->additional_domains_is_enabled ? null : 'text-muted' ?>">
                                            <div class="bill-spesi">
                                                <i class="fa fa-fw fa-sm <?= $data->plan_settings->additional_domains_is_enabled ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
                                                <div>
                                                    <span class="packk"><?= l('global.plan_settings.additional_domains_is_enabled') ?></span><i class="fa fa-fw fa-xs fa-question text-gray-500" id="tooltip"></i>
                                                    <span class="tooltip-text" id="tooltip-text"><?= l('global.plan_settings.additional_domains_is_enabled_help') ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif ?>

                                    <div class="bill-variant <?= $data->plan_settings->analytics_is_enabled ? null : 'text-muted' ?>">
                                            <div class="bill-spesi">
                                                <i class="fa fa-fw fa-sm <?= $data->plan_settings->analytics_is_enabled ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
                                                <div>
                                                    <span class="packk"><?= l('global.plan_settings.analytics_is_enabled') ?></span><i class="fa fa-fw fa-xs fa-question text-gray-500" id="tooltip"></i>
                                                    <span class="tooltip-text" id="tooltip-text"><?= l('global.plan_settings.analytics_is_enabled_help') ?></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="bill-variant  <?= $data->plan_settings->password_protection_is_enabled ? null : 'text-muted' ?>">
                                            <div class="bill-spesi">
                                                <i class="fa fa-fw fa-sm <?= $data->plan_settings->password_protection_is_enabled ?'fa-check text-success' : 'fa-times text-muted' ?>"></i>
                                                <div>
                                                    <span class="packk"><?= l('global.plan_settings.password_protection_is_enabled') ?></span><i class="fa fa-fw fa-xs fa-question text-gray-500" id="tooltip"></i>
                                                    <span class="tooltip-text" id="tooltip-text"><?= l('global.plan_settings.password_protection_is_enabled_help') ?></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="bill-variant  <?= $data->plan_settings->sensitive_content_is_enabled ? null : 'text-muted' ?>">
                                            <div class="bill-spesi">
                                                <i class="fa fa-fw fa-sm <?= $data->plan_settings->sensitive_content_is_enabled ?'fa-check text-success' : 'fa-times text-muted' ?>"></i>
                                                <div>
                                                    <span class="packk"><?= l('global.plan_settings.sensitive_content_is_enabled') ?></span><i class="fa fa-fw fa-xs fa-question text-gray-500" id="tooltip"></i>
                                                    <span class="tooltip-text" id="tooltip-text"><?= l('global.plan_settings.sensitive_content_is_enabled_help') ?></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="bill-variant  <?= $data->plan_settings->custom_url_is_enabled ? null : 'text-muted' ?>">
                                            <div class="bill-spesi">
                                                <i class="fa fa-fw fa-sm <?= $data->plan_settings->custom_url_is_enabled ?'fa-check text-success' : 'fa-times text-muted' ?>"></i>
                                                <div>
                                                    <span class="packk"><?= l('global.plan_settings.custom_url_is_enabled') ?></span><i class="fa fa-fw fa-xs fa-question text-gray-500" id="tooltip"></i>
                                                    <span class="tooltip-text" id="tooltip-text"><?= l('global.plan_settings.custom_url_is_enabled_help') ?></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="bill-variant  <?= $data->plan_settings->qr_reader_is_enabled ? null : 'text-muted' ?>">
                                            <div class="bill-spesi">
                                                <i class="fa fa-fw fa-sm <?= $data->plan_settings->qr_reader_is_enabled ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
                                                <div>
                                                    <span class="packk"><?= l('global.plan_settings.qr_reader_is_enabled') ?></span><i class="fa fa-fw fa-xs fa-question text-gray-500" id="tooltip"></i>
                                                    <span class="tooltip-text" id="tooltip-text"><?= l('global.plan_settings.qr_reader_is_enabled_help') ?></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="bill-variant  <?= $data->plan_settings->api_is_enabled ? null : 'text-muted' ?>">
                                            <div class="bill-spesi">
                                                <i class="fa fa-fw fa-sm <?= $data->plan_settings->api_is_enabled ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
                                                <div>
                                                    <span class="packk"><?= l('global.plan_settings.api_is_enabled') ?></span><i class="fa fa-fw fa-xs fa-question text-gray-500" id="tooltip"></i>
                                                    <span class="tooltip-text" id="tooltip-text"><?= l('global.plan_settings.api_is_enabled_help') ?></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="bill-variant  <?= $data->plan_settings->no_ads ? null : 'text-muted' ?>">
                                            <div class="bill-spesi">
                                                <i class="fa fa-fw fa-sm <?= $data->plan_settings->no_ads ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
                                                <div>
                                                    <span class="packk"><?= l('global.plan_settings.no_ads') ?></span><i class="fa fa-fw fa-xs fa-question text-gray-500" id="tooltip"></i>
                                                    <span class="tooltip-text" id="tooltip-text"><?= l('global.plan_settings.no_ads_help') ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    <button class="primaryBigButton outline">Buy</button>
                                </div>
                            <?php endif ?>
                        <?php endforeach ?>


                    </div>
                    <p class="tax">Value Added Tax not included in the amounts.</p>
                </div>
            </div>
        </div>
    <?php endif ?>
<?php endif ?>