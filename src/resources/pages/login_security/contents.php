<?PHP
    use DynamicalWeb\HTML;

    HTML::importScript('check');
    HTML::importScript('disable_mobile_verification');


    /** @var \IntellivoidAccounts\Objects\Account $Account */
    $Account = \DynamicalWeb\DynamicalWeb::getMemoryObject('account');
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
                                                <h2 class="card-title ml-3">Mobile Verification</h2>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="text-center pb-3">
                                            <?PHP
                                                if($Account->Configuration->VerificationMethods->TwoFactorAuthenticationEnabled)
                                                {
                                                    HTML::print("<div class=\"badge badge-lg badge-outline-success badge-pill\">", false);
                                                    HTML::print("Enabled");
                                                    HTML::print("</div>", false);
                                                }
                                                else
                                                {
                                                    HTML::print("<div class=\"badge badge-lg badge-outline-danger badge-pill\">", false);
                                                    HTML::print("Disabled");
                                                    HTML::print("</div>", false);
                                                }
                                            ?>
                                        </div>
                                        <p class="text-center mb-2 comment">
                                            Using Google Authenticator on your phone, you can enter a one-time password
                                            to verify it's you
                                        </p>
                                        <?PHP
                                            HTML::print("<small class=\"d-block mt-4 text-center posted-date\">", false);
                                            if($Account->Configuration->VerificationMethods->TwoFactorAuthenticationEnabled)
                                            {
                                                $LastUpdated = $Account->Configuration->VerificationMethods->TwoFactorAuthentication->LastUpdated;
                                                HTML::print(str_ireplace("%s", gmdate("F j, Y, g:i a", $LastUpdated), "Last Updated: %s"));
                                            }
                                            else
                                            {
                                                HTML::print(str_ireplace("%s", "Not Activated", "Last Updated: %s"));
                                            }
                                            HTML::print("</small>", false);
                                        ?>
                                    </div>
                                    <div class="card-footer align-content-center d-flex">
                                        <?PHP
                                        if($Account->Configuration->VerificationMethods->TwoFactorAuthenticationEnabled)
                                        {
                                            HTML::print("<button class=\"btn btn-danger btn-block\" data-toggle=\"modal\" data-target=\"#disable-mv\">", false);
                                            HTML::print("Disable");
                                            HTML::print("</button>", false);
                                        }
                                        else
                                        {
                                            HTML::print("<button class=\"btn btn-primary btn-block\" onclick=\"location.href='/setup_mobile_verification';\">", false);
                                            HTML::print("Setup");
                                            HTML::print("</button>", false);
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="disable-mv" tabindex="-1" role="dialog" aria-labelledby="disable-mv-label" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="disable-mv-label">Dsiable Mobile Verification</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">
                                                    <i class="mdi mdi-close"></i>
                                                </span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>
                                                Please confirm that you want to disable Mobile Verification, this will
                                                not disable the other methods of verification such as Recovery Codes.
                                                Those must be disabled separately
                                            </p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                                            <button type="button" class="btn btn-danger" onclick="location.href='/login_security?action=disable_mv';">Disable</button>
                                        </div>
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
                                        <button class="btn btn-primary btn-block">Setup</button>
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
