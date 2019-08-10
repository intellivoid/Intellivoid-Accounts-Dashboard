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

                                <form action="/login" method="POST">
                                    <div class="form-group pt-4">
                                        <label for="username_email" class="label">Username or Email</label>
                                        <div class="input-group">
                                            <input name="username_email" id="username_email" type="text" class="form-control" placeholder="netkas@intellivoid.info" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                  <i class="mdi mdi-account"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="password" class="label">Password</label>
                                        <div class="input-group">
                                            <input name="password" id="password" type="password" class="form-control" placeholder="*********" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                  <i class="mdi mdi-textbox-password"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-primary submit-btn btn-block" value="Login">
                                    </div>
                                    <div class="form-group d-flex justify-content-between">
                                        <div class="form-check form-check-flat mt-0">
                                            <label class="form-check-label">
                                                <input name="trusted_device" id="trusted_device" type="checkbox" class="form-check-input">
                                                Trust this device
                                            </label>
                                        </div>
                                    </div>
                                    <div class="text-block text-center my-3">
                                        <span class="text-small font-weight-semibold">Don't have an account?</span>
                                        <a href="/register" class="text-black text-small">Create one</a>
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
