<?PHP

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use DynamicalWeb\Runtime;
use IntellivoidAccounts\Abstracts\SearchMethods\AccountSearchMethod;
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
        $RecentTransactions = $IntellivoidAccounts->getTransactionRecordManager()->getNewRecords($Account->ID, 15);
    }


?>
<!doctype html>
<html lang="<?PHP HTML::print(APP_LANGUAGE_ISO_639); ?>">
    <head>
        <?PHP HTML::importSection('dashboard_headers'); ?>
        <title>Intellivoid Accounts - Personal</title>
    </head>

    <body>
        <div class="container-scroller">
            <?PHP HTML::importSection("dashboard_navbar"); ?>
            <div class="container-fluid page-body-wrapper">
                <div class="main-panel container">
                    <div class="content-wrapper">

                        <div class="row">
                            <div class="col-sm-5 col-md-5 col-lg-5 grid-margin">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="absolute left top bottom h-100 v-strock-2 bg-success"></div>
                                        <p class="text-muted mb-2">Account Balance</p>
                                        <div class="d-flex align-items-center">
                                            <h1 class="font-weight-medium mb-2">$<?PHP HTML::print($Account->Configuration->Balance); ?> USD</h1>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary dot-indicator"></div>
                                            <p class="text-muted mb-0 ml-2">
                                                <a class="text-primary" href="#">Add to balance</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-7 col-lg-7 col-md-6 col-sm-12 grid-margin stretch-card">
                                <div class="card review-card">
                                    <div class="card-header header-sm d-flex justify-content-between align-items-center">
                                        <h4 class="card-title">Recent Activity</h4>
                                        <div class="wrapper d-flex align-items-center">
                                            <div class="dropdown">
                                                <button class="btn btn-transparent icon-btn dropdown-toggle arrow-disabled pr-0" type="button" id="dropdownMenuIconButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="mdi mdi-dots-vertical"></i>
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuIconButton1">
                                                    <a class="dropdown-item" href="#">View more transactions</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body no-gutter">
                                        <?PHP
                                            if($TotalTransactions == 0)
                                            {
                                                ?>
                                                <div class="d-flex flex-column justify-content-center align-items-center"  style="height:50vh;">
                                                    <div class="p-2 my-flex-item">
                                                        <img src="/assets/images/sadboi.svg" class="img-fluid img-md" alt="No items icon"/>
                                                    </div>
                                                    <div class="p-2 my-flex-item">
                                                        <h6 class="text-muted"><?PHP HTML::print("No Items"); ?></h6>
                                                    </div>
                                                </div>
                                                <?PHP
                                            }
                                            else
                                            {
                                                $CachedAccounts = array();
                                                foreach($RecentTransactions as $transaction)
                                                {
                                                    $TransactionRecord = TransactionRecord::fromArray($transaction);
                                                    $ImageSource = "/assets/images/vendor.svg";
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
                                                    ?>
                                                    <div class="list-item">
                                                        <div class="preview-image">
                                                            <img class="img-sm rounded-circle" src="<?PHP HTML::print($ImageSource, false); ?>" alt="profile image">
                                                        </div>
                                                        <div class="content">
                                                            <div class="d-flex align-items-center">
                                                                <h6 class="product-name"><?PHP HTML::print($TransactionRecord->Vendor); ?></h6>
                                                                <small class="time ml-3 d-none d-sm-block"><?PHP HTML::print(gmdate("j/m/y g:i a", $TransactionRecord->Timestamp)); ?></small>
                                                                <div class="ml-auto">
                                                                    <a class="text-small" href="<?PHP DynamicalWeb::getRoute('view_invoice', array('transaction_id' => $TransactionRecord->PublicID), true); ?>">View Invoice</a>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex align-items-center">
                                                                <?PHP
                                                                    if($TransactionRecord->Amount == 0)
                                                                    {
                                                                        ?>
                                                                        <p class="text-muted mb-0">
                                                                            $<?PHP HTML::print($TransactionRecord->Amount); ?> USD
                                                                        </p>
                                                                        <?PHP
                                                                    }
                                                                    if($TransactionRecord->Amount < 0)
                                                                    {
                                                                        ?>
                                                                        <p class="text-danger mb-0">
                                                                            -$<?PHP HTML::print(abs($TransactionRecord->Amount)); ?> USD
                                                                        </p>
                                                                        <?PHP
                                                                    }
                                                                    if($TransactionRecord->Amount > 0)
                                                                    {
                                                                        ?>
                                                                        <p class="text-success mb-0">
                                                                            $<?PHP HTML::print($TransactionRecord->Amount); ?> USD
                                                                        </p>
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
                    <?PHP HTML::importSection('dashboard_footer'); ?>
                </div>
            </div>

        </div>
        <?PHP HTML::importSection('dashboard_js'); ?>
    </body>
</html>
