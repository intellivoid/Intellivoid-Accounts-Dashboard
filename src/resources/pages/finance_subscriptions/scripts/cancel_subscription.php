<?php

    use DynamicalWeb\Actions;
    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\Runtime;
    use IntellivoidSubscriptionManager\Abstracts\SearchMethods\SubscriptionSearchMethod;
    use IntellivoidSubscriptionManager\Exceptions\SubscriptionNotFoundException;
    use IntellivoidSubscriptionManager\IntellivoidSubscriptionManager;

    if(isset($_GET['action']))
    {
        if($_GET['action'] == 'cancel_subscription')
        {
            if(isset($_GET['subscription_id']))
            {
                /** @noinspection PhpUnhandledExceptionInspection */
                cancel_subscription($_GET['subscription_id']);
            }
        }
    }

    /**
     * Cancels an existing subscription
     *
     * @param string $access_id
     * @throws Exception
     */
    function cancel_subscription(string $access_id)
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        Runtime::import("SubscriptionManager");
        if(isset(DynamicalWeb::$globalObjects["subscription_manager"]) == false)
        {
            /** @var IntellivoidSubscriptionManager $SubscriptionManager */
            $SubscriptionManager = DynamicalWeb::setMemoryObject(
                "subscription_manager", new IntellivoidSubscriptionManager()
            );
        }
        else
        {
            /** @var IntellivoidSubscriptionManager $SubscriptionManager */
            $SubscriptionManager = DynamicalWeb::getMemoryObject("subscription_manager");
        }

        try
        {
            $Subscription = $SubscriptionManager->getSubscriptionManager()->getSubscription(
                SubscriptionSearchMethod::byPublicId, $_GET['subscription_id']
            );
        }
        catch (SubscriptionNotFoundException $e)
        {
            Actions::redirect(DynamicalWeb::getRoute('finance_subscriptions', array('callback' => '100')));
        }
        catch(Exception $e)
        {
            Actions::redirect(DynamicalWeb::getRoute('finance_subscriptions', array('callback' => '101')));
        }

        try
        {
            /** @noinspection PhpUndefinedVariableInspection */
            $SubscriptionManager->getSubscriptionManager()->cancelSubscription($Subscription);
        }
        catch(Exception $e)
        {
            Actions::redirect(DynamicalWeb::getRoute('finance_subscriptions', array('callback' => '101')));
        }

        Actions::redirect(DynamicalWeb::getRoute('finance_subscriptions', array('callback' => '102')));

    }
