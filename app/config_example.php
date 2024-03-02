<?php
/* Configuration of the site */
define('DATABASE_SERVER',   'localhost');
define('DATABASE_USERNAME', '');
define('DATABASE_PASSWORD', '');
define('DATABASE_NAME',     '');
define('SITE_URL',          'https://online-qr-generator.com/');
define('LANDING_PAGE_URL',  'https://scanned.page/');


// Stripe Product & Price ID
define('STRIPE_PRODUCT_ID', 'prod_O0Cy4Q8PQFiGtj');
define('STRIPE_PRICE_1_ID', 'price_1NECYJKXJvFOZ1iNtFv3eBbG');
define('STRIPE_PRICE_3_ID', 'price_1NECYJKXJvFOZ1iNphbZHowe');
define('STRIPE_PRICE_12_ID', 'price_1NECYJKXJvFOZ1iNLhwiLcC1');

// Analytic database configuration
define('ANALYTICS_DATABASE_SERVER',   'localhost');
define('ANALYTICS_DATABASE_USERNAME', 'root');
define('ANALYTICS_DATABASE_PASSWORD', '');
define('ANALYTICS_DATABASE_NAME', 'analytics_db');

define('ZENDESK_SUBDOMAIN','');
define('ZENDESK_EMAIL','');
define('ZENDESK_TOKEN','');

// Offload storage configuration
define('OFFLOAD_ENDPOINT','');
define('OFFLOAD_FULL_ENDPOINT','');
define('OFFLOAD_ACCESS_KEY','');
define('OFFLOAD_SECRET_KEY','');
define('OFFLOAD_PROVIDER','local');
define('OFFLOAD_BUCKET','');

define('APP_CONFIG', 'local');

// Local analytic key
define('GTAG', '');
define('GTM', '');
define('GA_SESSION', '');
define('GA_TAG', '');
define('GADS', '');

define('ANALYTIC_API', '');
define('EMAIL_API', '');
define('OQG_API', 'http://127.0.0.1:8000/');
define('CONTENT_API', '');
