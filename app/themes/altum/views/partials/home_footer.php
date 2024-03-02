<?php defined('ALTUMCODE') || die() ?>

<?php if (\Altum\Middlewares\Authentication::check() && !isset($data->isNewLanding)) : ?>
<?php else : ?>
	<footer class="section-footer ">

		<div class="-container">

			<div class="-columns">

				<div class="-column -column-register">
					<div class="-box-register">
						<div class="-message">
							<?= l('footer.register_desc') ?>
						</div>
						<a <?= isset($data->isNewLanding) && $data->isNewLanding ? 'onclick="javascript:$(document).scrollTop(0)"' : 'href="'.url('register').'"' ?> style="cursor: pointer;" class="-link-register">
							<?= isset($data->isNewLanding) && $data->isNewLanding ? l('home.showcase.btn') : l('footer.register_btn') ?>
						</a>
					</div>
				</div>

				<div class="-column -column-slogan">
					<div>
						<img src="<?= ASSETS_FULL_URL . '/images/logo-footer.svg' ?>" alt="Online QR Generator" width="69" height="60" loading="lazy">
						<div class="-message">
							<?= l('footer.description_1') ?> <br> <?= l('footer.description_2') ?> <br> <?= l('footer.description_3') ?>
						</div>
					</div>
				</div>

				<div class="-column footer-service-order">
					<div class="sm-text-nowrap">
						<div class="-title">
							<?= l('footer.service') ?>
						</div>
						<ul>
							<li>
								<a <?= isset($data->isNewLanding) && $data->isNewLanding ? 'onclick="javascript:$(document).scrollTop(0)"' : 'href="'.url('login').'"' ?> style="cursor: pointer;" class="-link"><?= l('footer.service.create_qr') ?></a>
							</li>
							<li>
								<a href="<?= url('plans-and-prices') ?>" class="-link"><?= l('footer.service.plans') ?></a>
							</li>
							<?php if (APP_CONFIG == 'local') { ?>
								<li>
									<div class="footer-lang-dropdown">
										<a class="-link" role="button" id="lang-drop-down" style="cursor: pointer;">
											<?= l('footer.language') ?>
										</a>
										<div class="footer-lang-dropdown-menu shadow-lg" hidden>
											<ul>
												<!-- <li><a class="footer-lang-dropdown-menu-item" href="#">Action</a></li> -->
												<?php foreach (\Altum\Language::$languages as $key => $language) : ?>
													<?php if ($language['status'] == 'active') : ?>
														<li><a class="footer-lang-dropdown-menu-item" href="<?= SITE_URL . $language['code'] ?>"><?= ucfirst(strtolower($language['name'])) ?></a></li>
													<?php endif ?>
													<?php endforeach ?>
												</ul>
											</div>
										</div>
										
									</li>
									<?php } ?>
										<?php if (isset($data->isNewLanding)) { ?>
											<li>
												<a href="<?= url('login') ?>" class="-link">
													<span><?= l('home.navbar.btn.login') ?></span>
												</a>
												
											</li>
										<?php } ?>
							
							</ul>
					</div>
				</div>

				<div class="-column footer-company-order">
					<div class="sm-text-nowrap">
						<div class="-title">
							<?= l('footer.company') ?>
						</div>
						<ul>
							<li>
								<a href="<?= url('terms-and-conditions') ?>" class="-link"><?= l('footer.company.terms_cond') ?></a>
							</li>
							<li>
								<a href="<?= url('privacy-policy') ?>" class="-link"><?= l('footer.company.privacy') ?></a>
							</li>
						</ul>
					</div>
				</div>

				<div class="-column footer-help-order">
					<div>
						<div class="-title">
							<?= l('footer.help') ?>
						</div>
						<ul>

							<?php if (url(\Altum\Routing\Router::$original_request) != (url('create'))) : ?>

								<li>
									<a href="<?= url('contact') ?>" class="-link"><?= l('footer.help.contact') ?></a>
								</li>

							<?php endif ?>
							
							<li>
								<a href="<?= url('faq') ?>" class="-link"><?= l('footer.help.faq') ?></a>
							</li>
							<li>
								<a href="<?= url('cancel-subscription') ?>" class="-link"><?= l('footer.help.cancel_subscription') ?></a>
							</li>
						</ul>
					</div>
				</div>

			</div>

			<hr class="-separator">

			<div class="-copyright-trademark">
				<div>
				<?=  date("Y"); ?> © Online QR Generator <?= l('footer.copyright') ?>
				</div>
				<div>
					<?= l('footer.trademark') ?>
				</div>
			</div>

			<!-- <div class="-copyright-trademark">
			<div>
				© <?=  date("Y"); ?>  QR Code
			</div>
			<div class="-social-link-list">



            <?php foreach (require APP_PATH . 'includes/admin_socials.php' as $key => $value) : ?>
                <?php if (isset(settings()->socials->{$key}) && !empty(settings()->socials->{$key})) : ?>
                    <a href="<?= sprintf($value['format'], settings()->socials->{$key}) ?>" class="-social-link -<?= settings()->socials->{$key} ?>" target="_blank" data-toggle="tooltip" title="<?= $value['name'] ?>">
                        <img src="<?= ASSETS_FULL_URL . '/images/social/' . strtolower($value['name']) . '.svg' ?>" alt=""> 
                    </a>
                <?php endif ?>
            <?php endforeach ?>


			</div>
		</div> -->

		</div>

	</footer>
<?php endif ?>

<script>
	$(document).on('click', '.-link-register', function() {

		var event = "cta_click";
		var data = {
			"userId": null,
			"clicktext": "Register_Click",
		}
		googleDataLayer(event, data);
	});
</script>