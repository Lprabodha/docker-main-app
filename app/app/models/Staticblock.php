<?php
/*
 * @copyright Copyright (c) 2021 AltumCode (https://altumcode.com/)
 *
 * This software is exclusively sold through https://altumcode.com/ by the AltumCode author.
 * Downloading this product from any other sources and running it without a proper license is illegal,
 *  except the official ones linked from https://altumcode.com/.
 */

namespace Altum\Models;

class Staticblock extends Model {

    public function get_staticblock_by_staticblock_id($staticblock_id) {

        /* Get the staticblock */
        $staticblock = null;

        /* Try to check if the resource exists via the cache */
        $cache_instance = \Altum\Cache::$adapter->getItem('staticblock?staticblock_id=' . $staticblock_id);

        /* Set cache if not existing */
        if(is_null($cache_instance->get())) {

            /* Get data from the database */
            $staticblock = db()->where('staticblock_id', $staticblock_id)->getOne('staticblocks');

            if($staticblock) {
                \Altum\Cache::$adapter->save(
                    $cache_instance->set($staticblock)->expiresAfter(CACHE_DEFAULT_SECONDS)->addTag('user_id=' . $staticblock->user_id)
                );
            }

        } else {

            /* Get cache */
            $staticblock = $cache_instance->get();

        }

        return $staticblock;

    }

}
