<?PHP
    use DynamicalWeb\HTML;
    HTML::importScript('auth.register');
?>
<!doctype html>
<html lang="<?PHP HTML::print(APP_LANGUAGE_ISO_639); ?>">
    <head>
        <?PHP HTML::importSection('headers'); ?>
        <title>Intellivoid Accounts</title>
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
                                </h1>
                                <div class="dot-opacity-loader">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                                <div class="pb-4"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?PHP HTML::importSection('js_scripts'); ?>
    </body>
</html>
