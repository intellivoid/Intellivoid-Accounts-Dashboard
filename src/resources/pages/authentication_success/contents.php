<?PHP

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use DynamicalWeb\Javascript;
    use DynamicalWeb\Runtime;
use IntellivoidAccounts\Abstracts\AccountRequestPermissions;
use IntellivoidAccounts\Abstracts\ApplicationFlags;
use IntellivoidAccounts\Abstracts\AuthenticationMode;
use IntellivoidAccounts\Objects\COA\Application;
use IntellivoidAccounts\Objects\COA\AuthenticationAccess;
use IntellivoidAccounts\Objects\COA\AuthenticationRequest;

    Runtime::import('IntellivoidAccounts');
    HTML::importScript('validate_coa');
    HTML::importScript('validate_access_token');

    /** @var Application $Application */
    $Application = DynamicalWeb::getMemoryObject('application');

    /** @var AuthenticationAccess $AuthenticationAccess */
    $AuthenticationAccess = DynamicalWeb::getMemoryObject('access_token');
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
                                    <span class="text-dark pl-3">Sign in with Intellivoid Accounts</span>
                                </div>
                                <div class="d-flex mb-2">
                                    <div class="image-grouped mx-auto d-block">
                                        <img src="<?PHP DynamicalWeb::getRoute('avatar', array('user_id' => WEB_ACCOUNT_PUBID, 'resource' => 'normal'), true) ?>" alt="User Avatar">
                                        <img src="<?PHP DynamicalWeb::getRoute('application_icon', array('app_id' => $Application->PublicAppId, 'resource' => 'normal'), true) ?>" alt="Application Logo">
                                    </div>
                                </div>
                                <h4 class="text-center">
                                    <?PHP HTML::print($Application->Name); ?>
                                    <?PHP
                                        if(in_array(ApplicationFlags::Official, $Application->Flags))
                                        {
                                            HTML::print("<i class=\"mdi mdi-verified text-success\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"This is verified & trusted\"></i>", false);
                                        }
                                        elseif(in_array(ApplicationFlags::Verified, $Application->Flags))
                                        {
                                            HTML::print("<i class=\"mdi mdi-verified text-primary\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"This is an official Intellivoid Application/Service\"></i>", false);
                                        }
                                        elseif(in_array(ApplicationFlags::Untrusted, $Application->Flags))
                                        {
                                            HTML::print("<i class=\"mdi mdi-alert text-danger\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"This is untrusted and unsafe\"></i>", false);
                                        }
                                    ?>

                                </h4>
                                <div class="border-bottom mt-4 mb-3"></div>

                                <div class="mt-5 mb-4 d-flex flex-column justify-content-center align-items-center">
                                    <h4>
                                        <i class="mdi mdi-check-circle text-success"></i> Successfully Authenticated
                                    </h4>
                                    <p><?PHP HTML::print(str_ireplace('%s', $Application->Name, "%s is processing your request")); ?></p>
                                </div>
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
