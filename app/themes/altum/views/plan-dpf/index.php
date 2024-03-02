<?php

$rate = null;
$symbol = null;
$currentUser =  $this->user;


if ($exchangeData = exchange_rate($currentUser)) {
	$rate   = $exchangeData['rate'];
	$symbol = $exchangeData['symbol'];
	$code   = $exchangeData['code'];
}


$currency = 'USD';
$countryCurrency = get_user_currency($code);
if ($countryCurrency) {
	$currency = $code;
}


?>

<div class="section-login-signup plan-dpf-main-wrapper plan-cards-main-wrap">
	<div class="container">
		<div class="-main-cols plans-pick">
			<div class="right-pad">
				<div class="-col-form w-100">
					<div class="-logo-wrapper-shadow"></div>
					<div class="-logo-wrapper">
						<img src="<?= ASSETS_FULL_URL . 'images/logo-footer.svg' ?>" alt="Online QR Generator" class="-logo" loading="lazy">
					</div>
					<form id="register-nsf-form" method="post" role="form" style="padding-top: 65px;" onkeydown="return event.key != 'Enter';">
						<div class="-form-title">
							<?= l('register_dpf.header') ?>
						</div>
						<div class="-form-subtitle">
							<?= l('plan_dpf.form_subtitle') ?>
						</div>

						<div class="dpf-plans-wrap" id="dpf-plans-wrap">
							<div class="plan plan-1 ">
								<div class="friday-dis-wrap d-none">
									<span class="txt-fri-dis">70%</span>
								</div>
								<div class="friday-dis-wrap most-popular d-none">
									<span class="txt-fri-dis">70%</span>
								</div>
								<div class="plan-card">
									<input type="radio" id="dpfPlan1" name="dpf-plan" value="dpfPlan1" />
									<div class="card-wrp">
										<label for="dpfPlan1" class="<?= $symbol == 'Arg$' || $symbol == 'Rs' || $symbol == 'R'  ? 'arg-currency ' : ''  ?>">
											<span class="dpfplan-title"><?= l('plan_dpf.plan_1_name') ?></span>
											<?php if ($countryCurrency) : ?>
												<span class="dpf-plan-price us-canda-price-text"><?= $symbol ?>&nbsp;<?= custom_currency_format(get_plan_month_price(7, $code)) ?></span></label>
										<div class="friday-price-wrap d-none">
											<span class="pay-currency"><?= $symbol ?>&nbsp;<?= round_number_format(get_plan_month_price(7, $code) / 30 * 100) ?></span>
										</div>
									<?php elseif (check_usd($code)) : ?>
										<span class="dpf-plan-price us-canda-price-text">$&nbsp;<?= custom_currency_format(get_plan_month_price(7, $code)) ?></span></label>
										<div class="friday-price-wrap d-none">
											<span class="pay-currency"><?= $symbol ?>&nbsp;<?= round_number_format(get_plan_month_price(7, $code) / 30 * 100) ?></span>
										</div>
									<?php else : ?>
										<span class="dpf-plan-price"><?= $symbol ?>&nbsp;<?= custom_currency_format(get_plan_month_price(7, $code) * $rate) ?><span class="d-sm-inline">&nbsp;<?= $code ?></span></span></label>
										<div class="usd-price-wrap">
											<span class="pay-currency">($ 1.45 USD)</span>
										</div>
										<div class="friday-price-wrap d-none">
											<span class="pay-currency "><?= $symbol ?>&nbsp;<?= round_number_format(get_plan_month_price(7, $code) * $rate / 30 * 100) ?></span>
										</div>
									<?php endif ?>
									</div>
								</div>
							</div>

							<div class="plan plan-2 most-popular">
								<div class="plan-card">
									<input type="radio" id="dpfPlan2" name="dpf-plan" value="dpfPlan2" checked />
									<div for="dpfPlan2" class="card-wrp">
										<label for="dpfPlan2" class="<?= $symbol == 'Arg$' || $symbol == 'Rs' || $symbol == 'R'  ? 'arg-currency ' : ''  ?>">
											<span class="dpfplan-title"><?= l('plan_dpf.plan_2_name') ?></span>
											<?php if ($countryCurrency) : ?>
												<span class="dpf-plan-price us-canda-price-text"><?= $symbol ?>&nbsp;<?= custom_currency_format(get_plan_month_price(6, $code)) ?></span></label>
										<div class="friday-price-wrap friday-price-offer-wrap d-none">
											<span class="pay-currency friday-price-currency"><?= $symbol ?>&nbsp;<?= round_number_format(get_plan_month_price(6, $code) / 30 * 100) ?></span>
										</div>
									<?php elseif (check_usd($code)) : ?>
										<span class="dpf-plan-price us-canda-price-text">$&nbsp;<?= custom_currency_format(get_plan_month_price(6, $code)) ?></span></label>
										<div class="friday-price-wrap friday-price-offer-wrap d-none">
											<span class="pay-currency friday-price-currency"><?= $symbol ?>&nbsp;<?= round_number_format(get_plan_month_price(6, $code) / 30 * 100) ?></span>
										</div>
									<?php else : ?>
										<span class="dpf-plan-price"><?= $symbol ?>&nbsp;<?= custom_currency_format(get_plan_month_price(6, $code) * $rate) ?><span class="d-sm-inline">&nbsp;<?= $code ?></span></span></label>
										<div class="usd-price-wrap usd-offer-wrap">
											<span class="pay-currency">($ 1.95 USD)</span>
										</div>
										<div class="friday-price-wrap friday-price-offer-wrap d-none">
											<span class="pay-currency friday-price-currency"><?= $symbol ?>&nbsp;<?= round_number_format(get_plan_month_price(6, $code) * $rate / 30 * 100) ?></span>
										</div>
									<?php endif ?>
									</div>
									<div class="badge-wrp"><span><?= l('plan_dpf.plan_popular_badge') ?></span></div>
								</div>
							</div>
							<div class="plan plan-3">
								<div class="friday-dis-wrap d-none">
									<span class="txt-fri-dis">60%</span>
								</div>
								<div class="plan-card">
									<input type="radio" id="dpfPlan3" name="dpf-plan" value="dpfPlan3" />
									<div class="card-wrp">
										<label for="dpfPlan3" class="<?= $symbol == 'Arg$' || $symbol == 'Rs' || $symbol == 'R'  ? 'arg-currency ' : ''  ?>"><span class="dpfplan-title"><?= l('plan_dpf.plan_3_name') ?></span>
											<?php if ($countryCurrency) : ?>
												<span class="dpf-plan-price us-canda-price-text"><?= $symbol ?>&nbsp;<?= custom_currency_format(get_plan_month_price(2, $code)) ?> / mo</span></label>
										<div class="friday-price-wrap d-none">
											<span class="pay-currency"><?= $symbol ?>&nbsp;<?= round_number_format(get_plan_month_price(2, $code) / 40 * 100) ?>&nbsp;/ mo</span>
										</div>
									<?php elseif (check_usd($code)) : ?>
										<span class="dpf-plan-price us-canda-price-text">$&nbsp;<?= custom_currency_format(get_plan_month_price(2, $code)) ?>&nbsp;<?= l('plan_dpf.plan_3_price') ?></span></label>
										<div class="friday-price-wrap d-none">
											<span class="pay-currency"><?= $symbol ?>&nbsp;<?= round_number_format(get_plan_month_price(2, $code) / 40 * 100) ?>&nbsp;/ mo</span>
										</div>
									<?php else : ?>
										<span class="dpf-plan-price "><?= $symbol ?>&nbsp;<?= custom_currency_format(get_plan_month_price(2, $code)  * $rate) ?><span class="d-sm-inline">&nbsp;<?= $code ?></span><?= l('plan_dpf.plan_3_price') ?></span></label>
										<div class="usd-price-wrap">
											<span class="pay-currency">($ 19.95 USD / mo)</span>
										</div>
										<div class="friday-price-wrap d-none">
											<span class="pay-currency"><?= $symbol ?>&nbsp;<?= round_number_format(get_plan_month_price(2, $code) * $rate / 40 * 100) ?>&nbsp;/ mo</span>
										</div>
									<?php endif ?>
									</div>
								</div>
							</div>

							<div class="button-wrp">
								<a href="" id="user_plan_url" type="button" class="-btn-submit nfs-submit-btn mx-auto dpf-plan-btn add-to-cart">
									<span class="dpf-submit-text"><?= l('plan_dpf.continue_btn') ?></span>
									<div class="dpf-spinner default-spinner"></div>
								</a>
							</div>
						</div>

						<hr class="dpf-hr d-none">

						<div class="mobile-qr">
							<div class="col-qr-image dpf-qr-wrap mx-auto">
								<div class="dpf-pay-qr-header mt-3 d-flex justify-content-center">
									<div class="check-icon-wrap">
										<div class="check-icon"></div>
									</div>
									<div class="heading-wrp">
										<p><?= l('plan_dpf.heading') ?></p>
									</div>
								</div>
								<div class="qr-wrap">
									<object data="<?= SITE_URL . 'uploads/qr_codes/logo/' . $data->qr_code->qr_code ?>?<?= time() ?>" class="img-fluid scan-img-obj" style="pointer-events: none;"></object>
									<span class="corners-set corners-up"></span>
									<span class="corners-set corners-down"></span>
								</div>
							</div>
						</div>

						<div class="section-email-feature row row-cols-md-2 mt-6">
							<div class="feature-detail">
								<div class="detail d-flex">
									<div class="feature-icon-area">
										<i class="dpf-plan-icon icon-email text-success"></i>
									</div>
									<div class="feature-item-detail">
										<p class="item-description"> <?= l('register_dpf.email_feature_1') ?>
										</p>
									</div>
								</div>
							</div>
							<div class="feature-detail">
								<div class="detail d-flex">
									<div class="feature-icon-area ">
										<i class="dpf-plan-icon icon-qr-multiple text-success"></i>
									</div>
									<div class="feature-item-detail">
										<p class="item-description 1 acces-text"> <?= l('plan_dpf.email_feature_1') ?></p>
										<p class="item-description 1 d-none limited-acces-text"> <?= l('plan_dpf.email_feature_1_1') ?></p>
									</div>
								</div>
							</div>
							<div class="feature-detail">
								<div class="detail d-flex">
									<div class="feature-icon-area ">
										<i class="dpf-plan-icon icon-qr-edit-sq text-success"></i>
									</div>
									<div class="feature-item-detail">
										<p class="item-description 4"> <?= l('plan_dpf.email_feature_2') ?></p>

									</div>
								</div>
							</div>
							<div class="feature-detail">
								<div class="detail d-flex">
									<div class="feature-icon-area ">
										<i class="dpf-plan-icon icon-scan-barcode text-success"></i>
									</div>
									<div class="feature-item-detail">
										<p class="item-description 3 acces-text"> <?= l('plan_dpf.email_feature_3') ?></p>
										<p class="item-description 4 d-none limited-acces-text"> <?= l('plan_dpf.email_feature_3_1') ?></p>
									</div>
								</div>
							</div>
							<div class="feature-detail">
								<div class="detail d-flex">
									<div class="feature-icon-area ">
										<i class="dpf-plan-icon icon-activity text-success"></i>
									</div>
									<div class="feature-item-detail">
										<p class="item-description 5"> <?= l('plan_dpf.email_feature_4') ?></p>
									</div>
								</div>
							</div>
							<div class="feature-detail">
								<div class="detail d-flex">
									<div class="feature-icon-area ">
										<i class="dpf-plan-icon icon-qr-manage text-success"></i>
									</div>
									<div class="feature-item-detail">
										<p class="item-description 2"> <?= l('plan_dpf.email_feature_5') ?></p>
									</div>
								</div>
							</div>
							<div class="feature-detail">
								<div class="detail d-flex">
									<div class="feature-icon-area">
										<i class="dpf-plan-icon icon-qr-more text-success"></i>
									</div>
									<div class="feature-item-detail">
										<p class="item-description 6"> <?= l('plan_dpf.email_feature_6') ?></p>
									</div>
								</div>
							</div>
						</div>
						<!-- </form> -->
						<div class="plan-dpf-paymethod-wrap">
							<hr class="d-sm-none">
							<div class="plan-dpf-paymethod-title-wrap d-flex justify-content-center align-items-center">
								<div class="shield-icon-wrap">
									<div class="shield-icon">
										<img src="<?= ASSETS_FULL_URL . 'images/shield.png' ?>" alt="" class="img-fluid">
									</div>
								</div>
								<div class="plan-dpf-pay-method-text-wrap ps-2">
									<span class="plan-dpf-paymethod-title"> <?= l('plan_dpf.paymethod_title_1') ?> <span class="plan-paymethod-green"><?= l('plan_dpf.paymethod_title_2') ?></span><?= l('plan_dpf.paymethod_title_3') ?></span>
								</div>
							</div>

							<div class="plan-dpf-paymethod-cards-wrap py-4">
								<div class="dpf-pay-method-wrap d-flex">
									<div class="pay-method-card col">
										<div class="pay-card">
											<div class="image-card-wrap">
												<img src="<?= ASSETS_FULL_URL . 'images/payment-methods/visa.png' ?>" class="img-fluid" alt="" />
											</div>
										</div>
									</div>
									<div class="pay-method-card col">
										<div class="pay-card">
											<div class="image-card-wrap">
												<img src="<?= ASSETS_FULL_URL . 'images/payment-methods/master.png' ?>" class="img-fluid" alt="" />
											</div>
										</div>
									</div>
									<div class="pay-method-card col">
										<div class="pay-card">
											<div class="image-card-wrap">
												<img src="<?= ASSETS_FULL_URL . 'images/payment-methods/google-pay.png' ?>" class="img-fluid" alt="" />
											</div>
										</div>
									</div>
									<div class="pay-method-card col">
										<div class="pay-card">
											<div class="image-card-wrap">
												<img src="<?= ASSETS_FULL_URL . 'images/payment-methods/amreican-express.png' ?>" class="img-fluid" alt="" />
											</div>
										</div>
									</div>
									<div class="pay-method-card col">
										<div class="pay-card">
											<div class="image-card-wrap">
												<img src="<?= ASSETS_FULL_URL . 'images/payment-methods/apple-pay.png' ?>" class="img-fluid" alt="" />
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

				
						<div class="payment-policy-wrap mt-3 dfg">
								<span class="dpf-policy-text text-center not-annual-plan-policy">
											<span class="text-annual-plan-dpf">
												<?php

														if ($countryCurrency){
															$plan_price = $symbol.' '.custom_currency_format(get_plan_month_price(1, $code));
														}else{
															$plan_price = '$'.'&nbsp'.custom_currency_format(get_plan_month_price(1, $code));
														} 
													$plan_text = l('plan_dpf.policy_text_not_annual_1');
													$plan_text_price = str_replace("[plan_price_dpf]", $plan_price , $plan_text);
													$plan_text_3 = l('plan_dpf.policy_text_not_annual_3');
													$plan_text_email = str_replace("[oqg_support_plan_email]", '<a href="mailto:support@online-qr-generator.com">'.'support@online-qr-generator.com'.'</a>' ,$plan_text_3 );
													echo $plan_text_price.' '.'<b>'.l('plan_dpf.policy_text_not_annual_2').'</b>'.' '. $plan_text_email ;
												?>
											</span>
									
								</span>
								<span class="dpf-policy-text text-center annual-plan-policy" style="display:none;">
											<span class="text-annual-plan-dpf">
												<?php
													$plan_text_annual = l('plan_dpf.policy_text_annual_1');
													$plan_text_annual_email = str_replace("[oqg_support_plan_email]", '<a href="mailto:support@online-qr-generator.com">'.'support@online-qr-generator.com'.'</a>'  , $plan_text_annual);
													echo $plan_text_annual_email ;
												?>
											</span>
									
								</span>
						</div>

						<div class="paln-dpf-mobile-q-area d-none">
							<div class="plan-dpf-q-wrap bg-white">
								<div class="plan-dpf-q-heading">
									<span class="q-title">
										<?= l('plan_dpf.question_title') ?>
									</span>
								</div>
								<div class="q-cards">
									<div class="q-full-card">
										<div class="q-card-wrap row w-100">
											<div class="q-icon-full-wrap col-sm-1 col">
												<div class="q-icon-wrap rounded-circle">
												</div>
											</div>
											<div class="q-text-area col-sm col-10">
												<p class="q-title"><?= l('plan_dpf.question_1') ?></p>
												<span class="q-answer"><?= l('plan_dpf.answer_1') ?></span>
											</div>
										</div>
									</div>
									<div class="q-full-card">
										<div class="q-card-wrap row w-100">
											<div class="q-icon-full-wrap col-sm-1 col">
												<div class="q-icon-wrap rounded-circle">
												</div>
											</div>
											<div class="q-text-area col-sm col-10">
												<p class="q-title"><?= l('plan_dpf.question_2') ?>
												</p>
												<span class="q-answer"><?= l('plan_dpf.answer_2') ?></span>
											</div>
										</div>
									</div>
									<div class="q-full-card">
										<div class="q-card-wrap row w-100">
											<div class="q-icon-full-wrap col-sm-1 col">
												<div class="q-icon-wrap rounded-circle">
												</div>
											</div>
											<div class="q-text-area col-sm col-10">
												<p class="q-title"><?= l('plan_dpf.question_3') ?></p>
												<span class="q-answer"><?= l('plan_dpf.answer_3') ?></span>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>

			<div class="left-pad desktop-qr">
				<div class="desktop-qr col-qr-image dpf-qr-wrap w-100">
					<div class="plan-dpf-qr-full-wrap d-flex justify-content-center align-items-center flex-column">
						<div class="dpf-pay-qr-header mt-3 d-flex justify-content-center">
							<div class="check-icon-wrap">
								<div class="check-icon"></div>
							</div>
							<div class="heading-wrp">
								<p><?= l('plan_dpf.heading') ?></p>
							</div>
						</div>

						<div class="qr-wrap p-4">
							<object data="<?= SITE_URL . 'uploads/qr_codes/logo/' . $data->qr_code->qr_code ?>?<?= time() ?>" class="img-fluid scan-img-obj" style="height: 350px;pointer-events: none;max-width:310px"></object>
							<span class="corners-set corners-up"></span>
							<span class="corners-set corners-down"></span>
						</div>
					</div>

					<div class="plan-dpf-q-wrap desktop-q-area">
						<div class="plan-dpf-q-heading">
							<span class="q-title">
								<?= l('plan_dpf.question_title') ?>
							</span>
						</div>
						<div class="q-cards">
							<div class="q-full-card">
								<div class="q-card-wrap row w-100">
									<div class="q-icon-full-wrap col-1">
										<div class="q-icon-wrap rounded-circle">
										</div>
									</div>
									<div class="q-text-area col">
										<p class="q-title"><?= l('plan_dpf.question_1') ?></p>
										<span class="q-answer"><?= l('plan_dpf.answer_1') ?></span>
									</div>
								</div>
							</div>
							<div class="q-full-card">
								<div class="q-card-wrap row w-100">
									<div class="q-icon-full-wrap col-1">
										<div class="q-icon-wrap rounded-circle">
										</div>
									</div>
									<div class="q-text-area col">
										<p class="q-title"><?= l('plan_dpf.question_2') ?>
										</p>
										<span class="q-answer"><?= l('plan_dpf.answer_2') ?></span>
									</div>
								</div>
							</div>
							<div class="q-full-card">
								<div class="q-card-wrap row w-100">
									<div class="q-icon-full-wrap col-1">
										<div class="q-icon-wrap rounded-circle">
										</div>
									</div>
									<div class="q-text-area col">
										<p class="q-title"><?= l('plan_dpf.question_3') ?></p>
										<span class="q-answer"><?= l('plan_dpf.answer_3') ?></span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="plan-dpf-rate-wrap p-3 mt-3">
			<div class="rate-head-wrap">
				<span class="rate-head-title"><?= l('plan_dpf.rating_title') ?></span>
				<div class="rate-full-wrap d-flex justify-content-center align-items-center mt-1">
					<div class="rate-wrap">
						<span class="rate-subheading"><?= l('plan_dpf.rating_title_sub') ?></span>
					</div>
					<div class="rate-stars-wrap ps-3">
						<span class="rate-star icon-qr-star"></span>
						<span class="rate-star icon-qr-star"></span>
						<span class="rate-star icon-qr-star"></span>
						<span class="rate-star icon-qr-star"></span>
						<span class="rate-star icon-qr-star"></span>
					</div>
				</div>
			</div>
			<div class="review-full-wrap">
				<div class="review-cards-wrap row w-100 m-auto">
					<div class="col-lg-4">
						<div class="review-card p-3 py-4">
							<div class="review-text-wrap">
								<span class="reivew-text">
									<?= l('plan_dpf.rating_review_1') ?>
								</span>
							</div>
							<div class="reviewer-full-wrap mt-auto">
								<div class="reviewer-detail-wrap d-flex">
									<div class="reviewer-image">
										<img src="<?= ASSETS_FULL_URL . 'images/review/EthanRodriguez.png' ?>" alt="" class="img-fluid">
									</div>
									<div class="ps-3 reviewer-detail d-flex justify-content-center align-items-start flex-column">
										<p class="reviewer-name"><?= l('plan_dpf.rating_reviewer_1') ?></p>
										<span class="reviewer-position"><?= l('plan_dpf.rating_reviewer_position_1') ?>
										</span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="review-card p-3 py-4">
							<div class="review-text-wrap">
								<span class="reivew-text">
									<?= l('plan_dpf.rating_review_2') ?>
								</span>
							</div>
							<div class="reviewer-full-wrap mt-auto">
								<div class="reviewer-detail-wrap d-flex">
									<div class="reviewer-image">
										<img src="<?= ASSETS_FULL_URL . 'images/review/MarcusNguyen.png' ?>" alt="" class="img-fluid">
									</div>
									<div class="ps-3 reviewer-detail d-flex justify-content-center align-items-start flex-column">
										<p class="reviewer-name"><?= l('plan_dpf.rating_reviewer_2') ?></p>
										<span class="reviewer-position"><?= l('plan_dpf.rating_reviewer_position_2') ?></span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="review-card p-3 py-4">
							<div class="review-text-wrap">
								<span class="reivew-text">
									<?= l('plan_dpf.rating_review_3') ?>
								</span>
							</div>
							<div class="reviewer-full-wrap mt-auto">
								<div class="reviewer-detail-wrap d-flex">
									<div class="reviewer-image">
										<img src="<?= ASSETS_FULL_URL . 'images/review/AlexPatel.png' ?>" alt="" class="img-fluid">
									</div>
									<div class="ps-3 reviewer-detail d-flex justify-content-center align-items-start flex-column">
										<p class="reviewer-name"><?= l('plan_dpf.rating_reviewer_3') ?></p>
										<span class="reviewer-position"><?= l('plan_dpf.rating_reviewer_position_3') ?></span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="plan-dpf-footer-wrap p-2 d-sm-none">
			<span class="term-text-1 text-center d-block"><?= l('plan_dpf.footer_text_1') ?></span>
			<span class="term-text-2 text-center d-block">2<?= date("Y"); ?> © Online QR Generator <?= l('plan_dpf.footer_text_2') ?></span>
			<span class="term-text-1 text-center d-block"><?= l('plan_dpf.footer_text_3') ?></span>
		</div>
	</div>
</div>
<div id="confirmationModal" style="display: none;position:absolute;top:50%;left:50%;opacity:0;transform:translate(-50%,-50%);background-color:#fff;z-index:-1000;">
	<div>
		<p>Are you sure you want to leave this page?</p>
		<button class="btn leave-alert-accept" onclick="confirmLeave()">Yes</button><br>
		<button class="btn" onclick="closeModal()">No</button>
	</div>
</div>

<?php if (isset($this->user->user_id) && $this->user->payment_processor == '') : ?>
	<script>
		// Data Layer Implementation (GTM)
		$(document).on('click', '.add-to-cart', function() {

			const selectedOption = document.querySelector('input[name="dpf-plan"]:checked').id;
			var event = "add_to_cart";

			var data = {
				"userId": "<?php echo $this->user ? $this->user->user_id : 'null' ?>",
				'plan_name': planPrice(selectedOption)[1],
				'plan_value': planPrice(selectedOption)[0],
				'plan_currency': "<?= $currency ?>",
				'user_type': '<?php echo $this->user->total_logins == '1' ? 'New User' : 'Returning User' ?>',
				'method': '<?php echo $this->user->source == 'direct' ? 'Email' : 'Google' ?>',
				'entry_point': '<?php echo $this->user->total_logins == '1' ? 'Signup' : 'Signin' ?>',
				'funnel': 'dpf',

			}
			googleDataLayer(event, data);
		})
	</script>
<?php endif ?>

<script>
	function planPrice(selectedOption) {
		let price;
		let name;
		let data;
		switch (selectedOption) {
			case 'dpfPlan1':
				price = '<?= custom_currency_format(get_plan_month_price(7, $code)) ?>';
				name = '14 Day Limited Access';
				break;
			case 'dpfPlan2':
				price = '<?= custom_currency_format(get_plan_month_price(6, $code))  ?>';
				name = '14 Day Full Access';
				break;
			case 'dpfPlan3':
				price = '<?= custom_currency_format(get_plan_price(2, $code)) ?>';
				name = 'Annually';
				break;
		}

		data = [price, name];
		return data;

	}
</script>

<script>
	function adjustFontSize(elementId, newSize, newSize2) {
		// var textElement = document.getElementById(elementId);
		var textElement = document.querySelector("." + elementId);
		var textLength = textElement.textContent.length;
		if (textLength > 12) {
			textElement.style.fontSize = newSize;
		}
		if (textLength > 16) {
			textElement.style.fontSize = newSize2;
		}
	}
	adjustFontSize('badge-wrp', '9px', '8.5px');
</script>

<script>
	function checkUserOnlineStatus(status = 'online') {
		var data = {
			action: 'check_user_online_status',
			status: status,
			userId: '<?= $this->user->user_id ?>'
		}

		$.ajax({
			type: 'POST',
			url: '<?= url('api/ajax_new') ?>',
			data: data,
			dataType: 'json',
			success: function(response) {},
			error: function(error) {
				console.error(error);
			}
		});
	}

	setInterval(() => {
		checkUserOnlineStatus();
	}, 30000);

	$(document).ready(function() {
		var elements = $('.dpfplan-title');
		elements.each(function(index, element) {
			var textLength = $(element).text().length;
			if (textLength > 20) {
				$(element).addClass('set-font-size');
				console.log('Text Length of Element ' + index + ':', textLength);
			}
		});
	});
	$(document).ready(function() {
		$(document).find('#user_plan_url').attr('href', `${url}pay-dpf/6?<?= $data->query_string ?>`);
	});

	let isSubmit = false;

	document.getElementById('dpf-plans-wrap').addEventListener('click', function(event) {
		isSubmit = true;
		const selectedOption = document.querySelector('input[name="dpf-plan"]:checked').id;
		let content;
		var link = document.getElementById("user_plan_url");

		switch (selectedOption) {
			case 'dpfPlan1':
				content = `${url}pay-dpf/7?<?= $data->query_string ?>`;
				break;
			case 'dpfPlan2':
				content = `${url}pay-dpf/6?<?= $data->query_string ?>`;
				break;
			case 'dpfPlan3':
				content = `${url}pay-dpf/2?<?= $data->query_string ?>`;
				break;
			default:
				content = `${url}pay-dpf/6?<?= $data->query_string ?>`;
				break;
		}

		link.setAttribute('href', content);

	});

	let confirmedLeave = false;

	function confirmLeave() {
		confirmedLeave = true;
		window.location.replace('<?= SITE_URL ?>');
	}

	$(".animate-logo").on("click", function(e) {
		if ($(window).width() < 768) {
			isSubmit = true;
			getAlert();
			e.preventDefault();
			window.location.href = "<?= SITE_URL ?>";
		}
	});

	$(".dpf-plan-btn").on("click", function() {
		isSubmit = true;
		getAlert();
	});

	window.addEventListener('beforeunload', function(event) {
		if (!isSubmit) {
			<?php $_SESSION['exit_from_plans'] = true ?>
		} else {
			<?php unset($_SESSION['exit_from_plans']) ?>
		}
	});

	function getAlert() {
		if (!isSubmit) {
			window.onbeforeunload = function(e) {
				if (!confirmedLeave) {
					openModal();
					return "Are you sure you want to leave this page?";
				}
			};

			function openModal() {
				const modal = document.getElementById("confirmationModal");
				modal.style.display = "block";
				setTimeout(function() {
					$(".leave-alert-accept").trigger("click");
				}, 800);
			}

		} else {
			// If isSubmit is true, disable the onbeforeunload function
			window.onbeforeunload = null;
		}
	}

	function getBrowserBackAlert() {
		window.onbeforeunload = function(e) {
			return "Are you sure you want to leave this page?";
		};
		openModalInBack();
		createBrowserHistory();
		isSubmit = false;
		confirmedLeave = false;
		getAlert();
	}

	function defaultLeaveAlert() {
		window.onbeforeunload = function(e) {
			return "Are you sure you want to leave this page?";
		};
	}

	function openModalInBack() {
		const modal = document.getElementById("confirmationModal");
		modal.style.display = "block";
		$(".leave-alert-accept").trigger("click");
	}

	$(".animate-logo").on("click", function() {
		isSubmit = true;
		getAlert();
		defaultLeaveAlert();
	});

	getAlert();

	$(".plan-card").on("click", function() {
		toggleFeature();
	});

	$(document).ready(function() {
		setTimeout(function() {
			toggleFeature();
		}, 500);

		createBrowserHistory();
	});

	function createBrowserHistory() {
		var dpfUrl = window.location.href;

		history.pushState({
			page: "plan-dpf"
		}, "plan-dpf", dpfUrl);

	}

	function toggleFeature() {
		if ($('#dpfPlan1').is(':checked')) {
			$(".limited-acces-text").show();
			$(".limited-acces-text").removeClass("d-none");
			$(".acces-text").hide();
		} else {
			$(".limited-acces-text").hide();
			$(".limited-acces-text").addClass("d-none");
			$(".acces-text").show();
		}
		

		if ($('#dpfPlan3').is(':checked')) {
			$(".not-annual-plan-policy").hide();
			$(".annual-plan-policy").show();
		} else {
			$(".not-annual-plan-policy").show();
			$(".annual-plan-policy").hide();
		}
	}

	$("#user_plan_url").on("click", function() {
		$('.dpf-submit-text').addClass("invisible");
		$('.dpf-spinner').show();
		$(this).css('pointer-events', 'none');
	});
</script>

<script>
	// Set the time (in milliseconds) for inactivity before redirect
	const inactivityTimeout = 30 * 60 * 1000; // 60 minutes

	let timeout;

	function resetTimer() {
		clearTimeout(timeout);
		timeout = setTimeout(redirectToHomepage, inactivityTimeout);
	}

	function redirectToHomepage() {
		// redirect to dashboard
		window.location.href = '<?= SITE_URL ?>';
	}

	// Reset the timer when there's user activity
	document.addEventListener('mousemove', resetTimer);
	document.addEventListener('keypress', resetTimer);
	document.addEventListener('touchstart', resetTimer);

	// Initial timer start
	resetTimer();
</script>

<script>
	// Data Layer Implementation (GTM)
	window.addEventListener('load', (event) => {

		<?php if ($data->auth_method != '') { ?>
			let method = '<?= $data->auth_method ?>';
			let user_id = '<?= $this->user->user_id ?>';
			let email = '<?= $this->user->email ?>';
			let unique_id = '<?= isset($this->user->unique_id) ? $this->user->unique_id : null  ?>';
			let client_id = '<?php echo get_client_id() != null ? get_client_id() : default_client_id() ?>';
			let funnel = 'dpf';


			$.ajax({
				type: 'POST',
				url: '<?php echo url('api/ajax_new') ?>',
				data: {
					client_id: client_id,
					method: method,
					user_id: user_id,
					action: 'saveRegisterUser',
				},
				success: function(response) {
					if (response.data.newUser == true) {
						var event = "registration";
						var registerData = {
							"userId": user_id,
							"user_type": 'New User',
							"method": method,
							"entry_point": 'DPF',
							"client_id": client_id,
							"funnel": 'dpf',
							"email": email
						}
						googleDataLayer(event, registerData);

						// if (response.data.isProduction == true) {
						// 	//Add Google Ads "Event Snippet"
						// 	gtag('set', 'user_data', {
						// 		"sha256_email_address": email,
						// 	});

						// 	gtag('event', 'conversion', {
						// 		'send_to': 'AW-11373126555/BibACObJp-wYEJvHkK8q',
						// 		'transaction_id': user_id
						// 	});
						// }
					}
				}
			})
		<?php } ?>
	})

	window.addEventListener("resize", () => {
		const windowWidth = window.innerWidth;
		if (windowWidth < 900) {
			$(".plan-dpf-rate-wrap").appendTo(".plan-cards-main-wrap form");
		} else {
			$(".plan-dpf-rate-wrap").appendTo(".plan-cards-main-wrap .container");
		}
		if (windowWidth < 768) {
			$(".plan-dpf-footer-wrap").appendTo(".plan-cards-main-wrap form");
		}
	});

	if ($(window).width() > 1200) {
		getObjectHeight();
	}

	function getObjectHeight() {
		setTimeout(function() {
			var qrContentHeight = $('.scan-img-obj').contents().find('svg').height();
			if (qrContentHeight > 300) {
				$(".plan-cards-main-wrap .desktop-q-area").addClass("frame-qr-add");
				$("#dpf-plans-wrap").addClass("qr-frame-active");
			} else {
				$(".plan-cards-main-wrap .desktop-q-area").removeClass("frame-qr-add");
				$("#dpf-plans-wrap").removeClass("qr-frame-active");
			}
		}, 1000);
	}

	if ($(".dpf-header-wrap").children(".black-friday-full-wrap")) {
		// $(".plan-dpf-main-wrapper").addClass("isFriday"); // get Black Friday Styles
	} else {
		// $(".plan-dpf-main-wrapper").removeClass("isFriday"); // get Black Friday Styles
	}

	if ($(".plan-dpf-main-wrapper").hasClass("isFriday")) {
		$(".usd-price-wrap").addClass("d-none");
		$(".friday-price-wrap").removeClass("d-none");
		$(".friday-price-wrap").removeClass("d-block");
	} else {
		$(".usd-price-wrap").addClass("d-block");
		$(".usd-price-wrap").removeClass("d-none");
	}

	window.addEventListener('popstate', function(event) {
		isSubmit = true;
		confirmedLeave = true;
		getAlert();
		getBrowserBackAlert();
	});

	$(document).ready(function() {
		$(".dpf-spinner").hide();
	});
</script>

<?php ob_start() ?>



<?php \Altum\Event::add_content(ob_get_clean(), 'javascript') ?>