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
use Altum\Middlewares\Authentication;
use Altum\Date;
use Exception;

class ChangePlan extends Controller
{

    public function index()
    {

        if (!Authentication::check()) {
            if (isset($_GET['id'])) {
                $user  = db()->where('referral_key', $_GET['id'])->getOne('users');
                if (!$user) {
                    return redirect('plans-and-prices');
                }

                $billingInfo  = json_decode($user->billing);
            }
        } else {
            $billingInfo   = $this->user->billing;
            Authentication::guard();
        }

        $plan_id = isset($this->params[0]) ? $this->params[0] : null;

        if (!settings()->payment->is_enabled) {
            redirect();
        }

        $user   =  isset($this->user->user_id) ? $this->user : $user;

        if ($user->plan_id == $plan_id) {
            redirect('plan/upgrade');
        }

        $plan_id = (int) $plan_id;

        /* Check if plan exists */
        $plan = (new \Altum\Models\Plan())->get_plan_by_id($plan_id);

        /* Make sure the plan is enabled */
        if (!$plan->status) {
            redirect('plan');
        }

        if (!isset($billingInfo->name) && $billingInfo->name == '') {
            redirect('pay-billing/' . $plan_id);
        }

        $payment_user = $user;

        $viewInfo = false;
        if (empty($billingInfo->name) || empty($billingInfo->line1) || empty($billingInfo->city) || empty($billingInfo->country)) {
            $viewInfo = true;
        }

        $customerId = null;

        try {
            $stripe = new \Stripe\StripeClient(settings()->stripe->secret_key);
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


        $data = [
            'plan'         => $plan,
            'info'         => $billingInfo,
            'plan_id'      => $plan_id,
            'customerId'   => $customerId,
            'stripe'       => $stripe,
            'info'         => $payment_user->billing,
            'view_info'    => $viewInfo,
            'user'         => $user,
        ];


        $view = new \Altum\Views\View('pay/change_plan', (array) $this);
        $this->add_view_content('content', $view->run($data));
    }


    public function update()
    {
        if (!empty($_POST)) {

            $user_id =  $_POST['user_id'];
            $user  = db()->where('user_id', $user_id)->getOne('users');

            if (!$user) {
                redirect('plan');
            }

            $subscriptionUser = analyticsDatabase()->query("SELECT * FROM `subscription_users` WHERE `user_id` = {$user->user_id} AND  `subscription_change` != 'cancellation' AND  `subscription_change` != 'refund' ORDER BY `id` DESC LIMIT 1")->fetch_object();
            $currentPlan =  $subscriptionUser->new_plan;
            $planName =  $_POST['plan_name'];
            $payment_total =  $_POST['total_amount'];
            $subscriptionChange  = subscription_change($currentPlan, $planName);
            $currency =  $_POST['currency'];
           
            analyticsBb()->insert('subscription_users', [
                'user_id'                 => $user->user_id,
                'subscription_change'     => $subscriptionChange,
                'change_date'             => Date::$date,
                'new_plan'                => $planName,
                'previous_plan'           => isset($subscriptionUser->new_plan) ? $subscriptionUser->new_plan : null,
                'new_plan_amount'         => $payment_total,
                'previous_plan_amount'    => isset($subscriptionUser->new_plan_amount) ? $subscriptionUser->new_plan_amount : null,
                'currency'                => $currency
            ]);

            $priceId = $_POST['priceId'];
            try {

                $paymentMethod = db()->where('user_id', $user->user_id)->where('status', 1)->getOne('payment_methods');

                $stripe = new \Stripe\StripeClient(settings()->stripe->secret_key);
                if ($_POST['new_plan_id'] == 5) {

                    if (strtolower($currency) == 'clp') {
                        $stripeTotal = $payment_total;
                    } else {
                        $stripeTotal = $payment_total * 100;
                    }

                    $stripe->subscriptions->cancel(
                        $user->payment_subscription_id,
                        ['cancellation_details' => ['comment' => 'discount_plan']]

                    );

                    $payment_intent = $stripe->paymentIntents->create([
                        'customer' => $user->stripe_customer_id,
                        'amount' => $stripeTotal,
                        'currency' => $currency,
                        'description' => 'One-time payment',
                        'payment_method' => $paymentMethod->payment_method,
                        'metadata' => [
                            'plan_id' => $_POST['new_plan_id'],
                            'payment_frequency' => 'onetime',
                        ],
                        'payment_method_types' => ['card'],
                        'confirm' => true,
                        'capture_method' => 'automatic_async'
                    ]);
                } else if ($user->payment_subscription_id == 'onetime' && !$user->subscription_schedule_id) {

                    $subscriptionSchedule = $stripe->subscriptionSchedules->create([
                        'customer' => $user->stripe_customer_id,
                        'start_date' => strtotime((new \DateTime())->modify('+14 days')->format('Y-m-d H:i:s')),
                        'end_behavior' => 'release',
                        'phases' => [
                            [
                                'items' => [
                                    [
                                        'price' => $priceId,
                                        'quantity' => 1,
                                    ],
                                ],

                            ],
                        ],
                        'default_settings' => [
                            'default_payment_method' =>  $paymentMethod->payment_method,
                        ],
                        'currency' => $currency
                    ]);

                    db()->where('user_id', $user->user_id)->update('users', [
                        'subscription_schedule_id' => $subscriptionSchedule->id,
                    ]);
                } else {

                    $subscription = $stripe->subscriptions->retrieve($user->payment_subscription_id);
                    $currentPriceId = $subscription->plan->id;
                    $startDate = $subscription->current_period_start;
                    $subscriptionSchedule = $stripe->subscriptionSchedules->create(['from_subscription' => $user->payment_subscription_id]);
                    $subscriptionSchedule = $stripe->subscriptionSchedules->update(
                        $subscriptionSchedule->id,
                        [

                            'phases' => [

                                [
                                    'items' => [
                                        [
                                            'price' => $currentPriceId,
                                            'quantity' => 1,
                                        ],
                                    ],
                                    'start_date' => $startDate,
                                    'iterations' => 1,
                                ],
                                [
                                    'items' => [
                                        [
                                            'price' => $priceId,
                                            'quantity' => 1,
                                        ],
                                    ],
                                ],
                            ],

                        ]
                    );


                    $subscription = db()->where('subscription_id', $user->payment_subscription_id)->getOne('subscriptions');

                    if ($subscription) {

                        db()->where('subscription_id', $user->payment_subscription_id)->update('subscriptions', [
                            'end_date' => $user->plan_expiration_date,
                        ]);

                        db()->insert('subscriptions', [
                            'user_id' => $user->user_id,
                            'plan_id' => $_POST['new_plan_id'],
                            'subscription_id' => $user->payment_subscription_id,
                            'start_date' => $user->plan_expiration_date,
                        ]);

                        if ($user->email_subscription_type != 2) {
                            $template  = 'new-subscription';
                            trigger_email($user->user_id, $template);
                        }
                    } else {
                        Alerts::add_error(l('upgrade_checkout.plan_error'));
                        redirect('change-plan/' . $_POST['new_plan_id']);
                    }
                }

                $thank_you_url_parameters = '&plan_id=' . $_POST['new_plan_id'];
                $thank_you_url_parameters = '&ref=' . $user->referral_key;
                if ($_POST['new_plan_id'] != 5) {
                    $thank_you_url_parameters .= '&schedule_id=' . $subscriptionSchedule->id;
                }

                $_SESSION['pay_thank_you'] = true;
                redirect('pay-thank-you?' . $thank_you_url_parameters);
            } catch (\Stripe\Exception\ApiErrorException $e) {
                Alerts::add_error($e->getMessage());
                redirect('change-plan/' . $_POST['new_plan_id']);
            }
        } else {
            redirect('plan');
        }
    }
}
