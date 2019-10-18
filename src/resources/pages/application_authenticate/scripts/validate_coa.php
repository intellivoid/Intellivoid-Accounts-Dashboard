<?php


    use DynamicalWeb\Actions;
    use DynamicalWeb\DynamicalWeb;
    use IntellivoidAccounts\Abstracts\AuthenticationMode;
    use IntellivoidAccounts\Abstracts\SearchMethods\ApplicationSearchMethod;
    use IntellivoidAccounts\Abstracts\SearchMethods\AuthenticationRequestSearchMethod;
    use IntellivoidAccounts\Exceptions\ApplicationNotFoundException;
    use IntellivoidAccounts\Exceptions\AuthenticationRequestNotFoundException;
    use IntellivoidAccounts\IntellivoidAccounts;

    if(isset($_GET['auth']) == false)
    {
        Actions::redirect(DynamicalWeb::getRoute('application_error', array('error_code' => '7')));
    }

    if($_GET['auth'] !== 'application')
    {
        Actions::redirect(DynamicalWeb::getRoute('application_error', array('error_code' => '15')));
    }

    if(isset($_GET['application_id']) == false)
    {
        Actions::redirect(DynamicalWeb::getRoute('application_error', array('error_code' => '8')));
    }

    if(isset($_GET['request_token']) == false)
    {
        Actions::redirect(DynamicalWeb::getRoute('application_error', array('error_code' => '9')));
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
            ApplicationSearchMethod::byApplicationId, $_GET['application_id']
        );
    }
    catch (ApplicationNotFoundException $e)
    {
        Actions::redirect(DynamicalWeb::getRoute('application_error', array('error_code' => '10')));
    }
    catch(Exception $e)
    {
        Actions::redirect(DynamicalWeb::getRoute('application_error', array('error_code' => '11')));
    }

    try
    {
        $AuthenticationRequest = $IntellivoidAccounts->getCrossOverAuthenticationManager()->getAuthenticationRequestManager()->getAuthenticationRequest(
            AuthenticationRequestSearchMethod::requestToken, $_GET['request_token']
        );
    }
    catch (AuthenticationRequestNotFoundException $e)
    {
        Actions::redirect(DynamicalWeb::getRoute('application_error', array('error_code' => '12')));
    }
    catch(Exception $e)
    {
        Actions::redirect(DynamicalWeb::getRoute('application_error', array('error_code' => '13')));
    }

    if($Application->AuthenticationMode == AuthenticationMode::Redirect)
    {
        if(isset($_GET['redirect']) == false)
        {
            Actions::redirect(DynamicalWeb::getRoute('application_error', array('error_code' => '14')));
        }

        // Validate the URL
        if (filter_var($_GET['redirect'], FILTER_VALIDATE_URL) == false)
        {
            Actions::redirect(DynamicalWeb::getRoute('application_error', array('error_code' => '17')));
        }

    }

    // TODO: Check if auth request has expired or is already used

    DynamicalWeb::setMemoryObject('application', $Application);
    DynamicalWeb::setMemoryObject('auth_request', $AuthenticationRequest);