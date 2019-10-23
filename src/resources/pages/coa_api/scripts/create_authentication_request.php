<?php


    use DynamicalWeb\Actions;
    use DynamicalWeb\DynamicalWeb;
    use IntellivoidAccounts\Abstracts\ApplicationStatus;
    use IntellivoidAccounts\Abstracts\AuthenticationMode;
    use IntellivoidAccounts\Abstracts\SearchMethods\ApplicationSearchMethod;
    use IntellivoidAccounts\Exceptions\ApplicationNotFoundException;
    use IntellivoidAccounts\Exceptions\DatabaseException;
    use IntellivoidAccounts\IntellivoidAccounts;

    if(get_parameter('application_id') == null)
    {
        Actions::redirect(DynamicalWeb::getRoute('application_error', array('error_code' => '1')));
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


    if($Application->Status == ApplicationStatus::Suspended)
    {
        returnJsonResponse(array(
            'status' => false,
            'status_code' => 403,
            'error_code' => 3,
            'message' => resolve_error_code(3)
        ));
    }

    if($Application->Status == ApplicationStatus::Disabled)
    {
        returnJsonResponse(array(
            'status' => false,
            'status_code' => 403,
            'error_code' => 4,
            'message' => resolve_error_code(4)
        ));
    }

    if($Application->AuthenticationMode == AuthenticationMode::Redirect)
    {
        if(get_parameter('redirect') == null)
        {
            returnJsonResponse(array(
                'status' => false,
                'status_code' => 400,
                'error_code' => 6,
                'message' => resolve_error_code(6)
            ));
        }
    }

    try
    {
        $KnownHost = $IntellivoidAccounts->getKnownHostsManager()->syncHost(CLIENT_REMOTE_HOST, CLIENT_USER_AGENT);
    }
    catch(Exception $exception)
    {
        returnJsonResponse(array(
            'status' => false,
            'status_code' => 400,
            'error_code' => 5,
            'message' => resolve_error_code(5)
        ));
    }

    try
    {
        $AuthRequestToken = $IntellivoidAccounts->getCrossOverAuthenticationManager()->getAuthenticationRequestManager()->createAuthenticationRequest(
            $Application, $KnownHost->ID
        );
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

    $protocol = 'https';

    if(get_parameter('secured') == 'false')
    {
        $protocol = 'http';
    }

    if($Application->AuthenticationMode == AuthenticationMode::Redirect)
    {
        returnJsonResponse(array(
            'status' => true,
            'status_code' => 200,
            'request_token' => $AuthRequestToken->RequestToken,
            'auth_url' => $protocol . '://' . $_SERVER['HTTP_HOST'] . DynamicalWeb::getRoute('login',
                    array(
                        'auth' => 'application',
                        'redirect' => get_parameter('redirect'),
                        'application_id' => $Application->PublicAppId,
                        'request_token' => $AuthRequestToken->RequestToken
                    ))
        ));
    }
    else
    {
        returnJsonResponse(array(
            'status' => true,
            'status_code' => 200,
            'request_token' => $AuthRequestToken->RequestToken,
            'auth_url' => $protocol . '://' . $_SERVER['HTTP_HOST'] . DynamicalWeb::getRoute('login',
                    array(
                        'auth' => 'application',
                        'application_id' => $Application->PublicAppId,
                        'request_token' => $AuthRequestToken->RequestToken
                    ))
        ));
    }
