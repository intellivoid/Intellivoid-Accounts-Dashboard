<?php


    use DynamicalWeb\Actions;
    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\Page;
use IntellivoidAccounts\Abstracts\ApplicationStatus;
use IntellivoidAccounts\Abstracts\SearchMethods\ApplicationSearchMethod;
    use IntellivoidAccounts\Exceptions\ApplicationNotFoundException;
    use IntellivoidAccounts\Exceptions\DatabaseException;
    use IntellivoidAccounts\IntellivoidAccounts;

    if(get_parameter('application_id') == null)
        {
            returnJsonResponse(array(
                'status' => false,
                'response_code' => 103,
                'message' => 'Invalid Action'
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
            'response_code' => 104,
            'message' => 'Invalid public Application ID'
        ));
    }
    catch(Exception $exception)
    {
        returnJsonResponse(array(
            'status' => false,
            'response_code' => 102,
            'message' => 'Internal Server Error'
        ));
    }


    if($Application->Status == ApplicationStatus::Suspended)
    {
        Page::staticResponse(
            'Intellivoid Accounts', 'Authentication unavailable',
            "The Application that's trying to authenticate you has been suspended."
        );
        exit();
    }

    if($Application->Status == ApplicationStatus::Disabled)
    {
        Page::staticResponse(
            'Intellivoid Accounts', 'Authentication unavailable',
            "The Application that's trying to authenticate you is unavailable at the moment."
        );
        exit();
    }

    try
    {
        $KnownHost = $IntellivoidAccounts->getKnownHostsManager()->syncHost(CLIENT_REMOTE_HOST, CLIENT_USER_AGENT);
    }
    catch(Exception $exception)
    {
        Page::staticResponse(
            'Security Error', 'Security Verification Failure',
            "The server cannot verify your browser or IP Address, please contact support."
        );
        exit();
    }

    try
    {
        $AuthRequestToken = $IntellivoidAccounts->getCrossOverAuthenticationManager()->getAuthenticationRequestManager()->createAuthenticationRequest(
            $Application, $KnownHost->ID
        );
    }
    catch (DatabaseException $e)
    {
        Page::staticResponse(
            'Server Error', 'Internal Server Error',
            "There was an issue while trying to process your request."
        );
        exit();
    }

    Actions::redirect(DynamicalWeb::getRoute('login',
        array('auth' => 'application', 'application_id' => $Application->PublicAppId, 'request_token' => $AuthRequestToken->RequestToken)
    ));