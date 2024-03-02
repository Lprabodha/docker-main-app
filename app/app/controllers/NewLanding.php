<?php

namespace Altum\Controllers;

use Altum\Alerts;
use Altum\Middlewares\Authentication;
use Altum\Title;
use Altum\Meta;
use DateTime;
use Altum\Models\User;
use Altum\Routing\Router;

class NewLanding extends Controller
{

    public function index()
    {
        // New Sign Up Funnel & Create a new temp user account
        $url  = $_SERVER['REQUEST_URI'];
        $url_components = parse_url($url);
        parse_str(isset($url_components['query']) ? $url_components['query'] : '', $params);
        $query_string = http_build_query($params);

        $aciveNsf      =  isset($params['qr_onboarding']) ? $params['qr_onboarding'] == 'active_nsf' : false;
        $activeDpf     =  isset($params['qr_onboarding']) ? $params['qr_onboarding'] == 'active_dpf' : false;

        $onboarding_funnel = onboarding_funnel($url_components, $this->user->user_id);

        $qr_code_id = null;

        if (isset($_COOKIE['nsf_qr_id'])  && $_COOKIE['nsf_qr_id'] != '') {
            $nsfQr =   db()->where('uId', $_COOKIE['nsf_qr_id'])->getOne('qr_codes');
            $qr_code_id =  $nsfQr->qr_code_id;
        }

        if (isset($_COOKIE['nsf_user_id']) && $_COOKIE['nsf_user_id'] != '') {
            $nsfUser =  db()->where('user_id', $_COOKIE['nsf_user_id'])->getOne('users');

            $token_code = $nsfUser->token_code;
            if (empty($token_code)) {
                $token_code = md5($_COOKIE['nsf_user_id'] . microtime());
                db()->where('user_id', $_COOKIE['nsf_user_id'])->update('users', ['token_code' => $token_code]);
            }

            $_SESSION['user_id'] = $_COOKIE['nsf_user_id'];
            $_SESSION['user_password_hash'] = md5($nsfUser->password);
            setcookie('user_id', $_COOKIE['nsf_user_id'], time() + (60 * 60 * 24 * 90), COOKIE_PATH);
            setcookie('token_code', $token_code, time() + (60 * 60 * 24 * 90), COOKIE_PATH);
            setcookie('user_password_hash', md5($nsfUser->password), time() + (60 * 60 * 24 * 90), COOKIE_PATH);
            $this->user = $nsfUser;
        }

        $_SESSION['new_landing'] = true;

        unset($_SESSION['new_landing_route']);
        if ($_SESSION['new_landing']) {
            $_SESSION['new_landing_route'] =  'create?' . $query_string;
        }

        $_SESSION['new_landing'] = true;

        unset($_SESSION['new_landing_route']);
        if ($_SESSION['new_landing']) {
            $_SESSION['new_landing_route'] =  'create?' . $query_string;
        }

        if (!Authentication::check()) {

            $this->create_temp_user($onboarding_funnel);
        } else {
            if ($this->user->type != 2) {
                return redirect('qr-codes');
            }
        }

        unset($_SESSION['qrCodeUid']);


        if (!empty(settings()->main->opengraph)) {
            Meta::set_social_url(SITE_URL);
            Meta::set_social_title('Online QR Generator | Create Free QR Codes');
            Meta::set_social_description('Online QR Code Generator with your logo, frame, colors & more. Create, manage and statistically track your QR codes. For URL, vCard, PDF and more');
            Meta::set_social_image(UPLOADS_FULL_URL . 'main/' . settings()->main->opengraph);
        }

        $qr_code_settings = require APP_PATH . 'includes/qr_code.php';

        $status =  null;
        $method = null;
        if ($qr_code_id != null &&  $qr_code_id != '') {
            $qr_code = db()->where('qr_code_id', $qr_code_id)->getOne('qr_codes');
            $status = $qr_code->status;
            $qr_code->settings = json_decode($qr_code->settings);
            $type = $qr_code->type;
        } else {
            $type = isset($this->params[0]) && array_key_exists($this->params[0], $qr_code_settings['type']) ? $this->params[0] : null;
        }

        //Dynamic title for Google Bot
        $fxParameter = isset($_GET['fx']) ? $_GET['fx'] : '';
        $titleBot    = null;

        if (isset($_SESSION['ip_data']) &&  $_SESSION['ip_data'] != '') {
            $ipData = $_SESSION['ip_data'];
        } else {
            $ipData = location_data();
        }

        if ($fxParameter) {
            if (isset($ipData) && $ipData  != null && $ipData->org == "google" || $ipData->org == "Google" ) {
                if ($fxParameter) {
                    $decoded_text = htmlspecialchars_decode($fxParameter, ENT_NOQUOTES);
                    $titleBot = ucwords($decoded_text);
                }
            }
        }


        $data = [
            'type'             => $type ?  $type : 'url',
            'qr_code_settings' => $qr_code_settings,
            'links'            => $links ?? null,
            'qr_code_id'       => $qr_code_id,
            'qr_uid'           => isset($qr_code->uId) ? $qr_code->uId : null,
            'status'           => $status,
            'auth_method'      => $method,
            'onboarding_funnel' => $onboarding_funnel,
            'isNewLanding'     => true,
            'titleBot'         => isset($titleBot) ? $titleBot : null
        ];

        $landingData = [
            'isNewLanding' => true
        ];

        $view = new \Altum\Views\View('qr/index', (array) $this);
        $landing = new \Altum\Views\View('index/index', (array) $this);
        $home_footer = new \Altum\Views\View('partials/home_footer', (array) $this);

        $this->add_view_content('content', $view->run($data));
        $this->add_view_content('landing', $landing->run($landingData));
        $this->add_view_content('home_footer', $home_footer->run(['isNewLanding' => true]));
    }

    private function create_temp_user($onboarding_funnel)
    {
        $plan_id                    = 'free';
        $plan_settings              = json_encode(settings()->plan_free->settings);
        $plan_expiration_date       = date('Y-m-d H:i:s', strtotime('+10 day', strtotime(date('Y-m-d H:i:s'))));
        $ipData                     = location_data();

        $registered_user = (new User())->create(
            'temp@gmail.com',
            isset($_POST['password']) ? $_POST['password'] : null,
            isset($_POST['name']) ? $_POST['name'] : 'temp_user',
            (int) !settings()->users->email_confirmation,
            'direct',
            null,
            null,
            $plan_id,
            $plan_settings,
            $plan_expiration_date,
            isset($ipData->timezone) ? $ipData->timezone : settings()->main->default_timezone,
            (int) 2,
            $onboarding_funnel
        );

        $_SESSION['user_id'] = $registered_user['user_id'];
        $_SESSION['user_password_hash'] = md5($registered_user['password']);

        $token_code = isset($registered_user['token_code']) ? $registered_user['token_code'] : null;
        /* Generate a new token */
        if (empty($token_code)) {
            $token_code = md5($registered_user['user_id'] . microtime());
            db()->where('user_id', $registered_user['user_id'])->update('users', ['token_code' => $token_code]);
        }

        setcookie('user_id', $registered_user['user_id'], time() + (60 * 60 * 24 * 90), COOKIE_PATH);
        setcookie('token_code', $token_code, time() + (60 * 60 * 24 * 90), COOKIE_PATH);
        setcookie('user_password_hash', md5($registered_user['password']), time() + (60 * 60 * 24 * 3), COOKIE_PATH);

        $user  =  db()->where('user_id', $registered_user['user_id'])->getOne('users');
        $this->user  = $user;
    }
}
