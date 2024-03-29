<?php

    use DynamicalWeb\Actions;
    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\Runtime;
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
    use IntellivoidAccounts\IntellivoidAccounts;
    use IntellivoidAccounts\Objects\Account;
    use IntellivoidAccounts\Objects\COA\Application;
    use IntellivoidSubscriptionManager\IntellivoidSubscriptionManager;
    use IntellivoidSubscriptionManager\Objects\SubscriptionPlan;
    use IntellivoidSubscriptionManager\Objects\SubscriptionPromotion;

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

        /** @var SubscriptionPlan $SubscriptionPlan */
        $SubscriptionPlan = DynamicalWeb::getMemoryObject('subscription_plan');

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
            $ApplicationSubscriptionPlans = $SubscriptionManager->getPlanManager()->getSubscriptionPlansByApplication($Application->ID);
        }
        catch(Exception $e)
        {
            $_GET['action'] = 'exec_callback';
            $_GET['callback'] = '100';
            Actions::redirect(DynamicalWeb::getRoute('confirm_subscription_purchase', $_GET));
        }

        /** @var SubscriptionPlan $subscriptionPlanIlt */
        /** @noinspection PhpUndefinedVariableInspection */
        foreach($ApplicationSubscriptionPlans as $subscriptionPlanIlt)
        {
            try
            {
                $Exists = $SubscriptionManager->getSubscriptionManager()->subscriptionPlanAssociatedWithAccount(
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
            $IntellivoidAccounts->getAccountManager()->startSubscription(
                $SubscriptionManager, $Account->ID, $Application->ID, $SubscriptionPlan->PlanName, $PromotionCode
            );

            if(isset($_GET['redirect']))
            {
                if (filter_var($_GET['redirect'], FILTER_VALIDATE_URL) == true)
                {
                    Actions::redirect(DynamicalWeb::getRoute('purchase_success', array('redirect' => $_GET['redirect'])));
                }
            }

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
        } catch(Exception $e)
        {
            Actions::redirect(DynamicalWeb::getRoute(
                'purchase_failure', array(
                    'error_type' => 'system_error',
                    'error' => 'unknown_exception'
                )
            ));
        }
    }