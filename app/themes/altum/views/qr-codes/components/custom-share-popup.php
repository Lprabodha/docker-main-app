<div class="modal custom-modal fade share-modal" id="sharePopup" tabindex="-1" aria-labelledby="sharePopup" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-export">
        <div class="modal-content">
            <div class="modal-header">
                <h1><?= l('qr_share_popup.title') ?></h1>

                <button id="closeBtn" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <svg class="MuiSvgIcon-root jss709" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 28px;">
                        <path d="M13.41,12l5.3-5.29a1,1,0,1,0-1.42-1.42L12,10.59,6.71,5.29A1,1,0,0,0,5.29,6.71L10.59,12l-5.3,5.29a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0L12,13.41l5.29,5.3a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42Z"></path>
                    </svg>
                </button>
            </div>
            <div class="col-md-8 mx-auto">
                <form id="shareForm" class="w-100" name="folder_form" onsubmit="return false;">
                    <input type="hidden" id="uid" name="uid" value="<?php echo isset($data->user_id) ? $data->user_id : ''; ?>" required>
                    <div class="d-sm-flex w-100 share-by-email">

                        <div class="input-wrap">
                            <div class="form-group m-0 p-0" data-type="url" data-url="">
                                <label for="Name"><?= l('qr_share_popup.enter_email_label') ?></label>
                                <input type="email" id="recieverEmail" name="reciever_email" placeholder="<?= l('qr_share_popup.enter_email_placeholder') ?>" class="form-control" data-reload-qr-code="">
                            </div>
                            <p id="emailReq" style="display:none;color:red;margin-bottom:0;"><?= l('qr_share_popup.email_required_error') ?></p>
                        </div>
                        <div class="btn-wrap">
                            <button type="button" id="shareToEmailBtn" onclick="shareQrViaEmail()" class=" r-4 btn primary-btn create-folder-btn ml-2" name="Create"><?= l('qr_share_popup.send') ?></button>
                        </div>
                    </div>

                </form>

            </div>

            <div class="modal-body modal-btn modalFooter border-0">
            </div>

        </div>
    </div>
</div>


<script>
    $('#closeBtn').click(function() {
        $('#recieverEmail').val('');
        $('#emailReq').hide();        
    });

    var emailInput = document.getElementById("recieverEmail");

    emailInput.addEventListener("keypress", function(event) {
        if (event.keyCode === 13) {
            document.getElementById("shareToEmailBtn").click();
        }
    });

    $("#shareBtn").on("click", function() {
        if ($(window).width() > 1200){
            $('#sharePopup').css({'padding-right':'12px'});
        }
    });
</script>