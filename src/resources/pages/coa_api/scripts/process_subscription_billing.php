<?php

    use DynamicalWeb\DynamicalWeb;
    use IntellivoidAccounts\Abstracts\SearchMethods\SubscriptionSearchMethod;
    use IntellivoidAccounts\Exceptions\AccountNotFoundException;
    use IntellivoidAccounts\Exceptions\ApplicationNotFoundException;
    use IntellivoidAccounts\Exceptions\InsufficientFundsException;
    use IntellivoidAccounts\Exceptions\SubscriptionNotFoundException;
    use IntellivoidAccounts\Exceptions\SubscriptionPlanNotFoundException;
    use IntellivoidAccounts\Exceptions\SubscriptionPromotionNotFoundException;
    use IntellivoidAccounts\IntellivoidAccounts;


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
            SubscriptionSearchMethod::byId, (int)$SubscriptionID
        );
    }
    catch (SubscriptionNotFoundException $e)
    {
        returnJsonResponse(array(
            'status' => false,
            'response_code' => 400,
            'error_code' => 43,
            'message' => resolve_error_code(43)
        ));
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
        $Results = $IntellivoidAccounts->getSubscriptionManager()->processBilling($Subscription);

        if($Results == true)
        {
            $Subscription->NextBillingCycle = (int)time() + (int)$Subscription->BillingCycle;
            $IntellivoidAccounts->getSubscriptionManager()->updateSubscription($Subscription);

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
    catch (SubscriptionPlanNotFoundException $e)
    {
        returnJsonResponse(array(
            'status' => false,
            'response_code' => 500,
            'error_code' => 43,
            'message' => resolve_error_code(43)
        ));
    }
    catch (SubscriptionPromotionNotFoundException $e)
    {
        returnJsonResponse(array(
            'status' => false,
            'response_code' => 500,
            'error_code' => 44,
            'message' => resolve_error_code(44)
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