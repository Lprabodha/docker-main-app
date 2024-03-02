<?php defined('ALTUMCODE') || die() ?>

<?php
$decodedData = json_decode(isset($data->qr_code[0]['data']) ? $data->qr_code[0]['data'] : null, true);
$qrType = isset($decodedData['type']) ? $decodedData['type'] : null;

if (isset($data->qr_code[0]['data']) && $qrType == 'video') {
    $filledInput = json_decode($data->qr_code[0]['data'], true);
    $qrName =  $data->qr_code[0]['name'];
    $qrUid =  $data->qr_code[0]['uId'];
} else {
    $filledInput = array();
    $qrName = null;
    $qrUid  =  null;
}
?>

<div id="step2_form">

    <!-- <input type="hidden" id="uId" name="uId" class="form-control" value="<?php echo (!empty($filledInput)) ? $qrUid : uniqid();  ?>" data-reload-qr-code /> -->
    <input type="hidden" id="preview_link" name="preview_link" value="<?php echo (!empty($filledInput)) ? $filledInput['preview_link'] : '';  ?>" class="form-control" data-reload-qr-code />
    <input type="hidden" id="preview_link2" name="preview_link2" value="<?php echo (!empty($filledInput)) ? $filledInput['preview_link2'] : '';  ?>" class="form-control" data-reload-qr-code />
    <input type="hidden" name="uploadUniqueId" id="uploadUniqueId" value="">

    <div class="custom-accodian">
        <button class="btn accodianBtn" type="button" data-toggle="collapse" data-target="#acc_videoUpload" aria-expanded="true" aria-controls="acc_videoUpload">
            <div class="qr-step-icon">
                <span class="icon-play-circle grey steps-icon"></span>
            </div>

            <span class="custom-accodian-heading">
                <span class="accodianRequired"><?= l('qr_step_2_video.type') ?><sup>*</sup></span>
                <span class="fields-helper-heading"><?= l('qr_step_2_video.help_txt.type') ?></span>
            </span>

            <div class="toggle-icon-wrap ml-2">
                <span class="icon-arrow-h-right grey toggle-icon"></span>
            </div>
        </button>
        <div class="collapse show" id="acc_videoUpload">
            <hr class="accordian-hr">
            <div class="collapseInner video-collaps">
                <div class="row m-auto w-100 align-items-end r-form video-input-wrap">
                    <div id="url" class="form-group w-100 col-md" data-type="video" data-url>
                        <label for="youTubeUrl" class="section-heading"> <?= l('qr_step_2_video.input.video_url') ?></label>
                        <input type="url" id="youTubeUrl" name="youTubeUrl" placeholder="https://www.youtube.com/watch..." value="<?php echo (!empty($filledInput)) ? (isset($filledInput['youTubeUrl']) ? $filledInput['youTubeUrl'] : '') : '';  ?>" class="step-form-control w-100" data-reload-qr-code />
                    </div>
                    <p id="validYoutube" class="valid-youtube" style="color:red; display:none;"><?= l('qr_step_2_video.invalid_url') ?></p>
                    <div class="form-group col-md-auto video-add-wrap">
                        <button class="accountSaveButton d-flex detail-save-btn videos-upload" onclick="addVideo()" id="youtubeSubmit" type="button" disabled style="padding-left:8px;padding-right:8px;">
                            <span class="icon-add-barcode start-icon save-btn-icon"></span>
                            <span class="save-btn-text"><?= l('qr_step_2_video.type.add_video') ?></span>
                        </button>
                    </div>
                </div>

                <div class="form-group mt-4 mb-0">
                    <label class="video-label"><?= l('qr_step_2_video.upload_video') ?> <span style="color :red;"></span></label>
                </div>

                <div class="dropzone dropzone fileupload col-12 dz-clickable videos-upload" id="files">
                </div>
                <span class="col-lg-12 col-xl-12 error" id="logo-error" style="color:red;"></span>
                <div id="img_previews">
                </div>

                <?php if (isset($filledInput['allValues'])) { ?>
                    <div class="row video-error-area">
                        <input type="hidden" name="is_video" value="<?php echo count($filledInput['allValues']) ?>" id="is_video">
                    </div>
                <?php } else { ?>
                    <div class="row video-error-area">
                        <input type="hidden" name="is_video" value="0" id="is_video">
                    </div>
                <?php } ?>

                <!-- After Upload Priview -->
                <div class="mb-2 video_preview" id="video_preview">

                    <?php if (isset($filledInput['allValues'])) { ?>
                        <?php foreach ($filledInput['allValues'] as $key => $video) { ?>
                            <div class="afterImage-upload align-items-start xl_video" style="position:relative;">

                                <div class="row w-100 m-auto upload-video-wrap">
                                    <div class="col-sm-3 video-prw-wrap">
                                        <div class="videoPreview">
                                            <?php if ($filledInput['video_types'][$key] === 'youtube') { ?>
                                                <iframe src="<?php echo $video ?>" alt=""></iframe>

                                            <?php } else { ?>
                                                <video class="video-fluid z-depth-1" loop controls muted>
                                                    <source src="<?php echo $video ?>" />
                                                </video>

                                            <?php } ?>
                                        </div>
                                        <input type="hidden" value="<?php echo $video ?>" name="allValues[]">
                                        <input type="hidden" value="<?php echo $filledInput['video_types'][$key] ?>" name="video_types[]">
                                        <input type="hidden" value="<?php echo $filledInput['video_title'][$key] ?>" name="video_title[]">
                                    </div>
                                    <div class="col-sm-7 video-detail-wrap">
                                        <div class="previewDetail flex-1">
                                            <label class="f-500 mt-1">
                                                <p class="video-title-name"><?php echo $filledInput['video_title'][$key]; ?></p>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-1 pl-0 delete-video-wrap">
                                        <!-- onclick="deleteYoutubeVideo(this)" -->
                                        <button type="button" class="video-delete-btn" data-dz-remove>
                                            <span class="icon-trash grey delete-mark d-flex"></span>
                                        </button>
                                    </div>
                                    <div class="col-1 pl-0 up-down-wrap">
                                        <div class="d-flex flex-column">
                                            <button type="button" class="video-order-up jss1426 jss1424 anchorLoc">
                                                <span class="icon-arrow-h-right video-icon-up grey"></span>
                                            </button>

                                            <button type="button" class="video-order-down jss1426 jss1424 anchorLoc">
                                                <span class="icon-arrow-h-right video-icon-down grey"></span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-12 text-area-wrap mt-3 w-100 mx-auto">
                                        <textarea class="step-form-control anchorLoc" data-anchor="" rows="1" style=" border-radius:24px; height:98px; padding:8px 15px; resize: none;" placeholder="<?= l('qr_step_2_video.desc') ?>" name="videos_desc[]" pl rows="3"><?php echo $filledInput['videos_desc'][$key] ?></textarea>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>


                </div>
                <div class="checkbox-wrapper video-checkbox-wrapper mb-4 video-directly">
                    <div class="roundCheckbox custom-wrp-with-label">
                        <input class="checkbox-wrp-dis" type="checkbox" id="direct_video" onchange="LoadPreview()" name="direct_video" <?php echo (!empty($filledInput)) ? ((isset($filledInput['direct_video'])) ? 'checked' : '') : '';  ?> />
                        <label class="m-0" for="direct_video"></label>
                    </div>
                    <label class="video-label mb-0 pl-3"><?= l('qr_step_2_video.show_directly') ?></label>
                </div>
                <div class="checkbox-wrapper helight-wrap mb-4 d-none">
                    <div class="roundCheckbox custom-wrp-with-label ">
                        <input type="checkbox" name="Highlight" onchange="LoadPreview()" id="Highlight" <?php echo (!empty($filledInput)) ? ((isset($filledInput['Highlight'])) ? 'checked' : '') : '';  ?> />
                        <label class="m-0" for="Highlight"></label>
                    </div>
                    <label class="video-label mb-0 pl-3"><?= l('qr_step_2_video.highlight_video') ?></label>
                </div>
                <div class="checkbox-wrapper video-checkbox-wrapper autoplay-wrapper">
                    <div class="roundCheckbox custom-wrp-with-label">
                        <input class="checkbox-wrp-dis" type="checkbox" name="Autoplay" onchange="LoadPreview()" id="Autoplay" <?php echo (!empty($filledInput)) ? ((isset($filledInput['Autoplay'])) ? 'checked' : '') : '';  ?> />
                        <label class="m-0" for="Autoplay"></label>
                    </div>
                    <label class="video-label mb-0 pl-3"><?= l('qr_step_2_video.autoplay_video') ?></label>
                </div>
            </div>
        </div>
    </div>

    <!-- add color palette -->
    <?php include_once('components/design-1-color.php'); ?>


    <div class="custom-accodian  video-info-main-wrp info-block-main-wrp consider">
        <button class="btn accodianBtn" type="button" data-toggle="collapse" data-target="#acc_contactInfo" aria-expanded="true" aria-controls="acc_contactInfo">
            <div class="qr-step-icon">
                <span class="icon-info grey steps-icon"></span>
            </div>

            <span class="custom-accodian-heading">
                <span><?= l('qr_step_2_video.input.videoInformation') ?></span>
                <span class="fields-helper-heading"><?= l('qr_step_2_video.help_txt.videoInformation') ?></span>
            </span>

            <div class="toggle-icon-wrap ml-2">
                <span class="icon-arrow-h-right grey toggle-icon"></span>
            </div>
        </button>
        <div class="collapse show" id="acc_contactInfo">
            <hr class="accordian-hr">
            <div class="collapseInner">
                <div class="form-group step-form-group mt-3">
                    <label for="companyName"> <?= l('qr_step_2_video.input.company') ?></label>
                    <input id="companyName" name="companyName" placeholder="<?= l('qr_step_2_video.input.companyName.placeholder') ?>" class="anchorLocTop form-control" value="<?php echo (!empty($filledInput)) ? $filledInput['companyName'] : ''; ?>" data-reload-qr-code />
                </div>
                <div class="form-group step-form-group mt-3">
                    <label for="videoTitle"> <?= l('qr_step_2_video.input.videoTitle') ?></label>
                    <input id="videoTitle" name="videoTitle" placeholder="<?= l('qr_step_2_video.input.videoTitle.placeholder') ?>" class="anchorLocTop form-control" value="<?php echo (!empty($filledInput)) ? $filledInput['videoTitle'] : ''; ?>" data-reload-qr-code />
                </div>
                <div class="form-group step-form-group mt-3">
                    <label for="videoDescription"> <?= l('qr_step_2_video.input.description') ?></label>
                    <input id="videoDescription" name="videoDescription" placeholder="<?= l('qr_step_2_video.input.videoDescription.placeholder') ?>" class="anchorLocTop form-control" value="<?php echo (!empty($filledInput)) ? $filledInput['videoDescription'] : ''; ?>" data-reload-qr-code />
                </div>


                <?php if (isset($filledInput['button_text']) && $filledInput['button_url']) { ?>
                    <div class=" mb-4  step-form-group addRow button-wrp">
                        <label for="contactMobiles"> <?= l('qr_step_2_video.input.button') ?> <span class="text-danger text-bold">*</span> </label>
                        <div class="d-flex align-items-center w-100">
                            <div class="d-flex align-items-center w-100 form-fields-wrp">
                                <div class="w-75 btn-text mr-3">
                                    <input class="form-control mr-3 anchorLocTop" type="text" id="button_text" value="<?php echo $filledInput['button_text'] ?>" name="button_text" placeholder="<?= l('qr_step_2_video.input.button_text.placeholder') ?>" required input_validate />
                                </div>
                                <div class="w-100 btn-url mr-3">
                                    <input class="form-control mr-3 anchorLocTop" type="url" id="button_url" value="<?php echo $filledInput['button_url'] ?>" name="button_url" placeholder="<?= l('qr_step_2_video.input.button_url.placeholder') ?>" required input_validate />
                                </div>
                            </div>
                            <button type="button" class="reapeterCloseIcon removeBtn" onclick="showButton(this)">
                                <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                <?php } else { ?>
                    <div id="addBtn" class="px-2 mt-3">
                        <button id="add2" style="text-align: center;" type="button" class="all-add-btn outlineBtn addRowButton" onclick="showFields(this)"><span class="icon-add-square start-icon add-btn-icon"></span> <span><?= l('qr_step_2_video.input.addButton') ?></span></button>
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


    <!-- <?php include_once('accodian-form-group/tracking-analytics.php'); ?> -->
</div>

<script>
    var dataAnchor = 0;

    $('#video_preview').on('DOMSubtreeModified', function(e) {
        $("#youTubeUrl").trigger("click");
        var videoCount = $("#video_preview").children().length;
        if (videoCount > 1) {
            $(".video-directly").css({
                'display': 'none'
            });
        } else {
            $(".video-directly").css({
                'display': 'flex'
            });
        }
        // dataAnchor++;
        $('#video_preview .afterImage-upload').map((i, e) => {
            e.setAttribute('data-anchor', `video${i+1}`);
            $("textarea[name='videos_desc[]']")[i].setAttribute('data-anchor', `video${i+1}`);
            // $(".video-order-up.anchorLoc")[i].setAttribute('data-anchor',`video${i}`);
            // $(".video-order-down.anchorLoc")[i].setAttribute('data-anchor',`video${i+2}`);
            dataAnchor = `video${i+1}`;
        });
    });

    $("#video_preview").on("input", '.anchorLoc', function(e) {
        if (($('input[name=qrtype_input]').length > 0 && $('input[name=qrtype_input]').val() == "url") || ($('input[name=qrtype_input]').length > 0 && $('input[name=qrtype_input]').val() == "wifi")) {} else {
            // currentPos = e.target.getAttribute('data-anchor');     
            dataAnchor = $(this).parents('.afterImage-upload').data('anchor');
        }
    });
    $(document).on("input", '.anchorLocTop', function(e) {
        if (($('input[name=qrtype_input]').length > 0 && $('input[name=qrtype_input]').val() == "url") || ($('input[name=qrtype_input]').length > 0 && $('input[name=qrtype_input]').val() == "wifi")) {} else {
            // currentPos = e.target.getAttribute('data-anchor');     
            dataAnchor = 'anchorLocTop';
            console.log(dataAnchor);
        }
    });
    $("#Autoplay").on("change", function() {
        dataAnchor = "video1";
        LoadPreview();
    });
    // onchange="LoadPreview()"



    var base_url = '<?php echo UPLOADS_FULL_URL; ?>'
    var vidHtml = `<div class="afterImage-upload align-items-start local-video "  >
                                <div class="row w-100 m-auto upload-video-wrap">
                                    <div class="col-sm-3 video-prw-wrap" style="position: relative;">
                                        <div class="videoPreview dz-videoss" style="position:relative;">
                                        
                                            <video playsinline src="" preload="auto" controls="" style="width: 100%; height: 100%;"></video>

                                            <div class="dz-progress video-progress"><span class="dz-upload video-upload-progress" data-dz-uploadprogress></span></div>
                                        </div>
                                        <div class="real-progress" id="reals-progress"></div>
                                        <input  type="hidden" id="videosUrls" value="" name="allValues[]" >
                                        <input type="hidden" value="local_video" name="video_types[]">
                                        <input type="hidden" value="" name="video_title[]">
                                        
                                    </div>
                                    <div class="col-sm-7 video-detail-wrap">
                                        <div class="previewDetail flex-1">
                                            <label class="f-500 mt-1">
                                                <p class="video-title-name" data-dz-name ></p>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-1 delete-video-wrap pl-0">
                                            <button type="button" class="video-delete-btn" data-dz-remove>
                                                <span class="icon-trash grey delete-mark d-flex"></span>
                                            </button>
                                    </div>
                                    <div class="col-1 pl-0 up-down-wrap">
                                        <div class="d-flex flex-column">
                                            <button type="button" class="video-order-up jss1426 jss1424 anchorLoc">
                                            <span class="icon-arrow-h-right video-icon-up grey"></span>
                                            </button>

                                            <button type="button" class="video-order-down jss1426 jss1424 anchorLoc">
                                                <span class="icon-arrow-h-right video-icon-down grey"></span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-12 text-area-wrap mt-3 w-100 mx-auto">
                                        <textarea class="step-form-control anchorLoc"  rows="1" style="border-radius:5px; height:98px; padding:8px 15px; resize: none" placeholder="<?= l('qr_step_2_video.desc') ?>" name="videos_desc[]" pl rows="3" ></textarea>
                                    </div>
                                </div>
                            <div class="progressbar">   </div> 
                        </div>`;
    var imageArray = [];
    var ImagesUploading = false;
    let uId = document.getElementById('uId').value;
    var isSuccess = false;
    var isNotError = true;
    var myDropzone = new Dropzone("div#files", {

        // autoProcessQueue: false,
        url: '<?= CONTENT_API . 'api/video-chunk-upload' ?>',
        paramName: "video_file",
        previewsContainer: "#video_preview",

        chunking: true, // enable chunking
        forceChunking: true, // forces chunking when file.size < chunkSize
        parallelChunkUploads: true, // allows chunks to be uploaded in parallel (this is independent of the parallelUploads option)
        chunkSize: 20000000, // chunk size 20,000,000 bytes (~20MB)
        retryChunks: true, // retry chunks on failure
        retryChunksLimit: 3, // retry maximum of 3 times (default is 3)

        init: function() {
            this.on("complete", function(file) {


                var progressBar = file.previewElement.querySelector(".dz-progress");
                progressBar.style.opacity = "0";
                var percent = file.previewElement.querySelector(".real-progress");
                percent.style.opacity = "0";
                $(".dz-remove").text("Delete");
                $(".real-progress").css("display", "none");
                $("local-video .up-down-wrap").addClass("local-up-down-wrap");
            });
            this.on("addedfile", function(file) {
                if (file.type.match(/video.*/)) {
                    file.previewElement.querySelector('[name="video_title[]"]').value = file.name;
                }
                $(".dz-remove").text("Delete");
                $("#2").attr("disabled", false);
                $("#2").removeClass("disable-btn");
                $("#direct_video").attr("disabled", false);
                $("#Highlight").attr("disabled", false);
                $("#Autoplay").attr("disabled", false);
            });
        },
        renameFile: function(file) {
            let newName = new Date().getTime() + '_' + file.name.replaceAll(" ", "-");
            return newName;
        },
        sending: function(file, xhr, formData) {
            $('#loader.qr').fadeIn(); +
            $('#qr-code-wrap').fadeOut();

            var videoUnqId = Date.now();
            imageArray[file.upload.filename] = videoUnqId;
            formData.append("videoUnqId", videoUnqId);
            formData.append("uuid", uId);
        },
        uploadprogress: function(file, progress, bytesSent) {
            // Get the progress bar element for this file
            var progressBar = file.previewElement.querySelector(".dz-upload");

            // Update the progress bar width and text
            progressBar.style.width = progress + "%";

            // Update the progress percentage in the progress element
            var progressElement = file.previewElement.querySelector(".real-progress");
            progressElement.innerHTML = Math.floor(progress) + "%";
        },
        acceptedFiles: "video/x-ms-asf,video/x-ms-wmv,video/x-ms-wmx,video/x-ms-wm,video/divx,video/x-flv,video/quicktime,video/mpeg,video/mp4,video/ogg,video/webm,video/x-matroska,video/3gpp,video/3gpp2",
        maxFilesize: 250, //2 MB
        maxFiles: 5,
        previewTemplate: vidHtml,
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
            $.ajax({
                method: 'post',
                url: '<?= CONTENT_API . 'api/video-delete' ?>',
                data: {
                    videoName: file?.resource_name
                },
                success: function(res) {
                    if (res?.status) {
                        file.previewElement.remove();
                        removedfile = true;
                        if (myDropzone.getAcceptedFiles().length <= 0) {
                            $('#qr-code-wrap').html("");
                        }
                        LoadPreview(undefined, false);
                    }
                }
            });
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
        success: function(file, response) {

            // var fileNames = file.upload.filename;
            // var fileExtension = fileNames.substr(fileNames.lastIndexOf('.') + 1);
            // file.previewElement.querySelector('#videosUrls').value = base_url + "video/" + uId + "_" + imageArray[fileNames] + "." + fileExtension + "";
            // file.previewElement.querySelector('.dz-videoss video').src = base_url + "video/" + uId + "_" + imageArray[fileNames] + "." + fileExtension + "#t=0.001";

            if (response?.status) {
                file.resource_name = response?.name
                file.previewElement.querySelector('#videosUrls').value = `${response.resource_url}`;
                file.previewElement.querySelector('.dz-videoss video').src = `${response.resource_url}#t=0.001`;

                $.ajax({
                    url: '<?= url('qr-code-generator') ?>',
                    method: 'post',
                    data: $('form#myform').serialize(),
                    success: function(res) {
                        isSuccess = true;
                        const qrResponse = JSON.parse(res);
                        $('#qr-code-wrap').html(qrResponse.details.image);

                        document.querySelector('#download_svg').href = qrResponse.details.data;
                        if (document.querySelector('input[name="qr_code"]')) {
                            document.querySelector('input[name="qr_code"]').value = qrResponse.details.data;
                        }
                    }
                })
            }

            $("#validate_value_ajax").val(0)
            $("#2").attr('disabled', false);
            $("#2").removeClass("disable-btn");
            $("#2").attr('onclick', 'save_qr_fn()');
            $("#2m").attr('disabled', false);
            $("#2m").removeClass("disable-btn");
            $("#2m").attr('onclick', 'save_qr_fn()');
            $("#direct_video").attr("disabled", false);
            $("#Highlight").attr("disabled", false);
            $("#Autoplay").attr("disabled", false);


            $('#loader.qr').fadeOut(); +
            $('#qr-code-wrap').fadeIn();


        },
        error: function(file, response) {
            isNotError = false;
            $(".preview-qr-btn").attr("disabled", false);
            file.previewElement.remove();

            var errorAreas = document.getElementsByClassName("invalid_err");
            if (errorAreas[0]) {
                if (response == "You can not upload any more files.") {
                    $(errorAreas[0]).text("<?= l('qr_step_2_video.max_video') ?>");
                } else if (response == "You can't upload files of this type.") {
                    $("#files").after("<span class=\"invalid_err\" style='margin-top:15px;'><?= l('qr_step_2_video.notAllow_video') ?></span>");
                } else {
                    $(errorAreas[0]).text("<?= l('qr_step_2_video.max_size_allowed') ?>");
                }
            } else {
                if (response == "You can not upload any more files.") {
                    $("#files").after("<span class=\"invalid_err\" style='margin-top:15px;'><?= l('qr_step_2_video.max_video') ?></span>");
                } else if (response == "You can't upload files of this type.") {
                    $("#files").after("<span class=\"invalid_err\" style='margin-top:15px;'><?= l('qr_step_2_video.notAllow_video') ?></span>");
                } else {

                    var errorText = $('.video-error-area span.invalid_err');
                    if (errorText) {
                        errorText.remove();
                    }
                    $("#files").after("<span class=\"invalid_err\" style='margin-top:15px;'><?= l('qr_step_2_video.max_size_allowed') ?></span>");
                }
            }
        },
    });
    $(".dz-button").before("<span class=\"icon-upload-video upload-icon\"></span>");
    $(".dz-button").text("<?= l('qr_step_2_video.upload_videos') ?>");
    $(".dz-button").after("<p style='color: #220E27;margin-top: 16px;font-size: 13px;line-height: 18px;  '><strong><?= l('qr_step_2_video.mx_file') ?></strong></p>");
</script>

<script>
    $(document).on('change keyup paste keydown', '#youTubeUrl', function(e) {
        setTimeout(function() {
            validateYouTubeUrl(e.target.value);
        }, 0);

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

    // $(document).on('DOMNodeInserted', '#video_preview', function(event) {
    //     console.log('A <div> element has been appended:', event.target);
    // });

    // document.getElementById('iframesrc').src = '<?= LANDING_PAGE_URL ?>preview/video';

    const input = document.getElementById('video_file')
    const inputAll = document.getElementById('file_storage');
    const dt = new DataTransfer()
    const reader = new FileReader();


    function removeFileFromFileList(index) {
        const dt1 = new DataTransfer()
        const input = document.getElementById('file_storage')
        const {
            files
        } = input

        for (let i = 0; i < files.length; i++) {
            const file = files[i]
            if (index !== files[i].uniqId) {
                dt1.items.add(file) // here you exclude the file. thus removing it.
            } else {
                var re = i;
            }
        }
        dt.items.remove(re);

        inputAll.files = dt1.files // Assign the updates list
    }

    // function deleteYoutubeVideo(elm) {
    //     remove_me(elm);
    //     document.getElementById('youTubeUrl').value = "";
    //     LoadPreview();
    //     // .closest('.parent')
    //     console.log(elm.closest('.afterImage-upload'));
    // }


    $(".video_preview").on("click", ".video-delete-btn", function() {
        $(this).parents('.afterImage-upload').remove();
        // console.log( $(this).parents('.afterImage-upload') );
        LoadPreview();
    });

    function hideA(x) {
        if (x.checked) {
            document.getElementById("url").style.display = "none";
            document.getElementById("video_url").removeAttribute("required");
            document.getElementById("file").style.display = "block";
            document.getElementById("video_file").setAttribute("required", "");
        }
    }

    function hideB(x) {
        if (x.checked) {
            document.getElementById("url").style.display = "block";
            document.getElementById("video_url").setAttribute("required", "");
            document.getElementById("file").style.display = "none";
            document.getElementById("video_file").removeAttribute("required");
        }
    }

    function showButton(thisObj) {
        var parent = thisObj.closest('div.collapseInner');
        thisObj.closest('.addRow').remove();
        var html = `<div id="addBtn">
                    <button id="add2" style="text-align: center;" type="button" class="outlineBtn addRowButton all-add-btn" onclick="showFields(this)"><span class="icon-add-square start-icon add-btn-icon"></span> <span><?= l('qr_step_2_video.input.addButton') ?></span></button>
                </div>`;
        $('#acc_contactInfo').find('div.collapseInner').append(html);
        LoadPreview();
    }

    function showFields(thisObj) {
        var parent = thisObj.closest('#acc_contactInfo');
        thisObj.closest("#addBtn").remove();
        var html = `<div class="mt-3 step-form-group addRow button-wrp" >
                            <label for="contactMobiles"> <?= l('qr_step_2_video.input.button') ?> <span class="text-danger text-bold">*</span> </label>
                            <div class="d-flex align-items-center w-100">
                                <div class="d-flex align-items-center w-100 form-fields-wrp">
                                    <div class="w-75 btn-text mr-3">
                                        <input class="form-control mr-3" type="text" id="button_text" name="button_text" placeholder="<?= l('qr_step_2_video.input.button_text.placeholder') ?>" required input_validate/>
                                    </div>
                                    <div class="w-100 btn-url mr-3">
                                        <input class="form-control mr-3" type="url" id="button_url" name="button_url" placeholder="<?= l('qr_step_2_video.input.button_url.placeholder') ?>" required input_validate/>
                                    </div>
                                </div>
                                <button type="button" class="reapeterCloseIcon removeBtn" onclick="showButton(this)">
                                    <span class="icon-trash remove-btn-icon"></span>
                                </button>
                            </div>
                    </div>`;

        var html2 = `<div class="borderSection" id="addBtnfields">
                    <div class="form-group m-0">
                        <label for="contactMobiles"> <?= l('qr_step_2_video.input.button') ?></label>
                        <div class="d-flex align-items-center w-100">
                            <div class="d-flex align-items-center w-100">
                                <input class="form-control mr-3" type="text" id="video_button_text" name="video_button_text" placeholder="<?= l('qr_step_2_video.input.button_text.placeholder') ?>"  required="" />
                                <input class="form-control mr-3" type="url" id="video_button_urls" name="video_button_urls" placeholder="<?= l('qr_step_2_video.input.button_url.placeholder') ?>" required="" />
                            </div>
                            <button type="button" class="reapeterCloseIcon removeBtn" onclick="showButton(this)">
                                <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"></path></svg>
                            </button>
                        </div>
                    </div>
                </div>`;

        $('#acc_contactInfo').find('div.collapseInner').append(html);
        LoadPreview();
    }

    function validateYouTubeUrl(value) {
        var url = value;
        if (url.trim() != undefined && url.trim() != '') {

            var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=|\?v=)([^#\&\?]*).*/;

            var match = url.match(regExp);

            if (match && match[2].length == 11) {
                // Do anything for being valid
                // if need to change the url to embed url then use below line
                $('#ytplayerSide').attr('src', 'https://www.youtube.com/embed/' + match[2] + '?autoplay=0');
                $('#youtubeSubmit').attr('disabled', false);
                $('#validYoutube').hide();
            } else {
                let regex = /(youtu.*be.*)\/(watch\?v=|embed\/|v|shorts|)(.*?((?=[&#?])|$))/gm;
                try {
                    var u_final = regex.exec(url)[3];
                } catch (error) {}
                if (u_final && u_final.length == 11) {
                    $('#ytplayerSide').attr('src', 'https://www.youtube.com/embed/' + u_final + '?autoplay=0');
                    $('#youtubeSubmit').attr('disabled', false);
                    $('#validYoutube').hide();

                } else {
                    $('#youtubeSubmit').attr('disabled', true);
                    $('#youTubeUrl').css({
                        'border': '1px solid red'
                    });
                    $('#validYoutube').show();

                }
            }
        } else {
            $('#youtubeSubmit').attr('disabled', true);
            $('#validYoutube').hide();
            $('#youTubeUrl').css({
                'border': '1px solid #8c8c8c95'
            });
        }
    }

    function loader() {
        document.getElementById("video_loader").style.display = "block";
    }
</script>
<script>
    <?php if (isset($filledInput['direct_video'])) { ?>
        <?php if ($filledInput['direct_video'] == 'on') { ?>
            $('.consider').hide();
        <?php } else { ?>
            $('.consider').show();
        <?php } ?>
    <?php } ?>

    $(document).on('change', '#direct_video', function() {
        if ($(this).is(":checked")) {
            $('.consider').hide();
        } else {
            $('.consider').show();
        }
    });

    function YouTubeGetID(url) {
        var id = '';
        url = url.split(/(vi\/|v=|\/v\/|youtu\.be\/|\/embed\/|shorts\/)/);
        return (url[2] !== undefined) ? url[2].split(/[^0-9a-z_\-]/i)[0] : url[0];
    }

    async function foo(vidurl) {
        var darth = [];
        const res = await fetch(`https://noembed.com/embed?dataType=json&url=${vidurl}`).then(response => response.json())
            .then(darthVaderObj => {
                darth.push(darthVaderObj.title);
            })
        return darth;
    }

    // video_preview

    async function addVideo() {
        id = YouTubeGetID(document.getElementById('youTubeUrl').value);

        var data = await foo('https://www.youtube.com/watch?v=' + id);
        var title = ""
        if (data.length != 0) {
            title = data[0]


        }


        if (document.getElementById('youTubeUrl').value) {
            videoUrl = document.getElementById('youTubeUrl').value;


            var vidHtml = `<div class="afterImage-upload align-items-start xl_video" style="position:relative;">
                            <div class="row w-100 m-auto upload-video-wrap">
                                <div class="col-sm-3 video-prw-wrap">
                                    <div class="videoPreview">
                                        <iframe src="https://www.youtube.com/embed/` + id + `" alt=""></iframe>
                                    </div>
                                    <input type="hidden" value="https://www.youtube.com/embed/` + id + `" name="allValues[]">                          
                                    <input type="hidden" value="youtube" name="video_types[]">
                                    <input type="hidden" value="${title}" name="video_title[]">
                                </div>
                                <div class="col-sm-7 video-detail-wrap">
                                    <div class="previewDetail flex-1">
                                        <label class="f-500 mt-1">
                                            <p class="video-title-name">${title}</p>
                                        </label>
                                    </div>                                    
                                </div>
                                <div class="col-1 delete-video-wrap pl-0">
                                    <button type="button" class="video-delete-btn" >
                                       <span class="icon-trash grey delete-mark d-flex"></span>
                                    </button>
                                </div>
                                <div class="col-1 pl-0 up-down-wrap">
                                    <div class="d-flex flex-column">
                                        <button type="button" class="video-order-up jss1426 jss1424 anchorLoc">
                                            <span class="icon-arrow-h-right video-icon-up grey"></span>
                                        </button>

                                        <button type="button" class="video-order-down jss1426 jss1424 anchorLoc">
                                            <span class="icon-arrow-h-right video-icon-down grey"></span>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-12 text-area-wrap mt-3 w-100 mx-auto">
                                    <textarea class="step-form-control anchorLoc"  rows="1" style=" border-radius:5px; height:98px; padding:8px 15px;   resize: none;" placeholder="<?= l('qr_step_2_video.desc') ?>" name="videos_desc[]" pl rows="3"></textarea>
                                </div>
                            </div>
                    </div>`;
            $('#video_preview').append(vidHtml);

            document.getElementById('youTubeUrl').value = "";
            LoadPreview()
            $("#youTubeUrl").trigger("change");

        }
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
    $(document).ready(function() {
        // video-order-up
        // video-order-down
        $(".video_preview").on("click", ".video-order-up", function() {
            var mainNodes = $(this).parents('.video_preview').children('.afterImage-upload');
            var mainNodeslength = mainNodes.length;
            var mainNodesindex = mainNodes.index;
            if (mainNodeslength > 1) {
                $(this).parents('.afterImage-upload').insertBefore($(this).parents('.afterImage-upload').prev());
            }
            dataAnchor = this.getAttribute('data-anchor');
            LoadPreview(false, false, dataAnchor);
            initVideoOrderButAnchors()
        });
        $(".video_preview").on("click", ".video-order-down", function() {
            var mainNodes = $(this).parents('.video_preview').children('.afterImage-upload');
            var mainNodeslength = mainNodes.length;
            var mainNodesindex = mainNodes.index;
            if ((mainNodeslength > 1) && (mainNodes.is(':not(:first-child)'))) {
                $(this).parents('.afterImage-upload').insertAfter($(this).parents('.afterImage-upload').next());
            }
            dataAnchor = this.getAttribute('data-anchor');
            LoadPreview(false, false, dataAnchor);
            initVideoOrderButAnchors()
        });
    });
    $(document).ready(function() {
        var timer = setInterval(function() {
            if ($('.xl_video').children().length == 0) {
                $(".xl_video").remove();
            }
        }, 500); // check every half-second.
    });
    $(document).ready(function() {
        var timer = setInterval(function() {
            if ($(".local-video").children().length == 1) {
                $(".local-video").remove();
            }
        }, 500); // check every half-second.
    })
    $(document).ready(function() {
        var timer = setInterval(function() {
            if ($('#Highlight').is('[disabled=disabled]')) {
                $('.helight-wrap').css({
                    'opacity': '0.3'
                });
            } else {
                $('.helight-wrap').css({
                    'opacity': '1'
                });
            }
        }, 500); // check every half-second.
    });

    $(document).ready(function() {
        $("#direct_video").prop("disabled", true);
        $("#Autoplay").attr("disabled", true);

        setTimeout(function() {
            desableCheckBox();
            desableAutoplayCheckBox();
        }, 1000);
    });

    function desableCheckBox() {
        if ($('#direct_video').attr('disabled')) {
            $('.video-directly').css({
                'opacity': '0.3'
            });
        } else {
            $('.video-directly').css({
                'opacity': '1'
            });
        }
    }

    function desableAutoplayCheckBox() {
        if ($('#Autoplay').attr('disabled')) {
            $('.autoplay-wrapper').css({
                'opacity': '0.3'
            });
        } else {
            $('.autoplay-wrapper').css({
                'opacity': '1'
            });
            $("#direct_pdf").attr("disabled", false);
        }
    }

    function desableShowVideo() {
        var videoCount = $("#video_preview").children().length;
        if (videoCount > 1) {
            $(".video-directly").css({
                'display': 'none'
            });
        } else {
            $(".video-directly").css({
                'display': 'flex'
            });
        }
    }

    $('#video_preview').on('DOMSubtreeModified', function() {
        desableAutoplayCheckBox();
        desableShowVideo();
    });

    $(document).ready(function() {
        desableShowVideo();
    });

    function LoadPreview(welcome_screen = false, showLoader = true, changeAnc = null) {

        // if (showLoader)
        //     setFrame();

        if ($("input[name=\"step_input\"]").val() == 2) {
            $("#tabs-1").addClass("active");
            $("#tabs-2").removeClass("active");
            $("#2").removeClass("active");
            $("#1").addClass("active");
        }

        let youTubeUrl = document.getElementById('youTubeUrl').value;
        let direct_video = document.getElementById('direct_video').checked;
        let Highlight = document.getElementById('Highlight').checked;
        let Autoplay = document.getElementById('Autoplay').checked;
        let primaryColor = document.getElementById('primaryColor').value;
        let companyName = document.getElementById('companyName').value.replace(/&/g, '%26');
        let videoTitle = document.getElementById('videoTitle').value.replace(/&/g, '%26');
        let videoDescription = document.getElementById('videoDescription').value.replace(/&/g, '%26');
        let uId = document.getElementById('uId').value;
        let font_title = document.getElementById('filters_title_by').value;
        let font_text = document.getElementById('filters_text_by').value;


        let allVideos = $("input[name='allValues[]']").map((i, e) => {
            return {
                url: e.value,
                type: $("input[name='video_types[]']")[i].value,
                description: $("textarea[name='videos_desc[]']")[i].value
            };
        }).get();

        var youtubelength = $("input[name='youtubevideoUrl[]']").length;

        var screen = document.getElementById("editscreen").value;

        let video_button_text = document.getElementById('button_text')?.value.replace(/&/g, '%26') || "";
        let buttonCreated = "0";
        if (document.getElementById('button_text')) {
            buttonCreated = "1";
        }

        var urlValue = document.getElementById('button_url')?.value.replace(/&/g, '%26') || "";
        var video_button_urls = set_url(urlValue);

        if (parseInt(allVideos.length) == 0) {
            $("input[name=\"is_video\"]").val(0)
        } else {
            $("input[name=\"is_video\"]").val(1)
            $('#qr-code-wrap').addClass('active');

        }

        if (companyName == '' && videoTitle == '' && videoDescription == '' && allVideos.length == 0 && buttonCreated === "0") {
            companyName = 'Emily’s Kitchen';
            videoTitle = 'Cooking Tutorial';
            videoDescription = 'Watch our step-by-step cooking tutorial video and learn how to make a delicious meal in no time!';
            video_button_text = 'View More';
        } else {}



        if (allVideos.length == 0) {
            // $("#2").addClass('disable-btn');
            // $("#2").attr('disabled', true);
            $("#direct_video").attr("disabled", true);
            $("#Highlight").attr("disabled", true);
            $("#Autoplay").attr("disabled", true);
            $("#direct_video").prop("checked", false);
            $("#Highlight").prop("checked", false);
            $("#Autoplay").prop("checked", false);
            $("#youTubeUrl").attr("disabled", false);
            $(".dz-button").attr("disabled", false);
            $(".dz-button").removeAttr('style');
            $(".dz-message > p").removeAttr('style');
            $(".checkbox-label").css("color", "#a3abad");
            $(".checkbox-button").css("border", "1px solid #a3abad");
            $(".checkbox-button").css("cursor", "auto");
            $(".videos-upload").removeClass("disable-videos-upload");
            desableCheckBox();
            desableAutoplayCheckBox();

        } else if (allVideos.length == 1) {
            if ($('#direct_video').is(':checked')) {
                $("#Highlight").attr("disabled", true);
                $("#youTubeUrl").attr("disabled", true);
                $(".dz-button").attr("disabled", true);
                $(".dz-button").attr('style', 'background-color: #d9d9d9 !important;');
                $(".dz-message > p").attr('style', 'color: #d9d9d9 !important;');
                $(".videos-upload").addClass("disable-videos-upload");
            } else {
                $("#Highlight").attr("disabled", false);
                $("#youTubeUrl").attr("disabled", false);
                $(".dz-button").attr("disabled", false);
                $(".dz-button").removeAttr('style');
                $(".dz-message > p").removeAttr('style');
                $(".videos-upload").removeClass("disable-videos-upload");
            }
            $(".checkbox-button").css("border", "2px solid #a3abad");
            $(".checkbox-button").css("cursor", "pointer");
            $(".checkbox-label").css("color", "#767c83");
            $("#direct_video").removeAttr('disabled');
            $("#Autoplay").attr("disabled", false);
            desableCheckBox();
            desableAutoplayCheckBox();
        } else {
            $("#direct_video").attr("disabled", false);
            $("#Highlight").attr("disabled", false);
            $("#Autoplay").attr("disabled", false);
            $("#youTubeUrl").attr("disabled", false);
            $(".dz-button").attr("disabled", false);
            $(".dz-button").removeAttr('style');
            $(".dz-message > p").removeAttr('style');
            $(".checkbox-label").css("color", "#767c83");
            $(".checkbox-button").css("border", "2px solid #a3abad");
            $(".checkbox-button").css("cursor", "pointer");
            $(".videos-upload").removeClass("disable-videos-upload");
            desableCheckBox();
            desableAutoplayCheckBox();
        }

        if (allVideos.length > 0) {
            $("#2").removeClass('disable-btn');
            $("#2").attr('disabled', false);
        } else {
            $("#2").addClass('disable-btn');
            $("#2").attr('disabled', true);
        }

        const PreviewData = {
            live: true,
            videos: allVideos,
            direct_video: direct_video || false,
            Highlight: Highlight || false,
            Autoplay: Autoplay || false,
            primaryColor: primaryColor,
            companyName: companyName,
            videoTitle: videoTitle,
            videoDescription: videoDescription,
            screen: !welcome_screen ? false : screen,
            font_title: font_title,
            font_text: font_text,
            button_text: video_button_text,
            button_url: video_button_urls,
            change: changeAnc || dataAnchor,
            type:'video',
            static:false,
            step:2
        };

        try {
            document.getElementById('iframesrc').contentWindow.postMessage(PreviewData, '<?= LANDING_PAGE_URL ?>');
        } catch (e) {
            console.warn(e);
        }

        let im_url = $('#qr_code').attr('src');
        if ($(".qrCodeImg")) {
            $(".qrCodeImg").html(`<img id="qr_code_p" src=` + im_url + ` class="img-fluid qr-code" loading="lazy" />`);
        }
    }

    if($('#qr_status').val()){
        $('#iframesrc').ready(function(){
            setTimeout(()=>{
                LoadPreview()
                initVideoOrderButAnchors();
            },1000)
        })
    }

    function initVideoOrderButAnchors() {
        $('#video_preview .afterImage-upload').map((i, e) => {
            $(".video-order-up.anchorLoc")[i].setAttribute('data-anchor', `video${i}`);
            $(".video-order-down.anchorLoc")[i].setAttribute('data-anchor', `video${i+2}`);
        });
    }
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