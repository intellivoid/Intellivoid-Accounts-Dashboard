<?php


    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\Runtime;
    use IntellivoidAccounts\Abstracts\SearchMethods\AccountSearchMethod;
    use IntellivoidAccounts\IntellivoidAccounts;

    Runtime::import('IntellivoidAccounts');
    $IntellivoidAccounts = new IntellivoidAccounts();
    $Account = $IntellivoidAccounts->getAccountManager()->getAccount(AccountSearchMethod::byId, WEB_ACCOUNT_ID);

    DynamicalWeb::setMemoryObject('intellivoid_accounts', $IntellivoidAccounts);
    DynamicalWeb::setMemoryObject('account', $Account);

    if($Account->Configuration->VerificationMethods->RecoveryCodesEnabled == true)
    {
        header('/Location: /login_security?callback=106');
        exit();
    }