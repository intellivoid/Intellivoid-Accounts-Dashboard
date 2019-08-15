<?php

    use DynamicalWeb\DynamicalWeb;
    use IntellivoidAccounts\IntellivoidAccounts;
    use IntellivoidAccounts\Objects\Account;

    if(isset($_GET['action']))
    {
        if($_GET['action'] == 'disable_rc')
        {
            disable_recovery_codes();
        }
    }


    function disable_recovery_codes()
    {
        /** @var Account $Account */
        $Account = DynamicalWeb::getMemoryObject('account');

        if($Account->Configuration->VerificationMethods->RecoveryCodesEnabled == false)
        {
            header('Location: /login_security?callback=104');
            exit();
        }

        $Account->Configuration->VerificationMethods->RecoveryCodes->disable();
        $Account->Configuration->VerificationMethods->RecoveryCodesEnabled = false;

        /** @var IntellivoidAccounts $IntellivoidAccounts */
        $IntellivoidAccounts = DynamicalWeb::getMemoryObject('intellivoid_accounts');
        $IntellivoidAccounts->getAccountManager()->updateAccount($Account);

        header('Location: /login_security?callback=105');
        exit();
    }