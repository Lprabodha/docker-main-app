<?php defined('ALTUMCODE') || die() ?>

<div>
    <div class="form-group">
        <label for="is_enabled"><?= l('admin_settings.facebook.is_enabled') ?></label>
        <select id="is_enabled" name="is_enabled" class="form-control form-control-lg">
            <option value="1" <?= settings()->facebook->is_enabled ? 'selected="selected"' : null ?>><?= l('global.yes') ?></option>
            <option value="0" <?= !settings()->facebook->is_enabled ? 'selected="selected"' : null ?>><?= l('global.no') ?></option>
        </select>
    </div>

    <div class="form-group">
        <label for="app_id"><?= l('admin_settings.facebook.app_id') ?></label>
        <input id="app_id" type="text" name="app_id" class="form-control form-control-lg" value="<?= settings()->facebook->app_id ?>" />
    </div>

    <div class="form-group">
        <label for="app_secret"><?= l('admin_settings.facebook.app_secret') ?></label>
        <input id="app_secret" type="text" name="app_secret" class="form-control form-control-lg" value="<?= settings()->facebook->app_secret ?>" />
    </div>
</div>

<button type="submit" name="submit" class="btn btn-lg btn-block btn-primary mt-4"><?= l('global.update') ?></button>
