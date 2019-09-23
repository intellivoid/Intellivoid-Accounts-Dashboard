<?PHP

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use IntellivoidAccounts\IntellivoidAccounts;
    use IntellivoidAccounts\Objects\COA\Application;

    HTML::importScript('check_application');

    /** @var Application $Application */
    $Application = DynamicalWeb::getMemoryObject('application');


    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        if(isset($_GET['action']))
        {
            switch($_GET['action'])
            {
                case 'change-logo':
                   HTML::importScript('change_logo');
                   break;

                case 'update-auth-mode':
                    HTML::importScript('update_auth_mode');
            }
        }
    }

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
                        <div class="row">
                            <div class="col-md-4 d-flex align-items-stretch">
                                <div class="row flex-grow">
                                    <div class="col-12 grid-margin">
                                        <div class="card">
                                            <div class="card-body">
                                                <form action="<?PHP DynamicalWeb::getRoute('manage_application', array('pub_id' => $Application->PublicAppId, 'action' => 'change-logo'), true); ?>" method="POST" enctype="multipart/form-data">
                                                    <div class="d-flex align-items-start pb-3 border-bottom">
                                                        <img class="img-md" src="<?PHP DynamicalWeb::getRoute('application_icon', array('app_id' => $Application->PublicAppId, 'resource' => 'small'), true); ?>" alt="brand logo">

                                                        <div class="wrapper pl-4">
                                                            <p class="font-weight-bold mb-0"><?PHP HTML::print($Application->Name); ?></p>
                                                            <label class="btn btn-inverse-light btn-xs mt-2" for="file-selector" onchange="this.form.submit();">
                                                                <input id="file-selector" name="user_av_file" type="file" class="d-none">
                                                                Change Logo
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <button class="btn btn-block btn-danger mt-3"  data-toggle="tooltip" data-placement="bottom" title="This action will prevent users from authenticating to your Application"">Disable Application</button>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title text-muted">Application Keys</h4>
                                        <form class="border-bottom">
                                            <div class="form-group pb-3">
                                                <label for="public_app_id">Public Application ID</label>
                                                <input type="text" class="form-control bg-white" id="public_app_id" data-toggle="tooltip" data-placement="bottom" title="This is used for getting the public Application Logo and information" value="<?PHP HTML::print($Application->PublicAppId); ?>" aria-readonly="true" readonly>
                                            </div>
                                            <div class="form-group pb-3">
                                                <label for="app_secret_key">Secret Key</label>
                                                <input type="text" class="form-control border-danger bg-white" id="app_secret_key" data-toggle="tooltip" data-placement="bottom" title="This is for creating authentication requests, don't share it!" value="<?PHP HTML::print($Application->SecretKey); ?>" aria-readonly="true" readonly>
                                            </div>
                                        </form>

                                    </div>

                                    <div class="card-body">
                                        <h4 class="card-title text-muted">Settings</h4>
                                        <form action="<?PHP DynamicalWeb::getRoute('manage_application', array('action' => 'update-auth-mode'), true); ?>" method="POST">
                                            <div class="form-group">
                                                <label for="authentication_type">Authentication Type</label>
                                                <select class="form-control" name="authentication_type" id="authentication_type" onchange="this.form.submit();">
                                                    <option value="redirect">Redirect</option>
                                                    <option value="placeholder">Application Placeholder</option>
                                                    <option value="code">Code</option>
                                                </select>
                                            </div>
                                        </form>
                                        <div class="form-group pt-2">
                                            <label>Permissions</label>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input type="checkbox" name="perm_view_personal_information" class="form-check-input"> View Personal Information
                                                            <i class="input-helper"></i>
                                                        </label>
                                                    </div>
                                                    <p class="text-muted text-small pb-4">Access to Personal Information like name, birthday and email</p>

                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input type="checkbox" name="perm_make_purchases" id="perm_make_purchases" class="form-check-input">  Make purchases
                                                            <i class="input-helper"></i>
                                                        </label>
                                                    </div>
                                                    <p class="text-muted text-small">Make purchases or activate paid subscriptions on users behalf</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input type="checkbox" name="perm_edit_personal_information" id="perm_edit_personal_information" class="form-check-input"> Edit Personal Information
                                                            <i class="input-helper"></i>
                                                        </label>
                                                    </div>
                                                    <p class="text-muted text-small pb-4">Edit user's personal information</p>

                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input type="checkbox" name="perm_telegram_notifications" id="perm_telegram_notifications" class="form-check-input"> Telegram Notifications
                                                            <i class="input-helper"></i>
                                                        </label>
                                                    </div>
                                                    <p class="text-muted text-small">Send notifications via Telegram (if available)</p>
                                                </div>
                                            </div>

                                        </div>


                                    </div>
                                    <div class="card-footer">
                                        <div class="row align-items-center">
                                            <button class="btn btn-success ml-auto mr-2">Save Changes</button>
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
        <script src="/assets/js/shared/tooltips.js"></script>
    </body>
</html>
