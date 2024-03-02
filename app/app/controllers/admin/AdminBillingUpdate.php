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

class AdminBillingUpdate extends Controller {

    public function index() {

        if (Authentication::is_support()) {
            redirect('admin/users');
        }

        $billing_id = isset($this->params[0]) ? $this->params[0] : null;

        /* Make sure it is either the trial / free billing or normal billings */
        switch($billing_id) {

            default:

                $billing_id = (int) $billing_id;

                /* Check if billing exists */
                if(!$billing = db()->where('billing_id', $billing_id)->getOne('billings')) {
                    redirect('admin/billings');
                }

                /* Parse the settings of the billing */
                $billing->settings = json_decode($billing->settings);

                /* Parse codes & taxes */
                $billing->taxes_ids = json_decode($billing->taxes_ids);
                $billing->codes_ids = json_decode($billing->codes_ids);

                if(in_array(settings()->license->type, ['Extended License', 'extended'])) {
                    /* Get the available taxes from the system */
                    $taxes = db()->get('taxes');

                    /* Get the available codes from the system */
                    $codes = db()->get('codes');
                }

                break;

        }

        if(!empty($_POST)) {

            //ALTUMCODE:DEMO if(DEMO) Alerts::add_error('This command is blocked on the demo.');

            if(!Csrf::check()) {
                Alerts::add_error(l('global.error_message.invalid_csrf_token'));
            }

            switch($billing_id) {

                default:

                    $_POST['name'] = input_clean($_POST['name']);
                    $_POST['short_description'] = input_clean($_POST['short_description']);
                    $_POST['description'] = $_POST['description'];
                    $_POST['price'] = input_clean($_POST['price']);
                    $_POST['all_price'] = input_clean($_POST['all_price']);
                    $_POST['status'] = (int) $_POST['status'];

                    /* Check for any errors */
                    $required_fields = ['name', 'price', 'all_price'];
                    foreach($required_fields as $field) {
                        if(!isset($_POST[$field]) || (isset($_POST[$field]) && empty($_POST[$field]) && $_POST[$field] != '0')) {
                            Alerts::add_field_error($field, l('global.error_message.empty_field'));
                        }
                    }

                    break;

            }

            if(!Alerts::has_field_errors() && !Alerts::has_errors()) {

                /* Update the billing in database */
                switch ($billing_id) {

                    default:

                        $settings = json_encode($_POST['settings']);

                        db()->where('billing_id', $billing_id)->update('billings', [
                            'name' => $_POST['name'],
                            'short_description' => $_POST['short_description'],
                            'description' => $_POST['description'],
                            'price' => $_POST['price'],
                            'all_price' => $_POST['all_price'],
                            'status' => $_POST['status'],
                            'order' => $_POST['order'],
                        ]);

                        break;

                }

                /* Set a nice success message */
                Alerts::add_success(sprintf(l('global.success_message.update1'), '<strong>' . $billing->name . '</strong>'));

                /* Refresh the page */
                redirect('admin/billing-update/' . $billing_id);

            }

        }

        /* Main View */
        $data = [
            'billing_id' => $billing_id,
            'billing' => $billing,
            'taxes' => $taxes ?? null,
            'codes' => $codes ?? null,
        ];

        $view = new \Altum\Views\View('admin/billing-update/index', (array) $this);

        $this->add_view_content('content', $view->run($data));

    }

}
