<div class="custom-accodian ">
    <button class="btn accodianBtn collapsed" type="button" data-toggle="collapse" data-target="#acc_nameOfQrCode" aria-expanded="false" aria-controls="acc_nameOfQrCode">
        <div class="qr-step-icon">
            <span class="icon-scan-barcode grey steps-icon"></span>
        </div>
        <span class="custom-accodian-heading">
            <span><?= l('qr_step_2_com_qr_name.input.qrname') ?></span>
            <span class="fields-helper-heading"><?= l('qr_step_2_com_qr_name.help_txt.qrname') ?></span>
        </span>
        <div class="toggle-icon-wrap ml-2">
            <span class="icon-arrow-h-right grey toggle-icon"></span>
        </div>
    </button>
    <div class="collapse " id="acc_nameOfQrCode">
        <hr class="accordian-hr">
        <div class="collapseInner">
            <div class="step-form-group">
                <label class="filed-label" for="url"><?= l('qr_step_2_com_qr_name.input.name') ?></label>
                <div class="input-field-wrap">
                    <input id="name" name="name" placeholder="<?= l('qr_step_2_com_qr_name.placeholder') ?>" class="step-form-control" value="<?php echo (!empty($qrName)) ? $qrName : '';  ?>" maxlength="<?= $data->qr_code_settings['type']['images']['name']['max_length'] ?>" data-reload-qr-code />
                </div>
            </div>
        </div>
    </div>
</div>