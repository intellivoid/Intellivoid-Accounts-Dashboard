<?PHP

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
use IntellivoidAccounts\Abstracts\SearchMethods\AccountSearchMethod;
use IntellivoidAccounts\IntellivoidAccounts;

    HTML::importScript('coa_auth');
    HTML::importScript('telegram_auth');
    HTML::importScript('update_password');
    HTML::importScript('change_avatar');
    HTML::importScript('submit_report');

    $UsernameSafe = ucfirst(WEB_ACCOUNT_USERNAME);
    if(strlen($UsernameSafe) > 16)
    {
        $UsernameSafe = substr($UsernameSafe, 0 ,16);
        $UsernameSafe .= "...";
    }

    if(isset(DynamicalWeb::$globalObjects["intellivoid_accounts"]) == false)
    {
        /** @var IntellivoidAccounts $IntellivoidAccounts */
        $IntellivoidAccounts = DynamicalWeb::setMemoryObject(
            "intellivoid_accounts", new IntellivoidAccounts()
        );
    }
    else
    {
        /** @var IntellivoidAccounts $IntellivoidAccounts */
        $IntellivoidAccounts = DynamicalWeb::getMemoryObject("intellivoid_accounts");
    }

    $Account = $IntellivoidAccounts->getAccountManager()->getAccount(AccountSearchMethod::byId, WEB_ACCOUNT_ID);

?>
<!doctype html>
<html lang="<?PHP HTML::print(APP_LANGUAGE_ISO_639); ?>">
    <head>
        <?PHP HTML::importSection('dashboard_headers'); ?>
        <title>Intellivoid Accounts</title>
    </head>

    <body>
        <div class="container-scroller">
            <?PHP HTML::importSection("dashboard_navbar"); ?>
            <div class="container-fluid page-body-wrapper">
                <div class="main-panel container">
                    <div class="content-wrapper">
                        <?PHP HTML::importScript('callbacks'); ?>
                        <div class="row">
                            <div class="col-12 grid-margin d-none d-lg-block">
                                <div class="intro-banner">
                                    <div class="banner-image">
                                        <img src="/assets/images/dashboard/banner_img.png" alt="banner image">
                                    </div>
                                    <div class="content-area">
                                        <h3 class="mb-0">Welcome back, <?PHP HTML::print($UsernameSafe); ?>!</h3>
                                        <p class="mb-0">Need anything more to know more? Feel free to contact us at any point.</p>
                                    </div>
                                    <a href="#" data-toggle="modal" data-target="#feedback_dialog" class="btn btn-light ml-5">Contact us</a>
                                </div>
                            </div>
                        </div>
                        <?PHP
                            if($Account->Configuration->VerificationMethods->TelegramClientLinked == false)
                            {
                                ?>
                                <div class="alert alert-fill-light border-dark" role="alert">
                                    <h4 class="text-black mb-3">
                                        <i class="mdi mdi-24px mdi-lock-plus text-black"></i> Account Security
                                    </h4>
                                    <span class="text-black">
                                        It is important that you link your Telegram Account with your Intellivoid Account, this will
                                        provide greater security to your Account and allow you to recover your account in the case you
                                        lose access to it
                                    </span>
                                    <div class="mt-4 mb-2">
                                        <button class="btn btn-primary">
                                            <i class="mdi mdi-telegram pr-1"></i>Open Telegram
                                        </button>
                                    </div>
                                </div>
                                <?PHP
                            }
                        ?>
                        <div class="row">
                            <div class="col-md-4 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-header header-sm d-flex justify-content-between align-items-center">
                                        <h4 class="card-title">Recent Actions</h4>
                                        <div class="dropdown">
                                            <button class="btn btn-transparent icon-btn dropdown-toggle arrow-disabled pr-0" type="button" id="recentActionsDropDown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="mdi mdi-dots-vertical"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="recentActionsDropDown">
                                                <a class="dropdown-item" href="<?PHP DynamicalWeb::getRoute('audit_logs', array(), true); ?>">View More</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="wrapper">
                                            <?PHP HTML::importScript('list_audit_logs'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-8 grid-margin">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 d-flex flex-column mb-4">
                                                <small class="text-muted d-none d-lg-block mb-3">Overview</small>
                                                <div class="mb-3">
                                                    <div class="d-flex align-items-center">
                                                        <h1 class="font-weight-medium mb-2">$<?PHP HTML::print($Account->Configuration->Balance); ?> USD</h1>
                                                    </div>
                                                    <div class="d-flex align-items-center">
                                                        <p class="text-muted mb-0 ml-1">
                                                            <a class="text-primary" href="<?PHP DynamicalWeb::getRoute('account_balance', array(), true); ?>">Manage Account Balance</a>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="border-top"></div>
                                                <div class="d-flex justify-content-between py-1 mt-2 mb-0">
                                                    <div class="wrapper">
                                                        <a class="mb-0 text-small text-black" href="<?PHP DynamicalWeb::getRoute('services', array(), true); ?>" style="text-decoration: none;">
                                                            <i class="mdi mdi-account-key pr-2"></i>
                                                            Manage Authorized Applications
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between py-1 mt-0 mb-0">
                                                    <div class="wrapper">
                                                        <a class="mb-0 text-small text-black" href="<?PHP DynamicalWeb::getRoute('applications', array(), true); ?>" style="text-decoration: none;">
                                                            <i class="mdi mdi-application pr-2"></i>
                                                            Manage Applications
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between py-1">
                                                    <div class="wrapper">
                                                        <a class="mb-0 text-small text-black" href="<?PHP DynamicalWeb::getRoute('login_history', array(), true); ?>" style="text-decoration: none;">
                                                            <i class="mdi mdi-history pr-2"></i>
                                                            View Login History
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <small class="text-muted ml-auto d-none d-lg-block mb-3">Account Security</small>
                                                <div class="d-flex justify-content-between py-2 border-bottom">

                                                    <div class="wrapper">
                                                        <p class="mb-0">Mobile Verification</p>
                                                        <h5 class="font-weight-medium">
                                                            <?PHP
                                                            HTML::print("<small class=\"posted-date\">", false);
                                                            if($Account->Configuration->VerificationMethods->TwoFactorAuthenticationEnabled)
                                                            {
                                                                $LastUpdated = $Account->Configuration->VerificationMethods->TwoFactorAuthentication->LastUpdated;
                                                                HTML::print(gmdate("F j, Y, g:i a", $LastUpdated));
                                                            }
                                                            else
                                                            {
                                                                HTML::print("Not Enabled");
                                                            }
                                                            HTML::print("</small>", false);
                                                            ?>
                                                        </h5>
                                                    </div>
                                                    <div class="wrapper d-flex flex-column align-items-center">
                                                        <?PHP
                                                        if($Account->Configuration->VerificationMethods->TwoFactorAuthenticationEnabled)
                                                        {
                                                            HTML::print("<div class=\"badge badge-success badge-pill\">", false);
                                                            HTML::print("Enabled");
                                                            HTML::print("</div>", false);
                                                        }
                                                        else
                                                        {
                                                            HTML::print("<div class=\"badge badge-danger badge-pill\">", false);
                                                            HTML::print("Disabled");
                                                            HTML::print("</div>", false);
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between py-2 border-bottom">
                                                    <div class="wrapper">
                                                        <p class="mb-0">Recovery Codes</p>
                                                        <h5 class="font-weight-medium">
                                                            <?PHP
                                                            HTML::print("<small class=\"posted-date\">", false);
                                                            if($Account->Configuration->VerificationMethods->RecoveryCodesEnabled)
                                                            {
                                                                $LastUpdated = $Account->Configuration->VerificationMethods->RecoveryCodes->LastUpdated;
                                                                HTML::print(gmdate("F j, Y, g:i a", $LastUpdated));
                                                            }
                                                            else
                                                            {
                                                                HTML::print("Not Enabled");
                                                            }
                                                            HTML::print("</small>", false);
                                                            ?>
                                                        </h5>
                                                    </div>
                                                    <div class="wrapper d-flex flex-column align-items-center">
                                                        <?PHP
                                                        if($Account->Configuration->VerificationMethods->RecoveryCodesEnabled)
                                                        {
                                                            HTML::print("<div class=\"badge badge-success badge-pill\">", false);
                                                            HTML::print("Enabled");
                                                            HTML::print("</div>", false);
                                                        }
                                                        else
                                                        {
                                                            HTML::print("<div class=\"badge badge-danger badge-pill\">", false);
                                                            HTML::print("Disabled");
                                                            HTML::print("</div>", false);
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between py-2 border-bottom">
                                                    <div class="wrapper">
                                                        <p class="mb-0">Telegram Verification</p>
                                                        <h5 class="font-weight-medium">
                                                            <?PHP
                                                            HTML::print("<small class=\"posted-date\">", false);
                                                            if($Account->Configuration->VerificationMethods->TelegramClientLinked)
                                                            {
                                                                $LastUpdated = $Account->Configuration->VerificationMethods->TelegramLink->LastLinked;
                                                                HTML::print(gmdate("F j, Y, g:i a", $LastUpdated));
                                                            }
                                                            else
                                                            {
                                                                HTML::print("Not Enabled");
                                                            }
                                                            HTML::print("</small>", false);
                                                            ?>
                                                        </h5>
                                                    </div>
                                                    <div class="wrapper d-flex flex-column align-items-center">
                                                        <?PHP
                                                        if($Account->Configuration->VerificationMethods->TelegramClientLinked)
                                                        {
                                                            HTML::print("<div class=\"badge badge-success badge-pill\">", false);
                                                            HTML::print("Enabled");
                                                            HTML::print("</div>", false);
                                                        }
                                                        else
                                                        {
                                                            HTML::print("<div class=\"badge badge-danger badge-pill\">", false);
                                                            HTML::print("Disabled");
                                                            HTML::print("</div>", false);
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="wrapper mt-4 d-flex d-lg-block">
                                                    <button class="btn btn-danger btn-block" onclick="location.href='<?PHP DynamicalWeb::getRoute('login_security', array(), true); ?>';">
                                                        <i class="mdi mdi-lock pr-1"></i>Manage Login Security
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <?PHP HTML::importSection('dashboard_footer'); ?>
                </div>
            </div>

        </div>
        <?PHP HTML::importSection('dashboard_js'); ?>
    </body>
</html>
