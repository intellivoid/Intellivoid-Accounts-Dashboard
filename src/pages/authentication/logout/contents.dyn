<?PHP

    use DynamicalWeb\Actions;
    use DynamicalWeb\DynamicalWeb;
    use sws\sws;

    if(WEB_SESSION_ACTIVE == true)
    {
        $GetParameters = $_GET;
        unset($GetParameters['callback']);

        /** @var sws $sws */
        $sws = DynamicalWeb::getMemoryObject('sws');

        $Cookie = $sws->WebManager()->getCookie('intellivoid_secured_web_session');
        $Cookie->Data["session_active"] = false;
        $Cookie->Data["account_pubid"] = null;
        $Cookie->Data["account_id"] = null;
        $Cookie->Data["account_email"] = null;
        $Cookie->Data["account_username"] = null;
        $Cookie->Data["sudo_mode"] = false;
        $Cookie->Data["verification_required"] = false;
        $Cookie->Data["verification_type"] = null;
        $sws->CookieManager()->updateCookie($Cookie);

        $sws->WebManager()->disposeCookie('intellivoid_secured_web_session');

        Actions::redirect(DynamicalWeb::getRoute('authentication/login', $GetParameters));
    }
