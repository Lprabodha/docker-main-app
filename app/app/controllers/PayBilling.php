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

class PayBilling extends Controller
{

    public function index()
    {

       

        Authentication::guard();
        $plan_id = isset($this->params[0]) ? $this->params[0] : null;
        if (!settings()->payment->is_enabled) {
            redirect();
        }

        if (!settings()->payment->taxes_and_billing_is_enabled) {
            redirect('pay/' . $plan_id);
        }

        if (in_array($plan_id, ['free', 'custom'])) {
            redirect('pay/' . $plan_id);
        }

        $plan_id = (int) $plan_id;

        /* Check if plan exists */
        $plan = (new \Altum\Models\Plan())->get_plan_by_id($plan_id);

        /* Make sure the plan is enabled */
        if (!$plan->status) {
            redirect('plan');
        }

        if (!empty($_POST)) {

           $data = (json_decode($_POST['address'], true));
          
            $_POST['billing'] = json_encode([                
                'name'      => $data['name'],   
                'email'     => $this->user->email,            
                'line1'     => $data['address']['line1'],
                'line2'     => $data['address']['line2'],                  
                'city'      => $data['address']['city'],         
                'province'  => isset($data['address']['province']) ? $data['address']['province'] : '' ,
                'state'     => isset($data['address']['state']) ? $data['address']['state'] : '' ,
                'zip'       => isset($data['address']['zip'])? $data['address']['zip'] : '',
                'country'   => $data['address']['country'],           
                'postal_code' => isset($data['address']['postal_code']) ? $data['address']['postal_code'] : '',
                    
            ]);

           
            /* Check for any errors */
            if (!Csrf::check()) {
                Alerts::add_error(l('global.error_message.invalid_csrf_token'));
            }

            if (!Alerts::has_field_errors() && !Alerts::has_errors()) {

                $name_parts = explode(" ", $data['name']);
                $first_name = $name_parts[0];
                // Assign the last name
                $last_name = $name_parts[1];

                /* Database query */
                db()->where('user_id', $this->user->user_id)->update('users', ['billing' => $_POST['billing'], 'name'=>$data['name']]);

                $tax = db()->where('user_id', $this->user->user_id)->getOne('taxes');
               
                if (!$tax) {
                    db()->insert('taxes', [
                        'user_id' =>$this->user->user_id,
                        'type' =>'private',
                        'company_name' =>'#',
                        'tax_id' =>'#',
                        'name' => $first_name,
                        'surname'=> $last_name,
                        'address' => $data['address']['line1'] . (isset($data['address']['line2']) ?  ', ' . $data['address']['line2'] : ''),
                        'postal_code' => (isset($data['address']['zip'])?$data['address']['zip']:'').(isset($data['address']['postal_code'])?$data['address']['postal_code']:''),
                        'city'=> $data['address']['city'],
                        'country' => $data['address']['country'],
                        'email'=> $this->user->email,
                    ]);
                }else{
                    db()->where('user_id', $this->user->user_id)->update('taxes', 
                    [
                        'address' => $data['address']['line1'] . (isset($data['address']['line2']) ?  ', ' . $data['address']['line2'] : ''),
                        'postal_code' => (isset($data['address']['zip'])?$data['address']['zip']:'').(isset($data['address']['postal_code'])?$data['address']['postal_code']:''),
                        'city'=> $data['address']['city'],
                        'country' => $data['address']['country'],
                    ]);
                }

                

                /* Clear the cache */
                \Altum\Cache::$adapter->deleteItemsByTag('user_id=' . $this->user->user_id);
                
               

                /* Redirect to the checkout page */
                redirect('pay/' . $plan_id . '?' . (isset($_GET['trial_skip']) ? '&trial_skip=true' : null) . (isset($_GET['code']) ? '&code=' . $_GET['code'] : null));
            }
        }


        
        /* Prepare the View */        
        $data = [
            'plan_id' > $plan_id,
            'plan' => $plan,
            'info' => $this->user->billing,
        ];      
        

        $view = new \Altum\Views\View('pay-billing/index', (array) $this);

        $this->add_view_content('content', $view->run($data));
    }
}
