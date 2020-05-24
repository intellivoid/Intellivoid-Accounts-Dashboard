<?php

    /** @noinspection PhpUndefinedConstantInspection */

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use DynamicalWeb\Runtime;
    use IntellivoidAccounts\IntellivoidAccounts;

    Runtime::import('IntellivoidAccounts');

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        if(isset($_GET['action']))
        {
            if($_GET['action'] == 'register_application')
            {
                HTML::importScript('register_application');
            }
        }
    }

    $UsernameSafe = ucfirst(WEB_ACCOUNT_USERNAME);
    if(strlen($UsernameSafe) > 16)
    {
        $UsernameSafe = substr($UsernameSafe, 0 ,16);
        $UsernameSafe .= "...";
    }
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
                        <div class="col-md-4 grid-margin">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title"><?PHP HTML::print(TEXT_ACTIONS_CARD_TITLE); ?></h4>
                                    <div class="wrapper mt-4">
                                        <a class="d-flex align-items-center py-3 text-black" data-toggle="modal" data-target="#create-application" style="text-decoration: none;" href="<?PHP ?>">
                                            <i class="mdi mdi-plus text-danger"></i>
                                            <p class="mb-0 ml-3"><?PHP HTML::print(TEXT_ACTIONS_CREATE_APPLICATION_LINK); ?></p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title"><?PHP HTML::print(TEXT_APPLICATIONS_CARD_TITLE); ?></h4>
                                    <p class="card-description"><?PHP HTML::print(TEXT_APPLICATIONS_CARD_DESCRIPTION); ?></p>
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

                                        $TotalRecords = $IntellivoidAccounts->getApplicationManager()->getRecords(WEB_ACCOUNT_ID);

                                        if(count($TotalRecords) == 0)
                                        {
                                            HTML::importScript('ren.no_contents');
                                        }
                                        else
                                        {
                                            HTML::importScript('ren.contents');
                                            render_items($TotalRecords);
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?PHP HTML::importScript('create_application_dialog'); ?>
        </div>

        <?PHP HTML::importSection('main_ehelper'); ?>
        <?PHP HTML::importSection('main_footer'); ?>
        <?PHP HTML::importSection('main_js'); ?>

    </body>
</html>