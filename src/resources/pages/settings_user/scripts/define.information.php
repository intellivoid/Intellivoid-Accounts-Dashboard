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

    if($Account->PersonalInformation->FirstName == null)
    {
        if($Account->PersonalInformation->LastName == null)
        {
            define("USER_NAME_SET", false, false);
        }
        else
        {
            define("USER_NAME_SET", true, false);
        }
    }
    else
    {
        define("USER_NAME_SET", true, false);
    }

    if($Account->PersonalInformation->BirthDate->Year == 0)
    {
        define("USER_BOD_SET", false, false);
        define("USER_BOD_YEAR", "", false);
    }
    else
    {
        define("USER_BOD_SET", true, false);
        define("USER_BOD_YEAR", $Account->PersonalInformation->BirthDate->Year, false);
    }

    if($Account->PersonalInformation->BirthDate->Month == 0)
    {
        define("USER_BOD_MONTH", "", false);
    }
    else
    {
        define("USER_BOD_MONTH", $Account->PersonalInformation->BirthDate->Month, false);
    }

    if($Account->PersonalInformation->BirthDate->Day == 0)
    {
        define("USER_BOD_DAY", "", false);
    }
    else
    {
        define("USER_BOD_DAY", $Account->PersonalInformation->BirthDate->Day, false);
    }

    define("USER_EMAIL", "value=\"" . htmlspecialchars($Account->Email, ENT_QUOTES, 'UTF-8') . "\"", false);