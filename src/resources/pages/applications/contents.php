<?PHP

use DynamicalWeb\DynamicalWeb;
use DynamicalWeb\HTML;

    $UsernameSafe = ucfirst(WEB_ACCOUNT_USERNAME);
    if(strlen($UsernameSafe) > 16)
    {
        $UsernameSafe = substr($UsernameSafe, 0 ,16);
        $UsernameSafe .= "...";
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

                        <div class="row">
                            <div class="col-md-8 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Applicationsy</h4>
                                        <p class="card-description"> Review what devices you logged in with and when </p>
                                        <div class="row">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Actions</h4>
                                        <div class="wrapper mt-4">
                                            <a class="d-flex align-items-center py-3 text-black" data-toggle="modal" data-target="#create-application" style="text-decoration: none;" href="<?PHP ?>">
                                                <i class="mdi mdi-plus text-danger"></i>
                                                <p class="mb-0 ml-3">Create Application</p>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="create-application" tabindex="-1" role="dialog" aria-labelledby="create-application-label" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <form class="modal-content" action="<?PHP DynamicalWeb::getRoute('applications', array('action' => 'create-application'), true); ?>">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="create-application-label">Create Application</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">
                                                <i class="mdi mdi-close"></i>
                                            </span>
                                        </button>
                                    </div>
                                    <div class="modal-body">

                                        <div class="form-group">
                                            <label for="application_name">Application Name</label>
                                            <div class="input-group">
                                                <input type="text" id="application_name" name="application_name" placeholder="Enter your Application Name" class="form-control">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">
                                                        <i class="mdi mdi-application"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group pt-2">
                                            <label for="authentication_type">Authentication Type</label>
                                            <select class="form-control" id="authentication_type">
                                                <option value="1">Redirect</option>
                                                <option value="2">Application Placeholder</option>
                                                <option value="3">Code</option>
                                            </select>
                                        </div>

                                       <div class="form-group pt-2">
                                           <label>Permissions</label>
                                           <div class="row">
                                               <div class="col-md-6">
                                                   <div class="form-check">
                                                       <label class="form-check-label">
                                                           <input type="checkbox" class="form-check-input"> View Personal Information
                                                           <i class="input-helper"></i>
                                                       </label>
                                                   </div>
                                                   <p class="text-muted text-small pb-4">Access to Personal Information like name, birthday and email</p>

                                                   <div class="form-check">
                                                       <label class="form-check-label">
                                                           <input type="checkbox" class="form-check-input">  Make purchases
                                                           <i class="input-helper"></i>
                                                       </label>
                                                   </div>
                                                   <p class="text-muted text-small">Make purchases or activate paid subscriptions on users behalf</p>


                                               </div>
                                               <div class="col-md-6">
                                                   <div class="form-check">
                                                       <label class="form-check-label">
                                                           <input type="checkbox" class="form-check-input"> Edit Personal Information
                                                           <i class="input-helper"></i>
                                                       </label>
                                                   </div>
                                                   <p class="text-muted text-small pb-4">Edit user's personal information</p>

                                                   <div class="form-check">
                                                       <label class="form-check-label">
                                                           <input type="checkbox" class="form-check-input"> Telegram Notifications
                                                           <i class="input-helper"></i>
                                                       </label>
                                                   </div>
                                                   <p class="text-muted text-small">Send notifications via Telegram (if available)</p>
                                               </div>
                                           </div>

                                       </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                                        <button type="button" class="btn btn-success">Create Application</button>
                                    </div>
                                </form>
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
