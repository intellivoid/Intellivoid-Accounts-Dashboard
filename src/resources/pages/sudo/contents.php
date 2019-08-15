<?PHP

    use DynamicalWeb\HTML;
    use DynamicalWeb\Runtime;

    Runtime::import('IntellivoidAccounts');

    HTML::importScript('enter_sudo_mode');
    if(isset($_GET['redirect']) == false)
    {
        header('Location: /');
        exit();
    }
?>
<!doctype html>
<html lang="<?PHP HTML::print(APP_LANGUAGE_ISO_639); ?>">
    <head>
        <?PHP HTML::importSection('headers'); ?>
        <title>Intellivoid Accounts - Sudo Mode</title>
    </head>

    <body>
        <div class="container-scroller">
            <div class="container-fluid page-body-wrapper full-page-wrapper">
                <div class="content-wrapper d-flex align-items-center auth auth-bg-1 theme-one">
                    <div class="row w-100 mx-auto">
                        <div class="col-lg-4 mx-auto">
                            <div class="auto-form-wrapper">
                                <h1 class="text-center">
                                    <img src="/assets/images/iv_logo.svg" alt="Intellivoid Blue Logo" class="img-sm rounded-circle"/>
                                    Intelli<b>void</b>
                                    <p>To prevent unauthorized changes, enter your password</p>
                                </h1>
                                <div name="callback_alert" id="callback_alert">
                                    <?PHP HTML::importScript('callbacks'); ?>
                                </div>

                                <div class="border-bottom pt-3"></div>

                                <form id="authentication_form" name="authentication_form" class="pt-4">
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
                                        <input type="submit" class="btn btn-danger submit-btn btn-block" value="Enter sudo mode">
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
        <script src="/assets/js/auth_sudo.js"></script>
    </body>
</html>
