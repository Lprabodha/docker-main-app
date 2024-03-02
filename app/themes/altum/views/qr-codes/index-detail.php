<?php defined('ALTUMCODE') || die() ?>
<?php
$qr_code = $data->qr_code ?? [];
$qr_code['data'] = json_decode($qr_code['data'], true);
$campaign_info = $data->campaign_info ?? [];
// dd($qr_code['data']['type']);

$qrCount = database()->query("SELECT COUNT(*) AS `qr_code_id` FROM `qr_codes` WHERE `user_id` = {$this->user->user_id} AND `status` = '1'")->fetch_object()->qr_code_id ?? 0;

?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css">
<link rel="stylesheet" type="text/css" href="<?= SITE_URL . 'js/material-date-range-picker/duDatepicker.min.css' ?>">

<style>


</style>

<form id="filterForm" class="filter-form-wrp" name="filter_form" method="POST" action="<?= url('dashboard/export') ?>">

    <input type="hidden" name="qr_code[]" value="<?php echo $qr_code['qr_code_id']; ?>">

    <div id="myQrCode">
        <div class="myQrCode-inner" id="qrCodeDetail">
            <section class="container-fluid qrDetail qr-detail-container space-block">
                <?= \Altum\Alerts::output_alerts() ?>
                <div class="custom-heading-wrp d-flex justify-content-between align-items-center scale-block">
                    <div class="d-flex align-items-center">
                        <a href="<?= url('qr-codes') ?>" class="back-btn mr-2">
                            <svg class="MuiSvgIcon-root jss2013" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 16px; margin-right: 3px;">
                                <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"></path>
                            </svg>
                        </a>
                        <h1 class="h4 custom-heading m-0"><?= $qr_code['name'] ?></h1>
                    </div>
                    <div class="d-flex align-items-center">
                        <div id="btnPauseOrResume">
                            <?php
                            if ($qr_code['status'] == '1' || $qr_code['status'] == '2') :
                                if ($qr_code['status'] == '1') : ?>
                                    <button type="button" class="btn outline-btn mr-md-3 mr-2 d-flex align-items-center justify-content-center actionBtn" id="PauseModalOpenBtn" data-toggle="modal" data-target="#PauseModal">
                                        <span class="start-icon icon-pause mr-md-2 mr-0"></span>
                                        <span class="text d-md-block d-none"><?= l('qr_code.qr_code_status.pause') ?></span>
                                    </button>
                                <?php else : ?>
                                    <button class="btn outline-btn mr-md-3 mr-2 d-flex align-items-center actionBtn justify-content-center" type="button" id="ResumeModalOpenBtn" data-toggle="modal" data-target="#ResumeModal">
                                        <span class="start-icon icon-play-circle mr-md-2 mr-0 d-flex">
                                        </span>
                                        <span class="text d-md-block d-none"><?= l('qr_code.resume') ?></span>
                                    </button>
                                <?php endif ?>
                            <?php endif ?>
                        </div>
                        <div>
                            <a class="btn outline-btn d-flex align-items-center mr-md-3 mr-2 download-btn downloadBtn" data-toggle="modal" data-target="#DownloadModal">
                                <span class="start-icon icon-download mr-md-2 mr-0">
                                </span>
                                <span class="text d-md-block d-none"><?= l('qr_code.download') ?></span>
                            </a>
                        </div>
                        <div>
                            <a href="<?= url('qr/' . $qr_code['qr_code_id']) ?>" class="btn primary-btn d-flex align-items-center ">
                                <span class="start-icon icon-edit mr-md-2 mr-0">
                                </span>
                                <span class="text d-md-block d-none"><?= l('qr_code.edit') ?></span>
                            </a>
                        </div>
                    </div>

                </div>


                <div class="detail-card scale-block">
                    <div class="row mx-0 w-100">

                        <div class="col-md-7 col-lg-7 col-xl-4 qr-scans-info">
                            <div class="detail-head">
                                <span>
                                    <span class="icon-qr icon-scan-barcode"></span>
                                    <?= l('qr_codes.type.' . $qr_code['type']) ?>
                                </span>
                                <span>
                                    <span class="icon-qr icon-folder"></span>
                                    <?= (isset($qr_code['project_id']) && isset($data->projects[$qr_code['project_id']])) ? $data->projects[$qr_code['project_id']]->name : l('qr_code.no_folder') ?>
                                </span>
                                <span>
                                    <?php if ($qr_code['type'] === 'url') {
                                        $url = $qr_code['data']['url'];
                                        $parsed_url = parse_url($url);
                                        if (isset($parsed_url['scheme']) && ($parsed_url['scheme'] == 'https' || $parsed_url['scheme'] == 'http')) {
                                            $website = $qr_code['data']['url'];
                                        } else {
                                            $website =  '//' . $qr_code['data']['url'];
                                        }
                                    ?>
                                        <span class="icon-qr icon-redirect"></span>
                                        <a href="<?= $website ?>" target="_blank">
                                            <?php
                                            $url = $qr_code['data']['url'];
                                            echo strlen($url) > 45 ? substr($url, 0, 45) . '...' : $url;
                                            ?>
                                        </a>
                                    <?php } else { ?>

                                        <span class="icon-qr icon-global"></span>
                                        <a href="<?= (isset($qr_code['link_id']) && isset($data->links[$qr_code['link_id']])) ? $data->links[$qr_code['link_id']]->location_url : LANDING_PAGE_URL . 'p/' . $qr_code['uId'] ?>" target="_blank">
                                            <?= (isset($qr_code['link_id']) && isset($data->links[$qr_code['link_id']])) ? $data->links[$qr_code['link_id']]->location_url : LANDING_PAGE_URL . 'p/' . $qr_code['uId'] ?>
                                        </a>
                                    <?php } ?>
                                </span>
                            </div>
                            <div class="scan-info">
                                <span class="text"><?= l('qr_code.total_scan') ?></span>
                                <span class="count">
                                    <h4 id="totalScanCounter"><?= number_format($qr_code['total_scan']) ?? 0 ?></h4>
                                </span>
                            </div>

                        </div>
                        <div class="detail-inner qr-info-block col-xl-5 col-lg-7 col-md-7 col-sm-9">
                            <div class="innerLeft">
                                <div class="detailContainer" data-toggle="modal" data-target="#campaign" style="cursor: pointer;">
                                    <div class="detailBox">
                                        <span class="badge">
                                            <span class="icon-medium act-btn-icon"></span>
                                        </span>
                                        <div>
                                            <span><?= l('qr_code.medium') ?></span>
                                            <label data-toggle="modal" data-target="#campaign"><span id="campaignMediumLable" style="max-width:100px; font-weight: 500;"><?= (!empty($campaign_info) && is_array($campaign_info) && isset($campaign_info['medium'])) ? $campaign_info['medium'] : '-' ?></span>
                                                <svg class="MuiSvgIcon-root jss135" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 16px;">
                                                    <path d="M20.71,6.29l-3-3a1,1,0,0,0-1.42,0l-12,12a1,1,0,0,0-.26.47l-1,4a1,1,0,0,0,.26.95A1,1,0,0,0,4,21a1,1,0,0,0,.24,0l4-1a1,1,0,0,0,.47-.26l12-12A1,1,0,0,0,20.71,6.29ZM7.49,18.1l-2.12.53.53-2.12,8.6-8.6L16.09,9.5Zm10-10L15.91,6.5,17,5.41,18.59,7Z"></path>
                                                </svg>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="detailBox">
                                        <span class="badge">
                                            <span class="icon-print-run act-btn-icon"></span>
                                        </span>
                                        <div>
                                            <span><?= l('qr_code.print_run') ?></span>
                                            <label data-toggle="modal" data-target="#campaign"><span id="pritnRunLable" style=" font-weight: 500;"><?= (!empty($campaign_info) && is_array($campaign_info) && isset($campaign_info['print_run'])) ? $campaign_info['print_run'] : '-' ?></span>
                                                <svg class="MuiSvgIcon-root jss135" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 16px;">
                                                    <path d="M20.71,6.29l-3-3a1,1,0,0,0-1.42,0l-12,12a1,1,0,0,0-.26.47l-1,4a1,1,0,0,0,.26.95A1,1,0,0,0,4,21a1,1,0,0,0,.24,0l4-1a1,1,0,0,0,.47-.26l12-12A1,1,0,0,0,20.71,6.29ZM7.49,18.1l-2.12.53.53-2.12,8.6-8.6L16.09,9.5Zm10-10L15.91,6.5,17,5.41,18.59,7Z"></path>
                                                </svg>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="detailContainer" data-toggle="modal" data-target="#campaign" style="cursor: pointer;">
                                    <div class="detailBox">
                                        <span class="badge">
                                            <span class="icon-calendar act-btn-icon"></span>
                                        </span>
                                        <div>
                                            <span><?= l('qr_code.start_of_campaign') ?></span>
                                            <label data-toggle="modal" data-target="#campaign">
                                                <span id="campaignStarDateLable" style=" font-weight: 500;">
                                                    <?= (!empty($campaign_info) && is_array($campaign_info) && isset($campaign_info['start_date'])) ? date("M d, Y", strtotime($campaign_info['start_date'])) : '-' ?>
                                                </span>
                                                <svg class="MuiSvgIcon-root jss135" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 16px;">
                                                    <path d="M20.71,6.29l-3-3a1,1,0,0,0-1.42,0l-12,12a1,1,0,0,0-.26.47l-1,4a1,1,0,0,0,.26.95A1,1,0,0,0,4,21a1,1,0,0,0,.24,0l4-1a1,1,0,0,0,.47-.26l12-12A1,1,0,0,0,20.71,6.29ZM7.49,18.1l-2.12.53.53-2.12,8.6-8.6L16.09,9.5Zm10-10L15.91,6.5,17,5.41,18.59,7Z"></path>
                                                </svg>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="detailBox">
                                        <span class="badge">
                                            <span class="icon-calendar act-btn-icon"></span>
                                        </span>
                                        <div>
                                            <span><?= l('qr_code.end_of_campaign') ?></span>
                                            <label data-toggle="modal" data-target="#campaign">
                                                <span id="campaignEndDateLable" style=" font-weight: 500;"><?= (!empty($campaign_info) && is_array($campaign_info) && isset($campaign_info['end_date'])) ? date("M d, Y", strtotime($campaign_info['end_date'])) : '-' ?></span>
                                                <svg class="MuiSvgIcon-root jss135" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 16px;">
                                                    <path d="M20.71,6.29l-3-3a1,1,0,0,0-1.42,0l-12,12a1,1,0,0,0-.26.47l-1,4a1,1,0,0,0,.26.95A1,1,0,0,0,4,21a1,1,0,0,0,.24,0l4-1a1,1,0,0,0,.47-.26l12-12A1,1,0,0,0,20.71,6.29ZM7.49,18.1l-2.12.53.53-2.12,8.6-8.6L16.09,9.5Zm10-10L15.91,6.5,17,5.41,18.59,7Z"></path>
                                                </svg>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="detail-inner qr-code-block  col-xl-3 col-md-5 col-lg-5 col-sm-3 qrdetail-top-qr-block">
                            <div class="innerRight">
                                <div class="scan-box" style="padding-bottom:0px">
                                    <div class="scanImg" data-toggle="modal" data-target="#QRcodeModal">
                                        <embed src="<?= SITE_URL . 'uploads/qr_codes/logo/' . $qr_code['qr_code'] ?>?<?= time() ?>" class="img-fluid scan-img-obj" style="width: 60%; height: 60%; pointer-events: none;"></embed>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="detail-card qr-code-block">

                    <div class="card-body">
                        <div class="dropdown-group my-qr datepicker-options-wrps scale-block">
                            <div class="date-time">
                                <div class="dateItem">
                                    <div class=" align-items-center w-100 datepicker-parent">
                                        <input class="form-control" name="date_range" placeholder="Oct 10, 2022 - Nov 10, 2022" id="kt_daterangepicker_1" onclick="javascript:this.blur();this.onfocus=()=>this.blur()" style="cursor: pointer;" readonly />
                                        <input class="form-control" type="hidden" id="pop_picker" onclick="javascript:this.blur();this.onfocus=()=>this.blur()" />
                                        <span class="icon-calendar" id="pop_picker_icon" style="pointer-events:none;"></span>
                                    </div>
                                </div>

                            </div>

                            <div class="exp options d-flex">
                                <div class="export-info export-btn-wrap">
                                    <button class="btn outline-btn export-btn btn-with-icon" type="button" id="exportBtn">
                                        <span class="icon-export"></span>
                                        <span class="text-long">
                                            <?= l('qr_code.export_information') ?>
                                        </span>
                                        <span class="text-short">
                                            <?= l('qr_code.export_short') ?>

                                        </span>
                                    </button>
                                </div>

                                <div class="export-info pe-0 reset-btn-wrap">
                                    <button class="btn outline-btn export-btn btn-with-icon" type="button" id="resetScans">
                                        <span class="reset-icon d-flex">
                                            <svg width="20px" height="20px" viewBox="0 0 21 21" xmlns="http://www.w3.org/2000/svg">
                                                <g fill="none" fill-rule="evenodd" stroke="#28c254" stroke-linecap="round" stroke-linejoin="round" transform="matrix(0 1 1 0 2.5 2.5)">
                                                    <path d="m3.98652376 1.07807068c-2.38377179 1.38514556-3.98652376 3.96636605-3.98652376 6.92192932 0 4.418278 3.581722 8 8 8s8-3.581722 8-8-3.581722-8-8-8" />
                                                    <path d="m4 1v4h-4" transform="matrix(1 0 0 -1 0 6)" />
                                                </g>
                                            </svg>
                                        </span>
                                        <span class="reset-text-long">
                                            <?= l('qr_code.reset_scans') ?>
                                        </span>
                                        <span class="reset-mobile">
                                            <?= l('qr_code.reset_scans.mobile') ?>
                                        </span>
                                    </button>
                                </div>
                            </div>

                        </div>



                        <!-- before scan qr-code -->
                        <?php if (isset($qr_code['total_scan']) && $qr_code['total_scan'] != '' && $qr_code['total_scan'] > 0) : ?>
                            <div class="qrrecord-container mt-1">
                                <div class="scan-activities">
                                    <div class="card">
                                        <div class="cardHeader"><?= l('qr_code.scan_activites') ?></div>
                                        <div class="cardBody custom-legend">
                                            <div class="legend-box" id="legendBox"></div>
                                            <div class="chart-container custom-tooltip" id="canvasContainer">
                                                <canvas id="pageviews_chart"></canvas>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php else : ?>
                            <div class="codepannel qr-code-panel scale-block">
                                <div class="codepannel-inner qrcode-detailview">
                                    <div class="codepannel-img">
                                        <object data="<?= SITE_URL . 'uploads/qr_codes/logo/' . $qr_code['qr_code'] ?>?<?= time() ?>" class="img-fluid"></object>
                                        <!-- <span class="border-set"></span> -->
                                        <span class="corners-set corners-up"></span>
                                        <span class="corners-set corners-down"></span>
                                    </div>
                                </div>
                                <p class="text-center mt-3 mb-3"><?= l('qr_code.scan_message') ?></p>
                            </div>
                        <?php endif ?>

                    </div>

                </div>

                <?php if (isset($qr_code['total_scan']) && $qr_code['total_scan'] != '' && $qr_code['total_scan'] > 0) : ?>
                    <div class="row">
                        <!-- <?php if ($qr_code['data']["type"] == 'feedback') { ?>
                                                <div class="col-xxl-4 mb-xxl-0 mb-2 scan-by-blocks qr-detail-view">
                                                    <div class="scan-by-block">
                                                        <div class="title-block">
                                                            <span><?= l('qr_code.feedback_results') ?></span>
                                                        </div>
                                                        <div class="content-block"  id="feedbackCateory">
                                                            <div class="collapseInner">
                                                                <div class="custom-table">
                                                                    
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="col-xxl-4 mb-xxl-0 mb-2 scan-by-blocks qr-detail-view">
                                                        <div class="scan-by-block">
                                                            <div class="title-block">
                                                                <span><?= l('qr_code.feedback_reviews') ?></span>
                                                            </div>
                                                            <div class="content-block"  id="feedbackReview">
                                                                <div class="collapseInner">
                                                                    <div class="custom-table">
                                                                        
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <?php } ?> -->
                        <div class="col-xxl-4 mb-xxl-0 mb-2 scan-by-blocks qr-detail-view">
                            <div class="scan-by-block">
                                <div class="title-block">
                                    <span><?= l('qr_code.scan_by_operating_system') ?></span>
                                </div>
                                <div class="content-block " id="scanOS">
                                    <div class="row">
                                        <div class="col-sm-4 col-auto dougnut-wrp">
                                            <canvas id="osChart">
                                            </canvas>
                                        </div>
                                        <div class="col-sm-8 col-12 d-flex align-items-center">
                                            <div class="legend w-100" id="osLegend">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="norecords"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-4 mb-xxl-0 mb-2 scan-by-blocks qr-detail-view">
                            <div class="scan-by-block">
                                <div class="title-block">
                                    <span><?= l('qr_code.scan_by_country') ?> </span>
                                </div>
                                <div class="content-block" id="scanCountry">
                                    <div class="row">
                                        <div class="col-sm-4 col-auto dougnut-wrp">
                                            <canvas id="countryChart">
                                            </canvas>
                                        </div>
                                        <div class="col-sm-8 col-12 d-flex align-items-center">
                                            <div class="legend w-100" id="countryLegend">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="norecords"></div>

                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-4 mb-xxl-0 mb-2 scan-by-blocks qr-detail-view">
                            <div class="scan-by-block">
                                <div class="title-block">
                                    <span><?= l('qr_code.scan_by_region_city') ?></span>
                                </div>
                                <div class="content-block" id="scanCity">
                                    <div class="row">
                                        <div class="col-sm-4 col-auto dougnut-wrp">
                                            <canvas id="cityChart">

                                            </canvas>
                                        </div>
                                        <div class="col-sm-8 col-12 d-flex align-items-center">
                                            <div class="legend w-100" id="cityLegend">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="norecords"></div>
                                </div>
                            </div>

                        </div>

                    </div>
                <?php endif ?>
                <!-- after scan qr-code -->
            </section>
        </div>
    </div>
    </div>

    <?php require THEME_PATH . 'views/qr-codes/js_qr_code.php' ?>
    <?php \Altum\Event::add_content(include_view(THEME_PATH . 'views/partials/universal_delete_modal_form.php', [
        'name' => 'qr_code',
        'resource_id' => 'qr_code_id',
        'has_dynamic_resource_name' => true,
        'path' => 'qr-codes/delete'
    ]), 'modals'); ?>



    <!-- Export info Modal -->
    <div class="modal custom-modal download-modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-dialog-export">
            <div class="modal-content">
                <div class="modal-header align-items-start">
                    <h1><?= l('qr_code.export_information') ?></h1>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <svg class="MuiSvgIcon-root jss709" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 20px;">
                            <path d="M13.41,12l5.3-5.29a1,1,0,1,0-1.42-1.42L12,10.59,6.71,5.29A1,1,0,0,0,5.29,6.71L10.59,12l-5.3,5.29a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0L12,13.41l5.29,5.3a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42Z"></path>
                        </svg>
                    </button>
                </div>
                <div class="modal-body p-0">
                    <div class="form-group mb-2">
                        <button class="btn outline-btn m-0" name="CSV" onclick="download('csv')">CSV</button>
                    </div>
                    <div class="form-group mb-2">
                        <button class="btn outline-btn m-0" name="XLSX" onclick="download('xlsx')">XLSX</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


</form>
<!-- Pause Modal -->
<div class="modal smallmodal fade" id="PauseModal" tabindex="-1" aria-labelledby="PauseModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-export">
        <div class="modal-content extra-space">
            <button type="button" class="close d-none" data-dismiss="modal" aria-label="Close">
                <svg class="MuiSvgIcon-root jss709" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 20px;">
                    <path d="M13.41,12l5.3-5.29a1,1,0,1,0-1.42-1.42L12,10.59,6.71,5.29A1,1,0,0,0,5.29,6.71L10.59,12l-5.3,5.29a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0L12,13.41l5.29,5.3a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42Z"></path>
                </svg>
            </button>
            <div class="modal-img">
                <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 140 140">
                    <defs>
                        <style>
                            .cls-1 {
                                fill: #e5e7ef;
                            }

                            .cls-2 {
                                fill: #fff;
                            }
                        </style>
                    </defs>
                    <circle class="cls-1" cx="70" cy="70" r="70" />
                    <path class="cls-2" d="M87.5,70c-.17,0-.33,0-.5,0V47.49a4,4,0,0,0-4-4H45.6a4,4,0,0,0-4,4v37.4a4,4,0,0,0,4,4H73.68A14.5,14.5,0,1,0,87.5,70Z" />
                    <path d="M88,69V47.49a5,5,0,0,0-5-5H45.6a5,5,0,0,0-5,5v37.4a5,5,0,0,0,5,5H73A15.49,15.49,0,1,0,88,69ZM45.6,87.89a3,3,0,0,1-3-3V47.49a3,3,0,0,1,3-3H83a3,3,0,0,1,3,3V69.08A15.51,15.51,0,0,0,72,84.5a15.12,15.12,0,0,0,.39,3.39ZM87.5,98A13.5,13.5,0,1,1,101,84.5,13.52,13.52,0,0,1,87.5,98Z" />
                    <path d="M60,48.66H49.27a2.5,2.5,0,0,0-2.5,2.5V61.92a2.5,2.5,0,0,0,2.5,2.5H60a2.5,2.5,0,0,0,2.5-2.5V51.16A2.5,2.5,0,0,0,60,48.66Zm1.5,13.26a1.5,1.5,0,0,1-1.5,1.5H49.27a1.5,1.5,0,0,1-1.5-1.5V51.16a1.5,1.5,0,0,1,1.5-1.5H60a1.5,1.5,0,0,1,1.5,1.5Z" />
                    <path d="M68.57,64.42H79.32a2.5,2.5,0,0,0,2.5-2.5V51.16a2.5,2.5,0,0,0-2.5-2.5H68.57a2.5,2.5,0,0,0-2.5,2.5V61.92A2.5,2.5,0,0,0,68.57,64.42Zm-1.5-13.26a1.5,1.5,0,0,1,1.5-1.5H79.32a1.5,1.5,0,0,1,1.5,1.5V61.92a1.5,1.5,0,0,1-1.5,1.5H68.57a1.5,1.5,0,0,1-1.5-1.5Z" />
                    <path d="M60,68H49.27a2.5,2.5,0,0,0-2.5,2.5V81.22a2.51,2.51,0,0,0,2.5,2.5H60a2.51,2.51,0,0,0,2.5-2.5V70.46A2.5,2.5,0,0,0,60,68Zm1.5,13.26a1.51,1.51,0,0,1-1.5,1.5H49.27a1.5,1.5,0,0,1-1.5-1.5V70.46a1.5,1.5,0,0,1,1.5-1.5H60a1.5,1.5,0,0,1,1.5,1.5Z" />
                    <rect x="51.31" y="53.2" width="6.68" height="6.68" rx="1.5" />
                    <rect x="51.31" y="72.5" width="6.68" height="6.68" rx="1.5" />
                    <path d="M72.74,73.13V69.46a1.5,1.5,0,0,0-1.5-1.5H67.57a1.5,1.5,0,0,0-1.5,1.5v3.67a1.5,1.5,0,0,0,1.5,1.5h3.67A1.5,1.5,0,0,0,72.74,73.13Zm-1,0a.5.5,0,0,1-.5.5H67.57a.5.5,0,0,1-.5-.5V69.46a.5.5,0,0,1,.5-.5h3.67a.5.5,0,0,1,.5.5Z" />
                    <rect x="70.61" y="53.2" width="6.68" height="6.68" rx="1.5" />
                    <path d="M84.51,80A1.5,1.5,0,0,0,83,81.5v5.55a1.5,1.5,0,0,0,3,0V81.5A1.5,1.5,0,0,0,84.51,80Z" />
                    <path d="M90.51,80A1.5,1.5,0,0,0,89,81.5v5.55a1.5,1.5,0,0,0,3,0V81.5A1.5,1.5,0,0,0,90.51,80Z" />
                </svg>
                <p><?= l('qr_code.selected_qr_paused_message') ?></p>
            </div>
            <div class="modal-body modal-btn justify-content-center">
                <button class="btn primary-btn grey-btn  m-0 r-4 me-2" type="button" data-dismiss="modal" aria-label="Close"><?= l('qr_code.cancel') ?></button>
                <button class="btn primary-btn r-4 footerActionBtn " type="button" name="qr_status_paused"><?= l('qr_code.qr_code_status.pause') ?></button>
            </div>
        </div>
    </div>
</div>
<!-- Resume Modal -->
<div class="modal smallmodal fade" id="ResumeModal" tabindex="-1" aria-labelledby="ResumeModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-export">
        <div class="modal-content extra-space">
            <button type="button" class="close d-none" data-dismiss="modal" aria-label="Close">
                <svg class="MuiSvgIcon-root jss709" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 20px;">
                    <path d="M13.41,12l5.3-5.29a1,1,0,1,0-1.42-1.42L12,10.59,6.71,5.29A1,1,0,0,0,5.29,6.71L10.59,12l-5.3,5.29a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0L12,13.41l5.29,5.3a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42Z"></path>
                </svg>
            </button>
            <div class="modal-img">
                <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 140 140">
                    <defs>
                        <style>
                            .cls-1 {
                                fill: #e5e7ef;
                            }

                            .cls-2 {
                                fill: #fff;
                            }
                        </style>
                    </defs>
                    <circle class="cls-1" cx="70" cy="70" r="70" />
                    <path class="cls-2" d="M87.5,70c-.17,0-.33,0-.5,0V47.49a4,4,0,0,0-4-4H45.6a4,4,0,0,0-4,4v37.4a4,4,0,0,0,4,4H73.68A14.5,14.5,0,1,0,87.5,70Z" />
                    <path d="M88,69V47.49a5,5,0,0,0-5-5H45.6a5,5,0,0,0-5,5v37.4a5,5,0,0,0,5,5H73A15.49,15.49,0,1,0,88,69ZM45.6,87.89a3,3,0,0,1-3-3V47.49a3,3,0,0,1,3-3H83a3,3,0,0,1,3,3V69.08A15.51,15.51,0,0,0,72,84.5a15.12,15.12,0,0,0,.39,3.39ZM87.5,98A13.5,13.5,0,1,1,101,84.5,13.52,13.52,0,0,1,87.5,98Z" />
                    <path d="M60,48.66H49.27a2.5,2.5,0,0,0-2.5,2.5V61.92a2.5,2.5,0,0,0,2.5,2.5H60a2.5,2.5,0,0,0,2.5-2.5V51.16A2.5,2.5,0,0,0,60,48.66Zm1.5,13.26a1.5,1.5,0,0,1-1.5,1.5H49.27a1.5,1.5,0,0,1-1.5-1.5V51.16a1.5,1.5,0,0,1,1.5-1.5H60a1.5,1.5,0,0,1,1.5,1.5Z" />
                    <path d="M68.57,64.42H79.32a2.5,2.5,0,0,0,2.5-2.5V51.16a2.5,2.5,0,0,0-2.5-2.5H68.57a2.5,2.5,0,0,0-2.5,2.5V61.92A2.5,2.5,0,0,0,68.57,64.42Zm-1.5-13.26a1.5,1.5,0,0,1,1.5-1.5H79.32a1.5,1.5,0,0,1,1.5,1.5V61.92a1.5,1.5,0,0,1-1.5,1.5H68.57a1.5,1.5,0,0,1-1.5-1.5Z" />
                    <path d="M60,68H49.27a2.5,2.5,0,0,0-2.5,2.5V81.22a2.51,2.51,0,0,0,2.5,2.5H60a2.51,2.51,0,0,0,2.5-2.5V70.46A2.5,2.5,0,0,0,60,68Zm1.5,13.26a1.51,1.51,0,0,1-1.5,1.5H49.27a1.5,1.5,0,0,1-1.5-1.5V70.46a1.5,1.5,0,0,1,1.5-1.5H60a1.5,1.5,0,0,1,1.5,1.5Z" />
                    <rect x="51.31" y="53.2" width="6.68" height="6.68" rx="1.5" />
                    <rect x="51.31" y="72.5" width="6.68" height="6.68" rx="1.5" />
                    <path d="M72.74,73.13V69.46a1.5,1.5,0,0,0-1.5-1.5H67.57a1.5,1.5,0,0,0-1.5,1.5v3.67a1.5,1.5,0,0,0,1.5,1.5h3.67A1.5,1.5,0,0,0,72.74,73.13Zm-1,0a.5.5,0,0,1-.5.5H67.57a.5.5,0,0,1-.5-.5V69.46a.5.5,0,0,1,.5-.5h3.67a.5.5,0,0,1,.5.5Z" />
                    <rect x="70.61" y="53.2" width="6.68" height="6.68" rx="1.5" />
                    <path d="M84.51,80A1.5,1.5,0,0,0,83,81.5v5.55a1.5,1.5,0,0,0,3,0V81.5A1.5,1.5,0,0,0,84.51,80Z" />
                    <path d="M90.51,80A1.5,1.5,0,0,0,89,81.5v5.55a1.5,1.5,0,0,0,3,0V81.5A1.5,1.5,0,0,0,90.51,80Z" />
                </svg>
                <p><?= l('qr_code.select_qr_code_resume_message') ?></p>
            </div>
            <div class="modal-body modal-btn justify-content-center">
                <button class="btn primary-btn grey-btn  m-0 r-4 me-2" type="button" data-dismiss="modal" aria-label="Close"><?= l('qr_code.cancel') ?></button>
                <button class="btn primary-btn r-4 footerActionBtn" type="button" name="qr_status_resume"><?= l('qr_code.resume') ?></button>
            </div>
        </div>
    </div>
</div>

<!-- Download to Modal -->
<?php include_once(THEME_PATH . '/views/qr-codes/components/download-model.php') ?>

<!-- Custom share modal -->
<?php include_once(THEME_PATH . '/views/qr-codes/components/custom-share-popup.php') ?>

<!-- Pop View model -->
<?php include_once('components/modals.php'); ?>


<!-- Save Campaign information Modal -->
<div class="modal custom-modal smallmodal fade" id="campaign" tabindex="-1" aria-labelledby="campaign" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-export">
        <div class="modal-content">
            <div class="modal-header align-items-start">
                <h1><?= l('qr_code.campaign_information') ?></h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <svg class="MuiSvgIcon-root jss709" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 20px;">
                        <path d="M13.41,12l5.3-5.29a1,1,0,1,0-1.42-1.42L12,10.59,6.71,5.29A1,1,0,0,0,5.29,6.71L10.59,12l-5.3,5.29a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0L12,13.41l5.29,5.3a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42Z"></path>
                    </svg>
                </button>

            </div>
            <form id="saveCampaign" name="edit_folder_form" action="javascript:void(0)" target="_blank">
                <input type="hidden" name="user_id" value="<?php echo $data->user_id; ?>">
                <input type="hidden" name="qr_code_id" value="<?php echo $qr_code['qr_code_id']; ?>">
                <input type="hidden" id="campaignId" name="campaign_id" value="<?php echo isset($campaign_info['id']) ? $campaign_info['id'] : '' ?>">
                <div class="inputContainer">
                    <div class="form-group mb-4" data-type="url" data-url="">
                        <label for="medium"><?= l('qr_code.medium') ?></label>
                        <select name="medium" id="medium" class="form-control">
                            <option disabled selected><?= l('qr_code.select') ?></option>
                            <option value="Art" <?= (!empty($campaign_info) && is_array($campaign_info) && isset($campaign_info['medium']) && $campaign_info['medium'] == 'Art') ? "selected='selected'" : '' ?>><?= l('qr_code.art') ?></option>
                            <option value="Badges" <?= (!empty($campaign_info) && is_array($campaign_info) && isset($campaign_info['medium']) && $campaign_info['medium'] == 'Badges') ? "selected='selected'" : '' ?>><?= l('qr_code.badges') ?></option>
                            <option value="Banners" <?= (!empty($campaign_info) && is_array($campaign_info) && isset($campaign_info['medium']) && $campaign_info['medium'] == 'Banners') ? "selected='selected'" : '' ?>><?= l('qr_code.banners') ?></option>
                            <option value="Billboards" <?= (!empty($campaign_info) && is_array($campaign_info) && isset($campaign_info['medium']) && $campaign_info['medium'] == 'Billboards') ? "selected='selected'" : '' ?>><?= l('qr_code.billboards') ?></option>
                            <option value="Books" <?= (!empty($campaign_info) && is_array($campaign_info) && isset($campaign_info['medium']) && $campaign_info['medium'] == 'Books') ? "selected='selected'" : '' ?>><?= l('qr_code.books') ?></option>
                            <option value="Bottles and cans" <?= (!empty($campaign_info) && is_array($campaign_info) && isset($campaign_info['medium']) && $campaign_info['medium'] == 'Bottles and cans') ? "selected='selected'" : '' ?>><?= l('qr_code.bottles_and_cans') ?></option>
                            <option value="Catalogues" <?= (!empty($campaign_info) && is_array($campaign_info) && isset($campaign_info['medium']) && $campaign_info['medium'] == 'Catalogues') ? "selected='selected'" : '' ?>><?= l('qr_code.catalogues') ?></option>
                            <option value="Clothing" <?= (!empty($campaign_info) && is_array($campaign_info) && isset($campaign_info['medium']) && $campaign_info['medium'] == 'Clothing') ? "selected='selected'" : '' ?>><?= l('qr_code.clothing') ?></option>
                            <option value="Digital signage" <?= (!empty($campaign_info) && is_array($campaign_info) && isset($campaign_info['medium']) && $campaign_info['medium'] == 'Digital signage') ? "selected='selected'" : '' ?>><?= l('qr_code.digital_signage') ?></option>
                            <option value="Displays" <?= (!empty($campaign_info) && is_array($campaign_info) && isset($campaign_info['medium']) && $campaign_info['medium'] == 'Displays') ? "selected='selected'" : '' ?>><?= l('qr_code.displays') ?></option>
                            <option value="Ebooks" <?= (!empty($campaign_info) && is_array($campaign_info) && isset($campaign_info['medium']) && $campaign_info['medium'] == 'Ebooks') ? "selected='selected'" : '' ?>><?= l('qr_code.ebooks') ?></option>
                            <option value="Emails" <?= (!empty($campaign_info) && is_array($campaign_info) && isset($campaign_info['medium']) && $campaign_info['medium'] == 'Emails') ? "selected='selected'" : '' ?>><?= l('qr_code.emails') ?></option>
                            <option value="Flyers" <?= (!empty($campaign_info) && is_array($campaign_info) && isset($campaign_info['medium']) && $campaign_info['medium'] == 'Flyers') ? "selected='selected'" : '' ?>><?= l('qr_code.flyers') ?></option>
                            <option value="Food packaging" <?= (!empty($campaign_info) && is_array($campaign_info) && isset($campaign_info['medium']) && $campaign_info['medium'] == 'Food packaging') ? "selected='selected'" : '' ?>><?= l('qr_code.food_packaging') ?></option>
                            <option value="Gifts" <?= (!empty($campaign_info) && is_array($campaign_info) && isset($campaign_info['medium']) && $campaign_info['medium'] == 'Gifts') ? "selected='selected'" : '' ?>><?= l('qr_code.gifts') ?></option>
                            <option value="Infographics" <?= (!empty($campaign_info) && is_array($campaign_info) && isset($campaign_info['medium']) && $campaign_info['medium'] == 'Infographics') ? "selected='selected'" : '' ?>><?= l('qr_code.inforgtaphics') ?></option>
                            <option value="Labels and stickers" <?= (!empty($campaign_info) && is_array($campaign_info) && isset($campaign_info['medium']) && $campaign_info['medium'] == 'Labels and stickers') ? "selected='selected'" : '' ?>><?= l('qr_code.label_and_stickers') ?></option>
                            <option value="Menus" <?= (!empty($campaign_info) && is_array($campaign_info) && isset($campaign_info['medium']) && $campaign_info['medium'] == 'Menus') ? "selected='selected'" : '' ?>><?= l('qr_code.menus') ?></option>
                            <option value="Movie advertising" <?= (!empty($campaign_info) && is_array($campaign_info) && isset($campaign_info['medium']) && $campaign_info['medium'] == 'Movie advertising') ? "selected='selected'" : '' ?>><?= l('qr_code.movie_advertising') ?></option>
                            <option value="Newspapers and magazines" <?= (!empty($campaign_info) && is_array($campaign_info) && isset($campaign_info['medium']) && $campaign_info['medium'] == 'Newspapers and magazines') ? "selected='selected'" : '' ?>><?= l('qr_code.newspaper_magazine') ?></option>
                            <option value="No material" <?= (!empty($campaign_info) && is_array($campaign_info) && isset($campaign_info['medium']) && $campaign_info['medium'] == 'No material') ? "selected='selected'" : '' ?>><?= l('qr_code.no_material') ?></option>
                            <option value="Poster" <?= (!empty($campaign_info) && is_array($campaign_info) && isset($campaign_info['medium']) && $campaign_info['medium'] == 'Poster') ? "selected='selected'" : '' ?>><?= l('qr_code.poster') ?></option>
                            <option value="Product packaging" <?= (!empty($campaign_info) && is_array($campaign_info) && isset($campaign_info['medium']) && $campaign_info['medium'] == 'Product packaging') ? "selected='selected'" : '' ?>><?= l('qr_code.product_packaging') ?></option>
                            <option value="Shop windows" <?= (!empty($campaign_info) && is_array($campaign_info) && isset($campaign_info['medium']) && $campaign_info['medium'] == 'Shop windows') ? "selected='selected'" : '' ?>><?= l('qr_code.shop_windows') ?></option>
                            <option value="Social media" <?= (!empty($campaign_info) && is_array($campaign_info) && isset($campaign_info['medium']) && $campaign_info['medium'] == 'Social media') ? "selected='selected'" : '' ?>><?= l('qr_code.social_media') ?></option>
                            <option value="Stationary" <?= (!empty($campaign_info) && is_array($campaign_info) && isset($campaign_info['medium']) && $campaign_info['medium'] == 'Stationary') ? "selected='selected'" : '' ?>><?= l('qr_code.stationary') ?></option>
                            <option value="Street signs" <?= (!empty($campaign_info) && is_array($campaign_info) && isset($campaign_info['medium']) && $campaign_info['medium'] == 'Street signs') ? "selected='selected'" : '' ?>><?= l('qr_code.street_signs') ?></option>
                            <option value="TV commercials" <?= (!empty($campaign_info) && is_array($campaign_info) && isset($campaign_info['medium']) && $campaign_info['medium'] == 'TV commercials') ? "selected='selected'" : '' ?>><?= l('qr_code.tv_commercials') ?></option>
                            <option value="Table tents" <?= (!empty($campaign_info) && is_array($campaign_info) && isset($campaign_info['medium']) && $campaign_info['medium'] == 'Table tents') ? "selected='selected'" : '' ?>><?= l('qr_code.table_tents') ?></option>
                            <option value="Tickets" <?= (!empty($campaign_info) && is_array($campaign_info) && isset($campaign_info['medium']) && $campaign_info['medium'] == 'Tickets') ? "selected='selected'" : '' ?>><?= l('qr_code.tickets') ?></option>
                            <option value="Vehicles" <?= (!empty($campaign_info) && is_array($campaign_info) && isset($campaign_info['medium']) && $campaign_info['medium'] == 'Vehicles') ? "selected='selected'" : '' ?>><?= l('qr_code.vehicles') ?></option>
                            <option value="Video games" <?= (!empty($campaign_info) && is_array($campaign_info) && isset($campaign_info['medium']) && $campaign_info['medium'] == 'Video games') ? "selected='selected'" : '' ?>><?= l('qr_code.video_games') ?></option>
                            <option value="Web banners" <?= (!empty($campaign_info) && is_array($campaign_info) && isset($campaign_info['medium']) && $campaign_info['medium'] == 'Web banners') ? "selected='selected'" : '' ?>><?= l('qr_code.web_banners') ?></option>
                            <option value="Websites" <?= (!empty($campaign_info) && is_array($campaign_info) && isset($campaign_info['medium']) && $campaign_info['medium'] == 'Websites') ? "selected='selected'" : '' ?>><?= l('qr_code.websites') ?></option>
                        </select>
                    </div>
                    <div class="form-group mb-4" data-type="url" data-url="">
                        <label for="print"><?= l('qr_code.print_run') ?></label>
                        <input type="number" id="print" name="print_run" placeholder="E.g. 1000" class="form-control" value="<?= (!empty($campaign_info) && is_array($campaign_info) && isset($campaign_info['print_run'])) ? $campaign_info['print_run'] : '' ?>" data-reload-qr-code="">
                    </div>
                    <div class="form-group qr-details-date-input-wrp" data-type="url" data-url="">
                        <label class="date-input-label-qrdetail" for="startDate"><?= l('qr_code.start_of_campaign') ?></label>
                        <input type="text" id="startDate" placeholder="mm/dd/yyyy" name="start_date" class="form-control qr-details-date-input" value="<?= (!empty($campaign_info) && is_array($campaign_info) && isset($campaign_info['start_date'])) ? date("Y-m-d", strtotime($campaign_info['start_date'])) : '' ?>" data-reload-qr-code="">
                        <span class="icon-calendar pickdate"></span>
                    </div>
                    <div class="form-group qr-details-date-input-wrp" data-type="url" data-url="">
                        <label class="date-input-label-qrdetail" for="endDate"><?= l('qr_code.end_of_campaign') ?></label>
                        <input type="text" placeholder="mm/dd/yyyy" id="endDate" name="end_date" class="form-control qr-details-date-input" value="<?= (!empty($campaign_info) && is_array($campaign_info) && isset($campaign_info['end_date'])) ? date("Y-m-d", strtotime($campaign_info['end_date'])) : '' ?>" data-reload-qr-code>
                        <span class="icon-calendar pickdate"></span>
                    </div>
                </div>
                <div class="modal-body modal-btn modalFooter ">
                    <button class="btn primary-btn grey-btn  m-0 r-4 me-2" type="button" data-dismiss="modal" aria-label="Close"><?= l('qr_code.cancel') ?></button>
                    <button type="button" class="btn primary-btn r-4" id="saveCampaignBtn" name="Save"><?= l('qr_code.update') ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Reset scan Modal -->
<div class="modal smallmodal fade" id="resetScanModal" tabindex="-1" aria-labelledby="resetScanModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-export">
        <div class="modal-content extra-space reset-model-wrap">
            <button type="button" class="close reset-close" data-dismiss="modal" aria-label="Close">
                <svg class="MuiSvgIcon-root jss709" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 20px;">
                    <path d="M13.41,12l5.3-5.29a1,1,0,1,0-1.42-1.42L12,10.59,6.71,5.29A1,1,0,0,0,5.29,6.71L10.59,12l-5.3,5.29a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0L12,13.41l5.29,5.3a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42Z"></path>
                </svg>
            </button>
            <div class="modal-img">
                <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 140 140">
                    <defs>
                        <style>
                            .cls-1 {
                                fill: #e5e7ef;
                            }

                            .cls-2 {
                                fill: #fff;
                            }
                        </style>
                    </defs>
                    <circle class="cls-1" cx="70" cy="70" r="70" />
                    <path class="cls-2" d="M89,70.08V47.49a4,4,0,0,0-4-4H45.6a4,4,0,0,0-4,4v37.4a4,4,0,0,0,4,4H73.68A14.5,14.5,0,1,0,89,70.08Z" />
                    <path d="M51.5,51.72H48.28a1.52,1.52,0,0,1-1.51-1.51V50a1.51,1.51,0,0,1,1.51-1.5H51.5A1.51,1.51,0,0,1,53,50v.21A1.51,1.51,0,0,1,51.5,51.72ZM48.28,49.5a.51.51,0,0,0-.51.5v.21a.51.51,0,0,0,.51.51H51.5a.51.51,0,0,0,.5-.51V50a.51.51,0,0,0-.5-.5Z" />
                    <path d="M50.5,63.19H49.27a2.5,2.5,0,0,0-2.5,2.5v8.53a2.51,2.51,0,0,0,2.5,2.5H50.5a2.51,2.51,0,0,0,2.5-2.5V65.69A2.5,2.5,0,0,0,50.5,63.19Zm1.5,11a1.5,1.5,0,0,1-1.5,1.5H49.27a1.5,1.5,0,0,1-1.5-1.5V65.69a1.5,1.5,0,0,1,1.5-1.5H50.5a1.5,1.5,0,0,1,1.5,1.5Z" />
                    <path d="M51.5,79.5H48.28A1.51,1.51,0,0,0,46.77,81v.21a1.52,1.52,0,0,0,1.51,1.51H51.5A1.51,1.51,0,0,0,53,81.21V81A1.51,1.51,0,0,0,51.5,79.5Zm.5,1.71a.51.51,0,0,1-.5.51H48.28a.51.51,0,0,1-.51-.51V81a.51.51,0,0,1,.51-.5H51.5a.51.51,0,0,1,.5.5Z" />
                    <rect x="47.27" y="49" width="5.23" height="2.22" rx="1" />
                    <path d="M61.5,79.5H58.28A1.51,1.51,0,0,0,56.77,81v.21a1.52,1.52,0,0,0,1.51,1.51H61.5A1.51,1.51,0,0,0,63,81.21V81A1.51,1.51,0,0,0,61.5,79.5Zm.5,1.71a.51.51,0,0,1-.5.51H58.28a.51.51,0,0,1-.51-.51V81a.51.51,0,0,1,.51-.5H61.5a.51.51,0,0,1,.5.5Z" />
                    <path d="M60.5,59H59.27a2.5,2.5,0,0,0-2.5,2.5V74.22a2.51,2.51,0,0,0,2.5,2.5H60.5a2.51,2.51,0,0,0,2.5-2.5V61.5A2.5,2.5,0,0,0,60.5,59ZM62,74.22a1.5,1.5,0,0,1-1.5,1.5H59.27a1.5,1.5,0,0,1-1.5-1.5V61.5a1.5,1.5,0,0,1,1.5-1.5H60.5A1.5,1.5,0,0,1,62,61.5Z" />
                    <path d="M69.27,76.72H70.5a2.51,2.51,0,0,0,2.5-2.5V57.5A2.5,2.5,0,0,0,70.5,55H69.27a2.5,2.5,0,0,0-2.5,2.5V74.22A2.51,2.51,0,0,0,69.27,76.72ZM67.77,57.5a1.5,1.5,0,0,1,1.5-1.5H70.5A1.5,1.5,0,0,1,72,57.5V74.22a1.5,1.5,0,0,1-1.5,1.5H69.27a1.5,1.5,0,0,1-1.5-1.5Z" />
                    <path d="M90,69.22V47.49a5,5,0,0,0-5-5H45.6a5,5,0,0,0-5,5v37.4a5,5,0,0,0,5,5H73A15.49,15.49,0,1,0,90,69.22ZM45.6,87.89a3,3,0,0,1-3-3V47.49a3,3,0,0,1,3-3H85a3,3,0,0,1,3,3V69c-.17,0-.33,0-.5,0a15.55,15.55,0,0,0-4.5.67V53.5A2.5,2.5,0,0,0,80.5,51H79.27a2.5,2.5,0,0,0-2.5,2.5V73.34a15.46,15.46,0,0,0-4.11,6.72,1.51,1.51,0,0,0-1.16-.56H68.28A1.51,1.51,0,0,0,66.77,81v.21a1.52,1.52,0,0,0,1.51,1.51H71.5a1.5,1.5,0,0,0,.63-.15,14.73,14.73,0,0,0,.26,5.32ZM82,70a15.29,15.29,0,0,0-4.23,2.42v-19a1.5,1.5,0,0,1,1.5-1.5H80.5A1.5,1.5,0,0,1,82,53.5ZM72,81v.21a.51.51,0,0,1-.5.51H68.28a.51.51,0,0,1-.51-.51V81a.51.51,0,0,1,.51-.5H71.5A.51.51,0,0,1,72,81ZM87.5,98A13.5,13.5,0,1,1,101,84.5,13.52,13.52,0,0,1,87.5,98Z" />
                    <path d="M89,82H82.41l2.3-2.29a1,1,0,0,0-1.42-1.42l-4,4a1,1,0,0,0,0,1.42l4,4a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42L82.41,84H89a3,3,0,0,1,3,3v2a1,1,0,0,0,2,0V87A5,5,0,0,0,89,82Z" />
                </svg>
                <p><?= l('qr_code.scan_confrim_message') ?></p>
            </div>
            <div class="modal-body modal-btn reset-model-btn-wrap">
                <button class="btn primary-btn grey-btn reset-cansel-btn m-0" type="button" data-dismiss="modal" aria-label="Close"><?= l('qr_code.cancel') ?></button>
                <button class="btn primary-btn footerActionBtn" type="button" name="reset_scan"><?= l('qr_code.yes_reset') ?></button>
            </div>
        </div>
    </div>
</div>

<?php ob_start() ?>


<!-- <script type="text/javascript" src="<?= SITE_URL . 'js/material-date-range-picker/duDatepicker.min.js' ?>"></script> -->
<script type="text/javascript" src="<?= SITE_URL . 'js/material-date-range-picker/duDatepicker.js' ?>"></script>
<script src="<?= ASSETS_FULL_URL . 'js/libraries/Chart.bundle.min.js' ?>"></script>
<!-- <script src="<?= ASSETS_FULL_URL . 'js/chartjs_defaults.js' ?>"></script> -->
<script src="<?= ASSETS_FULL_URL . 'js/libraries/chart.js' ?>"></script>
<script type="text/javascript">
    $(".pickdate").on("click", function() {
        $(this).parent().children('input').focus();
    });
    var campaignStarDateLable = document.getElementById('campaignStarDateLable');
    if (campaignStarDateLable.innerText) {
        var x = campaignStarDateLable.closest('.detailBox')
    }
    /* Pageviews chart */
    function chart(chartData) {
        if (chartData) {
            var maxPageviews = Math.max(...chartData.pageviews);
            var maxVisitors = Math.max(...chartData.visitors);
            var max;
            if (maxPageviews >= maxVisitors) {
                if (maxPageviews <= 5) {
                    max = 5;
                } else {
                    max = maxPageviews;
                }

            } else {
                max = maxVisitors;
            }

            if (maxPageviews > 5) {
                max = Math.ceil(max / 10) * 10;
            }
            $(".chart-container").html('<canvas id="pageviews_chart"></canvas>');
            let pageviews_chart = document.getElementById('pageviews_chart').getContext('2d');
            let pageviews_color = '#10b981';
            let pageviews_gradient = pageviews_chart.createLinearGradient(0, 0, 0, 250);
            pageviews_gradient.addColorStop(0, 'rgba(16, 185, 129, .1)');
            pageviews_gradient.addColorStop(1, 'rgba(16, 185, 129, 0.025)');
            let visitors_color = '#3b82f6';
            let visitors_gradient = pageviews_chart.createLinearGradient(0, 0, 0, 250);
            visitors_gradient.addColorStop(0, 'rgba(59, 130, 246, .1)');
            visitors_gradient.addColorStop(1, 'rgba(59, 130, 246, 0.025)');

            /* Display chart */
            const data = {
                labels: chartData.labels,
                datasets: [{
                        label: '<?= l('qr_code.scans') ?>',
                        data: chartData.pageviews,
                        backgroundColor: pageviews_gradient,
                        borderColor: pageviews_color,
                        borderWidth: 1,
                        fill: true
                    },
                    {
                        label: '<?= l('qr_code.unique_scans') ?>',
                        data: chartData.visitors,
                        backgroundColor: visitors_gradient,
                        borderColor: visitors_color,
                        borderWidth: 1,
                        fill: true
                    },
                ],

            };
            const bar = {
                id: 'bar',
                beforeDatasetsDraw(chart) {
                    const {
                        ctx,
                        tooltip,
                        scales: {
                            x,
                            y
                        },
                        chartArea: {
                            top,
                            bottom,
                            left,
                            right,
                            width,
                            height
                        }
                    } = chart;
                    if (tooltip._active[0]) {
                        var cords = tooltip._active[0].element.x;
                        var grad = ctx.createLinearGradient(0, top, 0, bottom);
                        grad.addColorStop(0, 'rgba(29, 92, 249,1)');
                        grad.addColorStop(1, 'rgba(29, 92, 249,0.3)');
                        ctx.beginPath();
                        ctx.strokeStyle = grad;
                        ctx.lineWidth = 2;
                        ctx.setLineDash([2, 2]);
                        ctx.moveTo(cords, tooltip.yAlign === 'top' ? tooltip.caretY + 6 : tooltip.caretY - 30);
                        ctx.lineTo(cords, bottom);
                        ctx.stroke();
                        // Calculate the height from the bottom of the chart to the tooltip
                        const tooltipHeight = bottom - (tooltip.yAlign === 'top' ? tooltip.caretY + 6 : tooltip.caretY - 6);
                    }


                }
            };

            const getOrCreateLegendList = (chart, id) => {
                const legendContainer = document.getElementById(id);
                let legendList = legendContainer.querySelector('UL');
                if (!legendList) {
                    legendList = document.createElement('UL');
                    legendList.classList.add('chartLegend');
                    legendContainer.appendChild(legendList);
                }
                return legendList;
            }


            const getOrCreateTooltip = (chart) => {
                let tooltipEl = chart.canvas.parentNode.querySelector('div');

                if (!tooltipEl) {
                    tooltipEl = document.createElement('div');
                    tooltipEl.classList.add('custom-tooltip-block');
                    tooltipEl.setAttribute('id', 'toolTipBlock');
                    tooltipEl.style.background = 'white';
                    tooltipEl.style.borderRadius = '10px';
                    tooltipEl.style.fontWeight = 'bold';
                    tooltipEl.style.color = visitors_color;
                    tooltipEl.style.opacity = 0.6;
                    tooltipEl.style.pointerEvents = 'none';
                    tooltipEl.style.position = 'absolute';
                    tooltipEl.style.transform = 'translate(-50%, 0)';
                    tooltipEl.style.transition = 'all .1s ease';
                    tooltipEl.style.padding = 8;

                    const table = document.createElement('table');
                    table.style.margin = '0px';

                    tooltipEl.appendChild(table);
                    chart.canvas.parentNode.appendChild(tooltipEl);
                }

                return tooltipEl;
            };

            const externalTooltipHandler = (context) => {
                // Tooltip Element
                const {
                    chart,
                    tooltip
                } = context;
                const tooltipEl = getOrCreateTooltip(chart);

                // Hide if no tooltip
                if (tooltip.opacity === 0) {
                    tooltipEl.style.opacity = 0;
                    return;
                }

                // Set Text
                if (tooltip.body) {
                    const titleLines = tooltip.title || [];
                    const bodyLines = tooltip.body.map(b => b.lines);

                    const tableHead = document.createElement('thead');
                    const tableBody = document.createElement('tbody');

                    let objectDate = new Date();
                    // let year = objectDate.getFullYear()

                    titleLines.forEach(title => {
                        const parts = title.split("-");
                        const year = parts[0];
                        const monthAndDate = parts[1];

                        const tr = document.createElement('tr');
                        tr.style.borderWidth = 0;

                        const th = document.createElement('th');
                        th.style.borderWidth = 0;
                        const text = document.createTextNode(monthAndDate + ", " + year);
                        tr.appendChild(text);
                        tableBody.appendChild(tr);
                    });

                    bodyLines.forEach((body, i) => {
                        const tr = document.createElement('tr');
                        tr.style.borderWidth = 0;

                        const th = document.createElement('th');
                        th.style.borderWidth = 0;
                        const text = document.createTextNode(body);

                        const splitStrings = [];
                        for (const string of body) {
                            splitStrings.push(string.split(":"));
                        }

                        tableBody.appendChild(tr);
                        splitStrings.forEach((splitString) => {
                            for (const string of splitString) {
                                const td = document.createElement('td');
                                td.style.borderWidth = 0;
                                const texttd = document.createTextNode(string);

                                td.appendChild(texttd);
                                tr.appendChild(td);
                            }
                        });

                    });

                    const tableRoot = tooltipEl.querySelector('table');

                    // Remove old children
                    while (tableRoot.firstChild) {
                        tableRoot.firstChild.remove();
                    }

                    // Add new children
                    tableRoot.appendChild(tableHead);
                    tableRoot.appendChild(tableBody);
                }

                const {
                    offsetLeft: positionX,
                    offsetTop: positionY
                } = chart.canvas;

                // Display, position, and set styles for font
                tooltipEl.style.opacity = 1;
                tooltipEl.style.left = positionX + tooltip.caretX + 'px';
                tooltipEl.style.top = (positionY + tooltip.caretY) - 120 + 'px';
                tooltipEl.style.font = tooltip.options.bodyFont.string;
                tooltipEl.style.padding = tooltip.options.padding + 'px ' + tooltip.options.padding + 'px';
                // Tooltip remover
                var canvas = document.getElementById('pageviews_chart');
                // var message = document.getElementById('toolTipBlock');

                // Event listener for touchmove
                document.addEventListener('touchmove', function(event) {

                    // console.log(canvas);
                    // console.log(message);
                    var touch = event.touches[0];
                    var touchX = touch.clientX;
                    var touchY = touch.clientY;

                    var canvasRect = canvas.getBoundingClientRect();
                    var canvasLeft = canvasRect.left;
                    var canvasTop = canvasRect.top;
                    var canvasRight = canvasRect.right;
                    var canvasBottom = canvasRect.bottom;

                    if (
                        touchX < canvasLeft ||
                        touchX > canvasRight ||
                        touchY < canvasTop ||
                        touchY > canvasBottom
                    ) {
                        tooltipEl.style.display = 'none';
                    } else {
                        tooltipEl.style.display = 'block';
                    }
                });
                // Tooltip remover
            };

            const htmlLegendPlugin = {
                id: 'htmlLegend',
                afterUpdate(chart, args, options) {

                    const ul = getOrCreateLegendList(chart, options.containerID);

                    while (ul.firstChild) {
                        ul.firstChild.remove()
                    }

                    const legendItems = chart.options.plugins.legend.labels.generateLabels(chart);
                    legendItems.forEach((item, index, arr) => {
                        const li = document.createElement('LI');
                        li.classList.add('legendItem');

                        li.onclick = () => {
                            const {
                                type
                            } = chart.config;
                            if (type === 'pie' || type === 'doughnut') {
                                chart.toggleDatavisibility(item.index);
                            } else {
                                chart.setDatasetVisibility(item.datasetIndex, !chart.isDatasetVisible(item.datasetIndex));
                            }
                            chart.update();
                        }

                        const colorBox = document.createElement('SPAN');
                        colorBox.classList.add('color-box');
                        colorBox.style.backgroundColor = item.strokeStyle;

                        const textBox = document.createElement('SPAN');
                        textBox.classList.add('text-box');
                        textBox.style.color = item.hidden ? '#ccc' : item.fontColor;
                        const text = document.createTextNode(item.text);

                        li.appendChild(colorBox);
                        li.appendChild(textBox);
                        textBox.appendChild(text);
                        ul.appendChild(li);
                    })
                }
            };

            const formattedLabels = data.labels.map(date => date.substring(5));

            const config = {
                type: 'line',
                data,
                options: {
                    layout: {
                        padding: {
                            top: 15,
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                callback: function(value, index, ticks) {
                                    return formattedLabels[value];
                                }
                            },
                            bounds: data.labels.length == 1 ? [0, 100] : [0, 0],
                            offset: data.labels.length == 1 ? true : false,

                        },
                        y: {
                            grid: {
                                display: true,
                            },
                            beginAtZero: true,
                            ticks: {
                                padding: 0,
                                stepSize: maxPageviews <= 5 ? 1 : 0,
                            },
                            border: {
                                dash: [4, 8],
                            },
                            suggestedMin: 0,
                            suggestedMax: max,
                        },

                    },
                    interaction: {
                        mode: 'index',
                    },

                    plugins: {
                        legend: {
                            display: false,
                        },
                        tooltip: {
                            enabled: false,
                            mode: 'index',
                            intersect: false,
                            caretPadding: 20,
                            bodyLineHeight: 1.2,
                            position: 'nearest',
                            backgroundColor: '#FFFFFF',
                            displayColors: false,
                            bodySpacing: 8,
                            multiKeyBackground: '#fff',
                            usePointStyle: true,
                            borderWidth: 1,
                            borderColor: '#EBEBEB',
                            bodyFont: {
                                size: 16,
                                weight: 700,
                            },
                            external: externalTooltipHandler,
                            // callbacks: {
                            //   labelTextColor: (context) => {
                            //     return context.dataset.borderColor;
                            //   },
                            //   title: function(context) {
                            //     return '';
                            //   },
                            //   afterTitle: (context) => {

                            //   },
                            // },
                        },
                        htmlLegend: {
                            containerID: 'legendBox'

                        },
                    },
                    responsive: true,
                    maintainAspectRatio: false,
                    pointRadius: 0,
                    pointHoverRadius: 5,
                    pointHoverBorderWidth: 2,
                    pointHitRadius: 15,
                    hoverBackgroundColor: 'white',
                },
                plugins: [
                    bar,
                    htmlLegendPlugin,
                ]
            };


            const myChart = new Chart(
                pageviews_chart,
                config,
            );

            Chart.Tooltip.positioners.top = function(elements, eventPosition) {

                const {
                    chartArea: {
                        top
                    },
                    scales: {
                        x,
                        y
                    }
                } = this.chart;
                return {
                    x: x.getPixelForValue(x.getValueForPixel(eventPosition.x)),
                    y: top + 5,
                    xAlign: 'center',
                    yAlign: 'bottom',
                }

            };


        } else {
            $(".chart-container").html('<div class="no-records-wrp"><p class="noRecordMsg"><?= l('qr_code.no_data') ?></p></div>');
        }

    }
    // Doughnut Chart
    let lengthLimit = 20;
    let backgroundColor = [
        "#8CE6A5",
        "#EC9E72",
        "#F8CA71",
        "#FBE275",
        "#E6DD8C",
        "#C9E68C",
        "#65D0BD",
        "#5D82D5",
        "#D55DA5",
        "#D55D64",
        //new color code
        "#8CE6A5",
        "#EC9E72",
        "#F8CA71",
        "#FBE275",
        "#E6DD8C",
        "#C9E68C",
        "#65D0BD",
        "#5D82D5",
        "#D55DA5",
        "#D55D64",
    ];
    let str;
    let osChart;
    let countryChart;
    let cityChart;

    function legendData(chartData) {
        const max = chartData.values.reduce((a, b) => (a + b), 0);
        const idx = []
        $.each(chartData.values, function(k, v) {
            idx.push((v / max * 100).toFixed(0));
        });
        str = ""
        str += '<table class="custom-grid-table-wrp w-100">';
        str += '<tbody>';
        $.each(chartData.labels, function(k, v) {
            if (k => 0) {
                var prse
                str += '<tr><td><div><span style="background-color:' + backgroundColor[k] + ';"></span> ' + chartData.labels[k] + '</div></td><td>' + chartData.values[k] + '</td><td style="text-align:center;background-color:' + chartData.labels[k] + '">' + idx[k] + '%</td></tr>';
            }
        });
        str += '</tbody></table>';
        return str;
    }

    async function osDoughnutChart(chartData) {

        if (chartData.values.length > 0) {
            str = legendData(chartData);
            if (chartData.values.length > 20) {
                chartData.labels.length = chartData.values.length = lengthLimit;
            }

            const ctx = $('#osChart');
            if (osChart) {
                osChart.destroy();
                $(".scan-by-block .content-block#scanOS .row").css("max-height", "1000px");
                $(".scan-by-block .content-block#scanOS .norecords .no-records-wrp").remove();
                osChart = new Chart(ctx, configuration(chartData));
                $("#osLegend").html(str);

            } else {
                $(".scan-by-block .content-block#scanOS .row").css("max-height", "1000px");
                $(".scan-by-block .content-block#scanOS .norecords .no-records-wrp").remove();
                osChart = new Chart(ctx, configuration(chartData));
                $("#osLegend").html(str);
            }
        } else {
            if (osChart) {
                osChart.destroy();
            }
            $(".scan-by-block .content-block#scanOS .row").css("max-height", "0px");
            $(".scan-by-block .content-block#scanOS .norecords").html('<div class="no-records-wrp"><p class="noRecordMsg"><?= l('qr_code.no_data') ?></p></div>');
            $('#osLegend table').remove();

        }
    }

    async function countryDoughnutChart(chartData) {
        if (chartData.values.length > 0) {
            str = legendData(chartData);
            if (chartData.values.length > 20) {
                chartData.labels.length = chartData.values.length = lengthLimit;
            }

            const ctx = $('#countryChart');
            if (countryChart) {
                countryChart.destroy();
                $(".scan-by-block .content-block#scanCountry .row").css("max-height", "1000px");
                $(".scan-by-block .content-block#scanCountry .norecords .no-records-wrp").remove();
                countryChart = new Chart(ctx, configuration(chartData));
                $("#countryLegend").html(str);
            } else {
                $(".scan-by-block .content-block#scanCountry .row").css("max-height", "1000px");
                $(".scan-by-block .content-block#scanCountry .norecords .no-records-wrp").remove();
                countryChart = new Chart(ctx, configuration(chartData));
                $("#countryLegend").html(str);
            }
        } else {
            if (countryChart) {
                countryChart.destroy();
            }
            $(".scan-by-block .content-block#scanCountry .row").css("max-height", "0px");
            $(".scan-by-block .content-block#scanCountry .norecords").html('<div class="no-records-wrp"><p class="noRecordMsg"><?= l('qr_code.no_data') ?></p></div>');
            $('#countryLegend table').remove();

        }
    }

    async function cityDoughnutChart(chartData) {
        if (chartData.values.length > 0) {
            str = legendData(chartData);
            if (chartData.values.length > 20) {
                chartData.labels.length = chartData.values.length = lengthLimit;
            }

            const ctx = $('#cityChart');
            if (cityChart) {
                cityChart.destroy();
                $(".scan-by-block .content-block#scanCity .row").css("max-height", "1000px");
                $(".scan-by-block .content-block#scanCity .norecords .no-records-wrp").remove();
                cityChart = new Chart(ctx, configuration(chartData));
                $("#cityLegend").html(str);

            } else {
                $(".scan-by-block .content-block#scanCity .row").css("max-height", "1000px");
                $(".scan-by-block .content-block#scanCity .norecords .no-records-wrp").remove();
                cityChart = new Chart(ctx, configuration(chartData));
                $("#cityLegend").html(str);
            }
        } else {
            if (cityChart) {
                cityChart.destroy();
            }
            $(".scan-by-block .content-block#scanCity .row").css("max-height", "0px");
            $(".scan-by-block .content-block#scanCity .norecords").html('<div class="no-records-wrp"><p class="noRecordMsg"><?= l('qr_code.no_data') ?></p></div>');
            $('#cityLegend table').remove();

        }
    }

    function configuration(chartData) {
        const legendMarginRight = {
            id: 'legendMarginRight',
            afterInit(chart, args, options) {

                const fitValue = chart.legend.fit;
                chart.legend.fit = function fit() {
                    fitValue.bind(chart.legend)();
                    let width = this.width = 200;
                    return width;
                }
            }
        }

        const configuration = {
            type: 'doughnut',
            data: {
                labels: chartData.labels,
                datasets: [{
                    data: chartData.values,
                    backgroundColor: backgroundColor,
                }],
                hoverOffset: 4,
            },
            options: {

                plugins: {
                    legend: {
                        display: false,
                    }
                },

            },
            plugins: [legendMarginRight]
        }

        return configuration;
    }
    // Doughnut Chart

    function configuration(chartData) {

        const legendMarginRight = {
            id: 'legendMarginRight',
            afterInit(chart, args, options) {
                const fitValue = chart.legend.fit;
                chart.legend.fit = function fit() {
                    fitValue.bind(chart.legend)();
                    let width = this.width = 200;
                    return width;
                }
            }
        }

        const configuration = {
            type: 'doughnut',
            data: {
                labels: chartData.labels,
                datasets: [{
                    data: chartData.values,
                    backgroundColor: backgroundColor
                }, ],
                hoverOffset: 4
            },
            options: {
                elements: {
                    arc: {
                        borderWidth: 0,
                    }
                },
                plugins: {
                    legend: {
                        display: false,
                    }
                },

            },
            plugins: [legendMarginRight]
        }

        return configuration;

    }
    // Doughnut Chart
</script>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js"></script>

<link href="<?= ASSETS_FULL_URL . 'css/daterangepicker.min.css' ?>" rel="stylesheet" media="screen,print">
<script src="<?= ASSETS_FULL_URL . 'js/libraries/moment.min.js' ?>"></script>
<script src="<?= ASSETS_FULL_URL . 'js/libraries/daterangepicker.min.js' ?>"></script>
<script src="<?= ASSETS_FULL_URL . 'js/libraries/moment-timezone-with-data-10-year-range.min.js' ?>"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
<script>
    window.onload = function() {

        var months = '<?= l('global.date.long_months.1') ?>_<?= l('global.date.long_months.2') ?>_<?= l('global.date.long_months.3') ?>_<?= l('global.date.long_months.4') ?>_<?= l('global.date.long_months.5') ?>_<?= l('global.date.long_months.6') ?>_<?= l('global.date.long_months.7') ?>_<?= l('global.date.long_months.8') ?>_<?= l('global.date.long_months.9') ?>_<?= l('global.date.long_months.10') ?>_<?= l('global.date.long_months.11') ?>_<?= l('global.date.long_months.12') ?>'.split('_'),

            days = '<?= l('global.date.short_days.7') ?>_<?= l('global.date.short_days.1') ?>_<?= l('global.date.short_days.2') ?>_<?= l('global.date.short_days.3') ?>_<?= l('global.date.short_days.4') ?>_<?= l('global.date.short_days.5') ?>_<?= l('global.date.short_days.6') ?>'.split('_');

        duDatepicker('#pop_picker', {
            range: true,
            clearBtn: true,
            format: 'mmm d, yyyy',
            // maxDate: moment().format("ll"),
            i18n: new duDatepicker.i18n.Locale(months, null, days, null, null, 1, ),
            events: {
                dateChanged: function(data) {
                    if (data.dateFrom) {
                        console.log();
                        // var str = data.dateFrom;
                        // var strToDate = new Date(str);
                        // var month = strToDate.getMonth() + 1;

                        // console.log(month);
                        $('#kt_daterangepicker_1').val(data.dateFrom + ' - ' + data.dateTo);
                        setTimeout(function() {
                            reloadData();
                        }, 100);
                    }
                },
                onRangeFormat: function(from, to) {
                    var fromFormat = 'mmmm d, yyyy',
                        toFormat = 'mmmm d, yyyy';

                    if (from.getMonth() === to.getMonth() && from.getFullYear() === to.getFullYear()) {
                        fromFormat = 'mmmm d'
                        toFormat = 'd, yyyy'
                    } else if (from.getFullYear() === to.getFullYear()) {
                        fromFormat = 'mmmm d'
                        toFormat = 'mmmm d, yyyy'
                    }

                    return from.getTime() === to.getTime() ?
                        this.formatDate(from, 'mmmm d, yyyy') : [this.formatDate(from, fromFormat), this.formatDate(to, toFormat)].join('-');
                }
            },

        });




        duDatepicker('#startDate', {
            root: 'body',
            clearBtn: true,
            format: 'yyyy/mm/dd',
            i18n: new duDatepicker.i18n.Locale(months, null, days, null, null, 1, ),
        });
        duDatepicker('#endDate', {
            root: 'body',
            clearBtn: true,
            format: 'yyyy/mm/dd',
            i18n: new duDatepicker.i18n.Locale(months, null, days, null, null, 1, ),
        });




        $('.dudp__button.ok').html('<?= str_replace("'", "\'", l('global.date.ok')) ?> ');
        $('.dudp__button.clear').html('<?= str_replace("'", "\'", l('global.date.clear')) ?>');

    }
    'use strict';

    $("#exportBtn").click(function() {
        $('#exportModal').modal('show');
    });

    function download(type) {

        var dateRange = $("#kt_daterangepicker_1").val();
        var type = $("<input>").attr("type", "hidden").attr("name", "file_type").val(type);
        var date_range = $("<input>").attr("type", "hidden").attr("name", "date_range").val(dateRange);
        var user_id = $("<input>").attr("type", "hidden").attr("name", "user_id").val(<?php echo $data->user_id; ?>);
        var date_range = $("<input>").attr("type", "hidden").attr("name", "qr_code[]").val(<?php echo $qr_code['qr_code_id']; ?>);

        $('#filterForm').append(date_range);
        $('#filterForm').append(type);
        $('#filterForm').append(user_id);
        $('#filterForm').append(date_range);

        var form = $("#filterForm")[0];
        form.submit();


        $("#exportModal").modal('toggle');
    }


    moment.tz.setDefault("UTC");

    // console.log(moment().subtract(2, 'years'));   

    $('#kt_daterangepicker_1').daterangepicker({
            autoUpdateInput: true,
            locale: <?= json_encode(require APP_PATH . 'includes/daterangepicker_translations.php') ?>,
            autoApply: true,
            startDate: moment().subtract(1, 'months').format("ll"),
            endDate: moment().format("ll"),
            timePicker: false,
            linkedCalendars: false,
            showCustomRangeLabel: false,
            parentEl: '.datepicker-parent',
            ranges: {
                '<?= l('qr_code.date_range.auto') ?>': [moment().subtract(1, 'months'), moment()],
                '<?= l('qr_code.date_range.48') ?>': [moment().subtract(2, 'days'), moment()],
                '<?= l('qr_code.date_range.30') ?>': [moment().subtract(1, 'months'), moment()],
                '<?= l('qr_code.date_range.12') ?>': [moment().subtract(12, 'months'), moment()],
                '<?= l('qr_code.date_range.lifetime') ?>': [moment().subtract(5, 'years'), moment()],
                '<?= l('qr_code.date_range.custom') ?> ': [moment().subtract(1, 'months'), moment()],
            },
        },
        (start, end) => {
            /* Redirect */
            setTimeout(function() {
                reloadData();
            }, 100);

        });

    let isDRPVisible = true;
    $('#kt_daterangepicker_1').on("click", (elm) => {
        const daterangepicker = $(".daterangepicker");
        if (!isDRPVisible && daterangepicker.css('display') == 'block') {
            daterangepicker.css('display', 'none');
        } else {
            isDRPVisible = false;
            daterangepicker.css('display', 'block');
        }
    })

    $('#kt_daterangepicker_1').on('hide.daterangepicker', () => {
        isDRPVisible = true;
    });

    $('#kt_daterangepicker_1').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('ll') + ' - ' + picker.endDate.format('ll'));

        if (picker.chosenLabel == '<?= l('qr_code.date_range.custom') ?> ') {
            $('#pop_picker').click();
        }

    });
</script>


<script>
    $(document).ready(function() {
        reloadData();
    });

    $('#filterForm').submit(function(e) {
        e.preventDefault();
        this.submit();
        setTimeout(function() {
            $('#exportModal').modal('hide');
        }, 100);
    });


    function reloadData() {
        var dateRange = $("#kt_daterangepicker_1").val();
        var data = {
            'action': 'loadDashboardData',
            'dateRange': dateRange
        }
        var form = $("#filterForm")[0];
        var formData = new FormData(form);
        formData.append('action', 'loadDashboardData');

        $.ajax({
            type: 'POST',
            url: '<?php echo url('api/ajax') ?>',
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function(response) {
                var data = response.data.data;

                osDoughnutChart(data['os_chart']);
                countryDoughnutChart(data['country_chart']);
                cityDoughnutChart(data['city_chart']);

                chart(data['chart_data']);
            },
            error: () => {
                /* Re enable submit button */
                // submit_button.removeClass('disabled').text(text);
            },

        });
    }

    function makeTableByOs(rows, id, totalScan) {
        var trHtml = '';
        var totalScan = parseInt(totalScan)
        if (rows.length > 0) {
            rows.forEach(function each(row, index) {
                var rowTotalScan = parseInt(row[1]);
                var per = ((rowTotalScan * 100) / totalScan).toFixed(2);
                trHtml +=
                    `<tr>
                <td class="opsystem">${row[0]}</td>
                <td class="scans">
                <div class="d-flex align-items-center">
                <span class="number">${rowTotalScan}</span>
                <div class="progress">
                <div class="progress-bar" role="progressbar" aria-label="Basic example" style="width: ${per}%" aria-valuenow="${per}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                </div>
                </td>
                <td class="percentage">${per}%</td>
                </tr>`;

            });
        } else {
            trHtml = `<tr><td colspan="3">Not enough data to show statistics</td></tr>`
        }
        $(`#${id}`).find('tbody').html(trHtml);
    }

    function makeGroupByTable(rows, id, totalScan) {
        var trHtml = '';
        var totalScan = parseInt(totalScan)
        if (rows.length > 0) {
            rows.forEach(function each(row, index) {
                var rowTotalScan = parseInt(row[1]);
                var per = ((rowTotalScan * 100) / totalScan).toFixed(2);
                trHtml +=
                    `<tr>
                <td class="">${index + 1}</td>
                <td class="name">${row[0]}</td>
                <td class="scans">
                <div class="d-flex align-items-center">
                <span class="number">${rowTotalScan}</span>
                <div class="progress">
                <div class="progress-bar" role="progressbar" aria-label="Basic example" style="width: ${per}%" aria-valuenow="${per}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                </div>
                </td>
                <td class="percentage">${per}%</td>
                </tr>`;

            });
        } else {
            trHtml = `<tr><td colspan="3">Not enough data to show statistics</td></tr>`
        }
        $(`#${id}`).find('tbody').html(trHtml);
    }

    // 
    $(document).on('click', ".downloadQrCode", function() {
        var modal = $(this).closest("#DownloadModal");
        var type = $('.dl-modal-options').attr('data-selected');
        var size = $('.dl-modal-size-picker-options').attr('data-selected').split('x');
        var link = modal.find("#dmQrcodeLink").val();
        var fileName = modal.find("#fileName").val();
        var qrId = modal.find("#qr_id").val();
        var qrType = modal.find("#qr_type").val();
        var qrUid = modal.find("#qr_uid").val();
        var user_id = modal.find("#user_id").val();

        const spinnerHTML = `<div class='px-1'><svg viewBox="25 25 50 50" class="new-spinner"><circle r="20" cy="50" cx="50"></circle></svg></div>
                            <span class="download-modal-text">Processing...</span>`;
        let dlButtonHTML = $(this).html();

        if ($(this).hasClass('single')) {
            // modal.find("button.new-dl-close").trigger('click');

            var data = {
                qr_code_id: qrId,
                user_id: user_id,
                uid: qrUid,
                action: "change_qr_download_status",
            }
            $.ajax({
                type: 'POST',
                url: '<?php echo url('api/ajax') ?>',
                data: data,
                dataType: 'json',
                success: function(response) {

                },
                error: () => {

                }
            });

            // Data Layer Implementation (GTM)
            var eventDownload = "qr_download";

            var eventData = {
                "userId": "<?php echo $this->user->user_id ?>",
                'user_type': '<?php echo $this->user->total_logins == '1' ? 'New User' : 'Returning User' ?>',
                'method': '<?php echo $this->user->source == 'direct' ? 'Email' : 'Google' ?>',
                "qr_type": qrType,
                "qr_id": qrId,
                'entry_point': '<?php echo $this->user->total_logins == '1' ? 'Signup' : 'Signin' ?>',
                "qr_first": '<?php echo $qrCount == 1 ? 'first_time' : "null" ?>',

            }

            googleDataLayer(eventDownload, eventData);

            var data = {
                link: link,
                name: fileName,
                type: type,
                size: size[0],
                action: "get_image_ratio",
            }
            $.ajax({
                type: 'POST',
                url: '<?php echo url('api/ajax') ?>',
                data: data,
                dataType: 'json',
                beforeSend: function() {
                    $(".downloadQrCode").html(spinnerHTML);
                },
                success: function(response) {
                    $(".downloadQrCode").html(dlButtonHTML);
                    width = response.data.width;
                    height = response.data.height;
                    var fileName = response.data.name;
                    if (type == "svg") {
                        downloadSvg(link, fileName, width, height, qrUid);
                    } else if (type == "pdf") {
                        makePDF(link, size[0], size[1], width, height, fileName);
                        modal.find(".new-dl-close").trigger('click');
                    } else if (type == "eps") {
                        makeEPS(link, width, fileName, qrUid, qrId);
                    } else {
                        convert_svg_to_others(link, type, fileName, width, height);
                        modal.find(".new-dl-close").trigger('click');
                    }
                },
                error: () => {
                    $(".downloadQrCode").html(dlButtonHTML);
                }
            });

            // Data Layer Implementation (GTM)
            // var event = "all_click";

            // var qrData = {
            //     "userId": "<?php echo $this->user->user_id ?>",
            //     'user_type': '<?php echo $this->user->total_logins == '1' ? 'New User' : 'Returning User' ?>',
            //     'method': '<?php echo $this->user->source == 'direct' ? 'Email' : 'Google' ?>',
            //     "qr_type": qrType,
            //     "qr_id": qrUid,
            //     'entry_point': '<?php echo $this->user->total_logins == '1' ? 'Signup' : 'Signin' ?>',
            //     "qr_first": '<?php echo $qrCount == 1 ? 'first_time' : "null" ?>',
            //             // }

            // googleDataLayer(eventDownload, eventData);


        }

    });


    $(document).on('click', '.toPrintBtn', function(e) {
        $('.qrFrameWindow').remove();
        downloadModalClose();
        printModalRemove();
        e.preventDefault();
        // $('.codepannel-img').addClass('qr-center');
        var modal = $(this).closest("#DownloadModal");
        var link = modal.find("#dmQrcodeLink").val();
        var link = `<?= SITE_URL . 'uploads/qr_codes/logo/' . $qr_code['qr_code'] ?>`;
        console.log(link);
        let innerContents = "";
        innerContents += `<img src="${link}" alt="" style="width:100%;height:100%;">`;
        var iframe = document.createElement('iframe');
        iframe.setAttribute('class', 'qrFrameWindow');
        iframe.setAttribute('width', '100%');
        iframe.setAttribute('height', '100%');
        iframe.setAttribute('frameborder', '0');
        iframe.setAttribute('scrolling', 'no');
        var qrBlock = document.createElement('div');
        qrBlock.style.width = '100%';
        qrBlock.style.height = '100%';
        qrBlock.style.display = 'flex';
        qrBlock.style.justifyContent = 'center';
        qrBlock.style.alignContent = 'center';
        var imgElement = document.createElement('img');
        imgElement.setAttribute('src', link);
        imgElement.style.width = '300px';
        qrBlock.appendChild(imgElement);

        var qrId = modal.find("#qr_id").val();
        var qrUid = modal.find("#qr_uid").val();

        var data = {
            qr_code_id: qrId,
            user_id: "<?php echo $this->user->user_id ?>",
            uid: qrUid,
            action: "change_qr_download_status",
        }

        $.ajax({
            type: 'POST',
            url: '<?php echo url('api/ajax') ?>',
            data: data,
            dataType: 'json',
        });

        iframe.onload = function() {
            var iframeDocument = iframe.contentDocument || iframe.contentWindow.document;
            iframeDocument.body.appendChild(qrBlock);
            imgElement.onload = function() {
                iframe.contentWindow.print();
            };

            setTimeout(function() {
                $(".modal-backdrop").remove();
            }, 1000);

        };

        document.body.appendChild(iframe);
        // window.print();

        $('.downloadBtn').trigger('click');



        // Data Layer Implementation (GTM)
        var event = "all_click";

        var qrData = {
            "userId": "<?php echo $this->user->user_id ?>",
            "clicktext": "Print Qr Code",

        }
        googleDataLayer(event, qrData);
    });
    // 
    // 


    // 

    /**for pause the qr code */
    $(document).on('click', '.footerActionBtn', function() {
        // var form = $("#duplicateForm")[0];
        // var formData = new FormData(form);
        var modal = null;
        var user_id = '<?php echo $this->user->user_id; ?>';

        var qrCodeIdArr = ['<?php echo $qr_code['qr_code_id'] ?>']
        var data = {
            'user_id': user_id,
            qrCodeIdArr: qrCodeIdArr
        }

        // formData.append('user_id', user_id);
        var actionBtn = $(this).attr('name');
        if (actionBtn == 'qr_status_paused') {
            modal = $("#PauseModal");
            data['action'] = 'make_qrcode_paused';
        } else if (actionBtn == 'qr_status_resume') {
            modal = $("#ResumeModal");
            data['action'] = 'qr_status_resume';
        } else if (actionBtn == 'reset_scan') {
            modal = $("#resetScanModal");
            data['action'] = 'reset_scan';
        } else {
            return false;
        }

        modal.find("button.close").trigger('click');

        $.ajax({
            type: 'POST',
            url: '<?php echo url('api/ajax') ?>',
            data: data,
            dataType: 'json',
            success: function(response) {
                var response = response.data;
                // closeAfterFooterActionDone(actionBtn);
                var btnHtml = '';
                if (actionBtn == 'qr_status_paused') {
                    btnHtml = `
                    <button class="btn outline-btn mr-md-3 mr-2 d-flex align-items-center actionBtn" type="button" id="ResumeModalOpenBtn" data-toggle="modal" data-target="#ResumeModal">
                    <span class="start-icon icon-play-circle mr-md-2 mr-0"></span>
                    <span class="text d-md-block d-none"><?= l('qr_code.resume') ?></span>
                    </button>`;
                    $("#btnPauseOrResume").html(btnHtml);
                } else if (actionBtn == 'qr_status_resume') {
                    btnHtml = `
                    <button type="button" class="btn outline-btn mr-md-3 mr-2 d-flex align-items-center actionBtn" id="PauseModalOpenBtn" data-toggle="modal" data-target="#PauseModal">
                        <span class="start-icon icon-pause mr-md-2 mr-0"></span>
                        <span class="text d-md-block d-none"><?= l('qr_code.qr_code_status.pause') ?></span>
                    </button>`;
                    $("#btnPauseOrResume").html(btnHtml);
                } else if (actionBtn == 'reset_scan') {
                    $('#resetScanModal').modal('hide');
                    $("#totalScanCounter").text("0");
                    reloadData();
                }
            },
            error: () => {
                /* Re enable submit button */
                // submit_button.removeClass('disabled').text(text);
            },

        });
    });

    $(document).on('click', '#resetScanModal button[data-dismiss="modal"]', function(e) {
        $('#resetScanModal').modal('hide');
    });
    $(document).on('click', '#saveCampaignBtn', function(e) {
        e.preventDefault();
        var form = $("#saveCampaign")[0];
        var formData = new FormData(form);

        formData.append('action', 'saveCampaign');

        $.ajax({
            type: 'POST',
            url: '<?php echo url('api/ajax') ?>',
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function(response) {
                var data = response.data.data;
                var insertData = data.insertData;
                var campaign_id = data.campaign_id;
                $("#campaign").find("button.close").trigger('click');
                $("#campaign").find("#campaignId").val(campaign_id);

                medium = (typeof insertData['medium'] !== 'undefined' && insertData['medium'] != '') ? insertData['medium'] : '-'
                printRun = (typeof insertData['print_run'] !== 'undefined' && insertData['print_run'] != '') ? insertData['print_run'] : '-'
                $("#campaignMediumLable").text(medium);
                $("#pritnRunLable").text(printRun);
                // Nov 22, 2022
                startDate = (typeof insertData['start_date'] !== 'undefined' && insertData['start_date'] != '') ? moment(insertData['start_date'], "YYYY-MM-DD").format("MMM DD, YYYY") : '-'
                endDate = (typeof insertData['end_date'] !== 'undefined' && insertData['end_date'] != '') ? moment(insertData['end_date'], "YYYY-MM-DD").format("MMM DD, YYYY") : '-'
                $("#campaignStarDateLable").text(startDate);
                $("#campaignEndDateLable").text(endDate);

                window.location.reload();
            },
            error: () => {
                /* Re enable submit button */
                // submit_button.removeClass('disabled').text(text);
            },

        });

    });
    $(document).on('click', '#resetScans', function() {
        $('#resetScanModal').modal('show');
    });
</script>

<script>
    // Data Layer Implementation (GTM)

    $(document).on('click', '.qr_status_paused', function() {

        var event = "all_click";

        var data = {
            "userId": "<?php echo isset($data->user_id) ? $data->user_id : null ?>",
            "clicktext": "Pause QR Code",

        }
        googleDataLayer(event, data);
    });

    $(document).on('click', '.qr_status_resume', function() {

        var event = "all_click";

        var data = {
            "userId": "<?php echo isset($data->user_id) ? $data->user_id : null  ?>",
            "clicktext": "Resume QR Code",

        }
        googleDataLayer(event, data);
    });


    $(document).on('click', '.edit-qr-code', function() {

        var event = "all_click";

        var data = {
            "userId": "<?php echo isset($data->user_id) ? $data->user_id : null  ?>",
            "clicktext": "EDit QR Code",

        }
        googleDataLayer(event, data);
    });

    $(document).on('click', '.export-qr', function() {

        var event = "all_click";

        var data = {
            "userId": "<?php echo isset($data->user_id) ? $data->user_id : null  ?>",
            "clicktext": "Export information",

        }
        googleDataLayer(event, data);
    });

    $(document).on('click', '.detail-btn', function() {

        var event = "all_click";

        var data = {
            "userId": "<?php echo isset($data->user_id) ? $data->user_id : null  ?>",
            "clicktext": "Send QR Code",

        }
        googleDataLayer(event, data);
    });
</script>

<script>
    $(".scanImg").on("click", function() {
        var obj = $(this).children('embed').attr('src');
        // var modalQr = 
        $('.qr-code-model .qr-code-embed').attr('src', obj);
    });
    $(".qr-code-download-btn").on("click", function() {
        $('#QRcodeModal').modal().hide();
        // $('.scanImg').trigger('click');
        $('.qr-code-model').removeClass('show');
        $(".close-download-model-btn").on("click", function() {
            $('.modal-backdrop').fadeOut(300, function() {
                $(this).remove();
            });
        });
    });

    function printModalRemove() {
        if ($('#print').is(':checked')) {
            // $(".modal-backdrop").remove();
            $("body").removeClass('modal-open');
            $("body").css({
                'padding-right': '0px',
                'overflow': 'auto'
            });

            // $('.codepannel-img').removeClass('qr-center');
        }
    }

    function downloadModalClose() {
        $("#DownloadModal").removeClass('show');
        $('#DownloadModal').css({
            'display': 'none'
        });
        $(".modal-backdrop").remove();
    }
</script>



<?php \Altum\Event::add_content(ob_get_clean(), 'javascript') ?>