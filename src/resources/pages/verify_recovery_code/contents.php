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
                    <div class="row w-100 mx-auto animated slideInRight" id="input_dialog">
                        <div class="col-lg-4 mx-auto">
                            <div class="auto-form-wrapper">
                                <button class="btn btn-rounded btn-inverse-light grid-margin" onclick="animate_dialog(); location.href='/verify';">
                                    <i class="mdi mdi-arrow-left"></i>
                                </button>
                                <h1 class="text-center">
                                    <i class="mdi mdi-reload"></i>
                                    Verification
                                    <p>Enter a one-time use recovery code</p>
                                </h1>
                                <div name="callback_alert" id="callback_alert">
                                    <?PHP HTML::importScript('callbacks'); ?>
                                </div>
                                <div class="border-bottom pb-2"></div>
                                <form id="authentication_form" class="pt-4" name="authentication_form">

                                    <div class="form-group">
                                        <label for="code" class="label" style="display: none; visibility: hidden;" hidden>Recovery Code</label>
                                        <div class="input-group">
                                            <input name="code" id="code" type="text" class="form-control" placeholder="Verification Code" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                  <i class="mdi mdi-verified"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group pb-2 pt-2">
                                        <input type="submit" class="btn btn-primary submit-btn btn-block" value="Verify">
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
        <script>
            function animate_dialog()
            {
                $("#input_dialog").removeClass("animated");
                $("#input_dialog").removeClass("slideInRight");
                $("#input_dialog").addClass("animated slideOutRight");
            }
        </script>
    </body>
</html>
