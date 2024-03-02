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
use Altum\Models\User;
use Altum\Response;
use Exception;

class AddPayment extends Controller {

    public function index(){
        Authentication::guard();
        $stripe = new \Stripe\StripeClient(settings()->stripe->secret_key);
        $error = null;

        if(!$this->user->payment_subscription_id || !$this->user->subscription_schedule_id){
            $error = "Subscription ID not found. Please contact support team";
            $data = [
                'error'=> $error,
                'complete'=> false,
            ];            
            return Response::jsonapi_success($data, null, 200);
        }

        try {
            $stripe->paymentMethods->attach(
                $_POST['id'],
                ['customer' => $subscriptions->customer]
              );
          
          } catch(\Stripe\Exception\CardException $e) {
            $error = "A payment error occurred: {$e->getError()->message}";
          } catch (\Stripe\Exception\InvalidRequestException $e) {
            $error = "An invalid request occurred.";
          } catch (Exception $e) {
            $error = "Another problem occurred, maybe unrelated to Stripe.";
        }
        

        if($this->user->payment_subscription_id){



        }

        $subscriptions = $stripe->subscriptions->retrieve($this->user->payment_subscription_id);
       
        

        
        try{
            $stripe->subscriptions->update(
                $this->user->payment_subscription_id,
                ['default_payment_method' => $_POST['id']]
              );
        } catch(\Stripe\Exception\CardException $e) {
            $error = "A payment error occurred: {$e->getError()->message}";
          } catch (\Stripe\Exception\InvalidRequestException $e) {
            $error = "An invalid request occurred.";
          } catch (Exception $e) {
            $error = "Another problem occurred, maybe unrelated to Stripe.";
        }
       

        if($error){
            $data = [
                'error'=> $error,
                'complete'=> false,
            ];
        }else{
            $data = [
                'error'=> null,
                'complete'=> true,
            ];

        }
            return Response::jsonapi_success($data, null, 200);
      

        

    }


}