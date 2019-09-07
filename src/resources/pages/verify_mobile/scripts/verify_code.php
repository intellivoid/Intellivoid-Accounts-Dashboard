<?php

    use DynamicalWeb\DynamicalWeb;
    use IntellivoidAccounts\Objects\Account;
    use sws\sws;

    if(isset($_GET['action']))
    {
        if($_GET['action'] == 'submit')
        {
            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                execute_verification();
            }
        }
    }

    function execute_verification()
    {
        if(isset($_POST['code']) == false)
        {
            header('Location: /verify_mobile?callback=100');
            exit();
        }

        /** @var Account $Account */
        $Account = DynamicalWeb::getMemoryObject('account');

        if($Account->Configuration->VerificationMethods->TwoFactorAuthentication->verifyCode($_POST['code']) == false)
        {
            // TODO: Log incorrect verification code here.
            // TODO: Add auto-lockout
            header('Location: /verify_mobile?callback=101');
            exit();
        }

        /** @var sws $sws */
        $sws = DynamicalWeb::getMemoryObject('sws');
        $Cookie = $sws->WebManager()->getCookie('intellivoid_secured_web_session');

        $Cookie->Data["verification_required"] = false;
        $Cookie->Data["auto_logout"] = 0;
        $Cookie->Data["verification_attempts"] = 0;

        $sws->CookieManager()->updateCookie($Cookie);

        header('Location: /');
        exit();
    }