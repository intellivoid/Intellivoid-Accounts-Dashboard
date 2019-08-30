<?php

    use asas\Exceptions\DatabaseException;
    use DynamicalWeb\DynamicalWeb;
    use IntellivoidAccounts\Abstracts\SearchMethods\LoginRecordMultiSearchMethod;
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

    try
    {

        $Results = $IntellivoidAccounts->getLoginRecordManager()->searchRecords(LoginRecordMultiSearchMethod::byAccountId, WEB_ACCOUNT_ID);
    }
    catch(Exception $exception)
    {
        $Results = [];
    }

    $IntellivoidAccounts = DynamicalWeb::setArray(
        "search_results", $Results
    );