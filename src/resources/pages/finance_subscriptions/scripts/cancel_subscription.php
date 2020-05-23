<?php

    use DynamicalWeb\Actions;
    use DynamicalWeb\DynamicalWeb;
    use IntellivoidAccounts\Abstracts\SearchMethods\SubscriptionSearchMethod;
    use IntellivoidAccounts\Exceptions\SubscriptionNotFoundException;
    use IntellivoidAccounts\IntellivoidAccounts;

    if(isset($_GET['action']))
    {
        if($_GET['action'] == 'cancel_subscription')
        {
            if(isset($_GET['subscription_id']))
            {
                cancel_subscription($_GET['subscription_id']);
            }
        }
    }

    function cancel_subscription(string $access_id)
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

        try
        {
            $Subscription = $IntellivoidAccounts->getSubscriptionManager()->getSubscription(
                SubscriptionSearchMethod::byPublicId, $_GET['subscription_id']
            );
        }
        catch (SubscriptionNotFoundException $e)
        {
            Actions::redirect(DynamicalWeb::getRoute('manage_subscriptions', array('callback' => '100')));
        }
        catch(Exception $e)
        {
            Actions::redirect(DynamicalWeb::getRoute('manage_subscriptions', array('callback' => '101')));
        }

        try
        {
            $IntellivoidAccounts->getSubscriptionManager()->cancelSubscription($Subscription);
        }
        catch(Exception $e)
        {
            Actions::redirect(DynamicalWeb::getRoute('manage_subscriptions', array('callback' => '101')));
        }

        Actions::redirect(DynamicalWeb::getRoute('manage_subscriptions', array('callback' => '102')));

    }
