<?php defined('ALTUMCODE') || die() ?>

<?php

$country  = null;
if ($this->user->country) {
    $country  = $this->user->country;
} else if (isset($data->taxData->country)) {
    $country  = $data->taxData->country;
}


?>


<style>
    input.error {
        border: 1px solid red !important;
    }

    .deleteCard {
        display: none;
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css">
<div id="success"></div>
<div class="my-account my-account-wrp container-fluid space-block container-warp">
    <?= \Altum\Alerts::output_alerts() ?>
    <!-- <?= $this->views['account_header_menu'] ?> -->

    <div class="headingName m-0 mb-2">
        <h1 class="myaccount-title"><?= l('account.menu') ?></h1>
    </div>
    <!-- <form action="" method="" role="form" id="accountForm"> -->
    <input type="hidden" name="token" value="<?= \Altum\Middlewares\Csrf::get() ?>" />
    <input type="hidden" name="user_id" value="<?php echo $this->user->user_id; ?>">


    <div class="accountTabbing">
        <div class="tab-content" id="myTabContent">
            <div class="myaccount-nav">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item active_item border_round not_active" onclick="linkPreviousChange()" id="active_link" role="presentation">
                        <button class="navLinkBtn active " id="generalInfo-tab" data-toggle="tab" data-target="#generalInfo" type="button" role="tab" aria-controls="generalInfo" aria-selected="true"><span class="desktop-nav-btn"><?= l('account.general') ?></span><span class="mobile-nav-btn"><?= l('account.general.mobile') ?></span></button>
                    </li>
                    <li class="nav-item border_style border_round" onclick="linkChange(),colorChange()" id="nav2" role="presentation">
                        <button class="navLinkBtn " id="taxInfo-tab" data-toggle="tab" data-target="#taxInfo" type="button" role="tab" aria-controls="taxInfo" aria-selected="false"><span class="desktop-nav-btn"><?= l('account.tax') ?></span><span class="mobile-nav-btn"><?= l('account.tax.mobile') ?></span></button>
                    </li>
                    <li class="nav-item border_style border_round d-none" onclick="linkChange(),borderChange()" id="nav3" role="presentation">
                        <button class="navLinkBtn" id="trackAnalytics-tab" data-toggle="tab" data-target="#trackAnalytics" type="button" role="tab" aria-controls="trackAnalytics" aria-selected="false"><span class="desktop-nav-btn"><?= l('account.tracking') ?></span><span class="mobile-nav-btn"><?= l('account.tracking.mobile') ?></span></button>
                    </li>
                </ul><?php
                        $fullname = $this->user->name;
                        $fullname = explode(" ", $fullname);
                        $name = isset($fullname[0]) ? $fullname[0] : '';
                        $surname = isset($fullname[1]) ? $fullname[1] : '';
                        ?>
            </div>
            <div class="tab-pane fade show active" id="generalInfo" role="tabpanel" aria-labelledby="generalInfo-tab">
                <div class="accountCardDetail contactDetail">
                    <form id="contactform">
                        <div class="accountCardDetailRow d-flex align-items-start">
                            <h2 class="mb-3"><?= l('account.contact') ?></h2>
                            <div class="container-fluid fullCard rounded">
                                <div class="row m-0">
                                    <div class="form-group my-account-form-group col-md-6 col-sm-12 px-md-3 px-2">
                                        <label for="name"><?= l('account.name') ?></label>
                                        <div class="input-field-area">
                                            <input type="text" id="name" name="name" placeholder="<?= l('account.settings.name.placeholder') ?>" class="rounded-end form-control input-field-control <?= \Altum\Alerts::has_field_errors('name') ? 'is-invalid' : null ?>" value="<?php echo $name; ?>" maxlength="32" />
                                            <?= \Altum\Alerts::output_field_error('name') ?>
                                            <div class="input_icons_field m-auto d-flex rounded-start">
                                                <span class="icon-profile grey input_icon"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group my-account-form-group col-md-6 col-sm-12 px-md-3 px-2">
                                        <label for="name"><?= l('account.surname') ?></label>
                                        <div class="input-field-area">
                                            <input type="text" id="surname" name="surname" placeholder="<?= l('account.settings.surname.placeholder') ?>" class="rounded form-control input-field-control <?= \Altum\Alerts::has_field_errors('name') ? 'is-invalid' : null ?>" value="<?php echo $surname; ?>" maxlength="32" />
                                            <?= \Altum\Alerts::output_field_error('name') ?>
                                            <div class="input_icons_field m-auto d-flex  rounded-start">
                                                <span class="icon-profile grey input_icon"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row m-0">
                                    <div class="form-group my-account-form-group col-md-6 col-sm-12 px-md-3 px-2 email-field">
                                        <label for="email"><?= l('account.settings.email') ?></label>
                                        <div class="input-field-area">
                                            <input type="text" id="email" name="email" placeholder="<?= l('account.settings.email.placeholder') ?>" class="rounded  input-field-control form-control <?= \Altum\Alerts::has_field_errors('email') ? 'is-invalid' : null ?>" value="<?= $this->user->email ?>" maxlength="128" autocomplete="true" <?= $this->user->source == 'google' ? 'readonly' : '' ?> />
                                            <?= \Altum\Alerts::output_field_error('email') ?>
                                            <div class="input_icons_field m-auto d-flex rounded-start">
                                                <span class="icon-email grey input_icon"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group my-account-form-group col-md-6 col-sm-12 px-md-3 px-2 ">
                                        <label><?= l('account.settings.telephone') ?></label>
                                        <div class="input-field-area">
                                            <input class="rounded form-control input-field-control" type="number" name="telephone" value="<?= $this->user->telephone ?>" id="telephone" placeholder="<?= l('account.settings.telephone.placeholder') ?>" />
                                            <?= \Altum\Alerts::output_field_error('name') ?>
                                            <div class="input_icons_field m-auto d-flex  rounded-start">
                                                <span class="icon-call grey input_icon"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="accountCardDetailBtn accountButton mt-4 px-md-3 px-2">
                                    <div class="update_button_area d-flex float-start">
                                        <button class="accountSaveButton btn btn-update rounded" id="sbmt" type="button"><?= l('account.save') ?></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="accountCardDetail">
                    <form id="passwordForm">
                        <div class="accountCardDetailRow d-flex align-items-start">
                            <h2 class="mb-3"><?= l('account.change_password') ?></h2>
                            <div class="container-fluid fullCard rounded">
                                <div class="row m-0 w-100">
                                    <div class="form-group my-account-form-group col-md-6 col-sm-12 px-md-3 px-2">
                                        <label><?= l('account.password') ?></label>
                                        <div class="input-field-area">
                                            <input type="password" class="form-control input-field-control formMiWidth <?= \Altum\Alerts::has_field_errors('password') ?: null ?>" value="" id="password" name="password" />
                                            <div class="input_icons_field m-auto d-flex rounded-start icon-position mobile-icon-position">
                                                <span class="icon-lock grey input_icon"></span>
                                            </div>
                                            <div class="show_password m-auto d-flex mobile-icon-position">
                                                <input type="checkbox" onclick="showPassword()" class="password_check" name="" id="password_check">
                                                <span class="icon-eye-off grey input_icon" id="password_eyeoff"></span>
                                                <span class="icon-eye-on grey input_icon eye_on" id="password_eyeon" aria-hidden="true"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group my-account-form-group col-md-6 col-sm-12 px-md-3 px-2">
                                        <label><?= l('account.repassword') ?></label>
                                        <div class="input-field-area">
                                            <input type="password" oninput="passwordCheck()" class="form-control input-field-control formMiWidth" value="" name="repassword" id="re_password" type="text" />
                                            <?= \Altum\Alerts::has_field_errors('re_password') ?: null ?>
                                            <div class="input_icons_field m-auto d-flex rounded-start icon-position">
                                                <span class="icon-lock grey input_icon"></span>
                                            </div>
                                            <div class="show_password m-auto d-flex">
                                                <input type="checkbox" onclick="showRePassword()" class="password_check" name="" id="password_check">
                                                <span class="icon-eye-off grey input_icon" id="repassword_eyeoff"></span>
                                                <span class="icon-eye-on grey input_icon eye_on" id="repassword_eyeon" aria-hidden="true"></span>
                                            </div>
                                        </div>
                                        <span class="ms-2" id="password_error"></span>
                                    </div>
                                </div>
                                <div class="accountCardDetailBtn px-md-3 px-2">
                                    <div class="update_button_area d-flex float-start">
                                        <button class="accountSaveButton btn btn-update rounded" id="passSave" type="button"><?= l('account.save') ?></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>


                <div class="accountCardDetail language-card">
                    <form id="languagedData">
                        <div class="accountCardDetailRow d-flex align-items-start">
                            <h2 class="mb-3"><?= l('account.language') ?></h2>
                            <div class="container-fluid fullCard rounded">
                                <div class="row m-0 country_select">
                                    <div class="form-group my-account-form-group col-md-6 col-sm-12 px-md-3 px-2">
                                        <label><?= l('account.language') ?></label>
                                        <div class="input_field d-flex rounded">
                                            <div class="input_icons_field language-icon m-auto d-flex rounded-start">
                                                <span class="icon-global grey input_icon"></span>
                                            </div>
                                            <select name="language" id="language" class="form-control input-field-control formMiWidth">
                                                <?php if (APP_CONFIG == 'local') { ?>
                                                    <?php foreach (\Altum\Language::$languages as $key => $language) : ?>
                                                        <?php if ($language['status'] == 'active') : ?>
                                                            <option value="<?= $language['code'] ?>" <?php if ($this->user->language == $language['name']) {
                                                                                                            echo 'selected';
                                                                                                        } ?>>
                                                                <?= l('account.language_name.' . $language['name']) ?>
                                                            </option>
                                                        <?php endif ?>
                                                    <?php endforeach ?>
                                                <?php } else { ?>
                                                    <option value="en">English</option>
                                                <?php }  ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="accountCardDetailBtn  mt-3 px-md-3 px-2">
                                    <div class="update_button_area d-flex float-start">
                                        <button class="accountSaveButton btn btn-update rounded" id="LangSave" type="button"><?= l('account.save') ?></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>


                <div class="accountCardDetail deleteCard mb-5">
                    <form>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="accountCardDetailRow deleteCard">
                                    <h2 class="delete-title mb-3"><?= l('account.status') ?></h2>
                                    <p class="headDes"><?= l('account.delete') ?></p>
                                </div>
                            </div>
                            <div class="col-md-6 m-auto">
                                <div class="accountDeleteBtn">
                                    <div class="btn deleteBtn d-flex rounded">
                                        <span class="icon-trash grey deleteIcon"></span>
                                        <a href="<?= url('account-delete') ?>" class="accountSaveButton delete-btn-text delete-btn-font-color accountDeleteButton rounded-end" id="DeleteData" type=""><?= l('account.delete_button') ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="tab-pane fade" id="taxInfo" role="tabpanel" aria-labelledby="taxInfo-tab">
                <div class="accountCardDetail tax-full-wrap">
                    <form id="texForm">
                        <div class="container-fluid tax fullCard rounded">
                            <div class="taxCardDetailRow">
                                <div class="companyTypeGroup mb-3">
                                    <div class="companyItem">
                                        <label><?= l('account.type') ?></label>
                                        <input type="radio" class="radioButton" id="comapanyRadio" value="company" name="radio" checked onclick="toggleText(false)">
                                        <button class="companyTypeButton rounded-pill" id="comapany" value="company" name="radio" type="button"><?= l('account.company') ?></button>
                                    </div>
                                    <div class="companyItem">
                                        <input type="radio" class="radioButton" id="privateRadio" value="private" name="radio" onclick="toggleText(true)">
                                        <button class="companyTypeButton rounded-pill" id="private" value="private" name="radio" type="button"><?= l('account.private') ?></button>
                                    </div>
                                </div>
                                <div class="row m-0 mt-4" style="position: relative; z-index:50;">
                                    <div class="form-group my-account-form-group col-md-6 col-sm-12 px-md-3 px-2" id="notoptinal">
                                        <label id="companyLabel"><?= l('account.company_name') ?></label>
                                        <div class="input_field d-flex rounded">
                                            <div class="input_icons_field m-auto d-flex rounded-start">
                                                <span class="icon-company tx-icon grey input_icon"></span>
                                            </div>
                                            <input class="form-control w-100 input-field-control" id="company_name" name="company_name" value="<?= $data->taxData ? ($data->taxData->company_name == "#" ? '' : $data->taxData->company_name) : null ?>" type="text" placeholder="<?= l('account.company_name.placeholder') ?>" />
                                        </div>
                                    </div>
                                    <div class="form-group my-account-form-group col-md-6 col-sm-12 px-md-3 px-2">
                                        <label><?= l('account.tax_id') ?></label>
                                        <div class="input_field d-flex rounded">
                                            <div class="input_icons_field m-auto d-flex rounded-start">
                                                <span class="icon-hash tx-icon grey input_icon"></span>
                                            </div>
                                            <input class="form-control w-100 input-field-control" id="taxId" name="tax_id" type="text" value="<?= $data->taxData ? ($data->taxData->tax_id == "#" ? '' : $data->taxData->tax_id) : null ?>" placeholder="<?= l('account.tax_id.placeholder') ?>" />
                                            <div class="help_icons_field m-auto d-flex rounded-start">
                                                <span class="tax-tooltip"><?= l('account.tax.tooltip') ?></span>
                                                <svg class="MuiSvgIcon-root positionSvg" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                                    <path d="M12,2A10,10,0,1,0,22,12,10,10,0,0,0,12,2Zm0,18a8,8,0,1,1,8-8A8,8,0,0,1,12,20Z"></path>
                                                    <path d="M11.17,15.17a.91.91,0,0,0-.92.92.89.89,0,0,0,.27.65.91.91,0,0,0,.65.26.92.92,0,0,0,.65-.26.93.93,0,0,0,0-1.31A.92.92,0,0,0,11.17,15.17Z"></path>
                                                    <path d="M12,7a3,3,0,0,0-2.18.76,2.5,2.5,0,0,0-.81,2h1.44a1.39,1.39,0,0,1,.41-1.07A1.61,1.61,0,0,1,12,8.27a1.6,1.6,0,0,1,1.14.4,1.48,1.48,0,0,1,.41,1.1,1.39,1.39,0,0,1-.61,1.33,3.88,3.88,0,0,1-1.88.33h-.64v2.65h1.45V12.46a3.79,3.79,0,0,0,2.35-.63,2.37,2.37,0,0,0,.79-2,2.7,2.7,0,0,0-.83-2.11A3.16,3.16,0,0,0,12,7Z"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row m-0" style="position: relative; z-index:40;">
                                    <div class="form-group my-account-form-group col-md-6 col-sm-12 px-md-3 px-2">
                                        <label><?= l('account.name') ?></label>
                                        <div class="input_field d-flex rounded">
                                            <div class="input_icons_field m-auto d-flex rounded-start">
                                                <span class="icon-profile tx-icon grey input_icon"></span>
                                            </div>
                                            <input class="form-control input-field-control" id="taxName" name="tax_name" value="<?= $data->taxData ? $data->taxData->name : null ?>" type="text" placeholder="<?= l('account.tax_name.placeholder') ?>" />
                                        </div>
                                    </div>
                                    <div class="form-group my-account-form-group col-md-6 col-sm-12 px-md-3 px-2">
                                        <label><?= l('account.surname') ?></label>
                                        <div class="input_field d-flex rounded">
                                            <div class="input_icons_field m-auto d-flex rounded-start">
                                                <span class="icon-profile tx-icon grey input_icon"></span>
                                            </div>
                                            <input class="form-control" name="tax_surname" value="<?= $data->taxData ? $data->taxData->surname : null ?>" placeholder="<?= l('account.tax_surname.placeholder') ?>" id="taxSurname" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group my-account-form-group col-lg-6 col-sm-12 px-md-3 px-2 email">
                                    <label><?= l('account.email') ?></label>
                                    <div class="input_field d-flex rounded">
                                        <div class="input_icons_field m-auto d-flex rounded-start">
                                            <span class="icon-email tx-icon grey input_icon"></span>
                                        </div>
                                        <input id="email" name="email" type="email" value="<?= $data->taxData ? $data->taxData->email : null ?>" class="form-control input-field-control <?= \Altum\Alerts::has_field_errors('email') ? 'is-invalid' : null ?>" placeholder="<?= l('account.email.placeholder') ?>" />
                                    </div>
                                </div>
                                <div class="row m-0">
                                    <div class="form-group my-account-form-group col-md-6 col-sm-12 px-md-3 px-2">
                                        <label><?= l('account.address') ?></label>
                                        <div class="input_field d-flex rounded">
                                            <div class="input_icons_field m-auto d-flex rounded-start">
                                                <span class="icon-location tx-icon grey input_icon"></span>
                                            </div>
                                            <input class="form-control input-field-control" name="address" value=" <?= $data->taxData ? (strpos($data->taxData->address, ",") != false ? $data->taxData->address : str_replace(",", "**", $data->taxData->address)) : ''; ?>" type="text" placeholder="<?= l('account.address.placeholder') ?>" id="taxAdd" />
                                        </div>
                                    </div>
                                    <div class="form-group my-account-form-group col-md-6 col-sm-12 px-md-3 px-2">
                                        <label><?= l('account.postal_code') ?></label>
                                        <div class="input_field d-flex rounded">
                                            <div class="input_icons_field m-auto d-flex rounded-start">
                                                <span class="icon-hash tx-icon grey input_icon"></span>
                                            </div>
                                            <input class="form-control input-field-control" name="postal_code" value="<?= $data->taxData ? $data->taxData->postal_code : null ?>" type="text" placeholder="<?= l('account.postal_code.placeholder') ?>" id="taxPcode" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row m-0">
                                    <div class="form-group my-account-form-group col-md-6 col-sm-12 px-md-3 px-2">
                                        <label><?= l('account.city') ?></label>
                                        <div class="input_field d-flex rounded">
                                            <div class="input_icons_field m-auto d-flex rounded-start">
                                                <span class="icon-location tx-icon grey input_icon"></span>
                                            </div>
                                            <input class="form-control input-field-control" name="city" value="<?= $data->taxData ? $data->taxData->city : null ?>" type="text" placeholder="<?= l('account.city.placeholder') ?>" id="taxCity" />
                                        </div>
                                    </div>
                                    <?php
                                    ?>

                                    <div class="form-group my-account-form-group col-md-6 col-sm-12 px-md-3 px-2 country_select">
                                        <label class="fieldLabel"><?= l('account.country') ?></label>
                                        <div class="input_field d-flex rounded">
                                            <div class="input_icons_field m-auto d-flex rounded-start">
                                                <span class="icon-global grey input_icon tx-icon"></span>
                                            </div>

                                            <select name="country" id="country" class="form-control">

                                                <option value=""><?= l('account.select_country') ?></option>
                                                <?php foreach (get_countries_array() as $key => $value) {  ?>
                                                    <option value="<?= $key ?>" <?= ($data->taxData ? ($data->taxData->country == $key) :  ($data->country == $key)) ? 'selected' : '' ?>><?= l('account.country.' . $key) ?> </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accountCardDetailBtn tax-btn-area tax-btn-area-2">
                                <button class="accountSaveButton btn-update btn rounded" id="Users_tax" type="button"><?= l('account.save_btn') ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="tab-pane fade d-none" id="trackAnalytics" role="tabpanel" aria-labelledby="trackAnalytics-tab">
                <div class="accountCardDetail track-full-wrap py-3">
                    <form id="analyticsForm">
                        <div class="container-fluid tax fullCard rounded">
                            <div class="taxCardDetailRow">
                                <div class="form-group my-account-form-group">
                                    <label for="businessButtons">Google Analytics Tracking ID</label>
                                    <div class="input_field d-flex rounded">
                                        <div class="input_icons_field tax-icon-position m-auto d-flex rounded-start">
                                            <span class="icon-hash grey input_icon"></span>
                                        </div>
                                        <input class="form-control input-field-control w-100" id="trackingId" name="trackingid" value="<?= $this->user->google_tracking_id ?>" type="text" />
                                    </div>
                                    <span class="text-danger" id="google-analytics-error"></span>
                                </div>
                                <div class="form-group m-0 my-account-form-group">
                                    <label for="businessButtons">Facebook Pixel ID</label>
                                    <div class="input_field d-flex rounded">
                                        <div class="input_icons_field tax-icon-position m-auto d-flex rounded-start">
                                            <span class="icon-hash grey input_icon"></span>
                                        </div>
                                        <input class="form-control input-field-control w-100" id="pixelId" name="pixelid" value="<?= $this->user->pixelid ?>" type="number" />
                                    </div>
                                    <span class="text-danger" id="facebook-id-error"></span>
                                </div>
                            </div>
                            <div class="accountCardDetailBtn id-update-btn-area">
                                <button class="accountSaveButton  btn btn-update rounded" id="trackingSave" type="button"><?= l('account.save') ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- </form> -->
</div>

<?php if (!$this->user->twofa_secret) : ?>
    <?php ob_start() ?>
    <script>
        'use strict';

        let twofa = () => {
            let is_enabled;
            const selectElement = document.querySelector('select[name="twofa_is_enabled"]');
            if (selectElement) {
                is_enabled = parseInt(selectElement.value);
            } else {
                is_enabled = null;
            }

            if (is_enabled) {
                document.querySelector('#twofa_container').style.display = '';
            } else {
                const twoFaContainerElement = document.querySelector('#twofa_container');
                if (twoFaContainerElement) {
                    twoFaContainerElement.style.display = 'none';
                }

            }
        };

        twofa();

        const twofaSelectElement = document.querySelector('select[name="twofa_is_enabled"]');
        if (twofaSelectElement) {
            twofaSelectElement.addEventListener('change', twofa);
        }
    </script>
    <?php \Altum\Event::add_content(ob_get_clean(), 'javascript') ?>
<?php endif ?>

<script>
    function toggleText(type) {
        if (type) {
            document.getElementById("companyLabel").innerHTML = "<?= l('account.company_name_optional') ?>";
        } else {
            document.getElementById("companyLabel").innerHTML = "<?= l('account.company_name') ?>";
        }
    }
</script>



<?php ob_start() ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>





<link href="<?= ASSETS_FULL_URL . 'css/daterangepicker.min.css' ?>" rel="stylesheet" media="screen,print">
<script src="<?= ASSETS_FULL_URL . 'js/libraries/moment.min.js' ?>"></script>
<script src="<?= ASSETS_FULL_URL . 'js/libraries/daterangepicker.min.js' ?>"></script>
<script src="<?= ASSETS_FULL_URL . 'js/libraries/moment-timezone-with-data-10-year-range.min.js' ?>"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
<script>
    $('#contactform').validate({
        rules: {
            name: {
                required: true,
            },
            email: {
                required: true,
                email: true
            },
            surname: {
                required: true
            },

            errorPlacement: function() {
                return true;
            }
        }
    });
    $('#passwordForm').validate({
        rules: {
            password: "required"
        },
        messages: {
            password: "Password is required"
        }
    });


    $('#texForm').validate({
        rules: {
            company_name: {
                required: '#comapanyRadio:checked'
            },
            tax_id: "required",
            tax_name: "required",
            tax_surname: "required",
            address: "required",
            postal_code: "required",
            city: "required",
            Tax_email: "required",

        }
    });
    $(document).on('click', '.accountSaveButton', function() {
        var buttonId = this.id;
        var spinner = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`;
        // var form = $("#accountForm")[0];
        var form = $(this).closest('form')[0];
        var formData = new FormData(form);
        formData.append('user_id', '<?php echo $this->user->user_id; ?>');
        var isValidForm = false;
        if (buttonId == 'sbmt') {
            formData.append('action', 'contactInfoData');
            isValidForm = $("#contactform").valid();

            var event = "all_click";

            <?php if (isset($this->user->user_id)) { ?>
                var data = {
                    "userId": "<?php echo $this->user->user_id ?>",
                    "clicktext": "Update Personal information"};
            <?php } ?>

            googleDataLayer(event, data);

        } else if (buttonId == 'passSave') {
            passwordConfirmation = $('#re_password').val();
            formData.append('action', 'passwordData');
            isValidForm = $("#passwordForm").valid();

            var event = "all_click";

            <?php if (isset($this->user->user_id)) { ?>
                var data = {
                    "userId": "<?php echo $this->user->user_id ?>",
                    "clicktext": "Change password" }
            <?php } ?>
            googleDataLayer(event, data);

        } else if (buttonId == 'LangSave') {
            formData.append('action', 'languagedData');
            isValidForm = true;

            var event = "all_click";
            <?php if (isset($this->user->user_id)) { ?>
                var data = {
                    "userId": "<?php echo $this->user->user_id ?>",
                    "clicktext": "Change Language"}
            <?php } ?>
            googleDataLayer(event, data);

        } else if (buttonId == 'TzoneSave') {
            formData.append('action', 'timezoneData');
            isValidForm = true;


            var event = "all_click";
            <?php if (isset($this->user->user_id)) { ?>
                var data = {
                    "userId": "<?php echo $this->user->user_id ?>",
                    "clicktext": "Change Timezone"}
            <?php } ?>
            googleDataLayer(event, data);

        } else if (buttonId == 'Users_tax') {
            formData.append('action', 'userTaxData');
            // isValidForm = $("#texForm").valid();
            isValidForm = true;
            console.log(isValidForm);

            var event = "all_click";

            <?php if (isset($this->user->user_id)) { ?>
                var data = {
                    "userId": "<?php echo $this->user->user_id ?>",
                    "clicktext": "Update Tax Information"}
            <?php } ?>
            googleDataLayer(event, data);

        } else if (buttonId == 'trackingSave') {
            formData.append('action', 'TrackingAnalyticsData');
            isValidForm = $("#analyticsForm").valid()

            var event = "all_click";
            <?php if (isset($this->user->user_id)) { ?>
                var data = {
                    "userId": "<?php echo $this->user->user_id ?>",
                    "clicktext": "Update Tracking Analytics"}
            <?php } ?>
            googleDataLayer(event, data);
        }
        var $this = $(this);

        function BtnLoading(elem) {
            $(elem).attr("data-original-text", $(elem).html());
            $(elem).prop("disabled", true);
            $(elem).html(spinner);
        }

        function BtnReset(elem) {
            $(elem).prop("disabled", false);
            $(elem).html($(elem).attr("data-original-text"));
        }
        if (isValidForm) {
            BtnLoading($this);
            $.ajax({
                type: 'POST',
                url: '<?php echo url('api/ajax') ?>',
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function(response) {
                    var res = response.data
                    if (res == "success") {
                        BtnReset($this);
                        $("#success").fadeIn().html(`<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <span>
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                          </svg>
                        </span>
                          <strong><?= l('account.alert.successfully_update') ?></strong>
                        </div>`);
                        $this.text("Update");

                        let language = $('#language').find(":selected").val();
                        if (language != '<?= \Altum\Language::$name ?>') {
                            window.location.href = '<?= SITE_URL ?>' + language + '/account';
                        } else {
                            setTimeout(function() {
                                $("#success").fadeOut();
                            }, 4000);
                        }

                    } else if (res == "failed") {
                        $("#success").fadeIn().html(`<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-circle-fill" viewBox="0 0 16 16">
                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                            </svg>
                        </span>
                        <strong><?= l('account.password_incorrect') ?></strong>
                        </div>`);
                        setTimeout(function() {
                            $("#success").fadeOut();
                        }, 4000);
                        $this.prop("disabled", false);
                        $this.text("Update");
                        if (buttonId == 'sbmt') {
                            $("#email").val('<?= $this->user->email ?>');
                            $("#email").focus();
                            console.log($("#email"));
                        }
                    } else {
                        $("#success").fadeIn().html(`<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-circle-fill" viewBox="0 0 16 16">
                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                            </svg>
                        </span>
                        <strong><?= l('register.error_message.email_exists') ?></strong>
                        </div>`);
                        setTimeout(function() {
                            $("#success").fadeOut();
                        }, 4000);
                        $this.prop("disabled", false);
                        $this.text("Update");
                        if (buttonId == 'sbmt') {
                            $("#email").val('<?= $this->user->email ?>');
                            $("#email").focus();
                            console.log($("#email"));
                        }
                    }
                    $(window).scrollTop(0);
                },
                error: () => {
                    /* Re enable submit button */
                    // submit_button.removeClass('disabled').text(text);
                },
            });
        }
    });
</script>



<script>
    // Google Analytics Tracking ID validation
    $("#trackingId").on("keyup change", function(e) {

        var gaId = $('#trackingId').val();
        var regex = /^UA-\d{4,}-\d{1,}$/;

        if (gaId) {
            if (regex.test(gaId)) {
                $('#google-analytics-error').empty("");
                $('#trackingSave').prop('disabled', false);
            } else {
                $('#google-analytics-error').text("Invalid Google Analytics ID");
                $('#trackingSave').prop('disabled', true);
            }
        } else {

            $('#google-analytics-error').empty("");
            $('#trackingSave').prop('disabled', false);
        }





    })



    // Facebook pixel id validation
    $("#pixelId").on("keyup change", function(e) {

        var pixelId = $('#pixelId').val();
        var regex = /^\d{15,16}$/;

        if (pixelId) {
            if (regex.test(pixelId)) {
                $('#facebook-id-error').empty("");
                $('#trackingSave').prop('disabled', false);
            } else {
                $('#facebook-id-error').text("Invalid Facebook Pixel ID");
                $('#trackingSave').prop('disabled', true);
            }


        } else {
            $('#facebook-id-error').empty("");
            $('#trackingSave').prop('disabled', false);
        }



    });

    function showPassword() {
        var passowrd = document.getElementById("password");
        var pw_eye_off = document.getElementById("password_eyeoff");
        var pw_eye_on = document.getElementById("password_eyeon");
        if (passowrd.type === "password") {
            passowrd.type = "text";
            pw_eye_on.style.display = "block";
            pw_eye_off.style.display = "none";
        } else {
            passowrd.type = "password";
            pw_eye_on.style.display = "none";
            pw_eye_off.style.display = "block"
        }
    }

    function showRePassword() {
        var passowrd = document.getElementById("re_password");
        var re_pw_eye_off = document.getElementById("repassword_eyeoff");
        var re_pw_eye_on = document.getElementById("repassword_eyeon");
        if (passowrd.type === "password") {
            passowrd.type = "text";
            re_pw_eye_on.style.display = "block";
            re_pw_eye_off.style.display = "none";
        } else {
            passowrd.type = "password";
            re_pw_eye_on.style.display = "none";
            re_pw_eye_off.style.display = "block";
        }
    }

    function passwordCheck() {
        let password = document.getElementById("password").value;
        console.log(password);
        let rePassword = document.getElementById("re_password").value;
        console.log(rePassword);
        let error = document.getElementById("password_error");

        if (password != null && rePassword != null) {
            if (password == rePassword) {
                document.getElementById("password_error").innerHTML = "<?= l('account.password_correct') ?>";
                document.getElementById("password_error").style.color = "green";
                console.log("Password is correct");
            } else {
                error.style.color = "red";
                document.getElementById("password_error").innerHTML = "<?= l('account.password_incorrect') ?>";
                console.log("Password is incorrect");
            }
        } else {
            error.style.color = "red";
            document.getElementById("password_error").innerHTML = "<?= l('account.password_incorrect') ?>";
            console.log("Password is incorrect");
        }
    }

    function linkChange() {
        let activeLink = document.getElementById("active_link");
        activeLink.style.border = "1px solid #dee2e6";
        let secondLink = document.getElementById("nav2");
        secondLink.style.border = "1px solid #ffff";
        let thirdLink = document.getElementById("nav3");
        thirdLink.style.border = "1px solid #dee2e6";
    }

    function borderChange() {
        let thirdLink = document.getElementById("nav3");
        thirdLink.style.border = "1px solid #ffff";
        let secondLink = document.getElementById("nav2");
        secondLink.style.border = "1px solid #dee2e6";
    }

    function linkPreviousChange() {
        let activeLink = document.getElementById("active_link");
        activeLink.style.border = "1px solid #ffff";
        let secondLink = document.getElementById("nav2");
        secondLink.style.border = "1px solid #dee2e6";
    }

    var mobile = window.matchMedia("(max-width: 990px)")
    myFunction(mobile) // Call listener function at run time
    mobile.addListener(myFunction)



    function myFunction(mobile) {

        if (mobile.matches) { // If media query matches
            var element = document.getElementById("myTab");
            element.classList.remove("border_round");
        }

    }
</script>

<script>
    function ClearPersonalInfo() {
        document.getElementById('name').value = '';
        document.getElementById('surname').value = '';
        document.getElementById('email').value = '';
        document.getElementById('telephone').value = '';
    }

    function ClearPassowrd() {
        document.getElementById('password').value = '';
        document.getElementById('re_password').value = '';
        document.getElementById("password_error").innerHTML = "";
    }


    $(document).on('click', '.accountDeleteButton', function() {

        var event = "all_click";
        <?php if (isset($this->user->user_id)) { ?>
            var data = {
                "userId": "<?php echo $this->user->user_id ?>",
                "clicktext": "Delete Account"}
        <?php } ?>
        googleDataLayer(event, data);
    });
</script>

<script>
    function ClearPersonalInfo() {
        document.getElementById('name').value = '';
        document.getElementById('surname').value = '';
        document.getElementById('email').value = '';
        document.getElementById('telephone').value = '';
    }

    function ClearPassowrd() {
        document.getElementById('password').value = '';
        document.getElementById('re_password').value = '';
        document.getElementById("password_error").innerHTML = "";
    }

    $(document).on('click', '.accountDeleteButton', function() {

        var event = "all_click";
        <?php if (isset($this->user->user_id)) { ?>
            var data = {
                "userId": "<?php echo $this->user->user_id ?>",
                "clicktext": "Delete Account"}
        <?php } ?>
        googleDataLayer(event, data);
    });

    function showPassword() {
        var passowrd = document.getElementById("password");
        var pw_eye_off = document.getElementById("password_eyeoff");
        var pw_eye_on = document.getElementById("password_eyeon");
        if (passowrd.type === "password") {
            passowrd.type = "text";
            pw_eye_on.style.display = "block";
            pw_eye_off.style.display = "none";
        } else {
            passowrd.type = "password";
            pw_eye_on.style.display = "none";
            pw_eye_off.style.display = "block"
        }
    }

    function showRePassword() {
        var passowrd = document.getElementById("re_password");
        var re_pw_eye_off = document.getElementById("repassword_eyeoff");
        var re_pw_eye_on = document.getElementById("repassword_eyeon");
        if (passowrd.type === "password") {
            passowrd.type = "text";
            re_pw_eye_on.style.display = "block";
            re_pw_eye_off.style.display = "none";
        } else {
            passowrd.type = "password";
            re_pw_eye_on.style.display = "none";
            re_pw_eye_off.style.display = "block";
        }
    }

    function passwordCheck() {
        let password = document.getElementById("password").value;
        console.log(password);
        let rePassword = document.getElementById("re_password").value;
        console.log(rePassword);
        let error = document.getElementById("password_error");

        if (password != null && rePassword != null) {
            if (password == rePassword) {
                document.getElementById("password_error").innerHTML = "Password is correct";
                document.getElementById("password_error").style.color = "green";
                console.log("Password is correct");
            } else {
                error.style.color = "red";
                document.getElementById("password_error").innerHTML = "Password is Incorrect";
                console.log("Password is incorrect");
            }
        } else {
            error.style.color = "red";
            document.getElementById("password_error").innerHTML = "Password is Incorrect";
            console.log("Password is incorrect");
        }
    }

    function linkChange() {
        let activeLink = document.getElementById("active_link");
        activeLink.style.border = "1px solid #dee2e6";
        let secondLink = document.getElementById("nav2");
        secondLink.style.border = "1px solid #ffff";
        let thirdLink = document.getElementById("nav3");
        thirdLink.style.border = "1px solid #dee2e6";
    }

    function borderChange() {
        let thirdLink = document.getElementById("nav3");
        thirdLink.style.border = "1px solid #ffff";
        let secondLink = document.getElementById("nav2");
        secondLink.style.border = "1px solid #dee2e6";
    }

    function linkPreviousChange() {
        let activeLink = document.getElementById("active_link");
        activeLink.style.border = "1px solid #ffff";
        let secondLink = document.getElementById("nav2");
        secondLink.style.border = "1px solid #dee2e6";
    }

    var mobile = window.matchMedia("(max-width: 990px)")
    myFunction(mobile) // Call listener function at run time
    mobile.addListener(myFunction)



    function myFunction(mobile) {

        if (mobile.matches) { // If media query matches
            var element = document.getElementById("myTab");
            element.classList.remove("border_round");
        }

    }
</script>

<!-- <script>
    function errorColor() {
        if ($(".form-control").hasClass("error")) {
            // console.log("True");
            var id_name = $(".error").attr('id');
            console.log("#" + id_name);
            $("#" + id_name).parent(".input_field").css('border', '1px solid red');
        } else if ($(".form-control").hasClass("valid")) {
            // console.log("False");
            var id_name = $(".error").attr('id');
            $("#" + id_name).parent(".input_field").css('border', '2px solid #eaeaec');
            // console.log("#" + id_name);
        }
    }

    setInterval(errorColor, 1000);
</script> -->

<script>
    function ClearPersonalInfo() {
        document.getElementById('name').value = '';
        document.getElementById('surname').value = '';
        document.getElementById('email').value = '';
        document.getElementById('telephone').value = '';
    }

    function ClearPassowrd() {
        document.getElementById('password').value = '';
        document.getElementById('re_password').value = '';
        document.getElementById("password_error").innerHTML = "";
    }
</script>


<?php \Altum\Event::add_content(ob_get_clean(), 'javascript') ?>