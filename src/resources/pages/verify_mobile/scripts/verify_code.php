<?php

    use DynamicalWeb\DynamicalWeb;
use IntellivoidAccounts\Abstracts\LoginStatus;
use IntellivoidAccounts\Abstracts\SearchMethods\KnownHostsSearchMethod;
use IntellivoidAccounts\Exceptions\DatabaseException;
use IntellivoidAccounts\Exceptions\HostNotKnownException;
use IntellivoidAccounts\Exceptions\InvalidIpException;
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


    function execute_verification()
    {
        if(isset($_POST['code']) == false)
        {
            header('Location: /verify_mobile?callback=100');
            exit();
        }

        /** @var Account $Account */
        $Account = DynamicalWeb::getMemoryObject('account');

        $Host = get_host();

        /** @var IntellivoidAccounts $IntellivoidAccounts */
        $IntellivoidAccounts = DynamicalWeb::getMemoryObject("intellivoid_accounts");

        if($Account->Configuration->VerificationMethods->TwoFactorAuthentication->verifyCode($_POST['code']) == false)
        {
            $IntellivoidAccounts->getLoginRecordManager()->createLoginRecord(
                $Account->ID, $Host->ID,
                LoginStatus::VerificationFailed, 'Intellivoid Accounts',
                CLIENT_USER_AGENT
            );

            // TODO: Add auto-lockout
            header('Location: /verify_mobile?callback=101&incorrect_auth=1');
            exit();
        }

        /** @var sws $sws */
        $sws = DynamicalWeb::getMemoryObject('sws');
        $Cookie = $sws->WebManager()->getCookie('intellivoid_secured_web_session');

        $Cookie->Data["verification_required"] = false;
        $Cookie->Data["auto_logout"] = 0;
        $Cookie->Data["verification_attempts"] = 0;

        $sws->CookieManager()->updateCookie($Cookie);

        $IntellivoidAccounts->getLoginRecordManager()->createLoginRecord(
            $Account->ID, $Host->ID,
            LoginStatus::Successful, 'Intellivoid Accounts',
            CLIENT_USER_AGENT
        );

        header('Location: /');
        exit();
    }