<?php

    use DynamicalWeb\Runtime;
    use IntellivoidAccounts\Abstracts\SearchMethods\AccountSearchMethod;
use IntellivoidAccounts\Abstracts\SearchMethods\TelegramClientSearchMethod;
use IntellivoidAccounts\IntellivoidAccounts;
    
    Runtime::import('IntellivoidAccounts');
    
    if(isset($_GET['send']))
    {
        $IntellivoidAccounts = new IntellivoidAccounts();
        $Account = $IntellivoidAccounts->getAccountManager()->getAccount(AccountSearchMethod::byId, WEB_ACCOUNT_ID);
        
        $TelegramClient = $IntellivoidAccounts->getTelegramClientManager()->getClient(
            TelegramClientSearchMethod::byId,
            $Account->Configuration->VerificationMethods->TelegramLink->ClientId
        );
    }