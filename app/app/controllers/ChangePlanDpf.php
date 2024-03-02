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
use Altum\Title;

class ChangePlanDpf extends Controller
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

        
        if(isset($this->user->user_id)){
            $payment_user = $this->user;
        }else{                   
            $payment_user = $user;
        }
       

        $plan_id = isset($this->params[0]) ? $this->params[0] : null;

        if (!settings()->payment->is_enabled) {
            redirect();
        }


        if ($payment_user->plan_id == $plan_id) {
            redirect('plan-rdpf/upgrade');
        }

       
        $plan_id = (int) $plan_id;

        /* Check if plan exists */
        $plan = (new \Altum\Models\Plan())->get_plan_by_id($plan_id);

        /* Make sure the plan is enabled */
        if (!$plan->status) {
            redirect('plan');
        }

        $data = [
            'plan' => $plan,
            'info' => $payment_user->billing,
            'plan_id' => $plan_id,
            'user' => $payment_user,
        ];
        
        $view = new \Altum\Views\View('pay-dpf/change_plan', (array) $this);
        $this->add_view_content('content', $view->run($data));
    }


    public function update()
    {
        if (!empty($_POST)) {
            
            $user  = db()->where('user_id', $_POST['user_id'])->getOne('users');

            if ($user->onboarding_funnel == 4 && $user->plan_id == 6 || $user->plan_id == 7) {

                $stripe = new \Stripe\StripeClient(settings()->stripe->secret_key);

                if ($user->payment_subscription_id) {
                    // (new User())->cancel_subscription($this->user->user_id);

                    $paymentMethods = $stripe->customers->allPaymentMethods(
                        $user->stripe_customer_id,
                        ['type' => 'card']
                    );

                    $paymentMethod = $paymentMethods['data'][0]['id'];

                    try {
                        $stripe->subscriptions->cancel(
                            $user->payment_subscription_id,
                            ['cancellation_details' => ['comment' => 'discount_plan']]
                        );
                    } catch (\Exception $e) {
                        echo 'Error: ' . $e->getMessage();
                    }

                    $priceId = $_POST['priceId'];

                    if ($priceId != STRIPE_PRICE_ONETIME_ID) {
                        try {
                            $stripe->subscriptions->create([
                                'customer' => $user->stripe_customer_id,
                                'items' => [['price' => $priceId]],
                                'default_payment_method' => $paymentMethod,
                            ]);
                        } catch (\Exception $e) {
                            echo 'Error: ' . $e->getMessage();
                        }
                    } else {

                        try {
                            $code = null;
                            if ($exchange_rate = exchange_rate($user)) {
                                $rate   = $exchange_rate['rate'];
                                $symbol = $exchange_rate['symbol'];
                                $code   = $exchange_rate['code'];
                            }

                            $userCurrency = $user->payment_currency;

                            $currency = 'USD';
                            $countryCurrency = get_user_currency($code);
                            if ($userCurrency && $userCurrency != '') {
                                $currency = $userCurrency;
                            } else if ($countryCurrency) {
                                $currency = $code;
                            }

                            $total   = get_plan_price($_POST['new_plan_id'], $code);
                            
                            $payment_intent = $stripe->paymentIntents->create([
                                'customer' => $user->stripe_customer_id,
                                'amount' => get_stripe_format($total, $currency),
                                'currency' => $currency,
                                'payment_method_types' => ['card'], // Specify the payment method type.
                                'description' => 'One-time payment',
                                'metadata' => [
                                    'plan_id' => $_POST['new_plan_id'],
                                    'payment_frequency' => 'onetime',
                                ]
                            ]);

                            $clientSecret = $payment_intent->client_secret;
                            $_SESSION['clientSecret'] = $clientSecret;
                        } catch (\Exception $e) {
                            // dd($e->getMessage());
                        }
                    }
                }


                $thank_you_url_parameters = '&type=change';
                $thank_you_url_parameters .= '&plan_id=' . $_POST['plan_id'];
                $_SESSION['pay_thank_you'] = true;

                redirect('pay-thank-you-rdpf?' . $thank_you_url_parameters);
            } else {

                $subscriptionUser = analyticsDatabase()->query("SELECT * FROM `subscription_users` WHERE `user_id` = {$user->user_id} AND  `subscription_change` != 'cancellation' ORDER BY `id` DESC LIMIT 1")->fetch_object();
                $currentPlan = $subscriptionUser->new_plan;
                $planName = $_POST['plan_name'];
                $payment_total = $_POST['total_amount'];
                $currency = $_POST['currency'];
                $subscriptionChange = subscription_change($currentPlan, $planName);

                analyticsBb()->insert('subscription_users', [
                    'user_id' => $user->user_id,
                    'subscription_change' => $subscriptionChange,
                    'change_date' => Date::$date,
                    'new_plan' => $planName,
                    'previous_plan' => isset($subscriptionUser->new_plan) ? $subscriptionUser->new_plan : null,
                    'new_plan_amount' => $payment_total,
                    'previous_plan_amount' => isset($subscriptionUser->new_plan_amount) ? $subscriptionUser->new_plan_amount : null,
                    'currency' => $currency
                ]);


                $priceId = $_POST['priceId'];
                try {
                    $stripe = new \Stripe\StripeClient(settings()->stripe->secret_key);
                    if ($user->payment_subscription_id == 'onetime' && !$user->subscription_schedule_id) {

                        $paymentMethoeds = $stripe->customers->allPaymentMethods(
                            $user->stripe_customer_id,
                            ['type' => 'card']
                        );

                        $paymentMethoed = $paymentMethoeds['data'][0]['id'];

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
                                'default_payment_method' => $paymentMethoed,
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

                            //Send email new-subscription(Upgrade/Downgrade)

                            if($user->email_subscription_type != 2){
                                $template  = 'new-subscription';
                                trigger_email($user->user_id, $template);
                            }
                         
                        } else {
                            Alerts::add_error(l('upgrade_checkout.plan_error'));
                            redirect('change-plan-dpf/' . $_POST['plan_id']);
                        }
                    }

                    $thank_you_url_parameters = '&type=change';
                    $thank_you_url_parameters .= '&plan_id=' . $_POST['plan_id'];
                    $thank_you_url_parameters .= '&schedule_id=' . $subscriptionSchedule->id;
                    $_SESSION['pay_thank_you'] = true;

                    redirect('pay-thank-you-rdpf?' . $thank_you_url_parameters);
                } catch (\Stripe\Exception\ApiErrorException $e) {
                    Alerts::add_error($e->getMessage());
                    redirect('change-plan-dpf/' . $_POST['plan_id']);
                }
            }
        } else {
            redirect('plan');
        }
    }
}
