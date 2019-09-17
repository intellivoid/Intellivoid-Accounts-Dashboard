<?php

    use DynamicalWeb\Actions;
    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use DynamicalWeb\Runtime;
    use IntellivoidAccounts\Exceptions\AccountNotFoundException;
    use IntellivoidAccounts\Exceptions\DatabaseException;
    use IntellivoidAccounts\Exceptions\EmailAlreadyExistsException;
    use IntellivoidAccounts\Exceptions\InvalidEmailException;
    use IntellivoidAccounts\Exceptions\InvalidPasswordException;
    use IntellivoidAccounts\Exceptions\InvalidSearchMethodException;
    use IntellivoidAccounts\Exceptions\InvalidUsernameException;
    use IntellivoidAccounts\Exceptions\UsernameAlreadyExistsException;
    use IntellivoidAccounts\IntellivoidAccounts;

    Runtime::import('IntellivoidAccounts');

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        try
        {
            register_account();
            HTML::importScript('sync_avatar');
            Actions::redirect(DynamicalWeb::getRoute('login', array(
                'callback' => '106'
            )));
        }
        catch(InvalidUsernameException $invalidUsernameException)
        {
            Actions::redirect(DynamicalWeb::getRoute('register', array(
                'callback' => '102'
            )));
        }
        catch(InvalidEmailException $invalidEmailException)
        {
            Actions::redirect(DynamicalWeb::getRoute('register', array(
                'callback' => '103'
            )));
        }
        catch(InvalidPasswordException $invalidPasswordException)
        {
            Actions::redirect(DynamicalWeb::getRoute('register', array(
                'callback' => '104'
            )));
        }
        catch(UsernameAlreadyExistsException $usernameAlreadyExistsException)
        {
            Actions::redirect(DynamicalWeb::getRoute('register', array(
                'callback' => '105'
            )));
        }
        catch(EmailAlreadyExistsException $emailAlreadyExistsException)
        {
            Actions::redirect(DynamicalWeb::getRoute('register', array(
                'callback' => '106'
            )));
        }
        catch(Exception $exception)
        {
            Actions::redirect(DynamicalWeb::getRoute('register', array(
                'callback' => '101'
            )));
        }
    }

    /**
     * Gets the checkbox's input
     *
     * @param string $name
     * @return bool
     */
    function get_checkbox_input(string $name): bool
    {
        if(isset($_POST[$name]) == false)
        {
            return false;
        }

        switch(strtolower($_POST[$name]))
        {
            case "true":
                return true;

            case "false":
            default:
                return false;
        }
    }


    /**
     * Registers a new Intellivoid Account
     *
     * @return bool
     * @throws AccountNotFoundException
     * @throws DatabaseException
     * @throws EmailAlreadyExistsException
     * @throws InvalidEmailException
     * @throws InvalidPasswordException
     * @throws InvalidSearchMethodException
     * @throws InvalidUsernameException
     * @throws UsernameAlreadyExistsException
     */
    function register_account(): bool
    {
        if(isset($_POST['email']) == false)
        {
            Actions::redirect(DynamicalWeb::getRoute('register', array(
                'callback' => '100'
            )));
        }

        if(isset($_POST['password']) == false)
        {
            Actions::redirect(DynamicalWeb::getRoute('register', array(
                'callback' => '100'
            )));
        }

        if(isset($_POST['password']) == false)
        {
            Actions::redirect(DynamicalWeb::getRoute('register', array(
                'callback' => '100'
            )));
        }

        if(get_checkbox_input("tos_agree") == false)
        {
            Actions::redirect(DynamicalWeb::getRoute('register', array(
                'callback' => '107'
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

        $IntellivoidAccounts->getAccountManager()->registerAccount(
            $_POST['username'], $_POST['email'], $_POST['password']
        );

        return True;
    }