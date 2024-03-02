<?php defined('ALTUMCODE') || die() ?>

<div class="jss1347 main-inner">
    <?= \Altum\Alerts::output_alerts() ?>
    <div class="custom-row">
        <div class="col-left customScrollbar">

            <input type="hidden" name="step_input" value="1">
            <input type="hidden" name="current_step_input" value="1">
            <input type="hidden" name="qrcodeId" value="<?php echo $data->id; ?>">
            <input type="hidden" name="qrtype_input" value="<?php echo $data->type; ?>">
            <input type="hidden" name="qrtype_input_old" value="">

            <?php if (\Altum\Middlewares\Authentication::check()) : ?>
                <input type="hidden" name="userid" value="<?= $this->user->user_id ?>" />
            <?php endif ?>

            <div class="jss1349">
                <div style="position: relative; overflow: hidden; width: 100%; height: 100%;">
                    <div style="inset: 0px; margin-right: -7px; margin-bottom: -14px;">
                        <section class="jss1452">
                            <div class="jss1456">
                                <div class="MuiPaper-root MuiStepper-root jss1470 MuiStepper-horizontal MuiPaper-elevation0">
                                    <a onclick="change_step(1)" class="MuiStep-root jss1471 MuiStep-horizontal" id="tab1">
                                        <span class="MuiStepLabel-root MuiStepLabel-horizontal">
                                            <span class="MuiStepLabel-iconContainer jss1472">
                                                <div class="jss1477 jss1480">
                                                    <svg id="s1" class="MuiSvgIcon-root jss1478 jss1480" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                                        <circle cx="12" cy="12" r="12"></circle>
                                                        <text class="jss1479" x="12" y="18" text-anchor="middle">1</text>
                                                    </svg>
                                                </div>
                                            </span>
                                            <span class="MuiStepLabel-labelContainer">
                                                <span class="MuiTypography-root MuiStepLabel-label jss1473 MuiStepLabel-active jss1474 MuiTypography-body2 MuiTypography-displayBlock">Type of QR code</span>
                                            </span>
                                        </span>
                                    </a>
                                    <div class="MuiStepConnector-root jss1483 MuiStepConnector-horizontal">
                                        <span class="MuiStepConnector-line jss1484 MuiStepConnector-lineHorizontal"></span>
                                    </div>
                                    <div class="MuiStep-root jss1471 MuiStep-horizontal" id="tab2" onclick="backButton()">
                                        <span class="MuiStepLabel-root MuiStepLabel-horizontal">
                                            <span class="MuiStepLabel-iconContainer jss1472">
                                                <div class="jss1477">
                                                    <svg id="s2" class="MuiSvgIcon-root jss1478" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                                        <circle cx="12" cy="12" r="12"></circle>
                                                        <text class="jss1479" x="12" y="18" text-anchor="middle">2</text>
                                                    </svg>
                                                </div>
                                            </span>
                                            <span class="MuiStepLabel-labelContainer">
                                                <span class="MuiTypography-root MuiStepLabel-label jss1473 MuiTypography-body2 MuiTypography-displayBlock">Content</span>
                                            </span>
                                        </span>
                                    </div>
                                    <div class="MuiStepConnector-root jss1483 MuiStepConnector-horizontal Mui-disabled">
                                        <span class="MuiStepConnector-line jss1484 MuiStepConnector-lineHorizontal"></span>
                                    </div>
                                    <div class="MuiStep-root jss1471 MuiStep-horizontal " id="tab3">
                                        <span class="MuiStepLabel-root MuiStepLabel-horizontal Mui-disabled">
                                            <span class="MuiStepLabel-iconContainer jss1472">
                                                <div class="jss1477">
                                                    <svg id="s3" class="MuiSvgIcon-root jss1478" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                                        <circle cx="12" cy="12" r="12"></circle>
                                                        <text class="jss1479" x="12" y="18" text-anchor="middle">3</text>
                                                    </svg>
                                                </div>
                                            </span>
                                            <span class="MuiStepLabel-labelContainer">
                                                <span class="MuiTypography-root MuiStepLabel-label jss1473 MuiTypography-body2 MuiTypography-displayBlock">QR design</span>
                                            </span>
                                        </span>
                                    </div>
                                </div>
                                <button type="button" class="jss1466" data-toggle="modal" data-target="#helpModal" data-target="#helpCarousel" data-slide-to="0" onclick="onModal()">
                                    <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M12,2A10,10,0,1,0,22,12,10,10,0,0,0,12,2Zm0,18a8,8,0,1,1,8-8A8,8,0,0,1,12,20Z"></path>
                                        <path d="M11.17,15.17a.91.91,0,0,0-.92.92.89.89,0,0,0,.27.65.91.91,0,0,0,.65.26.92.92,0,0,0,.65-.26.93.93,0,0,0,0-1.31A.92.92,0,0,0,11.17,15.17Z"></path>
                                        <path d="M12,7a3,3,0,0,0-2.18.76,2.5,2.5,0,0,0-.81,2h1.44a1.39,1.39,0,0,1,.41-1.07A1.61,1.61,0,0,1,12,8.27a1.6,1.6,0,0,1,1.14.4,1.48,1.48,0,0,1,.41,1.1,1.39,1.39,0,0,1-.61,1.33,3.88,3.88,0,0,1-1.88.33h-.64v2.65h1.45V12.46a3.79,3.79,0,0,0,2.35-.63,2.37,2.37,0,0,0,.79-2,2.7,2.7,0,0,0-.83-2.11A3.16,3.16,0,0,0,12,7Z"></path>
                                    </svg>
                                    <span class="jss1467">Help</span>
                                </button>
                            </div>
                            <div id="ajax-content-data">

                            </div>
                            <!-- </div></div> -->
                            <?php require THEME_PATH . 'views/qr-codes/js_qr_code.php' ?>
                        </section>

                    </div>
                </div>
                <div class="preview" id="preview">
                    <img class="preview-img" src="<?= $data->qr_code_settings['type'][$data->type]['preview'] ?>" width="100" />
                </div>
            </div>
        </div>
        <div class="col-right customScrollbar">
            <div class="col-right-inner">
                <div class="preview-head" id="tabhead">
                    <button type="button" class="clear-btn">
                        <spana id="QrType"><a href="qr/<?= ucfirst($data->type) ?>"> <?= ucfirst($data->type) ?></a></span>
                            <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 22px;">
                                <path d="M20.71,6.29l-3-3a1,1,0,0,0-1.42,0l-12,12a1,1,0,0,0-.26.47l-1,4a1,1,0,0,0,.26.95A1,1,0,0,0,4,21a1,1,0,0,0,.24,0l4-1a1,1,0,0,0,.47-.26l12-12A1,1,0,0,0,20.71,6.29ZM7.49,18.1l-2.12.53.53-2.12,8.6-8.6L16.09,9.5Zm10-10L15.91,6.5,17,5.41,18.59,7Z"></path>
                            </svg>
                    </button>
                    <ul class="nav" role="tablist">
                        <li>
                            <a class="square-btn active" data-toggle="tab" href="#tabs-1" id="1" role="tab">
                                <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 16 28" aria-hidden="true" style="font-size: 24px;">
                                    <path d="M12,0 C14.209139,-4.05812251e-16 16,1.790861 16,4 L16,24 C16,26.209139 14.209139,28 12,28 L4,28 C1.790861,28 2.705415e-16,26.209139 0,24 L0,4 C-2.705415e-16,1.790861 1.790861,4.05812251e-16 4,0 L12,0 Z M12,2 L4,2 C2.9456382,2 2.08183488,2.81587779 2.00548574,3.85073766 L2,4 L2,24 C2,25.0543618 2.81587779,25.9181651 3.85073766,25.9945143 L4,26 L12,26 C13.0543618,26 13.9181651,25.1841222 13.9945143,24.1492623 L14,24 L14,4 C14,2.8954305 13.1045695,2 12,2 Z M8,20 C9.1045695,20 10,20.8954305 10,22 C10,23.1045695 9.1045695,24 8,24 C6.8954305,24 6,23.1045695 6,22 C6,20.8954305 6.8954305,20 8,20 Z"></path>
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a class="square-btn" data-toggle="tab" href="#tabs-2" id="2" role="tab">
                                <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 24px;">
                                    <path d="M10,4H5A1,1,0,0,0,4,5v5a1,1,0,0,0,1,1h5a1,1,0,0,0,1-1V5A1,1,0,0,0,10,4ZM9,9H6V6H9Z"></path>
                                    <path d="M19,4H14a1,1,0,0,0-1,1v5a1,1,0,0,0,1,1h5a1,1,0,0,0,1-1V5A1,1,0,0,0,19,4ZM18,9H15V6h3Z"></path>
                                    <path d="M10,13H5a1,1,0,0,0-1,1v5a1,1,0,0,0,1,1h5a1,1,0,0,0,1-1V14A1,1,0,0,0,10,13ZM9,18H6V15H9Z"></path>
                                    <circle cx="14" cy="14" r="1"></circle>
                                    <circle cx="14" cy="18" r="1"></circle>
                                    <circle cx="18" cy="18" r="1"></circle>
                                    <circle cx="16" cy="16" r="1"></circle>
                                    <circle cx="18" cy="14" r="1"></circle>
                                </svg>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="preview-head" id="tabhead_example">
                    <div class="text-center w-100">
                        <h4>Example</h4>
                    </div>
                </div>
                <!-- Tab panes -->
                <div class="tab-content mb-frame">
                    <div class="tab-pane active" id="tabs-1" role="tabpanel">
                        <div class="mb-frame-inner">
                            <div class="frame-top">
                                <div class="frame-left"></div>
                                <div class="frame-right"></div>
                            </div>
                            <div class="card">
                                <div class="card-body p-0">

                                    <div class="loader" id="loader" style="margin: 110px;">
                                        <div class="box1"></div>
                                        <div class="box2"></div>
                                        <div class="box3"></div>
                                    </div>
                                    <iframe id="iframesrc" src="<?= $data->qr_code_settings['type'][$data->type]['preview'] ?>" width="100%" height="500" scrolling="yes"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tabs-2" role="tabpanel">
                        <div class="mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <img id="qr_code" src="<?= ASSETS_FULL_URL . 'images/qr_code.svg' ?>" class="img-fluid qr-code" loading="lazy" />
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4 d-print-none" style="visibility: hidden;">
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
                <div class="mb-4 text-center d-print-none">
                    <small>
                        <i class="fa fa-fw fa-info-circle text-muted mr-1"></i> <span class="text-muted"><?= l('qr_codes.info') ?></span>
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="jss49">
    <div class="jss50">
        <div class="jss51">
            <button class="MuiButtonBase-root MuiButton-root jss59 jss142 MuiButton-outlined jss71 jss54 MuiButton-outlinedPrimary jss60" tabindex="0" type="button" id="cancel" onclick="backButton()">
                <span class="MuiButton-label jss72"></span>
            </button>
        </div>
        <div class="jss53">
            <button class="square-btn" data-toggle="modal" data-target="#QrCodeModal">
                <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 24px;">
                    <path d="M10,4H5A1,1,0,0,0,4,5v5a1,1,0,0,0,1,1h5a1,1,0,0,0,1-1V5A1,1,0,0,0,10,4ZM9,9H6V6H9Z"></path>
                    <path d="M19,4H14a1,1,0,0,0-1,1v5a1,1,0,0,0,1,1h5a1,1,0,0,0,1-1V5A1,1,0,0,0,19,4ZM18,9H15V6h3Z"></path>
                    <path d="M10,13H5a1,1,0,0,0-1,1v5a1,1,0,0,0,1,1h5a1,1,0,0,0,1-1V14A1,1,0,0,0,10,13ZM9,18H6V15H9Z"></path>
                    <circle cx="14" cy="14" r="1"></circle>
                    <circle cx="14" cy="18" r="1"></circle>
                    <circle cx="18" cy="18" r="1"></circle>
                    <circle cx="16" cy="16" r="1"></circle>
                    <circle cx="18" cy="14" r="1"></circle>
                </svg>
            </button>
            <button class="square-btn" data-toggle="modal" data-target="#PreviewModal">
                <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 16 28" aria-hidden="true" style="font-size: 24px;">
                    <path d="M12,0 C14.209139,-4.05812251e-16 16,1.790861 16,4 L16,24 C16,26.209139 14.209139,28 12,28 L4,28 C1.790861,28 2.705415e-16,26.209139 0,24 L0,4 C-2.705415e-16,1.790861 1.790861,4.05812251e-16 4,0 L12,0 Z M12,2 L4,2 C2.9456382,2 2.08183488,2.81587779 2.00548574,3.85073766 L2,4 L2,24 C2,25.0543618 2.81587779,25.9181651 3.85073766,25.9945143 L4,26 L12,26 C13.0543618,26 13.9181651,25.1841222 13.9945143,24.1492623 L14,24 L14,4 C14,2.8954305 13.1045695,2 12,2 Z M8,20 C9.1045695,20 10,20.8954305 10,22 C10,23.1045695 9.1045695,24 8,24 C6.8954305,24 6,23.1045695 6,22 C6,20.8954305 6.8954305,20 8,20 Z"></path>
                </svg>
            </button>

            <?php if (\Altum\Middlewares\Authentication::check()) : ?>
                <button id="temp_next" class="MuiButtonBase-root MuiButton-root jss59 jss74 MuiButton-contained jss56 MuiButton-containedPrimary jss70" tabindex="0" type="button">
                    <span class="MuiButton-label jss72">Next
                        <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 16 16" aria-hidden="true" style="margin-left: 12px; font-size: 18px;">
                            <path d="M13.92,8.38a1,1,0,0,0,0-.76,1,1,0,0,0-.21-.33l-4-4A1,1,0,0,0,8.29,4.71L10.59,7H3A1,1,0,0,0,3,9h7.59l-2.3,2.29a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0l4-4A1,1,0,0,0,13.92,8.38Z"></path>
                        </svg>
                    </span>
                </button>
                <button id="temp_next_tmp" class="MuiButtonBase-root MuiButton-root jss59 jss74 MuiButton-contained jss56 MuiButton-containedPrimary jss70" tabindex="0" type="button" disabled="disabled">
                    <span class="MuiButton-label jss72">Next
                        <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 16 16" aria-hidden="true" style="margin-left: 12px; font-size: 18px;">
                            <path d="M13.92,8.38a1,1,0,0,0,0-.76,1,1,0,0,0-.21-.33l-4-4A1,1,0,0,0,8.29,4.71L10.59,7H3A1,1,0,0,0,3,9h7.59l-2.3,2.29a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0l4-4A1,1,0,0,0,13.92,8.38Z"></path>
                        </svg>
                    </span>
                </button>
                <button id="temp_submit" class="MuiButtonBase-root MuiButton-root jss59 jss74 MuiButton-contained jss56 MuiButton-containedPrimary jss70" tabindex="0" type="button">
                    <span class="MuiButton-label jss72" onclick="submit()"><?= l('global.create') ?>
                        <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 16 16" aria-hidden="true" style="margin-left: 12px; font-size: 18px;">
                            <path d="M13.92,8.38a1,1,0,0,0,0-.76,1,1,0,0,0-.21-.33l-4-4A1,1,0,0,0,8.29,4.71L10.59,7H3A1,1,0,0,0,3,9h7.59l-2.3,2.29a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0l4-4A1,1,0,0,0,13.92,8.38Z"></path>
                        </svg>
                    </span>
                </button>
                <button id="temp_submit_loader" style="display: none" disabled="disabled" class="MuiButtonBase-root MuiButton-root jss59 jss74 MuiButton-contained jss56 MuiButton-containedPrimary jss70">
                    <i class="fa fa-spinner fa-spin"></i> Submit
                </button>
                <!-- <button  class="btn btn-block btn-primary mt-4"><?= l('global.create') ?></button> -->
            <?php else : ?>
                <?php if (settings()->users->register_is_enabled) : ?>
                    <a data-toggle="modal" data-target="#registerModal" id="temp_submit" class="MuiButtonBase-root MuiButton-root jss59 jss74 MuiButton-contained jss56 MuiButton-containedPrimary jss70" tabindex="0" type="button" style="display: block;">
                        <span class="MuiButton-label jss72" style="margin-top: 5px;"><i class="fa fa-fw fa-xs fa-plus mr-1"></i><?= l('qr_register') ?>
                        </span>
                    </a>
                    <!-- <a href="<?= url('register') ?>" class="btn btn-block btn-outline-primary mt-4"><i class="fa fa-fw fa-xs fa-plus mr-1"></i> <?= l('qr_register') ?></a> -->
                <?php endif ?>
            <?php endif ?>
        </div>

    </div>
</div>


<!-- Help Modal -->
<div class="modal smallmodal fade" id="helpModal" tabindex="-1" aria-labelledby="helpModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-dialog-help">
        <div class="modal-content p-0">
            <div id="helpCarousel" class="carousel slide" data-interval="false" data-wrap="false">
                <ol class="carousel-indicators">
                    <li data-target="#helpCarousel" data-slide-to="0" class="active"><span></span></li>
                    <li data-target="#helpCarousel" data-slide-to="1"><span></span></li>
                    <li data-target="#helpCarousel" data-slide-to="2"><span></span></li>
                    <li data-target="#helpCarousel" data-slide-to="3"><span></span></li>
                    <li data-target="#helpCarousel" data-slide-to="4"><span></span></li>
                </ol>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="<?= ASSETS_FULL_URL . 'static/s1.webp' ?>" class="d-block w-100" loading="lazy" alt="...">
                        <div class="p-4">
                            <span>Step 1</span>
                            <h3>Choose a type of QR code</h3>
                            <p>Select the type of QR code you need by clicking on the icons. You have up to eight different options.</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="<?= ASSETS_FULL_URL . 'static/s2.webp' ?>" class="d-block w-100" loading="lazy" alt="...">
                        <div class="p-4">
                            <span>Step 2</span>
                            <h3>Add content</h3>
                            <p>Fill in the information needed for your QR code to work. Link a URL, upload a file, or fill in the fields with the different content.</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="<?= ASSETS_FULL_URL . 'static/s3.webp' ?>" class="d-block w-100" loading="lazy" alt="...">
                        <div class="p-4">
                            <span>Step 3</span>
                            <h3>Design your QR code</h3>
                            <p>Customise your QR code by choosing colours and a style, adding texts and even logos. Get a QR tailored to your business or idea.</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="<?= ASSETS_FULL_URL . 'static/s4.webp' ?>" class="d-block w-100" loading="lazy" alt="...">
                        <div class="p-4">
                            <span>Step 4</span>
                            <h3>Preview your QR code</h3>
                            <p>Access a preview of the QR code that you have created by clicking on the two buttons that you see in the image. Remember that it is always a good idea to test the QR once it has been created.</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="<?= ASSETS_FULL_URL . 'static/s5.webp' ?>" class="d-block w-100" alt="...">
                        <div class="p-4 flex-column d-flex align-items-center justify-content-center">
                            <span></span>
                            <h3 class="mt-3">Congratulations!</h3>
                            <p class="text-center">You're now ready to create your own <br>custom QR codes.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-footer">
                <div>
                    <button id="helpSkipbtn" class="carouselBtn" type="button" data-dismiss="modal">Skip</button>
                    <button id="helpPrevbtn" class="carouselBtn" type="button" data-target="#helpCarousel" data-slide="prev" onclick="onSlide(false)">Back</button>
                </div>
                <div>
                    <button id="helpAcceptbtn" class="carouselBtn carouselNextBtn" type="button" data-dismiss="modal">Accept</button>
                    <button id="helpNextbtn" class="carouselBtn carouselNextBtn" type="button" data-target="#helpCarousel" data-slide="next" onclick="onSlide(true)">Next</button>
                </div>
            </div>
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
            <p>Preview</p>
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
                <div class="frame-top">
                    <div class="frame-left"></div>
                    <div class="frame-right"></div>
                </div>
                <div class="card">
                    <div class="card-body p-0">
                        <iframe id="iframesrc2" src="<?= $data->qr_code_settings['type'][$data->type]['preview'] ?>" width="100%" height="500" style="visibility: visible" scrolling="yes"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php ob_start() ?>
<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>

<script>
    change_step(1);
    changeUrl();
    $("#temp_next").show();
    $("#temp_next_tmp").hide();
    $("#temp_submit").hide();

    function change_step(step) {
        // alert(step);
        var step1 = $("input[name=\"step_input\"]").val(step);
        var current = $("input[name=\"current_step_input\"]").val();
        $("input[name=\"current_step_input\"]").val(step);

        if (parseInt(step) == 1) {
            $("#cancel > span").text('Cancel');
            $("#temp_next").show();
            $("#temp_next_tmp").hide();
            $("#temp_submit").hide();

            get_data()
        } else if (parseInt(step) == 2) {
            $("#cancel > span").text('Back');
            $("#temp_next").show();
            $("#temp_next_tmp").hide();
            $("#temp_submit").hide();

            document.getElementById('s1').style.fill = '#220E27';
            document.getElementById('s2').style.fill = '#FE8E3E';
            document.getElementById('s2').style.opacity = '1';
            document.getElementById('s3').style.fill = '#220E27';
            document.getElementById('preview').style.display = 'none';
            document.getElementById('tabhead').style.display = 'flex';
            document.getElementById('tabhead_example').style.display = 'none';

            // document.getElementById('step2_form').style.display = 'block';
            // document.getElementById('step3').style.display = 'none';
            document.getElementById('temp_next').style.display = 'none';
            document.getElementById('temp_next_tmp').style.display = 'block';
            document.getElementById('temp_submit').style.display = 'none';

            if (parseInt(current) != 3) {
                document.getElementById('step1').style.display = 'none';
                get_data();
            } else {
                console.log('back to step 2');
                document.getElementById('step2_form').style.display = 'block';
                document.getElementById('step3').style.display = 'none';
                $('#temp_next_tmp').hide();
                $('#temp_next').show();
            }

        } else {
            document.getElementById('s1').style.fill = '#220E27';
            document.getElementById('s2').style.fill = '#220E27';
            document.getElementById('s2').style.opacity = '1';
            document.getElementById('s3').style.fill = '#FE8E3E';
            document.getElementById('tabs-1').classList.remove('active');
            document.getElementById('1').classList.remove('active');
            document.getElementById('tabs-2').classList.add('active');
            document.getElementById('2').classList.add('active');
            // document.getElementById('step1').style.display = 'none';
            // document.getElementById('step2').style.display = 'none';
            document.getElementById('step2_form').style.display = 'none';
            document.getElementById('step3').style.display = 'block';
            document.getElementById('temp_next').style.display = 'none';

            // document.getElementById('preview').style.display = 'none';
            document.getElementById('temp_submit').style.display = 'block';


        }

    }

    function get_data() {
        var step = $("input[name=\"step_input\"]").val();
        var type = $("input[name=\"qrtype_input\"]").val();
        var userId = $("input[name=\"userid\"]").val();
        var qr_code_id = $("input[name=\"qrcodeId\"]").val();

        $.ajax({
            type: 'POST',
            url: '<?php echo url('api/ajax') ?>',
            data: {
                step: step,
                type: type,
                action: 'ajax_content',
                userId: userId,
                qr_code_id: qr_code_id
            },
            dataType: 'json',
            success: function(response) {
                var response = response.data;
                $("#ajax-content-data").html(response);


                $("#dot").click(function() {
                    $("#dot").addClass('active');
                    $("#round").removeClass('active');
                    $("#square").removeClass('active');
                });
                $("#round").click(function() {
                    $("#dot").removeClass('active');
                    $("#round").addClass('active');
                    $("#square").removeClass('active');
                });
                $("#square").click(function() {
                    $("#dot").removeClass('active');
                    $("#round").removeClass('active');
                    $("#square").addClass('active');
                });

                $("#RE").click(function() {
                    $("#CE").removeClass('active');
                    $("#RE").addClass('active');
                });

                $("#CE").click(function() {
                    $("#RE").removeClass('active');
                    $("#CE").addClass('active');
                });

                // $(document).on('change', '#isGradientSelected', function() {

                //     if ($(this).is(":checked")) {

                //         $('#gradient').show();
                //     } else {
                //         $('#gradient').hide();
                //     }
                // });

                // $(document).ready(function() {
                //     $("#isGradientSelected").change(function() {
                //         console.log("here", $("#isGradientSelected").val())
                //         var selectedOption = $("#isGradientSelected").val()
                //         if (selectedOption == 'gradient') {

                //             $('#gradient').show();
                //         } else {
                //             $('#gradient').hide();
                //         }
                //     });
                // });

                // $(document).ready(function() {
                //     $("#isFrameGradientSelected").change(function() {
                //         console.log("here", $("#isFrameGradientSelected").val())
                //         var selectedOption = $("#isFrameGradientSelected").val()
                //         if (selectedOption == 'gradient') {

                //             $('#gradient').show();
                //         } else {
                //             $('#gradient').hide();
                //         }
                //     });
                // });

                $(document).ready(function() {
                    $("#isGradientSelected").change(function() {
                        console.log("here gradient", $("#isGradientSelected").val())
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
                        console.log("here frame", $("#isFrameGradientSelected").val())
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
                        console.log("here background", $("#isBackgroundGradientSelected").val())
                        var selectedOption = $("#isBackgroundGradientSelected").val()
                        if (selectedOption == 'gradient') {

                            $('#background_gradient').show();
                        } else {
                            $('#background_gradient').hide();
                        }
                    });
                });

                // $('input').trigger('keyup');

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
                    // $("#qr_frame_enabled").click();
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
                    $("#ForgroundColorSpan").html(selectedOption)
                });
                $("#BackgroundColor").change(function() {
                    let selectedOption = $("#BackgroundColor").val()
                    $("#BackgroundColorSpan").html(selectedOption)
                });



                $("#ForgroundColorFirst").change(function() {
                    var selectedOption = $("#ForgroundColorFirst").val()
                    $("#ForgroundColorFirstSpan").html(selectedOption)
                });
                $("#ForgroundColorSecond").change(function() {
                    var selectedOption = $("#ForgroundColorSecond").val()
                    $("#ForgroundColorSecondSpan").html(selectedOption)
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
                    $("#FrameColorSpan").html(selectedOption)
                });

                $("#FrameColorFirst").change(function() {
                    var selectedOption = $("#FrameColorFirst").val()
                    $("#FrameColorFirstSpan").html(selectedOption)
                });
                $("#FrameColorSecond").change(function() {
                    var selectedOption = $("#FrameColorSecond").val()
                    $("#FrameColorSecondSpan").html(selectedOption)
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
                    $("#FrameBackgroundColorSpan").html(selectedOption)
                });

                $("#FrameBackgroundColorFirst").change(function() {
                    var selectedOption = $("#FrameBackgroundColorFirst").val()
                    $("#FrameBackgroundColorFirstSpan").html(selectedOption)
                });

                $("#FrameBackgroundColorSecond").change(function() {
                    var selectedOption = $("#FrameBackgroundColorSecond").val()
                    $("#FrameBackgroundColorSecondSpan").html(selectedOption)
                });

                // EIColorSpan

                $("#EIColor").change(function() {
                    let selectedOption = $("#EIColor").val()
                    $("#EIColorSpan").html(selectedOption)
                });
                $("#EOColor").change(function() {
                    let selectedOption = $("#EOColor").val()
                    $("#EOColorSpan").html(selectedOption)
                });

                $("input, textarea").on("keyup", function() {
                    if (step == 2) {
                        let allAreFilled = true;
                        document.getElementById("myform").querySelectorAll("[required]").forEach(function(i) {
                            // console.log("iiii", i);
                            if (!allAreFilled) return;

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
                        })
                        console.log("valid", allAreFilled);
                        if (!allAreFilled) {
                            $('#temp_next').hide();
                            $('#temp_next_tmp').show();
                        } else {
                            $('#temp_next_tmp').hide();
                            $('#temp_next').show();
                        }
                    }

                    // let valid = true;
                    // $('[required]').each(function() {
                    //     if ($(this).is(':invalid') || !$(this).val()) valid = false;
                    // })
                    // console.log("valid", valid);
                    // if (!valid) {
                    //     $('#temp_next').attr('disabled', 'disabled');
                    // } else {
                    //     $('#temp_next').removeAttr('disabled');
                    // }
                });


                for (let index = 1; index < 6; index++) {
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
                $("#formcolorPalette1").click(
                    function() {
                        $("#primaryColor").val("#2F6BFD")
                        $("#SecondaryColor").val("#0E379A")
                        LoadPreview()
                    });

                $("#formcolorPalette2").click(
                    function() {
                        $("#primaryColor").val("#28EDC9")
                        $("#SecondaryColor").val("#03A183")
                        LoadPreview()
                    });

                $("#formcolorPalette3").click(
                    function() {
                        $("#primaryColor").val("#28ED28")
                        $("#SecondaryColor").val("#00A301")
                        LoadPreview()
                    });

                $("#formcolorPalette4").click(
                    function() {
                        $("#primaryColor").val("#EDE728")
                        $("#SecondaryColor").val("#A39E0A")
                        LoadPreview()
                    });

                $("#formcolorPalette5").click(
                    function() {
                        $("#primaryColor").val("#ED4C28")
                        $("#SecondaryColor").val("#A31F01")
                        LoadPreview()
                    });


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
                            // if(input.getAttribute('disabled')) {
                            //     input.setAttribute('data-is-disabled', 'true');
                            // }
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
                            // if(input.getAttribute('data-is-disabled')) {
                            //     input.setAttribute('disabled', 'required')
                            // }
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
                    console.log("test function load");
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

                    console.log(url_dynamic);

                    if (url_dynamic) {
                        document.querySelector('#url').removeAttribute('required');
                        document.querySelector('[data-url]').classList.add('d-none');
                        document.querySelector('#link_id').setAttribute('required', 'required');
                        document.querySelector('[data-link-id]').classList.remove('d-none');

                        let link_id_element = document.querySelector('#link_id');
                        if (link_id_element.options.length) {
                            document.querySelector('#url').value = link_id_element.options[link_id_element.selectedIndex].text;
                        }
                    } else {
                        document.querySelector('#link_id').removeAttribute('required');
                        document.querySelector('[data-link-id]').classList.add('d-none');
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
                        ['change', 'paste', 'keyup'].forEach(event_type => {
                            element.removeEventListener(event_type, reload_qr_code_event_listener);
                            element.addEventListener(event_type, reload_qr_code_event_listener);
                        })
                    });
                }

                let reload_qr_code_event_listener = () => {
                    /* Add the preloader, hide the QR */
                    document.querySelector('#qr_code').classList.add('qr-code-loading');

                    /* Disable the submit button */
                    if (document.querySelector('button[type="submit"]')) {
                        document.querySelector('button[type="submit"]').classList.add('disabled');
                        document.querySelector('button[type="submit"]').setAttribute('disabled', 'disabled');
                    }

                    clearTimeout(delay_timer);

                    delay_timer = setTimeout(() => {

                        /* Send the request to the server */
                        let form = document.querySelector('form#myform');
                        let form_data = new FormData(form);

                        let notification_container = form.querySelector('.notification-container');
                        notification_container.innerHTML = '';

                        fetch(`${url}qr-code-generator`, {
                                method: 'POST',
                                body: form_data,
                            })
                            .then(response => response.ok ? response.json() : Promise.reject(response))
                            .then(data => {
                                
                                if (data.status == 'error') {
                                    display_notifications(data.message, 'error', notification_container);
                                } else if (data.status == 'success') {
                                    display_notifications(data.message, 'success', notification_container);

                                    document.querySelector('#qr_code').src = data.details.data;
                                    document.querySelector('#download_svg').href = data.details.data;
                                    if (document.querySelector('input[name="qr_code"]')) {
                                        document.querySelector('input[name="qr_code"]').value = data.details.data;
                                    }

                                    /* Enable the submit button */
                                    if (document.querySelector('button[type="submit"]')) {
                                        document.querySelector('button[type="submit"]').classList.remove('disabled');
                                        document.querySelector('button[type="submit"]').removeAttribute('disabled');
                                    }
                                }

                                /* Hide the preloader, display the QR */
                                document.querySelector('#qr_code').classList.remove('qr-code-loading');

                            })
                            .catch(error => {});

                    }, 750);
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
            },
            error: () => {
                /* Re enable submit button */
                // submit_button.removeClass('disabled').text(text);
            },

        });
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
        // temp_submit_loader
        $("#temp_submit").hide();
        $("#temp_submit_loader").show();
        if (document.getElementById("preview_link")) {
            document.getElementById("preview_link").value = "<?php echo LANDING_PAGE_URL; ?>" + document.getElementById('uId').value;
            $("#qr_frame_id_tmp").click();
            $("#qr_frame_path_tmp").click();
            await new Promise(resolve => setTimeout(resolve, 5000));
            document.getElementById("submit").click();
        } else {
            document.getElementById("submit").click();
        }

    }



    $("#temp_next").on("click",
        function() {
            var c_step = $("input[name=\"step_input\"]").val();
            $("input[name=\"step_input\"]").val(parseInt(c_step) + 1);
            change_step(parseInt(c_step) + 1);
        }
    );

    var __QRTYPES = <?php echo json_encode($data->qr_code_settings['type']); ?>;

    function changeUrl(newUrl = '', thisObj = null) {
        $('#loader').show();
        if (thisObj == null) {
            $('#QrType').text('Url');
            // $("#iframesrc").prop('src', '<?php echo LANDING_PAGE_URL; ?>preview/default');
            $("#qr-preview").prop('src', '<?php echo ASSETS_FULL_URL; ?>images/default.png');
        } else {
            var qrtype = $(thisObj).val();
            $("input[name=\"qrtype_input\"]").val(qrtype);
            var newQrTypeText = $(thisObj).data('qr_type') || 'pdf';
            $('#QrType').text(newQrTypeText);
            $("#iframesrc").prop('src', __QRTYPES[newQrTypeText.toLowerCase()]['preview'])
        }
        $('#loader').hide();
    }

    function getBackButtonText() {
        if (step > 1) {
            return "Back";
        }
        return "Cancel";
    }

    function swapValues() {
        var tmp = document.getElementById("primaryColor").value;
        document.getElementById("primaryColor").value = document.getElementById("SecondaryColor").value;
        document.getElementById("SecondaryColor").value = tmp;
        // document.getElementById('primaryColortxt').innerHTML = document.getElementById("SecondaryColor").value;
        // document.getElementById('SecondaryColortxt').innerHTML = tmp;
        LoadPreview();
    }

    function backButton() {
        var c_step = $("input[name=\"step_input\"]").val();
        if (c_step == 1 || c_step == '1') {
            history.back();
            // var newstep = $("input[name=\"step_input\"]").val(1);
            // change_step(newstep);
        } else {
            $("input[name=\"step_input\"]").val(parseInt(c_step) - 1)
            change_step(parseInt(c_step) - 1)
        }

    }
</script>


<script type="text/javascript">
    function onModal() {
        document.getElementById('helpSkipbtn').style.display = 'block';
        document.getElementById('helpNextbtn').style.display = 'block';
        document.getElementById('helpPrevbtn').style.display = 'none';
        document.getElementById('helpAcceptbtn').style.display = 'none';
        $('#helpCarousel').carousel(0).index();

        var myCarousel = document.querySelector('#helpCarousel')
        var carousel = new bootstrap.Carousel(myCarousel, {
            interval: false,
            wrap: false
        })
    }

    function onSlide(type) {
        var current = $('.carousel-item.active').index() + 1;
        if (type) {
            document.getElementById('helpPrevbtn').style.display = 'block';
            document.getElementById('helpSkipbtn').style.display = 'none';
            if (current === 4) {
                document.getElementById('helpNextbtn').style.display = 'none';
                document.getElementById('helpAcceptbtn').style.display = 'block';
            }
        } else {
            document.getElementById('helpNextbtn').style.display = 'block';
            document.getElementById('helpAcceptbtn').style.display = 'none';
            if (current === 2) {
                document.getElementById('helpPrevbtn').style.display = 'none';
                document.getElementById('helpSkipbtn').style.display = 'block';
            }
        }
    }
    $("#screen_delete").on("click", function() {
        // var control = $("#screen");
        // control.replaceWith(control = control.clone(true));
        $('#screen').val('');

        document.getElementById('edit-icon').style.display = 'none';
        document.getElementById('screen_delete').style.display = 'none';
        document.getElementById("tmp-mage").style.display = "block";
        document.getElementById('add-icon').style.display = "block";
        let upl_img = document.getElementById('upl-img');
        upl_img.remove();

    });

    // function deleteWelocomeImage() {
    //     reset($('#screen_delete'));
    //     var input = $("#screen_delete");
    //     input.replaceWith(input.val('').clone(true));
    //     document.getElementById("tmp-mage").style.display = "block";
    //     document.getElementById('add-icon').style.display = "block";
    //     let upl_img = document.getElementById('upl-img');
    //     upl_img.remove();
    //     document.getElementById("input-image").appendChild(elem);
    //     document.getElementById('edit-icon').style.display = 'none';
    //     document.getElementById('screen_delete').style.display = 'none';

    // }
    if (document.getElementById('screen')) {
        var screen = document.getElementById('screen')
        screen.onchange = evt => {
            console.log("file uploaded")
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
                // par.innerHTML = `<img id="blah" src="${URL.createObjectURL(file)}" alt="your image" />`
                // blah.src = URL.createObjectURL(file)
            }
        }
    }


    var logoImg = document.getElementById('qr_code_logo')

    if (logoImg) {
        logoImg.onchange = evt => {
            console.log("file uploaded")
            const [file] = logoImg.files
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
                // document.getElementById('screen_delete').style.visibility = "visible";
                // par.innerHTML = `<img id="blah" src="${URL.createObjectURL(file)}" alt="your image" />`
                // blah.src = URL.createObjectURL(file)
            }
        }
    }
    $("#logo_delete").on("click", function() {
        // var control = $("#screen");
        // control.replaceWith(control = control.clone(true));
        $('#qr_code_logo').val('');

        document.getElementById('edit-logo-icon').style.display = "none";
        document.getElementById('logo_delete').style.display = "none";
        document.getElementById("logo-tmp-mage").style.display = 'block';
        document.getElementById('add-logo-icon').style.display = 'block';
        // let upl_img = document.getElementById('logo-upl-img');
        $('#logo-upl-img').remove();

    });


    $("#cl_screen_delete").on("click", function() {
        // var control = $("#screen");
        // control.replaceWith(control = control.clone(true));
        $('#companyLogo').val('');

        document.getElementById('company_log_edit_icon').style.display = "none";
        document.getElementById('cl_screen_delete').style.display = "none";
        document.getElementById("cl-tmp-mage").style.display = 'block';
        document.getElementById('company_log_add_icon').style.display = 'block';
        // let upl_img = document.getElementById('logo-upl-img');
        $('#cl-upl-img').remove();

    });
    if (document.getElementById('companyLogo')) {
        var companyLogo = document.getElementById('companyLogo')
        companyLogo.onchange = evt => {
            console.log("file uploaded")
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
    // imgUploadForm.addEventListener('submit', function (e) {
    //   e.preventDefault();
    //   alert('Images Uploaded! (not really, but it would if this was on your website)');
    // }, false);

    function previewImgs(event) {
        totalFiles = imgUpload.files.length;

        if (!!totalFiles) {
            imgPreview.classList.remove('quote-imgs-thumbs--hidden');
            // previewTitle = document.createElement('p');
            // previewTitle.style.fontWeight = 'bold';
            // previewTitleText = document.createTextNode(totalFiles + ' Total Images Selected');
            // previewTitle.appendChild(previewTitleText);
            // imgPreview.appendChild(previewTitle);
        }
        // console.log("sger" ,event.target.files);
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
        console.log("remove", id)
        const img_div = document.getElementById('img_div');
        img_div.addEventListener('click', () => {
            img_div.remove();
        });
    }

    // QR code frame URL PATH and ID
    function getQRFromUrl(d) {
        console.log("here---frame")
        $("#qr_frame_path").val(d.getAttribute("data-qrframeurl"));
        $("#qr_frame_id").val(d.getAttribute("data-qrframeid"));
        document.getElementById("qr_frame_id").value = d.getAttribute("data-qrframeid");
        document.getElementById("qr_frame_path").value = d.getAttribute("data-qrframeurl");
        $("#qr_frame_id_tmp").click();
        $("#qr_frame_path_tmp").click();

    }
</script>

<script type="text/javascript">
    // document.getElementById("loader").style.display = "block";
    // document.getElementById("iframesrc").style.visibility = "hidden";

    // function showIt2() {
    document.getElementById("iframesrc").style.visibility = "visible";
    document.getElementById("loader").style.display = "none";
    // }
    // setTimeout("showIt2()", 1000); // after 5 secs
</script>

<script>
    $("#dot").click(function() {
        $("#dot").addClass('active');
        $("#round").removeClass('active');
        $("#square").removeClass('active');
    });
    $("#round").click(function() {
        $("#dot").removeClass('active');
        $("#round").addClass('active');
        $("#square").removeClass('active');
    });
    $("#square").click(function() {
        $("#dot").removeClass('active');
        $("#round").removeClass('active');
        $("#square").addClass('active');
    });

    $("#RE").click(function() {
        $("#CE").removeClass('active');
        $("#RE").addClass('active');
    });

    $("#CE").click(function() {
        $("#RE").removeClass('active');
        $("#CE").addClass('active');
    });

    // $(document).on('change', '#isGradientSelected', function() {

    //     if ($(this).is(":checked")) {

    //         $('#gradient').show();
    //     } else {
    //         $('#gradient').hide();
    //     }
    // });

    $(document).ready(function() {
        $("#isGradientSelected").change(function() {
            console.log("here", $("#isGradientSelected").val())
            var selectedOption = $("#isGradientSelected").val()
            if (selectedOption == 'gradient') {

                $('#gradient').show();
            } else {
                $('#gradient').hide();
            }
        });
    });

    // ForgroundColorFirst - changeForgroundColor - ForgroundColorSecond

    $(document).ready(function() {

        $("#passwordField").hide();
        $("#changeForgroundColor").click(
            function() {
                var one = $("#ForgroundColorFirst").val()
                var second = $("#ForgroundColorSecond").val()
                $("#ForgroundColorFirst").val(second)
                $("#ForgroundColorSecond").val(one)
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
            // $("#qr_frame_enabled").click();
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
            $("#ForgroundColorSpan").html(selectedOption)
        });
        $("#BackgroundColor").change(function() {
            let selectedOption = $("#BackgroundColor").val()
            $("#BackgroundColorSpan").html(selectedOption)
        });



        $("#ForgroundColorFirst").change(function() {
            var selectedOption = $("#ForgroundColorFirst").val()
            $("#ForgroundColorFirstSpan").html(selectedOption)
        });
        $("#ForgroundColorSecond").change(function() {
            var selectedOption = $("#ForgroundColorSecond").val()
            $("#ForgroundColorSecondSpan").html(selectedOption)
        });

        // EIColorSpan

        $("#EIColor").change(function() {
            let selectedOption = $("#EIColor").val()
            $("#EIColorSpan").html(selectedOption)
        });
        $("#EOColor").change(function() {
            let selectedOption = $("#EOColor").val()
            $("#EOColorSpan").html(selectedOption)
        });

        $("input, textarea").on("keyup", function() {
            console.log("valid");
            if (step == 2) {
                let allAreFilled = true;
                document.getElementById("myform").querySelectorAll("[required]").forEach(function(i) {
                    // console.log("iiii", i);
                    if (!allAreFilled) return;
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
                })
                console.log("valid", allAreFilled);
                if (!allAreFilled) {
                    $('#temp_next').hide();
                    $('#temp_next_tmp').show();
                } else {
                    $('#temp_next_tmp').hide();
                    $('#temp_next').show();
                }
            }

            // let valid = true;
            // $('[required]').each(function() {
            //     if ($(this).is(':invalid') || !$(this).val()) valid = false;
            // })
            // console.log("valid", valid);
            // if (!valid) {
            //     $('#temp_next').attr('disabled', 'disabled');
            // } else {
            //     $('#temp_next').removeAttr('disabled');
            // }
        });


        for (let index = 1; index < 6; index++) {
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
        $("#formcolorPalette1").click(
            function() {
                $("#primaryColor").val("#2F6BFD")
                $("#SecondaryColor").val("#0E379A")
                LoadPreview()
            });

        $("#formcolorPalette2").click(
            function() {
                $("#primaryColor").val("#28EDC9")
                $("#SecondaryColor").val("#03A183")
                LoadPreview()
            });

        $("#formcolorPalette3").click(
            function() {
                $("#primaryColor").val("#28ED28")
                $("#SecondaryColor").val("#00A301")
                LoadPreview()
            });

        $("#formcolorPalette4").click(
            function() {
                $("#primaryColor").val("#EDE728")
                $("#SecondaryColor").val("#A39E0A")
                LoadPreview()
            });

        $("#formcolorPalette5").click(
            function() {
                $("#primaryColor").val("#ED4C28")
                $("#SecondaryColor").val("#A31F01")
                LoadPreview()
            });


    });
</script>

<script>
    $("#social").hide();

    function remove_me(elm) {
        $(elm).parent().parent().remove();
    }

    function remove_me_up(elm) {
        $(elm).parent().parent().parent().remove();
        LoadPreview();
    }

    $(function() {
        $('#passcheckbox').on('change', function() {
            console.log("checked", $(this).prop('checked'))
            // var checked = $(this).prop('checked');
            $('#passwordField').prop('disabled', !$(this).prop('checked'));
            $("#passwordField").val('');
            if ($(this).prop('checked')) {

                $("#passwordBlock").append(`<input autocomplete="new-password" id="passwordField" type="password" name="password" class="form-control" value="" maxlength="30" data-reload-qr-code />`);
            } else {
                $("#passwordField").remove();
            }
        });
    });
</script>


<?php \Altum\Event::add_content(ob_get_clean(), 'javascript') ?>