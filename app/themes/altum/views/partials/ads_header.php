<?php
use Altum\Middlewares\Authentication;

if(
    !empty(settings()->ads->header)
    && (
        !Authentication::check() ||
        (Authentication::check() && !$this->user->plan_settings->no_ads)
    )
    && \Altum\Routing\Router::$controller_settings['ads']
): ?>
    <div class="container my-3"><?= settings()->ads->header ?></div>
<?php endif ?>
