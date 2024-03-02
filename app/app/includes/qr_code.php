<?php
/*
 * @copyright Copyright (c) 2021 AltumCode (https://altumcode.com/)
 *
 * This software is exclusively sold through https://altumcode.com/ by the AltumCode author.
 * Downloading this product from any other sources and running it without a proper license is illegal,
 *  except the official ones linked from https://altumcode.com/.
 */

return [
    /* Max QR code logo upload in mb */
    'qr_code_logo_size_limit' => 10,
   
    'type' => [
        'url' => [
            'icon' => 'fa fa-link',
            'max_length' => 2048,
            'image' => ASSETS_FULL_URL.'/images/qr-types/web_page.png',
            // 'preview' =>  ASSETS_FULL_URL.'images/default.png'
        ],
        'pdf' => [
            'icon' => 'fa fa-file',
            'max_length' => 32,
            'image' => ASSETS_FULL_URL.'/images/qr-types/pdf.png',
            // 'preview' => ASSETS_FULL_URL.'images/default.png'
        ],
        'images' => [
            'icon' => 'fa fa-image',
            'max_length' => 32,
            'name' => [
                'max_length' => 64,
            ],
            'image_title' => [
                'max_length' => 64,
            ],
            'image_description' => [
                'max_length' => 1000,
            ],
            'website' => [
                'max_length' => 1024,
            ],
            'image' => ASSETS_FULL_URL.'/images/qr-types/images.png',
            // 'preview' => ASSETS_FULL_URL.'images/default.png'
        ],
        'video' => [
            'icon' => 'fa fa-video',
            'max_length' => 400,
            'image' => ASSETS_FULL_URL.'/images/qr-types/video.png',
            // 'preview' => ASSETS_FULL_URL.'images/default.png'
        ],
        'wifi' => [
            'icon' => 'fa fa-wifi',
            'ssid' => [
                'max_length' => 128,
            ],
            'password' => [
                'max_length' => 128,
            ],
            'image' => ASSETS_FULL_URL.'/images/qr-types/wifi.png',
            // 'preview' => ASSETS_FULL_URL.'images/default.png'
        ],
        'menu' => [
            'icon' => 'fa fa-menu',
            'name' => [
                'max_length' => 64,
            ],
            'companyTitle' => [
                'max_length' => 64,
            ],
            'companyDescription' => [
                'max_length' => 1000,
            ],
            'image' => ASSETS_FULL_URL.'/images/qr-types/menu.png',
            // 'preview' => ASSETS_FULL_URL.'images/default.png'
        ],
        'business' => [
            'icon' => 'fa fa-menu',
            'name' => [
                'max_length' => 64,
            ],
            'companyTitle' => [
                'max_length' => 64,
            ],
            'companyDescription' => [
                'max_length' => 1000,
            ],
            'image' => ASSETS_FULL_URL.'/images/qr-types/business.png',
            // 'preview' => ASSETS_FULL_URL.'images/default.png'
        ],
        'vcard' => [
            'icon' => 'fa fa-id-card',
            'image' => ASSETS_FULL_URL.'/images/qr-types/vcard_plus.png',
            // 'preview' => ASSETS_FULL_URL.'images/default.png',
            'first_name' => [
                'max_length' => 64,
            ],
            'last_name' => [
                'max_length' => 64,
            ],
            'phone' => [
                'max_length' => 32,
            ],
            'email' => [
                'max_length' => 320,
            ],
            'url' => [
                'max_length' => 1024,
            ],
            'company' => [
                'max_length' => 64,
            ],
            'job_title' => [
                'max_length' => 64,
            ],
            'birthday' => [
                'max_length' => 16,
            ],
            'street' => [
                'max_length' => 128,
            ],
            'city' => [
                'max_length' => 64,
            ],
            'zip' => [
                'max_length' => 32,
            ],
            'region' => [
                'max_length' => 32,
            ],
            'country' => [
                'max_length' => 32,
            ],
            'note' => [
                'max_length' => 256,
            ],
            'social_label' => [
                'max_length' => 32
            ],
            'social_value' => [
                'max_length' => 1024
            ]
        ],
        'mp3' => [
            'icon' => 'fa fa-video',
            'max_length' => 32,
            'image' => ASSETS_FULL_URL.'/images/qr-types/mp3.png',
            // 'preview' => ASSETS_FULL_URL.'images/default.png'
        ],
        'app' => [
            'icon' => 'fa fa-app',
            'max_length' => 32,
            'image' => ASSETS_FULL_URL.'/images/qr-types/app.png',
            // 'preview' => ASSETS_FULL_URL.'images/default.png'
        ],
        'links' => [
            'icon' => 'fa fa-app',
            'max_length' => 32,
            'image' => ASSETS_FULL_URL.'/images/qr-types/linklist.png',
            // 'preview' => ASSETS_FULL_URL.'images/default.png'
        ],
        'coupon' => [
            'icon' => 'fa fa-app',
            'max_length' => 32,
            'image' => ASSETS_FULL_URL.'/images/qr-types/coupon.png',
            // 'preview' => ASSETS_FULL_URL.'images/default.png'
        ],
        
    ],
];
