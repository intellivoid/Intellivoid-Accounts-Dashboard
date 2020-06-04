<?php

    use DynamicalWeb\Actions;
    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use IntellivoidAccounts\Abstracts\SearchMethods\AccountSearchMethod;
    use IntellivoidAccounts\IntellivoidAccounts;

    HTML::importScript('coa_auth');
    HTML::importScript('telegram_auth');
    HTML::importScript('update_password');
    HTML::importScript('change_avatar');
    HTML::importScript('submit_report');

    if(isset($_GET['pwc_mcache']))
    {
        if($_GET['pwc_mcache'] == '1')
        {
            Actions::redirect(DynamicalWeb::getRoute('index', array('callback'=>'114')));
        }
    }
    
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
    DynamicalWeb::setMemoryObject('account', $Account);
?>
<!DOCTYPE html>
<html class="loading" lang="<?PHP HTML::print(APP_LANGUAGE_ISO_639); ?>" data-textdirection="ltr">
    <head>
        <?PHP HTML::importSection('main_headers'); ?>
        <title><?PHP HTML::print(TEXT_PAGE_TITLE); ?></title>
    </head>
    <body class="horizontal-layout horizontal-menu 2-columns navbar-sticky fixed-footer" data-open="hover" data-menu="horizontal-menu" data-col="2-columns">

        <?PHP HTML::importSection('main_bhelper'); ?>
        <?PHP HTML::importSection('main_nav'); ?>
        <?PHP HTML::importSection('main_horizontal_menu'); ?>

        <div class="app-content content mb-0">
            <?PHP HTML::importSection('main_chelper'); ?>
            <div class="content-wrapper">
                <div class="content-body">
                    <?PHP HTML::importScript('callbacks'); ?>
                    <section id="header">
                        <div class="row">
                            <div class="col-12 d-none d-lg-block">
                                <div class="card bg-analytics text-white">
                                    <div class="card-content">
                                        <div class="card-body text-center">
                                            <img src="/assets/images/decore-left.png" class="img-left" alt="card-img-left">
                                            <img src="/assets/images/decore-right.png" class="img-right" alt="card-img-right">
                                            <div class="text-center">
                                                <h1 class="mb-2 text-white"><?PHP HTML::print(str_ireplace("%s", $UsernameSafe, TEXT_WELCOME_BANNER_HEADER)); ?></h1>
                                                <p class="m-auto w-75"><?PHP HTML::print(TEXT_WELCOME_BANNER_SUB_HEADER); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <section id="general">
                        <div class="row">
                            <div class="col-lg-4 col-md-12 col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title"><?PHP HTML::print(TEXT_RECENT_ACTIONS_CARD_TITLE); ?></h4>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            <?PHP HTML::importScript('list_audit_logs'); ?>
                                        </div>
                                    </div>
                                    <div class="card-footer text-muted bg-white">
                                        <span class="float-right">
                                            <a href="<?PHP DynamicalWeb::getRoute('audit_log', array(), true); ?>" class="card-link"><?PHP HTML::print(TEXT_RECENT_ACTIONS_CARD_DROPDOWN_VIEW_MORE); ?>
                                                <i class="fa fa-angle-right"></i>
                                            </a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-12 col-12">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="row pb-50">
                                                <div class="col-xl-6 col-12 d-flex justify-content-between flex-column order-lg-1 order-2 mt-lg-0 mt-2">
                                                    <div>
                                                        <h2 class="text-bold-700 mb-25">$<?PHP HTML::print($Account->Configuration->Balance); ?> USD</h2>
                                                        <p class="text-bold-500 mb-75"><?PHP HTML::print(TEXT_ACCOUNT_BALANCE_TEXT); ?></p>
                                                    </div>
                                                    <a href="<?PHP DynamicalWeb::getRoute('finance_balance', array(), true); ?>" class="btn btn-primary shadow"><?PHP HTML::print(TEXT_ACCOUNT_BALANCE_MANAGE_BUTTON); ?>
                                                        <i class="feather icon-chevrons-right"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <?PHP HTML::importScript('recent_transactions'); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-12 col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title"><?PHP HTML::print(TEXT_ACCOUNT_SECURITY); ?></h4>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between py-1 border-bottom">
                                                <div class="wrapper">
                                                    <p class="mb-0"><?PHP HTML::print(TEXT_ACCOUNT_SECURITY_MOBILE_VERIFICATION); ?></p>
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
                                                            HTML::print(TEXT_ACCOUNT_SECURITY_NOT_ENABLED);
                                                        }
                                                        HTML::print("</small>", false);
                                                        ?>
                                                    </h5>
                                                </div>
                                                <div class="wrapper d-flex flex-column align-items-center">
                                                    <?PHP
                                                    if($Account->Configuration->VerificationMethods->TwoFactorAuthenticationEnabled)
                                                    {
                                                        HTML::print("<div class=\"badge badge-primary badge-pill\">", false);
                                                        HTML::print(TEXT_ACCOUNT_SECURITY_ENABLED);
                                                        HTML::print("</div>", false);
                                                    }
                                                    else
                                                    {
                                                        HTML::print("<div class=\"badge badge-danger badge-pill\">", false);
                                                        HTML::print(TEXT_ACCOUNT_SECURITY_DISABLED);
                                                        HTML::print("</div>", false);
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between py-1 border-bottom">
                                                <div class="wrapper">
                                                    <p class="mb-0"><?PHP HTML::print(TEXT_ACCOUNT_SECURITY_RECOVERY_CODES); ?></p>
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
                                                            HTML::print(TEXT_ACCOUNT_SECURITY_NOT_ENABLED);
                                                        }
                                                        HTML::print("</small>", false);
                                                        ?>
                                                    </h5>
                                                </div>
                                                <div class="wrapper d-flex flex-column align-items-center">
                                                    <?PHP
                                                    if($Account->Configuration->VerificationMethods->RecoveryCodesEnabled)
                                                    {
                                                        HTML::print("<div class=\"badge badge-primary badge-pill\">", false);
                                                        HTML::print(TEXT_ACCOUNT_SECURITY_ENABLED);
                                                        HTML::print("</div>", false);
                                                    }
                                                    else
                                                    {
                                                        HTML::print("<div class=\"badge badge-danger badge-pill\">", false);
                                                        HTML::print(TEXT_ACCOUNT_SECURITY_DISABLED);
                                                        HTML::print("</div>", false);
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between pt-1">
                                                <div class="wrapper">
                                                    <p class="mb-0"><?PHP HTML::print(TEXT_ACCOUNT_SECURITY_TELEGRAM_VERIFICATION); ?></p>
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
                                                            HTML::print(TEXT_ACCOUNT_SECURITY_NOT_ENABLED);
                                                        }
                                                        HTML::print("</small>", false);
                                                        ?>
                                                    </h5>
                                                </div>
                                                <div class="wrapper d-flex flex-column align-items-center">
                                                    <?PHP
                                                    if($Account->Configuration->VerificationMethods->TelegramClientLinked)
                                                    {
                                                        HTML::print("<div class=\"badge badge-primary badge-pill\">", false);
                                                        HTML::print(TEXT_ACCOUNT_SECURITY_ENABLED);
                                                        HTML::print("</div>", false);
                                                    }
                                                    else
                                                    {
                                                        HTML::print("<div class=\"badge badge-danger badge-pill\">", false);
                                                        HTML::print(TEXT_ACCOUNT_SECURITY_DISABLED);
                                                        HTML::print("</div>", false);
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer text-muted bg-white">
                                        <span class="float-right">
                                            <a href="<?PHP DynamicalWeb::getRoute('settings_login_security', array(), true); ?>" class="card-link"><?PHP HTML::print(TEXT_ACCOUNT_SETTINGS); ?>
                                                <i class="fa fa-angle-right"></i>
                                            </a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>

        <?PHP HTML::importSection('main_ehelper'); ?>
        <?PHP HTML::importSection('main_footer'); ?>
        <?PHP HTML::importSection('main_js'); ?>

    </body>
</html>