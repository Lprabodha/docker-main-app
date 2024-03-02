<?php
/*
 * @copyright Copyright (c) 2024 Rightmo (https://rightmo.lk/)
 *
 * This software is exclusively sold through https://altumcode.com/ by the AltumCode author.
 * Downloading this product from any other sources and running it without a proper license is illegal,
 *  except the official ones linked from https://altumcode.com/.
 */

namespace Altum\Controllers;

use Altum\Middlewares\Authentication;
use DateTime;

class PlansAndPrices extends Controller
{

    public function index()
    { 
        if (isset($_SESSION['pay_thank_you'])) {
            unset($_SESSION['pay_thank_you']);
        }

        $type = isset($this->params[0]) && in_array($this->params[0], ['renew', 'upgrade', 'new']) ? $this->params[0] : 'new';
        $user = null;
        $id = null;
        $planType = isset($_GET['plan_type']) ? $_GET['plan_type'] : '';
        $promoCode = isset($_GET['promo_code']) ? $_GET['promo_code'] : '';

        if (Authentication::check()) {
            $user = $this->user;
        }else if (isset($_GET['id']) || isset($_GET['referral_key'])) {
            $id     = $_GET['referral_key'] ?? $_GET['id'];              
            $user   = db()->where('referral_key', $id)->getOne('users');
        }

        if($user){
            promo_email_trigger($user->user_id, 'pricing');

            if ($user->type == 2) {
                Authentication::logout(false);
                return redirect('plans-and-prices');
            }   
                   
            if ($user->plan_id != 'free' && $user->payment_subscription_id != '' &&  (new DateTime($user->plan_expiration_date) > new DateTime())) { // Subscription active and not cancelled 
                
                if ($planType) {
                    if($planType == 'discounted' || $planType == 'onetime'){
                        $url = 'plan?type=' . $planType. ($id ?'&id='.$id : '');                   
                    }else{
                        $url = 'plan/upgrade?type=' . $planType. ($id ?  '&id='.$id : '');                    
                    }
                }else{                   
                    $url = 'plan/upgrade'.($id ?  '?id='.$id : '');                  
                }               
                redirect($url);
            }else{ // 
                $subscription = get_pastdue_subscription($user);
    
                if ($subscription && !$planType) {
                    $url = 'update-payment-method?referral_key=' . $user->referral_key;              
                    redirect($url);               
                }
    
                if ($promoCode) {
                    $_SESSION['discount'] = $promoCode;
                    $url =    'plan?promo=' . $promoCode.($id ?'&id='.$id : ''); 
                    redirect($url);               
                }
    
                if ($planType) {
                    $url =  'plan?type=' . $planType.($id ?  '&id='.$id : '');     
                    redirect($url);          
                }
    
    
                if($user->payment_processor != '' ){                
                    $url =   'plan/renew'. ($id ? '?id='.$id : '');
                    redirect($url);
                }
    
            }
        }

        if ($id) {
            redirect('plan?id='.$id);
        } 

        if (Authentication::check()) {
            redirect('plan');
        }        
       
        if ($planType == 'discounted') {
            $planId = 4;
        }

        if ($planType == 'onetime') {
            $planId = 5;
        }

        $discount = null;
        if ($promoCode && $promoCode == '70OFF') {
            $discount = 70;          
        }
      
        $data = ['user' => $user];
        $view = new \Altum\Views\View('partials/plans', (array) $this);
        $this->add_view_content('plans', $view->run($data));

        $qrCount = 0;
        if ($user) {
            $qrCount = database()->query("SELECT COUNT(*) AS `qr_code_id` FROM `qr_codes` WHERE `user_id` = {$user->user_id} AND `status` = '1' ")->fetch_object()->qr_code_id ?? 0;
        }  

        /* Prepare the View */
        $data = [
            'type'     => $type,
            'discount' => $discount,
            'user'     => $user,
            'planId'   => isset($planId) ? $planId : null,
            'qrCount'  => $qrCount,

        ];

        if (isset($_SESSION['clientSecret'])) {
            unset($_SESSION['clientSecret']);
        }

        $view = new \Altum\Views\View('plans-and-prices/index', (array) $this);
        $this->add_view_content('content', $view->run($data));
    }
}
