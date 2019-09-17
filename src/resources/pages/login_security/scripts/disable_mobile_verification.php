<?php

    use DynamicalWeb\Actions;
    use DynamicalWeb\DynamicalWeb;

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
            Actions::redirect(DynamicalWeb::getRoute('login_security', array(
                'callback' => '102'
            )));
        }

        $Account->Configuration->VerificationMethods->TwoFactorAuthentication->disable();
        $Account->Configuration->VerificationMethods->TwoFactorAuthenticationEnabled = false;

        /** @var \IntellivoidAccounts\IntellivoidAccounts $IntellivoidAccounts */
        $IntellivoidAccounts = \DynamicalWeb\DynamicalWeb::getMemoryObject('intellivoid_accounts');
        $IntellivoidAccounts->getAccountManager()->updateAccount($Account);

        Actions::redirect(DynamicalWeb::getRoute('login_security', array(
            'callback' => '103'
        )));
    }