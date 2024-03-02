<?php defined('ALTUMCODE') || die() ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
<?= \Altum\Alerts::output_alerts() ?>


<?php

$redirect_route = null;

if (isset($_GET['redirect'])) {
    $redirect = $_GET['redirect'];
    $redirect_route = $_GET['redirect'];
} else {
    $redirect = 'qr-codes';
}

if (isset($_GET['promo_code']) && isset($_GET['referral_key'])) {
    $redirect_route = 'plans-and-prices?promo_code=' . $_GET['promo_code'] . '&referral_key=' . $_GET['referral_key'];
} else if (isset($_GET['plan_type']) && isset($_GET['referral_key'])) {
    if ($_GET['plan_type'] == 'default') {
        $redirect_route = 'plan';
    } else {
        $redirect_route = 'plan?type=' . $_GET['plan_type'] . '&referral_key=' . $_GET['referral_key'];
    }
}

setcookie('qr_code_id', '', time() - 7200, COOKIE_PATH);
setcookie('qr_uid', '', time() - 7200, COOKIE_PATH);
setcookie('nsf_qr_id', '', time() - 7200, COOKIE_PATH);
setcookie('nsf_user_id', '', time() - 7200, COOKIE_PATH);


?>

<style>
    .wrapper {
        text-align: center;
    }

    .wrapper>div {
        display: inline-block;
        position: relative;

    }

    .wrapper>div>p {
        text-align: left;
        margin-bottom: 6px;
        opacity: 0.65;
        font-size: 17px;
        font-weight: 500;
    }

    .btn {
        outline: 0;
        text-align: center;
        font-size: 20px;
        /* border-radius: 32px; */
        text-decoration: none;
        min-width: unset !important;

    }

    .continue-verify-btn {
        width: calc(100% - 240px);
        /* font-size: 23px; */
        display: block;
        margin: 30px auto 0;
        color: #ffffff;

    }

    .qr-fill-btn {
        background-image: linear-gradient(133deg, #28c254, #25b567);
        border: 0;
        color: white;
        padding: 12px 16px;
    }

    .qr-fill-btn:hover {
        background-image: linear-gradient(133deg, #25b567, #28c254);
        color: #ffffff;
    }

    .verification-inputs {
        gap: 22px;
        justify-content: center;
        margin: 0;
    }

    .verification-timer {
        justify-content: flex-end;

    }

    .verification-inputs input {
        height: 100px;
        padding: 0px;
        max-width: 80px;
        text-align: center;
        font-size: 32px;
        border: 1px solid rgba(40, 194, 84, 0.2);
        background-color: #ffffff;
        box-shadow: 0 0 4px 0 rgba(97, 97, 97, 0.06);
        border-radius: 4px;
    }

    .verification-inputs.error input {
        box-shadow: 0 0 4px 0 rgba(254, 66, 86, 0.6);
        border: 1px solid rgba(254, 66, 86, 1);
    }

    .verification-inputs.success input {
        box-shadow: 0 0 4px 0 rgba(40, 194, 84, 0.6);
        border: 1px solid rgba(40, 194, 84, 1);
    }

    .resend-timer {
        opacity: 0.5;
        padding-top: 8px;
        display: flex;
        align-items: center;
        font-size: 14px;
    }

    .resend-timer span.resend-text {
        margin-right: 4px;
    }

    .resend-button {
        font-size: 14px;
        margin-top: 8px;
        color: #25b567;
    }

    #verifyLoginModal .modal-dialog-centered {
        display: flex;
        justify-content: center;
    }

    #error_verify_code {
        text-align: left;
        line-height: 1.25;
        font-size: 14px;
        bottom: 2px;
        left: 0;
        position: absolute;
        font-size: 14px;
    }

    @media only screen and (max-width: 439.5px) {
        #error_verify_code {
            bottom: -15px;
            width: 140px;
        }
    }

    @media only screen and (max-width: 767.5px) {
        #verifyLoginModal .modal-content {
            width: calc(100% - 20px);
        }

        .verification-inputs input {
            height: 92px;
        }

        @media only screen and (max-width: 639.5px) {
            .verification-inputs input {
                height: 82px;
                font-size: 30px;
            }

            .verification-inputs {
                gap: 16px;
            }

            .continue-verify-btn {
                width: calc(100% - 120px);
            }

            @media only screen and (max-width: 575.5px) {
                .text-content-wrp {
                    padding-left: 0;
                    padding-right: 0;
                }

                .wrapper>div {
                    width: 100%;
                }
            }



            @media only screen and (max-width: 508.5px) {
                .verification-inputs {
                    gap: 8px;
                }

                .continue-verify-btn {
                    width: calc(100% - 80px);
                }

                @media only screen and (max-width: 375.5px) {

                    .continue-verify-btn {
                        width: calc(100% - 0px);
                    }

                    .verification-inputs input {
                        height: 50px;
                    }

                    #error_verify_code {
                        bottom: -15px;
                        width: 130px;
                    }

                }

            }
        }

    }

    .ready-Use-Modal .modal-content .modal-header .btn-close {
        position: absolute;
        right: 15px;
        top: 15px;
        background: #fff;
        border-radius: 20px;
        font-size: 16px;
        color: #767c83;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 1;
    }

    .ready-Use-Modal .modal-content {
        position: relative;
    }

    .buttonload {
        background-color: #04AA6D;
        /* Green background */
        border: none;
        /* Remove borders */
        color: white;
        /* White text */
        padding: 12px 24px;
        /* Some padding */
        font-size: 16px;
        /* Set a font-size */
    }

    /* Add a right margin to each icon */
    .fa {
        margin-left: -12px;
        margin-right: 8px;
    }

    .-logo-wrapper {
        position: relative;
    }

    .-logo-wrapper::before {
        background-repeat: no-repeat;
        content: "";
        position: absolute;
        background-image: url('<?= ASSETS_FULL_URL . 'images/corners-r.png' ?>');
        bottom: 37px;
        height: 50px;
        width: 32px;
        right: -38px;
    }

    .-logo-wrapper::after {
        background-repeat: no-repeat;
        content: "";
        position: absolute;
        background-image: url('<?= ASSETS_FULL_URL . 'images/corners-l.png' ?>');
        bottom: 37px;
        height: 50px;
        width: 32px;
        left: -41px;
    }

    @media only screen and (max-width: 1199.5px) {
        .-logo-wrapper::after {
            bottom: 51px;
            height: 36px;
            width: 30px;
            left: -42px;
            background-position-y: bottom;
        }

        .-logo-wrapper::before {
            bottom: 51px;
            height: 34px;
            width: 32px;
            right: -39px;
            background-position-y: bottom;
        }

        .section-login-signup .-container {
            margin-top: 100px;
        }

        @media only screen and (max-width: 899.5px) {
            .-logo-wrapper::after {
                bottom: 31px;
                height: 20px;
                width: 30px;
                left: -31px;
                background-position-y: bottom;
            }

            .-logo-wrapper::before {
                bottom: 31px;
                height: 17px;
                width: 32px;
                right: -28px;
                background-position-y: bottom;
            }
        }
    }
</style>

<div class="section-login-signup">

    <div class="-container">

        <div class="-main-cols">

            <div class="-col-slogan">
                <img src="<?= ASSETS_FULL_URL . 'images/qr-cards.svg' ?>" alt="">
                <div class="-slogan-message">
                    <?= l('login.description') ?> Online QR Generator
                </div>
            </div>
            <?php isset($_GET['promo']) ?>

            <div class="-col-form">
                <div class="-logo-wrapper-shadow"></div>
                <div class="-logo-wrapper">
                    <img src="<?= ASSETS_FULL_URL . 'images/OQG_Brand_Logo.png' ?>" alt="Online QR Generator" class="-logo">
                </div>
                <form action="<?php echo SITE_URL; ?>login?redirect=<?= $redirect ?><?php if (isset($_GET['promo'])) : ?>&promo=<?= $_GET['promo'] ?> <?php endif ?>" method="post" role="form" id="loginForm" autocomplete="off">

                    <div class="-form-title">
                        <?= l('login.form.title') ?>
                    </div>
                    <div class="-form-subtitle">
                        <?= l('login.form.description') ?>
                    </div>
                    <div class="-form-group -email">
                        <div>
                            <label for="input-email"><?= l('login.form.email') ?></label>
                        </div>
                        <div class="-form-input-wrapper">
                            <img src="<?= ASSETS_FULL_URL . 'images/Message.svg' ?>" class="-input-icon">
                            <div class="-divider"></div>
                            <input id="input-email" name="email" autocomplete="false" onfocus="this.removeAttribute('readonly');" placeholder="<?= l('login.form.email.placeholder') ?>" class="loginEmail" value="<?= $data->values['email'] ?>" autofocus="autofocus" autocomplete="off" />


                        </div>
                        <span id="log_email_err" style="color:red;"></span>
                    </div>
                    <div class="-form-group -password d-none">
                        <div>
                            <label for="input-password"><?= l('login.form.password') ?></label>
                        </div>
                        <div class="-form-input-wrapper">
                            <img src="<?= ASSETS_FULL_URL . 'images/Lock.svg' ?>" class="-input-icon">
                            <div class="-divider"></div>
                            <input id="input-password" readonly autocomplete="false" onfocus="this.removeAttribute('readonly');" type="password" placeholder="<?= l('login.form.password.placeholder') ?>" name="password" class="loginPass" value="<?= $data->user ? $data->values['password'] : null ?>" autocomplete="off" />



                            <button type="button" class="-reveal-password" data-target="#input-password">
                                <img id="eyeOff" class="" src="<?= ASSETS_FULL_URL . 'images/Eye Off.svg' ?>">
                                <img id="eyeOn" class="d-none" src="<?= ASSETS_FULL_URL . 'images/Eye On.svg' ?>">
                            </button>
                        </div>
                        <!-- <span id="log_pass_err" style="color:red;"></span> -->
                    </div>
                    <input type="hidden" name="valid_verify_code" class="valid_verify_code" />

                    <?php if (settings()->captcha->login_is_enabled) : ?>
                        <div class="form-group">
                            <?php $data->captcha->display() ?>
                        </div>
                    <?php endif ?>

                    <div class="form-group" id="error_log" style="color:red;"></div>

                    <div class="-form-group -remember-me-forgot-password d-none">
                        <label>
                            <input type="checkbox" name="rememberme" id="rememberme" <?= $data->values['rememberme'] ? 'checked="checked"' : null ?>>
                            <?= l('login.form.remember_me') ?>
                        </label>
                        <a href="lost-password" class="-link-forgot-password">
                            <?= l('login.form.forgot') ?>
                        </a>
                    </div>
                    <button type="button" id="login-btn" class="-btn-submit login-btn" onclick="submitForm()">
                        <i class="fa fa-circle-o-notch fa-spin loading-icon d-none"></i>
                        <span class="login-text"><?= l('login.form.login_btn') ?></span>
                        <div class="default-spinner login-spinner"></div>
                    </button>
                    <div class="-or-divider">
                        <div class="-divider"></div>
                        <div class="-or">
                            <?= l('login.form.or') ?>
                        </div>
                        <div class="-divider"></div>
                    </div>
                    <a href="<?= url('login/google-initiate') ?><?= isset($_GET['redirect']) ? '?redirect=' . $_GET['redirect'] : '' ?><?= isset($_GET['promo']) ? '&promo=' . $_GET['promo'] : '' ?>" class="-google-auth">
                        <img src="<?= ASSETS_FULL_URL . 'images/logo-google.svg' ?>">
                        <?= l('login.form.google_login') ?>
                    </a>
                    <div class="-no-account">
                        <?= l('login.form.footer_1') ?>
                        <!-- Don't have an account? -->
                        <a href="<?= url('register') ?><?= isset($_GET['redirect']) ? '?redirect=' . $_GET['redirect'] : '' ?><?= isset($_GET['promo']) ? '&promo=' . $_GET['promo'] : '' ?>" class="-link-create-account">
                            <!-- Create an account -->
                            <?= l('login.form.footer_2') ?>
                        </a>
                    </div>
                </form>
            </div>

        </div>

    </div>

</div>


<!--Verification code  Modal -->
<div class="modal new-dl-modal fade ready-Use-Modal show" id="verifyLoginModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-export">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title text-center w-100" id="staticBackdropLabel"><?= l('login.verification_modal.title') ?></h2>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span class="icon-failed"></span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <p class="text-center" id="modal-subtitle"></p>
                    <div class="col-md-12 col-12 text-content-wrp">
                        <form action="<?php echo SITE_URL; ?>login?redirect=<?= $redirect ?><?php if (isset($_GET['promo'])) : ?>&promo=<?= $_GET['promo'] ?> <?php endif ?>" method="post" role="form" id="verifyForm">

                            <input type="hidden" id="user_email" name="email" value="" />
                            <input id="input-verify_code" type="hidden" name="verify_code" class="verify_code" value="" />
                            <input type="hidden" name="valid_verify_code" class="valid_verify_code" />

                            <div class="wrapper">
                                <div class="col-auto">

                                    <p class="text-center modal-title-intro mb-4"></p>
                                    <p><?= l('login.verification_modal.sub_title_2') ?> </p>
                                    <div id="verification-code-inputs" class="row verification-inputs">
                                        <input type="number" id="first" class="verification-input col" maxlength="1" pattern="\d*" onKeyPress="if(this.value.length==1) return false;">
                                        <input type="number" class="verification-input col" maxlength="1" pattern="\d*" onKeyPress="if(this.value.length==1) return false;">
                                        <input type="number" class="verification-input col" maxlength="1" pattern="\d*" onKeyPress="if(this.value.length==1) return false;">
                                        <input type="number" class="verification-input col" maxlength="1" pattern="\d*" onKeyPress="if(this.value.length==1) return false;">
                                        <input type="number" class="verification-input col" maxlength="1" pattern="\d*" onKeyPress="if(this.value.length==1) return false;">
                                        <input type="number" class="verification-input col" maxlength="1" pattern="\d*" onKeyPress="if(this.value.length==1) return false;">
                                    </div>
                                    <span style="color:red;" id="error_verify_code"></span>
                                    <div id="" class="col-12 ms-auto me-0 verification-timer d-flex">
                                        <button type="button" class="resend-button" id="resend-code"><?= l('login.verification_modal.resend_code') ?></button>
                                        <div class="resend-timer"><span class="resend-text"><?= l('login.verification_modal.resend_code') ?></span><span>(</span>
                                            <div id="timer"></div><span><?= l('login.verification_modal.sec') ?>)</span>
                                        </div>
                                    </div>

                                </div>
                                <button type="button" class="btn qr-fill-btn continue-verify-btn" onclick="submitFormVerifyCode()" id="verify-code">
                                    <i class="fa fa-circle-o-notch fa-spin verify-loading-icon d-none"></i>
                                    <span class="verify-btn-text"><?= l('login.verification_modal.verify_code') ?></span>
                                    <div class="default-spinner verify-spinner"></div>
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="col-md-12 img-content-wrp d-flex justify-content-center">
                        <img src="<?= ASSETS_FULL_URL . 'images/mail-sent-rafiki.png' ?>" class="img-fluid" alt="" width="" height="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--  -->


<?php ob_start() ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.11/clipboard.min.js"></script>


<script>
    var myForm = document.getElementById("loginForm");
    var verifyForm = document.getElementById("verifyForm");
    var timerSeconds = 30; // Timer duration in seconds
    var timerInterval; // Interval ID for the timer
    const codeFields = document.querySelectorAll('.verification-input');
    var verify_code = $(".verify_code").val();

    $(function() {
        $('form').each(function() {
            $(this).find('input').keypress(function(e) {
                if (!$(this).hasClass('verification-input')) {
                    if (e.which == 10 || e.which == 13) {
                        submitForm()
                    }
                }

            });
        });
    });
    // Paste

    function startTimer() {
        var totalSeconds = timerSeconds;
        updateTimerDisplay(totalSeconds);
        $('#resend-code').hide();
        clearInterval(timerInterval);
        timerInterval = setInterval(function() {

            totalSeconds--;
            updateTimerDisplay(totalSeconds);

            if (totalSeconds <= 0) {
                clearInterval(timerInterval);
                $('#resend-code').show();
                $('.resend-timer').hide();
            }
        }, 1000);
    }


    function updateTimerDisplay(seconds) {
        var remainingSeconds = seconds % 60;
        var timerDisplay = remainingSeconds.toString().padStart(2, '0');
        $('#timer').text(timerDisplay);
    }

    codeFields.forEach((field, index) => {
        field.addEventListener('keydown', (event) => {
            if (event.key === 'Delete') {
                event.preventDefault();
                field.value = '';
                if (index > 0) {
                    codeFields[index - 1].focus();
                }
            }
        });
        field.addEventListener('keyup', (event) => {
            if (event.key === 'Backspace') {
                field.value = '';
                if (index > 0) {
                    codeFields[index - 1].focus();
                }
            }
        });
    });

    codeFields.forEach(input => {
        input.addEventListener('input', handleInputEvent);
        input.addEventListener('paste', handlePasteEvent); // Add the paste event listener
        // input.addEventListener('touchstart', handlePasteEvent); // Add the paste event listener
    });

    function handleInputEvent(event) {
        const targetElementsvals = document.querySelector('.valid_verify_code').value;
        const input = event.target;
        const pastedText = input.value;
        const numbersRegex = /^\d+$/;
        if (numbersRegex.test(pastedText)) {
            let inputs = document.querySelectorAll('.verification-input');
            if (pastedText.length !== inputs.length) return;
            inputs.forEach((input, index) => {

                input.value = pastedText[index]

            });
        }
    }


    const targetElement = document.getElementById('first');
    targetElement.addEventListener('paste', handlePasteEvent);

    function handlePasteEvent(event) {
        const clipboardData = event.clipboardData || window.clipboardData;
        const pastedText = clipboardData.getData('text');
        const numbersRegex = /^\d+$/;
        if (numbersRegex.test(pastedText)) {
            let inputs = document.querySelectorAll('.verification-input');
            if (pastedText.length != inputs.length) return;
            inputs.forEach((input, index) => {
                input.focus();
                input.value = pastedText[index]
            });
            verify_code = pastedText;
        }
        event.preventDefault();
    }

    $('.verification-input').keyup(function(event) {
        if ((event.keyCode !== 46 && event.keyCode !== 13)) {

            $('#error_verify_code').html("");
            var maxLength = parseInt($(this).attr('maxlength'));
            var currentLength = $(this).val().length;
            if (currentLength === maxLength) {
                $(this).next('.verification-input').focus();
            }

            var verificationCode = '';
            $('.verification-input').each(function() {
                verificationCode += $(this).val();
            });
            verify_code = verificationCode;
            if ($('.verification-input').closest('.verification-inputs').hasClass('error')) {
                $('.verification-input').closest('.verification-inputs').removeClass('error');
            }
        }
    });

    function verification_code_disappear() {
        setTimeout(function() {
            $('#error_verify_code').html("");
            if ($('.verification-input').closest('.verification-inputs').hasClass('error')) {
                $('.verification-input').closest('.verification-inputs').removeClass('error');
            }

            $('.verification-input').each(function() {
                $(this).val('');
                $('#input-verify_code').val('');
            });
        }, 2000);
    }

    // Paste

    function submitFormVerifyCode() {
        var email = $(".loginEmail").val();

        var valid_verify_code = $(".valid_verify_code").val();
        $("#error_verify_code").html("");

        $(".verify-loading-icon").removeClass('d-none');
        $(".verify-btn-text").addClass("invisible");
        $(".verify-spinner").show();
        $('.continue-verify-btn').attr('disabled', true);

        if (email.trim() != "") {
            $.ajax({
                type: 'POST',
                method: 'post',
                url: '<?php echo url('api/ajax_new') ?>',
                data: {
                    action: "login_verify_code",
                    email: email,
                    verify_code: window.verify_code,
                    valid_verify_code: valid_verify_code,
                },

                success: function(response) {
                    if (response.data.result == "success") {
                        setTimeout(function() {
                            $(".verify-loading-icon").addClass('d-none');
                            $(".verify-btn-text").removeClass("invisible");
                            $(".verify-spinner").hide();
                            $('.continue-verify-btn').attr('disabled', false);

                            var event = "login";
                            var data = {
                                "userId": response.data.user.user_id,
                                "unique_id": response.data.user.unique_id,
                                "user_type": 'Returning User',
                                "method": 'Email',
                                "entry_point": "Signin"
                            }
                            window.location.href = "<?= SITE_URL . $redirect_route != null ? $redirect_route : 'qr-codes' ?>"

                        }, 1500);

                    }
                    if (response.data.result == "failed") {

                        $(".verify-loading-icon").addClass('d-none');
                        $(".verify-btn-text").removeClass("invisible");
                        $(".verify-spinner").hide();
                        $('.continue-verify-btn').attr('disabled', false);

                        $('#error_verify_code').html(response.data.data.message);
                        $('.verification-input').closest('.verification-inputs').addClass('error');

                        verification_code_disappear();
                    }

                }

            });
        }
    }


    // // Function to handle code resending
    function resendCode() {

        var email = $(".loginEmail").val();

        $.ajax({
            type: 'POST',
            method: 'post',
            url: '<?php echo url('api/ajax_new') ?>',
            data: {
                action: "resend_verify_code",
                email: email.trim(),
            },

            success: function(response) {}

        });
    }


    //if a user doesn’t enter the right verification code, the verification code entered should disappear

    $("#resend-code").click(function() {
        $('#resend-code').hide();
        $('.resend-timer').show();
        $('.verification-input').each(function() {
            $(this).val('');
            $('#input-verify_code').val('');
        });
        if ($('.verification-input').closest('.verification-inputs').hasClass('error')) {
            $('.verification-input').closest('.verification-inputs').removeClass('error');
            $('#error_verify_code').html('');
        }
        resendCode();
        startTimer();

    });

    $('#verifyLoginModal').on('hidden.bs.modal', function() {
        clearInterval(timerInterval);
    });

    var cnt = 0;

    function submitForm() {

        cnt++;
        var email = $(".loginEmail").val();
        var pass = $(".loginPass").val();
        var valid_verify_code = $(".valid_verify_code").val();


        $("#log_email_err").html("");
        $("#log_pass_err").html("");
        $("#error_log").html("");


        $(".loading-icon").removeClass('d-none');
        $('.login-btn').attr('disabled', true);
        $(".login-text").addClass("invisible");
        $(".login-spinner").show();

        if (email.trim() == "" || email.trim() == undefined || email.trim() == null) {
            $("#log_email_err").html("Email required");
            $(".loading-icon").addClass('d-none');
            $('.login-btn').attr('disabled', false);
            $(".login-text").removeClass("invisible");
            $(".login-spinner").hide();
        }

        if (email.trim() != "") {

            $.ajax({
                type: 'POST',
                method: 'post',
                url: '<?php echo url('api/ajax_new') ?>',
                data: {
                    action: "login_with_password",
                    email: email.trim(),
                    password: pass.trim(),
                    verify_code: verify_code.trim(),
                    valid_verify_code: valid_verify_code.trim(),
                },
                start_time: new Date().getTime(),
                success: function(response) {
                    if (response.data.result == "success") {

                        var event = "login";
                        var data = {
                            "userId": response.data.user.user_id,
                            "user_type": 'Returning User',
                            "method": 'Email',
                            "entry_point": "Signin"
                        }
                        googleDataLayer(event, data);
                        myForm.submit();
                    } else if (response.data.result == "verify") {
                        $("#verifyLoginModal").modal('show');
                        $('.valid_verify_code').val(response.data.data.verify_code);
                        $('#verifyLoginModal').on('shown.bs.modal', function() {

                            startTimer();
                            const inputField = document.getElementById('first');
                            inputField.focus();
                        });
                    } else if (response.data.result == 'password') {
                        $(".loading-icon").addClass('d-none');
                        $('.login-btn').attr('disabled', false);
                        $(".-password").removeClass('d-none');
                        $('#input-password').prop('readonly', false);
                        $(".login-text").removeClass("invisible");
                        $(".login-spinner").hide();

                        $(".-remember-me-forgot-password").removeClass('d-none');
                        $(".verify-code").addClass('d-none');

                        if (cnt >= 2) {
                            if (pass.trim() == "" || pass.trim() == undefined || pass.trim() == null) {
                                $("#log_pass_err").html("Password required");
                                $(".loading-icon").addClass('d-none');
                                $('.login-btn').attr('disabled', false);
                                $(".login-text").removeClass("invisible");
                                $(".login-spinner").hide();
                            }
                        }
                    } else {
                        $(".loading-icon").addClass('d-none');
                        $('.login-btn').attr('disabled', false);
                        $(".login-text").removeClass("invisible");
                        $(".login-spinner").hide();

                        if (response.data.data['type'] == 'google') {
                            $(".-password").addClass('d-none');
                            $(".-remember-me-forgot-password").addClass('d-none');
                        }

                        $("#error_log").html(response.data.data['message']);
                    }
                }
            })
        }
    }


    $("#input-email").on("change", function(e) {

        $("#error_log").html("");
        var pass = $(".loginPass").val();
        var email = $(".loginEmail").val();
        $(".modal-title-intro").html(`<?= l('login.verification_modal.sub_title_1') ?>` + ` ` + `<b>` + email + `</b>`);


        $("#user_email").val(email);

        if (pass.trim() != "" || pass.trim() != undefined || pass.trim() != null) {
            $(".-password").addClass('d-none');
            $("#log_email_err").html("");
            $("#log_pass_err").html("");
            $("#error_log").html("");
            $('.loginPass').val('');
            $(".-remember-me-forgot-password").addClass('d-none');

            // $(".loading-icon").addClass('d-none');
            // $('.login-btn').attr('disabled', false);

            window.cnt = 0;
        }
    })

    $(document).ready(function() {
        $(this).find('.verification-input').keypress(function(e) {
            if (e.which == 10 || e.which == 13) {
                submitFormVerifyCode()
            }
        });

    });

    $('#verifyLoginModal .btn-close').click(function() {
        location.reload();
    });
</script>

<?php \Altum\Event::add_content(ob_get_clean(), 'javascript') ?>