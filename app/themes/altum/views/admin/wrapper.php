<?php defined('ALTUMCODE') || die() ?>
<!DOCTYPE html>
<html lang="<?= \Altum\Language::$code ?>" dir="<?= l('direction') ?>" class="w-100 h-100">

<head>
    <title><?= \Altum\Title::get() ?></title>
    <base href="<?= SITE_URL; ?>">
    <meta charset="UTF-8">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" /> -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">

    <link rel="alternate" href="<?= SITE_URL . \Altum\Routing\Router::$original_request ?>" hreflang="x-default" />
    <?php if (count(\Altum\Language::$active_languages) > 1) : ?>
        <?php foreach (\Altum\Language::$active_languages as $language_name => $language_code) : ?>
            <?php if (settings()->main->default_language != $language_name) : ?>
                <link rel="alternate" href="<?= SITE_URL . $language_code . '/' . \Altum\Routing\Router::$original_request ?>" hreflang="<?= $language_code ?>" />
            <?php endif ?>
        <?php endforeach ?>
    <?php endif ?>

    <?php if (!empty(settings()->main->favicon)) : ?>
        <link href="<?= UPLOADS_FULL_URL . 'main/' . settings()->main->favicon ?>" rel="shortcut icon" />
    <?php endif ?>

    <link href="<?= ASSETS_FULL_URL . 'css/admin-' . \Altum\ThemeStyle::get_file() . '?v=' . PRODUCT_CODE ?>" id="css_theme_style" rel="stylesheet" media="screen,print">
    <link href="<?= ASSETS_FULL_URL . 'css/qr-icons.css?v=' . PRODUCT_CODE ?>" rel="stylesheet" media="screen,print">
    <link href="<?= ASSETS_FULL_URL . 'css/components/spinner.css?v=' . PRODUCT_CODE ?>" rel="stylesheet" media="screen,print">
    <?php foreach (['admin-custom.css'] as $file) : ?>
        <link href="<?= ASSETS_FULL_URL ?>css/<?= $file ?>?v=<?= PRODUCT_CODE ?>" rel="stylesheet" media="screen,print">
    <?php endforeach ?>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

    <style>
        .translate-middle-x {
            transform: translateX(-50%) !important;
        }

        .start-50 {
            left: 50% !important;
        }

        .top-0 {
            top: 0 !important;
        }

        .toast-container {
            width: -webkit-max-content;
            width: -moz-max-content;
            width: max-content;
            max-width: 100%;
            pointer-events: none;
        }

        .toast:not(.showing):not(.show) {
            opacity: 0;
        }

        .fade:not(.show) {
            opacity: 0.5;
        }

        .toast.hide {
            display: none;
        }

        .toast {
            width: 350px;
            max-width: 100%;
            font-size: .875rem;
            pointer-events: auto;
            background-color: rgba(255, 255, 255, .85);
            background-clip: padding-box;
            border: 1px solid rgba(0, 0, 0, .1);
            box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15);
            border-radius: .25rem;
        }

        .toast-body {
            padding: .75rem;
            word-wrap: break-word;
        }

        .btn-close-white {
            filter: invert(1) grayscale(100%) brightness(200%);
        }

        .btn-close {
            box-sizing: content-box;
            width: 1em;
            height: 1em;
            padding: .25em .25em;
            color: #000;
            background: transparent url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23000'%3e%3cpath d='M.293.293a1 1 0 011.414 0L8 6.586 14.293.293a1 1 0 111.414 1.414L9.414 8l6.293 6.293a1 1 0 01-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 01-1.414-1.414L6.586 8 .293 1.707a1 1 0 010-1.414z'/%3e%3c/svg%3e") center/1em auto no-repeat;
            border: 0;
            border-radius: .25rem;
            opacity: .5;
        }

        .me-2 {
            margin-right: .5rem !important;
        }

        .btn-close:hover {
            color: #000;
            text-decoration: none;
            opacity: .75;
        }
    </style>

    <?= \Altum\Event::get_content('head') ?>
</head>

<body class="<?= l('direction') == 'rtl' ? 'rtl' : null ?>" data-theme-style="<?= \Altum\ThemeStyle::get() ?>">
    <div id="admin_overlay" class="admin-overlay" style="display: none"></div>

    <div class="admin-container">
        <?= $this->views['admin_sidebar'] ?>

        <section class="admin-content altum-animate altum-animate-fill-none altum-animate-fade-in">
            <?= $this->views['admin_menu'] ?>

            <div class="p-3 p-lg-5 position-relative">
                <?= $this->views['content'] ?>

                <?= $this->views['footer'] ?>
            </div>
        </section>
    </div>

    <?= \Altum\Event::get_content('modals') ?>

    <?php require THEME_PATH . 'views/partials/js_global_variables.php' ?>

    <?php foreach (['libraries/popper.min.js', 'libraries/bootstrap.min.js', 'custom.js', 'repeater.js', 'libraries/fontawesome.min.js', 'libraries/fontawesome-solid.min.js', 'libraries/fontawesome-brands.modified.js'] as $file) : ?>
        <script src="<?= ASSETS_FULL_URL ?>js/<?= $file ?>?v=<?= PRODUCT_CODE ?>"></script>
    <?php endforeach ?>

    <?= \Altum\Event::get_content('javascript') ?>
    <!-- <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script> -->
    <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.js"></script>

    <script>
        let toggle_admin_sidebar = () => {
            /* Open sidebar menu */
            let body = document.querySelector('body');
            body.classList.toggle('admin-sidebar-opened');

            /* Toggle overlay */
            let admin_overlay = document.querySelector('#admin_overlay');
            admin_overlay.style.display == 'none' ? admin_overlay.style.display = 'block' : admin_overlay.style.display = 'none';

            /* Change toggle button content */
            let button = document.querySelector('#admin_menu_toggler');

            if (body.classList.contains('admin-sidebar-opened')) {
                // button.innerHTML = `<i class="fa fa-fw fa-times"></i>`;
                button.classList.add('opened')
            } else {
                // button.innerHTML = `<i class="fa fa-fw fa-bars"></i>`;
                button.classList.remove('opened')
            }
        };



        /* Toggler for the sidebar */
        document.querySelector('#admin_menu_toggler').addEventListener('click', event => {
            event.preventDefault();

            toggle_admin_sidebar();

            let admin_sidebar_is_opened = document.querySelector('body').classList.contains('admin-sidebar-opened');

            if (admin_sidebar_is_opened) {
                document.querySelector('#admin_overlay').removeEventListener('click', toggle_admin_sidebar);
                document.querySelector('#admin_overlay').addEventListener('click', toggle_admin_sidebar);
            } else {
                document.querySelector('#admin_overlay').removeEventListener('click', toggle_admin_sidebar);
            }
        });
    </script>
    <?php include_once(THEME_PATH . '/views/partials/alert_toast.php') ?>

</body>

</html>