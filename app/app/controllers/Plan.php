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
use DateTime;
use Stripe\Exception\ApiErrorException;

class Plan extends Controller
{


    public function index()
    {

        
        if (!settings()->payment->is_enabled) {
            redirect();
        }
        
        if (!Authentication::check()) {

            if (isset($_GET['id']) || isset($_GET['referral_key'])) {
                $id = $_GET['referral_key'] ?? $_GET['id'];
                $user  = db()->where('referral_key',  $id)->getOne('users');
                if (!$user) {
                    redirect('plans-and-prices');
                }
            } else {
                redirect('plans-and-prices');
            }
        }
    
        $user  =  isset($this->user->user_id) ? $this->user : $user;

 
        
        if (isset($_SESSION['pay_thank_you'])) {
            unset($_SESSION['pay_thank_you']);
        }
        
        $type = isset($this->params[0]) && in_array($this->params[0], ['renew', 'upgrade', 'new']) ? $this->params[0] : 'new';
        
        /* If the user is not logged in when trying to upgrade or renew, make sure to redirect them */
        if (in_array($type, ['renew', 'upgrade']) && !Authentication::check()) {
            if (!$type == 'upgrade' && isset($_GET['id'])) {
                redirect('plan/new');
            }
        }
        
        promo_email_trigger($user->user_id, 'pricing');
    
        
        // if ($user->onboarding_funnel == 4 && $user->plan_id != 6 && $user->plan_id != 7) {

        //     if (isset($_GET['promo'])) { 
        //         redirect('plan-rdpf?promo=70OFF');
        //     }            
               
        //     if (isset($_GET['type'])) {
        //         redirect('plan-rdpf?type='.$_GET['type']);
        //     }

        //     if($type == 'upgrade'){               
        //         redirect('plan-rdpf/upgrade');
        //     }
        //     if($type == 'renew'){
        //         redirect('plan-rdpf/renew');
        //     }           
        //     redirect('plan-rdpf');
        // }      
       
        
        $stripe = new \Stripe\StripeClient(settings()->stripe->secret_key);
        $activeStripeSubcription = db()->where('user_id', $user->user_id)->orderBy('id', 'DESC')->getOne('subscriptions');      
        if($activeStripeSubcription){
            
            try{
                $activeStripeSubcription = $stripe->subscriptions->retrieve(
                    $activeStripeSubcription->subscription_id,
                    []
                );
                
            }catch(ApiErrorException $e){
                $activeStripeSubcription = null;                
            }                    
        }

        
        if($activeStripeSubcription && $activeStripeSubcription->status !='canceled' && (new DateTime($user->plan_expiration_date) < new DateTime())){
            $suspendsubcription  = $activeStripeSubcription;
        }else{
            $suspendsubcription = null;
        }
          
        
        $discountType = isset($_GET['type']) ? $_GET['type'] : null;

        if (($discountType != 'discounted' && $discountType != 'onetime') && ($user->payment_subscription_id && ($type != 'upgrade')) && $user->plan_id != 6 && $user->plan_id != 7) {
            if (!$suspendsubcription) {
                if ((new DateTime($user->plan_expiration_date) > new DateTime())) {
                    redirect('plan/upgrade');
                }

                // redirect('billing');
            } else if (!$user->payment_subscription_id) {
                redirect('billing');
            }
        }
        
        if (isset($_GET['promo']) && !isset($_SESSION['discount'])) {            
            redirect('plan');
        }

        
        $discount = null;
        if (isset($_GET['promo'])) {
            if ($_GET['promo'] == '70OFF') {
                $discount = 70;
            }
        }

        $planId  = null;
        if (isset($_GET['type'])) {
            if ($_GET['type'] == 'discounted') {
                $planId = 4;
            }
            
            if ($_GET['type'] == 'onetime') {
                $planId = 5;
            }
        }       
  
        $qrCount = database()->query("SELECT COUNT(*) AS `qr_code_id` FROM `qr_codes` WHERE `user_id` = {$user->user_id} AND `status` = '1' ")->fetch_object()->qr_code_id ?? 0;

        /* Plans View */
        $data = [
            'user' => $user,
        ];
        $planData = [];

        $view = new \Altum\Views\View('partials/plans', (array) $this);
        // $planExpireBannerHtml = (new \Altum\Views\View('plan/expire-banner', (array) $this))->run($planData);

        $this->add_view_content('plans', $view->run($data));

        /* Prepare the View */
        $data = [
            'type'     => $type,
            'discount' => $discount,
            'qrCount'  => $qrCount,
            'planId'   => $planId,
            'user'     => $user,
        ];

        

        if (isset($_SESSION['clientSecret'])) {
            unset($_SESSION['clientSecret']);
        }

        $view = new \Altum\Views\View('plan/index', (array) $this);

        $this->add_view_content('content', $view->run($data));
    }
}
