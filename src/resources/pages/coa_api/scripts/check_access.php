<?php

    use DynamicalWeb\DynamicalWeb;
use IntellivoidAccounts\Abstracts\AccountStatus;
use IntellivoidAccounts\Abstracts\ApplicationStatus;
    use IntellivoidAccounts\Abstracts\SearchMethods\AccountSearchMethod;
    use IntellivoidAccounts\Abstracts\SearchMethods\ApplicationSearchMethod;
    use IntellivoidAccounts\Abstracts\SearchMethods\AuthenticationAccessSearchMethod;
    use IntellivoidAccounts\Abstracts\SearchMethods\AuthenticationRequestSearchMethod;
    use IntellivoidAccounts\Exceptions\AccountNotFoundException;
    use IntellivoidAccounts\Exceptions\ApplicationNotFoundException;
    use IntellivoidAccounts\Exceptions\AuthenticationAccessNotFoundException;
    use IntellivoidAccounts\IntellivoidAccounts;

    if(get_parameter('application_id') == null)
    {
        returnJsonResponse(array(
            'status' => false,
            'status_code' => 400,
            'error_code' => 1,
            'message' => resolve_error_code(1)
        ));
    }

    if(get_parameter('secret_key') == null)
    {
        returnJsonResponse(array(
            'status' => false,
            'status_code' => 400,
            'error_code' => 22,
            'message' => resolve_error_code(22)
        ));
    }

    if(get_parameter('access_token') == null)
    {
        returnJsonResponse(array(
            'status' => false,
            'status_code' => 400,
            'error_code' => 24,
            'message' => resolve_error_code(24)
        ));
    }

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

    try
    {
        $Application = $IntellivoidAccounts->getApplicationManager()->getApplication(
            ApplicationSearchMethod::byApplicationId, get_parameter('application_id')
        );
    }
    catch (ApplicationNotFoundException $e)
    {
        returnJsonResponse(array(
            'status' => false,
            'status_code' => 400,
            'error_code' => 2,
            'message' => resolve_error_code(2)
        ));
    }
    catch(Exception $exception)
    {
        returnJsonResponse(array(
            'status' => false,
            'status_code' => 500,
            'error_code' => -1,
            'message' => resolve_error_code(-1)
        ));
    }

    if(get_parameter('secret_key') !== $Application->SecretKey)
    {
        returnJsonResponse(array(
            'status' => false,
            'status_code' => 401,
            'error_code' => 23,
            'message' => resolve_error_code(23)
        ));
    }

    if($Application->Status == ApplicationStatus::Suspended)
    {
        returnJsonResponse(array(
            'status' => false,
            'status_code' => 403,
            'error_code' => 3,
            'message' => resolve_error_code(3)
        ));
    }

    try
    {
        $AuthenticationAccess = $IntellivoidAccounts->getCrossOverAuthenticationManager()->getAuthenticationAccessManager()->getAuthenticationAccess(AuthenticationAccessSearchMethod::byAccessToken, get_parameter('access_token'));
        $AuthenticationRequest = $IntellivoidAccounts->getCrossOverAuthenticationManager()->getAuthenticationRequestManager()->getAuthenticationRequest(AuthenticationRequestSearchMethod::byId, $AuthenticationAccess->RequestId);
    }
    catch (AuthenticationAccessNotFoundException $e)
    {
        returnJsonResponse(array(
            'status' => false,
            'status_code' => 401,
            'error_code' => 25,
            'message' => resolve_error_code(25)
        ));
    }
    catch (Exception $e)
    {
        returnJsonResponse(array(
            'status' => false,
            'status_code' => 500,
            'error_code' => -1,
            'message' => resolve_error_code(-1)
        ));
    }

    if((int)time() > $AuthenticationAccess->ExpiresTimestamp)
    {
        returnJsonResponse(array(
            'status' => false,
            'status_code' => 401,
            'error_code' => 27,
            'message' => resolve_error_code(27)
        ));
    }

    try
    {
        $Account = $IntellivoidAccounts->getAccountManager()->getAccount(AccountSearchMethod::byId, $AuthenticationAccess->AccountId);
    }
    catch (AccountNotFoundException $e)
    {
        returnJsonResponse(array(
            'status' => false,
            'status_code' => 404,
            'error_code' => 26,
            'message' => resolve_error_code(26)
        ));
    }
    catch (Exception $e)
    {
        returnJsonResponse(array(
            'status' => false,
            'status_code' => 500,
            'error_code' => -1,
            'message' => resolve_error_code(-1)
        ));
    }

    if($Account->Status == AccountStatus::Suspended)
    {
        returnJsonResponse(array(
            'status' => false,
            'status_code' => 410,
            'error_code' => 28,
            'message' => resolve_error_code(28)
        ));
    }

    $AuthenticationAccess->ExpiresTimestamp = (int)time() + 43200;
    $AuthenticationAccess->LastUsedTimestamp = (int)time();

    try
    {
        $IntellivoidAccounts->getCrossOverAuthenticationManager()->getAuthenticationAccessManager()->updateAuthenticationAccess($AuthenticationAccess);
    }
    catch(Exception $e)
    {
        returnJsonResponse(array(
            'status' => false,
            'status_code' => 500,
            'error_code' => -1,
            'message' => resolve_error_code(-1)
        ));
    }

    DynamicalWeb::setMemoryObject('authentication_access', $AuthenticationAccess);
    DynamicalWeb::setMemoryObject('authentication_request', $AuthenticationRequest);
    DynamicalWeb::setMemoryObject('account', $Account);