<?php defined('ALTUMCODE') || die() ?>

<div id="step2_form">
    <label for="name"> <?= l('qr_codes.input.qrname') ?></label>
        <input id="name" name="name" class="form-control" value="" maxlength="<?= $data->qr_code_settings['type']['business']['name']['max_length'] ?>" required="required" data-reload-qr-code />
        
    <div class="form-group" data-type="phone">
        <label for="phone"><i class="fa fa-fw fa-phone-square-alt fa-sm mr-1"></i> <?= l('qr_codes.input.phone') ?></label>
        <input type="text" id="phone" name="phone" class="form-control" value="" maxlength="<?= $data->qr_code_settings['type']['phone']['max_length'] ?>" required="required" data-reload-qr-code />
        
        
        <label for="password"> Password</label>
        <input id="password" type="password" name="password" class="form-control" value="" maxlength="30" required="required" data-reload-qr-code />
    </div>
</div>
