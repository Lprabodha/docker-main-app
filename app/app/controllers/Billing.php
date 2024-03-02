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
use Altum\Middlewares\Authentication;

use Altum\Alerts;
use Altum\Logger;
use Altum\Models\User;
use Altum\Middlewares\Csrf;
use Altum\Response;
use DateTime;
use Exception;
use Stripe\Exception\ApiErrorException;

class Billing extends Controller
{


    public function index()
    {

        Authentication::guard();
        
       
        if ($this->user->plan_id == 'free' && $this->user->payment_processor =='') {           
            redirect('plan');
        }

        // unset_delinquent_session
        unset_delinquent_session($this->user->user_id);

        $upcomingInvoices           = null;
        $stripeSubcriptionDiscount  = null;
        $upcomingDiscount = null;
        $isSwitchPlan = false;
        $dpfUser = db()->where('user_id', $this->user->user_id)->getOne('dpf_user_emails');
        if (!$this->user->is_switch_plan &&  $this->user->plan_id == 1 && $this->user->onboarding_funnel == 4 && !$dpfUser->is_trial_cancel) {
            $isSwitchPlan = true;
        }

        $stripe = new \Stripe\StripeClient(settings()->stripe->secret_key);

        $userDiscount = database()->query("SELECT * FROM `payments` WHERE `user_id` = {$this->user->user_id} AND `code` != '70OFF'  ORDER BY `id` ASC LIMIT 1")->fetch_object();

        $activeStripeSubcription = db()->where('user_id', $this->user->user_id)->orderBy('id', 'DESC')->getOne('subscriptions');      
        if($activeStripeSubcription && $this->user->subscription_schedule_id == null){
            try{
                $activeStripeSubcription = $stripe->subscriptions->retrieve(
                    $activeStripeSubcription->subscription_id,
                    []
                );
                $stripeSubcriptionDiscount = $activeStripeSubcription->discount;
            } catch (ApiErrorException $e) {
                $activeStripeSubcription   = null;
                $stripeSubcriptionDiscount = null;
            }
        } else {
            if($this->user->stripe_customer_id){
                try {
                    $activeStripeSubcription = $stripe->subscriptions->all(
    
                        ['customer' => $this->user->stripe_customer_id]
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

        if (!$userDiscount) {
            try {
                $upcomingInvoices = $stripe->invoices->upcoming([
                    'customer' => $this->user->stripe_customer_id,
                ]);
                $stripeSubcriptionDiscount = $upcomingInvoices->discount;
            } catch (\Stripe\Exception\ApiErrorException $e) {
                $stripeSubcriptionDiscount =  null;
            }
        }

        if ($this->user->subscription_schedule_id && $this->user->stripe_customer_id) {
            try {
                $upcomingInvoices = $stripe->invoices->upcoming([
                    'customer' => $this->user->stripe_customer_id,
                ]);
                $upcomingDiscount =  $upcomingInvoices->discount;
            } catch (\Stripe\Exception\ApiErrorException $e) {
                $upcomingDiscount = null;
            }
        }


        if (isset($_GET['setup_intent'])) {
            $setupIntent = $stripe->setupIntents->retrieve(
                $_GET['setup_intent'],
                []
            );

            $error = null;

            if ($this->user->payment_subscription_id && $this->user->payment_subscription_id != 'onetime') {
                try {
                    $stripe->subscriptions->update(
                        $this->user->payment_subscription_id,
                        ['default_payment_method' => $setupIntent->payment_method]
                    );
                } catch (\Stripe\Exception\CardException $e) {
                    $error = "A payment error occurred: {$e->getError()->message}";
                } catch (\Stripe\Exception\InvalidRequestException $e) {
                    $error = "An invalid request occurred.";
                } catch (Exception $e) {
                    $error = "Another problem occurred, maybe unrelated to Stripe.";
                }
            }

            db()->where('user_id', $this->user->user_id)->update('payment_methods', [
                'status' => 0,
            ]);

            $paymentMethod  = $stripe->paymentMethods->retrieve($setupIntent->payment_method);
            $card = $paymentMethod->card->brand . ' ****' . $paymentMethod->card->last4;

            db()->insert('payment_methods', [
                'user_id'           => $this->user->user_id,
                'payment_method'    => $setupIntent->payment_method,
                'card'              => $card,
                'status'            => true,
                'updated_at'        => (new \DateTime())->format('Y-m-d H:i:s'),
            ]);


            $stripe->customers->update(
                $this->user->stripe_customer_id,
                ['invoice_settings' => ['default_payment_method' => $setupIntent->payment_method]]
            );


            if ($error) {
                Alerts::add_error($error);
            } else {
                Alerts::add_success(l('billing.update_success_message'));
            }

            redirect('billing');
        } else if (isset($_GET['payment_intent'])) {
            sleep(3);
            Alerts::add_success(l('billing.update_success_message'));
            redirect('billing');
        }

        $clientSecret = null;
        if ($activeStripeSubcription && $activeStripeSubcription->status != 'canceled' && (new DateTime($this->user->plan_expiration_date) < new DateTime())) {
            $suspendsubcription  = $activeStripeSubcription;
            $invoice  = $stripe->invoices->retrieve($suspendsubcription->latest_invoice, []);

            $paymentIntent  = $stripe->paymentIntents->retrieve($invoice->payment_intent, []);

            if ($paymentIntent->status != 'succeeded') {
                $paymentIntent = $stripe->paymentIntents->update($invoice->payment_intent, [
                    'setup_future_usage' => 'off_session',
                ]);
                $clientSecret = $paymentIntent->client_secret;
            } else {
                $suspendsubcription = null;
            }
        } else {
            $suspendsubcription = null;
        }

        $payments = [];
        $payments_result = database()->query("SELECT `payments`.*, plans.`name` AS `plan_name` FROM `payments` LEFT JOIN plans ON `payments`.plan_id = plans.plan_id WHERE `user_id` = {$this->user->user_id}");
        while ($row = $payments_result->fetch_object()) $payments[] = $row;

        $paymentMethoed = db()->where('user_id', $this->user->user_id)->where('status', 1)->getOne('payment_methods');
        $card = $paymentMethoed->card;


        $query  = "SELECT * FROM `subscriptions` WHERE (`end_date` >= '{$this->user->plan_expiration_date}' OR `end_date` IS NULL ) AND `subscription_id` = '{$this->user->payment_subscription_id}'";
        $allSubscriptionPlans = db()->query($query);

        $planData = [];
        $planExpireBannerHtml = (new \Altum\Views\View('plan/expire-banner', (array) $this))->run($planData);


        if (count($allSubscriptionPlans) > 1) {
            $newPlan =  end($allSubscriptionPlans);
            $plan = db()->where('plan_id', $newPlan->plan_id)->getOne('plans', ['name', 'plan_id']);

            $data = [
                'card'                      => $card,
                'payments'                  => $payments,
                'newPlanName'               => $plan->name,
                'newPlanId'                 => $plan->plan_id,
                'start_date'                => $newPlan->start_date,
                'reactivePlanName'          => null,
                'suspendsubcription'        => $suspendsubcription,
                'stripeSubcriptionDiscount' => $stripeSubcriptionDiscount,
                'userDiscount'              => $userDiscount,
                'upcomingDiscount'          => $upcomingDiscount,
                'isSwitchPlan'              => $isSwitchPlan,
                'clientSecret'              => $clientSecret,
                'planExpireBannerHtml'      => $planExpireBannerHtml,
            ];
        } else {

            if ($this->user->subscription_schedule_id != '') {

                try {
                    $subscriptionSchedule  = $stripe->subscriptionSchedules->retrieve(
                        $this->user->subscription_schedule_id,
                        []
                    );
                    $priceId = $subscriptionSchedule->phases[0]->items[0]->plan;
                    $startDate = $subscriptionSchedule->phases[0]->start_date;

                    switch ($priceId) {
                        case STRIPE_PRICE_1_ID:
                            $planId = 1;
                            break;
                        case STRIPE_PRICE_12_ID:
                            $planId = 2;
                            break;
                        case STRIPE_PRICE_3_ID:
                            $planId = 3;
                            break;
                        default:
                            $planId = 1;
                    }

                    $newPlan = db()->where('plan_id', $planId)->getOne('plans', ['name']);

                    $data = [
                        'card'                      => $card,
                        'payments'                  => $payments,
                        'newPlanName'               => null,
                        'newPlanId'                 => null,
                        'start_date'                => date("m/d/Y h:i:s A T", $startDate),
                        'reactivePlanName'          => $newPlan->name,
                        'suspendsubcription'        => $suspendsubcription,
                        'stripeSubcriptionDiscount' => $stripeSubcriptionDiscount,
                        'userDiscount'              => $userDiscount,
                        'upcomingDiscount'          => $upcomingDiscount,
                        'isSwitchPlan'              => $isSwitchPlan,
                        'clientSecret'              => $clientSecret,
                        'planExpireBannerHtml'      => $planExpireBannerHtml,
                    ];
                } catch (Exception $e) {
                    Alerts::add_error(l('Another problem occurred, maybe unrelated to Stripe'));
                }
            }else{    
                
                
       
                $data = [
                    'card'                  => $card,
                    'payments'              => $payments,
                    'newPlanName'           => null,
                    'start_date'            => null,
                    'reactivePlanName'      => null,
                    'suspendsubcription'    => $suspendsubcription,
                    'isSwitchPlan'          => $isSwitchPlan,
                    'upcomingDiscount'      => $upcomingDiscount,  
                    'userDiscount'          => $userDiscount,  
                    'clientSecret'          => $clientSecret,
                    'planExpireBannerHtml'  => $planExpireBannerHtml,
                ];
            }
        }
      
        setcookie('feedback_type', '', time() - (3 * 3600)); // A cancel feedback_type cookie, if any, is removed
       
        $view = new \Altum\Views\View('billing/index', (array) $this);
        $this->add_view_content('content', $view->run($data));
    }


    public function cancel_subscription()
    {
       
        Authentication::guard();

        if (!Csrf::check()) {
            Alerts::add_error(l('global.error_message.invalid_csrf_token'));
            redirect('billing');
        }

        if (!Alerts::has_field_errors() && !Alerts::has_errors()) {

            try {
                (new User())->cancel_subscription($this->user->user_id);
                

            } catch (\Exception $exception) {
                Alerts::add_error($exception->getCode() . ':' . $exception->getMessage());
                redirect('billing');
            }

            if(isset($_GET['cancel_promo'])){
                db()->where('user_id', $this->user->user_id)->update('users', [
                    'cancel_promo' => 4,
                ]);
            }

            $_SESSION['cancel_subscription'] = true;

            /* Set a nice success message */
            Alerts::add_success(l('account_plan.success_message.subscription_canceled'));

            redirect('billing');
        }
    }

    public function update_payment_method()
    {
        Authentication::guard();

        if ($this->user->plan_id == 'free' && $this->user->payment_processor == '') {
            redirect('plan');
        }

        $stripe = new \Stripe\StripeClient(settings()->stripe->secret_key);
        $activeStripeSubcription = db()->where('user_id', $this->user->user_id)->orderBy('id', 'DESC')->getOne('subscriptions');
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
            if($this->user->stripe_customer_id){
                try {
                    $activeStripeSubcription = $stripe->subscriptions->all(
                        ['customer' => $this->user->stripe_customer_id]
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

        $upcoming_payment = $stripe->invoices->upcoming(['customer' => $this->user->stripe_customer_id]);

        $overdueAmount = null;
        if($upcoming_payment){
            $overdueAmount = convert_payment_format($upcoming_payment->amount_due,$this->user->payment_currency );
        }
        

        $clientSecret = null;
        if ($activeStripeSubcription && $activeStripeSubcription->status != 'canceled' && (new DateTime($this->user->plan_expiration_date) < new DateTime())) {
            $suspendsubcription  = $activeStripeSubcription;
            $invoice  = $stripe->invoices->retrieve($suspendsubcription->latest_invoice, []);
            $paymentIntent = $stripe->paymentIntents->update($invoice->payment_intent, [
                'setup_future_usage' => 'off_session',
            ]);
            $clientSecret = $paymentIntent->client_secret;
        } else {
            $suspendsubcription = null;
        }

        $payments = [];
        $payments_result = database()->query("SELECT `payments`.*, plans.`name` AS `plan_name` FROM `payments` LEFT JOIN plans ON `payments`.plan_id = plans.plan_id WHERE `user_id` = {$this->user->user_id}");
        while ($row = $payments_result->fetch_object()) $payments[] = $row;

        $paymentMethoed = db()->where('user_id', $this->user->user_id)->where('status', 1)->getOne('payment_methods');
        $card = $paymentMethoed->card;

        $latestPayment = end($payments);

        $code   = $this->user->payment_currency;
        $symbol = getSymbol($code);

        $data = [
            'card'                  => $card,
            'payments'              => $payments,
            'overdueAmount'         => $overdueAmount,
            'newPlanName'           => null,
            'start_date'            => null,
            'code'                  => $code,
            'symbol'                => $symbol,
            'reactivePlanName'      => null,
            'suspendsubcription'    => $suspendsubcription,
            'latestPayment'         => $latestPayment ?? null,
            'clientSecret'          => $clientSecret
        ];


        $view = new \Altum\Views\View('billing/update-payment', (array) $this);
        $this->add_view_content('content', $view->run($data));
    }




    public function delete()
    {

        Authentication::guard();

        /* Team checks */
        if (\Altum\Teams::is_delegated() && !\Altum\Teams::has_access('delete')) {
            Alerts::add_info(l('global.info_message.team_no_access'));
            redirect('billings');
        }

        if (empty($_POST)) {
            redirect('billings');
        }

        $billing_id = (int) Database::clean_string($_POST['billing_id']);

        //ALTUMCODE:DEMO if(DEMO) if($this->user->user_id == 1) Alerts::add_error('Please create an account on the demo to test out this function.');

        if (!Csrf::check()) {
            Alerts::add_error(l('global.error_message.invalid_csrf_token'));
        }

        if (!$billing = db()->where('billing_id', $billing_id)->where('user_id', $this->user->user_id)->getOne('billings', ['billing_id', 'name'])) {
            redirect('billings');
        }

        if (!Alerts::has_field_errors() && !Alerts::has_errors()) {

            /* Delete the billing */
            db()->where('billing_id', $billing_id)->delete('billings');

            /* Set a nice success message */
            Alerts::add_success(sprintf(l('global.success_message.delete1'), '<strong>' . $billing->name . '</strong>'));

            /* Clear the cache */
            \Altum\Cache::$adapter->deleteItem('billings?user_id=' . $this->user->user_id);

            redirect('billings');
        }

        redirect('billings');
    }
}
