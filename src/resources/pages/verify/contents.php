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

    function getAnimationStyle()
    {
        if(isset($_GET['anim']))
        {
            switch($_GET['anim'])
            {
                case 'previous':
                    return " animated slideInLeft";
            }
        }

        return " animated fadeInUp";
    }

    $GetParameters = $_GET;
    unset($GetParameters['callback']);
    unset($GetParameters['incorrect_auth']);
    unset($GetParameters['anim']);

    /** @var Account $Account */
    $Account = DynamicalWeb::getMemoryObject('account');
?>
<!doctype html>
<html lang="<?PHP HTML::print(APP_LANGUAGE_ISO_639); ?>">
    <head>
        <?PHP HTML::importSection('headers'); ?>
        <link rel="stylesheet" href="/assets/css/extra.css">
        <title>Intellivoid Accounts - Verify</title>
    </head>

    <body>
        <div class="container-scroller">
            <div class="container-fluid page-body-wrapper full-page-wrapper">
                <div class="content-wrapper d-flex align-items-center auth area theme-one">
                    <?PHP HTML::importSection('background_animations'); ?>
                    <div class="row w-100 mx-auto<?PHP HTML::print(getAnimationStyle()); ?>" id="verification_dialog">
                        <div class="col-lg-5 mx-auto">
                            <div class="auto-form-wrapper">
                                <h1 class="text-center">
                                    <i class="mdi mdi-lock"></i>
                                    Verification
                                    <p>To protect your account from unauthorized access, verify your login</p>
                                </h1>
                                <div id="callback_alert" class="pb-3" id="callback_alert">
                                    <?PHP HTML::importScript('callbacks'); ?>
                                </div>

                                <form id="authentication_form" class="border-top pb-4" name="authentication_form">
                                    <div class="pt-4">
                                    </div>
                                    <?PHP
                                        if($Account->Configuration->VerificationMethods->TelegramClientLinked)
                                        {
                                            ?>
                                            <div class="form-group">
                                                <a class="d-flex align-items-center py-1 text-black" href="#" onclick="verify_telegram();" style="text-decoration: none;">
                                                    <span class="mdi mdi-telegram"></span>
                                                    <p class="mb-0 ml-3">Telegram Prompt</p>
                                                    <p class="ml-auto mb-0 text-muted">
                                                        <i class="mdi mdi-arrow-right"></i>
                                                    </p>
                                                </a>
                                            </div>
                                            <?PHP
                                        }

                                        if($Account->Configuration->VerificationMethods->TwoFactorAuthenticationEnabled)
                                        {
                                            ?>
                                            <div class="form-group">
                                                <a class="d-flex align-items-center py-1 text-black" href="#" onclick="verify_mobile();" style="text-decoration: none;">
                                                    <span class="mdi mdi-cellphone-iphone"></span>
                                                    <p class="mb-0 ml-3">Verify using your Phone</p>
                                                    <p class="ml-auto mb-0 text-muted">
                                                        <i class="mdi mdi-arrow-right"></i>
                                                    </p>
                                                </a>
                                            </div>
                                            <?PHP
                                        }

                                        if($Account->Configuration->VerificationMethods->RecoveryCodesEnabled)
                                        {
                                            ?>
                                            <div class="form-group">
                                                <a class="d-flex align-items-center py-1 text-black" href="#" onclick="verify_recovery_codes();" style="text-decoration: none;">
                                                    <span class="mdi mdi-reload"></span>
                                                    <p class="mb-0 ml-3">Use a recovery code</p>
                                                    <p class="ml-auto mb-0 text-muted">
                                                        <i class="mdi mdi-arrow-right"></i>
                                                    </p>
                                                </a>
                                            </div>
                                            <?PHP
                                        }

                                    ?>

                                    <div class="border-bottom pb-1"></div>

                                    <div class="text-block text-center my-3 pt-4">
                                        <span class="text-small font-weight-semibold">Not <?php HTML::print($UsernameSafe); ?>?</span>
                                        <a href="<?PHP DynamicalWeb::getRoute('logout', $GetParameters, true); ?>" class="text-black text-small">Logout</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?PHP HTML::importSection('js_scripts'); ?>
        <?PHP Javascript::importScript('verify', $GetParameters); ?>
    </body>
</html>
