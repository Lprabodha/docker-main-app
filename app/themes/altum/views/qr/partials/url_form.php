<?php defined('ALTUMCODE') || die() ?>
<?php

$decodedData = json_decode(isset($data->qr_code[0]['data']) ? $data->qr_code[0]['data'] : null, true);
$qrType = isset($decodedData['type']) ? $decodedData['type'] : null;

if (isset($data->qr_code[0]['data']) && $qrType == 'url') {
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
    <input type="hidden" id="preview_link" name="preview_link" class="form-control" value="<?php echo (!empty($filledInput)) ? $filledInput['preview_link'] : '';  ?>" data-reload-qr-code />
    <input type="hidden" id="preview_link2" name="preview_link2" value="<?php echo (!empty($filledInput)) ? $filledInput['preview_link2'] : '';  ?>" class="form-control" data-reload-qr-code />

    <!-- <input type="hidden" name=""> -->

    <div class="custom-accodian">
        <button class="btn accodianBtn" type="button" data-toggle="collapse" data-target="#acc_nameOfUrl" aria-expanded="true" aria-controls="acc_nameOfUrl">
            <div class="qr-step-icon">
                <span class="icon-global grey steps-icon"></span>
            </div>

            <span class="custom-accodian-heading">
                <span class="accodianRequired"><?= l('qr_step_2_website.web_info') ?><sup>*</sup></span>
                <span class="fields-helper-heading"><?= l('qr_step_2_website.help_txt.web_info') ?></span>
            </span>

            <div class="toggle-icon-wrap ml-2">
                <span class="icon-arrow-h-right grey toggle-icon"></span>
            </div>
        </button>
        <div class="collapse show" id="acc_nameOfUrl">
            <hr class="accordian-hr">
            <div class="collapseInner">
                <div class="step-form-group" data-type="url" data-url <?php echo (!empty($filledInput)) ? 'style="display:block !important;"' : '';  ?>>
                    <label class="filed-label" for="url"><?= l('qr_step_2_website.web_url') ?>  <span class="text-danger text-bold">*</span></label>
                    <div class="input-field-wrap">
                        <input 
                            type="url" 
                            id="url" 
                            name="url" 
                            placeholder="<?= l('qr_step_2_website.input.url.placeholder') ?>" 
                            class="step-form-control" 
                            value="<?php echo (!empty($filledInput)) ? $filledInput['url'] : '';  ?>" 
                            maxlength="<?= $data->qr_code_settings['type']['url']['max_length'] ?>" 
                            data-reload-qr-code input_validate 
                            onchange="LoadPreview()"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if (settings()->users->register_is_enabled) : ?>
        <div class="form-group d-none" data-type="url">
            <div <?= \Altum\Middlewares\Authentication::check() ? null : 'data-toggle="tooltip" title="' . l('global.info_message.plan_feature_no_access') . '"' ?>>
                <div class="<?= \Altum\Middlewares\Authentication::check() ? null : 'container-disabled' ?>" style="display:none ;">
                    <div class="custom-control custom-checkbox">
                        <input id="url_dynamic" name="url_dynamic" type="checkbox" <?php echo (!empty($filledInput) && isset($filledInput['url']) && $filledInput['url'] != '') ? 'checked' : '';  ?> class="custom-control-input" data-reload-qr-code />
                        <label class="custom-control-label" for="url_dynamic"><?= l('qr_codes.input.url_dynamic') ?></label>
                        <small class="form-text text-muted"><?= l('qr_codes.input.url_dynamic_help') ?></small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Name sections -->
        <?php include_once('components/qr-name.php'); ?>
        
        <!-- password sections -->
        <?php include_once('components/password.php'); ?>

        <!-- Folder sections -->
        <?php include_once('components/folder.php'); ?>

    <?php endif ?>
</div>

<script>

    $('#acc_nameOfUrl').on('keyup change paste', 'input, select, textarea', ".colorPaletteInner", function() {
        if ($("input[name=\"step_input\"]").val() == 2) {
            $("#tabs-1").addClass("active");
            $("#tabs-2").removeClass("active");
            $("#2").removeClass("active");
            $("#1").addClass("active");
        }
    });

    // document.getElementById('iframesrc').src = '<?=LANDING_PAGE_URL?>preview/website';

    function LoadPreview(welcome_screen = false, showLoader = false) {
        const PreviewData = {
            live: true,
            url:$("#url").val(),
            type:'website',
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