<?PHP
    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
?>
<div class="modal fade" id="disable-rc" tabindex="-1" role="dialog" aria-labelledby="disable-rc-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="disable-rc-label">Disable Recovery Codes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">
                        <i class="mdi mdi-close"></i>
                    </span>
                </button>
            </div>
            <div class="modal-body">
                <p>
                    Please confirm that you want to disable recovery codes. Your old recovery
                    codes will become invalid and you will  no longer be prompted for a
                    recovery code when trying to verify  your login
                </p>
            </div>
            <div class="modal-footer">
                <?PHP $Href = DynamicalWeb::getRoute('login_security', array('action' => 'disable_rc')); ?>
                <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" onclick="location.href='<?PHP HTML::print($Href); ?>';">Disable</button>
            </div>
        </div>
    </div>
</div>