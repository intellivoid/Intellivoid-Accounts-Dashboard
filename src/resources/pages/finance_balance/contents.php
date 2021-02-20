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
    HTML::importScript('redirect_paypal');

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
        $RecentTransactions = $IntellivoidAccounts->getTransactionRecordManager()->getNewRecords($Account->ID, 15);
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
                        <div class="col-12 col-xl-4">
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <h2 class="text-bold-400">
                                                $<?PHP HTML::print($Account->Configuration->Balance); ?> USD
                                            </h2>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <i class="fa fa-circle font-small-3 text-primary mr-50"></i>
                                            <p class="text-muted mb-0">
                                                <a class="text-primary" data-toggle="modal" data-target="#add-balance-dialog"  href="#"><?PHP HTML::print(TEXT_BALANCE_ADD_LINK); ?></a>
                                            </p>
                                        </div>
                                        <div class="alert alert-primary mt-2" role="alert">
                                            <p><?PHP HTML::print(TEXT_ADD_MESSAGE_P1); ?></p>
                                            <br/>
                                            <p><?PHP HTML::print(TEXT_ADD_MESSAGE_P2); ?></p>
                                            <br/>
                                            <p><?PHP HTML::print(TEXT_ADD_MESSAGE_P3); ?></p>
                                            <a class="btn btn-block bg-gradient-primary mt-1" href="<?PHP DynamicalWeb::getRoute('settings/user', array(), true); ?>"><?PHP HTML::print(TEXT_UPDATE_EMAIL_BUTTON); ?></a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-12 col-xl-8">
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-body">
                                        <h4 class="card-title"><?PHP HTML::print(TEXT_RECENT_ACTIVITY_CARD_TITLE); ?></h4>
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
                                            ?>
                                            <a class="btn btn-block bg-gradient-danger mt-2 mx-2" href="<?PHP DynamicalWeb::getRoute('finance_transactions', array(), true); ?>">
                                                <?PHP HTML::print(TEXT_VIEW_TRANSACTION_HISTORY); ?>
                                            </a>
                                            <?php
                                        }
                                        ?>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?PHP HTML::importScript('add_balance_dialog'); ?>
        </div>

        <?PHP HTML::importSection('main_ehelper'); ?>
        <?PHP HTML::importSection('main_footer'); ?>
        <?PHP HTML::importSection('main_js'); ?>

    </body>
</html>