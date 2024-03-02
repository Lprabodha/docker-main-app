<div class="custom-accodian">
    <button class="btn accodianBtn" type="button" data-toggle="collapse" data-target="#acc_contactInfo" aria-expanded="true" aria-controls="acc_contactInfo">
        <div class="qr-step-icon">
            <span class="icon-contact-info grey steps-icon"></span>
        </div>

        <span class="custom-accodian-heading">
            <span><?= l('qr_step_2_com_contact_info.contact_info') ?></span>
            <span class="fields-helper-heading" id="contact_info_help_text">
                <script>
                    if($("input[name=\"qrtype_input\"]").val() === 'menu'){
                        $('#contact_info_help_text').text('<?= l('qr_step_2_com_contact_info.help_txt.contact_info_restaurant') ?>');
                    } else {
                        $('#contact_info_help_text').text('<?= l('qr_step_2_com_contact_info.help_txt.contact_info_business') ?>');
                    }
                </script>
            </span>
        </span>

        <div class="toggle-icon-wrap ml-2">
            <span class="icon-arrow-h-right grey toggle-icon"></span>
        </div>
    </button>
    <div class="collapse show" id="acc_contactInfo">
        <hr class="accordian-hr">
        <div class="collapseInner">
            <div class="add-on-phone mb-3">
                <div id="web-btn" class="mt- row add-phone-area-wrap">
                    <div class="col-8 add-phone-area-text">
                        <span class="contact-subheading"><?= l('qr_step_2_com_contact_info.add_website') ?></span>
                    </div>
                    <div class="col-4 add-phone-btn-area">
                        <!-- <button id="addWeb" onclick="addWebField()" type="button" class="addweb-btn add-phone-btn-active float-right d-block hide-for-type">
                            <span class="icon-add grey plus-mark d-flex"></span>
                        </button> -->
                    </div>
                    <hr id="" class="contact-hr mb-3" style="display: block;">

                </div>
                <div class="mb-3 addBusinessButton addRow web-block-wrap" id="web-block">
                    <div class="form-group mt-0 mx-0 web-field" style="margin-bottom:25px;">
                        <div class="row m-auto align-items-center web-form-group form-group">
                            <div class="row col-12 contact-field-full-wrap web-field-full-wrap align-items-center w-100 position-relative form-group">
                                <div class="col-6 flex-grow-1 lable-wrap">
                                    <label for="contactMobiles" class="filed-label"><?= l('qr_step_2_com_contact_info.name') ?></label>
                                    <input id="contactName"   onchange="LoadPreview()" name="contactName" placeholder="<?= l('qr_step_2_com_contact_info.input.contactName.placeholder') ?>" data-anchor="contactsBlock" class="anchorLoc step-form-control " value="<?php echo (!empty($filledInput)) ? $filledInput['contactName'] : ''; ?>" data-reload-qr-code />
                                </div>
                                <div class="col-6 flex-grow-1 relative contact-field-wrap">
                                    <label for="contactWebsite" class="filed-label"> <?= l('qr_step_2_com_contact_info.website') ?></label>
                                    <input id="contactWebsite"   onchange="LoadPreview()" name="contactWebsite" data-anchor="contactsBlock" class="anchorLoc step-form-control" placeholder="<?= l('qr_step_2_com_contact_info.input.contactWebsite.placeholder') ?>" value="<?php echo (!empty($filledInput)) ? $filledInput['contactWebsite'] : ''; ?>" maxlength="<?= $data->qr_code_settings['type']['menu']['companyTitle']['max_length'] ?>" data-reload-qr-code />
                                </div>
                            </div>
                            <!-- <div class="delete-contact-btn-wrap col-1 phone-row form-group ">
                                <button type="button" onclick="removeWeb()" class="reapeterCloseIcon close-web-btn contact-delete-btn removable-delete-btn  removeBtnPhone">
                                    <span class="icon-trash grey delete-mark d-flex"></span>
                                </button>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="add-on-phone mb-3">
                <div id="phn-btn" class="mt- row add-phone-area-wrap">
                    <div class="col-8 add-phone-area-text">
                        <span class="contact-subheading"><?= l('qr_step_2_com_contact_info.addPhone') ?></span>
                    </div>
                    <div class="col-4 add-phone-btn-area">
                        <button id="add11" type="button" class="add-phone addRowButton2 add-phone-btn float-right d-block">
                            <span class="icon-add grey plus-mark d-flex"></span>
                        </button>
                    </div>
                    <hr id="contactHr2" class="contact-hr">
                </div>
                <div class="mb- addBusinessButton addRow" id="phn-block">
                    <?php if (!empty($filledInput['contactMobileTitles'])) { ?>
                        <?php foreach ($filledInput['contactMobileTitles'] as $key => $val) { ?>
                            <div class="form-group mt-0 mx-0 mobile-field removable-block-wrp" style="margin-bottom:25px;">
                                <div class="row m-auto align-items-center web-form-group w-100 form-group">
                                    <div class="row col-11 contact-field-full-wrap web-field-full-wrap align-items-center w-100 position-relative form-group">

                                        <div class="col-6 flex-grow-1 lable-wrap">

                                            <label for="contactMobiles" class="filed-label"><?= l('qr_step_2_com_contact_info.phone_label') ?></label>

                                            <input class="step-form-control anchorLoc" 
                                            data-anchor="contactsBlock"
                                            type="text" 
                                            id="contactMobileTitles" 
                                            onchange="LoadPreview()" 
                                            name="contactMobileTitles[]" 
                                            placeholder="<?= l('qr_step_2_com_contact_info.input.contactMobileTitles.placeholder') ?>" 
                                            value="<?php echo $val ?>" 
                                            data-reload-qr-code="">
                                        
                                        </div>

                                        <div class="col-6 flex-grow-1 relative contact-field-wrap">

                                            <label for="contactMobiles" class="filed-label"><?= l('qr_step_2_com_contact_info.phone_number') ?></label>

                                            <input class="step-form-control" 
                                            type="tel" 
                                            id="contactMobiles" 
                                            name="contactMobiles[]" 
                                            onchange="LoadPreview()" 
                                            placeholder="<?= l('qr_step_2_com_contact_info.input.contactMobiles.placeholder') ?>" 
                                            value="<?php echo $filledInput['contactMobiles'][$key] ?>" 
                                            data-reload-qr-code="">

                                        </div>
                                    </div>
                                    <div class="delete-contact-btn-wrap col-1 phone-row form-group">
                                        <button type="button" class="reapeterCloseIcon removable-delete-btn contact-delete-btn removeBtnPhone" >
                                            <span class="icon-trash grey delete-mark d-flex"></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- onclick="remove_me(this)" -->
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
            <div class="add-on-phone">
                <div class="row mt- add-email-area-wrap">
                    <div class="col-8 add-phone-area-text">
                        <span class="contact-subheading"><?= l('qr_step_2_com_contact_info.addEmail') ?></span>
                    </div>
                    <div class="col-4 add-email-btn-area">
                        <button id="add12" type="button" class="email-add add-email-btn float-right d-block">
                            <span class="icon-add grey plus-mark d-flex"></span>
                        </button>
                    </div>
                    <hr id="contactHr3" class="contact-hr">
                </div>
                <div class="mb- addBusinessButton addRow" id="email-block">
                    <?php if (!empty($filledInput['contactEmailTitles'])) { ?>
                        <?php foreach ($filledInput['contactEmailTitles'] as $key => $val) { ?>
                            <div class="form-group email-field  removable-block-wrp" id="email<?php echo $key + 1 ?>" style="margin-bottom:25px;">
                                <div class="row m-auto align-items-center w-100  web-form-group  form-group">
                                    <div class="row col-11 contact-field-full-wrap align-items-center w-100 form-group position-relative">
                                        <div class="col-6 flex-grow-1 lable-wrap">
                                            <label class="filed-label" for="contactEmails"><?= l('qr_step_2_com_contact_info.email_label') ?></label>
                                            <input  data-anchor="contactsBlock" class="anchorLoc step-form-control" type="text" id="contactEmailTitles" onchange="LoadPreview()" name="contactEmailTitles[]" value="<?php echo $val; ?>" placeholder="<?= l('qr_step_2_com_contact_info.input.contactEmailTitles.placeholder') ?>">
                                        </div>
                                        <div class="col-6 flex-grow-1 relative contact-field-wrap">
                                            <label for="contactEmails" class="filed-label"><?= l('qr_step_2_com_contact_info.email') ?></label>
                                            <input  data-anchor="contactsBlock" class="anchorLoc step-form-control" type="email" id="contactEmails" onchange="LoadPreview()" name="contactEmails[]" value="<?php echo $filledInput['contactEmails'][$key] ?>" placeholder="<?= l('qr_step_2_com_contact_info.input.contactEmails.placeholder') ?>">
                                        </div>
                                    </div>
                                    <div class="delete-contact-btn-wrap col-1 phone-row form-group">
                                        <button type="button" class="reapeterCloseIcon removable-delete-btn contact-delete-btn removeBtnEmail" >
                                            <span class="icon-trash grey delete-mark d-flex"></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function removeWeb() {
        $(".web-field").addClass('hide-web');
        // $("#addWeb").addClass('add-phone-btn-active');
        // $("#addWeb").removeClass('add-phone-btn');
        $('#contactHr1').css({
            'display': 'none'
        });
    }

    function addWebField() {
        $(".web-field").removeClass('hide-web');
        // $("#addWeb").addClass('add-phone-btn-active');
        // $("#addWeb").removeClass('add-phone-btn');
        console.log("Added web field");
        if ($("#addWeb").hasClass("add-phone-btn-active")) {
            $('#contactHr1').css({
                'display': 'block'
            });
        }
    }

    if ($("#addWeb").hasClass("add-phone-btn-active")) {
        $('#contactHr1').css({
            'display': 'block'
        });
    }

    $(document).ready(function() {
        var timer = setInterval(function() {
            if ($("#phn-block").children().hasClass("mobile-field")) {
                // $(".add-phone").removeClass('add-phone-btn');
                // $(".add-phone").addClass('add-phone-btn-active');
            }
            if ($("#email-block").children().hasClass("email-field")) {
                // $(".email-add").removeClass('add-email-btn');
                // $(".email-add").addClass('add-phone-btn-active');
            }
            if ($(".web-field").hasClass("hide-web")) {
                // $("#addWeb").removeClass('add-phone-btn-active');
                // $("#addWeb").addClass('add-phone-btn');
            }
            if ($(".add-phone").hasClass("add-phone-btn-active")) {
                $('#contactHr2').css({
                    'display': 'block'
                });
            } else {
                $('#contactHr2').css({
                    'display': 'none'
                });
            }
            if ($(".email-add").hasClass("add-phone-btn-active")) {
                $('#contactHr3').css({
                    'display': 'block'
                });
            } else {
                $('#contactHr3').css({
                    'display': 'none'
                });
            }
        }, 500); // check every half-second.
    });
</script>
