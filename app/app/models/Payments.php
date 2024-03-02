<?php
/*
 * @copyright Copyright (c) 2021 AltumCode (https://altumcode.com/)
 *
 * This software is exclusively sold through https://altumcode.com/ by the AltumCode author.
 * Downloading this product from any other sources and running it without a proper license is illegal,
 *  except the official ones linked from https://altumcode.com/.
 */

namespace Altum\Models;

use Altum\Date;
use Altum\Logger;
use Altum\Models\User;
use Exception;
use Stripe\Exception\ApiErrorException;

class Payments extends Model
{

    public function webhook_process_payment($payment_processor, $external_payment_id, $payment_total, $payment_currency, $user_id, $plan_id, $payment_frequency, $code, $discount_amount, $base_amount, $taxes_ids, $payment_type, $payment_subscription_id, $payer_email, $payer_name, $status, $proof, $previous_plan, $credit_amount,  $description)
    {


        /* Get the plan details */
        $plan = db()->where('plan_id', $plan_id)->getOne('plans');

        /* Just make sure the plan is still existing */
        if (!$plan) {
            echo 'Plan not available';
            http_response_code(400);
            die();
        }

        // /* Make sure the transaction is not already existing */
        if (db()->where('payment_id', $external_payment_id)->where('status', 1)->where('processor', $payment_processor)->has('payments')) {
            echo 'All ready payment';
            http_response_code(400);
            die();
        }

        /* Make sure the account still exists */
        $user          = db()->where('user_id', $user_id)->getOne('users');

        if (!$user) {
            echo 'User not available';
            http_response_code(400);
            die();
        }

        $paymentUser =  db()->where('user_id', $user_id)->getOne('payments');
        if (!$paymentUser && ($plan->plan_id == 6 || $plan->plan_id == 7)) {
            db()->where('user_id', $user_id)->update('user_emails', [
                'payment_date'  => \Altum\Date::$date,
            ]);
        }


        /* Add a log into the database */
        $payment = db()->insert('payments', [
            'user_id' => $user_id,
            'plan_id' => $plan_id,
            'processor' => $payment_processor,
            'type' => $payment_type,
            'frequency' => $payment_frequency,
            'code' => $code,
            'discount_amount' => $discount_amount,
            'base_amount' => $base_amount,
            'email' => $payer_email,
            'payment_id' => $external_payment_id,
            'name' => $payer_name,
            'plan' => json_encode(db()->where('plan_id', $plan_id)->getOne('plans', ['plan_id', 'name'])),
            'billing' => settings()->payment->taxes_and_billing_is_enabled && $user->billing ? $user->billing : null,
            'business' => json_encode(settings()->business),
            'taxes_ids' => $taxes_ids,
            'total_amount' => $payment_total,
            'currency' => $payment_currency,
            'status' => $status,
            'datetime' => Date::$date,
            'payment_proof' => $proof,
            'previous_plan' => $previous_plan,
            'credit_amount' => $credit_amount,
        ]);

        db()->where('payment_id', $external_payment_id)->update('payment_failed', [
            'payment_success' => '1',
        ]);



        // update promo emails rules table record
        $promo_email_rules = db()->where('user_id', $user->user_id)->getOne('promo_email_rules');
        if ($promo_email_rules && $promo_email_rules->type != 'purchase') {
            db()->where('user_id', $user->user_id)->update('promo_email_rules', [
                'type'               => 'purchase',
                'payment_date'       => \Altum\Date::$date
            ]);
        }

        $subscription = db()->where('subscription_id', $payment_subscription_id)->getOne('subscriptions');

        /* Update the user with the new plan */
        if ($subscription) {
            $current_plan_expiration_date = $user->plan_expiration_date;
        } else {
            $current_plan_expiration_date = '';
        }

        switch ($payment_frequency) {
            case 'monthly':
                $plan_expiration_date = (new \DateTime($current_plan_expiration_date))->modify('+1 months')->format('Y-m-d H:i:s');
                break;
            case 'annually':
                if ($previous_plan) {
                    $plan_expiration_date  = (new \DateTime($user->plan_expiration_date))->modify('+11 months')->format('Y-m-d H:i:s');
                } else {
                    $plan_expiration_date = (new \DateTime($current_plan_expiration_date))->modify('+12 months')->format('Y-m-d H:i:s');
                }
                break;
            case 'quarterly':
                if ($previous_plan) {
                    $plan_expiration_date  = (new \DateTime($user->plan_expiration_date))->modify('+2 months')->format('Y-m-d H:i:s');
                } else {
                    $plan_expiration_date = (new \DateTime($current_plan_expiration_date))->modify('+3 months')->format('Y-m-d H:i:s');
                }
                break;
            case 'discounted':
                $plan_expiration_date = (new \DateTime($current_plan_expiration_date))->modify('+1 months')->format('Y-m-d H:i:s');
                break;
            case 'onetime':
                $plan_expiration_date = (new \DateTime($current_plan_expiration_date))->modify('+200 years')->format('Y-m-d H:i:s');
                break;
            case '14_day_full_access':
                $plan_expiration_date = (new \DateTime($current_plan_expiration_date))->modify('+14 days')->format('Y-m-d H:i:s');
                break;
            case '14_day_limited_access':
                $plan_expiration_date = (new \DateTime($current_plan_expiration_date))->modify('+14 days')->format('Y-m-d H:i:s');
                break;
        }
        /* Database query */
        db()->where('user_id', $user_id)->update('users', [
            'plan_id' => $plan_id,
            'plan_settings' => $plan->settings,
            'plan_expiration_date' => $plan_expiration_date,
            'plan_expiry_reminder' => 0,
            'plan_trial_done' => 1,
            'payment_subscription_id' => $payment_subscription_id,
            'payment_processor' => $payment_processor,
            'payment_total_amount' => $payment_total,
            'payment_currency' => $payment_currency,
            'subscription_cancel_date' => null,
        ]);


        $user = db()->where('user_id', $user_id)->getOne('users');

        $paymentPlanDiscountName = null;
        if ($code) {
            if ($code == STRIPE_COUPON_1_NEW || $code == STRIPE_COUPON_3_NEW || $code == STRIPE_COUPON_12_NEW) {
                $paymentPlanDiscountName = $plan->name . ' - Promo 70';
            }
            if ($code == STRIPE_COUPON_30_FOREVER) {
                $paymentPlanDiscountName = $plan->name . ' - Discount 30';
            }
            if ($code == STRIPE_COUPON_50_FOREVER) {
                $paymentPlanDiscountName = $plan->name . ' - Discount 50';
            }
            if ($code == STRIPE_COUPON_70_FOREVER) {
                $paymentPlanDiscountName = $plan->name . ' - Discount 70';
            }
            if ($code == STRIPE_COUPON_90_FOREVER) {
                $paymentPlanDiscountName = $plan->name . ' - Discount 90';
            }
        }


        if (!$subscription) {
            db()->insert('subscriptions', [
                'user_id' => $user_id,
                'plan_id' => $plan_id,
                'subscription_id' => $payment_subscription_id,
                'start_date' =>   Date::$date
            ]);
        }

        if ($user->subscription_schedule_id) {
            db()->where('user_id', $user_id)->update('users', [
                'subscription_schedule_id' => null,
            ]);
        }

        $subscriptionUser = analyticsDatabase()->query("SELECT * FROM `subscription_users` WHERE `user_id` = {$user_id} ORDER BY `id` DESC LIMIT 1")->fetch_object();

        $conversion_name_2 = null;
        $subscription_change_2 = null;
        $onboarding_funnel = $user->onboarding_funnel;
        $transaction_id = $external_payment_id;

        if (!$subscriptionUser) {

            if ($plan->plan_id == 6 || $plan->plan_id == 7) {
                $subscription_change = 'trial_purchase';
                $new_plan = $plan->plan_id == 6 ? 'trial_full' : 'trial_limited';
                $previous_plan = NULL;
                $previous_plan_amount = null;
                $conversion_name = 'Trial Purchase';
                $onboarding_funnel = 4;

                $this->dpfUserUpdateOnboarding($user,  $plan->plan_id);
            } else {

                if ($plan->plan_id == 2 && $description == 'DPF') {
                    $onboarding_funnel = 4;
                    $conversion_name = 'Trial Purchase - Annual';

                    $this->dpfUserUpdateOnboarding($user,  $plan->plan_id);
                } else {
                    $conversion_name = 'CFF Purchase';
                }

                $subscription_change = 'first_purchase';
                $new_plan = $code ? $paymentPlanDiscountName :  $plan->name;
                $previous_plan = NULL;
                $previous_plan_amount = NULL;
            }
        } else if ($subscriptionUser->subscription_change == 'trial_purchase') {

            $subscription_change = 'first_purchase';
            $new_plan = $plan->name;
            $previous_plan = $subscriptionUser->new_plan;
            $previous_plan_amount = $subscriptionUser->new_plan_amount;
            $conversion_name = 'DPF Purchase';
        } else if ($subscriptionUser->subscription_change == 'cancellation' && ($subscriptionUser->previous_plan == 'trial_limited' ||  $subscriptionUser->previous_plan == 'trial_full')) {

            $subscription_change = 'reactivation';
            $new_plan = $code ? $paymentPlanDiscountName :  $plan->name;
            $previous_plan = $subscriptionUser->previous_plan;
            $previous_plan_amount = $subscriptionUser->previous_plan_amount;
            $conversion_name = 'DPF Reactivation';

            $subscription_change_2 = 'first_purchase';
            $conversion_name_2 = 'DPF Purchase';
        } else if ($subscriptionUser->subscription_change == 'cancellation') {

            $previousSubscriptionUser = analyticsDatabase()->query("SELECT * FROM `subscription_users` WHERE `user_id` = {$user_id} AND  `subscription_change` != 'cancellation' AND  `subscription_change` != 'delinquent' ORDER BY `id` DESC LIMIT 1")->fetch_object();

            $subscription_change = 'reactivation';
            $new_plan = $code ? $paymentPlanDiscountName :  $plan->name;
            $previous_plan = $previousSubscriptionUser->new_plan;
            $previous_plan_amount = $previousSubscriptionUser->new_plan_amount;
            $conversion_name = 'Reactivation';

            $subscription_change_2 = 'purchase';
            $conversion_name_2 = $user->onboarding_funnel == 4 ? 'DPF Purchase Renewal' : 'CFF Purchase Renewal';
        } else if ($subscriptionUser->subscription_change == 'first_purchase' || $subscriptionUser->subscription_change == 'purchase') {

            $subscription_change = 'purchase';
            $new_plan = $code ? $paymentPlanDiscountName :  $plan->name;
            $previous_plan = Null;
            $previous_plan_amount = Null;
            $conversion_name = $user->onboarding_funnel == 4 ? 'DPF Purchase Renewal' : 'CFF Purchase Renewal';
        } else if ($subscriptionUser->subscription_change == 'reactivation') {

            $previousSubscriptionUser = analyticsDatabase()->query("SELECT * FROM `subscription_users` WHERE `user_id` = {$user_id} AND  `subscription_change` != 'cancellation' AND  `subscription_change` != 'delinquent' ORDER BY `id` DESC LIMIT 1")->fetch_object();

            $subscription_change = 'purchase';
            $new_plan = $plan->name;
            $previous_plan = $previousSubscriptionUser->new_plan;
            $previous_plan_amount = $previousSubscriptionUser->new_plan_amount;
            $conversion_name = $user->onboarding_funnel == 4 ? 'DPF Purchase Renewal' : 'CFF Purchase Renewal';
        } else if ($subscriptionUser->subscription_change == 'delinquent') {
            $previousSubscriptionUser = analyticsDatabase()->query("SELECT * FROM `subscription_users` WHERE `user_id` = {$user_id} AND  `subscription_change` != 'cancellation' AND  `subscription_change` != 'delinquent' ORDER BY `id` DESC LIMIT 1")->fetch_object();

            $subscription_change = 'reactivation';
            $new_plan = $code ? $paymentPlanDiscountName :  $plan->name;
            $previous_plan = $previousSubscriptionUser->new_plan;
            $previous_plan_amount = $previousSubscriptionUser->new_plan_amount;

            if ($previousSubscriptionUser->new_plan == 'trial_limited' || $previousSubscriptionUser->new_plan == 'trial_full') {
                $conversion_name = 'DPF Reactivation';
                $conversion_name_2 =      'DPF Purchase';
                $subscription_change_2 = 'first_purchase';
            } else {
                $conversion_name = 'Reactivation';
                $conversion_name_2 = $user->onboarding_funnel == 4 ? 'DPF Purchase Renewal' : 'CFF Purchase Renewal';
                $subscription_change_2 = 'purchase';
            }
        } else if ($subscriptionUser->subscription_change == 'refund') {

            // $previousSubscriptionUser = analyticsDatabase()->query("SELECT * FROM `subscription_users` WHERE `user_id` = {$user_id} AND  `subscription_change` != 'cancellation' AND  `subscription_change` != 'delinquent' ORDER BY `id` DESC LIMIT 1")->fetch_object();

            $subscription_change = 'reactivation';
            $new_plan = $code ? $paymentPlanDiscountName :  $plan->name;
            $previous_plan = $subscriptionUser->previous_plan;
            $previous_plan_amount = $subscriptionUser->previous_plan_amount;
            $conversion_name = 'Reactivation';
        } else if ($subscriptionUser->subscription_change == 'downgrade' || $subscriptionUser->subscription_change == 'upgrade') {

            $subscription_change = 'purchase';
            $new_plan = $code ? $paymentPlanDiscountName :  $plan->name;
            $previous_plan = $subscriptionUser->new_plan;
            $previous_plan_amount = $subscriptionUser->new_plan_amount;
            $conversion_name = $user->onboarding_funnel == 4 ? 'DPF Purchase Renewal' : 'CFF Purchase Renewal';
        }

        try {
            analyticsBb()->insert('subscription_users', [
                'user_id'                 => $user_id,
                'subscription_change'     => $subscription_change,
                'change_date'             => Date::$date,
                'new_plan'                => $new_plan,
                'previous_plan'           => $previous_plan,
                'new_plan_amount'         => $payment_total,
                'previous_plan_amount'    => $previous_plan_amount,
                'currency'                => $payment_currency,

            ]);
        } catch (Exception $e) {
            dil('subscription_users table not updated - ' . $user_id);
            dil($e);
        }

        $billing_info = json_decode($user->billing);
        $address = null;
        if (isset($billing_info->line1) && $billing_info->line1) {
            $address = $billing_info->line1;
            $address = isset($billing_info->line2) && $billing_info->line2 ? $address . ', ' . $billing_info->line2 : $address;
            $address = isset($billing_info->city) && $billing_info->city ? $address . ', ' . $billing_info->city : $address;
            $address = isset($billing_info->state) && $billing_info->state ? $address . ', ' . $billing_info->state : $address;
            $address = isset($billing_info->province) && $billing_info->province ? $address . ', ' . $billing_info->province : $address;
            $address = isset($billing_info->zip) && $billing_info->zip ? $address . ', ' . $billing_info->zip : $address;
            $address = isset($billing_info->postal_code) && $billing_info->postal_code ? $address . ', ' . $billing_info->postal_code : $address;
        }


        try {
            analyticsBb()->insert('conversion_data', [
                'user_id'             => $user_id,
                'name'                => $user->name,
                'email_id'            => $user->email,
                'gaid'                => $user->gaid,
                'country'             => $user->country,
                'subscription_change' => $subscription_change,
                'previous_plan'       => $previous_plan,
                'previous_plan_amount' => $previous_plan_amount,
                'new_plan'            => $new_plan,
                'new_plan_amount'     => $payment_total,
                'currency'            => $payment_currency,
                'conversion_name'     => $conversion_name,
                'transaction_id'      => $transaction_id,
                'onboarding_funnel'   => $onboarding_funnel,
                'create_time'         => \Altum\Date::$date,
                'signup_date'         => $user->datetime,
                'address'             => $address,
            ]);
        } catch (Exception $e) {
            dil('conversion_data table not updated - ' . $user_id);
            dil($e);
        }

        //Update additional records
        if ($conversion_name_2 && $subscription_change_2) {

            try {
                analyticsBb()->insert('subscription_users', [
                    'user_id'                 => $user_id,
                    'subscription_change'     => $subscription_change_2,
                    'change_date'             => Date::$date,
                    'new_plan'                => $new_plan,
                    'previous_plan'           => $previous_plan,
                    'new_plan_amount'         => $payment_total,
                    'previous_plan_amount'    => $previous_plan_amount,
                    'currency'                => $payment_currency,

                ]);
            } catch (Exception $e) {
                dil('subscription_users table second record not updated - ' . $user_id);
                dil($e);
            }

            try {
                analyticsBb()->insert('conversion_data', [
                    'user_id'             => $user_id,
                    'name'                => $user->name,
                    'email_id'            => $user->email,
                    'gaid'                => $user->gaid,
                    'country'             => $user->country,
                    'subscription_change' => $subscription_change_2,
                    'previous_plan'       => $previous_plan,
                    'previous_plan_amount' => $previous_plan_amount,
                    'new_plan'            => $new_plan,
                    'new_plan_amount'     => $payment_total,
                    'currency'            => $payment_currency,
                    'conversion_name'     => $conversion_name_2,
                    'transaction_id'      => $transaction_id,
                    'onboarding_funnel'   => $onboarding_funnel,
                    'create_time'         => \Altum\Date::$date,
                    'signup_date'         => $user->datetime,
                    'address'             => $address,
                ]);
            } catch (Exception $e) {
                dil('conversion_data table second record not updated - ' . $user_id);
                dil($e);
            }
        }


        /* Clear the cache */
        \Altum\Cache::$adapter->deleteItemsByTag('user_id=' . $user_id);
        // check already subscription

        if (!$subscriptionUser) {
            if ($plan_id == 6 || $plan_id == 7) {
                if ($user->email_subscription_type != 2) {
                    /* Send notification download the QR code  */
                    $link          = 'qr-download/' . $user->referral_key;
                    $template      = 'download-qr';
                    trigger_email($user->user_id, $template, $link);
                }
            } else {
                if ($user->email_subscription_type != 2) {
                    /* Send notification to the user first time payment */
                    $template  = 'subscription';
                    trigger_email($user->user_id, $template);
                }
            }
        }

        /* Send notification to admin if needed */
        if (settings()->email_notifications->new_payment && !empty(settings()->email_notifications->emails)) {

            $email_template = get_email_template(
                [
                    '{{PROCESSOR}}' => $payment_processor,
                    '{{TOTAL_AMOUNT}}' => $payment_total,
                    '{{CURRENCY}}' => $payment_currency,
                ],
                l('global.emails.admin_new_payment_notification.subject'),
                [
                    '{{PROCESSOR}}' => $payment_processor,
                    '{{TOTAL_AMOUNT}}' => $payment_total,
                    '{{CURRENCY}}' => $payment_currency,
                    '{{NAME}}' => $user->email,
                    '{{EMAIL}}' => $user->email,
                ],
                l('global.emails.admin_new_payment_notification.body')
            );

            send_mail(explode(',', settings()->email_notifications->emails), $email_template->subject, $email_template->body);
        }
    }

    public function codes_payment_check($code, $user)
    {
        /* Make sure the code exists */
        $codes_code = db()->where('code', $code)->where('type', 'discount')->getOne('codes');

        if ($codes_code) {
            /* Check if we should insert the usage of the code or not */
            if (!db()->where('user_id', $user->user_id)->where('code_id', $codes_code->code_id)->has('redeemed_codes')) {

                /* Update the code usage */
                db()->where('code_id', $codes_code->code_id)->update('codes', ['redeemed' => db()->inc()]);

                /* Add log for the redeemed code */
                db()->insert('redeemed_codes', [
                    'code_id'   => $codes_code->code_id,
                    'user_id'   => $user->user_id,
                    'datetime'  => \Altum\Date::$date
                ]);
            }

            return $codes_code;
        }

        return null;
    }

    public function affiliate_payment_check($payment_id, $payment_total, $user)
    {
        if (\Altum\Plugin::is_active('affiliate') && settings()->affiliate->is_enabled && $user->referred_by) {
            if ((settings()->affiliate->commission_type == 'once' && !$user->referred_by_has_converted) || settings()->affiliate->commission_type == 'forever') {
                $referral_user = db()->where('user_id', $user->referred_by)->getOne('users', ['user_id', 'email', 'status', 'plan_settings']);
                $referral_user->plan_settings = json_decode($referral_user->plan_settings);

                /* Make sure the referral user is active and existing */
                if ($referral_user && $referral_user->status == 1) {
                    $amount = number_format($payment_total * (float) $referral_user->plan_settings->affiliate_commission_percentage / 100, 2, '.', '');

                    /* Insert the affiliate commission */
                    db()->insert('affiliates_commissions', [
                        'user_id' => $referral_user->user_id,
                        'referred_user_id' => $user->user_id,
                        'payment_id' => $payment_id,
                        'amount' => $amount,
                        'currency' => settings()->payment->currency,
                        'datetime' => \Altum\Date::$date
                    ]);

                    /* Update the referred user */
                    db()->where('user_id', $user->user_id)->update('users', ['referred_by_has_converted' => 1]);
                }
            }
        }
    }

    private function dpfUserUpdateOnboarding($user, $planId)
    {

        if ($user) {
            // update DPF Funnel user record 
            if ($user->onboarding_funnel == 3) {

                db()->where('user_id', $user->user_id)->update('users', [
                    'onboarding_funnel' => 4
                ]);

                if ($planId == 6 || $planId == 7) {
                    db()->where('user_id', $user->user_id)->update('dpf_user_emails', [
                        'is_trial_payment' => 1,
                        'payment_date'     => \Altum\Date::$date,
                    ]);
                } else if ($planId == 2) {
                    db()->where('user_id', $user->user_id)->update('dpf_user_emails', [
                        'payment_date'  => \Altum\Date::$date,
                    ]);
                }

                db()->where('user_id', $user->user_id)->update('user_emails', [
                    'funnel_type' => 'DPF'
                ]);

                try {
                    $stripe = new \Stripe\StripeClient(settings()->stripe->secret_key);
                    $stripe->customers->update(
                        $user->stripe_customer_id,
                        ['metadata' => ['onboarding_funnel' => 4]]
                    );
                } catch (ApiErrorException $e) {
                    dil('Stripe funnel update error - ' . $user->user_id);
                }
            }
        }
    }
}
