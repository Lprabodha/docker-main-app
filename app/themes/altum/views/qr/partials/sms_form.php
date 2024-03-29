<?php defined('ALTUMCODE') || die() ?>

<div id="step2_form">
    <div class="form-group" data-type="sms">
        <label for="sms"><i class="fa fa-fw fa-sms fa-sm mr-1"></i> <?= l('qr_codes.input.sms') ?></label>
        <input type="text" id="sms" name="sms" class="form-control" value="" maxlength="<?= $data->qr_code_settings['type']['sms']['max_length'] ?>" required="required" data-reload-qr-code />
    </div>

    <div class="form-group" data-type="sms">
        <label for="sms_body"><i class="fa fa-fw fa-paragraph fa-sm mr-1"></i> <?= l('qr_codes.input.sms_body') ?></label>
        <textarea id="sms_body" name="sms_body" class="form-control" maxlength="<?= $data->qr_code_settings['type']['sms']['body']['max_length'] ?>" data-reload-qr-code></textarea>
    </div>
</div>
