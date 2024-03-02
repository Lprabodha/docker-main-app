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
                    <input id="name" name="name" placeholder="E.g. My QR code" class="form-control" value="" maxlength="<?= $data->qr_code_settings['type']['images']['name']['max_length'] ?>" required="required" data-reload-qr-code />
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
                            <select name="search_by" id="font_title" name="font_title" onchange="LoadPreview()" class="form-control">
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
                            <select name="search_by" id="font_text" name="font_text" onchange="LoadPreview()" class="form-control">
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
        <button class="btn accodianBtn" type="button" data-toggle="collapse" data-target="#acc_imageInfo" aria-expanded="true" aria-controls="acc_imageInfo">
            <span>App information</span>
            <svg class="MuiSvgIcon-root MuiSvgIcon-colorPrimary leftArrow" focusable="false" viewBox="0 0 16 16" aria-hidden="true" style="font-size: 16px;">
                <path d="M12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5ZM12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5Z"></path>
            </svg>
        </button>
        <div class="collapse show" id="acc_imageInfo">
            <div class="collapseInner">
                <div class="form-group">
                    <label for="app_title">App Name</label>
                    <input id="app_title" onchange="LoadPreview()" placeholder="E.g. Myfintech" name="app_title" class="form-control" value="" required="required" data-reload-qr-code />
                </div>
                <div class="form-group">
                    <label for="app_company">Developer/Company</label>
                    <input id="app_company" placeholder="E.g. Techncorp" onchange="LoadPreview()" name="app_company" class="form-control" value="" required="required" data-reload-qr-code />
                </div>
                <!-- <div class="form-group">
                <label for="images"><i class="fa fa-fw fa-link fa-sm mr-1"></i>App Logo</label>
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

                <div class="welcome-screen mb-4">
                    <span>App Logo</span>
                    <!-- Before Upload Priview -->
                    <div class="screen-upload">
                        <label for="images">
                            <input type="file" id="images" name="images[]" onchange="LoadPreview()" class="form-control py-2" value="" accept="image/png, image/gif, image/jpeg" data-reload-qr-code />
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

                    <!-- After Upload Priview -->
                    <!-- <div class="screen-upload">
                        <label for="images">
                            <input type="file" id="images" name="images[]" onchange="LoadPreview()" class="form-control py-2" value="" accept="image/png, image/gif, image/jpeg" multiple required="required" data-reload-qr-code />
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
                    </div> -->
                </div>
                <div class="form-group">
                    <label for="app_description">Description</label>
                    <input id="app_description" placeholder="E.g. Fintech app" onchange="LoadPreview()" name="app_description" class="form-control" value="" required="required" data-reload-qr-code />
                </div>
                <div class="form-group m-0">
                    <label for="app_website"> Website</label>
                    <input id="app_website" type="url" placeholder="E.g. https://mywebsite.com/" name="app_website" onchange="LoadPreview()" class="form-control" value="" data-reload-qr-code />
                </div>
            </div>
        </div>
    </div>

    <div class="custom-accodian">
        <button class="btn accodianBtn" type="button" data-toggle="collapse" data-target="#acc_nameOfQrCode" aria-expanded="true" aria-controls="acc_nameOfQrCode">
            <span>Links to different platforms</span>
            <svg class="MuiSvgIcon-root MuiSvgIcon-colorPrimary leftArrow" focusable="false" viewBox="0 0 16 16" aria-hidden="true" style="font-size: 16px;">
                <path d="M12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5ZM12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5Z"></path>
            </svg>
        </button>
        <div class="collapse show" id="acc_nameOfQrCode">
            <div class="collapseInner row-links">
                <div class="socialFormContainer appLinks">
                    <div class="socialItem">
                        <div class="socialInner">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16">
                                    <path fill="#2196F3" d="M8.32 7.68.58 15.42c-.37-.35-.57-.83-.57-1.35V1.93C.01 1.4.22.92.6.56l7.72 7.12z" />
                                    <path fill="#FFC107" d="M15.01 8c0 .7-.38 1.32-1.01 1.67l-2.2 1.22-2.73-2.52-.75-.69 2.89-2.89L14 6.33c.63.35 1.01.97 1.01 1.67z" />
                                    <path fill="#4CAF50" d="M8.32 7.68.6.56C.7.46.83.37.96.29 1.59-.09 2.35-.1 3 .26l8.21 4.53-2.89 2.89z" />
                                    <path fill="#F44336" d="M11.8 10.89 3 15.74c-.31.18-.66.26-1 .26-.36 0-.72-.09-1.04-.29a1.82 1.82 0 0 1-.38-.29l7.74-7.74.75.69 2.73 2.52z" />
                                </svg>
                            </span>
                            <p class="m-0">Google Play</p>
                        </div>
                        <div class="socialInput">
                            <input id="google" type="url" placeholder="Enter Play Store URL" name="google" onchange="LoadPreview()" class="form-control" value="" data-reload-qr-code />
                        </div>
                        <!-- <button type="button">
                            <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"></path>
                            </svg>
                        </button> -->
                    </div>
                    <div class="socialItem">
                        <div class="socialInner">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" data-name="Layer 1" viewBox="0 0 120 120">
                                    <defs>
                                        <linearGradient id="a" x1="-1315.782" x2="-1195.782" y1="529.793" y2="529.793" gradientTransform="rotate(-90 -832.788 -362.994)" gradientUnits="userSpaceOnUse">
                                            <stop offset="0" stop-color="#1d6ff2" />
                                            <stop offset="1" stop-color="#1ac8fc" />
                                        </linearGradient>
                                    </defs>
                                    <path fill="url(#a)" fill-rule="evenodd" d="M120,26V94a25.94821,25.94821,0,0,1-26,26H26A25.94821,25.94821,0,0,1,0,94V26A25.94821,25.94821,0,0,1,26,0H94A25.94821,25.94821,0,0,1,120,26Z" />
                                    <path fill="#fff" fill-rule="evenodd" d="M82.6,69H97.5a5.5,5.5,0,0,1,0,11H82.6Z" />
                                    <path fill="#fff" fill-rule="evenodd" d="M64.3 69a7.85317 7.85317 0 0 1 7.9 7.9 8.14893 8.14893 0 0 1-.6 3.1H22.5a5.5 5.5 0 0 1 0-11zM62.9 32.8v9.6H56.5L48.7 29a5.19712 5.19712 0 1 1 9-5.2zM68.4 42.1L95.7 89.4a5.48862 5.48862 0 0 1-9.5 5.5L69.7 66.2c-1.5-2.8-2.6-5-3.3-6.2A15.03868 15.03868 0 0 1 68.4 42.1z" data-name="Combined-Shape" />
                                    <path fill="#fff" fill-rule="evenodd" d="M46 74H33.3L62 24.3a5.48862 5.48862 0 0 1 9.5 5.5zM39.3 85.5L34 94.8a5.48862 5.48862 0 1 1-9.5-5.5l3.9-6.8a8.59835 8.59835 0 0 1 3.9-.9A7.77814 7.77814 0 0 1 39.3 85.5z" data-name="Combined-Shape" />
                                </svg>
                            </span>
                            <p class="m-0">App Store</p>
                        </div>
                        <div class="socialInput">
                            <input id="apple" type="url" placeholder="Enter Apple App Store URL" name="apple" onchange="LoadPreview()" class="form-control" value="" data-reload-qr-code />
                        </div>
                        <!-- <button type="button">
                            <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"></path>
                            </svg>
                        </button> -->
                    </div>
                    <div class="socialItem">
                        <div class="socialInner">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" aria-label="Amazon" viewBox="0 0 512 512">
                                    <rect width="512" height="512" fill="#f90" rx="15%" />
                                    <path fill="#fff" d="M283 187c-62 2-121 19-121 81 0 43 26 64 61 64 31 0 51-12 68-30 8 11 10 16 24 27 3 2 8 2 10-1l31-27c4-3 2-8 0-10-7-11-15-19-15-39v-64c0-27 2-52-18-70-17-16-38-20-62-21-53-1-88 28-93 62-1 6 4 9 7 9l37 5c6 1 9-4 10-8 6-22 29-28 43-23 20 6 18 29 18 45zm-36 105c-15 0-25-13-25-30 1-36 29-42 61-42v18c0 32-17 54-36 54zm168 106c13-11 26-38 25-57 0-7-1-8-8-10-13-4-46-5-62 10-3 3-2 5 1 5 11-2 45-6 50 2 4 7-8 35-12 47-2 5 2 6 6 3zM58 342c96 91 247 94 345 25 7-4 0-12-6-9a376 376 0 0 1-335-21c-4-3-8 2-4 5z" />
                                </svg>
                            </span>
                            <p class="m-0">Amazon</p>
                        </div>
                        <div class="socialInput">
                            <input id="amazon" type="url" placeholder="Enter Amazon App Store URL" name="amazon" onchange="LoadPreview()" class="form-control" value="" data-reload-qr-code />
                        </div>
                        <!-- <button type="button">
                            <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"></path>
                            </svg>
                        </button> -->
                    </div>
                </div>
                <!-- <div class="appLink-btn">
                    <span>Add</span>
                    <div class="d-flex align-items-center">
                        <button type="button"> Google</button>
                        <button type="button"> Apple</button>
                        <button type="button"> Amazon</button>
                    </div>
                </div> -->
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

</div>

<script>
    function LoadPreview(welcome_screen = false) {
        let uId = document.getElementById('uId').value;
        let primaryColor = document.getElementById('primaryColor').value;
        let SecondaryColor = document.getElementById('SecondaryColor').value;
        let app_title = document.getElementById('app_title').value;
        let app_description = document.getElementById('app_description').value;
        let app_website = document.getElementById('app_website').value;
        let app_company = document.getElementById('app_company').value;
        let google = document.getElementById('google').value;
        let apple = document.getElementById('apple').value;
        let amazon = document.getElementById('amazon').value;
        let font_title = document.getElementById('font_title').value;
        let font_text = document.getElementById('font_text').value;

        let tmp_screen = document.getElementById('screen').value;
        var filesscreen = document.getElementById("screen").files;
        var screen = filesscreen.length ? "<?php echo SITE_URL?>uploads/app/" + uId + "_" + filesscreen[0].name + "" : "";

        let tmp_images = document.getElementById('images').value;
        console.log("images", tmp_images)
        var files = document.getElementById("images").files;
        var all_images = [];
        for (var i = 0; i < files.length; i++) {
            var image = "<?php echo SITE_URL?>uploads/app/" + uId + "_" + i + "_" + files[i].name + "";
            console.log(image);
            all_images.push(image)
        }

        let link = `<?php echo LANDING_PAGE_URL;?>app?SecondaryColor=${SecondaryColor.replace("#","")}&primaryColor=${primaryColor.replace("#","")}&app_title=${app_title}&app_description=${app_description}&font_title=${font_title}&font_text=${font_text}&app_website=${app_website}&app_company=${app_company}&screen=${screen}&google=${google}&apple=${apple}&amazon=${amazon}&images=${JSON.stringify(all_images)}`
        if (!welcome_screen) {
            link = `<?php echo LANDING_PAGE_URL;?>app?SecondaryColor=${SecondaryColor.replace("#","")}&primaryColor=${primaryColor.replace("#","")}&app_title=${app_title}&app_description=${app_description}&font_title=${font_title}&font_text=${font_text}&app_website=${app_website}&app_company=${app_company}&google=${google}&apple=${apple}&amazon=${amazon}&images=${JSON.stringify(all_images)}`
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
<script src="<?= ASSETS_FULL_URL ?>js/qr_form.js"></script>