<?php defined('ALTUMCODE') || die() ?>
<?php
$decodedData = json_decode(isset($data->qr_code[0]['data']) ? $data->qr_code[0]['data'] : null, true);
$qrType = isset($decodedData['type']) ? $decodedData['type'] : null;

if (isset($data->qr_code[0]['data']) && $qrType == 'business') {
    $filledInput = json_decode($data->qr_code[0]['data'], true);

    $qrName =  $data->qr_code[0]['name'];
    $qrUid =  $data->qr_code[0]['uId'];

    $companyLogo = $filledInput['companyLogoImage'];
} else {
    $filledInput = array();
    $qrName = null;
    $qrUid = null;
    $companyLogo =  null;
}
?>

<!-- <input type="hidden" id="uId" name="uId" class="form-control" value="<?php echo (!empty($filledInput)) ? $qrUid : uniqid();  ?>" data-reload-qr-code /> -->
<input type="hidden" id="preview_link" name="preview_link" class="form-control" value="<?php echo (!empty($filledInput)) ? $filledInput['preview_link'] : ''; ?>" data-reload-qr-code />
<input type="hidden" id="preview_link2" name="preview_link2" class="form-control" value="<?php echo (!empty($filledInput)) ? $filledInput['preview_link2'] : ''; ?>" data-reload-qr-code />
<input type="hidden" name="uploadUniqueId" id="uploadUniqueId" value="">
<style>
    .addPhone .removeBtn {
        padding-top: 0px !important;
    }
</style>

<div id="step2_form">



    <!-- add color palette -->
    <?php include_once('components/design-2-color.php'); ?>

    <div class="custom-accodian business-info-main-wrp info-block-main-wrp">
        <button class="btn accodianBtn" id="accodianBtn" type="button" data-toggle="collapse" data-target="#acc_businessInfo" aria-expanded="true" aria-controls="acc_businessInfo">
            <div class="qr-step-icon">
                <span class="icon-info grey steps-icon"></span>
            </div>

            <span class="custom-accodian-heading">
                <span class="accodianRequired"><?= l('qr_step_2_business.information') ?><sup>*</sup></span>
                <span class="fields-helper-heading"><?= l('qr_step_2_business.help_txt.information') ?></span>
            </span>

            <div class="toggle-icon-wrap ml-2">
                <span class="icon-arrow-h-right grey toggle-icon"></span>
            </div>
        </button>
        <div class="collapse show" id="acc_businessInfo">
            <hr class="accordian-hr">
            <div class="collapseInner">

                <div class="welcome-screen mb-4">
                    <span style="display:flex;">
                        <?= l('qr_step_2_business.input.companyLogo') ?>
                        <span class="info-tooltip-icon ctp-tooltip" tp-content="<?= l('qr_step_2_business.help_tooltip.companyLogo') ?>"></span>
                    </span>
                    <div class="screen-upload">
                        <label for="companyLogo">

                            <input type="hidden" id="companyLogoImage" name="companyLogoImage" value="<?php echo $companyLogo ? $companyLogo : ''; ?>">

                            <input type="file" id="companyLogo" name="companyLogo" class="form-control py-2" accept="image/png, image/gif, image/jpeg, image/svg+xml, image/webp" input_size_validate required />
                            <div class="input-image" id="company_logo_img">

                                <?php if ($companyLogo) { ?>
                                    <img src="<?php echo $companyLogo; ?>" height="" width="" alt="Company Logo image" id="cl-upl-img" />
                                <?php } ?>
                                <span class="icon-upload-image mb-0" id="cl-tmp-mage" style="display:<?php echo $companyLogo ? 'none' : 'flex'; ?>;"></span>
                            </div>
                            <div class="add-icon" id="company_log_add_icon" style="opacity:0; display:<?php echo  $companyLogo ? 'none' : 'block'; ?>;">
                                <svg style="margin: 7px;" class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"></path>
                                </svg>
                            </div>
                            <div class="add-icon" id="company_log_edit_icon" style="opacity:0; display:<?php echo  $companyLogo ? 'block' : 'none'; ?>;">
                                <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 24px;margin: 7px;">
                                    <path d="M20.71,6.29l-3-3a1,1,0,0,0-1.42,0l-12,12a1,1,0,0,0-.26.47l-1,4a1,1,0,0,0,.26.95A1,1,0,0,0,4,21a1,1,0,0,0,.24,0l4-1a1,1,0,0,0,.47-.26l12-12A1,1,0,0,0,20.71,6.29ZM7.49,18.1l-2.12.53.53-2.12,8.6-8.6L16.09,9.5Zm10-10L15.91,6.5,17,5.41,18.59,7Z"></path>
                                </svg>
                            </div>
                        </label>
                        <button type="button" class="delete-btn" id="cl_screen_delete" style="display:<?php echo  $companyLogo ? 'block' : 'none'; ?>;">
                            <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 24px;">
                                <path d="M20,7H4A1,1,0,0,0,4,9H5.08l.77,9.25a3,3,0,0,0,3,2.75h6.32a3,3,0,0,0,3-2.75L18.92,9H20a1,1,0,0,0,0-2ZM16.16,18.08a1,1,0,0,1-1,.92H8.84a1,1,0,0,1-1-.92L7.09,9h9.82Z"></path>
                                <path d="M9,5h6a1,1,0,0,0,0-2H9A1,1,0,0,0,9,5Z"></path>
                            </svg>
                            <?= l('qr_step_2_business.delete') ?>
                        </button>
                    </div>
                </div>

                <div class="form-group step-form-group">
                    <label for="company"> <?= l('qr_step_2_business.input.company') ?> <span class="text-danger text-bold">*</span></label>
                    <input id="company" name="company" data-anchor="company" class="anchorLoc form-control" value="<?php echo (!empty($filledInput)) ? $filledInput['company'] : ''; ?>" placeholder="<?= l('qr_step_2_business.input.company.placeholder') ?>" required="required" data-reload-qr-code input_validate />
                </div>
                <div class="form-group step-form-group mt-4">
                    <label for="companyTitle"><?= l('qr_step_2_business.title') ?></label>
                    <input id="companyTitle" name="companyTitle" autocomplete="nope" data-anchor="company" class="anchorLoc form-control" value="<?php echo (!empty($filledInput)) ? $filledInput['companyTitle'] : ''; ?>" placeholder="<?= l('qr_step_2_business.input.companyTitle.placeholder') ?>" data-reload-qr-code />
                </div>
                <div class="form-group step-form-group mt-4">
                    <label for="companySubtitle"><?= l('qr_step_2_business.subtitle') ?></label>
                    <input id="companySubtitle" name="companySubtitle" autocomplete="nope" data-anchor="company" class="anchorLoc form-control" value="<?php echo (!empty($filledInput)) ? $filledInput['companySubtitle'] : ''; ?>" placeholder="<?= l('qr_step_2_business.input.companySubtitle.placeholder') ?>" data-reload-qr-code />
                </div>

                <div class=" mb-3 addBusinessButton addRow mt-4" id="add-btn">
                    <?php if ((!empty($filledInput) && (isset($filledInput['businessButtons'])))) { ?>
                        <div class="form-group m-0" id="btn-section">
                            <label for="contactMobiles"> <?= l('qr_step_2_business.input.button') ?></label>
                            <div class="d-flex align-items-center w-100">
                                <div class="d-flex align-items-center w-100">
                                    <input data-anchor="websiteLink" class="anchorLoc form-control mr-3" type="text" autocomplete="nope" id="businessButtons" name="businessButtons" placeholder="<?= l('qr_step_2_business.input.businessButtons.placeholder') ?>" required="required" value="<?php echo ((!empty($filledInput) && ($filledInput['businessButtons'])) ? $filledInput['businessButtons'] : '') ?>" />
                                    <input data-anchor="websiteLink" class="anchorLoc form-control mr-3" type="url" autocomplete="nope" id="businessButtonUrls" name="businessButtonUrls" placeholder="<?= l('qr_step_2_business.input.businessButtonUrls.placeholder') ?>" required="required" value="<?php echo ((!empty($filledInput) && ($filledInput['businessButtonUrls'])) ? $filledInput['businessButtonUrls'] : '') ?>" />
                                </div>
                                <button type="button" class="reapeterCloseIcon removeBtn busRemoveBtn" onclick="showButton(this)">
                                    <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div id="btn-item" class="px-2 mt-3">
                            <button id="add" type="button" class="outlineBtn addRowButton busAddRowBtn all-add-btn"><span class="icon-add-square start-icon add-btn-icon"></span> <span><?= l('qr_step_2_business.input.addButton') ?></span></button>
                        </div>
                    <?php } ?>
                    <div id="btn-item2" class="px-2 mt-3"></div>
                </div>


            </div>
        </div>


    </div>
    <!-- Opening hours section  -->
    <?php include_once('components/opeaning-hours.php'); ?>


    <!-- location section  -->
    <div class="custom-accodian">
        <button class="btn accodianBtn" type="button" data-toggle="collapse" data-target="#acc_location" aria-expanded="true" aria-controls="acc_location">
            <div class="qr-step-icon">
                <span class="icon-location grey steps-icon"></span>
            </div>

            <span class="custom-accodian-heading">
                <span><?= l('qr_step_2_business.location') ?></span>
                <span class="fields-helper-heading"><?= l('qr_step_2_business.help_txt.location') ?></span>
            </span>

            <div class="toggle-icon-wrap ml-2">
                <span class="icon-arrow-h-right grey toggle-icon"></span>
            </div>
        </button>
        <div class="collapse show" id="acc_location">
            <hr class="accordian-hr">
            <div class="collapseInner">
                <?php include_once('components/location.php'); ?>
            </div>
        </div>
    </div>

    <div class="custom-accodian facilities-block-main-wrp">
        <button class="btn accodianBtn" type="button" data-toggle="collapse" data-target="#acc_facilities" aria-expanded="true" aria-controls="acc_facilities">
            <div class="qr-step-icon">
                <span class="icon-medium grey steps-icon"></span>
            </div>

            <span class="custom-accodian-heading">
                <span><?= l('qr_step_2_business.facilities') ?></span>
                <span class="fields-helper-heading"><?= l('qr_step_2_business.help_txt.facilities') ?></span>
            </span>

            <div class="toggle-icon-wrap ml-2">
                <span class="icon-arrow-h-right grey toggle-icon"></span>
            </div>

        </button>
        <div class="collapse show" id="acc_facilities">
            <hr class="accordian-hr">
            <div class="collapseInner">
                <div class="form-group m-0">
                    <ul class="ks-cboxtags facilitiesIcon facility-icons-container">
                        <li data-toggle="" data-placement="bottom" title="ficon">
                            <input onclick="LoadPreview()" type="checkbox" data-anchor="facilitiesBlock" class="anchorLoc" id="ficon" name="ficon" <?php echo (!empty($filledInput)) ? ((isset($filledInput['ficon'])) ? 'checked' : '') : ''; ?> data-reload-qr-code>
                            <span class="facility-text"><?= l('qr_step_2_business.facilities.wifi') ?></span>
                            <label for="ficon" class="boxtagLabel">
                                <span class="icon-ficon"></span>
                            </label>
                        </li>
                        <li data-toggle="" data-placement="bottom" title="ficon1">
                            <input onclick="LoadPreview()" type="checkbox" data-anchor="facilitiesBlock" class="anchorLoc" id="ficon1" name="ficon1" <?php echo (!empty($filledInput)) ? ((isset($filledInput['ficon1'])) ? 'checked' : '') : ''; ?> data-reload-qr-code>
                            <span class="facility-text"><?= l('qr_step_2_business.facilities.seating') ?></span>
                            <label for="ficon1" class="boxtagLabel">
                                <span class="icon-ficon1"></span>
                            </label>
                        </li>
                        <li data-toggle="" data-placement="bottom" title="ficon2">
                            <input onclick="LoadPreview()" type="checkbox" data-anchor="facilitiesBlock" class="anchorLoc" id="ficon2" name="ficon2" <?php echo (!empty($filledInput)) ? ((isset($filledInput['ficon2'])) ? 'checked' : '') : ''; ?> data-reload-qr-code>
                            <span class="facility-text"><?= l('qr_step_2_business.facilities.accessible') ?></span>
                            <label for="ficon2" class="boxtagLabel">
                                <span class="icon-ficon2"></span>
                            </label>
                        </li>
                        <li data-toggle="" data-placement="bottom" title="ficon3">
                            <input onclick="LoadPreview()" type="checkbox" id="ficon3" data-anchor="facilitiesBlock" class="anchorLoc" name="ficon3" <?php echo (!empty($filledInput)) ? ((isset($filledInput['ficon3'])) ? 'checked' : '') : ''; ?> data-reload-qr-code>
                            <span class="facility-text"><?= l('qr_step_2_business.facilities.restroom') ?></span>
                            <label for="ficon3" class="boxtagLabel">
                                <span class="icon-qr-toilet facility-icon"></span>
                            </label>
                        </li>
                        <li data-toggle="" data-placement="bottom" title="ficon4">
                            <input onclick="LoadPreview()" type="checkbox" id="ficon4" data-anchor="facilitiesBlock" class="anchorLoc" name="ficon4" <?php echo (!empty($filledInput)) ? ((isset($filledInput['ficon4'])) ? 'checked' : '') : ''; ?> data-reload-qr-code>
                            <span class="facility-text"><?= l('qr_step_2_business.facilities.child') ?></span>
                            <label for="ficon4" class="boxtagLabel">
                                <span class="icon-ficon4"></span>
                            </label>
                        </li>
                        <li data-toggle="" data-placement="bottom" title="ficon5">
                            <input onclick="LoadPreview()" type="checkbox" id="ficon5" data-anchor="facilitiesBlock" class="anchorLoc" name="ficon5" <?php echo (!empty($filledInput)) ? ((isset($filledInput['ficon5'])) ? 'checked' : '') : ''; ?> data-reload-qr-code>
                            <span class="facility-text"><?= l('qr_step_2_business.facilities.pet') ?></span>
                            <label for="ficon5" class="boxtagLabel">
                                <span class="icon-ficon5"></span>
                            </label>
                        </li>
                        <li data-toggle="" data-placement="bottom" title="ficon6">
                            <input onclick="LoadPreview()" type="checkbox" id="ficon6" data-anchor="facilitiesBlock" class="anchorLoc" name="ficon6" <?php echo (!empty($filledInput)) ? ((isset($filledInput['ficon6'])) ? 'checked' : '') : ''; ?> data-reload-qr-code>
                            <span class="facility-text"><?= l('qr_step_2_business.facilities.parking') ?></span>
                            <label for="ficon6" class="boxtagLabel">
                                <span class="icon-ficon6"></span>
                            </label>
                        </li>
                        <li data-toggle="" data-placement="bottom" title="ficon7">
                            <input onclick="LoadPreview()" type="checkbox" id="ficon7" data-anchor="facilitiesBlock" class="anchorLoc" name="ficon7" <?php echo (!empty($filledInput)) ? ((isset($filledInput['ficon7'])) ? 'checked' : '') : ''; ?> data-reload-qr-code>
                            <span class="facility-text"><?= l('qr_step_2_business.facilities.public_transport') ?></span>
                            <label for="ficon7" class="boxtagLabel">
                                <span class="icon-qr-bus"></span>
                            </label>
                        </li>
                        <li data-toggle="" data-placement="bottom" title="ficon8">
                            <input onclick="LoadPreview()" type="checkbox" id="ficon8" data-anchor="facilitiesBlock" class="anchorLoc" name="ficon8" <?php echo (!empty($filledInput)) ? ((isset($filledInput['ficon8'])) ? 'checked' : '') : ''; ?> data-reload-qr-code>
                            <span class="facility-text"><?= l('qr_step_2_business.facilities.taxi') ?></span>
                            <label for="ficon8" class="boxtagLabel">
                                <span class="icon-qr-taxi facility-icon"></span>
                            </label>
                        </li>
                        <li data-toggle="" data-placement="bottom" title="ficon9">
                            <input onclick="LoadPreview()" type="checkbox" id="ficon9" data-anchor="facilitiesBlock" class="anchorLoc" name="ficon9" <?php echo (!empty($filledInput)) ? ((isset($filledInput['ficon9'])) ? 'checked' : '') : ''; ?> data-reload-qr-code>
                            <span class="facility-text"><?= l('qr_step_2_business.facilities.lodging') ?></span>
                            <label for="ficon9" class="boxtagLabel">
                                <span class="icon-ficon9"></span>
                            </label>
                        </li>
                        <li data-toggle="" data-placement="bottom" title="ficon10">
                            <input onclick="LoadPreview()" type="checkbox" id="ficon10" data-anchor="facilitiesBlock" class="anchorLoc" name="ficon10" <?php echo (!empty($filledInput)) ? ((isset($filledInput['ficon10'])) ? 'checked' : '') : ''; ?> data-reload-qr-code>
                            <span class="facility-text"><?= l('qr_step_2_business.facilities.coffee') ?></span>
                            <label for="ficon10" class="boxtagLabel">
                                <span class="icon-qr-coffee facility-icon"></span>
                            </label>
                        </li>
                        <li data-toggle="" data-placement="bottom" title="ficon11">
                            <input onclick="LoadPreview()" type="checkbox" id="ficon11" data-anchor="facilitiesBlock" class="anchorLoc" name="ficon11" <?php echo (!empty($filledInput)) ? ((isset($filledInput['ficon11'])) ? 'checked' : '') : ''; ?> data-reload-qr-code>
                            <span class="facility-text"><?= l('qr_step_2_business.facilities.bar') ?></span>
                            <label for="ficon11" class="boxtagLabel">
                                <span class="icon-ficon11"></span>
                            </label>
                        </li>
                        <li data-toggle="" data-placement="bottom" title="ficon12">
                            <input onclick="LoadPreview()" type="checkbox" id="ficon12" data-anchor="facilitiesBlock" class="anchorLoc" name="ficon12" <?php echo (!empty($filledInput)) ? ((isset($filledInput['ficon12'])) ? 'checked' : '') : ''; ?> data-reload-qr-code>
                            <span class="facility-text"><?= l('qr_step_2_business.facilities.restaurant') ?></span>
                            <label for="ficon12" class="boxtagLabel">
                                <span class="icon-ficon12"></span>
                            </label>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>



    <!-- Welcome Screen sections -->
    <?php include_once('components/contact-information.php'); ?>

    <!-- add  none-->
    <?php include_once('components/social-icons.php'); ?>



    <div class="custom-accodian about-block-main-wrp">
        <button class="btn accodianBtn" type="button" data-toggle="collapse" data-target="#acc_aboutCompany" aria-expanded="true" aria-controls="acc_aboutCompany">
            <div class="qr-step-icon">
                <span class="icon-upload-image grey steps-icon"></span>
            </div>
            <span class="custom-accodian-heading"> <?= l('qr_step_2_business.input.aboutCompany') ?>
                <span class="fields-helper-heading"><?= l('qr_step_2_business.help_txt.aboutCompany') ?></span>
            </span>
            <div class="toggle-icon-wrap ml-2">
                <span class="icon-arrow-h-right grey toggle-icon"></span>
            </div>
        </button>
        <div class="collapse show" id="acc_aboutCompany">
            <hr class="accordian-hr">
            <div class="collapseInner">
                <div class="form-group step-form-group pt-3 m-0">
                    <textarea id="aboutCompany" name="aboutCompany" placeholder="<?= l('qr_step_2_business.input.aboutCompany.placeholder') ?>" data-anchor="aboutCompanyBlock" class="anchorLoc form-control textarea-control" rows="5" style="border-radius: 4px;"><?php echo isset($filledInput['aboutCompany']) ? $filledInput['aboutCompany'] : ''; ?></textarea>
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
</div>



<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>

<script>
    const timer = document.querySelectorAll(".timepicker");
    M.Timepicker.init(timer, {});

    $(document).on('focus', '.timepicker', function() {
        const timer = document.querySelectorAll(".timepicker");
        M.Timepicker.init(timer, {});
        $(".timepicker-close:first-child").addClass("time-cancel-btn");
        $(".timepicker-close:last-child").addClass("time-ok-btn");
    });

    $('.time-ok-btn').html('<?= str_replace("'", "\'", l('global.date.ok')) ?> ');
    $('.time-cancel-btn').html('<?= str_replace("'", "\'", l('global.date.clear')) ?>');

    $(document).on('click', '.timepicker-close , .bottom-back-btn', function() {
        $(".timepicker-modal").removeClass("open");
        $(".timepicker-modal").hide();
        $('.bg-white').css({
            'overflow': 'auto'
        });
    });

    $(document).ready(function() {
        $(".timepicker-modal").removeClass("open");
        $(".timepicker-modal").hide();
    });

    var image_uploaded = false;

    var base_url = '<?php echo UPLOADS_FULL_URL; ?>';

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
        }
    });

    var currentPos;
    $(document).on("input click", '.anchorLoc, .anchorLocBtn', function(e) {
        if (($('input[name=qrtype_input]').length > 0 && $('input[name=qrtype_input]').val() == "url") || ($('input[name=qrtype_input]').length > 0 && $('input[name=qrtype_input]').val() == "wifi")) {} else {
            currentPos = e.target.getAttribute('data-anchor');
        }
    });


    // document.getElementById('iframesrc').src = '<?=LANDING_PAGE_URL?>preview/business';

    function LoadPreview(welcome_screen = false, showLoader = true,anchor=null) {

        // if (showLoader)
        //     setFrame();

        if ($("input[name=\"step_input\"]").val() == 2) {
            $("#tabs-1").addClass("active");
            $("#tabs-2").removeClass("active");
            $("#2").removeClass("active");
            $("#1").addClass("active");
        }

        let uId = document.getElementById('uId').value;
        let primaryColor = document.getElementById('primaryColor').value;
        let SecondaryColor = document.getElementById('SecondaryColor').value;
        let companyLogoUrl = document.getElementById('companyLogoImage').value;
        let company = document.getElementById('company').value.replace(/&/g, '%26');
        let companyTitle = document.getElementById('companyTitle').value.replace(/&/g, '%26');
        let cardContainer = true;
        let companySubtitle = document.getElementById('companySubtitle').value.replace(/&/g, '%26');
        let Monday_From = document.getElementById('Monday_From').value;
        let Monday_To = document.getElementById('Monday_To').value;
        let Tuesday_From = document.getElementById('Tuesday_From').value;
        let Tuesday_To = document.getElementById('Tuesday_To').value;
        let Wednesday_From = document.getElementById('Wednesday_From').value;
        let Wednesday_To = document.getElementById('Wednesday_To').value;
        let Thursday_From = document.getElementById('Thursday_From').value;
        let Thursday_To = document.getElementById('Thursday_To').value;
        let Friday_From = document.getElementById('Friday_From').value;
        let Friday_To = document.getElementById('Friday_To').value;
        let Saturday_From = document.getElementById('Saturday_From').value;
        let Saturday_To = document.getElementById('Saturday_To').value;
        let Sunday_From = document.getElementById('Sunday_From').value;
        let Sunday_To = document.getElementById('Sunday_To').value;
        let ship_address = document.getElementById('ship-address1').value.replace(/&/g, '%26');
        let contactName = document.getElementById('contactName').value.replace(/&/g, '%26');

        var contactWebValue = document.getElementById('contactWebsite').value.replace(/&/g, '%26');
        var contactWebsite = set_url(contactWebValue);

        var businessButtons = document.getElementById('businessButtons')?.value.replace(/&/g, '%26') || "";
        let businessButtonsCreated = "0";
        if (document.getElementById('businessButtons')) {
            businessButtonsCreated = "1";
        }

        var urlValue = document.getElementById('businessButtonUrls')?.value.replace(/&/g, '%26') || "";
        var businessButtonUrls = set_url(urlValue);

        let aboutCompany = document.getElementById('aboutCompany').value.replace(/&/g, '%26');

        let contactMobiles = $("input[name='contactMobileTitles[]']").map((i,e)=>{
            return {
                title:e.value,
                number:$("input[name='contactMobiles[]']")[i].value
            };
        }).get();

        let contactEmails = $("input[name='contactEmailTitles[]']").map((i,e)=>{
            return {
                title:e.value,
                email:$("input[name='contactEmails[]']")[i].value
            };
        }).get();

        // ficon
        let ficons = $("input[name*='ficon']").map(function() {
            if ($(this).is(":checked")) {
                return $(this).attr('name');
            }
        }).get();

        let vcard_website = $("input[name='vcard_website[]']").map(function() {
            return $(this).val().replace(/&/g, '%26');
        }).get();

        // set social icons
        let socialLinks = $("input[name='social_icon_name[]']").map((i,elm)=>{
            return {
                name:$(elm).attr('data-attr') + '' + $(elm).val(),
                text:$("input[name='social_icon_text[]']")[i].value,
                icon:$("input[name='social_icon[]']")[i].value,
                url:$("input[name='social_icon_url[]']")[i].value
            }
        }).get();

        //map opening hours to an object
        var mondayObj = [];
        var tuesdayObj = [];
        var wednesdayObj = [];
        var thursdayObj = [];
        var fridayObj = [];
        var saturdayObj = [];
        var sundayObj = [];

        if ($("#checkboxMon").is(':checked')) {

            var mondayTo = $("input[name='Monday_To[]']").map(function(index) {
                return $(this).val();
            }).get();

            $("input[name='Monday_From[]']").each(function(i, v) {
                if ($(this).val()) {
                    mondayObj.push({
                        'from': $(v).val(),
                        'to': mondayTo[i],
                    });
                }
            });
        }
        if ($("#checkboxTue").is(':checked')) {
            var tuesdayTo = $("input[name='Tuesday_To[]']").map(function(index) {
                return $(this).val();
            }).get();

            $("input[name='Tuesday_From[]']").each(function(i, v) {
                if ($(this).val()) {
                    tuesdayObj.push({
                        'from': $(v).val(),
                        'to': tuesdayTo[i],
                    });
                }
            });
        }
        if ($("#checkboxWed").is(':checked')) {
            var WednesdayTo = $("input[name='Wednesday_To[]']").map(function(index) {
                return $(this).val();
            }).get();

            $("input[name='Wednesday_From[]']").each(function(i, v) {
                if ($(this).val()) {
                    wednesdayObj.push({
                        'from': $(v).val(),
                        'to': WednesdayTo[i],
                    });
                }
            });
        }
        if ($("#checkboxThu").is(':checked')) {
            var thursdayTo = $("input[name='Thursday_To[]']").map(function(index) {
                return $(this).val();
            }).get();

            $("input[name='Thursday_From[]']").each(function(i, v) {
                if ($(this).val()) {
                    thursdayObj.push({
                        'from': $(v).val(),
                        'to': thursdayTo[i],
                    });
                }
            });
        }
        if ($("#checkboxFri").is(':checked')) {

            var fridayTo = $("input[name='Friday_To[]']").map(function(index) {
                return $(this).val();
            }).get();

            $("input[name='Friday_From[]']").each(function(i, v) {
                if ($(this).val()) {
                    fridayObj.push({
                        'from': $(v).val(),
                        'to': fridayTo[i],
                    });
                }
            });
        }
        if ($("#checkboxSat").is(':checked')) {
            var saturdayTo = $("input[name='Saturday_To[]']").map(function(index) {
                return $(this).val();
            }).get();


            $("input[name='Saturday_From[]']").each(function(i, v) {
                if ($(this).val()) {
                    saturdayObj.push({
                        'from': $(v).val(),
                        'to': saturdayTo[i],
                    });
                }
            });
        }
        if ($("#checkboxSun").is(':checked')) {
            var sundayTo = $("input[name='Sunday_To[]']").map(function(index) {
                return $(this).val();
            }).get();

            $("input[name='Sunday_From[]']").each(function(i, v) {
                if ($(this).val()) {
                    sundayObj.push({
                        'from': $(v).val(),
                        'to': sundayTo[i],
                    });
                }
            });

        }
        let weekDays = {
            'Monday': mondayObj,
            'Tuesday': tuesdayObj,
            'Wednesday': wednesdayObj,
            'Thursday': thursdayObj,
            'Friday': fridayObj,
            'Saturday': saturdayObj,
            'Sunday': sundayObj,
        };

        let areAllDaysNull = Object.values(weekDays).every(day => day.length === 0);

        let street_number = $('#customSwitchToggle').is(":checked");

        let offer_street = document.getElementById('route')?.value.replace(/&/g, '%26') || "";
        let offer_number = document.getElementById('street_number')?.value || "";
        let offer_postalcode = document.getElementById('postal_code')?.value || "";
        let offer_city = document.getElementById('locality')?.value.replace(/&/g, '%26') || "";
        let offer_state = document.getElementById('administrative_area_level_1')?.value.replace(/&/g, '%26') || "";
        let offer_country = document.getElementById('country')?.value.replace(/&/g, '%26') || "";

        var urlValue = document.getElementById('offer_url1')?.value.replace(/&/g, '%26') || "";
        if (/^(http|https|ftp):\/\/[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,}(:[0-9]{1,})?(\/.*)?$/i.test(urlValue)) {
            var offer_url1 = document.getElementById('offer_url1')?.value.replace(/&/g, '%26') || "";
        } else if (/^[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,}(:[0-9]{1,})?(\/.*)?$/i.test(urlValue)) {
            var output = "https://" + urlValue;
            var offer_url1 = output;
        } else if (urlValue == "") {
            var offer_url1 = "";
        }

        let latitude = document.getElementById('latitude')?.value || "";
        let longitude = document.getElementById('longitude')?.value || "";
        let font_title = document.getElementById('filters_title_by').value;
        let font_text = document.getElementById('filters_text_by').value;
        var screen = document.getElementById("editscreen").value;


        if (
            companyLogoUrl == '' && 
            contactWebsite == '' && 
            company == '' && 
            companyTitle == '' && 
            companySubtitle == '' && 
            aboutCompany == '' && 
            ficons.length == 0 && 
            areAllDaysNull && 
            contactName == '' && businessButtonsCreated === "0" &&
            ship_address == '' && 
            offer_url1 == "" && 
            (latitude == "" || longitude == "")
        ) {
            companyLogoUrl = '<?php echo LANDING_PAGE_URL; ?>images/images/new/business.webp';
            company = '<?= str_replace("'", "\'", l('qr_step_2_business.lp_def_company')) ?>';
            companyTitle = '<?= str_replace("'", "\'", l('qr_step_2_business.lp_def_company_title')) ?>';
            companySubtitle = '<?= str_replace("'", "\'", l('qr_step_2_business.lp_def_company_subtitle')) ?>';
            businessButtons = '<?= str_replace("'", "\'", l('qr_step_2_business.lp_def_business_buttons')) ?>';
            cardContainer = false;
            contactEmails = [{title:'',email:'<?= str_replace("'", "\'", l('qr_step_2_business.lp_def_contact_emails')) ?>'}];
            contactMobiles = [{title:'',number:'<?= str_replace("'", "\'", l('qr_step_2_business.lp_def_contact_mobiles')) ?>'}];
            aboutCompany = '<?= str_replace("'", "\'", l('qr_step_2_business.lp_def_about_company')) ?>';
            contactName = '<?= str_replace("'", "\'", l('qr_step_2_business.lp_def_contactName')) ?>';
            contactWebsite = '#';
            businessButtonUrls = '#';
            offer_street = '<?= str_replace("'", "\'", l('qr_step_2_business.lp_def_offer_street')) ?>';
            offer_number = '<?= str_replace("'", "\'", l('qr_step_2_business.lp_def_offer_street')) ?>';
            offer_postalcode = '<?= str_replace("'", "\'", l('qr_step_2_business.lp_def_offer_postalcode')) ?>';
            offer_city = '<?= str_replace("'", "\'", l('qr_step_2_business.lp_def_offer_city')) ?>';
            offer_state = '<?= str_replace("'", "\'", l('qr_step_2_business.lp_def_offer_state')) ?>';
            offer_country = '<?= str_replace("'", "\'", l('qr_step_2_business.lp_def_offer_country')) ?>'
            offer_url1 = '#';
            ficons = ['ficon', 'ficon1', 'ficon2', 'ficon3', 'ficon4', 'ficon5', 'ficon6', 'ficon7', 'ficon8', 'ficon9', 'ficon10', 'ficon11', 'ficon12'];
            socialLinks = [
                {name:'',text:'Social Account',icon:'Facebook',url:'<?=LANDING_PAGE_URL?>images/social/facebook.png'},
                {name:'',text:'Social Account',icon:'Instagram',url:'<?=LANDING_PAGE_URL?>images/social/instagram.png'},
                {name:'',text:'Social Account',icon:'Google',url:'<?=LANDING_PAGE_URL?>images/social/google.png'},
                {name:'',text:'Social Account',icon:'Linkedin',url:'<?=LANDING_PAGE_URL?>images/social/linkedin.png'},
                {name:'',text:'Social Account',icon:'TikTok',url:'<?=LANDING_PAGE_URL?>images/ListOfLinks/tiktok.png'}
            ]
            street_number = true;
            businessButtons = '<?= str_replace("'", "\'", l('qr_step_2_business.lp_def_business_buttons')) ?>'

            weekDays = {
                "Monday": [{
                    "from": "10:00",
                    "to": "17:00"
                }],
                "Tuesday": [{
                    "from": "10:00",
                    "to": "17:00"
                }],
                "Wednesday": [{
                    "from": "10:00",
                    "to": "17:00"
                }],
                "Thursday": [{
                    "from": "10:00",
                    "to": "17:00"
                }],
                "Friday": [{
                    "from": "10:00",
                    "to": "17:00"
                }],
                "Saturday": [{
                    "from": "10:00",
                    "to": "17:00"
                }],
                "Sunday": [{
                    "from": "10:00",
                    "to": "05:00"
                }]
            }
        }

        const PreviewData = {
            live:true,
            contactMobiles: contactMobiles,
            contactEmails: contactEmails,
            font_title: font_title,
            font_text: font_text,
            socialLinks: socialLinks,
            aboutCompany: aboutCompany,
            weekDays:weekDays,
            primaryColor: primaryColor,
            SecondaryColor: SecondaryColor,
            companyLogo: companyLogoUrl,
            company: company,
            companyTitle: companyTitle,
            companySubtitle: companySubtitle,
            screen: !welcome_screen ? false : screen,
            contactName: contactName,
            contactWebsite: contactWebsite,
            businessButtons: businessButtons,
            businessButtonUrls: businessButtonUrls,
            businessButtonsCreated: businessButtonsCreated,
            cardContainer: cardContainer,
            ship_address: ship_address,
            offer_street: offer_street,
            offer_number: offer_number,
            offer_postalcode: offer_postalcode,
            offer_city: offer_city,
            offer_state: offer_state,
            offer_country: offer_country,
            offer_url1: offer_url1,
            latitude: latitude,
            longitude: longitude,
            ficons: ficons,
            street_number: street_number,
            change: anchor || currentPos,
            uId:uId,
            type:'business',
            static:false,
            step:2
        };

        document.getElementById('iframesrc').contentWindow.postMessage(PreviewData,'<?=LANDING_PAGE_URL?>');

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
    });

    $(document).on('click', '.delete-btn', function() {
        LoadPreview(false);
    });

    $('.colorPalette').on('click', function(e) {
        element.classList.add("active");
    });
</script>

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
    $('.day').each(function() {
        var day = $(this).attr('id');
        element.classList.add("active");
    });
</script>
<script>
    var manualClicked = false;
    var urlClicked = false;
    var coClicked = false;
    var phoneNumber = 0;
    var emailNumber = 0;
</script>


<script>
    (function($, window, document, undefined) {
        var pluginName = "formRepeater2",
            defaults = {
                addBtnId: "#add1",
            };

        function Plugin(element, options) {
            this.container = $(element);
            this.options = $.extend({}, defaults, options);
            this._defaults = defaults;
            this._name = pluginName;
            this.init();
        }

        Plugin.prototype.init = function() {
            var rows = $("#phone1", this.container);
            console.log("rows", rows)
            if (rows.length === 0) {
                return;
            }

            this.numGroups = rows.length;
            this.maxGroupIndex = this.numGroups - 1;

            this.template = $(rows[0]).clone(true);
            this.template.find(":input").val("");

            this.lastGroup = $(rows[this.maxGroupIndex]);

            rows.each($.proxy(initGroup, this));

            this.container.on("click", this.options.addBtnId, $.proxy(addGroup, this));
        };

        function addFieldIds(groupIndex, group) {
            // add unique IDs to each field to aid automation testing
            // following is just to show that method was called
        };

        function initGroup(groupIndex, group) {
            var group = $(group);
            $.proxy(addFieldIds, this)(groupIndex, group);
        };

        function addGroup(ev) {
            var newGroup;
            ev.preventDefault();

            this.numGroups += 1;
            this.maxGroupIndex += 1;
            newGroup = this.template.clone(true);

            $.proxy(initGroup, this)(this.maxGroupIndex, newGroup);

            newGroup.insertAfter(this.lastGroup);
            this.lastGroup = newGroup;
        };

        $.fn[pluginName] = function(options) {
            return this.each(function() {
                if (!$.data(this, "plugin_" + pluginName)) {
                    $.data(this, "plugin_" + pluginName, new Plugin(this, options));
                }
            });
        };

    }(jQuery));

    $("#myform").formRepeater2();
</script>
<script>
    function remove_me(elm) {
        $(elm).parent().parent().remove();
        LoadPreview(true);
    }
</script>
<script>
    // qr-code-preview by webethics

    $("#exitPreview").click(function() {
        $("#overlayPre").css({
            'opacity': '0',
            'display': 'none'
        });
        $(".col-right.customScrollbar").removeClass("active");
    });

    $(document).ready(function() {
        $('.facility-icons-container li input[type="checkbox"]:checked').each(function() {
            var parentLi = $(this).parent();
            parentLi.addClass('active-facility');
        });
    });

    $(document).on('click', '.facility-icons-container li input', function() {
        if ($(this).is(':checked')) {
            $(this).parents("li").addClass("active-facility");
        } else {
            $(this).parents("li").removeClass("active-facility");
        }
    });
</script>