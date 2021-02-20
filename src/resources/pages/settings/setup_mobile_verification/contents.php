<?php

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use DynamicalWeb\Javascript;

    HTML::importScript('check');
    HTML::importScript('verify');
    HTML::importScript('setup');
?>
<!DOCTYPE html>
<html class="loading" lang="<?PHP HTML::print(APP_LANGUAGE_ISO_639); ?>" data-textdirection="ltr">
    <head>
        <?PHP HTML::importSection('main_headers'); ?>
        <link rel="stylesheet" type="text/css" href="/assets/css/plugins/forms/wizard.css">
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
                    <section id="setup_mobile_verification">
                        <div class="row">
                            <div class="col-md-4 col-lg-3 mb-2 mb-md-0" id="settings_sidebar">
                                <?PHP HTML::importSection('settings_sidebar'); ?>
                            </div>
                            <div class="col-md-8 col-lg-9" id="settings_viewer">


                                <section id="icon-tabs">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h4 class="card-title"><?PHP HTML::print(TEXT_PAGE_HEADER); ?></h4>
                                                </div>
                                                <div class="card-content">
                                                    <div class="card-body">
                                                        <form action="<?PHP DynamicalWeb::getRoute('settings_setup_mobile_verification', array('action'=>'verify'), true); ?>" method="POST" id="mobile_verification_setup_wizard" class="wizard-circle">

                                                            <!-- Download -->
                                                            <h6>
                                                                <i class="step-icon feather icon-download"></i> <?PHP HTML::print(TEXT_PART_1_TITLE); ?>
                                                            </h6>
                                                            <fieldset>
                                                                <p><?PHP HTML::print(TEXT_PART_1_BODY); ?></p>
                                                                <div class="row">
                                                                    <div class="col-lg-6 col-12">
                                                                        <div class="card text-white bg-gradient-success text-center">
                                                                            <div class="card-content d-flex">
                                                                                <div class="card-body">
                                                                                    <div class="d-inline">
                                                                                        <img src="/assets/images/undraw/android.svg" alt="Android" width="150" class="float-left px-1 d-none d-lg-inline">
                                                                                        <h4 class="card-title text-white mb-2">Android</h4>
                                                                                    </div>

                                                                                    <div class="d-none d-xl-inline">
                                                                                        <a class="btn btn-primary waves-effect waves-light mt-auto" href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2">
                                                                                            <?PHP HTML::print(TEXT_PART_1_PLAYSTORE); ?>
                                                                                        </a>
                                                                                    </div>
                                                                                    <div class="d-xl-none d-md-block">
                                                                                        <a class="btn btn-primary btn-block waves-effect waves-light" href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2">
                                                                                            <?PHP HTML::print(TEXT_PART_1_PLAYSTORE); ?>
                                                                                        </a>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-lg-6 col-12">
                                                                        <div class="card text-white bg-gradient-info text-center">
                                                                            <div class="card-content d-flex">
                                                                                <div class="card-body">
                                                                                    <div class="d-inline">
                                                                                        <img src="/assets/images/undraw/ios.svg" alt="iOS" width="150" class="float-left px-1 d-none d-lg-inline">
                                                                                        <h4 class="card-title text-white mb-2">iOS</h4>
                                                                                    </div>

                                                                                    <div class="d-none d-xl-inline">
                                                                                        <a class="btn btn-primary waves-effect waves-light mt-auto" href="http://appstore.com/googleauthenticator">
                                                                                            <?PHP HTML::print(TEXT_PART_1_APPSTORE); ?>
                                                                                        </a>
                                                                                    </div>
                                                                                    <div class="d-xl-none d-md-block">
                                                                                        <a class="btn btn-primary btn-block waves-effect waves-light mt-auto" href="http://appstore.com/googleauthenticator">
                                                                                            <?PHP HTML::print(TEXT_PART_1_APPSTORE); ?>
                                                                                        </a>
                                                                                    </div>

                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </fieldset>

                                                            <!-- Scan -->
                                                            <h6><i class="step-icon feather icon-camera"></i> <?PHP HTML::print(TEXT_PART_2_TITLE); ?></h6>
                                                            <fieldset>
                                                                <img alt="QR Code" class="img-fluid d-block mx-auto mb-2" src="<?PHP HTML::print(SECURITY_QR_CODE, false); ?>">
                                                                <div class="text-center">
                                                                    <a class="btn bg-gradient-primary" href="<?PHP HTML::print(OTP_URL, false); ?>"><?PHP HTML::print(TEXT_PAGE_2_BUTTON); ?></a>
                                                                    <br/>
                                                                    <p class="pt-2">
                                                                        <?PHP HTML::print(TEXT_PART_2_HINT); ?> <code><?PHP HTML::print(SECURITY_SECRET_CODE); ?></code>
                                                                    </p>
                                                                </div>

                                                            </fieldset>

                                                            <!-- Verify Code -->
                                                            <h6><i class="step-icon feather icon-check"></i> <?PHP HTML::print(TEXT_PART_3_TITLE); ?></h6>
                                                            <fieldset>
                                                                <div class="form-group">
                                                                    <label for="verification_code"><?PHP HTML::print(TEXT_PART_3_INPUT_LABEL); ?></label>
                                                                    <input type="text" class="form-control" id="verification_code" name="verification_code" placeholder="123 456" required>
                                                                </div>
                                                            </fieldset>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>

                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>

        <?PHP HTML::importSection('main_ehelper'); ?>
        <?PHP HTML::importSection('main_footer'); ?>
        <?PHP HTML::importSection('main_js'); ?>
        <script src="/assets/vendors/js/ui/jquery.sticky.js"></script>
        <script src="/assets/vendors/js/extensions/jquery.steps.min.js"></script>
        <?PHP Javascript::importScript('mbsetup', $_GET, false); ?>
    </body>
</html>