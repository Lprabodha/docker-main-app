<?php defined('ALTUMCODE') || die() ?>
<?php
$decodedData = json_decode(isset($data->qr_code[0]['data']) ? $data->qr_code[0]['data'] : null, true);
$qrType = isset($decodedData['type']) ? $decodedData['type'] : null;

if (isset($data->qr_code[0]['data']) && $qrType == 'app') {
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

<style>
    @media (min-width: 0px) and (max-width: 659.95px) {
        .appLink-btn {
            overflow-x: scroll;
        }
    }
</style>

<div id="step2_form">
    <!-- <input type="hidden" id="uId" name="uId" class="form-control" value="<?php echo (!empty($filledInput)) ? $qrUid : uniqid();  ?>" data-reload-qr-code /> -->
    <input type="hidden" id="preview_link" name="preview_link" value="<?php echo (!empty($filledInput)) ? $filledInput['preview_link'] : '';  ?>" class="form-control" data-reload-qr-code />
    <input type="hidden" id="preview_link2" name="preview_link2" value="<?php echo (!empty($filledInput)) ? $filledInput['preview_link2'] : '';  ?>" class="form-control" data-reload-qr-code />
    <input type="hidden" name="uploadUniqueId" id="uploadUniqueId" value="">

    <!-- add color palette -->
    <?php include_once('components/design-2-color.php'); ?>

    <div class="custom-accodian ">
        <button class="btn accodianBtn" type="button" data-toggle="collapse" data-target="#acc_imageInfo" aria-expanded="true" aria-controls="acc_imageInfo">
            <div class="qr-step-icon">
                <span class="icon-info grey steps-icon"></span>
            </div>

            <span class="custom-accodian-heading">
                <span class="accodianRequired"><?= l('qr_step_2_apps.information') ?><sup>*</sup></span>
                <span class="fields-helper-heading"><?= l('qr_step_2_apps.help_txt.app_info') ?></span>
            </span>

            <div class="toggle-icon-wrap ml-2">
                <span class="icon-arrow-h-right grey toggle-icon"></span>
            </div>
        </button>
        <div class="collapse show" id="acc_imageInfo">
            <hr class="accordian-hr">
            <div class="collapseInner">
                <div class="form-group step-form-group app-name-wrap mb-4">
                    <label for="app_title"><?= l('qr_step_2_apps.name') ?> <span class="text-danger text-bold">*</span></label>
                    <input id="app_title" placeholder="<?= l('qr_step_2_apps.input.app_title.placeholder') ?>" name="app_title" data-anchor="app_title" class="anchorLoc step-form-control" value="<?php echo (!empty($filledInput)) ? $filledInput['app_title'] : ''; ?>" required="required" data-reload-qr-code input_validate />
                </div>
                <div class="form-group step-form-group mb-4">
                    <label for="app_company"><?= l('qr_step_2_apps.developer') ?> </label>
                    <input id="app_company" placeholder="<?= l('qr_step_2_apps.input.app_company.placeholder') ?>" name="app_company" data-anchor="app_title" class="anchorLoc step-form-control" value="<?php echo (!empty($filledInput)) ? $filledInput['app_company'] : ''; ?>" data-reload-qr-code />
                </div>

                <div class="welcome-screen mb-4 pl-2">
                    <span class="d-flex">
                        <?= l('qr_step_2_apps.logo') ?>
                        <span
                            class="info-tooltip-icon ctp-tooltip"
                            tp-content="<?= l('qr_step_2_apps.help_tooltip.logo') ?>"
                        ></span>
                    </span>
                    <div class="screen-upload">
                        <label for="companyLogo">

                            <input type="hidden" id="companyLogoImage" name="companyLogoImage" value="<?php echo $companyLogo ? $companyLogo : ''; ?>">

                            <input type="file" id="companyLogo" name="companyLogo" data-anchor="app_title" class="form-control py-2 anchorLoc" accept="image/png, image/gif, image/jpeg, image/svg+xml, image/webp" input_size_validate required />
                            <div class="input-image" id="company_logo_img">

                                <?php if ($companyLogo) { ?>
                                    <img src="<?php echo $companyLogo; ?>" height="" width="" alt="Company Logo image" id="cl-upl-img" />
                                <?php } ?>

                                <span class="icon-upload-image mb-0" style="display:<?php echo $companyLogo ? 'none' : 'flex'; ?>;" id="cl-tmp-mage"></span>
                            </div>
                            <div class="add-icon" id="company_log_add_icon" style="display:<?php echo  $companyLogo ? 'none' : 'block'; ?>; opacity:0;">
                                <svg style="margin: 7px;" class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"></path>
                                </svg>
                            </div>
                            <div class="add-icon" id="company_log_edit_icon" style="display:<?php echo  $companyLogo ? 'block' : 'none'; ?>; opacity:0;">
                                <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 24px;margin: 7px;">
                                    <path d="M20.71,6.29l-3-3a1,1,0,0,0-1.42,0l-12,12a1,1,0,0,0-.26.47l-1,4a1,1,0,0,0,.26.95A1,1,0,0,0,4,21a1,1,0,0,0,.24,0l4-1a1,1,0,0,0,.47-.26l12-12A1,1,0,0,0,20.71,6.29ZM7.49,18.1l-2.12.53.53-2.12,8.6-8.6L16.09,9.5Zm10-10L15.91,6.5,17,5.41,18.59,7Z"></path>
                                </svg>
                            </div>
                        </label>
                        <button type="button" class="delete-btn" id="cl_screen_delete" style="display:<?php echo  $companyLogo ? 'block' : 'none'; ?>;">
                        <?= l('qr_step_2_apps.delete') ?>
                        </button>
                    </div>
                </div>
                <div class="form-group step-form-group mb-4">
                    <label for="app_description"><?= l('qr_step_2_apps.description') ?> </label>
                    <input id="app_description" placeholder="<?= l('qr_step_2_apps.input.app_description.placeholder') ?>" data-anchor="app_title" name="app_description" class="step-form-control anchorLoc" value="<?php echo (!empty($filledInput)) ? $filledInput['app_description'] : ''; ?>" data-reload-qr-code />
                </div>
                <div class="form-group m-0 step-form-group error-placement-wrp app-qr-type">
                    <label for="app_website"> <?= l('qr_step_2_apps.website') ?></label>
                    <input id="app_website" type="url" placeholder="<?= l('qr_step_2_apps.input.app_website.placeholder') ?>" data-anchor="app_website"  name="app_website" class="step-form-control anchorLoc" value="<?php echo (!empty($filledInput)) ? $filledInput['app_website'] : ''; ?>" data-reload-qr-code />
                </div>
            </div>
        </div>
    </div>

    <div class="custom-accodian">
        <button class="btn accodianBtn" type="button" data-toggle="collapse" data-target="#acc_platformOfQrCode" aria-expanded="true" aria-controls="acc_platformOfQrCode">
            <div class="qr-step-icon">
                <span class="icon-links grey steps-icon"></span>
            </div>

            <span class="custom-accodian-heading" >
                <span class="d-none d-sm-block accodianRequired">
                    <?= l('qr_step_2_apps.link_platforms') ?><sup>*</sup>
                </span>
                <span class="d-block d-sm-none" style="text-align: left;">
                    <?= l('qr_step_2_apps.link_platforms') ?>
                    <span class="text-danger text-bold" style="font-size: 20px;">*</span>
                </span>
                <span class="fields-helper-heading"><?= l('qr_step_2_apps.help_txt.link_platforms') ?></span>
            </span>

            <div class="toggle-icon-wrap ml-2">
                <span class="icon-arrow-h-right grey toggle-icon"></span>
            </div>
        </button>
        <div class="collapse show" id="acc_platformOfQrCode">
            <hr class="accordian-hr">
            <div class="collapseInner row-links app-full-wrap">
                <span class="social_err app-text"><?= l('qr_step_2_apps.choose_url') ?> </span>
                <div class="socialFormContainer appLinks">
                    <div class="socialItem google_section app-section" style="display: none;">
                        <div class="app-detail-wrap">
                            <div class="app-icon-wrap d-flex">
                                <span class="app-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16">
                                        <path fill="#2196F3" d="M8.32 7.68.58 15.42c-.37-.35-.57-.83-.57-1.35V1.93C.01 1.4.22.92.6.56l7.72 7.12z" />
                                        <path fill="#FFC107" d="M15.01 8c0 .7-.38 1.32-1.01 1.67l-2.2 1.22-2.73-2.52-.75-.69 2.89-2.89L14 6.33c.63.35 1.01.97 1.01 1.67z" />
                                        <path fill="#4CAF50" d="M8.32 7.68.6.56C.7.46.83.37.96.29 1.59-.09 2.35-.1 3 .26l8.21 4.53-2.89 2.89z" />
                                        <path fill="#F44336" d="M11.8 10.89 3 15.74c-.31.18-.66.26-1 .26-.36 0-.72-.09-1.04-.29a1.82 1.82 0 0 1-.38-.29l7.74-7.74.75.69 2.73 2.52z" />
                                    </svg>
                                </span>
                                <p class="m-0 app-store-text"><?= l('qr_step_2_apps.google_play') ?></p>
                            </div>
                            <div class="socialInput col-7">
                                <input id="google" type="hidden" placeholder="<?= l('qr_step_2_apps.play_store') ?>" name="google" class="position-relative step-form-control" value="<?php echo (!empty($filledInput)) ? $filledInput['google'] : ''; ?>" data-reload-qr-code onkeyup="validation_plateform_url()" />
                            </div>
                            <div class="app-remove-wrap d-flex justify-content-center align-items-center">
                                <button type="button" class="app-btn remove-app-btn" onclick="$('.google_section').hide();$('#google').attr('type','hidden');$('#google').val('');$('#google').removeClass('s_link');$('.google_btn').show();validation_plateform_url();LoadPreview();">
                                    <span class="icon-trash app-delete-icon d-flex align-items-center justify-content-center"></span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="socialItem apple_section app-section" style="display:none;">
                        <div class="app-detail-wrap">
                            <div class="app-icon-wrap d-flex">
                                <span class="app-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" data-name="Layer 1" viewBox="0 0 120 120">
                                        <defs>
                                            <linearGradient id="a" x1="-1315.782" x2="-1195.782" y1="529.793" y2="529.793" gradientTransform="rotate(-90 -832.788 -362.994)" gradientUnits="userSpaceOnUse">
                                                <stop offset="0" stop-color="#1d6ff2" />
                                                <stop offset="1" stop-color="#1ac8fc" />
                                            </linearGradient>
                                        </defs>
                                        <path fill="url(#a)" fill-rule="evenodd" d="M120,26V94a25.94821,25.94821,0,0,1-26,26H26A25.94821,25.94821,0,0,1,0,94V26A25.94821,25.94821,0,0,1,26,0H94A25.94821,25.94821,0,0,1,120,26Z" />
                                        <path fill="#fff" fill-rule="evenodd" d="M82.6,69H97.5a5.5,5.5,0,0,1,0,11H82.6Z" />
                                        <path fill="#fff" fill-rule="evenodd" d="M64.3 69a7.85317 7.85317 0 0 1 7.9 7.9 8.14893 8.14893 0 0 1-.6 3.1H22.5a5.5 5.5 0 0 1 0-11zM62.9 32.8v9.6H56.5L48.7 29a5.19712 5.19712 0 1 1 9-5.2zM68.4 42.1L95.7 89.4a5.48862 5.48862 0 0 1-9.5 5.5L69.7 66.2c-1.5-2.8-2.6-5-3.3-6.2A15.03868 15.03868 0 0 1 68.4 42.1z" data-name="Combined-Shape" />
                                        <path fill="#fff" fill-rule="evenodd" d="M46 74H33.3L62 24.3a5.48862 5.48862 0 0 1 9.5 5.5zM39.3 85.5L34 94.8a5.48862 5.48862 0 1 1-9.5-5.5l3.9-6.8a8.59835 8.59835 0 0 1 3.9-.9A7.77814 7.77814 0 0 1 39.3 85.5z" data-name="Combined-Shape" />
                                    </svg>
                                </span>
                                <p class="m-0 app-store-text"><?= l('qr_step_2_apps.app_store') ?></p>
                            </div>
                            <div class="socialInput col-7">
                                <input id="apple" type="hidden" placeholder="<?= l('qr_step_2_apps.apple_store_url') ?>" name="apple" class="step-form-control position-relative" value="<?php echo (!empty($filledInput)) ? $filledInput['apple'] : ''; ?>" data-reload-qr-code onkeyup="validation_plateform_url()" />
                            </div>
                            <div class="app-remove-wrap d-flex justify-content-center align-items-center">
                                <button type="button" class="app-btn remove-app-btn" onclick="$('.apple_section').hide();$('#apple').attr('type','hidden');$('#apple').val('');$('#apple').removeClass('s_link');$('.apple_btn').show();validation_plateform_url();LoadPreview();">
                                    <span class="icon-trash app-delete-icon d-flex align-items-center justify-content-center"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="socialItem amazone_section app-section" style="display:none;">
                        <div class="app-detail-wrap">
                            <div class="app-icon-wrap d-flex">
                                <span class="app-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" aria-label="Amazon" viewBox="0 0 512 512">
                                        <rect width="512" height="512" fill="#f90" rx="15%" />
                                        <path fill="#fff" d="M283 187c-62 2-121 19-121 81 0 43 26 64 61 64 31 0 51-12 68-30 8 11 10 16 24 27 3 2 8 2 10-1l31-27c4-3 2-8 0-10-7-11-15-19-15-39v-64c0-27 2-52-18-70-17-16-38-20-62-21-53-1-88 28-93 62-1 6 4 9 7 9l37 5c6 1 9-4 10-8 6-22 29-28 43-23 20 6 18 29 18 45zm-36 105c-15 0-25-13-25-30 1-36 29-42 61-42v18c0 32-17 54-36 54zm168 106c13-11 26-38 25-57 0-7-1-8-8-10-13-4-46-5-62 10-3 3-2 5 1 5 11-2 45-6 50 2 4 7-8 35-12 47-2 5 2 6 6 3zM58 342c96 91 247 94 345 25 7-4 0-12-6-9a376 376 0 0 1-335-21c-4-3-8 2-4 5z" />
                                    </svg>
                                </span>
                                <p class="m-0 app-store-text"><?= l('qr_step_2_apps.amazon') ?></p>
                            </div>
                            <div class="socialInput col-7">
                                <input id="amazon" type="hidden" placeholder="<?= l('qr_step_2_apps.amazon_url') ?>" name="amazon" class="position-relative step-form-control" value="<?php echo (!empty($filledInput)) ? $filledInput['amazon'] : ''; ?>" data-reload-qr-code onkeyup="validation_plateform_url()" />
                            </div>
                            <div class="app-remove-wrap d-flex justify-content-center align-items-center">
                                <button type="button" class="app-btn remove-app-btn" onclick="$('.amazone_section').hide();$('#amazon').attr('type','hidden');$('#amazon').val('');$('#amazon').removeClass('s_link');$('.amazone_btn').show();validation_plateform_url();LoadPreview();">
                                    <span class="icon-trash app-delete-icon d-flex align-items-center justify-content-center"></span>
                                </button>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="appLink-btn">
                <!-- <?= l('qr_step_2_apps.google') ?><?= l('qr_step_2_apps.apple') ?><?= l('qr_step_2_apps.amazon') ?> -->
                    <!-- <span><?= l('qr_step_2_apps.add') ?></span> -->
                    <div class="d-flex align-items-center w-100 justify-content-center app-btn-wrap p-2">
                        <button type="button" data-anchor="app_website" class="google_btn add-app-btn anchorLocBtn" onclick="$('.google_section').show();$('#google').attr('type','url');$('#google').val('');$('#google').addClass('s_link');$(this).hide();$('#google').css('border','2px solid #EAEAEC');$('.social_err').html(''); LoadPreview();">Google </button>
                        <button type="button" data-anchor="app_website" class="apple_btn add-app-btn anchorLocBtn" onclick=" $('.apple_section').show();$('#apple').attr('type','url');$('#apple').val('');$(this).hide();$('#apple').addClass('s_link');$('#apple').css('border','2px solid #EAEAEC');$('.social_err').html(''); LoadPreview();"> Apple</button>
                        <button type="button" data-anchor="app_website" class="amazone_btn add-app-btn anchorLocBtn" onclick="$('.amazone_section').show();$('#amazon').attr('type','url');$('#amazon').val('');$('#amazon').addClass('s_link');$(this).hide();$('#amazon').css('border','2px solid #EAEAEC');$('.social_err').html(''); LoadPreview();">Amazon</button>
                    </div>
                </div>
                <!-- <span class="social_err" style="color:red;"><?= l('qr_step_2_apps.choose_url') ?> </span> -->
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

<script>
    $(document).ready(function() {
        <?php if (isset($filledInput['google']) && $filledInput['google']) { ?>
            $('.google_section').show();
            $('#google').attr('type', 'url');
            $('.google_btn').hide();
        <?php } ?>
        <?php if (isset($filledInput['google']) && $filledInput['apple']) { ?>
            $('.apple_section').show();
            $('#apple').attr('type', 'url');
            $('.apple_btn').hide();
        <?php } ?>
        <?php if (isset($filledInput['google']) && $filledInput['amazon']) { ?>
            $('.amazone_section').show();
            $('#amazon').attr('type', 'url');
            $('.amazone_btn').hide();
        <?php } ?>

        <?php if (isset($filledInput['google']) || isset($filledInput['apple']) || isset($filledInput['amazon'])) { ?>
            $(".social_err").html("");
            console.log("social error hide now");
        <?php } ?>
    });

    var base_url = '<?php echo UPLOADS_FULL_URL; ?>'

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
    $(document).on("input click", '.anchorLoc, .anchorLocBtn', function(e) {
        if (($('input[name=qrtype_input]').length > 0 && $('input[name=qrtype_input]').val() == "url") || ($('input[name=qrtype_input]').length > 0 && $('input[name=qrtype_input]').val() == "wifi")) {
            
        } else {
            currentPos = e.target.getAttribute('data-anchor');                     
        }
    });

    // document.getElementById('iframesrc').src = '<?=LANDING_PAGE_URL?>preview/app';

    function LoadPreview(welcome_screen = false, showLoader = true, changeAnc = null) {

        if ($("input[name=\"step_input\"]").val() == 2) {
            $("#tabs-1").addClass("active");
            $("#tabs-2").removeClass("active");
            $("#2").removeClass("active");
            $("#1").addClass("active");
        }

        // if (showLoader)
        //     setFrame();

        let uId = document.getElementById('uId').value;
        let primaryColor = document.getElementById('primaryColor').value;
        let SecondaryColor = document.getElementById('SecondaryColor').value;
        let app_title = document.getElementById('app_title').value.replace(/&/g, '%26');
        let app_description = document.getElementById('app_description').value.replace(/&/g, '%26');

        var appWebValue = document.getElementById('app_website').value.replace(/&/g, '%26');
        var app_website = set_url(appWebValue);

        let app_company = document.getElementById('app_company').value.replace(/&/g, '%26');

        var googleValue = document.getElementById('google').value.replace(/&/g, '%26');
        var google = set_url(googleValue);
        var appleValue = document.getElementById('apple').value.replace(/&/g, '%26');
        var apple = set_url(appleValue);
        var amazonValue = document.getElementById('amazon').value.replace(/&/g, '%26');
        var amazon = set_url(amazonValue);

        let font_title = document.getElementById('filters_title_by').value;
        let font_text = document.getElementById('filters_text_by').value;
        var screen = document.getElementById("editscreen").value;
        var companyLogoUrl = document.getElementById('companyLogoImage').value;


        var all_images = [];
        if ($('#google').attr('type') == "hidden" && $('#google').val() == "") {} else if ($('#google').val() == "") {
            google = "https://play.google.com/store/apps/details";
        } else {
            google = google;
        }
        if ($('#apple').attr('type') == "hidden" && $('#apple').val() == "") {} else if ($('#google').val() == "") {
            apple = "https://apps.apple.com/us/apps";
        } else {
            apple = apple;
        }
        if ($('#amazon').attr('type') == "hidden" && $('#amazon').val() == "") {} else if ($('#amazon').val() == "") {
            amazon = "https://www.amazon.com";
        } else {
            amazon = amazon;
        }


        if (app_title == '' && app_company == '' && app_description == '' && app_website == '' && companyLogoUrl == '' && google == '' && apple == '' && amazon == '') {
            app_title = '<?= str_replace("'", "\'", l('qr_step_2_apps.lp_def_app_title')) ?>';
            app_company = '<?= str_replace("'", "\'", l('qr_step_2_apps.lp_def_app_company')) ?>';
            companyLogoUrl = '<?php echo LANDING_PAGE_URL; ?>images/images/new/nourish.webp';
            app_description = '<?= str_replace("'", "\'", l('qr_step_2_apps.lp_def_app_description')) ?>';
            app_website = '#';
            google = 'http://www.google.com';
            apple = 'http://www.apple.com';
            amazon = 'https://www.amazon.com/';
        }

        const PreviewData = {
            live: true,
            screen: !welcome_screen ? false : screen,
            SecondaryColor: SecondaryColor,
            primaryColor: primaryColor,
            app_title: app_title,
            app_description: app_description,
            font_title: font_title,
            font_text: font_text,
            app_website: app_website,
            app_company: app_company,
            google: google,
            apple: apple,
            amazon: amazon,
            images: all_images,
            companyLogo: companyLogoUrl,
            change: changeAnc || currentPos,
            type:'app',
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

    if (document.getElementById('images')) {
        var images = document.getElementById('images')
        images.onchange = evt => {
            console.log("app file uploaded")
            const [file] = images.files
            if (file) {


                if ($('#cl-upl-img')) {
                    $('#cl-upl-img').remove();
                }
                document.getElementById("cl-tmp-mage").style.display = 'none';
                document.getElementById('app_log_add_icon').style.display = 'none';
                var elem = document.createElement("img");
                elem.setAttribute("src", URL.createObjectURL(file));
                // elem.setAttribute("height", "60");
                // elem.setAttribute("width", "60");
                elem.setAttribute("alt", "Welcome screen image");
                elem.setAttribute("id", "cl-upl-img");
                document.getElementById("app_logo_img").appendChild(elem);
                document.getElementById('images_edit_icon').style.display = "block";
                document.getElementById('cl_screen_delete').style.display = "block";
            }
        }
    }


    function validation_plateform_url() {
        var countLen = $(".s_link").length;
        var allAreFilled = true;
        $("#social_err").html("");

        if (parseInt(countLen) < 1) {
            $(".social_err").html("Choose at least one store below and add a link to your app ");
        } else {
            $(".s_link").each(function() {

                $(this).closest('.socialInput').find('.invalid_err').remove();

                var urlvalue = ($(this).val()).trim();
                if ($(this).attr('type') == 'url') {

                    $(this).css("border", "2px solid #96949C")


                    if ($(this).attr('name') == 'google' || $(this).attr('name') == 'amazon' || $(this).attr('name') == 'apple') {
                        if (/^(http|https|ftp):\/\/[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,}(:[0-9]{1,})?(\/.*)?$/i.test(urlvalue)) {
                            $(this).css("border", "2px solid #96949C")
                            $(this).find(".invalid_err").remove();
                        } else if (/^[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,}(:[0-9]{1,})?(\/.*)?$/i.test(urlvalue)) {
                            $(this).css("border", "2px solid #96949C")
                            $(this).find(".invalid_err").remove();
                        } else {
                            $(this).css("border", "2px solid red")
                            $("<span class=\"invalid_err\"><?= l('qr_step_2.url_error') ?></span>").insertAfter($(this))
                            allAreFilled = false;
                        }
                    }
                }

            })
        }
        return allAreFilled;
    }

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

<script type="text/javascript">
    var qrFormPostUrl = "<?= url('qr-code-generator') ?>";
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