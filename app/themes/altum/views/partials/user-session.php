<?php
// Decode the parameters
$utmSource    =  isset($_REQUEST['utm_source']) ? $_REQUEST['utm_source']  : null;
$utmMedium    =  isset($_REQUEST['utm_medium']) ? $_REQUEST['utm_medium']  : null;
$utmId        =  isset($_REQUEST['utm_id']) ? $_REQUEST['utm_id']  : null;
$utmContent   =  isset($_REQUEST['utm_content']) ? $_REQUEST['utm_content']  : null;
$utmTerm      =  isset($_REQUEST['utm_term']) ? $_REQUEST['utm_term']  : null;
$matchType    =  isset($_REQUEST['matchtype']) ? $_REQUEST['matchtype']  : null;
$gaid         =  isset($_REQUEST['gaid']) ? $_REQUEST['gaid']  : null;
$gclid        =  isset($_REQUEST['gclid']) ? $_REQUEST['gclid']  : null;
$wbraid       =  isset($_REQUEST['wbraid']) ? $_REQUEST['wbraid']  : null;
$gbraid       =  isset($_REQUEST['gbraid']) ? $_REQUEST['gbraid']  : null;

$url                = $_SERVER['REQUEST_URI'];
$url_components     = parse_url($url);
$onboarding_funnel  = onboarding_funnel($url_components, $this->user->user_id);

$device         = null;
$country        = null;
$language       = null;

$google_click_id    =  null;
$controllerKey      =  Altum\Routing\Router::$controller_key;

switch ($controllerKey) {
    case 'qr-download':
        $keys         = explode('/', $url);
        $referralKey  = end($keys);
        break;
    case 'plans-and-prices':
        $referralKey  = isset($_GET['id']) ? $_GET['id'] : null;
        break;
}

$user         = null;
if (isset($referralKey)) {
    $user = db()->where('referral_key', $referralKey)->getOne('users');
}else{
    $user =  isset($this->user->user_id) ? $this->user : null;
}


if ($gclid) {
    $google_click_id = $gclid;
} else if ($gbraid) {
    $google_click_id = $gbraid;
} else if ($wbraid) {
    $google_click_id = $wbraid;
}

?>


<?php if ($clientId     = get_client_id()) : ?>
    <?php

    $firstQr      = null;
    $userSession  = null;
    $firstSession = null;
    $session      = analyticsBb()->where('client_id', $clientId)->getOne('sessions');

    if (isset($user) && $user->user_id) {
        $firstSession = analyticsDatabase()->query("SELECT * FROM `sessions` WHERE `user_id` = '{$user->user_id}' AND `default_signup_view` IS NOT NULL  ORDER BY `create_time` ASC LIMIT 1")->fetch_object();
        $userSession  = analyticsDatabase()->query("SELECT * FROM `sessions` WHERE `user_id` = '{$user->user_id}' ORDER BY `create_time` ASC LIMIT 1")->fetch_object();
    }

    if ($session) {
        $userSessionRow =  analyticsBb()->where('client_id',  $session->client_id)->orderBy('id', 'ASC')->getOne('users');
        if ($user) {
            if (!$user->unique_id && $this->user->type != 2) {
                $user_params  = array(
                    'data' => array(
                        'unique_id'   => $session->unique_id,
                    ),
                    'where' => array(
                        'column'   => 'user_id',
                        'value'    => $user->user_id
                    ),

                );
                analytic_database('users', 'update', $user_params);
                db()->where('user_id', $user->user_id)->update('users', [
                    'unique_id'   => $session->unique_id,
                ]);
            } else if ($user->unique_id) {
                if ($session->unique_id != $user->unique_id) {
                    $sessions_params  = array(
                        'data' => array(
                            'unique_id'   => $user->unique_id,
                        ),
                        'where' => array(
                            'column'   => 'client_id',
                            'value'    => $session->client_id
                        ),

                    );
                    analytic_database('sessions', 'update', $sessions_params);
                }
            }

            if (!$session->user_id && !isset($_COOKIE['nsf_user_id'])) {
                $sessions_params  = array(
                    'data' => array(
                        'user_id'             => $user->type == 2 ? null : $user->user_id,
                        'update_time'         => date("Y-m-d H:i:s")
                    ),
                    'where' => array(
                        'column'   => 'client_id',
                        'value'    => $session->client_id
                    ),

                );
                analytic_database('sessions', 'update', $sessions_params);
            } else if ($session->user_id != $user->user_id && !isset($_COOKIE['nsf_user_id'])) {
                $sessions_params  = array(
                    'data' => array(
                        'user_id'             => $user->type == 2 ? null : $user->user_id,
                        'update_time'         => date("Y-m-d H:i:s")
                    ),
                    'where' => array(
                        'column'   => 'client_id',
                        'value'    => $session->client_id
                    ),

                );
                analytic_database('sessions', 'update', $sessions_params);
            }
        } else if (!$session->unique_id) {
            $sessions_params  = array(
                'data' => array(
                    'unique_id'   => getRandomNumber(),
                ),
                'where' => array(
                    'column'   => 'client_id',
                    'value'    => $session->client_id
                ),

            );
            analytic_database('sessions', 'update', $sessions_params);
        }

        if (!$userSessionRow) {

            $sessions_params  = array(
                'data' => array(
                    'utm_id'            => $utmId ? $utmId  : ($session->utm_id ? $session->utm_id : null),
                    'utm_term'          => $utmTerm ? $utmTerm  : ($session->utm_term ? $session->utm_term : null),
                    'utm_source'        => $utmSource ? $utmSource  : ($session->utm_source ? $session->utm_source : null),
                    'utm_medium'        => $utmMedium ? $utmMedium  : ($session->utm_medium ? $session->utm_medium : null),
                    'utm_content'       => $utmContent ? $utmContent  : ($session->utm_content ? $session->utm_content : null),
                    'gaid'              => $gaid ? $gaid  : ($session->gaid ? $session->gaid : null),
                    'matchtype'         => $matchType ? $matchType  : ($session->matchtype ? $session->matchtype : null),
                    'google_click_id'   => $google_click_id ? $google_click_id  : ($session->google_click_id ? $session->google_click_id : null),
                    'language'          => $session->language,
                    'device'            => $session->device,
                    'country'           => $session->country,
                ),
                'where' => array(
                    'column'   => 'client_id',
                    'value'    => $session->client_id
                ),
            );
            analytic_database('sessions', 'update', $sessions_params);
        }
    } else {
        $analytic_user =  null;

        if ($user && $user->unique_id && $user->type != 2) {
            $unique_id     = $user->unique_id;
            $analytic_user = analyticsBb()->where('user_id', $user->user_id)->getOne('users');
        } else {
            $unique_id = getRandomNumber();
        }

        if(!$analytic_user){
            $userGeLocation = get_user_gelocation();
        $device         = $userGeLocation['device'];
        $country        = $userGeLocation['country'];
        $language       = $userGeLocation['language'];
        }    



        $sessions_params  = array(
            'data' => array(
                'client_id'           => $clientId,
                'user_id'             => $user ? ($user->type == 2 ? null : $user->user_id) : null,
                'utm_id'              => $analytic_user ? $analytic_user->utm_id  : $utmId,
                'utm_source'          => $analytic_user ? $analytic_user->utm_source  : $utmSource,
                'utm_medium'          => $analytic_user ? $analytic_user->utm_medium  : $utmMedium,
                'utm_content'         => $analytic_user ? $analytic_user->utm_content  : $utmContent,
                'utm_term'            => $analytic_user ? $analytic_user->utm_term  : $utmTerm,
                'gaid'                => $analytic_user ? $analytic_user->gaid  : $gaid,
                'google_click_id'     => $analytic_user ? $analytic_user->google_click_id  : $google_click_id,
                'matchtype'           => $analytic_user ? $analytic_user->matchtype  : $matchType,
                'unique_id'           => $unique_id,
                'onboarding_funnel'   => $analytic_user ? $analytic_user->onboarding_funnel  : (isset($_SESSION['on_bording_register']) ?  $_SESSION['on_bording_register'] : $onboarding_funnel),
                'language'            => $analytic_user ? $analytic_user->language : $language,
                'device'              => $analytic_user ? $analytic_user->device : $device,
                'country'             => $analytic_user ? $analytic_user->country : $country,
                'create_time'         => date("Y-m-d H:i:s"),
                'update_time'         => date("Y-m-d H:i:s"),
            ),
        );


        if (isset($_COOKIE['_ga_client_id']) && $_COOKIE['_ga_client_id'] != '') {

            $cookieSession = analyticsBb()->where('client_id', $_COOKIE['_ga_client_id'])->getOne('sessions');

            if ($cookieSession) {
                $sessions_params['where'] = array(
                    'column' => 'client_id',
                    'value' => $_COOKIE['_ga_client_id']
                );
                analytic_database('sessions', 'update', $sessions_params);
            }else{               
                setcookie('unique_id',$unique_id, time() + (60 * 60 * 24 * 90), COOKIE_PATH);
                analytic_database('sessions', 'insert', $sessions_params);
                setcookie('_ga_client_id', '', time() - 7200, COOKIE_PATH);
            }
        } else {           
            setcookie('unique_id',$unique_id, time() + (60 * 60 * 24 * 90), COOKIE_PATH);
            analytic_database('sessions', 'insert', $sessions_params);
        }

        $_SESSION['unique_id'] = $unique_id;
    }


    ?>

<?php else : ?>

    <?php
        if (isset($user) && $user->user_id) {
            $user = $user;
        } else {
            $user = null;
        }

        $userGeLocation = get_user_gelocation();
        $device         = $userGeLocation['device'];
        $country        = $userGeLocation['country'];
        $language       = $userGeLocation['language'];

    ?>

    <script>
        var google_client_id = null;
        var client_id = null;
        var sessionGtag = '<?= GA_TAG ?>';
        var utm_source = '<?= $utmSource ?>';
        var utm_medium = '<?= $utmMedium  ?>';
        var utm_id = '<?= $utmId ?>';
        var utm_content = '<?= $utmContent ?>';
        var utm_term = '<?= $utmTerm  ?>';
        var matchtype = '<?= $matchType  ?>';
        var gaid = '<?= $gaid  ?>';
        var google_click_id = '<?= $google_click_id  ?>';
        var language = '<?= $language  ?>';
        var device = '<?= $device  ?>';
        var country = '<?= $country  ?>';

        // check gtag
        setTimeout(() => {
            gtag('get', sessionGtag, 'client_id', function(gCientId) {
                client_id = gCientId;
                google_client_id = gCientId;
            });
            setTimeout(() => {

                if (!client_id) {
                    $cookie_client_id = '<?= isset($_COOKIE['_ga_client_id']) ? $_COOKIE['_ga_client_id'] : null ?>';
                    if (!$cookie_client_id) {
                        client_id = '<?= default_client_id() ?>';
                        setCookie('_ga_client_id', client_id);
                    } else {
                        client_id = $cookie_client_id;
                    }
                }

                $.ajax({
                    type: 'POST',
                    url: '<?php echo url('api/ajax_new') ?>',
                    data: {
                        client_id: client_id,
                        utm_source: utm_source,
                        utm_medium: utm_medium,
                        utm_id: utm_id,
                        utm_content: utm_content,
                        utm_term: utm_term,
                        matchtype: matchtype,
                        gaid: gaid,
                        google_click_id: google_click_id,
                        language: language,
                        device: device,
                        country: country,
                        user_id: '<?= $user ? ($user->type == 2 ? null : $user->user_id) : null ?>',
                        onboarding_funnel: '<?= isset($_SESSION['on_bording_register']) ?  $_SESSION['on_bording_register'] : $onboarding_funnel ?>',
                        action: 'getSessionId',
                    },
                    success: function(response) {
                        if (response.data.result == "success") {
                            updateClientId();
                        }
                    }
                })

            }, 1000);

            setTimeout(() => {
                // check cookie
                if (!google_client_id) {
                    var cookie = {};
                    document.cookie.split(';').forEach(function(el) {
                        var splitCookie = el.split('=');
                        var key = splitCookie[0].trim();
                        var value = splitCookie[1];
                        cookie[key] = value;
                    });
                    var client_id = cookie["_ga"] ? cookie["_ga"].substring(6) : null;
                    if (client_id) {
                        $.ajax({
                            type: 'POST',
                            url: '<?php echo url('api/ajax_new') ?>',
                            data: {
                                client_id: client_id,
                                utm_source: utm_source,
                                utm_medium: utm_medium,
                                utm_id: utm_id,
                                utm_content: utm_content,
                                utm_term: utm_term,
                                matchtype: matchtype,
                                gaid: gaid,
                                google_click_id: google_click_id,
                                is_temp_client: is_temp_client,
                                language: language,
                                device: device,
                                country: country,
                                user_id: '<?= $user ? ($user->type == 2 ? null : $user->user_id) : null ?>',

                                onboarding_funnel: '<?= isset($_SESSION['on_bording_register']) ?  $_SESSION['on_bording_register'] : $onboarding_funnel ?>',
                                action: 'getSessionId',
                            },
                            success: function(response) {
                                if (response.data.result == "success") {}
                            }
                        })
                    }
                }
            }, 3000);

        }, 1000);

        function updateClientId() {

            var currentStep = $("input[name=\"current_step_input\"]").val();
            if (currentStep == '1') {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo url('api/ajax_new') ?>',
                    data: {
                        action: 'update_client_id',
                    },
                    success: function(response) {
                        if (response.data.result == true) {}
                    }

                });
            }
        }

        function setCookie(cname, cvalue) {
            const d = new Date();
            d.setTime(d.getTime() + (2 * 60 * 60 * 1000));
            let expires = "expires=" + d.toUTCString();
            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=<?= COOKIE_PATH ?>";
        }
    </script>
<?php endif ?>