<?php

    use DynamicalWeb\Actions;
    use DynamicalWeb\DynamicalWeb;
use IntellivoidAccounts\Abstracts\AccountRequestPermissions;
use IntellivoidAccounts\Abstracts\AccountStatus;
    use IntellivoidAccounts\Abstracts\ApplicationAccessStatus;
    use IntellivoidAccounts\Abstracts\ApplicationStatus;
    use IntellivoidAccounts\Abstracts\SearchMethods\AccountSearchMethod;
    use IntellivoidAccounts\Abstracts\SearchMethods\AuthenticationAccessSearchMethod;
    use IntellivoidAccounts\Abstracts\SearchMethods\AuthenticationRequestSearchMethod;
    use IntellivoidAccounts\Exceptions\AccountNotFoundException;
    use IntellivoidAccounts\Exceptions\AuthenticationAccessNotFoundException;
    use IntellivoidAccounts\IntellivoidAccounts;
    use IntellivoidAccounts\Objects\COA\Application;

if(get_parameter('app_tag') == null)
    {
        header('X-COA-Error: 1');
        Actions::redirect(DynamicalWeb::getRoute('authentication/coa/application_error', array('error_code' => '1')));
    }

    if(get_parameter('access_token') == null)
    {
        header('X-COA-Error: 24');
        Actions::redirect(DynamicalWeb::getRoute('authentication/coa/application_error', array('error_code' => '24')));
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

    /** @var Application $Application */
    $Application = DynamicalWeb::getMemoryObject('application');

    if($Application->Status == ApplicationStatus::Suspended)
    {
        header('X-COA-Error: 3');
        Actions::redirect(DynamicalWeb::getRoute('authentication/coa/application_error', array('error_code' => '3')));
    }

    try
    {
        $AuthenticationAccess = $IntellivoidAccounts->getCrossOverAuthenticationManager()->getAuthenticationAccessManager()->getAuthenticationAccess(
            AuthenticationAccessSearchMethod::byAccessToken, $_GET['access_token']
        );
        $AuthenticationRequest = $IntellivoidAccounts->getCrossOverAuthenticationManager()->getAuthenticationRequestManager()->getAuthenticationRequest(
            AuthenticationRequestSearchMethod::byId, $AuthenticationAccess->RequestId
        );
    }
    catch (AuthenticationAccessNotFoundException $e)
    {
        header('X-COA-Error: 25');
        Actions::redirect(DynamicalWeb::getRoute('authentication/coa/application_error', array('error_code' => '25')));
    }
    catch (Exception $e)
    {
        header('X-COA-Error: -1');
        Actions::redirect(DynamicalWeb::getRoute('authentication/coa/application_error', array('error_code' => '-1')));
    }

    if((int)time() > $AuthenticationAccess->ExpiresTimestamp)
    {
        header('X-COA-Error: 27');
        Actions::redirect(DynamicalWeb::getRoute('authentication/coa/application_error', array('error_code' => '27')));
    }

    try
    {
        $Account = $IntellivoidAccounts->getAccountManager()->getAccount(
            AccountSearchMethod::byId, $AuthenticationAccess->AccountId
        );
    }
    catch (AccountNotFoundException $e)
    {
        header('X-COA-Error: 26');
        Actions::redirect(DynamicalWeb::getRoute('authentication/coa/application_error', array('error_code' => '26')));
    }
    catch (Exception $e)
    {
        header('X-COA-Error: -1');
        Actions::redirect(DynamicalWeb::getRoute('authentication/coa/application_error', array('error_code' => '-1')));
    }

    if($Account->Status == AccountStatus::Suspended)
    {
        header('X-COA-Error: 28');
        Actions::redirect(DynamicalWeb::getRoute('authentication/coa/application_error', array('error_code' => '28')));
    }

    try
    {
        $ApplicationAccess = $IntellivoidAccounts->getCrossOverAuthenticationManager()->getApplicationAccessManager()->syncApplicationAccess(
            $Application->ID, $Account->ID
        );
    }
    catch(Exception $e)
    {
        header('X-COA-Error: -1');
        Actions::redirect(DynamicalWeb::getRoute('authentication/coa/application_error', array('error_code' => '-1')));
    }

    if($ApplicationAccess->Status == ApplicationAccessStatus::Unauthorized)
    {
        header('X-COA-Error: 29');
        Actions::redirect(DynamicalWeb::getRoute('authentication/coa/application_error', array('error_code' => '29')));
    }

    if(in_array(AccountRequestPermissions::MakePurchases ,$ApplicationAccess->Permissions) == false)
    {
        Actions::redirect(DynamicalWeb::getRoute(
            'purchase_failure', array(
                'error_type' => 'access_error',
                'error' => 'access_denied'
            )
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
        header('X-COA-Error: -1');
        Actions::redirect(DynamicalWeb::getRoute('authentication/coa/application_error', array('error_code' => '-1')));
    }

    DynamicalWeb::setMemoryObject('authentication_access', $AuthenticationAccess);
    DynamicalWeb::setMemoryObject('authentication_request', $AuthenticationRequest);
    DynamicalWeb::setMemoryObject('application_access', $ApplicationAccess);
    DynamicalWeb::setMemoryObject('account', $Account);