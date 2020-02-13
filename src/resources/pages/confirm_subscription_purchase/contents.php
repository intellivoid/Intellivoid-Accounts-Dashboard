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

    HTML::importScript('render_alert');
    HTML::importScript('request_parser');
    HTML::importScript('sp_validate_parameters');
    HTML::importScript('sp_validate_access');
    HTML::importScript('process_purchase');

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
        <title><?PHP HTML::print(TEXT_PAGE_TITLE); ?></title>
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
                                    <span class="text-dark pl-3"><?PHP HTML::print(TEXT_CARD_HEADER); ?></span>
                                </div>
                                <div id="callback_alert">
                                    <?PHP HTML::importScript('callbacks'); ?>
                                </div>

                                <div class="d-flex mb-2">
                                    <div class="image-grouped mx-auto d-block">
                                        <img src="<?PHP DynamicalWeb::getRoute('avatar', array('user_id' => WEB_ACCOUNT_PUBID, 'resource' => 'normal'), true) ?>" alt="<?PHP HTML::print(TEXT_USER_IMG_ALT); ?>">
                                        <img src="<?PHP DynamicalWeb::getRoute('application_icon', array('app_id' => $Application->PublicAppId, 'resource' => 'normal'), true) ?>" alt="<?PHP HTML::print(TEXT_APP_IMG_ALT); ?>">
                                    </div>
                                </div>

                                <h4 class="text-center">
                                    <?PHP HTML::print($Application->Name); ?>
                                    <?PHP
                                        if(in_array(ApplicationFlags::Verified, $Application->Flags))
                                        {
                                            HTML::print("<i class=\"mdi mdi-verified text-success\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"" . TEXT_APPLICATION_TICK_VERIFIED . "\"></i>", false);
                                        }
                                        elseif(in_array(ApplicationFlags::Official, $Application->Flags))
                                        {
                                            HTML::print("<i class=\"mdi mdi-verified text-primary\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"" . TEXT_APPLICATION_TICK_OFFICIAL . "\"></i>", false);
                                        }
                                        elseif(in_array(ApplicationFlags::Untrusted, $Application->Flags))
                                        {
                                            HTML::print("<i class=\"mdi mdi-alert text-danger\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"" . TEXT_APPLICATION_TICK_UNTRUSTED . "\"></i>", false);
                                        }
                                    ?>
                                </h4>

                                <div class="border-bottom pt-3"></div>
                                <?PHP $_GET['action'] = 'process_transaction'; ?>
                                <form id="purchase_form" name="purchase_form" method="POST" action="<?PHP DynamicalWeb::getRoute('confirm_subscription_purchase', $_GET, true); ?>" class="pt-4">
                                    <h6 class="mb-3"><?PHP HTML::print(str_ireplace("%s", $Application->Name, TEXT_ACTIVATE_SUBSCRIPTION_HEADER)); ?></h6>
                                    <div class="form-group" data-toggle="tooltip" data-placement="bottom" title="<?PHP HTML::print(TEXT_INITIAL_PAYMENT_TOOLTIP); ?>">
                                        <div class="d-flex align-items-center py-1 text-black" >
                                            <span class="mdi mdi-currency-usd"></span>
                                            <p class="mb-0 ml-3">
                                                <?PHP
                                                    if(isset($SubscriptionDetails['promotion_code']))
                                                    {
                                                        $Text = TEXT_INITIAL_PAYMENT_PROMOTION_ACTIVE;
                                                        $Text = str_ireplace('%pp', $SubscriptionDetails['initial_price'], $Text);
                                                        $Text = str_ireplace('%op', $SubscriptionPlan->InitialPrice, $Text);
                                                        HTML::print($Text);
                                                    }
                                                    else
                                                    {
                                                        $Text = TEXT_INITIAL_PAYMENT_CYCLE_TEXT;
                                                        $Text = str_ireplace('%pp', $SubscriptionDetails['initial_price'], $Text);
                                                        HTML::print($Text);
                                                    }
                                                ?>
                                                <?PHP  ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="form-group" data-toggle="tooltip" data-placement="bottom" title="<?PHP HTML::print(TEXT_BILLING_CYCLE_TOOLTIP); ?>">
                                        <div class="d-flex align-items-center py-1 text-black" >
                                            <span class="mdi mdi-timer"></span>
                                            <?PHP
                                                if(isset($SubscriptionDetails['promotion_code']))
                                                {
                                                    $Text = TEXT_BILLING_CYCLE_PROMOTION_ACTIVE;
                                                    $Text = str_ireplace("%pp", $SubscriptionDetails['cycle_price'], $Text);
                                                    $Text = str_ireplace("%bc", intval(abs($SubscriptionDetails['billing_cycle'])/60/60/24), $Text);
                                                    $Text = str_ireplace("%op", $SubscriptionPlan->CyclePrice, $Text);
                                                }
                                                else
                                                {
                                                    $Text = TEXT_BILLING_CYCLE_TEXT;
                                                    $Text = str_ireplace("%pp", $SubscriptionDetails['cycle_price'], $Text);
                                                    $Text = str_ireplace("%bc", intval(abs($SubscriptionDetails['billing_cycle'])/60/60/24), $Text);
                                                }
                                            ?>
                                            <p class="mb-0 ml-3"><?PHP HTML::print($Text); ?></p>
                                        </div>
                                    </div>
                                    <div class="border-bottom pt-1"></div>

                                    <div class="form-group mt-4">
                                        <label for="confirm_password" id="label_1" class="label"><?PHP HTML::print(TEXT_CONFIRM_PASSWORD_LABEL); ?></label>
                                        <input name="confirm_password" id="confirm_password" type="password" class="form-control" placeholder="*********" aria-autocomplete="none" autocomplete="off" required>
                                    </div>
                                    <div class="form-group pb-2 pt-2">
                                        <?PHP
                                            $Text = TEXT_START_SUBSCRIPTION_BUTTON;
                                            if((float)$SubscriptionDetails['initial_price'] == 0)
                                            {
                                                $Text = TEXT_START_SUBSCRIPTION_BUTTON_FREE;
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
