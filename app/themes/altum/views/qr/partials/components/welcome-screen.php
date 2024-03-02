<div class="custom-accodian consider">
  <button class="btn accodianBtn collapsed" type="button" data-toggle="collapse" data-target="#acc_welcomeScreen" aria-expanded="true" aria-controls="acc_welcomeScreen">
    <div class="qr-step-icon">
      <span class="icon-welcome grey steps-icon"></span>
    </div>

    <span class="custom-accodian-heading">
      <span><?= l('qr_step_2_com_welcome_screen.welcome_screen') ?></span>
      <span class="fields-helper-heading"><?= l('qr_step_2_com_welcome_screen.help_txt.welcome_screen') ?></span>
    </span>

    <div class="toggle-icon-wrap ml-2">
      <span class="icon-arrow-h-right grey toggle-icon"></span>
    </div>
  </button>

  <div class="collapse " id="acc_welcomeScreen">
    <hr class="accordian-hr">
    <div class="collapseInner">
      <div class="welcome-screen">
        <!-- <span><?= l('qr_step_2_com_welcome_screen.image') ?><</span> -->
        <!-- Before Upload Priview -->
        <div class="screen-upload justify-content-flex-start">
          <div class="d-flex align-items-center  mr-sm-2 mr-0">
            <label for="screen">
              <input type="hidden" name="welcomescreen" id="editscreen" value="<?php echo (!empty($filledInput) && isset($filledInput['welcomescreen']) ? $filledInput['welcomescreen'] : ''); ?>">

              <input type="file" id="screen" name="screen" class="form-control py-2" value="" accept="image/png, image/gif, image/jpeg" input_size_validate />
              <div class="input-image d-flex align-item-center justify-content-center" id="input-image">
                <?php
                if (!empty($filledInput) && (isset($filledInput['welcomescreen'])) && $filledInput['welcomescreen'] != '') {
                ?>
                  <img src="<?php echo $filledInput['welcomescreen']; ?>" height="" width="" alt="Welcome screen image" id="upl-img" />
                <?php
                }
                ?>
                <span class="icon-upload-image mb-0 " id="tmp-mage" style="display:<?php echo (!empty($filledInput) && (isset($filledInput['welcomescreen'])) && $filledInput['welcomescreen'] != '') ? 'none' : 'flex'; ?>;"></span>
              </div>
              <div class="add-icon" id="add-icon" style="opacity:0; display:<?php echo (!empty($filledInput) && (isset($filledInput['welcomescreen'])) && $filledInput['welcomescreen'] != '') ? 'none' : 'block'; ?>;">
                <svg style="margin: 7px;" class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                  <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"></path>
                </svg>
              </div>
              <div class="add-icon" id="edit-icon" style="opacity:0; display:<?php echo (!empty($filledInput) && (isset($filledInput['welcomescreen'])) && $filledInput['welcomescreen'] != '') ? 'block' : 'none'; ?>;">
                <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 24px;margin: 7px;">
                  <path d="M20.71,6.29l-3-3a1,1,0,0,0-1.42,0l-12,12a1,1,0,0,0-.26.47l-1,4a1,1,0,0,0,.26.95A1,1,0,0,0,4,21a1,1,0,0,0,.24,0l4-1a1,1,0,0,0,.47-.26l12-12A1,1,0,0,0,20.71,6.29ZM7.49,18.1l-2.12.53.53-2.12,8.6-8.6L16.09,9.5Zm10-10L15.91,6.5,17,5.41,18.59,7Z"></path>
                </svg>
              </div>
            </label>
          </div>
          <div class="d-flex flex-sm-row flex-column">
            <button type="button" id="custom_preview" class=" mb-sm-0 mb-1 upload-btn prevw-deskd mobile-preview-w ms-auto ml-sm-2" onclick="LoadPreview(true, false)" <?php echo (!empty($filledInput) && (isset($filledInput['welcomescreen'])) && $filledInput['welcomescreen'] != '') ? '' : 'disabled'; ?>><?= l('qr_step_2_com_welcome_screen.preview') ?></button>
            <!-- <button type="button" id="custom_preview_one" class="upload-btn prevw-mob preview-qr-btn mb-sm-0 mb-1" onclick="LoadPreview(true, false)" disabled><?= l('qr_step_2_com_welcome_screen.preview') ?></button> -->
            <button type="button" class="delete-btn ml-sm-2 " id="screen_delete" style="display:<?php echo (!empty($filledInput) && (isset($filledInput['welcomescreen'])) && $filledInput['welcomescreen'] != '') ? 'flex' : 'none'; ?>;">
              <?= l('qr_step_2_com_welcome_screen.delete') ?>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  $("#screen").change(function() {
    var randomNum = generateRandomNumber();
    $("#uploadUniqueId").val(randomNum);
    LoadPreview()
  });
  $(".mobile-preview-w").click(function() {
      $("#overlayPre").addClass("active-preview")
      $("body").not(".app").addClass("scroll-none");
      $(".col-right.customScrollbar").addClass("active");
    });
    $(".exitPreview").click(function() {
      $("#overlayPre").removeClass("active-preview")
      $("body").not(".app").removeClass("scroll-none");
      $(".col-right.customScrollbar").removeClass("active");

    });
</script>