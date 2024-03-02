<?php defined('ALTUMCODE') || die() ?>

<?php
$decodedData = json_decode(isset($data->qr_code[0]['data']) ? $data->qr_code[0]['data'] : null, true);
$qrType = isset($decodedData['type']) ? $decodedData['type'] : null;

if (isset($data->qr_code[0]['data']) && $qrType == 'mp3') {
    $filledInput = json_decode($data->qr_code[0]['data'], true);
    $qrName =  $data->qr_code[0]['name'];
    $qrUid =  $data->qr_code[0]['uId'];

    $companyLogo = $filledInput['companyLogoImage'];

    $mp3File = $filledInput['mp3File'];
} else {
    $filledInput = array();
    $QrName = null;
    $qrUid = null;
    $companyLogo =  null;
    $mp3File =  null;
}
?>

<style>
    .multiline-ellipsis {
        overflow: hidden;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 3;
        /* start showing ellipsis when 3rd line is reached */
        white-space: pre-wrap;
        /* let the text wrap preserving spaces */
    }
</style>

<div id="step2_form">
    <!-- <input type="hidden" id="uId" name="uId" class="form-control" value="<?php echo (!empty($filledInput)) ? $qrUid : uniqid();  ?>" data-reload-qr-code /> -->
    <input type="hidden" id="preview_link" name="preview_link" class="form-control" value="<?php echo (!empty($filledInput)) ? $filledInput['preview_link'] : '';  ?>" data-reload-qr-code />
    <input type="hidden" id="preview_link2" name="preview_link2" value="<?php echo (!empty($filledInput)) ? $filledInput['preview_link2'] : '';  ?>" class="form-control" data-reload-qr-code />
    <input type="hidden" name="uploadUniqueId" id="uploadUniqueId" value="">


    <div class="custom-accodian mp3-upload-main-wrap upload-main-wrp">
        <button class="btn accodianBtn" type="button" data-toggle="collapse" data-target="#acc_nameOfMp3" aria-expanded="true" aria-controls="acc_nameOfMp3">
            <div class="qr-step-icon">
                <span class="icon-info grey steps-icon"></span>
            </div>

            <span class="custom-accodian-heading">
                <span class="accodianRequired"><?= l('qr_step_2_mp3.input') ?><sup>*</sup></span>
                <span class="fields-helper-heading"><?= l('qr_step_2_mp3.help_txt.input') ?></span>
            </span>

            <div class="toggle-icon-wrap ml-2">
                <span class="icon-arrow-h-right grey toggle-icon"></span>
            </div>
        </button>
        <div class="collapse show" id="acc_nameOfMp3">
            <hr class="accordian-hr">
            <div class="collapseInner">

                <div class="custom-upload">
                    <input type="hidden" name="mp3File" id="mp3File" class="anchorLoc" value="<?php echo $mp3File ? $mp3File : ''; ?>">
                    <div class="dropzone dropzone fileupload col-12 anchorLocBtn" id="mp3" data-anchor="mp3File" style="display:<?php echo  $mp3File ? 'none' : 'block'; ?>;">
                    </div>
                    <span class="col-lg-12 col-xl-12 error" id="logo-error" style="color:red;"></span>
                    <div id="img_previews">
                    </div>
                    <div id="custom-dropzone-preview" class="mp3-drpzone dropzone-previews dropzone col-12 d-flex" style="display:<?php echo  $mp3File ? 'block' : 'none !important'; ?>;">
                        <!-- <span class="touch-detect "></span> -->
                        <?php if ($mp3File) { ?>
                            <div class="dz-preview dz-file-preview dz-complete">
                                <div class="dz-image"><img data-dz-thumbnail="" src="./themes/altum/assets/images/mp3.png"></div>
                                <span class="hover-effect-icon edit-hover-icon"></span>
                                <div class="upload-edit-wrap mp3-file-edit-upload">
                                    <span class="image-edit-icon"></span>
                                </div>
                                <a class="dz-remove" data-dz-remove=""><?= l('qr_step_2_mp3.delete') ?><span class="dz-remove-icon"></span></a>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="row">
                        <!-- <input type="hidden" name="is_mp3" value="0" id="is_mp3"> -->
                    </div>
                </div>
                <div class="checkbox-wrapper">
                    <div class="roundCheckbox m-2 mr-3">
                        <input type="checkbox" style="border:<?php echo $mp3File ? '2px solid #767c83' : '1px solid #a3abad' ?>" id="addDownloadOption" onchange="LoadPreview()" name="addDownloadOption" <?php echo (!empty($filledInput)) ? ((isset($filledInput['addDownloadOption'])) ? 'checked' : '') : '';  ?> <?php echo $mp3File ? '' : 'disabled';  ?> />
                        <label class="m-0 download-option" for="addDownloadOption" style="cursor:<?php echo $mp3File ? 'pointer' : 'auto' ?>;border:<?php echo $mp3File ? '2px solid #767c83' : '1px solid #a3abad' ?>;"></label>
                    </div>
                    <label class="passwordlabel checkbox-label mb-0" style="color:<?php echo $mp3File ? '#767c83' : '#a3abad' ?>">
                        <?= l('qr_step_2_mp3.add_option') ?>
                        <span style="line-height:1.25;" class="info-tooltip-icon ctp-tooltip" tp-content="<?= l('qr_step_2_mp3.help_tooltip.add_option') ?>"></span>
                    </label>
                </div>
            </div>
        </div>
    </div>

    <!-- add color palette -->
    <?php include_once('components/design-2-color.php'); ?>

    <div class="custom-accodian mp3-info-main-wrp info-block-main-wrp">
        <button class="btn accodianBtn" type="button" data-toggle="collapse" data-target="#acc_imageInfo" aria-expanded="true" aria-controls="acc_imageInfo">
            <div class="qr-step-icon">
                <span class="icon-info grey steps-icon"></span>
            </div>

            <span class="custom-accodian-heading">
                <span><?= l('qr_step_2_mp3.basic_information') ?></span>
                <span class="fields-helper-heading"><?= l('qr_step_2_mp3.help_txt.basic_information') ?></span>
            </span>

            <div class="toggle-icon-wrap ml-2">
                <span class="icon-arrow-h-right grey toggle-icon"></span>
            </div>
        </button>
        <div class="collapse show" id="acc_imageInfo">
            <hr class="accordian-hr">
            <div class="collapseInner">
                <div class="welcome-screen mb-4 pl-2">
                    <span style="display:flex;">
                        <?= l('qr_step_2_mp3.input.companyLogo') ?>
                        <span class="info-tooltip-icon ctp-tooltip" tp-content="<?= l('qr_step_2_mp3.help_tooltip.companyLogo') ?>"></span>
                    </span>
                    <div class="screen-upload">
                        <label for="companyLogo">

                            <input type="hidden" id="companyLogoImage" name="companyLogoImage" value="<?php echo $companyLogo ? $companyLogo : ''; ?>">

                            <input type="file" id="companyLogo" name="companyLogo" class="form-control py-2" accept="image/png, image/gif, image/jpeg, image/svg+xml, image/webp" input_size_validate required />
                            <div class="input-image" id="company_logo_img">

                                <?php if ($companyLogo) { ?>
                                    <img src="<?php echo $companyLogo; ?>" height="" width="" alt="Company Logo image" id="cl-upl-img" />
                                <?php } ?>

                                <span class="icon-upload-image mb-0" style="display:<?php echo $companyLogo ? 'none' : 'flex'; ?>;" id="cl-tmp-mage"></span>
                                <!-- <svg class="MuiSvgIcon-root" id="cl-tmp-mage" focusable="false" viewBox="0 0 60 60" aria-hidden="true" style="display:<?php echo $companyLogo ? 'none' : 'block'; ?>;font-size: 60px;">
                                    <path d="M19.24,26.79a8.17,8.17,0,1,0-8.17-8.17A8.17,8.17,0,0,0,19.24,26.79Zm0-14.34a6.17,6.17,0,1,1-6.17,6.17A6.18,6.18,0,0,1,19.24,12.45Z"></path>
                                    <path d="M56.75,49.34,39.18,29.26a1,1,0,0,0-1.46-.05L25.09,41.84,19.1,35a1,1,0,0,0-.72-.34.93.93,0,0,0-.74.29L3.29,49.29a1,1,0,0,0,1.42,1.42L18.3,37.12,30.14,50.66a1,1,0,0,0,.76.34,1,1,0,0,0,.66-.25,1,1,0,0,0,.09-1.41l-5.24-6,12-12L55.25,50.66A1,1,0,0,0,56,51a1,1,0,0,0,.75-1.66Z"></path>
                                </svg> -->
                            </div>
                            <div class="add-icon" id="company_log_add_icon" style="display:<?php echo  $companyLogo ? 'none' : 'block'; ?>;opacity:0;">
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
                        <button type="button" class="delete-btn" id="cl_screen_delete" style="display:<?php echo  $companyLogo ? 'block' : 'none'; ?>;">
                            <?= l('qr_step_2_mp3.delete') ?>
                        </button>
                    </div>
                </div>
                <div class="form-group step-form-group">
                    <label for="image_title"><?= l('qr_step_2_mp3.title') ?> </label>
                    <input id="mp3_title" placeholder="<?= l('qr_step_2_mp3.input.mp3_title.placeholder') ?>" name="mp3_title" data-anchor="mp3_title" class="anchorLoc form-control" value="<?php echo (!empty($filledInput)) ? $filledInput['mp3_title'] : ''; ?>" data-reload-qr-code />
                </div>
                <div class="form-group step-form-group">
                    <label for="image_description"><?= l('qr_step_2_mp3.description') ?> </label>
                    <input id="mp3_description" placeholder="<?= l('qr_step_2_mp3.input.mp3_description.placeholder') ?>" name="mp3_description" class="form-control" value="<?php echo (!empty($filledInput)) ? $filledInput['mp3_description'] : ''; ?>" data-reload-qr-code />
                </div>
                <div class="form-group mb step-form-group">
                    <label for="website"> <?= l('qr_step_2_mp3.website') ?></label>
                    <input id="mp3_website" type="url" placeholder="<?= l('qr_step_2_mp3.input.mp3_website.placeholder') ?>" name="mp3_website" data-anchor="mp3_website" class="anchorLoc form-control" value="<?php echo (!empty($filledInput)) ? $filledInput['mp3_website'] : ''; ?>" data-reload-qr-code />
                </div>

                <div class="mb-3 addBusinessButton addRow" id="add-btn">

                </div>
                <?php if ((!empty($filledInput)) ? (($filledInput['button_text'] != '') ? '1' : '') : '') { ?>
                    <div class="mb-4 addRow">
                        <div class="form-group step-form-group button-wrp">
                            <label for="contactMobiles"> <?= l('qr_step_2_mp3.input.button') ?> <span class="text-danger text-bold">*</span></label>
                            <div class="d-flex align-items-center w-100">
                                <div class="d-flex align-items-center w-100 form-fields-wrp">
                                    <div class="w-75 btn-text mr-3">
                                        <input class="step-form-control mr-3" type="text" id="button_text" name="button_text" value="<?php echo (!empty($filledInput)) ? $filledInput['button_text'] : ''; ?>" placeholder="<?= l('qr_step_2_mp3.input.button_text.placeholder') ?>" required="" input_validate>
                                    </div>
                                    <div class="w-100 btn-url mr-3">
                                        <input class="step-form-control mr-3" type="url" id="button_url" name="button_url" value="<?php echo (!empty($filledInput)) ? $filledInput['button_url'] : ''; ?>" placeholder="<?= l('qr_step_2_mp3.input.button_url.placeholder') ?>" required="" input_validate>
                                    </div>
                                </div>
                                <button class="reapeterCloseIcon removeBtn mp3RemoveBtn" type="button" onclick="remove_me(this)">
                                    <span class="icon-trash remove-btn-icon"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div id="btn-item"></div>
                <?php } else { ?>

                    <div id="btn-item" class="px-2">
                        <button id="add" style="text-align: center;" type="button" class="all-add-btn outlineBtn addRowButton mp3AddRowBtn">
                            <span class="icon-add-square start-icon add-btn-icon"></span>
                            <span><?= l('qr_step_2_mp3.input.addButton') ?></span>
                        </button>
                    </div>
                <?php } ?>

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
    $("#addDownloadOption").on("change", function() {
        currentPos = "";
        // onchange="LoadPreview()"
        LoadPreview();
    });
    var base_url = '<?php echo UPLOADS_FULL_URL; ?>'
    var isMp3 = false;

    window.addEventListener('load', (event) => {


        if (isMp3) {
            $('.dropzone-previews .dz-image img').attr("src", "./themes/altum/assets/images/mp3.png");
            $("dropzone-previews .dz-remove").text("<?= l('qr_step_2_mp3.delete') ?>");
            $(".dz-remove").append('<span class="dz-remove-icon"></span>');
            $("#custom-dropzone-preview").removeAttr('style');
            $("#2").attr("disabled", true);
            $("#2").removeClass("disable-btn");
            $("#mp3").hide();
            $("#addDownloadOption").attr('disabled', false);
        }

        LoadPreview();

        <?php if ($qrUid) { ?>
            reload_qr_code_event_listener();
            $('#qr-code-wrap').addClass('active');
            $("#2").attr('disabled', false)
            $("#2").removeClass("disable-btn")
        <?php } ?>
    });

    $(".dz-remove").on("click", function() {
        $("#mp3File").val("");
        $("#custom-dropzone-preview").attr('style', 'display:none !important');
        $(".dz-preview").remove();
        $("#2").attr("disabled", false);
        $("#2").addClass("disable-btn");
        $("#mp3").show();
        $("#addDownloadOption").prop("checked", false);
        window.isMp3 = false;
        LoadPreview(false);
        $(".dz-remove").remove();
    });

    var currentPos;
    $(document).on("click", '.anchorLocBtn', function(e) {
        if (($('input[name=qrtype_input]').length > 0 && $('input[name=qrtype_input]').val() == "url") || ($('input[name=qrtype_input]').length > 0 && $('input[name=qrtype_input]').val() == "wifi")) {} else {
            currentPos = $(this).data('anchor');
        }
    });
    $(document).on("input", '.anchorLoc', function(e) {
        if (($('input[name=qrtype_input]').length > 0 && $('input[name=qrtype_input]').val() == "url") || ($('input[name=qrtype_input]').length > 0 && $('input[name=qrtype_input]').val() == "wifi")) {} else {
            currentPos = e.target.getAttribute('data-anchor');
            //   currentPos = $(this).data('anchor');    
        }
    });

    // document.getElementById('iframesrc').src = '<?=LANDING_PAGE_URL?>preview/mp3';

    function LoadPreview(welcome_screen = false, showLoader = true, changeAnc = null) {

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
        var companyLogoFile = document.getElementById('companyLogoImage').value;
        let mp3_title = document.getElementById('mp3_title').value.replace(/&/g, '%26');
        let mp3_description = document.getElementById('mp3_description').value.replace(/&/g, '%26');

        var mp3WebValue = document.getElementById('mp3_website').value.replace(/&/g, '%26');
        var mp3_website = set_url(mp3WebValue);

        let font_title = document.getElementById('filters_title_by').value;
        let font_text = document.getElementById('filters_text_by').value;
        var screen = document.getElementById("editscreen").value;
        let button_text = document.getElementById('button_text')?.value.replace(/&/g, '%26') || "";


        let buttonCreated = "0";
        if (document.getElementById('button_text')) {
            buttonCreated = "1";
        }

        var urlValue = document.getElementById('button_url')?.value.replace(/&/g, '%26') || "";
        var button_url = set_url(urlValue);

        let tmp_mp3 = document.getElementById('mp3').value;
        let addDownloadOption = document.getElementById('addDownloadOption').checked || "";

        var files = myDropzone.getAcceptedFiles();

        if (files.length < 1) {
            $("#2").removeAttr('onclick');
            $("#2").addClass('disable-btn');
            $("#2").attr('disabled', true);
        }

        var all_images = [];

        var mp3 = document.getElementById('mp3File').value;

        if (mp3 == "") {
            isMp3 = false;
            $("#2").addClass('disable-btn');
            $("#2").attr('disabled', true);
            $("#tabs-1").addClass('active');
            $("#tabs-2").removeClass('active');
            // $("#1").addClass('active');
            $("#2").addClass('no-files');
            $("#2").removeClass('active');
            $("#addDownloadOption").attr('disabled', true);
            $("#addDownloadOption").prop("checked", false);
            $(".download-option").css("border", "1px solid #a3abad");
            $(".download-option").css("cursor", "auto");
            $(".checkbox-label").css("color", "#a3abad");

        } else {
            isMp3 = true;
            $('#qr-code-wrap').addClass('active');
            // $("#2").removeClass('disable-btn');
            $("#2").removeClass('no-files');
            $("#2").attr('disabled', false);
            $("#addDownloadOption").attr('disabled', false);
            $(".download-option").removeAttr('style');
            $(".checkbox-label").css("color", "#767c83");
        }


        if (mp3_title == '' && mp3_description == '' && companyLogoFile == '' && mp3 == '' && mp3WebValue == '' && buttonCreated === "0") {
            mp3_title = '<?= str_replace("'", "\'", l('qr_step_2_mp3.lp_def_mp3_title')) ?>';
            mp3_description = '<?= str_replace("'", "\'", l('qr_step_2_mp3.lp_def_mp3_description')) ?>';
            companyLogoFile = '<?php echo LANDING_PAGE_URL; ?>images/images/new/mp3.webp';
            button_text = '<?= str_replace("'", "\'", l('qr_step_2_mp3.lp_def_button_text')) ?>';
            mp3_website = '#';
            mp3 = ['<?php echo SITE_URL; ?>uploads/mp3/644979abb1bd2_narcos%20ringtone.mp3'];
        }

        const PreviewData = {
            live: true,
            screen: !welcome_screen ? false : screen,
            addDownloadOption: addDownloadOption,
            button_url: button_url,
            button_text: button_text,
            primaryColor: primaryColor,
            SecondaryColor: SecondaryColor,
            mp3_title: mp3_title,
            mp3_description: mp3_description,
            font_title: font_title,
            font_text: font_text,
            mp3_website: mp3_website,
            mmp3: mp3,
            images: all_images,
            image: companyLogoFile,
            button_created: buttonCreated,
            change: changeAnc || currentPos,
            uId:uId,
            type:'mp3',
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

    $(document).on('click', '.delete-btn', function() {
        LoadPreview(false);
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
    $(document).on("change", "#mp3", function() {
        var files = document.getElementById("mp3").files;
        var fileName = files[0].name;
        $(".after-upload").show();
        $(".after-upload").find('span').html(fileName)
        $(".before-upload").hide();
    })


    // qr-code-preview by webethics

    $("#exitPreview").click(function() {
        $("#overlayPre").css({
            'opacity': '0',
            'display': 'none'
        });
        $("body").not(".app").removeClass("scroll-none");
        $(".col-right.customScrollbar").removeClass("active");
    });

    $(document).on("click", ".dz-clickable", function() {
        var uniqueId = generateRandomNumber();
        $("#uploadUniqueId").val(uniqueId);
    });
</script>

<script>
    var imageArray = [];
    var ImagesUploading = false;
    let uId = document.getElementById('uId').value;
    var isSuccess = false;
    var isNotError = true;
    var myDropzone = new Dropzone("div#mp3", {

        url: '<?= url('qr-code-generator') ?>',
        paramName: "mp3",
        previewsContainer: ".dropzone-previews",
        init: function() {
            this.on("complete", function(file) {
                if ($(window).width() < 567) {
                    $(".dz-remove").appendTo(".mp3-drpzone");
                }
                $(".dz-remove").text("<?= l('qr_step_2_mp3.delete') ?>");
                $(".dz-remove").append('<span class="dz-remove-icon"></span>');
                $(".dz-image img").attr("src", "./themes/altum/assets/images/mp3-up.png")
            });

            this.on('addedfile', function(file) {
                while (this.files.length > this.options.maxFiles) this.removeFile(this.files[0]);
                mp3UniqueId = $("#uploadUniqueId").val();

                $(".dz-remove").text("<?= l('qr_step_2_mp3.delete') ?>");
                $(".dz-remove").append('<span class="dz-remove-icon"></span>');
                $("#custom-dropzone-preview").removeAttr('style');
                $("#2").attr("disabled", false);
                $("#2").removeClass("disable-btn");
                console.log("add file");
            });
        },
        renameFile: function(file) {
            let newName = new Date().getTime() + '_' + file.name.replaceAll(" ", "-");
            return newName;
        },
        sending: function(file, xhr, formData) {
            $('#loader.qr').fadeIn(); +
            $('#qr-code-wrap').fadeOut();

            if ($('#custom-dropzone-preview').children(".dz-preview").length > 1) {
                $('#custom-dropzone-preview').children(".dz-preview").last().remove();
            }
            myDropzone.removeAllFiles();

            let form = document.querySelector('form#myform');
            let form_data = new FormData(form);
            for (var pair of form_data.entries()) {
                formData.append(pair[0], pair[1]);
            }
            var imageId = Date.now();
            imageArray[file.upload.filename] = imageId;
            formData.append("imageID", imageId);
            formData.delete("screen");
        },
        acceptedFiles: ".mp3",
        maxFilesize: 25, //2 MB
        maxFiles: 1,
        processing: function() {
            $(".preview-qr-btn").attr("disabled", true);
            ImagesUploading = true;
            $("#temp_next").attr("disabled", true);
            if (isNotError) {
                $(".invalid_err").first().text("");
            }
            this.options.autoProcessQueue = true;

        },
        removedfile: function(file) {
            var fileNames = file.upload.filename;
            var fileExtension = file.upload.filename.substr(fileNames.lastIndexOf('.') + 1);

            fileLinks = "mp3/" + uId + "_" + mp3UniqueId + "." + fileExtension;

            formData = new FormData();
            formData.append('action', 'deleteFiles');
            formData.append('fileLinks', fileLinks);
            $("#mp3File").val("");

            $.ajax({
                type: 'POST',
                method: 'post',
                url: '<?php echo url('api/ajax') ?>',
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
            })
            delete imageArray.fileNames;
            file.previewElement.remove();
            removedfile = true;
            if (myDropzone.getAcceptedFiles().length <= 0) {
                $("#custom-dropzone-preview").attr('style', 'display:none !important');
                $('#qr-code-wrap').html("");
                $("#is_mp3").val(0);
            }
            $(".custom_error").remove();
            $(".invalid_err").remove();
            LoadPreview(true, false);
            $("#mp3").show();
        },
        queuecomplete: function(files) {
            $(".preview-qr-btn").attr("disabled", false);
            ImagesUploading = false
            $("#temp_next").attr("disabled", false);
            if (isSuccess || isNotError) {
                LoadPreview(undefined, false);
            }

            isSuccess = false;
            isNotError = true;

        },
        addRemoveLinks: true,
        success: function(file, responseText) {

            isSuccess = true;
            var responseText = JSON.parse(responseText); +
            $('#qr-code-wrap').html(responseText.details.image);

            document.querySelector('#download_svg').href = responseText.details.data;
            if (document.querySelector('input[name="qr_code"]')) {
                document.querySelector('input[name="qr_code"]').value = responseText.details.data;
            }

            var fileNames = file.upload.filename;
            var fileExtension = file.upload.filename.substr(fileNames.lastIndexOf('.') + 1);

            fileLinks = "mp3/" + uId + "_" + mp3UniqueId + "." + fileExtension;

            if (fileLinks) {
                $('input[name="mp3File"]').val(base_url + fileLinks);
                $("#is_mp3").val(1);
                LoadPreview(false);

            }

            $("#mp3 .dz-message").append("<div class=\"custom_error\" style='margin-top:0px;'>NOTE: You can only upload a maximum of one audio file. If you wish to replace the existing audio, please click on the delete button first to remove the current file.</div>");
            $("#mp3").hide();
            $('#loader.qr').fadeOut(); +
            $('#qr-code-wrap').fadeIn();

            $(file.previewElement).append('<span class="hover-effect-icon"></span>');
            $(file.previewElement).append('<div class="upload-edit-wrap mp3-file-upload"></div>');
            $(file.previewElement).children(".upload-edit-wrap").append('<span class="image-edit-icon"></span>');
        },
        error: function(file, response) {
            isNotError = false;
            $(".preview-qr-btn").attr("disabled", false);
            file.previewElement.remove();
            var fileNames = file.upload.filename
            delete imageArray.fileNames;


            if (myDropzone.getAcceptedFiles().length <= 0) {
                $("#custom-dropzone-preview").attr('style', 'display:none !important');
            }


            // myDropzone.removeFile(file);
            var errorAreas = document.getElementsByClassName("invalid_err");
            if (errorAreas[0]) {
                if (response == "You can not upload any more files.") {
                    $(errorAreas[0]).text("<?= l('qr_step_2_mp3.max_mp3_2') ?>");
                } else {
                    $(errorAreas[0]).text("<?= l('qr_step_2_mp3.max_allowed') ?>");
                }
            } else {
                if (response == "You can not upload any more files.") {
                    $("#mp3").after("<span class=\"invalid_err\" style='margin-top:15px;'><?= l('qr_step_2_mp3.max_mp3') ?></span>");
                } else {
                    $("#mp3").after("<span class=\"invalid_err\" style='margin-top:15px;'><?= l('qr_step_2_mp3.max_allowed') ?></span>");
                }
            }
        },
    });

    $(document).on('click', '.mp3-file-upload, .mp3-file-edit-upload, .hover-effect-icon', function() {
        $("#mp3").trigger("click");
    });

    $(".dz-button").text("<?= l('qr_step_2_mp3.upload') ?>");
    $(".dz-button").after("<p style='color: #220E27;margin-top: 16px;font-size: 13px;line-height: 18px;  '><strong><?= l('qr_step_2_mp3.mx_file') ?></strong></p>");
</script>