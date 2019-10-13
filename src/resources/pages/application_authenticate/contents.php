<?PHP

use DynamicalWeb\DynamicalWeb;
use DynamicalWeb\HTML;
use DynamicalWeb\Javascript;
use DynamicalWeb\Runtime;

    Runtime::import('IntellivoidAccounts');

?>
<!doctype html>
<html lang="<?PHP HTML::print(APP_LANGUAGE_ISO_639); ?>">
    <head>
        <?PHP HTML::importSection('headers'); ?>
        <link rel="stylesheet" href="/assets/css/extra.css">
        <title>Intellivoid Accounts - Au</title>
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
                                    <span class="text-dark pl-3">Sign in with Intellivoid Accounts</span>
                                </div>
                                <div class="d-flex mb-2">
                                    <div class="image-grouped mx-auto d-block">
                                        <img src="<?PHP DynamicalWeb::getRoute('avatar', array('user_id' => WEB_ACCOUNT_PUBID, 'resource' => 'normal'), true) ?>" alt="User Avatar">
                                        <img src="<?PHP DynamicalWeb::getRoute('application_icon', array('app_id' => $_GET['application_id'], 'resource' => 'normal'), true) ?>" alt="Application Loggo">
                                    </div>
                                </div>

                                <h4 class="text-center">CoffeeHouse</h4>

                                <div id="callback_alert">
                                    <?PHP HTML::importScript('callbacks'); ?>
                                </div>

                                <div class="border-bottom pt-3"></div>

                                <form id="authentication_form" name="authentication_form" class="pt-4">
                                    <h6 class="mb-5">This application would like to have access to</h6>
                                    <div class="form-group">
                                        <div class="d-flex align-items-center py-1 text-black" >
                                            <span class="mdi mdi-account"></span>
                                            <p class="mb-0 ml-3">View your personal information</p>
                                            <div class="form-check ml-auto mb-0 mt-0">
                                                <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" checked> Allow Access
                                                    <i class="input-helper"></i>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="d-flex align-items-center py-1 text-black" >
                                            <span class="mdi mdi-account-edit"></span>
                                            <p class="mb-0 ml-3">Edit your personal information</p>
                                            <div class="form-check ml-auto mb-0 mt-0">
                                                <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" checked> Allow Access
                                                    <i class="input-helper"></i>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group pb-2 mt-5">
                                        <input id="submit_button" type="submit" class="btn btn-primary submit-btn btn-block" value="Authenticate">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?PHP HTML::importSection('js_scripts'); ?>
        <?PHP Javascript::importScript('sudo'); ?>
    </body>
</html>
