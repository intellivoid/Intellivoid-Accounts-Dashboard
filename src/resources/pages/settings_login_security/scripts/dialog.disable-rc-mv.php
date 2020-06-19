<?PHP
    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
?>
<div class="modal fade text-left" id="disable-rc-mv" tabindex="-1" role="dialog" aria-labelledby="disable-rc-mv-label" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="disable-rc-mv-label"><?PHP HTML::print(TEXT_DISABLE_RC_MV_DIALOG_TITLE); ?></h4>
            </div>
            <div class="modal-body">
                <?PHP HTML::print(TEXT_DISABLE_RC_MV_DIALOG_BODY); ?>
            </div>
            <div class="modal-footer">
                <?PHP $Href = DynamicalWeb::getRoute('settings_login_security', array('action' => 'disable_rc')); ?>
                <button type="button" class="btn btn-light" data-dismiss="modal"><?PHP HTML::print(TEXT_DISABLE_RC_MV_DIALOG_CANCEL_BUTTON); ?></button>
                <button type="button" class="btn btn-danger" onclick="location.href='<?PHP HTML::print($Href); ?>';"><?PHP HTML::print(TEXT_DISABLE_RC_MV_DIALOG_DISABLE_BUTTON); ?></button>
            </div>
        </div>
    </div>
</div>