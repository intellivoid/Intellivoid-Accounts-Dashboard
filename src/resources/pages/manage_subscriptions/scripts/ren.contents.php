<?PHP

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use IntellivoidAccounts\Abstracts\AccountRequestPermissions;
    use IntellivoidAccounts\Abstracts\ApplicationAccessStatus;
    use IntellivoidAccounts\Abstracts\SearchMethods\ApplicationSearchMethod;
use IntellivoidAccounts\Abstracts\SearchMethods\SubscriptionPlanSearchMethod;
use IntellivoidAccounts\Exceptions\ApplicationNotFoundException;
use IntellivoidAccounts\IntellivoidAccounts;
    use IntellivoidAccounts\Objects\ApplicationAccess;
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
        <div class="accordion" id="subscription-accordion" role="tablist">
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
                    <div class="card accordion-minimal">
                        <div class="card-header" role="tab" id="heading-<?PHP HTML::print($Subscription->PublicID); ?>">
                            <a class="mb-0 d-flex collapsed" data-toggle="collapse" href="#collapse-<?PHP HTML::print($Subscription->PublicID); ?>" aria-expanded="false" aria-controls="collapse-<?PHP HTML::print($Application->PublicAppId); ?>">
                                <img class="img-xs rounded-circle mt-2" src="<?PHP DynamicalWeb::getRoute('application_icon', array('app_id' => $Application->PublicAppId, 'resource' => 'small'), true); ?>" alt="profile image">

                                <div class="ml-3">
                                    <h6 class="mb-0">
                                        <?PHP
                                            $Text = "%an (%sn)";
                                            $Text = str_ireplace('%an', $Application->Name, $Text);
                                            $Text = str_ireplace('%sn', $SubscriptionPlan->PlanName, $Text);

                                            HTML::print($Text);
                                        ?>
                                    </h6>
                                    <small class="text-muted"><?PHP HTML::print(str_ireplace('%s', gmdate("j/m/Y g:i a", $Subscription->CreatedTimestamp), 'Started on: %s')); ?></small>
                                </div>
                            </a>
                        </div>
                        <div id="collapse-<?PHP HTML::print($Subscription->PublicID); ?>" class="collapse" role="tabpanel" aria-labelledby="heading-<?PHP HTML::print($SubscriptionPlan->PublicID); ?>" data-parent="#subscription-accordion">
                            <div class="card-body">
                                <div class="ml-2 mr-2 row grid-margin d-flex mb-0">
                                    <div class="col-lg-9 mb-2">
                                        <div class="d-flex ml-2 align-items-center py-1 pb-2">
                                            <i class="mdi mdi-calendar-clock mdi-18px"></i>
                                            <p class="mb-0 ml-3">
                                                <?PHP $Text = 'You will be billed $%cp USD on %nbc'; ?>
                                                <?PHP $Text = str_ireplace('%nbc', gmdate("j/m/Y g:i a", $Subscription->NextBillingCycle), $Text); ?>
                                                <?PHP $Text = str_ireplace('%cp', $Subscription->Properties->CyclePrice, $Text); ?>
                                                <?PHP HTML::print($Text); ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 mt-auto mb-2">
                                        <button class="btn btn-block btn-outline-danger" onclick="location.href='<?PHP DynamicalWeb::getRoute('manage_subscriptions', array('action' => 'cancel_subscription', 'subscription_id' => $Subscription->PublicID), true); ?>';">Cancel Subscription</button>
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