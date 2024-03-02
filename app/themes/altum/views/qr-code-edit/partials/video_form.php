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
                    <input id="name" name="name" placeholder="E.g. My QR code" class="form-control mb-1" value="" maxlength="<?= $data->qr_code_settings['type']['business']['name']['max_length'] ?>" required data-reload-qr-code />
                </div>
            </div>
        </div>
    </div>

    <div class="custom-accodian">
        <button class="btn accodianBtn" type="button" data-toggle="collapse" data-target="#acc_videoUpload" aria-expanded="true" aria-controls="acc_videoUpload">
            <span>Video</span>
            <svg class="MuiSvgIcon-root MuiSvgIcon-colorPrimary leftArrow" focusable="false" viewBox="0 0 16 16" aria-hidden="true" style="font-size: 16px;">
                <path d="M12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5ZM12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5Z"></path>
            </svg>
        </button>
        <div class="collapse show" id="acc_videoUpload">
            <div class="collapseInner">
                <!--<div class="form-group m-0">
                    <div class="mb-2">
                        <input type="radio" onchange="hideB(this)" name="video_type" checked><label class="ml-2 mr-2 mb-0">URL</label> |
                        <input class="ml-2" type="radio" onchange="hideA(this)" name="video_type"><label class="ml-2 mb-0">Upload Video</label>
                    </div>
                    <div id="url" class="form-group m-0" data-type="video" data-url>
                        <input type="hidden" id="uId" name="uId" class="form-control" value="<?= uniqid() ?>" data-reload-qr-code />
                        <label for="video_url"><i class="fa fa-fw fa-link fa-sm mr-1"></i> <?= l('qr_codes.input.video_url') ?></label>
                        <input type="url" id="video_url" name="url" placeholder="https://www.youtube.com/watch�" class="form-control" value="" maxlength="<?= $data->qr_code_settings['type']['video']['max_length'] ?>" required="required" data-reload-qr-code />
                    </div>
                    <div id="file" class="form-group" data-type="video" style="display:none">
                        <input type="hidden" id="uId" name="uId" class="form-control" value="<?= uniqid() ?>" data-reload-qr-code />
                        <label for="video_file"><i class="fa fa-fw fa-link fa-sm mr-1"></i> <?= l('qr_codes.input.video_upload') ?></label>
                        <input type="file" id="video_file" name="video_file" accept="video/mp4,video/x-m4v,video/*" class="form-control py-2" value="" required="required" data-reload-qr-code />
                    </div>
                </div> -->
                <div class="d-flex align-items-end r-form">
                    <div id="url" class="form-group w-100 mr-3" data-type="video" data-url>
                        <label for="youTubeUrl"> <?= l('qr_codes.input.video_url') ?></label>
                        <input type="url" onchange="validateYouTubeUrl()" id="youTubeUrl" name="youTubeUrl" placeholder="https://www.youtube.com/watch..." class="form-control mr-3 w-100" data-reload-qr-code />
                    </div>
                    <div class="form-group">
                        <button class="accountSaveButton" onclick="addVideo()" id="youtubeSubmit" type="button" disabled>Add video</button>
                    </div>
                </div>

                <p id="validYoutube" style="color:red; display:none;">Invalid URL. Enter a YouTube link.</p>
                <div class="form-group m-0">
                    <label>If you prefer, you can also upload your video</label>
                </div>
                <div class="custom-upload mb-3">
                    <label for="video_file">

                        <!-- Before Upload Priview -->
                        <div class="before-upload">
                            <input type="file" id="video_file" onchange="setTimeout(function() { document.getElementById('video_loader').style.display='none'; document.getElementById('loader').style.display = 'block'; document.getElementById('iframesrc').style.visibility = 'hidden'; LoadPreview(); }, 5000);" name="video_file[]" class="form-control py-2" accept="video/mp4,video/x-m4v,video/*" multiple data-reload-qr-code />

                            <!-- <input type="file" id="video_file" onchange="LoadPreview()" name="video_file" class="form-control py-2" accept="video/mp4,video/x-m4v,video/*" multiple data-reload-qr-code /> -->
                            <button type="button" class="upload-btn" onclick="loader()">

                                Upload video(s)
                            </button>
                            <div class="spinner-grow mt-2" id="video_loader" role="status" style="display:none;">
                                <span class="sr-only">Loading...</span>
                            </div>
                            <span>Maximum size: 100MB</span>
                        </div>
                    </label>
                </div>

                <!-- After Upload Priview -->
                <div class="mb-4" id="video_preview">


                </div>
                <div class="checkbox-wrapper mb-4">
                    <div class="roundCheckbox m-2 mr-3">
                        <input type="checkbox" id="direct_video" name="direct_video" onchange="LoadPreview()" />
                        <label class="m-0" for="direct_video"></label>
                    </div>
                    <label class="passwordlabel mb-0">Show the video directly</label>
                </div>
                <div class="checkbox-wrapper mb-4">
                    <div class="roundCheckbox m-2 mr-3">
                        <input type="checkbox" name="Highlight" id="Highlight" onchange="LoadPreview()" />
                        <label class="m-0" for="Highlight"></label>
                    </div>
                    <label class="passwordlabel mb-0">Highlight the first video</label>
                </div>
                <div class="checkbox-wrapper">
                    <div class="roundCheckbox m-2 mr-3">
                        <input type="checkbox" name="Autoplay" id="Autoplay" onchange="LoadPreview()" />
                        <label class="m-0" for="Autoplay"></label>
                    </div>
                    <label class="passwordlabel mb-0">Autoplay the first video</label>
                </div>
            </div>
        </div>
    </div>
    <div class="custom-accodian consider">
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

    <div class="custom-accodian consider">
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
              <label for="filters_title_by" class="fieldLabel">Title</label>
              <div class="custom-select-box">
               
                <input readonly
                  type="text" 
                  value="<?php echo (!empty($filledInput) && ($filledInput['font_title'])) ? ($filledInput['font_title']): 'Lato';?>"  
                  style="font-family: <?php echo (!empty($filledInput) && ($filledInput['font_title'])) ? ($filledInput['font_title']): 'Lato';?> ;"
                  id="filters_title_by" 
                  onchange="LoadPreview()" 
                  name="font_title"
                >
                <div class="dropdown">
                      <butoon type="button" class="btn drp-btn btn-lato" value="Lato">Lato</butoon>
                      <butoon type="button" class="btn drp-btn btn-open" value="Open Sans">Open Sans</butoon>
                      <butoon type="button" class="btn drp-btn btn-robo" value="Roboto">Roboto</butoon>
                      <butoon type="button" class="btn drp-btn btn-oswa" value="Oswald">Oswald</butoon>
                      <butoon type="button" class="btn drp-btn btn-mont" value="Montserrat">Montserrat</butoon>
                      <butoon type="button" class="btn drp-btn btn-sour" value="Source Sans Pro">Source Sans Pro</butoon>
                      <butoon type="button" class="btn drp-btn btn-slab" value="Slabo 27px">Slabo 27px</butoon>
                      <butoon type="button" class="btn drp-btn btn-rale" value="Raleway">Raleway</butoon>
                      <butoon type="button" class="btn drp-btn btn-merr" value="Merriwealther">Merriwealther</butoon>
                      <butoon type="button" class="btn drp-btn btn-noto" value="Noto Sans">Noto Sans</butoon>                   
                </div>

              </div>
              
            </div>
            <div class="form-group m-0 col-md-6 col-sm-12">
              <label for="filters_text_by" class="fieldLabel">Texts</label>
              <div class="custom-select-box">
                <input 
                type="text" 
                value="<?php echo (!empty($filledInput) && ($filledInput['font_text'])) ? ($filledInput['font_text']) : 'Lato';?>" 
                style="font-family: <?php echo (!empty($filledInput) && ($filledInput['font_text'])) ? ($filledInput['font_text']): 'Lato';?> ;"
                readonly 
                id="filters_text_by" 
                onchange="LoadPreview()" 
                name="font_text"
              >
                <div class="dropdown">
                      <butoon type="button"  class="btn drp-btn btn-lato" value="Lato">Lato</butoon>
                      <butoon type="button"  class="btn drp-btn btn-open" value="Open Sans">Open Sans</butoon>
                      <butoon type="button"  class="btn drp-btn btn-robo" value="Roboto">Roboto</butoon>
                      <butoon type="button"  class="btn drp-btn btn-oswa" value="Oswald">Oswald</butoon>
                      <butoon type="button"  class="btn drp-btn btn-mont" value="Montserrat">Montserrat</butoon>
                      <butoon type="button"  class="btn drp-btn btn-sour" value="Source Sans Pro">Source Sans Pro</butoon>
                      <butoon type="button"  class="btn drp-btn btn-slab" value="Slabo 27px">Slabo 27px</butoon>
                      <butoon type="button"  class="btn drp-btn btn-rale" value="Raleway">Raleway</butoon>
                      <butoon type="button"  class="btn drp-btn btn-merr" value="Merriwealther">Merriwealther</butoon>
                      <butoon type="button"  class="btn drp-btn btn-noto" value="Noto Sans">Noto Sans</butoon>                   
                </div>

              </div>
            
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

    <div class="custom-accodian consider">
        <button class="btn accodianBtn" type="button" data-toggle="collapse" data-target="#acc_contactInfo" aria-expanded="true" aria-controls="acc_contactInfo">
            <span><?= l('qr_codes.input.videoInformation') ?></span>
            <svg class="MuiSvgIcon-root MuiSvgIcon-colorPrimary leftArrow" focusable="false" viewBox="0 0 16 16" aria-hidden="true" style="font-size: 16px;">
                <path d="M12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5ZM12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5Z"></path>
            </svg>
        </button>
        <div class="collapse show" id="acc_contactInfo">
            <div class="collapseInner">
                <div class="form-group">
                    <label for="companyName"> <?= l('qr_codes.input.company') ?></label>
                    <input id="companyName" onchange="LoadPreview()" name="companyName" class="form-control" value="" maxlength="<?= $data->qr_code_settings['type']['menu']['companyTitle']['max_length'] ?>" data-reload-qr-code />
                </div>
                <div class="form-group">
                    <label for="videoTitle"> <?= l('qr_codes.input.videoTitle') ?></label>
                    <input id="videoTitle" onchange="LoadPreview()" name="videoTitle" class="form-control" value="" maxlength="<?= $data->qr_code_settings['type']['menu']['companyTitle']['max_length'] ?>" data-reload-qr-code />
                </div>
                <div class="form-group">
                    <label for="videoDescription"> <?= l('qr_codes.input.description') ?></label>
                    <input id="videoDescription" onchange="LoadPreview()" name="videoTitle" class="form-control" value="" maxlength="<?= $data->qr_code_settings['type']['menu']['companyTitle']['max_length'] ?>" data-reload-qr-code />
                </div>

                <!-- <div id="addBtn">
                    <button id="add2" class="outlineBtn addRowButton" onclick="showFields(this)"><i class="fa fa-fw fa-plus fa-sm mr-1"></i> <?= l('qr_codes.input.addButton') ?></button>
                </div> -->
            </div>
        </div>
    </div>

    <div class="custom-accodian consider">
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
                            <input type="file" id="screen" name="screen" onchange="setTimeout(function() { console.log('here'); document.getElementById('loader').style.display = 'block'; document.getElementById('iframesrc').style.visibility = 'hidden'; LoadPreview(); }, 5000);" class="form-control py-2" value=""  accept="image/png, image/gif, image/jpeg"   required="required" data-reload-qr-code />
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

    <div class="custom-accodian consider">
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

    <!-- <div class="form-group">
        <label for="password"> Password</label>
        <input id="password" type="password" name="password" class="form-control" value="" maxlength="30" required="required" data-reload-qr-code />
    </div> -->
    <!-- <?php include_once('accodian-form-group/tracking-analytics.php'); ?> -->
</div>

<script>
    var base_url = '<?php echo SITE_URL?>'

    $(".custom-select-box input").click(function() {
        $(this).next(".dropdown").addClass('active')
    });


    $(".custom-select-box .dropdown .drp-btn").click(function() {
        $(this).parents(".dropdown").removeClass('active');
        let setFont = $(this).parents(".custom-select-box").children('input');
        setFont.attr("value", $(this).attr("value"));
        setFont.css("font-family", $(this).attr("value"));
        LoadPreview();
    });
    $(".custom-select-box .dropdown") .mouseleave(function() {
        $(this).removeClass('active')
    });
    $(".custom-select-box .dropdown") .mouseleave(function() {
        $(this).next(".dropdown").removeClass('active')
    });
    $(".custom-select-box input") .mouseleave(function() {
        $(this).removeClass('active')
    });


    function LoadPreview(welcome_screen = false) {
        let youTubeUrl = document.getElementById('youTubeUrl').value;
        let video_files = document.getElementById('video_file').files;
        let direct_video = document.getElementById('direct_video').checked;
        let Highlight = document.getElementById('Highlight').checked;
        let Autoplay = document.getElementById('Autoplay').checked;
        let primaryColor = document.getElementById('primaryColor').value;
        let companyName = document.getElementById('companyName').value;
        let videoTitle = document.getElementById('videoTitle').value;
        let videoDescription = document.getElementById('videoDescription').value;
        // let screen = document.getElementById('screen').value;
        // let passwordField = document.getElementById('passwordField').value;
        let uId = document.getElementById('uId').value;
        let font_title = document.getElementById('filters_title_by').value;
        let font_text = document.getElementById('filters_text_by').value;
        var filesscreen = document.getElementById("screen").files;

        var screen = filesscreen && filesscreen.length ? base_url + "uploads/screen/" + uId + "_" + filesscreen[0].name + "" : "";

        // let company = document.getElementById('company').value;
        // let pdftitle = document.getElementById('pdftitle').value;
        // let primaryColor = document.getElementById('primaryColor').value;
        // let SecondaryColor = document.getElementById('SecondaryColor').value;
        // let description = document.getElementById('description').value;
        // let website = document.getElementById('website').value;
        // let button = document.getElementById('button').value;
        // let font_title = document.getElementById('filters_title_by').value;
        // let font_text = document.getElementById('filters_text_by').value;
        // let tmp_screen = document.getElementById('screen').value;
        // var filesscreen = document.getElementById("screen").files;

        // var pdf_url = "<?php echo SITE_URL?>uploads/pdf/" + uId + ".pdf";
        var all_videos = [];
        for (var i = 0; i < video_files.length; i++) {
            var video = base_url + "uploads/video/" + uId + "_" + i + "_" + video_files[i].name + "";
            // console.log(image);
            all_videos.push(video)
        }

        // let link = `<?php echo LANDING_PAGE_URL;?>pdf?company=${company}&pdftitle=${pdftitle}&primaryColor=${primaryColor.replace("#","")}&secondaryColor=${SecondaryColor.replace("#","")}&description=${description}&font_title=${font_title}&font_text=${font_text}&screen=${screen}&button=${button}&pdf=${pdf_url}`
        let link = `<?php echo LANDING_PAGE_URL;?>video?youTubeUrl=${youTubeUrl}&video_file=${JSON.stringify(all_videos)}&direct_video=${direct_video || ""}&Highlight=${Highlight||""}&Autoplay=${Autoplay||""}&primaryColor=${primaryColor.replace("#","")}&companyName=${companyName}&videoTitle=${videoTitle}&videoDescription=${videoDescription}&screen=${screen}&font_title=${font_title}&font_text=${font_text}`
        if (!welcome_screen) {
            link = `<?php echo LANDING_PAGE_URL;?>video?youTubeUrl=${youTubeUrl}&video_file=${JSON.stringify(all_videos)}&direct_video=${direct_video || ""}&Highlight=${Highlight||""}&Autoplay=${Autoplay||""}&primaryColor=${primaryColor.replace("#","")}&companyName=${companyName}&videoTitle=${videoTitle}&videoDescription=${videoDescription}&font_title=${font_title}&font_text=${font_text}`
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


    const input = document.getElementById('video_file')

    input.addEventListener('change', (event) => {
        const target = event.target
        console.log("Upload")
        if (target.files && target.files[0]) {

            /*Maximum allowed size in bytes
              5MB Example
              Change first operand(multiplier) for your needs*/
            const maxAllowedSize = 300 * 1024 * 1024;
            if (target.files[0].size > maxAllowedSize) {
                // Here you can ask your users to load correct file
                target.value = ''
                alert("Maximum allowed size is 100MB")
            } else {

                // $('.video-preview').attr('src', URL.createObjectURL(this.files[0]));
                // $('.video-prev').show();

                var vidHtml = `<div class="afterImage-upload align-items-start" >
                        <div class="d-flex flex-1">
                            <div class="videoPreview">
                               
                                <video class="video-fluid z-depth-1" loop controls muted>
                                    <source src=` + URL.createObjectURL(target.files[0]) + ` />
                                </video>
                            </div>
                            <div class="previewDetail flex-1">
                                <label class="f-500 mt-3">
                                    <h5>` + target.files[0].name + `</h5>
                                </label>
                            </div>
                        </div>
                        <div class="d-flex">
                            <button type="button" onclick="deleteVideo(this)">
                                <svg class="MuiSvgIcon-root" color="#FE4256" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 24px;">
                                    <path d="M20,7H4A1,1,0,0,0,4,9H5.08l.77,9.25a3,3,0,0,0,3,2.75h6.32a3,3,0,0,0,3-2.75L18.92,9H20a1,1,0,0,0,0-2ZM16.16,18.08a1,1,0,0,1-1,.92H8.84a1,1,0,0,1-1-.92L7.09,9h9.82Z"></path>
                                    <path d="M9,5h6a1,1,0,0,0,0-2H9A1,1,0,0,0,9,5Z"></path>
                                </svg>
                            </button>

                        </div>
                    </div>`;
                $('#video_preview').append(vidHtml);

            }
        }
    })

    function deleteVideo(elm) {
        remove_me(elm);
        document.getElementById('video_file').value = "";
        LoadPreview();
    }

    function deleteYoutubeVideo(elm) {
        remove_me(elm);
        document.getElementById('youTubeUrl').value = "";
        LoadPreview();
    }

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
        thisObj.closest('#addBtnfields').remove();
        var html = `<div id="addBtn">
                    <button id="add2" class="btn outlineBtn addRowButton" onclick="showFields(this)"><i class="fa fa-fw fa-plus fa-sm mr-1"></i> <?= l('qr_codes.input.addButton') ?></button>
                </div>`;


        $('#acc_contactInfo').find('div.collapseInner').append(html);

    }

    function showFields(thisObj) {
        // var parent = thisObj.closest('div.collapseInner');
        var parent = thisObj.closest('#acc_contactInfo');
        thisObj.closest("#addBtn").remove();
        var html = `<div class="borderSection" id="addBtnfields">
                    <div class="form-group m-0">
                        <label for="contactMobiles"> <?= l('qr_codes.input.button') ?></label>
                        <div class="d-flex align-items-center w-100">
                            <div class="d-flex align-items-center w-100">
                                <input class="form-control mr-3" type="text" name="video_button_text[]" placeholder="Write the button text here..." />
                                <input class="form-control mr-3" type="tel" name="video_button_urls[]" placeholder="https://" />
                            </div>
                            <button type="button" class="reapeterCloseIcon removeBtn" onclick="showButton(this)">
                                <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"></path></svg>
                            </button>
                        </div>
                    </div>
                </div>`;

        $('#acc_contactInfo').find('div.collapseInner').append(html);

    }

    function validateYouTubeUrl() {
        // youtubeSubmit - validYoutube
        var url = $('#youTubeUrl').val();
        if (url != undefined || url != '') {
            var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=|\?v=)([^#\&\?]*).*/;
            var match = url.match(regExp);
            if (match && match[2].length == 11) {
                // Do anything for being valid
                // if need to change the url to embed url then use below line
                $('#ytplayerSide').attr('src', 'https://www.youtube.com/embed/' + match[2] + '?autoplay=0');
                $('#youtubeSubmit').attr('disabled', false);
                $('#validYoutube').hide();
                LoadPreview();
            } else {
                $('#youtubeSubmit').attr('disabled', true);
                $('#validYoutube').show();
                // Do anything for not being valid
            }
        }
    }

    // $("#upload_btn").click(function() {
    //     console.log("Upload")
    //     $("#video_loader").css("display", "block")
    // });

    function loader() {
        console.log("Upload");
        document.getElementById("video_loader").style.display = "block";
    }
</script>
<script src="<?= ASSETS_FULL_URL ?>js/qr_form.js"></script>
<script>
    $(document).on('change', '#direct_video', function() {

        if ($(this).is(":checked")) {

            $('.consider').hide();
        } else {
            $('.consider').show();
        }
    });

    // video_preview
    function addVideo() {
        var videoUrl;
        var id;
        if (document.getElementById('youTubeUrl').value) {
            videoUrl = document.getElementById('youTubeUrl').value;
            let re = /(https?:\/\/)?(((m|www)\.)?(youtube(-nocookie)?|youtube.googleapis)\.com.*(v\/|v=|vi=|vi\/|e\/|embed\/|user\/.*\/u\/\d+\/)|youtu\.be\/)([_0-9a-z-]+)/i;
            id = (document.getElementById('youTubeUrl').value).match(re)[7];
            console.log(id);
            var vidHtml = `<div class="afterImage-upload align-items-start">
                        <div class="d-flex flex-1">
                            <div class="videoPreview">
                                <iframe src="https://www.youtube.com/embed/` + id + `" alt=""></iframe>
                            </div>
                            <div class="previewDetail flex-1">
                                <label class="f-500 mt-3">
                                    <h5>Youtube Video</h5>
                                </label>
                            </div>
                        </div>
                        <div class="d-flex">
                            <button type="button" onclick="deleteYoutubeVideo(this)">
                                <svg class="MuiSvgIcon-root" color="#FE4256" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 24px;">
                                    <path d="M20,7H4A1,1,0,0,0,4,9H5.08l.77,9.25a3,3,0,0,0,3,2.75h6.32a3,3,0,0,0,3-2.75L18.92,9H20a1,1,0,0,0,0-2ZM16.16,18.08a1,1,0,0,1-1,.92H8.84a1,1,0,0,1-1-.92L7.09,9h9.82Z"></path>
                                    <path d="M9,5h6a1,1,0,0,0,0-2H9A1,1,0,0,0,9,5Z"></path>
                                </svg>
                            </button>

                        </div>
                    </div>`;
            $('#video_preview').append(vidHtml);
        }
    }
</script>