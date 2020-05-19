<?php


    use DynamicalWeb\Actions;
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

            if(isset($_GET['callback']))
            {
                unset($_GET['callback']);
            }

            if(isset($_POST['redirect']))
            {
                switch($_POST['redirect'])
                {
                    case 'settings_login_security':
                        Actions::redirect(DynamicalWeb::getRoute('settings_login_security', $_GET));
                        break;

                    case 'setup_mobile_verification':
                        Actions::redirect(DynamicalWeb::getRoute('setup_mobile_verification', $_GET));
                        break;

                    case 'setup_recovery_codes':
                        Actions::redirect(DynamicalWeb::getRoute('setup_recovery_codes', $_GET));
                        break;

                    default:
                        Actions::redirect(DynamicalWeb::getRoute('index', $_GET));
                        break;
                }
            }
            else
            {
                Actions::redirect(DynamicalWeb::getRoute('index'));
            }
        }
        catch(IncorrectLoginDetailsException $incorrectLoginDetailsException )
        {
            if(isset($_POST['redirect']))
            {
                Actions::redirect(DynamicalWeb::getRoute('sudo',
                    array('callback' => '101', 'redirect' => urlencode($_POST['redirect']))
                ));
            }
            else
            {
                Actions::redirect(DynamicalWeb::getRoute('sudo',
                    array('callback' => '101')
                ));
            }
        }
        catch(Exception $exception)
        {
            if(isset($_POST['redirect']))
            {
                Actions::redirect(DynamicalWeb::getRoute('sudo',
                    array('callback' => '100', 'redirect' => urlencode($_POST['redirect']))
                ));
            }
            else
            {
                Actions::redirect(DynamicalWeb::getRoute('sudo',
                    array('callback' => '100')
                ));
            }
        }
    }
