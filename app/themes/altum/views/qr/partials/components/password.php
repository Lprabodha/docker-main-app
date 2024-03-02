<div class="custom-accodian">
    <button class="btn accodianBtn collapsed pwcol" data-toggle="collapse" type="button" data-target="#acc_password" aria-expanded="false" aria-controls="acc_password">
        <div class="qr-step-icon">
            <span class="icon-lock grey steps-icon"></span>
        </div>
        <span class="custom-accodian-heading">
            <span style="line-height: 1.25;" class="d-flex align-items-center">
                <span><?= l('qr_step_2_com_password.input.password') ?></span>
                <span class="info-tooltip-icon ctp-tooltip pwtp" tp-content="<?= l('qr_step_2_com_password.help_tooltip.password') ?>"></span>
            </span>

        </span>
        <div class="toggle-icon-wrap ml-2">
            <span class="icon-arrow-h-right grey toggle-icon"></span>
        </div>
    </button>
    <div class="collapse" id="acc_password">
        <hr class="accordian-hr">
        <div class="collapseInner">
            <div class="form-group m-0 passwordBlock" id="passwordBlock">
                <div class="d-flex passowrd-full-wrap align-items-center mb-3">
                    <div class="roundCheckbox passwordCheckbox mr-3">
                        <input class="passcheckbox" type="checkbox" id="passcheckbox" <?php echo ((isset($filledInput['password']) &&  $filledInput['password'] != '') ? 'checked' : '')  ?> />
                        <label class="m-0" for="passcheckbox"></label>
                    </div>
                    <div class="passowrd-text-wrap">
                        <label class="passwordlabel mb-0"><?= l('qr_step_2_com_password.password_active') ?></label>
                    </div>
                </div>
                <?php if (isset($filledInput['password']) && $filledInput['password'] != '') { ?>
                    <div class="step-form-group password-field-wrap">
                        <label class="filed-label" for="passowrd"><?= l('qr_step_2_com_password.input.password') ?></label>
                        <input autocomplete="new-password" type="password" name="password" class="step-form-control passwordField" placeholder="<?= l('qr_step_2_com_password.input.password.placehoder') ?>" value="<?php echo (!empty($filledInput)) ? $filledInput['password'] : '' ?>" maxlength="30" data-reload-qr-code />
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        var pwtpElements = $(".pwtp");
        pwtpElements.click(function(event) {
            event.stopPropagation();
        });
    });
</script>