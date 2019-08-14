<?php

    use DynamicalWeb\DynamicalWeb;
    use IntellivoidAccounts\IntellivoidAccounts;
    use IntellivoidAccounts\Objects\Account;

    /** @var IntellivoidAccounts $IntellivoidAccounts */
    $IntellivoidAccounts = DynamicalWeb::getMemoryObject('intellivoid_accounts');

    /** @var Account $Account */
    $Account = DynamicalWeb::getMemoryObject('account');

    $Account->Configuration->VerificationMethods->TwoFactorAuthentication->enable();
    $IntellivoidAccounts->getAccountManager()->updateAccount($Account);
    $QRCode = \tsa\Classes\Utilities::createQrCodeImage(
        $Account->Username,
        $Account->Configuration->VerificationMethods->TwoFactorAuthentication->PrivateSignature,
        "Intellivoid Accounts"
    );

    define("SECURITY_SECRET_CODE", $Account->Configuration->VerificationMethods->TwoFactorAuthentication->PrivateSignature);
    define("SECURITY_QR_CODE", $QRCode);
