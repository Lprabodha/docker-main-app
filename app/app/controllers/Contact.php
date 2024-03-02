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
use Altum\Response;
use Altum\Middlewares\Authentication;
use Altum\Middlewares\Csrf;

class Contact extends Controller
{

    public function index()
    {

        // Zendesk API credentials
        $subdomain = ZENDESK_SUBDOMAIN;
        $username = ZENDESK_EMAIL;
        $token = ZENDESK_TOKEN;
        
        if (Authentication::check()) {
            $languages = \Altum\Language::$active_languages[$this->user->language];
        } else {
            $languages = isset($_POST['lang']) ? $_POST['lang'] : 'english';
        }

        //zendesk locale data
        $localeEndpoint = "https://{$subdomain}.zendesk.com/api/v2/locales/{$languages}.json";

        $ch = curl_init($localeEndpoint);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json'
        ));
        curl_setopt($ch, CURLOPT_USERPWD, "{$username}/token:{$token}");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


        $localeResponse = curl_exec($ch);

        $localeId = json_decode($localeResponse, true)['locale']['id'];

        curl_close($ch);


        /* Initiate captcha */
        $captcha = new Captcha();

        if (!empty($_POST)) {
            $_POST['name']     = mb_substr(trim(filter_var($_POST['name'], FILTER_SANITIZE_STRING)), 0, 64);
            $_POST['email']    = mb_substr(trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL)), 0, 320);
            $_POST['subject']  = mb_substr(trim(filter_var($_POST['subject'], FILTER_SANITIZE_STRING)), 0, 128);
            $_POST['message']  = str_replace("\n", '<br />',  $_POST['message']);

            /* Check for any errors */
            $required_fields = ['name', 'email', 'subject', 'message'];
            foreach ($required_fields as $field) {
                if (!isset($_POST[$field]) || (isset($_POST[$field]) && empty($_POST[$field]) && $_POST[$field] != '0')) {
                    Alerts::add_field_error($field, l('global.error_message.empty_field'));
                }
            }

            if (!Csrf::check()) {
                Alerts::add_error(l('global.error_message.invalid_csrf_token'));
            }

            if (settings()->captcha->contact_is_enabled && !$captcha->is_valid()) {
                Alerts::add_field_error('captcha', l('global.error_message.invalid_captcha'));
            }

            if (!Alerts::has_field_errors() && !Alerts::has_errors()) {

                // API endpoint and data
                $endpoint = "https://{$subdomain}.zendesk.com/api/v2/tickets.json";
                $data = array(
                    'ticket' => array(
                        'subject' =>  $_POST['subject'],
                        'comment' => array(
                            'html_body' => $_POST['message']
                        ),
                        'requester' => array(
                            'locale_id' => $localeId,
                            'name' =>  $_POST['name'],
                            'email' => $_POST['email'],
                        ),
                    )
                );



                // Convert data to JSON
                $data_string = json_encode($data);

                // Create cURL request
                $ch = curl_init($endpoint);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json'
                ));
                curl_setopt($ch, CURLOPT_USERPWD, "{$username}/token:{$token}");
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                // Execute the request
                $response = curl_exec($ch);

                // Check for errors
                if (curl_errno($ch)) {
                    echo 'Error: ' . curl_error($ch);
                } else {
                    // Print the response
                    echo $response;
                }

                // Close cURL
                curl_close($ch);


                return Response::jsonapi_success($data, null, 200);

                // /* Set a nice success message */
                Alerts::add_success(l('contact.success_message'));

                redirect('contact');
            }
        }

        $rawQuery = "SELECT `email` FROM `users`";
        $query = database()->query($rawQuery);

        $values = [
            'name' => Authentication::check() ? $this->user->name : ($_POST['name'] ??  ''),
            'email' => Authentication::check() ? $this->user->email : ($_POST['email'] ??  ''),
            'subject' => $_POST['subject'] ?? '',
            'message' => $_POST['message'] ?? '',

        ];


        /* Prepare the View */
        $data = [
            'captcha' => $captcha,
            'values' => $values,
        ];


        $view = new \Altum\Views\View('contact/index', (array) $this);

        $this->add_view_content('content', $view->run($data, $query));
    }
}
