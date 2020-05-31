<?php

    use DynamicalWeb\Actions;
    use DynamicalWeb\DynamicalWeb;
    use IntellivoidAccounts\Abstracts\ApplicationAccessStatus;
    use IntellivoidAccounts\Abstracts\SearchMethods\ApplicationAccessSearchMethod;
    use IntellivoidAccounts\Exceptions\ApplicationAccessNotFoundException;
    use IntellivoidAccounts\IntellivoidAccounts;

    if(isset($_GET['action']))
    {
        if($_GET['action'] == 'revoke_access')
        {
            if(isset($_GET['access_id']))
            {
                revoke_access($_GET['access_id']);
            }
        }
    }

    function revoke_access(string $access_id)
    {
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
            $ApplicationAccess = $IntellivoidAccounts->getCrossOverAuthenticationManager()->getApplicationAccessManager()->getApplicationAccess(ApplicationAccessSearchMethod::byPublicId, $access_id);
        }
        catch (ApplicationAccessNotFoundException $e)
        {
            Actions::redirect(DynamicalWeb::getRoute('settings_authorized_apps', array('callback' => '100')));
        }
        catch(Exception $exception)
        {
            Actions::redirect(DynamicalWeb::getRoute('settings_authorized_apps', array('callback' => '101')));
        }

        /** @noinspection PhpUndefinedVariableInspection */
        if($ApplicationAccess->Status == ApplicationAccessStatus::Authorized)
        {
            $ApplicationAccess->Status = ApplicationAccessStatus::Unauthorized;
            $IntellivoidAccounts->getCrossOverAuthenticationManager()->getApplicationAccessManager()->updateApplicationAccess($ApplicationAccess);
            Actions::redirect(DynamicalWeb::getRoute('settings_authorized_apps', array('callback' => '102')));
        }

        Actions::redirect(DynamicalWeb::getRoute('settings_authorized_apps', array('callback' => '103')));
    }
