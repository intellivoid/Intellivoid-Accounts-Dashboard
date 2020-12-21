<?php


    use DynamicalWeb\Actions;
    use DynamicalWeb\DynamicalWeb;
    use IntellivoidAccounts\Abstracts\ApplicationStatus;
    use IntellivoidAccounts\Abstracts\AuthenticationMode;
    use IntellivoidAccounts\Abstracts\SearchMethods\ApplicationSearchMethod;
    use IntellivoidAccounts\Exceptions\ApplicationNotFoundException;
    use IntellivoidAccounts\Exceptions\DatabaseException;
    use IntellivoidAccounts\IntellivoidAccounts;

    if(get_parameter("application_id") == null)
    {
        header("X-COA-Error: 1");
        Actions::redirect(DynamicalWeb::getRoute("application_error", array("error_code" => "1")));
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
            ApplicationSearchMethod::byApplicationId, get_parameter("application_id")
        );
    }
    catch (ApplicationNotFoundException $e)
    {
        header("X-COA-Error: 2");
        Actions::redirect(DynamicalWeb::getRoute("application_error", array("error_code" => "2")));
    }
    catch(Exception $exception)
    {
        header("X-COA-Error: -1");
        Actions::redirect(DynamicalWeb::getRoute("application_error", array("error_code" => "-1", "internal_reason" => "application_exception")));
    }


    if($Application->Status == ApplicationStatus::Suspended)
    {
        header("X-COA-Error: 3");
        Actions::redirect(DynamicalWeb::getRoute("application_error", array("error_code" => "3")));
    }

    if($Application->Status == ApplicationStatus::Disabled)
    {
        header("X-COA-Error: 4");
        Actions::redirect(DynamicalWeb::getRoute("application_error", array("error_code" => "4")));
    }

    if($Application->AuthenticationMode == AuthenticationMode::Redirect)
    {
        if(get_parameter("redirect") == null)
        {
            header("X-COA-Error: 6");
            Actions::redirect(DynamicalWeb::getRoute("application_error", array("error_code" => "6")));
        }
    }

    try
    {
        $KnownHost = $IntellivoidAccounts->getKnownHostsManager()->syncHost(CLIENT_REMOTE_HOST, CLIENT_USER_AGENT);
    }
    catch(Exception $exception)
    {
        header("X-COA-Error: 5");
        Actions::redirect(DynamicalWeb::getRoute("application_error", array("error_code" => "5", "furry" => "awoooo")));
    }

    try
    {
        $AuthRequestToken = $IntellivoidAccounts->getCrossOverAuthenticationManager()->getAuthenticationRequestManager()->createAuthenticationRequest(
            $Application, $KnownHost->ID
        );
    }
    catch (Exception $e)
    {
        header("X-COA-Error: -1");
        Actions::redirect(DynamicalWeb::getRoute("application_error", array("error_code" => "-1", "internal_reason" => "auth_request_exception")));
    }

    if($Application->AuthenticationMode == AuthenticationMode::Redirect)
    {
        Actions::redirect(DynamicalWeb::getRoute("login",
            array("auth" => "application", "redirect" => get_parameter("redirect"), "application_id" => $Application->PublicAppId, "request_token" => $AuthRequestToken->RequestToken)
        ));
    }
    else
    {
        Actions::redirect(DynamicalWeb::getRoute("login",
            array("auth" => "application", "application_id" => $Application->PublicAppId, "request_token" => $AuthRequestToken->RequestToken)
        ));
    }
