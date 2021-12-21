<?php

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use IntellivoidAccounts\Abstracts\AccountRequestPermissions;
    use IntellivoidAccounts\Objects\COA\AuthenticationAccess;
    use IntellivoidAccounts\Objects\COA\AuthenticationRequest;

    HTML::importScript("async.check_access");

    /** @var AuthenticationRequest $AuthenticationRequest */
    $AuthenticationRequest = DynamicalWeb::getMemoryObject("authentication_request");

    /** @var AuthenticationAccess $AuthenticationRequest */
    $AuthenticationAccess = DynamicalWeb::getMemoryObject("authentication_access");

    $Response = array(
        "status" => true,
        "response_code" => 200,
        "permissions" => array()
    );

    $Response["permissions"]["view_public_information"] = true;

    if($AuthenticationRequest->has_requested_permission(AccountRequestPermissions::ViewEmailAddress))
    {
        if($AuthenticationAccess->has_permission(AccountRequestPermissions::ViewEmailAddress))
        {
            $Response["permissions"]["view_email_address"] = true;
        }
        else
        {
            $Response["permissions"]["view_email_address"] = false;
        }
    }

    if($AuthenticationRequest->has_requested_permission(AccountRequestPermissions::ReadPersonalInformation))
    {
        if($AuthenticationAccess->has_permission(AccountRequestPermissions::ReadPersonalInformation))
        {
            $Response["permissions"]["read_personal_information"] = true;
        }
        else
        {
            $Response["permissions"]["read_personal_information"] = false;
        }
    }

    if($AuthenticationRequest->has_requested_permission(AccountRequestPermissions::TelegramNotifications))
    {
        if($AuthenticationAccess->has_permission(AccountRequestPermissions::TelegramNotifications))
        {
            $Response["permissions"]["send_telegram_notifications"] = true;
        }
        else
        {
            $Response["permissions"]["send_telegram_notifications"] = false;
        }
    }

    if($AuthenticationRequest->has_requested_permission(AccountRequestPermissions::MakePurchases))
    {
        if($AuthenticationAccess->has_permission(AccountRequestPermissions::MakePurchases))
        {
            $Response["permissions"]["make_purchases"] = true;
        }
        else
        {
            $Response["permissions"]["make_purchases"] = false;
        }
    }

    returnJsonResponse($Response);