<?php

    use DynamicalWeb\Actions;
    use DynamicalWeb\DynamicalWeb;
    use IntellivoidAccounts\Abstracts\SearchMethods\ApplicationSearchMethod;
use IntellivoidAccounts\Abstracts\SearchMethods\SubscriptionPlanSearchMethod;
use IntellivoidAccounts\Abstracts\SearchMethods\SubscriptionPromotionSearchMethod;
    use IntellivoidAccounts\Exceptions\ApplicationNotFoundException;
    use IntellivoidAccounts\Exceptions\InvalidSubscriptionPromotionNameException;
    use IntellivoidAccounts\Exceptions\SubscriptionPlanNotFoundException;
    use IntellivoidAccounts\Exceptions\SubscriptionPromotionNotFoundException;
    use IntellivoidAccounts\IntellivoidAccounts;

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

    if(isset($_GET['promotion_code']) == false)
    {
        validate_parameter_presence('promotion_id');
    }

    if(isset($_GET['promotion_id']) == false)
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
        $SubscriptionPlan = $IntellivoidAccounts->getSubscriptionPlanManager()->getSubscriptionPlanByName(
            $Application->ID, $_GET['plan_name']
        );

        $IntellivoidAccounts->getSubscriptionPlanManager()->getSubscriptionPlan(
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
            $SubscriptionPromotion = $IntellivoidAccounts->getSubscriptionPromotionManager()->getSubscriptionPromotion(
                SubscriptionPromotionSearchMethod::byPromotionCode, $_GET['promotion_code']
            );

            $IntellivoidAccounts->getSubscriptionPromotionManager()->getSubscriptionPromotion(
                SubscriptionPromotionSearchMethod::byPublicId, $_GET['promotion_id']
            );
        }
        catch (InvalidSubscriptionPromotionNameException $e)
        {
            Actions::redirect(DynamicalWeb::getRoute(
                'purchase_failure', array(
                    'error_type' => 'parameter_error',
                    'error' => 'invalid_promotion_name',
                    'step' => '1'
                )
            ));
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

    DynamicalWeb::setMemoryObject('subscription_plan', $SubscriptionPlan);
    DynamicalWeb::setMemoryObject('application', $Application);