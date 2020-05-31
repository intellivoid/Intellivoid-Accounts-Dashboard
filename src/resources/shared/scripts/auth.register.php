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
use pwc\pwc;

    Runtime::import('IntellivoidAccounts');
    Runtime::import('PwCompromission');

    $GetParameters = $_GET;
    unset($GetParameters['callback']);

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        try
        {
            register_account();
            HTML::importScript('sync_avatar');
            $GetParameters['callback'] = '106';
            Actions::redirect(DynamicalWeb::getRoute('login', $GetParameters));
        }
        catch(InvalidUsernameException $invalidUsernameException)
        {
            $GetParameters['callback'] = '102';
            Actions::redirect(DynamicalWeb::getRoute('register', $GetParameters));
        }
        catch(InvalidEmailException $invalidEmailException)
        {
            $GetParameters['callback'] = '103';
            Actions::redirect(DynamicalWeb::getRoute('register', $GetParameters));
        }
        catch(InvalidPasswordException $invalidPasswordException)
        {
            $GetParameters['callback'] = '104';
            Actions::redirect(DynamicalWeb::getRoute('register', $GetParameters));
        }
        catch(UsernameAlreadyExistsException $usernameAlreadyExistsException)
        {
            $GetParameters['callback'] = '105';
            Actions::redirect(DynamicalWeb::getRoute('register', $GetParameters));
        }
        catch(EmailAlreadyExistsException $emailAlreadyExistsException)
        {
            $GetParameters['callback'] = '106';
            Actions::redirect(DynamicalWeb::getRoute('register', $GetParameters));
        }
        catch(Exception $exception)
        {
            $GetParameters['callback'] = '101';
            Actions::redirect(DynamicalWeb::getRoute('register', $GetParameters));
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
            $GetParameters['callback'] = '100';
            Actions::redirect(DynamicalWeb::getRoute('register', $GetParameters));
        }

        if(isset($_POST['password']) == false)
        {
            $GetParameters['callback'] = '100';
            Actions::redirect(DynamicalWeb::getRoute('register', $GetParameters));
        }

        if(isset($_POST['password']) == false)
        {
            $GetParameters['callback'] = '100';
            Actions::redirect(DynamicalWeb::getRoute('register', $GetParameters));
        }

        if(get_checkbox_input("tos_agree") == false)
        {
            $GetParameters['callback'] = '107';
            Actions::redirect(DynamicalWeb::getRoute('register', $GetParameters));
        }

        $pwc = new pwc();

        try
        {
            $PasswordCache = $pwc->checkPassword($_POST['password']);

            if($PasswordCache->Compromised)
            {
                $GetParameters['callback'] = '108';
                Actions::redirect(DynamicalWeb::getRoute('register', $GetParameters));
            }
        }
        catch(Exception $exception)
        {
            unset($exception);
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