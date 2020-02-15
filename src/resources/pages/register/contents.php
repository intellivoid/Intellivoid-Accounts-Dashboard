<?PHP

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use DynamicalWeb\Javascript;

    HTML::importScript('auth.register');

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
                                <div class="text-center tiny-text"><?PHP HTML::print(TEXT_AUTHENTICATION_SUB_HEADER); ?></div>
                                <div id="callback_alert">
                                    <?PHP HTML::importScript('callbacks'); ?>
                                </div>
                                <div class="border-bottom pt-3"></div>
                                <form id="authentication_form" name="authentication_form">
                                    <div class="form-group pt-4">
                                        <label for="email" class="label" id="label_1"><?PHP HTML::print(TEXT_EMAIL_ADDRESS_LABEL); ?></label>
                                        <input name="email" id="email" type="email" class="form-control" placeholder="Email Address" aria-autocomplete="none" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="username" class="label" id="label_2"><?PHP HTML::print(TEXT_USERNAME_LABEL); ?></label>
                                        <input name="username" id="username" type="text" class="form-control" aria-autocomplete="none" autocomplete="off" placeholder="Username" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="password" class="label" id="label_3"><?PHP HTML::print(TEXT_PASSWORD_LABEL); ?></label>
                                        <input name="password" id="password" type="password" class="form-control"  autocomplete="new-password" placeholder="*********" required>
                                    </div>
                                    <div class="form-group">
                                        <p class="text-small" id="tos_label"><?PHP HTML::print(TEXT_TOS_HINT); ?></p>
                                    </div>
                                    <div class="form-group d-flex justify-content-between">

                                        <div class="form-check form-check-flat mt-0">
                                            <label id="tos_check_label" class="form-check-label">
                                                <input name="tos_agree" id="tos_agree" type="checkbox" class="form-check-input" required><?PHP HTML::print(TEXT_AGREE_CHECKBOX_LABEL); ?>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" id="submit_button" value="<?PHP HTML::print(TEXT_CREATE_ACCOUNT_BUTTON); ?>" class="btn btn-primary submit-btn btn-block">
                                    </div>

                                    <div class="text-block text-center my-3">
                                        <span class="text-small font-weight-semibold" id="ca_label"><?PHP HTML::print(TEXT_EXISTING_ACCOUNT_HINT); ?></span>
                                        <a id="ca_link" href="<?PHP DynamicalWeb::getRoute('login', $GetParameters, true); ?>" class="text-black text-small"><?PHP HTML::print(TEXT_LOGIN_LINK); ?></a>
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
        <?PHP Javascript::importScript('register', $GetParameters); ?>
    </body>
</html>
