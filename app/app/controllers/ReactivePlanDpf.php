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
use Altum\Response;
use Altum\Title;

class ReactivePlanDpf extends Controller
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
        $plan_id = (int) $plan_id;

        /* Check if plan exists */
        $plan = (new \Altum\Models\Plan())->get_plan_by_id($plan_id);

        /* Set a custom title */
        Title::set(sprintf(l('pay.title'), $plan->name));

        /* Make sure the plan is enabled */
        if (!$plan->status) {
            redirect('plan');
        }

        if ($payment_user->onboarding_funnel != 4) {
            redirect('reactive-plan/' . $plan_id);
        }

        if($payment_user->subscription_schedule_id){
            redirect('billing');
        }

      
        if (isset($_GET['payment_intent']) || (isset($_GET['priceId']) && isset($_GET['total']) && (isset($_GET['setup_intent'])) || isset($_GET['pm']))) {

           

            $subscriptionUser = analyticsDatabase()->query("SELECT * FROM `subscription_users` WHERE `user_id` = {$payment_user->user_id} AND  `subscription_change` != 'cancellation' ORDER BY `id` DESC LIMIT 1")->fetch_object();
            $payment = db()->where('user_id', $payment_user->user_id)->where('status', 1)->getOne('payments');

           
            $stripe = new \Stripe\StripeClient(settings()->stripe->secret_key);
            if(isset($_GET['pm']) &&  $plan_id == 5 && isset($_GET['pi'])){

                try {

                    $stripe->paymentIntents->confirm(
                        $_GET['pi'],
                        [
                        'payment_method' => $_GET['pm'],                             
                        ]
                    );

                    $thank_you_url_parameters = '?type=reactive';
                    $thank_you_url_parameters = 'plan_id=' . $plan_id;  
                    $paymentId = $_GET['pi'];  
                } catch (\Stripe\Exception\ApiErrorException $e) {
                    Alerts::add_error($e->getMessage());
                    redirect('reactive-plan/' . $plan_id);
                }
                
                
            }else if ( (isset($_GET['priceId']) && isset($_GET['setup_intent']) && isset($_GET['total'])) || isset($_GET['pm'])) {
               

                if($payment_user->subscription_schedule_id){
                    $stripe->subscriptionSchedules->cancel($payment_user->subscription_schedule_id, []);
                }

                $priceId = $_GET['priceId'];
                try {                   
                        if (isset($_GET['pm'])) {
                            $payment_method = $_GET['pm'];
                        }else{
    
                            $setupIntent =  $_GET['setup_intent'];
                            $setupIntent = $stripe->setupIntents->retrieve(
                                $setupIntent,
                                []
                            );
                            $payment_method = $setupIntent->payment_method;
                        }
    
                        if(isset($_GET['code'])){
    
                            $subscriptionSchedule = $stripe->subscriptionSchedules->create([
                                'customer' => $payment_user->stripe_customer_id,
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
                                    'default_payment_method' => $payment_method,
                                ],
                            ]);
    
                        }else{
    
                            $subscriptionSchedule = $stripe->subscriptionSchedules->create([
                                'customer' => $payment_user->stripe_customer_id,
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
                                    'default_payment_method' => $payment_method,
                                ],
                            ]);
    
                        }
    
                        sleep(3);
    
                        db()->where('user_id', $payment_user->user_id)->update('users', [
                            'subscription_schedule_id' => $subscriptionSchedule->id,
                        ]);  
    
                        $thank_you_url_parameters = '?type=reactive';
                        $thank_you_url_parameters .= '&plan_id=' . $plan_id;
                        $thank_you_url_parameters .= '&reactive_schedule_id=' . $subscriptionSchedule->id;
                        $paymentId = $subscriptionSchedule->id;       

                      

                } catch (\Stripe\Exception\ApiErrorException $e) {
                    Alerts::add_error($e->getMessage());
                    redirect('reactive-plan/' . $plan_id);
                }


            }else if (isset($_GET['payment_intent']) && isset($_GET['total'])){  

                $thank_you_url_parameters = '?type=reactive';
                $thank_you_url_parameters = 'plan_id=' . $plan_id;  
                $paymentId = $_GET['payment_intent'];          
            }

            $planName =  $plan->name;
            $payment_total =  $_GET['total'];
           
            $subscriptionUser = analyticsDatabase()->query("SELECT * FROM `subscription_users` WHERE `user_id` = {$payment_user->user_id} AND  `subscription_change` != 'cancellation' AND  `subscription_change` != 'delinquent' ORDER BY `id` DESC LIMIT 1")->fetch_object();

            analyticsBb()->insert('subscription_users', [
                'user_id'                 => $payment_user->user_id,                    
                'subscription_change'     => 'reactivation',
                'change_date'             => Date::$date,
                'new_plan'                => $planName,
                'previous_plan'           => $subscriptionUser->new_plan,
                'new_plan_amount'         => $payment_total,
                'previous_plan_amount'    => $subscriptionUser->new_plan_amount,
                'currency'                => $payment->currency,
            ]);

            $userName = get_user_name($payment_user->name);

            analyticsBb()->insert('conversion_data', [
                'user_id'             => $payment_user->user_id,
                'first_name'          => $userName['first_name'],
                'last_name'           => $userName['last_name'],
                'email_id'            => $payment_user->email,
                'gaid'                => $payment_user->gaid,
                'country'             => $payment_user->country,
                'subscription_change' => 'reactivation',
                'previous_plan'       => $subscriptionUser->new_plan,
                'previous_plan_amount'=> $subscriptionUser->new_plan_amount,
                'new_plan'            => $planName,
                'new_plan_amount'     => $payment_total,                    
                'currency'            => $subscriptionUser->currency,
                'conversion_name'     => 'Reactivation',
                'transaction_id'      => $paymentId,
                'onboarding_funnel'   => $user->onboarding_funnel,
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
            redirect('pay-thank-you-rdpf?' . $thank_you_url_parameters);
           
            
        }

        $paymentMethod = db()->where('user_id', $payment_user->user_id)->where('status', 1)->getOne('payment_methods');

        $discount = null;
        if (isset($_GET['promo'])) {
            if ($_GET['promo'] == "70OFF") {
                $_SESSION['promo']    = "70OFF";
                $_SESSION['discount'] = 70;
                $discount = 70;
            }
        }

        $data = [
            'plan' => $plan,            
            'plan_id' => $plan_id,
            'paymentMethod'  => $paymentMethod,
            'user'  =>  $payment_user, 
            'discount'  => $discount,
        ];

        $view = new \Altum\Views\View('pay-dpf/reactive_plan_dpf', (array) $this);
        $this->add_view_content('content', $view->run($data));
    }

    public function update()
    {


        $stripe = new \Stripe\StripeClient(settings()->stripe->secret_key);
        try {
            $subscription = $stripe->subscriptions->retrieve(
                $_POST['subscription'],
                []
            );

            try {
                $payment = $stripe->invoices->pay(
                    $subscription->latest_invoice,
                    ['payment_method' => $_POST['pm']]
                );

                if ($payment) {
                    $id = $payment->id;
                    $status = $payment->status;

                    if ($status) {
                        $url = SITE_URL . 'pay-rdpf/' . $_POST['plan_id'] . '?payment_intent=' . $id . '&redirect_status=succeeded';
                        return Response::jsonapi_success(
                            ['payment' => 'success', 'url' => $url],
                            null,
                            200
                        );
                    }
                }
            } catch (\Stripe\Exception\CardException $e) {

                $error = "A payment error occurred: {$e->getError()->message}";
                return Response::jsonapi_success(
                    ['payment' => 'failed', 'error' => $error],
                    null,
                    200
                );
            }
        } catch (\Stripe\Exception\CardException $e) {

            $error = "A payment error occurred: {$e->getError()->message}";
            return Response::jsonapi_success(
                ['payment' => 'failed', 'error' => $error],
                null,
                200
            );
        }

        return Response::jsonapi_success(
            ['payment' => 'success', 'error' => ''],
            null,
            200
        );
    }
}
