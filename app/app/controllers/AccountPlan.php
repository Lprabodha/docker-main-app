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
use Altum\Logger;
use Altum\Middlewares\Authentication;
use Altum\Middlewares\Csrf;
use Altum\Models\Model;
use Altum\Models\Plan;
use Altum\Models\User;
use Altum\Response;

class AccountPlan extends Controller {

    public function index() {

        Authentication::guard();

        /* Get the account header menu */
        $menu = new \Altum\Views\View('partials/account_header_menu', (array) $this);
        $this->add_view_content('account_header_menu', $menu->run());

        /* Prepare the View */
        $view = new \Altum\Views\View('account-plan/index', (array) $this);

        $this->add_view_content('content', $view->run());

    }

    public function cancel_subscription() {

        Authentication::guard();

        if(!Csrf::check()) {
            Alerts::add_error(l('global.error_message.invalid_csrf_token'));
            redirect('account-plan');
        }

        if(!Alerts::has_field_errors() && !Alerts::has_errors()) {

            try {
                (new User())->cancel_subscription($this->user->user_id);
            } catch (\Exception $exception) {
                Alerts::add_error($exception->getCode() . ':' . $exception->getMessage());
                redirect('billing');
            }

            /* Set a nice success message */
            Alerts::add_success(l('account_plan.success_message.subscription_canceled'));

            redirect('account-plan');

        }

    }

}
