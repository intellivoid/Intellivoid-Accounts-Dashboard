<?PHP /** @noinspection PhpUndefinedConstantInspection */

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use IntellivoidAccounts\Abstracts\AccountRequestPermissions;
    use IntellivoidAccounts\Abstracts\ApplicationAccessStatus;
    use IntellivoidAccounts\Objects\ApplicationAccess;
    use IntellivoidAccounts\Objects\COA\Application;

    function list_authorized_services(array $application_access_records, array $applications)
    {
        ?>
        <div class="accordion" id="apps-accordion" role="tablist">
            <?PHP
                foreach($application_access_records as $access_record)
                {
                    $ApplicationAccess = ApplicationAccess::fromArray($access_record);

                    if($ApplicationAccess->Status == ApplicationAccessStatus::Authorized)
                    {
                        if(isset($applications[$ApplicationAccess->ApplicationID]))
                        {
                            /** @var Application $Application */
                            $Application = $applications[$ApplicationAccess->ApplicationID];
                        }
                        else
                        {
                            continue;
                        }
                        ?>
                        <div class="collapse-margin">
                            <div class="card-header" style="justify-content: normal;;" id="heading-<?PHP HTML::print($Application->PublicAppId); ?>" data-toggle="collapse" role="button" data-target="#collapse-<?PHP HTML::print($Application->PublicAppId); ?>" aria-expanded="false" aria-controls="collapse-<?PHP HTML::print($Application->PublicAppId); ?>">
                                <div data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" data-original-title="<?PHP HTML::print($Application->Name); ?>" class="avatar pull-up">
                                    <img class="media-object rounded-circle" src="<?PHP DynamicalWeb::getRoute('application_icon', array('app_id' => $Application->PublicAppId, 'resource' => 'small'), true); ?>" alt="<?PHP HTML::print($Application->Name); ?>" height="30" width="30">
                                </div>
                                <div class="ml-1">
                                    <h6 class="mb-0">
                                        <?PHP HTML::print($Application->Name); ?>
                                    </h6>
                                    <small class="text-muted d-none d-lg-inline">
                                        <?PHP HTML::print(str_ireplace('%s', gmdate("j/m/y g:i a", $ApplicationAccess->LastAuthenticatedTimestamp), TEXT_ITEM_LAST_AUTHENTICATED)); ?>
                                    </small>
                                    <small class="text-muted d-md-inline d-lg-none">
                                        <?PHP HTML::print(gmdate("j/m/y g:i a", $ApplicationAccess->LastAuthenticatedTimestamp)); ?>
                                    </small>
                                </div>
                                <div class="ml-auto mr-3 d-none d-md-inline">
                                    <i class="feather icon-user pl-25"></i>
                                    <?PHP
                                        if(in_array(AccountRequestPermissions::SyncApplicationSettings, $ApplicationAccess->Permissions))
                                        {
                                            HTML::print("<i class=\"feather icon-settings pl-25\"></i> ", false);
                                        }
                                        if(in_array(AccountRequestPermissions::ViewEmailAddress, $ApplicationAccess->Permissions))
                                        {
                                            HTML::print("<i class=\"feather icon-mail pl-25\"></i> ", false);
                                        }
                                        if(in_array(AccountRequestPermissions::ReadPersonalInformation, $ApplicationAccess->Permissions))
                                        {
                                            HTML::print("<i class=\"feather icon-eye pl-25\"></i> ", false);
                                        }
                                        if(in_array(AccountRequestPermissions::EditPersonalInformation, $ApplicationAccess->Permissions))
                                        {
                                            HTML::print("<i class=\"feather icon-edit-2 pl-25\"></i> ", false);
                                        }
                                        if(in_array(AccountRequestPermissions::MakePurchases, $ApplicationAccess->Permissions))
                                        {
                                            HTML::print("<i class=\"feather icon-shopping-cart pl-25\"></i> ", false);
                                        }
                                        if(in_array(AccountRequestPermissions::TelegramNotifications, $ApplicationAccess->Permissions))
                                        {
                                            HTML::print("<i class=\"feather icon-message-square pl-25\"></i> ", false);
                                        }
                                        if(in_array(AccountRequestPermissions::GetTelegramClient, $ApplicationAccess->Permissions))
                                        {
                                            HTML::print("<i class=\"feather icon-info pl-25\"></i> ", false);
                                        }
                                        if(in_array(AccountRequestPermissions::ManageTodo, $ApplicationAccess->Permissions))
                                        {
                                            HTML::print("<i class=\"feather icon-check-square pl-25\"></i> ", false);
                                        }
                                        elseif(in_array(AccountRequestPermissions::AccessTodo, $ApplicationAccess->Permissions))
                                        {
                                            HTML::print("<i class=\"feather icon-check-square pl-25\"></i> ", false);
                                        }
                                    ?>

                                </div>
                            </div>

                            <div id="collapse-<?PHP HTML::print($Application->PublicAppId); ?>" class="collapse" aria-labelledby="heading-<?PHP HTML::print($Application->PublicAppId); ?>" data-parent="#apps-accordion">
                                <div class="card-body pt-50 px-2">
                                    <div class="row grid-margin d-flex mb-0">
                                        <div class="col-lg-9 mb-2">
                                            <p><?PHP HTML::print(str_ireplace("%s", $Application->Name, TEXT_PERMISSIONS_HEADER)); ?></p>
                                            <div class="d-flex ml-2 align-items-center pb-50">
                                                <i class="feather icon-user"></i>
                                                <p class="mb-0 ml-2"><?PHP HTML::print(TEXT_PERMISSIONS_USERNAME_AVATAR_TEXT); ?></p>
                                            </div>
                                            <?PHP
                                                if(in_array(AccountRequestPermissions::SyncApplicationSettings, $ApplicationAccess->Permissions))
                                                {
                                                    ?>
                                                    <div class="d-flex ml-2 align-items-center pb-50">
                                                        <i class="feather icon-settings"></i>
                                                        <p class="mb-0 ml-2"><?PHP HTML::print(TEXT_PERMISSIONS_SYNC_SETTINGS_TEXT); ?></p>
                                                    </div>
                                                    <?PHP
                                                }
                                                if(in_array(AccountRequestPermissions::ViewEmailAddress, $ApplicationAccess->Permissions))
                                                {
                                                    ?>
                                                    <div class="d-flex ml-2 align-items-center pb-50">
                                                        <i class="feather icon-mail"></i>
                                                        <p class="mb-0 ml-2"><?PHP HTML::print(TEXT_PERMISSIONS_EMAIL_TEXT); ?></p>
                                                    </div>
                                                    <?PHP
                                                }
                                                if(in_array(AccountRequestPermissions::ReadPersonalInformation, $ApplicationAccess->Permissions))
                                                {
                                                    ?>
                                                    <div class="d-flex ml-2 align-items-center pb-50">
                                                        <i class="feather icon-eye"></i>
                                                        <p class="mb-0 ml-2"><?PHP HTML::print(TEXT_PERMISSIONS_PERSONAL_INFORMATION_TEXT); ?></p>
                                                    </div>
                                                    <?PHP
                                                }
                                                if(in_array(AccountRequestPermissions::EditPersonalInformation, $ApplicationAccess->Permissions))
                                                {
                                                    ?>
                                                    <div class="d-flex ml-2 align-items-center pb-50">
                                                        <i class="feather icon-edit-2"></i>
                                                        <p class="mb-0 ml-2"><?PHP HTML::print(TEXT_PERMISSIONS_EDIT_PERSONAL_INFORMATION_TEXT); ?></p>
                                                    </div>
                                                    <?PHP
                                                }
                                                if(in_array(AccountRequestPermissions::MakePurchases, $ApplicationAccess->Permissions))
                                                {
                                                    ?>
                                                    <div class="d-flex ml-2 align-items-center pb-50">
                                                        <i class="feather icon-shopping-cart"></i>
                                                        <p class="mb-0 ml-2"><?PHP HTML::print(TEXT_PERMISSIONS_MAKE_PURCHASE_TEXT); ?></p>
                                                    </div>
                                                    <?PHP
                                                }
                                                if(in_array(AccountRequestPermissions::TelegramNotifications, $ApplicationAccess->Permissions))
                                                {
                                                    ?>
                                                    <div class="d-flex ml-2 align-items-center pb-50">
                                                        <i class="feather icon-message-square"></i>
                                                        <p class="mb-0 ml-2"><?PHP HTML::print(TEXT_PERMISSIONS_TELEGRAM_NOTIFICATIONS_TEXT); ?></p>
                                                    </div>
                                                    <?PHP
                                                }
                                                if(in_array(AccountRequestPermissions::GetTelegramClient, $ApplicationAccess->Permissions))
                                                {
                                                    ?>
                                                    <div class="d-flex ml-2 align-items-center pb-50">
                                                        <i class="feather icon-info"></i>
                                                        <p class="mb-0 ml-2"><?PHP HTML::print(TEXT_PERMISSIONS_VIEW_TELEGRAM_ACCOUNT_TEXT); ?></p>
                                                    </div>
                                                    <?PHP
                                                }

                                                if(in_array(AccountRequestPermissions::ManageTodo, $ApplicationAccess->Permissions))
                                                {
                                                    ?>
                                                    <div class="d-flex ml-2 align-items-center pb-50">
                                                        <i class="feather icon-check-square"></i>
                                                        <p class="mb-0 ml-2"><?PHP HTML::print(TEXT_PERMISSIONS_MANAGE_TODO_MANAGER_TEXT); ?></p>
                                                    </div>
                                                    <?PHP
                                                }
                                                elseif(in_array(AccountRequestPermissions::AccessTodo, $ApplicationAccess->Permissions))
                                                {
                                                    ?>
                                                    <div class="d-flex ml-2 align-items-center pb-50">
                                                        <i class="feather icon-check-square"></i>
                                                        <p class="mb-0 ml-2"><?PHP HTML::print(TEXT_PERMISSIONS_ACCESS_TODO_MANAGER_TEXT); ?></p>
                                                    </div>
                                                    <?PHP
                                                }
                                            ?>
                                        </div>
                                        <div class="col-lg-3 mt-auto mb-1">
                                            <!-- <button class="btn btn-block btn-square btn-outline-success" onclick="location.href='<?PHP #DynamicalWeb::getRoute('settings/authorized_apps', array('action' => 'revoke_access', 'access_id' => $ApplicationAccess->PublicID), true); ?>';">Export Data</button> -->
                                            <!-- <button class="btn btn-block btn-square btn-outline-light" onclick="location.href='<?PHP #DynamicalWeb::getRoute('settings/authorized_apps', array('action' => 'revoke_access', 'access_id' => $ApplicationAccess->PublicID), true); ?>';">Clear Data</button> -->
                                            <button class="btn btn-block btn-square btn-outline-danger" onclick="location.href='<?PHP DynamicalWeb::getRoute('settings/authorized_apps', array('action' => 'revoke_access', 'access_id' => $ApplicationAccess->PublicID), true); ?>';"><?PHP HTML::print(TEXT_REVOKE_ACCESS_BUTTON); ?></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?PHP
                    }
                }
            ?>
        </div>
        <?PHP
    }