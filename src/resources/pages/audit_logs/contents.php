<?PHP

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use DynamicalWeb\Runtime;
    use IntellivoidAccounts\Abstracts\AuditEventType;
    use IntellivoidAccounts\IntellivoidAccounts;
    use IntellivoidAccounts\Objects\Account;
    use IntellivoidAccounts\Objects\AuditRecord;

    Runtime::import('IntellivoidAccounts');

    /** @var Account $Account */
    $Account = DynamicalWeb::getMemoryObject('account');
?>
<!doctype html>
<html lang="<?PHP HTML::print(APP_LANGUAGE_ISO_639); ?>">
    <head>
        <?PHP HTML::importSection('dashboard_headers'); ?>
        <link rel="stylesheet" href="/assets/vendors/iconfonts/flag-icon-css/css/flag-icon.min.css">
        <title><?PHP HTML::print(TEXT_PAGE_TITLE); ?></title>
    </head>
    <body>
        <div class="container-scroller">
            <?PHP HTML::importSection("dashboard_navbar"); ?>
            <div class="container-fluid page-body-wrapper">
                <div class="main-panel container">
                    <div class="content-wrapper">
                        <div class="row">
                            <div class="col-lg-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title"><?PHP HTML::print(TEXT_CARD_TITLE); ?></h4>
                                        <p class="card-description text-muted"><?PHP HTML::print(TEXT_CARD_DESCRIPTION); ?></p>
                                        <div class="wrapper mt-4">
                                            <?PHP
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
                                            $AuditRecords = $IntellivoidAccounts->getAuditLogManager()->getNewRecords(WEB_ACCOUNT_ID, 100);
                                            if(count($AuditRecords) > 0)
                                            {
                                                HTML::print("<ul class=\"bullet-line-list ml-4 pb-3\">", false);
                                                foreach($AuditRecords as $AuditRecord)
                                                {
                                                    $AuditRecordObject = AuditRecord::fromArray($AuditRecord);
                                                    $EventText = null;
                                                    $EventIcon = null;

                                                    switch($AuditRecordObject->EventType)
                                                    {
                                                        case AuditEventType::NewLoginDetected:
                                                            $EventText = TEXT_AUDIT_EVENT_NEW_LOGIN_DETECTED;
                                                            $EventIcon = "mdi mdi-shield text-success";
                                                            break;

                                                        case AuditEventType::PasswordUpdated:
                                                            $EventText = TEXT_AUDIT_EVENT_PASSWORD_UPDATE;
                                                            $EventIcon = "mdi mdi-key-change text-success";
                                                            break;

                                                        case AuditEventType::PersonalInformationUpdated:
                                                            $EventText = TEXT_AUDIT_EVENT_PERSONAL_INFORMATION_UPDATE;
                                                            $EventIcon = "mdi mdi-account text-success";
                                                            break;

                                                        case AuditEventType::EmailUpdated:
                                                            $EventText = TEXT_AUDIT_EVENT_EMAIL_CHANGED;
                                                            $EventIcon = "mdi mdi-email text-success";
                                                            break;

                                                        case AuditEventType::MobileVerificationEnabled:
                                                            $EventText = TEXT_AUDIT_EVENT_MOBILE_VERIFICATION_ENABLED;
                                                            $EventIcon = "mdi mdi-cellphone-iphone text-success";
                                                            break;

                                                        case AuditEventType::MobileVerificationDisabled:
                                                            $EventText = TEXT_AUDIT_EVENT_MOBILE_VERIFICATION_DISABLED;
                                                            $EventIcon = "mdi mdi-cellphone-iphone text-danger";
                                                            break;

                                                        case AuditEventType::RecoveryCodesEnabled:
                                                            $EventText = TEXT_AUDIT_EVENT_RECOVERY_CODES_ENABLED;
                                                            $EventIcon = "mdi mdi-refresh text-success";
                                                            break;

                                                        case AuditEventType::RecoveryCodesDisabled:
                                                            $EventText = TEXT_AUDIT_EVENT_RECOVERY_CODES_DISABLED;
                                                            $EventIcon = "mdi mdi-refresh text-danger";
                                                            break;

                                                        case AuditEventType::TelegramVerificationEnabled:
                                                            $EventText = TEXT_AUDIT_EVENT_TELEGRAM_VERIFICATION_ENABLED;
                                                            $EventIcon = "mdi mdi-telegram text-success";
                                                            break;

                                                        case AuditEventType::TelegramVerificationDisabled:
                                                            $EventText = TEXT_AUDIT_EVENT_TELEGRAM_VERIFICATION_DISABLED;
                                                            $EventIcon = "mdi mdi-telegram text-danger";
                                                            break;

                                                        case AuditEventType::ApplicationCreated:
                                                            $EventText = TEXT_AUDIT_EVENT_APPLICATION_CREATED;
                                                            $EventIcon = "mdi mdi-console text-success";
                                                            break;

                                                        case AuditEventType::NewLoginLocationDetected:
                                                            $EventText = TEXT_AUDIT_EVENT_NEW_LOGIN_LOCATION;
                                                            $EventIcon = "mdi mdi-map-marker text-success";
                                                            break;

                                                        default:
                                                            $EventText = TEXT_AUDIT_EVENT_UNKNOWN;
                                                            $EventIcon = "mdi mdi-help text-muted";
                                                            break;
                                                    }
                                                    $Timestamp = gmdate("j/m/y g:i a", $AuditRecordObject->Timestamp);

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
                                                ?>
                                                <div class="d-flex flex-column justify-content-center align-items-center"  style="height:50vh;">
                                                    <div class="p-2 my-flex-item">
                                                        <img src="/assets/images/sadboi.svg" class="img-fluid img-md" alt="No items icon"/>
                                                    </div>
                                                    <div class="p-2 my-flex-item">
                                                        <h6 class="text-muted"><?PHP HTML::print(TEXT_AUDIT_NO_ITEMS); ?></h6>
                                                    </div>
                                                </div>
                                                <?PHP
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?PHP HTML::importSection('dashboard_footer'); ?>
                </div>
            </div>
        </div>
        <?PHP HTML::importSection('dashboard_js'); ?>
        <script src="/assets/js/shared/tooltips.js"></script>
        <script src="/assets/js/shared/popover.js"></script>
    </body>
</html>
