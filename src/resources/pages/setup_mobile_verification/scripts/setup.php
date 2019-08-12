<?php

    use DynamicalWeb\Runtime;
    use IntellivoidAccounts\Abstracts\SearchMethods\AccountSearchMethod;
    use IntellivoidAccounts\IntellivoidAccounts;

    Runtime::import('IntellivoidAccounts');
    $IntellivoidAccounts = new IntellivoidAccounts();
    $Account = $IntellivoidAccounts->getAccountManager()->getAccount(AccountSearchMethod::byId, WEB_ACCOUNT_ID);

    $Account->Configuration->VerificationMethods->TwoFactorAuthentication->enable();
    $IntellivoidAccounts->getAccountManager()->updateAccount($Account);
    $QRCode = \tsa\Classes\Utilities::createQrCodeImage(
        $Account->Username,
        $Account->Configuration->VerificationMethods->TwoFactorAuthentication->PrivateSignature,
        "Intellivoid Accounts"
    );

    define("SECURITY_SECRET_CODE", $Account->Configuration->VerificationMethods->TwoFactorAuthentication->PrivateSignature);
    define("SECURITY_QR_CODE", $QRCode);
