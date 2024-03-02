<?php defined('ALTUMCODE') || die() ?>

<nav aria-label="breadcrumb">
    <ol class="custom-breadcrumbs small">
        <li>
            <a href="<?= url('admin/languages') ?>"><?= l('admin_languages.breadcrumb') ?></a><i class="fa fa-fw fa-angle-right"></i>
        </li>
        <li class="active" aria-current="page"><?= l('admin_language_update.breadcrumb') ?></li>
    </ol>
</nav>

<div class="d-flex justify-content-between mb-4">
    <h1 class="h3 mb-0 text-truncate"><i class="fa fa-fw fa-xs fa-language text-primary-900 mr-2"></i> <?= l('admin_language_update.header') ?></h1>

    <?= include_view(THEME_PATH . 'views/admin/languages/admin_language_dropdown_button.php', ['id' => $data->language['name']]) ?>
</div>

<?= \Altum\Alerts::output_alerts() ?>

<div class="alert alert-info" role="alert">
    <?php
    $total_translated = 0;
    $total = 0;
    foreach (\Altum\Language::$languages[\Altum\Language::$main_name]['content'] as $key => $value) {
        if (!empty(\Altum\Language::$languages[$data->language['name']]['content'][$key])) $total_translated++;
        $total++;
    }
    ?>
    <?= sprintf(l('admin_languages.info_message.total'), $total_translated, $total) ?>
</div>




<div class="card <?= \Altum\Alerts::has_field_errors() ? 'border-danger' : null ?>">
    <div class="card-body">

        <form action="" method="post" role="form">
            <input type="hidden" name="token" value="<?= \Altum\Middlewares\Csrf::get() ?>" />

            <div class="form-group">
                <label for="language_name"><?= l('admin_languages.main.language_name') ?></label>
                <input id="language_name" type="text" name="language_name" class="form-control form-control-lg <?= \Altum\Alerts::has_field_errors('language_name') ? 'is-invalid' : null ?>" value="<?= $data->language['name'] ?>" <?= $data->language['name'] == \Altum\Language::$main_name ? 'readonly="readonly"' : null ?> required="required" />
                <?= \Altum\Alerts::output_field_error('language_name') ?>
                <small class="form-text text-muted"><?= l('admin_languages.main.language_name_help') ?></small>
            </div>

            <div class="form-group">
                <label for="language_code"><?= l('admin_languages.main.language_code') ?></label>
                <input id="language_code" type="text" name="language_code" class="form-control form-control-lg <?= \Altum\Alerts::has_field_errors('language_code') ? 'is-invalid' : null ?>" value="<?= $data->language['code'] ?>" <?= $data->language['name'] == \Altum\Language::$main_name ? 'readonly="readonly"' : null ?> required="required" />
                <?= \Altum\Alerts::output_field_error('language_code') ?>
                <small class="form-text text-muted"><?= l('admin_languages.main.language_code_help') ?></small>
            </div>

            <div class="form-group">
                <label for="status"><?= l('admin_languages.main.status') ?></label>
                <select id="status" name="status" class="form-control form-control-lg">
                    <option value="active" <?= $data->language['status'] == 'active' ? 'selected="selected"' : null ?>><?= l('global.active') ?></option>
                    <option value="disabled" <?= $data->language['status'] == 'disabled' ? 'selected="selected"' : null ?>><?= l('global.disabled') ?></option>
                </select>
            </div>

            <div class="form-group">
                <label for="status"><?= l('admin_languages.main.page') ?></label>
                <select id="status" name="status" class="form-control form-control-lg">
                    <option value="analytics">analytics</option>
                    <option value="account">account</option>
                    <option value="contact">contact</option>
                    <option value="billing">billing</option>
                    <option value="faq">faq</option>
                    <option value="home">home</option>
                    <option value="footer">home - footer</option>
                    <option value="pay">pay</option>
                    <option value="pay_billing">pay-billing</option>
                    <option value="billing_com_summary">billing - Component - Summary</option>
                    <option value="privacy_policy">privacy-policy</option>
                    <option value="plans_and_prices">plans-and-prices</option>
                    <option value="plan_cards">plan cards</option>
                    <option value="plan_questions">plan questions</option>
                    <option value="qr_general">qr - General</option>
                    <option value="qr_step_1">qr - Step 1</option>
                    <option value="qr_step_2">qr - Step 2</option>
                    <option value="qr_step_2_com_contact_info">qr - Step 2 - Component - Contact Information</option>
                    <option value="qr_step_2_com_colorPalette">qr - Step 2 - Component - Design</option>
                    <option value="qr_step_2_com_fonts">qr - Step 2 - Component - Fonts</option>
                    <option value="qr_step_2_com_location">qr - Step 2 - Component - Location</option>
                    <option value="qr_step_2_com_opening_hours">qr - Step 2 - Component - Opening Hours</option>
                    <option value="qr_step_2_com_password">qr - Step 2 - Component - Password</option>
                    <option value="qr_step_2_com_qr_name">qr - Step 2 - Component - Name of the QR Code</option>
                    <option value="qr_step_2_com_social_icon">qr - Step 2 - Component - Social Networks</option>
                    <option value="qr_step_2_com_welcome_screen">qr - Step 2 - Component - Welcome Screen</option>
                    <option value="qr_step_2_com_folder">qr - Step 2 - Component - Folder</option>
                    <option value="qr_step_2_website">qr - Step 2 - Website</option>
                    <option value="qr_step_2_pdf">qr - Step 2 - PDF</option>
                    <option value="qr_step_2_images">qr - Step 2 - Images</option>
                    <option value="qr_step_2_video">qr - Step 2 - Video</option>
                    <option value="qr_step_2_wifi">qr - Step 2 - Wifi</option>
                    <option value="qr_step_2_menu">qr - Step 2 - Menu</option>
                    <option value="qr_step_2_business">qr - Step 2 - Business</option>
                    <option value="qr_step_2_vcard">qr - Step 2 - Vcard</option>
                    <option value="qr_step_2_mp3">qr - Step 2 - Mp3</option>
                    <option value="qr_step_2_apps">qr - Step 2 - Apps</option>
                    <option value="qr_step_2_links">qr - Step 2 - Links</option>
                    <option value="qr_step_2_coupon">qr - Step 2 - Coupon</option>
                    <option value="qr_step_3">qr - Step 3</option>
                    <option value="qr_codes">qr-codes</option>
                    <option value="qr_code">qr-code</option>
                    <option value="login">login</option>
                    <option value="lost_password">lost-password</option>
                    <option value="register">register</option>
                    <option value="register_nsf">register NSF</option>
                    <option value="register_dpf">register DPF</option>
                    <option value="plan_dpf">plan-DPF</option>
                    <option value="pay_dpf">pay-DPF</option>
                    <option value="terms_conditions">terms-and-conditions</option>
                    <option value="upgrade_checkout">upgrade-checkout</option>
                    <option value="resubscribe_checkout">resubscribe-checkout</option>
                    <option value="public_plan">public-plan</option>
                    <option value="private_plan">private-plan</option>
                    <option value="qr_download">qr download</option>
                    <option value="qr_share_popup">Custom QR Share Popup</option>
                    <option value="upgrade_popup">Upgrade Popup</option>
                    <option value="notfound">404 page not found</option>
                    <option value="emails_account_create">emails - account_create</option>
                    <option value="emails_declined_payment">emails - declined_payment</option>
                    <option value="emails_subscription_changed">emails - subscription_changed</option>
                    <option value="emails_password_changed">emails - password_changed</option>
                    <option value="emails_reactivate_qr_code">emails - reactivate_qr_code</option>
                    <option value="emails_reset_password">emails - reset_password</option>
                    <option value="emails_subscriptions_canceled">emails - subscriptions_canceled</option>
                    <option value="emails_subscriptions_confirmed">emails - emails_subscriptions_confirmed</option>
                    <option value="emails_trial_end">emails - trial_end</option>
                    <option value="emails_qr_download">emails - qr download</option>
                    <option value="emails_verification_code">emails - verification code</option>
                    <option value="emails_change">emails - Change email</option>
                    <option value="emails_share">emails - QR Share</option>
                    <option value="emails_promo">emails - 70% Promotion</option>
                    <option value="emails_qr_download_reminder">emails - QR download reminder</option>
                    <option value="emails_scan_and_track_qr">emails - Scan and track QR</option>
                    <option value="emails_print_qr">emails - Print QR</option>
                    <option value="emails_trial_expire_1day_reminder">emails - Trial expire 1 day reminder</option>
                    <option value="emails_dpf">emails - Welcome DPF</option>
                    <option value="emails_dpf_14_day_plan_reminder">emails - DPF - plan expire 1 Day reminder (14 days plan)</option>
                    <option value="emails_dpf_14_day_plan_end">emails - DPF - plan end (14 days plan)</option>
                    <option value="emails_dpf_one_hour">emails - DPF - one hour</option>
                    <option value="emails_dpf_qr_download">emails - DPF - Download QR code </option>
                    <option value="all">all</option>
                </select>
            </div>

            <div class="d-flex align-items-center my-5">
                <div class="flex-fill">
                    <hr class="border-gray-200">
                </div>

                <div class="ml-3">
                    <select id="display" name="display" class="form-control" aria-label="<?= l('admin_languages.main.display') ?>">
                        <option value="all"><?= l('admin_languages.main.display_all') ?></option>
                        <option value="translated"><?= l('admin_languages.main.display_translated') ?></option>
                        <option value="not_translated"><?= l('admin_languages.main.display_not_translated') ?></option>
                    </select>
                </div>
            </div>

            <div id="translations">
                <?php $index = 1; ?>
                <?php foreach (\Altum\Language::$languages[\Altum\Language::$main_name]['content'] as $key => $value) : ?>
                    <?php $form_key = str_replace('.', '##', $key) ?>
                    <?php $page_key = explode('.', $key) ?>

                    <?php if ($key == 'direction') : ?>
                        <div class="row language" data-key="<?= $page_key[0] ?>">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="<?= \Altum\Language::$main_name . '_' . $form_key ?>"><?= $key ?></label>
                                    <input id="<?= \Altum\Language::$main_name . '_' . $form_key ?>" value="<?= $value ?>" class="form-control form-control-lg" readonly="readonly" />
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label for="<?= $form_key ?>">&nbsp;</label>
                                    <select id="<?= $form_key ?>" name="<?= $form_key ?>" class="form-control form-control-lg <?= \Altum\Alerts::has_field_errors($form_key) ? 'is-invalid' : null ?> <?= !isset(\Altum\Language::get($data->language['name'])[$key]) || (isset(\Altum\Language::get($data->language['name'])[$key]) && empty(\Altum\Language::get($data->language['name'])[$key])) ? 'border-danger' : null ?>">
                                        <option value="ltr" <?= (\Altum\Language::get($data->language['name'])[$key] ?? null) == 'ltr' ? 'selected="selected"' : null ?>>ltr</option>
                                        <option value="rtl" <?= (\Altum\Language::get($data->language['name'])[$key] ?? null) == 'rtl' ? 'selected="selected"' : null ?>>rtl</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    <?php else : ?>
                        <div class="row language d-none" data-display-container data-key="<?= $page_key[0] ?>">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="<?= \Altum\Language::$main_name . '_' . $form_key ?>"><?= $key ?></label>
                                    <textarea id="<?= \Altum\Language::$main_name . '_' . $form_key ?>" class="form-control form-control-lg" readonly="readonly"><?= $value ?></textarea>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label for="<?= $form_key ?>">&nbsp;</label>
                                    <textarea data-display-input id="<?= $form_key ?>" name="<?= $form_key ?>" class="form-control form-control-lg <?= \Altum\Alerts::has_field_errors($form_key) ? 'is-invalid' : null ?> <?= !isset(\Altum\Language::get($data->language['name'])[$key]) || (isset(\Altum\Language::get($data->language['name'])[$key]) && empty(\Altum\Language::get($data->language['name'])[$key])) ? 'border-danger' : null ?>"><?= \Altum\Language::get($data->language['name'])[$key] ?? null ?></textarea>
                                </div>
                            </div>
                        </div>
                    <?php endif ?>
                <?php endforeach ?>
            </div>

            <button type="submit" name="submit" class="btn btn-lg btn-block btn-primary mt-4"><?= l('global.update') ?></button>
        </form>

    </div>
</div>

<?php ob_start() ?>
<script>
    $(document).ready(function() {

        document.querySelectorAll('#translations [data-key]').forEach(element => {
            if ($(element).data("key") != '' && $(element).data("key") == "analytics") {
                $(element).removeClass('d-none');
            } else {
                $(element).addClass('d-none');
            }

        });


    });

    let display_handler = () => {
        let display_element = document.querySelector('#display');
        let display = display_element.value;

        switch (display) {
            case 'all':

                document.querySelectorAll('#translations [data-display-container]').forEach(element => {
                    element.classList.remove('d-none');
                });

                break;

            case 'translated':

                document.querySelectorAll('#translations [data-display-input]').forEach(element => {
                    if (element.value.trim() != '') {
                        element.closest('[data-display-container]').classList.remove('d-none');
                    } else {
                        element.closest('[data-display-container]').classList.add('d-none');
                    }
                });

                break;

            case 'not_translated':

                document.querySelectorAll('#translations [data-display-input]').forEach(element => {
                    if (element.value.trim() != '') {
                        element.closest('[data-display-container]').classList.add('d-none');
                    } else {
                        element.closest('[data-display-container]').classList.remove('d-none');
                    }
                });

                break;
        }
    }

    document.querySelector('#display').addEventListener('change', display_handler);
</script>

<script>
    $("select[name='status']").change(function() {
        var status = this.value;

        switch (status) {
            case 'all':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    $(element).removeClass('d-none');
                });
                break;
            case 'qr_codes':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "qr_codes") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'qr_code':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "qr_code") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'home':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "home") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'footer':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "footer") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'analytics':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "analytics") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'account':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "account") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'billing':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "billing") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'contact':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "contact") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'contact':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "contact") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'faq':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "faq") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'login':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "login") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'register':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "register") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'register_nsf':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "register_nsf") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'plan_dpf':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "plan_dpf") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'pay_dpf':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "pay_dpf") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'plans_and_prices':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "plans_and_prices") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'plan_cards':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "plan_cards") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'plan_questions':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "plan_questions") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'pay':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "pay") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'pay_billing':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "pay_billing") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'billing_com_summary':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "billing_com_summary") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'terms_conditions':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "terms_conditions") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'privacy_policy':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "privacy_policy") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'lost_password':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "lost_password") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'upgrade_checkout':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "upgrade_checkout") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'resubscribe_checkout':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "resubscribe_checkout") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'public_plan':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "public_plan") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'private_plan':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "private_plan") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'qr_download':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "qr_download") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'qr_share_popup':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "qr_share_popup") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'upgrade_popup':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "upgrade_popup") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'notfound':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "notfound") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'emails_account_create':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "emails_account_create") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'emails_declined_payment':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "emails_declined_payment") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'emails_subscription_changed':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "emails_subscription_changed") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'emails_password_changed':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "emails_password_changed") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'emails_reactivate_qr_code':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "emails_reactivate_qr_code") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'emails_reset_password':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "emails_reset_password") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'emails_subscriptions_canceled':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "emails_subscriptions_canceled") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'emails_subscriptions_confirmed':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "emails_subscriptions_confirmed") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'emails_trial_end':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "emails_trial_end") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'emails_qr_download':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "emails_qr_download") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'emails_verification_code':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "emails_verification_code") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'emails_change':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "emails_change") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'emails_share':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "emails_share") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'emails_promo':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "emails_promo") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'emails_qr_download_reminder':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "emails_qr_download_reminder") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'emails_scan_and_track_qr':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "emails_scan_and_track_qr") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'emails_print_qr':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "emails_print_qr") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'emails_trial_expire_1day_reminder':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "emails_trial_expire_1day_reminder") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'emails_dpf':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "emails_dpf") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'emails_dpf_14_day_plan_reminder':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "emails_dpf_14_day_plan_reminder") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'emails_dpf_14_day_plan_end':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "emails_dpf_14_day_plan_end") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'emails_dpf_one_hour':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "emails_dpf_one_hour") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'emails_dpf_qr_download':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "emails_dpf_qr_download") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'qr_general':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "qr_general") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'qr_step_1':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "qr_step_1") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'qr_step_2':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "qr_step_2") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'qr_step_2_com_contact_info':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "qr_step_2_com_contact_info") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'qr_step_2_com_colorPalette':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "qr_step_2_com_colorPalette") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'qr_step_2_com_fonts':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "qr_step_2_com_fonts") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'qr_step_2_com_location':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "qr_step_2_com_location") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'qr_step_2_com_opening_hours':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "qr_step_2_com_opening_hours") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'qr_step_2_com_password':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "qr_step_2_com_password") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'qr_step_2_com_qr_name':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "qr_step_2_com_qr_name") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'qr_step_2_com_social_icon':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "qr_step_2_com_social_icon") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'qr_step_2_com_social_icon':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "qr_step_2_com_social_icon") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'qr_step_2_com_welcome_screen':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "qr_step_2_com_welcome_screen") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'qr_step_2_com_folder':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "qr_step_2_com_folder") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'qr_step_2_website':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "qr_step_2_website") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'qr_step_2_pdf':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "qr_step_2_pdf") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'qr_step_2_images':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "qr_step_2_images") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'qr_step_2_video':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "qr_step_2_video") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'qr_step_2_wifi':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "qr_step_2_wifi") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'qr_step_2_menu':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "qr_step_2_menu") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'qr_step_2_business':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "qr_step_2_business") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'qr_step_2_vcard':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "qr_step_2_vcard") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'qr_step_2_mp3':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "qr_step_2_mp3") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'qr_step_2_apps':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "qr_step_2_apps") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'qr_step_2_links':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "qr_step_2_links") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'qr_step_2_coupon':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "qr_step_2_coupon") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
            case 'qr_step_3':
                document.querySelectorAll('#translations [data-key]').forEach(element => {
                    if ($(element).data("key") != '' && $(element).data("key") == "qr_step_3") {
                        $(element).removeClass('d-none');
                    } else {
                        $(element).addClass('d-none');
                    }

                });
                break;
        }

    });
</script>

<?php \Altum\Event::add_content(ob_get_clean(), 'javascript') ?>

<?php \Altum\Event::add_content(include_view(THEME_PATH . 'views/partials/universal_delete_modal_url.php', [
    'name' => 'language',
    'resource_id' => 'language_name',
    'has_dynamic_resource_name' => true,
    'path' => 'admin/languages/delete/'
]), 'modals'); ?>