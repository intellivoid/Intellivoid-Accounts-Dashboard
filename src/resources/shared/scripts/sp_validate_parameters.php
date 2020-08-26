<?php

    use DynamicalWeb\Actions;
    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\Runtime;
    use IntellivoidAccounts\Abstracts\SearchMethods\ApplicationSearchMethod;
    use IntellivoidAccounts\Exceptions\ApplicationNotFoundException;
    use IntellivoidAccounts\IntellivoidAccounts;
    use IntellivoidSubscriptionManager\Abstracts\SearchMethods\SubscriptionPlanSearchMethod;
    use IntellivoidSubscriptionManager\Abstracts\SearchMethods\SubscriptionPromotionSearchMethod;
    use IntellivoidSubscriptionManager\Exceptions\SubscriptionPlanNotFoundException;
    use IntellivoidSubscriptionManager\Exceptions\SubscriptionPromotionNotFoundException;
    use IntellivoidSubscriptionManager\IntellivoidSubscriptionManager;
    use IntellivoidSubscriptionManager\Objects\Subscription\Properties;

    // Validate the parameters
    function validate_parameter_presence(string $parameter_name)
    {
        if(isset($_GET[$parameter_name]) == false)
        {
            Actions::redirect(DynamicalWeb::getRoute(
                'purchase_failure', array(
                    'error_type' => 'missing_parameter',
                    'parameter' => $parameter_name
                )
            ));
        }
    }

    validate_parameter_presence('plan_name');
    validate_parameter_presence('access_token');
    validate_parameter_presence('transaction_token');
    validate_parameter_presence('subscription_plan_id');
    validate_parameter_presence('app_tag');

    if(isset($_GET['promotion_code']))
    {
        validate_parameter_presence('promotion_id');
    }

    if(isset($_GET['promotion_id']))
    {
        validate_parameter_presence('promotion_code');
    }


    // Validate the information
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
        $Application = $IntellivoidAccounts->getApplicationManager()->getApplication(
            ApplicationSearchMethod::byId, $_GET['app_tag']
        );
    }
    catch (ApplicationNotFoundException $e)
    {
        Actions::redirect(DynamicalWeb::getRoute(
            'purchase_failure', array(
                'error_type' => 'parameter_error',
                'error' => 'invalid_app_tag'
            )
        ));
    }
    catch(Exception $e)
    {
        Actions::redirect(DynamicalWeb::getRoute(
            'purchase_failure', array(
                'error_type' => 'parameter_error',
                'error' => 'internal_server_error',
                'step' => '1'
            )
        ));
    }

    try
    {
        $SubscriptionPlan = $SubscriptionManager->getPlanManager()->getSubscriptionPlanByName(
            $Application->ID, $_GET['plan_name']
        );

        $SubscriptionPlanAlt = $SubscriptionManager->getPlanManager()->getSubscriptionPlan(
            SubscriptionPlanSearchMethod::byPublicId, $_GET['subscription_plan_id']
        );
    }
    catch (SubscriptionPlanNotFoundException $e)
    {
        Actions::redirect(DynamicalWeb::getRoute(
            'purchase_failure', array(
                'error_type' => 'parameter_error',
                'error' => 'invalid_plan_name',
                'step' => '1'
            )
        ));
    }
    catch(Exception $e)
    {
        Actions::redirect(DynamicalWeb::getRoute(
            'purchase_failure', array(
                'error_type' => 'parameter_error',
                'error' => 'internal_server_error',
                'step' => '2'
            )
        ));
    }

    if($SubscriptionPlan->PublicID !== $SubscriptionPlanAlt->PublicID)
    {
        Actions::redirect(DynamicalWeb::getRoute(
            'purchase_failure', array(
                'error_type' => 'parameter_error',
                'error' => 'invalid_plan_name',
                'step' => '1'
            )
        ));
    }

    if($SubscriptionPlan->ApplicationID !== $Application->ID)
    {
        Actions::redirect(DynamicalWeb::getRoute(
            'purchase_failure', array(
                'error_type' => 'parameter_error',
                'error' => 'invalid_plan_name',
                'step' => '2'
            )
        ));
    }

    if(isset($_GET['promotion_code']))
    {
        try
        {
            $SubscriptionPromotion = $SubscriptionManager->getPromotionManager()->getSubscriptionPromotion(
                SubscriptionPromotionSearchMethod::byPromotionCode, $_GET['promotion_code']
            );

            $SubscriptionManager->getPromotionManager()->getSubscriptionPromotion(
                SubscriptionPromotionSearchMethod::byPublicId, $_GET['promotion_id']
            );
        }
        catch (SubscriptionPromotionNotFoundException $e)
        {
            Actions::redirect(DynamicalWeb::getRoute(
                'purchase_failure', array(
                    'error_type' => 'parameter_error',
                    'error' => 'invalid_promotion_name',
                    'step' => '2'
                )
            ));
        }
        catch(Exception $e)
        {
            Actions::redirect(DynamicalWeb::getRoute(
                'purchase_failure', array(
                    'error_type' => 'parameter_error',
                    'error' => 'internal_server_error',
                    'step' => '3'
                )
            ));
        }

        if($SubscriptionPromotion->SubscriptionPlanID !== $SubscriptionPlan->ID)
        {
            Actions::redirect(DynamicalWeb::getRoute(
                'purchase_failure', array(
                    'error_type' => 'parameter_error',
                    'error' => 'invalid_promotion_name',
                    'step' => '3'
                )
            ));
        }

        DynamicalWeb::setBoolean('subscription_promotion_set', true);
        DynamicalWeb::setMemoryObject('subscription_promotion', $SubscriptionPromotion);
    }
    else
    {
        DynamicalWeb::setBoolean('subscription_promotion_set', false);
    }

    $SubscriptionDetails = array(
        'billing_cycle' => $SubscriptionPlan->BillingCycle,
        'plan_name' => $SubscriptionPlan->PlanName,
        'plan_id' => $SubscriptionPlan->PublicID,
        'features' => array()
    );

    $SubscriptionDetailsProperties = new Properties();

    foreach($SubscriptionPlan->Features as $feature)
    {
        $SubscriptionDetailsProperties->addFeature($feature);
    }

    if(isset($_GET['promotion_code']) == false)
    {
        $SubscriptionDetails['initial_price'] = $SubscriptionPlan->InitialPrice;
        $SubscriptionDetails['cycle_price'] = $SubscriptionPlan->CyclePrice;
    }
    else
    {
        $SubscriptionDetails['initial_price'] = $SubscriptionPromotion->InitialPrice;
        $SubscriptionDetails['cycle_price'] = $SubscriptionPromotion->CyclePrice;

        foreach($SubscriptionPromotion->Features as $feature)
        {
            $SubscriptionDetailsProperties->addFeature($feature);
        }

        $SubscriptionDetails['promotion_code'] = $SubscriptionPromotion->PromotionCode;
        $SubscriptionDetails['promotion_id'] = $SubscriptionPromotion->PublicID;
    }

    foreach($SubscriptionDetailsProperties->Features as $feature)
    {
        $SubscriptionDetails['features'][] = $feature->toArray();
    }

    DynamicalWeb::setMemoryObject('subscription_plan', $SubscriptionPlan);
    DynamicalWeb::setMemoryObject('application', $Application);
    DynamicalWeb::setArray('subscription_details', $SubscriptionDetails);