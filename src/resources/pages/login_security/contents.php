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
        <title><?PHP HTML::print(TEXT_PAGE_TITLE); ?></title>
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
                                <div class="card card-weather">
                                    <div class="card-body">
                                        <div class="pt-3">
                                            <h3 class="text-white"><?PHP HTML::print(TEXT_BANNER_HEADER); ?></h3>
                                            <p class="text-white"><?PHP HTML::print(TEXT_BANNER_SUB_HEADER); ?></p>
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
                                            <div class="wrapper d-flex align-items-center media-info text-primary">
                                                <i class="mdi mdi-cellphone-iphone icon-md"></i>
                                                <h2 class="card-title ml-3"><?PHP HTML::print(TEXT_CARD_MOBILE_VERIFICATION_HEADER); ?></h2>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="text-center pb-3">
                                            <?PHP
                                                if($Account->Configuration->VerificationMethods->TwoFactorAuthenticationEnabled)
                                                {
                                                    HTML::print("<div class=\"badge badge-lg badge-outline-success badge-pill\">", false);
                                                    HTML::print(TEXT_STATE_ENABLED);
                                                    HTML::print("</div>", false);
                                                }
                                                else
                                                {
                                                    HTML::print("<div class=\"badge badge-lg badge-outline-danger badge-pill\">", false);
                                                    HTML::print(TEXT_STATE_DISABLED);
                                                    HTML::print("</div>", false);
                                                }
                                            ?>
                                        </div>
                                        <p class="text-center mb-2 comment"><?PHP HTML::print(TEXT_CARD_MOBILE_VERIFICATION_DESCRIPTION); ?></p>
                                        <?PHP
                                            HTML::print("<small class=\"d-block mt-4 text-center posted-date\">", false);
                                            if($Account->Configuration->VerificationMethods->TwoFactorAuthenticationEnabled)
                                            {
                                                $LastUpdated = $Account->Configuration->VerificationMethods->TwoFactorAuthentication->LastUpdated;
                                                HTML::print(str_ireplace("%s", gmdate("F j, Y, g:i a", $LastUpdated), TEXT_LAST_UPDATED_TIMESTAMP));
                                            }
                                            else
                                            {
                                                HTML::print(TEXT_STATE_NOT_ENABLED);
                                            }
                                            HTML::print("</small>", false);
                                        ?>
                                    </div>
                                    <div class="card-footer align-content-center d-flex">
                                        <?PHP
                                            if($Account->Configuration->VerificationMethods->TwoFactorAuthenticationEnabled)
                                            {
                                                HTML::print("<button class=\"btn btn-danger btn-block\" data-toggle=\"modal\" data-target=\"#disable-mv\">", false);
                                                HTML::print(TEXT_ACTION_DISABLE);
                                                HTML::print("</button>", false);
                                            }
                                            else
                                            {
                                                $Href = DynamicalWeb::getRoute('setup_mobile_verification');
                                                HTML::print("<button class=\"btn btn-primary btn-block\" onclick=\"location.href='$Href';\">", false);
                                                HTML::print(TEXT_ACTION_SETUP);
                                                HTML::print("</button>", false);
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 grid-margin stretch-card">
                                <div class="card card-statistics social-card card-default">
                                    <div class="card-header header-sm">
                                        <div class="d-flex align-items-center">
                                            <div class="wrapper d-flex align-items-center media-info text-primary">
                                                <i class="mdi mdi-reload icon-md"></i>
                                                <h2 class="card-title ml-3"><?PHP HTML::print(TEXT_CARD_RECOVERY_CODES_HEADER); ?></h2>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="text-center pb-3">
                                            <?PHP
                                            if($Account->Configuration->VerificationMethods->RecoveryCodesEnabled)
                                            {
                                                HTML::print("<div class=\"badge badge-lg badge-outline-success badge-pill\">", false);
                                                HTML::print(TEXT_STATE_ENABLED);
                                                HTML::print("</div>", false);
                                            }
                                            else
                                            {
                                                HTML::print("<div class=\"badge badge-lg badge-outline-danger badge-pill\">", false);
                                                HTML::print(TEXT_STATE_DISABLED);
                                                HTML::print("</div>", false);
                                            }
                                            ?>
                                        </div>
                                        <p class="text-center mb-2 comment"><?PHP HTML::print(TEXT_CARD_RECOVERY_CODES_DESCRIPTION); ?></p>
                                        <?PHP
                                            HTML::print("<small class=\"d-block mt-4 text-center posted-date\">", false);
                                            if($Account->Configuration->VerificationMethods->RecoveryCodesEnabled)
                                            {
                                                $LastUpdated = $Account->Configuration->VerificationMethods->RecoveryCodes->LastUpdated;
                                                HTML::print(str_ireplace("%s", gmdate("F j, Y, g:i a", $LastUpdated), TEXT_LAST_UPDATED_TIMESTAMP));
                                            }
                                            else
                                            {
                                                HTML::print(TEXT_STATE_NOT_ENABLED);
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
                                                    HTML::print(TEXT_ACTION_DISABLE);
                                                    HTML::print("</button>", false);
                                                }
                                                else
                                                {
                                                    HTML::print("<button class=\"btn btn-danger btn-block\" data-toggle=\"modal\" data-target=\"#disable-rc\">", false);
                                                    HTML::print(TEXT_ACTION_DISABLE);
                                                    HTML::print("</button>", false);
                                                }
                                            }
                                            else
                                            {
                                                $Href = DynamicalWeb::getRoute('setup_recovery_codes');
                                                HTML::print("<button class=\"btn btn-primary btn-block\" onclick=\"location.href='$Href';\">", false);
                                                HTML::print(TEXT_ACTION_SETUP);
                                                HTML::print("</button>", false);
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 grid-margin stretch-card">
                                <div class="card card-statistics social-card card-default">
                                    <div class="card-header header-sm">
                                        <div class="d-flex align-items-center">
                                            <div class="wrapper d-flex align-items-center media-info text-primary">
                                                <i class="mdi mdi-telegram icon-md"></i>
                                                <h2 class="card-title ml-3"><?PHP HTML::print(TEXT_CARD_TELEGRAM_VERIFICATION_HEADER); ?></h2>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="text-center pb-3">
                                            <?PHP
                                            if($Account->Configuration->VerificationMethods->TelegramClientLinked)
                                            {
                                                HTML::print("<div class=\"badge badge-lg badge-outline-success badge-pill\">", false);
                                                HTML::print(TEXT_STATE_ENABLED);
                                                HTML::print("</div>", false);
                                            }
                                            else
                                            {
                                                HTML::print("<div class=\"badge badge-lg badge-outline-danger badge-pill\">", false);
                                                HTML::print(TEXT_STATE_DISABLED);
                                                HTML::print("</div>", false);
                                            }
                                            ?>
                                        </div>
                                        <p class="text-center mb-2 comment"><?PHP HTML::print(TEXT_CARD_TELEGRAM_VERIFICATION_DESCRIPTION); ?></p>
                                        <?PHP
                                            HTML::print("<small class=\"d-block mt-4 text-center posted-date\">", false);
                                            if($Account->Configuration->VerificationMethods->TelegramClientLinked)
                                            {
                                                $LastUpdated = $Account->Configuration->VerificationMethods->TelegramLink->LastLinked;
                                                HTML::print(str_ireplace("%s", gmdate("F j, Y, g:i a", $LastUpdated), TEXT_ADDED_ON_TIMESTAMP));
                                            }
                                            else
                                            {
                                                HTML::print(TEXT_STATE_NOT_ENABLED);
                                            }
                                            HTML::print("</small>", false);
                                        ?>
                                    </div>
                                    <div class="card-footer align-content-center d-flex">
                                        <?PHP
                                        if($Account->Configuration->VerificationMethods->TelegramClientLinked)
                                        {
                                            HTML::print("<button class=\"btn btn-danger btn-block\" data-toggle=\"modal\" data-target=\"#unlink-telegram\">", false);
                                            HTML::print(TEXT_ACTION_UNLINK_TELEGRAM);
                                            HTML::print("</button>", false);
                                        }
                                        else
                                        {
                                            $BotName = $IntellivoidAccounts->getTelegramConfiguration()['TgBotName'];
                                            $Href = DynamicalWeb::getRoute('setup_recovery_codes');
                                            HTML::print("<button class=\"btn btn-primary btn-block\" onclick=\"location.href='tg://resolve?domain=$BotName&start=link'\">", false);
                                            HTML::print(TEXT_ACTION_LINK_TELEGRAM);
                                            HTML::print("</button>", false);
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                      </div>
                    </div>
                    <?PHP HTML::importScript('dialog.disable-mv'); ?>
                    <?PHP HTML::importScript('dialog.disable-rc-mv'); ?>
                    <?PHP HTML::importScript('dialog.disable-rc'); ?>
                    <?PHP HTML::importScript('dialog.disable-tg'); ?>
                    <?PHP HTML::importSection('dashboard_footer'); ?>
                </div>
            </div>

        </div>
        <?PHP HTML::importSection('dashboard_js'); ?>
    </body>
</html>
