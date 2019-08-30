<?PHP

use DynamicalWeb\DynamicalWeb;
use DynamicalWeb\HTML;
use IntellivoidAccounts\Objects\Account;

/** @var Account $Account */
    $Account = DynamicalWeb::getMemoryObject('account');

    HTML::importScript('get_records');
?>
<!doctype html>
<html lang="<?PHP HTML::print(APP_LANGUAGE_ISO_639); ?>">
    <head>
        <?PHP HTML::importSection('dashboard_headers'); ?>
        <link rel="stylesheet" href="/assets/vendors/iconfonts/flag-icon-css/css/flag-icon.min.css">
        <title>Intellivoid Accounts</title>
    </head>

    <body>
        <div class="container-scroller">
            <?PHP HTML::importSection("dashboard_navbar"); ?>
            <div class="container-fluid page-body-wrapper">
                <div class="main-panel container">
                    <div class="content-wrapper">
                        <?PHP HTML::importScript('callbacks'); ?>

                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Login History</h4>
                                    <p class="card-description"> Review what devices you logged in with and when </p>
                                    <div class="row">
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
                                <?PHP HTML::importScript('render_navigation'); ?>
                            </div>
                        </div>


                    </div>
                    <?PHP HTML::importSection('dashboard_footer'); ?>
                </div>
            </div>

        </div>
        <?PHP HTML::importSection('dashboard_js'); ?>
        <script src="/assets/js/shared/tooltips.js"></script>
        <script src="/assets/js/shared/popover.js"></script>
    </body>
</html>
