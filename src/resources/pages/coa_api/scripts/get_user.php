<?php


    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use IntellivoidAccounts\Abstracts\AccountRequestPermissions;
    use IntellivoidAccounts\Objects\Account;
    use IntellivoidAccounts\Objects\COA\AuthenticationAccess;
    use IntellivoidAccounts\Objects\COA\AuthenticationRequest;

    HTML::importScript('async.check_access');

    /** @var AuthenticationRequest $AuthenticationRequest */
    $AuthenticationRequest = DynamicalWeb::getMemoryObject('authentication_request');

    /** @var AuthenticationAccess $AuthenticationRequest */
    $AuthenticationAccess = DynamicalWeb::getMemoryObject('authentication_access');

    /** @var Account $Account */
    $Account = DynamicalWeb::getMemoryObject('account');

    $Response = array(
        'status' => true,
        'response_code' => 200,
        'user_information' => array()
    );

    $protocol = 'https';

    if(get_parameter('secured') == 'false')
    {
        $protocol = 'http';
    }

    $Domain = $protocol . '://' . $_SERVER['HTTP_HOST'];
    $Response['user_information']['tag'] = $Account->ID;
    $Response['user_information']['public_id'] = $Account->PublicID;
    $Response['user_information']['username'] = $Account->Username;
    $Response['user_information']['avatar'] = array(
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
            $Response['user_information']['email_address'] = array(
                'available' => true,
                'value' => $Account->Email
            );
        }
        else
        {
            $Response['user_information']['email_address'] = array(
                'available' => false
            );
        }
    }

    if($AuthenticationRequest->has_requested_permission(AccountRequestPermissions::ReadPersonalInformation))
    {
        if($AuthenticationAccess->has_permission(AccountRequestPermissions::ReadPersonalInformation))
        {
            $Response['user_information']['personal_information'] = array(
                'available' => true,
                'first_name' => array(),
                'last_name' => array(),
                'birthday' => array(),
            );

            if($Account->PersonalInformation->FirstName == null)
            {
                $Response['user_information']['personal_information']['first_name'] = array(
                    'available' => false,
                    'value' => null
                );
            }
            else
            {
                $Response['user_information']['personal_information']['first_name'] = array(
                    'available' => true,
                    'value' => $Account->PersonalInformation->FirstName
                );
            }

            if($Account->PersonalInformation->LastName == null)
            {
                $Response['user_information']['personal_information']['last_name'] = array(
                    'available' => false,
                    'value' => null
                );
            }
            else
            {
                $Response['user_information']['personal_information']['last_name'] = array(
                    'available' => true,
                    'value' => $Account->PersonalInformation->LastName
                );
            }

            if($Account->PersonalInformation->BirthDate->Day == null)
            {
                $Response['user_information']['personal_information']['birthday'] = array(
                    'available' => false,
                    'day' => null,
                    'month' => null,
                    'year' => null
                );
            }
            else
            {
                $Response['user_information']['personal_information']['birthday'] = array(
                    'available' => true,
                    'day' => (int)$Account->PersonalInformation->BirthDate->Day,
                    'month' => (int)$Account->PersonalInformation->BirthDate->Month,
                    'year' => (int)$Account->PersonalInformation->BirthDate->Year
                );
            }
        }
        else
        {
            $Response['user_information']['personal_information'] = array(
                'available' => false
            );
        }
    }
    else
    {
        $Response['user_information']['personal_information'] = array(
            'available' => false
        );
    }

    returnJsonResponse($Response);