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
use Altum\Middlewares\Csrf;
use Altum\Response;
use Altum\Models\QrCode;
use Altum\Models\User;

class AdminArchivedQrCodes extends Controller {

    public function index(){

        switch ($_SERVER['REQUEST_METHOD']) {
            case 'POST':
                if (!empty($_POST['action'])) {
                    if ($_POST['action'] == 'searchArchivedQr') {
                        echo $this->searchArchivedQr();
                    }
                }
                break;
            case 'GET':

                /* Detect if we only need an object, or the whole list */

                break;
        }

        /* Prepare the filtering system */
        $filters = (new \Altum\Filters(['user_id', 'project_id', 'type'], ['name'], ['name', 'datetime']));
        $filters->set_default_order_by('qr_code_id', 'DESC');
        $filters->set_default_results_per_page(settings()->main->default_results_per_page);

        /* Prepare the paginator */
        $total_rows = database()->query("
        SELECT COUNT(*) AS `total` FROM
            `qr_codes`
        LEFT JOIN
            `users` ON `qr_codes`.`user_id` = `users`.`user_id` 
        WHERE 
            1 = 1 
            AND (`qr_codes`.`user_id` IS NULL OR `users`.`type` = 2) 
            {$filters->get_sql_where()}")->fetch_object()->total ?? 0;
        $paginator = (new \Altum\Paginator($total_rows, $filters->get_results_per_page(), $_GET['page'] ?? 1, url('admin/archived-qr-codes?' . $filters->get_get() . '&page=%d')));

        /* Get the data */
        $qr_codes = [];
        $qr_codes_result = database()->query("
            SELECT
                `qr_codes`.`qr_code_id`, `qr_codes`.`name`, `qr_codes`.`type`, `qr_codes`.`datetime`, `qr_codes`.`uId`
            FROM
                `qr_codes`
            LEFT JOIN
                `users` ON `qr_codes`.`user_id` = `users`.`user_id`
            WHERE

                1 = 1 
                AND (`qr_codes`.`user_id` IS NULL OR `users`.`type` = 2)
                {$filters->get_sql_where('qr_codes')}
                {$filters->get_sql_order_by('qr_codes')}

            {$paginator->get_sql_limit()}

        ");
        while($row = $qr_codes_result->fetch_object()) {
            $qr_codes[] = $row;
        }

        /* Prepare the pagination view */
        $pagination = (new \Altum\Views\View('partials/pagination', (array) $this))->run(['paginator' => $paginator]);

        $qr_code_settings = require APP_PATH . 'includes/qr_code.php';

        /* Main View */
        $data = [
            'qr_codes' => $qr_codes,
            'filters' => $filters,
            'pagination' => $pagination,
            'qr_code_settings' => $qr_code_settings,
        ];

        $view = new \Altum\Views\View('admin/archived-qr-codes/index', (array) $this);

        $this->add_view_content('content', $view->run($data));

    }

    public function reactive_qr_code() {

        $nowDateTime = (new \DateTime())->format('Y-m-d H:i:s');

        if(empty($_POST)) {
            redirect('admin/archived-qr-codes');
        }

        $qr_code_id = (int) $_POST['qr_code_id'];
        $_POST['email'] = mb_substr(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL), 0, 320);

        if(!Csrf::check()) {
            Alerts::add_error(l('global.error_message.invalid_csrf_token'));
        }

        if(!$qr_code = db()->where('qr_code_id', $qr_code_id)->getOne('qr_codes', ['qr_code_id', 'user_id', 'name'])) {
            redirect('admin/archived-qr-codes');
        }

        $new_user = db()->where('email', $_POST['email'])->getOne('users', ['user_id', 'email', 'plan_id', 'datetime', 'plan_expiration_date']);

        if(!$new_user) {

            $password                   = null;
            $name                       = '';
            $plan_id                    = 'free';
            $plan_settings              = json_encode(settings()->plan_free->settings);
            $plan_expiration_date       = $nowDateTime;
            $ipData                     = location_data();
            $onboarding_funnel          = 1;
            $is_review                  = 1;
            $plan_expiry_reminder       = 1;

            $created_user = (new User())->create(
                $_POST['email'],
                $password,
                $name,
                (int) !settings()->users->email_confirmation,
                'direct',
                null,
                null,
                $plan_id,
                $plan_settings,
                $plan_expiration_date,
                isset($ipData->timezone) ? $ipData->timezone : settings()->main->default_timezone,
                (int) 0,
                $onboarding_funnel,
                false,
                $is_review,
                $plan_expiry_reminder,
            );

            // create promo email record
            $promo_email_rule = db()->where('user_id', $created_user['user_id'])->getOne('promo_email_rules');
            if (!$promo_email_rule) {

                $month_first_email_date =  (new \DateTime())->modify('+30 days')->format('Y-m-d H:i:s');
                $month_second_email_date =  (new \DateTime())->modify('+33 days')->format('Y-m-d H:i:s');

                db()->insert('promo_email_rules', [
                    'user_id'                 => $created_user['user_id'],
                    'email'                   => $_POST['email'],
                    'month_first_email_date'  => $month_first_email_date,
                    'month_second_email_date' => $month_second_email_date,
                ]);
            }

        } else {

            if ($new_user->plan_id == 'free' && $new_user->plan_expiration_date > $nowDateTime) {
                db()->where('user_id', $new_user->user_id)->update('users', [
                    'plan_expiration_date'  => $new_user->datetime,
                    'plan_expiry_reminder'  => 1,
                    'is_review'             => 1,
                ]);

            }

        }

        if(!Alerts::has_field_errors() && !Alerts::has_errors()) {

            /* Update the database */
            $new_user_id = isset($created_user) ? $created_user['user_id'] : $new_user->user_id;
            $updated_qr = db()->where('qr_code_id', $qr_code->qr_code_id)->getOne('qr_codes');
            $qrJsonData = json_decode($updated_qr->data, true);
            $qrJsonData['userIdAjax'] = $new_user_id;
            $newJsonData = json_encode($qrJsonData);

            
            db()->where('qr_code_id', $qr_code->qr_code_id)->update('qr_codes', [
                'user_id' => $new_user_id,
                'data' => $newJsonData
            ]);
            
            

            /* Set a nice success message */
            Alerts::add_success(sprintf(l('admin.reactive_qr_modal.success_message'), '<strong>' . input_clean($qr_code->name) . '</strong>', '<strong>' . input_clean($_POST['email']) . '</strong>'));

            /* Redirect */
            redirect('admin/archived-qr-codes');

        }

        redirect('admin/archived-qr-codes');
    }

    public function searchArchivedQr() 
    {
        $searchInput = $_POST['searchInput'];
        if (filter_var($searchInput, FILTER_VALIDATE_URL)) {
            $parsed_url = parse_url($searchInput);
            $path_parts = explode('/', $parsed_url['path']);
            $qr_uid = end($path_parts);
    
            $qrData = $this->getQrData($qr_uid);
            if ($qrData) {
    
                $response = [
                    'result' => 'success', 
                    'qr_code' => $qrData['qr_code'], 
                    'qr_icon' => $qrData['qr_icon'], 
                    'create_date' => $qrData['create_date'], 
                    'qr_type' => $qrData['qr_type'],
                    'scanpage_url' => $qrData['scanpage_url'],
                    'dropdown_content' => $qrData['dropdown_content']
                ];
            } else {
                $response = ['result' => 'error', 'message' => 'no_results'];
            }
        } else {
            $searchUrl = "https://" . $searchInput;
            if (filter_var($searchUrl, FILTER_VALIDATE_URL)) {
                $parsed_url = parse_url($searchInput);
                $path_parts = explode('/', $parsed_url['path']);
                $qr_uid = end($path_parts);
        
                $qrData = $this->getQrData($qr_uid);

                if ($qrData) {
                    $response = [
                        'result' => 'success', 
                        'qr_code' => $qrData['qr_code'], 
                        'qr_icon' => $qrData['qr_icon'], 
                        'create_date' => $qrData['create_date'], 
                        'qr_type' => $qrData['qr_type'],
                        'scanpage_url' => $qrData['scanpage_url'],
                        'dropdown_content' => $qrData['dropdown_content']
                    ];
                } else {
                    $response = ['result' => 'error', 'message' => 'no_results'];
                }
        
                
            } else if ($qrData = $this->getQrData($searchInput)) {
                $response = [
                    'result' => 'success', 
                    'qr_code' => $qrData['qr_code'], 
                    'qr_icon' => $qrData['qr_icon'], 
                    'create_date' => $qrData['create_date'], 
                    'qr_type' => $qrData['qr_type'],
                    'scanpage_url' => $qrData['scanpage_url'],
                    'dropdown_content' => $qrData['dropdown_content']
                ];            
            } else {
                $response = ['result' => 'error', 'message' => 'no_results'];
            }
        }

        return Response::jsonapi_success($response, null, 200);
    }

    public function getQrData($qr_uid) 
    {

        $qr_code = database()->query("
            SELECT
                `qr_codes`.`qr_code_id`, `qr_codes`.`name`, `qr_codes`.`type`, `qr_codes`.`datetime`, `qr_codes`.`uId`
            FROM
                `qr_codes`
            LEFT JOIN
                `users` ON `qr_codes`.`user_id` = `users`.`user_id`
            WHERE
                `qr_codes`.`uId` = '{$qr_uid}'
                AND (`qr_codes`.`user_id` IS NULL OR `users`.`type` = 2)

        ")->fetch_object();
        
        if ($qr_code) {
            $qr_code_settings = require APP_PATH . 'includes/qr_code.php';
            $qr_icon = $qr_code_settings['type'][$qr_code->type]['icon'];
            $create_date = \Altum\Date::get($qr_code->datetime, 2);
            $qr_type = l('qr_codes.type.' . $qr_code->type);
            $scanpage_url = LANDING_PAGE_URL . 'p/' . $qr_code->uId;
            $dropdown_content = include_view(THEME_PATH . 'views/admin/archived-qr-codes/admin_archived_qr_dropdown_button.php', ['id' => $qr_code->qr_code_id, 'resource_name' => $qr_code->name]);
    
            return [
                'qr_code' => $qr_code, 
                'qr_icon' => $qr_icon, 
                'create_date' => $create_date, 
                'qr_type' => $qr_type, 
                'scanpage_url' => $scanpage_url, 
                'dropdown_content' => $dropdown_content
            ];
        } else {
            return false;
        }
                
    }

}