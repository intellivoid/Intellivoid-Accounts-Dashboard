<?PHP
    use DynamicalWeb\HTML;
?>
<!doctype html>
<html lang="<?PHP HTML::print(APP_LANGUAGE_ISO_639); ?>">
    <head>
        <?PHP HTML::importSection('gen_dashboard_headers'); ?>
        <title><?PHP HTML::print(TEXT_PAGE_TITLE); ?></title>
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
                                            <div class="d-flex">
                                                <i class="mdi mdi-alert-octagon icon-lg text-danger d-flex align-items-center"></i>
                                                <div class="d-flex flex-column ml-4">
                                                    <h4 class="font-weight-bold"><?PHP HTML::print(TEXT_HEADER_TITLE); ?></h4>
                                                    <small class="text-muted"><?PHP HTML::print(TEXT_SUB_HEADER); ?></small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="border-top mt-4"></div>
                                        <div class="row mt-5 ml-4 mr-4 mb-3">
                                            <p><?PHP HTML::print(TEXT_PAGE_CONTENT); ?></p>
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
