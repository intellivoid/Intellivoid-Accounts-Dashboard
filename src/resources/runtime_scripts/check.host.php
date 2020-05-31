<?php

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\Page;
    use DynamicalWeb\Runtime;
    use IntellivoidAccounts\IntellivoidAccounts;
    use sws\Objects\Cookie;
    use sws\sws;

    Runtime::import('IntellivoidAccounts');

    if(defined('AUTHENTICATION_SKIPPED'))
    {
        if(AUTHENTICATION_SKIPPED == false)
        {
            /** @var Cookie $Cookie */
            $Cookie = DynamicalWeb::getMemoryObject('(cookie)web_session');

            if($Cookie !== null)
            {
                if(isset($Cookie->Data['host_id']))
                {
                    if($Cookie->Data['host_id'] == 0)
                    {
                        establish_host();
                    }
                }
            }
        }
    }

    function establish_host()
    {
        if(isset(DynamicalWeb::$globalObjects["intellivoid_accounts"]) == false)
        {
            /** @var IntellivoidAccounts $IntellivoidAccounts */
            $IntellivoidAccounts = DynamicalWeb::setMemoryObject(
                "intellivoid_accounts", new IntellivoidAccounts()
            );
        }
        else
        {
            /** @var IntellivoidAccounts $IntellivoidAccounts */
            $IntellivoidAccounts = DynamicalWeb::getMemoryObject("intellivoid_accounts");
        }

        try
        {
            $KnownHost = $IntellivoidAccounts->getKnownHostsManager()->syncHost(CLIENT_REMOTE_HOST, CLIENT_USER_AGENT);
        }
        catch(Exception $exception)
        {
            Page::staticResponse(
                'Security Error', 'Security Verification Failure',
                "Your browser is not supported because it does not have proper support for secured communications, try using a browser like Chrome, Firefox or Opera."
            );
            exit();
        }

        /** @var sws $sws */
        $sws = DynamicalWeb::getMemoryObject('sws');

        $Cookie = $sws->WebManager()->getCookie('intellivoid_secured_web_session');
        $Cookie->Data["host_id"] = $KnownHost->ID;
        $Cookie->Data["host_cache_ip"] = $KnownHost->IpAddress;
        $Cookie->Data["host_cache_ua"] = CLIENT_USER_AGENT;

        $sws->CookieManager()->updateCookie($Cookie);
        DynamicalWeb::setMemoryObject('(cookie)web_session', $Cookie);
    }


