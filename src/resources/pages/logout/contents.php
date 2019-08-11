<?PHP

    use DynamicalWeb\DynamicalWeb;
    use sws\sws;

    if(WEB_SESSION_ACTIVE == true)
    {
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
        $sws->CookieManager()->updateCookie($Cookie);

        header('Location: /login');
        exit();
    }
