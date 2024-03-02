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
use Altum\Models\QrCode;
use Altum\Meta;
use Altum\Response;
// use DateInterval;
use DateTime;
// use DateTimeInterface;
use Stripe\Exception\ApiErrorException;


class QrCodes extends Controller
{

    public function index()
    {
        Authentication::guard();


        if (isset($_SESSION['exit_from_plans'])) {           
            unset($_SESSION['exit_from_plans']);
            if ($this->user->onboarding_funnel == 3) {               
                try {
                    send_download_qr_email($this->user->user_id);
                    db()->where('user_id', $this->user->user_id)->delete('dpf_online');                    
                } catch (\Throwable $th) {
                    //throw $th;
                }
            }
        }

        $referral_key = isset($_GET['referral_key']) ? $_GET['referral_key'] : null;

        if (isset($_SESSION['pay_thank_you'])) {
            unset($_SESSION['pay_thank_you']);
        }

        if (isset($_SESSION['is_dpf'])) {
            unset($_SESSION['is_dpf']);
        }

        /* Existing projects */
        $single_project = [];
        if (isset($_GET['project_id']) && $_GET['project_id'] != '') {
            $project_id = $_GET['project_id'];
            $projects = (new \Altum\Models\Projects())->get_projects_by_user_id($this->user->user_id);
            $single_project = (isset($projects[$project_id])) ? (array)$projects[$project_id] : [];
        }

        if (!empty(settings()->main->opengraph)) {
            Meta::set_social_url(SITE_URL);
            Meta::set_social_title('Online QR Generator | Create Free QR Codes');
            Meta::set_social_description('Online QR Code Generator with your logo, frame, colors & more. Create, manage and statistically track your QR codes. For URL, vCard, PDF and more');
            Meta::set_social_image(UPLOADS_FULL_URL . 'main/' . settings()->main->opengraph);
        }

        $queryResource = "SELECT * FROM qr_codes  WHERE user_id = '{$this->user->user_id}' LIMIT 1";
        $qrCount = database()->query("SELECT COUNT(*) AS `qr_code_id` FROM `qr_codes` WHERE `user_id` = {$this->user->user_id} AND `status` = '1'")->fetch_object()->qr_code_id ?? 0;
        $qrCode = database()->query($queryResource)->fetch_object();


        $reviewBanner = false;
        if ($qrCode != null && $qrCount >= 1 && $this->user->is_review == false) {
            $modifyDay         = (new \DateTime($qrCode->datetime))->modify('+3 day')->format('Y-m-d H:i:s');
            $reviewBanner      = (new \DateTime($modifyDay) > new DateTime()) ? true :  false;
            if (!$reviewBanner && $this->user->is_review == false) {
                db()->where('user_id', $this->user->user_id)->update('users', [
                    'is_review' => true
                ]);
            }
        }

       
        $first_qr_code = null;
        $downloadBanner = false;
        if ($qrCode != null && $qrCount == 1 && $this->user->is_first_qr == false) {
            $downloadBanner = true;
            $first_qr_code = db()->where('qr_code_id', $qrCode->qr_code_id)->getOne('qr_codes', ['qr_code_id', 'name', 'uId', 'type', 'qr_code']);
        }

        $planData = [
            'page'=> 'qr-codes'
        ];
        $planExpireBannerHtml = (new \Altum\Views\View('plan/expire-banner', (array) $this))->run($planData);


        $method = null;
        if (isset($_SESSION['auth_register']) && $_SESSION['auth_register'] == 'google') {
            $method = 'Google';
            unset($_SESSION['auth_register']);
        } else if (isset($_SERVER['HTTP_REFERER'])) {

            if (url('register_nsf') == $_SERVER['HTTP_REFERER']) {
                $method = 'Email';
            } else {
                $reffer = explode('?', $_SERVER['HTTP_REFERER']);
                if ($reffer[0] == url('register_nsf')) {
                    $method = 'Email';
                }
            }
        }

        /* Prepare the View */
        $data = [
            'user_id'                    => $this->user->user_id,
            'single_project'             => $single_project,
            'planExpireBannerHtml'       => $planExpireBannerHtml,
            // 'reviewBannerHtml'           => $reviewBannerHtml,
            'reviewBanner'               => $reviewBanner,
            'downloadBanner'             => $downloadBanner,
            'first_qr_code'              => $first_qr_code,
            'qrCount'                    => $qrCount,
            'auth_method'                => $method,

        ];



        if (isset($_SESSION['auth']) && $_SESSION['auth'] == 'google') {

            $data = [
                'user_id'                    => $this->user->user_id,
                'single_project'             => $single_project,
                'planExpireBannerHtml'       => $planExpireBannerHtml,
                // 'reviewBannerHtml'           => $reviewBannerHtml,
                'reviewBanner'               => $reviewBanner,
                'downloadBanner'             => $downloadBanner,
                'first_qr_code'              => $first_qr_code,
                'qrCount'                    => $qrCount,
                'login_method'               => 'google',
                'auth_method'                => $method,

            ];

            unset($_SESSION['auth']);
        }


        $view = new \Altum\Views\View('qr-codes/index', (array) $this);

        $this->add_view_content('content', $view->run($data));
    }

    public function delete()
    {
        Authentication::guard();

        /* Team checks */
        if (\Altum\Teams::is_delegated() && !\Altum\Teams::has_access('delete')) {
            Alerts::add_info(l('global.info_message.team_no_access'));
            redirect('qr-codes');
        }

        if (empty($_POST)) {
            redirect('qr-codes');
        }

        $qr_code_id = (int) Database::clean_string($_POST['qr_code_id']);

        //ALTUMCODE:DEMO if(DEMO) if($this->user->user_id == 1) Alerts::add_error('Please create an account on the demo to test out this function.');

        if (!Csrf::check()) {
            Alerts::add_error(l('global.error_message.invalid_csrf_token'));
            redirect('qr-codes');
        }

        /* Make sure the vcard id is created by the logged in user */
        if (!$qr_code = db()->where('qr_code_id', $qr_code_id)->where('user_id', $this->user->user_id)->getOne('qr_codes', ['qr_code_id', 'name'])) {
            redirect('qr-codes');
        }

        if (!Alerts::has_field_errors() && !Alerts::has_errors()) {

            (new QrCode())->delete($qr_code->qr_code_id);

            /* Set a nice success message */
            Alerts::add_success(sprintf(l('global.success_message.delete1'), '<strong>' . $qr_code->name . '</strong>'));

            redirect('qr-codes');
        }

        redirect('qr-codes');
    }

    public function detail()
    {

        Authentication::guard();

        $qr_code_id = isset($this->params[0]) ? (int) $this->params[0] : null;

        $select = "*";
        $select .= ", (SELECT COUNT(id) FROM `qrscan_statistics` WHERE `qr_code_id` = qr_codes.`qr_code_id`) AS total_scan";
        $raw_qry = "SELECT {$select} FROM `qr_codes` WHERE `user_id` = {$this->user->user_id} AND `qr_code_id` = {$qr_code_id}";
        $qr_codes_result = database()->query($raw_qry);
        $qr_code = $qr_codes_result->fetch_assoc();

        if (!$qr_code) {
            redirect('qr-codes');
        }

        // dd($qr_code);

        $projects = (new \Altum\Models\Projects())->get_projects_by_user_id($this->user->user_id);
        $links = (new \Altum\Models\Link())->get_full_links_by_user_id($this->user->user_id);


        $raw_qry = "SELECT * FROM `campaign_informations` WHERE `user_id` = {$this->user->user_id} AND `qr_code_id` = {$qr_code_id}";
        $campaign_info_result = database()->query($raw_qry);
        $campaign_info = $campaign_info_result->fetch_assoc();
        $planExpireBanner = new \Altum\Views\View('plan/expire-banner', (array) $this);


        /* Prepare the View */
        $data = [
            'user_id'             => $this->user->user_id,
            'qr_code'             => $qr_code,
            'projects'            => $projects,
            'links'               => $links,
            'campaign_info'       => $campaign_info,
            'planExpireBanner'    => $planExpireBanner,
            'downloadBanner'      => false,
        ];

        $view = new \Altum\Views\View('qr-codes/index-detail', (array) $this);

        $this->add_view_content('content', $view->run($data));
    }
}
