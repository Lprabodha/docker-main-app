<?php defined('ALTUMCODE') || die() ?>

<div id="step2_form">
    <div class="form-group" data-type="whatsapp">
        <label for="whatsapp"><i class="fab fa-fw fa-whatsapp fa-sm mr-1"></i> <?= l('qr_codes.input.whatsapp') ?></label>
        <input type="text" id="whatsapp" name="whatsapp" class="form-control" value="" maxlength="<?= $data->qr_code_settings['type']['whatsapp']['max_length'] ?>" required="required" data-reload-qr-code />
    </div>

    <div class="form-group" data-type="whatsapp">
        <label for="whatsapp_body"><i class="fa fa-fw fa-paragraph fa-sm mr-1"></i> <?= l('qr_codes.input.whatsapp_body') ?></label>
        <textarea id="whatsapp_body" name="whatsapp_body" class="form-control" maxlength="<?= $data->qr_code_settings['type']['whatsapp']['body']['max_length'] ?>" data-reload-qr-code></textarea>
    </div>
</div>
