<?php
/*
 * @copyright Copyright (c) 2021 AltumCode (https://altumcode.com/)
 *
 * This software is exclusively sold through https://altumcode.com/ by the AltumCode author.
 * Downloading this product from any other sources and running it without a proper license is illegal,
 *  except the official ones linked from https://altumcode.com/.
 */

namespace Altum\Controllers;

use Altum\Alerts;
use Altum\Middlewares\Authentication;
use Altum\Middlewares\Csrf;

class CookiesPolicy extends Controller {

    public function index() {

        $view = new \Altum\Views\View('cookies-policy/index', (array) $this);
        $data = [];

        $this->add_view_content('content', $view->run($data));

    }

}