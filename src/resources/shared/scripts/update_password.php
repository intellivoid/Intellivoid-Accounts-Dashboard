<?php

    use DynamicalWeb\Actions;
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
            Actions::redirect(DynamicalWeb::getRoute('index', array(
                'callback' => '100'
            )));
        }

        if(isset($_POST['new_password']) == false)
        {
            Actions::redirect(DynamicalWeb::getRoute('index', array(
                'callback' => '100'
            )));
        }

        if(isset($_POST['confirm_password']) == false)
        {
            Actions::redirect(DynamicalWeb::getRoute('index', array(
                'callback' => '100'
            )));
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
            Actions::redirect(DynamicalWeb::getRoute('index', array(
                'callback' => '101'
            )));
        }

        if(Hashing::password($_POST['new_password']) !== Hashing::password($_POST['confirm_password']))
        {
            Actions::redirect(DynamicalWeb::getRoute('index', array(
                'callback' => '102'
            )));
        }

        $AccountObject->updatePassword($_POST['new_password']);
        $IntellivoidAccounts->getAccountManager()->updateAccount($AccountObject);
        Actions::redirect(DynamicalWeb::getRoute('index', array(
            'callback' => '103'
        )));
    }