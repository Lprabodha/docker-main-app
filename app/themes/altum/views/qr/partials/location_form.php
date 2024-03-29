<?php defined('ALTUMCODE') || die() ?>

<div id="step2_form">
    <div class="form-group" data-type="location">
        <label for="location_latitude"><i class="fa fa-fw fa-map-pin fa-sm mr-1"></i> <?= l('qr_codes.input.location_latitude') ?></label>
        <input type="number" id="location_latitude" name="location_latitude" step="0.0000001" class="form-control" value="" maxlength="<?= $data->qr_code_settings['type']['location']['latitude']['max_length'] ?>" required="required" data-reload-qr-code />
    </div>

    <div class="form-group" data-type="location">
        <label for="location_longitude"><i class="fa fa-fw fa-map-pin fa-sm mr-1"></i> <?= l('qr_codes.input.location_longitude') ?></label>
        <input type="number" id="location_longitude" name="location_longitude" step="0.0000001" class="form-control" value="" maxlength="<?= $data->qr_code_settings['type']['location']['longitude']['max_length'] ?>" required="required" data-reload-qr-code />
    </div>
</div>
