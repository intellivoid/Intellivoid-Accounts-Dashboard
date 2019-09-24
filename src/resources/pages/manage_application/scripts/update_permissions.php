<?php

    use DynamicalWeb\Actions;
    use DynamicalWeb\DynamicalWeb;
use IntellivoidAccounts\Abstracts\AccountRequestPermissions;
use IntellivoidAccounts\IntellivoidAccounts;
    use IntellivoidAccounts\Objects\COA\Application;
    use IntellivoidAccounts\Utilities\Hashing;

    /**
     * @param string $parameter
     * @return bool
     */
    function is_checked(string $parameter): bool
    {
        if(isset($_POST[$parameter]))
        {
            if($_POST[$parameter] == 'on')
            {
                return true;
            }
        }

        return false;
    }

    /** @var Application $Application */
    $Application = DynamicalWeb::getMemoryObject('application');

    /** @var IntellivoidAccounts $IntellivoidAccounts */
    $IntellivoidAccounts = DynamicalWeb::getMemoryObject("intellivoid_accounts");


    $Application->Permissions = [];

    if(is_checked('perm_view_personal_information'))
    {
        $Application->apply_permission(AccountRequestPermissions::ReadPersonalInformation);
    }

    if(is_checked('perm_make_purchases'))
    {
        $Application->apply_permission(AccountRequestPermissions::MakePurchases);
    }

    if(is_checked('perm_edit_personal_information'))
    {
        $Application->apply_permission(AccountRequestPermissions::EditPersonalInformation);
    }

    if(is_checked('perm_telegram_notifications'))
    {
        $Application->apply_permission(AccountRequestPermissions::TelegramNotifications);
    }

    $Timestamp = (int)time();
    $Application->LastUpdatedTimestamp = $Timestamp;

    try
    {
        $IntellivoidAccounts->getApplicationManager()->updateApplication($Application);
        Actions::redirect(DynamicalWeb::getRoute('manage_application',
            array('pub_id' => $_GET['pub_id'], 'callback' => '110')
        ));
    }
    catch(Exception $exception)
    {
        Actions::redirect(DynamicalWeb::getRoute('manage_application',
            array('pub_id' => $_GET['pub_id'], 'callback' => '100')
        ));
    }