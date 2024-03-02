<?php defined('ALTUMCODE') || die() ?>
<?php
$isPlanExpire = (new DateTime($this->user->plan_expiration_date) < new DateTime()) ? true : false;

?>


<div id="myQrCode">
    <div class="myQrCode-inner">

        <?php require THEME_PATH . 'views/plan/trial-banner.php' ?>

        <section class="container-fluid space-block scale-block">
            <?= \Altum\Alerts::output_alerts() ?>

            <!-- List view Header -->
            <div class="custom-heading-wrp d-flex  align-items-center">
                <div class="d-flex align-items-md-center justify-content-between w-100 folder-header-container">
                    <?php if (!empty($data->single_project) && is_array($data->single_project)) : ?>
                        <div class="d-flex align-items-md-center flex-md-row flex-column folder-title-wrp">
                            <a href="<?= url('qr-codes') ?>" class="back-btn mr-2">
                                <svg class="MuiSvgIcon-root jss2013" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 18px;">
                                    <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"></path>
                                </svg>
                            </a>
                            <h1 class="h4 custom-heading m-0 folderName flex-md-grow-0 flex-grow-1"><?= $data->single_project['name'] ?></h1>
                        </div>
                    <?php else : ?>
                        <div class="d-flex align-items-center">
                            <h1 class="custom-title m-0 "><?= l('qr_codes.header') ?></h1>

                        </div>
                    <?php endif ?>

                    <div class="d-flex justify-content-end">

                        <div>
                            <?php if (!empty($data->single_project) && is_array($data->single_project)) : ?>
                                <div class="d-flex align-items-center mr-1">
                                    <div>
                                        <a class="btn outline-btn font-bold  btn-with-icon mr-sm-3 mr-1 px-sm-4 d-flex align-items-center justify-content-between delete-folder-btn red-btn" data-toggle="modal" data-target="#DeleteProjectModal">
                                            <span class="icon-trash start-icon mr-sm-1 mr-0"></span>
                                            <span class="text d-sm-block d-none"><?= l('qr_codes.delete') ?></span>
                                        </a>
                                    </div>
                                    <div>
                                        <a class="btn outline-btn font-bold  btn-with-icon mr-sm-2 mr-0 px-sm-4 d-flex align-items-center justify-content-between edit-folder-btn" data-toggle="modal" data-target="#EditFolderModal">
                                            <span class="icon-edit start-icon mr-sm-1 mr-0"></span>
                                            <span class="text d-sm-block d-none"><?= l('qr_codes.edit') ?></span>
                                        </a>
                                    </div>

                                </div>
                            <?php else : ?>
                                <a class="btn outline-btn  btn-with-icon mr-sm-3 mr-1 px-sm-4 d-flex align-items-center justify-content-between new-folder-btn font-bold" data-toggle="modal" data-target="#createFolder">
                                    <span class="icon-folder-add start-icon mr-sm-1 mr-0">
                                    </span>
                                    <span class="text"><?= l('qr_codes.new_folder') ?></span>
                                </a>
                            <?php endif ?>
                        </div>
                        <div>
                            <?php if ($isPlanExpire || $this->user->plan_id == 5) : ?>
                                <button type="button" class="btn primary-btn  btn-with-icon  create-qr-btn font-bold" disabled>
                                    <span class="icon-add-barcode start-icon"></span>
                                    <span class="text"><?= l('qr_codes.create_qr_code') ?></span>
                                </button>
                            <?php else : ?>
                                <a href="<?= url('qr') ?><?= !empty($data->single_project['project_id']) ? "&project_id={$data->single_project['project_id']}" : '' ?>" class="btn primary-btn  btn-with-icon  create-qr-btn font-bold">
                                    <span class="icon-add-barcode start-icon"></span>

                                    <span class="text"><?= l('qr_codes.create_qr_code') ?></span>
                                </a>
                            <?php endif ?>
                        </div>
                    </div>
                </div>

            </div>

            <?= isset($data->planExpireBannerHtml)  ? $data->planExpireBannerHtml : '' ?>



            <?php if ($data->reviewBanner && $this->user->is_review == false && $this->user->onboarding_funnel != 4) : ?>
                <?php include_once(THEME_PATH . '/views/qr-codes/components/review-banner.php') ?>
            <?php endif ?>

            <!-- Edit Folder List view Header -->
            <?php if (empty($data->single_project)) : ?>
                <div class="folder-section">
                    <label><?= l('qr_codes.my_folder') ?></label>
                    <!-- After add folder design  -->
                    <div style="display:flex" id="availableFolder">
                    </div>
                </div>
            <?php endif ?>

            <div class="filter-container qr-codes-listing">
                <form id="qrCodeListFrm" action="javascript:void(0)">
                    <input type="hidden" name="project_id" value="<?= (!empty($data->single_project) && !empty($data->single_project['project_id'])) ? $data->single_project['project_id'] : '' ?>">
                    <div class="my-qr filters">
                        <div class="row">
                            <div class="col-xxl-3 col-xl-auto col-12 search-field-wrp">
                                <div class="form-group custom-mui-drop-down">
                                    <label class="fieldLabel"><?= l('qr_codes.my_qr_codes') ?></label>
                                    <div class="d-flex align-items-center">

                                        <div class="search-bar">
                                            <span class="icon-search"></span>
                                            <input type="search" class="form-control search-bar" placeholder="<?= l('qr_codes.my_qr_codes.placeholder') ?>" name="search_keyword" id="filters_search" value="" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-2 col-xl-auto col-lg-3 col-sm-6 qr-code-status-wrp">
                                <div class="form-group custom-mui-drop-down radios qr-code-status">
                                    <label for="filters_qrcode_by" class="fieldLabel"><?= l('qr_codes.qr_code_status') ?></label>
                                    <select class="multiSelect active-cstm" name="qr_code_status" data-live-search="false">
                                        <option value="1"><?= l('qr_codes.qr_code_status.active') ?></option>
                                        <option value="2"><?= l('qr_codes.qr_code_status.paused') ?></option>
                                        <option value="3"><?= l('qr_codes.qr_code_status.deleted') ?></option>
                                        <!-- <option value="4"><?= l('qr_codes.qr_code_status.blocked') ?></option> -->
                                    </select>
                                </div>
                            </div>
                            <div class="col-xxl-2 col-xl-auto col-lg-3 col-sm-6 qr-code-type-wrp">
                                <div class="form-group custom-mui-drop-down multiSelect-qrTypes">
                                    <label for="filters_type" class="fieldLabel"><?= l('qr_codes.qr_code_type') ?></label>
                                    <select class="multiSelect active-cstm " name="qr_code_type[]" data-live-search="false" multiple>
                                        <?php foreach (array_keys((require APP_PATH . 'includes/qr_code.php')['type']) as $type) : ?>
                                            <option value="<?= $type ?>"><?= l('qr_codes.type.' . $type) ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xxl-2 col-xl-auto col-lg-4 col-sm-6 sort-by-wrp">
                                <div class="form-group custom-mui-drop-down radios">
                                    <label for="Sort_by" class="fieldLabel"><?= l('qr_codes.sort_by') ?></label>
                                    <select class="multiSelect active-cstm" name="sort_by" data-live-search="false">
                                        <option value=""><?= l('qr_codes.sort_by.most_relevant') ?></option>
                                        <option value="name"><?= l('qr_codes.sort_by.name') ?></option>
                                        <option value="most-scan"><?= l('qr_codes.sort_by.most_scan') ?></option>
                                        <option value="last-modified"><?= l('qr_codes.sort_by.last_modified') ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xxl-2 col-xl-auto col-lg-2 col-sm-6 rows-count-wrp">
                                <div class="form-group custom-mui-drop-down radios">
                                    <label for="filters_results_per_page" class="fieldLabel"><?= l('qr_codes.quantity') ?></label>
                                    <select class="multiSelect quantity-cstm active-cstm" name="limit" data-live-search="false">
                                        <option value="10"><span>10</span></option>
                                        <option value="20">20</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                    <button class="btn more-filters-btn col-2" type="button">
                        <span class="icon-filter"></span>
                    </button>

                </form>
            </div>


            <div class="qrCode-check mb-4 ml-2 d-flex justify-content-between ">
                <div class="roundCheckbox">
                    <input type="checkbox" name="qr_code" id="qrAllSelected" class="qrAllSelected" value="all_checked" />
                    <label class="m-0" for="qrAllSelected">
                    </label>
                    <span class="select-all-label">
                        <?= l('qr_codes.select_all') ?></span>
                </div>

                <button class="d-none btn outline-btn  downloadBtn d-flex align-items-center" type="button" data-toggle="modal" data-target="#DownloadModal">
                    <span class="dropmenu-icon icon-download mr-1"></span>
                    <span class="text"><?= l('qr_codes.download') ?></span>
                </button>
            </div>

            <div id="qrCodeListing">
            </div>

        </section>
    </div>
    <section class="qrCode-footer" id="qrCodeFooterActive" style="display:none">
        <div class="container-fluid my-1 d-flex align-items-center justify-content-between h-100">
            <button class=" btn clear-btn  footerClose actionBtn " name="footer_close"><span><?= l('qr_codes.cancel') ?></span><span>X</span></button>
            <div class="d-flex align-items-center mx-2">
                <button class="btn outline-btn m-0 actionBtn pause-btn" type="button" data-toggle="modal" data-target="#PauseModal">
                    <span class="icon-pause-circle act-btn-icon"></span>
                    <span class="text d-xl-block d-none"><?= l('qr_codes.qr_code_status.pause') ?></span>
                </button>

                <button class="btn outline-btn btn-with-icon bulk downloadBtn action-bar-dl-btn <?= ($isPlanExpire) ? 'action-bar-dl-btn-disabled' : '' ?>" type="button" data-toggle="modal" data-target="#DownloadModal" <?= ($isPlanExpire) ? 'disabled' : '' ?>>
                    <span class="icon-download act-btn-icon"></span>
                    <span class="text d-xl-block d-none"><?= l('qr_codes.download') ?></span>
                </button>

                <button class="btn outline-btn m-0 dl-btn actionBtn delete-btn" type="button" data-toggle="modal" data-target="#DeleteModal">
                    <span class="icon-trash act-btn-icon"></span>
                    <span class="text d-xl-block d-none"><?= l('qr_codes.delete') ?></span>
                </button>

                <button class="btn primary-btn actionBtn send-to-btn" name="send_to_modal" data-toggle="modal" data-target="#SendToModal">
                    <span class="icon-folder act-btn-icon"></span>
                    <span class="text d-xl-block d-none"><?= l('qr_codes.send_to') ?></span>
                </button>
            </div>
            <div class="selected-code">
                <p><?= l('qr_codes.selected') ?></p>
                <span class="selectedValue"><span>1</span></span>
            </div>
        </div>
    </section>
    <section class="qrCode-footer" id="qrCodeFooterPaused" style="display:none">
        <div class="container-fluid my-1 d-flex align-items-center justify-content-between h-100">
            <button class=" btn clear-btn  footerClose actionBtn " name="footer_close"><span><?= l('qr_codes.cancel') ?></span><span>X</span></button>
            <div class="d-flex align-items-center mx-2">
                <button class="btn outline-btn m-0 actionBtn resume-btn" type="button" data-toggle="modal" data-target="#ResumeModal">
                    <span class="icon-play-circle act-btn-icon"></span>
                    <span class="text d-xl-block d-none"><?= l('qr_codes.resume') ?></span>
                </button>

                <button class="btn outline-btn m-0 dl-btn actionBtn delete-btn" type="button" data-toggle="modal" data-target="#DeleteModal">
                    <span class="icon-trash act-btn-icon"></span>
                    <span class="text d-xl-block d-none"><?= l('qr_codes.delete') ?></span>
                </button>

                <button class="btn primary-btn actionBtn send-to-btn" name="Create" data-toggle="modal" data-target="#SendToModal">
                    <span class="icon-folder act-btn-icon"></span>
                    <span class="text d-xl-block d-none"><?= l('qr_codes.send_to') ?></span>
                </button>
            </div>
            <div class="selected-code">
                <p><?= l('qr_codes.selected') ?></p>
                <span class="selectedValue"><span>1</span></span>
            </div>
        </div>
    </section>
    <section class="qrCode-footer" id="qrCodeFooterDeleted" style="display:none">
        <div class="container-fluid my-1 d-flex align-items-center justify-content-between h-100">
            <button class=" btn clear-btn  footerClose actionBtn " name="footer_close"><span><?= l('qr_codes.cancel') ?></span><span>X</span></button>
            <div class="d-flex align-items-center mx-2">
                <button class="btn primary-btn cclr actionBtn restore-btn" name="Create" data-toggle="modal" data-target="#RestoreModal">
                    <span class="start-icon">
                        <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 24px;">
                            <path d="M12,7a1,1,0,0,0-1,1v4a1,1,0,0,0,.45.83l3,2A.94.94,0,0,0,15,15a1,1,0,0,0,.55-1.83L13,11.46V8A1,1,0,0,0,12,7Z"></path>
                            <path d="M12,3a9,9,0,0,0-9,9v.59l-.29-.3a1,1,0,0,0-1.42,1.42l2,2a1,1,0,0,0,1.42,0l2-2a1,1,0,0,0-1.42-1.42l-.29.3V12a7,7,0,1,1,7,7,6.93,6.93,0,0,1-3.5-.94,1,1,0,0,0-1,1.74A9,9,0,1,0,12,3Z"></path>
                        </svg>
                    </span>
                    <span class="text d-xl-block d-none"><?= l('qr_codes.restore') ?></span>
                </button>

            </div>
            <div class="selected-code">
                <p><?= l('qr_codes.selected') ?></p>
                <span class="selectedValue"><span>1</span></span>
            </div>
        </div>
    </section>
</div>

<?php require THEME_PATH . 'views/qr-codes/js_qr_code.php' ?>
<?php \Altum\Event::add_content(include_view(THEME_PATH . 'views/partials/universal_delete_modal_form.php', [
    'name' => 'qr_code',
    'resource_id' => 'qr_code_id',
    'has_dynamic_resource_name' => true,
    'path' => 'qr-codes/delete'
]), 'modals'); ?>

<?php if (!empty($data->single_project) && is_array($data->single_project)) : ?>
    <!-- Edit Folder name Modal -->
    <div class="modal custom-modal fade" id="EditFolderModal" tabindex="-1" aria-labelledby="EditFolderModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-export">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="create-modal-text"><?= l('qr_codes.edit_folder') ?></h1>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <svg class="MuiSvgIcon-root jss709" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 20px;">
                            <path d="M13.41,12l5.3-5.29a1,1,0,1,0-1.42-1.42L12,10.59,6.71,5.29A1,1,0,0,0,5.29,6.71L10.59,12l-5.3,5.29a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0L12,13.41l5.29,5.3a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42Z"></path>
                        </svg>
                    </button>
                </div>


                <form id="editFolderForm" name="edit_folder_form" action="" target="_blank">
                    <input type="hidden" name="user_id" value="<?php echo $data->user_id; ?>">
                    <input type="hidden" name="project_id" value="<?= (!empty($data->single_project) && !empty($data->single_project['project_id'])) ? $data->single_project['project_id'] : '' ?>">
                    <div class="form-group m-0" data-type="url" data-url="">
                        <label for="Name"><?= l('qr_codes.name') ?></label>
                        <input type="text" name="name" class="form-control" data-reload-qr-code="" value="<?= (!empty($data->single_project) && !empty($data->single_project['name'])) ? $data->single_project['name'] : '' ?>">
                    </div>
                    <p id="nameReqEdit" class="nameReq" style="display:none;color:red"><?= l('qr_codes.name_is_required') ?></p>
                    <div class="modal-body modal-btn modalFooter">
                        <button class="btn primary-btn m-0 grey-btn  r-4" type="button" data-dismiss="modal" aria-label="Close"><?= l('qr_codes.cancel') ?></button>
                        <button type="button" id="editFolder" class="r-4 btn primary-btn save-edits-btn ml-2" name="Save"><?= l('qr_codes.save') ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php endif ?>
<!-- Add Folder Modal -->
<div class="modal custom-modal fade" id="createFolder" tabindex="-1" aria-labelledby="createFolder" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-export">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="create-modal-text dashboard-creat-folder-text"><?= l('qr_codes.create_new_folder') ?></h1>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <svg class="MuiSvgIcon-root jss709" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 28px;">
                        <path d="M13.41,12l5.3-5.29a1,1,0,1,0-1.42-1.42L12,10.59,6.71,5.29A1,1,0,0,0,5.29,6.71L10.59,12l-5.3,5.29a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0L12,13.41l5.29,5.3a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42Z"></path>
                    </svg>
                </button>
            </div>

            <form id="folderForm" name="folder_form" onsubmit="return false;">
                <input type="hidden" name="user_id" value="<?php echo isset($data->user_id) ? $data->user_id : ''; ?>" required>
                <div class="form-group m-0" data-type="url" data-url="">
                    <label for="Name"><?= l('qr_codes.sort_by.name') ?></label>
                    <input type="text" id="name" name="name" class="form-control" data-reload-qr-code="">
                </div>
                <p id="nameReq" style="display:none;color:red"><?= l('qr_codes.name_is_required') ?></p>
                <div class="modal-body modal-btn modalFooter ">
                    <button class="btn primary-btn m-0 grey-btn  r-4 font-medium" type="button" data-dismiss="modal" aria-label="Close"><?= l('qr_codes.cancel') ?></button>
                    <button type="button" id="makeFolder" class=" r-4 btn primary-btn create-folder-btn ml-2" name="Create"><?= l('qr_codes.create_folder') ?></button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Add folder modal when selecting qr's -->
<div class="modal custom-modal fade" id="createFolderWithQr" tabindex="-1" aria-labelledby="createFolder" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-export">
        <div class="modal-content">
            <div class="modal-header">
                <h1><?= l('qr_codes.create_new_folder') ?></h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <svg class="MuiSvgIcon-root jss709" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 20px;">
                        <path d="M13.41,12l5.3-5.29a1,1,0,1,0-1.42-1.42L12,10.59,6.71,5.29A1,1,0,0,0,5.29,6.71L10.59,12l-5.3,5.29a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0L12,13.41l5.29,5.3a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42Z"></path>
                    </svg>
                </button>
            </div>

            <form id="folderFormWithQr" name="folder_form" action="" onsubmit="return false;">
                <input type="hidden" name="user_id" value="<?php echo isset($data->user_id) ? $data->user_id : null; ?>" required>
                <div class="form-group m-0" data-type="url" data-url="">
                    <label for="Name"><?= l('qr_codes.sort_by.name') ?></label>
                    <input type="text" id="name" name="name" class="form-control" data-reload-qr-code="">
                </div>
                <p id="nameReq" style="display:none;color:red"><?= l('qr_codes.name_is_required') ?></p>
                <div class="modal-body modal-btn modalFooter">
                    <button class="btn primary-btn m-0 grey-btn  r-4 font-medium" type="button" data-dismiss="modal" aria-label="Close"><?= l('qr_codes.cancel') ?></button>
                    <button type="button" data-target="#SendToModal" data-dismiss="modal" data-toggle="modal" id="makeFolderWithQr" class="r-4 btn primary-btn create-folder-btn ml-2" name="Create">
                        <?= l('qr_codes.create_folder') ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Duplicate Modal -->
<div class="modal smallmodal fade" id="DuplicateModal" tabindex="-1" aria-labelledby="DuplicateModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-export">

        <div class="modal-content extra-space">
            <form id="duplicateForm">
                <input type="hidden" name="qr_code_id" id="duplicateQrCodeId">
            </form>
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
                <p><?= l('qr_codes.qr_duplicate_message') ?></p>
            </div>
            <div class="modal-body modal-btn justify-content-center">
                <button class="btn primary-btn grey-btn  m-0 r-4 me-2" type="button" data-dismiss="modal" aria-label="Close"><?= l('qr_codes.cancel') ?></button>
                <button class="btn primary-btn r-4 makeDuplicateQrCode" type="button" name="Create"><?= l('qr_codes.duplicate') ?></button>
            </div>
        </div>
    </div>
</div>
<!-- Restore Modal -->
<div class="modal smallmodal fade" id="RestoreModal" tabindex="-1" aria-labelledby="RestoreModal" aria-hidden="true">
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
                <p><?= l('qr_codes.select_qr_code_resume_message') ?></p>
            </div>
            <div class="modal-body modal-btn justify-content-center">
                <button class="btn primary-btn grey-btn  m-0 r-4 me-2" type="button" data-dismiss="modal" aria-label="Close"><?= l('qr_codes.cancel') ?></button>
                <button class="btn primary-btn r-4 footerActionBtn" name="qr_status_restore"><?= l('qr_codes.restore') ?></button>
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
                <p><?= l('qr_codes.select_qr_code_resume_message') ?></p>
            </div>
            <div class="modal-body modal-btn justify-content-center">
                <button class="btn primary-btn grey-btn  m-0 r-4 me-2" type="button" data-dismiss="modal" aria-label="Close"><?= l('qr_codes.cancel') ?></button>
                <button class="btn primary-btn r-4 footerActionBtn" name="qr_status_resume"><?= l('qr_codes.resume') ?></button>
            </div>
        </div>
    </div>
</div>
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
                <p><?= l('qr_codes.selected_qr_paused_message') ?></p>
            </div>
            <div class="modal-body modal-btn justify-content-center">
                <button class="btn primary-btn grey-btn  m-0 r-4 me-2" type="button" data-dismiss="modal" aria-label="Close"><?= l('qr_codes.cancel') ?></button>
                <button class="btn primary-btn r-4 footerActionBtn actionBtn" name="qr_status_paused"><?= l('qr_codes.qr_code_status.pause') ?></button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Project Modal -->
<div class="modal smallmodal fade" id="DeleteProjectModal" tabindex="-1" aria-labelledby="DeleteProjectModal" aria-hidden="true">
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
                    <path class="cls-2" d="M81.84,98H56.58a8,8,0,0,1-8-7.33L45.22,50h48L89.81,90.63A8,8,0,0,1,81.84,98Z" />
                    <path d="M101.19,49h-64a1,1,0,0,0,0,2H44.3l3.32,39.72a9,9,0,0,0,9,8.25H81.84a9.06,9.06,0,0,0,9-8.25L94.12,51h7.07a1,1,0,0,0,0-2ZM88.81,90.55a7,7,0,0,1-7,6.41H56.58a7,7,0,0,1-7-6.41L46.31,51h45.8Z" />
                    <path d="M57.22,45h24a2,2,0,0,0,0-4h-24a2,2,0,0,0,0,4Z" />
                    <path d="M58,88h.07A1,1,0,0,0,59,86.93l-2-27a1,1,0,1,0-2,.14l2,27A1,1,0,0,0,58,88Z" />
                    <path d="M79.93,88H80a1,1,0,0,0,1-.93l2-27a1,1,0,1,0-2-.14l-2,27A1,1,0,0,0,79.93,88Z" />
                    <path d="M69,88a1,1,0,0,0,1-1V60a1,1,0,0,0-2,0V87A1,1,0,0,0,69,88Z" />
                </svg>
                <p><?= l('qr_codes.folder_deleted_message_line1') ?><br>
                    <?= l('qr_codes.folder_deleted_message_line2') ?>
                </p>

            </div>
            <div class="modal-body modal-btn justify-content-center">
                <button class="btn primary-btn grey-btn  m-0 r-4 me-2 close" type="button" data-dismiss="modal" aria-label="Close"><?= l('qr_codes.cancel') ?></button>
                <button id="project_status_deleted" class="btn primary-btn red-btn r-4 footerActionBtn" name="project_status_deleted"><?= l('qr_codes.delete_modal.header') ?></button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal smallmodal fade" id="DeleteModal" tabindex="-1" aria-labelledby="DeleteModal" aria-hidden="true">
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
                    <path class="cls-2" d="M81.84,98H56.58a8,8,0,0,1-8-7.33L45.22,50h48L89.81,90.63A8,8,0,0,1,81.84,98Z" />
                    <path d="M101.19,49h-64a1,1,0,0,0,0,2H44.3l3.32,39.72a9,9,0,0,0,9,8.25H81.84a9.06,9.06,0,0,0,9-8.25L94.12,51h7.07a1,1,0,0,0,0-2ZM88.81,90.55a7,7,0,0,1-7,6.41H56.58a7,7,0,0,1-7-6.41L46.31,51h45.8Z" />
                    <path d="M57.22,45h24a2,2,0,0,0,0-4h-24a2,2,0,0,0,0,4Z" />
                    <path d="M58,88h.07A1,1,0,0,0,59,86.93l-2-27a1,1,0,1,0-2,.14l2,27A1,1,0,0,0,58,88Z" />
                    <path d="M79.93,88H80a1,1,0,0,0,1-.93l2-27a1,1,0,1,0-2-.14l-2,27A1,1,0,0,0,79.93,88Z" />
                    <path d="M69,88a1,1,0,0,0,1-1V60a1,1,0,0,0-2,0V87A1,1,0,0,0,69,88Z" />
                </svg>
                <p><?= l('qr_codes.qr_delete_message') ?><br><?= l('qr_codes.qr_delete_message_line_2') ?></p>
            </div>
            <div class="modal-body modal-btn justify-content-center">
                <button class="btn primary-btn grey-btn  m-0 r-4 me-2" type="button" data-dismiss="modal" aria-label="Close"><?= l('qr_codes.cancel') ?></button>
                <button class="btn primary-btn r-4 red-btn footerActionBtn" name="qr_status_deleted"><?= l('qr_codes.delete_modal.header') ?></button>
            </div>
        </div>
    </div>
</div>
<!-- Hard Delete Modal -->
<div class="modal smallmodal fade" id="HardDeleteModal" tabindex="-1" aria-labelledby="HardDeleteModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-export">
        <div class="modal-content extra-space">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
                    <path class="cls-2" d="M81.84,98H56.58a8,8,0,0,1-8-7.33L45.22,50h48L89.81,90.63A8,8,0,0,1,81.84,98Z" />
                    <path d="M101.19,49h-64a1,1,0,0,0,0,2H44.3l3.32,39.72a9,9,0,0,0,9,8.25H81.84a9.06,9.06,0,0,0,9-8.25L94.12,51h7.07a1,1,0,0,0,0-2ZM88.81,90.55a7,7,0,0,1-7,6.41H56.58a7,7,0,0,1-7-6.41L46.31,51h45.8Z" />
                    <path d="M57.22,45h24a2,2,0,0,0,0-4h-24a2,2,0,0,0,0,4Z" />
                    <path d="M58,88h.07A1,1,0,0,0,59,86.93l-2-27a1,1,0,1,0-2,.14l2,27A1,1,0,0,0,58,88Z" />
                    <path d="M79.93,88H80a1,1,0,0,0,1-.93l2-27a1,1,0,1,0-2-.14l-2,27A1,1,0,0,0,79.93,88Z" />
                    <path d="M69,88a1,1,0,0,0,1-1V60a1,1,0,0,0-2,0V87A1,1,0,0,0,69,88Z" />
                </svg>
                <p><?= l('qr_codes.qr_delete_message') ?></p>
            </div>
            <div class="modal-body modal-btn justify-content-center">
                <button class="btn primary-btn grey-btn  m-0 r-4 me-2" type="button" data-dismiss="modal" aria-label="Close"><?= l('qr_codes.cancel') ?></button>
                <button class="btn primary-btn r-4 footerActionBtn red-btn" name="qr_code_hard_deleted"><?= l('qr_codes.delete_modal.header') ?></button>
            </div>
        </div>
    </div>
</div>
<!-- Send to Modal -->
<div class="modal custom-modal fade" id="SendToModal" tabindex="-1" aria-labelledby="SendToModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-export">
        <div class="modal-content">
            <div class="modal-header align-items-start">
                <input type="hidden" name="folder_id" id="folderId" value="0">
                <h1 class="long-title"><?= l('qr_codes.selected_qr_code_heading') ?></h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <svg class="MuiSvgIcon-root jss709" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 20px;">
                        <path d="M13.41,12l5.3-5.29a1,1,0,1,0-1.42-1.42L12,10.59,6.71,5.29A1,1,0,0,0,5.29,6.71L10.59,12l-5.3,5.29a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0L12,13.41l5.29,5.3a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42Z"></path>
                    </svg>
                </button>
            </div>
            <div id="sendTofolderList" class="inner-block">
            </div>
            <div class="modal-body modal-btn">
                <button class="btn outline-btn r-4 me-2 grey-btn newFolderFromSendModal" type="button" data-dismiss="modal" data-toggle="modal" data-target="#createFolderWithQr">
                    <span class="icon-folder-add start-icon mx-1 mr-sm-1 mr-0"></span>
                    <?= l('qr_codes.new_folder') ?>
                </button>
                <button class=" r-4 btn primary-btn footerActionBtn qr-send-to-btn" name="qr_send_to_folder" disabled>
                    <?= l('qr_codes.send') ?>
                    <span class="icon-arrow-right start-icon ml-1 "></span>
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Download to Modal -->
<?php include_once(THEME_PATH . '/views/qr-codes/components/download-model.php') ?>

<!-- Custom share modal -->
<?php include_once(THEME_PATH . '/views/qr-codes/components/custom-share-popup.php') ?>

<!-- Pop View model -->
<?php include_once(THEME_PATH . '/views/qr-codes/components/modals.php'); ?>


<?php \Altum\Event::add_content(include_view(THEME_PATH . 'views/partials/universal_delete_modal_form.php', [
    'name' => 'qr_code',
    'resource_id' => 'qr_code_id',
    'has_dynamic_resource_name' => true,
    'path' => 'qr-codes/delete'
]), 'modals'); ?>




<?php ob_start() ?>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

<?php
$userLanguage =  user_language($this->user);
$userLanguageCode = \Altum\Language::$active_languages[$userLanguage] ? \Altum\Language::$active_languages[$userLanguage] : null;

?>

<script>
    $(document).on("click", "#editURL .custom-close", function() {

        // $('#editURL').hide();
        $('#editURL').fadeOut(100);
        $('#editURL').removeClass('show');
        $('body').removeClass('set-scroll-none');
        $('#overlayPre').css({
            'opacity': '0',
            'display': 'none'
        });

    });
    var user_id = '<?php echo $this->user->user_id; ?>';
    $(document).ready(function() {
        qrCodeListing();
        folderListing();

        $('.multiSelect').multiselect({
            // buttonWidth : '160px',
            includeSelectAllOption: false,
            nonSelectedText: '<?= l('qr_codes.qr_code_type.placeholder') ?>'
        });

        // set language code to current url
        var langURL = "<?= SITE_URL . ($userLanguageCode  == 'en'  ? null : $userLanguageCode  . '/') . (\Altum\Routing\Router::$original_request) ?>";

        if ('<?= url(\Altum\Routing\Router::$original_request) ?>' != langURL) {
            window.location.href = langURL;
        }

    }); /*End of document ready*/

    function folderListing() {
        user_id = user_id || '<?php echo $this->user->user_id; ?>';
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
        // $('#qrAllSelected').prop("checked",false);
    });
    $(document).on('keyup', '.form-control.search-bar', function() {
        var searchKeyword = $(this).val();
        var searchKeywordLen = parseInt(searchKeyword.length)

        if ((typeof searchKeyword == 'undefined' || searchKeyword == '') || searchKeywordLen >= 1) {
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
        var user_id = '<?php echo $this->user->user_id; ?>';
        var isPlanExpire = '<?php echo $isPlanExpire ? 1 : 0; ?>';
        var planId = '<?= $this->user->plan_id ?>';

        formData.append('action', 'qrcode_data_table');
        formData.append('user_id', user_id);
        formData.append('page_no', pageNo);
        formData.append('isPlanExpire', isPlanExpire);
        formData.append('planId', planId);

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


    $(document).on('click', '#deleteFolderButton', function(e) {

        e.preventDefault();
        var form = $("#deleteFolderForm")[0];
        var formData = new FormData(form);

        formData.append('action', 'deleteFolder');

        $.ajax({
            type: 'POST',
            url: '<?php echo url('api/ajax') ?>',
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function(response) {
                var data = response.data;
                $("#DeleteFolderModal").find("button.close").trigger('click');
                window.location.href = window.location.origin + window.location.pathname;

                // Data Layer Implementation (GTM)
                var event = "all_click";

                var qrData = {
                    "userId": "<?php echo $this->user->user_id ?>",
                    "clicktext": "Delete folder",

                }
                googleDataLayer(event, qrData);
            },
            error: () => {
                /* Re enable submit button */
                // submit_button.removeClass('disabled').text(text);
            },
        });

    });


    // delete my folder
    $(document).on('click', '#folderDelete', function() {
        var project_id = $("#project_id").val();
        var formData = new FormData();
        formData.append('action', 'deleteFolder');
        formData.append('user_id', '<?= $this->user->user_id ?>');
        formData.append('project_id', project_id);
        $.ajax({
            type: 'POST',
            url: '<?php echo url('api/ajax') ?>',
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function(response) {
                window.location.reload();
            },
            error: (code) => {
                if (code.status == 500) {
                    // console.log('failed');
                }
            },
        });

    });




    $(document).on('click', '#editFolder', function(e) {
        e.preventDefault();
        var form = $("#editFolderForm")[0];
        var formData = new FormData(form);

        formData.append('action', 'editFolder');
        if (formData.get('name')) {
            $(".nameReq").hide();
            $.ajax({
                type: 'POST',
                url: '<?php echo url('api/ajax') ?>',
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function(response) {
                    var data = response.data;
                    $("#EditFolderModal").find("button.close").trigger('click');
                    $(".folderName").text(data.name);
                    folderListing();
                    window.location.reload();

                    // Data Layer Implementation (GTM)
                    var event = "all_click";

                    var qrData = {
                        "userId": "<?php echo $this->user->user_id ?>",
                        "clicktext": "Edit folder",

                    }
                    googleDataLayer(event, data);
                },
                error: () => {
                    /* Re enable submit button */
                    // submit_button.removeClass('disabled').text(text);
                },

            });
        } else {
            $(".nameReq").show();
        }

    });

    $(document).on('click', '#makeFolder', function(e) {
        e.preventDefault();
        var form = $("#folderForm")[0];

        var formData = new FormData(form);
        // $params = $_POST['name'];
        formData.append('action', 'createFolder');
        if (formData.get('name')) {
            // var data = $('#Name').val();
            // $("#createFolder").modal().hide();
            $("#nameReq").hide();

            $("#createFolder").find("button.close").trigger('click');
            $(".modal-backdrop").remove();

            $("#createFolder").find('form').trigger('reset');
            $.ajax({
                type: 'POST',
                url: '<?php echo url('api/ajax') ?>',
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function(response) {
                    var data = response.data;
                    folderListing();

                    // Data Layer Implementation (GTM)
                    var event = "all_click";

                    var qrData = {
                        "userId": "<?php echo $this->user->user_id ?>",
                        "clicktext": "Create Folder",

                    }
                    googleDataLayer(event, qrData);
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

    $(document).on('click', '#makeFolderWithQr', function(e) {
        e.preventDefault();
        var form = $("#folderFormWithQr")[0];

        var formData = new FormData(form);
        // $params = $_POST['name'];
        formData.append('action', 'createFolder');
        if (formData.get('name')) {
            // var data = $('#Name').val();
            // $("#createFolder").modal().hide();
            $("#nameReq").hide();

            // $("#createFolder").find("button.close").trigger('click');
            // $(".modal-backdrop").remove();

            $("#createFolder").find('form').trigger('reset');
            $.ajax({
                type: 'POST',
                url: '<?php echo url('api/ajax') ?>',
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function(response) {
                    var data = response.data;
                    folderListing();
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
        console.log("downloadBtn clicked");
        $("#DownloadModal").removeClass('show');
        $('#DownloadModal').css({
            'display': 'none'
        });
        if (!$(this).hasClass('bulk')) {
            setQrCodeData(this);
        }
    });

    $(document).on('click', ".downloadQrCode", function() {

        var modal = $(this).closest("#DownloadModal");
        var type = $('.dl-modal-options').attr('data-selected');
        var size = $('.dl-modal-size-picker-options').attr('data-selected').split('x');
        var link = modal.find("#dmQrcodeLink").val();
        var fileName = modal.find("#fileName").val();
        var qrId = modal.find("#qr_id").val();
        var qrType = modal.find("#qr_type").val();
        var qrUid = modal.find("#qr_uid").val();
        var userId = "<?php echo $this->user->user_id ?>";
        const spinnerHTML = `<div class='px-1'><svg viewBox="25 25 50 50" class="new-spinner"><circle r="20" cy="50" cx="50"></circle></svg></div>
                            <span class="download-modal-text">Processing...</span>`;
        let dlButtonHTML = $(this).html();

        if ($(this).hasClass('single')) {
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
                        makePDF(link, size[0], size[1], width, height, fileName, qrUid);
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

            // Data Layer Implementation (GTM)
            var eventDownload = "qr_download";



            var eventData = {
                "userId": "<?php echo $this->user->user_id ?>",
                'user_type': '<?php echo $this->user->total_logins == '1' ? 'New User' : 'Returning User' ?>',
                'method': '<?php echo $this->user->source == 'direct' ? 'Email' : 'Google' ?>',
                "qr_type": qrType,
                "qr_id": qrUid,
                'entry_point': '<?php echo $this->user->total_logins == '1' ? 'Signup' : 'Signin' ?>',
                "qr_first": '<?php echo $data->qrCount == 1 ? 'first_time' : "null" ?>',

            }

            googleDataLayer(eventDownload, eventData);

        } else {
            const qrCodeIdArr = [];
            const qrSvgPaths = [
                [],
                []
            ];
            $("input.qrSelected:checked").each(function() {
                qrCodeIdArr.push($(this).val());
                qrSvgPaths[0].push($(this).attr('id'));
                qrSvgPaths[1].push($(this).attr('qr-name'));
                // console.log(this);
            });

            if (type === 'png' || type === 'jpeg') {

                $(this).html(spinnerHTML);
                ArchiveToZip(type, qrSvgPaths, size[0], size[1]);
                $(".downloadQrCode").html(dlButtonHTML);
                modal.find(".new-dl-close").trigger('click');

                isDownload(userId)

            } else {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo url('api/ajax') ?>',
                    data: {
                        qr_code_ids: qrCodeIdArr,
                        user_id: "<?php echo $this->user->user_id ?>",
                        action: "convert_svg",
                        type: type,
                        mode: 'bulk'
                    },
                    dataType: 'json',
                    beforeSend: () => {
                        $(this).html(spinnerHTML);
                    },
                    success: function(response) {
                        $(".downloadQrCode").html(dlButtonHTML);
                        if (type === "pdf") {
                            savePdf(response.ImageData, response.fileName, response.jobId);
                        } else {
                            ForceDownload(response.link, response.filename);
                        }
                    },
                    error: () => {
                        $(".downloadQrCode").html(dlButtonHTML);
                    }
                });
            }
        }

    });



    $(document).on('click', '.toPrintBtn', function(e) {
        $('.qrFrameWindow').remove();
        downloadModalClose();
        printModalRemove();
        e.preventDefault();
        var qrCodeCard = $(this).closest('.qrCode-card');
        var imgHtml = qrCodeCard.find('.qrCode-image').html();
        var imgHtmlSrc = qrCodeCard.find('.qrCode-image img').attr('src');
        var modal = $(this).closest("#DownloadModal");
        var link = modal.find("#dmQrcodeLink").val();
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

        if (imgHtml) {
            link = imgHtmlSrc
        }

        var iframe = document.createElement('iframe');
        iframe.setAttribute('class', 'qrFrameWindow');
        iframe.setAttribute('width', '100%');
        iframe.setAttribute('height', '100%');
        iframe.setAttribute('frameborder', '0');
        iframe.setAttribute('scrolling', 'no');

        const qrBlockStyles = {
            width: '100%',
            height: '100%',
            display: 'flex',
            alignItems: 'center',
            flexDirection: 'column',
            gap: '17px',
        }
        const ImagesStyles = {
            width: '300px',
            height: '100%',
        }

        var qrBlock = document.createElement('div');
        Object.assign(qrBlock.style, qrBlockStyles);

        let imgElement

        if ($(e.currentTarget).hasClass('bulk')) {

            $("input.qrSelected:checked").each((i, e) => {
                imgElement = document.createElement('img');
                imgElement.setAttribute('src', e.id);
                // Object.assign(imgElement.style,ImagesStyles);
                imgElement.setAttribute('style', 'width:100%;height:100%;');
                qrBlock.appendChild(imgElement);
            });

        } else {
            imgElement = document.createElement('img');
            imgElement.setAttribute('src', link);
            Object.assign(imgElement.style, ImagesStyles);
            qrBlock.appendChild(imgElement);
        }


        iframe.onload = function() {
            var iframeDocument = iframe.contentDocument || iframe.contentWindow.document;
            iframeDocument.body.appendChild(qrBlock);

            imgElement.onload = () => {
                iframe.contentWindow.print();
            }

            var modalback = $('.modal-backdrop');
            if (modalback.length === 0) {
                var modalbackBlock = document.createElement('div');
                modalbackBlock.setAttribute('class', 'modal-backdrop fade show');
                $('body').append(modalbackBlock);
            }

            setTimeout(function() {
                $(".modal-backdrop").remove();
            }, 1000);

        };

        document.body.appendChild(iframe);

        $(".close-download-model-btn").trigger('click');

        var event = "all_click";

        var qrData = {
            "userId": "<?php echo $this->user->user_id ?>",
            "clicktext": "Print Qr Code",

        }
        googleDataLayer(event, qrData);
    });



    //Make duplicate QR code
    $(document).on('click', '.whenOpenDuplicateModal', function() {
        var qrCodeId = $(this).data('qr_code_id');
        $("#DuplicateModal").find("#duplicateQrCodeId").val(qrCodeId);

        // Data Layer Implementation (GTM)
        var event = "all_click";

        var qrData = {
            "userId": "<?php echo $this->user->user_id ?>",
            "clicktext": "Duplicate Qr Code",

        }
        googleDataLayer(event, qrData);

    });
    $(document).on('click', '.makeDuplicateQrCode', function() {
        var form = $("#duplicateForm")[0];
        var formData = new FormData(form);
        var user_id = '<?php echo $this->user->user_id; ?>';

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
                qrCodeListing()

                // Data Layer Implementation (GTM)
                var event = "all_click";

                var qrData = {
                    "userId": "<?php echo $this->user->user_id ?>",
                    "clicktext": "Duplicate QR Code",

                }
                googleDataLayer(event, qrData);
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
        $('#qrAllSelected').prop('checked', false);
        $(this).closest('.qrCode-footer').hide();
    });

    function openFooterActionBar() {
        var statusValue = $("select[name=qr_code_status]").val();
        statusValue = parseInt(statusValue);

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
        if (totalChecked > 0) {
            qrCodeFooter.show();
            qrCodeFooter.find(".selectedValue > span").text(totalChecked);
        } else {
            qrCodeFooter.hide();
            qrCodeFooter.find(".selectedValue > span").text(0);
        }
    }

    // $(document).on('click', '.qrSelected', function() {
    //         if($(this).prop('checked', true)){
    //            console.log('checked');  
    //         }else{
    //            $(this).prop('checked', false);
    //        }
    // });
    $(document).on('change', '.qrSelected', function() {
        openFooterActionBar();
        var totalCheckBox = $('input.qrSelected').length;
        var totalCheckedBox = $('input.qrSelected:checked').length;
        $('#qrAllSelected').prop('checked', false);
        if (parseInt(totalCheckBox) === parseInt(totalCheckedBox)) {
            $('#qrAllSelected').prop('checked', true);

        } else {
            $('#qrAllSelected').prop('checked', false);

        }
        var checkedItemCard = $(this).parents('.qrcode-card-wrapper').children('.qrCode-card');
        if ($(this).is(':checked')) {
            console.log('checked');
            checkedItemCard.addClass('selected');
            console.log(checkedItemCard);
        } else {
            checkedItemCard.removeClass('selected');
            console.log('unchecked');
            console.log(checkedItemCard);

        }

        var checkboxes = $('.qrSelected');
        var isChecked = checkboxes.is(':checked');
        if (isChecked) {
            $('.myQrCode-inner').css('padding-bottom', '100px');
        } else {
            $('.myQrCode-inner').css('padding-bottom', '24px');
        }
    });

    $(document).on('change', "#qrAllSelected", function() {
        // $(document).on('change', '.qrSelected', function() {
        var allCards = $('.qrCode-card');
        if ($(this).is(':checked')) {
            $('input.qrSelected').prop('checked', true);
            allCards.addClass('selected');
            $('.myQrCode-inner').css('padding-bottom', '100px');
        } else {
            $('input.qrSelected').prop('checked', false);
            allCards.removeClass('selected');
            $('.myQrCode-inner').css('padding-bottom', '24px');
        }
        openFooterActionBar();
    });


    var qrCodeIdArr = [];
    $(document).on('click', '.qrCode-footer button.actionBtn', function() {
        $('#qrAllSelected').prop('checked', false);
        var dataTarget = $(this).data('target');
        var modal = $(`${dataTarget}`);
        qrCodeIdArr = [];
        $("input.qrSelected:checked").each(function() {
            qrCodeIdArr.push($(this).val());
        });
        if ($('#qrCodeListing .qrcode-card-wrapper .qrCode-card').hasClass('selected')) {
            $('#qrCodeListing .qrcode-card-wrapper .qrCode-card').removeClass('selected')
        }
    });
    $(document).on('click', '.dotactionBtn', function() {
        var qrcodeId = $(this).parents('.dropdown-menu').prev('.kebab-button').attr('data-qrcodeid');
        var dataTarget = $(this).data('target');
        var modal = $(`${dataTarget}`);
        qrCodeIdArr = [];
        qrCodeIdArr.push(qrcodeId);
    });
    $(document).on('click', '.footerActionBtn', function() {
        // var form = $("#duplicateForm")[0];
        // var formData = new FormData(form);
        var modal = null;
        var user_id = '<?php echo $this->user->user_id; ?>';

        var data = {
            'user_id': user_id,
            qrCodeIdArr: qrCodeIdArr
        }

        // formData.append('user_id', user_id);
        var actionBtn = $(this).attr('name');

        if (actionBtn == 'qr_status_paused') {
            modal = $("#PauseModal");
            data['action'] = 'make_qrcode_paused';

            console.log(modal);
            // Data Layer Implementation (GTM)
            var event = "all_click";

            var qrData = {
                "userId": "<?php echo $this->user->user_id ?>",
                "clicktext": "Pause QR Code",

            }
            googleDataLayer(event, qrData);

        } else if (actionBtn == 'qr_status_deleted') {
            modal = $("#DeleteModal");
            data['action'] = 'make_qrcode_deleted';
        } else if (actionBtn == 'qr_send_to_folder') {

            // Data Layer Implementation (GTM)
            var event = "all_click";

            var qrData = {
                "userId": "<?php echo $this->user->user_id ?>",
                "clicktext": "Send Qr Code",

            }
            googleDataLayer(event, qrData);

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


            // Data Layer Implementation (GTM)
            var event = "all_click";

            var qrData = {
                "userId": "<?php echo $this->user->user_id ?>",
                "clicktext": "Delete folder",

            }
            googleDataLayer(event, qrData);

        } else if (actionBtn == 'project_status_deleted') {
            modal = $("#DeleteProjectModal");
            data['action'] = 'makeProjectDeleted';
            data['projectId'] = '<?php echo  isset($_GET['project_id']) ? $_GET['project_id'] : ''; ?>';
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
        } else if (actionBtn == 'project_status_deleted') {
            window.location.href = "qr-codes/";
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
    $(document).on('click', '.newFolderFromSendModal', function() {
        // create new folder code goes here
    });

    $(document).on("click", ".qrCode-image", function() {
        var dataId = $(this).attr('data-id');
        var modalDl = $("#QRcodeModal .qr-code-embed");
        modalDl.attr('src', dataId);
        var myBookId = $(this).data('id');
        $("#pre-qr").attr('src', myBookId);

        var qrCodeCard = $(this).closest('.qrCode-card');
        var fileName = qrCodeCard.find('.qrCodeName').text();
        var link = qrCodeCard.find('.qrCode-image img').attr('src');
        var qrId = qrCodeCard.find('.qrCodeId').val();
        var qrUid = qrCodeCard.find('.qrCodeUid').val();
        var qrType = qrCodeCard.find('.qrCodeType').val();
        $("#QRcodeModal").find("#popFileName").val(fileName);
        $("#QRcodeModal").find("#popDmQrcodeLink").val(link);
        $("#QRcodeModal").find("#popQrId").val(qrId);
        $("#QRcodeModal").find("#popQrUid").val(qrUid);
        $("#QRcodeModal").find("#popQrType").val(qrType);

        // Data Layer Implementation (GTM)
        var event = "all_click";
        var data = {
            "userId": "<?php echo $this->user->user_id ?>",
            "clicktext": "Qr Code Image",

        }
        googleDataLayer(event, data);
    });

    $(document).on('click', '.qrnameChange', function() {
        var parent = $(this).closest('.qrCode-info');
        $(this).hide();
        parent.find(".qrnameInput").show();

        // Data Layer Implementation (GTM)
        var event = "all_click";

        var data = {
            "userId": "<?php echo $this->user->user_id ?>",
            "clicktext": "Rename Qr Code",

        }
        googleDataLayer(event, data);

    });

    $(document).on('click', '.qrnameSaveBtn', function() {

        // Data Layer Implementation (GTM)
        var event = "all_click";
        var qrData = {
            "userId": "<?php echo $this->user->user_id ?>",
            "clicktext": "Rename Qr Code",

        }
        googleDataLayer(event, qrData);


        var parent = $(this).closest('.qrCode-info');
        var oldName = parent.find('.qrCodeName').text();
        var newName = parent.find('.editQrField').val();
        var qr_code_id = $(this).data('qr_code_id');
        if (oldName === newName) {
            parent.find(".qrnameChange").show();
            parent.find(".qrnameInput").hide();
        } else {
            var data = {
                'user_id': user_id,
                qr_code_id: qr_code_id,
                qr_code_name: newName,
                action: "change_qr_name"
            }
            $.ajax({
                type: 'POST',
                url: '<?php echo url('api/ajax') ?>',
                data: data,
                dataType: 'json',
                success: function(response) {
                    parent.find('.qrCodeName').text(newName);
                    parent.find(".qrnameChange").show();
                    parent.find(".qrnameInput").hide();
                },
                error: () => {
                    /* Re enable submit button */
                    // submit_button.removeClass('disabled').text(text);
                },

            });
        }
    });
    $(document).ready(function() {
        $(".more-filters-btn").click(function() {
            $('.my-qr.filters').toggleClass('active');
            // console.log($(this).children('.few'));
            if ($(this).children('.few').hasClass('d-none')) {
                $(this).children('.more').addClass('d-none');
                $(this).children('.few').removeClass('d-none');
            } else {
                $(this).children('.few').addClass('d-none');
                $(this).children('.more').removeClass('d-none');
            }
        });
    });



    // Data Layer Implementation (GTM)
    $(document).on('click', '.create-qr-btn', function() {
        var event = "all_click";

        var data = {
            "userId": "<?php echo $this->user->user_id ?>",
            "clicktext": "Create QR Code",

        }
        googleDataLayer(event, data);
    });


    // Qr Detail click event data
    $(document).on('click', '.qrCodeDetail', function() {
        var event = "all_click";

        var data = {
            "userId": "<?php echo $this->user->user_id ?>",
            "clicktext": "QR Code Detail",

        }
        googleDataLayer(event, data);
    });


    // Folder Create button click event data
    $(document).on('click', '.new-folder-btn', function() {

        var event = "all_click";

        var data = {
            "userId": "<?php echo $this->user->user_id ?>",
            "clicktext": "New Folder",

        }
        googleDataLayer(event, data);
    });

    $(document).on('click', '.add-new-folder', function() {

        var event = "all_click";

        var data = {
            "userId": "<?php echo $this->user->user_id ?>",
            "clicktext": "New Folder",

        }
        googleDataLayer(event, data);
    });

    $(document).on('click', '#makeFolder', function() {

        var event = "all_click";

        var data = {
            "userId": "<?php echo $this->user->user_id ?>",
            "clicktext": "New Folder",

        }
        googleDataLayer(event, data);
    });


    // EDit Folder click event data
    $(document).on('click', '.edit-folder-btn', function() {

        var event = "all_click";

        var data = {
            "userId": "<?php echo $this->user->user_id ?>",
            "clicktext": "Edit folder",

        }
        googleDataLayer(event, data);
    });


    // Delete Folder click event
    $(document).on('click', '.delete-folder-btn', function() {

        var event = "all_click";

        var data = {
            "userId": "<?php echo $this->user->user_id ?>",
            "clicktext": "Delete folder",

        }
        googleDataLayer(event, data);
    });



    $(document).on('click', '.edit-qr-code', function() {

        var event = "all_click";

        var data = {
            "userId": "<?php echo $this->user->user_id ?>",
            "clicktext": "Edit Qr Code",

        }
        googleDataLayer(event, data);
    });



    // Pause QR Code click event
    $(document).on('click', '.pauseQRCode', function() {

        var event = "all_click";

        var data = {
            "userId": "<?php echo $this->user->user_id ?>",
            "clicktext": "Pause QR Code",

        }
        googleDataLayer(event, data);
    });

    $(document).on('click', '.pause-btn', function() {

        var event = "all_click";

        var data = {
            "userId": "<?php echo $this->user->user_id ?>",
            "clicktext": "Pause QR Code",

        }
        googleDataLayer(event, data);
    });


    // Delete QR Code button click event
    $(document).on('click', '.delete-btn', function() {
        var event = "all_click";

        var data = {
            "userId": "<?php echo $this->user->user_id ?>",
            "clicktext": "Delete QR Code",

        }
        googleDataLayer(event, data);
    });


    // Send QR Code Folder click event
    $(document).on('click', '.send-to-btn', function() {
        console.log("send to btn");

        var event = "all_click";

        var data = {
            "userId": "<?php echo $this->user->user_id ?>",
            "clicktext": "Send QR Code",

        }
        googleDataLayer(event, data);
    });

    window.addEventListener('load', (event) => {

        <?php if (isset($data->login_method)) { ?>

            var event = "login";
            var data = {
                "userId": "<?php echo $this->user->user_id ?>",
                "user_type": 'Returning User',
                "method": 'Google',
                "entry_point": "Signin",

            }
            googleDataLayer(event, data);

        <?php } ?>



    });
    setInterval(function() {
        $(document).ready(function() {
            if ($(".custom-modal").hasClass("show")) {
                $(".custom-modal").css("background-color", "#00000014");
            }
        });
    }, 1000);

    $(document).ready(function() {
        if ($(".alert-success").hasClass("altum-animate-fade-in")) {
            $(".alert-success").addClass('fadeDownMessage');
            $(".fadeDownMessage").slideDown().delay(5500).fadeOut();
        } else {
            console.log("Div Close");
        }
    });

    $(document).ready(function() {
        $('.multiSelect-qrTypes').find('.multiselect').click(function() {
            const multiSelectContainer = $('.multiSelect-qrTypes').find('.multiselect-container');
            multiSelectContainer.ready(() => {
                if (multiSelectContainer.attr('x-placement') === "bottom-start") {
                    const SMCBottom = multiSelectContainer[0].getBoundingClientRect().left;
                    const windowBottom = document.body.getBoundingClientRect().bottom;
                    const dif = Number(((windowBottom - SMCBottom)).toFixed());
                    if (0 > dif) {
                        if (multiSelectContainer.attr('oh')) {
                            multiSelectContainer.height(multiSelectContainer.attr('oh'));
                        }
                        const newHeight = multiSelectContainer.height() - Math.abs(dif);
                        multiSelectContainer.attr('oh', multiSelectContainer.height());
                        multiSelectContainer.height(newHeight);
                    }
                }
            });
        });
    });
</script>

<script>
    window.addEventListener('load', (event) => {
        <?php if (isset($data->login_method) && isset($isPlanExpire)) { ?>
            window.location.reload();
        <?php  } ?>

        <?php if (isset($data->login_method) && isset($reviewBanner)) { ?>
            window.location.reload();
        <?php  } ?>
    });
</script>

<script>
    $(".qr-code-download-btn").on("click", function() {
        // $('#QRcodeModal').modal().hide();
        $('.large-icon').trigger('click');
        $('.qr-code-model').removeClass('show');
        $(".close-download-model-btn").on("click", function() {
            $('.modal-backdrop').fadeOut(300, function() {
                $(this).remove();
            });
        });
    });

    $(document).ready(function() {
        if ($("#DownloadModal").hasClass("show")) {

            $(document).on('click', '.download-prtint-btn', function() {
                printModalRemove();
                downloadModalClose();
            });

            $("body").css({
                'overflow': 'hidden'
            });
        }
        if (window.matchMedia('(max-width: 576px)').matches) {
            if ($(".first-modal-img-wrap").find(".dl-modal-head-img").length > 0) {

                if ($(".dl-modal-head-img").css("display") == "none") {

                    $(".new-dl-modal-first-title").css({
                        'scale': '100%'
                    });
                }

                $(".close-download-model-btn").appendTo(".new-download-modal > .modal-dialog");

                $(".new-download-modal > .modal-dialog").css({
                    'background': 'linear-gradient(#daf3e6, #ffffff, #ffffff, #ffffff)',
                    'border-radius': "5px",
                    "pointer-events": "auto"
                });

                $(".new-download-modal > .modal-dialog > .modal-content").css({
                    'background': 'linear-gradient(#daf3e673,#ffffff,#ffffff,#ffffff)'
                });
            } else {
                console.log("false");
            }

        }
    });

    $(".close-download-model-btn").on("click", function() {
        $("body").css({
            'overflow': 'auto'
        });

        $(".new-download-modal > .modal-dialog").animate({
            opacity: 0,
        }, 500, function() {
            $(this).removeAttr("style");
        });

        $("#DownloadModal").css({
            'display': 'none'
        }).removeClass('show');

        $('.modal-backdrop').fadeOut(300, function() {
            $(this).remove();
        });

        $(".new-download-modal > .modal-dialog > .modal-content").css({
            'background': ''
        });

        $(".close-download-model-btn").appendTo(".new-download-modal > .modal-dialog > .modal-content");

    });


    $(document).on('click', '.download-prtint-btn', function() {
        $(document).on('click', '.download-prtint-btn', function() {
            printModalRemove();
            $(".downloadBtn").trigger("click");
            downloadModalClose();
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

        }
    }



    $("#qrCodeListing").on("mouseover", function() {
        var qrCardCount = $('.qrcode-card-wrapper').length;



        // if ($(window).width() < 767) {
        $('#qrCodeListing .qrcode-card-wrapper').last().children('.qrCode-card').children('.row').addClass('last-qr-code').children('.qr-actions-dropdown-wrp').children('.right').children('.dropdown-menu-right').addClass('last-qr-dropdown-btn').attr('x-placement', 'top-end');
        // } else {
        // setInterval(() => {
        //     $('#qrCodeListing .qrcode-card-wrapper').last().children('.qrCode-card').children('.row').addClass('last-qr-code').children('.qr-actions-dropdown-wrp').children('.right').children('.dropdown-menu-right').addClass('last-qr-dropdown-btn').attr('x-placement', 'top-end');
        // }, 1000);
        // }

        if (qrCardCount == 1) {
            $('#qrCodeListing .qrcode-card-wrapper').first().children('.qrCode-card').children('.row').addClass('last-qr-code').children('.qr-actions-dropdown-wrp').children('.right').children('.dropdown-menu-right').attr('x-placement', 'bottom-end').css({
                'top': '0px'
            });
        }

    });

    $(window).on('scroll', function() {
        if ($(".dropdown-menu-right").hasClass("show")) {
            $(".dropdown-menu-right").removeClass("show");
            $(".right").removeClass("show");
        }
    });
</script>

<script>
    // Data Layer Implementation (GTM)
    window.addEventListener('load', (event) => {

        <?php if ($data->auth_method != '') { ?>
            let method = '<?= $data->auth_method ?>';
            let user_id = '<?= $this->user->user_id ?>';
            let unique_id = '<?= isset($this->user->unique_id) ? $this->user->unique_id : null  ?>';
            let client_id = '<?php echo get_client_id() != null ? get_client_id() : default_client_id() ?>';
            let funnel = 'nsf';
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
                            "funnel": 'nsf',
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

    function downloadModalClose() {
        $("#DownloadModal").removeClass('show');
        $('#DownloadModal').css({
            'display': 'none'
        });
        $('#DownloadModal').removeAttr('aria-modal');
        $(".modal-backdrop").remove();
    }

    $(document).on('click', '.review-modal-close', function(e) {
        $("#reviewModal").find("#closeBtn").trigger('click');
        $(".modal-backdrop").remove();
    });
</script>

<script>
    function isDownload(user_id) {

        var data = {
            user_id: user_id,
            action: "is_download",
        }

        $.ajax({
            type: 'POST',
            url: '<?php echo url('api/ajax') ?>',
            data: data,
            dataType: 'json',
            success: function(response) {},
            error: () => {},

        });
    }
</script>




<?php \Altum\Event::add_content(ob_get_clean(), 'javascript') ?>