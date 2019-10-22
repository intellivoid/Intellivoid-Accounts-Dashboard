<?php


    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use IntellivoidAccounts\Abstracts\AccountRequestPermissions;
    use IntellivoidAccounts\Objects\Account;
    use IntellivoidAccounts\Objects\COA\AuthenticationAccess;
    use IntellivoidAccounts\Objects\COA\AuthenticationRequest;

    HTML::importScript('check_access');

    /** @var AuthenticationRequest $AuthenticationRequest */
    $AuthenticationRequest = DynamicalWeb::getMemoryObject('authentication_request');

    /** @var AuthenticationAccess $AuthenticationRequest */
    $AuthenticationAccess = DynamicalWeb::getMemoryObject('authentication_access');

    /** @var Account $Account */
    $Account = DynamicalWeb::getMemoryObject('account');

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
        'normal' =>     $Domain . DynamicalWeb::getRoute('avatar', array('user_id' => $Account->PublicID, 'resource' => 'normal')),
        'original' =>   $Domain . DynamicalWeb::getRoute('avatar', array('user_id' => $Account->PublicID, 'resource' => 'original')),
        'preview' =>    $Domain . DynamicalWeb::getRoute('avatar', array('user_id' => $Account->PublicID, 'resource' => 'preview')),
        'small' =>      $Domain . DynamicalWeb::getRoute('avatar', array('user_id' => $Account->PublicID, 'resource' => 'small')),
        'tiny' =>       $Domain . DynamicalWeb::getRoute('avatar', array('user_id' => $Account->PublicID, 'resource' => 'tiny')),
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