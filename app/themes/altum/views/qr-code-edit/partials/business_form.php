<?php defined('ALTUMCODE') || die() ?>

<input type="hidden" id="uId" name="uId" class="form-control" value="<?= uniqid() ?>" data-reload-qr-code />
<input type="hidden" id="preview_link" name="preview_link" class="form-control" data-reload-qr-code />
<input type="hidden" id="preview_link2" name="preview_link2" class="form-control" data-reload-qr-code />
<style>
    .addPhone .removeBtn {
        padding-top: 0px !important;
    }
</style>
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

                    <input id="name" name="name" placeholder="E.g. My QR code" class="form-control" value="" maxlength="<?= $data->qr_code_settings['type']['business']['name']['max_length'] ?>" required="required" data-reload-qr-code />
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
        <button class="btn accodianBtn" type="button" data-toggle="collapse" data-target="#acc_businessInfo" aria-expanded="true" aria-controls="acc_businessInfo">
            <span>Business information</span>
            <svg class="MuiSvgIcon-root MuiSvgIcon-colorPrimary leftArrow" focusable="false" viewBox="0 0 16 16" aria-hidden="true" style="font-size: 16px;">
                <path d="M12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5ZM12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5Z"></path>
            </svg>
        </button>
        <div class="collapse show" id="acc_businessInfo">
            <div class="collapseInner">
                <!-- <div class="form-group">
                    <label for="images"><i class="fa fa-fw fa-link fa-sm mr-1"></i> <?= l('qr_codes.input.companyLogo') ?></label>
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
                    <label for="company"> <?= l('qr_codes.input.company') ?></label>
                    <input id="company" onchange="LoadPreview()" name="company" class="form-control" value="" placeholder="E.g.Company LLC" maxlength="<?= $data->qr_code_settings['type']['menu']['companyTitle']['max_length'] ?>" required="required" data-reload-qr-code />
                </div>
                <div class="form-group">
                    <label for="companyTitle">Title</label>
                    <input id="companyTitle" onchange="LoadPreview()" name="companyTitle" class="form-control" value="" placeholder="E.g." maxlength="<?= $data->qr_code_settings['type']['menu']['companyDescription']['max_length'] ?>" required="required" data-reload-qr-code />
                </div>
                <div class="form-group">
                    <label for="companySubtitle">Subtitle</label>
                    <input id="companySubtitle" onchange="LoadPreview()" name="companySubtitle" class="form-control" value="" placeholder="E.g." maxlength="<?= $data->qr_code_settings['type']['menu']['companyDescription']['max_length'] ?>" required="required" data-reload-qr-code />
                </div>
                <div class=" mb-3 addBusinessButton addRow" id="add-btn">
                    <!-- <div class="form-group m-0">
                        <label for="contactMobiles"> <?= l('qr_codes.input.button') ?></label>
                        <div class="d-flex align-items-center w-100" id="add-btn">
                            <div class="d-flex align-items-center w-100">
                                <input class="form-control mr-3" type="text" name="businessButtons[]" placeholder="Write the button text here..." required="required" />
                                <input class="form-control mr-3" type="url" name="businessButtonUrls[]" placeholder="https://…" required="required" />
                            </div>
                            <button type="button" class="reapeterCloseIcon removeBtn" onclick="showButton(this)">
                                <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"></path>
                                </svg>
                            </button>
                        </div>
                    </div> -->
                </div>
                <div id="btn-item">
                    <button id="add" type="button" class="outlineBtn addRowButton"><i class="fa fa-fw fa-plus fa-sm mr-1 smIcon"></i> Add button</button>
                </div>
            </div>
        </div>
    </div>

    <div class="custom-accodian">
        <button class="btn accodianBtn" type="button" data-toggle="collapse" data-target="#acc_openingHours" aria-expanded="true" aria-controls="acc_openingHours">
            <span>Opening Hours</span>
            <svg class="MuiSvgIcon-root MuiSvgIcon-colorPrimary leftArrow" focusable="false" viewBox="0 0 16 16" aria-hidden="true" style="font-size: 16px;">
                <path d="M12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5ZM12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5Z"></path>
            </svg>
        </button>
        <div class="collapse show" id="acc_openingHours">
            <div class="collapseInner p-0">
                <div class="form-group m-0">
                    <!-- <div class="couponLocation couponLocation1">
                        <div class="couponButtonGroup d-block m-0">
                            <button type="button" class="outlineBtn squreBtn active squreSmallBtn" id="ampm">am/pm</button>
                            <button type="button" class="outlineBtn squreBtn squreSmallBtn ml-2" id="24hr">24 hrs</button>
                        </div>
                    </div> -->
                    <!-- <h4>Opening Hours</h4> -->
                    <!-- <div id="Sunday" class="day"></div>
                    <div id="Monday" class="day"></div>
                    <div id="Tuesday" class="day"></div>
                    <div id="Wednesday" class="day"></div>
                    <div id="Thursday" class="day"></div>
                    <div id="Friday" class="day"></div>
                    <div id="Saturday" class="day"></div> -->
                    <div class="checkboxBorder">
                        <div class="col-4 d-flex align-items-center p-0">
                            <div class="roundCheckbox">
                                <input type="checkbox" id="checkboxMon" />
                                <label class="m-0" for="checkboxMon"></label>
                            </div>
                            <label class="m-0">Monday</label>
                        </div>
                        <div class="name col-4">
                            <input type="time" id="Monday_From" onchange="LoadPreview()" name="Monday_From" placeholder="From" class="form-control Monday_From" disabled data-reload-qr-code />

                        </div>
                        <div class="name col-4">
                            <input type="time" id="Monday_To" name="Monday_To" onchange="LoadPreview()" placeholder="To" class="form-control Monday_To" disabled data-reload-qr-code />

                        </div>
                    </div>
                    <div class="checkboxBorder">
                        <div class="col-4 d-flex align-items-center p-0">
                            <div class="roundCheckbox">
                                <input type="checkbox" id="checkboxTue" />
                                <label class="m-0" for="checkboxTue"></label>
                            </div>
                            <label class="m-0">Tuesday</label>
                        </div>
                        <div class="name col-4">
                            <input type="time" id="Tuesday_From" name="Tuesday_From" onchange="LoadPreview()" placeholder="From" class="form-control Tuesday_From" disabled data-reload-qr-code />

                        </div>
                        <div class="name col-4">
                            <input type="time" id="Tuesday_To" name="Tuesday_To" onchange="LoadPreview()" placeholder="To" class="form-control Tuesday_To" disabled data-reload-qr-code />

                        </div>
                    </div>
                    <div class="checkboxBorder">
                        <div class="col-4 d-flex align-items-center p-0">
                            <div class="roundCheckbox">
                                <input type="checkbox" id="checkboxWed" />
                                <label class="m-0" for="checkboxWed"></label>
                            </div>
                            <label class="m-0">Wednesday</label>
                        </div>
                        <div class="name col-4">
                            <input type="time" id="Wednesday_From" name="Wednesday_From" onchange="LoadPreview()" placeholder="From" class="form-control Wednesday_From" disabled data-reload-qr-code />

                        </div>
                        <div class="name col-4">
                            <input type="time" id="Wednesday_To" name="Wednesday_To" onchange="LoadPreview()" placeholder="To" class="form-control Wednesday_To" disabled data-reload-qr-code />

                        </div>
                    </div>
                    <div class="checkboxBorder">
                        <div class="col-4 d-flex align-items-center p-0">
                            <div class="roundCheckbox">
                                <input type="checkbox" id="checkboxThu" />
                                <label class="m-0" for="checkboxThu"></label>
                            </div>
                            <label class="m-0">Thursday</label>
                        </div>
                        <div class="name col-4">
                            <input type="time" id="Thursday_From" name="Thursday_From" onchange="LoadPreview()" placeholder="From" class="form-control Thursday_From" disabled data-reload-qr-code />

                        </div>
                        <div class="name col-4">
                            <input type="time" id="Thursday_To" name="Thursday_To" onchange="LoadPreview()" placeholder="To" class="form-control Thursday_To" disabled data-reload-qr-code />

                        </div>
                    </div>
                    <div class="checkboxBorder">
                        <div class="col-4 d-flex align-items-center p-0">
                            <div class="roundCheckbox">
                                <input type="checkbox" id="checkboxFri" />
                                <label class="m-0" for="checkboxFri"></label>
                            </div>
                            <label class="m-0">Friday</label>
                        </div>
                        <div class="name col-4">
                            <input type="time" id="Friday_From" name="Friday_From" onchange="LoadPreview()" placeholder="From" class="form-control Friday_From" disabled data-reload-qr-code />

                        </div>
                        <div class="name col-4">
                            <input type="time" id="Friday_To" name="Friday_To" onchange="LoadPreview()" placeholder="To" class="form-control Friday_To" disabled data-reload-qr-code />

                        </div>
                    </div>
                    <div class="checkboxBorder">
                        <div class="col-4 d-flex align-items-center p-0">
                            <div class="roundCheckbox">
                                <input type="checkbox" id="checkboxSat" />
                                <label class="m-0" for="checkboxSat"></label>
                            </div>
                            <label class="m-0">Saturday</label>
                        </div>
                        <div class="name col-4">
                            <input type="time" id="Saturday_From" name="Saturday_From" onchange="LoadPreview()" placeholder="From" class="form-control Saturday_From" disabled data-reload-qr-code />

                        </div>
                        <div class="name col-4">
                            <input type="time" id="Saturday_To" name="Saturday_To" onchange="LoadPreview()" placeholder="To" class="form-control Saturday_To" disabled data-reload-qr-code />

                        </div>
                    </div>
                    <div class="checkboxBorder">
                        <div class="col-4 d-flex align-items-center p-0">
                            <div class="roundCheckbox">
                                <input type="checkbox" id="checkboxSun" />
                                <label class="m-0" for="checkboxSun"></label>
                            </div>
                            <label class="m-0">Sunday</label>
                        </div>
                        <div class="name col-4">
                            <input type="time" id="Sunday_From" name="Sunday_From" onchange="LoadPreview()" placeholder="From" class="form-control Sunday_From" disabled data-reload-qr-code />

                        </div>
                        <div class="name col-4">
                            <input type="time" id="Sunday_To" name="Sunday_To" onchange="LoadPreview()" placeholder="To" class="form-control Sunday_To" disabled data-reload-qr-code />

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="custom-accodian">
        <button class="btn accodianBtn" type="button" data-toggle="collapse" data-target="#acc_location" aria-expanded="true" aria-controls="acc_location">
            <span>Location</span>
            <svg class="MuiSvgIcon-root MuiSvgIcon-colorPrimary leftArrow" focusable="false" viewBox="0 0 16 16" aria-hidden="true" style="font-size: 16px;">
                <path d="M12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5ZM12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5Z"></path>
            </svg>
        </button>
        <div class="collapse show" id="acc_location">
            <div class="collapseInner">
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
                            <label for="ship_address">Search address</label>
                            <input id="ship_address" name="ship_address" autocomplete="off" onchange="LoadPreview()" placeholder="" class="form-control" value="" data-reload-qr-code />
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

            </div>
        </div>
    </div>

    <div class="custom-accodian">
        <button class="btn accodianBtn" type="button" data-toggle="collapse" data-target="#acc_facilities" aria-expanded="true" aria-controls="acc_facilities">
            <span>Facilities</span>
            <svg class="MuiSvgIcon-root MuiSvgIcon-colorPrimary leftArrow" focusable="false" viewBox="0 0 16 16" aria-hidden="true" style="font-size: 16px;">
                <path d="M12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5ZM12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5Z"></path>
            </svg>
        </button>
        <div class="collapse show" id="acc_facilities">
            <div class="collapseInner">
                <div class="form-group m-0">
                    <ul class="ks-cboxtags facilitiesIcon">
                        <li data-toggle="" data-placement="bottom" title="ficon">
                            <input type="checkbox" id="ficon" name="ficon" data-reload-qr-code>
                            <label for="ficon" class="boxtagLabel">
                                <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 32 32" aria-hidden="true" style="font-size: 32px;">
                                    <path d="M16,20.55a2.73,2.73,0,1,0,2.73,2.72A2.72,2.72,0,0,0,16,20.55Z"></path>
                                    <path d="M29.43,10.6a19.1,19.1,0,0,0-27,0,1,1,0,0,0,0,1.41,1,1,0,0,0,1.42,0A17.09,17.09,0,0,1,28,12a1,1,0,0,0,1.42,0A1,1,0,0,0,29.43,10.6Z"></path>
                                    <path d="M15.92,9.89a14.12,14.12,0,0,0-10,4.17,1,1,0,0,0,0,1.41,1,1,0,0,0,1.42,0,12.19,12.19,0,0,1,17.26,0,1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.41A14.12,14.12,0,0,0,15.92,9.89Z"></path>
                                    <path d="M15.92,14.79a9.26,9.26,0,0,0-6.59,2.73,1,1,0,0,0,0,1.41,1,1,0,0,0,1.42,0,7.32,7.32,0,0,1,10.34,0,1,1,0,0,0,.71.29,1,1,0,0,0,.71-.29,1,1,0,0,0,0-1.41A9.26,9.26,0,0,0,15.92,14.79Z"></path>
                                </svg>
                            </label>
                        </li>
                        <li data-toggle="" data-placement="bottom" title="ficon1">
                            <input type="checkbox" id="ficon1" name="ficon1" data-reload-qr-code>
                            <label for="ficon1" class="boxtagLabel">
                                <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 32 32" aria-hidden="true" style="font-size: 32px;">
                                    <path d="M26.93,15.8A3.5,3.5,0,0,0,24,13V10a5,5,0,0,0-5-5H13a5,5,0,0,0-5,5v3a3.51,3.51,0,0,0-2.93,2.78A3.82,3.82,0,0,0,5,16.5V19a4.5,4.5,0,0,0,.16,1.25,5,5,0,0,0,3.58,3.57A3.63,3.63,0,0,0,8,26a1,1,0,0,0,2,0,2.3,2.3,0,0,1,2.5-2h7A2.3,2.3,0,0,1,22,26a1,1,0,0,0,2,0,3.63,3.63,0,0,0-.74-2.18,4.94,4.94,0,0,0,3.57-3.55A4.38,4.38,0,0,0,27,19V16.5A4.26,4.26,0,0,0,26.93,15.8ZM13,7h6a3,3,0,0,1,3,3v3.35a3.51,3.51,0,0,0-1.93,2.47,3.82,3.82,0,0,0-.07.68V17H12v-.5a4.26,4.26,0,0,0-.07-.7A3.5,3.5,0,0,0,10,13.35V10A3,3,0,0,1,13,7ZM25,19a2.61,2.61,0,0,1-.1.75A3,3,0,0,1,22,22H10a3,3,0,0,1-2.91-2.27A2.75,2.75,0,0,1,7,19V16.5a1.32,1.32,0,0,1,0-.3,1.5,1.5,0,0,1,2.94,0,1.66,1.66,0,0,1,0,.32V18a1,1,0,0,0,1,1H21a1,1,0,0,0,1-1V16.5a1.32,1.32,0,0,1,0-.3,1.5,1.5,0,0,1,2.94,0,1.66,1.66,0,0,1,0,.32Z"></path>
                                </svg>
                            </label>
                        </li>
                        <li data-toggle="" data-placement="bottom" title="ficon2">
                            <input type="checkbox" id="ficon2" name="ficon2" data-reload-qr-code>
                            <label for="ficon2" class="boxtagLabel">
                                <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 32 32" aria-hidden="true" style="font-size: 32px;">
                                    <path d="M18.13,23a1,1,0,0,0-1.31.53A4.08,4.08,0,1,1,11.88,18a1,1,0,0,0-.6-1.92,6.11,6.11,0,1,0,7.38,8.24A1,1,0,0,0,18.13,23Z"></path>
                                    <circle cx="15" cy="7" r="2"></circle>
                                    <path d="M22.27,20,16,18.25V14l1.2,1.6a1,1,0,0,0,.8.4h3a1,1,0,0,0,0-2H18.5l-2.7-3.6-.05-.05-.15-.13a.54.54,0,0,0-.16-.1l-.17-.07-.2,0H15l-.12,0-.19,0-.19.09-.1,0-.05.05-.13.15a.91.91,0,0,0-.11.16l-.06.17c0,.07,0,.13,0,.2S14,11,14,11v8a1,1,0,0,0,.73,1L21,21.75V27a1,1,0,0,0,2,0V21A1,1,0,0,0,22.27,20Z"></path>
                                </svg>
                            </label>
                        </li>
                        <li data-toggle="" data-placement="bottom" title="ficon3">
                            <input type="checkbox" id="ficon3" name="ficon3" data-reload-qr-code>
                            <label for="ficon3" class="boxtagLabel">
                                <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 32 32" aria-hidden="true" style="font-size: 32px;">
                                    <circle cx="10" cy="6" r="2"></circle>
                                    <path d="M13,9H7a1,1,0,0,0-1,1v9a1,1,0,0,0,1,1H8v7a1,1,0,0,0,1,1h2a1,1,0,0,0,1-1V20h1a1,1,0,0,0,1-1V10A1,1,0,0,0,13,9Zm-1,9H8V11h4Z"></path>
                                    <circle cx="22" cy="6" r="2"></circle>
                                    <path d="M24,9.8A1,1,0,0,0,23,9H21a1,1,0,0,0-1,.8l-2,10a1,1,0,0,0,.21.83A1,1,0,0,0,19,21h1v6a1,1,0,0,0,1,1h2a1,1,0,0,0,1-1V21h1a1,1,0,0,0,.77-.37A1,1,0,0,0,26,19.8ZM21.82,11h.36l1.6,8H20.22Z"></path>
                                </svg>
                            </label>
                        </li>
                        <li data-toggle="" data-placement="bottom" title="ficon4">
                            <input type="checkbox" id="ficon4" name="ficon4" data-reload-qr-code>
                            <label for="ficon4" class="boxtagLabel">
                                <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 32 32" aria-hidden="true" style="font-size: 32px;">
                                    <path d="M25,11a5,5,0,0,0-5-5H17a1,1,0,0,0-1,1v5H10.62l-.73-1.45A1,1,0,0,0,9,10H7a1,1,0,0,0,0,2H8.38L9,13.24V14a7,7,0,0,0,7,7h2a7,7,0,0,0,7-7V13a1,1,0,0,0-.15-.5A1,1,0,0,0,25,12Zm-7,8H16a5,5,0,0,1-5-5H23A5,5,0,0,1,18,19Zm0-7V8h2a3,3,0,0,1,3,3v1Z"></path>
                                    <circle cx="12.5" cy="24.5" r="2.5"></circle>
                                    <circle cx="21.5" cy="24.5" r="2.5"></circle>
                                </svg>
                            </label>
                        </li>
                        <li data-toggle="" data-placement="bottom" title="ficon5">
                            <input type="checkbox" id="ficon5" name="ficon5" data-reload-qr-code>
                            <label for="ficon5" class="boxtagLabel">
                                <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 32 32" aria-hidden="true" style="font-size: 32px;">
                                    <path d="M10,13V11a2,2,0,0,0-4,0v2a2,2,0,0,0,4,0Z"></path>
                                    <path d="M24,9a2,2,0,0,0-2,2v2a2,2,0,0,0,4,0V11A2,2,0,0,0,24,9Z"></path>
                                    <path d="M13,11a2,2,0,0,0,2-2V7a2,2,0,0,0-4,0V9A2,2,0,0,0,13,11Z"></path>
                                    <path d="M19,11a2,2,0,0,0,2-2V7a2,2,0,0,0-4,0V9A2,2,0,0,0,19,11Z"></path>
                                    <path d="M20,13.71A5,5,0,0,0,16.19,12h-.38a5,5,0,0,0-3.76,1.71L7.86,18.5A5,5,0,0,0,7,23.65l.09.21A5,5,0,0,0,11.71,27h8.58a5,5,0,0,0,4.64-3.14l.09-.21a5,5,0,0,0-.88-5.15Zm3.21,9.19-.08.21A3,3,0,0,1,20.29,25H11.71a3,3,0,0,1-2.79-1.89l-.08-.21a3,3,0,0,1,.53-3.09L13.56,15a3,3,0,0,1,2.25-1h.38a3,3,0,0,1,2.25,1l4.19,4.79A3,3,0,0,1,23.16,22.9Z"></path>
                                </svg>
                            </label>
                        </li>
                        <li data-toggle="" data-placement="bottom" title="ficon6">
                            <input type="checkbox" id="ficon6" name="ficon6" data-reload-qr-code>
                            <label for="ficon6" class="boxtagLabel">
                                <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 32 32" aria-hidden="true" style="font-size: 32px;">
                                    <path d="M17.5,4H9A1,1,0,0,0,8,5V27a1,1,0,0,0,1,1h5a1,1,0,0,0,1-1V19h2.5a7.5,7.5,0,0,0,0-15Zm0,13H14a1,1,0,0,0-1,1v8H10V6h7.5a5.5,5.5,0,0,1,0,11Z"></path>
                                    <path d="M17.5,9H13v5h4.5a2.5,2.5,0,0,0,0-5Z"></path>
                                </svg>
                            </label>
                        </li>
                        <li data-toggle="" data-placement="bottom" title="ficon7">
                            <input type="checkbox" id="ficon7" name="ficon7" data-reload-qr-code>
                            <label for="ficon7" class="boxtagLabel">
                                <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 32 32" aria-hidden="true" style="font-size: 32px;">
                                    <path d="M21,4H11A5,5,0,0,0,6,9V24a1,1,0,0,0,1,1H8v2a1,1,0,0,0,1,1h2a1,1,0,0,0,1-1V25h8v2a1,1,0,0,0,1,1h2a1,1,0,0,0,1-1V25h1a1,1,0,0,0,1-1V9A5,5,0,0,0,21,4ZM8,14V10h7v4Zm9-4h7v4H17ZM11,6H21a3,3,0,0,1,2.82,2H8.18A3,3,0,0,1,11,6ZM24,23H8V16H24Z"></path>
                                    <circle cx="11.5" cy="19.5" r="1.5"></circle>
                                    <circle cx="20.5" cy="19.5" r="1.5"></circle>
                                </svg>
                            </label>
                        </li>
                        <li data-toggle="" data-placement="bottom" title="ficon8">
                            <input type="checkbox" id="ficon8" name="ficon8" data-reload-qr-code>
                            <label for="ficon8" class="boxtagLabel">
                                <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 32 32" aria-hidden="true" style="font-size: 32px;">
                                    <path d="M27,14.83s0-.07,0-.1L25.38,9.18A3,3,0,0,0,22.49,7H19V6a1,1,0,0,0-1-1H14a1,1,0,0,0-1,1V7H9.51A3,3,0,0,0,6.62,9.18L5,14.73s0,.07,0,.1A1,1,0,0,0,5,15V26a1,1,0,0,0,1,1H8a1,1,0,0,0,1-1V24H23v2a1,1,0,0,0,1,1h2a1,1,0,0,0,1-1V15A1,1,0,0,0,27,14.83ZM8,22H7V16H25v6H8ZM8.55,9.73a1,1,0,0,1,1-.73h13a1,1,0,0,1,1,.73L24.67,14H7.33Z"></path>
                                    <path d="M12,18H10a1,1,0,0,0,0,2h2a1,1,0,0,0,0-2Z"></path>
                                    <path d="M22,18H20a1,1,0,0,0,0,2h2a1,1,0,0,0,0-2Z"></path>
                                </svg>
                            </label>
                        </li>
                        <li data-toggle="" data-placement="bottom" title="ficon9">
                            <input type="checkbox" id="ficon9" name="ficon9" data-reload-qr-code>
                            <label for="ficon9" class="boxtagLabel">
                                <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 32 32" aria-hidden="true" style="font-size: 32px;">
                                    <path d="M25,11H15a1,1,0,0,0-1,1v4a1,1,0,0,0,1,1H27a1,1,0,0,0,1-1V14A3,3,0,0,0,25,11Zm1,4H16V13h9a1,1,0,0,1,1,1Z"></path>
                                    <path d="M27,18H6V11a1,1,0,0,0-2,0V22a1,1,0,0,0,2,0V20H26v2a1,1,0,0,0,2,0V19A1,1,0,0,0,27,18Z"></path>
                                    <circle cx="10.5" cy="14.5" r="2.5"></circle>
                                </svg>
                            </label>
                        </li>
                        <li data-toggle="" data-placement="bottom" title="ficon10">
                            <input type="checkbox" id="ficon10" name="ficon10" data-reload-qr-code>
                            <label for="ficon10" class="boxtagLabel">
                                <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 32 32" aria-hidden="true" style="font-size: 32px;">
                                    <path d="M25,11H6a1,1,0,0,0-1,1V23a5,5,0,0,0,5,5h8a5,5,0,0,0,5-5V21h2a3,3,0,0,0,3-3V14A3,3,0,0,0,25,11ZM21,23a3,3,0,0,1-3,3H10a3,3,0,0,1-3-3V13H21V23Zm5-5a1,1,0,0,1-1,1H23V13h2a1,1,0,0,1,1,1Z"></path>
                                    <path d="M10.36,8.23a1,1,0,0,0-.13,1.41A1,1,0,0,0,11,10a1,1,0,0,0,.64-.23c2.25-1.88,1.12-3.29.64-3.89A4.07,4.07,0,0,1,12,5.49s.05-.23.64-.72a1,1,0,1,0-1.28-1.54c-2.25,1.88-1.12,3.29-.64,3.89a4.07,4.07,0,0,1,.28.39S11,7.74,10.36,8.23Z"></path>
                                    <path d="M15.36,8.23a1,1,0,0,0-.13,1.41A1,1,0,0,0,16,10a1,1,0,0,0,.64-.23c2.25-1.88,1.12-3.29.64-3.89A4.07,4.07,0,0,1,17,5.49s.05-.23.64-.72a1,1,0,0,0-1.28-1.54c-2.25,1.88-1.12,3.29-.64,3.89a4.07,4.07,0,0,1,.28.39S16,7.74,15.36,8.23Z"></path>
                                </svg>
                            </label>
                        </li>
                        <li data-toggle="" data-placement="bottom" title="ficon11">
                            <input type="checkbox" id="ficon11" name="ficon11" data-reload-qr-code>
                            <label for="ficon11" class="boxtagLabel">
                                <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 32 32" aria-hidden="true" style="font-size: 32px;">
                                    <path d="M25.83,9.55a1,1,0,0,0,.05-1A1,1,0,0,0,25,8H12.86A4,4,0,1,0,9,13a4.81,4.81,0,0,0,1.28-.28L16,21.3V26H13a1,1,0,0,0,0,2h8a1,1,0,0,0,0-2H18V21.3ZM13.54,14h6.92L17,19.2Zm8.26-2H12.2l-1.33-2H23.13Z"></path>
                                </svg>
                            </label>
                        </li>
                        <li data-toggle="" data-placement="bottom" title="ficon12">
                            <input type="checkbox" id="ficon12" name="ficon12" data-reload-qr-code>
                            <label for="ficon12" class="boxtagLabel">
                                <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 32 32" aria-hidden="true" style="font-size: 32px;">
                                    <path d="M25,4a6,6,0,0,0-6,6v6a1,1,0,0,0,1,1h.88L20,24.89A.41.41,0,0,0,20,25a3,3,0,0,0,6,0V5A1,1,0,0,0,25,4Zm-4,6a4,4,0,0,1,3-3.87V15H21Zm3,15a1,1,0,0,1-2,.05l.9-8H24Z"></path>
                                    <path d="M15,4a1,1,0,0,0-1,1v7a1,1,0,0,1-1,1H12V5a1,1,0,0,0-2,0v8H9a1,1,0,0,1-1-1V5A1,1,0,0,0,6,5v7a3,3,0,0,0,2,2.82V25a3,3,0,0,0,6,0V14.82A3,3,0,0,0,16,12V5A1,1,0,0,0,15,4ZM12,25a1,1,0,0,1-2,0V15h2Z"></path>
                                </svg>
                            </label>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="custom-accodian">
        <button class="btn accodianBtn" type="button" data-toggle="collapse" data-target="#acc_contactInfo" aria-expanded="true" aria-controls="acc_contactInfo">
            <span>Contact Information</span>
            <svg class="MuiSvgIcon-root MuiSvgIcon-colorPrimary leftArrow" focusable="false" viewBox="0 0 16 16" aria-hidden="true" style="font-size: 16px;">
                <path d="M12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5ZM12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5Z"></path>
            </svg>
        </button>
        <div class="collapse show" id="acc_contactInfo">
            <div class="collapseInner">
                <div class="row">
                    <div class="form-group col-6 pr-2">
                        <label for="contactName"> <?= l('qr_codes.input.name') ?></label>
                        <input id="contactName" onchange="LoadPreview()" name="contactName" class="form-control" value="" maxlength="<?= $data->qr_code_settings['type']['menu']['companyTitle']['max_length'] ?>" data-reload-qr-code />
                    </div>
                    <div class="form-group col-6 pl-2">
                        <label for="contactWebsite"> <?= l('qr_codes.input.website') ?></label>
                        <input id="contactWebsite" onchange="LoadPreview()" name="contactWebsite" class="form-control" value="" maxlength="<?= $data->qr_code_settings['type']['menu']['companyTitle']['max_length'] ?>" data-reload-qr-code />
                    </div>
                </div>
                <div>
                    <div class=" mb-3 addBusinessButton addRow" id="phn-block">

                    </div>
                    <div id="phn-btn">
                        <button id="add11" type="button" class="btn outlineBtn mb-4 addRowButton2"><i class="fa fa-fw fa-plus fa-sm mr-1"></i> <?= l('qr_codes.input.addPhone') ?></button>
                    </div>
                </div>

                <div>
                    <div class=" mb-3 addBusinessButton addRow" id="email-block">

                    </div>
                    <div>
                        <button id="add12" type="button" class="outlineBtn addRowButton2"><i class="fa fa-fw fa-plus fa-sm mr-1"></i> <?= l('qr_codes.input.addEmail') ?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="custom-accodian">
        <button class="btn accodianBtn" type="button" data-toggle="collapse" data-target="#acc_aboutCompany" aria-expanded="true" aria-controls="acc_aboutCompany">
            <span> <?= l('qr_codes.input.aboutCompany') ?></span>
            <svg class="MuiSvgIcon-root MuiSvgIcon-colorPrimary leftArrow" focusable="false" viewBox="0 0 16 16" aria-hidden="true" style="font-size: 16px;">
                <path d="M12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5ZM12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5Z"></path>
            </svg>
        </button>
        <div class="collapse show" id="acc_aboutCompany">
            <div class="collapseInner">
                <div class="form-group m-0">
                    <textarea id="aboutCompany" name="aboutCompany" onchange="LoadPreview()" placeholder="E.g. Lorem ipsum" class="form-control textarea-control"></textarea>
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
                <div class="socialFormContainer">
                    <div class="socialItem">
                        <div class="socialInner">
                            <img src="<?= ASSETS_FULL_URL . 'images/socialicon/icon1.svg'; ?>" alt="">
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

                    <!-- After Upload Priview -->
                    <!-- <div class="screen-upload justify-content-between">
                        <div class="d-flex align-items-center mr-2">
                        <label for="screen">
                            <input type="file" id="screen" name="screen" 
 onchange="setTimeout(function() { console.log('here'); document.getElementById('loader').style.display = 'block'; document.getElementById('iframesrc').style.visibility = 'hidden'; LoadPreview(); }, 5000);" class="form-control py-2" value=""  accept="image/png, image/gif, image/jpeg"   required="required" data-reload-qr-code />
                            <div class="input-image">
                            <img src="data:image/jpeg;base64,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" alt="">
                            </div>
                            <div class="add-icon">
                            <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 24px;"><path d="M20.71,6.29l-3-3a1,1,0,0,0-1.42,0l-12,12a1,1,0,0,0-.26.47l-1,4a1,1,0,0,0,.26.95A1,1,0,0,0,4,21a1,1,0,0,0,.24,0l4-1a1,1,0,0,0,.47-.26l12-12A1,1,0,0,0,20.71,6.29ZM7.49,18.1l-2.12.53.53-2.12,8.6-8.6L16.09,9.5Zm10-10L15.91,6.5,17,5.41,18.59,7Z"></path></svg>
                            </div>
                        </label>
                        <button type="button" class="delete-btn">
                            <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 24px;"><path d="M20,7H4A1,1,0,0,0,4,9H5.08l.77,9.25a3,3,0,0,0,3,2.75h6.32a3,3,0,0,0,3-2.75L18.92,9H20a1,1,0,0,0,0-2ZM16.16,18.08a1,1,0,0,1-1,.92H8.84a1,1,0,0,1-1-.92L7.09,9h9.82Z"></path><path d="M9,5h6a1,1,0,0,0,0-2H9A1,1,0,0,0,9,5Z"></path></svg>
                            Delete
                        </button>
                        </div>
                         <button type="button" class="upload-btn" onclick="LoadPreview(true)">Preview</button>
                    </div> -->
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
    <!-- <div class="form-group" data-type="business">
        <input type="hidden" id="uId" name="uId" class="form-control" value="<?= uniqid() ?>" data-reload-qr-code />
        <label for="name"> <?= l('qr_codes.input.qrname') ?></label>
        <input id="name" name="name" class="form-control" value="" maxlength="<?= $data->qr_code_settings['type']['business']['name']['max_length'] ?>" required="required" data-reload-qr-code />
        <label for="primaryColor"> <?= l('qr_codes.input.primaryColor') ?></label>
        <input type="color" id="primaryColor" name="primaryColor" class="form-control" value="#0099ff" data-reload-qr-code />
        <label for="secondryColor"> <?= l('qr_codes.input.secondryColor') ?></label>
        <input type="color" id="secondryColor" name="secondryColor" class="form-control" value="#0099ff" data-reload-qr-code />
        <h4>Business information</h4>
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
        <h4>Buttons</h4>
        <div class="row" style="margin-right: 0 !important;margin-left: 0 !important;">
            <label for="businessButtons"> <?= l('qr_codes.input.businessButton') ?></label>
            <input class="form-control" type="text" name="businessButtons[]" placeholder="E.g. Contact Us" required="required" />
            <input class="form-control" type="url" name="businessButtonUrls[]" placeholder="https://your-website.com/contact-us" required="required" />
        </div>
        <div>
            <button id="add" class="delete btn btn-outline-primary mt-4"><i class="fa fa-fw fa-plus fa-sm mr-1"></i> Add Button</button>
        </div>
        <h4>Opening Hours</h4>
        <div id="Sunday" class="day"></div>
        <div id="Monday" class="day"></div>
        <div id="Tuesday" class="day"></div>
        <div id="Wednesday" class="day"></div>
        <div id="Thursday" class="day"></div>
        <div id="Friday" class="day"></div>
        <div id="Saturday" class="day"></div>
        <h4>Location Details</h4>
        <label for="businessAddress"> <?= l('qr_codes.input.businessAddress') ?></label>
        <input id="businessAddress" name="businessAddress" class="form-control" value="" maxlength="<?= $data->qr_code_settings['type']['menu']['companyTitle']['max_length'] ?>" data-reload-qr-code />
        <label for="businessNumeration"> <?= l('qr_codes.input.businessNumeration') ?></label>
        <input id="businessNumeration" name="businessNumeration" class="form-control" value="" maxlength="<?= $data->qr_code_settings['type']['menu']['companyTitle']['max_length'] ?>" data-reload-qr-code />
        <label for="businessPostalCode"> <?= l('qr_codes.input.businessPostalCode') ?></label>
        <input id="businessPostalCode" name="businessPostalCode" class="form-control" value="" maxlength="<?= $data->qr_code_settings['type']['menu']['companyTitle']['max_length'] ?>" data-reload-qr-code />
        <label for="businessCity"> <?= l('qr_codes.input.businessCity') ?></label>
        <input id="businessCity" name="businessCity" class="form-control" value="" maxlength="<?= $data->qr_code_settings['type']['menu']['companyTitle']['max_length'] ?>" data-reload-qr-code />
        <label for="businessState"> <?= l('qr_codes.input.businessState') ?></label>
        <input id="businessState" name="businessState" class="form-control" value="" maxlength="<?= $data->qr_code_settings['type']['menu']['companyTitle']['max_length'] ?>" data-reload-qr-code />
        <label for="Country"> <?= l('qr_codes.input.Country') ?></label>
        <input id="Country" name="Country" class="form-control" value="" maxlength="<?= $data->qr_code_settings['type']['menu']['companyTitle']['max_length'] ?>" data-reload-qr-code />
        <h4>Facilities</h4>
        <ul class="ks-cboxtags">
            <li data-toggle="tooltip" data-placement="bottom" title="Wifi"><input type="checkbox" id="wifi" value="wifi"><label for="wifi"> <i class="fa fa-fw fa-wifi"></i></label></li>
            <li data-toggle="tooltip" data-placement="bottom" title="Chair"><input type="checkbox" id="seat" value="seat"><label for="seat"> <i class="fa fa-fw fa-chair"></i></label></li>
            <li data-toggle="tooltip" data-placement="bottom" title="Accessible"><input type="checkbox" id="accessible" value="accessible"><label for="accessible"> <i class="fa fa-fw fa-wheelchair"></i></label></li>
        </ul>
        <h4>Contact Information</h4>
        <label for="contactName"> <?= l('qr_codes.input.name') ?></label>
        <input id="contactName" name="contactName" class="form-control" value="" maxlength="<?= $data->qr_code_settings['type']['menu']['companyTitle']['max_length'] ?>" data-reload-qr-code />
        <label for="contactWebsite"> <?= l('qr_codes.input.website') ?></label>
        <input id="contactWebsite" name="contactWebsite" class="form-control" value="" maxlength="<?= $data->qr_code_settings['type']['menu']['companyTitle']['max_length'] ?>" data-reload-qr-code />
        <div class="row2" style="margin-right: 0 !important;margin-left: 0 !important;">
            <label for="contactMobiles"> <?= l('qr_codes.input.telephone') ?></label>
            <input class="form-control" type="text" name="contactMobileTitles[]" placeholder="Phone Title" />
            <input class="form-control" type="tel" name="contactMobiles[]" placeholder="+1735425436" />
        </div>
        <div>
            <button id="add2" class="delete btn btn-outline-primary mt-4"><i class="fa fa-fw fa-plus fa-sm mr-1"></i> Add Phone</button>
        </div>
        <label for="aboutCompany"> <?= l('qr_codes.input.aboutCompany') ?></label>
        <textarea id="aboutCompany" name="aboutCompany" class="form-control" rows="4" cols="50"></textarea>
        
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
    var base_url = '<?php echo SITE_URL ?>'

    function LoadPreview(welcome_screen = false) {
        let uId = document.getElementById('uId').value;
        let primaryColor = document.getElementById('primaryColor').value;
        let SecondaryColor = document.getElementById('SecondaryColor').value;
        let companyLogo = document.getElementById('companyLogo').files;
        let company = document.getElementById('company').value;
        let companyTitle = document.getElementById('companyTitle').value;
        let companySubtitle = document.getElementById('companySubtitle').value;
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
        let ship_address = document.getElementById('ship_address').value;
        let contactName = document.getElementById('contactName').value;
        let contactWebsite = document.getElementById('contactWebsite').value;
        var businessButtons = document.getElementById('businessButtons')?.value || "";
        var businessButtonUrls = document.getElementById('businessButtonUrls')?.value || "";
        let aboutCompany = document.getElementById('aboutCompany').value
        let contactMobileTitles = JSON.stringify($("input[name='contactMobileTitles[]']").map(function() {
            return $(this).val();
        }).get());
        let contactMobiles = JSON.stringify($("input[name='contactMobiles[]']").map(function() {
            return $(this).val();
        }).get());
        let contactEmailTitles = JSON.stringify($("input[name='contactEmailTitles[]']").map(function() {
            return $(this).val();
        }).get());
        let contactEmails = JSON.stringify($("input[name='contactEmails[]']").map(function() {
            return $(this).val();
        }).get());
        // ficon
        let ficons = $("input[name*='ficon']").map(function() {
            if ($(this).is(":checked")) {
                return $(this).attr('name');
            }
        }).get();
        console.log("ficon", ficons)
        let offer_street = document.getElementById('offer_street')?.value || "";
        let offer_number = document.getElementById('offer_number')?.value || "";
        let offer_postalcode = document.getElementById('offer_postalcode')?.value || "";
        let offer_city = document.getElementById('offer_city')?.value || "";
        let offer_state = document.getElementById('offer_state')?.value || "";
        let offer_country = document.getElementById('offer_country')?.value || "";
        let offer_url1 = document.getElementById('offer_url1')?.value || "";
        let latitude = document.getElementById('latitude')?.value || "";
        let longitude = document.getElementById('longitude')?.value || "";
        let font_title = document.getElementById('filters_title_by').value;
        let font_text = document.getElementById('filters_text_by').value;
        var filesscreen = document.getElementById("screen").files;

        var screen = filesscreen && filesscreen.length ? base_url + "uploads/screen/" + uId + "_" + filesscreen[0].name + "" : "";
        var companyLogoUrl = companyLogo && companyLogo.length ? base_url + "uploads/business/" + uId + "_companyLogo_" + companyLogo[0].name + "" : "";
        // var all_companyLogo = [];
        // for (var i = 0; i < companyLogo.length; i++) {
        //     var image1 = base_url + "uploads/menu/" + uId + "_" + i + "_companyLogo_" + files[i].name + "";
        //     all_companyLogo.push(image1)
        // }

        let link = `<?php echo LANDING_PAGE_URL; ?>business?contactEmailTitles=${contactEmailTitles}&contactEmails=${contactEmails}&contactMobileTitles=${contactMobileTitles}&contactMobiles=${contactMobiles}&aboutCompany=${aboutCompany}&font_title=${font_title}&font_text=${font_text}&primaryColor=${primaryColor.replace("#","")}&SecondaryColor=${SecondaryColor.replace("#","")}&companyLogo=${companyLogoUrl}&company=${company}&companyTitle=${companyTitle}&companySubtitle=${companySubtitle}&Monday_From=${Monday_From}&Monday_To=${Monday_To}&Tuesday_From=${Tuesday_From}&Tuesday_To=${Tuesday_To}&Wednesday_From=${Wednesday_From}&Wednesday_To=${Wednesday_To}&Thursday_From=${Thursday_From}&Thursday_To=${Thursday_To}&Friday_From=${Friday_From}&Friday_To=${Friday_To}&Saturday_From=${Saturday_From}&Saturday_To=${Saturday_To}&Sunday_From=${Sunday_From}&Sunday_To=${Sunday_To}&ship_address=${ship_address}&contactName=${contactName}&contactWebsite=${contactWebsite}&screen=${screen}&businessButtons=${businessButtons}&businessButtonUrls=${businessButtonUrls}&offer_street=${offer_street}&offer_number=${offer_number}&offer_postalcode=${offer_postalcode}&offer_city=${offer_city}&offer_state=${offer_state}&offer_country=${offer_country}&offer_url1=${offer_url1}&latitude=${latitude}&longitude=${longitude}&ficons=${JSON.stringify(ficons)}`
        if (!welcome_screen) {
            link = `<?php echo LANDING_PAGE_URL; ?>business?contactEmailTitles=${contactEmailTitles}&contactEmails=${contactEmails}&contactMobileTitles=${contactMobileTitles}&contactMobiles=${contactMobiles}&aboutCompany=${aboutCompany}&font_title=${font_title}&font_text=${font_text}&primaryColor=${primaryColor.replace("#","")}&SecondaryColor=${SecondaryColor.replace("#","")}&companyLogo=${companyLogoUrl}&company=${company}&companyTitle=${companyTitle}&companySubtitle=${companySubtitle}&Monday_From=${Monday_From}&Monday_To=${Monday_To}&Tuesday_From=${Tuesday_From}&Tuesday_To=${Tuesday_To}&Wednesday_From=${Wednesday_From}&Wednesday_To=${Wednesday_To}&Thursday_From=${Thursday_From}&Thursday_To=${Thursday_To}&Friday_From=${Friday_From}&Friday_To=${Friday_To}&Saturday_From=${Saturday_From}&Saturday_To=${Saturday_To}&Sunday_From=${Sunday_From}&Sunday_To=${Sunday_To}&ship_address=${ship_address}&contactName=${contactName}&contactWebsite=${contactWebsite}&businessButtons=${businessButtons}&businessButtonUrls=${businessButtonUrls}&offer_street=${offer_street}&offer_number=${offer_number}&offer_postalcode=${offer_postalcode}&offer_city=${offer_city}&offer_state=${offer_state}&offer_country=${offer_country}&offer_url1=${offer_url1}&latitude=${latitude}&longitude=${longitude}&ficons=${JSON.stringify(ficons)}`
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
<script>
    $('.day').each(function() {
        var day = $(this).attr('id');
        // $(this).append(`<div class="checkboxBorder">
        //                 <div class="col-4 d-flex align-items-center p-0">
        //                     <div class="roundCheckbox">
        //                         <input type="checkbox" name="closed" value="closed" class="closed" />
        //                         <label class="m-0" for="closed"></label>
        //                     </div>
        //                     <label class="m-0">` + day + `</label>
        //                 </div>
        //                 <div class="name col-4">

        //                 <input class="form-control" type="time" min="04:00" max="23:00" step="0" placeholder="hh:mm"   />



        //                 </div>
        //                 <div class="name col-4">
        //                 <div class="form-control">
        //                 <select name="search_by" name="` + day + `ToH"  class="hour to ">

        //                     </select>
        //                     <select name="search_by" name="` + day + `ToM"  class="min to  ">

        //                     </select>
        //                     <select name="search_by" name="` + day + `ToAP"  class="ampm to  ">

        //                     </select>
        //                 </div>
        //                 </div>
        //             </div>`);
        // var day = $(this).attr('id');
        // $(this).append('<div id="label" class="name col-4">' + day + ': </div>');
        // $(this).append('<select name="' + day + 'FromH" class="hour from form-control"></select>');
        // $(this).append('<select name="' + day + 'FromM" class="min from form-control"></select>');
        // $(this).append('<select name="' + day + 'FromAP" class="ampm from form-control"></select>');
        // $(this).append(' to <select name="' + day + 'ToH" class="hour to form-control"></select>');
        // $(this).append('<select name="' + day + 'ToM" class="min to form-control"></select>');
        // $(this).append('<select name="' + day + 'ToAP" class="ampm to form-control"></select>');
        // $(this).append(' <input type="checkbox" name="closed" value="closed" class="closed"><span>Closed</span>');

    });

    $('.hour').each(function() {
        for (var h = 1; h < 13; h++) {
            $(this).append('<option value="' + h + '">' + h + '</option>');
        }

        $(this).filter('.from').val('9');
        $(this).filter('.to').val('5');
    });

    $('.min').each(function() {
        var min = [':00', ':15', ':30', ':45'];
        for (var m = 0; m < min.length; m++) {
            $(this).append('<option value="' + min[m] + '">' + min[m] + '</option>');
        }

        $(this).val(':00');
    });

    $('.ampm').each(function() {
        $(this).append('<option value="AM">AM</option>');
        $(this).append('<option value="PM">PM</option>');

        $(this).filter('.from').val('AM');
        $(this).filter('.to').val('PM');
    });

    $('input').change(function() {
        if ($(this).filter(':checked').val() != "closed") {
            $(this).siblings('select').attr('disabled', true);
        } else {
            $(this).siblings('select').attr('disabled', false);
        }
    });

    $('#Saturday .closed, #Sunday .closed').val(["closed"]).siblings('select').attr('disabled', true);
</script>
<script>
    var manualClicked = false;
    var urlClicked = false;
    var coClicked = false;
    var phoneNumber = 0;
    var emailNumber = 0;
    $(document).on('click', '.addRowButton', function() {
        var parent = $(this).closest('.collapseInner');
        var clone = parent.find('.addRow:first').clone(true)
        $(clone).insertAfter(parent.find('.addRow:last'));

        var rmvBtnHtml = `<div class="form-group m-0" id="btn-section">
                        <label for="contactMobiles"> <?= l('qr_codes.input.button') ?></label>
                        <div class="d-flex align-items-center w-100" ">
                            <div class="d-flex align-items-center w-100">
                                <input class="form-control mr-3" type="text" id="businessButtons" onchange="LoadPreview()" placeholder="Write the button text here..." required="required" />
                                <input class="form-control mr-3" type="url" id ="businessButtonUrls" onchange="LoadPreview()" placeholder="https://…" required="required" />
                            </div>
                            <button type="button" class="reapeterCloseIcon removeBtn" onclick="showButton(this)">
                               <span class="icon-trash remove-btn-icon"></span>
                            </button>
                        </div>
                    </div>`;
        $('#add-btn').append(rmvBtnHtml);
        $(clone).find('div.row').append(rmvBtnHtml);
        $(".addRowButton").remove();
    });

    $(document).on('click', '#add11', function() {
        var rmvBtnHtml = `<div class="form-group m-0">
                            <label for="contactMobiles"><?= l('qr_codes.input.telephone') ?></label>
                            <div class="d-flex align-items-center w-100">
                                <div class="d-flex align-items-center w-100">
                                    <input class="form-control mr-3" type="text" id="contactMobileTitles" onchange="LoadPreview()" name="contactMobileTitles[]" placeholder="Phone title" data-reload-qr-code />
                                    <input class="form-control mr-3" type="tel" id="contactMobiles" name="contactMobiles[]" onchange="LoadPreview()" placeholder="E.g. 00000 00000" data-reload-qr-code />
                                </div>
                                <button type="button" class="reapeterCloseIcon removeBtnPhone" onclick="remove_me(this)">
                                    <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>`;
        $('#phn-block').append(rmvBtnHtml);
        phoneNumber++
    });

    $(document).on('click', '#add12', function() {
        var rmvBtnHtml = `<div class="form-group m-0" id="email1">
                            <label for="contactEmails"><?= l('qr_codes.input.email') ?></label>
                            <div class="d-flex align-items-center w-100">
                                <div class="d-flex align-items-center w-100">
                                    <input class="form-control mr-3" type="text" id="contactEmailTitles" onchange="LoadPreview()" name="contactEmailTitles[]" placeholder="Label..." />
                                    <input class="form-control mr-3" type="email" id="contactEmails" onchange="LoadPreview()" name="contactEmails[]" placeholder="E.g. name@email.com" />
                                </div>
                                <button type="button" class="reapeterCloseIcon removeBtnEmail" onclick="remove_me(this)">
                                    <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>`;
        $('#email-block').append(rmvBtnHtml);
        emailNumber++
    });

    $(document).on('click', '.removeBtn', function() {
        $("#btn-section").remove();
        $("#btn-item").append(`<button id="add" type="button" class="btn outlineBtn addRowButton"><i class="fa fa-fw fa-plus fa-sm mr-1 smIcon"></i> Add button</button>`)
        $(this).closest('.borderSection').remove()
    });

    $(document).on('click', '#ampm', function() {
        console.log("ampm");
        $('#ampm').addClass('active');
        $('#24hr').removeClass('active');
    });
    $(document).on('click', '#24hr', function() {
        console.log("24hr")
        $('#24hr').addClass('active');
        $('#ampm').removeClass('active');
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
                            <div class="col-6 pr-2">
                                <div class="form-group">
                                    <label for="offer_street">Street</label>
                                    <input id="offer_street" onchange="LoadPreview()" placeholder="" name="offer_street" class="form-control" value="" data-reload-qr-code="">
                                </div>
                            </div>
                            <div class="col-6 pl-2">
                                <div class="row">
                                    <div class="col-6 pr-2">
                                        <div class="form-group">
                                            <label for="offer_number">Number</label>
                                            <input id="offer_number" onchange="LoadPreview()" placeholder="" name="offer_number" class="form-control" value="" data-reload-qr-code="">
                                        </div>
                                    </div>
                                    <div class="col-6 pl-2">
                                        <div class="form-group">
                                            <label for="offer_postalcode">Postal Code</label>
                                            <input id="offer_postalcode" onchange="LoadPreview()" placeholder="" name="offer_postalcode" class="form-control" value="" data-reload-qr-code="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 pr-2">
                                <div class="form-group">
                                    <label for="offer_city">City</label>
                                    <input id="offer_city" onchange="LoadPreview()" placeholder="" name="offer_city" class="form-control" value="" data-reload-qr-code="">
                                </div>
                            </div>
                            <div class="col-6 pl-2">
                                <div class="form-group">
                                    <label for="offer_state">State / Province</label>
                                    <input id="offer_state" onchange="LoadPreview()" placeholder="" name="offer_state" class="form-control" value="" data-reload-qr-code="">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group m-0">
                                    <label for="offer_country">Country</label>
                                    <input id="offer_country" onchange="LoadPreview()" placeholder="" name="offer_country" class="form-control" value="" data-reload-qr-code="">
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

    // DAYS
    $('#checkboxMon').on('click', function() {
        if ($(this).is(':checked')) {
            $('.Monday_From').attr('disabled', false);
            $('.Monday_To').attr('disabled', false);
        } else {
            $('.Monday_From').attr('disabled', true);
            $('.Monday_To').attr('disabled', true);
        }
    });

    $('#checkboxTue').on('click', function() {
        if ($(this).is(':checked')) {
            $('.Tuesday_From').attr('disabled', false);
            $('.Tuesday_To').attr('disabled', false);
        } else {
            $('.Tuesday_From').attr('disabled', true);
            $('.Tuesday_To').attr('disabled', true);
        }
    });
    $('#checkboxWed').on('click', function() {
        if ($(this).is(':checked')) {
            $('.Wednesday_From').attr('disabled', false);
            $('.Wednesday_To').attr('disabled', false);
        } else {
            $('.Wednesday_From').attr('disabled', true);
            $('.Wednesday_To').attr('disabled', true);
        }


    });
    $('#checkboxThu').on('click', function() {
        if ($(this).is(':checked')) {
            $('.Thursday_From').attr('disabled', false);
            $('.Thursday_To').attr('disabled', false);
        } else {
            $('.Thursday_From').attr('disabled', true);
            $('.Thursday_To').attr('disabled', true);
        }


    });
    $('#checkboxFri').on('click', function() {
        if ($(this).is(':checked')) {
            $('.Friday_From').attr('disabled', false);
            $('.Friday_To').attr('disabled', false);
        } else {
            $('.Friday_From').attr('disabled', true);
            $('.Friday_To').attr('disabled', true);
        }


    });
    $('#checkboxSat').on('click', function() {
        if ($(this).is(':checked')) {
            $('.Saturday_From').attr('disabled', false);
            $('.Saturday_To').attr('disabled', false);
        } else {
            $('.Saturday_From').attr('disabled', true);
            $('.Saturday_To').attr('disabled', true);
        }


    });
    $('#checkboxSun').on('click', function() {
        if ($(this).is(':checked')) {
            $('.Sunday_From').attr('disabled', false);
            $('.Sunday_To').attr('disabled', false);
        } else {
            $('.Sunday_From').attr('disabled', true);
            $('.Sunday_To').attr('disabled', true);
        }
    });
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
            console.log(this.lastGroup)
            // $(group).find('div > div > div > button > p').text('Product ' + (parseInt(groupIndex) + 1).toString());
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
    }
</script>
<script>
    function initAutocomplete() {
        new google.maps.places.Autocomplete(
            (document.getElementById('ship_address')), {
                types: ['geocode']
            }
        );
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC8qMRqcnP5x7y15lRD1Arl56PRVEUv5r4&libraries=places&callback=initAutocomplete" async defer></script>