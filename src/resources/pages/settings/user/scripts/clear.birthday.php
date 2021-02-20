<?php

    use DynamicalWeb\Actions;
    use DynamicalWeb\DynamicalWeb;
    use IntellivoidAccounts\Abstracts\AuditEventType;
    use IntellivoidAccounts\Abstracts\SearchMethods\AccountSearchMethod;
    use IntellivoidAccounts\IntellivoidAccounts;

    if(isset($_GET['action']))
    {
        if($_GET['action'] == 'clear_birthday')
        {
            try
            {
                clear_birthday();
            }
            catch(Exception $exception)
            {
                Actions::redirect(DynamicalWeb::getRoute('settings/user', array(
                    'callback' => '107'
                )));
            }
        }
    }

    function clear_birthday()
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
        $Account->PersonalInformation->BirthDate->Year = 0;
        $Account->PersonalInformation->BirthDate->Month = 0;
        $Account->PersonalInformation->BirthDate->Day = 0;

        $IntellivoidAccounts->getAccountManager()->updateAccount($Account);
        $IntellivoidAccounts->getAuditLogManager()->logEvent($Account->ID, AuditEventType::PersonalInformationUpdated);

        Actions::redirect(DynamicalWeb::getRoute('settings/user', array(
            'callback' => '108'
        )));
    }