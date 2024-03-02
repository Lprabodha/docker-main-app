<?php defined('ALTUMCODE') || die() ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
<?= \Altum\Alerts::output_alerts() ?>
<?php


setcookie('qr_code_id', '', time() - 7200, COOKIE_PATH);
setcookie('qr_uid', '', time() - 7200, COOKIE_PATH);
setcookie('nsf_qr_id', '', time() - 7200, COOKIE_PATH);
setcookie('nsf_user_id', '', time() - 7200, COOKIE_PATH);

?>

<style>
	.invalid-feedback {
		display: block;
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
			margin-top: 10px;
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
					<?= l('register.title') ?>
				</div>
			</div>

			<div class="-col-form">
				<div class="-logo-wrapper-shadow"></div>
				<div class="-logo-wrapper">
					<img src="<?= ASSETS_FULL_URL . 'images/OQG_Brand_Logo.png' ?>" alt="Online QR Generator" class="-logo">
				</div>
				<form action="<?php echo SITE_URL; ?>register?redirect=qr?step=1&lang=<?php echo \Altum\Language::$code; ?>" id="register-form" method="post" role="form">

					<input type="hidden" name="utm_medium" value="<?php echo $data->utm_medium; ?>">
					<input type="hidden" name="utm_source" value="<?php echo $data->utm_source; ?>">
					<input type="hidden" name="utm_id" value="<?php echo $data->utm_id; ?>">
					<input type="hidden" name="utm_content" value="<?php echo $data->utm_content; ?>">
					<input type="hidden" name="utm_term" value="<?php echo $data->utm_term; ?>">
					<input type="hidden" name="gaid" value="<?php echo $data->gaid; ?>">
					<input type="hidden" name="gclid" value="<?php echo $data->gclid; ?>">
					<input type="hidden" name="gbraid" value="<?php echo $data->gbraid; ?>">
					<input type="hidden" name="wbraid" value="<?php echo $data->wbraid; ?>">
					<input type="hidden" name="matchtype" value="<?php echo $data->matchtype; ?>">
					<input type="hidden" name="user_id" value="<?php echo isset($_COOKIE['user_id']) ? $_COOKIE['user_id'] : null ?>">
					<div class="-form-title">
						<?= l('register.form.title') ?>
					</div>
					<div class="-form-subtitle">
						<?= l('register.form.description') ?>
					</div>
					<div class="-form-group -email">
						<div>
							<label for="input-email"><?= l('register.form.email') ?></label>
						</div>
						<div class="-form-input-wrapper">
							<img src="<?= ASSETS_FULL_URL . 'images/Message.svg' ?>" class="-input-icon">
							<div class="-divider"></div>
							<input id="input-email" autocapitalize="none" class="registerEmail" name="email" placeholder="<?= l('register.form.email.placeholder') ?>" maxlength="128" autofocus="autofocus" value="<?= $data->values['email'] ?>">

						</div>
						<span id="reg_email_err" style="color:red;font-size: 1rem;"></span>

					</div>
					<?= \Altum\Alerts::output_field_error('email') ?>
					<div class="-form-group -password">
						<div>
							<label for="input-password"><?= l('register.form.password') ?></label>
						</div>
						<div class="-form-input-wrapper">
							<img src="<?= ASSETS_FULL_URL . 'images/Lock.svg' ?>" class="-input-icon">
							<div class="-divider"></div>
							<input type="password" class="registerPassword" id="input-password" name="password" placeholder="<?= l('register.form.password.placeholder') ?>" value="<?= $data->values['password'] ?>">

							<button type="button" class="-reveal-password" data-target="#input-password">
								<img id="eyeOff" class="" src="<?= ASSETS_FULL_URL . 'images/Eye Off.svg' ?>">
								<img id="eyeOn" class="d-none" src="<?= ASSETS_FULL_URL . 'images/Eye On.svg' ?>">
							</button>
						</div>
						<span id="reg_pass_err" style="color:red;font-size: 1rem;"></span>
					</div>
					<?= \Altum\Alerts::output_field_error('password') ?>

					<?php if (settings()->captcha->register_is_enabled) : ?>
						<div class="form-group">
							<?php $data->captcha->display() ?>
						</div>
					<?php endif ?>

					<button type="submit" class="-btn-submit" onclick="submitForm()">
						<span class="signup-text"><?= l('register.form.signup_btn') ?></span>
						<div class="default-spinner"></div>
					</button>
					<div class="-or-divider">
						<div class="-divider"></div>
						<div class="-or">
							<?= l('register.form.or') ?>
						</div>
						<div class="-divider"></div>
					</div>
					<a href="<?= url('login/google-initiate') ?>?redirect=<?php echo  'qr?step=1' ?><?= $data->utm_id ? '&utm_id=' . $data->utm_id : '' ?><?= $data->utm_source ? '&utm_source=' . $data->utm_source : '' ?><?= $data->utm_medium ? '&utm_medium=' . $data->utm_medium : '' ?><?= $data->utm_content ? '&utm_content=' . $data->utm_content : '' ?><?= $data->utm_term ? '&utm_term=' . $data->utm_term : '' ?><?= $data->gaid ? '&gaid=' . $data->gaid : '' ?><?= $data->matchtype ? '&matchtype=' . $data->matchtype : '' ?><?= isset($_GET['promo']) ? '&promo=' . $_GET['promo'] : '' ?><?= isset($gclid) ? '&gclid=' . $gclid : '' ?><?= isset($gbraid) ? '&gbraid=' . $gbraid : '' ?><?= isset($wbraid) ? '&wbraid=' . $wbraid : '' ?>" class="-google-auth">
						<img src="<?= ASSETS_FULL_URL . 'images/logo-google.svg' ?>">
						<?= l('register.form.google_login') ?>
					</a>
					<div class="-no-account">
						<?= l('register.form.footer_1') ?>
						<a href="<?= url('login') ?>" class="-link-create-account">
							<?= l('register.form.footer_2') ?>
						</a>

						<p class="pt-5">
							<?= l('register.form.footer.text_1') ?><?= l('register.form.footer.text_2') ?><a class="-link-create-account" href="<?= url('terms-and-conditions') ?>"><?= l('register.form.footer.text_3') ?></a><?= l('register.form.footer.text_4') ?><a class="-link-create-account" href="<?= url('privacy-policy') ?>"><?= l('register.form.footer.text_5') ?></a>.
						</p>
					</div>
				</form>
			</div>

		</div>

	</div>

</div>

<?php ob_start() ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.11/clipboard.min.js"></script>

<script>
	$(document).ready(function() {
		$("#register-form").on("submit", function(event) {
			event.preventDefault();
		});
	});

	function submitForm() {

		var email = $(".registerEmail").val();
		var pass = $(".registerPassword").val();
		var regForm = document.getElementById("register-form")

		$("#reg_email_err").html("");
		$("#reg_pass_err").html("");

		if (email.trim() == "" || email.trim() == undefined || email.trim() == null) {
			$("#reg_email_err").html("<?= l('global.error_message.empty_field') ?>");
		}

		if (pass.trim() == "" || pass.trim() == undefined || pass.trim() == null) {
			$("#reg_pass_err").html("<?= l('global.error_message.empty_field') ?>");
		}

		if (email.trim() != "") {
			$.ajax({
				type: 'POST',
				method: 'post',
				url: '<?php echo url('api/ajax_new') ?>',
				data: {
					action: "check_email",
					email: email.trim(),
					password: pass.trim(),
				},

				start_time: new Date().getTime(),
				success: function(response) {

					if (response.data != '') {
						$("#reg_email_err").html(response.data);
						$(".signup-text").removeClass("add-invinsible");
						$(".default-spinner").hide();
					} else {
						$("#reg_email_err").html("");
						if (email.trim() != "" && email.trim() != undefined && email.trim() != null) {
							$(".-btn-submit").attr("disabled", true);
							$(".signup-text").addClass("add-invinsible");
							$(".default-spinner").show();
							regForm.submit();
						}
					}
				}
			})
		}
	}
</script>




<?php \Altum\Event::add_content(ob_get_clean(), 'javascript') ?>