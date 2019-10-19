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
        'permissions' => array(),
        'user' => array()
    );

    if($AuthenticationRequest->has_requested_permission(AccountRequestPermissions::ViewEmailAddress))
    {
        if($AuthenticationAccess->has_permission(AccountRequestPermissions::ViewEmailAddress))
        {
            $Response['permissions']['view_email_address'] = true;
        }
        else
        {
            $Response['permissions']['view_email_address'] = false;
        }
    }

    if($AuthenticationRequest->has_requested_permission(AccountRequestPermissions::ReadPersonalInformation))
    {
        if($AuthenticationAccess->has_permission(AccountRequestPermissions::ReadPersonalInformation))
        {
            $Response['permissions']['read_personal_information'] = true;
        }
        else
        {
            $Response['permissions']['read_personal_information'] = false;
        }
    }

    if($AuthenticationRequest->has_requested_permission(AccountRequestPermissions::EditPersonalInformation))
    {
        if($AuthenticationAccess->has_permission(AccountRequestPermissions::EditPersonalInformation))
        {
            $Response['permissions']['edit_personal_information'] = true;
        }
        else
        {
            $Response['permissions']['edit_personal_information'] = false;
        }
    }

    if($AuthenticationRequest->has_requested_permission(AccountRequestPermissions::TelegramNotifications))
    {
        if($AuthenticationAccess->has_permission(AccountRequestPermissions::TelegramNotifications))
        {
            $Response['permissions']['send_telegram_notifications'] = true;
        }
        else
        {
            $Response['permissions']['send_telegram_notifications'] = false;
        }
    }

    if($AuthenticationRequest->has_requested_permission(AccountRequestPermissions::MakePurchases))
    {
        if($AuthenticationAccess->has_permission(AccountRequestPermissions::MakePurchases))
        {
            $Response['permissions']['make_purchases'] = true;
        }
        else
        {
            $Response['permissions']['make_purchases'] = false;
        }
    }

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

    if($AuthenticationRequest->has_requested_permission(AccountRequestPermissions::ViewEmailAddress))
    {
        if ($AuthenticationAccess->has_permission(AccountRequestPermissions::ViewEmailAddress))
        {
            $Response['user']['email_address'] = array(
                'available' => true,
                'value' => $Account->Email
            );
        }
        else
        {
            $Response['user']['email_address'] = array(
                'available' => false
            );
        }
    }

    if($AuthenticationRequest->has_requested_permission(AccountRequestPermissions::ReadPersonalInformation))
    {
        if($AuthenticationAccess->has_permission(AccountRequestPermissions::ReadPersonalInformation))
        {
            $Response['user']['personal_information'] = array(
                'available' => true,
                'first_name' => array(),
                'last_name' => array(),
                'birthday' => array(),
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

            if($Account->PersonalInformation->LastName == null)
            {
                $Response['user']['personal_information']['last_name'] = array(
                    'available' => false,
                    'value' => null
                );
            }
            else
            {
                $Response['user']['personal_information']['last_name'] = array(
                    'available' => true,
                    'value' => $Account->PersonalInformation->LastName
                );
            }

            if($Account->PersonalInformation->BirthDate->Day == null)
            {
                $Response['user']['personal_information']['birthday'] = array(
                    'available' => false,
                    'day' => null,
                    'month' => null,
                    'year' => null
                );
            }
            else
            {
                $Response['user']['personal_information']['birthday'] = array(
                    'available' => true,
                    'day' => (int)$Account->PersonalInformation->BirthDate->Day,
                    'month' => (int)$Account->PersonalInformation->BirthDate->Month,
                    'year' => (int)$Account->PersonalInformation->BirthDate->Year
                );
            }
        }
        else
        {
            $Response['user']['personal_information'] = array(
                'available' => false
            );
        }
    }

    returnJsonResponse($Response);