<?php
/*
 * @copyright Copyright (c) 2021 AltumCode (https://altumcode.com/)
 *
 * This software is exclusively sold through https://altumcode.com/ by the AltumCode author.
 * Downloading this product from any other sources and running it without a proper license is illegal,
 *  except the official ones linked from https://altumcode.com/.
 */



namespace Altum\Controllers;

use SVG\SVG;
use Altum\Alerts;
use Altum\Uploads;
use Altum\Response;
use SVG\Nodes\Embedded\SVGImage;
use PHPMailer\PHPMailer\Exception;
use SimpleSoftwareIO\QrCode\Generator;
use Altum\Logger;
use Spatie\ImageOptimizer\OptimizerChainFactory;
use Imagick;

class QrCodeGenerator extends Controller
{

    public function index()
    {

 

        $landing_page_url = LANDING_PAGE_URL;

        $qr_code_post_id = isset($_POST['qrIdAjax']) ? (int) $_POST['qrIdAjax'] : null;

        $s3 = new \Aws\S3\S3Client(get_aws_s3_config());

        if ($qr_code_post_id != "" && $qr_code_post_id != null) {
            if (!$qr_code = db()->where('qr_code_id', $qr_code_post_id)->where('user_id', $_POST['userIdAjax'])->getOne('qr_codes')) {
                redirect('qr-codes');
            }
        }

        function reArrayFiles(&$file_post)
        {

            $file_ary = array();
            $file_count = count($file_post['name']);
            $file_keys = array_keys($file_post);

            for ($i = 0; $i < $file_count; $i++) {
                foreach ($file_keys as $key) {
                    $file_ary[$i][$key] = $file_post[$key][$i];
                }
            }

            return $file_ary;
        }

        if (empty($_POST)) {
            // redirect();
            echo "empty array";
            exit;
        }


        /* :) */
        $qr_code_settings = require APP_PATH . 'includes/qr_code.php';
        $_POST['type'] = isset($_POST['type']) && array_key_exists(trim($_POST['type']), $qr_code_settings['type']) ? trim($_POST['type']) : 'text';


        /* Process variables */
        $_POST['frame_type'] = isset($_POST['frame_type']) && in_array($_POST['frame_type'], ['color', 'gradient']) ? $_POST['frame_type'] : 'color';
        $_POST['frame_background_type'] = isset($_POST['background_type']) && in_array($_POST['background_type'], ['color', 'gradient']) ? $_POST['background_type'] : 'color';

        $_POST['style'] = isset($_POST['style']) && in_array($_POST['style'], ['square', 'dot', 'round', 'extra_rounded', 'diamond', 'heart']) ? $_POST['style'] : 'square';
        $_POST['cEye'] = isset($_POST['cEye']) && in_array($_POST['cEye'], ['square', 'dot', 'rounded', 'diamond', 'flower', 'leaf',]) ? $_POST['cEye'] : 'square';
        $_POST['fEye'] = isset($_POST['fEye']) && in_array($_POST['fEye'], ['square', 'circle', 'rounded', 'flower', 'leaf',]) ? $_POST['fEye'] : 'square';

        $_POST['foreground_type'] = isset($_POST['foreground_type'])  ? $_POST['foreground_type'] : 'color';
        $_POST['background_type'] = isset($_POST['background_type'])  ? $_POST['background_type'] : 'color';
        // $_POST['background_color'] = !preg_match('/#([A-Fa-f0-9]{3,4}){1,2}\b/i', $_POST['background_color']) ? '#ffffff' : $_POST['background_color'];
        $_POST['background_color_transparency'] = isset($_POST['background_color_transparency']) && in_array($_POST['background_color_transparency'], range(0, 100)) ? (int) $_POST['background_color_transparency'] : 0;
        $_POST['custom_eyes_color'] = (bool) (int) $_POST['custom_eyes_color'];
        if ($_POST['custom_eyes_color']) {

            $_POST['eyes_inner_color'] = !preg_match('/#(?:[0-9a-fA-F]{6})/', $_POST['eyes_inner_color']) ? '#000000' : $_POST['eyes_inner_color'];
            $_POST['eyes_outer_color'] = !preg_match('/#(?:[0-9a-fA-F]{6})/', $_POST['eyes_outer_color']) ? '#000000' : $_POST['eyes_outer_color'];

            // $_POST['eyes_inner_color'] = !preg_match('/#([A-Fa-f0-9]{3,4}){1,2}\b/i', $_POST['eyes_inner_color']) ? null : $_POST['eyes_inner_color'];
            // $_POST['eyes_outer_color'] = !preg_match('/#([A-Fa-f0-9]{3,4}){1,2}\b/i', $_POST['eyes_outer_color']) ? null : $_POST['eyes_outer_color'];
        }
        $qr_code_logo = !empty($_FILES['qr_code_logo']['name']) && !isset($_POST['qr_code_logo_remove']);
        $_POST['qr_code_logo'] = $_POST['qr_code_logo'] ?? null;
        $_POST['qr_code_logo_size'] = isset($_POST['qr_code_logo_size']) && in_array($_POST['qr_code_logo_size'], range(5, 35)) ? (int) $_POST['qr_code_logo_size'] : 25;
        $_POST['size'] = isset($_POST['size']) && in_array($_POST['size'], range(50, 2000)) ? (int) $_POST['size'] : 250;
        $_POST['margin'] = isset($_POST['margin']) && in_array($_POST['margin'], range(0, 25)) ? (int) $_POST['margin'] : 1;
        $_POST['ecc'] = isset($_POST['ecc']) && in_array($_POST['ecc'], ['L', 'M', 'Q', 'H']) ? $_POST['ecc'] : 'M';
        $uId =  $_POST['uId'];

        // if ($uId) {
        //     $qrCode = db()->where('uId', $uId)->getOne('qr_codes');
        // }

        if (isset($_FILES['screen'])) {
            // For Compression ....
            $filescreen = $_FILES['screen']['name'];
            if ($filescreen) {

                $imageQuality = 20;
                $tempPath = $_FILES["screen"]["tmp_name"];
                $screenFileExtension = pathinfo($_FILES["screen"]["name"], PATHINFO_EXTENSION);
                $uploadUniqueId = $_POST["uploadUniqueId"];
                $basename = basename($filescreen);
                $originalPath =  UPLOADS_PATH . 'screen/' . $uId . '_welcome_' . $uploadUniqueId . '.' . $screenFileExtension;
                $key  = 'uploads/screen/' . $uId . '_welcome_' . $uploadUniqueId . '.' . $screenFileExtension;
                $this->compress_image($tempPath, $originalPath, $imageQuality, $key);
                $_POST['screen'] =  UPLOADS_FULL_URL . 'screen/' . $uId . '_welcome_' . $uploadUniqueId . '.' . $screenFileExtension;
            }
        }


        if (isset($_FILES['companyLogo']) && $_FILES['companyLogo']['name']) {
            // For Compression ....

            $file = $_FILES['companyLogo']['name'];

            $imageQuality = 40;
            $tempPath = $_FILES['companyLogo']["tmp_name"];
            $screenFileExtension = pathinfo($_FILES["companyLogo"]["name"], PATHINFO_EXTENSION);
            $uploadUniqueId = isset($_POST['companyId']) ? $_POST['companyId'] : null;
            $basename = basename($file);
            $originalPath =  UPLOADS_PATH . trim($_POST['type']) . '/' . $uId . '_companyLogo_' . $uploadUniqueId . '.' . $screenFileExtension;
            $key =  'uploads/' . trim($_POST['type']) . '/' . $uId . '_companyLogo_' . $uploadUniqueId . '.' . $screenFileExtension;
            $this->compress_image($tempPath, $originalPath, $imageQuality, $key);

            $companyLogo =  UPLOADS_FULL_URL . trim($_POST['type']) . '/' . $uId . '_companyLogo_' . $uploadUniqueId . '.' . $screenFileExtension;
            $_POST['companyLogo'] = $companyLogo;
        }


        switch (trim($_POST['type'])) {

            case 'text':
                $data = $_POST['text'];
                break;

            case 'url':

                $_POST['url'] = LANDING_PAGE_URL . "p/{$uId}";

                $data = $_POST['url'];
                break;

            case 'pdf':
                $uId =  $_POST['uId'];

                if (isset($_FILES['pdf'])) {
                    $file_tmp = $_FILES['pdf']['tmp_name'];

                    if (OFFLOAD_PROVIDER == 'local') {

                        /* Local uploading */
                        move_uploaded_file($file_tmp, UPLOADS_PATH . 'pdf' . '/' . $uId . '.pdf');
                        $_POST['pdf'] = UPLOADS_PATH . 'pdf' . '/' . $uId . '.pdf';
                    } else {
                        try {
                            /* Upload pdf */
                            $s3->putObject([
                                'Bucket' => OFFLOAD_BUCKET,
                                'Key' => 'uploads/pdf/' . $uId . '.pdf',
                                'ContentType' => 'application/pdf',
                                'Body' => file_get_contents($file_tmp),
                                'ACL' => 'public-read',
                            ]);
                        } catch (\Exception $exception) {
                            Alerts::add_error($exception->getMessage());
                        }
                    }


                    $_POST['url'] = LANDING_PAGE_URL . "p/{$uId}";
                } else if ($qr_code_post_id != "" && $qr_code_post_id != null) {
                    $_POST['url'] = $landing_page_url . "p/{$qr_code->uId}";
                }

                $data = $_POST['url'] ?? LANDING_PAGE_URL . "p/{$uId}";

                if (isset($_POST['direct_pdf'])) {
                    $_POST['url'] = UPLOADS_FULL_URL . 'pdf/' . $uId . '_' . isset($filescreen);
                }

                break;

            case 'images':

                $uId =  $_POST['uId'];
                $_POST['url'] = LANDING_PAGE_URL . "p/{$uId}";
                $data = $_POST['url'];

                $all_images = array();

                if (isset($_FILES['images'])) {
                  
                    $unique =  $_POST['imageID'];
                    $filename = $_FILES['images']['name'];
                    $fileExtension = pathinfo($filename, PATHINFO_EXTENSION);

                    // For Compression ...................................................................
                    $imageQuality = 40;
                    $tempPath = $_FILES["images"]["tmp_name"];
                    $basename = basename($filename);
                    $originalPath = UPLOADS_PATH . 'images/' . $uId . '_' . $unique . '.' . $fileExtension;
                    $key = 'uploads/images/' . $uId . '_' . $unique . '.' . $fileExtension;
                    $this->compress_image($tempPath, $originalPath, $imageQuality, $key);
                    array_push($all_images, UPLOADS_FULL_URL . 'images/' . $uId . '_' . $unique . '.' . $fileExtension);
                }

                $_POST['images'] = $all_images;

                break;

            case 'mp3':

                $uId =  $_POST['uId'];
                $_POST['url'] = LANDING_PAGE_URL . "p/{$uId}";
                $data = $_POST['url'];
                $filemp3 = isset($_FILES['mp3']['name'])  ? $_FILES['mp3']['name'] : null;
                $fileExtension = pathinfo($filemp3, PATHINFO_EXTENSION);
                $mp3UniqueId = $_POST['uploadUniqueId'];

                if (isset($filemp3)) {
                    $mime = mime_content_type($_FILES['mp3']['tmp_name']);

                    if (OFFLOAD_PROVIDER == 'local') {
                        /* Local uploading */
                        move_uploaded_file($_FILES['mp3']['tmp_name'], UPLOADS_PATH . 'mp3/' . $uId . '_' . $mp3UniqueId . '.' . $fileExtension);
                        $mp3 =  SITE_URL . 'uploads/mp3/' . $uId . '_' . $mp3UniqueId . '.' . $fileExtension;
                    } else {
                        try {
                            /* Upload mp3 */
                            $s3->putObject([
                                'Bucket' => OFFLOAD_BUCKET,
                                'Key' =>  'uploads/mp3/' . $uId . '_' . $mp3UniqueId . '.' . $fileExtension,
                                'ContentType' => 'audio/mp3',
                                'Body' => file_get_contents($_FILES['mp3']['tmp_name']),
                                'ACL' => 'public-read',
                            ]);
                        } catch (\Exception $exception) {
                            Alerts::add_error($exception->getMessage());
                        }
                    }
                }

                break;
            case 'app':

                $uId =  $_POST['uId'];
                $_POST['url'] = LANDING_PAGE_URL . "p/{$uId}";
                $data = $_POST['url'];

                $all_images = array();

                // For Compression ....
                if (isset($_FILES['images'])) {
                    $countfiles = count($_FILES['images']['name']);

                    for ($i = 0; $i < $countfiles; $i++) {
                        $filename = $_FILES['images']['name'][$i];
                        $tempPath = $_FILES['images']['tmp_name'][$i];
                        $originalPath = UPLOADS_PATH . 'app/' . $uId . '_' . $i . '_' . $filename;
                        $key = 'uploads/app/' . $uId . '_' . $i . '_' . $filename;
                        $mime = mime_content_type($_FILES['images']['tmp_name'][$i]);
                        $this->compress_image($tempPath, $originalPath, $imageQuality, $key);
                        array_push($all_images, UPLOADS_FULL_URL . 'app/' . $uId . '_' . $i . '_' . $filename);
                    }
                }
                $_POST['images'] = $all_images;

                break;


            case 'video':

                $uId =  $_POST['uId'];
                $_POST['url'] = LANDING_PAGE_URL . "p/{$uId}";
                $data = $_POST['url'];

                $all_videos = array();

                if (isset($_FILES['video_file']) && isset($_FILES['video_file']['name'])) {
                    $filename = $_FILES['video_file']['name'];
                    $fileExtension = pathinfo($filename, PATHINFO_EXTENSION);
                    $videoUnqId = $_POST['videoUnqId'];
                    // Upload file
                    $mime = mime_content_type($_FILES['video_file']['tmp_name']);

                    // For Compression ....
                    if (OFFLOAD_PROVIDER == 'local') {

                        /* Local uploading */
                        move_uploaded_file($_FILES['video_file']['tmp_name'], UPLOADS_PATH . 'video/' . $uId . '_' . $videoUnqId . '.' . $fileExtension);
                    } else {
                        try {
                            $fileStream = fopen($_FILES['video_file']['tmp_name'], 'rb');

                            /* Upload mp3 */
                            $s3->putObject([
                                'Bucket' => OFFLOAD_BUCKET,
                                'Key' =>  'uploads/video/' . $uId . '_' . $videoUnqId . '.' . $fileExtension,
                                'ContentType' =>  $mime,
                                'Body' => $fileStream,
                                'ACL' => 'public-read',
                            ]);

                            fclose($fileStream);

                        } catch (\Exception $exception) {
                            Alerts::add_error($exception->getMessage());
                        }
                    }

                    array_push($all_videos,  UPLOADS_FULL_URL . 'video/' . $uId . '_' . $videoUnqId . '.' . $fileExtension);
                }
                $_POST['video_file'] = $all_videos;

                break;

            case 'menu':
                $uId =  $_POST['uId'];
                $_POST['url'] = LANDING_PAGE_URL . "p/{$uId}";
                $data = $_POST['url'];
                $all_productImages = array();
                $productImagesUnqId = $_POST['uploadUniqueId'];

                if (isset($_FILES['productImagess'])) {
                    $filescreen = $_FILES['productImagess']['name'];
                    $fileExtension = pathinfo($filescreen, PATHINFO_EXTENSION);
                    if ($filescreen) {
                        $imageQuality = 20;
                        $tempPath = $_FILES["productImagess"]["tmp_name"];
                        $basename = basename($filescreen);
                        $originalPath = UPLOADS_PATH . 'menu/' . $uId . '_' . $_POST['newSectionIds'] . '_productImages_' . $productImagesUnqId . '.' . $fileExtension;
                        $key = 'uploads/menu/' . $uId . '_' . $_POST['newSectionIds'] . '_productImages_' . $productImagesUnqId . '.' . $fileExtension;
                        $this->compress_image($tempPath, $originalPath, $imageQuality, $key);
                        array_push($all_productImages,  UPLOADS_FULL_URL . 'menu/' . $uId . '_' . $_POST['newSectionIds'] . '_productImages_' . $productImagesUnqId . '.' . $fileExtension);
                    }
                }
                break;
            case 'links':
                $uId =  $_POST['uId'];
                $_POST['url'] = LANDING_PAGE_URL . "p/{$uId}";
                $data = $_POST['url'];

                $all_productImages = array();
                if (isset($_FILES['linkImagess'])) {
                    $filescreen       = $_FILES['linkImagess']['name'];
                    $fileExtension    = pathinfo($filescreen, PATHINFO_EXTENSION);
                    $linksImagesUnqId = isset($_POST['linkId']) ? $_POST['linkId'] : null;
                    if ($filescreen) {

                        // For Compression ....
                        $imageQuality = 20;
                        $tempPath = $_FILES["linkImagess"]["tmp_name"];
                        $basename = basename($filescreen);
                        $originalPath = UPLOADS_PATH . 'links/' . $uId . '_linkImages_' . $linksImagesUnqId . '.' . $fileExtension;
                        $key = 'uploads/links/' . $uId . '_linkImages_' . $linksImagesUnqId . '.' . $fileExtension;
                        $this->compress_image($tempPath, $originalPath, $imageQuality, $key);
                        array_push($all_productImages,  UPLOADS_FULL_URL . 'links/' . $uId . '_linkImages_' . $linksImagesUnqId . '.' . $fileExtension);
                    }
                }

                $_POST['linkImages'] = $all_productImages;
                break;


            case 'business':
                $uId =  $_POST['uId'];
                $_POST['url'] = LANDING_PAGE_URL . "p/{$uId}";
                $data = $_POST['url'];
                break;
            case 'coupon':
                $uId =  $_POST['uId'];
                $_POST['url'] = LANDING_PAGE_URL . "p/{$uId}";
                $data = $_POST['url'];
                $offerImageUnqId = $_POST['uploadUniqueId'];

                if (isset($_FILES['offerImage']) && !empty($_FILES['offerImage']['name'])) {
                    $filescreen = $_FILES['offerImage']['name'];
                    $fileExtension = pathinfo($filescreen, PATHINFO_EXTENSION);
                    $imageQuality = 20;
                    $tempPath = $_FILES["offerImage"]["tmp_name"];
                    $basename = basename($filescreen);
                    $originalPath = UPLOADS_PATH . 'coupon/' . $uId . '_offerImage_' . $offerImageUnqId . '.' . $fileExtension;
                    $key = 'uploads/coupon/' . $uId . '_offerImage_' . $offerImageUnqId . '.' . $fileExtension;
                    $this->compress_image($tempPath, $originalPath, $imageQuality, $key);
                }

                break;


            case 'feedback':
                $uId =  $_POST['uId'];
                $_POST['url'] = LANDING_PAGE_URL . "p/{$uId}";
                $data = $_POST['url'];
                $_POST['name'] = input_clean($_POST['name']);
                break;

            case 'phone':
                $data = 'tel:' . $_POST['phone'];
                break;

            case 'sms':
                $data = 'SMSTO:' . $_POST['sms'] . ':' . $_POST['sms_body'];
                break;

            case 'email':
                $_POST['email'] = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
                $data = 'MATMSG:TO:' . $_POST['email'] . ';SUB:' . $_POST['email_subject'] . ';BODY:' . $_POST['email_body'] . ';;';
                break;

            case 'whatsapp':
                $data = 'https://api.whatsapp.com/send?phone=' . $_POST['whatsapp'] . '&text=' . urlencode($_POST['whatsapp_body']);
                break;

            case 'facetime':
                $_POST['facetime'] = input_clean($_POST['facetime']);
                $data = 'facetime:' . $_POST['facetime'];
                break;

            case 'location':
                $_POST['location_latitude'] = (float) $_POST['location_latitude'];
                $_POST['location_longitude'] = (float) $_POST['location_longitude'];
                $data = 'geo:' . $_POST['location_latitude'] . ',' . $_POST['location_longitude'] . '?q=' . $_POST['location_latitude'] . ',' . $_POST['location_longitude'];
                break;

            case 'wifi':
                $_POST['wifi_encryption'] = isset($_POST['wifi_encryption']) && in_array($_POST['wifi_encryption'], ['nopass', 'WEP', 'WPA/WPA2']) ? $_POST['wifi_encryption'] : 'nopass';
                if ($_POST['wifi_encryption'] == 'WPA/WPA2') $_POST['wifi_encryption'] = 'WPA';
                $_POST['wifi_is_hidden'] = (int) isset($_POST['wifi_is_hidden']);

                $data_to_be_rendered = 'WIFI:S:' . $_POST['wifi_ssid'] . ';';
                $data_to_be_rendered .= 'T:' . $_POST['wifi_encryption'] . ';';
                if ($_POST['wifi_password']) $data_to_be_rendered .= 'P:' . $_POST['wifi_password'] . ';';
                if ($_POST['wifi_is_hidden']) $data_to_be_rendered .= 'H:' . (bool) $_POST['wifi_is_hidden'] . ';';
                $data_to_be_rendered .= ';';

                $data = $data_to_be_rendered;
                break;

            case 'event':

                $_POST['event_url'] = filter_var($_POST['event_url'], FILTER_SANITIZE_URL);
                $_POST['event_start_datetime'] = (new \DateTime($_POST['event_start_datetime']))->format('Ymd\THis\Z');
                $_POST['event_end_datetime'] = empty($_POST['event_end_datetime']) ? null : (new \DateTime($_POST['event_end_datetime']))->format('Ymd\THis\Z');

                $data_to_be_rendered = 'BEGIN:VEVENT' . "\n";
                $data_to_be_rendered .= 'SUMMARY:' . $_POST['event'] . "\n";
                $data_to_be_rendered .= 'LOCATION:' . $_POST['event_location'] . "\n";
                $data_to_be_rendered .= 'URL:' . $_POST['event_url'] . "\n";
                $data_to_be_rendered .= 'DESCRIPTION:' . $_POST['event_note'] . "\n";
                $data_to_be_rendered .= 'DTSTART;TZID=' . $_POST['event_timezone'] . ':' . $_POST['event_start_datetime'] . "\n";
                if ($_POST['event_end_datetime']) $data_to_be_rendered .= 'DTEND;TZID=' . $_POST['event_timezone'] . ':' . $_POST['event_end_datetime'] . "\n";
                $data_to_be_rendered .= 'END:VEVENT';

                $data = $data_to_be_rendered;
                break;

            case 'crypto':
                $_POST['crypto_coin'] = isset($_POST['crypto_coin']) && array_key_exists($_POST['crypto_coin'], $qr_code_settings['type']['crypto']['coins']) ? $_POST['crypto_coin'] : array_key_first($qr_code_settings['type']['crypto']['coins']);;
                $_POST['crypto_amount'] = isset($_POST['crypto_amount']) ? (float) $_POST['crypto_amount'] : null;
                $data = $_POST['crypto_coin'] . ':' . $_POST['crypto_address'] . ($_POST['crypto_amount'] ? '?amount=' . $_POST['crypto_amount'] : null);
                break;

            case 'vcard':

                $_POST['vcard_email'] = filter_var(isset($_POST['vcard_email']), FILTER_SANITIZE_EMAIL);
                $_POST['vcard_url'] = filter_var(isset($_POST['vcard_url']), FILTER_SANITIZE_URL);

                if (!isset($_POST['vcard_social_label'])) {
                    $_POST['vcard_social_label'] = [];
                    $_POST['vcard_social_value'] = [];
                }

                $vcard = new \JeroenDesloovere\VCard\VCard();
                $vcard->addName($_POST['vcard_last_name'], $_POST['vcard_first_name']);
                $vcard->addAddress(null, null, isset($_POST['vcard_street']), isset($_POST['vcard_city']), isset($_POST['vcard_region']), isset($_POST['vcard_zip']), isset($_POST['vcard_country']));
                if (isset($_POST['vcard_phone'])) $vcard->addPhoneNumber(isset($_POST['vcard_phone']));
                if (isset($_POST['vcard_email'])) $vcard->addEmail(isset($_POST['vcard_email']));
                if (isset($_POST['vcard_url'])) $vcard->addURL(isset($_POST['vcard_url']));
                if (isset($_POST['vcard_company'])) $vcard->addCompany(isset($_POST['vcard_company']));
                if (isset($_POST['vcard_job_title'])) $vcard->addJobtitle(isset($_POST['vcard_job_title']));
                if (isset($_POST['vcard_birthday'])) $vcard->addBirthday(isset($_POST['vcard_birthday']));
                if (isset($_POST['vcard_note'])) $vcard->addNote(isset($_POST['vcard_note']));


                foreach ($_POST['vcard_social_label'] as $key => $value) {
                    if (empty(trim($value))) continue;
                    if ($key >= 20) continue;

                    $label = mb_substr($value, 0, $qr_code_settings['type']['vcard']['social_value']['max_length']);
                    $value = mb_substr($_POST['vcard_social_value'][$key], 0, $qr_code_settings['type']['vcard']['social_value']['max_length']);

                    $vcard->addURL(
                        $value,
                        'TYPE=' . $label
                    );
                }

                $data = $vcard->buildVCard();
                //$_POST['url'] = $_POST['preview_link'];
                $_POST['url'] = LANDING_PAGE_URL . "p/{$uId}";
                $data = $_POST['url'];
                break;

            case 'paypal':
                $_POST['paypal_type'] = isset($_POST['paypal_type']) && array_key_exists($_POST['paypal_type'], $qr_code_settings['type']['paypal']['type']) ? $_POST['paypal_type'] : array_key_first($qr_code_settings['type']['paypal']['type']);;
                $_POST['paypal_email'] = filter_var($_POST['paypal_email'], FILTER_SANITIZE_EMAIL);
                //$_POST['paypal_title'] = input_clean($_POST['paypal_title']);
                //$_POST['paypal_currency'] = input_clean($_POST['paypal_currency']);
                $_POST['paypal_price'] = (float) $_POST['paypal_price'];
                $_POST['paypal_thank_you_url'] = filter_var($_POST['paypal_thank_you_url'], FILTER_SANITIZE_URL);
                $_POST['paypal_cancel_url'] = filter_var($_POST['paypal_cancel_url'], FILTER_SANITIZE_URL);

                if ($_POST['paypal_type'] == 'add_to_cart') {
                    $data = sprintf('https://www.paypal.com/cgi-bin/webscr?business=%s&cmd=%s&currency_code=%s&amount=%s&item_name=%s&button_subtype=products&add=1&return=%s&cancel_return=%s', $_POST['paypal_email'], $qr_code_settings['type']['paypal']['type'][$_POST['paypal_type']], $_POST['paypal_currency'], $_POST['paypal_price'], $_POST['paypal_title'], $_POST['paypal_thank_you_url'], $_POST['paypal_cancel_url']);
                } else {
                    $data = sprintf('https://www.paypal.com/cgi-bin/webscr?business=%s&cmd=%s&currency_code=%s&amount=%s&item_name=%s&return=%s&cancel_return=%s', $_POST['paypal_email'], $qr_code_settings['type']['paypal']['type'][$_POST['paypal_type']], $_POST['paypal_currency'], $_POST['paypal_price'], $_POST['paypal_title'], $_POST['paypal_thank_you_url'], $_POST['paypal_cancel_url']);
                }

                break;
        }
        
       
        $qr = new Generator;
        $qr->size($_POST['size']);
        $qr->errorCorrection($_POST['ecc']);
        $qr->encoding('UTF-8');
        $qr->margin($_POST['margin']);

        $qr->style($_POST['style'], 0.9);

        /* Style */

        /* Eyes */
        if ($_POST['custom_eyes_color']) {
            $eyes_inner_color = hex_to_rgb($_POST['eyes_inner_color']);
            $eyes_outer_color = hex_to_rgb($_POST['eyes_outer_color']);

            $qr->eyeColor(0, $eyes_inner_color['r'], $eyes_inner_color['g'], $eyes_inner_color['b'], $eyes_outer_color['r'], $eyes_outer_color['g'], $eyes_outer_color['b']);
            $qr->eyeColor(1, $eyes_inner_color['r'], $eyes_inner_color['g'], $eyes_inner_color['b'], $eyes_outer_color['r'], $eyes_outer_color['g'], $eyes_outer_color['b']);
            $qr->eyeColor(2, $eyes_inner_color['r'], $eyes_inner_color['g'], $eyes_inner_color['b'], $eyes_outer_color['r'], $eyes_outer_color['g'], $eyes_outer_color['b']);
        }

        $qr->eye(\BaconQrCode\Renderer\Module\EyeCombiner::instance($_POST['cEye'], $_POST['fEye']));


        switch ($_POST['foreground_type']) {

            case 'color':

               
                $_POST['foreground_color'] = !preg_match('/#(?:[0-9a-fA-F]{6})/', $_POST['foreground_color']) ? '#000000' : $_POST['foreground_color'];
                // $_POST['foreground_color'] = !preg_match('/#([A-Fa-f0-9]{3,4}){1,2}\b/i', $_POST['foreground_color'] ?? null) ? '#000000' : $_POST['foreground_color'];
                $foreground_color = hex_to_rgb($_POST['foreground_color']);
                $qr->color($foreground_color['r'], $foreground_color['g'], $foreground_color['b']);
                break;

            case 'gradient':
                $_POST['foreground_gradient_style'] = isset($_POST['foreground_gradient_style']) && in_array($_POST['foreground_gradient_style'], ['vertical', 'horizontal', 'diagonal', 'inverse_diagonal', 'radial']) ? $_POST['foreground_gradient_style'] : 'radial';
                
                $_POST['foreground_gradient_one'] = !preg_match('/#(?:[0-9a-fA-F]{6})/', $_POST['foreground_gradient_one']) ? '#000000' : $_POST['foreground_gradient_one'];
                $_POST['foreground_gradient_two'] = !preg_match('/#(?:[0-9a-fA-F]{6})/', $_POST['foreground_gradient_two']) ? '#000000' : $_POST['foreground_gradient_two'];

                $foreground_gradient_one = hex_to_rgb($_POST['foreground_gradient_one']);
                $foreground_gradient_two = hex_to_rgb($_POST['foreground_gradient_two']);
                $qr->gradient($foreground_gradient_one['r'], $foreground_gradient_one['g'], $foreground_gradient_one['b'], $foreground_gradient_two['r'], $foreground_gradient_two['g'], $foreground_gradient_two['b'], $_POST['foreground_gradient_style']);
                break;
        }

        // Background 
        switch ($_POST['background_type']) {
            
            case 'color':               
                $_POST['background_color'] = !preg_match('/#(?:[0-9a-fA-F]{6})/', $_POST['background_color']) ? '#ffffff' : $_POST['background_color'];
                // $_POST['background_color'] = !preg_match('/#([A-Fa-f0-9]{3,4}){1,2}\b/i', $_POST['background_color']) ? '#ffffff' : $_POST['background_color'];
                $background_color = hex_to_rgb($_POST['background_color']);
                
                if($_POST['background_color_transparency']){
                    $background_color = hex_to_rgb('#ffffff');
                }else{
                    $qr->backgroundColor($background_color['r'], $background_color['g'], $background_color['b'], 100 - $_POST['background_color_transparency']);
                    
                }
                
                                
                break;

            case 'gradient':
                $background_color = hex_to_rgb('#ffffff');
                $qr->backgroundColor($background_color['r'], $background_color['g'], $background_color['b'], 0);

                break;
        }
        /* Generate the first SVG */
        try {
            $svg = $qr->generate($data);
            // Response::json($svg, $uId . '.pdf', 'error');
        } catch (\Exception $exception) {
            Response::json($exception->getMessage(), 'error');
        }

      

        if ((isset($_POST['qr_code_logo']) || $qr_code_logo || isset($_POST['edit_QR_code_logo'])) && !isset($_POST['qr_code_logo_remove'])) {

            $logo_width_percentage = 26;

            /* Start doing custom changes to the output SVG */
            $custom_svg_object = SVG::fromString($svg);
            $custom_svg_doc = $custom_svg_object->getDocument();

            /* Already existing QR code logo */
            if ($_POST['qr_code_logo']) {
                $qr_code_logo_name = $_POST['qr_code_logo'];
                $qr_code_logo_link = $_POST['qr_code_logo'];
            }

            //  XL Code
            if (isset($_POST['edit_QR_code_logo'])) {
                $qr_code_logo_name = $_POST['edit_QR_code_logo'];
                $qr_code_logo_link = "uploads/qr_codes/logo/" . $_POST['edit_QR_code_logo'];
            }
            // XL Code

            /* Freshly uploaded QR code logo */
            if ($qr_code_logo) {

                // var_dump(1 * 1048576);

                $qr_code_logo_name = $_FILES['qr_code_logo']['name'];

                $file_extension = explode('.', $qr_code_logo_name);
                $file_extension = mb_strtolower(end($file_extension));
                $qr_code_logo_link = $_FILES['qr_code_logo']['tmp_name'];

                if ($_FILES['qr_code_logo']['error'] == UPLOAD_ERR_INI_SIZE) {
                    // Alerts::add_error(sprintf(l('global.error_message.file_size_limit'), $qr_code_settings['qr_code_logo_size_limit']));
                }

                if ($_FILES['qr_code_logo']['error'] && $_FILES['qr_code_logo']['error'] != UPLOAD_ERR_INI_SIZE) {
                    Alerts::add_error(l('global.error_message.file_upload'));
                }

                if (!in_array($file_extension, Uploads::get_whitelisted_file_extensions('qr_codes/logo'))) {
                    Alerts::add_error(l('global.error_message.invalid_file_type'));
                }

                if (!\Altum\Plugin::is_active('offload') || (\Altum\Plugin::is_active('offload') && !settings()->offload->uploads_url)) {
                    if (!is_writable(UPLOADS_PATH . 'qr_codes/logo' . '/')) {
                        Response::json(sprintf(l('global.error_message.directory_not_writable'), UPLOADS_PATH . 'qr_codes/logo' . '/'), 'error');
                    }
                }

                if ($_FILES['qr_code_logo']['size'] > 1 * 1048576) {
                    Response::json(sprintf(l('global.error_message.file_size_limit'), $qr_code_settings['qr_code_logo_size_limit']), 'error');
                }
            }

            $qr_code_logo_extension = explode('.', $qr_code_logo_name);
            $qr_code_logo_extension = mb_strtolower(end($qr_code_logo_extension));

            if ($qr_code_logo_extension == 'png' && $_POST['background_type'] == 'color') {

                $src = imagecreatefromstring(file_get_contents($qr_code_logo_link));
                $src_w = imagesx($src);
                $src_h = imagesy($src);
                $dest_w = $src_w;
                $dest_h = $src_h;
                $dest = imagecreatetruecolor($dest_w, $dest_h);

                if($_POST['background_color_transparency'] == 100){
                    if ($_POST['qr_frame_id']) {
                        if (array_search($_POST['qr_frame_id'], [9, 24, 27]) !== false) {
                            if (isset($_POST['frame_color_type']) && $_POST['frame_color_type'] === 'gradient') {
                                $this->changeLogoBgColor($dest,null);
                            } else {
                                $this->changeLogoBgColor($dest,$_POST['frame_color']);
                            }
                        } else {
                            if (isset($_POST['frame_background_color_transparency'])) {
                                $this->changeLogoBgColor($dest,"#FFFFFF");
                            } elseif(isset($_POST['frame_background_color_type']) && $_POST['frame_background_color_type'] === 'gradient'){
                                $this->changeLogoBgColor($dest,null);
                            } else {
                                $this->changeLogoBgColor($dest,$_POST['frame_background_color']);
                            }
                        }
                    } else {
                        $this->changeLogoBgColor($dest,"#FFFFFF");
                    }
                }else{
                    $this->changeLogoBgColor($dest,$_POST['background_color']);
                }

                imagecopy($dest, $src, 0, 0, 0, 0, $src_w, $src_h);
                $stream = fopen('php://memory', 'r+');
                imagepng($dest, $stream);
                rewind($stream);
                $logo = stream_get_contents($stream);
            } else {
                $logo = file_get_contents($qr_code_logo_link);
            }

            $logo_base64 = 'data:image/' . $qr_code_logo_extension . ';base64,' . base64_encode($logo);

            /* Size of the logo */
            list($logo_width, $logo_height) = getimagesize($qr_code_logo_link);

            if ($logo_height > 0 &&  $logo_width > 0) {
                $logo_ratio = $logo_height / $logo_width;
            } else {
                $logo_ratio = 1;
            }


            if ($logo_ratio > 1.5) {
                $logo_new_width = $_POST['size'] * 18 / 100;
            } else {
                $logo_new_width = $_POST['size'] * $logo_width_percentage / 100;
            }
            $logo_new_height = $logo_new_width * $logo_ratio;

            /* Calculate center of the QR code */
            $logo_x = $_POST['size'] / 2 - $logo_new_width / 2;
            $logo_y = $_POST['size'] / 2 - $logo_new_height / 2;

            /* Add the logo to the QR code */
            $logo = new SVGImage($logo_base64, $logo_x, $logo_y, $logo_new_width, $logo_new_height);
            $custom_svg_doc->addChild($logo);

            if ($qr_code_logo_link == "uploads/qr_codes/logo/") {
                $custom_svg_doc->removeChild($logo);

                db()->where('qr_code_id', $qr_code->qr_code_id)->update('qr_codes', [
                    'qr_code_logo' => null,
                ]);
            }

            /* Export the QR code with the logo on top */
            $svg = $custom_svg_object->toXMLString();
        }

        if ($_POST['background_type'] == 'gradient') {


            $backgound_gradient_style = isset($_POST['backgound_gradient_style']) && in_array($_POST['backgound_gradient_style'], ['linear', 'radial']) ? $_POST['backgound_gradient_style'] : 'linear';
            $one = $_POST['background_gradient_one'];
            $two = $_POST['background_gradient_two'];


            if ($backgound_gradient_style == 'linear') {

                $gradiant_object = '<svg width="250" height="250" version="1.1" viewBox="0 0 250 250" xmlns="http://www.w3.org/2000/svg">            
                <defs>
                    <linearGradient id="backGradient">
                    <stop class="stop1" offset="20%"/>
                    <stop class="stop2" offset="100%"/>               
                    </linearGradient>
                
                    <style type="text/css"><![CDATA[
                    #rect1 { fill: url(#backGradient); }
                    .stop1 { stop-color: ' . $one . '; }
                    .stop2 { stop-color: ' . $two . ';  }                
                    ]]></style>
                </defs>        
                <rect id="rect1" x="0" y="0" width="250" height="250"/>     
          
          </svg>';
            } else {
                $gradiant_object = '<svg width="250" height="250" version="1.1" viewBox="0 0 250 250" xmlns="http://www.w3.org/2000/svg">            
                <defs>
                    <radialGradient id="backGradient">
                    <stop  class="stop1" offset="0%"  />
                    <stop   class="stop2" offset="100%" />
                    </radialGradient>     
                    
                    <style type="text/css"><![CDATA[
                        #rect1 { fill: url(#backGradient); }
                        .stop1 { stop-color: ' . $one . '; }
                        .stop2 { stop-color: ' . $two . ';  }                
                        ]]></style>

              </defs>     
              <rect
              x="0"
              y="0"
              width="250"
              height="250"
              fill="url(#backGradient)" />
          
          </svg>';
            }

            $custom_svg_object = SVG::fromString($gradiant_object);
            $custom_svg_doc = $custom_svg_object->getDocument();

            $gradiant_object = new SVGImage('data:image/svg+xml;base64,' . base64_encode($svg), 0, 0, 250, 250);
            $custom_svg_doc->addChild($gradiant_object);
            $svg = $custom_svg_object->toXMLString();
        }


        //QR code dynamic frame code
        $qr_frame_parameter_array = [
            '1' => [35, 30, 250, 250],
            '2' => [35, 30, 250, 250],
            '3' => [35, 30, 250, 250],
            '4' => [35, 30, 250, 250],//
            '5' => [35, 30, 250, 250],
            '6' => [35, 30, 250, 250],
            '7' => [35, 30, 250, 250],
            '8' => [60, 65, 200, 200],
            '9' => [60, 75, 200, 200],
            '10' => [50, 45, 200, 200],
            '11' => [50, 140, 200, 200],
            '12' => [75, 80, 200, 200],
            '13' => [35, 30, 250, 250],
            '14' => [35, 30, 250, 250],
            '15' => [42, 145, 350, 350],
            '16' => [65, 30, 250, 250],
            '17' => [105, 110, 200, 200],
            '18' => [70, 125, 200, 200],
            '19' => [75, 145, 200, 200],
            '20' => [150, 75, 200, 200],
            '21' => [110, 60, 200, 200],
            '22' => [45, 55, 200, 200],
            '23' => [120, 110, 200, 200],
            '24' => [185, 130, 200, 200],
            '25' => [60, 95, 200, 200],
            '26' => [95, 120, 200, 200],
            '27' => [95, 195, 200, 200],
            '28' => [115, 155, 200, 250],
            '29' => [50, 250, 200, 200],
            '30' => [95, 160, 200, 200],
            '31' => [115, 175, 200, 200],

        ];
        if ($_POST['qr_frame_id']) {
            $qr_frame_id = isset($_POST['qr_frame_id']) ? $_POST['qr_frame_id'] : 1;
            $qr_frame_path = isset($_POST['qr_frame_path']) ? file_get_contents($_POST['qr_frame_path']) :  file_get_contents(ASSETS_FULL_URL . 'images/qrframe/Asset1.svg');;
            $frame1 = $qr_frame_path;

            $frame_svg_object = SVG::fromString($frame1);
            $frame_svg_doc = $frame_svg_object->getDocument();
            $frame_data = new SVGImage('data:image/svg+xml;base64,' . base64_encode($svg), $qr_frame_parameter_array[$qr_frame_id][0], $qr_frame_parameter_array[$qr_frame_id][1], $qr_frame_parameter_array[$qr_frame_id][2], $qr_frame_parameter_array[$qr_frame_id][3]);
            $frame_svg_doc->addChild($frame_data);
            $svg = $frame_svg_object->toXMLString();

            $svg = $this->changeFrameText($svg, $_POST['frame_text']);

            $svg = $this->changeTextColor($svg, $_POST['qr_text_color']);

            $svg = $this->qrFrameFontSize($svg, $_POST['qr_frame_font_size']);

            $svg = $this->frameTextYPosition($svg, $_POST['frame_text_y_position']);


            if (isset($_POST['frame_color_type']) == 'gradient') {

                $_POST['frame_gradient_one'] = !preg_match('/#(?:[0-9a-fA-F]{6})/', $_POST['frame_gradient_one']) ? '#000000' : $_POST['frame_gradient_one'];
                $svg = $this->changeFrameGradientColor($svg, $_POST['frame_gradient_one'], $_POST['frame_gradient_two'], $_POST['frame_gradient_style']);
                $rgb = $this->HTMLToRGB($_POST['frame_gradient_one']);
                $hsl = $this->RGBToHSL($rgb);
                if ($hsl->lightness > 150) {
                    $svg = str_replace('.text-color{fill:#FFF;}', '.text-color{fill:#000;}', $svg);
                }
            } else {

                $_POST['frame_color'] = !preg_match('/#(?:[0-9a-fA-F]{6})/', $_POST['frame_color']) ? '#000000' : $_POST['frame_color'];
                $svg = $this->changeFrameColor($svg, $_POST['frame_color']);               
                $rgb = $this->HTMLToRGB($_POST['frame_color']);
                $hsl = $this->RGBToHSL($rgb);
                if ($hsl->lightness > 150) {
                    $svg = str_replace('.text-color{fill:#FFFFFF;}', '.text-color{fill:#000000;}', $svg);
                }
            }

            if (isset($_POST['frame_background_color_type']) == 'gradient') {

                $_POST['frame_background_gradient_one'] = !preg_match('/#(?:[0-9a-fA-F]{6})/', $_POST['frame_background_gradient_one']) ? '#000000' : $_POST['frame_background_gradient_one'];
                $svg = $this->changeFrameBackgroundGradientColor($svg, $_POST['frame_background_gradient_one'], $_POST['frame_background_gradient_two'], $_POST['frame_background_gradient_style']);
                $rgb = $this->HTMLToRGB($_POST['frame_background_gradient_one']);
                $hsl = $this->RGBToHSL($rgb);
                if ($hsl->lightness < 150) {
                    $svg = str_replace('.text-color-dark{fill:#000;}', '.text-color{fill:#FFF;}', $svg);
                }
            } else {
                $_POST['frame_background_color'] = !preg_match('/#(?:[0-9a-fA-F]{6})/', $_POST['frame_background_color']) ? '#000000' : $_POST['frame_background_color'];
               
                $svg = $this->changeFrameBackgroundColor($svg, $_POST['frame_background_color'], isset($_POST['frame_background_color_transparency']) ? true : false);
                $rgb = $this->HTMLToRGB($_POST['frame_background_color']);
                $hsl = $this->RGBToHSL($rgb);
                if ($hsl->lightness < 150) {
                    $svg = str_replace('.text-color-dark{fill:#000;}', '.text-color{fill:#FFF;}', $svg);
                }
            }
        }

        $qrImage = $svg;

        //QR Code's Scannability  
        $EOGrayScale = $this->grayScale($_POST['eyes_inner_color']);
        $EIGrayScale = $this->grayScale($_POST['eyes_outer_color']);

        //Frame
        if ($_POST['background_color_transparency'] == 100) {
            if ($_POST['qr_frame_id']) {
                if (array_search($_POST['qr_frame_id'], [9, 24, 27]) !== false) {
                    if (isset($_POST['frame_color_type']) && $_POST['frame_color_type'] === 'gradient') {
                        $BackGroundGrayScale = $this->grayScaleFromGradient($_POST['frame_gradient_one'], $_POST['frame_gradient_two']);
                    } else {
                        $BackGroundGrayScale = $this->grayScale($_POST['frame_color']);
                    }
                } else {
                    if (isset($_POST['frame_background_color_transparency'])) {
                        $BackGroundGrayScale = 0;
                    } elseif (isset($_POST['frame_background_color_type']) && $_POST['frame_background_color_type'] === 'gradient') {
                        $BackGroundGrayScale = $this->grayScaleFromGradient($_POST['frame_background_gradient_one'], $_POST['frame_background_gradient_two']);
                    } else {
                        $BackGroundGrayScale = $this->grayScale($_POST['frame_background_color']);
                    }
                }
            } else {
                $BackGroundGrayScale = 0;
            }
        } else if ($_POST['background_type'] === 'color') {
            $BackGroundGrayScale = $this->grayScale($_POST['background_color']);
        } else {
            $BackGroundGrayScale = $this->grayScaleFromGradient($_POST['background_gradient_one'], $_POST['background_gradient_two']);
        }

        //QR
        if ($_POST['foreground_type'] === 'color') {
            $PatternGrayScale = $this->grayScale($_POST['foreground_color']);
        } else {
            $PatternGrayScale = $this->grayScaleFromGradient($_POST['foreground_gradient_one'], $_POST['foreground_gradient_two']);
        }

        $patternTC = $PatternGrayScale - $BackGroundGrayScale;
        $cornerFrameTC = $EOGrayScale - $BackGroundGrayScale;
        $cornerDotTC = $EIGrayScale - $BackGroundGrayScale;

        if ($patternTC >= 0 || $cornerFrameTC >= 0 || $cornerDotTC >= 0) {
            $patternSBLevel = $patternTC >= 40 ? 1 : 0;
            $cornerFrameSBLevel = $cornerFrameTC >= 20 ? 1 : 0;
            $cornerDotSBLevel = $cornerDotTC >= 20 ? 1 : 0;
            $backgroundSBLevel = $BackGroundGrayScale <= 50 ? 1 : 0;
        } else {
            $patternSBLevel = ($patternTC + 100) >= 20 || ($patternTC + 100) == 0  ? 1 : 0;
            $cornerFrameSBLevel = ($cornerFrameTC + 100) >= 20 || ($cornerFrameTC + 100) == 0 ? 1 : 0;
            $cornerDotSBLevel = ($cornerDotTC + 100) >= 20 || ($cornerDotTC + 100) == 0 ? 1 : 0;
            $backgroundSBLevel = $BackGroundGrayScale >= 15 ? 1 : 0;
        }

        if ($patternSBLevel && $cornerFrameSBLevel && $cornerDotSBLevel && $backgroundSBLevel) {
            $message = 'GOOD';
        } else {
            $message = 'UNSCANNABLE';
        }

        $qr_sb_lvl = [
            "PatternGrayScale" => [$patternTC, $patternSBLevel],
            'CornerFrameGrayScale' => [$cornerFrameTC, $cornerFrameSBLevel],
            'CornerDotGrayScale' => [$cornerDotTC, $cornerDotSBLevel],
            'BackGroundGrayScale' => [$BackGroundGrayScale, $backgroundSBLevel],
            'status' => $message
        ];


        $data = 'data:image/svg+xml;base64,' . base64_encode($svg);
        $_POST['qr_code'] = $data;
        Response::json('', 'success', ['data' => $data, 'image' => $qrImage, 'message' => $message, 'qr_quality' => $qr_sb_lvl]);
        exit;
    }

    function grayScaleFromGradient($hexColor1, $hexColor2)
    {
        $GS1 = $this->grayScale($hexColor1);
        $GS2 = $this->grayScale($hexColor2);
        return ($GS1 + $GS2) / 2;
    }

    function grayScale($hexColor, $isBg = false)
    {
        /**
         * Returning Grayscale As a Percentage
         **/

        $rgb = $this->hex2rgb($hexColor);

        $intensity = 0.3 * $rgb[0] + 0.59 * $rgb[1] + 0.11 * $rgb[2];
        $k = 1;
        $r = round($intensity * $k + $rgb[0] * (1 - $k), 0);
        $g = round($intensity * $k + $rgb[1] * (1 - $k), 0);
        $b = round($intensity * $k + $rgb[2] * (1 - $k), 0);

        $grayscale = round(($r / 255) * 100, 0);

        return $grayscale = 100 - $grayscale;
    }


    function fillGradient($w, $h, $one, $two)
    {

        $im = imagecreatetruecolor($w, $h);
        $c[0] = $this->hex2rgb($one);
        $c[1] = $this->hex2rgb($two);

        $rgb = $c[0]; // start with top left color
        for ($x = 0; $x <= $w; $x++) { // loop columns
            for ($y = 0; $y <= $h; $y++) { // loop rows
                // set pixel color 
                $col = imagecolorallocate($im, $rgb[0], $rgb[1], $rgb[2]);
                imagesetpixel($im, $x, $y, $col);
                // calculate new color  
                for ($i = 0; $i <= 2; $i++) {
                    $rgb[$i] =
                        $c[0][$i] * (($w - $x) * ($h - $y) / ($w * $h)) +
                        $c[1][$i] * ($x     * ($h - $y) / ($w * $h));
                }
            }
        }
        return $im;
    }

    function hex2rgb($hex)
    {
        $rgb[0] = hexdec(substr($hex, 1, 2));
        $rgb[1] = hexdec(substr($hex, 3, 2));
        $rgb[2] = hexdec(substr($hex, 5, 2));
        return ($rgb);
    }


    private function changeFrameText($svg, $text)
    {
        return str_replace("#text", $text, $svg);
    }

    private function changeTextColor($svg, $frame_text_color)
    {
        return str_replace("frame_text_color", $frame_text_color, $svg);
    }

    private function qrFrameFontSize($svg, $qr_frame_font_size)
    {
        return str_replace("qr_frame_font_size", $qr_frame_font_size, $svg);
    }

    private function frameTextYPosition($svg, $frame_text_y_position)
    {
        return str_replace("frame_text_y_position", $frame_text_y_position, $svg);
    }

    private function changeFrameGradientColor($svg, $one, $two, $style)
    {
        if ($style == 'linear') {
            $svg = str_replace('GLC1', $one, $svg);
            $svg = str_replace('GLC2', $two, $svg);

            return str_replace('.black-area{fill:#000;}', '.black-area{fill: url(#linear);}', $svg);
        } else {
            $svg = str_replace('GLC1', $one, $svg);
            $svg = str_replace('GLC2', $two, $svg);
            $svg = str_replace('30%', '10%', $svg);
            $svg = str_replace('70%', '90%', $svg);
            $svg = str_replace('linear', 'radial', $svg);
            $svg = str_replace('#linear', '#radial', $svg);

            return str_replace('.black-area{fill:#000;}', '.black-area{fill: url(#radial);}', $svg);
        }
    }


    private function changeFrameBackgroundGradientColor($svg, $one, $two, $style)
    {
        if ($style == 'linear') {
            $svg = str_replace('GLCB1', $one, $svg);
            $svg = str_replace('GLCB2', $two, $svg);

            return str_replace('.white-area{fill:#FFF;}', '.white-area{fill: url(#linear-b);}', $svg);
            // $svg = str_replace('style="fill: #000; fill-opacity: 0.5"', 'style="fill: url(#linear); fill-opacity: 0.5"', $svg);
        } else {
            $svg = str_replace('GRCB1', $one, $svg);

            $svg = str_replace('GRCB2', $two, $svg);
            return str_replace('.white-area{fill:#FFF;}', '.white-area{fill: url(#radial-b);}', $svg);
        }
    }

    private function changeFrameColor($svg, $color)
    {
        return str_replace('.black-area{fill:#000;}', '.black-area{fill:' . $color . ';}', $svg);
    }

    private function changeFrameBackgroundColor($svg, $color, $transparent)
    {
        if ($transparent) {
            return  str_replace('.white-area{fill:#FFF;}', '.white-area{fill:#ffffff;}', $svg);
        } else {
            return str_replace('.white-area{fill:#FFF;}', '.white-area{fill:' . $color . ';}', $svg);
        }
    }

    function HTMLToRGB($htmlCode)
    {
        
        if ($htmlCode[0] == '#')
            $htmlCode = substr($htmlCode, 1);

        if (strlen($htmlCode) == 3) {
            $htmlCode = $htmlCode[0] . $htmlCode[0] . $htmlCode[1] . $htmlCode[1] . $htmlCode[2] . $htmlCode[2];
        }
       

        $r = hexdec($htmlCode[0] . $htmlCode[1]);
        $g = hexdec($htmlCode[2] . $htmlCode[3]);
        $b = hexdec($htmlCode[4] . $htmlCode[5]);

        return $b + ($g << 0x8) + ($r << 0x10);
    }

    function RGBToHSL($RGB)
    {
        $r = 0xFF & ($RGB >> 0x10);
        $g = 0xFF & ($RGB >> 0x8);
        $b = 0xFF & $RGB;

        $r = ((float)$r) / 255.0;
        $g = ((float)$g) / 255.0;
        $b = ((float)$b) / 255.0;

        $maxC = max($r, $g, $b);
        $minC = min($r, $g, $b);

        $l = ($maxC + $minC) / 2.0;

        if ($maxC == $minC) {
            $s = 0;
            $h = 0;
        } else {
            if ($l < .5) {
                $s = ($maxC - $minC) / ($maxC + $minC);
            } else {
                $s = ($maxC - $minC) / (2.0 - $maxC - $minC);
            }
            if ($r == $maxC)
                $h = ($g - $b) / ($maxC - $minC);
            if ($g == $maxC)
                $h = 2.0 + ($b - $r) / ($maxC - $minC);
            if ($b == $maxC)
                $h = 4.0 + ($r - $g) / ($maxC - $minC);

            $h = $h / 6.0;
        }

        $h = (int)round(255.0 * $h);
        $s = (int)round(255.0 * $s);
        $l = (int)round(255.0 * $l);

        return (object) array('hue' => $h, 'saturation' => $s, 'lightness' => $l);
    }


    private function compress_image($tempPath, $originalPath, $imageQuality, $key)
    {
        if (OFFLOAD_PROVIDER == 'local') {
            // Get image info
            if (!file_exists($tempPath)) {
                throw new Exception('The temp file does not exist');
            }
            $mime = mime_content_type($tempPath);

            // Create a new image from file 
            switch ($mime) {
                case 'image/jpeg':
                    $image = imagecreatefromjpeg($tempPath);
                    break;
                case 'image/png':
                    $input_file = $tempPath;
                    $output_file = $originalPath;
                    // Compress the input image using pngquant
                    exec("pngquant --force --output \"$output_file\" \"$input_file\"");
                    return $originalPath;
                    break;
                case 'image/gif':
                    $image = imagecreatefromgif($tempPath);
                    break;
                case 'image/webp':
                    $image = imagecreatefromwebp($tempPath);
                    break;
                case 'image/svg+xml':
                    move_uploaded_file($tempPath, $originalPath);
                    return $originalPath;
                    break;
                default:
                    $image = imagecreatefromjpeg($tempPath);
            }
            $orientation = isset(exif_read_data($tempPath)['Orientation']) ? exif_read_data($tempPath)['Orientation'] : null;
            $rotatedImages = $this->rotateImages($image, $orientation);
            // Save image 
            imagejpeg($rotatedImages, $originalPath, $imageQuality);
            imagedestroy($rotatedImages);
            // Return compressed image 
            return $originalPath;
        } else {
            $s3 = new \Aws\S3\S3Client(get_aws_s3_config());
            // Get image info 
            $mime = mime_content_type($tempPath);

            // Create a new image from file 
            switch ($mime) {
                case 'image/jpeg':
                    $image = imagecreatefromjpeg($tempPath);
                    $orientation = isset(exif_read_data($tempPath)['Orientation']) ? exif_read_data($tempPath)['Orientation'] : null;
                    $rotatedImages = $this->rotateImages($image, $orientation);
                    imagejpeg($rotatedImages, $originalPath, $imageQuality);
                    break;
                case 'image/png':
                    $input_file = $tempPath;
                    // Compress the input image using pngquant
                    exec("pngquant --force --output \"$originalPath\" \"$input_file\"");
                    break;
                case 'image/gif':
                    $image = imagecreatefromgif($tempPath);
                    $orientation = isset(exif_read_data($tempPath)['Orientation']) ? exif_read_data($tempPath)['Orientation'] : null;
                    $rotatedImages = $this->rotateImages($image, $orientation);
                    imagejpeg($rotatedImages, $originalPath, $imageQuality);
                    break;
                case 'image/webp':

                    $image = imagecreatefromwebp($tempPath);
                    $orientation = isset(exif_read_data($tempPath)['Orientation']) ? exif_read_data($tempPath)['Orientation'] : null;
                    $rotatedImages = $this->rotateImages($image, $orientation);
                    imagewebp($rotatedImages, $originalPath, $imageQuality);

                    break;
                case 'image/svg+xml':
                    try {
                        $s3->putObject([
                            'Bucket' => OFFLOAD_BUCKET,
                            'Key' =>  $key,
                            'ContentType' =>  'image/svg+xml',
                            'Body'   =>  file_get_contents($tempPath),
                            'ACL' => 'public-read',
                        ]);
                    } catch (\Exception $exception) {
                        Alerts::add_error($exception->getMessage());
                    }
                    return $originalPath;
                    break;
                default:
                    $image = imagecreatefromjpeg($tempPath);
            }

            if ($key && ($mime != 'image/svg+xml')) {
                try {
                    /* Upload mp3 */
                    $s3->putObject([
                        'Bucket' => OFFLOAD_BUCKET,
                        'Key' =>  $key,
                        'ContentType' =>  $mime,
                        'SourceFile'  => $originalPath,
                        'ACL' => 'public-read',
                    ]);
                } catch (\Exception $exception) {
                    Alerts::add_error($exception->getMessage());
                }
            }

            unlink($originalPath);

            return $originalPath;
        }
    }

    private function rotateImages($image, $orientation)
    {
        $image = $image;
        $rotate = null;
        switch ($orientation) {
            case 3:
                $rotate = 180;
                break;
            case 6:
                $rotate = -90;
                break;
            case 8:
                $rotate = 90;
                break;
        }
        if ($rotate) {
            $image = imagerotate($image, $rotate, 0);
        }

        return  $image;
    }

    function calculateContrastRatio($color1, $color2)
    {
        // Split the color values into their RGB components
        $r1 = ($color1 >> 16) & 0xFF;
        $g1 = ($color1 >> 8) & 0xFF;
        $b1 = $color1 & 0xFF;

        $r2 = ($color2 >> 16) & 0xFF;
        $g2 = ($color2 >> 8) & 0xFF;
        $b2 = $color2 & 0xFF;

        // Calculate the relative luminance of the colors
        $l1 = $this->calculateRelativeLuminance($r1, $g1, $b1);
        $l2 = $this->calculateRelativeLuminance($r2, $g2, $b2);

        // Calculate the contrast ratio
        $contrastRatio = ($l1 + 0.05) / ($l2 + 0.05);

        return $contrastRatio;
    }

    function calculateRelativeLuminance($red, $green, $blue)
    {
        $red = $red / 255;
        $green = $green / 255;
        $blue = $blue / 255;

        $red = ($red <= 0.03928) ? $red / 12.92 : pow(($red + 0.055) / 1.055, 2.4);
        $green = ($green <= 0.03928) ? $green / 12.92 : pow(($green + 0.055) / 1.055, 2.4);
        $blue = ($blue <= 0.03928) ? $blue / 12.92 : pow(($blue + 0.055) / 1.055, 2.4);

        $luminance = 0.2126 * $red + 0.7152 * $green + 0.0722 * $blue;

        return $luminance;
    }

    function hasSufficientContrast($color1, $color2)
    {
        $contrastRatio = $this->calculateContrastRatio($color1, $color2);
        return $contrastRatio;
        // return $this->determineContrastLevel($contrastRatio);
    }

    function determineContrastLevel($contrastRatio)
    {
        if ($contrastRatio >= 4.5) {
            return 'EXCELLENT';
        } elseif ($contrastRatio >= 3.1) {
            return 'GOOD';
        } elseif ($contrastRatio >= 1.5) {
            return 'POOR';
        } else {
            return 'UNSCANNABLE';
        }
    }

    private function changeLogoBgColor($imgObject,$hexColor){
        if($hexColor){
            $background_color = hex_to_rgb($hexColor);
            $background_color = imagecolorallocate($imgObject,  $background_color['r'], $background_color['g'], $background_color['b']);
            imagefill($imgObject, 0, 0, $background_color);
        }else{
            $color = imagecolorallocatealpha($imgObject, 0, 0, 0, 127);
            imagefill($imgObject, 0, 0, $color);
            imagesavealpha($imgObject, TRUE);
        }
    }
}
