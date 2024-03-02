<style>
	.invalid-feedback {
		display: block;
	}

	.section-email-feature {
		margin-top: 150px;
	}

	.section-login-signup>div>div>div.-col-form {
		margin-top: 85px;
	}

	@media (max-width: 1199.5px) {
		.section-email-feature {
			margin-top: 75px;
		}

		.section-login-signup>div>div>div.-col-form {
			margin-top: 80px;
		}

		@media (max-width: 899.5px) {
			.section-login-signup {
				position: relative;
			}

			.section-login-signup:after {
				z-index: 0;
				position: absolute;
				width: 100%;
				height: 300px;
				content: '';
				background-color: #F1FCF7;
				top: -219px;
			}
		}

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

	.section-email-feature .feature-detail .feature-icon-area {
		margin-right: 4px;
	}

	.section-email-feature .feature-detail .feature-icon-area i {
		padding: 2px;
		font-size: 14px;
	}

	.section-login-signup .section-email-feature .feature-detail .item-description {
		margin-bottom: 0.5rem;
		line-height: 1.25;
	}

	.section-login-signup .section-email-feature .feature-detail .item-description:not(:lang(en)) {
		margin-bottom: 0.75rem;
		line-height: 1.25;
	}

	/* ----------nfs-login-model------------- */

	.nsflogin-model-content {
		padding: 0px 20px 20px !important;
		max-width: 450px !important;
	}

	.nsflogin-model-content .modal-img {
		padding: 0 5px !important;
	}

	.nsflogin-model-content .modal-img p {
		margin-bottom: 20px;
	}

	.nsf-model-btn-wrap {
		justify-content: center;
		padding-top: 20px !important;
	}

	.nfs-login-btn:hover {
		color: #fff !important;
	}

	.nfs-login-btn {
		padding: 15px 13px;
		width: 250px !important;
		min-width: unset;
		font-size: 18px;
		height: 56px;
		font-weight: 700;
	}

	.nfs-model-close {
		position: absolute;
		top: 13px;
		right: 14px;
	}

	.nfs-model-close:focus {
		box-shadow: none;
	}

	.nsflogin-model-content .modal-header {
		border-bottom: none !important;
	}

	.nsf-login-modal-text {
		font-size: 18px !important;
	}

	.nsf-login-img {
		width: 275px;
		max-width: 275px;
		height: auto;
		margin-left: 37px;
	}

	@media(max-width:576.98px) {
		.nsf-header {
			position: fixed !important;
			top: 0px;
		}
	}
</style>

<div class="section-login-signup">
	<div class="-container">
		<div class="-main-cols">
			<div class="-col-form" style=" background-color: #fff;">
				<div class="-logo-wrapper-shadow"></div>
				<div class="-logo-wrapper">
					<img src="<?= ASSETS_FULL_URL . 'images/logo-footer.svg' ?>" alt="Online QR Generator" class="-logo" loading="lazy">
				</div>
				<form action="<?php echo SITE_URL; ?>register_nsf?redirect=qr-codes&lang=<?php echo \Altum\Language::$code; ?>" id="register-nsf-form" method="post" role="form" style="padding-top: 65px;" onkeydown="return event.key != 'Enter';">

					<input type="hidden" name="utm_id" value="<?php echo $data->utm_id; ?>">
					<input type="hidden" name="utm_source" value="<?php echo $data->utm_source; ?>">
					<input type="hidden" name="utm_medium" value="<?php echo $data->utm_medium; ?>">
					<input type="hidden" name="utm_content" value="<?php echo $data->utm_content; ?>">
					<input type="hidden" name="utm_term" value="<?php echo $data->utm_term; ?>">
					<input type="hidden" name="gaid" value="<?php echo $data->gaid; ?>">
					<input type="hidden" name="gclid" value="<?php echo $data->gclid; ?>">
					<input type="hidden" name="gbraid" value="<?php echo $data->gbraid; ?>">
					<input type="hidden" name="wbraid" value="<?php echo $data->wbraid; ?>">
					<input type="hidden" name="matchtype" value="<?php echo $data->matchtype; ?>">
					<input type="hidden" name="user_id" value="<?php echo isset($_COOKIE['user_id']) ? $_COOKIE['user_id'] : null ?>">
					<div class="-form-title">
						<?= l('register_nsf.header') ?>
					</div>
					<div class="-form-subtitle">
						<?= l('register_nsf.subtitle') ?>
					</div>
					<div class="-form-group -email" style="font-size:1rem;">
						<div>
							<label for="input-email"><?= l('register_nsf.email') ?></label>
						</div>
						<div class="-form-input-wrapper">
							<img src="<?= ASSETS_FULL_URL . 'images/Message.svg' ?>" class="-input-icon">
							<div class="-divider"></div>
							<input id="input-email" autocapitalize="none" class="nfs-email" name="email" placeholder="Enter your email here" maxlength="128" autofocus="autofocus" value="<?= $data->values['email'] ?>">
						</div>
						<span id="reg_email_err" style="color:red;"></span>

					</div>
					<?= \Altum\Alerts::output_field_error('email') ?>

					<?php if (settings()->captcha->register_is_enabled) : ?>
						<div class="form-group">
							<?php $data->captcha->display() ?>
						</div>
					<?php endif ?>

					<button type="button" class="-btn-submit nfs-submit-btn" onclick="submitForm()">
						<span class="nsf-submit-text"><?= l('register_nsf.submit') ?></span>
						<div class="nsf-spinner default-spinner"></div>
					</button>
					<div class="-or-divider">
						<div class="-divider"></div>
						<div class="-or">
							<?= l('register_nsf.or') ?>
						</div>
						<div class="-divider"></div>
					</div>
					<a href="<?= url('login/google-initiate') ?>?redirect=qr-codes<?= isset($_COOKIE['user_id']) ? '&user_id=' . $_COOKIE['user_id'] : '' ?>&on_bording=nsf<?= isset($data->gaid) ? '&gaid=' . $data->gaid : '' ?><?= isset($data->utm_term) ? '&utm_term=' . $data->utm_term : '' ?><?= isset($data->matchtype) ? '&matchtype=' . $data->matchtype : '' ?>" class="-google-auth">
						<img src="<?= ASSETS_FULL_URL . 'images/logo-google.svg' ?>">
						<?= l('register_nsf.google_register') ?>

					</a>
					<div class="section-email-feature">
						<h2 class="text">
							<?= l('register_nsf.email_feature') ?>

						</h2>

						<div class="feature-detail" style="margin-top: 20px;">
							<div class="detail d-flex">
								<div class="feature-icon-area ">
									<i class="icon-checker text-success" style="background-color: #25B533;"></i>
								</div>
								<div class="feature-item-detail">
									<p class="item-description"> <?= l('register_nsf.email_feature_1') ?>
									</p>
								</div>
							</div>
						</div>
						<div class="feature-detail">
							<div class="detail d-flex">
								<div class="feature-icon-area ">
									<i class="icon-checker text-success" style="background-color: #25B533;"></i>
								</div>
								<div class="feature-item-detail">
									<p class="item-description"> <?= l('register_nsf.email_feature_2') ?>
									</p>
								</div>
							</div>
						</div>
						<div class="feature-detail">
							<div class="detail d-flex">
								<div class="feature-icon-area ">
									<i class="icon-checker text-success" style="background-color: #25B533;"></i>
								</div>
								<div class="feature-item-detail">
									<p class="item-description"> <?= l('register_nsf.email_feature_3') ?>
									</p>
								</div>
							</div>
						</div>
						<div class="feature-detail">
							<div class="detail d-flex">
								<div class="feature-icon-area ">
									<i class="icon-checker text-success" style="background-color: #25B533;"></i>
								</div>
								<div class="feature-item-detail">
									<p class="item-description"> <?= l('register_nsf.email_feature_4') ?>
									</p>
								</div>
							</div>
						</div>
						<div class="feature-detail">
							<div class="detail d-flex">
								<div class="feature-icon-area ">
									<i class="icon-checker text-success" style="background-color: #25B533;"></i>
								</div>
								<div class="feature-item-detail">
									<p class="item-description"> <?= l('register_nsf.email_feature_5') ?>
									</p>
								</div>
							</div>
						</div>
						<div class="feature-detail">
							<div class="detail d-flex">
								<div class="feature-icon-area ">
									<i class="icon-checker text-success" style="background-color: #25B533;"></i>
								</div>
								<div class="feature-item-detail">
									<p class="item-description"> <?= l('register_nsf.email_feature_6') ?>
									</p>
								</div>
							</div>
						</div>
						<div class="feature-detail">
							<div class="detail d-flex">
								<div class="feature-icon-area">
									<i class="icon-checker text-success" style="background-color: #25B533;"></i>
								</div>
								<div class="feature-item-detail">
									<p class="item-description"> <?= l('register_nsf.email_feature_7') ?>
									</p>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>

			<div class="col-qr-image">
				<object data="<?= SITE_URL . 'uploads/qr_codes/logo/' . $data->qr_code->qr_code ?>?<?= time() ?>" class="img-fluid scan-img-obj" style="width: 100%;pointer-events: none;"></object>
			</div>
		</div>
	</div>
</div>

<!-- Details on this new popup modal -->
<div class="modal smallmodal fade" id="loginNsf" tabindex="-1" aria-labelledby="loginNsf" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-export">
		<div class="modal-content extra-space nsflogin-model-content">

			<div class="modal-header">
				<!-- <h5 class="modal-title">Modal title</h5> -->
				<button type="button" class="btn-close nfs-model-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>

			<button type="button" class="close d-none" data-dismiss="modal" aria-label="Close">
				<svg class="MuiSvgIcon-root jss709" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="font-size: 20px;">
					<path d="M13.41,12l5.3-5.29a1,1,0,1,0-1.42-1.42L12,10.59,6.71,5.29A1,1,0,0,0,5.29,6.71L10.59,12l-5.3,5.29a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0L12,13.41l5.29,5.3a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42Z"></path>
				</svg>
			</button>
			<div class="modal-img">
				<div class="nfs-img-wrap">
					<img src="<?= ASSETS_FULL_URL . 'images/NFS_login.png' ?>" class="img-fluid" />
				</div>
				<p class="nsf-login-modal-text"><?= l('register_nsf.email_used_text') ?></p>
			</div>
			<div class="modal-body modal-btn nsf-model-btn-wrap">
				<!-- <button class="btn primary-btn grey-btn  m-0 r-4 me-2" type="button" data-bs-dismiss="modal"><?= l('qr_codes.cancel') ?></button> -->
				<a class="btn primary-btn r-4 footerActionBtn nfs-login-btn" href="<?= SITE_URL . 'login' ?>" name="qr_status_deleted"><?= l('register_nsf.login_btn') ?></a>
			</div>
		</div>
	</div>
</div>

<?php ob_start() ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.11/clipboard.min.js"></script>
<script>
	$(".nfs-model-close").on("click", function() {
		$('#input-email').focus();
	});

	$(".nfs-submit-btn").on("click", function() {
		setTimeout(function() {
			if ($("#loginNsf").hasClass("show")) {
				var modelContent = $(".nsflogin-model-content");
				$(document).on("click", function(e) {
					if (!modelContent.is(e.target) && modelContent.has(e.target).length === 0) {
						$('#input-email').focus();
					}
				});
			}
		}, 800);
	});

	$(".section-navbar").addClass('nsf-header');
</script>

<script>
	$(document).ready(function() {
		$("#register-nsf-form").on("submit", function(event) {
			event.preventDefault();
		});
	});

	document.getElementById('input-email').addEventListener('keydown', function(event) {
		if (event.keyCode === 13 || event.which === 13) {
			event.preventDefault();
			submitForm();
		}
	});

	function submitForm() {

		var email = $("#input-email").val();
		var regForm = document.getElementById("register-nsf-form")

		$("#reg_email_err").html("");

		if (email.trim() == "" || email.trim() == undefined || email.trim() == null) {
			$("#reg_email_err").html("<?= l('global.error_message.empty_field') ?>");
		}

		if (email.trim() != "") {
			$.ajax({
				type: 'POST',
				method: 'post',
				url: '<?php echo url('api/ajax_new') ?>',
				data: {
					action: "check_email",
					email: email.trim(),
					password: '',
				},

				start_time: new Date().getTime(),
				success: function(response) {

					if (response.data != '') {
						$(".nsf-spinner").hide();
						$(".nsf-submit-text").removeClass("invisible");
						$('.nsf-submit-btn').css('pointer-events', 'auto');
						$("#reg_email_err").html(response.data);
						if (response.data == 'This email address is already in use.') {
							$("#reg_email_err").html('');
							document.getElementById('input-email').addEventListener('keypress', function(event) {
								if (event.keyCode === 13 || event.which === 13) {
									event.preventDefault();
									$("#loginNsf").modal("show");

								}
							});
							$("#loginNsf").modal("show");
						} else {
							$("#reg_email_err").html(response.data);
						}
					} else {
						$("#reg_email_err").html("");
						if (email.trim() != "" && email.trim() != undefined && email.trim() != null) {
							$('.nsf-submit-text').addClass("invisible");
							setTimeout(function() {
								$('.nsf-spinner').show();
							}, 300);
							$('.nsf-submit-btn').css('pointer-events', 'none');
							regForm.submit();
						}
					}

				}
			})
		}
	}

	$(".animate-logo").on("click", function(event) {
		if ($(window).width() < 768) {
			event.preventDefault();
			window.location.href = "<?= SITE_URL ?>";
		}
	});
</script>

<?php \Altum\Event::add_content(ob_get_clean(), 'javascript') ?>