<?php
$isPlanExpire = $data->isPlanExpire;
$planId = isset($data->planId) ? $data->planId : null;

?>

<?php if (count($data->qr_codes)) : ?>
    <?php foreach ($data->qr_codes as $row) : ?>
        <?php
        $qdata = json_decode($row['data'], true);
        if (isset($qdata['type'])) {
            $type = $qdata['type'];
        } else {
            $type = null;
        }
        $dataObject = isset($row['data']) ?  json_decode($row['data']) : null;


        ?>

        <?php if ($type == 'wifi') { ?>
            <div class="qrcode-card-wrapper">
                <div class="qrCode-check">
                    <div class="roundCheckbox">
                        <input type="checkbox" name="qr_code_ids[]" class="qrSelected" id="<?= url('uploads/qr_codes/logo/' . $row['qr_code']) ?>" value="<?= $row['qr_code_id'] ?>" qr-name="<?= $row['name'] ?>" />
                        <label class="m-0" for="<?= url('uploads/qr_codes/logo/' . $row['qr_code']) ?>"></label>
                    </div>
                </div>
                <div class="qrCode-card">
                    <div class="row w-100">
                        <div class="col-xxl-4 col-xl-4 col-sm-10 col-9 qr-image-with-check">
                            <div class="qr-image-info">

                                <div>
                                    <?php if (isset($dataObject->password) && $dataObject->password !== "") : ?>
                                        <?php if ($row['status'] == '2') : ?>
                                            <div class="qr-status-icon-wrap qr-card-status-icon qr-card-status-with-tooltip">
                                                <span class="qr-status-tooltip"><?= l('qr_codes.qr_pause_tooltip') ?></span>
                                                <span class="icon-pause pauseIcon"></span>
                                            </div>
                                        <?php elseif ($row['status'] == '3') : ?>
                                            <div class="qr-status-icon-wrap qr-card-status-icon qr-card-status-with-tooltip">
                                                <span class="qr-status-tooltip qr-status-lock-tooltip"><?= l('qr_codes.qr_pause_tooltip') ?></span>
                                                <span class="icon-pause pauseIcon"></span>
                                            </div>
                                        <?php else : ?>
                                            <div class="qr-status-icon-wrap qr-card-status-icon qr-card-status-with-tooltip">
                                                <span class="qr-status-tooltip"><?= l('qr_codes.qr_lock_tooltip') ?></span>
                                                <svg class="MuiSvgIcon-root lockSvg" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 20px;">
                                                    <path d="M18,9V8a5,5,0,0,0-5-5H11A5,5,0,0,0,6,8V9a3,3,0,0,0-3,3v6a3,3,0,0,0,3,3H18a3,3,0,0,0,3-3V12A3,3,0,0,0,18,9ZM8,8a3,3,0,0,1,3-3h2a3,3,0,0,1,3,3V9H8ZM19,18a1,1,0,0,1-1,1H6a1,1,0,0,1-1-1V12a1,1,0,0,1,1-1H18a1,1,0,0,1,1,1Z"></path>
                                                    <path d="M12,13a1,1,0,0,0-1,1v2a1,1,0,0,0,2,0V14A1,1,0,0,0,12,13Z"></path>
                                                </svg>
                                            </div>
                                        <?php endif; ?>
                                    <?php elseif ($row['status'] == '2') : ?>
                                        <div class="qr-status-icon-wrap qr-card-status-icon qr-card-status-with-tooltip">
                                            <span class="qr-status-tooltip"><?= l('qr_codes.qr_pause_tooltip') ?></span>
                                            <span class="icon-pause pauseIcon"></span>
                                        </div>
                                    <?php elseif ($row['status'] == '3') : ?>
                                        <div class="qr-status-icon-wrap qr-card-status-icon qr-card-status-with-tooltip">
                                            <span class="qr-status-tooltip"><?= l('qr_codes.qr_delete_tooltip') ?></span>
                                            <span class=" deleteIcon"></span>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="qrCode-image" data-qr-id="<?= $row['qr_code'] != null ? $row['qr_code'] : $row['qr_code'] ?>" data-toggle="modal" data-id="<?= SITE_URL . 'uploads/qr_codes/logo/' . ($row['qr_code'] != null ? $row['qr_code'] : $row['qr_code']) ?>?<?= time() ?>" data-target="#QRcodeModal">
                                    <img src="<?= SITE_URL  . 'uploads/qr_codes/logo/' . ($row['qr_code'] != null ? $row['qr_code'] : $row['qr_code']) ?>?<?= time() ?>" />

                                </div>
                                <div class="qrCode-info">
                                    <span class="name"><?= l('qr_codes.type.' . $row['type']) ?></span>
                                    <button type="button" class="qrnameChange">
                                        <span class="qrCodeName"><?= $row['name'] ?></span>
                                        <input type="hidden" class="qrCodeId" value="<?= $row['qr_code_id'] ?>"></input>
                                        <input type="hidden" class="qrCodeUid" value="<?= $row['uId'] ?>"></input>
                                        <input type="hidden" class="qrCodeType" value="<?= $row['type'] ?>"></input>
                                        <input type="hidden" class="qrStatus" value="<?= $row['status'] ?>"></input>

                                        <a href="javascript:void(0);">

                                            <svg class="MuiSvgIcon-root jss274" focusable="false" viewBox="0 0 16 16" aria-hidden="true" style="font-size: 15px; margin-left: 10px;">
                                                <path d="M14.71,4.29l-3-3c-.39-.39-1.02-.39-1.41,0L2.29,9.29c-.19,.19-.29,.44-.29,.71v3c0,.55,.45,1,1,1h3c.27,0,.52-.11,.71-.29L14.71,5.71c.39-.39,.39-1.02,0-1.41ZM5.59,12h-1.59v-1.59l4.5-4.5,1.59,1.59-4.5,4.5Zm5.91-5.91l-1.59-1.59,1.09-1.09,1.59,1.59-1.09,1.09Z"></path>
                                            </svg>
                                        </a>
                                    </button>

                                    <!-- After click edit name -->
                                    <div class="qrnameInput edit-qrCodeGroup qr-<?= $row['qr_code_id'] ?>" style="display:none">
                                        <input type="text" name="qr_name" class="editQrField" placeholder="E.g. My QR code" value="<?= $row['name'] ?>">
                                        <button type="button" class="btn primary-btn qrSmallBtn qrnameSaveBtn" data-qr_code_id="<?= $row['qr_code_id'] ?>"><?= l('qr_codes.save') ?></button>
                                    </div>
                                    <!-- / -->
                                    <span class="qr-label created-date-label"><span class="dropmenu-icon icon-calendar"></span> <?= date("F j, Y", strtotime($row['datetime'])) ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-xl-3 col-sm-7 col-12 qr-info-wrp">
                            <div class="qrCode-info2">
                                <span class="qr-label">
                                    <span class="icon dropmenu-icon icon-folder"></span>
                                    <span class="folderName"><?= (isset($row['project_id']) && isset($data->projects[$row['project_id']])) ? $data->projects[$row['project_id']]->name : l('qr_codes.projects.no_folder') ?></span>
                                </span>

                                <span class="qr-label">
                                    <span class="icon dropmenu-icon icon-edit"></span>
                                    <?= l('qr_codes.modified') ?>:&nbsp;<?= date("F j, Y", strtotime($row['updated_at'])) ?>
                                </span>
                            </div>
                        </div>
                        <div class="col-xxl-1 col-xl-1 col-sm-2 col-3 qr-scans-count-wrp">
                            <div class="scan-info scan-wifi-info">
                                <span class="scan-text"><?= l('qr_codes.static_qr') ?></span>
                                <div class="static-icon-wrap">
                                    <span class="static-tooltip"><?= l('qr_codes.static_qr.tooltip') ?></span>
                                    <span class="fas fa-info-circle ml-2 static-icon"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-4 col-xl-4 col-sm-5 col-12 qr-actions-dropdown-wrp">
                            <div class="right position-relative">
                                <?php $isVisible =  ($row['status'] == '3' || $row['status'] == '4') ? 'style="visibility: hidden;"' : ''; ?>
                                <?php if ($isPlanExpire) : ?>
                                    <button class="downloadBtn single btn outline-btn btn-with-icon disabled" type="button" data-toggle="modal" data-target="#DownloadModal" disabled>
                                        <svg class="MuiSvgIcon-root mr-1 download-icon" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 22px;">
                                            <path d="M11.29,15.71a1,1,0,0,0,.33.21.94.94,0,0,0,.76,0,1,1,0,0,0,.33-.21l4-4a1,1,0,0,0-1.42-1.42L13,12.59V4a1,1,0,0,0-2,0v8.59l-2.29-2.3a1,1,0,1,0-1.42,1.42Z"></path>
                                            <path d="M20,15a1,1,0,0,0-1,1v3H5V16a1,1,0,0,0-2,0v4a1,1,0,0,0,1,1H20a1,1,0,0,0,1-1V16A1,1,0,0,0,20,15Z"></path>
                                        </svg>
                                        <span class="download-text"><?= l('qr_codes.download') ?></span>
                                    </button>
                                    <button type="button" <?= $row['status'] == '4' ? 'style="visibility: hidden;"' : ''; ?> class="btn outline-btn detail-btn disabled" type="button" disabled>
                                        <span class="icon-detailSearch start-icon detail-icon"></span>
                                        <span class="detail-text"><?= l('qr_codes.detail') ?></span></button>
                                    <button class=" kebab-button disabled" disabled type="button" data-toggle="dropdown" data-boundary="viewport">
                                        <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 20px;">
                                            <circle cx="12" cy="4" r="2"></circle>
                                            <circle cx="12" cy="12" r="2"></circle>
                                            <circle cx="12" cy="20" r="2"></circle>
                                        </svg>
                                    </button>

                                    <div class="dropdown-menu dropdown-menu-right d-none">
                                        <button type="button" <?= $row['status'] == '4' ? 'style="visibility: hidden;"' : ''; ?> class="btn outline-btn detail-btn btn-secondary d-lg-none d-block" type="button" disabled><?= l('qr_codes.detail') ?></button>
                                        <button type="button" class="dropdown-item d-flex align-items-center" disabled>
                                            <span class="dropmenu-icon icon-copy"></span>
                                            <span class="text"><?= l('qr_codes.edit') ?></span>
                                        </button>
                                        <button type="button" class="dropdown-item d-flex align-items-center" disabled>
                                            <span class="dropmenu-icon icon-copy"></span>
                                            <span class="text"><?= l('qr_codes.duplicate') ?></span>
                                        </button>
                                        <button type="button" class="dropdown-item d-flex align-items-center" disabled>
                                            <span class="dropmenu-icon icon-printer"></span>
                                            <span class="text"> <?= l('qr_codes.toPrint') ?></span>
                                        </button>
                                    </div>
                                <?php else : ?>
                                    <button class="downloadBtn btn outline-btn btn-with-icon" type="button" data-toggle="modal" data-target="#DownloadModal">
                                        <svg class="MuiSvgIcon-root mr-1 download-icon" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 20px;">
                                            <path d="M11.29,15.71a1,1,0,0,0,.33.21.94.94,0,0,0,.76,0,1,1,0,0,0,.33-.21l4-4a1,1,0,0,0-1.42-1.42L13,12.59V4a1,1,0,0,0-2,0v8.59l-2.29-2.3a1,1,0,1,0-1.42,1.42Z"></path>
                                            <path d="M20,15a1,1,0,0,0-1,1v3H5V16a1,1,0,0,0-2,0v4a1,1,0,0,0,1,1H20a1,1,0,0,0,1-1V16A1,1,0,0,0,20,15Z"></path>
                                        </svg>
                                        <span class="download-text"><?= l('qr_codes.download') ?></span>
                                    </button>

                                    <button class="kebab-button" type="button" data-toggle="dropdown" data-boundary="viewport" data-qrcodeid="<?= $row['qr_code_id'] ?>">
                                        <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 20px;">
                                            <circle cx="12" cy="4" r="2"></circle>
                                            <circle cx="12" cy="12" r="2"></circle>
                                            <circle cx="12" cy="20" r="2"></circle>
                                        </svg>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">

                                        <a href="<?= url('qr/' . $row['qr_code_id']) ?>" class="dropdown-item d-flex align-items-center">
                                            <span class="dropmenu-icon icon-edit mr-1"></span>
                                            <span class="text"><?= l('qr_codes.edit') ?></span>
                                        </a>

                                        <?php if ($planId != 5) : ?>
                                            <a href="javascript:void(0)" class="dropdown-item whenOpenDuplicateModal d-flex align-items-center" data-qr_code_id="<?= $row['qr_code_id'] ?>" data-toggle="modal" data-target="#DuplicateModal">
                                                <span class="dropmenu-icon icon-copy mr-1"></span>
                                                <span class="text"><?= l('qr_codes.duplicate') ?></span>
                                            </a>
                                        <?php endif ?>

                                        <a href="javascript:void(0)" class="dropdown-item toPrintBtn d-flex align-items-center">
                                            <span class="dropmenu-icon icon-printer mr-1"></span>
                                            <span class="text"><?= l('qr_codes.toPrint') ?></span>
                                        </a>
                                        <a href="javascript:void(0)" name="send_to_modal" data-toggle="modal" data-target="#SendToModal" class="dropdown-item sent-to d-flex align-items-center dotactionBtn send-to-btn">
                                            <span class="dropmenu-icon icon-folder mr-1"></span>
                                            <span class="text"><?= l('qr_codes.send_to') ?></span>
                                        </a>
                                        <?php if ($row['status'] == '1') : ?>
                                            <a href="javascript:void(0)" data-toggle="modal" data-target="#PauseModal" type="button" class="dotactionBtn pause-btn dropdown-item pause d-flex align-items-center">
                                                <span class="dropmenu-icon icon-pause-circle mr-1"></span>
                                                <span class="text"><?= l('qr_codes.qr_code_status.pause') ?></span>
                                            </a>
                                        <?php elseif ($row['status'] == '2') : ?>
                                            <a href="javascript:void(0)" data-toggle="modal" data-target="#ResumeModal" type="button" class="dotactionBtn dropdown-item resume-btn d-flex align-items-center">
                                                <span class="dropmenu-icon icon-pause-circle mr-1"></span>
                                                <span class="text"><?= l('qr_codes.resume') ?></span>
                                            </a>
                                        <?php endif; ?>
                                        <?php if ($row['status'] != '3') : ?>
                                            <a href="javascript:void(0)" data-toggle="modal" data-target="#DeleteModal" type="button" class="dropdown-item delete delete-btn d-flex align-items-center dotactionBtn">
                                                <span class="dropmenu-icon icon-trash delete-icon mr-1"></span>
                                                <span class="text"><?= l('qr_codes.delete') ?></span>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                <?php endif ?>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        <?php } else { ?>
            <div class="qrcode-card-wrapper">
                <div class="qrCode-check">
                    <div class="roundCheckbox">
                        <input type="checkbox" name="qr_code_ids[]" class="qrSelected" id="<?= url('uploads/qr_codes/logo/' . $row['qr_code']) ?>" value="<?= $row['qr_code_id'] ?>" qr-name="<?= str_replace(' ', '-', $row['name']) ?>" />
                        <label class="m-0" for="<?= url('uploads/qr_codes/logo/' . $row['qr_code']) ?>"></label>
                    </div>
                </div>
                <div class="qrCode-card">
                    <div class="row w-100">
                        <div class="col-xxl-4 col-xl-4 col-sm-10 col-9 qr-image-with-check">
                            <div class="qr-image-info align-items-center">

                                <div>

                                    <?php if (isset($dataObject->password) && $dataObject->password !== "") : ?>
                                        <?php if ($row['status'] == '2') : ?>
                                            <div class="qr-status-icon-wrap qr-card-status-icon qr-card-status-with-tooltip">
                                                <span class="qr-status-tooltip"><?= l('qr_codes.qr_pause_tooltip') ?></span>
                                                <span class="icon-pause pauseIcon"></span>
                                            </div>
                                        <?php elseif ($row['status'] == '3') : ?>
                                            <div class="qr-status-icon-wrap qr-card-status-icon qr-card-status-with-tooltip">
                                                <span class="qr-status-tooltip"><?= l('qr_codes.qr_pause_tooltip') ?></span>
                                                <span class="icon-pause pauseIcon"></span>
                                            </div>
                                        <?php else : ?>
                                            <div class=" qr-status-icon-wrap qr-card-status-icon qr-card-status-with-tooltip">
                                                <span class="qr-status-tooltip qr-status-lock-tooltip"><?= l('qr_codes.qr_lock_tooltip') ?></span>
                                                <svg class="MuiSvgIcon-root lockSvg" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 20px;">
                                                    <path d="M18,9V8a5,5,0,0,0-5-5H11A5,5,0,0,0,6,8V9a3,3,0,0,0-3,3v6a3,3,0,0,0,3,3H18a3,3,0,0,0,3-3V12A3,3,0,0,0,18,9ZM8,8a3,3,0,0,1,3-3h2a3,3,0,0,1,3,3V9H8ZM19,18a1,1,0,0,1-1,1H6a1,1,0,0,1-1-1V12a1,1,0,0,1,1-1H18a1,1,0,0,1,1,1Z"></path>
                                                    <path d="M12,13a1,1,0,0,0-1,1v2a1,1,0,0,0,2,0V14A1,1,0,0,0,12,13Z"></path>
                                                </svg>
                                            </div>
                                        <?php endif; ?>
                                    <?php elseif ($row['status'] == '2') : ?>
                                        <div class="qr-status-icon-wrap qr-card-status-icon qr-card-status-with-tooltip">
                                            <span class="qr-status-tooltip"><?= l('qr_codes.qr_pause_tooltip') ?></span>
                                            <span class="icon-pause pauseIcon"></span>
                                        </div>
                                    <?php elseif ($row['status'] == '3') : ?>
                                        <div class="qr-status-icon-wrap qr-card-status-icon qr-card-status-with-tooltip">
                                            <span class="qr-status-tooltip"><?= l('qr_codes.qr_delete_tooltip') ?></span>
                                            <span class=" deleteIcon"></span>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="qrCode-image" data-qr-id="<?= $row['qr_code'] != null ? $row['qr_code'] : $row['qr_code'] ?>" data-toggle="modal" data-id="<?= SITE_URL . 'uploads/qr_codes/logo/' . ($row['qr_code'] != null ? $row['qr_code'] : $row['qr_code']) ?>?<?= time() ?>" data-target="#QRcodeModal">
                                    <img src="<?= SITE_URL  . 'uploads/qr_codes/logo/' . ($row['qr_code'] != null ? $row['qr_code'] : $row['qr_code'])  ?>?<?= time() ?>" />

                                </div>
                                <div class="qrCode-info">
                                    <span class="name"><?= l('qr_codes.type.' . $row['type']) ?></span>
                                    <button type="button" class="qrnameChange">
                                        <span class="qrCodeName"><?= $row['name'] ?></span>
                                        <input type="hidden" class="qrCodeId" value="<?= $row['qr_code_id'] ?>"></input>
                                        <input type="hidden" class="qrCodeUid" value="<?= $row['uId'] ?>"></input>
                                        <input type="hidden" class="qrCodeType" value="<?= $row['type'] ?>"></input>
                                        <input type="hidden" class="qrStatus" value="<?= $row['status'] ?>"></input>

                                        <a href="javascript:void(0);">

                                            <svg class="MuiSvgIcon-root jss274" focusable="false" viewBox="0 0 16 16" aria-hidden="true" style="font-size: 15px; margin-left: 10px;">
                                                <path d="M14.71,4.29l-3-3c-.39-.39-1.02-.39-1.41,0L2.29,9.29c-.19,.19-.29,.44-.29,.71v3c0,.55,.45,1,1,1h3c.27,0,.52-.11,.71-.29L14.71,5.71c.39-.39,.39-1.02,0-1.41ZM5.59,12h-1.59v-1.59l4.5-4.5,1.59,1.59-4.5,4.5Zm5.91-5.91l-1.59-1.59,1.09-1.09,1.59,1.59-1.09,1.09Z"></path>
                                            </svg>
                                        </a>
                                    </button>

                                    <!-- After click edit name -->
                                    <div class="qrnameInput edit-qrCodeGroup qr-<?= $row['qr_code_id'] ?>" style="display:none">
                                        <input type="text" name="qr_name" class="editQrField" placeholder="<?= l('qr_codes.edit_name.placeholder') ?>" value="<?= $row['name'] ?>">
                                        <button type="button" class="btn primary-btn qrSmallBtn qrnameSaveBtn" data-qr_code_id="<?= $row['qr_code_id'] ?>"><?= l('qr_codes.save') ?></button>
                                    </div>
                                    <!-- / -->
                                    <span class="qr-label created-date-label"><span class="dropmenu-icon icon-calendar"></span> <?= date("F j, Y", strtotime($row['datetime'])) ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-xl-3 col-sm-7 col-12 qr-info-wrp">
                            <div class="qrCode-info2">
                                <span class="qr-label">
                                    <span class="icon dropmenu-icon icon-folder"></span>
                                    <span class="folderName"><?= (isset($row['project_id']) && isset($data->projects[$row['project_id']])) ? $data->projects[$row['project_id']]->name : l('qr_codes.projects.no_folder') ?></span>
                                </span>
                                <span class="qr-label">

                                    <?php
                                    if ($type == 'url' && isset(json_decode($row['data'])->url)) {
                                        $url = json_decode($row['data'])->url;
                                        $parsed_url = parse_url($url);
                                        if (isset($parsed_url['scheme']) && ($parsed_url['scheme'] == 'https' || $parsed_url['scheme'] == 'http')) {
                                            $website = json_decode($row['data'])->url;
                                        } else {
                                            $website =  '//' . json_decode($row['data'])->url;
                                        }
                                    }
                                    ?>


                                    <a class="qr-card-link" href="<?= $type !== 'url' ? ((isset($row['link_id']) && isset($data->links[$row['link_id']])) ? $data->links[$row['link_id']]->location_url : LANDING_PAGE_URL . "p/{$row['uId']}") : ($row['status'] == '2' || $row['status'] == '3' ? LANDING_PAGE_URL . "p/{$row['uId']}" : $website) ?>" target="_blank">
                                        <span <?= $type === 'url' ? 'hidden' : '' ?> class="icon dropmenu-icon icon-global"></span>
                                        <span <?= $type === 'url' ? '' : 'hidden' ?> class="icon dropmenu-icon icon-redirect"></span>
                                        <?php
                                        if ($type === 'url') {
                                            $url = json_decode($row['data'])->url;
                                            echo ($url);
                                        } else {
                                            echo (isset($row['link_id']) && isset($data->links[$row['link_id']])) ? $data->links[$row['link_id']]->location_url : LANDING_PAGE_URL . "p/{$row['uId']}";
                                        }
                                        ?>
                                    </a>

                                    <?php if ($type === 'url') : ?>
                                        <span class="icon dropmenu-icon icon-edit ml-2" style="cursor: <?= $isPlanExpire ? 'no-drop' : 'pointer' ?>;" onclick="javascript:$('#editUrlForm').find('#qr_id').val('<?= $row['qr_code_id'] ?>');$('#editUrlForm').find('#newUrl').val('<?= $url ?>');$('#editURL').fadeIn(100);$('#editURL').addClass('show');$('#overlayPre').css({'opacity': '0.5','display': 'block'});$('body').addClass('set-scroll-none');"></span>
                                    <?php endif ?>
                                </span>
                                <span class="qr-label">
                                    <span class="icon dropmenu-icon icon-edit"></span>
                                    <?= l('qr_codes.modified') ?>:&nbsp;<?= date("F j, Y", strtotime($row['updated_at'])) ?>
                                </span>
                            </div>
                        </div>
                        <div class="col-xxl-1 col-xl-1 col-sm-2 col-3 qr-scans-count-wrp">
                            <a href="<?= url('qr-code/detail/' . $row['qr_code_id']) ?>">
                                <div class="scan-info">
                                    <span class="scan-text"><?= l('qr_codes.scans') ?></span>
                                    <label><span><?= $row['total_scan']; ?></span></label>
                                </div>
                            </a>
                        </div>
                        <div class="col-xxl-4 col-xl-4 col-sm-5 col-12 qr-actions-dropdown-wrp">
                            <div class="right position-relative">
                                <?php $isVisible =  ($row['status'] == '3' || $row['status'] == '4') ? 'style="visibility: hidden;"' : ''; ?>
                                <?php if ($isPlanExpire) : ?>
                                    <button class="downloadBtn btn outline-btn btn-with-icon disabled" type="button" data-toggle="modal" data-target="#DownloadModal" disabled>
                                        <svg class="MuiSvgIcon-root mr-1 download-icon" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 20px;">
                                            <path d="M11.29,15.71a1,1,0,0,0,.33.21.94.94,0,0,0,.76,0,1,1,0,0,0,.33-.21l4-4a1,1,0,0,0-1.42-1.42L13,12.59V4a1,1,0,0,0-2,0v8.59l-2.29-2.3a1,1,0,1,0-1.42,1.42Z"></path>
                                            <path d="M20,15a1,1,0,0,0-1,1v3H5V16a1,1,0,0,0-2,0v4a1,1,0,0,0,1,1H20a1,1,0,0,0,1-1V16A1,1,0,0,0,20,15Z"></path>
                                        </svg>
                                        <span class="download-text"><?= l('qr_codes.download') ?></span>
                                    </button>
                                    <button type="button" <?= $row['status'] == '4' ? 'style="visibility: hidden;"' : ''; ?> class="btn outline-btn detail-btn disabled" type="button" disabled>
                                        <span class="icon-detailSearch start-icon detail-icon"></span>
                                        <span class="detail-text"><?= l('qr_codes.detail') ?></span></button>
                                    <button class=" kebab-button disabled" disabled type="button" data-toggle="dropdown" data-boundary="viewport">
                                        <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 20px;">
                                            <circle cx="12" cy="4" r="2"></circle>
                                            <circle cx="12" cy="12" r="2"></circle>
                                            <circle cx="12" cy="20" r="2"></circle>
                                        </svg>
                                    </button>

                                    <div class="dropdown-menu dropdown-menu-right d-none">
                                        <button type="button" <?= $row['status'] == '4' ? 'style="visibility: hidden;"' : ''; ?> class="btn outline-btn detail-btn btn-secondary d-lg-none d-block" type="button" disabled><?= l('qr_codes.detail') ?></button>
                                        <button type="button" class="dropdown-item d-flex align-items-center" disabled>
                                            <span class="dropmenu-icon icon-copy"></span>
                                            <span class="text"><?= l('qr_codes.edit') ?></span>
                                        </button>
                                        <button type="button" class="dropdown-item d-flex align-items-center" disabled>
                                            <span class="dropmenu-icon icon-copy"></span>
                                            <span class="text"><?= l('qr_codes.duplicate') ?></span>
                                        </button>
                                        <button type="button" class="dropdown-item d-flex align-items-center" disabled>
                                            <span class="dropmenu-icon icon-printer"></span>
                                            <span class="text"> <?= l('qr_codes.toPrint') ?></span>
                                        </button>
                                    </div>
                                <?php else : ?>
                                    <button class="downloadBtn btn outline-btn btn-with-icon" type="button" data-toggle="modal" data-target="#DownloadModal">
                                        <svg class="MuiSvgIcon-root mr-1 download-icon" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 20px;">
                                            <path d="M11.29,15.71a1,1,0,0,0,.33.21.94.94,0,0,0,.76,0,1,1,0,0,0,.33-.21l4-4a1,1,0,0,0-1.42-1.42L13,12.59V4a1,1,0,0,0-2,0v8.59l-2.29-2.3a1,1,0,1,0-1.42,1.42Z"></path>
                                            <path d="M20,15a1,1,0,0,0-1,1v3H5V16a1,1,0,0,0-2,0v4a1,1,0,0,0,1,1H20a1,1,0,0,0,1-1V16A1,1,0,0,0,20,15Z"></path>
                                        </svg>
                                        <span class="download-text"><?= l('qr_codes.download') ?></span>
                                    </button>

                                    <a href="<?= url('qr-code/detail/' . $row['qr_code_id']) ?>" <?= $row['status'] == '4' ? 'style="visibility: hidden;"' : ''; ?> class="btn outline-btn detail-btn " type="button">
                                        <span class="icon-detailSearch start-icon detail-icon"></span>
                                        <span class="detail-text"><?= l('qr_codes.detail') ?></span>
                                    </a>

                                    <button class="kebab-button" type="button" data-toggle="dropdown" data-boundary="viewport" data-qrcodeid="<?= $row['qr_code_id'] ?>">
                                        <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 20px;">
                                            <circle cx="12" cy="4" r="2"></circle>
                                            <circle cx="12" cy="12" r="2"></circle>
                                            <circle cx="12" cy="20" r="2"></circle>
                                        </svg>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right <?= $row['status'] == '3' ? 'deleted-dropdown' : '' ?>">

                                        <a href="<?= url('qr/' . $row['qr_code_id']) ?>" class="dropdown-item d-flex align-items-center">
                                            <span class="dropmenu-icon icon-edit mr-1"></span>
                                            <span class="text"><?= l('qr_codes.edit') ?></span>
                                        </a>
                                        <?php if ($planId != 5) : ?>
                                            <a href="javascript:void(0)" class="dropdown-item whenOpenDuplicateModal d-flex align-items-center" data-qr_code_id="<?= $row['qr_code_id'] ?>" data-toggle="modal" data-target="#DuplicateModal">
                                                <span class="dropmenu-icon icon-copy mr-1"></span>
                                                <span class="text"><?= l('qr_codes.duplicate') ?></span>
                                            </a>
                                        <?php endif ?>
                                        <a href="javascript:void(0)" class="dropdown-item toPrintBtn d-flex align-items-center">
                                            <span class="dropmenu-icon icon-printer mr-1"></span>
                                            <span class="text"><?= l('qr_codes.toPrint') ?></span>
                                        </a>
                                        <a href="javascript:void(0)" name="send_to_modal" data-toggle="modal" data-target="#SendToModal" class="dropdown-item sent-to d-flex align-items-center dotactionBtn send-to-btn">
                                            <span class="dropmenu-icon icon-folder mr-1"></span>
                                            <span class="text"><?= l('qr_codes.send_to') ?></span>
                                        </a>
                                        <?php if ($row['status'] == '1') : ?>
                                            <a data-toggle="modal" data-target="#PauseModal" type="button" class="dotactionBtn pause-btn dropdown-item pause d-flex align-items-center">
                                                <span class="dropmenu-icon icon-pause-circle mr-1"></span>
                                                <span class="text"><?= l('qr_codes.qr_code_status.pause') ?></span>
                                            </a>
                                        <?php elseif ($row['status'] == '2') : ?>
                                            <a href="javascript:void(0)" data-toggle="modal" data-target="#ResumeModal" type="button" class="dotactionBtn dropdown-item resume-btn d-flex align-items-center">
                                                <span class="dropmenu-icon icon-pause-circle mr-1"></span>
                                                <span class="text"><?= l('qr_codes.resume') ?></span>
                                            </a>
                                        <?php elseif ($row['status'] == '3') : ?>
                                            <a href="javascript:void(0)" data-toggle="modal" data-target="#RestoreModal" type="button" class="dotactionBtn dropdown-item resume-btn d-flex align-items-center">
                                                <span class="restore-icon-wrap">
                                                    <span class="icon-restore-btn restore-icon"></span>
                                                </span>
                                                <span class="text ms-1"><?= l('qr_codes.restore') ?></span>
                                            </a>
                                        <?php endif; ?>
                                        <?php if ($row['status'] != '3') : ?>
                                            <a href="javascript:void(0)" data-toggle="modal" data-target="#DeleteModal" type="button" class="dropdown-item delete delete-btn d-flex align-items-center dotactionBtn">
                                                <span class="dropmenu-icon icon-trash delete-icon mr-1"></span>
                                                <span class="text"><?= l('qr_codes.delete') ?></span>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                <?php endif ?>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        <?php } ?>
    <?php endforeach ?>
    <div class="mt-3 pagination-wrapper"><?= $data->pagination ?></div>
<?php else : ?>
    <div class="card borr">
        <div class="card-body p-sm-5 p-2">
            <div class="d-flex flex-column align-items-center justify-content-center py-3">
                <img src="<?= ASSETS_FULL_URL . 'images/no_rows.svg' ?>" class="col-10 col-md-7 col-lg-4 mb-3 img-fluid no-rows-img" alt="<?= l('qr_codes.no_data') ?>" />
                <h2 class="h4 my-4 text-muted"><?= l('qr_codes.no_data') ?></h2>
                <!-- <p class="text-muted"><?= l('qr_codes.no_data_help') ?></p> -->

                <?php if ($isPlanExpire || $planId == 5) : ?>
                    <button type="button" class="btn primary-btn  btn-with-icon  create-qr-btn font-bold" disabled>
                        <span class="icon-add-barcode start-icon"></span>
                        <span class="text"><?= l('qr_codes.create_qr_code') ?></span>
                    </button>
                <?php else : ?>
                    <a href="<?= url('qr') ?><?= (isset($_REQUEST['project_id']) && !empty($_REQUEST['project_id'])) ? "?project_id={$_REQUEST['project_id']}" : '' ?>" class="btn primary-btn  btn-with-icon  create-qr-btn font-bold">
                        <span class="icon-add-barcode start-icon"></span>

                        <span class="text "><?= l('qr_codes.create_qr_code') ?></span>
                    </a>
                <?php endif ?>
            </div>
        </div>
    </div>
<?php endif ?>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script> -->
<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.js"></script>
<script>
    // $(document).on("click", ".qrCode-image", function() {
    //     var myBookId = $(this).data('id');
    //     console.log("myid", myBookId)
    //     $("#pre-qr").attr('src', myBookId);
    //     // As pointed out in comments, 
    //     // it is unnecessary to have to manually call the modal.
    //     // $('#addBookDialog').modal('show');
    // });
    // console.log('asdasdasdasd');  
    function editQr() {

    }
</script>

<?php ob_start() ?>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script> -->
<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js"></script> -->


<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js"></script> -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

<script>
    var user_id = '<?php echo isset($this->user->user_id) ? $this->user->user_id : null; ?>';
    $(document).ready(function() {
        qrCodeListing();
        folderListing();

        $('.multiSelect').multiselect({
            // buttonWidth : '160px',
            includeSelectAllOption: false,
            nonSelectedText: 'Select an Option'
        });

    }); /*End of document ready*/

    function folderListing() {
        user_id = user_id || '<?php echo isset($this->user->user_id) ? $this->user->user_id : null; ?>';
        var data = {
            'user_id': user_id,
            'action': 'folder_listing',
        }
        $.ajax({
            type: 'POST',
            url: '<?php echo url('api/ajax') ?>',
            data: data,
            dataType: 'json',
            success: function(response) {
                var response = response.data;
                $("#availableFolder").html(response.html)
                $("#sendTofolderList").html(response.send_to_folder_list)
            },
            error: () => {
                /* Re enable submit button */
                // submit_button.removeClass('disabled').text(text);
            },

        });

    }

    $(document).on('change', '.multiSelect.active-cstm', function() {
        qrCodeListing(1);
    });

    $(document).on('keyup', '.form-control.search-bar', function() {
        var searchKeyword = $(this).val();
        var searchKeywordLen = parseInt(searchKeyword.length)

        if ((typeof searchKeyword == 'undefined' || searchKeyword == '') || searchKeywordLen > 3) {
            qrCodeListing(1);
        }
    });

    var qrCodeListingXhr;

    function qrCodeListing(pageNo) {
        qrCodeListingXhr && qrCodeListingXhr.readyState != 4 && qrCodeListingXhr.abort(); // clear previous request

        $(".qrCode-footer").hide();
        pageNo = pageNo || 1;

        var form = $("#qrCodeListFrm")[0];
        var formData = new FormData(form);
        var user_id = '<?php echo isset($this->user->user_id) ? $this->user->user_id : null; ?>';

        formData.append('action', 'qrcode_data_table');
        formData.append('user_id', user_id);
        formData.append('page_no', pageNo);

        qrCodeListingXhr = $.ajax({
            type: 'POST',
            url: '<?php echo url('api/ajax') ?>',
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function(response) {
                var response = response.data;
                $("#qrCodeListing").html(response.html)
            },
            error: () => {
                /* Re enable submit button */
                // submit_button.removeClass('disabled').text(text);
            },

        });


    }

    $(document).on('click', '#makeFolder', function(e) {
        e.preventDefault();
        var form = $("#folderForm")[0];

        var formData = new FormData(form);
        // $params = $_POST['name'];
        console.log("name", formData.get('name'))
        formData.append('action', 'createFolder');
        if (formData.get('name')) {
            // var data = $('#Name').val();
            // $("#createFolder").modal().hide();
            $("#nameReq").hide();
            $("#createFolder").find("button.close").trigger('click');
            $(".modal-backdrop").remove();
            $.ajax({
                type: 'POST',
                url: '<?php echo url('api/ajax') ?>',
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function(response) {

                    var data = response.data;
                    //console.log(response.data);
                    folderListing();
                    // var trHtml = `<div class="folder-container">
                    //             <div class="my-folder">
                    //                 <h4>${data.name}</h4>
                    //                 <div class="folder-inner">
                    //                     <span>${data.datetime}</span>
                    //                     <div class="badge">0</div>
                    //                 </div>
                    //             </div>
                    //         </div>`;
                    // $('#availableFolder').append(trHtml);
                },
                error: () => {
                    /* Re enable submit button */
                    // submit_button.removeClass('disabled').text(text);
                },

            });
        } else {
            $("#nameReq").show();
        }


    });

    $(document).on('click', '.page-item', function(e) {
        e.preventDefault();
        var pageNo = $(this).find('a').attr('href');
        qrCodeListing(pageNo)
    });

    $(document).on('click', ".downloadBtn", function() {
        var qrCodeCard = $(this).closest('.qrCode-card');
        var fileName = qrCodeCard.find('.qrCodeName').text();
        var qrId = qrCodeCard.find('.qrCodeId').val();

        var link = qrCodeCard.find('.qrCode-image img').attr('src');
        $("#DownloadModal").find("#fileName").val(fileName);
        $("#DownloadModal").find("#dmQrcodeLink").val(link);
        // convert_svg_to_others('http://localhost/3way/qr-new/uploads/qr_codes/logo/5c6d39b0d1f991530e07ed2952607ecf.svg', 'png', 'first-image-qrcode.png');
    });

    $(document).on('click', ".downloadQrCode", function() {
        var modal = $(this).closest("#DownloadModal");
        var type = $(this).attr('name');
        var link = modal.find("#dmQrcodeLink").val();
        var fileName = modal.find("#fileName").val();
        modal.find("button.close").trigger('click');

        if (type == "svg") {
            downloadURI(link, `${fileName}.${type}`)
        } else {
            convert_svg_to_others(link, type, `${fileName}.${type}`);
        }
    });



    function downloadURI(uri, name) {
        var link = document.createElement("a");
        // If you don't know the name or want to use
        // the webserver default set name = ''
        link.setAttribute('download', name);
        link.href = uri;
        document.body.appendChild(link);
        link.click();
        link.remove();
    }


    //Make duplicate QR code
    $(document).on('click', '.whenOpenDuplicateModal', function() {
        var qrCodeId = $(this).data('qr_code_id');
        console.log('qrCodeId', qrCodeId);
        $("#DuplicateModal").find("#duplicateQrCodeId").val(qrCodeId);

    });
    $(document).on('click', '.makeDuplicateQrCode', function() {
        var form = $("#duplicateForm")[0];
        var formData = new FormData(form);
        var user_id = '<?php echo isset($this->user->user_id) ? $this->user->user_id : null; ?>';

        formData.append('action', 'qrcode_duplicate');
        formData.append('user_id', user_id);
        $("#DuplicateModal").find("button.close").trigger('click');
        $.ajax({
            type: 'POST',
            url: '<?php echo url('api/ajax') ?>',
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function(response) {
                var response = response.data;
                console.log(response);
                qrCodeListing()
            },
            error: () => {
                /* Re enable submit button */
                // submit_button.removeClass('disabled').text(text);
            },

        });
    });

    //checked box
    $(document).on('click', '.footerClose', function() {
        $('input.qrSelected').prop('checked', false);
        $(this).closest('.qrCode-footer').hide();
    });

    $(document).on('change', '.qrSelected', function() {
        var statusValue = $("select[name=qr_code_status]").val();
        statusValue = parseInt(statusValue);

        console.log('statusValue', statusValue)
        var qrCodeFooter;
        if (statusValue == 1) {
            qrCodeFooter = $("#qrCodeFooterActive");
        } else if (statusValue == 2) {
            qrCodeFooter = $("#qrCodeFooterPaused");
        } else if (statusValue == 3) {
            qrCodeFooter = $("#qrCodeFooterDeleted");
        }

        var totalChecked = $('input.qrSelected:checked').length;
        totalChecked = parseInt(totalChecked);
        console.log('totalChecked', totalChecked);
        if (totalChecked > 0) {
            qrCodeFooter.show();
            qrCodeFooter.find("#selectedValue").text(totalChecked);
        } else {
            qrCodeFooter.hide();
            qrCodeFooter.find("#selectedValue").text(0);
        }
    });

    var qrCodeIdArr = [];
    $(document).on('click', '.qrCode-footer button.actionBtn', function() {
        var dataTarget = $(this).data('target');
        var modal = $(`${dataTarget}`);
        qrCodeIdArr = [];
        $("input.qrSelected:checked").each(function() {
            qrCodeIdArr.push($(this).val());
        });
        console.log('qrCodeIdArr')
        console.log(qrCodeIdArr)
    });
    $(document).on('click', '.footerActionBtn', function() {
        // var form = $("#duplicateForm")[0];
        // var formData = new FormData(form);
        var modal = null;
        var user_id = '<?php echo isset($this->user->user_id) ? $this->user->user_id : null; ?>';

        var data = {
            'user_id': user_id,
            qrCodeIdArr: qrCodeIdArr
        }

        // formData.append('user_id', user_id);
        var actionBtn = $(this).attr('name');
        if (actionBtn == 'qr_status_paused') {
            modal = $("#PauseModal");
            data['action'] = 'make_qrcode_paused';
        } else if (actionBtn == 'qr_status_deleted') {
            modal = $("#DeleteModal");
            data['action'] = 'make_qrcode_deleted';
        } else if (actionBtn == 'qr_send_to_folder') {

            modal = $("#SendToModal");
            data['action'] = 'assign_folder_to_qrcode';
            var folderId = modal.find("#folderId").val()
            data['action'] = 'assign_folder_to_qrcode';
            data['folder_id'] = folderId;

        } else if (actionBtn == 'qr_status_resume') {
            modal = $("#ResumeModal");
            data['action'] = 'qr_status_resume';
        } else if (actionBtn == 'qr_status_restore') {
            modal = $("#RestoreModal");
            data['action'] = 'qr_status_resume';
        } else if (actionBtn == 'qr_code_hard_deleted') {
            modal = $("#HardDeleteModal");
            data['action'] = 'qr_code_hard_delete';
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
                closeAfterFooterActionDone(actionBtn);
            },
            error: () => {
                /* Re enable submit button */
                // submit_button.removeClass('disabled').text(text);
            },

        });
    });

    function closeAfterFooterActionDone(actionBtn) {
        $('.qrCode-footer').hide();
        qrCodeListing();
        if (actionBtn == 'qr_code_hard_deleted') {
            folderListing();
        } else if (actionBtn == 'qr_send_to_folder') {
            folderListing();
        }
    }
    $(document).on('click', '.selectFolder', function() {
        var modal = $(this).closest("#SendToModal");
        var folderId = $(this).data('project_id');
        modal.find("#folderId").val(folderId)
        modal.find(".footerActionBtn").removeAttr('disabled')
        // $("#SendToModal").find(".footerActionBtn").removeProp('disabled')
    });
    // $('#SendToModal').on('hidden.bs.modal close hidden shown shown.bs.modal', function (e) {
    $(document).on('hidden.bs.modal', '#SendToModal', function(e) {

        // do something…
        console.log(e)
        alert('close');
    });
    $(document).on('click', '.newFolderFromSendModal', function() {
        // create new folder code goes here
    });

    // $(document).on("click", ".qrCode-image", function() {
    //     var myBookId = $(this).data('id');
    //     console.log("myid", myBookId)
    //     $("#pre-qr").attr('src', myBookId);
    //     // As pointed out in comments, 
    //     // it is unnecessary to have to manually call the modal.
    //     // $('#addBookDialog').modal('show');
    // });

    function downloadModalClose() {
        $("#DownloadModal").removeClass('show');
        $('#DownloadModal').css({
            'display': 'none'
        });
        $(".modal-backdrop").remove();
    }
</script>

<?php \Altum\Event::add_content(ob_get_clean(), 'javascript') ?>