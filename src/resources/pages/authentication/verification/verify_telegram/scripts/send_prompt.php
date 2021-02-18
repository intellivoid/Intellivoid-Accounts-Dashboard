<?php

    use DynamicalWeb\Actions;
    use DynamicalWeb\DynamicalWeb;
    use IntellivoidAccounts\Exceptions\TooManyPromptRequestsException;
    use IntellivoidAccounts\IntellivoidAccounts;
    use IntellivoidAccounts\Objects\Account;
    use TelegramClientManager\Abstracts\SearchMethods\TelegramClientSearchMethod;

    /** @var IntellivoidAccounts $IntellivoidAccounts */
    $IntellivoidAccounts = DynamicalWeb::getMemoryObject("intellivoid_accounts");

    /** @var Account $Account */
    $Account = DynamicalWeb::getMemoryObject('account');

    try
    {
        $TelegramClient = $IntellivoidAccounts->getTelegramClientManager()->getClient(
            TelegramClientSearchMethod::byId,
            $Account->Configuration->VerificationMethods->TelegramLink->ClientId
        );
    }
    catch(Exception $exception)
    {
        $_GET['callback'] = '101';
        Actions::redirect(DynamicalWeb::getRoute('authentication/verification/verify', $_GET));
    }

    try
    {
        $IntellivoidAccounts->getTelegramService()->promptAuth(
            $TelegramClient, $Account->Username, CLIENT_USER_AGENT, get_host()->ID
        );
    }
    catch (TooManyPromptRequestsException $e)
    {
        $_GET['callback'] = '102';
        Actions::redirect(DynamicalWeb::getRoute('authentication/verification/verify', $_GET));
    }
    catch(Exception $e)
    {
        $_GET['callback'] = '103';
        Actions::redirect(DynamicalWeb::getRoute('authentication/verification/verify', $_GET));
    }