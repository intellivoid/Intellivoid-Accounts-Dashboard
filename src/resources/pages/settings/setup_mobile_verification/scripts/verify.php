<?php

    use DynamicalWeb\Actions;
    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\Runtime;
    use IntellivoidAccounts\Abstracts\AuditEventType;
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
            Actions::redirect(DynamicalWeb::getRoute('settings_setup_mobile_verification', array(
                'callback' => '100'
            )));;
        }

        /** @var IntellivoidAccounts $IntellivoidAccounts */
        $IntellivoidAccounts = DynamicalWeb::getMemoryObject('intellivoid_accounts');

        /** @var Account $Account */
        $Account = DynamicalWeb::getMemoryObject('account');

        if($Account->Configuration->VerificationMethods->TwoFactorAuthentication->verifyCode($_POST['verification_code']) == false)
        {
            Actions::redirect(DynamicalWeb::getRoute('settings_setup_mobile_verification', array(
                'callback' => '100'
            )));
        }

        $Account->Configuration->VerificationMethods->TwoFactorAuthenticationEnabled = true;
        $IntellivoidAccounts->getAuditLogManager()->logEvent($Account->ID, AuditEventType::MobileVerificationEnabled);
        $IntellivoidAccounts->getAccountManager()->updateAccount($Account);

        if($Account->Configuration->VerificationMethods->RecoveryCodesEnabled == false)
        {
            Actions::redirect(DynamicalWeb::getRoute('settings_setup_recovery_codes', array(
                'callback' => '100'
            )));
        }
        else
        {
            Actions::redirect(DynamicalWeb::getRoute('settings_login_security', array(
                'callback' => '100'
            )));
        }

    }

