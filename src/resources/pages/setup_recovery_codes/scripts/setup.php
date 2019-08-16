<?php



    use DynamicalWeb\DynamicalWeb;
    use IntellivoidAccounts\IntellivoidAccounts;
    use IntellivoidAccounts\Objects\Account;

    /** @var Account $Account */
    $Account = DynamicalWeb::getMemoryObject('account');

    if(isset(DynamicalWeb::$globalObjects["intellivoid_accounts"]) == false)
    {
        /** @var IntellivoidAccounts $IntellivoidAccounts */
        $IntellivoidAccounts = DynamicalWeb::setMemoryObject(
            "intellivoid_accounts", new IntellivoidAccounts()
        );
    }
    else
    {
        /** @var IntellivoidAccounts $IntellivoidAccounts */
        $IntellivoidAccounts = DynamicalWeb::getMemoryObject("intellivoid_accounts");
    }

    $Account->Configuration->VerificationMethods->RecoveryCodes->enable();
    $Account->Configuration->VerificationMethods->RecoveryCodesEnabled = false;
    $IntellivoidAccounts->getAccountManager()->updateAccount($Account);

