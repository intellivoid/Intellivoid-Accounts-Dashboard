<?php

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use DynamicalWeb\Page;
    use DynamicalWeb\Runtime;
    use sws\sws;

    Runtime::import('SecuredWebSessions');

    $unauthorized_pages = [
        'login',
        'register'
    ];

    $verification_pages = [
        'verify',
        'verify_mobile',
        'logout'
    ];

    /** @var sws $sws */
    $sws = DynamicalWeb::setMemoryObject('sws', new sws());

    if($sws->WebManager()->isCookieValid('intellivoid_secured_web_session') == false)
    {
        $Cookie = $sws->CookieManager()->newCookie('intellivoid_secured_web_session', 86400, false);

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

        if(isset($_GET['callback']))
        {
            header('Refresh: 2; URL=/login?callback=' . urlencode($_GET['callback']));
        }
        else
        {
            header('Refresh: 2; URL=/login');
        }
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

    if(WEB_SESSION_ACTIVE == false)
    {
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
            header('Location: /login');
            exit();
        }
    }
    else
    {
        if(WEB_VERIFICATION_REQUIRED == true)
        {
            if(time() > WEB_AUTO_LOGOUT)
            {
                $Cookie->Data['session_active'] = false;
                $Cookie->Data['verification_required'] = false;
                $Cookie->Data['auto_logout'] = 0;
                $sws->CookieManager()->updateCookie($Cookie);
                $sws->WebManager()->disposeCookie('intellivoid_secured_web_session');

                header('Location: /login?callback=107');
                exit();
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
                header('Location: /verify');
                exit();
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
                header('Location: /');
                exit();
            }
        }

    }