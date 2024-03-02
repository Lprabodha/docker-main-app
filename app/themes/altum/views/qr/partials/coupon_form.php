<?php defined('ALTUMCODE') || die() ?>
<?php
$decodedData = json_decode(isset($data->qr_code[0]['data']) ? $data->qr_code[0]['data'] : null, true);
$qrType = isset($decodedData['type']) ? $decodedData['type'] : null;

if (isset($data->qr_code[0]['data']) && $qrType == 'coupon') {
    $filledInput = json_decode($data->qr_code[0]['data'], true);

    $qrName =  $data->qr_code[0]['name'];
    $qrUid =  $data->qr_code[0]['uId'];

    $companyLogo = $filledInput['companyLogoImage'];

    $offerImage = $filledInput['offerImg'];
} else {
    $filledInput = array();
    $qrName = null;
    $qrUid = null;
    $companyLogo =  null;
}

?>

<link rel="stylesheet" type="text/css" href="<?= SITE_URL . 'js/material-date-range-picker/duDatepicker.min.css' ?>">

<style>
    #validTillDate {
        position: relative;
        display: flex;
        /* color: white; */
    }

    #validTillDate:before {

        content: attr(data-date);
        display: inline-block;
        color: black;
    }

    input::-webkit-calendar-picker-indicator {
        background: transparent;
        bottom: 0;
        color: transparent;
        cursor: pointer;
        height: auto;
        left: 0;
        position: absolute;
        right: 0;
        top: 0;
        width: auto;
    }

    #validTillDate::-webkit-datetime-edit,
    #validTillDate::-webkit-inner-spin-button,
    #validTillDate::-webkit-clear-button {
        display: none;
    }
</style>
<div id="step2_form">
    <!-- <input type="hidden" id="uId" name="uId" class="form-control" value="<?php echo (!empty($filledInput)) ? $qrUid : uniqid();  ?>" data-reload-qr-code /> -->
    <input type="hidden" id="preview_link" name="preview_link" value="<?php echo (!empty($filledInput)) ? $filledInput['preview_link'] : '';  ?>" class="form-control" data-reload-qr-code />
    <input type="hidden" id="preview_link2" name="preview_link2" value="<?php echo (!empty($filledInput)) ? $filledInput['preview_link2'] : '';  ?>" class="form-control" data-reload-qr-code />
    <input type="hidden" name="setFlip" value="">
    <input type="hidden" name="uploadUniqueId" id="uploadUniqueId" value="">


    <!-- add color palette -->
    <?php include_once('components/design-2-color.php'); ?>


    <div class="custom-accodian">
        <button class="btn accodianBtn" type="button" data-toggle="collapse" data-target="#acc_imageInfo" aria-expanded="true" aria-controls="acc_imageInfo">
            <div class="qr-step-icon">
                <span class="icon-offer grey steps-icon"></span>
            </div>

            <span class="custom-accodian-heading">
                <span><?= l('qr_step_2_coupon.offer_information') ?></span>
                <span class="fields-helper-heading"><?= l('qr_step_2_coupon.help_txt.offer_information') ?></span>
            </span>

            <div class="toggle-icon-wrap ml-2">
                <span class="icon-arrow-h-right grey toggle-icon"></span>
            </div>
        </button>
        <div class="collapse show" id="acc_imageInfo">
            <hr class="accordian-hr">
            <div class="collapseInner">
                <div class="welcome-screen mb-4 pl-2">
                    <span class="bar-code-text" style="display:flex;">
                        <?= l('qr_step_2_coupon.input.companyLogo') ?>
                        <span class="info-tooltip-icon ctp-tooltip" tp-content="<?= l('qr_step_2_coupon.help_tooltip.companyLogo') ?>"></span>
                    </span>
                    <div class="screen-upload">
                        <label for="companyLogo">
                            <input type="hidden" id="companyLogoImage" name="companyLogoImage" value="<?php echo $companyLogo ? $companyLogo : ''; ?>">

                            <input type="file" id="companyLogo" name="companyLogo" class="form-control py-2" accept="image/png, image/gif, image/jpeg, image/svg+xml, image/webp" input_size_validate required />
                            <div class="input-image d-flex" id="company_logo_img">

                                <?php if ($companyLogo) { ?>
                                    <img src="<?php echo $companyLogo; ?>" height="" width="" alt="Company Logo image" id="cl-upl-img" />
                                <?php } ?>
                                <span class="icon-upload-image mb-0" style="display:<?php echo $companyLogo ? 'none' : 'flex'; ?>;" id="cl-tmp-mage"></span>
                            </div>
                            <div class="add-icon" id="company_log_add_icon" style="display:<?php echo  $companyLogo ? 'none' : 'block'; ?>;opacity:0">
                                <svg style="margin: 7px;" class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"></path>
                                </svg>
                            </div>
                            <div class="add-icon" id="company_log_edit_icon" style="display:<?php echo  $companyLogo ? 'block' : 'none'; ?>;opacity:0;">
                                <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 24px;margin: 7px;">
                                    <path d="M20.71,6.29l-3-3a1,1,0,0,0-1.42,0l-12,12a1,1,0,0,0-.26.47l-1,4a1,1,0,0,0,.26.95A1,1,0,0,0,4,21a1,1,0,0,0,.24,0l4-1a1,1,0,0,0,.47-.26l12-12A1,1,0,0,0,20.71,6.29ZM7.49,18.1l-2.12.53.53-2.12,8.6-8.6L16.09,9.5Zm10-10L15.91,6.5,17,5.41,18.59,7Z"></path>
                                </svg>
                            </div>
                        </label>
                        <button type="button" class="delete-btn cl_screen_delete" id="cl_screen_delete" style="display:<?php echo  $companyLogo ? 'block' : 'none'; ?>;">
                            <?= l('qr_step_2_coupon.delete') ?>
                        </button>
                    </div>
                </div>

                <div class="form-group step-form-group">
                    <label for="company"><?= l('qr_step_2_coupon.input.company') ?></label>
                    <input id="company" placeholder="<?= l('qr_step_2_coupon.input.company.placeholder') ?>" name="company" data-anchor="company" class="anchorLoc form-control" value="<?php echo (!empty($filledInput)) ? $filledInput['company'] : ''; ?>" data-reload-qr-code />
                </div>
                <div class="form-group step-form-group">
                    <label for="title"><?= l('qr_step_2_coupon.title') ?></label>
                    <input id="title" placeholder="<?= l('qr_step_2_coupon.input.title.placeholder') ?>" name="title" class="form-control" value="<?php echo (!empty($filledInput)) ? $filledInput['title'] : ''; ?>" data-reload-qr-code />
                </div>
                <div class="form-group step-form-group">
                    <label for="description"><?= l('qr_step_2_coupon.description') ?></label>
                    <textarea id="description" name="description" placeholder="<?= l('qr_step_2_coupon.input.description.placeholder') ?>" data-anchor="company" class="anchorLoc form-control textarea-control"><?php echo (!empty($filledInput)) ? $filledInput['description'] : ''; ?></textarea>
                </div>
                <div class="form-group step-form-group">
                    <div class="d-flex align-items-center py-1" style="line-height:1.25;">
                        <label for="salesBadge" class="mb-0"><?= l('qr_step_2_coupon.sales_badge') ?></label>
                        <span class="info-tooltip-icon ctp-tooltip" tp-content="<?= l('qr_step_2_coupon.help_tooltip.sales_badge') ?>"></span>
                    </div>
                    <input id="salesBadge" placeholder="<?= l('qr_step_2_coupon.input.salesBadge.placeholder') ?>" name="salesBadge" class="form-control" value="<?php echo (!empty($filledInput)) ? $filledInput['salesBadge'] : ''; ?>" data-reload-qr-code />
                </div>
                <div class="form-group m-0 step-form-group">
                    <label for="buttonToSeeCode"><?= l('qr_step_2_coupon.button_code') ?></label>
                    <input id="buttonToSeeCode" placeholder="<?= l('qr_step_2_coupon.input.buttonToSeeCode.placeholder') ?>" name="buttonToSeeCode" data-anchor="buttonToSeeCode" class="anchorLoc form-control" value="<?php echo (!empty($filledInput)) ? $filledInput['buttonToSeeCode'] : ''; ?>" data-reload-qr-code />
                </div>
            </div>
        </div>
    </div>

    <div class="custom-accodian">
        <button class="btn accodianBtn" type="button" data-toggle="collapse" data-target="#acc_couponInfo" aria-expanded="true" aria-controls="acc_couponInfo">
            <div class="qr-step-icon">
                <span class="icon-info grey steps-icon"></span>
            </div>

            <span class="custom-accodian-heading">
                <span class="accodianRequired"><?= l('qr_step_2_coupon.information') ?><sup>*</sup></span>
                <span class="fields-helper-heading"><?= l('qr_step_2_coupon.help_txt.information') ?></span>
            </span>

            <div class="toggle-icon-wrap ml-2">
                <span class="icon-arrow-h-right grey toggle-icon"></span>
            </div>
        </button>
        <div class="collapse show" id="acc_couponInfo">
            <hr class="accordian-hr">
            <div class="collapseInner">
                <div class="couponCode-tgl">
                    <div class="welcome-screen large-screen mb-4">

                        <!-- coupon toggle switch -->
                        <div class="toggleBtn" id="toggleBtn">
                            <div class="custom-control custom-switch d-flex justify-content-center align-items-center">
                                <input type="checkbox" <?php echo isset($filledInput['couponTgl']) ?  ($filledInput['couponTgl'] == 'on'  ? 'checked' : '') : '' ?> class="custom-control-input couponTgl" name="couponTgl" id="couponTgl">
                                <label class="custom-control-label qr-custom-switch fieldLabel coupon-barcode-label" for="couponTgl">
                                    <span class="coupon-toggle-span" style="width:auto;"><?= l('qr_step_2_coupon.use_barcode'); ?></span>
                                </label>
                                <span class="info-tooltip-icon ctp-tooltip" tp-content="<?= l('qr_step_2_coupon.help_tooltip.use_barcode') ?>"></span>
                            </div>
                        </div>

                        <div class="coupon-barcode-image" style="display:<?php echo  isset($filledInput['couponTgl']) ? ($filledInput['couponTgl'] == 'on'  ? 'block' : 'none') : 'none' ?>;margin-top: -15px;padding-left:10px;">
                            <span class="bar-code-text"><?= l('qr_step_2_coupon.barcode_image') ?></span>
                            <!-- Before Upload Priview -->
                            <div class="screen-upload">

                                <label for="offerImage">

                                    <input type="hidden" id="offerImg" name="offerImg" value="<?php echo isset($offerImage) ? $offerImage : ''; ?>">

                                    <input type="file" id="offerImage" name="offerImage" onchange="setTimeout(function() { document.getElementById('loader').style.display = 'block'; document.getElementById('iframesrc').style.visibility = 'hidden'; LoadPreview(); }, 5000);" class="form-control py-2" value="" accept="image/png, image/gif, image/jpeg" input_size_validate data-reload-qr-code />
                                    <div class="input-image d-flex" id="oi-input-image">

                                        <?php if (isset($offerImage) && $offerImage) { ?>
                                            <img src="<?php echo  $offerImage ?>" height="" width="" alt="Welcome screen image" id="oi-upl-img" style="display:<?php echo isset($offerImage) ? ($offerImage != '' ? 'block' : 'none') : 'none'; ?>" />
                                        <?php } ?>
                                        <span class="icon-upload-image mb-0" id="oi-tmp-mage" style="display:<?php echo isset($offerImage) ? ($offerImage != '' ? 'none' : 'flex') : 'flex'; ?>;"></span>
                                    </div>
                                    <div class="add-icon" id="oi-add-icon" style="display:<?php echo  isset($offerImage) ? ($offerImage != '' ? 'none' : 'block') : 'block'; ?>; opacity:0">
                                        <svg style="margin: 7px;" class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"></path>
                                        </svg>
                                    </div>
                                    <div class="add-icon" id="oi-edit-icon" style="display:<?php echo  isset($offerImage) ? ($offerImage != '' ? 'block' : 'none') : 'none'; ?>; opacity:0">
                                        <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 24px;margin: 7px;">
                                            <path d="M20.71,6.29l-3-3a1,1,0,0,0-1.42,0l-12,12a1,1,0,0,0-.26.47l-1,4a1,1,0,0,0,.26.95A1,1,0,0,0,4,21a1,1,0,0,0,.24,0l4-1a1,1,0,0,0,.47-.26l12-12A1,1,0,0,0,20.71,6.29ZM7.49,18.1l-2.12.53.53-2.12,8.6-8.6L16.09,9.5Zm10-10L15.91,6.5,17,5.41,18.59,7Z"></path>
                                        </svg>
                                    </div>
                                </label>
                                <button type="button" class="delete-btn barcode-img-del" id="oi-screen_delete" style="display:<?php echo  isset($offerImage) ? ($offerImage != '' ? 'block' : 'none') : 'none'; ?>;">
                                    <?= l('qr_step_2_coupon.delete') ?>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="coupon-barcode-code" style="display:<?php echo isset($filledInput['couponTgl']) ? ($filledInput['couponTgl'] == 'on'  ? 'none' : 'block') : 'block' ?>;margin-top:-22px;">
                        <div class="form-group step-form-group coupen-code-wrap mb-4">
                            <label for="couponCode"><?= l('qr_step_2_coupon.code') ?> <span class="text-danger text-bold">*</span></label>
                            <input id="couponCode" required placeholder="<?= l('qr_step_2_coupon.input.couponCode.placeholder') ?>" name="couponCode" class="step-form-control" value="<?php echo (!empty($filledInput)) ? $filledInput['couponCode'] : ''; ?>" data-reload-qr-code <?php echo isset($filledInput['couponTgl']) ?  ($filledInput['couponTgl'] == 'on'  ? '' : 'input_validate') : 'input_validate' ?> />
                            <!-- <input id="couponCode" required placeholder="<?= l('qr_step_2_coupon.input.couponCode.placeholder') ?>" name="couponCode" class="form-control" value="<?php echo (!empty($filledInput)) ? $filledInput['couponCode'] : ''; ?>" data-reload-qr-code <?php echo isset($filledInput['couponTgl']) ?  ($filledInput['couponTgl'] == 'on'  ? '' : 'input_validate') : 'input_validate' ?> /> -->
                        </div>
                    </div>
                </div>
                <div class="form-group step-form-group">
                    <label for="validTillDate"><?= l('qr_step_2_coupon.valid_until') ?></label>
                    <input id="validTillDate" onchange="LoadPreview()" min="<?php echo date('Y-m-d'); ?>" type="text" onkeydown={handleKeyDown} data-date="" placeholder="" name="validTillDate" class="form-control" value="<?php echo (!empty($filledInput)) ? $filledInput['validTillDate'] : date('Y-m-d'); ?>" data-reload-qr-code />
                </div>
                <div class="form-group coupon step-form-group">
                    <div class="d-flex align-items-center py-1" style="line-height:1.25;">
                        <label for="terms" class="mb-0"><?= l('qr_step_2_coupon.term') ?></label>
                        <span class="info-tooltip-icon ctp-tooltip" tp-content="<?= l('qr_step_2_coupon.help_tooltip.term') ?>"></span>
                    </div>
                    <!-- onkeydown={handleKeyDown}  -->
                    <textarea id="terms" name="terms" onkeydown={handleKeyDown} placeholder="<?= l('qr_step_2_coupon.term_placeholder') ?>" data-anchor="terms" class="anchorLoc step-form-control textarea-control" maxlength="4000"><?php echo (!empty($filledInput)) ? $filledInput['terms'] : ''; ?></textarea>
                    <div id="theCount" style="float: right; font-size: 0.8rem !important; margin-right: 10px;">
                        <span id="current">0</span>
                        <span id="maximum">/ 4000</span>
                    </div>
                </div>
                <div class="row align-items-end step-form-group m-auto w-100">
                    <div class="form-group pr-2 coupon-btn-detail-wrap col-sm-6 pt-1">
                        <div class="d-flex align-items-center py-1" style="line-height:1.25;">
                            <label for="buttonText" class="mb-0"><?= l('qr_step_2_coupon.button') ?></label>
                            <span class="info-tooltip-icon ctp-tooltip" tp-content="<?= l('qr_step_2_coupon.help_tooltip.button') ?>"></span>
                        </div>
                        <input id="buttonText" placeholder="<?= l('qr_step_2_coupon.input.buttonText.placeholder') ?>" name="buttonText" class="form-control" value="<?php echo (!empty($filledInput)) ? $filledInput['buttonText'] : ''; ?>" data-reload-qr-code />
                    </div>
                    <div class="form-group pl-2 coupon-btn-detail-wrap col-sm-6">
                        <!-- <label for="buttonUrl"></label> -->
                        <input id="buttonUrl" placeholder="<?= l('qr_step_2_coupon.input.buttonURL.placeholder') ?>" name="buttonUrl" data-anchor="company" class="anchorLoc form-control" value="<?php echo (!empty($filledInput)) ? $filledInput['buttonUrl'] : ''; ?>" data-reload-qr-code />
                    </div>
                </div>

                <div class="form-group location-form-group step-form-group mt-4">
                    <p class="paraheading mb-3 pt-4"><?= l('qr_step_2_coupon.location') ?></p>

                    <!-- Location section -->
                    <?php include_once('components/location.php'); ?>
                </div>
            </div>
        </div>
    </div>

    <!-- fonts  -->
    <?php include_once('components/fonts.php'); ?>

    <!-- Welcome Screen sections -->
    <?php include_once('components/welcome-screen.php'); ?>

    <!-- Name sections -->
    <?php include_once('components/qr-name.php'); ?>

    <!-- password sections -->
    <?php include_once('components/password.php'); ?>

    <!-- Folder sections -->
    <?php include_once('components/folder.php'); ?>

    <!-- <?php include_once('accodian-form-group/tracking-analytics.php'); ?> -->

</div>

<script type="text/javascript" src="<?= SITE_URL . 'js/material-date-range-picker/duDatepicker.js' ?>"></script>

<script>
    const handleKeyDown = (event) => {
        if (event.key === 'Enter') {
            event.preventDefault();
        }
    };
</script>

<script>



    
    var months = '<?= l('global.date.long_months.1')?>_<?= l('global.date.long_months.2')?>_<?= l('global.date.long_months.3')?>_<?= l('global.date.long_months.4')?>_<?= l('global.date.long_months.5')?>_<?= l('global.date.long_months.6')?>_<?= l('global.date.long_months.7')?>_<?= l('global.date.long_months.8')?>_<?= l('global.date.long_months.9')?>_<?= l('global.date.long_months.10')?>_<?= l('global.date.long_months.11')?>_<?= l('global.date.long_months.12')?>'.split('_'),
    days = '<?= l('global.date.short_days.7')?>_<?= l('global.date.short_days.1')?>_<?= l('global.date.short_days.2')?>_<?= l('global.date.short_days.3')?>_<?= l('global.date.short_days.4')?>_<?= l('global.date.short_days.5')?>_<?= l('global.date.short_days.6')?>'.split('_');

    duDatepicker('#validTillDate', {
        root:'body',
        clearBtn: true,   
        format: 'yyyy/mm/dd', 
        i18n: new duDatepicker.i18n.Locale(months, null, days, null, null, 1,),

        events: {
            dateChanged : qrCodecheck,
        }
    });

    function qrCodecheck(){
        if($('#couponTgl').is(':checked') && $('#offerImg').val() !== '') {
            $("#2").removeAttr("disabled");
            $('#2').removeClass('disable-btn');
        }
    }

    $('.dudp__button.ok').html('<?= str_replace("'", "\'", l('global.date.ok')) ?> ');
    $('.dudp__button.clear').html('<?= str_replace("'", "\'", l('global.date.clear')) ?>');

    console.log($('.dudp__button.ok').html());

    $('#acc_imageInfo').on('keyup change paste', 'input, select, textarea', ".collapseInner", function() {
        $('[name="setFlip"]').attr('value', false);
    });

    $('#acc_couponInfo').on('keyup change paste', 'input, select, textarea', ".collapseInner", function() {
        $('[name="setFlip"]').attr('value', true);
    });

    $(".cl_screen_delete").on("click", function() {
        $('[name="setFlip"]').attr('value', false);
    });

    // coupon barcode input toggle check
    $("#couponTgl").click(function() {
        if ($(this).prop('checked') == true) {
            $(".coupon-barcode-image").css("display", "block");
            $(".coupon-barcode-code").css("display", "none");
            $("#couponCode").removeAttr("input_validate");
            $("#offerImage").attr("input_validate", 'input_validate');
            LoadPreview();
        } else {
            $(".coupon-barcode-image").css("display", "none");
            $(".coupon-barcode-code").css("display", "block");
            $("#couponCode").attr("input_validate", 'input_validate');
            let upl_img = document.getElementById("oi-upl-img");
            $("#offerImage").removeAttr("input_validate");
            // document.getElementById("oi-tmp-mage").style.display = "flex";
            // $('#offerImg').val('');
            // upl_img.remove();
            LoadPreview();
        }
    });

    window.addEventListener('load', (event) => {
        LoadPreview();

        <?php if ($qrUid) { ?>
            reload_qr_code_event_listener();
            $('#qr-code-wrap').addClass('active');
            $("#2").attr('disabled', false)
            $("#2").removeClass("disable-btn")
        <?php } ?>
    });
    var currentPos;
    $(document).on("input", '.anchorLoc', function(e) {
        if (($('input[name=qrtype_input]').length > 0 && $('input[name=qrtype_input]').val() == "url") || ($('input[name=qrtype_input]').length > 0 && $('input[name=qrtype_input]').val() == "wifi")) {} else {
            currentPos = e.target.getAttribute('data-anchor');
            //   currentPos = $(this).data('anchor');    
        }
    });

    // document.getElementById('iframesrc').src = '<?=LANDING_PAGE_URL?>preview/coupon?lang=<?=user_language($this->user);?>';

    function LoadPreview(welcome_screen = false, showLoader = true, changeAnc = null) {

        // if (showLoader) {
        //     setFrame();
        // }

        if ($("input[name=\"step_input\"]").val() == 2) {
            $("#tabs-1").addClass("active");
            $("#tabs-2").removeClass("active");
            $("#2").removeClass("active");
            $("#1").addClass("active");
        }

        var base_url = '<?php echo UPLOADS_FULL_URL; ?>';

        let uId = document.getElementById('uId').value;
        let primaryColor = document.getElementById('primaryColor').value;
        let SecondaryColor = document.getElementById('SecondaryColor').value;
        var companyLogoUrl = document.getElementById('companyLogoImage').value;
        var offerImageUrl = document.getElementById('offerImg').value;
        let company = document.getElementById('company').value.replace(/&/g, '%26');
        let title = document.getElementById('title').value.replace(/&/g, '%26');
        let description = document.getElementById('description').value.replace(/&/g, '%26');
        let salesBadge = document.getElementById('salesBadge').value;
        let buttonToSeeCode = document.getElementById('buttonToSeeCode').value.replace(/&/g, '%26');
        let couponCode = document.getElementById('couponCode').value.replace(/&/g, '%26');
        let validTillDate = document.getElementById('validTillDate').value;
        let terms = document.getElementById('terms').value.replace(/&/g, '%26');
        let buttonText = document.getElementById('buttonText').value.replace(/&/g, '%26');

        var buttonUrlValue = document.getElementById('buttonUrl').value.replace(/&/g, '%26');
        var buttonUrl = set_url(buttonUrlValue);

        let ship_address = document.getElementById('ship-address1').value.replace(/&/g, '%26');
        let offer_street = document.getElementById('route')?.value.replace(/&/g, '%26') || "";
        let offer_number = document.getElementById('street_number')?.value || "";
        let offer_postalcode = document.getElementById('postal_code')?.value || "";
        let offer_city = document.getElementById('locality')?.value.replace(/&/g, '%26') || "";
        let offer_state = document.getElementById('administrative_area_level_1')?.value.replace(/&/g, '%26') || "";
        let offer_country = document.getElementById('country')?.value.replace(/&/g, '%26') || "";

        var urlValue = document.getElementById('offer_url1')?.value.replace(/&/g, '%26') || "";
        var offer_url1 = set_url(urlValue);

        let latitude = document.getElementById('latitude')?.value || "";
        let longitude = document.getElementById('longitude')?.value || "";
        let street_number = $('#customSwitchToggle').is(":checked");
        let barCodeTgl = $('#couponTgl').is(":checked");
        var screen = document.getElementById("editscreen").value;
        let font_title = document.getElementById('filters_title_by').value;
        let font_text = document.getElementById('filters_text_by').value;

        let flip = $("input[name='setFlip").val() === 'true' ? true : false;


        // check paragraphs and put them to an array
        const paragraphs = terms ? terms.split('\n\n') : [];
        let termsArray = [];

        for (let i = 0; i < paragraphs.length; i++) {
            termsArray.push(paragraphs[i]);
        }

        if (companyLogoUrl == '' && company == '' && couponCode == '' && salesBadge == '' && buttonText == '' && validTillDate == '<?php echo date('Y-m-d');?>' && buttonUrl == '' && buttonToSeeCode == '' && offerImageUrl == '' && termsArray == '' && ship_address == '' && offer_url1 == "" && (latitude == "" || longitude == "") && title == '' && description == '') {
            companyLogoUrl = '<?php echo LANDING_PAGE_URL; ?>images/images/new/sale.webp';
            company = '<?= str_replace("'", "\'", l('qr_step_2_coupon.lp_def_company')) ?>';
            title = '<?= str_replace("'", "\'", l('qr_step_2_coupon.lp_def_title')) ?>';
            description = '<?= str_replace("'", "\'", l('qr_step_2_coupon.lp_def_description')) ?>';
            buttonToSeeCode = '<?= str_replace("'", "\'", l('qr_step_2_coupon.lp_def_buttonToSeeCode')) ?>';
            salesBadge = '<?= str_replace("'", "\'", l('qr_step_2_coupon.lp_def_salesBadge')) ?>';
            termsArray = ['<?= str_replace("'", "\'", l('qr_step_2_coupon.lp_def_terms_1')) ?>', '<?= str_replace("'", "\'", l('qr_step_2_coupon.lp_def_terms_2')) ?>'];
            barCodeTgl = true;
            validTillDate = '<?php echo date('Y-m-d');?>';
            buttonText = '<?= str_replace("'", "\'", l('qr_step_2_coupon.lp_def_buttonText')) ?>';
            buttonUrl = '#';
            offer_url1 = '#';
            street_number = false;
            flip = false;
            offerImageUrl = 'https://t3.ftcdn.net/jpg/02/55/97/94/360_F_255979498_vewTRAL5en9T0VBNQlaDBoXHlCvJzpDl.jpg';
            couponCode = '<?= str_replace("'", "\'", l('qr_step_2_coupon.lp_def_couponCode')) ?>';
        }

        const PreviewData = {
            live: true,
            screen: !welcome_screen ? false : screen,
            ship_address: ship_address,
            company: company,
            title: title,
            description: description,
            salesBadge: salesBadge,
            buttonToSeeCode: buttonToSeeCode,
            couponCode: couponCode,
            validTillDate: validTillDate,
            terms: termsArray,
            buttonText: buttonText,
            buttonUrl: buttonUrl,
            primaryColor: primaryColor,
            SecondaryColor: SecondaryColor,
            companyLogo: companyLogoUrl,
            offerImage: offerImageUrl,
            offer_street: offer_street,
            offer_number: offer_number,
            offer_postalcode: offer_postalcode,
            offer_city: offer_city,
            offer_state: offer_state,
            offer_country: offer_country,
            offer_url1: offer_url1,
            latitude: latitude,
            longitude: longitude,
            street_number: street_number,
            flip: flip,
            barCodeTgl: barCodeTgl,
            font_title: font_title,
            font_text: font_text,
            change: changeAnc || currentPos,
            uId:uId,
            type:'coupon',
            static:false,
            step:2
        };

        document.getElementById('iframesrc').contentWindow?.postMessage(PreviewData,'<?=LANDING_PAGE_URL?>');

        // var frame = $('#iframesrc')[0];
        // var frame2 = $('#iframesrc2')[0];
        // link = link.replace(/#/g, '%23'); //convert # symbol 
        // frame.contentWindow.location.replace(link);
        // if (document.getElementById('iframesrc2')) {
        //     frame2.contentWindow.location.replace(link);
        // }
        // document.getElementById("loader").style.display = "none";
        // document.getElementById("iframesrc").style.visibility = "visible";
        // document.getElementById("preview_link").value = (!welcome_screen && screen !== "") ? welcomeLinks : link;
        // document.getElementById("preview_link2").value = (!welcome_screen && screen !== "") ? welcomeLinks : link;

        let im_url = $('#qr_code').attr('src');
        if ($(".qrCodeImg")) {
            $(".qrCodeImg").html(`<img id="qr_code_p" src=` + im_url + ` class="img-fluid qr-code" loading="lazy" />`);
        }

        if ((barCodeTgl == false && couponCode == '') || (barCodeTgl == true && offerImageUrl == '')) {
            $("#2").addClass('disable-btn');
            $("#2").attr('disabled', true);
        } else {
            $("#2").removeClass('disable-btn');
            $("#2").attr('disabled', false);
            $("#2").attr('onclick', 'save_qr_fn()');
        }
    }

    if($('#qr_status').val()){
        $('#iframesrc').ready(function(){
            setTimeout(()=>{
                LoadPreview()
            },1000)
        })
    }

    $(document).ready(function() {
        $('input[type="file"]').change(function() {
            if (this.id === "screen" || this.id === "companyLogo") {
                return; // exclude elements with id "screen" or "company"
            }
            LoadPreview(false);
        });
        $('input[name="offerImage"]').change(function() {
            $('[name="setFlip"]').attr('value', true);
            LoadPreview(false);

        });
        $('input[name="companyLogo"]').change(function() {
            $('[name="setFlip"]').attr('value', false);
            LoadPreview(false);

        });
    });

    $(document).ready(function() {
        var options = {
            year: 'numeric',
            month: 'short',
            day: 'numeric',
        };

        options.timeZone = "UTC";

        const d = new Date($("#validTillDate").val());
        $("#validTillDate").attr("data-date",
            (d.toLocaleDateString("en-US", options))
        )
    });

    $(document).on('click', '.delete-btn', function() {
        LoadPreview(false);
        $("#couponCode").attr("input_validate", 'input_validate');
        $("#offerImage").removeAttr("input_validate");
    });

    $(document).on('click', '.barcode-img-del', function() {
        if ($("#couponTgl").prop('checked') == false) {
            $("#couponCode").attr("input_validate", 'input_validate');
            $("#offerImage").removeAttr("input_validate");
        }
    });

    $(document).on('click', '#oi-screen_delete', function() {
        $('#qr-code-wrap').removeClass('active');
        $("#2").attr('disabled', true);
        $("#2").addClass("disable-btn");
        $('[name="setFlip"]').attr('value', true);
    });
    $(document).on('click', '#cl_screen_delete', function() {
        $('[name="setFlip"]').attr('value', false);
    });
    $("#terms").on("change", function() {
        LoadPreview(true);
        qrCodecheck();
        if($('#couponTgl').is(':checked') && $('#offerImg').val() !== '') {
            $("#2").removeAttr("disabled");
            $('#2').removeClass('disable-btn');
        }
    });

    // New Change For QR Code preview Pill
    // $(document).on('keyup change paste', 'input, select, textarea', function() {
    //     if($('#couponTgl').is(':checked') && $('#offerImg').val() !== '') {
    //         $("#2").removeAttr("disabled");
    //         $('#2').removeClass('disable-btn');
    //     }
    // });
    // New Change For QR Code preview Pill
    
</script>

<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>

<!-- for passing language variables to qr_form.js -->
<?php
$langVariables = array(
    l('qr_step_2_com_welcome_screen.max_size_allowed_10mb'),
    l('qr_step_2.max_allow_10mb.error'),
    l('qr_step_2.loading')
);
$langVariablesJson = json_encode($langVariables);
?>

<script site-url="<?php echo UPLOADS_FULL_URL; ?>" lang-variables="<?= htmlspecialchars($langVariablesJson, ENT_QUOTES, 'UTF-8'); ?>" src="<?= ASSETS_FULL_URL ?>js/qr_form.js"></script>

<script>
    $("#validTillDate").on("change", function() {
        var options = {
            year: 'numeric',
            month: 'short',
            day: 'numeric',
        };

        options.timeZone = "UTC";

        const d = new Date(this.value);
        this.setAttribute("data-date",
            (d.toLocaleDateString("en-US", options))
        )
        
        // if($('#couponTgl').is(':checked') && $('.input1').val() !== '') {
            //I am checked
            // console.log($('#offerImg').val());
            // $("#2").removeAttr("disabled");
            // $('#2').removeAttr('disabled');
            // $('#2').removeClass('disable-btn');
            // console.log($('#2'));
            // console.log($(this).val());
        // }
    });


    // qr-code-preview by webethics

    $("#exitPreview").click(function() {
        $("#overlayPre").css({
            'opacity': '0',
            'display': 'none'
        });
        $("body").not(".app").removeClass("scroll-none");
        $(".col-right.customScrollbar").removeClass("active");
    });
</script>