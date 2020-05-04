<?php

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
use IntellivoidAccounts\Abstracts\AccountRequestPermissions;
use IntellivoidAccounts\Abstracts\ApplicationFlags;
    use IntellivoidAccounts\Objects\COA\Application;
    use IntellivoidAccounts\Objects\COA\AuthenticationRequest;

    $CardStyle = "";
    if(UI_EXPANDED)
    {
        $CardStyle = " style=\"height: calc(100% - 4px); position: fixed; width: 100%; overflow: auto; overflow-x: hidden;\"";
    }

    /** @var Application $Application */
    $Application = DynamicalWeb::getMemoryObject('application');

    /** @var AuthenticationRequest $AuthenticationRequest */
    $AuthenticationRequest = DynamicalWeb::getMemoryObject('auth_request');

    $UsernameSafe = ucfirst(WEB_ACCOUNT_USERNAME);
    if(strlen($UsernameSafe) > 16)
    {
        $UsernameSafe = substr($UsernameSafe, 0 ,16);
        $UsernameSafe .= "...";
    }

    $ApplicationNameSafe = ucfirst($Application->Name);
    if(strlen($ApplicationNameSafe) > 16)
    {
        $ApplicationNameSafe = substr($ApplicationNameSafe, 0 ,16);
        $ApplicationNameSafe .= "...";
    }
?>
<div class="linear-activity">
    <div id="linear-spinner" class="indeterminate"></div>
</div>
<div class="card rounded-0 mb-0"<?php HTML::print($CardStyle, false); ?>>
    <div class="card-header pt-50 pb-0 mb-0 mx-2 mt-2">
        <div class="card-title">
            <img src="/assets/images/logo_2.svg" alt="Intellivoid Accounts Brand" style="width: 130px; height: 30px;" class="img-fluid mb-2">
        </div>
    </div>
    <div class="card-content p-2 pt-0">
        <div class="card-body pt-0">
            <div class="d-flex mb-1">
                <div class="image-grouped mx-auto d-block">
                    <ul class="list-unstyled users-list d-flex">
                        <li data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" data-original-title="<?PHP HTML::print($UsernameSafe); ?>" class="avatar ml-0">
                            <img class="media-object rounded-circle" src="<?PHP DynamicalWeb::getRoute('avatar', array('user_id' => WEB_ACCOUNT_PUBID, 'resource' => 'original'), true) ?>" alt="<?PHP HTML::print(TEXT_USER_IMG_ALT); ?>" height="64" width="64">
                        </li>
                        <li data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" data-original-title="<?PHP HTML::print($ApplicationNameSafe); ?>" class="avatar">
                            <img class="media-object rounded-circle" src="<?PHP DynamicalWeb::getRoute('application_icon', array('app_id' => $Application->PublicAppId, 'resource' => 'normal'), true) ?>" alt="<?PHP HTML::print(TEXT_APP_IMG_ALT); ?>" height="64" width="64">
                        </li>
                    </ul>
                </div>
            </div>
            <h4 class="text-center">
                <?PHP HTML::print($Application->Name); ?>
                <?PHP
                if(in_array(ApplicationFlags::Verified, $Application->Flags))
                {
                    HTML::print("<i class=\"feather icon-shield text-success\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"" . TEXT_APPLICATION_TICK_VERIFIED . "\"></i>", false);
                }
                elseif(in_array(ApplicationFlags::Official, $Application->Flags))
                {
                    HTML::print("<i class=\"feather icon-shield text-primary\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"" . TEXT_APPLICATION_TICK_OFFICIAL . "\"></i>", false);
                }
                elseif(in_array(ApplicationFlags::Untrusted, $Application->Flags))
                {
                    HTML::print("<i class=\"feather icon-alert-octagon text-danger\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"" . TEXT_APPLICATION_TICK_UNTRUSTED . "\"></i>", false);
                }
                ?>
            </h4>
            <div id="callback_alert">
                <?PHP
                if(in_array(ApplicationFlags::Untrusted, $Application->Flags))
                {
                    RenderAlert(TEXT_APPLICATION_DANGER_ALERT, "danger", "icon-alert-circle");
                }
                ?>
            </div>
            <form class="mt-4" id="authentication_form" action="<?PHP HTML::print(DynamicalWeb::getString('authenticate_route'), false); ?>" method="POST" name="authentication_form">
                <h6 class="mb-2"><?PHP HTML::print(str_ireplace("%s", $Application->Name, TEXT_PERMISSIONS_REQUEST_HEADER)); ?></h6>
                <div class="form-group" data-toggle="tooltip" data-placement="bottom" title="<?PHP HTML::print(TEXT_PERMISSIONS_USERNAME_AVATAR_TOOLTIP); ?>">
                    <div class="d-flex align-items-center py-0 text-black" >
                        <span class="feather icon-user"></span>
                        <p class="mb-0 ml-1"><?PHP HTML::print(TEXT_PERMISSIONS_USERNAME_AVATAR_TEXT); ?></p>
                    </div>
                </div>
                <?PHP

                    if($AuthenticationRequest->has_requested_permission(AccountRequestPermissions::ViewEmailAddress))
                    {
                        ?>
                        <div class="form-group" data-toggle="tooltip" data-placement="bottom" title="<?PHP HTML::print(TEXT_PERMISSIONS_EMAIL_TOOLTIP); ?>">
                            <div class="d-flex align-items-center py-0">
                                <span class="feather icon-mail"></span>
                                <span class="mb-0 ml-1"><?PHP HTML::print(TEXT_PERMISSIONS_EMAIL_TEXT); ?></span>
                                <div class="vs-checkbox-con vs-checkbox-primary ml-auto mb-0 mt-0">
                                    <input name="view_email" id="view_email" type="checkbox" checked value="false">
                                    <span class="vs-checkbox">
                                        <span class="vs-checkbox--check">
                                            <i class="vs-icon feather icon-check"></i>
                                        </span>
                                    </span>
                                    <label for="view_email">
                                        <?PHP HTML::print(TEXT_PERMISSIONS_ALLOW_CHECKBOX); ?>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <?PHP
                    }

                    if(in_array(AccountRequestPermissions::ReadPersonalInformation, $AuthenticationRequest->RequestedPermissions))
                    {
                        ?>
                        <div class="form-group" data-toggle="tooltip" data-placement="bottom" title="<?PHP HTML::print(TEXT_PERMISSIONS_PERSONAL_INFORMATION_TOOLTIP); ?>">
                            <div class="d-flex align-items-center py-0 text-black">
                                <span class="feather icon-eye"></span>
                                <span class="mb-0 ml-1"><?PHP HTML::print(TEXT_PERMISSIONS_PERSONAL_INFORMATION_TEXT); ?></span>

                                <div class="vs-checkbox-con vs-checkbox-primary ml-auto mb-0 mt-0">
                                    <input name="view_personal_information" id="view_personal_information" type="checkbox" checked value="false">
                                    <span class="vs-checkbox">
                                        <span class="vs-checkbox--check">
                                            <i class="vs-icon feather icon-check"></i>
                                        </span>
                                    </span>
                                    <label for="view_personal_information">
                                        <?PHP HTML::print(TEXT_PERMISSIONS_ALLOW_CHECKBOX); ?>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <?PHP
                    }

                    if(in_array(AccountRequestPermissions::EditPersonalInformation, $AuthenticationRequest->RequestedPermissions))
                    {
                        ?>
                        <div class="form-group" data-toggle="tooltip" data-placement="bottom" title="<?PHP HTML::print(TEXT_PERMISSIONS_EDIT_PERSONAL_INFORMATION_TOOLTIP); ?>">
                            <div class="d-flex align-items-center py-0 text-black">
                                <span class="feather icon-edit-2"></span>
                                <p class="mb-0 ml-1"><?PHP HTML::print(TEXT_PERMISSIONS_EDIT_PERSONAL_INFORMATION_TEXT); ?></p>
                                <div class="vs-checkbox-con vs-checkbox-primary ml-auto mb-0 mt-0">
                                    <input name="edit_personal_information" id="edit_personal_information" type="checkbox" checked value="false">
                                    <span class="vs-checkbox">
                                        <span class="vs-checkbox--check">
                                            <i class="vs-icon feather icon-check"></i>
                                        </span>
                                    </span>
                                    <label for="edit_personal_information">
                                        <?PHP HTML::print(TEXT_PERMISSIONS_ALLOW_CHECKBOX); ?>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <?PHP
                    }

                    if(in_array(AccountRequestPermissions::TelegramNotifications, $AuthenticationRequest->RequestedPermissions))
                    {
                        ?>
                        <div class="form-group" data-toggle="tooltip" data-placement="bottom" title="<?PHP HTML::print(TEXT_PERMISSIONS_TELEGRAM_NOTIFICATIONS_TOOLTIP); ?>">
                            <div class="d-flex align-items-center py-0 text-black">
                                <span class="feather icon-message-square"></span>
                                <p class="mb-0 ml-1"><?PHP HTML::print(TEXT_PERMISSIONS_TELEGRAM_NOTIFICATIONS_TEXT); ?></p>
                                <div class="vs-checkbox-con vs-checkbox-primary ml-auto mb-0 mt-0">
                                    <input name="telegram_notifications" id="telegram_notifications" type="checkbox" checked value="false">
                                    <span class="vs-checkbox">
                                        <span class="vs-checkbox--check">
                                            <i class="vs-icon feather icon-check"></i>
                                        </span>
                                    </span>
                                    <label for="telegram_notifications">
                                        <?PHP HTML::print(TEXT_PERMISSIONS_ALLOW_CHECKBOX); ?>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <?PHP
                    }

                    if(in_array(AccountRequestPermissions::MakePurchases, $AuthenticationRequest->RequestedPermissions))
                    {
                        ?>
                        <div class="form-group" data-toggle="tooltip" data-placement="bottom" title="<?PHP HTML::print(TEXT_PERMISSIONS_MAKE_PURCHASES_TOOLTIP); ?>">
                            <div class="d-flex align-items-center py-0 text-black">
                                <span class="feather icon-shopping-cart"></span>
                                <p class="mb-0 ml-1"><?PHP HTML::print(TEXT_PERMISSIONS_MAKE_PURCHASE_TEXT); ?></p>
                            </div>
                        </div>
                        <?PHP
                    }
                ?>
                <div class="form-group pt-2">
                    <p class="text-muted font-small-3">
                        <?PHP
                        if(in_array(ApplicationFlags::Official, $Application->Flags))
                        {
                            HTML::print(str_ireplace("%s", $Application->Name, TEXT_AUTHENTICATION_NOTICE_OFFICIAL));
                        }
                        elseif(in_array(ApplicationFlags::Verified, $Application->Flags))
                        {
                            HTML::print(str_ireplace("%s", $Application->Name, TEXT_AUTHENTICATION_NOTICE_VERIFIED));
                        }
                        else
                        {
                            HTML::print(str_ireplace("%s", $Application->Name, TEXT_AUTHENTICATION_NOTICE_GENERIC));
                        }
                        ?>
                    </p>
                </div>

                <button type="submit" id="submit_button" class="btn btn-primary waves-effect waves-light btn-block" onclick="authenticate();" disabled>
                    <span id="submit_label" hidden><?PHP HTML::print(TEXT_AUTHENTICATION_AUTHENTICATE_BUTTON); ?></span>
                    <span id="submit_preloader" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                </button>
            </form>
        </div>
    </div>
    <div class="card-footer<?PHP if(UI_EXPANDED){ HTML::print(" mt-auto"); } ?>">
        <?PHP HTML::importSection('authentication_footer'); ?>
    </div>
</div>