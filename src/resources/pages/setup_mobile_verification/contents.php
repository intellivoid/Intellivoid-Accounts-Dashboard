<?PHP

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
use DynamicalWeb\Javascript;

    HTML::importScript('check');
    HTML::importScript('verify');
    HTML::importScript('setup');
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
                            <div class="col-12 grid-margin">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title"><?PHP HTML::print(TEXT_CARD_HEADER); ?></h4>
                                        <form id="mobile-verification-wizard" action="<?PHP DynamicalWeb::getRoute('setup_mobile_verification', array('action' => 'verify'), true); ?>" method="POST">
                                            <div>
                                                <h3><?PHP HTML::print(TEXT_PART_1_TITLE); ?></h3>
                                                <section>
                                                    <h6><?PHP HTML::print(TEXT_PART_1_HEADER); ?></h6>
                                                    <p><?PHP HTML::print(TEXT_PART_1_BODY); ?></p>
                                                    <div class="row pl-4">
                                                        <div class="col-md-6 col-lg-6 grid-margin">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <div class="d-flex flex-row align-items-top">
                                                                        <i class="mdi mdi-google-play text-success icon-md"></i>
                                                                        <div class="ml-3">
                                                                            <h6 class="text-success"><?PHP HTML::print(TEXT_PART_1_PLAYSTORE); ?></h6>
                                                                            <a class="btn btn-block btn-success mt-2" target="_blank" href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2"><?PHP HTML::print(TEXT_PART_1_DOWNLOAD_BUTTON); ?></a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-6 grid-margin">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <div class="d-flex flex-row align-items-top">
                                                                        <i class="mdi mdi-apple-mobileme text-primary icon-md"></i>
                                                                        <div class="ml-3">
                                                                            <h6 class="text-primary"><?PHP HTML::print(TEXT_PART_1_APPSTORE); ?></h6>
                                                                            <a class="btn btn-block btn-primary mt-2" target="_blank" href="http://appstore.com/googleauthenticator"><?PHP HTML::print(TEXT_PART_1_DOWNLOAD_BUTTON); ?></a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </section>
                                                <h3><?PHP HTML::print(TEXT_PART_2_TITLE); ?></h3>
                                                <section>
                                                    <h6><?PHP HTML::print(TEXT_PART_2_HEADER); ?></h6>
                                                    <div class="form-group">
                                                        <img class="img-fluid d-block mx-auto mb-2 pt-3 border-primary" src="<?PHP HTML::print(SECURITY_QR_CODE, false); ?>">
                                                        <p class="text-muted text-center pt-2">
                                                            <?PHP HTML::print(TEXT_PART_2_HINT); ?> <code><?PHP HTML::print(SECURITY_SECRET_CODE); ?></code>
                                                        </p>
                                                    </div>
                                                </section>
                                                <h3><?PHP HTML::print(TEXT_PART_3_TITLE); ?></h3>
                                                <section>
                                                    <h6><?PHP HTML::print(TEXT_PART_3_HEADER); ?></h6>
                                                    <div class="form-group pt-5 pl-1 pr-1">
                                                        <label for="verification_code"><?PHP HTML::print(TEXT_PART_3_INPUT_LABEL); ?></label>
                                                        <input type="text" class="form-control" id="verification_code" name="verification_code" placeholder="123 456" required>
                                                    </div>
                                                </section>
                                            </div>
                                        </form>
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
        <?PHP Javascript::importScript('mobver'); ?>
    </body>
</html>
