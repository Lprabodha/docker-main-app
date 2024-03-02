<?php
    function location_data()
    {
        $ipAddress =  get_ip();

        if(APP_CONFIG =='local'){
            // $ipAddress = '194.116.208.141'; //Euro
            // $ipAddress = '72.229.28.185';
            // $ipAddress = '103.255.63.255'; //BRL
            // $ipAddress = '122.255.63.255';
            // $ipAddress = '1.32.239.255'; //USA
            // $ipAddress ='1.178.63.255'; //Argentina
            // $ipAddress = '109.177.255.255'; // UAE
            // $ipAddress = '101.46.175.255';
            // $ipAddress = '100.42.255.255';//Canada
            // $ipAddress = '1.159.255.255'; //Australia
            // $ipAddress = '109.74.15.255';//sweden
            // $ipAddress = '103.144.60.255'; //Sri Lanka
            // $ipAddress = '164.73.255.255'; // Mexico
            // $ipAddress = '69.67.47.255'; // South Africa
            // $ipAddress = '104.250.207.255' ; //Sweeden
            // $ipAddress = '101.53.95.255'; //South Korea
            // $ipAddress = '103.10.207.255'; //Taiwan
            // $ipAddress = '221.110.187.102'; //Taiwan
            // $ipAddress = '101.128.64.5'; //indonesian
            // $ipAddress = '144.23.0.0'; // Costa Rica

        }
        
        try {

            $Url = "https://ipapi.co/".$ipAddress."/json?key=QsFZ2GmiouG1L37tzRD2B9UKNN36YzQjB4XbgQyI0B6BJDdIs8";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $Url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $output = curl_exec($ch);
            curl_close($ch);
            $ipData =  @json_decode($output);
            return $ipData;
        } catch (Exception $e) {
            header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
            echo json_encode(array("success" => false, "message" => $e->getMessage()));
            return;
        }
    }

    function exchange_rate($user)
    {
        $data           = null;
        $data['rate']   = null; 
        $data['symbol'] = null; 
        $data['code']   = null; 
              
      
        if($user){
            if($user->payment_currency ==''){               
                $currency = 'USD';
                if($user->currency_code ==''){
                    $ipData = location_data();
                    if(!isset($ipData->error)){ 
                        $countryCurrency = get_user_currency($ipData->currency);                     
                        if($countryCurrency){            
                            $currency = $ipData->currency;    
                        }
                        
                        db()->where('user_id', $user->user_id)->update('users', [
                            'currency_code' => $ipData->currency,  
                            'payment_currency' => $currency,                        
                        ]);
                    }
                    
                }else{
                    $countryCurrency = get_user_currency($user->currency_code);                     
                    if($countryCurrency){            
                        $currency = $user->currency_code;    
                    }

                    db()->where('user_id', $user->user_id)->update('users', [                           
                        'payment_currency' => $currency,
                    ]);
                }              

               
            }else{

                // If there is an incorrect currency code, it will be fixed
                $countryCurrency = get_user_currency($user->payment_currency);
               
                if(!$countryCurrency && $user->payment_currency != 'USD'){
                    
                    $countryCurrency = get_user_currency($user->currency_code);                     
                    if($countryCurrency){            
                        $currency = $user->currency_code;    
                    }else{
                        $currency = 'USD';
                    }

                    db()->where('user_id', $user->user_id)->update('users', [                           
                        'payment_currency' => $currency,
                    ]);
                }
            }


            $data = [
                'rate'   => getExchangeRate($user->currency_code),
                'symbol'=> getSymbol($user->currency_code),
                'code'  => $user->currency_code,
            ];

           

        }else{
            $ipData = location_data();
            if(!isset($ipData->error)){ 
                $data = [
                    'rate'   => getExchangeRate($ipData->currency),
                    'symbol'=> getSymbol($ipData->currency),
                    'code'  => $ipData->currency,
                ];
            }
        }

        return $data;
       
    }

    function getExchangeRate($code){

        $currency =  db()->where('name', $code)->getOne('exchange_rates');        
        if($currency){  
            return $currency->rate;
        }else{
            dil($code. 'Exchange  rate not found');
            return null;
        }

        
    }


    function get_country_code()
    {
        $data = null;
        
        try {
            $ipData = location_data();     
            if ($ipData && !isset($ipData->error)) {            
                $data =$ipData->country_code;                
            }
            return $data;
        } catch (Exception $e) {
            header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
            echo json_encode(array("success" => false, "message" => $e->getMessage()));
            return $data;
        }
    }


    function getSymbol($key){

        $currency_list = array(
            "AFA" => "؋",
            "ALL" => "Lek",
            "DZD" => "دج",
            "AOA" => "Kz",
            "ARS" => "Arg$",
            "AMD" => "֏",
            "AWG" => "ƒ",
            "AUD" => "$",
            "AZN" => "m",
            "BSD" => "B$",
            "BHD" => ".د.ب",
            "BDT" => "৳",
            "BBD" => "Bds$",
            "BYR" => "Br",
            "BEF" => "fr",
            "BZD" => "$",
            "BMD" => "$",
            "BTN" => "Nu.",
            "BTC" => "฿",
            "BOB" => "Bs.",
            "BAM" => "KM",
            "BWP" => "P",
            "BRL" => "R$",
            "GBP" => "£",
            "BND" => "B$",
            "BGN" => "Лв.",
            "BIF" => "FBu",
            "KHR" => "KHR",
            "CAD" => "$",
            "CVE" => "$",
            "KYD" => "$",
            "XOF" => "CFA",
            "XAF" => "FCFA",
            "XPF" => "₣",
            "CLP" => "Ch$",
            "CLF" => "CLF",
            "CNY" => "CN¥",
            "COP" => "Col$",
            "KMF" => "CF",
            "CDF" => "FC",
            "CRC" => "₡",
            "HRK" => "kn",
            "CUC" => "$, CUC",
            "CZK" => "Kč",
            "DKK" => "Kr",
            "DJF" => "Fdj",
            "DOP" => "RD$",
            "XCD" => "$",
            "EGP" => "ج.م",
            "ERN" => "Nfk",
            "EEK" => "kr",
            "ETB" => "Nkf",
            "EUR" => "€",
            "FKP" => "£",
            "FJD" => "FJ$",
            "GMD" => "D",
            "GEL" => "ლ",
            "DEM" => "DM",
            "GHS" => "GH₵",
            "GIP" => "£",
            "GRD" => "₯, Δρχ, Δρ",
            "GTQ" => "Q",
            "GNF" => "FG",
            "GYD" => "$",
            "HTG" => "G",
            "HNL" => "L",
            "HKD" => "HK$",
            "HUF" => "Ft",
            "ISK" => "kr",
            "INR" => "₹",
            "IDR" => "Rp",
            "IRR" => "﷼",
            "IQD" => "د.ع",
            "ILS" => "₪",
            "ITL" => "L,£",
            "JMD" => "J$",
            "JPY" => "¥",
            "JOD" => "ا.د",
            "KZT" => "₸",
            "KES" => "KSh",
            "KWD" => "ك.د",
            "KGS" => "лв",
            "LAK" => "₭",
            "LVL" => "Ls",
            "LBP" => "£",
            "LSL" => "L",
            "LRD" => "$",
            "LYD" => "د.ل",
            "LTC" => "Ł",
            "LTL" => "Lt",
            "MOP" => "$",
            "MKD" => "ден",
            "MGA" => "Ar",
            "MWK" => "MK",
            "MYR" => "RM",
            "MVR" => "Rf",
            "MRO" => "MRU",
            "MUR" => "₨",
            "MXN" => "MX$",
            "MDL" => "Lei",
            "MNT" => "₮",
            "MAD" => "MAD",
            "MZM" => "MT",
            "MMK" => "K",
            "NAD" => "$",
            "NPR" => "₨",
            "ANG" => "ƒ",
            "TWD" => "NT$",
            "NZD" => "$",
            "NIO" => "C$",
            "NGN" => "₦",
            "KPW" => "₩",
            "NOK" => "kr",
            "OMR" => ".ع.ر",
            "PKR" => "₨",
            "PAB" => "B/.",
            "PGK" => "K",
            "PYG" => "₲",
            "PEN" => "S/.",
            "PHP" => "₱",
            "PLN" => "zł",
            "QAR" => "ق.ر",
            "RON" => "lei",
            "RUB" => "₽",
            "RWF" => "FRw",
            "SVC" => "₡",
            "WST" => "SAT",
            "STD" => "Db",
            "SAR" => "﷼",
            "RSD" => "дин",
            "SCR" => "SRe",
            "SLL" => "Le",
            "SGD" => "S$",
            "SKK" => "Sk",
            "SBD" => "Si$",
            "SOS" => "Sh.so.",
            "ZAR" => "R",
            "KRW" => "₩",
            "SSP" => "£",
            "XDR" => "SDR",
            "LKR" => "Rs",
            "SHP" => "£",
            "SDG" => ".س.ج",
            "SRD" => "$",
            "SZL" => "E",
            "SEK" => "kr",
            "CHF" => "CHF",
            "SYP" => "LS",
            "TJS" => "SM",
            "TZS" => "TSh",
            "THB" => "฿",
            "TOP" => "$",
            "TTD" => "$",
            "TND" => "ت.د",
            "TRY" => "₺",
            "TMT" => "T",
            "UGX" => "USh",
            "UAH" => "₴",
            "AED" => "إ.د",
            "UYU" => '$A',
            "USD" => "$",
            "UZS" => "лв",
            "VUV" => "VT",
            "VEF" => "Bs",
            "VND" => "₫",
            "YER" => "﷼",
            "ZMK" => "ZK",
            "ZWL" => "$",     
            "BYN" => "Br"  
        );

        return $currency_list[$key];

    }



