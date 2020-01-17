<?php


    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use IntellivoidAccounts\Abstracts\AccountRequestPermissions;
    use IntellivoidAccounts\Abstracts\SearchMethods\SubscriptionPlanSearchMethod;
    use IntellivoidAccounts\Abstracts\SearchMethods\SubscriptionPromotionSearchMethod;
    use IntellivoidAccounts\Abstracts\SubscriptionPlanStatus;
    use IntellivoidAccounts\Abstracts\SubscriptionPromotionStatus;
    use IntellivoidAccounts\Exceptions\SubscriptionPlanNotFoundException;
    use IntellivoidAccounts\Exceptions\SubscriptionPromotionNotFoundException;
    use IntellivoidAccounts\IntellivoidAccounts;
    use IntellivoidAccounts\Objects\Account;
    use IntellivoidAccounts\Objects\ApplicationAccess;
    use IntellivoidAccounts\Objects\COA\AuthenticationAccess;
    use IntellivoidAccounts\Objects\COA\AuthenticationRequest;
    use IntellivoidAccounts\Objects\Subscription\Feature;
    use IntellivoidAccounts\Objects\Subscription\Properties;

    HTML::importScript('async.check_access');

    /** @var AuthenticationRequest $AuthenticationRequest */
    $AuthenticationRequest = DynamicalWeb::getMemoryObject('authentication_request');

    /** @var AuthenticationAccess $AuthenticationAccess */
    $AuthenticationAccess = DynamicalWeb::getMemoryObject('authentication_access');

    /** @var ApplicationAccess $ApplicationAccess */
    $ApplicationAccess = DynamicalWeb::getMemoryObject('application_access');

    /** @var Account $Account */
    $Account = DynamicalWeb::getMemoryObject('account');

    /** @var IntellivoidAccounts $IntellivoidAccounts */
    $IntellivoidAccounts = DynamicalWeb::getMemoryObject("intellivoid_accounts");

    $Response = array(
        'status' => true,
        'status_code' => 200,
        'user_information' => array()
    );

    if($AuthenticationAccess->has_permission(AccountRequestPermissions::MakePurchases))
    {
        returnJsonResponse(array(
            'status' => false,
            'status_code' => 403,
            'error_code' => 30,
            'message' => resolve_error_code(30)
        ));
    }

    if(get_parameter('plan_id') == null)
    {
        returnJsonResponse(array(
            'status' => false,
            'status_code' => 400,
            'error_code' => 42,
            'message' => resolve_error_code(42)
        ));
    }

    $SubscriptionPlanName = get_parameter('plan_name');
    $SubscriptionPromotionCode = get_parameter('promotion_code');

    $SubscriptionPlan = null;
    $SubscriptionPlanPromotion = null;

    try
    {
        $SubscriptionPlan = $IntellivoidAccounts->getSubscriptionPlanManager()->getSubscriptionPlanByName(
            $ApplicationAccess->ApplicationID, $SubscriptionPlanName
        );
    }
    catch (SubscriptionPlanNotFoundException $e)
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

    if($SubscriptionPlan->ApplicationID !== $ApplicationAccess->ApplicationID)
    {
        returnJsonResponse(array(
            'status' => false,
            'status_code' => 400,
            'error_code' => 43,
            'message' => resolve_error_code(43)
        ));
    }

    if($SubscriptionPromotionCode !== null)
    {
        try
        {
            $SubscriptionPlanPromotion = $IntellivoidAccounts->getSubscriptionPromotionManager()->getSubscriptionPromotion(
                SubscriptionPromotionSearchMethod::byPromotionCode, $SubscriptionPromotionCode
            );
        }
        catch (SubscriptionPromotionNotFoundException $e)
        {
            returnJsonResponse(array(
                'status' => false,
                'status_code' => 400,
                'error_code' => 44,
                'message' => resolve_error_code(44)
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
    }

    if($SubscriptionPlan->Status == SubscriptionPlanStatus::Unavailable)
    {
        returnJsonResponse(array(
            'status' => false,
            'status_code' => 400,
            'error_code' => 45,
            'message' => resolve_error_code(45)
        ));
    }

    if($SubscriptionPromotionCode !== null)
    {
        if($SubscriptionPlanPromotion->SubscriptionPlanID !== $SubscriptionPlan->ID)
        {
            returnJsonResponse(array(
                'status' => false,
                'status_code' => 400,
                'error_code' => 48,
                'message' => resolve_error_code(38)
            ));
        }

        if($SubscriptionPlanPromotion->Status == SubscriptionPromotionStatus::Disabled)
        {
            returnJsonResponse(array(
                'status' => false,
                'status_code' => 400,
                'error_code' => 46,
                'message' => resolve_error_code(46)
            ));
        }


        if($SubscriptionPlanPromotion->Status == SubscriptionPromotionStatus::Expired)
        {
            returnJsonResponse(array(
                'status' => false,
                'status_code' => 400,
                'error_code' => 47,
                'message' => resolve_error_code(47)
            ));
        }
    }


    $Features = array();
    $PromotionFeatures = array();

    $PromotionObject = null;

    /** @var Feature $feature */
    foreach($SubscriptionPlan->Features as $feature)
    {
        $Features[] = $feature->toArray();
    }

    if($SubscriptionPlanPromotion !== null)
    {
        /** @var Feature $feature */
        foreach($SubscriptionPlanPromotion->Features as $feature)
        {
            $PromotionFeatures[] = $feature->toArray();
        }

        $PromotionObject = array(
            'id' => $SubscriptionPlanPromotion->PublicID,
            'code' => $SubscriptionPlanPromotion->PromotionCode,
            'features' => $PromotionFeatures,
            'initial_price' => $SubscriptionPlanPromotion->InitialPrice,
            'cycle_price' => $SubscriptionPlanPromotion->CyclePrice,
            'last_updated' => $SubscriptionPlanPromotion->LastUpdatedTimestamp,
            'created' => $SubscriptionPlanPromotion->CreatedTimestamp
        );
    }

    $SubscriptionDetails = array(
        'billing_cycle' => $SubscriptionPlan->BillingCycle,
        'plan_name' => $SubscriptionPlan->PlanName,
        'plan_id' => $SubscriptionPlan->PublicID,
        'features' => array()
    );

    $SubscriptionDetailsProperties = new Properties();
    $PurchaseParameters = array(
        'plan_name'=> $SubscriptionPlan->PlanName,
        'access_token' => $AuthenticationAccess->AccessToken,
        'transaction_token' => hash('crc32b', time()),
        'subscription_plan_id' => $SubscriptionPlan->PublicID,
        'app_tag' => $ApplicationAccess->ApplicationID
    );

    foreach($SubscriptionPlan->Features as $feature)
    {
        $SubscriptionDetailsProperties->addFeature($feature);
    }

    if($SubscriptionPlanPromotion == null)
    {
        $SubscriptionDetails['initial_price'] = $SubscriptionPlan->InitialPrice;
        $SubscriptionDetails['cycle_price'] = $SubscriptionPlan->CyclePrice;
    }
    else
    {
        $SubscriptionDetails['initial_price'] = $SubscriptionPlanPromotion->InitialPrice;
        $SubscriptionDetails['cycle_price'] = $SubscriptionPlanPromotion->CyclePrice;

        foreach($SubscriptionPlanPromotion->Features as $feature)
        {
            $SubscriptionDetailsProperties->addFeature($feature);
        }

        $PurchaseParameters['promotion_code'] = $SubscriptionPlanPromotion->PromotionCode;
        $PurchaseParameters['promotion_id'] = $SubscriptionPlanPromotion->PublicID;
    }

    foreach($SubscriptionDetailsProperties->Features as $feature)
    {
        $SubscriptionDetails['features'][] = $feature->toArray();
    }

    returnJsonResponse(array(
        'status' => true,
        'status_code' => 200,
        'payload' => array(
            'subscription_plan' => array(
                'id' => $SubscriptionPlan->PublicID,
                'name' => $SubscriptionPlan->PlanName,
                'features' => $Features,
                'initial_price' => $SubscriptionPlan->InitialPrice,
                'cycle_price' => $SubscriptionPlan->CyclePrice,
                'billing_cycle' => $SubscriptionPlan->BillingCycle,
                'last_updated' => $SubscriptionPlan->LastUpdated,
                'created' => $SubscriptionPlan->CreatedTimestamp
            ),
            'subscription_promotion' => $PromotionObject,
            'subscription_details' =>  $SubscriptionDetails,
            'process_transaction_url' => DynamicalWeb::getRoute('confirm_subscription_purchase', $PurchaseParameters)
        )
    ));