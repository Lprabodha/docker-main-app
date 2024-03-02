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
use Altum\Date;
use Altum\Middlewares\Authentication;
use Altum\Middlewares\Csrf;
use Altum\Models\QrCode;
use Altum\Uploads;
use Aws\S3\S3Client;
use JmesPath\Env;


class QrCodeUpdate extends Controller
{

    public function index()
    {

        Authentication::guard();

        /* Team checks */
        if (\Altum\Teams::is_delegated() && !\Altum\Teams::has_access('update')) {
            Alerts::add_info(l('global.info_message.team_no_access'));
            redirect('qr-codes');
        }

        $qr_code_id = isset($this->params[0]) ? (int) $this->params[0] : null;

        if (!$qr_code = db()->where('qr_code_id', $qr_code_id)->where('user_id', $this->user->user_id)->getOne('qr_codes')) {
            redirect('qr-codes');
        }


        $data =  null;
        $existingData = json_decode($qr_code->data, true);
        $qr_code->settings = json_decode($qr_code->settings);


        $qr_code_settings = require APP_PATH . 'includes/qr_code.php';

        /* Existing projects */
        $projects = (new \Altum\Models\Projects())->get_projects_by_user_id($this->user->user_id);

        /* Existing links */
        $links = (new \Altum\Models\Link())->get_full_links_by_user_id($this->user->user_id);

        $total_rows_name = database()->query("SELECT COUNT(*) AS `total` FROM `qr_codes` WHERE `user_id` = {$this->user->user_id} AND `name` LIKE '%My QR Code%' AND `status` != '3' AND `qr_code_id` != '$qr_code_id'")->fetch_object()->total ?? 0;

        if (!empty($_POST)) {

            $required_fields = ['type'];
            $settings = [];


            if (isset($_FILES['screen']) && $_FILES['screen']['name'] != "") {
                $_POST['welcomescreen'] = $existingData['welcomescreen'];
            }

            if (isset($_FILES['offerImage']) && $_FILES['offerImage']['name'] == null) {
                $_POST['offerImage'] = $existingData['offerImage'];
            }


            $_POST['files'] = array();
            $_POST['files'] = isset($existingData['files']);

            $_POST['name'] = (isset($_POST['name']) && $_POST['name'] != "") ? trim(Database::clean_string($_POST['name'])) : "";
            if ($_POST['name'] == "") {
                $n_i = $total_rows_name + 1;
                do {
                    $name = "My QR Code " . ($n_i);
                    $total_rows_name_check = database()->query("SELECT COUNT(*) AS `total` FROM `qr_codes` WHERE `user_id` = {$_POST['userIdAjax']} AND `name` = '$name' AND `status` != '3'  AND `qr_code_id` != '$qr_code_id'")->fetch_object()->total ?? 0;
                    $n_i++;
                    $_POST['name'] = $name;
                } while ($total_rows_name_check != 0);
            }


            $_POST['project_id'] = !empty($_POST['project_id']) && array_key_exists($_POST['project_id'], $projects) ? (int) $_POST['project_id'] : null;
            $_POST['type'] = isset($_POST['type']) && array_key_exists($_POST['type'], $qr_code_settings['type']) ? $_POST['type'] : 'text';
            $settings['style'] = $_POST['style'] = isset($_POST['style']) && in_array($_POST['style'], ['square', 'dot', 'round', 'extra_rounded', 'heart', 'diamond']) ? $_POST['style'] : 'square';
            $settings['foreground_type'] = $_POST['foreground_type'] = isset($_POST['foreground_type']) && in_array($_POST['foreground_type'], ['color', 'gradient']) ? $_POST['foreground_type'] : 'color';
            switch ($_POST['foreground_type']) {
                case 'color':
                    $settings['foreground_color'] = $_POST['foreground_color'] = isset($_POST['foreground_color']) && preg_match('/#([A-Fa-f0-9]{3,4}){1,2}\b/i', $_POST['foreground_color']) ? $_POST['foreground_color'] : '#000000';
                    break;

                case 'gradient':
                    $settings['foreground_gradient_style'] = $_POST['foreground_gradient_style'] = isset($_POST['foreground_gradient_style']) && in_array($_POST['foreground_gradient_style'], ['vertical', 'horizontal', 'diagonal', 'inverse_diagonal', 'radial']) ? $_POST['foreground_gradient_style'] : 'horizontal';
                    $settings['foreground_gradient_one'] = $_POST['foreground_gradient_one'] = isset($_POST['foreground_gradient_one']) && preg_match('/#([A-Fa-f0-9]{3,4}){1,2}\b/i', $_POST['foreground_gradient_one']) ? $_POST['foreground_gradient_one'] : '#000000';
                    $settings['foreground_gradient_two'] = $_POST['foreground_gradient_two'] = isset($_POST['foreground_gradient_two']) && preg_match('/#([A-Fa-f0-9]{3,4}){1,2}\b/i', $_POST['foreground_gradient_two']) ? $_POST['foreground_gradient_two'] : '#000000';
                    break;
            }
            $settings['background_color'] = $_POST['background_color'] = isset($_POST['background_color']) && preg_match('/#([A-Fa-f0-9]{3,4}){1,2}\b/i', $_POST['background_color']) ? $_POST['background_color'] : '#ffffff';
            $settings['background_color_transparency'] = $_POST['background_color_transparency'] = isset($_POST['background_color_transparency']) && in_array($_POST['background_color_transparency'], range(0, 100)) ? (int) $_POST['background_color_transparency'] : 0;
            $settings['custom_eyes_color'] = $_POST['custom_eyes_color'] = (bool) (int) ($_POST['custom_eyes_color'] ?? 0);
            if ($_POST['custom_eyes_color']) {
                $settings['eyes_inner_color'] = $_POST['eyes_inner_color'] = isset($_POST['eyes_inner_color']) && preg_match('/#([A-Fa-f0-9]{3,4}){1,2}\b/i', $_POST['eyes_inner_color']) ? $_POST['eyes_inner_color'] : '#000000';
                $settings['eyes_outer_color'] = $_POST['eyes_outer_color'] = isset($_POST['eyes_outer_color']) && preg_match('/#([A-Fa-f0-9]{3,4}){1,2}\b/i', $_POST['eyes_outer_color']) ? $_POST['eyes_outer_color'] : '#000000';
            }


            $settings['qr_code_logo_size'] = $_POST['qr_code_logo_size'] = isset($_POST['qr_code_logo_size']) && in_array($_POST['qr_code_logo_size'], range(5, 35)) ? (int) $_POST['qr_code_logo_size'] : 25;

            $settings['size'] = $_POST['size'] = isset($_POST['size']) && in_array($_POST['size'], range(50, 2000)) ? (int) $_POST['size'] : 500;
            $settings['margin'] = $_POST['margin'] = isset($_POST['margin']) && in_array($_POST['margin'], range(0, 25)) ? (int) $_POST['margin'] : 1;
            $settings['ecc'] = $_POST['ecc'] = isset($_POST['ecc']) && in_array($_POST['ecc'], ['L', 'M', 'Q', 'H']) ? $_POST['ecc'] : 'M';

            /* Type dependant vars */
            switch ($_POST['type']) {
                case 'text':
                    $required_fields[] = 'text';
                    $settings['text'] = $_POST['text'] = mb_substr(input_clean($_POST['text']), 0, $qr_code_settings['type']['text']['max_length']);
                    break;

                case 'url':
                    $required_fields[] = 'url';
                    $settings['url'] = $_POST['url'] = mb_substr(input_clean($_POST['url']), 0, $qr_code_settings['type']['url']['max_length']);

                    if (isset($_POST['link_id']) && isset($_POST['url_dynamic'])) {
                        $link = db()->where('link_id', $_POST['link_id'])->where('user_id', $this->user->user_id)->getOne('links', ['link_id']);

                        if (!$link) {
                            unset($_POST['link_id']);
                        }
                    } else {
                        $_POST['link_id'] = null;
                    }

                    break;
                case 'phone':
                    $required_fields[] = 'phone';
                    $settings['phone'] = $_POST['phone'] = mb_substr(input_clean($_POST['phone']), 0, $qr_code_settings['type']['phone']['max_length']);
                    break;

                case 'sms':
                    $required_fields[] = 'sms';
                    $settings['sms'] = $_POST['sms'] = mb_substr(input_clean($_POST['sms']), 0, $qr_code_settings['type']['sms']['max_length']);
                    $settings['sms_body'] = $_POST['sms_body'] = mb_substr(input_clean($_POST['sms_body']), 0, $qr_code_settings['type']['sms']['body']['max_length']);
                    break;

                case 'email':
                    $required_fields[] = 'email';
                    $settings['email'] = $_POST['email'] = mb_substr(input_clean($_POST['email']), 0, $qr_code_settings['type']['email']['max_length']);
                    $settings['email_subject'] = $_POST['email_subject'] = mb_substr(input_clean($_POST['email_subject']), 0, $qr_code_settings['type']['email']['subject']['max_length']);
                    $settings['email_body'] = $_POST['email_body'] = mb_substr(input_clean($_POST['email_body']), 0, $qr_code_settings['type']['email']['body']['max_length']);
                    break;

                case 'whatsapp':
                    $required_fields[] = 'whatsapp';
                    $settings['whatsapp'] = $_POST['whatsapp'] = mb_substr(input_clean($_POST['whatsapp']), 0, $qr_code_settings['type']['whatsapp']['max_length']);
                    $settings['whatsapp_body'] = $_POST['whatsapp_body'] = mb_substr(input_clean($_POST['whatsapp_body']), 0, $qr_code_settings['type']['whatsapp']['body']['max_length']);
                    break;

                case 'facetime':
                    $required_fields[] = 'facetime';
                    $settings['facetime'] = $_POST['facetime'] = mb_substr(input_clean($_POST['facetime']), 0, $qr_code_settings['type']['facetime']['max_length']);
                    break;

                case 'location':
                    $required_fields[] = 'location_latitude';
                    $required_fields[] = 'location_longitude';
                    $settings['location_latitude'] = $_POST['location_latitude'] = (float) mb_substr(input_clean($_POST['location_latitude']), 0, $qr_code_settings['type']['location']['latitude']['max_length']);
                    $settings['location_longitude'] = $_POST['location_longitude'] = (float) mb_substr(input_clean($_POST['location_longitude']), 0, $qr_code_settings['type']['location']['longitude']['max_length']);
                    break;

                case 'wifi':
                    $required_fields[] = 'wifi_ssid';
                    $settings['wifi_ssid'] = $_POST['wifi_ssid'] = mb_substr(input_clean($_POST['wifi_ssid']), 0, $qr_code_settings['type']['wifi']['ssid']['max_length']);
                    $settings['wifi_encryption'] = $_POST['wifi_encryption'] = isset($_POST['wifi_encryption']) && in_array($_POST['wifi_encryption'], ['nopass', 'WPA', 'WEP', 'WPA/WPA2']) ? $_POST['wifi_encryption'] : 'nopass';
                    $settings['wifi_password'] = $_POST['wifi_password'] = mb_substr(input_clean($_POST['wifi_password']), 0, $qr_code_settings['type']['wifi']['password']['max_length']);
                    $settings['wifi_is_hidden'] = $_POST['wifi_is_hidden'] = (int) isset($_POST['wifi_is_hidden']);


                    $data_to_be_rendered = 'WIFI:S:' . $_POST['wifi_ssid'] . ';';
                    $data_to_be_rendered .= 'T:' . $_POST['wifi_encryption'] . ';';
                    if ($_POST['wifi_password']) $data_to_be_rendered .= 'P:' . $_POST['wifi_password'] . ';';
                    if ($_POST['wifi_is_hidden']) $data_to_be_rendered .= 'H:' . (bool) $_POST['wifi_is_hidden'] . ';';
                    $data_to_be_rendered .= ';';

                    $data = $data_to_be_rendered;

                    break;

                case 'event':
                    $required_fields[] = 'event';
                    $settings['event'] = $_POST['event'] = mb_substr(input_clean($_POST['event']), 0, $qr_code_settings['type']['event']['max_length']);
                    $settings['event_location'] = $_POST['event_location'] = mb_substr(input_clean($_POST['event_location']), 0, $qr_code_settings['type']['event']['location']['max_length']);
                    $settings['event_url'] = $_POST['event_url'] = mb_substr(input_clean($_POST['event_url']), 0, $qr_code_settings['type']['event']['url']['max_length']);
                    $settings['event_note'] = $_POST['event_note'] = mb_substr(input_clean($_POST['event_note']), 0, $qr_code_settings['type']['event']['note']['max_length']);
                    $settings['event_timezone'] = $_POST['event_timezone'] = in_array($_POST['event_timezone'], \DateTimeZone::listIdentifiers()) ? filter_var($_POST['event_timezone'], FILTER_SANITIZE_STRING) : Date::$default_timezone;
                    $settings['event_start_datetime'] = $_POST['event_start_datetime'] = (new \DateTime($_POST['event_start_datetime']))->format('Y-m-d\TH:i:s');
                    $settings['event_end_datetime'] = $_POST['event_end_datetime'] = (new \DateTime($_POST['event_end_datetime']))->format('Y-m-d\TH:i:s');
                    break;

                case 'crypto':
                    $required_fields[] = 'crypto_address';
                    $settings['crypto_coin'] = $_POST['crypto_coin'] = isset($_POST['crypto_coin']) && array_key_exists($_POST['crypto_coin'], $qr_code_settings['type']['crypto']['coins']) ? $_POST['crypto_coin'] : array_key_first($qr_code_settings['type']['crypto']['coins']);
                    $settings['crypto_address'] = $_POST['crypto_address'] = mb_substr(input_clean($_POST['crypto_address']), 0, $qr_code_settings['type']['crypto']['address']['max_length']);
                    $settings['crypto_amount'] = $_POST['crypto_amount'] = isset($_POST['crypto_amount']) ? (float) $_POST['crypto_amount'] : null;
                    break;

                case 'vcard':

                    $settings['vcard_first_name'] = $_POST['vcard_first_name'] = mb_substr(input_clean($_POST['vcard_first_name']), 0, $qr_code_settings['type']['vcard']['first_name']['max_length']);
                    $settings['vcard_last_name'] = $_POST['vcard_last_name'] = mb_substr(input_clean($_POST['vcard_last_name']), 0, $qr_code_settings['type']['vcard']['last_name']['max_length']);
                    $settings['vcard_company'] = $_POST['vcard_company'] = mb_substr(input_clean($_POST['vcard_company']), 0, $qr_code_settings['type']['vcard']['company']['max_length']);
                    $settings['vcard_job_title'] = $_POST['vcard_job_title'] = mb_substr(input_clean(isset($_POST['vcard_job_title'])), 0, $qr_code_settings['type']['vcard']['job_title']['max_length']);
                    $settings['vcard_birthday'] = $_POST['vcard_birthday'] = mb_substr(input_clean(isset($_POST['vcard_birthday'])), 0, $qr_code_settings['type']['vcard']['birthday']['max_length']);
                    $settings['vcard_street'] = $_POST['vcard_street'] = mb_substr(input_clean(isset($_POST['vcard_street'])), 0, $qr_code_settings['type']['vcard']['street']['max_length']);
                    $settings['vcard_city'] = $_POST['vcard_city'] = mb_substr(input_clean(isset($_POST['vcard_city'])), 0, $qr_code_settings['type']['vcard']['city']['max_length']);
                    $settings['vcard_zip'] = $_POST['vcard_zip'] = mb_substr(input_clean(isset($_POST['vcard_zip'])), 0, $qr_code_settings['type']['vcard']['zip']['max_length']);
                    $settings['vcard_region'] = $_POST['vcard_region'] = mb_substr(input_clean(isset($_POST['vcard_region'])), 0, $qr_code_settings['type']['vcard']['region']['max_length']);
                    $settings['vcard_country'] = $_POST['vcard_country'] = mb_substr(input_clean(isset($_POST['vcard_country'])), 0, $qr_code_settings['type']['vcard']['country']['max_length']);
                    $settings['vcard_note'] = $_POST['vcard_note'] = mb_substr(input_clean($_POST['vcard_note']), 0, $qr_code_settings['type']['vcard']['note']['max_length']);

                    if (!isset($_POST['vcard_social_label'])) {
                        $_POST['vcard_social_label'] = [];
                        $_POST['vcard_social_value'] = [];
                    }


                    $vcard_socials = [];
                    foreach ($_POST['vcard_social_label'] as $key => $value) {
                        if (empty(trim($value))) continue;
                        if ($key >= 20) continue;

                        $vcard_socials[] = [
                            'label' => mb_substr(input_clean($value), 0, $qr_code_settings['type']['vcard']['social_value']['max_length']),
                            'value' => mb_substr(input_clean($_POST['vcard_social_value'][$key]), 0, $qr_code_settings['type']['vcard']['social_value']['max_length'])
                        ];
                    }
                    $settings['vcard_socials'] = $vcard_socials;



                    break;

                case 'paypal':
                    $required_fields[] = 'paypal_email';
                    $required_fields[] = 'paypal_title';
                    $required_fields[] = 'paypal_currency';
                    $required_fields[] = 'paypal_price';
                    $settings['paypal_type'] = $_POST['paypal_type'] = isset($_POST['paypal_type']) && array_key_exists($_POST['paypal_type'], $qr_code_settings['type']['paypal']['type']) ? $_POST['paypal_type'] : array_key_first($qr_code_settings['type']['paypal']['type']);
                    $settings['paypal_email'] = $_POST['paypal_email'] = mb_substr(input_clean($_POST['paypal_email']), 0, $qr_code_settings['type']['paypal']['email']['max_length']);
                    $settings['paypal_title'] = $_POST['paypal_title'] = mb_substr(input_clean($_POST['paypal_title']), 0, $qr_code_settings['type']['paypal']['title']['max_length']);
                    $settings['paypal_currency'] = $_POST['paypal_currency'] = mb_substr(input_clean($_POST['paypal_currency']), 0, $qr_code_settings['type']['paypal']['currency']['max_length']);
                    $settings['paypal_price'] = $_POST['paypal_price'] = (float) $_POST['paypal_price'];
                    $settings['paypal_thank_you_url'] = $_POST['paypal_thank_you_url'] = mb_substr(input_clean($_POST['paypal_thank_you_url']), 0, $qr_code_settings['type']['paypal']['thank_you_url']['max_length']);
                    $settings['paypal_cancel_url'] = $_POST['paypal_cancel_url'] = mb_substr(input_clean($_POST['paypal_cancel_url']), 0, $qr_code_settings['type']['paypal']['cancel_url']['max_length']);
                    break;


                case 'feedback':


                    $feedbackCategories = [];
                    $feedbackSubCategories = [];
                    foreach ($_POST['feedback-categories'] as $key => $category) {
                        $id =  $key + 1;

                        $feedbackCategories[]   = [
                            'name'  => $category ? $category : null,
                            'icon'  =>  $_POST['feedback-categories-icon'] ? $_POST['feedback-categories-icon'][$key] : null,
                        ];

                        foreach ($_POST['sub_categories_' . $id] as $sub) {
                            $feedbackSubCategories[$id][] = [
                                'name'  => $sub,
                            ];
                        }
                    }

                    $settings['feedback_categories'] =  $feedbackCategories;
                    $settings['feedback_sub_categories'] =  $feedbackSubCategories;
                    break;

                case 'menu':

                    $uId      =  $_POST['uId'];
                    $sections = [];


                    foreach ($_POST['sectionId'] as $sectionId) {

                        $allergens = [];
                        foreach ($_POST['productId_' . $sectionId] as $productId) {
                            if (isset($_POST['allergens_' . $sectionId . '_' . $productId])) {
                                $allergens[]  = $_POST['allergens_' . $sectionId . '_' . $productId];
                            } else {
                                $allergens[] =  [''];
                            }
                        }


                        $products['names']          = $_POST['productNames_' . $sectionId];
                        $products['productIds']     = $_POST['productId_' . $sectionId];
                        $products['translated']     = $_POST['productNamesTranslated_' . $sectionId];
                        $products['description']    = $_POST['productDescriptions_' . $sectionId];
                        $products['prices']         = $_POST['productPrices_' . $sectionId];
                        $products['images']         = $_POST['productImg_' . $sectionId];
                        $products['allergens']      = $allergens;

                        $sections[$sectionId]  = [
                            'products'      =>  $products,
                            'name'          =>  $_POST['sectionNames_' . $sectionId],
                            'description'   =>  $_POST['sectionDescriptions_' . $sectionId],
                        ];
                    }

                    $_POST['sections'] =  $sections;

                    break;

                case 'links':

                    if (isset($_FILES['linkImages']) && $_FILES['linkImages'] != "") {
                        $_POST['linkImg'] = $existingData['linkImg'];
                    }
                    break;
            }


            /* Check for any errors */
            foreach ($required_fields as $field) {
                if (!isset($_POST[$field]) || (isset($_POST[$field]) && empty($_POST[$field]) && $_POST[$field] != '0')) {
                    Alerts::add_field_error($field, l('global.error_message.empty_field'));
                }
            }

            if (!Csrf::check()) {
                Alerts::add_error(l('global.error_message.invalid_csrf_token'));
            }

            if (isset($_POST['qr_code_logo']) == '' && isset($_POST['edit_QR_code_logo']) == '') {
                $qr_code->qr_code_logo =  null;
            }


            $qr_code->qr_code_logo = \Altum\Uploads::process_upload($qr_code->qr_code_logo, 'qr_codes/logo', 'qr_code_logo', 'qr_code_logo_remove', 1);


            if (!Alerts::has_field_errors() && !Alerts::has_errors()) {
                /* QR code image */

                if (isset($_POST['qr_code'])) {

                    $_POST['qr_code'] = base64_decode(mb_substr($_POST['qr_code'], mb_strlen('data:image/svg+xml;base64,')));

                    $post_data = json_decode(json_encode($_POST));

                    if ($_POST['type'] == 'wifi') {
                        $qrData = $data;
                    } else {
                        $qrData = LANDING_PAGE_URL . $_POST['uId'];
                    }


                    $_POST['trackable_qr_code'] = (new QrCode())->GenerateQrWithFrame($post_data, $qrData,  $qr_code->qr_code_logo);

                    /* Generate new name for image */
                    $image_new_name = $_POST['uId'] . '.svg';

                    /* Delete current image */
                    if (!empty($qr_code->qr_code) && file_exists(UPLOADS_PATH . 'qr_codes/logo' . '/' . $qr_code->qr_code)) {
                        unlink(UPLOADS_PATH . 'qr_codes/logo' . '/' . $qr_code->qr_code);
                    }
                    /* Upload the original */
                    file_put_contents(UPLOADS_PATH . 'qr_codes/logo' . '/' . $image_new_name, $_POST['trackable_qr_code']);

                    $qr_code->qr_code = $image_new_name;
                }

               

                if (isset($_POST['qr_code'])) {
                    unset($_POST['qr_code']);
                }
                if (isset($_POST['trackable_qr_code'])) {
                    unset($_POST['trackable_qr_code']);
                }

                if (isset($_POST['token'])) {
                    unset($_POST['token']);
                }

                $json_data = json_encode($_POST);

                $statusData = db()->where('qr_code_id', $qr_code_id)->getOne('qr_codes', ['status']);

                if ($statusData->status == '5') {
                    $msg  = sprintf(l('global.success_message.create1'), '<strong>' . e($_POST['name']) . '</strong>');
                                       
                } else {
                    $msg  = sprintf(l('global.success_message.update1'), '<strong>' . e($_POST['name']) . '</strong>');
                }

                /* Database query */
                $link_id = isset($_POST['link_id']) ? $_POST['link_id'] : null;
                $name = isset($_POST['name']) ? $_POST['name'] : null;
                $type = isset($_POST['type']) ? $_POST['type'] : null;
                db()->where('qr_code_id', $qr_code->qr_code_id)->update('qr_codes', [
                    'project_id'       => $_POST['project_id'] != "" ? $_POST['project_id'] : null,
                    'link_id'          => $link_id,
                    'name'             => $name,
                    'type'             => $type,                    
                    'status'           => '1',
                    'qr_code'          => $qr_code->qr_code,
                    'qr_code_logo'     => $qr_code->qr_code_logo,
                    'last_datetime'    => \Altum\Date::$date,
                    'data'             => $json_data
                ]);
                unset($_SESSION['qrCodeUid']);

                if($this->user->first_qr_type == null && $this->user->onboarding_funnel == 1){
                    db()->where('user_id', $this->user->user_id)->update('users', [
                        'first_qr_type'   => $type, 
                    ]);
                }

                if (Authentication::is_temp_user()) {

                    session_destroy();
                    setcookie('user_id', $this->user->user_id, time() + (3 * 3600), COOKIE_PATH);
                    setcookie('type', $this->user->type, time() +  (3 * 3600), COOKIE_PATH);
                    setcookie('user_password_hash', '', time() - (3 * 3600), COOKIE_PATH);

                    setcookie('qr_code_id', $qr_code->qr_code_id, time() +  (3 * 3600), '/');
                    setcookie('qr_uid', $qr_code->uId, time() +  (3 * 3600), '/');

                    $previous_page = $_SERVER['HTTP_REFERER'];

                    $url_components = parse_url($previous_page);
                    parse_str(isset($url_components['query']) ? $url_components['query'] : '', $params);                   
                    unset($params['step']);   
                    $query_string = http_build_query($params);

                    if($this->user->first_qr_type == null){
                        db()->where('user_id', $this->user->user_id)->update('users', [
                            'first_qr_type'   => $type, 
                        ]);
                    }

                    if (isset($params['qr_onboarding']) && $params['qr_onboarding'] == 'active_dpf') {
                        $redirect = 'register-dpf?' . $query_string;
                    }else if (isset($params['qr_onboarding']) && $params['qr_onboarding'] == 'active_nsf') {
                        $redirect = 'register_nsf?' . $query_string;
                    }else{
                        $redirect = 'register_nsf?' . $query_string;
                    }

                    redirect($redirect);
                }

                /* Set a nice success message */
                Alerts::add_success($msg);

                redirect('qr-codes');


                // redirect('qr-code-update/' . $qr_code_id);
            }
        }

        /* Prepare the View */
        $data = [
            'qr_code_settings' => $qr_code_settings,
            'qr_code'          => $qr_code,
            'projects'         => $projects,
            'links'            => $links,
        ];


        redirect('qr-codes');
    }
}
