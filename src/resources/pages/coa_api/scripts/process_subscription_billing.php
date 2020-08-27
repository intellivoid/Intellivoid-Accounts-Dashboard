<?php

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\Runtime;
    use IntellivoidAccounts\Exceptions\AccountNotFoundException;
    use IntellivoidAccounts\Exceptions\ApplicationNotFoundException;
    use IntellivoidAccounts\Exceptions\InsufficientFundsException;
    use IntellivoidAccounts\IntellivoidAccounts;
    use IntellivoidSubscriptionManager\Abstracts\SearchMethods\SubscriptionSearchMethod;
    use IntellivoidSubscriptionManager\IntellivoidSubscriptionManager;

    $SubscriptionID = get_parameter('subscription_id');

    if($SubscriptionID == null)
    {
        returnJsonResponse(array(
            'status' => false,
            'response_code' => 400,
            'error_code' => 42,
            'message' => resolve_error_code(42)
        ));
    }

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

    /** @noinspection PhpUnhandledExceptionInspection */
    Runtime::import('IntellivoidAccounts');
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
        $Subscription = $SubscriptionManager->getSubscriptionManager()->getSubscription(
            SubscriptionSearchMethod::byId, (int)$SubscriptionID
        );
    }
    catch(Exception $e)
    {
        returnJsonResponse(array(
            'status' => false,
            'response_code' => 400,
            'error_code' => -1,
            'message' => resolve_error_code(-1)
        ));
    }

    try
    {
        $Results = $IntellivoidAccounts->getAccountManager()->processBilling($SubscriptionManager, $Subscription);

        if($Results == true)
        {
            $Subscription->NextBillingCycle = (int)time() + (int)$Subscription->BillingCycle;
            $SubscriptionManager->getSubscriptionManager()->updateSubscription($Subscription);

            returnJsonResponse(array(
                'status' => true,
                'response_code' => 200,
                'payment_processed' => true
            ));
        }
        else
        {
            returnJsonResponse(array(
                'status' => true,
                'response_code' => 200,
                'payment_processed' => false
            ));
        }
    }
    catch (AccountNotFoundException $e)
    {
        returnJsonResponse(array(
            'status' => false,
            'response_code' => 500,
            'error_code' => 26,
            'message' => resolve_error_code(26)
        ));
    }
    catch (ApplicationNotFoundException $e)
    {
        returnJsonResponse(array(
            'status' => false,
            'response_code' => 500,
            'error_code' => 4,
            'message' => resolve_error_code(4)
        ));
    }
    catch (InsufficientFundsException $e)
    {
        returnJsonResponse(array(
            'status' => false,
            'response_code' => 400,
            'error_code' => 49,
            'message' => resolve_error_code(49)
        ));
    }
    catch(Exception $e)
    {
        returnJsonResponse(array(
            'status' => false,
            'response_code' => 500,
            'error_code' => -1,
            'message' => resolve_error_code(-1)
        ));
    }