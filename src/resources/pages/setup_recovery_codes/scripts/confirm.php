<?php

    use DynamicalWeb\Actions;
    use DynamicalWeb\DynamicalWeb;
use IntellivoidAccounts\Abstracts\AuditEventType;
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
        $IntellivoidAccounts->getAuditLogManager()->logEvent($Account->ID, AuditEventType::RecoveryCodesEnabled);
        $IntellivoidAccounts->getAccountManager()->updateAccount($Account);

        Actions::redirect(DynamicalWeb::getRoute('login_security', array(
            'callback' => '107'
        )));
    }