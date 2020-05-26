<?php

    use DynamicalWeb\Actions;
    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\Runtime;
    use IntellivoidAccounts\Abstracts\AccountRequestPermissions;
    use IntellivoidAccounts\Abstracts\AuditEventType;
    use IntellivoidAccounts\Abstracts\AuthenticationMode;
    use IntellivoidAccounts\Exceptions\ApplicationAlreadyExistsException;
    use IntellivoidAccounts\Exceptions\InvalidApplicationNameException;
    use IntellivoidAccounts\Exceptions\InvalidRequestPermissionException;
    use IntellivoidAccounts\IntellivoidAccounts;

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

    /**
     * If the
     *
     * @param string $param
     * @return bool
     */
    function is_checked(string $param): bool
    {
        if(isset($_POST[$param]))
        {
            if($_POST[$param] == 'on')
            {
                return true;
            }
        }

        return false;
    }

    if(isset($_POST['application_name']) == false)
    {
        Actions::redirect(DynamicalWeb::getRoute('manage_applications', array('callback' => '100', 'param' => 'application_name')));
    }

    if(isset($_POST['authentication_type']) == false)
    {
        Actions::redirect(DynamicalWeb::getRoute('manage_applications', array('callback' => '100', 'param' => 'authentication_type')));
    }

    $AuthenticationType = null;

    switch($_POST['authentication_type'])
    {
        case 'redirect':
            $AuthenticationType = AuthenticationMode::Redirect;
            break;

        case 'placeholder':
            $AuthenticationType = AuthenticationMode::ApplicationPlaceholder;
            break;

        case 'code':
            $AuthenticationType = AuthenticationMode::Code;
            break;

        default:
            Actions::redirect(DynamicalWeb::getRoute('manage_applications', array('callback' => '103')));
    }

    $Permissions = [];

    if(is_checked('perm_view_personal_information'))
    {
        $Permissions[] = AccountRequestPermissions::ReadPersonalInformation;
    }

    if(is_checked('perm_telegram_notifications'))
    {
        $Permissions[] = AccountRequestPermissions::TelegramNotifications;
    }

    if(is_checked('perm_view_email_address'))
    {
        $Permissions[] = AccountRequestPermissions::ViewEmailAddress;
    }



    try
    {
        $TotalRecords = count($IntellivoidAccounts->getApplicationManager()->getRecords(WEB_ACCOUNT_ID));

        if($TotalRecords == 20)
        {
            Actions::redirect(DynamicalWeb::getRoute('manage_applications', array('callback' => '109')));
        }

        if($TotalRecords > 20)
        {
            Actions::redirect(DynamicalWeb::getRoute('manage_applications', array('callback' => '109')));
        }

        $IntellivoidAccounts->getApplicationManager()->registerApplication(
            $_POST['application_name'], WEB_ACCOUNT_ID, $AuthenticationType, $Permissions
        );
        $IntellivoidAccounts->getAuditLogManager()->logEvent(WEB_ACCOUNT_ID, AuditEventType::ApplicationCreated);
        Actions::redirect(DynamicalWeb::getRoute('manage_applications', array('callback' => '106')));
    }
    catch (ApplicationAlreadyExistsException $e)
    {
        Actions::redirect(DynamicalWeb::getRoute('manage_applications', array('callback' => '104')));
    }
    catch (InvalidApplicationNameException $e)
    {
        Actions::redirect(DynamicalWeb::getRoute('manage_applications', array('callback' => '102')));
    }
    catch (InvalidRequestPermissionException $e)
    {
        Actions::redirect(DynamicalWeb::getRoute('manage_applications', array('callback' => '105')));
    }
    catch(Exception $e)
    {
        Actions::redirect(DynamicalWeb::getRoute('manage_applications', array('callback' => '100')));
    }