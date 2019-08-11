<?php

    use DynamicalWeb\DynamicalWeb;
    use IntellivoidAccounts\IntellivoidAccounts;

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

    $Account = $IntellivoidAccounts->getAccountManager()->getAccount(\IntellivoidAccounts\Abstracts\SearchMethods\AccountSearchMethod::byId, WEB_ACCOUNT_ID);

    if($Account->PersonalInformation->FirstName == null)
    {
        define("USER_FIRST_NAME", "", false);
    }
    else
    {
        define("USER_FIRST_NAME", "value=\"" . htmlspecialchars($Account->PersonalInformation->FirstName, ENT_QUOTES, 'UTF-8') . "\"", false);
    }

    if($Account->PersonalInformation->LastName == null)
    {
        define("USER_LAST_NAME", "", false);
    }
    else
    {
        define("USER_LAST_NAME", "value=\"" . htmlspecialchars($Account->PersonalInformation->LastName, ENT_QUOTES, 'UTF-8') . "\"", false);
    }