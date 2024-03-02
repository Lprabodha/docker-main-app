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

use Stripe\Exception\ApiErrorException;

class RegisterNsf extends Controller
{

    public function index()
    {
        /* Check for a special registration identifier */
        $unique_registration_identifier = isset($_GET['unique_registration_identifier'], $_GET['email']) && $_GET['unique_registration_identifier'] == md5($_GET['email'] . $_GET['email']) ? Database::clean_string($_GET['unique_registration_identifier']) : null;

        /* Check if Registration is enabled first */
        if (!settings()->users->register_is_enabled && (!\Altum\Plugin::is_active('teams') || (\Altum\Plugin::is_active('teams') && !$unique_registration_identifier))) {
            redirect();
        }

        if (!isset($_COOKIE['user_id'])) {
            redirect('register');
        }

        if ($_COOKIE['qr_code_id']) {
            $qr_code  = db()->where('qr_code_id', $_COOKIE['qr_code_id'])->getOne('qr_codes', ['qr_code', 'uId', 'user_id']);
        }

        unset($_SESSION['new_landing']);
        unset($_SESSION['new_landing_route']);


        $redirect = isset($_GET['redirect']) ? Database::clean_string($_GET['redirect']) : '';


        $utm_id         = isset($_GET['utm_id']) ? $_GET['utm_id'] : null;
        $utm_source     = isset($_GET['utm_source']) ? $_GET['utm_source'] : null;
        $utm_medium     = isset($_GET['utm_medium']) ? $_GET['utm_medium'] : null;
        $utm_content    = isset($_GET['utm_content']) ? $_GET['utm_content'] : null;
        $utm_term       = isset($_GET['utm_term']) ? $_GET['utm_term'] : null;
        $gaid           = isset($_GET['gaid']) ? $_GET['gaid'] : null;
        $gclid          = isset($_GET['gclid']) ? $_GET['gclid'] : null;
        $gbraid         = isset($_GET['gbraid']) ? $_GET['gbraid'] : null;
        $wbraid         = isset($_GET['wbraid']) ? $_GET['wbraid'] : null;
        $matchtype      = isset($_GET['matchtype']) ? $_GET['matchtype'] : null;

    
        /* Default variables */
        $values = [
            'name'          => isset($_GET['name']) ? Database::clean_string($_GET['name']) : '',
            'email'         => isset($_GET['email']) ? Database::clean_string($_GET['email']) : '',
            'password'      => '',
            'utm_medium'    => $utm_medium,
            'utm_source'    => $utm_source,
            'utm_id'        => $utm_id,
            'utm_content'   => $utm_content,
            'utm_term'      => $utm_term,
            'gaid'          => $gaid,
            'matchtype'     => $matchtype,
            'gclid'         => $gclid,
            'gbraid'        => $gbraid,
            'wbraid'        => $wbraid,
        ];

        /* Initiate captcha */
        $captcha = new Captcha();



        if (!empty($_POST)) {

            /* Clean some posted variables */
            // $_POST['name'] = mb_substr(trim(filter_var($_POST['name'], FILTER_SANITIZE_STRING)), 0, 64);
            $_POST['email'] = mb_substr(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL), 0, 320);

            /* Default variables */
            $values['name'] = $_POST['email'];
            $values['email'] = $_POST['email'];
            // $values['password'] = $_POST['password'];


            /* Check for any errors */
            // $required_fields = ['name', 'email' ,'password'];
            $required_fields = ['email'];
            foreach ($required_fields as $field) {
                if (!isset($_POST[$field]) || (isset($_POST[$field]) && empty($_POST[$field]) && $_POST[$field] != '0')) {
                    Alerts::add_field_error($field, l('global.error_message.empty_field'));
                }
            }

            if (settings()->captcha->register_is_enabled && !$captcha->is_valid()) {
                Alerts::add_field_error('captcha', l('global.error_message.invalid_captcha'));
            }
  
            if (db()->where('email', $_POST['email'])->has('users')) {
                Alerts::add_field_error('email', l('register.error_message.email_exists'));
            }
            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                Alerts::add_field_error('email', l('global.error_message.invalid_email'));
            }

            /* Make sure the domain is not blacklisted */
            $email_domain = get_domain_from_email($_POST['email']);
            if (settings()->users->blacklisted_domains && in_array($email_domain, explode(',', settings()->users->blacklisted_domains))) {
                Alerts::add_field_error('email', l('register.error_message.blacklisted_domain'));
            }

            /* If there are no errors continue the registering process */
            if (!Alerts::has_field_errors() && !Alerts::has_errors()) {
                $values = [
                    'name' => '',
                    'email' => '',
                    'password' => '',
                ];

                /* Define some needed variables */
                $active                     = (int) !settings()->users->email_confirmation;
                $email_code                 = md5($_POST['email'] . microtime());

                /* Determine what plan is set by default */
                $referral_key               = md5(rand() . $_POST['email'] . microtime() . $_POST['email'] . microtime());
                $plan_expiration_date       = date('Y-m-d H:i:s', strtotime('+10 day', strtotime(date('Y-m-d H:i:s'))));
            

                if ($_POST['user_id']) {

                    if ($_COOKIE['qr_code_id']) {
                        $qr_code  = db()->where('qr_code_id', $_COOKIE['qr_code_id'])->getOne('qr_codes', ['qr_code', 'uId', 'type']);
                    }

                   $get_gtm_campaign_url_data = get_gtm_campaign_url_data();

                   $user =  db()->where('user_id', $_POST['user_id'])->update('users', [
                        'email'                 => $_POST['email'],
                        'password'              => null,
                        'email_activation_code' => $email_code,
                        'type'                  => 0,
                        'name'                  => isset($_POST['name']) ? $_POST['name'] : '',
                        'referral_key'          => $referral_key,
                        'gaid'                  => !is_null($get_gtm_campaign_url_data['gaid']) ? $get_gtm_campaign_url_data['gaid'] : (isset($_POST['gaid']) ? $_POST['gaid'] : null),
                        'utm_term'              => !is_null($get_gtm_campaign_url_data['utm_term']) ? $get_gtm_campaign_url_data['utm_term'] : (isset($_POST['utm_term']) ? $_POST['utm_term'] : null),
                        'matchtype'             => !is_null($get_gtm_campaign_url_data['matchtype']) ? $get_gtm_campaign_url_data['matchtype'] : (isset($_POST['matchtype']) ? $_POST['matchtype'] : null),
                    ]);

                   
                    // create promo email record
                    $promo_email_rule = db()->where('user_id', $_POST['user_id'])->getOne('promo_email_rules');
                    if (!$promo_email_rule) {

                        $month_first_email_date =  (new \DateTime())->modify('+30 days')->format('Y-m-d H:i:s');
                        $month_second_email_date =  (new \DateTime())->modify('+33 days')->format('Y-m-d H:i:s');

                        db()->insert('promo_email_rules', [
                            'user_id'                     => $_POST['user_id'],
                            'email'                       => $_POST['email'],
                            'month_first_email_date'   => $month_first_email_date,
                            'month_second_email_date'   => $month_second_email_date,
                        ]);
                    }


                    // create email user table 
                    $user_email = db()->where('user_id', $_POST['user_id'])->getOne('user_emails');
                    if (!$user_email) {
                        db()->insert('user_emails', [
                            'user_id'                       => $_POST['user_id'],
                            'email'                         => $_POST['email'],
                            'download_reminder_email_date'  => (new \DateTime())->modify('+3 days')->format('Y-m-d H:i:s'),
                            'scan_qr_email_date'            => (new \DateTime())->modify('+3 days')->format('Y-m-d H:i:s'),
                            'print_qr_email_date'           => (new \DateTime())->modify('+6 days')->format('Y-m-d H:i:s'),
                            'trial_1day_email_date'         => (new \DateTime())->modify('+9 days')->format('Y-m-d H:i:s'),
                            'plan_expiry_reminder_date'     => $plan_expiration_date,
                            'funnel_type'                   => 'NSF'
                        ]);
                    }
                 
                    setcookie('qr_code_id', '', time() - 7200, COOKIE_PATH);
                    setcookie('qr_uid', '', time() - 7200, COOKIE_PATH);
                    setcookie('nsf_qr_id', '', time() - 7200, COOKIE_PATH);
                    setcookie('nsf_user_id', '', time() - 7200, COOKIE_PATH);
                }

                $userGeLocation = get_user_gelocation();
                $country        = $userGeLocation['country'];

                $user = db()->where('user_id', $_POST['user_id'])->getOne('users');

                try{
                    $stripe = new \Stripe\StripeClient(settings()->stripe->secret_key);
                    $customer = $stripe->customers->create([
                        'email' => $_POST['email'],
                        'name'  => isset($_POST['name']) ? $_POST['name'] : null,
                        'metadata'    => [
                            'user_id'    => $_POST['user_id'],
                            'user_email' => $_POST['email'],
                            'gaid'              => isset($user->gaid) ? $user->gaid : null,
                            'utm_term'          => isset($user->utm_term) ? $user->utm_term : null,
                            'matchtype'         => isset($user->matchtype) ? $user->matchtype : null,
                            'first_qr_type'     => isset($user->first_qr_type) ? $user->first_qr_type : null,
                            'onboarding_funnel' => 2,
                            'country' => $country,
                        ]    
                    ]);
                    $customerId = $customer->id;
    
                    db()->where('user_id', $_POST['user_id'])->update('users', [
                        'stripe_customer_id' => $customerId,
                        'onboarding_funnel'  => 2,
                    ]);

                    create_one_day_trial_subscription($customerId, $_POST['user_id']) ;

                   
                   

                }catch(ApiErrorException $e){
                    dil('NSF stripe customer create error - '.$_POST['user_id']);
                }
           
                $lang_code = $_GET['lang'];

                if ($lang_code) {
                    $langName = settings()->main->default_language;
                    foreach (\Altum\Language::$languages as $key => $language) {
                        if ($language['code'] == $lang_code) {
                            $langName = $language['name'];
                        }
                    }

                    db()->where('email', $_POST['email'])->update('users', [
                        'language' => $langName,
                    ]);
                }

                try {

                    if ($user->email_subscription_type != 2) {
                        /* Send notification download the QR code  */
                        $link      = 'qr-download/' . $referral_key;
                        $template  = 'download-qr';
                        trigger_email($user->user_id, $template, $link);

                    }
                } catch (\Throwable $th) {
                    return false;
                }

      
                /* If active = 1 then login the user, else send the user an activation email */
                if ($active == '1') {


                    $_SESSION['user_id']            =  $user->user_id;
                    $_SESSION['user_password_hash'] = md5($user->password);

                    $token_code = $user->token_code;
                    /* Generate a new token */
                    if (empty($user->token_code)) {
                        $token_code = md5($user->user_id . microtime());
                        db()->where('user_id', $user->user_id)->update('users', ['token_code' => $token_code]);
                    }

                    setcookie('user_id', $user->user_id, time() + (60 * 60 * 24 * 90), COOKIE_PATH);
                    setcookie('token_code', $token_code, time() + (60 * 60 * 24 * 90), COOKIE_PATH);
                    setcookie('user_password_hash', md5($user->password), time() + (60 * 60 * 24 * 90), COOKIE_PATH);

                    redirect($redirect);
                }
            }
        }

        setcookie('nsf_qr_id', $qr_code->uId, time() + (60 * 60 * 2 ), COOKIE_PATH);
        setcookie('nsf_user_id', $qr_code->user_id, time() + (60 * 60 * 2), COOKIE_PATH);

        /* Main View */
        $data = [
            'values'        => $values,
            'captcha'       => $captcha,
            'utm_medium'    => $utm_medium,
            'utm_source'    => $utm_source,
            'utm_id'        => $utm_id,
            'utm_content'   => $utm_content,
            'utm_term'      => $utm_term,
            'gaid'          => $gaid,
            'gclid'         => $gclid,
            'gbraid'        => $gbraid,
            'wbraid'        => $wbraid,
            'matchtype'     => $matchtype,
            'qr_code'       => isset($qr_code) ? $qr_code : null,
            'authMethod'    => 'Email',
            'user_id'       => $qr_code->user_id,
        ];


        $view = new \Altum\Views\View('register-nsf/index', (array) $this);

        $this->add_view_content('content', $view->run($data));
    }
}
