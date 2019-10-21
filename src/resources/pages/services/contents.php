<?PHP

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use DynamicalWeb\Runtime;
use IntellivoidAccounts\Abstracts\ApplicationAccessStatus;
use IntellivoidAccounts\IntellivoidAccounts;

    HTML::importScript('ren.contents');

?>
<!doctype html>
<html lang="<?PHP HTML::print(APP_LANGUAGE_ISO_639); ?>">
    <head>
        <?PHP HTML::importSection('dashboard_headers'); ?>
        <title>Intellivoid Accounts</title>
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
                                        <h4 class="card-title">Services</h4>
                                        <p class="card-description text-muted">Services and Applications you've authenticated to using this Intellivoid Account</p>
                                        <div class="wrapper mt-4">

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

                                                $ApplicationAccessRecords = $IntellivoidAccounts->getCrossOverAuthenticationManager()->getApplicationAccessManager()->searchRecordsByAccount(WEB_ACCOUNT_ID);
                                                $TotalAccessCount = 0;

                                                if(count($ApplicationAccessRecords) > 0)
                                                {
                                                    foreach($ApplicationAccessRecords as $record)
                                                    {
                                                        if($record['status'] == ApplicationAccessStatus::Authorized)
                                                        {
                                                            $TotalAccessCount += 1;
                                                        }
                                                    }
                                                }

                                                if($TotalAccessCount > 0)
                                                {
                                                    list_authorized_services($ApplicationAccessRecords);
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
