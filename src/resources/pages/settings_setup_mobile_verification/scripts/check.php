<?php


    use DynamicalWeb\Actions;
    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\Runtime;
    use IntellivoidAccounts\Abstracts\SearchMethods\AccountSearchMethod;
    use IntellivoidAccounts\IntellivoidAccounts;

    Runtime::import('IntellivoidAccounts');
    $IntellivoidAccounts = new IntellivoidAccounts();
    $Account = $IntellivoidAccounts->getAccountManager()->getAccount(AccountSearchMethod::byId, WEB_ACCOUNT_ID);

    if($Account->Configuration->VerificationMethods->TwoFactorAuthenticationEnabled == true)
    {
        Actions::redirect(DynamicalWeb::getRoute('settings_setup_mobile_verification', array(
            'callback' => '101'
        )));
    }

    DynamicalWeb::setMemoryObject('intellivoid_accounts', $IntellivoidAccounts);
    DynamicalWeb::setMemoryObject('account', $Account);