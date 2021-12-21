<?php

    use DynamicalWeb\Actions;
    use DynamicalWeb\DynamicalWeb;
use IntellivoidAccounts\Abstracts\ApplicationStatus;
use IntellivoidAccounts\Abstracts\AuthenticationMode;
use IntellivoidAccounts\IntellivoidAccounts;
    use IntellivoidAccounts\Objects\COA\Application;

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

    if(isset($_POST['authentication_type']) == false)
    {
        Actions::redirect(DynamicalWeb::getRoute('manage_application',
            array('pub_id' => $Application->PublicAppId, 'callback' => '106')
        ));
    }

    switch($_POST['authentication_type'])
    {
        case 'redirect':
            $Application->AuthenticationMode = AuthenticationMode::Redirect;
            break;

        case 'placeholder':
            $Application->AuthenticationMode = AuthenticationMode::ApplicationPlaceholder;
            break;

        case 'code':
            $Application->AuthenticationMode = AuthenticationMode::Code;
            break;

        default:
            Actions::redirect(DynamicalWeb::getRoute('manage_application',
                array('pub_id' => $Application->PublicAppId, 'callback' => '107')
            ));
    }

    $IntellivoidAccounts->getApplicationManager()->updateApplication($Application);
    Actions::redirect(DynamicalWeb::getRoute('manage_application',
        array('pub_id' => $Application->PublicAppId, 'callback' => '108')
    ));