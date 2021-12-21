<?PHP
    use DynamicalWeb\HTML;
?>
<!DOCTYPE html>
<html class="loading" lang="<?PHP HTML::print(APP_LANGUAGE_ISO_639); ?>" data-textdirection="ltr">
    <head>
        <?PHP HTML::importSection('generic_headers'); ?>
        <title><?PHP HTML::print(TEXT_PAGE_TITLE); ?></title>
    </head>
    <body class="horizontal-layout horizontal-menu 2-columns navbar-sticky fixed-footer" data-open="hover" data-menu="horizontal-menu" data-col="2-columns">

        <?PHP HTML::importSection('generic_bhelper'); ?>
        <?PHP HTML::importSection('generic_nav'); ?>

        <div class="app-content content mb-0 pt-0" style="min-height: auto;">
            <?PHP HTML::importSection('main_chelper'); ?>
            <div class="content-wrapper">
                <div class="content-body">

                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="row mx-2 mt-3">
                                    <div class="d-flex">
                                        <i class="feather icon-alert-octagon text-danger d-flex align-items-center" style="font-size: 38px;"></i>
                                        <div class="d-flex flex-column ml-1">
                                            <h4 class="font-weight-bold"><?PHP HTML::print(TEXT_HEADER_TITLE); ?></h4>
                                            <small class="text-muted"><?PHP HTML::print(TEXT_SUB_HEADER); ?></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="border-top mt-3"></div>
                                <div class="row mx-2 my-3">
                                    <label for="error_details"><?PHP HTML::print(TEXT_PAGE_CONTENT); ?></label>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <?PHP HTML::importSection('generic_ehelper'); ?>
        <?PHP HTML::importSection('generic_footer'); ?>
        <?PHP HTML::importSection('generic_js'); ?>

    </body>
</html>