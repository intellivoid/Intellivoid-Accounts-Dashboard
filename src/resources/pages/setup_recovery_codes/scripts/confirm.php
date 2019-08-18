<?php

    use DynamicalWeb\DynamicalWeb;
    use IntellivoidAccounts\IntellivoidAccounts;
    use IntellivoidAccounts\Objects\Account;

    if(isset($_GET['action']))
    {
        if($_GET['action'] == 'confirm')
        {
            confirm_recovery_codes();
        }
    }

    function confirm_recovery_codes()
    {
        /** @var Account $Account */
        $Account = DynamicalWeb::getMemoryObject('account');

        if($Account->Configuration->VerificationMethods->RecoveryCodesEnabled == true)
        {
            return;
        }

        if($Account->Configuration->VerificationMethods->RecoveryCodes->Enabled == false)
        {
            return;
        }

        /** @var IntellivoidAccounts $IntellivoidAccounts */
        $IntellivoidAccounts = DynamicalWeb::getMemoryObject("intellivoid_accounts");
        $Account->Configuration->VerificationMethods->RecoveryCodesEnabled = true;
        $IntellivoidAccounts->getAccountManager()->updateAccount($Account);

        header('Location: /login_security?callback=107');
        exit();
    }