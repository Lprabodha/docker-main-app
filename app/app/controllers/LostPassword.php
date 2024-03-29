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
use Altum\Logger;
use Altum\Middlewares\Authentication;

class LostPassword extends Controller
{

    public function index()
    {

        Authentication::guard('guest');

        /* Default values */
        $values = [
            'email' => ''
        ];

        /* Initiate captcha */
        $captcha = new Captcha();

        if (!empty($_POST)) {
            /* Clean the posted variable */
            $_POST['email'] = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $values['email'] = $_POST['email'];

            //ALTUMCODE:DEMO if(DEMO) Alerts::add_error('This command is blocked on the demo.');

            /* Check for any errors */
            if (settings()->captcha->lost_password_is_enabled && !$captcha->is_valid()) {
                Alerts::add_field_error('captcha', l('global.error_message.invalid_captcha'));
            }

            /* If there are no errors, resend the activation link */
            if (!Alerts::has_field_errors() && !Alerts::has_errors()) {

                $user = db()->where('email', $_POST['email'])->getOne('users', ['user_id', 'email', 'name', 'status', 'language', 'anti_phishing_code', 'email_subscription_type']);

                if ($user && $user->status != 2 && $user->email_subscription_type != 2) {
                    /* Define some variables */
                    $lost_password_code = md5($_POST['email'] . microtime());

                    /* Update the current activation email */
                    db()->where('user_id', $user->user_id)->update('users', ['lost_password_code' => $lost_password_code]);

                    /* Prepare the email */
            
                    $link      =  'reset-password/' . md5($_POST['email']) . '/' . $lost_password_code;
                    $template  = 'reset-password';

                    trigger_email($user->user_id, $template, $link);

                    Logger::users($user->user_id, 'lost_password.request_sent');
                }

                /* Set a nice success message */
                Alerts::add_success(l('lost_password.success_message'));
            }
        }

        /* Prepare the View */
        $data = [
            'values'    => $values,
            'captcha'   => $captcha
        ];

        $view = new \Altum\Views\View('lost-password/index', (array) $this);

        $this->add_view_content('content', $view->run($data));
    }
}
