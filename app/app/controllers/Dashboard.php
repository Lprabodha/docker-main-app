<?php
/*
 * @copyright Copyright (c) 2021 AltumCode (https://altumcode.com/)
 *
 * This software is exclusively sold through https://altumcode.com/ by the AltumCode author.
 * Downloading this product from any other sources and running it without a proper license is illegal,
 *  except the official ones linked from https://altumcode.com/.
 */

namespace Altum\Controllers;

use Altum\Database\Database;
use Altum\Middlewares\Authentication;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use DateTime;
use Dompdf\Dompdf;

class Dashboard extends Controller
{

    public $datetime;

    public function index()
    {

        Authentication::guard();


        $this->datetime = \Altum\Date::get_start_end_dates_new();
        /* Get some stats */
        $total_qr_codes = db()->where('user_id', $this->user->user_id)->where('status', '1')->getValue('qr_codes', 'count(`qr_code_id`)');

        /* Get available projects */
        $projects = (new \Altum\Models\Projects())->get_projects_by_user_id($this->user->user_id);
        $qr_codes =  db()->where('user_id', $this->user->user_id)->where('status', '1')->get('qr_codes', null, ['name', 'qr_code_id']);

        $where = "WHERE qr_code_id IN (SELECT qr_code_id FROM `qr_codes` WHERE user_id = '{$this->user->user_id}')";
        $query = database()->query("SELECT DISTINCT(os_name) FROM `qrscan_statistics` $where");
        $os_name_arr = $query->fetch_all(MYSQLI_ASSOC);
        $query = database()->query("SELECT DISTINCT(city_name) FROM `qrscan_statistics` $where");
        $city_name_arr = $query->fetch_all(MYSQLI_ASSOC);
        $query = database()->query("SELECT DISTINCT(country_name) FROM `qrscan_statistics` $where");
        $country_name_arr = $query->fetch_all(MYSQLI_ASSOC);


        $queryResource = "SELECT * FROM qr_codes  WHERE user_id = '{$this->user->user_id}' LIMIT 1";
        $qrCount = database()->query("SELECT COUNT(*) AS `qr_code_id` FROM `qr_codes` WHERE `user_id` = {$this->user->user_id} AND `status` = '1'")->fetch_object()->qr_code_id ?? 0;
        $qrCode = database()->query($queryResource)->fetch_object();


        $reviewBanner = false;
        if ($qrCode != null && $qrCount >= 1 && $this->user->is_review == false && date_format(new \DateTime($this->user->datetime), 'Y-m-d') >= "2023-06-16") {
            $modifyDay         =  (new \DateTime($qrCode->datetime))->modify('+3 day')->format('Y-m-d H:i:s');
            $reviewBanner      = (new \DateTime($modifyDay) > new DateTime()) ? true :  false;
            if (!$reviewBanner && $this->user->is_review == false) {
                db()->where('user_id', $this->user->user_id)->update('users', [
                    'is_review' => true
                ]);
            }
        }

        $planData = [];
        $planExpireBannerHtml = (new \Altum\Views\View('plan/expire-banner', (array) $this))->run($planData);
        $reviewBannerHtml = (new \Altum\Views\View('qr-codes/components/review-banner', (array) $this))->run();


        $qr_code_settings = require APP_PATH . 'includes/qr_code.php';


        if (count($qr_codes) > 0) {

            foreach ($qr_codes as $code) {
                $qrCodeIds[] = $code->qr_code_id;
            }
            $in = $this->makeInStr($qrCodeIds);
            $query = database()->query("SELECT datetime FROM `qrscan_statistics` WHERE (qr_code_id IN ($in)) ");
            $query = $query->fetch_all();
            if (!empty($query) && isset($query[0][0])) {
                $firstScanDate = (new \DateTime($query[0][0]))->format('Y-m-d');
            }
            if (is_array($query) && !empty($query)) {
                $lastElement = end($query);
                if ($lastElement !== false && isset($lastElement[0])) {
                    $lastScanDate = (new \DateTime($lastElement[0]))->format('Y-m-d');
                }
            }
        } else {
            $firstScanDate = (new \DateTime())->format('Y-m-d');
            $lastScanDate = (new \DateTime())->format('Y-m-d');
        }



        /* Prepare the View */
        $data = [
            'os_name_arr' => $os_name_arr,
            'city_name_arr' => $city_name_arr,
            'country_name_arr' => $country_name_arr,
            'qr_codes' => $qr_codes,
            'projects' => $projects,
            'total_qr_codes' => $total_qr_codes,
            'qr_code_settings'    => $qr_code_settings,
            'datetime' => $this->datetime,
            'user_id' => $this->user->user_id,
            'planExpireBannerHtml' => $planExpireBannerHtml,
            'reviewBannerHtml'  => $reviewBannerHtml,
            'firstScanDate' => $firstScanDate ?? null,
            'lastScanDate' => $lastScanDate ?? null,
            'reviewBanner' => $reviewBanner,
        ];

        $view = new \Altum\Views\View('dashboard/index', (array) $this);

        $this->add_view_content('content', $view->run($data));
    }


    public function export()
    {


        try {

            /**date */
            $dates = explode(" - ", $_POST['date_range']);

            $start_date = date('Y-m-d', strtotime($dates[0]));
            $end_date = date('Y-m-d', strtotime($dates[1]));

            if (!empty($_POST['qr_code']) && is_array($_POST['qr_code']) && count($_POST['qr_code']) > 0) {
                $qr_codes = $_POST['qr_code'];
            } else {
                $qr_codes =  db()->get('qr_codes', null, ['name', 'qr_code_id']);
                $qr_codes = array_column($qr_codes, 'qr_code_id');
            }

            $os_name = $contry_name = $city_name = [];
            if (!empty($_POST['os_name']) && is_array($_POST['os_name']) && count($_POST['os_name']) > 0) {
                $os_name = $_POST['os_name'];
            }

            if (!empty($_POST['contry_name']) && is_array($_POST['contry_name']) && count($_POST['contry_name']) > 0) {
                $contry_name = $_POST['contry_name'];
            }

            if (!empty($_POST['city_name']) && is_array($_POST['city_name']) && count($_POST['city_name']) > 0) {
                $city_name = $_POST['city_name'];
            }

            $QrCodesRows = $this->getScanQrCodes($start_date, $end_date, $qr_codes, $os_name, $contry_name, $city_name, $commonQuery);

            $title = ['Date/time', 'QR Name', 'Country Name', 'Country ISO', 'City', 'Operating System', 'Operating System Version', 'Unique Visitor'];
            $array = [$title];

            foreach ($QrCodesRows as $row) {

                $finalRow = [
                    'date_time' => $row['datetime'],
                    'qr_name' => $row['qr_code_name'],
                    'country_name' => $row['country_name'],
                    'country_code' => $row['country_code'],
                    'city_name' => $row['city_name'],
                    'os_name' => $row['os_name'],
                    'os_version' => 1.5,
                    'unique_visitor' => $row['is_unique'],
                ];
                $array[] = $finalRow;
            }


            if ($_POST['file_type'] == 'csv') {
                $file = date("Y-m-d-H_i_s") . "-qrcode-reports.csv";
            } else {
                $file = date("Y-m-d-H_i_s") . "-qrcode-reports.xlsx";
            }


            $this->array_to_download($array, $file, $_POST['file_type']);
        } catch (\Exception $exception) {
            // echo "Something Went Wrong";
            throw $exception;
        }

        die();
    }

    private function array_to_download($array, $filename, $type)
    {

        if ($type == 'csv') {

            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename="' . $filename . '";');

            $f = fopen('php://memory', 'w');
            fputs($f, $bom = (chr(0xEF) . chr(0xBB) . chr(0xBF)));
            foreach ($array as $line) {
                fputcsv($f, $line);
            }
            fseek($f, 0);
            fpassthru($f);
        } else {

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->fromArray($array, NULL, 'A1');

            header('Content-Disposition: attachment;filename="' . $filename . '";');
            header('Cache-Control: max-age=0');

            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }
    }

    private function makeInStr($arr)
    {
        return "'" . implode("','", $arr) . "'";
    }
    private function getScanQrCodes($start_date, $end_date, $qr_codes, $os_name, $contry_name, $city_name, &$commonQuery)
    {

        $rawQuery = "SELECT count(id) FROM `qrscan_statistics`";
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
        if (count($contry_name) > 0) {
            $in = $this->makeInStr($contry_name);
            $whereArr[] = "(contry_name IN ($in))";
        }
        if (count($city_name) > 0) {
            $in = preg_replace("/[^a-zA-Z 0-9]+/", "", $city_name);                      
            $in = $this->makeInStr($in);         
            $whereArr[] = "(city_name IN ($in))";
        }      

        $subQry = "(SELECT name FROM `qr_codes` WHERE `qr_code_id` = qrscan_statistics.qr_code_id LIMIT 1) as qr_code_name";
        if (count($whereArr) > 0) {
            $whereCondition = implode(" AND ", $whereArr);
            $rawQuery = "SELECT *, $subQry FROM `qrscan_statistics` WHERE $whereCondition";
        } else {
            $rawQuery = "SELECT *, $subQry FROM `qrscan_statistics`";
        }

        $query = database()->query($rawQuery);
        $scanQrCodeRecords = $query->fetch_all(MYSQLI_ASSOC);

        return $scanQrCodeRecords;
    }
}
