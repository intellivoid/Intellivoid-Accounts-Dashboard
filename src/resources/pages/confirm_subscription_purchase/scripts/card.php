<?php

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use IntellivoidAccounts\Abstracts\AccountRequestPermissions;
    use IntellivoidAccounts\Abstracts\ApplicationFlags;
    use IntellivoidAccounts\Objects\COA\Application;
    use IntellivoidAccounts\Objects\SubscriptionPlan;

    $CardStyle = "";
    if(UI_EXPANDED)
    {
        $CardStyle = " style=\"height: calc(100% - 3px); position: fixed; width: 100%; overflow: auto; overflow-x: hidden;\"";
    }


    /** @var Application $Application */
    $Application = DynamicalWeb::getMemoryObject('application');

    /** @var array $SubscriptionDetails */
    $SubscriptionDetails = DynamicalWeb::getArray('subscription_details');

    /** @var SubscriptionPlan $SubscriptionPlan */
    $SubscriptionPlan = DynamicalWeb::getMemoryObject('subscription_plan');

    $UsernameSafe = ucfirst(WEB_ACCOUNT_USERNAME);
    if(strlen($UsernameSafe) > 16)
    {
        $UsernameSafe = substr($UsernameSafe, 0 ,16);
        $UsernameSafe .= "...";
    }

    $ApplicationNameSafe = ucfirst($Application->Name);
    if(strlen($ApplicationNameSafe) > 16)
    {
        $ApplicationNameSafe = substr($ApplicationNameSafe, 0 ,16);
        $ApplicationNameSafe .= "...";
    }

?>
<div class="linear-activity">
    <div id="linear-spinner" class="indeterminate"></div>
</div>
<div class="card rounded-0 mb-0"<?php HTML::print($CardStyle, false); ?>>
    <div class="card-header pt-50 pb-0 mb-0 mx-2 mt-2">
        <div class="card-title">
            <img src="/assets/images/logo_2.svg" alt="Intellivoid Accounts Brand" style="width: 130px; height: 30px;" class="img-fluid mb-2">
        </div>
    </div>
    <div class="card-content p-2 pt-0">
        <div class="card-body pt-0">
            <div class="d-flex mb-1">
                <div class="image-grouped mx-auto d-block">
                    <ul class="list-unstyled users-list d-flex">
                        <li data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" data-original-title="<?PHP HTML::print($UsernameSafe); ?>" class="avatar ml-0">
                            <img class="media-object rounded-circle" src="<?PHP DynamicalWeb::getRoute('avatar', array('user_id' => WEB_ACCOUNT_PUBID, 'resource' => 'normal'), true) ?>" alt="<?PHP HTML::print($UsernameSafe); ?>" height="64" width="64">
                        </li>
                        <li data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" data-original-title="<?PHP HTML::print($ApplicationNameSafe); ?>" class="avatar">
                            <img class="media-object rounded-circle" src="<?PHP DynamicalWeb::getRoute('application_icon', array('app_id' => $Application->PublicAppId, 'resource' => 'normal'), true) ?>" alt="<?PHP HTML::print($ApplicationNameSafe); ?>" height="64" width="64">
                        </li>
                    </ul>
                </div>
            </div>
            <h4 class="text-center">
                <?PHP HTML::print($Application->Name); ?>
                <?PHP
                if(in_array(ApplicationFlags::Verified, $Application->Flags))
                {
                    HTML::print("<i class=\"feather icon-shield text-success\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"" . TEXT_APPLICATION_TICK_VERIFIED . "\"></i>", false);
                }
                elseif(in_array(ApplicationFlags::Official, $Application->Flags))
                {
                    HTML::print("<i class=\"feather icon-shield text-primary\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"" . TEXT_APPLICATION_TICK_OFFICIAL . "\"></i>", false);
                }
                elseif(in_array(ApplicationFlags::Untrusted, $Application->Flags))
                {
                    HTML::print("<i class=\"feather icon-alert-octagon text-danger\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"" . TEXT_APPLICATION_TICK_UNTRUSTED . "\"></i>", false);
                }
                ?>
            </h4>
            <?PHP $_GET['action'] = 'process_transaction'; ?>
            <form id="purchase_form" name="purchase_form" class="pt-3">
                <h4 class="mb-75"><?PHP HTML::print(str_ireplace("%s", $Application->Name, TEXT_ACTIVATE_SUBSCRIPTION_HEADER)); ?></h4>

                <div id="callback_alert">
                    <?PHP
                    if(in_array(ApplicationFlags::Untrusted, $Application->Flags))
                    {
                        RenderAlert(TEXT_APPLICATION_DANGER_ALERT, "danger", "icon-alert-circle");
                    }
                    HTML::importScript('callbacks');
                    ?>
                </div>
                <div class="form-group mb-0" data-toggle="tooltip" data-placement="bottom" title="<?PHP HTML::print(TEXT_INITIAL_PAYMENT_TOOLTIP); ?>">
                    <div class="d-flex align-items-center py-50 text-black" >
                        <span class="feather icon-credit-card"></span>
                        <p class="mb-0 ml-1">
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
                        </p>
                    </div>
                </div>
                <div class="form-group mb-0" data-toggle="tooltip" data-placement="bottom" title="<?PHP HTML::print(TEXT_BILLING_CYCLE_TOOLTIP); ?>">
                    <div class="d-flex align-items-center py-50 text-black" >
                        <span class="feather icon-clock"></span>
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
                        <p class="mb-0 ml-1"><?PHP HTML::print($Text); ?></p>
                    </div>
                </div>
                <div class="border-bottom pt-1"></div>

                <div class="form-group mt-1 mb-0">
                    <label for="confirm_password" id="confirm_password_label" class="label text-muted"><?PHP HTML::print(TEXT_CONFIRM_PASSWORD_LABEL); ?></label>
                    <input name="confirm_password" id="confirm_password" type="password" class="form-control" placeholder="*********" aria-autocomplete="none" autocomplete="off" required disabled>
                </div>
                <div class="form-group pb-0 mb-0 mt-2">
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

                    <button type="submit" id="submit_button" class="btn btn-primary waves-effect waves-light btn-block" disabled>
                        <span id="submit_label" hidden><?PHP HTML::print($Text); ?></span>
                        <span id="submit_preloader" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="card-footer<?PHP if(UI_EXPANDED){ HTML::print(" mt-auto"); } ?>">
        <?PHP HTML::importSection('authentication_footer'); ?>
    </div>
</div>