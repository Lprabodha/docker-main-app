<link rel="stylesheet" href="<?=ASSETS_FULL_URL?>css/components/upgrade_popup.css?v=<?=PRODUCT_CODE?>">

<div class="modal custom-modal fade upgradePopup" id="upgradePopup" tabindex="-1" aria-labelledby="upgradePopup" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-export">
        <div class="modal-content" style="border-radius:15px;">
            <div class="modal-head position-relative">
                <div class="head-logo position-absolute top-0 start-50 translate-middle">
                    <div class="logo-container">
                        <img class="brand-logo" src="<?= ASSETS_FULL_URL ?>images/OQG_Brand_Logo.png" alt="Online-QR-Generator">
                    </div>
                </div>
                <button type="button" class="close position-absolute top-0 start-100 translate-middle" id="closeBtn" data-dismiss="modal" aria-label="Close">
                    <span class="icon-failed"></span>
                </button>
            </div>
            <div class="modal-body">
                <div class="body-head">
                    <span><?=l('upgrade_popup.head.heading')?></span>
                    <div class="head-divider"></div>
                    <h4><?=l('upgrade_popup.head.title')?></h4>
                    <h6><?=l('upgrade_popup.head.description')?></h6>
                </div>
                <div class="popup-image">
                    <img src="<?= ASSETS_FULL_URL ?>images/upgrade_popup/upgrade_popup_image.jpg" alt="popup_image">
                </div>
                <div class="features-section">
                    <div class="features">
                        <?php
                            for($i=1; $i<=9;$i++):
                        ?>
                        <div class="feature-row">
                            <span class="f-icon"><i class="icon-checker"></i></span>
                            <span class="f-text"><?=l("upgrade_popup.features.feature_$i")?></span>
                        </div>
                        <?php endfor?>
                    </div>
                </div>
                <div class="body-footer">
                    <a href="<?=url('plan')?>"><?=l('upgrade_popup.upgrade_btn')?></a>
                </div>
            </div>
        </div>
    </div>
</div>

