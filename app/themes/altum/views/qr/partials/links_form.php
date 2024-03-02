<?php


defined('ALTUMCODE') || die() ?>

<?php
$decodedData = json_decode(isset($data->qr_code[0]['data']) ? $data->qr_code[0]['data'] : null, true);
$qrType = isset($decodedData['type']) ? $decodedData['type'] : null;

if (isset($data->qr_code[0]['data']) && $qrType == 'links') {
    $filledInput = json_decode($data->qr_code[0]['data'], true);
    $qrName =  $data->qr_code[0]['name'];
    $qrUid =  $data->qr_code[0]['uId'];

    $previewLink = parse_url($filledInput['preview_link2'], PHP_URL_QUERY); // Get query string
    parse_str($previewLink, $params); // Convert query string to array

    $linkImages  =  $filledInput['linkImg'];
    $companyLogo = $filledInput['companyLogoImage'];
} else {
    $filledInput = array();
    $pdfUrl = "<?php echo UPLOADS_FULL_URL;?>pdf/" . isset($filledInput['uId']) . ".pdf";
    $qrName = null;
    $qrUid =  null;
    $companyLogo =  null;
}
$listArray = isset($filledInput['list_text']);

?>


<style>
    link-preview:first-child {
        background-color: red
    }
</style>

<div id="step2_form">

    <!-- <input type="hidden" id="uId" name="uId" class="form-control" value="<?php echo (!empty($filledInput)) ? $qrUid : uniqid();  ?>" data-reload-qr-code /> -->
    <input type="hidden" id="preview_link" name="preview_link" value="<?php echo (!empty($filledInput)) ? $filledInput['preview_link'] : '';  ?>" class="form-control" data-reload-qr-code />
    <input type="hidden" id="preview_link2" name="preview_link2" value="<?php echo (!empty($filledInput)) ? $filledInput['preview_link2'] : '';  ?>" class="form-control" data-reload-qr-code />
    <input type="hidden" name="uploadUniqueId" id="uploadUniqueId" value="">

    <!-- add color palette -->
    <?php include_once('components/design-3-color.php'); ?>

    <div class="custom-accodian">
        <button class="btn accodianBtn" type="button" data-toggle="collapse" data-target="#acc_listInfo" aria-expanded="true" aria-controls="acc_listInfo">
            <div class="qr-step-icon">
                <span class="icon-info grey steps-icon"></span>
            </div>

            <span class="custom-accodian-heading">
                <span class="accodianRequired"><?= l('qr_step_2_links.information') ?><sup>*</sup></span>
                <span class="fields-helper-heading"><?= l('qr_step_2_links.help_txt.information') ?></span>
            </span>

            <div class="toggle-icon-wrap ml-2">
                <span class="icon-arrow-h-right grey toggle-icon"></span>
            </div>
        </button>
        <div class="collapse show" id="acc_listInfo">
            <hr class="accordian-hr">
            <div class="collapseInner">
                <div class="welcome-screen mb-3 pl-2">
                    <span style="display:flex;" class="bar-code-text">
                        <?= l('qr_step_2_links.input.companyLogo') ?>
                        <span
                            class="info-tooltip-icon ctp-tooltip"
                            tp-content="<?= l('qr_step_2_links.help_tooltip.companyLogo') ?>"
                        ></span>
                    </span>
                    <div class="screen-upload">
                        <label for="companyLogo">

                            <input type="hidden" id="companyLogoImage" name="companyLogoImage" value="<?php echo $companyLogo ? $companyLogo : ''; ?>">

                            <input type="file" id="companyLogo" name="companyLogo" data-anchor="list_title" class="anchorLoc form-control py-2" accept="image/png, image/gif, image/jpeg, image/svg+xml, image/webp" input_size_validate required />
                            <div class="input-image d-flex" id="company_logo_img">

                                <?php if ($companyLogo) { ?>
                                    <img src="<?php echo $companyLogo; ?>" height="" width="" alt="Company Logo image" id="cl-upl-img" />
                                <?php } ?>
                                <span class="icon-upload-image mb-0" id="cl-tmp-mage" style="display:<?php echo $companyLogo ? 'none' : 'flex'; ?>;"></span>
                            </div>
                            <div class=" add-icon" id="company_log_add_icon" style="display:<?php echo  $companyLogo ? 'none' : 'block'; ?>; opacity:0;">
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
                            <?= l('qr_step_2_links.delete') ?>
                        </button>
                    </div>
                </div>
                <div class="form-group step-form-group mb-3">
                    <label for="list_title"><?= l('qr_step_2_links.title') ?> <span class="text-danger text-bold">*</span></label>
                    <input id="list_title" placeholder="<?= l('qr_step_2_links.input.list_title.placeholder') ?>" name="list_title" data-anchor="list_title" class="anchorLoc step-form-control" value="<?php echo (!empty($filledInput)) ? $filledInput['list_title'] : ''; ?>" required="required" data-reload-qr-code input_validate />
                </div>
                <div class="form-group m-0 step-form-group">
                    <label for="list_description"><?= l('qr_step_2_links.description') ?></label>
                    <input id="list_description" placeholder="<?= l('qr_step_2_links.input.list_description.placeholder') ?>" name="list_description" data-anchor="list_title" class="anchorLoc step-form-control" value="<?php echo (!empty($filledInput)) ? $filledInput['list_description'] : ''; ?>" required="required" data-reload-qr-code />
                </div>
            </div>
        </div>
    </div>

    <div class="custom-accodian">
        <button class="btn accodianBtn" type="button" data-toggle="collapse" data-target="#acc_link" aria-expanded="true" aria-controls="acc_link">
            <div class="qr-step-icon">
                <span class="icon-links grey steps-icon"></span>
            </div>

            <span class="custom-accodian-heading">
                <span><?= l('qr_step_2_links.name') ?></span>
                <span class="fields-helper-heading"><?= l('qr_step_2_links.help_txt.name') ?></span>
            </span>

            <div class="toggle-icon-wrap ml-2">
                <span class="icon-arrow-h-right grey toggle-icon"></span>
            </div>
        </button>

        <!-- Links -->
        <div class="collapse show pb-3" id="acc_link">
            <hr class="accordian-hr">
            <div class="collapseInner p-0">
                <?php if (!empty($filledInput)) { ?>
                    <div class="link-preview">
                        <?php foreach ($filledInput['list_text'] as $key => $list) { ?>
                            <div id="add_product" class="filledInput link-container">
                                <div class="productAccodian accordian-wrp">
                                    <div class="row mx-auto w-100 link-section-wrap justify-content-between mb-3">
                                        <button class="accodianBtn justify-content-start col-9 link-btn-accordian" type="button" data-target="#acc_prodactname" aria-expanded="true" aria-controls="acc_prodactname">
                                            <p class="paraheading link-heading mb-0 ml-2"><?= l('qr_step_2_links.link') ?></p>
                                        </button>

                                        <div class="col-3 d-flex justify-content-around align-items-center pr-0 link-button-full-wrap">
                                            <div class="links-up-down d-flex linkActionButtons">
                                                <div class="d-flex w-100 links-up-down-wrap justify-content-center align-items-center">
                                                    <button type="button" class="link-order-up link-option-btn jss1426 jss1424">
                                                        <span class="icon-arrow-h-right link-icon-up grey"></span>
                                                    </button>
                                                    <button type="button" class="link-order-down link-option-btn jss1426 jss1424">
                                                        <span class="icon-arrow-h-right link-icon-down grey"></span>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="links-delete-wrap">
                                                <button type=" button" class="formCustomBtn link-delete-btn link-option-btn removeLinkFields">
                                                    <span class="icon-trash link-icon-delete d-flex grey"></span>
                                                </button>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="collapse show" id="">
                                        <div class="collapseInner p-0">
                                            <div class="welcome-screen mb-4 pl-2">
                                                <span class="bar-code-text"><?= l('qr_step_2_links.image') ?></span>
                                                <div class="screen-upload">
                                                    <label for="linkImages">
                                                        <input type="hidden" name="linkImg[]" value="<?php echo $filledInput['linkImg'] ? $filledInput['linkImg'][$key] : ''; ?>">
                                                        <input type="file" id="linkImages<?php echo $key + 1 ?>" name="linkImages[]" data-anchor="list_text_<?=$key + 1?>"  class="anchorLoc form-control py-2 linkImages" accept="image/png, image/gif, image/jpeg" />
                                                        <div class="input-image">
        
                                                            <?php
                                                            if (isset($filledInput['linkImg'][$key]) && $filledInput['linkImg'][$key] != '') {
                                                            ?>
                                                                <img src="<?php echo $filledInput['linkImg'][$key]; ?>" height="" width="" class="upl-p-img" alt="Welcome screen image" id="upl-p-img" />
                                                            <?php
                                                            }
                                                            ?>
        
                                                            <span class="icon-upload-image defaultImage mb-0" style="display:<?= $filledInput['linkImg'][$key]  ? 'none' : 'flex'; ?>;"></span>
        
                                                        </div>
                                                        <div class="add-icon addLImage" style="display:<?= (isset($filledInput['linkImg'][$key]) &&  $filledInput['linkImg'][$key] != '') ? 'none' : 'flex'; ?>;opacity:0;" onclick="triggerLinkImage('<?php echo $key + 1 ?>')">
                                                            <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                                                <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"></path>
                                                            </svg>
                                                        </div>
                                                        <div class="add-icon editLImage" style="display:<?= (isset($filledInput['linkImg'][$key]) &&  $filledInput['linkImg'][$key] != '') ? 'flex' : 'none'; ?>;opacity:0;" onchange="triggerLinkImage('<?php echo $key + 1 ?>')">
                                                            <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 24px;margin: 7px;">
                                                                <path d="M20.71,6.29l-3-3a1,1,0,0,0-1.42,0l-12,12a1,1,0,0,0-.26.47l-1,4a1,1,0,0,0,.26.95A1,1,0,0,0,4,21a1,1,0,0,0,.24,0l4-1a1,1,0,0,0,.47-.26l12-12A1,1,0,0,0,20.71,6.29ZM7.49,18.1l-2.12.53.53-2.12,8.6-8.6L16.09,9.5Zm10-10L15.91,6.5,17,5.41,18.59,7Z"></path>
                                                            </svg>
                                                        </div>
                                                    </label>
                                                    <button type="button" class="delete-btn l_delete" style="display:<?= (isset($filledInput['linkImg'][$key])  && $filledInput['linkImg'][$key] != '') ? 'flex' : 'none'; ?>;">
                                                        <?= l('team_members.input.access.delete') ?>
                                                    </button>
                                                </div>
                                            </div>
        
                                            <div class="form-group step-form-group mb-3">
                                                <label for="list_text"><?= l('qr_step_2_links.text') ?> <span class="text-danger text-bold"></span></label>
                                                <input id="list_text" placeholder="" name="list_text[]" data-anchor="list_text_<?=$key + 1?>"  class="anchorLoc step-form-control" value="<?php echo $list ?>"  data-reload-qr-code  />
                                            </div>
                                            <div class="form-group m-0 step-form-group">
                                                <label for="list_URL"><?= l('qr_step_2_links.url') ?> <span class="text-danger text-bold">*</span></label>
                                                <input type="url" id="list_URL" placeholder="" name="list_URL[]" data-anchor="list_text_<?=$key + 1?>"  class="anchorLoc step-form-control" value="<?php echo (!empty($filledInput)) ? $filledInput['list_URL'][$key] : ''; ?>"  data-reload-qr-code  />
                                            </div>

                                        </div>

                                    </div>

                                </div>
                            </div>
                        <?php } ?>
                    </div>
                <?php } else { ?>
                    <div class="link-preview">
                        <div id="add_product" class="filledInput link-container">
                            <div class="productAccodian accordian-wrp">
                                <div class="row mx-auto w-100 link-section-wrap justify-content-between mb-3">
                                    <button class="accodianBtn justify-content-start col-9 link-btn-accordian" type="button" data-target="#acc_prodactname" aria-expanded="true" aria-controls="acc_prodactname">
                                        <p class="paraheading link-heading mb-0 ml-2"><?= l('qr_step_2_links.link') ?></p>
                                    </button>

                                    <div class="col-3 d-flex justify-content-around align-items-center pr-0 link-button-full-wrap">
                                        <div class="links-delete-wrap">
                                            <button type=" button" class="formCustomBtn link-delete-btn link-option-btn removeLinkFields">
                                                <span class="icon-trash link-icon-delete d-flex grey"></span>
                                            </button>
                                        </div>
                                        <div class="links-up-down d-flex linkActionButtons">
                                            <div class="d-flex w-100 links-up-down-wrap justify-content-center align-items-center">
                                                <button type="button" class="link-order-up link-option-btn jss1426 jss1424">
                                                    <span class="icon-arrow-h-right link-icon-up grey"></span>
                                                </button>
                                                <button type="button" class="link-order-down link-option-btn jss1426 jss1424">
                                                    <span class="icon-arrow-h-right link-icon-down grey"></span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="collapse show" id="acc_prodactname">
                                    <div class="collapseInner p-0">

                                        <div class="welcome-screen mb-4 pl-2">
                                            <span class="bar-code-text d-flex">
                                                <?= l('qr_step_2_links.image') ?>
                                                <span
                                                    class="info-tooltip-icon ctp-tooltip"
                                                    tp-content="<?= l('qr_step_2_links.help_tooltip.image') ?>"
                                                ></span>
                                            </span>
                                            <div class="screen-upload">
                                                <label for="linkImages">
                                                    <input type="hidden" name="linkImg[]" value="">
                                                    <input type="file" id="linkImages1" name="linkImages[]" data-anchor="list_text_1" class="anchorLoc form-control py-2 linkImages" value="" accept="image/png, image/gif, image/jpeg, image/svg+xml, image/webp" />
                                                    <div class="input-image">
                                                        <span class="icon-upload-image defaultImage mb-0" style="display:flex"></span>
                                                    </div>
                                                    <div class="add-icon addLImage" style="display: flex; opacity:0;" onclick="triggerLinkImage(1)">
                                                        <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                                            <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"></path>
                                                        </svg>
                                                    </div>
                                                    <div class="add-icon editLImage" style="display: none; opacity:0;" onchange="triggerLinkImage(1)">
                                                        <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 24px;margin: 7px;">
                                                            <path d="M20.71,6.29l-3-3a1,1,0,0,0-1.42,0l-12,12a1,1,0,0,0-.26.47l-1,4a1,1,0,0,0,.26.95A1,1,0,0,0,4,21a1,1,0,0,0,.24,0l4-1a1,1,0,0,0,.47-.26l12-12A1,1,0,0,0,20.71,6.29ZM7.49,18.1l-2.12.53.53-2.12,8.6-8.6L16.09,9.5Zm10-10L15.91,6.5,17,5.41,18.59,7Z"></path>
                                                        </svg>
                                                    </div>
                                                </label>
                                                <button type="button" class="delete-btn l_delete" style="display:none;">
                                                    <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 24px;">
                                                        <path d="M20,7H4A1,1,0,0,0,4,9H5.08l.77,9.25a3,3,0,0,0,3,2.75h6.32a3,3,0,0,0,3-2.75L18.92,9H20a1,1,0,0,0,0-2ZM16.16,18.08a1,1,0,0,1-1,.92H8.84a1,1,0,0,1-1-.92L7.09,9h9.82Z"></path>
                                                        <path d="M9,5h6a1,1,0,0,0,0-2H9A1,1,0,0,0,9,5Z"></path>
                                                    </svg>
                                                    <?= l('qr_step_2_links.delete') ?>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="form-group step-form-group mb-3">
                                            <label for="list_text"><?= l('qr_step_2_links.text') ?>  <span class="text-danger text-bold"></span></label>
                                            <input id="list_text" placeholder="<?= l('qr_step_2_links.input.list_text.placeholder') ?>" name="list_text[]" data-anchor="list_text_1"  class="anchorLoc step-form-control" value=""  data-reload-qr-code  />
                                        </div>
                                        <div class="form-group m-0 step-form-group">
                                            <label for="list_URL"><?= l('qr_step_2_links.url') ?> <span class="text-danger text-bold"></span></label>
                                            <input type="url" id="list_URL" placeholder="<?= l('qr_step_2_links.input.list_URL.placeholder') ?>" name="list_URL[]" data-anchor="list_text_1"  class="anchorLoc step-form-control" value=""  data-reload-qr-code  />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="productAccodianbutton">
                <button id="add1" type="button" class="outlineBtn addRowButton all-add-btn"><span class="icon-add-square start-icon add-btn-icon"></span> <span><?= l('qr_step_2_links.add') ?></span></button>
            </div>
        </div>
    </div>


    <?php include_once('components/social-icons.php'); ?>

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
    var base_url = '<?php echo UPLOADS_FULL_URL; ?>'

    // add link image
    var linkImagesArray = [];

    $(document).on('change', '.linkImages', function() {
        var element = $(this);
        var elementIndex = $('.linkImages').index($(this));

        const [file_product] = $(this).prop('files');
        var linkId = Date.now();

        // if (!file_product) {
        //     let delButn = $(`.l_delete:eq(${elementIndex})`)
        //     delButn.click();
        //     return;
        // }

        if (file_product) {
            $(element).parent().css("border", "1px dashed #28c254");
            $(element).closest('.screen-upload').next('.productsizeErrorMesg').remove();

            if ($(element).closest('.screen-upload').find('.upl-p-img')) {
                $(element).closest('.screen-upload').find('.upl-p-img').remove();
            }
            $(element).closest('.screen-upload').find('.addLImage').hide();
            var elem = document.createElement("img");
            elem.setAttribute("src", URL.createObjectURL(file_product));
            // elem.setAttribute("height", "60");
            // elem.setAttribute("width", "60");
            elem.setAttribute("alt", "Link image");
            elem.setAttribute("class", "upl-p-img");
            $(element).closest('.screen-upload').find('.defaultImage').hide();
            $(element).closest('.screen-upload').find('.input-image').append(elem);

            if (linkImagesArray[elementIndex]) {
                // Deleting from Server 
                deleteCurrentLinks(linkImagesArray[elementIndex]);
            }

            // Note that to count exact value like operating system use 1000 instead of 1024 below functions 
            sizeinMB = file_product.size / Math.pow(1024, 2);
            if (sizeinMB > 10) {
                $(element).val(null);
                element.parent().css({
                    "border": "2px solid red"
                });
                $(element).parent().parent().after("<span class='productsizeErrorMesg' style='color:red;margin-top:15px;'><?= l('qr_step_2_links.max_allowed_10mb') ?> </span>");
            } else {
                $(".preview-qr-btn").attr("disabled", true);
                $("#temp_next").attr("disabled", true);
                $(element).parent().append('<div id="welcome-screens-loader" class="spinner-border text-secondary welcome-screens-loader" role="status"><span class="sr-only"><?= l('qr_step_2.loading') ?></span></div>');

                $(`.upl-p-img:eq(${elementIndex})`).css({
                    'filter': 'blur(1px)',
                });
                let form = document.querySelector('form#myform');
                let form_data = new FormData(form);
                newFormData = filterOnlyCurrentFile(form_data, file_product, linkId);
                // newFormData = onlyFileTypes(form_data, "companyLogo");
                $.ajax({
                    type: 'POST',
                    method: 'post',
                    url: qrFormPostUrl,
                    data: newFormData,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $(".preview-qr-btn").attr("disabled", false);
                        $("#temp_next").attr("disabled", false);
                        $(element).parent().find(".welcome-screens-loader").remove();
                        $(`.upl-p-img:eq(${elementIndex})`).css({
                            'filter': 'none',
                        });

                        $(element).closest('.screen-upload').find('.editLImage').show();
                        $(element).closest('.screen-upload').find('.l_delete').show();

                        LoadPreview(true, false);
                        document.querySelector('#qr_code').src = response.details.data;
                        document.querySelector('#download_svg').href = response.details.data;
                        if (document.querySelector('input[name="qr_code"]')) {
                            document.querySelector('input[name="qr_code"]').value = response.details.data;
                        }

                        // We are here doing this step to store the path of the current Welcome Screens and then delete it from the server if required 
                        let uId = document.getElementById('uId').value;
                        var filesscreens = file_product;
                        var linksImageUnqId = $("#uploadUniqueId").val();
                        var fileExtension = filesscreens.name.substr(filesscreens.name.lastIndexOf('.') + 1);
                        var types = document.querySelector('input[name="type"]').value;
                        linkImagesArray[elementIndex] = filesscreens ? "links/" + uId + "_linkImages_" + linkId + '.' + fileExtension + "" : "";

                        $(element).closest('.screen-upload').find("input[name='linkImg[]']").val(base_url + linkImagesArray[elementIndex]);
                        LoadPreview();
                    },
                    error: function(response) {
                        $(".preview-qr-btn").attr("disabled", false);
                        $("#temp_next").attr("disabled", false);
                    }
                });
            }
        }

    })


    const filterOnlyCurrentFile = (formData, files, linkId) => {
        // Loop through all fields in the FormData object
        var formData = formData;
        for (let pair of formData.entries()) {
            const fieldName = pair[0];
            const fieldValue = pair[1];

            // Check if the field is a file input and not named "screens"
            if (fieldValue instanceof File && fieldName !== "qr_code_logo") {
                // Remove the file input if it is not named "screens"
                formData.delete(fieldName);
            }
        }
        formData.append('linkImagess', files);
        formData.append('linkId', linkId);
        return formData;
    }

    const deleteCurrentLinks = (files) => {
        if (checkIfValueExistsMoreThanOnce(linkImagesArray, files)) {
            return;
        }
        formData = new FormData();
        formData.append('action', 'deleteFiles');
        formData.append('fileLinks', files);

        $.ajax({
            type: 'POST',
            method: 'post',
            url: 'api/ajax',
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
        });
    };

    $(document).on("click", ".removeLinkFields", function(e) {
        var ele = $(this);
        let index = $('.removeLinkFields').index(ele);
        deleteCurrentLinks(linkImagesArray[index]);
        linkImagesArray[index] = undefined;
        // remove_me_up(ele);
        $(this).parents('.link-container').remove();
        console.log();
        LoadPreview();
    });

    function checkIfValueExistsMoreThanOnce(arr, value) {
        let count = 0;
        for (let i = 0; i < arr.length; i++) {
            if (arr[i] === value) {
                count++;
            }
            if (count > 1) {
                return true;
            }
        }
        return false;
    }

    function triggerLinkImage(id) {

        $('#linkImages' + id).trigger('click');
        LoadPreview(true);
    }

    //remove product image

    $(document).on('click', '.l_delete', function() {

        $(this).closest('.screen-upload').find('input').val('');
        $(this).closest('.screen-upload').find('.addLImage').show();
        $(this).closest('.screen-upload').find('.editLImage').hide();
        $(this).closest('.screen-upload').find('.l_delete').hide();
        $(this).closest('.screen-upload').find('.defaultImage').show()

        $(this).closest('.screen-upload').find('.upl-p-img').remove();

        $(this).closest('.screen-upload').find("label[for='linkImages']").css("border", "1px dashed #28c254");
        $(this).closest('.screen-upload').next('.productsizeErrorMesg').remove();

        LoadPreview(true);
        // Deleting from Servers 
        let elementIndex = $('.l_delete').index($(this));
        deleteCurrentLinks(linkImagesArray[elementIndex]);
        linkImagesArray[elementIndex] = undefined;
    });
</script>

<script>
    $(document).on('change keyup', '#socialUrlInput', function() {
        LoadPreview();
        $(this).toggleClass('social-error');
        $(this).parents('.form-group').find(".error-label").hide();
        $(this).css("border", "2px solid #EAEAEC");
    });


    // window.addEventListener('load', (event) => {
    //     LoadPreview();

    //     <?php if ($qrUid) { ?>
    //         reload_qr_code_event_listener();
    //         $('#qr-code-wrap').addClass('active');
    //     <?php } ?>
    // });

    $(window).on("load", function() {
        LoadPreview();

        <?php if ($qrUid) { ?>
            reload_qr_code_event_listener();
            $('#qr-code-wrap').addClass('active');
            $("#2").attr('disabled', false)
            $("#2").removeClass("disable-btn")
        <?php } ?>
    });
</script>

<script>
    $(document).on('change keyup', '#socialUrlInput', function() {
        LoadPreview();
        $(this).toggleClass('social-error');
        $(this).parents('.form-group').find(".error-label").hide();
        $(this).css("border", "2px solid #EAEAEC");
    });

    var currentPos;
    $(document).on("input", '.anchorLoc', function(e) {
                //Prepare Anchors
        document.querySelectorAll("#add_product").forEach((elm,i)=>{
            elm.querySelectorAll('.anchorLoc').forEach((f,p)=>{
                f.setAttribute('data-anchor',`list_text_${i+1}`)
            })
        })
        $('.filters_title_by').each((i,e)=>{
            if(e.name === 'font_title'){
                e.classList.add('anchorLoc');
                e.setAttribute('data-anchor','list_title')
            }
        })
        if (($('input[name=qrtype_input]').length > 0 && $('input[name=qrtype_input]').val() == "url") || ($('input[name=qrtype_input]').length > 0 && $('input[name=qrtype_input]').val() == "wifi")) {
        } else {
            currentPos = e.target.getAttribute('data-anchor');  
                //   currentPos = $(this).data('anchor');    
        }
    });
    // document.getElementById('iframesrc').src = '<?=LANDING_PAGE_URL?>preview/links';

    function LoadPreview(welcome_screen = false, showLoader = true,anchor=null) {

        if (showLoader) {
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
        let linkColor = document.getElementById('linkColor').value;
        let linkTextColor = document.getElementById('SecondaryColor').value;
        let list_title = document.getElementById('list_title').value.replace(/&/g, '%26');
        let list_description = document.getElementById('list_description').value.replace(/&/g, '%26');
        let font_title = document.getElementById('filters_title_by').value;
        let font_text = document.getElementById('filters_text_by').value;
        let companyLogoUrl = document.getElementById('companyLogoImage').value;

        let webValue = "";

        // Link List
        let links = $("input[name='list_text[]']").map((i,elm)=>{
            return {
                name : elm.value,
                link : $("input[name='list_URL[]']")[i].value,
                image : $("input[name='linkImg[]']")[i].value
            }
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

        var screen = document.getElementById("editscreen").value;

        const PreviewData = {
            live: true,
            list_title: list_title,
            list_description: list_description,
            font_text: font_text,
            font_title: font_title,
            linkTextColor: linkTextColor,
            linkColor: linkColor,
            primaryColor: primaryColor,
            companyLogo: companyLogoUrl,
            screen: !welcome_screen ? false : screen,
            change: anchor || currentPos,
            linkList : links,
            socialLinks: socialLinks,
            type:'links',
            static:false,
            step:2
        }

        if (
            list_title == '' && 
            companyLogoUrl == '' && 
            list_description == '' && 
            socialLinks.length === 0 && 
            (links.length === 1 && links[0]?.name === '' ? true : links.length === 0 ? true : false) 
        ) {
            Object.assign(PreviewData.linkList,{
                0:{name:'<?= str_replace("'", "\'", l('qr_step_2_links.lp_def_list_text_1')) ?>',image:'<?=LANDING_PAGE_URL?>images/ListOfLinks/makeup.png',link:''},
                1:{name:'<?= str_replace("'", "\'", l('qr_step_2_links.lp_def_list_text_2')) ?>',image:'<?=LANDING_PAGE_URL?>images/ListOfLinks/instagram.png',link:''},
                2:{name:'<?= str_replace("'", "\'", l('qr_step_2_links.lp_def_list_text_3')) ?>',image:'<?=LANDING_PAGE_URL?>images/ListOfLinks/tiktok.png',link:''},
                3:{name:'<?= str_replace("'", "\'", l('qr_step_2_links.lp_def_list_text_4')) ?>',image:'<?=LANDING_PAGE_URL?>images/ListOfLinks/youtube.png',link:''},
                4:{name:'<?= str_replace("'", "\'", l('qr_step_2_links.lp_def_list_text_5')) ?>',image:'<?=LANDING_PAGE_URL?>images/ListOfLinks/demo.png',link:''},
            });

            PreviewData['companyLogo'] = '<?=LANDING_PAGE_URL?>images/images/new/avatar2.webp';
            PreviewData['list_title'] = '<?= str_replace("'", "\'", l('qr_step_2_links.lp_def_list_title')) ?>'
            PreviewData['list_description'] = '<?= str_replace("'", "\'", l('qr_step_2_links.lp_def_list_description')) ?>';
            
            Object.assign(PreviewData.socialLinks,{
                0:{
                    name:'',
                    text:'<?= str_replace("'", "\'", l('qr_step_2_links.lp_def_social_icon_text')) ?>',
                    icon:'Twitter',
                    url:'<?=LANDING_PAGE_URL?>images/social/twitter.png'
                },
                1:{
                    name:'',
                    text:'<?= str_replace("'", "\'", l('qr_step_2_links.lp_def_social_icon_text')) ?>',
                    icon:'Youtube',
                    url:'<?=LANDING_PAGE_URL?>images/ListOfLinks/youtube.png'
                },
                2:{
                    name:'',
                    text:'<?= str_replace("'", "\'", l('qr_step_2_links.lp_def_social_icon_text')) ?>',
                    icon:'TikTok',
                    url:'<?=LANDING_PAGE_URL?>images/ListOfLinks/tiktok.png'
                }
            });
        }

        document.getElementById('iframesrc').contentWindow.postMessage(PreviewData,'<?=LANDING_PAGE_URL?>');

        // var frame = $('#iframesrc')[0];
        // var frame2 = $('#iframesrc2')[0];
        // link = link.replace(/#/g, '%23'); //convert # symbol 
        // frame.contentWindow.location.replace(link);
        // if (document.getElementById('iframesrc2')) {
            // frame2.contentWindow.location.replace(link);
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

    $(document).ready(function() {
        $('input[type="file"]').change(function() {
            if (this.id === "screen" || this.id === "companyLogo") {
                return; // exclude elements with id "screen" or "company"
            }
            LoadPreview(false);
        });
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
            var rows = $("#add_product", this.container);

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
            if (parseInt(groupIndex) + 1 != 1) {
                $(group).find('div > div > div.d-flex.justify-content-between.mb-3 > div > button:first-child').addClass('dis-flex');
                $(group).find('div > div > div > .screen-upload > label > #linkImages1').attr('id', 'linkImages' + (parseInt(groupIndex) + 1).toString());

                $(group).find('div > div > div > .screen-upload > label > .addLImage').show()
                $(group).find('div > div > div > .screen-upload > label > .editLImage').hide()
                $(group).find('div > div > div > .screen-upload > .l_delete').hide()
                $(group).find('div > div > div > .screen-upload > label > .input-image >.defaultImage').show()
                $(group).find('div > div > div > .screen-upload > label > .input-image >.upl-p-img').remove()
                $(group).find("div > div > div > .screen-upload > label[for='linkImages']").css("border", "1px dashed #28c254");
                $(group).find('div > div > div > .screen-upload > label > .addLImage').attr('onclick', 'triggerLinkImage(' + (parseInt(groupIndex) + 1).toString() + ')');
                $(group).find('div > div > div > .screen-upload > label > .editLImage').attr('onclick', 'triggerLinkImage(' + (parseInt(groupIndex) + 1).toString() + ')');
            }
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
            $(".link-preview").append(newGroup);
            this.lastGroup = newGroup;

            tooltipUpdate();
            LoadPreview();
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
        $(".link-preview").on("click", ".link-order-up", function() {
            var mainNodes = $(this).parents('.link-preview').children('.link-container');
            var mainNodeslength = mainNodes.length;
            var mainNodesindex = mainNodes.index;
            if (mainNodeslength > 1) {
                var currentNode = $(this).parents('.link-container');
                var previousNode = $(this).parents('.link-container').prev();
                currentNode.insertBefore(previousNode);
                previousNode.insertAfter(currentNode);
            }

            if (!($(this).parents('.link-container').next())) {
                console.log("main nodes index : " + mainNodeslength);
            }
            LoadPreview();
        });
        $(".link-preview").on("click", ".link-order-down", function() {
            var mainNodes = $(this).parents('.link-preview').children('.link-container');
            var mainNodeslength = mainNodes.length;
            var mainNodesindex = mainNodes.index;
            if ((mainNodeslength > 1) && (mainNodes.is(':not(:first-child)'))) {
                $(this).parents('.link-container').insertAfter($(this).parents('.link-container').next());
            }
            LoadPreview();
        });
    });
</script>