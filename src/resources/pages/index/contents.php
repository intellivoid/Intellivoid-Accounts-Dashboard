<?php

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

        <div class="app-content content">
            <?PHP HTML::importSection('main_chelper'); ?>
            <div class="content-wrapper">
                <div class="content-body">
                    <section id="header">
                        <div class="row">
                            <div class="col-12">
                                <div class="card bg-analytics text-white">
                                    <div class="card-content">
                                        <div class="card-body text-center">
                                            <img src="/assets/images/elements/decore-left.png" class="img-left" alt="card-img-left">
                                            <img src="/assets/images/elements/decore-right.png" class="img-right" alt="card-img-right">
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
                            <div class="col-lg-4 col-md-4 col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Activity Timeline</h4>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            <ul class="activity-timeline timeline-left list-unstyled">
                                                <li>
                                                    <div class="timeline-icon bg-primary">
                                                        <i class="feather icon-plus font-medium-2 align-middle"></i>
                                                    </div>
                                                    <div class="timeline-info">
                                                        <p class="font-weight-bold mb-0">Client Meeting</p>
                                                        <span class="font-small-3">Bonbon macaroon jelly beans gummi bears jelly lollipop apple</span>
                                                    </div>
                                                    <small class="text-muted">25 mins ago</small>
                                                </li>
                                                <li>
                                                    <div class="timeline-icon bg-warning">
                                                        <i class="feather icon-alert-circle font-medium-2 align-middle"></i>
                                                    </div>
                                                    <div class="timeline-info">
                                                        <p class="font-weight-bold mb-0">Email Newsletter</p>
                                                        <span class="font-small-3">Cupcake gummi bears soufflé caramels candy</span>
                                                    </div>
                                                    <small class="text-muted">15 days ago</small>
                                                </li>
                                                <li>
                                                    <div class="timeline-icon bg-danger">
                                                        <i class="feather icon-check font-medium-2 align-middle"></i>
                                                    </div>
                                                    <div class="timeline-info">
                                                        <p class="font-weight-bold mb-0">Plan Webinar</p>
                                                        <span class="font-small-3">Candy ice cream cake. Halvah gummi bears</span>
                                                    </div>
                                                    <small class="text-muted">20 days ago</small>
                                                </li>
                                                <li>
                                                    <div class="timeline-icon bg-success">
                                                        <i class="feather icon-check font-medium-2 align-middle"></i>
                                                    </div>
                                                    <div class="timeline-info">
                                                        <p class="font-weight-bold mb-0">Launch Website</p>
                                                        <span class="font-small-3">Candy ice cream cake. </span>
                                                    </div>
                                                    <small class="text-muted">25 days ago</small>
                                                </li>
                                                <li>
                                                    <div class="timeline-icon bg-primary">
                                                        <i class="feather icon-check font-medium-2 align-middle"></i>
                                                    </div>
                                                    <div class="timeline-info">
                                                        <p class="font-weight-bold mb-0">Marketing</p>
                                                        <span class="font-small-3">Candy ice cream. Halvah bears Cupcake gummi bears.</span>
                                                    </div>
                                                    <small class="text-muted">28 days ago</small>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-8 col-12">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="row pb-50">
                                                <div class="col-lg-6 col-12 d-flex justify-content-between flex-column order-lg-1 order-2 mt-lg-0 mt-2">
                                                    <div>
                                                        <h2 class="text-bold-700 mb-25">$0</h2>
                                                        <p class="text-bold-500 mb-75">Account Balance</p>
                                                    </div>
                                                    <a href="#" class="btn btn-primary shadow">View Details
                                                        <i class="feather icon-chevrons-right"></i>
                                                    </a>
                                                </div>
                                                <div class="col-lg-6 col-12 d-flex justify-content-between flex-column text-right order-lg-2 order-1">
                                                    <div class="dropdown chart-dropdown">
                                                        <button class="btn btn-sm border-0 dropdown-toggle p-0" type="button" id="dropdownItem5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            Last 7 Days
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownItem5">
                                                            <a class="dropdown-item" href="#">Last 28 Days</a>
                                                            <a class="dropdown-item" href="#">Last Month</a>
                                                            <a class="dropdown-item" href="#">Last Year</a>
                                                        </div>
                                                    </div>
                                                    <div id="avg-session-chart"></div>
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row avg-sessions pt-50">
                                                <div class="col-6">
                                                    <p class="mb-0">Goal: $100000</p>
                                                    <div class="progress progress-bar-primary mt-25">
                                                        <div class="progress-bar" role="progressbar" aria-valuenow="50" aria-valuemin="50" aria-valuemax="100" style="width:50%"></div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <p class="mb-0">Users: 100K</p>
                                                    <div class="progress progress-bar-warning mt-25">
                                                        <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="60" aria-valuemax="100" style="width:60%"></div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <p class="mb-0">Retention: 90%</p>
                                                    <div class="progress progress-bar-danger mt-25">
                                                        <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="70" aria-valuemax="100" style="width:70%"></div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <p class="mb-0">Duration: 1yr</p>
                                                    <div class="progress progress-bar-success mt-25">
                                                        <div class="progress-bar" role="progressbar" aria-valuenow="90" aria-valuemin="90" aria-valuemax="100" style="width:90%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-12 col-12">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <h1>Test</h1>
                                        </div>
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