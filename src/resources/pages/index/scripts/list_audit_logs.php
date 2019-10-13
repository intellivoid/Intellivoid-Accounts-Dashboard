<?php

    // Define the important parts
    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use DynamicalWeb\Runtime;
use IntellivoidAccounts\Abstracts\AuditEventType;
use IntellivoidAccounts\IntellivoidAccounts;
    use IntellivoidAccounts\Objects\AuditRecord;

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

    $AuditRecords = $IntellivoidAccounts->getAuditLogManager()->getNewRecords(WEB_ACCOUNT_ID, 7);

    if(count($AuditRecords) > 0)
    {
        HTML::print("<ul class=\"bullet-line-list pb-3\">", false);
        foreach($AuditRecords as $AuditRecord)
        {
            $AuditRecordObject = AuditRecord::fromArray($AuditRecord);
            $EventText = null;
            $EventIcon = null;

            switch($AuditRecordObject->EventType)
            {
                case AuditEventType::NewLoginDetected:
                    $EventText = "New login detected";
                    $EventIcon = "mdi mdi-shield text-success";
                    break;

                case AuditEventType::PasswordUpdated:
                    $EventText = "Password Updated";
                    $EventIcon = "mdi mdi-key-change text-success";
                    break;

                case AuditEventType::PersonalInformationUpdated:
                    $EventText = "Personal Information Updated";
                    $EventIcon = "mdi mdi-account text-success";
                    break;

                case AuditEventType::EmailUpdated:
                    $EventText = "Email Changed";
                    $EventIcon = "mdi mdi-email text-success";
                    break;

                case AuditEventType::MobileVerificationEnabled:
                    $EventText = "Mobile Verification Enabled";
                    $EventIcon = "mdi mdi-cellphone-iphone text-success";
                    break;

                case AuditEventType::MobileVerificationDisabled:
                    $EventText = "Mobile Verification Disabled";
                    $EventIcon = "mdi mdi-cellphone-iphone text-danger";
                    break;

                case AuditEventType::RecoveryCodesEnabled:
                    $EventText = "Recovery Codes Enabled";
                    $EventIcon = "mdi mdi-refresh text-success";
                    break;

                case AuditEventType::RecoveryCodesDisabled:
                    $EventText = "Recovery Codes Disabled";
                    $EventIcon = "mdi mdi-refresh text-danger";
                    break;

                case AuditEventType::TelegramVerificationEnabled:
                    $EventText = "Telegram Verification Enabled";
                    $EventIcon = "mdi mdi-telegram text-success";
                    break;

                case AuditEventType::TelegramVerificationDisabled:
                    $EventText = "Telegram Verification Disabled";
                    $EventIcon = "mdi mdi-telegram text-danger";
                    break;

                case AuditEventType::ApplicationCreated:
                    $EventText = "Application Created";
                    $EventIcon = "mdi mdi-console text-success";
                    break;

                case AuditEventType::NewLoginLocationDetected:
                    $EventText = "New Login Location Detected";
                    $EventIcon = "mdi mdi-map-marker text-success";
                    break;

                default:
                    $EventText = "Unknown";
                    $EventIcon = "mdi mdi-help text-muted";
                    break;
            }
            $Timestamp = gmdate("j/m/y g:i a", $AuditRecordObject->Timestamp)

            ?>
            <li>
                <div class="d-flex align-items-center justify-content-between pb-2">
                    <div class="d-flex">
                        <div class="ml-3">
                            <p class="mb-0 pb-2"><?PHP HTML::print($EventText); ?></p>
                            <i class="<?PHP HTML::print($EventIcon); ?>"></i>
                            <small class="text-muted"> <?PHP HTML::print($Timestamp); ?> </small>
                        </div>
                    </div>
                </div>
            </li>
            <?PHP
        }
        HTML::print("</ul>", false);
    }
    else
    {
        HTML::print("No Items");
    }