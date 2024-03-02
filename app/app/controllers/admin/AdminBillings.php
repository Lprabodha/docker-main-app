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
use Altum\Middlewares\Authentication;
use Altum\Middlewares\Csrf;
use Altum\Models\Model;
use Altum\Models\User;

class AdminBillings extends Controller
{

    public function index()
    {
        if (Authentication::is_support()) {
            redirect('admin/users');
        }

        $billings = db()->orderBy('`order`', 'ASC')->get('billings');

        /* Main View */
        $data = [
            'billings' => $billings
        ];

        $view = new \Altum\Views\View('admin/billings/index', (array) $this);

        $this->add_view_content('content', $view->run($data));
    }

    public function delete()
    {

        $billing_id = isset($this->params[0]) ? $this->params[0] : null;

        //ALTUMCODE:DEMO if(DEMO) Alerts::add_error('This command is blocked on the demo.');

        if (!Csrf::check('global_token')) {
            Alerts::add_error(l('global.error_message.invalid_csrf_token'));
        }

        if (!$billing = db()->where('billing_id', $billing_id)->getOne('billings', ['billing_id', 'name'])) {
            redirect('admin/billings');
        }

        /* Set a nice success message */
        Alerts::add_success(sprintf(l('global.success_message.delete1'), '<strong>' . $billing->name . '</strong>'));

        redirect('admin/billings');
    }
}
