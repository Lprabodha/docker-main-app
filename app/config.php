<?php
/* Configuration of the site */
define('DATABASE_SERVER',   getenv('DB_HOST'));
define('DATABASE_USERNAME', getenv('DB_USER'));
define('DATABASE_PASSWORD', getenv('DB_PASSWORD'));
define('DATABASE_NAME',     getenv('MAIN_DATABASE'));
define('DATABASE_PORT',     getenv('DB_PORT'));


define('ANALYTICS_DATABASE_SERVER',getenv('DB_HOST'));
define('ANALYTICS_DATABASE_USERNAME',getenv('DB_USER'));
define('ANALYTICS_DATABASE_PASSWORD',getenv('DB_PASSWORD'));
define('ANALYTICS_DATABASE_NAME',getenv('ANALYTIC_DATABASE'));
define('ANALYTICS_DATABASE_PORT',getenv('DB_PORT'));


define('SITE_URL',getenv('SITE_URL'));
// define('SITE_URL','http://192.168.1.207/qr-website/');
define('LANDING_PAGE_URL',getenv('LANDING_PAGE_URL'));
// define('LANDING_PAGE_URL','http://192.168.1.207:3000/');
// define('LANDING_PAGE_URL','https://dev.scanned.page/');
// define('LANDING_PAGE_URL','https://dev.scanned.page/');

define('EXCHANGE_API_KEY', 'd1391912877b4af9a54c19eb641b95d3');

define('STRIPE_COUPON_1', 'PROMO_70OFF_MONTH');
define('STRIPE_COUPON_3', 'PROMO_70OFF_3_MONTH');
define('STRIPE_COUPON_3_NEW', 'PROMO_70OFF_3_MONTH');
define('STRIPE_COUPON_12', 'PROMO_70OFF_YEAR');
define('STRIPE_COUPON_1_NEW', 'PROMO_70OFF_MONTH');
define('STRIPE_COUPON_2_NEW', 'PROMO_70OFF_3_MONTH');
define('STRIPE_COUPON_12_NEW', 'PROMO_70OFF_YEAR');

define('STRIPE_COUPON_30_FOREVER', 'PROMO_30OFF_MONTH_FOREVER');
define('STRIPE_COUPON_40_FOREVER', 'PROMO_40OFF_MONTH_FOREVER');
define('STRIPE_COUPON_50_FOREVER', 'PROMO_50OFF_MONTH_FOREVER');
define('STRIPE_COUPON_60_FOREVER', 'PROMO_60OFF_MONTH_FOREVER');
define('STRIPE_COUPON_70_FOREVER', 'PROMO_70OFF_MONTH_FOREVER');
define('STRIPE_COUPON_90_FOREVER', 'PROMO_90OFF_MONTH_FOREVER');

define('STRIPE_PRODUCT_ID', 'prod_PIYiSYxQjZH6Sw');
define('STRIPE_PRICE_1_ID', 'price_1OTxdIA5oDtZLAtBLe9cXD7A'); // new price
define('STRIPE_PRICE_3_ID', 'price_1OTxeOA5oDtZLAtB2XwXXaPj');
define('STRIPE_PRICE_12_ID', 'price_1OTxdlA5oDtZLAtB8efSTnuT');
define('STRIPE_PRICE_1_DISCOUNTED_ID', 'price_1OTxgUA5oDtZLAtB9S80CzVh');
define('STRIPE_PRICE_ONETIME_ID', 'price_1OTyB2A5oDtZLAtBnr638CGG');
define('STRIPE_PRICE_14_DAY_FULL_ACCESS', 'price_1OTyAVA5oDtZLAtBbLXuPiLQ');
define('STRIPE_PRICE_14_DAY_LIMITED_ACCESS', 'price_1OTyAkA5oDtZLAtBngE8xjIM');
define('STRIPE_TRIAL_ID', 'price_1OeYXGA5oDtZLAtBMtw87kVa');

define('ZENDESK_SUBDOMAIN','increast');
define('ZENDESK_EMAIL','accounting@increast.com');
define('ZENDESK_TOKEN','dJNF2AZp8W6qOFZi0ksl23DRpvYAQXp3a9mFuDlX');

define('OFFLOAD_ENDPOINT','https://nyc3.digitaloceanspaces.com/');
define('OFFLOAD_FULL_ENDPOINT','https://oqg.nyc3.digitaloceanspaces.com/');
define('OFFLOAD_ACCESS_KEY','DO00VPK82VJTBZLKEP7T');
define('OFFLOAD_SECRET_KEY','RpzJSh/n3Mr+8LOJY53ePEy/D3mTg4tR1WgUkypCHq4');
// define('OFFLOAD_PROVIDER','digitalocean-spaces');
define('OFFLOAD_PROVIDER','local');
define('OFFLOAD_BUCKET','oqg');
// 
// define('APP_CONFIG', 'production');
define('APP_CONFIG', 'local');
define('APPLE_DOMAIN', 'localhost');

// Local
define('GTAG', 'G-W82T6XDHST');
define('GTM', 'GTM-KNPQVK3');
define('GA_SESSION', 'W82T6XDHST');
define('GA_TAG', 'G-W82T6XDHST');
define('GADS', '123456789');

define('OQG_API', 'http://127.0.0.1:8000/');
define('ANALYTIC_API', 'http://127.0.0.1:8000/');
define('EMAIL_API', 'http://127.0.0.1:8000/');
define('CONTENT_API', 'http://127.0.0.1:8000/');
define('WEB_HOOK_URL', '');