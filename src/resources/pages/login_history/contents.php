<?PHP
    use DynamicalWeb\HTML;

    /** @var \IntellivoidAccounts\Objects\Account $Account */
    $Account = \DynamicalWeb\DynamicalWeb::getMemoryObject('account');
?>
<!doctype html>
<html lang="<?PHP HTML::print(APP_LANGUAGE_ISO_639); ?>">
    <head>
        <?PHP HTML::importSection('dashboard_headers'); ?>
        <title>Intellivoid Accounts</title>
    </head>

    <body>
        <div class="container-scroller">
            <?PHP HTML::importSection("dashboard_navbar"); ?>
            <div class="container-fluid page-body-wrapper">
                <div class="main-panel container">
                    <div class="content-wrapper">
                        <?PHP HTML::importScript('callbacks'); ?>

                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Login History</h4>
                                    <p class="card-description"> Review what devices you logged in with and when </p>
                                    <div class="row">
                                        <div class="col-md-9">
                                            <div class="table-responsive">
                                                <table class="table table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th> User </th>
                                                        <th> First name </th>
                                                        <th> Progress </th>
                                                        <th> Amount </th>
                                                        <th> Deadline </th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td class="py-1">
                                                            <img src="../../../assets/images/faces-clipart/pic-1.png" alt="image"> </td>
                                                        <td> Herman Beck </td>
                                                        <td>
                                                            <div class="progress">
                                                                <div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </td>
                                                        <td> $ 77.99 </td>
                                                        <td> May 15, 2015 </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="py-1">
                                                            <img src="../../../assets/images/faces-clipart/pic-2.png" alt="image"> </td>
                                                        <td> Messsy Adam </td>
                                                        <td>
                                                            <div class="progress">
                                                                <div class="progress-bar bg-danger" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </td>
                                                        <td> $245.30 </td>
                                                        <td> July 1, 2015 </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="py-1">
                                                            <img src="../../../assets/images/faces-clipart/pic-3.png" alt="image"> </td>
                                                        <td> John Richards </td>
                                                        <td>
                                                            <div class="progress">
                                                                <div class="progress-bar bg-warning" role="progressbar" style="width: 90%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </td>
                                                        <td> $138.00 </td>
                                                        <td> Apr 12, 2015 </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="py-1">
                                                            <img src="../../../assets/images/faces-clipart/pic-4.png" alt="image"> </td>
                                                        <td> Peter Meggik </td>
                                                        <td>
                                                            <div class="progress">
                                                                <div class="progress-bar bg-primary" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </td>
                                                        <td> $ 77.99 </td>
                                                        <td> May 15, 2015 </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="py-1">
                                                            <img src="../../../assets/images/faces-clipart/pic-1.png" alt="image"> </td>
                                                        <td> Edward </td>
                                                        <td>
                                                            <div class="progress">
                                                                <div class="progress-bar bg-danger" role="progressbar" style="width: 35%" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </td>
                                                        <td> $ 160.25 </td>
                                                        <td> May 03, 2015 </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="py-1">
                                                            <img src="../../../assets/images/faces-clipart/pic-2.png" alt="image"> </td>
                                                        <td> John Doe </td>
                                                        <td>
                                                            <div class="progress">
                                                                <div class="progress-bar bg-info" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </td>
                                                        <td> $ 123.21 </td>
                                                        <td> April 05, 2015 </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="py-1">
                                                            <img src="../../../assets/images/faces-clipart/pic-3.png" alt="image"> </td>
                                                        <td> Henry Tom </td>
                                                        <td>
                                                            <div class="progress">
                                                                <div class="progress-bar bg-warning" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </td>
                                                        <td> $ 150.00 </td>
                                                        <td> June 16, 2015 </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <h5 class="my-4">
                                                Quick Shortcuts <br/>
                                                <small class="text-muted">Don't recognize a login? Here's what you can do to protect your account</small>
                                            </h5>
                                            <div class="new-accounts">
                                                <ul class="chats ps">
                                                    <li class="chat-persons">
                                                        <a href="#">
                                                            <div class="pro-pic">
                                                                <i class="mdi mdi-lock-reset text-primary icon-md"></i>
                                                            </div>
                                                            <div class="user">
                                                                <p class="u-name">Password</p>
                                                                <p class="u-designation">Update your password</p>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li class="chat-persons">
                                                        <a href="#">
                                                            <div class="pro-pic">
                                                                <i class="mdi mdi-firefox text-primary icon-md"></i>
                                                            </div>
                                                            <div class="user">
                                                                <p class="u-name">Firefox</p>
                                                                <p class="u-designation">192.168.1.1</p>
                                                            </div>
                                                        </a>
                                                    </li>
                                                </ul>
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
