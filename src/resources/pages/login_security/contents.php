<?PHP

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
use IntellivoidAccounts\IntellivoidAccounts;
use IntellivoidAccounts\Objects\Account;

    HTML::importScript('check_sudo');
    HTML::importScript('check');
    HTML::importScript('enable_telegram_verification');
    HTML::importScript('disable_mobile_verification');
    HTML::importScript('unlink_telegram');
    HTML::importScript('disable_recovery_codes');

    /** @var Account $Account */
    $Account = DynamicalWeb::getMemoryObject('account');

    /** @var IntellivoidAccounts $IntellivoidAccounts */
    $IntellivoidAccounts = DynamicalWeb::getMemoryObject('intellivoid_accounts');
?>
<!doctype html>
<html lang="<?PHP HTML::print(APP_LANGUAGE_ISO_639); ?>">
    <head>
        <?PHP HTML::importSection('dashboard_headers'); ?>
        <title>Intellivoid Accounts</title>
    </head>

    <body>
        <div class="container-scroller">
            <?PHP HTML::importSection("dashboard_navbar"); ?>
            <div class="container-fluid page-body-wrapper">
                <div class="main-panel container">
                    <div class="content-wrapper">
                        <?PHP HTML::importScript('callbacks'); ?>
                        <div class="row">
                            <div class="col-lg-12 grid-margin stretch-card">
                                <!--weather card-->
                                <div class="card card-weather">
                                    <div class="card-body">
                                        <div class="pt-3">
                                            <h3>Login Security</h3>
                                            <p class="text-gray">
                                                Secure your account even if somebody knows your password
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 grid-margin stretch-card">
                                <div class="card card-statistics social-card card-default">
                                    <div class="card-header header-sm">
                                        <div class="d-flex align-items-center">
                                            <div class="wrapper d-flex align-items-center media-info text-info">
                                                <i class="mdi mdi-cellphone-iphone icon-md"></i>
                                                <h2 class="card-title ml-3">Mobile Verification</h2>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="text-center pb-3">
                                            <?PHP
                                                if($Account->Configuration->VerificationMethods->TwoFactorAuthenticationEnabled)
                                                {
                                                    HTML::print("<div class=\"badge badge-lg badge-outline-success badge-pill\">", false);
                                                    HTML::print("Enabled");
                                                    HTML::print("</div>", false);
                                                }
                                                else
                                                {
                                                    HTML::print("<div class=\"badge badge-lg badge-outline-danger badge-pill\">", false);
                                                    HTML::print("Disabled");
                                                    HTML::print("</div>", false);
                                                }
                                            ?>
                                        </div>
                                        <p class="text-center mb-2 comment">
                                            Using Google Authenticator on your phone, you can enter a time based code
                                            to verify it's you without internet access
                                        </p>
                                        <?PHP
                                            HTML::print("<small class=\"d-block mt-4 text-center posted-date\">", false);
                                            if($Account->Configuration->VerificationMethods->TwoFactorAuthenticationEnabled)
                                            {
                                                $LastUpdated = $Account->Configuration->VerificationMethods->TwoFactorAuthentication->LastUpdated;
                                                HTML::print(str_ireplace("%s", gmdate("F j, Y, g:i a", $LastUpdated), "Last Updated: %s"));
                                            }
                                            else
                                            {
                                                HTML::print(str_ireplace("%s", "Not Activated", "Last Updated: %s"));
                                            }
                                            HTML::print("</small>", false);
                                        ?>
                                    </div>
                                    <div class="card-footer align-content-center d-flex">
                                        <?PHP
                                            if($Account->Configuration->VerificationMethods->TwoFactorAuthenticationEnabled)
                                            {
                                                HTML::print("<button class=\"btn btn-danger btn-block\" data-toggle=\"modal\" data-target=\"#disable-mv\">", false);
                                                HTML::print("Disable");
                                                HTML::print("</button>", false);
                                            }
                                            else
                                            {
                                                $Href = DynamicalWeb::getRoute('setup_mobile_verification');
                                                HTML::print("<button class=\"btn btn-primary btn-block\" onclick=\"location.href='$Href';\">", false);
                                                HTML::print("Setup");
                                                HTML::print("</button>", false);
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="disable-mv" tabindex="-1" role="dialog" aria-labelledby="disable-mv-label" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="disable-mv-label">Dsiable Mobile Verification</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">
                                                    <i class="mdi mdi-close"></i>
                                                </span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>
                                                Please confirm that you want to disable Mobile Verification, this will
                                                not disable the other methods of verification such as Recovery Codes.
                                                Those must be disabled separately
                                            </p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                                            <?PHP $Href = DynamicalWeb::getRoute('login_security', array('action' => 'disable_mv')); ?>
                                            <button type="button" class="btn btn-danger" onclick="location.href='<?PHP HTML::print($Href); ?>';">Disable</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 grid-margin stretch-card">
                                <div class="card card-statistics social-card card-default">
                                    <div class="card-header header-sm">
                                        <div class="d-flex align-items-center">
                                            <div class="wrapper d-flex align-items-center media-info text-primary">
                                                <i class="mdi mdi-reload icon-md"></i>
                                                <h2 class="card-title ml-3">Recovery Codes</h2>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="text-center pb-3">
                                            <?PHP
                                            if($Account->Configuration->VerificationMethods->RecoveryCodesEnabled)
                                            {
                                                HTML::print("<div class=\"badge badge-lg badge-outline-success badge-pill\">", false);
                                                HTML::print("Enabled");
                                                HTML::print("</div>", false);
                                            }
                                            else
                                            {
                                                HTML::print("<div class=\"badge badge-lg badge-outline-danger badge-pill\">", false);
                                                HTML::print("Disabled");
                                                HTML::print("</div>", false);
                                            }
                                            ?>
                                        </div>
                                        <p class="text-center mb-2 comment">
                                            Use one-time use recovery codes to access your account if you do not have access to your phone
                                        </p>
                                        <?PHP
                                            HTML::print("<small class=\"d-block mt-4 text-center posted-date\">", false);
                                            if($Account->Configuration->VerificationMethods->RecoveryCodesEnabled)
                                            {
                                                $LastUpdated = $Account->Configuration->VerificationMethods->RecoveryCodes->LastUpdated;
                                                HTML::print(str_ireplace("%s", gmdate("F j, Y, g:i a", $LastUpdated), "Last Updated: %s"));
                                            }
                                            else
                                            {
                                                HTML::print(str_ireplace("%s", "Not Activated", "Last Updated: %s"));
                                            }
                                            HTML::print("</small>", false);
                                        ?>
                                    </div>
                                    <div class="card-footer align-content-center d-flex">
                                        <?PHP
                                            if($Account->Configuration->VerificationMethods->RecoveryCodesEnabled)
                                            {
                                                if($Account->Configuration->VerificationMethods->TwoFactorAuthenticationEnabled)
                                                {
                                                    HTML::print("<button class=\"btn btn-danger btn-block\" data-toggle=\"modal\" data-target=\"#disable-rc-mv\">", false);
                                                    HTML::print("Disable");
                                                    HTML::print("</button>", false);
                                                }
                                                else
                                                {
                                                    HTML::print("<button class=\"btn btn-danger btn-block\" data-toggle=\"modal\" data-target=\"#disable-rc\">", false);
                                                    HTML::print("Disable");
                                                    HTML::print("</button>", false);
                                                }
                                            }
                                            else
                                            {
                                                $Href = DynamicalWeb::getRoute('setup_recovery_codes');
                                                HTML::print("<button class=\"btn btn-primary btn-block\" onclick=\"location.href='$Href';\">", false);
                                                HTML::print("Setup");
                                                HTML::print("</button>", false);
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="disable-rc-mv" tabindex="-1" role="dialog" aria-labelledby="disable-rc-mv-label" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="disable-rc-mv-label">Disable Recovery Codes</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">
                                                    <i class="mdi mdi-close"></i>
                                                </span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>
                                                Please confirm that you want to disable recovery codes, since you have
                                                Mobile Verification enabled as well, you may risk losing access to your
                                                account  if you lose your device and have no other way to recover your
                                                account. Your old recovery codes will become invalid and you will
                                                no longer be prompted for a recovery code when trying to verify
                                                your login
                                            </p>
                                        </div>
                                        <div class="modal-footer">
                                            <?PHP $Href = DynamicalWeb::getRoute('login_security', array('action' => 'disable_rc')); ?>
                                            <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                                            <button type="button" class="btn btn-danger" onclick="location.href='<?PHP HTML::print($Href); ?>';">Disable</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="disable-rc" tabindex="-1" role="dialog" aria-labelledby="disable-rc-label" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="disable-rc-label">Disable Recovery Codes</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">
                                                    <i class="mdi mdi-close"></i>
                                                </span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>
                                                Please confirm that you want to disable recovery codes. Your old recovery
                                                codes will become invalid and you will  no longer be prompted for a
                                                recovery code when trying to verify  your login
                                            </p>
                                        </div>
                                        <div class="modal-footer">
                                            <?PHP $Href = DynamicalWeb::getRoute('login_security', array('action' => 'disable_rc')); ?>
                                            <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                                            <button type="button" class="btn btn-danger" onclick="location.href='<?PHP HTML::print($Href); ?>';">Disable</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="unlink-telegram" tabindex="-1" role="dialog" aria-labelledby="unlink-telegram-label" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="unlink-telegram-label">Unlink Telegram Account</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">
                                                    <i class="mdi mdi-close"></i>
                                                </span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>
                                                Please confirm that you want to unlink your Telegram Account, you will
                                                no longer receive Authentication Prompts, security notifciations and
                                                application notifications.
                                            </p>
                                        </div>
                                        <div class="modal-footer">
                                            <?PHP $Href = DynamicalWeb::getRoute('login_security', array('action' => 'unlink_telegram')); ?>
                                            <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                                            <button type="button" class="btn btn-danger" onclick="location.href='<?PHP HTML::print($Href); ?>';">Unlink</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 grid-margin stretch-card">
                                <div class="card card-statistics social-card card-default">
                                    <div class="card-header header-sm">
                                        <div class="d-flex align-items-center">
                                            <div class="wrapper d-flex align-items-center media-info text-danger">
                                                <i class="mdi mdi-telegram icon-md"></i>
                                                <h2 class="card-title ml-3">Telegram Verification</h2>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="text-center pb-3">
                                            <?PHP
                                            if($Account->Configuration->VerificationMethods->TelegramClientLinked)
                                            {
                                                HTML::print("<div class=\"badge badge-lg badge-outline-success badge-pill\">", false);
                                                HTML::print("Enabled");
                                                HTML::print("</div>", false);
                                            }
                                            else
                                            {
                                                HTML::print("<div class=\"badge badge-lg badge-outline-danger badge-pill\">", false);
                                                HTML::print("Disabled");
                                                HTML::print("</div>", false);
                                            }
                                            ?>
                                        </div>
                                        <p class="text-center mb-2 comment">
                                            Receive authentication prompts, security updates and notifications on Telegram
                                        </p>
                                        <?PHP
                                            HTML::print("<small class=\"d-block mt-4 text-center posted-date\">", false);
                                            if($Account->Configuration->VerificationMethods->TelegramClientLinked)
                                            {
                                                $LastUpdated = $Account->Configuration->VerificationMethods->TelegramLink->LastLinked;
                                                HTML::print(str_ireplace("%s", gmdate("F j, Y, g:i a", $LastUpdated), "Added on %s"));
                                            }
                                            else
                                            {
                                                HTML::print(str_ireplace("%s", "Not available", "Added on: %s"));
                                            }
                                            HTML::print("</small>", false);
                                        ?>
                                    </div>
                                    <div class="card-footer align-content-center d-flex">
                                        <?PHP
                                        if($Account->Configuration->VerificationMethods->TelegramClientLinked)
                                        {
                                            HTML::print("<button class=\"btn btn-danger btn-block\" data-toggle=\"modal\" data-target=\"#unlink-telegram\">", false);
                                            HTML::print("Unlink Telegram");
                                            HTML::print("</button>", false);
                                        }
                                        else
                                        {
                                            $BotName = $IntellivoidAccounts->getTelegramConfiguration()['TgBotName'];
                                            $Href = DynamicalWeb::getRoute('setup_recovery_codes');
                                            HTML::print("<button class=\"btn btn-primary btn-block\" onclick=\"location.href='tg://resolve?domain=$BotName&start=link'\">", false);
                                            HTML::print("Open Telegram");
                                            HTML::print("</button>", false);
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>

                      </div>


                    </div>
                    <?PHP HTML::importSection('dashboard_footer'); ?>
                </div>
            </div>

        </div>
        <?PHP HTML::importSection('dashboard_js'); ?>
    </body>
</html>
