<?PHP
    /** @noinspection PhpUndefinedConstantInspection */
    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
?>
<!doctype html>
<html lang="<?PHP HTML::print(APP_LANGUAGE_ISO_639); ?>">
    <head>
        <?PHP HTML::importSection('generic_headers'); ?>
        <title><?PHP HTML::print(TEXT_PAGE_TITLE); ?></title>
    <body>
        <div class="container-scroller">
            <div class="container-fluid page-body-wrapper full-page-wrapper">
                <div class="content-wrapper d-flex align-items-center text-center error-page bg-info">
                    <div class="row flex-grow">
                        <div class="col-lg-7 mx-auto text-white">
                            <div class="row align-items-center d-flex flex-row">
                                <div class="col-lg-6 text-lg-right pr-lg-4">
                                    <h1 class="display-1 mb-0 animated slow fadeInLeft"><?PHP HTML::print(TEXT_HEADER); ?><h1>
                                </div>
                                <div class="col-lg-6 error-page-divider text-lg-left pl-lg-4">
                                    <h2 class="animated fadeInDown"><?PHP HTML::print(TEXT_SUB_HEADER); ?></h2>
                                    <h3 class="font-weight-light animated fadeInRight"><?PHP HTML::print(TEXT_MESSAGE); ?></h3>
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class="col-12 text-center mt-xl-2">
                                    <a class="text-white font-weight-medium animated slower fadeIn" href="<?PHP DynamicalWeb::getRoute('index', array(), true); ?>"><?PHP HTML::print(TEXT_HOME_LINK); ?></a>
                                </div>
                            </div>
                            <div class="row mt-5 animated fadeInUp">
                                <div class="col-12 mt-xl-2">
                                    <p class="text-white font-weight-medium text-center">Copyright &copy; 2017-<?PHP HTML::print(date('Y')); ?> Intellivoid Technologies All rights reserved.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?PHP HTML::importSection('generic_js'); ?>
    </body>
</html>
