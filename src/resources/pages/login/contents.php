<?PHP

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use DynamicalWeb\Javascript;

    HTML::importScript('auth.login');

    $GetParameters = $_GET;
    unset($GetParameters['callback']);
?>
<!doctype html>
<html lang="<?PHP HTML::print(APP_LANGUAGE_ISO_639); ?>">
    <head>
        <?PHP HTML::importSection('headers'); ?>
        <link rel="stylesheet" href="/assets/css/extra.css">
        <title><?PHP HTML::print(TEXT_PAGE_TITLE); ?></title>
    </head>
    <body>
        <div class="container-scroller">
            <div class="container-fluid page-body-wrapper full-page-wrapper">
                <div class="content-wrapper d-flex align-items-center auth area theme-one">
                    <?PHP HTML::importSection('background_animations'); ?>
                    <div class="row w-100 mx-auto">
                        <div class="col-lg-5 mx-auto">
                            <div class="linear-activity">
                                <div id="linear-spinner" class="indeterminate-none"></div>
                            </div>
                            <div class="auto-form-wrapper" style="border-radius: 0px; border-bottom-left-radius: 4px; border-bottom-right-radius: 4px;">
                                <h2 class="text-center">
                                    <img src="/assets/images/iv_logo.svg" alt="Intellivoid Blue Logo" class="img-xs rounded-circle mb-1"/>
                                    Intelli<b>void</b>
                                </h2>
                                <div class="text-center tiny-text"><?PHP HTML::print(TEXT_AUTHENTICATION_HEADER); ?></div>
                                <div id="callback_alert" class="mt-2">
                                    <?PHP HTML::importScript('callbacks'); ?>
                                </div>
                                <div class="border-bottom pt-3"></div>
                                <form id="authentication_form" name="authentication_form">
                                    <div class="form-group pt-4">
                                        <label for="username_email" id="username_email_label" class="label"><?PHP HTML::print(TEXT_LOGIN_PLACEHOLDER); ?></label>
                                        <input name="username_email" id="username_email" type="text" class="form-control" autofocus="autofocus" placeholder="example@intellivoid.info" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="password" id="password_label" class="label"><?PHP HTML::print(TEXT_PASSWORD_PLACEHOLDER); ?></label>
                                        <input name="password" id="password" type="password" class="form-control" placeholder="*********" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" id="submit_button" class="btn btn-primary submit-btn btn-block" value="<?PHP HTML::print(TEXT_LOGIN_BUTTON); ?>">
                                    </div>
                                    <div class="text-block text-center my-3">
                                        <span class="text-small font-weight-semibold" id="option_pt1"><?PHP HTML::print(TEXT_HINT_NO_ACCOUNT); ?></span>
                                        <a href="<?PHP DynamicalWeb::getRoute('register', $GetParameters, true); ?>" id="option_pt2" class="text-black text-small"><?PHP HTML::print(TEXT_CREATE_ACCOUNT_LINK); ?></a>
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
        <?PHP Javascript::importScript('login', $GetParameters); ?>
    </body>
</html>
