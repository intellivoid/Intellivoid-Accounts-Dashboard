<?php

    use DynamicalWeb\Actions;
    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use IntellivoidAccounts\Abstracts\LoginStatus;
    use IntellivoidAccounts\Abstracts\SearchMethods\KnownHostsSearchMethod;
    use IntellivoidAccounts\Exceptions\AccountNotFoundException;
    use IntellivoidAccounts\Exceptions\DatabaseException;
    use IntellivoidAccounts\Exceptions\HostNotKnownException;
    use IntellivoidAccounts\Exceptions\InvalidIpException;
    use IntellivoidAccounts\Exceptions\InvalidLoginStatusException;
    use IntellivoidAccounts\Exceptions\InvalidSearchMethodException;
    use IntellivoidAccounts\IntellivoidAccounts;
    use IntellivoidAccounts\Objects\Account;
    use IntellivoidAccounts\Objects\KnownHost;
    use sws\Objects\Cookie;
    use sws\sws;

    if(isset($_GET['action']))
    {
        if($_GET['action'] == 'submit')
        {
            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                execute_verification();
            }
        }
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


    /**
     * Executes the verification method
     *
     * @throws DatabaseException
     * @throws HostNotKnownException
     * @throws InvalidIpException
     * @throws AccountNotFoundException
     * @throws InvalidLoginStatusException
     * @throws InvalidSearchMethodException
     */
    function execute_verification()
    {
        $GetParameters = $_GET;
        unset($GetParameters['callback']);
        unset($GetParameters['incorrect_auth']);
        unset($GetParameters['action']);

        if(isset($_POST['code']) == false)
        {
            $GetParameters['callback'] = '100';
            Actions::redirect(DynamicalWeb::getRoute('verify_mobile', $GetParameters));
        }

        /** @var Account $Account */
        $Account = DynamicalWeb::getMemoryObject('account');
        $Host = get_host();
        /** @var IntellivoidAccounts $IntellivoidAccounts */
        $IntellivoidAccounts = DynamicalWeb::getMemoryObject("intellivoid_accounts");
        /** @var sws $sws */
        $sws = DynamicalWeb::getMemoryObject('sws');
        $Cookie = $sws->WebManager()->getCookie('intellivoid_secured_web_session');

        if($Account->Configuration->VerificationMethods->TwoFactorAuthentication->verifyCode($_POST['code']) == false)
        {
            $IntellivoidAccounts->getLoginRecordManager()->createLoginRecord(
                $Account->ID, $Host->ID,
                LoginStatus::VerificationFailed, 'Intellivoid Accounts',
                CLIENT_USER_AGENT
            );

            $Cookie->Data["verification_attempts"] += 1;
            $sws->CookieManager()->updateCookie($Cookie);

            $GetParameters['callback'] = '101';
            $GetParameters['incorrect_auth'] = '1';
            Actions::redirect(DynamicalWeb::getRoute('verify_mobile',  $GetParameters));
        }

        $Cookie->Data["verification_required"] = false;
        $Cookie->Data["auto_logout"] = 0;
        $Cookie->Data["verification_attempts"] = 0;

        $sws->CookieManager()->updateCookie($Cookie);

        $IntellivoidAccounts->getLoginRecordManager()->createLoginRecord(
            $Account->ID, $Host->ID,
            LoginStatus::Successful, 'Intellivoid Accounts',
            CLIENT_USER_AGENT
        );

        HTML::importScript('sync_avatar');
        Actions::redirect(DynamicalWeb::getRoute('index', $GetParameters));
        exit();
    }