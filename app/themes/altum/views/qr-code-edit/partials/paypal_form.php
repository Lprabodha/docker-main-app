<?php defined('ALTUMCODE') || die() ?>

<div id="step2_form">
    <div class="form-group" data-type="paypal">
        <label for="paypal_type"><i class="fab fa-fw fa-paypal fa-sm mr-1"></i> <?= l('qr_codes.input.paypal_type') ?></label>
        <select id="paypal_type" name="paypal_type" class="form-control" data-reload-qr-code>
            <?php foreach($data->qr_code_settings['type']['paypal']['type'] as $key => $value): ?>
                <option value="<?= $key ?>"><?= l('qr_codes.input.paypal_type_' . $key) ?></option>
            <?php endforeach ?>
        </select>
    </div>

    <div class="form-group" data-type="paypal">
        <label for="paypal_email"><i class="fa fa-fw fa-envelope fa-sm mr-1"></i> <?= l('qr_codes.input.paypal_email') ?></label>
        <input type="email" id="paypal_email" name="paypal_email" class="form-control" value="" maxlength="<?= $data->qr_code_settings['type']['paypal']['email']['max_length'] ?>" required="required" data-reload-qr-code />
    </div>

    <div class="form-group" data-type="paypal">
        <label for="paypal_title"><i class="fa fa-fw fa-heading fa-sm mr-1"></i> <?= l('qr_codes.input.paypal_title') ?></label>
        <input type="text" id="paypal_title" name="paypal_title" class="form-control" value="" maxlength="<?= $data->qr_code_settings['type']['paypal']['title']['max_length'] ?>" required="required" data-reload-qr-code />
    </div>

    <div class="form-group" data-type="paypal">
        <label for="paypal_currency"><i class="fa fa-fw fa-euro-sign fa-sm mr-1"></i> <?= l('qr_codes.input.paypal_currency') ?></label>
        <input type="text" id="paypal_currency" name="paypal_currency" class="form-control" value="" maxlength="<?= $data->qr_code_settings['type']['paypal']['currency']['max_length'] ?>" required="required" data-reload-qr-code />
    </div>

    <div class="form-group" data-type="paypal">
        <label for="paypal_price"><i class="fa fa-fw fa-dollar-sign fa-sm mr-1"></i> <?= l('qr_codes.input.paypal_price') ?></label>
        <input type="number" id="paypal_price" name="paypal_price" class="form-control" value="" min="1" required="required" data-reload-qr-code />
    </div>

    <div class="form-group" data-type="paypal">
        <label for="paypal_thank_you_url"><i class="fa fa-fw fa-link fa-sm mr-1"></i> <?= l('qr_codes.input.paypal_thank_you_url') ?></label>
        <input type="text" id="paypal_thank_you_url" name="paypal_thank_you_url" class="form-control" value="" maxlength="<?= $data->qr_code_settings['type']['paypal']['thank_you_url']['max_length'] ?>" data-reload-qr-code />
    </div>

    <div class="form-group" data-type="paypal">
        <label for="paypal_cancel_url"><i class="fa fa-fw fa-link fa-sm mr-1"></i> <?= l('qr_codes.input.paypal_cancel_url') ?></label>
        <input type="text" id="paypal_cancel_url" name="paypal_cancel_url" class="form-control" value="" maxlength="<?= $data->qr_code_settings['type']['paypal']['cancel_url']['max_length'] ?>" data-reload-qr-code />
    </div>
</div>
