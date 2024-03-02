<?php

use Altum\Routing\Router;

?>

<div>
	<?= \Altum\Alerts::output_alerts() ?>
</div>
<nav class="section-navbar  w-100 <?= (Router::parse_controller() === "NotFound") ? 'shadow' : '' ?>">
	<div class="-container">
		<div class="-logo-language">
			<a href="<?= isset($_SESSION['new_landing_route']) ? $_SESSION['new_landing_route'] : url() ?>" class="-logo logoUrl animate-logo">

				<img src="<?= ASSETS_FULL_URL . 'images/logo.webp' ?>" alt="Logo" width="1634" height="304">
			</a>
			<div class="ml-auto d-flex" style="display:flex; margin-left:auto;">
				<?php

				if (url(\Altum\Routing\Router::$original_request) != (url('faq'))  && Router::$controller_key != "notfound") { ?>

					<?php
					$request_uri = $_SERVER['REQUEST_URI'];
					if (strpos($request_uri, 'faq') == false) { ?>
						<a href="<?= url('faq') ?>" class="-link-language">
							<img src="<?= ASSETS_FULL_URL . '/images/message-question.svg' ?>" alt="">
						</a>
					<?php } ?>

				<?php } ?>
				<a href="#" class="-menu-toggler" style="margin-left:8px; ">
					<span class="-line"></span>
					<span class="-line"></span>
					<span class="-line"></span>
				</a>
			</div>
		</div>
		<?php if ((!\Altum\Middlewares\Authentication::check()) && (Router::$controller_key  != "qr-download")) : ?>
			<div class="-login-signup">
				<a href="<?= url('login') ?>" class="-link-log-in">
					<img src="<?= ASSETS_FULL_URL . '/images/Login.svg' ?>" alt="">
					<span><?= l('home.navbar.btn.login') ?></span>
				</a>
				<a href="<?= url('register') ?>" class="-link-sign-up">
					<img src="<?= ASSETS_FULL_URL . '/images/Logout.svg' ?>" alt="">
					<span><?= l('home.navbar.btn.signup') ?></span>
				</a>
			</div>
		<?php elseif ($this->user->type == 2) : ?>
			<div class="-login-signup">
				<a href="<?= url('login') ?>" class="-link-log-in">
					<img src="<?= ASSETS_FULL_URL . '/images/Login.svg' ?>" alt="">
					<span><?= l('home.navbar.btn.login') ?></span>
				</a>
				<a href="<?= url('register') ?>" class="-link-sign-up">
					<img src="<?= ASSETS_FULL_URL . '/images/Logout.svg' ?>" alt="">
					<span><?= l('home.navbar.btn.signup') ?></span>
				</a>
			</div>
		<?php endif ?>
	</div>
</nav>
<div class="black-friday-full-wrap  <?php if ((!\Altum\Middlewares\Authentication::check()) && (Router::$controller_key  == "plans-and-prices")) : ?> d-none home-friday-wrap <?php else : ?> home-d-none d-none <?php endif ?>">
	<div class="friday-wrap d-flex justify-content-center align-items-center">
		<div class="friday-text-wrap">
			<span class="friday-text"><?= l('plan_card.black_friday_text_1') ?><span class="color-text"><?= l('plan_card.black_friday_text_3') ?></span></span>
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		var preRoute = document.referrer;
		if (preRoute.includes('create')) {
			var href = $('.logoUrl').attr('href');
			href = href.replace('<?= url() ?>',preRoute);
			$('.logoUrl').attr('href', href);
		}
	});


	$(document).on('click', '.-link-log-in', function() {
		var event = "cta_click";
		var data = {
			"userId": null,
			"clicktext": "Log in",
		}
		googleDataLayer(event, data);
	});
	
	$(document).on('click', '.-link-sign-up', function() {
		var event = "cta_click";
		var data = {
			"userId": null,
			"clicktext": "Sign-Up",

		}
		googleDataLayer(event, data);
	});

	// alert success message auto close
	$(document).ready(function() {
		if ($(".alert-success").hasClass("altum-animate-fade-in")) {
			$(".alert-success").addClass('fadeDownMessage');
			$(".fadeDownMessage").slideDown().delay(5500).fadeOut();
		}
	});

	// $(".animate-logo").on("click", function(e) {
	// 	if ($(window).width() < 576){
	// 		var ripple = $('<span>');
	// 		ripple.addClass('ripple');
	
	// 		var max = Math.max($(this).width(), $(this).height());
	
	// 		ripple.css('width', max * 2 + 'px');
	// 		ripple.css('height', max * 2 + 'px');
	
	// 		var rect = $(this).offset();
	
	// 		ripple.css('left', event.pageX - rect.left - max + 'px');
	// 		ripple.css('top', event.pageY - rect.top - max + 'px');
	
	// 		$(this).append(ripple);
	// 	}
	// });
</script>