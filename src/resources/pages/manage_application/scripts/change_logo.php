<?php

    use DynamicalWeb\Actions;
    use DynamicalWeb\DynamicalWeb;
    use IntellivoidAccounts\IntellivoidAccounts;
    use IntellivoidAccounts\Objects\COA\Application;

    /** @var Application $Application */
    $Application = DynamicalWeb::getMemoryObject('application');

    /** @var IntellivoidAccounts $IntellivoidAccounts */
    $IntellivoidAccounts = DynamicalWeb::getMemoryObject("intellivoid_accounts");


    try
    {
        $file = $IntellivoidAccounts->getAppUdp()->getTemporaryFileManager()->accept_upload();
    }
    catch(Exception $exception)
    {
        var_dump($exception);
        exit();
    }

    try
    {
        $IntellivoidAccounts->getAppUdp()->getProfilePictureManager()->apply_avatar($file, $Application->PublicAppId);
    }
    catch(Exception $exception)
    {
        var_dump($exception);
        exit();
    }

    Actions::redirect(DynamicalWeb::getRoute('manage_application', array(
        'pub_id' => $Application->PublicAppId
    )));