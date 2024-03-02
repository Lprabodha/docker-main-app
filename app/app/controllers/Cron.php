<?php
/*
 * @copyright Copyright (c) 2021 AltumCode (https://altumcode.com/)
 *
 * This software is exclusively sold through https://altumcode.com/ by the AltumCode author.
 * Downloading this product from any other sources and running it without a proper license is illegal,
 *  except the official ones linked from https://altumcode.com/.
 */

namespace Altum\Controllers;

use Altum\Models\User;
use Altum\Date;
use Altum\Middlewares\Authentication;
use Exception;
use DateTime;
use Stripe\Exception\ApiErrorException;

class Cron extends Controller
{

    public function index()
    {
        die();
    }

    private function initiate()
    {
        /* Initiation */
        set_time_limit(0);

        /* Make sure the key is correct */
        if (!isset($_GET['key']) || (isset($_GET['key']) && $_GET['key'] != settings()->cron->key)) {
            die();
        }
    }



    private function update_cron_execution_datetimes($key)
    {
        /* Get non-cached values from the database */
        $settings_cron = json_decode(db()->where('`key`', 'cron')->getValue('settings', 'value'));

        $new_settings_cron_array = [
            'key' => $settings_cron->key,
            'reset_datetime' => $settings_cron->reset_datetime ?? \Altum\Date::$date,
            'reset_date' => $settings_cron->reset_date ?? \Altum\Date::$date,
        ];

        $new_settings_cron_array[$key] = \Altum\Date::$date;

        /* Update database */
        db()->where('`key`', 'cron')->update('settings', ['value' => json_encode($new_settings_cron_array)]);
    }

    public function reset()
    {
        $this->initiate();


        if (APP_CONFIG == 'production') {


            try {
                $this->payment_failed_emails();
            } catch (Exception $e) {
                echo 'payment_failed_emails';
            }


            try {
                $this->remove_temp_users();
            } catch (Exception $e) {
                echo 'remove_temp_users';
            }

            try {
                $this->update_exchange_rate();
            } catch (\Throwable $th) {
                echo 'update_exchange_rate';
            }

            try {
                $this->ipapi_credit_usage();
            } catch (\Throwable $th) {
                echo 'ipapi_credit_usage';
            }

            try {
                $this->users_plan_expiry_reminder();
            } catch (\Throwable $th) {
                echo 'users_plan_expiry_reminder';
            }

            try {
                $this->one_hour_dpf_email();
            } catch (\Throwable $th) {
                echo 'one_hour_dpf_email';
            }

            try {
                $this->promo_email_trigger();
            } catch (\Throwable $th) {
                echo 'promo_email_trigger';
            }

            try {
                $this->free_trial_funnel();
            } catch (\Throwable $th) {
                echo 'free_trial_funnel';
            }


            try {
                $this->dpf_14_days_plan_emails();
            } catch (\Throwable $th) {
                echo 'dpf_14_days_plan_emails';
            }

            try {
                $this->dpf_user_promo_email_trigger();
            } catch (\Throwable $th) {
                echo 'dpf_user_promo_email_trigger';
            }

            try {
                $this->delete_archived_qr_codes();
            } catch (\Throwable $th) {
                echo 'delete_archived_qr_codes';
            }
            
        }

        $this->update_cron_execution_datetimes('reset_datetime');
    }

    private function payment_failed_emails()
    {
        $nowTime  =  (new \DateTime())->format('Y-m-d H:i:s');
        $query  = "SELECT * FROM `payment_failed` WHERE `failed_time` < '{$nowTime}' AND `is_send` = 0 AND `payment_success` = 0 ORDER BY `id` ASC";
        $data = db()->query($query);
        $stripe = new \Stripe\StripeClient(settings()->stripe->secret_key);

        foreach ($data as $failedUser) {

            $user = db()->where('user_id', $failedUser->user_id)->getOne('users');

            $activeSubcription = db()->where('user_id', $failedUser->user_id)->orderBy('id', 'DESC')->getOne('subscriptions');
            $activeStripeSubcription = null;
            if ($activeSubcription && $user) {
                try {
                    $activeStripeSubcription = $stripe->subscriptions->retrieve(
                        $activeSubcription->subscription_id,
                        []
                    );
                } catch (ApiErrorException $e) {
                    dil('declined-payment ==>> failed ' . $failedUser->user_id);
                }
            }

            if ($user->plan_expiration_date < $nowTime && $activeStripeSubcription && $user->email_subscription_type != 2) {

                $template =  'declined-payment';
                $link     =  'update-payment-method?referral_key=' . $user->referral_key;
                $email    =   trigger_email($user->user_id, $template, $link);
                if ($email['complete']) {
                    db()->where('payment_id', $failedUser->payment_id)->update('payment_failed', [
                        'is_send' => '1',
                    ]);
                }
            }
        }
    }

    public function update_exchange_rate()
    {

        $time = (new \DateTime())->modify('-1 days')->format('Y-m-d H:i:s');      
        $query  = "SELECT * FROM `exchange_rates` WHERE `date` > '{$time}' AND `name` = 'USD' ORDER BY `id` ASC";
        $data = db()->query($query);
        
        if(!$data){
            $url = 'https://v6.exchangerate-api.com/v6/49cb9f989ef21cef36391f10/latest/USD';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $output = curl_exec($ch);
            curl_close($ch);
            $response =  @json_decode($output);

            try {
                if ('success' === $response->result) {
    
                    foreach ($response->conversion_rates as $key => $rate) {
                        $rate = round(($rate), 2);
                        $currency =  db()->where('name', $key)->getOne('exchange_rates');
                        if ($currency) {
                            db()->where('name', $key)->update('exchange_rates', [
                                'rate' => $rate, 'date' => Date::$date
                            ]);
                        } else {
                            db()->insert('exchange_rates', [
                                'name' => $key, 'rate' => $rate, 'date' => Date::$date
                            ]);
                        }
                    }
                    return $rate;
                }
            } catch (Exception $e) {
                header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
                echo json_encode(array("success" => false, "message" => $e->getMessage()));
                return null;
            }

        }      


        
    }


    public function users_plan_expiry_reminder()
    {

        $today = (new \DateTime())->format('Y-m-d H:i:s');
        $result = database()->query("
            SELECT
                `user_id`,
                `name`,
                `email`,
                `plan_id`,
                `plan_expiration_date`,
                `language`,
                `anti_phishing_code`,
                `referral_key`,
                `email_subscription_type`
            FROM 
                `users`
            WHERE 
                `status` = 1
                AND `plan_id` = 'free'
                AND `plan_expiry_reminder` = '0' 
				AND '{$today}' > `plan_expiration_date`
                AND `payment_processor` IS NULL
        ");

        /* Go through each result */
        while ($user = $result->fetch_object()) {
            /* Determine the exact days until expiration */

            if ($user->email_subscription_type != 2) {
                try {

                    /* Prepare the email */
                    $template =  'trial-end';
                    $link     =  'plans-and-prices?referral_key=' . $user->referral_key . '&email=trial_expired';
                    $email    = trigger_email($user->user_id, $template, $link);
                    if ($email['complete']) {
      
                        /* Update user */
                        db()->where('user_id', $user->user_id)->update('users', ['plan_expiry_reminder' => 1]);

                        // Update user_emails table
                        db()->where('user_id', $user->user_id)->update('user_emails', ['plan_expiry_reminder' => 1]);
                    }
                } catch (\Throwable $th) {
                    //throw $th;
                }
            }
        }
    }


    // Determine when active user log  (when user subcription is active)



    private function remove_temp_users()
    {

        $beforeHour = (new \DateTime())->modify('-2 hours')->format('Y-m-d H:i:s');

        $result = database()->query("
        SELECT
            `user_id`,
            `name`,
            `email`,
            `plan_id`,
            `plan_expiration_date`,
            `language`,
            `anti_phishing_code`
        FROM 
            `users`
        WHERE 
            `type` = 2
            AND '{$beforeHour}' > `datetime`
   
    ");
        while ($user = $result->fetch_object()) {

            (new User())->delete($user->user_id);
        }
    }

    //Promo 70 Emails
    private function  promo_email_trigger()
    {
        $nowTime   =  (new \DateTime())->format('Y-m-d H:i:s');
        $promoMail = null;
        // first_email_trigger
        $query  = "SELECT `id`, `first_email_date`, `type`, `is_first_email` , `user_id` FROM `promo_email_rules` WHERE `first_email_date` < '{$nowTime}' AND `type` != 'purchase'  AND `is_first_email` = 0 ORDER BY `id` ASC";
        $first_promo_users = db()->query($query);
        foreach ($first_promo_users as $promoUser) {
            $user = db()->where('user_id', $promoUser->user_id)->getOne('users');

            if ($user &&  $user->email_subscription_type == 0) {
                $is_one_day_expire_remind = db()->where('user_id', $user->user_id)->getOne('user_emails')->is_trial_1day_email;
                if ($is_one_day_expire_remind == 1 && $user->plan_id == 'free') {
                    try {
                        /* Prepare the email */
                        if ($promoUser->type == 'pricing') {
                            $promoMail =  $this->promo_email($user, 'promo-70-1', 'promo_70_pricing');

                        } else if ($promoUser->type == 'checkout') {
                            $promoMail = $this->promo_email($user, 'promo-70-1', 'promo_70_checkout');
                        }

                        if (isset($promoMail) && $promoMail['complete']) {
                            db()->where('user_id', $user->user_id)->update('promo_email_rules', [
                                'is_first_email' => '1',
                            ]);
                        }
                    } catch (\Throwable $th) {
                        //throw $th;
                    }
                }
            }
        }

        //second_email_trigger
        $query  = "SELECT `id`, `second_email_date`, `type`, `is_second_email`, `user_id`  FROM `promo_email_rules` WHERE  `second_email_date` < '{$nowTime}' AND `type` != 'purchase'  AND `is_second_email` = 0 ORDER BY `id` ASC";
        $second_promo_users = db()->query($query);
        foreach ($second_promo_users as $promoUser) {
            $user = db()->where('user_id', $promoUser->user_id)->getOne('users');

            if ($user &&  $user->email_subscription_type == 0) {
                $is_one_day_expire_remind = db()->where('user_id', $user->user_id)->getOne('user_emails')->is_trial_1day_email;
                if ($is_one_day_expire_remind == 1  && $user->plan_id == 'free') {
                    try {
                        /* Prepare the email */

                        if ($promoUser->type == 'pricing') {

                            $promoMail = $this->promo_email($user, 'promo-70-2', 'promo_70_pricing_2');

                        } else if ($promoUser->type == 'checkout') {

                            $promoMail = $this->promo_email($user, 'promo-70-2', 'promo_70_checkout_2');
                        }
                        if (isset($promoMail) && $promoMail['complete']) {

                            db()->where('user_id', $user->user_id)->update('promo_email_rules', [
                                'is_second_email' => '1',
                            ]);
                        }
                    } catch (\Throwable $th) {
                        //throw $th;
                    }
                }
            }
        }

        // month first email trigger
        $query  = "SELECT `month_first_email_date`,`type`, `id`, `is_month_email`, `user_id` FROM `promo_email_rules` WHERE  `month_first_email_date` < '{$nowTime}' AND (`type` != 'purchase' OR `type` IS NULL)  AND `is_month_email` = 0 ORDER BY `id` ASC";
        $promo_month_email_rules = db()->query($query);

        foreach ($promo_month_email_rules as $promoUser) {
            $user = db()->where('user_id', $promoUser->user_id)->getOne('users');

            if ($user &&  $user->email_subscription_type == 0) {
                $isPlanExpire = (new DateTime($user->plan_expiration_date) < new DateTime()) ? true : false;
                if ($isPlanExpire  && $user->plan_id == 'free') {
                    try {
                        /* Prepare the email */
                        $promoMail = $this->promo_email($user, 'promo-70-month-1', 'promo_70_month');
                        if ($promoMail['complete']) {
                            db()->where('user_id', $user->user_id)->update('promo_email_rules', [
                                'is_month_email' => '1',
                            ]);

                        }
                    } catch (\Throwable $th) {
                        //throw $th;
                    }
                }
            }
        }


        // month second email trigger
        $query  = "SELECT `month_second_email_date` , `type`, `id` , `is_month_email_2`, `user_id` FROM `promo_email_rules` WHERE  `month_second_email_date` < '{$nowTime}' AND (`type` != 'purchase' OR `type` IS NULL) AND `is_month_email_2` = 0 ORDER BY `id` ASC";
        $promo_month_email_rules = db()->query($query);
        foreach ($promo_month_email_rules as $promoUser) {
            /* Prepare the email */
            $user = db()->where('user_id', $promoUser->user_id)->getOne('users');
            if ($user &&  $user->email_subscription_type == 0) {
                $isPlanExpire = (new DateTime($user->plan_expiration_date) < new DateTime()) ? true : false;
                $promoMail =  $this->promo_email($user, 'promo-70-month-2', 'promo_70_month_2');

                if ($promoMail['complete']) {
                    db()->where('user_id', $user->user_id)->update('promo_email_rules', [
                        'is_month_email_2' => '1',
                    ]);

                }
            }
        }
    }

    private function promo_email($user, $template, $email_type)
    {
        $link     = 'plans-and-prices?promo_code=70OFF&referral_key=' . $user->referral_key . '&email=' . $email_type;
        return trigger_email($user->user_id, $template, $link);
    }

    public function user_promo_image($user)
    {
        $code = 'USD';
        $asset_path    = SITE_URL . 'themes/altum/assets';

        if($user->payment_currency && $user->payment_currency != ''){
            $code = $user->payment_currency;
        }else{
            $countryCurrency = get_user_currency($user->currency_code);                     
            if($countryCurrency){            
                $code = $user->currency_code;    
            }

        }        
        $image = $asset_path . '/images/promo_image/'.$code.'_Promo_70.png';
        return $image;
    }

    private function trial_mail_send($subject, $user_name, $link, $user_email, $user_language, $type)
    {
        try {

            $email_template =   [
                'subject' => $subject,
                'user_name' => $user_name,
                'link' => $link,
                'body' => [],
            ];

            send_mail($user_email, $email_template['subject'], $email_template['body'], ['language' =>  $user_language, 'link' => $email_template['link'], 'user_name' => $email_template['user_name'], 'type' => $type]);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    private function free_trial_funnel()
    {
        $query  = "
            SELECT * 
            FROM `user_emails` 
            WHERE  `funnel_type` != 'DPF' 
            AND `payment_date` IS NULL 
            AND NOT (
            (`is_scan_and_track_email` = '1' OR `is_download_reminder_email` = '1' )
            AND `is_print_qr_email` = 1
            AND `is_trial_1day_email` = 1
            AND `plan_expiry_reminder` = 1
          )  ORDER BY `id` ASC";

        $userEmails = db()->query($query);
        $nowTime    = (new \DateTime())->format('Y-m-d H:i:s');
        $today      = (new \DateTime())->format('Y-m-d');

        foreach ($userEmails as $userEmail) {

            $user =  database()->query("SELECT * FROM `users` WHERE `user_id` = {$userEmail->user_id} AND `plan_id` = 'free'  AND `payment_subscription_id` IS NULL AND `payment_processor` IS NULL AND '{$nowTime}' <= `plan_expiration_date`")->fetch_object();

            if ($user) {

                // check if user is already download qr code
                $is_download_complete = db()->where('is_download', true)->where('user_id', $user->user_id)->orderBy('qr_code_id', 'ASC')->getOne('qr_codes');

                if (($today ==  (new \DateTime($userEmail->download_reminder_email_date))->format('Y-m-d') && $nowTime > $userEmail->download_reminder_email_date) && $userEmail->is_download_reminder_email == 0 && !$is_download_complete && $user->email_subscription_type == 0) {
                    // send qr-download-reminder mail
                    $link      = 'qr-download/' . $user->referral_key;
                    $template  = 'qr-download-reminder';

                    $email =  trigger_email($user->user_id, $template, $link);

                    if ($email['complete']) {
                        /* Update user */
                        db()->where('user_id', $user->user_id)->update('user_emails', ['is_download_reminder_email' => 1]);
                    }
                } else if (($today ==  (new \DateTime($userEmail->scan_qr_email_date))->format('Y-m-d') && $nowTime > $userEmail->scan_qr_email_date) && $userEmail->is_scan_and_track_email == 0 && $userEmail->is_download_reminder_email == 0 && $is_download_complete && $user->email_subscription_type == 0) {

                    // send scan-and-track-qr
                    $link       = 'analytics';
                    $template   = 'scan-and-track-qr';
                    $email      =  trigger_email($user->user_id, $template, $link);

                    if ($email['complete']) {
                        /* Update user */
                        db()->where('user_id', $user->user_id)->update('user_emails', ['is_scan_and_track_email' => 1]);
                    }
                } else if (($today == (new \DateTime($userEmail->print_qr_email_date))->format('Y-m-d') && $nowTime > $userEmail->print_qr_email_date) && $userEmail->is_print_qr_email == 0 && $user->email_subscription_type == 0) {

                    // send print-qr mail
                    $link      = 'login?redirect=qr-codes';
                    $template  = 'print-qr';
                    $email     = trigger_email($user->user_id, $template, $link);

                    if ($email['complete']) {
                        /* Update user */
                        db()->where('user_id', $user->user_id)->update('user_emails', ['is_print_qr_email' => 1]);
                    }
                } else if (($today == (new \DateTime($userEmail->trial_1day_email_date))->format('Y-m-d') && $nowTime > $userEmail->trial_1day_email_date)  && $userEmail->is_trial_1day_email == 0 && $user->email_subscription_type !=  2) {

                    // send trial-expire-1day-reminder
                    $link      = 'plans-and-prices?referral_key=' . $user->referral_key;
                    $template  = 'trial-expire-1day-reminder';
                    $email     = trigger_email($user->user_id, $template, $link);

                    if ($email['complete']) {
                        /* Update user */
                        db()->where('user_id', $user->user_id)->update('user_emails', ['is_trial_1day_email' => 1]);
                    }
                } else if (($today == (new \DateTime($userEmail->plan_expiry_reminder_date))->format('Y-m-d') && $nowTime > $userEmail->plan_expiry_reminder_date)  && $userEmail->plan_expiry_reminder == 0 && $user->plan_expiry_reminder == 0  && $user->email_subscription_type !=  2) {
                    try {

                        // send trial-expire
                        $link      = 'plans-and-prices?referral_key=' . $user->referral_key . '&email=trial_expired';
                        $template  = 'trial-end';
                        $email     = trigger_email($user->user_id, $template, $link);

                        if ($email['complete']) {
                            /* Update user */
                            db()->where('user_id', $user->user_id)->update('users', ['plan_expiry_reminder' => 1]);
                            // Update user_emails table
                            db()->where('user_id', $user->user_id)->update('user_emails', ['plan_expiry_reminder' => 1]);
                            
                        }
                    } catch (\Throwable $th) {
                        //throw $th;
                    }
                }
            }
        }
    }


    // dpf user send email after signup 1 hour later
    private function one_hour_dpf_email()
    {
        $nowTime  =  (new \DateTime())->format('Y-m-d H:i:s');

        $query    = "SELECT * FROM `dpf_user_emails` WHERE  `is_trial_payment` = 0  AND `is_one_hour_email` = 0 AND `one_hour_email_time` < '{$nowTime}' ORDER BY `id` ASC";
        $dpfUsers = db()->query($query);


        foreach ($dpfUsers as $dpfUser) {

            $user    = db()->where('user_id', $dpfUser->user_id)->getOne('users');

            if ($user  && $user->email_subscription_type !=  2) {
                $is_download_complete = db()->where('is_download', true)->where('user_id', $user->user_id)->orderBy('qr_code_id', 'ASC')->getOne('qr_codes');

                if (!$is_download_complete && $dpfUser->is_one_hour_email == 0) {
                    try {

                        $template =  'dpf-one-hour';
                        $link     = 'qr-download/' . $user->referral_key;
                        $email    = trigger_email($user->user_id, $template, $link);

                        if ($email['complete']) {
                            db()->where('user_id', $user->user_id)->update('dpf_user_emails', [
                                'is_one_hour_email'   => 1
                            ]);
                        }
                    } catch (\Throwable $th) {
                    }
                }
            }
        }
    }


    private function dpf_14_days_plan_emails()
    {

        $query    = "
        SELECT * 
        FROM `dpf_user_emails` 
        WHERE  `is_trial_payment` = 1 
        AND  `is_trial_cancel` = 1 
        AND NOT (
          `is_download_reminder_email` = 1
           AND `is_print_qr_email` = 1
           AND `is_scan_qr_email` = 1
           AND `is_trial_1day_email` = 1
           AND `plan_expiry_reminder` = 1
                ) 
        ORDER BY `id` ASC";


        $dpfUsers = db()->query($query);
        $nowTime  = (new \DateTime())->format('Y-m-d H:i:s');


        foreach ($dpfUsers as $dpfUser) {
            $user =  database()->query("SELECT * FROM `users` WHERE `user_id` = {$dpfUser->user_id}   AND (`payment_subscription_id` IS NULL OR `payment_subscription_id` = '')")->fetch_object();

            if ($user) {
                // check if user is already download qr code

                if (($dpfUser->cancel_date <=  $dpfUser->download_reminder_email_date && $nowTime > $dpfUser->download_reminder_email_date) && $dpfUser->is_download_reminder_email == 0 && $user->email_subscription_type == 0) {

                    // send qr-download-reminder mail
                    $link     = 'qr-download/' . $user->referral_key;
                    $template = 'qr-download-reminder';
                    $email    = trigger_email($user->user_id, $template, $link);
                    if ($email['complete']) {
                        /* Update user */
                        db()->where('user_id', $user->user_id)->update('dpf_user_emails', ['is_download_reminder_email' => 1]);
                    }
                } else if (($dpfUser->cancel_date <=  $dpfUser->print_qr_email_date && $nowTime > $dpfUser->print_qr_email_date) && $dpfUser->is_print_qr_email == 0 && $user->email_subscription_type == 0) {

                    // send print-qr mail
                    $link     = 'login?redirect=qr-codes';
                    $template = 'print-qr';
                    $email    = trigger_email($user->user_id, $template, $link);
                    if ($email['complete']) {
                        /* Update user */
                        db()->where('user_id', $user->user_id)->update('dpf_user_emails', ['is_print_qr_email' => 1]);
                    }
                } else if (($dpfUser->cancel_date <=  $dpfUser->scan_qr_email_date && $nowTime > $dpfUser->scan_qr_email_date)  && $dpfUser->is_scan_qr_email == 0 && $user->email_subscription_type == 0) {

                    // send scan-and-track-qr
                    $link     = 'login?redirect=analytics';
                    $template = 'scan-and-track-qr';
                    $email    =  trigger_email($user->user_id, $template, $link);
                    if ($email['complete']) {
                        /* Update user */
                        db()->where('user_id', $user->user_id)->update('dpf_user_emails', ['is_scan_qr_email' => 1]);
                    }
                } else if (($dpfUser->cancel_date <= $dpfUser->trial_1day_email_date && $nowTime > $dpfUser->trial_1day_email_date)  && $dpfUser->is_trial_1day_email == 0  && $user->email_subscription_type != 2) {

                    // send dpf 14 day plan reminder email
                    $link     = 'plans-and-prices?referral_key=' . $user->referral_key . '&email=trial_expired';
                    $template = 'dpf-14-day-trial-expire-1day-reminder';
                    $email    = trigger_email($user->user_id, $template, $link);
                    if ($email['complete']) {
                        /* Update user */
                        db()->where('user_id', $user->user_id)->update('dpf_user_emails', ['is_trial_1day_email' => 1]);
                    }
                }

                // 14-day plan has ended
                if (($nowTime > $dpfUser->plan_expiry_reminder_date) && $dpfUser->plan_expiry_reminder == 0  && $user->email_subscription_type != 2) {

                    // send dpf 14 day plan expire mail
                    $link     = 'plans-and-prices?referral_key=' . $user->referral_key . '&email=trial_expired';
                    $template = 'dpf-14-day-plan-end';
                    $email    = trigger_email($user->user_id, $template, $link);
                    if ($email['complete']) {
                        /* Update user */
                        db()->where('user_id', $user->user_id)->update('dpf_user_emails', ['plan_expiry_reminder' => 1]);
                    }
                }
            }
        }
    }


    // dpf user send promo email 14 days plan cancel
    private function dpf_user_promo_email_trigger()
    {
        $nowTime  =  (new \DateTime())->format('Y-m-d H:i:s');

        // first_email_trigger
        $query  = "SELECT `id`, `first_email_date`, `type`, `is_first_email`, `user_id`  FROM `promo_email_rules` WHERE `first_email_date` < '{$nowTime}' AND `type` != 'purchase'  AND `is_first_email` = 0 ORDER BY `id` ASC";
        $first_promo_users = db()->query($query);
        $promoMail = null;

        foreach ($first_promo_users as $promoUser) {
            $user = db()->where('user_id', $promoUser->user_id)->getOne('users');

            if ($user &&  $user->email_subscription_type == 0) {
                try {
                    /* Prepare the email */
                    if ($promoUser->type == 'pricing') {
                        $promoMail = $this->promo_email($user, 'promo-70-1', 'promo_70_pricing');

                        if ($promoMail['complete']) {
                        }
                    } else if ($promoUser->type == 'checkout') {
                        $promoMail = $this->promo_email($user, 'promo-70-1', 'promo_70_checkout');
                        if ($promoMail['complete']) {

                        }
                    }
                    if (isset($promoMail) && $promoMail['complete']) {

                        db()->where('user_id', $user->user_id)->update('promo_email_rules', [
                            'is_first_email' => '1',
                        ]);
                    }
                } catch (\Throwable $th) {
                    //throw $th;
                }
            }
        }

        //second_email_trigger
        $query  = "SELECT `id`, `second_email_date`, `type`, `is_second_email`, `user_id` FROM `promo_email_rules` WHERE  `second_email_date` < '{$nowTime}' AND `type` != 'purchase'  AND `is_second_email` = 0 ORDER BY `id` ASC";
        $second_promo_users = db()->query($query);
        foreach ($second_promo_users as $promoUser) {
            $user = db()->where('user_id', $promoUser->user_id)->getOne('users');

            if ($user &&  $user->email_subscription_type == 0) {

                try {
                    /* Prepare the email */

                    if ($promoUser->type == 'pricing') {

                        $promoMail = $this->promo_email($user, 'promo-70-2', 'promo_70_pricing');
                        if ($promoMail['complete']) {

                        }
                    } else if ($promoUser->type == 'checkout') {

                        $promoMail = $this->promo_email($user, 'promo-70-2', 'promo_70_checkout');
                        if ($promoMail['complete']) {

                        }
                    }
                    if (isset($promoMail) && $promoMail['complete']) {
                        db()->where('user_id', $user->user_id)->update('promo_email_rules', [
                            'is_second_email' => '1',
                        ]);
                    }
                } catch (\Throwable $th) {
                    //throw $th;
                }
            }
        }



        // month first email trigger
        $query  = "SELECT `month_first_email_date`,`type`, `id`, `is_month_email`, `user_id` FROM `promo_email_rules` WHERE  `month_first_email_date` < '{$nowTime}' AND (`type` != 'purchase' OR `type` IS NULL)  AND `is_month_email` = 0 ORDER BY `id` ASC";
        $promo_month_email_rules = db()->query($query);

        foreach ($promo_month_email_rules as $promoUser) {
            $user = db()->where('user_id', $promoUser->user_id)->getOne('users');

            if ($user &&  $user->email_subscription_type == 0) {

                try {
                    /* Prepare the email */
                    $promoMail =  $this->promo_email($user, 'promo-70-month-1', 'promo_70_month');
                    if ($promoMail['complete']) {

                        db()->where('user_id', $user->user_id)->update('promo_email_rules', [
                            'is_month_email'  => '1',
                        ]);
                        
                    }
                } catch (\Throwable $th) {
                    //throw $th;
                }
            }
        }

        // month second email trigger
        $query  = "SELECT `month_second_email_date` , `type`, `id` , `is_month_email_2`, `user_id` FROM `promo_email_rules` WHERE  `month_second_email_date` < '{$nowTime}' AND (`type` != 'purchase' OR `type` IS NULL) AND `is_month_email_2` = 0 ORDER BY `id` ASC";
        $promo_month_email_rules = db()->query($query);
        foreach ($promo_month_email_rules as $promoUser) {
            /* Prepare the email */
            $user = db()->where('user_id', $promoUser->user_id)->getOne('users');
            if ($user && $user->email_subscription_type == 0) {
                $promoMail = $this->promo_email($user, 'promo-70-month-2', 'promo_70_month_2');

                if ($promoMail['complete']) {
                    db()->where('user_id', $user->user_id)->update('promo_email_rules', [
                        'is_month_email_2' => '1',
                    ]);
                    
                }
            }
        }
    }

    // Send a message via slack when the ipapi usage limit is low
    private function ipapi_credit_usage()
    {

        try {
            $Url = "https://ipapi.co/quota/?key=QsFZ2GmiouG1L37tzRD2B9UKNN36YzQjB4XbgQyI0B6BJDdIs8";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $Url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $output = curl_exec($ch);
            curl_close($ch);
            $data =  @json_decode($output);
            $message = null;

            $ipapi_plan = db()->where('id', 1)->getOne('ipapi_records');

            if (!$ipapi_plan) {
                db()->insert('ipapi_records', [
                    'current_plan' => '2000000',
                ]);
            }

            if ($data) {
                $available =  $data->available;
                $percentage = ($available / 2000000) * 100;
                $percentage = round($percentage) . '%';
                $webhookUrl = WEB_HOOK_URL;


                db()->where('id', 1)->update('ipapi_records', ['available_balance' => $available]);

                if ($available > 50000) {
                    db()->where('id', 1)->update('ipapi_records', ['reminder_message_1' => 0]);
                }

                if ($available > 10000) {
                    db()->where('id', 1)->update('ipapi_records', ['reminder_message_2' => 0]);
                }

                if ($available < 50000 && $ipapi_plan->reminder_message_1 == "0") {
                    $message = array(
                        'text' => "Ipapi Quota Alert :warning: \nHi <!channel> \n\nYour current API quota is only " . $available . " out of 2,000,000 (" . $percentage . "). Consider increasing utilization to maximize your benefits.",
                    );

                    db()->where('id', 1)->update('ipapi_records', [
                        'available_balance'   => $available,
                        'reminder_message_1'  => 1
                    ]);
                }

                if ($data) {
                    $available =  $data->available;
                    $percentage = ($available / 6000000) * 100;
                    $percentage = round($percentage) . '%';
                    $webhookUrl = WEB_HOOK_URL;


                    if ($available < 10000 && $ipapi_plan->reminder_message_2 == "0") {
                        $message = array(
                            'text' => "Urgent: Upgrade API Plan :rotating_light: :warning: :rotating_light: :warning: \nHi <!channel> \n\nYour API quota is nearing the limit at " . $available . " out of 2,000,000 (" . $percentage . "). Time to upgrade your plan for seamless service. \nPlease take prompt action to update the ipapi quota limit and ensure uninterrupted service (https://ipapi.co/account/).",
                        );

                        db()->where('id', 1)->update('ipapi_records', [
                            'available_balance'   => $available,
                            'reminder_message_2'  => 1
                        ]);
                    }
                }
                if ($message) {
                    // Convert the message to JSON format
                    $payload = json_encode($message);

                    $ch = curl_init($webhookUrl);
                    // Set cURL options
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, [
                        'Content-Type: application/json',
                    ]);

                    $result = curl_exec($ch);
                    curl_close($ch);
                    // echo $result;
                }
            }
        } catch (Exception $e) {
            header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
            echo json_encode(array("success" => false, "message" => $e->getMessage()));
            return;
        }
    }

    // Delete archived QR codes after 30 days of creation
    private function delete_archived_qr_codes()
    {
        $removeDate = (new \DateTime())->modify('-60 days')->format('Y-m-d H:i:s');

        $result = database()->query("
        SELECT * FROM 
            `qr_codes`
        WHERE 
            `user_id` IS NULL
            AND '{$removeDate}' > datetime
        ");
        while ($qr_code = $result->fetch_object()) {

            (new \Altum\Models\QrCode())->delete($qr_code->qr_code_id);
        }
    }
}
