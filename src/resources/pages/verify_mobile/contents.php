<?PHP
    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use DynamicalWeb\Javascript;

    HTML::importScript('get_account');
    HTML::importScript('check_method');
    HTML::importScript('verify_code');

    $UsernameSafe = ucfirst(WEB_ACCOUNT_USERNAME);
    if(strlen($UsernameSafe) > 16)
    {
        $UsernameSafe = substr($UsernameSafe, 0 ,16);
        $UsernameSafe .= "...";
    }

    $BorderDanger = false;
    if(isset($_GET['incorrect_auth']))
    {
        if($_GET['incorrect_auth'] == '1')
        {
            $BorderDanger = true;
        }
    }

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
                    <div class="row w-100 mx-auto animated slideInRight" id="input_dialog">
                        <div class="col-lg-5 mx-auto">
                            <div class="auto-form-wrapper">
                                <button class="btn btn-rounded btn-inverse-light grid-margin" onclick="go_back();">
                                    <i class="mdi mdi-arrow-left"></i>
                                </button>
                                <div id="callback_alert">
                                    <?PHP HTML::importScript('callbacks'); ?>
                                </div>
                                <div class="text-center">
                                    <h1>
                                        <i class="mdi mdi-cellphone-iphone"></i> <?PHP HTML::print(TEXT_HEADER); ?>
                                    </h1>
                                    <p><?PHP HTML::print(TEXT_SUB_HEADER); ?></p>
                                </div>
                                <div id="callback_alert">
                                    <?PHP HTML::importScript('callbacks'); ?>
                                </div>
                                <div class="border-bottom pb-2"></div>
                                <?PHP $GetParameters['action'] = 'submit'; ?>
                                <form action="<?PHP DynamicalWeb::getRoute('verify_mobile', $GetParameters, true); ?>" method="POST" id="authentication_form" class="pt-4" name="authentication_form">

                                    <div class="form-group">
                                        <label for="code" class="label" style="display: none; visibility: hidden;" hidden><?PHP HTML::print(TEXT_RECOVERY_CODE_LABEL); ?></label>
                                        <input name="code" id="code" autocomplete="off" type="text" class="form-control<?PHP if($BorderDanger == true){ HTML::print(" border-danger"); } ?>" autofocus="autofocus" placeholder="Verification Code" required>
                                    </div>

                                    <div class="form-group pb-2 pt-2">
                                        <input type="submit" class="btn btn-primary submit-btn btn-block" value="<?PHP HTML::print(TEXT_SUBMIT_BUTTON); ?>">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>       
        <?PHP HTML::importSection('js_scripts'); ?>
        <?PHP Javascript::importScript('verifymobile', $GetParameters); ?>
    </body>
</html>
