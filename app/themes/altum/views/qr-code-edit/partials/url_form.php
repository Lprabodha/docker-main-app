<?php defined('ALTUMCODE') || die() ?>

<div id="step2_form">
    <input type="hidden" id="uId" name="uId" class="form-control" value="<?= uniqid() ?>" data-reload-qr-code />
    <input type="hidden" id="preview_link" name="preview_link" class="form-control" data-reload-qr-code />
    <input type="hidden" id="preview_link2" name="preview_link2" class="form-control" data-reload-qr-code />
    <div class="custom-accodian">
        <button class="btn accodianBtn" type="button" data-toggle="collapse" data-target="#acc_nameOfQrCode" aria-expanded="true" aria-controls="acc_nameOfQrCode">
            <span><?= l('qr_codes.input.qrname') ?></span>
            <svg class="MuiSvgIcon-root MuiSvgIcon-colorPrimary leftArrow" focusable="false" viewBox="0 0 16 16" aria-hidden="true" style="font-size: 16px;">
                <path d="M12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5ZM12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5Z"></path>
            </svg>
        </button>
        <div class="collapse show" id="acc_nameOfQrCode">
            <div class="collapseInner">
                <div class="form-group m-0">
                    <!-- <label for="name"> <?= l('qr_codes.input.qrname') ?></label> -->
                    <input id="name" name="name" placeholder="E.g. My QR code" class="form-control" value="" required />
                </div>
            </div>
        </div>
    </div>

    <div class="custom-accodian">
        <button class="btn accodianBtn" type="button" data-toggle="collapse" data-target="#acc_nameOfUrl" aria-expanded="true" aria-controls="acc_nameOfUrl">
            <span>Website information</span>
            <svg class="MuiSvgIcon-root MuiSvgIcon-colorPrimary leftArrow" focusable="false" viewBox="0 0 16 16" aria-hidden="true" style="font-size: 16px;">
                <path d="M12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5ZM12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5Z"></path>
            </svg>
        </button>
        <div class="collapse show" id="acc_nameOfUrl">
            <div class="collapseInner">
                <div class="form-group m-0" data-type="url" data-url>
                    <label for="url">Website URL</label>
                    <input type="url" id="url" name="url" placeholder="E.g. https://www.myweb.com/" class="form-control" value="" maxlength="<?= $data->qr_code_settings['type']['url']['max_length'] ?>" required data-reload-qr-code />
                </div>
            </div>
        </div>
    </div>

    <?php if (settings()->users->register_is_enabled) : ?>
        <div class="form-group" data-type="url" data-link-id>
            <div class="d-flex flex-column flex-xl-row justify-content-between">
                <label for="link_id"><i class="fa fa-fw fa-link fa-sm mr-1"></i> <?= l('qr_codes.input.link_id') ?></label>
                <a href="<?= url('link-create') ?>" target="_blank" class="small mb-2"><i class="fa fa-fw fa-sm fa-plus mr-1"></i> <?= l('global.create') ?></a>
            </div>
            <select id="link_id" name="link_id" class="form-control" required data-reload-qr-code>
                <?php foreach ($data->links as $row) : ?>
                    <option value="<?= $row->link_id ?>"><?= $row->full_url ?></option>
                <?php endforeach ?>
            </select>
        </div>

        <div class="form-group" data-type="url">
            <div <?= \Altum\Middlewares\Authentication::check() ? null : 'data-toggle="tooltip" title="' . l('global.info_message.plan_feature_no_access') . '"' ?>>
                <div class="<?= \Altum\Middlewares\Authentication::check() ? null : 'container-disabled' ?>" style="display:none ;">
                    <div class="custom-control custom-checkbox">
                        <input id="url_dynamic" name="url_dynamic" type="checkbox" class="custom-control-input" data-reload-qr-code />
                        <label class="custom-control-label" for="url_dynamic"><?= l('qr_codes.input.url_dynamic') ?></label>
                        <small class="form-text text-muted"><?= l('qr_codes.input.url_dynamic_help') ?></small>
                    </div>
                </div>
            </div>
        </div>

        <div class="custom-accodian">
            <button class="btn accodianBtn" type="button" data-toggle="collapse" data-target="#acc_password" aria-expanded="false" aria-controls="acc_password">
                <span class="password">Password</span>
                <svg class="MuiSvgIcon-root MuiSvgIcon-colorPrimary leftArrow" focusable="false" viewBox="0 0 16 16" aria-hidden="true" style="font-size: 16px;">
                    <path d="M12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5ZM12.44,12.06,8,7.62,3.56,12.06,1.44,9.94l5.5-5.5a1.49,1.49,0,0,1,2.12,0l5.5,5.5Z"></path>
                </svg>
            </button>
            <div class="collapse" id="acc_password">
                <div class="collapseInner">
                    <div class="form-group m-0" id="passwordBlock">
                        <div class="d-flex align-items-center mb-3">
                            <div class="roundCheckbox passwordCheckbox mr-3">
                                <input type="checkbox" id="passcheckbox" />
                                <label class="m-0" for="passcheckbox"></label>
                            </div>
                            <label class="passwordlabel mb-0">Activate password to access the QR code</label>
                        </div>
                        <!-- <input id="passwordField" type="password" name="password" class="form-control" value="" maxlength="30" data-reload-qr-code /> -->
                    </div>
                </div>
            </div>
        </div>
    <?php endif ?>
</div>