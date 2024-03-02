<?php
/*
 * @copyright Copyright (c) 2021 AltumCode (https://altumcode.com/)
 *
 * This software is exclusively sold through https://altumcode.com/ by the AltumCode author.
 * Downloading this product from any other sources and running it without a proper license is illegal,
 *  except the official ones linked from https://altumcode.com/.
 */

namespace Altum\Controllers;

use Altum\Middlewares\Authentication;


class DpfPayThankYou extends Controller
{

    public function index()
    {
        if (isset($_SESSION['exit_from_plans'])) {
            unset($_SESSION['exit_from_plans']);
        }

        if (!isset($_SESSION['pay_thank_you'])) {
            redirect('qr-codes');
        } else {
            unset($_SESSION['pay_thank_you']);
        }


        if (isset($_SESSION['is_dpf'])) {
            unset($_SESSION['is_dpf']);
        }


        if (isset($_GET['schedule_id'])) {
            $data = [
                'plan_id'    => '',
                'plan'       => '',
            ];

            // redirect('qr');

            $view = new \Altum\Views\View('pay-dpf-thank-you/index', (array) $this);

            $this->add_view_content('content', $view->run($data));
        }

        $plan_id = $_GET['plan_id'] ?? null;


        switch ($plan_id) {

            case 'free':


                $plan = settings()->plan_free;

                break;

            default:

                $plan_id = (int) $plan_id;

                /* Check if plan exists */
                if (!$plan = (new \Altum\Models\Plan())->get_plan_by_id($plan_id)) {
                    redirect('plan');
                }

                break;
        }


        if (!$plan->status) {
            redirect('plan-rdpf');
        }

        $user = null;
        if (isset($_GET['ref'])) {
            $user  = db()->where('referral_key', $_GET['ref'])->getOne('users');
        }

        // /* Prepare the View */
        $data = [
            'plan_id'    => '',
            'plan'       => $plan,
            'user'      => $user,
        ];



        $view = new \Altum\Views\View('pay-dpf-thank-you/index', (array) $this);

        $this->add_view_content('content', $view->run($data));
    }
}
