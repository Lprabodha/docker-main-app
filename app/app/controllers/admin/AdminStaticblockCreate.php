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
use Altum\Database\Database;
use Altum\Middlewares\Authentication;
use Altum\Middlewares\Csrf;

class AdminStaticblockCreate extends Controller {

    public function index() {
        if (Authentication::is_support()) {
            redirect('admin/users');
        }

        if(!empty($_POST)) {

            /* Filter some the variables */
            $_POST['name'] = input_clean($_POST['name']);
            $_POST['description'] = $_POST['description'];
            $_POST['status'] = (int) $_POST['status'];
            $_POST['order'] = (int) $_POST['order'];
            //ALTUMCODE:DEMO if(DEMO) Alerts::add_error('This command is blocked on the demo.');
           
            /* Check for any errors */
            $required_fields = ['name'];
            foreach($required_fields as $field) {
                if(!isset($_POST[$field]) || (isset($_POST[$field]) && empty($_POST[$field]) && $_POST[$field] != '0')) {
                    Alerts::add_field_error($field, l('global.error_message.empty_field'));
                }
            }

            if(!Csrf::check()) {
                Alerts::add_error(l('global.error_message.invalid_csrf_token'));
            }
          
            if(!Alerts::has_field_errors() && !Alerts::has_errors()) {
              
                /* Database query */
                db()->insert('staticblocks', [
                    'name' => $_POST['name'],
                    'description' => $_POST['description'],
                    'status' => $_POST['status'],
                    'order' => $_POST['order'],
                    'datetime' => \Altum\Date::$date,
                ]);

                /* Set a nice success message */
                Alerts::add_success(sprintf(l('global.success_message.create1'), '<strong>' . e($_POST['name']) . '</strong>'));

                redirect('admin/staticblocks');
            }
        }


        /* Main View */
        $data = [
            'taxes' => $taxes ?? null,
            'codes' => $codes ?? null,
        ];

        $view = new \Altum\Views\View('admin/staticblock-create/index', (array) $this);

        $this->add_view_content('content', $view->run($data));

    }

}
