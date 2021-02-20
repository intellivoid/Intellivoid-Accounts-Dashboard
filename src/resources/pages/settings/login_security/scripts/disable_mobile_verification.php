<?php

    use DynamicalWeb\Actions;
    use DynamicalWeb\DynamicalWeb;
    use IntellivoidAccounts\Abstracts\AuditEventType;
    use IntellivoidAccounts\IntellivoidAccounts;
    use IntellivoidAccounts\Objects\Account;

    if(isset($_GET['action']))
    {
        if($_GET['action'] == 'disable_mv')
        {
            disable_mobile_verification();
        }
    }


    function disable_mobile_verification()
    {
        /** @var Account $Account */
        $Account = DynamicalWeb::getMemoryObject('account');

        if($Account->Configuration->VerificationMethods->TwoFactorAuthenticationEnabled == false)
        {
            Actions::redirect(DynamicalWeb::getRoute('settings/login_security', array(
                'callback' => '102'
            )));
        }

        $Account->Configuration->VerificationMethods->TwoFactorAuthentication->disable();
        $Account->Configuration->VerificationMethods->TwoFactorAuthenticationEnabled = false;

        try
        {
            /** @var IntellivoidAccounts $IntellivoidAccounts */
            $IntellivoidAccounts = DynamicalWeb::getMemoryObject('intellivoid_accounts');
            $IntellivoidAccounts->getAuditLogManager()->logEvent($Account->ID, AuditEventType::MobileVerificationDisabled);
            $IntellivoidAccounts->getAccountManager()->updateAccount($Account);
        }
        catch(Exception $e)
        {
            Actions::redirect(DynamicalWeb::getRoute('settings/login_security', array(
                'callback' => '110'
            )));
        }

        Actions::redirect(DynamicalWeb::getRoute('settings/login_security', array(
            'callback' => '103'
        )));
    }