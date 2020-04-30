<?php
    use DynamicalWeb\HTML;
?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
    <head>
        <?PHP HTML::importSection('mayax_dashboard_headers'); ?>
        <title>Blank Page</title>
    </head>
    <body class="horizontal-layout horizontal-menu 2-columns navbar-sticky fixed-footer" data-open="hover" data-menu="horizontal-menu" data-col="2-columns">

        <?PHP HTML::importSection('mayax_dashboard_bhelper'); ?>
        <?PHP HTML::importSection('mayax_dashboard_nav'); ?>
        <?PHP HTML::importSection('mayax_dashboard_horizontal_menu'); ?>

        <div class="app-content content">
            <?PHP HTML::importSection('mayax_dashboard_chelper'); ?>
            <div class="content-wrapper">
                <div class="content-body">
                    <section id="description" class="card">
                        <div class="card-header">
                            <h4 class="card-title">Lorem ipsum</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="card-text">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>

        <?PHP HTML::importSection('mayax_dashboard_ehelper'); ?>
        <?PHP HTML::importSection('mayax_dashboard_footer'); ?>
        <?PHP HTML::importSection('mayax_dashboard_js'); ?>

    </body>
</html>