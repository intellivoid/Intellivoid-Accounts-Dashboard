<?php
    use DynamicalWeb\HTML;
?>
<!DOCTYPE html>
<html class="loading" lang="<?PHP HTML::print(APP_LANGUAGE_ISO_639); ?>" data-textdirection="ltr">

    <head>
        <?PHP HTML::importSection('authentication_headers'); ?>
        <title>Authentication Blank</title>
    </head>
    <body class="horizontal-layout horizontal-menu 1-column navbar-floating footer-static bg-full-screen-image blank-page blank-page" data-open="hover" data-menu="horizontal-menu" data-col="1-column">
        <!-- BEGIN: Content-->
        <div class="app-content content">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow"></div>
            <div class="content-wrapper">
                <div class="content-header row">
                </div>
                <div class="content-body">
                    <section class="row flexbox-container">
                        <div class="col-xl-8 col-10 d-flex justify-content-center">
                            <div class="card bg-authentication rounded-0 mb-0">
                                <div class="row m-0">
                                    <div class="col-lg-6 d-lg-block d-none text-center align-self-center pl-0 pr-3 py-0">
                                        <img src="/assets/images/pages/register.jpg" alt="branding logo">
                                    </div>
                                    <div class="col-lg-6 col-12 p-0">
                                        <div class="card rounded-0 mb-0 p-2">
                                            <div class="card-header pt-50 pb-1">
                                                <div class="card-title">
                                                    <h4 class="mb-0">Create Account</h4>
                                                </div>
                                            </div>
                                            <p class="px-2">Fill the below form to create a new account.</p>
                                            <div class="card-content">
                                                <div class="card-body pt-0">
                                                    <form action="#">
                                                        <div class="form-label-group">
                                                            <input type="text" id="inputName" class="form-control" placeholder="Name" required>
                                                            <label for="inputName">Name</label>
                                                        </div>
                                                        <div class="form-label-group">
                                                            <input type="email" id="inputEmail" class="form-control" placeholder="Email" required>
                                                            <label for="inputEmail">Email</label>
                                                        </div>
                                                        <div class="form-label-group">
                                                            <input type="password" id="inputPassword" class="form-control" placeholder="Password" required>
                                                            <label for="inputPassword">Password</label>
                                                        </div>
                                                        <div class="form-label-group">
                                                            <input type="password" id="inputConfPassword" class="form-control" placeholder="Confirm Password" required>
                                                            <label for="inputConfPassword">Confirm Password</label>
                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="col-12">
                                                                <fieldset class="checkbox">
                                                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                                                        <input type="checkbox" checked>
                                                                        <span class="vs-checkbox">
                                                                                <span class="vs-checkbox--check">
                                                                                    <i class="vs-icon feather icon-check"></i>
                                                                                </span>
                                                                            </span>
                                                                        <span class=""> I accept the terms & conditions.</span>
                                                                    </div>
                                                                </fieldset>
                                                            </div>
                                                        </div>
                                                        <a href="#" class="btn btn-outline-primary float-left btn-inline mb-50">Login</a>
                                                        <input type="submit" class="btn btn-primary float-right btn-inline mb-50" value="Register">
                                                    </form>
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
        </div>
        <?PHP HTML::importSection('authentication_js'); ?>
    </body>
</html>