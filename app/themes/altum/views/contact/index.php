<?php defined('ALTUMCODE') || die() ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
<link href="<?= ASSETS_FULL_URL . 'css/contact-us.css?v=' . PRODUCT_CODE ?>" rel="stylesheet" media="screen,print">

<div class="container">
    <?= \Altum\Alerts::output_alerts() ?>

    <div class="contactPage">

        <div class="contactPageDetail" id="contactPageDetail" style="display:block;">
            <div class="outerheader contactPageHeading">
                <h1><?= l('contact.title') ?></h1>
                <p><?= l('contact.description') ?>
                </p>
            </div>
            <form id="contactUs">
                <input type="hidden" name="token" value="<?= \Altum\Middlewares\Csrf::get() ?>" />
                <input type="hidden" name="lang" id="curLang">

                <div class="form-group">
                    <label for="name"><?= l('contact.name') ?> *</label>
                    <input id="name" type="text" name="name" class="form-control <?= \Altum\Alerts::has_field_errors('name') ? 'is-invalid' : null ?>" value="<?= $data->values['name'] ?>" maxlength="320" />
                    <?= \Altum\Alerts::output_field_error('name') ?>
                </div>

                <div class="form-group">
                    <label for="email"><?= l('contact.email') ?> *</label>
                    <input id="email" type="email" name="email" class="form-control <?= \Altum\Alerts::has_field_errors('email') ? 'is-invalid' : null ?>" value="<?= $data->values['email'] ?>" maxlength="64" <?php if ($data->values['email']) { ?> <?php echo "readonly" ?> <?php } else { ?> <?php echo "" ?> <?php } ?> />
                    <?= \Altum\Alerts::output_field_error('email') ?>
                </div>

                <div class="form-group contact-drop-down">
                    <label for="subject"><?= l('contact.subject') ?>*</label>
                    <div class="contact-dropdwon-icon">
                        <span class="icon-arrow-down grey dropdown-icon" id="subject_drp_icon" style="cursor: pointer;"></span>
                    </div>
                    <select name="subject" id="subject" class="form-control open" value="">
                        <option value="Select"><?= l('contact.subject.select') ?></option>
                        <option value="Bugs & Technical issues"><?= l('contact.subject.select_technical') ?></option>
                        <option value="Invoice and Payment"><?= l('contact.subject.select_administrative') ?></option>
                        <option value="Feedback or Suggestions"><?= l('contact.subject.select_feedback') ?></option>
                        <option value="Other"><?= l('contact.subject.other') ?></option>
                    </select>
                    <?= \Altum\Alerts::output_field_error('subject') ?>
                </div>

                <div class="form-group">
                    <label for="message"><?= l('contact.question') ?> *</label>
                    <textarea id="message" name="message" placeholder="<?= l('contact.question.placeholder') ?>" class="form-control textarea-control<?= \Altum\Alerts::has_field_errors('message') ? 'is-invalid' : null ?>" maxlength="2048"><?= $data->values['message'] ?></textarea>
                    <?= \Altum\Alerts::output_field_error('message') ?>
                </div>


                <?php if (settings()->captcha->contact_is_enabled) : ?>
                    <div class="contactCaptcha">
                        <div class="form-group w-100 m-0">
                            <?php $data->captcha->display() ?>
                        </div>
                        <div class="recaptcha-fail">
                            <p class="recaptcha-error" id="recapError" style="color:red; display:none;"> <?= l('global.error_message.invalid_captcha') ?></p>
                        </div>
                    </div>
                <?php endif ?>

                <button type="button" id="submit" class="accountSaveButton"><?= l('contact.send_btn') ?></button>

            </form>
        </div>

        <div class="pt-4 contact-success" id="contact-success" style="display:none;">
            <img class="mx-auto d-block success-img" src="<?= ASSETS_FULL_URL . 'images/contactUs_mail_success.svg' ?>" alt="">

            <div class="message">
                <p class="fs-4 mx-auto d-block w-75 text-center pt-5 fw-bold"><?= l('contact.success.description') ?></p>
            </div>

            <a href="<? url() ?>"><button type="button" id="backBtn" class="accountSaveButton backButton my-5"><?= l('contact.close_btn') ?></button></a>
        </div>

    </div>

</div>

<style>
    select.open {
        -webkit-appearance: menulist-button;
        -moz-appearance: menulist-button;
        appearance: menulist-button;
        cursor: pointer;
    }
</style>

<script>
    $(document).ready(function() {
        var lang = document.documentElement.lang;


        $("#curLang").val(lang);
        console.log($("#curLang").val());

    });
</script>

<script>
    var body = document.body;
    body.classList.add("ContactPage");


    $(document).ready(function() {

        $("#submit").click(function(event) {

            $("#name").parent().find(".invalid_err").remove();
            $("#email").parent().find(".invalid_err").remove();
            $("#subject").parent().find(".invalid_err").remove();
            $("#message").parent().find(".invalid_err").remove();

            var name = $("#name").val();
            var email = $("#email").val();
            var message = $("#message").val();
            var subject = $("#subject").val();


            if (($("#name").val() != "") && ($("#email").val() != "") && ($("#message").val() != "") && ($("#subject").val() != "Select")) {
                event.preventDefault();
                if (grecaptcha.getResponse() != "") {

                    $("#recapError").css("display", "none");
                    // Get form
                    var form = $('#contactUs')[0];
                    var data = new FormData(form);
                    $("#submit").prop("disabled", true);

                    $.ajax({
                        type: "POST",
                        url: "<?= url('contact') ?>",
                        data: data,
                        processData: false,
                        contentType: false,
                        cache: false,
                        success: function(data) {

                            $("#submit").prop("disabled", false);
                            $("#contactPageDetail").css("display", "none");
                            $("#contact-success").css("display", "block");
                            grecaptcha.reset();

                        },
                        error: function(e) {

                            $("#output").text(e.responseText);
                            $("#submit").prop("disabled", false);

                        }
                    });

                } else {
                    $("#recapError").css("display", "block");
                }
            } else {
                if ($("#name").val() == "") {
                    $("<span class=\"invalid_err\" style=\"color:red;\"><?= l('contact.input.validate.required') ?></span>").insertAfter($("#name"))
                } else {
                    $("#name").parent().find(".invalid_err").remove();
                }

                if ($("#email").val() == "") {
                    $("<span class=\"invalid_err\" style=\"color:red;\"><?= l('contact.input.validate.required') ?></span>").insertAfter($("#email"))
                } else {
                    $("#email").parent().find(".invalid_err").remove();
                }

                if ($("#subject").val() == "Select") {
                    $("<span class=\"invalid_err\" style=\"color:red;\"><?= l('contact.input.validate.select_sub') ?></span>").insertAfter($("#subject"))
                } else {
                    $("#subject").parent().find(".invalid_err").remove();
                }

                if ($("#message").val() == "") {
                    $("<span class=\"invalid_err\" style=\"color:red;\"><?= l('contact.input.validate.required') ?></span>").insertAfter($("#message"))
                } else {
                    $("#message").parent().find(".invalid_err").remove();
                }
            }

        });

    });

    $(document).on('click', '.accountSaveButton', function() {

        var event = "cta_click";

        var data = {
            "userId": "<?php echo $this->user->user_id ?>",
            "clicktext": "Save Contact"}
        googleDataLayer(event, data);
    });
</script>
<style>
    .ContactPage .main-content {
        height: auto;
    }
</style>