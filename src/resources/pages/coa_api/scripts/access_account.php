<?php


    use DynamicalWeb\Actions;
    use DynamicalWeb\DynamicalWeb;
use IntellivoidAccounts\Abstracts\AccountRequestPermissions;
use IntellivoidAccounts\Abstracts\ApplicationStatus;
    use IntellivoidAccounts\Abstracts\AuthenticationMode;
use IntellivoidAccounts\Abstracts\SearchMethods\AccountSearchMethod;
use IntellivoidAccounts\Abstracts\SearchMethods\ApplicationSearchMethod;
use IntellivoidAccounts\Abstracts\SearchMethods\AuthenticationAccessSearchMethod;
use IntellivoidAccounts\Abstracts\SearchMethods\AuthenticationRequestSearchMethod;
use IntellivoidAccounts\Exceptions\ApplicationNotFoundException;
use IntellivoidAccounts\Exceptions\AuthenticationAccessNotFoundException;
use IntellivoidAccounts\Exceptions\DatabaseException;
use IntellivoidAccounts\Exceptions\InvalidSearchMethodException;
use IntellivoidAccounts\IntellivoidAccounts;

    if(get_parameter('application_id') == null)
    {
        returnJsonResponse(array(
            'status' => false,
            'status_code' => 400,
            'error_code' => 1,
            'message' => "MISSING PARAMETER 'application_id'"
        ));
    }

    if(get_parameter('secret_key') == null)
    {
        returnJsonResponse(array(
            'status' => false,
            'status_code' => 400,
            'error_code' => 22,
            'message' => "MISSING PARAMETER 'secret_key'"
        ));
    }

    if(get_parameter('access_token') == null)
    {
        returnJsonResponse(array(
            'status' => false,
            'status_code' => 400,
            'error_code' => 24,
            'message' => "MISSING PARAMETER 'access_token'"
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
            'message' => "INVALID APPLICATION ID"
        ));
    }
    catch(Exception $exception)
    {
        returnJsonResponse(array(
            'status' => false,
            'status_code' => 500,
            'error_code' => -1,
            'message' => "INTERNAL SERVER ERROR"
        ));
    }

    if(get_parameter('secret_key') !== $Application->SecretKey)
    {
        returnJsonResponse(array(
            'status' => false,
            'status_code' => 401,
            'error_code' => 23,
            'message' => "ACCESS DENIED, INCORRECT SECRET KEY"
        ));
    }

    if($Application->Status == ApplicationStatus::Suspended)
    {
        returnJsonResponse(array(
            'status' => false,
            'status_code' => 403,
            'error_code' => 3,
            'message' => "APPLICATION SUSPENDED"
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
            'message' => "ACCESS DENIED, INCORRECT ACCESS TOKEN"
        ));
    }
    catch (Exception $e)
    {
        returnJsonResponse(array(
            'status' => false,
            'status_code' => 500,
            'error_code' => -1,
            'message' => "INTERNAL SERVER ERROR"
        ));
    }

    $Account = $IntellivoidAccounts->getAccountManager()->getAccount(AccountSearchMethod::byId, $AuthenticationAccess->AccountId);

    $Response = array(
        'status' => true,
        'status_code' => 200,
        'user' => array()
    );

    $Domain = 'https://accounts.intellivoid.info';
    $Response['user']['tag'] = $Account->ID;
    $Response['user']['public_id'] = $Account->PublicID;
    $Response['user']['username'] = $Account->Username;
    $Response['user']['avatar'] = array(
        'normal' =>     $Domain .  DynamicalWeb::getRoute('avatar', array('user_id' => $Account->PublicID, 'resource' => 'normal')),
        'original' =>   $Domain  .  DynamicalWeb::getRoute('avatar', array('user_id' => $Account->PublicID, 'resource' => 'original')),
        'preview' =>    $Domain .  DynamicalWeb::getRoute('avatar', array('user_id' => $Account->PublicID, 'resource' => 'preview')),
        'small' =>      $Domain .  DynamicalWeb::getRoute('avatar', array('user_id' => $Account->PublicID, 'resource' => 'small')),
        'tiny' =>       $Domain .  DynamicalWeb::getRoute('avatar', array('user_id' => $Account->PublicID, 'resource' => 'tiny')),
    );

    $Response['user']['personal_information'] = array(
        'available' => false
    );

    if(in_array(AccountRequestPermissions::ReadPersonalInformation, $AuthenticationRequest->RequestedPermissions))
    {
        if(in_array(AccountRequestPermissions::ReadPersonalInformation, $AuthenticationAccess->Permissions))
        {
            $Response['user']['personal_information'] = array(
                'available' => true,
                'first_name' => array(),
                'last_name' => array(),
                'birthday' => array(),
                'email' => array()
            );

            if($Account->PersonalInformation->FirstName == null)
            {
                $Response['user']['personal_information']['first_name'] = array(
                    'available' => false,
                    'value' => null
                );
            }
            else
            {
                $Response['user']['personal_information']['first_name'] = array(
                    'available' => true,
                    'value' => $Account->PersonalInformation->FirstName
                );
            }
        }
    }

    returnJsonResponse($Response);