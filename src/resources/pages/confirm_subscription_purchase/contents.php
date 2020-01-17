<?PHP

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use DynamicalWeb\Javascript;
    use DynamicalWeb\Runtime;
use IntellivoidAccounts\Abstracts\AccountRequestPermissions;
use IntellivoidAccounts\Abstracts\ApplicationFlags;
use IntellivoidAccounts\Abstracts\AuthenticationMode;
use IntellivoidAccounts\Objects\COA\Application;
use IntellivoidAccounts\Objects\COA\AuthenticationRequest;

    Runtime::import('IntellivoidAccounts');
    //HTML::importScript('validate_coa');
    //HTML::importScript('process_authentication');
    //HTML::importScript('render_alert');

    ///** @var Application $Application */
    //$Application = DynamicalWeb::getMemoryObject('application');

    ///** @var AuthenticationRequest $AuthenticationRequest */
    //$AuthenticationRequest = DynamicalWeb::getMemoryObject('auth_request');

    //$VerificationToken = hash('sha256', $AuthenticationRequest->CreatedTimestamp . $AuthenticationRequest->RequestToken . $Application->PublicAppId);

    //$ReqParameters = array(
    //    'auth' => 'application',
    //    'action' => 'authenticate',
    //    'application_id' => $_GET['application_id'],
    //    'request_token' => $_GET['request_token'],
    //    'exp' => $AuthenticationRequest->ExpiresTimestamp,
    //    'verification_token' => $VerificationToken,
    //);

    //if($Application->AuthenticationMode == AuthenticationMode::Redirect)
    //{
    //    $ReqParameters['redirect'] = $_GET['redirect'];
    //}

    //$AuthenticateRoute = DynamicalWeb::getRoute('application_authenticate', $ReqParameters);
?>
<!doctype html>
<html lang="<?PHP HTML::print(APP_LANGUAGE_ISO_639); ?>">
    <head>
        <?PHP HTML::importSection('headers'); ?>
        <link rel="stylesheet" href="/assets/css/extra.css">
        <title>Intellivoid Accounts - Authenticate</title>
    </head>

    <body>
        <div class="container-scroller">
            <div class="container-fluid page-body-wrapper full-page-wrapper">
                <div class="content-wrapper d-flex align-items-center auth area theme-one">
                    <?PHP HTML::importSection('background_animations'); ?>
                    <div class="row w-100 mx-auto">
                        <div class="col-lg-5 mx-auto">
                            <div class="linear-activity">
                                <div id="linear-spinner" class="indeterminate-none"></div>
                            </div>
                            <div class="auto-form-wrapper" style="border-radius: 0px; border-bottom-left-radius: 4px; border-bottom-right-radius: 4px;">
                                <div class="mr-auto mb-4">
                                    <img class="img-fluid img-xs" src="/assets/images/iv_logo.svg" alt="iv_logo"/>
                                    <span class="text-dark pl-3">Intellivoid Accounts</span>
                                </div>

                                <div class="border-bottom pt-3"></div>

                                <form id="authentication_form" action="#" method="POST" name="authentication_form" class="pt-4">
                                    <div class="form-group pb-2 mt-5">
                                        <input id="submit_button" type="submit" class="btn btn-primary submit-btn btn-block" value="Authenticate" disabled>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?PHP HTML::importSection('js_scripts'); ?>
        <script src="/assets/js/shared/tooltips.js"></script>
    </body>
</html>
