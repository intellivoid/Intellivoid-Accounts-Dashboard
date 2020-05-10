<?php

    use DynamicalWeb\Actions;
    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use IntellivoidAccounts\Abstracts\LoginStatus;
    use IntellivoidAccounts\Abstracts\SearchMethods\TelegramClientSearchMethod;
    use IntellivoidAccounts\IntellivoidAccounts;
    use IntellivoidAccounts\Objects\Account;
    use sws\sws;


    if(isset($_GET['action']))
    {
        if($_GET['action'] == 'verify')
        {
            verify_prompt();
        }
    }

    function verify_prompt()
    {
        /** @var IntellivoidAccounts $IntellivoidAccounts */
        $IntellivoidAccounts = DynamicalWeb::getMemoryObject("intellivoid_accounts");

        /** @var Account $Account */
        $Account = DynamicalWeb::getMemoryObject('account');

        $GetParameters = $_GET;
        unset($GetParameters['callback']);
        unset($GetParameters['incorrect_auth']);
        unset($GetParameters['action']);

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
            Actions::redirect(DynamicalWeb::getRoute('verify', $GetParameters));
        }

        $authenticated = false;

        try
        {
            /** @noinspection PhpUndefinedVariableInspection */
            if($IntellivoidAccounts->getTelegramService()->pollAuthPrompt($TelegramClient) == true)
            {
                $IntellivoidAccounts->getTelegramService()->closePrompt($TelegramClient, true);
                $authenticated = true;
            }
        }
        catch(Exception $e)
        {
            unset($e);
        }

        if($authenticated == true)
        {
            $Host = get_host();

            /** @var sws $sws */
            $sws = DynamicalWeb::getMemoryObject('sws');
            $Cookie = $sws->WebManager()->getCookie('intellivoid_secured_web_session');

            $Cookie->Data["verification_required"] = false;
            $Cookie->Data["auto_logout"] = 0;
            $Cookie->Data["verification_attempts"] = 0;

            $sws->CookieManager()->updateCookie($Cookie);

            $IntellivoidAccounts->getLoginRecordManager()->createLoginRecord(
                $Account->ID, $Host->ID,
                LoginStatus::Successful, 'Intellivoid Accounts',
                CLIENT_USER_AGENT
            );

            HTML::importScript('sync_avatar');
            Actions::redirect(DynamicalWeb::getRoute('index', $GetParameters));
            exit();
        }
    }
