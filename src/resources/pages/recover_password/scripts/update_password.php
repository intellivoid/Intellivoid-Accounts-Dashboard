<?php

    use DynamicalWeb\Actions;
    use DynamicalWeb\DynamicalWeb;
use DynamicalWeb\Runtime;
use IntellivoidAccounts\Abstracts\AccountStatus;
use IntellivoidAccounts\Exceptions\AccountNotFoundException;
    use IntellivoidAccounts\Exceptions\DatabaseException;
    use IntellivoidAccounts\Exceptions\InvalidAccountStatusException;
    use IntellivoidAccounts\Exceptions\InvalidEmailException;
    use IntellivoidAccounts\Exceptions\InvalidSearchMethodException;
    use IntellivoidAccounts\Exceptions\InvalidUsernameException;
    use IntellivoidAccounts\IntellivoidAccounts;
    use IntellivoidAccounts\Objects\Account;
    use IntellivoidAccounts\Utilities\Hashing;
    use IntellivoidAccounts\Utilities\Validate;
use pwc\pwc;
use sws\sws;

    Runtime::import('PwCompromission');

    if(isset($_GET['action']))
    {
        if($_GET['action'] == 'submit')
        {
            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                try
                {
                    update_password();
                }
                catch(Exception $e)
                {
                    $_GET['callback'] = '102';
                    Actions::redirect(DynamicalWeb::getRoute('recover_password', $_GET));
                }
            }
        }
    }


    /**
     * Updates the password of the account
     *
     * @throws AccountNotFoundException
     * @throws DatabaseException
     * @throws InvalidAccountStatusException
     * @throws InvalidEmailException
     * @throws InvalidSearchMethodException
     * @throws InvalidUsernameException
     */
    function update_password()
    {
        if(isset($_POST['new_password']) == false)
        {
            Actions::redirect(DynamicalWeb::getRoute('recover_password', array('callback' => '100')));
        }

        /** @var Account $Account */
        $Account = DynamicalWeb::getMemoryObject('account');

        /** @var IntellivoidAccounts $IntellivoidAccounts */
        $IntellivoidAccounts = DynamicalWeb::getMemoryObject("intellivoid_accounts");

        if(Validate::password($_POST['new_password']) == false)
        {
            $_GET['callback'] = '101';
            Actions::redirect(DynamicalWeb::getRoute('recover_password', $_GET));
        }

        $pwc = new pwc();

        try
        {
            $PasswordCache = $pwc->checkPassword($_POST['new_password']);

            if($PasswordCache->Compromised)
            {
                $_GET['callback'] = '103';
                Actions::redirect(DynamicalWeb::getRoute('recover_password', $_GET));
            }
        }
        catch(Exception $exception)
        {
            unset($exception);
        }

        $Account->Password = Hashing::password($_POST['new_password']);
        $Account->Status = AccountStatus::Active;
        $IntellivoidAccounts->getAccountManager()->updateAccount($Account);

        /** @var sws $sws */
        $sws = DynamicalWeb::getMemoryObject('sws');
        $Cookie = $sws->WebManager()->getCookie('intellivoid_secured_web_session');

        $Cookie->Data['session_active'] = false;
        $Cookie->Data['verification_required'] = false;
        $Cookie->Data['auto_logout'] = 0;
        $Cookie->Data['verification_attempts'] = 0;
        $sws->CookieManager()->updateCookie($Cookie);
        $sws->WebManager()->disposeCookie('intellivoid_secured_web_session');

        $_GET['callback'] = '110';
        Actions::redirect(DynamicalWeb::getRoute('login', $_GET));
        exit();
    }