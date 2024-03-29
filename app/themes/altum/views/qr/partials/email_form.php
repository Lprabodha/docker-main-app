<?php defined('ALTUMCODE') || die() ?>

<div id="step2_form">
    <div class="form-group" data-type="email">
        <label for="email"><i class="fa fa-fw fa-envelope fa-sm mr-1"></i> <?= l('qr_codes.input.email') ?></label>
        <input type="text" id="email" name="email" class="form-control" value="" maxlength="<?= $data->qr_code_settings['type']['email']['max_length'] ?>" required="required" data-reload-qr-code />
    </div>

    <div class="form-group" data-type="email">
        <label for="email_subject"><i class="fa fa-fw fa-heading fa-sm mr-1"></i> <?= l('qr_codes.input.email_subject') ?></label>
        <input type="text" id="email_subject" name="email_subject" class="form-control" value="" maxlength="<?= $data->qr_code_settings['type']['email']['body']['max_length'] ?>" data-reload-qr-code />
    </div>

    <div class="form-group" data-type="email">
        <label for="email_body"><i class="fa fa-fw fa-paragraph fa-sm mr-1"></i> <?= l('qr_codes.input.email_body') ?></label>
        <textarea id="email_body" name="email_body" class="form-control" maxlength="<?= $data->qr_code_settings['type']['email']['body']['max_length'] ?>" data-reload-qr-code></textarea>
    </div>
</div>
