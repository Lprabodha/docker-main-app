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
use Altum\Models\Payments;
use DateInterval;
use DateTime;

class AdminPayments extends Controller
{

    public function index()
    {

        $payment_processors = require APP_PATH . 'includes/payment_processors.php';

        /* Prepare the filtering system */
        $filters = (new \Altum\Filters(['status', 'plan_id', 'user_id', 'type', 'processor', 'frequency'], ['payment_id', 'is_refund', 'refund_id'], ['total_amount', 'email', 'datetime', 'name']));
        $filters->set_default_order_by('id', 'DESC');
        $filters->set_default_results_per_page(settings()->main->default_results_per_page);

        /* Prepare the paginator */
        $total_rows = database()->query("SELECT COUNT(*) AS `total` FROM `payments` WHERE 1 = 1 {$filters->get_sql_where()}")->fetch_object()->total ?? 0;
        $paginator = (new \Altum\Paginator($total_rows, $filters->get_results_per_page(), $_GET['page'] ?? 1, url('admin/payments?' . $filters->get_get() . '&page=%d')));

        /* Get the data */
        $payments = [];
        $payments_result = database()->query("
            SELECT
                `payments`.*, `users`.`name` AS `user_name`, `users`.`email` AS `user_email`,`users`.`payment_currency` AS `payment_currency`
            FROM
                `payments`
            
            LEFT JOIN
                `users` ON `payments`.`user_id` = `users`.`user_id`
            WHERE
                1 = 1
                {$filters->get_sql_where('payments')}
                {$filters->get_sql_order_by('payments')}
           

            {$paginator->get_sql_limit()}
        ");
        while ($row = $payments_result->fetch_object()) {
            $row->plan = json_decode($row->plan);
            $payments[] = $row;
        }       

        $upcomingPayments = $this->getUpcomingPayments();

        /* Export handler */
        process_export_json($payments, 'include', ['id', 'user_id', 'plan_id', 'payment_id', 'email', 'name', 'processor', 'type', 'frequency', 'billing', 'taxes_ids', 'base_amount', 'code', 'discount_amount', 'total_amount', 'currency', 'status', 'datetime']);
        process_export_csv($payments, 'include', ['id', 'user_id', 'plan_id', 'payment_id', 'email', 'name', 'processor', 'type', 'frequency', 'base_amount', 'code', 'discount_amount', 'total_amount', 'currency', 'status', 'datetime']);

        /* Requested plan details */
        $plans = [];
        $plans_result = database()->query("SELECT `plan_id`, `name` FROM `plans`");
        while ($row = $plans_result->fetch_object()) {
            $plans[$row->plan_id] = $row;
        }

        /* Prepare the pagination view */
        $pagination = (new \Altum\Views\View('partials/pagination', (array) $this))->run(['paginator' => $paginator]);

        /* Main View */
        $data = [
            'payments' => $payments,
            'plans' => $plans,
            'pagination' => $pagination,
            'filters' => $filters,
            'payment_processors' => $payment_processors,
            'upcomingPayments' => $upcomingPayments,
        ];

        $view = new \Altum\Views\View('admin/payments/index', (array) $this);

        $this->add_view_content('content', $view->run($data));
    }

    public function getUpcomingPayments()
    {
        $upcomingUsers = $this->processUpcomingPayments();

        $upcomingPayments   = [];

        foreach ($upcomingUsers[0] as $user) {
            $user = (object) $user;
            $isDelenquent = check_delinquent_user($user);
            $subscriptionUser = analyticsDatabase()->query("SELECT * FROM `subscription_users` WHERE `user_id` = $user->user_id  ORDER BY `id` DESC LIMIT 1")->fetch_object();
            $billingDate = null;

            $query = "SELECT * FROM `payments` WHERE `user_id` = $user->user_id ORDER BY `id` DESC LIMIT 1";
            $userPayment  = db()->query($query);
            $subscription = database()->query("SELECT * FROM `subscriptions` WHERE `user_id` = {$user->user_id} ORDER BY `id` DESC LIMIT 1")->fetch_object();


            if (isset($subscriptionUser->subscription_change) && $subscriptionUser->subscription_change == "refund") {
                $planExpireDate = new DateTime($user->plan_expiration_date);

                switch ($subscription->plan_id) {
                    case 1:
                        $planExpireDate->add(new DateInterval('P30D'));
                        $billingDate = $planExpireDate->format('Y-m-d H:i:s');
                        break;
                    case 2:
                        $planExpireDate->add(new DateInterval('P1Y'));
                        $billingDate = $planExpireDate->format('Y-m-d H:i:s');
                        break;
                    case 3:
                        $planExpireDate->add(new DateInterval('P3M'));
                        $billingDate = $planExpireDate->format('Y-m-d H:i:s');
                        break;
                    case 4:
                        $planExpireDate->add(new DateInterval('P30D'));
                        $billingDate = $planExpireDate->format('Y-m-d H:i:s');
                        break;
                    default:
                        $planExpireDate->add(new DateInterval('P30D'));
                        $billingDate = $planExpireDate->format('Y-m-d H:i:s');
                        break;
                }
            }

            $plan = (new \Altum\Models\Plan())->get_plan_by_id($subscription->plan_id);


            if ($subscriptionUser && $subscriptionUser->new_plan != 'OneTime' && $user->plan_id != 5) {
                $subscriptionId = $user->payment_subscription_id ?? $user->subscription_schedule_id; 
                if ($user->payment_subscription_id == null) {
                    $upcomingPayments[] = [
                        'customer_id' => $user->stripe_customer_id ?? null,
                        'user_id' => $user->user_id ?? null,
                        'email' => $user->email ?? null,
                        'name' => $user->name ?? null,
                        'currency' => $subscriptionUser->currency ?? null,
                        'payment_proof' => $userPayment[0]->payment_proof,
                        'billing_period' => $billingDate != null ? $billingDate : $user->plan_expiration_date,
                        'discount' => $userPayment[0]->code ?? null,
                        'billing_amount' =>  $subscriptionUser->previous_plan_amount,
                        'payment_frequency' => $subscriptionUser->previous_plan ?? $plan->name,
                        'subscription_id' => $subscriptionId ?? null,
                        'plan_id' => $user->plan_id ?? null,
                        'status' => ($isDelenquent || $user->subscription_schedule_id) ? 'upcoming' : 'canceled'
                    ];
                } else {
                    $upcomingPayments[] = [
                        'customer_id' => $user->stripe_customer_id ?? null,
                        'user_id' => $user->user_id ?? null,
                        'email' => $user->email ?? null,
                        'name' => $user->name ?? null,
                        'currency' => $subscriptionUser->currency ?? null,
                        'payment_proof' => $userPayment[0]->payment_proof,
                        'billing_period' => $user->plan_expiration_date,
                        'discount' => $userPayment[0]->code ?? null,
                        'billing_amount' =>  $subscriptionUser->new_plan_amount ?? $subscriptionUser->previous_plan_amount,
                        'payment_frequency' => $subscriptionUser->new_plan ?? $plan->name,
                        'subscription_id' => $subscriptionId ?? null,
                        'plan_id' => $subscription->plan_id ?? null,
                        'status' => $subscriptionUser->subscription_change == 'cancellation' ? 'canceled' : 'upcoming'
                    ];
                }
            }
        }

        return $upcomingPayments;
    }


    public function delete()
    {

        $payment_id = isset($this->params[0]) ? (int) $this->params[0] : null;

        //ALTUMCODE:DEMO if(DEMO) Alerts::add_error('This command is blocked on the demo.');

        if (!Csrf::check('global_token')) {
            Alerts::add_error(l('global.error_message.invalid_csrf_token'));
            redirect('admin/users');
        }

        if (!Alerts::has_field_errors() && !Alerts::has_errors()) {

            $payment = db()->where('id', $payment_id)->getOne('payments', ['payment_proof']);

            /* Delete the saved proof, if any */
            \Altum\Uploads::delete_uploaded_file($payment->payment_proof, 'offline_payment_proofs');

            /* Delete the payment */
            db()->where('id', $payment_id)->delete('payments');

            /* Set a nice success message */
            Alerts::add_success(l('global.success_message.delete2'));
        }

        redirect('admin/payments');
    }

    public function refund()
    {

        $payment_id = (isset($this->params[0])) ? (int) $this->params[0] : null;
        if (!Csrf::check('global_token')) {
            Alerts::add_error(l('global.error_message.invalid_csrf_token'));
            redirect('admin/payments');
        }

        if (!Alerts::has_field_errors() && !Alerts::has_errors()) {

            /* details about the payment */
            $payment = db()->where('id', $payment_id)->getOne('payments');

            /* details about the user who paid */
            $user = db()->where('user_id', $payment->user_id)->getOne('users');

            $stripe = new \Stripe\StripeClient(settings()->stripe->secret_key);

            try {
                $PaymentIntent  = $stripe->paymentIntents->retrieve(
                    $payment->payment_id,
                    []
                );
                $latestChargeId = $PaymentIntent['latest_charge'];
                try {
                    $refund = $stripe->refunds->create([
                        'charge' => $latestChargeId,
                    ]);
                    $refundId = $refund['id'];
                } catch (\Stripe\Exception\InvalidRequestException $e) {
                    Alerts::add_error('An invalid request occurred');
                    redirect('admin/payments');
                }
            } catch (\Stripe\Exception\InvalidRequestException $e) {
                Alerts::add_error('An invalid request occurred');
                redirect('admin/payments');
            }

            sleep(2);

            /* Clear the cache */
            \Altum\Cache::$adapter->deleteItemsByTag('user_id=' . $user->user_id);
            Alerts::add_success('The refund was successfully made.');
        }

        redirect('admin/payments');
    }

    public function approve()
    {

        $payment_id = (isset($this->params[0])) ? (int) $this->params[0] : null;

        //ALTUMCODE:DEMO if(DEMO) Alerts::add_error('This command is blocked on the demo.');

        if (!Csrf::check('global_token')) {
            Alerts::add_error(l('global.error_message.invalid_csrf_token'));
            redirect('admin/users');
        }

        if (!Alerts::has_field_errors() && !Alerts::has_errors()) {

            /* details about the payment */
            $payment = db()->where('id', $payment_id)->getOne('payments');

            /* details about the user who paid */
            $user = db()->where('user_id', $payment->user_id)->getOne('users');

            /* plan that the user has paid for */
            $plan = (new \Altum\Models\Plan())->get_plan_by_id($payment->plan_id);

            /* Make sure the code that was potentially used exists */
            $codes_code = db()->where('code', $payment->code)->where('type', 'discount')->getOne('codes');

            if ($codes_code) {
                /* Check if we should insert the usage of the code or not */
                if (!db()->where('user_id', $payment->user_id)->where('code_id', $codes_code->code_id)->has('redeemed_codes')) {

                    /* Update the code usage */
                    db()->where('code_id', $codes_code->code_id)->update('codes', ['redeemed' => db()->inc()]);

                    /* Add log for the redeemed code */
                    db()->insert('redeemed_codes', [
                        'code_id'   => $codes_code->code_id,
                        'user_id'   => $user->user_id,
                        'datetime'  => \Altum\Date::$date
                    ]);
                }
            }

            /* Give the plan to the user */
            $current_plan_expiration_date = $payment->plan_id == $user->plan_id ? $user->plan_expiration_date : '';
            switch ($payment->frequency) {
                case 'monthly':
                    $plan_expiration_date = (new \DateTime($current_plan_expiration_date))->modify('+30 days')->format('Y-m-d H:i:s');
                    break;

                case 'annual':
                    $plan_expiration_date = (new \DateTime($current_plan_expiration_date))->modify('+12 months')->format('Y-m-d H:i:s');
                    break;

                case 'lifetime':
                    $plan_expiration_date = (new \DateTime($current_plan_expiration_date))->modify('+100 years')->format('Y-m-d H:i:s');
                    break;
            }

            /* Database query */
            db()->where('user_id', $user->user_id)->update('users', [
                'plan_id' => $payment->plan_id,
                'plan_settings' => json_encode($plan->settings),
                'plan_expiration_date' => $plan_expiration_date,
                'plan_expiry_reminder' => 0,
                'payment_processor' => 'offline_payment',
                'payment_total_amount' => $payment->total_amount,
                'payment_currency' => $payment->currency,
            ]);

            /* Clear the cache */
            \Altum\Cache::$adapter->deleteItemsByTag('user_id=' . $user->user_id);

            /* Send notification to the user */
            $email_template = get_email_template(
                [],
                l('global.emails.user_payment.subject'),
                [
                    '{{NAME}}' => $user->name,
                    '{{PLAN_EXPIRATION_DATE}}' => Date::get($plan_expiration_date, 2),
                    '{{USER_PLAN_LINK}}' => url('account-plan'),
                    '{{USER_PAYMENTS_LINK}}' => url('account-payments'),
                ],
                l('global.emails.user_payment.body')
            );

            send_mail($user->email, $email_template->subject, $email_template->body, ['anti_phishing_code' => $user->anti_phishing_code, 'language' => $user->language]);

            /* Send webhook notification if needed */
            if (settings()->webhooks->payment_new) {

                \Unirest\Request::post(settings()->webhooks->payment_new, [], [
                    'user_id' => $user->user_id,
                    'email' => $user->email,
                    'name' => $user->name,
                    'plan_id' => $plan->plan_id,
                    'payment_id' => $payment_id,
                    'payment_processor' => $payment->processor,
                    'payment_type' => $payment->type,
                    'payment_frequency' => $payment->frequency,
                    'payment_total_amount' => $payment->total_amount,
                    'payment_currency' => $payment->currency,
                    'payment_code' => $payment->code,
                ]);
            }

            /* Update the payment */
            db()->where('id', $payment_id)->update('payments', ['status' => 1]);

            /* Affiliate */
            (new Payments())->affiliate_payment_check($payment_id, $payment->total_amount, $user);

            /* Set a nice success message */
            Alerts::add_success(l('admin_payment_approve_modal.success_message'));
        }

        redirect('admin/payments');
    }

    public function upcoming()
    {
        /* Prepare the filtering system */
        $filters = (new \Altum\Filters(['id', 'user_id', 'email'], ['id', 'user_id', 'email'], ['id', 'user_id', 'email']));
        $filters->set_default_order_by('id', 'DESC');
        $filters->set_default_results_per_page(settings()->main->default_results_per_page);

        $upcomingPayments = $this->getUpcomingPayments();
        $fetchedData = $this->processUpcomingPayments();

        $plans = [];
        $plans_result = database()->query("SELECT `plan_id`, `name` FROM `plans`");
        while ($row = $plans_result->fetch_object()) {
            $plans[$row->plan_id] = $row;
        }

        /* Main View */
        $data = [
            'upcomingPayments' => $upcomingPayments,
            'pagination' => $fetchedData[1],
            'filters' => $filters,
            'plans' => $plans,
        ];

        $view = new \Altum\Views\View('admin/payments/upcoming_payments', (array) $this);

        $this->add_view_content('content', $view->run($data));
    }

    public function all()
    {

        $payment_processors = require APP_PATH . 'includes/payment_processors.php';

        /* Prepare the filtering system */
        $filters = (new \Altum\Filters(['status', 'plan_id', 'user_id', 'type', 'processor', 'frequency'], ['payment_id', 'is_refund', 'refund_id'], ['total_amount', 'email', 'datetime', 'name']));
        $filters->set_default_order_by('id', 'DESC');
        $filters->set_default_results_per_page(settings()->main->default_results_per_page);

        /* Prepare the paginator */
        $total_rows = database()->query("SELECT COUNT(*) AS `total` FROM `payments` WHERE 1 = 1 {$filters->get_sql_where()}")->fetch_object()->total ?? 0;
        $paginator = (new \Altum\Paginator($total_rows, $filters->get_results_per_page(), $_GET['page'] ?? 1, url('admin/payments/all?' . $filters->get_get() . '&page=%d')));

        /* Get the data */
        $payments = [];
        $payments_result = database()->query("
            SELECT
                `payments`.*, `users`.`name` AS `user_name`, `users`.`email` AS `user_email`
            FROM
                `payments`
            
            LEFT JOIN
                `users` ON `payments`.`user_id` = `users`.`user_id`
            WHERE
                1 = 1
                {$filters->get_sql_where('payments')}
                {$filters->get_sql_order_by('payments')}
           

            {$paginator->get_sql_limit()}
        ");
        while ($row = $payments_result->fetch_object()) {
            $row->plan = json_decode($row->plan);
            $payments[] = $row;
        }

        /* Export handler */
        process_export_json($payments, 'include', ['id', 'user_id', 'plan_id', 'payment_id', 'email', 'name', 'processor', 'type', 'frequency', 'billing', 'taxes_ids', 'base_amount', 'code', 'discount_amount', 'total_amount', 'currency', 'status', 'datetime']);
        process_export_csv($payments, 'include', ['id', 'user_id', 'plan_id', 'payment_id', 'email', 'name', 'processor', 'type', 'frequency', 'base_amount', 'code', 'discount_amount', 'total_amount', 'currency', 'status', 'datetime']);

        /* Requested plan details */
        $plans = [];
        $plans_result = database()->query("SELECT `plan_id`, `name` FROM `plans`");
        while ($row = $plans_result->fetch_object()) {
            $plans[$row->plan_id] = $row;
        }

        /* Prepare the pagination view */
        $pagination = (new \Altum\Views\View('partials/pagination', (array) $this))->run(['paginator' => $paginator]);

        /* Main View */
        $data = [
            'payments' => $payments,
            'plans' => $plans,
            'pagination' => $pagination,
            'filters' => $filters,
            'payment_processors' => $payment_processors,
        ];


        $view = new \Altum\Views\View('admin/payments/payment_history', (array) $this);

        $this->add_view_content('content', $view->run($data));
    }

    private function processUpcomingPayments()
    {
        $filters = (new \Altum\Filters(['status', 'plan_id', 'user_id', 'type', 'processor', 'frequency'], ['payment_id', 'is_refund', 'refund_id'], ['total_amount', 'email', 'datetime', 'name']));
        $filters->set_default_order_by('id', 'DESC');
        $filters->set_default_results_per_page(settings()->main->default_results_per_page);

        $upcomingUserPayments = [];
        $subscriptionUsers = [];
        $subscriptionUser = null;
        $sqlQueryWithLimit = null;

        if (isset($_GET['user_id']) && $_GET['user_id'] != null) {

            if (filter_var($_GET['user_id'], FILTER_VALIDATE_EMAIL)) {
                redirect('admin/payments');
            }

            try {
                $user = db()->where('user_id', $_GET['user_id'])->getOne('users');
                if ($user) {
                    $subscriptionUser = analyticsDatabase()->query("SELECT * FROM `subscription_users` WHERE `user_id` = {$_GET['user_id']} AND (`subscription_change` = 'first_purchase' OR `subscription_change` = 'purchase' OR `subscription_change` = 'trial_purchase') 
                    AND  (`new_plan` != 'OneTime' OR `new_plan` IS NULL) ORDER BY `id` DESC LIMIT 1")->fetch_object();
                }
            } catch (\Exception $e) {
                dil($e->getMessage());
            }
        } else {
            $sql =
                "SELECT su.*
                FROM `subscription_users` su
                JOIN (
                SELECT `user_id`, MAX(`id`) AS max_id
                FROM `subscription_users`
                WHERE (`subscription_change` = 'first_purchase' OR `subscription_change` = 'purchase' OR `subscription_change` = 'trial_purchase') 
                AND  (`new_plan` != 'OneTime' OR `new_plan` IS NULL)
                GROUP BY `user_id`) AS max_ids
                ON su.`user_id` = max_ids.`user_id` AND su.`id` = max_ids.`max_id`
                ORDER BY su.`id` DESC";

            $paymentUsers = $this->fetchSubscriptionUsers($sql);

            /* Prepare the paginator */
            $paginator = (new \Altum\Paginator(
                count($paymentUsers),
                $filters->get_results_per_page(),
                $_GET['page'] ?? 1,
                url('admin/payments/upcoming?&page=%d')
            ));

            $sqlQueryWithLimit = $sql . " {$paginator->get_sql_limit()}";
        }

        if (isset($_GET['user_id']) && $_GET['user_id'] != null) {
            array_push($subscriptionUsers, (array) $subscriptionUser);
        } else {
            $subscriptionUsers = $this->fetchSubscriptionUsers($sqlQueryWithLimit);
            $pagination = (new \Altum\Views\View('partials/pagination', (array) $this))->run(['paginator' => $paginator]);
        }

        foreach ($subscriptionUsers as $paymentUser) {
            $user = db()->where('user_id', $paymentUser['user_id'])->getOne('users');

            if ($paymentUser && $paymentUser['new_plan'] != 'OneTime' && $user->plan_id != 5) {
                $paymentUser['stripe_customer_id']        = $user->stripe_customer_id;
                $paymentUser['payment_subscription_id']   = $user->payment_subscription_id;
                $paymentUser['name']                      = $user->name;
                $paymentUser['email']                     = $user->email;
                $paymentUser['plan_id']                   = $user->plan_id;
                $paymentUser['plan_expiration_date']      = $user->plan_expiration_date;
                $paymentUser['subscription_schedule_id']  = $user->subscription_schedule_id ?? null;
                array_push($upcomingUserPayments, $paymentUser);
            }
        }

        return [$upcomingUserPayments, isset($pagination) ? $pagination : null, isset($paginator) ? $paginator : null];
    }

    private function fetchSubscriptionUsers($sqlQuery)
    {
        try {
            $total_rows = analyticsDatabase()->query($sqlQuery);

            $subscriptionUsers = [];
            while ($row = $total_rows->fetch_assoc()) {
                array_push($subscriptionUsers, $row);
            }
        } catch (\Exception $e) {
            dil($e->getMessage());
        }

        return $subscriptionUsers;
    }
}
