<?php


    use DynamicalWeb\DynamicalWeb;
use IntellivoidAccounts\Exceptions\IncorrectLoginDetailsException;
use IntellivoidAccounts\IntellivoidAccounts;
    use sws\sws;

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        if(isset($_POST['password']))
        {
            enter_sudo();
        }
    }

    function enter_sudo()
    {
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
            $IntellivoidAccounts->getAccountManager()->checkLogin(WEB_ACCOUNT_USERNAME, $_POST['password']);

            /** @var sws $sws */
            $sws = DynamicalWeb::getMemoryObject('sws');

            $Cookie = $sws->WebManager()->getCookie('intellivoid_secured_web_session');
            $Cookie->Data["sudo_mode"] = true;
            $Cookie->Data["sudo_expires"] = time() + 900;
            $sws->CookieManager()->updateCookie($Cookie);

            if(isset($_POST['redirect']))
            {
                switch($_POST['redirect'])
                {
                    case 'login_security':
                        header('Location: /login_security');
                        exit();

                    case 'setup_mobile_verification':
                        header('Location: /setup_mobile_verification');
                        exit();

                    case 'setup_recovery_codes':
                        header('Location: /setup_recovery_codes');
                        exit();

                    default:
                        header('Location: /');
                        exit();
                }
            }
            else
            {
                header('Location: /');
                exit();
            }
        }
        catch(IncorrectLoginDetailsException $incorrectLoginDetailsException )
        {
            if(isset($_POST['redirect']))
            {
                header('Location: /sudo?callback=101&redirect=' . urlencode($_POST['redirect']));
            }
            else
            {
                header('Location: /sudo?callback=101');
            }
            exit();
        }
        catch(Exception $exception)
        {
            if(isset($_POST['redirect']))
            {
                header('Location: /sudo?callback=100&redirect=' . urlencode($_POST['redirect']));
            }
            else
            {
                header('Location: /sudo?callback=100');
            }
            exit();
        }
    }
