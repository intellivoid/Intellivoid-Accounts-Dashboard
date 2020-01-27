<?php

    use DynamicalWeb\Actions;
    use DynamicalWeb\DynamicalWeb;
    use IntellivoidAccounts\Exceptions\AccountLimitedException;
    use IntellivoidAccounts\Exceptions\AccountNotFoundException;
    use IntellivoidAccounts\Exceptions\AccountSuspendedException;
    use IntellivoidAccounts\Exceptions\ApplicationNotFoundException;
    use IntellivoidAccounts\Exceptions\IncorrectLoginDetailsException;
    use IntellivoidAccounts\Exceptions\InsufficientFundsException;
    use IntellivoidAccounts\Exceptions\InvalidAccountStatusException;
    use IntellivoidAccounts\Exceptions\InvalidEmailException;
    use IntellivoidAccounts\Exceptions\InvalidFundsValueException;
    use IntellivoidAccounts\Exceptions\InvalidUsernameException;
    use IntellivoidAccounts\Exceptions\InvalidVendorException;
    use IntellivoidAccounts\Exceptions\SubscriptionNotFoundException;
    use IntellivoidAccounts\Exceptions\SubscriptionPlanNotFoundException;
    use IntellivoidAccounts\Exceptions\SubscriptionPromotionNotFoundException;
    use IntellivoidAccounts\IntellivoidAccounts;
    use IntellivoidAccounts\Objects\Account;
    use IntellivoidAccounts\Objects\COA\Application;
    use IntellivoidAccounts\Objects\SubscriptionPlan;
    use IntellivoidAccounts\Objects\SubscriptionPromotion;

if(isset($_GET['action']))
    {
        if($_GET['action'] == 'process_transaction')
        {
            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                process_transaction();
            }
        }
    }

    function process_transaction()
    {
        // Get the required objects that has been defined in the memory
        /** @var IntellivoidAccounts $IntellivoidAccounts */
        $IntellivoidAccounts = DynamicalWeb::getMemoryObject('intellivoid_accounts');

        /** @var Application $Application */
        $Application = DynamicalWeb::getMemoryObject('application');

        /** @var Account $Account */
        $Account = DynamicalWeb::getMemoryObject('account');

        /** @var array $SubscriptionDetails */
        /** @noinspection PhpUnhandledExceptionInspection */
        $SubscriptionDetails = DynamicalWeb::getArray('subscription_details');

        /** @var SubscriptionPlan $SubscriptionPlan */
        $SubscriptionPlan = DynamicalWeb::getMemoryObject('subscription_plan');

        if(isset($_POST['confirm_password']) == false)
        {
            $_GET['action'] = 'exec_callback';
            $_GET['callback'] = '100';
            Actions::redirect(DynamicalWeb::getRoute('confirm_subscription_purchase', $_GET));
        }

        // Validate the password
        try
        {
            $IntellivoidAccounts->getAccountManager()->checkLogin(WEB_ACCOUNT_USERNAME, $_POST['confirm_password']);
        }
        catch (AccountNotFoundException $e)
        {
            Actions::redirect(DynamicalWeb::getRoute(
                'purchase_failure', array(
                    'error_type' => 'system_error',
                    'error' => 'account_not_found'
                )
            ));
        }
        catch (AccountSuspendedException $e)
        {
            Actions::redirect(DynamicalWeb::getRoute(
                'purchase_failure', array(
                    'error_type' => 'system_error',
                    'error' => 'account_suspended'
                )
            ));
        }
        catch (IncorrectLoginDetailsException $e)
        {
            $_GET['action'] = 'exec_callback';
            $_GET['callback'] = '101';
            Actions::redirect(DynamicalWeb::getRoute('confirm_subscription_purchase', $_GET));
        }
        catch(Exception $e)
        {
            $_GET['action'] = 'exec_callback';
            $_GET['callback'] = '100';
            Actions::redirect(DynamicalWeb::getRoute('confirm_subscription_purchase', $_GET));
        }

        // Check if the user already has a subscription with the Application
        try
        {
            $ApplicationSubscriptionPlans = $IntellivoidAccounts->getSubscriptionPlanManager()->getSubscriptionPlansByApplication(
                $Application->ID
            );
        }
        catch(Exception $e)
        {
            $_GET['action'] = 'exec_callback';
            $_GET['callback'] = '100';
            Actions::redirect(DynamicalWeb::getRoute('confirm_subscription_purchase', $_GET));
        }

        /** @var SubscriptionPlan $subscriptionPlanIlt */
        /** @var array $ApplicationSubscriptionPlans */
        foreach($ApplicationSubscriptionPlans as $subscriptionPlanIlt)
        {
            try
            {
                $Exists = $IntellivoidAccounts->getSubscriptionManager()->subscriptionPlanAssociatedWithAccount(
                    $Account->ID, $subscriptionPlanIlt->ID
                );

                if($Exists)
                {
                    $_GET['action'] = 'exec_callback';
                    $_GET['callback'] = '102';
                    Actions::redirect(DynamicalWeb::getRoute('confirm_subscription_purchase', $_GET));
                }
            }
            catch (Exception $e)
            {
                $_GET['action'] = 'exec_callback';
                $_GET['callback'] = '100';
                Actions::redirect(DynamicalWeb::getRoute('confirm_subscription_purchase', $_GET));
            }
        }

        $PromotionCode = "NONE";
        /** @noinspection PhpUnhandledExceptionInspection */
        if(DynamicalWeb::getBoolean('subscription_promotion_set') == true)
        {
            /** @var SubscriptionPromotion $Promotion */
            $Promotion = DynamicalWeb::getMemoryObject('subscription_promotion');
            $PromotionCode =  $Promotion->PromotionCode;
        }

        try
        {
            $IntellivoidAccounts->getSubscriptionManager()->startSubscription(
                $Account->ID, $Application->ID, $SubscriptionPlan->PlanName, $PromotionCode
            );
            Actions::redirect(DynamicalWeb::getRoute('purchase_success'));
        }
        catch (AccountLimitedException $e)
        {
            $_GET['action'] = 'exec_callback';
            $_GET['callback'] = '103';
            Actions::redirect(DynamicalWeb::getRoute('confirm_subscription_purchase', $_GET));
        }
        catch (AccountNotFoundException $e)
        {
            Actions::redirect(DynamicalWeb::getRoute(
                'purchase_failure', array(
                    'error_type' => 'system_error',
                    'error' => 'account_not_found'
                )
            ));
        }
        catch (ApplicationNotFoundException $e)
        {
            Actions::redirect(DynamicalWeb::getRoute(
                'purchase_failure', array(
                    'error_type' => 'system_error',
                    'error' => 'appliation_not_found'
                )
            ));
        }
        catch (InsufficientFundsException $e)
        {
            $_GET['action'] = 'exec_callback';
            $_GET['callback'] = '104';
            Actions::redirect(DynamicalWeb::getRoute('confirm_subscription_purchase', $_GET));
        }
        catch (InvalidAccountStatusException $e)
        {
            Actions::redirect(DynamicalWeb::getRoute(
                'purchase_failure', array(
                    'error_type' => 'system_error',
                    'error' => 'invalid_account_status'
                )
            ));
        }
        catch (InvalidEmailException $e)
        {
            Actions::redirect(DynamicalWeb::getRoute(
                'purchase_failure', array(
                    'error_type' => 'system_error',
                    'error' => 'invalid_email'
                )
            ));
        }
        catch (InvalidFundsValueException $e)
        {
            Actions::redirect(DynamicalWeb::getRoute(
                'purchase_failure', array(
                    'error_type' => 'system_error',
                    'error' => 'invalid_funds'
                )
            ));
        }
        catch (InvalidUsernameException $e)
        {
            Actions::redirect(DynamicalWeb::getRoute(
                'purchase_failure', array(
                    'error_type' => 'system_error',
                    'error' => 'invalid_username'
                )
            ));
        }
        catch (InvalidVendorException $e)
        {
            Actions::redirect(DynamicalWeb::getRoute(
                'purchase_failure', array(
                    'error_type' => 'system_error',
                    'error' => 'invalid_vendor'
                )
            ));
        }
        catch (SubscriptionNotFoundException $e)
        {
            Actions::redirect(DynamicalWeb::getRoute(
                'purchase_failure', array(
                    'error_type' => 'system_error',
                    'error' => 'subscription_not_found'
                )
            ));
        }
        catch (SubscriptionPlanNotFoundException $e)
        {
            Actions::redirect(DynamicalWeb::getRoute(
                'purchase_failure', array(
                    'error_type' => 'system_error',
                    'error' => 'subscription_plan_not_found'
                )
            ));
        }
        catch (SubscriptionPromotionNotFoundException $e)
        {
            Actions::redirect(DynamicalWeb::getRoute(
                'purchase_failure', array(
                    'error_type' => 'system_error',
                    'error' => 'subscription_promotion_not_found'
                )
            ));
        }
        catch(Exception $e)
        {
            Actions::redirect(DynamicalWeb::getRoute(
                'purchase_failure', array(
                    'error_type' => 'system_error',
                    'error' => 'unknown_exception'
                )
            ));
        }
    }