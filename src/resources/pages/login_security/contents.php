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
                            <div class="col-lg-12 grid-margin stretch-card">
                                <!--weather card-->
                                <div class="card card-weather">
                                    <div class="card-body">
                                        <div class="pt-3">
                                            <h3>Login Security</h3>
                                            <p class="text-gray">
                                                Secure your account even if somebody knows your password
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <!--weather card ends-->
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 grid-margin stretch-card">
                                <div class="card card-statistics social-card card-default">
                                    <div class="card-header header-sm">
                                        <div class="d-flex align-items-center">
                                            <div class="wrapper d-flex align-items-center media-info text-info">
                                                <i class="mdi mdi-cellphone-iphone icon-md"></i>
                                                <h2 class="card-title ml-3">Mobile Authentication</h2>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="text-center pb-3">
                                            <div class="badge badge-lg badge-outline-danger badge-pill">Disabled</div>
                                        </div>
                                        <p class="text-center mb-2 comment">
                                            Using Google Authenticator on your phone, you can enter a one-time password
                                            to verify it's you
                                        </p>
                                        <small class="d-block mt-4 text-center posted-date">Last Updated: Never</small>
                                    </div>
                                    <div class="card-footer align-content-center d-flex">
                                        <button class="btn btn-info btn-block">Setup</button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 grid-margin stretch-card">
                                <div class="card card-statistics social-card card-default">
                                    <div class="card-header header-sm">
                                        <div class="d-flex align-items-center">
                                            <div class="wrapper d-flex align-items-center media-info text-primary">
                                                <i class="mdi mdi-reload icon-md"></i>
                                                <h2 class="card-title ml-3">Recovery Codes</h2>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="text-center pb-3">
                                            <div class="badge badge-lg badge-outline-danger badge-pill">Disabled</div>
                                        </div>
                                        <p class="text-center mb-2 comment">
                                            If you lost your phone, or cannot access it. You can use one-time recovery
                                            codes to gain access to your account
                                        </p>
                                        <small class="d-block mt-4 text-center posted-date">Last Updated: Never</small>
                                    </div>
                                    <div class="card-footer align-content-center d-flex">
                                        <button class="btn btn-primary btn-block">Setup</button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 grid-margin stretch-card">
                                <div class="card card-statistics social-card card-default">
                                    <div class="card-header header-sm">
                                        <div class="d-flex align-items-center">
                                            <div class="wrapper d-flex align-items-center media-info text-danger">
                                                <i class="mdi mdi-telegram icon-md"></i>
                                                <h2 class="card-title ml-3">Telegram Verification</h2>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="text-center pb-3">
                                            <div class="badge badge-lg badge-outline-danger badge-pill">Disabled</div>
                                        </div>
                                        <p class="text-center mb-2 comment">
                                            Receive a notification on Telegram to verify your login authentication
                                        </p>
                                        <small class="d-block mt-4 text-center posted-date">Last Updated: Never</small>
                                    </div>
                                    <div class="card-footer align-content-center d-flex">
                                        <button class="btn btn-danger btn-block">Setup</button>
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
