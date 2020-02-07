<?php

    use DynamicalWeb\Actions;
    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use DynamicalWeb\Page;
    use DynamicalWeb\Runtime;
    use sws\sws;

    Runtime::import('SecuredWebSessions');

    $public_pages = [
        'avatar',
        'application_icon',
        'otl_api',
        'khm_api',
        'coa_api',
        'application_error',
        'landing_page',
        'privacy'
    ];

    $unauthorized_pages = [
        'login',
        'register'
    ];

    $verification_pages = [
        'verify',
        'verify_mobile',
        'verify_telegram',
        'verify_recovery_code',
        'telegram_poll',
        'logout'
    ];

    $skip_authentication = false;
    foreach($public_pages as $page)
    {
        if(APP_CURRENT_PAGE == $page)
        {
            $skip_authentication = true;
        }
    }
    define('AUTHENTICATION_SKIPPED', $skip_authentication, false);

    if(AUTHENTICATION_SKIPPED == false)
    {
        execute_authentication_check($unauthorized_pages, $verification_pages);
    }

    function execute_authentication_check(array $unauthorized_pages, array $verification_pages)
    {
        $GetParameters = $_GET;
        unset($GetParameters['callback']);

        /** @var sws $sws */
        $sws = DynamicalWeb::setMemoryObject('sws', new sws());

        if($sws->WebManager()->isCookieValid('intellivoid_secured_web_session') == false)
        {
            if(APP_CURRENT_PAGE == 'index')
            {
                Actions::redirect(DynamicalWeb::getRoute('landing_page'));
            }

            $Cookie = $sws->CookieManager()->newCookie('intellivoid_secured_web_session', 5656005, false);

            $Cookie->Data = array(
                'session_active' => false,
                'account_pubid' => null,
                'account_id' => null,
                'account_email' => null,
                'account_username' => null,
                'sudo_mode' => false,
                'sudo_expires' => 0,
                'verification_required' => false,
                'auto_logout' => 0,
                'host_id' => 0,
                'verification_attempts' => 0,
                'host_cache_ip' => null,
                'host_cache_ua' => null,
                'cache' => array(),
                'cache_refresh' => 0
            );

            $sws->CookieManager()->updateCookie($Cookie);
            $sws->WebManager()->setCookie($Cookie);

            if($Cookie->Name == null)
            {
                print('There was an issue with the security check, Please refresh the page');
                exit();
            }

            $Location =  null;

            if(isset($_GET['redirect']))
            {
                switch(strtolower($_GET['redirect']))
                {

                    case 'register':
                        $Location = DynamicalWeb::getRoute('register', $_GET);
                        break;

                    case 'login':
                    default:
                        $Location = DynamicalWeb::getRoute('login', $_GET);
                        break;
                }
            }
            else
            {
                $Location = DynamicalWeb::getRoute('login', $_GET);
            }

            header('Refresh: 2; URL=' . $Location);
            HTML::importScript('loader');
            exit();
        }

        try
        {
            $Cookie = $sws->WebManager()->getCookie('intellivoid_secured_web_session');
        }
        catch(Exception $exception)
        {
            Page::staticResponse(
                'Intellivoid Error',
                'Web Sessions Issue',
                'There was an issue with your Web Session, try clearing your cookies and try again'
            );
            exit();
        }

        DynamicalWeb::setMemoryObject('(cookie)web_session', $Cookie);

        define('WEB_SESSION_ACTIVE', $Cookie->Data['session_active'], false);
        define('WEB_ACCOUNT_PUBID', $Cookie->Data['account_pubid'], false);
        define('WEB_ACCOUNT_ID', $Cookie->Data['account_id'], false);
        define('WEB_ACCOUNT_EMAIL', $Cookie->Data['account_email'], false);
        define('WEB_ACCOUNT_USERNAME', $Cookie->Data['account_username'], false);
        define('WEB_SUDO_MODE', $Cookie->Data['sudo_mode'], false);
        define('WEB_SUDO_EXPIRES', $Cookie->Data['sudo_expires'], false);
        define('WEB_VERIFICATION_REQUIRED', $Cookie->Data['verification_required'], false);
        define('WEB_AUTO_LOGOUT', $Cookie->Data['auto_logout'], false);
        define('WEB_VERIFICATION_ATTEMPTS', $Cookie->Data['verification_attempts'], false);

        if(WEB_SESSION_ACTIVE == false)
        {
            if(APP_CURRENT_PAGE == 'index')
            {
                Actions::redirect(DynamicalWeb::getRoute('landing_page'));
            }

            $redirect = true;

            foreach($unauthorized_pages as $page)
            {
                if(APP_CURRENT_PAGE == $page)
                {
                    $redirect = false;
                }
            }

            if($redirect == true)
            {
                Actions::redirect(DynamicalWeb::getRoute('login', $GetParameters));
            }
        }
        else
        {
            if(WEB_VERIFICATION_REQUIRED == true)
            {
                if(time() > WEB_AUTO_LOGOUT || WEB_VERIFICATION_ATTEMPTS > 3)
                {
                    $Cookie->Data['session_active'] = false;
                    $Cookie->Data['verification_required'] = false;
                    $Cookie->Data['auto_logout'] = 0;
                    $Cookie->Data['verification_attempts'] = 0;
                    $sws->CookieManager()->updateCookie($Cookie);
                    $sws->WebManager()->disposeCookie('intellivoid_secured_web_session');

                    if(time() > WEB_AUTO_LOGOUT)
                    {
                        $GetParameters['callback'] = '107';
                        Actions::redirect(DynamicalWeb::getRoute('login', $GetParameters));
                    }

                    if(WEB_VERIFICATION_ATTEMPTS > 3)
                    {
                        $GetParameters['callback'] = '108';
                        Actions::redirect(DynamicalWeb::getRoute('login', $GetParameters));
                    }
                }

                $redirect = true;

                foreach($verification_pages as $page)
                {
                    if(APP_CURRENT_PAGE == $page)
                    {
                        $redirect = false;
                    }
                }

                if($redirect == true)
                {
                    Actions::redirect(DynamicalWeb::getRoute('verify', $GetParameters));
                }
            }
            else
            {
                $redirect = false;

                foreach($unauthorized_pages as $page)
                {
                    if(APP_CURRENT_PAGE == $page)
                    {
                        $redirect = true;
                    }
                }

                if($redirect == true)
                {
                    Actions::redirect(DynamicalWeb::getRoute('index', $GetParameters));
                }
            }

        }
    }

