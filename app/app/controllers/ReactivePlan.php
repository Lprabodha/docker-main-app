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
use Stripe\Exception\ExceptionInterface;
use Altum\Date;
use Altum\Models\User;
use Exception;

class ReactivePlan extends Controller
{

    public function index()
    {


        if (!Authentication::check()) {

            if (isset($_GET['id'])) {
                $user  = db()->where('referral_key', $_GET['id'])->getOne('users');
                if (!$user) {
                    return redirect('plans-and-prices');
                }
            }
        } else {
            Authentication::guard();
        }

        $plan_id = isset($this->params[0]) ? $this->params[0] : null;

        if (!settings()->payment->is_enabled) {
            redirect();
        }

        $plan_id = (int) $plan_id;

        

        if (isset($this->user->user_id)) {
            $payment_user = $this->user;
        } else {
            if (!isset($user->billing->name)) {
                $user->billing = json_decode($user->billing);
            }
            $payment_user = $user;
        }

        /* Check if plan exists */
        $plan = (new \Altum\Models\Plan())->get_plan_by_id($plan_id);

        /* Make sure the plan is enabled */
        if (!$plan->status) {
            redirect('plan');
        }

        if ($payment_user->onboarding_funnel == 4) {
            redirect('reactive-plan-dpf/' . $plan_id);
        }

       

        $stripe = new \Stripe\StripeClient(settings()->stripe->secret_key);

        $viewInfo = false;
        if (empty($payment_user->billing->name) || empty($payment_user->billing->line1) || empty($payment_user->billing->city) || empty($payment_user->billing->country)) {
            $viewInfo = true;
        }

        $customerId = null;
        try {

            $stripe->applePayDomains->create([
                'domain_name' => APPLE_DOMAIN,
            ]);
            if (!$payment_user->stripe_customer_id) {
                $customer = $stripe->customers->create([
                    'email' => $payment_user->email,
                    'name'  => isset($payment_user->billing->name) ? $payment_user->billing->name : null,
                    'metadata'    => [
                        'user_id'    => $payment_user->user_id,
                        'user_email' => $payment_user->email
                    ]

                ]);
                $customerId = $customer->id;

                db()->where('email', $payment_user->email)->update('users', [
                    'stripe_customer_id' => $customerId,
                ]);
            } else {
                $customerId = $payment_user->stripe_customer_id;
            }
        } catch (Exception $e) {
            Alerts::add_error(l('pay.error_message.payment_gateway'));
        }



        if (isset($_GET['payment_intent']) ||  (isset($_GET['priceId']) && isset($_GET['setup_intent']) && isset($_GET['total']))) {

            if (isset($_GET['priceId']) && isset($_GET['setup_intent']) && isset($_GET['total'])) {               

                try {
                    $priceId = $_GET['priceId'];
                    $setupIntent =  $_GET['setup_intent'];
                    $stripe = new \Stripe\StripeClient(settings()->stripe->secret_key);
                    $payment = db()->where('user_id', $payment_user->user_id)->where('status', 1)->getOne('payments');

                    $setupIntent = $stripe->setupIntents->retrieve(
                        $setupIntent,
                        []
                    );

                    if (isset($_GET['code'])) {
                        $subscriptionSchedule = $stripe->subscriptionSchedules->create([
                            'customer' => $setupIntent->customer,
                            'start_date' => strtotime((new \DateTime($payment_user->plan_expiration_date))->modify('-2 hour')->format('Y-m-d H:i:s')),
                            'end_behavior' => 'release',
                            'phases' => [
                                [
                                    'items' => [
                                        [
                                            'price' => $priceId,
                                            'quantity' => 1,
                                        ],
                                    ],
                                    'currency' => $payment->currency,
                                    'coupon'   => $_GET['code'],
                                ],
                            ],
                            'default_settings' => [
                                'default_payment_method' => $setupIntent->payment_method,
                            ],
                        ]);
                    } else {

                        $subscriptionSchedule = $stripe->subscriptionSchedules->create([
                            'customer' => $setupIntent->customer,
                            'start_date' => strtotime((new \DateTime($payment_user->plan_expiration_date))->modify('-2 hour')->format('Y-m-d H:i:s')),
                            'end_behavior' => 'release',
                            'phases' => [
                                [
                                    'items' => [
                                        [
                                            'price' => $priceId,
                                            'quantity' => 1,
                                        ],
                                    ],
                                    'currency' => $payment->currency,
                                ],
                            ],
                            'default_settings' => [
                                'default_payment_method' => $setupIntent->payment_method,
                            ],
                        ]);
                    }

                    db()->where('user_id', $payment_user->user_id)->update('users', [
                        'subscription_schedule_id' => $subscriptionSchedule->id,
                    ]);

                    $thank_you_url_parameters = 'plan_id=' . $plan_id;
                    $thank_you_url_parameters .= '&reactive_schedule_id=' . $subscriptionSchedule->id;

                    $paymentId = $subscriptionSchedule->id;
                } catch (\Stripe\Exception\ApiErrorException $e) {
                    Alerts::add_error($e->getMessage());
                    redirect('change-plan/' . $plan_id);
                }
            } else if (isset($_GET['payment_intent']) && isset($_GET['total'])) {
                
                $thank_you_url_parameters = 'plan_id=' . $plan_id;
                $paymentId = $_GET['payment_intent'];
            }

            $subscriptionUser = analyticsDatabase()->query("SELECT * FROM `subscription_users` WHERE `user_id` = {$payment_user->user_id} AND  `subscription_change` != 'cancellation' ORDER BY `id` DESC LIMIT 1")->fetch_object();

            $planName =  $plan->name;
            $payment_total =  $_GET['total'];
    
            $previousSubscriptionUser = analyticsDatabase()->query("SELECT * FROM `subscription_users` WHERE `user_id` = {$payment_user->user_id} AND  `subscription_change` != 'cancellation' AND  `subscription_change` != 'delinquent' AND  `subscription_change` != 'reactivation' ORDER BY `id` DESC LIMIT 1")->fetch_object();
    
            
            analyticsBb()->insert('subscription_users', [
                'user_id'                 => $payment_user->user_id,
                'subscription_change'     => 'reactivation',
                'change_date'             => Date::$date,
                'new_plan'                => $planName,
                'previous_plan'           => $previousSubscriptionUser->new_plan,
                'new_plan_amount'         => $payment_total,
                'previous_plan_amount'    => $previousSubscriptionUser->new_plan_amount,
                'currency'                => $subscriptionUser->currency,
            ]);


            // create convertion data table
            $userName = get_user_name($payment_user->name);

            analyticsBb()->insert('conversion_data', [
                'user_id'             => $payment_user->user_id,
                'first_name'          => $userName['first_name'],
                'last_name'           => $userName['last_name'],
                'email_id'            => $payment_user->email,
                'gaid'                => $payment_user->gaid,
                'country'             => $payment_user->country,
                'subscription_change' => 'reactivation',
                'new_plan'            => $planName,
                'new_plan_amount'     => $payment_total,  
                'previous_plan'       => $previousSubscriptionUser->new_plan,
                'previous_plan_amount'=> $previousSubscriptionUser->new_plan_amount,                                    
                'currency'            => $subscriptionUser->currency,
                'conversion_name'     => 'Reactivation',
                'transaction_id'      => $paymentId,
                'onboarding_funnel'   => $payment_user->onboarding_funnel,
                'create_time'         => \Altum\Date::$date,
                'signup_date'         => $payment_user->datetime,
            ]);


            try {
                if ($plan_id == 5 || $plan_id == 4) {
                    $subcriptionId = get_pastdue_subscription($payment_user);

                    if($subcriptionId){
                        $stripe->subscriptions->cancel(
                            $subcriptionId,
                            ['cancellation_details' => ['comment' => 'discount_plan']]
                        );

                        db()->where('subscription_id', $subcriptionId)->update('subscriptions', [
                            'end_date'    => Date::$date,
                        ]);

                    }                        
                }
            } catch (\Throwable $th) {
                //throw $th;
            }
            

            $_SESSION['pay_thank_you'] = true;
            redirect('pay-thank-you?' . $thank_you_url_parameters);
        }

        $discount = null;
        if (isset($_GET['promo'])) {
            if ($_GET['promo'] == "70OFF") {
                $_SESSION['promo']    = "70OFF";
                $_SESSION['discount'] = 70;
                $discount = 70;
            }
        }


        $data = [
            'plan'      => $plan,
            'user'      => $payment_user,
            'plan_id'   => $plan_id,
            'info'      => $payment_user->billing,
            'view_info' => $viewInfo,
            'customerId' => $customerId,
            'stripe'    => $stripe,
            'discount'  => $discount,
        ];
        $view = new \Altum\Views\View('pay/reactive_plan', (array) $this);
        $this->add_view_content('content', $view->run($data));
    }
}
