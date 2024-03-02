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
use DateTime;
use Exception;
use Stripe\Exception\ApiErrorException;

class UpdatePayment extends Controller
{

    public function index()
    {
        
        if(isset($_GET['referral_key'])){
            $referral_key = $_GET['referral_key'];
            $user = db()->where('referral_key', $referral_key)->getOne('users');
           
            if(!$user){
                redirect('login');
            }
        }else{
            redirect('login');
        }
   
        $user = isset($this->user->user_id) ? $this->user : $user;

        $suspendsubcription = null;
        $activeStripeSubcription = db()->where('user_id', $user->user_id)->orderBy('id', 'DESC')->getOne('subscriptions');   
        $stripe = new \Stripe\StripeClient(settings()->stripe->secret_key);

        if ($activeStripeSubcription) { 
            try {
                $subscription = $stripe->subscriptions->retrieve(
                    $activeStripeSubcription->subscription_id,
                    []
                );  
                
                
            } catch (ApiErrorException $e) {
                $subscription   = null;                
            }  

        }else{
            if($user->stripe_customer_id){
                try {
                    $activeStripeSubcription = $stripe->subscriptions->all(
                        ['customer' => $user->stripe_customer_id]
                    );

                    if ($activeStripeSubcription) {
                        $subscription = $activeStripeSubcription['data'][0];
                    }
                } catch (ApiErrorException $e) {
                    $subscription   = null;           
                }
            }else{
                $subscription   = null;    
            }
        }   
        
        $clientSecret = null;
        if ($subscription && $subscription->status != 'canceled' && (new DateTime($user->plan_expiration_date) < new DateTime())) {   
            $suspendsubcription =    $subscription;     
            $invoice  = $stripe->invoices->retrieve($subscription->latest_invoice, []);
            $paymentIntent = $stripe->paymentIntents->update($invoice->payment_intent,[
                'setup_future_usage' => 'off_session',               
            ]);                
            $clientSecret = $paymentIntent->client_secret;
        } 
       
        try {
            $upcoming_payment = $stripe->invoices->upcoming(['customer' => $user->stripe_customer_id]);
        } catch (\Throwable $th) {
            redirect('plans-and-prices');
        }
        
        $totalDue = null;
        if($upcoming_payment){
            $totalDue = convert_payment_format($upcoming_payment->amount_due,$user->payment_currency );
        }     

        $plan_id = $subscription->plan->metadata->plan_id;
        $plan_id = (int) $plan_id;
        $plan = (new \Altum\Models\Plan())->get_plan_by_id($plan_id);


        $code   = $user->payment_currency;
        $symbol = getSymbol($code);

        $data = [
            'user'             => $user,
            'plan'             => $subscription->plan,
            'totalDue'         => $totalDue,
            'planName'         => $plan->name,
            'code'             => $code,           
            'symbol'           => $symbol,           
            'clientSecret'     => $clientSecret,
            'suspendsubcription'=> $suspendsubcription,
        ];  

        if ($subscription->status == "past_due" || $subscription->status == "unpaid") {
            if (Authentication::check()) {              
                $route = 'billing/update_payment_method?referral_key=' . $referral_key;
                redirect($route);
            } else {
               
                $view = new \Altum\Views\View('update-payment/index', (array) $this);
                $this->add_view_content('content', $view->run($data));
            }
        } else{
            redirect('billing');
        }
        
        
       
      
        
    }

    public function change()
    {       
        $_SESSION['pay_thank_you'] = true;
        $_SESSION['payment_method_update'] = true;  
        redirect('pay-thank-you');    
    }
}
