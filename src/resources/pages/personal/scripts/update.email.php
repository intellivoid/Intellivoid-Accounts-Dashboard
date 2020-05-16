<?php

    use DynamicalWeb\Actions;
    use DynamicalWeb\DynamicalWeb;
    use IntellivoidAccounts\Abstracts\AuditEventType;
    use IntellivoidAccounts\Abstracts\SearchMethods\AccountSearchMethod;
    use IntellivoidAccounts\IntellivoidAccounts;
    use IntellivoidAccounts\Utilities\Validate;

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        if(isset($_GET['action']))
        {
            if($_GET['action'] == 'update_email')
            {
                try
                {
                    update_email();
                }
                catch(Exception $exception)
                {
                    Actions::redirect(DynamicalWeb::getRoute('personal', array(
                        'callback' => '116'
                    )));
                }
            }
        }
    }

    function update_email()
    {
        if(isset($_POST['email_address']) == false)
        {
            Actions::redirect(DynamicalWeb::getRoute('personal', array(
                'callback' => '100'
            )));
        }

        if(Validate::email($_POST['email_address']) == false)
        {
            Actions::redirect(DynamicalWeb::getRoute('personal', array(
                'callback' => '117'
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

        try
        {
            $IntellivoidAccounts->getAccountManager()->getAccount(AccountSearchMethod::byEmail, $_POST['email_address']);
            Actions::redirect(DynamicalWeb::getRoute('personal', array(
                'callback' => '118'
            )));
        }
        catch(Exception $e)
        {
            unset($e);
        }

        $Account = $IntellivoidAccounts->getAccountManager()->getAccount(AccountSearchMethod::byId, WEB_ACCOUNT_ID);
        $Account->Email = $_POST['email_address'];
        $IntellivoidAccounts->getAccountManager()->updateAccount($Account);
        $IntellivoidAccounts->getAuditLogManager()->logEvent($Account->ID, AuditEventType::EmailUpdated);

        Actions::redirect(DynamicalWeb::getRoute('personal', array(
            'callback' => '119'
        )));
    }