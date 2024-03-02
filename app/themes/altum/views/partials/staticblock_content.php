<?php defined('ALTUMCODE') || die() ?>

<div class="">
    <?php $enabled_qr_codes = array_filter((array) $data->staticblock_settings->enabled_qr_codes) ?>
    <?php $enabled_qr_codes_count = count($enabled_qr_codes) ?>
    <?php
    $enabled_qr_codes_string = implode(', ', array_map(function($key) {
        return l('qr_codes.type.' . mb_strtolower($key));
    }, array_keys($enabled_qr_codes)));
    ?>

    <div class="d-flex justify-content-between align-items-center my-3">
        <div>
            <?= sprintf(l('global.staticblock_settings.enabled_qr_codes'), '<strong>' . nr($enabled_qr_codes_count) . '</strong>') ?>
            <span class="mr-1" data-toggle="tooltip" title="<?= $enabled_qr_codes_string ?>"><i class="fa fa-fw fa-xs fa-question text-gray-500"></i></span>
        </div>

        <i class="fa fa-fw fa-sm <?= $enabled_qr_codes_count ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
    </div>

    <div class="d-flex justify-content-between align-items-center my-3">
        <div>
            <?= sprintf(l('global.staticblock_settings.qr_codes_limit'), '<strong>' . ($data->staticblock_settings->qr_codes_limit == -1 ? l('global.unlimited') : nr($data->staticblock_settings->qr_codes_limit)) . '</strong>') ?>
        </div>

        <i class="fa fa-fw fa-sm <?= $data->staticblock_settings->qr_codes_limit ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
    </div>

    <div class="d-flex justify-content-between align-items-center my-3">
        <div>
            <?= sprintf(l('global.staticblock_settings.links_limit'), '<strong>' . ($data->staticblock_settings->links_limit == -1 ? l('global.unlimited') : nr($data->staticblock_settings->links_limit)) . '</strong>') ?>
        </div>

        <i class="fa fa-fw fa-sm <?= $data->staticblock_settings->links_limit ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
    </div>

    <div class="d-flex justify-content-between align-items-center my-3">
        <div>
            <?= sprintf(l('global.staticblock_settings.projects_limit'), '<strong>' . ($data->staticblock_settings->projects_limit == -1 ? l('global.unlimited') : nr($data->staticblock_settings->projects_limit)) . '</strong>') ?>
        </div>

        <i class="fa fa-fw fa-sm <?= $data->staticblock_settings->projects_limit ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
    </div>

    <div class="d-flex justify-content-between align-items-center my-3">
        <div>
            <?= sprintf(l('global.staticblock_settings.pixels_limit'), '<strong>' . ($data->staticblock_settings->pixels_limit == -1 ? l('global.unlimited') : nr($data->staticblock_settings->pixels_limit)) . '</strong>') ?>
        </div>

        <i class="fa fa-fw fa-sm <?= $data->staticblock_settings->pixels_limit ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
    </div>

    <?php if(settings()->links->domains_is_enabled): ?>
        <div class="d-flex justify-content-between align-items-center my-3">
            <div>
                <?= sprintf(l('global.staticblock_settings.domains_limit'), '<strong>' . ($data->staticblock_settings->domains_limit == -1 ? l('global.unlimited') : nr($data->staticblock_settings->domains_limit)) . '</strong>') ?>
            </div>

            <i class="fa fa-fw fa-sm <?= $data->staticblock_settings->domains_limit ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
        </div>
    <?php endif ?>

    <?php if(\Altum\Plugin::is_active('teams')): ?>
        <div class="d-flex justify-content-between align-items-center my-3">
            <div>
                <?= sprintf(l('global.staticblock_settings.teams_limit'), '<strong>' . ($data->staticblock_settings->teams_limit == -1 ? l('global.unlimited') : nr($data->staticblock_settings->teams_limit)) . '</strong>') ?>
            </div>

            <i class="fa fa-fw fa-sm <?= $data->staticblock_settings->teams_limit ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
        </div>

        <div class="d-flex justify-content-between align-items-center my-3">
            <div>
                <?= sprintf(l('global.staticblock_settings.team_members_limit'), '<strong>' . ($data->staticblock_settings->team_members_limit == -1 ? l('global.unlimited') : nr($data->staticblock_settings->team_members_limit)) . '</strong>') ?>
            </div>

            <i class="fa fa-fw fa-sm <?= $data->staticblock_settings->team_members_limit ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
        </div>
    <?php endif ?>

    <?php if(\Altum\Plugin::is_active('affiliate') && settings()->affiliate->is_enabled): ?>
        <div class="d-flex justify-content-between align-items-center my-3">
            <div>
                <?= sprintf(l('global.staticblock_settings.affiliate_commission_percentage'), '<strong>' . nr($data->staticblock_settings->affiliate_commission_percentage) . '%</strong>') ?>
            </div>

            <i class="fa fa-fw fa-sm <?= $data->staticblock_settings->affiliate_commission_percentage ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
        </div>
    <?php endif ?>

    <div class="d-flex justify-content-between align-items-center my-3">
        <div>
            <?= sprintf(l('global.staticblock_settings.statistics_retention'), '<strong>' . ($data->staticblock_settings->statistics_retention == -1 ? l('global.unlimited') : nr($data->staticblock_settings->statistics_retention)) . '</strong>') ?>
        </div>

        <i class="fa fa-fw fa-sm <?= $data->staticblock_settings->statistics_retention ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
    </div>

    <?php if(settings()->links->additional_domains_is_enabled): ?>
        <div class="d-flex justify-content-between align-items-center my-3 <?= $data->staticblock_settings->additional_domains_is_enabled ? null : 'text-muted' ?>">
            <div>
                <?= l('global.staticblock_settings.additional_domains_is_enabled') ?>
                <span class="mr-1" data-toggle="tooltip" title="<?= l('global.staticblock_settings.additional_domains_is_enabled_help') ?>"><i class="fa fa-fw fa-xs fa-question text-gray-500"></i></span>
            </div>

            <i class="fa fa-fw fa-sm <?= $data->staticblock_settings->additional_domains_is_enabled ? 'fa-check text-success' : 'fa-times' ?>"></i>
        </div>
    <?php endif ?>

    <div class="d-flex justify-content-between align-items-center my-3 <?= $data->staticblock_settings->analytics_is_enabled ? null : 'text-muted' ?>">
        <div>
            <?= l('global.staticblock_settings.analytics_is_enabled') ?>
            <span class="mr-1" data-toggle="tooltip" title="<?= l('global.staticblock_settings.analytics_is_enabled_help') ?>"><i class="fa fa-fw fa-xs fa-question text-gray-500"></i></span>
        </div>

        <i class="fa fa-fw fa-sm <?= $data->staticblock_settings->analytics_is_enabled ? 'fa-check text-success' : 'fa-times' ?>"></i>
    </div>

    <div class="d-flex justify-content-between align-items-center my-3 <?= $data->staticblock_settings->password_protection_is_enabled ? null : 'text-muted' ?>">
        <div>
            <?= l('global.staticblock_settings.password_protection_is_enabled') ?>
            <span class="mr-1" data-toggle="tooltip" title="<?= l('global.staticblock_settings.password_protection_is_enabled_help') ?>"><i class="fa fa-fw fa-xs fa-question text-gray-500"></i></span>
        </div>

        <i class="fa fa-fw fa-sm <?= $data->staticblock_settings->password_protection_is_enabled ? 'fa-check text-success' : 'fa-times' ?>"></i>
    </div>

    <div class="d-flex justify-content-between align-items-center my-3 <?= $data->staticblock_settings->sensitive_content_is_enabled ? null : 'text-muted' ?>">
        <div>
            <?= l('global.staticblock_settings.sensitive_content_is_enabled') ?>
            <span class="mr-1" data-toggle="tooltip" title="<?= l('global.staticblock_settings.sensitive_content_is_enabled_help') ?>"><i class="fa fa-fw fa-xs fa-question text-gray-500"></i></span>
        </div>

        <i class="fa fa-fw fa-sm <?= $data->staticblock_settings->sensitive_content_is_enabled ? 'fa-check text-success' : 'fa-times' ?>"></i>
    </div>

    <div class="d-flex justify-content-between align-items-center my-3 <?= $data->staticblock_settings->custom_url_is_enabled ? null : 'text-muted' ?>">
        <div>
            <?= l('global.staticblock_settings.custom_url_is_enabled') ?>
            <span class="mr-1" data-toggle="tooltip" title="<?= l('global.staticblock_settings.custom_url_is_enabled_help') ?>"><i class="fa fa-fw fa-xs fa-question text-gray-500"></i></span>
        </div>

        <i class="fa fa-fw fa-sm <?= $data->staticblock_settings->custom_url_is_enabled ? 'fa-check text-success' : 'fa-times' ?>"></i>
    </div>

    <div class="d-flex justify-content-between align-items-center my-3 <?= $data->staticblock_settings->qr_reader_is_enabled ? null : 'text-muted' ?>">
        <div>
            <?= l('global.staticblock_settings.qr_reader_is_enabled') ?>
            <span class="mr-1" data-toggle="tooltip" title="<?= l('global.staticblock_settings.qr_reader_is_enabled_help') ?>"><i class="fa fa-fw fa-xs fa-question text-gray-500"></i></span>
        </div>

        <i class="fa fa-fw fa-sm <?= $data->staticblock_settings->qr_reader_is_enabled ? 'fa-check text-success' : 'fa-times' ?>"></i>
    </div>

    <div class="d-flex justify-content-between align-items-center my-3 <?= $data->staticblock_settings->api_is_enabled ? null : 'text-muted' ?>">
        <div>
            <?= l('global.staticblock_settings.api_is_enabled') ?>
            <span class="mr-1" data-toggle="tooltip" title="<?= l('global.staticblock_settings.api_is_enabled_help') ?>"><i class="fa fa-fw fa-xs fa-question text-gray-500"></i></span>
        </div>

        <i class="fa fa-fw fa-sm <?= $data->staticblock_settings->api_is_enabled ? 'fa-check text-success' : 'fa-times' ?>"></i>
    </div>

    <div class="d-flex justify-content-between align-items-center my-3 <?= $data->staticblock_settings->no_ads ? null : 'text-muted' ?>">
        <div>
            <?= l('global.staticblock_settings.no_ads') ?>
            <span class="mr-1" data-toggle="tooltip" title="<?= l('global.staticblock_settings.no_ads_help') ?>"><i class="fa fa-fw fa-xs fa-question text-gray-500"></i></span>
        </div>

        <i class="fa fa-fw fa-sm <?= $data->staticblock_settings->no_ads ? 'fa-check text-success' : 'fa-times' ?>"></i>
    </div>
</div>
