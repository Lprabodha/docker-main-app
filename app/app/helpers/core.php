<?php
/*
 * @copyright Copyright (c) 2021 AltumCode (https://altumcode.com/)
 *
 * This software is exclusively sold through https://altumcode.com/ by the AltumCode author.
 * Downloading this product from any other sources and running it without a proper license is illegal,
 *  except the official ones linked from https://altumcode.com/.
 */

function settings()
{
    return \Altum\Settings::$settings;
}

function db()
{
    return \Altum\Database\Database::$db;
}

function analyticsBb()
{
    return \Altum\AnalyticsDatabase\AnalyticsDatabase::$db;
}

function database()
{
    return \Altum\Database\Database::$database;
}

function analyticsDatabase()
{
    return \Altum\AnalyticsDatabase\AnalyticsDatabase::$database;
}

function language($language = null)
{
    return \Altum\Language::get($language);
}

function l($key, $language = null, $null_coalesce = false)
{

    if (!$language) {
        if (Altum\Middlewares\Authentication::check()) {
            if (APP_CONFIG == 'local') {
                // $language = Altum\Middlewares\Authentication::$user->language;
                $language = user_language(Altum\Middlewares\Authentication::$user);
            }else{
                $language = settings()->main->default_language;  
            }
        }
    }

    return \Altum\Language::get($language)[$key] ?? \Altum\Language::get(\Altum\Language::$main_name)[$key] ?? ($null_coalesce ? null : 'missing_translation: ' . $key);
}
