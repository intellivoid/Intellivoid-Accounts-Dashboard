<?php

    use DynamicalWeb\Actions;
    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use IntellivoidAccounts\Abstracts\AccountRequestPermissions;
    use IntellivoidAccounts\Abstracts\ApplicationAccessStatus;
    use IntellivoidAccounts\Abstracts\AuthenticationMode;
    use IntellivoidAccounts\Abstracts\LoginStatus;
    use IntellivoidAccounts\Abstracts\SearchMethods\KnownHostsSearchMethod;
    use IntellivoidAccounts\Exceptions\AccountNotFoundException;
    use IntellivoidAccounts\Exceptions\AuthenticationAccessNotFoundException;
    use IntellivoidAccounts\Exceptions\AuthenticationRequestAlreadyUsedException;
    use IntellivoidAccounts\Exceptions\DatabaseException;
    use IntellivoidAccounts\Exceptions\HostNotKnownException;
    use IntellivoidAccounts\Exceptions\InvalidIpException;
    use IntellivoidAccounts\Exceptions\InvalidLoginStatusException;
    use IntellivoidAccounts\Exceptions\InvalidSearchMethodException;
    use IntellivoidAccounts\IntellivoidAccounts;
    use IntellivoidAccounts\Objects\COA\Application;
    use IntellivoidAccounts\Objects\COA\AuthenticationRequest;
    use sws\Objects\Cookie;

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

    /** @var Application $Application */
    $Application = DynamicalWeb::getMemoryObject('application');
    HTML::importScript("direct_auth");

    // If this application supports direct auth, authenticate the user.
    if(directAuthVerify($Application->NameSafe))
    {
        $ReqParameters = DynamicalWeb::getArray("request_parameters");

        $_GET["auth"] = $ReqParameters["auth"];
        $_GET["action"] = $ReqParameters["action"];
        $_GET["application_id"] = $ReqParameters["application_id"];
        $_GET["request_token"] = $ReqParameters["request_token"];
        $_GET["exp"] = $ReqParameters["exp"];
        $_GET["verification_token"] = $ReqParameters["verification_token"];
        $_GET["direct_auth"] = "1";

        process_auth();
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

    /**
     * Processes the authentication procedure
     *
     * @throws AccountNotFoundException
     * @throws DatabaseException
     * @throws HostNotKnownException
     * @throws InvalidIpException
     * @throws InvalidLoginStatusException
     * @throws InvalidSearchMethodException
     */
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

        $SkipPermissionCheck = false;

        if(function_exists("directAuthVerify") == false)
        {
            HTML::importScript("direct_auth");
        }

        // Check if it's really a direct auth and if so
        // Then omit the permission check
        if(directAuthVerify($Application->NameSafe))
        {
            if(isset($_GET["direct_auth"]))
            {
                if($_GET["direct_auth"] == "1")
                {
                    $SkipPermissionCheck = true;
                }
            }
        }


        if($SkipPermissionCheck == false)
        {
            if($AuthenticationRequest->has_requested_permission(AccountRequestPermissions::ViewEmailAddress))
            {
                if(check_permission('view_email') == false)
                {
                    $Index = array_search(AccountRequestPermissions::ViewEmailAddress, $AuthenticationRequest->RequestedPermissions);
                    unset($AuthenticationRequest->RequestedPermissions[$Index]);
                }
            }

            if($AuthenticationRequest->has_requested_permission(AccountRequestPermissions::ReadPersonalInformation))
            {
                if(check_permission('view_personal_information') == false)
                {
                    $Index = array_search(AccountRequestPermissions::ReadPersonalInformation, $AuthenticationRequest->RequestedPermissions);
                    unset($AuthenticationRequest->RequestedPermissions[$Index]);
                }
            }

            if($AuthenticationRequest->has_requested_permission(AccountRequestPermissions::EditPersonalInformation))
            {
                if(check_permission('edit_personal_information') == false)
                {
                    $Index = array_search(AccountRequestPermissions::EditPersonalInformation, $AuthenticationRequest->RequestedPermissions);
                    unset($AuthenticationRequest->RequestedPermissions[$Index]);
                }
            }

            if($AuthenticationRequest->has_requested_permission(AccountRequestPermissions::TelegramNotifications))
            {
                if(check_permission('telegram_notifications') == false)
                {
                    $Index = array_search(AccountRequestPermissions::TelegramNotifications, $AuthenticationRequest->RequestedPermissions);
                    unset($AuthenticationRequest->RequestedPermissions[$Index]);
                }
            }

            if($AuthenticationRequest->has_requested_permission(AccountRequestPermissions::GetTelegramClient))
            {
                if(check_permission('get_telegram_client') == false)
                {
                    $Index = array_search(AccountRequestPermissions::GetTelegramClient, $AuthenticationRequest->RequestedPermissions);
                    unset($AuthenticationRequest->RequestedPermissions[$Index]);
                }
            }

            if($AuthenticationRequest->has_requested_permission(AccountRequestPermissions::ManageTodo))
            {
                if(check_permission('manage_todo') == false)
                {
                    $Index = array_search(AccountRequestPermissions::ManageTodo, $AuthenticationRequest->RequestedPermissions);
                    unset($AuthenticationRequest->RequestedPermissions[$Index]);

                    $Index = array_search(AccountRequestPermissions::AccessTodo, $AuthenticationRequest->RequestedPermissions);
                    unset($AuthenticationRequest->RequestedPermissions[$Index]);
                }
            }
            elseif($AuthenticationRequest->has_requested_permission(AccountRequestPermissions::AccessTodo))
            {
                if(check_permission('view_todo') == false)
                {
                    $Index = array_search(AccountRequestPermissions::AccessTodo, $AuthenticationRequest->RequestedPermissions);
                    unset($AuthenticationRequest->RequestedPermissions[$Index]);
                }
            }
        }

        // Correct the requested permissions
        $CorrectedArray = [];
        foreach($AuthenticationRequest->RequestedPermissions as $permission)
        {
            $CorrectedArray[] = $permission;
        }
        $AuthenticationRequest->RequestedPermissions = $CorrectedArray;

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

        try
        {
            $ApplicationAccess = $IntellivoidAccounts->getCrossOverAuthenticationManager()->getApplicationAccessManager()->syncApplicationAccess($Application->ID, WEB_ACCOUNT_ID);
        }
        catch(Exception $exception)
        {
            Actions::redirect(DynamicalWeb::getRoute('application_error', array('error_code' => '-1')));
        }

        /** @noinspection PhpUndefinedVariableInspection */
        $ApplicationAccess->LastAuthenticatedTimestamp = (int)time();
        $ApplicationAccess->Status = ApplicationAccessStatus::Authorized;
        $ApplicationAccess->Permissions = $AuthenticationRequest->RequestedPermissions;

        try
        {
            $IntellivoidAccounts->getCrossOverAuthenticationManager()->getApplicationAccessManager()->updateApplicationAccess($ApplicationAccess);
        }
        catch(Exception $exception)
        {
            Actions::redirect(DynamicalWeb::getRoute('application_error', array('error_code' => '-1')));
        }

        /** @var Cookie $Cookie */
        $Cookie = DynamicalWeb::getMemoryObject('(cookie)web_session');

        $Host = $IntellivoidAccounts->getKnownHostsManager()->getHost(KnownHostsSearchMethod::byId, $Cookie->Data['host_id']);

        $IntellivoidAccounts->getLoginRecordManager()->createLoginRecord(
            WEB_ACCOUNT_ID, $Host->ID,
            LoginStatus::Successful, $Application->Name,
            CLIENT_USER_AGENT
        );

        switch($Application->AuthenticationMode)
        {
            case AuthenticationMode::Redirect:
                HTML::importScript('redirect_url_function');
                /** @noinspection PhpUndefinedVariableInspection */
                Actions::redirect(create_redirect_location($_GET['redirect'], array(
                    'access_token' => $Access->AccessToken
                )));
                break;

            case AuthenticationMode::Code:
                $GetParameters = $_GET;
                $GetParameters["auth"] = "application";
                $GetParameters["access_token"] = $Access->AccessToken;
                $GetParameters["verification_token"] = hash('sha256', $AuthenticationRequest->CreatedTimestamp . $AuthenticationRequest->RequestToken . $Application->PublicAppId);

                Actions::redirect(DynamicalWeb::getRoute('authentication_code', $GetParameters));

                break;

            case AuthenticationMode::ApplicationPlaceholder:
                $GetParameters = $_GET;
                $GetParameters["auth"] = "application";
                $GetParameters["access_token"] = $Access->AccessToken;
                $GetParameters["verification_token"] = hash('sha256', $AuthenticationRequest->CreatedTimestamp . $AuthenticationRequest->RequestToken . $Application->PublicAppId);

                Actions::redirect(DynamicalWeb::getRoute('authentication_success', $GetParameters));

                break;

            default:
                Actions::redirect(DynamicalWeb::getRoute('application_error', array(
                    'error_code' => '35'
                )));
                break;
        }

    }