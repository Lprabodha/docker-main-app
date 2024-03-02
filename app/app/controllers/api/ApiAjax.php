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
use Altum\Middlewares\Csrf;
use Altum\Models\QrCode;
use Altum\Response;
use Altum\Traits\Apiable;
use Exception;
use SVG\Nodes\Embedded\SVGImage;
use SimpleSoftwareIO\QrCode\Generator;
use SVG\SVG;
use DOMDocument;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ZipArchive;
use Dompdf\Dompdf;

class ApiAjax extends Controller
{
    use Apiable;

    public function index()
    {

        $this->verify_request(false, true);
        /* Decide what to continue with */
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'POST':
                /* Detect if we only need an object, or the whole list */
                // return call_user_func('ApiAjax', $_POST['action']);
                if (!empty($_POST['action'])) {
                    if ($_POST['action'] == 'loadDashboardData') {
                        echo $this->loadDashboardData();
                    } elseif ($_POST['action'] == 'deleteFolder') {
                        echo $this->deleteFolder();
                    } elseif ($_POST['action'] == 'editFolder') {
                        echo $this->editFolder();
                    } elseif ($_POST['action'] == 'createFolder') {
                        echo $this->createFolder();
                    } elseif ($_POST['action'] == 'loadCitiesData') {
                        echo $this->loadCitiesData();
                    } elseif ($_POST['action'] == 'contactInfoData') {
                        echo $this->contactInfoData();
                    } elseif ($_POST['action'] == 'passwordData') {
                        echo $this->passwordData();
                    } elseif ($_POST['action'] == 'languagedData') {
                        echo $this->languagedData();
                    } elseif ($_POST['action'] == 'timezoneData') {
                        echo $this->timezoneData();
                    } elseif ($_POST['action'] == 'userTaxData') {
                        echo $this->userTaxData();
                    } elseif ($_POST['action'] == 'TrackingAnalyticsData') {
                        echo $this->TrackingAnalyticsData();
                    } elseif ($_POST['action'] == 'qrcode_data_table') {
                        echo $this->qrcodeDataTable();
                    } elseif ($_POST['action'] == 'folder_listing') {
                        echo $this->folderListing();
                    } elseif ($_POST['action'] == 'qrcode_duplicate') {
                        echo $this->qrcodeDuplicate();
                    } elseif ($_POST['action'] == 'assign_folder_to_qrcode') {
                        echo $this->assignFolderToQrcode();
                    } elseif ($_POST['action'] == 'make_qrcode_paused') {
                        echo $this->makeQrcodeStatusPaused();
                    } elseif ($_POST['action'] == 'make_qrcode_deleted') {
                        echo $this->makeQrcodeStatusDeleted();
                    } elseif ($_POST['action'] == 'qr_status_resume') {
                        echo $this->makeQrcodeStatusActice();
                    } elseif ($_POST['action'] == 'qr_code_hard_delete') {
                        echo $this->qrCodeHardDelete();
                    } elseif ($_POST['action'] == 'saveCampaign') {
                        echo $this->saveCampaign();
                    } elseif ($_POST['action'] == 'reset_scan') {
                        echo $this->resetScan();
                    } elseif ($_POST['action'] == 'ajax_content') {
                        echo $this->ajax_content();
                    } elseif ($_POST['action'] == 'change_qr_name') {
                        echo $this->changeQrname();
                    } elseif ($_POST['action'] == 'save_qr_code') {
                        echo $this->save_qr_code();
                    } elseif ($_POST['action'] == 'makeProjectDeleted') {
                        echo $this->makeProjectDeleted();
                    } elseif ($_POST['action'] == 'deleteFiles') {
                        echo $this->deleteFiles();
                    } elseif ($_POST['action'] == 'change_qr_download_status') {
                        echo $this->qrDownloadStatus();
                    } elseif ($_POST['action'] == 'hideFeedbackBanner') {
                        echo $this->hideFeedbackBanner();
                    } elseif ($_POST['action'] == 'savePayInfo') {
                        echo $this->savePayInfo();
                    } elseif ($_POST['action'] == 'hideDownloadModel') {
                        echo $this->hideDownloadModel();
                    } elseif ($_POST['action'] == 'resizeSvg') {
                        echo $this->svgResize();
                    } elseif ($_POST['action'] == 'clearTemp') {
                        echo $this->clearTempSvg();
                    } elseif ($_POST['action'] == 'get_image_ratio') {
                        echo $this->getImageRatio();
                    } elseif ($_POST['action'] == 'share_svg') {
                        echo $this->convertSvg();
                    } elseif ($_POST['action'] == 'bulk_share') {
                        echo $this->bulkShare();
                    } elseif ($_POST['action'] == 'convert_image_eps') {
                        echo $this->convertImageToEps();
                    } elseif ($_POST['action'] == 'convert_svg') {
                        echo $this->convertSVGtoOthers();
                    } elseif ($_POST['action'] == 'svg_resize_return') {
                        echo $this->svgResizeAndReturn();
                    } elseif ($_POST['action'] == 'download_pdf') {
                        echo $this->downloadPdf();
                    } elseif ($_POST['action'] == 'share_email_attachment') {
                        echo $this->shareEmailAttachment();
                    } elseif ($_POST['action'] == 'updateURL') {
                        echo $this->UpdateURL();
                    } elseif ($_POST['action'] == 'edit_uploaded_image') {
                        echo $this->editUploadedImage();
                    } elseif ($_POST['action'] == 'is_download') {
                        echo $this->isDownload();
                    }
                } else {
                    echo $this->noActionFound();
                }
                break;
            case 'GET':

                /* Detect if we only need an object, or the whole list */

                break;
        }

        // $this->return_404();
    }


    private function noActionFound()
    {
        $data = [
            'result' => 'fail',
            'data' => [
                'message' => 'no action found!!',
            ],
        ];

        return Response::jsonapi_success($data, null, 200);
    }

    public function downloadPdf()
    {

        if (isset($_FILES['file']) and !$_FILES['file']['error']) {

            $pdfFilePath = UPLOADS_PATH . 'temp/' . $_POST['name'];
            move_uploaded_file($_FILES['file']['tmp_name'], $pdfFilePath);
            return Response::jsonapi_success(["path" => $pdfFilePath], null, 200);
        } else {
            return Response::jsonapi_error([[
                'title' => 'File download failed',
                'status' => '401'
            ]], null, 401);
        }
    }

    public function svgResizeAndReturn()
    {
        if (isset($_POST['isBulk'])) {

            $origialSvgs = $_POST['svgPath'];
            $width = $_POST['width'];
            $height = $_POST['height'];

            $responses = [];

            foreach ($origialSvgs as $origialSvg) {
                $random_number = random_int(100000, 500000);
                $dom = new DOMDocument('1.0', 'utf-8');
                $dom->loadXML(file_get_contents($origialSvg));
                $svg = $dom->documentElement;

                if (!$svg->hasAttribute('viewBox')) { // viewBox is needed to establish
                    // userspace coordinates
                    $pattern = '/^(\d+)$/'; // any positive number

                    $interpretable =  preg_match($pattern, $width) &&
                        preg_match($pattern, $height);

                    if ($interpretable) {
                        $view_box = implode(' ', [0, 0, $width, $height]);
                        $svg->setAttribute('viewBox', $view_box);
                    } else { // this gets sticky
                        return Response::jsonapi_success("viewBox is dependent on environment", null, 500);
                    }
                }
                $svg->setAttribute('width', $width);
                $svg->setAttribute('height', $height);

                $dom->save(UPLOADS_PATH . 'temp/' . $random_number . '.svg');

                $responses[] = [
                    "svg" => url('uploads/temp') . "/$random_number.svg"
                ];
            }
            return Response::jsonapi_success(
                $responses,
                null,
                200
            );
        } else {

            $origialSvg = $_POST['svgPath'];
            $width = $_POST['width'];
            $height = $_POST['height'];
            $tempName = $_POST['tmpName'];

            $dom = new DOMDocument('1.0', 'utf-8');
            $dom->loadXML(file_get_contents($origialSvg));
            $svg = $dom->documentElement;

            if (!$svg->hasAttribute('viewBox')) { // viewBox is needed to establish
                // userspace coordinates
                $pattern = '/^(\d*\.\d+|\d+)(px)?$/'; // positive number, px unit optional

                $interpretable =  preg_match($pattern, $svg->getAttribute('width'), $width) &&
                    preg_match($pattern, $svg->getAttribute('height'), $height);

                if ($interpretable) {
                    $view_box = implode(' ', [0, 0, $width, $height]);
                    $svg->setAttribute('viewBox', $view_box);
                } else { // this gets sticky
                    return Response::jsonapi_success("viewBox is dependent on environment", null, 500);
                }
            }
            $svg->setAttribute('width', $width);
            $svg->setAttribute('height', $height);

            $dom->save(UPLOADS_PATH . 'temp/' . $tempName . '.svg');

            return Response::jsonapi_success(["svg" => url('uploads/temp') . "/$tempName.svg"], null, 200);
        }
    }

    public function convertImageToEps()
    {

        $originalSvg = $_POST['svgPath'];
        $width = $_POST['width'];
        $tempName = $_POST['tmpName'];
        $qrId = $_POST['qrId'];

        $qrData = "SELECT * FROM `qr_codes` WHERE `qr_code_id` = $qrId";
        $qr_result = database()->query($qrData);
        $qrCodeData = $qr_result->fetch_assoc();


        /* Upload the original */
        $settings = json_decode($qrCodeData['data']);


        $url = LANDING_PAGE_URL . $tempName;
        $data = $url;

        $qr = new Generator;
        $qr->size($width);
        $qr->errorCorrection($settings->ecc);
        $qr->encoding('UTF-8');
        $qr->margin($settings->margin);
        $qr->style($settings->style, 0.9);

        $qr->eye(\BaconQrCode\Renderer\Module\EyeCombiner::instance($settings->cEye, $settings->fEye));


        $settings->foreground_type = isset($settings->foreground_type)  ? $settings->foreground_type : 'color';
        $settings->background_type = isset($settings->background_type)  ? $settings->background_type : 'color';

        $qr->backgroundColor(0, 0, 0, 0);

        /* Generate the first SVG */
        try {
            $qr->format('eps');
            $eps = $qr->generate($data);
            // Response::json($svg, $uId . '.pdf', 'error');
        } catch (\Exception $exception) {
            Response::json($exception->getMessage(), 'error');
        }

        file_put_contents('uploads/temp/' . $tempName . '.eps', $eps);
        return Response::jsonapi_success(['fileName' => "$tempName.eps", "path" => url('uploads/temp') . "/$tempName.eps"], null, 200);
    }


    public function savePayInfo()
    {
        $data = (json_decode($_POST['address'], true));

        $_POST['billing'] = json_encode([
            'name'      => $data['name'],
            'email'     => $_POST['email'],
            'line1'     => $data['address']['line1'],
            'line2'     => $data['address']['line2'],
            'city'      => $data['address']['city'],
            'province'  => isset($data['address']['province']) ? $data['address']['province'] : '',
            'state'     => isset($data['address']['state']) ? $data['address']['state'] : '',
            'zip'       => isset($data['address']['zip']) ? $data['address']['zip'] : '',
            'country'   => $data['address']['country'],
            'postal_code' => isset($data['address']['postal_code']) ? $data['address']['postal_code'] : '',

        ]);

        $name_parts = explode(" ", $data['name']);
        $first_name = $name_parts[0];
        // Assign the last name
        $last_name = $name_parts[1];

        /* Database query */
        db()->where('user_id', $_POST['user_id'])->update('users', ['billing' => $_POST['billing'], 'name' => $data['name']]);

        $tax = db()->where('user_id', $_POST['user_id'])->getOne('taxes');

        if (!$tax) {
            db()->insert('taxes', [
                'user_id' => $_POST['user_id'],
                'type' => 'private',
                'company_name' => '#',
                'tax_id' => '#',
                'name' => $data['name'],
                'surname' => '-',
                'address' => $data['address']['line1'] . ', ' . $data['address']['line2'],
                'postal_code' => (isset($data['address']['zip']) ? $data['address']['zip'] : '') . (isset($data['address']['postal_code']) ? $data['address']['postal_code'] : ''),
                'city' => $data['address']['city'],
                'country' => $data['address']['country'],
                'email' => $_POST['email'],
            ]);
        } else {
            db()->where('user_id', $_POST['user_id'])->update(
                'taxes',
                [
                    'address' => $data['address']['line1'] . ', ' . $data['address']['line2'],
                    'postal_code' => (isset($data['address']['zip']) ? $data['address']['zip'] : '') . (isset($data['address']['postal_code']) ? $data['address']['postal_code'] : ''),
                    'city' => $data['address']['city'],
                    'country' => $data['address']['country'],
                ]
            );
        }

        try {
            $stripe = new \Stripe\StripeClient(settings()->stripe->secret_key);

            try {
                $stripe->customers->update(
                    $_POST['customer_id'],
                    ['name' => $data['name']]
                );
            } catch (Exception $e) {
                return Response::jsonapi_error([[
                    'title' => 'failed',
                    'status' => '401'
                ]], null, 401);
            }
        } catch (Exception $e) {
            return Response::jsonapi_error([[
                'title' => 'failed',
                'status' => '401'
            ]], null, 401);
        }


        return Response::jsonapi_success(
            [
                'name' => $data['name'],
                'country' => $data['address']['country'],
                'postal_code' => (isset($data['address']['zip']) ? $data['address']['zip'] : '') . (isset($data['address']['postal_code']) ? $data['address']['postal_code'] : '')
            ],
            null,
            200
        );
    }

    public function deleteFiles()
    {
        @unlink($_SERVER['DOCUMENT_ROOT'] . $_POST['fileLinks']);
        return Response::jsonapi_success("Hello", null, 200);
    }

    public function loadDashboardData()
    {
        try {
            /**date */
            $dates = explode(" - ", $_POST['date_range']);           
            $start_date = date('Y-m-d', strtotime($dates[0]));           
            $end_date = date('Y-m-d', strtotime($dates[1]));          

            if (!empty($_POST['qr_code']) && is_array($_POST['qr_code']) && count($_POST['qr_code']) > 0) {
                $qr_codes = $_POST['qr_code'];
            } else {
                $qr_codes = db()->where('user_id', $this->user->user_id)->get('qr_codes', null, ['name', 'qr_code_id']);
                $qr_codes = [array_column($qr_codes, 'qr_code_id')];
            }

            $os_name = $country_name = $city_name = [];
            if (!empty($_POST['os_name']) && is_array($_POST['os_name']) && count($_POST['os_name']) > 0) {
                $os_name = $_POST['os_name'];
            }

            if (!empty($_POST['country_name']) && is_array($_POST['country_name']) && count($_POST['country_name']) > 0) {
                $country_name = $_POST['country_name'];
            }

            if (!empty($_POST['city_name']) && is_array($_POST['city_name']) && count($_POST['city_name']) > 0) {
                $city_name = $_POST['city_name'];
            }

            $totalQrCodes = $this->totalScanQrCode($start_date, $end_date, $qr_codes, $os_name, $country_name, $city_name, $commonQuery);

            $totalScanQrCode = $totalQrCodes['totalScan'];
            $totalUniqueScanQrCode = $totalQrCodes['totalUniqueScan'];
            $query = $totalQrCodes['query'];

            $scan_by_os_rows = $this->scan_by_os($commonQuery);
            $os_chart = [];
            foreach ($scan_by_os_rows as $row) {
                $os_chart['labels'][] = $row[0];
                $os_chart['values'][] = (int)$row[1];
            }

            $scan_by_country_rows = $this->scan_by_contry($commonQuery);
            $country_chart = [];
            foreach ($scan_by_country_rows as $row) {
                $country_chart['labels'][] = $row[0];
                $country_chart['values'][] = (int)$row[1];
            }

            $scan_by_city_rows = $this->scan_by_city($commonQuery);

            $city_chart = [];
            foreach ($scan_by_city_rows as $row) {
                $city_chart['labels'][] = $row[0];
                $city_chart['values'][] = (int)$row[1];
            }

            $chart_data = $this->getChartData($commonQuery, $start_date, $end_date);

            $data = [
                'result' => 'success',
                'data' => [
                    'totalScan' => $totalScanQrCode,
                    'totalUniqueScan' => $totalUniqueScanQrCode,
                    'scan_by_os_rows' => $scan_by_os_rows,
                    'scan_by_country_rows' => $scan_by_country_rows,
                    'scan_by_city_rows' => $scan_by_city_rows,
                    'query' => $query,
                    'chart_data' => $chart_data,
                    'os_chart' => $os_chart,
                    'country_chart' => $country_chart,
                    'city_chart' => $city_chart,
                ],
            ];

            // return json_encode($data);
            return Response::jsonapi_success($data, null, 200);
        } catch (\Exception $exception) {
            $data = ['result' => 'failed', 'data' => ['message' => $exception->getMessage()]];
            return Response::jsonapi_success($data, null, 401);
        }

        $data = ['result' => 'failed', 'data' => ['message' => 'Something went wrong!!']];
        return Response::jsonapi_success($data, null, 422);
    }

    public function loadCitiesData()
    {
        try {

            $user_id = $_POST['user_id'];
            $where = "WHERE qr_code_id IN (SELECT qr_code_id FROM `qr_codes` WHERE user_id = '{$user_id}')";

            /**date */
            if (!empty($_POST['country_name']) && is_array($_POST['country_name']) && count($_POST['country_name']) > 0) {
                $country_name = $_POST['country_name'];
                $in = $this->makeInStr($country_name);
                $where .= " AND country_name IN ($in)";
            }

            $rawQuery = "SELECT DISTINCT(city_name) as city_name FROM `qrscan_statistics` $where ";
            $query = database()->query($rawQuery);
            $citiesName = [];
            if ($query) {
                $citiesName = $query->fetch_all(MYSQLI_ASSOC);
            }

            $data = [
                'result' => 'success',
                'data' => [
                    'country_name' => $country_name,
                    'queryResult' => $rawQuery,
                    'cities' => $citiesName,
                    'rawQuery' => $rawQuery,
                ],
            ];

            // return json_encode($data);
            return Response::jsonapi_success($data, null, 200);
        } catch (\Exception $exception) {
            $data = ['result' => 'failed', 'data' => ['message' => $exception->getMessage()]];
            return Response::jsonapi_success($data, null, 401);
        }

        $data = ['result' => 'failed', 'data' => ['message' => 'Something went wrong!!']];
        return Response::jsonapi_success($data, null, 422);
    }

    public function contactInfoData()
    {
        $user_id = $_POST['user_id'];

        $user = db()->where('user_id', $user_id)->getOne('users');

        if ($user->email != $_POST['email']) {

            $user_email = db()->where('email', $_POST['email'])->getOne('users');

            if ($user_email) {
                $error = ['result' => 'failed', 'data' => ['message' => 'This email address is already in use!']];
                return Response::jsonapi_error($error, null, 200);
            }

            $data = [
                'old_email' => $user->email,
                'new_email' => $_POST['email'],
            ];

            // user email change log
            db()->insert('email_change', [
                'user_id'          => $user_id,
                'data'             => json_encode($data),
                'created_at'       => \Altum\Date::$date,
            ]);

            $billing = json_decode($user->billing);
            $array = [];
            foreach ($billing as $key => $value) {
                if ($key == 'email') {
                    $array['email'] = $_POST['email'];
                } else {
                    $array[$key] = $value;
                }
            }

            // update stripe  customer
            try {

                $stripe = new \Stripe\StripeClient(settings()->stripe->secret_key);

                $customer = null;

                $customer  = $stripe->customers->search([
                    'query' => 'email:\'' . $user->email . '\' ',
                ]);

                if ($customer['data']) {
                    $customerId  = $customer['data'][0]->id;

                    $stripe->customers->update(
                        $customerId,
                        [
                            'email' => $_POST['email'],
                            'metadata' => ['user_email' => $_POST['email']]
                        ]
                    );
                }
            } catch (Exception $e) {
                Alerts::add_error(l('pay.error_message.payment_gateway'));
            }

            if ($user->email_subscription_type != 2) {
                /* Send email change email  */
                $template      = 'email-change';
                trigger_email($user->user_id, $template);
            }
        }


        $conversion_data = analyticsBb()->where('user_id', $user_id)->getOne('conversion_data');

        if ($conversion_data) {
            analyticsBb()->where('user_id', $user_id)->update('conversion_data', [
                'first_name'   => $_POST['name'],
                'last_name'    => $_POST['surname'],
            ]);
        }


        db()->where('user_id', $user_id)->update('users', [
            'name'      => $_POST['name'] . " " . $_POST['surname'],
            'email'     => $_POST['email'],
            'telephone' => $_POST['telephone'],
            'billing'   => json_encode($array),

        ]);



        return Response::jsonapi_success("success", null, 200);
    }

    public function qrDownloadStatus()
    {
        $qr_code_id = $_POST['qr_code_id'];
        $qr_uid = $_POST['uid'];
        $user_id = $_POST['user_id'];

        $user = db()->where('user_id', $user_id)->getOne('users');

        if ($user) {
            $dpfUser =  db()->where('user_id', $user_id)->getOne('dpf_user_emails');

            $is30MinuteEmail =  false;
            if ($dpfUser) {
                $is30MinuteEmail =  $dpfUser->is_one_hour_email;
            }

            if ($user  &&  $dpfUser && $user->onboarding_funnel == 3  && $user->payment_processor == null && !$is30MinuteEmail && $dpfUser->is_direct_download_email == 0 && $user->email_subscription_type != 2) {

                try {

                    $template = 'dpf-download-qr';
                    $link     =  'qr-download/' . $user->referral_key;
                    $email    = trigger_email($user->user_id, $template, $link);
                    if ($email['complete']) {
                        db()->where('user_id', $user->user_id)->update('dpf_user_emails', [
                            'is_direct_download_email' => '1',
                        ]);
                    }
                } catch (\Throwable $th) {
                    throw $th;
                }
            }


            db()->where('qr_code_id', $qr_code_id)->update('qr_codes', [
                'is_download' => 1,
            ]);

            db()->where('user_id', $user_id)->update('users', [
                'is_download' => 1,
            ]);


            return Response::jsonapi_success("success", null, 200);
        }else{
            return Response::jsonapi_success("failed", null, 200);
        }
    }

    public function passwordData()
    {
        $user_id = $_POST['user_id'];
        $password = $_POST['password'];
        $password_check = $_POST['repassword'];
        if ($password === $password_check) {
            $new_pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

            db()->where('user_id', $user_id)->update('users', [
                'password' => $new_pass,
            ]);

            $user = db()->where('user_id', $user_id)->getOne('users');

            if ($user->email_subscription_type != 2) {
                /* Send notification to the user */
                $template = 'change-password';
                trigger_email($user->user_id, $template);
            }
            return Response::jsonapi_success("success", null, 200);
        }

        return Response::jsonapi_success("failed", null, 200);
    }


    public function languagedData()
    {
        $user_id = $_POST['user_id'];

        $langName  = get_language_name($_POST['language']);
        db()->where('user_id', $user_id)->update('users', [
            'language' => $langName,
        ]);
        return Response::jsonapi_success("success", null, 200);
    }

    public function timezoneData()
    {
        $user_id = $_POST['user_id'];
        db()->where('user_id', $user_id)->update('users', [
            'timezone' => $_POST['timezone'],
        ]);
        return Response::jsonapi_success("success", null, 200);
    }

    public function TrackingAnalyticsData()
    {
        $user_id = $_POST['user_id'];

        db()->where('user_id', $user_id)->update('users', [
            'google_tracking_id' => $_POST['trackingid'],
            'pixelid' => $_POST['pixelid'],
        ]);
        return Response::jsonapi_success("success", null, 200);
    }

    public function userTaxData()
    {

        $user_id = $_POST['user_id'];
        $data = [
            'user_id' => $user_id,
            'type' => $_POST['radio'],
            'company_name' => $_POST['company_name'],
            'tax_id' => $_POST['tax_id'],
            'name' => $_POST['tax_name'],
            'surname' => $_POST['tax_surname'],
            'address' => $_POST['address'],
            'postal_code' => $_POST['postal_code'],
            'city' => $_POST['city'],
            'email' => $_POST['email'],
            'country' => $_POST['country'],
        ];

        try {
            if (db()->where('user_id', $_POST['user_id'])->getOne('taxes')) {
                db()->where('user_id', $_POST['user_id'])->update('taxes', $data);
            } else {
                db()->insert('taxes', $data);
            }
            db()->where('user_id', $_POST['user_id'])->update('users', ['country' => $_POST['country']]);

            $conversionData = analyticsDatabase()->query("SELECT * FROM `conversion_data` WHERE `user_id` = {$user_id} ORDER BY `id` DESC LIMIT 1")->fetch_object();
        
            if ($conversionData) {
                analyticsBb()->where('user_id', $user_id)->update('conversion_data', [
                    'first_name'         => $_POST['tax_name'],
                    'last_name'          => $_POST['tax_surname'],
                    'address'            => $_POST['address']
                ]);
            }


        } catch (\Throwable $th) {
            throw $th;
        }

        return Response::jsonapi_success("success", null, 200);
    }

    private function makeInStr($arr)
    {
        return "'" . implode("','", $arr) . "'";
    }

    private function totalScanQrCode($start_date, $end_date, $qr_codes, $os_name, $country_name, $city_name, &$commonQuery)
    {

        $rawQuery = "SELECT count(id) FROM `qrscan_statistics` WHERE `is_unique` = '1'";
        $whereArr = [];

        if (count($qr_codes) > 0) {
            $whereArr[] = "(DATE_FORMAT(datetime, '%Y-%m-%d') BETWEEN '$start_date' AND '$end_date')";
        }

        if (count($qr_codes) > 0) {
            $in = $this->makeInStr($qr_codes);
            $whereArr[] = "(qr_code_id IN ($in))";
        }

        if (count($os_name) > 0) {
            $in = $this->makeInStr($os_name);
            $whereArr[] = "(os_name IN ($in))";
        }
        if (count($country_name) > 0) {
            if (count($country_name) < 200) {
                $in = $this->makeInStr($country_name);
                $whereArr[] = "(country_name IN ($in))";
            }
        }
        if (count($city_name) > 0) {
            if (count($city_name) < 200) {
                $in = $this->makeInStr($city_name);
                $whereArr[] = "(city_name IN ($in))";
            }
        }


        if (count($whereArr) > 0) {
            $whereCondition = implode(" AND ", $whereArr);
            $commonQuery = $rawQuery = "SELECT count(id) FROM `qrscan_statistics` WHERE $whereCondition";
            $UniquScanQuery = "SELECT count(id) FROM `qrscan_statistics` WHERE `is_unique` = '1' AND $whereCondition";
        } else {
            $commonQuery = $rawQuery = "SELECT count(id) FROM `qrscan_statistics`";
            $UniquScanQuery = "SELECT count(id) FROM `qrscan_statistics` WHERE `is_unique` = '1'";
        }

        $query = database()->query($rawQuery);
        $totalScan = $query->fetch_row()['0'];



        $query = database()->query($UniquScanQuery);
        $totalUniqueScan = $query->fetch_row()['0'];



        return [
            'totalScan' => $totalScan,
            'totalUniqueScan' => $totalUniqueScan,
            'query' => $UniquScanQuery,
        ];
    }

    private function getChartData($commonQuery, $startDate, $endDate)
    {
        $rangArray = [];
        $startDate = strtotime($startDate);
        $endDate = strtotime($endDate);

        for (
            $currentDate = $startDate;
            $currentDate <= $endDate;
            $currentDate += (86400)
        ) {

            $date = date('Y-m-d', $currentDate);
            $rangArray[] = $date;
        }

        $rawQuery = str_replace('count(id)', "DATE_FORMAT(datetime, '%Y-%m-%d'), COUNT(id), SUM(is_unique)", $commonQuery);

        $rawQuery = $rawQuery . "GROUP BY DATE_FORMAT(datetime, '%Y-%m-%d')";
        $query = database()->query($rawQuery);
        $pageviews_result = $query->fetch_all();

        $data = null;

        if (count($pageviews_result) > 0) {

            foreach ($pageviews_result as $row) {
                $viewArray[$row[0]] = [
                    'pageviews' => $row[1],
                    'visitors'  => $row[2]
                ];
            }



            foreach ($rangArray as $date) {
                $data['labels'][] = (new \DateTime($date))->format('Y-M d');
                if (isset($viewArray[$date])) {
                    $data['pageviews'][] = $viewArray[$date]['pageviews'];
                    $data['visitors'][] = $viewArray[$date]['visitors'];
                } else {
                    $data['pageviews'][] = 0;
                    $data['visitors'][] = 0;
                }
            }
            return $data;
        }

        return $data;
    }


    private function scan_by_os($commonQuery)
    {
        $rawQuery = str_replace('count(id)', 'os_name, count(os_name)', $commonQuery);
        $rawQuery = $rawQuery . "GROUP BY os_name ORDER BY count(id) DESC";
        $query = database()->query($rawQuery);
        $totalScan = $query->fetch_all();

        return $totalScan;
    }
    private function scan_by_contry($commonQuery)
    {
        $rawQuery = str_replace('count(id)', 'country_name, count(country_name)', $commonQuery);
        $rawQuery = $rawQuery . "GROUP BY country_name ORDER BY count(id) DESC";
        $query = database()->query($rawQuery);
        $totalScan = $query->fetch_all();

        return $totalScan;
    }
    private function scan_by_city($commonQuery)
    {
        $rawQuery = str_replace('count(id)', 'city_name, count(city_name)', $commonQuery);
        $rawQuery = $rawQuery . "GROUP BY city_name ORDER BY count(id) DESC";
        $query = database()->query($rawQuery);
        $totalScan = $query->fetch_all();

        return $totalScan;
    }

    public function createFolder()
    {

        $insertData = [
            'user_id' => $_POST['user_id'],
            'name' => $_POST['name'],
            'datetime' => date('Y-m-d H:i:s'),
        ];
        $project_id = db()->insert('projects', $insertData);

        /* Folders query */
        $projects_result = database()->query("
        SELECT * 
        FROM `projects`
        WHERE `user_id` = {$_POST['user_id']}
        ");

        /* Iterate over the folders query */
        $folders = [];

        while ($row = $projects_result->fetch_object()) {
            $folders[] = $row;
        }



        $insertData[] = $folders;

        return Response::jsonapi_success($insertData, null, 200);
    }
    public function editFolder()
    {
        $updateData = [
            'user_id' => $_POST['user_id'],
            'name' => $_POST['name'],
            'datetime' => date('Y-m-d H:i:s'),
        ];
        db()->where('user_id', $_POST['user_id'])
            ->where('project_id', $_POST['project_id'])
            ->update('projects', ['name' => $_POST['name'], 'datetime' => date('Y-m-d H:i:s')]);

        return Response::jsonapi_success($updateData, null, 200);
    }
    public function deleteFolder()
    {
        $updateData = [
            'user_id' => $_POST['user_id'],
            'datetime' => date('Y-m-d H:i:s'),
        ];
        db()->where('user_id', $_POST['user_id'])
            ->where('project_id', $_POST['project_id'])
            ->delete('projects');

        db()->where('user_id', $_POST['user_id'])
            ->where('project_id', $_POST['project_id'])
            ->update('qr_codes', ['project_id' => null, 'datetime' => date('Y-m-d H:i:s')]);

        return Response::jsonapi_success($updateData, null, 200);
    }

    private function qrcodeDataTableSearch()
    {
        $extraWhere = '';
        if (!empty($_REQUEST['project_id']) && $_REQUEST['project_id'] > 0) {
            $project_id = $_POST['project_id'];
            $extraWhere .= " AND (`project_id` = '$project_id')";
        }
        if (!empty($_REQUEST['qr_code_status'])) {
            $qr_code_status = $_REQUEST['qr_code_status'];
            if ($qr_code_status == "1") {
                $extraWhere .= " AND (`status` = '1' OR `status` = '2')";
            } else {
                $extraWhere .= " AND (`status` = '$qr_code_status')";
            }
        }
        if (!empty($_REQUEST['search_keyword'])) {
            $search_keyword = $_REQUEST['search_keyword'];
            $extraWhere .= " AND (`name` LIKE '%$search_keyword%')";
        }
        if (!empty($_REQUEST['qr_code_type']) && is_array($_REQUEST['qr_code_type']) && count($_REQUEST['qr_code_type']) > 0) {
            $in = $this->makeInStr($_REQUEST['qr_code_type']);
            $extraWhere .= " AND (`type` IN ($in))";
        }
        return $extraWhere;
    }
    private function qrcodeDataTableSortBy()
    {
        $sort_by = '';

        // return $sort_by;
        if (!empty($_POST['sort_by']) && $_POST['sort_by'] == 'name') {
            $sort_by = "ORDER BY name ASC";
        } elseif (!empty($_POST['sort_by']) && $_POST['sort_by'] == 'most-scan') {
            $sort_by = "ORDER BY total_scan DESC";
        } elseif (!empty($_POST['sort_by']) && $_POST['sort_by'] == 'last-modified') {
            $sort_by = "ORDER BY updated_at DESC";
        } else {
            $sort_by = "ORDER BY datetime DESC";
        }

        return $sort_by;
    }

    private function qrcodeDataTable()
    {
        $user_id = $_POST['user_id'];
        $isPlanExpire = $_POST['isPlanExpire'];
        $limit = $_REQUEST['limit'] ?? 10;
        // $limit = 2;
        $page_no = $_REQUEST['page_no'] ?? 1;
        $offset = ((int) $page_no - 1) * $limit;

        // for search query
        $extraWhere = $this->qrcodeDataTableSearch();
        // for sort_by
        $sort_by = $this->qrcodeDataTableSortBy();

        /**total records */
        $queryStrTotalRecodrs = "SELECT COUNT(`qr_code_id`) FROM `qr_codes` WHERE `user_id` = '{$user_id}' {$extraWhere}";
        // dd($queryStrTotalRecodrs);
        $qrResource = database()->query($queryStrTotalRecodrs);
        $filterRecordsTotal = $recordsTotal = $qrResource->fetch_row()['0'];

        $select = "*";

        $select .= ", (SELECT COUNT(id) FROM `qrscan_statistics` WHERE `qr_code_id` = qr_codes.`qr_code_id`) AS total_scan";

        $queryStr = "SELECT {$select} FROM `qr_codes` WHERE `user_id` = '{$user_id}' {$extraWhere} {$sort_by} LIMIT {$offset}, {$limit}";
        $qrCodesQrResource = database()->query($queryStr);
        $qrCodes = $qrCodesQrResource->fetch_all(MYSQLI_ASSOC);

        $paginator = (new \Altum\Paginator($filterRecordsTotal, $limit, $page_no, '%d'));
        /* Prepare the pagination view */
        $pagination = (new \Altum\Views\View('partials/pagination', (array) $this))->run(['paginator' => $paginator]);
        $pageData = $paginator->getPages();

        $projects = (new \Altum\Models\Projects())->get_projects_by_user_id($user_id);

        $data = [
            'qr_codes' => $qrCodes,
            'pagination' => $pagination,
            'isPlanExpire' => $isPlanExpire,
            'projects' => $projects,
        ];
        $html = (new \Altum\Views\View('qr-codes/qr-cards', $data))->run($data);

        $response['recordsTotal'] = $recordsTotal;
        $response['recordsFiltered'] = $filterRecordsTotal;
        $response['qrCodes'] = $qrCodes;
        // $response ['$queryStr'] = $queryStr;
        $response['$pageData'] = $pageData;
        $response['html'] = $html;
        // $response ['queryStrTotalRecodrs'] = $queryStrTotalRecodrs;
        // $response ['$_REQUEST'] = $_REQUEST;

        return Response::jsonapi_success($response, null, 200);
    }

    private function qrcodeDuplicate()
    {

        if (!empty($_POST['qr_code_id']) && !empty($_POST['user_id'])) {
            $qr_code_id = $_POST['qr_code_id'];
            $uId =  uniqid();
            $user_id = $_POST['user_id'];
            $today = date('Y-m-d H:i:s');

            /* Generate new name for image */
            $image_new_name = $uId . '.svg';

            $qrData = "SELECT * FROM `qr_codes` WHERE `qr_code_id` = $qr_code_id  AND `user_id` = $user_id";
            $qr_result = database()->query($qrData);
            $qrCodeData = $qr_result->fetch_assoc();


            /* Upload the original */
            $settings = json_decode($qrCodeData['data']);

            if ($qrCodeData['type'] == 'wifi') {
                $data_to_be_rendered = 'WIFI:S:' . $settings->wifi_ssid . ';';
                $data_to_be_rendered .= 'T:' . $settings->wifi_encryption . ';';
                if ($settings->wifi_password) $data_to_be_rendered .= 'P:' . $settings->wifi_password . ';';
                if ($settings->wifi_is_hidden) $data_to_be_rendered .= 'H:' . (bool) $settings->wifi_is_hidden . ';';
                $data_to_be_rendered .= ';';

                $data = $data_to_be_rendered;
            } else {
                $url = LANDING_PAGE_URL . $uId;
                $data = $url;
            }



            $qr = new Generator;
            $qr->size($settings->size);
            $qr->errorCorrection($settings->ecc);
            $qr->encoding('UTF-8');
            $qr->margin($settings->margin);
            $qr->style($settings->style, 0.9);
            /* Eyes */
            if ($settings->custom_eyes_color) {
                $eyes_inner_color = hex_to_rgb($settings->eyes_inner_color);
                $eyes_outer_color = hex_to_rgb($settings->eyes_outer_color);

                $qr->eyeColor(0, $eyes_inner_color['r'], $eyes_inner_color['g'], $eyes_inner_color['b'], $eyes_outer_color['r'], $eyes_outer_color['g'], $eyes_outer_color['b']);
                $qr->eyeColor(1, $eyes_inner_color['r'], $eyes_inner_color['g'], $eyes_inner_color['b'], $eyes_outer_color['r'], $eyes_outer_color['g'], $eyes_outer_color['b']);
                $qr->eyeColor(2, $eyes_inner_color['r'], $eyes_inner_color['g'], $eyes_inner_color['b'], $eyes_outer_color['r'], $eyes_outer_color['g'], $eyes_outer_color['b']);
            }

            $qr->eye(\BaconQrCode\Renderer\Module\EyeCombiner::instance($settings->cEye, $settings->fEye));


            $settings->foreground_type = isset($settings->foreground_type)  ? $settings->foreground_type : 'color';
            $settings->background_type = isset($settings->background_type)  ? $settings->background_type : 'color';

            switch ($settings->foreground_type) {
                case 'color':

                    $foreground_color = hex_to_rgb($settings->foreground_color);
                    $qr->color($foreground_color['r'], $foreground_color['g'], $foreground_color['b']);
                    break;

                case 'gradient':
                    $foreground_gradient_one = hex_to_rgb($settings->foreground_gradient_one);
                    $foreground_gradient_two = hex_to_rgb($settings->foreground_gradient_two);
                    $qr->gradient($foreground_gradient_one['r'], $foreground_gradient_one['g'], $foreground_gradient_one['b'], $foreground_gradient_two['r'], $foreground_gradient_two['g'], $foreground_gradient_two['b'], $settings->foreground_gradient_style);
                    break;
            }

            // Background 
            switch ($settings->background_type) {

                case 'color':
                    $background_color = hex_to_rgb($settings->background_color);
                    $qr->backgroundColor($background_color['r'], $background_color['g'], $background_color['b'], 100 - $settings->background_color_transparency);

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

            if ($qrCodeData['qr_code_logo']) {

                $logo_width_percentage = 26;

                /* Start doing custom changes to the output SVG */
                $custom_svg_object = SVG::fromString($svg);
                $custom_svg_doc = $custom_svg_object->getDocument();

                $qr_code_logo_link =  "uploads/qr_codes/logo/" . $qrCodeData['qr_code_logo'];
                $qr_code_logo_extension = explode('.', $qrCodeData['qr_code_logo']);
                $qr_code_logo_extension = mb_strtolower(end($qr_code_logo_extension));


                if ($qr_code_logo_extension == 'png' && $settings->background_type == 'color') {

                    $src = imagecreatefromstring(file_get_contents($qr_code_logo_link));
                    $src_w = imagesx($src);
                    $src_h = imagesy($src);
                    $dest_w = $src_w;
                    $dest_h = $src_h;
                    $dest = imagecreatetruecolor($dest_w, $dest_h);

                    $background_color = hex_to_rgb($settings->background_color);
                    $background_color = imagecolorallocate($dest,  $background_color['r'], $background_color['g'], $background_color['b']);
                    imagefill($dest, 0, 0, $background_color);
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
                $logo_ratio = $logo_height / $logo_width;

                if ($logo_ratio > 1.5) {
                    $logo_new_width = $settings->size * 18 / 100;
                } else {
                    $logo_new_width = $settings->size * $logo_width_percentage / 100;
                }
                $logo_new_height = $logo_new_width * $logo_ratio;

                /* Calculate center of the QR code */
                $logo_x = $settings->size / 2 - $logo_new_width / 2;
                $logo_y = $settings->size / 2 - $logo_new_height / 2;

                /* Add the logo to the QR code */
                $logo = new SVGImage($logo_base64, $logo_x, $logo_y, $logo_new_width, $logo_new_height);

                $custom_svg_doc->addChild($logo);

                /* Export the QR code with the logo on top */
                $svg = $custom_svg_object->toXMLString();
            }




            if ($settings->background_type == 'gradient') {

                $backgound_gradient_style = $settings->backgound_gradient_style;
                $one = $settings->background_gradient_one;
                $two = $settings->background_gradient_two;


                if ($backgound_gradient_style == 'linear') {

                    $gradiant_object = '<svg width="500" height="500" version="1.1" viewBox="0 0 500 500" xmlns="http://www.w3.org/2000/svg">            
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
                    <rect id="rect1" x="0" y="0" width="500" height="500"/>     
              
              </svg>';
                } else {
                    $gradiant_object = '<svg width="500" height="500" version="1.1" viewBox="0 0 500 500" xmlns="http://www.w3.org/2000/svg">            
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
                  width="500"
                  height="500"
                  fill="url(#backGradient)" />
              
              </svg>';
                }

                $custom_svg_object = SVG::fromString($gradiant_object);
                $custom_svg_doc = $custom_svg_object->getDocument();

                $gradiant_object = new SVGImage('data:image/svg+xml;base64,' . base64_encode($svg), 0, 0, 500, 500);
                $custom_svg_doc->addChild($gradiant_object);
                $svg = $custom_svg_object->toXMLString();
            }

            //QR code dynamic frame code
            $qr_frame_parameter_array = [
                '1' => [35, 30, 250, 250],
                '2' => [35, 30, 250, 250],
                '3' => [35, 30, 250, 250],
                '4' => [35, 30, 250, 250], //
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
            if ($settings->qr_frame_id) {
                $qr_frame_id = $settings->qr_frame_id;
                $frame1 = file_get_contents($settings->qr_frame_path);
                $frame_svg_object = SVG::fromString($frame1);
                $frame_svg_doc = $frame_svg_object->getDocument();
                $frame_data = new SVGImage('data:image/svg+xml;base64,' . base64_encode($svg), $qr_frame_parameter_array[$qr_frame_id][0], $qr_frame_parameter_array[$qr_frame_id][1], $qr_frame_parameter_array[$qr_frame_id][2], $qr_frame_parameter_array[$qr_frame_id][3]);
                $frame_svg_doc->addChild($frame_data);
                $svg = $frame_svg_object->toXMLString();

                $svg = $this->changeFrameText($svg, $settings->frame_text);

                $svg = $this->changeTextColor($svg, $settings->qr_text_color);

                $svg = $this->qrFrameFontSize($svg, $settings->qr_frame_font_size);

                $svg = $this->frameTextYPosition($svg, $settings->frame_text_y_position);

                if (($settings->frame_color_type ?? '') == 'gradient') {

                    $svg = $this->changeFrameGradientColor($svg, $settings->frame_gradient_one, $settings->frame_gradient_two, $settings->frame_gradient_style);

                    $rgb = $this->HTMLToRGB($settings->frame_gradient_one);
                    $hsl = $this->RGBToHSL($rgb);
                    if ($hsl->lightness > 150) {
                        $svg = str_replace('.text-color{fill:#FFF;}', '.text-color{fill:#000;}', $svg);
                    }
                } else {

                    $svg = $this->changeFrameColor($svg, $settings->frame_color);

                    $rgb = $this->HTMLToRGB($settings->frame_color);
                    $hsl = $this->RGBToHSL($rgb);
                    if ($hsl->lightness > 150) {
                        $svg = str_replace('.text-color{fill:#FFF;}', '.text-color{fill:#000;}', $svg);
                    }
                }

                if (!empty($settings->frame_background_color_type) && $settings->frame_background_color_type == 'gradient') {

                    $svg = $this->changeFrameBackgroundGradientColor($svg, $settings->frame_background_gradient_one, $settings->frame_background_gradient_two, $settings->frame_background_gradient_style);
                    $rgb = $this->HTMLToRGB($settings->frame_background_gradient_one);
                    $hsl = $this->RGBToHSL($rgb);
                    if ($hsl->lightness < 150) {
                        $svg = str_replace('.text-color-dark{fill:#000;}', '.text-color{fill:#FFF;}', $svg);
                    }
                } else {
                    $svg = $this->changeFrameBackgroundColor(
                        $svg,
                        $settings->frame_background_color,
                        !empty($settings->frame_background_color_transparency) && $settings->frame_background_color_transparency ? true : false
                    );

                    $rgb = $this->HTMLToRGB($settings->frame_background_color);
                    $hsl = $this->RGBToHSL($rgb);
                    if ($hsl->lightness < 150) {
                        $svg = str_replace('.text-color-dark{fill:#000;}', '.text-color{fill:#FFF;}', $svg);
                    }
                }
            }

            file_put_contents(UPLOADS_PATH . 'qr_codes/logo' . '/' . $image_new_name, $svg);

            $query = "INSERT INTO qr_codes (`uId`,`data`,`link_id`,`user_id`,`project_id`,`name`,`type`,`qr_code_logo`,`qr_code`,`settings`,`status`,`datetime`,`last_datetime`,`updated_at`) SELECT '{$uId}',`data`,`link_id`,`user_id`,`project_id`,`name`,`type`,`qr_code_logo`,'{$image_new_name}',`settings`,`status`,'{$today}',`last_datetime`,`updated_at` FROM qr_codes WHERE `qr_code_id` = $qr_code_id  AND `user_id` = $user_id";
            $hello = database()->query($query);
            $last_id = database()->insert_id;


            $response = ['result' => 'success', 'data' => ['message' => 'Duplicate Qr Code created successfully!', 'last_id' => $last_id, 'query' => $query]];
        } else {
            $response = ['result' => 'failed', 'data' => ['message' => 'Something went wrong!!']];
        }

        return Response::jsonapi_success($response, null, 200);
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
            // $svg = str_replace('style="fill: #000; fill-opacity: 0.5"', 'style="fill: url(#linear); fill-opacity: 0.5"', $svg);
        } else {
            $svg = str_replace('GRC1', $one, $svg);

            $svg = str_replace('GRC2', $two, $svg);
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
            return  str_replace('.white-area{fill:#FFF;}', '.white-area{fill:#ffffff80;}', $svg);
        } else {
            return str_replace('.white-area{fill:#FFF;}', '.white-area{fill:' . $color . ';}', $svg);
        }
    }


    private function folderListing()
    {
        $user_id = $_POST['user_id'];

        /* Existing projects */
        $projects = (new \Altum\Models\Projects())->get_projects_by_user_id($user_id);

        $projects = (new \Altum\Models\Projects())->get_projects_by_user_id($user_id);

        $data = [
            'projects' => $projects,
        ];
        $html = (new \Altum\Views\View('qr-codes/folder_listing', $data))->run($data);
        $send_to_folder_list = (new \Altum\Views\View('qr-codes/send_to_folder_listing', $data))->run($data);
        $response['html'] = $html;
        $response['send_to_folder_list'] = $send_to_folder_list;

        return Response::jsonapi_success($response, null, 200);
    }


    private function assignFolderToQrcode()
    {

        if (!empty($_POST['qrCodeIdArr']) && !empty($_POST['user_id']) && isset($_POST['folder_id']) && $_POST['folder_id'] != '') {

            // $qr_code_id = $_POST['qr_code_id'];
            $user_id = $_POST['user_id'];
            $folder_id = ($_POST['folder_id'] == '' || $_POST['folder_id'] == '0' || $_POST['folder_id'] == null) ? null : $_POST['folder_id'];
            $qr_code_id_in = $this->makeInStr($_POST['qrCodeIdArr']);

            if ($folder_id == null) {
                $query = "UPDATE `qr_codes` SET `project_id` = null WHERE `user_id` = $user_id AND `qr_code_id` IN ($qr_code_id_in)";
            } else {
                $query = "UPDATE `qr_codes` SET `project_id` = $folder_id WHERE `user_id` = $user_id AND `qr_code_id` IN ($qr_code_id_in)";
            }
            $qr_code = database()->query($query);
            $affected_rows = database()->affected_rows;
            $response = ['result' => 'success', 'data' => ['message' => 'Qr Code send to successfully!', 'affected_rows' => $affected_rows, '$query' => 'stopeddddd$query']];
        } else {
            $response = ['result' => 'failed', 'data' => ['message' => 'Something went wrong!!']];
        }

        return Response::jsonapi_success($response, null, 200);
    }
    private function makeQrcodeStatusPaused()
    {

        if (!empty($_POST['qrCodeIdArr']) && !empty($_POST['user_id'])) {

            // $qr_code_id = $_POST['qr_code_id'];
            $user_id = $_POST['user_id'];
            $qr_code_id_in = $this->makeInStr($_POST['qrCodeIdArr']);

            $query = "UPDATE `qr_codes` SET `status` = '2' WHERE `user_id` = $user_id AND `qr_code_id` IN ($qr_code_id_in)";
            $qr_code = database()->query($query);
            $affected_rows = database()->affected_rows;
            $response = ['result' => 'success', 'data' => ['message' => 'Qr Code paused successfully!', 'affected_rows' => $affected_rows, '$query' => 'stopeddddd$query']];
        } else {
            $response = ['result' => 'failed', 'data' => ['message' => 'Something went wrong!!']];
        }

        return Response::jsonapi_success($response, null, 200);
    }
    private function makeQrcodeStatusDeleted()
    {

        if (!empty($_POST['qrCodeIdArr']) && !empty($_POST['user_id'])) {

            // $qr_code_id = $_POST['qr_code_id'];
            $user_id = $_POST['user_id'];
            $qr_code_id_in = $this->makeInStr($_POST['qrCodeIdArr']);

            $query = "UPDATE `qr_codes` SET `status` = '3' WHERE `user_id` = $user_id AND `qr_code_id` IN ($qr_code_id_in)";
            $qr_code = database()->query($query);
            $affected_rows = database()->affected_rows;
            $response = ['result' => 'success', 'data' => ['message' => 'Qr Code soft Deleted successfully!', 'affected_rows' => $affected_rows, '$query' => 'stopeddddd$query']];
        } else {
            $response = ['result' => 'failed', 'data' => ['message' => 'Something went wrong!!']];
        }

        return Response::jsonapi_success($response, null, 200);
    }
    private function makeQrcodeStatusActice()
    {

        if (!empty($_POST['qrCodeIdArr']) && !empty($_POST['user_id'])) {

            // $qr_code_id = $_POST['qr_code_id'];
            $user_id = $_POST['user_id'];
            $qr_code_id_in = $this->makeInStr($_POST['qrCodeIdArr']);

            $query = "UPDATE `qr_codes` SET `status` = '1' WHERE `user_id` = $user_id AND `qr_code_id` IN ($qr_code_id_in)";
            $qr_code = database()->query($query);
            $affected_rows = database()->affected_rows;
            $response = ['result' => 'success', 'data' => ['message' => 'Qr Code resumed successfully!', 'affected_rows' => $affected_rows, '$query' => 'stopeddddd$query']];
        } else {
            $response = ['result' => 'failed', 'data' => ['message' => 'Something went wrong!!']];
        }

        return Response::jsonapi_success($response, null, 200);
    }
    private function qrCodeHardDelete()
    {

        if (!empty($_POST['qrCodeIdArr']) && !empty($_POST['user_id'])) {

            // $qr_code_id = $_POST['qr_code_id'];
            $user_id = $_POST['user_id'];
            $qr_code_id_in = $this->makeInStr($_POST['qrCodeIdArr']);

            $query = "DELETE FROM `qr_codes` WHERE `user_id` = $user_id AND `qr_code_id` IN ($qr_code_id_in)";
            $qr_code = database()->query($query);
            $affected_rows = database()->affected_rows;
            $response = ['result' => 'success', 'data' => ['message' => 'Qr Code hard deleted successfully!', 'affected_rows' => $affected_rows, '$query' => 'stopeddddd$query']];
        } else {
            $response = ['result' => 'failed', 'data' => ['message' => 'Something went wrong!!']];
        }

        return Response::jsonapi_success($response, null, 200);
    }
    private function resetScan()
    {

        if (!empty($_POST['qrCodeIdArr']) && !empty($_POST['user_id'])) {

            // $qr_code_id = $_POST['qr_code_id'];
            $user_id = $_POST['user_id'];
            $qr_code_id_in = $this->makeInStr($_POST['qrCodeIdArr']);

            $query = "DELETE FROM `qrscan_statistics` WHERE `qr_code_id` IN ($qr_code_id_in)";
            $qr_code = database()->query($query);
            $affected_rows = database()->affected_rows;
            $response = ['result' => 'success', 'data' => ['message' => 'Qr Code scan deleted successfully!', 'affected_rows' => $affected_rows, '$query' => 'stopeddddd$query']];
        } else {
            $response = ['result' => 'failed', 'data' => ['message' => 'Something went wrong!!']];
        }

        return Response::jsonapi_success($response, null, 200);
    }

    public function saveCampaign()
    {
        if (!empty($_POST['campaign_id'])) {
            $insertData = [
                'qr_code_id' => $_POST['qr_code_id'],
                'user_id' => $_POST['user_id'],
                'medium' => $_POST['medium'],
                'print_run' => $_POST['print_run'] ? $_POST['print_run'] : null,
                'start_date' => $_POST['start_date'] ? (new \DateTime($_POST['start_date']))->format('Y-m-d') : null,
                'end_date' => $_POST['end_date'] ?  (new \DateTime($_POST['end_date']))->format('Y-m-d') : null,
                'updated_at' => date("Y-m-d H:i:s"),
            ];
            $project_id = db()->where('id', $_POST['campaign_id'])->where('user_id', $_POST['user_id'])
                ->update('campaign_informations', $insertData);
            $campaign_id = $_POST['campaign_id'];
        } else {
            $insertData = [
                'qr_code_id' => $_POST['qr_code_id'],
                'user_id' => $_POST['user_id'],
                'medium' => $_POST['medium'],
                'print_run' => $_POST['print_run'] ? $_POST['print_run'] : null,
                'start_date' => $_POST['start_date'] ? (new \DateTime($_POST['start_date']))->format('Y-m-d') : null,
                'end_date' => $_POST['end_date'] ? (new \DateTime($_POST['end_date']))->format('Y-m-d') : null,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ];
            $campaign_id = db()->insert('campaign_informations', $insertData);
        }

        $data = [
            'result' => 'success',
            'data' => [
                'insertData' => $insertData,
                'campaign_id' => $campaign_id,
            ],
        ];

        return Response::jsonapi_success($data, null, 200);
    }



    public function ajax_content()
    {
        $step                 = isset($_REQUEST['step']) ? $_REQUEST['step'] : 1;
        $type                 = isset($_REQUEST['type']) ? $_REQUEST['type'] : ''; //qr type
        $userId               = isset($_REQUEST['userId']) ? $_REQUEST['userId'] : 'url'; //user id
        $qr_code              = isset($_REQUEST['qr_code']) ? $_REQUEST['qr_code'] : ''; //qr_code
        $qr_code_id           = isset($_REQUEST['qr_code_id']) ? $_REQUEST['qr_code_id'] : ''; //qr_code
        $qr_code_settings     = require APP_PATH . 'includes/qr_code.php';
        $onboarding_funnel    = isset($_REQUEST['onboarding_funnel']) ? $_REQUEST['onboarding_funnel'] : ''; //qr_code

        if (!isset($_SESSION['qrCodeUid'])) {
            $_SESSION['qrCodeUid'] = uniqid();
        }
        $qrCodeUid = $_SESSION['qrCodeUid'];

        $response = '';

        $folderRawQuery = "SELECT * FROM `projects` where `user_id` = {$userId}";
        $folderQuery = database()->query($folderRawQuery);
        $folders = $folderQuery->fetch_all(MYSQLI_ASSOC);
        if ($qr_code_id != "") {
            $rawQuery = "SELECT * FROM `qr_codes` WHERE qr_code_id = '$qr_code_id'";
            $query = database()->query($rawQuery);
            $qr_code = $query->fetch_all(MYSQLI_ASSOC);

            $folderIdRawQuery = "SELECT `project_id` FROM `qr_codes` WHERE qr_code_id = '$qr_code_id'";
            $folderIdQuery = database()->query($folderIdRawQuery);
            $folderId = $folderIdQuery->fetch_all(MYSQLI_ASSOC);

            $qr_data = json_decode($qr_code[0]['data'], true);
            $qrCodeId  = $qr_code[0]['uId'];

            $adata = [
                'qr_code' => isset($qr_code) ? $qr_code : array(),
                'qr_code_settings' => $qr_code_settings,
                'user_id' => $userId,
                'folders' => $folders,
                'folderId' => $folderId,
                'status' => isset($qr_code->status) ? $qr_code->status : null,
            ];
        } else {
            $adata = [
                'qr_code' => array(),
                'qr_code_settings' => $qr_code_settings,
                'user_id' => $userId,
                'folders' => $folders,
                'status' => '1',
            ];
        }

        if ($type != '') {
            $viewform = (new \Altum\Views\View('qr/partials/' . $type . '_form', $adata))->run($adata);
            $viewcontent = (new \Altum\Views\View('qr/partials/' . $type . '_content', $adata))->run($adata);
        } else {
            $viewform = '';
            $viewcontent = '';
        }


        $response = "";

        if ($step == 1) {

            $response .=  "
                
                <div class=\"jss1458 steps-setpad qr-steps-wrap\" id=\"step1\" style=\"display:block;\">
                <input type=\"hidden\" id=\"qrCodeUid\" name=\"qrCodeUid\" value=\"" .  $qrCodeUid . "\" />
                            <div class=\"question-container \">
                                <div class=\"radio-btn-group row\">";
            foreach ($qr_code_settings['type'] as $key => $value) {
                $response .= "<div class=\"create-card col-lg-3 col-md-4 col-sm-6 col-12 qr-card qr-card-order-$key\" data-toggle=\"tooltip\" ";
                $response .=  'title="' .  l('qr_step_1.type.' . $key . '_description') . '"' . '>';
                $response .= "<button type=\"button\" class=\"qr-card-btn\">
                                                    <div class=\"input-container jss1486 jss1459\">
                                                            <div class=\" qr-card-img-wrap\">
                                                                <img src=\"" . $value['image'] . "\" alt=\"\" width=\"80\" height=\"80\" >
                                                            </div>
                                                            <input class=\"radio-button label-checker change-setp-2\" data-qr_type=\"" . ucfirst($key) . "\" type=\"radio\" name=\"radio\" value=\"" . $key . "\" onclick=\"changeUrl('" . url('qr/' . $key) . "', this), change_step(2)\" " . ($type == $key ? 'checked' : null) . " />
                                                            <div class=\"card-text-wrap\">
                                                                <span class=\"icon car-icon\">
                                                                " . l('qr_step_1.type.' . $key) . "
                                                                </span>
                                                                <span class=\"desc\"> " . l('qr_step_1.type.' . $key . '_description') . " </span>
                                                            </div>
                                                            <div class=\"card-icon-wrap\">
                                                                <span class=\"icon-arrow-h-right\"></span>
                                                            </div>
                                                    </div>
                                            </button>
                                        </div>";
            }
            $response .= "</div>
                        </div>
                    </div>";
        } else if ($step == 2) {
            $response .= "
                <div class=\"jss1452 steps-setpad qr-step-2-wrap\" id=\"step2\">
                    <div class=\"card\" style=\"background-color: transparent;\">
                        <div class=\"card-body steps-ped\">                        
                            <form action=\"" . (($qr_code_id != "" && $qr_code_id != null) ? url('qr-code-update/' . $qr_code_id) : url('qr-codes')) . "\" id=\"myform\" method=\"post\" role=\"form\" enctype=\"multipart/form-data\" novalidate>
                                <input type=\"hidden\" name=\"token\" value=\"" . \Altum\Middlewares\Csrf::get() . "\" />                              
                                <input type=\"hidden\" name=\"userIdAjax\" value=\"" . trim($userId) . "\" />
                                <input type=\"hidden\" name=\"qrIdAjax\" value=\"" . trim($qr_code_id) . "\" />
                                <input type=\"hidden\" name=\"type\" value=\"" . trim($type) . "\" />
                                <input type=\"hidden\" id=\"current_state\" name=\"current_state\" value=\"" . (($qr_code_id != "" && $qr_code_id != null) ? 'edit' : 'create') . "\" />
                                <input type=\"hidden\" name=\"uId\" id=\"uId\" value=\"" . (($qr_code_id != "" && $qr_code_id != null) ? $qrCodeId :   $qrCodeUid) . "\" data-reload-qr-code  />

                                <input type=\"hidden\" name=\"reload\" value=\"\" data-reload-qr-code />";
            if ($userId != "") {
                $qr_code_value = '';

                if (isset($qr_code) && is_array($qr_code)) {
                    foreach ($qr_code as $code) {
                        if (!is_array($code)) {
                            $qr_code_value .= $code;
                        }
                    }
                }

                $response .= "<input type=\"hidden\" name=\"qr_code\" value=\"" . $qr_code_value . "\" />";
            }
            // $html = (new \Altum\Views\View('qr/qr-cards', $data))->run($data);     

            $response .= "  <div class=\"notification-container\"></div> " .  $viewform . "

                                <div id=\"step3\">
                                <input type=\"hidden\"  style=\"visibility: hidden; height:0; appearance:none;\" name=\"qr_frame_path\" id=\"qr_frame_path\" value=\"" . (($qr_code_id != "" && $qr_code_id != null) ? $qr_data['qr_frame_path'] : '') . "\" />

                                <input type=\"hidden\"  style=\"visibility: hidden; height:0; appearance:none;\" name=\"qr_frame_id\" id=\"qr_frame_id\" value=\"" . (($qr_code_id != "" && $qr_code_id != null) ? $qr_data['qr_frame_id'] : '0') . "\" data-reload-qr-code />

                                <input type=\"radio\" style=\"visibility: hidden; height:0; appearance:none; position:absolute; z-index:-99;\" name=\"qr_frame_path_tmp\" id=\"qr_frame_path_tmp\" data-reload-qr-code  " . (($qr_code_id != "" && $qr_code_id != null) ? (isset($qr_data['qr_frame_path_tmp']) ? ($qr_data['qr_frame_path_tmp'] == $i ? 'checked' : '') : '') : '') . " />

                                <input type=\"radio\" style=\"visibility: hidden; height:0; appearance:none; position:absolute; z-index:-99;\" name=\"qr_frame_path_tmp\" id=\"qr_frame_id_tmp\" data-reload-qr-code />
                                    
                                <div class=\"custom-accodian\">
                                        <button class=\"btn accodianBtn collapsed\" type=\"button\" data-toggle=\"collapse\" data-target=\"#acc_frame\" aria-expanded=\"true\" aria-controls=\"acc_frame\">
                                            <span class=\"icon-frame title-icon\"></span>

                                            <span class=\"title-wrp d-flex flex-column align-items-start \">"
                . l('qr_step_3.frame') . "
                                                <span class=\"fields-helper-heading\">" . l('qr_step_3.frame.help_txt') . "</span>
                                            </span>

                                            <div class=\"icon-wrp\">
                                            <span class=\"icon-arrow-h-right\"></span>
                                            </div>
                                        </button>

                                        <div class=\"collapse collapse-wrp \" id=\"acc_frame\">
                                        <hr class=\"acc-separator mt-0\">
                                            <div class=\"collapseInner\">
                                            <span class=\"title-wrp pl-15\">" . l('qr_step_3.frame_style') . "</span>

                                            <div class=\"frameWrapper customScrollbar mb-1\">
                                                <div class=\"  mb-1\">

                                                    <div id=\"slider4\" class=\"text-center pb-2 frameSlide\">
                                                        <button style=\"color:#000000;\" type=\"button\" id=\"qr_frame_id_0\" class=\"qr_frame_button " . ((($qr_code_id != "" && $qr_code_id != null) && $qr_data['qr_frame_id'] == 0) ? 'active' : (($qr_code_id == "" || $qr_code_id == null) ? 'active' : '')) . "\"  data-qrframeid=\"0\" onclick=\"getQRFromUrl(this);\" data-reload-qr-code>
                                                            <svg class=\"MuiSvgIcon-root\" stroke=\"#000000\" fill=\"#000000\" focusable=\"false\" viewBox=\"0 0 32 32\" aria-hidden=\"true\">
                                                                <path d=\"M16 0c8.837 0 16 7.163 16 16s-7.163 16-16 16c-8.837 0-16-7.163-16-16s7.163-16 16-16zM1.778 16c0 7.855 6.367 14.222 14.222 14.222 3.603 0 6.894-1.34 9.4-3.549l-20.017-20.136c-2.242 2.514-3.605 5.829-3.605 9.463zM16 1.778c-3.582 0-6.854 1.324-9.355 3.509l20.012 20.131c2.218-2.508 3.565-5.806 3.565-9.418 0-7.855-6.367-14.222-14.222-14.222z\"></path>
                                                            </svg>
                                                            <span></span>
                                                        </button>";
            for ($i = 1; $i < 16; $i++) {
                $response .= "<button type=\"button\" id=\"qr_frame_id_" . $i . "\" class=\"qr_frame_button " . ((($qr_code_id != "" && $qr_code_id != null) && $qr_data['qr_frame_id'] == $i) ? 'active' : '') . "\" data-qrframeid=\"" . trim($i) . "\" data-qrframeurl=\"" . ASSETS_FULL_URL . 'images/qrframe/Asset' . $i . '.svg' . "\" onclick=\"getQRFromUrl(this);\" data-reload-qr-code>
                                                                <div class=\"qr_frame_button_img\"> <img src='" . ASSETS_FULL_URL . "images/qrframe/" . $i . ".svg' /><span></span></div>
                                                                                                                                                                </button>";
            }
            $response .= "
                                                    </div>

                                                </div>
                                                <div class=\" mb-1\">
                                                    <div id=\"slider5\" class=\"text-center pb-2 frameSlide\">";
            for ($j = 16; $j < 32; $j++) {
                $response .= " <button type=\"button\" id=\"qr_frame_id_" . $j . "\" class=\"qr_frame_button " . ((($qr_code_id != "" && $qr_code_id != null) && $qr_data['qr_frame_id'] == $j) ? 'active' : '') . "\" data-qrframeid=\"" . $j . "\" data-qrframeurl=\"" . ASSETS_FULL_URL . 'images/qrframe/Asset' . $j . '.svg' . "\" onclick=\"getQRFromUrl(this);\" data-reload-qr-code>
                                                            <div class=\"qr_frame_button_img\"> <img src='" . ASSETS_FULL_URL . "images/qrframe/" . $j . ".svg' /><span></span></div>
                                                                                                                                                        </button>";
            }
            $response .= "
                                                </div>
                                                </div>
                                            </div>

                                           
                                         
                                                <div id=\"newpost\" class=\"bg-container set-w-bg frame-style-wrp\" style=\"display: " . ((($qr_code_id != "" && $qr_code_id != null) && $qr_data['qr_frame_path']) ? 'block' : 'none') . ";\">
                                                    <div>
                                                        <div class=\"custom-block p-x4\">
                                                            <p class=\"bg-head mb-2\">" . l('qr_step_3.text') . "</p>
                                                            <div class=\"w-100\">
                                                                <div class=\"w-100 MuiFormControl-root MuiTextField-root jss1148 jss1149 MuiFormControl-fullWidth\">
                                                                    <div
                                                                        class=\"w-100 MuiInputBase-root MuiInput-root MuiInputBase-fullWidth MuiInput-fullWidth MuiInputBase-formControl MuiInput-formControl MuiInputBase-adornedEnd\">
                                                                        <input id=\"qrFrameText\" aria-invalid=\"false\" name=\"frame_text\" placeholder=\"\" type=\"text\" maxlength=\"30\"
                                                                            class=\"MuiInputBase-input MuiInput-input MuiInputBase-inputAdornedEnd step-form-control qr-frame-text-field\" value=\"" . (($qr_code_id != "" && $qr_code_id != null) ? $qr_data['frame_text'] : 'Scan me!') . "\" data-reload-qr-code/>
                                                                        <input type=\"hidden\" id=\"qrFrameFontSize\" name=\"qr_frame_font_size\" value=\"" . (($qr_code_id != "" && $qr_code_id != null) ? (isset($qr_data['qr_frame_font_size']) ? $qr_data['qr_frame_font_size'] : '42px') : '42px') . "\" defaultFontSize=\"42px\" data-reload-qr-code/>
                                                                        <span id=\"qrFrameTextSpan\" style=\"width: auto; display: inline-block; position: absolute; top: 60px; visibility: hidden\"></span>
                                                                        <input type=\"hidden\" id=\"frameTextYPosition\" name=\"frame_text_y_position\" value=\"" . (($qr_code_id != "" && $qr_code_id != null) ? (isset($qr_data['frame_text_y_position']) ? $qr_data['frame_text_y_position'] : '0') : '0') . "\" deftextYPosition=\"0\" data-reload-qr-code/>
                                                                        <input type=\"hidden\" id=\"UppercaseDecValue\" name=\"UppercaseDecValue\" value=\"" . (($qr_code_id != "" && $qr_code_id != null) ? (isset($qr_data['UppercaseDecValue']) ? $qr_data['UppercaseDecValue'] : '0') : '0') . "\" data-reload-qr-code/>
                                                                        <input type=\"hidden\" id=\"decValue\" name=\"decValue[]\" value=\"" . (($qr_code_id != "" && $qr_code_id != null) ? $qr_data['decValue'][0] : "12, 15, 18, 20, 21, 22, 23, 24, 25, 27") . "\" data-reload-qr-code/>
                                                                        <div class=\"frame-color-text-wrap\">
                                                                            <label for=\"primaryColor\">
                                                                                <input id=\"frameTextColor\" readonly name=\"qr_text_color\" onchange=\"LoadPreview()\" class=\"frame-text-color custompicker-coloris frame-text-color-input pickerField\" type=\"text\" value=\"" . (($qr_code_id != "" && $qr_code_id != null) ? $qr_data['qr_text_color'] : '') . "\" 
                                                                                style=\"background-color:" . (($qr_code_id != "" && $qr_code_id != null) ? $qr_data['qr_text_color'] : '') . ";\"
                                                                                data-reload-qr-code />
                                                                                <span class=\"icon-edit grey step-edit-icon \"></span>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <div  style=\"max-width: 700px; display:none;\">
                                                                    <div style=\"display: inline-block; white-space: nowrap; font-size: 90px;\">fdgsdf gsdf gsdfg sfdg</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class=\"custom-block frame-color-wrp\">
                                                        <div class=\"\" >
                                                                <p class=\"bg-head pl-0 mb-0\">" . l('qr_step_3.frame_color') . "</p>
                                                                <div class=\"row p-x4 frame-fields-wrap\" >
                                                                    <div class=\"col-md-8 mb-3 frame-custom-switch-container\">
                                                                    
                                                                        <div class=\" custom-switch-wrp\">
                                                                            <div class=\"custom-control custom-switch \">
                                                                                <span class=\"custom-switch-text\">" . l('qr_step_3.use_gradients_for_fr') . "</span>
                                                                                <input type=\"checkbox\" class=\"custom-control-input\" name=\"frame_color_type\" id=\"isFrameGradient\" value=\"gradient\" data-reload-qr-code " . (($qr_code_id != "" && $qr_code_id != null && isset($qr_data['frame_color_type']) ?  $qr_data['frame_color_type'] == 'gradient' : null) ?  'checked' : '') . ">
                                                                                <label class=\"custom-control-label qr-custom-switch fieldLabel\" for=\"isFrameGradient\">
                                                                                </label>
                                                                            </div>
                                                                        </div> 
                                                                    </div>
                                                              
                                                                    <div class=\"col-md-4 frame-border-color picker-wrap-main\">
                                                                        <div class=\"single-frame-color-wrp\">
                                                                        <div class=\"form-group m-0\">
                                                                        
                                                               
                                                                        <label class=\"field-label\" for=\"\">" . l('qr_step_3.frame_color') . "</label>
                                                                        
                                                                        <div class=\"customColorPicker\">
                                                                        
                                                                        <label for=\"frame_color\" class=\"label-with-icon\">
                                                                        
                                                                                        <input type=\"text\" name=\"FrameColorInput\" class=\"FrameColorInput iconColorPiker st3cv\" id=\"FrameColorInput\" value=\"" . (($qr_code_id != "" && $qr_code_id != null) ?  $qr_data['frame_color'] : '#000000') . "\" style=\"text-transform:uppercase; border: hidden; font-size:15px; width: 105px;\" maxlength=\"7\" placeholder=\"#000000\" data-reload-qr-code color_validate />
                                                                                        <input data-coloris56 id=\"FrameColor\" name=\"frame_color\" class=\"pickerField custompicker-coloris edit-icon-input black\" type=\"text\" value=\"" . (($qr_code_id != "" && $qr_code_id != null) ?  $qr_data['frame_color'] : '#000000') . "\"
                                                                                        style=\"background-color:" . (($qr_code_id != "" && $qr_code_id != null) ?  $qr_data['frame_color'] : '#000000') . ";\" data-reload-qr-code />

                                                                                        <span class=\"icon-edit grey step-edit-icon \"></span>

                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class=\"frame-grad-dropdown grad-picker grad-select\" style=\"display: none;\">
                                                                            <div class=\"form-group m-0\">
                                                                                <label for=\"filters_cities_by\" class=\"fieldLabel ml-1\">" . l('qr_step_3.gradient') . "</label>
                                                                                <div class=\"custom-drop-wrp\">
                                                                                    <select id=\"foreground_gradient_style\" name=\"frame_gradient_style\" class=\"form-control \" data-reload-qr-code>
                                                                                    <option value=\"linear\" " . (($qr_code_id != "" && $qr_code_id != null) ? (($qr_data['frame_gradient_style'] == 'linear') ? 'selected' : '') : '') . ">Linear</option>
                                                                                    <option value=\"radial\" " . (($qr_code_id != "" && $qr_code_id != null) ? (($qr_data['frame_gradient_style'] == 'radial') ? 'selected' : '') : '') . ">Radial</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class=\"row w-100 frame-border-colour-container grid-3l  \" style=\"display: none;\">
                                                                        <div class=\"col-md-6 grad-picker\">
                                                                            <div class=\"form-group m-0\">
                                                                                <label class=\"field-label\" for=\"\">" . l('qr_step_3.frame_color_1') . "</label>
                                                                                <div class=\"customColorPicker\">                        
                
                                                                                    <label for=\"foreground_gradient_one\" class=\"label-with-icon\">
                                                                                        <input type=\"text\" name=\"FrameColorFirstInput\" class=\"FrameColorFirstInput iconColorPiker st3cv\" id=\"FrameColorFirstInput\" value=\"" . (($qr_code_id != "" && $qr_code_id != null) ? (isset($qr_data['frame_color_type']) ?  ($qr_data['frame_color_type'] == 'gradient' ? $qr_data['frame_gradient_one'] : '#000000') : '#000000') : '#000000') . "\" style=\"text-transform:uppercase; border: hidden; font-size:15px; width: 105px;\" maxlength=\"7\" placeholder=\"#000000\"
                                                                                        data-reload-qr-code color_validate />
                                                                                        <input id=\"FrameColorFirst\" name=\"frame_gradient_one\" class=\"pickerField custompicker-coloris edit-icon-input white\" type=\"text\" value=\"" . (($qr_code_id != "" && $qr_code_id != null) ? (isset($qr_data['frame_color_type']) ?  ($qr_data['frame_color_type'] == 'gradient' ? $qr_data['frame_gradient_one'] : '#000000') : '#000000') : '#000000') . "\" 
                                                                                        style=\"background-color:" . (($qr_code_id != "" && $qr_code_id != null) ? (isset($qr_data['frame_color_type']) ?  ($qr_data['frame_color_type'] == 'gradient' ? $qr_data['frame_gradient_one'] : '#000000') : '#000000') : '#000000') . ";\" data-reload-qr-code />
                                                                                        <span class=\"icon-edit grey step-edit-icon \"></span>
                                                                                    </label>
                
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class=\"col-md-6 grad-picker\">
                                                                            <div class=\"form-group m-0\">
                                                                            <label class=\"field-label\" for=\"\">" . l('qr_step_3.frame_color_2') . "</label>
                                                                                <div class=\"customColorPicker\">
                
                                                                                    
                                                                                <label for=\"frame_gradient_two\" class=\"label-with-icon\">
                                                                                    <input type=\"text\" name=\"FrameColorSecondInput\" class=\"FrameColorSecondInput iconColorPiker st3cv\" id=\"FrameColorSecondInput\" value=\"" . (($qr_code_id != "" && $qr_code_id != null) ? (isset($qr_data['frame_color_type']) ?  ($qr_data['frame_color_type'] == 'gradient' ? $qr_data['frame_gradient_two'] : '#2f6bfd') : '#2f6bfd') : '#2f6bfd') . "\" style=\"text-transform:uppercase; border: hidden; font-size:15px; width: 105px;\" maxlength=\"7\" placeholder=\"#000000\" data-reload-qr-code color_validate />
                                                                                    <input id=\"FrameColorSecond\" name=\"frame_gradient_two\"  class=\"pickerField custompicker-coloris edit-icon-input white\" type=\"text\" value=\"" . (($qr_code_id != "" && $qr_code_id != null) ? (isset($qr_data['frame_color_type']) ?  ($qr_data['frame_color_type'] == 'gradient' ? $qr_data['frame_gradient_two'] : '#2f6bfd') : '#2f6bfd') : '#2f6bfd') . "\" 
                                                                                    style=\"background-color:" . (($qr_code_id != "" && $qr_code_id != null) ? (isset($qr_data['frame_color_type']) ?  ($qr_data['frame_color_type'] == 'gradient' ? $qr_data['frame_gradient_two'] : '#2f6bfd') : '#2f6bfd') : '#2f6bfd') . ";\"
                                                                                    data-reload-qr-code />
                                                                                    <span class=\"icon-edit grey step-edit-icon \"></span>
                                                                                </label>
                
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    
                                                                    </div>
                                                                </div>
                                                        </div>
                                                            <span class=\"seperator mb-16\"></span>
                                                        <div class=\"\" >
                                                            <p class=\"bg-head pl-0 mb-0\">" . l('qr_step_3.frame_background') . "</p>
                                                            <div class=\"col-md-12 frame-background-color-transparency trp-block\">
                                                                <div class=\"checkbox-wrapper p-0 form-group m-0 justify-content-start\">
                                                                    <div class=\"roundCheckbox ml-0 my-2 mr-2 \">
                                                                        <input type=\"checkbox\" name=\"frame_background_color_transparency\" id=\"frame_is_transparent\" data-reload-qr-code value=\"100\"" . (($qr_code_id != "" && $qr_code_id != null && (isset($qr_data['frame_background_color_transparency']))) ?  'checked' : '') . "/>
                                                                        <label class=\"m-0\" for=\"frame_is_transparent\"></label>
                                                                    </div>
                                                                    <label class=\"mb-0\">" . l('qr_step_3.transparent_background') . "</label>
                                                                </div>
                                                            </div> 
                                                            <div class=\"row p-x4 frame-fields-wrap\" >
                                                                <div class=\"col-md-8 mb-3 frame-custom-switch-container\">
                                                                    
                                                                    <div class=\"custom-switch-wrp\">
                                                                    <div class=\"custom-control custom-switch\">
                                                                            <span class=\"custom-switch-text\">" . l('qr_step_3.use_gradients_for_bg') . "</span>
                                                                            <input type=\"checkbox\" class=\"custom-control-input\" name=\"frame_background_color_type\" id=\"isFrameBackgroundGradient\" value=\"gradient\" data-reload-qr-code " . (($qr_code_id != "" && $qr_code_id != null && isset($qr_data['frame_background_color_type']) ? ($qr_data['frame_background_color_type'] == 'gradient' ?  'checked' : '') : '')) . ">
                                                                            <label class=\"custom-control-label qr-custom-switch fieldLabel\" for=\"isFrameBackgroundGradient\">
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class=\"col-md-4 frame-background-color picker-wrap-main\">
                                                                    <div class=\"single-frame-bg-color-wrp\">
                                                                    <div class=\"form-group m-0\">
                                                                        <label class=\"field-label\" for=\"\">" . l('qr_step_3.frame_background_color_FrameBackgroundColorInput') . "</label>
                                                                        <div class=\"customColorPicker\">                                                                    
                                                                            <label for=\"background_color\" class=\"label-with-icon\">
                                                                                <input type=\"text\" name=\"FrameBackgroundColorInput\" class=\"FrameBackgroundColorInput iconColorPiker st3cv\" id=\"FrameBackgroundColorInput\" value=\"" . (($qr_code_id != "" && $qr_code_id != null) ?  $qr_data['FrameBackgroundColorInput'] : '#FFFFFF') . "\" style=\"text-transform:uppercase; border: hidden; font-size:15px; width: 105px;\" maxlength=\"7\" placeholder=\"#FFFFFF\" data-reload-qr-code color_validate />
                                                                                <input id=\"FrameBackgroundColor\" name=\"frame_background_color\" class=\"pickerField custompicker-coloris edit-icon-input black\" type=\"text\" value=\"" . (($qr_code_id != "" && $qr_code_id != null) ?  $qr_data['frame_background_color'] : '#FFFFFF') . "\" style=\"background-color:" . (($qr_code_id != "" && $qr_code_id != null) ?  $qr_data['frame_background_color'] : '#FFFFFF') . ";\" data-reload-qr-code />
                                                                                <span class=\"icon-edit grey step-edit-icon \" style=\"color: black;\"></span>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                    </div>
                                                                    <div class=\"frame-bggrad-dropdown grad-picker grad-select\" style=\"display: none;\">
                                                                        <div class=\"form-group m-0\">
                                                                            <label for=\"filters_cities_by\" class=\"fieldLabel ml-1\">" . l('qr_step_3.gradient') . "</label>
                                                                            <div class=\"custom-drop-wrp\">
                                                                                <select id=\"frame_background_gradient_style\" name=\"frame_background_gradient_style\" class=\"form-control \" data-reload-qr-code>
                                                                                    <option value=\"linear\" " . (($qr_code_id != "" && $qr_code_id != null) ? (($qr_data['frame_background_gradient_style'] == 'linear') ? 'selected' : '') : '') . ">Linear</option>
                                                                                    <option value=\"radial\" " . (($qr_code_id != "" && $qr_code_id != null) ? (($qr_data['frame_background_gradient_style'] == 'radial') ? 'selected' : '') : '') . ">Radial</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class=\"row w-100 frame-backgound-colour-container  grid-3l\" style=\"display: none;\">
                                                                <div class=\"col-md-6 grad-picker\">
                                                                    <div class=\"form-group m-0\">
                                                                        <label class=\"field-label\" for=\"\">" . l('qr_step_3.frame_background_color_1') . "</label>
                                                                        <div class=\"customColorPicker\">
                                                                            <label for=\"background_gradient_one\" class=\"label-with-icon\">
                                                                                    <input
                                                                                    type=\"text\"
                                                                                    name=\"FrameBackgroundColorFirstInput\" 
                                                                                    class=\"FrameBackgroundColorFirstInput iconColorPiker st3cv\" 
                                                                                    id=\"FrameBackgroundColorFirstInput\"

                                                                                    value=\"" . (($qr_code_id != "" && $qr_code_id != null) ? (isset($qr_data['frame_background_color_type']) ? ($qr_data['frame_background_color_type'] == 'gradient' ? $qr_data['frame_background_gradient_one'] : '#000000') : '#000000') : '#000000') . "\" 

                                                                                    style=\"text-transform:uppercase; border: hidden; font-size:15px; width: 105px;\" 
                                                                                    maxlength=\"7\" 
                                                                                    placeholder=\"#000000\"
                                                                                    data-reload-qr-code color_validate />

                                                                                    <input 
                                                                                    id=\"FrameBackgroundColorFirst\" 
                                                                                    name=\"frame_background_gradient_one\" 
                                                                                    class=\"pickerField custompicker-coloris edit-icon-input white\" 
                                                                                    type=\"text\" 

                                                                                    value=\"" . (($qr_code_id != "" && $qr_code_id != null) ? (isset($qr_data['frame_background_color_type']) ?  ($qr_data['frame_background_color_type'] == 'gradient'  ? $qr_data['frame_background_gradient_one'] : '#000000') : '#000000') : '#000000') . "\" 
                                                                                    style=\"background-color:" . (($qr_code_id != "" && $qr_code_id != null) ? (isset($qr_data['frame_background_color_type']) ?  ($qr_data['frame_background_color_type'] == 'gradient'  ? $qr_data['frame_background_gradient_one'] : '#000000') : '#000000') : '#000000') . ";\"
                                                                                    data-reload-qr-code />

                                                                                    <span class=\"icon-edit grey step-edit-icon \"></span>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class=\"col-md-6 grad-picker\">
                                                                    <div class=\"form-group m-0\">
                                                                    <label class=\"field-label\" for=\"\">" . l('qr_step_3.frame_background_color_2') . "</label>
                                                                        <div class=\"customColorPicker\">                                                                    
                                                                        <label for=\"background_type_gradient_two\"  class=\"label-with-icon\">
                                                                            <input 
                                                                            type=\"text\" 
                                                                            name=\"FrameBackgroundColorSecondInput\" 
                                                                            class=\"FrameBackgroundColorSecondInput iconColorPiker st3cv\" 
                                                                            id=\"FrameBackgroundColorSecondInput\" 


                                                                            value=\"" .  (($qr_code_id != "" && $qr_code_id != null) ? (isset($qr_data['frame_background_color_type']) ? ($qr_data['frame_background_color_type'] == 'gradient' ? $qr_data['frame_background_gradient_two'] : '#000000') : '#000000') : '#000000') . "\" 

                                                                            style=\"text-transform:uppercase; border: hidden; font-size:15px; width: 105px;\" 

                                                                            maxlength=\"7\" placeholder=\"#000000\" 
                                                                            data-reload-qr-code color_validate />
                                                                            <input id=\"FrameBackgroundColorSecond\" name=\"frame_background_gradient_two\" class=\"pickerField custompicker-coloris edit-icon-input white\" type=\"text\" value=\"" . (($qr_code_id != "" && $qr_code_id != null) ? (isset($qr_data['frame_background_color_type']) ?  ($qr_data['frame_background_color_type'] == 'gradient'  ? $qr_data['frame_background_gradient_two'] : '#000000') : '#000000') : '#000000') . "\" 
                                                                            style=\"background-color:" . (($qr_code_id != "" && $qr_code_id != null) ? (isset($qr_data['frame_background_color_type']) ?  ($qr_data['frame_background_color_type'] == 'gradient'  ? $qr_data['frame_background_gradient_two'] : '#000000') : '#000000') : '#000000') . ";\"
                                                                            data-reload-qr-code />
                                                                            <span class=\"icon-edit grey step-edit-icon \"></span>
                                                                        </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>  
                                                    </div>   
                                                </div>    
                                            </div>
                                        </div>          
                                    </div>";

            $response .= "<div class=\"custom-accodian\">
                                        <button class=\"btn accodianBtn collapsed qr-frame-btn\" type=\"button\" data-toggle=\"collapse\" data-target=\"#acc_patterns\" aria-expanded=\"true\" aria-controls=\"acc_colors\">
                                            <span class=\"icon-scan-barcode title-icon\"></span>

                                            <span class=\"title-wrp d-flex flex-column align-items-start \">" . l('qr_step_3.code_pattern') . "
                                                <span class=\"fields-helper-heading\">" . l('qr_step_3.code_pattern.help_txt') . "</span>
                                            </span>

                                            <div class=\"icon-wrp\">
                                            <span class=\"icon-arrow-h-right\"></span>
                                            </div>
                                        </button>
    
                                        <div class=\"collapse collapse-wrp \" id=\"acc_patterns\">
                                        <hr class=\"acc-separator mt-1\">
                                            <div class=\"collapseInner\">
                                                <span class=\"title-wrp pl-15\">" . l('qr_step_3.pattern_style') . "</span>
                                                <div class=\"d-flex mb-3 qr-shape customScrollbar\" >
                                                    <div class=\"mr-2 qr-style-wrp\">
                                                        <label class=\"shape-btn " . (($qr_code_id != "" && $qr_code_id != null) ? (($qr_data['style'] == 'square') ? 'active' : '') : 'active') . "\" id=\"square\">
                                                            <input type=\"radio\" name=\"style\" value=\"square\" class=\"custom-control-input\" " . (($qr_code_id != "" && $qr_code_id != null) ? (($qr_data['style'] == 'square') ? 'checked=\"checked\"' : '') : 'checked=\"checked\"') . "  data-reload-qr-code />
                                                            <div class=\"icon-wrapper\">
                                                            <div  class=\"code-style-background\" style=\"display: flex; align-items: center; justify-content: center; padding: 8px;\">
                                                            <span   class=\" dropmenu-icon icon-qr-st-square  code-style\" ></span>
                                                            </div>
                                                            </div>

                                                        </label>
                                                        <span class=\"\"></span>
                                                    </div>
                                                  
                                                    <div class=\"mr-2 qr-style-wrp\">
                                                        <label class=\"shape-btn " . (($qr_code_id != "" && $qr_code_id != null) ? (($qr_data['style'] == 'round') ? 'active' : '') : '') . "\" id=\"round\">
                                                            <input type=\"radio\" name=\"style\" value=\"round\" class=\"custom-control-input\" " . (($qr_code_id != "" && $qr_code_id != null) ? (($qr_data['style'] == 'round') ? 'checked=\"checked\"' : '') : '') . " data-reload-qr-code />
                                                            <div class=\"icon-wrapper\">
                                                            <div  class=\"code-style-background\" style=\"display: flex; align-items: center; justify-content: center; padding: 8px;\">
                                                            <span   class=\" dropmenu-icon icon-qr-st-round code-style\" ></span>
                                                            </div>
                                                            </div>

                                                        </label>
                                                        <span class=\"\"></span>
                                                    </div>
    
                                                    <div class=\"mr-2 qr-style-wrp\">
                                                        <label class=\"shape-btn " . (($qr_code_id != "" && $qr_code_id != null) ? (($qr_data['style'] == 'extra_rounded') ? 'active' : '') : '') . "\" id=\"extra_rounded\">
                                                            <input type=\"radio\" name=\"style\" value=\"extra_rounded\" class=\"custom-control-input\" " . (($qr_code_id != "" && $qr_code_id != null) ? (($qr_data['style'] == 'extra-rounded') ? 'checked=\"checked\"' : '') : '') . " data-reload-qr-code />
                                                            <div class=\"icon-wrapper\">
                                                            <div  class=\"code-style-background\" style=\"display: flex; align-items: center; justify-content: center; padding: 8px;\">
                                                            <span   class=\" dropmenu-icon icon-qr-st-extra-rounded code-style\" ></span>
                                                            </div>
                                                            </div>

                                                        </label>
                                                        <span class=\"\"></span>
                                                    </div> 
    
                                                    <div class=\"mr-2 qr-style-wrp\">
                                                        <label class=\"shape-btn " . (($qr_code_id != "" && $qr_code_id != null) ? (($qr_data['style'] == 'dot') ? 'active' : '') : '') . "\" id=\"dot\">
                                                            <input type=\"radio\" name=\"style\" value=\"dot\" class=\"custom-control-input\" " . (($qr_code_id != "" && $qr_code_id != null) ? (($qr_data['style'] == 'dot') ? 'checked=\"checked\"' : '') : '') . " data-reload-qr-code />
                                                            <div class=\"icon-wrapper\">
                                                            <div  class=\"code-style-background\" style=\"display: flex; align-items: center; justify-content: center; padding: 8px;\">
                                                            <span   class=\" dropmenu-icon icon-qr-st-dot code-style\" ></span>
                                                            </div>
                                                            </div>

                                                        </label>
                                                        <span class=\"\"></span>
                                                    </div>

                                                    <div class=\"mr-2 qr-style-wrp\">
                                                        <label class=\"shape-btn " . (($qr_code_id != "" && $qr_code_id != null) ? (($qr_data['style'] == 'heart') ? 'active' : '') : '') . "\" id=\"heart\">
                                                            <input type=\"radio\" name=\"style\" value=\"heart\" class=\"custom-control-input\" " . (($qr_code_id != "" && $qr_code_id != null) ? (($qr_data['style'] == 'heart') ? 'checked=\"checked\"' : '') : '') . " data-reload-qr-code />
                                                            <div class=\"icon-wrapper\">
                                                            <div  class=\"code-style-background\" style=\"display: flex; align-items: center; justify-content: center; padding: 8px;\">
                                                            <span   class=\" dropmenu-icon icon-qr-st-heart code-style\" ></span>
                                                            </div>
                                                            </div>

                                                        </label>
                                                        <span class=\"\"></span>
                                                    </div>

                                                    <div class=\"mr-2 qr-style-wrp\">
                                                        <label class=\"shape-btn " . (($qr_code_id != "" && $qr_code_id != null) ? (($qr_data['style'] == 'diamond') ? 'active' : '') : '') . "\" id=\"diamond\">
                                                            <input type=\"radio\" name=\"style\" value=\"diamond\" class=\"custom-control-input\" " . (($qr_code_id != "" && $qr_code_id != null) ? (($qr_data['style'] == 'diamond') ? 'checked=\"checked\"' : '') : '') . " data-reload-qr-code />
                                                            <div class=\"icon-wrapper\">
                                                            <div  class=\"code-style-background\" style=\"display: flex; align-items: center; justify-content: center; padding: 8px;\">
                                                            <span   class=\" dropmenu-icon icon-qr-st-diamond code-style\" ></span>
                                                            </div>
                                                            </div>

                                                        </label>
                                                        <span class=\"\"></span>
                                                    </div>
                                            
                                                </div>
                                                <div class=\"bg-container mb-2\">                                                  
                                                    <div>
                                                        <p class=\"bg-head\">" . l('qr_step_3.pattern_color') . "</p>
                                                        <div class=\"pattern-bg-changer-wrp\" >
                                                            <div class=\"row pattern-custom-switch p-x3\" >
                                                                <div class=\"col-md-8 mb-0  pattern-grad-color pattern-custom-switch-container\">
                                                                    <div class=\" custom-switch-wrp\">
                                                                        <div class=\"custom-control custom-switch\">
                                                                            <span  class=\"custom-switch-text\">" . l('qr_step_3.use_gradients_for_pt') . "</span>
                                                                            <input type=\"checkbox\" class=\"custom-control-input\" name=\"foreground_type\" id=\"isBorderGradient\" value=\"gradient\" data-reload-qr-code " . (($qr_code_id != "" && $qr_code_id != null && ($qr_data['foreground_type'] == 'gradient')) ?  'checked' : '') . ">
                                                                            <label class=\"custom-control-label qr-custom-switch fieldLabel\" for=\"isBorderGradient\">
                                                                            </label>
                                                                        </div>
                                                                    </div> 
                                                                </div>
                                                                <div class=\"col-md-4  border-color picker-wrap-main pattern-border-color\">
                                                                    <div class=\"pattern-grad-switch\">
                                                                        <div class=\"form-group m-0\">
                                                                            <label class=\"field-label\" for=\"\">" . l('qr_step_3.pattern_color') . "</label>
                                                                            <div class=\"customColorPicker\">
                                                                                <label  class=\"label-with-icon label-fgc\">
                                                                                    <input type=\"text\" name=\"ForgroundColorInput\" class=\"ForgroundColorInput iconColorPiker st3cv\" id=\"ForgroundColorInput\" value=\"" . (($qr_code_id != "" && $qr_code_id != null) ?  $qr_data['foreground_color'] : '#000000') . "\" style=\"text-transform:uppercase; border: hidden; font-size:15px; width: 105px;\" maxlength=\"7\" placeholder=\"#000000\" data-reload-qr-code color_validate />

                                                                                    <input id=\"ForgroundColor\" name=\"foreground_color\" class=\"pickerField custompicker-coloris edit-icon-input white\" type=\"text\" value=\"" . (($qr_code_id != "" && $qr_code_id != null) ?  $qr_data['foreground_color'] : '#000000') . "\" 
                                                                                    style=\"background-color:" . (($qr_code_id != "" && $qr_code_id != null) ?  $qr_data['foreground_color'] : '#000000') . ";\"
                                                                                    data-reload-qr-code />
                                                                                    <span class=\"icon-edit grey step-edit-icon \" style=\"color: rgb(255, 255, 255);\"></span>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class=\"pattern-grad-dropdown grad-picker grad-select\" style=\"display: none;\">
                                                                        <div class=\"form-group m-0\">
                                                                            <label for=\"filters_cities_by\" class=\"field-label\">" . l('qr_step_3.gradient') . "</label>
                                                                            <div class=\"custom-drop-wrp\">
                                                                                <select id=\"foreground_gradient_style\" name=\"foreground_gradient_style\" class=\"form-control foregroundGradientStyle\" data-reload-qr-code>
                                                                                    <option value=\"vertical\" " . (($qr_code_id != "" && $qr_code_id != null) ? (($qr_data['foreground_gradient_style'] == 'vertical') ? 'selected' : '') : '') . ">Vertical</option>
                                                                                    <option value=\"horizontal\" " . (($qr_code_id != "" && $qr_code_id != null) ? (($qr_data['foreground_gradient_style'] == 'horizontal') ? 'selected' : '') : '') . ">Horizontal</option>
                                                                                    <option value=\"diagonal\" " . (($qr_code_id != "" && $qr_code_id != null) ? (($qr_data['foreground_gradient_style'] == 'diagonal') ? 'selected' : '') : '') . ">Diagonal</option>
                                                                                    <option value=\"inverse_diagonal\" " . (($qr_code_id != "" && $qr_code_id != null) ? (($qr_data['foreground_gradient_style'] == 'inverse_diagonal') ? 'selected' : '') : '') . ">Inverse diagonal</option>
                                                                                    <option value=\"radial\" " . (($qr_code_id != "" && $qr_code_id != null) ? (($qr_data['foreground_gradient_style'] == 'radial') ? 'selected' : '') : '') . ">Radial</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class=\"row w-100 grid-3l border-colour-container  \" style=\"display: none;\">
                                                               
                                                                <div class=\"col-md-6 grad-picker\">
                                                                    <div class=\"form-group m-0\">
                                                                        <label class=\"field-label\" for=\"\">" . l('qr_step_3.pattern_color_1') . "</label>
                                                                        <div class=\"customColorPicker\">
                                                                            <label for=\"foreground_gradient_one\"  class=\"label-with-icon label-fg1\">
                                                                                <input type=\"text\" name=\"ForgroundColorFirstInput\" class=\"ForgroundColorFirstInput iconColorPiker st3cv\" id=\"ForgroundColorFirstInput\" value=\"" . (($qr_code_id != "" && $qr_code_id != null) ? (($qr_data['foreground_type'] == 'gradient') ? $qr_data['foreground_gradient_one'] : '#000000') : '#000000') . "\" style=\"text-transform:uppercase; border: hidden; font-size:15px; width: 105px;\" maxlength=\"7\" placeholder=\"#000000\" data-reload-qr-code color_validate/>
                                                                                <input id=\"ForgroundColorFirst\" name=\"foreground_gradient_one\" class=\"pickerField custompicker-coloris edit-icon-input white\" type=\"text\" value=\"" . (($qr_code_id != "" && $qr_code_id != null) ? (($qr_data['foreground_type'] == 'gradient') ? $qr_data['foreground_gradient_one'] : '#000000') : '#000000') . "\" 
                                                                                style=\"background-color:" . (($qr_code_id != "" && $qr_code_id != null) ? (($qr_data['foreground_type'] == 'gradient') ? $qr_data['foreground_gradient_one'] : '#000000') : '#000000') .  ";\"
                                                                                data-reload-qr-code />
                                                                                <span class=\"icon-edit grey step-edit-icon \" style=\"color: rgb(255, 255, 255);\"></span>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class=\"col-md-6 grad-picker\">
                                                                    <div class=\"form-group m-0\">
                                                                    <label class=\"field-label\" for=\"\">" . l('qr_step_3.pattern_color_2') . "</label>
                                                                        <div class=\"customColorPicker\">
                                                                            <label for=\"foreground_gradient_two\"  class=\"label-with-icon label-fg2\">
                                                                                <input type=\"text\" name=\"ForgroundColorSecondInput\" class=\"ForgroundColorSecondInput iconColorPiker st3cv\" id=\"ForgroundColorSecondInput\" value=\"" . (($qr_code_id != "" && $qr_code_id != null) ? (($qr_data['foreground_type'] == 'gradient') ? $qr_data['foreground_gradient_two'] : '#000000') : '#000000') . "\" style=\"text-transform:uppercase; border: hidden; font-size:15px; width: 105px;\" maxlength=\"7\" placeholder=\"#000000\" data-reload-qr-code color_validate/>
                                                                                <input id=\"ForgroundColorSecond\" name=\"foreground_gradient_two\" class=\"pickerField custompicker-coloris edit-icon-input white\" type=\"text\" value=\"" . (($qr_code_id != "" && $qr_code_id != null) ? (($qr_data['foreground_type'] == 'gradient') ? $qr_data['foreground_gradient_two'] : '#000000') : '#000000') . "\" 
                                                                                style=\"background-color:" . (($qr_code_id != "" && $qr_code_id != null) ? (($qr_data['foreground_type'] == 'gradient') ? $qr_data['foreground_gradient_two'] : '#000000') : '#000000') .  ";\"
                                                                                data-reload-qr-code />
                                                                                <span class=\"icon-edit grey step-edit-icon \" style=\"color: rgb(255, 255, 255);\"></span>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            
                                                            </div>

                                                            <div class=\"row justify-content-center divider-wrp \">
                                                                <div class=\"col swap-btn-wrp\">
                                                                    <button type=\"button\" class=\"replace-btn d-block mt-0 mx-auto swap-primary-color\" id=\"swapPrimaryColor\" data-reload-qr-code>
                                                        
                                                                        <span class=\"icon-swap\"></span>
                                                                
                                                                    </button>
                                                                    <div class=\"divider new \"></div>
                                                                </div>
                                                            </div>
                                                            <div class=\"row p-x3 pattern-bg-wrap\">
                                                                <div class=\"col-12 pl-0\"><p class=\"mb-0 bg-head\">" . l('qr_step_3.pattern_background_color') . "</p></div>
                                                                <div class=\"col-md-12 pl-0 background-color-transparency trp-block\">
                                                                    <div class=\"checkbox-wrapper p-0 form-group m-0 justify-content-start\">
                                                                        <div class=\"roundCheckbox my-2 mr-2 \">
                                                                            <input type=\"checkbox\" name=\"background_color_transparency\" id=\"is_transparent\" data-reload-qr-code value=\"100\" " . (($qr_code_id != "" && $qr_code_id != null && ($qr_data['background_color_transparency'])) ?  'checked' : '') . "/>
                                                                            <label class=\"m-0\" for=\"is_transparent\"></label>
                                                                        </div>
                                                                        <label class=\"mb-0\">" . l('qr_step_3.transparent_background') . "</label>
                                                                    </div>
                                                                </div> 
                                                                <div class=\"col-md-8 mb-3 pattern-grad-bg-color pattern-custom-switch-container\">
                                                                    <div class=\" custom-switch-wrp\">
                                                                        <div class=\"custom-control custom-switch\">
                                                                            <span class=\"custom-switch-text\">" . l('qr_step_3.use_gradients_for_bg') . "</span>
                                                                            <input type=\"checkbox\" class=\"custom-control-input\" name=\"background_type\" id=\"background_colour_gradient\" value=\"gradient\" data-reload-qr-code " . (($qr_code_id != "" && $qr_code_id != null && isset($qr_data['background_type']) ? ($qr_data['background_type'] == 'gradient' ?  'checked' : '') : '')) . ">
                                                                            <label class=\"custom-control-label qr-custom-switch fieldLabel\" for=\"background_colour_gradient\">
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class=\"col-md-4 background-color pattern-bg-color-wrap picker-wrap-main\">
                                                                    <div class=\"pattern-bg-single-color\">
                                                                        <div class=\"form-group m-0\">
                                                                            <label class=\"field-label\" for=\"\">" . l('qr_step_3.pattern_background_color_BackgroundColorInput') . "</label>
                                                                            <div class=\"customColorPicker\">

                                                                                <label for=\"background_color\" class=\"label-with-icon label-bgc\">
                                                                                    <input type=\"text\" name=\"BackgroundColorInput\" class=\"BackgroundColorInput iconColorPiker st3cv\" id=\"BackgroundColorInput\" value=\"" . (($qr_code_id != "" && $qr_code_id != null) ?  $qr_data['background_color'] : '#FFFFFF') . "\" style=\"text-transform:uppercase; border: hidden; font-size:15px; width: 105px;\" maxlength=\"7\" placeholder=\"#000000\" data-reload-qr-code color_validate />
                                                                                    <input id=\"BackgroundColor\" name=\"background_color\" class=\"pickerField custompicker-coloris edit-icon-input black\" type=\"text\" value=\"" . (($qr_code_id != "" && $qr_code_id != null) ?  $qr_data['background_color'] : '#FFFFFF') . "\" 
                                                                                    style=\"background-color:" . (($qr_code_id != "" && $qr_code_id != null) ?  $qr_data['background_color'] : '#FFFFFF') . ";\"
                                                                                    data-reload-qr-code />
                                                                                    <span class=\"icon-edit grey step-edit-icon \" style=\"color: rgb(0, 0, 0);\"></span>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class=\"pattern-bg-grad-dropdown\" style=\"display: none;\">
                                                                        <div class=\"form-group mb-0\">
                                                                            <label for=\"filters_cities_by\" class=\"field-label\">" . l('qr_step_3.gradient') . "</label>
                                                                            <div class=\"custom-drop-wrp\">
                                                                            <select id=\"background_gradient_style\" name=\"backgound_gradient_style\" class=\"form-control backgroundGradientStyle\" data-reload-qr-code>
                                                                                <option value=\"linear\" " . (($qr_code_id != "" && $qr_code_id != null) ? (($qr_data['backgound_gradient_style'] == 'linear') ? 'selected' : '') : '') . ">Linear</option>
                                                                                <option value=\"radial\" " . (($qr_code_id != "" && $qr_code_id != null) ? (($qr_data['backgound_gradient_style'] == 'radial') ? 'selected' : '') : '') . ">Radial</option>
                                                                            </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>                                                               
                                                                </div>

                                                                
                                                            </div>

                                                            <div class=\"row mt-0 backgound-colour-container  grid-3l\" style=\"display: none;\">
                                                            
                                                            <div class=\"col-md-6 grad-picker\">
                                                                <div class=\"form-group m-0\">
                                                                    <label class=\"field-label\" for=\"\">" . l('qr_step_3.pattern_bg_color_1') . "</label>
                                                                    <div class=\"customColorPicker\">

                                                                        <label for=\"background_gradient_one\" class=\"label-with-icon label-bg1\">
                                                                        <input type=\"text\" name=\"BackgroundColorFirstInput\" class=\"BackgroundColorFirstInput iconColorPiker st3cv\" id=\"BackgroundColorFirstInput\" value=\"" .  (($qr_code_id != "" && $qr_code_id != null) ? (isset($qr_data['background_type']) ?  ($qr_data['background_type'] == 'gradient' ? $qr_data['background_gradient_one'] : '#FFFFFF') : '#FFFFFF') : '#FFFFFF') . "\" style=\"text-transform:uppercase; border: hidden; font-size:15px; width: 105px;\" maxlength=\"7\" placeholder=\"#000000\" data-reload-qr-code color_validate/>

                                                                            <input id=\"BackgroundColorFirst\" name=\"background_gradient_one\" class=\"pickerField custompicker-coloris edit-icon-input black\" type=\"text\" value=\"" . (($qr_code_id != "" && $qr_code_id != null) ? (isset($qr_data['background_type']) ?  ($qr_data['background_type'] == 'gradient' ? $qr_data['background_gradient_one'] : '#FFFFFF') : '#FFFFFF') : '#FFFFFF') . "\" 
                                                                            style=\"background-color:" . (($qr_code_id != "" && $qr_code_id != null) ? (isset($qr_data['background_type']) ?  ($qr_data['background_type'] == 'gradient' ? $qr_data['background_gradient_one'] : '#FFFFFF') : '#FFFFFF') : '#FFFFFF') .  ";\"
                                                                            data-reload-qr-code />
                                                                            <span class=\"icon-edit grey step-edit-icon \" style=\"color: rgb(0, 0, 0);\"></span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class=\"col-md-6 grad-picker\">
                                                                <div class=\"form-group m-0\">
                                                                <label class=\"field-label\" for=\"\">" . l('qr_step_3.pattern_bg_color_2') . "</label>
                                                                    <div class=\"customColorPicker\">
                                                                        <label for=\"background_type_gradient_two\" class=\"label-with-icon label-bg2\">
                                                                            <input type=\"text\" name=\"BackgroundColorSecondInput\" class=\"BackgroundColorSecondInput iconColorPiker st3cv\" id=\"BackgroundColorSecondInput\" value=\"" . (($qr_code_id != "" && $qr_code_id != null) ? (isset($qr_data['background_type']) ?  ($qr_data['background_type'] == 'gradient' ? $qr_data['background_gradient_two'] : '#FFFFFF') : '#FFFFFF') : '#FFFFFF') . "\" style=\"text-transform:uppercase; border: hidden; font-size:15px; width: 105px;\" maxlength=\"7\" placeholder=\"#000000\" data-reload-qr-code color_validate/>

                                                                            <input id=\"BackgroundColorSecond\" name=\"background_gradient_two\" class=\"pickerField custompicker-coloris edit-icon-input black\" type=\"text\" value=\"" . (($qr_code_id != "" && $qr_code_id != null) ? (isset($qr_data['background_type']) ?  ($qr_data['background_type'] == 'gradient' ? $qr_data['background_gradient_two'] : '#FFFFFF') : '#FFFFFF') : '#FFFFFF') . "\" 
                                                                            style=\"background-color:" . (($qr_code_id != "" && $qr_code_id != null) ? (isset($qr_data['background_type']) ?  ($qr_data['background_type'] == 'gradient' ? $qr_data['background_gradient_two'] : '#FFFFFF') : '#FFFFFF') : '#FFFFFF') . ";\"
                                                                            data-reload-qr-code />
                                                                            <span class=\"icon-edit grey step-edit-icon \" style=\"color: rgb(0, 0, 0);\"></span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                   
                                                    </div>
    
                                                    </div>
                                                    <div class=\"bg-note high-contrast\">
                                                        <span class=\"icon-pending\"></span>
                                                        <span class=\"high-contrast-text\"><span class=\"bold\">" . l('qr_step_3.remember') . "</span> " . l("qr_step_3.description") . "</span>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>";
            $response .= "  <div class=\"custom-accodian\">
                                        <button class=\"btn accodianBtn collapsed qr-frame-btn\" type=\"button\" data-toggle=\"collapse\" data-target=\"#acc_corners\" aria-expanded=\"true\"    aria-controls=\"acc_colors\">
                                            <span class=\"icon-qr-corners title-icon\"></span>

                                            <span class=\"title-wrp d-flex flex-column align-items-start \">"
                . l('qr_step_3.code_corners') . "
                                                <span class=\"fields-helper-heading\">" . l('qr_step_3.code_corners.help_txt') . "</span>
                                            </span>

                                            <div class=\"icon-wrp\">
                                            <span class=\"icon-arrow-h-right\"></span>
                                            </div>
                                        </button>
    
                                        <div class=\"collapse collapse-wrp \" id=\"acc_corners\">
                                            <hr class=\"acc-separator mt-1\">
                                            <div class=\"collapseInner\">
                                                    <div class=\"corner-style-wrp\" >
                                                        <p class=\"bg-head mb-2 mt-3 pl-14 \">" . l('qr_step_3.corners') . "</p>
                                                       
                                                        <div class=\"row mx-0 corners-row\" style=\"\">

                                                            <div class=\"col-md-5\">
                                                                <div class=\"form-group m-0\">
                                                                    <label>" . l('qr_step_3.frame_corner') . "</label>
                                                                </div>

                                                                <div class=\"cornerBtn-container\">
                                                                    <div class=\"mb-0\"> 
                                                                        <label class=\"eye-btn " . (($qr_code_id != "" && $qr_code_id != null) ? (($qr_data['fEye']) ? '' : 'active') : 'active') . "\" id=\"NS\">
                                                                            <input type=\"radio\" name=\"fEye\" id=\"eyeNS\" " . (($qr_code_id != "" && $qr_code_id != null) ? (($qr_data['fEye']) ? '' : 'checked') : 'checked') . " value=\"square\" class=\"custom-control-input\" data-reload-qr-code />
                                                                            <svg class=\"MuiSvgIcon-root MuiSvgIcon-fontSizeMedium mui-style-vubbuv\" focusable=\"false\" aria-hidden=\"true\" viewBox=\"0 0 24 24\" data-testid=\"DoDisturbAltOutlinedIcon\"><path class=\"cornerDotAroundSvg\" d=\"M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10 10-4.5 10-10S17.5 2 12 2zM4 12c0-4.4 3.6-8 8-8 1.8 0 3.5.6 4.9 1.7L5.7 16.9C4.6 15.5 4 13.8 4 12zm8 8c-1.8 0-3.5-.6-4.9-1.7L18.3 7.1C19.4 8.5 20 10.2 20 12c0 4.4-3.6 8-8 8z\"></path></svg>
                                                                        </label>
                                                                    </div>

                                                                     <div class=\"mb-0\"> 
                                                                        <label class=\"eye-btn " . (($qr_code_id != "" && $qr_code_id != null) ? (($qr_data['fEye'] == 'circle') ? 'active' : '') : '') . "\" id=\"FR\">
                                                                            <input type=\"radio\" name=\"fEye\" id=\"eyeFR\" " . (($qr_code_id != "" && $qr_code_id != null) ? (($qr_data['fEye'] == 'circle') ? 'checked' : '') : '') . " value=\"circle\" class=\"custom-control-input\" data-reload-qr-code />
                                                                            <svg viewBox=\"0 0 24 24\" xmlns=\"http://www.w3.org/2000/svg\" width=\"24px\" height=\"24px\"><path class=\"cornerDotAroundSvg\" fill=\"#000000\" d=\"M12,0A12,12,0,1,0,24,12,12,12,0,0,0,12,0Zm0,20a8,8,0,1,1,8-8A8,8,0,0,1,12,20Z\"></path></svg>
                                                                        </label>
                                                                    </div>
                                                                    <div class=\"mb-0\"> 
                                                                        <label class=\"eye-btn " . (($qr_code_id != "" && $qr_code_id != null) ? (($qr_data['fEye'] == 'square') ? 'active' : '') : '') . "\" id=\"FS\">
                                                                            <input type=\"radio\" name=\"fEye\" id=\"eyeFS\" " . (($qr_code_id != "" && $qr_code_id != null) ? (($qr_data['fEye'] == 'square') ? 'checked' : '') : '') . " value=\"square\" class=\"custom-control-input\" data-reload-qr-code />
                                                                            <svg viewBox=\"0 0 24 24\" xmlns=\"http://www.w3.org/2000/svg\" width=\"24px\" height=\"24px\"><path class=\"cornerDotAroundSvg\" fill=\"#000000\" d=\"M0,0V24H24V0ZM20,20H4V4H20Z\"></path></svg>
                                                                        </label>
                                                                    </div>
                                                                    <div class=\"mb-0\"> 
                                                                        <label class=\"eye-btn " . (($qr_code_id != "" && $qr_code_id != null) ? (($qr_data['fEye'] == 'rounded') ? 'active' : '') : '') . "\" id=\"FRR\">
                                                                            <input type=\"radio\" name=\"fEye\" id=\"eyeFRR\" " . (($qr_code_id != "" && $qr_code_id != null) ? (($qr_data['fEye'] == 'rounded') ? 'checked' : '') : '') . " value=\"rounded\" class=\"custom-control-input\" data-reload-qr-code />
                                                                            <svg viewBox=\"0 0 24 24\" xmlns=\"http://www.w3.org/2000/svg\" width=\"24px\" height=\"24px\"><path class=\"cornerDotAroundSvg\" fill=\"#000000\" d=\"M18.89,23.29H5.11a4.41,4.41,0,0,1-4.4-4.4V5.11A4.41,4.41,0,0,1,5.11.71H18.89a4.41,4.41,0,0,1,4.4,4.4V18.89A4.41,4.41,0,0,1,18.89,23.29ZM5.11,4.71a.4.4,0,0,0-.4.4V18.89a.4.4,0,0,0,.4.4H18.89a.4.4,0,0,0,.4-.4V5.11a.4.4,0,0,0-.4-.4Z\"></path></svg>
                                                                        </label>
                                                                    </div>

                                                                    <div class=\"mb-0\"> 
                                                                        <label class=\"eye-btn " . (($qr_code_id != "" && $qr_code_id != null) ? (($qr_data['fEye'] == 'flower') ? 'active' : '') : '') . "\" id=\"FF\">
                                                                            <input type=\"radio\" name=\"fEye\" id=\"eyeFF\" " . (($qr_code_id != "" && $qr_code_id != null) ? (($qr_data['fEye'] == 'flower') ? 'checked' : '') : '') . " value=\"flower\" class=\"custom-control-input\" data-reload-qr-code />
                                                                            <svg viewBox=\"0 0 24 24\" xmlns=\"http://www.w3.org/2000/svg\" width=\"24px\" height=\"24px\"><path class=\"cornerDotAroundSvg\" fill=\"#000000\" d=\"M23.29,23.29H5.11a4.41,4.41,0,0,1-4.4-4.4V5.11A4.41,4.41,0,0,1,5.11.71H18.89a4.41,4.41,0,0,1,4.4,4.4ZM5.11,4.71a.4.4,0,0,0-.4.4V18.89a.4.4,0,0,0,.4.4H19.29V5.11a.4.4,0,0,0-.4-.4Z\"></path></svg>
                                                                        </label>
                                                                    </div>

                                                                    <div class=\"mb-0\"> 
                                                                        <label class=\"eye-btn " . (($qr_code_id != "" && $qr_code_id != null) ? (($qr_data['fEye'] == 'leaf') ? 'active' : '') : '') . "\" id=\"FL\">
                                                                            <input type=\"radio\" name=\"fEye\" id=\"eyeFL\" " . (($qr_code_id != "" && $qr_code_id != null) ? (($qr_data['fEye'] == 'leaf') ? 'checked' : '') : '') . " value=\"leaf\" class=\"custom-control-input\" data-reload-qr-code />
                                                                            <svg viewBox=\"0 0 24 24\" xmlns=\"http://www.w3.org/2000/svg\" width=\"24px\" height=\"24px\"><path class=\"cornerDotAroundSvg\" fill=\"#000000\" d=\"M18.89,23.29H.71V5.11A4.41,4.41,0,0,1,5.11.71H23.29V18.89A4.41,4.41,0,0,1,18.89,23.29Zm-14.18-4H18.89a.4.4,0,0,0,.4-.4V4.71H5.11a.4.4,0,0,0-.4.4Z\"></path></svg>
                                                                        </label>
                                                                    </div>

                                                                </div>
                                                            </div>

                                                            <div class=\"col-md-6 offset-md-1\">
                                                                   <div class=\"form-group m-0\">
                                                                        <label>" . l('qr_step_3.corner_dot') . "</label>
                                                                    </div>
                                                                    <div class=\"cornerBtn-container\">

                                                                    <div class=\"mb-0\"> 
                                                                        <label class=\"eye-btn " . (($qr_code_id != "" && $qr_code_id != null) ? (($qr_data['cEye']) ? '' : 'active') : 'active') . "\" id=\"IN\">
                                                                            <input type=\"radio\" name=\"cEye\" id=\"IIN\" " . (($qr_code_id != "" && $qr_code_id != null) ? (($qr_data['cEye']) ? '' : 'checked') : 'checked') . " value=\"square\" class=\"custom-control-input\" data-reload-qr-code />
                                                                            <svg class=\"MuiSvgIcon-root MuiSvgIcon-fontSizeMedium mui-style-vubbuv\" focusable=\"false\" aria-hidden=\"true\" viewBox=\"0 0 24 24\" data-testid=\"DoDisturbAltOutlinedIcon\"><path class=\"cornerDotSvg\" d=\"M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10 10-4.5 10-10S17.5 2 12 2zM4 12c0-4.4 3.6-8 8-8 1.8 0 3.5.6 4.9 1.7L5.7 16.9C4.6 15.5 4 13.8 4 12zm8 8c-1.8 0-3.5-.6-4.9-1.7L18.3 7.1C19.4 8.5 20 10.2 20 12c0 4.4-3.6 8-8 8z\"></path></svg>
                                                                        </label>
                                                                    </div>
                                                                    <div class=\"mb-0\"> 
                                                                        <label class=\"eye-btn " . (($qr_code_id != "" && $qr_code_id != null) ? (($qr_data['cEye'] == 'dot') ? 'active' : '') : '') . "\" id=\"ID\">
                                                                            <input type=\"radio\" name=\"cEye\" id=\"IID\" " . (($qr_code_id != "" && $qr_code_id != null) ? (($qr_data['cEye'] == 'dot') ? 'checked' : '') : '') . " value=\"dot\" class=\"custom-control-input\" data-reload-qr-code />
                                                                            <svg viewBox=\"0 0 24 24\" xmlns=\"http://www.w3.org/2000/svg\" width=\"24px\" height=\"24px\"><circle class=\"cornerDotSvg\" fill=\"#000000\" cx=\"12\" cy=\"12\" r=\"6\"></circle></svg>
                                                                        </label>
                                                                    </div>
                                                                    <div class=\"mb-0\"> 
                                                                        <label class=\"eye-btn " . (($qr_code_id != "" && $qr_code_id != null) ? (($qr_data['cEye'] == 'square') ? 'active' : '') : '') . "\" id=\"IS\">
                                                                            <input type=\"radio\" name=\"cEye\" id=\"IIS\" " . (($qr_code_id != "" && $qr_code_id != null) ? (($qr_data['cEye'] == 'square') ? 'checked' : '') : '') . " value=\"square\" class=\"custom-control-input\" data-reload-qr-code />
                                                                            <svg viewBox=\"0 0 24 24\" xmlns=\"http://www.w3.org/2000/svg\" width=\"24px\" height=\"24px\"><rect class=\"cornerDotSvg\" fill=\"#000000\" x=\"6\" y=\"6\" width=\"12\" height=\"12\"></rect></svg>
                                                                        </label>
                                                                    </div>

                                                                    <div class=\"mb-0\"> 
                                                                        <label class=\"eye-btn " . (($qr_code_id != "" && $qr_code_id != null) ? (($qr_data['cEye'] == 'rounded') ? 'active' : '') : '') . "\" id=\"IR\">
                                                                            <input type=\"radio\" name=\"cEye\" id=\"IIR\" " . (($qr_code_id != "" && $qr_code_id != null) ? (($qr_data['cEye'] == 'rounded') ? 'checked' : '') : '') . " value=\"rounded\" class=\"custom-control-input\" data-reload-qr-code />
                                                                            <svg viewBox=\"0 0 24 24\" xmlns=\"http://www.w3.org/2000/svg\" width=\"24px\" height=\"24px\"><rect class=\"cornerDotSvg\" fill=\"#000000\" x=\"6\" y=\"6\" width=\"12\" height=\"12\" rx=\"2.4\"></rect></svg>
                                                                        </label>
                                                                    </div>

                                                                    <div class=\"mb-0\"> 
                                                                    <label class=\"eye-btn " . (($qr_code_id != "" && $qr_code_id != null) ? (($qr_data['cEye'] == 'diamond') ? 'active' : '') : '') . "\" id=\"IDD\">
                                                                            <input type=\"radio\" name=\"cEye\" id=\"IIDD\" " . (($qr_code_id != "" && $qr_code_id != null) ? (($qr_data['cEye'] == 'diamond') ? 'checked' : '') : '') . " value=\"diamond\" class=\"custom-control-input\" data-reload-qr-code />
                                                                            <svg viewBox=\"0 0 24 24\" xmlns=\"http://www.w3.org/2000/svg\" width=\"24px\" height=\"24px\"><rect class=\"cornerDotSvg\" x=\"6.79\" y=\"6.79\" width=\"10.42\" height=\"10.42\" transform=\"translate(-4.97 12) rotate(-45)\"/></svg>
                                                                        </label>
                                                                    </div>

                                                                    <div class=\"mb-0\"> 
                                                                        <label class=\"eye-btn " . (($qr_code_id != "" && $qr_code_id != null) ? (($qr_data['cEye'] == 'flower') ? 'active' : '') : '') . "\" id=\"IF\">
                                                                            <input type=\"radio\" name=\"cEye\" id=\"IIF\" " . (($qr_code_id != "" && $qr_code_id != null) ? (($qr_data['cEye'] == 'flower') ? 'checked' : '') : '') . " value=\"flower\" class=\"custom-control-input\" data-reload-qr-code />
                                                                            <svg viewBox=\"0 0 24 24\" xmlns=\"http://www.w3.org/2000/svg\" width=\"24px\" height=\"24px\"><path class=\"cornerDotSvg\" d=\"M9.19,6.79h5.62a2.39,2.39,0,0,1,2.4,2.4v8h-8a2.39,2.39,0,0,1-2.4-2.4V9.19A2.39,2.39,0,0,1,9.19,6.79Z\"/></svg>
                                                                        </label>
                                                                    </div>

                                                                    <div class=\"mb-0\"> 
                                                                        <label class=\"eye-btn " . (($qr_code_id != "" && $qr_code_id != null) ? (($qr_data['cEye'] == 'leaf') ? 'active' : '') : '') . "\" id=\"IL\">
                                                                            <input type=\"radio\" name=\"cEye\" id=\"IIL\" " . (($qr_code_id != "" && $qr_code_id != null) ? (($qr_data['cEye'] == 'leaf') ? 'checked' : '') : '') . " value=\"leaf\" class=\"custom-control-input\" data-reload-qr-code />
                                                                            <svg viewBox=\"0 0 24 24\" xmlns=\"http://www.w3.org/2000/svg\" width=\"24px\" height=\"24px\"><path class=\"cornerDotSvg\" d=\"M17.21,6.79v8a2.39,2.39,0,0,1-2.4,2.4h-8v-8a2.39,2.39,0,0,1,2.4-2.4Z\"/></svg>
                                                                        </label>
                                                                    </div>


                                                                </div>
                                                            </div>
                                                        </div>
    
                                                        <input type=\"hidden\" name=\"custom_eyes_color\" value=\"1\" />
                                                        <div class=\"p-3 bg-inner inner-pickers-wrp  m-0\" style=\"background-color:#ffffff\">
                                                            <div class=\"row grid-3l\">
                                                                <div class=\"col-md-6 grad-picker \">
                                                                    <div class=\"form-group m-0\">
                                                                        <label class=\"field-label\" for=\"\">" . l('qr_step_3.frame_corner_color') . "</label>
                                                                        <div class=\"customColorPicker\">

                                                                        
                                                                        <label for=\"eyes_inner_color\" class=\"label-with-icon\">
                                                                                <input type=\"text\" name=\"EIColorInput\" class=\"EIColorInput iconColorPiker st3cv\" id=\"EIColorInput\" value=\"" . (($qr_code_id != "" && $qr_code_id != null) ?  $qr_data['eyes_inner_color'] : '#000000') . "\" style=\"text-transform:uppercase; border: hidden; font-size:15px; width: 105px;\" maxlength=\"7\" placeholder=\"#000000\" data-reload-qr-code color_validate/>
                                                                                <input id=\"EIColor\" name=\"eyes_inner_color\" class=\"pickerField custompicker-coloris edit-icon-input white\" type=\"text\" value=\"" . (($qr_code_id != "" && $qr_code_id != null) ?  $qr_data['eyes_inner_color'] : '#000000') . "\" 
                                                                                style=\"background-color:" . (($qr_code_id != "" && $qr_code_id != null) ?  $qr_data['eyes_inner_color'] : '#000000') . ";\"
                                                                                data-reload-qr-code />
                                                                                <span class=\"icon-edit grey step-edit-icon \"></span>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class=\"col-md-6 grad-picker \">
                                                                    <div class=\"form-group m-0\">
                                                                        <label class=\"field-label\" for=\"\">" . l('qr_step_3.corner_dot_type') . "</label>
                                                                        <div class=\"customColorPicker\">

                                                                            <label for=\"eyes_outer_color\" class=\"label-with-icon\">
                                                                                <input type=\"text\" name=\"EOColorInput\" class=\"EOColorInput iconColorPiker st3cv\" id=\"EOColorInput\" value=\"" . (($qr_code_id != "" && $qr_code_id != null) ?  $qr_data['eyes_outer_color'] : '#000000') . "\" style=\"text-transform:uppercase; border: hidden; font-size:15px; width: 105px;\" maxlength=\"7\" placeholder=\"#000000\" data-reload-qr-code color_validate/>

                                                                                <input id=\"EOColor\" name=\"eyes_outer_color\" class=\"pickerField custompicker-coloris edit-icon-input white\" type=\"text\" value=\"" . (($qr_code_id != "" && $qr_code_id != null) ?  $qr_data['eyes_outer_color'] : '#000000') . "\" 
                                                                                style=\"background-color:" . (($qr_code_id != "" && $qr_code_id != null) ?  $qr_data['eyes_outer_color'] : '#000000') . ";\"
                                                                                data-reload-qr-code />
                                                                                <span class=\"icon-edit grey step-edit-icon \"></span>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                            </div>";

            $response .= "<div class=\"custom-accodian\">
                                        <button class=\"btn accodianBtn collapsed qr-frame-btn addLogoBtn\" type=\"button\" data-toggle=\"collapse\" data-target=\"#acc_addLogo\" aria-expanded=\"true\" aria-controls=\"acc_addLogo\">
                                            <span class=\"icon-add-image title-icon\"></span>

                                            <span class=\"title-wrp d-flex flex-column align-items-start \">"
                . l('qr_step_3.add_logo') . "
                                                <span class=\"fields-helper-heading\">" . l('qr_step_3.add_logo.help_txt') . "</span>
                                            </span>

                                            <div class=\"icon-wrp\">
                                            <span class=\"icon-arrow-h-right\"></span>
                                            </div>
                                        </button>
                                        <div class=\"collapse collapse-wrp \" id=\"acc_addLogo\">
                                        <hr class=\"acc-separator mt-1\">
                                            <div class=\"collapseInner logo-wrapper-block\">
                                                <div class=\"welcome-screen\">
                                                    <span class=\"title-wrp pl-0\">" . l('qr_step_3.upload_logo') . "</span>
                                                    <!-- Before Upload Priview -->
                                                    <div class=\"screen-upload\">
                                                        <label for=\"qr_code_logo\">
                                                            <input id=\"qr_code_logo\"   type=\"file\" name=\"qr_code_logo\" accept=\"" . \Altum\Uploads::get_whitelisted_file_extensions_accept('qr_codes/logo') . "\" class=\"form-control py-2\" data-reload-qr-code  />
                                                            <div class=\"input-image\" id=\"input-logo-image\">
                                                            " . (($qr_code_id != "" && $qr_code_id != null && $qr_code[0]['qr_code_logo'] != '') ? '<img src="uploads/qr_codes/logo/' . $qr_code[0]['qr_code_logo'] . '" height="60" width="60" alt="Welcome screen image" id="logo-upl-img">
                                                            <input type="hidden" name="edit_QR_code_logo" id="edit_QR_code_logo" value="' . $qr_code[0]['qr_code_logo'] . '" >' : '') . "
                                                            <span class=\"icon-add-image logo-tmp-mage\" id=\"logo-tmp-mage\" style=\"" . (($qr_code_id != "" && $qr_code_id != null && $qr_code[0]['qr_code_logo'] != '') ? 'display: none;' : '') . " \"></span>
                                                            <svg class=\"MuiSvgIcon-root d-none logo-tmp-mage\" id=\"logo-tmp-mage\" focusable=\"false\" viewBox=\"0 0 60 60\" aria-hidden=\"true\" style=\"" . (($qr_code_id != "" && $qr_code_id != null && $qr_code[0]['qr_code_logo'] != '') ? 'display: none;' : '') . " \">
                                                            <path d=\"M19.24,26.79a8.17,8.17,0,1,0-8.17-8.17A8.17,8.17,0,0,0,19.24,26.79Zm0-14.34a6.17,6.17,0,1,1-6.17,6.17A6.18,6.18,0,0,1,19.24,12.45Z\"></path>
                                                            <path d=\"M56.75,49.34,39.18,29.26a1,1,0,0,0-1.46-.05L25.09,41.84,19.1,35a1,1,0,0,0-.72-.34.93.93,0,0,0-.74.29L3.29,49.29a1,1,0,0,0,1.42,1.42L18.3,37.12,30.14,50.66a1,1,0,0,0,.76.34,1,1,0,0,0,.66-.25,1,1,0,0,0,.09-1.41l-5.24-6,12-12L55.25,50.66A1,1,0,0,0,56,51a1,1,0,0,0,.75-1.66Z\"></path>
                                                            </svg>
                                                            </div>
                                                            <div class=\"add-icon\" id=\"add-logo-icon\" style=\"opacity:0;" . (($qr_code_id != "" && $qr_code_id != null && $qr_code[0]['qr_code_logo'] != '') ? 'display: none;' : '') . " \">
                                                                <svg style=\"margin: 7px;\" class=\"MuiSvgIcon-root\" focusable=\"false\" viewBox=\"0 0 24 24\" aria-hidden=\"true\">
                                                                    <path d=\"M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z\"></path>
                                                                </svg>
                                                            </div>
                                                            <div class=\"add-icon logo-edit-icon\" id=\"edit-logo-icon\" style=\"opacity:1;" . (($qr_code_id != "" && $qr_code_id != null && $qr_code[0]['qr_code_logo'] != '') ? '' : 'display: none;') . "\">
                                                                <svg class=\"MuiSvgIcon-root\" focusable=\"false\" viewBox=\"0 0 24 24\" aria-hidden=\"true\" style=\"font-size: 24px;font-size: 24px;margin: 7px;\">
                                                                    <path d=\"M20.71,6.29l-3-3a1,1,0,0,0-1.42,0l-12,12a1,1,0,0,0-.26.47l-1,4a1,1,0,0,0,.26.95A1,1,0,0,0,4,21a1,1,0,0,0,.24,0l4-1a1,1,0,0,0,.47-.26l12-12A1,1,0,0,0,20.71,6.29ZM7.49,18.1l-2.12.53.53-2.12,8.6-8.6L16.09,9.5Zm10-10L15.91,6.5,17,5.41,18.59,7Z\"></path>
                                                                </svg>
                                                            </div>
                                                        </label>
                                                        <button type=\"button\" class=\"delete-btn\" id=\"logo_delete\" style=\"" . (($qr_code_id != "" && $qr_code_id != null && $qr_code[0]['qr_code_logo'] != '') ? '' : 'display: none;') . "\" data-reload-qr-code>
                                                           
                                                        " . l('qr_step_3.delete') . "
                                                        </button>
                                                    </div>
                                                    <br>
                                                    <div class=\"form-group mb-0\" style=\"display:none;\">
                                                        <label for=\"qr_code_logo_size\"><svg class=\"svg-inline--fa fa-expand-alt fa-w-14 fa-fw fa-sm mr-1\" aria-hidden=\"true\" focusable=\"false\" data-prefix=\"fa\" data-icon=\"expand-alt\" role=\"img\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 448 512\" data-fa-i2svg=\"\">
                                                                <path fill=\"currentColor\" d=\"M212.686 315.314L120 408l32.922 31.029c15.12 15.12 4.412 40.971-16.97 40.971h-112C10.697 480 0 469.255 0 456V344c0-21.382 25.803-32.09 40.922-16.971L72 360l92.686-92.686c6.248-6.248 16.379-6.248 22.627 0l25.373 25.373c6.249 6.248 6.249 16.378 0 22.627zm22.628-118.628L328 104l-32.922-31.029C279.958 57.851 290.666 32 312.048 32h112C437.303 32 448 42.745 448 56v112c0 21.382-25.803 32.09-40.922 16.971L376 152l-92.686 92.686c-6.248 6.248-16.379 6.248-22.627 0l-25.373-25.373c-6.249-6.248-6.249-16.378 0-22.627z\"></path>
                                                            </svg><!-- <i class=\"fa fa-fw fa-expand-alt fa-sm mr-1\"></i> Font Awesome fontawesome.com --> Logo size</label>
                                                        <input id=\"qr_code_logo_size\" type=\"range\" min=\"5\" max=\"35\" name=\"qr_code_logo_size\" value=\"100\" class=\"form-control\" data-reload-qr-code=\"\">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type=\"submit\" name=\"submit\" id=\"submit\" style=\"display: none;\" class=\"btn btn-block btn-primary mt-4\">" . l('qr_step_3.create') . "</button>";

            if ($userId != '') {
                $response .= "
                                                                    <button type=\"submit\" name=\"submit2\" id=\"submit2\" style=\"display: none;\" class=\"btn btn-block btn-primary mt-4\">" . l('qr_step_3.create') . "</button>";
            } else {
                if (settings()->users->register_is_enabled) :
                    $response .= "<a href=\"" . url('register') . "\" style=\"display: none;\" class=\"btn btn-block btn-outline-primary mt-4\"><i class=\"fa fa-fw fa-xs fa-plus mr-1\"></i> " . l('qr_register') . "</a>";
                endif;
            }
            $response .= "
                                                            </div>";

            $response .= "</div>
                            </form>
                        </div>
                    </div>
                    <div class=\"mt-5\">
                        " . $viewcontent . "
                    </div>
                </div>
            ";
        }

        return Response::jsonapi_success($response, null, 200);
    }

    private function changeQrname()
    {

        if (!empty($_POST['qr_code_id']) && !empty($_POST['user_id'])) {

            // $qr_code_id = $_POST['qr_code_id'];
            $user_id = $_POST['user_id'];
            $qr_code_id = $_POST['qr_code_id'];
            $name = str_replace(' ', '', $_POST['qr_code_name']) ?? 'Untitled';
            $query = "UPDATE `qr_codes` SET `name` = '$name' WHERE `user_id` = $user_id AND `qr_code_id` = $qr_code_id LIMIT 1;";
            $qr_code = database()->query($query);
            $affected_rows = database()->affected_rows;
            $response = ['result' => 'success', 'data' => ['message' => 'Qr name updated successfully!', 'affected_rows' => $affected_rows, '$query' => 'stopeddddd$query']];
        } else {
            $response = ['result' => 'failed', 'data' => ['message' => 'Something went wrong!!']];
        }

        return Response::jsonapi_success($response, null, 200);
    }

    private function makeProjectDeleted()
    {
        if (!empty($_POST['projectId']) && !empty($_POST['user_id'])) {

            $user_id = $_POST['user_id'];
            $projectId = $_POST['projectId'];

            $query = "DELETE FROM `projects` WHERE `user_id` = $user_id AND `project_id` = $projectId";
            $qr_code = database()->query($query);
            $response = ['result' => 'success', 'data' => ['message' => 'Folder Deleted successfully!']];
        } else {
            $response = ['result' => 'failed', 'data' => ['message' => 'Something went wrong!!']];
        }

        return Response::jsonapi_success($response, null, 200);
    }

    public function save_qr_code()
    {

        $_POST['qr_code'] = $_REQUEST['qr_code'];
        $_POST['userIdAjax'] = $_REQUEST['userIdAjax'];

        // New QR Code Creation
        if (empty(trim($_REQUEST['qr_code_id']))) {

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

            /* Team checks */
            if (\Altum\Teams::is_delegated() && !\Altum\Teams::has_access('create')) {
                Alerts::add_info(l('global.info_message.team_no_access'));
                redirect('qr-codes');
            }

            /* Check for the plan limit */
            $total_rows = database()->query("SELECT COUNT(*) AS `total` FROM `qr_codes` WHERE `user_id` = {$_POST['userIdAjax']}")->fetch_object()->total ?? 0;

            $total_rows_name = database()->query("SELECT COUNT(*) AS `total` FROM `qr_codes` WHERE `user_id` = {$_POST['userIdAjax']} AND `name` LIKE '%My QR Code%' AND `status` != '3'")->fetch_object()->total ?? 0;

            $rawQuery = "SELECT * FROM `users` WHERE `user_id` = {$_POST['userIdAjax']}";
            $query = database()->query($rawQuery);
            $user_data = $query->fetch_all(MYSQLI_ASSOC);
            $plan_settings = json_decode($user_data[0]['plan_settings'], true);

            if ($plan_settings['qr_codes_limit'] != -1 && $total_rows >= $plan_settings['qr_codes_limit']) {
                Alerts::add_info(l('global.info_message.plan_feature_limit'));
                redirect('qr-codes');
            }

            $qr_code_settings = require APP_PATH . 'includes/qr_code.php';
            /* Existing projects */
            $projects = (new \Altum\Models\Projects())->get_projects_by_user_id($_POST['userIdAjax']);

            $settings = [
                'style' => 'square',
                'foreground_type' => 'color',
            ];

            if ($_POST['uId']) {
                $uId = $_POST['uId'];
            } else {
                $uId = uniqid();
            }

            // $_POST['welcomescreen'] = "";
            if (isset($_FILES['screen']) && $_FILES['screen']['name'] != '') {
                $filescreen = $_FILES['screen']['name'];
                $uploadUniqueId = $_POST['uploadUniqueId'];
                $screenFileExtension = pathinfo($_FILES["screen"]["name"], PATHINFO_EXTENSION);
                $_POST['welcomescreen'] = UPLOADS_FULL_URL . 'screen/' . $uId . '_welcome_' . $uploadUniqueId . '.' . $screenFileExtension;
            }

            if (!empty($_POST)) {
                $required_fields = ['type'];

                if (isset($_POST['url'])) {
                    $_POST['url'] = trim(urldecode($_POST['url']));
                }

                $_POST['name'] = (isset($_POST['name']) && $_POST['name'] != "") ? trim(Database::clean_string($_POST['name'])) : "";

                if ($_POST['name'] == "") {
                    $n_i = $total_rows_name + 1;
                    do {
                        $name = "My QR Code " . ($n_i);
                        $total_rows_name_check = database()->query("SELECT COUNT(*) AS `total` FROM `qr_codes` WHERE `user_id` = {$_POST['userIdAjax']} AND `name` = '$name' AND `status` != '3'")->fetch_object()->total ?? 0;
                        $n_i++;
                        $_POST['name'] = $name;
                    } while ($total_rows_name_check != 0);
                }

                $_POST['project_id'] = !empty($_POST['project_id']) && array_key_exists($_POST['project_id'], $projects) ? (int) $_POST['project_id'] : null;
                $_POST['type'] = isset($_POST['type']) && array_key_exists(trim($_POST['type']), $qr_code_settings['type']) ? $_POST['type'] : 'text';
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

                $_POST['qr_code_logo'] = !empty($_FILES['qr_code_logo']['name']) && !isset($_POST['qr_code_logo_remove']);

                if ($_POST['qr_code_logo'] == "") {
                    $_POST['qr_code_logo'] = (isset($_POST['edit_QR_code_logo']) && $_POST['edit_QR_code_logo'] != "") ? $_POST['edit_QR_code_logo'] : "";
                }

                $settings['qr_code_logo_size'] = $_POST['qr_code_logo_size'] = isset($_POST['qr_code_logo_size']) && in_array($_POST['qr_code_logo_size'], range(5, 35)) ? (int) $_POST['qr_code_logo_size'] : 25;

                $settings['size'] = $_POST['size'] = isset($_POST['size']) && in_array($_POST['size'], range(50, 2000)) ? (int) $_POST['size'] : 500;
                $settings['margin'] = $_POST['margin'] = isset($_POST['margin']) && in_array($_POST['margin'], range(0, 25)) ? (int) $_POST['margin'] : 1;
                $settings['ecc'] = $_POST['ecc'] = isset($_POST['ecc']) && in_array($_POST['ecc'], ['L', 'M', 'Q', 'H']) ? $_POST['ecc'] : 'M';

                /* Type dependant vars */
                switch (trim($_POST['type'])) {
                    case 'text':
                        $required_fields[] = 'text';
                        $settings['text'] = $_POST['text'] = mb_substr(input_clean($_POST['text']), 0, $qr_code_settings['type']['text']['max_length']);
                        break;

                    case 'url':
                        $required_fields[] = 'url';
                        $settings['url'] = $_POST['url'] = mb_substr(input_clean(trim($_POST['url'])), 0, $qr_code_settings['type']['url']['max_length']);

                        break;

                    case 'pdf':
                        $settings['url'] = LANDING_PAGE_URL . "p/{$uId}";
                        $_POST['files'][] = isset($_FILES['pdf']['name']);
                        $_POST['pdf'] = SITE_URL . "uploads/pdf/" . $uId . '.pdf';

                        break;

                    case 'images':
                        $settings['url'] = LANDING_PAGE_URL . "p/{$uId}";
                        break;

                    case 'mp3':
                        $settings['url'] = LANDING_PAGE_URL . "p/{$uId}";
                        break;

                    case 'app':
                        $uId = $_POST['uId'];
                        $_POST['url'] = LANDING_PAGE_URL . "p/{$uId}";
                        $data = $_POST['url'];

                        break;

                    case 'video':
                        // $required_fields[] = 'pdf';
                        $settings['url'] = LANDING_PAGE_URL . "p/{$uId}";
                        $all_video = array();
                        if (isset($_FILES['file_storage'])) {
                            $file_ary = reArrayFiles($_FILES['video_file']);
                            $index = 0;
                            foreach ($file_ary as $file) {
                                array_push($all_video, SITE_URL . 'uploads/video/' . $uId . '_' . $index . '_' . $file['name']);
                                $index++;
                            }

                            $_POST['video'] = $all_video;
                        }
                        break;

                    case 'menu':
                        $settings['url'] = LANDING_PAGE_URL . "p/{$uId}";
                        break;

                    case 'business':
                        $settings['url'] = LANDING_PAGE_URL . "p/{$uId}";
                        break;

                    case 'vcard':
                        $settings['url'] = LANDING_PAGE_URL . $uId;
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
                        $settings['wifi_encryption'] = $_POST['wifi_encryption'] = isset($_POST['wifi_encryption']) && in_array($_POST['wifi_encryption'], ['nopass', 'WEP', 'WPA/WPA2']) ? $_POST['wifi_encryption'] : 'nopass';
                        $settings['wifi_password'] = $_POST['wifi_password'] = mb_substr(input_clean($_POST['wifi_password']), 0, $qr_code_settings['type']['wifi']['password']['max_length']);
                        $settings['wifi_is_hidden'] = $_POST['wifi_is_hidden'] = (int) isset($_POST['wifi_is_hidden']);
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
                }

                /* Check for any errors */

                foreach ($required_fields as $field) {

                    if (!$field == 'pdf' && !isset($_POST[$field]) || (isset($_POST[$field]) && empty($_POST[$field]) && $_POST[$field] != '0')) {
                        // print "-------------E1-------------------------------------------------------" . $field;
                        Alerts::add_field_error($field, l('global.error_message.empty_field'));
                    }
                }

                if (!Csrf::check()) {
                    // print "-------------E2-------------------------------------------------------";

                    Alerts::add_error(l('global.error_message.invalid_csrf_token'));
                }

                $qr_code_logo = \Altum\Uploads::process_upload(null, 'qr_codes/logo', 'qr_code_logo', 'qr_code_logo_remove', $qr_code_settings['qr_code_logo_size_limit']);

                if (!Alerts::has_field_errors() && !Alerts::has_errors()) {
                    $qr_code = null;
                    // print "-------------E11-new-------------------------------------------------------" . Alerts::has_field_errors();

                    /* QR code image */
                    if ($_POST['qr_code']) {
                        $_POST['qr_code'] = base64_decode(mb_substr($_POST['qr_code'], mb_strlen('data:image/svg+xml;base64,')));

                        $scannableQrUid = LANDING_PAGE_URL . $_POST['uId'];
                        $scannableQrCode = (new QrCode())->GenerateQrWithFrame(json_decode(json_encode($_POST)), $scannableQrUid, $qr_code_logo);

                        $uId = $_POST['uId'];
                        /* Generate new name for image */
                        $image_new_name = $uId . '.svg';

                        /* Offload uploading */
                        if (\Altum\Plugin::is_active('offload') && settings()->offload->uploads_url) {
                            try {
                                $s3 = new \Aws\S3\S3Client(get_aws_s3_config());

                                /* Upload image */
                                $result = $s3->putObject([
                                    'Bucket' => settings()->offload->storage_name,
                                    'Key' => 'uploads/qr_codes/logo/' . $image_new_name,
                                    'ContentType' => 'image/svg+xml',
                                    'Body' => $_POST['qr_code'],
                                    'ACL' => 'public-read',
                                ]);
                            } catch (\Exception $exception) {
                                Alerts::add_error($exception->getMessage());
                            }
                        }

                        /* Local uploading */ else {
                            /* Upload the original */
                            file_put_contents(UPLOADS_PATH . 'qr_codes/logo' . '/' . $image_new_name, $scannableQrCode);
                        }
                        $qr_code = $image_new_name;
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
                    // exit;
                    /* Database query */
                    try {
                        $insertData = [
                            'user_id'      => $_POST['userIdAjax'],
                            'link_id'      => $_POST['link_id'] ?? null,
                            'project_id'   => $_POST['project_id'],
                            'name'         => $_POST['name'],
                            'type'         => $_POST['type'],
                            'status'       => '5',
                            'qr_code'      => $qr_code,
                            'qr_code_logo' => $qr_code_logo,
                            'datetime'     => \Altum\Date::$date,
                            'uId'          => $uId,
                            'data'         => $json_data,

                        ];
                        $qr_code_id_inserted = db()->insert('qr_codes', $insertData);
                    } catch (\Exception $e) {
                        print $e->getMessage();
                        Alerts::add_error($e->getMessage());
                    }

                    // echo $qr_code_id_inserted;
                    // exit;
                    return Response::jsonapi_success($qr_code_id_inserted, $uId, 200);
                }
            } else {
                return Response::jsonapi_success('', null, 400);
            }
        }
        //QR Code Update
        else {
            $qr_code_id = isset($_REQUEST['qr_code_id']) ? (int) ($_REQUEST['qr_code_id']) : null;

            if (!$qr_code = db()->where('qr_code_id', $qr_code_id)->where('user_id', $_POST['userIdAjax'])->getOne('qr_codes')) {
                redirect('qr-codes');
            }
            $qr_code->settings = json_decode($qr_code->settings);
            $qrDatas = json_decode($qr_code->data, true);



            // print_r($qrDatas);

            $qr_code_settings = require APP_PATH . 'includes/qr_code.php';

            /* Existing projects */
            $projects = (new \Altum\Models\Projects())->get_projects_by_user_id($_POST['userIdAjax']);

            /* Check for the plan limit */
            $total_rows = database()->query("SELECT COUNT(*) AS `total` FROM `qr_codes` WHERE `user_id` = {$_POST['userIdAjax']}")->fetch_object()->total ?? 0;

            $total_rows_name = database()->query("SELECT COUNT(*) AS `total` FROM `qr_codes` WHERE `user_id` = {$_POST['userIdAjax']} AND `name` LIKE '%My QR Code%' AND `status` != '3' AND `qr_code_id` != '$qr_code_id'")->fetch_object()->total ?? 0;

            if (!empty($_POST)) {
                $required_fields = ['type'];
                $settings = [];
                $_POST['files'] = array();

                // $_POST['welcomescreen'] = "";
                if (isset($_FILES['screen']) && $_FILES['screen']['name'] != "") {
                    $filescreen = $_FILES['screen']['name'];
                    $uploadUniqueId = $_POST['uploadUniqueId'];
                    $screenFileExtension = pathinfo($_FILES["screen"]["name"], PATHINFO_EXTENSION);
                    $_POST['welcomescreen'] = UPLOADS_FULL_URL . 'screen/' . $qr_code->uId . '_welcome_' . $uploadUniqueId . '.' . $screenFileExtension;
                }


                $_POST['name'] = (isset($_POST['name']) && $_POST['name'] != "") ? trim(Database::clean_string($_POST['name'])) : "";
                if ($_POST['name'] == "") {
                    $n_i = $total_rows_name + 1;
                    do {
                        $name = "My QR Code " . ($n_i);
                        $total_rows_name_check = database()->query("SELECT COUNT(*) AS `total` FROM `qr_codes` WHERE `user_id` = {$_POST['userIdAjax']} AND `name` = '$name' AND `status` != '3'")->fetch_object()->total ?? 0;
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

                $_POST['qr_code_logo'] = !empty($_FILES['qr_code_logo']['name']) && !isset($_POST['qr_code_logo_remove']);

                if ($_POST['qr_code_logo'] == "") {
                    $_POST['qr_code_logo'] = (isset($_POST['edit_QR_code_logo']) && $_POST['edit_QR_code_logo'] != "") ? $_POST['edit_QR_code_logo'] : "";
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

                        break;
                    case 'pdf':

                        $settings['url'] = LANDING_PAGE_URL . (isset($uId) ? "s/{$uId}" : '');
                        $_POST['files'][0] = isset($_FILES['pdf']['error']) && $_FILES['pdf']['error'] === UPLOAD_ERR_OK
                            ? $_FILES['pdf']['name']
                            : (isset($qrDatas['files'][0]) ? $qrDatas['files'][0] : '');



                        $_POST['pdf'] = SITE_URL . "uploads/pdf/" . isset($uId) . '.pdf';

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
                        $settings['wifi_encryption'] = $_POST['wifi_encryption'] = isset($_POST['wifi_encryption']) && in_array($_POST['wifi_encryption'], ['nopass', 'WEP', 'WPA/WPA2']) ? $_POST['wifi_encryption'] : 'nopass';
                        $settings['wifi_password'] = $_POST['wifi_password'] = mb_substr(input_clean($_POST['wifi_password']), 0, $qr_code_settings['type']['wifi']['password']['max_length']);
                        $settings['wifi_is_hidden'] = $_POST['wifi_is_hidden'] = (int) isset($_POST['wifi_is_hidden']);
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

                        break;
                    case 'menu':

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
                }

                //ALTUMCODE:DEMO if(DEMO) if($this->user->user_id == 1) Alerts::add_error('Please create an account on the demo to test out this function.');

                /* Check for any errors */
                foreach ($required_fields as $field) {
                    if (!isset($_POST[$field]) || (isset($_POST[$field]) && empty($_POST[$field]) && $_POST[$field] != '0')) {
                        Alerts::add_field_error($field, l('global.error_message.empty_field'));
                    }
                }

                if (!Csrf::check()) {
                    Alerts::add_error(l('global.error_message.invalid_csrf_token'));
                }

                $qr_code->qr_code_logo = \Altum\Uploads::process_upload($qr_code->qr_code_logo, 'qr_codes/logo', 'qr_code_logo', 'qr_code_logo_remove', 1);

                if (!Alerts::has_field_errors() && !Alerts::has_errors()) {
                    /* QR code image */
                    if ($_POST['qr_code']) {

                        $_POST['qr_code'] = base64_decode(mb_substr($_POST['qr_code'], mb_strlen('data:image/svg+xml;base64,')));

                        $scannableQrUid = LANDING_PAGE_URL . $_POST['uId'];
                        $scannableQrCode = (new QrCode())->GenerateQrWithFrame(json_decode(json_encode($_POST)), $scannableQrUid, $qr_code->qr_code_logo);

                        /* Generate new name for image */
                        $uId = $_POST['uId'];
                        $image_new_name = $uId . '.svg';

                        /* Offload uploading */
                        if (\Altum\Plugin::is_active('offload') && settings()->offload->uploads_url) {
                            try {
                                $s3 = new \Aws\S3\S3Client(get_aws_s3_config());

                                /* Delete current image */
                                $s3->deleteObject([
                                    'Bucket' => settings()->offload->storage_name,
                                    'Key' => 'uploads/qr_codes/logo/' . $qr_code->qr_code,
                                ]);

                                /* Upload image */
                                $result = $s3->putObject([
                                    'Bucket' => settings()->offload->storage_name,
                                    'Key' => 'uploads/qr_codes/logo/' . $image_new_name,
                                    'ContentType' => 'image/svg+xml',
                                    'Body' => $_POST['qr_code'],
                                    'ACL' => 'public-read',
                                ]);
                            } catch (\Exception $exception) {
                                Alerts::add_error($exception->getMessage());
                            }
                        }

                        /* Local uploading */ else {
                            /* Delete current image */
                            if (!empty($qr_code->qr_code) && file_exists(UPLOADS_PATH . 'qr_codes/logo' . '/' . $qr_code->qr_code)) {
                                unlink(UPLOADS_PATH . 'qr_codes/logo' . '/' . $qr_code->qr_code);
                            }

                            /* Upload the original */
                            file_put_contents(UPLOADS_PATH . 'qr_codes/logo' . '/' . $image_new_name, $scannableQrCode);
                        }

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
                    $settings = json_encode($settings);

                    // print_r($_POST);
                    // exit;

                    /* Database query */
                    db()->where('qr_code_id', $qr_code->qr_code_id)->update('qr_codes', [
                        'project_id'        => $qr_code->project_id,
                        'link_id'           => isset($_POST['link_id']) ? $_POST['link_id'] : null,
                        'name'              => $_POST['name'],
                        'type'              => $_POST['type'],
                        'qr_code'           => $qr_code->qr_code,
                        'qr_code_logo'      => $qr_code->qr_code_logo,
                        'last_datetime'     => \Altum\Date::$date,
                        'data'              => $json_data

                    ]);


                    /* Set a nice success message */
                    return Response::jsonapi_success($qr_code_id, '',  200);
                }
            } else {
                // return Response::jsonapi_success('', null, 400);
            }
        }
    }



    public function getImageRatio()
    {

        $svg = simplexml_load_file($_POST['link']);



        if ((int) $svg['width'] > 0) {
            $width = (int) $svg['width'];
            $height = (int) $svg['height'];
        } else {

            $viewbox = $svg['viewBox'];
            $array = explode(' ', $viewbox);
            $width = (int) $array[2];
            $height = (int) $array[3];
        }

        $ratio = (int) $height / $width;

        $width = $_POST['size'];
        $height =  $_POST['size'] * $ratio;

        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $_POST['name'])));

        $name = $slug . '-' . $_POST['size'] . '.' . $_POST['type'];


        return Response::jsonapi_success(
            [
                'width' => $width,
                'height' => $height,
                'name' => $name,
            ],
            null,
            200
        );
    }



    public function hideDownloadModel()
    {
        $user_id = $_POST['user_id'];
        $first_qr = db()->where('user_id', $user_id)->update('users', [
            'is_first_qr' => true
        ]);
        if ($first_qr) {
            return Response::jsonapi_success(["status" => true], null, 200);
        }
        return Response::jsonapi_success(["status" => false], null, 500);
    }
    public function svgResize()
    {

        $origialSvg = $_POST['svgPath'];
        $width = $_POST['width'];
        $height = $_POST['height'];
        $tempName = $_POST['tmpName'];

        $dom = new DOMDocument('1.0', 'utf-8');
        $dom->loadXML(file_get_contents($origialSvg));
        $svg = $dom->documentElement;

        if (!$svg->hasAttribute('viewBox')) { // viewBox is needed to establish
            // userspace coordinates
            $pattern = '/^(\d*\.\d+|\d+)(px)?$/'; // positive number, px unit optional

            $interpretable =  preg_match($pattern, $svg->getAttribute('width'), $width) &&
                preg_match($pattern, $svg->getAttribute('height'), $height);

            if ($interpretable) {
                $view_box = implode(' ', [0, 0, $width, $height]);
                $svg->setAttribute('viewBox', $view_box);
            } else { // this gets sticky
                return Response::jsonapi_success("viewBox is dependent on environment", null, 500);
            }
        }
        $svg->setAttribute('width', $width);
        $svg->setAttribute('height', $height);

        $dom->save(UPLOADS_PATH . 'temp/' . $tempName . '.svg');

        return Response::jsonapi_success(['fileName' => "$tempName.svg", "path" => url('uploads/temp') . "/$tempName.svg"], null, 200);
    }


    public function clearTempSvg()
    {
        $file_name = $_POST['fileName'];
        if (!empty($_POST['type']) && isset($_POST['type']) && $_POST['type'] === 'folder') {
            if (array_map('unlink', glob("uploads/temp/$file_name/*.*"))) {
                if (rmdir("uploads/temp/$file_name")) {;
                    return Response::jsonapi_success(['status' => true, 'reason' => 'Done'], null, 200);
                } else {
                    return Response::jsonapi_success(['status' => false, 'reason' => 'Failed to Remove Folder.'], null, 500);
                }
            } else {
                return Response::jsonapi_success(['status' => false, 'reason' => 'Unknown Folder Name or Something went wrong!'], null, 500);
            }
        } else {
            $filePath = "uploads/temp/$file_name";
            if (file_exists($filePath)) {
                if (unlink($filePath)) {
                    return Response::jsonapi_success(['status' => true, 'reason' => 'Done'], null, 200);
                } else {
                    return Response::jsonapi_success(['status' => false, 'reason' => 'Unknown File Name or Something went wrong!'], null, 500);
                }
            } else {
                return Response::jsonapi_success(['status' => false, 'reason' => 'Unknown File Name or Something went wrong!'], null, 500);
            }
        }
    }

    public function hideFeedbackBanner()
    {
        $user_id = $_POST['user_id'];
        $u = db()->where('user_id', $user_id)->update('users', [
            'is_review' => true
        ]);
        if ($u) {
            return Response::jsonapi_success('', null, 200);
        }
        return Response::jsonapi_success('', null, 500);
    }


    // Convert SVG images to PNG,JPEG,EPS & PDF formats

    public function convertSvg()
    {
        $s3 = new \Aws\S3\S3Client(get_aws_s3_config());

        $svgUrl = $_POST['link'];
        $fileName = $_POST['name'];
        $type = $_POST['type'];
        $qrId = $_POST['qrId'];
        $height = $_POST['height'];
        $width = $_POST['width'];
        $quality = 0;
        $outputPath = UPLOADS_FULL_URL . 'share-folder/' . $qrId . '.' . (($type == "print") ? "png" : $type);

        $key = 'uploads/share-folder/' . $qrId . '.' . (($type == "print") ? "png" : $type);

        try {
            // Verify directory exists and has write permissions
            $directory = 'uploads/share-folder/';
            if (!is_dir($directory) || !is_writable($directory)) {
                mkdir($directory, 0777);
                // throw new Exception('The output directory is not writable.');
            }

            $svgContents = file_get_contents($svgUrl);

            if ($svgContents === false) {
                throw new Exception('Failed to read SVG file.');
            }

            if ($type == "png" || $type == 'print') {

                $imagick = new \Imagick();
                $imagick->setBackgroundColor(new \ImagickPixel('transparent'));
                $imagick->readImageBlob($svgContents);
                $imagick->resizeImage($type == 'print' ? '1024' : $width, $type == 'print' ? '1024' : $height, \Imagick::FILTER_SINC, 0, true);
                $imagick->setImageCompression(\Imagick::COMPRESSION_NO);
                $imagick->setCompressionQuality(75);
                $imagick->setImageFormat("png32");
            } elseif ($type == "jpeg") {

                $imagick = new \Imagick();
                $imagick->setBackgroundColor('#FFFFFF');
                $imagick->readImageBlob($svgContents);
                $imagick->resizeImage($width, $height, \Imagick::FILTER_SINC, 0, true);
                $imagick->setImageCompression(\Imagick::COMPRESSION_NO);
                $imagick->setCompressionQuality($quality);
                $imagick->setImageFormat("jpeg");
            }

            if ($type == "eps") {
                $qrData = "SELECT * FROM `qr_codes` WHERE `qr_code_id` = $qrId";
                $qr_result = database()->query($qrData);
                $qrCodeData = $qr_result->fetch_assoc();

                /* Upload the original */
                $settings = json_decode($qrCodeData['data']);

                $url = LANDING_PAGE_URL . $fileName;
                $data = $url;

                $qr = new Generator;
                $qr->size($width);
                $qr->errorCorrection($settings->ecc);
                $qr->encoding('UTF-8');
                $qr->margin($settings->margin);
                $qr->style($settings->style, 0.9);

                $qr->eye(\BaconQrCode\Renderer\Module\EyeCombiner::instance($settings->cEye, $settings->fEye));


                $settings->foreground_type = isset($settings->foreground_type)  ? $settings->foreground_type : 'color';
                $settings->background_type = isset($settings->background_type)  ? $settings->background_type : 'color';


                $qr->backgroundColor(0, 0, 0, 0);


                /* Generate the first SVG */
                try {
                    $qr->format('eps');
                    $svg = $qr->generate($data);

                    if (OFFLOAD_PROVIDER == 'local') {
                        file_put_contents(UPLOADS_PATH . 'share-folder/' . $qrId . '.eps', $svg);
                    } else {
                        try {
                            $s3->putObject([
                                'Bucket' => OFFLOAD_BUCKET,
                                'Key' =>  'uploads/share-folder/' . $qrId . '.eps', $svg,
                                'ContentType' => 'application/postscript',
                                'Body' => $svg,
                                'ACL' => 'public-read',
                            ]);
                        } catch (\Exception $exception) {
                            Alerts::add_error($exception->getMessage());
                        }
                    }

                    // Response::json($svg, $uId . '.pdf', 'error');
                } catch (\Exception $exception) {
                    Response::json($exception->getMessage(), 'error');
                }

                return Response::jsonapi_success(
                    UPLOADS_FULL_URL . '/' . 'share-folder/' . $qrId . '.eps',
                    null,
                    200
                );
            }

            if ($type == 'pdf') {

                $PDF_SIZES = [
                    'A4' => '210x297',
                    'A3' => '297x420',
                    'A2' => '420x594',
                    'A1' => '594x841',
                    'A0' => '841x1189'
                ];

                $svg = file_get_contents($svgUrl);

                $imagick = new \Imagick();
                $imagick->setBackgroundColor(new \ImagickPixel('transparent'));
                $imagick->readImageBlob($svg);
                $imagick->resizeImage(1024, 1024, \Imagick::FILTER_BOX, 1, true);
                // $imagick->setImageCompression(\Imagick::COMPRESSION_NO);
                // $imagick->setCompressionQuality($quality);
                $imagick->setImageFormat("png32");

                file_put_contents(UPLOADS_PATH . 'share-folder/test.png', $imagick);

                $jpegFile = $imagick->getImagesBlob();


                $base64_svg = base64_encode($jpegFile);

                $iwidth = 600;
                $iheight = 600;

                $dompdf = new Dompdf(["chroot" => __DIR__, 'debugLayout' => false]);

                $dompdf->setPaper(array_search($height . 'x' . $width, $PDF_SIZES), 'portrait');

                $marginX = ($dompdf->getPaperSize()[2] - $iwidth) / 2;
                $marginY = ($dompdf->getPaperSize()[3] - $iheight) / 2;

                $html = '<img 
                    src="data:image/jpeg;base64,' . $base64_svg . '"  
                    width="' . $iwidth . 'px" 
                    height="' . $iheight . 'px"
                    style="margin-left: ' . $marginX + 40 . 'px; margin-top: ' . $marginY + 40 . 'px;"
                />';

                $dompdf->loadHtml($html);

                $dompdf->render();
                $pdf_content = $dompdf->output();
            }


            // Save image to local directory or digital ocean spaces
            if (OFFLOAD_PROVIDER == 'local') {
                if ($type == 'pdf') {
                    file_put_contents(UPLOADS_PATH . 'share-folder/' . $qrId . '.pdf', $pdf_content);
                } else {
                    file_put_contents(UPLOADS_PATH . 'share-folder/' . $qrId . '.' . (($type == "print") ? "png" : $type), $imagick->getImagesBlob());
                }
            } else {
                try {

                    if ($type == 'pdf') {

                        $s3->putObject([
                            'Bucket' => OFFLOAD_BUCKET,
                            'Key' =>  $key,
                            'ContentType' => 'application/pdf',
                            'Body' =>  $pdf_content,
                            'ACL' => 'public-read',
                        ]);
                    } else {

                        switch ($type) {
                            case 'png':
                                $mime_type = 'image/png';
                                break;
                            case 'jpeg':
                                $mime_type = 'image/jpeg';
                                break;
                            case 'print':
                                $mime_type = 'image/png';
                                break;
                            default:
                        }

                        $s3->putObject([
                            'Bucket' => OFFLOAD_BUCKET,
                            'Key' =>  $key,
                            'ContentType' =>  $mime_type,
                            'Body' =>  $imagick->getImagesBlob(),
                            'ACL' => 'public-read',
                        ]);
                    }
                } catch (\Exception $exception) {
                    Alerts::add_error($exception->getMessage());
                }
            }

            return Response::jsonapi_success(
                $outputPath,
                null,
                200
            );
        } catch (\ImagickException $e) {

            return Response::jsonapi_error($e->getMessage(), $e->getCode());
        } catch (Exception $e) {

            return Response::jsonapi_error($e->getMessage());
        }
    }

    public function bulkShare()
    {
        $qrImages = $_POST['files'];
        $type = $_POST['type'];

        $outputPath = '';
        $outputPathsArray = array();
        $key = '';

        $min = 100000;
        $max = 500000;

        $s3 = new \Aws\S3\S3Client(get_aws_s3_config());

        try {
            $directory = 'uploads/share-folder/';
            if (!is_dir($directory) || !is_writable($directory)) {
                mkdir($directory, 0777);
            }

            if ($type == "png" || $type == "print") {
                foreach ($qrImages as $qrImage) {
                    $imagick = new \Imagick();
                    $imagick->setBackgroundColor(new \ImagickPixel('transparent'));
                    $imagick->readImageBlob(file_get_contents($qrImage));
                    $imagick->resizeImage('1024', '1024', \Imagick::FILTER_SINC, 0, true);
                    $imagick->setImageFormat("png32");

                    $randomNumber = mt_rand($min, $max);
                    $outputPath = UPLOADS_FULL_URL . 'share-folder/' . $randomNumber . '.' . (($type == "print") ? "png" : $type);
                    $key = 'uploads/share-folder/' . $randomNumber . '.' . (($type == "print") ? "png" : $type);
                    array_push($outputPathsArray, $outputPath);

                    if (OFFLOAD_PROVIDER == 'local') {
                        file_put_contents(UPLOADS_PATH . 'share-folder/' . $randomNumber . '.' . (($type == "print") ? "png" : $type), $imagick->getImagesBlob());
                    } else {
                        $s3->putObject([
                            'Bucket' => OFFLOAD_BUCKET,
                            'Key' =>  $key,
                            'ContentType' =>  'image/png',
                            'Body' =>  $imagick->getImagesBlob(),
                            'ACL' => 'public-read',
                        ]);
                    }
                }
            }
            if ($type == "jpeg") {
                foreach ($qrImages as $qrImage) {
                    $imagick = new \Imagick();
                    $imagick->setBackgroundColor('#FFFFFF');
                    $imagick->readImageBlob(file_get_contents($qrImage));
                    $imagick->resizeImage('1024', '1024', \Imagick::FILTER_SINC, 0, true);
                    $imagick->setImageFormat("jpeg");

                    $randomNumber = mt_rand($min, $max);
                    $outputPath = UPLOADS_FULL_URL . 'share-folder/' . $randomNumber . '.' . $type;
                    $key = 'uploads/share-folder/' . $randomNumber . '.' . (($type == "print") ? "png" : $type);
                    array_push($outputPathsArray, $outputPath);

                    if (OFFLOAD_PROVIDER == 'local') {
                        file_put_contents(UPLOADS_PATH . 'share-folder/' . $randomNumber . '.' . $type, $imagick->getImagesBlob());
                    } else {
                        $s3->putObject([
                            'Bucket' => OFFLOAD_BUCKET,
                            'Key' =>  $key,
                            'ContentType' =>  'image/jpeg',
                            'Body' =>  $imagick->getImagesBlob(),
                            'ACL' => 'public-read',
                        ]);
                    }
                }
            }
            if ($type == "pdf") {

                $htmlTemplate = '<img 
                    src="data:image/jpeg;base64,%s"  
                    width="600px" 
                    height="600px"
                    style="margin-left: 40px; margin-top: 40px;"
                    />';

                foreach ($qrImages as $index => $qrImage) {

                    $dompdf = new Dompdf(["chroot" => __DIR__, 'debugLayout' => false]);

                    $svg = file_get_contents($qrImage);
                    $imagick = new \Imagick();
                    $imagick->setBackgroundColor(new \ImagickPixel('transparent'));
                    $imagick->readImageBlob($svg);
                    $imagick->resizeImage(1024, 1024, \Imagick::FILTER_BOX, 1, true);
                    $imagick->setImageFormat("png32");
                    $jpegFile = $imagick->getImagesBlob();
                    $base64_svg = base64_encode($jpegFile);

                    $dompdf->setPaper('A4', 'portrait');

                    $html = sprintf($htmlTemplate, $base64_svg);
                    $dompdf->loadHtml($html);
                    $dompdf->render();

                    $pdf_content = $dompdf->output();

                    $randomNumber = mt_rand($min, $max);
                    $outputPath = UPLOADS_FULL_URL . 'share-folder/' . $randomNumber . '_' . $index . '.' . $type;
                    $key = 'uploads/share-folder/' . $randomNumber . '.' . (($type == "print") ? "png" : $type);
                    array_push($outputPathsArray, $outputPath);

                    if (OFFLOAD_PROVIDER == 'local') {
                        file_put_contents(UPLOADS_PATH . 'share-folder/' . $randomNumber . '_' . $index . '.' . $type, $pdf_content);
                    } else {
                        $s3->putObject([
                            'Bucket' => OFFLOAD_BUCKET,
                            'Key' =>  $key,
                            'ContentType' =>  'application/pdf',
                            'Body' =>  $pdf_content,
                            'ACL' => 'public-read',
                        ]);
                    }
                }
            }
        } catch (\Throwable $th) {
        }


        return Response::jsonapi_success(
            $outputPathsArray,
            null,
            200
        );
    }

    function prepareSVG($originalSvg, $width, $height)
    {
        $dom = new DOMDocument('1.0', 'utf-8');
        $data = @file_get_contents($originalSvg);
        if ($data === false) {
            $data = file_get_contents(ASSETS_FULL_URL . 'images/404.svg');
        }
        $dom->loadXML($data);
        $svg = $dom->documentElement;

        if (!$svg->hasAttribute('viewBox')) {
            $pattern = '/^(\d*\.\d+|\d+)(px)?$/';
            $interpretable =  preg_match($pattern, $svg->getAttribute('width'), $width) &&
                preg_match($pattern, $svg->getAttribute('height'), $height);
            if ($interpretable) {
                $view_box = implode(' ', [0, 0, $width[0], $height[0]]);
                $svg->setAttribute('viewBox', $view_box);
            } else {
                // echo("viewBox is dependent on environment");
            }
        }
        $svg->setAttribute('width', $width);
        $svg->setAttribute('height', $height);
        $svg = $dom->saveXML($dom);
        return $svg;
    }

    function makeZipFile($tempFolder, $tempId)
    {
        $rootPath = realpath($tempFolder);

        $zip = new ZipArchive();
        $zip->open($tempFolder . ".zip", ZipArchive::CREATE | ZipArchive::OVERWRITE);

        /** @var SplFileInfo[] $files */
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($rootPath), RecursiveIteratorIterator::LEAVES_ONLY);
        foreach ($files as $name => $file) {
            if (!$file->isDir()) {
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($rootPath) + 1);
                $zip->addFile($filePath, $relativePath);
            }
        }
        $zip->close();

        array_map('unlink', glob("$tempFolder/*.*"));
        rmdir("$tempFolder");
    }

    function makeEPS($folder, $name, $settings, $width, $qrcontent)
    {
        $qr = new Generator;
        $qr->size($width);
        $qr->errorCorrection($settings->ecc);
        $qr->encoding('UTF-8');
        $qr->margin($settings->margin);
        $qr->style($settings->style, 0.9);

        $qr->eye(\BaconQrCode\Renderer\Module\EyeCombiner::instance($settings->cEye, $settings->fEye));


        $settings->foreground_type = isset($settings->foreground_type)  ? $settings->foreground_type : 'color';
        $settings->background_type = isset($settings->background_type)  ? $settings->background_type : 'color';

        try {
            $qr->format('eps');
            $svg = $qr->generate(LANDING_PAGE_URL . $qrcontent);
        } catch (\Exception $exception) {
            Response::json($exception->getMessage(), 'error');
        }

        file_put_contents("$folder/$name.eps", $svg);
    }

    public function convertSVGtoOthers()
    {
        dil('ssss');
        $tempId = time() . $_POST['user_id'];
        $tempFolder = 'uploads/temp/' . $tempId;
        $type = $_POST['type'];
        mkdir($tempFolder, 0777, true) || chmod($tempFolder, 0777);
        $fparr = [];

        if (is_array($_POST['qr_code_ids']) && isset($_POST['qr_code_ids']) && !empty($_POST['qr_code_ids'])) {

            foreach ($_POST['qr_code_ids'] as $key => $id) {
                $qrCodes = db()->where('qr_code_id', $id)->getOne('qr_codes', ['name', 'qr_code', 'data', 'uid']);
                $svgFilePath = url('uploads/qr_codes/logo/') . $qrCodes->qr_code;

                $newSvgPath = $tempFolder . "/" . str_replace(' ', '-', $qrCodes->name) . ".svg";
                $fileName = str_replace(' ', '-', $qrCodes->name);

                file_put_contents($newSvgPath, $this->prepareSVG($svgFilePath, 1024, 1024));

                // $customFontsDir = '/var/www/html/qr-new/themes/altum/assets/fonts';

                if ($type == 'png') {
                    $im = new \Imagick();
                    $im->readImage($newSvgPath);
                    $im->setBackgroundColor(new \ImagickPixel('transparent'));
                    $im->setImageFormat('png');

                    $im->writeImage("$tempFolder/$fileName.png");
                    unlink($newSvgPath);
                    $im->clear();
                    $im->destroy();
                }

                if ($type == 'jpeg' || $type == 'print' || $type == 'pdf') {
                    $im = new \Imagick();
                    $im->readImage($newSvgPath);
                    $im->setImageCompression(\Imagick::COMPRESSION_JPEG);
                    $im->setImageFormat("jpeg");
                    $im->writeImage("$tempFolder/$fileName.jpeg");
                    unlink($newSvgPath);
                    $im->clear();
                    $im->destroy();
                }

                if ($type == 'eps') {
                    $this->makeEPS($tempFolder, $fileName, json_decode($qrCodes->data), 1024, $qrCodes->uid);
                    unlink($newSvgPath);
                }

                if ($type == 'print' || $type == 'pdf') {
                    array_push($fparr, ['imgLink' => url("$tempFolder/$fileName.jpeg"), 'size' => 180]);
                }
            }


            db()->where('user_id', $_POST['user_id'])->update('users', [
                'is_download' => 1,
            ]);


            if ($type === 'pdf') {
                return Response::simple_json([
                    "jobId" => $tempId,
                    "ImageData" => $fparr,
                    "fileName" => $tempId . ".pdf"
                ], null, 200);
            } elseif ($type === 'print') {
                return Response::simple_json(['svg_paths' => $fparr], null, 200);
            } else {
                $this->makeZipFile($tempFolder, $tempId);
            }
        } else {
            return Response::jsonapi_success('No Qr Ids', null, 500);
        }

        return Response::simple_json([
            "link" => url($tempFolder) . ".zip",
            "filename" => $tempId . ".zip",
        ], null, 200);
    }

    public function shareEmailAttachment()
    {
        $recipient_email = $_POST['email'];
        $user_id = $_POST['user_id'];
        $user = db()->where('user_id', $user_id)->getOne('users');
        $is_bulk = $_POST['is_bulk'];
        $fileName = $_POST['qr_name'];

        if ($user) {
            $email_template =   [
                'subject' => $is_bulk == "false" ? "Your QR Code from Online QR Generator (" . $fileName . ")" : "Your QR Code from Online QR Generator",
                'body'    => [
                    'name'         =>  isset($user->name) ? str_replace('.', '. ', $user->name) : $user->email,
                    'user_id'      =>  $user_id,
                    'from_email'   =>  $user->email,
                    'is_bulk'      =>  $is_bulk,
                    'file_name'    =>  $fileName,
                    'files'        =>   $_FILES['file'],

                ],

            ];

            $isEmailSent = send_mail($recipient_email, $email_template['subject'], $email_template['body'], ['language' =>  $user->language, 'type' => 'share-qrcode']);

            if ($isEmailSent) {
                if ($is_bulk == "false") {
                    $qr_code_id = $_POST['qrId'];
                    $qr_uid     = $_POST['uid'];

                    db()->where('qr_code_id', $qr_code_id)->update('qr_codes', [
                        'is_download' => true,
                    ]);

                    db()->where('user_id', $user_id)->update('users', [
                        'is_download' => 1,
                    ]);
                }
                return Response::jsonapi_success('success', null, 200);
            } else {
                return Response::jsonapi_success('failed', null, 200);
            }
        } else {
            return Response::jsonapi_success('failed', null, 200);
        }
    }

    public function UpdateURL()
    {
        $userID = $_POST['user_id'];
        $qrID = $_POST['qr_id'];
        $newURL = $_POST['url'];

        $qrCodeDBData = db()->where('qr_code_id', $qrID)->getOne('qr_codes', ['data']);

        $qrCodeData = json_decode($qrCodeDBData->data);

        $qrCodeData->url = $newURL;

        $up = db()->where('qr_code_id', $qrID)->update('qr_codes', [
            'data' => json_encode($qrCodeData),
        ]);

        if ($up) {
            return Response::simple_json(['status' => true, 'message' => l('qr_codes.edit_url_modal.save_success_msg')], null, 200);
        } else {
            return Response::simple_json(['status' => false, 'message' => l('qr_codes.edit_url_modal.save_failed_msg')], null, 200);
        }
    }

    public function editUploadedImage()
    {
        $file            = $_FILES['file'];
        $tempPath        = $_FILES['file']['tmp_name'];
        $fileName        = $_POST['fileName'];
        $uploadDirectory = 'uploads/images/';
        $imageQuality    = 20;
        $targetPath      = $uploadDirectory . $fileName;
        $isUploaded      = false;
        $s3              = new \Aws\S3\S3Client(get_aws_s3_config());

        $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $key = 'uploads/images/' . $fileName;

        if (OFFLOAD_PROVIDER == 'local') {

            $isUploaded = move_uploaded_file($file['tmp_name'], $targetPath);
        } else {


            // Create a new image from file 
            switch ($_POST['mime']) {
                case 'image/jpeg':
                    $image = imagecreatefromjpeg($tempPath);
                    $orientation = isset(exif_read_data($tempPath)['Orientation']) ? exif_read_data($tempPath)['Orientation'] : null;
                    $rotatedImages = $this->rotateImages($image, $orientation);
                    imagejpeg($rotatedImages, $targetPath, $imageQuality);
                    break;
                case 'image/png':
                    $input_file = $tempPath;
                    // Compress the input image using pngquant
                    exec("pngquant --force --output \"$targetPath\" \"$input_file\"");
                    break;
                case 'image/gif':
                    $image = imagecreatefromgif($tempPath);
                    $orientation = isset(exif_read_data($tempPath)['Orientation']) ? exif_read_data($tempPath)['Orientation'] : null;
                    $rotatedImages = $this->rotateImages($image, $orientation);
                    imagejpeg($rotatedImages, $targetPath, $imageQuality);
                    break;
                case 'image/webp':

                    $image = imagecreatefromwebp($tempPath);
                    $orientation = isset(exif_read_data($tempPath)['Orientation']) ? exif_read_data($tempPath)['Orientation'] : null;
                    $rotatedImages = $this->rotateImages($image, $orientation);
                    imagewebp($rotatedImages, $targetPath, $imageQuality);

                    break;
                case 'image/svg+xml':
                    try {
                        $s3->putObject([
                            'Bucket' => OFFLOAD_BUCKET,
                            'Key' =>  $targetPath,
                            'ContentType' =>  'image/svg+xml',
                            'Body'   =>  file_get_contents($tempPath),
                            'ACL' => 'public-read',
                        ]);
                    } catch (\Exception $exception) {
                        Alerts::add_error($exception->getMessage());
                    }

                    break;
                default:
                    $image = imagecreatefromjpeg($tempPath);
            }

            if ($targetPath && ($_POST['mime'] != 'image/svg+xml')) {
                try {
                    /* Upload mp3 */
                    $s3->putObject([
                        'Bucket' => OFFLOAD_BUCKET,
                        'Key' =>  $key,
                        'ContentType' =>  $_POST['mime'],
                        'SourceFile'  => $targetPath,
                        'ACL' => 'public-read',
                    ]);
                } catch (\Exception $exception) {
                    Alerts::add_error($exception->getMessage());
                }
            }

            unlink($targetPath);
            $isUploaded =  true;
        }

        if ($isUploaded) {
            if (OFFLOAD_PROVIDER == 'local') {
                return Response::jsonapi_success(SITE_URL . $targetPath, null, 200);
            } else {
                return Response::jsonapi_success(OFFLOAD_FULL_ENDPOINT . $targetPath, null, 200);
            }
        } else {
            return Response::jsonapi_success("failed", null, 404);
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


    public function isDownload()
    {
        $userID = $_POST['user_id'];
        $user = db()->where('user_id', $userID)->getOne('users');

        if ($user) {

            db()->where('user_id', $userID)->update('users', [
                'is_download' => 1,
            ]);

            return Response::jsonapi_success('success', null, 200);
        } else {
            return Response::jsonapi_success('failed', null, 200);
        }
    }
}
