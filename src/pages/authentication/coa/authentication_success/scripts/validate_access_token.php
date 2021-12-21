<?php

    use DynamicalWeb\Actions;
    use DynamicalWeb\DynamicalWeb;
    use IntellivoidAccounts\Abstracts\SearchMethods\AuthenticationAccessSearchMethod;
    use IntellivoidAccounts\Exceptions\AuthenticationAccessNotFoundException;
    use IntellivoidAccounts\IntellivoidAccounts;
    use IntellivoidAccounts\Objects\COA\Application;
    use IntellivoidAccounts\Objects\COA\AuthenticationRequest;

    if(isset($_GET['access_token']))
    {
        /** @var IntellivoidAccounts $IntellivoidAccounts */
        $IntellivoidAccounts = DynamicalWeb::getMemoryObject("intellivoid_accounts");

        /** @var Application $Application */
        $Application = DynamicalWeb::getMemoryObject('application');

        /** @var AuthenticationRequest $AuthenticationRequest */
        $AuthenticationRequest = DynamicalWeb::getMemoryObject('auth_request');

        try
        {
            $AccessToken = $IntellivoidAccounts->getCrossOverAuthenticationManager()->getAuthenticationAccessManager()->getAuthenticationAccess(AuthenticationAccessSearchMethod::byAccessToken, $_GET['access_token']);
        }
        catch (AuthenticationAccessNotFoundException $e)
        {
            Actions::redirect(DynamicalWeb::getRoute('authentication/coa/application_error', array('error_code' => '25')));
        }
        catch(Exception $exception)
        {
            Actions::redirect(DynamicalWeb::getRoute('authentication/coa/application_error', array('error_code' => '-1')));
        }

        if($AccessToken->ApplicationId !== $Application->ID)
        {
            Actions::redirect(DynamicalWeb::getRoute('authentication/coa/application_error', array('error_code' => '36')));
        }

        if($AccessToken->RequestId !== $AuthenticationRequest->Id)
        {
            Actions::redirect(DynamicalWeb::getRoute('authentication/coa/application_error', array('error_code' => '37')));
        }

        if($AccessToken->AccountId !== WEB_ACCOUNT_ID)
        {
            Actions::redirect(DynamicalWeb::getRoute('authentication/coa/application_error', array('error_code' => '38')));
        }

        if((int)time() > $AccessToken->ExpiresTimestamp)
        {
            Actions::redirect(DynamicalWeb::getRoute('authentication/coa/application_error', array('error_code' => '27')));
        }

        DynamicalWeb::setMemoryObject('access_token', $AccessToken);

    }
    else
    {
        Actions::redirect(DynamicalWeb::getRoute('authentication/coa/application_error', array('error_code' => '24')));
    }