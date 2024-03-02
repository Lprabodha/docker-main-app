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
use Exception;
use MaxMind\Db\Reader;
use Stripe\Exception\ApiErrorException;

class Register extends Controller
{

    public function index()
    {

        Authentication::guard('guest');

        /* Check for a special registration identifier */
        $unique_registration_identifier = isset($_GET['unique_registration_identifier'], $_GET['email']) && $_GET['unique_registration_identifier'] == md5($_GET['email'] . $_GET['email']) ? Database::clean_string($_GET['unique_registration_identifier']) : null;

        /* Check if Registration is enabled first */
        if (!settings()->users->register_is_enabled && (!\Altum\Plugin::is_active('teams') || (\Altum\Plugin::is_active('teams') && !$unique_registration_identifier))) {
            redirect();
        }

        $redirect     = isset($_GET['redirect']) ? Database::clean_string($_GET['redirect']) : '';
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

 
        /* Default variables */
        $values = [
            'name'            => isset($_GET['name']) ? Database::clean_string($_GET['name']) : '',
            'email'           => isset($_GET['email']) ? Database::clean_string($_GET['email']) : '',
            'password'        => '',
            'utm_medium'      => $utm_medium,
            'utm_source'      => $utm_source,
            'utm_id'          => $utm_id,
            'utm_content'     => $utm_content,
            'utm_term'        => $utm_term,
            'gaid'            => $gaid,
            'matchtype'       => $matchtype,
            'gclid'           => $gclid,
            'gbraid'          => $gbraid,
            'wbraid'          => $wbraid,
        ];

        // on bording funnel update session table
        unset($_SESSION['on_bording_register']);
        $_SESSION['on_bording_register']  = 1;


        /* Initiate captcha */
        $captcha = new Captcha();

        if (!empty($_POST)) {

            /* Clean some posted variables */
            $_POST['email'] = mb_substr(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL), 0, 320);

            /* Default variables */
            $values['name'] = $_POST['email'];
            $values['email'] = $_POST['email'];
            $values['password'] = $_POST['password'];


            /* Check for any errors */
            // $required_fields = ['name', 'email' ,'password'];
            $required_fields = ['email', 'password'];
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

            $userGeLocation = get_user_gelocation();
            $country        = $userGeLocation['country'];

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
                $plan_id                    = 'free';
                $plan_settings              = json_encode(settings()->plan_free->settings);
                $plan_expiration_date       = date('Y-m-d H:i:s', strtotime('+10 day', strtotime(date('Y-m-d H:i:s'))));
                $ipData = location_data();


                $registered_user = (new User())->create(
                    $_POST['email'],
                    $_POST['password'],
                    isset($_POST['name']) ? $_POST['name'] : '',
                    (int) !settings()->users->email_confirmation,
                    'direct',
                    $email_code,
                    null,
                    $plan_id,
                    $plan_settings,
                    $plan_expiration_date,
                    isset($ipData->timezone) ? $ipData->timezone : settings()->main->default_timezone,
                    0,
                    1,

                );

        
                try{
                    $stripe = new \Stripe\StripeClient(settings()->stripe->secret_key);
                    $customer = $stripe->customers->create([
                        'email' => $_POST['email'],
                        'name'  => isset($_POST['name']) ? $_POST['name'] : null,
                        'metadata'    => [
                            'user_id'           => $registered_user['user_id'],
                            'user_email'        => $_POST['email'],
                            'gaid'              => isset($_POST['gaid']) ? $_POST['gaid'] : null,
                            'utm_term'          => isset($_POST['utm_term']) ? $_POST['utm_term'] : null,
                            'matchtype'         => isset($_POST['matchtype']) ? $_POST['matchtype'] : null,
                            'onboarding_funnel' => 1,
                            'country'           => $country,

                        ]    
                    ]);
                    $customerId = $customer->id;
                   
    
                    db()->where('user_id', $registered_user['user_id'])->update('users', [
                        'stripe_customer_id' => $customerId,
                    ]);
                 
                   
                   create_one_day_trial_subscription($customerId, $registered_user['user_id']) ;

                }catch(ApiErrorException $e){
                    dil('Register Stripe customer create error - '.$registered_user['user_id']);
                }
               

                // create promo email record
                $promo_email_rule = db()->where('user_id', $registered_user['user_id'])->getOne('promo_email_rules');
                if (!$promo_email_rule) {

                    $month_first_email_date =  (new \DateTime())->modify('+30 days')->format('Y-m-d H:i:s');
                    $month_second_email_date =  (new \DateTime())->modify('+33 days')->format('Y-m-d H:i:s');

                    db()->insert('promo_email_rules', [
                        'user_id'                 => $registered_user['user_id'],
                        'email'                   => $_POST['email'],
                        'month_first_email_date'  => $month_first_email_date,
                        'month_second_email_date' => $month_second_email_date,
                    ]);
                }

                // create a email user table

                $user_email = db()->where('user_id', $registered_user['user_id'])->getOne('user_emails');
                if (!$user_email) {
                    db()->insert('user_emails', [
                        'user_id'                       => $registered_user['user_id'],
                        'email'                         => $_POST['email'],
                        'download_reminder_email_date'  => (new \DateTime())->modify('+3 days')->format('Y-m-d H:i:s'),
                        'scan_qr_email_date'            => (new \DateTime())->modify('+3 days')->format('Y-m-d H:i:s'),
                        'print_qr_email_date'           => (new \DateTime())->modify('+6 days')->format('Y-m-d H:i:s'),
                        'trial_1day_email_date'         => (new \DateTime())->modify('+9 days')->format('Y-m-d H:i:s'),
                        'plan_expiry_reminder_date'     => $plan_expiration_date,
                        'funnel_type'                   => 'DEFAULT'
                    ]);
                }

                $user = db()->where('email', $_POST['email'])->getOne('users', ['user_id', 'email', 'name', 'status', 'referral_key', 'password', 'token_code', 'twofa_secret', 'language', 'email_subscription_type']);
               
                if (isset($_GET['lang']) && $_GET['lang']) {   
                    $lang_code = $_GET['lang'];                       
                    $langName = get_language_name($lang_code);                
                                 
                    try{
                        db()->where('user_id', $user->user_id)->update('users', [
                            'language' => $langName,
                        ]);
                    }catch(Exception $e){ 
                        dil($e->getCode() . ':' . $e->getMessage());
                    }
                }

                /* Log the action */
                // Logger::users($registered_user['user_id'], 'register.success');

                /* Send notification to admin if needed */
                if (settings()->email_notifications->new_user && !empty(settings()->email_notifications->emails)) {

                    /* Prepare the email */
                    $email_template = get_email_template(
                        [],
                        l('global.emails.admin_new_user_notification.subject'),
                        [
                            '{{NAME}}' => isset($_POST['name']) ? str_replace('.', '. ', $_POST['name']) : $_POST['email'],
                            '{{EMAIL}}' => $_POST['email'],
                        ],
                        l('global.emails.admin_new_user_notification.body')
                    );

                    send_mail(explode(',', settings()->email_notifications->emails), $email_template->subject, $email_template->body);
                }

                try {
                    if ($user->email_subscription_type != 2) {
                        /* Send notification to new user if needed  */
                        $link          = 'login?redirect=qr-codes?referral_key=' .  $user->referral_key;
                        $template      = 'new-account';

                        $email =  trigger_email($user->user_id, $template, $link);

                    }
                } catch (\Throwable $th) {
                    return false;
                }


                /* If active = 1 then login the user, else send the user an activation email */
                if ($active == '1') {

                    /* Send webhook notification if needed */
                    if (settings()->webhooks->user_new) {

                        \Unirest\Request::post(settings()->webhooks->user_new, [], [
                            'user_id' => $registered_user['user_id'],
                            'email' => $_POST['email'],
                            'name' => isset($_POST['name']) ? $_POST['name'] : ''
                        ]);
                    }

                    $_SESSION['user_id'] =  $user->user_id;
                    $_SESSION['user_password_hash'] = md5($user->password);

                    $token_code = $user->token_code;
                    /* Generate a new token */
                    if (empty($token_code)) {
                        $token_code = md5($user->user_id . microtime());
                        db()->where('user_id', $user->user_id)->update('users', ['token_code' => $token_code]);
                    }


                    setcookie('user_id', $user->user_id, time() + (60 * 60 * 24 * 90), COOKIE_PATH);
                    setcookie('token_code', $token_code, time() + (60 * 60 * 24 * 90), COOKIE_PATH);
                    setcookie('user_password_hash', md5($user->password), time() + (60 * 60 * 24 * 90), COOKIE_PATH);
                    setcookie('qr_code_id', '', time() - 7200, '/');
                    setcookie('qr_uid', '', time() - 7200, '/');

                    if (\Altum\Language::$name == $user->language) {
                        redirect($redirect);
                    } else {
                        redirect((\Altum\Language::$active_languages[$user->language] ? \Altum\Language::$active_languages[$user->language] . '/' : null) . $redirect, true);
                    }
                } else {


                    /* Prepare the email */
                    $email_template = get_email_template(
                        [
                            '{{NAME}}' => str_replace('.', '. ', $_POST['name']),
                        ],
                        l('global.emails.user_activation.subject'),
                        [
                            '{{ACTIVATION_LINK}}' => url('activate-user?email=' . md5($_POST['email']) . '&email_activation_code=' . $email_code . '&type=user_activation' . '&redirect=' . $redirect),
                            '{{NAME}}' => isset($_POST['name']) ? str_replace('.', '. ', $_POST['name']) : $_POST['email'],
                        ],
                        l('global.emails.user_activation.body')
                    );


                    send_mail($_POST['email'], $email_template->subject, $email_template->body);

                    /* Set a nice success message */
                    Alerts::add_success(l('register.success_message.login'));
                }
            }
        }



        /* Main View */
        $data = [
            'values'            => $values,
            'captcha'           => $captcha,
            'utm_medium'        => $utm_medium,
            'utm_source'        => $utm_source,
            'utm_id'            => $utm_id,
            'utm_content'       => $utm_content,
            'utm_term'          => $utm_term,
            'gaid'              => $gaid,
            'gclid'             => $gclid,
            'gbraid'            => $gbraid,
            'wbraid'            => $wbraid,
            'matchtype'         => $matchtype,
        ];


        $view = new \Altum\Views\View('register/index', (array) $this);

        $this->add_view_content('content', $view->run($data));
    }
}
