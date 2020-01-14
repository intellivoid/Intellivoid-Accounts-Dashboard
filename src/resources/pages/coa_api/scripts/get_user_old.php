<?php


    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
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

    $protocol = "https";
    if(get_parameter('secured') == 'false')
    {
        $protocol = "http";
    }

    $Domain = $protocol . '://' . $_SERVER['HTTP_HOST'];

    $Response = array(
        'status' => true,
        'status_code' => 200,
        'permissions' => array(),
        'user' => array(
            'tag' => $Account->ID,
            'public_id' => $Account->PublicID,
            'username' => $Account->Username,
            'avatars' =>  array(
                'normal' =>     $Domain . DynamicalWeb::getRoute('avatar', array('user_id' => $Account->PublicID, 'resource' => 'normal')),
                'original' =>   $Domain . DynamicalWeb::getRoute('avatar', array('user_id' => $Account->PublicID, 'resource' => 'original')),
                'preview' =>    $Domain . DynamicalWeb::getRoute('avatar', array('user_id' => $Account->PublicID, 'resource' => 'preview')),
                'small' =>      $Domain . DynamicalWeb::getRoute('avatar', array('user_id' => $Account->PublicID, 'resource' => 'small')),
                'tiny' =>       $Domain . DynamicalWeb::getRoute('avatar', array('user_id' => $Account->PublicID, 'resource' => 'tiny')),
            )
        )
    );
    
    returnJsonResponse($Response);