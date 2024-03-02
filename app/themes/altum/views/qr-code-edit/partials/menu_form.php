<?php defined('ALTUMCODE') || die() ?>

<div id="step2_form">

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
                    <input type="hidden" id="preview_link" name="preview_link" class="form-control" data-reload-qr-code />
                    <input type="hidden" id="preview_link2" name="preview_link2" class="form-control" data-reload-qr-code />
                    <input type="hidden" id="uId" name="uId" class="form-control" value="<?= uniqid() ?>" data-reload-qr-code />
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
        <button class="btn accodianBtn" type="button" data-toggle="collapse" data-target="#acc_menuInfo" aria-expanded="true" aria-controls="acc_menuInfo">
            <span>Menu information</span>
            <svg class="MuiSvgIcon-root MuiSvgIcon-colorPrimary leftArrow" focusable="false" viewBox="0 0 16 16" aria-hidden="true" style="font-size: 16px;">
                <path d="M12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5ZM12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5Z"></path>
            </svg>
        </button>
        <div class="collapse show" id="acc_menuInfo">
            <div class="collapseInner">
                <!-- <div class="form-group">
                    <label for="companyLogo"><i class="fa fa-fw fa-link fa-sm mr-1"></i> <?= l('qr_codes.input.companyLogo') ?></label>
                    <input type="file" id="images" name="companyLogo" class="form-control py-2" value="" accept="image/png, image/gif, image/jpeg" required="required" data-reload-qr-code />
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
                <div class="form-group">
                    <label for="companyTitle"> <?= l('qr_codes.input.companyTitle') ?></label>
                    <input id="companyTitle" name="companyTitle" onchange="LoadPreview()" placeholder="E.g. Ristorante Tavolo Grande" class="form-control" value="" maxlength="<?= $data->qr_code_settings['type']['menu']['companyTitle']['max_length'] ?>" required data-reload-qr-code />
                </div>
                <div class="form-group m-0">
                    <label for="companyDescription"> <?= l('qr_codes.input.companyDescription') ?></label>
                    <input id="companyDescription" name="companyDescription" onchange="LoadPreview()" placeholder="E.g. Italian Trattoria" class="form-control" value="" maxlength="<?= $data->qr_code_settings['type']['menu']['companyDescription']['max_length'] ?>" required data-reload-qr-code />
                </div>
            </div>
        </div>
    </div>

    <div class="custom-accodian">
        <button class="btn accodianBtn" type="button" data-toggle="collapse" data-target="#acc_product" aria-expanded="true" aria-controls="acc_product">
            <span>Menu</span>
            <svg class="MuiSvgIcon-root MuiSvgIcon-colorPrimary leftArrow" focusable="false" viewBox="0 0 16 16" aria-hidden="true" style="font-size: 16px;">
                <path d="M12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5ZM12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5Z"></path>
            </svg>
        </button>
        <div class="collapse show" id="acc_product">
            <div class="collapseInner collapseInner1">
                <div id="add_section">
                    <div class="form-group mb-2 d-flex align-items-center justify-content-between">
                        <p class="paraheading mb-0">Section</p>
                        <div class="d-flex align-items-center">
                            <button type="button" class="formCustomBtn mr-3 " onclick="remove_me_up(this)" style="display: none;">
                                <svg class="MuiSvgIcon-root" color="#FE4256" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 24px;">
                                    <path d="M20,7H4A1,1,0,0,0,4,9H5.08l.77,9.25a3,3,0,0,0,3,2.75h6.32a3,3,0,0,0,3-2.75L18.92,9H20a1,1,0,0,0,0-2ZM16.16,18.08a1,1,0,0,1-1,.92H8.84a1,1,0,0,1-1-.92L7.09,9h9.82Z"></path>
                                    <path d="M9,5h6a1,1,0,0,0,0-2H9A1,1,0,0,0,9,5Z"></path>
                                </svg>
                            </button>
                            <!-- <button type="button" class="formCustomBtn formMenuBtn">
                                <svg class="MuiSvgIcon-root" color="#94969C" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 24px;">
                                    <path d="M20,17H4a1,1,0,0,0,0,2H20a1,1,0,0,0,0-2Z"></path>
                                    <path d="M20,11H4a1,1,0,0,0,0,2H20a1,1,0,0,0,0-2Z"></path>
                                    <path d="M4,7H20a1,1,0,0,0,0-2H4A1,1,0,0,0,4,7Z"></path>
                                </svg>
                            </button> -->
                        </div>
                    </div>
                    <div class="form-group col-12">
                        <label for="sectionNames"> <?= l('qr_codes.input.name') ?></label>
                        <input class="form-control" id="sectionNames" type="text" onchange="LoadPreview()" name="sectionNames[]" placeholder="E.g. Desserts" required="required" data-reload-qr-code />
                    </div>
                    <div class="form-group col-12 m-0">
                        <label for="productDescriptions"> <?= l('qr_codes.input.description') ?></label>
                        <input class="form-control" id="sectionDescriptions" type="text" onchange="LoadPreview()" name="sectionDescriptions[]" placeholder="E.g. Selection of homemade desserts" required="required" data-reload-qr-code />
                    </div>
                    <div id="add_product">
                        <div class="productAccodian">
                            <div class="custom-accodian mb-0">
                                <div class="d-flex justify-content-between mb-3">
                                    <!-- <button class="btn accodianBtn justify-content-start p-0" type="button" data-toggle="collapse" data-target="#acc_prodactname" aria-expanded="true" aria-controls="acc_prodactname"> -->
                                    <button class="btn accodianBtn justify-content-start p-0" type="button" data-target="#acc_prodactname" aria-expanded="true" aria-controls="acc_prodactname">

                                        <!-- <svg class="MuiSvgIcon-root MuiSvgIcon-colorPrimary leftArrow blackLeftArrow" color="#220E27" focusable="false" viewBox="0 0 16 16" aria-hidden="true" style="font-size: 16px;">
                                            <path d="M12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5ZM12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5Z"></path>
                                        </svg> -->
                                        <p class="paraheading mb-0 ml-3"><?= l('qr_codes.input.productName') ?></p>
                                    </button>
                                    <div class="d-flex align-items-center">
                                        <button type="button" class="formCustomBtn mr-3" onclick="remove_me_up(this)" style="display: none;">
                                            <svg class="MuiSvgIcon-root" color="#FE4256" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 24px;">
                                                <path d="M20,7H4A1,1,0,0,0,4,9H5.08l.77,9.25a3,3,0,0,0,3,2.75h6.32a3,3,0,0,0,3-2.75L18.92,9H20a1,1,0,0,0,0-2ZM16.16,18.08a1,1,0,0,1-1,.92H8.84a1,1,0,0,1-1-.92L7.09,9h9.82Z"></path>
                                                <path d="M9,5h6a1,1,0,0,0,0-2H9A1,1,0,0,0,9,5Z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="collapse show" id="acc_prodactname">
                                    <div class="collapseInner p-0">
                                        <div class="welcome-screen">
                                            <span>Image</span>
                                            <!-- Before Upload Priview -->
                                            <div class="screen-upload mb-4">
                                                <label for="productImages">
                                                    <input type="file" onchange="setTimeout(function() { console.log('here'); document.getElementById('loader').style.display = 'block'; document.getElementById('iframesrc').style.visibility = 'hidden'; LoadPreview(); }, 5000);" id="productImages" name="productImages[]" class="form-control py-2" accept="image/png, image/gif, image/jpeg" required="required" data-reload-qr-code />
                                                    <div class="input-image">
                                                        <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 60 60" aria-hidden="true" style="font-size: 60px;">
                                                            <path d="M19.24,26.79a8.17,8.17,0,1,0-8.17-8.17A8.17,8.17,0,0,0,19.24,26.79Zm0-14.34a6.17,6.17,0,1,1-6.17,6.17A6.18,6.18,0,0,1,19.24,12.45Z"></path>
                                                            <path d="M56.75,49.34,39.18,29.26a1,1,0,0,0-1.46-.05L25.09,41.84,19.1,35a1,1,0,0,0-.72-.34.93.93,0,0,0-.74.29L3.29,49.29a1,1,0,0,0,1.42,1.42L18.3,37.12,30.14,50.66a1,1,0,0,0,.76.34,1,1,0,0,0,.66-.25,1,1,0,0,0,.09-1.41l-5.24-6,12-12L55.25,50.66A1,1,0,0,0,56,51a1,1,0,0,0,.75-1.66Z"></path>
                                                        </svg>
                                                    </div>
                                                    <div class="add-icon">
                                                        <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                                            <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"></path>
                                                        </svg>
                                                    </div>
                                                </label>
                                            </div>


                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-6 col-sm-12">
                                                <label for="productNames"> <?= l('qr_codes.input.name') ?></label>
                                                <input class="form-control" type="text" onchange="LoadPreview()" name="productNames[]" placeholder="E.g. Rice Pudding" required="required" data-reload-qr-code />
                                            </div>
                                            <div class="form-group col-md-6 col-sm-12">
                                                <label for="productNamesTranslated">Translated name (optional)</label>
                                                <input class="form-control" type="text" id="productNamesTranslated" onchange="LoadPreview()" name="productNamesTranslated[]" placeholder="E.g. Arroz con leche" data-reload-qr-code />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="productDescriptions"> <?= l('qr_codes.input.description') ?></label>
                                            <input class="form-control" type="text" id="productDescriptions" onchange="LoadPreview()" name="productDescriptions[]" placeholder="E.g. As good as your grandmother's" required="required" data-reload-qr-code />
                                        </div>
                                        <div class="form-group col-md-6 col-sm-12 p-0">
                                            <label for="productPrices">Price (optional)</label>
                                            <input class="form-control" type="text" id="productPrices" name="productPrices[]" onchange="LoadPreview()" placeholder="E.g. £4.50" data-reload-qr-code />
                                        </div>
                                        <!-- <div class="form-group m-0" style="visibility:hidden">
                                            <label for="productIcon">Allergens</label>

                                            <div class="socialIconContain productIcon">
                                                <ul class="ks-cboxtags facilitiesIcon">
                                                    <?php for ($i = 1; $i < 15; $i++) { ?>

                                                        <li data-toggle="" data-placement="bottom" title="ficon">
                                                            <input type="checkbox" id="allergensIcon<?= $i ?>" name="allergensIcon<?= $i ?>" data-reload-qr-code>
                                                            <label for="allergensIcon<?= $i ?>" class="boxtagLabel">
                                                                <?php echo file_get_contents(ASSETS_FULL_URL . 'images/menuproduct/picon' . $i . '.svg'); ?>
                                                            </label>
                                                        </li>

                                                    <?php } ?>
                                                </ul>
                                            </div>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="productAccodianbutton">
                        <button id="add1" type="button" class="outlineBtn addRowButton"><i class="fa fa-fw fa-plus fa-sm mr-1 smIcon"></i> Add product</button>
                    </div>
                </div>
            </div>
            <!-- <div class="productSectionBtn">
                <button id="add" class="outlineBtn addRowButton"><i class="fa fa-fw fa-plus fa-sm mr-1 smIcon"></i> Add Section</button>
            </div> -->
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
    <!-- <?php include_once('accodian-form-group/tracking-analytics.php'); ?> -->

    <!-- <div class="form-group" data-type="menu">
        <input type="hidden" id="uId" name="uId" class="form-control" value="<?= uniqid() ?>" data-reload-qr-code />

        <label for="name"> <?= l('qr_codes.input.qrname') ?></label>
        <input id="name" name="name" class="form-control" value="" maxlength="<?= $data->qr_code_settings['type']['menu']['name']['max_length'] ?>" required="required" data-reload-qr-code />

        <label for="primaryColor"> <?= l('qr_codes.input.primaryColor') ?></label>
        <input type="color" id="primaryColor" name="primaryColor" class="form-control" value="#0099ff" data-reload-qr-code />

        <label for="secondryColor"> <?= l('qr_codes.input.secondryColor') ?></label>
        <input type="color" id="secondryColor" name="secondryColor" class="form-control" value="#0099ff" data-reload-qr-code />

        <h4>Menu information</h4>
        <label for="companyLogo"><i class="fa fa-fw fa-link fa-sm mr-1"></i> <?= l('qr_codes.input.companyLogo') ?></label>
        <input type="file" id="images" name="companyLogo" class="form-control" value="" accept="image/png, image/gif, image/jpeg" required="required" data-reload-qr-code />
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

        <label for="companyTitle"> <?= l('qr_codes.input.companyTitle') ?></label>
        <input id="companyTitle" name="companyTitle" class="form-control" value="" maxlength="<?= $data->qr_code_settings['type']['menu']['companyTitle']['max_length'] ?>" required="required" data-reload-qr-code />

        <label for="companyDescription"> <?= l('qr_codes.input.companyDescription') ?></label>
        <input id="companyDescription" name="companyDescription" class="form-control" value="" maxlength="<?= $data->qr_code_settings['type']['menu']['companyDescription']['max_length'] ?>" required="required" data-reload-qr-code />

        <h4>Products</h4>
        <div id="add_product" class="row" style="margin-right: 0 !important;margin-left: 0 !important;">
            <label for="productNames"> <?= l('qr_codes.input.productName') ?></label>
            <input class="form-control" type="text" name="productNames[]" placeholder="E.g. Rice Pudding" required="required" />

            <label for="productDescriptions"> <?= l('qr_codes.input.productDescription') ?></label>
            <input class="form-control" type="text" name="productDescriptions[]" placeholder="E.g. Arroz con leche" required="required" />

            <label for="productPrices"> <?= l('qr_codes.input.productPrice') ?></label>
            <input class="form-control" type="text" name="productPrices[]" placeholder="E.g. £4.50" required="required" />

            <label for="productImages"><i class="fa fa-fw fa-image fa-sm mr-1"></i> <?= l('qr_codes.input.image') ?></label>
            <input type="file" id="images" name="productImages[]" class="form-control" value="" accept="image/png, image/gif, image/jpeg" multiple required="required" />
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


        </div>
        <div>
            <button id="add" class="delete btn btn-outline-primary mt-4"><i class="fa fa-fw fa-plus fa-sm mr-1"></i> Add product</button>
        </div>
        
        <div class="form-group">
            <label for="password"> Password</label>
            <input id="password" type="password" name="password" class="form-control" value="" maxlength="30" data-reload-qr-code />
        </div>
        
        
    </div> -->
</div>
<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script>
    var image_uploaded = false;
    // var base_url = 'http://localhost/qr-new/'
    var base_url = '<?php echo SITE_URL?>'

    function LoadPreview(welcome_screen = false) {
        let uId = document.getElementById('uId').value;
        let primaryColor = document.getElementById('primaryColor').value;
        let SecondaryColor = document.getElementById('SecondaryColor').value;
        let companyLogo = document.getElementById('companyLogo').files;
        let companyTitle = document.getElementById('companyTitle').value;
        let companyDescription = document.getElementById('companyDescription').value;
        let sectionNames = $("input[name='sectionNames[]']").map(function() {
            return $(this).val();
        }).get();
        let sectionDescriptions = $("input[name='sectionDescriptions[]']").map(function() {
            return $(this).val();
        }).get();
        let productImages = document.getElementById('productImages').files;
        let productNames = $("input[name='productNames[]']").map(function() {
            return $(this).val();
        }).get();
        let productNamesTranslated = $("input[name='productNamesTranslated[]']").map(function() {
            return $(this).val();
        }).get();
        let productDescriptions = $("input[name='productDescriptions[]']").map(function() {
            return $(this).val();
        }).get();
        let productPrices = $("input[name='productPrices[]']").map(function() {
            return $(this).val();
        }).get();
        // let screen = document.getElementById('screen').files;
        let font_title = document.getElementById('filters_title_by').value;
        let font_text = document.getElementById('filters_text_by').value;
        var filesscreen = document.getElementById("screen").files;
        var screen = filesscreen && filesscreen.length ? base_url + "uploads/screen/" + uId + "_" + filesscreen[0].name + "" : "";
        var companyLogoFile = companyLogo && companyLogo.length ? base_url + "uploads/menu/" + uId + "_companyLogo_" + companyLogo[0].name + "" : "";

        // var all_companyLogo = [];
        // for (var i = 0; i < companyLogo.length; i++) {
        //     var image1 = base_url + "uploads/menu/" + uId + "_" + i + "_companyLogo_" + companyLogo[i].name + "";
        //     all_companyLogo.push(image1)
        // }


        var all_productImages = [];
        for (var i = 0; i < productImages.length; i++) {
            var image2 = base_url + "uploads/menu/" + uId + "_" + i + "_productImages_" + productImages[i].name + "";
            all_productImages.push(image2)
        }
        // var values = $("input[name='productNames[]']").map(function() {return $(this).val();}).get();
        // console.log("productNames", values)
        let link = `<?php echo LANDING_PAGE_URL;?>menu?primaryColor=${primaryColor.replace("#","")}&SecondaryColor=${SecondaryColor.replace("#","")}&companyLogo=${companyLogoFile}&companyTitle=${companyTitle}&companyDescription=${companyDescription}&sectionNames=${JSON.stringify(sectionNames)}&sectionDescriptions=${JSON.stringify(sectionDescriptions)}&productImages=${JSON.stringify(all_productImages)}&productNames=${JSON.stringify(productNames)}&productNamesTranslated=${JSON.stringify(productNamesTranslated)}&productDescriptions=${JSON.stringify(productDescriptions)}&productPrices=${JSON.stringify(productPrices)}&screen=${screen}&font_title=${font_title}&font_text=${font_text}`
        if (!welcome_screen) {
            link = `<?php echo LANDING_PAGE_URL;?>menu?primaryColor=${primaryColor.replace("#","")}&SecondaryColor=${SecondaryColor.replace("#","")}&companyLogo=${companyLogoFile}&companyTitle=${companyTitle}&companyDescription=${companyDescription}&sectionNames=${JSON.stringify(sectionNames)}&sectionDescriptions=${JSON.stringify(sectionDescriptions)}&productImages=${JSON.stringify(all_productImages)}&productNames=${JSON.stringify(productNames)}&productNamesTranslated=${JSON.stringify(productNamesTranslated)}&productDescriptions=${JSON.stringify(productDescriptions)}&productPrices=${JSON.stringify(productPrices)}&font_title=${font_title}&font_text=${font_text}`
        }
        document.getElementById('iframesrc').src = link;
        document.getElementById("loader").style.display = "none";
        document.getElementById("iframesrc").style.visibility = "visible";
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

    $('.colorPalette').on('click', function(e) {

        //    input.addclass document.getElementById("iframesrc").style.visibility = "visible";
        element.classList.add("active");
        console.log("werwereww");
        //    element.classList.remove("active");
    });
</script>
<script src="<?= ASSETS_FULL_URL ?>js/qr_form.js"></script>

<!-- <script>
    (function($, window, document, undefined) {
        var pluginName = "formRepeater",
            defaults = {
                addBtnId: "#add",
            };

        function Plugin(element, options) {
            this.container = $(element);
            this.options = $.extend({}, defaults, options);
            this._defaults = defaults;
            this._name = pluginName;
            this.init();
        }

        Plugin.prototype.init = function() {
            var rows = $("#add_section", this.container);

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
            // $(group).append("+");
            // console.log("added field", parseInt(groupIndex) + 1)
            if (parseInt(groupIndex) + 1 != 1) {
                $(group).find('div.form-group.mb-2.d-flex.align-items-center.justify-content-between > div > button:first-child').addClass('dis-block');
                // $('.Section ' + (parseInt(groupIndex) + 1).toString()).attr('onClick', 'remove_me_up(this)');
                $(group).find('div > p:first-child').text('Section ' + (parseInt(groupIndex) + 1).toString());
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
</script> -->

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
                $(group).find('div > div > div.d-flex.justify-content-between.mb-3 > div > button:first-child').addClass('dis-block');
                // $('.Section ' + (parseInt(groupIndex) + 1).toString()).attr('onClick', 'remove_me_up(this)');
                // $(group).find('div > p:first-child').text('Section ' + (parseInt(groupIndex) + 1).toString());
                // $(group).find('div > div > div > button > p').text('Product ' + (parseInt(groupIndex) + 1).toString());

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