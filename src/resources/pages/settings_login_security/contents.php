<?php

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
<!DOCTYPE html>
<html class="loading" lang="<?PHP HTML::print(APP_LANGUAGE_ISO_639); ?>" data-textdirection="ltr">
    <head>
        <?PHP HTML::importSection('main_headers'); ?>
        <title><?PHP HTML::print(TEXT_PAGE_TITLE) ?></title>
    </head>
    <body class="horizontal-layout horizontal-menu 2-columns navbar-sticky fixed-footer" data-open="hover" data-menu="horizontal-menu" data-col="2-columns">

        <?PHP HTML::importSection('main_bhelper'); ?>
        <?PHP HTML::importSection('main_nav'); ?>
        <?PHP HTML::importSection('main_horizontal_menu'); ?>

        <div class="app-content content mb-0">
            <?PHP HTML::importSection('main_chelper'); ?>
            <div class="content-wrapper">
                <?PHP HTML::importScript('callbacks'); ?>
                <div class="content-body">
                    <section id="account_settings">
                        <div class="row">
                            <div class="col-md-4 col-lg-3 mb-2 mb-md-0" id="settings_sidebar">
                                <?PHP HTML::importSection('settings_sidebar'); ?>
                            </div>
                            <div class="col-md-8" id="settings_viewer">
                                <div class="row">

                                    <!-- MOBILE VERIFICATION -->
                                    <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 grid-margin stretch-card">
                                        <div class="card">
                                            <div class="card-content">
                                                <div class="card-body">
                                                    <img class="card-img img-fluid mb-1 p-1 d-lg-none d-xl-inline" src="/assets/images/undraw/mobile_verification.svg" alt="<?PHP HTML::print(TEXT_CARD_MOBILE_VERIFICATION_HEADER); ?>">
                                                    <h5 class="mt-1"><?PHP HTML::print(TEXT_CARD_MOBILE_VERIFICATION_HEADER); ?></h5>
                                                    <p class="card-text"><?PHP HTML::print(TEXT_CARD_MOBILE_VERIFICATION_DESCRIPTION); ?></p>
                                                    <hr class="my-1">
                                                    <div class="d-flex justify-content-between">
                                                        <div class="float-left">
                                                            <p class="font-medium-1 mb-0">
                                                                <?PHP
                                                                    if($Account->Configuration->VerificationMethods->TwoFactorAuthenticationEnabled)
                                                                    {
                                                                        HTML::print("<i class=\"fa fa-circle font-small-3 text-success mr-25\"></i>", false);
                                                                        HTML::print(TEXT_STATE_ENABLED);
                                                                    }
                                                                    else
                                                                    {
                                                                        HTML::print("<i class=\"fa fa-circle font-small-3 text-danger mr-25\"></i>", false);
                                                                        HTML::print(TEXT_STATE_DISABLED);
                                                                    }
                                                                ?>
                                                            </p>
                                                            <p class="font-small-3 pt-50 mb-0">
                                                                <?PHP
                                                                    if($Account->Configuration->VerificationMethods->TwoFactorAuthenticationEnabled)
                                                                    {
                                                                        $LastUpdated = $Account->Configuration->VerificationMethods->TwoFactorAuthentication->LastUpdated;
                                                                        HTML::print(gmdate("n/j/Y g:i a", $LastUpdated));
                                                                    }
                                                                ?>
                                                            </p>
                                                        </div>
                                                        <div class="float-right mt-auto mb-50">
                                                            <?PHP
                                                                if($Account->Configuration->VerificationMethods->TwoFactorAuthenticationEnabled)
                                                                {
                                                                    HTML::print("<button class=\"btn bg-gradient-danger\" data-toggle=\"modal\" data-target=\"#disable-mv\">", false);
                                                                    HTML::print(TEXT_ACTION_DISABLE);
                                                                    HTML::print("</button>", false);
                                                                }
                                                                else
                                                                {
                                                                    $Href = DynamicalWeb::getRoute('settings_setup_mobile_verification');
                                                                    HTML::print("<button class=\"btn bg-gradient-primary\" onclick=\"location.href='$Href';\">", false);
                                                                    HTML::print(TEXT_ACTION_SETUP);
                                                                    HTML::print("</button>", false);
                                                                }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>

                                    <!-- RECOVERY CODES -->
                                    <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 grid-margin stretch-card">
                                        <div class="card">
                                            <div class="card-content">
                                                <div class="card-body">
                                                    <img class="card-img img-fluid mb-1 p-1 d-lg-none d-xl-inline" src="/assets/images/undraw/recovery_code.svg" alt="<?PHP HTML::print(TEXT_CARD_RECOVERY_CODES_HEADER); ?>">
                                                    <h5 class="mt-1"><?PHP HTML::print(TEXT_CARD_RECOVERY_CODES_HEADER); ?></h5>
                                                    <p class="card-text"><?PHP HTML::print(TEXT_CARD_RECOVERY_CODES_DESCRIPTION); ?></p>
                                                    <hr class="my-1">
                                                    <div class="d-flex justify-content-between">
                                                        <div class="float-left">
                                                            <p class="font-medium-1 mb-0">
                                                                <?PHP
                                                                if($Account->Configuration->VerificationMethods->RecoveryCodesEnabled)
                                                                {
                                                                    HTML::print("<i class=\"fa fa-circle font-small-3 text-success mr-25\"></i>", false);
                                                                    HTML::print(TEXT_STATE_ENABLED);
                                                                }
                                                                else
                                                                {
                                                                    HTML::print("<i class=\"fa fa-circle font-small-3 text-danger mr-25\"></i>", false);
                                                                    HTML::print(TEXT_STATE_DISABLED);
                                                                }
                                                                ?>
                                                            </p>
                                                            <p class="font-small-3 pt-50 mb-0">
                                                                <?PHP
                                                                if($Account->Configuration->VerificationMethods->RecoveryCodesEnabled)
                                                                {
                                                                    $LastUpdated = $Account->Configuration->VerificationMethods->RecoveryCodes->LastUpdated;
                                                                    HTML::print(gmdate("n/j/Y g:i a", $LastUpdated));
                                                                }
                                                                ?>
                                                            </p>
                                                        </div>
                                                        <div class="float-right mt-auto mb-50">

                                                            <?PHP
                                                                if($Account->Configuration->VerificationMethods->RecoveryCodesEnabled)
                                                                {
                                                                    if($Account->Configuration->VerificationMethods->TwoFactorAuthenticationEnabled)
                                                                    {
                                                                        HTML::print("<button class=\"btn bg-gradient-danger\" data-toggle=\"modal\" data-target=\"#disable-rc-mv\">", false);
                                                                        HTML::print(TEXT_ACTION_DISABLE);
                                                                        HTML::print("</button>", false);
                                                                    }
                                                                    else
                                                                    {
                                                                        HTML::print("<button class=\"btn bg-gradient-danger\" data-toggle=\"modal\" data-target=\"#disable-rc\">", false);
                                                                        HTML::print(TEXT_ACTION_DISABLE);
                                                                        HTML::print("</button>", false);
                                                                    }
                                                                }
                                                                else
                                                                {
                                                                    $Href = DynamicalWeb::getRoute('settings_setup_recovery_codes');
                                                                    HTML::print("<button class=\"btn bg-gradient-primary\" onclick=\"location.href='$Href';\">", false);
                                                                    HTML::print(TEXT_ACTION_SETUP);
                                                                    HTML::print("</button>", false);
                                                                }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>

                                    <!-- TELEGRAM PROMPT -->
                                    <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 grid-margin stretch-card">
                                        <div class="card">
                                            <div class="card-content">
                                                <div class="card-body">
                                                    <img class="card-img img-fluid mb-1 p-1  d-lg-none d-xl-inline" src="/assets/images/undraw/telegram_prompt.svg" alt="<?PHP HTML::print(TEXT_CARD_TELEGRAM_VERIFICATION_HEADER); ?>">
                                                    <h5 class="mt-1"><?PHP HTML::print(TEXT_CARD_TELEGRAM_VERIFICATION_HEADER); ?></h5>
                                                    <p class="card-text"><?PHP HTML::print(TEXT_CARD_TELEGRAM_VERIFICATION_DESCRIPTION); ?></p>
                                                    <hr class="my-1">
                                                    <div class="d-flex justify-content-between">
                                                        <div class="float-left">
                                                            <p class="font-medium-1 mb-0">
                                                                <?PHP
                                                                if($Account->Configuration->VerificationMethods->TelegramClientLinked)
                                                                {
                                                                    HTML::print("<i class=\"fa fa-circle font-small-3 text-success mr-25\"></i>", false);
                                                                    HTML::print(TEXT_STATE_ENABLED);
                                                                }
                                                                else
                                                                {
                                                                    HTML::print("<i class=\"fa fa-circle font-small-3 text-danger mr-25\"></i>", false);
                                                                    HTML::print(TEXT_STATE_DISABLED);
                                                                }
                                                                ?>
                                                            </p>
                                                            <p class="font-small-3 pt-50 mb-0">
                                                                <?PHP
                                                                if($Account->Configuration->VerificationMethods->TelegramClientLinked)
                                                                {
                                                                    $LastUpdated = $Account->Configuration->VerificationMethods->TelegramLink->LastLinked;
                                                                    HTML::print(gmdate("n/j/Y g:i a", $LastUpdated));
                                                                }
                                                                ?>
                                                            </p>
                                                        </div>
                                                        <div class="float-right mt-auto mb-50">
                                                            <?PHP
                                                            if($Account->Configuration->VerificationMethods->TelegramClientLinked)
                                                            {
                                                                HTML::print("<button class=\"btn bg-gradient-danger\" data-toggle=\"modal\" data-target=\"#unlink-telegram\">", false);
                                                                HTML::print(TEXT_ACTION_DISABLE);
                                                                HTML::print("</button>", false);
                                                            }
                                                            else
                                                            {
                                                                $BotName = $IntellivoidAccounts->getTelegramConfiguration()['TgBotName'];
                                                                HTML::print("<button class=\"btn bg-gradient-primary\" onclick=\"location.href='tg://resolve?domain=$BotName&start=link';\">", false);
                                                                HTML::print(TEXT_ACTION_SETUP);
                                                                HTML::print("</button>", false);
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <?PHP HTML::importScript('dialog.disable-mv'); ?>
            <?PHP HTML::importScript('dialog.disable-rc-mv'); ?>
            <?PHP HTML::importScript('dialog.disable-rc'); ?>
            <?PHP HTML::importScript('dialog.disable-tg'); ?>
        </div>

        <?PHP HTML::importSection('main_ehelper'); ?>
        <?PHP HTML::importSection('main_footer'); ?>
        <?PHP HTML::importSection('main_js'); ?>

    </body>
</html>