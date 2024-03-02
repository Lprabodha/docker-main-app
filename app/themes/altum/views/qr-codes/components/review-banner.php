<div class="feedback-banner r-4" id="fbBanner">
    <div class="feedback-section">
        <div class="feedback-des-wrp">
            <div class="d-flex">
                <svg class="MuiSvgIcon-root expire-icon MuiSvgIcon-fontSizeMedium MuiSvgIcon-root MuiSvgIcon-fontSizeLarge css-1shn170" focusable="false" aria-hidden="true" viewBox="0 0 24 24" data-testid="ErrorIcon" tabindex="-1" title="Error">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"></path>
                </svg>
            </div>
            <div class="feedback-text ">
                <p class="bil-des bil-des1 "><?= l('qr_codes.review_banner_des') ?></p>
            </div>
        </div>
        <div class="feedback-buttons">
            <div>
                <!-- <a href="https://g.page/r/CWAbVtg9iBaZEBI/review" class="btn btn-light feedback-review-btn" onclick="feedback_close_btn()" target="_blank"><?= l('qr_codes.review_banner_write_btn') ?></a> -->
                <button class="btn btn-light feedback-review-btn" data-toggle="modal" data-target="#reviewModal"><?= l('qr_codes.review_banner_write_btn') ?></button>
            </div>
            <button class="feedback-close-btn" onclick="feedback_close_btn()">
                <svg class="feedback-close-icon" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"></path>
                </svg>
            </button>
        </div>
    </div>
</div>


<!-- Review Modal -->
<div class="modal custom-modal fade" id="reviewModal" data-backdrop="static" tabindex="-1" aria-labelledby="reviewModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-export review-modal-wrap">
        <div class="modal-content review-modal-content">

            <button data-dismiss="modal" class="review-close-btn review-modal-close" id="closeBtn" onclick="feedback_close_btn()">
                <span class="icon-failed review-close-icon"></span>
            </button>

            <div class="mx-6 my-4 review-modal-inner">
                <div class="review-title-1 text-center mx-3">
                    <p><?= l('qr_codes.review_modal_text_1') ?></p>
                </div>

                <div class="my-6">
                    <hr>
                    <div class="review-logo-bg-content">
                        <div class="review-logo-bg-wrap">
                            <div class="review-logo-bg">
                                <img src="<?= ASSETS_FULL_URL . 'images/OQG_Brand_Logo.png' ?>" alt="Online QR Generator" class="review-logo">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="review-title-2 text-center mx-3">
                    <h5 class="fw-bold"><?= l('qr_codes.review_modal_text_2') ?></h5>

                </div>

                <div class="review-option-wrap">
                    <div class="review-option review-google">
                        <a href="https://g.page/r/CWAbVtg9iBaZEBI/review" class="review-modal-close"
 onclick="feedback_close_btn()" target="_blank">
                            <img src="<?= ASSETS_FULL_URL . 'images/logo-google.svg' ?>" alt="">
                            <span><?= l('qr_codes.review_modal_platform_1') ?></span>
                        </a>
                    </div>
                    <div class="review-option review-trustpilot">
                        <a href="https://www.trustpilot.com/evaluate/www.online-qr-generator.com"  class="review-modal-close"
 onclick="feedback_close_btn()" target="_blank">
                            <img src="<?= ASSETS_FULL_URL . 'images/logo-trustpilot.svg' ?>" alt="">
                            <span translate="no"><?= l('qr_codes.review_modal_platform_2') ?></span>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript">
    function feedback_close_btn() {

        var formData = new FormData();
        formData.append('action', 'hideFeedbackBanner');
        formData.append('user_id', '<?= $this->user->user_id ?>');
        $.ajax({
            type: 'POST',
            url: '<?php echo url('api/ajax') ?>',
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function(response) {
                $("#fbBanner").animate({
                    opacity: 0
                }, "slow", function() {
                    $("#fbBanner").addClass('fb-banner-hide');
                });
            },
            error: (code) => {
                if (code.status == 500) {
                    // console.log('failed');
                }
            },
        });
    }
</script>