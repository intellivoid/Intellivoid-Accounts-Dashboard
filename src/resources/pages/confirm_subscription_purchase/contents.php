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
use IntellivoidAccounts\Objects\SubscriptionPlan;

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

    HTML::importScript('request_parser');
    HTML::importScript('sp_validate_parameters');
    HTML::importScript('sp_validate_access');

    /** @var Application $Application */
    $Application = DynamicalWeb::getMemoryObject('application');

    /** @var array $SubscriptionDetails */
    $SubscriptionDetails = DynamicalWeb::getArray('subscription_details');

    /** @var SubscriptionPlan $SubscriptionPlan */
    $SubscriptionPlan = DynamicalWeb::getMemoryObject('subscription_plan');
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

                                <div class="border-bottom pt-3"></div>

                                <form id="authentication_form" name="authentication_form" class="pt-4">
                                    <h6 class="mb-3"><?PHP HTML::print(str_ireplace("%s", $Application->Name, 'Activate subscription for %s')); ?></h6>
                                    <div class="form-group" data-toggle="tooltip" data-placement="bottom" title="The billing cycle is when your subscription's billing gets processed automatically">
                                        <div class="d-flex align-items-center py-1 text-black" >
                                            <span class="mdi mdi-currency-usd"></span>
                                            <p class="mb-0 ml-3">
                                                <?PHP
                                                    if(isset($SubscriptionDetails['promotion_code']))
                                                    {
                                                        $Text = "You will initially pay $%pp USD to start this subscription instead of $%op USD";
                                                        $Text = str_ireplace('%pp', $SubscriptionDetails['initial_price'], $Text);
                                                        $Text = str_ireplace('%op', $SubscriptionPlan->InitialPrice, $Text);
                                                        HTML::print($Text);
                                                    }
                                                    else
                                                    {
                                                        $Text = "You will initially pay $%pp USD to start this subscription";
                                                        $Text = str_ireplace('%pp', $SubscriptionDetails['initial_price'], $Text);
                                                        HTML::print($Text);
                                                    }
                                                ?>
                                                <?PHP  ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="form-group" data-toggle="tooltip" data-placement="bottom" title="The billing cycle is when your subscription's billing gets processed automatically">
                                        <div class="d-flex align-items-center py-1 text-black" >
                                            <span class="mdi mdi-timer"></span>
                                            <?PHP
                                                if(isset($SubscriptionDetails['promotion_code']))
                                                {
                                                    $Text = "You will automatically be billed $%pp USD every %bc days instead of $%op USD";
                                                    $Text = str_ireplace("%pp", $SubscriptionDetails['cycle_price'], $Text);
                                                    $Text = str_ireplace("%bc", intval(abs($SubscriptionDetails['billing_cycle'])/60/60/24), $Text);
                                                    $Text = str_ireplace("%op", $SubscriptionPlan->CyclePrice, $Text);
                                                }
                                                else
                                                {
                                                    $Text = "You will automatically be billed $%pp USD every %bc days";
                                                    $Text = str_ireplace("%pp", $SubscriptionDetails['cycle_price'], $Text);
                                                    $Text = str_ireplace("%bc", intval(abs($SubscriptionDetails['billing_cycle'])/60/60/24), $Text);
                                                }
                                            ?>
                                            <p class="mb-0 ml-3"><?PHP HTML::print($Text); ?></p>
                                        </div>
                                    </div>
                                    <div class="border-bottom pt-1"></div>

                                    <div class="form-group mt-4">
                                        <label for="confirm_password" id="label_1" class="label">Confirm Password</label>
                                        <input name="confirm_password" id="confirm_password" type="password" class="form-control" placeholder="*********" aria-autocomplete="none" autocomplete="off" required>
                                    </div>
                                    <div class="form-group pb-2 pt-2">
                                        <?PHP
                                            $Text = "Start Subscription ($%s USD)";
                                            if((float)$SubscriptionDetails['initial_price'] == 0)
                                            {
                                                $Text = "Start Subscription (FREE)";
                                            }
                                            else
                                            {
                                                $Text = str_ireplace('%s', $SubscriptionDetails['initial_price'], $Text);
                                            }
                                        ?>
                                        <input id="submit_button" type="submit" class="btn btn-success submit-btn btn-block" value="<?PHP HTML::print($Text); ?>" disabled>
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
        <?PHP Javascript::importScript('autoenable'); ?>
    </body>
</html>
