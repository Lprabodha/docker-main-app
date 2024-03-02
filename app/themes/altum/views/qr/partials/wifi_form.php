<?php defined('ALTUMCODE') || die() ?>

<?php

$decodedData = json_decode(isset($data->qr_code[0]['data']) ? $data->qr_code[0]['data'] : null, true);
$qrType = isset($decodedData['type']) ? $decodedData['type'] : null;

if (isset($data->qr_code[0]['data']) && $qrType == 'wifi') {
    $filledInput = json_decode($data->qr_code[0]['data'], true);
    $qrName =  $data->qr_code[0]['name'];
    $qrUid =  $data->qr_code[0]['uId'];
} else {
    $filledInput = array();
    $qrName = null;
    $qrUid = null;
}
?>

<div id="step2_form">

    <!-- <input type="hidden" id="uId" name="uId" class="form-control" value="<?php echo (!empty($filledInput)) ? $qrUid : uniqid();  ?>" data-reload-qr-code /> -->
    <input type="hidden" id="preview_link" name="preview_link" value="<?php echo (!empty($filledInput)) ? $filledInput['preview_link'] : '';  ?>" class="form-control" data-reload-qr-code />
    <input type="hidden" id="preview_link2" name="preview_link2" value="<?php echo (!empty($filledInput)) ? $filledInput['preview_link2'] : '';  ?>" class="form-control" data-reload-qr-code />


    <div class="custom-accodian wifi-info-main-wrp info-block-main-wrp">
        <button class="btn accodianBtn" type="button" data-toggle="collapse" data-target="#acc_WiFi_Information" aria-expanded="true" aria-controls="acc_WiFi_Information">
            <div class="qr-step-icon">
                <span class="icon-info grey steps-icon"></span>
            </div>

            <span class="custom-accodian-heading">
                <span class="accodianRequired"><?= l('qr_step_2_wifi.title') ?><sup>*</sup></span>
                <span class="fields-helper-heading"><?= l('qr_step_2_wifi.help_txt.title') ?></span>
            </span>

            <div class="toggle-icon-wrap ml-2">
                <span class="icon-arrow-h-right grey toggle-icon"></span>
            </div>
        </button>
        <div class="collapse show" id="acc_WiFi_Information">
            <hr class="accordian-hr">
            <div class="collapseInner">
                <div class="row align-items-center mx-0">
                    <div class="form-group step-form-group col-md-12 col-sm-12" data-type="wifi">
                        <label for="wifi_ssid"><?= l('qr_step_2_wifi.input.network_name') ?> <span class="text-danger text-bold">*</span></label>
                        <input 
                            type="text" 
                            id="wifi_ssid" 
                            placeholder="<?= l('qr_step_2_wifi.input.network_name.wifi_ssid.placeholder') ?>" 
                            name="wifi_ssid" 
                            class="form-control" 
                            value="<?php echo (!empty($filledInput)) ? $filledInput['wifi_ssid'] : '';  ?>" 
                            maxlength="<?= $data->qr_code_settings['type']['wifi']['ssid']['max_length'] ?>" 
                            required="required" 
                            data-reload-qr-code 
                            input_validate 
                            onchange="LoadPreview()"
                        />
                    </div>

                    <div class="form-group step-form-group col-md-12 col-sm-12" data-type="wifi">
                        <label for="wifi_password"><?= l('qr_step_2_wifi.input.network_password') ?></label>
                        <input type="text" id="wifi_password" placeholder="<?= l('qr_step_2_wifi.input.network_password.placeholder') ?>" name="wifi_password" class="form-control" value="<?php echo (!empty($filledInput)) ? $filledInput['wifi_password'] : '';  ?>" maxlength="<?= $data->qr_code_settings['type']['wifi']['password']['max_length'] ?>" data-reload-qr-code />
                    </div>

                    <div class="form-group step-form-group m-0 col-md-5 col-sm-12" data-type="wifi">
                        <label for="wifi_encryption"><?= l('qr_step_2_wifi.input.encryption_type') ?></label>
                        <div class="custom-drop-wrp">
                            <select id="wifi_encryption" name="wifi_encryption" class="form-control" data-reload-qr-code>
                                <option value="WPA" <?php echo (!empty($filledInput)) ? (($filledInput['wifi_encryption'] == 'WPA') ? 'selected' : '') : '';  ?> selected>WPA</option>
                                <option value="WEP" <?php echo (!empty($filledInput)) ? (($filledInput['wifi_encryption'] == 'WEP') ? 'selected' : '') : '';  ?>>WEP</option>
                                <option value="WPA/WPA2" <?php echo (!empty($filledInput)) ? (($filledInput['wifi_encryption'] == 'WPA/WPA2') ? 'selected' : '') : '';  ?>>WPA-EAP</option>
                                <option value="nopass" <?php echo (!empty($filledInput)) ? (($filledInput['wifi_encryption'] == 'nopass') ? 'selected' : '') : '';  ?>><?= l('qr_step_2_wifi.input.wifi_encryption_nopass') ?></option>
                            </select>
                        </div>
                    </div>

                    <div class="checkbox-wrapper col-md-7 col-sm-12" style="height: 50px;">
                        <div class="roundCheckbox m-2 mr-3">
                            <input type="checkbox" id="uploadCheckbox" name="uploadCheckbox" <?php echo (!empty($filledInput)) ? ((isset($filledInput['uploadCheckbox'])) ? 'checked' : '') : '';  ?>>
                            <label class="m-0" for="uploadCheckbox"></label>
                        </div>
                        <label class="passwordlabel mb-0" for="wifi_is_hidden"><?= l('qr_step_2_wifi.input.wifi_is_hidden') ?></label>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Name sections -->
    <?php include_once('components/qr-name.php'); ?>

    <!-- Folder sections -->
    <?php include_once('components/folder.php'); ?>

</div>

<script>
    window.addEventListener('load', (event) => {

        <?php if ($qrUid) { ?>
            reload_qr_code_event_listener();
            $('#qr-code-wrap').addClass('active');
            $("#2").attr('disabled', false)
            $("#2").removeClass("disable-btn")
        <?php } ?>
    });

    $('#acc_WiFi_Information').on('keyup change paste', 'input, select, textarea', ".colorPaletteInner", function() {
        if ($("input[name=\"step_input\"]").val() == 2) {
            $("#tabs-1").addClass("active");
            $("#tabs-2").removeClass("active");
            $("#2").removeClass("active");
            $("#1").addClass("active");
        }
    });

    // document.getElementById('iframesrc').src = '<?=LANDING_PAGE_URL?>preview/wifi';

    function LoadPreview(welcome_screen = false, showLoader = false) {
        const PreviewData = {
            live: true,
            networkName:$("#wifi_ssid").val(),
            type:'wifi',
            static:false,
            step:2
        }
        document.getElementById('iframesrc').contentWindow?.postMessage(PreviewData,'<?=LANDING_PAGE_URL?>');
    }

    if($('#qr_status').val()){
        $('#iframesrc').ready(function(){
            setTimeout(()=>{
                LoadPreview()
            },1000)
        })
    }
</script>