<?php defined('ALTUMCODE') || die() ?>
<?php
$contactCheckbox = false;
$decodedData = json_decode(isset($data->qr_code[0]['data']) ? $data->qr_code[0]['data'] : null, true);
$qrType = isset($decodedData['type']) ? $decodedData['type'] : null;
if (isset($data->qr_code[0]['data']) && $qrType == 'vcard') {
    $filledInput = json_decode($data->qr_code[0]['data'], true);
    if (isset($filledInput['vcard_add_contact_at_top'])) {
        if ($filledInput['vcard_add_contact_at_top'] == 'on') {
            $contactCheckbox = true;
        }
    }

    $qrName =  $data->qr_code[0]['name'];
    $qrUid =  $data->qr_code[0]['uId'];
    $previewLink = parse_url($filledInput['preview_link2'], PHP_URL_QUERY); // Get query string
    parse_str($previewLink, $params); // Convert query string to array

    $companyLogo = $filledInput['companyLogoImage'];
} else {
    $filledInput = array();
    $qrName = null;
    $qrUid  = null;
    $companyLogo =  null;
}


?>
<div id="step2_form">
    <!-- <input type="hidden" id="uId" name="uId" class="form-control" value="<?php echo (!empty($filledInput)) ? $qrUid : uniqid();  ?>" data-reload-qr-code /> -->
    <input type="hidden" id="preview_link" name="preview_link" class="form-control" value="<?php echo (!empty($filledInput)) ? $filledInput['preview_link'] : ''; ?>" data-reload-qr-code />
    <input type="hidden" id="preview_link2" name="preview_link2" class="form-control" value="<?php echo (!empty($filledInput)) ? $filledInput['preview_link2'] : ''; ?>" data-reload-qr-code />
    <input type="hidden" name="uploadUniqueId" id="uploadUniqueId" value="">
    <!-- add color palette -->
    <?php include_once('components/design-2-color.php'); ?>

    <div class="custom-accodian vcard-info-main-wrp info-block-main-wrp">
        <button class="btn accodianBtn" type="button" data-toggle="collapse" data-target="#acc_vCardInfo" aria-expanded="true" aria-controls="acc_vCardInfo">
             <div class="qr-step-icon">
                <span class="icon-infoCard grey steps-icon"></span>
            </div>

            <span class="custom-accodian-heading">
                <span><?= l('qr_step_2_vcard.information') ?></span>
                <span class="fields-helper-heading"><?= l('qr_step_2_vcard.help_txt.information') ?></span>
            </span>

            <div class="toggle-icon-wrap ml-2">
                <span class="icon-arrow-h-right grey toggle-icon"></span>
            </div>
        </button>
        <div class="collapse show" id="acc_vCardInfo">
            <hr class="accordian-hr">
            <div class="collapseInner">
                <p class="paraheading d-none mb-4"><?= l('qr_step_2_vcard.about') ?></p>

                <div class="welcome-screen mb-4 px-2">
                    <span style="display:flex;">
                        <?= l('qr_step_2_vcard.input.companyLogo') ?>
                        <span 
                            class="info-tooltip-icon ctp-tooltip"
                            tp-content="<?= l('qr_step_2_vcard.help_tooltip.companyLogo') ?>"
                        ></span>
                    </span>
                    <div class="screen-upload">
                        <label for="companyLogo">

                            <input type="hidden" id="companyLogoImage" name="companyLogoImage" value="<?php echo $companyLogo ? $companyLogo : ''; ?>">

                            <input type="file" id="companyLogo" name="companyLogo" data-anchor="vcardName" class="anchorLoc form-control py-2" accept="image/png, image/gif, image/jpeg, image/svg+xml, image/webp" input_size_validate required />
                            <div class="input-image d-flex align-item-center justify-content-center" id="company_logo_img">

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
                            <?= l('qr_step_2_vcard.delete') ?>
                        </button>
                    </div>
                </div>

                <div class="step-form-group">
                    <div class="row">
                        <div class="col-md-6 col-sm-12 vcard-surname-wrap">
                            <div class="form-group mb-0 input-with-icon" data-type="vcard">
                                <label for="vcard_first_name"><?= l('qr_step_2_vcard.input.name') ?> <span class="text-danger text-bold">*</span></label>
                                <span class="icon-profile input-icon"></span>
                                <input type="text" id="vcard_first_name" name="vcard_first_name" placeholder="<?= l('qr_step_2_vcard.input.vcard_first_name.placeholder') ?>" data-anchor="vcardName" class="anchorLoc form-control" value="<?php echo (!empty($filledInput)) ? $filledInput['vcard_first_name'] : ''; ?>" data-reload-qr-code input_validate />
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 vcard-surname-wrap">
                            <div class="form-group mb-0 input-with-icon" data-type="vcard">
                                <label for="vcard_last_name"><?= l('qr_step_2_vcard.surname') ?></label>
                                <span class="icon-profile input-icon"></span>
                                <input type="text" id="vcard_last_name" name="vcard_last_name" placeholder="<?= l('qr_step_2_vcard.input.vcard_last_name.placeholder') ?>" data-anchor="vcardName" class="anchorLoc form-control" value="<?php echo (!empty($filledInput)) ? $filledInput['vcard_last_name'] : ''; ?>" data-reload-qr-code />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- <p class="paraheading mb-4 pt-4"><?= l('qr_step_2_vcard.contact') ?></p> -->
            </div>
        </div>
    </div>

    <!-- Contact Details -->
    <div class="custom-accodian vcard-info-main-wrp info-block-main-wrp">
        <button class="btn accodianBtn" type="button" data-toggle="collapse" data-target="#acc_contactInfo" aria-expanded="true" aria-controls="acc_contactInfo">
            <div class="qr-step-icon">
                <span class="icon-info grey steps-icon"></span>
            </div>
            <span class="custom-accodian-heading">
                <span><?= l('qr_step_2_vcard.contact_details') ?></span>
                <span class="fields-helper-heading"><?= l('qr_step_2_vcard.help_txt.contact_details') ?></span>
            </span>
            <div class="toggle-icon-wrap ml-2">
                <span class="icon-arrow-h-right grey toggle-icon"></span>
            </div>
        </button>
        <div class="collapse show" id="acc_contactInfo">
            <hr class="accordian-hr">
            <div class="collapseInner">
                <div class="custom-accodian sub-accordion disabled-accord">
                    <button data-anchor="vcardPhone" class="anchorLocBtn btn accodianBtn vcard-add-phone" type="button" data-toggle="collapse-dis" data-target="#add_phone-dis" aria-expanded="true-dis" aria-controls="add_phone-dis">

                        <span class="custom-accodian-heading"><?= l('qr_step_2_vcard.input.addPhone') ?></span>
                    </button>
                    <!-- <div class="custom-add-button"> -->
                    <button id="addPhone" type="button" class="outlineBtn addRowButton vcard-add-btn vcard-add-phone"><span class="icon-add"></span></button>
                    <!-- </div> -->
                    <div class="collapse <?php echo isset($filledInput['vcard_phoneLabel']) == 1 ? 'show' : '' ?>" id="add_phone">
                        <div class="collapseInner mt-2">
                            <div id="phoneBlock" class="vcard-info-content-block">
                                <!-- <hr class="accordian-hr"> -->
                                <!--  -->
                                <?php if (isset($filledInput['vcard_phoneLabel']) && is_array($filledInput['vcard_phoneLabel'])) : ?>
                                    <?php foreach ($filledInput['vcard_phoneLabel'] as $key => $val) {
                                        $phoneNumber = $key + 2; ?>
                                        <div class="d-flex align-items-end mb-3 vcard-contact-info removable-block-wrp">
                                            <div class="d-flex  w-100 flex-column">
                                                <div class="d-flex align-items-end w-100 form-fileds-wrp">
                                                    <div class="w-75 label-input-wrp input-with-icon">
                                                        <label for="filters_address_by" class="fieldLabel"><?= l('qr_step_2_vcard.phone_label') ?> </label>
                                                        <span class="icon-qr-label input-icon"></span>
                                                        <input type="text" data-anchor="vcardPhone" class="anchorLoc form-control mr-2" id="vcard_phoneLabel" name="vcard_phoneLabel[]" value="<?php echo $val ?>" placeholder="<?= l('qr_step_2_vcard.input.vcard_phoneLabel.placeholder') ?>" data-reload-qr-code />
                                                    </div>
                                                    <div class="w-100 data-input-wrp input-with-icon-drop">
                                                        <div class="icon-text-wrap">
                                                            <span class="icon-dropdown-text"><?= l('qr_step_2_vcard.phone_number.dropdown') ?></span><label for="filters_address_by" class="fieldLabel"><?= l('qr_step_2_vcard.phone_number') ?> </label>
                                                        </div>
                                                        <div class="apto-dropdown-wrapper">
                                                            <button class="form-control apto-trigger-dropdown">
                                                                <?php if ($filledInput['vcard_phoneSvg']) { ?>

                                                                    <?php echo  $filledInput['vcard_phoneSvg'][$key]  ?>
                                                                <?php } else { ?>
                                                                    <span class="icon-call drp-icon cell"></span>
                                                                <?php } ?>
                                                            </button>
                                                            <div class="dropdown-menu filters_address_by phone_type<?php echo $phoneNumber ?>" data-selected="<?php echo $filledInput['vcard_phoneIcon'][$key] ?>">

                                                                <input type="hidden" data-anchor="vcardPhone" class="anchorLoc" value='<?php echo $filledInput['vcard_phoneIcon'][$key] ?>' name="vcard_phoneIcon[]">
                                                                <input type="hidden" data-anchor="vcardPhone" class="anchorLoc" value='<?php echo $filledInput['vcard_phoneSvg'][$key] ?>' name="vcard_phoneSvg[]">


                                                                <button type="button" value="mobile-phone" tabindex="0" class="dropdown-item">
                                                                    <span class="icon-mobile drp-icon cell"></span>
                                                                    <span class="break-text"><?= l('qr_step_2_vcard.label_mobile_phone') ?></span>
                                                                </button>
                                                                <button type="button" value="home" tabindex="0" class="dropdown-item">
                                                                    <span class="icon-house drp-icon home"></span>
                                                                    <span class="break-text"><?= l('qr_step_2_vcard.label_home') ?></span>
                                                                </button>
                                                                <button type="button" value="work" tabindex="0" class="dropdown-item">
                                                                    <span class="icon-buildings drp-icon work"></span>
                                                                    <span class="break-text"><?= l('qr_step_2_vcard.label_work') ?></span>
                                                                </button>
                                                                <button type="button" value="fax" tabindex="0" class="dropdown-item">

                                                                    <span class="icon-fax drp-icon fax"></span>
                                                                    <span class="break-text"><?= l('qr_step_2_vcard.label_fax') ?></span>
                                                                </button>
                                                                <button type="button" value="other" tabindex="0" class="dropdown-item">
                                                                    <span class="icon-call drp-icon other"></span>
                                                                    <span class="break-text"><?= l('qr_step_2_vcard.label_other') ?></span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <input type="text" id="vcard_phone" data-anchor="vcardPhone" class="anchorLoc form-control mr-2" name="vcard_phone[]" value="<?php echo $filledInput['vcard_phone'][$key] ?>" placeholder="<?= l('qr_step_2_vcard.input.vcard_phone.placeholder') ?>"  maxlength="<?= $data->qr_code_settings['type']['vcard']['phone']['max_length'] ?>" data-reload-qr-code />
                                                    </div>
                                                    <button class="reapeterCloseIcon delete-btn removable-delete-btn vcard-remove" type="button">
                                                        <span class="icon-trash"></span>
                                                    </button>



                                                </div>
                                            </div>
                                        </div>

                                    <?php } ?>
                                <?php endif ?>
                                <!--  -->

                            </div>

                        </div>
                    </div>
                </div>

                <div class="custom-accodian sub-accordion disabled-accord">
                    <button data-anchor="vcardEmail" class="anchorLocBtn btn accodianBtn vcard-add-email" type="button" data-toggle="collapse-dis" data-target="#add_email-dis" aria-expanded="true-dis" aria-controls="add_email-dis">
                        <span class="custom-accodian-heading"><?= l('qr_step_2_vcard.input.addEmail') ?></span>
                    </button>
                    <!-- <div class="custom-add-button"> -->
                    <button id="addEmail" type="button" class="outlineBtn addRowButton vcard-add-btn vcard-add-email"><span class="icon-add"></span></button>
                    <!-- </div> -->

                    <div class="collapse <?php echo isset($filledInput['vcard_emailLabel']) == 1 ? 'show' : '' ?>" id="add_email">
                        <div class="collapseInner mt-2">
                            <div id="emailBlock" class="vcard-info-content-block">
                                <!-- <hr class="accordian-hr"> -->
                                <!--  -->
                                <?php if (isset($filledInput['vcard_emailLabel']) && is_array($filledInput['vcard_emailLabel'])) : ?>
                                    <?php foreach ($filledInput['vcard_emailLabel'] as $key => $val) { ?>
                                        <div class="d-flex align-items-end mb-4 vcard-contact-info removable-block-wrp">
                                            <div class="d-flex  w-100 flex-column">
                                                <div class="d-flex align-items-end w-100 form-fileds-wrp">


                                                    <div class="w-75 label-input-wrp input-with-icon">
                                                        <span class="icon-qr-label input-icon add-label-icon"></span>
                                                        <label for="vcard_email" class="fieldLabel"><?= l('qr_step_2_vcard.email_label') ?></label>
                                                        <input type="text" data-anchor="vcardEmail" class="anchorLoc form-control mr-2" id="vcard_emailLabel" value="<?php echo $val; ?>" placeholder="<?= l('qr_step_2_vcard.input.vcard_emailLabel.placeholder') ?>" name="vcard_emailLabel[]" maxlength="320" data-reload-qr-code="">

                                                    </div>
                                                    <div class="w-100 data-input-wrp input-with-icon">
                                                        <span class="icon-email input-icon"></span>
                                                        <label for="vcard_email" class="fieldLabel"><?= l('qr_step_2_vcard.type.email') ?></label>
                                                        <input type="email" data-anchor="vcardEmail" class="anchorLoc form-control mr-2" id="vcard_email" value="<?php echo $filledInput['vcard_email'][$key]; ?>" placeholder="<?= l('qr_step_2_vcard.input.vcard_email.placeholder') ?>" name="vcard_email[]" maxlength="320" data-reload-qr-code="">
                                                    </div>
                                                    <button class="reapeterCloseIcon delete-btn removable-delete-btn vcard-remove">
                                                        <span class="icon-trash"></span>
                                                    </button>


                                                </div>

                                            </div>
                                        </div>
                                    <?php } ?>
                                <?php endif ?>
                                <!--  -->

                            </div>

                        </div>
                    </div>
                </div>
                <div class="custom-accodian sub-accordion disabled-accord">
                    <button  data-anchor="vcardWeb" class="anchorLocBtn btn accodianBtn vcard-add-web" type="button" data-toggle="collapse-dis" data-target="#add_website-dis" aria-expanded="true-dis" aria-controls="add_website-dis">
                        <span class="custom-accodian-heading"><?= l('qr_step_2_vcard.add_web') ?></span>
                    </button>
                    <!-- <div class="custom-add-button"> -->
                    <button id="addWebsite" type="button" class="outlineBtn addRowButton vcard-add-btn vcard-add-web"><span class="icon-add"></span></button>
                    <!-- </div> -->

                    <div class="collapse <?php echo isset($filledInput['vcard_website_title']) == 1 ? 'show' : '' ?>" id="add_website">
                        <div class="collapseInner mt-2">
                            <div id="websiteBlock" class="vcard-info-content-block">
                                <!-- <hr class="accordian-hr"> -->
                                <!--  -->
                                <?php if (isset($filledInput['vcard_website_title']) && is_array($filledInput['vcard_website_title'])) : ?>
                                    <?php foreach ($filledInput['vcard_website_title'] as $key => $val) { ?>
                                        <div class="d-flex align-items-end mb-3 vcard-contact-info removable-block-wrp">
                                            <div class="d-flex  w-100 flex-column">
                                                <div class="d-flex align-items-end w-100 form-fileds-wrp">

                                                    <div class="w-75 label-input-wrp input-with-icon">
                                                        <label for="vcard_url" class="fieldLabel"><?= l('qr_step_2_vcard.web_label') ?></label>
                                                        <span class="icon-qr-label input-icon add-label-icon"></span>
                                                        <input type="text" data-anchor="vcardWeb" class="anchorLoc form-control mr-2" id="vcard_website_title" value="<?php echo $val; ?>" placeholder="<?= l('qr_step_2_vcard.input.vcard_website_title.placeholder') ?>" name="vcard_website_title[]" maxlength="320" data-reload-qr-code="">
                                                    </div>

                                                    <div class="w-100 data-input-wrp input-with-icon">
                                                        <label for="vcard_url" class="fieldLabel"><?= l('qr_step_2_vcard.personal_web') ?></label>
                                                        <span class="icon-global input-icon"></span>
                                                        <input type="url" data-anchor="vcardWeb" class="anchorLoc form-control mr-2" id="vcard_website" value="<?php echo $filledInput['vcard_website'][$key]; ?>" placeholder="<?= l('qr_step_2_vcard.input.vcard_website.placeholder') ?>" name="vcard_website[]" maxlength="320" data-reload-qr-code="">
                                                    </div>

                                                    <button class="reapeterCloseIcon delete-btn removable-delete-btn vcard-remove" type="button">
                                                        <span class="icon-trash"></span>
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                    <?php } ?>
                                <?php endif ?>
                                <!--  -->
                            </div>

                        </div>
                    </div>
                </div>
                <div class="checkbox-wrapper custom-check-field-wrp">
                    <div class="roundCheckbox mx-2">
                        <input type="checkbox" data-anchor="vcardContact" class="anchorLoc"  name="vcard_add_contact_at_top" onchange="LoadPreview()" id="checkbox1" <?php if ($contactCheckbox) echo "checked"; ?> />
                        <label class="m-0" for="checkbox1"></label>
                    </div>
                    <label class="m-0">
                        <?= l('qr_step_2_vcard.add_contact') ?>
                        <span 
                            style="line-height:1.25;"
                            class="info-tooltip-icon ctp-tooltip"
                            tp-content="<?= l('qr_step_2_vcard.help_tooltip.add_contact') ?>"
                        ></span>
                    </label>
                </div>
            </div>
        </div>
    </div>

    <!-- Location -->
    <div class="custom-accodian vcard-info-main-wrp info-block-main-wrp">
        <button class="btn accodianBtn" type="button" data-toggle="collapse" data-target="#acc_location" aria-expanded="true" aria-controls="acc_location">
            <div class="qr-step-icon">
                <span class="icon-location grey steps-icon"></span>
            </div>

            <span class="custom-accodian-heading">
                <span><?= l('qr_step_2_vcard.type.location') ?></span>
                <span class="fields-helper-heading"><?= l('qr_step_2_vcard.help_txt.location') ?></span>
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

    <!-- Company Details -->
    <div class="custom-accodian vcard-info-main-wrp info-block-main-wrp">
        <button class="btn accodianBtn" type="button" data-toggle="collapse" data-target="#acc_companyInfo" aria-expanded="true" aria-controls="acc_companyInfo">
            <div class="qr-step-icon">
                <span class="icon-buildings grey steps-icon"></span>
            </div>
            <span class="custom-accodian-heading  d-flex flex-column">
                <?= l('qr_step_2_vcard.company') ?>
                <span class="fields-helper-heading"><?= l('qr_step_2_vcard.help_txt.company') ?></span>
            </span>
            <div class="toggle-icon-wrap ml-2">
                <span class="icon-arrow-h-right grey toggle-icon"></span>
            </div>
        </button>
        <div class="collapse show" id="acc_companyInfo">
            <hr class="accordian-hr">
            <div class="collapseInner">
                <div class="px-1 px-sm-3">
                    <!-- <p class="paraheading pt-2 mb-4"><?= l('qr_step_2_vcard.company') ?></p> -->
                    <div class="step-form-group">
                        <div class="row">
                            <div class="form-group pr-2 col-6" data-type="vcard">
                                <label for="vcard_company" class="filed-label"><?= l('qr_step_2_vcard.input.vcard_company') ?></label>
                                <input type="text" id="vcard_company" name="vcard_company" placeholder="<?= l('qr_step_2_vcard.input.vcard_company.placeholder') ?>" data-anchor="vcardCompany" class="anchorLoc form-control" value="<?php echo isset($filledInput['vcard_company']) ? $filledInput['vcard_company'] : ''; ?>" data-reload-qr-code />
                            </div>
                            <div class="form-group pl-2 col-6" data-type="vcard">
                                <label for="vcard_profession" class="filed-label"><?= l('qr_step_2_vcard.profession') ?></label>
                                <input type="text" id="vcard_profession" name="vcard_profession" placeholder="<?= l('qr_step_2_vcard.input.vcard_profession.placeholder') ?>" data-anchor="vcardCompany" class="anchorLoc form-control" value="<?php echo isset($filledInput['vcard_profession']) ? $filledInput['vcard_profession'] : ''; ?>" data-reload-qr-code />
                            </div>
                        </div>

                    </div>
                </div>

                <div class="form-group mb-0 px-1 px-sm-3" data-type="vcard">
                    <p class="paraheading pt-4 mb-2"><?= l('qr_step_2_vcard.summary') ?></p>
                    <div class="step-form-group pt-2 pb-2">
                        <textarea id="vcard_note" name="vcard_note" placeholder="<?= l('qr_step_2_vcard.input.vcard_note.placeholder') ?>" rows="6" data-anchor="vcardNotes" class="anchorLoc form-control textarea-control pt-2" data-reload-qr-code><?php echo isset($filledInput['vcard_note']) ? $filledInput['vcard_note'] : ''; ?></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- add  none-->
    <?php include_once('components/social-icons.php'); ?>

    <div class="custom-accodian" style="display:none;">
        <button class="btn accodianBtn" type="button" data-toggle="collapse" data-target="#vcard_socials_container" aria-expanded="true" aria-controls="vcard_socials_container" data-type="vcard">
            <?= l('qr_step_2_vcard.input.vcard_socials') ?>
            <svg class="MuiSvgIcon-root MuiSvgIcon-colorPrimary leftArrow" focusable="false" viewBox="0 0 16 16" aria-hidden="true" style="font-size: 16px;">
                <path d="M12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5ZM12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5Z"></path>
            </svg>
        </button>
        <div class="collapse show" id="vcard_socials_container">
            <div class="collapseInner">
                <div id="vcard_socials">
                    <?php if (is_array(isset($filledInput['vcard_social_label']))) { ?>
                        <?php foreach ($filledInput['vcard_social_label'] as $key => $val) { ?>
                            <div class="mb-4">
                                <div class="form-group">
                                    <label for=""><?= l('qr_step_2_vcard.label') ?></label>
                                    <input id="" type="text" name="vcard_social_label[<?= $key ?>]" value="<?php echo $val; ?>" class="form-control" required="required" data-reload-qr-code="">
                                </div>
                                <div class="form-group mb-2">
                                    <label for=""><?= l('qr_step_2_vcard.url') ?></label>
                                    <input id="" type="url" name="vcard_social_value[<?= $key ?>]" value="<?php echo $filledInput['vcard_social_value'][$key]; ?>" class="form-control" maxlength="1024" required="required" data-reload-qr-code="">
                                </div>
                                <button type="button" data-remove="vcard_social" class="mt-2 outlineBtn manualyBtn closeBtn" style="border: 2px solid #f91d1d !important;color: red !important;margin-left: 0px;"><svg class="svg-inline--fa fa-times fa-w-11 fa-fw" aria-hidden="true" focusable="false" data-prefix="fa" data-icon="times" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 352 512" data-fa-i2svg="">
                                        <path fill="currentColor" d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z"></path>
                                    </svg><?= l('qr_step_2_vcard.delete') ?></button>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
                <div>
                    <button data-add="vcard_social" type="button" class="outlineBtn addRowButton"><i class="fa fa-fw fa-plus-circle smIcon"></i><?= l('qr_step_2_vcard.button.add_social') ?></button>
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

    <template id="template_vcard_social">
        <div class="mb-4">
            <div class="form-group">
                <label for="">Label</label>
                <input id="" type="text" name="vcard_social_label[]" class="form-control" required="required" data-reload-qr-code />
            </div>

            <div class="form-group mb-2">
                <label for="">URL</label>
                <input id="" type="url" name="vcard_social_value[]" class="form-control" maxlength="<?= $data->qr_code_settings['type']['vcard']['social_value']['max_length'] ?>" required="required" data-reload-qr-code />
            </div>

            <button type="button" data-remove="vcard_social" class="mt-2 outlineBtn manualyBtn closeBtn" style="border: 2px solid #f91d1d !important;color: red !important;margin-left: 0px;"><i class="fa fa-fw fa-times"> </i><?= l('qr_step_2_vcard.delete') ?></button>

        </div>
    </template>
    <!-- <?php include_once('accodian-form-group/tracking-analytics.php'); ?> -->
    <input type="hidden" id="imgencode" value="">
</div>



<script>
    $(document).ready(function() {
        var checkphones = $('#phoneBlock').children('.vcard-contact-info').length;
        var checkemails = $('#emailBlock').children('.vcard-contact-info').length;
        var checkwebs = $('#websiteBlock').children('.vcard-contact-info').length;
        if (checkphones > 1) {
            $("#add_phone").addClass('show');
        }
        if (checkemails > 1) {
            $("#add_email").addClass('show');
        }
        if (checkwebs > 1) {
            $("#add_website").addClass('show');
        }
    });

    $(document).on('click', '.vcard-add-btn', function() {
        var checkCollapse = $(this).next('.collapse ');
        var checkchildren = checkCollapse.find('.vcard-info-content-block').children('.vcard-contact-info').length;
        // console.log(checkchildren);
        if ((checkCollapse.hasClass('.show'))) {} else {
            $(this).next('.collapse ').addClass('show');

        }
    });
    $('#phoneBlock').on('click', '.vcard-remove', function() {
        var phoneBlockChild = $('#phoneBlock').children('.vcard-contact-info').length;
        if (phoneBlockChild === 1) {
            $("#add_phone").removeClass('show');
        }
    });
    $('#emailBlock').on('click', '.vcard-remove', function() {
        var emailBlockChild = $('#emailBlock').children('.vcard-contact-info').length;
        if (emailBlockChild === 1) {
            $("#add_email").removeClass('show');
        }
    });

    $('#websiteBlock').on('click', '.vcard-remove', function() {
        var webBlockChild = $('#websiteBlock').children('.vcard-contact-info').length;
        if (webBlockChild === 1) {
            $("#add_website").removeClass('show');

        }
    });

    
    $(document).on('click', '.delete-btn', function() {
        LoadPreview(false);
    });

    var base_url = '<?php echo UPLOADS_FULL_URL; ?>'

    function isUrl(s) {
        var regexp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/
        return regexp.test(s);
    }

    $(document).on('change', '.main-input', function() {
        var _val_url = $(this).val();
        var _data_url = isUrl(_val_url);
        if ($(this).val() != "") {
            if ($(this).parents('.form-group').hasClass("url")) {
                if (_data_url == false) {
                    $(this).parents('.form-group').find(".error-label").text('URL must start with http or https');
                } else {
                    LoadPreview();
                    $(this).toggleClass('social-error');
                    $(this).parents('.form-group').find(".error-label").hide();
                    $(this).css("border", "2px solid #EAEAEC");
                }
            } else {
                LoadPreview();
                $(this).toggleClass('social-error');
                $(this).parents('.form-group').find(".error-label").hide();
                $(this).css("border", "2px solid #EAEAEC");
            }
        } else {
            $(this).parents('.form-group').find(".error-label").show();
        }

    })

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
    $(document).on("click", '.anchorLocBtn', function(e) {
        if (($('input[name=qrtype_input]').length > 0 && $('input[name=qrtype_input]').val() == "url") || ($('input[name=qrtype_input]').length > 0 && $('input[name=qrtype_input]').val() == "wifi")) {
            
        } else {
            currentPos = $(this).data('anchor');                     
        }
    });

    // document.getElementById('iframesrc').src = '<?=LANDING_PAGE_URL?>preview/vcard';

    function LoadPreview(welcome_screen = false, showLoader = true,anchor=null) {


        // if (showLoader)
        //     setFrame();
        var uId = document.getElementById('uId').value;
        if (typeof(uId) != 'undefined') {
            uId = uId;
        }


        if ($("input[name=\"step_input\"]").val() == 2) {
            $("#tabs-1").addClass("active");
            $("#tabs-2").removeClass("active");
            $("#2").removeClass("active");
            $("#1").addClass("active");
        }

        let vcard_first_name = document.getElementById('vcard_first_name').value.replace(/&/g, '%26');
        let vcard_last_name = document.getElementById('vcard_last_name').value.replace(/&/g, '%26');
        let primaryColor = document.getElementById('primaryColor').value;
        let SecondaryColor = document.getElementById('SecondaryColor').value;
        let ship_address = document.getElementById('ship-address1')?.value.replace(/&/g, '%26') || "";
        let offer_street = document.getElementById('route')?.value.replace(/&/g, '%26') || "";
        let offer_number = document.getElementById('street_number')?.value.replace(/&/g, '%26') || "";
        let offer_postalcode = document.getElementById('postal_code')?.value || "";
        let offer_city = document.getElementById('locality')?.value.replace(/&/g, '%26') || "";
        let offer_state = document.getElementById('administrative_area_level_1')?.value.replace(/&/g, '%26') || "";
        let offer_country = document.getElementById('country')?.value.replace(/&/g, '%26') || "";

        var urlValue = document.getElementById('offer_url1')?.value.replace(/&/g, '%26') || "";
        var offer_url1 = set_url(urlValue);

        let latitude = document.getElementById('latitude')?.value || "";
        let longitude = document.getElementById('longitude')?.value || "";
        let vcard_note = document.getElementById('vcard_note').value.replace(/&/g, '%26');
        let vcard_company = document.getElementById('vcard_company').value.replace(/&/g, '%26');
        var companyLogoFile = document.getElementById('companyLogoImage').value;
        var encode_img = "";

        let vcard_phone = $("input[name='vcard_phoneLabel[]']").map((i,e)=>{
            return {
                number:$("input[name='vcard_phone[]']")[i].value,
                label:e.value,
                type:$(`.phone_type${i+2}`).attr('data-selected')
            }
        }).get();

        let vcard_email = $("input[name='vcard_emailLabel[]']").map((i,e)=>{
            return {
                title:e.value,
                email:$("input[name='vcard_email[]']")[i].value
            }
        }).get();

        let vcard_social_label = $("input[name*='vcard_social_label']").map(function() {
            return $(this).val().replace(/&/g, '%26');
        }).get();
        let vcard_social_value = $("input[name*='vcard_social_value']").map(function() {
            return $(this).val();
        }).get();

        let vcard_website = $("input[name='vcard_website_title[]']").map((i,e)=>{
            return {
                title:e.value,
                website:$("input[name='vcard_website[]']")[i].value || "My Website"
            };
        }).get();
        
        let socialLinks = $("input[name='social_icon[]']").map((i,e)=>{
            return {
                name:$("input[name='social_icon_name[]']")[i].value,
                text:$("input[name='social_icon_text[]']")[i].value,
                icon:e.value,
                url:$("input[name='social_icon_url[]']")[i].value
            }
        }).get();

        let vcard_profession = document.getElementById("vcard_profession").value.replace(/&/g, '%26');
        let font_title = document.getElementById('filters_title_by').value;
        let font_text = document.getElementById('filters_text_by').value;
        let street_number = $('#customSwitchToggle').is(":checked");

        var vcard_add_contact_at_top = $("#checkbox1").is(":checked");
        var screen = document.getElementById("editscreen").value;

        if (
            vcard_first_name == '' && 
            vcard_last_name == '' && 
            companyLogoFile == '' && 
            vcard_note == '' && 
            offer_street == '' && 
            ship_address == '' && 
            (latitude == "" || longitude == "") && 
            vcard_email.length == 0 &&
            vcard_phone.length == 0 &&
            vcard_profession == '' && 
            vcard_company == ''
        ) {
            vcard_first_name = '<?= str_replace("'", "\'", l('qr_step_2_vcard.lp_def_vcard_first_name')) ?>';
            vcard_last_name = '<?= str_replace("'", "\'", l('qr_step_2_vcard.lp_def_vcard_last_name')) ?>';
            vcard_profession = '<?= str_replace("'", "\'", l('qr_step_2_vcard.lp_def_vcard_profession')) ?>',
            companyLogoFile = '<?php echo LANDING_PAGE_URL; ?>images/images/new/avatar.webp';
            vcard_phone = [{label:'',type:'other',number:'<?= str_replace("'", "\'", l('qr_step_2_vcard.lp_def_vcard_phone')) ?>'}];
            vcard_email = [{title:'',email:'<?= str_replace("'", "\'", l('qr_step_2_vcard.lp_def_vcard_email')) ?>'}];
            vcard_company = '<?= str_replace("'", "\'", l('qr_step_2_vcard.lp_def_vcard_company')) ?>';
            vcard_note = '<?= str_replace("'", "\'", l('qr_step_2_vcard.lp_def_vcard_note')) ?>';
            vcard_website = [{title:'',website:'My Website'}];
            socialLinks = [
                {
                    name:'',
                    text:'<?= str_replace("'", "\'", l('qr_step_2_vcard.lp_def_social_icon_text')) ?>',
                    icon:'Linkedin',
                    url:'<?php echo LANDING_PAGE_URL; ?>images/social/linkedin.png'
                },
                {
                    name:'',
                    text:'<?= str_replace("'", "\'", l('qr_step_2_vcard.lp_def_social_icon_text')) ?>',
                    icon:'Facebook',
                    url:'<?php echo LANDING_PAGE_URL; ?>images/social/facebook.png'
                },
                {
                    name:'',
                    text:'<?= str_replace("'", "\'", l('qr_step_2_vcard.lp_def_social_icon_text')) ?>',
                    icon:'Google',
                    url:'<?php echo LANDING_PAGE_URL; ?>images/social/google.png'
                },
                {
                    name:'',
                    text:'<?= str_replace("'", "\'", l('qr_step_2_vcard.lp_def_social_icon_text')) ?>',
                    icon:'Instagram',
                    url:'<?php echo LANDING_PAGE_URL; ?>images/social/instagram.png'
                },
            ]
            street_number = true;
            vcard_add_contact_at_top = false;
            offer_url1 = '#';
            offer_country = '<?= str_replace("'", "\'", l('qr_step_2_vcard.lp_def_offer_country')) ?>';
            offer_state = '<?= str_replace("'", "\'", l('qr_step_2_vcard.lp_def_offer_state')) ?>';
            offer_postalcode = '<?= str_replace("'", "\'", l('qr_step_2_vcard.lp_def_offer_postalcode')) ?>';
            offer_street = '<?= str_replace("'", "\'", l('qr_step_2_vcard.lp_def_offer_street')) ?>';
            offer_city = '<?= str_replace("'", "\'", l('qr_step_2_vcard.lp_def_offer_city')) ?>';
            offer_number = '<?= str_replace("'", "\'", l('qr_step_2_vcard.lp_def_offer_number')) ?>';
        };

        const PreviewData = {
            live: true,
            screen: !welcome_screen ? false : screen,
            font_title: font_title,
            font_text: font_text,
            vcard_profession: vcard_profession,
            primaryColor: primaryColor,
            SecondaryColor: SecondaryColor,
            vcard_first_name: vcard_first_name,
            vcard_last_name: vcard_last_name,
            socialLinks: socialLinks,
            vcard_website: vcard_website,
            vcard_phone: vcard_phone,
            vcard_email: vcard_email,
            vcard_note: vcard_note,
            vcard_company: vcard_company,
            vcard_social_label: vcard_social_label,
            vcard_social_value: vcard_social_value,
            images: companyLogoFile,
            offer_street: offer_street,
            offer_number: offer_number,
            offer_postalcode: offer_postalcode,
            offer_city: offer_city,
            offer_state: offer_state,
            offer_country: offer_country,
            offer_url1: offer_url1,
            latitude: latitude,
            longitude: longitude,
            vcard_add_contact_at_top: vcard_add_contact_at_top,
            street_number: street_number,
            change:anchor || currentPos,
            type:'vcard',
            static:false,
            step:2
        }

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
    //prevent page redirect on keypress
    $('input').keypress(function(e) {
        if (event.keyCode == 13) {
            event.preventDefault();
        }
    })
</script>
<script>
    var manualClicked = false;
    var urlClicked = false;
    var coClicked = false;
    var phoneNumber = <?php echo isset($phoneNumber) ? $phoneNumber : 1 ?>;
    var emailNumber = 1;
    var websiteNumber = 1;


    $(document).on('click', '#Complete', function() {
        $('#Complete').addClass('active');
        $('#Url').removeClass('active');
        $('#Coordinates').removeClass('active');
        $('#LocationInputs').show();
        $('#UrlEntry').hide();
        $('#CoEntry').hide();
    });

    $(document).on('change', '#vcard_email', function() {
        $(this).css("border", "");
        $(this).parent().find(".invalid_err").remove();

        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        if (!emailReg.test($.trim(this.value))) {
            $(this).css("border", "2px solid red")
            $("<span class=\"invalid_err\" style=\"position: absolute;\"><?= l('qr_step_2.email_not_valid') ?></span>").insertAfter($(this));
        } else {
            $(this).css("border", "");
            $(this).parent().find(".invalid_err").remove();
        }
    });

    $(document).on('click', '#Url', function() {
        $('#Url').addClass('active');
        $('#Complete').removeClass('active');
        $('#Coordinates').removeClass('active');
        $('#LocationInputs').hide();
        $('#CoEntry').hide();
        $('#UrlEntry').show();
        if (!urlClicked) {

            var contentHtml = `
                        <div class="form-group">
                            <label for="offer_url1">Url</label>
                            <input id="offer_url1"   placeholder="<?= l('qr_step_2_com_location.url.placeholder') ?>" name="offer_url1" class="form-control" value=""  data-reload-qr-code />
                        </div>
                                `;
            $('#UrlEntry').append(contentHtml);
            urlClicked = true;
            //prevent page redirect on keypress
            $('input').keypress(function(e) {
                if (event.keyCode == 13) {
                    event.preventDefault();
                }
            })
        } else {
            $('#UrlEntry').show();
        }

    });
</script>
<script>
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