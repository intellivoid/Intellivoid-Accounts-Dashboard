<?php

    use DynamicalWeb\Actions;
    use DynamicalWeb\DynamicalWeb;
    use IntellivoidAccounts\IntellivoidAccounts;

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        if(isset($_GET['action']))
        {
            if($_GET['action'] == 'update_birthday')
            {
                try
                {
                    update_birthday();
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

    function update_birthday()
    {
        if(isset($_POST['dob_year']) == false)
        {
            Actions::redirect(DynamicalWeb::getRoute('personal', array(
                'callback' => '100'
            )));
        }

        if(isset($_POST['dob_month']) == false)
        {
            Actions::redirect(DynamicalWeb::getRoute('personal', array(
                'callback' => '100'
            )));
        }

        if(isset($_POST['dob_day']) == false)
        {
            Actions::redirect(DynamicalWeb::getRoute('personal', array(
                'callback' => '100'
            )));
        }

        $DOB_Year = (int)$_POST['dob_year'];
        $DOB_Month = (int)$_POST['dob_month'];
        $DOB_Day = (int)$_POST['dob_day'];

        if($DOB_Year < 1970)
        {
            Actions::redirect(DynamicalWeb::getRoute('personal', array(
                'callback' => '105'
            )));
        }

        if($DOB_Year > ((int)date('Y') - 13))
        {
            Actions::redirect(DynamicalWeb::getRoute('personal', array(
                'callback' => '105'
            )));
        }

        if($DOB_Month < 1)
        {
            Actions::redirect(DynamicalWeb::getRoute('personal', array(
                'callback' => '105'
            )));
        }

        if($DOB_Month > 12)
        {
            Actions::redirect(DynamicalWeb::getRoute('personal', array(
                'callback' => '105'
            )));
        }

        if($DOB_Day < 1)
        {
            Actions::redirect(DynamicalWeb::getRoute('personal', array(
                'callback' => '105'
            )));
        }

        if($DOB_Day > 31)
        {
            Actions::redirect(DynamicalWeb::getRoute('personal', array(
                'callback' => '105'
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
        $Account->PersonalInformation->BirthDate->Year = $DOB_Year;
        $Account->PersonalInformation->BirthDate->Month = $DOB_Month;
        $Account->PersonalInformation->BirthDate->Day = $DOB_Day;
        $IntellivoidAccounts->getAccountManager()->updateAccount($Account);

        Actions::redirect(DynamicalWeb::getRoute('personal', array(
            'callback' => '106'
        )));
    }