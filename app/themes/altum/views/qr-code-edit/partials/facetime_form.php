<?php defined('ALTUMCODE') || die() ?>

<div id="step2_form">
    <div class="form-group" data-type="facetime">
        <label for="facetime"><i class="fa fa-fw fa-headset fa-sm mr-1"></i> <?= l('qr_codes.input.facetime') ?></label>
        <input type="text" id="facetime" name="facetime" class="form-control" value="" maxlength="<?= $data->qr_code_settings['type']['facetime']['max_length'] ?>" required="required" data-reload-qr-code />
    </div>
</div>
