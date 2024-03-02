<?php

namespace Altum\Controllers;

use Altum\Database\Database;
use Altum\Response;
use Altum\Traits\Apiable;


class ApiAnalytics extends Controller
{
    use Apiable;

    public function index()
    {
        $this->verify_request(false, true);

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {

            $this->get();
        }

        $this->return_404();
    }

    public function get()
    {
        try {

            /* Get the data */
            $data = [];

            $data_result = database()->query("
            SELECT
                *
            FROM
                `users`");


            while ($row = $data_result->fetch_object()) {

                if ($row->plan_id == 'free') {
                    $planName = 'free';
                } else {
                    $plan = db()->where('plan_id', $row->plan_id)->getOne('plans');
                    $planName  =  $plan->name;
                }

                $lastPayments = database()->query("SELECT * FROM `payments` WHERE `user_id` = {$row->user_id} ORDER BY `id` DESC LIMIT 1")->fetch_object();

                $firstSubscription     = database()->query("SELECT * FROM `payments` WHERE `user_id` = {$row->user_id} ORDER BY `id` ASC LIMIT 1")->fetch_object();

                $qrResults = database()->query("SELECT * FROM `qr_codes` WHERE `user_id` = {$row->user_id} ORDER BY `qr_code_id`");


                $user  = [
                    'user'                    => $row->name ? $row->name : $row->email,
                    'signup_date'             => $row->datetime,
                    'last_active_date'        => $row->last_activity,
                    'subscription_plan'       => $planName,
                    'subscription_start_date' => $firstSubscription ? $firstSubscription->datetime : null,
                    'plan_end_date'           => $row->plan_expiration_date,
                    'subscription_status'     => $row->payment_subscription_id ? 'live' : 'canceled',
                    'source'                  => $row->source,
                    'last_payment_date'       => $lastPayments ? $lastPayments->datetime : null,
                    'date_of_cancellation'    => $row->subscription_cancel_date ? $row->subscription_cancel_date  : null,
                    'user_status'             => time() - $row->last_activity  <= 300 ? 'online' : 'offline',
                    'trial_period'            => $row->plan_trial_done ? 'yes' : 'no',
                    'subscription_end_date'   => $row->plan_expiration_date
                ];

                $qrData = [];
                while ($qrResult =  $qrResults->fetch_object()) {
                    $qrData[] = [
                        'type'       => $qrResult->type,
                        'created_at' => $qrResult->datetime,
                        'downloaded' => $qrResult->is_download ? 'yes' : 'no',
                    ];
                }

                $user['qr'] = $qrData;
                $data[]  = $user;
            }


            Response::jsonapi_success($data);
        } catch (\Exception $exception) {
            $data = [
                'result' => 'fail', 'data' => ['error' => $exception->getMessage()]
            ];
            return $data;
        }
    }
}
