<?php
/*
 * @copyright Copyright (c) 2021 AltumCode (https://altumcode.com/)
 *
 * This software is exclusively sold through https://altumcode.com/ by the AltumCode author.
 * Downloading this product from any other sources and running it without a proper license is illegal,
 *  except the official ones linked from https://altumcode.com/.
 */

namespace Altum\Controllers;


use Altum\Middlewares\Authentication;


class PlanDpf extends Controller
{

    public function index()
    {
        Authentication::guard();

        $qr_code  =  db()->where('user_id', $this->user->user_id)->getOne('qr_codes');

        $onlineUser =  db()->where('user_id', $this->user->user_id)->getOne('dpf_online');
        // Set user status to  online
        if ($onlineUser) {
            db()->where('user_id', $this->user->user_id)->update('dpf_online', [
                'last_activity' => (new \DateTime())->format('Y-m-d H:i:s')
            ]);
        } else {
            db()->insert('dpf_online', [
                'user_id'           => $this->user->user_id,
                'status'            => 'online',
                'last_activity' => (new \DateTime())->format('Y-m-d H:i:s')
            ]);
        }

        if (isset($_SESSION['clientSecret'])) {
            unset($_SESSION['clientSecret']);
        }

        if (!isset($_SESSION['is_dpf'])) {
            redirect();
        }

        $current_page = $_SERVER['REQUEST_URI'];

        $url_components = parse_url($current_page);
        parse_str(isset($url_components['query']) ? $url_components['query'] : '', $params);
        $query_string   = http_build_query($params);

        $method = null;
        if (isset($_SESSION['auth_register']) && $_SESSION['auth_register'] == 'google') {
            $method = 'Google';
            unset($_SESSION['auth_register']);
        } else if (isset($_SERVER['HTTP_REFERER'])) {

            if (url('register-dpf') == $_SERVER['HTTP_REFERER']) {
                $method = 'Email';
            } else {
                $reffer = explode('?', $_SERVER['HTTP_REFERER']);
                if ($reffer[0] == url('register-dpf')) {
                    $method = 'Email';
                }
            }
        }

        /* Main View */
        $data = [
            'query_string' => $query_string,
            'qr_code'       => isset($qr_code) ? $qr_code : null,
            'user_id'       => $qr_code->user_id,
            'auth_method'   => $method,
        ];

        if (isset($_SESSION['auth']) && $_SESSION['auth'] == 'google') {
            /* Main View */
            $data = [
                'query_string' => $query_string,
                'qr_code'       => isset($qr_code) ? $qr_code : null,
                'user_id'       => $qr_code->user_id,
                'auth_method'   => $method,
            ];

            unset($_SESSION['auth']);
        }

        $view = new \Altum\Views\View('plan-dpf/index', (array) $this);
        $this->add_view_content('content', $view->run($data));
    }
}
