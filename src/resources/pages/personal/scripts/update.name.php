<?php

    use DynamicalWeb\Actions;
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
                    Actions::redirect(DynamicalWeb::getRoute('personal', array(
                        'callback' => '104'
                    )));
                }
            }
        }
    }

    function update_name()
    {
        if(isset($_POST['first_name']) == false)
        {
            Actions::redirect(DynamicalWeb::getRoute('personal', array(
                'callback' => '100'
            )));
        }

        if(isset($_POST['last_name']) == false)
        {
            Actions::redirect(DynamicalWeb::getRoute('personal', array(
                'callback' => '100'
            )));
        }

        if(preg_match("/^([a-zA-Z' ]+)$/",$_POST['first_name']) == false)
        {
            Actions::redirect(DynamicalWeb::getRoute('personal', array(
                'callback' => '104'
            )));
        }

        if(strlen($_POST['first_name']) > 46)
        {
            Actions::redirect(DynamicalWeb::getRoute('personal', array(
                'callback' => '101'
            )));
        }

        if(strlen($_POST['first_name']) < 1)
        {
            Actions::redirect(DynamicalWeb::getRoute('personal', array(
                'callback' => '101'
            )));
        }

        if(preg_match("/^([a-zA-Z' ]+)$/",$_POST['last_name']) == false)
        {
            Actions::redirect(DynamicalWeb::getRoute('personal', array(
                'callback' => '102'
            )));
        }

        if(strlen($_POST['last_name']) > 64)
        {
            Actions::redirect(DynamicalWeb::getRoute('personal', array(
                'callback' => '102'
            )));
        }

        if(strlen($_POST['last_name']) < 1)
        {
            Actions::redirect(DynamicalWeb::getRoute('personal', array(
                'callback' => '102'
            )));
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

        Actions::redirect(DynamicalWeb::getRoute('personal', array(
            'callback' => '103'
        )));
    }