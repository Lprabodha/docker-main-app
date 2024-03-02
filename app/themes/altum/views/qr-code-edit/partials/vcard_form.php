<?php defined('ALTUMCODE') || die() ?>

<div id="step2_form">
    <input type="hidden" id="uId" name="uId" class="form-control" value="<?= uniqid() ?>" data-reload-qr-code />
    <input type="hidden" id="preview_link" name="preview_link" class="form-control" data-reload-qr-code />
    <input type="hidden" id="preview_link2" name="preview_link2" class="form-control" data-reload-qr-code />
    <div class="custom-accodian">
        <button class="btn accodianBtn" type="button" data-toggle="collapse" data-target="#acc_nameOfQrCode" aria-expanded="true" aria-controls="acc_nameOfQrCode">
            <span> <?= l('qr_codes.input.qrname') ?></span>
            <svg class="MuiSvgIcon-root MuiSvgIcon-colorPrimary leftArrow" focusable="false" viewBox="0 0 16 16" aria-hidden="true" style="font-size: 16px;">
                <path d="M12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5ZM12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5Z"></path>
            </svg>
        </button>
        <div class="collapse show" id="acc_nameOfQrCode">
            <div class="collapseInner">
                <div class="form-group m-0">
                    <input id="name" name="name" placeholder="E.g. My QR code" class="form-control" value="" maxlength="<?= $data->qr_code_settings['type']['business']['name']['max_length'] ?>" required data-reload-qr-code />
                </div>
            </div>
        </div>
    </div>

    <div class="custom-accodian">
        <button class="btn accodianBtn" type="button" data-toggle="collapse" data-target="#acc_Design" aria-expanded="true" aria-controls="acc_Design">
            <span>Design</span>
            <svg class="MuiSvgIcon-root MuiSvgIcon-colorPrimary leftArrow" focusable="false" viewBox="0 0 16 16" aria-hidden="true" style="font-size: 16px;">
                <path d="M12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5ZM12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5Z"></path>
            </svg>
        </button>
        <div class="collapse show" id="acc_Design">
            <div class="collapseInner">
                <div class="form-group m-0">
                    <label for="colorPalette">Colour palette</label>
                    <div class="colorPaletteForm">
                        <div class="formcolorPalette active" id="formcolorPalette1">
                            <input type="color" name="" class="colorPalette" value="#2F6BFD" readonly />
                            <input type="color" name="" class="colorPalette ml-1" value="#0E379A" readonly />
                        </div>
                        <div class="formcolorPalette" id="formcolorPalette2">
                            <input type="color" name="" class="colorPalette" value="#28EDC9" />
                            <input type="color" name="" class="colorPalette ml-1" value="#03A183" />
                        </div>
                        <div class="formcolorPalette" id="formcolorPalette3">
                            <input type="color" name="" class="colorPalette" value="#28ED28" />
                            <input type="color" name="" class="colorPalette ml-1" value="#00A301" />
                        </div>
                        <div class="formcolorPalette" id="formcolorPalette4">
                            <input type="color" name="" class="colorPalette" value="#EDE728" />
                            <input type="color" name="" class="colorPalette ml-1" value="#A39E0A" />
                        </div>
                        <div class="formcolorPalette" id="formcolorPalette5">
                            <input type="color" name="" class="colorPalette" value="#ED4C28" />
                            <input type="color" name="" class="colorPalette ml-1" value="#A31F01" />
                        </div>
                    </div>

                    <div class="colorPaletteInner">
                        <div class="form-group m-0">
                            <label for="">Primary</label>
                            <div class="customColorPicker">
                                <label for="primaryColor">
                                    <input id="primaryColor" name="primaryColor" onchange="LoadPreview()" class="pickerField pickerFieldes" type="color" value="#0E379A" data-reload-qr-code />
                                </label>
                            </div>
                        </div>
                        <button type="button" onclick="swapValues()">
                            <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 24px; color:#fff">
                                <path d="M17,5H8.41l1.3-1.29A1,1,0,1,0,8.29,2.29l-3,3a1,1,0,0,0,0,1.42l3,3a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42L8.41,7H17a3,3,0,0,1,3,3v3a1,1,0,0,0,2,0V10A5,5,0,0,0,17,5Z"></path>
                                <path d="M15.7,14.28a1,1,0,0,0-1.4,1.44L15.62,17H7a3,3,0,0,1-3-3V11a1,1,0,0,0-2,0v3a5,5,0,0,0,5,5h8.64l-1.33,1.28a1,1,0,0,0,0,1.41,1,1,0,0,0,1.41,0l3.11-3a1,1,0,0,0,.31-.72,1,1,0,0,0-.3-.72Z"></path>
                            </svg>
                        </button>
                        <div class="form-group m-0">
                            <label for="">Secondary</label>
                            <div class="customColorPicker">
                                <label for="SecondaryColor">
                                    <input id="SecondaryColor" name="SecondaryColor" onchange="LoadPreview()" class="pickerField pickerFields" type="color" value="#2F6BFD" data-reload-qr-code />
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="custom-accodian">
        <button class="btn accodianBtn" type="button" data-toggle="collapse" data-target="#acc_nameOfFonts" aria-expanded="true" aria-controls="acc_nameOfFonts">
            <span>Fonts</span>
            <svg class="MuiSvgIcon-root MuiSvgIcon-colorPrimary leftArrow" focusable="false" viewBox="0 0 16 16" aria-hidden="true" style="font-size: 16px;">
                <path d="M12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5ZM12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5Z"></path>
            </svg>
        </button>
        <div class="collapse show" id="acc_nameOfFonts">
            <div class="collapseInner">
                <div class="bg-container">
                    <div class="row">
                        <div class="form-group m-0 col-md-6 col-sm-12">
                            <label for="filters_cities_by" class="fieldLabel">Title</label>
                            <select name="search_by" id="filters_title_by" class="form-control" onchange="LoadPreview()">
                                <option value="Lato">Lato</option>
                                <option value="Open Sans">Open Sans</option>
                                <option value="Roboto">Roboto</option>
                                <option value="Oswald">Oswald</option>
                                <option value="Montserrat">Montserrat</option>
                                <option value="Source Sans Pro">Source Sans Pro</option>
                                <option value="Slabo 27px">Slabo 27px</option>
                                <option value="Raleway">Raleway</option>
                                <option value="Merriwealther">Merriwealther</option>
                                <option value="Noto Sans">Noto Sans</option>
                            </select>
                        </div>
                        <div class="form-group m-0 col-md-6 col-sm-12">
                            <label for="filters_cities_by" class="fieldLabel">Texts</label>
                            <select name="search_by" id="filters_text_by" class="form-control" onchange="LoadPreview()">
                                <option value="Open Sans">Open Sans</option>
                                <option value="Roboto">Roboto</option>
                                <option value="Oswald">Oswald</option>
                                <option value="Montserrat">Montserrat</option>
                                <option value="Lato">Lato</option>
                                <option value="Source Sans Pro">Source Sans Pro</option>
                                <option value="Slabo 27px">Slabo 27px</option>
                                <option value="Raleway">Raleway</option>
                                <option value="Merriwealther">Merriwealther</option>
                                <option value="Noto Sans">Noto Sans</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="custom-accodian">
        <button class="btn accodianBtn" type="button" data-toggle="collapse" data-target="#acc_vCardInfo" aria-expanded="true" aria-controls="acc_vCardInfo">
            <span>vCard information</span>
            <svg class="MuiSvgIcon-root MuiSvgIcon-colorPrimary leftArrow" focusable="false" viewBox="0 0 16 16" aria-hidden="true" style="font-size: 16px;">
                <path d="M12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5ZM12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5Z"></path>
            </svg>
        </button>
        <div class="collapse show" id="acc_vCardInfo">
            <div class="collapseInner">
                <p class="paraheading mb-4">About you</p>
                <!-- <div class="form-group" data-type="vcard">
                    <label for="images"><?= l('qr_codes.input.image') ?></label>
                    <input type="file" id="images" name="images" class="form-control py-2" value="" accept="image/png, image/gif, image/jpeg" required="required" data-reload-qr-code />
                    <div class="quote-imgs-thumbs quote-imgs-thumbs--hidden" id="<div class="screen-upload mb-3">
            <label for="screen">
              <input type="file" id="screen" name="screen" onchange="setTimeout(function() { console.log('here'); document.getElementById('loader').style.display = 'block'; document.getElementById('iframesrc').style.visibility = 'hidden'; LoadPreview(); }, 5000);" class="form-control py-2" value="" accept="image/png, image/gif, image/jpeg" data-reload-qr-code />
              <div class="input-image" id="input-image">
                <svg class="MuiSvgIcon-root" id="tmp-mage" focusable="false" viewBox="0 0 60 60" aria-hidden="true" style="font-size: 60px;">
                  <path d="M19.24,26.79a8.17,8.17,0,1,0-8.17-8.17A8.17,8.17,0,0,0,19.24,26.79Zm0-14.34a6.17,6.17,0,1,1-6.17,6.17A6.18,6.18,0,0,1,19.24,12.45Z"></path>
                  <path d="M56.75,49.34,39.18,29.26a1,1,0,0,0-1.46-.05L25.09,41.84,19.1,35a1,1,0,0,0-.72-.34.93.93,0,0,0-.74.29L3.29,49.29a1,1,0,0,0,1.42,1.42L18.3,37.12,30.14,50.66a1,1,0,0,0,.76.34,1,1,0,0,0,.66-.25,1,1,0,0,0,.09-1.41l-5.24-6,12-12L55.25,50.66A1,1,0,0,0,56,51a1,1,0,0,0,.75-1.66Z"></path>
                </svg>
              </div>
              <div class="add-icon" id="add-icon">
                <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                  <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"></path>
                </svg>
              </div>
            </label>
            <button type="button" class="upload-btn" onclick="LoadPreview(true)">Preview</button>
          </div>" aria-live="polite"></div>
                </div> -->

                <div class="welcome-screen mb-4">
                    <span><?= l('qr_codes.input.companyLogo') ?></span>
                    <div class="screen-upload">
                        <label for="companyLogo">
                            <input type="file" onchange="LoadPreview()" id="companyLogo" name="companyLogo" class="form-control py-2" accept="image/png, image/gif, image/jpeg" required data-reload-qr-code />
                            <div class="input-image" id="company_logo_img">
                                <svg class="MuiSvgIcon-root" id="cl-tmp-mage" focusable="false" viewBox="0 0 60 60" aria-hidden="true" style="font-size: 60px;">
                                    <path d="M19.24,26.79a8.17,8.17,0,1,0-8.17-8.17A8.17,8.17,0,0,0,19.24,26.79Zm0-14.34a6.17,6.17,0,1,1-6.17,6.17A6.18,6.18,0,0,1,19.24,12.45Z"></path>
                                    <path d="M56.75,49.34,39.18,29.26a1,1,0,0,0-1.46-.05L25.09,41.84,19.1,35a1,1,0,0,0-.72-.34.93.93,0,0,0-.74.29L3.29,49.29a1,1,0,0,0,1.42,1.42L18.3,37.12,30.14,50.66a1,1,0,0,0,.76.34,1,1,0,0,0,.66-.25,1,1,0,0,0,.09-1.41l-5.24-6,12-12L55.25,50.66A1,1,0,0,0,56,51a1,1,0,0,0,.75-1.66Z"></path>
                                </svg>
                            </div>
                            <div class="add-icon" id="company_log_add_icon">
                                <svg style="margin: 7px;" class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"></path>
                                </svg>
                            </div>
                            <div class="add-icon" id="company_log_edit_icon" style="display: none;">
                                <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 24px;margin: 7px;">
                                    <path d="M20.71,6.29l-3-3a1,1,0,0,0-1.42,0l-12,12a1,1,0,0,0-.26.47l-1,4a1,1,0,0,0,.26.95A1,1,0,0,0,4,21a1,1,0,0,0,.24,0l4-1a1,1,0,0,0,.47-.26l12-12A1,1,0,0,0,20.71,6.29ZM7.49,18.1l-2.12.53.53-2.12,8.6-8.6L16.09,9.5Zm10-10L15.91,6.5,17,5.41,18.59,7Z"></path>
                                </svg>
                            </div>
                        </label>
                        <button type="button" class="delete-btn" id="cl_screen_delete" style="display:none;">
                            <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 24px;">
                                <path d="M20,7H4A1,1,0,0,0,4,9H5.08l.77,9.25a3,3,0,0,0,3,2.75h6.32a3,3,0,0,0,3-2.75L18.92,9H20a1,1,0,0,0,0-2ZM16.16,18.08a1,1,0,0,1-1,.92H8.84a1,1,0,0,1-1-.92L7.09,9h9.82Z"></path>
                                <path d="M9,5h6a1,1,0,0,0,0-2H9A1,1,0,0,0,9,5Z"></path>
                            </svg>
                            Delete
                        </button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group" data-type="vcard">
                            <label for="vcard_first_name">Name *</label>
                            <input type="text" id="vcard_first_name" onchange="LoadPreview()" name="vcard_first_name" placeholder="E.g. Paul" class="form-control" value="" maxlength="<?= $data->qr_code_settings['type']['vcard']['first_name']['max_length'] ?>" data-reload-qr-code />
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group" data-type="vcard">
                            <label for="vcard_last_name">Surname</label>
                            <input type="text" id="vcard_last_name" onchange="LoadPreview()" name="vcard_last_name" placeholder="E.g. Jones" class="form-control" value="" maxlength="<?= $data->qr_code_settings['type']['vcard']['last_name']['max_length'] ?>" data-reload-qr-code />
                        </div>
                    </div>
                </div>
                <p class="paraheading mb-4 pt-4">Contact info</p>
                <div id="phoneBlock">
                    <!-- <div class="d-flex align-items-end mb-4">
                        <div class="form-group m-0">
                            <label for="filters_address_by" class="fieldLabel">Telephone </label>
                            <select name="phone_type0" id="filters_address_by" class="form-control" data-reload-qr-code>
                                <option value="Mobile phone">
                                    <svg class="MuiSvgIcon-root jss246 cell" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M15.5 1h-8C6.12 1 5 2.12 5 3.5v17C5 21.88 6.12 23 7.5 23h8c1.38 0 2.5-1.12 2.5-2.5v-17C18 2.12 16.88 1 15.5 1zm-4 21c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm4.5-4H7V4h9v14z"></path>
                                    </svg> Mobile phone
                                </option>
                                <option value="Home">
                                    <svg class="MuiSvgIcon-root jss246 home" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"></path>
                                    </svg> Home
                                </option>
                                <option value="Work">
                                    <svg class="MuiSvgIcon-root jss1658 work" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M20 6h-4V4c0-1.11-.89-2-2-2h-4c-1.11 0-2 .89-2 2v2H4c-1.11 0-1.99.89-1.99 2L2 19c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2zm-6 0h-4V4h4v2z"></path>
                                    </svg>
                                    Work
                                </option>
                                <option value="Fax">
                                    <svg class="MuiSvgIcon-root jss246 fax" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M19 8H5c-1.66 0-3 1.34-3 3v6h4v4h12v-4h4v-6c0-1.66-1.34-3-3-3zm-3 11H8v-5h8v5zm3-7c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm-1-9H6v4h12V3z"></path>
                                    </svg> Fax
                                </option>
                                <option value="Other">
                                    <svg class="MuiSvgIcon-root jss246 other" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 22px;">
                                        <path d="M16.18,21.3a5,5,0,0,1-3.53-1.46L4.16,11.35a5,5,0,0,1,0-7.07l.71-.7a3,3,0,0,1,4.24,0L11.23,5.7a3,3,0,0,1,0,4.24l-.6.6,2.83,2.83.6-.6a3,3,0,0,1,4.24,0l2.12,2.12a3,3,0,0,1,0,4.24l-.7.71A5,5,0,0,1,16.18,21.3ZM7,4.7A1,1,0,0,0,6.28,5l-.7.71a3,3,0,0,0,0,4.24l8.48,8.48a3,3,0,0,0,4.24,0l.71-.7a1,1,0,0,0,0-1.42l-2.12-2.12a1,1,0,0,0-1.42,0l-2,2L7.8,10.54l2-2a1,1,0,0,0,0-1.42L7.7,5A1,1,0,0,0,7,4.7Z"></path>
                                    </svg> Other
                                </option>
                            </select>
                        </div>
                        <div class="d-flex align-items-center w-100 ml-2">
                            <div class="d-flex align-items-center w-100">
                                <input type="text" id="vcard_phone" name="vcard_phone[]" onchange="LoadPreview()" placeholder="Label..." class="form-control mr-2" value="" maxlength="<?= $data->qr_code_settings['type']['vcard']['phone']['max_length'] ?>" data-reload-qr-code />
                                <input type="text" id="vcard_phoneLabel" name="vcard_phoneLabel[]" onchange="LoadPreview()" placeholder="E.g. 00000 000000" class="form-control mr-2" value="" maxlength="<?= $data->qr_code_settings['type']['vcard']['phone']['max_length'] ?>" data-reload-qr-code />
                            </div>
                            <button class="reapeterCloseIcon" onclick="remove_me(this)">
                                <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"></path>
                                </svg>
                            </button>
                        </div>
                    </div> -->
                </div>
                <div class="mb-4">
                    <button id="addPhone" type="button" class="outlineBtn addRowButton"><i class="fa fa-fw fa-plus fa-sm mr-1"></i> <?= l('qr_codes.input.addPhone') ?></button>
                </div>
                <div id="emailBlock">
                    <!-- <div class="form-group">
                        <label for="vcard_email"><?= l('qr_codes.input.vcard_email') ?></label>
                        <div class="d-flex align-items-center w-100">
                            <div class="d-flex align-items-center w-100">
                                <input type="text" id="vcard_email_lable" placeholder="Label..." name="vcard_email_lable0" onchange="LoadPreview()" class="form-control mr-3" value="" maxlength="<?= $data->qr_code_settings['type']['vcard']['email']['max_length'] ?>" data-reload-qr-code />
                                <input type="email" id="vcard_email" placeholder="E.g. name@email.com" name="vcard_email0" onchange="LoadPreview()" class="form-control mr-3" value="" maxlength="<?= $data->qr_code_settings['type']['vcard']['email']['max_length'] ?>" data-reload-qr-code />
                            </div>
                            <button class="reapeterCloseIcon" onclick="remove_me(this)">
                                <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"></path>
                                </svg>
                            </button>
                        </div>
                    </div> -->
                </div>


                <div class="mb-4">
                    <button id="addEmail" type="button" class="outlineBtn addRowButton"><i class="fa fa-fw fa-plus fa-sm mr-1"></i> Add email</button>
                </div>

                <div id="websiteBlock">
                    <!-- <div class="form-group">
                        <label for="vcard_url">Personal website</label>
                        <div class="d-flex align-items-center w-100">
                            <div class="d-flex align-items-center w-100">
                                <input type="text" id="vcard_website_title" placeholder="Write here the text of the URL ..." name="vcard_website_title0" onchange="LoadPreview()" class="form-control mr-3" value="" maxlength="<?= $data->qr_code_settings['type']['vcard']['email']['max_length'] ?>" data-reload-qr-code />
                                <input type="url" id="vcard_website" placeholder="https://..." name="vcard_website0" onchange="LoadPreview()" class="form-control mr-3" value="" maxlength="<?= $data->qr_code_settings['type']['vcard']['email']['max_length'] ?>" data-reload-qr-code />
                            </div>
                            <button class="reapeterCloseIcon" onclick="remove_me(this)">
                                <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"></path>
                                </svg>
                            </button>
                        </div>
                    </div> -->
                </div>


                <div class="mb-4">
                    <button id="addWebsite" type="button" class="outlineBtn addRowButton"><i class="fa fa-fw fa-plus fa-sm mr-1"></i> Add website</button>
                </div>
                <!-- <div class="form-group d-flex align-items-center justify-content-center py-2 mb-3">
                    <div class="roundCheckbox mx-2">
                        <input type="checkbox" id="checkbox1" />
                        <label class="m-0" for="checkbox1"></label>
                    </div>
                    <label class="m-0">"Add contact" at the top</label>
                </div> -->

                <div class="couponLocation">
                    <div class="couponButtonGroup">
                        <button type="button" class="outlineBtn squreBtn active" id="Complete">Complete</button>
                        <button type="button" class="outlineBtn squreBtn" id="Url">Url</button>
                        <button type="button" class="outlineBtn squreBtn" id="Coordinates">Coordinates</button>
                    </div>
                </div>

                <!-- Complete Div -->
                <div id="LocationInputs">

                    <div class="d-flex align-items-end mb-4" id="mapInput">
                        <div class="form-group m-0 w-100">
                            <label for="ship-address">Search address</label>
                            <input id="ship-address" name="ship-address" autocomplete="off" onchange="LoadPreview()" placeholder="" class="form-control" value="" data-reload-qr-code />
                        </div>
                        <button type="button" class="outlineBtn manualyBtn" id="manualyBtn">Manual entry</button>
                    </div>
                    <div>
                        <div id="manualEntry">

                        </div>
                        <!-- <div class="row">


        

    </div> -->
                    </div>
                </div>

                <!-- Url Div -->
                <div id="UrlEntry">
                    <!-- <div class="form-group">
                        <label for="offer_url1">Url</label>
                        <input id="offer_url1" onchange="LoadPreview()" placeholder=" https://…" name="offer_url1" class="form-control" value="" required="" data-reload-qr-code />
                    </div> -->
                </div>


                <!-- Coordinates Div -->
                <div id="CoEntry">
                    <!-- <div class="row align-items-end">
                        <div class="form-group pr-2 col-6">
                            <label for="latitude">Latitude</label>
                            <input id="latitude" onchange="LoadPreview()" placeholder="" name="latitude" class="form-control" value="" required="" data-reload-qr-code />
                        </div>
                        <div class="form-group pl-2 col-6">
                            <label for="longitude">Longitude</label>
                            <input id="longitude" onchange="LoadPreview()" placeholder="" name="longitude" class="form-control" value="" required="" data-reload-qr-code />
                        </div>
                    </div> -->
                </div>

                <div>
                    <p class="paraheading pt-4 mb-4">Company</p>
                    <div class="row">
                        <div class="form-group pr-2 col-6" data-type="vcard">
                            <label for="vcard_company"><?= l('qr_codes.input.vcard_company') ?></label>
                            <input type="text" id="vcard_company" onchange="LoadPreview()" name="vcard_company" placeholder="E.g. Company LLC" class="form-control" value="" maxlength="<?= $data->qr_code_settings['type']['vcard']['country']['max_length'] ?>" data-reload-qr-code />
                        </div>
                        <div class="form-group pl-2 col-6" data-type="vcard">
                            <label for="vcard_profession">Profession</label>
                            <input type="text" id="vcard_profession" onchange="LoadPreview()" name="vcard_profession" placeholder="E.g. Your profession/position" class="form-control" value="" maxlength="<?= $data->qr_code_settings['type']['vcard']['country']['max_length'] ?>" data-reload-qr-code />
                        </div>
                    </div>
                </div>

                <div class="form-group mb-0" data-type="vcard">
                    <p class="paraheading pt-4 mb-2">Summary</p>
                    <textarea id="vcard_note" name="vcard_note" placeholder="E.g. Lorem ipsum" onchange="LoadPreview()" class="form-control textarea-control" maxlength="<?= $data->qr_code_settings['type']['vcard']['note']['max_length'] ?>" data-reload-qr-code></textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="custom-accodian" id="social">
        <button class="btn accodianBtn" type="button" data-toggle="collapse" data-target="#acc_social" aria-expanded="true" aria-controls="acc_social">
            <span>Social networks</span>
            <svg class="MuiSvgIcon-root MuiSvgIcon-colorPrimary leftArrow" focusable="false" viewBox="0 0 16 16" aria-hidden="true" style="font-size: 16px;">
                <path d="M12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5ZM12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5Z"></path>
            </svg>
        </button>
        <div class="collapse show" id="acc_social">
            <div class="collapseInner">
                <!-- repeter form -->
                <div class="socialFormContainer">
                    <div class="socialItem">
                        <div class="socialInner">
                            <img src="https://qrfy.com/static/media/circle_dribbble_logo.61b290c3.svg" alt="">
                            <p class="m-0">Dribbble</p>
                        </div>
                        <div class="socialDetail">
                            <div class="socialInput">
                                <div class="form-group mb-3">
                                    <label>User ID</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="form-group m-0">
                                    <label>Text</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="socialBtn">
                                <button type="button">
                                    <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="socialIconContainer">
                    <label class="socialLabel">Add more</label>
                    <div class="socialIconContain">
                        <?php for ($i = 1; $i < 32; $i++) { ?>
                            <button type="button" id="socialicon_id_<?= $i ?>" class="boxtagLabel" data-socialiconid="<?php echo $i; ?>" data-socialiconurl="<?= ASSETS_FULL_URL . 'images/socialicon/icon' . $i . '.svg'; ?>" onclick="getQRFromUrl(this);" data-reload-qr-code>
                                <?php echo file_get_contents(ASSETS_FULL_URL . 'images/socialicon/icon' . $i . '.svg'); ?>
                            </button>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="custom-accodian">
        <button class="btn accodianBtn" type="button" data-toggle="collapse" data-target="#vcard_socials_container" aria-expanded="true" aria-controls="vcard_socials_container" data-type="vcard">
            <?= l('qr_codes.input.vcard_socials') ?>
            <svg class="MuiSvgIcon-root MuiSvgIcon-colorPrimary leftArrow" focusable="false" viewBox="0 0 16 16" aria-hidden="true" style="font-size: 16px;">
                <path d="M12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5ZM12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5Z"></path>
            </svg>
        </button>
        <div class="collapse show" id="vcard_socials_container">
            <div class="collapseInner">
                <div id="vcard_socials"></div>
                <div>
                    <button data-add="vcard_social" type="button" class="outlineBtn addRowButton"><i class="fa fa-fw fa-plus-circle smIcon"></i>Add Social</button>
                </div>
            </div>
        </div>
    </div>

    <div class="custom-accodian">
        <button class="btn accodianBtn" type="button" data-toggle="collapse" data-target="#acc_welcomeScreen" aria-expanded="true" aria-controls="acc_welcomeScreen">
            <span>Welcome Screen</span>
            <svg class="MuiSvgIcon-root MuiSvgIcon-colorPrimary leftArrow" focusable="false" viewBox="0 0 16 16" aria-hidden="true" style="font-size: 16px;">
                <path d="M12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5ZM12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5Z"></path>
            </svg>
        </button>
        <div class="collapse show" id="acc_welcomeScreen">
            <div class="collapseInner">
                <div class="welcome-screen">
                    <span>Image</span>
                    <!-- Before Upload Priview -->
                    <div class="screen-upload justify-content-between">
                        <div class="d-flex align-items-center mr-2">
                            <label for="screen">
                                <input type="file" id="screen" name="screen" onchange="setTimeout(function() { console.log('here'); document.getElementById('loader').style.display = 'block'; document.getElementById('iframesrc').style.visibility = 'hidden'; LoadPreview(); }, 5000);" class="form-control py-2" value="" accept="image/png, image/gif, image/jpeg" data-reload-qr-code />
                                <div class="input-image" id="input-image">
                                    <svg class="MuiSvgIcon-root" id="tmp-mage" style="display:block;" focusable="false" viewBox="0 0 60 60" aria-hidden="true" style="font-size: 60px;">
                                        <path d="M19.24,26.79a8.17,8.17,0,1,0-8.17-8.17A8.17,8.17,0,0,0,19.24,26.79Zm0-14.34a6.17,6.17,0,1,1-6.17,6.17A6.18,6.18,0,0,1,19.24,12.45Z"></path>
                                        <path d="M56.75,49.34,39.18,29.26a1,1,0,0,0-1.46-.05L25.09,41.84,19.1,35a1,1,0,0,0-.72-.34.93.93,0,0,0-.74.29L3.29,49.29a1,1,0,0,0,1.42,1.42L18.3,37.12,30.14,50.66a1,1,0,0,0,.76.34,1,1,0,0,0,.66-.25,1,1,0,0,0,.09-1.41l-5.24-6,12-12L55.25,50.66A1,1,0,0,0,56,51a1,1,0,0,0,.75-1.66Z"></path>
                                    </svg>
                                </div>
                                <div class="add-icon" id="add-icon" style="display:block;">
                                    <svg style="margin: 7px;" class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"></path>
                                    </svg>
                                </div>
                                <div class="add-icon" id="edit-icon" style="display:none;">
                                    <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 24px;margin: 7px;">
                                        <path d="M20.71,6.29l-3-3a1,1,0,0,0-1.42,0l-12,12a1,1,0,0,0-.26.47l-1,4a1,1,0,0,0,.26.95A1,1,0,0,0,4,21a1,1,0,0,0,.24,0l4-1a1,1,0,0,0,.47-.26l12-12A1,1,0,0,0,20.71,6.29ZM7.49,18.1l-2.12.53.53-2.12,8.6-8.6L16.09,9.5Zm10-10L15.91,6.5,17,5.41,18.59,7Z"></path>
                                    </svg>
                                </div>
                            </label>
                            <button type="button" class="delete-btn" id="screen_delete" style="display:none;">
                                <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 24px;">
                                    <path d="M20,7H4A1,1,0,0,0,4,9H5.08l.77,9.25a3,3,0,0,0,3,2.75h6.32a3,3,0,0,0,3-2.75L18.92,9H20a1,1,0,0,0,0-2ZM16.16,18.08a1,1,0,0,1-1,.92H8.84a1,1,0,0,1-1-.92L7.09,9h9.82Z"></path>
                                    <path d="M9,5h6a1,1,0,0,0,0-2H9A1,1,0,0,0,9,5Z"></path>
                                </svg>
                                Delete
                            </button>
                        </div>
                        <button type="button" class="upload-btn" onclick="LoadPreview(true)">Preview</button>
                    </div>


                </div>
            </div>
        </div>
    </div>

    <div class="custom-accodian">
        <button class="btn accodianBtn" type="button" data-toggle="collapse" data-target="#acc_password" aria-expanded="false" aria-controls="acc_password">
            <span> Password</span>
            <svg class="MuiSvgIcon-root MuiSvgIcon-colorPrimary leftArrow" focusable="false" viewBox="0 0 16 16" aria-hidden="true" style="font-size: 16px;">
                <path d="M12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5ZM12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5Z"></path>
            </svg>
        </button>
        <div class="collapse" id="acc_password">
            <div class="collapseInner">
                <div class="form-group m-0" id="passwordBlock">
                    <div class="d-flex align-items-center mb-3">
                        <div class="roundCheckbox passwordCheckbox mr-3">
                            <input type="checkbox" id="passcheckbox" />
                            <label class="m-0" for="passcheckbox"></label>
                        </div>
                        <label class="passwordlabel mb-0">Activate password to access the QR code</label>
                    </div>
                    <!-- <input id="passwordField" type="password" name="password" class="form-control" value="" maxlength="30" data-reload-qr-code /> -->
                </div>
            </div>
        </div>
    </div>
    <template id="template_vcard_social">
        <div class="mb-4">
            <div class="form-group">
                <label for=""><?= l('qr_codes.input.vcard_social_label') ?></label>
                <input id="" type="text" name="vcard_social_label[]" class="form-control" onchange="LoadPreview()" required="required" data-reload-qr-code />
            </div>

            <div class="form-group mb-2">
                <label for=""><?= l('qr_codes.input.vcard_social_value') ?></label>
                <input id="" type="url" name="vcard_social_value[]" class="form-control" onchange="LoadPreview()" maxlength="<?= $data->qr_code_settings['type']['vcard']['social_value']['max_length'] ?>" required="required" data-reload-qr-code />
            </div>

            <button type="button" data-remove="vcard_social" class="mt-2 outlineBtn manualyBtn closeBtn" style="border: 2px solid #f91d1d !important;color: red !important;margin-left: 0px;"><i class="fa fa-fw fa-times"> </i>Delete</button>

        </div>
    </template>
    <!-- <?php include_once('accodian-form-group/tracking-analytics.php'); ?> -->
</div>



<script>
    var base_url = '<?php echo SITE_URL?>'

    function LoadPreview(welcome_screen = false) {

        let vcard_first_name = document.getElementById('vcard_first_name').value;
        let vcard_last_name = document.getElementById('vcard_last_name').value;
        let primaryColor = document.getElementById('primaryColor').value;
        let SecondaryColor = document.getElementById('SecondaryColor').value;
        // let vcard_phone = document.getElementById('vcard_phone').value;
        // let vcard_email = document.getElementById('vcard_email').value;
        let offer_street = document.getElementById('offer_street')?.value || "";
        let offer_number = document.getElementById('offer_number')?.value || "";
        let offer_postalcode = document.getElementById('offer_postalcode')?.value || "";
        let offer_city = document.getElementById('offer_city')?.value || "";
        let offer_state = document.getElementById('offer_state')?.value || "";
        let offer_country = document.getElementById('offer_country')?.value || "";
        let offer_url1 = document.getElementById('offer_url1')?.value || "";
        let latitude = document.getElementById('latitude')?.value || "";
        let longitude = document.getElementById('longitude')?.value || "";
        let vcard_note = document.getElementById('vcard_note').value;
        let vcard_company = document.getElementById('vcard_company').value;
        let companyLogo = document.getElementById('companyLogo').files;
        var companyLogoFile = companyLogo && companyLogo.length ? base_url + "uploads/vcard/" + uId + "_companyLogo_" + companyLogo[0].name + "" : "";     

        let vcard_phone = $("input[name='vcard_phone[]']").map(function() {
            return $(this).val();
        }).get();
        let vcard_phoneLabel = $("input[name='vcard_phoneLabel[]']").map(function() {
            return $(this).val();
        }).get();
        let vcard_email = $("input[name='vcard_email[]']").map(function() {
            return $(this).val();
        }).get();
        let vcard_emailLabel = $("input[name='vcard_emailLabel[]']").map(function() {
            return $(this).val();
        }).get();
        let vcard_social_label = $("input[name*='vcard_social_label']").map(function() {
            return $(this).val();
        }).get();
        let vcard_social_value = $("input[name*='vcard_social_value']").map(function() {
            return $(this).val();
        }).get();
        let vcard_website_title = $("input[name='vcard_website_title[]']").map(function() {
            return $(this).val();
        }).get();
        let vcard_website = $("input[name='vcard_website[]']").map(function() {
            return $(this).val();
        }).get();
        let vcard_profession = document.getElementById("vcard_profession").value;
        let font_title = document.getElementById('filters_title_by').value;
        let font_text = document.getElementById('filters_text_by').value;
        // let tmp_images = document.getElementById('images').value;
        // var files = document.getElementById("images").files;
        console.log("vcard_social_label", vcard_social_label)
        // var image = "<?php echo SITE_URL?>uploads/images/" + uId + "_" + files.name + "";
        console.log("vcard_phone -------- ", vcard_phone)

        var filesscreen = document.getElementById("screen").files;

        var screen = filesscreen && filesscreen.length ? base_url + "uploads/screen/" + uId + "_" + filesscreen[0].name + "" : "";


        let link = `<?php echo LANDING_PAGE_URL;?>vcard?vcard_website_title=${JSON.stringify(vcard_website_title)}&vcard_website=${JSON.stringify(vcard_website)}&font_title=${font_title}&font_text=${font_text}&vcard_profession=${vcard_profession}&primaryColor=${primaryColor.replace("#","")}&SecondaryColor=${SecondaryColor.replace("#","")}&vcard_first_name=${vcard_first_name}&vcard_last_name=${vcard_last_name}&vcard_phone=${JSON.stringify(vcard_phone)}&vcard_phoneLabel=${JSON.stringify(vcard_phoneLabel)}&vcard_email=${JSON.stringify(vcard_email)}&vcard_emailLabel=${JSON.stringify(vcard_emailLabel)}&vcard_note=${vcard_note}&vcard_company=${vcard_company}&vcard_social_label=${JSON.stringify(vcard_social_label)}&vcard_social_value=${JSON.stringify(vcard_social_value)}&images=${JSON.stringify([companyLogoFile])}&offer_street=${offer_street}&offer_number=${offer_number}&offer_postalcode=${offer_postalcode}&offer_city=${offer_city}&offer_state=${offer_state}&offer_country=${offer_country}&offer_url1=${offer_url1}&latitude=${latitude}&longitude=${longitude}&screen=${screen}`
        if (!welcome_screen) {
            link = `<?php echo LANDING_PAGE_URL;?>vcard?vcard_website_title=${JSON.stringify(vcard_website_title)}&vcard_website=${JSON.stringify(vcard_website)}&font_title=${font_title}&font_text=${font_text}&vcard_profession=${vcard_profession}&primaryColor=${primaryColor.replace("#","")}&SecondaryColor=${SecondaryColor.replace("#","")}&vcard_first_name=${vcard_first_name}&vcard_last_name=${vcard_last_name}&vcard_phone=${JSON.stringify(vcard_phone)}&vcard_phoneLabel=${JSON.stringify(vcard_phoneLabel)}&vcard_email=${JSON.stringify(vcard_email)}&vcard_emailLabel=${JSON.stringify(vcard_emailLabel)}&vcard_note=${vcard_note}&vcard_company=${vcard_company}&vcard_social_label=${JSON.stringify(vcard_social_label)}&vcard_social_value=${JSON.stringify(vcard_social_value)}&images=${JSON.stringify([companyLogoFile])}&offer_street=${offer_street}&offer_number=${offer_number}&offer_postalcode=${offer_postalcode}&offer_city=${offer_city}&offer_state=${offer_state}&offer_country=${offer_country}&offer_url1=${offer_url1}&latitude=${latitude}&longitude=${longitude}`
        }
        document.getElementById('iframesrc').src = link;
        document.getElementById("preview_link").value = link;
        document.getElementById("preview_link2").value = link;
        if (document.getElementById('iframesrc2')) {
            document.getElementById('iframesrc2').src = link;
        }
        let im_url = $('#qr_code').attr('src');
        if ($(".qrCodeImg")) {
            $(".qrCodeImg").html(`<img id="qr_code_p" src=` + im_url + ` class="img-fluid qr-code" loading="lazy" />`);
        }

    }
</script>
<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="<?= ASSETS_FULL_URL ?>js/qr_form.js"></script>
<script>
    var manualClicked = false;
    var urlClicked = false;
    var coClicked = false;
    var phoneNumber = 1;
    var emailNumber = 1;
    var websiteNumber = 1;
    $(document).on('click', '#addPhone', function() {
        var rmvBtnHtml = `
                        <div class="d-flex align-items-end mb-4">
                        <div class="form-group m-0">
                            <label for="filters_address_by" class="fieldLabel">Telephone </label>
                            <select name="phone_type` + (phoneNumber + 1).toString() + `" id="filters_address_by" class="form-control" data-reload-qr-code>
                                <option value="Mobile phone">
                                    <svg class="MuiSvgIcon-root jss246 cell" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M15.5 1h-8C6.12 1 5 2.12 5 3.5v17C5 21.88 6.12 23 7.5 23h8c1.38 0 2.5-1.12 2.5-2.5v-17C18 2.12 16.88 1 15.5 1zm-4 21c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm4.5-4H7V4h9v14z"></path>
                                    </svg> Mobile phone
                                </option>
                                <option value="Home">
                                    <svg class="MuiSvgIcon-root jss246 home" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"></path>
                                    </svg> Home
                                </option>
                                <option value="Work">
                                    <svg class="MuiSvgIcon-root jss1658 work" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M20 6h-4V4c0-1.11-.89-2-2-2h-4c-1.11 0-2 .89-2 2v2H4c-1.11 0-1.99.89-1.99 2L2 19c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2zm-6 0h-4V4h4v2z"></path>
                                    </svg>
                                    Work
                                </option>
                                <option value="Fax">
                                    <svg class="MuiSvgIcon-root jss246 fax" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M19 8H5c-1.66 0-3 1.34-3 3v6h4v4h12v-4h4v-6c0-1.66-1.34-3-3-3zm-3 11H8v-5h8v5zm3-7c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm-1-9H6v4h12V3z"></path>
                                    </svg> Fax
                                </option>
                                <option value="Other">
                                    <svg class="MuiSvgIcon-root jss246 other" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 22px;">
                                        <path d="M16.18,21.3a5,5,0,0,1-3.53-1.46L4.16,11.35a5,5,0,0,1,0-7.07l.71-.7a3,3,0,0,1,4.24,0L11.23,5.7a3,3,0,0,1,0,4.24l-.6.6,2.83,2.83.6-.6a3,3,0,0,1,4.24,0l2.12,2.12a3,3,0,0,1,0,4.24l-.7.71A5,5,0,0,1,16.18,21.3ZM7,4.7A1,1,0,0,0,6.28,5l-.7.71a3,3,0,0,0,0,4.24l8.48,8.48a3,3,0,0,0,4.24,0l.71-.7a1,1,0,0,0,0-1.42l-2.12-2.12a1,1,0,0,0-1.42,0l-2,2L7.8,10.54l2-2a1,1,0,0,0,0-1.42L7.7,5A1,1,0,0,0,7,4.7Z"></path>
                                    </svg> Other
                                </option>
                            </select>
                        </div>
                        <div class="d-flex align-items-center w-100 ml-2">
                            <div class="d-flex align-items-center w-100">
                                <input type="text" id="vcard_phoneLabel" name="vcard_phoneLabel[]" onchange="LoadPreview()" placeholder="Label..." class="form-control mr-2" maxlength="<?= $data->qr_code_settings['type']['vcard']['phone']['max_length'] ?>" data-reload-qr-code />
                                <input type="text" id="vcard_phone" name="vcard_phone[]" onchange="LoadPreview()" placeholder="E.g. 00000 000000" class="form-control mr-2" maxlength="<?= $data->qr_code_settings['type']['vcard']['phone']['max_length'] ?>" data-reload-qr-code />
                            </div>
                            <button class="reapeterCloseIcon" onclick="remove_me(this)">
                                <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                        `;
        $('#phoneBlock').append(rmvBtnHtml);
        phoneNumber++
    });
    $(document).on('click', '#addEmail', function() {
        var rmvBtnHtml = `
        <div class="form-group">
                        <label for="vcard_email"><?= l('qr_codes.input.vcard_email') ?></label>
                        <div class="d-flex align-items-center w-100">
                            <div class="d-flex align-items-center w-100">
                                <input type="text" id="vcard_emailLabel" placeholder="Label..." name="vcard_emailLabel[]" onchange="LoadPreview()" class="form-control mr-3" maxlength="<?= $data->qr_code_settings['type']['vcard']['email']['max_length'] ?>" data-reload-qr-code />
                                <input type="email" id="vcard_email" placeholder="E.g. name@email.com" name="vcard_email[]" onchange="LoadPreview()" class="form-control mr-3" maxlength="<?= $data->qr_code_settings['type']['vcard']['email']['max_length'] ?>" data-reload-qr-code />
                            </div>
                            <button class="reapeterCloseIcon" onclick="remove_me(this)">
                                <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                        `;
        $('#emailBlock').append(rmvBtnHtml);
        emailNumber++
    });
    $(document).on('click', '#addWebsite', function() {
        var rmvBtnHtml = `
        <div class="form-group">
                        <label for="vcard_url">Personal website</label>
                        <div class="d-flex align-items-center w-100">
                            <div class="d-flex align-items-center w-100">
                                <input type="text" id="vcard_website_title" placeholder="Write here the text of the URL ..." name="vcard_website_title[]" onchange="LoadPreview()" class="form-control mr-3" maxlength="<?= $data->qr_code_settings['type']['vcard']['email']['max_length'] ?>" data-reload-qr-code />
                                <input type="url" id="vcard_website" placeholder="https://..." name="vcard_website[]" onchange="LoadPreview()" class="form-control mr-3" maxlength="<?= $data->qr_code_settings['type']['vcard']['email']['max_length'] ?>" data-reload-qr-code />
                            </div>
                            <button class="reapeterCloseIcon" onclick="remove_me(this)">
                                <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                        `;
        $('#websiteBlock').append(rmvBtnHtml);
        websiteNumber++
    });

    $(document).on('click', '#Complete', function() {
        console.log("24hr")
        $('#Complete').addClass('active');
        $('#Url').removeClass('active');
        $('#Coordinates').removeClass('active');
        $('#LocationInputs').show();
        $('#UrlEntry').hide();
        $('#CoEntry').hide();
        // urlClicked = false;
    });
    // manualyBtn

    $(document).on('click', '#manualyBtn', function() {
        console.log("manualyBtn")
        if (!manualClicked) {

            $('#manualyBtn').html("Delete Address")
            var contentHtml = `  
                        <div class="d-flex align-items-center mb-3">
                            <div class="custom-control custom-switch customSwitchToggle">
                                <input type="checkbox" class="custom-control-input" id="customSwitchToggle1">
                                <label class="custom-control-label" for="customSwitchToggle1">Street number first</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 street">
                                <div class="form-group">
                                    <label for="offer_street">Street</label>
                                    <input id="offer_street" onchange="LoadPreview()" placeholder="" name="offer_street" class="form-control anchorLoc" value="" data-anchor="vcardLocation" data-reload-qr-code="">
                                </div>
                            </div>
                            <div class="col-12 npc">
                                <div class="row">
                                    <div class="col-6 pr-2">
                                        <div class="form-group">
                                            <label for="offer_number">Number</label>
                                            <input id="offer_number" onchange="LoadPreview()" placeholder="" name="offer_number" class="form-control anchorLoc" data-anchor="vcardLocation" value="" data-reload-qr-code="">
                                        </div>
                                    </div>
                                    <div class="col-6 pl-2">
                                        <div class="form-group">
                                            <label for="offer_postalcode">Postal Code</label>
                                            <input id="offer_postalcode" onchange="LoadPreview()" placeholder="" name="offer_postalcode" class="form-control anchorLoc" value="" data-anchor="vcardLocation" data-reload-qr-code="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 pr-2">
                                <div class="form-group">
                                    <label for="offer_city">City</label>
                                    <input id="offer_city" onchange="LoadPreview()" placeholder="" name="offer_city" class="form-control anchorLoc" value="" data-anchor="vcardLocation" data-reload-qr-code="">
                                </div>
                            </div>
                            <div class="col-6 pl-2">
                                <div class="form-group">
                                    <label for="offer_state">State / Province</label>
                                    <input id="offer_state" onchange="LoadPreview()" placeholder="" name="offer_state" class="form-control anchorLoc" value="" data-anchor="vcardLocation" data-reload-qr-code="">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group m-0">
                                    <label for="offer_country">Country</label>
                                    <input id="offer_country" onchange="LoadPreview()" placeholder="" name="offer_country" class="form-control anchorLoc" value="" data-anchor="vcardLocation" data-reload-qr-code="">
                                </div>
                            </div>
                        </div>
                            `;
            $('#manualEntry').append(contentHtml);
            manualClicked = true;
            $("#mapInput").hide();
        } else {
            $('#manualyBtn').html("Manual Entry")
            $('#manualEntry').empty();

            manualClicked = false;
            $("#mapInput").show();
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
            console.log("Url")


            var contentHtml = `
                        <div class="form-group">
                            <label for="offer_url1">Url</label>
                            <input id="offer_url1" onchange="LoadPreview()" placeholder=" https://…" name="offer_url1" class="form-control" value=""  data-reload-qr-code />
                        </div>
                                `;
            $('#UrlEntry').append(contentHtml);
            urlClicked = true;
        } else {
            $('#UrlEntry').show();
        }

    });

    $(document).on('click', '#Coordinates', function() {
        console.log("Coordinates")
        $('#Coordinates').addClass('active');
        $('#Complete').removeClass('active');
        $('#Url').removeClass('active');
        $('#LocationInputs').hide();
        $('#UrlEntry').hide();
        $('#CoEntry').show()
        // CoEntry
        if (!coClicked) {
            console.log("CoEntry")


            var contentHtml = `
            <div class="row align-items-end">
                        <div class="form-group pr-2 col-6">
                            <label for="latitude">Latitude</label>
                            <input id="latitude" onchange="LoadPreview()" placeholder="" name="latitude" class="form-control" value=""  data-reload-qr-code />
                        </div>
                        <div class="form-group pl-2 col-6">
                            <label for="longitude">Longitude</label>
                            <input id="longitude" onchange="LoadPreview()" placeholder="" name="longitude" class="form-control" value="" data-reload-qr-code />
                        </div>
                    </div>
                                `;
            $('#CoEntry').append(contentHtml);
            coClicked = true;
        } else {
            $('#CoEntry').show();
        }
    });
</script>
<script>
    function initAutocomplete() {
        new google.maps.places.Autocomplete(
            (document.getElementById('ship-address')), {
                types: ['geocode']
            }
        );
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC8qMRqcnP5x7y15lRD1Arl56PRVEUv5r4&libraries=places&callback=initAutocomplete" async defer></script>

<!-- <script>
    (function($, window, document, undefined) {
        var pluginName = "formRepeater",
            defaults = {
                addBtnId: "#addPhone",
            };

        function Plugin(element, options) {
            this.container = $(element);
            this.options = $.extend({}, defaults, options);
            this._defaults = defaults;
            this._name = pluginName;
            this.init();
        }

        Plugin.prototype.init = function() {
            var rows = $("#phoneBlock", this.container);

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

    $("#myform").formRepeater();
</script>

<script>
    (function($, window, document, undefined) {
        var pluginName = "formRepeater2",
            defaults = {
                addBtnId: "#addEmail",
            };

        function Plugin(element, options) {
            this.container = $(element);
            this.options = $.extend({}, defaults, options);
            this._defaults = defaults;
            this._name = pluginName;
            this.init();
        }

        Plugin.prototype.init = function() {
            var rows = $("#emailBlock", this.container);

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
    (function($, window, document, undefined) {
        var pluginName = "formRepeater3",
            defaults = {
                addBtnId: "#addWebsite",
            };

        function Plugin(element, options) {
            this.container = $(element);
            this.options = $.extend({}, defaults, options);
            this._defaults = defaults;
            this._name = pluginName;
            this.init();
        }

        Plugin.prototype.init = function() {
            var rows = $("#websiteBlock", this.container);

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

    $("#myform").formRepeater3();
</script> -->