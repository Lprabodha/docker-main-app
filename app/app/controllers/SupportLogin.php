<?php
/*
 * @copyright Copyright (c) 2021 AltumCode (https://altumcode.com/)
 *
 * This software is exclusively sold through https://altumcode.com/ by the AltumCode author.
 * Downloading this product from any other sources and running it without a proper license is illegal,
 *  except the official ones linked from https://altumcode.com/.
 */

namespace Altum\Controllers;


use Abraham\TwitterOAuth\TwitterOAuth;
use Altum\Alerts;
use Altum\Captcha;
use Altum\Database\Database;
use Altum\Logger;
use Altum\Middlewares\Authentication;
use Altum\Models\Model;
use Altum\Models\User;
use Google\Client;
use Google\Service\Oauth2;
use Altum\Response;
use Altum\Routing\Router;

class SupportLogin extends Controller
{

    public function index()
    {
       

        if(Authentication::$user->type == "1"){
            redirect('qr-codes');
        }

        if(Authentication::check()){            
            redirect('admin/users');
        }     

        $method       = (isset($this->params[0])) ? $this->params[0] : null;
        $redirect     = isset($_GET['redirect']) ? Database::clean_string($_GET['redirect']) : '';


        /* Default values */
        $values = [
            'email' => isset($_GET['email']) ? Database::clean_string($_GET['email']) : '',
            'password' => '',
            'rememberme' => isset($_POST['rememberme']),
        ];

        /* Initiate captcha */
        $captcha = new Captcha();


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
                if (empty($user->token_code)) {
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

                //  Alerts::add_info(sprintf(l('login.info_message.logged_in'), $user->name));

                /* Check to see if the user has a custom language set */

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



        $view = new \Altum\Views\View('support/login/index', (array) $this);

        $this->add_view_content('content', $view->run($data));
    }

}
