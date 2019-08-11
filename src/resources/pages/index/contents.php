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
        <?PHP HTML::importSection('dashboard_headers'); ?>
        <title>Intellivoid Accounts</title>
    </head>

    <body>
        <div class="container-scroller">
            <?PHP HTML::importSection("dashboard_navbar"); ?>
            <div class="container-fluid page-body-wrapper">
                <div class="main-panel container">
                    <div class="content-wrapper">

                        <div class="row">
                            <div class="col-12 grid-margin d-none d-lg-block">
                                <div class="intro-banner">
                                    <div class="banner-image">
                                        <img src="../assets/images/dashboard/banner_img.png" alt="banner image"> </div>
                                    <div class="content-area">
                                        <h3 class="mb-0">Welcome back, <?PHP HTML::print($UsernameSafe); ?>!</h3>
                                        <p class="mb-0">Need anything more to know more? Feel free to contact us at any point.</p>
                                    </div>
                                    <a href="https://intellivoid.info/contact" target="_blank" class="btn btn-light">Contact us</a>
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-4 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Account Checkup</h4>
                                        <div class="wrapper mt-4">
                                            <div class="d-flex align-items-center py-3 border-bottom">
                                                <i class="mdi mdi-telegram text-info"></i>
                                                <p class="mb-0 ml-3">Setup Telegram Authentication</p>
                                            </div>
                                            <div class="d-flex align-items-center py-3 border-bottom">
                                                <i class="mdi mdi-key text-info"></i>
                                                <p class="mb-0 ml-3">Setup Two Factor Authentication</p>
                                            </div>
                                            <div class="d-flex align-items-center py-3 border-bottom">
                                                <i class="mdi mdi-reload text-info"></i>
                                                <p class="mb-0 ml-3">Renew Recovery Codes</p>
                                            </div>
                                            <div class="d-flex align-items-center py-3 border-bottom">
                                                <i class="mdi mdi-account-alert text-info"></i>
                                                <p class="mb-0 ml-3">Review Recent Logins</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-8 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-8 d-flex flex-column"><div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                                                <div class="d-flex align-items-center pb-3">
                                                    <h4 class="card-title mb-0">Quick Access</h4>
                                                </div>
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="d-flex">
                                                            <i class="mdi mdi-bank icon-lg text-success d-flex align-items-center"></i>
                                                            <div class="d-flex flex-column ml-4">
                                                                <span class="d-flex flex-column">
                                                                    <p class="mb-0">Account Balance</p>
                                                                    <h4 class="font-weight-bold">$0</h4>
                                                                </span>
                                                                <small class="text-muted">
                                                                    <a href="/balance">Add money to your Account</a>
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="pb-4"></div>
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="d-flex">
                                                            <i class="mdi mdi-cart-outline icon-lg text-success d-flex align-items-center"></i>
                                                            <div class="d-flex flex-column ml-4">
                                                                <span class="d-flex flex-column">
                                                                    <p class="mb-0">Account Balance</p>
                                                                    <h4 class="font-weight-bold">$0</h4>
                                                                </span>
                                                                <small class="text-muted">
                                                                    <a href="/balance">Add money to your Account</a>
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="pb-4"></div>
                                            </div>
                                            <div class="col-md-4">
                                                <small class="text-muted ml-auto d-none d-lg-block mb-3">Updated at 08.32pm, Aug 2018</small>
                                                <div class="d-flex justify-content-between py-2 border-bottom">
                                                    <div class="wrapper">
                                                        <p class="mb-0">Marketing</p>
                                                        <h5 class="font-weight-medium">34%</h5>
                                                    </div>
                                                    <div class="wrapper d-flex flex-column align-items-center">
                                                        <small class="text-muted mb-2">2018</small>
                                                        <div class="badge badge-pill badge-danger">Mar</div>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between py-2 border-bottom">
                                                    <div class="wrapper">
                                                        <p class="mb-0">Develpment</p>
                                                        <h5 class="font-weight-medium">49%</h5>
                                                    </div>
                                                    <div class="wrapper d-flex flex-column align-items-center">
                                                        <small class="text-muted mb-2">2018</small>
                                                        <div class="badge badge-pill badge-warning">DVR</div>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between pt-2">
                                                    <div class="wrapper">
                                                        <p class="mb-0">Human Resources</p>
                                                        <h5 class="font-weight-medium">75%</h5>
                                                    </div>
                                                    <div class="wrapper d-flex flex-column align-items-center">
                                                        <small class="text-muted mb-2">2017</small>
                                                        <div class="badge badge-pill badge-success">H&amp;R</div>
                                                    </div>
                                                </div>
                                                <div class="wrapper mt-4 d-none d-lg-block">
                                                    <p class="text-muted">Note: These statistics are aggregates over all of your application's
                                                        users. </p>
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
