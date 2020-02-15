<?PHP

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use IntellivoidAccounts\Abstracts\ApplicationAccessStatus;
    use IntellivoidAccounts\Abstracts\SearchMethods\ApplicationSearchMethod;
    use IntellivoidAccounts\IntellivoidAccounts;

    HTML::importScript('revoke_access');
    HTML::importScript('ren.contents');

?>
<!doctype html>
<html lang="<?PHP HTML::print(APP_LANGUAGE_ISO_639); ?>">
    <head>
        <?PHP HTML::importSection('dashboard_headers'); ?>
        <title><?PHP HTML::print(TEXT_PAGE_TITLE); ?></title>
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
                                        <h4 class="card-title"><?PHP HTML::print(TEXT_CARD_HEADER); ?></h4>
                                        <p class="card-description text-muted"><?PHP HTML::print(TEXT_CARD_SUB_HEADER); ?></p>
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

                                                $ApplicationAccessRecords = $IntellivoidAccounts->getCrossOverAuthenticationManager()->getApplicationAccessManager()->searchRecordsByAccount(WEB_ACCOUNT_ID);
                                                $TotalAccessCount = 0;
                                                $Applications = array();

                                                if(count($ApplicationAccessRecords) > 0)
                                                {
                                                    foreach($ApplicationAccessRecords as $record)
                                                    {
                                                        if($record['status'] == ApplicationAccessStatus::Authorized)
                                                        {
                                                            $TotalAccessCount += 1;

                                                            try
                                                            {
                                                                $Application = $IntellivoidAccounts->getApplicationManager()->getApplication(ApplicationSearchMethod::byId, $record['application_id']);
                                                                $Applications[$record['application_id']] = $Application;
                                                            }
                                                            catch (Exception $e)
                                                            {
                                                                unset($e);
                                                                $TotalAccessCount -= 1;
                                                                continue;
                                                            }
                                                        }
                                                    }
                                                }

                                                if($TotalAccessCount > 0)
                                                {
                                                    list_authorized_services($ApplicationAccessRecords, $Applications);
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
