<?php

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use DynamicalWeb\Runtime;
    use IntellivoidAccounts\Objects\COA\Application;
    use IntellivoidAccounts\Objects\COA\AuthenticationAccess;

    Runtime::import('IntellivoidAccounts');
    HTML::importScript('validate_coa');
    HTML::importScript('validate_access_token');

    /** @var Application $Application */
    $Application = DynamicalWeb::getMemoryObject('application');

    /** @var AuthenticationAccess $AuthenticationAccess */
    $AuthenticationAccess = DynamicalWeb::getMemoryObject('access_token');

?>
<!DOCTYPE html>
<html class="loading" lang="<?PHP HTML::print(APP_LANGUAGE_ISO_639); ?>" data-textdirection="ltr">
    <head>
        <?PHP HTML::importSection('authentication_headers'); ?>
        <title><?PHP HTML::print(TEXT_PAGE_TITLE); ?></title>
    </head>
    <body class="horizontal-layout horizontal-menu 1-column navbar-floating footer-static blank-page blank-page area" data-open="hover" data-menu="horizontal-menu" data-col="1-column">
        <div class="app-content content" style="overflow: inherit;">
            <?PHP HTML::importSection('authentication_bhelper'); ?>
            <div class="content-wrapper mt-0">
                <?PHP HTML::importScript("expanded"); ?>
                <?PHP HTML::importSection('background_animations'); ?>
                <div class="content-body">
                    <?PHP
                        if(UI_EXPANDED)
                        {
                            HTML::importScript("card");
                        }
                        else
                        {
                            ?>
                            <section class="row flexbox-container mx-0">
                                <div class="col-xl-8 col-10 d-flex justify-content-center my-3">
                                    <div class="col-12 col-sm-10 col-md-11 col-lg-8 col-xl-7 p-0 mb-3">
                                        <?PHP HTML::importScript("card"); ?>
                                    </div>
                                </div>
                            </section>
                            <?PHP
                        }
                    ?>
                </div>
            </div>
            <?PHP HTML::importSection('change_language_modal'); ?>
        </div>
        <?PHP HTML::importSection('authentication_js'); ?>
    </body>
</html>