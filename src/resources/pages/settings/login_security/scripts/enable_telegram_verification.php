<?php


    use DynamicalWeb\Actions;
    use DynamicalWeb\DynamicalWeb;
    use IntellivoidAccounts\Abstracts\AuditEventType;
    use IntellivoidAccounts\IntellivoidAccounts;
    use IntellivoidAccounts\Objects\Account;
    use TelegramClientManager\Abstracts\SearchMethods\TelegramClientSearchMethod;
    use TelegramClientManager\Exceptions\TelegramClientNotFoundException;

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
            Actions::redirect(DynamicalWeb::getRoute('settings/login_security'));
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
        catch(Exception $e)
        {
            Actions::redirect(DynamicalWeb::getRoute('settings/login_security', array(
                'callback' => '110'
            )));
        }

        /** @noinspection PhpUndefinedVariableInspection */
        if($TelegramClient->AccountID !== null)
        {
            Actions::redirect(DynamicalWeb::getRoute('settings/login_security', array(
                'callback' => '111'
            )));
        }

        if(isset($_GET["hash"]) == false)
        {
            Actions::redirect(DynamicalWeb::getRoute('settings/login_security', array(
                'callback' => '109', 'clause' => 'missing_hash'
            )));
        }

        if(isset($_GET["verification_sign"]) == false)
        {
            Actions::redirect(DynamicalWeb::getRoute('settings/login_security', array(
                'callback' => '109', 'clause' => 'missing_verification'
            )));
        }

        $VerificationSign = hash("sha256", $_GET["hash"] . $TelegramClient->ID);
        if($VerificationSign !== $_GET["verification_sign"])
        {
            Actions::redirect(DynamicalWeb::getRoute('settings/login_security', array(
                'callback' => '109', 'clause' => 'bad_verification'
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
            $IntellivoidAccounts->getTelegramClientManager()->updateClient($TelegramClient, false, true);
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