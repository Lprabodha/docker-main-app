<?php

use Altum\Date;


header('Content-Type: application/json');

try {
    // retrieve JSON from POST body
    $jsonStr = file_get_contents('php://input');
    $jsonObj = json_decode($jsonStr);


    $price = round($jsonObj->payment->amount / 100, 2);

    $plan = db()->where('plan_id', $jsonObj->planId)->getOne('plans');
    $user = db()->where('user_id', $jsonObj->userId)->getOne('users');

    db()->insert('payments', [
        'user_id' => $jsonObj->userId,
        'plan_id' => $jsonObj->planId,
        'processor' => 'offline_payment',
        'type' => $jsonObj->type,
        'frequency' => $jsonObj->planName,
        'code' => NULL,
        'discount_amount' => null,
        'base_amount' => $price,
        'email' => $user->email,
        'payment_id' => $jsonObj->payment->id,
        'name' => $user->name,
        'plan' => json_encode(db()->where('plan_id', $jsonObj->planId)->getOne('plans', ['plan_id', 'name'])),
        'billing' =>  null,
        'business' => json_encode(settings()->business),
        'taxes_ids' => null,
        'total_amount' => $price,
        'currency' => settings()->payment->currency,
        'status' => 0,
        'datetime' => Date::$date
    ]);

    /* Determine the expiration date of the plan */
    /* Update the user with the new plan */
    $current_plan_expiration_date = $plan_id == $user->plan_id ? $user->plan_expiration_date : '';
    switch ($plan->name) {
        case 'Monthly':
            $plan_expiration_date = (new \DateTime($current_plan_expiration_date))->modify('+30 days')->format('Y-m-d H:i:s');
            break;

        case 'Annual':
            $plan_expiration_date = (new \DateTime($current_plan_expiration_date))->modify('+12 months')->format('Y-m-d H:i:s');
            break;

        case 'Quarterly':
            $plan_expiration_date = (new \DateTime($current_plan_expiration_date))->modify('+3 months')->format('Y-m-d H:i:s');
            break;
        case 'Discounted':
            $plan_expiration_date = (new \DateTime($current_plan_expiration_date))->modify('+30 days')->format('Y-m-d H:i:s');
            break;
        case 'OneTime':
            $plan_expiration_date = (new \DateTime($current_plan_expiration_date))->modify('+200 years')->format('Y-m-d H:i:s');
            break;
    }

    $plan_settings = $plan->settings;

    db()->where('user_id',  $jsonObj->userId)->update('users', [
        'plan_id' =>  $jsonObj->planId,
        'plan_settings' => $plan_settings,
        'plan_expiration_date' => $plan_expiration_date,
        'plan_trial_done' => 1,
    ]);

    $_SESSION['pay_thank_you'] = true;

    redirect('pay-thank-you');
} catch (Error $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
    redirect('pay/' . $jsonObj->planId . '?' . (isset($_GET['trial_skip']) ? '&trial_skip=true' : null) . (isset($_GET['code']) ? '&code=' . $_GET['code'] : null));
}
