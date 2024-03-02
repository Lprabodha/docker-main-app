<?php
/*
 * @copyright Copyright (c) 2021 AltumCode (https://altumcode.com/)
 *
 * This software is exclusively sold through https://altumcode.com/ by the AltumCode author.
 * Downloading this product from any other sources and running it without a proper license is illegal,
 *  except the official ones linked from https://altumcode.com/.
 */

namespace Altum\Models;

use Altum\Database\Database;
use Altum\Logger;
use Altum\PaymentGateways\Paystack;
use MaxMind\Db\Reader;
use Razorpay\Api\Api;
use Altum\Date;
use Stripe\Exception\ApiErrorException;

class User extends Model
{

    public function get_user_by_user_id($user_id)
    {

        /* Try to check if the store posts exists via the cache */
        $cache_instance = \Altum\Cache::$adapter->getItem('user?user_id=' . $user_id);

        /* Set cache if not existing */
        if (is_null($cache_instance->get())) {

            /* Get data from the database */
            $data = db()->where('user_id', $user_id)->getOne('users');

            if ($data) {

                /* Parse the users plan settings */
                $data->plan_settings = json_decode($data->plan_settings);

                /* Parse billing details if existing */
                $data->billing = json_decode($data->billing);

                /* Save to cache */
                \Altum\Cache::$adapter->save(
                    $cache_instance->set($data)->expiresAfter(CACHE_DEFAULT_SECONDS)->addTag('users')->addTag('user_id=' . $data->user_id)
                );
            }
        } else {

            /* Get cache */
            $data = $cache_instance->get();
        }



        return $data;
    }

    public function get_user_by_user_id_and_token_code($user_id, $token_code)
    {

        /* Try to check if the store posts exists via the cache */
        $cache_instance = \Altum\Cache::$adapter->getItem('user?user_id=' . md5($user_id) . '&token_code=' . $token_code);

        /* Set cache if not existing */
        if (is_null($cache_instance->get())) {

            /* Get data from the database */
            $data = db()->where('user_id', $user_id)->where('token_code', $token_code)->getOne('users');

            if ($data) {

                /* Parse the users plan settings */
                $data->plan_settings = json_decode($data->plan_settings);



                /* Parse billing details if existing */
                $data->billing = json_decode($data->billing);

                /* Save to cache */
                \Altum\Cache::$adapter->save(
                    $cache_instance->set($data)->expiresAfter(CACHE_DEFAULT_SECONDS)->addTag('users')->addTag('user_id=' . $data->user_id)
                );
            }
        } else {

            /* Get cache */
            $data = $cache_instance->get();
        }


        return $data;
    }

    /* Requires full user variable */
    public function process_user_plan_expiration_by_user($user)
    {

        if ((new \DateTime($user->plan_expiration_date)) < (new \DateTime()) && $user->plan_id != 'free') {

            /* Switch the user to the default plan */
            db()->where('user_id', $user->user_id)->update('users', [
                'plan_id' => 'free',
                'plan_settings' => json_encode(settings()->plan_free->settings),
                'payment_subscription_id' => '',
            ]);

            /* Clear the cache */
            \Altum\Cache::$adapter->deleteItemsByTag('user_id=' . $user->user_id);
        }
    }

    public function delete($user_id)
    {

        /* Cancel his active subscriptions if active */
        // $this->cancel_subscription($user_id);

        /* Send webhook notification if needed */
        if (settings()->webhooks->user_delete) {

            $user = db()->where('user_id', $user_id)->getOne('users', ['user_id', 'email', 'name']);

            \Unirest\Request::post(settings()->webhooks->user_delete, [], [
                'user_id' => $user->user_id,
                'email' => $user->email,
                'name' => $user->name
            ]);
        }

        /* archiving QR codes of deleted user */
        $result = database()->query("SELECT `qr_code_id` FROM `qr_codes` WHERE `user_id` = {$user_id}");

        while ($qr_code = $result->fetch_object()) {
            // (new \Altum\Models\QrCode())->delete($qr_code->qr_code_id);
            db()->where('qr_code_id', $qr_code->qr_code_id)->update('qr_codes', ['user_id' => NULL]);
        }

        /* Delete the record from the database */
        db()->where('user_id', $user_id)->delete('users');

        /* Clear the cache */
        \Altum\Cache::$adapter->deleteItemsByTag('user_id=' . $user_id);
    }

    public function update_last_activity($user_id)
    {
        db()->where('user_id', $user_id)->update('users', ['last_activity' => \Altum\Date::$date]);

        }

    public function verify_null_password($user_id, $email, $password)
    {
        if (empty($password)) {
            $lost_password_code = $lost_password_code ?? md5($email . microtime());
            db()->where('user_id', $user_id)->update('users', ['lost_password_code' => $lost_password_code]);
            redirect('reset-password/' . md5($email) . '/' . $lost_password_code);
        }

        return;
    }

    public function create(
        $email = '',
        $raw_password = '',
        $name = '',
        $status = 0,
        $source = null,
        $email_activation_code = null,
        $lost_password_code = null,
        $plan_id = 'free',
        $plan_settings = '',
        $plan_expiration_date = null,
        $timezone = 'UTC',
        $type = 0,
        $onboarding_funnel = 0,
        $is_admin_created = false,
        $is_review = 0,
        $plan_expiry_reminder = 0,


    ) {



        /* Define some needed variables */

        if($source == 'google'){
            $password =  null;
        }else{
            $password = is_null($raw_password) ? null : password_hash($raw_password, PASSWORD_DEFAULT);
        }

       
        $total_logins = $status == '1' && !$is_admin_created ? 1 : 0;
        $plan_expiration_date = $plan_expiration_date ?? \Altum\Date::$date;
        $plan_trial_done = 0;
        $language = \Altum\Language::$name;
        $billing = json_encode(['fname' => '', 'lname' => '', 'address' => '', 'company' => '', 'apartment' => '', 'province' => '', 'city' => '', 'zip' => '', 'country' => '']);
        $api_key = md5($email . microtime() . microtime());
        $referral_key = md5(rand() . $email . microtime() . $email . microtime());
        $ip = $is_admin_created ? null : get_ip();
        $last_user_agent = $is_admin_created ? null : Database::clean_string($_SERVER['HTTP_USER_AGENT']);


        $userGeLocation = get_user_gelocation();
        $device        = $userGeLocation['device'];

        $country = null;
        $currencyCode = null;
        $payment_currency = null;
        try {
            $Url = "https://ipapi.co/" . get_ip() . "/json?key=QsFZ2GmiouG1L37tzRD2B9UKNN36YzQjB4XbgQyI0B6BJDdIs8";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $Url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $output = curl_exec($ch);
            curl_close($ch);
            $ipData =  @json_decode($output);
            if (!isset($ipData->error)) {
                $country = $ipData->country;
                $currencyCode = $ipData->currency;
                $payment_currency = 'USD';
                $countryCurrency = get_user_currency($ipData->currency);                     
                if($countryCurrency){            
                    $payment_currency = $ipData->currency;    
                }

            }
        } catch (\Exception $exception) {
        }


        /* Check for potential referral cookie */
        $referred_by = null;
        if (!$is_admin_created && isset($_COOKIE['referred_by']) && $user = db()->where('referral_key', $_COOKIE['referred_by'])->getOne('users', ['user_id', 'referral_key'])) {
            $referred_by = $user->user_id;
        }

        $get_gtm_campaign_url_data = get_gtm_campaign_url_data();

        /* Add the user to the database */
        $registered_user_id = db()->insert('users', [
            'password' => $password,
            'email' => $email,
            'name' => $name,
            'billing' => $billing,
            'api_key' => $api_key,
            'email_activation_code' => $email_activation_code,
            'lost_password_code' => $lost_password_code,
            'plan_id' => $plan_id,
            'plan_expiration_date' => $plan_expiration_date,
            'plan_settings' => $plan_settings,
            'plan_trial_done' => $plan_trial_done,
            'referral_key' => $referral_key,
            'referred_by' => $referred_by,
            'language' => $language,
            'timezone' => $timezone,
            'status' => $status,
            'type' => $type == 2 ? 2 : 0,
            'onboarding_funnel' => $onboarding_funnel,
            'source' => $source,
            'datetime' => \Altum\Date::$date,
            'ip' => $ip,
            'country' => $country,
            'currency_code' => $currencyCode,
            'payment_currency' => $payment_currency,
            'last_user_agent' => $last_user_agent,
            'total_logins' => $total_logins,
            'is_review' => $is_review,
            'device' => $device,
            'plan_expiry_reminder' => $plan_expiry_reminder,
            'gaid' => $get_gtm_campaign_url_data['gaid'],
            'utm_term' => $get_gtm_campaign_url_data['utm_term'],
            'matchtype' => $get_gtm_campaign_url_data['matchtype'],

        ]);

        /* Clear out referral cookie if needed */
        if ($referred_by) {
            setcookie('referred_by', '', time() - 30, COOKIE_PATH);
        }

        return [
            'user_id' => $registered_user_id,
            'password' => $password,
        ];
    }

    /*
     * Function to update a user with more details on a login action
     */
    public function login_aftermath_update($user_id, $method = 'default')
    {

        $ip = get_ip();
        $last_user_agent = Database::clean_string($_SERVER['HTTP_USER_AGENT']);

        $ipData = location_data();

        /* Database query */
        db()->where('user_id', $user_id)->update('users', [
            'ip' => $ip,
            'last_user_agent' => $last_user_agent,
            'total_logins' => db()->inc(),
            'user_deletion_reminder' => 0,
            'timezone' =>    $ipData->timezone ? $ipData->timezone : settings()->main->default_timezone,
        ]);

        // Logger::users($user_id, 'login.' . $method . '.success');

        /* Clear the cache */
        \Altum\Cache::$adapter->deleteItemsByTag('user_id=' . $user_id);
    }

    public function cancel_subscription($user_id)
    {

        $user = db()->where('user_id', $user_id)->getOne('users');
        $stripe = new \Stripe\StripeClient(settings()->stripe->secret_key);

        $activeStripeSubcription   = null;
        if (!$user->payment_subscription_id && !$user->subscription_schedule_id) {
            $activeSubcription = db()->where('user_id', $user_id)->orderBy('id', 'DESC')->getOne('subscriptions');
            if ($activeSubcription) {
                try {
                    $activeStripeSubcription = $stripe->subscriptions->retrieve(
                        $activeSubcription->subscription_id,
                        []
                    );
                } catch (ApiErrorException $e) {
                    $activeStripeSubcription   = null;
                }
            }

            if (!$activeStripeSubcription) {
                return true;
            }
        }

        if(isset($_COOKIE['feedback_type']) && $_COOKIE['feedback_type'] != ''){

            db()->where('user_id', $user->user_id)->update('users', [
                'cancel_reason' =>  cancel_promo_reason($_COOKIE['feedback_type'])
            ]);
           
        }

        if ($user->payment_subscription_id && $user->payment_subscription_id != 'onetime') {


            $stripe->subscriptions->cancel(
                $user->payment_subscription_id,
                []
            );

            db()->where('user_id', $user_id)->update('users', [
                'payment_subscription_id' => NULL,
            ]);
        } else if ($activeStripeSubcription) {
            $stripe->subscriptions->cancel(
                $activeSubcription->subscription_id,
                []
            );
        } else {



            $stripe->subscriptionSchedules->cancel(
                $user->subscription_schedule_id,
                []
            );

            db()->where('user_id', $user_id)->update('subscriptions', [
                'end_date'    => Date::$date,
            ]);

            db()->where('user_id', $user_id)->update('users', [
                'subscription_schedule_id' => Null,
            ]);

            $subscriptionUser = analyticsDatabase()->query("SELECT * FROM `subscription_users` WHERE `user_id` = {$user->user_id} AND  `subscription_change` != 'cancellation' AND  `subscription_change` != 'delinquent' ORDER BY `id` DESC LIMIT 1")->fetch_object();
            if ($subscriptionUser) {

                analyticsBb()->insert('subscription_users', [
                    'user_id'                 => $user->user_id,
                    'subscription_change'     => 'cancellation',
                    'change_date'             => Date::$date,
                    'new_plan'                => $user->plan_id == 8 ? 'Lifetime free' : NULL,
                    'previous_plan'           => $subscriptionUser->new_plan,
                    'new_plan_amount'         => NULL,
                    'previous_plan_amount'    => isset($subscriptionUser->new_plan_amount) ? $subscriptionUser->new_plan_amount : null,
                    'currency'                => $subscriptionUser->currency,

                ]);
            }
        }


        /* Clear the cache */
        \Altum\Cache::$adapter->deleteItemsByTag('user_id=' . $user->user_id);
    }
}
