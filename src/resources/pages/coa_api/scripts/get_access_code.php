<?php


    use DynamicalWeb\Actions;
    use DynamicalWeb\DynamicalWeb;
    use IntellivoidAccounts\Abstracts\ApplicationStatus;
    use IntellivoidAccounts\Abstracts\AuthenticationMode;
    use IntellivoidAccounts\Abstracts\SearchMethods\ApplicationSearchMethod;
use IntellivoidAccounts\Abstracts\SearchMethods\AuthenticationAccessSearchMethod;
use IntellivoidAccounts\Abstracts\SearchMethods\AuthenticationRequestSearchMethod;
use IntellivoidAccounts\Exceptions\ApplicationNotFoundException;
use IntellivoidAccounts\Exceptions\AuthenticationAccessNotFoundException;
use IntellivoidAccounts\Exceptions\AuthenticationRequestNotFoundException;
use IntellivoidAccounts\Exceptions\DatabaseException;
use IntellivoidAccounts\Exceptions\InvalidSearchMethodException;
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

    //if(get_parameter('secret_key') == null)
    //{
    //    returnJsonResponse(array(
    //        'status' => false,
    //        'status_code' => 400,
    //        'error_code' => 22,
    //        'message' => resolve_error_code(22)
    //    ));
    //}

    if(get_parameter('request_token') == null)
    {
        returnJsonResponse(array(
            'status' => false,
            'status_code' => 400,
            'error_code' => 39,
            'message' => resolve_error_code(39)
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

    // Check if the Application Exists
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

    //if(get_parameter('secret_key') !== $Application->SecretKey)
    //{
    //    returnJsonResponse(array(
    //        'status' => false,
    //        'status_code' => 401,
    //        'error_code' => 23,
    //        'message' => resolve_error_code(23)
    //    ));
    //}

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
        $AuthenticationRequest = $IntellivoidAccounts->getCrossOverAuthenticationManager()->getAuthenticationRequestManager()->getAuthenticationRequest(
            AuthenticationRequestSearchMethod::requestToken, get_parameter('request_token')
        );
    }
    catch (AuthenticationRequestNotFoundException $e)
    {
        returnJsonResponse(array(
            'status' => false,
            'status_code' => 400,
            'error_code' => 40,
            'message' => resolve_error_code(40)
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

    if((int)time() > $AuthenticationRequest->ExpiresTimestamp)
    {
        returnJsonResponse(array(
            'status' => false,
            'status_code' => 400,
            'error_code' => 34,
            'message' => resolve_error_code(34)
        ));
    }

    try
    {
        $AuthenticationAccess = $IntellivoidAccounts->getCrossOverAuthenticationManager()->getAuthenticationAccessManager()->getAuthenticationAccess(
            AuthenticationAccessSearchMethod::byRequestId, $AuthenticationRequest->Id
        );
    }
    catch (AuthenticationAccessNotFoundException $e)
    {
        returnJsonResponse(array(
            'status' => false,
            'status_code' => 400,
            'error_code' => 41,
            'message' => resolve_error_code(41)
        ));
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

    returnJsonResponse(array(
        'status' => true,
        'status_code' => 200,
        'access_token' => $AuthenticationAccess->AccessToken
    ));