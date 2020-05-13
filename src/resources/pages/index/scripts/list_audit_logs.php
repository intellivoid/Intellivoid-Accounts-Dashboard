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
        HTML::print("<ul class=\"activity-timeline timeline-left list-unstyled\">", false);
        foreach($AuditRecords as $AuditRecord)
        {
            $AuditRecordObject = AuditRecord::fromArray($AuditRecord);
            $EventText = null;
            $EventIcon = null;
            $EventClass = null;

            switch($AuditRecordObject->EventType)
            {
                case AuditEventType::NewLoginDetected:
                    $EventText = TEXT_AUDIT_EVENT_NEW_LOGIN_DETECTED;
                    $EventIcon = "feather icon-shield";
                    $EventClass = "bg-primary";
                    break;

                case AuditEventType::PasswordUpdated:
                    $EventText = TEXT_AUDIT_EVENT_PASSWORD_UPDATE;
                    $EventIcon = "feather icon-unlock";
                    $EventClass = "bg-primary";
                    break;

                case AuditEventType::PersonalInformationUpdated:
                    $EventText = TEXT_AUDIT_EVENT_PERSONAL_INFORMATION_UPDATE;
                    $EventIcon = "feather icon-user";
                    $EventClass = "bg-primary";
                    break;

                case AuditEventType::EmailUpdated:
                    $EventText = TEXT_AUDIT_EVENT_EMAIL_CHANGED;
                    $EventIcon = "feather icon-mail";
                    $EventClass = "bg-primary";
                    break;

                case AuditEventType::MobileVerificationEnabled:
                    $EventText = TEXT_AUDIT_EVENT_MOBILE_VERIFICATION_ENABLED;
                    $EventIcon = "feather icon-smartphone";
                    $EventClass = "bg-success";
                    break;

                case AuditEventType::MobileVerificationDisabled:
                    $EventText = TEXT_AUDIT_EVENT_MOBILE_VERIFICATION_DISABLED;
                    $EventIcon = "feather icon-smartphone";
                    $EventClass = "bg-danger";
                    break;

                case AuditEventType::RecoveryCodesEnabled:
                    $EventText = TEXT_AUDIT_EVENT_RECOVERY_CODES_ENABLED;
                    $EventIcon = "feather icon-rotate-ccw";
                    $EventClass = "bg-success";
                    break;

                case AuditEventType::RecoveryCodesDisabled:
                    $EventText = TEXT_AUDIT_EVENT_RECOVERY_CODES_DISABLED;
                    $EventIcon = "feather icon-rotate-ccw";
                    $EventClass = "bg-danger";
                    break;

                case AuditEventType::TelegramVerificationEnabled:
                    $EventText = TEXT_AUDIT_EVENT_TELEGRAM_VERIFICATION_ENABLED;
                    $EventIcon = "feather icon-smartphone";
                    $EventClass = "bg-success";
                    break;

                case AuditEventType::TelegramVerificationDisabled:
                    $EventText = TEXT_AUDIT_EVENT_TELEGRAM_VERIFICATION_DISABLED;
                    $EventIcon = "feather icon-smartphone";
                    $EventClass = "bg-danger";
                    break;

                case AuditEventType::ApplicationCreated:
                    $EventText = TEXT_AUDIT_EVENT_APPLICATION_CREATED;
                    $EventIcon = "feather icon-layers";
                    $EventClass = "bg-primary";
                    break;

                case AuditEventType::NewLoginLocationDetected:
                    $EventText = TEXT_AUDIT_EVENT_NEW_LOGIN_LOCATION;
                    $EventIcon = "feather icon-map-pin";
                    $EventClass = "bg-warning";
                    break;

                default:
                    $EventText = TEXT_AUDIT_EVENT_UNKNOWN;
                    $EventIcon = "feather icon-help-circle";
                    $EventClass = "bg-primary";
                    break;
            }
            $Timestamp = gmdate("j/m/y g:i a", $AuditRecordObject->Timestamp)

            ?>
            <li>
                <div class="timeline-icon <?PHP HTML::print($EventClass); ?>">
                    <i class="<?PHP HTML::print($EventIcon); ?> font-medium-1 align-middle"></i>
                </div>
                <div class="timeline-info">
                    <p class="mb-0"><?PHP HTML::print($EventText); ?></p>
                </div>
                <small class="text-muted"><?PHP HTML::print($Timestamp); ?></small>
            </li>
            <?PHP
        }
        HTML::print("</ul>", false);
    }
    else
    {
        ?>
        <div class="d-flex flex-column justify-content-center align-items-center"  style="height:50vh;">
            <div class="my-flex-item">
                <img src="/assets/images/sadboi.svg" class="img-fluid img-md" alt="No items icon" width="48" height="48"/>
            </div>
            <div class="pt-2 my-flex-item">
                <h6 class="text-muted"><?PHP HTML::print(TEXT_NO_ITEMS); ?></h6>
            </div>
        </div>
        <?PHP
    }