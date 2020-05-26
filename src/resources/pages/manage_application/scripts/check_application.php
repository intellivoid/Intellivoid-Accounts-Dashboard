<?php

    use DynamicalWeb\Actions;
    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\Runtime;
    use IntellivoidAccounts\Abstracts\SearchMethods\ApplicationSearchMethod;
    use IntellivoidAccounts\Exceptions\ApplicationNotFoundException;
    use IntellivoidAccounts\IntellivoidAccounts;

    Runtime::import('IntellivoidAccounts');

    if(isset($_GET['pub_id']) == false)
    {
        Actions::redirect(DynamicalWeb::getRoute('applications', array('callback' => '107')));
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
        $Application = $IntellivoidAccounts->getApplicationManager()->getApplication(ApplicationSearchMethod::byApplicationId, $_GET['pub_id']);
    }
    catch (ApplicationNotFoundException $e)
    {
        Actions::redirect(DynamicalWeb::getRoute('applications', array('callback' => '107')));
    }
    catch(Exception $exception)
    {
        Actions::redirect(DynamicalWeb::getRoute('applications', array('callback' => '100')));
    }

    if($Application->AccountID !== WEB_ACCOUNT_ID)
    {
        Actions::redirect(DynamicalWeb::getRoute('applications', array('callback' => '107')));
    }

    DynamicalWeb::setMemoryObject('application', $Application);