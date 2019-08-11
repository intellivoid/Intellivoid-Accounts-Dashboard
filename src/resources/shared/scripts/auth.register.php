<?php

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\Runtime;
    use IntellivoidAccounts\Exceptions\AccountNotFoundException;
    use IntellivoidAccounts\Exceptions\AccountSuspendedException;
    use IntellivoidAccounts\Exceptions\ConfigurationNotFoundException;
    use IntellivoidAccounts\Exceptions\DatabaseException;
use IntellivoidAccounts\Exceptions\EmailAlreadyExistsException;
use IntellivoidAccounts\Exceptions\HostBlockedFromAccountException;
    use IntellivoidAccounts\Exceptions\HostNotKnownException;
    use IntellivoidAccounts\Exceptions\IncorrectLoginDetailsException;
use IntellivoidAccounts\Exceptions\InvalidEmailException;
use IntellivoidAccounts\Exceptions\InvalidIpException;
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

            header('Location: /register?mode=success');
            exit();
        }
        catch(InvalidUsernameException $invalidUsernameException)
        {
            header('Location: /register?callback=102');
            exit();
        }
        catch(InvalidEmailException $invalidEmailException)
        {
            header('Location: /register?callback=103');
            exit();
        }
        catch(InvalidPasswordException $invalidPasswordException)
        {
            header('Location: /register?callback=104');
            exit();
        }
        catch(UsernameAlreadyExistsException $usernameAlreadyExistsException)
        {
            header('Location: /register?callback=105');
            exit();
        }
        catch(EmailAlreadyExistsException $emailAlreadyExistsException)
        {
            header('Location: /register?callback=106');
            exit();
        }
        catch(Exception $exception)
        {
            header('Location: /register?callback=101');
            exit();
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
            case "false":
                return false;

            case "true":
                return true;

            default:
                return false;
        }
    }


    /**
     * Registers a new Intellivoid Account
     *
     * @return bool
     * @throws AccountNotFoundException
     * @throws ConfigurationNotFoundException
     * @throws DatabaseException
     * @throws InvalidSearchMethodException
     * @throws EmailAlreadyExistsException
     * @throws InvalidEmailException
     * @throws InvalidPasswordException
     * @throws InvalidUsernameException
     * @throws UsernameAlreadyExistsException
     */
    function register_account(): bool
    {
        if(isset($_POST['email']) == false)
        {
            header('Location: /register?callback=100');
            exit();
        }

        if(isset($_POST['password']) == false)
        {
            header('Location: /register?callback=100');
            exit();
        }

        if(isset($_POST['password']) == false)
        {
            header('Location: /register?callback=100');
            exit();
        }

        if(get_checkbox_input("tos_agree") == false)
        {
            header('Location: /register?callback=107');
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
            $IntellivoidAccounts = DynamicalWeb::getMemoryObject(
                "intellivoid_accounts", DynamicalWeb::getMemoryObject("intellivoid_accounts")
            );
        }

        $IntellivoidAccounts->getAccountManager()->registerAccount(
            $_POST['username'], $_POST['email'], $_POST['password']
        );

        return True;
    }