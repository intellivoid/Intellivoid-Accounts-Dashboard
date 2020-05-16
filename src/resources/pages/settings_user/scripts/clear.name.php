<?php

    use DynamicalWeb\Actions;
    use DynamicalWeb\DynamicalWeb;
    use IntellivoidAccounts\Abstracts\AuditEventType;
    use IntellivoidAccounts\Abstracts\SearchMethods\AccountSearchMethod;
    use IntellivoidAccounts\IntellivoidAccounts;

    if(isset($_GET['action']))
    {
        if($_GET['action'] == 'clear_name')
        {
            try
            {
                clear_name();
            }
            catch(Exception $exception)
            {
                Actions::redirect(DynamicalWeb::getRoute('settings_user', array(
                    'callback' => '107'
                )));
            }
        }
    }

    function clear_name()
    {
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

        $Account = $IntellivoidAccounts->getAccountManager()->getAccount(AccountSearchMethod::byId, WEB_ACCOUNT_ID);
        $Account->PersonalInformation->FirstName = null;
        $Account->PersonalInformation->LastName = null;
        $IntellivoidAccounts->getAccountManager()->updateAccount($Account);
        $IntellivoidAccounts->getAuditLogManager()->logEvent($Account->ID, AuditEventType::PersonalInformationUpdated);

        Actions::redirect(DynamicalWeb::getRoute('settings_user', array(
            'callback' => '109'
        )));
    }