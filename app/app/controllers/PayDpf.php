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
use Altum\Response;
use Altum\Title;
use Exception;
use Stripe\Exception\ApiErrorException;

class PayDpf extends Controller
{

    public function index()
    {

        $payment_user               =  isset($this->user->user_id) ? $this->user : null;
        $plan_id                    = isset($this->params[0]) ? $this->params[0] : null;
        $plan                       = db()->where('plan_id', $plan_id)->getOne('plans');

        $onlineUser =  db()->where('user_id', $this->user->user_id)->getOne('dpf_online');
        // Set user status to  online
        if ($onlineUser) {
            db()->where('user_id', $this->user->user_id)->update('dpf_online', [
                'last_activity' => (new \DateTime())->format('Y-m-d H:i:s')
            ]);
        } else {
            db()->insert('dpf_online', [
                'user_id'           => $this->user->user_id,
                'status'            => 'online',
                'last_activity' => (new \DateTime())->format('Y-m-d H:i:s')
            ]);
        }


        if (isset($_SESSION['pay_thank_you'])) {
            unset($_SESSION['pay_thank_you']);
        }

        if (!isset($_SESSION['is_dpf'])) {
            redirect();
        }


        Title::set(sprintf(l('pay.title'), $plan->name));
        $qr_code  =  db()->where('user_id', $this->user->user_id)->getOne('qr_codes');

        if (isset($_GET['payment_intent']) && isset($_GET['redirect_status']) && $_GET['redirect_status'] === 'succeeded') {
            $currency = $_GET['currency'] ? $_GET['currency'] : 'USD';
            sleep(4);
            $this->redirect_pay_thank_you($currency, $payment_user);
        }

        $customerId = null;
        try {
            $stripe = new \Stripe\StripeClient(settings()->stripe->secret_key);
            $stripe->applePayDomains->create([
                'domain_name' => APPLE_DOMAIN,
            ]);
            if (!$payment_user->stripe_customer_id) {
                $customer = $stripe->customers->create([
                    'email' => $payment_user->email,
                    'name'  => isset($payment_user->billing->name) ? $payment_user->billing->name : null,
                    'metadata'    => [
                        'user_id'    => $payment_user->user_id,
                        'user_email' => $payment_user->email
                    ],
                ]);
                $customerId = $customer->id;

                db()->where('email', $payment_user->email)->update('users', [
                    'stripe_customer_id' => $customerId,
                ]);
            } else {
                $customerId = $payment_user->stripe_customer_id;
            }
        } catch (Exception $e) {
            Alerts::add_error(l('pay.error_message.payment_gateway'));
        }

        /* Main View */
        $data = [
            'qr_code'       => $qr_code,
            'user_id'       => $qr_code->user_id,
            'customerId'    => $customerId,
            'stripe'        => $stripe,
            'plan'          => $plan,
            'plan_id'       => $plan_id
        ];

        $view = new \Altum\Views\View('pay-dpf/index', (array) $this);
        $this->add_view_content('content', $view->run($data));
    }

    /* Simple url generator to return the thank you page */
    private function redirect_pay_thank_you($currency, $payment_user)
    {

        $_SESSION['dpf-funnel']  = true;
        $urlParameters = array_filter($_GET, function ($key) {
            return $key != 'altum';
        }, ARRAY_FILTER_USE_KEY);

        $plan_id    = isset($this->params[0]) ? $this->params[0] : null;


        if ($payment_user) {
            // update DPF Funnel user record 
            if ($payment_user->onboarding_funnel == 3) {

                db()->where('user_id', $payment_user->user_id)->update('users', [
                    'onboarding_funnel' => 4
                ]);


                if ($plan_id == 6 || $plan_id == 7) {
                    $step5 =  1;
                } else if ($plan_id == 2) {
                    $step5 =  2;
                    db()->where('user_id', $payment_user->user_id)->update('dpf_user_emails', [
                        'payment_date'  => \Altum\Date::$date,
                    ]);
                }

                db()->where('user_id', $payment_user->user_id)->update('dpf_user_emails', [
                    'is_trial_payment' => 1,
                    'payment_date'     => \Altum\Date::$date,
                ]);

                db()->where('user_id', $payment_user->user_id)->update('user_emails', [
                    'funnel_type' => 'DPF'
                ]);

                try {
                    $stripe = new \Stripe\StripeClient(settings()->stripe->secret_key);
                    $stripe->customers->update(
                        $payment_user->stripe_customer_id,
                        ['metadata' => ['onboarding_funnel' => 4]]
                    );
                } catch (ApiErrorException $e) {
                    dil('Stripe funnel update error - ' . $payment_user->user_id);
                }
            }
        }

        $thank_you_url_parameters = 'payment_intent=' . $urlParameters['payment_intent'];
        $thank_you_url_parameters .= '&plan_id=' . $plan_id;
        $thank_you_url_parameters .= '&currency=' . $currency;

        if (isset($_GET['ref'])) {
            $thank_you_url_parameters .= '&ref=' . $_GET['ref'];
        }

        $_SESSION['pay_thank_you'] = true;
        redirect('pay-thank-you-dpf?' . $thank_you_url_parameters);
    }
}
?>