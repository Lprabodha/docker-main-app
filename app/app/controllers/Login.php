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
use Altum\Captcha;
use Altum\Database\Database;
use Altum\Middlewares\Authentication;
use Altum\Models\User;
use Google\Client;
use Google\Service\Oauth2;
use Altum\Response;
use Exception;
use Stripe\Exception\ApiErrorException;

class Login extends Controller
{

    public function index()
    {

        Authentication::guard('guest');

        $method       = (isset($this->params[0])) ? $this->params[0] : null;
        $redirect     = isset($_GET['redirect']) ? Database::clean_string($_GET['redirect']) : '';
        $promo        = isset($_GET['promo']) ? Database::clean_string($_GET['promo']) : '';
        $user_id      = isset($_GET['user_id']) ? $_GET['user_id'] : '';
        $on_bording   = isset($_GET['on_bording']) ? $_GET['on_bording'] : '';
        $utm_id       = isset($_GET['utm_id']) ? $_GET['utm_id'] : null;
        $utm_source   = isset($_GET['utm_source']) ? $_GET['utm_source'] : null;
        $utm_medium   = isset($_GET['utm_medium']) ? $_GET['utm_medium'] : null;
        $utm_content  = isset($_GET['utm_content']) ? $_GET['utm_content'] : null;
        $utm_term     = isset($_GET['utm_term']) ? $_GET['utm_term'] : null;
        $gaid         = isset($_GET['gaid']) ? $_GET['gaid'] : null;
        $gclid        = isset($_GET['gclid']) ? $_GET['gclid'] : null;
        $gbraid       = isset($_GET['gbraid']) ? $_GET['gbraid'] : null;
        $wbraid       = isset($_GET['wbraid']) ? $_GET['wbraid'] : null;
        $matchtype    = isset($_GET['matchtype']) ? $_GET['matchtype'] : null;
        $referral_key = isset($_GET['referral_key']) ? $_GET['referral_key'] : null;



        $google_click_id = null;
        if (isset($gclid)) {
            $google_click_id = $gclid;
        } else if (isset($gbraid)) {
            $google_click_id = $gbraid;
        } else if (isset($wbraid)) {
            $google_click_id = $wbraid;
        } else {
            $google_click_id = null;
        }

        /* Default values */
        $values = [
            'email' => isset($_GET['email']) ? Database::clean_string($_GET['email']) : '',
            'password' => '',
            'rememberme' => isset($_POST['rememberme']),
        ];

 
        /* Initiate captcha */
        $captcha = new Captcha();

        /* One time login */
        if ($method == 'one-time-login-code') {
            $one_time_login_code = isset($this->params[1]) ? Database::clean_string($this->params[1]) : null;

            if (empty($one_time_login_code)) {
                redirect('login');
            }

            /* Try to get the user from the database */
            $user = db()->where('one_time_login_code', $one_time_login_code)->getOne('users', ['user_id', 'password', 'name', 'status', 'language']);

            if (!$user) {
                redirect('login');
            }

            if ($user->status != 1) {
                Alerts::add_error(l('login.error_message.user_not_active'));
                redirect($redirect); //redirect('login');
            }

            /* Login the user */
            $_SESSION['user_id'] = $user->user_id;
            $_SESSION['user_password_hash'] = md5($user->password);

            (new User())->login_aftermath_update($user->user_id);

            /* Remove one time login */
            db()->where('user_id', $user->user_id)->update('users', ['one_time_login_code' => null]);

            /* Set a welcome message */
            // Alerts::add_info(sprintf(l('login.info_message.logged_in'), $user->name));

            /* Check to see if the user has a custom language set */
            if (\Altum\Language::$name == $user->language) {
                redirect($redirect);
            } else {

                redirect((\Altum\Language::$active_languages[$user->language] ? \Altum\Language::$active_languages[$user->language] . '/' : null) . $redirect, true);
            }
        }


        /* Google Login / Register */
        if (settings()->google->is_enabled && in_array($method, ['google-initiate', 'google'])) {
            $client = new Client();
            $client->setClientId(settings()->google->client_id);
            $client->setClientSecret(settings()->google->client_secret);

            $client->setRedirectUri(SITE_URL . 'login/google');
            $client->addScope('email');
            $client->addScope('profile');
            $client->setState(base64_encode(implode(",", [$redirect, $utm_id,  $utm_source, $utm_medium, $utm_content, $utm_term, $gaid,  $matchtype, $promo, $user_id, $on_bording,  $google_click_id])));

            if ($method == 'google-initiate') {
                $google_login_url = $client->createAuthUrl();
                header('Location: ' . $google_login_url);
                die();
            }

            if ($method == 'google' && isset($_GET['code']) && !empty($_GET['code'])) {
                $state              = base64_decode($_GET['state']);
                $state              = explode(',', $state);
                $redirect           = $state[0];
                $utmId              = $state[1];
                $utmSource          = $state[2];
                $utmMedium          = $state[3];
                $utmContent         = $state[4];
                $utmTerm            = $state[5];
                $gaId               = $state[6];
                $matchType          = $state[7];
                $promo              = $state[8];
                $userId             = $state[9];
                $onBording          = $state[10];
                $google_click_id    = $state[11];
                $token              = $client->fetchAccessTokenWithAuthCode($_GET['code']);              
               
                if(!isset($token['error'])){
                    $client->setAccessToken($token['access_token']);               
                    /* Get profile info */
                    $google_oauth        = new Oauth2($client);
                    $google_account_info = $google_oauth->userinfo->get();
                    $email               = $google_account_info->email;
                    $name                = $google_account_info->name;
                    $lang_code           = $google_account_info->locale;
    
                    if (is_null($email)) {
                        Alerts::add_error(l('login.error_message.email_is_null'));
                        redirect('login');
                    }    
                    $this->process_social_login($email, $name, $redirect, $method, $lang_code, $utmId, $utmSource, $utmMedium, $utmContent, $utmTerm, $gaId, $matchType, $promo, $userId, $onBording, $google_click_id);
                }else{
                    dil('Google login error');
                    dil($token);
                }
                
            }
        }


        if (!empty($_POST)) {
            /* Clean email and encrypt the password */
            $_POST['email'] = Database::clean_string($_POST['email']);
            $_POST['twofa_token'] = isset($_POST['twofa_token']) ? Database::clean_string($_POST['twofa_token']) : null;
            $values['email'] = $_POST['email'];
            $values['password'] = isset($_POST['password']) ? $_POST['password'] : null;

            /* Check for any errors */
            $required_fields = ['email'];
            foreach ($required_fields as $field) {
                if (!isset($_POST[$field]) || (isset($_POST[$field]) && empty($_POST[$field]) && $_POST[$field] != '0')) {
                    Alerts::add_field_error($field, l('global.error_message.empty_field'));
                }
            }

            if (settings()->captcha->login_is_enabled && !isset($_SESSION['twofa_required']) && !$captcha->is_valid()) {
                Alerts::add_field_error('captcha', l('global.error_message.invalid_captcha'));
            }

            /* Try to get the user from the database */
            $user = db()->where('email', $_POST['email'])->getOne('users', ['user_id', 'email', 'name', 'status', 'password', 'token_code', 'twofa_secret', 'language']);


            if (!$user) {
                Alerts::add_error(l('login.error_message.wrong_login_credentials'));
                redirect($redirect);
            } else {

                if ($user->status != 1) {
                    Alerts::add_error(l('login.error_message.user_not_active'));
                    redirect($redirect);
                } else

                 if (!isset($_POST['verify_code'])) {
                    if (!password_verify($_POST['password'], $user->password)) {
                        // Logger::users($user->user_id, 'login.wrong_password');
                        Alerts::add_error(l('login.error_message.wrong_login_credentials'));
                        redirect($redirect);
                    }
                } else {
                    if ($_POST['verify_code'] != $_POST['valid_verify_code']) {
                        Alerts::add_error(l('login.error_message.wrong_login_credentials'));
                        // redirect($redirect);
                    }
                }
            }


            /* Check if the user has Two-factor Authentication enabled */
            if (!Alerts::has_field_errors() && !Alerts::has_errors()) {
                if ($user && $user->twofa_secret) {
                    $_SESSION['twofa_required'] = 1;

                    if ($_POST['twofa_token']) {
                        $twofa = new \RobThree\Auth\TwoFactorAuth(settings()->main->title, 6, 30);
                        $twofa_check = $twofa->verifyCode($user->twofa_secret, $_POST['twofa_token']);

                        if (!$twofa_check) {
                            Alerts::add_field_error('twofa_token', l('login.error_message.twofa_token'));
                        }
                    } else {
                        Alerts::add_info(l('login.info_message.twofa_token'));
                    }
                }
            }


            if (!Alerts::has_field_errors() && !Alerts::has_errors() && !Alerts::has_infos()) {

                /* If remember me is checked, log the user with cookies for 30 days else, remember just with a session */

                $token_code = $user->token_code;
                /* Generate a new token */
                if (empty($token_code)) {
                    $token_code = md5($user->email . microtime());
                    db()->where('user_id', $user->user_id)->update('users', ['token_code' => $token_code]);
                }

                if (isset($_POST['rememberme'])) {
                    setcookie('user_id', $user->user_id, time() + (60 * 60 * 24 * 90), COOKIE_PATH);
                    setcookie('token_code', $token_code, time() + (60 * 60 * 24 * 90), COOKIE_PATH);
                    setcookie('user_password_hash', md5($user->password), time() + (60 * 60 * 24 * 90), COOKIE_PATH);
                } else {

                    $_SESSION['user_id'] = $user->user_id;
                    $_SESSION['user_password_hash'] = md5($user->password);

                    setcookie('user_id', $user->user_id, time() + (60 * 60 * 24 * 90), COOKIE_PATH);
                    setcookie('token_code', $token_code, time() + (60 * 60 * 24 * 90), COOKIE_PATH);
                    setcookie('user_password_hash', md5($user->password), time() + (60 * 60 * 24 * 90), COOKIE_PATH);
                }


                unset($_SESSION['twofa_required']);
                unset($_SESSION['verify_code']);
                setcookie('qr_code_id', '', time() - 7200, '/');
                setcookie('qr_uid', '', time() - 7200, '/');

                (new User())->login_aftermath_update($user->user_id);


                if ($promo && $promo != '') {
                    $redirect = $redirect . '?promo=' . $promo;
                }

                if (\Altum\Language::$name == $user->language) {
                    redirect($redirect);
                } else {
                    redirect((\Altum\Language::$active_languages[$user->language] ? \Altum\Language::$active_languages[$user->language] . '/' : null) . $redirect, true);
                }

                return Response::jsonapi_success($user, null, 200);
            }
        }

        if (empty($_POST)) {
            unset($_SESSION['twofa_required']);
            unset($_SESSION['verify_code']);
        }

        /* Prepare the View */
        $data = [
            'captcha' => $captcha,
            'values' => $values,
            'user' => $user ?? null
        ];

        $view = new \Altum\Views\View('login/index', (array) $this);

        $this->add_view_content('content', $view->run($data));
    }

    /* After a successful social login auth, register or login the user */
    private function process_social_login($email, $name, $redirect, $method, $lang_code, $utmId, $utmSource, $utmMedium, $utmContent, $utmTerm, $gaId, $matchType, $promo, $userId, $onBording,  $google_click_id)
    {

        if ($user = db()->where('email', $email)->getOne('users', ['user_id', 'email', 'password', 'lost_password_code', 'language', 'token_code'])) {

            // (new User())->verify_null_password($user->user_id, $user->email, $user->password);

            $_SESSION['user_id'] = $user->user_id;
            $_SESSION['user_password_hash'] = md5($user->password);

            $_SESSION['auth'] = 'google';

            (new User())->login_aftermath_update($user->user_id, $method);
            // user session table update

     
            if ($promo) {
                $redirect = $redirect . '?promo=' . $promo;
            } else {
                $redirect = 'qr-codes';
            }


            $token_code = $user->token_code;
            /* Generate a new token */
            if (empty($token_code)) {
                $token_code = md5($user->email . microtime());
                db()->where('user_id', $user->user_id)->update('users', ['token_code' => $token_code]);
            }

            if (isset($_POST['rememberme'])) {

                setcookie('user_id', $user->user_id, time() + (60 * 60 * 24 * 90), COOKIE_PATH);
                setcookie('token_code', $token_code, time() + (60 * 60 * 24 * 90), COOKIE_PATH);
                setcookie('user_password_hash', md5($user->password), time() + (60 * 60 * 24 * 90), COOKIE_PATH);
            } else {

                $_SESSION['user_id'] = $user->user_id;
                $_SESSION['user_password_hash'] = md5($user->password);

                setcookie('user_id', $user->user_id, time() + (60 * 60 * 24 * 90), COOKIE_PATH);
                setcookie('token_code', $token_code, time() + (60 * 60 * 24 * 90), COOKIE_PATH);
                setcookie('user_password_hash', md5($user->password), time() + (60 * 60 * 24 * 90), COOKIE_PATH);
            }


            unset($_SESSION['twofa_required']);
            unset($_SESSION['verify_code']);
            setcookie('qr_code_id', '', time() - 7200, '/');
            setcookie('qr_uid', '', time() - 7200, '/');

            /* Check to see if the user has a custom language set */
            if (\Altum\Language::$name == $user->language) {
                redirect($redirect);
            } else {
                redirect((\Altum\Language::$active_languages[$user->language] ? \Altum\Language::$active_languages[$user->language] . '/' : null) . $redirect, true);
            }
        } else {

            if (!Alerts::has_field_errors() && !Alerts::has_errors()) {

                $funnel   =   1;
                switch ($onBording) {
                    case 'nsf':
                        $funnel   =   2;
                        break;
                    case 'dpf':
                        $funnel   =   3;
                        break;
                    default:
                        $funnel   =   1;
                        break;
                }


                /* Determine what plan is set by default */
                $plan_id                    = 'free';
                $plan_settings              = json_encode(settings()->plan_free->settings);
                $plan_expiration_date       = date('Y-m-d H:i:s', strtotime('+10 day', strtotime(date('Y-m-d H:i:s'))));
                $password_code              = $email . microtime();
                $ipData                     = location_data();
                $referral_key               = md5(rand() . $email . microtime() . $email . microtime());


                if ($userId) {

                    if ($_COOKIE['qr_code_id']) {
                        $qr_code  = db()->where('qr_code_id', $_COOKIE['qr_code_id'])->getOne('qr_codes', ['qr_code', 'uId', 'type']);
                    }

                 
                    $get_gtm_campaign_url_data = get_gtm_campaign_url_data();

                    db()->where('user_id', $userId)->update('users', [
                        'email'                 => $email,
                        'password'              => null,
                        'type'                  => 0,
                        'name'                  => $name,
                        'source'                => $method,
                        'referral_key'          => $referral_key,
                        'onboarding_funnel'     => $funnel,
                        'gaid'                  => !is_null($get_gtm_campaign_url_data['gaid']) ? $get_gtm_campaign_url_data['gaid'] : (isset( $gaId) ?  $gaId : null),
                        'utm_term'              => !is_null($get_gtm_campaign_url_data['utm_term']) ? $get_gtm_campaign_url_data['utm_term'] : (isset($utmTerm) ? $utmTerm : null),
                        'matchtype'             => !is_null($get_gtm_campaign_url_data['matchtype']) ? $get_gtm_campaign_url_data['matchtype'] : (isset($matchType) ? $matchType : null),
                    ]);


                    setcookie('qr_code_id', '', time() - 7200, COOKIE_PATH);
                    setcookie('qr_uid', '', time() - 7200, COOKIE_PATH);
                    setcookie('nsf_qr_id', '', time() - 7200, COOKIE_PATH);
                    setcookie('nsf_user_id', '', time() - 7200, COOKIE_PATH);
                } else {

                    $registered_user = (new User())->create(
                        $email,
                        $password_code,
                        $name,
                        1,
                        $method,
                        null,
                        null,
                        $plan_id,
                        $plan_settings,
                        $plan_expiration_date,
                        $ipData->timezone ? $ipData->timezone : settings()->main->default_timezone,
                        0,
                        $funnel,
                        $lang_code,
                    );
                }


                // create promo email record
                $currentUserId = isset($registered_user['user_id']) ? $registered_user['user_id'] : $userId;

                $promo_email_rule = db()->where('user_id',  $currentUserId)->getOne('promo_email_rules');
                if (!$promo_email_rule) {

                    $month_first_email_date =  (new \DateTime())->modify('+30 days')->format('Y-m-d H:i:s');
                    $month_second_email_date =  (new \DateTime())->modify('+33 days')->format('Y-m-d H:i:s');

                    db()->insert('promo_email_rules', [
                        'user_id'                     =>  $currentUserId,
                        'email'                       => $email,
                        'month_first_email_date'      => $month_first_email_date,
                        'month_second_email_date'     => $month_second_email_date,
                    ]);
                }

                // create email user table record 
                $user_email = db()->where('user_id',  $currentUserId)->getOne('user_emails');
                if (!$user_email) {

                    $funnelType = 'DEFAULT';

                    switch ($onBording) {
                        case 'nsf':
                            $funnelType = 'NSF';
                            break;
                        case 'dpf':
                            $funnelType = 'CFF';
                            break;
                        default:
                            $funnelType = 'DEFAULT';
                            break;
                    }


                    db()->insert('user_emails', [
                        'user_id'                       => $currentUserId,
                        'email'                         => $email,
                        'download_reminder_email_date'  => (new \DateTime())->modify('+3 days')->format('Y-m-d H:i:s'),
                        'scan_qr_email_date'            => (new \DateTime())->modify('+3 days')->format('Y-m-d H:i:s'),
                        'print_qr_email_date'           => (new \DateTime())->modify('+6 days')->format('Y-m-d H:i:s'),
                        'trial_1day_email_date'         => (new \DateTime())->modify('+9 days')->format('Y-m-d H:i:s'),
                        'plan_expiry_reminder_date'     => $plan_expiration_date,
                        'funnel_type'                   => $funnelType
                    ]);
                }

                if (isset($name)) {
                    $fullName = explode(" ", $name);
                }

                $user_id  = isset($registered_user['user_id']) ? $registered_user['user_id'] : $userId;
                $user     = db()->where('user_id', $user_id)->getOne('users');

                $userGeLocation = get_user_gelocation();
                $country        = $userGeLocation['country'];

                try{
                    $stripe = new \Stripe\StripeClient(settings()->stripe->secret_key);
                    $customer = $stripe->customers->create([
                        'email' => $email,
                        'name'  => $name ? $name : null,
                        'metadata'    => [
                            'user_id'           => $user->user_id,
                            'user_email'        => $email,
                            'gaid'              => isset($user->gaid) ? $user->gaid : null,
                            'utm_term'          => isset($user->utm_term) ? $user->utm_term : null,
                            'matchtype'         => isset($user->matchtype) ? $user->matchtype : null,
                            'first_qr_type'     => isset($user->first_qr_type) ? $user->first_qr_type : null,
                            'onboarding_funnel' => $user->onboarding_funnel,
                            'country'           => $country,
                        ]    
                    ]);
                    $customerId = $customer->id;
    
                    db()->where('user_id', $user->user_id)->update('users', [
                        'stripe_customer_id' => $customerId,
                        'onboarding_funnel'  => $user->onboarding_funnel,
                    ]);

                    create_one_day_trial_subscription($customerId, $user->user_id) ;
                    

                }catch(ApiErrorException $e){
                    dil('Google Stripe customer create error - '.$user->user_id);
                }

                // Create dpf_user_emails record
                if ($onBording == 'dpf') {
                    $dpfUser = db()->where('user_id', $userId)->getOne('dpf_user_emails');
                    if (!$dpfUser) {
                        db()->insert('dpf_user_emails', [
                            'user_id'                         => $userId,
                            'email'                           => $email,
                            'download_reminder_email_date'    => (new \DateTime())->modify('+3 days')->format('Y-m-d H:i:s'),
                            'print_qr_email_date'             => (new \DateTime())->modify('+5 days')->format('Y-m-d H:i:s'),
                            'scan_qr_email_date'              => (new \DateTime())->modify('+10 days')->format('Y-m-d H:i:s'),
                            'trial_1day_email_date'           => (new \DateTime())->modify('+13 days')->format('Y-m-d H:i:s'),
                            'plan_expiry_reminder_date'       => (new \DateTime())->modify('+14 days')->format('Y-m-d H:i:s'),
                            'one_hour_email_time'             => (new \DateTime())->modify('+30 minutes')->format('Y-m-d H:i:s'),
                        ]);
                    }

                    $_SESSION['is_dpf']  = true;
                }

                if (isset($lang_code) && $lang_code) {
                    $langName = get_language_name($lang_code); 
                    try{
                        db()->where('user_id', $user->user_id)->update('users', [
                            'language' => $langName,
                        ]);
                    }catch(Exception $e){ 
                        dil($e->getCode() . ':' . $e->getMessage());
                    }
                }

                /* Send notification to admin if needed */
                if (settings()->email_notifications->new_user && !empty(settings()->email_notifications->emails)) {

                    $email_template = get_email_template(
                        [],
                        l('global.emails.admin_new_user_notification.subject'),
                        [
                            '{{NAME}}' => $name,
                            '{{EMAIL}}' => $email,
                        ],
                        l('global.emails.admin_new_user_notification.body')
                    );

                    send_mail(explode(',', settings()->email_notifications->emails), $email_template->subject, $email_template->body);
                }


                /* Send webhook notification if needed */
                if (settings()->webhooks->user_new) {

                    \Unirest\Request::post(settings()->webhooks->user_new, [], [
                        'user_id' => $registered_user['user_id'],
                        'email' => $email,
                        'name' => $name
                    ]);
                }

                $user = db()->where('email', $email)->getOne('users', ['user_id', 'email', 'password', 'lost_password_code', 'referral_key', 'language', 'token_code', 'email_subscription_type']);


                if ($userId && $onBording == 'nsf') {

                    try {
                        /* Send notification download the QR code  */

                        if ($user->email_subscription_type != 2) {
                            $link      =  'qr-download/' . $referral_key;
                            $template  = 'download-qr';
                            $email     =  trigger_email($user->user_id, $template, $link);

                        }
                    } catch (\Throwable $th) {
                        return false;
                    }
                } else if (!$onBording == 'dpf') {
                    try {
                        /* Send notification to new user if needed  */

                        if ($user->email_subscription_type != 2) {
                            $link      = 'login?redirect=qr-codes?referral_key=' .  $user->referral_key;
                            $template  = 'new-account';

                            $email     = trigger_email($user->user_id, $template, $link);

                        }
                    } catch (\Throwable $th) {
                        return false;
                    }
                }


                /* Make sure the user has a password set before letting the user login */
                $_SESSION['user_id'] = $user->user_id;
                $_SESSION['user_password_hash'] = md5($user->password);
                $_SESSION['auth_register'] = 'google';


                $token_code = $user->token_code;
                /* Generate a new token */
                if (empty($token_code)) {
                    $token_code = md5($user->email . microtime());
                    db()->where('user_id', $user->user_id)->update('users', ['token_code' => $token_code]);
                }

                setcookie('user_id', $user->user_id, time() + (60 * 60 * 24 * 90), COOKIE_PATH);
                setcookie('token_code', $token_code, time() + (60 * 60 * 24 * 90), COOKIE_PATH);
                setcookie('user_password_hash', md5($user->password), time() + (60 * 60 * 24 * 90), COOKIE_PATH);

                (new User())->login_aftermath_update($user->user_id, $method);

                if ($promo) {
                    $redirect = $redirect . '?promo=' . $promo;
                } else {
                    if ($userId && $onBording == 'nsf') {
                        $redirect = 'qr-codes';
                    } else if ($onBording == 'dpf') {
                        $redirect = 'plan-dpf?qr_onboarding=active_dpf';
                    } else {
                        $redirect = 'qr?step=1';
                    }
                }
                redirect($redirect);
               
            }
        }
    }
}
