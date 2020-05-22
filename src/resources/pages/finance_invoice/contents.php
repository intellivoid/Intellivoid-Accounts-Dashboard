<?php

    /** @noinspection PhpUndefinedConstantInspection */

    use DynamicalWeb\Actions;
    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use DynamicalWeb\Runtime;
    use IntellivoidAccounts\Abstracts\SearchMethods\AccountSearchMethod;
    use IntellivoidAccounts\Abstracts\SearchMethods\ApplicationSearchMethod;
    use IntellivoidAccounts\Abstracts\SearchMethods\TransactionLogSearchMethod;
    use IntellivoidAccounts\IntellivoidAccounts;

    Runtime::import('IntellivoidAccounts');

    $TransactionPublicID = $_GET['transaction_id'];

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

    try
    {
        $TransactionRecord = $IntellivoidAccounts->getTransactionRecordManager()->getTransactionRecord(
            TransactionLogSearchMethod::byPublicId, $TransactionPublicID
        );
    }
    catch(Exception $e)
    {
        Actions::redirect(DynamicalWeb::getRoute('index'));
    }


    if($TransactionRecord->AccountID !== WEB_ACCOUNT_ID)
    {
        Actions::redirect(DynamicalWeb::getRoute('index'));
    }

    if($TransactionRecord->Amount == 0)
    {
        $TransactionRecord->Amount = 0;
    }


?>
<!DOCTYPE html>
<html class="loading" lang="<?PHP HTML::print(APP_LANGUAGE_ISO_639); ?>" data-textdirection="ltr">
    <head>
        <?PHP HTML::importSection('main_headers'); ?>
        <title><?PHP HTML::print(str_ireplace('%s', $TransactionRecord->ID, TEXT_PAGE_TITLE)); ?></title>
    </head>
    <body class="horizontal-layout horizontal-menu 2-columns navbar-sticky fixed-footer" data-open="hover" data-menu="horizontal-menu" data-col="2-columns">

        <?PHP HTML::importSection('main_bhelper'); ?>
        <?PHP HTML::importSection('main_nav'); ?>
        <?PHP HTML::importSection('main_horizontal_menu'); ?>

        <div class="app-content content mb-0">
            <?PHP HTML::importSection('main_chelper'); ?>
            <div class="content-wrapper">
                <div class="content-body">
                    <section class="card invoice-page">
                        <div id="invoice-template" class="card-body">
                            <?PHP
                                $FromAccount = null;
                                $FromApplication = null;

                                try
                                {
                                    $FromApplication = $IntellivoidAccounts->getApplicationManager()->getApplication(
                                        ApplicationSearchMethod::byName,
                                        substr($TransactionRecord->Vendor, 0, strpos($TransactionRecord->Vendor, ' '))
                                    );
                                }
                                catch(Exception $e)
                                {
                                    $FromApplication = null;
                                }

                                try
                                {
                                    $FromAccount = $IntellivoidAccounts->getAccountManager()->getAccount(
                                        AccountSearchMethod::byUsername, $TransactionRecord->Vendor
                                    );
                                }
                                catch(Exception $e)
                                {
                                    $FromAccount = null;
                                }
                            ?>
                            <!-- Invoice Company Details -->
                            <div id="invoice-company-details" class="row">
                                <div class="col-sm-6 col-12 text-left pt-1">
                                    <div class="media pt-1">
                                        <?PHP
                                            if($FromApplication !== null)
                                            {
                                                $ImageSource = DynamicalWeb::getRoute('application_icon', array(
                                                    'app_id' => $FromApplication->PublicAppId,
                                                    'resource'=> 'normal'
                                                ));
                                            }
                                            elseif($FromAccount !== null)
                                            {
                                                $ImageSource = DynamicalWeb::getRoute('avatar', array(
                                                    'user_id' => $FromAccount->PublicID,
                                                    'resource' => 'normal'
                                                ));
                                            }
                                        ?>
                                        <img src="<?PHP HTML::print($ImageSource, false); ?>" height="78" width="78" alt="company logo" />
                                    </div>
                                </div>
                                <div class="col-sm-6 col-12 text-right">
                                    <h1><?PHP HTML::print(str_ireplace('%s', $TransactionRecord->ID, TEXT_INVOICE_HEADER)); ?></h1>
                                    <div class="invoice-details mt-2">
                                        <h6><?PHP HTML::print(TEXT_INVOICE_VENDOR_ID); ?></h6>
                                        <?PHP
                                        if($FromApplication !== null)
                                        {
                                            ?>
                                            <code><?PHP HTML::print($FromApplication->PublicAppId); ?></code>
                                            <?PHP
                                        }
                                        elseif($FromAccount !== null)
                                        {
                                            ?>
                                            <code><?PHP HTML::print($FromAccount->PublicID); ?></code>
                                            <?PHP
                                        }
                                        ?>
                                        <h6 class="mt-2"><?PHP HTML::print(TEXT_INVOICE_DATE); ?></h6>
                                        <p><?PHP HTML::print(date("F j, Y, g:i a", $TransactionRecord->Timestamp)); ?></p>
                                    </div>
                                </div>
                            </div>
                            <!-- Invoice Items Details -->
                            <div id="invoice-items-details" class="pt-1 invoice-items-table">
                                <div class="row">
                                    <div class="table-responsive w-100">
                                        <table class="table">
                                            <thead>
                                            <tr class="bg-dark text-white">
                                                <th>#</th>
                                                <th><?PHP HTML::print(TEXT_INVOICE_DESCRIPTION); ?></th>
                                                <th class="text-right"><?PHP HTML::print(TEXT_INVOICE_QUANTITY); ?></th>
                                                <th class="text-right"><?PHP HTML::print(TEXT_INVOICE_UNIT_COST); ?></th>
                                                <th class="text-right"><?PHP HTML::print(TEXT_INVOICE_TOTAL); ?></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr class="text-right">
                                                <td class="text-left">1</td>
                                                <td class="text-left"><?PHP HTML::print(TEXT_INVOICE_TRANSACTION); ?></td>
                                                <td>1</td>
                                                <?PHP
                                                if($TransactionRecord->Amount == 0)
                                                {
                                                    ?>
                                                    <td>$0 USD</td>
                                                    <td>$0 USD</td>
                                                    <?PHP
                                                }
                                                elseif($TransactionRecord->Amount > 0)
                                                {
                                                    ?>
                                                    <td>$<?PHP HTML::print($TransactionRecord->Amount); ?> USD</td>
                                                    <td>$<?PHP HTML::print($TransactionRecord->Amount); ?> USD</td>
                                                    <?PHP
                                                }
                                                elseif($TransactionRecord->Amount < 0)
                                                {
                                                    ?>
                                                    <td>-$<?PHP HTML::print(abs($TransactionRecord->Amount)); ?> USD</td>
                                                    <td>-$<?PHP HTML::print(abs($TransactionRecord->Amount)); ?> USD</td>
                                                    <?PHP
                                                }
                                                ?>

                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="container-fluid mt-2 w-100">
                                <h4 class="text-right">
                                    <?PHP
                                    HTML::print(TEXT_INVOICE_TOTAL);
                                    if($TransactionRecord->Amount == 0)
                                    {
                                        HTML::print("$0 USD");
                                    }
                                    elseif($TransactionRecord->Amount > 0)
                                    {
                                        ?>$<?PHP HTML::print($TransactionRecord->Amount); ?> USD<?PHP
                                    }
                                    elseif($TransactionRecord->Amount < 0)
                                    {
                                        ?>Total -$<?PHP HTML::print(abs($TransactionRecord->Amount)); ?> USD<?PHP
                                    }
                                    ?>
                                </h4>
                            </div>
                            <div id="invoice-footer" class="text-right pt-3">
                                <p><?PHP HTML::print(TEXT_INVOICE_FOOTER); ?>, copyright &copy; 2017-<?PHP print(date('Y')); ?> Intellivoid Technologies
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