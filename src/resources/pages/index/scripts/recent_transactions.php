<?php

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use DynamicalWeb\Runtime;
    use IntellivoidAccounts\Abstracts\SearchMethods\AccountSearchMethod;
    use IntellivoidAccounts\Abstracts\SearchMethods\ApplicationSearchMethod;
    use IntellivoidAccounts\IntellivoidAccounts;
    use IntellivoidAccounts\Objects\Account;
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


    /** @var Account $Account */
    $Account = DynamicalWeb::getMemoryObject('account');
    $TotalTransactions = $IntellivoidAccounts->getTransactionRecordManager()->getTotalRecords($Account->ID);

    $RecentTransactions = null;

    if($TotalTransactions > 0)
    {
        $RecentTransactions = $IntellivoidAccounts->getTransactionRecordManager()->getNewRecords($Account->ID, 4);
    }


    if($TotalTransactions == 0)
    {
        ?>
        <div class="ml-auto mr-auto my-3">
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
                <div class="avatar avatar-lg mr-1">
                    <img src="<?PHP HTML::print($ImageSource, false); ?>" alt="Brand Logo">
                </div>
                <div class="content pr-0">
                    <div class="d-flex flex-wrap">
                        <p class="font-medium-1 mr-1 mb-0"><?PHP HTML::print($TransactionRecord->Vendor); ?></p>
                        <div class="ml-auto">
                            <span class="text-muted font-medium-1"><?PHP HTML::print(gmdate("j/m/y g:i a", $TransactionRecord->Timestamp)); ?></span>
                            <a href="<?PHP DynamicalWeb::getRoute('view_invoice', array('transaction_id' => $TransactionRecord->PublicID), true); ?>">
                                <i class="feather icon-file-text"></i>
                            </a>
                        </div>
                    </div>
                    <div class="mt-20">
                        <?PHP
                            if($TransactionRecord->Amount == 0)
                            {
                                ?>
                                <span class="text-muted font-medium-4">$0 USD</span>
                                <?PHP
                            }
                            elseif($TransactionRecord->Amount < 0)
                            {
                                ?>
                                <span class="text-danger font-medium-4">-$<?PHP HTML::print(abs($TransactionRecord->Amount)); ?> USD</span>
                                <?PHP
                            }
                            elseif($TransactionRecord->Amount > 0)
                            {
                                ?>
                                <span class="text-primary font-medium-4">$<?PHP HTML::print($TransactionRecord->Amount); ?> USD</span>
                                <?PHP
                            }
                        ?>
                    </div>
                </div>
            </div>
            <?PHP
        }
        ?>
        <button class="btn btn-block bg-gradient-danger mt-2 mx-2" onclick="location.href='<?PHP DynamicalWeb::getRoute('transaction_history', [], true); ?>';">
            <?PHP HTML::print(TEXT_VIEW_TRANSACTION_HISTORY); ?>
        </button>
        <?php
    }
?>