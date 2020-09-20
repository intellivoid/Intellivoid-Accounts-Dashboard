<?php

    use DynamicalWeb\Actions;
    use DynamicalWeb\DynamicalWeb;
    use IntellivoidAccounts\Abstracts\AccountRequestPermissions;
    use IntellivoidAccounts\Abstracts\ApplicationStatus;
    use IntellivoidAccounts\IntellivoidAccounts;
    use IntellivoidAccounts\Objects\COA\Application;

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

    if($Application->Status == ApplicationStatus::Suspended)
    {
        Actions::redirect(DynamicalWeb::getRoute('manage_application',
            array('pub_id' => $Application->PublicAppId, 'callback' => '115'))
        );
    }

    $Application->Permissions = [];

    if(is_checked('perm_view_personal_information'))
    {
        $Application->apply_permission(AccountRequestPermissions::ReadPersonalInformation);
    }

    if(is_checked('perm_telegram_notifications'))
    {
        $Application->apply_permission(AccountRequestPermissions::TelegramNotifications);
    }

    if(is_checked('perm_view_email_address'))
    {
        $Application->apply_permission(AccountRequestPermissions::ViewEmailAddress);
    }

    if(is_checked('perm_view_telegram_client'))
    {
        $Application->apply_permission(AccountRequestPermissions::GetTelegramClient);
    }

    if(is_checked('perm_access_todo'))
    {
        $Application->apply_permission(AccountRequestPermissions::AccessTodo);
    }

    if(is_checked('perm_manage_todo'))
    {
        $Application->apply_permission(AccountRequestPermissions::ManageTodo);
    }

    if(is_checked('perm_sync_settings'))
    {
        $Application->apply_permission(AccountRequestPermissions::SyncApplicationSettings);
    }

    $Application->LastUpdatedTimestamp = (int)time();

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