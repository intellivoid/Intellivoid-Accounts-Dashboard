<?PHP

    /** @noinspection PhpUndefinedConstantInspection */

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use DynamicalWeb\Javascript;
    use DynamicalWeb\Runtime;
    use IntellivoidAccounts\Abstracts\AccountRequestPermissions;
    use IntellivoidAccounts\Abstracts\ApplicationFlags;
    use IntellivoidAccounts\Abstracts\AuthenticationMode;
    use IntellivoidAccounts\Objects\COA\Application;
    use IntellivoidAccounts\Objects\COA\AuthenticationRequest;

    Runtime::import('IntellivoidAccounts');
    HTML::importScript('validate_coa');
    HTML::importScript('process_authentication');
    HTML::importScript('render_alert');

    /** @var Application $Application */
    $Application = DynamicalWeb::getMemoryObject('application');

    /** @var AuthenticationRequest $AuthenticationRequest */
    $AuthenticationRequest = DynamicalWeb::getMemoryObject('auth_request');

    $VerificationToken = hash('sha256', $AuthenticationRequest->CreatedTimestamp . $AuthenticationRequest->RequestToken . $Application->PublicAppId);

    $ReqParameters = array(
        'auth' => 'application',
        'action' => 'authenticate',
        'application_id' => $_GET['application_id'],
        'request_token' => $_GET['request_token'],
        'exp' => $AuthenticationRequest->ExpiresTimestamp,
        'verification_token' => $VerificationToken,
    );

    if($Application->AuthenticationMode == AuthenticationMode::Redirect)
    {
        $ReqParameters['redirect'] = $_GET['redirect'];
    }

    $AuthenticateRoute = DynamicalWeb::getRoute('application_authenticate', $ReqParameters);
?>
<!doctype html>
<html lang="<?PHP HTML::print(APP_LANGUAGE_ISO_639); ?>">
    <head>
        <?PHP HTML::importSection('headers'); ?>
        <link rel="stylesheet" href="/assets/css/extra.css">
        <title><?PHP HTML::print(str_ireplace('%s', $Application->Name, TEXT_PAGE_TITLE)); ?></title>
    </head>
    <body>
        <div class="container-scroller">
            <div class="container-fluid page-body-wrapper full-page-wrapper">
                <div class="content-wrapper d-flex align-items-center auth area theme-one">
                    <?PHP HTML::importSection('background_animations'); ?>
                    <div class="row w-100 mx-auto">
                        <div class="col-lg-5 mx-auto">
                            <div class="linear-activity">
                                <div id="linear-spinner" class="indeterminate-none"></div>
                            </div>
                            <div class="auto-form-wrapper" style="border-radius: 0px; border-bottom-left-radius: 4px; border-bottom-right-radius: 4px;">
                                <div class="mr-auto mb-4">
                                    <img class="img-fluid img-xs" src="/assets/images/iv_logo.svg" alt="iv_logo"/>
                                    <span class="text-dark pl-3"><?PHP HTML::print(TEXT_AUTHENTICATE_CARD_TITLE); ?></span>
                                </div>
                                <div class="d-flex mb-2">
                                    <div class="image-grouped mx-auto d-block">
                                        <img src="<?PHP DynamicalWeb::getRoute('avatar', array('user_id' => WEB_ACCOUNT_PUBID, 'resource' => 'normal'), true) ?>" alt="<?PHP HTML::print(TEXT_USER_IMG_ALT); ?>">
                                        <img src="<?PHP DynamicalWeb::getRoute('application_icon', array('app_id' => $Application->PublicAppId, 'resource' => 'normal'), true) ?>" alt="<?PHP HTML::print(TEXT_APP_IMG_ALT); ?>">
                                    </div>
                                </div>
                                <h4 class="text-center">
                                    <?PHP HTML::print($Application->Name); ?>
                                    <?PHP
                                        if(in_array(ApplicationFlags::Verified, $Application->Flags))
                                        {
                                            HTML::print("<i class=\"mdi mdi-verified text-success\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"" . TEXT_APPLICATION_TICK_VERIFIED . "\"></i>", false);
                                        }
                                        elseif(in_array(ApplicationFlags::Official, $Application->Flags))
                                        {
                                            HTML::print("<i class=\"mdi mdi-verified text-primary\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"" . TEXT_APPLICATION_TICK_OFFICIAL . "\"></i>", false);
                                        }
                                        elseif(in_array(ApplicationFlags::Untrusted, $Application->Flags))
                                        {
                                            HTML::print("<i class=\"mdi mdi-alert text-danger\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"" . TEXT_APPLICATION_TICK_UNTRUSTED . "\"></i>", false);
                                        }
                                    ?>
                                </h4>
                                <div id="callback_alert">
                                    <?PHP
                                        if(in_array(ApplicationFlags::Untrusted, $Application->Flags))
                                        {
                                            RenderAlert(TEXT_APPLICATION_DANGER_ALERT, "danger", "mdi-alert-circle");
                                        }
                                    ?>
                                </div>
                                <div class="border-bottom pt-3"></div>
                                <form id="authentication_form" action="<?PHP HTML::print($AuthenticateRoute, false); ?>" method="POST" name="authentication_form" class="pt-4">
                                    <h6 class="mb-5"><?PHP HTML::print(str_ireplace("%s", $Application->Name, TEXT_PERMISSIONS_REQUEST_HEADER)); ?></h6>
                                    <div class="form-group" data-toggle="tooltip" data-placement="bottom" title="<?PHP HTML::print(TEXT_PERMISSIONS_USERNAME_AVATAR_TOOLTIP); ?>">
                                        <div class="d-flex align-items-center py-1 text-black" >
                                            <span class="mdi mdi-account-card-details"></span>
                                            <p class="mb-0 ml-3"><?PHP HTML::print(TEXT_PERMISSIONS_USERNAME_AVATAR_TEXT); ?></p>
                                        </div>
                                    </div>
                                    <?PHP
                                        if($AuthenticationRequest->has_requested_permission(AccountRequestPermissions::ViewEmailAddress))
                                        {
                                            ?>
                                            <div class="form-group" data-toggle="tooltip" data-placement="bottom" title="<?PHP HTML::print(TEXT_PERMISSIONS_EMAIL_TOOLTIP); ?>">
                                                <div class="d-flex align-items-center py-1 text-black">
                                                    <span class="mdi mdi-email"></span>
                                                    <p class="mb-0 ml-3"><?PHP HTML::print(TEXT_PERMISSIONS_EMAIL_TEXT); ?></p>
                                                    <div class="form-check ml-auto mb-0 mt-0">
                                                        <label class="form-check-label">
                                                            <input type="checkbox" name="view_email" id="view_email" class="form-check-input" checked> <?PHP HTML::print(TEXT_PERMISSIONS_ALLOW_CHECKBOX); ?>
                                                            <i class="input-helper"></i>
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
                                                <div class="d-flex align-items-center py-1 text-black">
                                                    <span class="mdi mdi-account"></span>
                                                    <p class="mb-0 ml-3"><?PHP HTML::print(TEXT_PERMISSIONS_PERSONAL_INFORMATION_TEXT); ?></p>
                                                    <div class="form-check ml-auto mb-0 mt-0">
                                                        <label class="form-check-label">
                                                            <input type="checkbox" name="view_personal_information" id="view_personal_information" class="form-check-input" checked> <?PHP HTML::print(TEXT_PERMISSIONS_ALLOW_CHECKBOX); ?>
                                                            <i class="input-helper"></i>
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
                                                <div class="d-flex align-items-center py-1 text-black">
                                                    <span class="mdi mdi-account-edit"></span>
                                                    <p class="mb-0 ml-3"><?PHP HTML::print(TEXT_PERMISSIONS_EDIT_PERSONAL_INFORMATION_TEXT); ?></p>
                                                    <div class="form-check ml-auto mb-0 mt-0">
                                                        <label class="form-check-label">
                                                            <input type="checkbox" name="edit_personal_information" id="edit_personal_information" class="form-check-input" checked> <?PHP HTML::print(TEXT_PERMISSIONS_ALLOW_CHECKBOX); ?>
                                                            <i class="input-helper"></i>
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
                                                <div class="d-flex align-items-center py-1 text-black">
                                                    <span class="mdi mdi-telegram"></span>
                                                    <p class="mb-0 ml-3"><?PHP HTML::print(TEXT_PERMISSIONS_TELEGRAM_NOTIFICATIONS_TEXT); ?></p>
                                                    <div class="form-check ml-auto mb-0 mt-0">
                                                        <label class="form-check-label">
                                                            <input type="checkbox" name="telegram_notifications" id="telegram_notifications" class="form-check-input" checked> <?PHP HTML::print(TEXT_PERMISSIONS_ALLOW_CHECKBOX); ?>
                                                            <i class="input-helper"></i>
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
                                                <div class="d-flex align-items-center py-1 text-black">
                                                    <span class="mdi mdi-shopping"></span>
                                                    <p class="mb-0 ml-3"><?PHP HTML::print(TEXT_PERMISSIONS_MAKE_PURCHASE_TEXT); ?></p>
                                                </div>
                                            </div>
                                            <?PHP
                                        }
                                    ?>
                                    <div class="form-group pt-4">
                                        <p class="text-muted">
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
                                    <div class="form-group pb-2 mt-5">
                                        <input id="submit_button" type="submit" class="btn btn-primary submit-btn btn-block" onclick="authenticate();" value="<?PHP HTML::print(TEXT_AUTHENTICATION_AUTHENTICATE_BUTTON); ?>" disabled>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?PHP HTML::importSection('js_scripts'); ?>
        <script src="/assets/js/shared/tooltips.js"></script>
        <?PHP Javascript::importScript('autoenable'); ?>
    </body>
</html>
