<?php

    use DynamicalWeb\Actions;
    use DynamicalWeb\DynamicalWeb;
    use IntellivoidAccounts\Abstracts\AuditEventType;
    use IntellivoidAccounts\Abstracts\SearchMethods\AccountSearchMethod;
    use IntellivoidAccounts\Exceptions\AccountNotFoundException;
    use IntellivoidAccounts\Exceptions\DatabaseException;
    use IntellivoidAccounts\Exceptions\InvalidAccountStatusException;
    use IntellivoidAccounts\Exceptions\InvalidEmailException;
    use IntellivoidAccounts\Exceptions\InvalidEventTypeException;
    use IntellivoidAccounts\Exceptions\InvalidSearchMethodException;
    use IntellivoidAccounts\Exceptions\InvalidUsernameException;
    use IntellivoidAccounts\IntellivoidAccounts;
    use IntellivoidAccounts\Utilities\Validate;

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        if(isset($_GET['action']))
        {
            if($_GET['action'] == 'update')
            {
                try
                {
                    update_birthday();
                    update_name();
                    update_email();
                    Actions::redirect(DynamicalWeb::getRoute('settings_user', array(
                        'callback' => '120'
                    )));
                }
                catch(Exception $exception)
                {
                    Actions::redirect(DynamicalWeb::getRoute('settings_user', array(
                        'callback' => '104'
                    )));
                }
            }
        }
    }

    /**
     * Updates the birthday if set
     *
     * @throws AccountNotFoundException
     * @throws DatabaseException
     * @throws InvalidAccountStatusException
     * @throws InvalidEmailException
     * @throws InvalidSearchMethodException
     * @throws InvalidUsernameException
     * @throws InvalidEventTypeException
     */
    function update_birthday()
    {
        if(isset($_POST['dob_year']) == false)
        {
            Actions::redirect(DynamicalWeb::getRoute('settings_user', array(
                'callback' => '100'
            )));
        }

        if(isset($_POST['dob_month']) == false)
        {
            Actions::redirect(DynamicalWeb::getRoute('settings_user', array(
                'callback' => '100'
            )));
        }

        if(isset($_POST['dob_day']) == false)
        {
            Actions::redirect(DynamicalWeb::getRoute('settings_user', array(
                'callback' => '100'
            )));
        }

        if(strtolower($_POST['dob_year']) == 'none')
        {
            return;
        }

        if(strtolower($_POST['dob_month']) == 'none')
        {
            return;
        }

        if(strtolower($_POST['dob_day']) == 'none')
        {
            return;
        }

        $DOB_Year = (int)$_POST['dob_year'];
        $DOB_Month = (int)$_POST['dob_month'];
        $DOB_Day = (int)$_POST['dob_day'];

        if($DOB_Year < 1970)
        {
            Actions::redirect(DynamicalWeb::getRoute('settings_user', array(
                'callback' => '105'
            )));
        }

        if($DOB_Year > ((int)date('Y') - 13))
        {
            Actions::redirect(DynamicalWeb::getRoute('settings_user', array(
                'callback' => '105'
            )));
        }

        if($DOB_Month < 1)
        {
            Actions::redirect(DynamicalWeb::getRoute('settings_user', array(
                'callback' => '105'
            )));
        }

        if($DOB_Month > 12)
        {
            Actions::redirect(DynamicalWeb::getRoute('settings_user', array(
                'callback' => '105'
            )));
        }

        if($DOB_Day < 1)
        {
            Actions::redirect(DynamicalWeb::getRoute('settings_user', array(
                'callback' => '105'
            )));
        }

        if($DOB_Day > 31)
        {
            Actions::redirect(DynamicalWeb::getRoute('settings_user', array(
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

        $Account = $IntellivoidAccounts->getAccountManager()->getAccount(AccountSearchMethod::byId, WEB_ACCOUNT_ID);
        $Account->PersonalInformation->BirthDate->Year = $DOB_Year;
        $Account->PersonalInformation->BirthDate->Month = $DOB_Month;
        $Account->PersonalInformation->BirthDate->Day = $DOB_Day;
        $IntellivoidAccounts->getAccountManager()->updateAccount($Account);
        $IntellivoidAccounts->getAuditLogManager()->logEvent($Account->ID, AuditEventType::PersonalInformationUpdated);
    }

    /**
     * Updates the user's email address if it has changed
     *
     * @throws AccountNotFoundException
     * @throws DatabaseException
     * @throws InvalidAccountStatusException
     * @throws InvalidEmailException
     * @throws InvalidEventTypeException
     * @throws InvalidSearchMethodException
     * @throws InvalidUsernameException
     */
    function update_email()
    {
        if(isset($_POST['email']) == false)
        {
            Actions::redirect(DynamicalWeb::getRoute('settings_user', array(
                'callback' => '100'
            )));
        }

        if(Validate::email($_POST['email']) == false)
        {
            Actions::redirect(DynamicalWeb::getRoute('settings_user', array(
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

        $Account = $IntellivoidAccounts->getAccountManager()->getAccount(AccountSearchMethod::byId, WEB_ACCOUNT_ID);

        if($_POST['email'] === $Account->Email)
        {
            return;
        }

        try
        {
            $IntellivoidAccounts->getAccountManager()->getAccount(AccountSearchMethod::byEmail, $_POST['email']);
            Actions::redirect(DynamicalWeb::getRoute('settings_user', array(
                'callback' => '118'
            )));
        }
        catch(Exception $e)
        {
            unset($e);
        }

        $Account->Email = $_POST['email'];
        $IntellivoidAccounts->getAccountManager()->updateAccount($Account);
        $IntellivoidAccounts->getAuditLogManager()->logEvent($Account->ID, AuditEventType::EmailUpdated);
    }

    /**
     * Updates the user's first and last name if set
     *
     * @throws AccountNotFoundException
     * @throws DatabaseException
     * @throws InvalidAccountStatusException
     * @throws InvalidEmailException
     * @throws InvalidEventTypeException
     * @throws InvalidSearchMethodException
     * @throws InvalidUsernameException
     */
    function update_name()
    {
        if(isset($_POST['first_name']) == false)
        {
            Actions::redirect(DynamicalWeb::getRoute('settings_user', array(
                'callback' => '100'
            )));
        }

        if(isset($_POST['last_name']) == false)
        {
            Actions::redirect(DynamicalWeb::getRoute('settings_user', array(
                'callback' => '100'
            )));
        }

        if(strlen($_POST['first_name']) == 0)
        {
            return;
        }

        if(strlen($_POST['last_name']) == 0)
        {
            Actions::redirect(DynamicalWeb::getRoute('settings_user', array(
                'callback' => '102'
            )));

            return;
        }

        if(preg_match("/^([a-zA-Z' ]+)$/",$_POST['first_name']) == false)
        {
            Actions::redirect(DynamicalWeb::getRoute('settings_user', array(
                'callback' => '101'
            )));
        }

        if(strlen($_POST['first_name']) > 46)
        {
            Actions::redirect(DynamicalWeb::getRoute('settings_user', array(
                'callback' => '101'
            )));
        }

        if(strlen($_POST['first_name']) < 1)
        {
            Actions::redirect(DynamicalWeb::getRoute('settings_user', array(
                'callback' => '101'
            )));
        }

        if(preg_match("/^([a-zA-Z' ]+)$/",$_POST['last_name']) == false)
        {
            Actions::redirect(DynamicalWeb::getRoute('settings_user', array(
                'callback' => '102'
            )));
        }

        if(strlen($_POST['last_name']) > 64)
        {
            Actions::redirect(DynamicalWeb::getRoute('settings_user', array(
                'callback' => '102'
            )));
        }

        if(strlen($_POST['last_name']) < 1)
        {
            Actions::redirect(DynamicalWeb::getRoute('settings_user', array(
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

        $Account = $IntellivoidAccounts->getAccountManager()->getAccount(AccountSearchMethod::byId, WEB_ACCOUNT_ID);

        $FirstNameUpdated = false;
        $LastNameUpdated = false;

        if($Account->PersonalInformation->FirstName != $_POST['first_name'])
        {
            $FirstNameUpdated = true;
        }

        if($Account->PersonalInformation->LastName != $_POST['last_name'])
        {
            $LastNameUpdated = true;
        }

        if(($FirstNameUpdated == false) && ($LastNameUpdated == false))
        {
            return;
        }

        $Account->PersonalInformation->FirstName = $_POST['first_name'];
        $Account->PersonalInformation->LastName = $_POST['last_name'];
        $IntellivoidAccounts->getAccountManager()->updateAccount($Account);
        $IntellivoidAccounts->getAuditLogManager()->logEvent($Account->ID, AuditEventType::PersonalInformationUpdated);
    }