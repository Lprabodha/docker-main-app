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
                    <input type="hidden" id="uId" name="uId" class="form-control" value="<?= uniqid() ?>" data-reload-qr-code />
                    <input type="hidden" id="preview_link" name="preview_link" class="form-control" data-reload-qr-code />
                    <input type="hidden" id="preview_link2" name="preview_link2" class="form-control" data-reload-qr-code />
                    <input id="name" name="name" placeholder="E.g. My QR code" class="form-control" value="" maxlength="<?= $data->qr_code_settings['type']['images']['name']['max_length'] ?>" required data-reload-qr-code />
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
                            <input type="color" name="" class="colorPalette w-100" value="#0E379A" readonly />
                        </div>
                        <div class="formcolorPalette" id="formcolorPalette2">
                            <input type="color" name="" class="colorPalette w-100" value="#28EDC9" />
                        </div>
                        <div class="formcolorPalette" id="formcolorPalette3">
                            <input type="color" name="" class="colorPalette w-100" value="#28ED28" />
                        </div>
                        <div class="formcolorPalette" id="formcolorPalette4">
                            <input type="color" name="" class="colorPalette w-100" value="#EDE728" />
                        </div>
                        <div class="formcolorPalette" id="formcolorPalette5">
                            <input type="color" name="" class="colorPalette w-100" value="#ED4C28" />
                        </div>
                    </div>

                    <div class="colorPaletteInner">
                        <div class="form-group m-0">
                            <label for="">Primary</label>
                            <div class="customColorPicker">
                                <label for="primaryColor">
                                    <input id="primaryColor" name="primaryColor" onchange="LoadPreview()" class="pickerField" type="color" value="#0E379A" data-reload-qr-code />
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
                            <select name="search_by" id="filters_title_by" onchange="LoadPreview()" class="form-control">
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
                            <select name="search_by" id="filters_text_by" onchange="LoadPreview()" class="form-control">
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
        <button class="btn accodianBtn" type="button" data-toggle="collapse" data-target="#acc_images" aria-expanded="true" aria-controls="acc_images">
            <span><?= l('qr_codes.input.image') ?></span>
            <svg class="MuiSvgIcon-root MuiSvgIcon-colorPrimary leftArrow" focusable="false" viewBox="0 0 16 16" aria-hidden="true" style="font-size: 16px;">
                <path d="M12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5ZM12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5Z"></path>
            </svg>
        </button>
        <div class="collapse show" id="acc_images">
            <div class="collapseInner">
                <!-- <div class="form-group m-0">
                    <input type="file" id="images" name="images[]" onchange="LoadPreview()" class="form-control py-2" value="" accept="image/png, image/gif, image/jpeg" multiple required="required" data-reload-qr-code />
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
                <div class="custom-upload mb-3">
                    <label for="images">

                        <!-- Before Upload Priview -->
                        <div class="before-upload">
                            <input type="file" id="images" onchange="loadFile(event)" name="images[]" class="form-control py-2" accept="image/png, image/gif, image/jpeg" multiple required data-reload-qr-code />
                            <button type="button" class="upload-btn">Upload images</button>
                            <span>Maximum size: 15MB</span>
                        </div>
                    </label>
                </div>

                <!-- After Upload Priview -->
                <!-- <div class="mb-4 quote-imgs-thumbs--hidden" id="<div class=" screen-upload mb-3">
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
                </div> -->
                <div id="img_previews">

                </div>
                <!-- <div class="afterImage-upload">
                    <div class="d-flex align-items-center">
                        <div class="imagePreview">
                            <img src="https://cdn.pixabay.com/photo/2015/04/23/22/00/tree-736885__480.jpg" alt="">
                        </div>
                        <div class="previewDetail">
                            <label>image.jpg</label>
                            <span>Size: 4.09KB</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <button type="button">
                            <svg class="MuiSvgIcon-root" color="#FE4256" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 24px;">
                                <path d="M20,7H4A1,1,0,0,0,4,9H5.08l.77,9.25a3,3,0,0,0,3,2.75h6.32a3,3,0,0,0,3-2.75L18.92,9H20a1,1,0,0,0,0-2ZM16.16,18.08a1,1,0,0,1-1,.92H8.84a1,1,0,0,1-1-.92L7.09,9h9.82Z"></path>
                                <path d="M9,5h6a1,1,0,0,0,0-2H9A1,1,0,0,0,9,5Z"></path>
                            </svg>
                        </button>
                        <button type="button">
                            <svg class="MuiSvgIcon-root" color="#EAEAEC" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 24px;">
                                <path d="M20,17H4a1,1,0,0,0,0,2H20a1,1,0,0,0,0-2Z"></path>
                                <path d="M20,11H4a1,1,0,0,0,0,2H20a1,1,0,0,0,0-2Z"></path>
                                <path d="M4,7H20a1,1,0,0,0,0-2H4A1,1,0,0,0,4,7Z"></path>
                            </svg>
                        </button>
                    </div>
                </div> -->
                <!-- <div class="quote-imgs-thumbs aria-live=" polite"></div> -->
            </div>
            <div class="checkbox-wrapper">
                <div class="roundCheckbox m-2 mr-3">
                    <input type="checkbox" id="uploadCheckbox" onchange="LoadPreview()" />
                    <label class="m-0" for="uploadCheckbox"></label>
                </div>
                <label class="passwordlabel mb-0">Vertical images</label>
            </div>
        </div>
    </div>
    <div class="custom-accodian">
        <button class="btn accodianBtn" type="button" data-toggle="collapse" data-target="#acc_imageInfo" aria-expanded="true" aria-controls="acc_imageInfo">
            <span>Image information</span>
            <svg class="MuiSvgIcon-root MuiSvgIcon-colorPrimary leftArrow" focusable="false" viewBox="0 0 16 16" aria-hidden="true" style="font-size: 16px;">
                <path d="M12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5ZM12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5Z"></path>
            </svg>
        </button>
        <div class="collapse show" id="acc_imageInfo">
            <div class="collapseInner">
                <div class="form-group mb-4">
                    <label for="image_title"> <?= l('qr_codes.input.imageName') ?></label>
                    <input id="image_title" onchange="LoadPreview()" placeholder="E.g. My photos" name="image_title" class="form-control" value="" maxlength="<?= $data->qr_code_settings['type']['images']['image_title']['max_length'] ?>" required data-reload-qr-code />
                </div>
                <div class="form-group mb-4">
                    <label for="image_description"> <?= l('qr_codes.input.imageDescription') ?></label>
                    <input id="image_description" placeholder="E.g. Trips 2019" onchange="LoadPreview()" name="image_description" class="form-control" value="" maxlength="<?= $data->qr_code_settings['type']['images']['image_description']['max_length'] ?>" required data-reload-qr-code />
                </div>
                <div class="form-group mb-4 addRow">
                    <label for="website"> Website</label>
                    <input id="website" type="url" placeholder="E.g. https://mywebsite.com/" name="website" onchange="LoadPreview()" class="form-control" value="" data-reload-qr-code />
                </div>

                <div>
                    <button id="add2" type="button" class="outlineBtn addRowButton"><i class="fa fa-fw fa-plus fa-sm mr-1"></i> <?= l('qr_codes.input.addButton') ?></button>
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
                    <!-- <div class="screen-upload mb-3">
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
                </div> -->

                    <!-- After Upload Priview -->
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
</div>




<!-- <?php include_once('accodian-form-group/tracking-analytics.php'); ?> -->
<!-- <div class="form-group" data-type="images" data-images>


        <label for="name"> <?= l('qr_codes.input.qrname') ?></label>
        <input id="name" name="name" class="form-control"  value="" maxlength="<?= $data->qr_code_settings['type']['images']['name']['max_length'] ?>" required="required" data-reload-qr-code />

        <label for="primaryColor"> <?= l('qr_codes.input.primaryColor') ?></label>
        <input type="color" id="primaryColor" name="primaryColor" onchange="LoadPreview()" class="form-control" value="#0099ff" data-reload-qr-code />

        <label for="images"><i class="fa fa-fw fa-link fa-sm mr-1"></i> <?= l('qr_codes.input.image') ?></label>
        <input type="file" id="images" name="images[]" onchange="LoadPreview()" class="form-control" value="" accept="image/png, image/gif, image/jpeg" multiple required="required" data-reload-qr-code />
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

        <h4>Image information</h4>
        <label for="image_title"> <?= l('qr_codes.input.imageName') ?></label>
        <input id="image_title" onchange="LoadPreview()" name="image_title" class="form-control" value="" maxlength="<?= $data->qr_code_settings['type']['images']['image_title']['max_length'] ?>" required="required" data-reload-qr-code />

        <label for="image_description"> <?= l('qr_codes.input.imageDescription') ?></label>
        <input id="image_description"  onchange="LoadPreview()" name="image_description" class="form-control" value="" maxlength="<?= $data->qr_code_settings['type']['images']['image_description']['max_length'] ?>" required="required" data-reload-qr-code />
        
         <label for="website"> Website</label>
        <input id="website" type="url" name="website" onchange="LoadPreview()" class="form-control" value="" placeholder="E.g. https://mywebsite.com/"   data-reload-qr-code />
        
        <div class="form-group">
            <label for="password"> Password</label>
            <input id="password" type="password" name="password" class="form-control" value="" maxlength="30"  data-reload-qr-code />
        </div>

        
    </div> -->

<!-- </div> -->
<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script>
    var loadFile = function(event) {
        var imgCont = document.getElementById("images");
        console.log("here loadFile")
        for (let i = 0; i < event.target.files.length; i++) {
            let preview_obj = `
                <div class="afterImage-upload" id="rowdiv-${i}">
                    <div class="d-flex align-items-center">
                        <div class="imagePreview">
                            <img src=${URL.createObjectURL(event.target.files[i])} alt="">
                        </div>
                        <div class="previewDetail">
                            <label>image.jpg</label>
                            <span>Size: 4.09KB</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <button type="button" onclick="deleteImage(${i})">
                            <svg class="MuiSvgIcon-root" color="#FE4256" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 24px;">
                                <path d="M20,7H4A1,1,0,0,0,4,9H5.08l.77,9.25a3,3,0,0,0,3,2.75h6.32a3,3,0,0,0,3-2.75L18.92,9H20a1,1,0,0,0,0-2ZM16.16,18.08a1,1,0,0,1-1,.92H8.84a1,1,0,0,1-1-.92L7.09,9h9.82Z"></path>
                                <path d="M9,5h6a1,1,0,0,0,0-2H9A1,1,0,0,0,9,5Z"></path>
                            </svg>
                        </button>
                        
                    </div>
                </div>
            `
            $("#img_previews").append(preview_obj);
            setTimeout(function() {
                console.log('here');
                document.getElementById('loader').style.display = 'block';
                document.getElementById('iframesrc').style.visibility = 'hidden';
                LoadPreview();
            }, 5000);
        }
    };

    function deleteImage(index) {
        $('#rowdiv-' + index).remove();
        const dt = new DataTransfer()
        const input = document.getElementById('images')
        const {
            files
        } = input

        for (let i = 0; i < files.length; i++) {
            const file = files[i]
            if (index !== i)
                dt.items.add(file) // here you exclude the file. thus removing it.
        }
        input.files = dt.files // Assign the updates list
        document.getElementById('loader').style.display = 'block';
        document.getElementById('iframesrc').style.visibility = 'hidden';
        LoadPreview();
    }
</script>
<script>
    var image_uploaded = false;
    // var base_url = 'http://localhost/qr-new/'
    var base_url = '<?php echo OFFLOAD_FULL_ENDPOINT?>'

    function LoadPreview(welcome_screen = false) {
        let uId = document.getElementById('uId').value;
        let primaryColor = document.getElementById('primaryColor').value;
        let image_title = document.getElementById('image_title').value;
        let image_description = document.getElementById('image_description').value;
        let website = document.getElementById('website').value;
        let font_title = document.getElementById('filters_title_by').value;
        let font_text = document.getElementById('filters_text_by').value;
        let tmp_screen = document.getElementById('screen').value;
        var filesscreen = document.getElementById("screen").files;
        let button_text = document.getElementById('button_text')?.value || "";
        let button_url = document.getElementById('button_url')?.value || "";

        // console.log("bb", document.getElementById('button_text').value, document.getElementById('button_url').value);
        var screen = filesscreen.length ? base_url + "/uploads/screen/" + uId + "_" + filesscreen[0].name + "" : "";

        let tmp_images = document.getElementById('images').value;
        // console.log("images", tmp_images)
        var files = document.getElementById("images").files;
        console.log("filesscreen", files);
        var all_images = [];
        for (var i = 0; i < files.length; i++) {
            var image = base_url + "/uploads/images/" + uId + "_" + i + "_" + files[i].name + "";
            // console.log(image);
            all_images.push(image)
        }
        let uploadCheckbox = document.getElementById('uploadCheckbox').checked;

        let link = `<?php echo LANDING_PAGE_URL;?>images?primaryColor=${primaryColor.replace("#","")}&image_title=${image_title}&image_description=${image_description}&font_title=${font_title}&font_text=${font_text}&screen=${screen}&website=${website}&images=${JSON.stringify(all_images)}&button_text=${button_text}&button_url=${button_url}&horizontal=${uploadCheckbox||""}`
        if (!welcome_screen) {
            link = `<?php echo LANDING_PAGE_URL;?>images?primaryColor=${primaryColor.replace("#","")}&image_title=${image_title}&image_description=${image_description}&font_title=${font_title}&font_text=${font_text}&website=${website}&images=${JSON.stringify(all_images)}&button_text=${button_text}&button_url=${button_url}&horizontal=${uploadCheckbox||""}`
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


    $(document).on('click', '.addRowButton', function() {
        // console.log('Hellow');
        var parent = $(this).closest('.collapseInner');
        // var clone = parent.find('.addRow:first').clone(true)
        // $(clone).insertAfter(parent.find('.addRow:last'));

        var row = `<div class=" mb-4 addRow">
                        <div class="form-group">
                            <label for="contactMobiles"> <?= l('qr_codes.input.button') ?></label>
                            <div class="d-flex align-items-center w-100">
                                <div class="d-flex align-items-center w-100">
                                    <input class="form-control mr-3" onchange="LoadPreview()" type="text" id="button_text" name="button_text" placeholder="Write the button text here..." required/>
                                    <input class="form-control mr-3" onchange="LoadPreview()" type="url" id="button_url" name="button_url" placeholder="https://…" required/>
                                </div>
                                <button class="reapeterCloseIcon removeBtn" type="button" onclick="remove_me(this)">
                                    <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"></path></svg>
                                </button>
                            </div>
                        </div>
                    </div>`;
        $(row).insertAfter(parent.find('.addRow:last'));
        $('.addRowButton').hide();
    });

    $(document).on('click', '.removeBtn', function() {
        $(this).closest('.borderSection').remove()
        $('.addRowButton').show();
    });

    document.querySelectorAll('.pickerField').forEach(function(picker) {
        var targetLabel = document.querySelector('label[for="' + picker.id + '"]'),
            codeArea = document.createElement('span');

        codeArea.innerHTML = picker.value;
        targetLabel.appendChild(codeArea);

        picker.addEventListener('change', function() {
            codeArea.innerHTML = picker.value;
            targetLabel.appendChild(codeArea);
        });
    });

    $('.colorPalette').on('click', function(e) {

        //    input.addclass document.getElementById("iframesrc").style.visibility = "visible";
        element.classList.add("active");
        console.log("werwereww");
        //    element.classList.remove("active");
    });

    function loadImage() {
        // document.getElementById("loader").style.display = "block";

        // function showIt2() {
        //     console.log("here")
        LoadPreview();
        // }
        // setTimeout(showIt2(), 7000);
    }
</script>
<script src="<?= ASSETS_FULL_URL ?>js/qr_form.js"></script>