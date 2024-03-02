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
    <button class="btn accodianBtn" type="button" data-toggle="collapse" data-target="#acc_nameOfQrPdf" aria-expanded="true" aria-controls="acc_nameOfQrPdf">
      <span>PDF file</span>
      <svg class="MuiSvgIcon-root MuiSvgIcon-colorPrimary leftArrow" focusable="false" viewBox="0 0 16 16" aria-hidden="true" style="font-size: 16px;">
        <path d="M12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5ZM12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5Z"></path>
      </svg>
    </button>
    <div class="collapse show" id="acc_nameOfQrPdf">
      <div class="collapseInner">
        <!-- <input type="hidden" id="uId" name="uId" class="form-control" value="<?= uniqid() ?>" data-reload-qr-code /> -->
        <div class="custom-upload">
          <label for="pdf">

            <!-- Before Upload Priview -->
            <div class="before-upload">
              <input type="file" id="pdf" onchange="LoadPreview()" name="pdf" class="form-control py-2" accept="application/pdf" value="" required data-reload-qr-code />
              <button type="button" class="upload-btn">Upload PDF</button>
              <span>Maximum size: 100MB</span>
            </div>

            <!-- After Upload Priview -->
            <!-- <div class="after-upload">
              <div class="d-flex align-items-center">
                <img src="<?= ASSETS_FULL_URL . 'images/after_upload.svg'; ?>" alt="">
                <span>abc.pdf</span>
              </div>
              <button type="button" class="change-btn">change</button>
            </div> -->
          </label>
        </div>

        <div class="checkbox-wrapper">
          <div class="roundCheckbox m-2 mr-3">
            <input type="checkbox" id="direct_pdf" name="direct_pdf" data-reload-qr-code />
            <label class="m-0" for="direct_pdf"></label>
          </div>
          <label class="passwordlabel mb-0">Directly show the PDF file</label>
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

  <div class="custom-accodian consider">
    <button class="btn accodianBtn" type="button" data-toggle="collapse" data-target="#acc_pdfInformation" aria-expanded="true" aria-controls="acc_pdfInformation">
      <span>PDF information</span>
      <svg class="MuiSvgIcon-root MuiSvgIcon-colorPrimary leftArrow" focusable="false" viewBox="0 0 16 16" aria-hidden="true" style="font-size: 16px;">
        <path d="M12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5ZM12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5Z"></path>
      </svg>
    </button>
    <div class="collapse show" id="acc_pdfInformation">
      <div class="collapseInner">

        <div class="form-group mb-4">
          <label for="company" class="formLabel"> <?= l('qr_codes.input.company') ?></label>
          <input id="company" onchange="LoadPreview()" placeholder="E.g. Tech & Corp" name="company" class="form-control" value="" data-reload-qr-code />
        </div>

        <div class="form-group mb-4">
          <label for="pdftitle" class="formLabel"> <?= l('qr_codes.input.pdf_title') ?></label>
          <input id="pdftitle" onchange="LoadPreview()" placeholder="E.g. Menifesto" name="pdftitle" class="form-control" value="" data-reload-qr-code />
        </div>

        <div class="form-group mb-4">
          <label for="description" class="formLabel"> <?= l('qr_codes.input.description') ?></label>
          <input id="description" onchange="LoadPreview()" placeholder="E.g. Full Tech & Corp Menifesto" name="description" class="form-control" value="" data-reload-qr-code />
        </div>

        <div class="form-group mb-4">
          <label for="website" class="formLabel"> <?= l('qr_codes.input.website') ?></label>
          <input id="website" name="website" onchange="LoadPreview()" placeholder="E.g. https://www.techcorp.com/" class="form-control" value="" data-reload-qr-code />
        </div>

        <div class="form-group m-0">
          <label for="button" class="formLabel"> <?= l('qr_codes.input.button') ?></label>
          <input id="button" name="button" onchange="LoadPreview()" placeholder="E.g. View pdf" class="form-control" value="" data-reload-qr-code />
        </div>
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
        </div>
      </div>
    </div>
  </div>

  <!-- <?php include_once('accodian-form-group/tracking-analytics.php'); ?> -->

</div>
<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script>
  function LoadPreview(welcome_screen = false) {
    let uId = document.getElementById('uId').value;
    let company = document.getElementById('company').value;
    let pdftitle = document.getElementById('pdftitle').value;
    let primaryColor = document.getElementById('primaryColor').value;
    let SecondaryColor = document.getElementById('SecondaryColor').value;
    let description = document.getElementById('description').value;
    let website = document.getElementById('website').value;
    let button = document.getElementById('button').value;
    let font_title = document.getElementById('filters_title_by').value;
    let font_text = document.getElementById('filters_text_by').value;
    let tmp_screen = document.getElementById('screen').value;
    var filesscreen = document.getElementById("screen").files;

    var pdf_url = "<?php echo SITE_URL ?>uploads/pdf/" + uId + ".pdf";
    var screen = filesscreen.length ? "<?php echo SITE_URL ?>uploads/pdf/" + uId + "_" + filesscreen[0].name + "" : "";


    // let link = `<?php echo LANDING_PAGE_URL; ?>pdf?company=${company}&pdftitle=${pdftitle}&primaryColor=${primaryColor.replace("#","")}&secondaryColor=${SecondaryColor.replace("#","")}&description=${description}&font_title=${font_title}&font_text=${font_text}&screen=${screen}&button=${button}&pdf=${pdf_url}`
    let link = `<?php echo LANDING_PAGE_URL; ?>pdf?company=${company}&pdftitle=${pdftitle}&primaryColor=${primaryColor.replace("#","")}&SecondaryColor=${SecondaryColor.replace("#","")}&description=${description}&font_title=${font_title}&font_text=${font_text}&screen=${screen}&button=${button}&pdf=${pdf_url}&website=${website}`
    if (!welcome_screen) {
      link = `<?php echo LANDING_PAGE_URL; ?>pdf?company=${company}&pdftitle=${pdftitle}&primaryColor=${primaryColor.replace("#","")}&SecondaryColor=${SecondaryColor.replace("#","")}&description=${description}&font_title=${font_title}&font_text=${font_text}&button=${button}&pdf=${pdf_url}&website=${website}`
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

  function swapValues() {
    var tmp = document.getElementById("primaryColor").value;
    document.getElementById("primaryColor").value = document.getElementById("SecondaryColor").value;
    document.getElementById("SecondaryColor").value = tmp;
    // document.getElementById('primaryColortxt').innerHTML = document.getElementById("SecondaryColor").value;
    // document.getElementById('SecondaryColortxt').innerHTML = tmp;
    LoadPreview()
  }
</script>
<script src="<?= ASSETS_FULL_URL ?>js/qr_form.js"></script>
<script>
  $(document).on('change', '#direct_pdf', function() {

    if ($(this).is(":checked")) {
      $('#company').removeAttr('required');
      $('.consider').hide();
    } else {
      $('#company').prop('required', true);
      $('.consider').show();
    }
  });
</script>