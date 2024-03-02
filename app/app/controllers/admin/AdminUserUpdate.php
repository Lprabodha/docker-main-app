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
use Altum\Date;
use Altum\Middlewares\Authentication;
use Altum\Middlewares\Csrf;
use Altum\Models\Plan;
use Altum\Models\User;

class AdminUserUpdate extends Controller
{

    public function index()
    {

        $user_id = isset($this->params[0]) ? (int) $this->params[0] : null;
        $user = db()->where('user_id', $user_id)->getOne('users');

        /* Check if user exists */
        if (!$user || ($user->type == 1 && $this->user->type == 3)) {
            redirect('admin/users');
        }

        /* Get current plan proper details */
        $user->plan = (new Plan())->get_plan_by_id($user->plan_id);

        $userDiscount =  database()->query("SELECT * FROM `payments` WHERE `user_id` = {$user_id} AND `discount_amount` IS  NOT NULL ORDER BY `id` ASC LIMIT 1")->fetch_object();

        $lastPayment = database()->query("SELECT * FROM `payments` WHERE `user_id` = {$user->user_id} ORDER BY `id` DESC LIMIT 1")->fetch_object();

        $lastPlanName  = null;
        if ($lastPayment) {
            $lastPlanName =  db()->where('plan_id', $lastPayment->plan_id)->getOne('plans')->name;
        }

        /* Check if its a custom plan */
        if ($user->plan->plan_id == 'custom') {
            $user->plan->settings = json_decode($user->plan_settings);
        }

        if (!empty($_POST)) {
            /* Filter some the variables */
            $_POST['name']            = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
            $_POST['status']          = (int) $_POST['status'];
            $_POST['type']            = (int) $_POST['type'];
            $_POST['discount']        = (int) $_POST['discount'];
            $_POST['plan_trial_done'] = (int) $_POST['plan_trial_done'];

            switch ($_POST['plan_id']) {
                case 'free':

                    $plan_settings  = json_encode(settings()->plan_free->settings);
                    $new_plan       = $_POST['new_plan'];

                    break;

                case 'custom':


                    /* Determine the enabled QR codes */
                    $enabled_qr_codes = [];

                    foreach (array_keys((require APP_PATH . 'includes/qr_code.php')['type']) as $key) {
                        $enabled_qr_codes[$key] = (bool) isset($_POST['enabled_qr_codes']) && in_array($key, $_POST['enabled_qr_codes']);
                    }

                    $plan_settings = [
                        'qr_codes_limit'                    => (int) $_POST['qr_codes_limit'],
                        'links_limit'                       => (int) $_POST['links_limit'],
                        'projects_limit'                    => (int) $_POST['projects_limit'],
                        'pixels_limit'                      => (int) $_POST['pixels_limit'],
                        'domains_limit'                     => (int) $_POST['domains_limit'],
                        'teams_limit'                       => (int) $_POST['teams_limit'],
                        'team_members_limit'                => (int) $_POST['team_members_limit'],
                        'statistics_retention'              => (int) $_POST['statistics_retention'],
                        'additional_domains_is_enabled'     => (bool) isset($_POST['additional_domains_is_enabled']),
                        'analytics_is_enabled'              => (bool) isset($_POST['analytics_is_enabled']),
                        'custom_url_is_enabled'             => (bool) isset($_POST['custom_url_is_enabled']),
                        'password_protection_is_enabled'    => (bool) isset($_POST['password_protection_is_enabled']),
                        'sensitive_content_is_enabled'      => (bool) isset($_POST['sensitive_content_is_enabled']),
                        'api_is_enabled'                    => (bool) isset($_POST['api_is_enabled']),
                        'affiliate_commission_percentage'   => (int) $_POST['affiliate_commission_percentage'],
                        'no_ads'                            => (bool) isset($_POST['no_ads']),
                        'qr_reader_is_enabled'              => (bool) isset($_POST['qr_reader_is_enabled']),
                        'enabled_qr_codes'                  => $enabled_qr_codes,
                    ];

                    $plan_settings = json_encode($plan_settings);

                    break;

                default:

                    //New discounted plan in the admin panel

                    $new_discounted_plan = false;
                    $discount            =  $_POST['discount'];
                    $plan_id             =  $_POST['plan_id'];
                    $refund              =  $_POST['refund'];
                    $new_plan            =  $_POST['new_plan'];


                    if (isset($discount) && $discount != 0) {
                        $new_discounted_plan  = true;
                        switch ($discount) {
                            case 30:
                                $couponCode = STRIPE_COUPON_30_FOREVER;
                                $code       = '30OFF_FOREVER';
                                break;
                            case 50:
                                $couponCode = STRIPE_COUPON_50_FOREVER;
                                $code       = '50OFF_FOREVER';
                                break;
                            case 70:
                                $couponCode = STRIPE_COUPON_70_FOREVER;
                                $code       = '70OFF_FOREVER';
                                break;
                            case 90:
                                $couponCode = STRIPE_COUPON_90_FOREVER;
                                $code       = '90OFF_FOREVER';
                                break;
                            default:
                                $couponCode = '';
                        }
                    }


                    if ($new_discounted_plan && $new_plan != 'none') {
                        $this->new_discounted_plan($plan_id, $couponCode,  $user, $discount, $code, $new_plan, $refund, $lastPayment);
                        sleep(5);
                    }


                    /* Make sure this plan exists */
                    if (!$plan_settings = db()->where('plan_id', $_POST['plan_id'])->getValue('plans', 'settings')) {
                        redirect('admin/user-update/' . $user->user_id);
                    }

                    break;
            }

            $_POST['plan_expiration_date'] = (new \DateTime($_POST['plan_expiration_date']))->format('Y-m-d H:i:s');

            //ALTUMCODE:DEMO if(DEMO) Alerts::add_error('This command is blocked on the demo.');

            /* Check for any errors */
            $required_fields = ['email'];
            foreach ($required_fields as $field) {
                if (!isset($_POST[$field]) || (isset($_POST[$field]) && empty($_POST[$field]) && $_POST[$field] != '0')) {
                    Alerts::add_field_error($field, l('global.error_message.empty_field'));
                }
            }

            if (!Csrf::check()) {
                Alerts::add_error(l('global.error_message.invalid_csrf_token'));
            }

            if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) == false) {
                //ALTUMCODE:DEMO if(DEMO) {
                Alerts::add_field_error('email', l('global.error_message.invalid_email'));
                //ALTUMCODE:DEMO }
            }
            if (db()->where('email', $_POST['email'])->has('users') && $_POST['email'] !== $user->email) {
                Alerts::add_field_error('email', l('admin_users.error_message.email_exists'));
            }

            if (!empty($_POST['new_password']) && !empty($_POST['repeat_password'])) {
                if (mb_strlen($_POST['new_password']) < 6 || mb_strlen($_POST['new_password']) > 64) {
                    Alerts::add_field_error('new_password', l('global.error_message.password_length'));
                }
                if ($_POST['new_password'] !== $_POST['repeat_password']) {
                    Alerts::add_field_error('repeat_password', l('global.error_message.passwords_not_matching'));
                }
            }

            /* If there are no errors, continue */
            if (!Alerts::has_field_errors() && !Alerts::has_errors()) {
                /* Update the basic user settings */


                if ($new_discounted_plan && $new_plan != 'none') {
                    db()->where('user_id', $user->user_id)->update('users', [
                        'name' => $_POST['name'],
                        'email' => $_POST['email'],
                        'type' => $_POST['type'],
                        'plan_expiry_reminder' => $user->plan_expiration_date != $_POST['plan_expiration_date'] ? 0 : 1,
                        'plan_settings' => $plan_settings,
                        'plan_trial_done' => $_POST['plan_trial_done'],
                        'email_subscription_type' => $_POST['email_subscription']
                    ]);
                } else if ($new_plan == '8') {

                    $current_plan_status = $user->plan_id;
                    $new_plan_details = db()->where('plan_id', $new_plan)->getOne('plans');

                    $new_plan_expiration_date = (new \DateTime($_POST['plan_expiration_date']))->modify('+500 years')->format('Y-m-d H:i:s');
                    db()->where('user_id', $user->user_id)->update('users', [
                        'name'                  =>  $_POST['name'],
                        'email'                 =>  $_POST['email'],
                        'type'                  =>  $_POST['type'],
                        'plan_id'               =>  $new_plan,
                        'plan_expiration_date'  =>  $new_plan_expiration_date,
                        'plan_expiry_reminder'  =>  $user->plan_expiration_date != $_POST['plan_expiration_date'] ? 0 : 1,
                        'plan_settings'         =>  $plan_settings,
                        'plan_trial_done'       =>  $_POST['plan_trial_done'],
                        'email_subscription_type' => 1
                    ]);

                    if ($user->subscription_schedule_id != null) {
                        try {

                            $stripe = new \Stripe\StripeClient(settings()->stripe->secret_key);

                            $subscriptionSchedule =  $stripe->subscriptionSchedules->retrieve($user->subscription_schedule_id, []);
                            if ($subscriptionSchedule) {
                                $stripe->subscriptionSchedules->cancel(
                                    $user->subscription_schedule_id,
                                    []
                                );
                            }
                        } catch (\Exception $exception) {
                            Alerts::add_error($exception->getCode() . ':' . $exception->getMessage());
                            redirect('admin/user-update/' . $user->user_id);
                        }
                    }

                    if ($current_plan_status != 'free' && $user->payment_subscription_id == null) {

                        $subscriptionUser = analyticsDatabase()->query("SELECT * FROM `subscription_users` WHERE `user_id` = {$user_id} AND  `subscription_change` = 'cancellation' ORDER BY `id` DESC LIMIT 1")->fetch_object();
                        if ($subscriptionUser) {

                            $lastSubscriptionChange =  analyticsDatabase()->query("SELECT * FROM `subscription_users` WHERE `user_id` = {$user_id} ORDER BY `id` DESC LIMIT 1")->fetch_object();

                            if ($lastSubscriptionChange && $lastSubscriptionChange->subscription_change == 'reactivation') {

                                analyticsBb()->insert('subscription_users', [
                                    'user_id'                 => $user->user_id,
                                    'subscription_change'     => 'cancellation',
                                    'change_date'             => Date::$date,
                                    'new_plan'                => $new_plan_details->name,
                                    'previous_plan'           => $lastSubscriptionChange->previous_plan,
                                    'new_plan_amount'         => NULL,
                                    'previous_plan_amount'    => isset($lastSubscriptionChange->previous_plan_amount) ? $lastSubscriptionChange->previous_plan_amount : null,
                                    'currency'                => $lastSubscriptionChange->currency,

                                ]);
                            } else {
                                analyticsBb()->where('id', $subscriptionUser->id)->update('subscription_users', [
                                    'new_plan' =>  $new_plan_details->name,
                                ]);
                            }
                        }

                        $conversionData = analyticsDatabase()->query("SELECT * FROM `conversion_data` WHERE `user_id` = {$user_id} AND  `subscription_change` = 'cancellation' ORDER BY `id` DESC LIMIT 1")->fetch_object();
                        if ($conversionData) {

                            $lastConversionData =  analyticsDatabase()->query("SELECT * FROM `conversion_data` WHERE `user_id` = {$user_id} ORDER BY `id` DESC LIMIT 1")->fetch_object();

                            if ($lastConversionData && $lastConversionData->subscription_change == 'reactivation') {
                                $userName = get_user_name($user->name);
                                analyticsBb()->insert('conversion_data', [
                                    'user_id'             => $user->user_id,
                                    'first_name'          => $userName['first_name'],
                                    'last_name'           => $userName['last_name'],
                                    'email_id'            => $user->email,
                                    'gaid'                => $user->gaid,
                                    'country'             => $user->country,
                                    'subscription_change' => 'cancellation',
                                    'previous_plan'       => $lastConversionData->previous_plan,
                                    'previous_plan_amount' => isset($lastConversionData->previous_plan_amount) ? $lastConversionData->previous_plan_amount : null,
                                    'new_plan'            => $new_plan_details->name,
                                    'new_plan_amount'     => null,
                                    'currency'            => $lastConversionData->currency,
                                    'conversion_name'     => $lastConversionData->previous_plan == 'trial_limited' ||  $lastConversionData->previous_plan == 'trial_full' ? 'Trial Churn' : 'Churn',
                                    'transaction_id'      => $user->stripe_customer_id,
                                    'onboarding_funnel'   => $user->onboarding_funnel,
                                    'create_time'         => \Altum\Date::$date,
                                    'signup_date'         => $user->datetime,

                                ]);
                            } else {

                                analyticsBb()->where('id', $conversionData->id)->update('conversion_data', [
                                    'new_plan'     =>  $new_plan_details->name,
                                ]);
                            }
                        }
                    } else if ($current_plan_status != 'free' && $user->payment_subscription_id != null) {

                        try {

                            $stripe = new \Stripe\StripeClient(settings()->stripe->secret_key);

                            $stripe->subscriptions->cancel(
                                $user->payment_subscription_id,
                                ['cancellation_details' => ['comment' => 'lifetime_plan']]
                            );
                        } catch (\Exception $exception) {
                            Alerts::add_error($exception->getCode() . ':' . $exception->getMessage());
                            redirect('admin/user-update/' . $user->user_id);
                        }
                    }
                } else {
                    db()->where('user_id', $user->user_id)->update('users', [
                        'name' => $_POST['name'],
                        'email' => $_POST['email'],
                        'type' => $_POST['type'],
                        'plan_expiration_date' => $_POST['plan_expiration_date'],
                        'plan_expiry_reminder' => $user->plan_expiration_date != $_POST['plan_expiration_date'] ? 0 : 1,
                        'plan_settings' => $plan_settings,
                        'plan_trial_done' => $_POST['plan_trial_done'],
                        'email_subscription_type' => $_POST['email_subscription']
                    ]);
                }



                /* Update the password if set */
                if (!empty($_POST['new_password']) && !empty($_POST['repeat_password'])) {
                    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

                    /* Database query */
                    db()->where('user_id', $user->user_id)->update('users', ['password' => $new_password]);
                }

                /* Set a nice success message */
                Alerts::add_success(sprintf(l('global.success_message.update1'), '<strong>' . e($_POST['name']) . '</strong>'));

                /* Clear the cache */
                \Altum\Cache::$adapter->deleteItemsByTag('user_id=' . $user->user_id);

                redirect('admin/user-update/' . $user->user_id);
            }
        }

        /* Get all the plans available */
        $plans = db()->where('status', 0, '<>')->get('plans');

        /* Main View */
        $data = [
            'user'               => $user,
            'plans'              => $plans,
            'user_discount'      => $userDiscount,
            'last_payment'       => $lastPayment,
            'last_plan_name'     => $lastPlanName

        ];

        $view = new \Altum\Views\View('admin/user-update/index', (array) $this);

        $this->add_view_content('content', $view->run($data));
    }


    // new discounted plan
    public function new_discounted_plan($plan_id, $couponCode, $user, $discount, $code, $new_plan, $refund, $lastPayment)
    {
        // discount without plan value
        $newPlan  =  db()->where('plan_id', $new_plan)->getOne('plans');
        $plan     = json_decode(json_encode($newPlan), true);

        switch ($new_plan) {
            case 1:
                $multiple = 1;
                break;
            case 2:
                $multiple = 12;
                break;
            case 3:
                $multiple = 3;
                break;
            default:
                $multiple = 1;
                break;
        }

        if (get_user_currency($lastPayment->currency)) {
            $newPlanValue = $plan[strtolower($lastPayment->currency)] * $multiple;
        } else {
            $newPlanValue = $plan['monthly_price'] * $multiple;
        }

        // discount with plan value
        $new_plan_amount  = round($newPlanValue - ($newPlanValue / 100 * $discount), 2);
        $discount_amount  = round($newPlanValue / 100 * $discount, 2);
        $plan_end_date    = (new \DateTime($user->plan_expiration_date))->format('Y-m-d');
        $payment          = database()->query("SELECT * FROM `payments` WHERE `user_id` = {$user->user_id} ORDER BY `id` DESC LIMIT 1")->fetch_object();


        $refund_amount    = number_format($user->payment_total_amount - $new_plan_amount, 2, '.', '') * 100;
        if ($refund_amount < 0) {
            $refund_amount = null;
        }



        $subscriptions_susses    = false;
        $refund_susses           = false;
        $new_subcription         = false;
        $stripe                  = new \Stripe\StripeClient(settings()->stripe->secret_key);

        switch ($new_plan) {
            case 1:
                $priceId = STRIPE_PRICE_1_ID;
                break;
            case 2:
                $priceId = STRIPE_PRICE_12_ID;
                break;
            case 3:
                $priceId = STRIPE_PRICE_3_ID;
                break;
            default:
                $priceId = STRIPE_PRICE_1_ID;
        }


        // update new subscription with discount
        if ($plan_id != $new_plan) {
            if ($refund && $refund_amount) {
                try {
                    $subscription = $stripe->subscriptions->retrieve($user->payment_subscription_id);
                    $stripe->subscriptions->cancel(
                        $user->payment_subscription_id,
                        ['cancellation_details' => ['comment' => 'discount_plan']]
                    );

                    $blance = $user->payment_total_amount * 100 - $refund_amount;


                    $stripe->customers->createBalanceTransaction(
                        $user->stripe_customer_id,
                        [
                            'amount' => -$blance,
                            'currency' => $user->payment_currency,
                        ]
                    );

                    $paymentMethoed = db()->where('user_id', $user->user_id)->where('status', 1)->getOne('payment_methods');
                    $stripe->subscriptions->create([
                        'customer' => $user->stripe_customer_id,
                        'backdate_start_date' => $subscription->current_period_start,
                        'items' => [['price' => $priceId]],
                        'coupon'     => $couponCode,
                        'currency' => $user->payment_currency,
                        ['default_payment_method' => $paymentMethoed->payment_method],
                        'metadata' => [
                            'previous_plan' => $plan_id,
                            'credit_amount' => $user->payment_total_amount
                        ]
                    ]);

                    $subscriptions_susses = true;
                    $refund_susses        = true;
                    Alerts::add_success('Stripe updated successfully');
                } catch (\Exception $e) {
                    Alerts::add_error('Stripe was not successfully updated.');
                }

                try {

                    $refund  = $stripe->refunds->create([
                        'payment_intent' => $payment->payment_id,
                        'amount' => $refund_amount,
                        'metadata' => [
                            'reason' => 'discount_plan'
                        ]
                    ]);
                    $refundId = $refund['id'];

                    db()->where('id', $payment->id)
                        ->update('payments', [
                            'is_discount_refund' => 1,
                            'refund_id' => $refundId,
                        ]);

                    Alerts::add_success('Customer refunded successfully.');
                } catch (\Exception $e) {
                    Alerts::add_error('Customer was not refunded successfully.');
                }
            } else if ($refund) {
                try {
                    $subscription = $stripe->subscriptions->retrieve($user->payment_subscription_id);
                    $stripe->subscriptions->cancel(
                        $user->payment_subscription_id,
                        ['cancellation_details' => ['comment' => 'discount_plan']]
                    );

                    $blance = $user->payment_total_amount * 100;

                    $stripe->customers->createBalanceTransaction(
                        $user->stripe_customer_id,
                        [
                            'amount' => -$blance,
                            'currency' => $user->payment_currency,
                        ]
                    );

                    $paymentMethoed = db()->where('user_id', $user->user_id)->where('status', 1)->getOne('payment_methods');
                    $stripe->subscriptions->create([
                        'customer' => $user->stripe_customer_id,
                        'backdate_start_date' => $subscription->current_period_start,
                        'items' => [['price' => $priceId]],
                        'coupon'     => $couponCode,
                        'currency' => $user->payment_currency,
                        ['default_payment_method' => $paymentMethoed->payment_method],
                        'metadata' => [
                            'previous_plan' => $plan_id,
                            'credit_amount' => $user->payment_total_amount
                        ]
                    ]);
                    Alerts::add_success('Stripe updated successfully');
                    Alerts::add_success('Database updated successfully'); // Payment records update by webhooks 

                } catch (\Exception $e) {
                    Alerts::add_error('Stripe was not successfully updated.');
                }
            } else {
                try {
                    $subscription = $stripe->subscriptions->retrieve($user->payment_subscription_id);
                    $currentPriceId = $subscription->plan->id;
                    $startDate = $subscription->current_period_start;
                    $subscriptionSchedule = $stripe->subscriptionSchedules->create(['from_subscription' => $user->payment_subscription_id]);
                    $subscriptionSchedule = $stripe->subscriptionSchedules->update(
                        $subscriptionSchedule->id,
                        [
                            'phases' => [
                                [
                                    'items' => [
                                        [
                                            'price'    => $currentPriceId,
                                            'quantity' => 1,
                                        ],
                                    ],
                                    'start_date' => $startDate,
                                    'iterations' => 1,
                                ],
                                [
                                    'items' => [
                                        [
                                            'price'    => $priceId,
                                            'quantity' => 1,
                                        ],
                                    ],
                                    'coupon'   => $couponCode,
                                ],
                            ],

                        ]
                    );
                    $new_subcription      = true;
                    Alerts::add_success('Stripe updated successfully');
                } catch (\Exception $e) {
                    Alerts::add_error('Stripe was not successfully updated.');
                }
            }
        } else {

            if ($refund && $refund_amount) {
                try {
                    $subscription = $stripe->subscriptions->retrieve($user->payment_subscription_id);
                    $stripe->subscriptions->cancel(
                        $user->payment_subscription_id,
                        ['cancellation_details' => ['comment' => 'discount_plan']]
                    );

                    $blance = $user->payment_total_amount * 100 - $refund_amount;

                    $stripe->customers->createBalanceTransaction(
                        $user->stripe_customer_id,
                        [
                            'amount' => -$blance,
                            'currency' => $user->payment_currency,
                        ]
                    );

                    $paymentMethoed = db()->where('user_id', $user->user_id)->where('status', 1)->getOne('payment_methods');
                    $stripe->subscriptions->create([
                        'customer' => $user->stripe_customer_id,
                        'backdate_start_date' => $subscription->current_period_start,
                        'items' => [['price' => $priceId]],
                        'coupon'     => $couponCode,
                        'currency' => $user->payment_currency,
                        ['default_payment_method' => $paymentMethoed->payment_method],
                        'metadata' => [
                            'previous_plan' => $plan_id,
                            'credit_amount' => $user->payment_total_amount
                        ]
                    ]);

                    $subscriptions_susses = true;
                    $refund_susses        = true;
                    Alerts::add_success('Stripe updated successfully');
                } catch (\Exception $e) {
                    Alerts::add_error('Stripe was not successfully updated.');
                }

                try {

                    $refund  = $stripe->refunds->create([
                        'payment_intent' => $payment->payment_id,
                        'amount' => $refund_amount,
                        'metadata' => [
                            'reason' => 'discount_plan'
                        ]
                    ]);
                    $refundId = $refund['id'];

                    db()->where('id', $payment->id)
                        ->update('payments', [
                            'is_discount_refund' => 1,
                            'refund_id' => $refundId,
                        ]);

                    Alerts::add_success('Customer refunded successfully.');
                } catch (\Exception $e) {
                    Alerts::add_error('Customer was not refunded successfully.');
                }
            } else {
                // update current subscription with discount
                try {

                    $stripe->subscriptions->update(
                        $user->payment_subscription_id,
                        [
                            'coupon' => $couponCode,
                        ]
                    );

                    if ($refund) {
                        $refund_susses =  true;
                    }

                    $subscriptions_susses = true;
                    Alerts::add_success('Stripe updated successfully.');
                } catch (\Exception $e) {
                    Alerts::add_error('Stripe was not successfully updated.');
                }
            }
        }

        if ($subscriptions_susses && $refund_susses) {
            switch ($new_plan) {
                case '1':
                    $planExpireDate = $user->plan_expiration_date;
                    break;
                case '2':
                    $planExpireDate  = (new \DateTime($user->plan_expiration_date))->modify('+11 months')->format('Y-m-d H:i:s');
                    break;
                case '3':
                    $planExpireDate  = (new \DateTime($user->plan_expiration_date))->modify('+2 months')->format('Y-m-d H:i:s');
                    break;
            }

            db()->where('user_id', $user->user_id)->update('users', [
                'plan_expiration_date' => $planExpireDate
            ]);

            db()->where('subscription_id', $user->payment_subscription_id)->update('subscriptions', [
                'end_date' => $planExpireDate,
                'plan_id'  => $new_plan,
            ]);

            switch ($new_plan) {
                case '1':
                    $planName = 'Monthly - Discount ' . $discount;
                    break;
                case '2':
                    $planName = 'Annually - Discount ' . $discount;
                    break;
                case '3':
                    $planName = 'Quarterly - Discount ' . $discount;
                    break;
                case '4':
                    $planName = 'Discounted - Discount ' . $discount;
                    break;
            }

            /* Update the payment */
            db()->where('id', $payment->id)->update('payments', ['discount_amount' => $discount_amount, 'code' => $code, 'new_plan_id' => $new_plan]);
            db()->where('user_id', $user->user_id)->update('users', ['payment_total_amount' => $new_plan_amount, 'plan_id' => $new_plan]);

            // update subscription users table 
            $subscriptionUser  = analyticsDatabase()->query("SELECT * FROM `subscription_users` WHERE `user_id` = {$user->user_id} ORDER BY `id` DESC LIMIT 1")->fetch_object();

            if ($subscriptionUser) {
                analyticsBb()->insert('subscription_users', [
                    'user_id'                 => $user->user_id,
                    'subscription_change'     => 'purchase',
                    'change_date'             => Date::$date,
                    'new_plan'                => $planName,
                    'previous_plan'           => $subscriptionUser->new_plan,
                    'new_plan_amount'         => $new_plan_amount,
                    'previous_plan_amount'    => $subscriptionUser->new_plan_amount,
                    'currency'                => $subscriptionUser->currency,
                ]);
            }
            Alerts::add_success('Database updated successfully.');
        }

        if ($new_subcription) {
            try {
                db()->where('subscription_id', $user->payment_subscription_id)->update('subscriptions', [
                    'end_date' => $user->plan_expiration_date,
                ]);

                db()->insert('subscriptions', [
                    'user_id'         => $user->user_id,
                    'plan_id'         => $new_plan,
                    'subscription_id' => $user->payment_subscription_id,
                    'start_date'      => $user->plan_expiration_date,
                ]);

                db()->where('id', $payment->id)->update('payments', ['new_plan_id' => $new_plan, 'code' => $code]);
                Alerts::add_success('Database updated successfully.');
            } catch (\Throwable $th) {
                Alerts::add_success('The database was not successfully updated.');
            }
        }
    }
}
