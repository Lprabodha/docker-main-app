<!-- Qr-code Modal -->
<div class="modal fade p-0 qr-code-model" id="QRcodeModal" tabindex="-1" aria-labelledby="QRcodeModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered large-modal">
        <div class="modal-content qr-model-content">
            <button type="button" class="large-icon" data-dismiss="modal" aria-label="Close">
                <svg class="MuiSvgIcon-root jss709 code-model-close-icon" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 28px;">
                    <path d="M13.41,12l5.3-5.29a1,1,0,1,0-1.42-1.42L12,10.59,6.71,5.29A1,1,0,0,0,5.29,6.71L10.59,12l-5.3,5.29a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0L12,13.41l5.29,5.3a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42Z"></path>
                </svg>
            </button>
            <div class="qrCodeWrap">
                <div class="qrCodeImg">
                  
                    <embed src="" class="qr-code-embed" loading="lazy"></embed>
                </div>
                <div class="scanme-img-wrap">
                    <div class="scan-me-text-wrap">
                        <span class="scan-me-text"><?= l('qr_codes.scan_me_text') ?></span>
                    </div>
                </div>
            </div>

            <input type="hidden" id="popDmQrcodeLink" value="">
            <input type="hidden" id="popFileName" value="">
            <input type="hidden" id="popQrId" value="">
            <input type="hidden" id="popQrUid" value="">
            <input type="hidden" id="popQrType" value="">


            <button type="button" class="btn qr-code-download-btn rounded-pill downloadBtn" data-toggle="modal" data-target="#DownloadModal"><span class="icon-downloadBtn qr-code-download-icon"></span> <span><?= l('global.download') ?></span></button>
            
        </div>
    </div>
</div>

<!-- Edit Url Modal -->
<div class="modal custom-modal fade" id="editURL" tabindex="-1" aria-labelledby="editURL" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-export">
        <div class="modal-content">
            <div class="modal-header">
                <h1><?= l('qr_codes.edit_url_modal.title') ?></h1>

                <button 
                    type="button" 
                    class="close custom-close" 
                    id="closeBtn" 
                    data-dismiss="modal" 
                    aria-label="Close"
                >
                    <svg class="MuiSvgIcon-root jss709" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 28px;">
                        <path d="M13.41,12l5.3-5.29a1,1,0,1,0-1.42-1.42L12,10.59,6.71,5.29A1,1,0,0,0,5.29,6.71L10.59,12l-5.3,5.29a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0L12,13.41l5.29,5.3a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42Z"></path>
                    </svg>
                </button>
            </div>

            <form id="editUrlForm" onsubmit="return false;">
                <input type="hidden" id="user_id" value="<?php echo isset($data->user_id) ? $data->user_id : ''; ?>" required>
                <input type="hidden" id="qr_id" value="" required>
                <div class="form-group m-0">
                    <label for="Name"><?= l('qr_codes.edit_url_modal.field_label') ?></label>
                    <input type="text" id="newUrl" class="form-control" >
                    <p id="urlErr" style="display:none;color:red"><?= l('qr_codes.edit_url_modal.field_error') ?></p>
                </div>
                <div class="modal-body modal-btn modalFooter ">
                    <button class="btn primary-btn m-0 grey-btn  r-4 font-medium custom-close" type="button" data-dismiss="modal" aria-label="Close"><?= l('qr_codes.cancel') ?></button>
                    <button type="button" id="saveUrl" class=" r-4 btn primary-btn create-folder-btn ml-2" ><?= l('qr_codes.save') ?></button>
                </div>
            </form>
        </div>
    </div>
</div>