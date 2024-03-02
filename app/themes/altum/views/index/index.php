<?php if(!$data->isNewLanding): ?>
<section class="section-main">

	<div class="-backdrop"></div>

	<div class="-container">

		<div class="-slogan -mobile"><?= l('home.hero.title.mobile') ?></div>

		<div class="-slogan -desktop"><?= l('home.hero.title.desktop') ?></div>

		<div class="-feature-list">
			<div class="-feature">
				<img src="<?= ASSETS_FULL_URL . '/images/tick-circle.svg' ?>" alt="Online QR Generator" width="20" height="20">
				<span><?= l('home.hero.feature1') ?></span>
			</div>
			<div class="-feature">
				<img src="<?= ASSETS_FULL_URL . '/images/tick-circle.svg' ?>" alt="Online QR Generator" width="20" height="20">
				<span><?= l('home.hero.feature2') ?></span>
			</div>
			<div class="-feature">
				<img src="<?= ASSETS_FULL_URL . '/images/tick-circle.svg' ?>" alt="Online QR Generator" width="20" height="20">
				<span><?= l('home.hero.feature3') ?></span>
			</div>
		</div>

		<a href="<?= url('register') ?>" class="-link-create-qr">
			<img src="<?= ASSETS_FULL_URL . 'images/scan-barcode.svg' ?>" alt="Online QR Generator">
			<span><?= l('home.hero.btn') ?></span>
		</a>
		<div class="-preview-image-row">
			<div class="-preview-image-column">
				<img src="<?= ASSETS_FULL_URL . 'images/preview-desktop.webp' ?>" alt="Online QR Generator" class="desktopz">
				<!-- <img src="<?= ASSETS_FULL_URL . 'images/preview-desktop_m.webp' ?>" alt="Online QR Generator" class="mobile"> -->
			</div>

			<div class="-preview-image-column">
				<img src="<?= ASSETS_FULL_URL . 'images/preview-mobile.png' ?>" alt="Online QR Generator" class="desktopz">
				<!-- <img src="<?= ASSETS_FULL_URL . 'images/preview-mobile_m.webp' ?>" alt="Online QR Generator" class="mobile"> -->
			</div>

		</div>
	</div>

</section>
<?php endif ?>

<section class="section-steps">

	<div class="-container">

		<div class="-section-title">
			<?= l('home.steps.title') ?>
		</div>

		<div class="-step-list">

			<div class="-step">
				<div class="-icon-wrapper-rounded-square -green">
					<div class="-icon-wrapper-circle">
						<img src="<?= ASSETS_FULL_URL . '/images/Document.svg' ?>" alt="Online QR Generator">
					</div>
				</div>
				<div class="-title">
					<?= l('home.steps.step_1.title') ?>
				</div>
				<div class="-description">
					<?= l('home.steps.step_1.description') ?>
				</div>
			</div>

			<div class="-circle-line-wrapper">
				<div class="-circle-line">
					<div class="-circle -green"></div>
					<div class="-line -green-to-purple"></div>
					<div class="-circle -purple"></div>
				</div>
			</div>

			<div class="-step">
				<div class="-icon-wrapper-rounded-square -purple">
					<div class="-icon-wrapper-circle">
						<img src="<?= ASSETS_FULL_URL . '/images/path-2.svg' ?>" alt="Online QR Generator">
					</div>
				</div>
				<div class="-title">
					<?= l('home.steps.step_2.title') ?>
				</div>
				<div class="-description">
					<?= l('home.steps.step_2.description') ?>
				</div>
			</div>

			<div class="-circle-line-wrapper">
				<div class="-circle-line">
					<div class="-circle -purple"></div>
					<div class="-line -purple-to-blue"></div>
					<div class="-circle -blue"></div>
				</div>
			</div>

			<div class="-step">
				<div class="-icon-wrapper-rounded-square -blue">
					<div class="-icon-wrapper-circle">
						<img src="<?= ASSETS_FULL_URL . '/images/printer.svg' ?>" alt="Online QR Generator">
					</div>
				</div>
				<div class="-title">
					<?= l('home.steps.step_3.title') ?>
				</div>
				<div class="-description">
					<?= l('home.steps.step_3.description') ?>
				</div>
			</div>

		</div>

	</div>

</section>

<section class="section-features">

	<div class="-container">

		<div class="-section-title">
			<?= l('home.experience.title') ?>
		</div>

		<div class="-section-description">
			<?= l('home.experience.description') ?>
		</div>

		<div class="-box-carousel owl-carousel owl-theme">

			<div class="-box">
				<div class="-icon-wrapper-rounded-square -blue">
					<img src="<?= ASSETS_FULL_URL . 'images/icon-features/scan-barcode.svg' ?>" alt="Online QR Generator" loading="lazy">
				</div>
				<div class="-title">
					<?= l('home.experience.qr.title') ?>
				</div>
				<div class="-description">
					<?= l('home.experience.qr.description') ?>
				</div>
			</div>

			<div class="-box">
				<div class="-icon-wrapper-rounded-square -green">
					<img src="<?= ASSETS_FULL_URL . 'images/icon-features/chart-square.svg' ?>" alt="Online QR Generator" loading="lazy">
				</div>
				<div class="-title">
					<?= l('home.experience.rates.title') ?>
				</div>
				<div class="-description">
					<?= l('home.experience.rates.description') ?>
				</div>
			</div>

			<div class="-box">
				<div class="-icon-wrapper-rounded-square -purple">
					<img src="<?= ASSETS_FULL_URL . 'images/icon-features/Activity.svg' ?>" alt="Online QR Generator" loading="lazy">
				</div>
				<div class="-title">
					<?= l('home.experience.analytics.title') ?>
				</div>
				<div class="-description">
					<?= l('home.experience.analytics.description') ?>
				</div>
			</div>

			<div class="-box">
				<div class="-icon-wrapper-rounded-square -orange">
					<img src="<?= ASSETS_FULL_URL . 'images/icon-features/Document.svg' ?>" alt="Online QR Generator" loading="lazy">
				</div>
				<div class="-title">
					<?= l('home.experience.pages.title') ?>
				</div>
				<div class="-description">
					<?= l('home.experience.pages.description') ?>
				</div>
			</div>

			<div class="-box">
				<div class="-icon-wrapper-rounded-square -green">
					<img src="<?= ASSETS_FULL_URL . 'images/icon-features/element-4.svg' ?>" alt="Online QR Generator" loading="lazy">
				</div>
				<div class="-title">
					<?= l('home.experience.types.title') ?>
				</div>
				<div class="-description">
					<?= l('home.experience.types.description') ?>
				</div>
			</div>

			<div class="-box">
				<div class="-icon-wrapper-rounded-square -purple">
					<img src="<?= ASSETS_FULL_URL . 'images/icon-features/pen-tool.svg' ?>" alt="Online QR Generator" loading="lazy">
				</div>
				<div class="-title">
					<?= l('home.experience.customization.title') ?>
				</div>
				<div class="-description">
					<?= l('home.experience.customization.description') ?>
				</div>
			</div>

			<div class="-box">
				<div class="-icon-wrapper-rounded-square -orange">
					<img src="<?= ASSETS_FULL_URL . 'images/icon-features/receive-square.svg' ?>" alt="Online QR Generator" loading="lazy">
				</div>
				<div class="-title">
					<?= l('home.experience.download.title') ?>
				</div>
				<div class="-description">
					<?= l('home.experience.download.description') ?>
				</div>
			</div>

			<div class="-box">
				<div class="-icon-wrapper-rounded-square -blue">
					<img src="<?= ASSETS_FULL_URL . 'images/icon-features/dollar-circle.svg' ?>" alt="Online QR Generator" loading="lazy">
				</div>
				<div class="-title">
					<?= l('home.experience.get_started.title') ?>
				</div>
				<div class="-description">
					<?= l('home.experience.get_started.description') ?>
				</div>
			</div>

		</div>

		<div class="-box-list">

			<div class="-box">
				<div class="-icon-wrapper-rounded-square -blue">
					<img src="<?= ASSETS_FULL_URL . 'images/icon-features/scan-barcode.svg' ?>" alt="Online QR Generator" loading="lazy">
				</div>
				<div class="-title">
					<?= l('home.experience.qr.title') ?>
				</div>
				<div class="-description">
					<?= l('home.experience.qr.description') ?>
				</div>
			</div>

			<div class="-box">
				<div class="-icon-wrapper-rounded-square -green">
					<img src="<?= ASSETS_FULL_URL . 'images/icon-features/chart-square.svg' ?>" alt="Online QR Generator" loading="lazy">
				</div>
				<div class="-title">
					<?= l('home.experience.rates.title') ?>
				</div>
				<div class="-description">
					<?= l('home.experience.rates.description') ?>
				</div>
			</div>

			<div class="-box">
				<div class="-icon-wrapper-rounded-square -purple">
					<img src="<?= ASSETS_FULL_URL . 'images/icon-features/Activity.svg' ?>" alt="Online QR Generator" loading="lazy">
				</div>
				<div class="-title">
					<?= l('home.experience.analytics.title') ?>
				</div>
				<div class="-description">
					<?= l('home.experience.analytics.description') ?>
				</div>
			</div>

			<div class="-box">
				<div class="-icon-wrapper-rounded-square -orange">
					<img src="<?= ASSETS_FULL_URL . 'images/icon-features/Document.svg' ?>" alt="Online QR Generator" loading="lazy">
				</div>
				<div class="-title">
					<?= l('home.experience.pages.title') ?>
				</div>
				<div class="-description">
					<?= l('home.experience.pages.description') ?>
				</div>
			</div>

			<div class="-box">
				<div class="-icon-wrapper-rounded-square -green">
					<img src="<?= ASSETS_FULL_URL . 'images/icon-features/element-4.svg' ?>" alt="Online QR Generator" loading="lazy">
				</div>
				<div class="-title">
					<?= l('home.experience.types.title') ?>
				</div>
				<div class="-description">
					<?= l('home.experience.types.description') ?>
				</div>
			</div>

			<div class="-box">
				<div class="-icon-wrapper-rounded-square -purple">
					<img src="<?= ASSETS_FULL_URL . 'images/icon-features/pen-tool.svg' ?>" alt="Online QR Generator" loading="lazy">
				</div>
				<div class="-title">
					<?= l('home.experience.customization.title') ?>
				</div>
				<div class="-description">
					<?= l('home.experience.customization.description') ?>
				</div>
			</div>

			<div class="-box">
				<div class="-icon-wrapper-rounded-square -orange">
					<img src="<?= ASSETS_FULL_URL . 'images/icon-features/receive-square.svg' ?>" alt="Online QR Generator" loading="lazy">
				</div>
				<div class="-title">
					<?= l('home.experience.download.title') ?>
				</div>
				<div class="-description">
					<?= l('home.experience.download.description') ?>
				</div>
			</div>

			<div class="-box">
				<div class="-icon-wrapper-rounded-square -blue">
					<img src="<?= ASSETS_FULL_URL . 'images/icon-features/dollar-circle.svg' ?>" alt="Online QR Generator" loading="lazy">
				</div>
				<div class="-title">
					<?= l('home.experience.get_started.title') ?>
				</div>
				<div class="-description">
					<?= l('home.experience.get_started.description') ?>
				</div>
			</div>

		</div>

	</div>

</section>

<?php
	$qrTypesShowcase = [
		'qrTypeList'=>[
			['vcards','vcard_plus.png',l('home.showcase.vcard')],
			['website','web_page.png',l('home.showcase.website')],
			['pdf','pdf.png',l('home.showcase.pdf')],
			['images','images.png',l('home.showcase.images')],
			['video','video.png',l('home.showcase.video')],
			['wifi','wifi.png',l('home.showcase.wifi')],
			['menus','menu.png',l('home.showcase.menu')],
			['business','business.png',l('home.showcase.business')],
			['mp3s','mp3.png',l('home.showcase.mp3')],
			['applications','app.png',l('home.showcase.apps')],
			['links','linklist.png',l('home.showcase.links')],
			['coupons','coupon.png',l('home.showcase.coupon')],
		],
		'qrTypeShow'=>[
			['vcards','vCard_preview.webp',l('home.showcase.vcard.title'),l('home.showcase.vcard.description')],
			['website','website_preview.webp',l('home.showcase.website.title'),l('home.showcase.website.description')],
			['menus','menu_preview.webp',l('home.showcase.menu.title'),l('home.showcase.menu.description')],
			['business','business_preview.webp',l('home.showcase.business.title'),l('home.showcase.business.description')],
			['applications','apps_preview.webp',l('home.showcase.apps.title'),l('home.showcase.apps.description')],
			['wifi','Wifi_preview.webp',l('home.showcase.wifi.title'),l('home.showcase.wifi.description')],
			['video','video_preview.webp',l('home.showcase.video.title'),l('home.showcase.video.description')],
			['pdf','PDF_preview.webp',l('home.showcase.pdf.title'),l('home.showcase.pdf.description')],
			['images','Images_preview.webp',l('home.showcase.images.title'),l('home.showcase.images.description')],
			['links','links_preview.webp',l('home.showcase.links.title'),l('home.showcase.links.description')],
			['mp3s','mp3_preview.webp',l('home.showcase.mp3.title'),l('home.showcase.mp3.description')],
			['coupons','coupon_preview.webp',l('home.showcase.coupon.title'),l('home.showcase.coupon.description')],
		]
	]
?>

<section class="section-qr-types">

	<div class="-container" style="max-width: 1170px; margin: 0 auto; padding: 0 16px;">

		<div class="-section-title">
			<?= l('home.showcase.title') ?>
		</div>

		<div class="-section-description">
			<?= l('home.showcase.description') ?>
		</div>

		<div class="-columns">

			<div class="-column -qr-type-list-wrapper">

				<div class="-qr-type-list">

				<?php foreach($qrTypesShowcase['qrTypeList'] as $row=>$qrType) : ?>
					<div class="-qr-type -fill <?= $row === 0 ? '-active' : null ?>" data-target="#qr-type-info-<?=$qrType[0]?>">
						<div class="-icon-wrapper-circle">
							<img src="<?= ASSETS_FULL_URL . '/images/steps-icons/'.$qrType[1] ?>" alt="<?=$qrType[0]?>" style="filter: grayscale(100%);" loading="lazy">
						</div>
						<div>
							<?= $qrType[2] ?>
						</div>
					</div>
				<?php endforeach ?>
				</div>
			</div>

			<div class="-column">

			<?php foreach($qrTypesShowcase['qrTypeShow'] as $row => $qrShow) : ?>
				<div id="qr-type-info-<?=$qrShow[0]?>" class="-qr-type-info <?= $row === 0 ? '-show' : null ?>">

					<div class="-qr-type-image-cards-wrapper">
						<img src="<?= ASSETS_FULL_URL . '/images/Group 1362788781.svg' ?>" alt="Online QR Generator" loading="lazy">
						<div class="-qr-type-image-wrapper">
							<img src="<?= ASSETS_FULL_URL . '/images/qr-preview/home/'.$qrShow[1] ?>" alt="Online QR Generator" class="fluid-images -qr-type-image" loading="lazy">
						</div>
					</div>

					<div class="-qr-type-title">
						<?= $qrShow[2] ?>
					</div>

					<div class="-qr-type-description">
						<?= $qrShow[3] ?>
					</div>

					<a <?= $data->isNewLanding ? 'onclick="javascript:$(document).scrollTop(0)"' : 'href="'.url('register').'"' ?> class="-link-create-qr" style="cursor: pointer;" rel="nofollow">
						<img src="<?= ASSETS_FULL_URL . '/images/qr-code.svg' ?>" alt="Online QR Generator">
						<span><?= l('home.showcase.btn') ?></span>
					</a>

				</div>
			<?php endforeach ?>
			</div>

		</div>

	</div>

</section>

<section class="section-concepts">

	<div class="-container">

		<div class="-section-title">
			<?= l('home.concepts.title') ?>
		</div>

		<div class="-question-answer-list accordion">

			<div class="-question-answer -accordion-item">
				<div tabindex="0" class="-question -accordion-toggler">
					<span><?= l('home.concepts.qr_code.title') ?></span>
					<img src="<?= ASSETS_FULL_URL . '/images/chevron.svg' ?>" class="-accordion-icon" alt="Online QR Generator">
				</div>
				<div class="-answer -accordion-panel">
					<div class="-accordion-panel-box">
						<?= l('home.concepts.qr_code.description') ?>
					</div>
				</div>
			</div>

			<div class="-question-answer -accordion-item">
				<div tabindex="0" class="-question -accordion-toggler">
					<span><?= l('home.concepts.qr_free.title') ?></span>
					<img src="<?= ASSETS_FULL_URL . '/images/chevron.svg' ?>" class="-accordion-icon" alt="Online QR Generator">
				</div>
				<div class="-answer -accordion-panel">
					<div class="-accordion-panel-box">
						<?= l('home.concepts.qr_free.description') ?>
					</div>
				</div>
			</div>

			<div class="-question-answer -accordion-item">
				<div tabindex="0" class="-question -accordion-toggler">
					<span><?= l('home.concepts.qr_create.title') ?></span>
					<img src="<?= ASSETS_FULL_URL . '/images/chevron.svg' ?>" class="-accordion-icon" alt="Online QR Generator">
				</div>
				<div class="-answer -accordion-panel">
					<div class="-accordion-panel-box">
						<?= l('home.concepts.qr_create.description') ?>
					</div>
				</div>
			</div>

			<div class="-question-answer -accordion-item">
				<div tabindex="0" class="-question -accordion-toggler">
					<span><?= l('home.concepts.offering.title') ?></span>
					<img src="<?= ASSETS_FULL_URL . '/images/chevron.svg' ?>" class="-accordion-icon" alt="Online QR Generator">
				</div>
				<div class="-answer -accordion-panel">
					<div class="-accordion-panel-box">
						<?= l('home.concepts.offering.description') ?>
					</div>
				</div>
			</div>

			<div class="-question-answer -accordion-item">
				<div tabindex="0" class="-question -accordion-toggler">
					<span><?= l('home.concepts.commercial.title') ?></span>
					<img src="<?= ASSETS_FULL_URL . '/images/chevron.svg' ?>" class="-accordion-icon" alt="Online QR Generator">
				</div>
				<div class="-answer -accordion-panel">
					<div class="-accordion-panel-box">
						<?= l('home.concepts.commercial.description') ?>
					</div>
				</div>
			</div>

			<div class="-question-answer -accordion-item">
				<div tabindex="0" class="-question -accordion-toggler">
					<span><?= l('home.concepts.information.title') ?></span>
					<img src="<?= ASSETS_FULL_URL . '/images/chevron.svg' ?>" class="-accordion-icon" alt="Online QR Generator">
				</div>
				<div class="-answer -accordion-panel">
					<div class="-accordion-panel-box">
						<?= l('home.concepts.information.description') ?>
					</div>
				</div>
			</div>

			<div class="-question-answer -accordion-item">
				<div tabindex="0" class="-question -accordion-toggler">
					<span><?= l('home.concepts.expire.title') ?></span>
					<img src="<?= ASSETS_FULL_URL . '/images/chevron.svg' ?>" class="-accordion-icon" alt="Online QR Generator">
				</div>
				<div class="-answer -accordion-panel">
					<div class="-accordion-panel-box">
						<?= l('home.concepts.expire.description') ?>
					</div>
				</div>
			</div>

			<div class="-question-answer -accordion-item">
				<div tabindex="0" class="-question -accordion-toggler">
					<span><?= l('home.concepts.difference.title') ?></span>
					<img src="<?= ASSETS_FULL_URL . '/images/chevron.svg' ?>" class="-accordion-icon" alt="Online QR Generator">
				</div>
				<div class="-answer -accordion-panel">
					<div class="-accordion-panel-box">
						<?= l('home.concepts.difference.description') ?>
					</div>
				</div>
			</div>

			<div class="-question-answer -accordion-item">
				<div tabindex="0" class="-question -accordion-toggler">
					<span><?= l('home.concepts.manage.title') ?></span>
					<img src="<?= ASSETS_FULL_URL . '/images/chevron.svg' ?>" class="-accordion-icon" alt="Online QR Generator">
				</div>
				<div class="-answer -accordion-panel">
					<div class="-accordion-panel-box">
						<?= l('home.concepts.manage.description') ?>
					</div>
				</div>
			</div>

		</div>

		<div class="-question-answer-grid">

			<div class="-question-answer">
				<div class="-icon-wrapper-circle">
					<span class="-fill">

						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<g clip-path="url(#clip0_411_43188)">
								<path d="M2 9.75C1.59 9.75 1.25 9.41 1.25 9V6.5C1.25 3.6 3.61 1.25 6.5 1.25H9C9.41 1.25 9.75 1.59 9.75 2C9.75 2.41 9.41 2.75 9 2.75H6.5C4.43 2.75 2.75 4.43 2.75 6.5V9C2.75 9.41 2.41 9.75 2 9.75Z" fill="white" />
								<path d="M22 9.75C21.59 9.75 21.25 9.41 21.25 9V6.5C21.25 4.43 19.57 2.75 17.5 2.75H15C14.59 2.75 14.25 2.41 14.25 2C14.25 1.59 14.59 1.25 15 1.25H17.5C20.39 1.25 22.75 3.6 22.75 6.5V9C22.75 9.41 22.41 9.75 22 9.75Z" fill="white" />
								<path d="M17.5 22.75H16C15.59 22.75 15.25 22.41 15.25 22C15.25 21.59 15.59 21.25 16 21.25H17.5C19.57 21.25 21.25 19.57 21.25 17.5V16C21.25 15.59 21.59 15.25 22 15.25C22.41 15.25 22.75 15.59 22.75 16V17.5C22.75 20.4 20.39 22.75 17.5 22.75Z" fill="white" />
								<path d="M9 22.75H6.5C3.61 22.75 1.25 20.4 1.25 17.5V15C1.25 14.59 1.59 14.25 2 14.25C2.41 14.25 2.75 14.59 2.75 15V17.5C2.75 19.57 4.43 21.25 6.5 21.25H9C9.41 21.25 9.75 21.59 9.75 22C9.75 22.41 9.41 22.75 9 22.75Z" fill="white" />
								<path d="M9 11.25H7C5.59 11.25 4.75 10.41 4.75 9V7C4.75 5.59 5.59 4.75 7 4.75H9C10.41 4.75 11.25 5.59 11.25 7V9C11.25 10.41 10.41 11.25 9 11.25ZM7 6.25C6.41 6.25 6.25 6.41 6.25 7V9C6.25 9.59 6.41 9.75 7 9.75H9C9.59 9.75 9.75 9.59 9.75 9V7C9.75 6.41 9.59 6.25 9 6.25H7Z" fill="white" />
								<path d="M17 11.25H15C13.59 11.25 12.75 10.41 12.75 9V7C12.75 5.59 13.59 4.75 15 4.75H17C18.41 4.75 19.25 5.59 19.25 7V9C19.25 10.41 18.41 11.25 17 11.25ZM15 6.25C14.41 6.25 14.25 6.41 14.25 7V9C14.25 9.59 14.41 9.75 15 9.75H17C17.59 9.75 17.75 9.59 17.75 9V7C17.75 6.41 17.59 6.25 17 6.25H15Z" fill="white" />
								<path d="M9 19.25H7C5.59 19.25 4.75 18.41 4.75 17V15C4.75 13.59 5.59 12.75 7 12.75H9C10.41 12.75 11.25 13.59 11.25 15V17C11.25 18.41 10.41 19.25 9 19.25ZM7 14.25C6.41 14.25 6.25 14.41 6.25 15V17C6.25 17.59 6.41 17.75 7 17.75H9C9.59 17.75 9.75 17.59 9.75 17V15C9.75 14.41 9.59 14.25 9 14.25H7Z" fill="white" />
								<path d="M17 19.25H15C13.59 19.25 12.75 18.41 12.75 17V15C12.75 13.59 13.59 12.75 15 12.75H17C18.41 12.75 19.25 13.59 19.25 15V17C19.25 18.41 18.41 19.25 17 19.25ZM15 14.25C14.41 14.25 14.25 14.41 14.25 15V17C14.25 17.59 14.41 17.75 15 17.75H17C17.59 17.75 17.75 17.59 17.75 17V15C17.75 14.41 17.59 14.25 17 14.25H15Z" fill="white" />
							</g>
							<defs>
								<clipPath id="clip0_411_43188">
									<rect width="24" height="24" fill="white" />
								</clipPath>
							</defs>
						</svg>

					</span>
				</div>
				<div class="-question">
					<?= l('home.concepts.qr_code.title') ?>
				</div>
				<div class="-answer">
					<?= l('home.concepts.qr_code.description') ?>
				</div>
				<a href="#" class="-read-more" rel="nofollow"><?= l('home.concepts.read_more') ?></a>
			</div>

			<div class="-question-answer">
				<div class="-icon-wrapper-circle">
					<span class="-stroke">

						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M8.67188 14.3298C8.67188 15.6198 9.66188 16.6598 10.8919 16.6598H13.4019C14.4719 16.6598 15.3419 15.7498 15.3419 14.6298C15.3419 13.4098 14.8119 12.9798 14.0219 12.6998L9.99187 11.2998C9.20187 11.0198 8.67188 10.5898 8.67188 9.36984C8.67188 8.24984 9.54187 7.33984 10.6119 7.33984H13.1219C14.3519 7.33984 15.3419 8.37984 15.3419 9.66984" stroke="#767C83" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
							<path d="M12 6V18" stroke="#767C83" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
							<path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="#767C83" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
						</svg>

					</span>
				</div>
				<div class="-question">
					<?= l('home.concepts.qr_free.title') ?>
				</div>
				<div class="-answer">
					<?= l('home.concepts.qr_free.description') ?>
				</div>
				<a href="#" class="-read-more" rel="nofollow"><?= l('home.concepts.read_more') ?></a>
			</div>

			<div class="-question-answer">
				<div class="-icon-wrapper-circle">
					<span class="-fill-on-hover -stroke">

						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<g clip-path="url(#clip0_411_43157)">
								<path d="M1.1 9.00195C1.1 9.4948 1.50716 9.90195 2 9.90195C2.49284 9.90195 2.9 9.4948 2.9 9.00195V6.50195C2.9 4.5148 4.51284 2.90195 6.5 2.90195H9C9.49284 2.90195 9.9 2.4948 9.9 2.00195C9.9 1.50911 9.49284 1.10195 9 1.10195H6.5C3.52734 1.10195 1.1 3.51892 1.1 6.50195V9.00195Z" fill="#767C83" stroke="#767C83" stroke-width="0.3" />
								<path d="M21.1 9.00195C21.1 9.4948 21.5072 9.90195 22 9.90195C22.4928 9.90195 22.9 9.4948 22.9 9.00195V6.50195C22.9 3.51892 20.4727 1.10195 17.5 1.10195H15C14.5072 1.10195 14.1 1.50911 14.1 2.00195C14.1 2.4948 14.5072 2.90195 15 2.90195H17.5C19.4872 2.90195 21.1 4.5148 21.1 6.50195V9.00195Z" fill="#767C83" stroke="#767C83" stroke-width="0.3" />
								<path d="M16 22.898H17.5C20.4727 22.898 22.9 20.4811 22.9 17.498V15.998C22.9 15.5052 22.4928 15.098 22 15.098C21.5072 15.098 21.1 15.5052 21.1 15.998V17.498C21.1 19.4852 19.4872 21.098 17.5 21.098H16C15.5072 21.098 15.1 21.5052 15.1 21.998C15.1 22.4909 15.5072 22.898 16 22.898Z" fill="#767C83" stroke="#767C83" stroke-width="0.3" />
								<path d="M6.5 22.9H9C9.49284 22.9 9.9 22.4928 9.9 22C9.9 21.5072 9.49284 21.1 9 21.1H6.5C4.51284 21.1 2.9 19.4872 2.9 17.5V15C2.9 14.5072 2.49284 14.1 2 14.1C1.50716 14.1 1.1 14.5072 1.1 15V17.5C1.1 20.483 3.52734 22.9 6.5 22.9Z" fill="#767C83" stroke="#767C83" stroke-width="0.3" />
								<path d="M7 12.777H17C17.4245 12.777 17.775 12.4265 17.775 12.002C17.775 11.5774 17.4245 11.227 17 11.227H7C6.57549 11.227 6.225 11.5774 6.225 12.002C6.225 12.4265 6.57549 12.777 7 12.777Z" fill="#767C83" stroke="#767C83" stroke-width="0.3" />
								<path d="M11.225 17C11.225 17.4245 11.5755 17.775 12 17.775C12.4245 17.775 12.775 17.4245 12.775 17V7C12.775 6.57549 12.4245 6.225 12 6.225C11.5755 6.225 11.225 6.57549 11.225 7V17Z" fill="#767C83" stroke="#767C83" stroke-width="0.3" />
							</g>
							<defs>
								<clipPath id="clip0_411_43157">
									<rect width="24" height="24" fill="white" />
								</clipPath>
							</defs>
						</svg>

					</span>
				</div>
				<div class="-question">
					<?= l('home.concepts.qr_create.title') ?>
				</div>
				<div class="-answer">
					<?= l('home.concepts.qr_create.description') ?>
				</div>
				<a href="#" class="-read-more" rel="nofollow"><?= l('home.concepts.read_more') ?></a>
			</div>

			<div class="-question-answer">
				<div class="-icon-wrapper-circle -fill">
					<span class="-fill">

						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M17 20.75H7C2.59 20.75 1.25 19.41 1.25 15V14.5C1.25 14.09 1.59 13.75 2 13.75C2.96 13.75 3.75 12.96 3.75 12C3.75 11.04 2.96 10.25 2 10.25C1.59 10.25 1.25 9.91 1.25 9.5V9C1.25 4.59 2.59 3.25 7 3.25H17C21.41 3.25 22.75 4.59 22.75 9V10C22.75 10.41 22.41 10.75 22 10.75C21.04 10.75 20.25 11.54 20.25 12.5C20.25 13.46 21.04 14.25 22 14.25C22.41 14.25 22.75 14.59 22.75 15C22.75 19.41 21.41 20.75 17 20.75ZM2.75 15.16C2.77 18.6 3.48 19.25 7 19.25H17C20.34 19.25 21.15 18.66 21.24 15.66C19.81 15.32 18.75 14.03 18.75 12.5C18.75 10.97 19.82 9.68 21.25 9.34V9C21.25 5.43 20.58 4.75 17 4.75H7C3.48 4.75 2.77 5.4 2.75 8.84C4.18 9.18 5.25 10.47 5.25 12C5.25 13.53 4.18 14.82 2.75 15.16Z" fill="#767C83" />
							<path d="M10 7.25C9.59 7.25 9.25 6.91 9.25 6.5V4C9.25 3.59 9.59 3.25 10 3.25C10.41 3.25 10.75 3.59 10.75 4V6.5C10.75 6.91 10.41 7.25 10 7.25Z" fill="#767C83" />
							<path d="M10 14.5802C9.59 14.5802 9.25 14.2402 9.25 13.8302V10.1602C9.25 9.75016 9.59 9.41016 10 9.41016C10.41 9.41016 10.75 9.75016 10.75 10.1602V13.8302C10.75 14.2502 10.41 14.5802 10 14.5802Z" fill="#767C83" />
							<path d="M10 20.75C9.59 20.75 9.25 20.41 9.25 20V17.5C9.25 17.09 9.59 16.75 10 16.75C10.41 16.75 10.75 17.09 10.75 17.5V20C10.75 20.41 10.41 20.75 10 20.75Z" fill="#767C83" />
						</svg>

					</span>
				</div>
				<div class="-question">
					<?= l('home.concepts.offering.title') ?>
				</div>
				<div class="-answer">
					<?= l('home.concepts.offering.description') ?>
				</div>
				<a href="#" class="-read-more" rel="nofollow"><?= l('home.concepts.read_more') ?></a>
			</div>

			<div class="-question-answer">
				<div class="-icon-wrapper-circle">
					<span class="-stroke">

						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M8.67188 14.3298C8.67188 15.6198 9.66188 16.6598 10.8919 16.6598H13.4019C14.4719 16.6598 15.3419 15.7498 15.3419 14.6298C15.3419 13.4098 14.8119 12.9798 14.0219 12.6998L9.99187 11.2998C9.20187 11.0198 8.67188 10.5898 8.67188 9.36984C8.67188 8.24984 9.54187 7.33984 10.6119 7.33984H13.1219C14.3519 7.33984 15.3419 8.37984 15.3419 9.66984" stroke="#767C83" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
							<path d="M12 6V18" stroke="#767C83" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
							<path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="#767C83" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
						</svg>

					</span>
				</div>
				<div class="-question">
					<?= l('home.concepts.commercial.title') ?>
				</div>
				<div class="-answer">
					<?= l('home.concepts.commercial.description') ?>
				</div>
				<a href="#" class="-read-more" rel="nofollow"><?= l('home.concepts.read_more') ?></a>
			</div>

			<div class="-question-answer">
				<div class="-icon-wrapper-circle">
					<span class="-fill-on-hover">

						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path fill-rule="evenodd" clip-rule="evenodd" d="M15.7122 16.9736H8.49219C8.07819 16.9736 7.74219 16.6376 7.74219 16.2236C7.74219 15.8096 8.07819 15.4736 8.49219 15.4736H15.7122C16.1262 15.4736 16.4622 15.8096 16.4622 16.2236C16.4622 16.6376 16.1262 16.9736 15.7122 16.9736Z" fill="#767C83" />
							<path fill-rule="evenodd" clip-rule="evenodd" d="M15.7122 12.7871H8.49219C8.07819 12.7871 7.74219 12.4511 7.74219 12.0371C7.74219 11.6231 8.07819 11.2871 8.49219 11.2871H15.7122C16.1262 11.2871 16.4622 11.6231 16.4622 12.0371C16.4622 12.4511 16.1262 12.7871 15.7122 12.7871Z" fill="#767C83" />
							<path fill-rule="evenodd" clip-rule="evenodd" d="M11.2472 8.61035H8.49219C8.07819 8.61035 7.74219 8.27435 7.74219 7.86035C7.74219 7.44635 8.07819 7.11035 8.49219 7.11035H11.2472C11.6612 7.11035 11.9972 7.44635 11.9972 7.86035C11.9972 8.27435 11.6612 8.61035 11.2472 8.61035Z" fill="#767C83" />
							<mask id="mask0_411_43174" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="3" y="2" width="19" height="20">
								<path fill-rule="evenodd" clip-rule="evenodd" d="M3 2H21.1647V21.9098H3V2Z" fill="white" />
							</mask>
							<g mask="url(#mask0_411_43174)">
								<path fill-rule="evenodd" clip-rule="evenodd" d="M15.909 3.5L8.22 3.504C5.892 3.518 4.5 4.958 4.5 7.357V16.553C4.5 18.968 5.905 20.41 8.256 20.41L15.945 20.407C18.273 20.393 19.665 18.951 19.665 16.553V7.357C19.665 4.942 18.261 3.5 15.909 3.5ZM8.257 21.91C5.113 21.91 3 19.757 3 16.553V7.357C3 4.124 5.047 2.023 8.215 2.004L15.908 2H15.909C19.053 2 21.165 4.153 21.165 7.357V16.553C21.165 19.785 19.118 21.887 15.95 21.907L8.257 21.91Z" fill="#767C83" />
							</g>
						</svg>

					</span>

				</div>
				<div class="-question">
					<?= l('home.concepts.information.title') ?>
				</div>
				<div class="-answer">
					<?= l('home.concepts.information.description') ?>
				</div>
				<a href="#" class="-read-more" rel="nofollow"><?= l('home.concepts.read_more') ?></a>
			</div>

			<div class="-question-answer">
				<div class="-icon-wrapper-circle">
					<span class="-fill-on-hover">

						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path fill-rule="evenodd" clip-rule="evenodd" d="M20.6677 9.9043H2.84375C2.42975 9.9043 2.09375 9.5683 2.09375 9.1543C2.09375 8.7403 2.42975 8.4043 2.84375 8.4043H20.6677C21.0817 8.4043 21.4177 8.7403 21.4177 9.1543C21.4177 9.5683 21.0817 9.9043 20.6677 9.9043Z" fill="#767C83" />
							<path fill-rule="evenodd" clip-rule="evenodd" d="M16.1993 13.8096C15.7853 13.8096 15.4453 13.4736 15.4453 13.0596C15.4453 12.6456 15.7763 12.3096 16.1903 12.3096H16.1993C16.6133 12.3096 16.9493 12.6456 16.9493 13.0596C16.9493 13.4736 16.6133 13.8096 16.1993 13.8096Z" fill="#767C83" />
							<path fill-rule="evenodd" clip-rule="evenodd" d="M11.7618 13.8096C11.3478 13.8096 11.0078 13.4736 11.0078 13.0596C11.0078 12.6456 11.3388 12.3096 11.7528 12.3096H11.7618C12.1758 12.3096 12.5118 12.6456 12.5118 13.0596C12.5118 13.4736 12.1758 13.8096 11.7618 13.8096Z" fill="#767C83" />
							<path fill-rule="evenodd" clip-rule="evenodd" d="M7.3175 13.8096C6.9035 13.8096 6.5625 13.4736 6.5625 13.0596C6.5625 12.6456 6.8945 12.3096 7.3085 12.3096H7.3175C7.7315 12.3096 8.0675 12.6456 8.0675 13.0596C8.0675 13.4736 7.7315 13.8096 7.3175 13.8096Z" fill="#767C83" />
							<path fill-rule="evenodd" clip-rule="evenodd" d="M16.1993 17.6963C15.7853 17.6963 15.4453 17.3603 15.4453 16.9463C15.4453 16.5323 15.7763 16.1963 16.1903 16.1963H16.1993C16.6133 16.1963 16.9493 16.5323 16.9493 16.9463C16.9493 17.3603 16.6133 17.6963 16.1993 17.6963Z" fill="#767C83" />
							<path fill-rule="evenodd" clip-rule="evenodd" d="M11.7618 17.6963C11.3478 17.6963 11.0078 17.3603 11.0078 16.9463C11.0078 16.5323 11.3388 16.1963 11.7528 16.1963H11.7618C12.1758 16.1963 12.5118 16.5323 12.5118 16.9463C12.5118 17.3603 12.1758 17.6963 11.7618 17.6963Z" fill="#767C83" />
							<path fill-rule="evenodd" clip-rule="evenodd" d="M7.3175 17.6963C6.9035 17.6963 6.5625 17.3603 6.5625 16.9463C6.5625 16.5323 6.8945 16.1963 7.3085 16.1963H7.3175C7.7315 16.1963 8.0675 16.5323 8.0675 16.9463C8.0675 17.3603 7.7315 17.6963 7.3175 17.6963Z" fill="#767C83" />
							<path fill-rule="evenodd" clip-rule="evenodd" d="M15.7969 5.791C15.3829 5.791 15.0469 5.455 15.0469 5.041V1.75C15.0469 1.336 15.3829 1 15.7969 1C16.2109 1 16.5469 1.336 16.5469 1.75V5.041C16.5469 5.455 16.2109 5.791 15.7969 5.791Z" fill="#767C83" />
							<path fill-rule="evenodd" clip-rule="evenodd" d="M7.71875 5.791C7.30475 5.791 6.96875 5.455 6.96875 5.041V1.75C6.96875 1.336 7.30475 1 7.71875 1C8.13275 1 8.46875 1.336 8.46875 1.75V5.041C8.46875 5.455 8.13275 5.791 7.71875 5.791Z" fill="#767C83" />
							<mask id="mask0_411_43129" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="2" y="2" width="20" height="21">
								<path fill-rule="evenodd" clip-rule="evenodd" d="M2 2.5791H21.5V22.5H2V2.5791Z" fill="white" />
							</mask>
							<g mask="url(#mask0_411_43129)">
								<path fill-rule="evenodd" clip-rule="evenodd" d="M7.521 4.0791C4.928 4.0791 3.5 5.4621 3.5 7.9731V17.0221C3.5 19.5881 4.928 21.0001 7.521 21.0001H15.979C18.572 21.0001 20 19.6141 20 17.0981V7.9731C20.004 6.7381 19.672 5.7781 19.013 5.1181C18.335 4.4381 17.29 4.0791 15.988 4.0791H7.521ZM15.979 22.5001H7.521C4.116 22.5001 2 20.4011 2 17.0221V7.9731C2 4.6451 4.116 2.5791 7.521 2.5791H15.988C17.697 2.5791 19.11 3.0911 20.075 4.0581C21.012 4.9991 21.505 6.3521 21.5 7.9751V17.0981C21.5 20.4301 19.384 22.5001 15.979 22.5001Z" fill="#767C83" />
							</g>
						</svg>

					</span>
				</div>
				<div class="-question">
					<?= l('home.concepts.expire.title') ?>
				</div>
				<div class="-answer">
					<?= l('home.concepts.expire.description') ?>
				</div>
				<a href="#" class="-read-more" rel="nofollow"><?= l('home.concepts.read_more') ?></a>
			</div>

			<div class="-question-answer">
				<div class="-icon-wrapper-circle">
					<span class="-fill-on-hover">

						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path fill-rule="evenodd" clip-rule="evenodd" d="M7.21848 16.0026C7.05848 16.0026 6.89748 15.9516 6.76148 15.8476C6.43348 15.5946 6.37148 15.1236 6.62448 14.7956L9.61748 10.9056C9.73948 10.7466 9.92048 10.6436 10.1185 10.6186C10.3205 10.5926 10.5185 10.6486 10.6755 10.7736L13.4955 12.9886L15.9625 9.80562C16.2165 9.47662 16.6865 9.41562 17.0145 9.67162C17.3425 9.92562 17.4025 10.3966 17.1485 10.7236L14.2185 14.5036C14.0965 14.6616 13.9165 14.7646 13.7185 14.7886C13.5185 14.8156 13.3205 14.7576 13.1625 14.6346L10.3445 12.4206L7.81348 15.7096C7.66548 15.9016 7.44348 16.0026 7.21848 16.0026Z" fill="#767C83" />
							<mask id="mask0_411_43150" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="17" y="2" width="6" height="6">
								<path fill-rule="evenodd" clip-rule="evenodd" d="M17.2969 2H22.6409V7.3449H17.2969V2Z" fill="white" />
							</mask>
							<g mask="url(#mask0_411_43150)">
								<path fill-rule="evenodd" clip-rule="evenodd" d="M19.9689 3.5C19.3229 3.5 18.7969 4.025 18.7969 4.672C18.7969 5.318 19.3229 5.845 19.9689 5.845C20.6149 5.845 21.1409 5.318 21.1409 4.672C21.1409 4.025 20.6149 3.5 19.9689 3.5ZM19.9689 7.345C18.4959 7.345 17.2969 6.146 17.2969 4.672C17.2969 3.198 18.4959 2 19.9689 2C21.4429 2 22.6409 3.198 22.6409 4.672C22.6409 6.146 21.4429 7.345 19.9689 7.345Z" fill="#767C83" />
							</g>
							<mask id="mask1_411_43150" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="2" y="2" width="20" height="21">
								<path fill-rule="evenodd" clip-rule="evenodd" d="M2 2.8418H21.8619V22.7028H2V2.8418Z" fill="white" />
							</mask>
							<g mask="url(#mask1_411_43150)">
								<path fill-rule="evenodd" clip-rule="evenodd" d="M16.233 22.7028H7.629C4.262 22.7028 2 20.3378 2 16.8178V8.7358C2 5.2108 4.262 2.8418 7.629 2.8418H14.897C15.311 2.8418 15.647 3.1778 15.647 3.5918C15.647 4.0058 15.311 4.3418 14.897 4.3418H7.629C5.121 4.3418 3.5 6.0658 3.5 8.7358V16.8178C3.5 19.5228 5.082 21.2028 7.629 21.2028H16.233C18.741 21.2028 20.362 19.4818 20.362 16.8178V9.7788C20.362 9.3648 20.698 9.0288 21.112 9.0288C21.526 9.0288 21.862 9.3648 21.862 9.7788V16.8178C21.862 20.3378 19.6 22.7028 16.233 22.7028Z" fill="#767C83" />
							</g>
						</svg>

					</span>
				</div>
				<div class="-question">
					<?= l('home.concepts.difference.title') ?>
				</div>
				<div class="-answer">
					<?= l('home.concepts.difference.description') ?>
				</div>
				<a href="#" class="-read-more" rel="nofollow"><?= l('home.concepts.read_more') ?></a>
			</div>

			<div class="-question-answer">
				<div class="-icon-wrapper-circle">
					<span class="-fill">

						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M12.0022 22.6298C11.3322 22.6298 10.6522 22.4798 10.1222 22.1698L4.62219 18.9998C2.38219 17.4898 2.24219 17.2598 2.24219 14.8898V9.1098C2.24219 6.7398 2.37219 6.5098 4.57219 5.0198L10.1122 1.8198C11.1622 1.2098 12.8122 1.2098 13.8622 1.8198L19.3822 4.9998C21.6222 6.5098 21.7622 6.7398 21.7622 9.1098V14.8798C21.7622 17.2498 21.6322 17.4798 19.4322 18.9698L13.8922 22.1698C13.3522 22.4798 12.6722 22.6298 12.0022 22.6298ZM12.0022 2.8698C11.5822 2.8698 11.1722 2.9498 10.8822 3.1198L5.38219 6.2998C3.75219 7.3998 3.75219 7.3998 3.75219 9.1098V14.8798C3.75219 16.5898 3.75219 16.5898 5.42219 17.7198L10.8822 20.8698C11.4722 21.2098 12.5422 21.2098 13.1322 20.8698L18.6322 17.6898C20.2522 16.5898 20.2522 16.5898 20.2522 14.8798V9.1098C20.2522 7.3998 20.2522 7.3998 18.5822 6.2698L13.1222 3.1198C12.8322 2.9498 12.4222 2.8698 12.0022 2.8698Z" fill="#767C83" />
							<path d="M12 15.75C9.93 15.75 8.25 14.07 8.25 12C8.25 9.93 9.93 8.25 12 8.25C14.07 8.25 15.75 9.93 15.75 12C15.75 14.07 14.07 15.75 12 15.75ZM12 9.75C10.76 9.75 9.75 10.76 9.75 12C9.75 13.24 10.76 14.25 12 14.25C13.24 14.25 14.25 13.24 14.25 12C14.25 10.76 13.24 9.75 12 9.75Z" fill="#767C83" />
						</svg>

					</span>
				</div>
				<div class="-question">
					<?= l('home.concepts.manage.title') ?>
				</div>
				<div class="-answer">
					<?= l('home.concepts.manage.description') ?>
				</div>
				<a href="#" class="-read-more" rel="nofollow"><?= l('home.concepts.read_more') ?></a>
			</div>

		</div>

	</div>

</section>

<div class="modal concept-modal">
	<div class="-modal-box">
		<div class="-modal-box-content">
			<button type="button" class="-close">×</button>
			<div class="-icon-wrapper-circle"></div>
			<div class="-question"></div>
			<div class="-answer"></div>
		</div>
	</div>
</div>

<section class="section-design-faq">

	<div class="-container">

		<div class="-section-title">
			<?= l('home.dac_qa.title') ?>
		</div>

		<div class="-question-answer-list accordion">

			<div class="-question-answer -accordion-item">
				<div tabindex="0" class="-question -accordion-toggler">
					<span><?= l('home.dac_qa.question_1.question') ?></span>
					<img src="<?= ASSETS_FULL_URL . '/images/chevron.svg' ?>" class="-accordion-icon" alt="Online QR Generator">
				</div>
				<div class="-answer -accordion-panel">
					<div class="-accordion-panel-box">
						<?= l('home.dac_qa.question_1.answer') ?>
					</div>
				</div>
			</div>

			<div class="-question-answer -accordion-item">
				<div tabindex="0" class="-question -accordion-toggler">
					<span><?= l('home.dac_qa.question_2.question') ?></span>
					<img src="<?= ASSETS_FULL_URL . '/images/chevron.svg' ?>" class="-accordion-icon" alt="Online QR Generator">
				</div>
				<div class="-answer -accordion-panel">
					<div class="-accordion-panel-box">
						<?= l('home.dac_qa.question_2.answer') ?>
					</div>
				</div>
			</div>

			<div class="-question-answer -accordion-item">
				<div tabindex="0" class="-question -accordion-toggler">
					<span><?= l('home.dac_qa.question_3.question') ?></span>
					<img src="<?= ASSETS_FULL_URL . '/images/chevron.svg' ?>" class="-accordion-icon" alt="Online QR Generator">
				</div>
				<div class="-answer -accordion-panel">
					<div class="-accordion-panel-box">
						<?= l('home.dac_qa.question_3.answer') ?>
					</div>
				</div>
			</div>

			<div class="-question-answer -accordion-item">
				<div tabindex="0" class="-question -accordion-toggler">
					<span><?= l('home.dac_qa.question_4.question') ?></span>
					<img src="<?= ASSETS_FULL_URL . '/images/chevron.svg' ?>" class="-accordion-icon" alt="Online QR Generator">
				</div>
				<div class="-answer -accordion-panel">
					<div class="-accordion-panel-box">
						<?= l('home.dac_qa.question_4.answer') ?>
					</div>
				</div>
			</div>

		</div>

		<div class="-question-answer-tab">

			<div class="-arrows">
				<a href="#" class="-arrow -left">
					<svg width="13" height="7" viewBox="0 0 13 7" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M0.803534 3.73948C0.803676 3.73962 0.803794 3.73979 0.803961 3.73993L3.28351 6.20752C3.46927 6.39237 3.76972 6.39169 3.95463 6.20591C4.13951 6.02015 4.13879 5.7197 3.95304 5.53482L2.28826 3.87811L12.338 3.87811C12.6 3.87811 12.8125 3.66566 12.8125 3.40358C12.8125 3.14149 12.6001 2.92904 12.338 2.92904L2.28829 2.92904L3.95301 1.27234C4.13877 1.08746 4.13948 0.787007 3.9546 0.601249C3.7697 0.415445 3.46922 0.414804 3.28349 0.599636L0.803936 3.06723C0.803794 3.06737 0.803676 3.06753 0.803509 3.06768C0.617657 3.25317 0.61825 3.5546 0.803534 3.73948Z" fill="#505050" />
					</svg>
				</a>
				<a href="#" class="-arrow -right">
					<svg width="13" height="7" viewBox="0 0 13 7" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M12.3058 3.07107C12.3057 3.07093 12.3056 3.07076 12.3054 3.07062L9.82586 0.603027C9.64011 0.418172 9.33965 0.418859 9.15475 0.604641C8.96987 0.790398 8.97058 1.09085 9.15634 1.27573L10.8211 2.93243H0.771412C0.509325 2.93243 0.296875 3.14488 0.296875 3.40697C0.296875 3.66906 0.509325 3.88151 0.771412 3.88151H10.8211L9.15636 5.53821C8.9706 5.72309 8.96989 6.02354 9.15477 6.2093C9.33968 6.3951 9.64015 6.39574 9.82589 6.21091L12.3054 3.74332C12.3056 3.74318 12.3057 3.74301 12.3059 3.74287C12.4917 3.55737 12.4911 3.25595 12.3058 3.07107Z" fill="white" />
					</svg>
				</a>
			</div>

			<div class="-question-tab-list-wrapper">
				<div class="-question-tab-list">
					<div class="-question-tab -active" data-target="#design-faq-1">
						<?= l('home.dac_qa.question_1.question') ?>
					</div>
					<div class="-question-tab" data-target="#design-faq-2">
						<?= l('home.dac_qa.question_2.question') ?>
					</div>
					<div class="-question-tab" data-target="#design-faq-3">
						<?= l('home.dac_qa.question_3.question') ?>
					</div>
					<div class="-question-tab" data-target="#design-faq-4">
						<?= l('home.dac_qa.question_4.question') ?>
					</div>
				</div>
			</div>

			<div class="-question-answer-tab-content">

				<div id="design-faq-1" class="-question-answer -show">
					<div class="-question">
						<?= l('home.dac_qa.question_1.question') ?>
					</div>
					<div class="-answer">
						<?= l('home.dac_qa.question_1.answer') ?>
					</div>
				</div>

				<div id="design-faq-2" class="-question-answer">
					<div class="-question">
						<?= l('home.dac_qa.question_2.question') ?>
					</div>
					<div class="-answer">
						<?= l('home.dac_qa.question_2.answer') ?>
					</div>
				</div>

				<div id="design-faq-3" class="-question-answer">
					<div class="-question">
						<?= l('home.dac_qa.question_3.question') ?>
					</div>
					<div class="-answer">
						<?= l('home.dac_qa.question_3.answer') ?>
					</div>
				</div>

				<div id="design-faq-4" class="-question-answer">
					<div class="-question">
						<?= l('home.dac_qa.question_4.question') ?>
					</div>
					<div class="-answer">
						<?= l('home.dac_qa.question_4.answer') ?>
					</div>
				</div>

			</div>

		</div>

	</div>

</section>

<section class="section-print-faq">

	<div class="-container">

		<div class="-section-title">
			<?= l('home.sap_qa.title') ?>
		</div>

		<div class="-question-answer-list accordion">

			<div class="-question-answer -accordion-item">
				<div tabindex="0" class="-question -accordion-toggler">
					<span><?= l('home.sap_qa.question_1.question') ?></span>
					<img src="<?= ASSETS_FULL_URL . '/images/chevron.svg' ?>" class="-accordion-icon" alt="Online QR Generator">
				</div>
				<div class="-answer -accordion-panel">
					<div class="-accordion-panel-box">
						<?= l('home.sap_qa.question_1.answer') ?>
					</div>
				</div>
			</div>

			<div class="-question-answer -accordion-item">
				<div tabindex="0" class="-question -accordion-toggler">
					<span><?= l('home.sap_qa.question_2.question') ?></span>
					<img src="<?= ASSETS_FULL_URL . '/images/chevron.svg' ?>" class="-accordion-icon" alt="Online QR Generator">
				</div>
				<div class="-answer -accordion-panel">
					<div class="-accordion-panel-box">
						<?= l('home.sap_qa.question_2.answer') ?>
					</div>
				</div>
			</div>

			<div class="-question-answer -accordion-item">
				<div tabindex="0" class="-question -accordion-toggler">
					<span><?= l('home.sap_qa.question_3.question') ?></span>
					<img src="<?= ASSETS_FULL_URL . '/images/chevron.svg' ?>" class="-accordion-icon" alt="Online QR Generator">
				</div>
				<div class="-answer -accordion-panel">
					<div class="-accordion-panel-box">
						<?= l('home.sap_qa.question_3.answer') ?>
					</div>
				</div>
			</div>

			<div class="-question-answer -accordion-item">
				<div tabindex="0" class="-question -accordion-toggler">
					<span><?= l('home.sap_qa.question_4.question') ?></span>
					<img src="<?= ASSETS_FULL_URL . '/images/chevron.svg' ?>" class="-accordion-icon" alt="Online QR Generator">
				</div>
				<div class="-answer -accordion-panel">
					<div class="-accordion-panel-box">
						<?= l('home.sap_qa.question_4.answer') ?>
					</div>
				</div>
			</div>

			<div class="-question-answer -accordion-item">
				<div tabindex="0" class="-question -accordion-toggler">
					<span><?= l('home.sap_qa.question_5.question') ?></span>
					<img src="<?= ASSETS_FULL_URL . '/images/chevron.svg' ?>" class="-accordion-icon" alt="Online QR Generator">
				</div>
				<div class="-answer -accordion-panel">
					<div class="-accordion-panel-box">
						<?= l('home.sap_qa.question_5.answer') ?>
					</div>
				</div>
			</div>

			<div class="-question-answer -accordion-item">
				<div tabindex="0" class="-question -accordion-toggler">
					<span><?= l('home.sap_qa.question_6.question') ?></span>
					<img src="<?= ASSETS_FULL_URL . '/images/chevron.svg' ?>" class="-accordion-icon" alt="Online QR Generator">
				</div>
				<div class="-answer -accordion-panel">
					<div class="-accordion-panel-box">
						<?= l('home.sap_qa.question_6.answer') ?>
					</div>
				</div>
			</div>

		</div>

	</div>

</section>

<section class="section-ready">

	<div class="-container">

		<div class="-box">
			<div class="-content">
				<div>
					<div class="-section-title">
						<?= l('home.get_started.title') ?>
					</div>
					<div class="-section-description">
						<?= l('home.get_started.description') ?>
					</div>
				</div>
				<div>
					<a <?= $data->isNewLanding ? 'onclick="javascript:$(document).scrollTop(0)"' : 'href="'.url('register').'"' ?> class="-link register-link" style="cursor: pointer;">
						<img src="<?= ASSETS_FULL_URL . '/images/arrow-right.svg' ?>" alt="Online QR Generator" class="-arrow-right">
					</a>
				</div>
			</div>
		</div>

	</div>

</section>

<script>
	// Data Layer Implementation (GTM)

	$(document).on('click', '.-link-create-qr', function() {

		var event = "cta_click";
		var data = {
			"userId": null,
			"clicktext": "Create QR Code"}
		googleDataLayer(event, data);
	});


	$(document).on('click', '.-link-sign-up', function() {
		var event = "cta_click";
		var data = {
			"userId": null,
			"clicktext": "Sign-Up" }
		googleDataLayer(event, data);
	});

	
	
	$(document).on('click', '.register-link', function() {
		
		var event = "cta_click";
		var data = {
			"userId": null,
			"clicktext": "Sign-Up"
		}
		googleDataLayer(event, data);
	});

</script>