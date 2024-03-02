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
use Altum\Middlewares\Authentication;
use Altum\Middlewares\Csrf;
use Altum\Alerts;
use Altum\Date;
use Altum\Models\User;
use Altum\Captcha;
use Exception;
use MaxMind\Db\Reader;
use Stripe\Exception\ApiErrorException;


class ApiAjaxNew extends Controller
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
                    if ($_POST['action'] == 'check_duplicate_email') {
                        echo $this->check_duplicate_email();
                    } else if ($_POST['action'] == 'resend_verify_code') {
                        echo $this->resend_verify_code();
                    } else if ($_POST['action'] == 'saveRegisterUser') {
                        echo $this->saveRegisterUser();
                    } else if ($_POST['action'] == 'check_google_login') {
                        echo $this->check_google_login();
                    } else if ($_POST['action'] == 'check_duplicate_nsf_email') {
                        echo $this->check_duplicate_nsf_email();
                    } else if ($_POST['action'] == 'login_with_password') {
                        echo $this->login_with_password();
                    } else if ($_POST['action'] == 'login_verify_code') {
                        echo $this->login_verify_code();
                    } else if ($_POST['action'] == 'check_email') {
                        echo $this->checkEmail();
                    } else if ($_POST['action'] == 'feedback_zendesk') {
                        echo $this->feedback_zendesk();
                    } else if ($_POST['action'] == 'cancel_subscription_promo') {
                        echo $this->cancel_subscription_promo();
                    } else if ($_POST['action'] == 'keep_monthly') {
                        echo $this->keepMonthly();
                    } else if ($_POST['action'] == 'switch_plan') {
                        echo $this->switchPlan();
                    } else if ($_POST['action'] == 'get_discounts') {
                        echo $this->get_discounts();
                    } else if ($_POST['action'] == 'cancel_subscription') {
                        echo $this->cancel_subscription();
                    } else if ($_POST['action'] == 'check_user_online_status') {
                        echo $this->update_user_online_status();
                    } else if ($_POST['action'] == 'cancel_popup_delinquent_user') {
                        echo $this->cancelPopupDelinquentUser();
                    } else if ($_POST['action'] == 'create_client_secret') {
                        echo $this->createClientSecret();
                    } else if ($_POST['action'] == 'unset_delinquent_session') {
                        echo $this->unsetDelinquentSession();
                    } else if ($_POST['action'] == 'get_user_by_email') {
                        echo $this->get_user_by_email();
                    } else if ($_POST['action'] == 'refund_payment') {
                        echo $this->refund_payment();
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

    private function check_duplicate_email()
    {
        if (!empty($_POST['email'])) {
            $rawQuery = "SELECT `user_id` FROM `users` WHERE `email` = '" . trim($_POST['email']) . "' ";
            $query = database()->query($rawQuery);
            $totalUniqueScan = $query->fetch_row()[0];

            if ($totalUniqueScan) {
                // $response = ['result' => 'failed', 'data' => ['message' => 'This email address is already in use.']];
                return json_encode("This email address is already in use.");
            } else {
                // $response = ['result' => 'success', 'data' => ['message' => '']];
                return json_encode(true);
            }
        } else {
            // $response = ['result' => 'failed', 'data' => ['message' => 'Email address required']];
            return json_encode("This email address is already in use.");
        }

        // return Response::jsonapi_success($response, null, 200);
    }



    public function sendVerificationCode($user)
    {
        $verificationCode = $this->generateVerificationCode(6);

        $user_verify_code = db()->where('user_id', $user['user_id'])->getOne('user_verify_codes');

        if ($user_verify_code) {
            db()->where('user_id', $user['user_id'])->update('user_verify_codes', [
                'verify_code' => $verificationCode,
                'create_time' => \Altum\Date::$date,
                'expire_time' => (new \DateTime())->modify('+30 minutes')->format('Y-m-d H:i:s'),
            ]);
        } else {
            db()->insert('user_verify_codes', [
                'user_id'     => $user['user_id'],
                'verify_code' => $verificationCode,
                'create_time' => \Altum\Date::$date,
                'expire_time' => (new \DateTime())->modify('+30 minutes')->format('Y-m-d H:i:s'),
            ]);
        }

        /* Send notification  code  */

        $template = 'verification-code';
        $code     = $verificationCode;
        trigger_email($user['user_id'], $template, $link =  null, $code);


        return $verificationCode;
    }

    // Resend verify code
    public function resend_verify_code()
    {
        $_POST['email'] = trim($_POST['email']);

        $verificationCode = $this->generateVerificationCode(6);

        $user = db()->where('email', $_POST['email'])->getOne('users');
        $user_verify_code = db()->where('user_id', $user->user_id)->getOne('user_verify_codes');

        if ($user_verify_code) {
            db()->where('user_id', $user->user_id)->update('user_verify_codes', [
                'verify_code' => $verificationCode,
                'create_time' => \Altum\Date::$date,
                'expire_time' => (new \DateTime())->modify('+30 minutes')->format('Y-m-d H:i:s'),
            ]);
        }

        if ($user) {

            /* Send notification  code  */
            $template = 'verification-code';
            $code     = $verificationCode;
            trigger_email($user->user_id, $template, $link =  null, $code);

            $response = ['result' => 'draft',   'data' => ['status' => false]];
        }


        return Response::jsonapi_success($response, null, 200);
    }

    function generateVerificationCode($length = 6)
    {
        $characters = '0123456789';
        $code = '';
        $characterCount = strlen($characters);

        for ($i = 0; $i < $length; $i++) {
            $code .= $characters[rand(0, $characterCount - 1)];
        }

        return $code;
    }

    public function saveRegisterUser()
    {
        $client_id  = $_POST['client_id'];
        $userId = $_POST['user_id'];
        $method = $_POST['method'];
        $isProduction =  false;

        $user = analyticsBb()->where('user_id', $userId)->getOne('registered_users');

        if (!$user) {
            analyticsBb()->insert('registered_users', [
                'client_id'   => $client_id,
                'user_id'      => $userId,
                'method'        => $method,
                'created_at'  => date("Y-m-d H:i:s"),
            ]);

            if (APP_CONFIG == 'production') {
                $isProduction =  true;
            }

            return Response::jsonapi_success(['newUser' => true, 'isProduction' => $isProduction], null, 200);
        } else {
            return Response::jsonapi_success(['newUser' => false, 'isProduction' => $isProduction], null, 200);
        }
    }

    private function check_duplicate_nsf_email()
    {
        if (!empty($_POST['email'])) {
            $rawQuery = "SELECT `user_id` FROM `users` WHERE `email` = '" . trim($_POST['email']) . "' ";
            $query = database()->query($rawQuery);

            $userId = null;
            if ($users = $query->fetch_row()) {
                $userId = $users[0];
            }


            if ($userId) {
                $response = ['result' => 'failed', 'data' => ['message' => 'This email address is already in use.']];

                //new NSF funnel
                failed_qr_users();
            } else {
                $response = ['result' => 'success', 'data' => ['message' => '']];
            }
        } else {
            $response = ['result' => 'failed', 'data' => ['message' => 'Email address required']];

            //new NSF funnel
            failed_qr_users();
        }

        return Response::jsonapi_success($response, null, 200);
    }

    private function check_google_login()
    {
        if (!empty($_POST['email'])) {
            $rawQuery = "SELECT `source` FROM `users` WHERE `email` = '" . trim($_POST['email']) . "' ";
            $query = database()->query($rawQuery);
            $source = $query->fetch_row()[0];
            if ($source == 'google') {
                $response = ['result' => 'failed', 'data' => ['message' => l('login.error_message.google_login')]];
                return Response::jsonapi_success($response, null, 200);
            }
        }
    }

    private function login_with_password()
    {
        if (!empty(trim($_POST['email']))) {
            $_POST['email'] = trim($_POST['email']);
            $_POST['password'] = trim($_POST['password']);
            $rawQuery = "SELECT * FROM `users` WHERE `email` = '" . trim($_POST['email']) . "' ";
            $query = database()->query($rawQuery);
            $user = $query->fetch_assoc();
            if ($user) {
                if ($user['status'] != 1) {
                    $response = ['result' => 'failed', 'data' => ['message' => 'User not active']];
                } else {
                    if ($user['password'] == null) {

                        if ($user['source'] == 'google') {
                            $response = ['result' => 'failed', 'data' => ['message' => l('login.error_message.google_login'), 'type' => 'google']];
                        } else {
                            $this->sendVerificationCode($user);
                            $_SESSION['email'] = $_POST['email'];
                            $response = ['result' => 'verify',   'data' => ['status' => false]];
                        }
                    } else {
                        $response = ['result' => 'password',   'data' => ['status' => false]];
                        if ($_POST['password']) {
                            if (!password_verify(trim($_POST['password']), $user['password'])) {
                                $response = ['result' => 'failed', 'data' => ['message' => l('login.error_message.wrong_login_credentials')]];
                            } else {
                                $response = ['result' => 'success', 'user' => $user,  'data' => ['message' => '', 'user_type' => $user['type']]];
                            }
                        }
                    }
                }
            } else {
                $response = ['result' => 'failed', 'data' => ['message' => l('login.error_message.wrong_login_credentials')]];
            }
        }
        return Response::jsonapi_success($response, null, 200);
    }


    private function login_verify_code()
    {
        if (!empty(trim($_POST['email']))) {
            $_POST['email'] = trim($_POST['email']);
            $_POST['verify_code'] = $_POST['verify_code'];

            $rawQuery = "SELECT * FROM `users` WHERE `email` = '" . trim($_POST['email']) . "' ";
            $query = database()->query($rawQuery);
            $user = $query->fetch_assoc();
            if ($user) {
                if ($user['status'] != 1) {
                    $response = ['result' => 'failed', 'data' => ['message' => 'User not active']];
                } else {
                    if ($user['password'] == null) {

                        if ($_POST['verify_code']) {

                            $user_verify_code = db()->where('user_id', $user['user_id'])->getOne('user_verify_codes');


                            if ((new \DateTime())->format('Y-m-d H:i:s') >  (new \DateTime($user_verify_code->expire_time))->modify('-30 minutes')->format('Y-m-d H:i:s')  && $user_verify_code->verify_code == $_POST['verify_code']) {

                                $token_code = $user['token_code'];
                                /* Generate a new token */
                                if (empty($user['token_code'])) {
                                    $token_code = md5($user['email'] . microtime());
                                    db()->where('user_id', $user['user_id'])->update('users', ['token_code' => $token_code]);
                                }

                                $_SESSION['user_id'] = $user['user_id'];
                                $_SESSION['user_password_hash'] = md5($user['password']);

                                setcookie('user_id', $user['user_id'], time() + (60 * 60 * 24 * 90), COOKIE_PATH);
                                setcookie('token_code', $token_code, time() + (60 * 60 * 24 * 90), COOKIE_PATH);
                                setcookie('user_password_hash', md5($user['password']), time() + (60 * 60 * 24 * 90), COOKIE_PATH);

                                $user      =   db()->where('user_id', $user['user_id'])->getOne('users');

                                $response = ['result' => 'success', 'user' => $user,  'data' => ['message' => '']];
                                unset($_SESSION['verify_code']);
                            } else {
                                $response = ['result' => 'failed',   'data' => ['status' => false, 'message' => l('login.invalid_code.error')]];
                            }
                        } else {
                            $response = ['result' => 'failed',   'data' => ['status' => false, 'message' => l('login.invalid_code.error')]];
                        }
                    }
                }
            } else {
                $response = ['result' => 'failed', 'data' => ['message' => l('login.error_message.wrong_login_credentials')]];
            }
        }
        return Response::jsonapi_success($response, null, 200);
    }

    public function checkEmail()
    {
        $captcha = new Captcha();
        $error = '';

        if (db()->where('email', $_POST['email'])->has('users')) {
            failed_qr_users();
            $error = l('register.error_message.email_exists');
            return Response::jsonapi_success($error, null, 200);
        }
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $error = l('global.error_message.invalid_email');
            return Response::jsonapi_success($error, null, 200);
        }
        if (settings()->captcha->register_is_enabled && !$captcha->is_valid()) {
            $error = l('global.error_message.invalid_captcha');
        }
        return Response::jsonapi_success($error, null, 200);
    }



    public function feedback_zendesk()
    {

        $feedbackType    =  $_POST['feedbackType'];
        $customFeedback  =  $_POST['customFeedback'];


        switch ($feedbackType) {
            case 'another_platform':
                $subject =  'Cancel Feedback - New Platform';
                $tag     =  'cancel_feedback_new_platform';

                break;
            case 'missing_feature':
                $subject =  'Cancel Feedback - Missing Features';
                $tag     =  'cancel_feedback_missing_features';
                break;
            case 'other':
                $subject =  'Cancel Feedback - Other';
                $tag     =  'cancel_feedback_other';
                break;
            case 'defficulties_platform':
                $subject =  'Cancel Feedback - Help';
                $tag     =  'cancel_feedback_help';
                break;
        }

        if ($_POST['user_id']) {
            $user  = db()->where('user_id', $_POST['user_id'])->getOne('users');


            if ($user) {

                // Zendesk API credentials
                $subdomain = ZENDESK_SUBDOMAIN;
                $username  = ZENDESK_EMAIL;
                $token     =  ZENDESK_TOKEN;

                $languages = \Altum\Language::$active_languages[$user->language];

                //zendesk locale data
                $localeEndpoint = "https://{$subdomain}.zendesk.com/api/v2/locales/{$languages}.json";

                $ch = curl_init($localeEndpoint);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json'
                ));
                curl_setopt($ch, CURLOPT_USERPWD, "{$username}/token:{$token}");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


                $localeResponse = curl_exec($ch);

                $localeId = json_decode($localeResponse, true)['locale']['id'];

                curl_close($ch);

                if (APP_CONFIG == 'production') {

                    try {
                        // API endpoint and data
                        $endpoint = "https://{$subdomain}.zendesk.com/api/v2/tickets.json";
                        $data = array(
                            'ticket' => array(
                                'subject' =>   $subject,
                                'comment' => array(
                                    'html_body' => $customFeedback,
                                ),
                                'requester' => array(
                                    'locale_id' => $localeId,
                                    'name'      =>  $user->name,
                                    'email'     => $user->email,
                                ),
                                'tags' => array($tag),
                            )
                        );

                        // Convert data to JSON
                        $data_string = json_encode($data);

                        // Create cURL request
                        $ch = curl_init($endpoint);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                            'Content-Type: application/json'
                        ));
                        curl_setopt($ch, CURLOPT_USERPWD, "{$username}/token:{$token}");
                        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                        // Execute the request
                        $response = curl_exec($ch);

                        // Check for errors
                        if (curl_errno($ch)) {
                            echo 'Error: ' . curl_error($ch);
                        } else {
                            // Print the response
                            echo $response;
                        }

                        // Close cURL
                        curl_close($ch);


                        // return Response::jsonapi_success($data, null, 200);
                    } catch (\Throwable $th) {
                        //throw $th;
                    }
                }
            }
        }
    }

    public function cancel_subscription_promo()
    {

        $discount        =  $_POST['discount'];
        $plan_id         =  $_POST['plan_id'];
        $price_id        =  $_POST['price_id'];
        $month_free      =  $_POST['month_free'];
        $feedback_type   =  $_POST['feedback_type'];
        $couponCode      =  null;

        $cancel_reason =  cancel_promo_reason($feedback_type);

        if ($_POST['user_id']) {
            $user  = db()->where('user_id', $_POST['user_id'])->getOne('users');
            $plan  = db()->where('plan_id', $plan_id)->getOne('plans');


            switch ($discount) {
                case 70:
                    $couponCode     = STRIPE_COUPON_70_FOREVER;
                    $discountName   = 'Discount 70';
                    break;
                case 90:
                    $couponCode     = STRIPE_COUPON_90_FOREVER;
                    $discountName   = 'Discount 90';
                    break;
                default:
                    $couponCode = '';
            }

            if ($user) {
                $payment_currency  = $user->payment_currency;

                if ($plan->plan_id == 1) {

                    $payment_total_amount  = $user->payment_total_amount;

                    if ($payment_total_amount == '39.95') {
                        $total   = 39.95;
                    } else {
                        $total   = get_plan_month_price($plan->plan_id, $payment_currency);
                    }
                } else {
                    $total      = get_plan_price($plan->plan_id, $payment_currency);
                }


                $new_plan_amount  = number_format($total - ($total / 100 * $discount), 2, '.', '');
                $current_plan_expiration_date = $user->plan_expiration_date;

                try {
                    $stripe         = new \Stripe\StripeClient(settings()->stripe->secret_key);

                    if ($user->stripe_customer_id) {
                        $customer       =  $stripe->subscriptions->all([
                            'customer' => $user->stripe_customer_id
                        ]);

                        $subcription_id = $customer->data[0]->id;
                        $subscription   = $stripe->subscriptions->retrieve($subcription_id);
                        $currentPriceId = $subscription->plan->id;
                        $endDate        = $subscription->current_period_end;
                        $startDate      = $subscription->current_period_start;

                        $subscription_schedule_id = $customer->data[0]->schedule;
                    } else {
                        $subscription_schedule_id = null;
                    }


                    if ($subscription_schedule_id) {
                        $subscriptionSchedules    = $stripe->subscriptionSchedules->retrieve($subscription_schedule_id, []);
                        $phaseTwoPriceId          = $subscriptionSchedules->phases[1]->items[0]->price;
                    }

                    if ($month_free == 'yes') {

                        if (isset($phaseTwoPriceId)) {
                            if ($phaseTwoPriceId != $currentPriceId) {
                                try {
                                    $stripe->subscriptions->cancel(
                                        $subcription_id,
                                        ['cancellation_details' => ['comment' => 'discount_plan']]
                                    );

                                    $subscription_schedule =   $stripe->subscriptions->create([
                                        'customer' => $user->stripe_customer_id,
                                        'items' => [['price' => $price_id]],
                                        'trial_end' => strtotime('+30 days', $endDate),
                                        'billing_cycle_anchor' => strtotime('+30 days', $endDate),
                                        'coupon'    => $couponCode,
                                    ]);

                                    $subscriptionScheduleId = $subscription_schedule->id;
                                } catch (\Exception $th) {
                                    $data = [
                                        'error'    => l('pay.error_message.payment_gateway'),
                                        'complete' => false,
                                    ];
                                    return Response::jsonapi_error($data, null, 400);
                                }
                            }
                        } else {
                            try {
                                $stripe->subscriptions->update(
                                    $subcription_id,
                                    [
                                        'trial_end' => strtotime('+30 days', $endDate),
                                        'proration_behavior' => 'none',
                                        'coupon'    => $couponCode,
                                    ]
                                );
                                $subscriptionScheduleId = $subcription_id;
                            } catch (\Exception $e) {
                                $data = [
                                    'error'    => l('pay.error_message.payment_gateway'),
                                    'complete' => false,
                                ];
                                return Response::jsonapi_error($data, null, 400);
                            }
                        }
                    } else {

                        if (isset($phaseTwoPriceId)) {
                            if ($phaseTwoPriceId != $currentPriceId) {
                                try {

                                    $stripe->subscriptionSchedules->update(
                                        $subscription_schedule_id,
                                        [
                                            'phases' => [
                                                [
                                                    'items' => [
                                                        [
                                                            'price'    => $currentPriceId,
                                                            'quantity' => 1,
                                                        ],
                                                    ],
                                                    'start_date' => $startDate,
                                                    'iterations' => 1
                                                ],
                                                [
                                                    'items' => [
                                                        [
                                                            'price'    => $phaseTwoPriceId,
                                                            'quantity' => 1
                                                        ],
                                                    ],
                                                    'coupon'    => $couponCode,
                                                ],
                                            ],

                                        ]
                                    );

                                    $subscriptionScheduleId = $subscription_schedule_id;
                                } catch (\Exception $e) {
                                    $data = [
                                        'error'    => l('pay.error_message.payment_gateway'),
                                        'complete' => false,
                                    ];
                                    return Response::jsonapi_error($data, null, 400);
                                }
                            }
                        } else {
                            try {
                                $subcription_id  =  $customer->data[0]->id;
                                $stripe->subscriptions->update(
                                    $subcription_id,
                                    [
                                        'coupon'    => $couponCode,
                                    ]
                                );

                                $subscriptionScheduleId = $subcription_id;
                            } catch (\Exception $e) {
                                $data = [
                                    'error' => l('pay.error_message.payment_gateway'),
                                    'complete' => false,
                                ];
                                return Response::jsonapi_error($data, null, 400);
                            }
                        }
                    }

                    if (isset($subscriptionScheduleId)) {
                        db()->where('user_id', $user->user_id)->update('users', [
                            'subscription_schedule_id' => $subscriptionScheduleId,
                        ]);
                    }


                    $subscription = db()->where('subscription_id', $user->payment_subscription_id)->getOne('subscriptions');

                    if ($subscription) {
                        if ($month_free == 'yes') {
                            $subcriptionStartDate =  (new \DateTime($current_plan_expiration_date))->modify('+1 months')->format('Y-m-d H:i:s');
                        } else {
                            $subcriptionStartDate = $current_plan_expiration_date;
                        }

                        db()->where('subscription_id', $user->payment_subscription_id)->update('subscriptions', [
                            'end_date' => $subcriptionStartDate,
                        ]);


                        db()->insert('subscriptions', [
                            'user_id'         => $user->user_id,
                            'plan_id'         => $plan_id,
                            'subscription_id' => $user->payment_subscription_id,
                            'start_date'      => $subcriptionStartDate,
                        ]);
                    }

                    $subscriptionUser = analyticsDatabase()->query("SELECT * FROM `subscription_users` WHERE `user_id` = {$user->user_id} ORDER BY `id` DESC LIMIT 1")->fetch_object();


                    if ($month_free == 'yes') {

                        analyticsBb()->insert('subscription_users', [
                            'user_id'                 => $user->user_id,
                            'subscription_change'     => 'downgrade',
                            'change_date'             => Date::$date,
                            'new_plan'                => $plan->name . ' - ' . 'Discount 100',
                            'previous_plan'           => $plan->name,
                            'new_plan_amount'         => 0,
                            'previous_plan_amount'    => $subscriptionUser->new_plan_amount,
                            'currency'                => $subscriptionUser->currency,
                        ]);

                        db()->where('user_id', $user->user_id)->update('users', [
                            'plan_expiration_date' => (new \DateTime($current_plan_expiration_date))->modify('+1 months')->format('Y-m-d H:i:s'),
                        ]);


                        $cancel_promo  = 3;
                    } else {
                        if ($discount == '70') {
                            $cancel_promo  = 1;
                        } else if ($discount == '90') {
                            $cancel_promo  = 2;
                        }

                        analyticsBb()->insert('subscription_users', [
                            'user_id'                 => $user->user_id,
                            'subscription_change'     => 'downgrade',
                            'change_date'             => Date::$date,
                            'new_plan'                => $plan->name . ' - ' .  $discountName,
                            'previous_plan'           => $plan->name,
                            'new_plan_amount'         => $new_plan_amount,
                            'previous_plan_amount'    => $subscriptionUser->new_plan_amount,
                            'currency'                => $subscriptionUser->currency,
                        ]);
                    }

                    db()->where('user_id', $user->user_id)->update('users', [
                        'cancel_reason' => $cancel_reason,
                        'cancel_promo' => $cancel_promo
                    ]);

                    $data = [
                        'error' => '',
                        'complete' => true,
                    ];
                    return Response::jsonapi_success($data, null, 200);
                } catch (\Exception $e) {
                    $data = [
                        'error' => l('pay.error_message.payment_gateway'),
                        'complete' => false,
                    ];
                    return Response::jsonapi_error($data, null, 400);
                }
            }
        }
    }

    public function keepMonthly()
    {
        $user_id  = $_POST['user_id'];

        if ($user_id) {
            $user = db()->where('user_id', $user_id)->getOne('users');

            if ($user) {
                db()->where('user_id',  $user_id)->update('users', [
                    'is_switch_plan'   => true,
                ]);
                return Response::jsonapi_success(['result' => true], null, 200);
            }
        }
    }

    public function switchPlan()
    {
        $user_id   = $_POST['user_id'];
        $plan_id   = $_POST['plan_id'];
        $discount  = $_POST['discount'];

        if ($user_id && $plan_id && $discount) {

            $user     = db()->where('user_id', $user_id)->getOne('users');
            $newPlan  = db()->where('plan_id',  $plan_id)->getOne('plans');

            if ($user) {

                switch ($newPlan->plan_id) {
                    case 2:
                        $priceId = STRIPE_PRICE_12_ID;
                        break;
                    case 3:
                        $priceId = STRIPE_PRICE_3_ID;
                        break;
                    default:
                        $priceId = STRIPE_PRICE_1_ID;
                }


                try {
                    $stripe               = new \Stripe\StripeClient(settings()->stripe->secret_key);
                    $subscription         = $stripe->subscriptions->retrieve($user->payment_subscription_id);
                    $currentPriceId       = $subscription->plan->id;
                    $startDate            = $subscription->current_period_start;
                    $subscriptionSchedule = $stripe->subscriptionSchedules->create(['from_subscription' => $user->payment_subscription_id]);
                    $subscriptionSchedule = $stripe->subscriptionSchedules->update(
                        $subscriptionSchedule->id,
                        [
                            'phases' => [
                                [
                                    'items' => [
                                        [
                                            'price'    => $currentPriceId,
                                            'quantity' => 1,
                                        ],
                                    ],
                                    'start_date' => $startDate,
                                    'iterations' => 1
                                ],
                                [
                                    'items' => [
                                        [
                                            'price'    => $priceId,
                                            'quantity' => 1
                                        ],
                                    ],
                                ],
                            ],

                        ]
                    );

                    db()->where('user_id',  $user->user_id)->update('users', [
                        'is_switch_plan'   => true,
                    ]);

                    db()->where('subscription_id', $user->payment_subscription_id)->update('subscriptions', [
                        'end_date' => $user->plan_expiration_date,
                    ]);

                    db()->insert('subscriptions', [
                        'user_id'         => $user->user_id,
                        'plan_id'         => $newPlan->plan_id,
                        'subscription_id' => $user->payment_subscription_id,
                        'start_date'      => $user->plan_expiration_date,
                    ]);

                    $subscriptionUser = analyticsDatabase()->query("SELECT * FROM `subscription_users` WHERE `user_id` = {$user->user_id} AND  `subscription_change` != 'cancellation' ORDER BY `id` DESC LIMIT 1")->fetch_object();

                    $total = get_plan_price($newPlan->plan_id, $user->payment_currency);

                    analyticsBb()->insert('subscription_users', [
                        'user_id'                 => $user->user_id,
                        'subscription_change'     => 'downgrade',
                        'change_date'             => Date::$date,
                        'new_plan'                => $newPlan->name,
                        'previous_plan'           => isset($subscriptionUser->new_plan) ? $subscriptionUser->new_plan : null,
                        'new_plan_amount'         => $total,
                        'previous_plan_amount'    => isset($subscriptionUser->new_plan_amount) ? $subscriptionUser->new_plan_amount : null,
                        'currency'                => $subscriptionUser->currency
                    ]);

                    $data = [
                        'error' => '',
                        'complete' => true,
                    ];
                    return Response::jsonapi_success($data, null, 200);
                } catch (\Exception $e) {

                    $data = [
                        'error' => l('pay.error_message.payment_gateway'),
                        'complete' => false,
                    ];
                    return Response::jsonapi_error($data, null, 400);
                }
            }
        }
    }

    // Get discounts for the new plan
    public function get_discounts()
    {
        $current_plan_id = $_POST['currentPlan'];
        $new_plan_id = $_POST['newPlan'];
        $discounts = [];
        if ($current_plan_id == "1" && ($new_plan_id == "2" || $new_plan_id == "3")) {
            array_push($discounts, 70, 90);
        } else {
            array_push($discounts, 30, 50, 70, 90);
        }
        return Response::jsonapi_success($discounts, null, 200);
    }



    public function cancel_subscription()
    {
        try {
            $user_id = $_POST['user_id'];
            $user = db()->where('user_id', $user_id)->getOne('users');
            $latestSubscripion = db()->query("SELECT * FROM `subscriptions` WHERE `user_id` = {$user_id} ORDER BY `id` DESC LIMIT 1");
            $stripe = new \Stripe\StripeClient(settings()->stripe->secret_key);

            $subscription_id = ($user->payment_subscription_id != null && $user->payment_subscription_id != '')  ? $user->payment_subscription_id : $latestSubscripion[0]->subscription_id;           
            
            if ($subscription_id && $user->subscription_schedule_id == null) {              
                
                $stripe->subscriptions->cancel(
                    $subscription_id,
                    []
                );

                db()->where('user_id', $user_id)->update('users', [
                    'payment_subscription_id' => NULL,
                ]);
            } else {
                $stripe->subscriptionSchedules->cancel(
                    $user->subscription_schedule_id,
                    []
                );

                db()->where('user_id', $user_id)->update('subscriptions', [
                    'end_date'    => Date::$date,
                ]);


                db()->where('user_id', $user_id)->update('users', [
                    'subscription_schedule_id' => Null,
                ]);

                $subscriptionUser = analyticsDatabase()->query("SELECT * FROM `subscription_users` WHERE `user_id` = {$user->user_id} AND  `subscription_change` != 'cancellation' AND  `subscription_change` != 'delinquent' ORDER BY `id` DESC LIMIT 1")->fetch_object();
                if ($subscriptionUser) {

                    analyticsBb()->insert('subscription_users', [
                        'user_id'                 => $user->user_id,
                        'subscription_change'     => 'cancellation',
                        'change_date'             => Date::$date,
                        'new_plan'                => NULL,
                        'previous_plan'           => $subscriptionUser->new_plan,
                        'new_plan_amount'         => NULL,
                        'previous_plan_amount'    => isset($subscriptionUser->new_plan_amount) ? $subscriptionUser->new_plan_amount : null,
                        'currency'                => $subscriptionUser->currency,

                    ]);
                }
            }
            Alerts::add_success('Payment was cancelled successfully');
            /* Clear the cache */
            \Altum\Cache::$adapter->deleteItemsByTag('user_id=' . $user->user_id);
            return Response::jsonapi_success('success', null, 200);
        } catch (\Exception $e) {
            dil($e->getMessage());
            return Response::jsonapi_success('failed', null, 400);
        }
    }


    public function update_user_online_status()
    {
        $user_id = $_POST['userId'];

        $onlineUser =  db()->where('user_id', $user_id)->getOne('dpf_online');
        // Set user status to  online
        if ($onlineUser) {
            db()->where('user_id', $user_id)->update('dpf_online', [
                'last_activity' => (new \DateTime())->format('Y-m-d H:i:s')
            ]);
        } else {
            db()->insert('dpf_online', [
                'user_id'           => $user_id,
                'status'            => 'online',
                'last_activity' => (new \DateTime())->format('Y-m-d H:i:s')
            ]);
        }

        $response = [
            'status' => 'success',
        ];

        return Response::jsonapi_success($response, null, 200);
    }

    public function cancelPopupDelinquentUser()
    {

        $userId              = $_POST['user_id'];
        $planId              = $_POST['plan_id'];
        $discount            = $_POST['discount'];
        $monthFree           = $_POST['month_free'];
        $subcription_id      = $_POST['subId'];
        $new_subscription_id = $_POST['new_subscription_id'];
        $setup_intent        = $_POST['setup_intent'];

        $user  = db()->where('user_id', $userId)->getOne('users');
        $plan  = db()->where('plan_id', $planId)->getOne('plans');

        $stripe = new \Stripe\StripeClient(settings()->stripe->secret_key);


        if ($user) {

            $payment_currency  = $user->payment_currency;

            try {
                if ($plan->plan_id == 1) {
                    $payment_total_amount  = $user->payment_total_amount;
                    if ($payment_total_amount == '39.95') {
                        $total   = 39.95;
                    } else {
                        $total   = get_plan_month_price($plan->plan_id, $payment_currency);
                    }
                } else {
                    $total      = get_plan_price($plan->plan_id, $payment_currency);
                }

                $new_plan_amount  = number_format($total - ($total / 100 * $discount), 2, '.', '');

                $stripe->subscriptions->cancel(
                    $subcription_id,
                    ['cancellation_details' => ['comment' => 'discount_plan']]
                );

                if ($monthFree == 'yes') {
                    $new_plan_amount  = 0;
                    $cancel_promo     = 3;

                    db()->where('user_id', $user->user_id)->update('users', [
                        'plan_expiration_date' => (new \DateTime())->modify('+1 months')->format('Y-m-d H:i:s'),
                        'payment_subscription_id' => $new_subscription_id,
                        'plan_id' => $planId,
                    ]);

                    $setupIntent = $stripe->setupIntents->retrieve(
                        $setup_intent,
                        []
                    );

                    db()->where('user_id', $user->user_id)->update('payment_methods', [
                        'status' => 0,
                    ]);

                    $paymentMethod  = $stripe->paymentMethods->retrieve($setupIntent->payment_method);
                    $card = $paymentMethod->card->brand . ' ****' . $paymentMethod->card->last4;

                    db()->insert('payment_methods', [
                        'user_id'           => $user->user_id,
                        'payment_method'    => $setupIntent->payment_method,
                        'card'              => $card,
                        'status'            => true,
                        'updated_at'        => (new \DateTime())->format('Y-m-d H:i:s'),
                    ]);

                    $stripe->customers->update(
                        $user->stripe_customer_id,
                        ['invoice_settings' => ['default_payment_method' => $setupIntent->payment_method]]
                    );

                    $previousSubscriptionUser = analyticsDatabase()->query("SELECT * FROM `subscription_users` WHERE `user_id` = {$user->user_id} AND  `subscription_change` != 'cancellation' AND  `subscription_change` != 'delinquent' ORDER BY `id` DESC LIMIT 1")->fetch_object();

                    $analytic_user = analyticsBb()->where('user_id', $user->user_id)->getOne('users');


                    $subscription_change  = 'reactivation';
                    $new_plan             = $plan->name . ' -  Discount 100';
                    $previous_plan        = $previousSubscriptionUser->new_plan;
                    $previous_plan_amount = $previousSubscriptionUser->new_plan_amount;

                    if ($previousSubscriptionUser->new_plan == 'trial_limited' || $previousSubscriptionUser->new_plan == 'trial_full') {
                        $conversion_name       = 'DPF Reactivation';
                        $conversion_name_2     = 'DPF Purchase';
                        $subscription_change_2 = 'first_purchase';
                    } else {
                        $conversion_name       = 'Reactivation';
                        $conversion_name_2     = $analytic_user->onboarding_funnel == 4 ? 'DPF Purchase Renewal' : 'CFF Purchase Renewal';
                        $subscription_change_2 = 'purchase';
                    }

                    try {
                        analyticsBb()->insert('subscription_users', [
                            'user_id'                 => $user->user_id,
                            'unique_id'               => $analytic_user->unique_id,
                            'subscription_change'     => $subscription_change,
                            'change_date'             => Date::$date,
                            'new_plan'                => $new_plan,
                            'previous_plan'           => $previous_plan,
                            'new_plan_amount'         => $new_plan_amount,
                            'previous_plan_amount'    => $previous_plan_amount,
                            'currency'                => $payment_currency,

                        ]);
                    } catch (Exception $e) {
                        dil('subscription_users table not updated - ' . $user->user_id);
                        dil($e);
                    }


                    try {
                        analyticsBb()->insert('conversion_data', [
                            'user_id'             => $user->user_id,
                            'first_name'          => $analytic_user->first_name,
                            'last_name'           => $analytic_user->last_name,
                            'unique_id'           => $analytic_user->unique_id,
                            'client_id'           => $analytic_user->client_id,
                            'email_id'            => $user->email,
                            'google_click_id'     => $analytic_user->google_click_id,
                            'gaid'                => $analytic_user->gaid,
                            'country'             => $user->country,
                            'subscription_change' => $subscription_change,
                            'previous_plan'       => $previous_plan,
                            'previous_plan_amount' => $previous_plan_amount,
                            'new_plan'            => $new_plan,
                            'new_plan_amount'     => $new_plan_amount,
                            'currency'            => $payment_currency,
                            'conversion_name'     => $conversion_name,
                            'transaction_id'      => null,
                            'onboarding_funnel'   => $user->onboarding_funnel,
                            'create_time'         => \Altum\Date::$date,
                            'signup_date'         => $analytic_user->signup_date,
                        ]);
                    } catch (Exception $e) {
                        dil('conversion_data table not updated - ' . $user->user_id);
                        dil($e);
                    }

                    if ($conversion_name_2 && $subscription_change_2) {

                        try {
                            analyticsBb()->insert('subscription_users', [
                                'user_id'                 => $user->user_id,
                                'unique_id'               => $analytic_user->unique_id,
                                'subscription_change'     => $subscription_change_2,
                                'change_date'             => Date::$date,
                                'new_plan'                => $new_plan,
                                'previous_plan'           => $previous_plan,
                                'new_plan_amount'         => $new_plan_amount,
                                'previous_plan_amount'    => $previous_plan_amount,
                                'currency'                => $payment_currency,

                            ]);
                        } catch (Exception $e) {
                            dil('subscription_users table second record not updated - ' . $user->user_id);
                            dil($e);
                        }

                        try {
                            analyticsBb()->insert('conversion_data', [
                                'user_id'             => $user->user_id,
                                'first_name'          => $analytic_user->first_name,
                                'last_name'           => $analytic_user->last_name,
                                'unique_id'           => $analytic_user->unique_id,
                                'client_id'           => $analytic_user->client_id,
                                'email_id'            => $user->email,
                                'google_click_id'     => $analytic_user->google_click_id,
                                'gaid'                => $analytic_user->gaid,
                                'country'             => $user->country,
                                'subscription_change' => $subscription_change_2,
                                'previous_plan'       => $previous_plan,
                                'previous_plan_amount'    => $previous_plan_amount,
                                'new_plan'            => $new_plan,
                                'new_plan_amount'     => $new_plan_amount,
                                'currency'            => $payment_currency,
                                'conversion_name'     => $conversion_name_2,
                                'transaction_id'      => null,
                                'onboarding_funnel'   => $user->onboarding_funnel,
                                'create_time'         => \Altum\Date::$date,
                                'signup_date'         => $analytic_user->signup_date,
                            ]);
                        } catch (Exception $e) {
                            dil('conversion_data table second record not updated - ' . $user->user_id);
                            dil($e);
                        }
                    }
                } else {

                    if ($discount == '70') {
                        $cancel_promo  = 1;
                    } else if ($discount == '90') {
                        $cancel_promo  = 2;
                    }
                    $new_plan_amount  = $new_plan_amount;
                }

                db()->where('user_id', $user->user_id)->update('users', [
                    'cancel_promo' => $cancel_promo,
                    'is_switch_plan' => '1',
                ]);

                analyticsBb()->where('user_id', $user->user_id)->update('users', [
                    'cancel_promo' => $cancel_promo,
                ]);

                if (isset($_SESSION['delinquentClientSecret']) &&  $_SESSION['delinquentClientSecret'] != '') {
                    unset($_SESSION['delinquentClientSecret']);
                }

                if (isset($_SESSION['subscriptionId']) &&  $_SESSION['subscriptionId'] != '') {
                    unset($_SESSION['subscriptionId']);
                }

                $data = [
                    'error' => '',
                    'complete' => true,
                ];
                return Response::jsonapi_success($data, null, 200);
            } catch (\Exception $th) {
                $data = [
                    'error'    => l('pay.error_message.payment_gateway'),
                    'complete' => false,
                ];

                return Response::jsonapi_error($data, null, 400);
            }
        } else {
            $data = [
                'error'    => l('pay.error_message.payment_gateway'),
                'complete' => false,
            ];

            return Response::jsonapi_error($data, null, 400);
        }
    }


    // delinquent user create client secret
    public function createClientSecret()
    {

        $discount   = $_POST['discount'];
        $user_id    = $_POST['user_id'];
        $priceId    = $_POST['price_id'];
        $month_free = $_POST['month_free'];

        $user   = db()->where('user_id', $user_id)->getOne('users');
        $stripe = new \Stripe\StripeClient(settings()->stripe->secret_key);

        switch ($discount) {
            case 70:
                $couponCode     = STRIPE_COUPON_70_FOREVER;
                break;
            case 90:
                $couponCode     = STRIPE_COUPON_90_FOREVER;
                break;
            default:
        }

        if ($user) {
            $customerId     = $user->stripe_customer_id;
            $userCurrency   = $user->payment_currency;
            $customer       =  $stripe->subscriptions->all([
                'customer' => $customerId
            ]);

            $subcription_id = $customer->data[0]->id;
            $subscription   = $stripe->subscriptions->retrieve($subcription_id);

            if (isset($_SESSION['delinquentClientSecret']) &&  $_SESSION['delinquentClientSecret'] != '') {
                $clientSecret = $_SESSION['delinquentClientSecret'];
            } else {
                try {

                    if ($month_free == 'yes') {
                        $subscription = $stripe->subscriptions->create([
                            'customer' => $customerId,
                            'items' => [[
                                'price' => $priceId,
                            ]],
                            'currency' => $userCurrency,
                            'coupon' => $couponCode,
                            'trial_period_days' => 30,
                            'payment_settings' => ['save_default_payment_method' => 'on_subscription'],
                            'payment_behavior' => 'default_incomplete',
                            'expand' => ['latest_invoice.payment_intent', 'pending_setup_intent'],
                        ]);

                        $clientSecret = $subscription->pending_setup_intent->client_secret;

                        $type = 'setup';
                    } else {
                        $subscription = $stripe->subscriptions->create([
                            'customer' => $customerId,
                            'items' => [[
                                'price' => $priceId,
                            ]],
                            'coupon' => $couponCode,
                            'currency' => $userCurrency,
                            'payment_behavior' => 'default_incomplete',
                            'payment_settings' => ['save_default_payment_method' => 'on_subscription'],
                            'expand' => ['latest_invoice.payment_intent', 'pending_setup_intent'],
                        ]);

                        $type = 'payment';
                        $clientSecret = $subscription->latest_invoice->payment_intent->client_secret;
                    }

                    $_SESSION['delinquentClientSecret'] = $clientSecret;
                } catch (Exception $e) {
                    $data = [
                        'error' => l('pay.error_message.payment_gateway'),
                        'complete' => false,
                    ];
                    return Response::jsonapi_error($data, null, 400);
                }
            }

            if (isset($clientSecret)) {
                $_SESSION['subscriptionId'] = $subscription->id;

                $data = [
                    'error'           => '',
                    'clientSecret'    => $clientSecret,
                    'subscriptionId'  => $subscription->id,
                    'complete'        => true,
                    'type'            => $type,
                ];
                return Response::jsonapi_success($data, null, 200);
            } else {
                $data = [
                    'error' => l('pay.error_message.payment_gateway'),
                    'complete' => false,
                ];
                return Response::jsonapi_error($data, null, 400);
            }
        } else {
            $data = [
                'error' => l('pay.error_message.payment_gateway'),
                'complete' => false,
            ];
            return Response::jsonapi_error($data, null, 400);
        }
    }

    public function unsetDelinquentSession()
    {

        $user_id =  $_POST['user_id'];

        unset_delinquent_session($user_id);

        $data = [
            'error'         => '',
            'complete'      => true,
        ];
        return Response::jsonapi_success($data, null, 200);
    }

    public function get_user_by_email(){
        $email = $_POST['email'];
        if (isset($email)) {
            $user =  db()->where('email', $email)->getOne('users');
            
            if ($user) {
                $response = [
                    'status' => 'success',
                    'uid' => $user->user_id
                ];
            }else{
                $response = [
                    'status' => 'failed ',
                    'uid' => null
                ];
            }
            
        }else{
            $response = [
                'status' => 'failed',
                'uid' => null
            ];
        }       
       
        return Response::jsonapi_success($response, null, 200);
    }
    public function refund_payment(){     


        $payment_id = isset($_POST['payment_id']) ? $_POST['payment_id'] : null;
        $refund_type = isset($_POST['option']) ? $_POST['option'] : null;
        $err_msg = null;

        if (!Csrf::check('global_token')) {
            $data = [
                'success' => false,
            ];
        }        
       
        if (isset($payment_id)) {         

            /* details about the payment */
            $payment = db()->where('id', $payment_id)->getOne('payments');          

            /* details about the user who paid */
            $user = db()->where('user_id', $payment->user_id)->getOne('users');
            
            $refund_message = null;
            switch ($refund_type) {
                case 'option1':
                    $refund_message = 'full_refund';
                    break;
                case 'option2':
                    $refund_message = 'keep_renewal';
                    break;
                case 'option3':
                    $refund_message = 'full_partial_refund';
                    break;
                case 'option4':
                    $refund_message = 'partial_keep_renewal';
                    break;                 
                default:
                    $refund_message = '';
                    break;
            }
            $stripe = new \Stripe\StripeClient(settings()->stripe->secret_key);

            try {
                $PaymentIntent  = $stripe->paymentIntents->retrieve(
                    $payment->payment_id,
                    []
                );
                $latestChargeId = $PaymentIntent['latest_charge'];
                
                try {
                    if (isset($_POST['refund_amount'])) {
                        $stripe->refunds->create([
                            'charge' => $latestChargeId,
                            'metadata' => [
                                'message' => $refund_message,
                            ],
                            'amount' => $_POST['refund_amount'] * 100
                        ]);
                        Alerts::add_success('The refund was successfully made.');
                    } else {
                        $stripe->refunds->create([
                            'charge' => $latestChargeId,
                            'metadata' => [
                                'message' => $refund_message,
                            ],
                        ]);
                        Alerts::add_success('The refund was successfully made.');                       
                    }

                } catch (\Stripe\Exception\InvalidRequestException $e) {
                    dil($e->getMessage());
                    $err_msg = $e->getMessage();                                    
                }
            } catch (\Stripe\Exception\InvalidRequestException $e) {
                $err_msg = $e->getMessage();
                dil($e->getMessage());
            }

            sleep(2);

            /* Clear the cache */
            \Altum\Cache::$adapter->deleteItemsByTag('user_id=' . $user->user_id);
            
        }      
        
        $data = [
            'success' => true,
            'message' => $err_msg ?? null           
        ];
        return Response::jsonapi_success($data, null, 200);
    }
}
