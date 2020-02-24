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
        <title><?PHP HTML::print(TEXT_PAGE_TITLE); ?></title>
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
                                        <h3 class="mb-0"><?PHP HTML::print(str_ireplace('%s', $UsernameSafe, TEXT_WELCOME_BANNER_HEADER)); ?></h3>
                                        <p class="mb-0"><?PHP HTML::print(TEXT_WELCOME_BANNER_SUB_HEADER); ?></p>
                                    </div>
                                    <a href="#" data-toggle="modal" data-target="#feedback_dialog" class="btn btn-light ml-5"><?PHP HTML::print(TEXT_WELCOME_BANNER_CONTACT_BUTTON); ?></a>
                                </div>
                            </div>
                        </div>
                        <?PHP
                            if($Account->Configuration->VerificationMethods->TelegramClientLinked == false)
                            {
                                ?>
                                <div class="alert alert-fill-light border-dark" role="alert">
                                    <h4 class="text-black mb-3">
                                        <i class="mdi mdi-24px mdi-lock-plus text-black"></i> <?PHP HTML::print(TEXT_ACCOUNT_SECURITY_ALERT_TITLE); ?>
                                    </h4>
                                    <span class="text-black"><?PHP HTML::print(TEXT_ACCOUNT_SECURITY_ALERT_MESSAGE); ?></span>
                                    <div class="mt-4 mb-2">
                                        <button class="btn btn-primary" onclick="location.href='tg://resolve?domain=IntellivoidBot&start=link';">
                                            <i class="mdi mdi-telegram pr-1"></i> <?PHP HTML::print(TEXT_ACCOUNT_SECURITY_OPEN_TELEGRAM_BUTTON); ?>
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
                                        <h4 class="card-title"><?PHP HTML::print(TEXT_RECENT_ACTIONS_CARD_TITLE); ?></h4>
                                        <div class="dropdown">
                                            <button class="btn btn-transparent icon-btn dropdown-toggle arrow-disabled pr-0" type="button" id="recentActionsDropDown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="mdi mdi-dots-vertical"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="recentActionsDropDown">
                                                <a class="dropdown-item" href="<?PHP DynamicalWeb::getRoute('audit_logs', array(), true); ?>"><?PHP HTML::print(TEXT_RECENT_ACTIONS_CARD_DROPDOWN_VIEW_MORE); ?></a>
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
                                                <small class="text-muted d-none d-lg-block mb-3"><?PHP HTML::print(TEXT_OVERVIEW_CARD_TITLE); ?></small>
                                                <div class="mb-3">
                                                    <div class="d-flex align-items-center">
                                                        <h1 class="font-weight-medium mb-2">$<?PHP HTML::print($Account->Configuration->Balance); ?> USD</h1>
                                                    </div>
                                                    <div class="d-flex align-items-center">
                                                        <p class="text-muted mb-0 ml-1">
                                                            <a class="text-primary" href="<?PHP DynamicalWeb::getRoute('account_balance', array(), true); ?>"><?PHP HTML::print(TEXT_OVERVIEW_CARD_ACCOUNT_BALANCE_MANAGE_LINK); ?></a>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="border-top"></div>
                                                <div class="d-flex justify-content-between py-1 mt-2 mb-0">
                                                    <div class="wrapper">
                                                        <a class="mb-0 text-small text-black" href="<?PHP DynamicalWeb::getRoute('services', array(), true); ?>" style="text-decoration: none;">
                                                            <i class="mdi mdi-account-key pr-2"></i> <?PHP HTML::print(TEXT_OVERVIEW_CARD_QUICK_ACTIONS_MANAGE_AUTHORIZED_APPLICATIONS); ?>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between py-1 mt-0 mb-0">
                                                    <div class="wrapper">
                                                        <a class="mb-0 text-small text-black" href="<?PHP DynamicalWeb::getRoute('applications', array(), true); ?>" style="text-decoration: none;">
                                                            <i class="mdi mdi-application pr-2"></i> <?PHP HTML::print(TEXT_OVERVIEW_CARD_QUICK_ACTIONS_MANAGE_APPLICATIONS); ?>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between py-1">
                                                    <div class="wrapper">
                                                        <a class="mb-0 text-small text-black" href="<?PHP DynamicalWeb::getRoute('login_history', array(), true); ?>" style="text-decoration: none;">
                                                            <i class="mdi mdi-history pr-2"></i> <?PHP HTML::print(TEXT_OVERVIEW_CARD_QUICK_ACTIONS_VIEW_LOGIN_HISTORY); ?>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <small class="text-muted ml-auto d-none d-lg-block mb-3"><?PHP HTML::print(TEXT_OVERVIEW_CARD_ACCOUNT_SECURITY); ?></small>
                                                <div class="d-flex justify-content-between py-2 border-bottom">
                                                    <div class="wrapper">
                                                        <p class="mb-0"><?PHP HTML::print(TEXT_OVERVIEW_CARD_ACCOUNT_SECURITY_MOBILE_VERIFICATION); ?></p>
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
                                                                HTML::print(TEXT_OVERVIEW_CARD_ACCOUNT_SECURITY_NOT_ENABLED);
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
                                                            HTML::print(TEXT_OVERVIEW_CARD_ACCOUNT_SECURITY_ENABLED);
                                                            HTML::print("</div>", false);
                                                        }
                                                        else
                                                        {
                                                            HTML::print("<div class=\"badge badge-danger badge-pill\">", false);
                                                            HTML::print(TEXT_OVERVIEW_CARD_ACCOUNT_SECURITY_DISABLED);
                                                            HTML::print("</div>", false);
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between py-2 border-bottom">
                                                    <div class="wrapper">
                                                        <p class="mb-0"><?PHP HTML::print(TEXT_OVERVIEW_CARD_ACCOUNT_SECURITY_RECOVERY_CODES); ?></p>
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
                                                                HTML::print(TEXT_OVERVIEW_CARD_ACCOUNT_SECURITY_NOT_ENABLED);
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
                                                            HTML::print(TEXT_OVERVIEW_CARD_ACCOUNT_SECURITY_ENABLED);
                                                            HTML::print("</div>", false);
                                                        }
                                                        else
                                                        {
                                                            HTML::print("<div class=\"badge badge-danger badge-pill\">", false);
                                                            HTML::print(TEXT_OVERVIEW_CARD_ACCOUNT_SECURITY_DISABLED);
                                                            HTML::print("</div>", false);
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between py-2 border-bottom">
                                                    <div class="wrapper">
                                                        <p class="mb-0"><?PHP HTML::print(TEXT_OVERVIEW_CARD_ACCOUNT_SECURITY_TELEGRAM_VERIFICATION); ?></p>
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
                                                                HTML::print(TEXT_OVERVIEW_CARD_ACCOUNT_SECURITY_NOT_ENABLED);
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
                                                            HTML::print(TEXT_OVERVIEW_CARD_ACCOUNT_SECURITY_ENABLED);
                                                            HTML::print("</div>", false);
                                                        }
                                                        else
                                                        {
                                                            HTML::print("<div class=\"badge badge-danger badge-pill\">", false);
                                                            HTML::print(TEXT_OVERVIEW_CARD_ACCOUNT_SECURITY_DISABLED);
                                                            HTML::print("</div>", false);
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="wrapper mt-4 d-flex d-lg-block">
                                                    <button class="btn btn-danger btn-block" onclick="location.href='<?PHP DynamicalWeb::getRoute('login_security', array(), true); ?>';">
                                                        <i class="mdi mdi-lock pr-1"></i><?PHP HTML::print(TEXT_OVERVIEW_CARD_ACCOUNT_SECURITY_MANAGE_BUTTON); ?>
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
