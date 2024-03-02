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
use Altum\Response;
use Altum\Traits\Apiable;

class ApiScans extends Controller {
    use Apiable;

    public function index() {

        $this->verify_request();

        /* Decide what to continue with */
        switch($_SERVER['REQUEST_METHOD']) {
            case 'GET':

                /* Detect if we only need an object, or the whole list */
                if(isset($this->params[0])) {
                    //$this->get();
                }

            break;
        }

        $this->return_404();
    }
    public function store() {

        $this->verify_request(false, true);

        /* Decide what to continue with */
        switch($_SERVER['REQUEST_METHOD']) {
            case 'POST':
                /* Detect if we only need an object, or the whole list */
                $data = $this->storeScan();
                echo json_encode($data);
                die();
            break;
        }

        $this->return_404();
    }

    private function storeScan(){
        
        try{

            /** Check */
            $uniqueUser = "SELECT COUNT(*) FROM qrscan_statistics WHERE os_name = '{$_POST['os_name']}' AND ip_address = '{$_POST['ip_address']}' AND browser_name = '{$_POST['browser_name']}'";
            $queryResource = database()->query($uniqueUser);
            $count = $queryResource->fetch_row()['0'];
            $isUnique = ($count == 0) ? 1 : 0;
            
            /* Check for any errors */
            $required_fields = ['qr_code_id'];
            foreach($required_fields as $field) {
                if(!isset($_POST[$field]) || (isset($_POST[$field]) && empty($_POST[$field]) && $_POST[$field] != '0')) {
                    $this->response_error(l('global.error_message.empty_fields'), 401);
                    break 1;
                }
            }

             /* Insert the log */
             $insertData = [
                'qr_code_id' => $_POST['qr_code_id'],
                'country_code' => $_POST['country_code'] ?? null,
                'os_name' => $_POST['os_name'] ?? null,
                'city_name' => $_POST['city_name'] ?? null,
                'country_name' => $_POST['country_name'] ?? null,
                'browser_name' => $_POST['browser_name'] ?? null,
                'referrer_host' => $_POST['referrer_host'] ?? null,
                'referrer_path' => $_POST['referrer_path'] ?? null,
                'device_type' => $_POST['device_type'],
                'browser_language' => $_POST['browser_language'] ?? null,
                'utm_source' => $_POST['utm_source'] ?? null,
                'utm_medium' => $_POST['utm_medium'] ?? null,
                'utm_campaign' => $_POST['utm_campaign'] ?? null,
                'is_unique' => $isUnique,
                'ip_address' => $_POST['ip_address'] ?? NULL,
                'datetime' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
             /* Insert the log */
            $scan_id = db()->insert('qrscan_statistics', $insertData);

            $data = [
                'result' => 'success', 'data' => ['scan_id' => $scan_id]
            ];
       
            return $data;

        } catch (\Exception $exception) {
            $data = ['result' => 'fail', 'data' => ['error' => $exception->getMessage()]
            ];
            return $data;
        }
        die();

    }

    public function ajax(){
        // $this->verify_request(false, true);
        $this->verify_request(false, true);

        /* Decide what to continue with */
        switch($_SERVER['REQUEST_METHOD']) {
            case 'POST':
                /* Detect if we only need an object, or the whole list */
                $this->storeScan();
            break;
            case 'GET':
                /* Detect if we only need an object, or the whole list */
                echo "Hello";
                die();
                // $this->storeScan();
            break;
        }

        $this->return_404();
        try{
            $data = [
                'result' => 'success',
                'data' => [
                    'scan_id' => 'bla bla',
                ],
            ];
       
            Response::jsonapi_success($data, null, 200);

        } catch (\Exception $exception) {
            $this->response_error($exception->getMessage(), 401);
        }
        Response::jsonapi_success($data);

        die();
    }

    function export(){
        echo 'hello';
        dd($_POST);
    }

    function array_to_csv_download($array, $filename = "export.csv") {
        $f = fopen('php://memory', 'w');
        fputs($f, $bom = ( chr(0xEF) . chr(0xBB) . chr(0xBF) ));
        foreach ($array as $line) {
            fputcsv($f, $line);
        }
        fseek($f, 0);
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '";');
        fpassthru($f);
    }

}
