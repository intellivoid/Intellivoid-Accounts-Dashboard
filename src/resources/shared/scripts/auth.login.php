<?php

    use DynamicalWeb\Actions;
    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use DynamicalWeb\Runtime;
    use IntellivoidAccounts\Abstracts\AccountStatus;
    use IntellivoidAccounts\Abstracts\LoginStatus;
    use IntellivoidAccounts\Abstracts\SearchMethods\AccountSearchMethod;
    use IntellivoidAccounts\Abstracts\SearchMethods\KnownHostsSearchMethod;
    use IntellivoidAccounts\Exceptions\AccountNotFoundException;
    use IntellivoidAccounts\Exceptions\AccountSuspendedException;
    use IntellivoidAccounts\Exceptions\DatabaseException;
    use IntellivoidAccounts\Exceptions\HostNotKnownException;
    use IntellivoidAccounts\Exceptions\IncorrectLoginDetailsException;
    use IntellivoidAccounts\Exceptions\InvalidIpException;
    use IntellivoidAccounts\Exceptions\InvalidSearchMethodException;
    use IntellivoidAccounts\IntellivoidAccounts;
    use IntellivoidAccounts\Objects\Account;
    use IntellivoidAccounts\Objects\KnownHost;
    use IntellivoidAccounts\Utilities\Validate;
    use sws\Objects\Cookie;
    use sws\sws;

    Runtime::import('IntellivoidAccounts');

    $GetParameters = $_GET;
    unset($GetParameters['callback']);

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        try
        {
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

            /** @var sws $sws */
            $sws = DynamicalWeb::getMemoryObject('sws');
            $Cookie = $sws->WebManager()->getCookie('intellivoid_secured_web_session');
            DynamicalWeb::setMemoryObject('(cookie)web_session', $Cookie);

            $Host = get_host();
        }
        catch(Exception $exception)
        {
            $GetParameters['callback'] = '106';
            $GetParameters['type'] = 'internal';
            Actions::redirect(DynamicalWeb::getRoute('login', $GetParameters));
        }

        if(isset($_POST['password']) == false)
        {
            $GetParameters['callback'] = '100';
            Actions::redirect(DynamicalWeb::getRoute('login', $GetParameters));
        }

        try
        {
            $Account = get_account();

            if($Account == null)
            {
                $GetParameters['callback'] = '103';
                Actions::redirect(DynamicalWeb::getRoute('login', $GetParameters));
            }

            if($Host->Blocked == true)
            {
                try
                {
                    $IntellivoidAccounts->getLoginRecordManager()->createLoginRecord(
                        $Account->ID, $Host->ID,
                        LoginStatus::UntrustedIpBlocked, 'Intellivoid Accounts',
                        CLIENT_USER_AGENT
                    );

                    $GetParameters['callback'] = '105';
                    Actions::redirect(DynamicalWeb::getRoute('login', $GetParameters));
                }
                catch(Exception $exception)
                {
                    $GetParameters['callback'] = '106';
                    $GetParameters['type'] = 'blocked';
                    Actions::redirect(DynamicalWeb::getRoute('login', $GetParameters));
                }
            }

            if(Validate::verifyHashedPassword($_POST['password'], $Account->Password) == false)
            {
                try
                {
                    $IntellivoidAccounts->getLoginRecordManager()->createLoginRecord(
                        $Account->ID, $Host->ID,
                        LoginStatus::IncorrectCredentials, 'Intellivoid Accounts',
                        CLIENT_USER_AGENT
                    );
                }
                catch(Exception $exception)
                {
                    $GetParameters['callback'] = '101';
                    $GetParameters['type'] = 'verify_ps';
                    Actions::redirect(DynamicalWeb::getRoute('login', $GetParameters));
                }

                $GetParameters['callback'] = '103';
                Actions::redirect(DynamicalWeb::getRoute('login', $GetParameters));
            }

            if($Account->Status == AccountStatus::Suspended)
            {
                $GetParameters['callback'] = '104';
                Actions::redirect(DynamicalWeb::getRoute('login', $GetParameters));
            }

            $Cookie->Data["session_active"] = true;
            $Cookie->Data["account_pubid"] = $Account->PublicID;
            $Cookie->Data["account_id"] = $Account->ID;
            $Cookie->Data["account_email"] = $Account->Email;
            $Cookie->Data["account_username"] = $Account->Username;
            $Cookie->Data["sudo_mode"] = false;
            $Cookie->Data["sudo_expires"] = 0;

            if($Account->Configuration->VerificationMethods->TwoFactorAuthenticationEnabled == true)
            {
                $Cookie->Data["verification_required"] = true;
                $Cookie->Data["auto_logout"] = time() + 600;
                $Cookie->Data["verification_attempts"] = 0;
            }
            elseif($Account->Configuration->VerificationMethods->RecoveryCodesEnabled == true)
            {
                $Cookie->Data["verification_required"] = true;
                $Cookie->Data["auto_logout"] = time() + 600;
                $Cookie->Data["verification_attempts"] = 0;
            }
            elseif($Account->Configuration->VerificationMethods->TelegramClientLinked == true)
            {
                $Cookie->Data["verification_required"] = true;
                $Cookie->Data["auto_logout"] = time() + 600;
                $Cookie->Data["verification_attempts"] = 0;
            }
            else
            {
                try
                {
                    $IntellivoidAccounts->getLoginRecordManager()->createLoginRecord(
                        $Account->ID, $Host->ID,
                        LoginStatus::Successful, 'Intellivoid Accounts',
                        CLIENT_USER_AGENT
                    );
                }
                catch(Exception $exception)
                {
                    $GetParameters['callback'] = '105';
                    $GetParameters['type'] = 'no_verification';
                    Actions::redirect(DynamicalWeb::getRoute('login', $GetParameters));
                }

                if($Account->Configuration->KnownHosts->addHostId($Host->ID) == true)
                {
                    $IntellivoidAccounts->getAccountManager()->updateAccount($Account);
                }

                $Cookie->Data["verification_required"] = false;
                $Cookie->Data["auto_logout"] = 0;
            }

            $sws->CookieManager()->updateCookie($Cookie);
            HTML::importScript('sync_avatar');

            Actions::redirect(DynamicalWeb::getRoute('index', $GetParameters));
        }
        catch(AccountNotFoundException $accountNotFoundException)
        {
            $GetParameters['callback'] = '102';
            Actions::redirect(DynamicalWeb::getRoute('login', $GetParameters));
        }
        catch(Exception $exception)
        {
            $GetParameters['callback'] = '101';
            Actions::redirect(DynamicalWeb::getRoute('login', $GetParameters));
        }

    }

    /**
     * Makes the IP Safe to use for the system
     *
     * @param string $input
     * @return string
     */
    function safe_ip(string $input): string
    {
        if($input == "::1")
        {
            return "127.0.0.1";
        }

        return $input;
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
     * Check's if the given login information is correct or not
     *
     * @deprecated
     * @return Account
     * @throws AccountNotFoundException
     * @throws AccountSuspendedException
     * @throws DatabaseException
     * @throws IncorrectLoginDetailsException
     * @throws InvalidSearchMethodException
     */
    function check_login(): Account
    {

        $GetParameters = $_GET;
        unset($GetParameters['callback']);

        if(isset($_POST['username_email']) == false)
        {
            $GetParameters['callback'] = '100';
            Actions::redirect(DynamicalWeb::getRoute('login', $GetParameters));
        }

        if(isset($_POST['password']) == false)
        {
            $GetParameters['callback'] = '100';
            Actions::redirect(DynamicalWeb::getRoute('login', $GetParameters));
        }

        /** @var IntellivoidAccounts $IntellivoidAccounts */
        $IntellivoidAccounts = DynamicalWeb::getMemoryObject("intellivoid_accounts");
        return $IntellivoidAccounts->getAccountManager()->getAccountByAuth($_POST['username_email'], $_POST['password']);
    }

    /**
     * Returns an account if the entered username/email exists
     *
     * @return Account|null
     * @throws AccountNotFoundException
     * @throws DatabaseException
     * @throws InvalidSearchMethodException
     */
    function get_account()
    {
        $GetParameters = $_GET;
        unset($GetParameters['callback']);

        if(isset($_POST['username_email']) == false)
        {
            $GetParameters['callback'] = '100';
            Actions::redirect(DynamicalWeb::getRoute('login', $GetParameters));
        }

        /** @var IntellivoidAccounts $IntellivoidAccounts */
        $IntellivoidAccounts = DynamicalWeb::getMemoryObject("intellivoid_accounts");

        if(Validate::email($_POST['username_email']))
        {
            if($IntellivoidAccounts->getAccountManager()->emailExists($_POST['username_email']))
            {
                return $IntellivoidAccounts->getAccountManager()->getAccount(AccountSearchMethod::byEmail, $_POST['username_email']);
            }
        }

        if($IntellivoidAccounts->getAccountManager()->usernameExists($_POST['username_email']))
        {
            return $IntellivoidAccounts->getAccountManager()->getAccount(AccountSearchMethod::byUsername, $_POST['username_email']);
        }

        return null;
    }

    /**
     * Get's the known host associated with this client
     *
     * @return KnownHost
     * @throws DatabaseException
     * @throws HostNotKnownException
     * @throws InvalidIpException
     */
    function get_host(): KnownHost
    {
        /** @var IntellivoidAccounts $IntellivoidAccounts */
        $IntellivoidAccounts = DynamicalWeb::getMemoryObject("intellivoid_accounts");

        /** @var Cookie $Cookie */
        $Cookie = DynamicalWeb::getMemoryObject('(cookie)web_session');

        return $IntellivoidAccounts->getKnownHostsManager()->getHost(KnownHostsSearchMethod::byId, $Cookie->Data['host_id']);
    }