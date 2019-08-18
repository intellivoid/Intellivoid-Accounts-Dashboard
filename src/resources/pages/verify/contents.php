<?PHP
    use DynamicalWeb\HTML;

    $UsernameSafe = ucfirst(WEB_ACCOUNT_USERNAME);
    if(strlen($UsernameSafe) > 16)
    {
        $UsernameSafe = substr($UsernameSafe, 0 ,16);
        $UsernameSafe .= "...";
    }
?>
<!doctype html>
<html lang="<?PHP HTML::print(APP_LANGUAGE_ISO_639); ?>">
    <head>
        <?PHP HTML::importSection('headers'); ?>
        <title>Intellivoid Accounts - Verify</title>
    </head>

    <body>
        <div class="container-scroller">
            <div class="container-fluid page-body-wrapper full-page-wrapper">
                <div class="content-wrapper d-flex align-items-center auth auth-bg-1 theme-one">
                    <div class="row w-100 mx-auto">
                        <div class="col-lg-4 mx-auto">
                            <div class="auto-form-wrapper">
                                <h1 class="text-center">
                                    <i class="mdi mdi-lock"></i>
                                    Verification
                                    <p>To protect your account from unauthorized access, verify your login</p>
                                </h1>
                                <div name="callback_alert" id="callback_alert">
                                    <?PHP HTML::importScript('callbacks'); ?>
                                </div>

                                <div class="border-bottom pb-4"></div>

                                <form id="authentication_form" name="authentication_form">

                                    <div class="form-group pt-4">
                                        <a class="d-flex align-items-center py-1 text-black" href="/verify" style="text-decoration: none;">
                                            <span class="mdi mdi-cellphone-iphone"></span>
                                            <p class="mb-0 ml-3">Verify using your Phone</p>
                                            <p class="ml-auto mb-0 text-muted">
                                                <i class="mdi mdi-arrow-right"></i>
                                            </p>
                                        </a>
                                    </div>

                                    <div class="form-group">
                                        <a class="d-flex align-items-center py-1 text-black" href="/verify" style="text-decoration: none;">
                                            <span class="mdi mdi-reload"></span>
                                            <p class="mb-0 ml-3">Use a recovery code</p>
                                            <p class="ml-auto mb-0 text-muted">
                                                <i class="mdi mdi-arrow-right"></i>
                                            </p>
                                        </a>
                                    </div>

                                    <div class="form-group">
                                        <a class="d-flex align-items-center py-1 text-black" href="/verify" style="text-decoration: none;">
                                            <span class="mdi mdi-telegram"></span>
                                            <p class="mb-0 ml-3">Verify using your Telegram</p>
                                            <p class="ml-auto mb-0 text-muted">
                                                <i class="mdi mdi-arrow-right"></i>
                                            </p>
                                        </a>
                                    </div>

                                    <div class="form-group">
                                        <a class="d-flex align-items-center py-1 text-black" href="/verify" style="text-decoration: none;">
                                            <span class="mdi mdi-server"></span>
                                            <p class="mb-0 ml-3">Verify using OpenSSL</p>
                                            <p class="ml-auto mb-0 text-muted">
                                                <i class="mdi mdi-arrow-right"></i>
                                            </p>
                                        </a>
                                    </div>

                                    <div class="border-bottom pb-1"></div>

                                    <div class="text-block text-center my-3">
                                        <span class="text-small font-weight-semibold">Not <?php HTML::print($UsernameSafe); ?>?</span>
                                        <a href="/logout" class="text-black text-small">Logout</a>
                                    </div>
                                </form>
                            </div>
                            <?PHP HTML::importSection('auth_footer'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?PHP HTML::importSection('js_scripts'); ?>
        <script src="/assets/js/auth_login.js"></script>
    </body>
</html>
