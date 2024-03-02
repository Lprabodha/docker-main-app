<?php
/*
 * @copyright Copyright (c) 2021 AltumCode (https://altumcode.com/)
 *
 * This software is exclusively sold through https://altumcode.com/ by the AltumCode author.
 * Downloading this product from any other sources and running it without a proper license is illegal,
 *  except the official ones linked from https://altumcode.com/.
 */

namespace Altum\Routing;

use Altum\Database\Database;
use Altum\Language;

class Router
{
    public static $params = [];
    public static $original_request = '';
    public static $language_code = '';
    public static $path = '';
    public static $controller_key = 'index';
    public static $controller = 'Index';
    public static $controller_settings = [
        'wrapper' => 'wrapper',
        'no_authentication_check' => false,

        /* Enable / disable browser language detection & redirection */
        'no_browser_language_detection' => false,

        /* Should we see a view for the controller? */
        'has_view' => true,

        /* If set on yes, ads won't show on these pages at all */
        'ads' => false,

        /* Authentication guard check (potential values: null, 'guest', 'user', 'admin') */
        'authentication' => null,

        /* Teams */
        'allow_team_access' => null,
    ];
    public static $method = 'index';
    public static $data = [];



    public static $routes = [
        'l' => [
            'link' => [
                'controller' => 'Link',
                'settings' => [
                    'no_authentication_check' => true,
                    'no_browser_language_detection' => true,
                    'ads' => true,
                ]
            ]
        ],

        '' => [
            'plans-and-prices' => [
                'controller' => 'PlansAndPrices',
                'settings' => [
                    'allow_team_access' => false,
                    'wrapper' => 'home_wrapper',
                ]
            ],
            'terms-and-conditions' => [
                'controller' => 'TermsAndConditions',
                'settings' => [
                    'allow_team_access' => false,
                    'wrapper' => 'home_wrapper',
                ]
            ],
            'privacy-policy' => [
                'controller' => 'PrivacyPolicy',
                'settings' => [
                    'allow_team_access' => false,
                    'wrapper' => 'home_wrapper',
                ]
            ],
            'cookies-policy' => [
                'controller' => 'CookiesPolicy',
                'settings' => [
                    'allow_team_access' => false,
                ]
            ],
            'gdpr' => [
                'controller' => 'Gdpr',
                'settings' => [
                    'allow_team_access' => false,
                ]
            ],
            'faq' => [
                'controller' => 'Faq',
                'settings' => [
                    'wrapper' => 'home_wrapper',
                    'allow_team_access' => false,
                ]
            ],
            'cancel-subscription' => [
                'controller' => 'CancelSubscription',
                'settings' => [
                    'wrapper' => 'home_wrapper',
                    'allow_team_access' => false,
                ]
            ],
            'error' => [
                'controller' => 'Error',
                'settings' => [
                    'allow_team_access' => false,
                ]
            ],
            'users' => [
                'controller' => 'Users',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ],
            ],

            'billing' => [
                'controller' => 'Billing',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ],
            ],

            'update-payment-method' => [
                'controller' => 'UpdatePayment',
                'settings' => [
                    'wrapper' => 'guest_wrapper',
                    'ads' => true,
                ],
            ],


            'add-payment-method' => [
                'controller' => 'AddPayment',
                // 'method' => 'addPaymentMethod',
                'settings' => [
                    'has_view' => false
                ]
            ],

            'qr' => [
                'controller' => 'Qr',
                'settings' => [
                    'ads' => true,
                    'no_browser_language_detection' => true,
                ],
            ],

            'create' => [
                'controller' => 'NewLanding',
                'settings' => [
                    'ads' => true,
                    'no_browser_language_detection' => true,
                ],
            ],

            'qr-reader' => [
                'controller' => 'QrReader',
                'settings' => [
                    'ads' => true,
                ],
            ],
            'analytics' => [
                'controller' => 'Dashboard',
                'method' => 'export',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => false,
                    'has_view' => false
                ]
            ],
            'analytics' => [
                'controller' => 'Dashboard',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],
            'dashboard' => [
                'controller' => 'Dashboard',
                'method' => 'export',
                'settings' => [
                    'wrapper' => false,
                    'ads' => false,
                    'has_view' => false
                ]
            ],
            'dashboard' => [
                'controller' => 'Dashboard',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            'qr-codes' => [
                'controller' => 'QrCodes',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],
            'qr-code' => [
                'controller' => 'QrCodes',
                'method' => 'detail',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            'qr-download' => [
                'controller' => 'QrDownload',
                'settings' => [
                    'wrapper' => 'guest_wrapper',
                    // 'no_browser_language_detection' => true,
                    // 'ads' => true,
                ]
            ],

            'qr-code-update' => [
                'controller' => 'QrCodeUpdate',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            'qr-code-generator' => [
                'controller' => 'QrCodeGenerator',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'no_browser_language_detection' => true,
                ]
            ],

            'projects' => [
                'controller' => 'Projects',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            'project-create' => [
                'controller' => 'ProjectCreate',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            'project-update' => [
                'controller' => 'ProjectUpdate',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            'pixels' => [
                'controller' => 'Pixels',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            'pixel-update' => [
                'controller' => 'PixelUpdate',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            'pixel-create' => [
                'controller' => 'PixelCreate',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            'domains' => [
                'controller' => 'Domains',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            'domain-create' => [
                'controller' => 'DomainCreate',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            'domain-update' => [
                'controller' => 'DomainUpdate',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            'links' => [
                'controller' => 'Links',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            'link-create' => [
                'controller' => 'LinkCreate',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            'link-update' => [
                'controller' => 'LinkUpdate',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            'link-redirect' => [
                'controller' => 'LinkRedirect',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                ]
            ],

            'link-statistics' => [
                'controller' => 'LinkStatistics',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            /* Common routes */
            'index' => [
                'controller' => 'Index',
                'settings' => [
                    'wrapper' => 'home_wrapper',
                    'no_browser_language_detection' => true,
                ]
            ],

            'login' => [
                'controller' => 'Login',
                'settings' => [
                    'wrapper' => 'guest_wrapper',
                    'no_browser_language_detection' => true,
                ]
            ],


            'register' => [
                'controller' => 'Register',
                'settings' => [
                    'wrapper' => 'home_wrapper',
                    'no_browser_language_detection' => true,
                ]
            ],

            'register_nsf' => [
                'controller' => 'RegisterNsf',
                'settings' => [
                    'wrapper' => 'guest_wrapper',
                    'no_browser_language_detection' => true,
                ]
            ],
            'register-dpf' => [
                'controller' => 'RegisterDpf',
                'settings' => [
                    'wrapper' => 'guest_wrapper',
                    'no_browser_language_detection' => true,
                ]
            ],
        

            'contact' => [
                'controller' => 'Contact',
                'settings' => [
                    'allow_team_access' => false,
                    'wrapper' => 'home_wrapper',
                ]
            ],

            'activate-user' => [
                'controller' => 'ActivateUser'
            ],

            'lost-password' => [
                'controller' => 'LostPassword',
                'settings' => [
                    'wrapper' => 'basic_wrapper',
                ]
            ],

            'reset-password' => [
                'controller' => 'ResetPassword',
                'settings' => [
                    'wrapper' => 'basic_wrapper',
                ]
            ],

            'resend-activation' => [
                'controller' => 'ResendActivation',
                'settings' => [
                    'wrapper' => 'basic_wrapper',
                ]
            ],

            'logout' => [
                'controller' => 'Logout'
            ],

            'notfound' => [
                'controller' => 'NotFound',
                'settings' => [
                    'wrapper' => 'home_wrapper',
                ]
            ],

            'account' => [
                'controller' => 'Account',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'allow_team_access' => false,
                ]
            ],

            'account-plan' => [
                'controller' => 'AccountPlan',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'allow_team_access' => false,
                ]
            ],

            'account-redeem-code' => [
                'controller' => 'AccountRedeemCode',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'allow_team_access' => false,
                ]
            ],

            'account-payments' => [
                'controller' => 'AccountPayments',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'allow_team_access' => false,
                ]
            ],

            'account-logs' => [
                'controller' => 'AccountLogs',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'allow_team_access' => false,
                ]
            ],

            'account-api' => [
                'controller' => 'AccountApi',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'allow_team_access' => false,
                ]
            ],

            'account-delete' => [
                'controller' => 'AccountDelete',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'allow_team_access' => false,
                ]
            ],

            'referrals' => [
                'controller' => 'Referrals',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'allow_team_access' => false,
                ]
            ],

            'refer' => [
                'controller' => 'Refer',
                'settings' => [
                    'has_view' => false
                ]
            ],

            'invoice' => [
                'controller' => 'Invoice',
                'settings' => [
                    'wrapper' => 'invoice/invoice_wrapper',
                ]
            ],

            'plan' => [
                'controller' => 'Plan',
                'settings' => [
                    'wrapper' => 'billing_wrapper',
                    'allow_team_access' => false,
                ]
            ],

            'plan-dpf' => [
                'controller' => 'PlanDpf',
                'settings' => [
                    'wrapper' => 'dpf_wrapper',
                    'no_browser_language_detection' => true,
                ]
            ],

            'plan-rdpf' => [
                'controller' => 'PlanRDpf',
                'settings' => [
                    'wrapper' => 'dpf_renew_wrapper',
                    'no_browser_language_detection' => true,
                ]
            ],



            'pay' => [
                'controller' => 'Pay',
                'settings' => [
                    'wrapper' => 'billing_wrapper',
                    'allow_team_access' => false,
                ]
            ],
            'pay-dpf' => [
                'controller' => 'PayDpf',
                'settings' => [
                    'wrapper' => 'dpf_wrapper',
                    'allow_team_access' => false,
                ]
            ],

            'pay-rdpf' => [
                'controller' => 'PayRDpf',
                'settings' => [
                    'wrapper' => 'dpf_renew_wrapper',
                    'allow_team_access' => false,
                ]
            ],

            'change-plan' => [
                'controller' => 'ChangePlan',
                'settings' => [
                    'wrapper' => 'billing_wrapper',
                    'allow_team_access' => false,
                ]
            ],

            'change-plan-dpf' => [
                'controller' => 'ChangePlanDpf',
                'settings' => [
                    'wrapper' => 'dpf_renew_wrapper',
                    'allow_team_access' => false,
                ]
            ],


            'reactive-plan' => [
                'controller' => 'ReactivePlan',
                'settings' => [
                    'wrapper' => 'billing_wrapper',
                    'allow_team_access' => false,
                ]
            ],

            'reactive-plan-dpf' => [
                'controller' => 'ReactivePlanDpf',
                'settings' => [
                    'wrapper' => 'dpf_renew_wrapper',
                    'allow_team_access' => false,
                ]
            ],



            'pay-billing' => [
                'controller' => 'PayBilling',
                'settings' => [
                    'wrapper' => 'billing_wrapper',
                    'allow_team_access' => false,
                ]
            ],

            'pay-thank-you' => [
                'controller' => 'PayThankYou',
                'settings' => [
                    'no_authentication_check' => false,
                    'wrapper' => 'billing_wrapper',
                    'allow_team_access' => false,
                ]
            ],

            'pay-thank-you-dpf' => [
                'controller' => 'DpfPayThankYou',
                'settings' => [
                    'no_authentication_check' => false,
                    'wrapper' => 'dpf_wrapper',
                    'allow_team_access' => false,
                ]
            ],

            'pay-thank-you-rdpf' => [
                'controller' => 'RDpfPayThankYou',
                'settings' => [
                    'no_authentication_check' => false,
                    'wrapper' => 'dpf_renew_wrapper',
                    'allow_team_access' => false,
                ]
            ],

            'teams-system' => [
                'controller' => 'TeamsSystem',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                    'allow_team_access' => false,
                ]
            ],

            'teams' => [
                'controller' => 'Teams',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                    'allow_team_access' => false,
                ]
            ],

            'team-create' => [
                'controller' => 'TeamCreate',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                    'allow_team_access' => false,
                ]
            ],

            'team-update' => [
                'controller' => 'TeamUpdate',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                    'allow_team_access' => false,
                ]
            ],

            'team' => [
                'controller' => 'Team',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                    'allow_team_access' => false,
                ]
            ],

            'teams-members' => [
                'controller' => 'TeamsMembers',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                    'allow_team_access' => false,
                ]
            ],

            'team-member-create' => [
                'controller' => 'TeamMemberCreate',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                    'allow_team_access' => false,
                ]
            ],

            'team-member-update' => [
                'controller' => 'TeamMemberUpdate',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                    'allow_team_access' => false,
                ]
            ],

            'teams-member' => [
                'controller' => 'TeamsMember',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                    'allow_team_access' => false,
                ]
            ],

            /* Webhooks */
            'webhook-paypal' => [
                'controller' => 'WebhookPaypal',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'no_browser_language_detection' => true,
                ]
            ],


            'webhook-stripe' => [
                'controller' => 'WebhookStripe',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'no_browser_language_detection' => true,
                ]
            ],


            'stripe-element' => [
                'controller' => 'StripeElement',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'no_browser_language_detection' => true,
                ]
            ],

            'save-payment' => [
                'controller' => 'SavePayment',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'no_browser_language_detection' => true,
                ]
            ],
            'stripe' => [
                'controller' => 'Stripe',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'no_browser_language_detection' => true,
                ]
            ],

            'save-payment' => [
                'controller' => 'SavePayment',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'no_browser_language_detection' => true,
                ]
            ],
            'stripe' => [
                'controller' => 'Stripe',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'no_browser_language_detection' => true,
                ]
            ],

            'save-payment' => [
                'controller' => 'SavePayment',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'no_browser_language_detection' => true,
                ]
            ],

            'webhook-coinbase' => [
                'controller' => 'WebhookCoinbase',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'no_browser_language_detection' => true,
                ]
            ],

            'webhook-payu' => [
                'controller' => 'WebhookPayu',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'no_browser_language_detection' => true,
                ]
            ],

            'webhook-paystack' => [
                'controller' => 'WebhookPaystack',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'no_browser_language_detection' => true,
                ]
            ],

            'webhook-razorpay' => [
                'controller' => 'WebhookRazorpay',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'no_browser_language_detection' => true,
                ]
            ],

            'webhook-mollie' => [
                'controller' => 'WebhookMollie',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'no_browser_language_detection' => true,
                ]
            ],

            'webhook-yookassa' => [
                'controller' => 'WebhookYookassa',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'no_browser_language_detection' => true,
                ]
            ],

            'webhook-crypto-com' => [
                'controller' => 'WebhookCryptoCom',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'no_browser_language_detection' => true,
                ]
            ],

            'webhook-paddle' => [
                'controller' => 'WebhookPaddle',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'no_browser_language_detection' => true,
                ]
            ],

            /* Others */
            'cookie-consent' => [
                'controller' => 'CookieConsent',
                'settings' => [
                    'no_authentication_check' => true,
                    'no_browser_language_detection' => true,
                ]
            ],

            'sitemap' => [
                'controller' => 'Sitemap',
                'settings' => [
                    'no_authentication_check' => true,
                    'no_browser_language_detection' => true,
                ]
            ],

            'cron' => [
                'controller' => 'Cron',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'no_browser_language_detection' => true,
                ]
            ],

            'cron-quick' => [
                'controller' => 'CronQuick',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'no_browser_language_detection' => true,
                ]
            ],

            
            'helpdesk' => [
                'controller' => 'SupportLogin',
                'settings' => [
                    'no_authentication_check' => false,
                    'wrapper' => 'guest_wrapper',                    
                    'no_browser_language_detection' => true,
                ],

            ],
 

            'email-unsubscribe' => [
                'controller' => 'UnsubscribeEmail',
                'settings' => [
                    'no_authentication_check' => true,
                    'wrapper' => 'guest_wrapper',
                    'no_browser_language_detection' => true,
                ],
            ],

        ],

        'api' => [
            'qr-codes' => [
                'controller' => 'ApiQrCodes',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false
                ]
            ],
            'product-metrics' => [
                'controller' => 'ApiAnalytics',
                'settings' => [
                    'no_authentication_check' => false,
                    'has_view' => false
                ]
            ],
            'qr-code' => [
                'controller' => 'ApiQrCode',
                'settings' => [
                    'no_authentication_check' => false,
                    'has_view' => false
                ]
            ],
            'user-language' => [
                'controller' => 'ApiUserLanguage',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false
                ]
            ],
            'statistics' => [
                'controller' => 'ApiStatistics',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false
                ]
            ],
            'scan' => [
                'controller' => 'ApiScans',
                'method' => 'store',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false
                ]
            ],
            'ajax' => [
                'controller' => 'ApiAjax',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false
                ],
            ],
            'ajax_new' => [
                'controller' => 'ApiAjaxNew',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false
                ],
            ],
            'links' => [
                'controller' => 'ApiLinks',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false
                ]
            ],
            'projects' => [
                'controller' => 'ApiProjects',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false
                ]
            ],
            'pixels' => [
                'controller' => 'ApiPixels',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false
                ]
            ],
            'domains' => [
                'controller' => 'ApiDomains',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false
                ]
            ],

            /* Common routes */
            'teams' => [
                'controller' => 'ApiTeams',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                ]
            ],
            'teams-member' => [
                'controller' => 'ApiTeamsMember',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                ]
            ],
            'team-members' => [
                'controller' => 'ApiTeamMembers',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                ]
            ],
            'user' => [
                'controller' => 'ApiUser',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false
                ]
            ],
            'payments' => [
                'controller' => 'ApiPayments',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false
                ]
            ],
            'logs' => [
                'controller' => 'ApiLogs',
                'settings' => [
                    'no_authentication_check' => true,
                'has_view' => false
                ]
            ],

            'cancel-popup-delinquent-user' => [
                'controller' => 'ApiAjaxNew',
                'method' => 'cancelPopupDelinquentUser',
                'settings' => [
                    'no_authentication_check' => true,
                'has_view' => false
                ]
            ],


        ],



        /* Admin Panel */
        /* Authentication is set by default to 'admin' */
        'admin' => [
            'qr-codes' => [
                'controller' => 'AdminQrCodes',
            ],

            'archived-qr-codes' => [
                'controller' => 'AdminArchivedQrCodes',
            ],

            'links' => [
                'controller' => 'AdminLinks',
            ],

            'projects' => [
                'controller' => 'AdminProjects',
            ],

            'pixels' => [
                'controller' => 'AdminPixels'
            ],

            'domains' => [
                'controller' => 'AdminDomains',
            ],

            'domain-create' => [
                'controller' => 'AdminDomainCreate',
            ],

            'domain-update' => [
                'controller' => 'AdminDomainUpdate',
            ],

            /* Common routes */
            'index' => [
                'controller' => 'AdminIndex',
            ],

            'users' => [
                'controller' => 'AdminUsers',
            ],

            'user-create' => [
                'controller' => 'AdminUserCreate',
            ],

            'user-view' => [
                'controller' => 'AdminUserView',
            ],

            'user-update' => [
                'controller' => 'AdminUserUpdate',
            ],

            'users-logs' => [
                'controller' => 'AdminUsersLogs',
            ],

            'redeemed-codes' => [
                'controller' => 'AdminRedeemedCodes',
            ],

            'blog-posts' => [
                'controller' => 'AdminBlogPosts'
            ],

            'blog-post-create' => [
                'controller' => 'AdminBlogPostCreate'
            ],

            'blog-post-update' => [
                'controller' => 'AdminBlogPostUpdate'
            ],

            'blog-posts-categories' => [
                'controller' => 'AdminBlogPostsCategories'
            ],

            'blog-posts-category-create' => [
                'controller' => 'AdminBlogPostsCategoryCreate'
            ],

            'blog-posts-category-update' => [
                'controller' => 'AdminBlogPostsCategoryUpdate'
            ],

            'resources' => [
                'controller' => 'AdminResources'
            ],

            'pages' => [
                'controller' => 'AdminPages'
            ],

            'page-create' => [
                'controller' => 'AdminPageCreate'
            ],

            'page-update' => [
                'controller' => 'AdminPageUpdate'
            ],

            'pages-categories' => [
                'controller' => 'AdminPagesCategories'
            ],

            'pages-category-create' => [
                'controller' => 'AdminPagesCategoryCreate'
            ],

            'pages-category-update' => [
                'controller' => 'AdminPagesCategoryUpdate'
            ],

            'plans' => [
                'controller' => 'AdminPlans',
            ],

            'plan-create' => [
                'controller' => 'AdminPlanCreate',
            ],

            'plan-update' => [
                'controller' => 'AdminPlanUpdate',
            ],

            'billings' => [
                'controller' => 'AdminBillings',
            ],

            'billing-create' => [
                'controller' => 'AdminBillingCreate',
            ],

            'billing-update' => [
                'controller' => 'AdminBillingUpdate',
            ],

            'staticblocks' => [
                'controller' => 'AdminStaticblocks',
            ],

            'staticblock-create' => [
                'controller' => 'AdminStaticblockCreate',
            ],

            'staticblock-update' => [
                'controller' => 'AdminStaticblockUpdate',
            ],

            'codes' => [
                'controller' => 'AdminCodes',
            ],

            'code-create' => [
                'controller' => 'AdminCodeCreate',
            ],

            'code-update' => [
                'controller' => 'AdminCodeUpdate',
            ],

            'taxes' => [
                'controller' => 'AdminTaxes',
            ],

            'tax-create' => [
                'controller' => 'AdminTaxCreate',
            ],

            'tax-update' => [
                'controller' => 'AdminTaxUpdate',
            ],

            'affiliates-withdrawals' => [
                'controller' => 'AdminAffiliatesWithdrawals',
            ],

            'payments' => [
                'controller' => 'AdminPayments',
            ],

            'statistics' => [
                'controller' => 'AdminStatistics',
            ],

            'plugins' => [
                'controller' => 'AdminPlugins',
            ],

            'languages' => [
                'controller' => 'AdminLanguages'
            ],

            'language-create' => [
                'controller' => 'AdminLanguageCreate'
            ],

            'language-update' => [
                'controller' => 'AdminLanguageUpdate'
            ],

            'settings' => [
                'controller' => 'AdminSettings',
            ],

            'api-documentation' => [
                'controller' => 'AdminApiDocumentation',
            ],

            'teams' => [
                'controller' => 'AdminTeams',
            ],

        ],

        'admin-api' => [
            'users' => [
                'controller' => 'AdminApiUsers',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false
                ]
            ],

            'plans' => [
                'controller' => 'AdminApiPlans',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false
                ]
            ],

        ],
    ];


    public static function parse_url()
    {

        $params = self::$params;

        if (isset($_GET['altum'])) {
            $params = explode('/', filter_var(rtrim($_GET['altum'], '/'), FILTER_SANITIZE_STRING));
        }

        self::$params = $params;

        return $params;
    }

    public static function get_params()
    {

        return self::$params = array_values(self::$params);
    }

    public static function parse_language()
    {

        /* Check for potential language set in the first parameter */
        if (!empty(self::$params[0]) && in_array(self::$params[0], Language::$active_languages)) {

            /* Set the language */
            $language_code = filter_var(self::$params[0], FILTER_SANITIZE_STRING);
            Language::set_by_code($language_code);
            self::$language_code = $language_code;

            /* Unset the parameter so that it wont be used further */
            unset(self::$params[0]);
            self::$params = array_values(self::$params);
        }
    }

    public static function parse_controller()
    {

        self::$original_request = filter_var(implode('/', self::$params), FILTER_SANITIZE_STRING);

        /* Check if the current link accessed is actually the original url or not (multi domain use) */
        $original_url_host = parse_url(url(), PHP_URL_HOST);
        $request_url_host = filter_var($_SERVER['HTTP_HOST'], FILTER_SANITIZE_STRING);

        if ($original_url_host != $request_url_host) {
            /* Make sure the custom domain is attached */
            $domain = (new \Altum\Models\Domain())->get_domain_by_host($request_url_host);

            if ($domain && $domain->is_enabled) {
                self::$path = 'l';

                /* Set some route data */
                self::$data['domain'] = $domain;

                /* Check for custom index url */
                if (empty(self::$params[0]) && self::$data['domain']->custom_index_url) {
                    header('Location: ' . self::$data['domain']->custom_index_url);
                    die();
                }
            }
        }


        /* Check for potential other paths than the default one (admin panel) */
        if (!empty(self::$params[0])) {

            if (in_array(self::$params[0], ['admin', 'v', 'admin-api', 'api'])) {
                self::$path = self::$params[0];

                unset(self::$params[0]);

                self::$params = array_values(self::$params);
            }
        }

        /* Check for potential link */
        if (self::$path == 'l') {
            self::$controller_key = 'link';
            self::$controller = 'Link';
        }


        if (!empty(self::$params[0])) {

            if (array_key_exists(self::$params[0], self::$routes[self::$path]) && file_exists(APP_PATH . 'controllers/' . (self::$path != '' ? self::$path . '/' : null) . self::$routes[self::$path][self::$params[0]]['controller'] . '.php')) {


                self::$controller_key = self::$params[0];

                unset(self::$params[0]);
            } else {

                /* Try to check if the link exists via the cache */
                $cache_instance = \Altum\Cache::$adapter->getItem('l_link?url=' . md5(self::$params[0]) . (isset(self::$data['domain']) ? '&domain_id=' . self::$data['domain']->domain_id : null));

                /* Set cache if not existing */
                if (!$cache_instance->get()) {

                    /* Get data from the database */
                    if (isset(self::$data['domain'])) {
                        $link = db()->where('url', self::$params[0])->where('domain_id', self::$data['domain']->domain_id)->getOne('links');
                        if ($link) $link->full_url = self::$data['domain']->scheme . self::$data['domain']->host . '/' . self::$params[0] . '/';
                    } else {
                        $link = db()->where('url', self::$params[0])->where('domain_id', NULL, 'IS')->getOne('links');
                        if ($link) $link->full_url = SITE_URL . self::$params[0] . '/';
                    }

                    /* Save cache */
                    if ($link) {
                        \Altum\Cache::$adapter->save($cache_instance->set($link)->expiresAfter(CACHE_DEFAULT_SECONDS)->addTag('link_id=' . $link->link_id));

                        /* Set some route data */
                        self::$data['link'] = $link;
                    }
                } else {
                    /* Get cache */
                    $link = $cache_instance->get();

                    /* Set some route data */
                    self::$data['link'] = $link;
                }

                /* Check if there is any link available in the database */
                if ($link) {
                    self::$controller_key = 'link';
                    self::$controller = 'Link';
                    self::$path = 'l';
                } else {


                    /* Check for a custom domain 404 redirect */
                    if (isset(self::$data['domain']) && self::$data['domain']->custom_not_found_url) {
                        header('Location: ' . self::$data['domain']->custom_not_found_url);
                        die();
                    } else {
                        /* Not found controller */
                        self::$path = '';
                        self::$controller_key = 'notfound';
                    }
                }
            }
        }

        /* Save the current controller */
        if (!isset(self::$routes[self::$path][self::$controller_key])) {
            /* Not found controller */
            self::$path = '';
            self::$controller_key = 'notfound';
        }
        self::$controller = self::$routes[self::$path][self::$controller_key]['controller'];

        /* Admin path */
        if (self::$path == 'admin' && !isset(self::$routes[self::$path][self::$controller_key]['settings'])) {
            self::$routes[self::$path][self::$controller_key]['settings'] = [
                'authentication' => 'admin',
                'allow_team_access' => false,
            ];
        }

        /* Make sure we also save the controller specific settings */
        if (isset(self::$routes[self::$path][self::$controller_key]['settings'])) {
            self::$controller_settings = array_merge(self::$controller_settings, self::$routes[self::$path][self::$controller_key]['settings']);
        }

        return self::$controller;
    }

    public static function get_controller($controller_ame, $path = '')
    {

        require_once APP_PATH . 'controllers/' . ($path != '' ? $path . '/' : null) . $controller_ame . '.php';

        /* Create a new instance of the controller */
        $class = 'Altum\\Controllers\\' . $controller_ame;

        /* Instantiate the controller class */
        $controller = new $class;

        return $controller;
    }

    public static function parse_method($controller)
    {

        $method = self::$method;

        /* Make sure to check the class method if set in the url */
        if (isset(self::get_params()[0]) && method_exists($controller, self::get_params()[0])) {

            /* Make sure the method is not private */
            $reflection = new \ReflectionMethod($controller, self::get_params()[0]);
            if ($reflection->isPublic()) {
                $method = self::get_params()[0];

                unset(self::$params[0]);
            }
        }

        return self::$method = $method;
    }
}
