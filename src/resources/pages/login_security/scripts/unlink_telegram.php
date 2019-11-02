<?php

    use DynamicalWeb\Actions;
    use DynamicalWeb\DynamicalWeb;
use IntellivoidAccounts\Abstracts\AuditEventType;
use IntellivoidAccounts\Abstracts\SearchMethods\TelegramClientSearchMethod;
use IntellivoidAccounts\Exceptions\TelegramClientNotFoundException;
use IntellivoidAccounts\IntellivoidAccounts;
    use IntellivoidAccounts\Objects\Account;

    if(isset($_GET['action']))
    {
        if($_GET['action'] == 'unlink_telegram')
        {
            unlink_telegram();
        }
    }


    function unlink_telegram()
    {
        /** @var Account $Account */
        $Account = DynamicalWeb::getMemoryObject('account');

        if($Account->Configuration->VerificationMethods->TelegramClientLinked == false)
        {
            Actions::redirect(DynamicalWeb::getRoute('login_security', array(
                'callback' => '113'
            )));
        }

        /** @var IntellivoidAccounts $IntellivoidAccounts */
        $IntellivoidAccounts = DynamicalWeb::getMemoryObject('intellivoid_accounts');

        try
        {
            $TelegramClient = $IntellivoidAccounts->getTelegramClientManager()->getClient(
                TelegramClientSearchMethod::byId, $Account->Configuration->VerificationMethods->TelegramLink->ClientId
            );
        }
        catch (TelegramClientNotFoundException $e)
        {
            Actions::redirect(DynamicalWeb::getRoute('login_security', array(
                'callback' => '109'
            )));
        }
        catch(Exception $exception)
        {
            Actions::redirect(DynamicalWeb::getRoute('login_security', array(
                'callback' => '110'
            )));
        }

        /** @noinspection PhpUndefinedVariableInspection */
        $TelegramClient->AccountID = 0;

        $Account->Configuration->VerificationMethods->TelegramLink->disable();
        $Account->Configuration->VerificationMethods->TelegramClientLinked = false;

        $IntellivoidAccounts->getAuditLogManager()->logEvent($Account->ID, AuditEventType::TelegramVerificationDisabled);
        $IntellivoidAccounts->getAccountManager()->updateAccount($Account);
        $IntellivoidAccounts->getTelegramClientManager()->updateClient($TelegramClient);

        Actions::redirect(DynamicalWeb::getRoute('login_security', array(
            'callback' => '114'
        )));
    }