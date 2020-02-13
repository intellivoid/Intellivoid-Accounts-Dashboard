<?PHP

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use DynamicalWeb\Runtime;
    use IntellivoidAccounts\IntellivoidAccounts;

    Runtime::import('IntellivoidAccounts');

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        if(isset($_GET['action']))
        {
            if($_GET['action'] == 'create-application')
            {
                HTML::importScript('register_application');
            }
        }
    }

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
        <title><?PHP HTML::print(TEXT_PAGE_TITLE); ?></title>
    </head>

    <body>
        <div class="container-scroller">
            <?PHP HTML::importSection("dashboard_navbar"); ?>
            <div class="container-fluid page-body-wrapper">
                <div class="main-panel container">
                    <div class="content-wrapper">
                        <?PHP HTML::importScript('callbacks'); ?>
                        <div class="row">
                            <div class="col-md-4 grid-margin">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title"><?PHP HTML::print(TEXT_ACTIONS_CARD_TITLE); ?></h4>
                                        <div class="wrapper mt-4">
                                            <a class="d-flex align-items-center py-3 text-black" data-toggle="modal" data-target="#create-application" style="text-decoration: none;" href="<?PHP ?>">
                                                <i class="mdi mdi-plus text-danger"></i>
                                                <p class="mb-0 ml-3"><?PHP HTML::print(TEXT_ACTIONS_CREATE_APPLICATION_LINK); ?></p>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title"><?PHP HTML::print(TEXT_APPLICATIONS_CARD_TITLE); ?></h4>
                                        <p class="card-description"><?PHP HTML::print(TEXT_APPLICATIONS_CARD_DESCRIPTION); ?></p>
                                        <?PHP
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

                                            $TotalRecords = $IntellivoidAccounts->getApplicationManager()->getRecords(WEB_ACCOUNT_ID);

                                            if(count($TotalRecords) == 0)
                                            {
                                                HTML::importScript('ren.no_contents');
                                            }
                                            else
                                            {
                                                HTML::importScript('ren.contents');
                                                render_items($TotalRecords);
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="create-application" tabindex="-1" role="dialog" aria-labelledby="create-application-label" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <form class="modal-content" method="POST" action="<?PHP DynamicalWeb::getRoute('applications', array('action' => 'create-application'), true); ?>">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="create-application-label"><?PHP HTML::print(TEXT_CREATE_APPLICATION_DIALOG_TITLE); ?></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">
                                                <i class="mdi mdi-close"></i>
                                            </span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="application_name"><?PHP HTML::print(TEXT_CREATE_APPLICATION_DIALOG_APPLICATION_NAME_LABEL); ?></label>
                                            <div class="input-group">
                                                <input type="text" id="application_name" name="application_name" placeholder="<?PHP HTML::print(TEXT_CREATE_APPLICATION_DIALOG_APPLICATION_NAME_PLACEHOLDER); ?>" class="form-control">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">
                                                        <i class="mdi mdi-application"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group pt-2">
                                            <label for="authentication_type"><?PHP HTML::print(TEXT_CREATE_APPLICATION_DIALOG_AUTHENTICATION_TYPE_LABEL); ?></label>
                                            <select class="form-control" name="authentication_type" id="authentication_type">
                                                <option value="redirect"><?PHP HTML::print(TEXT_CREATE_APPLICATION_DIALOG_AUTHENTICATION_TYPE_REDIRECT); ?></option>
                                                <option value="placeholder"><?PHP HTML::print(TEXT_CREATE_APPLICATION_DIALOG_AUTHENTICATION_TYPE_PLACEHOLDER); ?></option>
                                                <option value="code"><?PHP HTML::print(TEXT_CREATE_APPLICATION_DIALOG_AUTHENTICATION_TYPE_CODE); ?></option>
                                            </select>
                                        </div>
                                       <div class="form-group mt-4 mx-2">
                                           <label><?PHP HTML::print(TEXT_CREATE_APPLICATION_DIALOG_PERMISSIONS_HEADER); ?></label>
                                           <div class="row">
                                               <div class="col-md-6">
                                                   <div class="form-check">
                                                       <label class="form-check-label">
                                                           <input type="checkbox" name="perm_view_email_address" id="perm_view_email_address" class="form-check-input"> <?PHP HTML::print(TEXT_CREATE_APPLICATION_DIALOG_PERMISSIONS_VIEW_EMAIL_TEXT); ?>
                                                           <i class="input-helper"></i>
                                                       </label>
                                                   </div>
                                                   <p class="text-muted text-small pb-4"><?PHP HTML::print(TEXT_CREATE_APPLICATION_DIALOG_PERMISSIONS_VIEW_EMAIL_DESCRIPTION); ?></p>

                                                   <div class="form-check">
                                                       <label class="form-check-label">
                                                           <input type="checkbox" name="perm_telegram_notifications" id="perm_telegram_notifications" class="form-check-input"> <?PHP HTML::print(TEXT_CREATE_APPLICATION_DIALOG_PERMISSIONS_TELEGRAM_NOTIFICATIONS_TEXT); ?>
                                                           <i class="input-helper"></i>
                                                       </label>
                                                   </div>
                                                   <p class="text-muted text-small"><?PHP HTML::print(TEXT_CREATE_APPLICATION_DIALOG_PERMISSIONS_TELEGRAM_NOTIFICATIONS_DESCRIPTION); ?></p>
                                               </div>
                                               <div class="col-md-6">
                                                   <div class="form-check">
                                                       <label class="form-check-label">
                                                           <input type="checkbox" name="perm_view_personal_information" class="form-check-input"> <?PHP HTML::print(TEXT_CREATE_APPLICATION_DIALOG_PERMISSIONS_VIEW_PERSONAL_INFORMATION_TEXT); ?>
                                                           <i class="input-helper"></i>
                                                       </label>
                                                   </div>
                                                   <p class="text-muted text-small pb-4"><?PHP HTML::print(TEXT_CREATE_APPLICATION_DIALOG_PERMISSIONS_VIEW_PERSONAL_INFORMATION_DESCRIPTION); ?></p>
                                               </div>
                                           </div>
                                       </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light" data-dismiss="modal"><?PHP HTML::print(TEXT_CREATE_APPLICATION_DIALOG_CANCEL_BUTTON); ?></button>
                                        <input type="submit" class="btn btn-success" value="<?PHP HTML::print(TEXT_CREATE_APPLICATION_DIALOG_SUBMIT_BUTTON); ?>">
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