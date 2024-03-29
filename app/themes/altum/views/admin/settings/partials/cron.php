<?php defined('ALTUMCODE') || die() ?>

<div>
    <?php foreach(['reset'] as $cron): ?>
        <label for="cron_<?= $cron ?>"><?= l('admin_settings.cron.' . $cron) ?></label>
        <div class="input-group mb-3">
            <input id="cron_<?= $cron ?>" name="cron_<?= $cron ?>" type="text" class="form-control form-control-lg" value="<?= '* * * * * wget --quiet -O /dev/null ' . SITE_URL . 'cron/' . $cron . '?key=' . settings()->cron->key ?>" readonly="readonly" />
            <div class="input-group-append">
                <span class="input-group-text" data-toggle="tooltip" title="<?= sprintf(l('admin_settings.cron.last_execution'), isset(settings()->cron->{$cron . '_datetime'}) ? \Altum\Date::get_timeago(settings()->cron->{$cron . '_datetime'}) : '-') ?>">
                    <i class="fa fa-fw fa-calendar text-muted"></i>
                </span>
            </div>
        </div>
    <?php endforeach ?>
</div>
