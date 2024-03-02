<?php
/*
 * @copyright Copyright (c) 2021 AltumCode (https://altumcode.com/)
 *
 * This software is exclusively sold through https://altumcode.com/ by the AltumCode author.
 * Downloading this product from any other sources and running it without a proper license is illegal,
 *  except the official ones linked from https://altumcode.com/.
 */

namespace Altum\Controllers;

use Altum\Meta;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Altum\Middlewares\Authentication;

class Index extends Controller
{

    public function index()
    {

        /* Custom index redirect if set */
        if (!empty(settings()->main->index_url)) {
            header('Location: ' . settings()->main->index_url);
            die();
        }

        // var_dump($this->get_session_number($_COOKIE['_ga_TX6N5PBXTK']));

        Authentication::guard('guest');

        //CHANGES BY KRUPA HIRANI
        if (!empty(settings()->main->opengraph)) {
            Meta::set_social_url(SITE_URL);
            Meta::set_social_title('Online QR Generator | Create Free QR Codes');
            Meta::set_social_description('Online QR Code Generator with your logo, frame, colors & more. Create, manage and statistically track your QR codes. For URL, vCard, PDF and more');
            Meta::set_social_image(UPLOADS_FULL_URL . 'main/' . settings()->main->opengraph);
        }
        /* Main View */
        $data = [
            'qr_code_settings' => require APP_PATH . 'includes/qr_code.php',
            'isNewLanding' => false
        ];

        $view = new \Altum\Views\View('index/index', (array) $this);

        $this->add_view_content('content', $view->run($data));
    }

  
}
