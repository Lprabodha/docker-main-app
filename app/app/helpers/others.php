<?php
/*
 * @copyright Copyright (c) 2021 AltumCode (https://altumcode.com/)
 *
 * This software is exclusively sold through https://altumcode.com/ by the AltumCode author.
 * Downloading this product from any other sources and running it without a proper license is illegal,
 *  except the official ones linked from https://altumcode.com/.
 */



/* Aws functions */

use MaxMind\Db\Reader;
use YooKassa\Helpers\UUID;
use Altum\Response;
use Stripe\Exception\ApiErrorException;

function get_aws_s3_config()
{
    $aws_s3_config = [
        'region' => 'us-east-1',
        'version' => 'latest',
        'endpoint' => OFFLOAD_ENDPOINT,
        'use_path_style_endpoint' => false,
        'bucket_endpoint' => true,
        'credentials' => [
            'key' => OFFLOAD_ACCESS_KEY,
            'secret' => OFFLOAD_SECRET_KEY,
        ],
    ];

    // switch(settings()->offload->provider) {
    //     case 'aws-s3':
    //         /* Nothing extra */
    //         break;

    //     default;
    //         $aws_s3_config['region'] = 'us-east-1';
    //         $aws_s3_config['endpoint'] = settings()->offload->endpoint_url;
    //         break;
    // }

    return $aws_s3_config;
}

/* Generate chart data for based on the date key and each of keys inside */
function get_chart_data(array $main_array)
{

    $results = [];

    foreach ($main_array as $date_label => $data) {

        foreach ($data as $label_key => $label_value) {

            if (!isset($results[$label_key])) {
                $results[$label_key] = [];
            }

            $results[$label_key][] = $label_value;
        }
    }

    foreach ($results as $key => $value) {
        $results[$key] = '["' . implode('", "', $value) . '"]';
    }

    $results['labels'] = '["' . implode('", "', array_keys($main_array)) . '"]';

    return $results;
}

function get_gravatar($email, $s = 80, $d = 'mp', $r = 'g', $img = false, $atts = [])
{
    $url = 'https://www.gravatar.com/avatar/';
    $url .= md5(mb_strtolower(trim($email)));
    $url .= "?s=$s&d=$d&r=$r";

    if ($img) {
        $url = '<img src="' . $url . '"';

        foreach ($atts as $key => $val) {
            $url .= ' ' . $key . '="' . $val . '"';
        }

        $url .= ' />';
    }

    return $url;
}

function custom_currency_format($num)
{

    $num = decimal_number_format($num);

    if (fmod($num, 1) !== 0.00) {
        $num =  number_format($num, 2, '.', ',');
    } elseif ($num > 999) {
        $num = number_format($num, 0, '.', ',');
    } else {
        $num = $num;
    }

    return $num;
}


/* Helper to output proper and nice numbers */
function nr($number, $decimals = 0, $extra = false)
{

    if ($extra) {
        $formatted_number = $number;
        $touched = false;

        if (!$touched && (!is_array($extra) || (is_array($extra) && in_array('B', $extra)))) {

            if ($number > 999999999) {
                $formatted_number = number_format($number / 1000000000, $decimals, l('global.number.decimal_point'), l('global.number.thousands_separator')) . 'B';

                $touched = true;
            }
        }

        if (!$touched && (!is_array($extra) || (is_array($extra) && in_array('M', $extra)))) {

            if ($number > 999999) {
                $formatted_number = number_format($number / 1000000, $decimals, l('global.number.decimal_point'), l('global.number.thousands_separator')) . 'M';

                $touched = true;
            }
        }

        if (!$touched && (!is_array($extra) || (is_array($extra) && in_array('K', $extra)))) {

            if ($number > 999) {
                $formatted_number = number_format($number / 1000, $decimals, l('global.number.decimal_point'), l('global.number.thousands_separator')) . 'K';

                $touched = true;
            }
        }

        if ($decimals > 0) {
            $dotzero = '.' . str_repeat('0', $decimals);
            $formatted_number = str_replace($dotzero, '', $formatted_number);
        }

        return $formatted_number;
    }

    if ($number == 0) {
        return 0;
    }

    return number_format($number, $decimals, l('global.number.decimal_point'), l('global.number.thousands_separator'));
}

function get_ip()
{
    if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)) {

        if (mb_strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',')) {
            $ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);

            return trim(reset($ips));
        } else {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
    } else if (array_key_exists('REMOTE_ADDR', $_SERVER)) {
        return $_SERVER['REMOTE_ADDR'];
    } else if (array_key_exists('HTTP_CLIENT_IP', $_SERVER)) {
        return $_SERVER['HTTP_CLIENT_IP'];
    }

    return '';
}

function get_device_type($user_agent)
{
    $mobile_regex = '/(?:phone|windows\s+phone|ipod|blackberry|(?:android|bb\d+|meego|silk|googlebot) .+? mobile|palm|windows\s+ce|opera mini|avantgo|mobilesafari|docomo)/i';
    $tablet_regex = '/(?:ipad|playbook|(?:android|bb\d+|meego|silk)(?! .+? mobile))/i';

    if (preg_match_all($mobile_regex, $user_agent)) {
        return 'mobile';
    } else {

        if (preg_match_all($tablet_regex, $user_agent)) {
            return 'tablet';
        } else {
            return 'desktop';
        }
    }
}

function process_export_json($array_of_objects, $type = '', $type_array = [], $file_name = 'data')
{

    if (isset($_GET['export']) && $_GET['export'] == 'json') {
        //ALTUMCODE:DEMO if(DEMO) exit('This command is blocked on the demo.');

        header('Content-Disposition: attachment; filename="' . $file_name . '.json";');
        header('Content-Type: application/json; charset=UTF-8');

        $json = json_exporter($array_of_objects, $type, $type_array);

        die($json);
    }
}

function json_exporter($array_of_objects, $type = 'basic', $type_array = [])
{

    foreach ($array_of_objects as $object) {

        foreach ($object as $key => $value) {

            if (($type == 'exclude' && in_array($key, $type_array)) || ($type == 'include' && !in_array($key, $type_array))) {
                unset($object->{$key});
            }
        }
    }

    return json_encode($array_of_objects);
}

function process_export_csv($array, $type = '', $type_array = [], $file_name = 'data')
{

    if (isset($_GET['export']) && $_GET['export'] == 'csv') {
        //ALTUMCODE:DEMO if(DEMO) exit('This command is blocked on the demo.');

        header('Content-Disposition: attachment; filename="' . $file_name . '.csv";');
        header('Content-Type: application/csv; charset=UTF-8');

        $csv = csv_exporter($array, $type, $type_array);

        die($csv);
    }
}

function csv_exporter($array, $type = 'basic', $type_array = [])
{

    $result = '';

    /* Export the header */
    $headers = [];
    foreach (array_keys((array) reset($array)) as $value) {
        /* Check if not excluded */
        if (($type == 'exclude' && !in_array($value, $type_array)) || ($type == 'include' && in_array($value, $type_array)) || $type == 'basic') {
            $headers[] = '"' . $value . '"';
        }
    }

    $result .= implode(',', $headers);

    /* Data */
    foreach ($array as $row) {
        $result .= "\n";

        $row_array = [];

        foreach ($row as $key => $value) {
            /* Check if not excluded */
            if (($type == 'exclude' && !in_array($key, $type_array)) || ($type == 'include' && in_array($key, $type_array)) || $type == 'basic') {
                $row_array[] = '"' . addslashes($value) . '"';
            }
        }

        $result .= implode(',', $row_array);
    }

    return $result;
}

function csv_link_exporter($csv)
{
    return 'data:application/csv;charset=utf-8,' . urlencode($csv);
}

function get_countries_array()
{
    return [
        'AF' => 'Afghanistan',
        'AX' => 'Aland Islands',
        'AL' => 'Albania',
        'DZ' => 'Algeria',
        'AS' => 'American Samoa',
        'AD' => 'Andorra',
        'AO' => 'Angola',
        'AI' => 'Anguilla',
        'AQ' => 'Antarctica',
        'AG' => 'Antigua and Barbuda',
        'AR' => 'Argentina',
        'AM' => 'Armenia',
        'AW' => 'Aruba',
        'AU' => 'Australia',
        'AT' => 'Austria',
        'AZ' => 'Azerbaijan',
        'BS' => 'Bahamas',
        'BH' => 'Bahrain',
        'BD' => 'Bangladesh',
        'BB' => 'Barbados',
        'BY' => 'Belarus',
        'BE' => 'Belgium',
        'BZ' => 'Belize',
        'BJ' => 'Benin',
        'BM' => 'Bermuda',
        'BT' => 'Bhutan',
        'BO' => 'Bolivia',
        'BQ' => 'Bonaire, Saint Eustatius and Saba',
        'BA' => 'Bosnia and Herzegovina',
        'BW' => 'Botswana',
        'BV' => 'Bouvet Island',
        'BR' => 'Brazil',
        'IO' => 'British Indian Ocean Territory',
        'VG' => 'British Virgin Islands',
        'BN' => 'Brunei',
        'BG' => 'Bulgaria',
        'BF' => 'Burkina Faso',
        'BI' => 'Burundi',
        'KH' => 'Cambodia',
        'CM' => 'Cameroon',
        'CA' => 'Canada',
        'CV' => 'Cape Verde',
        'KY' => 'Cayman Islands',
        'CF' => 'Central African Republic',
        'TD' => 'Chad',
        'CL' => 'Chile',
        'CN' => 'China',
        'CX' => 'Christmas Island',
        'CC' => 'Cocos Islands',
        'CO' => 'Colombia',
        'KM' => 'Comoros',
        'CK' => 'Cook Islands',
        'CR' => 'Costa Rica',
        'HR' => 'Croatia',
        'CU' => 'Cuba',
        'CW' => 'Curacao',
        'CY' => 'Cyprus',
        'CZ' => 'Czech Republic',
        'CD' => 'Democratic Republic of the Congo',
        'DK' => 'Denmark',
        'DJ' => 'Djibouti',
        'DM' => 'Dominica',
        'DO' => 'Dominican Republic',
        'TL' => 'East Timor',
        'EC' => 'Ecuador',
        'EG' => 'Egypt',
        'SV' => 'El Salvador',
        'GQ' => 'Equatorial Guinea',
        'ER' => 'Eritrea',
        'EE' => 'Estonia',
        'ET' => 'Ethiopia',
        'FK' => 'Falkland Islands',
        'FO' => 'Faroe Islands',
        'FJ' => 'Fiji',
        'FI' => 'Finland',
        'FR' => 'France',
        'GF' => 'French Guiana',
        'PF' => 'French Polynesia',
        'TF' => 'French Southern Territories',
        'GA' => 'Gabon',
        'GM' => 'Gambia',
        'GE' => 'Georgia',
        'DE' => 'Germany',
        'GH' => 'Ghana',
        'GI' => 'Gibraltar',
        'GR' => 'Greece',
        'GL' => 'Greenland',
        'GD' => 'Grenada',
        'GP' => 'Guadeloupe',
        'GU' => 'Guam',
        'GT' => 'Guatemala',
        'GG' => 'Guernsey',
        'GN' => 'Guinea',
        'GW' => 'Guinea-Bissau',
        'GY' => 'Guyana',
        'HT' => 'Haiti',
        'HM' => 'Heard Island and McDonald Islands',
        'HN' => 'Honduras',
        'HK' => 'Hong Kong',
        'HU' => 'Hungary',
        'IS' => 'Iceland',
        'IN' => 'India',
        'ID' => 'Indonesia',
        'IR' => 'Iran',
        'IQ' => 'Iraq',
        'IE' => 'Ireland',
        'IM' => 'Isle of Man',
        'IL' => 'Israel',
        'IT' => 'Italy',
        'CI' => 'Ivory Coast',
        'JM' => 'Jamaica',
        'JP' => 'Japan',
        'JE' => 'Jersey',
        'JO' => 'Jordan',
        'KZ' => 'Kazakhstan',
        'KE' => 'Kenya',
        'KI' => 'Kiribati',
        'XK' => 'Kosovo',
        'KW' => 'Kuwait',
        'KG' => 'Kyrgyzstan',
        'LA' => 'Laos',
        'LV' => 'Latvia',
        'LB' => 'Lebanon',
        'LS' => 'Lesotho',
        'LR' => 'Liberia',
        'LY' => 'Libya',
        'LI' => 'Liechtenstein',
        'LT' => 'Lithuania',
        'LU' => 'Luxembourg',
        'MO' => 'Macao',
        'MK' => 'Macedonia',
        'MG' => 'Madagascar',
        'MW' => 'Malawi',
        'MY' => 'Malaysia',
        'MV' => 'Maldives',
        'ML' => 'Mali',
        'MT' => 'Malta',
        'MH' => 'Marshall Islands',
        'MQ' => 'Martinique',
        'MR' => 'Mauritania',
        'MU' => 'Mauritius',
        'YT' => 'Mayotte',
        'MX' => 'Mexico',
        'FM' => 'Micronesia',
        'MD' => 'Moldova',
        'MC' => 'Monaco',
        'MN' => 'Mongolia',
        'ME' => 'Montenegro',
        'MS' => 'Montserrat',
        'MA' => 'Morocco',
        'MZ' => 'Mozambique',
        'MM' => 'Myanmar',
        'NA' => 'Namibia',
        'NR' => 'Nauru',
        'NP' => 'Nepal',
        'NL' => 'Netherlands',
        'NC' => 'New Caledonia',
        'NZ' => 'New Zealand',
        'NI' => 'Nicaragua',
        'NE' => 'Niger',
        'NG' => 'Nigeria',
        'NU' => 'Niue',
        'NF' => 'Norfolk Island',
        'KP' => 'North Korea',
        'MP' => 'Northern Mariana Islands',
        'NO' => 'Norway',
        'OM' => 'Oman',
        'PK' => 'Pakistan',
        'PW' => 'Palau',
        'PS' => 'Palestinian Territory',
        'PA' => 'Panama',
        'PG' => 'Papua New Guinea',
        'PY' => 'Paraguay',
        'PE' => 'Peru',
        'PH' => 'Philippines',
        'PN' => 'Pitcairn',
        'PL' => 'Poland',
        'PT' => 'Portugal',
        'PR' => 'Puerto Rico',
        'QA' => 'Qatar',
        'CG' => 'Republic of the Congo',
        'RE' => 'Reunion',
        'RO' => 'Romania',
        'RU' => 'Russia',
        'RW' => 'Rwanda',
        'BL' => 'Saint Barthelemy',
        'SH' => 'Saint Helena',
        'KN' => 'Saint Kitts and Nevis',
        'LC' => 'Saint Lucia',
        'MF' => 'Saint Martin',
        'PM' => 'Saint Pierre and Miquelon',
        'VC' => 'Saint Vincent and the Grenadines',
        'WS' => 'Samoa',
        'SM' => 'San Marino',
        'ST' => 'Sao Tome and Principe',
        'SA' => 'Saudi Arabia',
        'SN' => 'Senegal',
        'RS' => 'Serbia',
        'SC' => 'Seychelles',
        'SL' => 'Sierra Leone',
        'SG' => 'Singapore',
        'SX' => 'Sint Maarten',
        'SK' => 'Slovakia',
        'SI' => 'Slovenia',
        'SB' => 'Solomon Islands',
        'SO' => 'Somalia',
        'ZA' => 'South Africa',
        'GS' => 'South Georgia and the South Sandwich Islands',
        'KR' => 'South Korea',
        'SS' => 'South Sudan',
        'ES' => 'Spain',
        'LK' => 'Sri Lanka',
        'SD' => 'Sudan',
        'SR' => 'Suriname',
        'SJ' => 'Svalbard and Jan Mayen',
        'SZ' => 'Swaziland',
        'SE' => 'Sweden',
        'CH' => 'Switzerland',
        'SY' => 'Syria',
        'TW' => 'Taiwan',
        'TJ' => 'Tajikistan',
        'TZ' => 'Tanzania',
        'TH' => 'Thailand',
        'TG' => 'Togo',
        'TK' => 'Tokelau',
        'TO' => 'Tonga',
        'TT' => 'Trinidad and Tobago',
        'TN' => 'Tunisia',
        'TR' => 'Turkey',
        'TM' => 'Turkmenistan',
        'TC' => 'Turks and Caicos Islands',
        'TV' => 'Tuvalu',
        'VI' => 'U.S. Virgin Islands',
        'UG' => 'Uganda',
        'UA' => 'Ukraine',
        'AE' => 'United Arab Emirates',
        'GB' => 'United Kingdom',
        'US' => 'United States',
        'UM' => 'United States Minor Outlying Islands',
        'UY' => 'Uruguay',
        'UZ' => 'Uzbekistan',
        'VU' => 'Vanuatu',
        'VA' => 'Vatican',
        'VE' => 'Venezuela',
        'VN' => 'Vietnam',
        'WF' => 'Wallis and Futuna',
        'EH' => 'Western Sahara',
        'YE' => 'Yemen',
        'ZM' => 'Zambia',
        'ZW' => 'Zimbabwe',
    ];
}

function get_country_from_country_code($code)
{
    $code = mb_strtoupper($code);

    $country_list = get_countries_array();

    if (!isset($country_list[$code])) {
        return $code;
    } else {
        return $country_list[$code];
    }
}

function get_locale_languages_array()
{
    return [
        'ab' => 'Abkhazian',
        'aa' => 'Afar',
        'af' => 'Afrikaans',
        'ak' => 'Akan',
        'sq' => 'Albanian',
        'am' => 'Amharic',
        'ar' => 'Arabic',
        'an' => 'Aragonese',
        'hy' => 'Armenian',
        'as' => 'Assamese',
        'av' => 'Avaric',
        'ae' => 'Avestan',
        'ay' => 'Aymara',
        'az' => 'Azerbaijani',
        'bm' => 'Bambara',
        'ba' => 'Bashkir',
        'eu' => 'Basque',
        'be' => 'Belarusian',
        'bn' => 'Bengali',
        'bh' => 'Bihari languages',
        'bi' => 'Bislama',
        'bs' => 'Bosnian',
        'br' => 'Breton',
        'bg' => 'Bulgarian',
        'my' => 'Burmese',
        'ca' => 'Catalan, Valencian',
        'km' => 'Central Khmer',
        'ch' => 'Chamorro',
        'ce' => 'Chechen',
        'ny' => 'Chichewa, Chewa, Nyanja',
        'zh' => 'Chinese',
        'cu' => 'Church Slavonic, Old Bulgarian, Old Church Slavonic',
        'cv' => 'Chuvash',
        'kw' => 'Cornish',
        'co' => 'Corsican',
        'cr' => 'Cree',
        'hr' => 'Croatian',
        'cs' => 'Czech',
        'da' => 'Danish',
        'dv' => 'Divehi, Dhivehi, Maldivian',
        'nl' => 'Dutch, Flemish',
        'dz' => 'Dzongkha',
        'en' => 'English',
        'eo' => 'Esperanto',
        'et' => 'Estonian',
        'ee' => 'Ewe',
        'fo' => 'Faroese',
        'fj' => 'Fijian',
        'fi' => 'Finnish',
        'fr' => 'French',
        'ff' => 'Fulah',
        'gd' => 'Gaelic, Scottish Gaelic',
        'gl' => 'Galician',
        'lg' => 'Ganda',
        'ka' => 'Georgian',
        'de' => 'German',
        'ki' => 'Gikuyu, Kikuyu',
        'el' => 'Greek (Modern)',
        'kl' => 'Greenlandic, Kalaallisut',
        'gn' => 'Guarani',
        'gu' => 'Gujarati',
        'ht' => 'Haitian, Haitian Creole',
        'ha' => 'Hausa',
        'he' => 'Hebrew',
        'hz' => 'Herero',
        'hi' => 'Hindi',
        'ho' => 'Hiri Motu',
        'hu' => 'Hungarian',
        'is' => 'Icelandic',
        'io' => 'Ido',
        'ig' => 'Igbo',
        'id' => 'Indonesian',
        'ia' => 'Interlingua (International Auxiliary Language Association)',
        'ie' => 'Interlingue',
        'iu' => 'Inuktitut',
        'ik' => 'Inupiaq',
        'ga' => 'Irish',
        'it' => 'Italian',
        'ja' => 'Japanese',
        'jv' => 'Javanese',
        'kn' => 'Kannada',
        'kr' => 'Kanuri',
        'ks' => 'Kashmiri',
        'kk' => 'Kazakh',
        'rw' => 'Kinyarwanda',
        'kv' => 'Komi',
        'kg' => 'Kongo',
        'ko' => 'Korean',
        'kj' => 'Kwanyama, Kuanyama',
        'ku' => 'Kurdish',
        'ky' => 'Kyrgyz',
        'lo' => 'Lao',
        'la' => 'Latin',
        'lv' => 'Latvian',
        'lb' => 'Letzeburgesch, Luxembourgish',
        'li' => 'Limburgish, Limburgan, Limburger',
        'ln' => 'Lingala',
        'lt' => 'Lithuanian',
        'lu' => 'Luba-Katanga',
        'mk' => 'Macedonian',
        'mg' => 'Malagasy',
        'ms' => 'Malay',
        'ml' => 'Malayalam',
        'mt' => 'Maltese',
        'gv' => 'Manx',
        'mi' => 'Maori',
        'mr' => 'Marathi',
        'mh' => 'Marshallese',
        'ro' => 'Moldovan, Moldavian, Romanian',
        'mn' => 'Mongolian',
        'na' => 'Nauru',
        'nv' => 'Navajo, Navaho',
        'nd' => 'Northern Ndebele',
        'ng' => 'Ndonga',
        'ne' => 'Nepali',
        'se' => 'Northern Sami',
        'no' => 'Norwegian',
        'nb' => 'Norwegian Bokmål',
        'nn' => 'Norwegian Nynorsk',
        'ii' => 'Nuosu, Sichuan Yi',
        'oc' => 'Occitan (post 1500)',
        'oj' => 'Ojibwa',
        'or' => 'Oriya',
        'om' => 'Oromo',
        'os' => 'Ossetian, Ossetic',
        'pi' => 'Pali',
        'pa' => 'Panjabi, Punjabi',
        'ps' => 'Pashto, Pushto',
        'fa' => 'Persian',
        'pl' => 'Polish',
        'pt' => 'Portuguese',
        'qu' => 'Quechua',
        'rm' => 'Romansh',
        'rn' => 'Rundi',
        'ru' => 'Russian',
        'sm' => 'Samoan',
        'sg' => 'Sango',
        'sa' => 'Sanskrit',
        'sc' => 'Sardinian',
        'sr' => 'Serbian',
        'sn' => 'Shona',
        'sd' => 'Sindhi',
        'si' => 'Sinhala, Sinhalese',
        'sk' => 'Slovak',
        'sl' => 'Slovenian',
        'so' => 'Somali',
        'st' => 'Sotho, Southern',
        'nr' => 'South Ndebele',
        'es' => 'Spanish, Castilian',
        'su' => 'Sundanese',
        'sw' => 'Swahili',
        'ss' => 'Swati',
        'sv' => 'Swedish',
        'tl' => 'Tagalog',
        'ty' => 'Tahitian',
        'tg' => 'Tajik',
        'ta' => 'Tamil',
        'tt' => 'Tatar',
        'te' => 'Telugu',
        'th' => 'Thai',
        'bo' => 'Tibetan',
        'ti' => 'Tigrinya',
        'to' => 'Tonga (Tonga Islands)',
        'ts' => 'Tsonga',
        'tn' => 'Tswana',
        'tr' => 'Turkish',
        'tk' => 'Turkmen',
        'tw' => 'Twi',
        'ug' => 'Uighur, Uyghur',
        'uk' => 'Ukrainian',
        'ur' => 'Urdu',
        'uz' => 'Uzbek',
        've' => 'Venda',
        'vi' => 'Vietnamese',
        'vo' => 'Volap_k',
        'wa' => 'Walloon',
        'cy' => 'Welsh',
        'fy' => 'Western Frisian',
        'wo' => 'Wolof',
        'xh' => 'Xhosa',
        'yi' => 'Yiddish',
        'yo' => 'Yoruba',
        'za' => 'Zhuang, Chuang',
        'zu' => 'Zulu'
    ];
}

function get_language_from_locale($locale)
{
    $languages = get_locale_languages_array();

    if (!isset($languages[$locale])) {
        return $locale;
    } else {
        return $languages[$locale];
    }
}

/* Dump & die */
function dd($string = null)
{
    echo '<pre style="background: black;color: chartreuse;">';
    array_map(function ($string) {
        var_dump($string);
    }, func_get_args());
    die;
}

/*Js Console log*/
function ConsoleLog($value)
{
    if (is_array($value) || is_object($value)) {
        $val = json_encode($value);
    } else {
        $val = is_numeric($value) ? $value : "'" . str_replace('\\', '/', $value) . "'";
    }
    echo "<script>console.log($val)</script>";
}

/* Output in debug.log file */
function dil($string = null)
{
    ob_start();

    print_r($string);

    $content = ob_get_clean();

    error_log($content);
}

/* Quick include with parameters */
function include_view($view_path, $data = [])
{

    $data = (object) $data;

    ob_start();

    require $view_path;

    return ob_get_clean();
}

function get_max_upload()
{
    return min(convert_php_size_to_mb(ini_get('upload_max_filesize')), convert_php_size_to_mb(ini_get('post_max_size')));
}

function convert_php_size_to_mb($string)
{
    $suffix = mb_strtoupper(mb_substr($string, -1));

    if (!in_array($suffix, ['P', 'T', 'G', 'M', 'K'])) {
        return (int) $string;
    }

    $value = mb_substr($string, 0, -1);

    switch ($suffix) {
        case 'P':
            $value *= 1000 * 1000 * 100;
            break;
        case 'T':
            $value *= 1000 * 1000;
            break;
        case 'G':
            $value *= 1000;
            break;
        case 'M':
            /* :) */
            break;
        case 'K':
            $value = $value / 1000;
            break;
    }

    return (float) $value;
}

function get_formatted_bytes($bytes, $precision = 2)
{
    $units = ['B', 'KB', 'MB', 'GB', 'TB'];

    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1000));
    $pow = min($pow, count($units) - 1);
    $bytes /= pow(1000, $pow);

    return round($bytes, $precision) . ' ' . $units[$pow];
}

function get_percentage_change($old, $new)
{
    $old = (int) $old;
    $new = (int) $new;

    if ($old < 1) {
        $old = 0;
    }

    $difference = $new - $old;

    if ($difference == 0) {
        return 0;
    }

    if ($new == 0) {
        return 100;
    }

    return ($difference / $new) * 100;
}

function get_percentage_difference($old, $new)
{
    $old = (float) $old;
    $new = (float) $new;

    return ($old - $new) / $old * 100;
}

function hex_to_rgb($hex)
{


    preg_match("/^#{0,1}([0-9a-f]{1,6})$/i", $hex, $match);
    if (!isset($match[1])) {
        return false;
    }

    if (mb_strlen($match[1]) == 6) {
        list($r, $g, $b) = [$match[1][0] . $match[1][1], $match[1][2] . $match[1][3], $match[1][4] . $match[1][5]];
    } elseif (mb_strlen($match[1]) == 3) {
        list($r, $g, $b) = [$match[1][0] . $match[1][0], $match[1][1] . $match[1][1], $match[1][2] . $match[1][2]];
    } else if (mb_strlen($match[1]) == 2) {
        list($r, $g, $b) = [$match[1][0] . $match[1][1], $match[1][0] . $match[1][1], $match[1][0] . $match[1][1]];
    } else if (mb_strlen($match[1]) == 1) {
        list($r, $g, $b) = [$match[1] . $match[1], $match[1] . $match[1], $match[1] . $match[1]];
    } else {
        return false;
    }

    $color = [];
    $color['r'] = hexdec($r);
    $color['g'] = hexdec($g);
    $color['b'] = hexdec($b);

    return $color;
}


function user_language($user)
{
    if (APP_CONFIG == 'local') {

        $lang_code = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? mb_substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2) : null;

        if ($lang_code) {
            $browser_language = null;
            foreach (\Altum\Language::$languages as $key => $language) {
                if ($language['code'] == $lang_code) {
                    $browser_language = $language['name'];
                }
            }

            if ($browser_language) {
                if ('english' != $browser_language) {
                    $userLanguage   =  $browser_language;
                } else {
                    $userLanguage = $user->language;
                }
            }
        } else {
            $userLanguage  = $user->language;
        }
        return $userLanguage;
    } else {
        return settings()->main->default_language;
    }
}




// get user browser session id
function user_sessionId()
{

    if (isset($_COOKIE['_ga_' . GA_SESSION])) {
        $parts = explode('.', $_COOKIE['_ga_' . GA_SESSION]);
        if (isset($parts[2])) {
            $desiredNumber = $parts[2];
            return $desiredNumber;
        } else if (isset($_COOKIE['_ga_session_id'])) {
            return $_COOKIE['_ga_session_id'];
        } else {
            return null;
        }
    } else {
        if (isset($_COOKIE['_ga_session_id'])) {
            return $_COOKIE['_ga_session_id'];
        }

        return null;
    }
}

// browser avoid google ga_session_id and browser ga_client_id
function default_client_id()
{
    return uniqid();
}

function default_session_id()
{
    return uniqid();
}

function failed_qr_users()
{
    if (isset($_COOKIE['qr_uid']) && $_COOKIE['qr_uid']) {

        $qr_users_params  = array(
            'data' => array(
                'user_id'       => 'failed',
                'update_time'   => \Altum\Date::$date,
                'unique_id'     => 'failed',
            ),
            'where' => array(
                'column'   => 'qr_code_id',
                'value'    => $_COOKIE['qr_uid']
            ),
        );
        analytic_database('qr_users', 'update', $qr_users_params);
    }
}


function subscription_change($currentPlan, $planName)
{
    $subscriptionChange =  null;
    switch ($planName) {
        case "Monthly":
            if ($currentPlan == 'Annually' || $currentPlan == 'Quarterly') {
                $subscriptionChange = 'upgrade';
            }
            break;
        case "Annually":
            if ($currentPlan == 'Monthly' || $currentPlan == 'Quarterly') {
                $subscriptionChange = 'downgrade';
            }
            break;
        case "Quarterly":
            if ($currentPlan == 'Monthly') {
                $subscriptionChange = 'downgrade';
            } else if ($currentPlan == 'Annually') {
                $subscriptionChange = 'upgrade';
            }
            break;
        default:
            $subscriptionChange  = 'cancellation';
    }

    return $subscriptionChange;
}

function getRandomNumber()
{
    $data =  floor((int) microtime() + floor(rand() * 6789));
    return $data;
}

function session_unique_id()
{
    if (isset($_SESSION['unique_id'])) {
        return  $_SESSION['unique_id'];
    } else {
        return null;
    }
}


function get_client_id()
{
    // Get the cookie
    $ga_cookie = isset($_COOKIE["_ga"]) ? $_COOKIE["_ga"] : null;
    if ($ga_cookie) {
        // Get the domain name
        $domain_name = parse_url($_SERVER["HTTP_HOST"], PHP_URL_HOST);
        // Check if the domain name matches
        if (substr($ga_cookie[0], 0, strlen($domain_name)) == $domain_name) {

            if (isset($ga_cookie)) {
                $parts = explode('.', $ga_cookie);
                if (count($parts) >= 4 && $parts[0] === 'GA1') {
                    return $parts[2] . '.' . $parts[3];
                }
                return null;
            }
        } else {
            return null;
        }
    } else {
        return null;
    }
}

function get_user_currency($code)
{    
    $currency = db()->where('code', $code)->getOne('plan_prices');    
    if($currency){
        return true;
    }   
    return false;
}

function check_usd($code)
{
    $currencyArray =  [
        'USD', 'CAD', 'AUD'
    ];

    if (in_array($code, $currencyArray)) {
        return true;
    }
    return false;
}


function get_plan_price($id, $code)
{
    switch ($id) {
        case 1:
            $multiple = 1;
            break;
        case 2:
            $multiple = 12;
            break;
        case 3:
            $multiple = 3;
            break;
        default:
            $multiple = 1;
            break;
    }

    if (get_user_currency($code)) {
        $planPrice = db()->where('plan_id', $id)->where('code', $code)->getOne('plan_prices');
        $total = $planPrice->value * $multiple;
    } else {
        $plan = db()->where('plan_id', $id)->getOne('plans');
        $total = $plan->monthly_price * $multiple;
    }


    return $total;
}

function get_plan_month_price($id, $code)
{
    if (get_user_currency($code)) {
        $planPrice = db()->where('plan_id', $id)->where('code', $code)->getOne('plan_prices');
        $total = $planPrice->value;
    } else {
        $plan = db()->where('plan_id', $id)->getOne('plans');
        $total = $plan->monthly_price;
    }   
    return $total;
}

function decimal_number_format($number)
{

    if (strlen(strtok($number, ".")) < 4) {
        $formattedNumber = $number;
    } else {
        $formattedNumber = round($number, 0);; // Remove decimals for numbers > 4 digits
    }
    // return round ($formattedNumber * 20, 0) / 20; //Round to nearest 0.05

    return $formattedNumber;
}

function round_number_format($number)
{

    $num = decimal_number_format($number);

    $num = round($num * 20, 0) / 20;

    if (fmod($num, 1) !== 0.00) {
        $num =  number_format($num, 2, '.', ',');
    } elseif ($num > 999) {
        $num = number_format($num, 0, '.', ',');
    } else {
        $num = $num;
    }
    return $num;
}


function get_country_to_currency_array()
{
    return [
        'AD' => 'EUR',
        'AE' => 'AED',
        'AF' => 'AFN',
        'AG' => 'XCD',
        'AI' => 'XCD',
        'AL' => 'ALL',
        'AM' => 'AMD',
        'AO' => 'AOA',
        'AR' => 'ARS',
        'AS' => 'USD',
        'AU' => 'AUD',
        'AW' => 'AWG',
        'AX' => 'EUR',
        'AZ' => 'AZN',
        'BA' => 'BAM',
        'BB' => 'BBD',
        'BD' => 'BDT',
        'BE' => 'EUR',
        'BF' => 'XOF',
        'BG' => 'BGN',
        'BH' => 'BHD',
        'BI' => 'BIF',
        'BJ' => 'XOF',
        'BL' => 'EUR',
        'BM' => 'BMD',
        'BN' => 'BND',
        'BO' => 'BOB',
        'BQ' => 'USD',
        'BR' => 'BRL',
        'BS' => 'BSD',
        'BT' => 'BTN',
        'BV' => 'NOK',
        'BW' => 'BWP',
        'BY' => 'BYR',
        'BZ' => 'BZD',
        'CA' => 'USD',
        'CC' => 'AUD',
        'CD' => 'XAF',
        'CG' => 'XAF',
        'CH' => 'CHF',
        'CI' => 'XOF',
        'CK' => 'NZD',
        'CL' => 'CLP',
        'CM' => 'XAF',
        'CN' => 'CNY',
        'CO' => 'COP',
        'CR' => 'CRC',
        'CU' => 'CUP',
        'CV' => 'CVE',
        'CW' => 'ANG',
        'CX' => 'AUD',
        'CY' => 'EUR',
        'CZ' => 'CZK',
        'DE' => 'EUR',
        'DJ' => 'DJF',
        'DK' => 'DKK',
        'DM' => 'XCD',
        'DO' => 'DOP',
        'DZ' => 'DZD',
        'EC' => 'USD',
        'EE' => 'EUR',
        'EG' => 'EGP',
        'EH' => 'MAD',
        'ER' => 'ERN',
        'ES' => 'EUR',
        'ET' => 'ETB',
        'FI' => 'EUR',
        'FJ' => 'FJD',
        'FK' => 'FKP',
        'FM' => 'USD',
        'FO' => 'DKK',
        'FR' => 'EUR',
        'GA' => 'XAF',
        'GB' => 'GBP',
        'GD' => 'XCD',
        'GE' => 'GEL',
        'GF' => 'EUR',
        'GG' => 'GBP',
        'GH' => 'GHS',
        'GI' => 'GIP',
        'GL' => 'DKK',
        'GM' => 'GMD',
        'GN' => 'GNF',
        'GP' => 'EUR',
        'GQ' => 'XAF',
        'GR' => 'EUR',
        'GS' => 'GBP',
        'GT' => 'GTQ',
        'GU' => 'USD',
        'GW' => 'XOF',
        'GY' => 'GYD',
        'HK' => 'HKD',
        'HM' => 'AUD',
        'HN' => 'HNL',
        'HR' => 'HRK',
        'HT' => 'HTG',
        'HU' => 'HUF',
        'ID' => 'IDR',
        'IE' => 'EUR',
        'IL' => 'ILS',
        'IM' => 'GBP',
        'IN' => 'INR',
        'IO' => 'USD',
        'IQ' => 'IRR',
        'IS' => 'ISK',
        'IT' => 'EUR',
        'JE' => 'GBP',
        'JM' => 'JMD',
        'JO' => 'JOD',
        'JP' => 'JPY',
        'KE' => 'KES',
        'KG' => 'KGS',
        'KH' => 'KHR',
        'KI' => 'AUD',
        'KM' => 'KMF',
        'KN' => 'XCD',
        'KP' => 'KPW',
        'KR' => 'KRW',
        'KW' => 'KWD',
        'KY' => 'KYD',
        'KZ' => 'KZT',
        'LA' => 'LAK',
        'LB' => 'LBP',
        'LC' => 'XCD',
        'LI' => 'CHF',
        'LK' => 'LKR',
        'LR' => 'LRD',
        'LS' => 'LSL',
        'LT' => 'EUR',
        'LU' => 'EUR',
        'LV' => 'EUR',
        'LY' => 'LYD',
        'MA' => 'MAD',
        'MC' => 'MAD',
        'MC' => 'EUR',
        'MD' => 'MDL',
        'ME' => 'EUR',
        'MF' => 'EUR',
        'MG' => 'MGA',
        'MH' => 'USD',
        'MK' => 'MKD',
        'ML' => 'XOF',
        'MM' => 'MMK',
        'MN' => 'MNT',
        'MO' => 'MOP',
        'MP' => 'USD',
        'MQ' => 'EUR',
        'MR' => 'MRO',
        'MS' => 'XCD',
        'MT' => 'EUR',
        'MU' => 'MUR',
        'MV' => 'MVR',
        'MW' => 'MWK',
        'MX' => 'MXN',
        'MY' => 'MYR',
        'MZ' => 'MZN',
        'NA' => 'NAD',
        'NC' => 'XPF',
        'NE' => 'XOF',
        'NF' => 'AUD',
        'NG' => 'NGN',
        'NI' => 'NIO',
        'NL' => 'EUR',
        'NO' => 'NOK',
        'NP' => 'NPR',
        'NR' => 'AUD',
        'NU' => 'NZD',
        'NZ' => 'NZD',
        'OM' => 'OMR',
        'PA' => 'PAB',
        'PE' => 'PEN',
        'PF' => 'XPF',
        'PG' => 'PGK',
        'PH' => 'PHP',
        'PK' => 'PKR',
        "PL" => "PLN",
        "PM" => "EUR",
        "PN" => "NZD",
        "PR" => "USD",
        "PS" => "ILS",
        "PT" => "EUR",
        "PW" => "USD",
        "PY" => "PYG",
        "QA" => "QAR",
        "RE" => "EUR",
        "RO" => "RON",
        "RS" => "RSD",
        "RU" => "RUB",
        "RW" => "RWF",
        "SA" => "SAR",
        "SB" => "SBD",
        "SC" => "SCR",
        "SD" => "SDG",
        "SE" => "SEK",
        "SG" => "SGD",
        "SH" => "SHP",
        "SI" => "EUR",
        "SJ" => "NOK",
        "SK" => "EUR",
        "SL" => "SLL",
        "SM" => "EUR",
        "SN" => "XOF",
        "SO" => "SOS",
        "SR" => "SRD",
        "SS" => "SSP",
        "ST" => "STD",
        "SV" => "USD",
        "SX" => "ANG",
        "SY" => "SYP",
        "SZ" => "SZL",
        "TC" => "USD",
        "TD" => "XAF",
        "TF" => "EUR",
        "TG" => "XOF",
        "TH" => "THB",
        "TJ" => "TJS",
        "TK" => "NZD",
        "TL" => "USD",
        "TM" => "TMT",
        "TN" => "TND",
        "TO" => "TOP",
        "TR" => "TRY",
        "TT" => "TTD",
        "TV" => "AUD",
        "TW" => "TWD",
        "TZ" => "TZS",
        "UA" => "UAH",
        "UG" => "UGX",
        "UM" => "USD",
        "US" => "USD",
        "UY" => "UYU",
        "UZ" => "UZS",
        "VA" => "EUR",
        "VC" => "XCD",
        "VE" => "VEF",
        "VG" => "USD",
        "VI" => "USD",
        "VN" => "VND",
        "VU" => "VUV",
        "WF" => "XPF",
        "WS" => "WST",
        "XK" => "EUR",
        "YE" => "YER",
        "YT" => "EUR",
        "ZA" => "ZAR",
        "ZM" => "ZMW",
        "ZW" => "ZWL",
    ];
}

function promo_email_trigger($user_id, $type)
{
    $user  = db()->where('user_id', $user_id)->where('plan_id', 'free')->getOne('users');
    if ($user) {
        $promo_email  = db()->where('user_id', $user_id)->getOne('promo_email_rules');
        $is_one_day_expire_remind = db()->where('user_id', $user_id)->getOne('user_emails')->is_trial_1day_email;

        if ($is_one_day_expire_remind == 1) {
            switch ($type) {

                case 'pricing':
                    if ($promo_email && $promo_email->type == '') {
                        $first_email_trigger_date  =  (new \DateTime())->modify('+5 days')->format('Y-m-d H:i:s');
                        $second_email_trigger_date =  (new \DateTime())->modify('+8 days')->format('Y-m-d H:i:s');

                        db()->where('user_id', $user_id)->update('promo_email_rules', [
                            'type'                        => $type,
                            'first_email_date'    => $first_email_trigger_date,
                            'second_email_date'   => $second_email_trigger_date,
                        ]);
                    }

                    break;

                case 'checkout':

                    $first_email_trigger_date  =  (new \DateTime())->modify('+24 hours')->format('Y-m-d H:i:s');
                    $second_email_trigger_date =  (new \DateTime($first_email_trigger_date))->modify('+3 days')->format('Y-m-d H:i:s');

                    if ($promo_email && $promo_email->type == 'pricing') {

                        if (!$promo_email->is_first_email) {
                            db()->where('user_id', $user_id)->update('promo_email_rules', [
                                'type'                        => $type,
                                'first_email_date'    => $first_email_trigger_date,
                                'second_email_date'   => $second_email_trigger_date,
                            ]);
                        } else if ($promo_email->is_first_email && !$promo_email->is_second_email) {

                            db()->where('user_id', $user_id)->update('promo_email_rules', [
                                'type'                => $type,
                                'second_email_date'   => (new \DateTime())->modify('+3 days')->format('Y-m-d H:i:s'),
                            ]);
                        }
                    }

                    break;

                default:
                    break;
            }
        }
    } else {
        //for dpf users
        $dpf_user_email = db()->where('user_id', $user_id)->where('is_trial_payment', 1)->where('is_trial_cancel', 1)->where('is_trial_1day_email', 1)->getOne('dpf_user_emails');
        if ($dpf_user_email) {
            $user    =  database()->query("SELECT * FROM `users` WHERE `user_id` = {$user_id} AND `payment_subscription_id` IS NULL")->fetch_object();
            $promo_email  = db()->where('user_id', $user_id)->getOne('promo_email_rules');
            if ($user && $promo_email) {
                switch ($type) {
                    case 'pricing':
                        if ($promo_email->type == 'purchase') {
                            $first_email_trigger_date  =  (new \DateTime())->modify('+5 days')->format('Y-m-d H:i:s');
                            $second_email_trigger_date =  (new \DateTime())->modify('+8 days')->format('Y-m-d H:i:s');

                            db()->where('user_id', $user_id)->update('promo_email_rules', [
                                'type'                => $type,
                                'first_email_date'    => $first_email_trigger_date,
                                'second_email_date'   => $second_email_trigger_date,
                            ]);
                        }
                        break;

                    case 'checkout':

                        $first_email_trigger_date  =  (new \DateTime())->modify('+24 hours')->format('Y-m-d H:i:s');
                        $second_email_trigger_date =  (new \DateTime($first_email_trigger_date))->modify('+3 days')->format('Y-m-d H:i:s');

                        if ($promo_email->type == 'pricing') {
                            if (!$promo_email->is_first_email) {
                                db()->where('user_id', $user_id)->update('promo_email_rules', [
                                    'type'                => $type,
                                    'first_email_date'    => $first_email_trigger_date,
                                    'second_email_date'   => $second_email_trigger_date,
                                ]);
                            } else if ($promo_email->is_first_email && !$promo_email->is_second_email) {

                                db()->where('user_id', $user_id)->update('promo_email_rules', [
                                    'type'                => $type,
                                    'second_email_date'   => (new \DateTime())->modify('+3 days')->format('Y-m-d H:i:s'),
                                ]);
                            }
                        }
                        break;

                    default:
                        break;
                }
            }
        }
    }
}

function onboarding_funnel($url_components, $userId)
{
    parse_str(isset($url_components['query']) ? $url_components['query'] : '', $params);

    $aciveNsf        =  isset($params['qr_onboarding']) ? $params['qr_onboarding'] == 'active_nsf' : false;
    $activeDpf       =  isset($params['qr_onboarding']) ? $params['qr_onboarding'] == 'active_dpf' : false;

    $currentUrl      = SITE_URL . \Altum\Routing\Router::$original_request;

    if ($userId) {
        $totalQrCode = database()->query("SELECT COUNT(*) AS `qr_code_id` FROM `qr_codes` WHERE `user_id` = {$userId}")->fetch_object()->qr_code_id ?? 0;
    }

    if ($aciveNsf) {
        return 2;
    } else if ($activeDpf) {
        return 3;
    } else if ($currentUrl == url('create')) {
        return 2;
    } else if (isset($userId) && $totalQrCode == 0) {
        return 1;
    } else {
        return 0;
    }
}

function dpf_plan_price($price, $rate, $code, $symbol)
{

    if ($rate && $symbol && $price) {

        if (check_usd($code)) {
            return  number_format($price, 2, '.', ',');
        } else {

            $userPrice            = number_format($price * $rate, 2, '.', ',');
            $newPrice             = str_replace(',', '', $userPrice);
            $numberWithoutDecimal = intval($newPrice); // Remove the decimal part
            $digitsCount          = strlen((string)$numberWithoutDecimal);

            if ($digitsCount >= 4) {
                return number_format($price * $rate, 0, '.', ',');
            } else {
                return  number_format($price * $rate, 2, '.', ',');
            }
        }
    } else {
        return  number_format($price, 2, '.', ',');
    }
}

function analytic_database($table, $method, $params)
{

    switch ($table) {
        case 'qr_users':

            $endpoint = 'qr-users';

            $data  = array(
                'method' => $method,
                'params' => $params,
            );

            return api_endpoint($endpoint, $data);

            break;
        case 'sessions':

            $endpoint = 'sessions';

            $data  = array(
                'method' => $method,
                'params' => $params,
            );

            return api_endpoint($endpoint, $data);
            break;
        case 'users':

            $endpoint = 'users';

            $data  = array(
                'method' => $method,
                'params' => $params,
            );

            return api_endpoint($endpoint, $data);
            break;
        case 'registered_users':

            $endpoint = 'registered-users';

            $data  = array(
                'method' => $method,
                'params' => $params,
            );

            return api_endpoint($endpoint, $data);
            break;
        case 'subscription_users':
            $endpoint = 'subscription-users';

            $data  = array(
                'method' => $method,
                'params' => $params,
            );

            return api_endpoint($endpoint, $data);

            break;
        case 'email_users':
            $endpoint = 'email-users';

            $data  = array(
                'method' => $method,
                'params' => $params,
            );

            return api_endpoint($endpoint, $data);
            break;
        case 'conversion_data':
            $endpoint = 'conversion-data';

            $data  = array(
                'method' => $method,
                'params' => $params,
            );

            return api_endpoint($endpoint, $data);
            break;
        default:

            break;
    }
}

function api_endpoint($endpoint, $data)
{

    try {
        $endpoint = ANALYTIC_API . "api/" . $endpoint;
        // Convert data to JSON
        $data_string = json_encode($data);

        // Create cURL request
        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json'
        ));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


        // Execute the request
        $response = curl_exec($ch);

        // Check for errors
        if (curl_errno($ch)) {
            dil('Api Error: ' . curl_error($ch));
        } else {
        }

        $result = json_decode($response, true);

        if (isset($result)) {
            if ($result['success'] ==  true) {
                $data = [
                    'error'    => false,
                    'complete' => true,
                ];
                return  $data;
            } else {
                $data = [
                    'error'    => $result['error'],
                    'complete' => false,
                ];
                dil($result['error']);
                return $data;
            }
        }

        // Close cURL
        curl_close($ch);
    } catch (\Exception $e) {
        dil('Analytics API error');
    }
}

// Start Email server request

function trigger_email($userId, $template, $link = null, $code = null)
{
    $user = db()->where('user_id', $userId)->getOne('users');

    $emailTemplates = [
        'reset-password', 'admin-contact', 'change-password', 'verification-code', 'email-change', 'share-qrcode', 'subscription-canceled', 'new-subscription', 'declined-payment',
    ];

    $payment_currency = 'USD';

    if ($user->payment_currency && $user->payment_currency != '') {
        $payment_currency = $user->payment_currency;
    } else {
        $countryCurrency = get_user_currency($user->currency_code);
        if ($countryCurrency) {
            $payment_currency = $user->currency_code;
        }
    }

    if ($user) {

        $language =  isset(\Altum\Language::$active_languages[$user->language]) && \Altum\Language::$active_languages[$user->language] ? \Altum\Language::$active_languages[$user->language] : 'en';

        if (!in_array($template, $emailTemplates)) {
            $data  = array(
                'email'              => $user->email,
                'user_id'            => $user->user_id,
                'template'           => $template,
                'user_name'          => $user->name,
                'anti_phishing_code' => $user->anti_phishing_code,
                'referral_key'       => $user->referral_key,
                'country'            => $user->country,
                'currency_code'      => $payment_currency,
                'link'               => $link,
                'language'           => $language,
                'is_queue'           => true,
            );

            $endpoint = EMAIL_API . "api/queue-mails";
            return email_api_endpoint($endpoint, $data);
        } else {
            $data  = array(
                'email'              => $user->email,
                'user_id'            => $user->user_id,
                'template'           => $template,
                'user_name'          => $user->name,
                'anti_phishing_code' => $user->anti_phishing_code,
                'referral_key'       => $user->referral_key,
                'code'               => $code,
                'link'               => $link,
                'language'           => $language,
                'is_queue'           => false,
            );

            $endpoint = EMAIL_API . "api/send-mail";
            return email_api_endpoint($endpoint, $data);
        }
    }
}


function email_api_endpoint($endpoint, $data)
{

    try {

        // Convert data to JSON
        $data_string = json_encode($data);

        // Create cURL request
        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json'
        ));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Execute the request
        $response = curl_exec($ch);

        // Check for errors
        if (curl_errno($ch)) {
            dil('Email API error: ' . curl_error($ch));
        } else {
        }

        $result = json_decode($response, true);

        if (isset($result)) {
            if ($result['success'] ==  true) {
                $data = [
                    'error'    => false,
                    'complete' => true,
                ];
                return  $data;
            } else {
                $data = [
                    'error'    => $result['error'],
                    'complete' => false,
                ];
                dil($result['error']);
                return $data;
            }
        }

        // Close cURL
        curl_close($ch);
    } catch (\Exception $e) {
        dil('Email API error');
    }
}

// End Email server request

function discount_price($plan_id, $discount, $total)
{
    $price = $total - ($total / 100 * $discount);

    switch ($plan_id) {
        case '1':
            $discountPrice = $price;
            break;
        case '2':
            $discountPrice = $price * 12;
            break;
        case '3':
            $discountPrice = $price * 3;
            break;
        default:
            $discountPrice = $price;
            break;
    }

    return $discountPrice;
}

function get_user_gelocation()
{
    $country = null;
    $device = null;
    $language = null;

    try {
        $ipData = location_data();
        if (!isset($ipData->error)) {
            $country = $ipData->country;
        }
    } catch (Exception $e) {
        dil('IP API Not workign');
    }

    try {
        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            $deviceDetect = new \WhichBrowser\Parser($_SERVER['HTTP_USER_AGENT']);
            $device       = $deviceDetect->device->type;
        }
    } catch (Exception $e) {
        dil('HTTP_USER_AGENT Not workign');
    }

    $language     = \Altum\Language::$name;

    $data =  [
        'device'   => $device,
        'country'  => $country,
        'language' => $language,
    ];

    return $data;
}

function  cancel_promo_reason($feedback_type)
{

    switch ($feedback_type) {

        case 'defficulties_platform':
            $cancel_reason  = 1;
            break;
        case 'enough_platform':
            $cancel_reason  = 2;
            break;
        case 'missing_feature':
            $cancel_reason  = 3;
            break;
        case 'platform_expensive':
            $cancel_reason  = 4;
            break;
        case 'no_need_qr':
            $cancel_reason  = 5;
            break;
        case 'another_platform':
            $cancel_reason  = 6;
            break;
        case 'other':
            $cancel_reason  = 7;
            break;
        default:
            $cancel_reason  = 1;
            break;
    }

    return $cancel_reason;
}

function get_language_name($code)
{
    $language_codes = array(
        'en' => 'english',
        'aa' => 'afar',
        'ab' => 'abkhazian',
        'af' => 'afrikaans',
        'am' => 'amharic',
        'ar' => 'arabic',
        'as' => 'assamese',
        'ay' => 'aymara',
        'az' => 'azerbaijani',
        'ba' => 'bashkir',
        'be' => 'byelorussian',
        'bg' => 'bulgarian',
        'bh' => 'bihari',
        'bi' => 'bislama',
        'bn' => 'bengali/bangla',
        'bo' => 'tibetan',
        'br' => 'breton',
        'ca' => 'catalan',
        'co' => 'corsican',
        'cs' => 'czech',
        'cy' => 'welsh',
        'da' => 'danish',
        'de' => 'german',
        'dz' => 'bhutani',
        'el' => 'greek',
        'eo' => 'esperanto',
        'es' => 'spanish',
        'et' => 'estonian',
        'eu' => 'basque',
        'fa' => 'persian',
        'fi' => 'finnish',
        'fj' => 'fiji',
        'fo' => 'faeroese',
        'fr' => 'french',
        'fy' => 'frisian',
        'ga' => 'irish',
        'gd' => 'scots/gaelic',
        'gl' => 'galician',
        'gn' => 'guarani',
        'gu' => 'gujarati',
        'ha' => 'hausa',
        'hi' => 'hindi',
        'hr' => 'croatian',
        'hu' => 'hungarian',
        'hy' => 'armenian',
        'ia' => 'interlingua',
        'ie' => 'interlingue',
        'ik' => 'inupiak',
        'in' => 'indonesian',
        'is' => 'icelandic',
        'it' => 'italian',
        'iw' => 'hebrew',
        'ja' => 'japanese',
        'ji' => 'yiddish',
        'jw' => 'javanese',
        'ka' => 'georgian',
        'kk' => 'kazakh',
        'kl' => 'greenlandic',
        'km' => 'cambodian',
        'kn' => 'kannada',
        'ko' => 'korean',
        'ks' => 'kashmiri',
        'ku' => 'kurdish',
        'ky' => 'kirghiz',
        'la' => 'latin',
        'ln' => 'lingala',
        'lo' => 'laothian',
        'lt' => 'lithuanian',
        'lv' => 'latvian/lettish',
        'mg' => 'malagasy',
        'mi' => 'maori',
        'mk' => 'macedonian',
        'ml' => 'malayalam',
        'mn' => 'mongolian',
        'mo' => 'moldavian',
        'mr' => 'marathi',
        'ms' => 'malay',
        'mt' => 'maltese',
        'my' => 'burmese',
        'na' => 'nauru',
        'ne' => 'nepali',
        'nl' => 'dutch',
        'no' => 'norwegian',
        'oc' => 'occitan',
        'om' => '(afan)/oromoor/oriya',
        'pa' => 'punjabi',
        'pl' => 'polish',
        'ps' => 'pashto/pushto',
        'pt' => 'portuguese',
        'qu' => 'quechua',
        'rm' => 'rhaeto-romance',
        'rn' => 'kirundi',
        'ro' => 'romanian',
        'ru' => 'russian',
        'rw' => 'kinyarwanda',
        'sa' => 'sanskrit',
        'sd' => 'sindhi',
        'sg' => 'sangro',
        'sh' => 'serbo-croatian',
        'si' => 'singhalese',
        'sk' => 'slovak',
        'sl' => 'slovenian',
        'sm' => 'samoan',
        'sn' => 'shona',
        'so' => 'somali',
        'sq' => 'albanian',
        'sr' => 'serbian',
        'ss' => 'siswati',
        'st' => 'sesotho',
        'su' => 'sundanese',
        'sv' => 'swedish',
        'sw' => 'swahili',
        'ta' => 'tamil',
        'te' => 'tegulu',
        'tg' => 'tajik',
        'th' => 'thai',
        'ti' => 'tigrinya',
        'tk' => 'turkmen',
        'tl' => 'tagalog',
        'tn' => 'setswana',
        'to' => 'tonga',
        'tr' => 'turkish',
        'ts' => 'tsonga',
        'tt' => 'tatar',
        'tw' => 'twi',
        'uk' => 'ukrainian',
        'ur' => 'urdu',
        'uz' => 'uzbek',
        'vi' => 'vietnamese',
        'vo' => 'volapuk',
        'wo' => 'wolof',
        'xh' => 'xhosa',
        'yo' => 'yoruba',
        'zh' => 'chinese',
        'zu' => 'zulu',
    );

    if (isset($language_codes[$code])) {
        return $language_codes[$code];
    } else {
        return settings()->main->default_language;
    }
}

function get_user_name($name)
{
    $fullName = explode(" ", $name);

    if (count($fullName) > 1) {
        $first_name =  $fullName[0];
        $last_name  =  $fullName[1];
    } else {
        $first_name =  $name;
        $last_name  =  null;
    }

    $data =  [
        'first_name' => $first_name,
        'last_name'  => $last_name,
    ];

    return $data;
}


function get_gtm_campaign_url_data()
{

    if (isset($_COOKIE['__gtm_campaign_url']) && $_COOKIE['__gtm_campaign_url'] != '') {

        parse_str(urldecode($_COOKIE['__gtm_campaign_url']), $params);

        $data =  [
            'gaid'      => isset($params['gaid']) ? $params['gaid'] : null,
            'utm_term'  => isset($params['utm_term']) ? $params['utm_term'] : null,
            'matchtype' => isset($params['matchtype']) ? $params['matchtype'] : null,
        ];

        return  $data;
    } else {
        $data =  [
            'gaid'      =>  null,
            'utm_term'  =>  null,
            'matchtype' =>  null,
        ];

        return  $data;
    }
}


function create_one_day_trial_subscription($customerId, $userId){


    $user = db()->where('user_id',$userId)->getOne('users');
    
    if($user){

        $code = $user->currency_code;
        $currency = 'USD';
        $countryCurrency = get_user_currency($code);   
        if($countryCurrency){            
            $currency = $code;    
        }       
      
        try{

            $stripe = new \Stripe\StripeClient(settings()->stripe->secret_key);
            $stripe->subscriptions->create([
                'customer' => $customerId,
                'items' => [['price' => STRIPE_TRIAL_ID]],
                'trial_period_days' => 1,
                'cancel_at_period_end' => true,    
                'currency'=>$currency        
            ]);
        }catch(ApiErrorException $e){
            dil('Stripe Trial Subscriptions error - '.$userId);
        }

    }
    
}


function get_pastdue_subscription($user){

    $stripe = new \Stripe\StripeClient(settings()->stripe->secret_key);
    
    if($user){
        $subscription = db()->where('user_id', $user->user_id)->orderBy('id', 'DESC')->getOne('subscriptions');  
       
        if ($subscription) {
            try{
                $activeSubcription = $stripe->subscriptions->retrieve(
                    $subscription->subscription_id,
                    []
                );

                if($activeSubcription->status =='past_due'){
                    return $activeSubcription->id;
                }

            }catch(\Stripe\Exception\ApiErrorException $e){
                  
            }                    
        }
        
        
        try{

            if($user->stripe_customer_id ){
                $activeSubcription = $stripe->subscriptions->all(
                    ['customer' => $user->stripe_customer_id ]
                );
            }else{
                $activeSubcription = null;
            }            

            if($activeSubcription){
                $activeSubcription = $activeSubcription['data'][0];

                if($activeSubcription->status =='past_due'){
                    return $activeSubcription->id;
                }
            }

        }catch(\Stripe\Exception\ApiErrorException $e){
             
        } 
    }

    return null;
    
}


function check_delinquent_user($user){

    $stripe = new \Stripe\StripeClient(settings()->stripe->secret_key);

    if($user){
        $activeStripeSubcription = db()->where('user_id', $user->user_id)->orderBy('id', 'DESC')->getOne('subscriptions');         
        if ($activeStripeSubcription && $user->subscription_schedule_id == null) {           
            try{
                $activeStripeSubcription = $stripe->subscriptions->retrieve(
                    $activeStripeSubcription->subscription_id,
                    []
                );
            }catch(\Stripe\Exception\ApiErrorException $e){
                $activeStripeSubcription   = null;                
            }                    
        }else{

            if($user->stripe_customer_id){
                try{
                    $activeStripeSubcription = $stripe->subscriptions->all(
                        ['customer' => $user->stripe_customer_id ]
                    );
        
                    if($activeStripeSubcription){
                        $activeStripeSubcription = $activeStripeSubcription['data'][0];
                    }
        
                }catch(\Stripe\Exception\ApiErrorException $e){
                    $activeStripeSubcription = null;                
                } 
            }else{
                $activeStripeSubcription = null; 
            }
            
        }
    
    
        if($activeStripeSubcription && $activeStripeSubcription->status !='canceled' && (new DateTime($user->plan_expiration_date) < new DateTime())){
           return true;
        }else{
            return false;
        } 
    }
    else{
        return false;
    }
}
//Convert to price to Stripe price
function get_stripe_format($value, $code){

    $code = strtolower($code);
    
    $zeroDecimal = [
        'bif', 'clp', 'djf', 'gnf', 'jpy', 'kmf', 'krw', 'mga','pyg','rwf','ugx','vnd','vuv','xaf','xof','xpf'
    ];

    $threeDecimal = [
        'bhd', 'jod', 'kwd', 'omr', 'tnd'
    ];

    if(in_array($code,$zeroDecimal)){
        return $value;
    }else if(in_array($code,$threeDecimal)){
        return $value * 1000;
    }else{
        return $value * 100;
    }
}

//Convert to Stripe price to price
function convert_payment_format($value, $code){

    $code = strtolower($code);

    $zeroDecimal = [
        'bif', 'clp', 'djf', 'gnf', 'jpy', 'kmf', 'krw', 'mga','pyg','rwf','ugx','vnd','vuv','xaf','xof','xpf'
    ];

    $threeDecimal = [
        'bhd', 'jod', 'kwd', 'omr', 'tnd'
    ];

    if(in_array($code,$zeroDecimal)){
        return $value;
    }else if(in_array($code,$threeDecimal)){
        return $value / 1000;
    }else{
        return $value / 100;

    }

}

function unset_delinquent_session($user_id)
{

    if (isset($_SESSION['delinquentClientSecret']) &&  $_SESSION['delinquentClientSecret'] != '') {
        unset($_SESSION['delinquentClientSecret']);
    }

    if (isset($_SESSION['subscriptionId']) &&  $_SESSION['subscriptionId'] != '') {

        $user = db()->where('user_id', $user_id)->getOne('users');

        if ($user && $user->payment_subscription_id == null) {
            $stripe = new \Stripe\StripeClient(settings()->stripe->secret_key);
            $subscription  = $stripe->subscriptions->retrieve($_SESSION['subscriptionId'], []);
            if ($subscription) {
                $stripe->subscriptions->cancel(
                    $_SESSION['subscriptionId'],
                    ['cancellation_details' => ['comment' => 'discount_plan']]
                );
            }
        }

        unset($_SESSION['subscriptionId']);
    }
}
// Send download qr email to cff users who exits the website without pay
function send_download_qr_email($user_id)
{
    $userEmails =   db()->where('user_id', $user_id)->getOne('dpf_user_emails');
    $user =   db()->where('user_id', $user_id)->getOne('users');

    if ($userEmails && $userEmails->is_one_hour_email == 0 && $user->onboarding_funnel == 3) {
        try {

            $template =  'dpf-one-hour';
            $link     = 'qr-download/' . $user->referral_key;
            $email    = trigger_email($user_id, $template, $link);

            if ($email['complete']) {
                db()->where('user_id', $user_id)->update('dpf_user_emails', [
                    'is_one_hour_email'   => 1
                ]);
                return true;
            }
        } catch (\Throwable $th) {
            return false;
        }
    }

}

