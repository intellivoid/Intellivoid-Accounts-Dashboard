<?PHP

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use DynamicalWeb\Runtime;
    use IntellivoidAccounts\IntellivoidAccounts;

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

    $Account = $IntellivoidAccounts->getAccountManager()->getAccount(\IntellivoidAccounts\Abstracts\SearchMethods\AccountSearchMethod::byId, WEB_ACCOUNT_ID);


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
                                        <div class="list-item">
                                            <div class="preview-image">
                                                <img class="img-sm rounded-circle" src="../../../assets/images/faces/face10.jpg" alt="profile image">
                                            </div>
                                            <div class="content">
                                                <div class="d-flex align-items-center">
                                                    <h6 class="product-name">Air Pod</h6>
                                                    <small class="time ml-3 d-none d-sm-block">08.34 AM</small>
                                                    <div class="ml-auto">
                                                        <div class="br-wrapper br-theme-css-stars"><select id="review-rating-1" name="rating" autocomplete="off" style="display: none;">
                                                                <option value="1">1</option>
                                                                <option value="2">2</option>
                                                                <option value="3">3</option>
                                                                <option value="4">4</option>
                                                                <option value="5">5</option>
                                                            </select><div class="br-widget"><a href="#" data-rating-value="1" data-rating-text="1" class="br-selected"></a><a href="#" data-rating-value="2" data-rating-text="2" class="br-selected"></a><a href="#" data-rating-value="3" data-rating-text="3" class="br-selected"></a><a href="#" data-rating-value="4" data-rating-text="4" class="br-selected br-current"></a><a href="#" data-rating-value="5" data-rating-text="5"></a></div></div>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <p class="user-name">Christine :</p>
                                                    <p class="review-text d-block">The brand apple is original !</p>
                                                </div>
                                            </div>
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
