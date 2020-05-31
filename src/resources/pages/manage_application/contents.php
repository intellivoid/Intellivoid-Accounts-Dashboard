<?php

    /** @noinspection PhpUndefinedConstantInspection */

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
                case 'update_app_logo':
                    HTML::importScript('change_logo');
                    break;

                case 'update_auth_mode':
                    HTML::importScript('update_authentication_mode');
                    break;

                case 'update_secret_key':
                    HTML::importScript('update_secret_key');
                    break;

                case 'update_permissions':
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
                case 'disable_application':
                    HTML::importScript('disable_application');
                    break;

                case 'enable_application':
                    HTML::importScript('enable_application');
                    break;

                case 'delete_application':
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
<!DOCTYPE html>
<html class="loading" lang="<?PHP HTML::print(APP_LANGUAGE_ISO_639); ?>" data-textdirection="ltr">
    <head>
        <?PHP HTML::importSection('main_headers'); ?>
        <title><?PHP HTML::print(str_ireplace('%s', $Application->Name, TEXT_PAGE_TITLE)); ?></title>
    </head>
    <body class="horizontal-layout horizontal-menu 2-columns navbar-sticky fixed-footer" data-open="hover" data-menu="horizontal-menu" data-col="2-columns">

        <?PHP HTML::importSection('main_bhelper'); ?>
        <?PHP HTML::importSection('main_nav'); ?>
        <?PHP HTML::importSection('main_horizontal_menu'); ?>

        <div class="app-content content mb-0">
            <?PHP HTML::importSection('main_chelper'); ?>
            <div class="content-wrapper">
                <?PHP
                    HTML::importScript('callbacks');

                    if($Suspended)
                    {
                        RenderAlert(TEXT_APPLICATION_SUSPENDED_MESSAGE, "warning", "icon-alert-triangle");
                    }
                ?>
                <div class="content-body">
                    <div class="row">
                        <div class="col-12 col-xl-4">
                            <div class="card">
                                <div class="card-body">
                                    <form action="<?PHP DynamicalWeb::getRoute('manage_application', array('pub_id' => $Application->PublicAppId, 'action' => 'update_app_logo'), true); ?>" method="POST" enctype="multipart/form-data">
                                        <div class="d-flex align-items-start pb-1 border-bottom">
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
                                            <div class="avatar mr-75">
                                                <img src="<?PHP DynamicalWeb::getRoute('application_icon', $img_parameters, true); ?>" alt="<?PHP HTML::print($Application->Name); ?>" height="64" width="64">
                                            </div>
                                            <div class="wrapper ml-1 my-auto">
                                                <h3 class="mb-0"><?PHP HTML::print($Application->Name); ?></h3>
                                                <label class="btn btn-primary btn-sm mt-75" for="file-selector" onchange="this.form.submit();">
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
                                            <button class="btn btn-block bg-gradient-danger mt-1" onclick="location.href='<?PHP DynamicalWeb::getRoute('manage_application', array('pub_id' => $Application->PublicAppId, 'action' => 'disable_application'), true); ?>'"><?PHP HTML::print(TEXT_DISABLE_APPLICATION_BUTTON); ?></button>
                                            <?PHP
                                            break;

                                        case ApplicationStatus::Disabled:
                                            ?>
                                            <button class="btn btn-block bg-gradient-success mt-1" onclick="location.href='<?PHP DynamicalWeb::getRoute('manage_application', array('pub_id' => $Application->PublicAppId, 'action' => 'enable_application'), true); ?>'"><?PHP HTML::print(TEXT_ENABLE_APPLICATION_BUTTON); ?></button>
                                            <?PHP
                                            break;

                                        case ApplicationStatus::Suspended:
                                            ?>
                                            <button class="btn btn-block btn-outline-warning disabled mt-1" disabled><?PHP HTML::print(TEXT_APPLICATION_SUSPENDED_BUTTON); ?></button>
                                            <?PHP
                                            break;
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-xl-8 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title pb-2"><?PHP HTML::print(TEXT_APPLICATION_KEYS_HEADER); ?></h4>
                                    <form class="border-bottom" method="POST" action="<?PHP DynamicalWeb::getRoute('manage_application', array('pub_id' => $Application->PublicAppId, 'action' => 'update_secret_key'), true) ?>">

                                        <label for="public_app_id"><?PHP HTML::print(TEXT_APPLICATION_KEYS_PUBLIC_APPLICATION_ID_LABEL); ?></label>
                                        <fieldset class="form-group position-relative has-icon-left">
                                            <input type="text" id="public_app_id" name="public_app_id" class="form-control bg-white" data-toggle="tooltip" data-placement="bottom" title="<?PHP HTML::print(TEXT_APPLICATION_KEYS_PUBLIC_APPLICATION_ID_TOOLTIP); ?>" value="<?PHP HTML::print($Application->PublicAppId); ?>" readonly>
                                            <div class="form-control-position">
                                                <i class="feather icon-unlock"></i>
                                            </div>
                                        </fieldset>

                                        <fieldset>
                                            <label for="app_secret_key"><?PHP HTML::print(TEXT_APPLICATION_KEYS_SECRET_KEY_LABEL); ?></label>
                                            <div class="input-group">
                                                <input type="text" name="app_secret_key" id="app_secret_key" data-toggle="tooltip" data-placement="bottom" title="<?PHP HTML::print(TEXT_APPLICATION_KEYS_SECRET_KEY_TOOLTIP); ?>" class="form-control bg-white" value="<?PHP HTML::print($Application->SecretKey); ?>" readonly>
                                                <div class="input-group-append" id="button-addon2">
                                                    <button class="btn btn-primary waves-effect waves-light" type="submit"<?PHP if($Suspended == true){ HTML::print(" disabled"); } ?>>
                                                        <i class="feather icon-refresh-cw"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </form>
                                </div>

                                <div class="card-body">
                                    <h4 class="card-title pb-2"><?PHP HTML::print(TEXT_SETTINGS_HEADER); ?></h4>
                                    <form action="<?PHP DynamicalWeb::getRoute('manage_application', array('pub_id' => $Application->PublicAppId, 'action' => 'update_auth_mode'), true); ?>" method="POST">
                                        <div class="form-group">
                                            <label for="authentication_type"><?PHP HTML::print(TEXT_AUTHENTICATION_TYPE_LABEL); ?></label>
                                            <select class="form-control" name="authentication_type" id="authentication_type" onchange="this.form.submit();"<?PHP if($Suspended == true){ HTML::print(" disabled"); } ?>>
                                                <option value="redirect"<?PHP if($Application->AuthenticationMode == AuthenticationMode::Redirect){ HTML::print(" selected", false); } ?>><?PHP HTML::print(TEXT_AUTHENTICATION_TYPE_REDIRECT); ?></option>
                                                <option value="placeholder"<?PHP if($Application->AuthenticationMode == AuthenticationMode::ApplicationPlaceholder){ HTML::print(" selected", false); } ?>><?PHP HTML::print(TEXT_AUTHENTICATION_TYPE_PLACEHOLDER); ?></option>
                                                <option value="code"<?PHP if($Application->AuthenticationMode == AuthenticationMode::Code){ HTML::print(" selected", false); } ?>><?PHP HTML::print(TEXT_AUTHENTICATION_TYPE_CODE); ?></option>
                                            </select>
                                        </div>
                                    </form>
                                    <form class="form-group pt-2 mb-0" id="permissions-form" action="<?PHP DynamicalWeb::getRoute('manage_application', array('pub_id' => $Application->PublicAppId, 'action' => 'update_permissions'), true); ?>" method="POST">
                                        <h4 class="card-title pb-2"><?PHP HTML::print(TEXT_PERMISSIONS_HEADER); ?></h4>
                                        <div class="row">
                                            <div class="col-md-6">


                                                <fieldset>
                                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                                        <input type="checkbox" name="perm_view_email_address" id="perm_view_email_address" <?PHP if($Application->has_permission(AccountRequestPermissions::ViewEmailAddress)){HTML::print(' checked'); } ?><?PHP if($Suspended == true){ HTML::print(" disabled"); } ?>>
                                                        <span class="vs-checkbox">
                                                            <span class="vs-checkbox--check">
                                                                <i class="vs-icon feather icon-check"></i>
                                                            </span>
                                                        </span>
                                                        <label for="perm_view_email_address" class="font-medium-1"><?PHP HTML::print(TEXT_PERMISSIONS_VIEW_EMAIL_ADDRESS_LABEL); ?></label>
                                                    </div>
                                                </fieldset>
                                                <p class="text-muted font-small-3 pb-1"><?PHP HTML::print(TEXT_PERMISSIONS_VIEW_EMAIL_ADDRESS_TEXT); ?></p>


                                                <fieldset>
                                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                                        <input type="checkbox" name="perm_telegram_notifications" id="perm_telegram_notifications"<?PHP if(in_array(AccountRequestPermissions::TelegramNotifications, $Application->Permissions)){HTML::print(' checked'); } ?><?PHP if($Suspended == true){ HTML::print(" disabled"); } ?>>
                                                        <span class="vs-checkbox">
                                                            <span class="vs-checkbox--check">
                                                                <i class="vs-icon feather icon-check"></i>
                                                            </span>
                                                        </span>
                                                        <label for="perm_telegram_notifications" class="font-medium-1"><?PHP HTML::print(TEXT_PERMISSIONS_TELEGRAM_NOTIFICATIONS_LABEL); ?></label>
                                                    </div>
                                                </fieldset>
                                                <p class="text-muted font-small-3"><?PHP HTML::print(TEXT_PERMISSIONS_TELEGRAM_NOTIFICATIONS_TEXT); ?></p>

                                            </div>
                                            <div class="col-md-6">


                                                <fieldset>
                                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                                        <input type="checkbox" name="perm_view_personal_information" id="perm_view_personal_information"<?PHP if(in_array(AccountRequestPermissions::ReadPersonalInformation, $Application->Permissions)){HTML::print(' checked'); } ?><?PHP if($Suspended == true){ HTML::print(" disabled"); } ?>>
                                                        <span class="vs-checkbox">
                                                            <span class="vs-checkbox--check">
                                                                <i class="vs-icon feather icon-check"></i>
                                                            </span>
                                                        </span>
                                                        <label for="perm_view_personal_information" class="font-medium-1"><?PHP HTML::print(TEXT_PERMISSIONS_VIEW_PERSONAL_INFORMATION_LABEL); ?></label>
                                                    </div>
                                                </fieldset>
                                                <p class="text-muted font-small-3"><?PHP HTML::print(TEXT_PERMISSIONS_VIEW_PERSONAL_INFORMATION_TEXT); ?></p>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer">
                                    <div class="row align-items-center">
                                        <button class="btn bg-gradient-danger ml-auto mr-2" data-toggle="modal" data-target="#delete-application"<?PHP if($Suspended == true){ HTML::print(" disabled"); } ?>><?PHP HTML::print(TEXT_DELETE_APPLICATION_BUTTON); ?></button>
                                        <button class="btn bg-gradient-primary mr-2<?PHP if($Suspended == true){ HTML::print(" disabled"); } ?>" onclick="$('#permissions-form').submit();"<?PHP if($Suspended == true){ HTML::print(" disabled"); } ?>><?PHP HTML::print(TEXT_SAVE_CHANGES_BUTTON); ?></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?PHP HTML::importScript('dialog.delete_application'); ?>
        </div>

        <?PHP HTML::importSection('main_ehelper'); ?>
        <?PHP HTML::importSection('main_footer'); ?>
        <?PHP HTML::importSection('main_js'); ?>

    </body>
</html>