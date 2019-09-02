<?php

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\Runtime;
    use IntellivoidAccounts\Abstracts\SearchMethods\AccountSearchMethod;
    use IntellivoidAccounts\IntellivoidAccounts;
    use IntellivoidAccounts\Utilities\Hashing;
    use IntellivoidAccounts\Utilities\Validate;

    Runtime::import('IntellivoidAccounts');

    if(isset($_GET['action']))
    {
        if($_GET['action'] == 'update_password')
        {
            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                update_password();
            }
        }
    }

    function update_password()
    {
        if(isset($_POST['current_password']) == false)
        {
            header('Location: /?callback=100');
            exit();
        }

        if(isset($_POST['new_password']) == false)
        {
            header('Location: /?callback=100');
            exit();
        }

        if(isset($_POST['confirm_password']) == false)
        {
            header('Location: /?callback=100');
            exit();
        }

        // Define the important parts
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

        $AccountObject = $IntellivoidAccounts->getAccountManager()->getAccount(AccountSearchMethod::byId, WEB_ACCOUNT_ID);

        if(Validate::verifyHashedPassword($_POST['current_password'], $AccountObject->Password) == false)
        {
            header('Location: /?callback=101');
            exit();
        }

        if(Hashing::password($_POST['new_password']) !== Hashing::password($_POST['confirm_password']))
        {
            header('Location: /?callback=102');
            exit();
        }

        $AccountObject->updatePassword($_POST['new_password']);
        $IntellivoidAccounts->getAccountManager()->updateAccount($AccountObject);

        header('Location: /?callback=103');
        exit();
    }