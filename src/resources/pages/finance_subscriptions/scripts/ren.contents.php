<?PHP

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use IntellivoidAccounts\Abstracts\SearchMethods\ApplicationSearchMethod;
    use IntellivoidAccounts\Abstracts\SearchMethods\SubscriptionPlanSearchMethod;
    use IntellivoidAccounts\IntellivoidAccounts;
    use IntellivoidAccounts\Objects\Subscription;

    function list_subscribed_services(array $Subscriptions)
    {
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

        ?>
        <div class="accordion" id="apps-accordion" role="tablist">
            <?PHP
                foreach($Subscriptions as $Subscription)
                {
                    $Subscription = Subscription::fromArray($Subscription);
                    $SubscriptionPlan = $IntellivoidAccounts->getSubscriptionPlanManager()->getSubscriptionPlan(
                        SubscriptionPlanSearchMethod::byId, $Subscription->SubscriptionPlanID
                    );
                    $Application = $IntellivoidAccounts->getApplicationManager()->getApplication(
                        ApplicationSearchMethod::byId, $SubscriptionPlan->ApplicationID
                    );
                    ?>
                    <div class="collapse-margin">
                        <div class="card-header" style="justify-content: normal;;" id="heading-<?PHP HTML::print($Subscription->PublicID); ?>" data-toggle="collapse" role="button" data-target="#collapse-<?PHP HTML::print($Subscription->PublicID); ?>" aria-expanded="false" aria-controls="collapse-<?PHP HTML::print($Subscription->PublicID); ?>">
                            <div data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" data-original-title="<?PHP HTML::print($Application->Name); ?>" class="avatar pull-up">
                                <img class="media-object rounded-circle" src="<?PHP DynamicalWeb::getRoute('application_icon', array('app_id' => $Application->PublicAppId, 'resource' => 'small'), true); ?>" alt="<?PHP HTML::print($Application->Name); ?>" height="30" width="30">
                            </div>
                            <div class="ml-1">
                                <h6 class="mb-0">
                                    <?PHP
                                        $Text = "%an (%sn)";
                                        $Text = str_ireplace('%an', $Application->Name, $Text);
                                        $Text = str_ireplace('%sn', $SubscriptionPlan->PlanName, $Text);
                                        HTML::print($Text);
                                    ?>
                                </h6>
                                <small class="text-muted d-none d-lg-inline">
                                    <?PHP HTML::print(str_ireplace('%s', gmdate("j/m/Y g:i a", $Subscription->CreatedTimestamp), TEXT_SUBSCRIPTION_START)); ?>
                                </small>
                                <small class="text-muted d-md-inline d-lg-none">
                                    <?PHP HTML::print(gmdate("j/m/Y g:i a", $Subscription->CreatedTimestamp)); ?>
                                </small>
                            </div>
                        </div>
                        <div id="collapse-<?PHP HTML::print($Subscription->PublicID); ?>" class="collapse" aria-labelledby="heading-<?PHP HTML::print($Subscription->PublicID); ?>" data-parent="#apps-accordion">
                            <div class="card-body pt-50 px-2">
                                <div class="row grid-margin d-flex mb-0">
                                    <div class="col-lg-9 mb-2">
                                        <div class="d-flex ml-2 align-items-center pb-50">
                                            <i class="feather icon-calendar"></i>
                                            <p class="mb-0 ml-2">
                                                <?PHP
                                                    $Text = TEXT_SUBSCRIPTION_BILLING;
                                                    $Text = str_ireplace('%nbc', gmdate("j/m/Y g:i a", $Subscription->NextBillingCycle), $Text);
                                                    $Text = str_ireplace('%cp', $Subscription->Properties->CyclePrice, $Text);
                                                    HTML::print($Text);
                                                ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 mt-auto mb-1">
                                        <button class="btn btn-block btn-square btn-outline-danger" onclick="location.href='<?PHP DynamicalWeb::getRoute('finance_subscriptions', array('action' => 'cancel_subscription', 'subscription_id' => $Subscription->PublicID), true); ?>';"><?PHP HTML::print(TEXT_CANCEL_SUBSCRIPTION_BUTTON); ?></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?PHP
                }
            ?>
        </div>
        <?PHP
    }