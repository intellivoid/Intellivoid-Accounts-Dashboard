<?php

    use DynamicalWeb\DynamicalWeb;
    use IntellivoidAccounts\IntellivoidAccounts;

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        if(isset($_GET['action']))
        {
            if($_GET['action'] == 'update_name')
            {
                try
                {
                    update_name();
                }
                catch(Exception $exception)
                {
                    header('Location: /personal?callback=104');
                    exit();
                }
            }
        }
    }

    function update_name()
    {
        if(isset($_POST['first_name']) == false)
        {
            header('Location: /personal?callback=100');
            exit();
        }

        if(isset($_POST['last_name']) == false)
        {
            header('Location: /personal?callback=100');
            exit();
        }

        if(preg_match("/^([a-zA-Z' ]+)$/",$_POST['first_name']) == false)
        {
            header('Location: /personal?callback=101');
            exit();
        }

        if(strlen($_POST['first_name']) > 46)
        {
            header('Location: /personal?callback=101');
            exit();
        }

        if(strlen($_POST['first_name']) < 1)
        {
            header('Location: /personal?callback=101');
            exit();
        }

        if(preg_match("/^([a-zA-Z' ]+)$/",$_POST['last_name']) == false)
        {
            header('Location: /personal?callback=102');
            exit();
        }

        if(strlen($_POST['last_name']) > 64)
        {
            header('Location: /personal?callback=102');
            exit();
        }

        if(strlen($_POST['last_name']) < 1)
        {
            header('Location: /personal?callback=102');
            exit();
        }


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

        $Account = $IntellivoidAccounts->getAccountManager()->getAccount(\IntellivoidAccounts\Abstracts\SearchMethods\AccountSearchMethod::byId, WEB_ACCOUNT_ID);
        $Account->PersonalInformation->FirstName = $_POST['first_name'];
        $Account->PersonalInformation->LastName = $_POST['last_name'];
        $IntellivoidAccounts->getAccountManager()->updateAccount($Account);

        header('Location: /personal?callback=103');
        exit();
    }