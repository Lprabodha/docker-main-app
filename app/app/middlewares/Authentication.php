<?php
/*
 * @copyright Copyright (c) 2021 AltumCode (https://altumcode.com/)
 *
 * This software is exclusively sold through https://altumcode.com/ by the AltumCode author.
 * Downloading this product from any other sources and running it without a proper license is illegal,
 *  except the official ones linked from https://altumcode.com/.
 */

namespace Altum\Middlewares;

use Altum\Database\Database;
use Altum\Models\User;

class Authentication extends Middleware
{

    public static $is_logged_in = null;
    public static $user_id = null;
    public static $user = null;



    public static function check()
    {

        /* Verify if the current route allows use to do the check */
        if (\Altum\Routing\Router::$controller_settings['no_authentication_check']) {
            return false;
        }

        /* Already logged in from previous checks */
        if (self::$is_logged_in) {
            return self::$user_id;
        }

        /* Check the cookies first */
        if (
            isset($_COOKIE['user_id'])
            && isset($_COOKIE['token_code'])
            && mb_strlen($_COOKIE['token_code']) > 0
            && $user = (new User())->get_user_by_user_id_and_token_code($_COOKIE['user_id'], $_COOKIE['token_code'])
        ) {


            if (isset($_COOKIE['user_password_hash']) && $_COOKIE['user_password_hash'] == md5($user->password)) {
                self::$is_logged_in = true;
                self::$user_id = $user->user_id;

                self::$user = $user;

                return true;
            }
        }

        /* Check the Session */
        if (
            isset($_SESSION['user_id'])
            && !empty($_SESSION['user_id'])
            && $user = (new User())->get_user_by_user_id($_SESSION['user_id'])
        ) {
            if (isset($_SESSION['user_password_hash']) && $_SESSION['user_password_hash'] == md5($user->password)) {
                self::$is_logged_in = true;
                self::$user_id = $user->user_id;

                self::$user = $user;

                return true;
            }
        }

        return false;
    }


    public static function is_admin()
    {

        if (!self::check()) {
            return false;
        }

        return self::$user->type > 0;
    }

    public static function is_support()
    {
        if (!self::check()) {
            return false;
        }

        if (self::$user->type == '3') {
            return true;
        } else {
            return false;
        }
    }


    public static function is_temp_user()
    {
        if (!self::check()) {
            return false;
        }
        return self::$user->type == 2;
    }



    public static function guard($permission = 'user')
    {

        switch ($permission) {
            case 'guest':

                if (self::check()) {

                    if (Authentication::is_temp_user()) {
                        Authentication::logout();
                        return false;
                    }
                    redirect(isset($_GET['redirect']) ? $_GET['redirect'] : 'qr-codes');
                }

                break;
            case 'user':

                if (!self::check() || (self::check() && self::$user->status != 1)) {
                    redirect();
                }

                break;

            case 'admin':
                if (!self::check() || (self::check() && (self::$user->status != 1 || (self::$user->type != '1' && self::$user->type != '3')))) {
                    redirect();
                }

                break;
        }
    }


    public static function logout($page = '')
    {

        if (self::check()) {
            db()->where('user_id', self::$user_id)->update('users', ['token_code' => '']);

            /* Clear the cache */
            \Altum\Cache::$adapter->deleteItemsByTag('user_id=' . self::$user_id);
        }

        session_destroy();
        setcookie('user_id', '', time() - 30, COOKIE_PATH);
        setcookie('token_code', '', time() - 30, COOKIE_PATH);
        setcookie('user_password_hash', '', time() - 30, COOKIE_PATH);

        if ($page !== false) {
            redirect($page);
        }
    }

    public static function get_authorization_bearer()
    {
        $headers = getallheaders();
        $authorization_header = $headers['Authorization'] ?? $headers['authorization'] ?? null;

        if (!$authorization_header) {
            return null;
        }

        if (!preg_match('/Bearer\s(\S+)/', $authorization_header, $matches)) {
            return null;
        }

        return $matches[1];
    }
}
