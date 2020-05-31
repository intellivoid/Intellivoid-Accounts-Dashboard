<?php

    /** @noinspection PhpUndefinedConstantInspection */

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use DynamicalWeb\Runtime;
    use IntellivoidAccounts\Abstracts\SearchMethods\AccountSearchMethod;
    use IntellivoidAccounts\Abstracts\SearchMethods\ApplicationSearchMethod;
    use IntellivoidAccounts\IntellivoidAccounts;
    use IntellivoidAccounts\Objects\TransactionRecord;

    Runtime::import('IntellivoidAccounts');

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

    $Account = $IntellivoidAccounts->getAccountManager()->getAccount(AccountSearchMethod::byId, WEB_ACCOUNT_ID);
    $TotalTransactions = $IntellivoidAccounts->getTransactionRecordManager()->getTotalRecords($Account->ID);

    $RecentTransactions = null;

    if($TotalTransactions > 0)
    {
        $RecentTransactions = $IntellivoidAccounts->getTransactionRecordManager()->getNewRecords($Account->ID, 50);
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
                        <div class="col-12">
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-body">
                                        <h4 class="card-title"><?PHP HTML::print(TEXT_PAGE_HEADER); ?></h4>
                                        <?PHP
                                            if($TotalTransactions == 0)
                                            {
                                                ?>
                                                <div class="text-center my-3">
                                                    <h5 class="text-muted"><?PHP HTML::print(TEXT_NO_TRANSACTIONS); ?></h5>
                                                </div>
                                                <?PHP
                                            }
                                            else
                                            {
                                                $CachedAccounts = array();
                                                $CachedApplications = array();
                                                foreach($RecentTransactions as $transaction)
                                                {
                                                    $TransactionRecord = TransactionRecord::fromArray($transaction);
                                                    $ImageSource = "/assets/images/vendor.svg";
                                                    $VendorFound = false;

                                                    if(isset($CachedApplications[$TransactionRecord->Vendor]))
                                                    {
                                                        if($CachedApplications[$TransactionRecord->Vendor] !== null)
                                                        {
                                                            $ImageSource = DynamicalWeb::getRoute('application_icon', array(
                                                                'app_id' => $CachedApplications[$TransactionRecord->Vendor],
                                                                'resource'=> 'normal'
                                                            ));
                                                            $VendorFound = true;
                                                        }
                                                    }
                                                    else
                                                    {
                                                        try
                                                        {
                                                            $VendorApplication = $IntellivoidAccounts->getApplicationManager()->getApplication(
                                                                ApplicationSearchMethod::byName,
                                                                substr($TransactionRecord->Vendor, 0, strpos($TransactionRecord->Vendor, ' '))
                                                            );
                                                            $CachedApplications[$TransactionRecord->Vendor] = $VendorApplication->PublicAppId;
                                                            $ImageSource = DynamicalWeb::getRoute('application_icon', array(
                                                                'app_id' => $CachedApplications[$TransactionRecord->Vendor],
                                                                'resource'=> 'normal'
                                                            ));
                                                            $VendorFound = true;
                                                        }
                                                        catch(Exception $e)
                                                        {
                                                            $CachedAccounts[$TransactionRecord->Vendor] = null;
                                                        }
                                                    }

                                                    if($VendorFound == false)
                                                    {
                                                        if(isset($CachedAccounts[$TransactionRecord->Vendor]))
                                                        {
                                                            if($CachedAccounts[$TransactionRecord->Vendor] !== null)
                                                            {
                                                                $ImageSource = DynamicalWeb::getRoute('avatar', array(
                                                                    'user_id' => $CachedAccounts[$TransactionRecord->Vendor],
                                                                    'resource' => 'normal'
                                                                ));
                                                            }
                                                        }
                                                        else
                                                        {
                                                            try
                                                            {
                                                                $VendorAccount = $IntellivoidAccounts->getAccountManager()->getAccount(
                                                                    AccountSearchMethod::byUsername, $TransactionRecord->Vendor
                                                                );
                                                                $CachedAccounts[$TransactionRecord->Vendor] = $VendorAccount->PublicID;
                                                                $ImageSource = DynamicalWeb::getRoute('avatar', array(
                                                                    'user_id' => $CachedAccounts[$TransactionRecord->Vendor],
                                                                    'resource' => 'normal'
                                                                ));
                                                            }
                                                            catch(Exception $e)
                                                            {
                                                                $CachedAccounts[$TransactionRecord->Vendor] = null;
                                                            }
                                                        }
                                                    }
                                                ?>
                                                <div class="list-item p-1">
                                                    <div class="avatar avatar-md mr-1">
                                                        <img src="<?PHP HTML::print($ImageSource, false); ?>" alt="Brand Logo">
                                                    </div>
                                                    <div class="content pr-0">
                                                        <div class="d-flex flex-wrap">
                                                            <p class="font-medium-1 mr-1 mb-0"><?PHP HTML::print($TransactionRecord->Vendor); ?></p>
                                                            <div class="ml-auto">
                                                                <span class="text-muted font-small-3 d-none d-xl-inline"><?PHP HTML::print(gmdate("j/m/y g:i a", $TransactionRecord->Timestamp)); ?></span>
                                                                <a href="<?PHP DynamicalWeb::getRoute('finance_invoice', array('transaction_id' => $TransactionRecord->PublicID), true); ?>">
                                                                    <i class="feather icon-file-text"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="mt-20">
                                                            <?PHP
                                                            if($TransactionRecord->Amount == 0)
                                                            {
                                                                ?>
                                                                <span class="text-muted font-medium-2">$0 USD</span>
                                                                <?PHP
                                                            }
                                                            elseif($TransactionRecord->Amount < 0)
                                                            {
                                                                ?>
                                                                <span class="text-danger font-medium-2">-$<?PHP HTML::print(abs($TransactionRecord->Amount)); ?> USD</span>
                                                                <?PHP
                                                            }
                                                            elseif($TransactionRecord->Amount > 0)
                                                            {
                                                                ?>
                                                                <span class="text-primary font-medium-2">$<?PHP HTML::print($TransactionRecord->Amount); ?> USD</span>
                                                                <?PHP
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?PHP
                                            }
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