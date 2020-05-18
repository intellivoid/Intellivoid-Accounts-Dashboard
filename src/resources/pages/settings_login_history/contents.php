<?php

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;

    HTML::importScript('get_records');
?>
<!DOCTYPE html>
<html class="loading" lang="<?PHP HTML::print(APP_LANGUAGE_ISO_639); ?>" data-textdirection="ltr">
    <head>
        <?PHP HTML::importSection('main_headers'); ?>
        <title><?PHP HTML::print(TEXT_PAGE_TITLE) ?></title>
    </head>
    <body class="horizontal-layout horizontal-menu 2-columns navbar-sticky fixed-footer" data-open="hover" data-menu="horizontal-menu" data-col="2-columns">

        <?PHP HTML::importSection('main_bhelper'); ?>
        <?PHP HTML::importSection('main_nav'); ?>
        <?PHP HTML::importSection('main_horizontal_menu'); ?>

        <div class="app-content content mb-0">
            <?PHP HTML::importSection('main_chelper'); ?>
            <div class="content-wrapper">
                <div class="content-body">
                    <section id="account_settings">
                        <div class="row">
                            <div class="col-md-3 mb-2 mb-md-0">
                                <?PHP HTML::importSection('settings_sidebar'); ?>
                            </div>
                            <div class="col-md-9">
                                <div class="card">
                                    <form method="POST" action="<?PHP DynamicalWeb::getRoute('index', array('action' => 'update_password', 'redirect' => 'settings_password'), true) ?>">
                                        <div class="card-header">
                                            <h4 class="card-title"><?PHP HTML::print(TEXT_PAGE_HEADER); ?></h4>
                                        </div>
                                        <div class="card-content">
                                            <div class="card-body">
                                                <?PHP
                                                    if(count(DynamicalWeb::getArray('search_results')) == 0)
                                                    {
                                                        HTML::importScript('no_items_msg');
                                                    }
                                                    else
                                                    {
                                                        HTML::importScript('render_table');
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                    </form>
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