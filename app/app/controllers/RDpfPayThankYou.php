<?php
/*
 * @copyright Copyright (c) 2021 AltumCode (https://altumcode.com/)
 *
 * This software is exclusively sold through https://altumcode.com/ by the AltumCode author.
 * Downloading this product from any other sources and running it without a proper license is illegal,
 *  except the official ones linked from https://altumcode.com/.
 */

namespace Altum\Controllers;

use Altum\Middlewares\Authentication;


class RDpfPayThankYou extends Controller {

    public function index() {

        if (!isset($_SESSION['pay_thank_you'])) {
            redirect('qr-codes');
        }else{
            unset($_SESSION['pay_thank_you']);
        }
        
        // Authentication::guard();
      
        if(!settings()->payment->is_enabled) {
            redirect();
        }

       

        if(isset($_GET['schedule_id'])){
            $data = [
                'plan_id'    => '',
                'plan'       => '',
            ]; 

                        
            $view = new \Altum\Views\View('pay-dpf-thank-you/renew', (array) $this);    
            $this->add_view_content('content', $view->run($data));
        }

        $plan_id = $_GET['plan_id'] ?? null;
        
       
        switch($plan_id) {
            case 'free':               
                $plan = settings()->plan_free;
                break;
            default:
                $plan_id = (int) $plan_id;
                /* Check if plan exists */
                if(!$plan = (new \Altum\Models\Plan())->get_plan_by_id($plan_id)) {
                    redirect('plan');
                }
                break;
        }

       
        if(!$plan->status) {
            redirect('plan');
        }

        $user = null;
        if (isset($_GET['ref'])) {                
            $user  = db()->where('referral_key', $_GET['ref'])->getOne('users');            
        }       

        $type = null;
        if(isset($_GET['type'])){
            $type = $_GET['type'];
        }


        // /* Prepare the View */
        $data = [
            'plan_id'    => '',
            'plan'       => $plan,
            'user'      => $user,
            'type'      => $type,
        ];
              
        
        $view = new \Altum\Views\View('pay-dpf-thank-you/renew', (array) $this);

        $this->add_view_content('content', $view->run($data));


    }

}