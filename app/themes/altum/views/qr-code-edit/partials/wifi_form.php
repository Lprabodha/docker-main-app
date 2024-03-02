<?php defined('ALTUMCODE') || die() ?>

<div id="step2_form">

    <div class="custom-accodian">
        <button class="btn accodianBtn" type="button" data-toggle="collapse" data-target="#acc_nameOfQrCode" aria-expanded="true" aria-controls="acc_nameOfQrCode">
            <span> <?= l('qr_codes.input.qrname') ?></span>
            <svg class="MuiSvgIcon-root MuiSvgIcon-colorPrimary leftArrow" focusable="false" viewBox="0 0 16 16" aria-hidden="true" style="font-size: 16px;"><path d="M12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5ZM12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5Z"></path></svg>
        </button>
        <div class="collapse show" id="acc_nameOfQrCode">
            <div class="collapseInner">
                <div class="form-group m-0">
                    <input id="name" name="name" placeholder="E.g. My QR code" class="form-control" value="" maxlength="<?= $data->qr_code_settings['type']['business']['name']['max_length'] ?>" required="required" data-reload-qr-code />
                </div>
            </div>
        </div>  
    </div>

    <div class="custom-accodian">
        <button class="btn accodianBtn" type="button" data-toggle="collapse" data-target="#acc_WiFi_Information" aria-expanded="true" aria-controls="acc_WiFi_Information">
            <span>Wi-Fi information</span>
            <svg class="MuiSvgIcon-root MuiSvgIcon-colorPrimary leftArrow" focusable="false" viewBox="0 0 16 16" aria-hidden="true" style="font-size: 16px;"><path d="M12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5ZM12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5Z"></path></svg>
        </button>
        <div class="collapse show" id="acc_WiFi_Information">
            <div class="collapseInner">
                <div class="row align-items-end">
                    <div class="form-group col-md-6 col-sm-12" data-type="wifi">
                        <label for="wifi_ssid"><?= l('qr_codes.input.wifi_ssid') ?></label>
                        <input type="text" id="wifi_ssid" placeholder="E.g. HomeWifi" name="wifi_ssid" class="form-control" value="" maxlength="<?= $data->qr_code_settings['type']['wifi']['ssid']['max_length'] ?>" required="required" data-reload-qr-code />
                    </div>

                    <div class="form-group col-md-6 col-sm-12" data-type="wifi">
                        <label for="wifi_password">Wifi <?= l('qr_codes.input.wifi_password') ?></label>
                        <input type="text" id="wifi_password" placeholder="E.g. Mypassword" name="wifi_password" class="form-control" value="" maxlength="<?= $data->qr_code_settings['type']['wifi']['password']['max_length'] ?>" data-reload-qr-code />
                    </div>
    
                    <div class="form-group m-0 col-md-3 col-sm-12" data-type="wifi">
                        <label for="wifi_encryption"><?= l('qr_codes.input.wifi_encryption') ?></label>
                        <select id="wifi_encryption" name="wifi_encryption" class="form-control" data-reload-qr-code>
                            <option value="WEP">WEP</option>
                            <option value="WPA/WPA2">WPA</option>
                            <option value="WPA/WPA2">WPA-EAP</option>
                            <option value="nopass"><?= l('qr_codes.input.wifi_encryption_nopass') ?></option>
                        </select>
                    </div>
                  
                    <div class="checkbox-wrapper col-md-3 col-sm-12" style="height: 50px;">
                        <div class="roundCheckbox m-2 mr-3">
                            <input type="checkbox" id="uploadCheckbox">
                            <label class="m-0" for="uploadCheckbox"></label>
                        </div>
                        <label class="passwordlabel mb-0" for="wifi_is_hidden"><?= l('qr_codes.input.wifi_is_hidden') ?></label>
                    </div>
                </div>
            </div>
        </div>  
    </div>
  
    


    <!-- <div class="form-group">
        <label for="name"> <?= l('qr_codes.input.qrname') ?></label>
        <input id="name" name="name" class="form-control" value="" maxlength="<?= $data->qr_code_settings['type']['business']['name']['max_length'] ?>" required="required" data-reload-qr-code />
    </div>    
    <div class="form-group" data-type="wifi">
        <label for="wifi_ssid"><i class="fa fa-fw fa-signature fa-sm mr-1"></i> <?= l('qr_codes.input.wifi_ssid') ?></label>
        <input type="text" id="wifi_ssid" name="wifi_ssid" class="form-control" value="" maxlength="<?= $data->qr_code_settings['type']['wifi']['ssid']['max_length'] ?>" required="required" data-reload-qr-code />
    </div>

    <div class="form-group" data-type="wifi">
        <label for="wifi_encryption"><i class="fa fa-fw fa-user-shield fa-sm mr-1"></i> <?= l('qr_codes.input.wifi_encryption') ?></label>
        <select id="wifi_encryption" name="wifi_encryption" class="form-control" data-reload-qr-code>
            <option value="WEP">WEP</option>
            <option value="WPA/WPA2">WPA/WPA2</option>
            <option value="nopass"><?= l('qr_codes.input.wifi_encryption_nopass') ?></option>
        </select>
    </div>

    <div class="form-group" data-type="wifi">
        <label for="wifi_password"><i class="fa fa-fw fa-key fa-sm mr-1"></i> Wifi <?= l('qr_codes.input.wifi_password') ?></label>
        <input type="text" id="wifi_password" name="wifi_password" class="form-control" value="" maxlength="<?= $data->qr_code_settings['type']['wifi']['password']['max_length'] ?>" data-reload-qr-code />
    </div>

    <div class="form-group" data-type="wifi">
        <label for="wifi_is_hidden"><i class="fa fa-fw fa-user-secret fa-sm mr-1"></i> <?= l('qr_codes.input.wifi_is_hidden') ?></label>
        <select id="wifi_is_hidden" name="wifi_is_hidden" class="form-control" data-reload-qr-code>
            <option value="1"><?= l('global.yes') ?></option>
            <option value="0"><?= l('global.no') ?></option>
        </select>
    </div>
    
    <label for="password">Qr Password</label>
    <input id="password" type="password" name="password" class="form-control" value="" maxlength="30" data-reload-qr-code /> -->
</div>
