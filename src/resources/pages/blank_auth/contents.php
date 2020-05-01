<?php

use DynamicalWeb\DynamicalWeb;
use DynamicalWeb\HTML;
?>
<!DOCTYPE html>
<html class="loading" lang="<?PHP HTML::print(APP_LANGUAGE_ISO_639); ?>" data-textdirection="ltr">
    <head>
        <?PHP HTML::importSection('authentication_headers'); ?>
        <title>Authentication Blank</title>
    </head>
    <body class="horizontal-layout horizontal-menu 1-column navbar-floating footer-static blank-page blank-page area" data-open="hover" data-menu="horizontal-menu" data-col="1-column">
        <div class="app-content content" style="overflow: inherit;">
            <?PHP HTML::importSection('authentication_bhelper'); ?>

            <div class="content-wrapper mt-0">
                <?PHP HTML::importSection('background_animations'); ?>
                <div class="content-header row">
                </div>
                <div class="content-body">
                    <section class="row flexbox-container mx-0">
                        <div class="col-xl-8 col-10 d-flex justify-content-center my-3">
                            <div class="col-12 col-sm-10 col-md-11 col-lg-8 col-xl-7 p-0">
                                <div class="linear-activity">
                                    <div id="linear-spinner" class="indeterminate"></div>
                                </div>
                                <div class="card rounded-0 mb-0">
                                    <div class="card-header pt-50 pb-0 mb-0 mx-2 mt-2">
                                        <div class="card-title">
                                            <img src="/assets/images/logo_2.svg" alt="Intellivoid Accounts Brand" style="width: 130px; height: 30px;" class="img-fluid mb-2">
                                            <h4 class="mb-0 auth-header">Register an Account</h4>
                                            <span class="text-danger font-small-2 auth-error">There was a problem while processing your request</span>
                                        </div>
                                    </div>
                                    <div class="card-content p-2 pt-0">
                                        <div class="card-body pt-0">
                                            <form action="#">
                                                <div class="form-group">
                                                    <label for="email" class="text-muted">Email</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="email" id="email" class="form-control" autocomplete="email" name="email" placeholder="Email Address" required disabled>
                                                        <div class="form-control-position">
                                                            <i class="feather icon-mail"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="username" class="text-muted">Username</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="text" id="username" class="form-control" autocomplete="username" name="username" placeholder="Username" required disabled>
                                                        <div class="form-control-position">
                                                            <i class="feather icon-user"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="password" class="text-muted">Password</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input type="password" id="password" class="form-control" autocomplete="new-password" name="password" placeholder="Password" required disabled>
                                                        <div class="form-control-position">
                                                            <i class="feather icon-lock"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-12">
                                                        <fieldset class="checkbox">
                                                            <div class="vs-checkbox-con vs-checkbox-primary">
                                                                <input name="tos_agree" id="tos_agree" type="checkbox" required disabled>
                                                                <span class="vs-checkbox">
                                                                    <span class="vs-checkbox--check">
                                                                        <i class="vs-icon feather icon-check"></i>
                                                                    </span>
                                                                </span>
                                                                <label for="tos_agree" class="text-muted">I accept the terms of service.</label>
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                </div>

                                                <input type="submit" id="submit_button" class="btn btn-primary waves-effect waves-light float-right" value="Register" data-value="none">

                                                <span>
                                                    Have an account?
                                                    <a href="#">Login</a>
                                                </span>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <span class="float-left">
                                            <a data-toggle="modal" data-target="#change-language-dialog" href="#">
                                                <i class="feather icon-globe"></i>
                                            </a>
                                        </span>
                                        <span class="float-right">
                                            <a href="<?PHP DynamicalWeb::getRoute('tos', [], true); ?>" class="card-link">Terms of Service
                                                <i class="fa fa-angle-right"></i>
                                            </a>
                                            <a href="<?PHP DynamicalWeb::getRoute('privacy', [], true); ?>" class="card-link">Privacy Policy
                                                <i class="fa fa-angle-right"></i>
                                            </a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                </div>
            </div>
            <?PHP HTML::importSection('change_language_modal'); ?>
        </div>
        <?PHP HTML::importSection('authentication_js'); ?>
    </body>
</html>