<?PHP

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

    try
    {
        $Account = $IntellivoidAccounts->getAccountManager()->getAccount(
            AccountSearchMethod::byId, WEB_ACCOUNT_ID
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
<!doctype html>
<html lang="<?PHP HTML::print(APP_LANGUAGE_ISO_639); ?>">
    <head>
        <?PHP HTML::importSection('dashboard_headers'); ?>
        <title><?PHP HTML::print(str_ireplace('%s', $TransactionRecord->ID, TEXT_PAGE_TITLE)); ?></title>
    </head>

    <body>
        <div class="container-scroller">
            <?PHP HTML::importSection("dashboard_navbar"); ?>
            <div class="container-fluid page-body-wrapper">
                <div class="main-panel container-fluid">
                    <div class="content-wrapper">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card px-2">
                                    <div class="card-body">
                                        <div class="container-fluid">
                                            <h3 class="text-right my-5"><?PHP HTML::print(str_ireplace('%s', $TransactionRecord->ID, TEXT_INVOICE_HEADER)); ?></h3>
                                            <hr>
                                        </div>
                                        <div class="container-fluid d-flex justify-content-between row">
                                            <div class="col-lg-4">
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
                                                <p class="mt-5 mb-2">
                                                    <b><?PHP HTML::print($TransactionRecord->Vendor); ?></b>
                                                </p>
                                                <?PHP
                                                if($FromApplication !== null)
                                                {
                                                    ?>
                                                    <p><?PHP HTML::print(TEXT_INVOICE_VENDOR_ID); ?>
                                                        <code><?PHP HTML::print($FromApplication->PublicAppId); ?></code>
                                                    </p>
                                                    <?PHP
                                                }
                                                elseif($FromAccount !== null)
                                                {
                                                    ?>
                                                    <p><?PHP HTML::print($FromAccount->Email); ?></p>
                                                    <p><?PHP HTML::print(TEXT_INVOICE_VENDOR_ID); ?>
                                                        <code><?PHP HTML::print($FromAccount->PublicID); ?></code>
                                                    </p>
                                                    <?PHP
                                                }
                                                ?>
                                            </div>
                                            <div class="col-lg-4">
                                                <p class="mt-5 mb-2">
                                                    <b><?PHP HTML::print(TEXT_INVOICE_TO); ?></b>
                                                </p>
                                                <p>
                                                    @<?PHP HTML::print($Account->Username); ?>
                                                    <br> <?PHP HTML::print($Account->Email); ?>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="container-fluid d-flex justify-content-between">
                                            <div class="col-lg-3 pl-0">
                                                <p class="mb-0 mt-5"><?PHP HTML::print(str_ireplace('%s', date("F j, Y, g:i a", $TransactionRecord->Timestamp), TEXT_INVOICE_DATE)); ?></p>
                                            </div>
                                        </div>
                                        <div class="container-fluid mt-5 d-flex justify-content-center w-100 py-0 px-0">
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
                                                        <td class="text-left">Transaction</td>
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
                                        <div class="container-fluid mt-5 w-100">
                                            <h4 class="text-right mb-5">
                                                <?PHP
                                                    if($TransactionRecord->Amount == 0)
                                                    {
                                                        ?>
                                                        Total $0 USD
                                                        <?PHP
                                                    }
                                                    elseif($TransactionRecord->Amount > 0)
                                                    {
                                                        ?>
                                                        Total $<?PHP HTML::print($TransactionRecord->Amount); ?> USD
                                                        <?PHP
                                                    }
                                                    elseif($TransactionRecord->Amount < 0)
                                                    {
                                                        ?>
                                                        Total -$<?PHP HTML::print(abs($TransactionRecord->Amount)); ?> USD
                                                        <?PHP
                                                    }
                                                ?>
                                            </h4>
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
