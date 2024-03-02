<div class="custom-accodian">
    <button class="btn accodianBtn" type="button" data-toggle="collapse" data-target="#trackingAnalytics" aria-expanded="false" aria-controls="trackingAnalytics">
      <span class="password">Tracking Analytics</span>
      <svg class="MuiSvgIcon-root MuiSvgIcon-colorPrimary leftArrow" focusable="false" viewBox="0 0 16 16" aria-hidden="true" style="font-size: 16px;">
        <path d="M12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5ZM12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5Z"></path>
      </svg>
    </button>
    <div class="collapse" id="trackingAnalytics">
      <div class="collapseInner">
        <div class="form-group">
          <label for="name"> <?= l('qr_codes.input.google_analytics_tracking_id') ?></label>
          <input id="google_analytic_id" type="text" name="google_analytic_id" class="form-control" value="" maxlength="255"/>
        </div>
        <div class="form-group m-0">
          <label for="name"> <?= l('qr_codes.input.facebook_pixel_id') ?></label>
          <input id="facebook_pixel_id" type="text" name="facebook_pixel_id" class="form-control" value="" maxlength="255" />
        </div>
      </div>
    </div>
</div>