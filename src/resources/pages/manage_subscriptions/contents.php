<?PHP

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use IntellivoidAccounts\Abstracts\ApplicationAccessStatus;
use IntellivoidAccounts\Abstracts\SearchMethods\ApplicationSearchMethod;
use IntellivoidAccounts\Exceptions\ApplicationNotFoundException;
use IntellivoidAccounts\IntellivoidAccounts;

    HTML::importScript('revoke_access');
    HTML::importScript('ren.contents');

?>
<!doctype html>
<html lang="<?PHP HTML::print(APP_LANGUAGE_ISO_639); ?>">
    <head>
        <?PHP HTML::importSection('dashboard_headers'); ?>
        <title>Intellivoid Accounts - Manage Subscriptions</title>
    </head>

    <body>
        <div class="container-scroller">
            <?PHP HTML::importSection("dashboard_navbar"); ?>
            <div class="container-fluid page-body-wrapper">
                <div class="main-panel container">
                    <div class="content-wrapper">
                        <div class="row">
                            <div class="col-lg-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Subscriptions</h4>
                                        <div class="wrapper mt-4">
                                            <?PHP HTML::importScript('callbacks'); ?>

                                            <?PHP
                                                if(isset(DynamicalWeb::$globalObjects["intellivoid_accounts"]) == false)
                                                {
                                                    /** @var IntellivoidAccounts $IntellivoidAccounts */
                                                    $IntellivoidAccounts = DynamicalWeb::setMemoryObject(
                                                        "intellivoid_accounts", new IntellivoidAccounts()
                                                    );
                                                }
                                                else
                                                {
                                                    /** @var IntellivoidAccounts $IntellivoidAccounts */
                                                    $IntellivoidAccounts = DynamicalWeb::getMemoryObject("intellivoid_accounts");
                                                }

                                                $Subscriptions = $IntellivoidAccounts->getSubscriptionManager()->getSubscriptionsByAccountID(
                                                        WEB_ACCOUNT_ID
                                                );


                                                if(count($Subscriptions) > 0)
                                                {
                                                    list_subscribed_services($Subscriptions);
                                                }
                                                else
                                                {
                                                    HTML::importScript('ren.no_contents');
                                                }
                                            ?>

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
        <?PHP HTML::importSection('dashboard_js'); ?>
    </body>
</html>
