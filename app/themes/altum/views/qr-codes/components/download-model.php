<?php
$qr_code = $data->qr_code ?? null;
$qrCode  = $data->qrCode ?? null;
$user    = isset($this->user->user_id) ?  $this->user : $data->user;
?>


<div class="modal new-dl-modal new-download-modal fade <?= isset($data->downloadBanner) && $data->downloadBanner ? 'show' : '' ?>" id="DownloadModal" tabindex="-1" aria-labelledby="DownloadModal" aria-hidden="true" style="display:<?= isset($data->downloadBanner) && $data->downloadBanner ? 'block' : 'none' ?>; padding-right:0;">

    <div class="modal-dialog modal-dialog-centered modal-dialog-export <?= isset($data->downloadBanner) && $data->downloadBanner ? 'image-with-modal' : '' ?>">
        <div class="modal-content">

            <?php if (
                $user && 
                $user->onboarding_funnel == 3 && 
                $user->plan_id == 'free' && 
                $user->is_first_qr == '0' && 
                new \DateTime((new \DateTime($user->datetime))->modify('+8 day')->format('Y-m-d H:i:s')) > new \DateTime()
            ) :  ?>
                <div class="dpf-model-content">
                    <div class="dpf-content-wrap">
                        <span class="icon-qr-star dpf-star-icon"></span>
                        <span class="icon-qr-star dpf-star-icon"></span>
                        <span class="icon-qr-star dpf-star-icon"></span>
                        <span class="dpf-offer-text px-3"><?= l('qr_download.download_model.dpf.heading_main') ?></span>
                        <span class="icon-qr-star dpf-star-icon"></span>
                        <span class="icon-qr-star dpf-star-icon"></span>
                        <span class="icon-qr-star dpf-star-icon"></span>
                    </div>
                </div>
            <?php endif ?>



            <div class="modal-header align-items-start">
                <?php if (isset($data->downloadBanner) && $data->downloadBanner) : ?>
                    <input type="hidden" name="dm_qrcode_link" id="dmQrcodeLink" value="<?= SITE_URL . 'uploads/qr_codes/logo/' . $data->first_qr_code->qr_code ?>">
                    <input type="hidden" name="file_name" id="fileName" value="<?= $data->first_qr_code->name ?>">
                    <input type="hidden" name="qr_id" id="qr_id" value="<?= $data->first_qr_code->qr_code_id ?>">
                    <input type="hidden" name="qr_uid" id="qr_uid" value="<?= $data->first_qr_code->uId ?>">
                    <input type="hidden" name="qr_type" id="qr_type" value="<?= $data->first_qr_code->type ?>">
                    <input type="hidden" name="user_id" id="user_id" value="<?= $user->user_id ?>">
                <?php elseif ($qr_code) : ?>
                    <input type="hidden" name="dm_qrcode_link" id="dmQrcodeLink" value="<?= SITE_URL . 'uploads/qr_codes/logo/' . $qr_code['qr_code'] ?>">
                    <input type="hidden" name="file_name" id="fileName" value="<?php echo $qr_code['name'] ?>">
                    <input type="hidden" name="qr_id" id="qr_id" value="<?php echo $qr_code['qr_code_id'] ?>">
                    <input type="hidden" name="qr_uid" id="qr_uid" value="<?php echo $qr_code['uId'] ?>">
                    <input type="hidden" name="qr_type" id="qr_type" value="<?php echo $qr_code['type'] ?>">
                    <input type="hidden" name="user_id" id="user_id" value="<?= $user->user_id ?>">
                <?php elseif ($qrCode) : ?>
                    <input type="hidden" name="dm_qrcode_link" id="dmQrcodeLink" value="<?= SITE_URL . 'uploads/qr_codes/logo/' . $qrCode->qr_code ?>">
                    <input type="hidden" name="file_name" id="fileName" value="<?php echo $qrCode->name ?>">
                    <input type="hidden" name="qr_id" id="qr_id" value="<?php echo $qrCode->qr_code_id ?>">
                    <input type="hidden" name="qr_uid" id="qr_uid" value="<?php echo $qrCode->uId ?>">
                    <input type="hidden" name="qr_type" id="qr_type" value="<?php echo $qrCode->type ?>">
                    <input type="hidden" name="user_id" id="user_id" value="<?= $user->user_id ?>">

                <?php else : ?>
                    <input type="hidden" name="dm_qrcode_link" id="dmQrcodeLink" value="">
                    <input type="hidden" name="file_name" id="fileName" value="">
                    <input type="hidden" name="qr_id" id="qr_id" value="">
                    <input type="hidden" name="qr_uid" id="qr_uid" value="">
                    <input type="hidden" name="qr_type" id="qr_type" value="">
                    <input type="hidden" name="user_id" id="user_id" value="<?= $user->user_id ?>">

                <?php endif ?>
            </div>

            <button type="button" class="new-dl-close close-download-model-btn" onclick="<?= isset($data->downloadBanner) && $data->downloadBanner ? 'firstDownloadModelClose()' : '' ?>" data-dismiss="modal" aria-label="Close">
                <span class="icon-failed download-modal-close-icon"></span>
            </button>

            <div class="new-dl-modal-body">
                <input type="hidden" name="onboarding_funnel" id="onboarding_funnel" value="<?= $user ? $user->onboarding_funnel : '' ?>">
                <input type="hidden" name="is_first_qr" id="is_first_qr" value="<?= $user ? $user->is_first_qr : '' ?>">
                <div class="dl-modal-head border-bottom">
                    <?php if (
                            $user &&
                            $user->onboarding_funnel == 3 &&
                             $user->plan_id == 'free' &&
                             $user->is_first_qr == '0' &&
                             new \DateTime((new \DateTime($user->datetime))->modify('+8 day')->format('Y-m-d H:i:s')) > new \DateTime()
                             ) :  ?>
                        <div class="dpf-model-heading-wrap">
                            <h3 class="dpf-heading-1 text-center mt-2 desktop-heading-dpf"><?= l('qr_download.download_model.dpf.heading_1') ?></h3>
                            <h3 class="dpf-heading-1 text-center mt-2 d-none mobile-heading-dpf"><?= l('qr_download.download_model.dpf.heading_4') ?></h3>
                            <h3 class="dpf-heading-2 text-center pt-2"><?= l('qr_download.download_model.dpf.heading_2') ?></h3>
                            <img src="<?= ASSETS_FULL_URL . 'images/dl-modal/qr-code-download.png' ?>" class="dl-modal-head-img dpf-image" />
                            <hr class="dpf-hr d-none">
                            <h3 class="dpf-heading-3 text-center pb-2 dpf-download-header"><?= l('qr_download.download_model.dpf.heading_3') ?></h3>
                            <h3 class="dpf-heading-4 new-dl-modal-title mb-4 mt-5"><?= l('qr_download.download_model.title') ?></h3>
                        </div>
                    <?php else :  ?>
                        <?php if (isset($data->downloadBanner) && $data->downloadBanner) : ?>
                            <div class="first-modal-img-wrap">
                                <img src="<?= ASSETS_FULL_URL . 'images/dl-modal/qr-code-download.png' ?>" class="dl-modal-head-img" />
                                <h3 class="new-dl-modal-title new-dl-modal-first-title"><span class="last-step-text"><?= l('qr_download.download_model.first_title_1') ?></span> <br> <?= l('qr_download.download_model.first_title_2') ?> </h3>
                            </div>
                        <?php else : ?>
                            <h3 class="new-dl-modal-title mb-4 mt-5"><?= l('qr_download.download_model.title') ?></h3>
                        <?php endif ?>
                    <?php endif ?>

                </div>

                <div class="dl-modal-options border-bottom pb-5 pt-2 mt-4" data-selected="jpeg">
                    <?php
                    $dl_options = [
                        [
                            ['PNG', 'png', 'dl-images.png'],
                            ['JPEG', 'jpeg', 'dl-images.png'],
                            ['SVG', 'svg', 'dl-svg.svg'],
                            ['PDF', 'pdf', 'dl-pdf.png'],
                            ['EPS', 'eps', 'dl-eps.svg'],
                            ['Print', 'print', 'dl-printer.svg'],

                        ],
                        ['Default', '512x512', '1024x1024', '2048x2048', '4096x4096']
                    ];
                    foreach ($dl_options[0] as $e => $op) : ?>
                        <div class="dl-modal-option-card card-<?= $e + 1 ?> shadow-sm <?= $op[1] == 'jpeg' ? 'dl-modal-option-card-active' : '' ?>">
                            <div class="qrCode-check">
                                <div class="roundCheckbox chk">
                                    <input type="checkbox" name="dl_type" id="<?= $op[1] ?>" <?= $op[1] == 'jpeg' ? 'checked' : '' ?>>
                                    <label class="m-0" for="<?= $op[1] ?>"></label>
                                </div>
                            </div>
                            <div class="dl-modal-option-card-body">
                                <div class="card-body-image-section">
                                    <img src="<?= ASSETS_FULL_URL . 'images/dl-modal/' . $op[2] ?>" class="<?= $op[1] == 'jpeg' ? 'card-body-image-active' : '' ?>" alt="type-image">
                                </div>
                                <div>
                                    <h6 class="l-show"><?= $op[0] === "Print" ? l('qr_download.download_model.print_btn_web') : $op[0] ?></h6>
                                    <h6 class="m-show <?= $op[1] == 'jpeg' ? 'm-show-active' : '' ?>">
                                        <?= $op[0] === "Print" ? l('qr_download.download_model.print_btn_mobile') : l('qr_download.download_model.download_text') . ' ' . strtolower($op[0]) ?>
                                    </h6>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>

                <div class="dl-modal-footer mt-4 mb-4">
                    <div class="dl-modal-footer-buttons">
                        <div class="dl-modal-size-picker-section">
                            <h4 class="file-text"><?= l('qr_download.download_model.file_size') ?></h4>
                            <div class="dl-modal-size-picker mt-1" onclick="expandSizePicker(this)" title="Default is 1024x1024 ">
                                <span><?= l('qr_download.download_model.default')?></span>
                                <span class="icon-arrow-down file-size-icon"></span>
                            </div>
                            <div class="dl-modal-size-picker-options" data-selected="1024x1024" hidden>
                                <?php foreach ($dl_options[1] as $e => $sz) : ?>
                                    <div class="size-picker-option">
                                        <div class="picker-option-s"><input type="radio" name="sizes" id="<?= $sz ?>" <?= $sz === "Default" ? 'checked' : '' ?>></div>
                                        <div class="picker-option-l <?= $sz === "Default" ? 'active' : '' ?>"><label for="<?= $sz ?>"><?= $sz ?></label></div>
                                    </div>
                                <?php endforeach ?>
                            </div>
                        </div>

                        <button class="download-prtint-btn btn primary-btn btn-with-icon font-bold single downloadQrCode" data-dismiss="modal" onclick="<?= isset($data->downloadBanner) && $data->downloadBanner ? 'firstDownloadModelClose()' : '' ?>">
                            <span id="icon-dl-btn" class="icon-downloadBtn"></span>
                            <span class="download-modal-text"><?= l('qr_download.download_model.download_text') ?></span>
                        </button>
                        <!-- data-toggle="modal" data-target="#sharePopup" -->
                        <a class="btn outline-btn btn-with-icon font-bold share-btn" title="Share" id="shareBtn">
                            <span id="shareIcon" style="margin: auto; font-size: 24px;" class="icon-sign-out grey"></span>
                        </a>
                    </div>
                    <!-- custom.js file -->
                </div>
                <div class="dl-modal-alert">
                    <!-- <i class="icon-info"></i>  -->
                    <i class="icon-pending"></i>
                    <span><?= l('qr_download.download_model.eps_warning') ?></span>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var shareBtn = document.getElementById("shareBtn");
        var shareIcon = document.getElementById("shareIcon");


        if (typeof navigator.share === "undefined") {
            shareBtn.setAttribute("data-toggle", "modal");
            shareBtn.setAttribute("data-target", "#sharePopup");
            shareIcon.setAttribute("data-toggle", "modal");
            shareIcon.setAttribute("data-target", "#sharePopup");

        }
    });

    $(document).ready(function() {
        if ($("#DownloadModal .modal-content").children("dpf-model-content")) {
            // $(".close-download-model-btn").addClass("dpf-close-btn");
            $("#DownloadModal .modal-content").addClass("dpf-model-content-wrap");
        } else {
            // $(".close-download-model-btn").removeClass("dpf-close-btn");
            $("#DownloadModal .modal-content").removeClass("dpf-model-content-wrap");
        }
    });

    $(document).on('click', '.downloadBtn', function() {
        setTimeout(function(){ 
            if ($("#DownloadModal .dpf-model-content-wrap").children("dpf-model-content")) {
                $('.new-dl-modal-body').css({'padding-top':'0px'});
            }
            hideDpfBanner();
        }, 100);
    });

    function hideDpfBanner(){
        const funnelType = $("#onboarding_funnel").val();
        const isFristQr = $("#is_first_qr").val();
        const dpfElements = $(".dpf-heading-1, .dpf-heading-2, .dpf-heading-3, .dpf-image, .dpf-model-content");
        if(funnelType == 3){
            dpfElements.css({'display':'none'});
            $(".dpf-heading-4").css({'display':'block'});
        }
    }


</script>