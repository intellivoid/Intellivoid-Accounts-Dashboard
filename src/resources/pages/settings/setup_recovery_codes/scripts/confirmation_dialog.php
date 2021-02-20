<?php
    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
?>
<div class="modal fade text-left" id="confirm" tabindex="-1" role="dialog" aria-labelledby="confirm-label" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="confirm-label"><?PHP HTML::print(TEXT_CONFIRMATION_DIALOG_TITLE); ?></h4>
            </div>
            <div class="modal-body">
                <?PHP HTML::print(TEXT_CONFIRMATION_DIALOG_BODY); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal"><?PHP HTML::print(TEXT_CONFIRMATION_DIALOG_CANCEL_BUTTON); ?></button>
                <button type="button" class="btn btn-primary" onclick="location.href='<?PHP DynamicalWeb::getRoute('settings_setup_recovery_codes', array('action' => 'confirm'), true); ?>';">
                    <?PHP HTML::print(TEXT_CONFIRMATION_DIALOG_SUBMIT_BUTTON); ?>
                </button>
            </div>
        </div>
    </div>
</div>