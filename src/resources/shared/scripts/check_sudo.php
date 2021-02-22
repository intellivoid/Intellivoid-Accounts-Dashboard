<?php

    use DynamicalWeb\Actions;
    use DynamicalWeb\DynamicalWeb;
    use sws\sws;

    if(WEB_SUDO_MODE == false)
    {
        $_GET['redirect'] = APP_CURRENT_PAGE;
        Actions::redirect(DynamicalWeb::getRoute('authentication/sudo', $_GET));
    }
    else
    {
        if(time() > WEB_SUDO_EXPIRES)
        {
            /** @var sws $sws */
            $sws = DynamicalWeb::getMemoryObject('sws');

            $Cookie = $sws->WebManager()->getCookie('intellivoid_secured_web_session');
            $Cookie->Data["sudo_mode"] = false;
            $Cookie->Data["sudo_expires"] = 0;

            $sws->CookieManager()->updateCookie($Cookie);
            $_GET['redirect'] = APP_CURRENT_PAGE;
            Actions::redirect(DynamicalWeb::getRoute('authentication/sudo', $_GET));
        }
        else
        {
            /** @var sws $sws */
            $sws = DynamicalWeb::getMemoryObject('sws');

            $Cookie = $sws->WebManager()->getCookie('intellivoid_secured_web_session');
            $Cookie->Data["sudo_mode"] = true;
            $Cookie->Data["sudo_expires"] = time() + 900;
            $sws->CookieManager()->updateCookie($Cookie);
        }
    }