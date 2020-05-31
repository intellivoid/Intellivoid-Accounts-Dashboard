<?php

    use DynamicalWeb\Actions;
    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\Runtime;
    use IntellivoidAccounts\Abstracts\AuditEventType;
    use IntellivoidAccounts\Abstracts\SearchMethods\AccountSearchMethod;
    use IntellivoidAccounts\IntellivoidAccounts;
    use IntellivoidAccounts\Utilities\Hashing;
    use IntellivoidAccounts\Utilities\Validate;
    use pwc\pwc;

    Runtime::import('IntellivoidAccounts');
    Runtime::import('PwCompromission');

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
        $RedirectPage = 'index';

        if(isset($_GET['redirect']))
        {
            if($_GET['redirect'] == 'settings_password')
            {
                $RedirectPage = 'settings_password';
            }
        }

        if(isset($_POST['current_password']) == false)
        {
            Actions::redirect(DynamicalWeb::getRoute($RedirectPage, array(
                'callback' => '100'
            )));
        }

        if(isset($_POST['new_password']) == false)
        {
            Actions::redirect(DynamicalWeb::getRoute($RedirectPage, array(
                'callback' => '100'
            )));
        }

        if(isset($_POST['confirm_password']) == false)
        {
            Actions::redirect(DynamicalWeb::getRoute($RedirectPage, array(
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
            Actions::redirect(DynamicalWeb::getRoute($RedirectPage, array(
                'callback' => '101'
            )));
        }

        if(Hashing::password($_POST['new_password']) !== Hashing::password($_POST['confirm_password']))
        {
            Actions::redirect(DynamicalWeb::getRoute($RedirectPage, array(
                'callback' => '102'
            )));
        }

        if(Validate::password($_POST['new_password']) == false)
        {
            {
                Actions::redirect(DynamicalWeb::getRoute($RedirectPage, array(
                    'callback' => '116'
                )));
            }

            if($RedirectPage == "settings_password")
            {
                Actions::redirect(DynamicalWeb::getRoute($RedirectPage, array(
                    'callback' => '105'
                )));
            }
        }

        $pwc = new pwc();

        try
        {
            $PasswordCache = $pwc->checkPassword($_POST['new_password']);

            if($PasswordCache->Compromised)
            {
                if($RedirectPage == "index")
                {
                    Actions::redirect(DynamicalWeb::getRoute($RedirectPage, array(
                        'callback' => '115'
                    )));
                }

                if($RedirectPage == "settings_password")
                {
                    Actions::redirect(DynamicalWeb::getRoute($RedirectPage, array(
                        'callback' => '104'
                    )));
                }
            }
        }
        catch(Exception $exception)
        {
            unset($exception);
        }

        $AccountObject->updatePassword($_POST['new_password']);
        $IntellivoidAccounts->getAccountManager()->updateAccount($AccountObject);
        $IntellivoidAccounts->getAuditLogManager()->logEvent($AccountObject->ID, AuditEventType::PasswordUpdated);
        Actions::redirect(DynamicalWeb::getRoute($RedirectPage, array(
            'callback' => '103'
        )));
    }