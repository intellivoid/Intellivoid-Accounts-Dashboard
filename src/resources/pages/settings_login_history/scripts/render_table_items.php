<?php

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use IntellivoidAccounts\Abstracts\LoginStatus;
    use IntellivoidAccounts\Abstracts\SearchMethods\ApplicationSearchMethod;
    use IntellivoidAccounts\Abstracts\SearchMethods\KnownHostsSearchMethod;
    use IntellivoidAccounts\IntellivoidAccounts;
    use IntellivoidAccounts\Objects\KnownHost;
    use IntellivoidAccounts\Objects\UserLoginRecord;

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

    /** @var array $loginRecord */
    foreach(DynamicalWeb::getArray('search_results') as $loginRecord)
    {
        /** @var UserLoginRecord $loginRecord */
        $loginRecord = UserLoginRecord::fromArray($loginRecord);

        if(isset(DynamicalWeb::$globalObjects["host_" . $loginRecord->HostID]) == false)
        {
            $KnownHost = $IntellivoidAccounts->getKnownHostsManager()->getHost(KnownHostsSearchMethod::byId, $loginRecord->HostID);
            DynamicalWeb::setMemoryObject('host_' . $loginRecord->HostID, $KnownHost);
        }

        $Details = $loginRecord->UserAgent->Platform;
        $Details .= ' ' . $loginRecord->UserAgent->Browser;
        $Details .= ' ' . $loginRecord->UserAgent->Version;

        if($KnownHost->LocationData->CountryName == null)
        {
            $LocationDetails = "Unknown";
        }
        else
        {
            if(isset($KnownHost->LocationData->City))
            {
                $LocationDetails = $KnownHost->LocationData->City;
                $LocationDetails .= ' ' . $KnownHost->LocationData->CountryName;
            }
            else
            {
                $LocationDetails = $KnownHost->LocationData->CountryName;
            }

            if(isset($KnownHost->LocationData->ZipCode))
            {
                $LocationDetails .= ' (' . $KnownHost->LocationData->ZipCode . ')';
            }
        }

        $ApplicationBrand = "/assets/images/vendor.svg";

        if(isset(DynamicalWeb::$globalObjects[$loginRecord->Origin]))
        {
            if(DynamicalWeb::$globalObjects[$loginRecord->Origin] !== null)
            {
                $ApplicationBrand = DynamicalWeb::getRoute('application_icon',
                    array('app_id' => DynamicalWeb::$globalObjects[$loginRecord->Origin]->PublicAppId, 'resource' => 'normal')
                );
            }
        }
        else
        {
            try
            {
                $Application = $IntellivoidAccounts->getApplicationManager()->getApplication(
                        ApplicationSearchMethod::byName, $loginRecord->Origin
                );
            }
            catch(Exception $e)
            {
                $Application = null;
                unset($e);
            }

            if($Application == null)
            {
                DynamicalWeb::$globalObjects[$loginRecord->Origin] = null;
            }
            else
            {
                DynamicalWeb::$globalObjects[$loginRecord->Origin] = $Application;
                $ApplicationBrand = DynamicalWeb::getRoute('application_icon',
                    array('app_id' => DynamicalWeb::$globalObjects[$loginRecord->Origin]->PublicAppId, 'resource' => 'normal')
                );
            }
        }

        ?>
        <tr>
            <td class="d-flex flex-row">
                <div data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" data-original-title="<?PHP HTML::print($loginRecord->Origin); ?>" class="avatar pull-up">
                    <img class="media-object rounded-circle" src="<?PHP HTML::print($ApplicationBrand); ?>" alt="<?PHP HTML::print($loginRecord->Origin); ?>" height="30" width="30">
                </div>
                <span class="my-auto d-none d-lg-inline"><?PHP HTML::print($loginRecord->Origin); ?></span>
            </td>
            <td class="flex-row">
                <?PHP
                    switch($loginRecord->Status)
                    {
                        case LoginStatus::Successful:
                            HTML::print("<i class=\"fa fa-circle font-small-3 text-success mr-50 d-none d-lg-inline\"></i>", false);
                            HTML::print("<span>", false);
                            HTML::print(TEXT_LOGIN_STATUS_SUCCESS);
                            HTML::print("</span>", false);
                            break;

                        case LoginStatus::IncorrectCredentials:
                            HTML::print("<i class=\"fa fa-circle font-small-3 text-warning mr-50 d-none d-lg-inline\"></i>", false);
                            HTML::print("<span>", false);
                            HTML::print(TEXT_LOGIN_STATUS_INCORRECT_CREDENTIALS);
                            HTML::print("</span>", false);
                            break;

                        case LoginStatus::VerificationFailed:
                            HTML::print("<i class=\"fa fa-circle font-small-3 text-warning mr-50 d-none d-lg-inline\"></i>", false);
                            HTML::print("<span>", false);
                            HTML::print(TEXT_LOGIN_STATUS_VERIFICATION_FAILED);
                            HTML::print("</span>", false);
                            break;

                        case LoginStatus::UntrustedIpBlocked:
                            HTML::print("<i class=\"fa fa-circle font-small-3 text-danger mr-50 d-none d-lg-inline\"></i>", false);
                            HTML::print("<span>", false);
                            HTML::print(TEXT_LOGIN_STATUS_UNTRUSTED_IP_BLOCKED);
                            HTML::print("</span>", false);
                            break;

                        case LoginStatus::BlockedSuspiciousActivities:
                            HTML::print("<i class=\"fa fa-circle font-small-3 text-danger mr-50 d-none d-lg-inline\"></i>", false);
                            HTML::print("<span>", false);
                            HTML::print(TEXT_LOGIN_STATUS_SUSPICIOUS_ACTIVITY_BLOCKED);
                            HTML::print("</span>", false);
                            break;

                        default:
                            HTML::print("<i class=\"fa fa-circle font-small-3 text-info mr-50 d-none d-lg-inline\"></i>", false);
                            HTML::print("<span>", false);
                            HTML::print(TEXT_LOGIN_STATUS_UNKNOWN);
                            HTML::print("</span>", false);
                            break;
                    }
                ?>
            </td>
            <td class="d-flex flex-row" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="<?PHP HTML::print($Details); ?>">
                <?PHP
                    switch($loginRecord->UserAgent->Platform)
                    {
                        case 'Chrome OS':
                        case 'Macintosh':
                        case 'Linux':
                        case 'Windows':
                            HTML::print("<img alt=\"laptop\" class=\"d-none d-lg-inline\" height=\"30\" width=\"30\" src=\"/assets/images/devices/laptop.svg\"/>", false);
                            break;

                        case 'iPad':
                        case 'iPod Touch':
                        case 'iPad / iPod Touch':
                        case 'Windows Phone OS':
                        case 'Kindle':
                        case 'Kindle Fire':
                        case 'BlackBerry':
                        case 'Playbook':
                        case 'Tizen':
                        case 'iPhone':
                        case 'Android':
                            HTML::print("<img alt=\"smartphone\" class=\"d-none d-lg-inline\" height=\"30\" width=\"30\" src=\"/assets/images/devices/smartphone.svg\"/>", false);
                            break;

                        default:
                            HTML::print("<img alt=\"desktop\" class=\"d-none d-lg-inline\" height=\"30\" width=\"30\" src=\"/assets/images/devices/desktop.svg\"/>", false);
                            break;
                    }
                ?>
                <span class="my-auto"><?PHP HTML::print($loginRecord->UserAgent->Browser); ?></span>
            </td>
            <td data-toggle="tooltip" data-placement="bottom" title="" data-original-title="<?PHP HTML::print($LocationDetails); ?>">
                <?PHP
                    if($KnownHost->LocationData->CountryName == null)
                    {
                        HTML::print("<i class=\"feather icon-help-circle\"></i>", false);
                    }
                    else
                    {
                        $CountryCode = strtolower($KnownHost->LocationData->CountryCode);
                        HTML::print("<i class=\"flag-icon flag-icon-$CountryCode\" title=\"$CountryCode\"></i>", false);
                    }
                ?>
                <span >
                    <?PHP
                        /** @var KnownHost $KnowHost */
                        $KnowHost = DynamicalWeb::getMemoryObject('host_' . $loginRecord->HostID);
                        HTML::print($KnownHost->IpAddress);
                    ?>
                </span>
            </td>
            <td> <?PHP HTML::print(gmdate("j/m/Y, g:i a", $loginRecord->Timestamp)); ?> </td>
        </tr>
        <?PHP
    }