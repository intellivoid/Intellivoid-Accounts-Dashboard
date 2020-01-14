<?php

    use DynamicalWeb\Actions;
    use DynamicalWeb\DynamicalWeb;
use IntellivoidAccounts\Abstracts\ApplicationStatus;
use IntellivoidAccounts\IntellivoidAccounts;
    use IntellivoidAccounts\Objects\COA\Application;
    use IntellivoidAccounts\Utilities\Hashing;

    /** @var Application $Application */
    $Application = DynamicalWeb::getMemoryObject('application');

    /** @var IntellivoidAccounts $IntellivoidAccounts */
    $IntellivoidAccounts = DynamicalWeb::getMemoryObject("intellivoid_accounts");

    if($Application->Status == ApplicationStatus::Suspended)
    {
        Actions::redirect(DynamicalWeb::getRoute('manage_application',
            array('pub_id' => $Application->PublicAppId, 'callback' => '115'))
        );
    }

    $Timestamp = (int)time();
    $Application->SecretKey = Hashing::applicationSecretKey($Application->PublicAppId, $Timestamp);
    $Application->LastUpdatedTimestamp = $Timestamp;

    try
    {
        $IntellivoidAccounts->getApplicationManager()->updateApplication($Application);
        Actions::redirect(DynamicalWeb::getRoute('manage_application',
            array('pub_id' => $_GET['pub_id'], 'callback' => '111')
        ));
    }
    catch(Exception $exception)
    {
        Actions::redirect(DynamicalWeb::getRoute('manage_application',
            array('pub_id' => $_GET['pub_id'], 'callback' => '100')
        ));
    }