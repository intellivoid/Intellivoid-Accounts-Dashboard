<?php

    use DynamicalWeb\Actions;
    use DynamicalWeb\DynamicalWeb;
    use IntellivoidAccounts\Abstracts\AuditEventType;
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
            Actions::redirect(DynamicalWeb::getRoute('login_security', array(
                'callback' => '104'
            )));
        }

        $Account->Configuration->VerificationMethods->RecoveryCodes->disable();
        $Account->Configuration->VerificationMethods->RecoveryCodesEnabled = false;

        try
        {
            /** @var IntellivoidAccounts $IntellivoidAccounts */
            $IntellivoidAccounts = DynamicalWeb::getMemoryObject('intellivoid_accounts');
            $IntellivoidAccounts->getAuditLogManager()->logEvent($Account->ID, AuditEventType::RecoveryCodesDisabled);
            $IntellivoidAccounts->getAccountManager()->updateAccount($Account);
        }
        catch(Exception $e)
        {
            Actions::redirect(DynamicalWeb::getRoute('login_security', array(
                'callback' => '110'
            )));
        }

        Actions::redirect(DynamicalWeb::getRoute('login_security', array(
            'callback' => '105'
        )));
    }