<?php
/*
 * @copyright Copyright (c) 2021 AltumCode (https://altumcode.com/)
 *
 * This software is exclusively sold through https://altumcode.com/ by the AltumCode author.
 * Downloading this product from any other sources and running it without a proper license is illegal,
 *  except the official ones linked from https://altumcode.com/.
 */

namespace Altum\Models;

class Billing extends Model {

    public function get_billing_by_billing_id($billing_id) {

        /* Get the billing */
        $billing = null;

        /* Try to check if the resource exists via the cache */
        $cache_instance = \Altum\Cache::$adapter->getItem('billing?billing_id=' . $billing_id);

        /* Set cache if not existing */
        if(is_null($cache_instance->get())) {

            /* Get data from the database */
            $billing = db()->where('billing_id', $billing_id)->getOne('billings');

            if($billing) {
                \Altum\Cache::$adapter->save(
                    $cache_instance->set($billing)->expiresAfter(CACHE_DEFAULT_SECONDS)->addTag('user_id=' . $billing->user_id)
                );
            }

        } else {

            /* Get cache */
            $billing = $cache_instance->get();

        }

        return $billing;

    }

}
