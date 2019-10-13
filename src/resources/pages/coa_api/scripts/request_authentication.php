<?php


    use DynamicalWeb\Actions;
    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\Page;
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
        Actions::redirect(DynamicalWeb::getRoute('application_error', array('error_code' => '2')));
    }
    catch(Exception $exception)
    {
        Actions::redirect(DynamicalWeb::getRoute('application_error', array('error_code' => '-1')));
    }


    if($Application->Status == ApplicationStatus::Suspended)
    {
        Actions::redirect(DynamicalWeb::getRoute('application_error', array('error_code' => '3')));
    }

    if($Application->Status == ApplicationStatus::Disabled)
    {
        Actions::redirect(DynamicalWeb::getRoute('application_error', array('error_code' => '4')));
    }

    if($Application->AuthenticationMode == AuthenticationMode::Redirect)
    {
        if(get_parameter('redirect') == null)
        {
            Actions::redirect(DynamicalWeb::getRoute('application_error', array('error_code' => '6')));
        }
    }

    try
    {
        $KnownHost = $IntellivoidAccounts->getKnownHostsManager()->syncHost(CLIENT_REMOTE_HOST, CLIENT_USER_AGENT);
    }
    catch(Exception $exception)
    {
        Actions::redirect(DynamicalWeb::getRoute('application_error', array('error_code' => '5')));
    }

    try
    {
        $AuthRequestToken = $IntellivoidAccounts->getCrossOverAuthenticationManager()->getAuthenticationRequestManager()->createAuthenticationRequest(
            $Application, $KnownHost->ID
        );
    }
    catch (DatabaseException $e)
    {
        Actions::redirect(DynamicalWeb::getRoute('application_error', array('error_code' => '-1')));
    }

    if($Application->AuthenticationMode == AuthenticationMode::Redirect)
    {
        Actions::redirect(DynamicalWeb::getRoute('login',
            array('auth' => 'application', 'redirect' => get_parameter('redirect'), 'application_id' => $Application->PublicAppId, 'request_token' => $AuthRequestToken->RequestToken)
        ));
    }
    else
    {
        Actions::redirect(DynamicalWeb::getRoute('login',
            array('auth' => 'application', 'application_id' => $Application->PublicAppId, 'request_token' => $AuthRequestToken->RequestToken)
        ));
    }
