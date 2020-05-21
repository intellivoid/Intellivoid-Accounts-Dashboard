<?php

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use IntellivoidAccounts\Abstracts\ApplicationAccessStatus;
    use IntellivoidAccounts\Abstracts\SearchMethods\AccountSearchMethod;
    use IntellivoidAccounts\Abstracts\SearchMethods\ApplicationSearchMethod;
    use IntellivoidAccounts\IntellivoidAccounts;

    HTML::importScript('revoke_access');
    HTML::importScript('ren.contents');
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
                    <?PHP HTML::importScript('callbacks'); ?>
                    <section id="authorized_applications">
                        <div class="row">
                            <div class="col-md-4 col-lg-3 mb-2 mb-md-0" id="settings_sidebar">
                                <?PHP HTML::importSection('settings_sidebar'); ?>
                            </div>
                            <div class="col-md-8" id="settings_viewer">
                                <div class="card collapse-icon accordion-icon-rotate">
                                    <div class="card-header">
                                        <h4 class="card-title"><?PHP HTML::print(TEXT_PAGE_HEADER); ?></h4>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
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
                    </section>
                </div>
            </div>
        </div>

        <?PHP HTML::importSection('main_ehelper'); ?>
        <?PHP HTML::importSection('main_footer'); ?>
        <?PHP HTML::importSection('main_js'); ?>

    </body>
</html>