<?PHP
use DynamicalWeb\HTML;
?>
<!doctype html>
<html lang="<?PHP HTML::print(APP_LANGUAGE_ISO_639); ?>">
    <head>
        <?PHP HTML::importSection('gen_dashboard_headers'); ?>
        <title>Intellivoid Accounts - COA Error</title>
    </head>

    <body>
        <div class="container-scroller">
            <?PHP HTML::importSection("gen_dashboard_navbar"); ?>
            <div class="container-fluid page-body-wrapper">
                <div class="main-panel container">
                    <div class="content-wrapper">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row ml-4 mr-4 mt-3">
                                            <div class="d-flex mb-3">
                                                <i class="mdi mdi-check-circle icon-lg text-success d-flex align-items-center"></i>
                                                <div class="d-flex flex-column ml-4">
                                                    <h4 class="font-weight-bold">Payment Successful</h4>
                                                    <small class="text-muted">
                                                        Intellivoid is now going to process your transaction, this may take up to 48 hours.
                                                    </small>
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
        <?PHP HTML::importSection('gen_dashboard_js'); ?>
    </body>
</html>
