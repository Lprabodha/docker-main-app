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
use Altum\Database\Database;
use Altum\Date;
use Altum\Models\QrCode;
use Altum\Response;
use Altum\Traits\Apiable;
use Altum\Uploads;
use Unirest\Request;
use DateTime;
use \Altum\Language;

class ApiUserLanguage extends Controller
{
    use Apiable;

    public function index()
    {
        $this->verify_request();

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {

            $this->get();
        }

        $this->return_404();
    }

    public function get()
    {
        $lang_code = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? mb_substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2) : null;

        if ($lang_code) {
            $browser_language = null;
            foreach (Language::$languages as $key => $language) {
                if ($language['code'] == $lang_code) {
                    $browser_language = $language['name'];
                }
            }

            if ($browser_language) {
                if (Language::$name != $browser_language) {
                    $userLanguage   =    Language::set_default_by_name($browser_language);
                }
            } else {
                $userLanguage   =  $this->api_user->language;
            }
        } else {
            $userLanguage   =   $this->api_user->language;
        }

        /* Prepare the data */
        $data = [
            'language' => $userLanguage,
            'timezone' => $this->api_user->timezone,
            'country' => $this->api_user->country,
        ];

        Response::jsonapi_success($data);
    }
}
