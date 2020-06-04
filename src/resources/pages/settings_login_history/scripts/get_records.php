<?php

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

    DynamicalWeb::setInt32('total_items', $IntellivoidAccounts->getLoginRecordManager()->getTotalRecords(
        LoginRecordMultiSearchMethod::byAccountId, WEB_ACCOUNT_ID
    ));

    DynamicalWeb::setInt32('total_pages', ceil(DynamicalWeb::getInt32('total_items') / 50));


    $CurrentPage = 1;
    if(isset($_GET['page']))
    {
        $CurrentPage = (int)$_GET['page'];
    }

    if($CurrentPage < 1)
    {
        $CurrentPage = 1;
    }


    if($CurrentPage > DynamicalWeb::getInt32('total_pages'))
    {
        $CurrentPage = DynamicalWeb::getInt32('total_pages') + 1;
    }

    DynamicalWeb::setInt32('current_page', $CurrentPage);

    $StartingItem = 0;

    if($CurrentPage > 1)
    {
        $StartingItem = 50 * $CurrentPage - 50;
    }

    try
    {

        $Results = $IntellivoidAccounts->getLoginRecordManager()->searchRecords(
            LoginRecordMultiSearchMethod::byAccountId, WEB_ACCOUNT_ID,
            50, (int)$StartingItem
        );
    }
    catch(Exception $exception)
    {
        $Results = [];
    }

    $IntellivoidAccounts = DynamicalWeb::setArray(
        "search_results", $Results
    );