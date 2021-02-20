<?php


    use DynamicalWeb\Actions;
    use DynamicalWeb\DynamicalWeb;
    use IntellivoidAccounts\Abstracts\AuditEventType;
    use IntellivoidAccounts\Abstracts\SearchMethods\TelegramClientSearchMethod;
    use IntellivoidAccounts\Exceptions\TelegramClientNotFoundException;
    use IntellivoidAccounts\IntellivoidAccounts;
    use IntellivoidAccounts\Objects\Account;

    if(isset($_GET['auth']))
    {
        if($_GET['auth'] == 'telegram')
        {
            if(isset($_GET['client_id']))
            {
                setupTelegramAuth();
            }
        }
    }


    function setupTelegramAuth()
    {
        /** @var Account $Account */
        $Account = DynamicalWeb::getMemoryObject('account');

        if($Account->Configuration->VerificationMethods->TelegramClientLinked == true)
        {
            Actions::redirect(DynamicalWeb::getRoute('settings/login_security', array(
                'callback' => '108'
            )));
        }

        /** @var IntellivoidAccounts $IntellivoidAccounts */
        $IntellivoidAccounts = DynamicalWeb::getMemoryObject('intellivoid_accounts');

        try
        {
            $TelegramClient = $IntellivoidAccounts->getTelegramClientManager()->getClient(
                TelegramClientSearchMethod::byPublicId, $_GET['client_id']
            );
        }
        catch (TelegramClientNotFoundException $e)
        {
            Actions::redirect(DynamicalWeb::getRoute('settings/login_security', array(
                'callback' => '109'
            )));
        }
        catch(Exception $exception)
        {
            Actions::redirect(DynamicalWeb::getRoute('settings/login_security', array(
                'callback' => '110'
            )));
        }

        /** @noinspection PhpUndefinedVariableInspection */
        if($TelegramClient->AccountID !== 0)
        {
            Actions::redirect(DynamicalWeb::getRoute('settings/login_security', array(
                'callback' => '111'
            )));
        }

        $Account->Configuration->VerificationMethods->TelegramClientLinked = true;
        $Account->Configuration->VerificationMethods->TelegramLink->enable($TelegramClient->ID);
        $TelegramClient->AccountID = $Account->ID;

        try
        {
            $IntellivoidAccounts->getAccountManager()->updateAccount($Account);
        }
        catch(Exception $e)
        {
            Actions::redirect(DynamicalWeb::getRoute('settings/login_security', array(
                'callback' => '110'
            )));
        }

        try
        {
            $IntellivoidAccounts->getAuditLogManager()->logEvent($Account->ID, AuditEventType::TelegramVerificationEnabled);
            $IntellivoidAccounts->getTelegramClientManager()->updateClient($TelegramClient);
            $IntellivoidAccounts->getTelegramService()->sendLinkedNotification($TelegramClient);
        }
        catch(Exception $e)
        {
            Actions::redirect(DynamicalWeb::getRoute('settings/login_security', array(
                'callback' => '110'
            )));
        }

        Actions::redirect(DynamicalWeb::getRoute('settings/login_security', array(
            'callback' => '112'
        )));
    }