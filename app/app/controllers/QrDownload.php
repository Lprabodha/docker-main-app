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
use Altum\Title;

class QrDownload extends Controller
{

    public function index()
    {

        $uri = $_SERVER['REQUEST_URI'];
        $tokens = explode('/', $uri);
        $token = end($tokens);

        $user  = db()->where('referral_key', $token)->getOne('users');

        if (!$user) {
            redirect();
        }

        $queryResource = "SELECT * FROM qr_codes  WHERE user_id = '{$user->user_id}' LIMIT 1";

        $qrCode = database()->query($queryResource)->fetch_object();


        /* Main View */
        $data = [
            'user'   => $user ? $user : null,
            'qrCode' => $qrCode
        ];


        $view = new \Altum\Views\View('qr-download/index', (array) $this);

        $this->add_view_content('content', $view->run($data));
    }
}
