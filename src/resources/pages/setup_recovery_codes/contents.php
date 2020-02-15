<?PHP

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;

    HTML::importScript('check_sudo');
    HTML::importScript('check');
    HTML::importScript('confirm');
    HTML::importScript('setup');

    $Account = DynamicalWeb::getMemoryObject('account');
?>
<!doctype html>
<html lang="<?PHP HTML::print(APP_LANGUAGE_ISO_639); ?>">
    <head>
        <?PHP HTML::importSection('dashboard_headers'); ?>
        <title><?PHP HTML::print(TEXT_PAGE_TITLE); ?></title>
    </head>
    <body>
        <div class="container-scroller">
            <?PHP HTML::importSection("dashboard_navbar"); ?>
            <div class="container-fluid page-body-wrapper">
                <div class="main-panel container">
                    <div class="content-wrapper">
                        <?PHP HTML::importScript('callbacks'); ?>
                        <div class="row">
                            <div class="col-lg-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title"><?PHP HTML::print(TEXT_CARD_TITLE); ?></h4>
                                        <p class="card-description"><?PHP HTML::print(TEXT_CARD_DESCRIPTION); ?></p>
                                        <?PHP $RecoveryCodes = $Account->Configuration->VerificationMethods->RecoveryCodes->RecoveryCodes; ?>
                                        <div class="row border-top pt-3 mt-auto">
                                            <div class="col-2">
                                                <h6 class="font-weight-medium"><?PHP HTML::print($RecoveryCodes[0]); ?></h6>
                                            </div>
                                            <div class="col-2">
                                                <h6 class="font-weight-medium"><?PHP HTML::print($RecoveryCodes[1]); ?></h6>
                                            </div>
                                            <div class="col-2">
                                                <h6 class="font-weight-medium"><?PHP HTML::print($RecoveryCodes[2]); ?></h6>
                                            </div>
                                            <div class="col-2">
                                                <h6 class="font-weight-medium"><?PHP HTML::print($RecoveryCodes[3]); ?></h6>
                                            </div>
                                            <div class="col-2">
                                                <h6 class="font-weight-medium"><?PHP HTML::print($RecoveryCodes[4]); ?></h6>
                                            </div>
                                            <div class="col-2">
                                                <h6 class="font-weight-medium"><?PHP HTML::print($RecoveryCodes[5]); ?></h6>
                                            </div>
                                            <div class="col-2">
                                                <h6 class="font-weight-medium"><?PHP HTML::print($RecoveryCodes[6]); ?></h6>
                                            </div>
                                            <div class="col-2">
                                                <h6 class="font-weight-medium"><?PHP HTML::print($RecoveryCodes[7]); ?></h6>
                                            </div>
                                            <div class="col-2">
                                                <h6 class="font-weight-medium"><?PHP HTML::print($RecoveryCodes[8]); ?></h6>
                                            </div>
                                            <div class="col-2">
                                                <h6 class="font-weight-medium"><?PHP HTML::print($RecoveryCodes[9]); ?></h6>
                                            </div>
                                            <div class="col-2">
                                                <h6 class="font-weight-medium"><?PHP HTML::print($RecoveryCodes[10]); ?></h6>
                                            </div>
                                            <div class="col-2">
                                                <h6 class="font-weight-medium"><?PHP HTML::print($RecoveryCodes[11]); ?></h6>
                                            </div>
                                            <div class="col-2">
                                                <h6 class="font-weight-medium"><?PHP HTML::print($RecoveryCodes[12]); ?></h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button class="btn btn-success" data-toggle="modal" data-target="#confirm"><?PHP HTML::print(TEXT_CONFIRM_BUTTON); ?></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="confirm" tabindex="-1" role="dialog" aria-labelledby="confirm-label" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="confirm-label"><?PHP HTML::print(TEXT_CONFIRMATION_DIALOG_TITLE); ?></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">
                                                <i class="mdi mdi-close"></i>
                                            </span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p><?PHP HTML::print(TEXT_CONFIRMATION_DIALOG_BODY); ?></p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light" data-dismiss="modal"><?PHP HTML::print(TEXT_CONFIRMATION_DIALOG_CANCEL_BUTTON); ?></button>
                                        <button type="button" class="btn btn-success" onclick="location.href='<?PHP DynamicalWeb::getRoute('setup_recovery_codes', array('action' => 'confirm'), true); ?>';"><?PHP HTML::print(TEXT_CONFIRMATION_DIALOG_SUBMIT_BUTTON); ?></button>
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
    </body>
</html>
