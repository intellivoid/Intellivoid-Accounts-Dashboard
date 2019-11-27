<?PHP

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use IntellivoidAccounts\Abstracts\AccountRequestPermissions;
    use IntellivoidAccounts\Abstracts\ApplicationAccessStatus;
    use IntellivoidAccounts\Abstracts\SearchMethods\ApplicationSearchMethod;
use IntellivoidAccounts\Exceptions\ApplicationNotFoundException;
use IntellivoidAccounts\IntellivoidAccounts;
    use IntellivoidAccounts\Objects\ApplicationAccess;

    function list_authorized_services(array $application_access_records)
    {
        if(isset(DynamicalWeb::$globalObjects["intellivoid_accounts"]) == false)
        {
            /** @var IntellivoidAccounts $IntellivoidAccounts */
            $IntellivoidAccounts = DynamicalWeb::setMemoryObject(
                "intellivoid_accounts", new IntellivoidAccounts()
            );
        }
        else
        {
            /** @var IntellivoidAccounts $IntellivoidAccounts */
            $IntellivoidAccounts = DynamicalWeb::getMemoryObject("intellivoid_accounts");
        }

        ?>
        <div class="accordion" id="apps-accordion" role="tablist">
            <?PHP
                foreach($application_access_records as $access_record)
                {
                    $ApplicationAccess = ApplicationAccess::fromArray($access_record);
                    if($ApplicationAccess->Status == ApplicationAccessStatus::Authorized)
                    {
                        try
                        {
                            $Application = $IntellivoidAccounts->getApplicationManager()->getApplication(ApplicationSearchMethod::byId, $ApplicationAccess->ApplicationID);
                        }
                        catch (ApplicationNotFoundException $e)
                        {
                            unset($e);
                            continue;
                        }
                        ?>
                        <div class="card accordion-minimal">
                            <div class="card-header" role="tab" id="heading-<?PHP HTML::print($Application->PublicAppId); ?>">
                                <a class="mb-0 d-flex collapsed" data-toggle="collapse" href="#collapse-<?PHP HTML::print($Application->PublicAppId); ?>" aria-expanded="false" aria-controls="collapse-<?PHP HTML::print($Application->PublicAppId); ?>">
                                    <img class="img-xs rounded-circle mt-2" src="<?PHP DynamicalWeb::getRoute('application_icon', array('app_id' => $Application->PublicAppId, 'resource' => 'small'), true); ?>" alt="profile image">
                                    <div class="ml-3">
                                        <h6 class="mb-0">
                                            <?PHP HTML::print($Application->Name); ?>
                                        </h6>
                                        <small class="text-muted"><?PHP HTML::print(str_ireplace('%s', gmdate("j/m/y g:i a", $ApplicationAccess->LastAuthenticatedTimestamp), 'Last Authenticated: %s')); ?></small>
                                    </div>
                                    <div class="ml-auto mr-3 mt-auto mb-auto">
                                        <i class="mdi mdi-account-card-details"></i>
                                        <?PHP
                                            if(in_array(AccountRequestPermissions::ViewEmailAddress ,$ApplicationAccess->Permissions))
                                            {
                                                HTML::print("<i class=\"mdi mdi-email\"></i>", false);
                                            }
                                            if(in_array(AccountRequestPermissions::ReadPersonalInformation ,$ApplicationAccess->Permissions))
                                            {
                                                HTML::print("<i class=\"mdi mdi-account\"></i>", false);
                                            }
                                            if(in_array(AccountRequestPermissions::EditPersonalInformation ,$ApplicationAccess->Permissions))
                                            {
                                                HTML::print("<i class=\"mdi mdi-account-edit\"></i>", false);
                                            }
                                            if(in_array(AccountRequestPermissions::MakePurchases ,$ApplicationAccess->Permissions))
                                            {
                                                HTML::print("<i class=\"mdi mdi-shopping\"></i>", false);
                                            }
                                            if(in_array(AccountRequestPermissions::TelegramNotifications ,$ApplicationAccess->Permissions))
                                            {
                                                HTML::print("<i class=\"mdi mdi-telegram\"></i>", false);
                                            }
                                        ?>

                                    </div>
                                </a>
                            </div>
                            <div id="collapse-<?PHP HTML::print($Application->PublicAppId); ?>" class="collapse" role="tabpanel" aria-labelledby="heading-<?PHP HTML::print($Application->PublicAppId); ?>" data-parent="#apps-accordion">
                                <div class="card-body">
                                    <div class="ml-2 mr-2 row grid-margin d-flex mb-0">
                                        <div class="col-lg-9 mb-2">
                                            <p><?PHP HTML::print(str_ireplace("%s", $Application->Name, "%s has access to")); ?></p>
                                            <div class="d-flex ml-2 align-items-center py-1 pb-2">
                                                <i class="mdi mdi-account-card-details mdi-18px"></i>
                                                <p class="mb-0 ml-3">Your username and avatar</p>
                                            </div>
                                            <?PHP
                                                if(in_array(AccountRequestPermissions::ViewEmailAddress, $ApplicationAccess->Permissions))
                                                {
                                                    ?>
                                                    <div class="d-flex ml-2 align-items-center py-1 pb-2">
                                                        <i class="mdi mdi-email mdi-18px"></i>
                                                        <p class="mb-0 ml-3">View your Email Address</p>
                                                    </div>
                                                    <?PHP
                                                }
                                                if(in_array(AccountRequestPermissions::ReadPersonalInformation, $ApplicationAccess->Permissions))
                                                {
                                                    ?>
                                                    <div class="d-flex ml-2 align-items-center py-1 pb-2">
                                                        <i class="mdi mdi-account mdi-18px"></i>
                                                        <p class="mb-0 ml-3">View your personal information</p>
                                                    </div>
                                                    <?PHP
                                                }
                                                if(in_array(AccountRequestPermissions::EditPersonalInformation, $ApplicationAccess->Permissions))
                                                {
                                                    ?>
                                                    <div class="d-flex ml-2 align-items-center py-1 pb-2">
                                                        <i class="mdi mdi-account-edit mdi-18px"></i>
                                                        <p class="mb-0 ml-3">Edit your personal information</p>
                                                    </div>
                                                    <?PHP
                                                }
                                                if(in_array(AccountRequestPermissions::MakePurchases, $ApplicationAccess->Permissions))
                                                {
                                                    ?>
                                                    <div class="d-flex ml-2 align-items-center py-1 pb-2">
                                                        <i class="mdi mdi-shopping mdi-18px"></i>
                                                        <p class="mb-0 ml-3">Make purchases on your behalf</p>
                                                    </div>
                                                    <?PHP
                                                }
                                                if(in_array(AccountRequestPermissions::TelegramNotifications, $ApplicationAccess->Permissions))
                                                {
                                                    ?>
                                                    <div class="d-flex ml-2 align-items-center py-1 pb-2">
                                                        <i class="mdi mdi-telegram mdi-18px"></i>
                                                        <p class="mb-0 ml-3">Send notifications to you on Telegram</p>
                                                    </div>
                                                    <?PHP
                                                }
                                            ?>

                                        </div>
                                        <div class="col-lg-3 mt-auto mb-2">
                                            <button class="btn btn-block btn-outline-danger" onclick="location.href='<?PHP DynamicalWeb::getRoute('services', array('action' => 'revoke_access', 'access_id' => $ApplicationAccess->PublicID), true); ?>';">Revoke Access</button>
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