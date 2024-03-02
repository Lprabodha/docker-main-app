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
use Altum\Response;
use Altum\Title;
use Exception;
use Stripe\Exception\ApiErrorException;
use DateTime;



class Pay extends Controller
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

            if (isset($_GET['id']) || isset($_GET['referral_key'])) {
                $id = $_GET['referral_key'] ?? $_GET['id'];

                $user  = db()->where('referral_key',  $id)->getOne('users');
                if (!$user) {
                    return redirect('plans-and-prices');
                }else{
                    $user->billing = json_decode($user->billing);
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

       
        if (!settings()->payment->is_enabled) {
            redirect();
        }


        $payment_processors = require APP_PATH . 'includes/payment_processors.php';
        $this->plan_id = isset($this->params[0]) ? $this->params[0] : null;
        $this->return_type = isset($_GET['return_type']) && in_array($_GET['return_type'], ['success', 'cancel']) ? $_GET['return_type'] : null;
        $this->payment_processor = isset($_GET['payment_processor']) && array_key_exists($_GET['payment_processor'], $payment_processors) ? $_GET['payment_processor'] : null;

        $payment_user               =  isset($this->user->user_id) ? $this->user : $user;
        $payment_subscription_id    =  $payment_user->payment_subscription_id ? $payment_user->payment_subscription_id : null;
        $user_plan_id               =  $payment_user->plan_id;
        $user_plan_expiration_date  =  $payment_user->plan_expiration_date;
        $stripe = new \Stripe\StripeClient(settings()->stripe->secret_key);


        

        switch ($this->plan_id) {
            case 'free':

                $this->plan = settings()->plan_free;

                if ($user_plan_id == 'free') {
                    Alerts::add_info(l('pay.free.free_already'));
                } else {
                    Alerts::add_info(l('pay.free.other_plan_not_expired'));
                }

                redirect('plan');

                break;

            default:

                $this->plan_id = (int) $this->plan_id;

                /* Check if plan exists */
                $this->plan = db()->where('plan_id', $this->plan_id)->getOne('plans');
                if (!$this->plan) {
                    redirect('plan');
                }
                $this->plan->settings = json_decode($this->plan->settings);
                break;
        }

        $activeStripeSubcription = db()->where('user_id', $payment_user->user_id)->orderBy('id', 'DESC')->getOne('subscriptions');
        if ($activeStripeSubcription) {
            try {
                $activeStripeSubcription = $stripe->subscriptions->retrieve(
                    $activeStripeSubcription->subscription_id,
                    []
                );
            } catch (ApiErrorException $e) {
                $activeStripeSubcription   = null;
            }
        } else {
            if($payment_user->stripe_customer_id){
                try {
                    $activeStripeSubcription = $stripe->subscriptions->all(

                        ['customer' => $payment_user->stripe_customer_id]
                    );

                    if ($activeStripeSubcription) {
                        $activeStripeSubcription = $activeStripeSubcription['data'][0];
                    }
                } catch (ApiErrorException $e) {
                    $activeStripeSubcription = null;
                }
            }else{
                $activeStripeSubcription = null;
            }
        }

        if ($activeStripeSubcription && $activeStripeSubcription->status != 'canceled' && (new DateTime($payment_user->plan_expiration_date) < new DateTime())) {
            $suspendsubcription  = $activeStripeSubcription;
        } else {
            $suspendsubcription = null;
        }

       
        if ($payment_user->onboarding_funnel == 4) {
           
            $queryString  = explode("&", explode("?", $_SERVER['REQUEST_URI'])[1]);
           
            $currentPlan = $payment_user->plan_id;
            if (count($queryString) > 0) {
                if (isset($payment_user) && $payment_subscription_id && ($currentPlan != 6 && $currentPlan != 7)) {
                    redirect('change-plan-dpf/' . $this->plan_id . '?' . implode('&', $queryString));
                } else if (($user_plan_id != '6' &&  $user_plan_id != '7') && $user_plan_expiration_date > \Altum\Date::$date) {
                    redirect('reactive-plan-dpf/' . $this->plan_id . '?' . implode('&', $queryString));
                } else {
                    redirect('pay-rdpf/' . $this->plan_id . '?' . implode('&', $queryString));
                }
            } else {
                if (isset($payment_user) && $payment_subscription_id && ($currentPlan != 6 && $currentPlan != 7)) {
                    redirect('change-plan-dpf/' . $this->plan_id);
                } else if (($user_plan_id != '6' &&  $user_plan_id != '7') && $user_plan_expiration_date > \Altum\Date::$date) {
                    redirect('reactive-plan-dpf/' . $this->plan_id);
                } else {
                    redirect('pay-rdpf/' . $this->plan_id);
                }
            }
        }
        

        if (isset($_GET['payment_intent']) && isset($_GET['redirect_status']) && $_GET['redirect_status'] === 'succeeded') {
            $currency = $_GET['currency'] ? $_GET['currency'] : 'USD';
            sleep(4);
            $this->redirect_pay_thank_you($currency);
        }

        /* Make sure the plan is enabled */
        if (!$this->plan->status) {
            redirect('plan');
        }


        if (isset($payment_user) && $payment_subscription_id) {
            $discountType = isset($_GET['type']) ? $_GET['type'] : null;
            if (($discountType == 'discounted' || $discountType == 'onetime')) {
                $queryString  = explode("&", explode("?", $_SERVER['REQUEST_URI'])[1]);

                redirect('change-plan/' . $this->plan_id . '?' . implode('&', $queryString));
            } else {
                if (isset($suspendsubcription)) {
                    if (isset($_GET['id'])) {
                        redirect('reactive-plan/' . $this->plan_id . '?id=' . $payment_user->referral_key);
                    } else {
                        redirect('reactive-plan/' . $this->plan_id);
                    }
                } else {
                    $queryString  = explode("&", explode("?", $_SERVER['REQUEST_URI'])[1]);
                    if (count($queryString) > 0) {
                        redirect('change-plan/' . $this->plan_id . '?' . implode('&', $queryString));
                    } else {
                        redirect('change-plan/' . $this->plan_id);
                    }
                }
            }
        } else {
            if (isset($suspendsubcription) &&  $payment_user->payment_processor != null) {
 
                if (isset($_GET['id'])) {
                    redirect('reactive-plan/' . $this->plan_id . '?id=' . $payment_user->referral_key);
                } else{
                    redirect('reactive-plan/' . $this->plan_id);  
                }
            }
        }



        if ($user_plan_id != 'free' && ($user_plan_expiration_date > \Altum\Date::$date ||  !$payment_user->payment_subscription_id)) {
            $queryString  = explode("&", explode("?", $_SERVER['REQUEST_URI'])[1]);
            if (count($queryString) > 0) {
                redirect('reactive-plan/' . $this->plan_id . '?' . implode('&', $queryString));
            } else {
                redirect('pay-rdpf/' . $this->plan_id);
            }
        }

        promo_email_trigger($payment_user->user_id, 'checkout');

        if (!empty($_POST) && !$this->return_type) {

            /* Check for code usage */
            if (settings()->payment->codes_is_enabled && isset($_POST['code'])) {
                $_POST['code'] = Database::clean_string($_POST['code']);
                $this->code = database()->query("SELECT * FROM `codes` WHERE `code` = '{$_POST['code']}' AND `redeemed` < `quantity`")->fetch_object();

                if ($this->code) {
                    if (db()->where('user_id', $this->user->user_id)->where('code_id', $this->code->code_id)->has('redeemed_codes')) {
                        $this->code = null;
                    }

                    if (!in_array($this->code->code_id, $this->plan->codes_ids)) {
                        $this->code = null;
                    }
                }
            }

            /* Check for any errors */
            if (!Csrf::check()) {
                Alerts::add_error(l('global.error_message.invalid_csrf_token'));
            }
        }

        /* Include the detection of callbacks processing */
        $this->payment_return_process($payment_user);

        /* Set a custom title */
        Title::set(sprintf(l('pay.title'), $this->plan->name));

        $viewInfo = false;
        if (empty($payment_user->billing->name) || empty($payment_user->billing->line1) || empty($payment_user->billing->city) || empty($payment_user->billing->country)) {
            $viewInfo = true;
        }
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


        /* Prepare the View */
        $data = [
            'plan_id'            => $this->plan_id,
            'plan'               => $this->plan,
            'plan_taxes'         => $this->plan_taxes,
            'payment_processors' => $payment_processors,
            'payment_extra_data' => $this->payment_extra_data,
            'info'               => $payment_user->billing,
            'view_info'          => $viewInfo,
            'discount'           => $discount,
            'user'               => $payment_user,
            'ref_key'            => isset($payment_user) ? $payment_user->referral_key : null,
            'customerId'         => $customerId,
            'stripe'             => $stripe
        ];



        $view = new \Altum\Views\View('pay/index', (array) $this);

        $this->add_view_content('content', $view->run($data));
    }
   

    private function payment_return_process($payment_user)
    {

        /* Return confirmation processing if successfully */
        if ($this->return_type && $this->payment_processor && $this->return_type == 'success') {
            /* Redirect to the thank you page */
            $this->redirect_pay_thank_you($payment_user);
        }

        /* Return confirmation processing if failed */
        if ($this->return_type && $this->payment_processor && $this->return_type == 'cancel') {
            Alerts::add_error(l('pay.error_message.canceled_payment'));
            redirect('pay/' . $this->plan_id . '?' . (isset($_GET['trial_skip']) ? '&trial_skip=true' : null) . (isset($_GET['code']) ? '&code=' . $_GET['code'] : null));
        }
    }

    /* Ajax to check if discount codes are available */
    public function code()
    {
        Authentication::guard();

        $_POST = json_decode(file_get_contents('php://input'), true);

        if (!Csrf::check('global_token')) {
            die();
        }

        if (!settings()->payment->is_enabled || !settings()->payment->codes_is_enabled) {
            die();
        }

        if (empty($_POST)) {
            die();
        }

        $_POST['plan_id'] = (int) $_POST['plan_id'];
        $_POST['code'] = trim(Database::clean_string($_POST['code']));

        if (!$plan = db()->where('plan_id', $_POST['plan_id'])->getOne('plans')) {
            Response::json(l('pay.error_message.code_invalid'), 'error');
        }
        $plan->codes_ids = json_decode($plan->codes_ids);

        /* Make sure the discount code exists */
        $code = database()->query("SELECT * FROM `codes` WHERE `code` = '{$_POST['code']}' AND `redeemed` < `quantity`")->fetch_object();

        if (!$code) {
            Response::json(l('pay.error_message.code_invalid'), 'error');
        }

        if (!in_array($code->code_id, $plan->codes_ids)) {
            Response::json(l('pay.error_message.code_invalid'), 'error');
        }

        if (db()->where('user_id', $this->user->user_id)->where('code_id', $code->code_id)->has('redeemed_codes')) {
            Response::json(l('pay.error_message.code_used'), 'error');
        }

        Response::json(
            sprintf(l('pay.success_message.code'), '<strong>' . $code->discount . '%</strong>'),
            'success',
            [
                'code' => $code,
                'submit_text' => $code->type == 'redeemable' ? sprintf(l('pay_custom_plan.code_redeemable'), $code->days) : l('pay_custom_plan.pay')
            ]
        );
    }

    /* Generate the generic return url parameters */
    private function return_url_parameters($return_type, $base_amount, $total_amount, $code, $discount_amount)
    {
        return
            '&return_type=' . $return_type
            . '&payment_processor=' . $_POST['payment_processor']
            . '&payment_frequency=' . $_POST['payment_frequency']
            . '&payment_type=' . $_POST['payment_type']
            . '&code=' . $code
            . '&discount_amount=' . $discount_amount
            . '&base_amount=' . $base_amount
            . '&total_amount=' . $total_amount;
    }

    /* Simple url generator to return the thank you page */
    private function redirect_pay_thank_you($currency)
    {
        $urlParameters = array_filter($_GET, function ($key) {
            return $key != 'altum';
        }, ARRAY_FILTER_USE_KEY);

        $thank_you_url_parameters = 'payment_intent=' . $urlParameters['payment_intent'];
        $thank_you_url_parameters .= '&plan_id=' . $this->plan_id;
        $thank_you_url_parameters .= '&currency=' . $currency;
        if (isset($_GET['schedule_id'])) {
            $thank_you_url_parameters .= '&schedule_id=' . $_GET['schedule_id'];
        }
        if (isset($_GET['ref'])) {
            $thank_you_url_parameters .= '&ref=' . $_GET['ref'];
        }


        $_SESSION['pay_thank_you'] = true;

        redirect('pay-thank-you?' . $thank_you_url_parameters);
    }
}
