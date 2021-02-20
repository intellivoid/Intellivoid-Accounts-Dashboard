<?php


    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use IntellivoidAccounts\Abstracts\AccountRequestPermissions;
    use IntellivoidAccounts\Objects\Account;
    use IntellivoidAccounts\Objects\COA\AuthenticationAccess;
    use IntellivoidAccounts\Objects\COA\AuthenticationRequest;

    HTML::importScript("async.check_access");

    /** @var AuthenticationRequest $AuthenticationRequest */
    $AuthenticationRequest = DynamicalWeb::getMemoryObject("authentication_request");

    /** @var AuthenticationAccess $AuthenticationAccess */
    $AuthenticationAccess = DynamicalWeb::getMemoryObject("authentication_access");

    $Response = array(
        "status" => true,
        "response_code" => 200,
        "app_tag" => $AuthenticationAccess->ApplicationId,
        "expires" => $AuthenticationAccess->ExpiresTimestamp
    );

    returnJsonResponse($Response);