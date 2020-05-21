<?php

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use IntellivoidAccounts\Objects\Account;

    HTML::importScript('check_sudo');
    HTML::importScript('check');
    HTML::importScript('confirm');
    HTML::importScript('setup');

    /** @var Account $Account */
    $Account = DynamicalWeb::getMemoryObject('account');
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
                    <section id="setup_recovery_codes">
                        <div class="row">
                            <div class="col-md-4 mb-2 mb-md-0" id="settings_sidebar">
                                <?PHP HTML::importSection('settings_sidebar'); ?>
                            </div>
                            <div class="col-md-8" id="settings_viewer">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title"><?PHP HTML::print(TEXT_PAGE_HEADER); ?></h4>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            <p class="card-description"><?PHP HTML::print(TEXT_CARD_DESCRIPTION); ?></p>
                                            <?PHP $RecoveryCodes = $Account->Configuration->VerificationMethods->RecoveryCodes->RecoveryCodes; ?>
                                            <div class="row border-top pt-3 mt-auto">
                                                <div class="col-2">
                                                    <h6 class="font-weight-medium"><?PHP HTML::print($RecoveryCodes[0]); ?></h6>
                                                </div>
                                                <div class="col-2">
                                                    <h6 class="font-weight-medium"><?PHP HTML::print($RecoveryCodes[1]); ?></h6>
                                                </div>
                                                <div class="col-2">
                                                    <h6 class="font-weight-medium"><?PHP HTML::print($RecoveryCodes[2]); ?></h6>
                                                </div>
                                                <div class="col-2">
                                                    <h6 class="font-weight-medium"><?PHP HTML::print($RecoveryCodes[3]); ?></h6>
                                                </div>
                                                <div class="col-2">
                                                    <h6 class="font-weight-medium"><?PHP HTML::print($RecoveryCodes[4]); ?></h6>
                                                </div>
                                                <div class="col-2">
                                                    <h6 class="font-weight-medium"><?PHP HTML::print($RecoveryCodes[5]); ?></h6>
                                                </div>
                                                <div class="col-2">
                                                    <h6 class="font-weight-medium"><?PHP HTML::print($RecoveryCodes[6]); ?></h6>
                                                </div>
                                                <div class="col-2">
                                                    <h6 class="font-weight-medium"><?PHP HTML::print($RecoveryCodes[7]); ?></h6>
                                                </div>
                                                <div class="col-2">
                                                    <h6 class="font-weight-medium"><?PHP HTML::print($RecoveryCodes[8]); ?></h6>
                                                </div>
                                                <div class="col-2">
                                                    <h6 class="font-weight-medium"><?PHP HTML::print($RecoveryCodes[9]); ?></h6>
                                                </div>
                                                <div class="col-2">
                                                    <h6 class="font-weight-medium"><?PHP HTML::print($RecoveryCodes[10]); ?></h6>
                                                </div>
                                                <div class="col-2">
                                                    <h6 class="font-weight-medium"><?PHP HTML::print($RecoveryCodes[11]); ?></h6>
                                                </div>
                                                <div class="col-2">
                                                    <h6 class="font-weight-medium"><?PHP HTML::print($RecoveryCodes[12]); ?></h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer text-muted bg-white">
                                        <span class="float-right">
                                            <button class="btn bg-gradient-success" data-toggle="modal" data-target="#confirm"><?PHP HTML::print(TEXT_CONFIRM_BUTTON); ?></button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <?PHP HTML::importScript('confirmation_dialog'); ?>
        </div>

        <?PHP HTML::importSection('main_ehelper'); ?>
        <?PHP HTML::importSection('main_footer'); ?>
        <?PHP HTML::importSection('main_js'); ?>

    </body>
</html>