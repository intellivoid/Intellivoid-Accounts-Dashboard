<?PHP

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
use DynamicalWeb\Javascript;
use IntellivoidAccounts\Objects\Account;

    HTML::importScript('get_account');
    $UsernameSafe = ucfirst(WEB_ACCOUNT_USERNAME);
    if(strlen($UsernameSafe) > 16)
    {
        $UsernameSafe = substr($UsernameSafe, 0 ,16);
        $UsernameSafe .= "...";
    }

    /** @var Account $Account */
    $Account = DynamicalWeb::getMemoryObject('account');
?>
<!doctype html>
<html lang="<?PHP HTML::print(APP_LANGUAGE_ISO_639); ?>">
    <head>
        <?PHP HTML::importSection('headers'); ?>
        <link rel="stylesheet" href="/assets/css/extra.css">
        <title>Intellivoid Accounts - Password Recovery</title>
    </head>

    <body>
        <div class="container-scroller">
            <div class="container-fluid page-body-wrapper full-page-wrapper">
                <div class="content-wrapper d-flex align-items-center auth area theme-one">
                    <?PHP HTML::importSection('background_animations'); ?>
                    <div class="row w-100 mx-auto" id="verification_dialog">
                        <div class="col-lg-5 mx-auto">
                            <div class="auto-form-wrapper">
                                <h1 class="text-center">
                                    <i class="mdi mdi-lock"></i>
                                    Recover Password
                                </h1>
                                <p>Set a new password</p>
                                <div id="callback_alert" class="pb-3" id="callback_alert">
                                    <?PHP //HTML::importScript('callbacks'); ?>
                                </div>

                                <form id="authentication_form" class="border-top pb-4" name="authentication_form">

                                    <div class="border-bottom pb-1"></div>

                                    <div class="text-block text-center my-3 pt-4">
                                        <span class="text-small font-weight-semibold">Not <?php HTML::print($UsernameSafe); ?>?</span>
                                        <a href="<?PHP DynamicalWeb::getRoute('logout', array(), true); ?>" class="text-black text-small">Logout</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?PHP HTML::importSection('js_scripts'); ?>
    </body>
</html>
