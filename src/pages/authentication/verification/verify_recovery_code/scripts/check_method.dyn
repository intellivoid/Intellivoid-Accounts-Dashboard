<?php

    use DynamicalWeb\Actions;
    use DynamicalWeb\DynamicalWeb;
    use IntellivoidAccounts\Objects\Account;


    /** @var Account $Account */
    $Account = DynamicalWeb::getMemoryObject('account');

    if($Account->Configuration->VerificationMethods->RecoveryCodesEnabled == false)
    {
        $_GET['callback'] = '100';
        Actions::redirect(DynamicalWeb::getRoute('authentication/verification/verify', $_GET));
    }