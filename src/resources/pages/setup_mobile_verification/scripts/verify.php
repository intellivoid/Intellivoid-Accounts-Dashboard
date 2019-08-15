<?php

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\Runtime;
    use IntellivoidAccounts\IntellivoidAccounts;
    use IntellivoidAccounts\Objects\Account;

    Runtime::import('IntellivoidAccounts');

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        if(isset($_GET['action']))
        {
            if($_GET['action'] == 'verify')
            {
                verify_code();
            }
        }
    }

    function verify_code()
    {
        if(isset($_POST['verification_code']) == false)
        {
            header('Location: /setup_mobile_verification?callback=100');
            exit();
        }

        /** @var IntellivoidAccounts $IntellivoidAccounts */
        $IntellivoidAccounts = DynamicalWeb::getMemoryObject('intellivoid_accounts');

        /** @var Account $Account */
        $Account = DynamicalWeb::getMemoryObject('account');

        if($Account->Configuration->VerificationMethods->TwoFactorAuthentication->verifyCode($_POST['verification_code']) == false)
        {
            header('Location: /setup_mobile_verification?callback=100');
            exit();
        }

        $Account->Configuration->VerificationMethods->TwoFactorAuthenticationEnabled = true;

        if($Account->Configuration->VerificationMethods->RecoveryCodesEnabled == true)
        {
            $Account->Configuration->VerificationMethods->RecoveryCodes->enable();
            $Account->Configuration->VerificationMethods->RecoveryCodesEnabled = true;
        }

        $IntellivoidAccounts->getAccountManager()->updateAccount($Account);
        header('Location: /login_security?callback=100');
        exit();

    }

