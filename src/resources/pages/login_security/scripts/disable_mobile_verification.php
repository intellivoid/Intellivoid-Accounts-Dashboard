<?php

    if(isset($_GET['action']))
    {
        if($_GET['action'] == 'disable_mv')
        {
            disable_mobile_verification();
        }
    }


    function disable_mobile_verification()
    {
        /** @var \IntellivoidAccounts\Objects\Account $Account */
        $Account = \DynamicalWeb\DynamicalWeb::getMemoryObject('account');

        if($Account->Configuration->VerificationMethods->TwoFactorAuthenticationEnabled == false)
        {
            header('Location: /login_security?callback=102');
            exit();
        }

        $Account->Configuration->VerificationMethods->TwoFactorAuthentication->disable();
        $Account->Configuration->VerificationMethods->TwoFactorAuthenticationEnabled = false;

        /** @var \IntellivoidAccounts\IntellivoidAccounts $IntellivoidAccounts */
        $IntellivoidAccounts = \DynamicalWeb\DynamicalWeb::getMemoryObject('intellivoid_accounts');
        $IntellivoidAccounts->getAccountManager()->updateAccount($Account);

        header('Location: /login_security?callback=103');
        exit();
    }