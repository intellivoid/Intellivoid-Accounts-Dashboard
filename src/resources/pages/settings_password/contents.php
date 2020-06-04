<?php

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use DynamicalWeb\Runtime;

    Runtime::import('IntellivoidAccounts');

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
                <div class="content-body">
                    <?PHP HTML::importScript('callbacks'); ?>
                    <section id="update_password">
                        <div class="row">
                            <div class="col-md-4 col-lg-3 mb-2 mb-md-0" id="settings_sidebar">
                                <?PHP HTML::importSection('settings_sidebar'); ?>
                            </div>
                            <div class="col-md-8 col-lg-9" id="settings_viewer">
                                <div class="card">
                                    <form method="POST" action="<?PHP DynamicalWeb::getRoute('index', array('action' => 'update_password', 'redirect' => 'settings_password'), true) ?>">
                                        <div class="card-header">
                                            <h4 class="card-title"><?PHP HTML::print(TEXT_PAGE_HEADER); ?></h4>
                                        </div>
                                        <div class="card-content">
                                            <div class="card-body">

                                                <div class="row">

                                                    <input name="username" id="username" type="text" autocomplete="off" value="<?PHP HTML::print(WEB_ACCOUNT_USERNAME); ?>" hidden>

                                                    <!-- Current Password -->
                                                    <div class="col-12">
                                                        <label for="current_password"><?PHP HTML::print(TEXT_CURRENT_PASSWORD_LABEL); ?></label>
                                                        <fieldset class="form-group position-relative has-icon-left">
                                                            <input id="current_password" name="current_password" autocomplete="current-password" type="password" class="form-control" placeholder="<?PHP HTML::print(TEXT_CURRENT_PASSWORD_PLACEHOLDER); ?>" required>
                                                            <div class="form-control-position">
                                                                <i class="feather icon-lock"></i>
                                                            </div>
                                                        </fieldset>
                                                    </div>

                                                    <!-- New Password -->
                                                    <div class="col-12">
                                                        <label for="new_password"><?PHP HTML::print(TEXT_NEW_PASSWORD_LABEL); ?></label>
                                                        <fieldset class="form-group position-relative has-icon-left">
                                                            <input id="new_password" name="new_password" autocomplete="new-password" type="password" class="form-control" placeholder="<?PHP HTML::print(TEXT_NEW_PASSWORD_PLACEHOLDER); ?>" required>
                                                            <div class="form-control-position">
                                                                <i class="feather icon-lock"></i>
                                                            </div>
                                                        </fieldset>
                                                    </div>

                                                    <!-- Confirm Password -->
                                                    <div class="col-12">
                                                        <label for="confirm_password"><?PHP HTML::print(TEXT_CONFIRM_PASSWORD_LABEL); ?></label>
                                                        <fieldset class="form-group position-relative has-icon-left">
                                                            <input id="confirm_password" name="confirm_password" autocomplete="new-password" type="password" class="form-control" placeholder="<?PHP HTML::print(TEXT_CONFIRM_PASSWORD_PLACEHOLDER); ?>" required>
                                                            <div class="form-control-position">
                                                                <i class="feather icon-lock"></i>
                                                            </div>
                                                        </fieldset>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                        <div class="card-footer bg-white">
                                            <span class="float-right">
                                                <button type="submit" class="btn btn-primary mb-1"><?PHP HTML::print(TEXT_SUBMIT_BUTTON); ?></button>
                                            </span>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>

        <?PHP HTML::importSection('main_ehelper'); ?>
        <?PHP HTML::importSection('main_footer'); ?>
        <?PHP HTML::importSection('main_js'); ?>

    </body>
</html>