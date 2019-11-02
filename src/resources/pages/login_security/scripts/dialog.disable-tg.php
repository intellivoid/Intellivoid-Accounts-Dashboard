<?PHP
    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
?>
<div class="modal fade" id="unlink-telegram" tabindex="-1" role="dialog" aria-labelledby="unlink-telegram-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="unlink-telegram-label">Unlink Telegram Account</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">
                        <i class="mdi mdi-close"></i>
                    </span>
                </button>
            </div>
            <div class="modal-body">
                <p>
                    Please confirm that you want to unlink your Telegram Account, you will
                    no longer receive Authentication Prompts, security notifications and
                    application notifications.
                </p>
            </div>
            <div class="modal-footer">
                <?PHP $Href = DynamicalWeb::getRoute('login_security', array('action' => 'unlink_telegram')); ?>
                <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" onclick="location.href='<?PHP HTML::print($Href); ?>';">Unlink</button>
            </div>
        </div>
    </div>
</div>