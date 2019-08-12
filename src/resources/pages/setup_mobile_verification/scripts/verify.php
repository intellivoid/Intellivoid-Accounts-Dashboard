<?php

    use DynamicalWeb\Runtime;
    use IntellivoidAccounts\Abstracts\SearchMethods\AccountSearchMethod;
    use IntellivoidAccounts\IntellivoidAccounts;

    Runtime::import('IntellivoidAccounts');

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        if(isset($_GET['action']))
        {
            if($_GET['action'] == 'verify')
            {
                verify_code();
            }
        }
    }

    function verify_code()
    {
        if(isset($_POST['verification_code']) == false)
        {
            header('Location: /setup_mobile_verification?callback=100');
            exit();
        }
        
        $IntellivoidAccounts = new IntellivoidAccounts();
        $Account = $IntellivoidAccounts->getAccountManager()->getAccount(AccountSearchMethod::byId, WEB_ACCOUNT_ID);
    }

