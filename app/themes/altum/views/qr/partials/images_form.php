<?php defined('ALTUMCODE') || die() ?>
<?php

$decodedData = json_decode(isset($data->qr_code[0]['data']) ? $data->qr_code[0]['data'] : null, true);
$qrType = isset($decodedData['type']) ? $decodedData['type'] : null;

$images = $decodedData['images'];

if (isset($data->qr_code[0]['data']) && $qrType == 'images') {
    $filledInput = json_decode($data->qr_code[0]['data'], true);

    $qrName =  $data->qr_code[0]['name'];
    $qrUid =  $data->qr_code[0]['uId'];
} else {
    $filledInput = array();
    $qrName = null;
    $qrUid = null;
}

if (isset($filledInput["preview_link2"])) {
    $url = $filledInput["preview_link2"];
}
// Parse the query string into an array
if (isset($url) && !empty($url)) {
    parse_str(parse_url($url, PHP_URL_QUERY), $query);
}
// Decode the JSON string value of the "images" key
if (isset($query['images'])) {
    // $images = json_decode($query['images']);
}
?>


<div id="step2_form">

    <!-- <input type="hidden" id="uId" name="uId" class="form-control" value="<?php echo (!empty($filledInput)) ? $qrUid : uniqid();  ?>" data-reload-qr-code /> -->
    <input type="hidden" id="preview_link" name="preview_link" class="form-control" value="<?php echo (!empty($filledInput)) ? $filledInput['preview_link'] : '';  ?>" data-reload-qr-code />
    <input type="hidden" id="preview_link2" name="preview_link2" class="form-control" value="<?php echo (!empty($filledInput)) ? $filledInput['preview_link2'] : '';  ?>" data-reload-qr-code />
    <input type="hidden" name="uploadUniqueId" id="uploadUniqueId" value="">

    <!-- add color palette -->
    <?php include_once('components/design-1-color.php'); ?>

    <div class="custom-accodian images-upload-main-wrp upload-main-wrp">
        <button class="btn accodianBtn" type="button" data-toggle="collapse" data-target="#acc_images" aria-expanded="true" aria-controls="acc_images">
            <div class="qr-step-icon">
                <span class="icon-upload-image grey steps-icon"></span>
            </div>

            <span class="custom-accodian-heading">
                <span class="accodianRequired"><?= l('qr_step_2_images.input') ?><sup>*</sup></span>
                <span class="fields-helper-heading"><?= l('qr_step_2_images.help_txt.input') ?></span>
            </span>

            <div class="toggle-icon-wrap ml-2">
                <span class="icon-arrow-h-right grey toggle-icon"></span>
            </div>
        </button>
        <div class="collapse show" id="acc_images">
            <hr class="accordian-hr">
            <div class="collapseInner">
                <div class="dropzone dropzone fileupload col-12 image-file-upload" id="files">
                </div>
                <span class="col-lg-12 col-xl-12 error" id="logo-error" style="color:red;"></span>

                <div id="img_previews">
                </div>
                <div id="custom-dropzone-preview" class="image-dropzone dropzone-previews dropzone col-12 " style="display:<?php echo isset($images)  ? 'flex !important' : 'none !important';  ?> ">
                    <?php if (!empty($images)) { ?>
                        <?php foreach ($images as $key => $image) { ?>
                            <div class="dz-preview dz-complete dz-image-preview image-dz" data-touch-count="0">
                                <div class="dz-image">
                                    <img data-dz-thumbnail="" alt="<?= $image ?>" src="<?= $image ?>" style="height: inherit;width:fit-content;">
                                </div>
                                <span class="hover-effect-icon"></span>
                                <div class="upload-edit-wrap image-file-upload">
                                    <span class="image-edit-icon"></span>
                                    <input type="file" class="update-image-file" accept="image/*">
                                </div>
                                <input type="hidden" name="images[]" class="media-ids dz-media-id" value="<?= $image ?>">
                                <a class="dz-remove" href="javascript:undefined;" data-dz-remove=""><?= l('qr_step_2_images.delete') ?><span class="dz-remove-icon"></span></a>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
                <div class="row">
                    <!-- <input type="hidden" name="is_image" value="0" id="is_image"> -->
                </div>

                <div class="checkbox-wrapper img_check_wrapper">
                    <div class="roundCheckbox m-2 mr-3">
                        <input type="checkbox" style="border:<?php echo isset($isImage) ? '2px solid #767c83' : '1px solid #a3abad' ?>" id="uploadCheckbox" name="uploadCheckbox" <?php echo (!empty($filledInput)) ? ((isset($filledInput['uploadCheckbox'])) ? 'checked' : '') : '';  ?> <?php echo isset($isImage) ? '' : 'disabled' ?>>
                        <label class="m-0 checkbox-label-vertical" style="border-width:1px ;" for="uploadCheckbox"></label>
                    </div>
                    <label class="passwordlabel checkbox-label mb-0" style="color:<?php echo isset($isImage) ? '#767c83' : '#a3abad' ?>"><?= l('qr_step_2_images.vertical') ?></label>
                </div>
            </div>
        </div>
    </div>
    <div class="custom-accodian image-info-main-wrp info-block-main-wrp">
        <button class="btn accodianBtn" type="button" data-toggle="collapse" data-target="#acc_imageInfo" aria-expanded="true" aria-controls="acc_imageInfo">
            <div class="qr-step-icon">
                <span class="icon-info grey steps-icon"></span>
            </div>

            <span class="custom-accodian-heading">
                <span><?= l('qr_step_2_images.image_information') ?></span>
                <span class="fields-helper-heading"><?= l('qr_step_2_images.help_txt.image_information') ?></span>
            </span>

            <div class="toggle-icon-wrap ml-2">
                <span class="icon-arrow-h-right grey toggle-icon"></span>
            </div>
        </button>
        <div class="collapse show" id="acc_imageInfo">
            <hr class="accordian-hr">
            <div class="collapseInner">
                <div class="form-group step-form-group mb-4">
                    <label for="image_title"> <?= l('qr_step_2_images.input.imageName') ?> <span class="text-danger text-bold"></span></label>
                    <input id="image_title" placeholder="<?= l('qr_step_2_images.input.image_title.placeholder') ?>" name="image_title" data-anchor="image_title" class="form-control anchorLoc" value="<?php echo (!empty($filledInput)) ? $filledInput['image_title'] : ''; ?>" data-reload-qr-code />
                </div>
                <div class="form-group step-form-group mb-4">
                    <label for="image_description"> <?= l('qr_step_2_images.input.imageDescription') ?> <span class="text-danger text-bold"></span></label>
                    <input id="image_description" placeholder="<?= l('qr_step_2_images.input.image_description.placeholder') ?>" name="image_description" data-anchor="image_title" class="anchorLoc form-control" value="<?php echo (!empty($filledInput)) ? $filledInput['image_description'] : ''; ?>" maxlength="<?= $data->qr_code_settings['type']['images']['image_description']['max_length'] ?>" data-reload-qr-code />
                </div>
                <div class="form-group step-form-group mb-4 addRow">
                    <label for="website"> <?= l('qr_step_2_images.input.website') ?></label>
                    <input id="website" type="url" placeholder="<?= l('qr_step_2_images.input.website.placeholder') ?>" name="website" data-anchor="website" class="anchorLoc form-control" value="<?php echo (!empty($filledInput)) ? $filledInput['website'] : ''; ?>" data-reload-qr-code />
                </div>
                <?php if ((!empty($filledInput)) ? ((isset($filledInput['button_text']) != '') ? '1' : '') : '') { ?>

                    <?php foreach ($filledInput['button_url'] as $key => $btnUrl) { ?>

                        <div class=" step-form-group  addRow button-wrp mb-3">
                            <label for="contactMobiles"> <?= l('qr_step_2_images.input.button') ?> <span class="text-danger text-bold">*</span></label>
                            <div class="d-flex align-items-center w-100">
                                <div class="d-flex align-items-center w-100 form-fields-wrp img-buttons">
                                    <div class="w-75 btn-text mr-3 "><input class="form-control mr-3" onchange="LoadPreview()" type="text" id="button_text" name="button_text[]" value="<?php echo (!empty($filledInput)) ? $filledInput['button_text'][$key] : '' ?>" placeholder="<?= l('qr_step_2_images.input.button_text.placeholder') ?>" required input_validate /> </div>
                                    <div class="w-100 btn-url mr-3"><input class="form-control mr-3" onchange="LoadPreview()" type="url" id="button_url" name="button_url[]" value="<?php echo (!empty($filledInput)) ? $btnUrl : '' ?>" placeholder="<?= l('qr_step_2_images.input.button_url.placeholder') ?>" required input_validate /></div>
                                </div>
                                <button class="reapeterCloseIcon removeBtn imgRemoveBtn" type="button" onclick="remove_me(this)">
                                    <span class="icon-trash remove-btn-icon"></span>
                                </button>

                            </div>
                        </div>

                    <?php } ?>

                    <div class="px-2 mt-4">
                        <button id="add2" type="button" class="outlineBtn addRowButton imgAddRowBtn all-add-btn"><span class="icon-add-square start-icon add-btn-icon"></span> <span><?= l('qr_step_2_images.input.addButton') ?></span></button>
                    </div>

                <?php } else { ?>

                    <div class="px-2 mt-4">
                        <button id="add2" type="button" class="outlineBtn addRowButton imgAddRowBtn all-add-btn"><span class="icon-add-square start-icon add-btn-icon"></span> <span> <?= l('qr_step_2_images.input.addButton') ?></span></button>
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
    var imageArray = [];
    var base_url = `<?php echo UPLOADS_FULL_URL ?>`;
    var isImage = false;
    var ImagesUploading = false;
    let uId = document.getElementById('uId').value;
    var isSuccess = false;
    var isNotError = true;
    var myDropzone = new Dropzone("div#files", {
        // autoProcessQueue: false,
        url: '<?= url('qr-code-generator') ?>',
        addRemoveLinks: true,
        paramName: "images",
        previewsContainer: ".dropzone-previews",
        acceptedFiles: ".jpeg,.jpg,.png,.gif,.webp,.svg",
        // acceptedFiles: ["image/*"],
        maxFilesize: 10, //2 MB
        maxFiles: 20,
        init: function() {
            this.on("complete", function(file) {
                $(".dz-remove").text("<?= l('qr_step_2_images.delete') ?>");
                $(".dz-remove").append('<span class="dz-remove-icon"></span>');
            });
            this.on("addedfile", function(file) {
                $(".dz-remove").text("<?= l('qr_step_2_images.delete') ?>");
                $(".dz-remove").append('<span class="dz-remove-icon"></span>');
                $("#custom-dropzone-preview").removeAttr('style');

                // if(maxFilesize > 10){

                // }else{

                // }
                $("#2").attr("disabled", false);
                $("#2").removeClass("disable-btn");
            });
        },

        renameFile: function(file) {
            let newName = new Date().getTime() + '_' + file.name.replaceAll(" ", "-");
            return newName;
        },
        sending: function(file, xhr, formData) {
            $('#loader.qr').fadeIn(); +
            $('#qr-code-wrap').fadeOut();


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
            currentPos = "";
            var fileNames = file.upload.filename;
            var fileExtension = file.upload.filename.substr(fileNames.lastIndexOf('.') + 1);
            fileLinks = "images/" + uId + "_" + imageArray[fileNames] + "." + fileExtension;
            formData = new FormData();
            formData.append('action', 'deleteFiles');
            formData.append('fileLinks', fileLinks);

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
            var imagesArray = <?php echo json_encode(isset($images)); ?>;
            if (myDropzone.getAcceptedFiles().length <= 0) {
                $("#custom-dropzone-preview").attr('style', 'display:none !important');
                $('#qr-code-wrap').html("");
                $("#is_image").val(0);
            }
            LoadPreview(undefined, false);
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
            currentPos = "";
            isSuccess = true;
            var responseText = JSON.parse(responseText); +
            $('#qr-code-wrap').html(responseText.details.image);

            document.querySelector('#download_svg').href = responseText.details.data;
            if (document.querySelector('input[name="qr_code"]')) {
                document.querySelector('input[name="qr_code"]').value = responseText.details.data;
            }

            var fileNames = file.upload.filename;
            var fileExtension = file.upload.filename.substr(fileNames.lastIndexOf('.') + 1);
            var fileValue = base_url + "images/" + uId + "_" + imageArray[fileNames] + "." + fileExtension;

            $('#loader.qr').fadeOut(); +
            $('#qr-code-wrap').fadeIn();

            $(file.previewElement).append($('<input type="hidden" name="images[]" class="media-ids dz-media-id" value="' + fileValue + '">'));
            $("#is_image").val(1);
            $(file.previewElement).append('<span class="hover-effect-icon"></span>');
            $(file.previewElement).append('<div class="upload-edit-wrap image-file-upload"></div>');
            $(file.previewElement).children(".upload-edit-wrap").append('<span class="image-edit-icon"></span>');
            $(file.previewElement).children(".upload-edit-wrap").append('<input type="file" class="update-image-file" accept="image/*">');
            LoadPreview();
        },
        error: function(file, response) {
            isNotError = false;
            $(".preview-qr-btn").attr("disabled", false);
            file.previewElement.remove();
            var fileNames = file.upload.filename
            delete imageArray.fileNames;

            // myDropzone.removeFile(file);
            var errorAreas = document.getElementsByClassName("invalid_err");
            if (errorAreas[0]) {
                if (response == "You can not upload any more files.") {
                    $(errorAreas[0]).text("<?= l('qr_step_2_images.max_images') ?>");
                } else {
                    $(errorAreas[0]).text("<?= l('qr_step_2_images.max_allowed') ?>");
                }
            } else {
                if (response == "You can not upload any more files.") {
                    $("#files").after("<span class=\"invalid_err\" style='margin-top:15px;'><?= l('qr_step_2_images.max_images') ?></span>");
                } else {
                    $("#files").after("<span class=\"invalid_err\" style='margin-top:15px;'><?= l('qr_step_2_images.max_allowed') ?></span>");
                    $("#custom-dropzone-preview").css("display", "none");
                }
            }
        },
    });

    $(document).on('change', '.image-file-upload', async function(e) {
        var newUpdateFile = e.target.files[0].name;
        var newImageFileSize = e.target.files[0].size / Math.pow(1024, 2);
        if (newImageFileSize < 10) {
            $(".invalid_err").remove();
            var newUpdateFileName = updateFileRename(newUpdateFile);
            var newUpdateFileExtention = getUpdateFileExtention(newUpdateFileName);
            var imageId = Date.now();
            imageArray[newUpdateFileName] = imageId;

            var newFileName = uId + "_" + Date.now() + "." + newUpdateFileExtention;
            var fileValue = base_url + "images/" + newFileName;

            $(this).parents(".dz-preview").children(".media-ids").remove();
            // $(this).parents(".dz-preview").append($('<input type="hidden" name="images[]" class="media-ids dz-media-id" value="' + fileValue + '">'));
            var newFile = e.target.files[0];

            var formData = new FormData(); // Append the file data

            formData.append('action', 'edit_uploaded_image');
            formData.append('file', newFile);
            formData.append('imageId', imageId);
            formData.append('fileName', newFileName);
            formData.append('mime', newFile['type']);

            // Make the AJAX request
            $.ajax({
                type: 'POST',
                url: '<?= url('api/ajax') ?>',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $(e.currentTarget).parents(".dz-preview").append($('<input type="hidden" name="images[]" class="media-ids dz-media-id" value="' + response.data + '">'));
                    $(e.currentTarget).parents(".dz-preview").children(".dz-image").children("img").attr('src', response.data);
                    LoadPreview(undefined, false);

                },
                error: function(error) {
                    console.error(error);
                }
            });
        } else {
            $("#custom-dropzone-preview").next().append('<span class="invalid_err"></span>');
            $(".invalid_err").text("<?= l('qr_step_2_images.max_allowed') ?>");
        }
    });


    function updateFileRename(newUpdateFile) {
        let newUpdateFileName = new Date().getTime() + '_' + newUpdateFile.replace(/ /g, "-");;
        return newUpdateFileName;
    }

    function getUpdateFileExtention(newUpdateFileName) {
        var updateFileExtention = newUpdateFileName.split(".").pop();
        return updateFileExtention;
    }

    $(document).on('click', '.hover-effect-icon', function() {
        $(this).closest(".dz-preview").find(".image-file-upload").children(".update-image-file").trigger("click");
    });

    $(".dz-button").text("<?= l('qr_step_2_images.upload_images') ?>");
    $(".dz-button").after("<p style='color: #220E27;margin-top: 16px;font-size: 13px;line-height: 18px;  '><strong><?= l('qr_step_2_images.mx_file') ?></strong></p>");
</script>

<script>
    const Allimage = document.getElementById('Allimage');
    const dt = new DataTransfer();

    function formatBytes(bytes, decimals = 2) {
        if (!+bytes) return '0 Bytes'

        const k = 1024
        const dm = decimals < 0 ? 0 : decimals
        const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB']

        const i = Math.floor(Math.log(bytes) / Math.log(k))

        return `${parseFloat((bytes / Math.pow(k, i)).toFixed(dm))} ${sizes[i]}`
    }
</script>
<script>
    var image_uploaded = false;

    var allImages = [];

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

        if (($('input[name=qrtype_input]').length > 0 && $('input[name=qrtype_input]').val() == "url") || ($('input[name=qrtype_input]').length > 0 && $('input[name=qrtype_input]').val() == "wifi")) {
            
        } else {
            currentPos = e.target.getAttribute('data-anchor');
        }
    });

    $("#uploadCheckbox").on("change", function() {
        currentPos = "";
        LoadPreview();
    });

    // document.getElementById('iframesrc').src = '<?=LANDING_PAGE_URL?>preview/images';

    function LoadPreview(welcome_screen = false, showLoader = true,changeAnc = null) {

        //Prepare Anchors
        document.querySelectorAll(".img-buttons").forEach((elm,i)=>{
            elm.querySelectorAll('input').forEach((f,p)=>{
                f.classList.add('anchorLoc');
                f.setAttribute('data-anchor',`button_${f.type}_${i+1}`);
            })
        }) 

        if (showLoader){
            // setFrame();
        }

        if ($("input[name=\"step_input\"]").val() == 2) {
            $("#tabs-1").addClass("active");
            $("#tabs-2").removeClass("active");
            $("#2").removeClass("active");
            $("#1").addClass("active");
        }

        let uId = document.getElementById('uId').value;
        let primaryColor = document.getElementById('primaryColor').value;
        let image_title = document.getElementById('image_title').value.replace(/&/g, '%26');
        let image_description = document.getElementById('image_description').value.replace(/&/g, '%26');

        var webValue = document.getElementById('website').value.replace(/&/g, '%26');
        var website = set_url(webValue);


        let font_title = document.getElementById('filters_title_by').value;
        let font_text = document.getElementById('filters_text_by').value;

        let im_url;

        let buttons = $("input[name='button_text[]']").map((i,e)=>{
            return {
                text:e.value,
                url:$("input[name='button_url[]']")[i].value
            };
        }).get();

        var screen = document.getElementById("editscreen").value;

        allImages = $("input[name='images[]']").map(function(i) {
            return $(this).val().replace(/&/g, '%26');
        }).get();

        if (allImages == null || allImages.length <= 0) {

            $("#2").addClass('disable-btn');
            $("#2").attr('disabled', true);
            $("#tabs-1").addClass('active');
            $("#tabs-2").removeClass('active');
            // $("#1").addClass('active');
            $("#2").addClass('no-files');
            $("#2").removeClass('active');
            isImage = false;
            $("#uploadCheckbox").attr('disabled', true);
            $("#uploadCheckbox").prop("checked", false);
            $("#custom-dropzone-preview").attr('style', 'display:none !important');
            $(".checkbox-label").css("color", "#a3abad");
            $(".checkbox-label-vertical").css("border", "1px solid #a3abad");
            $(".checkbox-label-vertical").css("cursor", "auto");
            if (currentPos != '') {
                currentPos = '';
                console.log(currentPos);
                LoadPreview();
            }
        } else {
            $("#custom-dropzone-preview").attr('style', 'display:flex !important');
            isImage = true;
            $('#qr-code-wrap').addClass('active');
            // $("#2").removeClass('disable-btn');
            $("#2").removeClass('no-files');
            $("#2").attr('disabled', false);
            $("#uploadCheckbox").attr('disabled', false);
            $(".checkbox-label").css("color", "#767c83");
            $(".checkbox-label-vertical").removeAttr('style');
            // $(".dz-remove").append('<span class="dz-remove-icon"></span>');
        }

        let uploadCheckbox = document.getElementById('uploadCheckbox').checked;

        var default_image = ['<?php echo LANDING_PAGE_URL; ?>images/images/new/01.webp', '<?php echo LANDING_PAGE_URL; ?>images/images/new/02.webp'];

        if (allImages.length == 0 && image_title == '' && image_description == '' && website == "" ) {
            allImages = default_image;
            image_title = '<?= str_replace("'", "\'", l('qr_step_2_images.lp_def_image_title')) ?>';
            image_description = '<?= str_replace("'", "\'", l('qr_step_2_images.lp_def_image_description')) ?>';
            buttons = [{text:'<?= str_replace("'", "\'", l('qr_step_2_images.lp_def_button_text')) ?>',url:'#'}];
            website = '#';
            uploadCheckbox = true;
        }

        const PreviewData = {
            live: true,
            primaryColor: primaryColor,
            image_title: image_title,
            image_description: image_description,
            font_title: font_title,
            font_text: font_text,
            screen: !welcome_screen ? false : screen,
            website: website,
            images: allImages,
            buttons: buttons,
            horizontal: uploadCheckbox||false,
            change: changeAnc || currentPos,
            type:'images',
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


        im_url = $('#qr_code').attr('src');

        if ($(".qrCodeImg")) {
            $(".qrCodeImg").html(`<img id="qr_code_p" src=` + im_url + ` class="img-fluid qr-code" loading="lazy" />`);
        }


        // if ($("input[name=\"qrcodeId\"]").val()) {
        //     save_qr_fn();
        // }
    }
    
    if($('#qr_status').val()){
        $('#iframesrc').ready(function(){
            setTimeout(()=>{
                LoadPreview()
            },1000)
        })
    }

    function loadImage() {
        LoadPreview();
    }

    
    $(document).on('click', '.dz-remove', function() {
        $(this).parent().remove();
        allImages.splice(1);
        LoadPreview(true);
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

    $(document).on('touchstart', '.dz-remove', function(event) {
        event.preventDefault();
        console.log("hsbdfjbsf");
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