<?php

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\Runtime;
    use IntellivoidAccounts\Exceptions\AccountNotFoundException;
    use IntellivoidAccounts\Exceptions\AccountSuspendedException;
    use IntellivoidAccounts\Exceptions\ConfigurationNotFoundException;
    use IntellivoidAccounts\Exceptions\DatabaseException;
    use IntellivoidAccounts\Exceptions\HostBlockedFromAccountException;
    use IntellivoidAccounts\Exceptions\HostNotKnownException;
    use IntellivoidAccounts\Exceptions\IncorrectLoginDetailsException;
    use IntellivoidAccounts\Exceptions\InvalidIpException;
    use IntellivoidAccounts\Exceptions\InvalidSearchMethodException;
    use IntellivoidAccounts\IntellivoidAccounts;

    Runtime::import('IntellivoidAccounts');

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        try
        {
            check_login();

            header('Location: /login?mode=success');
            exit();
        }
        catch(AccountNotFoundException $accountNotFoundException)
        {
            header('Location: /login?callback=102');
            exit();
        }
        catch(IncorrectLoginDetailsException $incorrectLoginDetailsException)
        {
            header('Location: /login?callback=103');
            exit();
        }
        catch(AccountSuspendedException $accountSuspendedException)
        {
            header('Location: /login?callback=104');
            exit();
        }
        catch(HostBlockedFromAccountException $hostBlockedFromAccountException)
        {
            header('Location: /login?callback=105');
            exit();
        }
        catch(Exception $exception)
        {
            header('Location: /login?callback=101');
            exit();
        }
    }

    /**
     * Detects the IP Address of the client
     *
     * @return string
     */
    function detectClientIp(): string
    {
        if(isset($_SERVER['HTTP_CLIENT_IP']))
        {
            return $_SERVER['HTTP_CLIENT_IP'];
        }

        if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }

        if(isset($_SERVER['HTTP_X_FORWARDED']))
        {
            return $_SERVER['HTTP_X_FORWARDED'];
        }

        if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        {
            return $_SERVER['HTTP_FORWARDED_FOR'];
        }

        if(isset($_SERVER['HTTP_FORWARDED']))
        {
            return $_SERVER['HTTP_FORWARDED'];
        }

        if(isset($_SERVER['REMOTE_ADDR']))
        {
            return $_SERVER['REMOTE_ADDR'];
        }

        if(getenv('HTTP_CLIENT_IP') !== False)
        {
            return getenv('HTTP_CLIENT_IP');
        }

        if(getenv('HTTP_X_FORWARDED_FOR'))
        {
            return getenv('HTTP_X_FORWARDED_FOR');
        }

        if(getenv('HTTP_X_FORWARDED'))
        {
            return getenv('HTTP_X_FORWARDED');
        }

        if(getenv('HTTP_FORWARDED_FOR'))
        {
            return getenv('HTTP_FORWARDED_FOR');
        }

        if(getenv('HTTP_FORWARDED'))
        {
            return getenv('HTTP_FORWARDED');
        }

        if(getenv('REMOTE_ADDR'))
        {
            return getenv('REMOTE_ADDR');
        }

        return '0.0.0.0';
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
     * Check's if the given login information is correct or not
     *
     * @return bool
     * @throws AccountNotFoundException
     * @throws AccountSuspendedException
     * @throws ConfigurationNotFoundException
     * @throws DatabaseException
     * @throws HostBlockedFromAccountException
     * @throws HostNotKnownException
     * @throws IncorrectLoginDetailsException
     * @throws InvalidIpException
     * @throws InvalidSearchMethodException
     */
    function check_login(): bool
    {
        if(isset($_POST['username_email']) == false)
        {
            header('Location: /login?callback=100');
            exit();
        }

        if(isset($_POST['password']) == false)
        {
            header('Location: /login?callback=100');
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

        $IntellivoidAccounts->getLoginProcessor()->verifyCredentials(
            detectClientIp(), $_POST['username_email'], $_POST['password']
        );

        return True;
    }