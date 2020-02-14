<?php
    use DynamicalWeb\HTML;
    use DynamicalWeb\DynamicalWeb;
?>
<div class="modal fade" id="disable-mv" tabindex="-1" role="dialog" aria-labelledby="disable-mv-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="disable-mv-label"<?PHP HTML::print(TEXT_DISABLE_MV_DIALOG_TITLE); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">
                        <i class="mdi mdi-close"></i>
                    </span>
                </button>
            </div>
            <div class="modal-body">
                <p><?PHP HTML::print(TEXT_DISABLE_MV_DIALOG_BODY); ?></p>
            </div>
            <div class="modal-footer">
                <?PHP $Href = DynamicalWeb::getRoute('login_security', array('action' => 'disable_mv')); ?>
                <button type="button" class="btn btn-light" data-dismiss="modal"><?PHP HTML::print(TEXT_DISABLE_MV_DIALOG_CANCEL_BUTTON); ?></button>
                <button type="button" class="btn btn-danger" onclick="location.href='<?PHP HTML::print($Href); ?>';"><?PHP HTML::print(TEXT_DISABLE_MV_DIALOG_DISABLE_BUTTON); ?></button>
            </div>
        </div>
    </div>
</div>