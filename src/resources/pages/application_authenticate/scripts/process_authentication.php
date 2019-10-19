<?php

    use DynamicalWeb\Actions;
    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use IntellivoidAccounts\Abstracts\AccountRequestPermissions;
    use IntellivoidAccounts\Exceptions\AuthenticationAccessNotFoundException;
    use IntellivoidAccounts\Exceptions\AuthenticationRequestAlreadyUsedException;
    use IntellivoidAccounts\IntellivoidAccounts;
    use IntellivoidAccounts\Objects\COA\Application;
    use IntellivoidAccounts\Objects\COA\AuthenticationRequest;

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        if(isset($_GET['action']))
        {
            if($_GET['action'] == 'authenticate')
            {
                process_auth();
            }
        }
    }

    function check_permission(string $permission): bool
    {
        if(isset($_POST[$permission]))
        {
            if($_POST[$permission] == 'on')
            {
                return true;
            }
        }

        return false;
    }

    function process_auth()
    {
        /** @var Application $Application */
        $Application = DynamicalWeb::getMemoryObject('application');

        /** @var AuthenticationRequest $AuthenticationRequest */
        $AuthenticationRequest = DynamicalWeb::getMemoryObject('auth_request');

        $VerificationToken = hash('sha256', $AuthenticationRequest->CreatedTimestamp . $AuthenticationRequest->RequestToken . $Application->PublicAppId);
        if(isset($_GET['verification_token']))
        {
            if($_GET['verification_token'] !== $VerificationToken)
            {
                Actions::redirect(DynamicalWeb::getRoute('application_error', array('error_code' => '18')));
            }
        }
        else
        {
            Actions::redirect(DynamicalWeb::getRoute('application_error', array('error_code' => '17')));
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

        if(in_array(AccountRequestPermissions::ReadPersonalInformation, $AuthenticationRequest->RequestedPermissions))
        {
            if(check_permission('view_personal_information') == false)
            {
                unset($AuthenticationRequest->RequestedPermissions[AccountRequestPermissions::ReadPersonalInformation]);
            }
        }

        if(in_array(AccountRequestPermissions::EditPersonalInformation, $AuthenticationRequest->RequestedPermissions))
        {
            if(check_permission('edit_personal_information') == false)
            {
                unset($AuthenticationRequest->RequestedPermissions[AccountRequestPermissions::EditPersonalInformation]);
            }
        }

        if(in_array(AccountRequestPermissions::TelegramNotifications, $AuthenticationRequest->RequestedPermissions))
        {
            if(check_permission('telegram_notifications') == false)
            {
                unset($AuthenticationRequest->RequestedPermissions[AccountRequestPermissions::TelegramNotifications]);
            }
        }

        if(in_array(AccountRequestPermissions::MakePurchases, $AuthenticationRequest->RequestedPermissions))
        {
            if(check_permission('make_purchases') == false)
            {
                unset($AuthenticationRequest->RequestedPermissions[AccountRequestPermissions::MakePurchases]);
            }
        }

        $AuthenticationRequest->AccountId = WEB_ACCOUNT_ID;

        try
        {
            $Access = $IntellivoidAccounts->getCrossOverAuthenticationManager()->getAuthenticationAccessManager()->createAuthenticationAccess($AuthenticationRequest);
        }
        catch(AuthenticationAccessNotFoundException $e)
        {
            Actions::redirect(DynamicalWeb::getRoute('application_error', array('error_code' => '19')));
        }
        catch (AuthenticationRequestAlreadyUsedException $e)
        {
            Actions::redirect(DynamicalWeb::getRoute('application_error', array('error_code' => '20')));
        }
        catch (Exception $e)
        {
            Actions::redirect(DynamicalWeb::getRoute('application_error', array('error_code' => '21')));
        }

        HTML::importScript('redirect_url_function');
        Actions::redirect(create_redirect_location($_GET['redirect'], array('access_token' => $Access->AccessToken)));
    }