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

class UnsubscribeEmail extends Controller
{

    public function index()
    {

        if(!isset($_GET['ref_key'])){
            
            if (Authentication::check()) {
                redirect('qr-codes');
            } else {
                redirect('');
            }
        }else{
            $user = db()->where('referral_key', $_GET['ref_key'])->getOne('users');
            if (!$user) {
                redirect('');
            }
        }

        $data = [
            'ref_key' => $_GET['ref_key'],
        ];
        
        $view = new \Altum\Views\View('email-unsubscribe/index', (array) $this);
        $this->add_view_content('content', $view->run($data));

        

       
    }

    public function update()
    {

        if(isset($_POST['ref_key']))       

            $user = db()->where('referral_key', $_POST['ref_key'])->getOne('users');
            if (!$user) {
                redirect('');
            }

            db()->where('user_id', $user->user_id)->update('users', [
                'email_subscription_type' => 1,
            ]);

            Alerts::add_success(l('email_unsubscribe.alert_successful'));
            if (Authentication::check()) {
                redirect('qr-codes');
            } else {
                redirect('');
            }
        }
    
}
