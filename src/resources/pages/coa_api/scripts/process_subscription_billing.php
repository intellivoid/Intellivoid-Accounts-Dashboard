<?php

    use IntellivoidAccounts\Abstracts\SearchMethods\SubscriptionSearchMethod;
    use IntellivoidAccounts\Exceptions\AccountNotFoundException;
    use IntellivoidAccounts\Exceptions\ApplicationNotFoundException;
    use IntellivoidAccounts\Exceptions\InsufficientFundsException;
    use IntellivoidAccounts\Exceptions\SubscriptionNotFoundException;
    use IntellivoidAccounts\Exceptions\SubscriptionPlanNotFoundException;
    use IntellivoidAccounts\Exceptions\SubscriptionPromotionNotFoundException;


    $SubscriptionID = get_parameter('subscription_id');

    if($SubscriptionID == null)
    {
        returnJsonResponse(array(
            'status' => false,
            'status_code' => 400,
            'error_code' => 42,
            'message' => resolve_error_code(42)
        ));
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
            'status_code' => 400,
            'error_code' => 43,
            'message' => resolve_error_code(43)
        ));
    }
    catch(Exception $e)
    {
        returnJsonResponse(array(
            'status' => false,
            'status_code' => 400,
            'error_code' => -1,
            'message' => resolve_error_code(-1)
        ));
    }

    try
    {
        $Results = $IntellivoidAccounts->getSubscriptionManager()->processBilling($Subscription);

        if($Results == true)
        {
            returnJsonResponse(array(
                'status' => true,
                'status_code' => 200,
                'payment_processed' => true
            ));
        }
        else
        {
            returnJsonResponse(array(
                'status' => true,
                'status_code' => 200,
                'payment_processed' => false
            ));
        }
    }
    catch (AccountNotFoundException $e)
    {
        returnJsonResponse(array(
            'status' => false,
            'status_code' => 500,
            'error_code' => 26,
            'message' => resolve_error_code(26)
        ));
    }
    catch (ApplicationNotFoundException $e)
    {
        returnJsonResponse(array(
            'status' => false,
            'status_code' => 500,
            'error_code' => 4,
            'message' => resolve_error_code(4)
        ));
    }
    catch (InsufficientFundsException $e)
    {
        returnJsonResponse(array(
            'status' => false,
            'status_code' => 400,
            'error_code' => 49,
            'message' => resolve_error_code(49)
        ));
    }
    catch (SubscriptionPlanNotFoundException $e)
    {
        returnJsonResponse(array(
            'status' => false,
            'status_code' => 500,
            'error_code' => 43,
            'message' => resolve_error_code(43)
        ));
    }
    catch (SubscriptionPromotionNotFoundException $e)
    {
        returnJsonResponse(array(
            'status' => false,
            'status_code' => 500,
            'error_code' => 44,
            'message' => resolve_error_code(44)
        ));
    }
    catch(Exception $e)
    {
        returnJsonResponse(array(
            'status' => false,
            'status_code' => 500,
            'error_code' => -1,
            'message' => resolve_error_code(-1)
        ));
    }