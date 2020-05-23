<?php

    /** @noinspection PhpUndefinedConstantInspection */

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use DynamicalWeb\Runtime;
    use IntellivoidAccounts\Abstracts\SearchMethods\AccountSearchMethod;
    use IntellivoidAccounts\Abstracts\SearchMethods\ApplicationSearchMethod;
    use IntellivoidAccounts\IntellivoidAccounts;
    use IntellivoidAccounts\Objects\TransactionRecord;

    HTML::importScript('cancel_subscription');
    HTML::importScript('ren.contents');

?>
<!DOCTYPE html>
<html class="loading" lang="<?PHP HTML::print(APP_LANGUAGE_ISO_639); ?>" data-textdirection="ltr">
    <head>
        <?PHP HTML::importSection('main_headers'); ?>
        <title><?PHP HTML::print(TEXT_PAGE_TITLE); ?></title>
    </head>
    <body class="horizontal-layout horizontal-menu 2-columns navbar-sticky fixed-footer" data-open="hover" data-menu="horizontal-menu" data-col="2-columns">

        <?PHP HTML::importSection('main_bhelper'); ?>
        <?PHP HTML::importSection('main_nav'); ?>
        <?PHP HTML::importSection('main_horizontal_menu'); ?>

        <div class="app-content content mb-0">
            <?PHP HTML::importSection('main_chelper'); ?>
            <div class="content-wrapper">
                <div class="content-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-body">
                                        <h4 class="card-title"><?PHP HTML::print(TEXT_PAGE_HEADER); ?></h4>
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
            </div>
        </div>

        <?PHP HTML::importSection('main_ehelper'); ?>
        <?PHP HTML::importSection('main_footer'); ?>
        <?PHP HTML::importSection('main_js'); ?>

    </body>
</html>