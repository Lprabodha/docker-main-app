<?php

use Altum\Routing\Router;
use Mollie\Api\Resources\Route;

defined('ALTUMCODE') || die() ?>

<?php
$userQrCode   = db()->where('user_id', $this->user->user_id)->getOne('qr_codes');
$userLanguage =  user_language($this->user);
$userLanguageCode = \Altum\Language::$active_languages[$userLanguage] ? \Altum\Language::$active_languages[$userLanguage] : null;

?>

<style>
    #overlay {
        position: fixed;
        /* position: relative; */
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
        background: rgba(0, 0, 0, 0.3);
        transition: 1s 0.4s;
        /* / padding-top: 10%; / */
        /* / padding:auto !important ; / */
        color: white;
        font-size: 20px;
        text-align: center;
        display: none;
        /* visibility: hidden; */
        /* opacity: 0; */
        z-index: 999999;
        height: 100%;
    }

    #overlay_img {

        margin: 0;
        position: relative;
        top: 50%;
        transform: translateY(-50%);
        max-width: 100%;
    }

    @media (min-width: 1281px) {
        #step-id-label {
            margin-bottom: 0px;
            font-size: 25px;
        }
    }

    @media (min-width: 1025px) and (max-width: 1280px) {
        #step-id-label {
            margin-bottom: 0px;
            /* margin-top: 4px; */
            font-size: 25px;
        }
    }

    @media (min-width: 768px) and (max-width: 1024px) {
        #step-id-label {
            margin-bottom: 0px;

            font-size: 25px;
        }

    }

    @media (min-width: 481px) and (max-width: 767px) {
        #step-id-label {
            margin-bottom: 0;
            font-size: 25px;
        }
    }

    @media (max-width: 480px) {
        #step-id-label {
            margin-bottom: 0;
            font-size: 18px;
        }
    }

    #overlayPre {
        position: fixed;
        top: 0;
        left: 0;
        background-color: black;
        width: 100%;
        height: 100%;
        z-index: 1039;
        opacity: 0;
        transition: opacity 0.05s linear;
        display: none;
    }

    .modal-backdrop.show {
        opacity: 0.5;
    }

    .modal-backdrop.fade:not(.show) {
        opacity: 0;
    }

    #sectionDeleteModal {
        z-index: 1050;
    }

    @media (max-width: 767.5px) {
        #step-id-label.set-pad {
            padding-top: 8px;
        }

        #step-id-label:lang(mni-Mtei) {
            padding-top: 10px;
        }
    }
</style>

<!-- <script src="<?= ASSETS_FULL_URL . 'js/jscolor.js' ?>"></script> -->
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/themes/nano.min.css"/> -->
<!-- <script src="themes/altum/assets/js/jscolor.js"></script> -->

<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/mdbassit/Coloris@latest/dist/coloris.min.css" />
<script src="https://cdn.jsdelivr.net/gh/mdbassit/Coloris@latest/dist/coloris.min.js"></script>

<div id="overlay">
    <img src="themes/altum/assets/images/qr-code-animation-unscreen.gif" alt="Loading" id="overlay_img" loading="lazy" />
    <!-- &nbsp;Loading... -->
</div>


<div class="jss1347 container-fluid  qr-generator-forms-content main-inner DbClickDisabledElm qr-step-full-wrap">
    <!-- <?= \Altum\Alerts::output_alerts() ?> -->

    <div class="custom-row">
        <div class="container main-container <?= Router::$controller_key != 'create' ? 'qr-step-default' : 'create-qr-container' ?>" style="position:relative;">
            <div class="arrow-info-block <?= Router::$controller_key != 'create' ? 'd-none' : '' ?>">
                <div class="curve-arrow">
                    <img src="themes/altum/assets/images/curve-arrow.png" class="img-fluid" alt="Loading" loading="lazy" />
                </div>
                <div class="arrow_tooltip_wrap">
                    <div class="arrow-tooltip">
                        <div class="pointer-text"><?= l('qr_step_1.new_landing_page.arrow_tooltip_text') ?></div>
                    </div>
                </div>
            </div>
            <!-- <div class="screen-vp">
                <div class="width"></div>
                <div class="height"></div>
            </div> -->
            <label id='funnel-qr-header' class="funnel-qr-header funnel-qr-header-desktop <?= Router::$controller_key != 'create' ? 'd-none' : '' ?>" style=''><?= isset($data->titleBot) ? $data->titleBot : l('qr_step_1.new_landing_page.title_desktop') ?></label>
            <label id='funnel-qr-header' class="funnel-qr-header funnel-qr-header-mobile <?= Router::$controller_key != 'create' ? 'd-none' : '' ?>" style=''><?= isset($data->titleBot) ? $data->titleBot : l('qr_step_1.new_landing_page.title_mobile') ?></label>
            <div class="row mx-0">
                <div class="col-xl-8 qr-types-wrp">
                    <div class="col-left customScrollbar">
                        <input type="hidden" name="step_input" value="<?php echo ($data->qr_code_id != "" && $data->qr_code_id != null) ? 2 : 1; ?>">
                        <input type="hidden" name="qrcodeId" value="<?php echo isset($data->qr_code_id) ? $data->qr_code_id : ''; ?>">
                        <input type="hidden" name="current_step_input" value="">
                        <input type="hidden" class="qrtypeInput" name="qrtype_input" value="<?php echo isset($data->type) ? $data->type : ''; ?>">
                        <input type="hidden" class="qrtypeInputOld" name="qrtype_input_old" value="">
                        <input type="hidden" name="validation_fire" id="validation_fire" value="0">
                        <input type="hidden" id="qr_status" value="<?= $data->status ?>">
                        <input type="hidden" id="tempUid" value="<?php echo ($data->qr_code_id != "" && $data->qr_code_id != null) ? $data->qr_code_id : uniqid(); ?>">
                        <input type="hidden" id="changeQrType" value="false">
                        <input type="hidden" id="isFirstQR" value="<?= $this->user->is_first_qr ?>">
                        <input type="hidden" id="onboarding_funnel" name="onboarding_funnel" value="<?= $data->onboarding_funnel ?>">

                        <?php if (\Altum\Middlewares\Authentication::check()) : ?>
                            <input type="hidden" name="userid" value="<?= $this->user->user_id ?>" />
                        <?php endif ?>

                        <div class="jss1349">
                            <div style="position: relative; overflow: hidden; width: 100%; height: 100%;">
                                <div style="">
                                    <section class="jss1452 card-full-wrap">
                                        <div id="topdiv"></div>
                                        <div id="ajax-content-data">
                                            <label id='step-id-label' class="<?= Router::$controller_key == 'create' ? 'd-none' : '' ?>" style=''>1. <?= l('qr_step_1.label') ?></label>
                                        </div>
                                        <?php require THEME_PATH . 'views/qr-codes/js_qr_code.php' ?>
                                    </section>
                                </div>
                            </div>
                            <div class="preview" id="preview">
                                <img class="preview-img" src="<?= isset($data->qr_code_settings['type'][$data->type]['preview']) ? $data->qr_code_settings['type'][$data->type]['preview'] : '' ?>" width="100" />
                            </div>
                        </div>
                    </div>
                </div>
                <span class="qr-code-btn-tooltip" id="qrCodeBtnTooltip">
                    <!-- <p class="tooltip-con-1"><?= l('qr_step_2.qrCode_Btn_tooltip.1') ?></p>
                    <p class="tooltip-con-2"><?= l('qr_step_2.qrCode_Btn_tooltip.2') ?></p> -->
                    <p class="tooltip-con-3"><?= l('qr_step_2.qrCode_Btn_tooltip.3') ?></p>
                </span>
                <div class="col-xl-4 mobile-mockup-wrp pr-0">
                    <div class="col-right customScrollbar mobile-preview-block" id="previewModel">
                        <div class="col-right-inner mobilephone-column <?= Router::$controller_key == 'create' ? 'create-view-phone' : '' ?>" <?= $data->isNewLanding ? 'style=""' : null ?>>

                            <div class="preview-head" id="tabhead">
                            </div>


                            <div class="qr-prev-btn-wrap qr-prev-btn-hover MuiTabs-root mui-style-1aio0y8  <?php echo $data->qr_code_id ? 'invisible' : '' ?>" id="preview_qrcode">
                                <button type="button" class="btn btn-secondary btn-outlined btn-close exitPreview btn-x" id="">X</button>
                                <div class="MuiTabs-scroller MuiTabs-fixed mui-style-1anid1y prev-qr-code-btn-wrap" style="overflow: hidden; margin-bottom: 0px;">
                                    <div class="MuiTabs-flexContainer MuiTabs-centered mui-style-1l4w6pd" role="tablist">

                                        <ul class="nav" role="tablist">


                                            <li class="MuiTabs-flexContainer prev-btn-wrap MuiTabs-centered mui-style-1l4w6pd">
                                                <a class="square-btn prev-btn preview-shifter active MuiButtonBase-root MuiTab-root MuiTab-textColorPrimary MuiTab-wrapped Mui-selected mui-style-22nrau" data-toggle="tab" href="#tabs-1" id="1" role="tab">
                                                    <?= l('qr_step_2.preview') ?>
                                                </a>
                                            </li>
                                            <li id="qrCodeBtn">
                                                <button class="square-btn preview-btn preview-shifter MuiButtonBase-root MuiTab-root disable-btn MuiTab-textColorPrimary MuiTab-wrapped Mui-selected mui-style-22nrau" data-toggle="tab" href="#tabs-2" id="2" role="tab" disabled="disabled">
                                                    <?= l('qr_step_2.qrCode') ?>
                                                    </svg>
                                                </button>
                                            </li>
                                        </ul>

                                    </div><span class="MuiTabs-indicator mui-style-ttwr4n" style="left: 91.9375px; width: 94.625px;"></span>
                                </div>
                            </div>
                            <div class="tab-content mb-frame">
                                <div id="window-size " style="display:none; position:absolute;z-index: 999;top: -30px;left:-100%; padding:8px 16px;background-color:#ffffff; white-space:nowrap;"></div>
                                <div class="tab-pane active landing-page-view" id="tabs-1" role="tabpanel">
                                    <div class="card mb-frame-inner desktop-frame-inner">

                                        <img class="scroller-img img-fluid" src="<?= ASSETS_FULL_URL . 'static/scroller.gif' ?>" alt="..." loading="lazy">
                                        <img class="pointer-img img-fluid lazyload" src="<?= ASSETS_FULL_URL . 'static/pointer.gif' ?>" alt="..." loading="lazy">

                                        <!-- <video class="scroller-img img-fluid" autoplay loop muted playsinline >
                                        <source src="<?= ASSETS_FULL_URL . 'static/scroller.webm' ?>" type="video/webm" />
                                        <source src="<?= ASSETS_FULL_URL . 'static/scroller.mp4' ?>" type="video/mp4" />
                                    </video> -->

                                        <!-- <video class="pointer-img img-fluid" autoplay loop muted playsinline >
                                        <source src="<?= ASSETS_FULL_URL . 'static/pointer.webm' ?>" type="video/webm" />
                                        <source src="<?= ASSETS_FULL_URL . 'static/pointer.mp4' ?>" type="video/mp4" />
                                    </video> -->


                                        <div class="card">

                                            <!-- <div class="loader" id="loader" style="margin: 110px;">
                                                <div class="box1"></div>
                                                <div class="box2"></div>
                                                <div class="box3"></div>
                                            </div> -->
                                            <div class="pdf-mob">
                                                <iframe id='iframesrc' scrolling="yes" style='position:absolute;top:0; width: 100%; height:100%;' src="<?php echo isset($data->qr_code_settings['type'][$data->type]['preview']) ? $data->qr_code_settings['type'][$data->type]['preview'] : '' ?>">
                                                </iframe>
                                                <style>
                                                    #myLoad {
                                                        background-color: rgb(82, 122, 201);
                                                    }

                                                    .vcard#myLoad,
                                                    .business#myLoad,
                                                    .menu#myLoad,
                                                    .mp3#myLoad,
                                                    .links#myLoad {
                                                        background-color: #F7F7F7;
                                                    }

                                                    #loading {
                                                        display: inline-block;
                                                        width: 50px;
                                                        height: 50px;
                                                        border: 3px solid rgba(255, 255, 255, .3);
                                                        border-radius: 50%;
                                                        border-top-color: #fff;
                                                        animation: spin 1s ease-in-out infinite;
                                                        -webkit-animation: spin 1s ease-in-out infinite;
                                                    }

                                                    .vcard #loading,
                                                    .business #loading,
                                                    .menu #loading,
                                                    .mp3 #loading,
                                                    .links #loading {
                                                        border-color: rgba(0, 0, 0, 0.1);
                                                        border-top-color: #000;
                                                    }

                                                    @keyframes spin {
                                                        to {
                                                            -webkit-transform: rotate(360deg);
                                                        }
                                                    }

                                                    @-webkit-keyframes spin {
                                                        to {
                                                            -webkit-transform: rotate(360deg);
                                                        }
                                                    }
                                                </style>

                                                <div id='myLoad' class="<?php echo isset($data->type) ? $data->type : ''; ?>" style='position: absolute; min-width: 100%; min-height: calc(100% - 7px);  display: flex; align-content: center; top:      0; bottom: 0; display:none'>
                                                    <div style='position: absolute; right: 0; left: 0; top: 45%; bottom: 0; margin: 0 auto;' id="loading">
                                                    </div>
                                                </div>
                                            </div>
                                            <img src="" alt="" id="qr-preview" class="img-fluid" />
                                            <span class="default-preview-text d-none"><?= l('qr_step_1.phone_mockup_default_value') ?></span>
                                            <div class="iphone-line"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane qr-code-view" id="tabs-2" role="tabpanel">
                                    <div class="card mb-frame-inner desktop-frame-inner">
                                        <div></div>
                                        <div></div>
                                        <div class="card" style="display: flex;justify-content: center;">
                                            <div class="loader qr" id="loader" style="">
                                                <img src="themes/altum/assets/images/qr-code-animation-unscreen.gif" alt="Loading" loading="lazy" />
                                            </div>
                                            <div>
                                                <div class="card-body" id="qr-code-wrap">
                                                </div>
                                                <div id="statusMsg">
                                                </div>

                                            </div>

                                        </div>
                                        <div class="iphone-line mobile-qr"></div>
                                    </div>

                                    <div class="row mb-4 d-print-none d-none" style="visibility: hidden;">
                                        <div class="col-12 col-lg-6 mb-3 mb-lg-0">
                                            <button type="button" onclick="window.print()" class="btn btn-block btn-outline-secondary d-print-none cclr">
                                                <i class="fa fa-fw fa-sm fa-file-pdf"></i> <?= l('qr_codes.print') ?>
                                            </button>
                                        </div>
                                        <div class="col-12 col-lg-6 mb-3 mb-lg-0">
                                            <button type="button" class="btn btn-block btn-primary d-print-none dropdown-toggle cclrf" data-toggle="dropdown" aria-expanded="false">
                                                <i class="fa fa-fw fa-sm fa-download"></i> <?= l('global.download') ?>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a href="<?= ASSETS_FULL_URL . 'images/qr_code.svg' ?>" id="download_svg" class="dropdown-item" download="<?= get_slug(settings()->main->title) . '.svg' ?>"><?= sprintf(l('global.download_as'), 'SVG') ?></a>
                                                <button type="button" class="dropdown-item" onclick="convert_svg_to_others(null, 'png', '<?= get_slug(settings()->main->title) . '.png' ?>');"><?= sprintf(l('global.download_as'), 'PNG') ?></button>
                                                <button type="button" class="dropdown-item" onclick="convert_svg_to_others(null, 'jpg', '<?= get_slug(settings()->main->title) . '.jpg' ?>');"><?= sprintf(l('global.download_as'), 'JPG') ?></button>
                                                <button type="button" class="dropdown-item" onclick="convert_svg_to_others(null, 'webp', '<?= get_slug(settings()->main->title) . '.webp' ?>');"><?= sprintf(l('global.download_as'), 'WEBP') ?></button>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <button type="button" class="btn btn-secondary btn-outlined btn-close exitPreview" id=""><?= l('qr_general.exit_preview') ?></button>

                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>


</div>
<div class="jss49 bottom-bar-wrap  d-none" id="qr-proceed-footer">
    <div class="container">
        <div class="row bottom-bar h-100">
            <div class="col-md-4 col-sm-auto col-auto align-items-center d-flex h-100 bottom-back-btn-wrap" style="position: relative;">
                <button type="button" class="fakeBack-btn"></button>
                <button class="btn bottom-back-btn label-checker scroll-to-doc-top" tabindex="0" type="button" id="cancel" onclick="backButton(1)">
                    <div class="back-icon-wrap">
                        <span class="icon-arrow-right grey bottom-icon-back"></span>
                    </div>
                    <span class="bottom-btn-label"><?= l('qr_step_2.back_btn') ?></span>
                </button>
            </div>
            <div class="col-sm-auto col-auto align-items-center d-flex h-100 bottom-preivew-btn-wrap">
                <button type="button" class="btn bottom-preview-btn preview-qr-btn square-bt">
                    <div class="back-icon-wrap">
                        <span class="icon-eye-on grey bottom-icon-back"></span>
                    </div>
                    <span class="preview-btn-label"><?= l('qr_step_2.preview') ?></span>
                </button>
            </div>
            <!-- onclick="setTimeout(LoadPreview(undefined,false),3000)" -->
            <div class="col-md-auto col-sm-auto col-auto align-items-center d-flex h-100 bottom-next-btn-wrap">
                <?php if (\Altum\Middlewares\Authentication::check()) : ?>
                    <button type="button" class="fakeNext-btn"></button>
                    <button id="temp_next" class="label-checker btn bottom-next-btn scroll-to-doc-top" tabindex="0" type="button">
                        <div class="next-btn-all d-flex justify-content-center justify-content-center">
                            <span class="next-label"><?= l('qr_step_2.next_btn') ?></span>
                            <div class="back-icon-wrap">
                                <span class="icon-arrow-right grey bottom-icon-next"></span>
                            </div>
                        </div>
                    </button>
                    <button id="temp_next_tmp" class="btn bottom-next-btn" tabindex="0" type="button" disabled="disabled">
                        <div class="next-btn-all d-flex justify-content-center">
                            <span class="next-label"><?= l('qr_step_2.next_btn') ?></span>
                            <div class="back-icon-wrap">
                                <span class="icon-arrow-right grey bottom-icon-next"></span>
                            </div>
                        </div>
                    </button>
                    <button id="temp_submit" class="btn bottom-next-btn" tabindex="0" type="button" onclick="submit()">
                        <div class="next-btn-all d-flex justify-content-center">
                            <span class="next-label"><?php echo isset($data->qr_code_id) ?  l('qr_step_3.save') : l('qr_step_3.create'); ?></span>
                            <div class="back-icon-wrap ">
                                <span class="icon-arrow-right grey bottom-icon-next"></span>
                            </div>
                        </div>
                    </button>
                    <button id="temp_submit_loader" style="display: none" disabled="disabled" class="btn bottom-next-btn submit-loader">
                        <div class="next-btn-all d-flex justify-content-center">
                            <span class="next-submit-label"><?= l('qr_step_3.submit') ?></span>
                            <div class="back-icon-wrap">
                                <i class="fa fa-spinner spin-icon fa-spin"></i>
                            </div>
                        </div>
                    </button>
                <?php else : ?>
                    <?php if (settings()->users->register_is_enabled) : ?>
                        <a data-toggle="modal" data-target="#registerModal" id="temp_submit" class="MuiButtonBase-root MuiButton-root jss59 jss74 MuiButton-contained jss56 MuiButton-containedPrimary jss70" tabindex="0" type="button" style="display: block;">
                            <span class="MuiButton-label jss72" style="margin-top: 5px;"><i class="fa fa-fw fa-xs fa-plus mr-1"></i><?= l('qr_register') ?>
                            </span>
                        </a>
                    <?php endif ?>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>
</div>


<!-- Help Modal -->

<!-- Help Modal -->
<div class="modal smallmodal help-modal fade" id="helpModal" tabindex="-1" data-backdrop="static" aria-labelledby="helpModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-dialog-help">
        <div class="modal-content p-0">
            <div id="helpCarousel1" class="carousel slide" data-interval="false" data-wrap="false">
                <button data-dismiss="modal" class="help-close-btn step-1 close-first-modal" id="closeBtn"><span class="icon-failed"></span></button>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="<?= ASSETS_FULL_URL . 'static/s1.webp' ?>" class="w-100" alt="..." loading="lazy">
                        <div class="p-3">
                            <h3><?= l('qr_general.help.step_1.title') ?></h3>
                            <p><?= l('qr_general.help.step_1.description') ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-footer">
                <div class="w-100">
                    <button id="helpClosebtn" class="carouselBtn helpmodal-btn close-first-modal" type="button" data-dismiss="modal"><?= l('qr_general.help.close') ?></button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal smallmodal help-modal fade" id="helpModal2" tabindex="-1" data-backdrop="static" aria-labelledby="helpModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-dialog-help">
        <div class="modal-content p-0">
            <!-- slide carousel-fade -->
            <div id="helpCarousel" class="carousel helpCarousel " data-touch="false" data-interval="false" data-wrap="false">
                <button data-dismiss="modal" class="help-close-btn step-2" id="closeBtn"><span class="icon-failed"></span></button>
                <div class=" step-2-slides image-check active-image" style="display: none;">
                    <div class="carousel-item carousel-1-item-1 item-1 carousel-item-1 ">
                        <div class="img-block">
                            <img src="<?= ASSETS_FULL_URL . 'static/s2.webp' ?>" class="w-100" alt="..." loading="lazy">
                        </div>
                        <div class="p-3 slider-content-wrp">
                            <h3><?= l('qr_general.help.step_2.title_1') ?></h3>
                            <p class="carousel-item-para"></p>
                        </div>
                    </div>
                    <div id="omitOnUrlWifi" class="carousel-item carousel-1-item-2 item-2">
                        <div class="img-block">
                            <img src="<?= ASSETS_FULL_URL . 'static/s2.webp' ?>" class="w-100" alt="..." loading="lazy">
                        </div>
                        <div class="p-3 slider-content-wrp">
                            <h3><?= l('qr_general.help.step_2.title_2') ?></h3>
                            <p class="desktop-show mb-2"><?= l('qr_general.help.step_2.description_2_desktop') ?></p>
                            <p class="desktop-show "><?= l('qr_general.help.step_2.description_2_tips_desktop') ?></p>
                            <p class="mobile-show "><?= l('qr_general.help.step_2.description_2_mobile') ?></p>
                        </div>
                    </div>
                    <div class="carousel-item carousel-1-item-4 item-4">
                        <div class="p-3 slider-content-wrp">
                            <h3><?= l('qr_general.help.step_2.title_4') ?></h3>
                            <p><?= l('qr_general.help.step_2.description_4') ?></p>
                        </div>
                    </div>
                    <div class="carousel-item carousel-1-item-3 item-3">
                        <div class="p-3 slider-content-wrp">
                            <h3><?= l('qr_general.help.step_2.title_3') ?></h3>
                            <p><?= l('qr_general.help.step_2.description_3') ?></p>
                        </div>
                    </div>

                </div>
                <div class=" step-3-slides image-check active-image" style="display:none;">
                    <div class=" carousel-item carousel-2-item-1  item-1">
                        <div class="img-block">
                            <img src="<?= ASSETS_FULL_URL . 'static/s3.webp' ?>" class="d-block w-100" alt="..." loading="lazy">
                        </div>
                        <div class="p-3 slider-content-wrp">
                            <h3><?= l('qr_general.help.step_3.title_slide_1') ?></h3>
                            <p><?= l('qr_general.help.step_3.description_slide_1') ?></p>
                        </div>
                    </div>
                    <div id="resetoverlays" class="carousel-item carousel-2-item-2 item-2">
                        <div class="img-block">
                            <img src="<?= ASSETS_FULL_URL . 'static/s3.webp' ?>" class="d-block w-100" alt="..." loading="lazy">
                        </div>
                        <div class="p-3 slider-content-wrp">
                            <h3 class="desktop-show"><?= l('qr_general.help.step_3.title_slide_2') ?></h3>
                            <h3 class="mobile-show"><?= l('qr_general.help.step_3.title_slide_2_mobile') ?></h3>
                            <p class="desktop-show "><?= l('qr_general.help.step_3.description_slide_2_desktop') ?></p>
                            <p class="mobile-show "><?= l('qr_general.help.step_3.description_slide_2_mobile') ?></p>
                        </div>
                    </div>
                </div>

                <div class="carousel-footer">
                    <div class="w-100">
                        <button id="helpNextbtn" class="carouselBtn carouselNextBtn helpmodal-btn" type="button" data-target="#helpCarousel" data-slide="next" onclick="onSlide(true)"><?= l('qr_general.help.continue') ?></button>
                    </div>
                </div>
                <div class="progressbar-wrp">
                    <div id="progress-bar"></div>
                </div>
            </div>
        </div>
        <div class="arrow-block"></div>
    </div>
</div>
</div>
<!-- Qr-code Modal -->
<div class="modal smallmodal fade" id="QrCodeModal" tabindex="-1" aria-labelledby="QrCodeModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered medium-modal">
        <div class="modal-content qrCodeModal">
            <button type="button" class="large-icon" data-dismiss="modal" aria-label="Close">
                <svg class="MuiSvgIcon-root jss709" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 20px;">
                    <path d="M13.41,12l5.3-5.29a1,1,0,1,0-1.42-1.42L12,10.59,6.71,5.29A1,1,0,0,0,5.29,6.71L10.59,12l-5.3,5.29a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0L12,13.41l5.29,5.3a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42Z"></path>
                </svg>
            </button>
            <p><?= l('qr_step_2.preview') ?></p>
            <div class="qrCodeImg">
                <img id="qr_code_p" src="<?= ASSETS_FULL_URL . 'images/qr_code.svg' ?>" class="img-fluid qr-code" loading="lazy" />
            </div>
        </div>
    </div>
</div>

<!-- Preview Modal -->
<div class="modal smallmodal fade" id="PreviewModal" tabindex="-1" aria-labelledby="PreviewModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered medium-modal">
        <div class="modal-content previewModal">
            <button type="button" class="large-icon" data-dismiss="modal" aria-label="Close">
                <svg class="MuiSvgIcon-root jss709" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 20px;">
                    <path d="M13.41,12l5.3-5.29a1,1,0,1,0-1.42-1.42L12,10.59,6.71,5.29A1,1,0,0,0,5.29,6.71L10.59,12l-5.3,5.29a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0L12,13.41l5.29,5.3a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42Z"></path>
                </svg>
            </button>
            <p>Preview</p>
            <div class="mb-frame-inner">

                <div class="card">
                    <div class="card-body p-0">
                        <iframe id="iframesrc2" src="<?= isset($data->qr_code_settings['type'][$data->type]['preview']) ? $data->qr_code_settings['type'][$data->type]['preview'] : '' ?>" width="100%" height="510" style="visibility: visible" scrolling="yes"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal smallmodal fade d-none" id="PreviewModal0" data-backdrop="static" tabindex="-1" aria-labelledby="PreviewModal0" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered medium-modal">
        <div class="modal-content previewModal">

            <div class="MuiTabs-root mui-style-1aio0y8 " id="preview_qrcode_mobile">
                <div class="MuiTabs-scroller MuiTabs-fixed mui-style-1anid1y" style="overflow: hidden; margin-bottom: 0px;">
                    <div class="MuiTabs-flexContainer MuiTabs-centered mui-style-1l4w6pd" role="tablist">

                        <ul class="nav" role="tablist">



                            <li class="MuiTabs-flexContainer MuiTabs-centered mui-style-1l4w6pd">
                                <a class="square-btn active MuiButtonBase-root MuiTab-root MuiTab-textColorPrimary MuiTab-wrapped Mui-selected mui-style-22nrau" data-toggle="tab" href="#tabs-1m" id="1m" role="tab">
                                    Preview
                                </a>
                            </li>
                            <li>
                                <!-- href="#tabs-2" -->
                                <button class="square-btn MuiButtonBase-root MuiTab-root MuiTab-textColorPrimary MuiTab-wrapped Mui-selected mui-style-22nrau" data-toggle="tab" href="#tabs-2m" id="2m" role="tab" disabled="disabled">
                                    QR Code
                                    </svg>
                                </button>
                            </li>
                        </ul>

                    </div><span class="MuiTabs-indicator mui-style-ttwr4n" style="left: 91.9375px; width: 94.625px;"></span>
                </div>
            </div>
            <div class="tab-content mb-frame">
                <div class="tab-pane active" id="tabs-1m" role="tabpanel">
                    <div class="mb-frame-inner ">

                        <div class="card">

                            <iframe style="" id="iframesrc" src="<?= isset($data->qr_code_settings['type'][$data->type]['preview']) ? $data->qr_code_settings['type'][$data->type]['preview'] : '' ?>" width="100" height="425" scrolling="yes">
                            </iframe>

                            <div class="iphone-line"></div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="tabs-2m" role="tabpanel">
                    <div class="card mb-frame-inner">
                        <div class="card" style="display: flex;justify-content: center;">
                            <div class="card-body">
                                <img id="qr_code" src="<?= ASSETS_FULL_URL . 'images/qr_code.svg' ?>" class="img-fluid qr-code" loading="lazy" />
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4 d-print-none d-none" style="visibility: hidden;">
                        <div class="col-12 col-lg-6 mb-3 mb-lg-0">
                            <button type="button" onclick="window.print()" class="btn btn-block btn-outline-secondary d-print-none cclr">
                                <i class="fa fa-fw fa-sm fa-file-pdf"></i> <?= l('qr_codes.print') ?>
                            </button>
                        </div>
                        <div class="col-12 col-lg-6 mb-3 mb-lg-0">
                            <button type="button" class="btn btn-block btn-primary d-print-none dropdown-toggle cclrf" data-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-fw fa-sm fa-download"></i> <?= l('global.download') ?>
                            </button>
                            <div class="dropdown-menu">
                                <a href="<?= ASSETS_FULL_URL . 'images/qr_code.svg' ?>" id="download_svg" class="dropdown-item" download="<?= get_slug(settings()->main->title) . '.svg' ?>"><?= sprintf(l('global.download_as'), 'SVG') ?></a>
                                <button type="button" class="dropdown-item" onclick="convert_svg_to_others(null, 'png', '<?= get_slug(settings()->main->title) . '.png' ?>');"><?= sprintf(l('global.download_as'), 'PNG') ?></button>
                                <button type="button" class="dropdown-item" onclick="convert_svg_to_others(null, 'jpg', '<?= get_slug(settings()->main->title) . '.jpg' ?>');"><?= sprintf(l('global.download_as'), 'JPG') ?></button>
                                <button type="button" class="dropdown-item" onclick="convert_svg_to_others(null, 'webp', '<?= get_slug(settings()->main->title) . '.webp' ?>');"><?= sprintf(l('global.download_as'), 'WEBP') ?></button>
                            </div>
                        </div>
                    </div>

                </div>


            </div>
        </div>


    </div>
</div>



<!-- Modal Preview -->

<div id="overlayPre" class=""></div>

<?php ob_start() ?>



<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>

<!-- <link rel="stylesheet" href="<?= ASSETS_FULL_URL . 'js/jquery.minicolors.css' ?>"> -->


<script src="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/pickr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/pickr.es5.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        if($('#qr_status').val()){
            //Edit Mode
            var qrInputType = $("input[name=\"qrtype_input\"]").val();
            document.getElementById('iframesrc').src = `<?= LANDING_PAGE_URL ?>preview?lang=<?php echo $userLanguage ?>&preview=true&type=${qrInputType == 'url' ? 'website' : qrInputType}`;
        }else{
            document.getElementById('iframesrc').src = `<?=LANDING_PAGE_URL?>preview?lang=<?php echo $userLanguage ?>&preview=true`;
        }

        windows();
        $(window).resize(function() {
            windows();

        });
    });

    function windows() {
        const width = $(window).width();
        const height = $(window).height();

        // Display the current window size in an element with id 'window-size'
        $('#window-size').text(`Window Size: ${width}x${height}`);
    }


    $(document).ready(function() {
        function adjustFontSize(elementId, newSize, newSize2, newSize3) {
            // var textElement = document.getElementById(elementId);
            var arrowInfoBlock = document.querySelector(".arrow-info-block");
            var textElement = document.querySelector("." + elementId);
            var textLength = textElement.textContent.length;
            console.log(textLength);
            if (textLength > 52) {
                textElement.style.fontSize = newSize;
                arrowInfoBlock.classList.add('set-top');
            }
            if (textLength > 60) {
                textElement.style.fontSize = newSize2;
            }
            if (textLength > 70) {
                textElement.style.fontSize = newSize3;
            }
        }
        adjustFontSize('funnel-qr-header-desktop', '30px', '28px', '26px');
        adjustFontSize('funnel-qr-header-mobile', '28px', '24px');
        // var w = window.innerWidth;
        // var h = window.innerHeight;

        // var w = window.innerWidth || document.documentElement.clientWidth;
        // var h = window.innerHeight || document.documentElement.clientHeight;

        // $('.screen .width').text('Width ' + w + 'px');
        // $('.screen .height').text('Height ' + h + 'px');

        document.documentElement.lang = "<?= $userLanguageCode ?>";

        // auto reload load preview in the edit view
        var qrStatVal = $('#qr_status').val();
        if (qrStatVal == 1) {
            apply_reload_qr_code_event_listeners();
        }

    });

    var qrFormPostUrl = "<?= url('qr-code-generator') ?>";

    function tooltipUpdate() {
        new CustomToolTip({
            targetClass: 'ctp-tooltip',
            collision: '.steps-ped',
            typoGraphy: {
                weight: 400
            }
        });
    }
</script>

<script>
    var qr_status = $('#qr_status').val();

    $(document).on('change', '.passcheckbox', function() {

        if ($(this).prop('checked')) {
            if ($('.passwordField').length === 0) {
                $(".passwordBlock").append(`<div class="step-form-group password-field-wrap"><label class="filed-label" for="passowrd"><?= l('l_link.password.input') ?></label><input autocomplete="new-password" id="passwordField" type="password" name="password" placeholder="<?= l('qr_step_2_com_password.input.password.placehoder'); ?>" class="step-form-control passwordField" value="<?php echo (!empty($filledInput)) ? $filledInput['password'] : '' ?>" maxlength="30" data-reload-qr-code /></div>`);

                //prevent page redirect on keypress
                $('.passwordField').keypress(function(e) {
                    if (event.keyCode == 13) {
                        event.preventDefault();
                    }
                })
            }
        } else {
            $('.passwordField').prop('disabled', !$(this).prop('checked'));
            $(".passwordField").val('');
            $(".password-field-wrap").remove();
        }
    });
    // Real Time Iframe Loader   
    var ifr = document.getElementById('iframesrc');
    let isGenerating = true;
    let isSubmitClicked = false;

    function setFrame() {
        var ele = $(document).find("#primaryColor");
        const primaryColor = ele ? $(ele).val() : "#527ac9";
        // document.getElementById('myLoad').style.backgroundColor = primaryColor;
        $('#myLoad').fadeIn(200);
        ifr.onload = function() {
            $('#myLoad').fadeOut(200);
        }
    }



    // Identify Mobile Device 
    function IsMobile() {
        if (navigator.userAgent.match(/Android/i) ||
            navigator.userAgent.match(/webOS/i) ||
            navigator.userAgent.match(/iPhone/i) ||
            navigator.userAgent.match(/iPad/i) ||
            navigator.userAgent.match(/iPod/i) ||
            navigator.userAgent.match(/BlackBerry/i) ||
            navigator.userAgent.match(/Windows Phone/i)) {
            a = true;
        } else {
            a = false;
        }
        return a;
    }



    let timer,
        timeoutVal = 1200;
    var ctrlDown = false,
        ctrlKey = 17,
        cmdKey = 91,
        vKey = 86;

    let eventchange = false;
    let timerId;
    let loadpreviewtab = false;
    let keycode = "";
    var spaceCount = 0;
    $(document).keydown(function(e) {
        if (e.keyCode == ctrlKey || e.keyCode == cmdKey) {
            ctrlDown = true;
        }
        handleKeyPress(e);
        eventchange = false;
        clearTimeout(timerId);
        if (e.which == 9) {
            keycode = 9;
        } else {
            keycode = "";
        }

    }).keyup(function(e) {
        if (e.keyCode == ctrlKey || e.keyCode == cmdKey) ctrlDown = false;
        handleKeyUp(e);
        loadpreviewtab = false;
    });

    function handleKeyPress(e) {
        window.clearTimeout(timer);
    }

    function handleSpacebarInput() {
        clearTimeout(timerId);
        eventchange = true;
        timerId = setTimeout(() => {
            LoadPreview();
            loadpreviewtab = true;
        }, 50);

    }

    // Reset the count to zero
    function resetCount() {
        spaceCount = 0; // Reset the count variable
    }
    $(document).on("change", '#step2_form input:not([type="file"]), #step2_form textarea', function(e) {
        if (($('input[name=qrtype_input]').length > 0 && $('input[name=qrtype_input]').val() == "url") || ($('input[name=qrtype_input]').length > 0 && $('input[name=qrtype_input]').val() == "wifi")) {

        } else {
            if (eventchange == false && loadpreviewtab == false) {
                handleKeyPress(e);
                LoadPreview();
            }
        }
    })


    function handleKeyUp(e) {

        if (!IsMobile()) {
            if (($('input[name=qrtype_input]').length > 0 && $('input[name=qrtype_input]').val() == "url") || ($('input[name=qrtype_input]').length > 0 && $('input[name=qrtype_input]').val() == "wifi")) {

            } else {
                if ($(e.target).is('input, textarea')) {
                    // window.clearTimeout(timer);
                    if ($(event.target).hasClass('loginEmail') || $(event.target).hasClass('loginPass') || e.target.id == "email" || e.target.id == "password" || e.target.id == "regEmail") {
                        return true;
                    } else if ((e.key == " ") ||
                        (e.code == "Space") ||
                        (e.keyCode == 32)
                    ) {
                        handleSpacebarInput(e);
                    } else if (ctrlDown && (e.keyCode == vKey)) {
                        LoadPreview();
                    } else {
                        if (e.keyCode == 17 || e.keyCode == 91) {} else if (e.keyCode == 8 || e.keyCode == 46) {
                            // timer = window.setTimeout(() => {
                            LoadPreview();
                            eventchange = true;
                            // }, timeoutVal);
                        } else {
                            if (keycode != 9) {
                                // timer = window.setTimeout(() => {
                                var re = /[A-Za-z0-9\!\@\#\$\%\^\&\*\)\(\+\=\.\<\>\{\}\[\]\:\;\'\"\|\~\`\_\-]/g
                                if (re.test(e.target.value)) {
                                    LoadPreview();
                                    eventchange = true;
                                    loadpreviewtab = true;
                                }
                                // }, timeoutVal);
                            }

                        }
                    }
                }
            }
        }
    }


    let submitClicked = false;

    $(document).on("mousedown", "#temp_next", function(e) {
        submitClicked = true;
    });
    $(document).on("touchstart", "#temp_next", function(e) {
        submitClicked = true;
    });

    $("#temp_next").click(function() {
        $("#tab2").addClass("active");
    });
    $(".exitXPreview").click(function() {

        $("#overlayPre").css({
            'opacity': '0',
            'display': 'none'
        });
        $("body").not(".app").removeClass("scroll-none");
        $(".col-right.customScrollbar").removeClass("active");
    });

    $("#helpAcceptbtn").click(function() {
        $('#helpCarousel .carousel-inner').children('.carousel-item.active').removeClass('active');
        $('#helpCarousel .carousel-inner').children('.carousel-item').first().addClass('active');
        $('#helpCarousel .carousel-indicators').children('li.active').removeClass('active');
        $('#helpCarousel .carousel-indicators').children('li').first().addClass('active');
    });


    var activePreview = $('#helpModal2 .modal-dialog-help');
    var bottomFooter = $('#qr-proceed-footer');
    var clickCount = 0;
    const updateButton = document.getElementById("helpNextbtn");
    const modalOpen = document.getElementById("helpInfoModal");
    const phoneMockup = document.getElementsByClassName("mobilephone-column")[0];



    $('#closeBtn.step-2').click(function() {
        var currentStep = $("input[name=\"current_step_input\"]").val();
        if ($('.mobilephone-column').hasClass('activeMobile') || $('.mobilephone-column').hasClass('activeCouponMobile') || $('.mobilephone-column').hasClass('activeQRmobile')) {
            $('.mobilephone-column').removeClass('activeMobile activeCouponMobile activeQRmobile');
        }
        $('.image-check').addClass('active-image');
        var url = window.location.href;
        var isCreate = url.indexOf("create") > -1;
        var queryParams = new URLSearchParams(url.split('&')[1]);
        var qrOnboarding = queryParams.get('qr_onboarding');
        // if (qrOnboarding !== null) {
        // && isFirstQR == 0
        if ((qrOnboarding == 'active_nsf' || qrOnboarding == 'active_dpf' || qrOnboarding == 'active' || isCreate)) {

            $("#helpModal2").hide();
            $('#overlayPre').hide();
            $('#overlayPre').animate({
                opacity: '0'
            }, "slow");
            $('body').removeClass('modal-open');


        }

        if ($('#mobile-preview').length > 0) {
            $('#mobile-preview').remove();
        }
        // }

        $('#overlayPre').hide();

        activePreview.removeClass('preview-point slide-2 slide-3 slide-4');
        bottomFooter.removeClass('hpmodal-active-preview slide-2 slide-3 slide-4');
        clickCount = 0;

        // helpModal2
    });

    $('.fakeBack-btn').click(function() {
        $("#helpNextbtn").trigger('click');
    });
    $('.fakeNext-btn').click(function() {
        $("#helpNextbtn").trigger('click');
    });

    $(document).ready(function() {
        $('#helpModal').on('show.bs.modal', function() {
            // Remove the "active" class from the last carousel item with id "last"
            $('.carousel-inner').find('#lastEl').removeClass('active');
        });

    });

    // Remove If not needed
    $("#temp_next").click(function() {
        $("#tab2").addClass("active");
        if (!$('#qr-code-wrap').hasClass('active')) {
            $('#qr-code-wrap').addClass('active');
        }
    });
    // Remove If not needed



    //serialize the form data
    function serializePost(form) {
        var data = {};
        form = $(form).serializeArray();
        for (var i = form.length; i--;) {
            var name = form[i].name;
            var value = form[i].value;
            var index = name.indexOf('[]');
            if (index > -1) {
                name = name.substring(0, index);
                if (!(name in data)) {
                    data[name] = [];
                }
                data[name].push(value);
            } else
                data[name] = value;
        }

        return data;
    }

    //Validate form data on step 2
    // if invalid input, throw error
    //else return true


    function validation_form(errorRedirect = 1) {
        var qrCodeId = $("input[name=\"qrcodeId\"]").val();
        var qrType = $("input[name=\"type\"]").val();
        let allAreFilled = true;

        $('#validation_fire').val('1');
        const elements = document.querySelectorAll('.invalid_err');

        elements.forEach((element) => {
            element.remove();
        });

        var errorIds = [];


        document.getElementById("myform").querySelectorAll("[color_validate]").forEach(function(i, idx, array) {
            if (i.type == "text") {
                var id = i.id;
                var colorValue = (i.value).trim();


                $('#' + id).parent().parent().find(".invalid_err").remove();
                if (/^#[0-9A-F]{6}$/i.test(colorValue)) {
                    $('#' + id).parent().parent().css("border", "2px solid #4e5d782f");
                    $('#' + id).parent().parent().find(".invalid_err").remove();
                } else {
                    $('#' + id).parent().parent().css("border", "2px solid red");
                    if (id == 'primaryColorValue' || id == 'secondaryColorValue' || id == 'linkColorValue') {
                        $("<span class=\"invalid_err color-error\"><?= l('qr_step_2.invalid_code_error') ?></span>").insertAfter($('#' + id).parent().parent());
                    } else {
                        $("<span class=\"invalid_err color-error\"><?= l('qr_step_2.invalid_code_error') ?></span>").insertAfter($('#' + id).parent());
                    }
                    allAreFilled = false;
                }
            }

            if (idx == (array.length - 1)) {
                if (allAreFilled == true) {
                    allAreFilled = true;
                }
            }

        });

        document.getElementById("myform").querySelectorAll("[input_validate]").forEach(function(i) {

            var is_required = false;
            if (i.type == "file") {
                var id = i.id;
                var files = document.getElementById(id).files
                var parent = $(i).parent();
                $(i).closest(".custom-upload").find(".invalid_err").remove();

                var website = $("input[name=\"website\"]").val();

                if (website) {
                    if (/^(http|https|ftp):\/\/[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,}(:[0-9]{1,})?(\/.*)?$/i.test(website)) {
                        // $("#website").css("border", "2px solid #96949C");
                        $("#website").css("border", "");
                        $('#website').parent().find(".invalid_err").remove();
                    } else if (/^[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,}(:[0-9]{1,})?(\/.*)?$/i.test(website)) {
                        $("#website").css("border", "");
                        $('#website').parent().find(".invalid_err").remove();
                    } else {

                        allAreFilled = false;
                        $("#website").css("border", "2px solid red");
                        $("<span class=\"invalid_err\" style=\"margin-left:15px;\"><?= l('qr_step_2.url_error') ?></span>").insertAfter($("#website"));


                    }
                } else {
                    $("#website").css("border", "");
                }

                if (files.length <= 0) {
                    if (parent.hasClass("before-upload")) {
                        $(i).parent().parent().css("border", "2px dashed red")
                        $("<span class=\"invalid_err\"><?= l('qr_step_2.file_selection_error') ?></span>").insertAfter($(i).closest("label"));

                        allAreFilled = false;

                    } else {

                        if (id == 'offerImage') {
                            var couponTglValue = $('#couponTgl').val();
                            if (couponTglValue == 'on') {
                                var offerImgValue = $('#offerImg').val();
                                if (offerImgValue == '') {
                                    $(i).parent().parent().css("border", "2px solid red")
                                    $("<span class=\"invalid_err\"><?= l('qr_step_2.file_selection_error') ?></span>").insertAfter($(i).closest("label"))
                                    allAreFilled = false;
                                }
                            }
                        } else {
                            $(i).parent().parent().css("border", "2px solid red")
                            $("<span class=\"invalid_err\"><?= l('qr_step_2.file_selection_error') ?></span>").insertAfter($(i).closest("label"))
                            allAreFilled = false;
                        }
                    }
                } else {
                    if (parent.hasClass("before-upload")) {
                        $(i).parent().parent().css("border", "2px dashed #96949C")
                    } else {
                        $(i).parent().parent().css("border", "2px solid #96949C")
                    }
                }
            } else if (i.type === "radio") {
                let radioValueCheck = false;
                document.getElementById("myform").querySelectorAll(`[name=${i.name}]`).forEach(function(r) {
                    if (r.checked) radioValueCheck = true;
                })
                allAreFilled = radioValueCheck;
                return;
            } else if (i.type == "url") {
                var urlvalue = (i.value).trim()
                var expression = /^(http|https|ftp):\/\/[-a-zA-Z0-9@:%_\+.~#?&//=]{1,256}\.[a-z]{2,}\b(\/[-a-zA-Z0-9@:%_\+.~#?&//=]*)?/gi;
                var regex = new RegExp(expression);

                $(i).parent().find(".invalid_err").remove();

                if (urlvalue == "") {
                    $(i).css("border", "2px solid red")
                    $("<span class=\"invalid_err\"><?= l('qr_step_2.required.error') ?></span>").insertAfter($(i))
                    allAreFilled = false;
                    is_required = true;
                } else if (!urlvalue.match(regex)) {
                    if (!(/^[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,}(:[0-9]{1,})?(\/.*)?$/i.test(urlvalue))) {
                        $(i).css("border", "2px solid red")
                        $("<span class=\"invalid_err\"><?= l('qr_step_2.url_error') ?>.</span>").insertAfter($(i))
                        allAreFilled = false;
                    }
                } else {
                    // $(i).css("border", "2px solid #96949C")
                    $(i).css("border", "")
                }
            } else {
                var fieldvalue = (i.value).trim()
                $(i).parent().find(".invalid_err").remove();

                if (fieldvalue == "") {

                    if (qrType == "menu") {
                        var errorSecId = $(i).closest('.section-collapse').attr('id');
                        errorIds.push(errorSecId);
                        var errorProId = $(i).closest('.product-collapse').attr('id');
                        errorIds.push(errorProId);
                    } else if (qrType == 'links') {
                        var errorId = $(i).closest('.collapse').attr('id');
                        errorIds.push(errorId);
                    }

                    $(i).css("border", "2px solid red")
                    $("<span class=\"invalid_err\"><?= l('qr_step_2.required.error') ?></span>").insertAfter($(i))
                    is_required = true;

                    allAreFilled = false;

                } else {
                    // $(i).css("border", "2px solid #96949C")
                    $(i).css("border", "")
                }
            }

        })

        // For 15 mb 
        document.getElementById("myform").querySelectorAll("[input_size_validate]").forEach(function(i) {

            if (i.type == "file") {
                var id = i.id;
                console.log(id);
                var files = document.getElementById(id).files
                var parent = $(i).parent();
                $(i).closest(".custom-upload").find(".invalid_err").remove();

                if (files.length) {
                    const [file] = files;
                    sizeInMb = file.size / Math.pow(1024, 2);
                    if (sizeInMb > 10) {
                        $(i).parent().css("border", "2px solid red")
                        $("<span class=\"invalid_err\" style='margin-top:15px;'><?= l('qr_step_2.max_allow_10mb.error') ?></span>").insertAfter($(i).parent().parent());
                        allAreFilled = false;
                        $("#sizeErrorMesg").remove();
                        $("#screensizeErrorMesg").remove();
                        $(".productsizeErrorMesg").remove();
                        if ($('.welcome-screen').children('#screensizeErrorMesg')) {
                            $('.welcome-screen').children('.screen-upload').children(".invalid_err").css("display", "none");
                        }
                        if ($('.welcome-screen').children('#sizeErrorMesg')) {
                            $('.welcome-screen').children(".invalid_err").css("display", "none");
                        }
                    }
                }
            }

        })


        $("input").filter(':not([input_validate])').each(function() {
            var urlvalue = ($(this).val()).trim();
            if ($(this).attr('type') == 'url') {
                // $(this).css("border", "2px solid #96949C")
                $(this).css("border", "")


                if (urlvalue) {
                    if (/^(http|https|ftp):\/\/[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,}(:[0-9]{1,})?(\/.*)?$/i.test(urlvalue)) {
                        $(this).css("border", "")
                        $(this).find(".invalid_err").remove();
                    } else if (/^[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,}(:[0-9]{1,})?(\/.*)?$/i.test(urlvalue)) {
                        $(this).css("border", "")
                        $(this).find(".invalid_err").remove();
                    } else {
                        $(this).css("border", "2px solid red")
                        if (qrType == "links") {
                            $("<span class=\"invalid_err invalid_err_links\"><?= l('qr_step_2.url_error') ?></span>").insertAfter($(this));
                        } else {
                            $("<span class=\"invalid_err\" style=\"position: absolute;\"><?= l('qr_step_2.url_error') ?></span>").insertAfter($(this));
                        }
                        allAreFilled = false;
                    }
                }
            }

            if ($(this).attr('type') == 'email') {
                $(this).css("border", "");

                var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
                if (!emailReg.test($.trim(this.value))) {
                    $(this).css("border", "2px solid red")
                    if (qrType == 'vcard') {
                        $("<span class=\"invalid_err\" style=\"position: absolute;\"><?= l('qr_step_2.email_not_valid') ?></span>").insertAfter($(this));
                    }
                    allAreFilled = false;
                } else {
                    $(this).css("border", "");
                    $(this).find(".invalid_err").remove();
                }
            }

        })

        if (qrType == 'app') {
            var google = $("input[name=\"google\"]");
            var apple = $("input[name=\"apple\"]");
            var amazon = $("input[name=\"amazon\"]");
            $(".social_err").html("");

            if ($(google).attr('type') != 'url' && $(apple).attr('type') != 'url' && $(amazon).attr('type') != 'url') {
                $(".social_err").html("Choose at least one store below and add a link to your app");
                $("<span class=\"invalid_err\"></span>").insertAfter($(".social_err"));
                allAreFilled = false;

            } else {
                $(".social_err").html("");
            }

        }



        if (qrType == 'video') {
            var is_video = $("input[name=\"is_video\"]").val();
            var videoYoutubeUrl = $("#youTubeUrl").val();
            if (parseInt(is_video) == 0 && videoYoutubeUrl == "") {
                allAreFilled = false;
                $("#youTubeUrl").css("border", "2px solid red");
                $("<span class=\"invalid_err\" style=\"margin-left:15px;\"><?= l('qr_step_2_video.video_selection_error') ?></span>").insertAfter($("#is_video"));
            } else {
                $("#youTubeUrl").css("border", "");
                $('#youTubeUrl').parent().find(".invalid_err").remove();
            }
        }
        if (qrType == 'images') {
            var files = myDropzone.getAcceptedFiles();
            var imageCount = window.allImages.length;
            var uploadedImages = $('[name="images[]"]');

            if (uploadedImages.length > 0) {
                allAreFilled = true;
            } else {
                var i = document.getElementById("files");
                $("<span class=\"invalid_err\" style='margin-top:15px;'><?= l('qr_step_2.file_selection_error') ?></span>").insertAfter($(i));
                allAreFilled = false;
                $("#logo-error").text("");
            }
        }
        if (qrType == 'mp3') {
            var files = myDropzone.getAcceptedFiles();
            var isMp3Uploaded = $("#mp3File").attr('value');

            if (isMp3Uploaded != '') {
                allAreFilled = true;
            } else {
                var i = document.getElementById("mp3");

                $("<span class=\"invalid_err\" style='margin-top:15px;'><?= l('qr_step_2.file_selection_error') ?></span>").insertAfter($(i));

                allAreFilled = false;
                $("#logo-error").text("");
            }

        }
        if (qrType == 'pdf') {
            var files = myDropzone.getAcceptedFiles();
            var isPdfUploaded = $("#pdfFile").attr('value');

            if (isPdfUploaded == '') {
                var i = document.getElementById("pdf");
                $("<span class=\"invalid_err\" style='margin-top:15px;'><?= l('qr_step_2.file_selection_error') ?></span>").insertAfter($(i));

                allAreFilled = false;
                $("#logo-error").text("");
            }

        }
        if (qrType == 'business' || qrType == 'menu') {
            var contactWebsite = $("input[name=\"contactWebsite\"]").val();

            if (contactWebsite) {
                if (/^(http|https|ftp):\/\/[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,}(:[0-9]{1,})?(\/.*)?$/i.test(contactWebsite)) {
                    // $("#contactWebsite").css("border", "2px solid #96949C");
                    $("#contactWebsite").css("border", "");
                    $('#contactWebsite').parent().find(".invalid_err").remove();
                } else if (/^[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,}(:[0-9]{1,})?(\/.*)?$/i.test(contactWebsite)) {
                    $("#contactWebsite").css("border", "");
                    $('#contactWebsite').parent().find(".invalid_err").remove();
                } else {
                    allAreFilled = false;
                    $("#contactWebsite").css("border", "2px solid red");
                    $("<span class=\"invalid_err\" style=\"margin-left:15px; position: absolute;\"><?= l('qr_step_2.url_error') ?></span>").insertAfter($("#contactWebsite"));
                }
            } else {
                $("#contactWebsite").css("border", "");
            }


            var contactCount = $('.contactMobiles').filter(function() {
                if ($.trim(this.value).length === 0) {
                    $("<span class=\"invalid_err\" style=\"margin-left:15px;\"><?= l('qr_step_2.required_error') ?></span>").insertAfter($(this));
                }

                return $.trim(this.value).length === 0;

            }).length > 0;

            if (contactCount) {
                allAreFilled = false;
            }

            var contactEmail = $('.contactEmails').filter(function() {
                var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
                if ($.trim(this.value).length === 0) {
                    $("<span class=\"invalid_err\" style=\"margin-left:15px;\"><?= l('qr_step_2.required_error') ?></span>").insertAfter($(this));
                }

                if (!emailReg.test($.trim(this.value))) {
                    $("<span class=\"invalid_err\" style=\"margin-left:15px;\"><?= l('qr_step_2.email_not_valid') ?></span>").insertAfter($(this));
                    allAreFilled = false;
                }

                return $.trim(this.value).length === 0;

            }).length > 0;

            if (contactEmail) {
                allAreFilled = false;
            }
        }

        //button url
        var buttonUrl = $("input[name=\"buttonUrl\"]").val();

        if (buttonUrl != '') {
            if (buttonUrl) {
                if (/^(http|https|ftp):\/\/[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,}(:[0-9]{1,})?(\/.*)?$/i.test(buttonUrl)) {
                    // $("#buttonUrl").css("border", "2px solid #96949C");
                    $("#buttonUrl").css("border", "");
                    $('#buttonUrl').parent().find(".invalid_err").remove();
                } else if (/^[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,}(:[0-9]{1,})?(\/.*)?$/i.test(buttonUrl)) {
                    $("#buttonUrl").css("border", "");
                    $('#buttonUrl').parent().find(".invalid_err").remove();
                } else {
                    $('#buttonUrl').parent().find(".invalid_err").remove();
                    $("#buttonUrl").css("border", "2px solid red");
                    $("<span class=\"invalid_err\" style=\"margin-left:15px; position: absolute;\"><?= l('qr_step_2.url_error') ?></span>").insertAfter($("#buttonUrl"));
                    allAreFilled = false;
                }

            } else {
                $('#buttonUrl').parent().find(".invalid_err").remove();
                $("#buttonUrl").css("border", "");
            }
        }

        //location url
        var offer_url1 = $("input[name=\"offer_url1\"]").val();

        if (offer_url1) {
            if (/^(http|https|ftp):\/\/[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,}(:[0-9]{1,})?(\/.*)?$/i.test(offer_url1)) {
                // $("#offer_url1").css("border", "2px solid #96949C");
                $("#offer_url1").css("border", "");
                $('#offer_url1').parent().find(".invalid_err").remove();
            } else if (/^[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,}(:[0-9]{1,})?(\/.*)?$/i.test(offer_url1)) {
                $("#offer_url1").css("border", "");
                $('#offer_url1').parent().find(".invalid_err").remove();
            } else {
                $('#offer_url1').parent().find(".invalid_err").remove();
                allAreFilled = false;
                $("#offer_url1").css("border", "2px solid red");
                $("<span class=\"invalid_err\" style=\"margin-left:15px;\"><?= l('qr_step_2.url_error') ?></span>").insertAfter($("#offer_url1"));
            }

        } else {
            $('#offer_url1').parent().find(".invalid_err").remove();
            $("#offer_url1").css("border", "");
        }

        document.getElementById("myform").querySelectorAll("[input_validate]").forEach(function(i) {
            if (i.type == "url") {
                var urlvalue = (i.value).trim()
                var expression = /^(http|https|ftp):\/\/[-a-zA-Z0-9@:%_\+.~#?&//=]{1,256}\.[a-z]{2,}\b(\/[-a-zA-Z0-9@:%_\+.~#?&//=]*)?/gi;
                if (i.id == 'socialUrl') {
                    expression = /[-a-zA-Z0-9@:%_\+.~#?&//=]{1,256}\.[a-z]{2,}\b(\/[-a-zA-Z0-9@:%_\+.~#?&//=]*)?/gi;
                }
                var regex = new RegExp(expression);

                $(i).parent().find(".invalid_err").remove();
                $(i).css("border", "");

                if (urlvalue == "") {
                    $(i).css("border", "2px solid red")
                    $("<span class=\"invalid_err\"><?= l('qr_step_2.required.error') ?></span>").insertAfter($(i))
                    $(".invalid_err").attr("style", "display: block !important;");
                    allAreFilled = false;
                } else {
                    if (!urlvalue.match(regex)) {

                        if (!(/^[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,}(:[0-9]{1,})?(\/.*)?$/i.test(urlvalue))) {
                            $(i).parent().find(".invalid_err").remove();
                            $(i).css("border", "2px solid red")
                            $("<span class=\"invalid_err\"><?= l('qr_step_2.url_error') ?></span>").insertAfter($(i))
                            $(".invalid_err").attr("style", "display: block !important;");
                            allAreFilled = false;

                        }

                    } else {
                        $(i).css("border", "");
                        $(i).parent().find(".invalid_err").remove();

                    }
                }

            }
        });

        $(document).on('change ', '.socialUrl', function() {
            var dataUrl = $(this).data('attr');
            if (dataUrl == '') {
                // $("<span class=\"invalid_err\"><?= l('qr_step_2.required.error') ?></span>").insertAfter($(this))
                // $(".invalid_err").attr("style", "display: block !important;");
                // allAreFilled = false;
            } else {
                $(this).css("border", "");
                $(this).parent().find(".invalid_err").remove();
            }
        });

        // #scroll to error
        if (!allAreFilled && errorRedirect == 1) {

            if (qrType == 'menu') {

                for (var x = 0; x < errorIds.length; x++) {
                    var error = errorIds[x];
                    $('#' + error).closest('.section-collapse').addClass('show');
                    $('#' + error).closest('.custom-accodian').find('[data-target="#' + error + '"]').addClass('collapsed');
                    $('#' + error).closest('.custom-accodian').find('[data-target="#' + error + '"]').attr("aria-expanded", "true");
                    $('#' + error).addClass('show');
                }

            } else if (qrType == 'coupon') {

                $('.invalid_err').closest('.collapse').addClass('show');
                $('.invalid_err').closest('.custom-accodian').find('.accodianBtn').addClass('collapsed');
                $('.invalid_err').closest('.custom-accodian').find('.accodianBtn').attr("aria-expanded", "true");

            } else if (qrType == 'links') {

                for (var x = 0; x < errorIds.length; x++) {
                    var error = errorIds[x];
                    $('#' + error).addClass('show');
                    $('#' + error).closest('.custom-accodian').find('[data-target="#' + error + '"]').addClass('collapsed');
                    $('#' + error).closest('.custom-accodian').find('[data-target="#' + error + '"]').attr("aria-expanded", "true");
                }

            }

            $('html, body').animate({
                scrollTop: $('.invalid_err')?.offset()?.top - 400
            }, 100);
        }


        return allAreFilled;
    }



    function validate_url(urlvalue) {
        urlvalue = urlvalue.trim();
        if (urlvalue != "") {
            var expression = /[-a-zA-Z0-9@:%_\+.~#?&//=]{1,256}\.[a-z]{2,}(?:\.[a-z]{2,})?\b(\/[-a-zA-Z0-9@:%_\+.~#?&//=]*)?/gi;

            var regex = new RegExp(expression);
            if (!urlvalue.match(regex)) {
                return false
            }
        }
    }


    function validate_number(e) {
        var k = e.keyCode;
        return (k >= 48 && k <= 57 || k == 8);
    }

    //save the qr code using ajax
    // and return the newly generated qrcodeId
    // everytime when jump from step 2 to  3 this function calls itself 
    // if qrcodeId is generated, update the details
    //else insert the details
    var edited = false;
    $(document).on('keyup change paste', 'input, select, textarea', "#acc_welcomeScreen", function() {
        edited = true;
    });

    function save_qr_fn() {

        var form = document.getElementById("myform");
        let form_data = new FormData(form);
        var formData = "";

        if (form) {
            form_data.append('action', 'save_qr_code');
            form_data.append('userId', $("input[name=\"userid\"]").val());
            form_data.append('qr_code_id', $("input[name=\"qrcodeId\"]").val());
            form_data.append('qr_code', $('input[name=\"qr_code\"]').val());
            form_data.append('project_id', <?= (isset($_REQUEST['project_id']) && !empty($_REQUEST['project_id'])) ? $_REQUEST['project_id'] : 0 ?>);
            if (edited) {
                $("#overlay").show();
            }
            edited = false;
            // $('#temp_submit').attr('disabled', true);

            $.ajax({
                type: 'POST',
                method: 'post',
                url: '<?php echo url('api/ajax') ?>',
                data: form_data,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    $("input[name=\"qrcodeId\"]").val(response.data);
                    $("#myform").attr('action', '<?php echo url('qr-code-update') ?>/' + response.data);
                    $("#current_state").val('edit');
                    $("#overlay").hide();
                }
            });
        }
    }


    <?php echo isset($data->qr_code_id) ? '$(document).ready(function(){
   change_step(2);
   })' : 'change_step(1);'; ?>

    changeUrl();
    $("#temp_next").show();
    $("#temp_next_tmp").hide();
    $("#temp_submit").hide();


    function changeLabel(step) {
        if (step == 1) {
            $("#step-id-label").text("1. <?= l('qr_step_1.label') ?>")
        } else if (step == 2) {
            $("#step-id-label").text("2.  <?= l('qr_step_2.label') ?>");
            $(".funnel-qr-header").addClass('d-none');
            $('#step-id-label').removeClass('d-none');
            $("#qrCodeBtnTooltip").css("display", "block");
        } else if (step == 3) {
            $("#step-id-label").text("3.  <?= l('qr_step_3.label') ?>");
            $(".funnel-qr-header").addClass('d-none');
            $('#step-id-label').removeClass('d-none');
            $("#qrCodeBtnTooltip").css("display", "none");
        }
    }

    var __QRTYPES = <?php echo json_encode($data->qr_code_settings['type']); ?>;

    var frame = $('#iframesrc')[0];


    // Function to handle the redirection 
    function redirectToNSFFunnel(step) {
        // Get the current query parameters from the URL

        var queryString = window.location.search;

        const currentURL = window.location.href;
        const url = new URL(currentURL);
        const params = url.searchParams;

        const searchParams = new URLSearchParams(queryString)
        const param = searchParams.get('qr_onboarding')

        // Your NSF Funnel link http://localhost/qr-new/qr
        const nsfFunnelLink = "<?php echo SITE_URL ?>qr?";

        // Set the query parameters for the NSF Funnel link
        params.set("step", step);

        if (param == "active_nsf") {
            params.set("qr_onboarding", "active_nsf");
        } else if (param == "active_dpf") {
            params.set("qr_onboarding", "active_dpf");
        } else {
            params.set("qr_onboarding", "active_nsf");
        }

        // Create the updated URL with the query parameters
        const updatedURL = nsfFunnelLink + params.toString();
        sessionStorage.removeItem("funnle_url");
        sessionStorage.setItem("funnle_url", updatedURL);

        // Update the URL using window.history.pushState
        window.history.pushState({}, "", updatedURL);
    }

    // new landaing page route
    function redirectToNewLanding(step) {

        // Get the current query parameters from the URL
        var queryString = window.location.search;

        const currentURL = window.location.href;
        const url = new URL(currentURL);
        const params = url.searchParams;

        if (step == 1) {
            const landingLink = "<?php echo SITE_URL ?>create?";
            params.set("step", step);
            const updatedURL = landingLink + params.toString();
            sessionStorage.removeItem("funnle_url");
            sessionStorage.setItem("funnle_url", updatedURL);
            window.history.pushState({}, "", updatedURL);
        }

    }

    // isvalidated = true;
    $("#temp_next").on("click", function() {
        var c_step = $("input[name=\"step_input\"]").val();
        change_step(parseInt(c_step) + 1);
        var bottombtnText = $(".bottom-back-btn span.bottom-btn-label").text();

    });


    const progressBar = document.getElementById("progress-bar");

    var isBackState2 = false;
    var isBackState3 = false;
    var funnelInCompletedQR = <?php echo json_encode(isset($_COOKIE['nsf_user_id'])); ?>;
    var validationFired = $("input[name=\"validation_fire\"]").val();
    var elements = document.querySelectorAll('.invalid_err');

    var activeStep3 = $('#current_state').val();

    function change_step(step) {


        var step2Active = $(".step-2-slides").hasClass("carousel-inner");
        var inputCheck = $("input[name=\"qr_code\"]").val();

        var type = $("input[name=\"qrtype_input\"]").val();
        var url = window.location.href;
        var isCreate = url.indexOf("create") > -1;
        var queryParams = new URLSearchParams(url.split('&')[1]);
        var qrOnboarding = queryParams.get('qr_onboarding');
        var isFirstQR = $('#isFirstQR').val();
        var checkStep = $("input.stepInput").val();
        var CurrentStep = $("input[name=\"current_step_input\"]").val();

        if (step == 0) {
            window.location.href = '<?php echo SITE_URL ?>qr-codes';

            step = 1;
        }

        if (step == 1) {
            $(".help-info-modal").attr("data-target", "#helpModal");
            $(document).prop('title', '<?= l('qr_step_1.title')   ?>');

        } else if (step == 2) {
            $(".col-right-inner").removeAttr("style");
            document.getElementById('landing_section')?.remove();
            $(document).prop('title', '<?= l('qr_step_2.title_2') ?>');
            $('#preview_qrcode').addClass('hidden-preview-qr');


        } else if (step == 3) {

            $(document).prop('title', '<?= l('qr_step_3.title_3') ?>');
            $('#preview_qrcode').removeClass('hidden-preview-qr');

        }

        if (step == 1) {
            $('#qr-proceed-footer').addClass('d-none');
            $(".default-preview-text").css("display", "none");
        }
        if (step == 2) {
            // $('html, body').prop('scrollTop', 0);
            window.scrollTo(0, 0);

        }
        if ((step == 2) || (step == 3)) {
            $('#qr-proceed-footer').removeClass('d-none');
            $(".default-preview-text").css("display", "none");

            if ($('.main-container').hasClass('qr-step-default')) {
                $('.main-container').removeClass('qr-step-default');
            }
        }
        var is_true = (step != 3) ? true : validation_form();


        if (is_true == true) {
            $("input[name=\"step_input\"]").val(parseInt(step) + 1);
            if (step == 3) {

                changeLabel(3)
                save_qr_fn();
            }

            if (step == 1) {
                $("#preview_qrcode").css({
                    'visibility': 'hidden',
                    'opacity': '0',
                });
                $("#preview_qrcode_mobile").hide();
            } else {
                $("#preview_qrcode").css({
                    'visibility': 'visible',
                    'opacity': '1',
                });
                $("#preview_qrcode_mobile").show();
            }

            var step1 = $("input[name=\"step_input\"]").val(step);
            var current = $("input[name=\"current_step_input\"]").val();
            $("input[name=\"current_step_input\"]").val(step);

            if (step != 1) {
                $(".arrow-info-block").css("display", "none");
            }
            //  else {
            //     $(".arrow-info-block").css("display", "block");
            // }



            if ($("input[name=\"qrcodeId\"]").val() != "" && $("input[name=\"qrcodeId\"]").val() != null) {
                $("#myform").attr('action', '<?php echo url('qr-code-update') ?>/' + $("input[name=\"qrcodeId\"]").val());
                var typeOfQr = $("input[name=\"type\"]").val();
                $("#current_state").val('edit');
                if (typeOfQr != 'images') {
                    $("input").trigger('change')
                }
            }

            if (parseInt(step) == 1) {
                //Changes For Step 1
                <?php if (\Altum\Middlewares\Authentication::is_temp_user()) { ?>

                    var urlKey = '<?= \Altum\Routing\Router::$controller_key ?>';

                    var url = window.location.href;
                    if (urlKey == 'create') {
                        redirectToNewLanding(1);
                    } else if (url.includes('active_nsf')) {
                        redirectToNSFFunnel(1);
                    } else if (url.includes('active_dpf')) {
                        redirectToNSFFunnel(1);
                    }


                <?php } else { ?>
                    window.history.pushState("object or string", "Title", '<?php echo SITE_URL . ($userLanguageCode  == 'en'  ? null : $userLanguageCode  . '/') ?>qr?step=1<?= !empty($_REQUEST['project_id']) ? "&project_id={$_REQUEST['project_id']}" : '' ?><?= $userQrCode == null ? "&qr_onboarding=active" : "" ?>');
                <?php }  ?>
                changeLabel(1)
                $("#cancel > span").text('Cancel');
                $("#temp_next").show();

                // $("#qr-preview").prop('src', '<?php echo ASSETS_FULL_URL; ?>images/funnel-default-phone-mockup-2.webp');
                $(".default-preview-text").css("display", "none");

                if (current > 1) {
                    document.querySelector('#tab1.step-1-wrp').classList.add('active-step');
                    document.getElementById('tab1text').style.fontWeight = '700';
                    document.getElementById('tab1text').style.opacity = '1';
                    document.getElementById('ms1').style.fill = '#FE8E3E';
                    document.getElementById('ms2').style.fill = '#220E27';
                    document.getElementById('ms2').style.opacity = '0.50';
                    document.getElementById('ms3').style.fill = '#220E27';
                    document.getElementById('step2_form').style.display = 'none';
                    document.getElementById('step3').style.display = 'none';
                    var elementSCreen1 = document.getElementById('step1');
                    if (elementSCreen1) {
                        document.getElementById('step1').style.display = 'block';

                    } else {
                        get_data();
                    }

                } else if (current != 1) {
                    get_data()

                }

                if (type == 'coupon') {
                    $('.dcalendarpicker').remove();
                }

            } else if (parseInt(step) == 2) {
                changeLabel(2)

                //Changes For Step 2
                if ($('.main-container').hasClass('create-qr-container')) {
                    $('.main-container').removeClass('create-qr-container');
                    $('#previewModel .col-right-inner ').removeClass('create-view-phone');
                } else if ($('.main-container').hasClass('qr-step-default')) {
                    $('.main-container').removeClass('qr-step-default');
                }

                $(".help-info-modal").attr("data-target", "#helpModal2");
                $(".step-2-slides").addClass("carousel-inner");
                $(".step-3-slides").removeClass("carousel-inner");
                $(".step-3-slides .carousel-item").removeClass("active");
                $(".step-2-slides .carousel-1-item-1").addClass("active");
                $(".step-3-slides .carousel-2-item-1").removeClass("active");
                $(".step-3-slides").hide();
                $(".step-2-slides").show();
                if (!funnelInCompletedQR) {
                    if (!(type == 'url' || type == 'wifi')) {
                        if (!isBackState2 && !isBackState3) {
                            // if (qrOnboarding !== null) {
                            // && isFirstQR == 0
                            if ((qrOnboarding == 'active_nsf' || qrOnboarding == 'active_dpf' || qrOnboarding == 'active' || isCreate)) {
                                // if (inputCheck !== "") {
                                // $("#helpModal").modal('show');
                                setTimeout(function() {
                                    $("#helpModal2").show();
                                    $('#overlayPre').show();
                                    $('#overlayPre').animate({
                                        opacity: '0.5'
                                    }, "0.15s");
                                    $('body').addClass('modal-open');
                                }, 1000);
                                progress = 25;
                                updateProgressBar();
                                // }
                            }
                            // }     
                            isBackState2 = true;

                        }
                    }
                }
                //Changes For Step 2



                <?php if (\Altum\Middlewares\Authentication::is_temp_user()) { ?>
                    redirectToNSFFunnel(2);
                <?php } else { ?>
                    window.history.pushState("object or string", "Title", '<?php echo SITE_URL . ($userLanguageCode  == 'en'  ? null : $userLanguageCode  . '/') ?>qr?step=2<?= !empty($_REQUEST['project_id']) ? "&project_id={$_REQUEST['project_id']}" : '' ?><?= $userQrCode == null ? "&qr_onboarding=active" : "" ?>');
                <?php }  ?>


                if ($("input[name=\"qrcodeId\"]").val() != "" && $("input[name=\"qrcodeId\"]").val() != null) {
                    $("#cancel > span").text('<?= l('qr_step_2.back_btn') ?>');
                    $('#temp_next_tmp').hide();
                    $('#temp_next').show();
                    $("#2").attr('disabled', false)
                    $("#2").removeClass("disable-btn")
                    $("#temp_next .next-btn-all .next-label").text('<?= l('qr_step_2.save_btn') ?>');
                    if (qr_status == '1') {
                        $("#cancel > span").text('<?= l('qr_step_2.qr_types') ?>');
                        $(".bottom-back-btn-wrap").addClass("editing");
                        $(".bottom-preivew-btn-wrap").addClass("editing");
                    } else {
                        $(".bottom-preivew-btn-wrap").removeClass("editing");
                        $(".bottom-back-btn-wrap").removeClass("editing");
                        $("#cancel > span").text('<?= l('qr_step_2.back_btn') ?>');
                    }


                } else {
                    $("#cancel > span").text('<?= l('qr_step_2.back_btn') ?>');
                    $("#temp_next").show();
                    $("#temp_next_tmp").hide();
                    $("#temp_submit").hide();

                    document.getElementById('temp_next').style.display = 'block';

                }

                document.querySelector('#tab1.step-1-wrp').classList.add('active-step');
                document.querySelector('#tab1Line.step-1-line').classList.add('active-line');
                document.querySelector('#tab2.step-2-wrp').classList.add('active-step');
                document.getElementById('ms1').style.fill = '#220E27';
                document.getElementById('ms2').style.fill = '#FE8E3E';
                document.getElementById('ms2').style.opacity = '1';
                document.getElementById('ms3').style.fill = '#220E27';
                document.getElementById('preview').style.display = 'none';
                document.getElementById('tabhead').style.display = 'flex';
                document.getElementById('temp_submit').style.display = 'none';

                if (parseInt(current) != 3) {

                    var type_old = $("input[name=\"qrtype_input_old\"]").val();
                    var type = $("input[name=\"qrtype_input\"]").val();


                    if (type_old === type) {
                        document.getElementById('step2_form').style.display = 'block';
                        document.getElementById('step2').style.display = 'block';
                        document.getElementById('step3').style.display = 'none';
                        document.getElementById('step1').style.display = 'none';

                        $('#qr-preview').css("display", "none");
                        $('#iframesrc').css("display", "block");

                        LoadPreview(false,false,null);

                        // frame.contentWindow.crossOrigin = 'anonymus'
                        // frame.contentWindow.location.replace("<?php echo LANDING_PAGE_URL; ?>preview/" + type + "?lang=<?php echo $userLanguage ?>");

                        $('#temp_next').show();
                    } else {

                        $("#1").addClass('active');
                        $("#2").removeAttr('onclick');
                        $("#2").addClass('disable-btn');
                        $("#2").attr('disabled', true);

                        if ($("input[name=\"qrtype_input_old\"]").val() != '') {
                            document.getElementById('step2').remove();
                        }
                        var type = $("input[name=\"qrtype_input\"]").val();
                        $("input[name=\"qrtype_input_old\"]").val(type);

                        var elementSCreen1 = document.getElementById('step1');

                        $('#qr-preview').css("display", "none");
                        $('#iframesrc').css("display", "block");

                        
                        document.getElementById('iframesrc').contentWindow.postMessage({
                            live:true,
                            type: type == 'url' ? 'website' : type,
                            step:2,
                            static:true
                        },'<?=LANDING_PAGE_URL?>');
                        

                        // frame.contentWindow.location.replace("<?php echo LANDING_PAGE_URL; ?>preview/" + (type == 'url' ? 'website' : type) + "?lang=<?php echo $userLanguage ?>");

                        if (elementSCreen1) {

                            document.getElementById('step1').style.display = 'none';
                        }
                        get_data();
                    }


                } else {

                    <?php if (\Altum\Middlewares\Authentication::is_temp_user()) { ?>
                        redirectToNSFFunnel(2);
                    <?php } else { ?>
                        window.history.pushState("object or string", "Title", '<?php echo SITE_URL . ($userLanguageCode  == 'en'  ? null : $userLanguageCode  . '/') ?>qr?step=2<?= !empty($_REQUEST['project_id']) ? "&project_id={$_REQUEST['project_id']}" : '' ?><?= $userQrCode == null ? "&qr_onboarding=active" : "" ?>');
                    <?php }  ?>

                    var step2_element = document.getElementById('step2_form');
                    if (typeof(step2_element) == 'undefined' || step2_element == null) {
                        window.location.reload();
                    }

                    document.getElementById('step2_form').style.display = 'block';
                    document.getElementById('step2').style.display = 'block';
                    document.getElementById('step3').style.display = 'none';
                    $('#temp_next').show();
                }

                if ($('.steps-progress-wrp').height() > 41) {
                    $('#step-id-label').addClass('set-pad')
                } else {
                    $('#step-id-label').removeClass('set-pad')

                }
                $(window).on('resize', function() {
                    if ($('.steps-progress-wrp').height() > 41) {
                        $('#step-id-label').addClass('set-pad')
                    } else {
                        $('#step-id-label').removeClass('set-pad')

                    }
                });

                var requiredAccordianBtnText = $(".accodianBtn .custom-accodian-heading .accodianRequired").text().length;
                console.log(requiredAccordianBtnText);


            } else {

                if (parseInt(step) == 3) {
                    //Changes For Step 3
                    $(".step-2-slides").hide();
                    $(".help-info-modal").attr("data-target", "#helpModal2");
                    $(".step-2-slides").removeClass("carousel-inner");
                    $(".step-3-slides").addClass("carousel-inner");
                    $(".step-2-slides .carousel-item").removeClass("active");
                    $(".step-2-slides .carousel-1-item-1").removeClass("active");
                    $(".step-3-slides .carousel-2-item-1").addClass("active");
                    $(".step-3-slides").show();
                    if (inputCheck !== "") {
                        if (!funnelInCompletedQR) {

                            if (!isBackState3) {
                                if ((qrOnboarding == 'active_nsf' || qrOnboarding == 'active_dpf' || qrOnboarding == 'active')) {

                                    updateButton.innerHTML = "Continue"

                                    setTimeout(function() {
                                        $("#helpModal2").show();
                                        $('#overlayPre').show();
                                        $('#overlayPre').animate({
                                            opacity: '0.5'
                                        }, "0.15s");
                                        $('body').addClass('modal-open');
                                        progress = 50;
                                        updateProgressBar();
                                    }, 1000);


                                }

                                isBackState3 = true;
                            }

                        }
                    }
                    //Changes For Step 3

                    $("#cancel > span").text('<?= l('qr_step_2.back_btn') ?>');
                    <?php if (\Altum\Middlewares\Authentication::is_temp_user()) { ?>
                        redirectToNSFFunnel(3);
                    <?php } else { ?>
                        window.history.pushState("object or string", "Title", '<?php echo SITE_URL . ($userLanguageCode  == 'en'  ? null : $userLanguageCode  . '/') ?>qr?step=3<?= !empty($_REQUEST['project_id']) ? "&project_id={$_REQUEST['project_id']}" : '' ?><?= $userQrCode == null ? "&qr_onboarding=active" : "" ?>');
                    <?php }  ?>

                }
                document.querySelector('#tab1Line.step-1-line').classList.add('active-line');
                document.querySelector('#tab2.step-2-wrp').classList.add('active-step');
                document.querySelector('#tab2.step-2-wrp').classList.add('complete');
                document.querySelector('#tab3.step-3-wrp').classList.add('active-step');
                document.querySelector('#tab2Line.step-2-line').classList.add('active-line');
                document.querySelector('#tab1.step-1-wrp').classList.add('active-step');
                document.getElementById('tabs-1').classList.remove('active');
                document.getElementById('1').classList.remove('active');
                document.getElementById('tabs-2').classList.add('active');
                document.getElementById('2').classList.add('active');
                var elementSCreen1 = document.getElementById('step1');

                if (elementSCreen1) {
                    document.getElementById('step1').style.display = 'none';
                }

                document.getElementById('step2_form').style.display = 'none';
                document.getElementById('step3').style.display = 'block';
                document.getElementById('temp_next').style.display = 'none';

                document.getElementById('temp_submit').style.display = 'block';

                reload_qr_code_event_listener();


            }


            if ($('.steps-progress-wrp').height() > 41) {
                $('#step-id-label').addClass('set-pad')
            } else {
                $('#step-id-label').removeClass('set-pad')

            }
            $(window).on('resize', function() {
                if ($('.steps-progress-wrp').height() > 41) {
                    $('#step-id-label').addClass('set-pad')
                } else {
                    $('#step-id-label').removeClass('set-pad')

                }
            });
        } else {
            console.log("is_true not valid")
        }

    }

    function removejscssfile(filename, filetype) {
        var targetelement = (filetype == "js") ? "script" : (filetype == "css") ? "link" : "none" //determine element type to create nodelist from
        var targetattr = (filetype == "js") ? "src" : (filetype == "css") ? "href" : "none" //determine corresponding attribute to test for
        var allsuspects = document.getElementsByTagName(targetelement)
        for (var i = allsuspects.length; i >= 0; i--) { //search backwards within nodelist for matching elements to remove
            if (allsuspects[i] && allsuspects[i].getAttribute(targetattr) != null && allsuspects[i].getAttribute(targetattr).indexOf(filename) != -1)
                allsuspects[i].parentNode.removeChild(allsuspects[i]) //remove element by calling parentNode.removeChild()
        }
    }

    window.sbdbg = {
        on: false
    };
    // step 3 qr code style radio button color change
    function code_style_color_change() {

        var patternGradient = $("#isBorderGradient");
        var backgroundGradient = $("#background_colour_gradient");

        var forgroundColor = $('#ForgroundColor').val();
        var backgroundColor = $('#BackgroundColor').val();
        var forgroundColorFirst = $('#ForgroundColorFirst').val();
        var forgroundColorSecond = $('#ForgroundColorSecond').val();
        var backgroundColorFirst = $('#BackgroundColorFirst').val();
        var backgroundColorSecond = $('#BackgroundColorSecond').val();

        var foregroundGradientStyle = $('.foregroundGradientStyle').val();
        var backgroundGradientStyle = $('.backgroundGradientStyle').val();

        var codeTransparentValue = $('#is_transparent');


        if (patternGradient.prop("checked") || backgroundGradient.prop("checked")) {

            if (foregroundGradientStyle == 'vertical') {
                var forgroundGradientColor = "linear-gradient(180deg, " + forgroundColorFirst + ", " + forgroundColorSecond + ")";
            } else if (foregroundGradientStyle == 'horizontal') {
                var forgroundGradientColor = "linear-gradient(90deg, " + forgroundColorFirst + ", " + forgroundColorSecond + ")";
            } else if (foregroundGradientStyle == 'diagonal') {
                var forgroundGradientColor = "linear-gradient(135deg, " + forgroundColorFirst + ", " + forgroundColorSecond + ")";
            } else if (foregroundGradientStyle == 'inverse_diagonal') {
                var forgroundGradientColor = "linear-gradient(45deg, " + forgroundColorFirst + ", " + forgroundColorSecond + ")";
            } else if (foregroundGradientStyle == 'radial') {
                var forgroundGradientColor = "radial-gradient(" + forgroundColorFirst + ", " + forgroundColorSecond + ")";
            }

            if (backgroundGradientStyle == 'linear') {
                var backgroundGradientColor = "linear-gradient(to right, " + backgroundColorFirst + ", " + backgroundColorSecond + ")";
            } else if (backgroundGradientStyle == 'radial') {
                var backgroundGradientColor = "radial-gradient(" + backgroundColorFirst + ", " + backgroundColorSecond + ")";
            }

            if (patternGradient.prop("checked")) {
                $(".code-style").css("background", forgroundGradientColor);
            } else {
                $(".code-style").css("background", forgroundColor);
            }

            if (backgroundGradient.prop("checked")) {
                $(".code-style-background").css("background", backgroundGradientColor);
            } else {
                if (codeTransparentValue.prop("checked")) {
                    $(".code-style-background").css("background", "rgba(0,0,0,0)");
                } else {
                    $(".code-style-background").css("background", backgroundColor);
                }
            }

        } else {

            $(".code-style").css("background", forgroundColor);

            if (codeTransparentValue.prop("checked")) {
                $(".code-style-background").css("background", "rgba(0,0,0,0)");
            } else {
                $(".code-style-background").css("background", backgroundColor);
            }

        }
        reload_qr_code_event_listener()

    }

    // step 3 qr code corner radio button color change
    function code_corners_color_change() {

        var cornerDotAround = $('#EIColor').val();
        var cornerDot = $('#EOColor').val();

        var cornerDotAroundSvg = $('.cornerDotAroundSvg');
        var cornerDotSvg = $('.cornerDotSvg');

        $(document).on('change keyup', '#EIColor, #EIColorInput', function() {
            cornerDotAroundSvg.attr('fill', cornerDotAround);
        });

        $(document).on('change keyup', '#EOColor, #EOColorInput', function() {
            cornerDotSvg.attr('fill', cornerDot);
        });
    }

    $(document).on('change', '.foregroundGradientStyle, .backgroundGradientStyle, #is_transparent', function() {
        code_style_color_change();
    });

    function get_data() {
        var step = $("input[name=\"step_input\"]").val();
        var type = $("input[name=\"qrtype_input\"]").val();
        var userId = $("input[name=\"userid\"]").val();


        if (step == '2') {
            // loading animation start
            $('#overlay').show();
            $('#overlay').addClass('active');
        }

        var post_data = {
            step: step,
            type: type,
            action: 'ajax_content',
            userId: userId,
            qr_code_id: $("input[name=\"qrcodeId\"]").val(),
            onboarding_funnel: $("input[name=\"onboarding_funnel\"]").val()
        }
        $.ajax({
            type: 'POST',
            url: '<?php echo url('api/ajax') ?>',
            data: post_data,
            dataType: 'json',
            success: function(response) {

                var response = response.data;


                $("#ajax-content-data").append(response);
                $('#acc_nameOfQrCode').removeClass('show');

                $('#overlay').hide();

                $(document).ready(function() {
                    // var pickerFields = document.querySelectorAll("#acc_Design .pickerField");
                    // console.log(pickerFields);
                    $(".color-comp-1 .pickerField").each(function() {
                        colorPikerIconChange(this);
                    });

                    $(".color-comp-2 .pickerField").each(function() {
                        colorPikerIconChange(this);
                    });


                    if ($("#formcolorPalette1").hasClass('active')) {
                        var primaryC = $("#formcolorPalette1").find('input:first').val()
                        var secondaryC = $("#formcolorPalette1").find('input:last').val()
                        if ($("#formcolorPalette1").find($('.middlePalette'))) {
                            var middleC = $(".middlePalette").val()
                            $("#linkColor").css('background-color', middleC);
                        }
                        $("#primaryColor").css('background-color', primaryC);
                        $("#SecondaryColor").css('background-color', secondaryC);
                        $(".color-comp-3 .pickerField").each(function() {
                            colorPikerIconChange(this);
                        });
                    }


                });



                $("#formcolorPalette1").on('click',
                    function() {
                        currentPos = "";
                        var primaryC = $(this).find('input:first').val()
                        var secondaryC = $(this).find('input:last').val()
                        $("#primaryColor").val(primaryC)
                        $("#primaryColorValue").val(primaryC);
                        $("#selectPrimary").val(primaryC);
                        $("#SecondaryColor").val(secondaryC)
                        $("#secondaryColorValue").val(secondaryC);
                        $("#selectSecondary").val(secondaryC);
                        $("#primaryColor").css('background-color', primaryC);
                        $("#SecondaryColor").css('background-color', secondaryC);

                        $(".color-comp-1 .pickerField").each(function() {
                            colorPikerIconChange(this);
                        });
                        $(".color-comp-2 .pickerField").each(function() {
                            colorPikerIconChange(this);
                        });

                        if ($(this).find($('.middlePalette'))) {
                            var middleC = $(this).find('input:eq(1)').val();
                            $("#linkColor").val(middleC)
                            $("#linkColorValue").val(middleC);
                            $("#selectThird").val(middleC);
                            $("#linkColor").css('background-color', middleC);

                            $(".color-comp-3 .pickerField").each(function() {
                                colorPikerIconChange(this);
                            });
                        }
                        $('[name="activeId"]').attr('value', '');
                        $('[name="setFlip"]').attr('value', false);


                        LoadPreview(false, false, 'color_palette')
                    });

                $("#formcolorPalette2").on('click',
                    function() {
                        currentPos = "";
                        var primaryC = $(this).find('input:first').val()
                        var secondaryC = $(this).find('input:last').val()
                        $("#primaryColor").val(primaryC)
                        $("#primaryColorValue").val(primaryC);
                        $("#selectPrimary").val(primaryC);
                        $("#SecondaryColor").val(secondaryC)
                        $("#secondaryColorValue").val(secondaryC);
                        $("#selectSecondary").val(secondaryC);



                        $("#primaryColor").css('background-color', primaryC);
                        $("#SecondaryColor").css('background-color', secondaryC);

                        $(".color-comp-1 .pickerField").each(function() {
                            colorPikerIconChange(this);
                        });

                        $(".color-comp-2 .pickerField").each(function() {
                            colorPikerIconChange(this);
                        });

                        if ($(this).find($('.middlePalette'))) {
                            var middleC = $(this).find('input:eq(1)').val();
                            $("#linkColor").val(middleC)
                            $("#linkColorValue").val(middleC);
                            $("#selectThird").val(middleC);
                            $("#linkColor").css('background-color', middleC);
                            $(".color-comp-3 .pickerField").each(function() {
                                colorPikerIconChange(this);
                            });
                        }
                        $('[name="activeId"]').attr('value', '');
                        $('[name="setFlip"]').attr('value', false);



                        LoadPreview(false, false, 'color_palette')
                    });

                // 
                // 

                $("#formcolorPalette3").on('click',
                    function() {
                        currentPos = "";
                        var primaryC = $(this).find('input:first').val()
                        var secondaryC = $(this).find('input:last').val()
                        $("#primaryColor").val(primaryC)
                        $("#primaryColorValue").val(primaryC);
                        $("#selectPrimary").val(primaryC);
                        $("#SecondaryColor").val(secondaryC)
                        $("#secondaryColorValue").val(secondaryC);
                        $("#selectSecondary").val(secondaryC);

                        $("#primaryColor").css('background-color', primaryC);
                        $("#SecondaryColor").css('background-color', secondaryC);

                        $(".color-comp-1 .pickerField").each(function() {
                            colorPikerIconChange(this);
                        });

                        $(".color-comp-2 .pickerField").each(function() {
                            colorPikerIconChange(this);
                        });

                        if ($(this).find($('.middlePalette'))) {
                            var middleC = $(this).find('input:eq(1)').val();
                            $("#linkColor").val(middleC)
                            $("#linkColorValue").val(middleC);
                            $("#selectThird").val(middleC);
                            $("#linkColor").css('background-color', middleC);
                            $(".color-comp-3 .pickerField").each(function() {
                                colorPikerIconChange(this);
                            });
                        }
                        $('[name="activeId"]').attr('value', '');
                        $('[name="setFlip"]').attr('value', false);

                        LoadPreview(false, false, 'color_palette')
                    });

                $("#formcolorPalette4").on('click',
                    function() {
                        currentPos = "";
                        var primaryC = $(this).find('input:first').val()
                        var secondaryC = $(this).find('input:last').val()
                        $("#primaryColor").val(primaryC)
                        $("#primaryColorValue").val(primaryC);
                        $("#selectPrimary").val(primaryC);
                        $("#SecondaryColor").val(secondaryC)
                        $("#secondaryColorValue").val(secondaryC);
                        $("#selectSecondary").val(secondaryC);

                        $("#primaryColor").css('background-color', primaryC);
                        $("#SecondaryColor").css('background-color', secondaryC);

                        $(".color-comp-1 .pickerField").each(function() {
                            colorPikerIconChange(this);
                        });

                        $(".color-comp-2 .pickerField").each(function() {
                            colorPikerIconChange(this);
                        });

                        if ($(this).find($('.middlePalette'))) {
                            var middleC = $(this).find('input:eq(1)').val();
                            $("#linkColor").val(middleC)
                            $("#linkColorValue").val(middleC);
                            $("#selectThird").val(middleC);
                            $("#linkColor").css('background-color', middleC);
                            $(".color-comp-3 .pickerField").each(function() {
                                colorPikerIconChange(this);
                            });
                        }
                        $('[name="activeId"]').attr('value', '');
                        $('[name="setFlip"]').attr('value', false);

                        LoadPreview(false, false, 'color_palette')
                    });

                $("#formcolorPalette5").on('click',
                    function() {
                        currentPos = "";
                        var primaryC = $(this).find('input:first').val()
                        var secondaryC = $(this).find('input:last').val()
                        $("#primaryColor").val(primaryC)
                        $("#primaryColorValue").val(primaryC);
                        $("#selectPrimary").val(primaryC);
                        $("#SecondaryColor").val(secondaryC)
                        $("#secondaryColorValue").val(secondaryC);
                        $("#selectSecondary").val(secondaryC);

                        $("#primaryColor").css('background-color', primaryC);
                        $("#SecondaryColor").css('background-color', secondaryC);

                        $(".color-comp-1 .pickerField").each(function() {
                            colorPikerIconChange(this);
                        });

                        $(".color-comp-2 .pickerField").each(function() {
                            colorPikerIconChange(this);
                        });


                        if ($(this).find($('.middlePalette'))) {
                            var middleC = $(this).find('input:eq(1)').val();
                            $("#linkColor").val(middleC)
                            $("#linkColorValue").val(middleC);
                            $("#selectThird").val(middleC);
                            $("#linkColor").css('background-color', middleC);
                            $(".color-comp-3 .pickerField").each(function() {
                                colorPikerIconChange(this);
                            });
                        }
                        $('[name="activeId"]').attr('value', '');
                        $('[name="setFlip"]').attr('value', false);

                        LoadPreview(false, false, 'color_palette')
                    });

                $("#formcolorPalette6").on('click',
                    function() {
                        currentPos = "";
                        var primaryC = $(this).find('input:first').val()
                        var secondaryC = $(this).find('input:last').val()
                        $("#primaryColor").val(primaryC)
                        $("#primaryColorValue").val(primaryC);
                        $("#selectPrimary").val(primaryC);
                        $("#SecondaryColor").val(secondaryC)
                        $("#secondaryColorValue").val(secondaryC);
                        $("#selectSecondary").val(secondaryC);

                        $("#primaryColor").css('background-color', primaryC);
                        $("#SecondaryColor").css('background-color', secondaryC);

                        $(".color-comp-1 .pickerField").each(function() {
                            colorPikerIconChange(this);
                        });

                        $(".color-comp-2 .pickerField").each(function() {
                            colorPikerIconChange(this);
                        });


                        if ($(this).find($('.middlePalette'))) {
                            var middleC = $(this).find('input:eq(1)').val();
                            $("#linkColor").val(middleC)
                            $("#linkColorValue").val(middleC);
                            $("#selectThird").val(middleC);
                            $("#linkColor").css('background-color', middleC);
                            $(".color-comp-3 .pickerField").each(function() {
                                colorPikerIconChange(this);
                            });
                        }
                        $('[name="activeId"]').attr('value', '');
                        $('[name="setFlip"]').attr('value', false);

                        LoadPreview(false, false, 'color_palette')
                    });

                $("#formcolorPalette7").on('click',
                    function() {
                        currentPos = "";
                        var primaryC = $(this).find('input:first').val()
                        var secondaryC = $(this).find('input:last').val()
                        $("#primaryColor").val(primaryC)
                        $("#primaryColorValue").val(primaryC);
                        $("#selectPrimary").val(primaryC);
                        $("#SecondaryColor").val(secondaryC)
                        $("#secondaryColorValue").val(secondaryC);
                        $("#selectSecondary").val(secondaryC);

                        $("#primaryColor").css('background-color', primaryC);
                        $("#SecondaryColor").css('background-color', secondaryC);

                        $(".color-comp-1 .pickerField").each(function() {
                            colorPikerIconChange(this);
                        });

                        $(".color-comp-2 .pickerField").each(function() {
                            colorPikerIconChange(this);
                        });


                        if ($(this).find($('.middlePalette'))) {
                            var middleC = $(this).find('input:eq(1)').val();
                            $("#linkColor").val(middleC)
                            $("#linkColorValue").val(middleC);
                            $("#selectThird").val(middleC);
                            $("#linkColor").css('background-color', middleC);
                            $(".color-comp-3 .pickerField").each(function() {
                                colorPikerIconChange(this);
                            });
                        }
                        $('[name="activeId"]').attr('value', '');
                        $('[name="setFlip"]').attr('value', false);

                        LoadPreview(false, false, 'color_palette')
                    });

                $("#primaryColor").on('change',
                    function() {
                        currentPos = "";
                        var activeIndexPrimary = $('.formcolorPalette.active').index();
                        $(".formcolorPalette:eq(" + activeIndexPrimary + ")").find('input[type=\"color\"]:first').val($(this).val());
                        var primaryC = $(this).val();
                        $("#primaryColorValue").val(primaryC);
                        $("#selectPrimary").val(primaryC);
                        $('.primaryColorValue').parent().parent().css("border", "2px solid #96949C");
                        $(".primary-color-picker").parent().find(".invalid_err").remove();
                    });

                $("#primaryColorValue").on('change keyup',
                    function() {
                        currentPos = "";
                        var activeIndexPrimary = $('.formcolorPalette.active').index();
                        $(".formcolorPalette:eq(" + activeIndexPrimary + ")").find('input[type=\"color\"]:first').val($(this).val());
                        var primaryC = $("#primaryColorValue").val();
                        $("#primaryColor").val(primaryC);
                        $("#selectPrimary").val(primaryC);
                    });

                $("#SecondaryColor").on('change',
                    function() {
                        currentPos = "";
                        var activeIndexPrimary = $('.formcolorPalette.active').index();
                        $(".formcolorPalette:eq(" + activeIndexPrimary + ")").find('input[type=\"color\"]:last').val($(this).val());
                        var secondaryC = $(this).val()
                        $("#secondaryColorValue").val(secondaryC);
                        $("#selectSecondary").val(secondaryC);
                        $('.secondaryColorValue').parent().parent().css("border", "2px solid #96949C");
                        $(".secondary-color-picker").parent().find(".invalid_err").remove();
                    });

                $("#secondaryColorValue").on('change keyup',
                    function() {
                        currentPos = "";
                        var activeIndexPrimary = $('.formcolorPalette.active').index();
                        $(".formcolorPalette:eq(" + activeIndexPrimary + ")").find('input[type=\"color\"]:last').val($(this).val());
                        var secondaryC = $("#secondaryColorValue").val();
                        $("#SecondaryColor").val(secondaryC);
                        $("#selectSecondary").val(secondaryC);
                    });

                $("#linkColor").on('change',
                    function() {
                        currentPos = "";
                        var activeIndexPrimary = $('.formcolorPalette.active').index();
                        $(".formcolorPalette:eq(" + activeIndexPrimary + ")").find('input[type=\"color\"]:eq(1)').val($(this).val());
                        var middleC = $(this).val()
                        $("#linkColorValue").val(middleC);
                        $("#selectThird").val(middleC);
                        $('.linkColorValue').parent().parent().css("border", "2px solid #96949C");
                        $(".link-color-picker").parent().find(".invalid_err").remove();
                    });

                $("#linkColorValue").on('change keyup',
                    function() {
                        currentPos = "";
                        var activeIndexPrimary = $('.formcolorPalette.active').index();
                        $(".formcolorPalette:eq(" + activeIndexPrimary + ")").find('input[type=\"color\"]:eq(1)').val($(this).val());
                        var middleC = $("#linkColorValue").val();
                        $("#linkColor").val(middleC);
                        $("#selectThird").val(middleC);
                    });

                $("#linkColorValue").on('change keyup',
                    function() {
                        currentPos = "";
                        var activeIndexPrimary = $('.formcolorPalette.active').index();
                        $(".formcolorPalette:eq(" + activeIndexPrimary + ")").find('input[type=\"color\"]:eq(1)').val($(this).val());
                        var middleC = $("#linkColorValue").val();
                        $("#linkColor").val(middleC);
                        $("#selectThird").val(middleC);
                    });

                $("#linkColorValue").on('change keyup',
                    function() {
                        currentPos = "";
                        var activeIndexPrimary = $('.formcolorPalette.active').index();
                        $(".formcolorPalette:eq(" + activeIndexPrimary + ")").find('input[type=\"color\"]:eq(1)').val($(this).val());
                        var middleC = $("#linkColorValue").val();
                        $("#linkColor").val(middleC);
                        $("#selectThird").val(middleC);
                    });

                // Qr style input  
                $("#diamond").click(function() {
                    $("#diamond").addClass('active');
                    $("#round").removeClass('active');
                    $("#extra_rounded").removeClass('active');
                    $("#classy_rounded").removeClass('active');
                    $("#square").removeClass('active');
                    $("#dot").removeClass('active');
                    $("#heart").removeClass('active');
                });
                $("#heart").click(function() {
                    $("#heart").addClass('active');
                    $("#round").removeClass('active');
                    $("#extra_rounded").removeClass('active');
                    $("#classy_rounded").removeClass('active');
                    $("#square").removeClass('active');
                    $("#dot").removeClass('active');
                    $("#diamond").removeClass('active');
                });
                $("#dot").click(function() {
                    $("#dot").addClass('active');
                    $("#round").removeClass('active');
                    $("#extra_rounded").removeClass('active');
                    $("#classy_rounded").removeClass('active');
                    $("#square").removeClass('active');
                    $("#heart").removeClass('active');
                    $("#diamond").removeClass('active');
                });
                $("#round").click(function() {
                    $("#round").addClass('active');
                    $("#dot").removeClass('active');
                    $("#extra_rounded").removeClass('active');
                    $("#classy_rounded").removeClass('active');
                    $("#square").removeClass('active');
                    $("#heart").removeClass('active');
                    $("#diamond").removeClass('active');
                });
                $("#square").click(function() {
                    $("#square").addClass('active');
                    $("#dot").removeClass('active');
                    $("#round").removeClass('active');
                    $("#extra_rounded").removeClass('active');
                    $("#classy_rounded").removeClass('active');
                    $("#heart").removeClass('active');
                    $("#diamond").removeClass('active');
                });
                $("#extra_rounded").click(function() {
                    $("#extra_rounded").addClass('active');
                    $("#dot").removeClass('active');
                    $("#round").removeClass('active');
                    $("#square").removeClass('active');
                    $("#classy_rounded").removeClass('active');
                    $("#heart").removeClass('active');
                    $("#diamond").removeClass('active');

                });
                $("#classy_rounded").click(function() {
                    $("#classy_rounded").addClass('active');
                    $("#dot").removeClass('active');
                    $("#round").removeClass('active');
                    $("#square").removeClass('active');
                    $("#extra_rounded").removeClass('active');
                    $("#heart").removeClass('active');
                    $("#diamond").removeClass('active');

                });
                //style input end
                // Dot frame click events
                $("#NS").click(function() {
                    $("#FR").removeClass('active');
                    $("#FS").removeClass('active');
                    $("#FF").removeClass('active');
                    $("#FRR").removeClass('active');
                    $("#FL").removeClass('active');
                    $("#NS").addClass('active');
                    // $("#eyeNS").click();
                });
                $("#FR").click(function() {
                    $("#NS").removeClass('active');
                    $("#FS").removeClass('active');
                    $("#FF").removeClass('active');
                    $("#FRR").removeClass('active');
                    $("#FL").removeClass('active');
                    $("#FR").addClass('active');
                    // $("#eyeFR").click();
                });
                $("#FS").click(function() {
                    $("#NS").removeClass('active');
                    $("#FR").removeClass('active');
                    $("#FF").removeClass('active');
                    $("#FRR").removeClass('active');
                    $("#FL").removeClass('active');

                    $("#FS").addClass('active');
                    // $("#eyeFS").click();
                });
                $("#FRR").click(function() {
                    $("#NS").removeClass('active');
                    $("#FR").removeClass('active');
                    $("#FS").removeClass('active');
                    $("#FF").removeClass('active');
                    $("#FL").removeClass('active');
                    $("#FRR").addClass('active');
                    // $("#eyeFRR").click();
                });
                $("#FF").click(function() {
                    $("#NS").removeClass('active');
                    $("#FR").removeClass('active');
                    $("#FS").removeClass('active');
                    $("#FRR").removeClass('active');
                    $("#FL").removeClass('active');
                    $("#FF").addClass('active');
                    // $("#eyeFF").click();
                });
                $("#FL").click(function() {
                    $("#NS").removeClass('active');
                    $("#FR").removeClass('active');
                    $("#FS").removeClass('active');
                    $("#FF").removeClass('active');
                    $("#FRR").removeClass('active');
                    $("#FL").addClass('active');
                    // $("#eyeFL").click();
                });
                // End dot frame
                // Dot style
                $("#IN").click(function() {
                    $("#IS").removeClass('active');
                    $("#ID").removeClass('active');
                    $("#IR").removeClass('active');
                    $("#IDD").removeClass('active');
                    $("#IF").removeClass('active');
                    $("#IL").removeClass('active');
                    $("#IN").addClass('active');
                    // $("#IIN").click();
                });
                $("#ID").click(function() {
                    $("#IN").removeClass('active');
                    $("#IS").removeClass('active');
                    $("#IR").removeClass('active');
                    $("#IDD").removeClass('active');
                    $("#IF").removeClass('active');
                    $("#IL").removeClass('active');
                    $("#ID").addClass('active');
                    // $("#IID").click();
                });
                $("#IS").click(function() {
                    $("#IN").removeClass('active');
                    $("#ID").removeClass('active');
                    $("#IR").removeClass('active');
                    $("#IDD").removeClass('active');
                    $("#IF").removeClass('active');
                    $("#IL").removeClass('active');
                    $("#IS").addClass('active');
                    // $("#IIS").click();
                });
                $("#IR").click(function() {
                    $("#IN").removeClass('active');
                    $("#IS").removeClass('active');
                    $("#ID").removeClass('active');
                    $("#IDD").removeClass('active');
                    $("#IF").removeClass('active');
                    $("#IL").removeClass('active');
                    $("#IR").addClass('active');
                    // $("#IIR").click();
                });
                $("#IDD").click(function() {
                    $("#IN").removeClass('active');
                    $("#IS").removeClass('active');
                    $("#ID").removeClass('active');
                    $("#IR").removeClass('active');
                    $("#IF").removeClass('active');
                    $("#IL").removeClass('active');
                    $("#IDD").addClass('active');
                    // $("#IIDD").click();
                });
                $("#IF").click(function() {
                    $("#IN").removeClass('active');
                    $("#IS").removeClass('active');
                    $("#ID").removeClass('active');
                    $("#IR").removeClass('active');
                    $("#IDD").removeClass('active');
                    $("#IL").removeClass('active');
                    $("#IF").addClass('active');
                    // $("#IIF").click();
                });
                $("#IL").click(function() {
                    $("#IN").removeClass('active');
                    $("#IS").removeClass('active');
                    $("#ID").removeClass('active');
                    $("#IR").removeClass('active');
                    $("#IDD").removeClass('active');
                    $("#IF").removeClass('active');
                    $("#IL").addClass('active');
                    // $("#IIL").click();
                });
                // End dot frame
                $("#direct_pdf").on("change", function() {
                    $("input[name=\"name\"]").keyup();
                })
                $(document).ready(function() {
                    code_style_color_change();
                });
                $(document).ready(function() {
                    $("#isGradientSelected").change(function() {
                        var selectedOption = $("#isGradientSelected").val()
                        if (selectedOption == 'gradient') {

                            $('#gradient').show();
                        } else {
                            $('#gradient').hide();
                        }
                    });
                });
                $(document).ready(function() {
                    $("#isFrameGradientSelected").change(function() {
                        var selectedOption = $("#isFrameGradientSelected").val()
                        if (selectedOption == 'gradient') {

                            $('#frame_gradient').show();
                        } else {
                            $('#frame_gradient').hide();
                        }
                    });
                });
                $(document).ready(function() {
                    $("#isBackgroundGradientSelected").change(function() {
                        var selectedOption = $("#isBackgroundGradientSelected").val()
                        if (selectedOption == 'gradient') {

                            $('#background_gradient').show();
                        } else {
                            $('#background_gradient').hide();
                        }
                    });
                });
                $(document).ready(function() {
                    $("#isGradientSelected").change(function() {
                        var selectedOption = $("#isGradientSelected").val()
                        if (selectedOption == 'gradient') {

                            $('#gradient').show();
                        } else {
                            $('#gradient').hide();
                        }
                    });
                });
                $(document).ready(function() {
                    $("#isFrameGradientSelected").change(function() {
                        var selectedOption = $("#isFrameGradientSelected").val()
                        if (selectedOption == 'gradient') {

                            $('#frame_gradient').show();
                        } else {
                            $('#frame_gradient').hide();
                        }
                    });
                });
                $(document).ready(function() {
                    $("#isBackgroundGradientSelected").change(function() {
                        var selectedOption = $("#isBackgroundGradientSelected").val()
                        if (selectedOption == 'gradient') {

                            $('#background_gradient').show();
                        } else {
                            $('#background_gradient').hide();
                        }
                    });
                });
                $(document).ready(function() {

                    var isFrameGradient = $("#isFrameGradient");
                    if (isFrameGradient.prop("checked")) {
                        $('.frame-border-colour-container').show();
                        $('.frame-grad-dropdown').show();
                        $('.single-frame-color-wrp').hide();
                    } else {
                        $('.frame-border-colour-container').hide();
                        $('.frame-grad-dropdown').hide();
                        $('.single-frame-color-wrp').show();
                    }



                    $('#isFrameGradient').change(function() {
                        if ($(this).is(":checked")) {
                            $('.frame-border-colour-container').show();
                            $('.frame-grad-dropdown').show();
                            $('.single-frame-color-wrp').hide();
                        } else {
                            $('.frame-border-colour-container').hide();
                            $('.frame-grad-dropdown').hide();
                            $('.single-frame-color-wrp').show();
                        }

                    });


                    var isFrameBackgroundGradient = $("#isFrameBackgroundGradient");
                    if (isFrameBackgroundGradient.prop("checked")) {
                        $('.frame-backgound-colour-container').show();
                        $('.single-frame-bg-color-wrp').hide();
                        $('.frame-bggrad-dropdown').show();
                        // $('.frame-background-color-transparency').hide();
                    } else {
                        $('.single-frame-bg-color-wrp').show();
                        $('.frame-bggrad-dropdown').hide();
                        $('.frame-backgound-colour-container').hide();
                        // $('.frame-background-color-transparency').show();
                    }


                    $('#isFrameBackgroundGradient').change(function() {
                        if ($(this).is(":checked")) {
                            $('.frame-backgound-colour-container').show();
                            $('.single-frame-bg-color-wrp').hide();
                            $('.frame-bggrad-dropdown').show();
                            // $('.frame-background-color-transparency').hide();

                        } else {
                            $('.frame-backgound-colour-container').hide();
                            $('.single-frame-bg-color-wrp').show();
                            $('.frame-bggrad-dropdown').hide();
                            // $('.frame-background-color-transparency').show();

                        }
                    });

                    $('#frame_is_transparent').change(function() {
                        if ($(this).is(":checked")) {
                            $('#isFrameBackgroundGradient').prop('checked', false);
                            $('.frame-backgound-colour-container').hide();
                            $('.single-frame-bg-color-wrp').show();
                            $('.frame-bggrad-dropdown').hide();
                            $('.frame-background-color .single-frame-bg-color-wrp').addClass('disabled');
                            $('#isFrameBackgroundGradient').attr("disabled", true);
                            $('#isFrameBackgroundGradient').prev('.custom-switch-text').css('color', '#b6b6b6');
                            console.log();
                        } else {
                            $('.frame-background-color .single-frame-bg-color-wrp').removeClass('disabled');
                            $('#isFrameBackgroundGradient').attr("disabled", false);
                            $('#isFrameBackgroundGradient').prev('.custom-switch-text').css('color', '#111827');

                        }
                    });
                    $('#is_transparent').change(function() {
                        if ($(this).is(":checked")) {
                            $('#background_colour_gradient').prop('checked', false);
                            $('#background_colour_gradient').prev('.custom-switch-text').css('color', '#b6b6b6');
                            $('.backgound-colour-container').hide();
                            $('.pattern-bg-single-color').show();
                            $('.pattern-bg-grad-dropdown').hide();
                            $('.pattern-bg-color-wrap .pattern-bg-single-color').addClass('disabled');
                            $('#background_colour_gradient').attr("disabled", true);
                        } else {
                            $('.pattern-bg-color-wrap .pattern-bg-single-color').removeClass('disabled');
                            $('#background_colour_gradient').attr("disabled", false);
                            $('#background_colour_gradient').prev('.custom-switch-text').css('color', '#111827');

                        }
                    });

                    var isBorderGradient = $("#isBorderGradient");
                    if (isBorderGradient.prop("checked")) {
                        $('.border-colour-container').show();
                        $('.pattern-grad-dropdown').show();
                        $('.pattern-grad-switch').hide();

                        code_style_color_change();
                    } else {
                        $('.border-colour-container').hide();
                        $('.border-color').show();

                        code_style_color_change();
                    }

                    $('#isBorderGradient').change(function() {
                        if ($(this).is(":checked")) {
                            $('.pattern-grad-dropdown').show();
                            $('.border-colour-container').show();
                            $('.pattern-grad-switch').hide();

                            code_style_color_change();
                        } else {
                            $('.pattern-grad-dropdown').hide();
                            $('.border-colour-container').hide();
                            $('.pattern-grad-switch').show();

                            code_style_color_change();
                        }

                    });

                    var background_colour_gradient = $("#background_colour_gradient");
                    if (background_colour_gradient.prop("checked")) {
                        $('.backgound-colour-container').show();
                        $('.pattern-bg-single-color').hide();
                        $('.pattern-bg-grad-dropdown').show();
                        // $('.background-color-transparency').hide();

                        code_style_color_change();
                    } else {
                        $('.backgound-colour-container').hide();
                        $('.pattern-bg-single-color').show();
                        $('.pattern-bg-grad-dropdown').hide();
                        // $('.background-color-transparency').show();

                        code_style_color_change();
                    }

                    $('#background_colour_gradient').change(function() {
                        if ($(this).is(":checked")) {
                            $('.backgound-colour-container').show();
                            $('.pattern-bg-single-color').hide();
                            $('.pattern-bg-grad-dropdown').show();
                            // $('.background-color-transparency').hide();

                            code_style_color_change();

                        } else {
                            $('.backgound-colour-container').hide();
                            $('.pattern-bg-single-color').show();
                            $('.pattern-bg-grad-dropdown').hide();
                            // $('.background-color-transparency').show();

                            code_style_color_change();
                        }
                    });

                    // $("").click(function() {
                        $('.pattern-bg-changer-wrp').on('mousedown', '#swapPrimaryColor', function() {
                        let forgroundColor = $("#ForgroundColor").val();
                        let backGroundColor = $("#BackgroundColor").val();
                        $("#BackgroundColor").val(forgroundColor);
                        $("#BackgroundColor").css('background-color', forgroundColor);
                        $(".BackgroundColorInput").val(forgroundColor);
                        $(".ForgroundColorInput").val(backGroundColor);
                        $("#ForgroundColor").val(backGroundColor);
                        $("#ForgroundColor").css('background-color', backGroundColor);
                        let forgroundColorFirst = $("#ForgroundColorFirst").val();
                        let forgroundColorSecond = $("#ForgroundColorSecond").val();
                        let backgroundColorFirst = $("#BackgroundColorFirst").val();
                        let backgroundColorSecond = $("#BackgroundColorSecond").val();
                        $("#BackgroundColorFirst").val(forgroundColorFirst);
                        $("#BackgroundColorFirst").css('background-color', forgroundColorFirst);
                        $(".BackgroundColorFirstInput").val(forgroundColorFirst);
                        $("#BackgroundColorSecond").val(forgroundColorSecond);
                        $("#BackgroundColorSecond").css('background-color', forgroundColorSecond);
                        $(".BackgroundColorSecondInput").val(forgroundColorSecond);
                        $("#ForgroundColorFirst").val(backgroundColorFirst);
                        $("#ForgroundColorFirst").css('background-color', backgroundColorFirst);
                        $(".ForgroundColorFirstInput").val(backgroundColorFirst);
                        $("#ForgroundColorSecond").val(backgroundColorSecond);
                        $("#ForgroundColorSecond").css('background-color', backgroundColorSecond);
                        $(".ForgroundColorSecondInput").val(backgroundColorSecond);


                        var spanfg1 = $('.label-fg1 span');
                        var spanfg2 = $('.label-fg2 span');

                        var spanbg1 = $('.label-bg1 span');
                        var spanbg2 = $('.label-bg2 span');

                        spanfg1.detach().appendTo($('.label-bg1'));
                        spanfg2.detach().appendTo($('.label-bg2'));
                        spanbg1.detach().appendTo($('.label-fg1'));
                        spanbg2.detach().appendTo($('.label-fg2'));

                        var span1 = $('.label-fgc span');
                        var span2 = $('.label-bgc span');
                        span1.detach().appendTo($('.label-bgc'));
                        span2.detach().appendTo($('.label-fgc'));

                        code_style_color_change();


                    });
                });
                $("#isBorderGradient").on('change', function() {
                    if ($("#isBorderGradient").is(':checked') && $("#background_colour_gradient").is(':checked'))
                        $('#swapPrimaryColor').prop('disabled', false);
                    else if ($("#isBorderGradient").is(':checked') || $("#background_colour_gradient").is(':checked')) {
                        $('#swapPrimaryColor').prop('disabled', true);
                    } else {
                        $('#swapPrimaryColor').prop('disabled', false);
                    }
                });
                $("#background_colour_gradient").on('change', function() {
                    if ($("#isBorderGradient").is(':checked') && $("#background_colour_gradient").is(':checked'))
                        $('#swapPrimaryColor').prop('disabled', false);
                    else if ($("#isBorderGradient").is(':checked') || $("#background_colour_gradient").is(':checked')) {
                        $('#swapPrimaryColor').prop('disabled', true);
                    } else {
                        $('#swapPrimaryColor').prop('disabled', false);
                    }
                });
                $("#passwordField").hide();
                $("#changeForgroundColor").click(
                    function() {
                        var one = $("#ForgroundColorFirst").val()
                        var second = $("#ForgroundColorSecond").val()
                        $("#ForgroundColorFirst").val(second)
                        $("#ForgroundColorSecond").val(one)
                    });
                $("#changeFrameColor").click(
                    function() {
                        var one = $("#FrameColorFirst").val()
                        var second = $("#FrameColorSecond").val()
                        $("#FrameColorFirst").val(second)
                        $("#FrameColorSecond").val(one)
                    });

                // qr_frame_id_1
                for (let index = 0; index < 33; index++) {
                    $("#qr_frame_id_" + index).click(
                        function() {
                            $("#qr_frame_id_" + index).addClass("active");
                            for (let i = 0; i < 33; i++) {
                                if (i != index) {
                                    $("#qr_frame_id_" + i).removeClass("active");
                                }

                            }
                        });
                    $("#qr_frame_enabled").click();
                }
                $("#changeForgroundColor").click(
                    function() {
                        var one = $("#ForgroundColorFirst").val()
                        var second = $("#ForgroundColorSecond").val()
                        $("#ForgroundColorFirst").val(second)
                        $("#ForgroundColorSecond").val(one)
                    });

                $("#ForgroundColor").change(function() {
                    let selectedOption = $("#ForgroundColor").val()
                    $("#ForgroundColorInput").val(selectedOption);

                    code_style_color_change();
                });

                $("#ForgroundColorInput").on('change keyup',
                    function() {
                        let selectedOption = $("#ForgroundColorInput").val();
                        $("#ForgroundColor").val(selectedOption);

                        code_style_color_change();
                    });

                $("#BackgroundColor").change(function() {
                    let selectedOption = $("#BackgroundColor").val();
                    $("#BackgroundColorInput").val(selectedOption);

                    code_style_color_change();
                });

                $("#BackgroundColorInput").on('change keyup',
                    function() {
                        let selectedOption = $("#BackgroundColorInput").val();
                        $("#BackgroundColor").val(selectedOption);

                        code_style_color_change();
                    });

                $("#ForgroundColorFirst").change(function() {
                    var selectedOption = $("#ForgroundColorFirst").val();
                    $("#ForgroundColorFirstInput").val(selectedOption);

                    code_style_color_change();
                });

                $("#ForgroundColorFirstInput").on('change keyup',
                    function() {
                        let selectedOption = $("#ForgroundColorFirstInput").val();
                        $("#ForgroundColorFirst").val(selectedOption);

                        code_style_color_change();
                    });

                $("#ForgroundColorSecond").change(function() {
                    var selectedOption = $("#ForgroundColorSecond").val();
                    $("#ForgroundColorSecondInput").val(selectedOption);

                    code_style_color_change();
                });

                $("#ForgroundColorSecondInput").on('change keyup',
                    function() {
                        let selectedOption = $("#ForgroundColorSecondInput").val();
                        $("#ForgroundColorSecond").val(selectedOption);

                        code_style_color_change();
                    });


                $("#changeFrameColor").click(
                    function() {
                        var one = $("#FrameColorFirst").val()
                        var second = $("#FrameColorSecond").val()
                        $("#FrameColorFirst").val(second)
                        $("#FrameColorSecond").val(one)
                    });

                $("#FrameColor").change(function() {
                    let selectedOption = $("#FrameColor").val()
                    $("#FrameColorInput").val(selectedOption);
                });

                $("#FrameColorInput").on('change keyup',
                    function() {
                        let selectedOption = $("#FrameColorInput").val();
                        $("#FrameColor").val(selectedOption);
                    });

                $("#frameTextColor").on('input',
                    function() {
                        let selectedOption = $("#frameTextColor").val();
                        $("#frameTextColor").val(selectedOption);
                    });

                $("#FrameColorFirst").change(function() {
                    var selectedOption = $("#FrameColorFirst").val()
                    $("#FrameColorFirstInput").val(selectedOption);
                });

                $("#FrameColorFirstInput").on('change keyup',
                    function() {
                        let selectedOption = $("#FrameColorFirstInput").val();
                        $("#FrameColorFirst").val(selectedOption);
                    });

                $("#FrameColorSecond").change(function() {
                    var selectedOption = $("#FrameColorSecond").val()
                    $("#FrameColorSecondInput").val(selectedOption);
                });

                $("#FrameColorSecondInput").on('change keyup',
                    function() {
                        let selectedOption = $("#FrameColorSecondInput").val();
                        $("#FrameColorSecond").val(selectedOption);
                    });

                $("#changeFrameBackgroundColor").click(
                    function() {
                        var one = $("#FrameBackgroundColorFirst").val()
                        var second = $("#FrameBackgroundColorSecond").val()
                        $("#FrameBackgroundColorFirst").val(second)
                        $("#FrameBackgroundColorSecond").val(one)
                    });

                $("#FrameBackgroundColor").change(function() {
                    let selectedOption = $("#FrameBackgroundColor").val()
                    $("#FrameBackgroundColorInput").val(selectedOption);
                });

                $("#FrameBackgroundColorInput").on('change keyup',
                    function() {
                        let selectedOption = $("#FrameBackgroundColorInput").val();
                        $("#FrameBackgroundColor").val(selectedOption);
                    });

                $("#BackgroundColor").change(function() {
                    let selectedOption = $("#BackgroundColor").val()
                    $("#BackgroundColorSpan").html(selectedOption);
                });

                $("#FrameBackgroundColorFirst").change(function() {
                    var selectedOption = $("#FrameBackgroundColorFirst").val()
                    $("#FrameBackgroundColorFirstInput").val(selectedOption);
                });

                $("#FrameBackgroundColorFirstInput").on('change keyup',
                    function() {
                        let selectedOption = $("#FrameBackgroundColorFirstInput").val();
                        $("#FrameBackgroundColorFirst").val(selectedOption);
                    });

                $("#FrameBackgroundColorSecond").change(function() {
                    var selectedOption = $("#FrameBackgroundColorSecond").val()
                    $("#FrameBackgroundColorSecondInput").val(selectedOption);
                });

                $("#FrameBackgroundColorSecondInput").on('change keyup',
                    function() {
                        let selectedOption = $("#FrameBackgroundColorSecondInput").val();
                        $("#FrameBackgroundColorSecond").val(selectedOption);
                    });


                $("#BackgroundColorFirst").change(function() {
                    var selectedOption = $("#BackgroundColorFirst").val();
                    $("#BackgroundColorFirstInput").val(selectedOption);

                    code_style_color_change();
                });

                $("#BackgroundColorFirstInput").on('change keyup',
                    function() {
                        let selectedOption = $("#BackgroundColorFirstInput").val();
                        $("#BackgroundColorFirst").val(selectedOption);

                        code_style_color_change();
                    });

                $("#BackgroundColorSecond").change(function() {
                    var selectedOption = $("#BackgroundColorSecond").val()
                    $("#BackgroundColorSecondInput").val(selectedOption);

                    code_style_color_change();
                });

                $("#BackgroundColorSecondInput").on('change keyup',
                    function() {
                        let selectedOption = $("#BackgroundColorSecondInput").val();
                        $("#BackgroundColorSecond").val(selectedOption);

                        code_style_color_change();
                    });

                // EIColorSpan

                $("#EIColor").change(function() {
                    let selectedOption = $("#EIColor").val()
                    $("#EIColorInput").val(selectedOption)

                    code_corners_color_change();
                });

                $("#EIColorInput").on('change keyup',
                    function() {
                        let selectedOption = $("#EIColorInput").val();
                        $("#EIColor").val(selectedOption);

                        code_corners_color_change();
                    });

                $("#EOColor").change(function() {
                    let selectedOption = $("#EOColor").val()
                    $("#EOColorInput").val(selectedOption);

                    code_corners_color_change();
                });

                $("#EOColorInput").on('change keyup',
                    function() {
                        let selectedOption = $("#EOColorInput").val();
                        $("#EOColor").val(selectedOption);

                        code_corners_color_change();
                    });

                //developed by XL Developer 16-01-2023

                $("textarea[name=\"terms\"]").on("keypress", function(e) {
                    text_counter(e, this, 4000);
                });
                $("textarea[name=\"terms\"]").on("paste", function(e) {
                    text_counter(e, this, 4000);
                });
                $("textarea[name=\"terms\"]").on("change", function(e) {
                    text_counter(e, this, 4000);
                });

                $(document).on('keyup', '#terms', function() {

                    var characterCount = $(this).val().length,
                        current = $('#current'),
                        maximum = $('#maximum'),
                        theCount = $('#theCount');

                    current.text(characterCount);

                    if (characterCount < 1000) {
                        current.css('color', '#666');
                    }
                    if (characterCount > 1000 && characterCount < 2000) {
                        current.css('color', '#6d5555');
                    }
                    if (characterCount > 2000 && characterCount < 3000) {
                        current.css('color', '#793535');
                    }
                    if (characterCount > 3000 && characterCount < 4000) {
                        current.css('color', '#841c1c');
                    }

                    if (characterCount >= 4000) {
                        maximum.css('color', '#8f0001');
                        current.css('color', '#8f0001');
                        theCount.css('font-weight', 'bold');
                    } else {
                        maximum.css('color', '#666');
                        theCount.css('font-weight', 'normal');
                    }


                });

                //prevent default submit on step 2 if data is not valid and required data not filled-up
                $('input').keydown(function(e) {
                    if (e.keyCode == 13) {
                        let allAreFilled1 = validation_form();
                        if (!allAreFilled1) {
                            e.preventDefault();
                            return false;
                        } else {
                            if (parseInt(step_new) == 1) {
                                change_step(2);
                                e.preventDefault();
                                return false;
                            } else if (parseInt(step_new) == 2) {
                                change_step(3)
                                e.preventDefault();
                                return false;
                            }
                        }
                    }
                });

                //prevent page redirect on keypress
                $('input').keypress(function(e) {
                    if (event.keyCode == 13) {
                        event.preventDefault();
                    }
                })

                $("input[type=\"number\"]").on("onkeypress", function(e) {
                    validate_number(e)
                })

                validateStepTwo();

                function validateStepTwo() {
                    var step = $("input[name=\"step_input\"]").val();
                    var qrType_inn = $("input[name=\"type\"]").val();
                    var custom_type = $("input[name=\"qrtype_input\"]").val();
                    var is_video = $("input[name=\"is_video\"]").val();
                    var is_image = $("input[name=\"is_image\"]").val();
                    var is_pdf = $("input[name=\"is_pdf\"]").val();
                    var is_mp3 = $("input[name=\"is_mp3\"]").val();
                    // || (qrType_inn.trim() != 'mp3') || (qrType_inn.trim() != 'pdf')
                    if ($("#2").hasClass("disable-btn")) {
                        if (qrType_inn && qrType_inn.trim() === 'image') {}
                    } else {
                        if ((qrType_inn.trim() == 'image')) {
                            $("#2").addClass("disable-btn");
                        }

                    }
                    if (step == 2) {
                        let allAreFilled = true;

                        document.addEventListener("DOMContentLoaded", function() {
                            var myForm = document.getElementById("myform");
                            if (myForm) {
                                myForm.querySelectorAll("[input_validate]").forEach(function(i) {
                                    if (allAreFilled == false) return;

                                    if (i.type === "radio") {
                                        let radioValueCheck = false;
                                        document.getElementById("myform").querySelectorAll(`[name=${i.name}]`).forEach(function(r) {
                                            if (r.checked) radioValueCheck = true;
                                        })
                                        allAreFilled = radioValueCheck;
                                        return;
                                    }
                                    if (!i.value) {
                                        allAreFilled = false;
                                        return;
                                    }
                                });
                            }
                        });


                        if (type == "url") {
                            var url = document.getElementById('url');
                            var isValidUrl = /^(https?:\/\/)?(www\.)?([A-Za-z0-9\-]+\.)+[A-Za-z]{2,}(:[0-9]+)?(\/.*)?$/i.test(url?.value);

                            // Check if the URL is empty or not valid
                            if (url?.value == '' || !isValidUrl) {
                                allAreFilled = false;
                            }
                        } else if (type == "wifi") {
                            var ssid = document.getElementById('wifi_ssid');
                            if (ssid?.value == '') {
                                allAreFilled = false;
                            }
                        } else if (type == 'menu') {
                            var sectionId = document.getElementById('sectionNames');
                            var productNames = $('input[name="productNames_1[]"]').val();
                            if (sectionId?.value == '' || productNames == '') {
                                allAreFilled = false;
                            }
                        } else if (type == 'business') {
                            var company = $('input[name="company"]').val();
                            if (company == '') {
                                allAreFilled = false;
                            }
                        } else if (type == 'vcard') {
                            var firstName = document.getElementById('vcard_first_name');
                            if (firstName?.value == '') {
                                allAreFilled = false;
                            }
                        } else if (type == 'links') {
                            var listTitle = document.getElementById('list_title');

                            if (listTitle?.value == '') {
                                allAreFilled = false;
                            }
                        } else if (type == 'coupon') {
                            var couponCode = document.getElementById('couponCode');
                            var couponCodeImg = document.getElementById('offerImg');
                            if (couponCode?.value == '' && couponCodeImg?.value == '') {
                                allAreFilled = false;
                            }
                        }

                        if (qrType_inn && qrType_inn.trim() === 'video' && parseInt(is_video) == 0) {
                            allAreFilled = false;
                        }
                        if (custom_type.trim() == 'images' && parseInt(is_image) == 0) {
                            allAreFilled = false;
                        }
                        if (custom_type.trim() == 'mp3' || custom_type.trim() == 'pdf') {
                            allAreFilled = false;
                        }



                        if (qrType_inn && qrType_inn.trim() == 'app') {
                            var google = $("input[name=\"google\"]").val();
                            var apple = $("input[name=\"apple\"]").val();
                            var amazon = $("input[name=\"amazon\"]").val();

                            if ((google.trim() == "" || google.trim() == null || google.trim() == undefined) && (apple.trim() == "" || apple.trim() == null || apple.trim() == undefined) && (amazon.trim() == "" || amazon.trim() == null || amazon.trim() == undefined)) {
                                allAreFilled = false;
                            }
                        }


                        if (!allAreFilled) {
                            $("#validate_value_ajax").val(0)
                            if (qrType_inn?.trim() != 'images') {
                                $("#2").addClass('disable-btn');
                                $("#2").attr('disabled', true);
                            }

                            $("#2").removeAttr('onclick');
                            $("#2m").attr('disabled', true);
                            $("#2m").addClass('disable-btn')
                            $("#2m").removeAttr('onclick');
                        } else {
                            $("#validate_value_ajax").val(0)
                            if (qrType_inn && qrType_inn.trim() != 'images') {
                                $("#2").attr('disabled', false);
                                $("#2").removeClass("disable-btn");
                                $("#2").removeClass("no-files");

                            }

                            $("#2").attr('onclick', 'save_qr_fn()');
                            $("#2m").attr('disabled', false);
                            $("#2m").removeClass("disable-btn");
                            $("#2m").attr('onclick', 'save_qr_fn()');

                        }
                    }
                }

                $("input, textarea").on("change paste keyup", function(event) {

                    var step = $("input[name=\"step_input\"]").val();
                    var qrType_inn = $("input[name=\"type\"]").val();
                    var custom_type = $("input[name=\"qrtype_input\"]").val();
                    var is_video = $("input[name=\"is_video\"]").val();
                    var is_image = $("input[name=\"is_image\"]").val();
                    var is_pdf = $("input[name=\"is_pdf\"]").val();
                    var is_mp3 = $("input[name=\"is_mp3\"]").val();
                    // || (qrType_inn.trim() != 'mp3') || (qrType_inn.trim() != 'pdf')
                    if ($("#2").hasClass("disable-btn")) {
                        if (qrType_inn && qrType_inn.trim() === 'image') {}
                    } else {
                        if ((qrType_inn.trim() == 'image')) {
                            $("#2").addClass("disable-btn");
                        }

                    }

                    if (step == 2) {
                        let allAreFilled = true;

                        document.addEventListener("DOMContentLoaded", function() {
                            var myForm = document.getElementById("myform");
                            if (myForm) {
                                myForm.querySelectorAll("[input_validate]").forEach(function(i) {
                                    if (allAreFilled == false) return;

                                    if (i.type === "radio") {
                                        let radioValueCheck = false;
                                        document.getElementById("myform").querySelectorAll(`[name=${i.name}]`).forEach(function(r) {
                                            if (r.checked) radioValueCheck = true;
                                        })
                                        allAreFilled = radioValueCheck;
                                        return;
                                    }
                                    if (!i.value) {
                                        allAreFilled = false;
                                        return;
                                    }
                                });
                            }
                        });


                        if (type == "url") {
                            var url = document.getElementById('url');
                            var isValidUrl = /^(https?:\/\/)?(www\.)?([A-Za-z0-9\-]+\.)+[A-Za-z]{2,}(:[0-9]+)?(\/.*)?$/i.test(url?.value);

                            // Check if the URL is empty or not valid
                            if (url?.value == '' || !isValidUrl) {
                                allAreFilled = false;
                            }
                        } else if (type == "wifi") {
                            var ssid = document.getElementById('wifi_ssid');
                            if (ssid?.value == '') {
                                allAreFilled = false;
                            }
                        } else if (type == 'menu') {
                            var sectionId = document.getElementById('sectionNames');
                            var productNames = $('input[name="productNames_1[]"]').val();
                            if (sectionId?.value == '' || productNames == '') {
                                allAreFilled = false;
                            }
                        } else if (type == 'business') {
                            var company = $('input[name="company"]').val();
                            if (company == '') {
                                allAreFilled = false;
                            }
                        } else if (type == 'vcard') {
                            var firstName = document.getElementById('vcard_first_name');
                            if (firstName?.value == '') {
                                allAreFilled = false;
                            }
                        } else if (type == 'links') {
                            var listTitle = document.getElementById('list_title');

                            if (listTitle?.value == '') {
                                allAreFilled = false;
                            }
                        } else if (type == 'coupon') {
                            var couponCode = document.getElementById('couponCode');
                            var couponCodeImg = document.getElementById('offerImg');
                            if (couponCode?.value == '' && couponCodeImg?.value == '') {
                                allAreFilled = false;
                            }
                        }

                        if (qrType_inn && qrType_inn.trim() === 'video' && parseInt(is_video) == 0) {
                            allAreFilled = false;
                        }
                        if (custom_type.trim() == 'images' && parseInt(is_image) == 0) {
                            allAreFilled = false;
                        }
                        if (custom_type.trim() == 'mp3' && parseInt(is_mp3) == 0) {
                            allAreFilled = false;
                        }
                        if (custom_type.trim() == 'pdf') {
                            var pdfUrl = $('#pdfFile').val();
                            if (pdfUrl == '') {
                                allAreFilled = false;
                            }
                        }



                        if (qrType_inn && qrType_inn.trim() == 'app') {
                            var google = $("input[name=\"google\"]").val();
                            var apple = $("input[name=\"apple\"]").val();
                            var amazon = $("input[name=\"amazon\"]").val();

                            if ((google.trim() == "" || google.trim() == null || google.trim() == undefined) && (apple.trim() == "" || apple.trim() == null || apple.trim() == undefined) && (amazon.trim() == "" || amazon.trim() == null || amazon.trim() == undefined)) {
                                allAreFilled = false;
                            }

                            if (app_title != '' && (google != '' || apple != '' || amazon != '')) {
                                $("#2").attr('disabled', false);
                                $("#2").removeClass("disable-btn");
                                console.log("# true");
                            } else {
                                $("#2").attr('disabled', true);
                                $("#2").addClass("disable-btn");
                                console.log("# false");
                            }
                        }


                        if (!allAreFilled) {
                            $("#validate_value_ajax").val(0)
                            if (qrType_inn?.trim() != 'images') {
                                $("#2").addClass('disable-btn');
                                $("#2").attr('disabled', true);
                            }

                            $("#2").removeAttr('onclick');
                            $("#2m").attr('disabled', true);
                            $("#2m").addClass('disable-btn')
                            $("#2m").removeAttr('onclick');
                        } else {
                            $("#validate_value_ajax").val(0)
                            if (qrType_inn && (qrType_inn.trim() != 'image' && qrType_inn.trim() != 'pdf')) {
                                $("#2").attr('disabled', false);
                                $("#2").removeClass("disable-btn");

                            }

                            $("#2").attr('onclick', 'save_qr_fn()');
                            $("#2m").attr('disabled', false);
                            $("#2m").removeClass("disable-btn");
                            $("#2m").attr('onclick', 'save_qr_fn()');

                        }
                    }

                    var validation_fire = $('#validation_fire').val();
                    if (validation_fire == 1) {
                        validation_form(0)
                    }
                });

                for (let index = 1; index < 8; index++) {
                    $("#formcolorPalette" + index).click(
                        function() {
                            $("#formcolorPalette" + index).addClass("active");
                            for (let i = 1; i < 33; i++) {
                                if (i != index) {
                                    $("#formcolorPalette" + i).removeClass("active");
                                }

                            }
                        });
                }

                //code from js_qr_code.php

                /* Vcard Social Script */
                'use strict';

                /* add new */
                let vcard_social_add = event => {
                    let clone = document.querySelector(`#template_vcard_social`).content.cloneNode(true);
                    let count = document.querySelectorAll(`[id="vcard_socials"] .mb-4`).length;

                    if (count >= 20) return;

                    clone.querySelector(`input[name="vcard_social_label[]"`).setAttribute('name', `vcard_social_label[${count}]`);
                    clone.querySelector(`input[name="vcard_social_value[]"`).setAttribute('name', `vcard_social_value[${count}]`);

                    document.querySelector(`[id="vcard_socials"]`).appendChild(clone);

                    vcard_social_remove_initiator();

                    apply_reload_qr_code_event_listeners();
                };

                document.querySelectorAll('[data-add="vcard_social"]').forEach(element => {
                    element.addEventListener('click', vcard_social_add);
                })

                /* remove */
                let vcard_social_remove = event => {
                    event.currentTarget.closest('.mb-4').remove();
                };

                let vcard_social_remove_initiator = () => {
                    document.querySelectorAll('[id^="vcard_socials_"] [data-remove]').forEach(element => {
                        element.removeEventListener('click', vcard_social_remove);
                        element.addEventListener('click', vcard_social_remove)
                    })
                };

                vcard_social_remove_initiator();
                /* Vcard Social Script over*/

                /* Vcard Phone Numbers */
                'use strict';

                /* add new */
                let vcard_phone_number_add = event => {
                    let clone = document.querySelector(`#template_vcard_phone_number`).content.cloneNode(true);
                    let count = document.querySelectorAll(`[id="vcard_phone_numbers"] .mb-4`).length;

                    if (count >= 20) return;

                    clone.querySelector(`input[name="vcard_phone_number[]"`).setAttribute('name', `vcard_phone_number[${count}]`);

                    document.querySelector(`[id="vcard_phone_numbers"]`).appendChild(clone);

                    vcard_phone_number_remove_initiator();

                    apply_reload_qr_code_event_listeners();
                };

                document.querySelectorAll('[data-add="vcard_phone_number"]').forEach(element => {
                    element.addEventListener('click', vcard_phone_number_add);
                })

                /* remove */
                let vcard_phone_number_remove = event => {
                    event.currentTarget.closest('.mb-4').remove();
                };

                let vcard_phone_number_remove_initiator = () => {
                    document.querySelectorAll('[id^="vcard_phone_numbers_"] [data-remove]').forEach(element => {
                        element.removeEventListener('click', vcard_phone_number_remove);
                        element.addEventListener('click', vcard_phone_number_remove)
                    })
                };

                vcard_phone_number_remove_initiator();
                /* Vcard Phone Numbers */


                $('.video_file').on('change', function() {
                    reload_qr_code_event_listener();
                })


                //-----------HANDLER---------//

                'use strict';
                /* Type handler */
                let type_handler = (selector, data_key) => {
                    if (!document.querySelector(selector)) {
                        return;
                    }

                    let type = null;
                    if (document.querySelector(selector).type == 'radio') {
                        type = document.querySelector(`${selector}:checked`) ? document.querySelector(`${selector}:checked`).value : null;
                    } else {
                        type = document.querySelector(selector).value;
                    }

                    document.querySelectorAll(`[${data_key}]:not([${data_key}="${type}"])`).forEach(element => {
                        element.classList.add('d-none');
                        let input = element.querySelector('input,select,textarea');

                        if (input) {
                            if (input.getAttribute('required')) {
                                input.setAttribute('data-is-required', 'true');
                            }

                            input.setAttribute('disabled', 'disabled');
                            input.removeAttribute('required');
                        }
                    });

                    document.querySelectorAll(`[${data_key}="${type}"]`).forEach(element => {
                        element.classList.remove('d-none');
                        let input = element.querySelector('input,select,textarea');

                        if (input) {
                            input.removeAttribute('disabled');
                            if (input.getAttribute('data-is-required')) {
                                input.setAttribute('required', 'required')
                            }
                        }
                    });
                }

                type_handler('select[name="type"]', 'data-type');
                document.querySelector('select[name="type"]') && document.querySelector('select[name="type"]').addEventListener('change', () => {
                    type_handler('select[name="type"]', 'data-type');
                    url_dynamic_handler()
                });

                type_handler('[name="foreground_type"]', 'data-foreground-type');
                document.querySelector('[name="foreground_type"]') && document.querySelectorAll('[name="foreground_type"]').forEach(element => {
                    element.addEventListener('change', () => {
                        type_handler('[name="foreground_type"]', 'data-foreground-type')
                    });
                })

                type_handler('select[name="custom_eyes_color"]', 'data-custom-eyes-color');
                document.querySelector('select[name="custom_eyes_color"]') && document.querySelector('select[name="custom_eyes_color"]').addEventListener('change', () => {
                    type_handler('select[name="custom_eyes_color"]', 'data-custom-eyes-color')
                });

                /* Url Dynamic handler */
                let url_dynamic_handler = () => {
                    if (document.querySelector('select[name="type"]')) {
                        let type = document.querySelector('select[name="type"]').value;

                        if (type != 'url') {
                            return;
                        }
                    }

                    if (!document.querySelector('#url')) {
                        return;
                    }

                    let url_dynamic = document.querySelector('#url_dynamic').checked;


                    if (url_dynamic) {
                        document.querySelector('#url').removeAttribute('required');
                        document.querySelector('[data-url]').classList.add('d-none');
                        if (document.querySelector('#link_id')) {
                            document.querySelector('#link_id').setAttribute('required', 'required');
                            let link_id_element = document.querySelector('#link_id');
                            if (link_id_element.options.length) {
                                document.querySelector('#url').value = link_id_element.options[link_id_element.selectedIndex].text;
                            }
                        }
                        if (document.querySelector('[data-link-id]')) {
                            document.querySelector('[data-link-id]').classList.remove('d-none');
                        }


                    } else {
                        if (document.querySelector('#link_id')) {
                            document.querySelector('#link_id').removeAttribute('required');
                        }
                        if (document.querySelector('[data-link-id]')) {
                            document.querySelector('[data-link-id]').classList.add('d-none');
                        }

                        document.querySelector('#url').setAttribute('required', 'required');
                        document.querySelector('[data-url]').classList.remove('d-none');
                    }
                }

                if (document.querySelector('#url_dynamic')) {
                    url_dynamic_handler();
                    document.querySelector('#url_dynamic').addEventListener('change', url_dynamic_handler);
                }

                /* URL Dynamic Link_id handler */
                let link_id_handler = () => {
                    let link_id_element = document.querySelector('#link_id');

                    if (link_id_element && document.querySelector('#url_dynamic') && document.querySelector('#url_dynamic').checked) {
                        document.querySelector('#url').value = link_id_element.options[link_id_element.selectedIndex].text;
                    }
                }
                document.querySelector('#link_id') && document.querySelector('#link_id').addEventListener('change', link_id_handler);

                /* On change regenerated qr */
                let delay_timer = null;

                let apply_reload_qr_code_event_listeners = () => {
                    document.querySelectorAll('[data-reload-qr-code]').forEach(element => {
                        ['change', 'paste', 'keyup', 'click'].forEach(event_type => {
                            element.removeEventListener(event_type, reload_qr_code_event_listener);
                            element.addEventListener(event_type, reload_qr_code_event_listener);
                        })
                    });
                }

                let reload_qr_code_event_listener = (event) => {

                    if (!submitClicked) {

                        let form = document.querySelector('form#myform');
                        let form_data = new FormData(form);

                        // Checck image select and canceld
                        var elementId = event.target.id;
                        if (elementId != 'undefined' && elementId == 'qr_code_logo') {
                            if (form_data.get("qr_code_logo") && form_data.get("qr_code_logo").name == '') {
                                var logoUplImg = $('#logo-upl-img').attr('src');
                                if (typeof(logoUplImg) != 'undefined' && logoUplImg != '') {
                                    return false;
                                }
                            }
                        }




                        $("#temp_next").attr("disabled", true);
                        $("#temp_submit").attr("disabled", true);
                        /* Add the preloader, hide the QR */
                        $('#loader.qr').addClass('active');
                        $('#qr-code-wrap').removeClass('active');

                        /* Disable the submit button */
                        if (document.querySelector('button[type="submit"]')) {
                            document.querySelector('button[type="submit"]').classList.add('disabled');
                            document.querySelector('button[type="submit"]').setAttribute('disabled', 'disabled');
                        }

                        // clearTimeout(delay_timer);

                        $("#temp_submit").attr("disabled", true);
                        // var ajaxTime = new Date().getTime();
                        // var totalTime;

                        /* Send the request to the server */

                        form_data.delete("screen");
                        form_data.delete("companyLogo");
                        form_data.delete("offerImage");
                        form_data.delete("linkImages[]");

                        var formTypes = form_data.get("type");
                        if (formTypes == "menu") {
                            for (let key of form_data.keys()) {
                                if (key.startsWith('productImages_')) {
                                    form_data.delete(key);
                                }
                            };
                        }


                        let notification_container = form.querySelector('.notification-container');
                        notification_container.innerHTML = '';

                        $('#temp_submit').attr('disabled', true);
                        isGenerating = true;

                        fetch(`${url}qr-code-generator`, {
                                method: 'POST',
                                body: form_data,
                            })
                            .then(response => response.ok ? response.json() : Promise.reject(response))
                            .then(data => {
                                isGenerating = false;

                                if (typeof ImagesUploading != 'undefined') {
                                    if (ImagesUploading === false) {

                                        $(".preview-qr-btn").attr("disabled", false);
                                        $("#temp_next").attr("disabled", false);
                                        $("#temp_submit").attr("disabled", false);

                                    }
                                } else {

                                    $("#temp_next").attr("disabled", false);
                                }

                                if (data.status == 'error') {
                                    console.log('data.status error' + data);
                                } else if (data.status == 'success') {
                                    display_notifications(data.message, 'success', notification_container);

                                    $('#qr-code-wrap').html(data.details.image);

                                    if (window?.sbdbg?.on) {
                                        console.log(JSON.stringify(data.details.qr_quality));
                                    }

                                    if (data.details.message == 'UNSCANNABLE') {
                                        // $(".carousel-item-1 .carousel-item-para").html('<?= str_replace("'", "\'", l('qr_general.help.step_2.description_coupon')) ?>');
                                        $('#statusMsg').html(`<div class="alert alert-danger"> 
                                                                <?= str_replace("'", "\'", l('qr_step_3.qr_scan_status_message')) ?>
                                                                </div>`);
                                    } else {
                                        $('#statusMsg').html('');
                                    }


                                    document.querySelector('#download_svg').href = data.details.data;
                                    if (document.querySelector('input[name="qr_code"]')) {
                                        document.querySelector('input[name="qr_code"]').value = data.details.data;
                                    }

                                    /* Enable the submit button */
                                    if (document.querySelector('button[type="submit"]')) {
                                        document.querySelector('button[type="submit"]').classList.remove('disabled');
                                        document.querySelector('button[type="submit"]').removeAttribute('disabled');
                                    }

                                    $('#temp_submit').attr('disabled', false);
                                }

                                /* Hide the preloader, display the QR */
                                $('#loader.qr').removeClass('active');
                                $('#qr-code-wrap').addClass('active');

                                $("#temp_submit").attr("disabled", false);

                            })
                            .catch(error => {
                                isGenerating = false;
                                $("#temp_submit").attr("disabled", true);
                                console.log('data.catch error' + error);
                            });

                    };
                    submitClicked = false;
                }

                apply_reload_qr_code_event_listeners();

                /* SVG to PNG, WEBP, JPG download handler */
                let convert_svg_to_others = (svg_data, type, name, size = 1000) => {
                    svg_data = !svg_data && document.querySelector('#download_svg') ? document.querySelector('#download_svg').href : svg_data;
                    size = document.querySelector('#size') ? document.querySelector('#size').value : size;
                    let image = new Image;
                    image.crossOrigin = 'anonymous';

                    /* Convert SVG data to others */
                    image.onload = function() {
                        let canvas = document.createElement('canvas');

                        canvas.width = size;
                        canvas.height = size;

                        let context = canvas.getContext('2d');
                        context.drawImage(image, 0, 0, size, size);

                        let data = canvas.toDataURL(`image/${type}`, 1);

                        /* Download */
                        let link = document.createElement('a');
                        link.download = name;
                        link.style.opacity = '0';
                        document.body.appendChild(link);
                        link.href = data;
                        link.click();
                        link.remove();
                    }

                    /* Add SVG data */
                    image.src = svg_data;
                }

                <?php if (isset($_GET['name'])) : ?>
                    document.querySelector('select[name="type"]').dispatchEvent(new Event('change'));
                    document.querySelector('input[name="reload"]').dispatchEvent(new Event('change'));
                <?php endif ?>
                //code from js_qr_code.php over

                var logoImg = document.getElementById('qr_code_logo');
                array = [];

                if (logoImg) {
                    logoImg.onchange = evt => {
                        let file_list = event.target.files
                        let key = event.target.id
                        const [file] = logoImg.files
                        persist_file(array, file_list, key)

                        if (file_list != undefined) {
                            event.target.files = element_for(array, key).file_list
                        }

                        if (file) {
                            if ($('#logo-upl-img')) {
                                $('#logo-upl-img').remove();
                            }
                            document.getElementById("logo-tmp-mage").style.display = 'none';
                            document.getElementById('add-logo-icon').style.display = 'none';
                            var elem = document.createElement("img");
                            elem.setAttribute("src", URL.createObjectURL(file));
                            elem.setAttribute("height", "60");
                            elem.setAttribute("width", "60");
                            elem.setAttribute("alt", "Welcome screen image");
                            elem.setAttribute("id", "logo-upl-img");
                            document.getElementById("input-logo-image").appendChild(elem);
                            document.getElementById('edit-logo-icon').style.display = "block";
                            document.getElementById('logo_delete').style.display = "block";
                        }

                    }
                }

                function persist_file(array, file_list, key) {
                    if (file_list != undefined) {
                        if (file_list.length > 0) {
                            if (member(array, key)) {
                                element_for(array, key).file_list = file_list;
                            } else {
                                array.push({
                                    key: key,
                                    file_list: file_list
                                })
                            }
                        }
                    }
                }

                function member(array, key) {
                    return array.some((element, index) => {
                        return element.key == key
                    })
                }

                function element_for(array, key) {
                    return array.find((function(obj, index) {
                        return obj.key === key
                    }))
                }

                $("#logo_delete").on("mousedown", function() {
                    $("#qr_code_logo").val('');
                    $("#edit_QR_code_logo").val('');
                });

                $("#logo_delete").on("click", function() {
                    $('#edit_QR_code_logo').val('');
                    $('#qr_code_logo').val('');
                    document.getElementById('edit-logo-icon').style.display = "none";
                    document.getElementById('logo_delete').style.display = "none";
                    document.getElementById("logo-tmp-mage").style.display = 'flex';
                    document.getElementById('add-logo-icon').style.display = 'block';
                    $('#logo-upl-img').remove();
                    reload_qr_code_event_listener(event);
                    $("#screensizeErrorMesg").remove();
                    $("label[for='qr_code_logo']").css("border", "2px solid #96949C");
                    $("#temp_submit").attr("disabled", false);

                });

                tooltipUpdate();


                Coloris({
                    el: '.custompicker-coloris',
                    themeMode: 'light',
                    alpha: false,
                    defaultColor: '#000000',
                    onChange: (color, el) => handleColorChange(el, color),
                });
            },

            error: () => {

            },


        });
    }

    function handleColorChange(el, color) {
        el.style.backgroundColor = color;
        // console.log(el.closest('.clr-field').nextElementSibling);
        var pikerColor = color.split('#').join('');
        var rgbColor = pikerColor.match(/.{1,2}/g);

        var rgbCode = [
            parseInt(rgbColor[0], 16),
            parseInt(rgbColor[1], 16),
            parseInt(rgbColor[2], 16)
        ];

        if (rgbCode[1] >= 180) {
            el.closest('.clr-field').nextElementSibling.style.color = "black";
        } else {
            el.closest('.clr-field').nextElementSibling.style.color = "white";
        }

    }



    // colorPicker
    document.querySelectorAll('.pickerField').forEach(function(picker) {
        var targetLabel = document.querySelector('label[for="' + picker.id + '"]'),
            codeArea = document.createElement('span');
        var clsid = document.querySelector('.pickerFieldes').id;
        var clsids = document.querySelector('.pickerFields').id;

        codeArea.innerHTML = picker.value;
        targetLabel.appendChild(codeArea);
        codeArea.setAttribute("id", clsid + "txt");
        codeArea.setAttribute("id", clsids + "txt");

        picker.addEventListener('change', function() {
            codeArea.innerHTML = picker.value;
            targetLabel.appendChild(codeArea);
            codeArea.setAttribute("id", clsid + "txt");
            codeArea.setAttribute("id", clsids + "txt");

        });
    });


    async function submit() {
        let allAreFilled = true;
        isSubmitClicked = true;
        var is_true = validation_form();
        var uid = $('#uId').val();


        // temp_submit_loader
        if (is_true == true) {
            window.onbeforeunload = null;
            $("#overlay").show();

            document.getElementById("submit").click();


            if ($('#qr_status').val() != '1') {

                var entery_point = $("input[name=\"onboarding_funnel\"]").val();
                var onboarding_funnel = userFunnle(entery_point);

                // qr_creation_process_complete and qr_design_step3_complete  Data Layer Implementation (GTM)
                var event = 'qr_creation_process_complete';

                var qrData = {
                    'userId': '<?php echo \Altum\Middlewares\Authentication::is_temp_user() ? null : $this->user->user_id ?>',
                    "unique_id": "<?php echo isset($this->user->unique_id) ? $this->user->unique_id : null ?>",
                    'user_type': '<?php echo $this->user->total_logins == '1' ? 'New User' : 'Returning User' ?>',
                    'method': '<?php echo ($this->user->type == 2 ? NULL : ($this->user->source == 'direct' ? 'Email' : 'Google')) ?>',
                    'entry_point': onboarding_funnel,
                    'qr_type': $("input[name=\"type\"]").val(),
                    'qr_id': uid,

                }

                var eventStep3 = 'qr_design_step3_complete';
                var qrStep = 3;
                var qrBack = $("#changeQrType").val() == 'false' ? false : true;


                var qrDataStep3 = {
                    'userId': '<?= $this->user->user_id ?>',
                    'user_type': '<?php echo $this->user->total_logins == '1' ? 'New User' : 'Returning User' ?>',
                    'method': '<?php echo ($this->user->type == 2 ? NULL : ($this->user->source == 'direct' ? 'Email' : 'Google')) ?>',
                    'entry_point': onboarding_funnel,
                    'qr_type': $("input[name=\"type\"]").val(),
                    'qr_id': uid,

                }

                googleDataLayer(eventStep3, qrDataStep3);
                googleDataLayer(event, qrData);

                sessionStorage.removeItem("select_qr_step1_complete");
                sessionStorage.removeItem("qr_content_step2_complete");

            }
        } else {
            console.log("## validation error");
        }
    }





    var __QRTYPES = <?php echo json_encode($data->qr_code_settings['type']); ?>;

    function changeUrl(newUrl = '', thisObj = null) {
        $('#loader').show();
        var frame = $('#iframesrc')[0];

        if (thisObj == null) {
            $('#QrType').text('Url');

            $('#qr-preview').css("display", "none");
            $('#iframesrc').css("display", "block");

            // $("#qr-preview").prop('src', '<?php echo ASSETS_FULL_URL; ?>images/funnel-default-phone-mockup-2.webp');
            $(".default-preview-text").css("display", "none");

        } else {

            var qrtype = $(thisObj).val();

            if ($("input[name=\"current_step_input\"]").val() == '2') {

            }


            $("input[name=\"qrtype_input\"]").val(qrtype);
            $("#myLoad").removeClass().addClass(qrtype);
            var newQrTypeText = $(thisObj).data('qr_type') || 'pdf';
            $('#QrType').text(newQrTypeText);

            $('#qr-preview').css("display", "none");
            $('#iframesrc').css("display", "block");

            // $("#qr-preview").attr("src", "<?= ASSETS_FULL_URL; ?>" + 'images/qr-preview/' + qrtype + '.png');
            $(".default-preview-text").css("display", "none");
        }
        $('#loader').hide();
    }

    function getBackButtonText() {
        if (step > 1) {
            return "<?= l('qr_step_2.back_btn') ?>";
        }
    }


    function swapValues() {
        var tmp = document.getElementById("primaryColor").value;
        document.getElementById("primaryColor").value = document.getElementById("SecondaryColor").value;
        document.getElementById("primaryColorValue").value = document.getElementById("SecondaryColor").value;
        document.getElementById("selectPrimary").value = document.getElementById("SecondaryColor").value;
        document.getElementById("SecondaryColor").value = tmp;
        document.getElementById("selectSecondary").value = tmp;
        document.getElementById("secondaryColorValue").value = tmp;

        var primaryBg = document.getElementById("primaryColor");
        var secondaryBg = document.getElementById("SecondaryColor");

        var cuPrimaryBg = primaryBg.getAttribute("style");
        var cuSecondaryBg = secondaryBg.getAttribute("style");

        primaryBg.setAttribute("style", cuSecondaryBg);
        secondaryBg.setAttribute("style", cuPrimaryBg);

        var primaryC = document.getElementById("primaryColorValue").value;
        var secondaryC = document.getElementById("secondaryColorValue").value;

        var activeIndexPrimary = $('.formcolorPalette.active').index();

        $(".formcolorPalette:eq(" + activeIndexPrimary + ")").find('input[type=\"color\"]:first').val(primaryC);
        $(".formcolorPalette:eq(" + activeIndexPrimary + ")").find('input[type=\"color\"]:last').val(secondaryC);

        var primaryCicon = $("#primaryColorValue").parents('label').find('span');
        var secondaryCicon = $("#secondaryColorValue").parents('label').find('span');

        primaryCicon.detach().appendTo($("#secondaryColorValue").parents('label'));
        secondaryCicon.detach().appendTo($("#primaryColorValue").parents('label'));

        // console.log(primaryCicon);
        // console.log(secondaryCicon);

        LoadPreview();
    }

    $(".bottom-back-btn").click(function() {
        var c_step = $("input[name=\"step_input\"]").val();
        if (c_step == 1) {
            document.querySelector('#tab2.step-2-wrp').classList.remove('active-step');
            document.querySelector('#tab1.step-1-wrp').classList.remove('active-step');
            document.querySelector('#tab1Line.step-1-line').classList.remove('active-line');
        }
        if (c_step == 2) {
            document.querySelector('#tab3.step-3-wrp').classList.remove('active-step');
            document.querySelector('#tab2Line.step-2-line').classList.remove('active-line');
        }
    });

    function backButton(back = 0) {

        var c_step = $("input[name=\"step_input\"]").val();
        document.getElementById('step2').style.display = 'none';

        if (back == 1) {
            if (c_step == 2) {
                // $("#qr-preview").prop('src', '<?php echo ASSETS_FULL_URL; ?>images/funnel-default-phone-mockup-2.webp');
                $(".default-preview-text").css("display", "none");
                $('.create-card').removeClass('active');
                $("#tabs-1").addClass("active");
                $("#tabs-2").removeClass("active");
                $("#1").addClass("active");
                $("#2").removeClass("active");
                $('#qr-preview').css("display", "none");
                $('#iframesrc').css("display", "block");
                $(".main-container").addClass("qr-step-default");

                if (!$('#current_state').val('edit')) {
                    $('input[name="qrcodeId"]').val("");
                }

                // document.getElementById('iframesrc').src = `<?=LANDING_PAGE_URL?>step-1?lang=<?php echo $userLanguage ?>&preview=true`;
                if($('#qr_status').val()){
                    setTimeout(()=>{
                        document.getElementById('iframesrc').contentWindow.postMessage({live:true,type:'default',step:1},'<?=LANDING_PAGE_URL?>');
                    },800)
                }else{
                    document.getElementById('iframesrc').contentWindow.postMessage({live:true,type:'default',step:1},'<?=LANDING_PAGE_URL?>');
                }

            }
        }



        if (c_step == 2) {

            $("#qr-preview").prop('src', '<?php echo ASSETS_FULL_URL; ?>images/default.png');

            $('#qr-preview').css("display", "none");
            $('#iframesrc').css("display", "block");
            if (!$('#current_state').val('edit')) {
                $('input[name="qrcodeId"]').val("");
            }
            // else{
            //     $('.bottom-back-btn span.bottom-btn-label').val("");

            // }
        }

        if (c_step == 1 || c_step == 3) {
            $("#tabs-1").addClass("active");
            $("#tabs-2").removeClass("active");
            $("#1").addClass("active");
            $("#2").removeClass("active");
        }

        if (c_step == 1 || c_step == '1') {
            if (back == 1) {
                window.location.href = '<?php echo SITE_URL ?>qr-codes';
            }

        } else {
            $("input[name=\"step_input\"]").val(parseInt(c_step) - 1)
            change_step(parseInt(c_step) - 1)
            if (c_step == 3) {

                <?php if (\Altum\Middlewares\Authentication::is_temp_user()) { ?>
                    redirectToNSFFunnel(2);
                <?php } else { ?>
                    window.history.pushState("object or string", "Title", '<?php echo SITE_URL . ($userLanguageCode  == 'en'  ? null : $userLanguageCode  . '/') ?>qr?step=2<?= !empty($_REQUEST['project_id']) ? "&project_id={$_REQUEST['project_id']}" : '' ?><?= $userQrCode == null ? "&qr_onboarding=active" : "" ?>');
                <?php }  ?>

                $("#changeQrType").val(false);
            }
            if (c_step == 2) {

                <?php if (\Altum\Middlewares\Authentication::is_temp_user()) { ?>
                    redirectToNSFFunnel(1);
                <?php } else { ?>
                    window.history.pushState("object or string", "Title", '<?php echo SITE_URL . ($userLanguageCode  == 'en'  ? null : $userLanguageCode  . '/') ?>qr?step=1<?= !empty($_REQUEST['project_id']) ? "&project_id={$_REQUEST['project_id']}" : '' ?><?= $userQrCode == null ? "&qr_onboarding=active" : "" ?>');
                <?php }  ?>


                $("#changeQrType").val(true);
            }
        }
    }

    window.addEventListener('popstate', function(event) {

        $('.help-close-btn.step-2').trigger('click');
        var c_step = $("input[name=\"step_input\"]").val();


        if ($("#previewModel").hasClass("active")) {
            if (c_step == 3) {
                <?php if (\Altum\Middlewares\Authentication::is_temp_user()) { ?>
                    redirectToNSFFunnel(3);
                <?php } else { ?>
                    window.history.pushState("object or string", "Title", '<?php echo SITE_URL . ($userLanguageCode  == 'en'  ? null : $userLanguageCode  . '/') ?>qr?step=3<?= !empty($_REQUEST['project_id']) ? "&project_id={$_REQUEST['project_id']}" : '' ?><?= $userQrCode == null ? "&qr_onboarding=active" : "" ?>');
                <?php } ?>

            }
            if (c_step == 2) {

                <?php if (\Altum\Middlewares\Authentication::is_temp_user()) { ?>
                    redirectToNSFFunnel(3);

                <?php } else { ?>
                    window.history.pushState("object or string", "Title", '<?php echo SITE_URL . ($userLanguageCode  == 'en'  ? null : $userLanguageCode  . '/') ?>qr?step=3<?= !empty($_REQUEST['project_id']) ? "&project_id={$_REQUEST['project_id']}" : '' ?><?= $userQrCode == null ? "&qr_onboarding=active" : "" ?>');
                <?php } ?>

            }
            $("#overlayPre").css({
                'opacity': '0',
                'display': 'none'
            });
            $("body").not(".app").removeClass("scroll-none");
            $(".col-right.customScrollbar").removeClass("active");
        } else {

            change_step(parseInt(c_step) - 1);

            if (c_step == 3) {

                <?php if (\Altum\Middlewares\Authentication::is_temp_user()) { ?>
                    redirectToNSFFunnel(2);

                <?php } else { ?>
                    window.history.pushState("object or string", "Title", '<?php echo SITE_URL . ($userLanguageCode  == 'en'  ? null : $userLanguageCode  . '/') ?>qr?step=2<?= !empty($_REQUEST['project_id']) ? "&project_id={$_REQUEST['project_id']}" : '' ?><?= $userQrCode == null ? "&qr_onboarding=active" : "" ?>');
                <?php } ?>

                $("#changeQrType").val(false);

            }
            if (c_step == 2) {
                <?php if (\Altum\Middlewares\Authentication::is_temp_user()) { ?>
                    redirectToNSFFunnel(1);
                <?php } else { ?>
                    window.history.pushState("object or string", "Title", '<?php echo SITE_URL . ($userLanguageCode  == 'en'  ? null : $userLanguageCode  . '/') ?>qr?step=1<?= !empty($_REQUEST['project_id']) ? "&project_id={$_REQUEST['project_id']}" : '' ?><?= $userQrCode == null ? "&qr_onboarding=active" : "" ?>');
                <?php }  ?>
                $("#qr-preview").prop('src', '<?php echo ASSETS_FULL_URL; ?>images/default.png');
                $("#tabs-1").addClass("active");
                $("#tabs-2").removeClass("active");
                $("#2").removeClass("active");
                $("#1").addClass("active");
                $('.create-card').removeClass('active');

                $('#qr-preview').css("display", "none");
                $('#iframesrc').css("display", "block");
                if (!$('#current_state').val('edit')) {
                    $('input[name="qrcodeId"]').val("");
                }
                $("#changeQrType").val(true);

            }
            if (c_step == 1) {

                <?php if (\Altum\Middlewares\Authentication::is_temp_user()) { ?>
                    var url = sessionStorage.getItem("funnle_url");
                <?php } else { ?>
                    var url = '<?php echo SITE_URL . ($userLanguageCode  == 'en'  ? null : $userLanguageCode  . '/') ?>qr?step=1<?= !empty($_REQUEST['project_id']) ? "&project_id={$_REQUEST['project_id']}" : '' ?><?= $userQrCode == null ? "&qr_onboarding=active" : "" ?>';
                <?php }  ?>

                $("#step1").css({
                    'display': 'block'
                });
                $("#tabs-1").addClass('active');
                $("#tabs-2").removeClass('active');
                $("input[name='step_input']").val("1");
                $("#step3").css({
                    'display': 'none'
                });
                $("#preview_qrcode").css({
                    'visibility': 'hidden',
                    'opacity': '0'
                });
                if (c_step == 1) {
                    $("input[name='current_step_input']").val("1");
                    $(".step-1-line, .step-2-line").removeClass('active-line');
                    $(".step-2-wrp, .step-3-wrp").removeClass('active-step');
                    window.history.pushState("object or string", "Title", url);
                    document.title = url;
                }

            }

        }
    });

    // Modal Changes    
    $(document).on('click', '.help-info-modal', function() {

        if ($('#omitOnUrlWifi').hasClass('active')) {
            $("#helpModal2 .modal-dialog-help.preview-point").removeClass("slide-2");
            $("#qr-proceed-footer").removeClass("hpmodal-active-preview slide-2");
            $('#omitOnUrlWifi').removeClass('active')
        }
        if ($('#resetoverlays').hasClass('active')) {
            $("#helpModal2 .modal-dialog-help.preview-point").removeClass("slide-2");
            $("#qr-proceed-footer").removeClass("hpmodal-active-preview slide-2");
            $('#resetoverlays').removeClass('active')
        }

    });
    $(document).on('click', '.qr-card-btn', function() {
        // $(".help-info-modal").attr("data-target", "#helpModal2");
        var qrType = $('.qrtypeInput').val();

        function resetClasses() {
            var allExist = $('#omitOnUrlWifi').hasClass('.item-2');
            if (!allExist) {
                $('#omitOnUrlWifi').addClass('carousel-item carousel-1-item-2 item-2');
                $('#omitOnUrlWifi').removeAttr('style');
            }
        }

        switch (qrType) {
            case 'url':
                $(".carousel-item-1 .carousel-item-para").html('<?= str_replace("'", "\'", l('qr_general.help.step_2.description_url')) ?>')
                $('#omitOnUrlWifi').removeClass().hide();
                break;
            case 'pdf':
                $(".carousel-item-1 .carousel-item-para").html('<?= str_replace("'", "\'", l('qr_general.help.step_2.description_pdf')) ?>');
                resetClasses();
                break;
            case 'images':
                $(".carousel-item-1 .carousel-item-para").html('<?= str_replace("'", "\'", l('qr_general.help.step_2.description_images')) ?>');
                resetClasses();
                break;
            case 'video':
                $(".carousel-item-1 .carousel-item-para").html('<?= str_replace("'", "\'", l('qr_general.help.step_2.description_video')) ?>');
                resetClasses();
                break;
            case 'wifi':
                $(".carousel-item-1 .carousel-item-para").html('<?= str_replace("'", "\'", l('qr_general.help.step_2.description_wifi')) ?>');
                $('#omitOnUrlWifi').removeClass().hide();
                break;
            case 'menu':
                $(".carousel-item-1 .carousel-item-para").html('<?= str_replace("'", "\'", l('qr_general.help.step_2.description_menu')) ?>');
                resetClasses();
                break;
            case 'business':
                $(".carousel-item-1 .carousel-item-para").html('<?= str_replace("'", "\'", l('qr_general.help.step_2.description_business')) ?>');
                resetClasses();
                break;
            case 'vcard':
                $(".carousel-item-1 .carousel-item-para").html('<?= str_replace("'", "\'", l('qr_general.help.step_2.description_vcard')) ?>');
                resetClasses();
                break;
            case 'mp3':
                $(".carousel-item-1 .carousel-item-para").html('<?= str_replace("'", "\'", l('qr_general.help.step_2.description_mp3')) ?>');
                resetClasses();
                break;
            case 'app':
                $(".carousel-item-1 .carousel-item-para").html("<?= str_replace("'", "\'", l("qr_general.help.step_2.description_app")) ?>");
                resetClasses();
                break;
            case 'links':
                $(".carousel-item-1 .carousel-item-para").html('<?= str_replace("'", "\'", l('qr_general.help.step_2.description_links')) ?>');
                resetClasses();
                break;
            case 'coupon':
                $(".carousel-item-1 .carousel-item-para").html('<?= str_replace("'", "\'", l('qr_general.help.step_2.description_coupon')) ?>');
                resetClasses();
                break;
            default:
        }

        if ($('#helpModal2 .carousel-1-item-4.item-4').hasClass('active')) {
            $('#helpModal2 .carousel-1-item-4.item-4').removeClass('active');
        }



    });

    let progress = 0;
    modalOpen.addEventListener("click", function() {
        var currentStep = $("input[name=\"current_step_input\"]").val();
        updateButton.removeAttribute("data-dismiss");
        if (currentStep == 2) {
            var qrType = $("input[name=\"type\"]").val();
            if (qrType == 'url' || qrType == 'wifi') {
                progress = 33.33;
            } else {
                progress = 25;
            }
            updateProgressBar();
            $(".step-2-slides .carousel-item").removeClass("active");
            $(".step-2-slides .carousel-1-item-1").addClass("active");
        } else if (currentStep == 3) {
            progress = 50;
            updateProgressBar();
            $(".step-3-slides .carousel-item").removeClass("active");
            $(".step-3-slides .carousel-2-item-1").addClass("active");

        }
        if (updateButton.innerHTML = "Close") {
            updateButton.innerHTML = "Continue"
        }
    });

    function updateProgressBar() {
        progressBar.style.width = progress + "%";
    }
    updateButton.addEventListener("click", function() {
        var url = window.location.href;
        var isCreate = url.indexOf("create") > -1;
        var queryParams = new URLSearchParams(url.split('&')[1]);
        var qrOnboarding = queryParams.get('qr_onboarding');
        clickCount++;
        // Increment the progress (you can customize this logic)
        var currentStep = $("input[name=\"current_step_input\"]").val();

        if (currentStep == 2) {
            var qrType = $("input[name=\"type\"]").val();
            if (qrType == 'url' || qrType == 'wifi') {
                progress += 33.33;
            } else {
                progress += 25;
            }

            if (clickCount == 1) {
                $('.image-check').removeClass('active-image');
                activePreview.addClass('preview-point slide-2');
                bottomFooter.addClass('hpmodal-active-preview slide-2');

                if (qrType == 'url' || qrType == 'wifi') {
                    activePreview.addClass('slide-4');
                    bottomFooter.addClass('slide-4');
                    activePreview.removeClass('slide-2');
                    bottomFooter.removeClass('slide-2');
                } else {
                    // if ($(window).width() >= 1200) {
                    if (qrType == 'coupon') {
                        phoneMockup.classList.add('activeCouponMobile');
                    } else {
                        phoneMockup.classList.add('activeMobile');
                    }
                    // }
                }


            } else if (clickCount == 2) {
                activePreview.addClass('slide-4');
                bottomFooter.addClass('slide-4');
                activePreview.removeClass('slide-2');
                bottomFooter.removeClass('slide-2');
                if (qrType == 'url' || qrType == 'wifi') {
                    updateButton.innerHTML = "Close";
                    activePreview.addClass('slide-3');
                    bottomFooter.addClass('slide-3');
                    activePreview.removeClass('slide-4');
                    bottomFooter.removeClass('slide-4');

                } else {
                    if (qrType == 'coupon') {
                        phoneMockup.classList.remove('activeCouponMobile');
                    } else {
                        phoneMockup.classList.remove('activeMobile');
                    }

                }

            } else if (clickCount == 3) {
                activePreview.addClass('slide-3');
                bottomFooter.addClass('slide-3');
                activePreview.removeClass('slide-4');
                bottomFooter.removeClass('slide-4');
                updateButton.innerHTML = "Close";
                if (qrType == 'url' || qrType == 'wifi') {
                    activePreview.removeClass('preview-point slide-3');
                    bottomFooter.removeClass('slide-3');
                    updateButton.setAttribute("data-dismiss", "modal");
                    bottomFooter.removeClass('hpmodal-active-preview slide-4');
                    setTimeout(() => {
                        $(".step-2-slides .carousel-1-item-3").removeClass("active");
                    }, 500);
                    clickCount = 0;
                }
            } else {
                $('.image-check').addClass('active-image');
                updateButton.setAttribute("data-dismiss", "modal");
                activePreview.removeClass('preview-point slide-4 slide-3');
                bottomFooter.removeClass('hpmodal-active-preview slide-4 slide-3');

                // if (qrOnboarding !== null) {
                if ((qrOnboarding == 'active_nsf' || qrOnboarding == 'active_dpf' || qrOnboarding == 'active' || isCreate)) {
                    if (clickCount == 4) {
                        $("#helpModal2").hide();
                        $('#overlayPre').hide();
                        $('#overlayPre').css('opacity', '0');
                        $('body').removeClass('modal-open');
                        if ($('#mobile-preview').length > 0) {
                            $('#mobile-preview').remove();
                        }
                        clickCount = 0
                    }
                }
                if ($('#omitOnUrlWifi').hasClass('active')) {
                    $("#helpModal2 .modal-dialog-help.preview-point").removeClass("slide-2");
                    $("#qr-proceed-footer").removeClass("hpmodal-active-preview slide-2");
                    $('#omitOnUrlWifi').removeClass('active')
                }

                // }
                else {
                    clickCount = 0
                }
            }

        } else if (currentStep == 3) {
            progress += 50;
            if (clickCount == 1) {
                $('.image-check').removeClass('active-image');
                activePreview.addClass('preview-point slide-2');
                bottomFooter.addClass('hpmodal-active-preview slide-2');
                phoneMockup.classList.add('activeQRmobile');
                updateButton.innerHTML = "Close";
            } else {
                $('.image-check').addClass('active-image');
                updateButton.setAttribute("data-dismiss", "modal");
                activePreview.removeClass('preview-point slide-2');
                bottomFooter.removeClass('hpmodal-active-preview slide-2');
                phoneMockup.classList.remove('activeQRmobile');
                // if (qrOnboarding !== null) {
                if ((qrOnboarding == 'active_nsf' || qrOnboarding == 'active_dpf' || qrOnboarding == 'active' || isCreate)) {
                    if (clickCount == 2) {
                        // if ($(window).width() < 1200) {
                        $("#helpModal2").hide();
                        $('#overlayPre').hide();
                        $('#overlayPre').css('opacity', '0');
                        $('body').removeClass('modal-open');
                        // }
                        if ($('#mobile-preview').length > 0) {
                            $('#mobile-preview').remove();
                        }
                        clickCount = 0
                    }
                }

                // }
                else {
                    clickCount = 0
                }

            }
        }
        if (progress > 100) {
            progress = 100;
        }

        updateProgressBar();
    });



    $(".preview-qr-btn").click(function() {
        var url = window.location.href;
        var isCreate = url.indexOf("create") > -1;
        var queryParams = new URLSearchParams(url.split('&')[1]);
        var qrOnboarding = queryParams.get('qr_onboarding');

        if ($('#qr-proceed-footer').hasClass('hpmodal-active-preview')) {
            $('#previewModel').css({
                'z-index': '1065'
            });
            $("#overlayPre").css({
                'opacity': '0.5',
                'display': 'block',
                'z-index': '1064'
            });

            if ((qrOnboarding == 'active_nsf' || qrOnboarding == 'active_dpf' || qrOnboarding == 'active' || isCreate)) {
                if (!($('.modal-backdrop.fade.show').length > 0)) {
                    $('body').append('<div id="mobile-preview" class = "modal-backdrop fade show"></div>');

                }

            }

            activePreview.removeClass('slide-2');
            bottomFooter.removeClass('slide-2');
            bottomFooter.removeClass('hpmodal-active-preview');
        } else {
            $("#overlayPre").css({
                'opacity': '0.5',
                'display': 'block'
            });

        }

        $("body").not(".app").addClass("scroll-none");
        $(".col-right.customScrollbar").addClass("active");
    });

    $(".exitPreview").click(function() {
        $("#overlayPre").css({
            'opacity': '0',
            'display': 'none'
        });
        if ($('#helpModal2').is(':visible')) {
            $("#helpModal2 .modal-dialog-help.preview-point").addClass("slide-2");
            $("#qr-proceed-footer").addClass("hpmodal-active-preview slide-2");
            $("#overlayPre").removeAttr('style');
        } else {
            if ($("#qr-proceed-footer").hasClass('hpmodal-active-preview')) {
                $("#helpModal2 .modal-dialog-help.preview-point").removeClass("slide-2");
                $("#qr-proceed-footer").removeClass("hpmodal-active-preview slide-2");
            }
        }
        if ($('.scroller-img').hasClass('d-none')) {
            $('.scroller-img').removeClass('d-none');
        }
        if ($('.pointer-img').addClass('d-none')) {
            $('.pointer-img').removeClass('d-none');
        }


        $("body").not(".app").removeClass("scroll-none");
        $(".col-right.customScrollbar").removeClass("active");
    });


    var winWidth = $(window).width();
    $(document).ready(function() {
        var touchElem = $(".mobilephone-column");
        $(".tab-content.mb-frame").on("touchstart", function() {
            if (touchElem.hasClass('activeMobile')) {
                $('.scroller-img').addClass('d-none');
            }
            if (touchElem.hasClass('activeCouponMobile')) {
                $('.pointer-img').addClass('d-none');
            }
        });
    });
    // Modal Changes
</script>


<script type="text/javascript">
    function onSlide(type) {
        var current = $('.carousel-item.active').index() + 1;
    }
    $("#screen_delete").on("click", function() {
        $('#screen').val('');

        document.getElementById('edit-icon').style.display = 'none';
        document.getElementById('screen_delete').style.display = 'none';
        document.getElementById("tmp-mage").style.display = "flex";
        document.getElementById("upl-img").style.display = "none";
        document.getElementById('add-icon').style.display = "block";
        let upl_img = document.getElementById('upl-img');
        upl_img.remove();

    });

    if (document.getElementById('screen')) {
        var screen = document.getElementById('screen')
        screen.onchange = evt => {

            const [file] = screen.files
            if (file) {
                if ($('#upl-img')) {
                    $('#upl-img').remove();
                }
                document.getElementById("tmp-mage").style.display = 'none';
                document.getElementById('add-icon').style.display = 'none';
                var elem = document.createElement("img");
                elem.setAttribute("src", URL.createObjectURL(file));
                elem.setAttribute("height", "60");
                elem.setAttribute("width", "60");
                elem.setAttribute("alt", "Welcome screen image");
                elem.setAttribute("id", "upl-img");
                document.getElementById("input-image").appendChild(elem);
                document.getElementById('edit-icon').style.display = "block";
                document.getElementById('screen_delete').style.display = "block";
            }
        }
    }

    $("#cl_screen_delete").on("click", function() {

        $('#companyLogo').val('');
        $('#companyLogoImage').val('');

        document.getElementById('company_log_edit_icon').style.display = "none";
        document.getElementById('cl_screen_delete').style.display = "none";
        document.getElementById("cl-tmp-mage").style.display = 'flex';
        document.getElementById('company_log_add_icon').style.display = 'block';
        $('#cl-upl-img').remove();

        LoadPreview(false);

    });

    if (document.getElementById('companyLogo')) {
        var companyLogo = document.getElementById('companyLogo')
        companyLogo.onchange = evt => {


            const [file] = companyLogo.files
            if (file) {
                if ($('#cl-upl-img')) {
                    $('#cl-upl-img').remove();
                }
                document.getElementById("cl-tmp-mage").style.display = 'none';
                document.getElementById('company_log_add_icon').style.display = 'none';
                var elem = document.createElement("img");
                elem.setAttribute("src", URL.createObjectURL(file));
                // elem.setAttribute("height", "60");
                // elem.setAttribute("width", "60");
                elem.setAttribute("alt", "Welcome screen image");
                elem.setAttribute("id", "cl-upl-img");
                document.getElementById("company_logo_img").appendChild(elem);
                document.getElementById('company_log_edit_icon').style.display = "block";
                document.getElementById('cl_screen_delete').style.display = "block";
            }
        }
    }

    var imgUpload = document.getElementById('images'),
        imgPreview = document.getElementById(`<div class="screen-upload mb-3"> <
           label
           for = "screen" >
           <
           input type = "file"
           id = "screen"
           name = "screen"
           onchange = "setTimeout(function() { console.log('here'); document.getElementById('loader').style.display = 'block'; document.getElementById('iframesrc').style.visibility = 'hidden'; LoadPreview(); }, 5000);"
           class = "form-control py-2"
           value = ""
           accept = "image/png, image/gif, image/jpeg"
           data - reload - qr - code / >
           <
           div class = "input-image"
           id = "input-image" >
           <
           svg class = "MuiSvgIcon-root"
           id = "tmp-mage"
           focusable = "false"
           viewBox = "0 0 60 60"
           aria - hidden = "true"
           style = "font-size: 60px;" >
           <
           path d = "M19.24,26.79a8.17,8.17,0,1,0-8.17-8.17A8.17,8.17,0,0,0,19.24,26.79Zm0-14.34a6.17,6.17,0,1,1-6.17,6.17A6.18,6.18,0,0,1,19.24,12.45Z" > < /path> <
           path d = "M56.75,49.34,39.18,29.26a1,1,0,0,0-1.46-.05L25.09,41.84,19.1,35a1,1,0,0,0-.72-.34.93.93,0,0,0-.74.29L3.29,49.29a1,1,0,0,0,1.42,1.42L18.3,37.12,30.14,50.66a1,1,0,0,0,.76.34,1,1,0,0,0,.66-.25,1,1,0,0,0,.09-1.41l-5.24-6,12-12L55.25,50.66A1,1,0,0,0,56,51a1,1,0,0,0,.75-1.66Z" > < /path> < /
           svg > <
           /div> <
           div class = "add-icon"
           id = "add-icon" >
           <
           svg class = "MuiSvgIcon-root"
           focusable = "false"
           viewBox = "0 0 24 24"
           aria - hidden = "true" >
           <
           path d = "M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" > < /path> < /
           svg > <
           /div> < /
           label > <
           button type = "button"
           class = "upload-btn"
           onclick = "LoadPreview()" > Preview < /button> < /
           div > `),
        totalFiles, previewTitle, previewTitleText, img;

    if (imgUpload)

        imgUpload.addEventListener('change', previewImgs, false);

    function previewImgs(event) {
        totalFiles = imgUpload.files.length;

        if (!!totalFiles) {
            imgPreview.classList.remove('quote-imgs-thumbs--hidden');
        }
        for (var i = 0; i < totalFiles; i++) {

            const fsize = event.target.files[i].size;
            const filesize = Math.round((fsize / 1024));
            upload = document.createElement('div');
            upload.className = "afterImage-upload";
            upload.id = "img_div";
            cent = document.createElement('div');
            cent.className = "d-flex align-items-center";
            prv = document.createElement('div');
            prv.className = "imagePreview";
            img = document.createElement('img');
            img.src = URL.createObjectURL(event.target.files[i]);
            prv2 = document.createElement('div');
            prv2.className = "previewDetail";
            lbl = document.createElement('label');
            lbl.innerHTML = event.target.files[i].name;
            flx = document.createElement('div');
            flx.className = "d-flex align-items-center";
            spn = document.createElement('span');
            spn.innerHTML = filesize + " kb";
            imgPreview.appendChild(upload);
            upload.appendChild(cent);
            cent.appendChild(prv);
            prv.appendChild(img);
            cent.appendChild(prv2);
            prv2.appendChild(lbl);
            prv2.appendChild(spn);
            upload.appendChild(flx);

            flx.innerHTML = '<button type="button" onclick="remove_me(this)">' +
                ' <svg class="MuiSvgIcon-root" color="#FE4256" focusable="false"  viewBox="0 0 24 24" aria-hidden="true" style="font-size: 24px;">' +
                '<path d="M20,7H4A1,1,0,0,0,4,9H5.08l.77,9.25a3,3,0,0,0,3,2.75h6.32a3,3,0,0,0,3-2.75L18.92,9H20a1,1,0,0,0,0-2ZM16.16,18.08a1,1,0,0,1-1,.92H8.84a1,1,0,0,1-1-.92L7.09,9h9.82Z"></path><path  d="M9,5h6a1,1,0,0,0,0-2H9A1,1,0,0,0,9,5Z"></path></svg>' +
                '</button>';

        }
    }
    // delete image
    function remove_div(id) {

        const img_div = document.getElementById('img_div');
        img_div.addEventListener('click', () => {
            img_div.remove();
        });
    }

    $(document).on('input', '#frameTextColor', function() {
        var changeTextColor = $(this).val();
        $('#frameTextColor').val(changeTextColor);
        $(this).data('changeTextColor', changeTextColor);
    });

    $(document).on('input', '#qrFrameText', function() {

        var defFontSize = parseInt($('#qrFrameFontSize').attr('defaultFontSize'));
        var defTextYPosition = parseInt($('#frameTextYPosition').attr('deftextYPosition'));
        var UppercaseDecValue = parseInt($('#UppercaseDecValue').val());
        var decValue = $("#decValue").val();


        // var qrFrameText = $("#qrFrameText").val();
        // var elemDiv = document.getElementById('qrFrameTextSpan');
        // elemDiv.textContent = qrFrameText;
        // console.log(elemDiv.clientWidth + "px");

        var decValueArray = decValue.split(',');
        decValueArray = decValueArray.map(function(value) {
            return parseInt(value, 10);
        });

        changeFrameFontSize(defFontSize, defTextYPosition, UppercaseDecValue, decValueArray);

    });

    function changeFrameFontSize(defFontSize, defTextYPosition, UppercaseDecValue, decValue) {
        var fontSize, yPosition, UppercaseDecValue;
        var defFontSize = defFontSize ? defFontSize : 42;
        var defTextYPosition = defTextYPosition ? defTextYPosition : 0;
        var decValue = decValue ? decValue : [12, 15, 18, 20, 21, 22, 23, 24, 25, 27];
        var qrFrameText = $("#qrFrameText").val();
        var textCount = qrFrameText.length;

        var qrFrameTextSpan = document.getElementById('qrFrameTextSpan');
        qrFrameTextSpan.textContent = qrFrameText;
        var textWidth = qrFrameTextSpan.clientWidth;


        var isUpperCase = qrFrameText === qrFrameText.toUpperCase();

        if (!containsEmoji(qrFrameText)) {
            if (isUpperCase) {
                UppercaseDecValue = UppercaseDecValue;
            } else {
                UppercaseDecValue = 0;
            }
        } else {
            if (textWidth >= 67) {
                UppercaseDecValue = UppercaseDecValue;
            } else {
                UppercaseDecValue = 0;
            }
        }

        if (textWidth >= 390) {
            fontSize = (defFontSize - decValue[13] - UppercaseDecValue) + "px";
            yPosition = defTextYPosition - 8;
            var dctest = decValue[13];
        } else if (textWidth >= 367) {
            fontSize = (defFontSize - decValue[12] - UppercaseDecValue) + "px";
            yPosition = defTextYPosition - 8;
            var dctest = decValue[12];
        } else if (textWidth >= 342) {
            fontSize = (defFontSize - decValue[11] - UppercaseDecValue) + "px";
            yPosition = defTextYPosition - 8;
            var dctest = decValue[11];
        } else if (textWidth >= 317) {
            fontSize = (defFontSize - decValue[10] - UppercaseDecValue) + "px";
            yPosition = defTextYPosition - 8;
            var dctest = decValue[10];
        } else if (textWidth >= 292) {
            fontSize = (defFontSize - decValue[9] - UppercaseDecValue) + "px";
            yPosition = defTextYPosition - 8;
            var dctest = decValue[9];
        } else if (textWidth >= 267) {
            fontSize = (defFontSize - decValue[8] - UppercaseDecValue) + "px";
            yPosition = defTextYPosition - 8;
            var dctest = decValue[8];
        } else if (textWidth >= 242) {
            fontSize = (defFontSize - decValue[7] - UppercaseDecValue) + "px";
            yPosition = defTextYPosition - 6;
            var dctest = decValue[7];
        } else if (textWidth >= 217) {
            fontSize = (defFontSize - decValue[6] - UppercaseDecValue) + "px";
            yPosition = defTextYPosition - 6;
            var dctest = decValue[6];
        } else if (textWidth >= 192) {
            fontSize = (defFontSize - decValue[5] - UppercaseDecValue) + "px";
            yPosition = defTextYPosition - 5;
            var dctest = decValue[5];
        } else if (textWidth >= 167) {
            fontSize = (defFontSize - decValue[4] - UppercaseDecValue) + "px";
            yPosition = defTextYPosition - 5;
            var dctest = decValue[4];
        } else if (textWidth >= 142) {
            fontSize = (defFontSize - decValue[3] - UppercaseDecValue) + "px";
            yPosition = defTextYPosition - 5;
            var dctest = decValue[3];
        } else if (textWidth >= 117) {
            fontSize = (defFontSize - decValue[2] - UppercaseDecValue) + "px";
            yPosition = defTextYPosition - 4;
            var dctest = decValue[2];
        } else if (textWidth >= 92) {
            fontSize = (defFontSize - decValue[1] - UppercaseDecValue) + "px";
            yPosition = defTextYPosition - 4;
            var dctest = decValue[1];
        } else if (textWidth >= 67) {
            fontSize = (defFontSize - decValue[0] - UppercaseDecValue) + "px";
            yPosition = defTextYPosition - 4;
            var dctest = decValue[0];
        } else {
            fontSize = (defFontSize - UppercaseDecValue) + "px";
            yPosition = defTextYPosition;
        }

        // console.log("# text width:", textWidth, "# font size:", fontSize, "# decValue:", dctest, "# uppercase value:", UppercaseDecValue);

        $("#qrFrameFontSize").val(fontSize);
        $("#frameTextYPosition").val(yPosition.toString());
        $("#qrFrameFontSize").data('qrFrameFontSize', fontSize);
        $("#frameTextYPosition").data('frameTextYPosition', yPosition);
    }

    // check iif the input text contains with emojis
    function containsEmoji(text) {
        var emojiRegex = /[\uD800-\uDBFF][\uDC00-\uDFFF]/g;
        return emojiRegex.test(text);
    }

    // QR code frame URL PATH and ID
    function getQRFromUrl(d) {
        $("#qr_frame_path").val(d.getAttribute("data-qrframeurl"));
        $("#qr_frame_id").val(d.getAttribute("data-qrframeid"));
        var qr_frame_id = d.getAttribute("data-qrframeid");
        let color = $("#frameTextColor").data('changeTextColor');
        let fontSize = $("#qrFrameFontSize").data('qrFrameFontSize');
        let textYPosition = $("#frameTextYPosition").data('frameTextYPosition');
        var qr_frames = [{
                id: 1,
                color: "#FFFFFF",
                defFontSize: "42",
                defTextYPosition: "8",
                UppercaseDecValue: "0",
                decValue: [8, 12, 14, 16, 18, 20, 22, 24, 25, 27, 28, 29, 31, 32]
            },
            {
                id: 2,
                color: "#FFFFFF",
                defFontSize: "42",
                defTextYPosition: "0",
                UppercaseDecValue: "0",
                decValue: [8, 12, 14, 16, 18, 20, 22, 24, 25, 27, 28, 29, 31, 32]
            },
            {
                id: 3,
                color: "#000000",
                defFontSize: "42",
                defTextYPosition: "2",
                UppercaseDecValue: "0",
                decValue: [8, 12, 14, 16, 18, 20, 22, 25, 26, 27, 28, 29, 31, 32]
            },
            {
                id: 4,
                color: "#000000",
                defFontSize: "42",
                defTextYPosition: "0",
                UppercaseDecValue: "0",
                decValue: [8, 12, 14, 16, 18, 20, 22, 25, 26, 27, 28, 29, 30, 31]
            },
            {
                id: 5,
                color: "#FFFFFF",
                defFontSize: "38",
                defTextYPosition: "0",
                UppercaseDecValue: "0",
                decValue: [8, 12, 14, 16, 18, 20, 22, 24, 25, 26, 27, 29, 30, 30]
            },
            {
                id: 6,
                color: "#FFFFFF",
                defFontSize: "42",
                defTextYPosition: "7",
                UppercaseDecValue: "0",
                decValue: [8, 12, 14, 16, 18, 20, 22, 25, 26, 27, 28, 29, 31, 32]
            },
            {
                id: 7,
                color: "#FFFFFF",
                defFontSize: "42",
                defTextYPosition: "0",
                UppercaseDecValue: "0",
                decValue: [8, 12, 14, 16, 18, 20, 22, 25, 26, 27, 28, 29, 31, 32]
            },
            {
                id: 8,
                color: "#000000",
                defFontSize: "42",
                defTextYPosition: "0",
                UppercaseDecValue: "0",
                decValue: [8, 12, 14, 16, 18, 20, 22, 25, 26, 27, 28, 29, 31, 32]
            },
            {
                id: 9,
                color: "#000000",
                defFontSize: "42",
                defTextYPosition: "0",
                UppercaseDecValue: "0",
                decValue: [8, 12, 14, 16, 18, 20, 22, 25, 26, 27, 28, 29, 31, 32]
            },
            {
                id: 10,
                color: "#FFFFFF",
                defFontSize: "42",
                defTextYPosition: "-6",
                UppercaseDecValue: "0",
                decValue: [8, 12, 14, 16, 18, 20, 22, 25, 26, 27, 28, 30, 31, 32]
            },
            {
                id: 11,
                color: "#FFFFFF",
                defFontSize: "42",
                defTextYPosition: "0",
                UppercaseDecValue: "0",
                decValue: [8, 12, 14, 16, 18, 20, 22, 25, 26, 27, 28, 29, 31, 32]
            },
            {
                id: 12,
                color: "#FFFFFF",
                defFontSize: "42",
                defTextYPosition: "0",
                UppercaseDecValue: "0",
                decValue: [8, 12, 15, 17, 20, 22, 24, 26, 27, 29, 29, 30, 31, 32]
            },
            {
                id: 13,
                color: "#000000",
                defFontSize: "55",
                defTextYPosition: "0",
                UppercaseDecValue: "11",
                decValue: [8, 12, 14, 16, 18, 20, 22, 25, 26, 27, 28, 29, 31, 32]
            },
            {
                id: 14,
                color: "#FFFFFF",
                defFontSize: "40",
                defTextYPosition: "0",
                UppercaseDecValue: "0",
                decValue: [8, 12, 15, 17, 20, 22, 24, 25, 26, 27, 28, 29, 30, 31]
            },
            {
                id: 15,
                color: "#000000",
                defFontSize: "44",
                defTextYPosition: "0",
                UppercaseDecValue: "0",
                decValue: [8, 11, 15, 17, 18, 19, 20, 22, 23, 24, 26, 27, 29, 30]
            },
            {
                id: 16,
                color: "#000000",
                defFontSize: "67",
                defTextYPosition: "0",
                UppercaseDecValue: "24",
                decValue: [8, 11, 15, 17, 18, 19, 20, 22, 23, 24, 26, 27, 29, 30]
            },
            {
                id: 17,
                color: "#000000",
                defFontSize: "42",
                defTextYPosition: "0",
                UppercaseDecValue: "0",
                decValue: [10, 12, 16, 20, 21, 22, 24, 26, 27, 28, 29, 30, 31, 32]
            },
            {
                id: 18,
                color: "#FFFFFF",
                defFontSize: "42",
                defTextYPosition: "0",
                UppercaseDecValue: "0",
                decValue: [10, 12, 15, 19, 20, 21, 23, 24, 25, 26, 27, 28, 30, 31]
            },
            {
                id: 19,
                color: "#FFFFFF",
                defFontSize: "42",
                defTextYPosition: "0",
                UppercaseDecValue: "0",
                decValue: [10, 12, 16, 19, 20, 21, 22, 25, 26, 27, 28, 29, 31, 32]
            },
            {
                id: 20,
                color: "#FFFFFF",
                defFontSize: "44",
                defTextYPosition: "0",
                UppercaseDecValue: "0",
                decValue: [9, 11, 14, 18, 20, 21, 22, 24, 25, 26, 27, 28, 30, 31]
            },
            {
                id: 21,
                color: "#000000",
                defFontSize: "42",
                defTextYPosition: "0",
                UppercaseDecValue: "0",
                decValue: [8, 10, 13, 16, 18, 20, 21, 23, 24, 25, 26, 27, 29, 30]
            },
            {
                id: 22,
                color: "#FFFFFF",
                defFontSize: "42",
                defTextYPosition: "3",
                UppercaseDecValue: "0",
                decValue: [8, 12, 16, 19, 20, 22, 23, 25, 26, 27, 28, 29, 31, 32]
            },
            {
                id: 23,
                color: "#000000",
                defFontSize: "42",
                defTextYPosition: "0",
                UppercaseDecValue: "0",
                decValue: [8, 11, 14, 16, 17, 18, 19, 21, 22, 23, 24, 25, 27, 28]
            },
            {
                id: 24,
                color: "#FFFFFF",
                defFontSize: "42",
                defTextYPosition: "0",
                UppercaseDecValue: "0",
                decValue: [8, 10, 13, 16, 17, 20, 21, 23, 24, 25, 26, 27, 29, 30]
            },
            {
                id: 25,
                color: "#FFFFFF",
                defFontSize: "42",
                defTextYPosition: "0",
                UppercaseDecValue: "0",
                decValue: [8, 10, 15, 18, 20, 22, 23, 25, 26, 27, 28, 29, 31, 32]
            },
            {
                id: 26,
                color: "#FFFFFF",
                defFontSize: "42",
                defTextYPosition: "0",
                UppercaseDecValue: "0",
                decValue: [8, 10, 15, 18, 20, 22, 23, 25, 26, 27, 28, 29, 31, 32]
            },
            {
                id: 27,
                color: "#FFFFFF",
                defFontSize: "42",
                defTextYPosition: "0",
                UppercaseDecValue: "0",
                decValue: [8, 10, 15, 18, 20, 21, 22, 24, 25, 26, 27, 28, 30, 31]
            },
            {
                id: 28,
                color: "#FFFFFF",
                defFontSize: "42",
                defTextYPosition: "0",
                UppercaseDecValue: "0",
                decValue: [8, 10, 15, 18, 20, 22, 23, 25, 26, 27, 28, 29, 31, 32]
            },
            {
                id: 29,
                color: "#FFFFFF",
                defFontSize: "40",
                defTextYPosition: "0",
                UppercaseDecValue: "0",
                decValue: [8, 10, 14, 16, 18, 20, 21, 23, 24, 25, 26, 27, 29, 30]
            },
            {
                id: 30,
                color: "#000000",
                defFontSize: "42",
                defTextYPosition: "0",
                UppercaseDecValue: "0",
                decValue: [8, 10, 14, 16, 18, 20, 22, 23, 24, 25, 26, 27, 28, 29]
            },
            {
                id: 31,
                color: "#FFFFFF",
                defFontSize: "42",
                defTextYPosition: "0",
                UppercaseDecValue: "0",
                decValue: [8, 10, 14, 16, 18, 20, 22, 24, 25, 26, 27, 28, 30, 31]
            },
        ];
        const qr_frame_data = qr_frames.filter((data) => {
            return data.id == qr_frame_id ? true : false;
        });


        if (color) {
            $('#frameTextColor').val(color);
        } else {
            $('#frameTextColor').val(qr_frame_data[0]?.color);
        }


        $('#qrFrameFontSize').attr('defaultFontSize', qr_frame_data[0]?.defFontSize);
        $('#frameTextYPosition').attr('deftextYPosition', qr_frame_data[0]?.defTextYPosition);
        $('#UppercaseDecValue').val(qr_frame_data[0]?.UppercaseDecValue);
        $('#decValue').val(qr_frame_data[0]?.decValue);

        if (fontSize) {
            $('#qrFrameFontSize').val(fontSize);
        } else {
            $('#qrFrameFontSize').val(qr_frame_data[0]?.defFontSize + "px");
            $('#frameTextYPosition').val(qr_frame_data[0]?.defTextYPosition);
        }

        var defFontSize = parseInt(qr_frame_data[0]?.defFontSize);
        var defTextYPosition = parseInt(qr_frame_data[0]?.defTextYPosition);
        var UppercaseDecValue = parseInt(qr_frame_data[0]?.UppercaseDecValue);
        var decValue = qr_frame_data[0]?.decValue;

        changeFrameFontSize(defFontSize, defTextYPosition, UppercaseDecValue, decValue);

        // $(".qr-frame-text-field").trigger("click");

        document.getElementById("qr_frame_id").value = d.getAttribute("data-qrframeid");
        var div = document.getElementById("newpost");
        if ((d.getAttribute("data-qrframeid")) != 0) {
            div.style.display = "block";
        } else {
            div.style.display = "none";
        }
        document.getElementById("qr_frame_path").value = d.getAttribute("data-qrframeurl");

        $("#qr_frame_id_tmp").click();
        // $("#qr_frame_path_tmp").click();
    }

    $(document).on('click', '#step3 .custom-accodian', function() {
        if (qr_status == "1") {
            var changeTextColor = $("#frameTextColor").val();
            if (changeTextColor == '#ffffff' || changeTextColor == '#000000') {
                return
            } else {
                $("#frameTextColor").data('changeTextColor', changeTextColor);
            }
        }
    });
</script>

<script type="text/javascript">
    document.getElementById("iframesrc").style.visibility = "visible";
    document.getElementById("loader").style.display = "none";
</script>

<script>
    $(document).ready(function() {
        $("#isGradientSelected").change(function() {
            var selectedOption = $("#isGradientSelected").val()
            if (selectedOption == 'gradient') {

                $('#gradient').show();
            } else {
                $('#gradient').hide();
            }
        });
    });

    $(document).ready(function() {
        $("#isFrameGradientSelected").change(function() {
            var selectedOption = $("#isFrameGradientSelected").val()
            if (selectedOption == 'gradient') {
                $('#gradient').show();
            } else {
                $('#gradient').hide();
            }
        });
    });
    $(document).ready(function() {
        $("#isBackgroundGradientSelected").change(function() {
            var selectedOption = $("#isBackgroundGradientSelected").val()
            if (selectedOption == 'gradient') {

                $('#gradient').show();
            } else {
                $('#gradient').hide();
            }
        });
    });
    if ($("#2").is('[disabled=disabled]')) {
        $("#2").addClass("disable-btn")

    } else {
        $("#2").removeClass("disable-btn")

    }
</script>

<script>
    $("#social").hide();

    function remove_me(elm) {
        $(elm).parent().parent().remove();
        LoadPreview();
    }

    function remove_me_up(elm) {
        $(elm).parent().parent().parent().remove();
        LoadPreview();
    }
    $(document).on('click', '.contact-delete-btn', function() {
        $(this).parents('.contact-block-wrp').remove();
        console.log($(this).parent('.contact-block-wrp'));
        $(".addRowButton2").removeClass('add-phone-btn-active');
        $(".addRowButton2").addClass('add-phone-btn');
        $(".email-add").removeClass('add-phone-btn-active');
        $(".email-add").addClass('add-email-btn');
        LoadPreview();
    });
    $(document).on('click', '.removable-delete-btn', function() {
        $(this).parents('.removable-block-wrp').remove();
        LoadPreview();
    });

    $(document).on('change', '#contactWebsite', function() {
        var contactWebsite = $("input[name=\"contactWebsite\"]").val();

        if (contactWebsite) {
            if (/^(http|https|ftp):\/\/[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,}(:[0-9]{1,})?(\/.*)?$/i.test(contactWebsite)) {
                // $("#contactWebsite").css("border", "2px solid #96949C");
                $('#contactWebsite').parent().find(".invalid_err").remove();
            } else if (/^[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,}(:[0-9]{1,})?(\/.*)?$/i.test(contactWebsite)) {
                // $("#contactWebsite").css("border", "2px solid #96949C");
                $('#contactWebsite').parent().find(".invalid_err").remove();
            } else {
                $('#contactWebsite').parent().find(".invalid_err").remove();
                allAreFilled = false;
                $("#contactWebsite").css("border", "2px solid red");
                $("<span class=\"invalid_err\" style=\"margin-left:15px; position: absolute;\"><?= l('qr_step_2.url_error') ?></span>").insertAfter($("#contactWebsite"));
            }

        } else {
            $('#contactWebsite').parent().find(".invalid_err").remove();
            // $("#contactWebsite").css("border", "2px solid #96949C");
        }

    });

    $(document).on('change', '#offer_url1', function() {
        var offer_url1 = $("input[name=\"offer_url1\"]").val();

        if (offer_url1) {
            if (/^(http|https|ftp):\/\/[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,}(:[0-9]{1,})?(\/.*)?$/i.test(offer_url1)) {
                $("#offer_url1").css("border", "2px solid #96949C");
                $('#offer_url1').parent().find(".invalid_err").remove();
            } else if (/^[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,}(:[0-9]{1,})?(\/.*)?$/i.test(offer_url1)) {
                $("#offer_url1").css("border", "2px solid #96949C");
                $('#offer_url1').parent().find(".invalid_err").remove();
            } else {
                $('#offer_url1').parent().find(".invalid_err").remove();
                allAreFilled = false;
                $("#offer_url1").css("border", "2px solid red");
                $("<span class=\"invalid_err\" style=\"margin-left:15px;\"><?= l('qr_step_2.url_error') ?></span>").insertAfter($("#offer_url1"));
            }

        } else {
            $('#offer_url1').parent().find(".invalid_err").remove();
            $("#offer_url1").css("border", "2px solid #96949C");
        }

    });


    $(document).on("change", ".contactMobiles", function() {
        var contactMobiles = $(this).val();
        if (contactMobiles) {
            $(this).css("border", "2px solid #96949C");
            $(this).parent().find(".invalid_err").remove();

        } else {
            $(this).css("border", "2px solid red");
            $("<span class=\"invalid_err\" style=\"margin-left:15px;\"><?= l('qr_step_2.required_error') ?></span>").insertAfter($(this));
            allAreFilled = false;
        }

    });



    // primary color validation
    $(document).on("change keyup", ".primaryColorValue", function() {
        var primaryColorValue = ($(this).val()).trim();
        $(".primary-color-picker").parent().find(".invalid_err").remove();

        if (primaryColorValue) {
            if (/^#[0-9A-F]{6}$/i.test(primaryColorValue)) {
                $(this).parent().parent().css("border", "2px solid #96949C");
                $(".primary-color-picker").parent().find(".invalid_err").remove();
            } else {

                $(this).parent().parent().css("border", "2px solid red");
                $("<span class=\"invalid_err color-error\"><?= l('qr_step_2.invalid_code_error') ?></span>").insertAfter($(this).parent().parent());
                allAreFilled = false;
            }
        }

    });

    // secondary color validation
    $(document).on("change keyup", ".secondaryColorValue", function() {
        var secondaryColorValue = ($(this).val()).trim();
        $(".secondary-color-picker").parent().find(".invalid_err").remove();

        if (secondaryColorValue) {
            if (/^#[0-9A-F]{6}$/i.test(secondaryColorValue)) {
                $(this).parent().parent().css("border", "2px solid #96949C");
                $(".secondary-color-picker").parent().find(".invalid_err").remove();
            } else {

                $(this).parent().parent().css("border", "2px solid red");
                $("<span class=\"invalid_err color-error\"><?= l('qr_step_2.invalid_code_error') ?></span>").insertAfter($(this).parent().parent());
                allAreFilled = false;
            }
        }

    });

    // link color validation
    $(document).on("change keyup", ".linkColorValue", function() {
        var linkColorValue = ($(this).val()).trim();
        $(".link-color-picker").parent().find(".invalid_err").remove();

        if (linkColorValue) {
            if (/^#[0-9A-F]{6}$/i.test(linkColorValue)) {
                $(this).parent().parent().css("border", "2px solid #96949C");
                $(".link-color-picker").parent().find(".invalid_err").remove();
            } else {

                $(this).parent().parent().css("border", "2px solid red");
                $("<span class=\"invalid_err color-error\"><?= l('qr_step_2.invalid_code_error') ?></span>").insertAfter($(this).parent().parent());
                allAreFilled = false;
            }
        }

    });


    // step3 color validation
    $(document).on("change keyup", ".st3cv", function() {
        var colorValue = ($(this).val()).trim();
        $(this).parent().parent().find(".invalid_err").remove();

        if (colorValue) {
            if (/^#[0-9A-F]{6}$/i.test(colorValue)) {
                $(this).parent().css("border", "2px solid #96949C");
                $(this).parent().parent().find(".invalid_err").remove();
            } else {
                $(this).parent().css("border", "2px solid red");
                $("<span class=\"invalid_err color-error\"><?= l('qr_step_3.invalid_code_error') ?></span>").insertAfter($(this).parent());
            }
        }

    });


    $(document).on("change", ".contactEmails", function() {
        var contactEmails = $(this).val();
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        if (contactEmails) {

            if (!emailReg.test(contactEmails)) {
                $(this).parent().find(".invalid_err").remove();
                allAreFilled = false;
                $(this).css("border", "2px solid red");
                $("<span class=\"invalid_err\" style=\"margin-left:15px;\"><?= l('qr_step_2.email_not_valid') ?></span>").insertAfter($(this));
            } else {
                $(this).css("border", "2px solid #96949C");
                $(this).parent().find(".invalid_err").remove();
            }

        } else {
            $(this).parent().find(".invalid_err").remove();
            $(this).css("border", "2px solid red");
            $("<span class=\"invalid_err\" style=\"margin-left:15px;\"><?= l('qr_step_2.required_error') ?></span>").insertAfter($(this));
            allAreFilled = false;
        }

    });


    // social networks validation
    $(document).on('change ', '.socialUrl', function() {
        var data_val = $(this).data('attr');

        var urlvalue = $(this).val();

        var dataUrl = $(this).data('attr');

        let expression = /^(http|https|ftp):\/\/[-a-zA-Z0-9@:%_\+.~#?&//=]{1,256}\.[a-z]{2,}\b(\/[-a-zA-Z0-9@:%_\+.~#?&//=]*)?/gi;
        if (this.id == 'socialUrl') {
            expression = /[-a-zA-Z0-9@:%_\+.~#?&//=]{1,256}\.[a-z]{2,}\b(\/[-a-zA-Z0-9@:%_\+.~#?&//=]*)?/gi;
        }
        var regex = new RegExp(expression);

        $(this).parent().find(".invalid_err").remove();
        $(this).css("border", "2px solid #96949C");

        if (urlvalue == "") {
            $(this).css("border", "2px solid red")
            $("<span class=\"invalid_err\"><?= l('qr_step_2.required.error') ?></span>").insertAfter($(this))
            $(".invalid_err").attr("style", "display: block !important;");

            allAreFilled = false;
        } else {
            if (!urlvalue.match(regex)) {
                if (!dataUrl) {
                    $(this).parent().find(".invalid_err").remove();
                    $(this).css("border", "2px solid red")
                    $("<span class=\"invalid_err\"><?= l('qr_step_2.url_error') ?></span>").insertAfter($(this))
                    $(".invalid_err").attr("style", "display: block !important;");
                    allAreFilled = false;
                }

                if (dataUrl == '') {
                    // $("<span class=\"invalid_err\"><?= l('qr_step_2.required.error') ?></span>").insertAfter($(this))
                    $(".invalid_err").attr("style", "display: block !important;");
                    allAreFilled = false;
                } else {
                    $(this).css("border", "2px solid #96949C");
                    $(this).parent().find(".invalid_err").remove();
                }


            } else {
                $(this).css("border", "2px solid #96949C");
                $(this).parent().find(".invalid_err").remove();
            }
        }

    });



    //developed by XL Developer 16-01-2023
    function text_counter(event, element, tLimit = 250) {
        var innerData = $(element).val();
        var tlength = parseInt((innerData.trim()).length);
        if (tlength >= tLimit) {
            event.preventDefault();

        }

        if (tlength > tLimit) {
            let result_sub = innerData.substring(0, tLimit);
            $(element).val(result_sub);
        }
    }




    $(document).on("mouseover", ".radio-button", function() {
        changeUrl('<?php url('qr/') ?>' + $(this).val(), this);
        $(this).parents('.create-card').addClass('active');
        $(this).parents('.create-card').siblings().removeClass('active');

        $('#qr-preview').css("display", "none");
        $('#iframesrc').css("display", "block");

        document.getElementById('iframesrc').contentWindow.postMessage({
            live: true,
            type: $(this).val() == 'url' ? 'website' : $(this).val(),
            step:1
        },'<?=LANDING_PAGE_URL?>');
    });

    $(document).on("mouseout", ".radio-button", function() {

        var c_step = $("input[name=\"step_input\"]").val();
        if (c_step == 1) {
            // $("#qr-preview").prop('src', '<?php echo ASSETS_FULL_URL; ?>images/funnel-default-phone-mockup-2.webp');
            $(".default-preview-text").css("display", "none");
            $(this).parents('.create-card').removeClass('active');
            $('#qr-preview').css("display", "none");
            $('#iframesrc').css("display", "block");

            document.getElementById('iframesrc').contentWindow.postMessage({live:true,type:'default',step:1},'<?=LANDING_PAGE_URL?>');
        }


    });
</script>

<script type="text/javascript">
    window.onbeforeunload = function() {
        var text = "Leave QR";
        return text;
    }


    document.addEventListener('dblclick', function(event) {
        event.preventDefault();
    }, {
        passive: false
    });
</script>


<script>
    function dummy() {}
    window.dummy = dummy;
</script>

<script>
    $(document).on('click', '.imgAddRowBtn', function() {
        var parent = $(this).closest('.collapseInner');

        var row = `<div class="step-form-group  addRow button-wrp mb-3">
                       
                            <label for="contactMobiles">  <?= l('qr_step_2_images.input.button') ?> <span class="text-danger text-bold">*</span></label>
                            <div class="d-flex align-items-center w-100">
                                <div class="d-flex align-items-center w-100 form-fields-wrp img-buttons">
                                    <div class="w-75 btn-text mr-3"><input class="form-control mr-3" onchange="LoadPreview()" type="text" id="button_text" name="button_text[]" placeholder="<?= l('qr_step_2_images.input.button_text.placeholder') ?>" required input_validate/> </div>
                                    <div class="w-100 btn-url mr-3"><input class="form-control mr-3" onchange="LoadPreview()" type="url" id="button_url" name="button_url[]" placeholder="<?= l('qr_step_2_images.input.button_url.placeholder') ?>" required input_validate/></div>
                                </div>
                                <button class="reapeterCloseIcon removeBtn imgRemoveBtn" type="button" onclick="remove_me(this)">
                                    <span class="icon-trash remove-btn-icon"></span>
                                </button>
                            </div>
                      
                    </div>`;
        $(row).insertAfter(parent.find('.addRow:last'));
        //prevent page redirect on keypress
        $('input').keypress(function(e) {
            if (event.keyCode == 13) {
                event.preventDefault();
            }
        })
        LoadPreview();
    });

    $(document).on('click', '.imgRemoveBtn', function() {
        $(this).closest('.borderSection').remove()
        $('.imgAddRowBtn').show();
    });


    $(document).on('click', '.busAddRowBtn', function() {
        var parent = $(this).closest('.collapseInner');
        var clone = parent.find('.addRow:first').clone(true)
        $(clone).insertAfter(parent.find('.addRow:last'));

        var rmvBtnHtml = `<div class="form-group step-form-group button-wrp" id="btn-section">
                        <label for="contactMobiles"> <?= l('qr_step_2_business.input.button') ?></label>
                        <div class="d-flex align-items-center w-100">
                            <div class="d-flex align-items-center w-100 form-fields-wrp">
                                <div class="w-75 btn-text mr-3">
                                    <input data-anchor="websiteLink" class="anchorLoc form-control mr-3" type="text" id="businessButtons" name="businessButtons"  placeholder="<?= l('qr_step_2_business.input.businessButtons.placeholder') ?>" required="required" />
                                </div>
                                <div class="w-100 btn-url mr-3">
                                    <input data-anchor="websiteLink" class="anchorLoc form-control mr-3" type="url" id="businessButtonUrls" name="businessButtonUrls"  placeholder="<?= l('qr_step_2_business.input.businessButtonUrls.placeholder') ?>" required="required" />
                                </div>
                            </div>
                            <button type="button" class="reapeterCloseIcon removeBtn busRemoveBtn" onclick="showButton(this)">
                                <span class="icon-trash remove-btn-icon"></span>
                            </button>
                        </div>
                    </div>`;
        $('#add-btn').append(rmvBtnHtml);
        //prevent page redirect on keypress
        $('input').keypress(function(e) {
            if (event.keyCode == 13) {
                event.preventDefault();
            }
        })
        $(clone).find('div.row').append(rmvBtnHtml);
        $(".busAddRowBtn").remove();
        LoadPreview();

    });

    $(document).on('click', '.busRemoveBtn', function() {
        $("#btn-section").remove();
        $("#btn-item2").append(`<button id="add" style="text-align: center;" type="button" class="outlineBtn addRowButton busAddRowBtn all-add-btn"><span class="icon-add-barcode start-icon save-btn-icon"></span> <?= l('qr_step_2_business.input.addButton') ?></button>`)
        $(this).closest('.borderSection').remove();
        LoadPreview();
    });


    $(document).on('click', '.mp3AddRowBtn', function() {

        var rmvBtnHtml = `<div class="form-group step-form-group m-0 button-wrp" id="btn-section">
                        <label for="contactMobiles"> <?= l('qr_step_2_mp3.input.button') ?></label>
                        <div class="d-flex m-auto align-items-center w-100">
                            <div class="d-flex align-items-center w-100 form-fields-wrp">
                                <div class="w-75 btn-text mr-3">
                                    <input class="form-control mp3-btn-field-text mr-1" type="text" name="button_text" id="button_text" placeholder="<?= l('qr_step_2_mp3.input.button_text.placeholder') ?>" required="required" />
                                </div>
                                <div class="w-100 btn-url mr-3">
                                    <input class="form-control mp3-btn-field-url" type="url" name="button_url" id="button_url" placeholder="<?= l('qr_step_2_mp3.input.button_url.placeholder') ?>" required="required" />
                                </div>
                            </div>
                            <button type="button" class="reapeterCloseIcon removeBtn mp3RemoveBtn">
                              <span class="icon-trash remove-btn-icon"></span>
                            </button>
                        </div>
                    </div>`;
        $('#add-btn').append(rmvBtnHtml);
        //prevent page redirect on keypress
        $('input').keypress(function(e) {
            if (event.keyCode == 13) {
                event.preventDefault();
            }
        })

        $(".mp3AddRowBtn").remove();
        LoadPreview();
    });

    $(document).on('click', '.mp3RemoveBtn', function() {
        $("#btn-section").remove();
        $("#btn-item").append(`<button id="add" style="text-align: center;" type="button" class="all-add-btn outlineBtn addRowButton mp3AddRowBtn"><span class="icon-add-square start-icon add-btn-icon"></span> <span><?= l('qr_step_2_mp3.input.addButton') ?></span></button>`)
        $(this).closest('.borderSection').remove();
        LoadPreview();
    });


    $(document).on('click', '#add11', function() {
        var rmvBtnHtml = `<div class="form-group mt-0 mx-0 mobile-field removable-block-wrp" style=\"margin-bottom:25px; \">
                            <div class="row m-auto align-items-center w-100 web-form-group form-group">
                                <div class="row col-11 contact-field-full-wrap web-field-full-wrap align-items-center w-100 position-relative form-group">
                                    <div class="col-6 flex-grow-1 lable-wrap">
                                    <label for="contactMobiles" class="filed-label"><?= l('qr_step_2_com_contact_info.phone_label') ?></label>
                                    <input data-anchor="contactsBlock" class="anchorLoc step-form-control" type="text" id="contactMobileTitles" onchange="LoadPreview()" name="contactMobileTitles[]" placeholder="<?= l('qr_step_2_business.input.contactMobileTitles.placeholder') ?>" data-reload-qr-code />
                                    </div>
                                    <div class="col-6 flex-grow-1 relative contact-field-wrap">
                                    <label for="contactMobiles" class="filed-label"><?= l('qr_step_2_com_contact_info.phone_number') ?></label>
                                    <input data-anchor="contactsBlock" class="anchorLoc step-form-control contactMobiles d-flex" type="tel" id="contactMobiles" name="contactMobiles[]" onchange="LoadPreview()" placeholder="<?= l('qr_step_2_business.input.contactMobiles.placeholder') ?>" data-reload-qr-code style="border:2px solid red" />
                                    <span class=\"invalid_err\" style=\"margin-left:15px; position:absolute; \"><?= l('qr_step_2.required_error') ?></span>
                                    </div>
                                </div>
                                <div class="delete-contact-btn-wrap col-1 phone-row form-group">
                                    <button type="button" class="reapeterCloseIcon removable-delete-btn removeBtnPhone contact-delete-btn" >
                                    <span class="icon-trash grey delete-mark d-flex"></span>
                                    </button>
                                </div>
                            </div>
                        </div>`;
        $('#phn-block').append(rmvBtnHtml);
        phoneNumber++
        //prevent page redirect on keypress
        $('input').keypress(function(e) {
            if (event.keyCode == 13) {
                event.preventDefault();
            }
        });
        LoadPreview();
    });

    $(document).on('click', '#add12', function() {
        var rmvBtnHtml = `<div class="form-group email-field  removable-block-wrp" id="email1"  style=\"margin-bottom:25px; \">
                            <div class="row m-auto align-items-center  web-form-group  w-100 form-group">

                                <div class="row col-11 contact-field-full-wrap align-items-center w-100 form-group position-relative">

                                    <div class="col-6 flex-grow-1 lable-wrap">
                                    <label for="contactEmails" class="filed-label"><?= l('qr_step_2_com_contact_info.phone_label') ?></label>
                                        <input data-anchor="contactsBlock" class="anchorLoc step-form-control" type="text" id="contactEmailTitles" onchange="LoadPreview()" name="contactEmailTitles[]" placeholder="<?= l('qr_step_2_business.input.contactEmailTitles.placeholder') ?>" />
                                    </div>
                                    <div class="col-6 flex-grow-1 relative contact-field-wrap">
                                    <label for="contactEmails" class="filed-label"><?= l('qr_step_2_com_contact_info.email') ?></label>
                                         <input data-anchor="contactsBlock" class="anchorLoc step-form-control d-flex contactEmails" type="email" id="contactEmails" onchange="LoadPreview()" name="contactEmails[]" placeholder="<?= l('qr_step_2_business.input.contactEmails.placeholder') ?>" style="border:2px solid red"  />
                                         <span class=\"invalid_err\" style=\"margin-left:15px; position:absolute; \"><?= l('qr_step_2.required_error') ?></span>
                                    </div>
                                </div>
                                <div class="delete-contact-btn-wrap col-1 phone-row form-group">
                                    <button type="button" class="reapeterCloseIcon removable-delete-btn removeBtnEmail contact-delete-btn" >
                                        <span class="icon-trash grey delete-mark d-flex"></span>
                                    </button>
                                </div>
                            </div>
                        </div>`;
        $('#email-block').append(rmvBtnHtml);
        // onclick="remove_me(this)"
        emailNumber++
        //prevent page redirect on keypress
        $('input').keypress(function(e) {
            if (event.keyCode == 13) {
                event.preventDefault();
            }
        });
        LoadPreview();
    });

    // $(".reapeterCloseIcon ").click(function () {
    //     console.log($(this));
    //     LoadPreview();
    // });

    $(document).on('click', '.vcard-add-phone', function() {
        var rmvBtnHtml = `
                        <div class="d-flex align-items-end mb-3 vcard-contact-info removable-block-wrp">
                        
                        <div class="d-flex  w-100 flex-column">
                        <div class="d-flex align-items-end w-100 form-fileds-wrp">
                        
                        <div class="w-75 label-input-wrp input-with-icon">
                        <label for="filters_address_by" class="fieldLabel"><?= l('qr_step_2_vcard.phone_label') ?> </label>
                        <span class="icon-qr-label input-icon add-label-icon"></span>
                        <input type="text" id="vcard_phoneLabel" name="vcard_phoneLabel[]"   placeholder="<?= l('qr_step_2_vcard.input.vcard_phoneLabel.placeholder') ?>" data-anchor="vcardPhone" class="anchorLoc form-control mr-2" data-reload-qr-code />
                        </div>

                        <div class="w-100 data-input-wrp input-with-icon-drop">
                            <div class="icon-text-wrap">
                            <span class="icon-dropdown-text"><?= l('qr_step_2_vcard.phone_number.dropdown') ?></span><label for="filters_address_by" class="fieldLabel"><?= l('qr_step_2_vcard.phone_number') ?> </label>
                            </div>
                            <div class="apto-dropdown-wrapper">
                                <button class="form-control apto-trigger-dropdown">
                                <span class="icon-call drp-icon cell"></span>
                                
                                </button>
                                <div class="dropdown-menu filters_address_by phone_type` + (phoneNumber + 1).toString() + `" data-selected="mobile-phone">
                                <input type="hidden" value='mobile-phone' name="vcard_phoneIcon[]" >
                                <input type="hidden" value='<span class="icon-call drp-icon cell"></span>' name="vcard_phoneSvg[]" >
                                    <button type="button" value="mobile-phone" tabindex="0" class="dropdown-item">
                                        <span class="icon-mobile drp-icon cell"></span>
                                        <span class="break-text"><?= l('qr_step_2_vcard.label_mobile_phone') ?></span>
                                    </button>
                                    <button type="button" value="home" tabindex="0" class="dropdown-item">
                                        <span class="icon-house drp-icon home"></span>
                                        <span class="break-text"><?= l('qr_step_2_vcard.label_home') ?></span>
                                    </button>
                                    <button type="button" value="work" tabindex="0" class="dropdown-item">
                                        <span class="icon-buildings drp-icon work"></span>
                                        <span class="break-text"><?= l('qr_step_2_vcard.label_work') ?></span>
                                    </button>
                                    <button type="button" value="fax" tabindex="0" class="dropdown-item">
                                    <span class="icon-fax drp-icon fax"></span>
                                        <span class="break-text"><?= l('qr_step_2_vcard.label_fax') ?></span>
                                    </button>
                                    <button type="button" value="other" tabindex="0" class="dropdown-item">
                                        <span class="icon-call drp-icon other"></span>
                                        <span class="break-text"><?= l('qr_step_2_vcard.label_other') ?></span>
                                    </button>
                                </div>
                            </div>
                        <input type="text" id="vcard_phone" name="vcard_phone[]"   placeholder="<?= l('qr_step_2_vcard.input.vcard_phone.placeholder') ?>" data-anchor="vcardPhone" class="anchorLoc form-control mr-2" maxlength="<?= $data->qr_code_settings['type']['vcard']['phone']['max_length'] ?>" data-reload-qr-code />
                        </div>
                                <button class="reapeterCloseIcon delete-btn removable-delete-btn vcard-remove" type="button" >
                                    <span class="icon-trash"></span>
                                </button>
                            </div>
                        </div>

                      
                    </div>
                        `;
        $('#phoneBlock').append(rmvBtnHtml);
        phoneNumber++
        LoadPreview();
    });
    $(document).on('click', '.vcard-add-email', function() {
        var rmvBtnHtml = `
        <div class="d-flex align-items-end mb-4 vcard-contact-info removable-block-wrp">
        <div class="d-flex  w-100 flex-column">
       
                            <div class="d-flex align-items-end w-100 form-fileds-wrp">
                            <div class="w-75 label-input-wrp input-with-icon ">
                                <label for="vcard_email" class="fieldLabel"><?= l('qr_step_2_vcard.email_label') ?></label>
                                <span class="icon-qr-label input-icon add-label-icon"></span>
                                <input type="text" id="vcard_emailLabel" placeholder="<?= l('qr_step_2_vcard.input.vcard_emailLabel.placeholder') ?>" name="vcard_emailLabel[]"   data-anchor="vcardEmail" class="anchorLoc form-control mr-3" maxlength="<?= $data->qr_code_settings['type']['vcard']['email']['max_length'] ?>" data-reload-qr-code />
                                </div>
                                <div class="w-100 data-input-wrp input-with-icon">
                                <span class="icon-email input-icon"></span>
                                <label for="vcard_email" class="fieldLabel"><?= l('qr_step_2_vcard.type.email') ?></label>
                                <input type="email" id="vcard_email" placeholder="<?= l('qr_step_2_vcard.input.vcard_email.placeholder') ?>" name="vcard_email[]"   data-anchor="vcardEmail" class="anchorLoc form-control mr-3" maxlength="<?= $data->qr_code_settings['type']['vcard']['email']['max_length'] ?>" data-reload-qr-code />
                                </div>
                                <button class="reapeterCloseIcon delete-btn removable-delete-btn vcard-remove" type="button" >
                                        <span class="icon-trash"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                        `;
        $('#emailBlock').append(rmvBtnHtml);
        emailNumber++
        LoadPreview();
    });
    $(document).on('click', '.vcard-add-web', function() {
        var rmvBtnHtml = `
        <div class="d-flex align-items-end mb-3 vcard-contact-info removable-block-wrp">
        <div class="d-flex  w-100 flex-column">
                        
                            <div class="d-flex align-items-end w-100 form-fileds-wrp">
                            <div class="w-75 label-input-wrp input-with-icon">
                            <label for="vcard_email" class="fieldLabel"><?= l('qr_step_2_vcard.web_label') ?></label>
                            <span class="icon-qr-label input-icon add-label-icon"></span>
                                <input type="text" id="vcard_website_title" placeholder="<?= l('qr_step_2_vcard.input.vcard_website_title.placeholder') ?>" name="vcard_website_title[]"   data-anchor="vcardWeb" class="anchorLoc form-control mr-3" maxlength="<?= $data->qr_code_settings['type']['vcard']['email']['max_length'] ?>" data-reload-qr-code />
                                </div>
                                <div class="w-100 data-input-wrp input-with-icon">
                                <label for="vcard_url" class="fieldLabel"><?= l('qr_step_2_vcard.personal_web') ?></label>
                                <span class="icon-global input-icon"></span>
                                <input type="url" id="vcard_website" placeholder="<?= l('qr_step_2_vcard.input.vcard_website.placeholder') ?>" name="vcard_website[]"   data-anchor="vcardWeb" class="anchorLoc form-control mr-3" maxlength="<?= $data->qr_code_settings['type']['vcard']['email']['max_length'] ?>" data-reload-qr-code />
                                </div>
                                <button class="reapeterCloseIcon delete-btn removable-delete-btn vcard-remove" type="button">
                                    <span class="icon-trash"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                        `;
        $('#websiteBlock').append(rmvBtnHtml);
        websiteNumber++


        LoadPreview();
    });


    $(document).ready(function() {

        $(document).click(function() {
            $('.dropdown-menu.show').removeClass('show');
        });

        $('body').on('click', '.apto-trigger-dropdown', function(e) {
            e.preventDefault();

            e.stopPropagation();


            $(this).closest('.apto-dropdown-wrapper').find('.dropdown-menu').toggleClass('show');
        });


        $('body').on('click', '.dropdown-item', function(e) {

            e.stopPropagation();

            let $selectedValue = $(this).val();
            let $icon = $(this).find('span');
            let $btn = $(this).closest('.apto-dropdown-wrapper').find('.apto-trigger-dropdown');

            $(this).closest('.apto-dropdown-wrapper').find('.dropdown-menu').removeClass('show').attr('data-selected', $selectedValue);

            $btn.find('span').remove();
            $btn.prepend($icon[0].outerHTML);
            console.log($icon[0].outerHTML);
            console.log($selectedValue);
            // $btn.prepend('<i class="fas fa-caret-down"></i>');

            $(this).closest('.apto-dropdown-wrapper').find("input[name='vcard_phoneIcon[]']").val($selectedValue);
            $(this).closest('.apto-dropdown-wrapper').find("input[name='vcard_phoneSvg[]']").val($icon[0].outerHTML);

            LoadPreview();
        });

    });
</script>




<script>
    $(document).on('keyup change paste', 'input, select, textarea', "#acc_welcomeScreen", function() {
        if ($("input[name=\"step_input\"]").val() == 2) {
            $("#tabs-1").addClass("active");
            $("#tabs-2").removeClass("active");
            $("#2").removeClass("active");
            $("#1").addClass("active");

        }
        // console.log('dsfasdf adfsg fd gsdfgh sfhjslkdfghlksdfg');
    });


    $(document).on('click', '#manualyBtn', function() {

        if (!manualClicked) {
            var contentHtml = `  

                <div class="d-flex align-items-center mb-3">
                    <div class="custom-control custom-switch customSwitchToggle">
                        <input checked onchange="LoadPreview()" type="checkbox" class="custom-control-input" id="customSwitchToggle" name="street_number">
                        <label onchange="LoadPreview()" class="custom-control-label anchorLoc" data-anchor="LocationBlock" id="custom_checkbox" for="customSwitchToggle"><?= l('qr_step_2_com_location.street_number_first') ?></label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 pr-2 street-field-wrap">
                        <div class="form-group">
                            <label for="offer_street"><?= l('qr_step_2_com_location.street') ?></label>
                            <input id="route" onchange="LoadPreview()" placeholder="<?= l('qr_step_2_com_location.street.placeholder') ?>" name="offer_street" class="step-form-control anchorLoc" value="" data-anchor="LocationBlock" data-reload-qr-code="">
                        </div>
                    </div>
                    <div class="col-6 pl-2 number-postal-wrap">
                        <div class="row number-full-wrap">
                            <div class="col-6 pr-2">
                                <div class="form-group">
                                    <label for="offer_number"><?= l('qr_step_2_com_location.number') ?></label>
                                    <input id="street_number" onchange="LoadPreview()" placeholder="<?= l('qr_step_2_com_location.number.placeholder') ?>" name="offer_number" class="step-form-control anchorLoc" value="" data-anchor="LocationBlock" data-reload-qr-code="">
                                </div>
                            </div>
                            <div class="col-6 pl-2">
                                <div class="form-group">
                                    <label for="offer_postalcode"><?= l('qr_step_2_com_location.postal_code') ?></label>
                                    <input id="postal_code" onchange="LoadPreview()" placeholder="<?= l('qr_step_2_com_location.postal_code.placeholder') ?>" name="offer_postalcode" class="step-form-control anchorLoc" value="" data-anchor="LocationBlock" data-reload-qr-code="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 pr-2">
                        <div class="form-group">
                            <label for="offer_city"><?= l('qr_step_2_com_location.city') ?></label>
                            <input id="locality" onchange="LoadPreview()" placeholder="<?= l('qr_step_2_com_location.city.placeholder') ?>" name="offer_city" class="step-form-control anchorLoc" value="" data-anchor="LocationBlock" data-reload-qr-code="">
                        </div>
                    </div>
                    <div class="col-6 pl-2">
                        <div class="form-group">
                            <label for="offer_state"><?= l('qr_step_2_com_location.state') ?></label>
                            <input id="administrative_area_level_1" onchange="LoadPreview()" placeholder="<?= l('qr_step_2_com_location.state.placeholder') ?>" name="offer_state" class="step-form-control anchorLoc" data-anchor="LocationBlock" value="" data-reload-qr-code="">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group m-0">
                            <label for="offer_country"><?= l('qr_step_2_com_location.country') ?></label>
                            <input id="country" onchange="LoadPreview()" placeholder="<?= l('qr_step_2_com_location.country.placeholder') ?>" name="offer_country" class="step-form-control anchorLoc" value="" data-anchor="LocationBlock" data-reload-qr-code="">
                        </div>
                    </div>
                </div>

                    `;
            $(document).find('#manualEntry').append(contentHtml);
            manualClicked = true;
            $(document).find("#mapInput").hide();
            $(document).find('#manualyBtn').html("<?= l('qr_step_2_com_location.delete_btn') ?>");
            document.getElementById('ship-address1').disabled = true;
        } else {
            document.getElementById('ship-address1').disabled = false;
            $(document).find('#manualyBtn').html("<?= l('qr_step_2_com_location.manual_entry') ?>");
            $(document).find('#manualEntry').empty();
            $(document).find('#ship-address1').val('');
            manualClicked = false;
            $(document).find("#mapInput").show();

        }

        LoadPreview();
    });

    var placeSearch, autocomplete;

    function initAutocomplete() {
        try {
            autocomplete = new google.maps.places.Autocomplete(
                document.getElementById('ship-address1'), {
                    types: ['geocode']
                });

            autocomplete.setFields(['address_components']);
            autocomplete.addListener('place_changed', fillInAddress);
        } catch (err) {
            console.log('Map loading error');
        }


    }

    function fillInAddress() {
        var componentForm = {
            street_number: 'short_name',
            route: 'long_name',
            locality: 'long_name',
            administrative_area_level_1: 'short_name',
            country: 'long_name',
            postal_code: 'short_name'
        };
        document.getElementById('manualyBtn').click();


        var place = autocomplete.getPlace();


        document.getElementById('ship-address1').disabled = true;
        for (var component in componentForm) {

            document.getElementById(component).value = '';
            document.getElementById(component).disabled = false;
        }

        for (var i = 0; i < place.address_components.length; i++) {
            var addressType = place.address_components[i].types[0];
            if (componentForm[addressType]) {
                var val = place.address_components[i][componentForm[addressType]];
                document.getElementById(addressType).value = val;
            }
        }
        LoadPreview();
    }
</script>

<!-- Fix for iPhone backButton event for NSF -->
<?php if (isset($_COOKIE['nsf_user_id']) && $_COOKIE['nsf_user_id'] != '') : ?>
    <script>
        var element = document.getElementById('step2_form');
        if (typeof(element) == 'undefined' || element == null && step == 2) {
            window.location.reload();
        }
    </script>
<?php endif ?>


<script>
    // QR code logo upload
    $(document).on('change', '#qr_code_logo', function() {
        $("#screensizeErrorMesg").remove();
        $("label[for='qr_code_logo']").css("border", "2px solid #96949C");
        var qrCodeLogo = document.getElementById("qr_code_logo");

        const [file] = qrCodeLogo.files;
        if (file) {

            sizeinMB = file.size / Math.pow(1024, 2);
            if (sizeinMB > 1) {
                const dts = new DataTransfer();
                qrCodeLogo.files = dts.files;
                $("label[for='qr_code_logo']").css({
                    "border": "2px solid red"
                });
                $(qrCodeLogo).parent().parent().parent().after("<span id='screensizeErrorMesg' style='color:red;margin-top:15px;'><?= l('qr_step_3.add_logo_max_size_error') ?> </span>");
                $("#logo-tmp-mage").css('display', 'flex');
                $("#logo-upl-img").css('display', 'none');
                $('#logo-upl-img').attr('src', '');
                reload_qr_code_event_listener(event);
                document.getElementById('logo_delete').style.display = "none";
                document.getElementById('edit-logo-icon').style.display = "none";
            } else {
                $("#logo-upl-img").css('display', 'block');
                $("#logo-tmp-mage").css('display', 'none');
                $("#temp_submit").attr("disabled", false);
                document.getElementById('logo_delete').style.display = "block";
            }
        }

    });

    // Start Database + GA4 Data Layer Updates(step 1)

    // registration Data Layer Implementation (GTM)
    window.addEventListener('load', (event) => {

        <?php if ($data->auth_method != '') { ?>

            let method = '<?= $data->auth_method ?>';
            let user_id = '<?= $this->user->user_id ?>';
            let unique_id = '<?= isset($this->user->unique_id) ? $this->user->unique_id : null  ?>';
            let client_id = '<?php echo get_client_id() != null ? get_client_id() : default_client_id() ?>';
            let funnel = 'default';
            let email = '<?= $this->user->email ?>';

            $.ajax({
                type: 'POST',
                url: '<?php echo url('api/ajax_new') ?>',
                data: {
                    client_id: client_id,
                    method: method,
                    user_id: user_id,
                    action: 'saveRegisterUser',
                },
                success: function(response) {
                    if (response.data.newUser == true) {
                        var event = "registration";
                        var registerData = {
                            "userId": user_id,
                            "user_type": 'New User',
                            "method": method,
                            "entry_point": 'Signup',
                            "client_id": client_id,
                            "funnel": 'default',
                            "email": email
                        }
                        googleDataLayer(event, registerData);


                        // if (response.data.isProduction == true) {
                        //     //Add Google Ads "Event Snippet"
                        //     gtag('set', 'user_data', {
                        //         "sha256_email_address": email,
                        //     });

                        //     gtag('event', 'conversion', {
                        //         'send_to': 'AW-11373126555/BibACObJp-wYEJvHkK8q',
                        //         'transaction_id': user_id
                        //     });
                        // }

                    }
                }
            })
        <?php } ?>
    })

    window.addEventListener('DOMContentLoaded', (event) => {
        sessionStorage.removeItem("select_qr_step1_complete");
        sessionStorage.removeItem("qr_content_step2_complete");
        sessionStorage.removeItem("qr_user");
    });

    var select_qr_step1_complete = sessionStorage.getItem("select_qr_step1_complete");

    var qr_creation_process_complete = sessionStorage.getItem("qr_creation_process_complete");

    $(document).on("click", ".change-setp-2", function() {

        var current_step_qr = $("input[name=\"current_step_input\"]").val();
        var is_nsf = '<?php echo ($this->user->type == 2 ? true : false) ?>';

        // select_qr_step1_complete Data Layer Implementation (GTM)
        if ($('#qr_status').val() != '1') {


            sessionStorage.removeItem("select_qr_step1_complete");
            sessionStorage.removeItem("qr_content_step2_complete");

            var entery_point = $("input[name=\"onboarding_funnel\"]").val();
            var onboarding_funnel = userFunnle(entery_point);

            var event = 'select_qr_step1_complete';

            var qrData = {
                'userId': '<?= $this->user->user_id ?>',
                'user_type': '<?php echo $this->user->total_logins == '1' ? 'New User' : 'Returning User' ?>',
                'method': '<?php echo ($this->user->type == 2 ? NULL : ($this->user->source == 'direct' ? 'Email' : 'Google')) ?>',
                'entry_point': onboarding_funnel,
                'qr_type': $("input[name=\"qrtype_input\"]").val(),
                'qr_id': $('#qrCodeUid').val(),
            }

            googleDataLayer(event, qrData);
            sessionStorage.setItem("select_qr_step1_complete", "true");
        }


    });

    // qr_content_step2_complete Data Layer Implementation (GTM)
    $("#temp_next").on("click",
        function() {
            var qr_content_step2_complete = sessionStorage.getItem("qr_content_step2_complete");
            var current_step = $("input[name=\"step_input\"]").val();
            if (current_step == 3 && $('#qr_status').val() != '1' && !qr_content_step2_complete) {

                var entery_point = $("input[name=\"onboarding_funnel\"]").val();
                var onboarding_funnel = userFunnle(entery_point);

                var event = 'qr_content_step2_complete';
                var qrData = {
                    'userId': '<?= $this->user->user_id ?>',
                    'user_type': '<?php echo $this->user->total_logins == '1' ? 'New User' : 'Returning User' ?>',
                    'method': '<?php echo ($this->user->type == 2 ? NULL : ($this->user->source == 'direct' ? 'Email' : 'Google')) ?>',
                    'entry_point': onboarding_funnel,
                    'qr_type': $("input[name=\"type\"]").val(),
                    'qr_id': $('#qrCodeUid').val(),


                }

                googleDataLayer(event, qrData);
                sessionStorage.setItem("qr_content_step2_complete", "true");
            }
        }

    );


    // End Database + GA4 Data Layer Updates(step 1)


    function generateRandomNumber() {
        var currentDate = new Date();
        var randomNumber = currentDate.getTime() % 100000000;
        return randomNumber;
    }

    $(document).on('click', '#companyLogo', function() {
        var randomNum = generateRandomNumber();
        $("#uploadUniqueId").val(randomNum);
    });

    $(document).on('click', '.productImages', function() {
        var randomNum = generateRandomNumber();
        $("#uploadUniqueId").val(randomNum);
    });

    $(document).on('click', '.linkImages', function() {
        var randomNum = generateRandomNumber();
        $("#uploadUniqueId").val(randomNum);
    });

    $(document).on('click', '#offerImage', function() {
        var randomNum = generateRandomNumber();
        $("#uploadUniqueId").val(randomNum);
    });
</script>


<script>
    //color picker icon color change
    $(document).on('input', '.pickerField', function() {
        colorPikerIconChange(this);
    });

    $(document).on('click', '#step3 .custom-accodian', function() {
        $(".pickerField").each(function() {
            colorPikerIconChange(this);
        });


    });

    function colorPikerIconChange(element) {
        var pikerColor = $(element).val();
        pikerColor = pikerColor.split('#').join('');
        var rgbColor = pikerColor.match(/.{1,2}/g);
        var rgbCode = [
            parseInt(rgbColor[0], 16),
            parseInt(rgbColor[1], 16),
            parseInt(rgbColor[2], 16)
        ];

        if (rgbCode[1] >= 180) {
            $(element).next().css({
                "color": "black"
            });
            $(element).parent('.clr-field').next().css({
                "color": "black"
            });
        } else {
            $(element).next().css({
                "color": "white"
            });
            $(element).parent('.clr-field').next().css({
                "color": "white"
            });

        }
    }

    //on color code change

    $(document).on('keypress', '.iconColorPiker', function() {
        var pikerColor = $(this).val();
        pikerColor = pikerColor.split('#').join('');
        var rgbColor = pikerColor.match(/.{1,2}/g);
        var rgbCode = [
            parseInt(rgbColor[0], 16),
            parseInt(rgbColor[1], 16),
            parseInt(rgbColor[2], 16)
        ];

        if (rgbCode[1] >= 180) {
            $(this).parent().children('span').css("color", "black");
        } else {
            $(this).parent().children('span').css("color", "white");
        }

    });

    $(document).on('click', '.formcolorPalette', function() {

        var colorPaletteLength = $(this).children().length;
        var linkColorPaletteLength = $(this).children(".color-wrap").children().length;

        if (colorPaletteLength == 1) {
            var primaryPikerColor = getColorCode($("#primaryColor").val());
            $("#primaryColor").next().css({
                "color": primaryPikerColor[1] >= 180 ? "black" : "white"
            });
        } else {
            var primaryPikerColor = getColorCode($("#primaryColor").val());
            var secondaryPikerColor = getColorCode($("#SecondaryColor").val());
            $("#primaryColor").next().css({
                "color": primaryPikerColor[1] >= 180 ? "black" : "white"
            });
            $("#SecondaryColor").next().css({
                "color": secondaryPikerColor[1] >= 180 ? "black" : "white"
            });
        }

        if (linkColorPaletteLength == 3) {
            var linkPikerColor = getColorCode($("#linkColor").val());
            $("#linkColor").next().css({
                "color": linkPikerColor[1] >= 180 ? "black" : "white"
            });
        }

        $('.customColorPicker').parent().find(".invalid_err").remove();
        $('.customColorPicker').css("border", "2px solid #96949C");

    });

    function getColorCode(color) {
        return color.replace("#", "").match(/.{1,2}/g).map(code => parseInt(code, 16));
    }

    $(document).on('click', '.vcard-add-phone, .vcard-add-web, .vcard-add-email', function() {
        $(this).next().next().addClass("show");
    });

    $(document).on('click', '.vcard-add-phone', function() {
        var phoneElementCount = $("#phoneBlock").children().length;
        if (phoneElementCount >= 1) {
            $(".accodianBtn").removeClass("vcard-add-phone");
        }
    });

    $(document).on('click', '.vcard-remove', function() {
        var phoneBlockChilds = $("#phoneBlock").children().length;
        if (phoneBlockChilds == 0) {
            $("#phoneBlock").parents().eq(2).children(".accodianBtn").addClass("vcard-add-phone");
        }
    });

    $(document).on('click', '.vcard-add-web', function() {
        var phoneElementCount = $("#websiteBlock").children().length;
        if (phoneElementCount >= 1) {
            $(".accodianBtn").removeClass("vcard-add-web");
        }
    });

    $(document).on('click', '.vcard-remove', function() {
        var phoneBlockChilds = $("#websiteBlock").children().length;
        if (phoneBlockChilds == 0) {
            $("#websiteBlock").parents().eq(2).children(".accodianBtn").addClass("vcard-add-web");
        }
    });

    $(document).on('click', '.vcard-add-email', function() {
        var phoneElementCount = $("#emailBlock").children().length;
        if (phoneElementCount >= 1) {
            $(".accodianBtn").removeClass("vcard-add-email");
        }
    });

    $(document).on('click', '.vcard-remove', function() {
        var phoneBlockChilds = $("#emailBlock").children().length;
        if (phoneBlockChilds == 0) {
            $("#emailBlock").parents().eq(2).children(".accodianBtn").addClass("vcard-add-email");
        }
    });

    $(document).on('touchstart', '.link-option-btn', function() {
        $(this).addClass('link-touch-add-btn');
    });

    $(document).on('touchend', '.link-option-btn.link-touch-add-btn', function() {
        $(this).removeClass('link-touch-add-btn');
    });
    $(document).on('click', '.qr-card-btn', function() {
        window.scrollTo(0, -100, {
            behavior: 'instant'
        });
    });
    $(document).on('click', '#temp_next', function() {
        window.scrollTo(0, -100, {
            behavior: 'instant'
        });
    });

    $(document).on('click', '.addLogoBtn', function() {
        $('html, body').animate({
            scrollTop: $(document).height()
        }, 260);
    });

    // phone mockup button tooltip js - start
    $("#qrCodeBtn").on("click", function() {
        validation_form()

    });

    $( document ).ready(function() {
        if ($('#2').prop('disabled')) {
            console.log("btn desabled");
            tooltipResponsive();
        }
    });

    $("#qrCodeBtn").on("mouseenter", function() {
        if ($('#2').prop('disabled')) {
            tooltipEnable();
            tooltipResponsive();
        }
    });

    function tooltipResponsive(){
        var divTop = document.querySelector(".prev-qr-code-btn-wrap").getBoundingClientRect().top;
        var tooltipHeight = $("#qrCodeBtnTooltip").outerHeight(true);
        var tooltipTop = divTop - (tooltipHeight + 5);
        var otherLangTooltipTop = divTop - (tooltipHeight + 1);
        var tooltipBeforeTop = tooltipHeight - 4;
        $(".qr-code-btn-tooltip").css("top", tooltipTop + "px");
        var tooltip = document.getElementById("qrCodeBtnTooltip");
        var styleSheet = document.styleSheets[0];
        removeExistingRule(styleSheet, '#qrCodeBtnTooltip::before');
        removeExistingRule(styleSheet, '.qr-code-btn-tooltip:not(:lang(en))');
       
        styleSheet.insertRule('#qrCodeBtnTooltip::before { top: ' + tooltipBeforeTop + 'px !important; }', styleSheet.cssRules.length);

        styleSheet.insertRule('.qr-code-btn-tooltip:not(:lang(en)) { top: ' + otherLangTooltipTop + 'px !important; }', styleSheet.cssRules.length);
    }

     function removeExistingRule(styleSheet, selector) {
        for (var i = styleSheet.cssRules.length - 1; i >= 0; i--) {
        if (styleSheet.cssRules[i].selectorText === selector) {
            styleSheet.deleteRule(i);
            break;
        }
    }
    }

    function tooltipEnable(){
        $('.qr-code-btn-tooltip').css({
            'opacity': '1',
            'visibility': 'visible'
        });
    }

    $("#qrCodeBtn").on("mouseleave", function() {
        $('.qr-code-btn-tooltip').css({
            'opacity': '0'
        });
    });

    $(".qr-prev-btn-wrap").on("mouseenter", function() {
        $('.custom-row').css({
            'overflow': 'visible'
        });
        $('.main-inner').css({
            'overflow': 'visible'
        });
    });

    $(".qr-prev-btn-wrap").on("mouseleave", function() {
        // setTimeout(function() {
        $('.custom-row').css({
            'overflow': 'hidden'
        });
        $('.main-inner').css({
            'overflow': 'hidden'
        });

        // }, 200);
    });

    // Changing qr code button tooltip content after filling required fields
    function changeTooltipContent(value = true) {
        if (value == true) {
            $(".tooltip-con-2").css('display', 'none');
            $("#qrCodeBtnTooltip").addClass("enabled-qr-btn");
        } else {
            $(".tooltip-con-2").css('display', 'block');
            $("#qrCodeBtnTooltip").removeClass("enabled-qr-btn");
        }
    }
    // phone mockup button tooltip js - end
</script>


<script>
    var isBackFromPay = sessionStorage.getItem("is_back");
    if (isBackFromPay) {
        sessionStorage.removeItem("is_back");
    }
</script>



<!-- <script src="https://unpkg.com/vanilla-picker@2"></script> -->


<?php \Altum\Event::add_content(ob_get_clean(), 'javascript') ?>
<!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC8qMRqcnP5x7y15lRD1Arl56PRVEUv5r4&libraries=places" async defer></script> -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBWqVnjsDUK7XOH0QsvXftLTsIIt6mKIRU&libraries=places" async defer></script>