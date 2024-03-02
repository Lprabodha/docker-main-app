<?php
/*
 * @copyright Copyright (c) 2023 AltumCode (https://altumcode.com/)
 *
 * This software is exclusively sold through https://altumcode.com/ by the AltumCode author.
 * Downloading this product from any other sources and running it without a proper license is illegal,
 *  except the official ones linked from https://altumcode.com/.
 */

namespace Altum\Controllers;

use Altum\Logger;
use Altum\Models\Payments;
use Altum\Date;
use Exception;
use Stripe\Exception\ApiErrorException;
use Stripe\Exception\OAuth\ExceptionInterface;

class WebhookStripe extends Controller
{

    public function index()
    {

        $stripe = new \Stripe\StripeClient(settings()->stripe->secret_key);
        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;
        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $sig_header,
                settings()->stripe->webhook_secret
            );
        } catch (\UnexpectedValueException $e) {
            echo $e->getMessage();
            http_response_code(400);
            exit();
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            echo $e->getMessage();
            http_response_code(400);
            exit();
        }

        // Handle the event
        if ($event->type == 'invoice.paid') {

            $paymentIntent = $event->data->object;


            $payment_subscription_id = $paymentIntent['subscription'];
            $customer = $stripe->customers->retrieve($paymentIntent['customer']);

            $user_id = (int) $customer['metadata']['user_id'];

            $payer_email = $paymentIntent['customer_email'];
            $payer_name =  $paymentIntent['customer_name'];


            if ($paymentIntent['charge'] == '') { //Subcription created with trial days  
                echo 'Subcription created and trial active ';

                http_response_code(200);
                exit();
            } else {
                $chargData = $stripe->charges->retrieve($paymentIntent['charge']);
                $card = $chargData['payment_method_details']['card']['brand'];
                $last4 = $chargData['payment_method_details']['card']['last4'];
                $proof = $card . ' ****' . $last4;

                $subscriptions = $stripe->subscriptions->retrieve($payment_subscription_id);
                $subscriptionsPaymentMethod  = $subscriptions->default_payment_method;

                $description = $subscriptions->description;

                $user = db()->where('email', $payer_email)->getOne('users');
                $billing_info = json_decode($user->billing);

                // fetch user contact data from stripe in DPF Annual plan
                if ($description == 'DPF' || !isset($billing_info->line1) || !$billing_info->line1) {
                    $this->updateUser($subscriptionsPaymentMethod, $user_id, $stripe);
                }

                if (!$subscriptionsPaymentMethod) {
                    try {
                        $subscriptionsPaymentMethod = $chargData->payment_method;
                        $stripe->subscriptions->update(
                            $payment_subscription_id,
                            ['default_payment_method' => $subscriptionsPaymentMethod]
                        );
                    } catch (Exception $e) {
                        echo 'Payment methoed attached error';
                    }
                }

                $paymentMethoed = db()->where('user_id', $user_id)->where('status', 1)->getOne('payment_methods');
                if ($paymentMethoed && $paymentMethoed != $subscriptionsPaymentMethod) {
                    db()->where('user_id', $user_id)->update('payment_methods', [
                        'status' => 0,
                    ]);

                    db()->insert('payment_methods', [
                        'user_id'           => $user_id,
                        'payment_method'    => $subscriptionsPaymentMethod,
                        'card'              => $proof,
                        'status'            => 1,
                        'updated_at'        => (new \DateTime())->format('Y-m-d H:i:s'),
                    ]);
                } else {
                    db()->insert('payment_methods', [
                        'user_id'           => $user_id,
                        'payment_method'    => $subscriptionsPaymentMethod,
                        'card'              => $proof,
                        'status'            => 1,
                        'updated_at'        => (new \DateTime())->format('Y-m-d H:i:s'),
                    ]);
                }


                $previous_plan = null;
                $credit_amount = null;

                $subscriptionMeta = $paymentIntent['subscription_details']['metadata'];

                if ($subscriptionMeta) {
                    $previous_plan = isset($subscriptionMeta->previous_plan) ? $subscriptionMeta->previous_plan : null;
                    $credit_amount = isset($subscriptionMeta->credit_amount) ? $subscriptionMeta->credit_amount : null;
                }

                $price = convert_payment_format($chargData['amount'], $paymentIntent['currency']);

                $taxes_ids = null;
                $metadata = $paymentIntent['lines']['data'][0]['plan']['metadata'];

                $plan_id = (int) $metadata['plan_id'];
                $frequency = $metadata['payment_frequency'];


                $plan = db()->where('plan_id', $plan_id)->getOne('plans');

                if ($paymentIntent['discount']) {
                    $code = $paymentIntent['discount']['coupon']['name'];
                    $discount_amount = convert_payment_format($paymentIntent['total_discount_amounts'][0]['amount'], $paymentIntent['currency']);
                } else {
                    $code = null;
                    $discount_amount = null;
                }

                $base_amount = $paymentIntent['subtotal'] / 100;
                (new Payments())->webhook_process_payment(
                    'stripe',
                    $paymentIntent['payment_intent'],
                    $price,
                    strtoupper($paymentIntent['currency']),
                    $user_id,
                    $plan_id,
                    $frequency,
                    $code,
                    $discount_amount,
                    $base_amount,
                    $paymentIntent['account_tax_ids'],
                    'card',
                    $payment_subscription_id,
                    $payer_email,
                    $payer_name,
                    $paymentIntent['paid'],
                    $proof,
                    $previous_plan,
                    $credit_amount,
                    $description
                );

                // update dpf user plan by date
                $dpfUser = db()->where('user_id', $user_id)->getOne('dpf_user_emails');

                if ($dpfUser) {
                    db()->where('user_id', $user_id)->update('dpf_user_emails', [
                        'payment_date'  => \Altum\Date::$date,
                    ]);
                }


                http_response_code(200);
            }
        } elseif ($event->type == 'payment_intent.succeeded') {
            $paymentIntent = $event->data->object;

            $metadata  =  $paymentIntent['charges']['data'][0]['metadata'];
            $plan_id   = (int) $metadata['plan_id'];

            $frequency = $metadata['payment_frequency'];

            if ($plan_id != 5 && $plan_id != 6 && $plan_id != 7) {
                echo 'This will already be updated by the "invoice.paid" event';
                http_response_code(200);
                exit();
            }

            if (db()->where('payment_id', $paymentIntent['id'])->where('status', 1)->has('payments')) {
                echo 'All ready payment';
                http_response_code(200);
                exit();
            }

            $customer = $stripe->customers->retrieve($paymentIntent['customer']);

            $user_id = (int) $customer['metadata']['user_id'];
            $payer_email = $customer['metadata']['user_email'];
            $payer_name =  $customer['name'];

            $user  = db()->where('email', $payer_email)->getOne('users');
            if (!$user) {
                echo 'User not found';
                http_response_code(400);
                exit();
            }

            $chargData = $stripe->charges->retrieve($paymentIntent['charges']['data'][0]['id']);
            $card = $chargData['payment_method_details']['card']['brand'];
            $last4 = $chargData['payment_method_details']['card']['last4'];
            $proof = $card . ' ****' . $last4;

            $subscriptionsPaymentMethod  = $paymentIntent->payment_method;
            $paymentMethoed = db()->where('user_id', $user_id)->where('status', 1)->getOne('payment_methods');


            $paymentMethoed = db()->where('user_id', $user_id)->where('status', 1)->getOne('payment_methods');
            if ($paymentMethoed && $paymentMethoed != $subscriptionsPaymentMethod) {
                db()->where('user_id', $user_id)->update('payment_methods', [
                    'status' => 0,
                ]);

                db()->insert('payment_methods', [
                    'user_id'           => $user_id,
                    'payment_method'    => $subscriptionsPaymentMethod,
                    'card'              => $proof,
                    'status'            => 1,
                    'updated_at'        => (new \DateTime())->format('Y-m-d H:i:s'),
                ]);
            } else {
                db()->insert('payment_methods', [
                    'user_id'           => $user_id,
                    'payment_method'    => $subscriptionsPaymentMethod,
                    'card'              => $proof,
                    'status'            => 1,
                    'updated_at'        => (new \DateTime())->format('Y-m-d H:i:s'),
                ]);
            }

            if ($plan_id == 6 || $plan_id == 7) {

                // fetch user contact data from stripe   
                $this->updateUser($subscriptionsPaymentMethod, $user_id, $stripe);

                $customerId = $paymentIntent['charges']['data'][0]['customer'];
                $currency = $paymentIntent['charges']['data'][0]['currency'];

                if (!$user->payment_subscription_id) {

                    $stripe->paymentMethods->attach(
                        $subscriptionsPaymentMethod,
                        ['customer' => $customerId]
                    );

                    $subscription = $stripe->subscriptions->create([
                        'customer' => $customerId,
                        'items' => [['price' => STRIPE_PRICE_1_ID]],
                        'trial_end' => strtotime((new \DateTime())->modify('+13 days, +22 hour')->format('Y-m-d H:i:s')),
                        'default_payment_method' => $subscriptionsPaymentMethod,
                        'currency' => $currency,
                    ]);
                } else {
                    echo 'Already subscription created';
                    http_response_code(200);
                    exit();
                }

                $payment_subscription_id = $subscription->id;
            } else {
                $payment_subscription_id = 'onetime';
            }

            $price = convert_payment_format($chargData['amount'], $paymentIntent['currency']);

            $code = null;
            $discount_amount = null;

            $base_amount = $price + $discount_amount;

            (new Payments())->webhook_process_payment(
                'stripe',
                $paymentIntent['id'],
                $price,
                strtoupper($paymentIntent['currency']),
                $user_id,
                $plan_id,
                $frequency,
                $code,
                $discount_amount,
                $base_amount,
                $paymentIntent['account_tax_ids'],
                'card',
                $payment_subscription_id,
                $payer_email,
                $payer_name,
                1,
                $proof,
                null,
                null,
                null
            );

            http_response_code(200);
        } elseif ($event->type == 'invoice.payment_failed') {

            $paymentIntent = $event->data->object;

            $payment_subscription_id = $paymentIntent['subscription'];
            $customer = $stripe->customers->retrieve($paymentIntent['customer']);
            $user_id = (int) $customer['metadata']['user_id'];

            if ($paymentIntent['charge']) {
                $chargData = $stripe->charges->retrieve($paymentIntent['charge']);

                $price = convert_payment_format($chargData['amount'], $paymentIntent['currency']);

                $card = $chargData['payment_method_details']['card']['brand'];
                $last4 = $chargData['payment_method_details']['card']['last4'];
                $proof = $card . ' ****' . $last4;
            } else {

                $price = convert_payment_format($paymentIntent['amount_due'], $paymentIntent['currency']);
                $proof = 'Not Found';
            }


            $payer_email = $paymentIntent['customer_email'];
            $payer_name =  $paymentIntent['customer_name'];

            $metadata = $paymentIntent['lines']['data'][0]['plan']['metadata'];

            $plan_id = (int) $metadata['plan_id'];
            $frequency = $metadata['payment_frequency'];

            $user = db()->where('email', $payer_email)->getOne('users');

            $subscriptionUser = analyticsDatabase()->query("SELECT * FROM `subscription_users` WHERE `user_id` = {$user_id} AND  `subscription_change` != 'cancellation' ORDER BY `id` DESC LIMIT 1")->fetch_object();

            if (db()->where('payment_id', $paymentIntent['payment_intent'])->where('status', 0)->where('processor', 'stripe')->has('payments')) {
                echo 'Already updated in payment table';
                http_response_code(200);
                die();
            } else if (db()->where('payment_id', $paymentIntent['payment_intent'])->where('status', 1)->where('processor', 'stripe')->has('payments')) {
                echo 'Payment sucsses';
                http_response_code(200);
                die();
            } else {
                //Stripe declined the user’s payment
                if ($subscriptionUser) {
                    db()->insert('payment_failed', [
                        'user_id' => $user_id,
                        'email' => $payer_email,
                        'failed_time' => Date::$date,
                        'payment_id' => $paymentIntent['payment_intent'],
                    ]);
                }

                db()->insert('payments', [
                    'user_id' => $user_id,
                    'plan_id' => $plan_id,
                    'processor' => 'stripe',
                    'type' => 'card',
                    'frequency' => $frequency,
                    'code' => null,
                    'discount_amount' => null,
                    'base_amount' => $price,
                    'email' => $payer_email,
                    'payment_id' => $paymentIntent['payment_intent'],
                    'name' => $payer_name,
                    'plan' => json_encode(db()->where('plan_id', $plan_id)->getOne('plans', ['plan_id', 'name'])),
                    'billing' => settings()->payment->taxes_and_billing_is_enabled && $user->billing ? $user->billing : null,
                    'business' => json_encode(settings()->business),
                    'taxes_ids' => null,
                    'total_amount' => $price,
                    'currency' => strtoupper($paymentIntent['currency']),
                    'status' => 0,
                    'datetime' => Date::$date,
                    'payment_proof' => $proof
                ]);

                if ($subscriptionUser && $subscriptionUser->subscription_change != 'delinquent' && $user->payment_subscription_id != '') {

                    analyticsBb()->insert('subscription_users', [
                        'user_id'                 => $user_id,
                        'subscription_change'     => 'delinquent',
                        'change_date'             => Date::$date,
                        'new_plan'                => null,
                        'previous_plan'           => $subscriptionUser->new_plan,
                        'new_plan_amount'         => null,
                        'previous_plan_amount'    => $subscriptionUser->new_plan_amount,
                        'currency'                => strtoupper($paymentIntent['currency'])
                    ]);

                    $userName = get_user_name($user->name);

                    analyticsBb()->insert('conversion_data', [
                        'user_id'             => $user->user_id,
                        'name'                => $user->name,
                        'first_name'          => $userName['first_name'],
                        'last_name'           => $userName['last_name'],
                        'email_id'            => $user->email,
                        'gaid'                => $user->gaid,
                        'country'             => $user->country,
                        'subscription_change' => 'delinquent',
                        'previous_plan'       => $subscriptionUser->new_plan,
                        'previous_plan_amount' => $subscriptionUser->new_plan_amount,
                        'new_plan'            => null,
                        'new_plan_amount'     => null,
                        'currency'            => strtoupper($paymentIntent['currency']),
                        'conversion_name'     => $subscriptionUser->new_plan == 'trial_limited' ||  $subscriptionUser->new_plan == 'trial_full' ? 'Trial Churn' : 'Churn',
                        'transaction_id'      => $user->stripe_customer_id,
                        'onboarding_funnel'   => $user->onboarding_funnel,
                        'create_time'         => \Altum\Date::$date,
                        'signup_date'         => $user->datetime,
                        'address'             => $this->getUserAddress($user),
                    ]);
                }
            }
        } elseif ($event->type == 'customer.subscription.deleted') {

            $paymentIntent           = $event->data->object;

            if ($paymentIntent['cancel_at_period_end']) {
                echo 'One day trial plan cancelled ';
                http_response_code(200);
            } else {

                $payment_subscription_id = $paymentIntent['subscription'];
                $customer                = $stripe->customers->retrieve($paymentIntent['customer']);
                $user_id = (int) $customer['metadata']['user_id'];
                $user = db()->where('user_id', $user_id)->getOne('users');

                if ($paymentIntent['cancellation_details']['comment'] && $paymentIntent['cancellation_details']['comment'] == 'discount_plan') {
                    echo 'Canceld for new discount plan';
                    http_response_code(200);
                } else {

                    if ($user) {
                        /* Database query */
                        db()->where('user_id', $user->user_id)->update('users', ['payment_subscription_id' => NULL, 'subscription_schedule_id' => NULL, 'subscription_cancel_date' => $user->plan_expiration_date]);

                        db()->where('user_id', $user_id)->update('subscriptions', [
                            'end_date'    => Date::$date,
                        ]);

                        if ($user->onboarding_funnel == 4 && ($user->plan_id == 6 ||  $user->plan_id == 7)) {
                            db()->where('user_id', $user->user_id)->update('dpf_user_emails', [
                                'is_trial_cancel' => 1,
                                'cancel_date'     => \Altum\Date::$date,
                            ]);
                        }
                    }

                    $newPlan  = null;
                    if ($paymentIntent['cancellation_details']['comment'] && $paymentIntent['cancellation_details']['comment'] == 'lifetime_plan') {
                        $newPlan = 'Lifetime free';
                    } else {
                        try {
                            /* Send notification to the user */


                            if ($user->email_subscription_type != 2) {
                                $template  = 'subscription-canceled';

                                $isDelenquent = check_delinquent_user($user);

                                if ($isDelenquent) {
                                    $link =  'update-payment-method?referral_key=' . $user->referral_key;
                                } else {
                                    $link = 'plans-and-prices';
                                }
                                trigger_email($user->user_id, $template, $link);
                            }
                        } catch (\Throwable $th) {
                            return false;
                        }
                    }

                    $subscriptionUser = analyticsDatabase()->query("SELECT * FROM `subscription_users` WHERE `user_id` = {$user->user_id} AND  `subscription_change` != 'cancellation' AND  `subscription_change` != 'delinquent' ORDER BY `id` DESC LIMIT 1")->fetch_object();
                    if ($subscriptionUser) {
                        if ($paymentIntent['cancellation_details']['comment'] && ($paymentIntent['cancellation_details']['comment'] == 'refund' || $paymentIntent['cancellation_details']['comment'] == 'dispute')) {
                            //record updated via refund request
                        } else {

                            if ($user->cancel_promo == 0) {
                                db()->where('user_id', $user->user_id)->update('users', [
                                    'cancel_promo' => 4,
                                ]);
                            }
                        }

                        $newPlan  = null;
                        if ($paymentIntent['cancellation_details']['comment'] && $paymentIntent['cancellation_details']['comment'] == 'lifetime_plan') {
                            $newPlan = 'Lifetime free';
                        } else {
                            try {
                                /* Send notification to the user */

                                if ($user->email_subscription_type != 2) {
                                    $template      = 'subscription-canceled';
                                    trigger_email($user->user_id, $template);
                                }
                            } catch (\Throwable $th) {
                                return false;
                            }
                        }

                        $subscriptionUser = analyticsDatabase()->query("SELECT * FROM `subscription_users` WHERE `user_id` = {$user->user_id} AND  `subscription_change` != 'cancellation' AND  `subscription_change` != 'downgrade' AND `subscription_change` != 'upgrade'  AND  `subscription_change` != 'reactivation' AND  `subscription_change` != 'delinquent' ORDER BY `id` DESC LIMIT 1")->fetch_object();
                        if ($subscriptionUser) {
                            if ($paymentIntent['cancellation_details']['comment'] && ($paymentIntent['cancellation_details']['comment'] == 'refund' || $paymentIntent['cancellation_details']['comment'] == 'dispute')) {
                                //record updated via refund request
                            } else {

                                // cancelled user subscription
                                analyticsBb()->insert('subscription_users', [
                                    'user_id'                 => $user->user_id,
                                    'subscription_change'     => 'cancellation',
                                    'change_date'             => Date::$date,
                                    'new_plan'                => $newPlan,
                                    'previous_plan'           => $subscriptionUser->new_plan,
                                    'new_plan_amount'         => NULL,
                                    'previous_plan_amount'    => isset($subscriptionUser->new_plan_amount) ? $subscriptionUser->new_plan_amount : null,
                                    'currency'                => $subscriptionUser->currency,

                                ]);
                                $userName = get_user_name($user->name);
                                analyticsBb()->insert('conversion_data', [
                                    'user_id'             => $user->user_id,
                                    'name'                => $user->name,
                                    'first_name'          => $userName['first_name'],
                                    'last_name'           => $userName['last_name'],
                                    'email_id'            => $user->email,
                                    'gaid'                => $user->gaid,
                                    'country'             => $user->country,
                                    'subscription_change' => 'cancellation',
                                    'previous_plan'       => $subscriptionUser->new_plan,
                                    'previous_plan_amount' => isset($subscriptionUser->new_plan_amount) ? $subscriptionUser->new_plan_amount : null,
                                    'new_plan'            => $newPlan,
                                    'new_plan_amount'     => null,
                                    'currency'            => $subscriptionUser->currency,
                                    'conversion_name'     => $subscriptionUser->new_plan == 'trial_limited' ||  $subscriptionUser->new_plan == 'trial_full' ? 'Trial Churn' : 'Churn',
                                    'transaction_id'      => $user->stripe_customer_id,
                                    'onboarding_funnel'   => $user->onboarding_funnel,
                                    'create_time'         => \Altum\Date::$date,
                                    'signup_date'         => $user->datetime,
                                    'address'             => $this->getUserAddress($user),

                                ]);
                            }
                        }
                    }

                    http_response_code(200);
                }
            }
        } elseif ($event->type == 'charge.refunded') {
            $refund     = $event->data->object;
            if (isset($refund->refunds['data'][0]->metadata['reason']) && $refund->refunds['data'][0]->metadata['reason'] == 'discount_plan') {
                echo 'Discount refund';
                http_response_code(200);
            } else {

                $refundId   = $refund->refunds['data'][0]->id;
                $paymentIntent = $refund->payment_intent;
                $customer   = $stripe->customers->retrieve($refund['customer']);
                $refund_message =  $refund->refunds['data'][0]->metadata['message'];

                $user_id = (int) $customer['metadata']['user_id'];
                $user = db()->where('user_id', $user_id)->getOne('users');

                /* Update the payment */
                db()->where('payment_id', $paymentIntent)->update('payments', ['is_refund' => 1, 'refund_id' => $refundId]);

                $conversionData = analyticsBb()->where('transaction_id', $paymentIntent)->orderBy('id', 'DESC')->getOne('conversion_data');

                if (!$conversionData) {

                    echo 'Payment records not found';
                    http_response_code(200);
                } else {

                    if ($conversionData->subscription_change == 'first_purchase') {
                        $conversion_name = $user->onboarding_funnel == 4 ? 'DPF Refund' : 'CFF Refund';
                    } else if ($conversionData->subscription_change == 'purchase') {
                        $conversion_name = $user->onboarding_funnel == 4 ? 'DPF Renewal Refund' : 'CFF Renewal Refund';
                    }

                    $userName = get_user_name($user->name);

                    if ($refund_message != 'keep_renewal' && $refund_message != 'partial_keep_renewal') {

                        //Update user plan data
                        db()->where('user_id', $user->user_id)->update('users', [
                            'plan_settings' => '',
                            'plan_expiration_date' => \Altum\Date::$date,
                            'subscription_schedule_id' => '',
                            'subscription_cancel_date' => \Altum\Date::$date
                        ]);


                        if ($user->payment_subscription_id && $user->payment_subscription_id != '') {

                            try {
                                $stripe->subscriptions->cancel(
                                    $user->payment_subscription_id,
                                    ['cancellation_details' => ['comment' => 'refund']]
                                );
                            } catch (\Stripe\Exception\InvalidRequestException $e) {
                                echo 'Subscription cancelled failed';
                                http_response_code(400);
                            }

                            // cancelled user subscription
                            analyticsBb()->insert('subscription_users', [
                                'user_id'                 => $user->user_id,
                                'subscription_change'     => 'cancellation',
                                'change_date'             => Date::$date,
                                'new_plan'                => NULL,
                                'previous_plan'           => $conversionData->new_plan,
                                'new_plan_amount'         => NULL,
                                'previous_plan_amount'    => isset($conversionData->new_plan_amount) ? $conversionData->new_plan_amount : null,
                                'currency'                => $conversionData->currency,
                            ]);

                            analyticsBb()->insert('conversion_data', [
                                'user_id'             => $user->user_id,
                                'name'                => $user->name,
                                'first_name'          => $userName['first_name'],
                                'last_name'           => $userName['last_name'],
                                'email_id'            => $user->email,
                                'gaid'                => $user->gaid,
                                'country'             => $user->country,
                                'subscription_change' => 'cancellation',
                                'previous_plan'       => $conversionData->new_plan,
                                'new_plan'            => NULL,
                                'new_plan_amount'     => NULL,
                                'currency'            => $conversionData->currency,
                                'conversion_name'     => $conversionData->new_plan == 'trial_limited' ||  $conversionData->new_plan == 'trial_full' ? 'Trial Churn' : 'Churn',
                                'transaction_id'      => $user->stripe_customer_id,
                                'onboarding_funnel'   => $user->onboarding_funnel,
                                'create_time'         => \Altum\Date::$date,
                                'signup_date'         => $user->datetime,
                                'previous_plan_amount'    => isset($conversionData->new_plan_amount) ? $conversionData->new_plan_amount : null,
                                'address'             => $this->getUserAddress($user),
                            ]);
                        }
                    }
                    // cancelled user subscription with refund
                    analyticsBb()->insert('subscription_users', [
                        'user_id'                 => $user->user_id,
                        'subscription_change'     => 'refund',
                        'change_date'             => Date::$date,
                        'new_plan'                => NULL,
                        'previous_plan'           => $conversionData->new_plan,
                        'new_plan_amount'         => NULL,
                        'previous_plan_amount'    => isset($conversionData->new_plan_amount) ? $conversionData->new_plan_amount : null,
                        'currency'                => $conversionData->currency,

                    ]);


                    analyticsBb()->insert('conversion_data', [
                        'user_id'             => $user->user_id,
                        'name'                => $user->name,
                        'first_name'          => $userName['first_name'],
                        'last_name'           => $userName['last_name'],
                        'email_id'            => $user->email,
                        'gaid'                => $user->gaid,
                        'country'             => $user->country,
                        'subscription_change' => 'refund',
                        'previous_plan'       => $conversionData->new_plan,
                        'new_plan'            => null,
                        'new_plan_amount'     => null,
                        'currency'            => $conversionData->currency,
                        'conversion_name'     => $conversionData->new_plan == 'trial_limited' ||  $conversionData->new_plan == 'trial_full' ? 'Trial Refund' :  $conversion_name,
                        'transaction_id'      => $refundId,
                        'onboarding_funnel'   => $user->onboarding_funnel,
                        'create_time'         => \Altum\Date::$date,
                        'signup_date'         => $user->datetime,
                        'previous_plan_amount'    => isset($conversionData->new_plan_amount) ? $conversionData->new_plan_amount : null,
                        'address'             => $this->getUserAddress($user),
                    ]);

                    /* Update the payment */
                    db()->where('payment_id', $paymentIntent)->update('payments', ['is_refund' => 1, 'refund_id' => $refundId]);
                    http_response_code(200);
                }
            }
        } elseif ($event->type == 'charge.dispute.closed') {

            $dispute     = $event->data->object;
            $disputeId = $dispute['id'];
            try {
                $payment_intent = $stripe->paymentIntents->retrieve($dispute['payment_intent'], []);

                try {
                    $customer   = $stripe->customers->retrieve($payment_intent['customer']);
                } catch (\Stripe\Exception\InvalidRequestException $e) {
                    echo $e->getMessage();
                    http_response_code(400);
                }
            } catch (\Stripe\Exception\InvalidRequestException $e) {
                echo $e->getMessage();
                http_response_code(400);
            }

            $payment = db()->where('payment_id', $dispute['payment_intent'])->getOne('payments');

            if (!$payment->is_refund) {
                $user_id = (int) $customer['metadata']['user_id'];
                $user = db()->where('user_id', $user_id)->getOne('users');

                $conversionData = analyticsBb()->where('transaction_id', $dispute['payment_intent'])->getOne('conversion_data');

                if ($conversionData->subscription_change == 'first_purchase') {
                    $conversion_name = $user->onboarding_funnel == 4 ? 'DPF Refund' : 'CFF Refund';
                } else if ($conversionData->subscription_change == 'purchase') {
                    $conversion_name = $user->onboarding_funnel == 4 ? 'DPF Renewal Refund' : 'CFF Renewal Refund';
                }

                if ($conversionData) {

                    if ($user->payment_subscription_id && $user->payment_subscription_id != '') {

                        try {
                            $stripe->subscriptions->cancel(
                                $user->payment_subscription_id,
                                ['cancellation_details' => ['comment' => 'dispute']]
                            );
                        } catch (\Stripe\Exception\InvalidRequestException $e) {
                            echo 'Subscription cancelled failed';
                            http_response_code(400);
                        }

                        // cancelled user subscription
                        analyticsBb()->insert('subscription_users', [
                            'user_id'                 => $user->user_id,
                            'subscription_change'     => 'cancellation',
                            'change_date'             => Date::$date,
                            'new_plan'                => NULL,
                            'previous_plan'           => $conversionData->new_plan,
                            'new_plan_amount'         => NULL,
                            'previous_plan_amount'    => isset($conversionData->new_plan_amount) ? $conversionData->new_plan_amount : null,
                            'currency'                => $conversionData->currency,
                        ]);

                        $userName = get_user_name($user->name);

                        analyticsBb()->insert('conversion_data', [
                            'user_id'             => $user->user_id,
                            'name'                => $user->name,
                            'first_name'          => $userName['first_name'],
                            'last_name'           => $userName['last_name'],
                            'email_id'            => $user->email,
                            'gaid'                => $user->gaid,
                            'country'             => $user->country,
                            'subscription_change' => 'cancellation',
                            'previous_plan'       => $conversionData->new_plan,
                            'new_plan'            => NULL,
                            'new_plan_amount'     => NULL,
                            'currency'            => $conversionData->currency,
                            'conversion_name'     => $conversionData->new_plan == 'trial_limited' ||  $conversionData->new_plan == 'trial_full' ? 'Trial Churn' : 'Churn',
                            'transaction_id'      => $user->stripe_customer_id,
                            'onboarding_funnel'   => $user->onboarding_funnel,
                            'create_time'         => \Altum\Date::$date,
                            'signup_date'         => $user->datetime,
                            'previous_plan_amount'    => isset($conversionData->new_plan_amount) ? $conversionData->new_plan_amount : null,
                            'address'             => $this->getUserAddress($user),
                        ]);

                        //Update user plan data
                        db()->where('user_id', $user->user_id)->update('users', [
                            'plan_settings' => '',
                            'plan_expiration_date' => \Altum\Date::$date,
                            'subscription_schedule_id' => '',
                            'subscription_cancel_date' => \Altum\Date::$date
                        ]);
                    }

                    analyticsBb()->insert('subscription_users', [
                        'user_id'                 => $user->user_id,
                        'subscription_change'     => 'refund',
                        'change_date'             => Date::$date,
                        'new_plan'                => NULL,
                        'new_plan_amount'         => NULL,
                        'previous_plan'           => $conversionData->new_plan,
                        'previous_plan_amount'    => isset($conversionData->new_plan_amount) ? $conversionData->new_plan_amount : null,
                        'currency'                => $conversionData->currency,

                    ]);
                    $userName = get_user_name($user->name);

                    analyticsBb()->insert('conversion_data', [
                        'user_id'             => $user->user_id,
                        'name'                => $user->name,
                        'first_name'          => $userName['first_name'],
                        'last_name'           => $userName['last_name'],
                        'email_id'            => $user->email,
                        'gaid'                => $user->gaid,
                        'country'             => $user->country,
                        'subscription_change' => 'refund',
                        'previous_plan'       => $conversionData->new_plan,
                        'previous_plan_amount' => isset($conversionData->new_plan_amount) ? $conversionData->new_plan_amount : null,
                        'new_plan'            => null,
                        'new_plan_amount'     => null,
                        'currency'            => $conversionData->currency,
                        'conversion_name'     => $conversionData->new_plan == 'trial_limited' ||  $conversionData->new_plan == 'trial_full' ? 'Trial Refund' :  $conversion_name,
                        'transaction_id'      => $disputeId,
                        'onboarding_funnel'   => $user->onboarding_funnel,
                        'create_time'         => \Altum\Date::$date,
                        'signup_date'         => $user->datetime,
                        'address'             => $this->getUserAddress($user),
                    ]);
                }
                /* Update the payment */
                db()->where('payment_id', $dispute['payment_intent'])->update('payments', ['is_refund' => 1, 'refund_id' => $disputeId]);
            }
            http_response_code(200);
        } else {
            echo 'Received unknown event type ' . $event->type;
            http_response_code(200);
        }
    }

    private function updateUser($paymentMethod, $user_id, $stripe)
    {
        try {
            $paymentMethod  = $stripe->paymentMethods->retrieve($paymentMethod, []);
            if ($paymentMethod) {
                $billing_info = array(
                    "name" => $paymentMethod->billing_details->name ?? '',
                    "email" => $paymentMethod->billing_details->email ?? '',
                    "line1" => isset($paymentMethod->billing_details->address->line1) ? $paymentMethod->billing_details->address->line1 : '',
                    "line2" => isset($paymentMethod->billing_details->address->line2) ? $paymentMethod->billing_details->address->line2 : '',
                    "city" => isset($paymentMethod->billing_details->address->city) ? $paymentMethod->billing_details->address->city : '',
                    "province" => isset($paymentMethod->billing_details->address->province) ? $paymentMethod->billing_details->address->province : '',
                    "state" => isset($paymentMethod->billing_details->address->state) ? $paymentMethod->billing_details->address->state : '',
                    "postal_code" => isset($paymentMethod->billing_details->address->postal_code) ? $paymentMethod->billing_details->address->postal_code : '',
                    "zip" => isset($paymentMethod->billing_details->address->zip) ? $paymentMethod->billing_details->address->zip : '',
                    "country" => $paymentMethod->billing_details->address->country ?? '',
                );

                if ($user_id && ($paymentMethod->billing_details->address->line1 || $paymentMethod->billing_details->name)) {
                    db()->where('user_id', $user_id)->update('users', ['billing' => json_encode($billing_info), 'name' => $paymentMethod->billing_details->name ?? '']);
                }
            }
        } catch (\Exception $e) {
            dil($e->getMessage());
        }
    }

    private function getUserAddress($user)
    {
        $address = null;
        if ($user) {
            $billing_info = json_decode($user->billing);

            if (isset($billing_info->line1) && $billing_info->line1) {
                $address = $billing_info->line1;
                $address = isset($billing_info->line2) && $billing_info->line2 ? $address . ', ' . $billing_info->line2 : $address;
                $address = isset($billing_info->city) && $billing_info->city ? $address . ', ' . $billing_info->city : $address;
                $address = isset($billing_info->state) && $billing_info->state ? $address . ', ' . $billing_info->state : $address;
                $address = isset($billing_info->province) && $billing_info->province ? $address . ', ' . $billing_info->province : $address;
                $address = isset($billing_info->zip) && $billing_info->zip ? $address . ', ' . $billing_info->zip : $address;
                $address = isset($billing_info->postal_code) && $billing_info->postal_code ? $address . ', ' . $billing_info->postal_code : $address;
            }
            return $address;
        } else {

            return $address;
        }
    }
}
