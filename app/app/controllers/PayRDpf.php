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
use Altum\Date;
use Altum\Middlewares\Authentication;
use Altum\Middlewares\Csrf;
use Altum\Response;
use Altum\Title;
use Exception;

class PayRDpf extends Controller
{
    public $plan_id;
    public $return_type;
    public $payment_processor;
    public $plan;
    public $plan_taxes;
    public $applied_taxes_ids = [];
    public $code = null;
    public $payment_extra_data = null;


    public function index()
    {
        if (!Authentication::check()) {
            if (isset($_GET['id'])) {
                setcookie('referral_key', $_GET['id']);
                $user  = db()->where('referral_key', $_GET['id'])->getOne('users');
                if (!$user) {
                    return redirect('plans-and-prices');
                }

                if (isset($_GET['plan_type'])) {
                    Authentication::guard('guest');
                }
            } else if (isset($_GET['payment_intent']) && isset($_GET['redirect_status']) && $_GET['redirect_status'] === 'succeeded') {
                Authentication::guard('guest');
            } else {
                Authentication::guard();
            }
        } else {
            Authentication::guard();
        }

        $this->plan_id = isset($this->params[0]) ? $this->params[0] : null;

        if (!$this->plan_id) {
            redirect('plan-rdpf');
        }


        $payment_user               =  isset($this->user->user_id) ? $this->user : $user;
        $payment_subscription_id    =  $payment_user->payment_subscription_id ? $payment_user->payment_subscription_id : null;
        $user_plan_id               =  $payment_user->plan_id;
        $user_plan_expiration_date  =  $payment_user->plan_expiration_date;
        $this->plan_id = (int) $this->plan_id;
        $this->plan = db()->where('plan_id', $this->plan_id)->getOne('plans');

        promo_email_trigger($payment_user->user_id, 'checkout');

        if (isset($_GET['payment_intent']) && isset($_GET['redirect_status']) && $_GET['redirect_status'] === 'succeeded') {
            $this->redirect_pay_thank_you($payment_user);
        }


        $currentPlan = $payment_user->plan_id;
        if (isset($payment_user) && $payment_subscription_id && ($currentPlan != 6 && $currentPlan != 7)) {
            redirect('change-plan-dpf/' . $this->plan_id);
        }


        if (($user_plan_id != '6' &&  $user_plan_id != '7') && $user_plan_expiration_date > \Altum\Date::$date) {
            redirect('reactive-plan-dpf/' . $this->plan_id);
        }
        
        Title::set(sprintf(l('pay.title'), $this->plan->name));
        $discount = null;
        if (isset($_GET['promo'])) {
            if ($_GET['promo'] == "70OFF") {
                $_SESSION['promo']    = "70OFF";
                $_SESSION['discount'] = 70;
                $discount = 70;
            }
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

        $paymentMethod = db()->where('user_id', $payment_user->user_id)->where('status', 1)->getOne('payment_methods');



        /* Prepare the View */
        $data = [
            'plan_id'            => $this->plan_id,
            'plan'               => $this->plan,
            'plan_taxes'         => $this->plan_taxes,
            'payment_extra_data' => $this->payment_extra_data,
            'info'               => $payment_user->billing,
            'discount'           => $discount,
            'user'               => $payment_user,
            'ref_key'            => isset($payment_user) ? $payment_user->referral_key : null,
            'customerId'         => $customerId,
            'stripeClient'       => $stripe,
            'paymentMethod'      => $paymentMethod
        ];
      
        $view = new \Altum\Views\View('pay-dpf/renew', (array) $this);
        $this->add_view_content('content', $view->run($data));
    }


    /* Simple url generator to return the thank you page */
    private function redirect_pay_thank_you()
    {
        $thank_you_url_parameters = '&plan_id=' . $this->plan_id;
        $_SESSION['pay_thank_you'] = true;
        redirect('pay-thank-you-rdpf?' . $thank_you_url_parameters);
    }

    public function update()
    {

        $stripe = new \Stripe\StripeClient(settings()->stripe->secret_key);
        $referral_key = $_COOKIE['referral_key'] ? $_COOKIE['referral_key'] : null;
        $user  = db()->where('referral_key', $referral_key)->getOne('users');
        $payment_user = isset($this->user->user_id) ? $this->user : $user;

        // cancel current subscription if user already have a subscription 
        if ($payment_user &&  $payment_user->payment_subscription_id != null &&  $payment_user->payment_subscription_id != '') {            
            try {
                $stripe->subscriptions->cancel(
                    $payment_user->payment_subscription_id,
                    ['cancellation_details' => ['comment' => 'discount_plan']]
                );
            } catch (\Exception $e) {
                echo 'Error: ' . $e->getMessage();
            }
        }else if ($_POST['plan_id'] == 5 || $_POST['plan_id'] == 4) {
            $subcriptionId = get_pastdue_subscription($payment_user);
            if($subcriptionId){
                try {
                    $stripe->subscriptions->cancel(
                        $subcriptionId,
                        ['cancellation_details' => ['comment' => 'discount_plan']]
                    );

                    db()->where('subscription_id', $subcriptionId)->update('subscriptions', [
                        'end_date'    => Date::$date,
                    ]);
                    
                } catch (\Throwable $th) {
                    //throw $th;
                }
            }                        
        }      



        if ($_POST['plan_id'] == 5) {
            try {
                $payment = $stripe->paymentIntents->confirm(
                    $_POST['payment_intent'],
                    ['payment_method' => $_POST['pm']]
                );

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
            } catch (\Stripe\Exception\CardException $e) {

                $error = "A payment error occurred: {$e->getError()->message}";
                return Response::jsonapi_success(
                    ['payment' => 'failed', 'error' => $error],
                    null,
                    200
                );
            }
        } else {            
            if($_POST['plan_id'] == 1){
                db()->where('user_id', $payment_user->user_id)->update('users', [
                    'is_switch_plan'   => true,
                ]);
            }
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
        }

        setcookie("referral_key", "", time() - 3600);

        return Response::jsonapi_success(
            ['payment' => 'success', 'error' => ''],
            null,
            200
        );
    }
}
