<?php
/*
 * @copyright Copyright (c) 2021 AltumCode (https://altumcode.com/)
 *
 * This software is exclusively sold through https://altumcode.com/ by the AltumCode author.
 * Downloading this product from any other sources and running it without a proper license is illegal,
 *  except the official ones linked from https://altumcode.com/.
 */

namespace Altum\Controllers;

use Abraham\TwitterOAuth\TwitterOAuth;
use Altum\Alerts;
use Altum\Captcha;
use Altum\Database\Database;
use Altum\AnalyticsDatabase\AnalyticsDatabase;
use Altum\Logger;
use Altum\Middlewares\Authentication;
use Altum\Models\User;
use Altum\Response;
use Altum\Title;
use DateTime;
use Google\Client;
use MaxMind\Db\Reader;
use Stripe\Exception\ApiErrorException;

class PlanRDpf extends Controller
{

    public function index()
    {
        Authentication::guard();       

       
        if ($this->user->onboarding_funnel != 4) {
            redirect('plan');
        }

        $type = isset($this->params[0]) && in_array($this->params[0], ['renew', 'upgrade', 'new']) ? $this->params[0] : 'new';

        if (in_array($type, ['renew', 'upgrade']) && !Authentication::check()) {
            redirect('plan-rdpf');
        }

        if ($this->user->payment_subscription_id && $type != 'upgrade' ) {
            redirect('billing');
        }
       
        if (isset($_GET['promo']) && !isset($_SESSION['discount'])) {
            redirect('plan-rdpf');
        }


        $discount = null;
        if (isset($_GET['promo'])) {
            if ($_GET['promo'] == '70OFF') {
                $discount = 70;
            }
        }
       
        $planId  = null;
        if (isset($_GET['type'])) {
            if ($_GET['type'] == 'discounted') {
                $planId = 4;
            }

            if ($_GET['type'] == 'onetime') {
                $planId = 5;
            }
        }


        Title::set(sprintf(l('private_plan.plan.title_upgrade')));       

        $qrCount = database()->query("SELECT COUNT(*) AS `qr_code_id` FROM `qr_codes` WHERE `user_id` = {$this->user->user_id} AND `status` = '1' ")->fetch_object()->qr_code_id ?? 0;
        
        $data = [           
            'qrCount' => $qrCount,
            'discount' => $discount,
            'planId' => $planId,
            'user'   => $this->user
        ];

        promo_email_trigger($this->user->user_id, 'pricing');

        $view = new \Altum\Views\View('partials/plans', (array) $this); 
        $this->add_view_content('plans', $view->run($data));

        $view = new \Altum\Views\View('plan-dpf/renew', (array) $this);
        $this->add_view_content('content', $view->run($data));
        

        
    }
}
