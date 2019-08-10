<?PHP
    use DynamicalWeb\HTML;
?>
<!doctype html>
<html lang="<?PHP HTML::print(APP_LANGUAGE_ISO_639); ?>">
    <head>
        <?PHP HTML::importSection('headers'); ?>
        <title>Intellivoid Accounts - Authentication</title>
    </head>

    <body>
        <div class="container-scroller">
            <div class="container-fluid page-body-wrapper full-page-wrapper">
                <div class="content-wrapper d-flex align-items-center auth auth-bg-1 theme-one">
                    <div class="row w-100 mx-auto">
                        <div class="col-lg-4 mx-auto">
                            <div class="auto-form-wrapper">
                                <h1>
                                    <img src="/assets/images/iv_logo.svg" alt="Intellivoid Blue Logo" class="img-sm rounded-circle"/>
                                    Intelli<b>void</b>
                                </h1>
                                <div class="border-bottom pt-3"></div>

                                <form action="#">
                                    <div class="form-group pt-4">
                                        <label class="label">Email Address</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Email Address">
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                  <i class="mdi mdi-email"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="label">Username</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Username">
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                  <i class="mdi mdi-account"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="label">Password</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" placeholder="*********">
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                  <i class="mdi mdi-textbox-password"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <p class="text-small">
                                            By creating an account you agree to the Terms of Service and Privacy
                                            Policies placed by Intellivoid
                                        </p>
                                    </div>
                                    <div class="form-group d-flex justify-content-between">

                                        <div class="form-check form-check-flat mt-0">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input"> I agree
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-primary submit-btn btn-block">Create Account</button>
                                    </div>

                                    <div class="text-block text-center my-3">
                                        <span class="text-small font-weight-semibold">Already have an account?</span>
                                        <a href="/login" class="text-black text-small">Login</a>
                                    </div>
                                </form>
                            </div>
                            <?PHP HTML::importSection('auth_footer'); ?>
                        </div>
                    </div>
                </div>
                <!-- content-wrapper ends -->
            </div>
            <!-- page-body-wrapper ends -->
        </div>
        <?PHP HTML::importSection('js_scripts'); ?>

    </body>
</html>
