<?php

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use IntellivoidAccounts\Abstracts\LoginStatus;
    use IntellivoidAccounts\Abstracts\SearchMethods\KnownHostsSearchMethod;
    use IntellivoidAccounts\Abstracts\SearchMethods\LoginRecordMultiSearchMethod;
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

        ?>
        <tr>
            <td>
                <?PHP HTML::print($loginRecord->Origin); ?>
            </td>
            <td data-toggle="tooltip" data-placement="bottom" title="" data-original-title="<?PHP HTML::print($Details); ?>">
                <?PHP
                    switch($loginRecord->UserAgent->Platform)
                    {
                        case 'Chrome OS':
                        case 'Macintosh':
                        case 'Linux':
                        case 'Windows':
                            HTML::print("<img src=\"/assets/images/devices/laptop.svg\"/>", false);
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
                            HTML::print("<img src=\"/assets/images/devices/smartphone.svg\"/>", false);
                            break;

                        default:
                            HTML::print("<img src=\"/assets/images/devices/desktop.svg\"/>", false);
                            break;
                    }
                    HTML::print($loginRecord->UserAgent->Browser);
                ?>
            </td>
            <td data-toggle="tooltip" data-placement="bottom" title="" data-original-title="<?PHP HTML::print($LocationDetails); ?>">
                <?PHP
                    if($KnownHost->LocationData->CountryName == null)
                    {
                        HTML::print("<i class=\"mdi mdi-help\"></i>", false);
                    }
                    else
                    {
                        $CountryCode = strtolower($KnownHost->LocationData->CountryCode);
                        HTML::print("<i class=\"flag-icon flag-icon-$CountryCode\" title=\"$CountryCode\"></i>", false);
                    }
                ?>
                <span class="pl-1">
                    <?PHP
                    /** @var KnownHost $KnowHost */
                    $KnowHost = DynamicalWeb::getMemoryObject('host_' . $loginRecord->HostID);
                    HTML::print($KnownHost->IpAddress);
                    ?>
                </span>

            </td>

            <td>
            <?PHP
                switch($loginRecord->Status)
                {
                    case LoginStatus::Successful:
                        HTML::print("<div class=\"badge badge-success\">", false);
                        HTML::print("Successful");
                        HTML::print("</div>", false);
                        break;

                    case LoginStatus::IncorrectCredentials:
                        HTML::print("<div class=\"badge badge-warning\">", false);
                        HTML::print("Incorrect Credentials");
                        HTML::print("</div>", false);
                        break;

                    case LoginStatus::VerificationFailed:
                        HTML::print("<div class=\"badge badge-warning\">", false);
                        HTML::print("Verification Failed");
                        HTML::print("</div>", false);
                        break;

                    case LoginStatus::UntrustedIpBlocked:
                        HTML::print("<div class=\"badge badge-danger\">", false);
                        HTML::print("Untrusted IP Blocked");
                        HTML::print("</div>", false);
                        break;

                    case LoginStatus::BlockedSuspiciousActivities:
                        HTML::print("<div class=\"badge badge-danger\">", false);
                        HTML::print("Suspicious Activity Blocked");
                        HTML::print("</div>", false);
                        break;

                    default:
                        HTML::print("<div class=\"badge badge-info\">", false);
                        HTML::print("Unknown");
                        HTML::print("</div>", false);
                        break;
                }
            ?>
            </td>

            <td> <?PHP HTML::print(gmdate("j/m/Y, g:i a", $loginRecord->Timestamp)); ?> </td>
        </tr>
        <?PHP
    }