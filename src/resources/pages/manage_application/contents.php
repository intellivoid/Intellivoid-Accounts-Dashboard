<?PHP

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
use IntellivoidAccounts\Abstracts\AccountRequestPermissions;
use IntellivoidAccounts\Abstracts\ApplicationStatus;
use IntellivoidAccounts\Abstracts\AuthenticationMode;
use IntellivoidAccounts\IntellivoidAccounts;
    use IntellivoidAccounts\Objects\COA\Application;

    HTML::importScript('render_alert');
    HTML::importScript('check_application');

    /** @var Application $Application */
    $Application = DynamicalWeb::getMemoryObject('application');

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        if(isset($_GET['action']))
        {
            switch($_GET['action'])
            {
                case 'change-logo':
                   HTML::importScript('change_logo');
                   break;

                case 'update-auth-mode':
                    HTML::importScript('update_authentication_mode');
                    break;

                case 'update-secret-key':
                    HTML::importScript('update_secret_key');
                    break;

                case 'update-permissions':
                    HTML::importScript('update_permissions');
                    break;
            }
        }
    }
    else
    {
        if(isset($_GET['action']))
        {
            switch($_GET['action'])
            {
                case 'disable-application':
                    HTML::importScript('disable_application');
                    break;

                case 'enable-application':
                    HTML::importScript('enable_application');
                    break;

                case 'delete-application':
                    HTML::importScript('delete_application');
                    break;
            }
        }
    }

    $Suspended = false;

    if($Application->Status == ApplicationStatus::Suspended)
    {
        $Suspended = true;
    }

?>
<!doctype html>
<html lang="<?PHP HTML::print(APP_LANGUAGE_ISO_639); ?>">
    <head>
        <?PHP HTML::importSection('dashboard_headers'); ?>
        <title><?PHP HTML::print(str_ireplace('%s', $Application->Name, TEXT_PAGE_TITLE)); ?></title>
    </head>
    <body>
        <div class="container-scroller">
            <?PHP HTML::importSection("dashboard_navbar"); ?>
            <div class="container-fluid page-body-wrapper">
                <div class="main-panel container">
                    <div class="content-wrapper">
                        <?PHP HTML::importScript('callbacks'); ?>
                        <?PHP
                            if($Suspended)
                            {
                                RenderAlert(TEXT_APPLICATION_SUSPENDED_MESSAGE, "warning", "mdi-alert-circle");
                            }
                        ?>
                        <div class="row">
                            <div class="col-md-4 d-flex align-items-stretch">
                                <div class="row flex-grow">
                                    <div class="col-12 grid-margin">
                                        <div class="card">
                                            <div class="card-body">
                                                <form action="<?PHP DynamicalWeb::getRoute('manage_application', array('pub_id' => $Application->PublicAppId, 'action' => 'change-logo'), true); ?>" method="POST" enctype="multipart/form-data">
                                                    <div class="d-flex align-items-start pb-3 border-bottom">
                                                        <?PHP
                                                            $img_parameters = array('app_id' => $Application->PublicAppId, 'resource' => 'small');
                                                            if(isset($_GET['cache_refresh']))
                                                            {
                                                                if($_GET['cache_refresh'] == 'true')
                                                                {
                                                                    $img_parameters = array('app_id' => $Application->PublicAppId, 'resource' => 'small', 'cache_refresh' => hash('sha256', time() . 'CACHE'));
                                                                }
                                                            }
                                                        ?>
                                                        <img class="img-md" src="<?PHP DynamicalWeb::getRoute('application_icon', $img_parameters, true); ?>" alt="brand logo">
                                                        <div class="wrapper pl-4">
                                                            <p class="font-weight-bold mb-0"><?PHP HTML::print($Application->Name); ?></p>
                                                            <label class="btn btn-inverse-light btn-xs mt-2" for="file-selector" onchange="this.form.submit();">
                                                                <input id="file-selector" name="user_av_file" type="file" class="d-none"> <?PHP HTML::print(TEXT_CHANGE_LOGO_BUTTON); ?>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </form>
                                                <?PHP
                                                    switch($Application->Status)
                                                    {
                                                        case ApplicationStatus::Active:
                                                            ?>
                                                            <button class="btn btn-block btn-danger mt-4" onclick="location.href='<?PHP DynamicalWeb::getRoute('manage_application', array('pub_id' => $Application->PublicAppId, 'action' => 'disable-application'), true); ?>'"><?PHP HTML::print(TEXT_DISABLE_APPLICATION_BUTTON); ?></button>
                                                            <?PHP
                                                            break;

                                                        case ApplicationStatus::Disabled:
                                                            ?>
                                                            <button class="btn btn-block btn-success mt-4" onclick="location.href='<?PHP DynamicalWeb::getRoute('manage_application', array('pub_id' => $Application->PublicAppId, 'action' => 'enable-application'), true); ?>'"><?PHP HTML::print(TEXT_ENABLE_APPLICATION_BUTTON); ?></button>
                                                            <?PHP
                                                            break;

                                                        case ApplicationStatus::Suspended:
                                                            ?>
                                                            <button class="btn btn-block btn-outline-warning disabled mt-4" disabled><?PHP HTML::print(TEXT_APPLICATION_SUSPENDED_BUTTON); ?></button>
                                                            <?PHP
                                                            break;
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title text-muted"><?PHP HTML::print(TEXT_APPLICATION_KEYS_HEADER); ?></h4>
                                        <form class="border-bottom" method="POST" action="<?PHP DynamicalWeb::getRoute('manage_application', array('pub_id' => $Application->PublicAppId, 'action' => 'update-secret-key'), true) ?>">
                                            <div class="form-group pb-3">
                                                <label for="public_app_id"><?PHP HTML::print(TEXT_APPLICATION_KEYS_PUBLIC_APPLICATION_ID_LABEL); ?></label>
                                                <input type="text" class="form-control bg-white" id="public_app_id" data-toggle="tooltip" data-placement="bottom" title="<?PHP HTML::print(TEXT_APPLICATION_KEYS_PUBLIC_APPLICATION_ID_TOOLTIP); ?>" value="<?PHP HTML::print($Application->PublicAppId); ?>" aria-readonly="true" readonly>
                                            </div>
                                            <div class="form-group pb-3">
                                                <label for="app_secret_key"><?PHP HTML::print(TEXT_APPLICATION_KEYS_SECRET_KEY_LABEL); ?></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control border-danger bg-white" id="app_secret_key" data-toggle="tooltip" data-placement="bottom" title="<?PHP HTML::print(TEXT_APPLICATION_KEYS_SECRET_KEY_TOOLTIP); ?>" value="<?PHP HTML::print($Application->SecretKey); ?>" aria-readonly="true" readonly>
                                                    <div class="input-group-append">
                                                        <button class="input-group-btn btn btn-light border-danger"<?PHP if($Suspended == true){ HTML::print(" disabled"); } ?>>
                                                            <i class="mdi mdi-reload"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-body">
                                        <h4 class="card-title text-muted"><?PHP HTML::print(TEXT_SETTINGS_HEADER); ?></h4>
                                        <form action="<?PHP DynamicalWeb::getRoute('manage_application', array('pub_id' => $Application->PublicAppId, 'action' => 'update-auth-mode'), true); ?>" method="POST">
                                            <div class="form-group">
                                                <label for="authentication_type"><?PHP HTML::print(TEXT_AUTHENTICATION_TYPE_LABEL); ?></label>
                                                <select class="form-control" name="authentication_type" id="authentication_type" onchange="this.form.submit();"<?PHP if($Suspended == true){ HTML::print(" disabled"); } ?>>
                                                    <option value="redirect"<?PHP if($Application->AuthenticationMode == AuthenticationMode::Redirect){ HTML::print(" selected", false); } ?>><?PHP HTML::print(TEXT_AUTHENTICATION_TYPE_REDIRECT); ?></option>
                                                    <option value="placeholder"<?PHP if($Application->AuthenticationMode == AuthenticationMode::ApplicationPlaceholder){ HTML::print(" selected", false); } ?>><?PHP HTML::print(TEXT_AUTHENTICATION_TYPE_PLACEHOLDER); ?></option>
                                                    <option value="code"<?PHP if($Application->AuthenticationMode == AuthenticationMode::Code){ HTML::print(" selected", false); } ?>><?PHP HTML::print(TEXT_AUTHENTICATION_TYPE_CODE); ?></option>
                                                </select>
                                            </div>
                                        </form>
                                        <form class="form-group pt-2" id="permissions-form" action="<?PHP DynamicalWeb::getRoute('manage_application', array('pub_id' => $Application->PublicAppId, 'action' => 'update-permissions'), true); ?>" method="POST">
                                            <label><?PHP HTML::print(TEXT_PERMISSIONS_HEADER); ?></label>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input type="checkbox" name="perm_view_email_address" id="perm_view_email_address" class="form-check-input"<?PHP if($Application->has_permission(AccountRequestPermissions::ViewEmailAddress)){HTML::print(' checked'); } ?><?PHP if($Suspended == true){ HTML::print(" disabled"); } ?>><?PHP HTML::print(TEXT_PERMISSIONS_VIEW_EMAIL_ADDRESS); ?>
                                                            <i class="input-helper"></i>
                                                        </label>
                                                    </div>
                                                    <p class="text-muted text-small"><?PHP HTML::print(TEXT_PERMISSIONS_VIEW_EMAIL_ADDRESS_TEXT); ?></p>
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input type="checkbox" name="perm_telegram_notifications" id="perm_telegram_notifications" class="form-check-input"<?PHP if(in_array(AccountRequestPermissions::TelegramNotifications, $Application->Permissions)){HTML::print(' checked'); } ?><?PHP if($Suspended == true){ HTML::print(" disabled"); } ?>><?PHP HTML::print(TEXT_PERMISSIONS_TELEGRAM_NOTIFICATIONS_LABEL); ?>
                                                            <i class="input-helper"></i>
                                                        </label>
                                                    </div>
                                                    <p class="text-muted text-small"><?PHP HTML::print(TEXT_PERMISSIONS_TELEGRAM_NOTIFICATIONS_TEXT); ?></p>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input type="checkbox" name="perm_view_personal_information" class="form-check-input"<?PHP if(in_array(AccountRequestPermissions::ReadPersonalInformation, $Application->Permissions)){HTML::print(' checked'); } ?><?PHP if($Suspended == true){ HTML::print(" disabled"); } ?>><?PHP HTML::print(TEXT_PERMISSIONS_VIEW_PERSONAL_INFORMATION_LABEL); ?>
                                                            <i class="input-helper"></i>
                                                        </label>
                                                    </div>
                                                    <p class="text-muted text-small"><?PHP HTML::print(TEXT_PERMISSIONS_VIEW_PERSONAL_INFORMATION_TEXT); ?></p>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer">
                                        <div class="row align-items-center">
                                            <button class="btn btn-danger ml-auto mr-2" data-toggle="modal" data-target="#delete-application"<?PHP if($Suspended == true){ HTML::print(" disabled"); } ?>><?PHP HTML::print(TEXT_DELETE_APPLICATION_BUTTON); ?></button>
                                            <button class="btn btn-success mr-2<?PHP if($Suspended == true){ HTML::print(" disabled"); } ?>" onclick="$('#permissions-form').submit();"<?PHP if($Suspended == true){ HTML::print(" disabled"); } ?>><?PHP HTML::print(TEXT_SAVE_CHANGES_BUTTON); ?></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?PHP HTML::importScript('dialog.delete_application'); ?>
                    <?PHP HTML::importSection('dashboard_footer'); ?>
                </div>
            </div>
        </div>
        <?PHP HTML::importSection('dashboard_js'); ?>
        <script src="/assets/js/shared/tooltips.js"></script>
    </body>
</html>
